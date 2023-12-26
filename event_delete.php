<?php
include "config.php";
include "util.php";

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

$event_id = $_GET['event_id'];

// update the staff table to set s_event_id to NULL
$update_query = "UPDATE staff SET s_event_id = NULL WHERE s_event_id = $event_id";
$ret_update = mysqli_query($conn, $update_query);

if (!$ret_update) {
    msg('Query Error: ' . mysqli_error($conn));
} else {
    $delete_query = "DELETE FROM event WHERE event_id = $event_id";
    $ret_delete = mysqli_query($conn, $delete_query);

    if (!$ret_delete) {
        msg('Query Error: ' . mysqli_error($conn));
    } else {
        s_msg('Event was deleted successfully.');
        echo "<meta http-equiv='refresh' content='0;url=event_list.php'>";
    }
}
?>
