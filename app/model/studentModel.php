<?php
// app/model/StudentModel.php

require_once __DIR__ . '/../../config/connection.php';

class StudentModel {
    private $db;
    private $table = 'students';

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function getAll($keyword = '') {
        // PERBAIKAN:
        // 1. Join ke users menggunakan u.user_id (sesuai FK di tabel students)
        // 2. Menghapus u.avatar karena kolom tersebut tidak ada
        $sql = "SELECT s.*, u.full_name, u.email 
                FROM {$this->table} s
                JOIN users u ON s.user_id = u.user_id";
        
        $params = [];

        if ($keyword) {
            // Pencarian case-insensitive (ILIKE untuk PostgreSQL, LIKE untuk MySQL)
            $sql .= " WHERE u.full_name ILIKE :keyword OR s.nim ILIKE :keyword OR s.program_study ILIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        // Urutkan berdasarkan angkatan terbaru
        $sql .= " ORDER BY s.batch DESC"; 

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($student_id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE student_id = :id");
        return $stmt->execute([':id' => $student_id]);
    }
}