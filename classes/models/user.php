<?php
namespace app\modules;
class User {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllUsers() {
        $query = "SELECT id, username, email, bio, profile_picture_url FROM users";
        $result = $this->db->query($query);

        $users = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    public function createUser($username, $email, $passwordHash, $bio, $profilePicture) {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password_hash, bio, profile_picture_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $passwordHash, $bio, $profilePicture);
        return $stmt->execute();
    }
}


?>