<?php include "header.php"; 

//the normal users will not get access to this site 
if($_SESSION['role'] == '0'){
    header("Location: {$hostname}/admin/post.php");
}

if(isset($_POST['submit'])){
    include "config.php";

    $catId = $_POST['cat_id'];
    $catName = $_POST['cat_name'];

    echo $sql = "UPDATE category SET category_name = '$catName' WHERE category_id = '{$catId}' " ;
    $result = mysqli_query($con, $sql) or die("Query Failed");
    if($result){
        header("Location: {$hostname}/admin/category.php");
    }
}


?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
              <?php
                include "config.php";
                $categoryId = $_GET['id'];
                $sql = "SELECT * FROM category WHERE category_id = '$categoryId'";
                $result = mysqli_query($con, $sql);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                ?>

                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
                      <div class="form-group">
                          <input type="text" name="cat_id"  class="form-control" value="<?php echo $categoryId?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name']?>"  placeholder="" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <?php
                        }
                    }
                  ?>                  
                </div>
              </div>
            </div>
          </div>
<?php include "footer.php"; ?>
