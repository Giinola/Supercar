<?php
$host = "mysql-ginola.alwaysdata.net";  
$login = "ginola";                  
$pass = "AlwaysGinola1";            
$dbname = "ginola_supercar";        
 
 
$bdd = new mysqli($host, $login, $pass, $dbname);
 
 
if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);  
}
 

$contenu = [];
$resultats = mysqli_query($bdd, "SELECT * FROM range_rover ORDER BY id ASC"); 


if ($resultats) {
    while ($ligne = mysqli_fetch_assoc($resultats)) {

        $contenu[$ligne['id']] = $ligne;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Modèles</title>
    <style>
   

      body {
    padding-top: 100px;
    font-family: 'Poppins', sans-serif;
    text-align: center;
    background: #0f172a;
    color: #cbd5e1;
}

.modèle {
    padding: 50px 20px;
    background: #0f172a;
    text-align: center;
}

.modèle h1 {
    font-size: 36px;
    color: #ffffff;
    margin-bottom: 20px;
}

.modèle p {
    font-size: 18px;
    color: #94a3b8;
    max-width: 900px;
    margin: 0 auto 40px;
}

.marque-info {
    padding: 80px 30px 60px;
    margin-bottom: 30px;
    text-align: center;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    position: relative;
    overflow: hidden;
}

.marque-info::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 50%, rgba(6, 182, 212, 0.1), transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.1), transparent 50%);
    z-index: 1;
}

.marque-nom {
    color: #ffffff;
    font-size: 2.5em;
    margin: 0 0 15px 0;
    font-weight: bold;
    position: relative;
    z-index: 2;
}

.marque-info h1 {
    color: #ffffff;
    font-size: 2.5em;
    margin: 0 0 15px 0;
    font-weight: bold;
    position: relative;
    z-index: 2;
}

.marque-description {
    color: #94a3b8;
    font-size: 1.1em;
    line-height: 1.6;
    margin: 0;
    font-weight: normal;
    position: relative;
    z-index: 2;
}

.marque-info p {
    color: #94a3b8;
    font-size: 1.1em;
    line-height: 1.6;
    margin: 0;
    font-weight: normal;
    position: relative;
    z-index: 2;
    max-width: 900px;
    margin: 0 auto;
}

.car-models {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: center;
}

.car-card {
    background: #1e293b;
    width: 500px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 30px;
    position: relative;
    border: 1px solid #334155;
}

.car-card::before {
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

.car-card:hover::before {
    opacity: 1;
}

.car-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(6, 182, 212, 0.3);
    border-color: #06b6d4;
}

.car-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.car-card:hover img {
    transform: scale(1.08);
}

.car-card h4 {
    font-size: 24px;
    color: #ffffff;
    text-align: center;
    margin: 15px 0;
}

.car-card p {
    font-size: 16px;
    color: #94a3b8;
    padding: 0 15px;
    margin-bottom: 20px;
}

.car-card p strong {
    color: #06b6d4;
    font-size: 20px;
}

