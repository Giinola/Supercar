<?php
$conn = mysqli_connect("localhost", "root", "", "supercar");
if (!$conn) {
    die("Erreur de connexion à la base de données.");
}

$total_users = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM utilisateur"));
$total_essais = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM demandes_essai"));
$total_messages = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM contacts"));
?>

<!DOCTYPE html>
< lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #1c1c1c;
      color: #f1f1f1;
      margin: 0;
      padding: 0;
    }
    .sidebar {
      height: 100vh;
      width: 220px;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #2a2a2a;
      padding-top: 20px;
      box-shadow: 2px 0 5px rgba(252, 191, 73, 0.3);
      display: flex;
      flex-direction: column;
    }
    .sidebar h4 {
      color: #fcbf49;
      text-align: center;
      margin-bottom: 15px;
      font-size: 16px;
      font-weight: 600;
    }
    .sidebar a {
      padding: 12px 20px;
      text-decoration: none;
      color: #eaeaea;
      display: block;
      font-size: 15px;
      font-weight: 500;
    }
    .sidebar a:hover {
      background-color: #fcbf49;
      color: #000;
    }
    .sidebar a.active {
      background-color: #2a2a2a;
      color: #fcbf49;
    }
    .sidebar .secondary-menu {
      margin-top: 20px;
      border-top: 1px solid #444;
      padding-top: 15px;
    }
    .topbar {
      background-color: #2a2a2a;
      padding: 20px 40px;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .main-content {
  margin-left: 220px;
  padding: 0 20px;
  box-sizing: border-box;
  width: calc(100% - 220px);
}

/* Adapter la topbar et le header */
.topbar,
.header-section {
  margin-left: 220px;
  width: calc(100% - 220px);
  box-sizing: border-box;
  padding: 20px;
}

/* Responsive */
@media (max-width: 768px) {
  .sidebar {
    width: 100%;
    position: relative;
    height: auto;
  }

  .topbar,
  .header-section,
  .main-content {
    margin-left: 0;
    width: 100%;
  }
}
    .logo {
      font-size: 26px;
      font-weight: 700;
      color: #fcbf49;
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    .header-section {
      text-align: center;
      padding: 60px 20px 40px;
    }
    .header-section h1 {
      font-size: 38px;
      color: #fcbf49;
      margin-bottom: 10px;
    }
    .header-section p {
      font-size: 16px;
      color: #aaa;
    }
    .main {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px 40px;
    }
    .info-panels {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 30px;
    }
    .panel {
      background: linear-gradient(145deg, #2f2f2f, #262626);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(252, 191, 73, 0.15);
      transition: 0.3s ease;
    }
    .panel:hover {
      transform: scale(1.02);
    }
    .panel h3 {
      color: #fcbf49;
      margin-bottom: 15px;
      font-size: 20px;
    }
    .panel p {
      font-size: 36px;
      font-weight: bold;
      margin: 0;
      color: #fff;
    }
    .shortcuts {
      margin-top: 1px;
      text-align: center;
    }
    .shortcuts a {
      display: inline-block;
      margin: 10px;
      padding: 12px 24px;
      background-color: #fcbf49;
      color: #1c1c1c;
      text-decoration: none;
      border-radius: 30px;
      font-weight: 500;
      transition: 0.3s;
    }
    .shortcuts a:hover {
      background-color: #e0a935;
    }
  </style>
</head>
<div class="sidebar">
    <div>
      <h4>Visualisation</h4>
      <a href="Acceuil.php">Tableau de bord</a>
      <a href="Demande_essai.php">Demandes d'essai</a>
      <a href="Utilisateurs.php">Utilisateurs</a>
      <a href="Contact.php">Contact</a>
      <div class="secondary-menu">
        <h4>Modification</h4>
        <a href="admin_acceuil.php">Accueil</a>
            <a href="admin_voitures.php">Voiture</a>
            <a href="admin_essai.php">Demandes essai</a>
            <a href="admin_services.php">Services</a>
            <a href="Admin_contact.php">Contact</a>
      </div>
    </div>
  </div>
<body>
  <div class="topbar">
    <div class="logo">SUPERCAR</div>
  </div>
  <div class="header-section">
    <h1>Accueil Administration</h1>
    <p>Gérez votre page ici</p>
  </div>
  <div class="main">
    <div class="info-panels">
      <div class="panel">
        <h3>Utilisateurs inscrits</h3>
        <p><?php echo $total_users; ?></p>
      </div>
      <div class="panel">
        <h3>Demandes d'essai</h3>
        <p><?php echo $total_essais; ?></p>
      </div>
      <div class="panel">
        <h3>Messages reçus</h3>
        <p><?php echo $total_messages; ?></p>
      </div>
    </div>
   
</body>
</html>
