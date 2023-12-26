<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>

<div class="container">
    <?php
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "SELECT * FROM (event NATURAL LEFT OUTER JOIN venue) NATURAL JOIN host";
    $result = mysqli_query($conn, $query);
    if (!$result) {
         die('Query Error : ' . mysqli_connect_error());
    }
    ?>
    <br>
    <table class="table table-striped table-bordered">
        <tr>
            <th>No.</th>
            <th>Event name</th>
            <th>Organizer name</th>
            <th>Start date/time</th>
            <th>End date/time</th>
            <th>Location</th>
            <th>Registration date</th>
            <th>Manage</th>
        </tr>
        <?php
        $row_index = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='event_view.php?event_id={$row['event_id']}'>{$row['title']}</a></td>";
            echo "<th>{$row['host_name']}</td>";
            echo "<td>{$row['event_start']}</td>";
            echo "<td>{$row['event_end']}</td>";
            
            if ($row['type'] == "online") {
                echo "<td>{$row['type']}</td>";   //'type' from event table
            } elseif ($row['type'] == "venue") {
                echo "<td>{$row['venue_name']}</td>";   //'venue_name' from venue table
            }
            
            echo "<td>{$row['registration_date']}</td>";
            echo "<td width='17%'>
                <a href='staff_assigned_list.php?event_id={$row['event_id']}'><button class='button primary small'
                    style='font-size:small; margin:auto; display:block; margin-bottom:5px;'>Check staff</button></a>
                <a href='staff_list.php?event_id={$row['event_id']}'><button class='button primary small' 
                    style='background-color:mediumseagreen; font-size:small; margin:auto; display:block;'>Assign staff</button></a>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
    </table>
</div>

<?php include("footer.php") ?>

