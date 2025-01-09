<?php
namespace App\Models;
use App\Models\Model;
use PDO;
class Article extends Model {
    protected $table = 'articles';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllArticles() {
        $query = "
        SELECT 
       articles.id, 
       articles.title, 
       articles.views, 
       articles.status, 
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


    public function updateStatus($id, $status) {
        return $this->update($this->table, ['status' => $status], 'id', $id);
    }

    public function deleteArticle($articleId) {
        return $this->delete($this->table, 'id', $articleId);
    }

    function incrementViews($articleId, $pdo) {
        try {
            $stmt = $pdo->prepare("UPDATE articles SET views = views + 1 WHERE id = :articleId");
            $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                return "Views count updated successfully.";
            } else {
                return "Failed to update views count.";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }


    function create_slug($string) {
        // Replace non letter or digits by -
        $string = preg_replace('~[^\pL\d]+~u', '-', $string);
                                                               
        // Transliterate                                          
        if (function_exists('iconv')) {                                 
            $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);            
        }
    
        // Remove unwanted characters
        $string = preg_replace('~[^-\w]+~', '', $string);
    
        // Trim
        $string = trim($string, '-');
    
        // Remove duplicate -
        $string = preg_replace('~-+~', '-', $string);
    
        // Lowercase
        $string = strtolower($string);
    
        // If string is empty, return 'n-a'
        if (empty($string)) {
            return 'n-a';
        }
    
        return $string;
    }
    
    
}
