<?php

require_once __DIR__ . '/../../config/connection.php';

class StudentModel {
    private $db;
    private $table = 'students';

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function getAll($keyword = '') {
        $sql = "SELECT s.*, u.full_name, u.email 
                FROM {$this->table} s
                JOIN users u ON s.user_id = u.user_id";
        
        $params = [];

        if ($keyword) {
            $sql .= " WHERE u.full_name ILIKE :keyword OR s.nim ILIKE :keyword OR s.program_study ILIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

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