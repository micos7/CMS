 <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php

            $query = "SELECT * FROM users";
            $select_users = mysqli_query($connection,$query);

            while($row = mysqli_fetch_assoc($select_users)){
                            $user_id = $row['user_id'];
                            $username = $row['username'];
                            $user_password = $row['user_password'];
                            $user_firstname = $row['user_firstname'];
                            $user_lastname = $row['user_lastname'];
                            $user_email = $row['user_email'];
                            $user_image = $row['user_image'];
                            $user_role = $row['user_role'];
    

                            echo "<tr>";
                            echo "<td>$user_id </td>";
                            echo "<td>$username </td>";
                            echo "<td>$user_firstname </td>";
                            echo "<td>$user_lastname </td>";
                            echo "<td>$user_email </td>";
                            echo "<td>$user_role </td>";


                    // $ct = $connection->prepare("SELECT * FROM posts WHERE post_id=?");
                    // $ct->bind_param("i", $comment_post_id);
                    // $ct->execute();
                    // $post_ct = $ct->get_result();
                    // if(!$ct){
                    //     printf("Error: %s.\n", $ep->error);
                    // }
                     
                    // while($row = $post_ct->fetch_assoc()){
                    //     $post_id = $row['post_id'];
                    //     $post_title = $row['post_title'];
                    // }


                            echo "<td><a href='comments.php?approve='>Approve</a></td>";
                            echo "<td><a href='comments.php?unapprove='>Unapprove</a></td>";
                            echo "<td><a href='users.php?delete=$user_id'>Delete</a></td>";
                            echo "</tr>";

             }
            ?>

                           
                            </tbody>
                        </table>

<?php

if(isset($_GET['unapprove'])){
$status_comment_id = $_GET['unapprove'];

 $dpi = $connection->prepare("UPDATE  comments SET comment_status ='unapproved'  WHERE comment_id=?");
        $dpi->bind_param("i", $status_comment_id);
        $dpi->execute();
        if(!$dpi){
            printf("Error: %s.\n", $dpi->error);
        }
        header('Location: comments.php');
}

if(isset($_GET['approve'])){
$status_comment_id = $_GET['approve'];

 $dpi = $connection->prepare("UPDATE  comments SET comment_status ='approved'  WHERE comment_id=?");
        $dpi->bind_param("i", $status_comment_id);
        $dpi->execute();
        if(!$dpi){
            printf("Error: %s.\n", $dpi->error);
        }
        header('Location: comments.php');
}

if(isset($_GET['delete'])){
$user_id = $_GET['delete'];

 $dpi = $connection->prepare("DELETE FROM users WHERE user_id=?");
        $dpi->bind_param("i", $user_id);
        $dpi->execute();
        if(!$dpi){
            printf("Error: %s.\n", $dpi->error);
        }
        header('Location: users.php');
} 


 ?>