<?php
$host = "mysql-ginola.alwaysdata.net";  
$login = "ginola";                  
$pass = "AlwaysGinola1";            
$dbname = "ginola_supercar";        
 
 
$bdd = new mysqli($host, $login, $pass, $dbname);
 
 
if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);  
}
 
 
$bdd->set_charset("utf8");
 

$contenu = [];
$resultats = mysqli_query($bdd, "SELECT * FROM voitures");
while ($ligne = mysqli_fetch_assoc($resultats)) {
    $contenu[$ligne['nom_champ']] = $ligne['valeur'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Modèles</title>
    <link rel="stylesheet" href="">
    <style>
        body {
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            background-color: #f8f8f8;
        }
      


        .modèle {
            color: #222;
            padding: 50px;
            text-align: center;
        }

        .modèle h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .modèle p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .catalog {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            flex-wrap: wrap;
        }

        .car {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            padding: 10px;
            width: 300px;
           
            text-decoration: none;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .car img {
            width: 100%;
            height: 200px; /* Taille fixe pour les images */
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s, filter 0.3s; 
        }

        .car img:hover {
            transform: scale(1.05); 
            filter: brightness(0.9); /* Assombrir légèrement l'image au survol */
        }

        .car h3 {
            margin: 10px 0 0;
            font-size: 24px;
            font-weight: bold;
        }

        .car:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0,0,0,0.4);
        }

            .button{
            display:block;
            width:100%;
            text-align:center;
            text-decoration:none;
            margin-top: 10px;
            background-color: #ff5733;
            color: white;
            padding: 10px 0;
            border-radius:5px;
            font-weight: bold;
        
}

        /* Footer de la page */
        footer {
            width: 100%;
            position:relative;
            background-color: #333;
            color: white;
            text-align: center;
            padding: 15px 0; /* Padding autour du footer */
            bottom: 0;
            left: 0; /* Marge au-dessus du footer */
        }

        footer p {
            margin-bottom: 10px;
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        footer a:hover {
            color: #ccc;
        }
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
</head>
<body>
    <header>
<?php include "navbar.php"; ?>
     </header>


 
    <section class="modèle">
    <h1><?php echo $contenu['titre_page']; ?></h1>
    <p><?php echo $contenu['description_page']; ?></p>
</section>

<div class="catalog">
    <div class="car">
        <h3><?php echo $contenu['ford_nom']; ?></h3>
        <img src="<?php echo $contenu['ford_image']; ?>" alt="Ford">
        <a href="<?php echo $contenu['ford_lien']; ?>" class="button">Voir détails</a>
    </div>
    <div class="car">
        <h3><?php echo $contenu['nissan_nom']; ?></h3>
        <img src="<?php echo $contenu['nissan_image']; ?>" alt="Nissan">
        <a href="<?php echo $contenu['nissan_lien']; ?>" class="button">Voir détails</a>
    </div>
    <div class="car">
        <h3><?php echo $contenu['mercedes_nom']; ?></h3>
        <img src="<?php echo $contenu['mercedes_image']; ?>" alt="Mercedes">
        <a href="<?php echo $contenu['mercedes_lien']; ?>" class="button">Voir détails</a>
    </div>
    <div class="car">
        <h3><?php echo $contenu['toyota_nom']; ?></h3>
        <img src="<?php echo $contenu['toyota_image']; ?>" alt="Toyota">
        <a href="<?php echo $contenu['toyota_lien']; ?>" class="button">Voir détails</a>
    </div>
</div>
    <!-- Footer de la page -->
    <footer>
        <footer>
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
          
        <p>