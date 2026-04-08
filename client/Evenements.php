<?php
$host = "mysql-ginola.alwaysdata.net";  
$login = "ginola";                  
$pass = "AlwaysGinola1";            
$dbname = "ginola_supercar";        
 
 
$bdd = new mysqli($host, $login, $pass, $dbname);
 
 
if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);  
}
 

$contenu = [];
$resultats = mysqli_query($bdd, "SELECT * FROM Evenements "); 


if ($resultats) {
    while ($ligne = mysqli_fetch_assoc($resultats)) {

        $contenu[$ligne['id']] = $ligne;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUPERCARS - événements</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    


<body>
    <header>
<?php include "navbar.php"; ?>
     </header>
 <section class="brand ford">
    <p style="text-align:center; max-width:800px; margin:0 auto 30px;">
</p>
 <h1>Evenements</h1>
<p>Toutes les évenemnts de SUPERCAR</p>
    <?php
foreach ($contenu as $event) {
    $nom_event = trim($event['nom_event']);
    $image_event = trim($event['image_event'] ?? '');
    if ($img !== '') $img = str_replace(' ', '%20', $img);
    $description = $event['description'] ?? 'Description non disponible';
    $prix_inscription = $event['prix_inscription'] ?? 'Prix non disponible';
    $date_heure = $event['date_heure'] ?? 'Puissance non disponible';

    $nom_eventH  = htmlspecialchars($nom_event, ENT_QUOTES, 'UTF-8');
    $image_eventH  = htmlspecialchars($image_event, ENT_QUOTES, 'UTF-8');
    $descriptionH = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    $prix_inscriptionH = htmlspecialchars($prix_inscription, ENT_QUOTES, 'UTF-8');
    $date_heureH = htmlspecialchars($date_heure, ENT_QUOTES, 'UTF-8');
    ?>
    <div class="car-card">
        <h4><?= $nom_eventH?></h4>
        <?php if ($image_eventH): ?><img src="<?= $image_eventH ?>" alt="<?= $nom_eventH ?>"><?php endif; ?>
        <p><?= $descH ?></p>
        <p><strong>PRIX: <?= $prix_inscriptionH ?>$</strong></p>
        <div class="try-button-container">
            <button class="info-button" onclick="toggleInfo(this)">Voir la date et heure</button>
            <div class="extra-info" style="display:none;">
                <p><strong>Date et heure</strong> <?=  $date_heureH?></p>
            </div>
        </div>
    </div>
<?php } ?>