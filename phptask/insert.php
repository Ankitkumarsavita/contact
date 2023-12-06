<?php
include 'conn.php';
if (isset($_POST['op'])) {
    session_start();
    $userid = $_SESSION['userid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];

    // echo "<pre>";
    // print_r($number);
    // exit();
    $error_messages = array();
    $name_pattern = "/^([a-zA-Z' ]+)$/";
    $email_pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    $number_pattern = '/^[0-9]{10}+$/';

    if (empty($name)) {

        $error_messages[] = ['field' => 'name', 'error' => 'Name is required'];
    } elseif (!preg_match($name_pattern, $name) && !empty($name)) {

        $error_messages[] = ['field' => 'name', 'error' => 'Invalid name'];
    }
    if (empty($email)) {

        $error_messages[] = ['field' => 'email', 'error' => 'Email is required'];
    } elseif (!preg_match($email_pattern, $email) && !empty($email)) {

        $error_messages[] = ['field' => 'email', 'error' => 'Invalid email'];
    }
}
if (empty($number)) {
    $error_messages[] = ['field' => 'number', 'error' => 'Number is required'];
} elseif (!preg_match($number_pattern, $number) && !empty($number)) {

    $error_messages[] = ['field' => 'number', 'error' => 'Invalid number'];
}
if (count($error_messages) > 0) {
    echo json_encode(['success' => false, 'messages' => $error_messages]);
} else {

    $check_email_query = "SELECT * FROM contact WHERE email = '$email'";
    $check_email_result = mysqli_query($conn, $check_email_query);
    if ($check_email_result->num_rows > 0) {
        $error_messages[] = ['field' => 'email', 'error' => 'Email already exist'];
        echo json_encode(['success' => false, 'messages' => $error_messages]);
    } else {
        $sql  = 'INSERT INTO contact(userid, name, email, number) VALUES ("' . $userid . '","' . $name . '", "' . $email . '", "' . $number . '")';
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Record updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating record']);
        }
    }
}
