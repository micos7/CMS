<?php

function confirmQuery($result){
    if(!$result){
        printf("Error: %s.\n", $result->error);
    }
}

function insert_categories(){
    global $connection;
    if(isset($_POST['submit'])){
                            $cat_title = $_POST['cat_title'];
                            if(empty($cat_title)){
                                echo "Please fill in the field";
                            } else{
                                $st = $connection->prepare("INSERT INTO categories (cat_title) VALUES (?)");
                                $st->bind_param("s", $cat_title);
                                $st->execute();
                                if(!$st){
                                    printf("Error: %s.\n", $st->error);
                                }


                            }
                        }
}

function findAllCategories(){
    global $connection;
     $query = "SELECT * FROM categories";
     $select_categories = mysqli_query($connection,$query);

     while($row = mysqli_fetch_assoc($select_categories)){
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];
                            echo "<tr>";
                            echo "<td>{$cat_id}</td>";
                            echo "<td>{$cat_title}</td>";
                            echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
                            echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
                            echo "</tr>";
}
}

function deleteCategories(){
    global $connection;
     if(isset($_GET['delete'])){
                                $del_cat_id = $_GET['delete'];
                                $dst = $connection->prepare("DELETE FROM categories WHERE cat_id=?");
                                $dst->bind_param("i", $del_cat_id);
                                $dst->execute();
                                if(!$dst){
                                    printf("Error: %s.\n", $dst->error);
                                }
                                header('Location: categories.php');
                             }

}

function users_online(){
    if(isset($_GET['onlineusers'])){
        global $connection;
        if(!$connection){

            session_start();
           include('../includes/db.php');

    $session =session_id();
    $time = time();
    $timeout_secs = 5; 
    $timeout = $time - $timeout_secs;

    $se = $connection->prepare("SELECT * FROM users_online WHERE session=?");
        $se->bind_param("s", $session);
        $se->execute();
        $se->store_result();
        if(!$se){
            printf("Error: %s.\n", $se->error);
        }



    $count = $se->num_rows;

    if($count == NULL){
        $si = $connection->prepare("INSERT INTO  users_online(`session`,`time`) VALUES(?,?)");
        $si->bind_param("si", $session,$time);
        $si->execute();
    }else{
        $si = $connection->prepare("UPDATE users_online SET `time`=? WHERE session=?");
        $si->bind_param("ss",$time,$session);
        $si->execute();
    }

        $uo = $connection->prepare("SELECT id FROM users_online  WHERE `time` > ?");
        $uo->bind_param("i",$timeout);
        $uo->execute();
        $uo->store_result();
        echo $users_online = $uo->num_rows;
        }
    

    } 
}

users_online();

function recordCount($table){
    global $connection;
    $query = "SELECT * FROM ".$table;
    $count_all_posts = mysqli_query($connection,$query);
    $post_count = mysqli_num_rows($count_all_posts);
    return $post_count;
}

function checkStatus($table,$column,$status){
    global $connection;
    $query = "SELECT * FROM $table WHERE $column  = '$status' ";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);
}

function is_admin($username=''){
    global $connection;
    $uq = $connection->prepare("SELECT user_role FROM users  WHERE username=?");
        $uq->bind_param("s", $username);
        $uq->execute();
        if(!$uq){
            printf("Error: %s.\n", $uq->error);
        }
         $login_user = $uq->get_result();

   $row = $login_user->fetch_assoc();
   if($row['user_role'] == 'admin'){
       return true;
   }else {
       return false;
   }
    

}