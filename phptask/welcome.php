<?php
include 'conn.php';

session_start();

// if(isset($_POST['check_Emailbtn']))
// {
//     $email = $_POST['email'];
//     $checkemail = "SELECT * FROM contact WHERE email = '$email'";
//     $checkeamil_run = mysqli_query($conn , $checkemail);
//     if(mysqli_num_rows($checkemai_run)>0)
//     {
// echo "email already exist";
//     }
   
// }

if (!isset($_SESSION['userid']) && !isset($_SESSION['name']) && !isset($_SESSION['uploadfile'])) {
    
    $user_id = $_SESSION['userid'];
    $user_name = $_SESSION['name'];
    $user_image = $_SESSION['uploadfile'];
    header("Location: ./index.php");
    exit();
}

/* Add new popup functionality*/
if (isset($_POST['submit']) && !empty($_POST['submit'])) {
    $user_id = $_SESSION['userid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];

    // Check if the email already exists for the current user
    $check_email_query = "SELECT * FROM contact WHERE email = '$email' AND userid = '$user_id'";
    $check_email_result = mysqli_query($conn, $check_email_query);

    // Check if the number already exists for the current user
    $check_number_query = "SELECT * FROM contact WHERE number = '$number' AND userid = '$user_id'";
    $check_number_result = mysqli_query($conn, $check_number_query);

    if (mysqli_num_rows($check_email_result) > 0 || mysqli_num_rows($check_number_result) > 0) {
        // Email or number already exists, handle accordingly (e.g., show an error message)
        $email_error = "Error: Email or number already exists for this user.";
    } else {
        // Email and number do not exist, insert a new record
        $query = 'INSERT INTO contact(userid, name, email, number) VALUES ("' . $user_id . '","' . $name . '", "' . $email . '", "' . $number . '")';
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Record inserted successfully, handle accordingly (e.g., redirect to another page)
            /* this function used to redirect to another page */
        } else {
            // Error inserting record, handle accordingly (e.g., show an error message)
            $email_error = "Error: " . mysqli_error($conn);
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
    $data_rows .= "<button class='btn btn-success edit-id' data-id='" . $row['id'] . "' data-name='" . $row['name'] . "' data-email='" . $row['email'] . "' data-number='" . $row['number'] . "'>Edit</button> ";
    $data_rows .= "<a href='#' class='btn btn-success' onclick='confirmDelete(" . $row['id'] . ")'>Delete</a> ";

    $data_rows .= "</tr>";
}

// Delete Item 
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
/*edit popup*/ 
// elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_submit'])) {
//     // Handle the update logic here
//     $id = isset($_POST['update-id']) ? $_POST['update-id'] : '';
//     $newName = isset($_POST['name']) ? $_POST['name'] : '';
//     $newEmail = isset($_POST['email']) ? $_POST['email'] : '';
//     $newNumber = isset($_POST['number']) ? $_POST['number'] : '';

//     // Check if email or number already exists
//     $checkQuery = "SELECT id FROM contact WHERE email=? OR number=? AND id !=?";
//     $checkStmt = $conn->prepare($checkQuery);
//     $checkStmt->bind_param("ssi", $newEmail, $newNumber, $id);
//     $checkStmt->execute();
//     $checkResult = $checkStmt->get_result();

//     if ($checkResult->num_rows > 0) {
//         // Email or number already exists, handle accordingly (e.g., show an error message)
//         $email_error = "Error: Email or number already exists for this user.";
//     } else {
//         // Perform the update query
//         if (!empty($newName) && !empty($newEmail) && !empty($newNumber) && !empty($id)) {
//             $updateQuery = "UPDATE contact SET name=?, email=?, number=? WHERE id=?";
//             $updateStmt = $conn->prepare($updateQuery);
//             $updateStmt->bind_param("sssi", $newName, $newEmail, $newNumber, $id);

//             if ($updateStmt->execute()) {
//                 // Update successful
//             } else {
//                 // Update failed
//                 echo "Error updating data: " . $updateStmt->error;
//             }

//             // Close the statement
//             $updateStmt->close();
//         } else {
//             // Invalid data for update
//             echo "Invalid data for update";
//         }
//     }

//     // Close the statement
//     $checkStmt->close();
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
                <form method="POST">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Name</label>
                        <input type="text" class="form-control" id="recipient-name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-email" class="col-form-label">Email-id</label>
                        <span class = "email_error" ></span>
                        <input type="text" class="form-control email_id" id="recipient-email" name="email">
                        <span id="add_email_msg"></span>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-number" class="col-form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="recipient-number" name="number">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="button" name="add_submit" value="save" class="btn btn-primary" id = "add_submit"></input>
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
                            <form  method="POST">
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