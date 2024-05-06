<?php
$servername = "faure.cs.colostate.edu";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["modifyColorSelect"];
    $name = $_POST["modifyColorName"];
    $hex = $_POST["modifyColorHex"];

    $sql = "UPDATE colors SET name = ?, hex = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $hex, $id);

    if ($stmt->execute()) {
        echo "Color modified successfully.";
    } else {
        echo "Error modifying color: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>