<?php
$config = require __DIR__ . '/../../../../config/database.php';
$conn = new PDO(
    "pgsql:host={$config['host']};dbname={$config['database']}",
    $config['username'],
    $config['password']
);

$url_gambar = $_POST['url_gambar'];

$stmt = $conn->prepare("INSERT INTO galeri (url_gambar, created_at) VALUES (?, NOW())");
$stmt->execute([$judul, $kategori, $url_gambar]);

header("Location: tables.html"); // Redirect kembali ke tabel
exit;
?>