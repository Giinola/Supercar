<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Formulaire de Contact</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
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
    margin-right: 170px;
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
            font-size: 24px;
            font-weight: bold;
            color: #ff5733;
            text-decoration: none;
        }
        .contact-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-top: 120px;
            width: 100%;
        }

        .contact-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px;
            width: 90%;
            max-width: 1400px;
        }

        .contact-info, .map-container, form {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        
        .contact-info h3 {
            color: #ff5733;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .contact-info p {
            font-size: 18px;
            color: #555;
        }
        .contact-info i {
            color: #ff5733;
            margin-right: 10px;
        }

        form {
            text-align: center;
        }
        input, textarea {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        textarea {
            resize: none;
        }
        input[type="submit"] {
            background: #ff5733;
            color: white;
            border: none;
            padding: 15px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        input[type="submit"]:hover {
            background: #e04c2d;
        }

        .map-container iframe {
            width: 100%;
            height: 500px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Style du pied de page */
        footer {
            background: #000; /* Fond noir */
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }
        footer p, footer a {
            color: #fff;
            transition: color 0.3s;
        }
        footer a:hover {
            color: #ff5733;
        }
        .footer-info {
            margin-top: 10px;
        }
        .footer-social a {
            color: #fff;
            margin: 0 10px;
            font-size: 20px;
            transition: color 0.3s;
        }
        .footer-social a:hover {
            color: #ff5733;
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

    
    <div class="contact-container">
        <div class="contact-row">
            <div class="contact-info">
                <h3>Contact Information</h3>
                <p><i class="fas fa-phone"></i> Tel: 59353663</p>
                <p><i class="fas fa-envelope"></i> Email: projetsupercare@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> Adresse: Ebène, cybercity</p>
            </div>

            <form action="contact.php" method="post">
                <h2>Formulaire de Contact</h2>
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="text" name="adresse" placeholder="Adresse" required>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="messages" rows="5" placeholder="Votre message..." required></textarea>
                <input type="submit" value="Envoyer">
            </form>
        </div>

        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3743.3007243848856!2d57.486723674531916!3d-20.246359148236436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x217c5b1ef2170f63%3A0xd1a78020fc096491!2sMCCI%20BUSINESS%20SCHOOL%20(Mauritius%20Chamber%20of%20Commerce%20and%20Industry)!5e0!3m2!1sfr!2smu!4v1743210972573!5m2!1sfr!2smu" allowfullscreen loading="lazy"></iframe>
        </div>
    </div>

    <footer>
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
