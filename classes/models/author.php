<?php
namespace App\Models;
use App\Model;
use PDO;
class Author extends User {


    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to create an article
    public function createArticle($title, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO articles (title, content, author_id, status) VALUES (?, ?, ?, 'pending')");
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $content);
        $stmt->bindParam(3, $_SESSION['user_id']);
        return $stmt->execute();
    }
   

    // Method to update an article
    public function updateArticle($articleId, $title, $content) {
        $stmt = $this->pdo->prepare("UPDATE articles SET title = ?, content = ? WHERE id = ? AND author_id = ?");
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $content);
        $stmt->bindParam(3, $articleId, PDO::PARAM_INT);
        $stmt->bindParam(4, $_SESSION['user_id'], PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Method to delete own article
    public function deleteArticle($articleId) {
        $stmt = $this->pdo->prepare("DELETE FROM articles WHERE id = ? AND author_id = ?");
        $stmt->bindParam(1, $articleId, PDO::PARAM_INT);
        $stmt->bindParam(2, $_SESSION['user_id'], PDO::PARAM_INT);
        return $stmt->execute();
    }
// methidee to add an article
    public function addArticle($title, $slug, $content, $excerpt, $meta_description, $category_id, $featured_image, $status) {
        $sql = "INSERT INTO articles (title, slug, content, excerpt, meta_description, category_id, featured_image, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$title, $slug, $content, $excerpt, $meta_description, $category_id, $featured_image, $status]);
        return $this->pdo->lastInsertId();
    }
    //methide to add tags to the article
    public function addArticleTag($article_id, $tag_id) {
        $sql = "INSERT INTO article_tag (article_id, tag_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$article_id, $tag_id]);
    }



    public function getTop3AuthorsByViews($limit = 3) {
        $sql = "SELECT authors.author_id, authors.name, COUNT(articles.id) AS article_count
                FROM authors
                LEFT JOIN articles ON authors.author_id = articles.author_id
                GROUP BY authors.author_id
                ORDER BY article_count DESC
                LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT); 
        $stmt->execute(); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
   
}

