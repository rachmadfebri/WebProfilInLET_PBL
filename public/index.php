<?php
// Start session for language preference
session_start();

// Handle language switching
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'id'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// --- 1. REQUIRE CONFIG & CONTROLLERS ---
require_once __DIR__ . '/../config/connection.php';

// --- CONTROLLERS ---
require_once __DIR__ . '/../app/controller/AuthController.php';
require_once __DIR__ . '/../app/controller/AdminController.php';
require_once __DIR__ . '/../app/controller/MahasiswaController.php';
require_once __DIR__ . '/../app/controller/galleryController.php';
require_once __DIR__ . '/../app/controller/NewsController.php';
require_once __DIR__ . '/../app/controller/ProductsController.php';
require_once __DIR__ . '/../app/controller/Collaborationcontroller.php';
require_once __DIR__ . '/../app/controller/ResearchController.php';
require_once __DIR__ . '/../app/controller/TeamMembersController.php';
require_once __DIR__ . '/../app/controller/AttendanceController.php';
require_once __DIR__ . '/../app/controller/AbsensiAdminController.php';
require_once __DIR__ . '/../app/controller/StudentController.php';
require_once __DIR__ . '/../app/controller/GuestbookController.php';

// --- 2. INISIALISASI DATABASE & CONTROLLER ---
$db = new Database();
$pdo = $db->connect();

$authController = new AuthController($pdo);
$adminController = new AdminController($pdo);
$mahasiswaController = new MahasiswaController();
$galleryController = new galleryController($pdo);
$newsController = new NewsController($pdo);
$productsController = new ProductsController($pdo);
$researchController = new ResearchController($pdo);
$collaborationController = new CollaborationController($pdo);
$teamMembersController = new TeamMembersController($pdo);
$attendanceController = new AttendanceController();
$absensiAdminController = new AbsensiAdminController();
$guestbookController = new GuestbookController($pdo);

// [BARU] Inisialisasi Student Controller
$studentController = new StudentController($pdo);

// --- 3. AMBIL PARAMETER URL ---
$page = $_GET['page'] ?? 'home'; // Nanti bisa diganti 'home' jika frontend sudah siap
$action = $_GET['action'] ?? null;

// --- 4. PROSES ACTION (POST REQUEST / ACTION BUTTONS) ---
if ($action) {
  if ($action === 'login') {
    $authController->login();
  } elseif ($action === 'register') {
    $authController->register();
  } elseif ($action === 'logout') {
    $authController->logout();
  } 
  // Routing Absensi
  elseif ($action === 'checkin') {
      $attendanceController->processCheckIn();
  } elseif ($action === 'checkout') {
      $attendanceController->processCheckOut();
  }
}


// --- ROUTING CRUD KHUSUS (Create, Edit, Delete) ---

// Routing Gallery
if ($page === 'gallery') {
    if ($action === 'create') { $galleryController->create(); exit; }
    elseif ($action === 'edit') { $galleryController->edit($_GET['id']); exit; }
    elseif ($action === 'delete') { $galleryController->delete($_GET['id']); exit; }
}

// Routing News
if ($page === 'news') {
    if ($action === 'create') { $newsController->create(); exit; }
    elseif ($action === 'edit') { $newsController->edit($_GET['id']); exit; }
    elseif ($action === 'delete') { $newsController->delete($_GET['id']); exit; }
}

// Routing Products
if ($page === 'products') {
    if ($action === 'create') { $productsController->create(); exit; }
    elseif ($action === 'edit') { $productsController->edit($_GET['id']); exit; }
    elseif ($action === 'delete') { $productsController->delete($_GET['id']); exit; }
}

// Routing Research
if ($page === 'research') {
    if ($action === 'create') { $researchController->create(); exit; }
    elseif ($action === 'edit') { $researchController->edit($_GET['id']); exit; }
    elseif ($action === 'delete') { $researchController->delete($_GET['id']); exit; }
}

