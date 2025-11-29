<?php
// app/model/ResearchModel.php

require_once __DIR__ . '/../../config/connection.php'; 

class ResearchModel {
    private $db;
    private $table = 'research_activities';

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    /**
     * PERBAIKAN: Menambahkan parameter $keyword = ''
     * Agar sesuai dengan Controller yang mengirim keyword pencarian.
     */
    public function getAll($keyword = '') {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        // Logika Pencarian (Search)
        if ($keyword) {
            // Menggunakan ILIKE untuk PostgreSQL (case-insensitive)
            // Jika pakai MySQL ganti ILIKE menjadi LIKE
            $sql .= " WHERE title ILIKE :keyword OR description ILIKE :keyword";
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
        $query = "INSERT INTO {$this->table} (title, description, image, created_at) 
                  VALUES (:title, :description, :image, NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':image' => $data['image']
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
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':image' => $data['image'],
            ':id' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}