<?php
// Serveur local : php -S localhost:8000 -t public router.php
$u = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($u !== '/' && is_file(__DIR__ . '/public' . $u)) return false; // fichiers statiques
$map = ['/module' => 'module', '/projets' => 'projets'];
if (isset($map[$u])) $_GET['p'] = $map[$u];
require __DIR__ . '/api/index.php';
