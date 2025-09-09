<?php
function tracks_all(PDO $pdo): array {
  $stmt = $pdo->query("SELECT id, no, title, duration, year, slug FROM tracks ORDER BY no ASC");
  return $stmt->fetchAll();
}

function track_by_slug(PDO $pdo, string $slug): ?array {
  $stmt = $pdo->prepare("SELECT id, no, title, duration, year, slug, description FROM tracks WHERE slug = ? LIMIT 1");
  $stmt->execute([$slug]);
  $row = $stmt->fetch();
  return $row ?: null;
}

function track_slug_exists(PDO $pdo, string $slug): bool {
  $stmt = $pdo->prepare("SELECT 1 FROM tracks WHERE slug = ? LIMIT 1");
  $stmt->execute([$slug]);
  return (bool)$stmt->fetchColumn();
}

function track_slug_exists_other(PDO $pdo, string $slug, int $excludeId): bool {
  $stmt = $pdo->prepare("SELECT 1 FROM tracks WHERE slug = ? AND id <> ? LIMIT 1");
  $stmt->execute([$slug, $excludeId]);
  return (bool)$stmt->fetchColumn();
}

function track_create(PDO $pdo, array $data): int {
  $stmt = $pdo->prepare("INSERT INTO tracks (no, title, duration, year, slug, description) VALUES (?,?,?,?,?,?)");
  $stmt->execute([
    $data['no'],
    $data['title'],
    $data['duration'],
    $data['year'],
    $data['slug'],
    $data['description'],
  ]);
  return (int)$pdo->lastInsertId();
}

function track_update(PDO $pdo, int $id, array $data): void {
  $stmt = $pdo->prepare("UPDATE tracks SET no = ?, title = ?, duration = ?, year = ?, slug = ?, description = ? WHERE id = ?");
  $stmt->execute([
    $data['no'],
    $data['title'],
    $data['duration'],
    $data['year'],
    $data['slug'],
    $data['description'],
    $id
  ]);
}

function track_delete(PDO $pdo, int $id): void {
  $stmt = $pdo->prepare("DELETE FROM tracks WHERE id = ?");
  $stmt->execute([$id]);
}

function tracks_count(PDO $pdo, string $q): int {
  $sql = "SELECT COUNT(*) FROM tracks";
  if ($q !== '') $sql .= " WHERE title LIKE :q OR description LIKE :q";
  $stmt = $pdo->prepare($sql);
  if ($q !== '') $stmt->bindValue(':q', '%'.$q.'%', PDO::PARAM_STR);
  $stmt->execute();
  return (int)$stmt->fetchColumn();
}

function tracks_find(PDO $pdo, string $q, string $sort, string $dir, int $limit, int $offset): array {
  $allowedSort = ['no','title','duration','year'];
  if (!in_array($sort, $allowedSort, true)) $sort = 'no';
  $dir = strtoupper($dir) === 'DESC' ? 'DESC' : 'ASC';

  $sql = "SELECT id, no, title, duration, year, slug FROM tracks";
  if ($q !== '') $sql .= " WHERE title LIKE :q OR description LIKE :q";
  $sql .= " ORDER BY $sort $dir LIMIT :limit OFFSET :offset";

  $stmt = $pdo->prepare($sql);
  if ($q !== '') $stmt->bindValue(':q', '%'.$q.'%', PDO::PARAM_STR);
  $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
  $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll();
}
