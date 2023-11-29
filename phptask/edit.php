<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the ID from the GET data
    $id = $_GET['id'];

    // Perform a database query to fetch data based on the ID
    $query = "SELECT * FROM contact WHERE id = $id";
    $result = $conn->query($query);

    // Check if the query was successful
    if ($result) {
        $data = $result->fetch_assoc();
       // Return the data as JSON
                if($data){
                    echo json_encode(['success' => true, 'data' => $data]);
            }
        else {
            echo json_encode(['success' => false, 'message' => 'Data not found']);
        }
    }
}
/*edit popup */
if(isset($_POST['op']) && $_POST['op'] =="update"){
$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$number = $_POST['number'];

    $check_email_query = "SELECT * FROM contact WHERE email = '$email'";
    $check_email_result = mysqli_query($conn, $check_email_query);
    if ($check_email_result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already exists ']);
    } else {
        
        $sql = "UPDATE contact SET name='$name', email='$email', number='$number' WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        echo json_encode(['success' => true, 'message' => 'record updated']);
    }
    
}



?>

