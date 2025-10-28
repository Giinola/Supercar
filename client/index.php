<?php
$host = "mysql-ginola.alwaysdata.net";  
$login = "ginola";                  
$pass = "AlwaysGinola1";            
$dbname = "ginola_supercar";        
 
$bdd = new mysqli($host, $login, $pass, $dbname);
 
if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);  
}
?>
<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUPERCARS - Voitures de Luxe et Sportives</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #0f172a;
            color: #cbd5e1;
            overflow-x: hidden;
        }

        /* Hero Section */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .hero::before {
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

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1400px;
            width: 100%;
            padding: 0 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-text h1 {
            font-size: 72px;
            font-weight: 800;
            margin-bottom: 20px;
            color: #ffffff;
            line-height: 1.1;
        }

        .hero-text .highlight {
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-text p {
            font-size: 20px;
            color: #94a3b8;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: #ffffff;
            padding: 16px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.4);
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(249, 115, 22, 0.6);
        }

        .btn-secondary {
            background: transparent;
            color: #06b6d4;
            padding: 16px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: 2px solid #06b6d4;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: rgba(6, 182, 212, 0.1);
            transform: translateY(-2px);
        }

        .hero-image {
            position: relative;
        }

        .hero-car-wrapper {
            position: relative;
            width: 100%;
            height: 500px;
        }

        .hero-car-wrapper img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 100%;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.5));
        }
        .hero-car-wrapper::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            width: 450px;
            height: 450px;
            border: 3px solid #06b6d4;
            border-radius: 20px;
            box-shadow: 0 0 50px rgba(6, 182, 212, 0.3);
        }

        .hero-car-wrapper img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 120%;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.5));
        }

        /* Stats Section */
        .stats-section {
            background: #1e293b;
            padding: 60px 40px;
            border-top: 1px solid #334155;
            border-bottom: 1px solid #334155;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 48px;
            font-weight: 700;
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .stat-item p {
            font-size: 14px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Featured Cars Section */
        .featured-section {
            padding: 100px 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: 48px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 15px;
        }

        .section-header p {
            font-size: 18px;
            color: #94a3b8;
        }

        .cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .car-card {
            background: #1e293b;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #334155;
            transition: all 0.4s ease;
            position: relative;
        }

        .car-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .car-card:hover {
            transform: translateY(-10px);
            border-color: #06b6d4;
            box-shadow: 0 20px 60px rgba(6, 182, 212, 0.25);
        }

        .car-card:hover::before {
            opacity: 1;
        }

        .car-image {
            position: relative;
            height: 250px;
            overflow: hidden;
            background: #0f172a;
        }

        .car-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .car-card:hover .car-image img {
            transform: scale(1.1);
        }

        .car-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .car-info {
            padding: 30px;
        }

        .car-info h3 {
            font-size: 24px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .car-specs {
            display: flex;
            gap: 20px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #94a3b8;
        }

        .spec-icon {
            width: 20px;
            height: 20px;
            background: #06b6d4;
            border-radius: 50%;
        }

        .car-price {
            font-size: 28px;
            font-weight: 700;
            color: #06b6d4;
            margin: 20px 0;
        }

        .car-link {
            display: inline-block;
            color: #06b6d4;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .car-link:hover {
            color: #3b82f6;
            transform: translateX(5px);
        }

        /* About Section */
        .about-section {
            background: #1e293b;
            padding: 100px 40px;
        }

        .about-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .about-text h2 {
            font-size: 48px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .about-text p {
            font-size: 18px;
            color: #94a3b8;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .about-features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 40px;
        }

        .feature-box {
            background: #0f172a;
            padding: 25px;
            border-radius: 15px;
            border-left: 3px solid #06b6d4;
            transition: all 0.3s ease;
        }

        .feature-box:hover {
            transform: translateX(5px);
            background: #1e293b;
        }

        .feature-box h4 {
            font-size: 16px;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 8px;
        }

        .feature-box p {
            font-size: 14px;
            color: #94a3b8;
            margin: 0;
        }

        .about-image {
            position: relative;
        }

        .about-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        /* CTA Section */
        .cta-section {
            padding: 100px 40px;
            text-align: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, rgba(6, 182, 212, 0.1), transparent 70%);
        }

        .cta-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .cta-content h2 {
            font-size: 48px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .cta-content p {
            font-size: 20px;
            color: #94a3b8;
            margin-bottom: 40px;
        }

        /* Footer */
        footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 60px 40px 30px;
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
        }

        .footer-section a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
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
        @media (max-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 52px;
            }

            .hero-buttons {
                justify-content: center;
            }

            .about-content {
                grid-template-columns: 1fr;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {

            .hero-text h1 {
                font-size: 38px;
            }

            .hero-text p {
                font-size: 16px;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .section-header h2 {
                font-size: 32px;
            }

            .cars-grid {
                grid-template-columns: 1fr;
            }

            .stats-container {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .about-features {
                grid-template-columns: 1fr;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }

            .socials {
                justify-content: center;
            }

            .featured-section, .hero, .about-section, .cta-section {
                padding: 60px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <header>
        <?php include "navbar.php"; ?>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Découvrez nos voitures <span class="highlight">de luxe</span></h1>
                <p>Explorez notre collection exclusive de voitures de luxe et sportives, conçues pour ceux qui exigent le meilleur !</p>
                <div class="hero-buttons">
                    <a href="Voitures.php" class="btn-primary">Voir le catalogue</a>
                    <a href="#about" class="btn-secondary">En savoir plus</a>
                </div>
            </div>
            <div class="hero-image">
                <div class="hero-car-wrapper">
                    <img src="IMAGES/logo2.png" alt="Voiture de luxe">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-container">
            <div class="stat-item">
                <h3></h3>
                <p>services premium</p>
            </div>
            <div class="stat-item">
                <h3>10+</h3>
                <p>Voiture de luxe</p>
            </div>
            <div class="stat-item">
                <h3>98%</h3>
                <p>Clients satisfaits</p>
            </div>
            <div class="stat-item">
                <h3>24/7</h3>
                <p>Support disponible</p>
            </div>
        </div>
    </section>

    
    <section class="featured-section">
        <div class="section-header">
            <h2>Véhicules en Vedette</h2>
            <p>Découvrez notre sélection de voitures d'exception</p>
        </div>
        <div class="cars-grid">
            <?php
            // Requête pour McLaren 765LT
            $query_mclaren = "SELECT nom_complet, classe, carrosserie, description_courte, chemin_image, puissance_ch, prix_estime FROM mclaren WHERE id = 1 LIMIT 1";
            $result_mclaren = mysqli_query($bdd, $query_mclaren);
            
            // Requête pour Ferrari Purosangue
            $query_ferrari = "SELECT nom_complet, classe, carrosserie, description_courte, chemin_image, puissance_ch, prix_estime FROM ferrari WHERE id = 2 LIMIT 1";
            $result_ferrari = mysqli_query($bdd, $query_ferrari);
            
            // Requête pour Range Rover Evoque
            $query_rangerover = "SELECT nom_complet, classe, carrosserie, description_courte, chemin_image, puissance_ch, prix_estime FROM range_rover WHERE id = 3 LIMIT 1";
            $result_rangerover = mysqli_query($bdd, $query_rangerover);
            
            // Afficher McLaren 765LT
            if ($result_mclaren && mysqli_num_rows($result_mclaren) > 0) {
                $car = mysqli_fetch_assoc($result_mclaren);
            ?>
            <div class="car-card">
                <div class="car-image">
                    <img src="<?php echo $car['chemin_image']; ?>" alt="<?php echo $car['nom_complet']; ?>">
                    <div class="car-badge">Nouveau</div>
                </div>
                <div class="car-info">
                    <h3><?php echo $car['nom_complet']; ?></h3>
                    <div class="car-specs">
                        <div class="spec-item"><div class="spec-icon"></div><span><?php echo $car['classe']; ?></span></div>
                        <div class="spec-item"><div class="spec-icon"></div><span><?php echo $car['carrosserie']; ?></span></div>
                        <div class="spec-item"><div class="spec-icon"></div><span><?php echo $car['puissance_ch']; ?> ch</span></div>
                    </div>
                    <div class="car-price"><?php echo number_format($car['prix_estime'], 0, ',', ' '); ?> $</div>
                    <a href="Voitures.php" class="car-link">Voir les détails →</a>
                </div>
            </div>
            <?php } ?>

            <?php
            // Afficher Ferrari Purosangue
            if ($result_ferrari && mysqli_num_rows($result_ferrari) > 0) {
                $car = mysqli_fetch_assoc($result_ferrari);
            ?>
            <div class="car-card">
                <div class="car-image">
                    <img src="<?php echo $car['chemin_image']; ?>" alt="<?php echo $car['nom_complet']; ?>">
                    <div class="car-badge">Exclusif</div>
                </div>
                <div class="car-info">
                    <h3><?php echo $car['nom_complet']; ?></h3>
                    <div class="car-specs">
                        <div class="spec-item"><div class="spec-icon"></div><span><?php echo $car['classe']; ?></span></div>
                        <div class="spec-item"><div class="spec-icon"></div><span><?php echo $car['carrosserie']; ?></span></div>
                        <div class="spec-item"><div class="spec-icon"></div><span><?php echo $car['puissance_ch']; ?> ch</span></div>
                    </div>
                    <div class="car-price"><?php echo number_format($car['prix_estime'], 0, ',', ' '); ?> $</div>
                    <a href="Voitures.php" class="car-link">Voir les détails →</a>
                </div>
            </div>
            <?php } ?>

            <?php
            // Afficher Range Rover Evoque
            if ($result_rangerover && mysqli_num_rows($result_rangerover) > 0) {
                $car = mysqli_fetch_assoc($result_rangerover);
            ?>
            <div class="car-card">
                <div class="car-image">
                    <img src="<?php echo $car['chemin_image']; ?>" alt="<?php echo $car['nom_complet']; ?>">
                    <div class="car-badge">Nouveau</div>
                </div>
                <div class="car-info">
                    <h3><?php echo $car['nom_complet']; ?></h3>
                    <div class="car-specs">
                        <div class="spec-item"><div class="spec-icon"></div><span><?php echo $car['classe']; ?></span></div>
                        <div class="spec-item"><div class="spec-icon"></div><span><?php echo $car['carrosserie']; ?></span></div>
                        <div class="spec-item"><div class="spec-icon"></div><span><?php echo $car['puissance_ch']; ?> ch</span></div>
                    </div>
                    <div class="car-price"><?php echo number_format($car['prix_estime'], 0, ',', ' '); ?> $</div>
                    <a href="Voitures.php" class="car-link">Voir les détails →</a>
                </div>
            </div>
            <?php } ?>
        </div>
        <div style="text-align: center; margin-top: 50px;">
            <a href="Voitures.php" class="btn-primary">Voir tous les véhicules</a>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="about-content">
            <div class="about-text">
                <h2>À propos</h2>
                <p>SUPERCARS est votre référence pour les voitures de luxe et sportives. Nous sélectionnons les meilleures marques pour vous offrir une expérience d'achat exceptionnelle.</p>
                <p>Passionné de vitesse et de design ? Découvrez nos modèles d'exception.</p>
                
                <div class="about-features">
                    <div class="feature-box">
                        <h4>Expertise Reconnue</h4>
                        <p>Plus de 15 ans d'expérience</p>
                    </div>
                    <div class="feature-box">
                        <h4>Véhicules Certifiés</h4>
                        <p>Garantie et traçabilité</p>
                    </div>
                    <div class="feature-box">
                        <h4>Service Premium</h4>
                        <p>Accompagnement personnalisé</p>
                    </div>
                    <div class="feature-box">
                        <h4>Financement Sur-Mesure</h4>
                        <p>Solutions adaptées à vos besoins</p>
                    </div>
                </div>
                
                <div style="margin-top: 40px;">
                    <a href="Services.php" class="btn-primary">En savoir plus</a>
                </div>
            </div>
            <div class="about-image">
                <img src="IMAGES/Supercar.png" alt="À propos">
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2>Prêt à conduire votre voiture de rêve ?</h2>
            <p>Contactez-nous dès aujourd'hui pour un essai ou une consultation personnalisée</p>
            <div class="hero-buttons">
                <a href="Contact.php" class="btn-primary">Nous contacter</a>
                <a href="tel:+23059456789" class="btn-secondary">+230 59 45 67 89</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>SUPERCARS</h3>
                <p style="color: #94a3b8; margin-top: 15px;">Votre partenaire privilégié pour l'acquisition de véhicules d'exception.</p>
            </div>
            
            <div class="footer-section">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="Voitures.php">Véhicules</a></li>
                    <li><a href="Services.php">Services</a></li>
                    <li><a href="Contact.php">Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Contact</h3>
                <ul>
                    <li>12ᵉ Route Pamplemousses</li>
                    <li>Mauritius</li>
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
                        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/x.svg" alt="X" />
                    </a>
                    <a href="https://www.instagram.com" target="_blank">
                        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/instagram.svg" alt="Instagram" />
                    </a>
                    <a href="https://www.linkedin.com" target="_blank">
                        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/linkedin.svg" alt="LinkedIn" />
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025-2028 Supercars.fr — Tous droits réservés. Réalisation & design MCCI SIO.</p>
            <div class="footer-links">
                <a href="/mentions-legales.html">Mentions légales</a>
                <a href="/politique-confidentialite.html">Confidentialité</a>
                <a href="/conditions-generales.html">Conditions générales</a>
            </div>
        </div>
    </footer>

</body>
</html>