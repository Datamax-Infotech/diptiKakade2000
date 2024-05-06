<?php

//require ("inc/header_session.php");

require "../mainfunctions/database.php";

require "../mainfunctions/general-functions.php";

db();

?>

<!DOCTYPE html>



<html>

<head>

	<title>B2B Inventory Conversion Tool</title>

	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">

	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css' >





<style type="text/css">

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

</style>





<script type="text/javascript">



	function chkvalues(){

		if (document.getElementById('warehouse').value == '')

		{

			alert("Please select the warehouse.");

			return false;

		}else{

			document.rpt_invconverter.submit();

			return true;

		}

	}



	function validate_values(){

		var flg = 0;

		if (document.getElementById('qty').value == '')

		{

			alert("Please select the Quantity.");

			flg = 1;

		}



		if (document.getElementById('skud_substract').value == '')

		{

			alert("Please select the Box to substract.");

			flg = 1;

		}



		if (document.getElementById('skud_add').value == '')

		{

			alert("Please select the Box to add.");

			flg = 1;

		}



		if (document.getElementById('skud_substract').value != '' && document.getElementById('skud_add').value != '')

		{

			if (document.getElementById('skud_substract').value == document.getElementById('skud_add').value)

			{

				alert("Substract and Add Box are same.");

				flg = 1;

			}

		}



		if (flg == 1) {

			return false;

		}else {

		document.getElementById('action_fld').value = "conv_box";

		document.frminventory_converter.submit(); return true; }

	}



	function validate_values_sku(){

		var flg = 0;

		if (document.getElementById('sku_substract').value == '')

		{

			alert("Please select the SKU to substract.");

			flg = 1;

		}



		if (document.getElementById('qty_sku').value == '')

		{

			alert("Please select the Quantity.");

			flg = 1;

		}



		if (document.getElementById('warehouse_add_sku').value == '')

		{

			alert("Please select the Warehouse to substract from.");

			flg = 1;

		}



		if (document.getElementById('warehouse_subc_sku').value == '')

		{

			alert("Please select the Warehouse to substract from.");

			flg = 1;

		}



		if (document.getElementById('warehouse_add_sku').value != '' && document.getElementById('warehouse_subc_sku').value != '')

		{

			if (document.getElementById('warehouse_add_sku').value == document.getElementById('warehouse_subc_sku').value)

			{

				alert("Warehouse selected in both the drop down list are same.");

				flg = 1;

			}

		}



		if (flg == 1) {

			return false;

		}else {

			document.getElementById('action_fld').value = "conv_sku";

			document.frminventory_converter_sku.submit(); return true;

		}

	}

</script>

</head>



<body>

<?php include "inc/header.php";?>

<div class="main_data_css">

	<div class="dashboard_heading" style="float: left;">

		<div style="float: left;">B2B Inventory Conversion Tool</div>

		&nbsp;<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>

		<span class="tooltiptext">This tool allows the user to move a selected available quantity from one inventory SKU to another. Reasons for this include boxes which are being restacked to different quantities, inventory which was resized to a different height.</span></div>

		<div style="height: 13px;">&nbsp;</div>

	</div>

<!--

<span class="style2">

	<a href="index.php">Home</a></span><br>

<br>



<br />

-->

	<h3>Convert a Box Quantity from One sku to Another</h3>



<table>

	<tr>

		<td>

		<form name="rpt_invconverter" action="inventory_converter.php" method="GET">

		<input type="hidden" name="action" value="view">

		Select the Warehouse



		<select name="warehouse" id="warehouse">

			<option value=""></option>

			<?php

$sql2 = "SELECT * FROM loop_warehouse WHERE rec_type LIKE 'Sorting' ORDER BY company_name";

$result2 = db_query($sql2);

