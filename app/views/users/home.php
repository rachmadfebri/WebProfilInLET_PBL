<?php
// $pdo is already available from index.php

// Language handling
$lang = $_SESSION['lang'] ?? 'en';

// Translations for home page
$homeTrans = array(
    'en' => array(
        'hero_title' => 'Learning Engineering',
        'hero_subtitle' => 'Technology Research Group',
        'hero_desc' => 'Find amazing Learning application tailored for you. Handy connects you with amazing Learning Engineering professionals.',
        'our_research' => 'Our Research',
        'learn_more' => 'Learn More',
        'viewers' => 'VIEWERS',
        'products_count' => 'PRODUCTS',
        'team_members' => 'TEAM MEMBERS',
        'our_partnerships' => 'Our Partnerships',
        'partnerships_desc' => 'Collaborating with leading institutions and organizations to advance learning technology',
        'academic_partners' => 'Academic Partners',
        'academic_desc' => 'Leading universities and research institutions',
        'industry_partners' => 'Industry Partners',
        'industry_desc' => 'Technology companies and organizations',
        'strategic_partners' => 'Strategic Partners',
        'strategic_desc' => 'Long-term strategic collaborations',
        'our_products' => 'Our Products',
        'products_desc' => 'Innovative learning solutions designed to enhance educational experiences',
        'visit_product' => 'Visit Product',
        'click_to_visit' => 'Click to visit product',
        'no_products' => 'No products added yet.',
        'meet_our_team' => 'Meet Our Team',
        'team_desc' => 'Dedicated professionals driving innovation in learning technology research and development',
        'meet_full_team' => 'Meet Full Team',
        'news_updates' => 'News & Updates',
        'read_more' => 'Read More',
        'show_more_news' => 'Show More News',
        'show_less' => 'Show Less',
        'view_all_news' => 'View All News',
        'no_news' => 'No news available yet.',
        'gallery_desc' => 'Behind every portrait, there is a story and feelings that come alive. This is a small part of our big story - where memories grow and never fade.',
        'view_more' => 'View More',
        'research_activities' => 'Research Activities',
        'view_details' => 'View Details',
        'no_research' => 'No research activity data yet.'
    ),
    'id' => array(
        'hero_title' => 'Learning Engineering',
        'hero_subtitle' => 'Kelompok Riset Teknologi',
        'hero_desc' => 'Temukan aplikasi pembelajaran luar biasa yang disesuaikan untuk Anda. Handy menghubungkan Anda dengan profesional Learning Engineering yang luar biasa.',
        'our_research' => 'Riset Kami',
        'learn_more' => 'Pelajari Lebih',
        'viewers' => 'PENGUNJUNG',
        'products_count' => 'PRODUK',
        'team_members' => 'ANGGOTA TIM',
        'our_partnerships' => 'Kemitraan Kami',
        'partnerships_desc' => 'Berkolaborasi dengan institusi dan organisasi terkemuka untuk memajukan teknologi pembelajaran',
        'academic_partners' => 'Mitra Akademik',
        'academic_desc' => 'Universitas dan lembaga penelitian terkemuka',
        'industry_partners' => 'Mitra Industri',
        'industry_desc' => 'Perusahaan dan organisasi teknologi',
        'strategic_partners' => 'Mitra Strategis',
        'strategic_desc' => 'Kolaborasi strategis jangka panjang',
        'our_products' => 'Produk Kami',
        'products_desc' => 'Solusi pembelajaran inovatif yang dirancang untuk meningkatkan pengalaman pendidikan',
        'visit_product' => 'Kunjungi Produk',
        'click_to_visit' => 'Klik untuk mengunjungi produk',
        'no_products' => 'Belum ada produk yang ditambahkan.',
        'meet_our_team' => 'Temui Tim Kami',
        'team_desc' => 'Profesional berdedikasi yang mendorong inovasi dalam penelitian dan pengembangan teknologi pembelajaran',
        'meet_full_team' => 'Lihat Semua Tim',
        'news_updates' => 'Berita & Pembaruan',
        'read_more' => 'Baca Selengkapnya',
        'show_more_news' => 'Tampilkan Lebih Banyak',
        'show_less' => 'Tampilkan Lebih Sedikit',
        'view_all_news' => 'Lihat Semua Berita',
        'no_news' => 'Belum ada berita terbaru.',
        'gallery_desc' => 'Di balik setiap potret, ada kisah dan perasaan yang hidup. Inilah bagian kecil dari cerita besar kita - tempat kenangan tumbuh dan tak pernah hilang.',
        'view_more' => 'Lihat Selengkapnya',
        'research_activities' => 'Aktivitas Riset',
        'view_details' => 'Lihat Detail',
        'no_research' => 'Belum ada data aktivitas riset.'
    )
);
$ht = $homeTrans[$lang];

$totalViewers = 0;
$totalProducts = 0;
$totalTeamMembers = 0;

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

// Get total products - separate try-catch
try {
    $stmtProducts = $pdo->query("SELECT COUNT(*) FROM products");
    if ($stmtProducts) {
        $totalProducts = (int)$stmtProducts->fetchColumn();
    }
} catch (Exception $e) {
    $totalProducts = 0;
}

