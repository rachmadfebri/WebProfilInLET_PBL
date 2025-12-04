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
        
        // Gunakan timezone Asia/Jakarta untuk konsistensi
        $jakartaTimezone = new DateTimeZone('Asia/Jakarta');
        $now = new DateTime('now', $jakartaTimezone);
        $current_hour = (int)$now->format('H');
        $current_minute = (int)$now->format('i');
        
        $is_check_in_time_allowed = $this->attendanceModel->isCheckInTimeAllowed();
        $is_activity_time_allowed = $this->attendanceModel->isActivityTimeAllowed();
        
        error_log("Current Jakarta time: " . $now->format('Y-m-d H:i:s'));
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

    public function profil() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
        header("Location: ?page=login");
        exit;
    }
    
    $user_id = (int)$_SESSION['user_id'];
    $error_message = '';
    $flash_message = null;

    // Get student data
    $sql = "SELECT s.*, u.email, u.full_name 
            FROM students s
            JOIN users u ON s.user_id = u.user_id
            WHERE s.user_id = :id";
    
    // Pastikan path connection benar sesuai struktur folder Anda
    $db = require __DIR__ . '/../../config/connection.php';
    $stmt = $db->prepare($sql);
    $stmt->execute([':id' => $user_id]);
    $student_data = $stmt->fetch();

    if (!$student_data) {
        $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Data profil tidak ditemukan.'];
        header("Location: ?page=mahasiswa-dashboard");
        exit;
    }

    // Handle profile update
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nim = trim($_POST['nim'] ?? '');
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $program_study = trim($_POST['program_study'] ?? '');
        $batch = trim($_POST['batch'] ?? '');
        
        $old_password = $_POST['old_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // Data awal yang akan diupdate
        $updateData = [
            'nim' => $nim,
            'full_name' => $full_name,
            'email' => $email,
            'program_study' => $program_study,
            'batch' => (int)$batch
        ];

        // Validasi Standard
        if (empty($nim) || strlen($nim) < 5) {
            $error_message = "NIM tidak boleh kosong dan minimal 5 karakter.";
        } elseif (empty($full_name) || strlen($full_name) < 3) {
            $error_message = "Nama lengkap minimal 3 karakter.";
        } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Email tidak valid.";
        } elseif (empty($program_study)) {
            $error_message = "Program studi wajib diisi.";
        } elseif (empty($batch) || !is_numeric($batch)) {
            $error_message = "Angkatan tidak valid.";
        }

        // --- LOGIKA UPDATE PASSWORD ---
        // Cek jika user mencoba mengganti password (salah satu kolom password terisi)
        if (empty($error_message) && (!empty($old_password) || !empty($new_password) || !empty($confirm_password))) {
            
            // 1. Pastikan semua kolom password terisi
            if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
                $error_message = "Untuk mengganti password, semua kolom password (Lama, Baru, Konfirmasi) wajib diisi.";
            } 
            // 2. Cek kecocokan password baru
            elseif ($new_password !== $confirm_password) {
                $error_message = "Password baru dan konfirmasi password tidak cocok.";
            }
            // 3. Verifikasi Password Lama
            else {
                $currentHash = $this->mahasiswaModel->getPasswordHash($user_id);
                
                if ($currentHash && password_verify($old_password, $currentHash)) {
                    // Password lama BENAR, masukkan password baru yang sudah di-hash ke array update
                    $updateData['password'] = password_hash($new_password, PASSWORD_DEFAULT);
                } else {
                    $error_message = "Password lama yang Anda masukkan salah.";
                }
            }
        }
        // ------------------------------

        // Jika tidak ada error, eksekusi update
        if (empty($error_message)) {
            try {
                if ($this->mahasiswaModel->updateProfile($user_id, $updateData)) {
                    $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Profil berhasil diperbarui!'];
                    
                    $_SESSION['full_name'] = $full_name;
                    $_SESSION['email'] = $email;

                    // Refresh data
                    $stmt = $db->prepare($sql);
                    $stmt->execute([':id' => $user_id]);
                    $student_data = $stmt->fetch();
                    
                    $flash_message = $_SESSION['flash_message'];
                    unset($_SESSION['flash_message']);
                } else {
                    $error_message = "Gagal memperbarui database.";
                }
            } catch (Exception $e) {
                $error_message = "Error: " . $e->getMessage();
            }
        }
    }

    $flash_message = $flash_message ?? null;
    require __DIR__ . '/../views/mahasiswa/profil.php';
}
}