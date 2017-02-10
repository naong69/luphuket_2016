<?php
include('../php/connect.php');

// start query

$colorArray = array("#FF6384", "#983ef2", "#f44242", "#36A2EB", "#3ef27a","#FFCE56", "#ff8000", "#ffff00" ,"#ff4000", "#40ff00", "#bf00ff");


if(isset($_REQUEST['get'])){
	
	$get = $_REQUEST['get'];
	
	// get building cat count
	if($get == 'cat'){
		$B = $F = $G = $I = $L = $P = 0;
		$sql = "SELECT SUBSTRING(`build_up_index`, 1, 1) as type, COUNT(*)AS count FROM `validate_logs` GROUP BY SUBSTRING(`build_up_index`, 1, 1) ORDER by type";
		if ($result=mysqli_query($link,$sql)){
			while ($row=mysqli_fetch_row($result)){
				if($row[0] == 'B') {$B = $row[1];}
				if($row[0] == 'F') {$F = $row[1];}
				if($row[0] == 'G') {$G = $row[1];}
				if($row[0] == 'I') {$I = $row[1];}
				if($row[0] == 'L') {$L = $row[1];}
				if($row[0] == 'P') {$P = $row[1];}
			}
		} 
		// Free result set
		mysqli_free_result($result);
		$cat_count = "[".$B.", ".$F.", ".$G.", ".$I.", ".$L.", ".$P."]";
		$cat_color = '["#FF6384", "#983ef2", "#f44242", "#36A2EB", "#3ef27a","#FFCE56"]';
		$json_str = '{"count" : '.$cat_count.', "color" : '.$cat_color.'}';
		echo $json_str;
	}
	
	// get os count
	if($get == 'os'){
		$os_count = "";
		$os_color = "";
		$os_label = "";
		$sql = "SELECT `os` as os, COUNT(*)AS count FROM `validate_logs` GROUP BY `os` ORDER by os";
		
		if ($result=mysqli_query($link,$sql)){
			$i=0;
			while ($row=mysqli_fetch_row($result)){
				$os_count = $os_count.$row[1].",";
				$os_color = $os_color.'"'.$colorArray[$i].'",';
				$os_label = $os_label.'"'.$row[0].'",';
				$i++;
			}
		} 
		// Free result set
		mysqli_free_result($result);
		$os_count = substr($os_count,0,-1);
		$os_count = "[".$os_count."]";
		$os_color = substr($os_color,0,-1);
		$os_color = "[".$os_color."]";
		$os_label = substr($os_label,0,-1);
		$os_label = "[".$os_label."]";
		$json_str = '{"count" : '.$os_count.', "color" : '.$os_color.', "label" : '.$os_label.'}';
		echo $json_str;
	}
	
	// get browser count
	if($get == 'browser'){
		$browser_count = "";
		$browser_color = "";
		$browser_label = "";
		$sql = "SELECT `browser` as browser, COUNT(*)AS count FROM `validate_logs` GROUP BY `browser` ORDER by browser";
		
		if ($result=mysqli_query($link,$sql)){
			$i=0;
			while ($row=mysqli_fetch_row($result)){
				$browser_count = $browser_count.$row[1].",";
				$browser_color = $browser_color.'"'.$colorArray[$i].'",';
				$browser_label = $browser_label.'"'.$row[0].'",';
				$i++;
			}
		} 
		// Free result set
		mysqli_free_result($result);
		$browser_count = substr($browser_count,0,-1);
		$browser_count = "[".$browser_count."]";
		$browser_color = substr($browser_color,0,-1);
		$browser_color = "[".$browser_color."]";
		$browser_label = substr($browser_label,0,-1);
		$browser_label = "[".$browser_label."]";
		$json_str = '{"count" : '.$browser_count.', "color" : '.$browser_color.', "label" : '.$browser_label.'}';
		echo $json_str;
	}
	
	
	
}





mysqli_close($link);

?>
