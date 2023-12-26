<?php 
include(__DIR__ . "/header.php"); 
include(__DIR__ . "/config.php");   //데이터베이스 연결 설정파일
include(__DIR__ . "/util.php");     //유틸 함수
?>

<!DOCTYPE html>
<html>
<body>
    <div class="container">
        </br>
        <h2>Welcome to Event Flow!</h2>
        </br>
        <p style="font-size: larger;">This is an example website of the web application using Database (DB).</p></br>
        The ER Diagram for this website is as follows.</br></br>
        <p align="left"><img src="images/er_diagram.PNG" width="50%"></p></br>
		<strong>☆ To create an event select one of "host_id" and enter it in the corresponding input field in your event creation form.</strong></br></br>
        <strong>☆ To invite users (a.k.a. attendees) to your event, select one of "attendee_id" and enter it in the corresponding input field during attendee's invitation procedure.</strong></br></br>
        Therefore, please refer to the following tables which contain the information of hosts and potential event attendees.</br></br>
        <p align="left"><img src="images/host_table.PNG" width="65%"></p>
        <p align="left"><img src="images/attendee_table.PNG" width="65%"></p></br>
    </div>
</body>
</html>

<?php include(__DIR__ . "/footer.php"); ?>

