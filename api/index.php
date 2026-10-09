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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<nav><div class="w">
  <a class="brand" href="/<?= $q1 ?>"><?= h($d['nom']) ?></a>
  <a class="h" href="/<?= $q1 ?>#modules">Modules</a>
  <a class="h" href="/projets<?= $q1 ?>"><?= T('Projets', 'Projects') ?></a>
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
    <div class="c"><h3><?= h(L($x['titre'])) ?></h3><p><?= h(L($x['desc'])) ?></p><?= tags($x['tags']) ?>
      <div class="row"><?= btn(T('Voir', 'View'), $x['pdf'], $soon) ?><?= btn('GitHub', $x['git'], $soon) ?></div>
    </div>
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
    <div class="g">
    <?php foreach ($d['modules'] as $i => $mo): ?>
      <div class="c"><h3><?= h(L($mo['titre'])) ?></h3><?= tags($mo['tags']) ?>
        <p><?= count($mo['ateliers']) ?> <?= T('ateliers', 'workshops') ?></p>
        <div class="row"><a class="b" href="/module?m=<?= $i + 1 ?><?= $ql ?>"><?= T('Voir le module', 'View module') ?></a></div>
      </div>
    <?php endforeach; ?>
    </div></section>

  <section><h2><?= T('Projets', 'Projects') ?></h2>
    <p class="sub"><?= T('Mes réalisations et leurs technologies.', 'My work and the technologies behind it.') ?></p>
    <a class="b" href="/projets<?= $q1 ?>"><?= T('Voir les projets', 'View projects') ?></a></section>
</main>
<?php endif; ?>

<footer>© <?= date('Y') ?> <?= h($d['nom']) ?></footer>
</body>
</html>
