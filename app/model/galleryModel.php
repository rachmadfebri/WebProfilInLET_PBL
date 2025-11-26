<?php
// app/model/GalleryModel.php

class galleryModel {
    private $db;

    public function __construct(PDO $pdo) {
        // Menerima koneksi PDO dari Controller
        $this->db = $pdo;
    }

    /**
     * Mengambil semua entri galeri.
     * @return array|false
     */
    public function getAll() {
        // Asumsi tabel Anda bernama 'galleries' dan memiliki kolom 'id', 'title', 'image_url', 'created_at'
         $stmt = $this->db->prepare("SELECT * FROM gallery ORDER BY upload_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Mengambil satu gambar berdasarkan ID.
     * @param int $id
     * @return array|false
     */
    public function getById(int $id) {
         $stmt = $this->db->prepare("SELECT * FROM gallery WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Anda bisa menambahkan fungsi create, update, dan delete di sini (misal: untuk CRUD Admin)
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