<?php

namespace App\Modules;

class Tag {
    private $db;

    // Constructor accepts PDO connection
    public function __construct($db) {
        $this->db = $db;
    }

    // Get all tags from the database
    public function getAllTags() {
        $query = "SELECT id, name FROM tags";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new tag in the database
    public function createTag($name) {
        $query = "INSERT INTO tags (name) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
