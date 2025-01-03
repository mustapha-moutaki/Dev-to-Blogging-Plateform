<?php
require_once __DIR__ . '/../../includes/crud_functions.php';
require_once '../../vendor/autoload.php';
use App\config\database;

$getAllCategories ="";
$category = "categories";
if(database::makeconnection() === null){
    echo"faild to instapleshed connection";
}else{
$getAllCategories = Database::getAllCategories($category);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add_category_form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="container p-2 mx-auto sm:p-4 text-black bg-white">
    <h2 class="mb-4 text-2xl font-semibold leading-tight"><tt>MANAGE ALL CATEGORIES()<tt></h2>
    <!-- ?= getTableCount($pdo, 'categories') ?> -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-1xl">
            <colgroup>
                <col style="width: 33%;">
                <col style="width: 33%;">
                <col style="width: 10%;">
            </colgroup>
            <thead class="bg-gray-300">
                <tr class="text-left">
                    <th class="p-3">ID#</th>
                    <th class="p-3">CATEGORY NAME</th>
                    <th class="p-3 text-center">ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($getAllCategories as $category)  :?>
                <tr class="border-b border-opacity-20 border-gray-300 bg-white">
                    <td class="p-3">
                        <p><?= $category['id']?></p>
                    </td>
                    <td class="p-3">
                        <p><?= $category['name']?></p>
                    </td>
                    <td class="p-3">
                        <span class=" font-semibold  flex justify-around gap-10">
                            <span class="rounded-md bg-violet-400 text-gray-900 px-10 py-1">edit</span>
                            <span class="rounded-md bg-violet-400 text-gray-900 px-10 py-1">delete</span>
                            
                        </span>
                    </td>
                </tr>
             
                <?php  endforeach;?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>