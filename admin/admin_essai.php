<?php
$page_table    = 'essai';
$page_titre    = "Demande d'essai";
$page_eyebrow  = 'Service · Formulaire';
$page_subtitle = "Modifiez les contenus de la page de demande d'essai : titre, message, options de marques et libellés des champs.";
 
$page_sections = [
    [
        'title' => "En-tête de la page",
        'desc'  => "Titre, image et message de succès",
        'fields' => [
            ['name' => 'titre_formulaire', 'label' => "Titre du formulaire", 'type' => 'text',     'placeholder' => 'Réservez votre essai'],
            ['name' => 'message_succes',   'label' => "Message de succès",   'type' => 'text',     'placeholder' => 'Votre demande a bien été enregistrée'],
            ['name' => 'texte_bouton',     'label' => "Texte du bouton",     'type' => 'text',     'placeholder' => 'Envoyer ma demande'],
            ['name' => 'image_fond',       'label' => "Image de fond",       'type' => 'text',     'placeholder' => 'IMAGES/essai-bg.jpg', 'is_image' => true],
        ],
    ],
    [
        'title' => "Libellés des marques",
        'desc'  => "Noms affichés dans le sélecteur",
        'fields' => [
            ['name' => 'label_mercedes', 'label' => "Libellé Mercedes", 'type' => 'text', 'placeholder' => 'Mercedes-Benz'],
            ['name' => 'label_ford',     'label' => "Libellé Ford",     'type' => 'text', 'placeholder' => 'Ford'],
            ['name' => 'label_toyota',   'label' => "Libellé Toyota",   'type' => 'text', 'placeholder' => 'Toyota'],
            ['name' => 'label_nissan',   'label' => "Libellé Nissan",   'type' => 'text', 'placeholder' => 'Nissan'],
        ],
    ],
    [
        'title' => "Modèles disponibles par marque",
        'desc'  => "Liste des modèles à proposer",
        'fields' => [
            ['name' => 'car_option_merco',  'label' => "Modèles Mercedes", 'type' => 'textarea', 'placeholder' => 'Classe A, Classe C, Classe E...'],
            ['name' => 'car_option_ford',   'label' => "Modèles Ford",     'type' => 'textarea', 'placeholder' => 'Mustang, Focus, Fiesta...'],
            ['name' => 'car_option_toyota', 'label' => "Modèles Toyota",   'type' => 'textarea', 'placeholder' => 'Corolla, RAV4, Yaris...'],
            ['name' => 'car_option_nissan', 'label' => "Modèles Nissan",   'type' => 'textarea', 'placeholder' => 'Qashqai, Juke, Micra...'],
        ],
    ],
];
 
include 'page_content_admin.php';