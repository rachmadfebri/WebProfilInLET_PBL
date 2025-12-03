
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

<header>
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
    
    <style>
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
        
        @media (max-width: 768px) {
            .lang-switcher {
                margin-right: 10px;
            }
            
            .lang-btn {
                font-size: 0.8rem;
                padding: 4px 6px;
            }
            
            .dropdown-menu {
                position: fixed;
                left: 50%;
                top: 70px;
                min-width: 250px;
            }
        }
    </style>
    
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