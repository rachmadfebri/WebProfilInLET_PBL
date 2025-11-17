<?php
class MahasiswaController {
    public function dashboard() {
        session_start();
        if ($_SESSION['role'] !== 'mahasiswa') {
            header("Location: ?page=login");
            exit;
        }
        require __DIR__ . '/../views/mahasiswa/dashboard.php';
    }
}
