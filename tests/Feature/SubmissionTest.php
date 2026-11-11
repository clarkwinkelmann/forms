<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\Submission;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mime\Address;
use Tests\TestCase;

/**
 * Tests for the main app task: Handling submit requests
 *
 * Make sure to run the TestFormSeeder before launching the tests
 */
class SubmissionTest extends TestCase
{
    public function testAcceptOnlyPostVerb()
    {
        $test_form = Form::first();

        $response1 = $this->call('GET', '/forms/' . $test_form->slug);

        $response1->assertStatus(405);

        $response2 = $this->call('POST', '/forms/' . $test_form->slug);

        $response2->assertStatus(422);
    }

    public function testInvalidFormNotFound()
    {
        $response = $this->call('POST', '/forms/noformshouldexistwiththisnameatall');

        $response->assertStatus(404);
    }

    public function testStandardSubmit()
    {
        $form = Form::where('slug', 'the-test')->firstOrFail();

        $response = $this->call('POST', '/forms/' . $form->slug, [
            'name' => 'John Doe',
            'rating' => 4,
        ]);

        $response->assertStatus(201);
    }

    public function testInvalidFieldSubmit()
    {
        $form = Form::where('slug', 'the-test')->firstOrFail();

        $response1 = $this->call('POST', '/forms/' . $form->slug, [
            'name' => null, // field was required
        ]);

        $response1->assertStatus(422);

        $response2 = $this->call('POST', '/forms/' . $form->slug, [
            'name' => 'John', // valid
            'rating' => 100, // max was 5
        ]);

        $response2->assertStatus(422);
    }

    public function testCannotSubmitToClosedForm()
    {
        $form = Form::where('slug', 'test-closed')->firstOrFail();

        $response = $this->call('POST', '/forms/' . $form->slug);

        $response->assertStatus(403);
    }

    public function testSendEmailNotification()
    {
        $form = Form::where('slug', 'test-with-email-notification')->firstOrFail();

        $response = $this->call('POST', '/forms/' . $form->slug);

        $response->assertStatus(201);

        $this->assertEqualsCanonicalizing(explode(',', $form->send_email_to), $this->sentTo());
    }

    public function testSendEmailConfirmation()
    {
        $form = Form::where('slug', 'test-with-email-confirmation')->firstOrFail();

        $response = $this->call('POST', '/forms/' . $form->slug, [
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(201);

        $this->assertEquals(['john@example.com'], $this->sentTo());
    }

    /**
     * Get the recipients of every email sent during the test. Emails go to the array mailer, set in phpunit.xml
     *
     * @return string[]
     */
    private function sentTo(): array
    {
        return Mail::getSymfonyTransport()->messages()
            ->flatMap(fn (SentMessage $message) => $message->getEnvelope()->getRecipients())
            ->map(fn (Address $address) => $address->getAddress())
            ->all();
    }

    public function testRedirectAfterSubmission()
    {
        $form = Form::where('slug', 'test-with-redirect')->firstOrFail();

        $response = $this->call('POST', '/forms/' . $form->slug);

        $response->assertRedirect($form->redirect_to_url);
    }

    public function testUserAgentAndRefererTruncated()
    {
        $form = Form::where('slug', 'the-test')->firstOrFail();

        $response = $this->call('POST', '/forms/' . $form->slug, [
            'name' => 'John Doe',
            'rating' => 4,
        ], [], [], [
            'HTTP_USER_AGENT' => 'FakeBrowser1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234shouldtruncate',
            'HTTP_REFERER' => 'https://fakewebsite.tld/456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234shouldtruncate',
        ]);

        $response->assertStatus(201);

        /**
         * @var $submission Submission
         */
        $submission = Submission::query()->orderBy('id', 'desc')->first();

        $this->assertEquals('FakeBrowser1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234', $submission->user_agent);
        $this->assertEquals('https://fakewebsite.tld/456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234', $submission->user_referer);
    }

    public function testSpamEmail()
    {
        $response = $this->call('POST', '/forms/test-with-email-confirmation', [
            'email' => 'not.suspicious@gmail.com',
        ]);

        $response->assertStatus(201);

        /**
         * @var $submission Submission
         */
        $submission = Submission::query()->orderBy('id', 'desc')->first();

        $this->assertEquals(0, $submission->is_spam);

        $response = $this->call('POST', '/forms/test-with-email-confirmation', [
            'email' => 'test@mail.ru',
        ]);

        $response->assertStatus(201);

        /**
         * @var $submission Submission
         */
        $submission = Submission::query()->orderBy('id', 'desc')->first();

        $this->assertEquals(1, $submission->is_spam);
    }

    public function testSpamLink()
    {
        $response = $this->call('POST', '/forms/the-test', [
            'name' => 'My site https://example.ch/',
            'rating' => 1,
        ]);

        $response->assertStatus(201);

        /**
         * @var $submission Submission
         */
        $submission = Submission::query()->orderBy('id', 'desc')->first();

        $this->assertEquals(0, $submission->is_spam);

        $response = $this->call('POST', '/forms/the-test', [
            'name' => 'My site https://example.com/',
            'rating' => 1,
        ]);

        $response->assertStatus(201);

        /**
         * @var $submission Submission
         */
        $submission = Submission::query()->orderBy('id', 'desc')->first();

        $this->assertEquals(1, $submission->is_spam);
    }

    public function testSpamWord()
    {
        $response = $this->call('POST', '/forms/the-test', [
            'name' => 'This is about capital financing',
            'rating' => 1,
        ]);

        $response->assertStatus(201);

        /**
         * @var $submission Submission
         */
        $submission = Submission::query()->orderBy('id', 'desc')->first();

        $this->assertEquals(1, $submission->is_spam);
    }
}
