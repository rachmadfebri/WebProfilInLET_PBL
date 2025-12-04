<?php
require_once __DIR__ . '/../../config/database.php';

class LoanModel {
    private $db;

    public function __construct($pdo = null) {
        if ($pdo) {
            $this->db = $pdo;
        } else {
            $database = new Database();
            $this->db = $database->connect();
        }
    }

    /**
     * Ambil semua peminjaman dengan join ke inventory dan users
     */
    public function getAll($status = null) {
        $sql = "
            SELECT l.*, i.name as inventory_name, i.type as inventory_type, 
                   u.full_name as user_name, u.email as user_email
            FROM loans l
            JOIN inventory i ON l.inventory_id = i.id
            JOIN users u ON l.user_id = u.user_id
        ";
        
        if ($status) {
            $sql .= " WHERE l.status = :status";
            $sql .= " ORDER BY l.created_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':status' => $status]);
        } else {
            $sql .= " ORDER BY l.created_at DESC";
            $stmt = $this->db->query($sql);
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ambil peminjaman berdasarkan user_id
     */
    public function getByUserId($userId, $status = null) {
        $sql = "
            SELECT l.*, i.name as inventory_name, i.type as inventory_type
            FROM loans l
            JOIN inventory i ON l.inventory_id = i.id
            WHERE l.user_id = :user_id
        ";
        
        $params = [':user_id' => $userId];
        
        if ($status) {
            $sql .= " AND l.status = :status";
            $params[':status'] = $status;
        }
        
        $sql .= " ORDER BY l.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ambil peminjaman berdasarkan ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT l.*, i.name as inventory_name, i.type as inventory_type,
                   u.full_name as user_name, u.email as user_email
            FROM loans l
            JOIN inventory i ON l.inventory_id = i.id
            JOIN users u ON l.user_id = u.user_id
            WHERE l.id = :id
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Buat peminjaman baru
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO loans (user_id, inventory_id, loan_date, return_date, reason, status)
            VALUES (:user_id, :inventory_id, :loan_date, :return_date, :reason, 'pending')
        ");
        
        $success = $stmt->execute([
            ':user_id' => $data['user_id'],
            ':inventory_id' => $data['inventory_id'],
            ':loan_date' => $data['loan_date'],
            ':return_date' => $data['return_date'],
            ':reason' => $data['reason'] ?? null
        ]);
        
        if ($success) {
            return $this->db->lastInsertId('loans_id_seq');
        }
        return false;
    }

    /**
     * Update status peminjaman (approve/reject)
     */
    public function updateStatus($id, $status, $adminNote = null) {
        $stmt = $this->db->prepare("
            UPDATE loans 
            SET status = :status, admin_note = :admin_note
            WHERE id = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':status' => $status,
            ':admin_note' => $adminNote
        ]);
    }

    /**
     * Set tanggal pengembalian aktual
     */
    public function setActualReturn($id) {
        $stmt = $this->db->prepare("
            UPDATE loans 
            SET actual_return_date = CURRENT_TIMESTAMP, status = 'returned'
            WHERE id = :id
        ");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Hapus peminjaman
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM loans WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Ambil peminjaman pending
     */
    public function getPending() {
        return $this->getAll('pending');
    }

    /**
     * Ambil peminjaman yang sudah dikembalikan
     */
    public function getReturned() {
        return $this->getAll('returned');
    }

    /**
     * Ambil peminjaman aktif (approved tapi belum dikembalikan)
     */
    public function getActive() {
        $stmt = $this->db->prepare("
            SELECT l.*, i.name as inventory_name, i.type as inventory_type,
                   u.full_name as user_name, u.email as user_email
            FROM loans l
            JOIN inventory i ON l.inventory_id = i.id
            JOIN users u ON l.user_id = u.user_id
            WHERE l.status = 'approved' AND l.actual_return_date IS NULL
            ORDER BY l.return_date ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cek peminjaman yang sudah melewati batas waktu
     */
    public function getOverdue() {
        $stmt = $this->db->prepare("
            SELECT l.*, i.name as inventory_name, i.type as inventory_type,
                   u.full_name as user_name, u.email as user_email
            FROM loans l
            JOIN inventory i ON l.inventory_id = i.id
            JOIN users u ON l.user_id = u.user_id
            WHERE l.status = 'approved' 
            AND l.actual_return_date IS NULL 
            AND l.return_date < CURRENT_TIMESTAMP
            ORDER BY l.return_date ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Hitung statistik peminjaman
     */
    public function getStats() {
        $stmt = $this->db->query("
            SELECT 
                COUNT(*) FILTER (WHERE status = 'pending') as pending,
                COUNT(*) FILTER (WHERE status = 'approved' AND actual_return_date IS NULL) as active,
                COUNT(*) FILTER (WHERE status = 'approved' AND actual_return_date IS NULL AND return_date < CURRENT_TIMESTAMP) as overdue,
                COUNT(*) FILTER (WHERE status = 'returned') as returned,
                COUNT(*) FILTER (WHERE status = 'rejected') as rejected
            FROM loans
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ambil peminjaman aktif untuk user tertentu
     */
    public function getActiveByUserId($userId) {
        $stmt = $this->db->prepare("
            SELECT l.*, i.name as inventory_name, i.type as inventory_type
            FROM loans l
            JOIN inventory i ON l.inventory_id = i.id
            WHERE l.user_id = :user_id 
            AND l.status = 'approved' 
            AND l.actual_return_date IS NULL
            ORDER BY l.return_date ASC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cek apakah user sudah meminjam barang yang sama dan belum dikembalikan
     */
    public function hasActiveLoanForItem($userId, $inventoryId) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as cnt FROM loans 
            WHERE user_id = :user_id 
            AND inventory_id = :inventory_id 
            AND status IN ('pending', 'approved') 
            AND actual_return_date IS NULL
        ");
        $stmt->execute([
            ':user_id' => $userId,
            ':inventory_id' => $inventoryId
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['cnt'] > 0;
    }
}
