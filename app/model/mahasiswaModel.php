<?php
class mahasiswaModel {
    private $db;

    public function __construct() {
        $this->db = require __DIR__ . '/../../config/connection.php';
    }

    public function createOrUpdate(int $user_id, array $data) {
        $stmt = $this->db->prepare("SELECT user_id FROM students WHERE user_id = :id");
        $stmt->execute([':id' => $user_id]);

        if ($stmt->fetch()) {
            $query = "
                UPDATE students 
                SET nim = :nim, program_study = :program_study, batch = :batch, activity_type = :activity_type
                WHERE user_id = :id
            ";
        } else {
            $query = "
                INSERT INTO students (user_id, nim, program_study, batch, activity_type)
                VALUES (:id, :nim, :program_study, :batch, :activity_type)
            ";
        }

        $st = $this->db->prepare($query);
        return $st->execute([
            ':id'            => $user_id,
            ':nim'           => $data['nim'] ?? null,
            ':program_study' => $data['program_study'] ?? null,
            ':batch'         => $data['batch'] ?? null,
            ':activity_type' => $data['activity_type'] ?? null,
        ]);
    }
}
