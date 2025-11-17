<?php
// config/database.php
class Database {
    private $host = "localhost";
    private $port = "5432";
    private $db_name = "lab_inlet";
    private $username = "postgres"; 
    private $password = ""; 

    public function connect() {
        try {
            $pdo = new PDO(
                "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;

        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
