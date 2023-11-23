<?php
include 'conn.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the ID from the GET data
    $id = $_GET['id'];
    // Perform a database query to fetch data based on the ID
    $query = "SELECT name, email, number FROM contact WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id); // 'i' indicates integer type for the ID
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query was successful
    if ($result) {
        $data = $result->fetch_assoc();
        if ($data !== null) {
            // Return the data as JSON
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Data not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error executing the query']);
    }
} else {
    // If the request method is not GET, return an error
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}




// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Get the ID from the POST data
//     $id = $_POST['id'];

//     // Perform a database query to fetch data based on the ID
//     // Replace the following line with your actual database query
//     $query = "SELECT name, email, number FROM contact WHERE id = :id";
//     $data = mysqli_query($conn, $query);
//     $result = mysqli_fetch_assoc($data);
//     // Execute the query, fetch data, and store it in $result

//     // Return the data as JSON
//     echo json_encode(['success' => true, 'data' => $result]);
// } else {
//     // If the request method is not POST, return an error
//     echo json_encode(['success' => false, 'message' => 'Invalid request method']);
// }
?>