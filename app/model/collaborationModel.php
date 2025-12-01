<?php

require_once __DIR__ . '/../../config/connection.php'; 

class CollaborationModel {
    private $db;
    private $table = 'collaborations';

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function getAll($keyword = '') {
        $sql = "SELECT c.*, u.full_name AS uploader_name 
                FROM {$this->table} c
                LEFT JOIN users u ON c.user_id = u.user_id";
        
        $params = [];
        
        if ($keyword) {
            $sql .= " WHERE c.name ILIKE :keyword OR c.description ILIKE :keyword"; 
            $params[':keyword'] = '%' . $keyword . '%';
        }
        
        $sql .= " ORDER BY c.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO {$this->table} (name, logo, website, description, user_id, created_at) 
                  VALUES (:name, :logo, :website, :description, :user_id, NOW())";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':name'        => $data['name'],
            ':logo'        => $data['logo'],
            ':website'     => $data['website'],
            ':description' => $data['description'],
            ':user_id'     => $data['user_id'] 
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET 
                  name = :name, 
                  logo = :logo, 
                  website = :website, 
                  description = :description 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':name'        => $data['name'],
            ':logo'        => $data['logo'],
            ':website'     => $data['website'],
            ':description' => $data['description'],
            ':id'          => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}