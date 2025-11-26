<?php
class AdminController {
     // Tambahkan constructor untuk memastikan sesi dimulai dengan aman HANYA sekali.
     public function __construct() {
         if (session_status() === PHP_SESSION_NONE) {
            session_start();
         }
     }

     public function dashboard() {
         // Hapus session_start() di sini karena sudah dipanggil di constructor
         if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
         }
         require __DIR__ . '/../views/admin/dashboard.php';
     }
}