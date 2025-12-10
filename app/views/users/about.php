<?php
$lang = $_SESSION['lang'] ?? 'en';
if (!in_array($lang, ['en', 'id'])) {
    $lang = 'en';
}

$aboutTrans = array(
    'en' => array(
        'page_title' => 'About',
        'hero_title' => 'About InLet Lab',
        'hero_desc' => 'Learning Engineering Technology Research Group focuses on designing research-based educational solutions. We combine instructional design approaches, learning analytics, and digital product prototyping to deliver relevant and impactful learning experiences.',
        'vision_title' => 'Our Vision',
        'vision_desc' => 'To become a leading research and development center in information and learning engineering technology, driving innovation and excellence in education technology solutions that transform the way people learn and interact with information.',
        'mission_title' => 'Our Mission',
        'mission_1' => 'Develop innovative learning technologies and information systems',
        'mission_2' => 'Conduct cutting-edge research in educational technology',
        'mission_3' => 'Foster collaboration with industry and academic partners',
        'mission_4' => 'Create impactful solutions for modern learning challenges',
        'who_title' => 'Who We Are',
        'who_p1' => '<strong>InLet</strong> (Information and Learning Engineering Technology) is a dynamic research laboratory dedicated to advancing the field of educational technology and information systems. Founded with the vision of transforming learning experiences through technology, we bring together researchers, developers, and educators to create innovative solutions.',
        'who_p2' => 'Our team consists of experienced professionals with diverse backgrounds in computer science, education, and engineering. We work on various projects ranging from learning management systems to artificial intelligence applications in education.',
        'who_quote' => 'Through our research activities, product development, and industry partnerships, we aim to make a significant impact on how technology is used in education and information management.',
        'focus_title' => 'Our Focus Areas',
        'focus_edu_title' => 'Educational Technology',
        'focus_edu_desc' => 'Developing innovative learning platforms and tools',
        'focus_ai_title' => 'Artificial Intelligence',
        'focus_ai_desc' => 'AI applications in education and information systems',
        'focus_info_title' => 'Information Systems',
        'focus_info_desc' => 'Building robust and scalable information management solutions',
        'focus_mobile_title' => 'Mobile Applications',
        'focus_mobile_desc' => 'Creating mobile-first learning experiences',
        'roadmap_title' => 'Our Research Road Map',
        'roadmap_desc' => 'We are aiming to build a complete support system based on the learning behavior of students. Starting from Learning Applications, Learning Analytics, Multi-Modal Learning Analytics, AI in Education, Adaptive Support Systems, Gamification, and Management Learning Monitoring Systems.'
    ),
    'id' => array(
        'page_title' => 'Tentang',
        'hero_title' => 'Tentang Lab InLet',
        'hero_desc' => 'Learning Engineering Technology Research Group berfokus pada desain solusi pendidikan berbasis riset. Kami memadukan pendekatan instructional design, analitik pembelajaran, serta prototyping produk digital untuk menghadirkan pengalaman belajar yang relevan dan berdampak.',
        'vision_title' => 'Visi Kami',
        'vision_desc' => 'Menjadi pusat penelitian dan pengembangan terkemuka dalam teknologi informasi dan pembelajaran, mendorong inovasi dan keunggulan dalam solusi teknologi pendidikan yang mengubah cara orang belajar dan berinteraksi dengan informasi.',
        'mission_title' => 'Misi Kami',
        'mission_1' => 'Mengembangkan teknologi pembelajaran dan sistem informasi yang inovatif',
        'mission_2' => 'Melakukan penelitian mutakhir dalam teknologi pendidikan',
        'mission_3' => 'Mendorong kolaborasi dengan mitra industri dan akademik',
        'mission_4' => 'Menciptakan solusi berdampak untuk tantangan pembelajaran modern',
        'who_title' => 'Siapa Kami',
        'who_p1' => '<strong>InLet</strong> (Information and Learning Engineering Technology) adalah laboratorium penelitian dinamis yang berdedikasi untuk memajukan bidang teknologi pendidikan dan sistem informasi. Didirikan dengan visi mengubah pengalaman belajar melalui teknologi, kami menyatukan peneliti, pengembang, dan pendidik untuk menciptakan solusi inovatif.',
        'who_p2' => 'Tim kami terdiri dari profesional berpengalaman dengan latar belakang beragam dalam ilmu komputer, pendidikan, dan teknik. Kami mengerjakan berbagai proyek mulai dari sistem manajemen pembelajaran hingga aplikasi kecerdasan buatan dalam pendidikan.',
        'who_quote' => 'Melalui aktivitas penelitian, pengembangan produk, dan kemitraan industri, kami bertujuan memberikan dampak signifikan pada bagaimana teknologi digunakan dalam pendidikan dan manajemen informasi.',
        'focus_title' => 'Area Fokus Kami',
        'focus_edu_title' => 'Teknologi Pendidikan',
        'focus_edu_desc' => 'Mengembangkan platform dan alat pembelajaran inovatif',
        'focus_ai_title' => 'Kecerdasan Buatan',
        'focus_ai_desc' => 'Aplikasi AI dalam pendidikan dan sistem informasi',
        'focus_info_title' => 'Sistem Informasi',
        'focus_info_desc' => 'Membangun solusi manajemen informasi yang kuat dan skalabel',
        'focus_mobile_title' => 'Aplikasi Mobile',
        'focus_mobile_desc' => 'Menciptakan pengalaman belajar yang mengutamakan mobile',
        'roadmap_title' => 'Peta Jalan Riset Kami',
        'roadmap_desc' => 'Kami bertujuan membangun sistem dukungan lengkap berdasarkan perilaku belajar siswa. Mulai dari Aplikasi Pembelajaran, Analitik Pembelajaran, Analitik Pembelajaran Multi-Modal, AI dalam Pendidikan, Sistem Dukungan Adaptif, Gamifikasi, dan Sistem Pemantauan Manajemen Pembelajaran.'
    )
);

