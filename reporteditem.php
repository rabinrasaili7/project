<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Reported Events</title>
    <style>
    body {
    background-image: url('https://cdn.wallpapersafari.com/14/13/SmgTFb.jpg'); /* URL of your background image */
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed; /* Fixed background */
    margin: 0; /* Remove default margin */
    padding: 0; /* Remove default padding */
}
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: white;
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        form {
            display: inline;
        }

        input[type="submit"] {
            background-color: #ff6347;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        input[type="submit"]:hover {
            background-color: #ff4837;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-bottom: 20px;
        }

        .footer a {
            text-decoration: none;
            color: #333;
            border-bottom: 1px solid #333;
        }

        .footer a:hover {
            color: #ff6347;
            border-bottom: 1px solid #ff6347;
        }
    </style>
</head>

<body>
    <h1>Reported Events</h1>
    <?php
    include 'session-file.php';

   

if (isset($_POST['delete_event'])) {
    $event_id = $_POST['event_id'];

    // Delete event from reported_events table
    $delete_reported_event_query = "DELETE FROM reported_events WHERE id = $event_id";
    $delete_reported_event_result = mysqli_query($con, $delete_reported_event_query);

    if (!$delete_reported_event_result) {
        echo "Error deleting event from reported_events table: " . mysqli_error($con);
    } else {
        if (mysqli_affected_rows($con) > 0) {
            echo "Event deleted successfully from Event Report Databse. Please remove event from Main admin  Panel to remove premanently .";
        } else {
            echo "No event with the specified ID found in reported_events table.";
        }
    }
}


    // Fetch reported events
    $select_reported_events_query = "SELECT * FROM reported_events";
    $reported_events_result = mysqli_query($con, $select_reported_events_query);

    if (mysqli_num_rows($reported_events_result) > 0) {
        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Event ID</th>";
        echo "<th>Event Date</th>";
        echo "<th>Description</th>";
        echo "<th>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

       while ($row = mysqli_fetch_assoc($reported_events_result)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['event_date'] . "</td>";
    echo "<td>" . $row['description'] . "</td>";
    echo "<td>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='event_id' value='" . $row['id'] . "'>";
      echo "<input type='submit' name='delete_event' value='Delete'>";
    echo "</form>";
    echo "</td>";
    echo "</tr>";
}

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No reported events found.</p>";
    }
    ?>
      <style>
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
</body>

</html>
