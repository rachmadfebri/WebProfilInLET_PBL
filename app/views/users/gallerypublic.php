<?php
// Initialize database connection and gallery model
try {
    // Gunakan $pdo dari index.php (sudah tersedia sebagai global)
    // Path dihitung dari app/views/users/, naik ke app/model/
    require_once __DIR__ . '/../../model/galleryModel.php';
    $galleryModel = new GalleryModel($pdo);
    $galleries = $galleryModel->getAll();
} catch (Exception $e) {
    error_log("Gallery Error: " . $e->getMessage());
    $galleries = [];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery • Learning Engineering Technology</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="page page-gallery">

    <?php include 'header.php'; ?>

    <main class="page-wrapper gallery-page">
        <div class="page-heading">
            <p class="page-label">Selected Works</p>
            <h1 class="page-title gradient-text">Galery</h1>
            <p class="page-subtitle">
                Ruang visual yang menampilkan dokumentasi kegiatan, eksperimen, dan hasil
                prototipe terbaru dari Learning Engineering Technology Research Group.
            </p>
        </div>

        <section class="gallery-wall">
            <?php if (!empty($galleries)): ?>
                <?php foreach ($galleries as $index => $gallery): ?>
                    <?php 
                        // Tentukan class untuk layout (wide, tall, normal)
                        // Rotasi pattern: wide, normal, normal, tall, wide, normal, normal, normal, tall, dll
                        $pattern = ($index + 1) % 10;
                        $galleryClass = 'gallery-brick';
                        if ($pattern == 1 || $pattern == 5) {
                            $galleryClass .= ' wide';
                        } elseif ($pattern == 4 || $pattern == 9) {
                            $galleryClass .= ' tall';
                        }
                    ?>
                    <a href="<?php echo htmlspecialchars($gallery['image']); ?>" 
                       class="<?php echo $galleryClass; ?>" 
                       target="_blank" 
                       rel="noopener">
                        <img src="<?php echo htmlspecialchars($gallery['image']); ?>" 
                             alt="Gallery Item <?php echo htmlspecialchars($gallery['id'] ?? $index + 1); ?>"
                             loading="lazy">
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #999;">
                    <p>Belum ada gambar dalam galeri.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <?php include 'footer.php'; ?>

</body>

</html>

