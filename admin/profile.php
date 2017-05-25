<?php include('includes/admin_header.php'); ?>
<?php
if(isset($_SESSION['username'])){

}

 ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include('includes/admin_navigation.php'); ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    <h1 class="page-header">
                            Welcome to pages
                            <small>Author</small>
                        </h1>
        <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
    </div>
    
    <div class="form-group">
        <label for="categories">User Role</label>
        <select name="user_role" class="form-control" >
           <option value="subscriber"><?php echo $user_role ; ?></option>
           <?php
                if($user_role == 'admin'){
                    echo "<option value='subscriber' >Subscriber</option>";
                } else {
                    echo "<option value='admin'>Admin</option>";
                }
            ?>
           

        </select>
    </div>
    
    <div class="form-group">
        <label for="author">Lastname</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
    </div>
    
    <div class="form-group">
        <label for="post_status">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
    </div>
    
    <!--<div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
        <p class="help-block">Select an image for the post.</p>
    </div>-->
    
    <div class="form-group">
        <label for="post_tags">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
    </div>

    <div class="form-group">
        <label for="post_tags">Password</label>
        <input type="password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
    </div>
    
   
    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Edit user">
    </div>
</form>
    
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->


<?php include('includes/admin_footer.php'); ?>