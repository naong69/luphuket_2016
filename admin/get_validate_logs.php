<?php
if(isset($_REQUEST['time'])){
include('../php/connect.php');

$time = $_REQUEST['time'];
// start query
$json_str = "";

if($time == 'a'){
	$sql = "SELECT `validate_logs`.*, `all_index`.`category_name`, `all_index`.`group_name_sub`, `all_index`.`oper_prod_name_sub` FROM `validate_logs` LEFT JOIN `all_index` ON `validate_logs`.`build_up_index` = `all_index`.`indexID` ORDER BY `validate_logs`.`time_stamp` DESC ";
} else {
	$sql = "SELECT `validate_logs`.*, `all_index`.`category_name`, `all_index`.`group_name_sub`, `all_index`.`oper_prod_name_sub` FROM `validate_logs` LEFT JOIN `all_index` ON `validate_logs`.`build_up_index` = `all_index`.`indexID` WHERE `time_stamp` BETWEEN DATE_ADD(CURDATE(), INTERVAL -".$time." DAY) AND CURDATE() ORDER BY `time_stamp` DESC";
}

if ($result=mysqli_query($link,$sql)){
	while ($row=mysqli_fetch_row($result)){
		$json_str = $json_str.'{"time_stamp":"'.$row[0].'","os":"'.$row[1].'","browser":"'.$row[2].'","ip":"'.$row[3].'","coor_xy":"'.$row[4].'","build_up_index":"'.$row[5].'","category_name":"'.$row[6].'","group_name_sub":"'.$row[7].'","oper_prod_name_sub":"'.$row[8].'"},';
	}
	// Free result set
	mysqli_free_result($result);
	
	$json_str = substr($json_str, 0, -1);
	$json_str = '['.$json_str.']';
	echo $json_str;
}

mysqli_close($link);
}
?>
