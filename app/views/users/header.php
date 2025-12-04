
<?php 
    $currentPage = $_GET['page'] ?? 'home';
    // Language handling
    if (isset($_GET['lang'])) {
        $_SESSION['lang'] = $_GET['lang'];
    }
    $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
    
    // Translations
    $translations = array(
        'en' => array(
            'home' => 'Home',
            'about' => 'About',
            'explore' => 'Explore',
            'partners' => 'Partners',
            'products' => 'Products',
            'research' => 'Research',
            'team' => 'Team',
            'news' => 'News',
            'gallery' => 'Gallery',
            'guestbook' => 'Guestbook',
            'login' => 'Login'
        ),
        'id' => array(
            'home' => 'Beranda',
            'about' => 'Tentang',
            'explore' => 'Jelajahi',
            'partners' => 'Mitra',
            'products' => 'Produk',
            'research' => 'Riset',
            'team' => 'Tim',
            'news' => 'Berita',
            'gallery' => 'Galeri',
            'guestbook' => 'Buku Tamu',
            'login' => 'Masuk'
        )
    );
    $t = $translations[$lang];
?>

<!-- ============================================== -->
<!-- DESKTOP HEADER (Tampil hanya di layar >= 769px) -->
<!-- ============================================== -->
<header class="desktop-header">
    <div class="logo">
        <img src="assets/img/logo lab tanpa bg.png" alt="Logo" class="img-logo">
    </div>

    <nav class="nav-pill">
        <div class="nav-indicator"></div>

        <ul>
            <li>
                <a href="?page=home" class="nav-item <?php echo $currentPage === 'home' ? 'active' : ''; ?>">
                    <?php echo $t['home']; ?>
                </a>
            </li>
            <li>
                <a href="?page=about" class="nav-item <?php echo $currentPage === 'about' ? 'active' : ''; ?>">
                    <?php echo $t['about']; ?>
                </a>
            </li>
            <li class="nav-dropdown">
                <a href="#" class="nav-item nav-dropdown-toggle">
                    <?php echo $t['explore']; ?> <i class="fas fa-chevron-down"></i>
                </a>
                <div class="dropdown-menu">
                    <a href="?page=home#partners" class="dropdown-item">
                        <i class="fas fa-handshake"></i> <?php echo $t['partners']; ?>
                    </a>
                    <a href="?page=home#products" class="dropdown-item">
                        <i class="fas fa-laptop-code"></i> <?php echo $t['products']; ?>
                    </a>
                    <a href="?page=home#research" class="dropdown-item">
                        <i class="fas fa-flask"></i> <?php echo $t['research']; ?>
                    </a>
                </div>
            </li>
            <li>
                <a href="?page=teampublic" class="nav-item <?php echo $currentPage === 'teampublic' ? 'active' : ''; ?>">
                    <?php echo $t['team']; ?>
                </a>
            </li>
            <li>
                <a href="?page=newspublic" class="nav-item <?php echo $currentPage === 'newspublic' ? 'active' : ''; ?>">
                    <?php echo $t['news']; ?>
                </a>
            </li>
            <li>
                <a href="?page=gallerypublic" class="nav-item <?php echo $currentPage === 'gallerypublic' ? 'active' : ''; ?>">
                    <?php echo $t['gallery']; ?>
                </a>
            </li>
            <li>
                <a href="?page=guestbook" class="nav-item <?php echo $currentPage === 'guestbook' ? 'active' : ''; ?>">
                    <?php echo $t['guestbook']; ?>
                </a>
            </li>
        </ul>
    </nav>

    <div class="header-action">
        <!-- Language Switcher -->
        <div class="lang-switcher">
            <a href="?page=<?php echo $currentPage; ?>&lang=en" class="lang-btn <?php echo $lang === 'en' ? 'active' : ''; ?>">EN</a>
            <span class="lang-divider">|</span>
            <a href="?page=<?php echo $currentPage; ?>&lang=id" class="lang-btn <?php echo $lang === 'id' ? 'active' : ''; ?>">ID</a>
        </div>
        
        <a href="index.php?page=login" class="btn-form">
            <span><?php echo $t['login']; ?></span>
            <div class="circle-icon">
                <i class="fa-solid fa-chevron-right"></i>
            </div>
        </a>
    </div>
</header>

<!-- ============================================== -->
<!-- MOBILE HEADER (Tampil hanya di layar < 769px) -->
<!-- ============================================== -->
<header class="mobile-header">
    <div class="mobile-header-content">
        <!-- Logo -->
        <div class="mobile-logo">
            <img src="assets/img/logo lab tanpa bg.png" alt="Logo" class="img-logo">
        </div>
        
        <!-- Hamburger Menu Button -->
        <button class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle Menu">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
    </div>
