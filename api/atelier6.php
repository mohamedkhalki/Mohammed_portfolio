<?php
declare(strict_types=1);

/** Atelier 6 – admin-only CRUD demonstration. Secrets never live in this repository. */
function a6h($v): string { return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function a6env(string $key): string { return trim((string)(getenv($key) ?: '')); }
function a6len(string $s): int { return function_exists('mb_strlen') ? mb_strlen($s) : strlen($s); }
function a6initial(string $s): string { return function_exists('mb_substr') ? mb_strtoupper(mb_substr($s,0,1)) : strtoupper(substr($s,0,1)); }
function a6local(): bool {
    $host = strtolower(explode(':', (string)($_SERVER['HTTP_HOST'] ?? ''))[0]);
    return a6env('ATELIER6_LOCAL_DEV') === '1' && in_array($host, ['127.0.0.1', 'localhost'], true) && in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true);
}
function a6authorized(): bool {
    if (a6local()) return true;
    $secret = a6env('ATELIER6_ADMIN_PASSWORD');
    if ($secret === '') return false;
    $user = (string)($_SERVER['PHP_AUTH_USER'] ?? '');
    $pass = (string)($_SERVER['PHP_AUTH_PW'] ?? '');
    if (($user === '' || $pass === '') && isset($_SERVER['HTTP_AUTHORIZATION']) && str_starts_with($_SERVER['HTTP_AUTHORIZATION'], 'Basic ')) {
        $decoded = base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6), true);
        if (is_string($decoded) && str_contains($decoded, ':')) [$user, $pass] = explode(':', $decoded, 2);
    }
    return $user === 'admin' && hash_equals($secret, $pass);
}
function a6auth(): void {
    if (a6authorized()) return;
    if (a6env('ATELIER6_ADMIN_PASSWORD') === '') {
        http_response_code(503);
        exit('Administration non configurée. Définir ATELIER6_ADMIN_PASSWORD sur le serveur.');
    }
    header('WWW-Authenticate: Basic realm="Atelier 6 administration"');
    http_response_code(401);
    exit('Authentification requise.');
}
function a6config(): array {
    $localDb = is_file(dirname(__DIR__).'/config.local.php') ? require dirname(__DIR__).'/config.local.php' : [];
    $localCloud = is_file(dirname(__DIR__).'/cloudinary.local.php') ? require dirname(__DIR__).'/cloudinary.local.php' : [];
    return [
        'host' => a6env('ATELIER6_DB_HOST') ?: (string)($localDb['host'] ?? ''),
        'port' => (int)(a6env('ATELIER6_DB_PORT') ?: ($localDb['port'] ?? 3306)),
        'database' => a6env('ATELIER6_DB_NAME') ?: (string)($localDb['database'] ?? ''),
        'user' => a6env('ATELIER6_DB_USER') ?: (string)($localDb['username'] ?? ''),
        'password' => a6env('ATELIER6_DB_PASSWORD') ?: (string)($localDb['password'] ?? ''),
        'caPath' => (string)($localDb['ssl_ca'] ?? ''),
        'caB64' => a6env('ATELIER6_DB_CA_BASE64'),
        'cloud' => a6env('ATELIER6_CLOUD_NAME') ?: (string)($localCloud['cloud_name'] ?? ''),
        'key' => a6env('ATELIER6_CLOUD_KEY') ?: (string)($localCloud['api_key'] ?? ''),
        'secret' => a6env('ATELIER6_CLOUD_SECRET') ?: (string)($localCloud['api_secret'] ?? ''),
    ];
}
function a6configured(array $cfg): bool {
    foreach (['host','database','user','password','cloud','key','secret'] as $name) {
        if ($cfg[$name] === '' || str_starts_with((string)$cfg[$name], 'YOUR_')) return false;
    }
    return $cfg['caB64'] !== '' || (is_file($cfg['caPath']) && is_readable($cfg['caPath']));
}
function a6db(array $cfg): PDO {
    $ca = $cfg['caPath'];
    if ($cfg['caB64'] !== '') {
        $pem = base64_decode($cfg['caB64'], true);
        if (!is_string($pem) || !str_contains($pem, 'BEGIN CERTIFICATE')) throw new RuntimeException('CA invalide');
        $ca = tempnam(sys_get_temp_dir(), 'a6ca_');
        if ($ca === false || file_put_contents($ca, $pem) === false) throw new RuntimeException('CA inaccessible');
        register_shutdown_function(static function () use ($ca) { @unlink($ca); });
    }
    if ($ca === '' || !is_file($ca)) throw new RuntimeException('CA manquante');
    $dsn = 'mysql:host='.$cfg['host'].';port='.$cfg['port'].';dbname='.$cfg['database'].';charset=utf8mb4';
    return new PDO($dsn, $cfg['user'], $cfg['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_SSL_CA => $ca,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
    ]);
}
function a6upload(array $cfg, array $photo): string {
    if (($photo['error'] ?? -1) !== UPLOAD_ERR_OK || !is_uploaded_file((string)($photo['tmp_name'] ?? ''))) throw new InvalidArgumentException('Photo invalide.');
    if ($photo['size'] < 1 || $photo['size'] > 3 * 1024 * 1024) throw new InvalidArgumentException('Photo : taille maximale 3 Mo.');
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($photo['tmp_name']);
    $extensions = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
    if (!isset($extensions[$mime]) || @getimagesize($photo['tmp_name']) === false) throw new InvalidArgumentException('Photo JPG, PNG ou WEBP requise.');
    $url = 'https://api.cloudinary.com/v1_1/'.rawurlencode($cfg['cloud']).'/image/upload';
    $ch = curl_init($url);
    if ($ch === false) throw new RuntimeException('Connexion Cloudinary impossible');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_USERPWD => $cfg['key'].':'.$cfg['secret'],
        CURLOPT_POSTFIELDS => ['file'=>new CURLFile($photo['tmp_name'], $mime, 'stagiaire.'.$extensions[$mime]), 'folder'=>'atelier6_stagiaires'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 35,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);
    $response = curl_exec($ch);
    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_errno($ch);
    curl_close($ch);
    if ($response === false || $status < 200 || $status >= 300) throw new RuntimeException('Cloudinary HTTP '.$status.' / cURL '.$err);
    $json = json_decode($response, true);
    $image = $json['secure_url'] ?? '';
    if (!is_string($image) || !str_starts_with($image, 'https://res.cloudinary.com/')) throw new RuntimeException('Réponse Cloudinary invalide');
    return $image;
}
function a6csrf(string $secret, int $hour): string { return hash_hmac('sha256', 'atelier6-form:'.$hour, $secret); }

