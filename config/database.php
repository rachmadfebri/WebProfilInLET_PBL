<?php
// config/database.php
class Database {
    private $host = "localhost";
    private $port = "5432";
    private $db_name = "lab_inlet";
    private $username = "postgres"; 
    private $password = ""; // Change this if your PostgreSQL has a password

    public function connect() {
        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";
            error_log("Attempting to connect to PostgreSQL with DSN: " . $dsn);
            
            $pdo = new PDO(
                $dsn,
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
            
            error_log("PostgreSQL connection successful!");
            return $pdo;

        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
