<?php
class AdminController {
    public function dashboard() {
        session_start();
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        require __DIR__ . '/../views/admin/dashboard.php';
    }
}
