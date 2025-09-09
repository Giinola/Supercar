<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=demande_essai.php");
    exit();
}

include('db.php');

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
        $message = "✅ Votre demande a été bien reçue. ";
    } else {
        $message = "❌ Erreur : " . $bdd->error;
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

        
        .header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 15px 8%;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 100;
}

.navbar {
    flex-grow: 1;
    display: flex;
    justify-content: center; /* Centre le menu */
}

.navbar a {
    font-size: 16px;
    color: white;
    text-decoration: none;
    margin: 0 15px;
    transition: color 0.3s ease-in-out;
}

.navbar a:hover {
    color: #ff5733;
}

/* Styles spécifiques pour "Se connecter" et "S'inscrire" */
.auth-links {
    display: flex;
    gap: 15px;
    margin-right: 150px;
}

.auth-links a {
    font-size: 16px;
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 8px 15px;
    border-radius: 5px;
    background: #ff5733; 
}

.auth-links a:hover {
    background: white;
    color: #ff5733;
}


        
        .logo {
            font-size: 30px;
            color: #ff5733;
            text-decoration: none;
            font-weight: 600;
        }

        
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

        
        h2 {
            font-size: 22px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        
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

        
        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }


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
<header class="header">
        <a href="#" class="logo">SUPERCARS</a>
    
        <nav class="navbar">
            <a href="index.php">Accueil</a>
            <a href="Voitures.php">Modèles</a>
            <a href="demande_essai.php">Demande d'essai</a>
            <a href="Service.php">Services</a>
            <a href="Contact.php">Contact</a>
        </nav>
    
        <div class="auth-links">
            <a href="Login.php">Se connecter</a>
            <a href="inscription.php">S'inscrire</a>
        </div>
    </header>

    <div class="container">
    <h2><?= $contenu['titre_formulaire'] ?? '🚗 Demande d\'essai' ?></h2>

    <?php if (isset($_GET['success'])): ?>
        <p class="message"><?= $contenu['message_succes'] ?? 'Votre demande a été envoyée avec succès !' ?></p>
    <?php endif; ?>

    <form action="dash.inscri.php" method="POST">
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

        <button type="submit"><?= $contenu['texte_bouton'] ?? '📩 Envoyer la demandede' ?></button>
    </form>
</div>

</body>
</html>