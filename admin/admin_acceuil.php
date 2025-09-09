<?php 
$bdd = new mysqli("localhost", "root", "", "supercar");
$bdd->set_charset("utf8");

// Initialisation
$contenu = [];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $champ => $valeur) {
        mysqli_query($bdd, "UPDATE accueil SET valeur = '$valeur' WHERE nom_champ = '$champ'");
    }
}

$resultats = mysqli_query($bdd, "SELECT * FROM accueil");
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
        background-color: rgb(0, 0, 0);
        color: #ffcc00;
        padding: 20px;
        font-size: 32px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        margin-bottom: 30px;
        margin-left: 220px;
    }

    table {
        width: 90%;
        margin: auto;
        border-collapse: collapse;
        background-color: #1e1e1e;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(255, 204, 0, 0.2);
    }

    th, td {
        padding: 15px 20px;
        text-align: left;
    }

    th {
        background-color: #ffcc00;
        color: #000;
        font-size: 16px;
        letter-spacing: 1px;
    }

    tr:nth-child(even) {
        background-color: #1a1a1a;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 10px;
        background-color: #2a2a2a;
        color: #fff;
        border: 1px solid #444;
        border-radius: 5px;
        font-size: 14px;
        transition: border 0.3s;
    }

    input[type="text"]:focus,
    textarea:focus {
        border-color: #ffcc00;
        outline: none;
    }

    img {
        max-width: 150px;
        height: auto;
        margin-top: 10px;
        border-radius: 4px;
        border: 1px solid #444;
    }

    button[type="submit"] {
        display: block;
        margin: 30px auto;
        padding: 12px 30px;
        background-color: #ffcc00;
        border: none;
        border-radius: 30px;
        font-size: 16px;
        font-weight: bold;
        color: #000;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #e6b800;
    }

    .sidebar {
        height: 100vh;
        width: 220px;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #2a2a2a;
        padding-top: 20px;
        box-shadow: 2px 0 5px rgba(252, 191, 73, 0.3);
        display: flex;
        flex-direction: column;
        z-index: 1000;
    }

    .sidebar h4 {
        color: #fcbf49;
        text-align: center;
        margin-bottom: 15px;
        font-size: 16px;
        font-weight: 600;
    }

    .sidebar a {
        padding: 12px 20px;
        text-decoration: none;
        color: #eaeaea;
        display: block;
        font-size: 15px;
        font-weight: 500;
    }

    .sidebar a:hover {
        background-color: #fcbf49;
        color: #000;
    }

    .sidebar a.active {
        background-color: #2a2a2a;
        color: #fcbf49;
    }

    .sidebar .secondary-menu {
        margin-top: 20px;
        border-top: 1px solid #444;
        padding-top: 15px;
    }

    .topbar {
        background-color: #2a2a2a;
        padding: 20px 40px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        margin-left: 220px;
    }

    .main-content {
        margin-left: 220px;
        padding: 0 20px;
        box-sizing: border-box;
        width: calc(100% - 220px);
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            position: relative;
            height: auto;
        }

        .topbar,
        .header-section,
        .main-content {
            margin-left: 0;
            width: 100%;
        }
    }

    .logo {
        font-size: 26px;
        font-weight: 700;
        color: #fcbf49;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
</style>

<div class="sidebar">
    <div>
        <h4>Visualisation</h4>
        <a href="Acceuil.php">Tableau de bord</a>
        <a href="Demande_essai.php">Demandes d'essai</a>
        <a href="Utilisateurs.php">Utilisateurs</a>
        <a href="Contact.php">Contact</a>
        <div class="secondary-menu">
            <h4>Modification</h4>
            <a href="admin_acceuil.php">Accueil</a>
            <a href="admin_voitures.php">Voiture</a>
            <a href="admin_essai.php">Demandes essai</a>
            <a href="admin_services.php">Services</a>
            <a href="Admin_contact.php">Contact</a>
        </div>
    </div>
</div>

<h1> Administration - Page d'accueil</h1>

<div class="main-content">
<form method="POST">
    <table>
        <tr>
            <th>Champ</th>
            <th>Valeur</th>
        </tr>
        <tr>
            <td>Titre Accueil</td>
            <td><input type="text" name="titre_accueil" value="<?php echo isset($contenu['titre_accueil']) ? $contenu['titre_accueil'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>Texte Accueil</td>
            <td><textarea name="texte_accueil"><?php echo isset($contenu['texte_accueil']) ? $contenu['texte_accueil'] : ''; ?></textarea></td>
        </tr>
        <tr>
            <td>Image Accueil</td>
            <td>
                <input type="text" name="image_accueil" value="<?php echo isset($contenu['image_accueil']) ? $contenu['image_accueil'] : ''; ?>">
                <br><img src="<?php echo isset($contenu['image_accueil']) ? $contenu['image_accueil'] : ''; ?>" alt="Image Accueil">
            </td>
        </tr>
        <tr>
            <td>Titre À Propos</td>
            <td><input type="text" name="titre_apropos" value="<?php echo isset($contenu['titre_apropos']) ? $contenu['titre_apropos'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>Paragraphe 1</td>
            <td><textarea name="p1_apropos"><?php echo isset($contenu['p1_apropos']) ? $contenu['p1_apropos'] : ''; ?></textarea></td>
        </tr>
        <tr>
            <td>Paragraphe 2</td>
            <td><textarea name="p2_apropos"><?php echo isset($contenu['p2_apropos']) ? $contenu['p2_apropos'] : ''; ?></textarea></td>
        </tr>
        <tr>
            <td>Bouton À Propos</td>
            <td><input type="text" name="bouton_apropos" value="<?php echo isset($contenu['bouton_apropos']) ? $contenu['bouton_apropos'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>Image À Propos</td>
            <td>
                <input type="text" name="image_apropos" value="<?php echo isset($contenu['image_apropos']) ? $contenu['image_apropos'] : ''; ?>">
                <br><img src="<?php echo isset($contenu['image_apropos']) ? $contenu['image_apropos'] : ''; ?>" alt="Image À Propos">
            </td>
        </tr>
        <tr>
            <td>Carrousel</td>
            <td>
                <input type="text" name="carousel_item" value="<?php echo isset($contenu['carousel_item']) ? $contenu['carousel_item'] : ''; ?>">
                <br><img src="<?php echo isset($contenu['carousel_item']) ? $contenu['carousel_item'] : ''; ?>" alt="Image Carrousel">
            </td>
        </tr>
    </table>
    <button type="submit">Enregistrer les modifications</button>
</form>
</div>
