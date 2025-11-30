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

            <div class="stat-row row-left">
                <div class="stat-item">
                    <img src="gambar_viewers.png" alt="Viewers" class="stat-img">
                    <h3 class="stat-text gradient-text">11 VIEWERS</h3>
                </div>
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

    <section class="portfolio-section">
        <div class="portfolio-container">

            <div class="portfolio-card">
                <a href="#" class="card-button-decorator button-left">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <div class="card-image-wrapper">
                    <img src="img/viat-map.png" alt="Viat Map Logo">
                </div>
                <h3 class="card-title">Viat Map Application</h3>
                <p class="card-description">
                    VIAT-map (Visual Arguments Toulmin) Application to help Reding Comprehension by using Toulmin Arguments Concept. We are trying to emphasise the logic behind a written text by adding the claim, ground, and warrant following the Toulmin Argument Concept.
                </p>
            </div>

            <div class="portfolio-card">
                <a href="#" class="card-button-decorator button-right">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <div class="card-image-wrapper">
                    <img src="img/pseudolearn.png" alt="PseudoLearn Logo">
                </div>
                <h3 class="card-title">PseudoLearn Application</h3>
                <p class="card-description">
                    Sebuah media pembelajaran rekonstruksi algoritma pseudocode dengan menggunakan pendekatan Element Fill-in-Blank Problems di dalam pemrograman Java
                </p>
            </div>

        </div>
    </section>

    <section id="news" class="news-section">


            <h2 class="news-heading gradient-text">News</h2>

            <div class="news-container">
                <div class="news-card-border">
                    <div class="news-card">
                        <img src="img/news 1.png" alt="News 1" class="news-card-img">
                        <div class="news-card-content">
                            <h3 class="news-card-title">Visiting Scientist Program</h3>
                            <p class="news-card-description">
                                In November, 2023, we had a chance to had a research collaboration with Hiroshima University
                            </p>
                        </div>
                    </div>
                </div>

                <div class="news-card-wrapper">
                    <div class="news-card-border">
                        <div class="news-card">
                            <img src="img/news 2.png" alt="News 2" class="news-card-img">
                            <div class="news-card-content">
                                <h3 class="news-card-title">Monthly Research Discussion</h3>
                                <p class="news-card-description">
                                    Conducting a routine monthly research discussion to find new concept and finding
                                </p>
                            </div>
                        </div>
                    </div>

                    <a href="javascript:void(0)" class="news-button" id="toggleNewsBtn">
                        <i class="fa-solid fa-chevron-down"></i> </a>
                </div>

                <div class="news-card-border">
                    <div class="news-card">
                        <img src="img/news 3.png" alt="News 3" class="news-card-img">
                        <div class="news-card-content">
                            <h3 class="news-card-title">International Research Discussion Program</h3>
                            <p class="news-card-description">
                                Enriching the research area by having Research discussion
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <div id="moreNewsSection" class="more-news-wrapper" style="display: none;">

                <div class="news-container additional-news-grid">
                    <div class="news-card-border">
                        <div class="news-card">
                            <img src="img/news4.png" alt="News 4" class="news-card-img">
                            <div class="news-card-content">
                                <h3 class="news-card-title">Workshop Data Science</h3>
                                <p class="news-card-description">
                                    Workshop intensif tentang dasar-dasar data science dan aplikasinya.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="news-card-border">
                        <div class="news-card">
                            <img src="img/news5.png" alt="News 5" class="news-card-img">
                            <div class="news-card-content">
                                <h3 class="news-card-title">Guest Lecture AI Ethics</h3>
                                <p class="news-card-description">
                                    Diskusi mendalam mengenai etika AI dengan pembicara ahli internasional.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="news-card-border">
                        <div class="news-card">
                            <img src="img/news6.png" alt="News 6" class="news-card-img">
                            <div class="news-card-content">
                                <h3 class="news-card-title">Research Grant Award</h3>
                                <p class="news-card-description">
                                    Penghargaan hibah penelitian bagi tim dengan inovasi terbaik.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="news-card-border">
                        <div class="news-card">
                            <img src="img/news7.png" alt="News 7" class="news-card-img">
                            <div class="news-card-content">
                                <h3 class="news-card-title">Student Exchange Program</h3>
                                <p class="news-card-description">
                                    Kesempatan belajar di luar negeri melalui program pertukaran mahasiswa.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="news-card-border">
                        <div class="news-card">
                            <img src="img/news8.png" alt="News 8" class="news-card-img">
                            <div class="news-card-content">
                                <h3 class="news-card-title">New Publication</h3>
                                <p class="news-card-description">
                                    Rilis publikasi ilmiah terbaru dari anggota tim peneliti kami.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="news-card-border">
                        <div class="news-card">
                            <img src="img/news9.png" alt="News 9" class="news-card-img">
                            <div class="news-card-content">
                                <h3 class="news-card-title">Community Service</h3>
                                <p class="news-card-description">
                                    Kegiatan pengabdian masyarakat berbasis teknologi untuk dampak sosial.
                                </p>
                            </div>
                        </div>
                    </div>
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

    <section class="activity-section">
        <h2 class="section-title gradient-text">Aktifiti</h2>
        <div class="activity-container">
            <a href="#" class="arrow-button left-arrow">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
            <div class="video-card-wrapper">
                <div class="video-card">
                    <iframe src="https://www.youtube.com/embed/YOUR_YOUTUBE_VIDEO_ID" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
            <a href="#" class="arrow-button right-arrow">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>
    </section>

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