.button {
    display: block;
    text-align: center;
    text-decoration: none;
    background: linear-gradient(135deg, #f97316, #ea580c);
    color: white;
    font-weight: bold;
}

.try-button-container {
    text-align: center;
    margin-bottom: 20px;
}

.try-button {
    display: inline-block;
    padding: 12px 28px;
    background: linear-gradient(135deg, #f97316, #ea580c);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(249, 115, 22, 0.4);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 14px;
}

.try-button:hover {
    background: linear-gradient(135deg, #ea580c, #f97316);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(249, 115, 22, 0.5);
}

.car-card label {
    display: inline-block;
    padding: 10px 20px;
    background: linear-gradient(135deg, #f97316, #ea580c);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    transition: all 0.3s ease;
    text-align: center;
    cursor: pointer;
}

.car-card label:hover {
    background: linear-gradient(135deg, #ea580c, #f97316);
    transform: translateY(-2px);
}

footer {
    background: #0f172a;
    color: #94a3b8;
    text-align: center;
    padding: 60px 40px 30px;
    border-top: 1px solid #334155;
    margin-top: 60px;
}

.catalog {
    display: flex;
    justify-content: center;
    gap: 20px;
    padding: 20px;
    flex-wrap: wrap;
}

.car {
    background: #1e293b;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    padding: 10px;
    width: 200px;
    transition: transform 0.2s;
    text-decoration: none;
    color: inherit;
}

.car img {
    width: 100%;
    height: auto;
    max-height: 150px;
    border-radius: 10px;
}

.car h3 {
    margin: 10px 0 0;
    font-size: 18px;
}

.car:hover {
    transform: scale(1.05);
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

.info-button {
    background: transparent;
    color: #06b6d4;
    border: 2px solid #06b6d4;
    border-radius: 50px;
    padding: 10px 20px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    margin-left: 10px;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-button:hover {
    background: rgba(6, 182, 212, 0.1);
    transform: translateY(-2px);
}

.extra-info {
    margin-top: 15px;
    font-size: 0.95em;
    color: #cbd5e1;
    background: #0f172a;
    padding: 15px;
    border-radius: 12px;
    border: 1px solid #334155;
}

.extra-info p {
    margin: 8px 0;
    text-align: left;
}

.extra-info strong {
    color: #06b6d4;
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

    .car-models {
        gap: 20px;
    }

    .car-card {
        width: 100%;
        max-width: 500px;
    }
}
    </style>
</head>
<script>
function toggleInfo(button) {
    const infoDiv = button.closest('.car-card').querySelector('.extra-info');
    if (infoDiv.style.display === 'none' || infoDiv.style.display === '') {
        infoDiv.style.display = 'block';
        button.textContent = 'Masquer les infos';
    } else {
        infoDiv.style.display = 'none';
        button.textContent = 'En savoir plus';
    }
}
</script>

<body>
    <header>
<?php include "navbar.php"; ?>
     </header>


   
        

    <section class="brand ford">
    <p style="text-align:center; max-width:800px; margin:0 auto 30px;">
</p>
<div class="marque-info">

        <h1>Range Rover</h1>
        <p>Le Range Rover est l'icône du SUV de luxe. Il combine un raffinement exceptionnel, un confort de première classe et des technologies de pointe avec des capacités tout-terrain légendaires.</p>
    
</div>
            <div class="car-models">
<?php
foreach ($contenu as $voiture) {
    $nom = trim($voiture['nom_complet']);
    $img = trim($voiture['chemin_image'] ?? '');
    if ($img !== '') $img = str_replace(' ', '%20', $img);
    $desc = $voiture['description_courte'] ?? 'Description non disponible';
    $prix = $voiture['prix_estime'] ?? 'Prix non disponible';
    $puissance = $voiture['puissance_ch'] ?? 'Puissance non disponible';
    $classe = $voiture['classe'] ?? 'Classe non disponible';
    $carrosserie = $voiture['carrosserie'] ?? 'Carrosserie non disponible';

    // Sécuriser les valeurs
    $nom_completH  = htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
    $imgH  = htmlspecialchars($img, ENT_QUOTES, 'UTF-8');
    $descH = htmlspecialchars($desc, ENT_QUOTES, 'UTF-8');
    $prixH = htmlspecialchars($prix, ENT_QUOTES, 'UTF-8');
    $puissanceH = htmlspecialchars($puissance, ENT_QUOTES, 'UTF-8');
    $classeH = htmlspecialchars($classe, ENT_QUOTES, 'UTF-8');
    $carrosserieH = htmlspecialchars($carrosserie, ENT_QUOTES, 'UTF-8');
    ?>
    <div class="car-card">
        <h4><?= $nom_completH ?></h4>
        <?php if ($imgH): ?><img src="<?= $imgH ?>" alt="<?= $nom_completH ?>"><?php endif; ?>
        <p><?= $descH ?></p>
        <p><strong>PRIX: <?= $prixH ?>$</strong></p>
        <div class="try-button-container">
            <a href="DE.php?modele=<?= urlencode($nom) ?>" class="try-button">Essayer</a>
            <button class="info-button" onclick="toggleInfo(this)">En savoir plus</button>
            <div class="extra-info" style="display:none;">
                <p><strong>Puissance :</strong> <?= $puissanceH ?></p>
                <p><strong>Classe :</strong> <?= $classeH ?></p>
                <p><strong>Carrosserie :</strong> <?= $carrosserieH ?></p>
            </div>
        </div>
    </div>
<?php } ?>

</div>
</div>

    </section>

    <footer>
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
          
    </footer>

</body>
</html>
   
   
   
