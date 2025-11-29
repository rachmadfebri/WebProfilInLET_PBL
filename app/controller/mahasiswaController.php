<?php
// app/controllers/MahasiswaController.php

// Memuat Model yang diperlukan
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
        
        // Memastikan semua aksi POST absensi diproses sebelum rendering
        $this->handleAttendanceAction();
    }

    /**
     * Menangani semua request POST yang terkait dengan absensi (Check-In/Check-Out).
     */
    private function handleAttendanceAction() {
        // Hanya proses jika ada request POST dan ada action
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];
            
            // PERBAIKAN: Pastikan user_id diambil dari session dengan benar
            if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Sesi tidak valid. Silakan login ulang.'];
                header('Location: ?page=login');
                exit;
            }
            
            $user_id = (int)$_SESSION['user_id']; // Cast ke integer untuk keamanan
            $redirect_url = '?page=mahasiswa-dashboard'; // Sesuaikan dengan routing Anda
            
            // Hapus flash message sebelumnya
            unset($_SESSION['flash_message']);

            if ($action === 'absen_datang') {
                $result = $this->attendanceModel->checkIn($user_id);

                if ($result) {
                    $_SESSION['flash_message'] = ['type' => 'success', 'text' => '✅ Check-In berhasil! Selamat beraktivitas.'];
                } else {
                    // Cek apakah sudah check-in hari ini
                    $latestAttendance = $this->attendanceModel->getLatestTodayAttendance($user_id);
                    if ($latestAttendance && is_null($latestAttendance['check_out_time'])) {
                        $_SESSION['flash_message'] = ['type' => 'warning', 'text' => '⚠️ Anda sudah Check-In hari ini pada pukul ' . date('H:i', strtotime($latestAttendance['check_in_time'])) . '.'];
                    } else {
                        $_SESSION['flash_message'] = ['type' => 'error', 'text' => '❌ Gagal Check-In. Silakan coba lagi.'];
                    }
                }
                
            } elseif ($action === 'absen_pulang') {
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
            
            // Redirect setelah POST untuk mencegah re-submit form pada refresh
            header('Location: ' . $redirect_url);
            exit;
        }
    }

    /**
     * Titik masuk utama Dashboard Mahasiswa.
     */
    public function dashboard() {
        // Cek Auth dan Role
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
            header("Location: ?page=login");
            exit;
        }
        
        $user_id = (int)$_SESSION['user_id'];
        
        // DEBUGGING: Log user_id untuk memastikan
        error_log("Dashboard loaded for user_id: " . $user_id);
        
        // Ambil data user
        $student_data = $this->mahasiswaModel->getStudentData($user_id);
        
        // Cek kelengkapan data mahasiswa (Asumsi: 'nim' adalah field wajib)
        if (!$student_data || empty($student_data['nim'])) { 
            return $this->setupProfile(); 
        }

        // --- Persiapan Data Absensi untuk View ---
        
        $latestAttendance = $this->attendanceModel->getLatestTodayAttendance($user_id);
        
        // DEBUGGING: Log hasil query attendance
        error_log("Latest attendance data: " . print_r($latestAttendance, true));
        
        // Default status
        $status_absen_hari_ini = 'belum_absen'; // Opsi: 'belum_absen', 'sudah_datang', 'sudah_lengkap'
        $check_in_time = null;
        
        if ($latestAttendance) {
            $check_in_time = date('H:i:s', strtotime($latestAttendance['check_in_time']));
            // PERBAIKAN: Pastikan logika pengecekan check_out_time konsisten
            if (is_null($latestAttendance['check_out_time']) || empty($latestAttendance['check_out_time'])) {
                $status_absen_hari_ini = 'sudah_datang';
            } else {
                $status_absen_hari_ini = 'sudah_lengkap';
            }
        }
        
        // DEBUGGING: Log status absen
        error_log("Status absen hari ini: " . $status_absen_hari_ini);

        // Ambil nama pengguna dari session, atau dari student_data jika ada
        $nama_pengguna = $student_data['full_name'] ?? $_SESSION['full_name'] ?? 'Mahasiswa';

        // Ambil flash message dari session
        $flash_message = $_SESSION['flash_message'] ?? null;
        unset($_SESSION['flash_message']); // Hapus setelah diambil
        
        // Load View: Variabel-variabel di atas tersedia di dashboard.php
        require __DIR__ . '/../views/mahasiswa/dashboard.php';
    }

    /**
     * Menangani Tampilan dan Proses Form Wajib Isi Data Mahasiswa.
     */
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
                if ($this->mahasiswaModel->createOrUpdate($user_id, $data)) {
                    $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Data profil berhasil dilengkapi!'];
                    header('Location: ?page=mahasiswa-dashboard');
                    exit();
                } else {
                    $error_message = "Gagal menyimpan data ke database. Silakan coba lagi.";
                }
            }
        } 
        
        require __DIR__ . '/../views/mahasiswa/setup_form.php';
    }
}