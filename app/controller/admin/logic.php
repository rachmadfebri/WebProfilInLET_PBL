<?php
$config = require __DIR__ . '/../../config/database.php';
$conn = new PDO(
    "pgsql:host={$config['host']};dbname={$config['database']}",
    $config['username'],
    $config['password']
);

$stmt = $conn->query("SELECT * FROM galeri ORDER BY id DESC");
$galeri = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kirim $galeri ke view tables.html
require __DIR__ . '/../../app/view/admin/tables.html.php';
?>