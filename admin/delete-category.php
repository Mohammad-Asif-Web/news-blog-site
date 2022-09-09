<?php

include 'config.php';
session_start();
//the normal users will not get access to this site 
if($_SESSION['role'] == '0'){
    header("Location: {$hostname}/admin/post.php");
}

$category_id = $_GET['id'];
$sql = "DELETE FROM category WHERE category_id = '$category_id' ";
$result = mysqli_query($con, $sql);
if($result){
    header("Location: {$hostname}/admin/category.php");
} else{
    echo "Record Delete Unsuccessfull";
}

?>