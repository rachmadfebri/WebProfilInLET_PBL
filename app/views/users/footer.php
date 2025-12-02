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
        </div>
    </div>

    <div class="footer-bottom">
        <span>&copy; <?php echo $year; ?> Information and Learning Engineering Technology • All rights reserved.</span>
    </div>
</footer>