</header>

<!-- Mobile Sidebar Overlay -->
<div class="mobile-sidebar-overlay" id="mobileSidebarOverlay"></div>

<!-- Mobile Sidebar -->
<nav class="mobile-sidebar" id="mobileSidebar">
    <div class="mobile-sidebar-header">
        <img src="assets/img/logo lab tanpa bg.png" alt="Logo" class="mobile-sidebar-logo">
        <button class="close-sidebar-btn" id="closeSidebarBtn" aria-label="Close Menu">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <ul class="mobile-nav-list">
        <li>
            <a href="?page=home" class="mobile-nav-item <?php echo $currentPage === 'home' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i>
                <span><?php echo $t['home']; ?></span>
            </a>
        </li>
        <li>
            <a href="?page=about" class="mobile-nav-item <?php echo $currentPage === 'about' ? 'active' : ''; ?>">
                <i class="fas fa-info-circle"></i>
                <span><?php echo $t['about']; ?></span>
            </a>
        </li>
        
        <!-- Explore Dropdown -->
        <li class="mobile-nav-dropdown">
            <button class="mobile-nav-item mobile-dropdown-toggle">
                <i class="fas fa-compass"></i>
                <span><?php echo $t['explore']; ?></span>
                <i class="fas fa-chevron-down dropdown-arrow"></i>
            </button>
            <ul class="mobile-dropdown-menu">
                <li>
                    <a href="?page=home#partners" class="mobile-dropdown-item">
                        <i class="fas fa-handshake"></i>
                        <span><?php echo $t['partners']; ?></span>
                    </a>
                </li>
                <li>
                    <a href="?page=home#products" class="mobile-dropdown-item">
                        <i class="fas fa-laptop-code"></i>
                        <span><?php echo $t['products']; ?></span>
                    </a>
                </li>
                <li>
                    <a href="?page=home#research" class="mobile-dropdown-item">
                        <i class="fas fa-flask"></i>
                        <span><?php echo $t['research']; ?></span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li>
            <a href="?page=teampublic" class="mobile-nav-item <?php echo $currentPage === 'teampublic' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i>
                <span><?php echo $t['team']; ?></span>
            </a>
        </li>
        <li>
            <a href="?page=newspublic" class="mobile-nav-item <?php echo $currentPage === 'newspublic' ? 'active' : ''; ?>">
                <i class="fas fa-newspaper"></i>
                <span><?php echo $t['news']; ?></span>
            </a>
        </li>
        <li>
            <a href="?page=gallerypublic" class="mobile-nav-item <?php echo $currentPage === 'gallerypublic' ? 'active' : ''; ?>">
                <i class="fas fa-images"></i>
                <span><?php echo $t['gallery']; ?></span>
            </a>
        </li>
        <li>
            <a href="?page=guestbook" class="mobile-nav-item <?php echo $currentPage === 'guestbook' ? 'active' : ''; ?>">
                <i class="fas fa-book"></i>
                <span><?php echo $t['guestbook']; ?></span>
            </a>
        </li>
    </ul>
    
    <!-- Mobile Sidebar Footer -->
    <div class="mobile-sidebar-footer">
        <!-- Language Switcher -->
        <div class="mobile-lang-switcher">
            <a href="?page=<?php echo $currentPage; ?>&lang=en" class="mobile-lang-btn <?php echo $lang === 'en' ? 'active' : ''; ?>">EN</a>
            <span class="mobile-lang-divider">|</span>
            <a href="?page=<?php echo $currentPage; ?>&lang=id" class="mobile-lang-btn <?php echo $lang === 'id' ? 'active' : ''; ?>">ID</a>
        </div>
        
        <!-- Login Button - Mirip dengan desktop -->
        <a href="index.php?page=login" class="mobile-login-btn">
            <span><?php echo $t['login']; ?></span>
            <div class="mobile-circle-icon">
                <i class="fa-solid fa-chevron-right"></i>
            </div>
        </a>
    </div>
</nav>
    
