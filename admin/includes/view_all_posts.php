 <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Comment Count</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php

            $query = "SELECT * FROM posts";
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
                            echo "<td>$post_id </td>";
                            echo "<td>$post_title </td>";
                            echo "<td>$post_author </td>";

                    //TODO - change to a JOIN in the main query
                    $ct = $connection->prepare("SELECT * FROM categories WHERE cat_id=?");
                    $ct->bind_param("i", $post_category_id);
                    $ct->execute();
                    $post_ct = $ct->get_result();
                    if(!$ct){
                        printf("Error: %s.\n", $ep->error);
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
                            echo "<td><a href='posts.php?source=edit_post&p_id=$post_id'>Edit</a></td>";
                            echo "<td><a href='posts.php?delete=$post_id'>Delete</a></td>";
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
                                </td>
                            </tbody>
                        </table>

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