<?php
include 'session-file.php';

// Function to fetch forum posts
function getForumPosts($con) {
    $get_forum_posts_query = "SELECT * FROM forum";
    $forum_result = mysqli_query($con, $get_forum_posts_query);
    
    while ($row = mysqli_fetch_assoc($forum_result)) {
        echo "<div class='forum-post'>";
        echo "<div class='post-header'>";
        
        echo "<p><strong>Date:</strong> " . ($row['forum_date'] ?? 'Unknown') . "</p>";
        echo "</div>";
        echo "<div class='post-content'>";
        echo "<p><strong>Posted by:</strong> " . ($row['forum_by'] ?? 'Unknown') . "</p>";echo "<p><strong>Idea:</strong><br>" . ($row['idea'] ?? 'No idea content') . "</p>";
        echo "</div>";
        
        // Form to reply to this forum post
        echo "<div class='reply-form'>";
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
        echo "<input type='hidden' name='forum_id' value='" . ($row['forum_id'] ?? '') . "'>";
        echo "<textarea id='reply_text' name='reply_text' placeholder='Your Reply' required></textarea><br>";
        echo "<input type='text' id='reply_by' name='reply_by' placeholder='Your Name' required><br>";
        echo "<input type='submit' name='reply_submit' value='Reply'>";
        echo "</form>";
        echo "</div>";
        
        // Display replies for this forum post
        echo "<div class='replies'>";
        echo "<h4>Replies:</h4>";
        $forum_id = $row['forum_id'];
        $get_replies_query = "SELECT * FROM forum_replies WHERE forum_id = $forum_id";
        $replies_result = mysqli_query($con, $get_replies_query);
        
        if (mysqli_num_rows($replies_result) > 0) {
            while ($reply_row = mysqli_fetch_assoc($replies_result)) {
                echo "<div class='reply'>";
                echo "<p><strong>Reply by:</strong> " . ($reply_row['reply_by'] ?? 'Unknown') . "</p>";
                echo "<p><strong>Date:</strong> " . ($reply_row['reply_date'] ?? 'Unknown') . "</p>";
                echo "<p><strong>Reply:</strong><br>" . ($reply_row['reply_text'] ?? 'No reply content') . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No replies yet.</p>";
        }
        echo "</div>"; // End of replies container
        echo "</div>"; // End of forum post
    }
}
// Function to insert new forum post into database
function insertForumPost($con) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['forum_submit'])) {
        $idea = $_POST['idea'];
        $posted_by = $_POST['posted_by'];
        
        // Insert the forum post into the database
        $insert_forum_post_query = "INSERT INTO forum (idea, forum_by, forum_date) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($con, $insert_forum_post_query);
        mysqli_stmt_bind_param($stmt, "ss", $idea, $posted_by);
        mysqli_stmt_execute($stmt);
    }
}



// Function to insert reply into database
function insertReply($con) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reply_submit'])) {
        // Retrieve form data
        $forum_id = $_POST['forum_id'];
        $reply_text = $_POST['reply_text'];
        $reply_by = $_POST['reply_by'];

        // Prepare the insert query
        $insert_reply_query = "INSERT INTO forum_replies (forum_id, reply_text, reply_by, reply_date) VALUES (?, ?, ?, NOW())";

        // Prepare and execute the statement
        $stmt = mysqli_prepare($con, $insert_reply_query);
        mysqli_stmt_bind_param($stmt, "iss", $forum_id, $reply_text, $reply_by);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            echo "Reply inserted successfully.";
        } else {
            // Print detailed error message for debugging
            echo "Error: " . mysqli_error($con);
            echo "<br>Query: " . $insert_reply_query;
            echo "<br>Forum ID: " . $forum_id;
            echo "<br>Reply Text: " . $reply_text;
            echo "<br>Reply By: " . $reply_by;
        }
    }
}
// Call function to insert new forum post
insertForumPost($con);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Board</title>
     <div class="back-home">
        <a href="homepage.html">Back to Home</a>
    </div>
   <style>
    body {
    background-image: url('https://t3.ftcdn.net/jpg/03/55/60/70/360_F_355607062_zYMS8jaz4SfoykpWz5oViRVKL32IabTP.jpg'); /* URL of your background image */
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
            padding: 20px;
        }
        .forum-post {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .post-header {
            margin-bottom: 10px;
        }
        .post-content {
            margin-bottom: 15px;
        }
        .reply-form {
            margin-bottom: 15px;
        }
        .reply-form textarea, .reply-form input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .replies {
            padding-left: 20px;
            border-left: 2px solid #ccc;
        }
        .reply {
            margin-bottom: 10px;
        }
        .reply p {
            margin: 0;
        }
        h2, h3 {
            color: #333;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Discussion Board</h2>

    <!-- Form to submit a new forum post -->
    <div class="forum-post">
        <h3>Submit a New Forum Post</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <textarea id="idea" name="idea" placeholder="Your Forum Idea" required></textarea><br>
            <input type="text" id="posted_by" name="posted_by" placeholder="Your Name" required><br>
            <input type="submit" name="forum_submit" value="Submit">
        </form>
    </div>

    <!-- Display existing forum posts -->
    <h3>Forum Posts:</h3>
    <?php
    getForumPosts($con); // Call function to fetch and display forum posts
    ?>



</body>
</html>
