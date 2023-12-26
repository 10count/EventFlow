<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    $query = "SELECT a.attendee_id, a.attendee_name, a.age, a.gender, a.email, CONCAT(a.address_street, ', ', a.address_city) AS address, GROUP_CONCAT(ai.interest SEPARATOR ', ') AS interests
              FROM attendee a
              INNER JOIN attend at ON a.attendee_id = at.attendee_id
              LEFT JOIN attendee_interest ai ON a.attendee_id = ai.attendee_id
              WHERE at.event_id = $event_id
              GROUP BY a.attendee_id";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<div class='container'>";
        echo "<table class='table table-striped table-bordered'></br>
                <tr>
                    <th>No.</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Interests</th>
                    <th>Manage</th>
                </tr>";

        $count = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$count."</td>";
            echo "<td>".$row['attendee_id']."</td>";
            echo "<td>".$row['attendee_name']."</td>";
            echo "<td>".$row['age']."</td>";
            echo "<td>".$row['gender']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['address']."</td>";
            echo "<td>".$row['interests']."</td>";
            echo "<td><a href='javascript:deleteConfirm(".$row['attendee_id'].", ".$event_id.")' class='button danger small' 
                    style='font-size:small; font-weight:normal; text-align:center; margin:auto; display:block;'>Remove</a></td>";
            echo "</tr>";
            $count++;
        }

        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='container' style='text-align: center; font-weight: bold;'></br>No attendees found for this event.</div>";
    }

} else {
    echo "<div class='container' style='text-align: center; font-weight: bold;'></br>Event ID is not provided.</div>";
}
?>

<div class='container'>
    <a href='event_list_participants.php?manage=attendees'>
        <button style='background-color:#f1f1f1; padding:8px; width:100px; border:none; font-weight:bold;
		transition: background-color 0.3s;' onmouseover="this.style.backgroundColor='#ddd'" onmouseout="this.style.backgroundColor='#f1f1f1'">
		&laquo; Previous</button>
	</a>
</div>


<script>
function deleteConfirm(attendee_id, event_id) {
    if (confirm("Do you want to remove this attendee?")) {
        window.location.href = "attendee_delete.php?attendee_id=" + attendee_id + "&event_id=" + event_id;
    }
}
</script>

<?php include("footer.php") ?>
