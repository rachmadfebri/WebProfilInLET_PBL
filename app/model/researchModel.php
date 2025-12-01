<?php

require_once __DIR__ . '/../../config/connection.php'; 

class ResearchModel {
    private $db;
    private $table = 'research_activities';

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function getAll($keyword = '') {
        $sql = "SELECT r.*, u.full_name AS uploader_name 
                FROM {$this->table} r
                LEFT JOIN users u ON r.user_id = u.user_id";
        
        $params = [];

        if ($keyword) {
            $sql .= " WHERE r.title ILIKE :keyword OR r.description ILIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY r.created_at DESC";

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
        $query = "INSERT INTO {$this->table} (title, description, image, user_id, created_at) 
                  VALUES (:title, :description, :image, :user_id, NOW())";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':image'       => $data['image'],
            ':user_id'     => $data['user_id']
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET 
                  title = :title, 
                  description = :description, 
                  image = :image 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':image'       => $data['image'],
            ':id'          => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}