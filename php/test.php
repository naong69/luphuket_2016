<?php
	$link = mysqli_connect("localhost", "root", "luphuket", "luphuket");
	mysqli_set_charset ( $link , "utf8" );
	
	$sql = "SELECT DISTINCT `group_index`, `group_name_sub` FROM `all_index` WHERE `category_index` = 'B'";
	
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
} else if (!mysqli_query($link, $sql)) {
    printf("Errormessage: %s\n", mysqli_error($link));
} else {
	
	$result=mysqli_query($link,$sql)
	echo var_dump($result);
}

/* close connection */
mysqli_close($link);
?>