<?php
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../model/MahasiswaModel.php';

class authController {
    private $userModel;
    private $mhsModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->mhsModel = new MahasiswaModel();
    }

    public function register() {

    $fullname = trim($_POST['full_name'] ?? '');
    $username = trim($_POST['username'] ?? ''); // <--- Tambahan username
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // 1. Validasi Input
    // Tambahkan $username ke validasi kosong
    if ($fullname === '' || $username === '' || $email === '' || $password === '') { 
        $_SESSION['error'] = "All fields required.";
        header("Location: ?page=register");
        exit;
    }

    if ($password !== $confirm) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ?page=register");
        exit;
    }

    // 2. Validasi Email Unik
    if ($this->userModel->getByEmail($email)) {
        $_SESSION['error'] = "Email already used.";
        header("Location: ?page=register");
        exit;
    }

    // 3. Buat User & Ambil ID
    // Pastikan urutan parameter di sini sesuai dengan urutan di userModel.php
    $user_id = $this->userModel->createUser($fullname, $username, $email, $password, 'mahasiswa');

    // PENTING: Cek apakah ID berhasil didapatkan. Jika gagal (misal: false), hentikan proses.
    if (!$user_id) {
        $_SESSION['error'] = "Account creation failed due to database error.";
        header("Location: ?page=register");
        exit;
    }

    // 4. Buat Entry Mahasiswa (Hanya Jika User ID Tersedia)
    $this->mhsModel->createOrUpdate($user_id, []);

    $_SESSION['success'] = "Account created.";
    header("Location: ?page=login");
    exit;
}

    public function login() {
        session_start();

        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $_SESSION['error'] = "Fill email & password.";
            header("Location: ?page=login");
            exit;
        }

        $user = $this->userModel->getByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $_SESSION['error'] = "Invalid credentials.";
            header("Location: ?page=login");
            exit;
        }

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['full_name'] = $user['full_name'];

        if ($user['role'] === 'admin') {
            header("Location: ?page=admin-dashboard");
        } else {
            header("Location: ?page=mahasiswa-dashboard");
        }
        exit;
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: ?page=login");
        exit;
    }
}
