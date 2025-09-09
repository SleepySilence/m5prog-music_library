<?php
require_once __DIR__ . '/../views/header.php';
require_once __DIR__ . '/../views/data.php';

$slug = $_GET['track'] ?? null;
$currentTrack = null;

foreach ($tracks as $t) {
  if ($t['slug'] === $slug) {
    $currentTrack = $t;
    break;
  }
}

if (!$currentTrack) {
  echo "<h1>Track not found</h1>";
  require_once __DIR__ . '/../views/footer.php';
  exit;
}
?>
  <div class="row align-items-start g-4 track-detail">
    <div class="col-12">
      <h1><?php echo htmlspecialchars($currentTrack['title']); ?></h1>
      <p class="lead mb-1">Track #<?php echo (int)$currentTrack['no']; ?></p>
      <p class="mb-1">Duration: <?php echo htmlspecialchars($currentTrack['duration']); ?></p>
      <p class="mb-1">Year: <?php echo (int)$currentTrack['year']; ?></p>
      <p class="mt-3"><?php echo htmlspecialchars($currentTrack['description']); ?></p>
      <a href="index.php" class="btn btn-outline-light mt-4">← Back to tracklist</a>
    </div>
  </div>
<?php require_once __DIR__ . '/../views/footer.php'; ?>
