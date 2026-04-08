<?php
// =====================================================
//  voiture_admin.php — Helper réutilisable
//  Inclus par ferrari.php, mclaren.php, Merco.php, range_rove.php
//  Variables attendues avant inclusion :
//    $table_name  : nom de la table SQL (ex: 'ferrari')
//    $marque_nom  : nom affiché (ex: 'Ferrari')
//    $marque_desc : sous-titre (ex: 'Le mythe italien de la performance')
// =====================================================
 
session_start();
 
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
 
require_once 'db.php';
 
// Token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}
 
// Liste blanche des tables autorisées
$tables_autorisees = ['ferrari', 'mclaren', 'mercedes', 'range_rover'];
if (!in_array($table_name, $tables_autorisees, true)) {
    die("Table non autorisée.");
}
 
include 'menu.php';
 
$success = false;
$error = '';
$success_msg = '';
 
// =====================================================
//  Suppression d'une voiture
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer'])) {
 
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erreur de sécurité.";
    } else {
        try {
            $id = (int) $_POST['supprimer'];
            $stmt = $pdo->prepare("DELETE FROM `$table_name` WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $success = true;
            $success_msg = "Voiture supprimée avec succès";
        } catch (PDOException $e) {
            $error = "Erreur lors de la suppression.";
        }
    }
}
 
// =====================================================
//  Ajout d'une voiture
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_add'])) {
 
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erreur de sécurité.";
    } else {
        $nom = trim($_POST['new_nom_complet'] ?? '');
 
        if ($nom === '') {
            $error = "Le nom du modèle est obligatoire.";
        } else {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO `$table_name`
                        (nom_complet, classe, carrosserie, description_courte, chemin_image, puissance_ch, prix_estime)
                    VALUES
                        (:nom, :classe, :carrosserie, :desc, :image, :puissance, :prix)
                ");
                $stmt->execute([
                    ':nom'        => $nom,
                    ':classe'     => trim($_POST['new_classe'] ?? ''),
                    ':carrosserie'=> trim($_POST['new_carrosserie'] ?? ''),
                    ':desc'       => trim($_POST['new_description_courte'] ?? ''),
                    ':image'      => trim($_POST['new_chemin_image'] ?? ''),
                    ':puissance'  => trim($_POST['new_puissance_ch'] ?? ''),
                    ':prix'       => trim($_POST['new_prix_estime'] ?? ''),
                ]);
                $success = true;
                $success_msg = "Voiture ajoutée avec succès";
            } catch (PDOException $e) {
                $error = "Erreur lors de l'ajout.";
            }
        }
    }
}
 
// =====================================================
//  Modification des voitures existantes
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_update'])) {
 
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erreur de sécurité.";
    } else {
        try {
            $stmt = $pdo->prepare("
                UPDATE `$table_name` SET
                    nom_complet = :nom,
                    classe = :classe,
                    carrosserie = :carrosserie,
                    description_courte = :desc,
                    chemin_image = :image,
                    puissance_ch = :puissance,
                    prix_estime = :prix
                WHERE id = :id
            ");
 
            if (isset($_POST['nom_complet']) && is_array($_POST['nom_complet'])) {
                foreach ($_POST['nom_complet'] as $id => $nom) {
                    $id = (int) $id;
                    $stmt->execute([
                        ':id'        => $id,
                        ':nom'       => trim($nom),
                        ':classe'    => trim($_POST['classe'][$id] ?? ''),
                        ':carrosserie'=> trim($_POST['carrosserie'][$id] ?? ''),
                        ':desc'      => trim($_POST['description_courte'][$id] ?? ''),
                        ':image'     => trim($_POST['chemin_image'][$id] ?? ''),
                        ':puissance' => trim($_POST['puissance_ch'][$id] ?? ''),
                        ':prix'      => trim($_POST['prix_estime'][$id] ?? ''),
                    ]);
                }
                $success = true;
                $success_msg = "Modifications enregistrées avec succès";
            }
        } catch (PDOException $e) {
            $error = "Erreur lors de la mise à jour.";
        }
    }
}
 
// =====================================================
//  Récupération des voitures
// =====================================================
$voitures = [];
try {
    $stmt = $pdo->query("SELECT * FROM `$table_name` ORDER BY id ASC");
    $voitures = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Impossible de charger les voitures.";
}
 
