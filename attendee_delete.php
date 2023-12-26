<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>

<?php

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (isset($_GET['attendee_id']) && isset($_GET['event_id'])) {
    $attendee_id = $_GET['attendee_id'];
    $event_id = $_GET['event_id'];

    $delete_query = "DELETE FROM attend WHERE attendee_id = $attendee_id AND event_id = $event_id";

    if ($conn->query($delete_query) === TRUE) {
        s_msg ('Attendee was successfully removed.');
        echo "<meta http-equiv='refresh' content='0;url=attendee_list.php?event_id=".$event_id."'>"; 
    } else {
        msg('Query Error : '.mysqli_error($conn));
    }

    $conn->close();
} else {
    s_msg ('Invalid parameters provided.');
    echo "<meta http-equiv='refresh' content='0;url=attendee_list.php?event_id=".$event_id."'>"; 
}
?>