<style>
    /* ============================================== */
    /* DESKTOP HEADER STYLES */
    /* ============================================== */
    .desktop-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 50px;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        background-color: transparent;
    }
    
    /* Language Switcher */
    .lang-switcher {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-right: 15px;
    }
    
    .lang-btn {
        text-decoration: none;
        color: #666;
        font-weight: 500;
        font-size: 0.9rem;
        padding: 5px 8px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }
    
    .lang-btn:hover {
        color: #2d5bd4;
    }
    
    .lang-btn.active {
        color: white;
        background: linear-gradient(135deg, #2d5bd4, #d53f8c);
    }
    
    .lang-divider {
        color: #ccc;
    }
    
    .header-action {
        display: flex;
        align-items: center;
    }
    
    /* Dropdown Styles */
    .nav-dropdown {
        position: relative;
    }
    
    .nav-dropdown-toggle {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .nav-dropdown-toggle i {
        font-size: 0.7rem;
        transition: transform 0.3s ease;
    }
    
    .nav-dropdown:hover .nav-dropdown-toggle i {
        transform: rotate(180deg);
    }
    
    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(10px);
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        padding: 10px;
        min-width: 200px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
    }
    
    .nav-dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }
    
    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        color: #333;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.2s ease;
        font-weight: 500;
    }
    
    .dropdown-item:hover {
        background: linear-gradient(135deg, rgba(45, 91, 212, 0.1), rgba(213, 63, 140, 0.1));
        color: #2d5bd4;
    }
    
    .dropdown-item i {
        width: 20px;
        text-align: center;
        color: #2d5bd4;
    }
    
    /* ============================================== */
    /* MOBILE HEADER STYLES */
    /* ============================================== */
    .mobile-header {
        display: none; /* Default hidden, show on mobile */
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1001;
        background: white;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }
    
    .mobile-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
    }
    
    .mobile-logo {
        display: flex;
        align-items: center;
    }
    
    .mobile-logo .img-logo {
        height: 40px;
        width: auto;
    }
    
    /* Hamburger Button */
    .hamburger-btn {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 28px;
        height: 20px;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 0;
        z-index: 1003;
    }
    
    .hamburger-line {
        display: block;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #2d5bd4, #d53f8c);
        border-radius: 3px;
        transition: all 0.3s ease;
    }
    
    .hamburger-btn.active .hamburger-line:nth-child(1) {
        transform: translateY(8.5px) rotate(45deg);
    }
    
    .hamburger-btn.active .hamburger-line:nth-child(2) {
        opacity: 0;
    }
    
    .hamburger-btn.active .hamburger-line:nth-child(3) {
        transform: translateY(-8.5px) rotate(-45deg);
    }
    
    /* Mobile Sidebar Overlay */
    .mobile-sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1001;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .mobile-sidebar-overlay.active {
        display: block;
        opacity: 1;
    }
    
    /* Mobile Sidebar */
    .mobile-sidebar {
        position: fixed;
        top: 0;
        right: -300px;
        width: 280px;
        max-width: 85vw;
        height: 100vh;
        background: white;
        z-index: 1002;
        transition: right 0.3s ease;
        display: flex;
        flex-direction: column;
        box-shadow: -5px 0 20px rgba(0,0,0,0.1);
    }
    
    .mobile-sidebar.active {
        right: 0;
    }
    
    .mobile-sidebar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .mobile-sidebar-logo {
        height: 35px;
        width: auto;
    }
    
    .close-sidebar-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #f5f5f5;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #666;
        transition: all 0.3s ease;
    }
    
    .close-sidebar-btn:hover {
        background: linear-gradient(135deg, #2d5bd4, #d53f8c);
        color: white;
    }
    
    /* Mobile Navigation List */
    .mobile-nav-list {
        list-style: none;
        margin: 0;
        padding: 15px 0;
        flex: 1;
        overflow-y: auto;
    }
    
    .mobile-nav-list li {
        margin: 0;
    }
    
    .mobile-nav-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 14px 25px;
        text-decoration: none;
        color: #333;
        font-weight: 500;
        font-size: 1rem;
        transition: all 0.2s ease;
        border: none;
        background: transparent;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }
    
    .mobile-nav-item i {
        width: 20px;
        text-align: center;
        color: #2d5bd4;
        font-size: 1rem;
    }
    
    .mobile-nav-item:hover,
    .mobile-nav-item.active {
        background: linear-gradient(90deg, rgba(45, 91, 212, 0.1), rgba(213, 63, 140, 0.05));
        color: #2d5bd4;
    }
    
    .mobile-nav-item.active {
        border-left: 4px solid #2d5bd4;
        padding-left: 21px;
    }
    
    /* Mobile Dropdown */
    .mobile-nav-dropdown {
        position: relative;
    }
    
    .mobile-dropdown-toggle {
        justify-content: flex-start;
    }
    
    .mobile-dropdown-toggle .dropdown-arrow {
        margin-left: auto;
        font-size: 0.8rem;
        transition: transform 0.3s ease;
    }
    
    .mobile-nav-dropdown.open .dropdown-arrow {
        transform: rotate(180deg);
    }
    
    .mobile-dropdown-menu {
        list-style: none;
        margin: 0;
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        background: #f9f9f9;
    }
    
    .mobile-nav-dropdown.open .mobile-dropdown-menu {
        max-height: 300px;
    }
    
    .mobile-dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 25px 12px 60px;
        text-decoration: none;
        color: #555;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    
    .mobile-dropdown-item i {
        width: 18px;
        text-align: center;
        color: #2d5bd4;
        font-size: 0.9rem;
    }
    
    .mobile-dropdown-item:hover {
        background: linear-gradient(90deg, rgba(45, 91, 212, 0.1), rgba(213, 63, 140, 0.05));
        color: #2d5bd4;
    }
    
    /* Mobile Sidebar Footer */
    .mobile-sidebar-footer {
        padding: 20px;
        border-top: 1px solid #eee;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .mobile-lang-switcher {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        background: #f8f9fa;
        padding: 8px 15px;
        border-radius: 25px;
    }
    
    .mobile-lang-btn {
        text-decoration: none;
        color: #666;
        font-weight: 500;
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }
    
    .mobile-lang-btn:hover {
        color: #2d5bd4;
    }
    
    .mobile-lang-btn.active {
        color: white;
        background: linear-gradient(135deg, #2d5bd4, #d53f8c);
    }
    
    .mobile-lang-divider {
        color: #ccc;
        font-weight: 300;
    }
    
    /* Mobile Login Button - Mirip dengan desktop .btn-form */
    .mobile-login-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 5px 5px 5px 25px;
        background: white;
        color: #333;
        text-decoration: none;
        font-weight: 500;
        font-size: 1rem;
        border-radius: 50px;
        border: 2px solid #2d5bd4;
        transition: all 0.3s ease;
        min-width: 140px;
    }
    
    .mobile-login-btn:hover {
        border-color: #d53f8c;
        color: #d53f8c;
    }
    
    .mobile-login-btn .mobile-circle-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2d5bd4, #d53f8c);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }
    
    .mobile-login-btn .mobile-circle-icon i {
        font-size: 0.9rem;
        color: white;
    }
    
    /* Mobile Nav Item hover dengan gradient */
    .mobile-nav-item:hover,
    .mobile-nav-item.active {
        background: linear-gradient(90deg, rgba(45, 91, 212, 0.1), rgba(213, 63, 140, 0.05));
        color: #2d5bd4;
    }
    
    .mobile-nav-item:hover i,
    .mobile-nav-item.active i {
        background: linear-gradient(135deg, #2d5bd4, #d53f8c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* ============================================== */
    /* RESPONSIVE: Show/Hide Desktop vs Mobile */
    /* ============================================== */
    @media (max-width: 768px) {
        /* Hide desktop header on mobile */
        .desktop-header {
            display: none !important;
        }
        
        /* Show mobile header on mobile */
        .mobile-header {
            display: block !important;
        }
        
        /* Adjust body padding for mobile header */
        body {
            padding-top: 70px !important;
        }
    }
    
    @media (min-width: 769px) {
        /* Show desktop header on desktop */
        .desktop-header {
            display: flex !important;
        }
        
        /* Hide mobile elements on desktop */
        .mobile-header,
        .mobile-sidebar,
        .mobile-sidebar-overlay {
            display: none !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ============================================
        // DESKTOP NAV INDICATOR
        // ============================================
        const navPill = document.querySelector('.nav-pill');
        const indicator = document.querySelector('.nav-indicator');
        const navItems = document.querySelectorAll('.desktop-header .nav-item');

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

            const activeItem = document.querySelector('.desktop-header .nav-item.active') || navItems[0];
            if (activeItem) {
                handleIndicator(activeItem);
            }
        }
        
        // ============================================
        // MOBILE SIDEBAR TOGGLE
        // ============================================
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const mobileSidebarOverlay = document.getElementById('mobileSidebarOverlay');
        
        function openMobileSidebar() {
            mobileSidebar.classList.add('active');
            mobileSidebarOverlay.classList.add('active');
            hamburgerBtn.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeMobileSidebar() {
            mobileSidebar.classList.remove('active');
            mobileSidebarOverlay.classList.remove('active');
            hamburgerBtn.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        if (hamburgerBtn) {
            hamburgerBtn.addEventListener('click', function() {
                if (mobileSidebar.classList.contains('active')) {
                    closeMobileSidebar();
                } else {
                    openMobileSidebar();
                }
            });
        }
        
        if (closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', closeMobileSidebar);
        }
        
        if (mobileSidebarOverlay) {
            mobileSidebarOverlay.addEventListener('click', closeMobileSidebar);
        }
        
        // ============================================
        // MOBILE DROPDOWN TOGGLE
        // ============================================
        const mobileDropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');
        
        mobileDropdownToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const parent = this.closest('.mobile-nav-dropdown');
                parent.classList.toggle('open');
            });
        });
        
        // Close sidebar when clicking nav links
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-item:not(.mobile-dropdown-toggle), .mobile-dropdown-item');
        mobileNavLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                setTimeout(closeMobileSidebar, 150);
            });
        });
    });
</script>