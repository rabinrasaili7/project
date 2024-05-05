<?php
// Establish database connection
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch approved events from database
$sql = "SELECT * FROM events WHERE approved = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Title: " . $row["title"]. " - Description: " . $row["description"]. " - Event Date: " . $row["event_date"]. "<br>";
    }
} else {
    echo "No approved events found.";
}

$conn->close();
?>
