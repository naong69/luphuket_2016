<?php

if(isset($_REQUEST['login'])){
	if($_REQUEST['login']== 'secure'){
	
?>
<?xml version='1.0' encoding='UTF-8'?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Admin Back End</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<style type="text/css">
	div.container {
		margin-top: 30px;
	}
</style>
<script src="Chart.js"></script>
<script>
$.get( "get_message.php", function (j){
	index_json_obj = $.parseJSON(j);
	$.each(index_json_obj, function() {
		$('#message-table').append('<tr><td>'+this['id']+'</td><td>'+this['name']+'</td><td>'+this['email']+'</td><td>'+this['subject']+'</td><td>'+this['message']+'</td><td>'+this['date-time']+'</td></tr>');
	});

});
$.get( "get_validate_logs.php", function (j){
	index_json_obj = $.parseJSON(j);
	i = 1;
	$.each(index_json_obj, function() {
		$('#validate-logs-table').append('<tr><td>'+i+'</td><td>'+this['time_stamp']+'</td><td>'+this['os']+'</td><td>'+this['browser']+'</td><td>'+this['ip']+'</td><td>'+this['coor_xy']+'</td><td>'+this['build_up_index']+'</td></tr>');
		i++;
	});

});
</script>
</head>
<body>
<div class="container">
	<div role="tabpanel">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id="myTab">
      <li role="presentation"><a href="#validate" aria-controls="settings" role="tab" data-toggle="tab">Summary of Validate</a></li>
	  <li role="presentation"><a href="#validate-logs" aria-controls="settings" role="tab" data-toggle="tab">Validate Logs</a></li>
	  <li role="presentation"><a href="#feedback" aria-controls="settings" role="tab" data-toggle="tab">Feedback</a></li>
	</ul>

    <!-- Tab panes -->
    <div class="tab-content">
		
		<div class="tab-pane active" id="validate" >
			<div align="center">
				<h2>Summary</h2>
				<div id="buildingCatChart-container" style="width: 500px; height: 400px;">
					<canvas id="buildingCatChart" width="350" height="225"></canvas>
				</div>
				<script>
				var cat_data = null;
				var cat_color = null;
				$.post( "get_validate.php",{ get: 'cat' }, function (j){
					index_json_obj = $.parseJSON(j);
					cat_data = index_json_obj.count;
					cat_color = index_json_obj.color;
					var catData = {
						labels: [
							"อาคารพาณิช",
							"โรงงาน",
							"สถานที่เกี่ยวกับน้ำมันและก๊าซ",
							"โครงสร้างพื้นฐาน",
							"อาคารที่อยู่อาศัย",
							"อาคารสาธารณะ"
						],
						datasets: [
							{
								data: cat_data,
								backgroundColor: cat_color,
								hoverBackgroundColor: cat_color
							}]
					};
					var ctx = document.getElementById("buildingCatChart");	
					var buildingCatChart = new Chart(ctx, {
						type: 'pie',
						data: catData
					});	
				});
				
				</script>
				<div id="osChart-container" style="width: 500px; height: 400px;">
					<canvas id="osChart" width="350" height="225"></canvas>
				</div>
				<script>
				var os_data = null;
				var os_color = null;
				var os_label = null;
				$.post( "get_validate.php",{ get: 'os' }, function (j){
					index_json_obj = $.parseJSON(j);
					os_data = index_json_obj.count;
					os_color = index_json_obj.color;
					os_label = index_json_obj.label;
					var osData = {
					labels: os_label,
					datasets: [
						{
							data: os_data,
							backgroundColor: os_color,
							hoverBackgroundColor: os_color
						}]
					};
					var ctx = document.getElementById("osChart");	
					var osChart = new Chart(ctx, {
						type: 'doughnut',
						data: osData
					});
					
				});
				
				</script>
				<div id="browserChart-container" style="width: 500px; height: 400px;">
					<canvas id="browserChart" width="350" height="225"></canvas>
				</div>
				<script>
				var browser_data = null;
				var browser_color = null;
				var browser_label = null;
				$.post( "get_validate.php",{ get: 'browser' }, function (j){
					index_json_obj = $.parseJSON(j);
					browser_data = index_json_obj.count;
					browser_color = index_json_obj.color;
					browser_label = index_json_obj.label;
					var osData = {
					labels: browser_label,
					datasets: [
						{
							data: browser_data,
							backgroundColor: browser_color,
							hoverBackgroundColor: browser_color
						}]
					};
					var ctx = document.getElementById("browserChart");	
					var osChart = new Chart(ctx, {
						type: 'doughnut',
						data: osData
					});
					
				});
				
				</script>
				
			</div>
		</div>
		
		<div class="tab-pane" id="validate-logs" >
			<div align="center">
				<h2>Logs</h2>
				<table class="table table-hover legend-table text-left" id="validate-logs-table">
					<tr>
						<th>#</th>
						<th>time</th>
						<th>os</th>
						<th>browser</th>
						<th>ip</th>
						<th>coor-xy</th>
						<th>building type</th>
					</tr>
				</table>
			</div>
		</div>
		
		<div class= "tab-pane" id="feedback" >
			<div align="center">
				<h2>Message</h2>
				<table class="table table-hover legend-table text-left" id="message-table">
					<tr>
						<th>id</th>
						<th>name</th>
						<th>email</th>
						<th>subject</th>
						<th width="300px">message</th>
						<th>date-time</th>
					</tr>
				</table>
			</div>
		</div>

    </div>
  </div>

	
	
	
	
	
	
</div>
<script>
     $('#myTab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })   
</script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
<?php
	}
}
?>