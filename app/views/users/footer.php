<?php
    $year = date('Y');
    $lang = $_SESSION['lang'] ?? 'en';
    
    $footerTrans = array(
        'en' => array(
            'tagline' => 'Designing research-based learning experiences and digital products.',
            'explore' => 'Explore',
            'home' => 'Home',
            'about' => 'About',
            'team' => 'Team',
            'news' => 'News',
            'gallery' => 'Gallery',
            'connect' => 'Connect',
            'guestbook' => 'Guestbook',
            'admin_login' => 'Admin Login',
            'location' => 'Location',
            'copyright' => 'All rights reserved.'
        ),
        'id' => array(
            'tagline' => 'Merancang pengalaman belajar dan produk digital berbasis riset.',
            'explore' => 'Jelajahi',
            'home' => 'Beranda',
            'about' => 'Tentang',
            'team' => 'Tim',
            'news' => 'Berita',
            'gallery' => 'Galeri',
            'connect' => 'Hubungi',
            'guestbook' => 'Buku Tamu',
            'admin_login' => 'Login Admin',
            'location' => 'Lokasi',
            'copyright' => 'Hak cipta dilindungi.'
        )
    );
    $ft = $footerTrans[$lang];
?>

<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <img src="assets/img/logo lab tanpa bg.png" alt="Learning Engineering Technology" class="footer-logo">
            <div class="footer-text">
                <h3>Information and Learning Engineering Technology</h3>
                <p><?php echo $ft['tagline']; ?></p>
            </div>
        </div>

        <div class="footer-links">
            <div class="footer-column">
                <p class="footer-label"><?php echo $ft['explore']; ?></p>
                <a href="index.php?page=home"><?php echo $ft['home']; ?></a>
                <a href="index.php?page=about"><?php echo $ft['about']; ?></a>
                <a href="index.php?page=teampublic"><?php echo $ft['team']; ?></a>
                <a href="index.php?page=newspublic"><?php echo $ft['news']; ?></a>
                <a href="index.php?page=gallerypublic"><?php echo $ft['gallery']; ?></a>
            </div>

            <div class="footer-column">
                <p class="footer-label"><?php echo $ft['connect']; ?></p>
                <a href="index.php?page=guestbook"><?php echo $ft['guestbook']; ?></a>
                <a href="index.php?page=login"><?php echo $ft['admin_login']; ?></a>
            </div>

            <div class="footer-column">
                <p class="footer-label"><?php echo $ft['location']; ?></p>
                <div class="footer-address">
                    <p><i class="fas fa-map-marker-alt"></i> Politeknik Negeri Malang</p>
                    <p><i class="fas fa-building"></i> Jurusan Teknologi Informasi</p>
                    <p><i class="fas fa-envelope"></i> jti@polinema.ac.id</p>
                    <p><i class="fas fa-phone"></i> (0341) 404424</p>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-content">
            <span>&copy; <?php echo $year; ?> Information and Learning Engineering Technology - <?php echo $ft['copyright']; ?></span>
            <div class="footer-map-mini">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.2904744648584!2d112.61606731534065!3d-7.963632094269095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7882781d0d10fb%3A0x33d89d9bc2d5f8fc!2sPoliteknik%20Negeri%20Malang!5e0!3m2!1sen!2sid!4v1701234567890!5m2!1sen!2sid" 
                    width="250" 
                    height="150" 
                    style="border:0; border-radius: 10px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-column {
        margin-bottom: 30px;
    }

    .footer-address {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .footer-address p {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        color: #666;
        font-size: 0.9rem;
    }

    .footer-address i {
        color: #667eea;
        width: 16px;
    }

    .footer-bottom {
        border-top: 1px solid #eee;
        padding: 20px 0;
        margin-top: 40px;
    }

    .footer-bottom-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
    }

    .footer-map-mini {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .map-container h4 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 30px;
        color: #333;
    }

    .map-wrapper {
        background: white;
        border-radius: 20px;
        padding: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 1px solid #f0f0f0;
    }

    @media (max-width: 768px) {
        .footer-inner {
            flex-direction: column;
            text-align: center;
        }

        .footer-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .footer-bottom-content {
            flex-direction: column;
            gap: 20px;
        }

        .footer-map-mini iframe {
            width: 200px;
            height: 120px;
        }
    }
</style>


