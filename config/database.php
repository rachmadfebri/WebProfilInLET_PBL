<?php
// config/database.php
class Database {
    private $host = "localhost";
    private $port = "5432";
    private $db_name = "lab_inlet";
    private $username = "postgres"; 
    private $password = ""; 
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}",
                                  $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Koneksi gagal: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
