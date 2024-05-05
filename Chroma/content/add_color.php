<?php
// Establish database connection
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["colorName"];
    $hex = $_POST["colorHex"];

    $sql = "INSERT INTO colors (name, hex) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $hex);


    if ($stmt->execute()) {

        echo "Color added successfully.";
    } else {
        echo "Error adding color: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>