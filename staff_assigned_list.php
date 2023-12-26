<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    $query = "SELECT s.staff_id, s.staff_name, s.age, s.gender, s.email, CONCAT(s.address_street, ', ', s.address_city) AS address, s.position, GROUP_CONCAT(sp.phone SEPARATOR ', ') AS phones
            FROM staff s
            JOIN staff_phone sp ON s.staff_id = sp.staff_id
            WHERE s.s_event_id = $event_id
            GROUP BY s.staff_id, s.staff_name, s.age, s.gender, s.email, address, s.position";

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
		            <th>E-mail</th>
		            <th>Address</th>
		            <th>Position</th>
		            <th>Phone num.</th>
		            <th>Action</th>
                </tr>";

        $count = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$count."</td>";
            echo "<td>".$row['staff_id']."</td>";
            echo "<td>".$row['staff_name']."</td>";
            echo "<td>".$row['age']."</td>";
            echo "<td>".$row['gender']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['address']."</td>";
            echo "<td>".$row['position']."</td>";
            echo "<td>".$row['phones']."</td>";
            echo "<td><a href='javascript:deleteConfirm(".$row['staff_id'].", ".$event_id.")' class='button danger small'
                    style='font-size:small; font-weight:normal; margin:auto; display:block;'>Discharge</a></td>";
            echo "</tr>";
            $count++;
        }

        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='container' style='text-align: center; font-weight: bold;'></br>No staff was assigned to this event.</div>";
    }

} else {
    echo "<div class='container' style='text-align: center; font-weight: bold;'></br>Event ID not provided.</div>";
}
?>

<div class='container'>
    <a href='event_list_participants.php?manage=staff'>
        <button style='background-color:#f1f1f1; padding:8px; width:100px; border:none; font-weight:bold;
        transition: background-color 0.3s;' onmouseover="this.style.backgroundColor='#ddd'" onmouseout="this.style.backgroundColor='#f1f1f1'">
        &laquo; Previous</button></a>
</div>

<script>
function deleteConfirm(staff_id, event_id) {
    if (confirm("Do you want to discharge this staff member?")) {
        window.location.href = "staff_delete.php?staff_id=" + staff_id + "&event_id=" + event_id;
    }
}
</script>

<?php include("footer.php") ?>