$mode = (string)($_GET['mode'] ?? 'demo');
$private = ($mode === 'admin');
$local = a6local();
if ($private) a6auth();
$config = a6config();
$ready = a6configured($config);
$error = '';
$success = isset($_GET['ok']);
$records = [
    ['nom'=>'Martin','prenom'=>'Samira','ville'=>'Tanger','photo_url'=>'','created_at'=>'Exemple'],
    ['nom'=>'Bennani','prenom'=>'Yassine','ville'=>'Rabat','photo_url'=>'','created_at'=>'Exemple'],
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    a6auth();
    if (!$ready) { http_response_code(503); $error = 'Connexion à la base non configurée.'; }
    else {
        $csrf = (string)($_POST['_csrf'] ?? '');
        $hour = (int)floor(time()/3600);
        $secret = a6env('ATELIER6_ADMIN_PASSWORD') ?: 'local-only-atelier6';
        if (!hash_equals(a6csrf($secret, $hour), $csrf) && !hash_equals(a6csrf($secret, $hour-1), $csrf)) {
            http_response_code(403); $error='Formulaire expiré. Rechargez la page.';
        } else {
            try {
                $nom = trim((string)($_POST['nom'] ?? ''));
                $prenom = trim((string)($_POST['prenom'] ?? ''));
                $ville = trim((string)($_POST['ville'] ?? ''));
                if ($nom === '' || $prenom === '' || $ville === '' || a6len($nom)>100 || a6len($prenom)>100 || a6len($ville)>100) throw new InvalidArgumentException('Veuillez compléter les champs (100 caractères maximum).');
                // Verify DB availability before uploading to avoid orphaned images on connection errors.
                $pdo = a6db($config);
                $photoUrl = a6upload($config, $_FILES['photo'] ?? []);
                $stmt = $pdo->prepare('INSERT INTO stagiaires (nom,prenom,ville,photo_url) VALUES (:nom,:prenom,:ville,:photo_url)');
                $stmt->execute(['nom'=>$nom,'prenom'=>$prenom,'ville'=>$ville,'photo_url'=>$photoUrl]);
                header('Location: /atelier6?mode=admin&ok=1', true, 303);
                exit;
            } catch (InvalidArgumentException $e) { http_response_code(400); $error=$e->getMessage(); }
              catch (Throwable $e) { error_log('Atelier6: '.$e->getMessage()); http_response_code(500); $error='Enregistrement impossible. Vérifiez la configuration et les journaux du serveur.'; }
        }
    }
}
if ($private && $ready) {
    try { $records = a6db($config)->query('SELECT nom,prenom,ville,photo_url,created_at FROM stagiaires ORDER BY id DESC LIMIT 50')->fetchAll(); }
    catch (Throwable $e) { error_log('Atelier6 listing: '.$e->getMessage()); $error='Impossible de charger la liste MySQL.'; $records=[]; }
}
$secret = a6env('ATELIER6_ADMIN_PASSWORD') ?: 'local-only-atelier6';
$token = a6csrf($secret, (int)floor(time()/3600));
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer');
header('Cache-Control: no-store');
?>
<!doctype html>
<html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Atelier 6 · Gestion des stagiaires</title><link rel="stylesheet" href="/css/atelier6.css"></head>
<body><main class="wrap">
<nav class="nav"><a href="/atelier?m=m02&amp;a=sprint3">← Portfolio · Atelier 6</a><a href="/atelier6?mode=<?= $private?'demo':'admin' ?>"><?= $private?'Voir la démo':'Espace administrateur' ?> ↗</a></nav>
<section class="heading"><span class="eyebrow">ATELIER 06 · PHP / MYSQL / CLOUDINARY</span><h1>Gestion des <em>stagiaires.</em></h1><p>Inscription, photos hébergées dans le cloud et base de données MySQL sécurisée.</p></section>
<?php if (!$private): ?><div class="notice">Démonstration publique avec données fictives. Vous pouvez remplir les champs pour une simulation locale à la page (aucune donnée transmise ni sauvegardée). L’inscription réelle est réservée à l’administrateur.</div><?php elseif (!$ready): ?><div class="notice warn">Configuration manquante : ajoutez les variables d’environnement Aiven et Cloudinary, et le certificat CA.</div><?php endif; ?>
<?php if ($error !== ''): ?><div class="notice warn" role="alert"><?= a6h($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="notice success" role="status">Stagiaire enregistré avec succès !</div><?php endif; ?>
<div class="layout"><section class="pane"><div class="pane-head"><span>01 / ENREGISTREMENT</span><h2>Nouveau stagiaire</h2></div>
<form id="atelier6-form" action="/atelier6?mode=admin" method="post" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?= a6h($token) ?>">
<div class="two"><label>Nom<input name="nom" maxlength="100" placeholder="Ex : El Amrani" required <?= $private&&!$ready?'disabled':'' ?>></label><label>Prénom<input name="prenom" maxlength="100" placeholder="Ex : Sara" required <?= $private&&!$ready?'disabled':'' ?>></label></div>
<label>Ville<select name="ville" required <?= $private&&!$ready?'disabled':'' ?>><option value="">Sélectionner une ville</option><option>Tanger</option><option>Rabat</option><option>Casablanca</option><option>Marrakech</option><option>Fès</option><option>Autre</option></select></label>
<label>Photo du stagiaire <small>JPG, PNG ou WEBP · 3 Mo max. Utilisez des images avec autorisation.</small><input type="file" name="photo" accept="image/jpeg,image/png,image/webp" required <?= $private&&!$ready?'disabled':'' ?>></label>
<button type="submit" <?= $private&&!$ready?'disabled':'' ?>>Enregistrer le stagiaire <span>↗</span></button>
</form></section>
<section class="pane"><div class="pane-head"><span>02 / BASE DE DONNÉES</span><h2><?= $private?'Liste des stagiaires':'Aperçu de la liste' ?></h2></div>
<div class="entries">
<?php if (!$records): ?><p class="empty">Aucun stagiaire pour le moment.</p><?php endif; ?>
<?php foreach($records as $rec): ?><article class="entry"><div class="avatar">
<?php $photo=(string)($rec['photo_url']??''); if($private && str_starts_with($photo,'https://res.cloudinary.com/')): ?><img loading="lazy" referrerpolicy="no-referrer" alt="Photo du stagiaire" src="<?= a6h($photo) ?>"><?php else: ?><?= a6h(a6initial((string)$rec['prenom'])) ?><?php endif; ?>
</div><div class="name"><strong><?= a6h($rec['prenom'].' '.$rec['nom']) ?></strong><span><?= a6h($rec['ville']) ?></span></div><small><?= a6h((string)$rec['created_at']) ?></small></article><?php endforeach; ?>
</div><p class="footnote"><?= $private?'Jusqu’à 50 inscriptions récentes · accès privé':'Noms fictifs · aucune donnée personnelle affichée' ?></p>
</section></div><footer>PHP 8.3 · Aiven MySQL + SSL · Cloudinary &nbsp;|&nbsp; <a href="/atelier?m=m02&amp;a=sprint3">Retour au portfolio</a> &nbsp;|&nbsp; <a href="/ateliers/m02/stagiaires-demo/atelier6-stagiaires-corrige.zip" download>Code source corrigé (ZIP)</a></footer>
</main>
<?php if (!$private): ?>
<script>
(function(){
  const form = document.getElementById('atelier6-form');
  const entries = document.querySelector('.entries');
  if (!form || !entries) return;
  form.addEventListener('submit', function(e){
    e.preventDefault();
    const data = new FormData(form);
    const first = String(data.get('prenom')||'').trim();
    const last = String(data.get('nom')||'').trim();
    const city = String(data.get('ville')||'').trim();
    if (!first || !last || !city) return;
    const card=document.createElement('article');card.className='entry';
    const avatar=document.createElement('div');avatar.className='avatar';
    avatar.textContent=first.slice(0,1).toUpperCase();
    const name=document.createElement('div');name.className='name';
    const strong=document.createElement('strong');strong.textContent=first+' '+last;
    const span=document.createElement('span');span.textContent=city;
    name.append(strong,span);
    const flag=document.createElement('small');flag.textContent='Simulation non sauvegardée';
    card.append(avatar,name,flag);
    entries.prepend(card);
    const notice=document.createElement('div');notice.className='notice success';
    notice.setAttribute('role','status');notice.textContent='Simulation réussie : aucune photo ni donnée envoyée à MySQL ou Cloudinary.';
    form.parentNode.insertBefore(notice,form);
    form.reset();
  });
})();
</script>
<?php endif; ?>
</body></html>
