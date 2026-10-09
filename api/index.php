<?php
$d  = require __DIR__ . '/data.php';
$en = ($_GET['lang'] ?? 'fr') === 'en';
$p  = $_GET['p'] ?? 'home';
$m  = max(0, min(count($d['modules']) - 1, (int)($_GET['m'] ?? 1) - 1));

// Texte FR/EN : accepte une chaîne ou ['fr'=>…,'en'=>…]
function L($v) { global $en; return is_array($v) ? ($en ? ($v['en'] ?? $v['fr'] ?? '') : ($v['fr'] ?? $v['en'] ?? '')) : $v; }
function T($fr, $e) { global $en; return $en ? $e : $fr; }
function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES); }
function btn($label, $url, $soon) {
  return $url ? '<a class="b" href="' . h($url) . '" target="_blank" rel="noopener">' . $label . '</a>'
              : '<span class="b off">' . $soon . '</span>';
}
function tags($a) { return '<p class="tg">' . implode('', array_map(fn($x) => '<span>' . h($x) . '</span>', $a)) . '</p>'; }

function pbtn($label, $url, $soon, $cls = '', $gh = false) {
  $ico = $gh ? '<svg viewBox="0 0 16 16" width="16" height="16" fill="currentColor" aria-hidden="true"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38v-1.33c-2.23.48-2.7-1.07-2.7-1.07-.36-.92-.89-1.17-.89-1.17-.73-.5.05-.49.05-.49.8.06 1.23.83 1.23.83.71 1.22 1.87.87 2.33.66.07-.52.28-.87.5-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82a7.6 7.6 0 0 1 4 0c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.28.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48v2.2c0 .21.15.46.55.38A8 8 0 0 0 16 8c0-4.42-3.58-8-8-8z"/></svg> ' : '';
  return $url ? '<a class="pb ' . $cls . '" href="' . h($url) . '" target="_blank" rel="noopener">' . $ico . h($label) . '</a>'
              : '<span class="pb ' . $cls . ' off">' . $ico . h($soon) . '</span>';
}
function pcard($title, $desc, $tg, $actions) {
  return '<article class="pc"><div class="pv"><div class="win"><i></i><svg viewBox="0 0 24 24" width="38" height="38" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2.5"/><path d="M3 9h18M7 6.5h.01M10 6.5h.01"/></svg></div></div>'
       . '<div class="pt"><h3>' . h($title) . '</h3><p>' . h($desc) . '</p>' . tags($tg) . '<div class="row">' . $actions . '</div></div></article>';
}

$soon = T('Bientôt', 'Soon');
$q1 = $en ? '?lang=en' : '';        // lien simple
$ql = $en ? '&lang=en' : '';        // lien avec paramètre existant
$path = strtok($_SERVER['REQUEST_URI'], '?');
$toggle = $path . '?' . http_build_query(array_merge(array_diff_key($_GET, ['p' => 1]), ['lang' => $en ? 'fr' : 'en']));
$photo = is_file(__DIR__ . '/../public/images/photo.jpg') ? '/images/photo.jpg' : '';
$ini = ''; foreach (explode(' ', $d['nom']) as $w) $ini .= mb_substr($w, 0, 1);
$intro = T($d['age'] . ' ans, ' . $d['ville'] . '.', $d['age'] . ' years old, ' . $d['ville'] . '.');
?><!DOCTYPE html>
<html lang="<?= $en ? 'en' : 'fr' ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Portfolio – <?= h($d['nom']) ?></title>
<meta name="description" content="<?= h(L($d['bio'])) ?>">
<meta name="theme-color" content="#0b3d91">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Fraunces:wght@600;700&family=JetBrains+Mono:wght@500&display=swap">
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<nav><div class="w">
  <a class="brand" href="/<?= $q1 ?>"><?= h($d['nom']) ?></a>
  <a class="h" href="/<?= $q1 ?>#modules">Modules</a>
  <a class="h" href="/<?= $q1 ?>#projets"><?= T('Projets', 'Projects') ?></a>
  <a class="lg" href="<?= h($toggle) ?>"><?= $en ? 'FR' : 'EN' ?></a>
</div></nav>

