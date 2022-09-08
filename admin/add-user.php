<?php include "header.php"; 

//the normal users will not get access to this site 
if($_SESSION['role'] == '0'){
    header("Location: {$hostname}/admin/post.php");
}

if(isset($_POST['save'])){
    include "config.php";

    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $user =mysqli_real_escape_string($con, $_POST['user']);
    $password = mysqli_real_escape_string($con, md5($_POST['password']));
    $role = mysqli_real_escape_string($con, $_POST['role']);

    // it will check, the same username is already exists or not. if exist the, the output will be alert or the new user will be insert into database
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
                  <h1 class="admin-heading">Add User</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST" autocomplete="off">
                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                      </div>
                          <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control" placeholder="Username" required>
                      </div>

                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Password" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" >
                              <option value="0">Normal User</option>
                              <option value="1">Admin</option>
                          </select>
                      </div>
                      <input type="submit"  name="save" class="btn btn-primary" value="Save" required />
                  </form>
                   <!-- Form End-->
               </div>
           </div>
       </div>
   </div>
<?php include "footer.php"; ?>
