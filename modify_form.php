<?php
include "header.php";
include "config.php";
include "util.php";


$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("event_id", $_GET)) {
    $event_id = $_GET["event_id"];
    $query = "SELECT * FROM event NATURAL LEFT OUTER JOIN venue WHERE event_id = $event_id";
    $result = mysqli_query($conn, $query);
    $event = mysqli_fetch_array($result);
    
    $title = $event['title'];
    $category = $event['category'];
    $event_start = isset($event['event_start']) ? date('Y-m-d\TH:i', strtotime($event['event_start'])) : '';
    $event_end = isset($event['event_end']) ? date('Y-m-d\TH:i', strtotime($event['event_end'])) : '';
    $type = $event['type'];
    
    $venue_name = $event['venue_name'];
    $venue_street = $event['venue_street'];
    $venue_city = $event['venue_city'];
    $parking = $event['parking'];
    
    $ticket_price = $event['ticket_price'];

    if (!$event) {
        msg("Event does not exist.");
    }
    $mode = "Modify";
    $action = "event_modify.php";
}
?>

<div class="container fullwidth">
    <form action="event_modify.php" method="POST">
	    <input type="hidden" name="event_id" value="<?=$event['event_id']?>"/>
	    
	    <h3>Event Details</h3>
	
	    <p>
	        <label for="title">Event name</label>
	        <input type="text" id="title" name="title" value="<?= $event['title'] ?>"/>
	    </p>
	
	    <p>
	        <label for="category">Category</label>
	        <select name="category" id="category">
	            <option value="-1">Select a category</option>
	            <option value="Business" <?= $category === "Business" ? "selected" : "" ?>>Business</option>
	            <option value="Community" <?= $category === "Community" ? "selected" : "" ?>>Community</option>
	            <option value="Education" <?= $category === "Education" ? "selected" : "" ?>>Education</option>
	            <option value="Fashion" <?= $category === "Fashion" ? "selected" : "" ?>>Fashion</option>
	            <option value="Media" <?= $category === "Media" ? "selected" : "" ?>>Media</option>
	            <option value="Food & Drink" <?= $category === "Food & Drink" ? "selected" : "" ?>>Food & Drink</option>
	            <option value="Politics" <?= $category === "Politics" ? "selected" : "" ?>>Politics</option>
	            <option value="Health" <?= $category === "Health" ? "selected" : "" ?>>Health</option>
	            <option value="Hobbies" <?= $category === "Hobbies" ? "selected" : "" ?>>Hobbies</option>
	            <option value="Lifestyle" <?= $category === "Lifestyle" ? "selected" : "" ?>>Lifestyle</option>
	            <option value="Religion" <?= $category === "Religion" ? "selected" : "" ?>>Religion</option>
	            <option value="Science & Technology" <?= $category === "Science & Technology" ? "selected" : "" ?>>Science & Technology</option>
	            <option value="Sport" <?= $category === "Sport" ? "selected" : "" ?>>Sport</option>
	            <option value="Other" <?= $category === "Other" ? "selected" : "" ?>>Other</option>
	    </select>
	    </p>
	    <p>
	    	<label>Date and time</label><br>
	        <input type="datetime-local" id="event_start" name="event_start" min="<?= date('Y-m-d\TH:i') ?>" value="<?= isset($event['event_start']) ? date('Y-m-d\TH:i', strtotime($event['event_start'])) : '' ?>" />
			<span style="margin-left: 10px; margin-right: 10px;">~</span>
	        <input type="datetime-local" id="event_end" name="event_end" min="<?= date('Y-m-d\TH:i') ?>" value="<?= isset($event['event_end']) ? date('Y-m-d\TH:i', strtotime($event['event_end'])) : '' ?>" />
	    </p>
	    
	    <?php if ($type === 'online'): ?>
	        <p>
	            <label for="type">Type</label>
	            <select name="type" id="type" onchange="toggleVenueFields()">
	                <option value="-1">Select event type</option>
	                <option value="venue" <?= $type === "venue" ? "selected" : "" ?>>In venue</option>
	                <option value="online" <?= $type === "online" ? "selected" : "" ?>>Online</option>
	            </select>
	        </p>
	        <div id="venueFields">
	            <p>
	                <label for="venue_name">Venue name</label>
	                <input type="text" placeholder="Enter venue name" id="venue_name" name="venue_name" value="<?= $venue_name ?>"/>
	            </p>
	            <p>
	                <label for="venue_street">Street</label>
	                <input type="text" placeholder="Enter street address" id="venue_street" name="venue_street" value="<?= $venue_street ?>"/>
	            <p>
	                <label for="venue_city">City</label>
	                <input type="text" placeholder="Enter city address" id="venue_city" name="venue_city" value="<?= $venue_city ?>"/>
	            </p>
	            <p>
	                <label for="parking">Parking</label><br>
	                <label><input type="radio" name="parking" value="y" <?= $parking === "y" ? "checked" : "" ?>> Available</label>
	                <label><input style="margin-left: 10px;" type="radio" name="parking" value="n" <?= $parking === "n" ? "checked" : "" ?>> Not available</label>
	            </p>   
	        </div> 
	        <p>
	            <label for="ticket_price">Ticket price (KRW)</label>
	            <input type="number" placeholder="Enter as a whole number" id="ticket_price" name="ticket_price" value="<?= $ticket_price ?>" <?php if ($type === 'online'): ?>readonly<?php endif; ?> />
				<span id="online_event_message" style="color: red; font-size: small; display: none;">*Online events are free</span>
			</p>
	
	    <?php else: ?>
	        <p>
	            <label for="type">Type</label>
	            <select name="type" id="type" onchange="toggleVenueFields()">
	                <option value="-1">Select event type</option>
	                <option value="venue" <?= $type === "venue" ? "selected" : "" ?>>In venue</option>
	                <option value="online" <?= $type === "online" ? "selected" : "" ?>>Online</option>
	            </select>
	        </p>
	        <div id="venueFields">
	            <p>
	                <label for="venue_name">Venue name</label>
	                <input type="text" id="venue_name" name="venue_name" value="<?= $venue_name ?>"/>
	            </p>
	            <p>
	                <label for="venue_street">Street</label>
	                <input type="text" id="venue_street" name="venue_street" value="<?= $venue_street ?>"/>
	            <p>
	                <label for="venue_city">City</label>
	                <input type="text" id="venue_city" name="venue_city" value="<?= $venue_city ?>"/>
	            </p>
	            <p>
	                <label for="parking">Parking</label><br>
	                <label><input type="radio" name="parking" value="y" <?= $parking === "y" ? "checked" : "" ?>>Available</label>
	                <label><input type="radio" name="parking" value="n" <?= $parking === "n" ? "checked" : "" ?>
							style="margin-left: 10px;">Not available</label>
	            </p>   
	        </div>     
	        <p>
	            <label for="ticket_price">Ticket price (KRW)</label>
	            <input type="number" id="ticket_price" name="ticket_price" value="<?= $ticket_price ?>" />
	        </p>
	    <?php endif; ?>
	    
		<p align="center"><button class="button primary small" style="margin-top: 20px;" onclick="javascript:return validate();"><?=$mode?></button></p>	    

		<script>
		    function toggleVenueFields() {
		        var type = document.getElementById("type").value;
		        var venueFields = document.getElementById("venueFields");
		        var ticketPriceField = document.getElementById("ticket_price");
				var onlineEventMessage = document.getElementById("online_event_message");
		
		        if (type === "venue") {
		            venueFields.style.display = "block";
		            ticketPriceField.removeAttribute("readonly");
		            ticketPriceField.value = "<?= $ticket_price ?>";
		            if (ticketPriceField.value === "") {
		                ticketPriceField.placeholder = "Enter as a whole number";
		            }
					onlineEventMessage.style.display = "none";
		        } else if (type === "online") {
		            venueFields.style.display = "none";
		            ticketPriceField.value = "0";
		            ticketPriceField.setAttribute("readonly", "readonly");
		            ticketPriceField.placeholder = "";
					onlineEventMessage.style.display = "inline";
		        } else {
		            venueFields.style.display = "none";
		            ticketPriceField.removeAttribute("readonly");
		            ticketPriceField.value = "";
		            ticketPriceField.placeholder = "Enter as a whole number";
					onlineEventMessage.style.display = "none";
		        }
		    }
	    
	        function validate() {

	            if (document.getElementById("title").value === "") {
	                alert("Enter event title.");
	                return false;
	            } else if (document.getElementById("category").value === "-1") {
	                alert("Select event category.");
	                return false;
	            } else if (document.getElementById("event_start").value === "") {
	                alert("Select event start date and time.");
	                return false;
	            } else if (document.getElementById("event_end").value === "") {
	                alert("Select event end date and time.");
	                return false;
	            } else if (document.getElementById("type").value === "-1") {
	                alert("Select event location.");
	                return false;
	                    
				} else if (document.getElementById("ticket_price").value === "") {
	                alert("Enter ticket price.");
	                return false;
	                    
	            } else if (document.getElementById("type").value === "venue") {
	                if (document.getElementById("venue_name").value === "") {
	                    alert("Enter venue name.");
	                    return false;
	                }
	                else if (document.getElementById("venue_street").value === "") {
	                    alert("Enter venue street address.");
	                    return false;
	                }
	                else if (document.getElementById("venue_city").value === "") {
	                    alert("Enter venue city address.");
	                    return false;
	                }
	                else if (document.querySelector('input[name="parking"]:checked') === null && document.getElementById("venueFields").style.display === "block") {
	                    alert("Enter parking availability.");
	                    return false;
	                }
	            }
	            return true;
	        }
	        
	        //call toggleVenueFields() on page load
	        window.addEventListener("DOMContentLoaded", function() {
	            toggleVenueFields();
	        });
	    </script>
    </form>
	
	<div>
		<a href='event_list.php'>
			<button style='background-color:#f1f1f1; padding:8px; width:100px; border:none; font-weight:bold;
			transition: background-color 0.3s; margin-top:5px;' onmouseover="this.style.backgroundColor='#ddd'" onmouseout="this.style.backgroundColor='#f1f1f1'">
			&laquo; Previous</button>
		</a>
	</div>

</div>



<?php include "footer.php" ?>
