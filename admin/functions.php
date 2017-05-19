<?php

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