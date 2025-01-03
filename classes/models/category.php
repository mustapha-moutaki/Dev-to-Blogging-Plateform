<?php
namespace App\Modules;
class Category {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllCategories() {
        $query = "SELECT id, name FROM categories";
        return $this->db->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function createCategory($name) {
        $stmt = $this->db->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }
}
