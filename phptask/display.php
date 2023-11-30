<?php
include 'conn.php';
$user_id = $_SESSION['userid'];
$select_query = "SELECT * FROM contact WHERE userid = '$user_id'ORDER BY id DESC";
$result_set = mysqli_query($conn, $select_query);
// Check for errors in the query
if (!$result_set) {
    $error_message = "Error: " . mysqli_error($conn);
}

// Fetch data and display in the table
$data_rows = "";
while ($row = mysqli_fetch_assoc($result_set)) {
    $data_rows .= "<tr>";
    $data_rows .= "<th scope='row'>" . $row['id'] . "</th>";
    $data_rows .= "<td>" . $row['name'] . "</td>";
    $data_rows .= "<td>" . $row['email'] . "</td>";
    $data_rows .= "<td>" . $row['number'] . "</td>";
    $data_rows .= "<td>";
    $data_rows .= "<button class='btn btn-success edit-id' data-id='" . $row['id'] . "' data-name='" . $row['name'] . "' data-email='" . $row['email'] . "' data-number='" . $row['number'] . "'>Edit</button> ";
    // $data_rows .= "<a href='#' class='btn btn-success' onclick='confirmDelete(" . $row['id'] . ")'>Delete</a> ";
    $data_rows .= "<button class='btn btn-success delete-id' data-id='" . $row['id'] . "'>Delete</button> ";
    $data_rows .= "</tr>";
}
?>