<?php
include('../php/connect.php');

// start query
$json_str = "";

$sql = "SELECT * FROM `feedbacks`";
if ($result=mysqli_query($link,$sql)){
	while ($row=mysqli_fetch_row($result)){
		$json_str = $json_str.'{"id":"'.$row[0].'","name":"'.$row[1].'","email":"'.$row[2].'","subject":"'.$row[3].'","message":"'.$row[4].'","date-time":"'.$row[5].'"},';
	}
	// Free result set
	mysqli_free_result($result);
	
	$json_str = substr($json_str, 0, -1);
	$json_str = '['.$json_str.']';
	echo $json_str;
}

mysqli_close($link);

?>
