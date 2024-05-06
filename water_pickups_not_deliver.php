<!DOCTYPE html>

<html>

<head>

	<title>WATER Pick-up Requests Tracker</title>

<style>

.display_maintitle {

    font-size: 13px;

    padding: 3px;

    font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;

    background: #98bcdf;

    white-space: nowrap;

}

.display_title {

    font-size: 12px;

    padding: 3px;

    font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;

    background: #b7d3ef;

    white-space: nowrap;

}

	.display_table {

    font-size: 11px;

    padding: 3px;

    font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;

    background: #EBEBEB;

}

</style>

	<LINK rel='stylesheet' type='text/css' href='one_style.css' >

	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">

	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>

	</head>

<?php



	//require ("inc/header_session.php");

	require ("../mainfunctions/database.php");

	require ("../mainfunctions/general-functions.php");



	db();



?>

<body>

	<?php include "inc/header.php";?>



<div class="main_data_css">

	<div class="dashboard_heading" style="float: left;">

		<div style="float: left;">WATER Pick-up Requests Tracker</div>

		&nbsp;<!--<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>

		<span class="tooltiptext">

			This report shows the user all of the biggest companies in each industry that we sell to, so that when we go to sell to other companies in that industry, we can drop the names of the big ones.

		</span></div>-->



		<div style="height: 13px;">&nbsp;</div>

	</div>



		<SCRIPT LANGUAGE="JavaScript" SRC="inc/CalendarPopup.js"></SCRIPT><SCRIPT LANGUAGE="JavaScript" SRC="inc/general.js"></SCRIPT>

	<script LANGUAGE="JavaScript">document.write(getCalendarStyles());</script>

	<script LANGUAGE="JavaScript">

		var cal2xx = new CalendarPopup("listdiv");

		cal2xx.showNavigationDropdowns();

		var cal3xx = new CalendarPopup("listdiv");

		cal3xx.showNavigationDropdowns();

	</script>

	<form name="frmwater_report_internal" id="frmwater_report_internal"  action="water_pickups_not_deliver.php">



		<table border="0" cellspacing="1" cellpadding="1">

			<tr align="center">

				<td>

					Company:

				</td>

				<td align="left">

					<select id="comp_sel" name="comp_sel" style="width: 200px;">

						<option value="All">All</option>

						<?php

$main_sql = "Select loop_warehouse.id, company_name, b2bid from loop_warehouse inner join water_loop_transaction on loop_warehouse.id = water_loop_transaction.warehouse_id where Active = 1 and loop_warehouse.rec_type = 'Manufacturer' group by loop_warehouse.id order by company_name";
db();
$data_res = db_query($main_sql);

while ($data = array_shift($data_res)) {

    echo "<option value='" . $data["id"] . "' ";

    if ($_REQUEST["comp_sel"] == $data["id"]) {echo " selected ";}

    echo ">" . get_nickname_val($data["company_name"], $data["b2bid"]) . "</option>";

}

?>

					</select>

				</td>

				<td>

					Report Filter:

				</td>

				<td align="left">

					<select id="rep_filter" name="rep_filter">

						<option value="1" <?php if ($_REQUEST["rep_filter"] == 1) {
    echo " selected";
}
?>>Pickups Requested and Not Confirmed</option>

						<option value="2" <?php if ($_REQUEST["rep_filter"] == 2) {
    echo " selected";
}
?>>Pickups Requested and Confirmed</option>

						<option value="3" <?php if ($_REQUEST["rep_filter"] == 3) {
    echo " selected";
}
?>>Pickups Completed</option>

					</select>

				</td>

				<td>

					&nbsp;&nbsp;&nbsp;Date:

				</td>

				<td>

					From:

					<input type="text" name="date_from" id="date_from" size="10" value="<?php if (isset($_REQUEST['date_from'])) {echo $_REQUEST['date_from'];} else {echo "";}?>"  >

					<a href="#" onclick="cal2xx.select(document.frmwater_report_internal.date_from,'dtanchor2xx','MM/dd/yyyy'); return false;" name="dtanchor2xx" id="dtanchor2xx"><img border="0" src="images/calendar.jpg"></a>

					<div ID="listdiv" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></div>

				To:

					<input type="text" name="date_to" id="date_to" size="10" value="<?php if (isset($_REQUEST['date_to'])) {echo $_REQUEST['date_to'];} else {echo "";}?>" >

					<a href="#" onclick="cal3xx.select(document.frmwater_report_internal.date_to,'dtanchor3xx','MM/dd/yyyy'); return false;" name="dtanchor3xx" id="dtanchor3xx"><img border="0" src="images/calendar.jpg"></a>

				</td>

				<td>

					 <input type="submit" id="btnrep" value="Run Report"/>

				</td>

			</tr>

		</table>

	</form>



<?php

		$main_title = "";

		if ($_REQUEST["rep_filter"] == 1){

			$main_title = "Pickups Requested and Not Confirmed";

		}elseif ($_REQUEST["rep_filter"] == 2){

			$main_title = "Pickups Requested and Confirmed";

		}elseif ($_REQUEST["rep_filter"] == 3){

			$main_title = "Pickups Completed";

		}



