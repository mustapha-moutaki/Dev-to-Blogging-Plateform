<?php
require_once __DIR__ . '/../../includes/crud_functions.php';
require_once '../../vendor/autoload.php';
use App\config\database;
use App\Models\Admin;


if (isset($_GET['update_tag'])) {
    $updateId = $_GET['update_tag'];

    //making a connection
    $pdo = Database::makeconnection();
    $admin = new Admin($pdo);

   //get data of the tag
    $tag = $admin->getTagById($updateId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_tag'])) {
    $tagName = $_POST['tag'];

    if ($admin->updateTag($updateId, $tagName)) {
        header('Location:list_tag.php');
        exit();
    } else {
        echo "error of updating ";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit tag</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class ="w-full h-screen flex justify-center items-center">
<form class="w-full max-w-sm" method="POST">
  <div class="flex items-center border-b border-teal-500 py-2">
  <?php if ($tag): ?>
    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="update Tag" aria-label="tag" name="tag" value="<?= $tag['name']; ?>">
    <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="sybmit" name="update_tag">
      update
    </button>
  </div>
  <?php endif; ?>
</form>
</div>
</body>
</html>
