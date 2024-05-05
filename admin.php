<!-- Admin.php^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->

<?php

    include 'session-file.php';

$error_array = array();

if(isset($_POST['login_btn'])){
    $Username = filter_var($_POST['log_user'], FILTER_SANITIZE_EMAIL);
    $_SESSION['log_user'] = $Username;
    $password = $_POST['log_password'];

    // Fetch hashed password from the database for the provided username
    $check_database_query = mysqli_query($con, "SELECT password FROM admin WHERE adminname='$Username'") or die(mysqli_error($con));

    if(mysqli_num_rows($check_database_query) == 1) {
        $row = mysqli_fetch_array($check_database_query);
        $hashed_password = $row['password'];

        // Verify the provided password with the hashed password
        if(password_verify($password, $hashed_password)) {
            // Password is correct, proceed with login

            // Fetch all admin data
            $check_login_query = mysqli_query($con, "SELECT * FROM admin WHERE adminname='$Username'") or die(mysqli_error($con));

            // Check if there is exactly one result
            if(mysqli_num_rows($check_login_query) == 1){
                $row = mysqli_fetch_array($check_login_query);
                $username = $row['adminname'];

                $_SESSION['username'] = $username;
                header("Location: admin_home.php");
                exit();
            } else {
                // More than one result found, handle the error
                array_push($error_array, "Multiple admin records found");
            }
        } else {
            // Password is incorrect
            array_push($error_array, "Username or Password was incorrect");
        }
    } else {
        // Username not found in the database
        array_push($error_array, "Username not found");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Your code -->
</head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/register.css">
    <link rel="stylesheet" href="assets/fontawesome-free-5.15.1-web/css/all.css">
    <link rel="shortcut icon" href="images/1.jpg" type="image/x-icon">
    <title>Welcome Admin</title>

    <style>
      body {
    background-image: url('https://cdn.wallpapersafari.com/14/13/SmgTFb.jpg'); /* URL of your background image */
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed; /* Fixed background */
    margin: 0; /* Remove default margin */
    padding: 0; /* Remove default padding */
}
      
    .alert{
        color: red;
        margin: auto;
    }
    .from_wreper{
        margin-left: 325px;
        margin-right: auto;
    }
    .upper_body{
        color: white;
        font-size: 30px;
        text-align: center;
        margin-top: 70px;
        margin-bottom: 10px;
    }
    
    </style>

</head>
<body>


    <div class="upper_body">
        Hello ADMIN Please Login to Proceed....
    </div>
    <div class="from_wreper">
        <div class="signin-form">
            <div class="form-top-left">
                <h3 style="padding-top:10px;">Login to our site <i class="fas fa-user-shield" style="float: right;"></i></h3>
                <p style="margin-top:-20px; padding-bottom:10px;">Enter Username and password to log on:</p>
            </div>
           
            <div class="form-bottom">
                <form action="admin.php" method="POST" class="login-form">
                    <!-- User Name -->
                        <label for="form-Username">User Name </label>
                        <input type="text" name="log_user" placeholder="User Name " value="<?php if(isset($SESSION['log_user'])) {
                            echo $_SESSION['log_user'];
                        } ?>" required> <br>
                                            
                    <!-- Password -->
                        <label for="form-password">Password</label>
                        <input type="password" name="log_password" placeholder="Password" required>
                       
 <Br>
                



                    <?php if(in_array("Username or Password was incorrect", $error_array)) echo "<p class='alert'>Username or Password was incorrect</p>"; ?>
                    <button type="submit" style="margin-bottom:20px" name="login_btn">Sign in!</button>  
                </form>     
            </div>
        </div>
    </div>
</body>
</html>
        