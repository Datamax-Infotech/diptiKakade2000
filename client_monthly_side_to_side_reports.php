<?php
require ("../mainfunctions/database.php");
require ("../mainfunctions/general-functions.php");
//require ("inc/header_session.php");

// set_time_limit(0);	
// ini_set('memory_limit', '-1');

function getnickname_warehouse(string $warehouse_name, int $loopid): string {
	$nickname = "";
	if ($loopid > 0) {
		db_b2b();
		$sql = "SELECT nickname, company, shipCity, shipState FROM companyInfo where loopid = ?";
		$result_comp = db_query($sql , array("i"), array($loopid));
		while ($row_comp = array_shift($result_comp)) {
			if ($row_comp["nickname"] != "") {
				$nickname = $row_comp["nickname"];
			} else {
				$tmppos_1 = strpos($row_comp["company"], "-");
				if ($tmppos_1 != false) {
					$nickname = $row_comp["company"];
				} else {
					if ($row_comp["shipCity"] <> "" || $row_comp["shipState"] <> "" ) {
						$nickname = $row_comp["company"] . " - " . $row_comp["shipCity"] . ", " . $row_comp["shipState"] ;
					} else {
						$nickname = $row_comp["company"];
					}
				}
			}
		}
	} else {
		$nickname = $warehouse_name;
	}
	
	return $nickname;
}

?>
<!DOCTYPE html>

<html>
	<head>
		<title>Contracted Clients Monthly Reports Side to Side</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>		
		<link rel="stylesheet" type="text/css" href="css/sop-styles.css" />
		<style type="text/css">
			body {
				margin-left: 0px;
				margin-top: 0px;
				margin-right: 0px;
				margin-bottom: 0px;
				padding: 0px 20px;
			}	
		
			.fa-search-child {
				position: absolute;
				margin-left: 10px;
				left: 10px;
			}	
			.labelStyle, .search_btn1{
				font-size: 12px;
		    margin-top: 2px;
		    margin-bottom: 2px;
		    font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
			}
		</style>
		<script type="text/javascript">
			function showdetails(tmpcnt) {
				if (document.getElementById("div_detail" + tmpcnt).style.display == 'block') 
				{
					document.getElementById("div_detail" + tmpcnt).style.display = "none";	
				}else{
					document.getElementById("div_detail" + tmpcnt).style.display = "block";	
				}
			}
		</script>
    <script>
			function checkValAndSubmit(){
				var client = document.getElementById('client');
				var ddMonthFrom = document.getElementById('ddMonthFrom');
				var ddYearFrom	= document.getElementById('ddYearFrom');
				var ddMonthTo 	= document.getElementById('ddMonthTo');
				var ddYearTo 	= document.getElementById('ddYearTo');
				if(client.value == '-'){
					alert("Select the client.");
					client.focus();
					return false;
				}
				if(ddMonthFrom.value == '-'){
					alert("Select the from month.");
					ddMonthFrom.focus();
					return false;
				}
				if(ddYearFrom.value == '-'){
					alert("Select the from year.");
					ddYearFrom.focus();
					return false;
				}
				if(ddMonthTo.value == '-'){
					alert("Select the to month.");
					ddMonthTo.focus();
					return false;
				}
				if(ddYearTo.value == '-'){
					alert("Select the to year.");
					ddYearTo.focus();
					return false;
				}
				if(ddYearTo.value < ddYearFrom.value){
					alert("Selected to year is always greater than the from year.");
					ddYearTo.focus();
					return false;
				}
			}
		</script>
		<LINK rel='stylesheet' type='text/css' href='one_style.css' >
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>
	</head>
	<body>
		<?php include("inc/header.php"); ?>

