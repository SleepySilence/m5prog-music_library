<?php
require_once __DIR__ . '/../lib/auth.php';
require_login();
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

$errors = [];
$values = [
  'no' => (string)$current['no'],
  'title' => $current['title'],
  'duration' => $current['duration'],
  'year' => (string)$current['year'],
  'slug' => $current['slug'],
  'description' => $current['description'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $values['no'] = trim($_POST['no'] ?? '');
  $values['title'] = trim($_POST['title'] ?? '');
  $values['duration'] = trim($_POST['duration'] ?? '');
  $values['year'] = trim($_POST['year'] ?? '');
  $values['slug'] = trim($_POST['slug'] ?? '');
  $values['description'] = trim($_POST['description'] ?? '');

  if ($values['no'] === '' || !ctype_digit($values['no'])) $errors['no'] = 'Invalid';
  if ($values['title'] === '') $errors['title'] = 'Required';
  if ($values['duration'] === '' || !preg_match('/^\d{1,2}:\d{2}$/', $values['duration'])) $errors['duration'] = 'mm:ss';
  if ($values['year'] === '' || !ctype_digit($values['year'])) $errors['year'] = 'Invalid';

  $base = $values['slug'] !== '' ? $values['slug'] : strtolower(preg_replace('/[^a-z0-9]+/i','-', $values['title']));
  $base = trim($base, '-');
  $slugOut = $base === '' ? $current['slug'] : $base;
  $i = 2;
  while (track_slug_exists_other($pdo, $slugOut, (int)$current['id'])) { $slugOut = $base . '-' . $i; $i++; }
  $values['slug'] = $slugOut;

  if (empty($errors)) {
    track_update($pdo, (int)$current['id'], [
      'no' => (int)$values['no'],
      'title' => $values['title'],
      'duration' => $values['duration'],
      'year' => (int)$values['year'],
      'slug' => $values['slug'],
      'description' => $values['description'],
    ]);
    flash('success', 'Track updated.');
    header('Location: /single/' . urlencode($values['slug']));
    exit;
  }
}
?>
<h1 class="mb-4">Edit Track</h1>
<form method="post" class="row g-3">
  <div class="col-md-2">
    <label class="form-label">No</label>
    <input type="number" name="no" class="form-control <?php echo isset($errors['no'])?'is-invalid':''; ?>" value="<?php echo htmlspecialchars($values['no']); ?>">
  </div>
  <div class="col-md-6">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control <?php echo isset($errors['title'])?'is-invalid':''; ?>" value="<?php echo htmlspecialchars($values['title']); ?>">
  </div>
  <div class="col-md-4">
    <label class="form-label">Duration (mm:ss)</label>
    <input type="text" name="duration" class="form-control <?php echo isset($errors['duration'])?'is-invalid':''; ?>" value="<?php echo htmlspecialchars($values['duration']); ?>">
  </div>
  <div class="col-md-3">
    <label class="form-label">Year</label>
    <input type="number" name="year" class="form-control <?php echo isset($errors['year'])?'is-invalid':''; ?>" value="<?php echo htmlspecialchars($values['year']); ?>">
  </div>
  <div class="col-md-9">
    <label class="form-label">Slug</label>
    <input type="text" name="slug" class="form-control" value="<?php echo htmlspecialchars($values['slug']); ?>">
  </div>
  <div class="col-12">
    <label class="form-label">Description</label>
    <textarea name="description" rows="6" class="form-control"><?php echo htmlspecialchars($values['description']); ?></textarea>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-outline-light">Save</button>
    <a href="/single/<?php echo urlencode($current['slug']); ?>" class="btn btn-secondary ms-2">Cancel</a>
  </div>
</form>
<?php require_once __DIR__ . '/../views/footer.php'; ?>
