<?php

// //require ("inc/header_session.php");
// ini_set("display_errors", "1");

// error_reporting(E_ALL);
require "../mainfunctions/database.php";

require "../mainfunctions/general-functions.php";

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">

<title>Inventory Summary Report - Outbound</title>

<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">

<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>



<style type="text/css">

.style7 {

	font-size: x-small;

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

}



/*table thead {

  position: fixed;

  top: 0;

  left: 0;

  width: 100%;

  background: #FFF;

  display: table;

  table-layout: fixed;

  border: solid 1px #000;

}*/

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

		width:1000px;

		z-index:1002;

		margin: 0px 0 0 0px;

		padding: 10px 10px 10px 10px;

		border-color:black;

		border-width:2px;

		overflow: auto;

	}



</style>

	<SCRIPT LANGUAGE="JavaScript" SRC="inc/CalendarPopup.js"></SCRIPT><SCRIPT LANGUAGE="JavaScript" SRC="inc/general.js"></SCRIPT>

	<script LANGUAGE="JavaScript">document.write(getCalendarStyles());</script>

	<script LANGUAGE="JavaScript">

		var cal2xx = new CalendarPopup("listdiv");

		cal2xx.showNavigationDropdowns();

		var cal3xx = new CalendarPopup("listdiv");

		cal3xx.showNavigationDropdowns();

	</script>



	<script LANGUAGE="JavaScript">

		function load_div(id){

			var element = document.getElementById("spanctr" + id); //replace elementId with your element's Id.



			var rect = element.getBoundingClientRect();

			var elementLeft,elementTop; //x and y

			var scrollTop = document.documentElement.scrollTop?

							document.documentElement.scrollTop:document.body.scrollTop;

			var scrollLeft = document.documentElement.scrollLeft?

							 document.documentElement.scrollLeft:document.body.scrollLeft;

			elementTop = rect.top+scrollTop;

			elementLeft = rect.left+scrollLeft;



			document.getElementById("light").innerHTML = document.getElementById("spanctr" + id).innerHTML;

			document.getElementById('light').style.display='block';

			document.getElementById('fade').style.display='block';



			document.getElementById('light').style.left='100px';

			document.getElementById('light').style.top=elementTop + 100 + 'px';



		}



		function close_div(){

			document.getElementById('light').style.display='none';

		}

	</script>

</head>



<body>

<?php include "inc/header.php";?>

<div class="main_data_css">

	<div class="dashboard_heading" style="float: left;">

		<div style="float: left;">Inventory Summary Report - Outbound</div>

		&nbsp;<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>

		<span class="tooltiptext">This report allows the user to search the outbound Bill of Lading (BOL) database for all inventory shipped over a period of time, whether by specific SKU, by specific sorting warehouse, and/or by a specific company UCB sells to.</span></div>

		<div style="height: 13px;">&nbsp;</div>

	</div>

	<div id="light" class="white_content">

	</div>

	<div id="fade" class="black_overlay"></div>



	<?php

$time = strtotime(Date('Y-m-d'));

$st_friday = $time;

$st_friday_last = date('m/d/Y', strtotime('-6 days', $st_friday));

$st_thursday_last = Date('m/d/Y');

//$st_friday_last = '01/01/2019';

$in_dt_range = "no";

if ($_REQUEST["date_from"] != "" && $_REQUEST["date_to"] != "") {

    $date_from_val = date("Y-m-d", strtotime($_REQUEST["date_from"]));

    $date_to_val_org = date("Y-m-d", strtotime($_REQUEST["date_to"]));

    $date_to_val = date("Y-m-d", strtotime($_REQUEST["date_to"]));

    $in_dt_range = "yes";

    //

} else {

    if (isset($_REQUEST["warehouse_id"]) || isset($_REQUEST["inv_id"])) {

        $in_dt_range = "no";

        $date_from_val = date("Y-01-01", strtotime($st_friday_last));

        $date_to_val_org = date("Y-m-d", strtotime($st_thursday_last));

        $date_to_val = date("Y-m-d", strtotime($st_thursday_last));

    } else {

        $in_dt_range = "no";

        $date_from_val = date("Y-m-d", strtotime($st_friday_last));

        $date_to_val_org = date("Y-m-d", strtotime($st_thursday_last));

        $date_to_val = date("Y-m-d", strtotime($st_thursday_last));

    }

}

