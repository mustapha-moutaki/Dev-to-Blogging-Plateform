<?php

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../../login.php'); 
    exit;
}

$username = $_SESSION['username']; 


$categories_stats = []; // Initialize the variable to prevent warnings

// Prepare data for the chart
$categories = [];
$counts = [];
$colors = [
    'rgb(78, 115, 223)',    // primary
    'rgb(28, 200, 138)',    // success
    'rgb(54, 185, 204)',    // info
    'rgb(246, 194, 62)',    // warning
    'rgb(231, 74, 59)',     // danger
    'rgb(133, 135, 150)',   // secondary
    'rgb(90, 92, 105)',     // dark
    'rgb(244, 246, 249)'    // light
];

require_once __DIR__ . '/../vendor/autoload.php';
use App\Config\Database;
use App\Models\User;
use App\Models\Tag;
use App\Models\Category;  // Use the Category model
use App\Models\Article; // Use the Category model
use App\Models\Author; // Use the Category model

// Get the connection instance
$pdo = Database::makeConnection();

// Create an instance of the Category model
$categoryModel = new Category($pdo);
$tagModel = new Tag($pdo);
$userModel = new user($pdo);
$articleModel = new Article($pdo);
$getAllArticles = new Article($pdo);

// Get the counts of categories and tags
$categoryCount = $categoryModel->countCategories();   
$tagCount = $tagModel->countTags();  
$userCount = $userModel->countUsers();  
$articleCount = $articleModel->countArticles();   
$allArticles = $getAllArticles->getAllArticles();

$articleModel = new Article($pdo);
$mostViewedArticles = $articleModel->getMostViewedArticles();

$authorModel = new Author($pdo);
$top3Authors = $authorModel->getTop3AuthorsByViews();


