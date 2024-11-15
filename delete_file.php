<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = intval($_GET['id']);
$sql = "SELECT filename FROM files WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $filePath = 'uploads/' . $row['filename'];

    if (unlink($filePath)) {
        $sql = "DELETE FROM files WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File deletion failed.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'File not found.']);
}

$conn->close();
?>