?>

	<!--

	<font size=4>Outbound Inventory Summary</font><br>

	<font size=2>This report allows the user to search the outbound Bill of Lading (BOL) database for all inventory shipped over a period of time, whether by specific SKU, by specific sorting warehouse, and/or by a specific company UCB sells to.</font>

	<br><br>

	-->

	<form method="post" name="inv_frm" action="report_Outbound_inventory_summary.php">

		<table border="0">

			<tr>

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

			</tr>



			<tr>

				<td>

					Inventory Item:

				</td>

				<td>

				<?php

db_b2b();

$matchStr2 = "Select *, inventory.id AS I from inventory order by vendor_b2b_rescue";

$res = db_query($matchStr2);

while ($objInvmatch = array_shift($res)) {

    $tipStr = "";

    $vendor_name = "";

    if ($objInvmatch["vendor"] != "") {
        db();
        $res_2 = db_query("Select * from loop_warehouse where id = '" . $objInvmatch["vendor_b2b_rescue"] . "'");

        while ($objInvmatch_2 = array_shift($res_2)) {

            $tipStr = $tipStr . $objInvmatch_2["company_name"] . " ";

            $vendor_name = $objInvmatch_2["company_name"];

        }

    }

    if ($objInvmatch["lengthInch"] != "") {

        $tipStr = $tipStr . $objInvmatch["lengthInch"];

    }

    if ($objInvmatch["lengthFraction"] != "") {

        $tipStr = $tipStr . " " . $objInvmatch["lengthFraction"];

    }

    $tipStr = $tipStr . " x ";

    if ($objInvmatch["widthInch"] != "") {

        $tipStr = $tipStr . $objInvmatch["widthInch"];

    }

    if ($objInvmatch["widthFraction"] != "") {

        $tipStr = $tipStr . " " . $objInvmatch["widthFraction"];

    }

    $tipStr = $tipStr . " x ";

    if ($objInvmatch["depthInch"] != "") {

        $tipStr = $tipStr . $objInvmatch["depthInch"];

    }

    if ($objInvmatch["depthFraction"] != "") {

        $tipStr = $tipStr . " " . $objInvmatch["depthFraction"];

    }

    $tipStr = $tipStr . "<BR>";

    if ($objInvmatch["description"] != "") {

        $tipStr = $tipStr . " " . $objInvmatch["description"] . " ";

    }

    if ($objInvmatch["sales_price"] != "") {

        $tipStr = $tipStr . "Price: $" . $objInvmatch["sales_price"] . " ";

    }

    if ($objInvmatch["costDollar"] != "") {

        //$tipStr = $tipStr . "Cost: " . number_format($objInvmatch["costDollar"] + $objInvmatch["costCents"],2) . " ";

    }

    if ($objInvmatch["location"] != "") {

        $tipStr = $tipStr . "Loc: " . $objInvmatch["location"] . " ";

    }

    if ($objInvmatch["location"] != "") {

        $tipStr = $tipStr . "B2B ID: " . $objInvmatch["I"] . " ";

    }

    if ($objInvmatch["location"] != "") {

        $tipStr = $tipStr . "Loops id: " . $objInvmatch["loops_id"] . " ";

    }

    $MGArray[] = array('I' => $objInvmatch["I"], 'tipStr' => $tipStr, 'vendor_name' => $vendor_name);

}

$MGArraysort_I = array();

?>

					<select name="inv_item" id="inv_item" style="width:400px;">

						<option value="" >All</option>

						<?php

foreach ($MGArray as $MGArraytmp) {

    $MGArraysort_I[] = $MGArraytmp['vendor_name'];

}

array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);

foreach ($MGArray as $MGArraytmp2) {

    if ($MGArraytmp2["I"] == $_REQUEST["inv_item"]) {

        echo "<option value=" . $MGArraytmp2["I"] . " selected >";

    } elseif ($MGArraytmp2["I"] == $_REQUEST["inv_id"]) {

        echo "<option value=" . $MGArraytmp2["I"] . " selected >";

    } else {

        echo "<option value=" . $MGArraytmp2["I"] . " >";

    }

    echo $MGArraytmp2["tipStr"] . "</option>";

}

?>

					</select>

				</td>

			</tr>



			<tr>

				<td>

					Sorting Warehouse:

				</td>

				<td>

					<select id="sorting_warehouse" name="sorting_warehouse">

						<option value="">All</option>

						<?php

db();

$queryinv2 = "Select * from loop_warehouse where rec_type='Sorting' ORDER BY company_name";

