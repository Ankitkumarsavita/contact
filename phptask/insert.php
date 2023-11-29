<?php
include 'conn.php';
if(isset($_POST['op'])){
    session_start();
    $userid = $_SESSION['userid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    
    // echo "<pre>";
    // print_r($number);
    // exit();
 
    $check_email_query = "SELECT * FROM contact WHERE email = '$email'";
    $check_email_result = mysqli_query($conn, $check_email_query);
    if ($check_email_result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already exists ']);
    } else {
        $sql  = 'INSERT INTO contact(userid, name, email, number) VALUES ("'.$userid.'","' . $name . '", "' . $email . '", "' .$number. '")';
        $result = mysqli_query($conn, $sql);

        echo json_encode(['success' => true, 'message' => 'record updated']);
   
       }
   
    }
?>