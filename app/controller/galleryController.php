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

        // 1. Ambil Keyword Pencarian dari URL
        // User bisa mengetik tanggal (misal: "2024-05")
        $keyword = $_GET['keyword'] ?? '';

        // 2. Panggil Model dengan Keyword
        // (Pastikan GalleryModel::getAll sudah diupdate untuk menerima $keyword)
        $galleries = $this->galleryModel->getAll($keyword); 
        
        // 3. Panggil View
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
        
        // Hapus file fisik (Opsional: agar server tidak penuh)
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

    // Fungsi gabungan untuk Create & Edit (Agar tabel tetap muncul di belakang popup)
    private function handleRequest($id = null) {
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        // --- PROSES SIMPAN (POST) ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = '';
            
            // Jika Edit, ambil path lama dulu sebagai default
            if ($id) {
                $oldData = $this->galleryModel->getById($id);
                $imagePath = $oldData['image']; 
            }

            // Cek Upload Gambar Baru
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
                $this->galleryModel->create($imagePath);
            }
            
            header("Location: index.php?page=gallery");
            exit;
        }

        // --- TAMPILKAN HALAMAN (GET) ---
        // Ambil data list juga agar tabel di background tetap muncul saat popup edit aktif
        $keyword = $_GET['keyword'] ?? '';
        $galleries = $this->galleryModel->getAll($keyword); 
        
        if ($id) {
            $editData = $this->galleryModel->getById($id);
        }

        require __DIR__ . '/../views/admin/gallery.php';
    }
}