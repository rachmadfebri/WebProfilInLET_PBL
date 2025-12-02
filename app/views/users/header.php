
<?php 
    $currentPage = $_GET['page'] ?? 'home';
?>

<header>
    <div class="logo">
        <img src="assets/img/logo lab tanpa bg.png" alt="Logo" class="img-logo">
    </div>

    <nav class="nav-pill">
        <div class="nav-indicator"></div>

        <ul>
            <li>
                <a href="?page=home" class="nav-item <?php echo $currentPage === 'home' ? 'active' : ''; ?>">
                    Home
                </a>
            </li>
            <li>
                <a href="?page=about" class="nav-item <?php echo $currentPage === 'about' ? 'active' : ''; ?>">
                    About
                </a>
            </li>
            <li>
                <a href="?page=teampublic" class="nav-item <?php echo $currentPage === 'teampublic' ? 'active' : ''; ?>">
                    Team
                </a>
            </li>
            <li>
                <a href="?page=newspublic" class="nav-item <?php echo $currentPage === 'newspublic' ? 'active' : ''; ?>">
                    News
                </a>
            </li>
            <li>
                <a href="?page=gallerypublic" class="nav-item <?php echo $currentPage === 'gallerypublic' ? 'active' : ''; ?>">
                    Gallery
                </a>
            </li>
            <li>
                <a href="?page=guestbook" class="nav-item <?php echo $currentPage === 'guestbook' ? 'active' : ''; ?>">
                    Guestbook
                </a>
            </li>
        </ul>
    </nav>

    <div class="header-action">
        <a href="index.php?page=login" class="btn-form">
            <span>Login</span>
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