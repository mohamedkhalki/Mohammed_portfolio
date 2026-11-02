<?php
require dirname(__DIR__).'/lib/data.php';
function esc($value){return htmlspecialchars((string)$value, ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
$path=parse_url($_SERVER['REQUEST_URI']??'/', PHP_URL_PATH) ?: '/';
$page=(string)($_GET['p']??'');
$isModule=($path==='/module')||$page==='module';
$isAtelier=($path==='/atelier')||$page==='atelier';
$isProjects=($path==='/projets')||$page==='projets';
$moduleKey=strtolower((string)($_GET['m']??'m02'));
$selectedModule=$modules[$moduleKey]??null;
$atelierKey=strtolower((string)($_GET['a']??''));
$selectedAtelier=null;
if($selectedModule){foreach($selectedModule['groups'] as $group){foreach($group['items'] as $item){if($item['id']===$atelierKey){$selectedAtelier=$item; break 2;}}}}
$totalAteliers=array_sum(array_map(static fn($module)=>count(allAteliers($module)), $modules));
$m02Ateliers = isset($modules['m02']) ? allAteliers($modules['m02']) : [];
$isGitAtelierDone = $isAtelier && $selectedAtelier && $moduleKey === 'm02' && $atelierKey === 'git-basics';
$isGitEfmDone = $isAtelier && $selectedAtelier && $moduleKey === 'm02' && $atelierKey === 'git-efm';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#0b1020">
<meta name="description" content="Portfolio de Mohammed Khalki, développeur web en formation à Tanger.">
<title><?= esc($isAtelier && $selectedAtelier ? $selectedAtelier['title'].' — ' : ($isModule && $selectedModule ? $selectedModule['title'].' — ' : '')) ?>Mohammed Khalki · Portfolio</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/style.css?v=v5glass-at3-at5">
<script src="/js/main.js?v=v5glass" defer></script>
</head>
<body>
<div class="site-bg" aria-hidden="true">
  <canvas id="motion-canvas"></canvas>
  <div class="bg-glow bg-glow-a"></div>
  <div class="bg-glow bg-glow-b"></div>
</div>
<header class="header" id="top">
  <div class="container nav-wrap">
    <a class="brand" href="/#accueil" aria-label="Retour à l'accueil">Mohammed<span> Khalki</span></a>
    <button class="menu-toggle" type="button" aria-label="Afficher le menu" aria-controls="nav" aria-expanded="false"><span></span><span></span></button>
    <nav class="nav" id="nav">
      <a href="/#accueil">Accueil</a>
      <a href="/#apropos">À propos</a>
      <a href="/#competences">Compétences</a>
      <a href="/#projets">Projets</a>
      <a href="/#ateliers">Ateliers</a>
      <a href="/#contact">Contact</a>
    </nav>
    <a class="ghost-link" href="<?= esc($profile['github']) ?>" target="_blank" rel="noopener noreferrer">GitHub ↗</a>
  </div>
</header>

<?php if($isAtelier): ?>
<main class="page container">
  <nav class="breadcrumbs" aria-label="Fil d'Ariane"><a href="/#ateliers">Portfolio</a><span>/</span><a href="/module?m=<?= esc($moduleKey) ?>"><?= esc($selectedModule['code'] ?? 'Module') ?></a><span>/</span><span>Atelier</span></nav>
  <?php if(!$selectedAtelier): ?>
    <section class="empty-state panel"><h1>Atelier introuvable</h1><p>Retournez à la liste des ateliers pour choisir un élément existant.</p><a class="btn primary" href="/#ateliers">Voir les ateliers</a></section>
  <?php else: ?>
    <section class="detail-hero reveal show">
      <div>
        <p class="section-kicker"><?= esc($selectedModule['code']) ?> · <?= esc($selectedAtelier['type']) ?></p>
        <h1><?= esc($selectedAtelier['title']) ?></h1>
        <p class="lead"><?= esc($selectedAtelier['summary']) ?></p>
      </div>
      <div class="detail-status panel-soft">
        <span class="status-dot"></span>
        <?php if($isGitAtelierDone): ?>
          <strong>Réalisation personnelle</strong>
          <p>Projet HTML/CSS réalisé avec un dépôt Git local et trois commits documentés.</p>
          <span class="badge badge-muted">Travail présenté</span>
        <?php elseif($isGitEfmDone): ?>
          <strong>Exercice pratique réalisé</strong>
          <p>Mini-projet de gestion des produits pour pratiquer les commandes Git, les branches et la fusion.</p>
          <span class="badge badge-muted">Travail présenté</span>
        <?php else: ?>
          <strong>Zone de travail personnelle</strong>
          <p>Cet atelier est volontairement laissé vide pour que vous ajoutiez votre propre réalisation plus tard.</p>
          <span class="badge badge-muted">À compléter</span>
        <?php endif; ?>
      </div>
    </section>
    <section class="detail-grid">
      <article class="panel reveal">
        <p class="mini-title">Étapes</p>
        <ol class="step-list"><?php foreach($selectedAtelier['steps'] as $i=>$step): ?><li><span><?= $i+1 ?></span><?= esc($step) ?></li><?php endforeach; ?></ol>
      </article>
      <article class="panel reveal">
        <p class="mini-title">Livrables attendus</p>
        <ul class="deliver-list"><?php foreach($selectedAtelier['deliverables'] as $d): ?><li><?= esc($d) ?></li><?php endforeach; ?></ul>
      </article>
    </section>
    <?php if($isGitAtelierDone): ?>
      <section class="panel git-work-panel reveal" id="realisation">
        <div class="git-work-head">
          <div>
            <p class="mini-title">Ma réalisation · Atelier 03</p>
            <h2>Mon premier projet Git</h2>
            <p>J’ai créé une page HTML simple, ajouté sa feuille de style CSS et un README, puis enregistré les étapes du travail dans un dépôt Git local.</p>
          </div>
          <span class="badge badge-muted">3 commits</span>
        </div>
        <div class="git-work-files" aria-label="Fichiers fournis">
          <span>index.html</span><span>style.css</span><span>README.md</span>
        </div>
        <div class="git-commits">
          <p class="mini-title">Historique Git</p>
          <img src="/ateliers/m02/git-basics/git-history.png" alt="Capture réelle de git log --oneline montrant trois commits" width="758" height="167" loading="lazy">
        </div>
        <div class="git-work-actions">
          <a class="btn primary" href="/ateliers/m02/git-basics/demo/index.html" target="_blank" rel="noopener noreferrer">Voir mon mini-site ↗</a>
          <a class="btn outline" href="/ateliers/m02/git-basics/atelier3-git.zip" download="atelier3-git.zip">Télécharger mon travail</a>
        </div>
        <p class="git-work-note">Le téléchargement contient les fichiers du projet et la capture de l’historique Git. Le dépôt Git local lui-même n’est pas inclus dans cette archive.</p>
      </section>
    <?php elseif($isGitEfmDone): ?>
      <section class="panel git-work-panel reveal" id="realisation">
        <div class="git-work-head">
          <div>
            <p class="mini-title">Ma réalisation · Atelier 05</p>
            <h2>Gestion des Produits — Entraînement Git</h2>
            <p>J’ai développé un mini-site HTML, CSS et JavaScript, créé une branche <code>gestion-produits</code>, enregistré les modifications et fusionné la branche dans <code>main</code>. L’historique est disponible ci-dessous.</p>
          </div>
          <span class="badge badge-muted">3 commits</span>
        </div>
        <div class="git-work-files" aria-label="Fichiers du projet">
          <span>produit.html</span><span>style.css</span><span>script.js</span>
        </div>
        <div class="git-commits">
          <p class="mini-title">Historique des branches et des commits</p>
          <img src="/ateliers/m02/git-efm/git-history.png" alt="Capture réelle de git log --oneline --all --graph, avec trois commits" width="925" height="167" loading="lazy">
        </div>
        <div class="git-work-actions">
          <a class="btn primary" href="/ateliers/m02/git-efm/demo/produit.html" target="_blank" rel="noopener noreferrer">Voir mon mini-site ↗</a>
          <a class="btn outline" href="https://github.com/mohamedkhalki/-atelier5-git" target="_blank" rel="noopener noreferrer">Repository GitHub ↗</a>
          <a class="btn outline" href="/ateliers/m02/git-efm/atelier5-git.zip" download="atelier5-git.zip">Télécharger les fichiers</a>
        </div>
        <p class="git-work-note">Exercice pratique d’entraînement aux commandes Git et à la gestion des branches. L’archive contient les fichiers du mini-site et la capture d’historique ; le dépôt Git complet est consultable via GitHub.</p>
      </section>
    <?php else: ?>
      <section class="panel placeholder-panel reveal">
        <div>
          <p class="mini-title">Mon espace</p>
          <h2>Ajoutez ici votre travail</h2>
          <p>Vous pouvez placer plus tard ici votre PDF, votre lien GitHub, votre maquette Figma, votre capture ou tout autre rendu personnel lié à cet atelier.</p>
        </div>
        <div class="placeholder-box">Espace réservé à votre réalisation</div>
      </section>
    <?php endif; ?>
    <div class="detail-actions-row"><a class="btn outline" href="/module?m=<?= esc($moduleKey) ?>">← Retour au module</a><?php if(!empty($selectedAtelier['source'])): ?><a class="btn primary" href="<?= esc($selectedAtelier['source']) ?>" target="_blank" rel="noopener noreferrer">Voir l'énoncé</a><?php endif; ?></div>
  <?php endif; ?>
</main>

<?php elseif($isModule): ?>
<main class="page container">
  <nav class="breadcrumbs" aria-label="Fil d'Ariane"><a href="/#ateliers">Portfolio</a><span>/</span><span><?= esc($selectedModule['code'] ?? 'Module') ?></span></nav>
  <?php if(!$selectedModule): ?>
    <section class="empty-state panel"><h1>Module introuvable</h1><a class="btn primary" href="/#ateliers">Retour</a></section>
  <?php else: ?>
    <section class="detail-hero reveal show">
      <div>
        <p class="section-kicker"><?= esc($selectedModule['code']) ?></p>
        <h1><?= esc($selectedModule['title']) ?></h1>
        <p class="lead"><?= esc($selectedModule['intro']) ?></p>
      </div>
      <div class="detail-status panel-soft">
        <strong><?= count(allAteliers($selectedModule)) ?> atelier<?= count(allAteliers($selectedModule))>1?'s':'' ?></strong>
        <p>Les cartes ci-dessous affichent les ateliers, leurs objectifs et une page dédiée où vous pourrez ajouter votre propre travail.</p>
      </div>
    </section>
    <?php foreach($selectedModule['groups'] as $group): ?>
      <section class="module-group reveal">
        <div class="group-head"><h2><?= esc($group['label']) ?></h2><span><?= count($group['items']) ?> élément<?= count($group['items'])>1?'s':'' ?></span></div>
        <div class="atelier-grid"><?php foreach($group['items'] as $i=>$item): ?>
          <article class="atelier-card">
            <div class="atelier-top"><span class="atelier-number"><?= str_pad((string)($i+1),2,'0',STR_PAD_LEFT) ?></span><span class="badge badge-muted"><?= esc($item['type']) ?></span></div>
            <h3><?= esc($item['title']) ?></h3>
            <p><?= esc($item['summary']) ?></p>
            <div class="atelier-bottom"><span class="empty-label"><?= $moduleKey === 'm02' && in_array($item['id'], ['git-basics','git-efm'], true) ? 'Travail disponible' : 'Zone vide à remplir' ?></span><a href="/atelier?m=<?= esc($moduleKey) ?>&a=<?= esc($item['id']) ?>">Ouvrir ↗</a></div>
          </article>
        <?php endforeach; ?></div>
      </section>
    <?php endforeach; ?>
  <?php endif; ?>
</main>

<?php else: ?>
<main>
  <section class="hero container" id="accueil">
    <div class="hero-copy reveal show">
      <p class="section-kicker">Portfolio · Développement digital</p>
      <h1>Simple, moderne<br>et <span>personnel.</span></h1>
      <p class="lead">Je suis Mohammed Khalki, développeur web en formation à Tanger. Je construis des interfaces web propres, claires et faciles à utiliser.</p>
      <div class="hero-actions">
        <a class="btn primary" href="#projets">Voir mes projets</a>
        <a class="btn outline" href="#ateliers">Voir mes ateliers</a>
      </div>
      <ul class="hero-meta">
        <li>Tanger, Maroc</li>
        <li>Développeur web</li>
        <li>Disponible pour apprendre</li>
      </ul>
    </div>
    <div class="hero-visual reveal show">
      <div class="visual-card">
        <div class="visual-ui">
          <span class="ui-pill">Portfolio</span>
          <span class="ui-dot"></span>
          <span class="ui-dot ui-dot-alt"></span>
        </div>
        <div class="visual-blur"></div>
        <img class="hero-portrait" src="/images/photo-clean.png" alt="Portrait de Mohammed Khalki" width="832" height="1102">
      </div>
    </div>
  </section>

  <section class="section container about" id="apropos">
    <div class="section-head reveal">
      <p class="section-kicker">À propos</p>
      <h2>Un profil en construction, <span>des bases solides.</span></h2>
    </div>
    <div class="section-copy reveal">
      <p>Je m’intéresse au développement web, à la conception d’interfaces et à la manière de transformer une idée en projet concret.</p>
      <p>Mon objectif est d’améliorer mon niveau projet après projet, avec une approche simple, propre et bien structurée.</p>
    </div>
  </section>

  <section class="section container" id="competences">
    <div class="section-head reveal">
      <p class="section-kicker">Compétences</p>
      <h2>Les outils que j’utilise.</h2>
    </div>
    <div class="skills-grid"><?php foreach($skills as $skill): ?>
      <article class="panel reveal skill-card"><h3><?= esc($skill['name']) ?></h3><p><?= esc($skill['stack']) ?></p></article>
    <?php endforeach; ?></div>
  </section>

  <section class="section container" id="projets">
    <div class="section-head reveal">
      <p class="section-kicker">Projets</p>
      <h2>Quelques projets personnels.</h2>
    </div>
    <div class="project-grid"><?php foreach($projects as $project): ?>
      <article class="panel reveal project-card">
        <span class="project-type"><?= esc($project['type']) ?></span>
        <h3><?= esc($project['name']) ?></h3>
        <p><?= esc($project['desc']) ?></p>
        <div class="chip-row"><?php foreach($project['stack'] as $tag): ?><span><?= esc($tag) ?></span><?php endforeach; ?></div>
      </article>
    <?php endforeach; ?></div>
  </section>

  <section class="section container" id="ateliers">
    <div class="section-head reveal">
      <p class="section-kicker">Ateliers</p>
      <h2>Les 7 ateliers <span>M02</span>.</h2>
      <p class="section-subtitle">Mes réalisations des ateliers 3 et 5 sont disponibles. Les autres ateliers seront ajoutés progressivement.</p>
    </div>
    <div class="atelier-grid atelier-grid-home"><?php foreach($m02Ateliers as $index=>$item): ?>
      <article class="atelier-card reveal">
        <div class="atelier-top"><span class="atelier-number"><?= str_pad((string)($index+1),2,'0',STR_PAD_LEFT) ?></span><span class="badge badge-muted">M02</span></div>
        <h3><?= esc($item['title']) ?></h3>
        <p><?= esc($item['summary']) ?></p>
        <div class="atelier-bottom"><span class="empty-label"><?= in_array($item['id'], ['git-basics','git-efm'], true) ? 'Travail disponible' : 'À remplir plus tard' ?></span><a href="/atelier?m=m02&a=<?= esc($item['id']) ?>">Détail ↗</a></div>
      </article>
    <?php endforeach; ?></div>
    <div class="section-foot reveal"><a class="btn outline" href="/module?m=m02">Voir tout le module M02</a></div>
  </section>

  <section class="section container" id="modules">
    <div class="section-head reveal">
      <p class="section-kicker">Modules</p>
      <h2>Vue d’ensemble de ma formation.</h2>
    </div>
    <div class="module-overview"><?php foreach($modules as $key=>$module): ?>
      <a class="panel reveal module-card" href="/module?m=<?= esc($key) ?>">
        <div class="module-top"><span class="badge"><?= esc($module['code']) ?></span><span>↗</span></div>
        <h3><?= esc($module['title']) ?></h3>
        <p><?= esc($module['intro']) ?></p>
        <small><?= count(allAteliers($module)) ?> atelier<?= count(allAteliers($module))>1?'s':'' ?></small>
      </a>
    <?php endforeach; ?></div>
  </section>

  <section class="section container contact" id="contact">
    <div class="section-head reveal">
      <p class="section-kicker">Contact</p>
      <h2>Discutons d’un projet.</h2>
    </div>
    <div class="contact-box panel reveal">
      <p>Vous pouvez me contacter pour échanger à propos d’un projet, d’un stage ou d’une collaboration.</p>
      <div class="hero-actions">
        <?php if($profile['email']): ?><a class="btn primary" href="mailto:<?= esc($profile['email']) ?>">Envoyer un e-mail</a><?php endif; ?>
        <a class="btn outline" href="<?= esc($profile['github']) ?>" target="_blank" rel="noopener noreferrer">GitHub ↗</a>
      </div>
    </div>
  </section>
</main>
<?php endif; ?>

<footer class="footer">
  <div class="container footer-wrap">
    <span>© <?= date('Y') ?> Mohammed Khalki</span>
    <span>PHP · CSS · JavaScript</span>
    <a href="#top">Retour en haut ↑</a>
  </div>
</footer>
</body>
</html>
