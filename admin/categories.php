<?php include('includes/admin_header.php'); ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include('includes/admin_navigation.php'); ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                        </h1>
                        <div class="col-xs-6">
                        <?php
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
                        
                        
                         ?>


                        <form method="post">
                            <div class="form-group" method="post">
                            <label for="cat_title">Add Category</label>
                            <input type="text" name="cat_title" class="form-control" >
                            </div>
                            <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                            </div>
                        </form>
                        </div>

                        <div class="col-xs-6">

                        <?php 
                            $query = "SELECT * FROM categories";
                            $select_categories = mysqli_query($connection,$query);
                        
                        ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category title</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
                            // Find all categories
                             while($row = mysqli_fetch_assoc($select_categories)){
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];
                            echo "<tr>";
                            echo "<td>{$cat_id}</td>";
                            echo "<td>{$cat_title}</td>";
                            echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
                            echo "</tr>";
                            } 
                            ?>

                            <?php
                            // Delete category
                             if(isset($_GET['delete'])){
                                 $del_cat_id = $_GET['delete'];
                                 $dst = $connection->prepare("DELETE FROM categories WHERE cat_id=?");
                                $dst->bind_param("s", $del_cat_id);
                                $dst->execute();
                                if(!$dst){
                                    printf("Error: %s.\n", $dst->error);
                                }
                                header('Location: categories.php');
                             }
                            ?>
                                
                                
                            </tbody>
                        </table>
                        </div>
                        
    
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->


<?php include('includes/admin_footer.php'); ?>