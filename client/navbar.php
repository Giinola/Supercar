<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Vente de Voitures</title>
    
    <style> 
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
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
            transition: all 0.3s ease;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ff5733;
            text-decoration: none;
            z-index: 101;
        }

        .navbar {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .navbar a {
            font-size: 16px;
            color: white;
            text-decoration: none;
            margin: 0 15px;
            transition: color 0.3s ease-in-out;
            white-space: nowrap;
        }

        .navbar a:hover {
            color: #ff5733;
        }

        .auth-links {
            display: flex;
            gap: 15px;
        }

        .auth-links a {
            font-size: 16px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            background: #ff5733;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .auth-links a:hover {
            background: white;
            color: #ff5733;
        }

        /* Bouton hamburger */
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            z-index: 101;
        }

        .menu-toggle span {
            width: 25px;
            height: 3px;
            background: white;
            margin: 3px 0;
            transition: all 0.3s ease;
            border-radius: 3px;
        }

        .menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .header {
                padding: 15px 5%;
            }

            .navbar a {
                margin: 0 10px;
                font-size: 15px;
            }

            .auth-links a {
                padding: 6px 12px;
                font-size: 15px;
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
            }

            .navbar {
                position: fixed;
                top: 0;
                right: -100%;
                width: 280px;
                height: 100vh;
                background: rgba(0, 0, 0, 0.95);
                flex-direction: column;
                justify-content: flex-start;
                padding-top: 80px;
                transition: right 0.4s ease;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.3);
            }

            .navbar.active {
                right: 0;
            }

            .navbar a {
                width: 100%;
                padding: 15px 30px;
                margin: 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .auth-links {
                position: fixed;
                bottom: 20px;
                right: -100%;
                flex-direction: column;
                width: 280px;
                padding: 0 30px;
                transition: right 0.4s ease;
            }

            .auth-links.active {
                right: 0;
            }

            .auth-links a {
                width: 100%;
                text-align: center;
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 12px 5%;
            }

            .logo {
                font-size: 20px;
            }

            .navbar {
                width: 100%;
            }

            .auth-links {
                width: 100%;
            }
        }

        /* Overlay pour fermer le menu */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99;
        }

        .overlay.active {
            display: block;
        }
    </style>
</head>
<body>

<header class="header">
    <a href="#" class="logo">SUPERCARS</a>
    
    <nav class="navbar">
        <a href="index.php">Accueil</a>
        <a href="Voitures.php">Modèles</a>
        <a href="DE.php">Demande d'essai</a>
        <a href="Service.php">Services</a>
        <a href="contact.php">Contact</a>
    </nav>

    <div class="auth-links">
        <a href="Login.php">Se connecter</a>
        <a href="inscription.php">S'inscrire</a>
    </div>

    <div class="menu-toggle">
        <span></span>
        <span></span>
        <span></span>
    </div>
</header>

<div class="overlay"></div>

<script>
    const menuToggle = document.querySelector('.menu-toggle');
    const navbar = document.querySelector('.navbar');
    const authLinks = document.querySelector('.auth-links');
    const overlay = document.querySelector('.overlay');

    menuToggle.addEventListener('click', function() {
        menuToggle.classList.toggle('active');
        navbar.classList.toggle('active');
        authLinks.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    // Fermer le menu en cliquant sur l'overlay
    overlay.addEventListener('click', function() {
        menuToggle.classList.remove('active');
        navbar.classList.remove('active');
        authLinks.classList.remove('active');
        overlay.classList.remove('active');
    });

    
    const navLinks = document.querySelectorAll('.navbar a, .auth-links a');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            menuToggle.classList.remove('active');
            navbar.classList.remove('active');
            authLinks.classList.remove('active');
            overlay.classList.remove('active');
        });
    });
</script>

</body>
</html>