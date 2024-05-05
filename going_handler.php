<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['going'])) {
    // Include your database connection file
    include 'session-file.php';

    // Get the event ID from the form
    $event_id = $_POST['event_id'];




    // Increment the attendees count in the database for the corresponding event ID
    $update_query = "UPDATE events SET attendees = attendees + 1 WHERE id = '$event_id'";
    $result = mysqli_query($con, $update_query);

    if ($result) {
        // Attendees count incremented successfully
         header("Location: index.php");
    } else {
        // Error handling if the query fails
        echo "Error updating attendees count: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
}
?>
