<?php
$host = "mysql-ginola.alwaysdata.net";  
$login = "ginola";                  
$pass = "AlwaysGinola1";            
$dbname = "ginola_supercar";        
 
 
$bdd = new mysqli($host, $login, $pass, $dbname);
 
 
if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);  
}
 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom             = $_POST["nom"];
    $prenom          = $_POST["prenom"];
    $email           = $_POST["email"];
    $nom_utilisateur = $_POST["nom_utilisateur"];
    $mot_de_passe    = $_POST["mot_de_passe"];

    $sql = "INSERT INTO utilisateur (nom, prenom, email, nom_utilisateur, mot_de_passe) 
            VALUES ('$nom', '$prenom', '$email', '$nom_utilisateur', '$mot_de_passe')";

    if ($bdd->query($sql) === TRUE) {
        header("Location:dash.inscri.php");
    } else {
        echo "Erreur : " . $bdd->error;
    }
}

// Fermer la connexion
$bdd->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Inscription - SUPERCARS</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
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
            background: radial-gradient(circle at 20% 50%, rgba(6, 182, 212, 0.15), transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.15), transparent 50%);
            z-index: 0;
            pointer-events: none;
        }

        /* Header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        /* Container principal */
        .signup-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 120px 20px 20px;
            position: relative;
            z-index: 1;
        }

        .wrapper {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(51, 65, 85, 0.8);
            position: relative;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Barre décorative en haut */
        .wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
            border-radius: 20px 20px 0 0;
        }

        /* Icône d'inscription */
        .signup-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
            box-shadow: 0 8px 25px rgba(6, 182, 212, 0.4);
        }

        .wrapper h1 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 10px;
            color: #ffffff;
            text-align: center;
            letter-spacing: 0.5px;
        }

        .subtitle {
            font-size: 15px;
            color: #94a3b8;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Champs du formulaire */
        .input-box {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .input-box label {
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 8px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-box input {
            width: 100%;
            height: 50px;
            background: rgba(15, 23, 42, 0.6);
            border: 2px solid #334155;
            outline: none;
            border-radius: 12px;
            font-size: 15px;
            color: #e2e8f0;
            padding: 0 18px;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

        .input-box input::placeholder {
            color: #64748b;
        }

        .input-box input:focus {
            border-color: #06b6d4;
            background: rgba(15, 23, 42, 0.8);
            box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1);
        }

        /* Bouton */
        .wrapper .btn {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            border: none;
            outline: none;
            border-radius: 50px;
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.4);
            cursor: pointer;
            font-size: 16px;
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }

        .wrapper .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .wrapper .btn:hover::before {
            left: 100%;
        }

        .wrapper .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(249, 115, 22, 0.6);
        }

        .wrapper .btn:active {
            transform: translateY(-1px);
        }

        /* Lien de connexion */
        .register-link {
            font-size: 14px;
            text-align: center;
            margin-top: 25px;
            color: #94a3b8;
        }

        .register-link p {
            margin: 0;
        }

        .register-link p a {
            color: #06b6d4;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link p a:hover {
            color: #3b82f6;
        }

        /* Footer */
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

        /* Responsive */
        @media (max-width: 768px) {
            .wrapper {
                padding: 30px 25px;
            }

            .wrapper h1 {
                font-size: 26px;
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

    <div class="signup-wrapper">
        <div class="wrapper">
            <div class="signup-icon">✍️</div>
            <form action="inscription.php" method="POST">
                <h1>Inscription</h1>
                <p class="subtitle">Créez votre compte Supercars</p>
                
                <div class="input-box">
                    <label>Nom</label>
                    <input type="text" name="nom" placeholder="Votre nom" required>
                </div>

                <div class="input-box">
                    <label>Prénom</label>
                    <input type="text" name="prenom" placeholder="Votre prénom" required>
                </div>

                <div class="input-box">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="votre@email.com" required>
                </div>

                <div class="input-box">
                    <label>Nom d'utilisateur</label>
                    <input type="text" name="nom_utilisateur" placeholder="Choisissez un nom d'utilisateur" required>
                </div>

                <div class="input-box">
                    <label>Mot de passe</label>
                    <input type="password" name="mot_de_passe" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn">S'inscrire</button>

                <div class="register-link">
                    <p>Vous avez déjà un compte? <a href="Login.php">Se connecter</a></p>
                </div>
            </form>
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