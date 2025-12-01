<?php

require_once __DIR__ . '/../model/StudentModel.php';

class StudentController {
    private $studentModel;

    public function __construct(PDO $pdo) {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $this->studentModel = new StudentModel($pdo);
    }

    public function index() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $keyword = $_GET['keyword'] ?? '';
        
        $studentList = $this->studentModel->getAll($keyword);
        $totalRecords = count($studentList); 
        
        require __DIR__ . '/../views/admin/students.php'; 
    }

    public function delete($id) {
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        if ($id) {
            $this->studentModel->delete($id);
        }
        
        header("Location: index.php?page=students");
        exit;
    }
}