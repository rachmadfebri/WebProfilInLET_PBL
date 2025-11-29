<?php
// app/model/CollaborationModel.php

require_once __DIR__ . '/../../config/connection.php'; 

class CollaborationModel {
    private $db;
    private $table = 'collaborations';

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    /**
     * Mengambil semua data kolaborasi, mendukung pencarian.
     * @param string $keyword Kata kunci pencarian (opsional).
     * @return array
     */
    public function getAll($keyword = '') {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        
        if ($keyword) {
            $sql .= " WHERE name ILIKE :keyword OR description ILIKE :keyword"; // ILIKE for PostgreSQL (case-insensitive)
            $params[':keyword'] = '%' . $keyword . '%';
        }
        
        $sql .= " ORDER BY created_at DESC";
        
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
        $query = "INSERT INTO {$this->table} (name, logo, website, description, created_at) 
                  VALUES (:name, :logo, :website, :description, NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':name' => $data['name'],
            ':logo' => $data['logo'],
            ':website' => $data['website'],
            ':description' => $data['description']
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
            ':name' => $data['name'],
            ':logo' => $data['logo'],
            ':website' => $data['website'],
            ':description' => $data['description'],
            ':id' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}