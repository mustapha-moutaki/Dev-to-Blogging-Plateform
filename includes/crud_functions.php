<?php 
include __DIR__.'/../config/database.php';


function connect_db() {
    try {
        // Create a DSN string
        $dsn = "mysql:host=" . $_ENV['DB_SERVER'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4";
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        $pdo = new PDO($dsn, $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
       
        die("Connection failed: " . $e->getMessage());
    }
}


// Function to get all articles
function get_all_articles($pdo) {
    $query = "SELECT articles.id, articles.title, users.username AS author_name, categories.name AS category_name, tags.name AS tags, views, created_at
              FROM articles 
              JOIN categories ON articles.category_id = categories.id
              JOIN users ON articles.author_id = users.id
              JOIN article_tags ON articles.id = article_tags.article_id
              JOIN tags ON article_tags.tag_id = tags.id";
    
    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    // Fetch all results
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $articles;
}

// new modification
function get_All_tags($pdo){
    $query = "SELECT tags.id , tags.name
    FROM tags 
    ";
    $stmt = $pdo -> prepare($query);
    $stmt ->execute();

    $tags = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    return $tags;

}

function get_All_categories($pdo){
    $query = "SELECT categories.id, categories.name
    FROM categories
    ";
    $stmt = $pdo ->prepare($query);
    $stmt ->execute();

    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}

// Function to get category stats
function get_category_stats($pdo) {
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


// Function to get top users
function get_top_users($pdo) {
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

// Function to get top articles
function get_top_articles($pdo) {
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

// Function to get table row count
function getTableCount($pdo, $table) {
    $query = "SELECT COUNT(*) AS count FROM " . $table;
    
    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    // Fetch the count result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['count'];
}

?>