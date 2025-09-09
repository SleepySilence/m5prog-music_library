<?php if (!empty($_SESSION['flash'])): $f = $_SESSION['flash']; unset($_SESSION['flash']); ?>
  <div class="alert alert-dark border-light-subtle mb-4" role="alert">
    <?php echo htmlspecialchars($f['msg']); ?>
  </div>
<?php endif; ?>
