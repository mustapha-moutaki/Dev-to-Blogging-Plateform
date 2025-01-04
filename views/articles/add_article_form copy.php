<?php
require_once __DIR__ . '/../../includes/crud_functions.php';
require_once '../../vendor/autoload.php';

use App\config\database;
use App\Models\Admin;
use App\Models\Author;
use App\Models\User;

// Establish database connection
$pdo = Database::makeconnection();
if (!$pdo) {
    // Handle connection failure (optional)
    // echo "Connection failed"; // Uncomment for debugging
}

// Fetch categories and tags for the form
$getAllCategories = Database::getAllCategories("categories");
$getAllTags = Database::getAllTags("tags");



    // Ensure the submit button is clicked
    if (isset($_POST['add_article'])) {
        // Retrieve form data
        $title = $_POST['title'];
        $slug = $_POST['slug'];
        $content = $_POST['content'];
        $excerpt = $_POST['excerpt'];
        $meta_description = $_POST['meta_description'];
        $category_id = $_POST['category'];
        $featured_image = $_FILES['image']['name'] ?? ''; // Handle file upload
        $status = $_POST['status'] ?? 'draft'; // Default status if not provided
        $tags = $_POST['tags'] ?? [];

        $author = new author($pdo);

        try {
            $pdo->beginTransaction();

            // Add the article and get its ID
            $article_id = $author->addArticle($title, $slug, $content, $excerpt, $meta_description, $category_id, $featured_image, $status);

            // Link tags to the article
            foreach ($tags as $tag_id) {
                $author->addArticleTag($article_id, $tag_id);
            }

            $pdo->commit();
            echo "Article added successfully!";
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add an Article</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="max-w-2xl mx-auto p-4 bg-gray shadow-2xl">
    <form action="" method="POST" enctype="multipart/form-data">
        <!-- Title Field -->
        <div class="mb-3">
            <label for="title" class="block text-lg font-medium text-gray-800 mb-1">Title</label>
            <input type="text" id="title" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" required>
        </div>

        <!-- Category Selection -->
        <label for="category" class="block mb-2 text-sm font-medium text-black">Select a category</label>
        <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <?php foreach ($getAllCategories as $category) : ?>
                <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Slug Field -->
        <div class="mb-6">
            <label for="slug" class="block text-lg font-medium text-gray-800 mb-1">Slug</label>
            <input type="text" id="slug" name="slug" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" required>
        </div>

        <!-- Meta Description Field -->
        <div class="mb-6">
            <label for="meta_description" class="block text-lg font-medium text-gray-800 mb-1">Meta Description</label>
            <input type="text" id="meta_description" name="meta_description" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" required>
        </div>

        <!-- Content Field -->
        <div class="mb-6">
            <label for="content" class="block text-lg font-medium text-gray-800 mb-1">Content</label>
            <textarea id="content" name="content" class="h-90 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" rows="6" required></textarea>
        </div>
        
        <!-- Excerpt Field -->
        <div class="mb-6">
            <label for="excerpt" class="block text-lg font-medium text-gray-800 mb-1">Excerpt</label>
            <input type="text" id="excerpt" name="excerpt" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500" required>
        </div>

        <!-- Image Upload -->
        <div class="mb-6">
            <label for="image" class="block text-lg font-medium text-gray-800 mb-1">Image</label>
            <input type="file" id="image" name="image" accept="image/*" class="w-full">
        </div>

        <!-- Tags Selection -->
        <div class="flex wrap gap-2 mb-10">
            <div class="flex flex-wrap w-30 justify-between">
                <?php foreach ($getAllTags as $tag): ?>
                    <div class="mr-40">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="w-4 h-4 accent-red-600" name="tags[]" value="<?= htmlspecialchars($tag['id']) ?>">
                            <span class="ml-2"><?= htmlspecialchars($tag['name']) ?></span>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-indigo-500 text-white font-semibold rounded-md hover:bg-indigo-600 focus:outline-none" name="add_article">
                PUBLISH
            </button>
        </div>
    </form>
</div>

</body>
</html>