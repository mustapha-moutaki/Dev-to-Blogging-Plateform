<?php
namespace App\Models;
use PDO;
class Admin {

    // Constructor to initialize PDO connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


    // Method to assign admin role to a user
    public function assignAdminRole($userId) {
        $stmt = $this->pdo->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Method to delete an article (any article)
    public function deleteArticle($articleId) {
        $stmt = $this->pdo->prepare("DELETE FROM articles WHERE id = ?");
        $stmt->bindParam(1, $articleId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Method to accept an article (approve an author article)
    public function acceptArticle($articleId) {
        $stmt = $this->pdo->prepare("UPDATE articles SET status = 'approved' WHERE id = ?");
        $stmt->bindParam(1, $articleId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getTagById($id) {
        $sql = "SELECT * FROM tags WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($id) {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllAuthors()
    {
        $stmt = $this->db->query("SELECT author_id, name FROM authors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>