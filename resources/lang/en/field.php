<?php

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

return [

	'label' => [

		'slug'  => 'Slug',
		'title' => 'Title',
		'rules' => 'Validation rules',
		'value' => 'Value',
		'no_value' => 'No value',

	],

	'help' => [

		'rules' => 'A Laravel Validation compatible rules string',

	],

	'action' => [

		'create'  => 'Create new field',
		'edit'    => 'Edit field',
		'save'    => 'Save field',
		'delete'  => 'Delete field',

	],

	'heading' => [

		'single' => 'Field',
		'list'   => 'Fields',
		'none'   => 'No field',

	],

	'message' => [

		'create_success'   => 'Field created successfully',
		'edit_success'     => 'Field edited successfully',
		'delete_success'   => 'Field deleted successfully',

	],

];
