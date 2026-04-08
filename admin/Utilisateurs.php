<?php
session_start();
 
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
 
require_once 'db.php';
 
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}
 
$success = false;
$error = '';
$success_msg = '';
 
// =====================================================
//  Suppression d'un utilisateur
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer_id'])) {
 
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erreur de sécurité.";
    } else {
        try {
            $id = (int) $_POST['supprimer_id'];
            $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $success = true;
            $success_msg = "Utilisateur supprimé avec succès";
        } catch (PDOException $e) {
            $error = "Erreur lors de la suppression.";
        }
    }
}
 
// =====================================================
//  Modification d'un utilisateur
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier_id'])) {
 
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erreur de sécurité.";
    } else {
        try {
            $stmt = $pdo->prepare("
                UPDATE utilisateur
                SET nom = :nom,
                    prenom = :prenom,
                    email = :email,
                    nom_utilisateur = :nom_utilisateur,
                    mot_de_passe = :mot_de_passe
                WHERE id = :id
            ");
            $stmt->execute([
                ':id'              => (int) $_POST['modifier_id'],
                ':nom'             => trim($_POST['nom'] ?? ''),
                ':prenom'          => trim($_POST['prenom'] ?? ''),
                ':email'           => trim($_POST['email'] ?? ''),
                ':nom_utilisateur' => trim($_POST['nom_utilisateur'] ?? ''),
                ':mot_de_passe'    => $_POST['mot_de_passe'] ?? '',
            ]);
            $success = true;
            $success_msg = "Utilisateur modifié avec succès";
        } catch (PDOException $e) {
            $error = "Erreur lors de la modification.";
        }
    }
}
 
// =====================================================
//  Récupération des utilisateurs
// =====================================================
$utilisateurs = [];
try {
    $stmt = $pdo->query("SELECT * FROM utilisateur ORDER BY id DESC");
    $utilisateurs = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Impossible de charger les utilisateurs.";
}
 
include 'menu.php';
 
function h($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SuperCar — Gestion des utilisateurs</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
 
    :root {
        --bg: #0a0a0a;
        --bg-soft: #111111;
        --bg-card: rgba(17, 17, 17, 0.6);
        --text: #f5f5f5;
        --text-muted: #8a8a8a;
        --accent: #c9a875;
        --line: rgba(255, 255, 255, 0.08);
        --success: #7ec998;
        --error: #d97766;
    }
 
    html, body {
        background: var(--bg);
        color: var(--text);
        font-family: 'Inter', sans-serif;
        font-weight: 300;
        letter-spacing: 0.3px;
        min-height: 100vh;
    }
 
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background:
            radial-gradient(ellipse at top right, rgba(201, 168, 117, 0.04), transparent 60%),
            radial-gradient(ellipse at bottom left, rgba(255, 255, 255, 0.02), transparent 50%);
        pointer-events: none;
        z-index: 0;
    }
 
    .main-content {
        margin-left: 240px;
        padding: 56px 60px 80px;
        position: relative;
        z-index: 1;
    }
 
    .page-header {
        margin-bottom: 56px;
        animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }
 
    .eyebrow {
        font-size: 11px;
        letter-spacing: 6px;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
 
    .eyebrow::before {
        content: '';
        width: 30px;
        height: 1px;
        background: var(--accent);
        opacity: 0.6;
    }
 
    h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 48px;
        font-weight: 400;
        line-height: 1.1;
        letter-spacing: 1px;
        margin-bottom: 12px;
    }
 
    h1 .accent {
        font-style: italic;
        color: var(--accent);
        font-weight: 500;
    }
 
    .page-subtitle {
        font-size: 14px;
        color: var(--text-muted);
        max-width: 600px;
        line-height: 1.6;
    }
 
    /* Toast */
    .toast {
        position: fixed;
        top: 100px;
        right: 32px;
        z-index: 100;
        padding: 18px 26px;
        background: rgba(17, 17, 17, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--line);
        color: var(--text);
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 14px;
        animation: toastIn 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) both,
                   toastOut 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) 3.5s forwards;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }
 
    .toast.success { border-left: 2px solid var(--success); }
    .toast.error   { border-left: 2px solid var(--error); }
 
    .toast-icon {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        color: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
    }
 
    .toast.success .toast-icon { background: var(--success); }
    .toast.error   .toast-icon { background: var(--error); }
 
    .toast-text strong { display: block; font-weight: 500; margin-bottom: 2px; }
    .toast-text small { color: var(--text-muted); font-size: 11px; }
 
    /* User card */
    .user-card {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--line);
        padding: 32px 36px;
        margin-bottom: 20px;
        animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }
 
    .user-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 18px;
        margin-bottom: 24px;
        border-bottom: 1px solid var(--line);
    }
 
    .user-id {
        font-family: 'Cormorant Garamond', serif;
        font-size: 18px;
        color: var(--text);
    }
 
    .user-id .num {
        font-style: italic;
        color: var(--accent);
        margin-left: 6px;
    }
 
    .field-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px 32px;
        margin-bottom: 24px;
    }
 
    .field-label {
        font-size: 10px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 10px;
        font-weight: 400;
    }
 
    .field input {
        width: 100%;
        padding: 12px 0;
        background: transparent;
        border: none;
        border-bottom: 1px solid var(--line);
        color: var(--text);
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 300;
        outline: none;
        transition: border-color 0.4s ease;
    }
 
    .field input:focus {
        border-bottom-color: var(--accent);
    }
 
    .actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }
 
    .btn {
        padding: 12px 28px;
        font-family: 'Inter', sans-serif;
        font-size: 10px;
        font-weight: 400;
        letter-spacing: 2px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s ease;
        background: transparent;
        color: var(--text);
        border: 1px solid var(--line);
    }
 
    .btn-save:hover {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--bg);
    }
 
    .btn-delete {
        color: var(--text-muted);
    }
 
    .btn-delete:hover {
        border-color: var(--error);
        color: var(--error);
    }
 
    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: var(--bg-card);
        border: 1px solid var(--line);
    }
 
    .empty-state h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        font-weight: 400;
        font-style: italic;
        color: var(--accent);
        margin-bottom: 8px;
    }
 
    .empty-state p {
        font-size: 12px;
        color: var(--text-muted);
    }
 
    .users-count {
        font-size: 11px;
        color: var(--text-muted);
        letter-spacing: 0.5px;
        margin-bottom: 24px;
    }
 
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
 
    @keyframes toastIn {
        from { opacity: 0; transform: translateX(40px); }
        to   { opacity: 1; transform: translateX(0); }
    }
 
    @keyframes toastOut {
        from { opacity: 1; transform: translateX(0); }
        to   { opacity: 0; transform: translateX(40px); visibility: hidden; }
    }
 
    @media (max-width: 1024px) {
        .main-content { padding: 40px 32px 60px; }
        .field-grid { grid-template-columns: 1fr; }
    }
 
    @media (max-width: 768px) {
        .main-content { margin-left: 0; padding: 32px 22px 60px; }
        h1 { font-size: 36px; }
        .user-card { padding: 24px; }
        .user-header { flex-direction: column; align-items: flex-start; gap: 12px; }
        .actions { flex-direction: column; }
        .btn { width: 100%; }
        .toast { top: 90px; right: 16px; left: 16px; }
    }
