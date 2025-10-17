<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: " . ($_GET['redirect'] ?? 'dashboard.php'));  // Redirection après connexion
    exit();
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
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $sql = "SELECT id FROM utilisateur WHERE email = '$email' AND mot_de_passe = '$mot_de_passe'";
    $result = $bdd->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];

        // Vérifier s'il y a une redirection en attente
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'dashboard.php';
        header("Location: $redirect");
        exit();
    } else {
        $error_message = "Identifiants incorrects";
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
<?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>

<form action="login.php?redirect=<?php echo $_GET['redirect'] ?? ''; ?>" method="POST">
    <label>Email :</label>
    <input type="email" name="email" required>

    <label>Mot de passe :</label>
    <input type="password" name="mot_de_passe" required>

    <button type="submit">Se connecter</button>
</form>

</body>
</html>
