
<?php

// ini_set("display_errors", "1");

// error_reporting(E_ERROR);
?>
<!DOCTYPE html>

<html>
<head>
	<title>UCBZeroWaste Monthly Consolidated Invoices Logs</title>

<style type="text/css">

.txtstyle_color
{
font-family:arial;
font-size:12;
height: 16px; 
background:#ABC5DF;
}

.txtstyle
{
	font-family:arial;
	font-size:12;
}

.style7 {
	font-size: xx-small;
	font-family: Arial, Helvetica, sans-serif;
	color: #333333;
	background-color: #FFCC66;
}
.style5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: x-small;
	text-align: center;
	background-color: #99FF99;
}
.style6 {
	text-align: center;
	background-color: #99FF99;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: x-small;
}
.style3 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: x-small;
	color: #333333;
}
.style8 {
	text-align: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: x-small;
	color: #333333;
}
.style11 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: x-small;
	color: #333333;
	text-align: center;
}
.style10 {
	text-align: left;
}
.style12 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: x-small;
	color: #333333;
	text-align: right;
}
.style13 {
	font-family: Arial, Helvetica, sans-serif;
}
.style14 {
	font-size: x-small;
}
.style15 {
	font-size: small;
}
.style16 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: x-small;
	background-color: #99FF99;
}
.style17 {
	background-color: #99FF99;
}
select, input {
font-family: Arial, Helvetica, sans-serif; 
font-size: 10px; 
color : #000000; 
font-weight: normal; 
}

	span.infotxt:hover {text-decoration: none; background: #ffffff; z-index: 6; }
	span.infotxt span {position: absolute; left: -9999px; margin: 20px 0 0 0px; padding: 3px 3px 3px 3px; z-index: 6;}
	span.infotxt:hover span {left: 45%; background: #ffffff;} 
	span.infotxt span {position: absolute; left: -9999px; margin: 0px 0 0 0px; padding: 3px 3px 3px 3px; border-style:solid; border-color:black; border-width:1px;}
	span.infotxt:hover span {margin: 18px 0 0 170px; background: #ffffff; z-index:6;} 
	
	span.infotxt_freight:hover {text-decoration: none; background: #ffffff; z-index: 6; }
	span.infotxt_freight span {position: absolute; left: -9999px; margin: 20px 0 0 0px; padding: 3px 3px 3px 3px; z-index: 6;}
	span.infotxt_freight:hover span {left: 0%; background: #ffffff;} 
	span.infotxt_freight span {position: absolute; width:850px; overflow:auto; height:300px; left: -9999px; margin: 0px 0 0 0px; padding: 10px 10px 10px 10px; border-style:solid; border-color:white; border-width:50px;}
	span.infotxt_freight:hover span {margin: 5px 0 0 50px; background: #ffffff; z-index:6;} 
	
	span.infotxt_freight2:hover {text-decoration: none; background: #ffffff; z-index: 6; }
	span.infotxt_freight2 span {position: absolute; left: -9999px; margin: 20px 0 0 0px; padding: 3px 3px 3px 3px; z-index: 6;}
	span.infotxt_freight2:hover span {left: 0%; background: #ffffff;} 
	span.infotxt_freight2 span {position: absolute; width:850px; overflow:auto; height:300px; left: -9999px; margin: 0px 0 0 0px; padding: 10px 10px 10px 10px; border-style:solid; border-color:white; border-width:50px;}
	span.infotxt_freight2:hover span {margin: 5px 0 0 500px; background: #ffffff; z-index:6;} 

	.black_overlay{
		display: none;
		position: absolute;
	}
	.white_content {
		display: none;
		position: absolute;
		padding: 5px;
		border: 2px solid black;
		background-color: white;
		overflow:auto;
		height:600px;
		width:850px;
		z-index:1002;
		margin: 0px 0 0 0px; 
		padding: 10px 10px 10px 10px;
		border-color:black; 
		border-width:2px;
		overflow: auto;
	}
	
	.dtclasslog {
		top: 140px !important;
		left: 300px !important;
	}	
</style>	
	
	<script LANGUAGE="JavaScript">
		function f_getPosition (e_elemRef, s_coord) {
			var n_pos = 0, n_offset,
				e_elem = e_elemRef;

			while (e_elem) {
				n_offset = e_elem["offset" + s_coord];
				n_pos += n_offset;
				e_elem = e_elem.offsetParent;
			}

			e_elem = e_elemRef;
			while (e_elem != document.body) {
				n_offset = e_elem["scroll" + s_coord];
				if (n_offset && e_elem.style.overflow == 'scroll')
					n_pos -= n_offset;
				e_elem = e_elem.parentNode;
			}
			return n_pos;
		}
			
		function log_markcomp(unqid, compid)
		{
			//alert(selectedText);
			document.getElementById("log_div").innerHTML = "<br><br>Loading .....<img src='images/wait_animated.gif' />";
			if (window.XMLHttpRequest){
			  xmlhttp=new XMLHttpRequest();
			}else{
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					location.reload();
				}
			}
			
			xmlhttp.open("GET","logs_details_update.php?logsCompanyID="+compid +"&unqid="+unqid+"&markcomp=1",true);
			xmlhttp.send();		
		}

		function log_edits(unqid, compid){ 
			if (window.XMLHttpRequest){
			  xmlhttp=new XMLHttpRequest();
			}else{
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					selectobject = document.getElementById("log_edit"+unqid);
					n_left = f_getPosition(selectobject, 'Left');
					n_top  = f_getPosition(selectobject, 'Top');
					
					parent.document.getElementById('light').style.display='block';
					parent.document.getElementById("light").innerHTML = "<a href='javascript:void(0)' onclick=parent.document.getElementById('light').style.display='none';>Close</a> &nbsp;<center></center><br/>" + xmlhttp.responseText;
						
					parent.document.getElementById('light').style.width= 600 + 'px';
					parent.document.getElementById('light').style.height= 250 + 'px';
					parent.document.getElementById('light').style.left= (n_left - 300) + 'px';
					parent.document.getElementById('light').style.top= n_top + 'px';
				}
			}		

			xmlhttp.open("GET","logs_details_update.php?logsCompanyID="+compid +"&unqid="+unqid+'&edit_log=yes',true);
			xmlhttp.send();		
		}

		function log_update_edit(unqid, compid){
			if (window.XMLHttpRequest){
			  xmlhttp=new XMLHttpRequest();
			}else{
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					location.reload();
				}
			}

			var logsMessage = document.getElementById('log_message_edit').value;
			var logsEmployee = document.getElementById('log_employee_edit').value;
			var logsDate = document.getElementById('log_date_edit').value;
			var logsPriority = document.getElementById('log_priority_edit').value;
			
			xmlhttp.open("GET","logs_details_update.php?inedit_mode=1&unqid="+unqid+"&logsCompanyID=" +compid+"&logsMessage="+encodeURIComponent(logsMessage)+"&logsEmployee="+logsEmployee+"&logsDate="+logsDate+"&logsPriority="+encodeURIComponent(logsPriority),true);
			xmlhttp.send();		
		}	
	
		function fun_log_delete(unqid, compid)
		{
			document.getElementById("log_div").innerHTML = "<br><br>Loading .....<img src='images/wait_animated.gif' />";
			if (window.XMLHttpRequest){
			  xmlhttp=new XMLHttpRequest();
			}else{
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					location.reload();
				}
			}
			
			xmlhttp.open("GET","logs_details_update.php?logsCompanyID="+compid +"&unqid="+unqid+"&logdel=1",true);
			xmlhttp.send();		
		}

	</script>
	
	<LINK rel='stylesheet' type='text/css' href='one_style.css' >
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>
	
	<script LANGUAGE="JavaScript" SRC="inc/CalendarPopup.js"></script>
	<script LANGUAGE="JavaScript" SRC="inc/general.js"></script>
		<script LANGUAGE="JavaScript">document.write(getCalendarStyles());</script>
		<script LANGUAGE="JavaScript">
			var logeditdt = new CalendarPopup("loglistdiv_edit");
			logeditdt.showNavigationDropdowns();
		</script>
	
</head>

<?php
	require ("../mainfunctions/database.php");
	require ("../mainfunctions/general-functions.php");

	db();
	// function getnickname($warehouse_name, $b2bid){
	// 	$nickname = "";
	// 	if ($b2bid > 0) {
	// 		db_b2b();
	// 		$sql = "SELECT nickname, company, shipCity, shipState FROM companyInfo where ID = ?";
	// 		$result_comp = db_query($sql , array("i"), array($b2bid));
	// 		while ($row_comp = array_shift($result_comp)) {
	// 			if ($row_comp["nickname"] != "") {
	// 				$nickname = $row_comp["nickname"];
	// 			}else {
	// 				$tmppos_1 = strpos($row_comp["company"], "-");
	// 				if ($tmppos_1 != false)
	// 				{
	// 					$nickname = $row_comp["company"];
	// 				}else {
	// 					if ($row_comp["shipCity"] <> "" || $row_comp["shipState"] <> "" ) 
	// 					{
	// 						$nickname = $row_comp["company"] . " - " . $row_comp["shipCity"] . ", " . $row_comp["shipState"] ;
	// 					}else { $nickname = $row_comp["company"]; }
	// 				}
	// 			}
	// 		}
	// 		db();
	// 	}else {
	// 		$nickname = $warehouse_name;
	// 	}
		
	// 	return $nickname;
	// }	

?>
<body>

	<?php include("inc/header.php"); ?>

<div class="main_data_css">
	<div id="light" class="white_content"></div>
	<div ID="listdiv" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></div>

	<div class="dashboard_heading" style="float: left;">
		<div style="float: left;">UCBZeroWaste Monthly Consolidated Invoices Logs</div>
		&nbsp;<!--<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
		<span class="tooltiptext">
			This report shows the user all of the biggest companies in each industry that we sell to, so that when we go to sell to other companies in that industry, we can drop the names of the big ones.
		</span></div>-->
		
		<div style="height: 13px;">&nbsp;</div>				
	</div>

	<form method="get" name="frmWaterMonthlyLogs" action="water_monthly_consolidated_invoices_log.php">
		<table border="0">
			<tr>
				<td>Select Company:</td>
				<td>
					<select id="comp_sel" name="comp_sel">
						<option value="All">All</option>
						<?php 
							$sort_data_arr = array();
							$main_sql = "SELECT loop_warehouse.id, company_name, b2bid FROM loop_warehouse inner join water_transaction on loop_warehouse.id = water_transaction.company_id where Active = 1 and loop_warehouse.rec_type = 'Manufacturer' group by loop_warehouse.id order by company_name";
							$data_res = db_query($main_sql);
							while ($data = array_shift($data_res)) {
								$nickname = getnickname($data["company_name"], $data["b2bid"]);
								
								$sort_data_arr[] = array("id" => $data["id"], "nickname" => $nickname, "company_name" => $data["company_name"], "b2bid" => $data["b2bid"]);
							}

							$MGArraysort_I = array();
							foreach ($sort_data_arr as $MGArraytmp) {
								$MGArraysort_I[] = $MGArraytmp['nickname'];
							}

							array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$sort_data_arr); 
							
							foreach ($sort_data_arr as $sort_data_arr1)
							{
								echo "<option value='". $sort_data_arr1["id"] ."' "; 
								if ($_REQUEST["comp_sel"] == $sort_data_arr1["id"]) { echo " selected "; }
								echo ">" . $sort_data_arr1["nickname"] . "</option>";
							}
						?>
					</select>			
				</td>
				<td>Log Status:</td>
				<td>
					<select id="log_status" name="log_status">
						<option value="" <?php if ($_REQUEST["log_status"] == "") { echo " selected ";} ?>>All</option>
						<option value="1" <?php if ($_REQUEST["log_status"] == "1") { echo " selected ";} ?>>Active</option>
						<option value="2" <?php if ($_REQUEST["log_status"] == "2") { echo " selected ";} ?>>Completed</option>
					</select>			
				</td>
				<td>
					<input type=submit value="SUBMIT">
				</td>
			</tr>
		</table>
	</form>

	<div id="log_div">
		<table width="90%" border="0" cellspacing="1" cellpadding="1">
			<tr align="center">
				<td colspan="10" bgcolor="#99FF99">
					<font face="Arial, Helvetica, sans-serif" size="1">Active Logs</font>
				</td>
			</tr>
			<tr align="center">
				<td bgcolor="#99FF99">
					<font size="1">Company Name</font>
				</td>
				<td bgcolor="#99FF99">
					<font size="1">Log Name</font>
				</td>
				<td bgcolor="#99FF99">
					<font size="1">Created By</font>
				</td>
				<td bgcolor="#99FF99">
					<font size="1">Assigned To</font>
				</td>
				<td bgcolor="#99FF99">
					<font size="1">Created On</font>
				</td>
				<td bgcolor="#99FF99">
					<font size="1">Due Date</font>
				</td>
				<td bgcolor="#99FF99">
					<font size="1">Priority</font>
				</td>
				<td bgcolor="#99FF99">
					&nbsp;
				</td>
				<td bgcolor="#99FF99">
					&nbsp;
				</td>
				<td bgcolor="#99FF99">
					&nbsp;
				</td>
			</tr>
			<?php
			//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
			$log_status_str = "";
			if ($_REQUEST["log_status"] != "")
			{
				$log_status_str = " and status = '" . $_REQUEST["log_status"] . "'";		
			}
			$b2bid = '';
			if (isset($_REQUEST["comp_sel"]) && $_REQUEST["comp_sel"] != 'All') {
				db_b2b();
				$selCompId = db_query("SELECT ID FROM companyInfo Where loopid = " . $_REQUEST['comp_sel']);
				$rowCompId = array_shift($selCompId); 
				$b2bid = $rowCompId['ID'];
			}
			//echo "<br />".$b2bid;
			if($b2bid > 0 || $_REQUEST["comp_sel"] == 'All'){
				if($_REQUEST["comp_sel"] == 'All'){
					db();
					$resLogDetails = db_query("SELECT * FROM company_logs where status = 1 $log_status_str ORDER BY id");
				}else{
					db();
					$resLogDetails = db_query("SELECT * FROM company_logs where company_id = '" . $b2bid . "' AND status = 1 $log_status_str ORDER BY id");
				}					
				$numofLogDetails = tep_db_num_rows($resLogDetails);
				if($numofLogDetails > 0){
					while ($rowsLogDetails = array_shift($resLogDetails)) {
						$date1 = new DateTime($rowsLogDetails["due_date"]);
						$date2 = new DateTime();
						$days = (strtotime($rowsLogDetails["due_date"]) - strtotime(date("Y-m-d"))) / (60 * 60 * 24);
						$b2bid = $rowsLogDetails["company_id"];
						$nickname = get_nickname_val('', $rowsLogDetails["company_id"]);
						?>
						<tr align="center">
							<td bgcolor="#E4E4E4" align="left"><font size="1"><?php echo $nickname?></font></td>
							
							<td bgcolor="#E4E4E4" align="left"><font size="1"><?php echo $rowsLogDetails["log_name"]?></font></td>

							<td bgcolor="#E4E4E4" ><font size="1"><?php echo $rowsLogDetails["log_created_by"]?></font></td>

							<td bgcolor="#E4E4E4" ><font size="1"><?php echo $rowsLogDetails["assign_to"]?></font></td>

							<td bgcolor="#E4E4E4" ><font size="1"><?php echo date("m/d/Y H:i:s", strtotime($rowsLogDetails["log_added_on"]))  . " CT";?></font></td>
							
							<?php if ($days == 0){?>
								<td bgcolor="green" ><font size="1"><?php echo date("m/d/Y", strtotime($rowsLogDetails["due_date"])) . " CT";?></font></td>
							<?php }

							if ($days > 0){ ?>
								<td bgcolor="#E4E4E4" ><font size="1"><?php echo date("m/d/Y", strtotime($rowsLogDetails["due_date"])) . " CT";?></font></td>
							<?php }
							
							if ($days < 0){?>
								<td bgcolor="red" ><font size="1"><?php echo date("m/d/Y", strtotime($rowsLogDetails["due_date"])) . " CT";?></font></td>
							<?php } ?>
							
							<td bgcolor="#E4E4E4" ><font size="1"><?php echo $rowsLogDetails["log_priority"];?></font></td>						

							<td bgcolor="#E4E4E4" align="middle">
								<input type="button" value="Edit" onclick="javascript: log_edits(<?php echo $rowsLogDetails["id"];?>, <?php echo $b2bid;?>);"  name="log_edit" id="log_edit<?php echo $rowsLogDetails["id"];?>" >
							</td>

							<td bgcolor="#E4E4E4" align="middle">
								<input type="button" value="Delete" onclick="javascript: fun_log_delete(<?php echo $rowsLogDetails["id"];?>, <?php echo $b2bid;?>);"  name="log_delete" id="log_delete<?php echo $rowsLogDetails["id"];?>" >
							</td>

							<td bgcolor="#E4E4E4" align="middle">
								<input type="button" value="Mark Complete" name="log_markcompl" id="log_markcompl" onclick="log_markcomp(<?php echo $rowsLogDetails["id"];?>, <?php echo $b2bid;?>)">
							</td>
							
						</tr>	
						<?php
					}
				}else{
					?>
					<tr align="center">
						<td bgcolor="#E4E4E4" align="center" colspan="7"><font size="1">No record found</font></td>
					</tr>
					<?php
				}
			}else{
				?>
				<tr><td colspan="7">Select company</td></tr>
				<?php
			}
			?>
		</table>
		<br>
		<table width="90%" border="0" cellspacing="1" cellpadding="1">
			<tr align="center">
				<td colspan="7" bgcolor="#99FF99">
					<font face="Arial, Helvetica, sans-serif" size="1">Recently Completed Logs</font>
				</td>
			</tr>
			<tr align="center">
				<td bgcolor="#99FF99">
					<font size="1">Company Name</font>
				</td>
				<td bgcolor="#99FF99">
					<font size="1">Log Name</font>
				</td>
				<td bgcolor="#99FF99">
					<font size="1">Assigned To</font>
				</td>
				<td bgcolor="#99FF99">
					<font size="1">Created On</font>
				</td>
				<td bgcolor="#99FF99">
					<font size="1">Due Date</font>
				</td>
				<td bgcolor="#99FF99">
					<font size="1">Priority</font>
				</td>
				<td bgcolor="#99FF99">
					<font size="1">Completed</font>
				</td>
			</tr>
			<?php
			if($b2bid > 0 || $_REQUEST["comp_sel"] == 'All'){
				if($_REQUEST["comp_sel"] == 'All'){
					$sql = "SELECT * FROM company_logs WHERE status = 2 $log_status_str ORDER BY due_date" ;
				}else{
					$sql = "SELECT * FROM company_logs WHERE company_id = '" . $b2bid . "'  AND status = 2 $log_status_str ORDER BY due_date" ;
				}		
				db();			
				$resLogDtls = db_query($sql);
				$numofLogDtls = tep_db_num_rows($resLogDtls);
				if($numofLogDtls > 0){
					while ($rowsLogDtls = array_shift($resLogDtls)) {
						$nickname = get_nickname_val('', $rowsLogDtls["company_id"]);
						?>
						<tr align="center">
							<td bgcolor="#E4E4E4" align="left"><font size="1"><?php echo $nickname?></font></td>
							<td bgcolor="#E4E4E4" align="left"><font size="1"><?php echo $rowsLogDtls["log_name"]?></font></td>
							<td bgcolor="#E4E4E4" ><font size="1"><?php echo $rowsLogDtls["assign_to"]?></font></td>

							<td bgcolor="#E4E4E4" ><font size="1"><?php echo date("m/d/Y H:i:s", strtotime($rowsLogDtls["log_added_on"]))  . " CT";?></font></td>
							
							<td bgcolor="#E4E4E4" ><font size="1"><?php echo date("m/d/Y", strtotime($rowsLogDtls["due_date"])) . " CT";?></font></td>

							<td bgcolor="#E4E4E4" ><font size="1"><?php echo $rowsLogDtls["log_priority"];?></font></td>

							<td bgcolor="#E4E4E4" ><font size="1"><?php echo $rowsLogDtls["mark_comp_by"] . " " . date("m/d/Y", strtotime($rowsLogDtls["mark_comp_on"])) . " CT";?></font></td>
						</tr>	
						<?php
					}
				}else{
					?>
					<tr align="center">
						<td bgcolor="#E4E4E4" align="center" colspan="6"><font size="1">No record found</font></td>
					</tr>
					<?php
				}
			}else{
				?>
				<tr><td colspan="6">Select Company</td></tr>
				<?php
			}
			?>		
		</table>		
	</div> 
</body>
</html>