<?php
include 'header.php';

if (isset($_POST['post'])) {
    $uploadOk = 1;
    $imageName = $_FILES['fileToUpload']['name'];
    $errorMessage = "";

    if ($imageName != "") {
        $targetDir = "assets/images/posts/";
        $imageName = $targetDir . uniqid() . basename($imageName);
        $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

        if ($uploadOk) {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) {
                // Image Upload Okay
                $errorMessage = "uploaded";
            } else {
                $uploadOk = 0;
                $errorMessage = "fail to upload";
            }
        }
    }

    if ($uploadOk) {
        $post = new Post($con, $userLoggedIn);
        $post->submitPost($_POST['post_text'], $imageName);
    } else {
        echo "<div style='text-align: center;' class='alert alert-danger'> $errorMessage </div>";
    }
}

$user_detail_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
$user_array = mysqli_fetch_array($user_detail_query);
$num_friends = (substr_count($user_array['friend_array'], ",")) - 1;
?>

<div class="index-wrapper">
    <div class="info-box">
        <div class="info-inner">
            <div class="info-in-head">
                <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['cover_pic']; ?>"></a>
            </div>
            <div class="info-in-body">
                <div class="in-b-box">
                    <div class="in-b-img">
                        <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic']; ?>"></a>
                    </div>
                </div>
                <div class="info-body-name">
                    <div class="in-b-name">
                        <div><a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name'] . " " . $user['last_name']; ?></a></div>
                        <span><small><a href="<?php echo $userLoggedIn; ?>"><?php echo "@" . $user['username'] ?></a></small></span>
                    </div>
                </div>
            </div>
            <div class="info-in-footer">
                <div class="number-wrapper">
                    <div class="num-box">
                        <div class="num-head">
                            POSTS
                        </div>
                        <div class="num-body">
                            <?php echo $user['num_posts']; ?>
                        </div>
                    </div>
                    <div class="num-box">
                        <div class="num-head">
                            LIKES
                        </div>
                        <div class="num-body">
                            <span class="count-likes">
                                <?php echo $user['num_likes']; ?>
                            </span>
                        </div>
                    </div>
                    <div class="num-box">
                        <div class="num-head">
                            Friends
                        </div>
                        <div class="num-body">
                            <?php echo $num_friends ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="post-wrap">
        <div class="post-inner">
            <div class="post-h-left">
                <div class="post-h-img">
                    <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic'] ?>"></a>
                </div>
            </div>

            <div class="post-body">
                <form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
                    <textarea class="status" name="post_text" id="post_text" placeholder="Type Something here!" rows="4" cols="50"></textarea>
                    <div class="hash-box">
                        <ul></ul>
                    </div>
            </div>
            <div class="post-footer">
                <div class="p-fo-left">
                    <ul>
                        <input type="file" name="fileToUpload" id="fileToUpload" />
                        <label for="fileToUpload"><img src="assets/images/camera.png" alt="" height="30px"></i></label>
                        <span class="tweet-error"></span>
                        <input id="sub-btn" type="submit" name="post" value="SHARE">
                    </ul>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="show_post">
        <?php
        $post = new Post($con, $userLoggedIn);
        $post->indexPosts();
        ?>
        <h1>Upcoming Events</h1>
        <style>
            .event {
                border: 1px solid #ccc;
                padding: 10px;
                margin-bottom: 20px;
                border-radius: 5px;
            }

            .like-btn,
            .comment-btn {
                background-color: #3b5998;
                color: #fff;
                border: none;
                padding: 5px 10px;
                border-radius: 3px;
                cursor: pointer;
                margin-right: 10px;
            }

            .comment-form input[type="text"] {
                width: 70%;
                padding: 5px;
                border-radius: 3px;
                border: 1px solid #ccc;
            }

            .comment-form button[type="submit"] {
                background-color: #3b5998;
                color: #fff;
                border: none;
                padding: 5px 10px;
                border-radius: 3px;
                cursor: pointer;
            }

            .comments {
                margin-top: 10px;
            }

            .comment {
                margin-top: 5px;
            }

            .comment img {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                margin-right: 5px;


            }
            .button-container {
    display: inline-flex; /* Display buttons in the same line */
    gap: 10px; /* Adjust the gap between buttons as needed */
}

.button-container form {
    margin: 0; /* Remove default form margin */
}

