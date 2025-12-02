<?php
    $year = date('Y');
?>

<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <img src="assets/img/logo lab tanpa bg.png" alt="Learning Engineering Technology" class="footer-logo">
            <div class="footer-text">
                <h3>Information and Learning Engineering Technology</h3>
                <p>Designing research-based learning experiences and digital products.</p>
            </div>
        </div>

        <div class="footer-links">
            <div class="footer-column">
                <p class="footer-label">Explore</p>
                <a href="index.php?page=home">Home</a>
                <a href="index.php?page=about">About</a>
                <a href="index.php?page=teampublic">Team</a>
                <a href="index.php?page=newspublic">News</a>
                <a href="index.php?page=gallerypublic">Gallery</a>
            </div>

            <div class="footer-column">
                <p class="footer-label">Connect</p>
                <a href="index.php?page=guestbook">Guestbook</a>
                <a href="index.php?page=login">Admin Login</a>
            </div>

            <div class="footer-column">
                <p class="footer-label">Location</p>
                <div class="footer-address">
                    <p><i class="fas fa-map-marker-alt"></i> Universitas Brawijaya</p>
                    <p><i class="fas fa-building"></i> Fakultas Ilmu Komputer</p>
                    <p><i class="fas fa-envelope"></i> contact@let.ub.ac.id</p>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-content">
            <span>&copy; <?php echo $year; ?> Information and Learning Engineering Technology • All rights reserved.</span>
            <div class="footer-map-mini">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.4479573778096!2d112.61301391477464!3d-7.951676794289586!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78827687d272e7%3A0x789ce9a636cd3aa2!2sFaculty%20of%20Computer%20Science%2C%20Brawijaya%20University!5e0!3m2!1sen!2sid!4v1701234567890!5m2!1sen!2sid" 
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


