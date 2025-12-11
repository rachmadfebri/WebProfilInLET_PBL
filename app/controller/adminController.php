<?php

require_once __DIR__ . '/../model/ProductsModel.php';
require_once __DIR__ . '/../model/ResearchModel.php';
require_once __DIR__ . '/../model/StudentModel.php';
require_once __DIR__ . '/../model/TeamMembersModel.php';
require_once __DIR__ . '/../model/GuestbookModel.php';
require_once __DIR__ . '/../model/NewsModel.php';


class AdminController {
    private $productsModel;
    private $researchModel;
    private $studentModel;
    private $teamModel;
    private $guestbookModel;
    private $newsModel;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->productsModel = new ProductsModel($pdo);
        $this->researchModel = new ResearchModel($pdo);
        $this->studentModel = new StudentModel($pdo);
        $this->teamModel = new TeamMembersModel($pdo);
        $this->guestbookModel = new GuestbookModel($pdo);
        $this->newsModel = new NewsModel($pdo);
    }

    public function dashboard() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        
        $totalProducts = count($this->productsModel->getAll());
        $totalResearch = count($this->researchModel->getAll());
        $totalStudents = count($this->studentModel->getAll());
        $totalTeam     = count($this->teamModel->getAll());

        $startDate = $_GET['start_date'] ?? null;
        $endDate   = $_GET['end_date']   ?? null;
        $keyword   = $_GET['keyword']    ?? '';

        $guestbookList = $this->guestbookModel->getAll($startDate, $endDate, $keyword);
        
        // Ambil data terbaru untuk dashboard
        $recentNews = $this->newsModel ? $this->newsModel->getAll() : [];
        $recentGuestbook = $guestbookList;

        // Visitor Statistics
        $totalVisitors = 0;
        $todayVisitors = 0;
        $monthVisitors = 0;
        
        try {
            // Total all visitors
            $stmtTotal = $this->pdo->query("SELECT COUNT(*) FROM visitor_stats");
            $totalVisitors = (int)$stmtTotal->fetchColumn();
            
            // Today's visitors
            $stmtToday = $this->pdo->prepare("SELECT COUNT(*) FROM visitor_stats WHERE visit_date = ?");
            $stmtToday->execute([date('Y-m-d')]);
            $todayVisitors = (int)$stmtToday->fetchColumn();
            
            // This month's visitors
            $stmtMonth = $this->pdo->prepare("SELECT COUNT(*) FROM visitor_stats WHERE visit_date >= ? AND visit_date <= ?");
            $stmtMonth->execute([date('Y-m-01'), date('Y-m-t')]);
            $monthVisitors = (int)$stmtMonth->fetchColumn();
        } catch (Exception $e) {
            // Keep default values
        }

        require __DIR__ . '/../views/admin/dashboard.php';
    }
}