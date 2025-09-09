<?php 
$bdd = new mysqli("localhost", "root", "", "supercar");
$bdd->set_charset("utf8");

$contenu = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $champ => $valeur) {
        mysqli_query($bdd, "UPDATE services SET valeur = '$valeur' WHERE nom_champ = '$champ'");
    }
}

$resultats = mysqli_query($bdd, "SELECT * FROM services");
while ($ligne = mysqli_fetch_assoc($resultats)) {
    $contenu[$ligne['nom_champ']] = $ligne['valeur'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Services</title>
    <style>
        :root {
            --jaune: #ffcc00;
            --noir: #121212;
            --gris-fonce: #1e1e1e;
            --gris-clair: #2a2a2a;
        }
        * {
            box-sizing: border-box;
        }
        body {
            background-color: var(--noir);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            margin-left: 220px;
            background: #000;
            padding: 20px;
            color: var(--jaune);
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .sidebar {
            height: 100vh;
            width: 220px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #1c1c1c;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(252, 191, 73, 0.2);
            overflow-y: auto;
        }
        .sidebar h4 {
            color: var(--jaune);
            text-align: center;
            font-size: 16px;
            margin: 20px 0 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #eaeaea;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s, color 0.3s;
            border-left: 4px solid transparent;
        }
        .sidebar a:hover {
            background-color: var(--jaune);
            color: #000;
        }
        .sidebar a.active {
            background-color: var(--jaune);
            color: #000;
            font-weight: bold;
            border-left: 4px solid #fff000;
        }
        .main-content {
            margin-left: 220px;
            padding: 40px;
            animation: fadeIn 0.6s ease-in-out;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }
        table {
            width: 100%;
            background: var(--gris-fonce);
            border-radius: 8px;
            overflow: hidden;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: 0 0 15px rgba(255, 204, 0, 0.1);
        }
        th {
            background: var(--jaune);
            color: #000;
            padding: 15px;
            font-size: 15px;
            text-transform: uppercase;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #333;
        }
        input[type="text"], textarea {
            width: 100%;
            background: var(--gris-clair);
            color: white;
            border: 1px solid #555;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            height: 80px;
        }
        img {
            max-width: 120px;
            border-radius: 4px;
            margin-top: 10px;
            border: 1px solid #444;
        }
        button {
            display: block;
            margin: 30px auto;
            background: var(--jaune);
            color: #000;
            font-weight: bold;
            padding: 12px 30px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #e6b800;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>Visualisation</h4>
    <a href="Acceuil.php"> Tableau de bord</a>
    <a href="Demande_essai.php"> Demandes d'essai</a>
    <a href="Utilisateurs.php"> Utilisateurs</a>
    <a href="Contact.php"> Messages</a>
    <div class="secondary-menu">
        <h4> Modification</h4>
        <a href="admin_acceuil.php"> Accueil</a>
        <a href="admin_voitures.php"> Voitures</a>
        <a href="admin_essai.php"> Demandes essai</a>
        <a href="admin_services.php" class="active">🛠️ Services</a>
        <a href="admin_contact.php"> Contact</a>
    </div>
</div>

<h1>Modifier les contenus de la page Services</h1>

<div class="main-content">
<form method="POST">
    <table>
        <tr><th>Champ</th><th>Valeur</th></tr>

        <?php
        function champ($label, $name, $type = 'text', $isImage = false) {
            global $contenu;
            echo "<tr><td>$label</td><td>";
            if ($type === 'textarea') {
                echo "<textarea name='$name'>" . ($contenu[$name] ?? '') . "</textarea>";
            } else {
                echo "<input type='text' name='$name' value='" . ($contenu[$name] ?? '') . "'>";
                if ($isImage && !empty($contenu[$name])) {
                    echo "<br><img src='" . htmlspecialchars($contenu[$name]) . "' alt='Image'>";
                }
            }
            echo "</td></tr>";
        }

        champ('Titre Bannière', 'titre_banner');
        champ('Image Fond Top', 'image_fond_top', 'text', true);
        champ('Titre Maintenance', 'titre_maintenance');
        champ('Photo Maintenance', 'photo_maintenance', 'text', true);
        champ('Texte Maintenance', 'texte_maintenance', 'textarea');
        champ('Titre Maintenance A', 'titre_maintenance_a');
        champ('Liste Maintenance A', 'liste_maintenance_a', 'textarea');
        champ('Titre Maintenance B', 'titre_maintenance_b');
        champ('Liste Maintenance B', 'liste_maintenance_b', 'textarea');
        champ('Titre Réparation', 'titre_reparation');
        champ('Photo Réparation', 'photo_réparation', 'text', true);
        champ('Texte Réparation', 'texte_reparation', 'textarea');
        champ('Titre Réparation A', 'titre_reparation_a');
        champ('Liste Réparation A', 'liste_reparation_a', 'textarea');
        champ('Titre Réparation B', 'titre_reparation_b');
        champ('Liste Réparation B', 'liste_reparation_b', 'textarea');
        champ('Titre Pièces', 'titre_pieces');
        champ('Photo Pièce', 'photp_piece', 'text', true);
        champ('Texte Pièces', 'texte_pieces', 'textarea');
        champ('Titre Pièces A', 'titre_pieces_a');
        champ('Liste Pièces A', 'liste_pieces_a', 'textarea');
        champ('Titre Pièces B', 'titre_pieces_b');
        champ('Liste Pièces B', 'liste_pieces_b', 'textarea');
        ?>

    </table>
    <button type="submit"> Enregistrer les modifications</button>
</form>
</div>
</body>
</html>