<div class="main_data_css">
	<div class="dashboard_heading" style="float: left;">
		<div style="float: left;">Contracted Clients Monthly Reports Side to Side
		<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
		<span class="tooltiptext">
			Contracted Clients Monthly Reports Side to Side
		</span></div>
		
		<div style="height: 13px;">&nbsp;</div>				
		</div>
	</div>
	
			<div style="padding-left:20px;padding-right:20px">	
				<table width="99%" border="0" cellspacing="0" cellpadding="0">
				  <tbody>
						<tr>
					  	<td>
							  <form method="post" name="search_frm" action="client_monthly_side_to_side_reports_data.php">
							  	<table>
							  		<tr>
							  			<td>
							  				<label class="labelStyle">Client:</label>
							  			</td>
							  			<td>
							  				<?php
											db_b2b();
							  				$getClientLists = db_query("SELECT loopid as id, company, nickname FROM companyInfo where ucbzw_account_status = 83 ORDER BY nickname ASC");
							  				?>
											<select name="client[]" id="client" multiple>
												<?php
												while($rowsClientLists = array_shift($getClientLists)){
													$warehouse_id = $rowsClientLists["id"];
													
													//$company_name = getnickname_warehouse($resultRow["company"], $warehouse_id)
													
													if ($rowsClientLists["nickname"] == ""){
														$company_name = $rowsClientLists["company"];
													}else{
														$company_name = $rowsClientLists["nickname"];
													}	

													?>
														<option <?php if ($_REQUEST["client"] == $warehouse_id) echo " selected ";?> value="<?php echo $warehouse_id;?>"><?php echo $company_name;?></option>
													<?php
												}
												?>
											</select>
							  			</td>
							  		</tr>
							  		<tr>
							  			<td>
							  				<label class="labelStyle">Report Start Month</label>
							  			</td>
							  			<td>
							  				<select name="ddMonthFrom" id="ddMonthFrom" class="ser_form_component dd_style">
													<option value="-">Select</option>
													<option value="01" <?php if($_REQUEST['ddMonthFrom'] == '01'){ echo "selected";}?>>January</option>
													<option value="02" <?php if($_REQUEST['ddMonthFrom'] == '02'){ echo "selected";}?>>February</option>
													<option value="03" <?php if($_REQUEST['ddMonthFrom'] == '03'){ echo "selected";}?>>March</option>
													<option value="04" <?php if($_REQUEST['ddMonthFrom'] == '04'){ echo "selected";}?>>April</option>
													<option value="05" <?php if($_REQUEST['ddMonthFrom'] == '05'){ echo "selected";}?>>May</option>
													<option value="06" <?php if($_REQUEST['ddMonthFrom'] == '06'){ echo "selected";}?>>June</option>
													<option value="07" <?php if($_REQUEST['ddMonthFrom'] == '07'){ echo "selected";}?>>July</option>
													<option value="08" <?php if($_REQUEST['ddMonthFrom'] == '08'){ echo "selected";}?> >August</option>
													<option value="09" <?php if($_REQUEST['ddMonthFrom'] == '09'){ echo "selected";}?>>September</option>
													<option value="10" <?php if($_REQUEST['ddMonthFrom'] == '10'){ echo "selected";}?>>October</option>
													<option value="11" <?php if($_REQUEST['ddMonthFrom'] == '11'){ echo "selected";}?>>November</option>
													<option value="12" <?php if($_REQUEST['ddMonthFrom'] == '12'){ echo "selected";}?>>December</option>
												</select>	
							  			</td>
							  		</tr>
							  		<tr>
							  			<td>
							  				<label class="labelStyle">Report Start Year</label>
							  			</td>
							  			<td>
							  				<select name="ddYearFrom" id="ddYearFrom" class="ser_form_component dd_style">
													<option value="-">Select FROM YEAR</option>
													<?php for($i = 3; $i > 0; $i--){ ?>
														<option value="<?php echo date("Y",strtotime("-$i year"));?>" <?php if($_REQUEST['ddYearFrom'] == date("Y",strtotime("-$i year")) ){ echo "selected"; } ?> ><?php echo date("Y",strtotime("-$i year"));?></option>
													<?php }  ?>
													<option value="<?php echo date("Y");?>" <?php if($_REQUEST['ddYearFrom'] == date("Y")){ echo "selected"; } ?> > <?php echo date("Y");?></option>
													<option value="<?php echo date("Y",strtotime("+1 year"));?>" <?php if($_REQUEST['ddYearFrom'] == date("Y",strtotime("+1 year")) ){ echo "selected"; } ?> ><?php echo date("Y",strtotime("+1 year"));?></option>
												</select>	
							  			</td>
							  		</tr>
							  		<tr>
							  			<td>
							  				<label class="labelStyle">Report End Month</label>
							  			</td>
							  			<td>
							  				<select name="ddMonthTo" id="ddMonthTo" class="ser_form_component dd_style">
													<option value="-">Select</option>
													<option value="01" <?php if($_REQUEST['ddMonthTo'] == '01'){ echo "selected";}?>>January</option>
													<option value="02" <?php if($_REQUEST['ddMonthTo'] == '02'){ echo "selected";}?>>February</option>
													<option value="03" <?php if($_REQUEST['ddMonthTo'] == '03'){ echo "selected";}?>>March</option>
													<option value="04" <?php if($_REQUEST['ddMonthTo'] == '04'){ echo "selected";}?>>April</option>
													<option value="05" <?php if($_REQUEST['ddMonthTo'] == '05'){ echo "selected";}?>>May</option>
													<option value="06" <?php if($_REQUEST['ddMonthTo'] == '06'){ echo "selected";}?>>June</option>
													<option value="07" <?php if($_REQUEST['ddMonthTo'] == '07'){ echo "selected";}?>>July</option>
													<option value="08" <?php if($_REQUEST['ddMonthTo'] == '08'){ echo "selected";}?>>August</option>
													<option value="09" <?php if($_REQUEST['ddMonthTo'] == '09'){ echo "selected";}?>>September</option>
													<option value="10" <?php if($_REQUEST['ddMonthTo'] == '10'){ echo "selected";}?>>October</option>
													<option value="11" <?php if($_REQUEST['ddMonthTo'] == '11'){ echo "selected";}?>>November</option>
													<option value="12" <?php if($_REQUEST['ddMonthTo'] == '12'){ echo "selected";}?>>December</option>
												</select>
							  			</td>
							  		</tr>
							  		<tr>
							  			<td>
							  				<label class="labelStyle">Report End Year</label>
							  			</td>
							  			<td>
							  				<select name="ddYearTo" id="ddYearTo" class="ser_form_component dd_style">
													<option value="-">Select TO YEAR</option>
													<?php for($i = 3; $i > 0; $i--){ ?>
														<option value="<?php echo date("Y",strtotime("-$i year"));?>" <?php if($_REQUEST['ddYearTo'] == date("Y",strtotime("-$i year")) ){ echo "selected"; } ?> ><?php echo date("Y",strtotime("-$i year"));?></option>
													<?php }  ?>
													<option value="<?php echo date("Y");?>" <?php if($_REQUEST['ddYearTo'] == date("Y")){ echo "selected"; } ?> > <?php echo date("Y");?></option>
													<option value="<?php echo date("Y",strtotime("+1 year"));?>" <?php if($_REQUEST['ddYearTo'] == date("Y",strtotime("+1 year")) ){ echo "selected"; } ?> ><?php echo date("Y",strtotime("+1 year"));?></option>
												</select>
							  			</td>
							  		</tr>
							  		<tr>
							  			<td colspan="2" align="center">
							  				<input type=submit value="Run Report" name="btnRunReport" class="search_btn1" onclick="return checkValAndSubmit();" >
							  			</td>
							  		</tr>
							  	</table>
								</form>
							</td>
						</tr>
						<tr>
						  <td>&nbsp;</td>
						</tr>
						<tr>
						  <td>&nbsp;</td>
						</tr>						
			  	</tbody>
				</table>
			</div>		
		</div>		

		<?php tep_db_close(); ?>
	</body>
</html>
	