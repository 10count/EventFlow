<?php
include (__DIR__ . "/header.php");
include "config.php";
include "util.php";
?>

<div class="container">
    <?php
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "SELECT * FROM `event` NATURAL LEFT OUTER JOIN `venue`";
    if (array_key_exists("search_keyword", $_POST)) {   // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query .= " where title like '%$search_keyword%' or venue_name like '%$search_keyword%'";
    }
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die('Query Error : ' . mysqli_connect_error());
    }
    ?>
    <br>
    <table class="table table-striped table-bordered">
        <tr>
            <th>No.</th>
            <th>Event Name</th>
            <th>Start Date/Time</th>
            <th>End Date/Time</th>
            <th>Location</th>
            <th>Ticket Price</th>
            <th>Registration Date</th>
            <th>Manage</th>
        </tr>
        <?php
        $row_index = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='event_view.php?event_id={$row['event_id']}'>{$row['title']}</a></td>";
            echo "<td>{$row['event_start']}</td>";
            echo "<td>{$row['event_end']}</td>";
            
            if ($row['type'] == "online") {
                echo "<td>{$row['type']}</td>";   //'type' from event table
            } elseif ($row['type'] == "venue") {
                echo "<td>{$row['venue_name']}</td>";   //'venue_name' from venue table
            }
            
            echo "<td>{$row['ticket_price']}</td>";
            echo "<td>{$row['registration_date']}</td>";
            echo "<td width='10%'>
                <a href='modify_form.php?event_id={$row['event_id']}'><button class='button primary small'
                    style='font-size:small; margin:auto; display:block;'>Modify</button></a>
                <button onclick='javascript:deleteConfirm({$row['event_id']})' class='button danger small'
                    style='font-size:small; margin:auto; display:block; margin-top:5px;'>Delete</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
    </table>
    <script>
        function deleteConfirm(event_id) {
            if (confirm("Do you want to delete this event?") == true){    //확인
                window.location = "event_delete.php?event_id=" + event_id;
            }
            else {   //취소
                return;
            }
        }
    </script>
</div>

<?php include (__DIR__ . "/footer.php") ?>
