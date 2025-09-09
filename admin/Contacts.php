<?php
$conn = mysqli_connect("localhost", "root", "", "supercar");
if (!$conn) {
    die("Erreur de connexion à la base de données.");
}
$requete = "SELECT * FROM contacts";
$result = mysqli_query($conn, $requete);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Messages de contact</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #1c1c1c;
      color: #f1f1f1;
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
    .main-content {
      margin-left: 220px;
      padding: 30px;
      background-color: #1c1c1c;
      min-height: 100vh;
    }
    h2 {
      color: #fcbf49;
      margin-bottom: 20px;
      font-size: 22px;
    }
    .table thead {
      background-color: #fcbf49;
      color: #1c1c1c;
    }
    .table td, .table th {
      vertical-align: middle;
    }
  </style>
</head>
<body>
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

  <div class="main-content">
    <h2>Messages de contact</h2>
    <div class="table-responsive">
      <table class="table table-bordered table-dark">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Email</th>
            <th>Message</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?php echo $row['nom']; ?></td>
            <td><?php echo $row['adresse']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['messages']; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
