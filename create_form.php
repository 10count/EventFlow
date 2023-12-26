<?php
include (__DIR__ . "/header.php");
include "config.php";
include "util.php";

//$conn = mysqli_connect('localhost', 'root', '', 'eventflow_db') 
//or die("Connection Failed:" .mysqli_connect_error());;
$conn = dbconnect($host, $dbid, $dbpass, $dbname);

$mode = "Submit";
$action = ("event_insert.php");

$host = array();  //create empty array

$query = "SELECT * FROM `host`";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result)) {
    $host[$row['host_id']] = $row['host_name'];
}
?>

<div class="container">
	
    <form name="create_form" action="<?=$action?>" method="post" class="fullwidth">
	    </br>
	    <div style="align-items: center; margin-left: 850px;">
	        <label for="host_id" style="margin-right: 10px;">Host ID:</label>
	        <input style="margin-top: 5px;" type="text" id="host_id" name="host_id">
	    </div>
        <input type="hidden" name="event_id" value="<?=$event['event_id']?>"/>
        <h3>Event Details</h3>
        <p>
            <label for="title">Event name</label>
            <input type="text" placeholder="Enter event name" id="title" name="title"/>
        </p>
        <p>
            <label for="category">Category</label>
            <select name="category" id="category">
                <option value="-1">Select a category</option>
                <option value="Business" >Business</option>
                <option value="Community" >Community</option>
                <option value="Education" >Education</option>
                <option value="Fashion" >Fashion</option>
                <option value="Media" >Media</option>
                <option value="Food & Drink" >Food & Drink</option>
                <option value="Politics" >Politics</option>
                <option value="Health" >Health</option>
                <option value="Hobbies" >Hobbies</option>
                <option value="Lifestyle" >Lifestyle</option>
                <option value="Religion" >Religion</option>
                <option value="Science & Technology" >Science & Technology</option>
                <option value="Sport" >Sport</option>
                <option value="Other" >Other</option>
            </select>
        </p>
        <p>
            <label>Date and time</label><br>
            <input type="datetime-local" id="event_start" name="event_start" min="<?= date('Y-m-d\TH:i') ?>" />
            <span style="margin-left: 10px; margin-right: 10px;">~</span>
            <input type="datetime-local" id="event_end" name="event_end" min="<?= date('Y-m-d\TH:i') ?>" />
        </p>
        <p>
            <label for="type">Type</label>
            <select name="type" id="type" onchange="toggleVenueFields()">
                <option value="-1">Select event type</option>
                <option value="venue" >In venue</option>
                <option value="online" >Online</option>
            </select>
        </p>
        
        <div id="venueFields" style="display: none;">
            <p>
                <label for="venue_name">Venue name</label>
                <input type="text" placeholder="Enter venue name" id="venue_name" name="venue_name" />
            </p>
            <p>
                <label for="venue_street">Street</label>
                <input type="text" placeholder="Enter street address" id="venue_street" name="venue_street" />
            </p>
            <p>
                <label for="venue_city">City</label>
                <input type="text" placeholder="Enter city address" id="venue_city" name="venue_city" />
            </p>
            <p>
                <label for="parking">Parking</label><br>
                <label><input type="radio" name="parking" value="y"> Available</label>
                <label><input type="radio" name="parking" value="n" style="margin-left: 10px;"> Not available</label>
            </p>
        </div>
        
        <p>
            <label for="ticket_price">Ticket price (KRW)</label>
            <input type="number" placeholder="Enter as a whole number" id="ticket_price" name="ticket_price">
            <span id="online_event_message" style="color: red; font-size: small; display: none;">*Online events are free</span>
        </p>
        
        <p align="center">
            <button style="margin-top: 20px;" class="button primary small" onclick="javascript:return validate();"><?=$mode?></button>
        </p>
            
        <script>
        
			function toggleVenueFields() {
			    var type = document.getElementById("type").value;
			    var venueFields = document.getElementById("venueFields");
			    var ticketPriceField = document.getElementById("ticket_price");
                var onlineEventMessage = document.getElementById("online_event_message");
			
			    if (type === "venue") {
			        venueFields.style.display = "block";
			        ticketPriceField.removeAttribute("readonly");
			        ticketPriceField.value = "";
			        ticketPriceField.placeholder = "Enter as a whole number";
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
                    onlineEventMessage.style.display = "node";
			    }
			}


            function validate() {
            	
			    if (document.getElementById("host_id").value === "") {
			        alert("Enter host ID.");
			        return false;
			    } else {
			        var hostId = document.getElementById("host_id").value;
			        var hostIds = <?php echo json_encode(array_keys($host)); ?>;
			
			        if (hostIds.indexOf(hostId) === -1) {
			            alert("Invalid host ID. Please enter a valid host ID.");
			            return false;
			        }
			    }
            	
                if (document.getElementById("host_id").value === "") {
                    alert("Enter host ID.");
                    return false;
				}
                else if (document.getElementById("title").value === "") {
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
            
			window.addEventListener("DOMContentLoaded", function() {
			    toggleVenueFields();
			});
        </script>
    </form>

    <div style='margin-bottom: 85px'>
        <a href='index.php'>
            <button style='background-color:#f1f1f1; padding:8px; width:90px; border:solid 0.5px #c8c8c8; font-weight:bold; float:right;
            transition: background-color 0.3s; margin-top:10px;' onmouseover="this.style.backgroundColor='#ddd'" onmouseout="this.style.backgroundColor='#f1f1f1'">
            Cancel</button>
        </a>
    </div>

</div>

<?php include(__DIR__ . "/footer.php") ?>


