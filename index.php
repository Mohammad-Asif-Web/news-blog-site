<?php include 'header.php'; ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- post-container -->
                    <div class="post-container">
                        <?php
                        include "config.php";

                        $limit = 3;
                        if(isset($_GET['page'])){
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }
                        $offset = ($page -1) * $limit;

                        $sql = "SELECT post.post_id, post.title, post.description, 
                        post.category, post.post_img,post.post_date, 
                        category.category_name, user.username FROM post
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id
                        ORDER BY post.post_id DESC LIMIT {$offset}, {$limit} ";

                        $result = mysqli_query($con, $sql) or die("Query Failed");
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)){ 

                        ?>
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?id=<?php echo $row['post_id'] ?>"><img src="admin/upload/<?php echo $row['post_img'] ?>" alt="<?php echo $row['post_img'] ?>"/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?id=<?php echo $row['post_id'] ?>'><?php echo $row['title'] ?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?cat_id=<?php echo $row['category'] ?>'><?php echo $row['category_name'] ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php'><?php echo $row['username'] ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $row['post_date'] ?>
                                            </span>
                                        </div>
                                        <p class="description">
                                        <?php echo substr($row['description'], 0, 15).'...' ?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id'] ?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        }
                        
                        $sqlPage = "SELECT * FROM post";
                        $resultPage = mysqli_query($con, $sqlPage);
                        
                        if(mysqli_num_rows($resultPage) > 0){
                            // $total_records = how much records store in database
                            $total_records = mysqli_num_rows($resultPage);
                            $total_page = ceil($total_records / $limit);
    
                            echo "<ul class='pagination admin-pagination'>";
                            if($page > 1){
                                echo '<li><a href="index.php?page='.($page - 1).'">Prev</a></li>';
                            }
                            
                            for($i = 1; $i <= $total_page; $i++){
                                if($i == $page){
                                    $active = "active";
                                } else {
                                    $active = '';
                                }
                                echo "<li class='$active'><a href='index.php?page=$i'>$i</a></li>";
                            }
                            // if $total_page number is greater than $page number then Next button will be show or it will be hide
                            if($total_page > $page){
                                echo '<li><a href="index.php?page='.($page + 1).'">Next</a></li>';
                            }
                            echo "</ul>";
                        }
                        ?>

                    </div>
                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
