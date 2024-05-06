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
    $id = $_POST["deleteColorSelect"];

    $count_query = "SELECT COUNT(*) AS count FROM colors";
    $count_result = $conn->query($count_query);
    $row = $count_result->fetch_assoc();
    $count = $row["count"];

    if ($count <= 2) {
        echo "Cannot delete color. There must be at least 2 colors in the table.";
    } else {
        $sql = "DELETE FROM colors WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Color deleted successfully.";
        } else {
            echo "Error deleting color: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>