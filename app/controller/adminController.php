<?php
// app/controller/AdminController.php

// Load semua model yang ingin dihitung datanya
require_once __DIR__ . '/../model/ProductsModel.php';
require_once __DIR__ . '/../model/ResearchModel.php';
require_once __DIR__ . '/../model/StudentModel.php';
require_once __DIR__ . '/../model/TeamMembersModel.php';

class AdminController {
    private $productsModel;
    private $researchModel;
    private $studentModel;
    private $teamModel;

    // Terima koneksi PDO di constructor
    public function __construct($pdo) {
        $this->productsModel = new ProductsModel($pdo);
        $this->researchModel = new ResearchModel($pdo);
        $this->studentModel = new StudentModel($pdo);
        $this->teamModel = new TeamMembersModel($pdo);
    }

    public function dashboard() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        
        // Cek Login Admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        // Hitung Jumlah Data (Count)
        // Catatan: Jika data sangat banyak, sebaiknya buat fungsi countAll() khusus di Model agar lebih ringan.
        // Tapi untuk skala kecil/menengah, count(getAll()) masih aman.
        
        $totalProducts = count($this->productsModel->getAll());
        $totalResearch = count($this->researchModel->getAll());
        $totalStudents = count($this->studentModel->getAll());
        $totalTeam     = count($this->teamModel->getAll());

        // Kirim variable ke View
        require __DIR__ . '/../views/admin/dashboard.php';
    }
}