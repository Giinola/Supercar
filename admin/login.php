<?php
$host = "mysql-ginola.alwaysdata.net";  
$login = "ginola";                   
$pass = "AlwaysGinola1";            
$dbname = "ginola_supercar";        

// Connexion à la base de données
$bdd = new mysqli($host, $login, $pass, $dbname);

// Vérification de la connexion
if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);  
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Remplacer $conn par $bdd pour la connexion à la base de données
    $nom_utilisateur = mysqli_real_escape_string($bdd, $_POST['nom_utilisateur']);
    $mot_de_passe = mysqli_real_escape_string($bdd, $_POST['mot_de_passe']);

    // Requête SQL pour vérifier les identifiants
    $query = "SELECT * FROM admin WHERE nom = '$nom_utilisateur' AND mot_de_passe = '$mot_de_passe'";
    $result = mysqli_query($bdd, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $nom_utilisateur;
        header("Location: admin_acceuil.php");
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - SuperCar Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
 
    body {
      height: 100vh;
      background: linear-gradient(180deg, #0f1115, #1b1f25);
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
    }
 
    .login-container {
      background: #161a1f;
      padding: 40px 50px;
      border-radius: 12px;
      box-shadow: 0 0 25px rgba(0,191,255,0.2);
      width: 380px;
      text-align: center;
      animation: fadeIn 0.8s ease-in-out;
    }
 
    .login-container h2 {
      color: #00bfff;
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 10px;
    }
 
    .login-container p {
      color: #aaa;
      font-size: 14px;
      margin-bottom: 30px;
    }
 
    .login-container input {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 15px;
      background-color: #1f242b;
      color: #fff;
      outline: none;
      transition: all 0.3s ease;
    }
 
    .login-container input:focus {
      border: 1px solid #00bfff;
      background-color: #20252c;
    }
 
    .login-container button {
      width: 100%;
      padding: 12px;
      background-color: #00bfff;
      border: none;
      border-radius: 8px;
      color: #fff;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }
 
    .login-container button:hover {
      background-color: #0095cc;
      transform: translateY(-2px);
    }
 
    .error-message {
      background-color: rgba(255, 0, 0, 0.1);
      color: #ff4d4d;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 15px;
      font-size: 14px;
    }
 
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
 
    .footer {
      text-align: center;
      margin-top: 20px;
      font-size: 13px;
      color: #777;
    }
  </style>
</head>
<body>
 
  <div class="login-container">
    <h2>SUPER<span style="color:#fff;">CAR</span></h2>
    <p>Connexion à l’espace d’administration</p>
 
    <?php if ($error): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
 
    <form method="POST" action="">
      <input type="text" name="nom_utilisateur" placeholder="Nom d'utilisateur" required>
      <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
      <button type="submit">Se connecter</button>
    </form>
 
    <div class="footer">
      © 2025 SuperCar | Admin
    </div>
  </div>
 
</body>
</html>
