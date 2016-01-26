<?php

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use App\Form;
use Illuminate\Mail\Message;

/**
 * Tests for the main app task: Handling submit requests
 *
 * Make sure to run the TestFormSeeder before launching the tests
 */
class SubmissionTest extends TestCase {

	public function testAcceptOnlyPostVerb()
	{
		$test_form = Form::first();

		$response1 = $this->call('GET', '/forms/' . $test_form->slug);

		$this->assertEquals(405, $response1->status());

		$response2 = $this->call('POST', '/forms/' . $test_form->slug);

		$this->assertNotEquals(405, $response2->status());
	}

	public function testInvalidFormNotFound()
	{
		$response = $this->call('POST', '/forms/noformshouldexistwiththisnameatall');

		$this->assertEquals(404, $response->status());
	}

	public function testStandardSubmit()
	{
		$form = Form::where('slug', 'the-test')->firstOrFail();

		$response = $this->call('POST', '/forms/' . $form->slug, [
			'name'   => 'John Doe',
			'rating' => 4,
		]);

		$this->assertEquals(201, $response->status());
	}

	public function testInvalidFieldSubmit()
	{
		$form = Form::where('slug', 'the-test')->firstOrFail();

		$response1 = $this->call('POST', '/forms/' . $form->slug, [
			'name' => null, // field was required
		]);

		$this->assertEquals(422, $response1->status());

		$response2 = $this->call('POST', '/forms/' . $form->slug, [
			'name' => 'John', // valid
			'rating' => 100, // max was 5
		]);

		$this->assertEquals(422, $response2->status());
	}

	public function testCannotSubmitToClosedForm()
	{
		$form = Form::where('slug', 'test-closed')->firstOrFail();

		$response = $this->call('POST', '/forms/' . $form->slug);

		$this->assertEquals(403, $response->status());
	}

	public function testSendEmailNotification()
	{
		$form = Form::where('slug', 'test-with-email-notification')->firstOrFail();

		$should_be_sent_to = collect(explode(',', $form->send_email_to));
		$sent_to = collect();

		Mail::shouldReceive('send')->twice()
				->andReturnUsing(function($view, $data, $callback) use($sent_to) {
					// replicate the behavior of Illuminate\Mail\Mailer::callMessageBuilder()
					// so we can test what would have been the output of the method send()
					$message = new Message(new Swift_Message);

					call_user_func($callback, $message);

					$sent_to->push(collect($message->getTo())->keys()->first());

					return $message;
				});

		$response = $this->call('POST', '/forms/' . $form->slug);

		$this->assertEquals(201, $response->status());

		// There should be no difference
		$this->assertEquals(0, $should_be_sent_to->diff($sent_to)->count());
	}

	public function testSendEmailConfirmation()
	{
		$form = Form::where('slug', 'test-with-email-confirmation')->firstOrFail();

		Mail::shouldReceive('send')->once()
				->andReturnUsing(function($view, $data, $callback) {
					// replicate the behavior of Illuminate\Mail\Mailer::callMessageBuilder()
					// so we can test what would have been the result of the send() method
					$message = new Message(new Swift_Message);

					call_user_func($callback, $message);

					$this->assertEquals('john@example.com', collect($message->getTo())->keys()->first());

					return $message;
				});

		$response = $this->call('POST', '/forms/' . $form->slug, [
			'email' => 'john@example.com',
		]);

		$this->assertEquals(201, $response->status());
	}

	public function testRedirectAfterSubmission()
	{
		$form = Form::where('slug', 'test-with-redirect')->firstOrFail();

		$this->call('POST', '/forms/' . $form->slug);

		$this->assertRedirectedTo($form->redirect_to_url);
	}

}
