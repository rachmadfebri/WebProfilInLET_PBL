<?php
require_once __DIR__ . '/../../config/connection.php';

class GuestbookModel {
    private $db;
    private $table = 'guest_book'; // Sesuaikan dengan nama tabel di DB

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    // UPDATE: Menambahkan parameter $keyword
    public function getAll($startDate = null, $endDate = null, $keyword = '') {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1"; // Gunakan WHERE 1=1 agar mudah menyambung kondisi
        $params = [];

        // Logika Filter Tanggal
        if ($startDate && $endDate) {
            $sql .= " AND sent_at BETWEEN :start AND :end";
            $params[':start'] = $startDate . ' 00:00:00';
            $params[':end'] = $endDate . ' 23:59:59';
        }

        // Logika Pencarian (Keyword)
        if (!empty($keyword)) {
            $sql .= " AND (name ILIKE :keyword OR institution ILIKE :keyword OR message ILIKE :keyword)";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY sent_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        // Menambahkan email dan phone_number sesuai struktur tabel
        $query = "INSERT INTO {$this->table} (name, institution, email, phone_number, message, sent_at) 
                  VALUES (:name, :institution, :email, :phone_number, :message, NOW())";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':name' => $data['name'],
            ':institution' => $data['institution'],
            ':email' => $data['email'] ?? null, 
            ':phone_number' => $data['phone_number'] ?? null, 
            ':message' => $data['message']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}