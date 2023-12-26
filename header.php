<!DOCTYPE html>
<html lang='ko'>
<head>
    <title>Event Flow</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        .subfunctions {
            display: none;
            position: absolute;
            background-color: rgba(249, 249, 249, 0.9);
            min-width: 100px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            padding: 15px 15px;
        }
        
        .dropdown {
              color: #5f8fb0;
              font-weight: bold;
        }
        
        .navbar .unclickable:hover .subfunctions {
            display: block;
        }
        
        .navbar .unclickable {
            cursor: default;
        }
    </style>
</head>
<body>
<form action="event_list.php" method="post">
    <div class='navbar fixed'>
        <div class='container'>
            <a class='pull-left title' href="index.php">Event Flow</a>
            <ul class='pull-right'>
                <li>
                    <input type="text" name="search_keyword" placeholder="Search events">
                </li>
                <li class="dropdown unclickable">
                    <span>Organize events</span>        
                    <ul class="subfunctions">
                        <li><a href='create_form.php'>Create event</a></li><br>
                        <li><a href='event_list.php'>Manage events</a></li><br>
                    </ul>
                </li>
                <li class="dropdown unclickable">
                    <span>Manage participants</span>
                    <ul class="subfunctions">
                        <li><a href='event_list_participants.php?manage=attendees'>Attendees</a></li><br>
                        <li><a href='event_list_participants.php?manage=staff'>Staff</a></li>
                    </ul>
                <li><a href='eventflow_db.php'>Database & Manual</a></li>
            </ul>
        </div>
    </div>
</form>

<script>
    var dropdowns = document.getElementsByClassName("dropdown");
    for (var i = 0; i < dropdowns.length; i++) {
        dropdowns[i].addEventListener("mouseover", function() {
            this.getElementsByClassName("subfunctions")[0].style.display = "block";
        });
        dropdowns[i].addEventListener("mouseout", function() {
            this.getElementsByClassName("subfunctions")[0].style.display = "none";
        });
    }
</script>
</body>
</html>
