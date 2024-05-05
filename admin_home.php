<?php 
include 'session-file.php';



$userLoggedIn = $_SESSION['username'];
if(isset($_SESSION['username'])){
    $user_details_query = mysqli_query($con, "SELECT * FROM admin WHERE adminname='$userLoggedIn'")or die(mysqli_error($con));
    $user = mysqli_fetch_array($user_details_query);
}
else{
    header("Location: admin.php");

}

$user_detail_query = mysqli_query($con,"select * from admin where adminname='$userLoggedIn'");
$user_array = mysqli_fetch_array($user_detail_query);

//total users
$count_user_query = mysqli_query($con,"select * from users");
$count_user = mysqli_num_rows($count_user_query);

//total posts
$count_post_query = mysqli_query($con,"select * from posts");
$count_post = mysqli_num_rows($count_post_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/fontawesome-free-5.15.1-web/css/all.css">
    <link rel="shortcut icon" href="images/1.jpg" type="image/x-icon">
    <title>Admin Dashboard</title>

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

        header {
            background-color: #3f51b5;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .heading {
            background-color: #4CAF50;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .total {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
        }

        .total .t_user, .total .t_post {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            margin: 0 10px;
        }

        .main {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .main input[type="submit"], .main input[type="button"] {
            margin: 10px;
            padding: 10px 20px;
            border: none;
            background-color: #4CAF50;
            color: #fff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .main input[type="submit"]:hover, .main input[type="button"]:hover {
            background-color: #45a049;
        }

        .remove {
            margin-top: 20px;
        }

        iframe {
            width: 100%;
            border: 2px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Welcome to Admin Dashboard</h1>
        <a href="logout.php" style="color: #fff; text-decoration: none;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </header>

    <div class="container">
        <div class="heading">
            <b>Manage users, posts, messages, and comments with ease</b>
        </div>

        <div class="total">
            <div class="t_user">
                <i class="fas fa-user fa-3x" style="color: #4CAF50;"></i><br>
                <span style="font-size: 15px; font-family: system-ui;">Total Users</span><br>
                <span style="font-size: 20px;"><?php echo $count_user; ?></span>
                 <a href="Admin_Userlist.php" style="text-decoration: none; color: inherit;">
        <button class="check-btn" style="background-color: #4CAF50; color: white;">Check User List</button>
    </a>
            </div>
            
            <div class="t_post">
               
                <i class="fas fa-copy fa-3x" style="color: #4CAF50;"></i><br>
                <span style="font-size: 15px; font-family: system-ui;">Total Posts</span><br>
                <span style="font-size: 20px;"><?php echo $count_post; ?></span>
                 <a href="Admin_UserPosts.php" style="text-decoration: none; color: inherit;">
        <button class="check-btn" style="background-color: #4CAF50; color: white;">Check User's Post</button>  
            </div></a></div>

        </div>

        <div class="main">
            <div>
               <input type="submit" class="l_user" for="user" onClick='javascript:show()' value="Remove User">
                <div class="remove" id="remove" style='display:none;'>
                    <iframe src='remove_user.php'></iframe>
                </div>
            </div>
            
            <div>
                <input type="submit" class="l_post" for="Post" onClick='javascript:show2()' name="Post" value="Remove Post">
                <div class="remove" id="remove_post" style='display:none;'>
                    <iframe src='remove_post.php'></iframe>
                </div>
            </div>
            
            <div>
                <input type="submit" class="l_msg" for="Post" onClick='javascript:show3()' name="Post" value="Remove Message">
                <div class="remove" id="remove_msg" style='display:none;'>
                    <iframe src='remove_msg.php'></iframe>
                </div>
            </div>
            
            <div>
                <input type="submit" class="l_comment" for="Post" onClick='javascript:show4()' name="Post" value="Remove Comment">
                <div class="remove" id="remove_comment" style='display:none;'>
                    <iframe src='remove_comment.php'></iframe>
                </div>
            </div>

            <div>
                <a href="approve_event.php"><input type="button" class="a_event" for="Post" name="Post" value="Approve Event"></a>
            </div>

            <div>
                <a href="reporteditem.php"><input type="button" class="a_event" for="Post" name="Post" value="Reported Items"></a>
            </div>

            <div>
                <a href="admin_ListEvents.php"><input type="button" class="a_event" for="Post" name="Post" value="All Events"></a>
            </div>
             <div>
                <a href="Add_admin.php"><input type="button" class="a_event" for="Post" name="Post" value="Add Admin"></a>
            </div>
        </div>
    </div>

    <script>
        function show() {
            var element = document.getElementById("remove");
            if (element.style.display == "block") {
                element.style.display = "none";
            } else {
                element.style.display = "block";
            }
        }

        function show2() {
            var element = document.getElementById("remove_post");
            if (element.style.display == "block") {
                element.style.display = "none";
            } else {
                element.style.display = "block";
            }
        }

        function show3() {
            var element = document.getElementById("remove_msg");
            if (element.style.display == "block") {
                element.style.display = "none";
            } else {
                element.style.display = "block";
            }
        }

        function show4() {
            var element = document.getElementById("remove_comment");
            if (element.style.display == "block") {
                element.style.display = "none";
            } else {
                element.style.display = "block";
            }
        }
    </script>

</body>
</html>
