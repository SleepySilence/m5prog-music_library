<?php
$total = tracks_count($pdo, $q);
$pages = max(1, (int)ceil($total / $perPage));
$offset = ($page - 1) * $perPage;
$tracks = tracks_find($pdo, $q, $sort, $dir, $perPage, $offset);
?>
<section class="hero card border-0 overflow-hidden mb-5">
  <div class="hero-img-wrap">
    <img src="<?php echo htmlspecialchars($album['cover']); ?>" class="hero-img" alt="A Matter of Time">
    <div class="hero-overlay"></div>
  </div>
  <div class="hero-text p-4 p-md-5">
    <h1 class="display-5 text-shadow"><?php echo htmlspecialchars($album['title']); ?></h1>
    <p class="lead m-0 text-shadow"><?php echo htmlspecialchars($album['artist']); ?> — Released <?php echo htmlspecialchars($album['released']); ?></p>
  </div>
</section>

<form method="get" class="row g-3 align-items-end mb-4">
  <div class="col-md-6">
    <label class="form-label">Search</label>
    <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" class="form-control" placeholder="Search tracks...">
  </div>
  <div class="col-md-3">
    <label class="form-label">Sort</label>
    <select name="sort" class="form-select">
      <option value="no" <?php echo $sort==='no'?'selected':''; ?>>Track No</option>
      <option value="title" <?php echo $sort==='title'?'selected':''; ?>>Title</option>
      <option value="duration" <?php echo $sort==='duration'?'selected':''; ?>>Duration</option>
      <option value="year" <?php echo $sort==='year'?'selected':''; ?>>Year</option>
    </select>
  </div>
  <div class="col-md-2">
    <label class="form-label">Direction</label>
    <select name="dir" class="form-select">
      <option value="ASC" <?php echo strtoupper($dir)==='ASC'?'selected':''; ?>>ASC</option>
      <option value="DESC" <?php echo strtoupper($dir)==='DESC'?'selected':''; ?>>DESC</option>
    </select>
  </div>
  <div class="col-md-1">
    <button class="btn btn-outline-light w-100">Go</button>
  </div>
</form>

<h2 class="h4 text-uppercase text-muted tracking mb-3">Tracklist</h2>
<div class="row g-4">
  <?php foreach ($tracks as $t): ?>
    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card h-100 shadow-soft text-center d-flex flex-column justify-content-center">
        <div class="card-body">
          <h5 class="card-title mb-2"><?php echo htmlspecialchars($t['no'] . '. ' . $t['title']); ?></h5>
          <p class="card-text text-muted"><?php echo htmlspecialchars($t['duration']); ?> • <?php echo (int)$t['year']; ?></p>
          <a href="/single/<?php echo htmlspecialchars($t['slug']); ?>" class="btn btn-outline-light mt-2">View</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php
$queryBase = function(array $extra = []) use ($q,$sort,$dir) {
  $params = array_merge(['q'=>$q,'sort'=>$sort,'dir'=>$dir], $extra);
  return '?' . http_build_query(array_filter($params, fn($v) => $v !== '' && $v !== null));
};
?>

<?php if ($pages > 1): ?>
<nav class="mt-4">
  <ul class="pagination pagination-dark">
    <li class="page-item <?php echo $page<=1?'disabled':''; ?>">
      <a class="page-link" href="<?php echo $queryBase(['page'=>$page-1]); ?>">&laquo;</a>
    </li>
    <?php for ($i=1;$i<=$pages;$i++): ?>
      <li class="page-item <?php echo $i===$page?'active':''; ?>">
        <a class="page-link" href="<?php echo $queryBase(['page'=>$i]); ?>"><?php echo $i; ?></a>
      </li>
    <?php endfor; ?>
    <li class="page-item <?php echo $page>=$pages?'disabled':''; ?>">
      <a class="page-link" href="<?php echo $queryBase(['page'=>$page+1]); ?>">&raquo;</a>
    </li>
  </ul>
</nav>
<?php endif; ?>