// Get total team members - separate try-catch
try {
    $stmtTeam = $pdo->query("SELECT COUNT(*) FROM team_members");
    if ($stmtTeam) {
        $totalTeamMembers = (int)$stmtTeam->fetchColumn();
    }
} catch (Exception $e) {
    $totalTeamMembers = 0;
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
                <?php echo $ht['hero_title']; ?> <br>
                <span class="gradient-text"><?php echo $ht['hero_subtitle']; ?></span>
            </h1>
            <p>
                <?php echo $ht['hero_desc']; ?>
            </p>

            <div class="hero-buttons">
                <a href="#research" class="btn-hero primary">
                    <span class="btn-text"><?php echo $ht['our_research']; ?></span>
                    <div class="circle-icon">
                        <i class="fa-solid fa-microscope"></i>
                    </div>
                </a>
                <a href="?page=about" class="btn-hero secondary">
                    <span class="btn-text"><?php echo $ht['learn_more']; ?></span>
                    <div class="circle-icon">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="stats-container">

            <div class="stat-item">
                <img src="assets/img/viewer.png" alt="Viewers" class="stat-img">
                <h3 class="stat-text gradient-text"><?php echo $totalViewers; ?> <?php echo $ht['viewers']; ?></h3>
            </div>

            <div class="stat-row row-right">
                <div class="stat-item">
                    <h3 class="stat-text gradient-text"><?php echo $totalProducts; ?> <?php echo $ht['products_count']; ?></h3>
                    <img src="assets/img/viewer2.png" alt="Products" class="stat-img">
                </div>
            </div>

            <div class="stat-row row-left">
                <div class="stat-item">
                    <img src="assets/img/viewer3.png" alt="Team" class="stat-img">
                    <h3 class="stat-text gradient-text"><?php echo $totalTeamMembers; ?> <?php echo $ht['team_members']; ?></h3>
                </div>
            </div>

        </div>
    </section>

    <?php
    // Ambil data collaboration untuk ditampilkan di collaboration-section
    try {
        require_once __DIR__ . '/../../model/collaborationModel.php';
        $collaborationModel = new CollaborationModel($pdo);
        $collaborations = $collaborationModel->getAll();
    } catch (Exception $e) {
        error_log("Collaboration Error: " . $e->getMessage());
        $collaborations = [];
    }
    ?>

    <section class="collaboration-section" id="partners">
        <div class="collaboration-container">
            <div class="collaboration-header">
                <h2 class="section-title gradient-text"><?php echo $ht['our_partnerships']; ?></h2>
                <p class="section-subtitle"><?php echo $ht['partnerships_desc']; ?></p>
            </div>
            
            <?php if (!empty($collaborations)): ?>
                <div class="collaboration-grid">
                    <?php foreach (array_slice($collaborations, 0, 6) as $collaboration): ?>
                        <div class="collaboration-card">
                            <?php if (!empty($collaboration['logo'])): ?>
                                <div class="collaboration-logo">
                                    <img src="<?php echo htmlspecialchars($collaboration['logo']); ?>" 
                                         alt="<?php echo htmlspecialchars($collaboration['name'] ?? 'Partner'); ?>">
                                </div>
                            <?php endif; ?>
                            <div class="collaboration-info">
                                <h4 class="collaboration-name"><?php echo htmlspecialchars($collaboration['name'] ?? 'Partner Name'); ?></h4>
                                <?php if (!empty($collaboration['description'])): ?>
                                    <p class="collaboration-desc"><?php echo htmlspecialchars(substr($collaboration['description'], 0, 100)); ?>...</p>
                                <?php endif; ?>
                                <span class="collaboration-type"><?php echo htmlspecialchars($collaboration['collaboration_type'] ?? 'Partnership'); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Placeholder partnerships jika tidak ada data -->
                <div class="collaboration-grid">
                    <div class="collaboration-card">
                        <div class="collaboration-logo">
                            <div class="placeholder-logo">
                                <i class="fas fa-university"></i>
                            </div>
                        </div>
                        <div class="collaboration-info">
                            <h4 class="collaboration-name"><?php echo $ht['academic_partners']; ?></h4>
                            <p class="collaboration-desc"><?php echo $ht['academic_desc']; ?></p>
                            <span class="collaboration-type">Academic</span>
                        </div>
                    </div>
                    <div class="collaboration-card">
                        <div class="collaboration-logo">
                            <div class="placeholder-logo">
                                <i class="fas fa-building"></i>
                            </div>
                        </div>
                        <div class="collaboration-info">
                            <h4 class="collaboration-name"><?php echo $ht['industry_partners']; ?></h4>
                            <p class="collaboration-desc"><?php echo $ht['industry_desc']; ?></p>
                            <span class="collaboration-type">Industry</span>
                        </div>
                    </div>
                    <div class="collaboration-card">
                        <div class="collaboration-logo">
                            <div class="placeholder-logo">
                                <i class="fas fa-handshake"></i>
                            </div>
                        </div>
                        <div class="collaboration-info">
                            <h4 class="collaboration-name"><?php echo $ht['strategic_partners']; ?></h4>
                            <p class="collaboration-desc"><?php echo $ht['strategic_desc']; ?></p>
                            <span class="collaboration-type">Strategic</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php
    // Ambil produk dari database untuk ditampilkan di portfolio-section
    try {
        require_once __DIR__ . '/../../model/productsModel.php';
        $productsModel = new ProductsModel($pdo);
        $products = $productsModel->getAll();
        // DEBUG: Tampilkan jumlah produk
        $productCount = count($products);
    } catch (Exception $e) {
        error_log("Products Error: " . $e->getMessage());
        $products = [];
        $productCount = 0;
    }
    ?>

    <section id="products" class="portfolio-section">
        <div class="products-header">
            <h2 class="section-title gradient-text"><?php echo $ht['our_products']; ?></h2>
            <p class="section-subtitle"><?php echo $ht['products_desc']; ?></p>
            
            <?php if (!empty($products) && count($products) > 3): ?>
                <div class="products-navigation">
                    <button class="products-nav-btn" id="prevProducts">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="products-pagination" id="productsPagination"></div>
                    <button class="products-nav-btn" id="nextProducts">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="products-carousel-container">
            <div class="products-viewport">
                <div class="portfolio-container" id="productsContainer">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $index => $product): ?>
                        <?php 
                        // Fix URL - pastikan ada https:// atau http://
                        $productUrl = $product['url'] ?? '';
                        if (!empty($productUrl)) {
                            // Hapus karakter aneh dan perbaiki format URL
                            $productUrl = trim($productUrl);
                            // Jika tidak dimulai dengan http:// atau https://, tambahkan https://
                            if (!preg_match('/^https?:\/\//i', $productUrl)) {
                                $productUrl = 'https://' . ltrim($productUrl, '/');
                            }
                        }
                        ?>
                        <div class="portfolio-card" 
                             <?php if (!empty($productUrl)): ?>
                                onclick="window.open('<?php echo htmlspecialchars($productUrl); ?>', '_blank'); event.stopPropagation();"
                                style="cursor: pointer;"
                             <?php endif; ?>>
                            
                            <div class="card-overlay">
                                <div class="card-overlay-content">
                                    <i class="fas fa-external-link-alt"></i>
                                    <span><?php echo $ht['visit_product']; ?></span>
                                </div>
                            </div>

                            <div class="card-image-wrapper">
                                <?php if (!empty($product['thumbnail'])): ?>
                                    <img src="<?php echo htmlspecialchars($product['thumbnail']); ?>"
                                         alt="<?php echo htmlspecialchars($product['title']); ?>">
                                <?php else: ?>
                                    <div class="card-placeholder">
                                        <i class="fas fa-laptop-code"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">
                                    <?php echo htmlspecialchars($product['title']); ?>
                                </h3>
                                <p class="card-description">
                                    <?php echo htmlspecialchars($product['description']); ?>
                                </p>
                                <?php if (!empty($product['url'])): ?>
                                    <div class="card-action">
                                        <span class="action-text"><?php echo $ht['click_to_visit']; ?></span>
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-products">
                        <i class="fas fa-laptop-code"></i>
                        <p><?php echo $ht['no_products']; ?></p>
                    </div>
                <?php endif; ?>
            </div>
            </div>
        </div>
    </section>

    <?php
    // Ambil data team untuk preview
    try {
        require_once __DIR__ . '/../../model/teamMembersModel.php';
        $teamMembersModel = new TeamMembersModel($pdo);
        $teamMembers = $teamMembersModel->getAll();
        $featuredTeam = array_slice($teamMembers, 0, 6); // Show 6 team members instead of 4
    } catch (Exception $e) {
        error_log("Team Error: " . $e->getMessage());
        $featuredTeam = [];
    }
    ?>

    <section class="team-preview-section">
        <div class="team-preview-container">
            <div class="team-preview-header">
                <h2 class="section-title gradient-text"><?php echo $ht['meet_our_team']; ?></h2>
                <p class="section-subtitle"><?php echo $ht['team_desc']; ?></p>
            </div>
            
            <?php if (!empty($featuredTeam)): ?>
                <div class="team-preview-grid">
                    <?php foreach ($featuredTeam as $member): ?>
                        <div class="team-preview-card">
                            <div class="team-preview-avatar">
                                <?php if (!empty($member['photo'])): ?>
                                    <img src="<?php echo htmlspecialchars($member['photo']); ?>" 
                                         alt="<?php echo htmlspecialchars($member['name']); ?>">
                                <?php else: ?>
                                    <div class="team-avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="team-preview-info">
                                <h4 class="team-preview-name"><?php echo htmlspecialchars($member['name']); ?></h4>
                                <p class="team-preview-position"><?php echo htmlspecialchars($member['position']); ?></p>
                                <div class="team-preview-contact">
                                    <?php if (!empty($member['email'])): ?>
                                        <a href="mailto:<?php echo htmlspecialchars($member['email']); ?>" class="team-contact-btn" title="Email">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="mailto:example@email.com" class="team-contact-btn" title="Email">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($member['phone'])): ?>
                                        <a href="tel:<?php echo htmlspecialchars($member['phone']); ?>" class="team-contact-btn" title="Phone">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="tel:+1234567890" class="team-contact-btn" title="Phone">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($member['linkedin'])): ?>
                                        <a href="<?php echo htmlspecialchars($member['linkedin']); ?>" class="team-contact-btn" title="LinkedIn" target="_blank">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="https://linkedin.com" class="team-contact-btn" title="LinkedIn" target="_blank">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($member['website'])): ?>
                                        <a href="<?php echo htmlspecialchars($member['website']); ?>" class="team-contact-btn" title="Website" target="_blank">
                                            <i class="fas fa-globe"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="#" class="team-contact-btn" title="Website">
                                            <i class="fas fa-globe"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="team-preview-footer">
                    <a href="?page=teampublic" class="btn-view-team">
                        <span><?php echo $ht['meet_full_team']; ?></span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section id="news" class="news-section">

        <?php
        try {
            require_once __DIR__ . '/../../model/newsModel.php';
            $newsModel = new NewsModel($pdo);
            $allNews = $newsModel->getAll();
        } catch (Exception $e) {
            error_log("News Error: " . $e->getMessage());
            $allNews = [];
        }
        ?>

        <h2 class="news-heading gradient-text"><?php echo $ht['news_updates']; ?></h2>

        <div class="news-grid-container" id="newsGridContainer">
            <?php if (!empty($allNews)): ?>
                <!-- First 3 news items (always visible) -->
                <?php foreach (array_slice($allNews, 0, 3) as $index => $news): ?>
                    <div class="news-card-modern">
                        <div class="news-card-header">
                            <?php if (!empty($news['thumbnail'])): ?>
                                <div class="news-thumbnail">
                                    <img src="<?php echo htmlspecialchars($news['thumbnail']); ?>" alt="<?php echo htmlspecialchars($news['title']); ?>">
                                    <div class="news-overlay">
                                        <span class="news-tag">Berita: <?php echo htmlspecialchars($news['title']); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="news-card-body">
                            <div class="news-meta">
                                <i class="fas fa-calendar-alt"></i>
                                <span><?php echo date('F d, Y', strtotime($news['created_at'])); ?></span>
                            </div>
                            <h3 class="news-title"><?php echo htmlspecialchars($news['title']); ?></h3>
                            <p class="news-excerpt">
                                <?php echo htmlspecialchars(substr(strip_tags($news['content']), 0, 120)); ?>...
                            </p>
                            <a href="?page=news-detail&id=<?php echo $news['id']; ?>" class="news-read-more">
                                <span><?php echo $ht['read_more']; ?></span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <!-- Additional news items (hidden by default) -->
                <?php if (count($allNews) > 3): ?>
                    <div class="more-news-grid" id="moreNewsGrid" style="display: none;">
                        <?php foreach (array_slice($allNews, 3, 6) as $index => $news): ?>
                            <div class="news-card-modern">
                                <div class="news-card-header">
                                    <?php if (!empty($news['thumbnail'])): ?>
                                        <div class="news-thumbnail">
                                            <img src="<?php echo htmlspecialchars($news['thumbnail']); ?>" alt="<?php echo htmlspecialchars($news['title']); ?>">
                                            <div class="news-overlay">
                                                <span class="news-tag">Berita: <?php echo htmlspecialchars($news['title']); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="news-card-body">
                                    <div class="news-meta">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo date('F d, Y', strtotime($news['created_at'])); ?></span>
                                    </div>
                                    <h3 class="news-title"><?php echo htmlspecialchars($news['title']); ?></h3>
                                    <p class="news-excerpt">
                                        <?php echo htmlspecialchars(substr(strip_tags($news['content']), 0, 120)); ?>...
                                    </p>
                                    <a href="?page=news-detail&id=<?php echo $news['id']; ?>" class="news-read-more">
                                        <span>Read More</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="no-news">
                    <p><?php echo $ht['no_news']; ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="news-footer">
            <?php if (count($allNews) > 3): ?>
                <button id="expandNewsBtn" class="btn-expand-news" onclick="expandNews()">
                    <span><?php echo $ht['show_more_news']; ?></span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <button id="collapseNewsBtn" class="btn-collapse-news" onclick="collapseNews()" style="display: none;">
                    <span><?php echo $ht['show_less']; ?></span>
                    <i class="fas fa-chevron-up"></i>
                </button>
            <?php endif; ?>
            <a href="?page=newspublic" class="btn-view-all-news">
                <span><?php echo $ht['view_all_news']; ?></span>
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>

    </section>

    <section class="gallery-section">
            <div class="gallery-container">
                <div class="gallery-left">
                    <img src="assets/img/visual jurney.png" alt="Gallery Highlight" class="gallery-hero-img">
                    <p class="gallery-description">
                        <?php echo $ht['gallery_desc']; ?>
                    </p>
                    <a href="index.php?page=gallerypublic" class="btn-view-more">
                        <span><?php echo $ht['view_more']; ?></span>
                        <i class="fas fa-arrow-right"></i>
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
    // Ambil data team untuk preview
    try {
        require_once __DIR__ . '/../../model/teamMembersModel.php';
        $teamMembersModel = new TeamMembersModel($pdo);
        $teamMembers = $teamMembersModel->getAll();
        $featuredTeam = array_slice($teamMembers, 0, 4); // Show 4 team members
    } catch (Exception $e) {
        error_log("Team Error: " . $e->getMessage());
        $featuredTeam = [];
    }
    ?>

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

    <section class="activity-section" id="research">
        <div class="research-scroll-container">
            <div class="research-header">
                <h2 class="section-title gradient-text"><?php echo $ht['research_activities']; ?></h2>
                <div class="research-scroll-buttons">
                    <button class="research-scroll-btn" id="scrollLeft">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="research-scroll-btn" id="scrollRight">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            
            <?php if (!empty($researchActivities)): ?>
                <div class="research-grid-scroll" id="researchGrid">
                    <?php foreach ($researchActivities as $activity): ?>
                        <div class="research-card-new">
                            <div class="research-image-new">
                                <?php if (!empty($activity['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($activity['image']); ?>"
                                         alt="<?php echo htmlspecialchars($activity['title']); ?>">
                                <?php else: ?>
                                    <div class="placeholder-image"
                                         style="background: linear-gradient(135deg, #2d5bd4, #d53f8c); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                                        <i class="fas fa-flask"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="research-overlay-new">
                                    <a href="?page=research-detail&id=<?= $activity['id'] ?>">
                                        <i class="fas fa-eye"></i> <?php echo $ht['view_details']; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="research-content-new">
                                <span class="research-category-new"><?= htmlspecialchars($activity['research_category'] ?? 'Research') ?></span>
                                <h3 class="research-title-new"><?= htmlspecialchars($activity['title']) ?></h3>
                                <p class="research-desc-new"><?= htmlspecialchars(substr($activity['description'], 0, 120)) ?>...</p>
                                <div class="research-meta-new">
                                    <span class="research-date-new"><?= date('M Y', strtotime($activity['created_at'] ?? 'now')) ?></span>
                                    <span class="research-status-new <?= strtolower($activity['status'] ?? 'ongoing') ?>">
                                        <?= htmlspecialchars($activity['status'] ?? 'Ongoing') ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-research">
                    <i class="fas fa-flask"></i>
                    <p><?php echo $ht['no_research']; ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Products Carousel - VERSION v7
            const productsContainer = document.getElementById('productsContainer');
            const productsPrevBtn = document.getElementById('prevProducts');
            const productsNextBtn = document.getElementById('nextProducts');
            const paginationContainer = document.getElementById('productsPagination');
            
            if (productsContainer && productsPrevBtn && productsNextBtn) {
                const productCards = productsContainer.querySelectorAll('.portfolio-card');
                const totalCards = productCards.length;
                
                if (totalCards === 0) return;
                
                const CARD_WIDTH = 360;
                const GAP = 30;
                const CARDS_PER_VIEW = 3;
                const totalSlides = Math.ceil(totalCards / CARDS_PER_VIEW);
                let currentSlide = 0;
                let autoSlideInterval;
                
                // Create pagination dots
                if (paginationContainer && totalSlides > 1) {
                    paginationContainer.innerHTML = '';
                    for (let i = 0; i < totalSlides; i++) {
                        const dot = document.createElement('div');
                        dot.className = 'pagination-dot' + (i === 0 ? ' active' : '');
                        dot.addEventListener('click', () => {
                            goToSlide(i);
                            resetAutoSlide();
                        });
                        paginationContainer.appendChild(dot);
                    }
                }
                
                function updateCarousel() {
                    let cardsToSkip = currentSlide * CARDS_PER_VIEW;
                    const maxSkip = Math.max(0, totalCards - CARDS_PER_VIEW);
                    if (cardsToSkip > maxSkip) cardsToSkip = maxSkip;
                    
                    const moveDistance = cardsToSkip * (CARD_WIDTH + GAP);
                    productsContainer.style.transform = `translateX(-${moveDistance}px)`;
                    
                    const dots = paginationContainer?.querySelectorAll('.pagination-dot');
                    if (dots) {
                        dots.forEach((dot, index) => {
                            dot.classList.toggle('active', index === currentSlide);
                        });
                    }
                    
                    productsPrevBtn.style.opacity = currentSlide === 0 ? '0.5' : '1';
                    productsNextBtn.style.opacity = currentSlide >= totalSlides - 1 ? '0.5' : '1';
                }
                
                function goToSlide(slideIndex) {
                    currentSlide = Math.max(0, Math.min(slideIndex, totalSlides - 1));
                    updateCarousel();
                }
                
                function nextSlide() {
                    currentSlide = (currentSlide + 1) % totalSlides;
                    updateCarousel();
                }
                
                function prevSlide() {
                    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                    updateCarousel();
                }
                
                function startAutoSlide() {
                    autoSlideInterval = setInterval(nextSlide, 4000);
                }
                
                function resetAutoSlide() {
                    clearInterval(autoSlideInterval);
                    startAutoSlide();
                }
                
                productsPrevBtn.addEventListener('click', () => { prevSlide(); resetAutoSlide(); });
                productsNextBtn.addEventListener('click', () => { nextSlide(); resetAutoSlide(); });
                productsContainer.addEventListener('mouseenter', () => clearInterval(autoSlideInterval));
                productsContainer.addEventListener('mouseleave', startAutoSlide);
                
                updateCarousel();
                if (totalSlides > 1) startAutoSlide();
            }
            
            // Research Activities Scroll - FIXED
            const researchGrid = document.getElementById('researchGrid');
            const scrollLeftBtn = document.getElementById('scrollLeft');
            const scrollRightBtn = document.getElementById('scrollRight');
            
            if (researchGrid && scrollLeftBtn && scrollRightBtn) {
                const scrollAmount = 400;
                
                scrollLeftBtn.addEventListener('click', () => {
                    researchGrid.scrollBy({
                        left: -scrollAmount,
                        behavior: 'smooth'
                    });
                });
                
                scrollRightBtn.addEventListener('click', () => {
                    researchGrid.scrollBy({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });
                });
                
                // Auto-scroll for research
                let researchAutoScroll;
                function startResearchAutoScroll() {
                    researchAutoScroll = setInterval(() => {
                        if (researchGrid.scrollLeft + researchGrid.clientWidth >= researchGrid.scrollWidth - 10) {
                            researchGrid.scrollTo({ left: 0, behavior: 'smooth' });
                        } else {
                            researchGrid.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                        }
                    }, 5000);
                }
                
                researchGrid.addEventListener('mouseenter', () => clearInterval(researchAutoScroll));
                researchGrid.addEventListener('mouseleave', startResearchAutoScroll);
                startResearchAutoScroll();
            }
            
            // News expansion functionality
            window.expandNews = function() {
                const moreNews = document.getElementById('moreNewsGrid');
                const expandBtn = document.getElementById('expandNewsBtn');
                const collapseBtn = document.getElementById('collapseNewsBtn');
                
                if (moreNews && expandBtn && collapseBtn) {
                    moreNews.style.display = 'contents';
                    expandBtn.style.display = 'none';
                    collapseBtn.style.display = 'inline-flex';
                }
            };
            
            window.collapseNews = function() {
                const moreNews = document.getElementById('moreNewsGrid');
                const expandBtn = document.getElementById('expandNewsBtn');
                const collapseBtn = document.getElementById('collapseNewsBtn');
                
                if (moreNews && expandBtn && collapseBtn) {
                    moreNews.style.display = 'none';
                    expandBtn.style.display = 'inline-flex';
                    collapseBtn.style.display = 'none';
                    document.getElementById('news').scrollIntoView({ behavior: 'smooth' });
                }
            };

            // Navigation
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

    <style>
        /* ============================================
           PRODUCTS CAROUSEL - OVERRIDE EXTERNAL CSS
           Version 7: Fixed selectors
           ============================================ */
        
        /* Override container styling from style.css */
        #products .portfolio-container,
        #productsContainer.portfolio-container,
        .portfolio-section .portfolio-container {
            display: flex !important;
            flex-wrap: nowrap !important;
            flex-direction: row !important;
            justify-content: flex-start !important;
            align-items: stretch !important;
            gap: 30px !important;
            max-width: none !important;
            width: max-content !important;
            margin: 0 !important;
            padding: 0 5px !important;
            transition: transform 0.5s ease !important;
            transform: translateX(0);
        }
        
        /* Override card styling from style.css */
        #products .portfolio-card,
        #productsContainer .portfolio-card,
        .portfolio-section .portfolio-card {
            flex: 0 0 360px !important;
            min-width: 360px !important;
            max-width: 360px !important;
            width: 360px !important;
            height: 420px !important;
            padding: 0 !important;
            margin: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            background: white !important;
            border-radius: 20px !important;
            overflow: hidden !important;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1) !important;
            transition: box-shadow 0.3s ease, transform 0.3s ease !important;
            border: 1px solid #f0f0f0 !important;
            position: relative !important;
        }
        
        #products .portfolio-card:hover,
        #productsContainer .portfolio-card:hover,
        .portfolio-section .portfolio-card:hover {
            transform: translateY(-10px) !important;
            box-shadow: 0 15px 40px rgba(139, 93, 255, 0.15) !important;
        }
        
        /* Hide card button decorator from external CSS */
        #products .card-button-decorator,
        #productsContainer .card-button-decorator,
        .portfolio-section .card-button-decorator {
            display: none !important;
        }
        
        /* Hero Buttons Improvement */
        .hero-buttons {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }
        
        .btn-hero {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .btn-hero.primary {
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(139, 93, 255, 0.3);
        }
        
        .btn-hero.secondary {
            background: transparent;
            color: #2d5bd4;
            border-color: #2d5bd4;
        }
        
        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 93, 255, 0.4);
        }
        
        .btn-hero.secondary:hover {
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            color: white;
        }
        
        .btn-text {
            font-size: 1rem;
        }
        
        .circle-icon {
            width: 35px;
            height: 35px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }
        
        /* Header login button should keep gradient background */
        .header-action .circle-icon {
            background: linear-gradient(135deg, #2d5bd4, #d53f8c);
            color: white;
        }
        
        .btn-hero:hover .circle-icon {
            transform: translateX(5px);
        }
        
        /* Collaboration Section */
        .collaboration-section {
            padding: 80px 20px;
            background: linear-gradient(135deg, rgba(139, 93, 255, 0.05), rgba(93, 57, 255, 0.05));
            margin: 60px 0;
        }
        
        .collaboration-container {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }
        
        .collaboration-header {
            margin-bottom: 60px;
        }
        
        .collaboration-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .collaboration-card {
            background: white;
            border-radius: 20px;
            padding: 30px 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .collaboration-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(139, 93, 255, 0.15);
        }
        
        .collaboration-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
        }
        
        .collaboration-logo img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            background: white;
            border-radius: 50%;
            padding: 10px;
        }
        
        .placeholder-logo {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }
        
        .collaboration-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        
        .collaboration-desc {
            color: #666;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        
        .collaboration-type {
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        /* Portfolio/Products Section */
        .portfolio-section {
            padding: 80px 20px;
            max-width: 1400px;
            margin: 0 auto;
            text-align: center;
        }
        
        .products-header {
            margin-bottom: 60px;
        }
        
        .section-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Products Navigation */
        .products-navigation {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .products-nav-btn {
            width: 45px;
            height: 45px;
            border: none;
            border-radius: 50%;
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(139, 93, 255, 0.3);
        }
        
        .products-nav-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(139, 93, 255, 0.4);
        }
        
        .products-nav-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }
        
        .products-pagination {
            display: flex;
            gap: 8px;
        }
        
        .pagination-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ddd;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .pagination-dot.active {
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            transform: scale(1.2);
        }
        
        .pagination-dot:hover {
            background: #2d5bd4;
        }
        
        /* Products Carousel */
        .products-carousel-container {
            position: relative;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 0;
        }
        
        .products-viewport {
            overflow: hidden !important;
            border-radius: 20px;
            width: 1170px; /* 360*3 + 30*2 + 30 extra = 1170 */
            max-width: 100%;
            margin: 0 auto;
            position: relative;
            padding: 15px 0;
        }
        
        .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(45, 91, 212, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 2;
            border-radius: 20px;
        }
        
        #productsContainer .portfolio-card:hover .card-overlay {
            opacity: 1;
        }
        
        .card-overlay-content {
            text-align: center;
            color: white;
        }
        
        .card-overlay-content i {
            font-size: 2.5rem;
            margin-bottom: 10px;
            display: block;
        }
        
        .card-overlay-content span {
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        #productsContainer .card-image-wrapper {
            height: 220px;
            overflow: hidden;
            position: relative;
            margin-bottom: 0 !important;
        }
        
        #productsContainer .card-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        #productsContainer .portfolio-card:hover .card-image-wrapper img {
            transform: scale(1.1);
        }
        
        .card-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }
        
        #productsContainer .card-content {
            padding: 20px 25px;
            text-align: left;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        #productsContainer .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
            line-height: 1.3;
        }
        
        #productsContainer .card-description {
            color: #666;
            line-height: 1.5;
            margin-bottom: 15px;
            flex: 1;
            font-size: 0.95rem;
        }
        
        .card-action {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #2d5bd4;
            font-weight: 500;
            margin-top: auto;
        }
        
        .action-text {
            flex: 1;
        }
        
        .card-action i {
            transition: transform 0.3s ease;
        }
        
        #productsContainer .portfolio-card:hover .card-action i {
            transform: translateX(5px);
        }
        
        .no-products {
            flex: 1;
            text-align: center;
            padding: 80px 20px;
            color: #999;
        }
        
        .no-products i {
            font-size: 4rem;
            margin-bottom: 20px;
            display: block;
            color: #ddd;
        }
        
        .no-products p {
            font-size: 1.2rem;
        }

        /* News Section Modern Design */
        .news-section {
            padding: 80px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .news-heading {
            text-align: center;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 60px;
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .news-grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .more-news-grid {
            display: contents;
        }
        
        .news-card-modern {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }
        
        .news-card-modern:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .news-card-header {
            position: relative;
            height: 220px;
            overflow: hidden;
        }
        
        .news-thumbnail {
            position: relative;
            width: 100%;
            height: 100%;
        }
        
        .news-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .news-card-modern:hover .news-thumbnail img {
            transform: scale(1.1);
        }
        
        .news-overlay {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .news-tag {
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 500;
            max-width: 90%;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .news-card-body {
            padding: 25px;
        }
        
        .news-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .news-meta i {
            color: #2d5bd4;
        }
        
        .news-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
            line-height: 1.3;
        }
        
        .news-excerpt {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .news-read-more {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #2d5bd4;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .news-read-more:hover {
            color: #d53f8c;
            gap: 12px;
        }
        
        .news-footer {
            text-align: center;
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-expand-news,
        .btn-collapse-news {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            border: 2px solid #2d5bd4;
            color: #2d5bd4;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-expand-news:hover,
        .btn-collapse-news:hover {
            background: #2d5bd4;
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-view-all-news {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.2s ease;
        }
        
        .btn-view-all-news:hover {
            transform: translateY(-2px);
        }
        
        .no-news {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        /* Team Preview Section */
        .team-preview-section {
            padding: 80px 20px;
            background: white;
        }
        
        .team-preview-container {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }
        
        .team-preview-header {
            margin-bottom: 60px;
        }
        
        .team-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }
        
        .team-preview-card {
            background: white;
            padding: 25px 20px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .team-preview-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2d5bd4, #d53f8c);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .team-preview-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(139, 93, 255, 0.15);
        }
        
        .team-preview-card:hover::before {
            transform: scaleX(1);
        }
        
        .team-preview-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin: 0 auto 20px;
            overflow: hidden;
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            padding: 4px;
            position: relative;
        }
        
        .team-preview-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            background: white;
        }
        
        .team-avatar-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border-radius: 50%;
            font-size: 1.5rem;
        }
        
        .team-preview-info {
            text-align: center;
        }
        
        .team-preview-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        
        .team-preview-position {
            color: #2d5bd4;
            font-weight: 500;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }
        
        .team-preview-contact {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        
        .team-contact-btn {
            width: 35px;
            height: 35px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2d5bd4;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }
        
        .team-contact-btn:hover {
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-view-team {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.2s ease;
        }
        
        .btn-view-team:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 93, 255, 0.3);
        }
        
        /* Research Section Improvements */
        .research-carousel {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .research-card {
            display: none;
            max-width: 800px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .research-card.active {
            display: block;
        }
        
        .research-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }
        
        .research-image {
            position: relative;
            width: 100%;
            height: 300px;
            overflow: hidden;
        }
        
        .research-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .research-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            opacity: 0;
            transition: opacity 0.3s ease;
            gap: 10px;
        }
        
        .research-overlay i {
            font-size: 2rem;
        }
        
        .research-link:hover .research-overlay {
            opacity: 1;
        }
        
        .research-link:hover .research-image img {
            transform: scale(1.1);
        }
        
        .research-info {
            padding: 20px;
        }
        
        .research-info h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
        }
        
        .research-info p {
            color: #666;
            line-height: 1.6;
        }
        
        @media (max-width: 768px) {
            .hero-buttons {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }
            
            .btn-hero {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .products-carousel-container {
                max-width: 100%;
                padding: 0 10px;
            }
            
            .products-viewport {
                width: 310px; /* Show 1 card on mobile: 280 + 30 padding */
            }
            
            .portfolio-card {
                flex: 0 0 280px;
                width: 280px;
            }
            
            .products-navigation {
                flex-direction: column;
                gap: 15px;
            }
            
            .products-nav-btn {
                width: 40px;
                height: 40px;
            }
            
            .collaboration-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .news-grid-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .news-card-header {
                height: 180px;
            }
            
            .news-heading {
                font-size: 2rem;
                margin-bottom: 40px;
            }
            
            .team-preview-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            
            .research-card {
                max-width: 90vw;
            }
            
            .research-image {
                height: 200px;
            }
            
            .research-info {
                padding: 15px;
            }
            
            .research-info h3 {
                font-size: 1.2rem;
            }
            
            .collaboration-section,
            .team-preview-section {
                padding: 60px 20px;
            }
        }
        
        @media (max-width: 1024px) {
            .products-carousel-container {
                max-width: 800px;
            }
            
            .products-viewport {
                width: 730px; /* Show 2 cards on tablet: 320*2 + 30 gap + 30 padding */
            }
            
            .portfolio-card {
                flex: 0 0 320px;
                width: 320px;
            }
        }
        
        @media (max-width: 480px) {
            .team-preview-grid {
                grid-template-columns: 1fr;
            }
            
            .news-footer {
                flex-direction: column;
                align-items: center;
            }
            
            .collaboration-grid {
                gap: 15px;
            }
            
            .collaboration-card,
            .team-preview-card {
                padding: 20px 15px;
            }
            
            .portfolio-card {
                margin: 0 5px;
            }
            
            .card-content {
                padding: 20px;
            }
            
            .card-title {
                font-size: 1.2rem;
            }
            
            .products-carousel-container {
                padding: 0 5px;
            }
            
            .portfolio-card {
                flex: 0 0 260px;
                width: 260px;
            }
        }

        /* ========== SCROLL ANIMATIONS ========== */
        
        /* Base animation classes - hidden by default */
        .scroll-animate {
            opacity: 0;
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .scroll-animate.animated {
            opacity: 1;
        }
        
        /* Fade Up Animation */
        .fade-up {
            transform: translateY(60px);
        }
        .fade-up.animated {
            transform: translateY(0);
        }
        
        /* Fade Down Animation */
        .fade-down {
            transform: translateY(-60px);
        }
        .fade-down.animated {
            transform: translateY(0);
        }
        
        /* Slide Left Animation */
        .slide-left {
            transform: translateX(-80px);
        }
        .slide-left.animated {
            transform: translateX(0);
        }
        
        /* Slide Right Animation */
        .slide-right {
            transform: translateX(80px);
        }
        .slide-right.animated {
            transform: translateX(0);
        }
        
        /* Zoom In Animation */
        .zoom-in {
            transform: scale(0.8);
        }
        .zoom-in.animated {
            transform: scale(1);
        }
        
        /* Zoom Out Animation */
        .zoom-out {
            transform: scale(1.2);
        }
        .zoom-out.animated {
            transform: scale(1);
        }
        
        /* Rotate In Animation */
        .rotate-in {
            transform: rotate(-10deg) scale(0.9);
        }
        .rotate-in.animated {
            transform: rotate(0) scale(1);
        }
        
        /* Flip Animation */
        .flip-up {
            transform: perspective(1000px) rotateX(45deg);
            transform-origin: bottom;
        }
        .flip-up.animated {
            transform: perspective(1000px) rotateX(0);
        }
        
        /* Bounce Animation */
        .bounce-in {
            transform: scale(0.3);
            animation-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        .bounce-in.animated {
            transform: scale(1);
        }
        
        /* Stagger delay classes for child elements */
        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.2s; }
        .stagger-3 { transition-delay: 0.3s; }
        .stagger-4 { transition-delay: 0.4s; }
        .stagger-5 { transition-delay: 0.5s; }
        .stagger-6 { transition-delay: 0.6s; }
        
        /* Parallax effect for background */
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        
        /* Floating animation for decorative elements */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        .floating {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Pulse animation for buttons/icons */
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .pulse-hover:hover {
            animation: pulse 1s ease-in-out infinite;
        }
        
        /* Glow effect */
        @keyframes glow {
            0%, 100% { box-shadow: 0 0 5px rgba(102, 126, 234, 0.5); }
            50% { box-shadow: 0 0 30px rgba(102, 126, 234, 0.8), 0 0 60px rgba(118, 75, 162, 0.4); }
        }
        
        .glow-effect {
            animation: glow 2s ease-in-out infinite;
        }
        
        /* Gradient text animation */
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }
        
        /* Smooth scroll indicator */
        .scroll-indicator {
            position: fixed;
            top: 0;
            left: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            z-index: 9999;
            transition: width 0.1s ease;
        }
        
        /* Card hover lift effect enhancement */
        .hover-lift {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.4s ease;
        }
        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        /* Reveal from blur */
        .blur-reveal {
            filter: blur(10px);
            opacity: 0;
        }
        .blur-reveal.animated {
            filter: blur(0);
            opacity: 1;
        }
        
        /* Counter animation style */
        .counter-animate {
            display: inline-block;
        }
        
        /* Section divider wave animation */
        .wave-divider {
            position: relative;
            overflow: hidden;
        }
        
        .wave-divider::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200%;
            height: 60px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120'%3E%3Cpath fill='%23ffffff' d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.92,146.53,111.31,216.54,92.83,253.75,googl,googl,e82.88,285.19,65.34,321.39,56.44Z'%3E%3C/path%3E%3C/svg%3E") repeat-x;
            animation: wave 10s linear infinite;
        }
        
        @keyframes wave {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        /* Typewriter effect for hero text */
        .typewriter {
            overflow: hidden;
            border-right: 3px solid #667eea;
            white-space: nowrap;
            animation: typing 3s steps(40, end), blink-caret 0.75s step-end infinite;
        }
        
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }
        
        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: #667eea; }
        }
        
        /* Morphing background shapes */
        @keyframes morph {
            0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
            50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
        }
        
        .morph-shape {
            animation: morph 8s ease-in-out infinite;
        }
        
        /* Shimmer loading effect */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
    </style>

    <!-- Scroll Animation JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ========== Scroll Progress Indicator ==========
            const scrollIndicator = document.createElement('div');
            scrollIndicator.className = 'scroll-indicator';
            document.body.prepend(scrollIndicator);
            
            // ========== Smooth Scroll for all anchor links ==========
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            // ========== Add scroll-animate classes to sections ==========
            const animateElements = [
                { selector: '.hero-content', animation: 'fade-up' },
                { selector: '.stats-section .stat-item', animation: 'zoom-in', stagger: true },
                { selector: '.collaboration-header', animation: 'fade-up' },
                { selector: '.collaboration-card', animation: 'fade-up', stagger: true },
                { selector: '.products-header', animation: 'fade-up' },
                { selector: '.portfolio-card', animation: 'zoom-in', stagger: true },
                { selector: '.team-preview-section h2', animation: 'fade-up' },
                { selector: '.team-preview-section > p', animation: 'fade-up' },
                { selector: '.team-preview-card', animation: 'fade-up', stagger: true },
                { selector: '.news-heading', animation: 'fade-up' },
                { selector: '.news-card', animation: 'slide-left', stagger: true },
                { selector: '.gallery-section h2', animation: 'fade-up' },
                { selector: '.gallery-grid-public img', animation: 'zoom-in', stagger: true },
                { selector: '.research-section h2', animation: 'fade-up' },
                { selector: '.research-card', animation: 'flip-up' }
            ];
            
            animateElements.forEach(item => {
                const elements = document.querySelectorAll(item.selector);
                elements.forEach((el, index) => {
                    el.classList.add('scroll-animate', item.animation);
                    if (item.stagger) {
                        el.classList.add('stagger-' + Math.min(index + 1, 6));
                    }
                });
            });
            
            // ========== Intersection Observer for scroll animations ==========
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -100px 0px',
                threshold: 0.1
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        // Optional: unobserve after animation (runs once)
                        // observer.unobserve(entry.target);
                    } else {
                        // Remove animated class when out of view (for re-animation on scroll back)
                        entry.target.classList.remove('animated');
                    }
                });
            }, observerOptions);
            
            document.querySelectorAll('.scroll-animate').forEach(el => {
                observer.observe(el);
            });
            
            // ========== Scroll Progress Bar ==========
            window.addEventListener('scroll', () => {
                const scrollTop = window.scrollY;
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                const scrollPercent = (scrollTop / docHeight) * 100;
                scrollIndicator.style.width = scrollPercent + '%';
            });
            
            // ========== Counter Animation for Stats ==========
            function animateCounter(element, target, duration = 2000) {
                let start = 0;
                const increment = target / (duration / 16);
                const timer = setInterval(() => {
                    start += increment;
                    if (start >= target) {
                        element.textContent = target;
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(start);
                    }
                }, 16);
            }
            
            // Observe stat numbers for counter animation
            const statNumbers = document.querySelectorAll('.stat-text');
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                        entry.target.classList.add('counted');
                        const text = entry.target.textContent;
                        const match = text.match(/(\d+)/);
                        if (match) {
                            const num = parseInt(match[1]);
                            const suffix = text.replace(match[1], '').trim();
                            entry.target.textContent = '0 ' + suffix;
                            
                            let current = 0;
                            const duration = 2000;
                            const increment = num / (duration / 16);
                            const timer = setInterval(() => {
                                current += increment;
                                if (current >= num) {
                                    entry.target.textContent = num + ' ' + suffix;
                                    clearInterval(timer);
                                } else {
                                    entry.target.textContent = Math.floor(current) + ' ' + suffix;
                                }
                            }, 16);
                        }
                    }
                });
            }, { threshold: 0.5 });
            
            statNumbers.forEach(stat => counterObserver.observe(stat));
            
            // ========== Parallax Effect for Hero ==========
            const hero = document.querySelector('.hero');
            if (hero) {
                window.addEventListener('scroll', () => {
                    const scrolled = window.scrollY;
                    hero.style.backgroundPositionY = scrolled * 0.5 + 'px';
                });
            }
            
            // ========== Add hover-lift to cards ==========
            document.querySelectorAll('.portfolio-card, .collaboration-card, .team-preview-card, .news-card').forEach(card => {
                card.classList.add('hover-lift');
            });
            
            // ========== Mouse move parallax for hero content ==========
            const heroContent = document.querySelector('.hero-content');
            if (heroContent) {
                document.addEventListener('mousemove', (e) => {
                    const xAxis = (window.innerWidth / 2 - e.pageX) / 50;
                    const yAxis = (window.innerHeight / 2 - e.pageY) / 50;
                    heroContent.style.transform = `translateX(${xAxis}px) translateY(${yAxis}px)`;
                });
                
                document.addEventListener('mouseleave', () => {
                    heroContent.style.transform = 'translateX(0) translateY(0)';
                });
            }
            
            // ========== Floating animation for stat images ==========
            document.querySelectorAll('.stat-img').forEach((img, index) => {
                img.style.animationDelay = (index * 0.5) + 's';
                img.classList.add('floating');
            });
            
            // ========== Button pulse on hover ==========
            document.querySelectorAll('.btn-hero, .view-team-btn, .btn-primary').forEach(btn => {
                btn.classList.add('pulse-hover');
            });
        });
    </script>

</body>

</html>
