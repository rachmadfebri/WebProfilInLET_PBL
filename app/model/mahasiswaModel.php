<?php
// app/models/MahasiswaModel.php

class MahasiswaModel {
    private $db;

    public function __construct() {
        // Pastikan path ke connection.php sudah benar
        $this->db = (require __DIR__ . '/../../config/connection.php');
    }

    /**
     * Mengecek dan mengambil data mahasiswa berdasarkan user_id.
     * @param int $user_id
     * @return array|false
     */
   public function getStudentData(int $user_id) {
    // Tambahkan kondisi 'AND nim IS NOT NULL' pada query
    $sql = "SELECT * FROM students 
            WHERE user_id = :id 
            AND nim IS NOT NULL"; 

    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $user_id]);
    
    // Jika data ditemukan dan NIM sudah terisi, fetch data.
    return $stmt->fetch();
}

    /**
     * Melakukan INSERT atau UPDATE data mahasiswa.
     * Cek apakah NIM sudah ada di database (dari user lain).
     */
    public function createOrUpdate(int $user_id, array $data) {
        // Cek apakah data untuk user_id ini sudah ada
        $stmt = $this->db->prepare("SELECT user_id FROM students WHERE user_id = :id");
        $stmt->execute([':id' => $user_id]);

        if ($stmt->fetch()) {
            // Data sudah ada untuk user ini, lakukan UPDATE
            $query = "
                UPDATE students 
                SET nim = :nim, program_study = :program_study, batch = :batch, activity_type = :activity_type
                WHERE user_id = :id
            ";
        } else {
            // Data belum ada, cek apakah NIM sudah digunakan user lain
            $checkNim = $this->db->prepare("SELECT user_id FROM students WHERE nim = :nim");
            $checkNim->execute([':nim' => $data['nim'] ?? null]);
            
            if ($checkNim->fetch()) {
                // NIM sudah digunakan, throw error
                throw new Exception("NIM {$data['nim']} sudah terdaftar di sistem.");
            }
            
            // NIM belum digunakan, lakukan INSERT
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