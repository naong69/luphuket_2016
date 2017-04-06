<?php
if(isset($_REQUEST['time'])){
include('../php/connect.php');

$time = $_REQUEST['time'];
// start query
$json_str = "";

if($time == 'a'){
	$sql = "SELECT `landuse_phuket`.`validate_logs`.*, `landuse_phuket`.`all_index`.`category_name`, `landuse_phuket`.`all_index`.`group_name_sub`, `landuse_phuket`.`all_index`.`oper_prod_name_sub` FROM `landuse_phuket`.`validate_logs` LEFT JOIN `landuse_phuket`.`all_index` ON `landuse_phuket`.`validate_logs`.`build_up_index` = `landuse_phuket`.`all_index`.`indexID` ORDER BY `landuse_phuket`.`validate_logs`.`time_stamp` DESC";
} else {
	$sql = "SELECT `landuse_phuket`.`validate_logs`.*, `landuse_phuket`.`all_index`.`category_name`, `landuse_phuket`.`all_index`.`group_name_sub`, `landuse_phuket`.`all_index`.`oper_prod_name_sub` FROM `landuse_phuket`.`validate_logs` LEFT JOIN `landuse_phuket`.`all_index` ON `landuse_phuket`.`validate_logs`.`build_up_index` = `landuse_phuket`.`all_index`.`indexID` WHERE `landuse_phuket`.`validate_logs`.`time_stamp` BETWEEN DATE_ADD(CURDATE(), INTERVAL -".$time." DAY) AND CURDATE() ORDER BY `landuse_phuket`.`validate_logs`.`time_stamp` DESC";
}

if ($result=mysqli_query($link,$sql)){
	while ($row=mysqli_fetch_row($result)){
		$json_str = $json_str.'{"time_stamp":"'.$row[1].'","os":"'.$row[2].'","browser":"'.$row[3].'","ip":"'.$row[4].'","coor_xy":"'.$row[5].'","build_up_index":"'.$row[6].'","category_name":"'.$row[7].'","group_name_sub":"'.$row[8].'","oper_prod_name_sub":"'.$row[9].'"},';
	}
	// Free result set
	mysqli_free_result($result);
	
	$json_str = substr($json_str, 0, -1);
	$json_str = '['.$json_str.']';
	echo $json_str;
} else 

mysqli_close($link);
}
?>
