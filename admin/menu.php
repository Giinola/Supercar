  <!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <body>
  <div class="sidebar">
    <div>
      <h4>Visualisation</h4>
      <a href="index.php" class="active">Tableau de bord</a>
      <a href="Demande_essai.php">Demandes d'essai</a>
      <a href="Utilisateurs.php">Utilisateurs</a>
      <a href="Contacts.php">Contact</a>
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
  
  <div class="topbar">
    <div class="logo">SUPERCAR</div>
  </div>
  </body>
  <style>
:root{
  --sidebar-w: 260px;
  --bg: #0f1115;
  --elev: #171a21;
  --panel: #1b1f2a;
  --text: #e7e9ee;
  --muted: #a7afc0;
  --accent: #fcbf49;       /* or #ffd166 */
  --accent-600: #e0a935;
  --ring: 0 0 0 3px rgba(252,191,73,.25);
  --radius: 14px;
  --shadow: 0 10px 30px rgba(0,0,0,.35);
  --bevel: inset 0 1px 0 rgba(255,255,255,.04), inset 0 -1px 0 rgba(0,0,0,.35);
}

@media (prefers-color-scheme: light){
  :root{
    --bg:#f6f7fb; --elev:#ffffff; --panel:#ffffff; --text:#0f1115; --muted:#596174;
    --shadow:0 10px 28px rgba(16,24,40,.08);
    --ring:0 0 0 3px rgba(252,191,73,.35);
  }
}

/* ====== Reset de base ====== */
body{
  font-family:'Poppins',system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,'Helvetica Neue',Arial,sans-serif;
  background: radial-gradient(1200px 600px at 10% -10%, rgba(252,191,73,.08), transparent 60%) , var(--bg);
  color:var(--text);
  margin:0;
  -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale;
}

/* ====== SIDEBAR ====== */
.sidebar{
  height:100vh;
  width:var(--sidebar-w);
  position:fixed; inset:0 auto 0 0;
  background: linear-gradient(180deg, var(--elev), var(--panel));
  border-right:1px solid rgba(255,255,255,.06);
  box-shadow: 2px 0 24px rgba(0,0,0,.25);
  display:flex; flex-direction:column;
  padding:18px 10px;
  backdrop-filter: saturate(120%) blur(6px);
}

.sidebar h4{
  color:var(--accent);
  text-align:center;
  margin:6px 0 12px;
  font-size:12px; letter-spacing:.18em; text-transform:uppercase;
  opacity:.9;
}

.sidebar .secondary-menu{ 
  margin-top:18px;
  border-top:1px dashed rgba(255,255,255,.08);
  padding-top:14px;
}

.sidebar a{
  position:relative;
  display:flex; align-items:center;
  gap:10px;
  padding:12px 14px;
  margin:6px 8px;
  text-decoration:none;
  color:var(--text);
  font-size:15px; font-weight:600;
  border-radius:12px;
  background: transparent;
  box-shadow: var(--bevel);
  transition: transform .18s ease, background-color .18s ease, color .18s ease, box-shadow .18s ease;
  outline: none;
}

.sidebar a:hover{
  background: linear-gradient(180deg, rgba(252,191,73,.12), rgba(252,191,73,.08));
  color:#111;
  text-shadow: 0 1px 0 rgba(255,255,255,.3);
}

.sidebar a.active{
  background: linear-gradient(180deg, rgba(252,191,73,.18), rgba(252,191,73,.14));
  color:#201a00;
  box-shadow: 0 6px 18px rgba(252,191,73,.18), var(--bevel);
}

.sidebar a.active::before{
  content:"";
  position:absolute; left:-6px; top:10px; bottom:10px;
  width:3px; border-radius:3px;
  background: var(--accent);
  box-shadow: 0 0 0 4px rgba(252,191,73,.15);
}

.sidebar a:active{ transform: translateY(1px); }

.sidebar a:focus-visible{
  box-shadow: var(--bevel), var(--ring);
}

/* Scrollbar discrète (WebKit) */
.sidebar::-webkit-scrollbar{ width:10px }
.sidebar::-webkit-scrollbar-thumb{
  background: linear-gradient(180deg, rgba(255,255,255,.12), rgba(0,0,0,.2));
  border-radius:10px;
}

/* ====== TOPBAR ====== */
.topbar{
  position:sticky; top:0; z-index:5;
  background: linear-gradient(180deg, rgba(23,26,33,.85), rgba(23,26,33,.78));
  -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px);
  padding:16px 28px;
  display:flex; align-items:center; justify-content:flex-start;
  border-bottom:1px solid rgba(255,255,255,.06);
  box-shadow: 0 4px 14px rgba(0,0,0,.25);
  margin-left: var(--sidebar-w);
  width: calc(100% - var(--sidebar-w));
  box-sizing:border-box;
}

