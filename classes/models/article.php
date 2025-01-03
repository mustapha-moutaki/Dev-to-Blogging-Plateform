<?php
namespace App\Modules;
class Article {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllArticles() {
        $query = "
            SELECT 
                articles.id, 
                articles.title, 
                articles.content, 
                users.username AS author_name, 
                categories.name AS category_name, 
                articles.created_at 
            FROM 
                articles 
            JOIN users ON articles.author_id = users.id 
            JOIN categories ON articles.category_id = categories.id";
        return $this->db->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function createArticle($title, $content, $categoryId, $authorId) {
        $stmt = $this->db->prepare("INSERT INTO articles (title, content, category_id, author_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $title, $content, $categoryId, $authorId);
        return $stmt->execute();
    }
}
