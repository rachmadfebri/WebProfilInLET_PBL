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

        $keyword = $_GET['keyword'] ?? '';
        $productsList = $this->productsModel->getAll($keyword); 

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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $thumbnailPath = '';
            
            if ($id) {
                $oldData = $this->productsModel->getById($id);
                $thumbnailPath = $oldData['thumbnail'];
            }

            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
                $newName = 'products_' . time() . '.' . $ext;
                $uploadDir = __DIR__ . '/../../public/uploads/';
                
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadDir . $newName)) {
                    $thumbnailPath = 'uploads/' . $newName;
                }
            }

            $currentUserId = $_SESSION['user_id'] ?? $_SESSION['id'] ?? null; 

            $data = [
                'title'       => $_POST['title'],
                'description' => $_POST['description'],
                'url'         => $_POST['url'] ?? '', 
                'thumbnail'   => $thumbnailPath,
                'user_id'     => $currentUserId 
            ];

            if ($id) {
                $this->productsModel->update($id, $data);
            } else {
                $this->productsModel->create($data);
            }
            
            header("Location: index.php?page=products");
            exit;
        }

        $keyword = $_GET['keyword'] ?? '';
        $productsList = $this->productsModel->getAll($keyword); 
        
        if ($id) {
            $editData = $this->productsModel->getById($id);
        }

        require __DIR__ . '/../views/admin/products.php';
    }
}