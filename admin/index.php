<?php
include('../php/connect.php');

// start query

$sql = "SELECT * FROM `feedbacks`";
if ($result=mysqli_query($link,$sql)){
	 

?>

<html>
<head>
<title>Admin-Message</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
	<div align="center">
		<h2>Message</h2>
		<table class="table table-hover legend-table text-left">
			<tr>
				<th>id</th>
				<th>name</th>
				<th>email</th>
				<th>subject</th>
				<th width="300px">message</th>
				<th>date-time</th>
			</tr>
		<?php
		while ($row=mysqli_fetch_row($result)){
		?>
			<tr>
				<td><?php echo $row[0]?></td>
				<td><?php echo $row[1]?></td>
				<td><?php echo $row[2]?></td>
				<td><?php echo $row[3]?></td>
				<td><?php echo $row[4]?></td>
				<td><?php echo $row[5]?></td>
			</tr>
		<?php
		}
		// Free result set
		mysqli_free_result($result);
		?>
		</table>
	</div>
</div>
<script>
    $(document).ready(function(){
        //init
        $("ul.subforums").hide();

        $("div .acts").click(function(){
			if($(this).parent().find("ul").is(":visible")){
				$(this).parent().find("ul").hide();
			} else {			
				$("ul.subforums").hide(); //hide all show ul
				$(this).parent().find("ul").toggle();
			}
        });
    });    
</script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
<?php

mysqli_close($link);

} // if isset

?>