</style>
</head>
<body>
 
<?php if ($success): ?>
    <div class="toast success">
        <div class="toast-icon">✓</div>
        <div class="toast-text">
            <strong><?= h($success_msg) ?></strong>
            <small>Opération effectuée avec succès</small>
        </div>
    </div>
<?php elseif ($error): ?>
    <div class="toast error">
        <div class="toast-icon">!</div>
        <div class="toast-text">
            <strong>Erreur</strong>
            <small><?= h($error) ?></small>
        </div>
    </div>
<?php endif; ?>
 
<div class="main-content">
 
    <header class="page-header">
        <div class="eyebrow">Comptes · Gestion</div>
        <h1>Utilisateurs <span class="accent">inscrits</span></h1>
        <p class="page-subtitle">Consultez, modifiez ou supprimez les comptes des utilisateurs inscrits sur le site SuperCar.</p>
    </header>
 
    <?php if (empty($utilisateurs)): ?>
        <div class="empty-state">
            <h3>Aucun utilisateur inscrit</h3>
            <p>Les comptes créés depuis le formulaire d'inscription apparaîtront ici.</p>
        </div>
    <?php else: ?>
        <div class="users-count"><?= count($utilisateurs) ?> compte<?= count($utilisateurs) > 1 ? 's' : '' ?> enregistré<?= count($utilisateurs) > 1 ? 's' : '' ?></div>
 
        <?php foreach ($utilisateurs as $i => $user): ?>
            <div class="user-card">
                <div class="user-header">
                    <div class="user-id">
                        Compte <span class="num">— ID #<?= (int) $user['id'] ?></span>
                    </div>
                </div>
 
                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
                    <input type="hidden" name="modifier_id" value="<?= (int) $user['id'] ?>">
 
                    <div class="field-grid">
                        <div>
                            <div class="field-label">Nom</div>
                            <div class="field"><input type="text" name="nom" value="<?= h($user['nom']) ?>"></div>
                        </div>
                        <div>
                            <div class="field-label">Prénom</div>
                            <div class="field"><input type="text" name="prenom" value="<?= h($user['prenom']) ?>"></div>
                        </div>
                        <div>
                            <div class="field-label">Adresse email</div>
                            <div class="field"><input type="email" name="email" value="<?= h($user['email']) ?>"></div>
                        </div>
                        <div>
                            <div class="field-label">Nom d'utilisateur</div>
                            <div class="field"><input type="text" name="nom_utilisateur" value="<?= h($user['nom_utilisateur']) ?>"></div>
                        </div>
                        <div>
                            <div class="field-label">Mot de passe</div>
                            <div class="field"><input type="text" name="mot_de_passe" value="<?= h($user['mot_de_passe']) ?>"></div>
                        </div>
                    </div>
 
                    <div class="actions">
                        <button type="submit" class="btn btn-save">Enregistrer</button>
                    </div>
                </form>
 
                <form method="POST" action="" style="margin-top: 12px;">
                    <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
                    <input type="hidden" name="supprimer_id" value="<?= (int) $user['id'] ?>">
                    <div class="actions">
                        <button type="submit" class="btn btn-delete"
                                onclick="return confirm('Voulez-vous vraiment supprimer ce compte ?')">
                            Supprimer ce compte
                        </button>
                    </div>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
 
</div>
 
</body>
</html>