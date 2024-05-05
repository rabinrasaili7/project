<?php
include 'session-file.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: admin.php");
    exit(); // Stop further execution
}

// Check if the user is an admin
$userLoggedIn = $_SESSION['username'];
$user_details_query = mysqli_query($con, "SELECT * FROM admin WHERE adminname='$userLoggedIn'") or die(mysqli_error($con));
$user = mysqli_fetch_array($user_details_query);
if (!$user) {
    header("Location: admin.php");
    exit(); // Stop further execution
}

// Function to delete an event from the database
function deleteEvent($event_id, $con) {
    $event_id = (int)$event_id; // Sanitize input
    mysqli_query($con, "DELETE FROM events WHERE id = $event_id") or die(mysqli_error($con));
    // Redirect to the same page to avoid resubmission on page refresh
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Fetch list of approved events from the database
$approved_events_query = mysqli_query($con, "SELECT * FROM events WHERE approved = 1") or die(mysqli_error($con));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/fontawesome-free-5.15.1-web/css/all.css">
    <link rel="shortcut icon" href="images/favigon.jpg" type="image/x-icon">
    <title>Approved Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            color: white; /* Set text color to white */
        }

        h2 {
    text-align: center;
    color: white; /* Set heading color to white */
}
         table td {
        color: black;
    }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .delete-btn {
            background-color: #f44336;
            border: none;
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin-top: 5px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }
         body {
    background-image: url('https://cdn.wallpapersafari.com/14/13/SmgTFb.jpg'); /* URL of your background image */
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed; /* Fixed background */
    margin: 0; /* Remove default margin */
    padding: 0; /* Remove default padding */
}
        /* Your existing CSS styles */
        
        footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .back-btn {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
        }

        .back-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>List of Approved Events</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Event Date</th>
                <th>Action</th>
            </tr>
            <?php
            // Display each approved event with a delete button
            while ($event = mysqli_fetch_assoc($approved_events_query)) {
                echo "<tr>";
                echo "<td>{$event['title']}</td>";
                echo "<td>{$event['description']}</td>";
                echo "<td>{$event['event_date']}</td>";
                echo "<td><button class='delete-btn' onclick='deleteEvent({$event['id']})'>Delete Event</button></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <script>
        // Function to confirm event deletion
        function deleteEvent(eventId) {
            if (confirm("Are you sure you want to delete this event?")) {
                window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>?delete_event=" + eventId;
            }
        }
    </script>
</body>
</html>

<?php
// Handle event deletion when the delete button is clicked
if (isset($_GET['delete_event'])) {
    $event_id = $_GET['delete_event'];
    deleteEvent($event_id, $con);
}
?>
  <style>
 
    </style>
</head>
<body>

    <footer>
        <div class="container">
            <button class="back-btn" onclick="backToAdminPanel()">Back to Admin Panel</button>
        </div>
    </footer>
    <script>
        function backToAdminPanel() {
            window.location.href = "admin_home.php"; // Change the URL to the actual admin panel page
        }
    </script>