<?php 
include "db.php";
$contenu = [];
$resultats = mysqli_query($bdd, "SELECT * FROM accueil");
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
    <title>Vente de Voitures</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="">

    <style>
        
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif; /* Applique la police Poppins */
}


body {
    background: #eaeaea; /* Couleur de fond gris clair */
    padding-top: 80px; /* Espace réservé pour éviter que l'en-tête fixe masque le contenu */
}

.home {
    position: relative;
    align-items: center;
    width: 100%;
    height: 100vh;
    justify-content: space-between;
    display: flex;
    text-align: center;
    padding: 50px 8% 0;
    overflow: hidden;
}

.home-content {
    max-width: 630px;
}

.home-content h1 {
    animation: slideRight 1s ease forwards;
    font-size: 50px;
    line-height: 1.2;
    color: #222;
    margin-bottom: 10px;
}

.home-content p {
    font-size: 20px;
    margin: 15px 0 30px;
}

.home-img {
    position: relative;
    right: -15%;
    width: 450px;
    height: 450px;
    transform: rotate(45deg);
}

.home-img .rhombus {
    position: absolute;
    width: 90%;
    height: 90%;
    background: #eaeaea;
    border: 25px solid #ff5733;
    box-shadow: -15px 15px 15px rgba(0, 0, 0, 0.2);
}

.home-img .rhombus img {
    position: absolute;
    top: 90px;
    left: -225px;
    max-width: 750px;
    transform: rotate(-45deg);
}

/* Deuxième losange d'arrière-plan */
.home .rhombus2 {
    position: absolute;
    top: -25%;
    right: -25%;
    width: 650px;
    height: 650px; /* Correction de la majuscule "Px" */
    background: #ff5733;
    transform: rotate(45deg);
    z-index: -1;
}

/* === Animation pour le texte === */
@keyframes slideRight {
    0% {
        transform: translateX(-100px);
        opacity: 0;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideTop {
    0% {
        transform: translateY(100px);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

/* === Pied de page === */
footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px 20px;
    font-size: 14px;
}

        .modèle {
            color: #222;
            padding: 50px;
            text-align: center;
        }

        .modèle h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .modèle p {
            font-size: 18px;
            margin-bottom: 20px;
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
            width: 300px;
            transition: transform 0.2s;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .car img {
            width: 100%;
            height: 200px; /* Taille fixe pour les images */
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s, filter 0.3s; /* Ajout d'une transition pour l'effet de survol */
        }

        .car img:hover {
            transform: scale(1.05); /* Légère augmentation de la taille de l'image au survol */
            filter: brightness(0.9); /* Assombrir légèrement l'image au survol */
        }

        .car:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0,0,0,0.4);
        }

        .about {
            padding: 60px 10%;
            background: #f4f4f4;
            text-align: center;
        }

        .about-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            flex-wrap: wrap;
        }

        .about-text {
            max-width: 600px;
            text-align: left;
        }

        .about-text h2 {
            font-size: 36px;
            color: #222;
            margin-bottom: 15px;
        }

        .about-text p {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .about-text .btn {
            background-color: #ff5733;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
        }

        .about-text .btn:hover {
            background-color: #e04e2e;
        }

        .about-image img {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .about-content {
                flex-direction: column;
                text-align: center;
            }

            .about-text {
                text-align: center;
            }
        }

        .carrousel-container {
            margin: 50px auto;
            width: 80%;
        }

        .carousel-item img {
            width: 100%;
            height: 500px; /* Ajuste cette hauteur selon tes besoins */
            object-fit: cover; /* Empêche la distorsion et recadre l'image */
            border-radius: 10px;
        }

        footer {
            background-color: #ff5733;
            color: #222;
            padding: 20px;
            text-align: center;
        }

        footer a {
            color: white;
            margin: 0 10px;
        }


    </style>
</head>
<body>
    <header>
<?php include "navbar.php"; ?>
     </header>
    <section class="home">
    <div class="home-content">
        <h1><?php echo isset($contenu['titre_accueil']) ? $contenu['titre_accueil'] : ''; ?></h1>
        <p><?php echo isset($contenu['texte_accueil']) ? $contenu['texte_accueil'] : ''; ?></p>
    </div>
    <div class="home-img">
        <div class="rhombus">
            <img src="<?php echo isset($contenu['image_accueil']) ? $contenu['image_accueil'] : ''; ?>" alt="Image Accueil">
        </div>
    </div>
</section>

<section class="about">
    <div class="about-content">
        <div class="about-text">
            <h2><?php echo isset($contenu['titre_apropos']) ? $contenu['titre_apropos'] : ''; ?></h2>
            <p><?php echo isset($contenu['p1_apropos']) ? $contenu['p1_apropos'] : ''; ?></p>
            <p><?php echo isset($contenu['p2_apropos']) ? $contenu['p2_apropos'] : ''; ?></p>
            <a href="Voitures.php" class="btn"><?php echo isset($contenu['bouton_apropos']) ? $contenu['bouton_apropos'] : ''; ?></a>
        </div>
        <div class="about-image">
            <img src="<?php echo isset($contenu['image_apropos']) ? $contenu['image_apropos'] : ''; ?>" alt="Image À propos">
        </div>
    </div>
</section>

<div id="carrouselVoitures" class="carousel slide carrousel-container" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?php echo isset($contenu['carousel_item'])? $contenu['carousel_item'] : ''; ?>" class="d-block w-100" alt="Image Carrousel">
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
        <p>&copy; 2025-2028 Supercars.fr — Tous droits réservés.</p>
        <div class="footer-links">
            <a href="/mentions-legales.html">Mentions légales</a>
            <a href="/politique-confidentialite.html">Confidentialité</a>
            <a href="/conditions-generales.html">Conditions générales</a>
        </div>
    </div>
</footer>


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
      
       