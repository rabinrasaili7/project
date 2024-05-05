<?php 

include 'session-file.php';

class Post{
    private $user_obj;
    private $con;
    
    public function __construct($con, $user){
        $this->con = $con;
        $this->user_obj = new User($con, $user);
    }
    
    public function submitPost($body){
        $body = strip_tags($body); //remove things like <,>...etc tags
        $body = mysqli_real_escape_string($this->con, $body); //ignore the ' in post body
        $check_empty = preg_replace('/\s+/', '', $body); //deletes all spaces
        
        if($check_empty != ""){
            $body_array = preg_split("/\s+/", $body);
            $body = implode(" ", $body_array);
            
            //current date and time
            $date_added = date("Y-m-d H:i:s");
            
            //get username 
            $added_by = $this->user_obj->getUsername();
            
            //insert post to database
            $query = mysqli_query($this->con, "INSERT INTO posts (body, added_by, date_added, user_closed, deleted, likes) VALUES('$body', '$added_by', '$date_added', 'no', 'no', '0')");

            //returns the id of inserted post
            $returned_id = mysqli_insert_id($this->con);
            
            //increase the post count of user 
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");
        }
    }

    public function indexPosts () {
      
        $ret_str = "";
        $data_query = mysqli_query($this->con, "SELECT * FROM posts ORDER BY id DESC");

        while($row = mysqli_fetch_array($data_query)) {
            $id = $row['id'];
            $body = $row['body'];
            $added_by = $row['added_by'];
            $date_time = $row['date_added'];

            // show post/display post
            $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
            $user_row = mysqli_fetch_array($user_details_query);
            $first_name = $user_row['first_name'];
            $last_name = $user_row['last_name'];
            $profile_pic = $user_row['profile_pic'];
            
            // Format time message
            $time_message = $this->formatTimeMessage($date_time);

            // Count comments
            $comment_check = mysqli_query($this->con,"SELECT * FROM comments WHERE post_id='$id'");
            $comment_check_num = mysqli_num_rows($comment_check);

            // Construct HTML for the post
            $ret_str .= "
                <div class='status_post'>                     
                    <div class='post_profile_pic'>
                        <img src='$profile_pic' width='50'> 
                    </div>  
                    <div class='posted_by' style='color:#ACACAC;'> 
                        <a href='$added_by'> $first_name $last_name </a> <br> 
                        <div class='time'> $time_message </div> 
                    </div> <br> <br> 
                    <div class='post_body' id='post_body'> 
                    <span style='margin-left: 34px;'> $body </span> <br> <br>
                    </div> 
                </div>
                <div class='post_feature'>
                    <div class='comImg_comCount' style='display: flex; float: right; margin: 0 40px;'>
                        <span class='comment' onClick='javascript:toggle$id()'><img src='assets/images/comment.png' height='30px'></span> 
                        <span style='margin: 5px 5px;'>($comment_check_num)</span>&nbsp;&nbsp;
                    </div>
                    <iframe src='like.php?post_id=$id' style='border: 0px; height: 25px; width: 120px; margin-left: 35px;' scrolling='no'></iframe>
                </div>
                <div class='post_comment' id='toggleComment$id' style='display:none;'>
                    <iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0' style='display: flex; width: 100%; border-radius: 5px;'></iframe>                                    
                </div>
                <hr style='margin-bottom: 28px;'> ";
        }
        
        echo $ret_str;
    }

    // Function to format time message
    private function formatTimeMessage($date_time) {
        $date_time_now = date("Y-m-d H:i:s");
        $start_date = new DateTime($date_time); //time of post
        $end_date = new DateTime($date_time_now); //current time
        $interval = $start_date->diff($end_date); //difference between dates

        if($interval->y >= 1){
            return $interval->y == 1 ? $interval->y . " year ago" : $interval->y . " years ago";
        } elseif($interval->m >= 1){
            $days = $interval->d == 0 ? "" : " ago";
            return $interval->m == 1 ? $interval->m . " month" . $days : $interval->m . " months" . $days;
        } elseif($interval->d >= 1){
            return $interval->d == 1 ? "Yesterday" : $interval->d . " days ago";
        } elseif($interval->h >= 1){
            return $interval->h == 1 ? $interval->h . " hour ago" : $interval->h . " hours ago";
        } elseif($interval->i >= 1){
            return $interval->i == 1 ? $interval->i . " minute ago" : $interval->i . " minutes ago";
        } else{
            return $interval->s < 30 ? "Just Now" : $interval->s . " seconds ago";
        }
    }
}
?>
