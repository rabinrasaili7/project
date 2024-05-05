<?php
// Include database connection file
include 'session-file.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if event IDs are provided
    if (isset($_POST['eventIds']) && is_array($_POST['eventIds'])) {
        // Sanitize the input
        $eventIds = array_map('intval', $_POST['eventIds']);

        // Update the database to approve the selected events
        $approve_query = "UPDATE events SET approved = 1 WHERE id IN (" . implode(',', $eventIds) . ")";
        $result = mysqli_query($con, $approve_query);

        if ($result) {
            // Query to select unapproved events after approval
            $select_unapproved_query = "SELECT * FROM events WHERE approved = 0";
            $result = mysqli_query($con, $select_unapproved_query);

            // Check if there are any unapproved events
            if (mysqli_num_rows($result) > 0) {
                // Display unapproved events in a table
                echo "<table>";
                echo "<tr><th>Title</th><th>Description</th><th>Approve</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td><input type='checkbox' value='" . $row['id'] . "'></td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<a href='javascript:void(0);' class='approve-btn'>Approve Events</a>";
            } else {
                echo "<p>No unapproved events found.</p>";
            }
        } else {
            echo "Error updating database.";
        }
    } else {
        echo "Event IDs not provided.";
    }
} else {
    echo "Invalid request.";
}
?>
