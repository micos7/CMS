 <?php
 include('delete_modal.php');

 if(isset($_POST['checkBoxArray'])){
     foreach($_POST['checkBoxArray'] as $postValueId){
         
      $bulk_options =   $_POST['bulkOptions'];

      switch ($bulk_options) {
        case 'publish':
            $pp= $connection->prepare("UPDATE posts set post_status=? WHERE post_id=?");
                    $pp->bind_param("si",$bulk_options, $postValueId);
                    $pp->execute();
                    if(!$pp){
                        printf("Error: %s.\n", $pp->error);
                    }
              break;
        case 'draft':
              $pp= $connection->prepare("UPDATE posts set post_status=? WHERE post_id=?");
                    $pp->bind_param("si",$bulk_options, $postValueId);
                    $pp->execute();
                    if(!$pp){
                        printf("Error: %s.\n", $pp->error);
                    }
              break;
        case 'delete':
              $pp= $connection->prepare("DELETE FROM  posts WHERE post_id=?");
                    $pp->bind_param("i", $postValueId);
                    $pp->execute();
                    if(!$pp){
                        printf("Error: %s.\n", $pp->error);
                    }
              break;
        case 'clone':
              $pp= $connection->prepare("SELECT * FROM  posts WHERE post_id=?");
                    $pp->bind_param("i", $postValueId);
                    $pp->execute();
                    if(!$pp){
                        printf("Error: %s.\n", $pp->error);
                    }
                    $select_post = $pp->get_result();
                    while($row = $select_post->fetch_assoc()){
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_user = $row['post_user'];
                            $post_category_id = $row['post_category_id'];
                            $post_status = $row['post_status'];
                            $post_image = $row['post_image'];
                            $post_tags = $row['post_tags'];
                            //$post_comment_count = $row['post_comment_count'];
                            $post_date = $row['post_date'];
                            $post_content = $row['post_content'];
                    }
                  $ap = $connection->prepare("INSERT INTO posts(post_category_id, post_title, post_author,post_user, post_date, post_image, post_content,
       post_tags, post_status)VALUES(?,?,?,?,now(), ?,?,?,?)");
                                $ap->bind_param("ssssssss", $post_category_id,$post_title,$post_author,$post_user,$post_image,$post_content,
                                $post_tags,$post_status);
                                $ap->execute();    
              break;
          default:
              # code...
              break;
      
     }
 }
 }
 
  ?>
 
 
 
 <form action="" method="post">
     
 
 <table class="table table-bordered table-hover">

 <div id="bulkOptionsContainer" class="col-xs-4">
 <select class="form-control" name="bulkOptions">
     <option value="">Select options</option>
     <option value="publish">Publish</option>
     <option value="draft">Draft</option>
     <option value="delete">Delete</option>
     <option value="clone">Clone</option>
 </select>
 </div>
 <div class="col-xs-4">
 <input type="submit" name="submit" value="Apply" class="btn btn-success">
 <a class="btn btn-primary" href="add_post.php">Add new</a>
 </div>
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="" id="selectAllBoxes"></th>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Users</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Comment Count</th>
                                    <th>Date</th>
                                    <th>View post</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    <th>Post views</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php


            $query = "SELECT  p.post_id, p.post_category_id, p.post_title, p.post_author, p.post_user, p.post_date, p.post_image, p.post_content,
             p.post_tags, p.post_comment_count, p.post_status, p.post_views_count,c.cat_id,c.cat_title
            FROM posts p LEFT JOIN categories c ON p.post_category_id = c.cat_id ORDER BY p.post_id DESC";
            $select_posts = mysqli_query($connection,$query);

            while($row = mysqli_fetch_assoc($select_posts)){
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_user = $row['post_user'];
                            $post_category_id = $row['post_category_id'];
                            $post_status = $row['post_status'];
                            $post_image = $row['post_image'];
                            $post_tags = $row['post_tags'];
                            //$post_comment_count = $row['post_comment_count'];
                            $post_date = $row['post_date'];
                            $post_views_count = $row['post_views_count'];
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];

                            echo "<tr>";
                            echo "<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='$post_id'></td>";
                            echo "<td>$post_id </td>";

                            echo "<td>$post_title </td>";
                            if(!empty($post_author)){
                                echo "<td>$post_author </td>";
                            }elseif( !empty($post_user)){
                                echo "<td>$post_user </td>";
                            }






            echo "<td>$cat_title </td>";
            echo "<td>$post_status </td>";
            echo "<td><img width='100' src='../images/$post_image'> </td>";
            echo "<td>$post_tags </td>";

             $cc = $connection->prepare("SELECT comment_id FROM comments WHERE comment_post_id=? ");
                    $cc->bind_param("i", $post_id);
                    $cc->execute();
                    $cc->bind_result($comment_id);
                    $cc->store_result();
                    $post_comment_count = $cc->num_rows;
                    
                    
                    $cc->fetch();

                
                    if(!$cc){
                        printf("Error: %s.\n", $cc->error);
                        }        
            echo "<td><a href='post_comments.php?id=$post_id'>$post_comment_count</a> </td>";
            echo "<td>$post_date </td>";
            echo "<td><a href='../post.php?p_id=$post_id'>View post</a></td>";
            echo "<td><a href='posts.php?source=edit_post&p_id=$post_id'>Edit</a></td>";
            echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
            //echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?');\"  href='posts.php?delete=$post_id'>Delete</a></td>";
            echo "<td class='text-center'><a href='posts.php?reset=$post_id'>{$post_views_count}</a></td>";
            echo "</tr>";

            }
            ?>

                                <td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </td>
                            </tbody>
                        </table>
                </form>

<?php

if(isset($_GET['delete'])){
$del_post_id = $_GET['delete'];

 $dpi = $connection->prepare("DELETE FROM posts WHERE post_id=?");
        $dpi->bind_param("i", $del_post_id);
        $dpi->execute();
        if(!$dpi){
            printf("Error: %s.\n", $dpi->error);
        }
        header('Location: posts.php');
}

if(isset($_GET['reset'])){
$reset_post_id = $_GET['reset'];

 $dpi = $connection->prepare("UPDATE  posts set post_views_count =0 WHERE post_id=?");
        $dpi->bind_param("i", $reset_post_id);
        $dpi->execute();
        if(!$dpi){
            printf("Error: %s.\n", $dpi->error);
        }
        header('Location: posts.php');
}


 ?>
 <script>
 $(document).ready(function(){
    $(".delete_link").on("click", function(){
        var id = $(this).attr("rel");
        var delete_url = "posts.php?delete="+ id + " ";
        $(".modal_delete_link").attr("href",delete_url);
        $("#myModal").modal("show");
    })
 });
</script>