<?php
include 'menu.php';
include 'db.php';

// Mise à jour du statut (version très simple)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['new_status'])) {
  $id = (int)$_POST['id'];
  $new = $_POST['new_status'] === 'approuve' ? 'approuve' : 'refuse'; // whitelist basique
  mysqli_query($conn, "UPDATE demandes_essai SET status='$new' WHERE id=$id");
}

// Récupération des demandes
$sql = "SELECT id, nom, email, voiture, date_essai, COALESCE(heure, Heure) AS heure,
               IFNULL(status,'en_attente') AS status
        FROM demandes_essai
        ORDER BY date_essai DESC, id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Demandes d'essai</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* Thème simple sombre */
:root{ --bg:#1c1c1c; --panel:#222428; --panel2:#2a2d32; --text:#f1f1f1; --accent:#fcbf49; }
body{ background:var(--bg) !important; color:var(--text); font-family: Poppins, Arial, sans-serif; }

/* Si tu as une sidebar fixe de 220px */
.main-content{ margin-left:220px; min-height:100vh; padding:28px; box-sizing:border-box; }

/* Titre */
h2{ color:var(--accent); margin:0 0 18px; font-weight:700; }
h2::after{ content:""; display:block; width:64px; height:3px; background:var(--accent); border-radius:99px; margin-top:8px; }

/* Carte du tableau (look moderne mais simple) */
.table-card{ background:linear-gradient(180deg,var(--panel),var(--panel2)); border:1px solid rgba(255,255,255,.08); border-radius:12px; overflow:hidden; }

/* Tableau sombre */
.table{ margin:0; color:var(--text); border-color:rgba(255,255,255,.08); }
.table thead{ background:var(--accent); color:#1b1b1b; }
.table thead th{ border:0 !important; padding:14px 16px; }
.table td,.table th{ border-color:rgba(255,255,255,.08) !important; padding:12px 16px; background:transparent; }
.table-striped tbody tr:nth-of-type(odd){ background:rgba(255,255,255,.02); }
.table-hover tbody tr:hover{ background:rgba(252,191,73,.10); }

/* Badge statut très simple */
.badge-status{ display:inline-block; padding:.35rem .6rem; border-radius:999px; font-weight:700; font-size:.8rem; }
.en_attente{ background:rgba(255,255,255,.12); color:#cfd5df; }
.approuve{   background:rgba(34,197,94,.18);  color:#86efac; }
.refuse{     background:rgba(244,63,94,.18);  color:#fda4af; }

/* Boutons simples (jaune / contour rouge) */
.actions{ display:flex; gap:.5rem; justify-content:flex-end; flex-wrap:wrap; }
.btn-approve{ background:var(--accent); color:#1b1b1b; border:0; border-radius:8px; padding:.4rem .7rem; font-weight:700; }
.btn-approve:disabled{ opacity:.6; }
.btn-refuse{ background:transparent; color:#f08a8f; border:1px solid #f08a8f; border-radius:8px; padding:.4rem .7rem; font-weight:700; }
.btn-refuse:disabled{ opacity:.6; }

/* Contenu du tableau en blanc (uniquement le tbody) */
.table tbody,
.table tbody td,
.table tbody th{
  color:#fff !important;
}

/* Éléments fréquents à l'intérieur des cellules */
.table tbody a,
.table tbody small,
.table tbody .text-muted{
  color:#fff !important;
  text-decoration: none;
}

/* On garde l'en-tête tel que défini (jaune + texte foncé) */
.table thead,
.table thead th{
  color:#1b1b1b !important; /* déjà dans ton thème, on renforce juste */
}

</style>
</head>
<body>


<div class="main-content">
  <h2>Demandes d'essai</h2>

  <div class="table-responsive table-card">
    <table class="table table-striped table-hover align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Nom</th>
          <th>Email</th>
          <th>Modèle</th>
          <th>Date</th>
          <th>Heure</th>
          <th>Statut</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): 
            $id    = (int)$row['id'];
            $nom   = $row['nom'] ?? '';
            $mail  = $row['email'] ?? '';
            $voit  = $row['voiture'] ?? '';
            $date  = !empty($row['date_essai']) ? date('d/m/Y', strtotime($row['date_essai'])) : '';
            $heure = $row['heure'] ?? '';
            $stat  = $row['status'] ?? 'en_attente';
          ?>
          <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $nom; ?></td>
            <td><?php echo $mail; ?></td>
            <td><?php echo $voit; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo $heure; ?></td>
            <td><span class="badge-status <?php echo $stat; ?>"><?php echo str_replace('_',' ', $stat); ?></span></td>
            <td class="text-end">
              <form method="post" class="actions">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" name="new_status" value="approuve" class="btn-approve" <?php echo $stat==='approuve'?'disabled':''; ?>>Approuver</button>
                <button type="submit" name="new_status" value="refuse" class="btn-refuse" <?php echo $stat==='refuse'?'disabled':''; ?>>Refuser</button>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="8" class="text-center py-4">Aucune demande</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
