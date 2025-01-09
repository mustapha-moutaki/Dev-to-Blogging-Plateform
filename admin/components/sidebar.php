<?php
use App\Config\Database;
use App\Models\User;

// Check if the user is logged in
if (isset($_SESSION['user_id']) ?? 'User') {
    $db = Database::makeConnection(); 
    $userModel = new User($db);

    $userId = $_SESSION['user_id'];  

    $user = $userModel->getUserById($userId);
}
?>

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-blog"></i>
                </div>
                <div class="sidebar-brand-text mx-3">DevBlog Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                <a class="nav-link" href="http://localhost/devblog_dashboard/admin/index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Content Management
            </div>

            <!-- Nav Item - Articles Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseArticles"
                    aria-expanded="true" aria-controls="collapseArticles">
                    <i class="fas fa-fw fa-newspaper"></i>
                    <span>Articles</span>
                </a>
                <div id="collapseArticles" class="collapse" aria-labelledby="headingArticles" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Article Management:</h6>
                        <a class="collapse-item" href="http://localhost/devblog_dashboard/views/home%20page/home.php">View All Articles</a> 
                        <!--?php if($user['role'] =='admin'): ?-->
                        <?php if (isset($user['role']) && $user['role'] == 'admin'): ?>
                        <a class="collapse-item" href="http://localhost/devblog_dashboard/views/articles/display_article.php">Manage All Articles</a>
                        <?php endif; ?>
                        <a class="collapse-item" href="http://localhost/devblog_dashboard/views/articles/add_article_form.php">Add New Article</a>
                        <a class="collapse-item" href="article-drafts.php">Drafts</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Categories -->
<!--?php if($user['role']==='admin'): ?-->
    <?php if (isset($user['role']) && $user['role'] == 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategories"
                    aria-expanded="true" aria-controls="collapseCategories">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Categories</span>
                </a>
                <div id="collapseCategories" class="collapse" aria-labelledby="headingCategories" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Category Management:</h6>
                        <a class="collapse-item" href="http://localhost/devblog_dashboard/views/Categories/list_categories.php">View All Categories</a>
                        <a class="collapse-item" href="http://localhost/devblog_dashboard/views/Categories/add_category_form.php">Add New Category</a>
                    </div>
                </div>
            </li>
            <?php endif; ?>
            <!-- Nav Item - Tags -->
            <!--?php if($user['role']==='admin'): ?-->
                <?php if (isset($user['role']) && $user['role'] == 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTags"
                    aria-expanded="true" aria-controls="collapseTags">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Tags</span>
                </a>
                <div id="collapseTags" class="collapse" aria-labelledby="headingTags" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Tag Management:</h6>
                        <a class="collapse-item" href="http://localhost/devblog_dashboard/views/tags/list_tag.php">View All Tags</a>
                        <a class="collapse-item" href="http://localhost/devblog_dashboard/views/tags/add_tag_form.php">Add New Tag</a>
                    </div>
                </div>
            </li>
            <?php endif; ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <!--?php if($user['role']==='admin'): ?-->
                <?php if (isset($user['role']) && $user['role'] == 'admin'): ?>
            <div class="sidebar-heading">
                User Management
            </div>
            <?php endif; ?>
            <!-- Nav Item - Authors -->
            <!--?php if($user['role']==='admin'): ?-->
                <?php if (isset($user['role']) && $user['role'] == 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAuthors"
                    aria-expanded="true" aria-controls="collapseAuthors">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span>
                </a>
                <div id="collapseAuthors" class="collapse" aria-labelledby="headingAuthors" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">User Management:</h6>
                        <a class="collapse-item" href="http://localhost/devblog_dashboard/views/users/users.php">manage All Users</a>
                        
                    </div>
                </div>
            </li>
            <?php endif; ?>
         

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
           

           

            <!-- Nav Item - Your Profile -->
            <li class="nav-item">
                <a class="nav-link" href="profile.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Your Profile</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->