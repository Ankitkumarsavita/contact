<?php
include 'conn.php';
if(isset($_POST['delete_submit'])){

    $id = $_POST['id'];
    // echo"<pre>";
    // print_r( $id );
    // exit();
    $delete_query = "DELETE FROM contact WHERE id = $id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo json_encode(['success' => true, 'message' => 'Record deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting record']);
    }
    mysqli_close($conn);
}

?>    