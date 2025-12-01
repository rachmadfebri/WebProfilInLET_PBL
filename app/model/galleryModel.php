<?php
require_once __DIR__ . '/../../config/connection.php'; 

class GalleryModel {
    private $db;
    private $table = 'gallery'; 

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function getAll($keyword = '') {
        $sql = "SELECT g.*, u.full_name as uploader_name 
                FROM {$this->table} g
                LEFT JOIN users u ON g.user_id = u.user_id";
        
        $params = [];

        if ($keyword) {
            $sql .= " WHERE TO_CHAR(g.upload_date, 'DD Mon YYYY') ILIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY g.upload_date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($image, $user_id) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (image, user_id, upload_date) VALUES (:image, :user_id, NOW())");
        return $stmt->execute([
            ':image' => $image,
            ':user_id' => $user_id
        ]);
    }

    public function update($id, $image) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET image = :image WHERE id = :id");
        return $stmt->execute([':image' => $image, ':id' => $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}