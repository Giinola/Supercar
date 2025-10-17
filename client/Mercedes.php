<?php
$host = "mysql-ginola.alwaysdata.net";  
$login = "ginola";                  
$pass = "AlwaysGinola1";            
$dbname = "ginola_supercar";        
 
 
$bdd = new mysqli($host, $login, $pass, $dbname);
 
 
if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);  
}
 

$contenu = [];
$resultats = mysqli_query($bdd, "SELECT * FROM mercedes");
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
    <header>
<?php include "navbar.php"; ?>
     </header>


   
        

    <section class="brand ford">
    <p style="text-align:center; max-width:800px; margin:0 auto 30px;">
    <?php echo $contenu['en_tete']; ?>
</p>
            <h1><?php echo $contenu['nom_marque']; ?></h1>

            <div class="car-models">
<?php
for ($i = 1; !empty($contenu["nom_voiture$i"]); $i++) {
    $nom = trim($contenu["nom_voiture$i"]);
    $img = trim($contenu["image_voiture$i"] ?? '');
    if ($img !== '') $img = str_replace(' ', '%20', $img);
    $desc = $contenu["descri_voiture$i"] ?? 'Description non disponible';
    $prix = $contenu["prix_voiture$i"]  ?? 'Prix non disponible';

    $nomH  = htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
    $imgH  = htmlspecialchars($img, ENT_QUOTES, 'UTF-8');
    $descH = htmlspecialchars($desc, ENT_QUOTES, 'UTF-8');
    $prixH = htmlspecialchars($prix, ENT_QUOTES, 'UTF-8');
    ?>
    <div class="car-card">
        <h4><?= $nomH ?></h4>
        <?php if ($imgH): ?><img src="<?= $imgH ?>" alt="<?= $nomH ?>"><?php endif; ?>
        <p><?= $descH ?></p>
        <p><strong>PRIX: <?= $prixH ?></strong></p>
        <div class="try-button-container">
            <a href="demande_essai.php?modele=<?= urlencode($nom) ?>" class="try-button">Essayer</a>
        </div>
    </div>
<?php } ?>
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
   
   
   
