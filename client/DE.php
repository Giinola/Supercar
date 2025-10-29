<?php
session_start();
if (!isset($_SESSION['user_id'])) {

    header('Location: Login.php');
    exit;
}



$host = "mysql-ginola.alwaysdata.net";
$login = "ginola";
$pass = "AlwaysGinola1";
$dbname = "ginola_supercar";


$bdd = new mysqli($host, $login, $pass, $dbname);


if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $voiture = $_POST['voiture'];
    $date_essai = $_POST['date_essai'];
    $Heure = $_POST['Heure'];

    $sql = "INSERT INTO demandes_essai (nom, prenom, email, voiture, date_essai,Heure) 
            VALUES ('$nom', '$prenom', '$email', '$voiture', '$date_essai', '$Heure')";

    if ($bdd->query($sql) === TRUE) {
        $message = " Votre demande a été bien reçue. ";
    } else {
        $message = " Erreur : " . $bdd->error;
    }
}

$contenu = [];
$result = $bdd->query("SELECT * FROM essai");
while ($row = $result->fetch_assoc()) {
    $contenu[$row['nom_champ']] = $row['valeur'];
}
function genererOptions($donnees)
{
    $options = explode("\n", $donnees);
    $html = '';
    foreach ($options as $opt) {
        $opt = trim($opt);
        if (!empty($opt)) {
            $html .= "<option value=\"$opt\">$opt</option>\n";
        }
    }
    return $html;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'essai</title>
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
            padding: 0;
            margin: 0;
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

        /* Container principal */
        .container {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(51, 65, 85, 0.8);
            position: relative;
            animation: slideUp 0.6s ease-out;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
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
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
            border-radius: 25px 25px 0 0;
        }

        /* Titre */
        h2 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 10px;
            color: #ffffff;
            text-align: center;
            letter-spacing: 0.5px;
        }

        .subtitle {
            font-size: 16px;
            color: #94a3b8;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Message de confirmation */
        .message {
            background: rgba(6, 182, 212, 0.15);
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-weight: 600;
            color: #06b6d4;
            border-left: 4px solid #06b6d4;
            text-align: left;
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Formulaire */
        .form-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 120px 20px 20px 20px;
            position: relative;
            z-index: 1;
        }

        /* Labels */
        label {
            font-size: 14px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: -12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Champs du formulaire */
        input,
        select {
            width: 100%;
            padding: 14px 18px;
            border-radius: 12px;
            border: 2px solid #334155;
            background: rgba(15, 23, 42, 0.6);
            font-size: 16px;
            font-weight: 500;
            color: #e2e8f0;
            outline: none;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        input::placeholder {
            color: #64748b;
        }

        input:focus,
        select:focus {
            border-color: #06b6d4;
            background: rgba(15, 23, 42, 0.8);
            box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1);
        }

        /* Select personnalisé */
        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 6L11 1' stroke='%2306b6d4' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 18px center;
            padding-right: 45px;
        }

        select option {
            background: #1e293b;
            color: #e2e8f0;
            padding: 10px;
        }

        select optgroup {
            background: #0f172a;
            color: #06b6d4;
            font-weight: 700;
            font-size: 14px;
        }

        /* Bouton moderne */
        button {
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            padding: 16px;
            width: 100%;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.4);
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }

        button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        button:hover::before {
            left: 100%;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(249, 115, 22, 0.6);
        }

        button:active {
            transform: translateY(-1px);
        }

        /* Icône du bouton */
        button::after {
            content: '🚗';
            margin-left: 10px;
        }

        /* Info supplémentaire */
        .info-text {
            text-align: center;
            font-size: 13px;
            color: #64748b;
            margin-top: 20px;
            line-height: 1.5;
        }

        /* FOOTER CSS */
        footer {
            background: #0f172a;
            color: #94a3b8;
            text-align: center;
            padding: 60px 40px 30px;
            border-top: 1px solid #334155;
            margin-top: 60px;
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
            transition: transform 0.3s ease, filter 0.3s ease;
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
            .footer-content {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .footer-section {
                flex: none;
            }
        }

        /* Responsive */
        @media (max-width: 600px) {
            .container {
                padding: 30px 25px;
            }

            h2 {
                font-size: 26px;
            }

            input,
            select,
            button {
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php include "navbar.php"; ?>
    </header>


    <body>
        <header>
            <?php include "navbar.php"; ?>
        </header>

        <div class="form-wrapper">
            <div class="container">
                <h2>🚗 Demande d'Essai</h2>
                <p class="subtitle">Réservez votre essai de conduite premium</p>

                <form action="DE.php" method="POST">
                    <label>Nom</label>
                    <input type="text" name="nom" placeholder="Votre nom" required>

                    <label>Prénom</label>
                    <input type="text" name="prenom" placeholder="Votre prénom" required>

                    <label>Email</label>
                    <input type="email" name="email" placeholder="votre@email.com" required>

                    <label>Heure souhaitée</label>
                    <input type="time" name="Heure" min="08:00" max="18:00" required>

                    <label>Choisissez votre véhicule</label>
                    <select name="voiture" required>
                        <option value="" disabled selected>Sélectionnez un modèle</option>

                        <optgroup label="🏎️ Ferrari">
                            <option value="Ferrari SF90 Stradale">SF90 Stradale</option>
                            <option value="Ferrari Purosangue">Purosangue</option>
                            <option value="Ferrari Roma Spider">Roma Spider</option>
                            <option value="Ferrari F430">F430</option>
                        </optgroup>

                        <optgroup label="🔥 McLaren">
                            <option value="McLaren 765LT">765LT</option>
                            <option value="McLaren Artura">Artura</option>
                            <option value="McLaren GTS">GTS</option>
                            <option value="McLaren Senna">Senna</option>
                        </optgroup>

                        <optgroup label="⭐ Mercedes-AMG">
                            <option value="Mercedes-AMG C 63 S Coupé">C 63 S Coupé AMG</option>
                            <option value="Mercedes-AMG E 53 Coupé">E 53 Coupé AMG</option>
                            <option value="Mercedes-AMG Classe G (G 63)">Classe G (G 63)</option>
                        </optgroup>

                        <optgroup label="🚙 Range Rover">
                            <option value="Range Rover">Range Rover</option>
                            <option value="Range Rover Sport">Range Rover Sport</option>
                            <option value="Range Rover Evoque">Range Rover Evoque</option>
                            <option value="Range Rover SV">Range Rover SV</option>
                        </optgroup>
                    </select>

                    <label>Date d'essai</label>
                    <input type="date" name="date_essai" required>

                    <button type="submit">Envoyer la demande</button>
                </form>

                <p class="info-text">
                    Nos conseillers vous recontacteront sous 24h pour confirmer votre rendez-vous.
                </p>
            </div>
        </div> <!-- Fermeture du form-wrapper -->

        <!-- Footer en dehors du form-wrapper -->
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