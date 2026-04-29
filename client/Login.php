<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location:Dashboard.php");
    exit();
}

require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    try {
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email AND mot_de_passe = :mdp");
        $stmt->execute([
            ':email' => $email,
            ':mdp'   => $mot_de_passe,
        ]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: Dashboard.php");
            exit(); 
        } else {
            $error_message = "Identifiants incorrects";
        }
    } catch (PDOException $e) {
        $error_message = "Erreur de connexion.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Connexion - SUPERCARS</title>
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
        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 120px 20px 20px;
            position: relative;
            z-index: 1;
        }

        .container {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(51, 65, 85, 0.8);
            position: relative;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
            border-radius: 20px 20px 0 0;
        }

        .login-icon {
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

        .container h1 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 10px;
            color: #ffffff;
            text-align: center;
        }

        .subtitle {
            font-size: 15px;
            color: #94a3b8;
            text-align: center;
            margin-bottom: 30px;
        }

        .error-message {
            background: rgba(239, 68, 68, 0.15);
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 600;
            color: #ef4444;
            border-left: 4px solid #ef4444;
            font-size: 14px;
        }

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

        .input-box input::placeholder { color: #64748b; }

        .input-box input:focus {
            border-color: #06b6d4;
            background: rgba(15, 23, 42, 0.8);
            box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1);
        }

        .btn {
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

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before { left: 100%; }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 12px 35px rgba(249, 115, 22, 0.6); }
        .btn:active { transform: translateY(-1px); }

        .register-link {
            font-size: 14px;
            text-align: center;
            margin-top: 25px;
            color: #94a3b8;
        }

        .register-link a {
            color: #06b6d4;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link a:hover { color: #3b82f6; }

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

        .footer-section { flex: 1 1 200px; }
        .footer-section h3 { color: #e2e8f0; margin-bottom: 15px; font-size: 18px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        .footer-section ul { list-style: none; padding: 0; margin: 0; }
        .footer-section li { margin-bottom: 10px; font-size: 15px; color: #94a3b8; transition: color 0.3s ease; }
        .footer-section li:hover { color: #06b6d4; }

        .socials { display: flex; gap: 10px; margin-top: 10px; }
        .socials a { width: 45px; height: 45px; background: #1e293b; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; border: 1px solid #334155; }
        .socials a:hover { background: #06b6d4; border-color: #06b6d4; transform: translateY(-3px); box-shadow: 0 8px 20px rgba(6, 182, 212, 0.4); }
        .socials a img { width: 22px; filter: brightness(0) invert(0.7); transition: transform 0.3s ease, filter 0.3s ease; }
        .socials a:hover img { filter: brightness(0) invert(1); }

        .footer-bottom { border-top: 1px solid #334155; margin-top: 30px; padding-top: 20px; text-align: center; }
        .footer-bottom p { color: #64748b; font-size: 14px; margin-bottom: 10px; }
        .footer-links { margin-top: 10px; }
        .footer-links a { margin: 0 15px; color: #94a3b8; text-decoration: none; transition: color 0.3s; font-size: 14px; }
        .footer-links a:hover { color: #06b6d4; }

        @media (max-width: 1024px) {
            .container { max-width: 420px; }
        }

        @media (max-width: 768px) {
            .footer-content { flex-direction: column; align-items: center; text-align: center; }
            .footer-section { flex: none; }
        }

        @media (max-width: 600px) {
            .container { padding: 30px 25px; }
            .container h1 { font-size: 26px; }
        }
    </style>
</head>
<body>
    <header>
        <?php include "navbar.php"; ?>
    </header>

    <div class="login-wrapper">
        <div class="container">
            <div class="login-icon"></div>
            <h1>Connexion</h1>
            <p class="subtitle">Accédez à votre espace SUPERCARS</p>

            <?php if (isset($error_message)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <form action="Login.php" method="POST">
                <div class="input-box">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="votre@email.com" required>
                </div>

                <div class="input-box">
                    <label>Mot de passe</label>
                    <input type="password" name="mot_de_passe" placeholder="Votre mot de passe" required>
                </div>

                <button type="submit" class="btn">Se connecter</button>
            </form>

            <div class="register-link">
                <p>Pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>
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
                <a href="/conditions générales.html">conditions générales</a>
            </div>
        </div>
    </footer>
</body>
</html>