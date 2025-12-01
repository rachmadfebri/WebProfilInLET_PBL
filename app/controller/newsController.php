<?php
require_once __DIR__ . '/../model/NewsModel.php'; 

class NewsController {
    private $newsModel;

    public function __construct(PDO $pdo) {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $this->newsModel = new NewsModel($pdo);
    }

    public function index() {
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

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
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        $this->newsModel->delete($id);
        header("Location: index.php?page=news");
        exit;
    }

    private function handleRequest($id = null) {
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

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

            $userId = $_SESSION['user_id'] ?? null;

            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'published_date' => $_POST['published_date'],
                'thumbnail' => $thumbnailPath,
                'user_id' => $userId 
            ];

            if ($id) {
                $this->newsModel->update($id, $data);
            } else {
                $this->newsModel->create($data);
            }
            
            header("Location: index.php?page=news");
            exit;
        }

        $keyword = $_GET['keyword'] ?? '';
        $newsList = $this->newsModel->getAll($keyword);
        
        if ($id) {
            $editData = $this->newsModel->getById($id);
        }

        require __DIR__ . '/../views/admin/news.php'; 
    }
}