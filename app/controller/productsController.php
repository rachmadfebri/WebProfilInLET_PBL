<?php
require_once __DIR__ . '/../model/ProductsModel.php'; 

class ProductsController {
    private $productsModel;

    public function __construct(PDO $pdo) {
        $this->productsModel = new ProductsModel($pdo);
    }

    public function index() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        $productsList = $this->productsModel->getAll(); 
        require __DIR__ . '/../views/admin/products.php'; 
    }

    public function create() {
        $this->handleRequest(null);
    }

    public function edit($id) {
        $this->handleRequest($id);
    }

    public function delete($id) {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        $this->productsModel->delete($id);
        header("Location: index.php?page=products");
        exit;
    }

    private function handleRequest($id = null) {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        // 1. JIKA POST (Simpan Data)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $thumbnailPath = '';
            
            // Ambil gambar lama jika edit dan tidak ada gambar baru
            if ($id) {
                $oldData = $this->productsModel->getById($id);
                $thumbnailPath = $oldData['thumbnail'];
            }

            // Proses Upload Gambar Baru
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
                $newName = 'products_' . time() . '.' . $ext;
                $uploadDir = __DIR__ . '/../../public/uploads/';
                
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadDir . $newName)) {
                    $thumbnailPath = 'uploads/' . $newName;
                }
            }

            // DATA YANG DIKIRIM KE MODEL
            // Pastikan 'url' diambil dari $_POST['url_product']
            $data = [
                'title'       => $_POST['title'],
                'description' => $_POST['description'],
                'url'         => $_POST['url'] ?? '', // Tangkap URL di sini
                'thumbnail'   => $thumbnailPath
            ];

            if ($id) {
                $this->productsModel->update($id, $data);
            } else {
                $this->productsModel->create($data);
            }
            
            header("Location: index.php?page=products");
            exit;
        }

        // 2. JIKA GET (Tampilkan View)
        $productsList = $this->productsModel->getAll(); 
        
        if ($id) {
            $editData = $this->productsModel->getById($id);
        }

        require __DIR__ . '/../views/admin/products.php';
    }
}