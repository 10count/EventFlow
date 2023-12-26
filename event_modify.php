<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$event_id = $_POST['event_id'];
$title = $_POST['title'];
$category = $_POST['category'];
$event_start = $_POST['event_start'];
$event_end = $_POST['event_end'];
$type = $_POST['type'];
$ticket_price = $_POST['ticket_price'];

// Get initial value of 'type'
$initial_type = mysqli_fetch_assoc(mysqli_query($conn, "SELECT type FROM event WHERE event_id = $event_id"))['type'];

if ($initial_type == 'online' && $type == 'venue') {
    // Insert new values into venue table
    $venue_name = $_POST['venue_name'];
    $venue_street = $_POST['venue_street'];
    $venue_city = $_POST['venue_city'];
    $parking = $_POST['parking'];

    $result = mysqli_query($conn, "UPDATE event SET title = '$title', category = '$category', event_start = '$event_start', event_end = '$event_end', type = '$type', ticket_price = $ticket_price WHERE event_id = $event_id");

    if (!$result) {
        msg('Query Error: ' . mysqli_error($conn));
    } else {
        // Insert new row into venue table
        $result = mysqli_query($conn, "INSERT INTO venue (venue_name, venue_street, venue_city, parking, event_id) VALUES ('$venue_name', '$venue_street', '$venue_city', '$parking', $event_id)");
        if (!$result) {
            msg('Query Error: ' . mysqli_error($conn));
        } else {
            s_msg('Event was modified successfully.');
            echo "<script>location.replace('event_list.php');</script>";
        }
    }
} elseif ($initial_type == 'venue' && $type == 'online') {
    // Update only values in event table    
    $result = mysqli_query($conn, "UPDATE event SET title = '$title', category = '$category', event_start = '$event_start', event_end = '$event_end', type = '$type', ticket_price = $ticket_price WHERE event_id = $event_id");
        
    if (!$result) {
        msg('Query Error: ' . mysqli_error($conn));
    } else {
        // Delete row from venue table
        $result = mysqli_query($conn, "DELETE FROM venue WHERE event_id = $event_id");
            
        if (!$result) {
            msg('Query Error: ' . mysqli_error($conn));
        } else {
            s_msg('Event was modified successfully.');
            echo "<script>location.replace('event_list.php');</script>";
        }
    }
} elseif ($initial_type == 'venue' && $type == 'venue') {
    
    $venue_name = $_POST['venue_name'];
    $venue_street = $_POST['venue_street'];
    $venue_city = $_POST['venue_city'];
    $parking = $_POST['parking'];

    $result = mysqli_query($conn, "UPDATE event SET title = '$title', category = '$category', event_start = '$event_start', event_end = '$event_end', type = '$type', ticket_price = $ticket_price WHERE event_id = $event_id");

    if (!$result) {
        msg('Query Error: ' . mysqli_error($conn));
    } else {
        // Update existing row in venue table
        $result = mysqli_query($conn, "UPDATE venue SET venue_name = '$venue_name', venue_street = '$venue_street', venue_city = '$venue_city', parking = '$parking' WHERE event_id = $event_id");

        if (!$result) {
            msg('Query Error: ' . mysqli_error($conn));
        } else {
            s_msg('Event was modified successfully.');
            echo "<script>location.replace('event_list.php');</script>";
        }
    }
} else {
    // $initial_type == 'online' && $type == 'online'
    // Update only values in event table
    $result = mysqli_query($conn, "UPDATE event SET title = '$title', category = '$category', event_start = '$event_start', event_end = '$event_end', type = '$type', ticket_price = $ticket_price WHERE event_id = $event_id");

    if (!$result) {
        msg('Query Error: ' . mysqli_error($conn));
    } else {
        s_msg('Event was modified successfully.');
        echo "<script>location.replace('event_list.php');</script>";
    }
}

?>
