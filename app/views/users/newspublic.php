<?php
// --- PHP LOGIC ---
try {
    // Sesuaikan path ini dengan struktur folder Anda
    require_once __DIR__ . '/../../model/newsModel.php'; 
    
    // Jika $pdo belum ada dari include lain, aktifkan baris ini:
    // include 'koneksi.php'; 

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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News List</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css"> 

    <style>
        /* --- CSS UPDATE --- */
        
        .news-wrapper * {
            box-sizing: border-box;
        }

        .news-wrapper {
            /* PERUBAHAN DISINI: Lebar maksimal diperbesar */
            max-width: 1200px; 
            width: 95%; /* Agar ada sedikit jarak di layar HP */
            margin: 0 auto;
            padding: 30px 20px;
            font-family: 'Poppins', sans-serif;
        }

        .news-page-title {
            text-align: center;
            font-size: 3rem; /* Judul diperbesar sedikit */
            font-weight: 900;
            margin-bottom: 40px;
            background: linear-gradient(to right, #2563eb, #d946ef);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            color: #2563eb; 
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* --- STYLE KARTU GLOBAL --- */
        .news-card-custom {
            background-color: #f8f9fa;
            border: 3px solid #3b82f6; 
            border-radius: 20px;      
            box-shadow: 0 8px 0 #e879f9; 
            margin-bottom: 30px;
            overflow: hidden;
            display: flex; 
            transition: transform 0.1s;
        }

        .news-card-custom:active {
            transform: translateY(4px);
            box-shadow: 0 4px 0 #e879f9;
        }

        /* --- 1. HERO ARTICLE (Berita Utama) --- */
        .hero-layout {
            flex-direction: row;
            align-items: center;
            padding: 25px; /* Padding lebih lega */
            min-height: 250px;
        }

        .hero-img-box {
            /* PERUBAHAN: Lebar gambar diatur agar tidak terlalu raksasa saat layar lebar */
            width: 350px; 
            height: 350px; 
            border-radius: 20px;
            overflow: hidden;
            flex-shrink: 0; 
            border: 2px solid #fff;
        }

        .hero-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-text-box {
            /* Mengisi sisa ruang */
            flex-grow: 1; 
            padding-left: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero-title {
            font-size: 2rem; /* Judul berita utama lebih besar */
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 15px;
            color: #000;
        }

        .hero-desc {
            font-size: 1rem;
            color: #444;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 4; /* Maksimal 4 baris teks */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* --- 2. LIST ARTICLE (Berita Kecil di Bawah) --- */
        .list-layout {
            padding: 15px;
            align-items: center;
            height: 110px;
        }

        .list-img-box {
            width: 80px; 
            height: 80px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .list-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .list-text-box {
            padding-left: 20px;
            flex-grow: 1;
            display: flex;
            align-items: center;
        }

        .list-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #000;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* --- RESPONSIVE (Untuk HP) --- */
        @media (max-width: 768px) {
            .hero-layout {
                flex-direction: column; /* HP: Gambar atas, teks bawah */
                text-align: center;
                padding: 20px;
                height: auto;
            }
            
            .hero-img-box {
                width: 100%; /* Gambar full width di HP */
                height: auto;
                aspect-ratio: 16/9;
                margin-bottom: 15px;
            }

            .hero-text-box {
                padding-left: 0;
                width: 100%;
            }

            .hero-title { font-size: 1.5rem; }
            .hero-desc { font-size: 0.9rem; -webkit-line-clamp: 3; }
        }

    </style>
</head>
<body>

    <?php include 'header.php'; ?> 
    
    <div class="news-wrapper">
        
        <h1 class="news-page-title">News</h1>
        
        <?php if (!empty($mainNews)): ?>
            
            <div class="news-card-custom hero-layout">
                <div class="hero-img-box">
                    <img src="<?php echo htmlspecialchars($mainNews['thumbnail'] ?? 'assets/images/placeholder.jpg'); ?>" alt="Main News">
                </div>
                <div class="hero-text-box">
                    <h2 class="hero-title"><?php echo htmlspecialchars($mainNews['title'] ?? 'No Title'); ?></h2>
                    <p class="hero-desc">
                        <?php echo htmlspecialchars(substr(strip_tags($mainNews['content'] ?? ''), 0, 250)); ?>...
                    </p>
                </div>
            </div>

            <?php foreach ($otherNews as $news): ?>
                <div class="news-card-custom list-layout">
                    <div class="list-img-box">
                        <img src="<?php echo htmlspecialchars($news['thumbnail'] ?? 'assets/images/placeholder.jpg'); ?>" alt="News List">
                    </div>
                    <div class="list-text-box">
                        <h3 class="list-title"><?php echo htmlspecialchars($news['title'] ?? 'No Title'); ?></h3>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <p style="text-align:center; color:#888;">Belum ada berita.</p>
        <?php endif; ?>

    </div>

    <?php include 'footer.php'; ?>

</body>
</html>