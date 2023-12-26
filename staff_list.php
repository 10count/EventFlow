<?php
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?php
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    //$event_id = $_GET['event_id'];
    $query = "SELECT s.staff_id, s.staff_name, s.age, s.gender, CONCAT(s.address_street, ', ', s.address_city) AS address, s.email, s.position, GROUP_CONCAT(sp.phone SEPARATOR ', ') AS phones, s.s_event_id
            FROM staff AS s
            LEFT JOIN staff_phone AS sp ON s.staff_id = sp.staff_id
            WHERE s.s_event_id IS NULL
            GROUP BY s.staff_id";
    $result = mysqli_query($conn, $query);
    if (!$result) {
         die('Query Error: ' . mysqli_connect_error());
    }
    ?>
    <form name='staff' action='staff_assign.php' method="post" onsubmit="return validateForm()">
        <input type="hidden" name="event_id" value="<?php echo $_GET['event_id']; ?>">
        </br>
        <table class="table table-striped table-bordered">
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Position</th>
                <th>E-mail</th>
                <th>Phone num.</th>
                <th>Assign to event</th>
            </tr>
            <?php
            $row_index = 1;
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>{$row_index}</td>";
                echo "<td>{$row['staff_name']}</td>";
                echo "<td>{$row['age']}</td>";
                echo "<td>{$row['gender']}</td>";
                echo "<td>{$row['address']}</td>";
                echo "<td>{$row['position']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['phones']}</td>";
                echo "<td width='14%'>
                    <input type='checkbox' name='staff_id[]' value='{$row['staff_id']}'>
                    </td>";
                echo "</tr>";
                $row_index++;
            }
            ?>
        </table>

        <div align='center'>
            <input type='submit' class='button primary small' value='Assign to event'>
        </div>
    </form>

    <div>
        <a href='event_list_participants.php?manage=staff'>
            <button style='background-color:#f1f1f1; padding:8px; width:100px; border:none; font-weight:bold;
            transition: background-color 0.3s; margin-top:5px;' onmouseover="this.style.backgroundColor='#ddd'" onmouseout="this.style.backgroundColor='#f1f1f1'">
            &laquo; Previous</button>
        </a>
    </div>
</div>

<?php include("footer.php") ?>

<script>
function validateForm() {
    var checkboxes = document.getElementsByName('staff_id[]');
    var checked = false;
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checked = true;
            break;
        }
    }
    if (!checked) {
        alert("Choose staff member to assign to event.");
        return false;
    }
    return true;
}
</script>
