<?php
// =================================================================
// 1. REQUIRE CONFIG & CONTROLLERS
// =================================================================
require_once __DIR__ . '/../config/connection.php';
// Perhatikan: Folder controller/model di struktur Anda adalah singular (controller, model)
require_once __DIR__ . '/../app/controller/AuthController.php'; 
require_once __DIR__ . '/../app/controller/AdminController.php'; 
require_once __DIR__ . '/../app/controller/MahasiswaController.php'; 

// =================================================================
// 2. INISIALISASI
// =================================================================
// Inisialisasi Database
$db = new Database();
$pdo = $db->connect();

// Inisialisasi Controller
$authController = new AuthController($pdo);
$adminController = new AdminController(); 
$mahasiswaController = new MahasiswaController();

// Ambil Parameter URL
// **DIUBAH:** Default page sekarang adalah 'index' (halaman utama)
$page = $_GET['page'] ?? 'index';
$action = $_GET['action'] ?? null;

// =================================================================
// 3. PROSES ACTION (POST REQUEST)
// =================================================================
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

// =================================================================
// 4. TAMPILKAN HALAMAN (GET REQUEST)
// =================================================================
switch ($page) {
    
    // --- START: ROUTING UNTUK HALAMAN PUBLIC (Folder users/) ---
    // Diakses: http://aplikasi.com/ atau http://aplikasi.com/?page=index
    case 'index':
        // Lokasi View: app/views/users/index.php
        require __DIR__ . '/../app/views/users/index.php'; 
        break;

    // Diakses: http://aplikasi.com/?page=about
    case 'about':
        // Lokasi View: app/views/users/about.php
        require __DIR__ . '/../app/views/users/about.php';
        break;

    // Diakses: http://aplikasi.com/?page=gallery
    case 'gallery':
        // Lokasi View: app/views/users/gallery.php
        require __DIR__ . '/../app/views/users/gallery.php';
        break;
        
    // Diakses: http://aplikasi.com/?page=team
    case 'team':
        // Lokasi View: app/views/users/team.php
        require __DIR__ . '/../app/views/users/team.php';
        break;
    // --- END: ROUTING UNTUK HALAMAN PUBLIC ---

    // --- START: AUTH PAGES ---
    case 'login':
        // Lokasi View: app/views/pages/sign-in.php
        require __DIR__ . '/../app/views/pages/sign-in.php'; 
        break;

    case 'register':
        // Lokasi View: app/views/pages/sign-up.php
        require __DIR__ . '/../app/views/pages/sign-up.php';
        break;
    // --- END: AUTH PAGES ---
        
    // --- START: DASHBOARDS ---
    case 'admin-dashboard':
        $adminController->dashboard();
        break;

    case 'mahasiswa-dashboard':
        $mahasiswaController->dashboard();
         break;
    // --- END: DASHBOARDS ---

    default:
        // Halaman tidak ditemukan
        header("HTTP/1.0 404 Not Found");
        require __DIR__ . '/../app/views/pages/404.php'; // Atau tampilkan pesan sederhana
        // echo "Page not found.";
        break;
}
?>