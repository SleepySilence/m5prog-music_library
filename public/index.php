<?php
require_once __DIR__ . '/../views/header.php';
require_once __DIR__ . '/../views/data.php';
?>
  <section class="hero card border-0 overflow-hidden mb-5">
    <div class="hero-img-wrap">
      <img src="assets/img/banner.jpg" class="hero-img" alt="A Matter of Time">
      <div class="hero-overlay"></div>
    </div>
    <div class="hero-text p-4 p-md-5">
      <h1 class="display-5 text-shadow"><?php echo htmlspecialchars($album['title']); ?></h1>
      <p class="lead m-0 text-shadow"><?php echo htmlspecialchars($album['artist']); ?> — Released <?php echo htmlspecialchars($album['released']); ?></p>
    </div>
  </section>

  <h2 class="h4 text-uppercase text-muted tracking mb-3">Tracklist</h2>
  <div class="row g-4">
    <?php foreach ($tracks as $t): ?>
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="card h-100 shadow-soft text-center d-flex flex-column justify-content-center">
          <div class="card-body">
            <h5 class="card-title mb-2"><?php echo htmlspecialchars($t['no'] . '. ' . $t['title']); ?></h5>
            <p class="card-text text-muted"><?php echo htmlspecialchars($t['duration']); ?> • <?php echo (int)$t['year']; ?></p>
            <a href="track.php?track=<?php echo urlencode($t['slug']); ?>" class="btn btn-outline-light mt-2">View</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php require_once __DIR__ . '/../views/footer.php'; ?>