// Routing Team
if ($page === 'team') {
    if ($action === 'create') { $teamMembersController->create(); exit; }
    elseif ($action === 'edit') { $teamMembersController->edit($_GET['id']); exit; }
    elseif ($action === 'delete') { $teamMembersController->delete($_GET['id']); exit; }
}

// Routing Collaboration
if ($page === 'collaboration') {
    if ($action === 'create') { $collaborationController->create(); exit; }
    elseif ($action === 'edit') { $collaborationController->edit($_GET['id']); exit; }
    elseif ($action === 'delete') { $collaborationController->delete($_GET['id']); exit; }
}

// [BARU] Routing Students (Hanya Delete, Create via Register)
if ($page === 'students' && $action === 'delete') {
    $studentController->delete($_GET['id']);
    exit;
}
if ($page === 'guestbook' && $action === 'delete') {
    $guestbookController->delete($_GET['id']);
    exit;
}

$viewDir = __DIR__ . '/../app/views/users/';

// --- 5. ROUTING VIEWS (SWITCH PAGE) ---
switch ($page) {
  // Auth Pages
  case 'login':
    require __DIR__ . '/../app/views/pages/sign-in.php';
    break;
  case 'register':
    require __DIR__ . '/../app/views/pages/sign-up.php';
    break;

   case 'home':
  case 'index': // Menangani default page
    require $viewDir . 'home.php'; // Memanggil home.php
    break;

  case 'about':
    require $viewDir . 'about.php'; // Memanggil about.php
    break;

  case 'teampublic':
    // Gunakan controller agar data tim diambil dari database
    $teamMembersController->publicIndex();
    break;

  case 'gallerypublic':
    // Opsi 1: Panggil langsung View (Cara Cepat)
    require $viewDir . 'gallerypublic.php';

    // Opsi 2: Jika ingin pakai Controller:
    // $galleryController->index();
    break;
  
  // Public Guestbook Page (menggunakan guestbook.php dari teman)
  case 'guestbook':
    require $viewDir . 'guestbook.php';
    break;

  case 'newspublic':
    // Opsi 1: Panggil langsung View (Cara Cepat)
    require $viewDir . 'newspublic.php';
    
    // Opsi 2: Jika ingin pakai Controller:
    // $newsController->index();
    break;

  // Research Detail Page
  case 'research-detail':
    require $viewDir . 'research-detail.php';
    break;

  // Dashboards
  case 'admin-dashboard':
    $adminController->dashboard();
    break;
  case 'mahasiswa-dashboard':
    $mahasiswaController->dashboard();
    break;
  
  // Profil Mahasiswa
  case 'profil':
    $mahasiswaController->profil();
    break;
 
  // Admin Features
  case 'gallery':
    $galleryController->index();
    break;
  case 'news':
    $newsController->index();
    break;
  case 'products':
    $productsController->index();
    break;
  case 'research':
    $researchController->index();
    break;
  case 'team':
    $teamMembersController->index();
    break;
  case 'collaboration':
    $collaborationController->index();
    break;
  case 'print-guestbook':
    $guestbookController->printReport();
    break;

  // [TAMBAHAN] Aksi Submit Tamu (Dipanggil dari form di halaman depan)
  // case 'submit-guestbook':
  //   $guestbookController->submit();
  //   break;

  // [BARU] Halaman Kelola Mahasiswa (Admin)
  case 'students':
    $studentController->index();
    break;

  // Halaman Kelola Buku Tamu (Admin)
  case 'admin-guestbook':
    if ($action === 'delete' && isset($_GET['id'])) {
        $guestbookController->delete($_GET['id']);
    } else {
        $guestbookController->index();
    }
    break;

  // Halaman Absensi (Admin)
  case 'absensi':
    $absensiAdminController->index();
    break;

  // News Detail Page
  case 'news-detail':
    require $viewDir . 'news-detail.php';
    break;

  default:
    echo "Page not found.";
    break;
}
?>