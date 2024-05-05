<?php

require_once("User.php"); // Assuming User.php contains the User class definition

class Message {
    private $user_obj;
    private $con;

    public function __construct($con, $user){
        $this->con = $con;
        $this->user_obj = new User($con, $user);
    }

    public function getMostRecentUser(){
        $userLoggedIn = $this->user_obj->getUsername();
        $query = mysqli_query($this->con, "SELECT user_to, user_from FROM messages WHERE user_to='$userLoggedIn' OR user_from='$userLoggedIn' ORDER BY id DESC LIMIT 1");
        
        if(mysqli_num_rows($query) == 0)
            return false;
        $row = mysqli_fetch_array($query);
        $user_to = $row['user_to'];
        $user_from = $row['user_from'];

        if ($user_to != $userLoggedIn)
            return $user_to;
        else
            return $user_from;
    }

    public function getLastMsg($userLoggedIn, $otheruser){
        $info_array = array();

        $query = mysqli_query($this->con, "SELECT body, user_to, date FROM messages WHERE (user_to='$userLoggedIn' AND user_from='$otheruser') OR (user_from='$userLoggedIn' AND user_to='$otheruser') ORDER BY id DESC LIMIT 1");

        // Check if the query executed successfully
        if ($query) {
            // Fetch the row
            $row = mysqli_fetch_array($query);
            // Check if the row is not empty
            if ($row) {
                // Access the array elements safely
                $sent_by = ($row['user_to'] == $userLoggedIn) ? "They said: " : "You said: ";
                // Other code remains the same
            } else {
                // Handle the case where no data was fetched
                $sent_by = ''; // Set default value
            }
        } else {
            // Handle the case where the query failed
            $sent_by = ''; // Set default value
        }

        // Push values to the array
        $time_message = ''; // Initialize time_message variable
        array_push($info_array, $sent_by);
        array_push($info_array, isset($row['body']) ? $row['body'] : ''); // Use isset() to check if the key exists
        array_push($info_array, $time_message);

        return $info_array;
    }

    public function sendMessage($user_to, $body, $date){
        if ($body != "") {            
            $userLoggedIn = $this->user_obj->getUsername();
            $query = mysqli_query($this->con, "INSERT INTO messages VALUES ('','$user_to','$userLoggedIn','$body','$date','no','no','no')") or die(mysqli_error($this->con));
        }
    }

    public function getMessages($otheruser){
        $userLoggedIn = $this->user_obj->getUsername();
        $data = "";
        $query = mysqli_query($this->con, "UPDATE messages SET opened='yes' WHERE user_to='$userLoggedIn' AND user_from='$otheruser'");

        // Getting the messages of both users (sender and receiver)
        $get_msg_query = mysqli_query($this->con, "SELECT * FROM messages WHERE (user_to='$userLoggedIn' AND user_from='$otheruser') OR (user_from='$userLoggedIn' AND user_to='$otheruser')");

        while ($row = mysqli_fetch_array($get_msg_query)) {
            $user_to = $row['user_to'];
            $user_from = $row['user_from'];
            $body = $row['body'];

            $div_top = ($user_to == $userLoggedIn) ? "<div class='msg' id='green'>" : "<div class='msg' id='blue'>";//conditional/ternary operator( e1 ? c1 : c2 )
            $data .= $div_top . $body . "</div><br><br>";
        }
        return $data;
    }

    public function getOtherChats(){
        $userLoggedIn = $this->user_obj->getUsername();
        $return_string = "";

        $chat = array();

        $query = mysqli_query($this->con, "SELECT user_to, user_from FROM messages WHERE user_to='$userLoggedIn' OR user_from='$userLoggedIn'");
        while ($row = mysqli_fetch_array($query)) {
            $user_to_push = ($row['user_to'] != $userLoggedIn) ? $row['user_to'] : $row['user_from']; 
            if (!in_array($user_to_push, $chat)) {
                array_push($chat, $user_to_push);
            }
        }

        foreach($chat as $username){
            $user_found_obj = new User($this->con, $username);
            $last_msg_detail = $this->getLastMsg($userLoggedIn, $username);

            $dots = (strlen($last_msg_detail[1]) >= 12) ? "..." : "";
            $split = str_split($last_msg_detail[1], 12);
           $split = !empty($split) ? $split[0] . $dots : ''; // Check if $split is not empty


            $return_string .= "<a href='messages.php?u=$username'> <div class='user_found_msg'> <div class='img'>
                                <img src='".$user_found_obj->getProfilePic()."' style='margin-right: 7px; height:50px; width: 50px; border-radius: 7px;'></div> <div class='chat_name'>
                                ".$user_found_obj->getFnameAndLname()."</div> <div class='other'>
                                <span class='time_sml' id='grey'>".$last_msg_detail[2]."</span>
                                <p class='chat_p'>".$last_msg_detail[0].$split."</p></div>
                                </div>
                                </a><hr> ";
        }

        return $return_string;
    }

    public function getUnreadNumber(){
        $userLoggedIn = $this->user_obj->getUsername();
        $query = mysqli_query($this->con, "SELECT * FROM messages WHERE opened='no' AND user_to='$userLoggedIn'");
        return mysqli_num_rows($query);
    }

}

?>