while ($myrowsel2 = array_shift($result2)) {

    ?>

			<option value="<?php echo $myrowsel2["id"]; ?>" <?php

    if ($myrowsel2["id"] == $_REQUEST["warehouse"]) {

        echo " selected ";

    }

    ?>><?php echo $myrowsel2["company_name"]; ?></option>

			<?php
}?>

		</select>



		</span>



		&nbsp; <input type="button" value="Display Inventory" onclick="chkvalues();">

		</form>

	</td>

	<td width="150">

	&nbsp;

	</td>

	<td>



	</td></tr>

</table>



<br/>



<?php

if ($_REQUEST["action"] == 'view') {

    ?>

<form method="post" name="frminventory_converter" action="inventory_converter_submit.php">

	<input type="hidden" name="warehouse_id" value="<?php echo $_REQUEST["warehouse"] ?>">

	<table>

		<tr>

			<td>SKU you want to subtract from</td>

			<td>

				<select name="skud_substract" id="skud_substract">

					<option value=""></option>

					<?php

    $dt_view_qry = "SELECT SUM(loop_inventory.boxgood) AS A, loop_inventory.box_id, loop_boxes.bdescription, loop_boxes.sku, loop_boxes.quantity_available FROM loop_inventory ";

    $dt_view_qry .= " INNER JOIN loop_warehouse ON loop_inventory.warehouse_id = loop_warehouse.id INNER JOIN loop_boxes ON loop_inventory.box_id = loop_boxes.id ";

    $dt_view_qry .= " WHERE loop_warehouse.id = " . $_REQUEST["warehouse"] . " GROUP BY loop_warehouse.warehouse_name, loop_inventory.box_id ORDER BY loop_boxes.bdescription ";

    $dt_view_res = db_query($dt_view_qry);

    while ($dt_view_row = array_shift($dt_view_res)) {

        if ($dt_view_row["sku"] != "") {

            ?>

						<option value="<?php echo $dt_view_row["box_id"]; ?>"><?php echo $dt_view_row["bdescription"] . " [" . $dt_view_row["sku"] . "] (" . $dt_view_row["A"] . ")"; ?></option>

					<?php
} else {?>

						<option value="<?php echo $dt_view_row["box_id"]; ?>"><?php echo $dt_view_row["bdescription"] . " (" . $dt_view_row["A"] . ")"; ?></option>

					<?php }

    }?>

				</select>

			</td>

		</tr>



		<tr>

			<td>SKU you want to add to</td>

			<td>

				<select name="skud_add" id="skud_add">

					<option value=""></option>

					<?php

    $dt_view_qry = "SELECT SUM(loop_inventory.boxgood) AS A, loop_inventory.box_id, loop_boxes.bdescription, loop_boxes.sku, loop_boxes.quantity_available FROM loop_inventory ";

    $dt_view_qry .= " INNER JOIN loop_warehouse ON loop_inventory.warehouse_id = loop_warehouse.id INNER JOIN loop_boxes ON loop_inventory.box_id = loop_boxes.id ";

    $dt_view_qry .= " WHERE loop_warehouse.id = " . $_REQUEST["warehouse"] . " GROUP BY loop_warehouse.warehouse_name, loop_inventory.box_id ORDER BY loop_boxes.bdescription ";

    echo $dt_view_qry;

    $dt_view_res = db_query($dt_view_qry);

    while ($dt_view_row = array_shift($dt_view_res)) {

        if ($dt_view_row["sku"] != "") {

            ?>

						<option value="<?php echo $dt_view_row["box_id"]; ?>"><?php echo $dt_view_row["bdescription"] . " [" . $dt_view_row["sku"] . "] (" . $dt_view_row["A"] . ")"; ?></option>

					<?php
} else {?>

						<option value="<?php echo $dt_view_row["box_id"]; ?>"><?php echo $dt_view_row["bdescription"] . " (" . $dt_view_row["A"] . ")"; ?></option>

					<?php	}

    }?>

				</select>

			</td>

		</tr>



		<tr>

			<td>Quantity</td>

			<td>

				<input type="text" name="qty" id="qty" value=""/>

			</td>

		</tr>



		<tr>

			<td>Available</td>

			<td>

				<input type="number" name="box_available" id="box_available" value="0" />

			</td>

		</tr>



		<tr><td colspan=2>

		<input type="button" value="Update" onclick="validate_values()"></td><tr>



	</table>

</form>



<br/>

<br/>



<?php
}?>





