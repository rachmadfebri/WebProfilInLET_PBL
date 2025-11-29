
<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<header>
    <div class="logo">
        <img src="img/logo.png" alt="Logo" class="img-logo">
    </div>

    <nav class="nav-pill">
        <div class="nav-indicator"></div>

        <ul>
            <li>
                <a href="index.php" class="nav-item <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">
                    Home
                </a>
            </li>
            <li>
                <a href="about.php" class="nav-item <?php echo $currentPage === 'about.php' ? 'active' : ''; ?>">
                    About
                </a>
            </li>
            <li>
                <a href="team.php" class="nav-item <?php echo $currentPage === 'team.php' ? 'active' : ''; ?>">
                    Team
                </a>
            </li>
            <li>
                <a href="<?php echo $currentPage === 'index.php' ? '#news' : 'index.php#news'; ?>" class="nav-item">
                    News
                </a>
            </li>
            <li>
                <a href="gallery.php" class="nav-item <?php echo $currentPage === 'gallery.php' ? 'active' : ''; ?>">
                    Gallery
                </a>
            </li>
        </ul>
    </nav>

    <div class="header-action">
        <a href="#" class="btn-form">
            <span>Form</span>
            <div class="circle-icon">
                <i class="fa-solid fa-chevron-right"></i>
            </div>
        </a>
    </div>
</header>