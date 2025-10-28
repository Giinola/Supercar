<?php
session_start();

// Si l'utilisateur est déjà connecté, le rediriger directement vers 'DE.php'
if (isset($_SESSION['user_id'])) {
    header("Location: DE.php");  // Redirige directement vers DE.php
    exit();
}

$host = "mysql-ginola.alwaysdata.net";  
$login = "ginola";                   
$pass = "AlwaysGinola1";            
$dbname = "ginola_supercar";        

// Connexion à la base de données
$bdd = new mysqli($host, $login, $pass, $dbname);

// Vérifier la connexion à la base de données
if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);  
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer et valider les entrées
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);  // Validation de l'email
    if (!$email) {
        $error_message = "L'email est invalide";
    } else {
        $mot_de_passe = $_POST['mot_de_passe'];

        // Utilisation de requêtes préparées pour éviter l'injection SQL
        $sql = "SELECT id FROM utilisateur WHERE email = ? AND mot_de_passe = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->bind_param("ss", $email, $mot_de_passe);  // "ss" signifie que les deux paramètres sont des chaînes
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];

            // Une fois connecté, redirige vers DE.php
            header("Location: DE.php");
            exit();
        } else {
            $error_message = "Identifiants incorrects";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>

<h2>Connexion</h2>
    <h5>Veillez vous connecter pour profiter du service</h5>
<?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>

<form action="login.php" method="POST">
    <label>Email :</label>
    <input type="email" name="email" required>

    <label>Mot de passe :</label>
    <input type="password" name="mot_de_passe" required>

    <button type="submit">Se connecter</button>
</form>

</body>
</html>
