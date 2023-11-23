<?php
include 'conn.php';
session_start();

// if (isset($_SESSION['userid']) && isset($_SESSION['name']) && isset($_SESSION['uploadfile'])) {

//     $user_id = $_SESSION['userid'];
//     $user_name = $_SESSION['name'];
//     $user_image = $_SESSION['uploadfile'];
//     header("Location: ./index.php");
//     exit();
// }

/*popup functionality*/
if (isset($_POST['submit']) &&  !empty($_POST['submit'])) {
    $user_id = $_SESSION['userid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];

    $check_query = "SELECT * FROM contact WHERE email = '$email' AND userid = '$user_id'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $signup_error = "Error: Email already exists.";
    } else {

        $query = 'INSERT INTO contact(userid, name, email, number) VALUES ("' . $user_id . '","' . $name . '", "' . $email . '", "' . $number . '")';
        $result = mysqli_query($conn, $query);
        if ($result) {
            /*this function used to redirect to another page */
        } else {
            $signup_error = "Error: " . mysqli_error($conn);
        }
    }
}

$user_id = $_SESSION['userid'];
$select_query = "SELECT * FROM contact WHERE userid = '$user_id'";
$result_set = mysqli_query($conn, $select_query);
// Check for errors in the query
if (!$result_set) {
    $error_message = "Error: " . mysqli_error($conn);
}

// Fetch data and display in the table
$data_rows = "";
while ($row = mysqli_fetch_assoc($result_set)) {
    $data_rows .= "<tr>";
    $data_rows .= "<th scope='row'>" . $row['id'] . "</th>";
    $data_rows .= "<td>" . $row['name'] . "</td>";
    $data_rows .= "<td>" . $row['email'] . "</td>";
    $data_rows .= "<td>" . $row['number'] . "</td>";
    $data_rows .= "<td>";
    $data_rows .= "<button class='btn btn-success' id='edit-id' data-id='" . $row['id'] . "' data-name='" . $row['name'] . "' data-email='" . $row['email'] . "' data-number='" . $row['number'] . "'>Edit</button> ";
    $data_rows .= "<a href='welcome.php?delete_id=" . $row['id'] . "' class='btn btn-success'>Delete</a> ";
    $data_rows .= "</tr>";
}

// Close the result set
mysqli_free_result($result_set);
/*delete model functionality*/
if (isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $user_id = $_GET['delete_id'];

    // Delete the data from the database
    $delete_query = "DELETE FROM contact WHERE id = '$user_id'";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        // Redirect to the same page after successful deletion
        header("Location: ./welcome.php");
        exit();
    } else {
        // Handle deletion error
        echo "Error deleting data: " . mysqli_error($conn);
    }
}
/*edit model functionality*/
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $edit_id = $_POST["edit_id"];
//     $name = $_POST["name"];
//     $email = $_POST["email"];
//     $number = $_POST["number"];
// }
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

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add New</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="welcome.php" method="POST">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Name</label>
                                    <input type="text" class="form-control" id="recipient-name" name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-email" class="col-form-label">Email-id</label>
                                    <input type="text" class="form-control" id="recipient-email" name="email">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-number" class="col-form-label">Mobile Number</label>
                                    <input type="text" class="form-control" id="recipient-number" name="number">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <input type="submit" name="submit" value="save" class="btn btn-primary"></input>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!--edit model-->
            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Detail</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="welcome.php" method="POST">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Name</label>
                                    <input type="text" class="form-control" id="recipient-name" name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-email" class="col-form-label">Email-id</label>
                                    <input type="text" class="form-control" id="recipient-email" name="email">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-number" class="col-form-label">Mobile Number</label>
                                    <input type="text" class="form-control" id="recipient-number" name="number">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <input type="submit" name="delete_submit" value="Update" class="btn btn-primary"></input>
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
                <tbody>
                    <?php echo $data_rows; ?>
                </tbody>
            </table>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script type="text/javascript" src="signup.js"></script>

</body>

</html>