<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

include('db.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $sql = "SELECT * FROM admin WHERE email = '$email' AND mot_de_passe = '$mot_de_passe'";
    $result = $bdd->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit(); 
    } else {
        $error_message = "Identifiants incorrects";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SUPERCARS</title>
    <style>
        /* ====== GLOBAL ====== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* ====== IMAGE DE FOND ====== */
        body {
            background: url('IMAGES/cn.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        /* ====== HEADER (NAVBAR) ====== */
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


        .logo {
            font-size: 24px;
            color: #ff5733;
            font-weight: bold;
            text-decoration: none;
        }

        /* ====== CONTAINER FORMULAIRE (DÉGRADÉ) ====== */
        .container {
            background: linear-gradient(135deg, white, #ff5733);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
            margin-top: 80px;
        }

        /* ====== Titre ====== */
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* ====== Message d'erreur ====== */
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }

        /* ====== Champs du formulaire ====== */
        label {
            display: block;
            font-weight: bold;
            margin: 10px 0 5px;
            color: #444;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease-in-out;
        }

        input:focus {
            border-color: #ff5733;
            outline: none;
            box-shadow: 0 0 10px rgba(255, 87, 51, 0.3);
        }

        /* ====== Bouton ====== */
        button {
            width: 100%;
            padding: 12px;
            background: #ff5733;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 15px;
        }

        button:hover {
            background: #d9461e;
        }

        /* ====== Responsive ====== */
        @media (max-width: 400px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<!-- ====== HEADER ====== -->
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


<!-- ====== CONTAINER FORMULAIRE ====== -->
<div class="container">
    <h2>Connexion</h2>

    <?php if (isset($error_message)): ?>    
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" name="mot_de_passe" required>

        <button type="submit">Se connecter</button>
    </form>
</div>


</body>
</html>
