<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute doit être accepté.',
    'active_url'           => ':attribute doit être une URL valide.',
    'after'                => ':attribute doit être une date après :date.',
    'alpha'                => ':attribute ne peut contenir que des lettres.',
    'alpha_dash'           => ':attribute ne peut contenir que des lettre, chiffres et traits d\'union.',
    'alpha_num'            => ':attribute ne peut contenir que des lettres et chiffres.',
    'array'                => ':attribute doit être un tableau.',
    'before'               => ':attribute doit être une date avant :date.',
    'between'              => [
        'numeric' => ':attribute doit être entre :min et :max.',
        'file'    => ':attribute doit peser entre :min et :max kilobytes.',
        'string'  => ':attribute doit avoir une longeur entre :min et :max caractères.',
        'array'   => ':attribute doit contenir entre :min et :max éléments.',
    ],
    'boolean'              => ':attribute doit valoir vrai ou faux.',
    'confirmed'            => 'La confirmation de :attribute ne correspond pas.',
    'date'                 => ':attribute n\'est pas une date valide.',
    'date_format'          => ':attribute ne correspond pas au format :format.',
    'different'            => ':attribute et :other doivent être différents.',
    'digits'               => ':attribute doit contenir :digits chiffres.',
    'digits_between'       => ':attribute doit contenir entre :min et :max chiffres.',
    'email'                => ':attribute doit être une adresse email valide.',
    'exists'               => 'La sélection pour :attribute est invalide.',
    'filled'               => 'Le champ :attribute est requis.',
    'image'                => ':attribute doit être une image.',
    'in'                   => 'La sélection pour :attribute est invalide.',
    'integer'              => ':attribute doit être un entier.',
    'ip'                   => ':attribute doit être une adresse IP valide.',
    'json'                 => ':attribute doit être une chaîne JSON valide.',
    'max'                  => [
        'numeric' => ':attribute ne doit pas etre plus grand que :max.',
        'file'    => ':attribute ne doit pas peser plus que :max kilobytes.',
        'string'  => ':attribute ne doit pas etre plus long que :max caractères.',
        'array'   => ':attribute ne doit pas contenir plus de :max éléments.',
    ],
    'mimes'                => ':attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute doit valoir au moins :min.',
        'file'    => ':attribute doit peser au moins :min kilobytes.',
        'string'  => ':attribute doit contenir au moins :min caractères.',
        'array'   => ':attribute doit contenir au moins :min éléments.',
    ],
    'not_in'               => 'La sélection pour :attribute est invalide.',
    'numeric'              => ':attribute doit être un nombre.',
    'regex'                => 'Le format de :attribute est invalide.',
    'required'             => 'Le champ :attribute est requis.',
    'required_if'          => 'Le champ :attribute est requis quand :other vaut :value.',
    'required_unless'      => 'Le champ :attribute est requis sauf si :other vaut :values.',
    'required_with'        => 'Le champ :attribute est requis quand :values est présent.',
    'required_with_all'    => 'Le champ :attribute est requis quand :values est présent.',
    'required_without'     => 'Le champ :attribute est requis quand :values est absent.',
    'required_without_all' => 'Le champ :attribute est requis quand aucun de :values n\'est présent.',
    'same'                 => 'Les champs :attribute et :other doivent être identiques.',
    'size'                 => [
        'numeric' => ':attribute doit valoir :size.',
        'file'    => ':attribute doit peser :size kilobytes.',
        'string'  => ':attribute doit contenir :size caractères.',
        'array'   => ':attribute doit contenir :size éléments.',
    ],
    'string'               => ':attribute doit être une chaîne de caractères.',
    'timezone'             => ':attribute doit être une timezone valide.',
    'unique'               => ':attribute a déjà été utilisé.',
    'url'                  => 'Le format de :attribute est invalide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

];