// Helper anti-XSS
function h($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SuperCar — Gestion <?= h($marque_nom) ?></title>
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
        flex-shrink: 0;
    }
 
    .toast.success .toast-icon { background: var(--success); }
    .toast.error   .toast-icon { background: var(--error); }
 
    .toast-text strong {
        display: block;
        font-weight: 500;
        margin-bottom: 2px;
    }
 
    .toast-text small {
        color: var(--text-muted);
        font-size: 11px;
    }
 
    /* Voiture card */
    .voiture-card {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--line);
        padding: 36px 40px;
        margin-bottom: 24px;
        animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }
 
    .voiture-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 20px;
        margin-bottom: 28px;
        border-bottom: 1px solid var(--line);
    }
 
    .voiture-id {
        font-family: 'Cormorant Garamond', serif;
        font-size: 18px;
        color: var(--text);
    }
 
    .voiture-id .num {
        font-style: italic;
        color: var(--accent);
        margin-left: 6px;
    }
 
    .btn-delete {
        padding: 10px 20px;
        background: transparent;
        color: var(--text-muted);
        border: 1px solid var(--line);
        font-family: 'Inter', sans-serif;
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s ease;
    }
 
    .btn-delete:hover {
        border-color: var(--error);
        color: var(--error);
    }
 
    .field-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 28px 36px;
    }
 
    .field { margin-bottom: 0; }
    .field.full { grid-column: 1 / -1; }
 
    .field-label {
        font-size: 10px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 12px;
        font-weight: 400;
    }
 
    .field input[type="text"],
    .field textarea {
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
        resize: vertical;
    }
 
    .field textarea {
        min-height: 70px;
        line-height: 1.6;
    }
 
    .field input:focus, .field textarea:focus {
        border-bottom-color: var(--accent);
    }
 
    .field input::placeholder, .field textarea::placeholder {
        color: #444;
    }
 
    .image-preview {
        margin-top: 12px;
        padding: 10px;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--line);
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }
 
    .image-preview img {
        width: 70px;
        height: 50px;
        object-fit: cover;
        border: 1px solid var(--line);
    }
 
    .image-preview-info {
        font-size: 10px;
        color: var(--text-muted);
        word-break: break-all;
        max-width: 200px;
    }
 
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: var(--bg-card);
        border: 1px solid var(--line);
        margin-bottom: 24px;
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
        letter-spacing: 0.5px;
    }
 
    /* Add new car section */
    .add-section {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--line);
        padding: 44px 48px;
        margin-bottom: 32px;
        animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) 0.3s both;
    }
 
    .section-header {
        display: flex;
        align-items: baseline;
        gap: 18px;
        margin-bottom: 36px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--line);
    }
 
    .section-number {
        font-family: 'Cormorant Garamond', serif;
        font-size: 14px;
        font-style: italic;
        color: var(--accent);
        letter-spacing: 2px;
    }
 
    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 26px;
        font-weight: 500;
        color: var(--text);
    }
 
    .section-desc {
        font-size: 11px;
        color: var(--text-muted);
        margin-left: auto;
        letter-spacing: 0.5px;
    }
 
    /* Form actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 24px;
        margin-top: 24px;
    }
 
    .form-hint {
        font-size: 11px;
        color: var(--text-muted);
    }
 
    .btn {
        padding: 18px 48px;
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 400;
        letter-spacing: 3px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
        background: var(--text);
        color: var(--bg);
        border: 1px solid var(--text);
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }
 
    .btn:hover {
        background: var(--accent);
        border-color: var(--accent);
        transform: translateY(-2px);
    }
 
    .btn .arrow { transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1); }
    .btn:hover .arrow { transform: translateX(5px); }
 
    .btn-secondary {
        background: transparent;
        color: var(--text);
        border-color: var(--line);
    }
 
    .btn-secondary:hover {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--bg);
    }
 
    .marque-divider {
        margin: 56px 0 32px;
        text-align: center;
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        color: var(--text-muted);
        font-size: 13px;
        letter-spacing: 3px;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 20px;
    }
 
    .marque-divider::before, .marque-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--line);
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
        .voiture-card, .add-section { padding: 32px; }
        .field-grid { grid-template-columns: 1fr; gap: 24px; }
    }
 
    @media (max-width: 768px) {
        .main-content { margin-left: 0; padding: 32px 22px 60px; }
        h1 { font-size: 36px; }
        .voiture-card, .add-section { padding: 24px 22px; }
        .voiture-header { flex-direction: column; align-items: flex-start; gap: 14px; }
        .form-actions { flex-direction: column-reverse; align-items: stretch; gap: 16px; }
        .btn { justify-content: center; }
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
        <div class="eyebrow">Catalogue · <?= h($marque_nom) ?></div>
        <h1>Gestion <span class="accent"><?= h($marque_nom) ?></span></h1>
        <p class="page-subtitle"><?= h($marque_desc) ?></p>
    </header>
 
    <!-- ===== Modification des voitures existantes ===== -->
    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
 
        <?php if (empty($voitures)): ?>
            <div class="empty-state">
                <h3>Aucun véhicule enregistré</h3>
                <p>Utilisez le formulaire ci-dessous pour ajouter votre premier modèle <?= h($marque_nom) ?>.</p>
            </div>
        <?php else: ?>
            <?php foreach ($voitures as $i => $voiture): $id = (int) $voiture['id']; ?>
                <div class="voiture-card">
                    <div class="voiture-header">
                        <div class="voiture-id">
                            Modèle <span class="num">— N°<?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                        </div>
                        <button type="submit" name="supprimer" value="<?= $id ?>" class="btn-delete"
                                onclick="return confirm('Voulez-vous vraiment supprimer cette voiture ?')">
                            Supprimer
                        </button>
                    </div>
 
                    <div class="field-grid">
                        <div class="field full">
                            <div class="field-label">Nom complet</div>
                            <input type="text" name="nom_complet[<?= $id ?>]" value="<?= h($voiture['nom_complet']) ?>">
                        </div>
 
                        <div class="field">
                            <div class="field-label">Classe</div>
                            <input type="text" name="classe[<?= $id ?>]" value="<?= h($voiture['classe']) ?>">
                        </div>
 
                        <div class="field">
                            <div class="field-label">Carrosserie</div>
                            <input type="text" name="carrosserie[<?= $id ?>]" value="<?= h($voiture['carrosserie']) ?>">
                        </div>
 
                        <div class="field">
                            <div class="field-label">Puissance (ch)</div>
                            <input type="text" name="puissance_ch[<?= $id ?>]" value="<?= h($voiture['puissance_ch']) ?>">
                        </div>
 
                        <div class="field">
                            <div class="field-label">Prix estimé</div>
                            <input type="text" name="prix_estime[<?= $id ?>]" value="<?= h($voiture['prix_estime']) ?>">
                        </div>
 
                        <div class="field full">
                            <div class="field-label">Description courte</div>
                            <textarea name="description_courte[<?= $id ?>]"><?= h($voiture['description_courte']) ?></textarea>
                        </div>
 
                        <div class="field full">
                            <div class="field-label">Chemin de l'image</div>
                            <input type="text" name="chemin_image[<?= $id ?>]" value="<?= h($voiture['chemin_image']) ?>">
                            <?php if (!empty($voiture['chemin_image'])): ?>
                                <div class="image-preview">
                                    <img src="<?= h($voiture['chemin_image']) ?>" alt="">
                                    <div class="image-preview-info"><?= h($voiture['chemin_image']) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
 
            <div class="form-actions">
                <span class="form-hint"><?= count($voitures) ?> modèle<?= count($voitures) > 1 ? 's' : '' ?> dans le catalogue</span>
                <button type="submit" name="action_update" value="1" class="btn">
                    Enregistrer les modifications
                    <span class="arrow">→</span>
                </button>
            </div>
        <?php endif; ?>
    </form>
 
    <div class="marque-divider">Ajouter un nouveau modèle</div>
 
    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
 
        <div class="add-section">
            <div class="section-header">
                <span class="section-number">— Nouveau</span>
                <h2 class="section-title">Ajouter une <?= h($marque_nom) ?></h2>
                <span class="section-desc">Tous les champs sauf le nom sont optionnels</span>
            </div>
 
            <div class="field-grid">
                <div class="field full">
                    <div class="field-label">Nom complet *</div>
                    <input type="text" name="new_nom_complet" placeholder="<?= h($marque_nom) ?> 488 GTB" required>
                </div>
 
                <div class="field">
                    <div class="field-label">Classe</div>
                    <input type="text" name="new_classe" placeholder="Sport / GT / SUV...">
                </div>
 
                <div class="field">
                    <div class="field-label">Carrosserie</div>
                    <input type="text" name="new_carrosserie" placeholder="Coupé / Cabriolet...">
                </div>
 
                <div class="field">
                    <div class="field-label">Puissance (ch)</div>
                    <input type="text" name="new_puissance_ch" placeholder="670">
                </div>
 
                <div class="field">
                    <div class="field-label">Prix estimé</div>
                    <input type="text" name="new_prix_estime" placeholder="250000">
                </div>
 
                <div class="field full">
                    <div class="field-label">Description courte</div>
                    <textarea name="new_description_courte" placeholder="Une brève présentation du modèle..."></textarea>
                </div>
 
                <div class="field full">
                    <div class="field-label">Chemin de l'image</div>
                    <input type="text" name="new_chemin_image" placeholder="IMAGES/<?= h($table_name) ?>/modele.jpg">
                </div>
            </div>
 
            <div class="form-actions">
                <span class="form-hint">L'ajout sera immédiat</span>
                <button type="submit" name="action_add" value="1" class="btn btn-secondary">
                    Ajouter le modèle
                    <span class="arrow">→</span>
                </button>
            </div>
        </div>
    </form>
</div>
 
</body>
</html>