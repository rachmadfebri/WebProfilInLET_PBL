<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About • Learning Engineering Technology</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .about-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Hero Section */
        .about-hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            padding: 80px 0;
            min-height: 80vh;
        }

        .about-hero-text {
            padding-right: 40px;
        }

        .about-label {
            color: #667eea;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .about-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .about-description {
            font-size: 1.2rem;
            line-height: 1.7;
            color: #666;
            margin-bottom: 25px;
        }

        .about-hero-image {
            position: relative;
            border-radius: 25px;
            overflow: hidden;
            height: 500px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .about-hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .about-hero-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(45, 91, 212, 0.3), rgba(213, 63, 140, 0.3));
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            padding: 80px 0;
            margin: 80px 0;
            border-radius: 30px;
            color: white;
        }

        .stats-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            text-align: center;
        }

        .stat-item {
            padding: 20px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 10px;
            display: block;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Mission Section */
        .mission-section {
            padding: 80px 0;
            text-align: center;
        }

        .mission-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 50px;
            color: #333;
        }

        .mission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .mission-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 2px solid #f0f0f0;
            text-align: center;
            transition: all 0.3s ease;
        }

        .mission-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .mission-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #2d5bd4 0%, #d53f8c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: white;
            font-size: 2rem;
        }

        .mission-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .mission-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Values Section */
        .values-section {
            background: #f8f9fa;
            padding: 80px 0;
            margin: 80px 0;
            border-radius: 30px;
        }

        .values-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;
        }

        .values-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 50px;
            color: #333;
        }

        .values-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .value-item {
            background: white;
            padding: 30px 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border-left: 4px solid #667eea;
        }

        .value-item h4 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .value-item p {
            color: #666;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .about-hero {
                grid-template-columns: 1fr;
                gap: 40px;
                padding: 40px 0;
                text-align: center;
            }

            .about-hero-text {
                padding-right: 0;
            }

            .about-title {
                font-size: 2.5rem;
            }

            .about-description {
                font-size: 1.1rem;
            }

            .about-hero-image {
                height: 300px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 30px;
            }

            .stat-number {
                font-size: 2rem;
            }

            .mission-title,
            .values-title {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body class="page page-about">

    <?php include 'header.php'; ?>

    <main class="page-wrapper">
        <div class="about-page">
            
            <!-- Hero Section -->
            <section class="about-hero">
                <div class="about-hero-text">
                    <div class="about-label">About Us</div>
                    <h1 class="about-title">Learning Engineering Technology</h1>
                    <p class="about-description">
                        Learning Engineering Technology Research Group berfokus pada desain solusi pendidikan
                        berbasis riset. Kami memadukan pendekatan instructional design, analitik pembelajaran,
                        serta prototyping produk digital untuk menghadirkan pengalaman belajar yang relevan dan
                        berdampak.
                    </p>
                    <p class="about-description">
                        Kolaborasi lintas disiplin, eksperimen terukur, dan kurasi teknologi terbaru menjadi
                        pijakan kami untuk menciptakan ekosistem pembelajaran yang human-centered.
                    </p>
                </div>
                <div class="about-hero-image">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=80"
                        alt="Learning Engineering Technology Research">
                </div>
            </section>

            <!-- Stats Section -->
            <section class="stats-section">
                <div class="stats-container">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-number">10+</span>
                            <span class="stat-label">Research Projects</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">25+</span>
                            <span class="stat-label">Team Members</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">50+</span>
                            <span class="stat-label">Publications</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">100+</span>
                            <span class="stat-label">Students Impacted</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Mission Section -->
            <section class="mission-section">
                <h2 class="mission-title">Our Mission</h2>
                <div class="mission-grid">
                    <div class="mission-card">
                        <div class="mission-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3>Innovation</h3>
                        <p>Mengembangkan teknologi pembelajaran inovatif yang memanfaatkan pendekatan learning engineering untuk menciptakan solusi pendidikan yang efektif.</p>
                    </div>
                    
                    <div class="mission-card">
                        <div class="mission-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Collaboration</h3>
                        <p>Membangun kolaborasi interdisipliner antara pendidik, teknolog, dan peneliti untuk menghasilkan produk pembelajaran yang berdampak nyata.</p>
                    </div>
                    
                    <div class="mission-card">
                        <div class="mission-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Research Excellence</h3>
                        <p>Melakukan penelitian berkualitas tinggi dalam bidang learning analytics, instructional design, dan educational technology.</p>
                    </div>
                </div>
            </section>

            <!-- Values Section -->
            <section class="values-section">
                <div class="values-container">
                    <h2 class="values-title">Our Values</h2>
                    <div class="values-list">
                        <div class="value-item">
                            <h4>Human-Centered Design</h4>
                            <p>Menempatkan kebutuhan pengguna sebagai fokus utama dalam setiap pengembangan teknologi pembelajaran.</p>
                        </div>
                        
                        <div class="value-item">
                            <h4>Evidence-Based Practice</h4>
                            <p>Menggunakan data dan bukti empiris sebagai dasar pengambilan keputusan dalam desain pembelajaran.</p>
                        </div>
                        
                        <div class="value-item">
                            <h4>Continuous Learning</h4>
                            <p>Berkomitmen pada pembelajaran berkelanjutan dan adaptasi terhadap perkembangan teknologi terbaru.</p>
                        </div>
                        
                        <div class="value-item">
                            <h4>Quality & Impact</h4>
                            <p>Mengutamakan kualitas output penelitian yang dapat memberikan dampak positif bagi dunia pendidikan.</p>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>

</html>

