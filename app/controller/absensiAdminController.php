<?php

require_once __DIR__ . '/../model/AttendanceModel.php';

class AbsensiAdminController {
    private $attendanceModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->attendanceModel = new AttendanceModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Handle request halaman absensi admin
     */
    public function index() {
        // Cek apakah sudah login sebagai admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=sign-in");
            exit;
        }

        // Load view
        require_once __DIR__ . '/../views/admin/absensi.php';
    }

    /**
     * Export attendance data to CSV (optional)
     */
    public function exportCSV() {
        if ($_SESSION['role'] !== 'admin') {
            die('Unauthorized');
        }

        $allAttendance = $this->attendanceModel->getAllAttendanceToday();

        // Filter jika ada keyword atau tanggal
        $keyword = $_GET['keyword'] ?? '';
        $filter_date = $_GET['filter_date'] ?? '';

        if (!empty($keyword)) {
            $allAttendance = array_filter($allAttendance, function($item) use ($keyword) {
                return stripos($item['full_name'], $keyword) !== false;
            });
        }

        if (!empty($filter_date)) {
            $allAttendance = array_filter($allAttendance, function($item) use ($filter_date) {
                $item_date = date('Y-m-d', strtotime($item['check_in_time']));
                return $item_date === $filter_date;
            });
        }

        // Set header untuk download CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="absensi_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['No', 'Nama', 'Email', 'Tanggal', 'Check-In', 'Check-Out', 'Status']);

        $no = 1;
        foreach ($allAttendance as $item) {
            $check_in_time = $item['check_in_time'] ? date('H:i:s', strtotime($item['check_in_time'])) : '-';
            $check_out_time = $item['check_out_time'] ? date('H:i:s', strtotime($item['check_out_time'])) : '-';
            $check_in_date = $item['check_in_time'] ? date('d M Y', strtotime($item['check_in_time'])) : '-';
            $status = (!empty($item['check_out_time'])) ? 'Lengkap' : 'Sedang Aktivitas';

            fputcsv($output, [
                $no++,
                $item['full_name'] ?? 'N/A',
                $item['email'] ?? '-',
                $check_in_date,
                $check_in_time,
                $check_out_time,
                $status
            ]);
        }

        fclose($output);
        exit;
    }
}
