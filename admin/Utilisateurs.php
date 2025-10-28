<?php
include 'menu.php'; 
$host = "mysql-ginola.alwaysdata.net";  
$login = "ginola";                  
$pass = "AlwaysGinola1";            
$dbname = "ginola_supercar";        
 
 
$bdd = new mysqli($host, $login, $pass, $dbname);
 
 
if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);  
}
 

 $requete="SELECT* FROM utilisateur";
 $resultats=mysqli_query($bdd, $requete);
 // Suppression
if (isset($_POST['supprimer_id'])) {
    $id = intval($_POST['supprimer_id']);
    $stmt = $bdd->prepare("DELETE FROM utilisateur WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

if (isset($_POST['modifier_id'])) {
    $id = intval($_POST['modifier_id']);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $stmt = $bdd->prepare("UPDATE utilisateur SET nom=?, prenom=?, email=?, nom_utilisateur=?, mot_de_passe=? WHERE id=?");
    $stmt->bind_param("sssssi", $nom, $prenom, $email, $nom_utilisateur, $mot_de_passe, $id);
    $stmt->execute();
}

 
 
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1c1c1c;
            color: #eaeaea;
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
            margin-bottom: 30px;
            font-size: 24px;
        }
        .table thead {
            background-color: #fcbf49;
            color: #1c1c1c;
        }
        .btn-primary {
            background-color: #fcbf49;
            border: none;
            font-size: 12px;
            padding: 5px 10px;
            color: #1c1c1c;
        }
        .btn-primary:hover {
            background-color: #e0ab30;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
            font-size: 12px;
            padding: 5px 10px;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .toggle-password {
            cursor: pointer;
            color: #fcbf49;
            margin-left: 6px;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="main-content">
        <h2>Gestion des Utilisateurs</h2>

        <div class="table-responsive">
            <table class="table table-bordered align-middle table-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Nom d'utilisateur</th>
                        <th>Mot de passe</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultats)) { ?>
<tr>
  <form method="post">
    <td>
      <input type="hidden" name="modifier_id" value="<?= $row['id'] ?>">
      <?= $row['id'] ?>
    </td>
    <td><input type="text" name="nom" value="<?= $row['nom'] ?>" class="form-control form-control-sm"></td>
    <td><input type="text" name="prenom" value="<?= $row['prenom'] ?>" class="form-control form-control-sm"></td>
    <td><input type="email" name="email" value="<?= $row['email'] ?>" class="form-control form-control-sm"></td>
    <td><input type="text" name="nom_utilisateur" value="<?= $row['nom_utilisateur'] ?>" class="form-control form-control-sm"></td>
    <td><input type="text" name="mot_de_passe" value="<?= $row['mot_de_passe'] ?>" class="form-control form-control-sm"></td>
    <td>
  </form>

  <form method="post" style="display:inline;">
    <input type="hidden" name="supprimer_id" value="<?= $row['id'] ?>">
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</button>
  </form>
    </td>
</tr>
<?php } ?>

                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const span = this.previousElementSibling;
                if (span.textContent === '••••••••') {
                    span.textContent = 'motdepasse123';
                    this.textContent = 'Masquer';
                } else {
                    span.textContent = '••••••••';
                    this.textContent = 'Afficher';
                }
            });
        });
    </script>
</body>
</html>
