<?php
$host = "mysql-ginola.alwaysdata.net";
$login = "ginola";
$pass = "AlwaysGinola1";
$dbname = "ginola_supercar";

$bdd = new mysqli($host, $login, $pass, $dbname);

if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = mysqli_real_escape_string($bdd, $_POST['nom']);
    $adresse = mysqli_real_escape_string($bdd, $_POST['adresse']);
    $email = mysqli_real_escape_string($bdd, $_POST['email']);
    $messages = mysqli_real_escape_string($bdd, $_POST['messages']);
    
    $sql = "INSERT INTO contacts (nom, adresse, email, message, date_envoi) 
            VALUES ('$nom', '$adresse', '$email', '$messages', NOW())";
    
    if ($bdd->query($sql) === TRUE) {
        $message = "✅ Votre message a été envoyé avec succès !";
        $message_type = "success";
    } else {
        $message = "❌ Erreur lors de l'envoi : " . $bdd->error;
        $message_type = "error";
    }
}
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Contact - Supercars</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #cbd5e1;
            min-height: 100vh;
            position: relative;
        }

        /* Effets de fond */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(6, 182, 212, 0.1), transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.1), transparent 50%);
            z-index: 0;
            pointer-events: none;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .contact-container {
            padding: 140px 20px 60px;
            position: relative;
            z-index: 1;
        }

        .page-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .page-title h1 {
            font-size: 42px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        .page-title p {
            font-size: 18px;
            color: #94a3b8;
        }

        /* Message de confirmation/erreur */
        .alert-message {
            max-width: 800px;
            margin: 0 auto 30px;
            padding: 18px 25px;
            border-radius: 12px;
            font-weight: 600;
            animation: slideDown 0.5s ease-out;
            border-left: 4px solid;
            text-align: left;
        }

        .alert-message.success {
            background: rgba(6, 182, 212, 0.15);
            color: #06b6d4;
            border-color: #06b6d4;
        }

        .alert-message.error {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border-color: #ef4444;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .contact-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto 40px;
        }

        .contact-card {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(51, 65, 85, 0.8);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .contact-card:hover::before {
            opacity: 1;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            border-color: #06b6d4;
            box-shadow: 0 25px 70px rgba(6, 182, 212, 0.3);
        }

        .contact-info h3 {
            color: #ffffff;
            font-size: 26px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 700;
        }

        .contact-info .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(15, 23, 42, 0.6);
            border-radius: 12px;
            border: 1px solid #334155;
            transition: all 0.3s ease;
        }

        .contact-info .info-item:hover {
            background: rgba(15, 23, 42, 0.8);
            border-color: #06b6d4;
        }

        .contact-info i {
            color: #06b6d4;
            font-size: 20px;
            margin-right: 15px;
            width: 25px;
        }

        .contact-info p {
            font-size: 16px;
            color: #cbd5e1;
            margin: 0;
        }

        form h2 {
            color: #ffffff;
            font-size: 26px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 700;
        }

        form label {
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 8px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input, textarea {
            width: 100%;
            padding: 14px 18px;
            margin-bottom: 20px;
            border: 2px solid #334155;
            border-radius: 12px;
            background: rgba(15, 23, 42, 0.6);
            font-size: 15px;
            font-weight: 500;
            color: #e2e8f0;
            outline: none;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        input::placeholder, textarea::placeholder {
            color: #64748b;
        }

        input:focus, textarea:focus {
            border-color: #06b6d4;
            background: rgba(15, 23, 42, 0.8);
            box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        input[type="submit"] {
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            border: none;
            padding: 16px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.4);
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(249, 115, 22, 0.6);
        }

        .map-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .map-container iframe {
            width: 100%;
            height: 500px;
            border-radius: 20px;
            border: 1px solid rgba(51, 65, 85, 0.8);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        footer {
            background: #0f172a;
            color: #94a3b8;
            text-align: center;
            padding: 60px 40px 30px;
            border-top: 1px solid #334155;
            margin-top: 60px;
            position: relative;
            z-index: 1;
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
            color: #e2e8f0;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-section li {
            margin-bottom: 10px;
            font-size: 15px;
            color: #94a3b8;
            transition: color 0.3s ease;
        }

        .footer-section li:hover {
            color: #06b6d4;
        }

        .socials {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            justify-content: center;
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
            width: 22px;
            filter: brightness(0) invert(0.7);
            transition: filter 0.3s ease;
        }

        .socials a:hover img {
            filter: brightness(0) invert(1);
        }

        .footer-bottom {
            border-top: 1px solid #334155;
            margin-top: 30px;
            padding-top: 20px;
            text-align: center;
        }

        .footer-bottom p {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .footer-links {
            margin-top: 10px;
        }

        .footer-links a {
            margin: 0 15px;
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s;
            font-size: 14px;
        }

        .footer-links a:hover {
            color: #06b6d4;
        }

        @media (max-width: 768px) {
            .page-title h1 {
                font-size: 32px;
            }

            .contact-row {
                grid-template-columns: 1fr;
            }

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
    
    <div class="contact-container">
        <div class="page-title">
            <h1>Contactez-nous</h1>
            <p>Notre équipe est à votre disposition pour répondre à toutes vos questions</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert-message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="contact-row">
            <div class="contact-card contact-info">
                <h3>Informations de Contact</h3>
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <p>+230 59 35 36 63</p>
                </div>
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <p>projetsupercare@gmail.com</p>
                </div>
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>Ebène, Cybercity, Mauritius</p>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <p>Lun - Sam : 8h00 - 18h00</p>
                </div>
            </div>

            <div class="contact-card">
                <form action="contact.php" method="post">
                    <h2>Envoyez-nous un message</h2>
                    <label>Nom</label>
                    <input type="text" name="nom" placeholder="Votre nom complet" required>
                    
                    <label>Adresse</label>
                    <input type="text" name="adresse" placeholder="Votre adresse" required>
                    
                    <label>Email</label>
                    <input type="email" name="email" placeholder="votre@email.com" required>
                    
                    <label>Message</label>
                    <textarea name="messages" rows="5" placeholder="Écrivez votre message ici..." required></textarea>
                    
                    <input type="submit" value="Envoyer le message">
                </form>
            </div>
        </div>

        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3743.3007243848856!2d57.486723674531916!3d-20.246359148236436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x217c5b1ef2170f63%3A0xd1a78020fc096491!2sMCCI%20BUSINESS%20SCHOOL%20(Mauritius%20Chamber%20of%20Commerce%20and%20Industry)!5e0!3m2!1sfr!2smu!4v1743210972573!5m2!1sfr!2smu" allowfullscreen loading="lazy"></iframe>
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
                <a href="/conditions générales.html">conditions générales</a>
            </div>
        </div>
    </footer>
</body>
</html>