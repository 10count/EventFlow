<?php
include "config.php";
include "util.php";

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
mysqli_autocommit($conn, false); // Disable autocommit

try {
    $event_id = $_POST['event_id'];
    
    foreach ($_POST['staff_id'] as $sid) {
        $query = "UPDATE staff SET s_event_id = $event_id WHERE staff_id = $sid";
        mysqli_query($conn, $query);
    }
    
    mysqli_commit($conn); //commit the transaction
    
    s_msg('Assigned staff successfully.');
    echo "<script>location.replace('staff_assigned_list.php?event_id=$event_id');</script>";
} catch (Exception $e) {
    mysqli_rollback($conn); // rollback the transaction in case of an error
    s_msg('Error occurred. Please try again.'); // display an error message
}

mysqli_autocommit($conn, false); // enable autocommit
mysqli_close($conn);
?>
