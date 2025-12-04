<?php
require_once __DIR__ . '/../model/loanModel.php';
require_once __DIR__ . '/../model/inventoryModel.php';

class LoanController {
    private $loanModel;
    private $inventoryModel;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->loanModel = new LoanModel($pdo);
        $this->inventoryModel = new InventoryModel($pdo);
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Halaman index untuk mahasiswa - Daftar peminjaman & form pengajuan
     */
    public function mahasiswaIndex() {
        // Pastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
            header("Location: ?page=login");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $this->handleMahasiswaAction();
            return; // Pastikan tidak lanjut eksekusi setelah redirect
        }

        // Get data untuk view
        try {
            $myLoans = $this->loanModel->getByUserId($user_id);
            $availableInventory = $this->inventoryModel->getAvailable();
            $activeLoans = $this->loanModel->getActiveByUserId($user_id);
        } catch (Exception $e) {
            $myLoans = [];
            $availableInventory = [];
            $activeLoans = [];
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
        
        $flash_message = $_SESSION['flash_message'] ?? null;
        unset($_SESSION['flash_message']);
        
        $nama_pengguna = $_SESSION['full_name'] ?? 'Mahasiswa';

        require __DIR__ . '/../views/mahasiswa/peminjaman.php';
    }

    /**
     * Handle aksi dari mahasiswa
     */
    private function handleMahasiswaAction() {
        $action = $_POST['action'];
        $user_id = $_SESSION['user_id'];

        try {
            if ($action === 'create_loan') {
                $inventory_id = $_POST['inventory_id'] ?? null;
                $loan_date = $_POST['loan_date'] ?? null;
                $return_date = $_POST['return_date'] ?? null;
                $reason = trim($_POST['reason'] ?? '');

                // Validasi
                if (!$inventory_id || !$loan_date || !$return_date) {
                    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Semua field wajib diisi!'];
                    header('Location: ?page=peminjaman');
                    exit;
                }

                // Validasi tanggal
                $loanDateTime = strtotime($loan_date);
                $returnDateTime = strtotime($return_date);

                if ($loanDateTime < strtotime(date('Y-m-d'))) {
                    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Tanggal peminjaman tidak boleh kurang dari hari ini!'];
                    header('Location: ?page=peminjaman');
                    exit;
                }

                if ($returnDateTime <= $loanDateTime) {
                    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Tanggal pengembalian harus setelah tanggal peminjaman!'];
                    header('Location: ?page=peminjaman');
                    exit;
                }

                // Cek ketersediaan - skip jika method belum ada
                try {
                    if (!$this->inventoryModel->isAvailableForPeriod($inventory_id, $loan_date, $return_date)) {
                        $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Maaf, barang/ruang tidak tersedia pada periode tersebut!'];
                        header('Location: ?page=peminjaman');
                        exit;
                    }
                } catch (Exception $e) {
                    // Abaikan jika tabel loans belum ada
                }

                // Buat peminjaman
                $data = [
                    'user_id' => $user_id,
                    'inventory_id' => $inventory_id,
                    'loan_date' => $loan_date,
                    'return_date' => $return_date,
                    'reason' => $reason
                ];

                if ($this->loanModel->create($data)) {
                    $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Pengajuan peminjaman berhasil! Menunggu persetujuan admin.'];
                } else {
                    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal mengajukan peminjaman. Silakan coba lagi.'];
                }

                header('Location: ?page=peminjaman');
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Terjadi kesalahan: ' . $e->getMessage()];
            header('Location: ?page=peminjaman');
            exit;
        }

        if ($action === 'cancel_loan') {
            $loan_id = $_POST['loan_id'] ?? null;
            
            if ($loan_id) {
                $loan = $this->loanModel->getById($loan_id);
                
                // Hanya bisa cancel jika masih pending dan milik user ini
                if ($loan && $loan['user_id'] == $user_id && $loan['status'] === 'pending') {
                    if ($this->loanModel->delete($loan_id)) {
                        $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Pengajuan peminjaman berhasil dibatalkan.'];
                    } else {
                        $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal membatalkan pengajuan.'];
                    }
                } else {
                    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Tidak dapat membatalkan pengajuan ini.'];
                }
            }

            header('Location: ?page=peminjaman');
            exit;
        }
    }

    /**
     * Public method untuk create loan (dipanggil dari routing)
     */
    public function createLoan() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
            header("Location: ?page=login");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        
        $inventory_id = $_POST['inventory_id'] ?? null;
        $loan_date = $_POST['loan_date'] ?? null;
        $return_date = $_POST['return_date'] ?? null;
        $reason = trim($_POST['reason'] ?? '');

        // Validasi
        if (!$inventory_id || !$loan_date || !$return_date) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Semua field wajib diisi!'];
            header('Location: ?page=peminjaman');
            exit;
        }

