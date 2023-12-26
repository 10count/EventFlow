<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>

<?php

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (isset($_GET['staff_id']) && isset($_GET['event_id'])) {
    $staff_id = $_GET['staff_id'];
    $event_id = $_GET['event_id'];

    $update_query = "UPDATE staff SET s_event_id = NULL WHERE staff_id = $staff_id AND s_event_id = $event_id";

    if ($conn->query($update_query) === TRUE) {
        s_msg ('Staff member was successfully discharged.');
        echo "<meta http-equiv='refresh' content='0;url=staff_assigned_list.php?event_id=".$event_id."'>"; 
    } else {
        msg('Query Error : '.mysqli_error($conn));
    }

    $conn->close();
} else {
    s_msg ('Invalid parameters provided.');
    echo "<meta http-equiv='refresh' content='0;url=staff_assigned_list.php?event_id=".$event_id."'>"; 
}
?>

