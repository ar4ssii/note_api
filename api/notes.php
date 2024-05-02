<?php
include '../config/db.php';
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, PUT, DELETE, POST');
date_default_timezone_set('Asia/Manila');


$server_method = $_SERVER['REQUEST_METHOD'];

if ($server_method == 'GET') {

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
} elseif ($server_method == 'POST') {
    // Assign values from the POST request to variables
    $title = $_POST['title'];
    $content = $_POST['content'];
    $dateTime = date('Y-m-d H:i:s');

    // Prepare the SQL statement using a prepared statement to prevent SQL injection
    $sql = $conn->prepare("INSERT INTO notes (title, content, dateTime) VALUES (?, ?, ?)");

    // Bind parameters and execute the statement
    $sql->bind_param("sss", $title, $content, $dateTime);

    if ($sql->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql->error;
    }

    // Close the database connection
    $conn->close();
} elseif ($server_method == 'PUT') {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    // echo json_encode($data);
    $title = $data["title"];
    $content = $data["content"];
    $date = date('Y-m-d H:i:s');
    $id = $data["id"];

    $sql = "UPDATE notes SET title='$title',content ='$content', dateTime ='$date' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} elseif ($server_method == 'DELETE') {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    $id = $data["id"];

    $sql = "DELETE FROM notes WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}
?>
