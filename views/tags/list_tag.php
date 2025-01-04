<?php
require_once __DIR__ . '/../../includes/crud_functions.php';
require_once '../../vendor/autoload.php';
use App\config\database;
use App\Models\Admin;

$pdo = Database::makeconnection();

try {
    $admin = new Admin($pdo);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


//for deleting
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    if ($admin->deleteTag($deleteId)) {
    } else {
        echo "Failed to delete the tag.";
    }
}

//for editing

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_tag'])) {
    $tagName = $_POST['tag_name'];
    
    if ($admin->updateTag($editId, $tagName)) {
        echo "Tag updated successfully!";
    } else {
        echo "Failed to update the tag.";
    }
}




$getAllTags ="";
$tag = "tags";
if(database::makeconnection() === null){
    echo"faild to instapleshed connection";
}else{
$getAllTags = Database::getAllTags($tag);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add_tags_form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="container p-2 mx-auto sm:p-4 text-black bg-white">
    <h2 class="mb-4 text-2xl font-semibold leading-tight"><tt>MANAGE ALL TAGS<tt></h2>
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
                    <th class="p-3">TAG NAME</th>
                    <th class="p-3 text-center">ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php  foreach ($getAllTags as $tag):?>
                <tr class="border-b border-opacity-20 border-gray-300 bg-white">
                    <td class="p-3">
                        <p><?= $tag['id'] ?></p>
                    </td>
                    <td class="p-3">
                        <p><?= $tag['name'] ?></p>
                    </td>
                    <td class="p-3">
                        <span class=" font-semibold  flex justify-around gap-10">
                            <span class="rounded-md bg-violet-400 text-gray-900 px-10 py-1">
                            <a href="update_tag.php?update_tag=<?= $tag['id']; ?>">Edit</a>
                            </span>
                            <span class="rounded-md bg-violet-400 text-gray-900 px-10 py-1"><a href="http://localhost/devblog_dashboard/views/tags/list_tag.php?delete_id=<?php echo $tag['id']; ?>" onclick="return confirm('Are you sure you want to delete this tag?')">Delete</a>

                              
                            </span>
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

