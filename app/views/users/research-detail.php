<?php
// Research detail page
require_once __DIR__ . '/../../model/researchModel.php';
require_once __DIR__ . '/../../../config/database.php';

$database = new Database();
$pdo = $database->connect();

$researchId = $_GET['id'] ?? null;
$research = null;

if ($researchId) {
    try {
        $researchModel = new ResearchModel($pdo);
        $research = $researchModel->getById($researchId);
    } catch (Exception $e) {
        error_log("Research Detail Error: " . $e->getMessage());
    }
}

if (!$research) {
    header('Location: ?page=home');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($research['title']) ?> • Research Detail</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="page page-research-detail research-detail-page">

    <?php include 'header.php'; ?>

    <main class="page-wrapper">
        <div class="research-detail">
            
            <a href="?page=home#research" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Research Activities
            </a>
            
            <div class="research-hero">
                <?php if (!empty($research['image'])): ?>
                    <img src="<?= htmlspecialchars($research['image']) ?>" 
                         alt="<?= htmlspecialchars($research['title']) ?>" 
                         class="research-hero-image">
                <?php endif; ?>
                
                <h1 class="research-title"><?= htmlspecialchars($research['title']) ?></h1>
                
                <div class="research-meta">
                    <span>
                        <i class="fas fa-calendar-alt"></i>
                        <?= date('d F Y', strtotime($research['created_at'])) ?>
                    </span>
                    <span>
                        <i class="fas fa-flask"></i>
                        Research Activity
                    </span>
                </div>
            </div>
            
            <div class="research-content">
                <?= nl2br(htmlspecialchars($research['description'])) ?>
            </div>
            
            <?php
            // Get related research activities
            try {
                $researchModel = new ResearchModel($pdo);
                $relatedResearch = array_filter(
                    $researchModel->getAll(), 
                    function($item) use ($research) {
                        return $item['id'] != $research['id'];
                    }
                );
                $relatedResearch = array_slice($relatedResearch, 0, 3);
            } catch (Exception $e) {
                $relatedResearch = [];
            }
            ?>
            
            <?php if (!empty($relatedResearch)): ?>
                <div class="research-grid-related">
                    <h3>Research Activities Lainnya</h3>
                    <div class="related-research-grid">
                        <?php foreach ($relatedResearch as $related): ?>
                            <div class="research-card-modern">
                                <div class="research-card-image">
                                    <?php if (!empty($related['image'])): ?>
                                        <img src="<?= htmlspecialchars($related['image']) ?>" 
                                             alt="<?= htmlspecialchars($related['title']) ?>">
                                    <?php else: ?>
                                        <div class="research-placeholder">
                                            <i class="fas fa-flask"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="research-overlay">
                                        <span class="research-tag">Research</span>
                                    </div>
                                </div>
                                <div class="research-card-body">
                                    <div class="research-meta">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?= date('M d, Y', strtotime($related['created_at'] ?? 'now')) ?></span>
                                    </div>
                                    <h4 class="research-card-title"><?= htmlspecialchars($related['title']) ?></h4>
                                    <p class="research-card-excerpt">
                                        <?= htmlspecialchars(substr($related['description'], 0, 120)) ?>...
                                    </p>
                                    <a href="?page=research-detail&id=<?= $related['id'] ?>" class="research-read-more">
                                        <span>Read More</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>

</html>