$res_inv2 = db_query($queryinv2);

while ($rowinv2 = array_shift($res_inv2)) {

    $sel_text = "";

    if ($rowinv2["id"] == $_REQUEST["sorting_warehouse"]) {

        $sel_text = " selected ";

    }

    if ($_REQUEST["warehouse_id"] == "18" && $rowinv2["id"] == 18) {

        $sel_text = " selected ";

    }

    if ($_REQUEST["warehouse_id"] == "556" && $rowinv2["id"] == 556) {

        $sel_text = " selected ";

    }

    if ($_REQUEST["warehouse_id"] == "18" && $rowinv2["id"] == 18) {

        $sel_text = " selected ";

    }

    echo "<option value='" . $rowinv2["id"] . "' $sel_text>";

    echo $rowinv2["company_name"] . "</option>";

}

?>

					</select>

				</td>

			</tr>



			<tr>

				<td>

					Sales Record:

				</td>

				<td>

				<?php

$sqlw = "SELECT b2bid, id , company_name FROM loop_warehouse WHERE rec_type LIKE 'Supplier' AND ACTIVE = 1 ORDER BY company_name ASC ";

$sql_resw = db_query($sqlw);

while ($roww = array_shift($sql_resw)) {

    $warehouse_name = $roww["company_name"];

    $com_name = get_nickname_val($warehouse_name, $roww["b2bid"]);

    $MGArray[] = array('loop_id' => $roww["id"], 'b2b_id' => $roww["b2bid"], 'company_name' => $com_name);

}

$MGArraysort_I = array();

foreach ($MGArray as $MGArraytmp) {

    $MGArraysort_I[] = $MGArraytmp['company_name'];

}

array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);

?>

					<select name="company_id" name="company_id"  >

						<option value="">All</option>

						<?php

foreach ($MGArray as $MGArraytmp2) {

    if (trim($MGArraytmp2["company_name"]) != "") {

        $sel_text = "";

        if ($MGArraytmp2["loop_id"] == $_REQUEST["company_id"] || $MGArraytmp2["loop_id"] == $_REQUEST["warehouse_id"]) {

            $sel_text = " selected ";

        }

        echo "<option value='" . $MGArraytmp2["loop_id"] . "' $sel_text>";

        ?>

						<?php echo $MGArraytmp2["company_name"] . " (Loop ID: " . $MGArraytmp2["loop_id"] . " B2B ID:" . $MGArraytmp2["b2b_id"] . ")"; ?></option>

					<?php
}
}?>

					</select>

				</td>

			</tr>



			<tr>

				<td colspan="2">

					<input type="submit" name="btntool" name="btntool" value="Submit" />

				</td>

			</tr>

		</table>

	</form>



