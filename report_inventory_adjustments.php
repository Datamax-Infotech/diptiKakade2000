<?php

//require ("inc/header_session.php");

require "../mainfunctions/database.php";

require "../mainfunctions/general-functions.php";

db();

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">

<title>Inventory Adjustments Summary Report</title>

<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">

<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css' >

<style type="text/css">

.style12 {

	font-family: Arial, Helvetica, sans-serif;

	font-size: x-small;

	color: #333333;

	text-align: right;

}

.style12center {

	font-family: Arial, Helvetica, sans-serif;

	font-size: x-small;

	color: #333333;

	text-align: center;

}

.style12right {

	font-family: Arial, Helvetica, sans-serif;

	font-size: x-small;

	color: #333333;

	text-align: right;

}

.style12left {

	font-family: Arial, Helvetica, sans-serif;

	font-size: x-small;

	color: #333333;

	text-align: left;

}

.style13 {

	font-family: Arial, Helvetica, sans-serif;

}

.style14 {

	font-size: x-small;

}

.style15 {

	font-size: x-small;

}

.style16 {

	font-family: Arial, Helvetica, sans-serif;

	font-size: x-small;

	background-color: #99FF99;

}

.style17 {

	font-family: Arial, Helvetica, sans-serif;

	font-size: x-small;

	color: #333333;

	background-color: #99FF99;

}



select, input {

font-family: Arial, Helvetica, sans-serif;

font-size: 12px;

color : #000000;

font-weight: normal;

}



    table.datatable {

  border-collapse: collapse;

  background: #FFF;

  width: 30%;

}



table.datatable tbody {

  margin-top: 24px;

}

table.datatable {

  border: 1px solid white;

}

table.datatable tr td,

table.datatable tr th {

  height: 20px;

  border: 1px solid white;

  padding: 5px;

}

</style>

	<SCRIPT LANGUAGE="JavaScript" SRC="inc/CalendarPopup.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript" SRC="inc/general.js"></SCRIPT>

	<script LANGUAGE="JavaScript">document.write(getCalendarStyles());</script>

	<script LANGUAGE="JavaScript">

		var cal2xx = new CalendarPopup("listdiv");

		cal2xx.showNavigationDropdowns();

		var cal3xx = new CalendarPopup("listdiv");

		cal3xx.showNavigationDropdowns();

	</script>

</head>



<body>

<?php

$time = strtotime(Date('Y-m-d'));

$st_friday = $time;

$st_friday_last = date('m/d/Y', strtotime('-6 days', $st_friday));

$st_thursday_last = Date('m/d/Y');

$in_dt_range = "no";
$date_from_val = "";
$date_to_val = "";
if ($_REQUEST["date_from"] != "" && $_REQUEST["date_to"] != "") {

    $date_from_val = date("Y-m-d", strtotime($_REQUEST["date_from"]));

    $date_to_val_org = date("Y-m-d", strtotime($_REQUEST["date_to"]));

    $date_to_val = date("Y-m-d", strtotime('+1 day', strtotime($_REQUEST["date_to"])));

    $in_dt_range = "yes";

} else {

    $in_dt_range = "no";

    $date_from_val = date("Y-m-d", strtotime($st_friday_last));

    $date_to_val_org = date("Y-m-d", strtotime($st_thursday_last));

    $date_to_val = date("Y-m-d", strtotime('+1 day', strtotime($st_thursday_last)));

}

?>

<?php include "inc/header.php";?>

