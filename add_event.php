<?php
include 'session-file.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Prepare and bind parameters
    $stmt = mysqli_prepare($con, "INSERT INTO events (title, description, event_date) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $title, $description, $date);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Event added successfully
        header("Location: Homepage.html");
        exit();
    } else {
        // Error occurred while adding event
        echo "Error: " . mysqli_error($con);
    }
}
?>
