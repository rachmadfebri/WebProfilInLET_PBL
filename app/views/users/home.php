<?php
require_once __DIR__ . '/../../../config/connection.php'; 

$totalViewers = 0; 

try {
    $ip_visitor = $_SERVER['REMOTE_ADDR'];
    $date_today = date('Y-m-d');

    $stmtCheck = $pdo->prepare("SELECT id FROM visitors WHERE ip_address = ? AND access_date = ?");
    $stmtCheck->execute([$ip_visitor, $date_today]);

    if ($stmtCheck->rowCount() == 0) {
        $stmtInsert = $pdo->prepare("INSERT INTO visitors (ip_address, access_date) VALUES (?, ?)");
        $stmtInsert->execute([$ip_visitor, $date_today]);
    }

    $stmtCount = $pdo->query("SELECT COUNT(*) FROM visitors");
    $totalViewers = $stmtCount->fetchColumn();

} catch (Exception $e) {
    $totalViewers = 0;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Engineering Technology</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="page-home">

    <?php include 'header.php'; ?>

    <section class="hero">
        <div class="hero-content">
            <h1>
                Learning Engineering <br>
                <span class="gradient-text">Technology Research Group</span>
            </h1>
            <p>
                Find amazing Learning application tailored for you. Handy connects you with amazing Learning Engineering professionals.
            </p>

            <div class="hero-buttons">
                <a href="#" class="btn-hero">
                    <span class="placeholder-text"></span>
                    <div class="circle-icon">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </a>
                <a href="#" class="btn-hero">
                    <span class="placeholder-text"></span>
                    <div class="circle-icon">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="stats-container">

            <div class="stat-item">
                <img src="gambar_viewers.png" alt="Viewers" class="stat-img">
                <h3 class="stat-text gradient-text"><?php echo $totalViewers; ?> VIEWERS</h3>
            </div>

            <div class="stat-row row-right">
                <div class="stat-item">
                    <h3 class="stat-text gradient-text">50 related articles</h3>
                    <img src="gambar_articles.png" alt="Articles" class="stat-img">
                </div>
            </div>

            <div class="stat-row row-left">
                <div class="stat-item">
                    <img src="gambar_prototypes.png" alt="Prototypes" class="stat-img">
                    <h3 class="stat-text gradient-text">5 prototypes</h3>
                </div>
            </div>

        </div>
    </section>

    <?php
    // Ambil produk dari database untuk ditampilkan di portfolio-section
    try {
        require_once __DIR__ . '/../../model/productsModel.php';
        $productsModel = new ProductsModel($pdo);
        $products = $productsModel->getAll();
    } catch (Exception $e) {
        error_log("Products Error: " . $e->getMessage());
        $products = [];
    }
    ?>

    <section class="portfolio-section">
        <div class="portfolio-container">
            <?php if (!empty($products)): ?>
                <?php foreach (array_slice($products, 0, 2) as $index => $product): ?>
                    <div class="portfolio-card">
                        <?php if (!empty($product['url'])): ?>
                            <a href="<?php echo htmlspecialchars($product['url']); ?>"
                               class="card-button-decorator <?php echo $index === 0 ? 'button-left' : 'button-right'; ?>"
                               target="_blank" rel="noopener noreferrer">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>

                        <div class="card-image-wrapper">
                            <?php if (!empty($product['thumbnail'])): ?>
                                <img src="<?php echo htmlspecialchars($product['thumbnail']); ?>"
                                     alt="<?php echo htmlspecialchars($product['title']); ?>">
                            <?php endif; ?>
                        </div>
                        <h3 class="card-title">
                            <?php echo htmlspecialchars($product['title']); ?>
                        </h3>
                        <p class="card-description">
                            <?php echo htmlspecialchars($product['description']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center; width:100%;">Belum ada produk yang ditambahkan.</p>
            <?php endif; ?>
        </div>
    </section>

    <section id="news" class="news-section">

        <?php
        try {
            require_once __DIR__ . '/../../model/newsModel.php';
            $newsModel = new NewsModel($pdo);
            $allNews = $newsModel->getAll();
            
            $mainNews = !empty($allNews) ? $allNews[0] : null;
            $otherNews = !empty($allNews) ? array_slice($allNews, 1, 8) : [];
        } catch (Exception $e) {
            error_log("News Error: " . $e->getMessage());
            $mainNews = null;
            $otherNews = [];
        }
        ?>

            <h2 class="news-heading gradient-text">News</h2>

            <div class="news-container">
                <!-- Main News Card -->
                <?php if ($mainNews): ?>
                    <div class="news-card-border">
                        <div class="news-card">
                            <?php if (!empty($mainNews['thumbnail'])): ?>
                                <img src="<?php echo htmlspecialchars($mainNews['thumbnail']); ?>" alt="<?php echo htmlspecialchars($mainNews['title']); ?>" class="news-card-img">
                            <?php endif; ?>
                            <div class="news-card-content">
                                <h3 class="news-card-title"><?php echo htmlspecialchars($mainNews['title']); ?></h3>
                                <p class="news-card-description">
                                    <?php echo htmlspecialchars(substr($mainNews['content'], 0, 150)) . '...'; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Second News Card with Toggle Button -->
                <?php if (count($otherNews) > 0): ?>
                    <div class="news-card-wrapper">
                        <div class="news-card-border">
                            <div class="news-card">
                                <?php if (!empty($otherNews[0]['thumbnail'])): ?>
                                    <img src="<?php echo htmlspecialchars($otherNews[0]['thumbnail']); ?>" alt="<?php echo htmlspecialchars($otherNews[0]['title']); ?>" class="news-card-img">
                                <?php endif; ?>
                                <div class="news-card-content">
                                    <h3 class="news-card-title"><?php echo htmlspecialchars($otherNews[0]['title']); ?></h3>
                                    <p class="news-card-description">
                                        <?php echo htmlspecialchars(substr($otherNews[0]['content'], 0, 150)) . '...'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <?php if (count($otherNews) > 1): ?>
                            <a href="javascript:void(0)" class="news-button" id="toggleNewsBtn">
                                <i class="fa-solid fa-chevron-down"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Third News Card -->
                <?php if (count($otherNews) > 1): ?>
                    <div class="news-card-border">
                        <div class="news-card">
                            <?php if (!empty($otherNews[1]['thumbnail'])): ?>
                                <img src="<?php echo htmlspecialchars($otherNews[1]['thumbnail']); ?>" alt="<?php echo htmlspecialchars($otherNews[1]['title']); ?>" class="news-card-img">
                            <?php endif; ?>
                            <div class="news-card-content">
                                <h3 class="news-card-title"><?php echo htmlspecialchars($otherNews[1]['title']); ?></h3>
                                <p class="news-card-description">
                                    <?php echo htmlspecialchars(substr($otherNews[1]['content'], 0, 150)) . '...'; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Additional News Grid (Hidden by default) -->
            <?php if (count($otherNews) > 2): ?>
                <div id="moreNewsSection" class="more-news-wrapper" style="display: none;">

                    <div class="news-container additional-news-grid">
                        <?php 
                        // Ambil berita ke-3 sampai ke-8
                        for ($i = 2; $i < count($otherNews) && $i < 8; $i++):
                            $news = $otherNews[$i];
                        ?>
                            <div class="news-card-border">
                                <div class="news-card">
                                    <?php if (!empty($news['thumbnail'])): ?>
                                        <img src="<?php echo htmlspecialchars($news['thumbnail']); ?>" alt="<?php echo htmlspecialchars($news['title']); ?>" class="news-card-img">
                                    <?php endif; ?>
                                    <div class="news-card-content">
                                        <h3 class="news-card-title"><?php echo htmlspecialchars($news['title']); ?></h3>
                                        <p class="news-card-description">
                                            <?php echo htmlspecialchars(substr($news['content'], 0, 80)) . '...'; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <div class="grid-nav-buttons">

                        <a href="javascript:void(0)" class="circle-btn-bottom" id="btnCollapse">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>

                        <a href="javascript:void(0)" class="circle-btn-bottom">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>

                    </div>

                </div>
            <?php endif; ?>

    </section>

    <section class="gallery-section">
            <div class="gallery-container">
                <div class="gallery-left">
                    <img src="assets/img/visual jurney.png" alt="Gallery Highlight" class="gallery-hero-img">
                    <p class="gallery-description">
                        Di balik setiap potret, ada kisah dan perasaan yang hidup. Inilah bagian kecil dari cerita besar kita — tempat kenangan tumbuh dan tak pernah hilang.
                    </p>
                    <a href="index.php?page=gallerypublic" class="btn-view-more">
                        <span>View More</span>
                    </a>
                </div>

                <div class="gallery-right">
                    <?php
                    // Ambil 3 gambar pertama dari database
                    try {
                        require_once __DIR__ . '/../../model/galleryModel.php';
                        $galleryModel = new GalleryModel($pdo);
                        $galleries = $galleryModel->getAll();
                        
                        // Ambil hanya 3 gambar pertama
                        $firstThree = array_slice($galleries, 0, 3);
                        
                        $capsuleClasses = ['mt-down', 'mt-up', 'mt-down'];
                        
                        foreach ($firstThree as $index => $gallery):
                    ?>
                        <div class="gallery-capsule <?php echo $capsuleClasses[$index] ?? 'mt-down'; ?>">
                            <img src="<?php echo htmlspecialchars($gallery['image']); ?>" alt="Gallery <?php echo $index + 1; ?>">
                        </div>
                    <?php
                        endforeach;
                    } catch (Exception $e) {
                        error_log("Gallery Error: " . $e->getMessage());
                    }
                    ?>
                </div>
            </div>
        </section>

    <?php
    // Ambil data aktivitas riset dari database
    try {
        require_once __DIR__ . '/../../model/researchModel.php';
        $researchModel = new ResearchModel($pdo);
        $researchActivities = $researchModel->getAll();
    } catch (Exception $e) {
        error_log("Research Activities Error: " . $e->getMessage());
        $researchActivities = [];
    }
    ?>

    <section class="activity-section">
        <h2 class="section-title gradient-text">Research Activities</h2>
        <div class="activity-container">
            <?php if (!empty($researchActivities)): ?>
                <?php $mainActivity = $researchActivities[0]; ?>

                <a href="#" class="arrow-button left-arrow">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>

                <div class="video-card-wrapper">
                    <div class="video-card">
                        <?php if (!empty($mainActivity['image'])): ?>
                            <img src="<?php echo htmlspecialchars($mainActivity['image']); ?>"
                                 alt="<?php echo htmlspecialchars($mainActivity['title']); ?>">
                        <?php endif; ?>
                    </div>
                </div>

                <a href="#" class="arrow-button right-arrow">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            <?php else: ?>
                <p>Belum ada data aktivitas riset.</p>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('toggleNewsBtn');
            const moreNewsSection = document.getElementById('moreNewsSection');
            const btnCollapse = document.getElementById('btnCollapse');

            if (toggleBtn && moreNewsSection && btnCollapse) {
                toggleBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    moreNewsSection.style.display = 'block';
                    toggleBtn.style.display = 'none';
                });

                btnCollapse.addEventListener('click', (e) => {
                    e.preventDefault();
                    moreNewsSection.style.display = 'none';
                    toggleBtn.style.display = 'flex';
                    const newsSection = document.querySelector('.news-section');
                    if (newsSection) {
                        newsSection.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            }

            const navPill = document.querySelector('.nav-pill');
            const indicator = document.querySelector('.nav-indicator');
            const navItems = document.querySelectorAll('.nav-item');

            if (navPill && indicator && navItems.length) {
                const handleIndicator = (el) => {
                    navItems.forEach((item) => {
                        item.classList.remove('active');
                        item.style.color = '';
                    });

                    const parentRect = navPill.getBoundingClientRect();
                    const elementRect = el.getBoundingClientRect();
                    indicator.style.width = `${elementRect.width}px`;
                    indicator.style.left = `${elementRect.left - parentRect.left}px`;
                    indicator.style.top = `${elementRect.top - parentRect.top}px`;
                    indicator.style.opacity = '1';

                    el.classList.add('active');
                    el.style.color = 'white';
                };

                navItems.forEach((item) => {
                    item.addEventListener('mouseenter', () => handleIndicator(item));
                    item.addEventListener('focus', () => handleIndicator(item));
                });

                const activeItem = document.querySelector('.nav-item.active') || navItems[0];
                if (activeItem) {
                    handleIndicator(activeItem);
                }
            }
        });
    </script>

</body>

</html>