<?php include('db.php'); ?>
<?php

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

     $uq = $connection->prepare("SELECT * FROM users  WHERE username=?");
        $uq->bind_param("s", $username);
        $uq->execute();
        if(!$uq){
            printf("Error: %s.\n", $uq->error);
        }
         $login_user = $uq->get_result();

    while($row = $login_user->fetch_assoc()){
        $db_id = $_POST['user_id'];
        $db_username = $_POST['username'];
        $db_password = $_POST['password'];
        $db_user_firstname = $_POST['user_firstname'];
        $db_user_lastname = $_POST['user_lastname'];
        $db_user_role = $_POST['user_role'];
    }

    if($username !== $db_username && $password !== $db_password){
        header('Location: ../index.php');
    }else if ($username == $db_username && $password == $db_password){
        header('Location: ../admin');
    }
}

?>