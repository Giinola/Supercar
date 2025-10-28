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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Modèles</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Hero Section */
        .modèle {
            padding: 80px 20px 60px;
            text-align: center;
            background: linear-gradient(135deg, rgba(255, 87, 51, 0.1) 0%, rgba(0, 0, 0, 0.3) 100%);
            position: relative;
            overflow: hidden;
        }

        .modèle::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h100v100H0z" fill="none"/><path d="M50 0L100 50L50 100L0 50z" fill="%23ff5733" opacity="0.03"/></svg>');
            animation: bgMove 20s linear infinite;
        }

        @keyframes bgMove {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(100px) translateY(100px); }
        }

        .modèle h1 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #fff 0%, #ff5733 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .modèle p {
            font-size: 18px;
            color: #ccc;
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            line-height: 1.6;
        }

        /* Catalog Grid */
        .catalog {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            padding: 60px 40px;
            max-width: 1600px;
            margin: 0 auto;
            width: 100%;
        }

        .car {
            background: linear-gradient(145deg, #222, #1a1a1a);
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 2px solid transparent;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .car::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #ff5733 0%, #ff8c00 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 0;
        }

        .car:hover::before {
            opacity: 0.1;
        }

        .car:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: #ff5733;
            box-shadow: 0 20px 50px rgba(255, 87, 51, 0.4);
        }

        .car-image-wrapper {
            position: relative;
            overflow: hidden;
            height: 240px;
            background: #000;
        }

        .car img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease, filter 0.5s ease;
        }

        .car:hover img {
            transform: scale(1.15) rotate(2deg);
            filter: brightness(1.1) contrast(1.1);
        }

        .car-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.8) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .car:hover .car-overlay {
            opacity: 1;
        }

        .car-content {
            padding: 25px;
            position: relative;
            z-index: 1;
        }

        .car h3 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .button {
            display: inline-block;
            width: 100%;
            text-align: center;
            text-decoration: none;
            background: linear-gradient(135deg, #ff5733 0%, #ff3d00 100%);
            color: white;
            padding: 14px 0;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
        }

        .button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .button:hover::before {
            left: 100%;
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 87, 51, 0.4);
            background: linear-gradient(135deg, #ff3d00 0%, #ff5733 100%);
        }

        /* Footer */
        footer {
            background: linear-gradient(180deg, #0a0a0a 0%, #000 100%);
            color: white;
            padding: 50px 20px 30px;
            margin-top: auto;
            border-top: 2px solid #ff5733;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto 30px;
        }

        .footer-section {
            flex: 1 1 250px;
        }

        .footer-section h3 {
            color: #ff5733;
            margin-bottom: 15px;
            font-size: 1.2em;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section li {
            margin-bottom: 10px;
            font-size: 0.95em;
            color: #ccc;
            transition: color 0.3s ease;
        }

        .footer-section li:hover {
            color: #ff5733;
        }

        .socials {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .socials a {
            width: 40px;
            height: 40px;
            background: #222;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .socials a:hover {
            background: #ff5733;
            border-color: #ff5733;
            transform: translateY(-5px) rotate(360deg);
        }

        .socials a img {
            width: 20px;
            filter: brightness(0) invert(1);
        }

        .footer-bottom {
            border-top: 1px solid #333;
            margin-top: 40px;
            padding-top: 20px;
            text-align: center;
        }

        .footer-bottom p {
            color: #888;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .footer-links {
            margin-top: 10px;
        }

        .footer-links a {
            margin: 0 15px;
            color: #aaa;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.9em;
        }

        .footer-links a:hover {
            color: #ff5733;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .catalog {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .modèle h1 {
                font-size: 36px;
            }

            .catalog {
                grid-template-columns: 1fr;
                padding: 40px 20px;
                gap: 30px;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }

            .socials {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .modèle h1 {
                font-size: 28px;
            }

            .modèle p {
                font-size: 16px;
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
            <div class="car-image-wrapper">
                <img src="<?php echo $contenu['Range Rover_image']; ?>" alt="Range Rover">
                <div class="car-overlay"></div>
            </div>
            <div class="car-content">
                <h3><?php echo $contenu['Range Rover_nom']; ?></h3>
                <a href="<?php echo $contenu['Range Rover_lien']; ?>" class="button">Voir détails</a>
            </div>
        </div>

        <div class="car">
            <div class="car-image-wrapper">
                <img src="<?php echo $contenu['ferrari_image']; ?>" alt="Ferrari">
                <div class="car-overlay"></div>
            </div>
            <div class="car-content">
                <h3><?php echo $contenu['ferrari_nom']; ?></h3>
                <a href="<?php echo $contenu['ferrari_lien']; ?>" class="button">Voir détails</a>
            </div>
        </div>

        <div class="car">
            <div class="car-image-wrapper">
                <img src="<?php echo $contenu['mercedes_image']; ?>" alt="Mercedes">
                <div class="car-overlay"></div>
            </div>
            <div class="car-content">
                <h3><?php echo $contenu['mercedes_nom']; ?></h3>
                <a href="<?php echo $contenu['mercedes_lien']; ?>" class="button">Voir détails</a>
            </div>
        </div>

        <div class="car">
            <div class="car-image-wrapper">
                <img src="<?php echo $contenu['mclaren_image']; ?>" alt="McLaren">
                <div class="car-overlay"></div>
            </div>
            <div class="car-content">
                <h3><?php echo $contenu['mclaren_nom']; ?></h3>
                <a href="<?php echo $contenu['mclaren_lien']; ?>" class="button">Voir détails</a>
            </div>
        </div>
    </div>

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
                <a href="/conditions générales.html">Conditions générales</a>
            </div>
        </div>
    </footer>
</body>
</html>