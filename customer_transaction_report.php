<?php

session_start();

require "inc/header_session.php";
require "mainfunctions/database.php";
require "mainfunctions/general-functions.php";

?>

<!DOCTYPE html>
<html>
<head>

<title>Company Travel Proximity Report</title>
	<LINK rel='stylesheet' type='text/css' href='one_style.css' >
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>
	<style>
		.style12{
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			color:#292929;
			font-weight: bold;
            white-space: nowrap;
		}
		.tdstyle{
			font-family: Arial, Helvetica, sans-serif;
			font-size: 11px;
			color:#333333;
		}
        table.sortable tr td{
            background-color: #EBEBEB;
        }

	</style>


</head>

<body>
<?php include_once "inc/header.php";?>
	<div class="main_data_css">
		<div class="dashboard_heading" style="float: left;">
			<div style="float: left;">
					Company Travel Proximity Report
				<div class="tooltip">
					<i class="fa fa-info-circle" aria-hidden="true"></i>
					<span class="tooltiptext">
						This report allows the user to search for all companies within a certain proximity of a zip code. This is useful for when someone travels. The user can see all companies that will be close to the zip code entered and it can be easily decided if any visits should be made.
					</span>
				</div>
				<div style="height: 13px;">&nbsp;</div>
			</div>
		</div>

		<table border="0" width="100%" cellspacing="0" cellpadding="5">
			<tr>
				<td valign="top"></td>
			</tr>
			<tr>
				
				<td valign="top">
					    <?php
						$sort_order_pre = "ASC";
						$asc_img = "";
						$surl = "";
						if ($_GET['sort_order_pre'] == "ASC") {
							$sort_order_pre = "DESC";
						} else {
							$sort_order_pre = "ASC";
						}

						?>

						<form action="customer_transaction_report.php" method="get">
							<table width="100%" border="0" cellspacing="2" cellpadding="2" bgcolor="#E4E4E4">
								<tr align="center">
									<td colspan="2" bgcolor="#C0CDDA">
										<font face="Arial, Helvetica, sans-serif" size="2" color="#0B0B0B">
											<strong>Customer's Transaction Report</strong>
										</font>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										Zipcode: <input name="zip" type="text" id="zip" value="<?=htmlspecialchars($_GET["zip"] ?? '')?>" size="6" maxlength="7">
									</td>
								</tr>
								<tr>
									<td colspan="2">
										How many miles to search for: <input type="text" name="miles" value="<?=htmlspecialchars($_GET["miles"] ?? '')?>">
									</td>
								</tr>
								<tr>
									<td colspan="2">
										Filter By: <select name="filterby">
											<option value="">Select One</option>
											<option value="1" <?=($_GET['filterby'] ?? '') == '1' ? "selected" : ""?>>Sales</option>
											<option value="2" <?=($_GET['filterby'] ?? '') == '2' ? "selected" : ""?>>Purchasing</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										<input type="submit" value="Find Matches">
									</td>
								</tr>
							</table>
						</form>
					<br>
					<form name="frmstatusdashboard" id="frmstatusdashboard" method="post" action="">
							<div>
								<i>Note: Please wait until you see <font color="red">"END OF REPORT"</font> at the bottom of the report, before using the sort option.</i>
							</div>
							
						<?php
						include 'customer_transaction_report_inc.php';
						?>
					</form>
				</td>
			</tr>
		</table>
		<div >
			<i><font color="red">"END OF REPORT"</font></i>
		</div>
	</div>
</body>
<SCRIPT LANGUAGE="JavaScript" SRC="inc/CalendarPopup.js"></SCRIPT>
<script LANGUAGE="JavaScript">document.write(getCalendarStyles());</script>
<script LANGUAGE="JavaScript">
	var cal2xx = new CalendarPopup("listdiv");
	cal2xx.showNavigationDropdowns();
</script>
	<script type="text/javascript">
	function update_details(comp_id,distance)
	{
		var notes_data = document.getElementById('note'+ comp_id).value;
		var notes_date = document.getElementById('txt_next_step_dt'+ comp_id).value;
		if (window.XMLHttpRequest)
		{
		  xmlhttp=new XMLHttpRequest();
		}
		else
		{
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		  xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			  document.getElementById("tbl_div" + comp_id).innerHTML = xmlhttp.responseText;
			}
		}

		xmlhttp.open("GET","update_note_transaction_data.php?updatedata=1&comp_id=" + comp_id + "&notes_data=" + encodeURIComponent(notes_data) + "&notes_date=" + encodeURIComponent(notes_date) + "&distance=" + encodeURIComponent(distance) ,true);
		xmlhttp.send();
	}
	</script>
</html>
