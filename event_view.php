<?php
include "header.php";
include "config.php";
include "util.php";

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("event_id", $_GET)) {
    $event_id = $_GET["event_id"];
    $query = "SELECT event_id, title, host_name, GROUP_CONCAT(phone SEPARATOR ', ') AS phones, category, event_start, event_end, type, venue_name, venue_street, venue_city, parking, ticket_price  FROM (event NATURAL JOIN host NATURAL JOIN host_phone) NATURAL LEFT OUTER JOIN venue WHERE event_id = $event_id";
    $result = mysqli_query($conn, $query);
    $event = mysqli_fetch_assoc($result);
    if (!$event) {
        msg("Event does not exist.");
    }
}
?>

<div class="container fullwidth">

    <h3>Event Details</h3>

    <p>
        <label for="event_id">Event ID</label>
        <input readonly type="text" id="event_id" name="event_id" value="<?= $event['event_id'] ?>"/>
    </p>
    <p>
        <label for="title">Event name</label>
        <input readonly type="text" id="title" name="title" value="<?= $event['title'] ?>"/>
    </p>
    <p>
        <label for="host_name">Organizer name</label>
        <input readonly type="text" id="host_name" name="host_name" value="<?= $event['host_name'] ?>"/>
    </p>
    <p>
        <label for="phones">Organizer phone num.</label>
        <input readonly type="text" id="phones" name="phones" value="<?= $event['phones'] ?>"/>
    </p>
    
    <p>
        <label for="category">Category</label>
        <input readonly type="text" id="category" name="category" value="<?= $event['category'] ?>"/>
    </p>
    
    <p>
        <label for="event_start">Start date/time</label>
        <input readonly type="text" id="event_start" name="event_start" value="<?= $event['event_start'] ?>"/>
    </p>
    <p>
        <label for="event_end">End date/time</label>
        <input readonly type="text" id="event_end" name="event_end" value="<?= $event['event_end'] ?>"/>
    </p>

    <?php if ($event['type'] === 'online'): ?>
        <p>
            <label for="type">Location</label>
            <input readonly type="text" id="type" name="type" value="Online"/>
        </p>
    <?php else: ?>
        <p>
            <label for="venue_name">Venue name</label>
            <input readonly type="text" id="venue_name" name="venue_name" value="<?= $event['venue_name'] ?>"/>
        </p>
        <p>
            <label for="venue_street">Street</label>
            <input readonly type="text" id="venue_street" name="venue_street" value="<?= $event['venue_street'] ?>"/>
        </p>
        <p>
            <label for="venue_city">City</label>
            <input readonly type="text" id="venue_city" name="venue_city" value="<?= $event['venue_city'] ?>"/>
        </p>
        <p>
            <label for="parking">Parking</label>
            <input readonly type="text" id="parking" name="parking" value="<?php echo ($event['parking'] === 'y') ? 'Available' : 'Not available'; ?>"/>
        </p>
    <?php endif; ?>

    <p>
        <label for="ticket_price">Ticket price (KRW)</label>
        <input readonly type="text" id="ticket_price" name="ticket_price" value="<?= $event['ticket_price'] ?>"/>
    </p>
    
    <a href='event_list.php'>
        <button style='background-color:#f1f1f1; padding:8px; width:100px; border:none; font-weight:bold;
        transition: background-color 0.3s; margin-top:25px;' onmouseover="this.style.backgroundColor='#ddd'" onmouseout="this.style.backgroundColor='#f1f1f1'">
        &laquo; Previous</button></a>

</div>



<?php include "footer.php" ?>
