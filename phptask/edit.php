<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the ID from the GET data
    $id = $_GET['id'];

    // Perform a database query to fetch data based on the ID
    $query = "SELECT * FROM contact WHERE id = $id";
    $result = $conn->query($query);
    if ($result) {
        $data = $result->fetch_assoc();
        if ($data) {
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Data not found']);
        }
    }
}
/*edit popup */
if (isset($_POST['op']) && $_POST['op'] == "update") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];

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

            $sql = "UPDATE contact SET name='$name', email='$email', number='$number' WHERE id=$id";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Record updated']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error updating record']);
            }
        }
    }
}
