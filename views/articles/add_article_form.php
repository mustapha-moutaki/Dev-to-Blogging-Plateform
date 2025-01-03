<?php
    require_once __DIR__ . '/../../includes/crud_functions.php';
    require_once '../../vendor/autoload.php';
    use App\config\database;
    
    // if(database::makeconnection() === null){
    //     echo"faild to instapleshed connection";
    // }else{
    //     echo"connected monsieur";
    // }
$getAllcategories ="";
$category = "categories";
$getAllTags ="";
$tag = "tags";
if(database::makeconnection() === null){
    echo"faild to instapleshed connection";
}else{
$getAllTags = Database::getAllTags($tag);
$getAllcategories = Database::getAllCategories($category);
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add an article</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="max-w-2xl mx-auto max-w-screen-sm/md/lg/xl/2xl p-4 bg-gray shadow-2xl">
    <form action="/submit-post" method="POST">
        <div class="mb-3">
            <label for="title" class="block text-lg font-medium text-gray-800 mb-1">Title</label>
            <input type="text" id="title" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" required>
        </div>


  <label for="countries" class="block mb-2 text-sm font-medium text-black-900 text-black">Select a category</label>
  <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 text-blCK dark:focus:ring-blue-500 dark:focus:border-blue-500">
    <?php foreach($getAllcategories as $category) :?>
    <option value="US"><?= htmlspecialchars($category['name']) ?></option>
    <?php endforeach;?>
  </select>


        <div class="mb-6">
            <label for="title" class="block text-lg font-medium text-gray-800 mb-1">slug</label>
            <input type="text" id="title" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" required>
        </div>


        <div class="mb-6">
            <label for="title" class="block text-lg font-medium text-gray-800 mb-1">meta description</label>
            <input type="text" id="title" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" required>
        </div>


        <div class="mb-6">
            <label for="content" class="block text-lg font-medium text-gray-800 mb-1">content</label>
            <textarea id="content" name="content" class="h-90 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" rows="6" required></textarea>
        </div>
        <div class="mb-6">
            <label for="title" class="block text-lg font-medium text-gray-800 mb-1">excerpt</label>
            <input type="text" id="title" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" required>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-lg font-medium text-gray-800 mb-1">Image</label>
            <input type="file" id="image" name="image" accept="image/*" class="w-full">
        </div>


        <div class="flex wrap gap-2 mb-10">
    <div class="flex flex-wrap w-30 justify-between">
    <?php foreach($getAllTags as $tag): ?>
        <div class="mr-40">
        <label class="inline-flex items-center" for="redCheckBox">
          <input id="redCheckBox" type="checkbox" class="w-4 h-4 accent-red-600">
          <span class="ml-2"><?= htmlspecialchars($tag['name']) ?></span>
        </label>
    </div>
        <?php endforeach;?>
    </div>
  
   

    </div>
    
  


        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-indigo-500 text-white font-semibold rounded-md hover:bg-indigo-600 focus:outline-none">PUBLISH</button>
        </div>
    </form>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
    .create(document.querySelector('#content'))
    .catch(error => {
      console.error(error);
    });
</script>
</body>
</html>