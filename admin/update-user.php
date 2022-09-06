<?php include "header.php";

if(isset($_POST['submit'])){
    include "config.php";

    $userId = mysqli_real_escape_string($con, $_POST['user_id']);
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $user =mysqli_real_escape_string($con, $_POST['user']);
    $password = mysqli_real_escape_string($con, md5($_POST['password']));
    $role = mysqli_real_escape_string($con, $_POST['role']);

    $sql = "SELECT username FROM user WHERE username = '{$user}' " ;
    // die();
    $result = mysqli_query($con, $sql) or die('Query Failed');
 
    if(mysqli_num_rows($result) > 0){
        echo "<p style='font-size:25px;background-color:red; color:#fff;text-align:center;margin:10px 0';> 
        Username Already Exists 
        </p>";
    } else {
        $sqlInsert = "INSERT INTO user (first_name, last_name, username, password, role)
                        VALUES ('$fname', '$lname', '$user', '$password', '$role')";

        if(mysqli_query($con, $sqlInsert)){
            header("Location: {$hostname}/admin/users.php");
        }
    }
}

?>


  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                <?php
                include "config.php";
                $userId = $_GET['id'];
                $sql = "SELECT * FROM user WHERE user_id = '$userId'";
                $result = mysqli_query($con, $sql);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){

                ?>
                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $userId?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name']?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name']?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $row['username']?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" value="<?php echo $row['role']; ?>">
                              <?php
                              if($row['role'] == 1){
                                echo "<option value='0'>normal User</option>";
                                echo "<option value='1' selected>Admin</option>";
                              } else {
                                echo "<option value='0' selected>normal User</option>";
                                echo "<option value='1'>Admin</option>";
                              }
                              
                              ?>
                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <!-- /Form -->
                  <?php
                        }
                    }
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
