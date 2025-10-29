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
   <style>* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: #0f172a;
    color: #cbd5e1;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    overflow-x: hidden;
}

/* Hero Section */
.modèle {
    padding: 100px 20px 80px;
    text-align: center;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
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
    background: radial-gradient(circle at 20% 50%, rgba(6, 182, 212, 0.15), transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.15), transparent 50%);
    z-index: 1;
}

.modèle h1 {
    font-size: 64px;
    font-weight: 800;
    margin-bottom: 20px;
    color: #ffffff;
    position: relative;
    z-index: 2;
    letter-spacing: 1px;
}

.modèle h1::after {
    content: '';
    display: block;
    width: 120px;
    height: 5px;
    background: linear-gradient(135deg, #06b6d4, #3b82f6);
    margin: 20px auto 0;
    border-radius: 10px;
}

.modèle p {
    font-size: 20px;
    color: #94a3b8;
    max-width: 700px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
    line-height: 1.6;
}

/* Catalog Grid */
.catalog {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 35px;
    padding: 80px 40px;
    max-width: 1600px;
    margin: 0 auto;
    width: 100%;
}

.car {
    background: #1e293b;
    border-radius: 25px;
    overflow: hidden;
    position: relative;
    transition: all 0.4s ease;
    border: 1px solid #334155;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
}

.car::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #06b6d4, #3b82f6);
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: 3;
}

.car:hover::before {
    opacity: 1;
}

.car:hover {
    transform: translateY(-12px);
    border-color: #06b6d4;
    box-shadow: 0 25px 60px rgba(6, 182, 212, 0.3);
}

.car-image-wrapper {
    position: relative;
    overflow: hidden;
    height: 280px;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
}

.car img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.car:hover img {
    transform: scale(1.15);
}

.car-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, transparent 0%, rgba(15, 23, 42, 0.8) 100%);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.car:hover .car-overlay {
    opacity: 1;
}

.car-content {
    padding: 30px;
    position: relative;
    z-index: 1;
}

.car h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #ffffff;
    letter-spacing: 0.5px;
}

.button {
    display: inline-block;
    width: 100%;
    text-align: center;
    text-decoration: none;
    background: linear-gradient(135deg, #f97316, #ea580c);
    color: white;
    padding: 16px 0;
    border-radius: 50px;
    font-weight: 600;
    font-size: 14px;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    text-transform: uppercase;
    box-shadow: 0 8px 25px rgba(249, 115, 22, 0.4);
}

.button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.button:hover::before {
    left: 100%;
}

.button:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(249, 115, 22, 0.6);
}

/* Footer */
footer {
    background: #0f172a;
    color: #94a3b8;
    padding: 60px 40px 30px;
    margin-top: auto;
    border-top: 1px solid #334155;
}

.footer-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 50px;
    max-width: 1400px;
    margin: 0 auto 40px;
}

.footer-section {
    flex: 1 1 250px;
}

.footer-section h3 {
    color: #e2e8f0;
    margin-bottom: 20px;
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.footer-section ul {
    list-style: none;
}

.footer-section li {
    margin-bottom: 12px;
    font-size: 15px;
    color: #94a3b8;
    transition: color 0.3s ease;
}

.footer-section li:hover {
    color: #06b6d4;
}

.socials {
    display: flex;
    gap: 15px;
    margin-top: 15px;
}

.socials a {
    width: 45px;
    height: 45px;
    background: #1e293b;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    border: 1px solid #334155;
}

.socials a:hover {
    background: #06b6d4;
    border-color: #06b6d4;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(6, 182, 212, 0.4);
}

.socials a img {
    width: 20px;
    filter: brightness(0) invert(0.7);
    transition: filter 0.3s ease;
}

.socials a:hover img {
    filter: brightness(0) invert(1);
}

.footer-bottom {
    border-top: 1px solid #334155;
    margin-top: 50px;
    padding-top: 30px;
    text-align: center;
}

.footer-bottom p {
    color: #64748b;
    font-size: 14px;
    margin-bottom: 15px;
}

.footer-links {
    margin-top: 15px;
}

.footer-links a {
    margin: 0 15px;
    color: #94a3b8;
    text-decoration: none;
    transition: color 0.3s ease;
    font-size: 14px;
}

.footer-links a:hover {
    color: #06b6d4;
}

/* Responsive */
@media (max-width: 1200px) {
    .catalog {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .modèle {
        padding: 60px 20px 40px;
    }

    .modèle h1 {
        font-size: 42px;
    }

    .modèle p {
        font-size: 16px;
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
        font-size: 32px;
    }

    .car h3 {
        font-size: 20px;
    }
}</style>
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