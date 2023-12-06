<?php
include 'conn.php';
session_start();
$emailcheck = "";
$passcheck = "";
$incpass = "";
$incemail = "";
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $emailcheck = "Email is required";
    }
    if (empty($password)) {
        $passcheck = "Password is required";
    }
    if (!empty($email) && !empty($password)) {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $data = mysqli_query($conn, $query);
        if ($data) {
            if (mysqli_num_rows($data) == 1) {

                $user = mysqli_fetch_assoc($data);
                $hashed_password =  $user['password'];
                if (password_verify($password, $hashed_password)) {
                    
                    $_SESSION['userid'] =  $user['id'];
                    $_SESSION['email'] = $email;
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['uploadfile'] = $user['image'];

                    echo "Login successful!";
                    header("Location: ./welcome.php");
                } else {
                    $incpass = "password does not match";
                }
            } else {
                $incemail = "User with that email does not exist.";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
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
    <title>index</title>
</head>

<body>
    <center>
        <!-- <h2>Login</h2>
        <form action="index.php" method="POST">
            <label for="email">email</label>
            <input type="text" name="email" placeholder="Enter the email"></input>
            <p><?php echo $emailcheck; ?></p>
            <p><?php echo $incemail; ?></p>
            <label for="password">password</label>
            <input type="password" name="password" placeholder="Enter the password"></input>
            <p><?php echo $passcheck; ?></p>
            <p><?php echo $incpass; ?></p>
            <input type="submit" name="submit"></input><br>
            <p>Don't have an account?<a href="signup.php">Signup</a></p>
        </form> -->

        <h2>User can Login here !</h2>
        <form action="index.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label"></label>
                <input type="text" name="email" class="form-control field-class" id="email" placeholder="Enter your Email">
                <p><?php echo $emailcheck; ?></p>
                <p><?php echo $incemail; ?></p>
                <div class="mb-3">
                    <label for="password" class="form-label"></label>
                    <input type="password" name="password" class="form-control field-class" id="password" placeholder="Enter your Password">
                    <p><?php echo $passcheck; ?></p>
                    <p><?php echo $incpass; ?></p>
                </div>
            <input type="submit" class="btn btn-primary" name="submit" value = "Login"></input>
        </form>
        <p>Don't have an account?<a href="signup.php">Signup</a></p>

    </center>


</body>

</html>