<?php if ($p === 'module'): $mo = $d['modules'][$m]; ?>
<main class="w pg">
  <a class="back" href="/<?= $q1 ?>#modules">← <?= T('Retour', 'Back') ?></a>
  <h2><?= h(L($mo['titre'])) ?></h2>
  <?= tags($mo['tags']) ?>
  <p class="sub"><?= T('Ateliers du module', 'Module workshops') ?></p>
  <?php foreach ($mo['ateliers'] as $a): ?>
    <div class="at"><h3><?= h(L($a['titre'])) ?></h3>
      <?= btn(T('Voir la correction', 'View solution'), $a['git'], $soon) ?>
      <?= btn(T('Télécharger', 'Download'), $a['pdf'], $soon) ?>
    </div>
  <?php endforeach; ?>
</main>

<?php elseif ($p === 'projets'): ?>
<main class="w pg">
  <a class="back" href="/<?= $q1 ?>">← <?= T('Retour', 'Back') ?></a>
  <h2><?= T('Projets', 'Projects') ?></h2>
  <p class="sub"><?= T('Mes réalisations et leurs technologies.', 'My work and the technologies behind it.') ?></p>
  <div class="g">
  <?php foreach ($d['projets'] as $x): ?>
    <?= pcard(L($x['titre']), L($x['desc']), $x['tags'],
          pbtn(T('Voir le projet', 'View project'), $x['pdf'], $soon) . pbtn('GitHub', $x['git'], $soon, 'ol', true)) ?>
  <?php endforeach; ?>
  </div>
</main>

<?php else: ?>
<header class="hero"><div class="w hero-in">
  <div class="ph"><?php if ($photo): ?><img src="<?= $photo ?>" alt="<?= h($d['nom']) ?>"><?php else: echo h($ini); endif; ?></div>
  <div>
    <h1><?= h($d['nom']) ?></h1>
    <h2><?= h(L($d['titre'])) ?></h2>
    <p><?= h($intro) ?> <?= h(L($d['bio'])) ?></p>
    <div class="row">
      <a class="b w1" href="#modules">Modules</a>
      <a class="b o" href="/projets<?= $q1 ?>"><?= T('Projets', 'Projects') ?></a>
      <?php if ($d['github']): ?><a class="b o" href="<?= h($d['github']) ?>" target="_blank" rel="noopener">GitHub</a><?php endif; ?>
      <?php if (!empty($d['email'])): ?><a class="b o" href="mailto:<?= h($d['email']) ?>">Email</a><?php endif; ?>
    </div>
  </div>
</div></header>
<main class="w">
  <section><h2><?= T('Compétences', 'Skills') ?></h2>
    <div class="sk"><?php foreach ($d['skills'] as $s) echo '<span>' . h($s) . '</span>'; ?></div></section>

  <section id="modules"><h2>Modules</h2>
    <p class="sub"><?= T('Chaque module regroupe ses ateliers.', 'Each module groups its workshops.') ?></p>
    <div class="g<?= count($d['modules']) % 3 ? ' g2' : '' ?>">
    <?php foreach ($d['modules'] as $i => $mo):
      $desc = !empty($mo['desc']) ? L($mo['desc']) : count($mo['ateliers']) . ' ' . T('ateliers', 'workshops'); ?>
      <?= pcard(L($mo['titre']), $desc, $mo['tags'],
            '<a class="pb" href="/module?m=' . ($i + 1) . $ql . '">' . h(T('Voir module ', 'View module ') . ($i + 1)) . '</a>'
            . pbtn('GitHub', $mo['git'] ?? '', $soon, 'ol', true)) ?>
    <?php endforeach; ?>
    </div></section>
</main>

<section class="dk" id="projets"><div class="w">
  <h2><?= T('Projets', 'Projects') ?></h2>
  <p class="sub"><?= T('Mes réalisations et leurs technologies.', 'My work and the technologies behind it.') ?></p>
  <div class="g">
  <?php foreach ($d['projets'] as $x): ?>
    <?= pcard(L($x['titre']), L($x['desc']), $x['tags'],
          pbtn(T('Voir le projet', 'View project'), $x['pdf'], $soon) . pbtn('GitHub', $x['git'], $soon, 'ol', true)) ?>
  <?php endforeach; ?>
  </div>
</div></section>
<?php endif; ?>

<footer>© <?= date('Y') ?> <?= h($d['nom']) ?></footer>
</body>
</html>
