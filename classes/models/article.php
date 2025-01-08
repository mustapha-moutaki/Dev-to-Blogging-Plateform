<?php
namespace App\Models;
use App\Models\Model;
use PDO;
class Article extends Model {

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
        JOIN categories ON articles.category_id = categories.id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function createArticle($title, $content, $categoryId, $authorId) {
        $stmt = $this->db->prepare("INSERT INTO articles (title, content, category_id, author_id) VALUES (:title, :content, :category_id, :author_id)");
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':content', $content);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':author_id', $authorId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function countArticles() {
        return $this->count('articles');
    }


    public function getMostViewedArticles($limit = 5) {
        $sql = "SELECT * FROM articles ORDER BY views DESC LIMIT $limit";
        $stmt = $this->db->query($sql); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    
}