?>

	<table width="40%" border="0" cellspacing="1" cellpadding="1">

		<tr align="center">

			<td colspan="4" class="display_maintitle">

				<font face="Arial, Helvetica, sans-serif" size="2" color="#333333"><b>WATER <?php echo $main_title; ?> REPORT</b></font>

			</td>

		</tr>

		<?php

		$flg_once = "no"; $swhere_condition = ""; $condt = "";

		if (isset($_REQUEST["comp_sel"])) {

			if ($_REQUEST["comp_sel"] != "All") {

				$swhere_condition = " and loop_warehouse.id = " . $_REQUEST["comp_sel"] ;

			}

			$comp_sel = $_REQUEST["comp_sel"];

		}else{

			$comp_sel = "All";

		}



		if ($_REQUEST["rep_filter"] == 1){

			$main_sql = "Select loop_warehouse.id as wid, water_loop_transaction.id as rec_id, loop_warehouse.company_name, loop_warehouse.b2bid, count(*) as cnt from water_loop_transaction inner join loop_warehouse on loop_warehouse.id = water_loop_transaction.warehouse_id where (water_loop_transaction.pa_pickupdate = '' or water_loop_transaction.pa_pickupdate is null) and loop_warehouse.rec_type = 'Manufacturer' $swhere_condition group by warehouse_id";

		}elseif ($_REQUEST["rep_filter"] == 2){

			$main_sql = "Select loop_warehouse.id as wid, water_loop_transaction.id as rec_id, loop_warehouse.company_name, loop_warehouse.b2bid, count(*) as cnt from water_loop_transaction inner join loop_warehouse on loop_warehouse.id = water_loop_transaction.warehouse_id where water_loop_transaction.pa_pickupdate <> '' and (water_loop_transaction.cp_date = '' or water_loop_transaction.cp_date is null) and loop_warehouse.rec_type = 'Manufacturer' $swhere_condition group by warehouse_id";

		}elseif ($_REQUEST["rep_filter"] == 3){

			$main_sql = "Select loop_warehouse.id as wid, water_loop_transaction.id as rec_id, loop_warehouse.company_name, loop_warehouse.b2bid, count(*) as cnt from water_loop_transaction inner join loop_warehouse on loop_warehouse.id = water_loop_transaction.warehouse_id where (water_loop_transaction.cp_date <> '' and water_loop_transaction.pa_pickupdate <> '') and loop_warehouse.rec_type = 'Manufacturer' $swhere_condition group by warehouse_id";

		}





		$no_rows = 0;



		$data_res = db_query($main_sql);

		while ($data = array_shift($data_res)) {



			$todisplay_data = "yes";

			if ($todisplay_data == "yes")

			{



				if (isset($_REQUEST["only_conf"])) {

					$condt .= " and double_chk_confirm=1";

				}else{



				}

				if ((isset($_REQUEST["date_from"])) && isset($_REQUEST["date_to"])) {

					if($_REQUEST["date_from"]!="" && $_REQUEST["date_to"]!="")

					{

						//

						$date_from=date("Y-m-d" , strtotime($_REQUEST["date_from"]));

						$date_to=date("Y-m-d" , strtotime($_REQUEST["date_to"]));

						//

						$condt .= " and (transaction_date >= '" . $date_from . "' and transaction_date <= '" . $date_to . "')";

					}



				}else{

				}



				$get_trans_sql = "SELECT * FROM water_loop_transaction left join supplier_commodity_details on water_loop_transaction.commodity = supplier_commodity_details.id WHERE water_loop_transaction.id = '".$data["rec_id"]."' and warehouse_id = '".$data["wid"]."' ".$condt;

				db();

				$trans_result=db_query($get_trans_sql);

				$trans_num=tep_db_num_rows($trans_result);

				if($trans_num>0)

				{

			?>

				<tr valign="middle" id="tbl_div" >

					<td colspan="4" class="display_title"><a target="_blank" href="viewCompany.php?ID=<?php echo $data["b2bid"]; ?>&proc=View&searchcrit=&show=watertransactions&rec_type=Manufacturer"><?php echo get_nickname_val($data["company_name"], $data["b2bid"]); ?></a></td>

				</tr>

				<tr><td colspan="4">

					<table width="100%" cellpadding="3" cellspacing="1">



					<tr  class="display_maintitle">

						<td width="150px">Pick-up Date Request</td>

						<td width="150px">Pick-up Date</td>

						<td width="150px">Commodity</td>

						<td width="150px">Trailer #</td>

						<td width="150px">Pickup Status</td>

					</tr>



				<?



					$open = "<img src=\"images/circle_open.gif\" border=\"0\">";

					$half = "<img src=\"images/circle__partial.gif\" border=\"0\">";

					$full = "<img src=\"images/complete.jpg\" border=\"0\">";



					while($tranlist=array_shift($trans_result))

					{

				?>

						<tr>

							<td width="150px" class="display_table" >

								<a href="viewCompany_func_water-mysqli.php?ID=<?php echo $data["b2bid"] ?>&show=watertransactions&warehouse_id=<?php echo $data["wid"]; ?>&b2bid=<?php echo $data["b2bid"]; ?>&rec_id=<?php echo $tranlist["id"]; ?>&rec_type=Manufacturer&proc=View&searchcrit=&display=water_sort" target="_blank">

								<?php echo date("Y-m-d H:m:i", strtotime($tranlist["pr_requestdate_php"])); ?>

								</a>

							</td>

							<td width="150px" class="display_table">

								<?php echo $tranlist["pr_pickupdate"]; ?>

							</td>

							<td width="150px" class="display_table">

								<?php echo $tranlist["commodity"]; ?>

							</td>

							<td width="150px" class="display_table">

								<?php echo $tranlist["dt_trailer"]; ?>

							</td>

							<td width="150px" class="display_table">

									<?php if (($tranlist["reported_in_water"] == 1)) {echo $full;} elseif ($tranlist["pa_pickupdate"] != "") {echo $half;} else {echo $open;}

?>

							</td>

						</tr>



							<?php

							}

					?>

						</table>



					</td>

				</tr>

		<?php

				}



			}

		}



?>

		</table>

		</td></tr>



	</table>

	</div>

</body>

</html>

