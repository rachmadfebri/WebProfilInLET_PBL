<?php
// app/controller/StudentController.php

require_once __DIR__ . '/../model/StudentModel.php';

class StudentController {
    private $studentModel;

    public function __construct(PDO $pdo) {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $this->studentModel = new StudentModel($pdo);
    }

    public function index() {
        // 1. Cek Security: Hanya Admin yang boleh akses
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        // 2. Ambil Keyword Pencarian
        $keyword = $_GET['keyword'] ?? '';
        
        // 3. Ambil Data dari Model
        $studentList = $this->studentModel->getAll($keyword);
        $totalRecords = count($studentList); // Untuk statistik sederhana di view
        
        // 4. Panggil View Admin
        require __DIR__ . '/../views/admin/students.php'; 
    }

    public function delete($id) {
        // Cek Security
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        // Proses Hapus
        if ($id) {
            $this->studentModel->delete($id);
        }
        
        // Redirect kembali ke daftar
        header("Location: index.php?page=students");
        exit;
    }
}