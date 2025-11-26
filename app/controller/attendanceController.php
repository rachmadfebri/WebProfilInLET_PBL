<?php
// app/controllers/AttendanceController.php

require_once __DIR__ . '/../model/AttendanceModel.php'; 

class AttendanceController {
    private $attendanceModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->attendanceModel = new AttendanceModel();
        // Atur timezone ke Asia/Jakarta untuk konsistensi waktu absensi
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Menangani proses Check-In absensi (dipanggil via ?action=checkin)
     */
    public function processCheckIn() {
        // PERBAIKAN: Validasi session lebih ketat
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Sesi kedaluwarsa. Silakan login ulang.'];
            header("Location: ?page=login"); 
            exit;
        }

        // PERBAIKAN: Cast ke integer untuk keamanan
        $user_id = (int)$_SESSION['user_id'];
        
        // DEBUGGING: Log user_id
        error_log("AttendanceController::processCheckIn - User ID: " . $user_id);
        
        $latest_attendance = $this->attendanceModel->getLatestTodayAttendance($user_id);
        
        // DEBUGGING: Log hasil query
        error_log("AttendanceController::processCheckIn - Latest Attendance: " . print_r($latest_attendance, true));

        // PERBAIKAN: Pengecekan yang lebih robust
        // Cek apakah user sudah Check-In hari ini dan belum Check-Out (status: sudah_datang)
        if ($latest_attendance && (is_null($latest_attendance['check_out_time']) || empty($latest_attendance['check_out_time']))) {
            $check_in_formatted = date('H:i', strtotime($latest_attendance['check_in_time']));
            $_SESSION['flash_message'] = [
                'type' => 'warning', 
                'text' => 'Anda sudah Check-In hari ini pada pukul ' . $check_in_formatted . '.'
            ];
            error_log("AttendanceController::processCheckIn - Duplicate check-in prevented");
        } elseif ($this->attendanceModel->checkIn($user_id)) {
            $_SESSION['flash_message'] = [
                'type' => 'success', 
                'text' => '✅ Check-In berhasil! Selamat beraktivitas.'
            ];
            error_log("AttendanceController::processCheckIn - Check-in successful");
        } else {
            // Ini akan menangani kasus di mana Check-In gagal karena error DB
            $_SESSION['flash_message'] = [
                'type' => 'error', 
                'text' => '⚠️ Gagal melakukan Check-In. Coba lagi atau hubungi admin.'
            ];
            error_log("AttendanceController::processCheckIn - Check-in failed");
        }

        // Redirect kembali ke dashboard mahasiswa
        header("Location: ?page=mahasiswa-dashboard"); 
        exit;
    }

    /**
     * Menangani proses Check-Out absensi (dipanggil via ?action=checkout)
     */
    public function processCheckOut() {
        // PERBAIKAN: Validasi session lebih ketat
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Sesi kedaluwarsa. Silakan login ulang.'];
            header("Location: ?page=login"); 
            exit;
        }

        // PERBAIKAN: Cast ke integer untuk keamanan
        $user_id = (int)$_SESSION['user_id'];
        
        // DEBUGGING: Log user_id
        error_log("AttendanceController::processCheckOut - User ID: " . $user_id);
        
        // Ambil record absensi terbaru hari ini
        $latest_attendance = $this->attendanceModel->getLatestTodayAttendance($user_id);
        
        // DEBUGGING: Log hasil query
        error_log("AttendanceController::processCheckOut - Latest Attendance: " . print_r($latest_attendance, true));

        // PERBAIKAN: Cek apakah ada record dan belum Check-Out
        if (!$latest_attendance) {
            $_SESSION['flash_message'] = [
                'type' => 'warning', 
                'text' => '❗ Anda belum Check-In hari ini.'
            ];
            error_log("AttendanceController::processCheckOut - No check-in record found");
        } elseif (!is_null($latest_attendance['check_out_time']) && !empty($latest_attendance['check_out_time'])) {
            $_SESSION['flash_message'] = [
                'type' => 'warning', 
                'text' => '❗ Anda sudah Check-Out lengkap hari ini.'
            ];
            error_log("AttendanceController::processCheckOut - Already checked out");
        } elseif ($this->attendanceModel->checkOut($latest_attendance['id'])) {
            $_SESSION['flash_message'] = [
                'type' => 'success', 
                'text' => '👋 Check-Out berhasil! Sampai jumpa besok.'
            ];
            error_log("AttendanceController::processCheckOut - Check-out successful");
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error', 
                'text' => '❌ Gagal melakukan Check-Out. Coba lagi.'
            ];
            error_log("AttendanceController::processCheckOut - Check-out failed");
        }

        header("Location: ?page=mahasiswa-dashboard"); 
        exit;
    }

    /** 
     * Fungsi helper untuk mengambil data absensi hari ini (Dipanggil dari MahasiswaController)
     * @param int $user_id
     * @return array 
     * 'status': 'belum_absen', 'sudah_datang', 'sudah_lengkap'
     * 'check_in_time': string waktu check-in (H:i:s)
     */
    public function getAttendanceStatus($user_id) {
        // PERBAIKAN: Cast ke integer
        $user_id = (int)$user_id;
        
        // DEBUGGING: Log user_id
        error_log("AttendanceController::getAttendanceStatus - User ID: " . $user_id);
        
        $latestAttendance = $this->attendanceModel->getLatestTodayAttendance($user_id);
        
        // DEBUGGING: Log hasil query
        error_log("AttendanceController::getAttendanceStatus - Latest Attendance: " . print_r($latestAttendance, true));
        
        $status = 'belum_absen'; 
        $check_in_time = null;
        
        if ($latestAttendance) {
            $check_in_time = date('H:i:s', strtotime($latestAttendance['check_in_time']));
            
            // PERBAIKAN: Pengecekan yang lebih robust
            // Jika ada record tapi check_out_time masih NULL atau kosong, berarti statusnya 'sudah_datang'
            if (is_null($latestAttendance['check_out_time']) || empty($latestAttendance['check_out_time'])) {
                $status = 'sudah_datang';
            } else {
                $status = 'sudah_lengkap';
            }
        }
        
        // DEBUGGING: Log status yang dikembalikan
        error_log("AttendanceController::getAttendanceStatus - Returning status: " . $status);

        return [
            'status' => $status,
            'check_in_time' => $check_in_time
        ];
    }
}