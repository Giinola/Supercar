<?php
$bdd = new mysqli("localhost", "root", "", "supercar");
$bdd->set_charset("utf8");

$contenu = [];
$resultats = mysqli_query($bdd, "SELECT * FROM services");
while ($ligne = mysqli_fetch_assoc($resultats)) {
    $contenu[$ligne['nom_champ']] = $ligne['valeur'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUPERCARS - Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            color: #333;
            margin: 0;
            padding: 0;
            overflow-x: hidden; /* Pour empêcher le défilement horizontal */
        }
        .top-background {
            position: absolute;
            top: 80px;
            left: 0;
            width: 100%;
            height: 400px;
            background: url('IMAGES/Fond\ service.jpeg') no-repeat center center/cover;
            z-index: -1;
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
    background: #ff5733; /* Ajoute un fond pour les distinguer */
}

.auth-links a:hover {
    background: white;
    color: #ff5733;
}

        .logo {
            font-size: 35px;
            color: #ff5733;
            text-decoration: none;
            font-weight: 600;
        }

        /* Animation de glissement pour le logo et le menu */
        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateX(-100%);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .banner {
            width: 100%;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            font-size: 36px;
            font-weight: 600;
            opacity: 0;
            animation: slideInBanner 1s forwards 0.5s; /* L'effet du texte de la bannière */
        }

        @keyframes slideInBanner {
            0% {
                opacity: 0;
                transform: translateY(-100px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .service-section {
            display: flex;
            align-items: center;
            max-width: 1200px;
            margin: 80px auto;
            padding: 20px;
            gap: 40px;
            opacity: 0;
            animation: slideInServices 1s forwards 1s; /* Animation des services */
        }

        @keyframes slideInServices {
            0% {
                opacity: 0;
                transform: translateX(100px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .service-section img {
            width: 50%;
            border-radius: 10px;
        }
        .service-info {
            width: 50%;
        }
        .service-info h2 {
            font-size: 28px;
            color: #ff5733;
        }
        .service-info p {
            font-size: 16px;
            color: #666;
        }
        .btn {
            display: inline-block;
            background: #ff5733;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
        }

        /* Hidden content */
        .hidden-content {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background:rgb(255, 249, 249);
            border-left: 4px solid #ff5733;
        }

        /* Checkbox to toggle content */
        .toggle-content {
            display: none;
        }

        .toggle-content + label {
            cursor: pointer;
        }

        .toggle-content:checked + label + .hidden-content {
            display: block;
        }
    </style>
</head>
<body>
    <div class="top-background"></div>
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
    
    <div class="banner">NOS SERVICES</div>

<section class="service-section">
    <img src="IMAGES/Maintenance.jpg" alt="Maintenance">
    <div class="service-info">
        <h2>Maintenance</h2>
        <p><?php echo nl2br($contenu['texte_maintenance'] ?? ''); ?></p>
        <input type="checkbox" id="maintenance-toggle" class="toggle-content">
        <label for="maintenance-toggle" class="btn">Voir plus</label>
        <div id="maintenance-details" class="hidden-content">
            <ul>
                <h4><?php echo $contenu['titre_maintenance_a'] ?? ''; ?></h4>
                <?php foreach (explode("\n", $contenu['liste_maintenance_a'] ?? '') as $item) echo "<li>$item</li>"; ?>
            </ul>
            <ul>
                <h4><?php echo $contenu['titre_maintenance_b'] ?? ''; ?></h4>
                <?php foreach (explode("\n", $contenu['liste_maintenance_b'] ?? '') as $item) echo "<li>$item</li>"; ?>
            </ul>
        </div>
    </div>
</section>

<section class="service-section">
    <img src="IMAGES/Réparation.jpg" alt="Réparation">
    <div class="service-info">
        <h2>Réparation</h2>
        <p><?php echo nl2br($contenu['texte_reparation'] ?? ''); ?></p>
        <input type="checkbox" id="reparation-toggle" class="toggle-content">
        <label for="reparation-toggle" class="btn">Voir plus</label>
        <div id="reparation-details" class="hidden-content">
            <ul>
                <h4><?php echo $contenu['titre_reparation_a'] ?? ''; ?></h4>
                <?php foreach (explode("\n", $contenu['liste_reparation_a'] ?? '') as $item) echo "<li>$item</li>"; ?>
            </ul>
            <ul>
                <h4><?php echo $contenu['titre_reparation_b'] ?? ''; ?></h4>
                <?php foreach (explode("\n", $contenu['liste_reparation_b'] ?? '') as $item) echo "<li>$item</li>"; ?>
            </ul>
        </div>
    </div>
</section>

<section class="service-section">
    <img src="IMAGES/Pièce.jpg" alt="Pièces de rechange">
    <div class="service-info">
        <h2>Pièces de Rechange</h2>
        <p><?php echo nl2br($contenu['texte_pieces'] ?? ''); ?></p>
        <input type="checkbox" id="pieces-toggle" class="toggle-content">
        <label for="pieces-toggle" class="btn">Voir plus</label>
        <div id="pieces-details" class="hidden-content">
            <ul>
                <h4><?php echo $contenu['titre_pieces_a'] ?? ''; ?></h4>
                <?php foreach (explode("\n", $contenu['liste_pieces_a'] ?? '') as $item) echo "<li>$item</li>"; ?>
            </ul>
            <ul>
                <h4><?php echo $contenu['titre_pieces_b'] ?? ''; ?></h4>
                <?php foreach (explode("\n", $contenu['liste_pieces_b'] ?? '') as $item) echo "<li>$item</li>"; ?>
            </ul>
        </div>
    </div>
</section>

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
      
        <div class="footer-content">
          <div class="footer-section">
            <h3>Contact</h3>
            <ul>
              <li>12ᵉ Route Pamplemousses, Mauritius</li>
              <li>+230 59 45 67 89</li>
              <li>contact@supercar.com</li>
            </ul>
          </div>
      
          <div class="footer-section">
            <h3>Suivez-nous</h3>
            <div class="socials">
              <a href="https://www.facebook.com" target="_blank">
                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" alt="Facebook" />
              </a>
              <a href="https://www.twitter.com" target="_blank">
                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/twitter.svg" alt="Twitter" />
              </a>
              <a href="https://www.instagram.com" target="_blank">
                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/instagram.svg" alt="Instagram" />
              </a>
            </div>
          </div>
        </div>
      
        <div class="footer-bottom">
          <p>&copy; 2025-2028 Supercars.fr — Tous droits réservés. Réalisation & design MCCI SIO.</p>
          <div class="footer-links">
            <a href="/mentions-legales.html">Mentions légales</a>
            <a href="/politique-confidentialite.html">Confidentialité</a>
            <a href="/conditions générales.html">conditions générales</a>
          </div>
        </div>
      </footer>
      

</body>
</html>
