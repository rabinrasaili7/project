<?php
include 'session-file.php';

if(isset($_POST['name']) && isset($_POST['idea'])) {
    $name = $_POST['name'];
    $idea = $_POST['idea'];

    $query = "INSERT INTO forum (name, idea) VALUES ('$name', '$idea')";
    mysqli_query($con, $query) or die(mysqli_error($con));

    header("Location: forum.php"); // Redirect back to the forum page after submission
    exit();
} else {
    echo "Error: Please fill out all fields.";
}
?>
