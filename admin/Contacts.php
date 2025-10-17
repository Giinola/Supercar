<?php
include 'menu.php';
include 'db.php';
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
            <td><?php echo htmlspecialchars($row['nom']); ?></td>
            <td><?php echo htmlspecialchars($row['adresse']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['messages']); ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
