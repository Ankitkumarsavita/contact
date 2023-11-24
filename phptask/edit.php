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
}
?>