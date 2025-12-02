<?php
require_once __DIR__ . '/../model/TeamMembersModel.php'; 

class TeamMembersController {
    private $teamModel;

    public function __construct(PDO $pdo) {
        $this->teamModel = new TeamMembersModel($pdo);
    }

    public function index() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $keyword = $_GET['keyword'] ?? '';
        $teamList = $this->teamModel->getAll($keyword); 

        require __DIR__ . '/../views/admin/team.php'; 
    }

    /**
     * Halaman publik: menampilkan daftar anggota tim tanpa perlu login admin.
     */
    public function publicIndex() {
        // Untuk halaman publik, ambil semua data tanpa filter keyword
        $teamList = $this->teamModel->getAll('');

        // Kirim ke view publik
        require __DIR__ . '/../views/users/teampublic.php';
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
        $this->teamModel->delete($id);
        header("Location: index.php?page=team");
        exit;
    }

    private function handleRequest($id = null) {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $photoPath = '';
            
            if ($id) {
                $oldData = $this->teamModel->getById($id);
                $photoPath = $oldData['photo'];
            }

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $newName = 'team_' . time() . '.' . $ext;
                $uploadDir = __DIR__ . '/../../public/uploads/';
                
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $newName)) {
                    $photoPath = 'uploads/' . $newName;
                }
            }

            $data = [
                'name'           => $_POST['name'],
                'position'       => $_POST['position'],
                'email'          => $_POST['email'],
                'google_scholar' => $_POST['google_scholar'],
                'twitter'        => $_POST['twitter'],
                'instagram'      => $_POST['instagram'],
                'photo'          => $photoPath
            ];

            if ($id) {
                $this->teamModel->update($id, $data);
            } else {
                $this->teamModel->create($data);
            }
            
            header("Location: index.php?page=team");
            exit;
        }

        $keyword = $_GET['keyword'] ?? '';
        $teamList = $this->teamModel->getAll($keyword); 
        
        if ($id) {
            $editData = $this->teamModel->getById($id);
        }

        require __DIR__ . '/../views/admin/team.php';
    }
}