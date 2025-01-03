<?php
namespace App\Modules;

class Author extends User {
    public function getMyArticles($authorId) {
        $stmt = $this->db->prepare("SELECT * FROM articles WHERE author_id = ?");
        $stmt->bind_param("i", $authorId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function createArticle($title, $content, $categoryId, $authorId) {
        $stmt = $this->db->prepare("INSERT INTO articles (title, content, category_id, author_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $title, $content, $categoryId, $authorId);
        return $stmt->execute();
    }
}
