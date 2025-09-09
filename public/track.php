<?php
require_once __DIR__ . '/../views/header.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/TrackModel.php';

$slug = $_GET['track'] ?? '';
$currentTrack = $slug ? track_by_slug($pdo, $slug) : null;

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
      <p class="mt-3"><?php echo nl2br(htmlspecialchars($currentTrack['description'])); ?></p>
      <div class="mt-4">
        <a href="index.php" class="btn btn-secondary me-2">← Back</a>
        <a href="edit.php?track=<?php echo urlencode($currentTrack['slug']); ?>" class="btn btn-outline-light me-2">Edit</a>
        <form method="post" action="delete.php?track=<?php echo urlencode($currentTrack['slug']); ?>" style="display:inline">
          <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this track?')">Delete</button>
        </form>
      </div>
    </div>
  </div>
<?php require_once __DIR__ . '/../views/footer.php'; ?>