.logo{
  font-size:24px; font-weight:800; letter-spacing:.12em; text-transform:uppercase;
  color:var(--accent);
  filter: drop-shadow(0 1px 0 rgba(255,255,255,.15));
}

/* ====== Layout contenu ====== */
.main, .main-content, .header-section{
  margin-left: var(--sidebar-w);
  width: calc(100% - var(--sidebar-w));
  box-sizing:border-box;
}

.header-section{
  text-align:center; padding:56px 20px 36px;
}
.header-section h1{ font-size:34px; color:var(--accent); margin:0 0 8px }
.header-section p{ color:var(--muted); margin:0 }

/* ====== Cartes / panneaux ====== */
.info-panels{
  display:grid; gap:26px;
  grid-template-columns: repeat(auto-fit,minmax(260px,1fr));
  padding: 0 20px 40px;
}
.panel{
  background: linear-gradient(180deg, var(--panel), #161a22);
  border-radius: var(--radius);
  border:1px solid rgba(255,255,255,.06);
  box-shadow: var(--shadow);
  padding:24px;
  transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
}
.panel:hover{
  transform: translateY(-2px);
  box-shadow: 0 14px 32px rgba(0,0,0,.4);
  border-color: rgba(252,191,73,.35);
}
.panel h3{ color:var(--accent); font-size:18px; margin:0 0 10px }
.panel p{ font-size:34px; font-weight:800; margin:0; color:var(--text) }

/* ====== Boutons raccourcis ====== */
.shortcuts{ text-align:center; margin-top:8px }
.shortcuts a{
  display:inline-block; margin:10px; padding:12px 22px;
  background: linear-gradient(180deg, var(--accent), var(--accent-600));
  color:#1c1c1c; text-decoration:none; font-weight:700;
  border-radius: 999px; transition: transform .15s ease, filter .15s ease;
  box-shadow: 0 8px 18px rgba(252,191,73,.28);
}
.shortcuts a:hover{ filter:saturate(105%) brightness(1.02) }
.shortcuts a:active{ transform: translateY(1px) }

/* ====== Responsive ====== */
@media (max-width: 992px){
  :root{ --sidebar-w: 220px; }
}
@media (max-width: 768px){
  :root{ --sidebar-w: 0px; }
  .sidebar{
    position:relative; width:100%; height:auto; inset:auto;
    border-right:none; border-bottom:1px solid rgba(255,255,255,.08);
    box-shadow: 0 6px 18px rgba(0,0,0,.2);
  }
  .topbar, .main, .main-content, .header-section{
    margin-left:0; width:100%;
  }
  .topbar{ position:sticky; top:0 }
}

/* ====== Préférence accessibilité ====== */
@media (prefers-reduced-motion: reduce){
  *{ transition:none !important }
}
/* ==== PATCH : hover jaune + pas de petits ronds ==== */

/* si tu utilises des <ul><li> pour le menu, on supprime les puces */
.sidebar ul, .sidebar li { list-style: none; margin: 0; padding: 0; }
/* supprime aussi d'éventuels marqueurs */
.sidebar ::marker { content: ""; }

/* liens du menu */
.sidebar a{
  position: relative;
  display: flex; align-items: center; gap: .6rem;
  padding: 12px 14px; margin: 6px 8px;
  border-radius: 12px; background: transparent;
  color: #eaeaea; font-size: 15px; font-weight: 600; text-decoration: none;
  transition: background-color .18s ease, color .18s ease,
              transform .18s ease, box-shadow .18s ease;
}

/* survol : fond JAUNE + texte foncé */
.sidebar a:hover{
  background: #fcbf49;
  color: #1b1f2a;
  box-shadow: 0 6px 16px rgba(252,191,73,.25);
  transform: translateX(2px);
}

.sidebar a.active{
  background: linear-gradient(180deg, #fcbf49, #e0a935);
  color: #1b1f2a;
  box-shadow: 0 8px 20px rgba(252,191,73,.30);
}


.sidebar a.active::before{
  content: "";
  position: absolute; left: -6px; top: 10px; bottom: 10px;
  width: 3px; border-radius: 3px;
  background: #fcbf49;
  box-shadow: 0 0 0 4px rgba(252,191,73,.15);
}

.sidebar a:focus-visible{
  outline: none;
  box-shadow: 0 0 0 3px rgba(252,191,73,.35);
}


.topbar{
  border-bottom: 1px solid rgba(252,191,73,.18);
  background: linear-gradient(180deg, rgba(23,26,33,.9), rgba(23,26,33,.82));
}


</style>
  