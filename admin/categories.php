<?php include('includes/header.php'); ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include('includes/navigation.php'); ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small>Subheading</small>
                        </h1>
                        <div class="col-xs-6">
                        <form>
                            <div class="form-group">
                            <label for="cat_title">Add Category</label>
                            <input type="text" name="cat_title" class="form-control" >
                            </div>
                            <div class="form-group">
                            <input class="btn btn-primary" type="tesubmitxt" name="submit" value="Add Category">
                            </div>
                        </form>
                        </div>

                        <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category title</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Test</td>
                                    <td>Blah</td>
                                </tr>
                                
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


<?php include('includes/footer.php'); ?>