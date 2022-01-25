<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\Form;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Creates the forms used in the tests
 */
class TestFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Delete all records
        Submission::whereNotNull('id')->delete();
        Form::whereNotNull('id')->delete();

        $form1 = Form::create([
            'slug' => 'the-test',
            'title' => 'Nice test Form',
        ]);

        $form1->fields()->save(new Field([
            'slug' => 'name',
            'title' => 'Name',
            'rules' => 'required|string',
        ]));

        $form1->fields()->save(new Field([
            'slug' => 'rating',
            'title' => 'Rating',
            'rules' => 'required|integer|min:1|max:5',
        ]));

        $form2 = Form::create([
            'slug' => 'test-with-email-confirmation',
            'title' => 'Test that sends email confirmation',
            'confirmation_message' => 'Thanks for the message !',
            'confirmation_email_field' => 'email',
            'owner_email' => 'info@company.com',
            'owner_name' => 'That Company',
        ]);

        $form2->fields()->save(new Field([
            'slug' => 'email',
            'title' => 'Email',
            'rules' => 'required|email',
        ]));

        Form::create([
            'slug' => 'test-with-email-notification',
            'title' => 'Test with email notification',
            'send_email_to' => 'john@example.com,max@example.com',
            'owner_email' => 'info@company.com',
            'owner_name' => 'That Company',
        ]);

        Form::create([
            'slug' => 'test-with-redirect',
            'title' => 'Test with a redirect',
            'redirect_to_url' => 'https://example.com/',
        ]);

        Form::create([
            'slug' => 'test-closed',
            'title' => 'Closed form test',
            'accept_submissions' => false,
        ]);

        Model::reguard();
    }
}
