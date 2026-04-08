<?php
session_start();
 
// Vide toutes les variables de session
$_SESSION = [];
 
// Détruit le cookie de session côté client
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
 
// Détruit la session côté serveur
session_destroy();
 
// Redirige vers la page de connexion
header("Location: login.php");
exit();
 