<?php if (isset($_REQUEST["btntool"]) || isset($_REQUEST["warehouse_id"]) || isset($_REQUEST["inv_id"])) {?>



		<?php

    db();

    $additoinal_filter_1 = "";
    $group_by_str = "";

    $inv_id = "";

    if ($_REQUEST["inv_id"] != "") {

        $inv_id = $_REQUEST["inv_id"];

    }

    if ($_REQUEST["inv_item"] != "") {

        $inv_id = $_REQUEST["inv_item"];

    }

    if ($inv_id != "") {

        db_b2b();

        $matchStr2 = "Select inventory.loops_id from inventory INNER JOIN vendors ON inventory.vendor = vendors.id WHERE active LIKE 'A' and inventory.ID = " . $inv_id;

        $res = db_query($matchStr2);

        while ($objInvmatch = array_shift($res)) {

            $additoinal_filter_1 = " and loop_bol_tracking.box_id = '" . $objInvmatch["loops_id"] . "' ";

        }

        db();

    } else {

    }

    $group_by_str = "group by warehouse_id, rec_warehouse_id, box_id ";

    $additoinal_filter_2 = "";

    if ($_REQUEST["sorting_warehouse"] != "") {

        //$additoinal_filter_2 = " and loop_bol_tracking.warehouse_id = '" . $_REQUEST["sorting_warehouse"] . "' ";

        $additoinal_filter_2 = " and loop_bol_tracking.location_warehouse_id = '" . $_REQUEST["sorting_warehouse"] . "' ";

    }

    if (isset($_REQUEST["warehouse_id"])) {

        $additoinal_filter_2 = " and loop_bol_tracking.warehouse_id = '" . $_REQUEST["warehouse_id"] . "' ";

    }

    $box_type_str_arr = array("'Gaylord','GaylordUCB', 'PresoldGaylord', 'Loop'", "'LoopShipping','Box','Boxnonucb','Presold','Medium','Large','Xlarge','Boxnonucb'", "'SupersackUCB','SupersacknonUCB'", "'DrumBarrelUCB','DrumBarrelnonUCB'", "'PalletsUCB','PalletsnonUCB'", "'Recycling','Other','Waste-to-Energy'");

    $box_type_cnt = 0;
    $id_cnt = 0;

    foreach ($box_type_str_arr as $box_type_str_arr_tmp) {

        $tot_qty_main = 0;

        $box_type_cnt = $box_type_cnt + 1;

        $tot_cnt = 0;

        if ($box_type_cnt == 1) {$box_type = "Gaylord";}

        if ($box_type_cnt == 2) {$box_type = "Shipping Boxes";}

        if ($box_type_cnt == 3) {$box_type = "Supersacks";}

        if ($box_type_cnt == 4) {$box_type = "Drums/Barrels/IBCs";}

        if ($box_type_cnt == 5) {$box_type = "Pallets";}

        if ($box_type_cnt == 6) {$box_type = "Recycling+Other";}

        if ($_REQUEST["manageboxpg"] == "y") {

            //$query = "SELECT loop_bol_tracking.warehouse_id, loop_transaction_buyer.id as rec_id, loop_transaction_buyer.warehouse_id as rec_warehouse_id, loop_bol_tracking.box_id, loop_bol_tracking.bol_date, sum(qty) as boxgood, count(*) as cnt FROM loop_bol_tracking inner join loop_transaction_buyer on loop_transaction_buyer.id = loop_bol_tracking.trans_rec_id inner join loop_boxes on loop_boxes.id = loop_bol_tracking.box_id INNER JOIN loop_bol_files ON loop_transaction_buyer.id = loop_bol_files.trans_rec_id where qty > 0 and loop_transaction_buyer.ignore = 0 and loop_boxes.type in ($box_type_str_arr_tmp) and DATE_FORMAT(STR_TO_DATE(loop_bol_files.bo_date, '%m/%d/%Y'), '%Y-%m-%d') BETWEEN  '" . $date_from_val. "' and '" . $date_to_val. "' $additoinal_filter_1 $additoinal_filter_2 $group_by_str order by loop_bol_tracking.id";

            $query = "SELECT loop_bol_tracking.location_warehouse_id, loop_bol_files.warehouse_id, loop_transaction_buyer.id as rec_id, loop_transaction_buyer.warehouse_id as rec_warehouse_id, loop_bol_tracking.box_id, loop_bol_files.bo_date, sum(loop_bol_tracking.qty) as boxgood, count(*) as cnt FROM loop_bol_files inner join loop_transaction_buyer on loop_transaction_buyer.id = loop_bol_files.trans_rec_id INNER JOIN loop_bol_tracking on loop_transaction_buyer.id = loop_bol_tracking.trans_rec_id inner join loop_boxes on loop_boxes.id = loop_bol_tracking.box_id  where qty > 0 and loop_transaction_buyer.ignore = 0 and loop_boxes.type in ($box_type_str_arr_tmp) and DATE_FORMAT(STR_TO_DATE(loop_bol_files.bo_date, '%m/%d/%Y'), '%Y-%m-%d') BETWEEN  '" . $date_from_val . "' and '" . $date_to_val . "' $additoinal_filter_1 $additoinal_filter_2 $group_by_str order by loop_bol_tracking.id";

            //echo $query;

        } else {

            if ($_REQUEST["company_id"] != "") {

                $query = "SELECT loop_bol_tracking.location_warehouse_id, loop_bol_files.warehouse_id, loop_transaction_buyer.id as rec_id, loop_transaction_buyer.warehouse_id as rec_warehouse_id, loop_bol_tracking.box_id, loop_bol_files.bo_date, sum(loop_bol_tracking.qty) as boxgood, count(*) as cnt FROM loop_bol_files inner join loop_transaction_buyer on loop_transaction_buyer.id = loop_bol_files.trans_rec_id INNER JOIN loop_bol_tracking on loop_transaction_buyer.id = loop_bol_tracking.trans_rec_id inner join loop_boxes on loop_boxes.id = loop_bol_tracking.box_id  where qty > 0 and  loop_transaction_buyer.ignore = 0 and loop_boxes.type in ($box_type_str_arr_tmp) and loop_transaction_buyer.warehouse_id = " . $_REQUEST["company_id"] . " and DATE_FORMAT(STR_TO_DATE(loop_bol_files.bo_date, '%m/%d/%Y'), '%Y-%m-%d') BETWEEN  '" . $date_from_val . "' and '" . $date_to_val . "' $additoinal_filter_1 $additoinal_filter_2 $group_by_str order by loop_bol_tracking.id";

            } else {

                $query = "SELECT loop_bol_tracking.location_warehouse_id, loop_bol_files.warehouse_id, loop_transaction_buyer.id as rec_id, loop_transaction_buyer.warehouse_id as rec_warehouse_id, loop_bol_tracking.box_id, loop_bol_files.bo_date, sum(loop_bol_tracking.qty) as boxgood, count(*) as cnt FROM loop_bol_files inner join loop_transaction_buyer on loop_transaction_buyer.id = loop_bol_files.trans_rec_id INNER JOIN loop_bol_tracking on loop_transaction_buyer.id = loop_bol_tracking.trans_rec_id inner join loop_boxes on loop_boxes.id = loop_bol_tracking.box_id where qty > 0 and loop_transaction_buyer.ignore = 0 and loop_boxes.type in ($box_type_str_arr_tmp) and DATE_FORMAT(STR_TO_DATE(loop_bol_files.bo_date, '%m/%d/%Y'), '%Y-%m-%d') BETWEEN  '" . $date_from_val . "' and '" . $date_to_val . "' $additoinal_filter_1 $additoinal_filter_2 $group_by_str order by loop_bol_tracking.id";

            }

        }

        //echo "q-".$query."<br>";

        //inner join loop_warehouse ON loop_inventory.warehouse_id = loop_warehouse.id

        ?>

	<table cellSpacing="1" cellPadding="1" border="0" class="datatable" width="1200px">

		<tr vAlign="center" >

			<td colspan="6" >&nbsp;</td>

		</tr>

		<tr vAlign="center" >

			<td colspan="6" bgColor="#e4e4e4" height="20" align="center"><b><?php echo $box_type; ?></b></td>

		</tr>



		<tr>

			<td class="style17" align="center">

				<b>Date</b></td>

			<td class="style17" align="center">

				<b>Warehouse</b></td>

			<td class="style17" align="center">

				<b>Sales Record</b></td>

			<td class="style17" align="center">

				<b>Inventory Item</b></td>

			<td class="style17" align="center">

				<b>Quantity</b></td>

			<td class="style17" align="center">

				<b># of Entries</b></td>



		</tr>



		<?php

        db();

        $res = db_query($query);

        while ($row = array_shift($res)) {

            if ($row["boxgood"] > 0) {

                db();

                $warehouse_name = "";
                $b2bid = 0;
                $nickname = "";

                if ($row["location_warehouse_id"] != "") {

                    $query_child = "SELECT company_name, b2bid from loop_warehouse where id = " . $row["location_warehouse_id"];

                    $res_child = db_query($query_child);

                    while ($row_child = array_shift($res_child)) {

                        $warehouse_name = $row_child["company_name"];

                    }

                }

                $company_name = "";

                if ($row["rec_warehouse_id"] != "") {

                    $query_child = "SELECT company_name, b2bid from loop_warehouse where id = " . $row["rec_warehouse_id"];

                    $res_child = db_query($query_child);

                    while ($row_child = array_shift($res_child)) {

                        $company_name = $row_child["company_name"];

                        $b2bid = $row_child["b2bid"];

                    }

                    $nickname = get_nickname_val($company_name, $b2bid);

                }

                $id_cnt = $id_cnt + 1;

                $lisoftrans = "<span style='width:800px;'><table cellSpacing='1' cellPadding='1' border='0' width='800'>";

                $lisoftrans .= "<tr><td bgColor='#ABC5DF' class='txtstyle_color'>Date Added</td><td bgColor='#ABC5DF' class='txtstyle_color'>Sort Warehouse</td>

					<td bgColor='#ABC5DF' class='txtstyle_color'>Transaction Id</td><td bgColor='#ABC5DF' class='txtstyle_color'>Quantity</td></tr>";

                //<td class='txtstyle_color'>Count</td>

                //<td class='txtstyle_color'>Notes</td><td class='txtstyle_color'>Inventory Notes</td><td class='txtstyle_color'>Log</td></tr>";

                if ($_REQUEST["manageboxpg"] == "y") {

                    $query_child = "SELECT loop_bol_files.warehouse_id, loop_transaction_buyer.id as rec_id, loop_transaction_buyer.warehouse_id as rec_warehouse_id, loop_bol_tracking.box_id, loop_bol_files.bo_date, loop_bol_tracking.qty as boxgood FROM loop_bol_files inner join loop_transaction_buyer on loop_transaction_buyer.id = loop_bol_files.trans_rec_id INNER JOIN loop_bol_tracking on loop_transaction_buyer.id = loop_bol_tracking.trans_rec_id inner join loop_boxes on loop_boxes.id = loop_bol_tracking.box_id where qty > 0 and loop_transaction_buyer.ignore = 0 and loop_boxes.type in ($box_type_str_arr_tmp)  and DATE_FORMAT(STR_TO_DATE(loop_bol_files.bo_date, '%m/%d/%Y'), '%Y-%m-%d') BETWEEN  '" . $date_from_val . "' and '" . $date_to_val . "' and loop_transaction_buyer.warehouse_id = " . $row["rec_warehouse_id"] . " and box_id = " . $row["box_id"] . " $additoinal_filter_1 $additoinal_filter_2 order by loop_bol_tracking.id";

                } else {

                    if ($_REQUEST["company_id"] != "") {

                        $query_child = "SELECT loop_bol_files.warehouse_id, loop_transaction_buyer.id as rec_id, loop_transaction_buyer.warehouse_id as rec_warehouse_id, loop_bol_tracking.box_id, loop_bol_files.bo_date, loop_bol_tracking.qty as boxgood FROM loop_bol_files inner join loop_transaction_buyer on loop_transaction_buyer.id = loop_bol_files.trans_rec_id INNER JOIN loop_bol_tracking on loop_bol_files.trans_rec_id = loop_bol_tracking.trans_rec_id inner join loop_boxes on loop_boxes.id = loop_bol_tracking.box_id where qty > 0 and loop_transaction_buyer.ignore = 0 and loop_boxes.type in ($box_type_str_arr_tmp) and loop_transaction_buyer.warehouse_id = " . $_REQUEST["company_id"] . " and DATE_FORMAT(STR_TO_DATE(loop_bol_files.bo_date, '%m/%d/%Y'), '%Y-%m-%d') BETWEEN  '" . $date_from_val . "' and '" . $date_to_val . "' and loop_transaction_buyer.warehouse_id = " . $row["rec_warehouse_id"] . " and box_id = " . $row["box_id"] . " $additoinal_filter_1 $additoinal_filter_2 order by loop_bol_tracking.id";

                    } else {

                        $query_child = "SELECT loop_bol_files.warehouse_id, loop_transaction_buyer.id as rec_id, loop_transaction_buyer.warehouse_id as rec_warehouse_id, loop_bol_tracking.box_id, loop_bol_files.bo_date, loop_bol_tracking.qty as boxgood FROM loop_bol_files inner join loop_transaction_buyer on loop_transaction_buyer.id = loop_bol_files.trans_rec_id INNER JOIN loop_bol_tracking on loop_transaction_buyer.id = loop_bol_tracking.trans_rec_id inner join loop_boxes on loop_boxes.id = loop_bol_tracking.box_id where qty > 0 and loop_transaction_buyer.ignore = 0 and loop_boxes.type in ($box_type_str_arr_tmp) and DATE_FORMAT(STR_TO_DATE(loop_bol_files.bo_date, '%m/%d/%Y'), '%Y-%m-%d') BETWEEN  '" . $date_from_val . "' and '" . $date_to_val . "'  and loop_transaction_buyer.warehouse_id = " . $row["rec_warehouse_id"] . " and box_id = " . $row["box_id"] . " $additoinal_filter_1 $additoinal_filter_2 order by loop_bol_tracking.id";

                    }

                }

                $tot_qty = 0;

                $res_child = db_query($query_child);

                while ($row_child = array_shift($res_child)) {

                    $lisoftrans .= "<tr>

						<td bgColor='#E4EAEB'>" . $row_child["bo_date"] . "</td>

						<td bgColor='#E4EAEB'>" . $warehouse_name . "</a></td>

						<td bgColor='#E4EAEB'><a target='_blank' href='viewCompany.php?ID=$b2bid&show=transactions&warehouse_id=" . $row_child['rec_warehouse_id'] . "&rec_type=Supplier&proc=View&searchcrit=&id=" . $row_child['rec_warehouse_id'] . "&rec_id=" . $row_child['rec_id'] . "&display=buyer_ship'>" . $row_child['rec_id'] . " - " . $nickname . "</a></td>

						<td bgColor='#E4EAEB' align='right'>" . $row_child["boxgood"] . "</td>

						</tr>";

                    $tot_qty = $tot_qty + $row_child["boxgood"];

                }

                if ($tot_qty > 0) {

                    $lisoftrans .= "<tr><td bgColor='#ABC5DF' colspan='3'>&nbsp;</td><td bgColor='#ABC5DF' align='right'>$tot_qty</td></tr>";

                }

                $lisoftrans .= "</table></span>";

                if ($_REQUEST["manageboxpg"] == "y") {

                    $query_child = "SELECT min(loop_bol_files.bo_date) as mindate, max(loop_bol_files.bo_date) as maxdate FROM loop_bol_files inner join loop_transaction_buyer on loop_transaction_buyer.id = loop_bol_files.trans_rec_id INNER JOIN loop_bol_tracking on loop_transaction_buyer.id = loop_bol_tracking.trans_rec_id inner join loop_boxes on loop_boxes.id = loop_bol_tracking.box_id where qty > 0 and loop_transaction_buyer.ignore = 0 and loop_boxes.type in ($box_type_str_arr_tmp)  and loop_transaction_buyer.warehouse_id = " . $row["rec_warehouse_id"] . " and DATE_FORMAT(STR_TO_DATE(loop_bol_files.bo_date, '%m/%d/%Y'), '%Y-%m-%d') BETWEEN  '" . $date_from_val . "' and '" . $date_to_val . "' and box_id = " . $row["box_id"] . " $additoinal_filter_1 $additoinal_filter_2 order by loop_bol_tracking.id";

                } else {

                    if ($_REQUEST["company_id"] != "") {

                        $query_child = "SELECT min(loop_bol_files.bo_date) as mindate, max(loop_bol_files.bo_date) as maxdate FROM loop_bol_files inner join loop_transaction_buyer on loop_transaction_buyer.id = loop_bol_files.trans_rec_id INNER JOIN loop_bol_tracking on loop_transaction_buyer.id = loop_bol_tracking.trans_rec_id inner join loop_boxes on loop_boxes.id = loop_bol_tracking.box_id where qty > 0 and loop_transaction_buyer.ignore = 0 and loop_boxes.type in ($box_type_str_arr_tmp) and loop_transaction_buyer.warehouse_id = " . $_REQUEST["company_id"] . " and DATE_FORMAT(STR_TO_DATE(loop_bol_files.bo_date, '%m/%d/%Y'), '%Y-%m-%d') BETWEEN  '" . $date_from_val . "' and '" . $date_to_val . "' and loop_transaction_buyer.warehouse_id = " . $row["rec_warehouse_id"] . " and box_id = " . $row["box_id"] . " $additoinal_filter_1 $additoinal_filter_2 order by loop_bol_tracking.id";

                    } else {

                        $query_child = "SELECT min(loop_bol_files.bo_date) as mindate, max(loop_bol_files.bo_date) as maxdate FROM loop_bol_files inner join loop_transaction_buyer on loop_transaction_buyer.id = loop_bol_files.trans_rec_id INNER JOIN loop_bol_tracking on loop_bol_files.trans_rec_id = loop_bol_tracking.trans_rec_id inner join loop_boxes on loop_boxes.id = loop_bol_tracking.box_id  where qty > 0 and loop_transaction_buyer.ignore = 0 and loop_boxes.type in ($box_type_str_arr_tmp) and DATE_FORMAT(STR_TO_DATE(loop_bol_files.bo_date, '%m/%d/%Y'), '%Y-%m-%d') BETWEEN  '" . $date_from_val . "' and '" . $date_to_val . "'  and loop_transaction_buyer.warehouse_id = " . $row["rec_warehouse_id"] . " and box_id = " . $row["box_id"] . " $additoinal_filter_1 $additoinal_filter_2 order by loop_bol_tracking.id";

                    }

                }

                $mindate = "";
                $maxdate = "";

                $res_child = db_query($query_child);

                while ($row_child = array_shift($res_child)) {

                    $mindate = $row_child["mindate"];

                    $maxdate = $row_child["maxdate"];

                }

                ?>

					<tr>



					<td  width="200" class="style12left" bgcolor="#e4e4e4" align="left">

						<?php echo $mindate . " - " . $maxdate; ?></td>

					<td  width="100" class="style12left" bgcolor="#e4e4e4" align="left">

						<?php echo $warehouse_name; ?></td>

					<td  width="300" class="style12left" bgcolor="#e4e4e4" align="left">

						<a target="_blank" href="viewCompany.php?ID=<?php echo $b2bid; ?>"><?php echo $nickname; ?></a></td>

					<td  width="500" class="style12left" bgcolor="#e4e4e4" align="left">

						<?php

                $tipStr = "";

                db_b2b();

                if ($row["box_id"] != "") {

                    $matchStr2 = "Select *, inventory.id AS I from inventory where inventory.loops_id = '" . $row["box_id"] . "'";

                    $res_child = db_query($matchStr2);

                    while ($objInvmatch = array_shift($res_child)) {

                        if ($objInvmatch["lengthInch"] != "") {

                            $tipStr = $tipStr . $objInvmatch["lengthInch"];

                        }

                        if ($objInvmatch["lengthFraction"] != "") {

                            $tipStr = $tipStr . " " . $objInvmatch["lengthFraction"];

                        }

                        $tipStr = $tipStr . " x ";

                        if ($objInvmatch["widthInch"] != "") {

                            $tipStr = $tipStr . $objInvmatch["widthInch"];

                        }

                        if ($objInvmatch["widthFraction"] != "") {

                            $tipStr = $tipStr . " " . $objInvmatch["widthFraction"];

                        }

                        $tipStr = $tipStr . " x ";

                        if ($objInvmatch["depthInch"] != "") {

                            $tipStr = $tipStr . $objInvmatch["depthInch"];

                        }

                        if ($objInvmatch["depthFraction"] != "") {

                            $tipStr = $tipStr . " " . $objInvmatch["depthFraction"];

                        }

                        $tipStr = $tipStr . " ";

                        if ($objInvmatch["description"] != "") {

                            $tipStr = $tipStr . " " . $objInvmatch["description"] . " ";

                        }

                        if ($objInvmatch["sales_price"] != "") {

                            $tipStr = $tipStr . "Price: $" . $objInvmatch["sales_price"] . " ";

                        }

                        if ($objInvmatch["costDollar"] != "") {

                            $tipStr = $tipStr . "Cost: " . number_format($objInvmatch["costDollar"] + $objInvmatch["costCents"], 2) . " ";

                        }

                        if ($objInvmatch["vendor"] != "") {

                            $tipStr = $tipStr . "Vendor: " . $objInvmatch["Name"] . " ";

                        }

                        if ($objInvmatch["location"] != "") {

                            $tipStr = $tipStr . "Loc: " . $objInvmatch["location"] . " ";

                        }

                        echo $tipStr;

                    }

                }

                ?>

					</td>

					<td  width="50" class="style12right" bgcolor="#e4e4e4" align="right">

						<b><?php echo number_format($row["boxgood"], 0); ?></b></td>

					<td  width="50" class="style12right" bgcolor="#e4e4e4" align="right">

						<a href='#' onclick="load_div(<?php echo $id_cnt; ?>); return false;"><b><?php echo number_format($row["cnt"], 0); ?></b></a>

						<span id="spanctr<?php echo $id_cnt; ?>" style="display:none;"><a href="#" onclick="close_div(); return false;">Close</a><?php echo $lisoftrans; ?></span>

					</td>



				</tr>

				<?php

                $tot_qty_main = $tot_qty_main + $row["boxgood"];

                $tot_cnt = $tot_cnt + $row["cnt"];

            }

        }

        if ($tot_qty_main > 0) {?>

				<tr>

					<td class="style12right" bgcolor="#e4e4e4" align="right">&nbsp;

						</td>

					<td class="style12right" bgcolor="#e4e4e4" align="right">&nbsp;

						</td>

					<td class="style12right" bgcolor="#e4e4e4" align="right">&nbsp;

						</td>

					<td class="style12right" bgcolor="#e4e4e4" align="right">

						<b>Total</b></td>

					<td  class="style12right" bgcolor="#e4e4e4" align="right">

						<b><?php echo number_format($tot_qty_main, 0); ?></b></td>

					<td  class="style12right" bgcolor="#e4e4e4" align="right">

						<b><?php echo number_format($tot_cnt, 0); ?></b></td>

				</tr>

				<?php }

        ?>





		</table>

<?php
}}?>

</div>

</body>

</html>

