 <?php
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
                            $post_category_id = $row['post_category_id'];
                            $post_status = $row['post_status'];
                            $post_image = $row['post_image'];
                            $post_tags = $row['post_tags'];
                            $post_comment_count = $row['post_comment_count'];
                            $post_date = $row['post_date'];
                            $post_content = $row['post_content'];
                    }
                  $ap = $connection->prepare("INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content,
       post_tags, post_status)VALUES(?,?,?,now(), ?,?,?,?)");
                                $ap->bind_param("sssssss", $post_category_id,$post_title,$post_author,$post_image,$post_content,
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
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Comment Count</th>
                                    <th>Date</th>
                                    <th>View post</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php

            $query = "SELECT * FROM posts ORDER BY post_id DESC";
            $select_posts = mysqli_query($connection,$query);

            while($row = mysqli_fetch_assoc($select_posts)){
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_category_id = $row['post_category_id'];
                            $post_status = $row['post_status'];
                            $post_image = $row['post_image'];
                            $post_tags = $row['post_tags'];
                            $post_comment_count = $row['post_comment_count'];
                            $post_date = $row['post_date'];

                            echo "<tr>";
                            echo "<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='$post_id'></td>";
                            echo "<td>$post_id </td>";
                            echo "<td>$post_title </td>";
                            echo "<td>$post_author </td>";

                    //TODO - change to a JOIN in the main query
                    $ct = $connection->prepare("SELECT * FROM categories WHERE cat_id=?");
                    $ct->bind_param("i", $post_category_id);
                    $ct->execute();
                    $post_ct = $ct->get_result();
                    if(!$ct){
                        printf("Error: %s.\n", $ct->error);
                    }
                     
                    while($row = $post_ct->fetch_assoc()){
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                    }




                            echo "<td>$cat_title </td>";
                            echo "<td>$post_status </td>";
                            echo "<td><img width='100' src='../images/$post_image'> </td>";
                            echo "<td>$post_tags </td>";
                            echo "<td>$post_comment_count </td>";
                            echo "<td>$post_date </td>";
                            echo "<td><a href='../post.php?p_id=$post_id'>View post</a></td>";
                            echo "<td><a href='posts.php?source=edit_post&p_id=$post_id'>Edit</a></td>";
                            echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?');\"  href='posts.php?delete=$post_id'>Delete</a></td>";
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


 ?>