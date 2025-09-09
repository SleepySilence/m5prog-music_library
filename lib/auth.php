<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function is_logged_in(): bool {
  return !empty($_SESSION['user']);
}

function require_login(): void {
  if (!is_logged_in()) {
    $_SESSION['flash'] = ['type' => 'warning', 'msg' => 'Please log in.'];
    header('Location: /login.php');
    exit;
  }
}

function login_user(string $username): void {
  $_SESSION['user'] = ['name' => $username];
}

function logout_user(): void {
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time()-42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
  }
  session_destroy();
}

function flash(string $type, string $msg): void {
  $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}
