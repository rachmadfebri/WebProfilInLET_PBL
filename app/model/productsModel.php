<?php
class ProductsModel {
    private $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function getAll($keyword = '') {
        $sql = "SELECT p.*, u.full_name as uploader_name 
                FROM products p 
                LEFT JOIN users u ON p.user_id = u.user_id";
        
        $params = [];

        if ($keyword) {
            $sql .= " WHERE (p.title ILIKE :keyword OR p.description ILIKE :keyword)";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY p.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT p.*, u.full_name as uploader_name 
                                    FROM products p 
                                    LEFT JOIN users u ON p.user_id = u.user_id 
                                    WHERE p.id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO products (title, description, url, thumbnail, user_id, created_at) 
                  VALUES (:title, :description, :url, :thumbnail, :user_id, NOW())";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':url'         => $data['url'], 
            ':thumbnail'   => $data['thumbnail'],
            ':user_id'     => $data['user_id'] 
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