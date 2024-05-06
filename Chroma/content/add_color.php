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
    $name = $_POST["colorName"];
    $hex = $_POST["colorHex"];

    //check for color
    $check_query = "SELECT id FROM colors WHERE name = ? AND hex = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("ss", $name, $hex);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "Color already exists.";
    } else {
        $insert_query = "INSERT INTO colors (name, hex) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("ss", $name, $hex);

        if ($insert_stmt->execute()) {
            echo "Color added successfully.";
        } else {
            echo "Error adding color: " . $conn->error;
        }

        if (isset($insert_stmt)) {
            $insert_stmt->close();
        }
    }

    $check_stmt->close();
    $conn->close();
}
?>