.button-container button {
    background-color: #3b5998; /* Blue color */
    color: #fff; /* White text color */
    border: none; /* Remove button border */
    padding: 5px 10px; /* Adjust button padding */
    border-radius: 3px; /* Add button border radius */
    cursor: pointer; /* Add pointer cursor */
    margin-right: 10px; /* Add margin between buttons */
}

.button-container button:hover {
    background-color: #274682; /* Darker shade of blue on hover */
}
.custom-button {
        background-color: #3b5998;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
    }

        </style>
        <?php

        // Function to handle comment submission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id']) && isset($_POST['comment_text'])) {
            // Sanitize input data to prevent SQL injection
            $event_id = mysqli_real_escape_string($con, $_POST['event_id']);
            $comment_text = mysqli_real_escape_string($con, $_POST['comment_text']);
            $posted_by = $_SESSION['username'];

            // Insert comment into the database
            $insert_query = "INSERT INTO comments (post_id, post_body, posted_by) VALUES ('$event_id', '$comment_text', '$posted_by')";
            $result = mysqli_query($con, $insert_query);

            if (!$result) {
                die("Error adding comment: " . mysqli_error($con));
            }
        }

        // Function to handle like submission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id']) && isset($_POST['action'])) {
            // Sanitize input data to prevent SQL injection
            $event_id = mysqli_real_escape_string($con, $_POST['event_id']);
            $action = mysqli_real_escape_string($con, $_POST['action']);

            if ($action === 'like') {
                // Increment the likes count in the database
                $update_query = "UPDATE events SET likes = likes + 1 WHERE id = '$event_id'";
                $result = mysqli_query($con, $update_query);

                if (!$result) {
                    die("Error updating likes: " . mysqli_error($con));
                }
            }
        }

        // Fetch events from the database
        $event_query = mysqli_query($con, "SELECT * FROM events WHERE approved = 1 ORDER BY event_date DESC");

        // Check if there are any events
        if (mysqli_num_rows($event_query) > 0) {
            while ($event_row = mysqli_fetch_assoc($event_query)) {
                $event_id = $event_row['id'];
                $event_title = $event_row['title'];
                $event_description = $event_row['description'];
                $event_date = $event_row['event_date'];
                $event_likes = $event_row['likes'];

                // Fetch comments for this event from the database
                $comment_query = mysqli_query($con, "SELECT * FROM comments WHERE post_id = $event_id");


        ?>
                <div class="event">
                    <h3><?php echo $event_title; ?></h3>
                    <p><?php echo $event_description; ?></p>
                    <p>Date: <?php echo $event_date; ?></p>
                    <p>Likes: <?php echo $event_likes; ?></p>

                    <!-- Like Button -->
                    <form method="post" action="">
                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                        <input type="hidden" name="action" value="like">
                        <button class="like-btn">Like</button>
                    </form>

                    <!-- Comment Form -->
                    <form class="comment-form" method="post" action="">
                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                        <input type="text" name="comment_text" placeholder="Write a comment..." required>
                        <button type="submit">Comment</button></form></form>
<div class="button-container">
    <!-- Report Event Form -->
   <form action="reportcomfirmation.php" method="post">
    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
    <input type="submit" name="report_event" value="Report" class="custom-button">
</form>
    
    <!-- Donate Form -->
    <form action="donate.php" method="post">
        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
        <button type="submit" name="donate">Donate</button>
    </form>
    
    <!-- Going Button Form -->
    <form action="going_handler.php" method="post">
        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
        <button type="submit" name="going">
            <?php 
            // Get the number of attendees for the event
            $num_attendees_query = mysqli_query($con, "SELECT attendees FROM events WHERE id = $event_id");
            $num_attendees = mysqli_fetch_array($num_attendees_query)[0];
            ?>
             Attend <?php echo $num_attendees; ?>
        </button>
    </form>
</div>




    
                    <!-- Display Comments for this event -->
                    <div class="comments">
                        <h4>Comments</h4>
                        <?php
                        while ($comment_row = mysqli_fetch_assoc($comment_query)) {
                            // Fetch the user's first and last names based on the username
                            $username = $comment_row['posted_by'];
                            $user_query = mysqli_query($con, "SELECT first_name, last_name FROM users WHERE username = '$username'");
                            $user_row = mysqli_fetch_assoc($user_query);
                            if ($user_row) {
                                $user_name = $user_row['first_name'] . ' ' . $user_row['last_name'];
                                echo "<p><strong>$user_name:</strong> " . $comment_row['post_body'] . "</p>";
                            }
                        }
                        ?>

                    </div>
                </div>
        <?php
            }
        } else {
            echo "No events found.";
        }
        ?>
