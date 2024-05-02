<?php
require_once "config/db.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM notes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Array to store notes data
    $notes = array();

    // Fetch data and store in array
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }

    // Output JSON
    header('Content-Type: application/json');
    echo json_encode($notes);
} else {
    echo json_encode(array());
}

// Close connection
$conn->close();
?>