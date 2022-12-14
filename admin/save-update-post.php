<?php 
include 'config.php';
/* first it will check user has uploaded new image or not? 
 if user not uploaded new image, then the old uploaded image will come
 into empty condition. if user want to change the image
 then the else condition will run */
if(empty($_FILES['new-image']['name'])){
    $new_name = $_POST['old-image'];
} else {
    $error = array();
    $image_Name = $_FILES['new-image']['name'];
    $image_tmp_name = $_FILES['new-image']['tmp_name'];
    $image_size = $_FILES['new-image']['size'];
    $image_type = $_FILES['new-image']['type']; 
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

    $new_name = time(). "-". basename($image_Name);
    $target = "upload/".$new_name;
    $image_name = $new_name;
    if(empty($error) == true){
        move_uploaded_file($image_tmp_name, $target);
    } else{
        print_r($error);
        die();
    }
}

$title = mysqli_real_escape_string($con, $_POST['post_title']);
$postDesc = mysqli_real_escape_string($con, $_POST['postdesc']);
$category = mysqli_real_escape_string($con, $_POST['category']);
$post_id = $_POST['post_id'];

$sql = "UPDATE post SET title='$title', description='$postDesc', category=$category, post_img='$image_name' WHERE post_id =$post_id ; ";
if($_POST['old_category'] != $_POST['category']){
    $sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$_POST['old_category']};";
    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$_POST['category']};";
}


$result = mysqli_multi_query($con, $sql) or die("Query Failed");
if($result){
    header("location: {$hostname}/admin/post.php");
}

?>
