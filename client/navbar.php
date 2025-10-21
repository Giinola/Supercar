<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Vente de Voitures</title>
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<header class="header">
        <a href="#" class="logo">SUPERCARS</a>
    
        <nav class="navbar">
            <a href="index.php">Accueil</a>
            <a href="Voitures.php">Modèles</a>
            <a href="demande_essai.php">Demande d'essai</a>
            <a href="Service.php">Services</a>
            <a href="contact.php">Contact</a>
        </nav>
    
        <div class="auth-links">
            <a href="Login.php">Se connecter</a>
            <a href="inscription.php">S'inscrire</a>
        </div>
    </header>
    <style> 
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
}

.navbar {
    flex-grow: 1;
    display: flex;
    justify-content: center; /* Centre le menu */
}

.navbar a {
    font-size: 16px;
    color: white;
    text-decoration: none;
    margin: 0 15px;
    transition: color 0.3s ease-in-out;
}

.navbar a:hover {
    color: #ff5733;
}

        /* Styles spécifiques pour "Se connecter" et "S'inscrire" */
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
    background: #ff5733; /* Ajoute un fond pour les distinguer */
}

.auth-links a:hover {
    background: white;
    color: #ff5733;
}

.logo {
    font-size: 24px;
    font-weight: bold;
    color: #ff5733;
    text-decoration: none;
}
    </style>