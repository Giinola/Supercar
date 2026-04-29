<?php
$page_table    = 'voitures';
$page_titre    = 'Voitures';
$page_eyebrow  = 'Catalogue · Présentation';
$page_subtitle = "Modifiez le titre, la description et les vignettes des marques affichées sur la page Voitures du site SuperCar.";


$page_set_admin_user = true;


$page_header_extra = '
<style>
    .marques-shortcuts {
        margin-bottom: 48px;
        animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) 0.15s both;
    }

    .marques-shortcuts-label {
        font-size: 10px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 18px;
        font-weight: 400;
    }

    .marques-shortcuts-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .marque-shortcut {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        background: rgba(17, 17, 17, 0.6);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--line);
        color: var(--text);
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    .marque-shortcut:hover {
        border-color: var(--accent);
        transform: translateY(-2px);
        background: rgba(201, 168, 117, 0.05);
    }

    .marque-shortcut-text {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .marque-shortcut-name {
        font-family: \'Cormorant Garamond\', serif;
        font-size: 18px;
        font-weight: 500;
        color: var(--text);
    }

    .marque-shortcut-desc {
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-muted);
    }

    .marque-shortcut:hover .marque-shortcut-desc {
        color: var(--accent);
    }

    .marque-shortcut-arrow {
        color: var(--text-muted);
        font-size: 18px;
        transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    .marque-shortcut:hover .marque-shortcut-arrow {
        color: var(--accent);
        transform: translateX(5px);
    }

    @media (max-width: 1024px) {
        .marques-shortcuts-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 600px) {
        .marques-shortcuts-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="marques-shortcuts">
    <div class="marques-shortcuts-label">Gérer les modèles par marque</div>
    <div class="marques-shortcuts-grid">
        <a href="ferrari.php" class="marque-shortcut">
            <div class="marque-shortcut-text">
                <span class="marque-shortcut-name">Ferrari</span>
                <span class="marque-shortcut-desc">Gérer les modèles</span>
            </div>
            <span class="marque-shortcut-arrow">→</span>
        </a>

        <a href="mclaren.php" class="marque-shortcut">
            <div class="marque-shortcut-text">
                <span class="marque-shortcut-name">McLaren</span>
                <span class="marque-shortcut-desc">Gérer les modèles</span>
            </div>
            <span class="marque-shortcut-arrow">→</span>
        </a>

        <a href="Merco.php" class="marque-shortcut">
            <div class="marque-shortcut-text">
                <span class="marque-shortcut-name">Mercedes</span>
                <span class="marque-shortcut-desc">Gérer les modèles</span>
            </div>
            <span class="marque-shortcut-arrow">→</span>
        </a>

        <a href="range_rove.php" class="marque-shortcut">
            <div class="marque-shortcut-text">
                <span class="marque-shortcut-name">Range Rover</span>
                <span class="marque-shortcut-desc">Gérer les modèles</span>
            </div>
            <span class="marque-shortcut-arrow">→</span>
        </a>
    </div>
</div>
';

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
            ['name' => 'mercedes_lien',  'label' => "Lien vers la page", 'type' => 'text', 'placeholder' => 'Merco.php'],
        ],
    ],
    [
        'title' => "Vignette · Ferrari",
        'desc'  => "Carte affichée sur la page Voitures",
        'fields' => [
            ['name' => 'ferrari_nom',   'label' => "Nom affiché",       'type' => 'text', 'placeholder' => 'Ferrari'],
            ['name' => 'ferrari_image', 'label' => "Chemin de l'image", 'type' => 'text', 'placeholder' => 'IMAGES/ferrari.jpg', 'is_image' => true],
            ['name' => 'ferrari_lien',  'label' => "Lien vers la page", 'type' => 'text', 'placeholder' => 'ferrari.php'],
        ],
    ],
    [
        'title' => "Vignette · McLaren",
        'desc'  => "Carte affichée sur la page Voitures",
        'fields' => [
            ['name' => 'mclaren_nom',   'label' => "Nom affiché",       'type' => 'text', 'placeholder' => 'McLaren'],
            ['name' => 'mclaren_image', 'label' => "Chemin de l'image", 'type' => 'text', 'placeholder' => 'IMAGES/mclaren.jpg', 'is_image' => true],
            ['name' => 'mclaren_lien',  'label' => "Lien vers la page", 'type' => 'text', 'placeholder' => 'mcLaren.php'],
        ],
    ],
    [
        'title' => "Vignette · Range Rover",
        'desc'  => "Carte affichée sur la page Voitures",
        'fields' => [
            ['name' => 'range_rover_nom',   'label' => "Nom affiché",       'type' => 'text', 'placeholder' => 'Range Rover'],
            ['name' => 'range_rover_image', 'label' => "Chemin de l'image", 'type' => 'text', 'placeholder' => 'IMAGES/rangerover.jpg', 'is_image' => true],
            ['name' => 'range_rover_lien',  'label' => "Lien vers la page", 'type' => 'text', 'placeholder' => 'range rove.php'],
        ],
    ],
];

include 'page_content_admin.php';
?>