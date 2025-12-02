<?php
// Initialize database connection and gallery model
require_once __DIR__ . '/../../model/galleryModel.php';
require_once __DIR__ . '/../../../config/database.php';

$database = new Database();
$pdo = $database->connect();

try {
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

    <main class="page-wrapper">
        <div class="gallery-page">
            
            <div class="gallery-header">
                <div class="gallery-label">Visual Portfolio</div>
                <h1 class="gallery-title">Gallery</h1>
                <p class="gallery-subtitle">
                    Dokumentasi visual kegiatan penelitian, eksperimen, dan pencapaian dari Learning Engineering 
                    Technology Research Group yang menunjukkan perjalanan inovasi kami.
                </p>
            </div>

            <?php if (!empty($galleries)): ?>
                
                <!-- Standard Grid Layout -->
                <div class="gallery-grid">
                    <?php foreach ($galleries as $index => $gallery): ?>
                        <div class="gallery-item" onclick="openModal('<?php echo htmlspecialchars($gallery['image']); ?>')">
                            <div class="gallery-image">
                                <img src="<?php echo htmlspecialchars($gallery['image']); ?>" 
                                     alt="Gallery Item <?php echo $index + 1; ?>"
                                     loading="lazy">
                                <div class="gallery-overlay">
                                    <i class="fas fa-expand"></i>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>
                <div class="no-gallery">
                    <i class="fas fa-images"></i>
                    <h3>Belum Ada Galeri</h3>
                    <p>Galeri visual kami sedang dalam pengembangan. Silakan kembali lagi nanti untuk melihat dokumentasi kegiatan terbaru.</p>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <!-- Image Modal -->
    <div id="galleryModal" class="gallery-modal" onclick="closeModal()">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <div class="modal-content">
            <img id="modalImage" src="" alt="Gallery Image">
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function openModal(imageSrc) {
            const modal = document.getElementById('galleryModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('galleryModal');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Add smooth loading effect
        document.addEventListener('DOMContentLoaded', function() {
            const galleryItems = document.querySelectorAll('.gallery-item');
            galleryItems.forEach((item, index) => {
                item.style.animationDelay = (index * 0.1) + 's';
                item.style.animation = 'fadeInUp 0.6s ease forwards';
            });
        });
    </script>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .gallery-item {
            opacity: 0;
        }
    </style>

</body>

</html>

