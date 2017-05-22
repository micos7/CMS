 <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>In Response to</th>
                                    <th>Date</th>
                                    <th>Approve</th>
                                    <th>Unapprove</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php

            $query = "SELECT * FROM comments";
            $select_comments = mysqli_query($connection,$query);

            while($row = mysqli_fetch_assoc($select_comments)){
                            $comment_id = $row['comment_id'];
                            $comment_post_id = $row['comment_post_id'];
                            $comment_author = $row['comment_author'];
                            $comment_email = $row['comment_email'];
                            $comment_status = $row['comment_status'];
                            $comment_content = $row['comment_content'];
                            $comment_date = $row['comment_date'];
    

                            echo "<tr>";
                            echo "<td>$comment_id </td>";
                            echo "<td>$comment_author </td>";
                            echo "<td>$comment_content </td>";
                            echo "<td>$comment_email </td>";
                            echo "<td>$comment_status </td>";


                    $ct = $connection->prepare("SELECT * FROM posts WHERE post_id=?");
                    $ct->bind_param("i", $comment_post_id);
                    $ct->execute();
                    $post_ct = $ct->get_result();
                    if(!$ct){
                        printf("Error: %s.\n", $ep->error);
                    }
                     
                    while($row = $post_ct->fetch_assoc()){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                    }


                            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                            echo "<td>$comment_date </td>";
                            echo "<td><a href='posts.php?source=edit_post&p_id=$post_id'>Approve</a></td>";
                            echo "<td><a href='posts.php?delete=$post_id'>Unappove</a></td>";
                            echo "<td><a href='posts.php?source=edit_post&p_id=$post_id'>Edit</a></td>";
                            echo "<td><a href='posts.php?delete=$post_id'>Delete</a></td>";
                            echo "</tr>";

             }
            ?>

                           
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