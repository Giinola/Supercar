<?php
$bdd = new mysqli("localhost", "root", "", "supercar");
$bdd->set_charset("utf8");

$contenu = [];
$resultats = mysqli_query($bdd, "SELECT * FROM ford");
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
    <style>
        .logo {
            position: absolute;
            left: 2%;
            top: 20px;
            font-size: 35px;
            color: #ff5733;
            text-decoration: none;
            font-weight: 600;
            animation: slideRight 1s ease forwards;
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


        body {
            padding-top: 100px;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            background-color: #f8f8f8;
        }

        .modèle {
            padding: 50px 20px;
            background-color: #f5f5f5;
            text-align: center;
        }

        .modèle h1 {
            font-size: 36px;
            color: #444;
            margin-bottom: 20px;
        }

        .modèle p {
            font-size: 18px;
            color: #555;
            max-width: 900px;
            margin: 0 auto 40px;
        }

        .car-models {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }

        .car-card {
            background-color: #fff;
            width: 500px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 30px;
            position: relative;
        }

        .car-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .car-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-bottom: 2px solid #f5f5f5;
        }

        .car-card h4 {
            font-size: 24px;
            color: #222;
            text-align: center;
            margin: 15px 0;
        }

        .car-card p {
            font-size: 16px;
            color: #666;
            padding: 0 15px;
            margin-bottom: 20px;
        }

        .button{
            display:block;
            text-align:center;
            text-decoration:none;
            background-color: #ff5733;
            color: white;
           
            
            font-weight: bold;
        
}
            .try-button-container {
                text-align: center;
                margin-bottom: 20px;
            }
            
            .try-button {
                display: inline-block;
                padding: 10px 25px;
                background-color: #ff5733;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
                transition: background-color 0.3s ease;
            }
            
            .try-button:hover {
                background-color: #e8491d;
            }

        .car-card label {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff5733;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            text-align: center;
            cursor: pointer;
        }

        .car-card label:hover {
            background-color: #e8491d;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            margin-top: 60px;
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
            width: 200px;
            transition: transform 0.2s;
            text-decoration: none;
            color: inherit;
        }

        .car img {
            width: 100%;
            height: auto;
            max-height: 150px;
            border-radius: 10px;
        }

        .car h3 {
            margin: 10px 0 0;
            font-size: 18px;
        }

        .car:hover {
            transform: scale(1.05);
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


   
        

    <section class="brand ford">
    <p style="text-align:center; max-width:800px; margin:0 auto 30px;">
    <?php echo $contenu['en_tete']; ?>
</p>
            <h1><?php echo $contenu['nom_marque']; ?></h1>

            <div class="car-models">
<?php
for ($i = 1; $i <= 4; $i++) {
    echo '<div class="car-card">';
    echo '<h4>' . $contenu['nom_voiture' . $i] . '</h4>';
    $image = isset($contenu['image_voiture' . $i]) ? $contenu['image_voiture' . $i] : '';
    $image = str_replace(' ', '%20', $image);

    echo '<img src="' . $image . '" alt="' . $contenu['nom_voiture' . $i] . '">';
    echo '<p>' . $contenu['descri_voiture' . $i] . '</p>';
    echo '<p><strong>PRIX: ' . $contenu['prix_voiture' . $i] . '</strong></p>';
    echo '<div class="try-button-container"><a href="demande_essai.php" class="try-button">Essayer</a></div>';
    echo '</div>';
}
?>


</div>

</div>
</div>

    </section>

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
          
    </footer>

</body>
</html>
   
   
   
