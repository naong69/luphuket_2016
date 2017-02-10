<?php
include('../php/connect.php');

// start query
$json_str = "";

$sql = "SELECT * FROM `validate_logs`";
if ($result=mysqli_query($link,$sql)){
	while ($row=mysqli_fetch_row($result)){
		$json_str = $json_str.'{"time_stamp":"'.$row[0].'","os":"'.$row[1].'","browser":"'.$row[2].'","ip":"'.$row[3].'","coor_xy":"'.$row[4].'","build_up_index":"'.$row[5].'"},';
	}
	// Free result set
	mysqli_free_result($result);
	
	$json_str = substr($json_str, 0, -1);
	$json_str = '['.$json_str.']';
	echo $json_str;
}

mysqli_close($link);

?>
