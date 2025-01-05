<?php
namespace App\Config;
// use Dotenv\Dotenv;
use PDO;
use PDOException;
// require '../vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';

// $dotenv = Dotenv::createImmutable(dirname(__DIR__));
// $dotenv->load();
/**
 * Connect to a MySQL database using the mysqli extension.
 *
 * This function establishes a connection to a MySQL database. If the
 * connection fails, it logs an error and terminates the program.
 *
 */
// $con = mysqli_connect($_ENV['DB_SERVER'],$_ENV['DB_USERNAME'],$_ENV['DB_PASSWORD'],$_ENV['DB_NAME']);
class Database{
    private static $con ;
    private static $DB_SERVER ="127.0.0.1";
    private static $DB_USERNAME ="root";
    private static $DB_PASSWORD ="";
    private static $DB_NAME ="devblog_db";

    public static function makeconnection(){
    try {
        $dsn = "mysql:host=" . self::$DB_SERVER . ";dbname=" . self::$DB_NAME . ";charset=utf8mb4";
        self::$con = new PDO($dsn, self::$DB_USERNAME, self::$DB_PASSWORD);
        self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
      }
      return self::$con;
    }


    public static function getConnection(){
        return self::$con;
    }


    public static function add($table,$column,$tagName){
        $pdo = self::getConnection();
        $query = "INSERT INTO $table ($column) VALUES (:tagName)";
        $stmt= $pdo->prepare($query);
        $stmt->bindParam(':tagName', $tagName, PDO::PARAM_STR);
         
        return $stmt->execute();

    }
  
    public static function addcategory($table,$column,$categoryName){
        $pdo = self::getConnection();
        $query = "INSERT INTO $table ($column) VALUES (:categoryName)";
        $stmt= $pdo->prepare($query);
        $stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
         
        return $stmt->execute();

    }
  
   public static function getTableCount($tag) {
     $pdo = self::getConnection();
        $query = "SELECT COUNT(*) AS count FROM $tag";
       
        // Prepare and execute the query
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        // Fetch the count result
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }


    public static function get_all_articles() {
        $pdo = self::getConnection();
        
        $query = "
            SELECT 
                articles.id, 
                articles.title, 
                users.username AS author_name, 
                categories.name AS category_name, 
                GROUP_CONCAT(tags.name SEPARATOR ', ') AS tags, 
                articles.views, 
                articles.created_at
            FROM articles
            JOIN categories ON articles.category_id = categories.id
            JOIN users ON articles.author_id = users.id
            LEFT JOIN article_tags ON articles.id = article_tags.article_id
            LEFT JOIN tags ON article_tags.tag_id = tags.id
            GROUP BY articles.id
            ORDER BY articles.created_at DESC
            LIMIT 3
        ";
        
        // Prepare and execute the query
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        // Fetch all results
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $articles;
    }





    public static function get_top_users() {
        $pdo = self::getConnection();
        $query = "SELECT users.id AS id, username, COUNT(articles.id) AS article_count, SUM(articles.views) AS total_views 
                  FROM users 
                  JOIN articles ON users.id = articles.author_id 
                  GROUP BY users.id 
                  ORDER BY article_count DESC 
                  LIMIT 3";
        
        // Prepare and execute the query
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        // Fetch all results
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }



    public static function get_category_stats() {
        $pdo = self::getConnection();
        $query = "SELECT COUNT(*) AS article_count, categories.name AS category_name 
                  FROM articles 
                  JOIN categories ON articles.category_id = categories.id 
                  GROUP BY category_name";
        
        // Prepare and execute the query
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        // Fetch all results
        $category_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $category_stats;
    }


    public static function get_top_articles() {
        $pdo = self::getConnection();
        $query = "SELECT articles.id, created_at, title, users.username AS author_name, views 
                  FROM articles 
                  JOIN users ON articles.author_id = users.id 
                  ORDER BY views DESC 
                  LIMIT 3";
        
        // Prepare and execute the query
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        // Fetch all results
        $top_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $top_articles;
    }


    public static function getAllTags() {
        $pdo = self::getConnection();
        $query = "SELECT id, name FROM tags";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getAllCategories() {
        $pdo = self::getConnection();
        $query = "SELECT id, name FROM categories";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>