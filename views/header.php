<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?><!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A Matter of Time — Laufey Library</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
  </head>
  <body class="theme-a-matter-of-time">
    <?php include_once __DIR__ . '/navigation.php'; ?>
    <main class="container py-5">
    <?php include_once __DIR__ . '/flash.php'; ?>
