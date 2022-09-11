<?php include "header.php"; 

//the normal users will not get access to this site 
if($_SESSION['role'] == '0'){
    header("Location: {$hostname}/admin/post.php");
}

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12">

              <?php
              include "config.php";
               /* Calculation of Pagination
               ex: SElECT * FROM user LIMIT 0, 3 -> that means, it will show 3 records, 0 to 2
                LIMIT takes two value offset, Limit
                $limit = how much records we will display
                $offset = From where to start showing records.
                offset = (1 -1) * 3 = 0
                offset = (2 -1) * 3 = 3
                offset = (3 - 1) * = 6 
                */
              $limit = 4;
              if(isset($_GET['page'])){
                $page = $_GET['page'];
              } else {
                $page = 1;
              }
              $offset = ($page -1) * $limit;
              $sql = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$offset}, {$limit}";
              $result = mysqli_query($con, $sql) or die("Query Failed");
              if(mysqli_num_rows($result) > 0){
              
              ?>

                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php
                            while($row = mysqli_fetch_assoc($result)){ 
                        ?>
                          <tr>
                              <td class='id'><?php echo $row['user_id'] ?></td>
                              <td><?php echo $row['first_name']. ' '. $row['last_name'] ?></td>
                              <td><?php echo $row['username'] ?></td>
                              <td><?php 
                                if($row['role'] == 1){
                                    echo 'Admin';
                                } else{
                                    echo 'Normal';
                                }
                              ?></td>
                              <td class='edit'><a href='update-user.php?id=<?php echo $row['user_id'] ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-user.php?id=<?php echo $row['user_id'] ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php
                            }
                          ?>
                      </tbody>
                  </table>
                  <?php
            }
                    $sqlPage = "SELECT * FROM user";
                    $resultPage = mysqli_query($con, $sqlPage);
                    
                    if(mysqli_num_rows($resultPage) > 0){
                        // $total_records = how much records store in database
                        $total_records = mysqli_num_rows($resultPage);
                        $total_page = ceil($total_records / $limit);

                        echo "<ul class='pagination admin-pagination'>";
                        if($page > 1){
                            echo '<li><a href="users.php?page='.($page - 1).'">Prev</a></li>';
                        }
                        
                        for($i = 1; $i <= $total_page; $i++){
                            if($i == $page){
                                $active = "active";
                            } else {
                                $active = '';
                            }
                            echo "<li class='$active'><a href='users.php?page=$i'>$i</a></li>";
                        }
                        // if $total_page number is greater than $page number then Next button will be show or it will be hide
                        if($total_page > $page){
                            echo '<li><a href="users.php?page='.($page + 1).'">Next</a></li>';
                        }
                        echo "</ul>";
                    }
                  ?>
                  
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
