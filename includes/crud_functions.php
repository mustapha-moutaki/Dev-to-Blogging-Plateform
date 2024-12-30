<?php 
include('../config/database.php');
function connect_db(){
    $con = mysqli_connect(
        $_ENV['DB_SERVER'], 
        $_ENV['DB_USERNAME'], 
        $_ENV['DB_PASSWORD'], 
        $_ENV['DB_NAME']
    );

    // Vérifier si la connexion est réussie
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $con;  // Retourner l'objet de connexion
}

function get_all_articles($mysqli){
    $query = "select articles.id, articles.title, users.username as author_name, categories.name as category_name,tags.name as tags ,views, created_at from articles 
    join categories on articles.category_id= categories.id
    join users on articles.author_id = users.id
    join article_tags on articles.id = article_tags.article_id
    join tags on article_tags.tag_id = tags.id;";
    $result = mysqli_query($mysqli,$query);
    if($result){
        $articles = []; 
        while ($row = mysqli_fetch_assoc($result)) {
            $articles[] = $row; 
        }
        return $articles; 
    }
}


function get_category_stats($mysqli){
    $query = "SELECT COUNT(*) as article_count, categories.name as category_name FROM articles JOIN categories ON articles.category_id = categories.id GROUP BY category_name";
    $result = mysqli_query($mysqli,$query);
    if($result){
        $category_stats = [];
        while($row = mysqli_fetch_assoc($result)){
            $category_stats[] = $row;
        }
        return $category_stats;
    }

}

function get_top_users($mysqli){
    $query = "select users.id as id, username, count(articles.id) as article_count, articles.views as total_views from users join articles on users.id = articles.author_id order by article_count limit 3;";
    $result = mysqli_query($mysqli,$query);
    if($result){
        $users = [];
        while($row = mysqli_fetch_assoc($result)){
            $users[] = $row;
        }
        return $users;
    }

}

function get_top_articles($mysqli){
    $query = "select articles.id, created_at, title, users.username as author_name, views from articles join users on articles.author_id = users.id order by views limit 3;";
    $result = mysqli_query($mysqli,$query);
    if($result){
        $top_articles = [];
        while($row = mysqli_fetch_assoc($result)){
            $top_articles[] = $row;
        }
        return $top_articles;

    }
    
}

function getTableCount($mysqli, $articles){
    $query = "select count(*) as count from $articles";
    $result = mysqli_query($mysqli,$query);
    if($result){
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }
    
}



?>