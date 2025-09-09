<?php
require_once __DIR__ . '/../views/header.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/TrackModel.php';

$slug = $_GET['track'] ?? '';
$current = $slug ? track_by_slug($pdo, $slug) : null;
if (!$current) {
  echo "<h1>Track not found</h1>";
  require_once __DIR__ . '/../views/footer.php';
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  track_delete($pdo, (int)$current['id']);
  header('Location: index.php');
  exit;
}
?>
  <h1 class="mb-3">Delete Track</h1>
  <p>Delete “<?php echo htmlspecialchars($current['title']); ?>”?</p>
  <form method="post" class="mt-3">
    <button type="submit" class="btn btn-danger">Delete</button>
    <a href="track.php?track=<?php echo urlencode($current['slug']); ?>" class="btn btn-secondary ms-2">Cancel</a>
  </form>
<?php require_once __DIR__ . '/../views/footer.php'; ?>
