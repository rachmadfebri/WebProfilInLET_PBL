<?php
// app/controller/ResearchController.php

require_once __DIR__ . '/../model/ResearchModel.php'; 

class ResearchController {
    private $researchModel;

    public function __construct(PDO $pdo) {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $this->researchModel = new ResearchModel($pdo);
    }

    public function index() {
        // Pengecekan role admin
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        $researchList = $this->researchModel->getAll(); 
        require __DIR__ . '/../views/admin/research.php'; 
    }

    public function create() {
        $this->handleRequest(null);
    }

    public function edit($id) {
        $this->handleRequest($id);
    }

    public function delete($id) {
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        // Hapus data riset
        $this->researchModel->delete($id);
        header("Location: index.php?page=research");
        exit;
    }

    // Fungsi Gabungan untuk Create dan Edit (agar rapi)
    private function handleRequest($id = null) {
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        // 1. JIKA POST (Simpan Data)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = '';
            
            // Jika Edit, ambil path lama dulu
            if ($id) {
                $oldData = $this->researchModel->getById($id);
                $imagePath = $oldData['image']; // image adalah nama kolom di DB
            }

            // Cek Upload Gambar Baru (Thumbnail)
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $newName = 'research_' . time() . '.' . $ext;
                $uploadDir = __DIR__ . '/../../public/uploads/';
                
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $newName)) {
                    $imagePath = 'uploads/' . $newName; // Path yang disimpan di database
                }
            }

            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'image' => $imagePath
            ];

            if ($id) {
                $this->researchModel->update($id, $data);
            } else {
                $this->researchModel->create($data);
            }
            
            header("Location: index.php?page=research");
            exit;
        }

        // 2. JIKA GET (Tampilkan Halaman)
        $researchList = $this->researchModel->getAll(); // Ambil list untuk tabel
        
        if ($id) {
            $editData = $this->researchModel->getById($id); // Data spesifik untuk form edit
        }
        // Pastikan variabel $editData ada di scope view jika mode edit aktif

        require __DIR__ . '/../views/admin/research.php';
    }
}