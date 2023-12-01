<?php
include 'conn.php';


session_start();
$user_id = $_SESSION['userid'];
$select_query = "SELECT * FROM contact WHERE userid = '$user_id' ORDER BY id DESC";
$result_set = mysqli_query($conn, $select_query);

// Check for errors in the query
if (!$result_set) {
    $error_message = "Error: " . mysqli_error($conn);
    echo json_encode(['success' => false, 'message' => $error_message]);
    exit;
}

// Fetch data and display in the table
$result_array = [];
if (mysqli_num_rows($result_set) > 0) {

    while ($row = mysqli_fetch_assoc($result_set)) {
        array_push($result_array, $row);
?>

        <tr>
            <td><?php echo $row['id']; ?> </td>
            <td><?php echo $row['name']; ?> </td>
            <td><?php echo $row['email']; ?> </td>
            <td><?php echo $row['number']; ?> </td>
            <td>
                <button class='btn btn-success edit-id' data-id='<?php echo $row['id']; ?>' data-name='<?php echo $row['name']; ?>' data-email='<?php echo $row['email']; ?>' data-number='<?php echo $row['number']; ?>'>Edit</button>
                <!-- <a href='#' class='btn btn-success' onclick='confirmDelete(<?php echo $row['id']; ?>)'>Delete</a> -->
                <button class='btn btn-success delete-id' data-id='<?php echo $row['id']; ?>'>Delete</button>
            </td>
        </tr>

<?php
    }
}

$htmlcontent = (['success' => true, 'data' => $result_array, 'message' => 'Data fetched successfully']);
echo $htmlcontent;
//    echo '<pre>';
//    print_r (['success' => true, 'data' => $result_array, 'message' => 'Data fetched successfully']);
//    exit();

?>