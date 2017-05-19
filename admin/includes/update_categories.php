<form method="post">
                            <div class="form-group">
                            <label for="cat_title">Update Category</label>
                            <?php
                            //Edit categories

                            if(isset($_GET['edit'])){
                                $edit_cat_id = $_GET['edit'];
                                $est = $connection->prepare("SELECT * FROM categories WHERE cat_id=?");
                                $est->bind_param("s", $edit_cat_id);
                                $est->execute();
                                $edit_val = $est->get_result();
                                if(!$est){
                                    printf("Error: %s.\n", $est->error);
                                }
                                while($row = $edit_val->fetch_assoc()){
                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];
                                ?>

                                <input value = <?php echo "$cat_title ? $cat_title : ''" ?> type="text" name="cat_title" class="form-control" >
                                

                            <?php } } ?>

                            <?php
                            //Update categories
                            if(isset($_POST['update_category'])){
                                $get_cat_id = $_GET['edit'];
                                $update_cat = $_POST['cat_title'];
                                $dst = $connection->prepare("UPDATE categories SET cat_title=? WHERE cat_id=?");
                                $dst->bind_param("si", $update_cat,$get_cat_id);
                                $dst->execute();
                                if(!$dst){
                                    printf("Error: %s.\n", $dst->error);
                                }
                                header('Location: categories.php');
                             }
                            
                             ?>
                            
                            </div>
                            <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="update_category" value="Edit">
                            </div>
                        </form>