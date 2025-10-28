<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    
    header('Location: Login.php');
    exit; 
}



$host = "mysql-ginola.alwaysdata.net";  
$login = "ginola";                  
$pass = "AlwaysGinola1";            
$dbname = "ginola_supercar";        
 
 
$bdd = new mysqli($host, $login, $pass, $dbname);
 
 
if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);  
}
 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $voiture = $_POST['voiture'];  
    $date_essai = $_POST['date_essai'];
    $Heure= $_POST['Heure'];

    $sql = "INSERT INTO demandes_essai (nom, prenom, email, voiture, date_essai,Heure) 
            VALUES ('$nom', '$prenom', '$email', '$voiture', '$date_essai', '$Heure')";

    if ($bdd->query($sql) === TRUE) {
        $message = " Votre demande a été bien reçue. ";
    } else {
        $message = " Erreur : " . $bdd->error;
    }
}

$contenu = [];
$result = $bdd->query("SELECT * FROM essai");
while ($row = $result->fetch_assoc()) {
    $contenu[$row['nom_champ']] = $row['valeur'];
}
function genererOptions($donnees) {
    $options = explode("\n", $donnees);
    $html = '';
    foreach ($options as $opt) {
        $opt = trim($opt);
        if (!empty($opt)) {
            $html .= "<option value=\"$opt\">$opt</option>\n";
        }
    }
    return $html;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'essai</title>
    <style>
       /* 🌆 Arrière-plan avec un effet flou */
        body {
            font-family: 'Poppins', sans-serif;
            background: url('IMAGES/dm.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

      

        /* 💎 Carte moderne */
        .container {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            width: 400px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            color: #333;
            position: relative;
            animation: fadeIn 0.8s ease-in-out;
        }

        /* 🏷️ Titres modernes */
        h2 {
            font-size: 22px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        /* ✅ Message de confirmation visible */
        .message {
            background: #dfffcf;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: bold;
            color: #3a8b42;
            border-left: 5px solid #3a8b42;
            text-align: left;
        }

        /* 📄 Formulaire bien structuré */
        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }

        /* 📝 Champs du formulaire */
        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            font-weight: 500;
            outline: none;
            transition: 0.3s;
        }

        input:focus, select:focus {
            border-color: #ff8008;
        }

        /* 🔘 Bouton moderne */
        button {
            background: linear-gradient(135deg, #ff8008, #ffcc00);
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s ease;
            box-shadow: 0px 4px 15px rgba(255, 128, 8, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        button:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 20px rgba(255, 128, 8, 0.6);
        }
    </style>
</head>
<body>
    <header>
<?php include "navbar.php"; ?>
     </header>
    <div class="container">
    <h2><?= $contenu['titre_formulaire'] ?? '🚗 Demande d\'essai' ?></h2>


    <form action="DE.php" method="POST">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="time" name="Heure" min="08:00" max="14:00" required>

        <select name="voiture" required>
            <optgroup label="<?= $contenu['label_mercedes'] ?? 'Mercedes' ?>">
                <?= genererOptions($contenu['car_option_merco'] ?? '') ?>
            </optgroup>
            <optgroup label="<?= $contenu['label_ford'] ?? 'Ford' ?>">
                <?= genererOptions($contenu['car_option_ford'] ?? '') ?>
            </optgroup>
            <optgroup label="<?= $contenu['label_toyota'] ?? 'Toyota' ?>">
                <?= genererOptions($contenu['car_option_toyota'] ?? '') ?>
            </optgroup>
            <optgroup label="<?= $contenu['label_nissan'] ?? 'Nissan' ?>">
                <?= genererOptions($contenu['car_option_nissan'] ?? '') ?>
            </optgroup>
        </select>

        <input type="date" name="date_essai" required>

        <button type="submit"><?= $contenu['texte_bouton'] ?? ' Envoyer la demande' ?></button>
    </form>
</div>

</body>
</html>