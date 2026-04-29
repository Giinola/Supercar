<?php

 
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
$tables_autorisees = ['voitures', 'contact_contenu', 'essai', 'services', 'accueil'];
if (!in_array($page_table, $tables_autorisees, true)) {
    die("Table non autorisée.");
}
 
include 'menu.php';
 
$success = false;
$error = '';
$contenu = [];
 
// Construire la liste blanche des champs à partir des sections
$champs_autorises = [];
foreach ($page_sections as $section) {
    foreach ($section['fields'] as $field) {
        $champs_autorises[] = $field['name'];
    }
}
 
// =====================================================
//  Traitement du formulaire
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erreur de sécurité. Veuillez recharger la page.";
    } else {
        try {
            // Si la page utilise un trigger d'audit, on définit
            // la variable de session MySQL @admin_user avant les UPDATE
            if (!empty($page_set_admin_user)) {
                $stmt_user = $pdo->prepare("SET @admin_user = :admin");
                $stmt_user->execute([':admin' => $_SESSION['admin']]);
            }
 
            $stmt = $pdo->prepare("UPDATE `$page_table` SET valeur = :valeur WHERE nom_champ = :nom_champ");
 
            foreach ($_POST as $champ => $valeur) {
                if (!in_array($champ, $champs_autorises, true)) continue;
                if (!is_string($valeur)) continue;
 
                $valeur = trim($valeur);
                $stmt->execute([
                    ':valeur'    => $valeur,
                    ':nom_champ' => $champ,
                ]);
            }
            $success = true;
        } catch (PDOException $e) {
            $error = "Erreur lors de l'enregistrement.";
        }
    }
}

try {
    $resultats = $pdo->query("SELECT nom_champ, valeur FROM `$page_table`");
    foreach ($resultats as $ligne) {
        $contenu[$ligne['nom_champ']] = $ligne['valeur'];
    }
} catch (PDOException $e) {
    $error = "Impossible de charger les données.";
}
 
// Helpers anti-XSS
function v($contenu, $key) {
    return htmlspecialchars($contenu[$key] ?? '', ENT_QUOTES, 'UTF-8');
}
function h($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SuperCar — <?= h($page_titre) ?></title>
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
 
    /* Form */
    form { animation: fadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) 0.2s both; }
 
    .section {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--line);
        padding: 44px 48px;
        margin-bottom: 32px;
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
        font-size: 28px;
        font-weight: 500;
        color: var(--text);
        letter-spacing: 0.5px;
    }
 
    .section-desc {
        font-size: 12px;
        color: var(--text-muted);
        margin-left: auto;
        letter-spacing: 0.5px;
    }
 
    .field { margin-bottom: 32px; }
    .field:last-child { margin-bottom: 0; }
 
    .field-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 10px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 12px;
        font-weight: 400;
    }
 
    .field-counter {
        color: #555;
        font-size: 10px;
        font-variant-numeric: tabular-nums;
    }
 
    .field input[type="text"],
    .field textarea {
        width: 100%;
        padding: 14px 0;
        background: transparent;
        border: none;
        border-bottom: 1px solid var(--line);
        color: var(--text);
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        font-weight: 300;
        outline: none;
        transition: border-color 0.4s ease;
        resize: vertical;
    }
 
    .field textarea {
        min-height: 90px;
        line-height: 1.6;
    }
 
    .field input:focus, .field textarea:focus {
        border-bottom-color: var(--accent);
    }
 
    .field input::placeholder, .field textarea::placeholder {
        color: #444;
    }
 
    .image-preview {
        margin-top: 18px;
        padding: 14px;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--line);
        display: inline-flex;
        align-items: center;
        gap: 16px;
        max-width: 100%;
    }
 
    .image-preview img {
        width: 90px;
        height: 60px;
        object-fit: cover;
        border: 1px solid var(--line);
        flex-shrink: 0;
    }
 
    .image-preview-info {
        font-size: 11px;
        color: var(--text-muted);
        word-break: break-all;
    }
 
    .image-preview-info strong {
        display: block;
        color: var(--text);
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 4px;
        font-weight: 400;
    }
 
    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 24px;
        margin-top: 16px;
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
        .section { padding: 36px 32px; }
    }
 
    @media (max-width: 768px) {
        .main-content { margin-left: 0; padding: 32px 22px 60px; }
        h1 { font-size: 36px; }
        .section { padding: 28px 22px; }
        .section-header { flex-wrap: wrap; gap: 8px; }
        .section-desc { margin-left: 0; width: 100%; }
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
            <strong>Modifications enregistrées</strong>
            <small>La page a été mise à jour avec succès</small>
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
        <div class="eyebrow"><?= h($page_eyebrow) ?></div>
        <h1>Page <span class="accent"><?= h($page_titre) ?></span></h1>
        <p class="page-subtitle"><?= h($page_subtitle) ?></p>
    </header>

    <?php if (!empty($page_header_extra)) echo $page_header_extra; ?>
 
    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
 
        <?php $section_index = 0; ?>
        <?php foreach ($page_sections as $section): $section_index++; ?>
            <section class="section">
                <div class="section-header">
                    <span class="section-number">— <?= str_pad($section_index, 2, '0', STR_PAD_LEFT) ?></span>
                    <h2 class="section-title"><?= h($section['title']) ?></h2>
                    <?php if (!empty($section['desc'])): ?>
                        <span class="section-desc"><?= h($section['desc']) ?></span>
                    <?php endif; ?>
                </div>
 
                <?php foreach ($section['fields'] as $field): ?>
                    <div class="field">
                        <div class="field-label">
                            <span><?= h($field['label']) ?></span>
                            <span class="field-counter" data-for="<?= h($field['name']) ?>">0</span>
                        </div>
                        <?php if (($field['type'] ?? 'text') === 'textarea'): ?>
                            <textarea name="<?= h($field['name']) ?>" placeholder="<?= h($field['placeholder'] ?? '') ?>"><?= v($contenu, $field['name']) ?></textarea>
                        <?php else: ?>
                            <input type="text" name="<?= h($field['name']) ?>" value="<?= v($contenu, $field['name']) ?>" placeholder="<?= h($field['placeholder'] ?? '') ?>">
                        <?php endif; ?>
 
                        <?php if (!empty($field['is_image']) && !empty($contenu[$field['name']])): ?>
                            <div class="image-preview">
                                <img src="<?= v($contenu, $field['name']) ?>" alt="">
                                <div class="image-preview-info">
                                    <strong>Aperçu actuel</strong>
                                    <?= v($contenu, $field['name']) ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php endforeach; ?>
 
        <div class="form-actions">
            <span class="form-hint">Les modifications sont appliquées immédiatement</span>
            <button type="submit" class="btn">
                Enregistrer les modifications
                <span class="arrow">→</span>
            </button>
        </div>
    </form>
</div>
 
<script>
    document.querySelectorAll('.field-counter').forEach(counter => {
        const input = document.querySelector(`[name="${counter.dataset.for}"]`);
        if (!input) return;
        const update = () => counter.textContent = input.value.length + ' caractères';
        update();
        input.addEventListener('input', update);
    });
</script>
 
</body>
</html>