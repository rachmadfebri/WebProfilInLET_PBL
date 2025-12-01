<?php
require_once __DIR__ . '/../model/GuestbookModel.php';

class GuestbookController {
    private $guestbookModel;

    public function __construct(PDO $pdo) {
        $this->guestbookModel = new GuestbookModel($pdo);
    }

    public function getData($startDate = null, $endDate = null, $keyword = '') {
        return $this->guestbookModel->getAll($startDate, $endDate, $keyword);
    }

    public function delete($id) {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if ($_SESSION['role'] !== 'admin') exit;
        
        $this->guestbookModel->delete($id);
        
        // Redirect kembali ke Dashboard Admin
        header("Location: index.php?page=admin-dashboard");
        exit;
    }

    // Fungsi Submit (Public)
    // public function submit() {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $data = [
    //             'name' => $_POST['name'],
    //             'institution' => $_POST['institution'],
    //             'email' => $_POST['email'] ?? null,
    //             'phone_number' => $_POST['phone_number'] ?? null,
    //             'message' => $_POST['message']
    //         ];
            
    //         $this->guestbookModel->create($data);
            
    //         // Redirect balik ke Home
    //         header("Location: index.php?page=home&status=guestbook_success"); 
    //         exit;
    //     }
    // }

    // Fungsi Print (Tetap via Controller ini)
    public function printReport() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if ($_SESSION['role'] !== 'admin') exit;

        $startDate = $_GET['start_date'] ?? date('Y-m-01'); 
        $endDate   = $_GET['end_date'] ?? date('Y-m-d');    
        $keyword   = $_GET['keyword'] ?? '';

        $dataLaporan = $this->guestbookModel->getAll($startDate, $endDate, $keyword);
        
        require __DIR__ . '/../views/admin/print_guestbook.php';
    }
}