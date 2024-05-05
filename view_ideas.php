<?php
include 'session-file.php';

$query = "SELECT * FROM forum ORDER BY date_posted DESC";
$result = mysqli_query($con, $query) or die(mysqli_error($con));

echo "<h2>Forum</h2>";

while($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $name = $row['name'];
    $idea = $row['idea'];
    $datePosted = $row['date_posted'];

    echo "<div>";
    echo "<p><strong>$name</strong> posted on $datePosted:</p>";
    echo "<p>$idea</p>";

    // Reply form
    echo "<form action='submit_reply.php' method='post'>";
    echo "<input type='hidden' name='idea_id' value='$id'>";
    echo "<input type='text' name='reply' placeholder='Reply...'>";
    echo "<input type='submit' value='Reply'>";
    echo "</form>";

    // Fetch and display replies
    $replyQuery = "SELECT * FROM replies WHERE idea_id = '$id' ORDER BY date_posted DESC";
    $replyResult = mysqli_query($con, $replyQuery) or die(mysqli_error($con));

    while($replyRow = mysqli_fetch_assoc($replyResult)) {
        $replyName = $replyRow['name'];
        $replyMessage = $replyRow['message'];
        $replyDate = $replyRow['date_posted'];

        echo "<p><strong>$replyName</strong> replied on $replyDate:</p>";
        echo "<p>$replyMessage</p>";
    }

    echo "</div>";
}

?>
