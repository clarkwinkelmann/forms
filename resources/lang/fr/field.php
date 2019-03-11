<?php

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

return [

	'label' => [

		'slug'  => 'Slug',
		'title' => 'Titre',
		'rules' => 'Règles de validation',
		'value' => 'Valeur',
		'no_value' => 'Sans valeur',

	],

	'help' => [

		'rules' => 'Une chaîne compatible Laravel Validation',

	],

	'action' => [

		'create'  => 'Créer un nouveau champ',
		'edit'    => 'Éditer le champ',
		'save'    => 'Sauvegarder le champ',
		'delete'  => 'Supprimer le champ',

	],

	'heading' => [

		'single' => 'Champ',
		'list'   => 'Champs',
		'none'   => 'Aucun champ',

	],

	'message' => [

		'create_success'   => 'Champ créé avec succès',
		'edit_success'     => 'Champ modifié avec succès',
		'delete_success'   => 'Champ supprimé avec succès',

	],

    'email_url_redacted' => 'La valeur contient une url et a été cachée. Consultez le message complet via l\'interface web',

];
