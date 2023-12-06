<?php
include 'conn.php';
/*take empty string variable print into html page */
$nameError = "";
$emailError = "";
$passError = "";
/*this is validation part */

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $folder = "./images/" . $_FILES["uploadfile"]["name"];

    $name_pattern = "/^([a-zA-Z' ]+)$/";
    $email_pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    $pass_pattern = '/^\d{6,}$/';
    if (empty($name)) {
        $nameError = "Name is required";
        // exit($nameError);
    }
    if (!preg_match($name_pattern, $name) && !empty($name)) {
        $nameError = "Invalid name format. Only letters and spaces allowed";
    }
    if (empty($email)) {

        $emailError = "Email is required";
    } elseif (!preg_match($email_pattern, $email) && !empty($email)) {
        $emailError = "Invalid email format";
    }
    if (empty($password)) {
        $passError = "Password is required";
    } elseif (!preg_match($pass_pattern, $password) && !empty($password)) {
        $passError = "password must be 6 charecter and use special charecter";
    }


    $original_filename = $_FILES["uploadfile"]["name"];
    $file_extension = pathinfo($original_filename, PATHINFO_EXTENSION);
    $filename = 'user_' . time() . "." . $file_extension;
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./images/" . $filename;
    if (move_uploaded_file($tempname, $folder)) {

        // echo "File uploaded successfully!";
    } else {
        // echo "Error uploading the file.";
    }
    /*if this condition is not empty then it will insert data into database*/
    if (!empty($name) && !empty($email) && !empty($password) && !empty($filename) && empty($nameError) && empty($emailError) && empty($passError)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = 'INSERT INTO users(name, email, password,image) VALUES ("' . $name . '", "' . $email . '", "' . $hashed_password . '","' . $filename . '")';
        $result = mysqli_query($conn, $query);
        if ($result) {
            /*this function used to redirect to another page*/

            header("Location: ./index.php");
        } else {
            $signup_error = "Error: " . mysqli_error($conn);
        }
    }
}

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
    <title>signup</title>
</head>

<body>
    <center>
        <!-- <h2>Sign Up</h2>

        <form action="signup.php" method="POST" enctype='multipart/form-data'>

            <label for="name">Name:</label>
            <input type="text" name="name" placeholder="Enter your name"><br>
            <p><?php echo $nameError; ?></p>
            <label for="email">Email:</label>
            <input type="text" name="email" placeholder="Enter your email"><br>
            <p><?php echo $emailError; ?></p>
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Enter your password"><br>
            <p><?php echo $passError; ?></p>
            <div class="mb-3">
                <label for="formFile" class="form-label"></label>
                <input class="form-control" type="file" name="uploadfile" id="formFile" accept=".jpg, .jpeg, .png " value="" style="width: 300px; color: black; font-size: 14px;">
            </div>
            <input type="submit" name="submit" value="Sign Up"></input>
        </form>
        <p>Already have an account?<a href="index.php">Login</a></p> -->

        <h2>Signup here !</h2>
        <form action="signup.php" method="POST" enctype='multipart/form-data'>
            <div class="mb-3">
                <label for="name" class="form-label "></label>
                <input type="text" name="name" class="form-control field" id="exampleInputEmail1" placeholder="Enter your Name">
                <p><?php echo $nameError; ?></p>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"></label>
                <input type="text" name="email" class="form-control field" id="email" placeholder="Enter your Email">
                <p><?php echo $emailError; ?></p>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"></label>
                <input type="password" name="password" class="form-control field" id="password" placeholder="Enter your Password">
                <p><?php echo $passError; ?></p>
            </div>
            <div class="mb-3">
                <!-- <label for="formFile" class="form-label"></label>
                <input class="form-control" type="file" name="uploadfile" id="formFile" accept=".jpg, .jpeg, .png " value="" style="width: 500px; color: black; font-size: 14px;"> -->
                <div class="mb-3">
  <label for="formFile" class="form-label"></label>
  <input class="form-control" type="file" id="formFileMultiple" name="uploadfile" id="formFile" accept=".jpg, .jpeg, .png " style="width: 500px; color: black; font-size: 14px;"multiple >
</div>
            </div>
            </div>
            <input type="submit" class="btn btn-primary" name="submit" value="Signup"></input>
        </form>
        <p>Already have an account?<a href="index.php">Login</a></p>
    </center>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="common.js"></script>
</body>

</html>