<?php
// app/controller/CollaborationController.php

require_once __DIR__ . '/../model/CollaborationModel.php'; 

class CollaborationController {
    private $collaborationModel;

    public function __construct(PDO $pdo) {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $this->collaborationModel = new CollaborationModel($pdo);
    }

    public function index() {
        // Pengecekan role admin
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        
        // Ambil keyword dari URL atau POST
        $keyword = $_GET['keyword'] ?? '';
        
        $collaborationList = $this->collaborationModel->getAll($keyword); 
        
        // Variabel yang akan tersedia di view
        $totalRecords = count($collaborationList);
        
        // Panggil View
        require __DIR__ . '/../views/admin/collaboration.php'; 
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
        // Hapus data
        $this->collaborationModel->delete($id);
        header("Location: index.php?page=collaboration");
        exit;
    }

    private function handleRequest($id = null) {
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        // 1. JIKA POST (Simpan Data)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $logoPath = '';
            
            if ($id) {
                $oldData = $this->collaborationModel->getById($id);
                $logoPath = $oldData['logo'];
            }

            // Cek Upload Logo Baru
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] == UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
                $newName = 'collab_' . time() . '.' . $ext;
                $uploadDir = __DIR__ . '/../../public/uploads/';
                
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadDir . $newName)) {
                    $logoPath = 'uploads/' . $newName; // Path yang disimpan di database
                }
            }

            $data = [
                'name' => $_POST['name'],
                'website' => $_POST['website'],
                'description' => $_POST['description'],
                'logo' => $logoPath
            ];

            if ($id) {
                $this->collaborationModel->update($id, $data);
            } else {
                $this->collaborationModel->create($data);
            }
            
            header("Location: index.php?page=collaboration");
            exit;
        }
        
        // 2. JIKA GET (Tampilkan Halaman)
        $collaborationList = $this->collaborationModel->getAll(); 
        if ($id) {
            $editData = $this->collaborationModel->getById($id); 
        }

        require __DIR__ . '/../views/admin/collaboration.php';
    }
}