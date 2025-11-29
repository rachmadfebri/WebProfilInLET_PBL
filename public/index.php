<?php
// =================================================================
// 1. REQUIRE CONFIG & CONTROLLERS
// =================================================================
require_once __DIR__ . '/../config/connection.php';
// Perhatikan: Folder controller/model di struktur Anda adalah singular (controller, model)
require_once __DIR__ . '/../app/controller/AuthController.php';
require_once __DIR__ . '/../app/controller/AdminController.php';
require_once __DIR__ . '/../app/controller/MahasiswaController.php';
require_once __DIR__ . '/../app/controller/galleryController.php';
require_once __DIR__ . '/../app/controller/NewsController.php';
require_once __DIR__ . '/../app/controller/ProductsController.php';
require_once __DIR__ . '/../app/controller/Collaborationcontroller.php';
require_once __DIR__ . '/../app/controller/ResearchController.php';
require_once __DIR__ . '/../app/controller/TeamMembersController.php';
// --- TAMBAH CONTROLLER ABSENSI (ATTENDANCE) ---
require_once __DIR__ . '/../app/controller/AttendanceController.php';

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
$galleryController = new galleryController($pdo);
$newsController = new NewsController($pdo);
$productsController = new ProductsController($pdo);
$researchController = new ResearchController($pdo);
$collaborationController = new CollaborationController($pdo);
$teamMembersController = new TeamMembersController($pdo);
// --- TAMBAH INIALISASI ATTENDANCE CONTROLLER ---
$attendanceController = new AttendanceController();

// Ambil Parameter URL
$page = $_GET['page'] ?? 'home';
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

//routing products
if ($page === 'products' && $action === 'create') {
  $productsController->create();
  exit;
} elseif ($page === 'products' && $action === 'edit') {
  $productsController->edit($_GET['id']);
  exit;
} elseif ($page === 'products' && $action === 'delete') {
  $productsController->delete($_GET['id']);
  exit;
}

//routing riset
if ($page === 'research' && $action === 'create') {
  $researchController->create();
  exit;
} elseif ($page === 'research' && $action === 'edit') {
  $researchController->edit($_GET['id']);
  exit;
} elseif ($page === 'research' && $action === 'delete') {
  $researchController->delete($_GET['id']);
  exit;
}

//routing tim
if ($page === 'team' && $action === 'create') {
  $teamMembersController->create();
  exit;
} elseif ($page === 'team' && $action === 'edit') {
  $teamMembersController->edit($_GET['id']);
  exit;
} elseif ($page === 'team' && $action === 'delete') {
  $teamMembersController->delete($_GET['id']);
  exit;
}

//routing collaboration
if ($page === 'collaboration' && $action === 'create') {
  $collaborationController->create();
  exit;
} elseif ($page === 'collaboration' && $action === 'edit') {
  $collaborationController->edit($_GET['id']);
  exit;
} elseif ($page === 'collaboration' && $action === 'delete') {
  $collaborationController->delete($_GET['id']);
  exit;
}

// ... (kode atas biarkan sama) ...

// Definisikan path folder view agar lebih rapi
$viewDir = __DIR__ . '/../app/views/users/';

switch ($page) {
  case 'login':
    require __DIR__ . '/../app/views/pages/sign-in.php';
    break;
   
  case 'register':
    require __DIR__ . '/../app/views/pages/sign-up.php';
    break;

  // --- ROUTING HALAMAN UTAMA (USER) ---
  case 'home':
  case 'index': // Menangani default page
    require $viewDir . 'home.php'; // Memanggil home.php
    break;

  case 'about':
    require $viewDir . 'about.php'; // Memanggil about.php
    break;

  case 'team':
    // Opsi 1: Panggil langsung View (Cara Cepat)
    require $viewDir . 'team.php';
    
    // Opsi 2: Jika ingin pakai Controller (MVC Murni), gunakan ini:
    // $teamMembersController->index(); 
    break;

  case 'gallery':
    // Opsi 1: Panggil langsung View (Cara Cepat)
    require $viewDir . 'gallery.php';

    // Opsi 2: Jika ingin pakai Controller:
    // $galleryController->index();
    break;

  // --- HALAMAN DASHBOARD ADMIN/MAHASISWA ---
  case 'admin-dashboard':
    $adminController->dashboard();
    break;

  case 'mahasiswa-dashboard':
    $mahasiswaController->dashboard();
    break;

  // ... (routing news, products, dll biarkan atau sesuaikan jika perlu) ...
  case 'news':
    $newsController->index();
    break;
  case 'products':
    $productsController->index();
    break;
  case 'research':
    $researchController->index();
    break;
  case 'collaboration':
    $collaborationController->index();
    break;
    
  default:
    // Set default ke home jika page tidak ditemukan atau kosong
    if (empty($page)) {
        require $viewDir . 'home.php';
    } else {
        echo "Page not found.";
    }
    break;
}
?>