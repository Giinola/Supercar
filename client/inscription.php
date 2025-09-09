<?php
$serveur = "localhost";
$utilisateur = "root";  
$mot_de_passe = "";     
$base_de_donnees = "supercar"; 


$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Erreur de connexion : " . $connexion->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom             = $_POST["nom"];
    $prenom          = $_POST["prenom"];
    $email           = $_POST["email"];
    $nom_utilisateur = $_POST["nom_utilisateur"];
    $mot_de_passe    = $_POST["mot_de_passe"];

    $sql = "INSERT INTO utilisateur (nom, prenom, email, nom_utilisateur, mot_de_passe) 
            VALUES ('$nom', '$prenom', '$email', '$nom_utilisateur', '$mot_de_passe')";

    if ($connexion->query($sql) === TRUE) {
        header("Location:dash.inscri.php");
    } else {
        echo "Erreur : " . $connexion->error;
    }
}

// Fermer la connexion
$connexion->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Inscription</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background: #121212; 
    color: white; 
}

        .logo {
            font-size: 24px;
            color: #ff5733;
            font-weight: bold;
            text-decoration: none;
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


.auth-links {
    display: flex;
    gap: 15px;
}

.auth-links a {
    font-size: 16px;
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 8px 15px;
    border-radius: 5px;
    background: #ff5733; /* Ajoute un fond pour les distinguer */
}

.auth-links a:hover {
    background: white;
    color: #ff5733;
}

        .wrapper {
            margin-top: 100px;
            width: 420px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #fff;
            border-radius: 10px;
            padding: 30px 40px;
        }

        .wrapper h1 {
            font-size: 36px;
            text-align: center;
        }

        .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            margin: 20px 0;
            border-radius: 40px;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: #222;
            border: none;
            outline: none;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 40px;
            font-size: 16px;
            color: #fff;
            padding: 20px 45px 20px 20px;
        }

        .input-box input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .wrapper .btn {
            width: 100%;
            height: 45px;
            background: #fff;
            border: none;
            outline: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: 600;
            transition: 0.3s;
        }

        .wrapper .btn:hover {
            background: #ddd;
        }

        .register-link {
            font-size: 14.5px;
            text-align: center;
            margin: 20px 0 15px;
        }

        .register-link p a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link p a:hover {
            text-decoration: underline;
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
<div class="wrapper">
    <form action="inscription.php" method="POST">
        <h1>Inscription</h1>
        
        <div class="input-box">
            <input type="text" name="nom" placeholder="Nom" required>
        </div>

        <div class="input-box">
            <input type="text" name="prenom" placeholder="Prénom" required>
        </div>

        <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-box">
            <input type="text" name="nom_utilisateur" placeholder="Nom d'utilisateur" required>
        </div>

        <div class="input-box">
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
        </div>

        <button type="submit" class="btn">S'inscrire</button>

        <div class="register-link">
            <p>Vous avez déjà un compte? <a href="Login.php">Se connecter</a></p>
        </div>
    </form>
</div>


</body>
</html>

