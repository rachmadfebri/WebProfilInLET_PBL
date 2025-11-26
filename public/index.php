<?php
// --- 1. REQUIRE CONFIG & CONTROLLERS ---
require_once __DIR__ . '/../config/connection.php';
// Perhatikan: Folder controller/model di struktur Anda adalah singular (controller, model)
require_once __DIR__ . '/../app/controller/AuthController.php';
require_once __DIR__ . '/../app/controller/AdminController.php';
require_once __DIR__ . '/../app/controller/MahasiswaController.php';
require_once __DIR__ . '/../app/controller/galleryController.php';
require_once __DIR__ . '/../app/controller/NewsController.php';
require_once __DIR__ . '/../app/controller/AttendanceController.php';

// Inisialisasi Database
$db = new Database();
$pdo = $db->connect();

// Inisialisasi Controller
$authController = new AuthController($pdo);
$adminController = new AdminController();
$mahasiswaController = new MahasiswaController();
$galleryController = new galleryController($pdo);
$newsController = new NewsController($pdo);
$attendanceController = new AttendanceController();

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
    // --- TAMBAH ROUTING UNTUK ABSENSI ---
    elseif ($action === 'checkin') {
        $attendanceController->processCheckIn();
    } elseif ($action === 'checkout') {
        $attendanceController->processCheckOut();
    }
    // Tambahkan aksi untuk menghapus semua data absensi (hanya untuk Admin)
    // elseif ($action === 'clear-all-attendance') {
    //     // Pastikan ini hanya bisa diakses oleh Admin
    //     // Anda perlu implementasi otorisasi di dalam method ini
    //     $attendanceController->clearAllAttendance(); 
    // }
}

//routing gallery
if ($page === 'gallery' && $action === 'create') {
  $galleryController->create();
  exit;
} elseif ($page === 'gallery' && $action === 'edit') {
  $galleryController->edit($_GET['id']);
  exit;
} elseif ($page === 'gallery' && $action === 'delete') {
  $galleryController->delete($_GET['id']);
  exit;
}

//routing news
if ($page === 'news' && $action === 'create') {
  $newsController->create();
  exit;
} elseif ($page === 'news' && $action === 'edit') {
  $newsController->edit($_GET['id']);
  exit;
} elseif ($page === 'news' && $action === 'delete') {
  $newsController->delete($_GET['id']);
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
    $galleryController->index();
    break;
  case 'news':
    $newsController->index();
    break;
  case 'products':
    require __DIR__ . '/../app/views/admin/products.php';
    break;
  case 'research':
    require __DIR__ . '/../app/views/admin/research.php';
    break;
  case 'team':
    require __DIR__ . '/../app/views/admin/team.php';
    break;
  default:
    echo "Page not found.";
    break;
}

?>