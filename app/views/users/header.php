
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

    <script>
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
    </script>
</header>