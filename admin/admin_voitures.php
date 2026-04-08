<?php
$page_table    = 'voitures';
$page_titre    = 'Voitures';
$page_eyebrow  = 'Catalogue · Présentation';
$page_subtitle = "Modifiez le titre, la description et les vignettes des marques affichées sur la page Voitures du site SuperCar.";
 
// Variable spéciale pour le trigger d'audit MySQL
// Le helper exécutera SET @admin_user avant les UPDATE
$page_set_admin_user = true;
 
$page_sections = [
    [
        'title' => "En-tête de la page",
        'desc'  => "Titre principal et description",
        'fields' => [
            ['name' => 'titre_page',       'label' => "Titre de la page", 'type' => 'text',     'placeholder' => 'Notre catalogue'],
            ['name' => 'description_page', 'label' => "Description",      'type' => 'textarea', 'placeholder' => 'Découvrez notre sélection de véhicules...'],
        ],
    ],
    [
        'title' => "Vignette · Mercedes",
        'desc'  => "Carte affichée sur la page Voitures",
        'fields' => [
            ['name' => 'mercedes_nom',   'label' => "Nom affiché",       'type' => 'text', 'placeholder' => 'Mercedes-Benz'],
            ['name' => 'mercedes_image', 'label' => "Chemin de l'image", 'type' => 'text', 'placeholder' => 'IMAGES/mercedes.jpg', 'is_image' => true],
            ['name' => 'mercedes_lien',  'label' => "Lien vers la page", 'type' => 'text', 'placeholder' => 'Mercedes.php'],
        ],
    ],
    [
        'title' => "Vignette · Ferrari",
        'desc'  => "Carte affichée sur la page Voitures",
        'fields' => [
            ['name' => 'ferrari_nom',   'label' => "Nom affiché",       'type' => 'text', 'placeholder' => 'Ferrari'],
            ['name' => 'ferrari_image', 'label' => "Chemin de l'image", 'type' => 'text', 'placeholder' => 'IMAGES/ferrari.jpg', 'is_image' => true],
            ['name' => 'ferrari_lien',  'label' => "Lien vers la page", 'type' => 'text', 'placeholder' => 'Ferrari.php'],
        ],
    ],
    [
        'title' => "Vignette · McLaren",
        'desc'  => "Carte affichée sur la page Voitures",
        'fields' => [
            ['name' => 'mclaren_nom',   'label' => "Nom affiché",       'type' => 'text', 'placeholder' => 'McLaren'],
            ['name' => 'mclaren_image', 'label' => "Chemin de l'image", 'type' => 'text', 'placeholder' => 'IMAGES/mclaren.jpg', 'is_image' => true],
            ['name' => 'mclaren_lien',  'label' => "Lien vers la page", 'type' => 'text', 'placeholder' => 'McLaren.php'],
        ],
    ],
    [
        'title' => "Vignette · Range Rover",
        'desc'  => "Carte affichée sur la page Voitures",
        'fields' => [
            ['name' => 'range_rover_nom',   'label' => "Nom affiché",       'type' => 'text', 'placeholder' => 'Range Rover'],
            ['name' => 'range_rover_image', 'label' => "Chemin de l'image", 'type' => 'text', 'placeholder' => 'IMAGES/rangerover.jpg', 'is_image' => true],
            ['name' => 'range_rover_lien',  'label' => "Lien vers la page", 'type' => 'text', 'placeholder' => 'RR.php'],
        ],
    ],
];
 
include 'page_content_admin.php';