$categories_stats = "";
if(database::makeconnection() === null){
    echo"faild to instapleshed connection";
}else{
    $categories_stats = Category::get_category_stats(); 
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $updateId = $_POST['article_id'];
    $statusName = $_POST['status'];  

    
    if (!empty($updateId) && !empty($statusName)) {
        if (!$articleModel->updateStatus($updateId, $statusName)) {
            echo "Failed to update article status.";
            
        }
    } else {
        echo "Please try again.";
    }
    header('location: http://localhost/devblog_dashboard/admin/index.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['read_article'])) {

    $result = $articleModel->incrementViews($articleId, $pdo);
    echo $result;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DevBlog - Dashboard</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'components/sidebar.php'; ?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'components/topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Articles</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $articleCount; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Users</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $userCount; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tags
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tagCount; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Categories</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $categoryCount; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-folder fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
<!-- Content Column -->
<div class="col-xl-8 col-lg-7">
    <!-- Top Authors Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Top Authors</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Actions:</div>
                    <a class="dropdown-item" href="users.php">View All Users</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php foreach($top3Authors as $author): ?>
                <div class="d-flex align-items-center mb-3">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary text-white">
                            <?php if($author['profile_picture_url'] ?? ''): ?>
                                <img src="<?= htmlspecialchars($author['profile_picture_url']) ?>" 
                                     class="rounded-circle" 
                                     style="width: 40px; height: 40px; object-fit: cover;"
                                     alt="<?= htmlspecialchars($author['name']) ?>">
                            <?php else: ?>
                                <i class="fas fa-user"></i>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="small text-gray-500">Author #<!--?= $index + 1 ?--></div>
                        <div class="font-weight-bold"><?= htmlspecialchars($author['name']) ?></div>
                        <div class="text-gray-800">
                            <?= number_format($author['article_count']) ?> articles
                            <span class="mx-1">•</span>
                        </div>
                    </div>
                    <div class="ml-2">
                        <a href="./entities/users/user-profile.php?id=<?= $author['author_id'] ?>"
                           class="btn btn-primary btn-sm">
                            View Profile
                        </a>
                    </div>
                </div>
                <!--?php if($index < count($topUsers) - 1): ?-->
                    <hr>
                <!--?php endif; ?-->
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Top Articles Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Most Read Articles</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink2"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink2">
                    <div class="dropdown-header">Actions:</div>
                    <a class="dropdown-item" href="./entities/articles/articles.php">View All Articles</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php foreach($mostViewedArticles as $article): ?>
                <div class="d-flex align-items-center mb-3">
                    <div class="mr-3">
                        <div class="icon-circle bg-success text-white">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="small text-gray-500">
                            Published <?= date('M d, Y', strtotime($article['created_at'])) ?>
                            by <?= htmlspecialchars($article['title']) ?>
                        </div>
                        <div class="font-weight-bold"><?= htmlspecialchars($article['title']) ?></div>
                        <div class="text-gray-800">
                            <i class="fas fa-eye mr-1"></i>
                            <?= number_format($article['views']) ?> views
                        </div>
                    </div>
                    <div class="ml-2">
                        <a href="http://localhost/devblog_dashboard/views/home%20page/home.php?id=<?= $article['id'] ?>"
                           class="btn btn-success btn-sm" name="read_article">
                            Read Article
                        </a>
                        <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                    </div>
                </div>
                    <hr>
            <?php endforeach; ?>
        </div>
    </div>
</div>





                    <div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <!-- Card Header -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Category Distribution</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Category Actions:</div>
                    <a class="dropdown-item" href="devblog_dashboard\views\Categories\list_categories.php">Manage Categories</a>
                    <a class="dropdown-item" href="http://localhost/devblog_dashboard/views/categories/list_category.php">Add Category</a>
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
                <canvas id="categoryPieChart"></canvas>
            </div>
            <div class="mt-4 text-center small">
                <!--?php if (isset($categories_stats) && is_array($categories_stats)): ?-->
                    <?php foreach ($categories_stats as $index => $stat):?>
                        <span class="mr-2">
                            <i class="fas fa-circle" style="color: <?= $colors[$index % count($colors)] ?>"></i>
                            <?= htmlspecialchars($stat['category_name']) ?> (<?= $stat['article_count'] ?>)
                        </span>
                    <?php endforeach; ?>



                <!--?php else: ?-->
                    <!--p class="text-muted">No data available</!--p-->
                <!--?php endif; ?-->

                
            </div>
        </div>
    </div>
</div>
                    <!-- DataTales Example -->
                     <?php if($user['role'] === 'admin'):?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Articles</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>Views</th>
                                            <th>Created At</th>
                                            <th>status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>Views</th>
                                            <th>Created At</th>
                                            <th>status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php foreach($allArticles as $article): ?>
                                        <tr>
                                            <td>                                           
                                                <?= htmlspecialchars($article['title']) ?>
                                            </td>
                                            <td><?= htmlspecialchars($article['author_name']|| 'null') ?></td>
                                            <td><?= htmlspecialchars($article['category_name'] || 'null') ?></td>
                                            <td>
                                                <?php
                                                if ($article['tags']) {
                                                    $tags = explode(',', $article['tags']);
                                                    foreach($tags as $tag) {
                                                        echo '<span class="badge badge-primary mr-1">' . htmlspecialchars($tag) . '</span>';
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td data-order="<?= $article['views'] ?>">
                                                <?= number_format($article['views']) ?>
                                            </td>
                                            <td data-order="<?= strtotime($article['created_at']) ?>">
                                                <?= date('M d, Y H:i', strtotime($article['created_at'])) ?>
                                            </td>

                                            <td>
                                           

                                                  <form method="POST" action="index.php">
                                                    <input type="hidden" name="article_id" value="<?= $article['id']; ?>">
                                                    <select name="status" style="border: none; padding: 5px; background-color: #f9f9f9; border-radius: 4px;">
                                                        <option value="published" <?= $article['status'] == 'published' ? 'selected' : '' ?>>Published</option>
                                                        <option value="draft" <?= $article['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                                                        <option value="scheduled" <?= $article['status'] == 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                                                    </select>
                                                    <button type="submit" name="update_status" style="background-color: #007BFF; color: white; padding: 10px 40px; border: none; border-radius: 8px; cursor: pointer; margin-top: 8px;">
                                                    Save
                                                </button>
                                            </form>


                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>


                
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include 'components/footer.php'; ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are tou sure you want to logout?.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="http://localhost/devblog_dashboard/views/login/logout.php" name ="logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
        <!-- Initialize the pie chart -->
        <script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Pie Chart
    var ctx = document.getElementById("categoryPieChart");
    var categoryPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($categories) ?>,
            datasets: [{
                data: <?= json_encode($counts) ?>,
                backgroundColor: <?= json_encode(array_slice($colors, 0, count($categories))) ?>,
                hoverBackgroundColor: <?= json_encode(array_slice($colors, 0, count($categories))) ?>,
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var total = dataset.data.reduce(function(previousValue, currentValue) {
                            return previousValue + currentValue;
                        });
                        var currentValue = dataset.data[tooltipItem.index];
                        var percentage = Math.floor(((currentValue/total) * 100)+0.5);
                        return data.labels[tooltipItem.index] + ': ' + currentValue + ' (' + percentage + '%)';
                    }
                }
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
    </script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
</body>

</html>