<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
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

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .success-message {
            margin-top: 20px;
            text-align: center;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <?php
    include 'session-file.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect admin details from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert admin into the admin table
        $admin_insert_query = "INSERT INTO admin (adminname, password) VALUES ('$username', '$hashed_password')";
        $admin_insert_result = mysqli_query($con, $admin_insert_query);

        if ($admin_insert_result) {
            // Insert corresponding details into the user table
            $user_insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$username', '$hashed_password')";
            $user_insert_result = mysqli_query($con, $user_insert_query);

            if ($user_insert_result) {
                $success_message = "New admin '$username' has been successfully added to the system.";
            } else {
                $error_message = "Error inserting admin into user table: " . mysqli_error($con);
            }
        } else {
            $error_message = "Error registering admin: " . mysqli_error($con);
        }
    }
    ?>
    <h2>Admin Registration</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <!-- Add more fields as needed (e.g., first name, last name, email, etc.) -->

        <input type="submit" value="Register">
        
    </form>

    <?php if (isset($success_message)) { ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php } ?>

    <?php if (isset($error_message)) { ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php } ?>
</body>

</html>
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