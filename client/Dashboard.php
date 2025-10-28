<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Si l'utilisateur n'est pas connecté, rediriger vers la connexion
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<div class="dashboard">
    <div class="card">
        <h1>Supercar vous souhaite la bienvenue !
            Prenez le volant
        </h1>
        <p>Ravi de vous revoir. Profitez pleinement de nos services.</p>
        
        <div class="buttons">
            <a class="btn primary" href="index.php">Accueil</a>
            <a class="btn secondary" href="logout.php">Déconnexion</a>
        </div>
    </div>
</div>
<footer>
  <style>
    footer {
      background-color: #111;
      color: white;
      padding: 30px 20px;
      font-family: 'Segoe UI', sans-serif;
    }

    .footer-content {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .footer-section {
      flex: 1 1 200px;
    }

    .footer-section h3 {
      color: #ff5733;
      margin-bottom: 10px;
      font-size: 1.1em;
    }

    .footer-section ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-section li {
      margin-bottom: 8px;
      font-size: 0.95em;
    }

    .socials {
      display: flex;
      gap: 10px;
      margin-top: 5px;
    }

    .socials a img {
      width: 22px;
      filter: brightness(0) invert(1);
      transition: transform 0.3s ease;
    }

    .socials a:hover img {
      transform: scale(1.1);
      filter: brightness(0) saturate(100%) sepia(1) hue-rotate(-20deg);
    }

    .footer-bottom {
      border-top: 1px solid #333;
      margin-top: 30px;
      padding-top: 15px;
      text-align: center;
      font-size: 0.85em;
    }

    .footer-links {
      margin-top: 8px;
    }

    .footer-links a {
      margin: 0 10px;
      color: #ccc;
      text-decoration: none;
      transition: color 0.3s;
    }

    .footer-links a:hover {
      color: #ff5733;
    }

    @media (max-width: 768px) {
      .footer-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .footer-section {
        flex: none;
      }
    }
  </style>

  
</body>
</html>

<style>/* Importer une police moderne */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

/* Style global */
body {
    font-family: 'Poppins', sans-serif;
    background: url('IMAGES/bv.jpg') no-repeat center center/cover; /* Arrière-plan couvrant tout */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Conteneur principal */
.dashboard {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

/* Carte stylée avec dégradé orange et blanc */
.card {
    background: linear-gradient(135deg, #FF8008, #FFFFFF);
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    text-align: center;
    width: 90%;
    max-width: 400px;
    animation: fadeIn 1s ease-in-out;
}

/* Animation d’apparition */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Titre */
h1 {
    color: white;
    font-size: 2em;
    font-weight: 600;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

/* Texte */
p {
    font-size: 1.1em;
    color: #fff;
    font-weight: 400;
    margin-bottom: 20px;
}

/* Boutons */
.buttons {
    margin-top: 20px;
}

.btn {
    display: inline-block;
    padding: 12px 20px;
    margin: 10px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    font-size: 1em;
    transition: 0.3s ease-in-out;
}

/* Bouton principal */
.primary {
    background: #007bff;
    color: white;
    box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
}

.primary:hover {
    background: #0056b3;
    box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
}

/* Bouton secondaire */
.secondary {
    background: #ff4b5c;
    color: white;
    box-shadow: 0 4px 10px rgba(255, 75, 92, 0.2);
}

.secondary:hover {
    background: #d63345;
    box-shadow: 0 6px 15px rgba(255, 75, 92, 0.3);
}

</style>