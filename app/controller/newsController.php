<?php
require_once __DIR__ . '/../model/NewsModel.php'; 

class NewsController {
    private $newsModel;

    public function __construct(PDO $pdo) {
        $this->newsModel = new NewsModel($pdo);
    }

    public function index() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        // PERBAIKAN: Ambil keyword search
        $keyword = $_GET['keyword'] ?? '';
        $newsList = $this->newsModel->getAll($keyword); 
        
        require __DIR__ . '/../views/admin/news.php'; 
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
        $this->newsModel->delete($id);
        header("Location: index.php?page=news");
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
            
            if ($id) {
                $oldData = $this->newsModel->getById($id);
                $thumbnailPath = $oldData['thumbnail'];
            }

            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
                $newName = 'news_' . time() . '.' . $ext;
                $uploadDir = __DIR__ . '/../../public/uploads/';
                
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadDir . $newName)) {
                    $thumbnailPath = 'uploads/' . $newName;
                }
            }

            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'published_date' => $_POST['published_date'],
                'thumbnail' => $thumbnailPath
            ];

            if ($id) {
                $this->newsModel->update($id, $data);
            } else {
                $this->newsModel->create($data);
            }
            
            header("Location: index.php?page=news");
            exit;
        }

        // 2. JIKA GET (Tampilkan Halaman)
        // PERBAIKAN: Tambahkan support search di sini juga
        $keyword = $_GET['keyword'] ?? '';
        $newsList = $this->newsModel->getAll($keyword);
        
        if ($id) {
            $editData = $this->newsModel->getById($id);
        }

        require __DIR__ . '/../views/admin/news.php';
    }
}