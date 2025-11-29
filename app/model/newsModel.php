<?php
class NewsModel {
    private $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM news ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM news WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO news (title, content, thumbnail, published_date, created_at) 
                  VALUES (:title, :content, :thumbnail, :published_date, NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':thumbnail' => $data['thumbnail'],
            ':published_date' => $data['published_date']
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE news SET 
                  title = :title, 
                  content = :content, 
                  published_date = :published_date,
                  thumbnail = :thumbnail 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':published_date' => $data['published_date'],
            ':thumbnail' => $data['thumbnail'],
            ':id' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM news WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}