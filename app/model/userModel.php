<?php
require_once __DIR__ . '/../../config/connection.php';
class userModel {
    private $db;

    public function __construct() {
        $this->db = require __DIR__ . '/../../config/connection.php';
    }

    public function createUser($fullname, $username, $email, $password, $role = 'mahasiswa') {
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $this->db->prepare("
        INSERT INTO users (full_name, username, email, password_hash, role)
        VALUES (:fullname, :username, :email, :pass, :role)
    ");

    $success = $stmt->execute([
        ':fullname' => $fullname,
        ':username' => $username,
        ':email' => $email,
        ':pass' => $hash,
        ':role' => $role
    ]);

    // PENTING: Jika INSERT berhasil, ambil ID yang baru dibuat.
    if ($success) {
        // Untuk PostgreSQL: ganti 'user_id' dengan nama kolom SERIAL/Primary Key Anda
        // Untuk MySQL: Anda dapat menggunakan $this->db->lastInsertId();
        
        // Asumsi kolom Primary Key Anda bernama 'user_id'
        return $this->db->lastInsertId('users_user_id_seq'); // <-- Contoh untuk PostgreSQL (Ganti 'users_user_id_seq' dengan nama sequence yang benar)
        
        // Jika Anda menggunakan MySQL:
        // return $this->db->lastInsertId();
    }
    return false; // Kembalikan false jika gagal
}

    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