<form method="post" name="frminventory_converter_sku" action="inventory_converter_submit.php">

	<input type="hidden" name="warehouse_id" value="<?php echo $_REQUEST["warehouse"] ?>">



	<h3>Convert a SKU from one Sorting Warehouse to Another</h3>

	<table>

		<tr>

			<td>Select the SKU: </td>

			<td>

				<select name="sku_substract" id="sku_substract">

					<option value=""></option>

					<?php

$dt_view_qry = "SELECT SUM(loop_inventory.boxgood) AS A, loop_inventory.box_id, loop_boxes.bdescription, loop_boxes.sku, loop_boxes.quantity_available FROM loop_inventory ";

$dt_view_qry .= " INNER JOIN loop_boxes ON loop_inventory.box_id = loop_boxes.id ";

$dt_view_qry .= " GROUP BY loop_inventory.box_id ORDER BY loop_boxes.bdescription ";

$dt_view_res = db_query($dt_view_qry);

while ($dt_view_row = array_shift($dt_view_res)) {

    if ($dt_view_row["sku"] != "") {

        ?>

						<option value="<?php echo $dt_view_row["box_id"]; ?>"><?php echo $dt_view_row["bdescription"] . " [" . $dt_view_row["sku"] . "] (" . $dt_view_row["A"] . ")"; ?></option>

					<?php
} else {?>

						<option value="<?php echo $dt_view_row["box_id"]; ?>"><?php echo $dt_view_row["bdescription"] . " (" . $dt_view_row["A"] . ")"; ?></option>

					<?php	}

}?>

				</select>

			</td>

		</tr>



		<tr>

			<td>Quantity</td>

			<td>

				<input type="text" name="qty_sku" id="qty_sku" value=""/>

			</td>

		</tr>



		<tr>

			<td>Available</td>

			<td>

				<input type="number" name="available_sku" id="available_sku" value="0" />

			</td>

		</tr>



		<tr>

			<td>Select the Warehouse to substract from</td>

			<td>

				<select name="warehouse_subc_sku" id="warehouse_subc_sku">

					<option value=""></option>

					<?php

$sql2 = "SELECT * FROM loop_warehouse WHERE rec_type LIKE 'Sorting' ORDER BY company_name";

$result2 = db_query($sql2);

while ($myrowsel2 = array_shift($result2)) {

    ?>

					<option value="<?php echo $myrowsel2["id"]; ?>" <?php

    if ($myrowsel2["id"] == $_REQUEST["warehouse"]) {

        echo " selected ";

    }

    ?>><?php echo $myrowsel2["company_name"]; ?></option>

					<?php
}?>

				</select>

			</td>

		</tr>



		<tr>

			<td>Select the Warehouse to add to</td>

			<td>

				<select name="warehouse_add_sku" id="warehouse_add_sku">

					<option value=""></option>

					<?php

$sql2 = "SELECT * FROM loop_warehouse WHERE rec_type LIKE 'Sorting' ORDER BY company_name";

$result2 = db_query($sql2);

while ($myrowsel2 = array_shift($result2)) {

    ?>

					<option value="<?php echo $myrowsel2["id"]; ?>" <?php

    if ($myrowsel2["id"] == $_REQUEST["warehouse"]) {

        echo " selected ";

    }

    ?>><?php echo $myrowsel2["company_name"]; ?></option>

					<?php
}?>

				</select>

			</td>

		</tr>



		<tr><td colspan=2>

		<input type="hidden" id="action_fld" name="action_fld" value="conv_sku">

		<input type="button" value="Update" onclick="validate_values_sku()"></td><tr>

	</table>



</form>



<br/>

</div>



</body>

</html>

