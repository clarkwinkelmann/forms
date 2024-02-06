<?php

namespace App\Console\Commands;

use App\Models\Form;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class SendSummary extends Command
{
    protected $signature = 'forms:summary {--period=1 week ago : The start of the period to notify for} {--to= : Emails separated by a comma that should receive the summary} {--forms= : Form slugs to include, all if skipped} {--only-to-owners : Only send information about forms where the email is listed as notified. The list of emails can be skipped when this option is used to send to everyone} {--send-if-empty : Send an email even if there was nothing}';
    protected $description = 'Send an email summary of the submissions in a given period';

    public function handle()
    {
        $to = $this->option('to') ? explode(',', $this->option('to')) : null;
        $since = Carbon::parse($this->option('period'));

        $formsQuery = Form::query()->with([
            'submissions' => function ($builder) use ($since) {
                $builder->where('created_at', '>=', $since);
            },
        ]);

        if (!$this->option('only-to-owners')) {
            if (!$to) {
                $this->error('You must provide --to and/or --only-to-owners options to the command. Aborting.');
                return;
            }

            $allForms = $formsQuery->get()->all();

            foreach ($to as $email) {
                $this->sendToUser($email, $allForms, $since);
            }
        }

        $formsPerEmail = [];

        $formsQuery->whereNotNull('send_email_to')->each(function (Form $form) use ($to, &$formsPerEmail) {
            $emails = explode(',', $form->send_email_to);

            if ($to) {
                $emails = array_intersect($emails, $to);
            }

            foreach ($emails as $email) {
                $formsPerEmail[$email][] = $form;
            }
        });

        foreach ($formsPerEmail as $email => $forms) {
            $this->sendToUser($email, $forms, $since);
        }
    }

    protected function sendToUser(string $email, array $forms, Carbon $since)
    {
        $totalSubmissions = 0;

        foreach ($forms as $form) {
            $totalSubmissions += $form->submissions->count();
        }

        if ($totalSubmissions === 0 && !$this->option('send-if-empty')) {
            $this->info("No new submissions for $email, skipping");
            return;
        }

        Mail::send('emails.summary', [
            'forms' => $forms,
            'since' => $since,
        ], function (Message $message) use ($email) {
            $message->to($email);
            $message->subject(trans('summary.subject'));
        });
    }
}
