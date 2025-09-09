<?php
$host = getenv('DB_HOST') ?: 'mariadb';
$db   = getenv('DB_NAME') ?: 'music_library';
$user = getenv('DB_USERNAME') ?: 'music_user';
$pass = getenv('DB_PASSWORD') ?: 'music_pass';
$dsn  = "mysql:host={$host};dbname={$db};charset=utf8mb4";

$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $user, $pass, $options);