$at = $aboutTrans[$lang] ?? $aboutTrans['en'];
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $at['page_title']; ?> - Learning Engineering Technology</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="page page-about">

    <?php include 'header.php'; ?>

    <main class="page-wrapper about-page">
        
        <!-- Hero Section -->
        <section class="about-hero">
            <div class="about-hero-content">
                <h1 class="gradient-text"><?php echo $at['hero_title']; ?></h1>
                <p class="about-hero-subtitle">
                    <?php echo $at['hero_desc']; ?>
                </p>
            </div>
        </section>

        <!-- Vision & Mission Section -->
        <section class="vision-mission-section">
            <div class="vision-mission-container">
                <div class="vm-card">
                    <h2><i class="fas fa-eye"></i> <?php echo $at['vision_title']; ?></h2>
                    <p>
                        <?php echo $at['vision_desc']; ?>
                    </p>
                </div>

                <div class="vm-card">
                    <h2><i class="fas fa-bullseye"></i> <?php echo $at['mission_title']; ?></h2>
                    <ul>
                        <li><?php echo $at['mission_1']; ?></li>
                        <li><?php echo $at['mission_2']; ?></li>
                        <li><?php echo $at['mission_3']; ?></li>
                        <li><?php echo $at['mission_4']; ?></li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Who We Are Section -->
        <section class="who-we-are-section">
            <div class="who-we-are-container">
                <div class="who-we-are-content">
                    <div class="who-we-are-text">
                        <h2 class="gradient-text"><?php echo $at['who_title']; ?></h2>
                        <p>
                            <?php echo $at['who_p1']; ?>
                        </p>
                        <p>
                            <?php echo $at['who_p2']; ?>
                        </p>
                        <div class="who-we-are-quote">
                            "<?php echo $at['who_quote']; ?>"
                        </div>
                    </div>
                    <div class="who-we-are-image">
                        <img src="https://let.polinema.ac.id/assets/images/whatsapp-image-2023-11-28-at-13.53.53-ad815996.jpg"
                             alt="InLet Team">
                    </div>
                </div>
            </div>
        </section>

        <!-- Focus Areas Section -->
        <section class="focus-areas-section">
            <div class="focus-areas-container">
                <h2 class="section-title-center gradient-text"><?php echo $at['focus_title']; ?></h2>
                <div class="focus-grid">
                    <div class="focus-card">
                        <div class="focus-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3><?php echo $at['focus_edu_title']; ?></h3>
                        <p><?php echo $at['focus_edu_desc']; ?></p>
                    </div>

                    <div class="focus-card">
                        <div class="focus-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3><?php echo $at['focus_ai_title']; ?></h3>
                        <p><?php echo $at['focus_ai_desc']; ?></p>
                    </div>

                    <div class="focus-card">
                        <div class="focus-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <h3><?php echo $at['focus_info_title']; ?></h3>
                        <p><?php echo $at['focus_info_desc']; ?></p>
                    </div>

                    <div class="focus-card">
                        <div class="focus-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3><?php echo $at['focus_mobile_title']; ?></h3>
                        <p><?php echo $at['focus_mobile_desc']; ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Roadmap Section -->
        <section class="roadmap-section">
            <div class="roadmap-container">
                <h2 class="section-title-center gradient-text"><?php echo $at['roadmap_title']; ?></h2>
                <div class="roadmap-intro">
                    <p>
                        <?php echo $at['roadmap_desc']; ?>
                    </p>
                </div>
                <div class="roadmap-image">
                    <img src="assets/img/roadmap.png" alt="InLet Research Roadmap">
                </div>
            </div>
        </section>

    </main>

    <?php include 'footer.php'; ?>

</body>

</html>