<?php
$servername = "faure.cs.colostate.edu";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, hex FROM colors";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $colors = array();
    while ($row = $result->fetch_assoc()) {
        $colors[] = $row;
    }
    echo json_encode($colors);
} else {
    echo "0 results";
}

$conn->close();
?>