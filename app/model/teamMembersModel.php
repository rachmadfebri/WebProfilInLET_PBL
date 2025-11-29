<?php
class TeamMembersModel {
    private $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    // PERBAIKAN: Tambahkan parameter $keyword
    public function getAll($keyword = '') {
        $sql = "SELECT * FROM team_members";
        $params = [];

        // Logika Pencarian
        if ($keyword) {
            $sql .= " WHERE name ILIKE :keyword OR position ILIKE :keyword OR email ILIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM team_members WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO team_members (name, position, photo, email, google_scholar, twitter, instagram, created_at) 
                  VALUES (:name, :position, :photo, :email, :google_scholar, :twitter, :instagram, NOW())";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':name' => $data['name'],
            ':position' => $data['position'],
            ':photo' => $data['photo'],
            ':email' => $data['email'],
            ':google_scholar' => $data['google_scholar'],
            ':twitter' => $data['twitter'],
            ':instagram' => $data['instagram']
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE team_members SET 
                  name = :name, 
                  position = :position, 
                  photo = :photo, 
                  email = :email, 
                  google_scholar = :google_scholar,
                  twitter = :twitter,
                  instagram = :instagram
                  WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':name' => $data['name'],
            ':position' => $data['position'],
            ':photo' => $data['photo'],
            ':email' => $data['email'],
            ':google_scholar' => $data['google_scholar'],
            ':twitter' => $data['twitter'],
            ':instagram' => $data['instagram'],
            ':id' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM team_members WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}