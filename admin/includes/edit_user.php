<?php
if(isset($_GET['edit_user'])){
    $user_id = $_GET['edit_user'];

    $su = $connection->prepare("SELECT * FROM users WHERE user_id=?");
        $su->bind_param("i", $user_id);
        $su->execute();
        if(!$su){
            printf("Error: %s.\n", $su->error);
        }


    $select_users = $su->get_result();

    while($row = $select_users->fetch_assoc()){
                    $user_id = $row['user_id'];
                    $username = $row['username'];
                    $user_password = $row['user_password'];
                    $user_firstname = $row['user_firstname'];
                    $user_lastname = $row['user_lastname'];
                    $user_email = $row['user_email'];
                    $user_image = $row['user_image'];
                    $user_role = $row['user_role'];
                    $salt = $row['randSalt'];
    }
}

if(isset($_POST['edit_user'])){
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];
    
    // $post_image = $_FILES['image']['name'];
    // $post_image_temp = $_FILES['image']['tmp_name'];
    
    //$post_date = date('d-m-y');
    
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    //$post_comment_count = 0;

    //move_uploaded_file($post_image_temp,"../images/$post_image");


    $hash_password = crypt($user_password,$salt);

        $dpi = $connection->prepare("UPDATE  users SET user_firstname =?,user_lastname=?,user_role=?,username=?,user_email=?,user_password =?
          WHERE user_id=?");
           $dpi->bind_param("ssssssi", $user_firstname,$user_lastname,$user_role,$username,$user_email,$hash_password,$user_id);
        $dpi->execute();
        if(!$dpi){
            printf("Error: %s.\n", $dpi->error);
        }
       
       

       echo "<p class='bg-success'>User Added: " . "<a href='users.php'>View User</a></p>";
}



 ?>



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
