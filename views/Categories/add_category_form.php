<?php
require_once __DIR__ . '/../../includes/crud_functions.php';
// require_once __DIR__ . '/../../classes/models/tag.php';
require_once '../../vendor/autoload.php';
// require_once __DIR__ . '/../../controllers/tagController.php';
// require_once __DIR__ . '/../../config/Database.php';
use App\config\database;
// include '/../../config/database.php'; 

use App\Modules\category;
// use App\Config\Database;

// $database = new Database();
// $db = $database->connect();



// $tagModel = new Tag($db);
$databse = database::makeconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addcategory'])) {
  $categoryName = htmlspecialchars(trim($_POST['category']));
  if (!empty($categoryName)) {
     
     if(database::makeconnection() === null){
      echo"faild connection!";
     }else {
      $table = "categories";
      $column = "name";
      database::addcategory($table,$column,$categoryName);
     }
  //     if ($tagModel->createTag($tagName)) {
  //         $message = "Tag added successfully!";
  //     } else {
  //         $message = "Failed to add the tag.";
  //     }
  }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add_new_category</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class ="w-full h-screen flex justify-center items-center">
<form class="w-full max-w-sm" method="POST">
  <div class="flex items-center border-b border-teal-500 py-2">
    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="add new category" aria-label="category" name="category">
    <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="submit" name="addcategory">
      ADD CATEDORY
    </button>
    <button class="flex-shrink-0 border-transparent border-4 text-teal-500 hover:text-teal-800 text-sm py-1 px-2 rounded" type="submit">
      Cancel
    </button>
  </div>
</form>
</div>
</body>
</html>
