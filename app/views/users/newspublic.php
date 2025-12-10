<?php
$lang = $_SESSION['lang'] ?? 'en';

$newsTrans = array(
    'en' => array(
        'page_title' => 'News',
        'title' => 'News & Updates',
        'subtitle' => 'Stay updated with the latest developments from Learning Engineering Technology Research Group, including achievements, research, and recent activities.',
        'featured' => 'Featured News',
        'read_more' => 'Read More',
        'min_read' => 'min read',
        'no_news_title' => 'No News Yet',
        'no_news_desc' => 'No news available at the moment. Please check back later.'
    ),
    'id' => array(
        'page_title' => 'Berita',
        'title' => 'Berita & Pembaruan',
        'subtitle' => 'Ikuti perkembangan terbaru dari Learning Engineering Technology Research Group, termasuk pencapaian, penelitian, dan kegiatan terkini.',
        'featured' => 'Berita Utama',
        'read_more' => 'Baca Selengkapnya',
        'min_read' => 'menit baca',
        'no_news_title' => 'Belum Ada Berita',
        'no_news_desc' => 'Saat ini belum ada berita yang tersedia. Silakan kembali lagi nanti.'
    )
);
$nt = $newsTrans[$lang];

// --- PHP LOGIC ---
require_once __DIR__ . '/../../model/newsModel.php'; 
require_once __DIR__ . '/../../../config/database.php';

$database = new Database();
$pdo = $database->connect();

try {
    $newsModel = new NewsModel($pdo);
    $allNews = $newsModel->getAll();
} catch (Exception $e) {
    error_log("News Error: " . $e->getMessage());
    $allNews = [];
}

// Pisahkan berita
$mainNews = [];
$otherNews = [];

if (!empty($allNews)) {
    $mainNews = $allNews[0]; // Berita Utama
    $otherNews = array_slice($allNews, 1); // Berita List
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nt['page_title']; ?> - Learning Engineering Technology</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="page page-news">

    <?php include 'header.php'; ?>
    
    <main class="page-wrapper">
        <div class="news-page">
            
            <div class="news-page-header">
                <h1 class="news-page-title"><?php echo $nt['title']; ?></h1>
                <p class="news-page-subtitle">
                    <?php echo $nt['subtitle']; ?>
                </p>
            </div>
            
            <?php if (!empty($mainNews)): ?>
                <div class="featured-news">
                    <div class="featured-news-content">
                        <div class="featured-news-image">
                            <img src="<?php echo htmlspecialchars($mainNews['thumbnail'] ?? 'assets/img/placeholder.jpg'); ?>" alt="Featured News">
                        </div>
                        <div class="featured-news-text">
                            <div class="featured-badge"><?php echo $nt['featured']; ?></div>
                            <h2 class="featured-title"><?php echo htmlspecialchars($mainNews['title'] ?? 'No Title'); ?></h2>
                            <div class="featured-meta">
                                <span><i class="fas fa-calendar-alt"></i> <?php echo date('F d, Y', strtotime($mainNews['created_at'])); ?></span>
                                <span><i class="fas fa-clock"></i> <?= ceil(str_word_count($mainNews['content']) / 200) ?> <?php echo $nt['min_read']; ?></span>
                            </div>
                            <p class="featured-excerpt">
                                <?php echo htmlspecialchars(substr(strip_tags($mainNews['content'] ?? ''), 0, 200)); ?>...
                            </p>
                            <a href="?page=news-detail&id=<?= $mainNews['id'] ?>" class="read-more-btn">
                                <span><?php echo $nt['read_more']; ?></span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="news-grid">
                <div class="news-grid-container">
                    <?php if (!empty($otherNews)): ?>
                        <?php foreach ($otherNews as $news): ?>
                            <article class="news-card">
                                <div class="news-card-image">
                                    <img src="<?php echo htmlspecialchars($news['thumbnail'] ?? 'assets/img/placeholder.jpg'); ?>" alt="News">
                                </div>
                                <div class="news-card-body">
                                    <div class="news-card-meta">
                                        <span><i class="fas fa-calendar-alt"></i> <?php echo date('M d, Y', strtotime($news['created_at'])); ?></span>
                                        <span><i class="fas fa-eye"></i> News</span>
                                    </div>
                                    <h3 class="news-card-title"><?php echo htmlspecialchars($news['title'] ?? 'No Title'); ?></h3>
                                    <p class="news-card-excerpt">
                                        <?php echo htmlspecialchars(substr(strip_tags($news['content'] ?? ''), 0, 150)); ?>...
                                    </p>
                                    <a href="?page=news-detail&id=<?= $news['id'] ?>" class="news-card-link">
                                        <span><?php echo $nt['read_more']; ?></span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php elseif (empty($mainNews)): ?>
                        <div class="no-news">
                            <i class="fas fa-newspaper"></i>
                            <h3><?php echo $nt['no_news_title']; ?></h3>
                            <p><?php echo $nt['no_news_desc']; ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>