<?php
require_once __DIR__ . '/../../../config/database.php';

$db = new Database();
$conn = $db->connect();

$judul   = $_POST['judul'] ?? '';
$konten  = $_POST['konten'] ?? '';
$publish = date('Y-m-d');

$thumbnailPath = '';
if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
    $newName = 'thumb_' . time() . '.' . $ext;
    $uploadDir = __DIR__ . '/../../../../public/assets/img/';
    $uploadPath = $uploadDir . $newName;
    if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadPath)) {
        $thumbnailPath = '/assets/img/' . $newName;
    }
}

$stmt = $conn->prepare("INSERT INTO news (title, content, thumbnail, published_date, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->execute([$judul, $konten, $thumbnailPath, $publish]);

header("Location: news.php");
exit;
?>