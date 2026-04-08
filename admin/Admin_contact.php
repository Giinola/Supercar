<?php
$page_table    = 'contact_contenu';
$page_titre    = 'de contact';
$page_eyebrow  = 'Communication · Coordonnées';
$page_subtitle = "Modifiez les coordonnées de l'entreprise et les contenus affichés sur la page Contact du site SuperCar.";
 
$page_sections = [
    [
        'title' => "Informations de contact",
        'desc'  => "Coordonnées de l'entreprise",
        'fields' => [
            ['name' => 'titre_infos_contact', 'label' => "Titre du bloc",     'type' => 'text', 'placeholder' => 'Nos coordonnées'],
            ['name' => 'contact_tel',         'label' => "Téléphone",          'type' => 'text', 'placeholder' => '+230 5 123 4567'],
            ['name' => 'contact_email',       'label' => "Adresse email",      'type' => 'text', 'placeholder' => 'contact@supercar.mu'],
            ['name' => 'contact_adresse',     'label' => "Adresse postale",    'type' => 'text', 'placeholder' => 'Port-Louis, Île Maurice'],
        ],
    ],
    [
        'title' => "Formulaire de contact",
        'desc'  => "Textes affichés autour du formulaire",
        'fields' => [
            ['name' => 'titre_formulaire', 'label' => "Titre du formulaire", 'type' => 'text', 'placeholder' => 'Envoyez-nous un message'],
            ['name' => 'texte_bouton',     'label' => "Texte du bouton",     'type' => 'text', 'placeholder' => 'Envoyer'],
        ],
    ],
    [
        'title' => "Carte Google Maps",
        'desc'  => "Code d'intégration iframe",
        'fields' => [
            ['name' => 'iframe_map', 'label' => "Code iframe Google Maps", 'type' => 'textarea', 'placeholder' => '<iframe src="https://www.google.com/maps/embed?..."></iframe>'],
        ],
    ],
];
 
include 'page_content_admin.php';