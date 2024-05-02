<?php
require_once "config/db.php"; // Add a semicolon here

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = "?"; 

$sql = "DELETE FROM notes WHERE id = '$id'"; 

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