<div class="main_data_css">

	<div class="dashboard_heading" style="float: left;">

		<div style="float: left;">Inventory Adjustments Summary Report</div>

		&nbsp;<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>

		<span class="tooltiptext">This report allows the user to view all manual inventory adjustments made within a date range. As a note, inventory adjustments are a LAST RESORT regarding inventory management. Making an adjustment generally means we were unable to identify the problem, meaning there will be a problem lingering somewhere in the system. The only exceptions to this are restacking, resizing and/or baling.</span></div>

		<div style="height: 13px;">&nbsp;</div>

	</div>




	<form method="post" name="inv_frm" action="report_inventory_adjustments.php">

		<table border="0"><tr>

			<td>Date Range Selector:</td>

			<td>

				From:

					<input type="text" name="date_from" id="date_from" size="10" value="<?php echo isset($_POST['date_from']) ? $_POST['date_from'] : date("m/d/Y", strtotime($date_from_val)); ?>" >

					<a href="#" onclick="cal2xx.select(document.inv_frm.date_from,'dtanchor2xx','MM/dd/yyyy'); return false;" name="dtanchor2xx" id="dtanchor2xx"><img border="0" src="images/calendar.jpg"></a>

					<div ID="listdiv" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></div>

				To:

					<input type="text" name="date_to" id="date_to" size="10" value="<?php echo isset($_POST['date_to']) ? $_POST['date_to'] : date("m/d/Y", strtotime($date_to_val_org)); ?>" >

					<a href="#" onclick="cal3xx.select(document.inv_frm.date_to,'dtanchor3xx','MM/dd/yyyy'); return false;" name="dtanchor3xx" id="dtanchor3xx"><img border="0" src="images/calendar.jpg"></a>

			</td>


			<td>

				<input type="submit" name="btntool" value="Submit" />

				<input type="hidden" name="inv_adj" id="inv_adj" value=""/>

			</td>

			</tr>

		</table>

	</form>

	<?php

if (isset($_POST["inv_adj"])) {
    db();
    $query = "SELECT * FROM loop_inventory INNER JOIN loop_warehouse ON loop_inventory.warehouse_id = loop_warehouse.id WHERE (inv_chng_date >= '" . $date_from_val . "') AND (inv_chng_date <'" . $date_to_val . " 23:59:59') AND boxgood !=0 order by loop_inventory.inv_chng_date, loop_warehouse.warehouse_name";

    $res = db_query($query);

    $numrows = tep_db_num_rows($res);

    if ($numrows > 0) {

        ?>

			<table cellSpacing="1" cellPadding="1" border="0" class="datatable" width="700px">

				<tr>

					<td style="width: 190" class="style17" align="center">

						<b>Warehouse</b></td>

					<td style="width: 200" class="style17" align="center">

						<b>Box Description</b></td>

					<td style="width: 190" class="style17" align="center">

						<b>Quantity Change</b></td>

					<td style="width: 190" class="style17" align="center">

						<b>Notes</b></td>

					<td style="width: 190" class="style17" align="center">

						<b>User Initials</b></td>

					<td style="width: 190" class="style17" align="center">

						<b>Date Time</b></td>

				</tr>

				<?php

        while ($row = array_shift($res)) {
            db();
            $bquery = "SELECT bdescription, id FROM loop_boxes WHERE id = " . $row["box_id"];

            $bres = db_query($bquery);

            $brow = array_shift($bres);

            ?>

						<tr>



							<td class="style12left" bgcolor="#e4e4e4" align="center">

								<?php echo $row["warehouse_name"]; ?></td>

							<td class="style12left" bgcolor="#e4e4e4" align="center">

								<?php echo $brow["bdescription"]; ?></td>

							<td class="style12center" bgcolor="#e4e4e4" align="center">

								<?php echo $row["inv_old_val"]; ?> to <?php echo $row["boxgood"]; ?></td>

							<td class="style12left" bgcolor="#e4e4e4" align="center">

								<?php echo $row["inv_notes"]; ?></td>

							<td class="style12center" bgcolor="#e4e4e4" align="center">

								<b><?php echo $row["inv_chng_user"]; ?></b></td>

							<td class="style12left" bgcolor="#e4e4e4" align="center">

								<?php echo date('m/d/Y H:i:s', strtotime($row["inv_chng_date"])); ?></td>

						</tr>

					<?php

        }

        ?>

			</table>

			<?php

    } else {

        echo "<span style='color:#FF0000'>No Records found</span>";

    }

} else {

    echo "";

}

?>

	</div>

</body>

</html>

