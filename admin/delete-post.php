<?php
include 'config.php';
$post_id = $_GET['id'];
$cat_id = $_GET['cat_id']; 

// delete image from folder
$sql2 = "SELECT * FROM post WHERE post_id = $post_id"; 
$result2 = mysqli_query($con, $sql2);
$row = mysqli_fetch_assoc($result2);
unlink("upload/{$row['post_img']}");

$sql = "DELETE FROM post WHERE post_id = {$post_id};";
$sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$cat_id}";
$result = mysqli_multi_query($con, $sql) or die("Query Failed") ;



if($result){
    header("location: {$hostname}/admin/post.php");
}


?>