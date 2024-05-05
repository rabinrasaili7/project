<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Unapproved Events</title>
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
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .approve-btn {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .approve-btn:hover {
            background-color: #45a049;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to handle event approval
            $('.approve-btn').on('click', function() {
                var eventIds = [];
                // Get the IDs of selected events
                $('input[type=checkbox]:checked').each(function() {
                    eventIds.push($(this).val());
                });
                // Send AJAX request to approve_events_backend.php
                $.ajax({
                    type: 'POST',
                    url: 'approve_events_backend.php',
                    data: { eventIds: eventIds },
                    success: function(response) {
                        // Reload the list of unapproved events
                        $('.container').html(response);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Admin Panel - Unapproved Events</h1>
        <?php
        // Include database connection file
        include 'session-file.php';

        // Query to select unapproved events
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
        ?>
    </div>
</body>
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
</html>
