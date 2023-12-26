<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>

<?php

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    $query = "SELECT title FROM event WHERE event_id = $event_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $title = $row['title'];
} else {
    header("Location: event_list_attendee.php");
    exit();
}

if (isset($_POST['invite'])) {
    $attendee_id = $_POST['attendee_id'];

    // check if attendee_id is entered
    if (empty($attendee_id)) {
        echo "<script>alert('Enter valid user ID');</script>";
    } else {
        // check if attendee_id exists in the attendee table
        $query = "SELECT * FROM attendee WHERE attendee_id = $attendee_id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Check if event_id and attendee_id pair already exists in attend table
            $query = "SELECT * FROM attend WHERE event_id = $event_id AND attendee_id = $attendee_id";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                echo "<script>alert('Already registered to your event.');</script>";
            } else {
                // pass event_id and attendee_id
                header("Location: attendee_insert.php?event_id=$event_id&attendee_id=$attendee_id");
                exit();
            }
        } else {
            echo "<script>alert('Enter valid user ID');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendee Invite</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        </br>
        <h3>Invite Attendees to the Event '<?php echo $title; ?>'</h3>
        </br>
        <form method="post" action="" style="display: flex; align-items: center;">
            <input type="text" name="attendee_id" style="padding: 5.5px; flex: 0.2;" placeholder="Enter user ID">
            <button type="submit" name="invite" class='button primary small' 
                    style="margin-top:10px; margin-left:10px;">Invite</button>
        </form>
        
        <a href='event_list_participants.php?manage=attendees'>
            <button style='background-color:#f1f1f1; padding:8px; width:100px; border:none; font-weight:bold;
            transition: background-color 0.3s; margin-top:25px;' onmouseover="this.style.backgroundColor='#ddd'" onmouseout="this.style.backgroundColor='#f1f1f1'">
            &laquo; Previous</button>
        </a>
    </div>
</body>
</html>

<?php include("footer.php") ?>
