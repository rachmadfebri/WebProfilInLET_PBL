<?php

class InventoryModel {
    private $db;

    public function __construct($pdo = null) {
        if ($pdo) {
            $this->db = $pdo;
        } else {
            // Fallback jika tidak ada PDO yang diberikan
            require_once __DIR__ . '/../../config/database.php';
            $database = new Database();
            $this->db = $database->connect();
        }
    }

    /**
     * Ambil semua inventory
     */
    public function getAll($type = null) {
        if ($type) {
            $sql = "SELECT * FROM inventory WHERE type = :type ORDER BY created_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':type' => $type]);
        } else {
            $sql = "SELECT * FROM inventory ORDER BY created_at DESC";
            $stmt = $this->db->query($sql);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ambil inventory berdasarkan ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM inventory WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ambil inventory yang tersedia
     */
    public function getAvailable($type = null) {
        $sql = "SELECT * FROM inventory WHERE is_available = TRUE";
        if ($type) {
            $sql .= " AND type = :type";
            $stmt = $this->db->prepare($sql . " ORDER BY name ASC");
            $stmt->execute([':type' => $type]);
        } else {
            $stmt = $this->db->prepare($sql . " ORDER BY name ASC");
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tambah inventory baru
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO inventory (name, type, description, is_available)
            VALUES (:name, :type, :description, :is_available)
        ");
        
        // Konversi boolean ke format PostgreSQL
        $isAvailable = !empty($data['is_available']) ? 't' : 'f';
        
        return $stmt->execute([
            ':name' => $data['name'],
            ':type' => $data['type'],
            ':description' => $data['description'] ?? null,
            ':is_available' => $isAvailable
        ]);
    }

    /**
     * Update inventory
     */
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE inventory 
            SET name = :name, type = :type, description = :description, is_available = :is_available
            WHERE id = :id
        ");
        
        // Konversi boolean ke format PostgreSQL
        $isAvailable = !empty($data['is_available']) ? 't' : 'f';
        
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':type' => $data['type'],
            ':description' => $data['description'] ?? null,
            ':is_available' => $isAvailable
        ]);
    }

    /**
     * Hapus inventory
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM inventory WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Cek apakah inventory tersedia untuk periode tertentu
     */
    public function isAvailableForPeriod($inventoryId, $loanDate, $returnDate) {
        // Cek apakah inventory exists dan is_available
        $item = $this->getById($inventoryId);
        if (!$item || !$item['is_available']) {
            return false;
        }

        // Cek apakah ada peminjaman yang overlap di periode ini
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as cnt FROM loans 
            WHERE inventory_id = :inventory_id 
            AND status IN ('pending', 'approved') 
            AND actual_return_date IS NULL
            AND (
                (loan_date <= :loan_date AND return_date >= :loan_date)
                OR (loan_date <= :return_date AND return_date >= :return_date)
                OR (loan_date >= :loan_date AND return_date <= :return_date)
            )
        ");
        $stmt->execute([
            ':inventory_id' => $inventoryId,
            ':loan_date' => $loanDate,
            ':return_date' => $returnDate
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['cnt'] == 0;
    }

    /**
     * Update status ketersediaan
     */
    public function updateAvailability($id, $isAvailable) {
        $stmt = $this->db->prepare("UPDATE inventory SET is_available = :is_available WHERE id = :id");
        return $stmt->execute([
            ':id' => $id,
            ':is_available' => $isAvailable
        ]);
    }
}
