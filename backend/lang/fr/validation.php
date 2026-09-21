<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Messages de validation, en francais
    |--------------------------------------------------------------------------
    |
    | Traductions minimales couvrant les regles utilisees par l'API
    | SignalAyiti (inscription, connexion, creation de signalement,
    | changement de statut).
    |
    */

    'accepted' => 'Le champ :attribute doit être accepté.',
    'confirmed' => 'La confirmation du champ :attribute ne correspond pas.',
    'email' => 'Le champ :attribute doit être une adresse email valide.',
    'exists' => 'Le champ :attribute sélectionné est invalide.',
    'file' => 'Le champ :attribute doit être un fichier.',
    'image' => 'Le champ :attribute doit être une image.',
    'in' => 'Le champ :attribute sélectionné est invalide.',
    'integer' => 'Le champ :attribute doit être un nombre entier.',
    'max' => [
        'string' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
        'file' => 'Le champ :attribute ne peut pas dépasser :max kilo-octets.',
        'numeric' => 'Le champ :attribute ne peut pas être supérieur à :max.',
    ],
    'min' => [
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
        'numeric' => 'Le champ :attribute doit être au moins :min.',
    ],
    'required' => 'Le champ :attribute est obligatoire.',
    'string' => 'Le champ :attribute doit être une chaîne de caractères.',
    'unique' => 'Cette valeur du champ :attribute est déjà utilisée.',
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'numeric' => 'Le champ :attribute doit être un nombre.',
    'date' => 'Le champ :attribute n\'est pas une date valide.',

    /*
    |--------------------------------------------------------------------------
    | Noms des attributs, en francais
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'name' => 'nom',
        'email' => 'adresse email',
        'password' => 'mot de passe',
        'password_confirmation' => 'confirmation du mot de passe',
        'quartier' => 'quartier',
        'telephone' => 'téléphone',
        'categorie' => 'catégorie',
        'titre' => 'titre',
        'description' => 'description',
        'photo' => 'photo',
        'statut' => 'statut',
        'commentaire' => 'commentaire',
    ],

];
