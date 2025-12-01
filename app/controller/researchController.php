<?php

require_once __DIR__ . '/../model/ResearchModel.php'; 

class ResearchController {
    private $researchModel;

    public function __construct(PDO $pdo) {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $this->researchModel = new ResearchModel($pdo);
    }

    public function index() {
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        
        $keyword = $_GET['keyword'] ?? '';
        
        $researchList = $this->researchModel->getAll($keyword); 
        
        $totalRecords = count($researchList);

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
        $this->researchModel->delete($id);
        header("Location: index.php?page=research");
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
                $oldData = $this->researchModel->getById($id);
                $imagePath = $oldData['image'];
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $newName = 'research_' . time() . '.' . $ext;
                $uploadDir = __DIR__ . '/../../public/uploads/';
                
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $newName)) {
                    $imagePath = 'uploads/' . $newName; 
                }
            }

        $currentUserId = $_SESSION['user_id'] ?? $_SESSION['id'] ?? null;

            $data = [
                'title'       => $_POST['title'],
                'description' => $_POST['description'],
                'image'       => $imagePath,
                'user_id'     => $currentUserId 
            ];

            if ($id) {
                $this->researchModel->update($id, $data);
            } else {
                $this->researchModel->create($data);
            }
            
            header("Location: index.php?page=research");
            exit;
        }

        $researchList = $this->researchModel->getAll(); 
        
        if ($id) {
            $editData = $this->researchModel->getById($id); 
        }

        require __DIR__ . '/../views/admin/research.php';
    }
}