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
                <a href="#research" class="btn-hero primary">
                    <span class="btn-text">Our Research</span>
                    <div class="circle-icon">
                        <i class="fa-solid fa-microscope"></i>
                    </div>
                </a>
                <a href="?page=about" class="btn-hero secondary">
                    <span class="btn-text">Learn More</span>
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

    <section class="collaboration-section">
        <div class="collaboration-container">
            <div class="collaboration-header">
                <h2 class="section-title gradient-text">Our Partnerships</h2>
                <p class="section-subtitle">Collaborating with leading institutions and organizations to advance learning technology</p>
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
                            <h4 class="collaboration-name">Academic Partners</h4>
                            <p class="collaboration-desc">Leading universities and research institutions</p>
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
                            <h4 class="collaboration-name">Industry Partners</h4>
                            <p class="collaboration-desc">Technology companies and organizations</p>
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
                            <h4 class="collaboration-name">Strategic Partners</h4>
                            <p class="collaboration-desc">Long-term strategic collaborations</p>
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
    } catch (Exception $e) {
        error_log("Products Error: " . $e->getMessage());
        $products = [];
    }
    ?>

    <section id="products" class="portfolio-section">
        <h2 class="section-title gradient-text">Our Products</h2>
        <p class="section-subtitle">Innovative learning solutions designed to enhance educational experiences</p>
        <div class="portfolio-container">
            <?php if (!empty($products)): ?>
                <?php foreach (array_slice($products, 0, 3) as $index => $product): ?>
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
                <h2 class="section-title gradient-text">Meet Our Team</h2>
                <p class="section-subtitle">Dedicated professionals driving innovation in learning technology research and development</p>
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
                        <span>Meet Full Team</span>
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

        <h2 class="news-heading gradient-text">News & Updates</h2>

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
                                <span>Read More</span>
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
                    <p>Belum ada berita terbaru.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="news-footer">
            <?php if (count($allNews) > 3): ?>
                <button id="expandNewsBtn" class="btn-expand-news" onclick="expandNews()">
                    <span>Show More News</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <button id="collapseNewsBtn" class="btn-collapse-news" onclick="collapseNews()" style="display: none;">
                    <span>Show Less</span>
                    <i class="fas fa-chevron-up"></i>
                </button>
            <?php endif; ?>
            <a href="?page=newspublic" class="btn-view-all-news">
                <span>View All News</span>
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>

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
                <h2 class="section-title gradient-text">Research Activities</h2>
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
                                        <i class="fas fa-eye"></i> View Details
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
                    <p>Belum ada data aktivitas riset.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        // News expansion functionality
        function expandNews() {
            const moreNews = document.getElementById('moreNewsGrid');
            const expandBtn = document.getElementById('expandNewsBtn');
            const collapseBtn = document.getElementById('collapseNewsBtn');
            
            moreNews.style.display = 'contents';
            expandBtn.style.display = 'none';
            collapseBtn.style.display = 'inline-flex';
        }
        
        function collapseNews() {
            const moreNews = document.getElementById('moreNewsGrid');
            const expandBtn = document.getElementById('expandNewsBtn');
            const collapseBtn = document.getElementById('collapseNewsBtn');
            
            moreNews.style.display = 'none';
            expandBtn.style.display = 'inline-flex';
            collapseBtn.style.display = 'none';
            
            // Scroll to news section
            document.getElementById('news').scrollIntoView({ behavior: 'smooth' });
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Research Carousel
            const prevBtn = document.getElementById('prevResearch');
            const nextBtn = document.getElementById('nextResearch');
            const researchCards = document.querySelectorAll('.research-card');
            let currentIndex = 0;

            if (researchCards.length > 0) {
                function showResearchCard(index) {
                    researchCards.forEach((card, i) => {
                        card.classList.toggle('active', i === index);
                    });
                }

                if (prevBtn) {
                    prevBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        currentIndex = (currentIndex - 1 + researchCards.length) % researchCards.length;
                        showResearchCard(currentIndex);
                    });
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        currentIndex = (currentIndex + 1) % researchCards.length;
                        showResearchCard(currentIndex);
                    });
                }

                // Auto-play carousel
                if (researchCards.length > 1) {
                    setInterval(() => {
                        currentIndex = (currentIndex + 1) % researchCards.length;
                        showResearchCard(currentIndex);
                    }, 5000);
                }
            }

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
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
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
            margin-bottom: 60px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .portfolio-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 50px;
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
            
            .portfolio-container,
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
        }
    </style>

</body>

</html>
