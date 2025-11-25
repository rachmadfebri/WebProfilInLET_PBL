<?php
// --- 1. REQUIRE CONFIG & CONTROLLERS ---
require_once __DIR__ . '/../config/connection.php';
// Perhatikan: Folder controller/model di struktur Anda adalah singular (controller, model)
require_once __DIR__ . '/../app/controller/AuthController.php'; 
require_once __DIR__ . '/../app/controller/AdminController.php'; 
require_once __DIR__ . '/../app/controller/MahasiswaController.php'; 

// Inisialisasi Database
$db = new Database();
$pdo = $db->connect();

// Inisialisasi Controller
$authController = new AuthController($pdo);
$adminController = new AdminController(); 
$mahasiswaController = new MahasiswaController();

// Ambil Parameter URL
$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? null;

// --- PROSES ACTION (POST REQUEST) ---
if ($action) {
    if ($action === 'login') {
        $authController->login();
    } elseif ($action === 'register') {
        $authController->register(); 
    } elseif ($action === 'logout') {
        $authController->logout();
    }
    exit;
}

switch ($page) {
    case 'login':
        // ... (kode yang sudah ada)
        require __DIR__ . '/../app/views/pages/sign-in.php'; 
        break;
        
    case 'register':
        // ... (kode yang sudah ada)
        require __DIR__ . '/../app/views/pages/sign-up.php';
        break;

    case 'admin-dashboard':
        $adminController->dashboard();
        break;

    case 'mahasiswa-dashboard':
        $mahasiswaController->dashboard();
        break;
    
    case 'gallery': 
        require __DIR__ . '/../app/views/admin/gallery.php'; 
        break;
    case 'proses_galeri':
        require __DIR__ . '/../app/views/admin/proses_galeri.php'; 
        break;
    case 'news':
        require __DIR__ . '/../app/views/admin/news.php';
        break;
    case 'proses_news':
        require __DIR__ . '/../app/views/admin/proses_news.php';
        break;
    case 'products':
        require __DIR__ . '/../app/views/admin/products.php';
        break;
    case 'proses_products':
        require __DIR__ . '/../app/views/admin/proses_products.php';
        break;
    case 'research':
        require __DIR__ . '/../app/views/admin/research.php';
        break;
    case 'proses_research':
        require __DIR__ . '/../app/views/admin/proses_research.php';
        break;
    case 'proses_research':
        require __DIR__ . '/../app/views/admin/proses_research.php';
        break;
    case 'team':
        require __DIR__ . '/../app/views/admin/team.php';
        break;
    case 'proses_team':
        require __DIR__ . '/../app/views/admin/proses_team.php';
        break;
    default:
        echo "Page not found.";
        break;
}

?>