<?php
include "config.php";
//the normal users will not get access to this site 
if($_SESSION['role'] == '0'){
    header("Location: {$hostname}/admin/post.php");
}

$userId = $_GET['id'];
$sql = "DELETE FROM user WHERE user_id = '$userId'";
$result = mysqli_query($con, $sql);

if($result){
    header("Location: {$hostname}/admin/users.php");
} else{
    echo "Record Delete Unsuccessfull";
}



?>