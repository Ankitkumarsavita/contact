<?php
include 'conn.php';

session_start();

if (!isset($_SESSION['userid']) && !isset($_SESSION['name']) && !isset($_SESSION['uploadfile'])) {

    $user_id = $_SESSION['userid'];
    $user_name = $_SESSION['name'];
    $user_image = $_SESSION['uploadfile'];
    header("Location: ./index.php");
    exit();
}


/*this query use display data into table */


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="style.css">

    <title>welcome</title>
</head>

<body>
    <center>
        <div class="col-sm-20" style="">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="Fourth navbar example">
                <div class="container-fluid position-relative">
                    <div class="collapse navbar-collapse" id="navbarsExample04">
                        <ul class="navbar-nav me-auto mb-2 mb-md-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                            </li>
                        </ul>

                        <div class="d-flex align-items-center">

                            <img src="./images/<?php echo $_SESSION['uploadfile']; ?>" alt="User Image" style="width: 50px; height: 50px; border-radius: 50%;">---
                            <h1 style="color: white; font-size: 20px;"><?php echo $_SESSION['name']; ?></h1>
                            <a href="./logout.php">
                                <button class="btn btn-primary ms-3">Logout</button>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <center>
            <!--popup botton-->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Add New</button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add New</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Name</label>
                                    <input type="text" class="form-control" id="recipient-name" name="name">
                                    <span id="add_name_msg"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-email" class="col-form-label">Email-id</label>
                                    <input type="text" class="form-control email_id" id="recipient-email" name="email">
                                    <span id="add_email_msg"></span>

                                </div>
                                <div class="mb-3">
                                    <label for="recipient-number" class="col-form-label">Mobile Number</label>
                                    <input type="text" class="form-control" id="recipient-number" name="number">
                                    <span id="add_number_msg"></span>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <input type="button" name="add_submit" value="save" class="btn btn-primary" id="add_submit"></input>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--edit model-->
            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="update-exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="update-exampleModalLabel">Update Detail</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="update-name" class="col-form-label">Name</label>
                                    <input type="text" class="form-control" id="update-name" name="name">
                                    <input type="hidden" name="update-id" id='update-id' value="">

                                </div>
                                <div class="mb-3">
                                    <label for="update-email" class="col-form-label">Email-id</label>
                                    <input type="text" class="form-control" id="update-email" name="email">
                                    <span id="update_email_msg"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="update-number" class="col-form-label">Mobile Number</label>
                                    <input type="text" class="form-control" id="update-number" name="number">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <input type="button" name="update_submit" id="update_submit" value="Update" class="btn btn-primary"></input>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--delete-->
            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="delete-exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-body">
                        <form method="POST">
                            <p>Are you want to delete this item?</p>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                <input type="submit" name="delete_submit" id="delete_submit" value="Yes" class="btn btn-primary"></input>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--table-->
            <table class="table">
                <thead class="table table-success table-striped">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile Number</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="tabledata">
             
                </tbody>
            </table>
          
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script type="text/javascript" src="common.js"></script>

</body>

</html>