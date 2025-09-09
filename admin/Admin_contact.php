<?php 
$bdd = new mysqli("localhost", "root", "", "supercar");
$bdd->set_charset("utf8");

$contenu = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $champ => $valeur) {
        mysqli_query($bdd, "UPDATE contact_contenu SET valeur = '$valeur' WHERE nom_champ = '$champ'");
    }
}

$resultats = mysqli_query($bdd, "SELECT * FROM  contact_contenu");
while ($ligne = mysqli_fetch_assoc($resultats)) {
    $contenu[$ligne['nom_champ']] = $ligne['valeur'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Contact</title>
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
    <a href="Acceuil.php">Tableau de bord</a>
    <a href="Demande_essai.php">Demandes d'essai</a>
    <a href="Utilisateurs.php">Utilisateurs</a>
    <a href="Contact.php">Messages</a>
    <div class="secondary-menu">
        <h4> Modification</h4>
        <a href="admin_acceuil.php">Accueil</a>
        <a href="admin_voitures.php">Voitures</a>
        <a href="admin_essai.php">Demandes essai</a>
        <a href="admin_services.php">Services</a>
        <a href="admin_contact.php" class="active">Contact</a>
    </div>
</div>

<h1> Modifier la page de contact</h1>

<div class="main-content">
<form method="POST">
    <table>
        <tr><th>Champ</th><th>Valeur</th></tr>
        <tr>
            <td>Titre Informations de contact</td>
            <td><input type="text" name="titre_infos_contact" value="<?php echo htmlspecialchars($contenu['titre_infos_contact'] ?? ''); ?>"></td>
        </tr>
        <tr>
            <td>Téléphone</td>
            <td><input type="text" name="contact_tel" value="<?php echo htmlspecialchars($contenu['contact_tel'] ?? ''); ?>"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="contact_email" value="<?php echo htmlspecialchars($contenu['contact_email'] ?? ''); ?>"></td>
        </tr>
        <tr>
            <td>Adresse</td>
            <td><input type="text" name="contact_adresse" value="<?php echo htmlspecialchars($contenu['contact_adresse'] ?? ''); ?>"></td>
        </tr>
        <tr>
            <td>Titre Formulaire</td>
            <td><input type="text" name="titre_formulaire" value="<?php echo htmlspecialchars($contenu['titre_formulaire'] ?? ''); ?>"></td>
        </tr>
        <tr>
            <td>Texte du bouton</td>
            <td><input type="text" name="texte_bouton" value="<?php echo htmlspecialchars($contenu['texte_bouton'] ?? ''); ?>"></td>
        </tr>
        <tr>
            <td>Google Maps (iframe)</td>
            <td><textarea name="iframe_map"><?php echo htmlspecialchars($contenu['iframe_map'] ?? ''); ?></textarea></td>
        </tr>
    </table>
    <button type="submit">💾 Enregistrer</button>
</form>
</div>
</body>
</html>
