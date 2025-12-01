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

    if ($success) {

        return $this->db->lastInsertId('users_user_id_seq'); 
    }
    return false; 
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