<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SubmissionController extends Controller
{
    public function store($form_slug, Request $request)
    {
        $form = Form::where('slug', $form_slug)->firstOrFail();

        if (!$form->accept_submissions) {
            return response()->view('submissions.closed', [], 403);
        }

        $fields = $form->fields;

        $rules = $fields->pluck('rules', 'slug')->toArray();

        try {
            $request->validate($rules);
        } catch (ValidationException $exception) {
            return response()->view('submissions.errors', ['messages' => $exception->validator->errors()], 422);
        }

        $isSpam = false;

        $emailBlacklist = config('spam.email_blacklist');

        if ($emailBlacklist) {
            $emailBlacklist = explode(',', $emailBlacklist);

            foreach ($fields as $field) {
                if (!Str::contains($field->rules, 'email')) {
                    continue;
                }

                $value = $request->get($field->slug);

                if (!$value) {
                    continue;
                }

                foreach ($emailBlacklist as $emailSuffix) {
                    if (Str::endsWith($value, ".$emailSuffix") || Str::endsWith($value, "@$emailSuffix")) {
                        $isSpam = true;
                        break 2;
                    }
                }
            }
        }

        $flagAllUrls = config('spam.flag_all_urls');
        $spamWords = config('spam.words_blacklist');

        if ($spamWords) {
            $spamWords = implode('|', array_map(function ($word) {
                return preg_quote($word, '~');
            }, explode(',', $spamWords)));
        }

        if ($flagAllUrls || $spamWords) {
            foreach ($fields as $field) {
                $value = $request->get($field->slug);

                if ($spamWords && preg_match("~\b$spamWords\b~", $value) === 1) {
                    $isSpam = true;
                    break;
                }

                if ($flagAllUrls && preg_match_all('~https?://([^ /]+)[ /$]~', $value, $matches) > 0) {
                    $trustedTLDs = config('spam.trusted_tlds');

                    foreach ($matches[1] as $url) {
                        if ($trustedTLDs) {
                            foreach (explode(',', $trustedTLDs) as $tld) {
                                if ($url === $tld || Str::endsWith($url, ".$tld")) {
                                    continue 2;
                                }
                            }
                        }

                        $isSpam = true;
                        break 2;
                    }
                }
            }
        }

        DB::beginTransaction();

        $submission = new Submission;
        $submission->is_spam = $isSpam;
        $submission->user_ip = $request->ip();
        $submission->user_agent = substr((string)$request->server('HTTP_USER_AGENT'), 0, 255);

        $referer = $request->server('HTTP_REFERER');
        $submission->user_referer = $referer ? substr($referer, 0, 255) : null;

        $form->submissions()->save($submission);

        foreach ($fields as $field) {
            $value = $request->get($field->slug, null);

            // Do not store null or non-given values
            if (is_null($value)) {
                continue;
            }

            $submission->fields()->save($field, [
                'value' => $value,
            ]);
        }

        DB::commit();

        if (!is_null($form->send_email_to) && (!$isSpam || config('send_notification_for_spam'))) {
            $send_to = explode(',', $form->send_email_to);

            foreach ($send_to as $email) {
                Mail::send('emails.notification', [
                    'submission' => $submission,
                ], function (Message $message) use ($email, $form) {
                    if ($form->owner_email) {
                        $message->from($form->owner_email, $form->owner_name);
                    }

                    $message->to($email);

                    $message->subject(trans('submission.heading.new_submission_on', ['form' => $form->title]));
                });
            }
        }

        /**
         * This var will hold the email confirmation status
         * null: Nothing happened about confirmation
         * true: Email sent
         * false: Tried to send email but error occurred
         */
        $email_sent_successfully = null;

        if (!is_null($form->confirmation_message) && (!$isSpam || config('send_confirmation_for_spam'))) {
            $email_sent_successfully = false; // From now defaults to false

            $email_field = $form->fields()->where('slug', $form->confirmation_email_field)->first();

            if (is_null($email_field)) {
                logger()->error('Confirmation email not sent : Invalid field "' . $form->confirmation_email_field . '" for form "' . $form->slug . '"');
            } else {
                $email = $submission->field($email_field)->pivot->value;

                $email_validator = Validator::make(
                    ['email' => $email],
                    ['email' => 'required|email']
                );

                if ($email_validator->fails()) {
                    logger()->error('Confirmation email not sent : Invalid email address "' . $email . '" in field "' . $email_field->slug . '" of submission ' . $submission->id . ' on form "' . $form->slug . '"');
                } else {
                    $parsedown = new \Parsedown();

                    $html_message = $parsedown->text($form->confirmation_message);

                    $html_message = preg_replace_callback('/:([0-9a-z_-]+)\b/i', function ($matches) use ($submission) {
                        $field = $submission->fields->where('slug', $matches[1])->first();

                        if (!is_null($field)) {
                            return e($field->pivot->value);
                        }

                        return ':' . $matches[1];
                    }, $html_message);

                    Mail::send('emails.confirmation', [
                        // Cannot call it $message because it conflicts with a Illuminate\Mail\Message object
                        'html_message' => $html_message,
                        'submission' => $submission,
                    ], function (Message $message) use ($email, $form) {
                        if ($form->owner_email) {
                            $message->from($form->owner_email, $form->owner_name);
                        }

                        $message->to($email);

                        $message->subject(trans('submission.heading.submitted'));
                    });

                    $email_sent_successfully = true;
                }
            }
        }

        // Redirect the user to the configured url, but not if an error occurred
        if ($email_sent_successfully !== false && !is_null($form->redirect_to_url)) {
            return redirect($form->redirect_to_url);
        }

        return response()->view('submissions.submitted', [
            'email_sent_successfully' => $email_sent_successfully,
        ], 201);
    }
}
