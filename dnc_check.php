<?

$phone_number = $_POST['phone_number'];
$con = mysqli_connect("localhost","cron","1234","asterisk");

$query = "SELECT COUNT(phone_number) FROM vicidial_list_dnc WHERE phone_number = '$phone_number'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_row($result);
$count = $row[0];
if($count != 0){
	$dnc = 'TRUE';
}else{
	$dnc = 'FALSE';
}


$container['dnc_result'] = $dnc;
echo json_encode($container);


?>

