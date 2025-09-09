<?php
require_once __DIR__ . '/../views/header.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/TrackModel.php';

$album = [
  'title' => 'A Matter of Time',
  'artist' => 'Laufey',
  'released' => '2025-08-22',
  'cover' => 'assets/img/banner.jpg'
];

$route = $_GET['r'] ?? $_SERVER['REQUEST_URI'];
$parts = array_values(array_filter(explode('/', $route), function($p){
  return $p !== '' && $p !== 'index.php';
}));
$mijn_pagina = end($parts);
$is_single = (count($parts) >= 2 && $parts[0] === 'single' && $mijn_pagina !== 'single');

if (empty($mijn_pagina) || !$is_single) {
  $tracks = tracks_all($pdo);
  require_once __DIR__ . '/../views/overview.php';
  require_once __DIR__ . '/../views/footer.php';
  exit;
}

$currentTrack = track_by_slug($pdo, $mijn_pagina);
require_once __DIR__ . '/../views/single.php';
require_once __DIR__ . '/../views/footer.php';
