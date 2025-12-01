<?php

require_once __DIR__ . '/../model/MahasiswaModel.php'; 
require_once __DIR__ . '/../model/AttendanceModel.php'; 

class MahasiswaController {
    private $mahasiswaModel;
    private $attendanceModel; 

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->mahasiswaModel = new MahasiswaModel();
        $this->attendanceModel = new AttendanceModel(); 
        
        $this->handleAttendanceAction();
    }

    private function handleAttendanceAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];
            
            if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Sesi tidak valid. Silakan login ulang.'];
                header('Location: ?page=login');
                exit;
            }
            
            $user_id = (int)$_SESSION['user_id']; 
            $redirect_url = '?page=mahasiswa-dashboard'; 

            unset($_SESSION['flash_message']);

            if ($action === 'absen_datang') {
                if (!$this->attendanceModel->isCheckInTimeAllowed()) {
                    $_SESSION['flash_message'] = ['type' => 'warning', 'text' => '⏰ Absensi datang hanya tersedia mulai pukul 07:00 WIB.'];
                    header('Location: ' . $redirect_url);
                    exit;
                }
                
                if (!$this->attendanceModel->isActivityTimeAllowed()) {
                    $_SESSION['flash_message'] = ['type' => 'warning', 'text' => '⏰ Absensi ditutup pada pukul 22:00 WIB. Silakan coba besok.'];
                    header('Location: ' . $redirect_url);
                    exit;
                }
                
                error_log("Attempting check-in for user_id: " . $user_id);
                $result = $this->attendanceModel->checkIn($user_id);
                error_log("Check-in result: " . ($result ? 'true' : 'false'));

                if ($result) {
                    $_SESSION['flash_message'] = ['type' => 'success', 'text' => '✅ Check-In berhasil! Selamat beraktivitas.'];
                } else {

                    $latestAttendance = $this->attendanceModel->getLatestTodayAttendance($user_id);
                    error_log("Latest attendance after failed check-in: " . json_encode($latestAttendance));
                    
                    if ($latestAttendance && is_null($latestAttendance['check_out_time'])) {
                        $_SESSION['flash_message'] = ['type' => 'warning', 'text' => '⚠️ Anda sudah Check-In hari ini pada pukul ' . date('H:i', strtotime($latestAttendance['check_in_time'])) . '.'];
                    } else {
                        $_SESSION['flash_message'] = ['type' => 'error', 'text' => '❌ Gagal Check-In. Silakan coba lagi.'];
                    }
                }
                
            } elseif ($action === 'absen_pulang') {
                if (!$this->attendanceModel->isActivityTimeAllowed()) {
                    $_SESSION['flash_message'] = ['type' => 'warning', 'text' => '⏰ Absensi ditutup pada pukul 22:00 WIB. Silakan coba besok.'];
                    header('Location: ' . $redirect_url);
                    exit;
                }
                
                $latestAttendance = $this->attendanceModel->getLatestTodayAttendance($user_id);
                
                if ($latestAttendance && is_null($latestAttendance['check_out_time'])) {
                    $attendance_id = $latestAttendance['id'];
                    $result = $this->attendanceModel->checkOut($attendance_id);

                    if ($result) {
                        $_SESSION['flash_message'] = ['type' => 'success', 'text' => '👋 Check-Out berhasil! Sampai jumpa besok.'];
                    } else {
                        $_SESSION['flash_message'] = ['type' => 'error', 'text' => '❌ Gagal Check-Out karena masalah database.'];
                    }
                } else {
                    $_SESSION['flash_message'] = ['type' => 'warning', 'text' => '❗ Anda belum Check-In hari ini atau sudah Check-Out lengkap.'];
                }
            }
            
            sleep(1);
            header('Location: ' . $redirect_url);
            exit;
        }
    }

    public function dashboard() {

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
            header("Location: ?page=login");
            exit;
        }
        
        $user_id = (int)$_SESSION['user_id'];
    
        error_log("Dashboard loaded for user_id: " . $user_id);
        
        $student_data = $this->mahasiswaModel->getStudentData($user_id);
        
        if (!$student_data || empty($student_data['nim'])) { 
            return $this->setupProfile(); 
        }

        // --- Persiapan Data Absensi untuk View ---
        
        $latestAttendance = $this->attendanceModel->getLatestTodayAttendance($user_id);
        
        error_log("Latest attendance data: " . print_r($latestAttendance, true));
        
        $status_absen_hari_ini = 'belum_absen'; 
        $check_in_time = null;
        
        if ($latestAttendance) {
            error_log("Latest attendance found!");
            error_log("check_in_time: " . $latestAttendance['check_in_time']);
            error_log("check_out_time: " . ($latestAttendance['check_out_time'] ?? 'NULL'));
            
            $check_in_time = date('H:i:s', strtotime($latestAttendance['check_in_time']));
            
            if (is_null($latestAttendance['check_out_time']) || $latestAttendance['check_out_time'] === '' || empty($latestAttendance['check_out_time'])) {
                $status_absen_hari_ini = 'sudah_datang';
                error_log("Status set to: sudah_datang");
            } else {
                $status_absen_hari_ini = 'sudah_lengkap';
                error_log("Status set to: sudah_lengkap");
            }
        } else {
            error_log("No attendance record found for today");
        }
        
        error_log("Status absen hari ini: " . $status_absen_hari_ini);

        $nama_pengguna = $student_data['full_name'] ?? $_SESSION['full_name'] ?? 'Mahasiswa';

        $flash_message = $_SESSION['flash_message'] ?? null;
        unset($_SESSION['flash_message']); 
        
        $current_hour = (int)date('H');
        $current_minute = (int)date('i');
        $is_check_in_time_allowed = $this->attendanceModel->isCheckInTimeAllowed();
        $is_activity_time_allowed = $this->attendanceModel->isActivityTimeAllowed();
        
        error_log("Current time: {$current_hour}:{$current_minute}");
        error_log("Check-in time allowed: " . ($is_check_in_time_allowed ? 'YES' : 'NO'));
        error_log("Activity time allowed: " . ($is_activity_time_allowed ? 'YES' : 'NO'));
        
        require __DIR__ . '/../views/mahasiswa/dashboard.php';
    }

    public function setupProfile() {
        $user_id = $_SESSION['user_id'] ?? 0;
        $error_message = '';
        $data_mahasiswa_input = []; 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nim'           => trim($_POST['nim'] ?? ''),
                'program_study' => trim($_POST['program_study'] ?? ''),
                'batch'         => trim($_POST['batch'] ?? ''),
                'activity_type' => trim($_POST['activity_type'] ?? 'Mahasiswa') 
            ];
            $data_mahasiswa_input = $data;

            if (empty($data['nim']) || empty($data['batch']) || !is_numeric($data['batch']) || strlen($data['nim']) < 5) {
                $error_message = "NIM dan Angkatan wajib diisi dengan format yang benar (NIM minimal 5 karakter).";
            } else {
                try {
                    if ($this->mahasiswaModel->createOrUpdate($user_id, $data)) {
                        $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Data profil berhasil dilengkapi!'];
                        header('Location: ?page=mahasiswa-dashboard');
                        exit();
                    } else {
                        $error_message = "Gagal menyimpan data ke database. Silakan coba lagi.";
                    }
                } catch (Exception $e) {
                    $error_message = $e->getMessage();
                }
            }
        } 
        
        require __DIR__ . '/../views/mahasiswa/setup_form.php';
    }
}