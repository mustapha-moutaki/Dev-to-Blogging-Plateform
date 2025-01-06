<?php
require_once __DIR__ . '/../../includes/crud_functions.php';
require_once __DIR__ . '/../../classes/models/tag.php';
require_once '../../vendor/autoload.php';
// require_once __DIR__ . '/../../controllers/tagController.php';
// require_once __DIR__ . '/../../config/Database.php';
use App\config\database;
// include '/../../config/database.php'; 

use App\Modules\Tag;
// use App\Config\Database;

// $database = new Database();
// $db = $database->connect();



// $tagModel = new Tag($db);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addTag'])) {
    $tagName = htmlspecialchars(trim($_POST['tag']));
    if (!empty($tagName)) {
       
       if(database::makeconnection() === null){
        echo"faild connection!";
       }else {
        $table = "tags";
        $column = "name";
        database::add($table,$column,$tagName);
        header('Location:http://localhost/devblog_dashboard/admin/index.php');
        exit();
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
    <title>add_new_tag</title>
     <!-- Custom fonts for this template-->
   <link href="../../admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../admin/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex">
<?php include '../../admin/components/sidebar.php'; ?>
<div class ="w-full h-screen flex justify-center items-center">
<form class="w-full max-w-sm" method="POST">
  <div class="flex items-center border-b border-blue-500 py-2">
    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="add new Tag" aria-label="tag" name="tag">
    <button class="flex-shrink-0 bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-sm border-4 text-white py-1 px-2 rounded" type="sybmit" name="addTag">
      ADD A TAG
    </button>
    <button class="flex-shrink-0 border-transparent border-4 text-blue-500 hover:text-blue-800 text-sm py-1 px-2 rounded" type="button">
      Cancel
    </button>
  </div>
</form>
</div>
</body>
</html>

