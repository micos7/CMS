<?php include('includes/header.php'); ?>
<?php include('includes/db.php'); ?>
<?php session_start(); ?>

    <!-- Navigation -->

<?php include('includes/navigation.php'); ?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php 

            if(isset($_GET['p_id'])){
                $post_id    = $_GET['p_id'];
                $post_auth  = $_GET['author'];
            }

            $ip = $connection->prepare("SELECT * FROM posts WHERE post_user=?");
                                $ip->bind_param("s", $post_auth);
                                $ip->execute();
                                $post_val = $ip->get_result();
                                if(!$ip){
                                    printf("Error: %s.\n", $ip->error);
                                }
                                while($row = $post_val->fetch_assoc()){
                                    $post_title = $row['post_title'];
                                    $post_author = $row['post_user'];
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
                    All posts by <?php echo $post_author; ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                

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


                    if(!empty($comment_author) && !empty($comment_email)  && !empty($comment_content)){

                    $pc = $connection->prepare("INSERT INTO comments(comment_post_id, comment_author,comment_email, comment_content,
    comment_status,comment_date)VALUES(?,?, ?,?,?,now())");
                            $pc->bind_param("issss", $post_id,$comment_author,$comment_email,$comment_content,$comment_status);
                            $pc->execute();

                            //todo decrement when deleting comments
                $uc = $connection->prepare("UPDATE posts  SET post_comment_count=post_comment_count+1 WHERE post_id=? ");
                    $uc->bind_param("i", $post_id);
                    $uc->execute();
                    if(!$uc){
                        printf("Error: %s.\n", $uc->error);
                        }        
   

                    } else {
                        echo "<script>alert('Comment fields cannnot be empty!')</script>";
                    }

        

                 }
                 
                 
                 ?>



                </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include('includes/sidebar.php'); ?>

        </div>
        <!-- /.row -->

        <hr>
<?php include('includes/footer.php'); ?>

      