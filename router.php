<?php
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$file = __DIR__.'/public'.$path;
if ($path !== '/' && is_file($file)) return false;
if ($path === '/atelier6') { require __DIR__.'/api/atelier6.php'; return true; }
require __DIR__.'/api/index.php';
