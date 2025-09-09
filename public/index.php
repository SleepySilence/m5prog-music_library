<?php
require_once __DIR__ . '/../views/header.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/TrackModel.php';

$album = [
  'title' => 'A Matter of Time',
  'artist' => 'Laufey',
  'released' => '2025-08-22',
  'cover' => '/assets/img/banner.jpg'
];

$route = $_GET['r'] ?? '/';
$parts = array_values(array_filter(explode('/', $route), fn($p) => $p !== '' && $p !== 'index.php'));
$mijn_pagina = end($parts);
$is_single = (count($parts) >= 2 && $parts[0] === 'single' && $mijn_pagina !== 'single');

if ($is_single) {
  $currentTrack = track_by_slug($pdo, $mijn_pagina);
  require_once __DIR__ . '/../views/single.php';
  require_once __DIR__ . '/../views/footer.php';
  exit;
}

$q = trim($_GET['q'] ?? '');
$sort = $_GET['sort'] ?? 'no';
$dir = $_GET['dir'] ?? 'ASC';
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 9;

require_once __DIR__ . '/../views/overview.php';
require_once __DIR__ . '/../views/footer.php';
