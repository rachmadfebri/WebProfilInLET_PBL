<?php
require_once __DIR__ . '/../model/inventoryModel.php';

class InventoryController {
    private $inventoryModel;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->inventoryModel = new InventoryModel($pdo);
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Halaman index untuk admin - Kelola inventory
     */
    public function index() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $filter = $_GET['type'] ?? null;
        $inventoryList = $this->inventoryModel->getAll($filter);
        
        $flash_message = $_SESSION['flash_message'] ?? null;
        unset($_SESSION['flash_message']);
        
        $nama_pengguna = $_SESSION['full_name'] ?? 'Administrator';

        require __DIR__ . '/../views/admin/inventory.php';
    }

    /**
     * Tambah inventory baru
     */
    public function create() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $type = $_POST['type'] ?? '';
            $description = trim($_POST['description'] ?? '');
            $is_available = isset($_POST['is_available']) ? true : false;

            // Validasi
            if (empty($name) || empty($type)) {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Nama dan tipe wajib diisi!'];
                header('Location: ?page=inventory');
                exit;
            }

            if (!in_array($type, ['barang', 'ruang'])) {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Tipe tidak valid!'];
                header('Location: ?page=inventory');
                exit;
            }

            $data = [
                'name' => $name,
                'type' => $type,
                'description' => $description,
                'is_available' => $is_available
            ];

            if ($this->inventoryModel->create($data)) {
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Inventory berhasil ditambahkan!'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal menambahkan inventory.'];
            }
            
            header('Location: ?page=inventory');
            exit;
        }

        // Jika bukan POST, redirect ke halaman inventory
        header('Location: ?page=inventory');
        exit;
    }

    /**
     * Edit inventory
     */
    public function edit($id) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $inventory = $this->inventoryModel->getById($id);
        
        if (!$inventory) {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Inventory tidak ditemukan!'];
            header('Location: ?page=inventory');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $type = $_POST['type'] ?? '';
            $description = trim($_POST['description'] ?? '');
            $is_available = isset($_POST['is_available']) ? true : false;

            // Validasi
            if (empty($name) || empty($type)) {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Nama dan tipe wajib diisi!'];
                header('Location: ?page=inventory');
                exit;
            }

            if (!in_array($type, ['barang', 'ruang'])) {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Tipe tidak valid!'];
                header('Location: ?page=inventory');
                exit;
            }

            $data = [
                'name' => $name,
                'type' => $type,
                'description' => $description,
                'is_available' => $is_available
            ];

            if ($this->inventoryModel->update($id, $data)) {
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Inventory berhasil diperbarui!'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal memperbarui inventory.'];
            }
            
            header('Location: ?page=inventory');
            exit;
        }

        // Jika bukan POST, redirect ke halaman inventory
        header('Location: ?page=inventory');
        exit;
    }

    /**
     * Hapus inventory
     */
    public function delete($id) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        if ($this->inventoryModel->delete($id)) {
            $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Inventory berhasil dihapus!'];
        } else {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Gagal menghapus inventory.'];
        }

        header('Location: ?page=inventory');
        exit;
    }
}
