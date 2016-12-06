<?php

if(isset($_REQUEST['data'])&& isset($_REQUEST['index'])){

$data = $_REQUEST['data'];
$index = $_REQUEST['index'];

$map = array();
$zone = array();

foreach (explode(",", $data) as $value){
  $mz = explode(":", $value);
  array_push($map, explode(".", $mz[0])[0]);
  array_push($zone,str_replace(".","_",$mz[1]));
}

include('connect.php');

// start query

$strSQL = "SELECT * FROM all_index WHERE indexID = '".$index."' ";
$objQuery = mysqli_query($link, $strSQL);
$objResult = mysqli_fetch_array($objQuery);

$cat_name = $objResult[2];
$group_name = $objResult[4];
$opr_name = $objResult[7];


$enval = $cpval = $bc20val = $bc15val = $muval = 1;


    /*==Environment=============================================================================================================================================================================*/
              
if(in_array("pk_en_act_2553",$map)){
	$key = array_search("pk_en_act_2553",$map);	
	
	// validate
	$strSQL = "SELECT A.zone_".$zone[$key]." FROM `en_validate_matrix` as A WHERE indexID = '".$index."'";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enval = $objResult[0];
	
    //Factory Restriction
    $strSQL = "SELECT B.dec FROM `en_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_factory_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enFacRes = $objResult[0];

    //Exception
    $strSQL = "SELECT B.dec FROM `en_exception_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_exception` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enExcepRes = $objResult[0];

    //Area Restriction
    $strSQL = "SELECT B.dec FROM `en_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_area_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enAreaRes = $objResult[0];

    //EIA Restriction
    $strSQL = "SELECT B.dec FROM `en_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_eia_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enEiaRes =  $objResult[0];

    //Height Restriction
    $strSQL = "SELECT B.dec FROM `en_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_height_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enHeightRes = $objResult[0];

    //Slope Restriction
    $strSQL = "SELECT B.dec FROM `en_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_slope_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enSlopeRes = $objResult[0];
	
}


    /*===CityPlan================================================================================================================================================================================*/
            
if(in_array("pk_cp_act_2558",$map)){
	$key = array_search("pk_cp_act_2558",$map);	
	
	// validate
	
	$strSQL = "SELECT A.zone_".$zone[$key]." FROM `cp_validate_matrix` as A WHERE indexID = '".$index."'";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $cpval = $objResult[0];
	
    //Factory Restriction
    $strSQL = "SELECT B.dec FROM `cp_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `cp_factory_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $cpFacRes = $objResult[0];

    //Area Restriction
    $strSQL = "SELECT B.dec FROM `cp_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `cp_area_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $cpAreaRes = $objResult[0];

    //Exception
    $strSQL = "SELECT B.dec FROM `cp_exception_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `cp_exception` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $cpExcepRes = $objResult[0];
               
}               
               
    /*===BuildingControl20==========================================================================================================================================================================*/

if(in_array("pk_bc20_act_2532",$map)){
	$key = array_search("pk_bc20_act_2532",$map);	
	
	// validate
	$strSQL = "SELECT A.zone_".$zone[$key]." FROM `bc20_validate_matrix` as A WHERE indexID = '".$index."'";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc20val = $objResult[0];
	
    //Factory Restriction
    $strSQL = "SELECT B.dec FROM `bc20_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc20_factory_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc20FacRes = $objResult[0];

    //Height Restriction
    $strSQL = "SELECT B.dec FROM `bc20_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc20_height_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc20HeightRes = $objResult[0];

    //Area Restriction
    $strSQL = "SELECT B.dec FROM `bc20_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc20_area_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc20AreaRes = $objResult[0];

    //Result Area Restriction
    $strSQL = "SELECT B.dec FROM `bc20_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc20_result_area_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc20ResulRes = $objResult[0];
    
}
    /*===BuildingControl15======================================================================================================================================================================================*/


if(in_array("pk_bc15_act_2529",$map)){
	$key = array_search("pk_bc15_act_2529",$map);	
	
	// validate
	$strSQL = "SELECT A.zone_".$zone[$key]." FROM `bc15_validate_matrix` as A WHERE indexID = '".$index."'";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc15val = $objResult[0];
	
    //Factory Restriction
    $strSQL = "SELECT B.dec FROM `bc15_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc15_factory_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc15FacRes = $objResult[0];

    //Height Restriction
    $strSQL = "SELECT B.dec FROM `bc15_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc15_height_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc15heightRes = $objResult[0];
    
    //Area Restriction
    $strSQL = "SELECT B.dec FROM `bc15_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc15_area_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc15AreaRes = $objResult[0];
}

    /*===MunicipalPathong=================================================================================================================================================================================================*/

if(in_array("pk_patong_lu_act_2548",$map)){
	$key = array_search("pk_patong_lu_act_2548",$map);	
	
	// validate
	$strSQL = "SELECT A.zone_".$zone[$key]." FROM `mu_validate_matrix` as A WHERE indexID = '".$index."'";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $muval = $objResult[0];
	
    //Factory Restriction
    $strSQL = "SELECT B.dec FROM `mu_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `mu_factory_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $muFacRes = $objResult[0];

    //Area Restriction
    $strSQL = "SELECT B.dec FROM `mu_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `mu_area_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $muAreaRes = $objResult[0];

}


?>

<html>
<head>
<title>ตรวจสอบสิ่งปลูกสร้าง</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<style type="text/css">

	li span, dd span{
		font-size : 16px;
	}

	li span.val {
		font-weight : bold;
	}
	button span {
		font-size : 18px;
	}
	
	.container {
		height: 650px;
	}
	
	div .acts {
		text-align: center;
		cursor: pointer;
	}
	
	div .act-label {
		display: inline-block;
		font-size : 18px;
	}
	
	.subforms {
		overflow-x: visible;
		overflow-y: visible;
	}

</style>
</head>
<body>
<div class="container">
	<div align="center">
		<h3>ผลการตรวจสอบ: 
		<?php  
		 echo ($enval && $cpval && $bc20val && $bc15val && $muval)?  "<font color='green'><b>สร้างได้</b></font>": "<font color='red'><b>สร้างไม่ได้</b></font>";
		?>
		</h3>
		<div class="text-left">
		<b>กลุ่ม: </b><?php echo $cat_name?><br>
		<b>ประเภท: </b><?php echo $group_name?><br>
		<b>กิจการ: </b><?php echo $opr_name?>
		</div>
		<hr>
	</div>
	<?php  if(in_array("pk_en_act_2553",$map)){ ?>
    <div class="span9 btn-block">
		<div class="acts alert <?php echo($enval)? "alert-success" : "alert-danger" ?>" role="alert"><div class="act-label">กฏหมายสิ่งแวดล้อม พ.ศ. ๒๕๕๓</div></div>
        <ul id="subforms1" class="subforums" style="padding: 10px 10px; list-style: none;">
			<li><span class="val" >ผลการตรวจสอบ: </span> <?php echo($enval)? "<span style='color: green; font-size: 16px; '><b>สร้างได้</b></span>" : "<span style='color: red; font-size: 16px; '><b>สร้างไม่ได้</b></span>" ?></li>
			<li><span><b>ข้อยกเว้น:</b> <?php echo $enExcepRes ?> </span> </li>
			<li><span><b>ข้อจำกัด:</b></span>
				<dd><span><b>โรงงาน:</b> <?php echo $enFacRes ?></span></dd>
				<dd><span><b>ความสูง:</b> <?php echo $enHeightRes ?></span></dd>
				<dd><span><b>พื้นที่:</b> <?php echo $enAreaRes ?></span></dd>
				<dd><span><b>ความลาดชัน:</b> <?php echo $enSlopeRes ?></span></dd>
				<dd><span><b>ผลกระทบสิ่งแวดล้อม:</b> <?php echo $enEiaRes ?></span></dd>
			</li>
		</ul>
    </div>
	<?php } ?>
	<?php  if(in_array("pk_cp_act_2558",$map)){ ?>
     <div class="span9 btn-block">
        <div class="acts alert <?php echo($cpval)? "alert-success" : "alert-danger" ?>" role="alert"><div class="act-label">กฏหมายผังเมืองรวม พ.ศ. ๒๕๕๘</div></div>
		<ul id="subforms2" class="subforums" style="padding: 10px 10px; list-style: none;">
			<li><span class="val" >ผลการตรวจสอบ: </span> <?php echo($cpval)? "<span style='color: green; font-size: 16px; '><b>สร้างได้</b></span>" : "<span style='color: red; font-size: 16px; '><b>สร้างไม่ได้</b></span>" ?></li>
			<li><span><b>ข้อยกเว้น:</b> <?php echo $enExcepRes ?> </span> </li>
			<li><span><b>ข้อจำกัด:</b></span>
				<dd><span><b>โรงงาน:</b> <?php echo $cpFacRes ?></span></dd>
				<dd><span><b>พื้นที่:</b> <?php echo $cpAreaRes ?></span></dd>
			</li>
		</ul>
	</div>
	<?php } ?>
	<?php  if(in_array("pk_bc20_act_2532",$map)){ ?>
     <div class="span9 btn-block">
        <div class="acts alert <?php echo($bc20val)? "alert-success" : "alert-danger" ?>" role="alert"><div class="act-label">กฏหมายควบคุมอาคาร ฉบับที่ ๒๐ (พ.ศ. ๒๕๓๒)</div></div>
		<ul id="subforms3" class="subforums" style="padding: 10px 10px; list-style: none;">
			<li><span class="val" >ผลการตรวจสอบ: </span> <?php echo($bc20val)? "<span style='color: green; font-size: 16px; '><b>สร้างได้</b></span>" : "<span style='color: red; font-size: 16px; '><b>สร้างไม่ได้</b></span>" ?></li>
			<li><span><b>ข้อยกเว้น:</b> <?php echo $enExcepRes ?> </span> </li>
			<li><span><b>ข้อจำกัด:</b></span>
				<dd><span><b>โรงงาน:</b> <?php echo $bc20FacRes ?></span></dd>
				<dd><span><b>ความสูง:</b> <?php echo $bc20HeightRes ?></span></dd>
				<dd><span><b>พื้นที่ว่าง:</b> <?php echo $bc20AreaRes ?></span></dd>
				<dd><span><b>พื้นที่รวม:</b> <?php echo $bc20ResulRes ?></span></dd>
			</li>
		</ul>
    </div>
	<?php } ?>
	<?php  if(in_array("pk_bc15_act_2529",$map)){ ?>
     <div class="span9 btn-block">
        <div class="acts alert <?php echo($bc15val)? "alert-success" : "alert-danger" ?>" role="alert"><div class="act-label">กฏหมายควบคุมอาคาร  ฉบับที่ ๑๕ (พ.ศ. ๒๕๒๙) </div></div>
		<ul id="subforms4" class="subforums" style="padding: 10px 10px; list-style: none;">
		<li><span class="val" >ผลการตรวจสอบ: </span> <?php echo($bc15val)? "<span style='color: green; font-size: 16px; '><b>สร้างได้</b></span>" : "<span style='color: red; font-size: 16px; '><b>สร้างไม่ได้</b></span>" ?></li>
			<li><span><b>ข้อยกเว้น:</b> <?php echo $enExcepRes ?> </span> </li>
			<li><span><b>ข้อจำกัด:</b></span>
				<dd><span><b>โรงงาน:</b> <?php echo $bc15FacRes ?></span></dd>
				<dd><span><b>ความสูง:</b> <?php echo $bc15heightRes ?></span></dd>
				<dd><span><b>พื้นที่:</b> <?php echo $bc15AreaRes ?></span></dd>
			</li>
		</ul>
    </div>
	<?php } ?>
	<?php  if(in_array("pk_patong_lu_act_2548",$map)){ ?>
     <div class="span9 btn-block">
        <div class="acts alert <?php echo($muval)? "alert-success" : "alert-danger" ?>" role="alert"><div class="act-label">เทศบัญญัติเทศบาลเมืองป่าตอง พ.ศ. ๒๕๔๘</div></div>
		<ul id="subforms5" class="subforums" style="padding: 10px 10px; list-style: none;">
			<li><span class="val" >ผลการตรวจสอบ: </span> <?php echo($muval)? "<span style='color: green; font-size: 16px; '><b>สร้างได้</b></span>" : "<span style='color: red; font-size: 16px; '><b>สร้างไม่ได้</b></span>" ?></li>
			<li><span><b>ข้อยกเว้น:</b> <?php echo $enExcepRes ?> </span> </li>
			<li><span><b>ข้อจำกัด:</b></span>
				<dd><span><b>โรงงาน:</b> <?php echo $muFacRes ?></span></dd>
				<dd><span><b>พื้นที่:</b> <?php echo $muAreaRes ?></span></dd>
			</li>
		</ul>
    </div>
	<?php } ?>
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

mysqli_free_result($objQuery);

mysqli_close($link);

} // if isset

?>
