<?php

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

return [

	'label' => [

		'slug'                     => 'Slug',
		'title'                    => 'Titre',
		'accept_submissions'       => 'Accepte de nouvelles réponses',
		'send_email_to'            => 'Envoyer un email de notification à',
		'confirmation_message'     => 'Message de confirmation',
		'confirmation_email_field' => 'Champ email pour la confirmation',
		'redirect_to_url'          => 'Rediriger vers l\'URL',
		'owner_email'              => 'Email du propriétaire',
		'owner_name'               => 'Nom du propriétaire',
		'created_at'               => 'Créé le',

		'total_submissions'        => 'Réponses',

	],

	'help' => [

		'send_email_to'            => 'Une liste d\'adresses email séparées par des virgules qui doivent recevoir une notification pour chaque nouvelle réponse',
		'confirmation_message'     => 'Un message de confirmation qui sera envoyé par email à l\'utilisateur quand il soumet une réponse. Laisser vide pour ne pas envoyer de confirmation',
		'confirmation_email_field' => 'Le slug du champ à utiliser comme adresse email de l\'utilisateur',
		'owner_email'              => 'L\'adresse email qui sera utilisée dans le champ "de" des emails envoyés',
		'owner_name'               => 'Le nom qui sera utilisée dans le champ "de" des emails envoyés',

	],

	'action' => [

		'create'  => 'Créer un nouveau formulaire',
		'edit'    => 'Éditer le formulaire',
		'save'    => 'Sauvegarder le formulaire',
		'delete'  => 'Supprimer le formulaire',

	],

	'heading' => [

		'list' => 'Formulaires',
		'none' => 'Aucun formulaire',

	],

	'message' => [

		'create_success'   => 'Formulaire créé avec succès',
		'edit_success'     => 'Formulaire modifié avec succès',
		'delete_success'   => 'Formulaire supprimé avec succès',

	],

];
