<?php
include 'config.php';
// Dynamic title code
// echo "<pre>";
// print_r($_SERVER);
// echo "</pre>";
// basename(): built in function gives the proper name of any file
// example: news-blog-site/index.php convert to only 'index.php'
$fileName = basename($_SERVER['PHP_SELF']);
// echo $fileName;
$pageTitle = '';

switch ($fileName) {
    case "category.php":
        if(isset($_GET['cat_id'])){
            $cat_id = $_GET['cat_id'];
            $sql = "SELECT * FROM category WHERE category_id = $cat_id";
            $result = mysqli_query($con, $sql) or die("Category Title Query Failed");
            $row = mysqli_fetch_assoc($result);
            $pageTitle = $row['category_name']. ' News';
        } else {
            echo "News Not Found";
        }
      break;
    case "author.php":
      if(isset($_GET['auth_id'])){
        $auth_id = $_GET['auth_id'];
        $sql = "SELECT * FROM user WHERE user_id = $auth_id";
        $result = mysqli_query($con, $sql) or die("Author Title Query Failed");
        $row = mysqli_fetch_assoc($result);
        $pageTitle = $row['first_name']. ' '.$row['last_name']. ' News';
      } else {
        echo "News Not Found";
      }
      break;
    case "single.php":
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = "SELECT * FROM post WHERE post_id = $id";
            $result = mysqli_query($con, $sql) or die("Single Title Query Failed");
            $row = mysqli_fetch_assoc($result);
            $pageTitle = $row['title'];
          } else {
            echo "News Not Found";
          }
      break;
    case "search.php":
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $pageTitle = "Search: ".$search;
          } else {
            echo "News Not Found";
          }
      break;
    default:
      $pageTitle = 'News Site';
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $pageTitle ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class=" col-md-offset-4 col-md-4">
                <a href="index.php" id="logo"><img src="images/news2.jpg" alt="news-portal-logo"></a>
            </div>
            <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class='menu'>
                    <li><a href='http://localhost/news-blog-site'>Home</a></li>
                    <?php
                    include 'config.php';

                    if(isset($_GET['cat_id'])){
                        $cat_id = $_GET['cat_id'];
                    }

                    $sql = "SELECT * FROM category WHERE post > 0";
                    $result = mysqli_query($con, $sql) or die("Query Failed: Category");
                    if(mysqli_num_rows($result) > 0){
                        $active = '';

                        while($row = mysqli_fetch_assoc($result)){
                            if(isset($_GET['cat_id'])){
                                if($row['category_id'] == $cat_id){
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                            }
                            echo "<li><a class='{$active}' href='category.php?cat_id={$row['category_id']}'>{$row['category_name']}</a></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->
