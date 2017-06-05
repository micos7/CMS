<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>

    <?php
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $subscriber_role = 'subscriber';

        
        if(!empty($username) && !empty($email) && !empty($password)){

            $password = password_hash($password,PASSWORD_BCRYPT,array('cost'=> 10));




            $ap = $connection->prepare("INSERT INTO users(username, user_email, user_password,user_role)VALUES(?,?,?,?)");
                                $ap->bind_param("ssss", $username,$email,$password,$subscriber_role);
                                $ap->execute();

            $message ='Your registration as been submitted!';

        } else {
            $message = 'Fields cannot be empty!';
        }

        
    } else {
        $message = '';
    }
    
    
     ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
 
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="subject" name="subject" id="subject" class="form-control" placeholder="Enter your subject">
                        </div> 
                         <div class="form-group">
                            <textarea class="form-control" name="body" id="body" cols="50" rows="10"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
