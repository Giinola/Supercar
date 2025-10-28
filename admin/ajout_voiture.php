<?php
// Connexion à la base de données
$host = "mysql-ginola.alwaysdata.net";  
$login = "ginola";                   
$pass = "AlwaysGinola1";            
$dbname = "ginola_supercar";        

$bdd = new mysqli($host, $login, $pass, $dbname);

if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);  
}
$bdd->set_charset('utf8mb4'); // Utilisation de l'UTF8 pour les accents et caractères spéciaux

// Message de succès ou d'erreur
$msg = '';

// Soumission du formulaire pour ajouter une nouvelle voiture
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['add_car'])
    && isset($_POST['table']) 
    && !empty($_POST['table']) // Vérifie que la table est définie
) {
    $table_name = $_POST['table']; // La table dépend du choix de la marque

    // Nettoyage des données d'entrée
    $nom_complet        = mysqli_real_escape_string($bdd, trim($_POST['nom_complet'] ?? ''));
    $classe             = mysqli_real_escape_string($bdd, trim($_POST['classe'] ?? ''));
    $carrosserie        = mysqli_real_escape_string($bdd, trim($_POST['carrosserie'] ?? ''));
    $description_courte = mysqli_real_escape_string($bdd, trim($_POST['description_courte'] ?? ''));
    $chemin_image       = mysqli_real_escape_string($bdd, trim($_POST['chemin_image'] ?? ''));
    $puissance_ch       = mysqli_real_escape_string($bdd, trim($_POST['puissance_ch'] ?? ''));
    $prix_estime        = mysqli_real_escape_string($bdd, trim($_POST['prix_estime'] ?? ''));

    // Vérification si le nom du modèle est bien rempli
    if ($nom_complet === '') {
        $_SESSION['msg'] = "Le nom du modèle est obligatoire."; // Message d'erreur
    } else {
        // Insertion dans la table sélectionnée dynamiquement
        $sql = "INSERT INTO `$table_name` (nom_complet, classe, carrosserie, description_courte, chemin_image, puissance_ch, prix_estime) 
                VALUES ('$nom_complet', '$classe', '$carrosserie', '$description_courte', '$chemin_image', '$puissance_ch', '$prix_estime')";
        
        // Exécution de la requête SQL
        $ok = mysqli_query($bdd, $sql);
        
        if ($ok) {
            $_SESSION['msg'] = "✅ Voiture ajoutée avec succès."; // Message de succès
            // Rediriger l'utilisateur pour éviter la soumission multiple
        } else {
            $_SESSION['msg'] = "⚠️ Erreur: " . mysqli_error($bdd); // Message d'erreur SQL
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<style>
.addcar { width:100%; box-sizing:border-box; padding: 0 16px; }
.addcar-card{
  max-width: 860px;
  margin: 24px auto 120px;
  background: #1e1e1e;
  border: 1px solid #444;
  border-radius: 12px;
  padding: 16px;
  color: #fff;
  font-family: Poppins, Arial, sans-serif;
  box-shadow: 0 8px 22px rgba(0,0,0,.35);
}
.addcar h2{ margin:0 0 12px; font-size:20px; color:#ffcc00; }
.addcar .row{ display:flex; gap:12px; flex-wrap:wrap; }
.addcar .col{ flex:1; min-width:220px; }
.addcar label{ display:block; font-weight:600; color:#cfd3da; margin-bottom:6px; }
.addcar input[type="text"], .addcar textarea{
  width:100%; background:#2a2a2a; color:#fff; border:1px solid #444;
  border-radius:8px; padding:10px; font-size:14px;
}
.addcar textarea{ min-height:90px; resize:vertical; }
.addcar .actions{ margin-top:12px; display:flex; gap:10px; justify-content:flex-end; }
.addcar button{
  background:#ffcc00; color:#111; border:0; border-radius:999px;
  padding:10px 16px; font-weight:800; cursor:pointer;
}
.addcar .flash{
  background:#333; color:#ffcc00; padding:8px 10px; border-radius:8px;
  margin-bottom:10px; display:inline-block;
}

@media (max-width: 992px){
  .addcar-card{ margin:16px auto 100px; }
}
</style>
<div class="addcar">
    <div class="addcar-card">
        <h2>Ajouter une nouvelle voiture</h2>

        <!-- Affichage du message de succès ou d'erreur -->
        <?php if (isset($_SESSION['msg'])): ?>
            <div class="flash"><?php echo htmlspecialchars($_SESSION['msg']); ?></div>
            <?php unset($_SESSION['msg']); // Supprime le message après l'affichage ?>
        <?php endif; ?>

       <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="table" value="voiture">

            <!-- Choisir la marque de la voiture -->
            <div class="row">
                <div class="col">
                    <label for="table">Choisir la marque de la voiture *</label>
                    <select id="table" name="table" required>
                        <option value="Mercedes">Mercedes</option>
                        <option value="ferrari">ferrari</option>
                        <option value="range_rover">Range Rover</option>
                        <option value="mclaren">McLaren</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="nom_complet">Nom Complet *</label>
                    <input type="text" id="nom_complet" name="nom_complet" required>
                </div>
                <div class="col">
                    <label for="classe">Classe</label>
                    <input type="text" id="classe" name="classe">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="chemin_image">Chemin de l'image</label>
                    <input type="text" id="chemin_image" name="chemin_image">
                </div>
                <div class="col">
                    <label for="prix_estime">Prix Estimé</label>
                    <input type="text" id="prix_estime" name="prix_estime">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="carrosserie">Carrosserie</label>
                    <input type="text" id="carrosserie" name="carrosserie">
                </div>
                <div class="col">
                    <label for="puissance_ch">Puissance (ch)</label>
                    <input type="text" id="puissance_ch" name="puissance_ch">
                </div>
            </div>

           <div class="row">
                <div class="col" style="min-width:100%;">
                    <label for="description_courte">Description Courte</label>
                    <textarea id="description_courte" name="description_courte"></textarea>
                </div>
            </div>

            <div class="actions">
                <button type="submit" name="add_car" value="1">Ajouter la voiture</button>
            </div>
        </form>
    </div>
</div>
