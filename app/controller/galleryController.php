<?php
require_once __DIR__ . '/../model/GalleryModel.php'; 

class GalleryController {
    private $galleryModel;

    public function __construct(PDO $pdo) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->galleryModel = new GalleryModel($pdo);
    }

    public function index() {
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $keyword = $_GET['keyword'] ?? '';
        $galleries = $this->galleryModel->getAll($keyword); 
        
        require __DIR__ . '/../views/admin/gallery.php';
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
        
        $data = $this->galleryModel->getById($id);
        if ($data && !empty($data['image'])) {
            $filePath = __DIR__ . '/../../public/' . $data['image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $this->galleryModel->delete($id);
        header("Location: index.php?page=gallery"); 
        exit;
    }

    private function handleRequest($id = null) {
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = '';
            
            if ($id) {
                $oldData = $this->galleryModel->getById($id);
                $imagePath = $oldData['image']; 
            }

            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $newName = 'galeri_' . time() . '.' . $ext;
                $uploadDir = __DIR__ . '/../../public/uploads/';
                
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $newName)) {
                    $imagePath = 'uploads/' . $newName;
                }
            }

            if ($id) {
                $this->galleryModel->update($id, $imagePath);
            } else {
                $userId = $_SESSION['user_id'] ?? null;
                
                $this->galleryModel->create($imagePath, $userId);
            }
            
            header("Location: index.php?page=gallery");
            exit;
        }

        $keyword = $_GET['keyword'] ?? '';
        $galleries = $this->galleryModel->getAll($keyword); 
        
        if ($id) {
            $editData = $this->galleryModel->getById($id);
        }

        require __DIR__ . '/../views/admin/gallery.php';
    }
}