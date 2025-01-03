<?php
namespace App\Modules;

class Admin extends User {
    public function deleteUser($userId) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }

    public function manageCategories($categoryId = null, $action = 'view') {
        if ($action === 'view') {
            return $this->db->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);
        } elseif ($action === 'delete' && $categoryId) {
            $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->bind_param("i", $categoryId);
            return $stmt->execute();
        }
    }
}

?>