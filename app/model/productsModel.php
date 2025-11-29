<?php
class ProductsModel {
    private $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM products ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // PERBAIKAN FUNGSI CREATE
    public function create($data) {
        // Tambahkan :url di VALUES
        $query = "INSERT INTO products (title, description, url, thumbnail, created_at) 
                  VALUES (:title, :description, :url, :thumbnail, NOW())";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':url'         => $data['url'], // Bind URL
            ':thumbnail'   => $data['thumbnail'],
        ]);
    }

    // PERBAIKAN FUNGSI UPDATE
    public function update($id, $data) {
        // Tambahkan url = :url
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
            ':url'         => $data['url'], // Bind URL
            ':thumbnail'   => $data['thumbnail'],
            ':id'          => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}