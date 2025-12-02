<?php
// News detail page
require_once __DIR__ . '/../../model/newsModel.php';
require_once __DIR__ . '/../../../config/database.php';

$database = new Database();
$pdo = $database->connect();

$newsId = $_GET['id'] ?? null;
$news = null;

if ($newsId) {
    try {
        $newsModel = new NewsModel($pdo);
        $news = $newsModel->getById($newsId);
    } catch (Exception $e) {
        error_log("News Detail Error: " . $e->getMessage());
    }
}

if (!$news) {
    header('Location: ?page=home');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($news['title']) ?> • News Detail</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="page page-news-detail news-detail-page">

    <?php include 'header.php'; ?>

    <main class="page-wrapper">
        <div class="news-detail">
            
            <a href="?page=home#news" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Kembali ke News
            </a>
            
            <div class="news-hero">
                <?php if (!empty($news['thumbnail'])): ?>
                    <img src="<?= htmlspecialchars($news['thumbnail']) ?>" 
                         alt="<?= htmlspecialchars($news['title']) ?>" 
                         class="news-hero-image">
                <?php endif; ?>
                
                <h1 class="news-title"><?= htmlspecialchars($news['title']) ?></h1>
                
                <div class="news-meta">
                    <span>
                        <i class="fas fa-calendar-alt"></i>
                        <?= date('d F Y', strtotime($news['created_at'])) ?>
                    </span>
                    <span>
                        <i class="fas fa-newspaper"></i>
                        Berita Terbaru
                    </span>
                    <span>
                        <i class="fas fa-clock"></i>
                        <?= ceil(str_word_count($news['content']) / 200) ?> menit baca
                    </span>
                </div>
            </div>
            
            <div class="news-content">
                <?= nl2br(htmlspecialchars($news['content'])) ?>
            </div>
            
            <?php
            // Get related news
            try {
                $newsModel = new NewsModel($pdo);
                $relatedNews = array_filter(
                    $newsModel->getAll(), 
                    function($item) use ($news) {
                        return $item['id'] != $news['id'];
                    }
                );
                $relatedNews = array_slice($relatedNews, 0, 3);
            } catch (Exception $e) {
                $relatedNews = [];
            }
            ?>
            
            <?php if (!empty($relatedNews)): ?>
                <div class="related-news">
                    <h3>Berita Lainnya</h3>
                    <div class="related-grid">
                        <?php foreach ($relatedNews as $related): ?>
                            <a href="?page=news-detail&id=<?= $related['id'] ?>" class="related-card">
                                <?php if (!empty($related['thumbnail'])): ?>
                                    <img src="<?= htmlspecialchars($related['thumbnail']) ?>" 
                                         alt="<?= htmlspecialchars($related['title']) ?>">
                                <?php endif; ?>
                                <div class="related-card-content">
                                    <h4><?= htmlspecialchars($related['title']) ?></h4>
                                    <p><?= htmlspecialchars(substr(strip_tags($related['content']), 0, 100)) ?>...</p>
                                    <div class="related-card-meta">
                                        <?= date('d M Y', strtotime($related['created_at'])) ?>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>

</html>
