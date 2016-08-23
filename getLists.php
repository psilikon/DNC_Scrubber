<?php
$con = mysqli_connect("localhost","cron","1234","asterisk");
$query = "SELECT list_id, list_name, list_description FROM vicidial_lists ORDER BY list_id";
$result = mysqli_query($con, $query);
$rowArray = array();
while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
	$rowArray[] = $row;
}
echo json_encode($rowArray);
?>
