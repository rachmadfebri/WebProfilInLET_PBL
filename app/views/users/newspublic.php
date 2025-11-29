<?php
// Initialize database connection and news model
try {
    // Gunakan $pdo dari index.php (sudah tersedia sebagai global)
    require_once __DIR__ . '/../../model/newsModel.php';
    $newsModel = new NewsModel($pdo);
    $allNews = $newsModel->getAll();
} catch (Exception $e) {
    error_log("News Error: " . $e->getMessage());
    $allNews = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News - Engineering Technology</title>
    
    <link rel="stylesheet" href="assets/css/style.css"> 
    <link rel="stylesheet" href="assets/css/news-page.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <?php include 'header.php'; ?> 
    
    <section class="news-section">
        
        <h1 class="news-title gradient-text">News</h1>
        
        <div class="news-grid-container">
            
            <div class="news-column-left">
                
                <?php if (!empty($allNews)): ?>
                    <!-- Main Article (Berita Pertama) -->
                    <div class="main-article-block">
                        <div class="main-article-image-placeholder">
                            <?php if (!empty($allNews[0]['thumbnail'])): ?>
                                <img src="<?php echo htmlspecialchars($allNews[0]['thumbnail']); ?>" alt="<?php echo htmlspecialchars($allNews[0]['title'] ?? 'Main Article'); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php endif; ?>
                        </div>
                        <div style="padding: 15px;">
                            <h3><?php echo htmlspecialchars($allNews[0]['title'] ?? ''); ?></h3>
                            <p><?php echo htmlspecialchars(substr($allNews[0]['content'] ?? '', 0, 150)) . '...'; ?></p>
                        </div>
                    </div>
                    
                    <!-- Small Article List (Berita 2-6) -->
                    <div class="small-article-list">
                        <?php
                        $smallArticles = array_slice($allNews, 1, 5);
                        foreach ($smallArticles as $news):
                        ?>
                            <div class="small-article-item">
                                <?php if (!empty($news['thumbnail'])): ?>
                                    <img src="<?php echo htmlspecialchars($news['thumbnail']); ?>" alt="<?php echo htmlspecialchars($news['title'] ?? 'Article'); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php endif; ?>
                                <div style="padding: 10px;">
                                    <h4><?php echo htmlspecialchars($news['title'] ?? ''); ?></h4>
                                    <small><?php echo htmlspecialchars(substr($news['content'] ?? '', 0, 80)) . '...'; ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 40px; color: #999;">
                        <p>Belum ada berita.</p>
                    </div>
                <?php endif; ?>
                
            </div>
            
            <div class="news-column-right">
                <div class="sidebar-detail-block">
                    <?php if (!empty($allNews)): ?>
                        <h3><?php echo htmlspecialchars($allNews[0]['title'] ?? ''); ?></h3>
                        <p><small><?php echo htmlspecialchars($allNews[0]['created_at'] ?? ''); ?></small></p>
                        <p><?php echo nl2br(htmlspecialchars($allNews[0]['content'] ?? '')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    </section>

</body>
</html>