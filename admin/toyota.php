<?php 
include 'menu.php';  
include 'db.php';

$table_name = 'toyota';
include 'ajout_voiture.php';
$contenu = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $champ => $valeur) {
        mysqli_query($bdd, "UPDATE toyota SET valeur = '$valeur' WHERE nom_champ = '$champ'");
    }
}

$resultats = mysqli_query($bdd, "SELECT * FROM toyota");
while ($ligne = mysqli_fetch_assoc($resultats)) {
    $contenu[$ligne['nom_champ']] = $ligne['valeur'];
}
?>

<style>
    body {
        background-color: #121212;
        color: #fff;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }
    h1 {
        text-align: center;
        background-color: #000;
        color: #ffcc00;
        padding: 20px;
        font-size: 28px;
        margin-left: 220px;
    }
    table {
        width: 90%;
        margin: 30px auto;
        border-collapse: collapse;
        background-color: #1e1e1e;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(255, 204, 0, 0.1);
    }
    th, td {
        padding: 15px;
        border-bottom: 1px solid #333;
    }
    th {
        background-color: #ffcc00;
        color: #000;
        font-size: 15px;
    }
    input[type="text"], textarea {
        width: 100%;
        background-color: #2a2a2a;
        color: #fff;
        border: 1px solid #444;
        padding: 10px;
        border-radius: 5px;
        font-size: 14px;
    }
    textarea {
        resize: vertical;
        height: 80px;
    }
    img {
        max-width: 100px;
        margin-top: 10px;
        border-radius: 4px;
        border: 1px solid #444;
    }
    button {
        display: block;
        margin: 30px auto;
        padding: 12px 30px;
        background-color: #ffcc00;
        border: none;
        border-radius: 25px;
        color: #000;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
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
    }
    .sidebar h4 {
        color: #ffcc00;
        text-align: center;
        font-size: 16px;
        margin: 20px 0 10px;
    }
    .sidebar a {
        display: block;
        padding: 12px 20px;
        color: #eaeaea;
        text-decoration: none;
        font-size: 14px;
    }
    .sidebar a:hover,
    .sidebar a.active {
        background-color: #ffcc00;
        color: #000;
        font-weight: bold;
    }
    .main-content {
        margin-left: 220px;
        padding: 30px;
    }
</style>

<div class="sidebar">
    <h4>Visualisation</h4>
     <a href="index.php">Tableau de bord</a>
    <a href="Demande_essai.php">Demandes d'essai</a>
    <a href="Utilisateurs.php">Utilisateurs</a>
    <a href="Contact.php">Messages</a>
    <div class="secondary-menu">
        <h4> Modification</h4>
        <a href="admin_acceuil.php">Accueil</a>
        <a href="admin_voitures.php" class="active">Voiture</a>
        <a href="admin_essais.php">Demandes essai</a>
        <a href="admin_services.php">Services</a>
        <a href="admin_contact.php">Contact</a>
    </div>
</div>

<h1> Administration - Toyota</h1>

<div class="main-content">
<form method="POST">
    <table>
        <tr><th>Champ</th><th>Valeur</th></tr>
        <tr><td>Texte en-tête</td><td><textarea name="en_tete"><?php echo isset($contenu['en_tete']) ? $contenu['en_tete'] : ''; ?></textarea></td></tr>
        <tr><td>Nom de la marque</td><td><textarea name="nom_marque"><?php echo isset($contenu['nom_marque']) ? $contenu['nom_marque'] : ''; ?></textarea></td></tr>

        <?php for ($i = 1; $i <= 3; $i++) { ?>
            <tr><td>Nom Voiture <?php echo $i; ?></td><td><textarea name="nom_voiture<?php echo $i; ?>"><?php echo isset($contenu['nom_voiture'.$i]) ? $contenu['nom_voiture'.$i] : ''; ?></textarea></td></tr>
            <tr><td>Image Voiture <?php echo $i; ?></td><td>
                <input type="text" name="image_voiture<?php echo $i; ?>" value="<?php echo isset($contenu['image_voiture'.$i]) ? $contenu['image_voiture'.$i] : ''; ?>">
                <br><img src="<?php echo isset($contenu['image_voiture'.$i]) ? $contenu['image_voiture'.$i] : ''; ?>" alt="">
            </td></tr>
            <tr><td>Description Voiture <?php echo $i; ?></td><td><textarea name="descri_voiture<?php echo $i; ?>"><?php echo isset($contenu['descri_voiture'.$i]) ? $contenu['descri_voiture'.$i] : ''; ?></textarea></td></tr>
            <tr><td>Prix Voiture <?php echo $i; ?></td><td><textarea name="prix_voiture<?php echo $i; ?>"><?php echo isset($contenu['prix_voiture'.$i]) ? $contenu['prix_voiture'.$i] : ''; ?></textarea></td></tr>
        <?php } ?>

    </table>
    <button type="submit"> Enregistrer les modifications</button> 
</form>
</div>
