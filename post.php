<?php include('includes/header.php'); ?>
<?php include('includes/db.php'); ?>

    <!-- Navigation -->

<?php include('includes/navigation.php'); ?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php 

            if(isset($_GET['p_id'])){
                $post_id = $_GET['p_id'];
            }

            $ip = $connection->prepare("SELECT * FROM posts WHERE post_id=?");
                                $ip->bind_param("s", $post_id);
                                $ip->execute();
                                $post_val = $ip->get_result();
                                if(!$ip){
                                    printf("Error: %s.\n", $ip->error);
                                }
                                while($row = $post_val->fetch_assoc()){
                                    $post_title = $row['post_title'];
                                    $post_author = $row['post_author'];
                                    $post_date = $row['post_date'];
                                    $post_image = $row['post_image'];
                                    $post_content = $row['post_content'];
                                    $post_tags = $row['post_tags'];

                                
                    
                
                ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php } ?>



                 <!-- Blog Comments -->
                 <?php
                 if(isset($_POST['create_comment'])){
                      $post_id = $_GET['p_id'];

                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];
                    $comment_status = 'unapproved';

                      $pc = $connection->prepare("INSERT INTO comments(comment_post_id, comment_author,comment_email, comment_content,
       comment_status,comment_date)VALUES(?,?, ?,?,?,now())");
                                $pc->bind_param("issss", $post_id,$comment_author,$comment_email,$comment_content,$comment_status);
                                $pc->execute();
                 }
                 
                 
                 ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="post">
                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input type="text" class="form-control" id="comment_author" name="comment_author" value="">
                        </div>
                        <div class="form-group">
                            <label for="comment_email">Email</label>
                            <input type="email" class="form-control" id="comment_email" name="comment_email" value="">
                        </div>
                        <div class="form-group">
                            <label for="comment_content">Your comment</label>
                            <textarea class="form-control" id="comment_content" rows="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php 
                $ct = $connection->prepare("SELECT * FROM comments WHERE comment_post_id=? AND comment_status = 'approved' ORDER BY comment_id DESC");
                    $ct->bind_param("i", $post_id);
                    $ct->execute();
                    $post_ct = $ct->get_result();
                    if(!$ct){
                        printf("Error: %s.\n", $ep->error);
                    }
                     
                    while($row = $post_ct->fetch_assoc()){
                        $comment_author = $row['comment_author'];
                        $comment_content = $row['comment_content'];
                        $comment_date = $row['comment_date'];
                    
                
                ?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                       <?php echo $comment_content; ?>
                    </div>
                </div>

          

            





                    <?php } ?>

                </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include('includes/sidebar.php'); ?>

        </div>
        <!-- /.row -->

        <hr>
<?php include('includes/footer.php'); ?>

      