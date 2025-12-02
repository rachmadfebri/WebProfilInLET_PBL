<?php

class MahasiswaModel {
    private $db;

    public function __construct() {
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
            $query = "
                UPDATE students 
                SET nim = :nim, program_study = :program_study, batch = :batch, activity_type = :activity_type
                WHERE user_id = :id
            ";
        } else {
            // data belum ada, cek apakah NIM sudah digunakan user lain
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

    /**
     * Update profile mahasiswa (email, password, NIM, full_name, program_study, batch)
     * @param int $user_id
     * @param array $data Email, password (optional), NIM, full_name, program_study, batch
     * @return bool
     */
    public function getPasswordHash(int $user_id) {
        // Query ambil password lama
        $stmt = $this->db->prepare("SELECT password_hash FROM users WHERE user_id = :id");
        $stmt->execute([':id' => $user_id]);
        $data = $stmt->fetch();
        
        // Kembalikan isi kolom password_hash
        return $data ? $data['password_hash'] : false;
    }

    public function updateProfile(int $user_id, array $data) {
        $updateFieldsUsers = [];
        $updateFieldsStudents = [];
        $paramsUsers = [':id' => $user_id];
        $paramsStudents = [':id' => $user_id];

        // Update users table fields
        if (isset($data['email'])) {
            $updateFieldsUsers[] = "email = :email";
            $paramsUsers[':email'] = $data['email'];
        }

        if (isset($data['full_name'])) {
            $updateFieldsUsers[] = "full_name = :full_name";
            $paramsUsers[':full_name'] = $data['full_name'];
        }

        // --- BAGIAN INI DIPERBAIKI (Mapping ke kolom 'password_hash') ---
        if (isset($data['password'])) {
            // Perhatikan: nama kolom di database adalah 'password_hash'
            $updateFieldsUsers[] = "password_hash = :password";
            $paramsUsers[':password'] = $data['password'];
        }
        // ----------------------------------------------------------------

        // Update students table fields
        if (isset($data['nim'])) {
            $updateFieldsStudents[] = "nim = :nim";
            $paramsStudents[':nim'] = $data['nim'];
        }

        if (isset($data['program_study'])) {
            $updateFieldsStudents[] = "program_study = :program_study";
            $paramsStudents[':program_study'] = $data['program_study'];
        }

        if (isset($data['batch'])) {
            $updateFieldsStudents[] = "batch = :batch";
            $paramsStudents[':batch'] = $data['batch'];
        }

        // Execute users table update
        if (!empty($updateFieldsUsers)) {
            $queryUsers = "UPDATE users SET " . implode(", ", $updateFieldsUsers) . " WHERE user_id = :id";
            $stmtUsers = $this->db->prepare($queryUsers);
            if (!$stmtUsers->execute($paramsUsers)) {
                return false;
            }
        }

        // Execute students table update
        if (!empty($updateFieldsStudents)) {
            $queryStudents = "UPDATE students SET " . implode(", ", $updateFieldsStudents) . " WHERE user_id = :id";
            $stmtStudents = $this->db->prepare($queryStudents);
            if (!$stmtStudents->execute($paramsStudents)) {
                return false;
            }
        }

        return true;
    }
}