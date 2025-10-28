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
    <title>SUPERCARS - Services</title>
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
            height: 65vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #0f172a;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('IMAGES/Fond service.jpeg') no-repeat center center/cover;
            opacity: 0.2;
            z-index: 0;
        }

        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, transparent 0%, #0f172a 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 20px;
        }

        .hero h1 {
            font-size: 64px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #ffffff;
            letter-spacing: 4px;
            text-transform: uppercase;
            animation: fadeInUp 1s ease;
            text-shadow: 0 0 30px rgba(6, 182, 212, 0.3);
        }

        .hero p {
            font-size: 18px;
            color: #94a3b8;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
            animation: fadeInUp 1.2s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Services Grid */
        .services-container {
            max-width: 1400px;
            margin: -80px auto 100px;
            padding: 0 40px;
            position: relative;
            z-index: 3;
        }

        .service-card {
            background: #1e293b;
            border-radius: 20px;
            margin-bottom: 50px;
            overflow: hidden;
            border: 1px solid #334155;
            transition: all 0.5s ease;
            position: relative;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .service-card:hover::before {
            opacity: 1;
        }

        .service-card:hover {
            transform: translateY(-8px);
            border-color: #06b6d4;
            box-shadow: 0 20px 60px rgba(6, 182, 212, 0.2);
        }

        .service-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }

        .service-image {
            position: relative;
            height: 400px;
            overflow: hidden;
            background: #0f172a;
        }

        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.7;
            transition: all 0.7s ease;
        }

        .service-card:hover .service-image img {
            transform: scale(1.08);
            opacity: 0.85;
        }

        .service-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(6, 182, 212, 0.2), transparent);
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .service-card:hover .service-image::after {
            opacity: 1;
        }

        .service-info {
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .service-number {
            font-size: 12px;
            font-weight: 600;
            color: #06b6d4;
            letter-spacing: 3px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .service-info h2 {
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #ffffff;
            position: relative;
            display: inline-block;
        }

        .service-info h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
            border-radius: 2px;
        }

        .service-info p {
            font-size: 15px;
            line-height: 1.8;
            color: #94a3b8;
            margin-bottom: 25px;
        }

        .service-features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 30px;
        }

        .feature-item {
            background: #0f172a;
            padding: 20px;
            border-radius: 12px;
            border-left: 3px solid #334155;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: #1e293b;
            border-left-color: #06b6d4;
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(6, 182, 212, 0.15);
        }

        .feature-item h4 {
            font-size: 14px;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .feature-item p {
            font-size: 13px;
            color: #94a3b8;
            margin: 0;
        }

        .service-btn {
            display: inline-block;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: #ffffff;
            padding: 14px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            margin-top: 30px;
            border: none;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
        }

        .service-btn:hover {
            background: linear-gradient(135deg, #ea580c, #dc2626);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.5);
        }

        /* Alternate Layout */
        .service-card:nth-child(even) .service-content {
            direction: rtl;
        }

        .service-card:nth-child(even) .service-info {
            direction: ltr;
        }

        /* Stats Section */
        .stats-section {
            background: #1e293b;
            padding: 80px 40px;
            margin: 80px 0;
            border-top: 1px solid #334155;
            border-bottom: 1px solid #334155;
            position: relative;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #06b6d4, transparent);
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            text-align: center;
        }

        .stat-item {
            position: relative;
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
        }

        .stat-item h3 {
            font-size: 52px;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-item p {
            font-size: 14px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Footer */
        footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 50px 20px 30px;
            border-top: 1px solid #334155;
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
            color: #e2e8f0;
            margin-bottom: 15px;
            font-size: 1.1em;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section li {
            margin-bottom: 10px;
            font-size: 0.95em;
            color: #94a3b8;
            transition: color 0.3s ease;
        }

        .footer-section li:hover {
            color: #06b6d4;
        }

        .socials {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .socials a {
            width: 40px;
            height: 40px;
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
            box-shadow: 0 5px 20px rgba(6, 182, 212, 0.4);
        }

        .socials a img {
            width: 18px;
            filter: brightness(0) invert(0.7);
            transition: filter 0.3s ease;
        }

        .socials a:hover img {
            filter: brightness(0) invert(1);
        }

        .footer-bottom {
            border-top: 1px solid #334155;
            margin-top: 40px;
            padding-top: 20px;
            text-align: center;
        }

        .footer-bottom p {
            color: #64748b;
            font-size: 0.85em;
            margin-bottom: 10px;
        }

        .footer-links {
            margin-top: 10px;
        }

        .footer-links a {
            margin: 0 15px;
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.85em;
        }

        .footer-links a:hover {
            color: #06b6d4;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .service-content {
                grid-template-columns: 1fr;
            }

            .service-card:nth-child(even) .service-content {
                direction: ltr;
            }

            .service-features {
                grid-template-columns: 1fr;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 38px;
            }

            .hero p {
                font-size: 15px;
            }

            .services-container {
                padding: 0 20px;
                margin-top: -50px;
            }

            .service-info {
                padding: 30px;
            }

            .service-info h2 {
                font-size: 26px;
            }

            .stats-container {
                grid-template-columns: 1fr;
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
    </style>
</head>
<body>
    <header>
        <?php include "navbar.php"; ?>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Nos Services</h1>
            <p>Excellence technique et savoir-faire artisanal au service de votre passion automobile</p>
        </div>
    </section>

    <!-- Services Container -->
    <div class="services-container">
        <!-- Service 1: Entretien Technique -->
        <div class="service-card">
            <div class="service-content">
                <div class="service-image">
                    <img src="IMAGES/Maintenance.jpg" alt="Entretien Technique">
                </div>
                <div class="service-info">
                    <div class="service-number">Service 01</div>
                    <h2>Entretien Technique</h2>
                    <p>Un entretien rigoureux effectué selon les standards constructeurs. Nos techniciens certifiés assurent la longévité et les performances optimales de votre véhicule grâce à des protocoles d'intervention précis.</p>
                    
                    <div class="service-features">
                        <div class="feature-item">
                            <h4>Révision Complète</h4>
                            <p>Contrôle multi-points et diagnostics</p>
                        </div>
                        <div class="feature-item">
                            <h4>Inspection Préventive</h4>
                            <p>Anticipation des besoins futurs</p>
                        </div>
                        <div class="feature-item">
                            <h4>Vidange Spécialisée</h4>
                            <p>Lubrifiants haute performance</p>
                        </div>
                        <div class="feature-item">
                            <h4>Contrôle Électronique</h4>
                            <p>Calibration et mise à jour</p>
                        </div>
                    </div>
                    
                    <a href="#contact" class="service-btn">Planifier un entretien</a>
                </div>
            </div>
        </div>

        <!-- Service 2: Restauration Mécanique -->
        <div class="service-card">
            <div class="service-content">
                <div class="service-image">
                    <img src="IMAGES/Réparation.jpg" alt="Restauration Mécanique">
                </div>
                <div class="service-info">
                    <div class="service-number">Service 02</div>
                    <h2>Restauration Mécanique</h2>
                    <p>Interventions techniques précises sur tous les systèmes mécaniques. De la simple réparation à la refonte complète, nous garantissons une qualité irréprochable et le respect de l'intégrité d'origine.</p>
                    
                    <div class="service-features">
                        <div class="feature-item">
                            <h4>Mécanique Moteur</h4>
                            <p>Réfection et optimisation</p>
                        </div>
                        <div class="feature-item">
                            <h4>Systèmes de Transmission</h4>
                            <p>Boîte et embrayage</p>
                        </div>
                        <div class="feature-item">
                            <h4>Suspension & Freinage</h4>
                            <p>Précision et sécurité</p>
                        </div>
                        <div class="feature-item">
                            <h4>Diagnostic Avancé</h4>
                            <p>Équipements professionnels</p>
                        </div>
                    </div>
                    
                    <a href="#contact" class="service-btn">Obtenir une estimation</a>
                </div>
            </div>
        </div>

        <!-- Service 3: Pièces Certifiées -->
        <div class="service-card">
            <div class="service-content">
                <div class="service-image">
                    <img src="IMAGES/Pièce.jpg" alt="Pièces Certifiées">
                </div>
                <div class="service-info">
                    <div class="service-number">Service 03</div>
                    <h2>Pièces Certifiées</h2>
                    <p>Accès exclusif à un réseau de fournisseurs officiels. Chaque composant est authentifié et tracé pour garantir la conformité absolue avec les spécifications d'origine de votre véhicule d'exception.</p>
                    
                    <div class="service-features">
                        <div class="feature-item">
                            <h4>Origine Constructeur</h4>
                            <p>Traçabilité garantie</p>
                        </div>
                        <div class="feature-item">
                            <h4>Composants Premium</h4>
                            <p>Catalogue étendu disponible</p>
                        </div>
                        <div class="feature-item">
                            <h4>Certification Officielle</h4>
                            <p>Conformité assurée</p>
                        </div>
                        <div class="feature-item">
                            <h4>Approvisionnement Rapide</h4>
                            <p>Réseau international</p>
                        </div>
                    </div>
                    
                    <a href="#contact" class="service-btn">Consulter le catalogue</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-container">
            <div class="stat-item">
                <h3>18</h3>
                <p>Années d'expertise</p>
            </div>
            <div class="stat-item">
                <h3>3200+</h3>
                <p>Interventions réalisées</p>
            </div>
            <div class="stat-item">
                <h3>96%</h3>
                <p>Satisfaction client</p>
            </div>
            <div class="stat-item">
                <h3>12</h3>
                <p>Techniciens certifiés</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
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