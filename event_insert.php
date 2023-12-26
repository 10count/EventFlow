<?php
include "config.php";
include "util.php";
?>

<?php
$conn = dbconnect($host, $dbid, $dbpass, $dbname);

$host_id = $_POST['host_id'];
$title = $_POST['title'];
$category = $_POST['category'];
$event_start = $_POST['event_start'];
$event_end = $_POST['event_end'];
$type = $_POST['type'];
$venue_name = $_POST['venue_name'];
$venue_street = $_POST['venue_street'];
$venue_city = $_POST['venue_city'];
$parking = $_POST['parking'];
$ticket_price = $_POST['ticket_price'];

$query = "INSERT INTO `event` (`registration_date`, `title`, `event_start`, `event_end`, `type`, `category`, `ticket_price`, `host_id`) VALUES (NOW(), '$title', '$event_start', '$event_end', '$type', '$category', '$ticket_price', '$host_id')";
$result = mysqli_query($conn, $query);

if (!$result) {
    msg('Query Error: ' . mysqli_error($conn));

} else {
    $event_id = mysqli_insert_id($conn);   // Get the last inserted event_id

    if ($type === "venue") {
        $venue_result = mysqli_query($conn, "INSERT INTO `venue` (`venue_name`, `venue_street`, `venue_city`, `parking`, `event_id`) VALUES ('$venue_name', '$venue_street', '$venue_city', '$parking', '$event_id')");
        if (!$venue_result) {
            msg('Query Error: ' . mysqli_error($conn));
        }
    }

    echo "
    <script>
         window.alert('Event was created successfully.');
         location.replace('event_list.php');
    </script>";
}
?>
