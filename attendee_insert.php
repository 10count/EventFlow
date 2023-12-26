<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>

<?php

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (isset($_GET['event_id']) && isset($_GET['attendee_id'])) {
    $event_id = $_GET['event_id'];
    $attendee_id = $_GET['attendee_id'];

    $query = "INSERT INTO attend (event_id, attendee_id) VALUES ($event_id, $attendee_id)";
    mysqli_query($conn, $query);
    
    header("Location: attendee_list.php?event_id=$event_id");
    exit();
} else {
    header("Location: event_list_attendee.php");
    exit();
}
?>
