<?php 
$edit_post_id = $_GET['p_id'] ? $_GET['p_id'] : '';
$ep = $connection->prepare("SELECT * FROM posts WHERE post_id=?");
                    $ep->bind_param("i", $edit_post_id);
                    $ep->execute();
                    $post_edit = $ep->get_result();
                    if(!$ep){
                        printf("Error: %s.\n", $ep->error);
                    }

while($row = $post_edit->fetch_assoc()){
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_content = $row['post_content'];
                $post_comment_count = $row['post_comment_count'];
                $post_date = $row['post_date'];

}

if(isset($_POST['update_post'])){

                $post_title = $_POST['title'];
                $post_author = $_POST['author'];
                $post_category_id = $_POST['post_category'];
                $post_status = $_POST['post_status'];
                $post_image = $_FILES['image']['name'];
                $post_image_tmp = $_FILES['image']['tmp_name'];
                $post_tags = $_POST['post_tags'];
                $post_content = $_POST['post_content'];

                move_uploaded_file($post_image_tmp,"../images/$post_image");

                if(empty($post_image)){
                    $img = $connection->prepare("SELECT post_image FROM posts WHERE post_id=?");
                    $img->bind_param("i", $edit_post_id);
                    $img->execute();
                    $img_file = $img->get_result();
                    if(!$ep){
                        printf("Error: %s.\n", $ep->error);
                    }
                    while($row = $img_file->fetch_assoc()){
                    $post_image = $row['post_image'];

                    }
                }

                $ap = $connection->prepare("UPDATE posts SET post_category_id=?, post_title=?, post_author=?, post_date=now(), post_image=?, post_content=?,
       post_tags=?, post_status=? WHERE post_id = ?");
                                $ap->bind_param("sssssssi", $post_category_id,$post_title,$post_author,$post_image,$post_content,
                                $post_tags,$post_status,$edit_post_id);
                                $ap->execute();
                                confirmQuery($ap);

           echo "<p class='bg-success'>Post Updated: " . "<a href='../post.php?p_id=$post_id'>View Post</a> or <a href='posts.php'>Edit posts</a></p>";     

}

?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $post_title; ?>">
    </div>
    
    <div class="form-group">
        <label for="categories">Post Category</label>
        <select name="post_category" class="form-control" >
        <?php
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection,$query);
         while($row = mysqli_fetch_assoc($select_categories)){
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];

            echo "<option value='{$cat_id}'>{$cat_title}</option>";
         }
        ?>
           
        </select>
    </div>
    
    <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" class="form-control" name="author" value="<?php echo $post_author; ?>">
    </div>
    
    <div class="form-group">
    <select name="post_status">
        <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
        <?php
        if($post_status == 'publish'){
            echo "<option value='draft'>Draft</option>";
        }else{
            echo "<option value='publish'>Publish</option>";
        }
        ?>
    </select>
    </div>
    
    <div class="form-group">
        <label for="image">Post Image</label>
        <img width="100" src="../images/<?php echo $post_image ?>" alt="">
        <input type="file" name="image">
    </div>
    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>
    
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" id="" cols="30" rows="10" class="form-control" >
        <?php echo $post_content; ?>
        </textarea>
    </div>
    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
</form> 