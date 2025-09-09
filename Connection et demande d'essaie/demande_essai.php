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

    $sql = "INSERT INTO demandes_essai (nom, prenom, email, voiture, date_essai, date_demande) 
            VALUES ('$nom', '$prenom', '$email', '$voiture', '$date_essai', NOW())";

    if ($bdd->query($sql) === TRUE) {
        $message = "✅ Votre demande a été bien reçue. Nous allons vous envoyer un email de confirmation.";
    } else {
        $message = "❌ Erreur : " . $bdd->error;
    }
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

        /* ✅ Menu fixe avec une fond semi-transparent */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 8%;
            background: rgba(255, 255, 255, 0.9); /* Fond semi-transparent */
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }

        /* ✅ Logo */
        .logo {
            font-size: 30px;
            color: #ff5733;
            text-decoration: none;
            font-weight: 600;
        }

        /* ✅ Liens de navigation */
        .navbar a {
            display: inline-block;
            font-size: 18px;
            color: #222; /* Couleur des liens */
            text-decoration: none;
            font-weight: 500;
            margin: 0 20px;
            transition: 0.3s;
        }

        /* ✅ Survol des liens */
        .navbar a:hover,
        .navbar a.active {
            color: #ff5733; /* Couleur au survol */
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
<header class="header">
    <a href="#" class="logo">SUPERCARS</a>
    <nav class="navbar">
        <a href="index.html">Accueil</a>
        <a href="Modèles.html">Modèles</a>
        <a href="demande_essai.php">Demande d'essai</a>
        <a href="Service.html">Services</a>
        <a href="Contact.html">Contact</a>
        <a href="Login.php" class="nav-link">Se connecter</a>
        <a href="inscription.html" class="nav-link">S'inscrire</a>
    </nav>
</header>

<div class="container">
    <h2>🚗 Demande d'essai</h2>

    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

    <form action="demande_essai.php" method="POST">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="email" name="email" placeholder="Email" required>

        <select name="voiture" required>
            <optgroup label="🚀 Mercedes">
                <option value="AMG GT">AMG GT</option>
                <option value="CLS 63 MG">CLS 63 MG</option>
                <option value="Classe G">Classe G</option>
                <option value="Maybach">Maybach</option>
            </optgroup>
            <optgroup label="🏆 Ford">
                <option value="Ranger Raptor">Ranger Raptor</option>
                <option value="F-150">F-150</option>
                <option value="Focus">Focus</option>
                <option value="Explorer">Explorer</option>
            </optgroup>
            <optgroup label="🔥 Toyota">
                <option value="Corolla">Corolla</option>
                <option value="RAV4">RAV4</option>
                <option value="Camry">Camry</option>
            </optgroup>
            <optgroup label="⚡ Nissan">
                <option value="GTR">GTR</option>
                <option value="Magnite">Magnite</option>
                <option value="X-Trail">X-Trail</option>
                <option value="Qashqai">Qashqai</option>
            </optgroup>
        </select>

        <input type="date" name="date_essai" required>

        <button type="submit">📩 Envoyer la demande</button>
    </form>
</div>

</body>
</html>
