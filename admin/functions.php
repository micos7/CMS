<?php

function confirmQuery($result){
    if(!$result){
        printf("Error: %s.\n", $result->error);
    }
}

function redirect($location){
    return header('Location: '.$location);
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

function is_admin($username){
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

function username_exists($username){
     global $connection;
    $uq = $connection->prepare("SELECT username FROM users  WHERE username=?");
        $uq->bind_param("s", $username);
        $uq->execute();
        if(!$uq){
            printf("Error: %s.\n", $uq->error);
        }
        $uq->store_result();
         if($uq->num_rows > 0){
             return true;
         }else{
             return false;
         }
}

function emailexists($email){
     global $connection;
    $uq = $connection->prepare("SELECT user_email FROM user_email  WHERE username=?");
        $uq->bind_param("s", $email);
        $uq->execute();
        if(!$uq){
            printf("Error: %s.\n", $uq->error);
        }
        $uq->store_result();
         if($uq->num_rows > 0){
             return true;
         }else{
             return false;
         }
}

function register_user($username,$email,$password){
    global $connection;

   

        if(username_exists($username)){
            $message ="User exists";
        }

        
        if(!empty($username) && !empty($email) && !empty($password)){

            $password = password_hash($password,PASSWORD_BCRYPT,array('cost'=> 10));




            $ap = $connection->prepare("INSERT INTO users(username, user_email, user_password,user_role)VALUES(?,?,?,?)");
                                $ap->bind_param("ssss", $username,$email,$password,$subscriber_role);
                                $ap->execute();

            $message ='Your registration as been submitted!';

        } else {
            $message = 'Fields cannot be empty!';
        }

        
    }

    function login_user($username,$password){
            global $connection;

            $uq = $connection->prepare("SELECT * FROM users  WHERE username=?");
                $uq->bind_param("s", $username);
                $uq->execute();
                if(!$uq){
                    printf("Error: %s.\n", $uq->error);
                }
                $login_user = $uq->get_result();

            while($row = $login_user->fetch_assoc()){
                $db_id = $row['user_id'];
                $db_username = $row['username'];
                $db_password = $row['user_password'];
                $db_user_firstname = $row['user_firstname'];
                $db_user_lastname = $row['user_lastname'];
                $db_user_role = $row['user_role'];
            }


            if(password_verify($password,$db_password )){

                $_SESSION['username'] = $db_username;
                $_SESSION['user_id'] = $db_id;
                $_SESSION['firstname'] = $db_user_firstname;
                $_SESSION['lastname'] = $db_user_lastname;
                $_SESSION['user_role'] = $db_user_role;

                header('Location: ../admin');
                
            }else{
                
                header('Location: ../index.php');
            }
    }
    


