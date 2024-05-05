<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
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
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: white;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            color: green; /* Set text color to white */
        }


        th, td {
            padding: 12px 15px;
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
    </style>
</head>
<body>
    <?php
    // Establish database connection
    include 'session-file.php';

    // Query to select all users
    $query = "SELECT * FROM users";
    $result = mysqli_query($con, $query);

    // Check if query executed successfully
    if ($result) {
        // Fetch users data and display them in a table
        echo "<h2>List of Users</h2>";
        echo "<table>";
        echo "<tr><th>User ID</th><th>First Name</th><th>Last Name</th><th>Username</th><th>Email</th><th>DOB</th><th>Gender</th><th>Signup Date</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['first_name']}</td>";
            echo "<td>{$row['last_name']}</td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['dob']}</td>";
            echo "<td>{$row['gender']}</td>";
            echo "<td>{$row['signup_date']}</td>";
          
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    // Close database connection
    mysqli_close($con);
    ?>
</body>
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
