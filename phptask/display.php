<?php
include 'conn.php';
session_start();
$user_id = $_SESSION['userid'];
// echo"<pre>"; 
// print_r($user_id);
// exit();
$select_query = "SELECT * FROM contact WHERE userid = '$user_id' ORDER BY id DESC";

$result_set = mysqli_query($conn, $select_query);

// Check for errors in the query
if (!$result_set) {
    $error_message = "Error: " . mysqli_error($conn);
    echo json_encode(['success' => false, 'message' => $error_message]);
    exit;
}
// Fetch data and display in the table
$return_arr = array();
if (mysqli_num_rows($result_set) > 0) {

    while ($row = mysqli_fetch_array($result_set)) {
        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $number = $row['number'];

        $return_arr[] = array(
            "id" => $id,
            "name" => $name,
            "email" => $email,
            "number" => $number
        );
    }
}
echo json_encode($return_arr);
// echo json_encode( ['success' => true, 'data' => $return_arr, 'message' => 'Data fetched successfully']);
 ?>

