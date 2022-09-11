<?php
include 'config.php';
session_start();

if(isset($_FILES['fileToUpload'])){
    $error = array();
    // $file= $_FILES['fileToUpload'];
    $image_Name = $_FILES['fileToUpload']['name'];
    $image_tmp_name = $_FILES['fileToUpload']['tmp_name'];
    $image_size = $_FILES['fileToUpload']['size'];
    $image_type = $_FILES['fileToUpload']['type']; 
    // explode function separates the stinge by '.'
    // end function takes the last string
    // strtolower converto the string to lowercase
    $img_ext = end(explode('.', $image_Name));
    $extension = array("jpeg", "jpg", "png");
    
    if(in_array($img_ext, $extension) === false){
        $error[] = "File must be jpg, jpeg or png type";
    }
    if($image_size > 2097152){
        $error[] =  "file size must be 2mb or lower";
    }
    if(empty($error) == true){
        move_uploaded_file($image_tmp_name,"upload/".$image_Name);
    } else{
        print_r($error);
        die();
    }
}

$title = mysqli_real_escape_string($con, $_POST['post_title']);
$postDesc = mysqli_real_escape_string($con, $_POST['postdesc']);
$category = mysqli_real_escape_string($con, $_POST['category']);
$postDate = date("d M, Y");
$author = $_SESSION['user_id'];

$sql = "INSERT INTO post(title, description, category, post_date, author, post_img) 
        VALUES('$title', '$postDesc', '$category', '$postDate', '$author', '$image_Name');";

$sql .= "UPDATE category SET post = post + 1 WHERE category_id = '$category'";

$result = mysqli_multi_query($con, $sql) or die("Query Failed");

if($result){
    header("Location: {$hostname}/admin/post.php");
}







?>