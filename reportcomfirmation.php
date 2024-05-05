<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reported</title>
    <?php
// Include your database connection file here
include 'session-file.php';

if(isset($_POST['report_event'])) {
    // Get event details from the form
    $event_id = $_POST['event_id'];
    
    // Retrieve event details from the events table
    $query = "SELECT event_date, description FROM events WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->bind_result($event_date, $description);
    $stmt->fetch();
    $stmt->close();
    
    // Insert the reported event details into the reported_events table
    $insert_query = "INSERT INTO reported_events (event_date, description) VALUES (?, ?)";
    $stmt = $con->prepare($insert_query);
    $stmt->bind_param("ss", $event_date, $description);
    $stmt->execute();
    $stmt->close();
    
    // Redirect the user to a confirmation page or back to the previous page
    header("Location: reportcomfirmation.php");
    exit();
}
?>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
            margin-top: 20px;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Event Reported</h1>
        <p>Thank you for reporting the event. We have received your report.</p>
        <p><a href="index.php">Go back to the homepage</a></p>
    </div>
</body>
</html>
