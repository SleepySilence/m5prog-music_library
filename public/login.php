<?php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../views/header.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $u = trim($_POST['username'] ?? '');
  $p = trim($_POST['password'] ?? '');
  $envU = getenv('ADMIN_USER') ?: 'admin';
  $envP = getenv('ADMIN_PASS') ?: 'admin123';
  if ($u === $envU && $p === $envP) {
    login_user($u);
    flash('success', 'Welcome, '.$u.'.');
    header('Location: /');
    exit;
  } else {
    $err = 'Invalid credentials.';
  }
}
?>
<h1 class="mb-4">Login</h1>
<?php if ($err): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($err); ?></div>
<?php endif; ?>
<form method="post" class="row g-3" autocomplete="off">
  <div class="col-12 col-md-6">
    <label class="form-label">Username</label>
    <input type="text" name="username" class="form-control" required>
  </div>
  <div class="col-12 col-md-6">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <div class="col-12">
    <button class="btn btn-outline-light">Login</button>
    <a href="/" class="btn btn-secondary ms-2">Cancel</a>
  </div>
</form>
<?php require_once __DIR__ . '/../views/footer.php'; ?>
