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

// --- TAMPILKAN HALAMAN (GET REQUEST) ---
switch ($page) {
    case 'login':
        // Lokasi View: app/views/pages/sign-in.php
        require __DIR__ . '/../app/views/pages/sign-in.php'; 
        break;

    case 'register':
        // Lokasi View: app/views/pages/sign-up.php
        require __DIR__ . '/../app/views/pages/sign-up.php';
        break;

    case 'admin-dashboard':
        $adminController->dashboard();
        break;

    case 'mahasiswa-dashboard':
        $mahasiswaController->dashboard();
        break;

    default:
        echo "Page not found.";
        break;
}
?>