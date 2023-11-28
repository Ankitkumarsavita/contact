<?php
// include 'conn.php';
// if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['check_Emailbtn']) && isset($_GET['email'])) {
//     // Get the email from the GET data
//     $email = $_GET['email'];

//     // Perform a database query to check if the email already exists
//     $check_email_query = "SELECT id FROM contact WHERE email = '$email'";
//     $check_email_result = $conn->query($check_email_query);

//     if ($check_email_result) {
//         if ($check_email_result->num_rows > 0) {
//             // Email already exists, include this information in the response
//             echo json_encode(['success' => false, 'message' => 'Email already exists for this user']);
//         } else {
//             // Email does not exist, return success
//             echo json_encode(['success' => true]);
//         }
//     } else {
//         echo json_encode(['success' => false, 'message' => 'Error executing the query']);
//     }
// }


?> 
