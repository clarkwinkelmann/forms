<?php

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

return [

	'label' => [

		'created_at' => 'Submitted at',

		'preview'    => 'Preview',

	],

	'action' => [

		'show'       => 'View submission',
		'show_index' => 'View submissions',
		'delete'     => 'Delete submission',

	],

	'heading' => [

		'single_for' => 'Submission on ":form"',
		'list'       => 'Submissions',
		'list_for'   => 'Submissions on ":form"',
		'none'       => 'No submission yet',
		'new_submission_on' => 'New submission on ":form"',

		'errors_occurred' => 'Errors occurred',
		'closed'          => 'Form closed',
		'submitted'       => 'Form submitted !',

	],

	'message' => [

		'delete_success'    => 'Submission deleted successfully',
		'meta_sentence'     => 'Submitted by :ip / :agent',
		'meta_sentence_ref' => 'Submitted by :ip / :agent via :referer',
		'errors_occurred'   => 'We tried to process the forms but the following errors occurred. This should not have happended and you should inform the form owner. Nothing has been saved !',
		'should_retry'      => 'You should hit the "back" button of your browser and try submitting the form again after you fixed the errors',
		'closed'            => 'This form has been closed and doesn\'t accept submissions anymore. You should contact the form owner if you think it\'s a mistake.',
		'submitted'         => 'Your submission has been saved. You\'re all done !',
		'email_sent'        => 'We sent a confirmation email to your address so you\'re extra sure it worked !',
		'email_failed'      => 'We tried to send a confirmation email but an error occurred. You should report that to the form owner. But don\'t worry, your submission has been successfully submitted ;-)',
		'below_summary'     => 'You can find a copy of your submission below:',

	],

];
