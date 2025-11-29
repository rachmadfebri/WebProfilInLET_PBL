<?php
class ProductsModel {
    private $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    // PERBAIKAN: Tambahkan parameter $keyword
    public function getAll($keyword = '') {
        $sql = "SELECT * FROM products";
        $params = [];

        // Logika Pencarian
        if ($keyword) {
            $sql .= " WHERE title ILIKE :keyword OR description ILIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO products (title, description, url, thumbnail, created_at) 
                  VALUES (:title, :description, :url, :thumbnail, NOW())";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':url'         => $data['url'], 
            ':thumbnail'   => $data['thumbnail'],
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE products SET 
                  title = :title, 
                  description = :description, 
                  url = :url,
                  thumbnail = :thumbnail 
                  WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':url'         => $data['url'], 
            ':thumbnail'   => $data['thumbnail'],
            ':id'          => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}