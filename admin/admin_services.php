<?php
$page_table    = 'services';
$page_titre    = 'des services';
$page_eyebrow  = 'Prestations · Présentation';
$page_subtitle = "Modifiez les contenus de la page Services : maintenance, réparation et pièces détachées proposées par SuperCar.";
 
$page_sections = [
    [
        'title' => "Bannière principale",
        'desc'  => "En-tête de la page Services",
        'fields' => [
            ['name' => 'titre_banner',    'label' => "Titre de la bannière", 'type' => 'text', 'placeholder' => 'Nos services premium'],
            ['name' => 'image_fond_top',  'label' => "Image de fond",        'type' => 'text', 'placeholder' => 'IMAGES/services-bg.jpg', 'is_image' => true],
        ],
    ],
    [
        'title' => "Maintenance",
        'desc'  => "Section maintenance des véhicules",
        'fields' => [
            ['name' => 'titre_maintenance',    'label' => "Titre",              'type' => 'text',     'placeholder' => 'Maintenance professionnelle'],
            ['name' => 'photo_maintenance',    'label' => "Photo",              'type' => 'text',     'placeholder' => 'IMAGES/maintenance.jpg', 'is_image' => true],
            ['name' => 'texte_maintenance',   'label' => "Texte descriptif",   'type' => 'textarea', 'placeholder' => 'Description du service de maintenance...'],
            ['name' => 'titre_maintenance_a', 'label' => "Sous-titre A",       'type' => 'text',     'placeholder' => 'Vidange et révision'],
            ['name' => 'liste_maintenance_a', 'label' => "Liste A",            'type' => 'textarea', 'placeholder' => 'Vidange moteur, Filtre à huile...'],
            ['name' => 'titre_maintenance_b', 'label' => "Sous-titre B",       'type' => 'text',     'placeholder' => 'Contrôles techniques'],
            ['name' => 'liste_maintenance_b', 'label' => "Liste B",            'type' => 'textarea', 'placeholder' => 'Freins, suspension, direction...'],
        ],
    ],
    [
        'title' => "Réparation",
        'desc'  => "Section réparation des véhicules",
        'fields' => [
            ['name' => 'titre_reparation',    'label' => "Titre",              'type' => 'text',     'placeholder' => 'Réparation experte'],
            ['name' => 'photo_réparation',    'label' => "Photo",              'type' => 'text',     'placeholder' => 'IMAGES/reparation.jpg', 'is_image' => true],
            ['name' => 'texte_reparation',    'label' => "Texte descriptif",   'type' => 'textarea', 'placeholder' => 'Description du service de réparation...'],
            ['name' => 'titre_reparation_a',  'label' => "Sous-titre A",       'type' => 'text',     'placeholder' => 'Mécanique générale'],
            ['name' => 'liste_reparation_a',  'label' => "Liste A",            'type' => 'textarea', 'placeholder' => 'Moteur, embrayage, boîte...'],
            ['name' => 'titre_reparation_b',  'label' => "Sous-titre B",       'type' => 'text',     'placeholder' => 'Carrosserie et peinture'],
            ['name' => 'liste_reparation_b',  'label' => "Liste B",            'type' => 'textarea', 'placeholder' => 'Débosselage, peinture, polissage...'],
        ],
    ],
    [
        'title' => "Pièces détachées",
        'desc'  => "Section pièces et accessoires",
        'fields' => [
            ['name' => 'titre_pieces',    'label' => "Titre",              'type' => 'text',     'placeholder' => 'Pièces d\'origine'],
            ['name' => 'photp_piece',     'label' => "Photo",              'type' => 'text',     'placeholder' => 'IMAGES/pieces.jpg', 'is_image' => true],
            ['name' => 'texte_pieces',    'label' => "Texte descriptif",   'type' => 'textarea', 'placeholder' => 'Description des pièces détachées...'],
            ['name' => 'titre_pieces_a',  'label' => "Sous-titre A",       'type' => 'text',     'placeholder' => 'Pièces moteur'],
            ['name' => 'liste_pieces_a',  'label' => "Liste A",            'type' => 'textarea', 'placeholder' => 'Bougies, filtres, courroies...'],
            ['name' => 'titre_pieces_b',  'label' => "Sous-titre B",       'type' => 'text',     'placeholder' => 'Accessoires'],
            ['name' => 'liste_pieces_b',  'label' => "Liste B",            'type' => 'textarea', 'placeholder' => 'Tapis, housses, jantes...'],
        ],
    ],
];
 
include 'page_content_admin.php';