        // Validasi tanggal
        $loanDateTime = strtotime($loan_date);
        $returnDateTime = strtotime($return_date);

        if ($loanDateTime < strtotime(date('Y-m-d'))) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Tanggal peminjaman tidak boleh kurang dari hari ini!'];
            header('Location: ?page=peminjaman');
            exit;
        }

        if ($returnDateTime <= $loanDateTime) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Tanggal pengembalian harus setelah tanggal peminjaman!'];
            header('Location: ?page=peminjaman');
            exit;
        }

        // Cek apakah user sudah meminjam barang yang sama dan belum dikembalikan
        try {
            if ($this->loanModel->hasActiveLoanForItem($user_id, $inventory_id)) {
                $_SESSION['flash_message'] = ['type' => 'warning', 'text' => 'Anda sudah meminjam barang/ruang ini dan belum dikembalikan. Silakan kembalikan terlebih dahulu!'];
                header('Location: ?page=peminjaman');
                exit;
            }
        } catch (Exception $e) {
            // Abaikan jika ada error
        }

        // Buat peminjaman
        $data = [
            'user_id' => $user_id,
            'inventory_id' => $inventory_id,
            'loan_date' => $loan_date,
            'return_date' => $return_date,
            'reason' => $reason
        ];

        try {
            if ($this->loanModel->create($data)) {
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Pengajuan peminjaman berhasil! Menunggu persetujuan admin.'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal mengajukan peminjaman. Silakan coba lagi.'];
            }
        } catch (Exception $e) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Error: ' . $e->getMessage()];
        }

        header('Location: ?page=peminjaman');
        exit;
    }

    /**
     * Public method untuk cancel loan (dipanggil dari routing)
     */
    public function cancelLoan() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
            header("Location: ?page=login");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $loan_id = $_POST['loan_id'] ?? null;
        
        if ($loan_id) {
            try {
                $loan = $this->loanModel->getById($loan_id);
                
                if ($loan && $loan['user_id'] == $user_id && $loan['status'] === 'pending') {
                    if ($this->loanModel->delete($loan_id)) {
                        $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Pengajuan peminjaman berhasil dibatalkan.'];
                    } else {
                        $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal membatalkan pengajuan.'];
                    }
                } else {
                    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Tidak dapat membatalkan pengajuan ini.'];
                }
            } catch (Exception $e) {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Error: ' . $e->getMessage()];
            }
        }

        header('Location: ?page=peminjaman');
        exit;
    }

    /**
     * Halaman admin untuk kelola peminjaman
     */
    public function adminIndex() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $this->handleAdminAction();
        }

        $filter = $_GET['filter'] ?? 'all';
        
        if ($filter === 'pending') {
            $loans = $this->loanModel->getPending();
        } elseif ($filter === 'active') {
            $loans = $this->loanModel->getActive();
        } elseif ($filter === 'overdue') {
            $loans = $this->loanModel->getOverdue();
        } elseif ($filter === 'returned') {
            $loans = $this->loanModel->getReturned();
        } else {
            $loans = $this->loanModel->getAll();
        }

        $stats = $this->loanModel->getStats();
        
        $flash_message = $_SESSION['flash_message'] ?? null;
        unset($_SESSION['flash_message']);
        
        $nama_pengguna = $_SESSION['full_name'] ?? 'Administrator';

        require __DIR__ . '/../views/admin/loans.php';
    }

    /**
     * Handle aksi dari admin
     */
    private function handleAdminAction() {
        $action = $_POST['action'];
        $loan_id = $_POST['loan_id'] ?? null;

        if (!$loan_id) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'ID peminjaman tidak valid.'];
            header('Location: ?page=admin-loans');
            exit;
        }

        if ($action === 'approve') {
            $admin_note = trim($_POST['admin_note'] ?? '');
            
            if ($this->loanModel->updateStatus($loan_id, 'approved', $admin_note)) {
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Peminjaman berhasil disetujui.'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal menyetujui peminjaman.'];
            }
        }

        if ($action === 'reject') {
            $admin_note = trim($_POST['admin_note'] ?? '');
            
            if (empty($admin_note)) {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Alasan penolakan wajib diisi!'];
                header('Location: ?page=admin-loans');
                exit;
            }
            
            if ($this->loanModel->updateStatus($loan_id, 'rejected', $admin_note)) {
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Peminjaman berhasil ditolak.'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal menolak peminjaman.'];
            }
        }

        if ($action === 'return') {
            if ($this->loanModel->setActualReturn($loan_id)) {
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Barang/ruang berhasil dikembalikan.'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal mencatat pengembalian.'];
            }
        }

        if ($action === 'delete') {
            if ($this->loanModel->delete($loan_id)) {
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Data peminjaman berhasil dihapus.'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal menghapus data peminjaman.'];
            }
        }

        header('Location: ?page=admin-loans');
        exit;
    }

    /**
     * Approve loan (public method untuk routing)
     */
    public function approveLoan() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $loan_id = $_POST['loan_id'] ?? null;
        $admin_note = trim($_POST['admin_note'] ?? '');

        if (!$loan_id) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'ID peminjaman tidak valid.'];
            header('Location: ?page=admin-loans');
            exit;
        }

        try {
            if ($this->loanModel->updateStatus($loan_id, 'approved', $admin_note)) {
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Peminjaman berhasil disetujui.'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal menyetujui peminjaman.'];
            }
        } catch (Exception $e) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Error: ' . $e->getMessage()];
        }

        header('Location: ?page=admin-loans');
        exit;
    }

    /**
     * Reject loan (public method untuk routing)
     */
    public function rejectLoan() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $loan_id = $_POST['loan_id'] ?? null;
        $admin_note = trim($_POST['admin_note'] ?? '');

        if (!$loan_id) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'ID peminjaman tidak valid.'];
            header('Location: ?page=admin-loans');
            exit;
        }

        if (empty($admin_note)) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Alasan penolakan wajib diisi!'];
            header('Location: ?page=admin-loans');
            exit;
        }

        try {
            if ($this->loanModel->updateStatus($loan_id, 'rejected', $admin_note)) {
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Peminjaman berhasil ditolak.'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal menolak peminjaman.'];
            }
        } catch (Exception $e) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Error: ' . $e->getMessage()];
        }

        header('Location: ?page=admin-loans');
        exit;
    }

    /**
     * Return loan (public method untuk routing)
     */
    public function returnLoan() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $loan_id = $_POST['loan_id'] ?? null;

        if (!$loan_id) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'ID peminjaman tidak valid.'];
            header('Location: ?page=admin-loans');
            exit;
        }

        try {
            if ($this->loanModel->setActualReturn($loan_id)) {
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Barang/ruang berhasil dikembalikan.'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal mencatat pengembalian.'];
            }
        } catch (Exception $e) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Error: ' . $e->getMessage()];
        }

        header('Location: ?page=admin-loans');
        exit;
    }

    /**
     * Delete loan (public method untuk routing)
     */
    public function deleteLoan() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $loan_id = $_POST['loan_id'] ?? null;

        if (!$loan_id) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'ID peminjaman tidak valid.'];
            header('Location: ?page=admin-loans');
            exit;
        }

        try {
            if ($this->loanModel->delete($loan_id)) {
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Data peminjaman berhasil dihapus.'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal menghapus data peminjaman.'];
            }
        } catch (Exception $e) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Error: ' . $e->getMessage()];
        }

        header('Location: ?page=admin-loans');
        exit;
    }
}
