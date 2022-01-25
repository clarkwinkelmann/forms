<?php

namespace Tests\Feature;

use App\Models\Form;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
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

        $should_be_sent_to = collect(explode(',', $form->send_email_to));
        $sent_to = collect();

        Mail::shouldReceive('send')->twice()
            ->andReturnUsing(function ($view, $data, $callback) use ($sent_to) {
                // replicate the behavior of Illuminate\Mail\Mailer::callMessageBuilder()
                // so we can test what would have been the output of the method send()
                $message = new Message(new \Swift_Message);

                call_user_func($callback, $message);

                $sent_to->push(collect($message->getTo())->keys()->first());

                return $message;
            });

        $response = $this->call('POST', '/forms/' . $form->slug);

        $response->assertStatus(201);

        // There should be no difference
        $this->assertEquals(0, $should_be_sent_to->diff($sent_to)->count());
    }

    public function testSendEmailConfirmation()
    {
        $form = Form::where('slug', 'test-with-email-confirmation')->firstOrFail();

        Mail::shouldReceive('send')->once()
            ->andReturnUsing(function ($view, $data, $callback) {
                // replicate the behavior of Illuminate\Mail\Mailer::callMessageBuilder()
                // so we can test what would have been the result of the send() method
                $message = new Message(new \Swift_Message);

                call_user_func($callback, $message);

                $this->assertEquals('john@example.com', collect($message->getTo())->keys()->first());

                return $message;
            });

        $response = $this->call('POST', '/forms/' . $form->slug, [
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(201);
    }

    public function testRedirectAfterSubmission()
    {
        $form = Form::where('slug', 'test-with-redirect')->firstOrFail();

        $response = $this->call('POST', '/forms/' . $form->slug);

        $response->assertRedirect($form->redirect_to_url);
    }
}