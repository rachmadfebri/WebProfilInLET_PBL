<?php
// app/models/AttendanceModel.php - FINAL PostgreSQL Version
// Struktur tabel:
// - id (serial4) PRIMARY KEY
// - user_id (int4) NOT NULL REFERENCES users(id)
// - check_in_time (timestamptz) NOT NULL
// - check_out_time (timestamptz) NULL
// - activity_description (text) NULL
// - created_at (timestamp) NULL

require_once __DIR__ . '/../../config/database.php'; 

class AttendanceModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        
        if (!$this->db) {
            throw new Exception("Failed to establish database connection");
        }
    }

    /**
     * Mencatat waktu masuk (Check-In)
     * @param int $user_id
     * @return bool
     */
    public function checkIn(int $user_id): bool {
        error_log("=== CheckIn START (PostgreSQL) ===");
        error_log("User ID: " . $user_id);
        error_log("DB Object type: " . gettype($this->db));
        
        // Cek duplikasi 
        $latestAttendance = $this->getLatestTodayAttendance($user_id);
        error_log("Latest attendance: " . json_encode($latestAttendance));
        
        if ($latestAttendance && is_null($latestAttendance['check_out_time'])) {
            error_log("Duplicate check-in prevented - User already checked in");
            error_log("=== CheckIn END (DUPLICATE) ===");
            return false; 
        }

        // PostgreSQL INSERT dengan RETURNING clause
        $query = "INSERT INTO attendance (user_id, check_in_time, activity_description, created_at) 
                  VALUES (?, NOW() AT TIME ZONE 'Asia/Jakarta', ?, NOW())
                  RETURNING id";
        
        error_log("Query: " . $query);
        error_log("Params: user_id=" . $user_id . ", activity_description='Check-In'");
        
        try {
            if (!$this->db) {
                error_log("❌ DATABASE CONNECTION IS NULL!");
                error_log("=== CheckIn END (NO DB CONNECTION) ===");
                return false;
            }
            
            $stmt = $this->db->prepare($query);
            
            if (!$stmt) {
                error_log("❌ PREPARE FAILED!");
                error_log("PDO Error Info: " . json_encode($this->db->errorInfo()));
                error_log("=== CheckIn END (PREPARE FAILED) ===");
                return false;
            }
            
            // Execute
            $result = $stmt->execute([$user_id, 'Attendance']);
            
            if ($result) {
                // P]ambil ID dari RETURNING clause
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $lastId = $row['id'] ?? 'unknown';
                error_log("✅ Check-in SUCCESS! Inserted ID: " . $lastId);
                error_log("=== CheckIn END (SUCCESS) ===");
                return true;
            } else {
                error_log("❌ Execute returned false");
                error_log("Statement Error Info: " . json_encode($stmt->errorInfo()));
                error_log("=== CheckIn END (EXECUTE FAILED) ===");
                return false;
            }
            
        } catch (PDOException $e) {
            error_log("❌ EXCEPTION CAUGHT!");
            error_log("Message: " . $e->getMessage());
            error_log("Code: " . $e->getCode());
            
            if (isset($e->errorInfo)) {
                error_log("SQLSTATE: " . ($e->errorInfo[0] ?? 'N/A'));
                error_log("Driver Error Code: " . ($e->errorInfo[1] ?? 'N/A'));
                error_log("Driver Error Message: " . ($e->errorInfo[2] ?? 'N/A'));
            }
            
            if (strpos($e->getMessage(), 'foreign key') !== false) {
                error_log("⚠️ FOREIGN KEY VIOLATION: user_id " . $user_id . " tidak ada di tabel users!");
            }
            
            error_log("=== CheckIn END (EXCEPTION) ===");
            return false;
        } catch (Exception $e) {
            error_log("❌ GENERAL EXCEPTION: " . $e->getMessage());
            error_log("=== CheckIn END (EXCEPTION) ===");
            return false;
        }
    }

    /**
     * Mencatat waktu keluar (Check-Out)
     * @param int $attendance_id ID dari record absensi yang akan diupdate
     * @return bool
     */
    public function checkOut(int $attendance_id): bool {
        error_log("=== CheckOut START (PostgreSQL) ===");
        error_log("Attendance ID: " . $attendance_id);
        
        // update check_out_time dengan timezone yang benar
        $query = "UPDATE attendance 
                  SET check_out_time = NOW() AT TIME ZONE 'Asia/Jakarta'
                  WHERE id = ? 
                  AND check_out_time IS NULL"; 

        try {
            if (!$this->db) {
                error_log("❌ DATABASE CONNECTION IS NULL!");
                error_log("=== CheckOut END (NO DB CONNECTION) ===");
                return false;
            }
            
            $stmt = $this->db->prepare($query);
            
            if (!$stmt) {
                error_log("❌ PREPARE FAILED!");
                error_log("PDO Error Info: " . json_encode($this->db->errorInfo()));
                error_log("=== CheckOut END (PREPARE FAILED) ===");
                return false;
            }
            
            $result = $stmt->execute([$attendance_id]);
            $rowCount = $stmt->rowCount();
            
            error_log("Execute result: " . ($result ? 'true' : 'false'));
            error_log("Rows affected: " . $rowCount);
            
            if ($result && $rowCount > 0) {
                error_log("✅ Check-out SUCCESS!");
                error_log("=== CheckOut END (SUCCESS) ===");
                return true;
            } else {
                error_log("❌ Check-out FAILED - No rows affected");
                error_log("Possible reason: ID not found or already checked out");
                error_log("Statement Error Info: " . json_encode($stmt->errorInfo()));
                error_log("=== CheckOut END (NO ROWS AFFECTED) ===");
                return false;
            }
            
        } catch (PDOException $e) {
            error_log("❌ EXCEPTION: " . $e->getMessage());
            error_log("SQLSTATE: " . $e->getCode());
            error_log("=== CheckOut END (EXCEPTION) ===");
            return false;
        } catch (Exception $e) {
            error_log("❌ GENERAL EXCEPTION: " . $e->getMessage());
            error_log("=== CheckOut END (EXCEPTION) ===");
            return false;
        }
    }

    /**
     * Mengecek apakah waktu saat ini sudah boleh untuk check-in (setelah jam 07:00)
     * Menggunakan timezone Asia/Jakarta untuk konsistensi dengan database
     */
    public function isCheckInTimeAllowed(): bool {
        // Set timezone ke Asia/Jakarta untuk memastikan waktu yang benar
        $jakartaTimezone = new DateTimeZone('Asia/Jakarta');
        $now = new DateTime('now', $jakartaTimezone);
        $current_hour = (int)$now->format('H');
        
        error_log("isCheckInTimeAllowed - Current Jakarta time: " . $now->format('Y-m-d H:i:s') . ", Hour: " . $current_hour);
        
        return $current_hour >= 7; 
    }

    /**
     * Mengecek apakah waktu saat ini masih boleh untuk aktivitas (sebelum jam 22:00)
     * Menggunakan timezone Asia/Jakarta untuk konsistensi dengan database
     */
    public function isActivityTimeAllowed(): bool {
        // Set timezone ke Asia/Jakarta untuk memastikan waktu yang benar
        $jakartaTimezone = new DateTimeZone('Asia/Jakarta');
        $now = new DateTime('now', $jakartaTimezone);
        $current_hour = (int)$now->format('H');
        
        error_log("isActivityTimeAllowed - Current Jakarta time: " . $now->format('Y-m-d H:i:s') . ", Hour: " . $current_hour);
        
        return $current_hour < 22; 
    }

    /**
     * Mengambil record absensi terbaru untuk user_id tertentu pada hari ini.
     * @param int $user_id The ID of the user.
     * @return array|false Associative array of attendance data or false.
     */
    public function getLatestTodayAttendance(int $user_id) {
        // PostgreSQL: Cast timestamp to date untuk perbandingan. menggunakan AT TIME ZONE untuk memastikan timezone konsisten
        $query = "SELECT a.*, u.full_name, u.email 
                  FROM attendance a
                  LEFT JOIN users u ON a.user_id = u.user_id
                  WHERE a.user_id = ? 
                  AND (a.check_in_time AT TIME ZONE 'Asia/Jakarta')::date = CURRENT_DATE
                  ORDER BY a.check_in_time DESC 
                  LIMIT 1"; 

        try {
            if (!$this->db) {
                error_log("Database connection is null in getLatestTodayAttendance!");
                return false;
            }
            
            $stmt = $this->db->prepare($query);
            
            if (!$stmt) {
                error_log("Prepare failed in getLatestTodayAttendance!");
                error_log("PDO Error: " . json_encode($this->db->errorInfo()));
                return false;
            }
            
            $executeResult = $stmt->execute([$user_id]);
            
            if (!$executeResult) {
                error_log("Execute failed in getLatestTodayAttendance!");
                error_log("Statement Error: " . json_encode($stmt->errorInfo()));
                return false;
            }
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            error_log("getLatestTodayAttendance for user_id " . $user_id);
            error_log("Query result: " . json_encode($result));
            
            // return false jika tidak ada data, not empty array
            return $result ?: false;
            
        } catch (PDOException $e) {
            error_log("Database error in getLatestTodayAttendance: " . $e->getMessage());
            error_log("SQLSTATE: " . $e->getCode());
            return false;
        } catch (Exception $e) {
            error_log("General error in getLatestTodayAttendance: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Mengambil status absensi hari ini (record terbaru).
     * @param int $userId The ID of the user.
     * @return array|false Associative array of attendance data (terbaru hari ini) or false.
     */
    public function getTodayAttendanceData($userId) {
        return $this->getLatestTodayAttendance($userId);
    }
    
    /**
     * Helper method: Mendapatkan semua attendance hari ini
     * Berguna untuk admin dashboard atau debugging
     */
    public function getAllAttendanceToday() {
        $query = "SELECT a.*, u.full_name, u.email 
                  FROM attendance a
                  LEFT JOIN users u ON a.user_id = u.user_id
                  WHERE a.check_in_time::date = CURRENT_DATE
                  ORDER BY a.check_in_time DESC";
        
        try {
            $stmt = $this->db->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAllAttendanceToday: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Helper method: Mendapatkan history attendance untuk user tertentu
     * @param int $user_id
     * @param int $limit Jumlah record yang diambil (default: 30)
     * @return array
     */
    public function getUserAttendanceHistory(int $user_id, int $limit = 30) {
        $query = "SELECT * FROM attendance 
                  WHERE user_id = $1 
                  ORDER BY check_in_time DESC 
                  LIMIT $2";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([$user_id, $limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getUserAttendanceHistory: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Helper method: Mendapatkan semua attendance data (all time atau dengan filter date)
     * @param string $startDate (optional) Format: YYYY-MM-DD
     * @param string $endDate (optional) Format: YYYY-MM-DD
     * @return array
     */
    public function getAllAttendance($startDate = null, $endDate = null) {
        // First, let's try a simple query to check if attendance table has data
        try {
            $countQuery = "SELECT COUNT(*) FROM attendance";
            $countStmt = $this->db->query($countQuery);
            $totalAttendance = $countStmt->fetchColumn();
            error_log("Total attendance records in database: " . $totalAttendance);
            
            $countUsersQuery = "SELECT COUNT(*) FROM users";
            $countUsersStmt = $this->db->query($countUsersQuery);
            $totalUsers = $countUsersStmt->fetchColumn();
            error_log("Total users in database: " . $totalUsers);
        } catch (Exception $e) {
            error_log("Error counting records: " . $e->getMessage());
        }
        
        // Use LEFT JOIN to include attendance records even if user doesn't exist
        $query = "SELECT a.id, a.user_id, a.check_in_time, a.check_out_time, 
                         a.activity_description, a.created_at,
                         COALESCE(u.full_name, 'User ID: ' || a.user_id) as full_name, 
                         COALESCE(u.email, 'No email') as email 
                  FROM attendance a
                  LEFT JOIN users u ON a.user_id = u.user_id
                  WHERE 1=1";
        
        $params = [];

        // Handle single date filter (when startDate and endDate are the same)
        if ($startDate && $endDate && $startDate === $endDate) {
            $query .= " AND a.check_in_time::date = ?";
            $params[] = $startDate;
        } 
        // Handle date range filter
        elseif ($startDate && $endDate) {
            $query .= " AND a.check_in_time::date BETWEEN ? AND ?";
            $params[] = $startDate;
            $params[] = $endDate;
        }
        // Handle only startDate (filter for specific date)
        elseif ($startDate) {
            $query .= " AND a.check_in_time::date = ?";
            $params[] = $startDate;
        }

        $query .= " ORDER BY a.check_in_time DESC";

        try {
            error_log("getAllAttendance Query: " . $query);
            error_log("getAllAttendance Params: " . json_encode($params));
            
            if (!empty($params)) {
                $stmt = $this->db->prepare($query);
                $stmt->execute($params);
            } else {
                $stmt = $this->db->query($query);
            }
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("getAllAttendance query executed successfully. Returned " . count($result) . " records.");
            
            // Log first few records for debugging
            if (!empty($result)) {
                error_log("Sample record: " . json_encode($result[0]));
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error in getAllAttendance: " . $e->getMessage());
            error_log("Query was: " . $query);
            error_log("Params were: " . json_encode($params));
            error_log("PDO Error Code: " . $e->getCode());
            return [];
        }
    }

    /**
     * Simple method to get all attendance without any filters for debugging
     */
    public function getAllAttendanceRaw() {
        try {
            $query = "SELECT a.*, 
                             COALESCE(u.full_name, 'User ID: ' || a.user_id) as full_name, 
                             COALESCE(u.email, 'No email') as email 
                      FROM attendance a
                      LEFT JOIN users u ON a.user_id = u.user_id
                      ORDER BY a.check_in_time DESC";
            
            error_log("Raw query: " . $query);
            $stmt = $this->db->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Raw query returned " . count($result) . " records");
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error in getAllAttendanceRaw: " . $e->getMessage());
            return [];
        }
    }
}