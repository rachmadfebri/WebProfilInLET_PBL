<?php
class GalleryModel {
    private $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM gallery ORDER BY upload_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM gallery WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($image) {
        $stmt = $this->db->prepare("INSERT INTO gallery (image, upload_date) VALUES (:image, NOW())");
        return $stmt->execute([':image' => $image]);
    }

    public function update($id, $image) {
        $stmt = $this->db->prepare("UPDATE gallery SET image = :image WHERE id = :id");
        return $stmt->execute([':image' => $image, ':id' => $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM gallery WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}