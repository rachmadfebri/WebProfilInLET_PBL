<?php
require_once __DIR__ . '/../../config/connection.php'; 

class GalleryModel {
    private $db;
    private $table = 'gallery'; // Pastikan nama tabel sesuai DB

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    /**
     * Mengambil data galeri dengan fitur pencarian.
     * PERBAIKAN: Pencarian HANYA diarahkan ke kolom upload_date.
     */
    public function getAll($keyword = '') {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        // Logika Search KHUSUS TANGGAL
        if ($keyword) {
            // PERBAIKAN UTAMA:
            // Mengubah format tanggal DB (YYYY-MM-DD) menjadi string tampilan (DD Mon YYYY) misal: "28 Nov 2025"
            // Agar user bisa mencari "Nov", "28", atau "2025".
            
            // UNTUK POSTGRESQL (Sesuai error log Anda sebelumnya):
            $sql .= " WHERE TO_CHAR(upload_date, 'DD Mon YYYY') ILIKE :keyword";
            
            // CATATAN: Jika nanti pindah ke MySQL/MariaDB, ganti baris di atas dengan:
            // $sql .= " WHERE DATE_FORMAT(upload_date, '%d %b %Y') LIKE :keyword";

            $params[':keyword'] = '%' . $keyword . '%';
        }

        // Urutkan dari yang paling baru
        $sql .= " ORDER BY upload_date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($image) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (image, upload_date) VALUES (:image, NOW())");
        return $stmt->execute([':image' => $image]);
    }

    public function update($id, $image) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET image = :image WHERE id = :id");
        return $stmt->execute([':image' => $image, ':id' => $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}