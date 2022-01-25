<?php

return [
    'label' => [
        'slug' => 'Slug',
        'title' => 'Title',
        'accept_submissions' => 'Accept new submissions',
        'send_email_to' => 'Send a notification email to',
        'confirmation_message' => 'Confirmation message',
        'confirmation_email_field' => 'Confirmation email field',
        'redirect_to_url' => 'Redirect to URL',
        'owner_email' => 'Owner email',
        'owner_name' => 'Owner name',
        'created_at' => 'Created at',

        'total_submissions' => 'Submissions',
    ],
    'help' => [
        'available_at_url' => 'You can POST your form to :url',
        'send_email_to' => 'Coma-separated list of email that should recieve a notification for each new submission',
        'confirmation_message' => 'A confirmation message that will be sent by email to the user when he submits the form. Leave empty for none.',
        'confirmation_formatting' => 'Markdown is enabled. Use :slug to display a field value.',
        'confirmation_email_field' => 'The slug of the field to use as the email address of the user',
        'owner_email' => 'The email that will be used in the "from" field of all sent emails',
        'owner_name' => 'The name that will be used in the "from" field of all sent emails',
    ],
    'action' => [
        'create' => 'Create new form',
        'edit' => 'Edit form',
        'save' => 'Save form',
        'delete' => 'Delete form',
    ],
    'heading' => [
        'list' => 'Forms',
        'none' => 'No forms',
    ],
    'message' => [
        'create_success' => 'Form created successfully',
        'edit_success' => 'Form edited successfully',
        'delete_success' => 'Form deleted successfully',
    ],
];
