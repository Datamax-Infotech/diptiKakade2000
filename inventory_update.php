<?php

//require ("inc/header_session.php");

require "../mainfunctions/database.php";

require "../mainfunctions/general-functions.php";

db();

?>

<!DOCTYPE html>

<html>

<head>

	<title>Manual B2B Inventory Adjustment Tool</title>

	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">

	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css' >

<script>

	function validatefrm() {

		var inventoryid = document.getElementsByName('inventoryid[]');

		var oldval = document.getElementsByName('old_val[]');

		var invnotes = document.getElementsByName('invnotes[]');

		var inventoryid_chk = document.getElementsByName('inventoryid_chk[]');



		for (var i = 0, iLen = inventoryid.length; i < iLen; i++) {

			if(inventoryid[i].value!=oldval[i].value)

			{

				if(invnotes[i].defaultValue==invnotes[i].value)

				{

					alert("Please update Notes");

					invnotes[i].focus();

					return false;

				}

				if (invnotes[i].value != "")

				{

					if (inventoryid_chk[i].checked == false){

						alert("Please check the checkbox.");

						inventoryid_chk[i].focus();

						return false;

					}

				}

			}

		}

		if( document.inv_frm.txt_pwd.value == "" ) {

			alert("Please enter Password");

			document.inv_frm.txt_pwd.focus() ;

			return false;

		}

		if( document.inv_frm.txt_pwd.value != "ladykiller" ) {

			alert("Incorrect Password");

			document.inv_frm.txt_pwd.value="";

			document.inv_frm.txt_pwd.focus() ;

			return false;

		}

		return true;

	}

</script>



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



</style>



</head>



<body>

<?php include "inc/header.php";?>

<div class="main_data_css">

	<div class="dashboard_heading" style="float: left;">

		<div style="float: left;">Manual B2B Inventory Adjustment Tool</div>

		&nbsp;<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>

		<span class="tooltiptext">This tool allows the user to move a selected available quantity from one inventory SKU to another. Reasons for this include boxes which are being restacked to different quantities, inventory which was resized to a different height.</span></div>

		<div style="height: 13px;">&nbsp;</div>

	</div>



<?php

?>



<span class="style13"><span class="style15">



<font face="Arial, Helvetica, sans-serif" color="#333333" size="1">

<table><tr><td>

<form name="rptSearch" action="inventory_update.php" method="GET">

<input type="hidden" name="action" value="view">

View Inventory for



<select name="warehouse">

<option value="A">Select Warehouse</option>

<?php

db();
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



&nbsp; <input type="submit" value="View Inventory">

</form>

</td>

<td width="150">&nbsp;



</td>

<td>



</td></tr></table>



<br></span><br>

<br />



<?php

if ($_REQUEST["action"] == 'view' && $_REQUEST["warehouse"] != "") {

    ?>



<form method="post" name="inv_frm" action="inventory_update_submit.php" onsubmit="return validatefrm()">



<input type=hidden name="warehouse_id" value="<?php echo $_REQUEST["warehouse"] ?>">

<input type="hidden" name="page_action" value="1">

  <table cellSpacing="1" cellPadding="1" border="0" width="600" >

    <tr align="middle">

      <td colspan="4" class="style24" style="height: 16px"><strong>INVENTORY</strong></td>

    </tr>

    <tr vAlign="center">

		<td bgColor="#e4e4e4" class="style12" ><strong>&nbsp;</strong></td>

		<td bgColor="#e4e4e4" class="style12" ><strong>Count</strong></td>

		<td bgColor="#e4e4e4" class="style12" ><strong>New Count</strong></td>

		<td bgColor="#e4e4e4" class="style12" ><strong>Notes</strong></td>

		<td bgColor="#e4e4e4" class="style12" ><strong>Box Description</strong></td>

		<td bgColor="#e4e4e4" class="style12" ><strong>Available</strong></td>

    </tr>

<?php
db();
    $dt_view_qry = "SELECT SUM(loop_inventory.boxgood) AS A, loop_inventory.box_id AS B,loop_inventory.id AS invid,  loop_boxes.bdescription AS C, loop_boxes.quantity_available FROM loop_inventory INNER JOIN loop_warehouse ON loop_inventory.warehouse_id = loop_warehouse.id INNER JOIN loop_boxes ON loop_inventory.box_id = loop_boxes.id WHERE loop_warehouse.id = " . $_REQUEST["warehouse"] . " GROUP BY

		loop_warehouse.warehouse_name, loop_inventory.box_id ORDER BY loop_warehouse.warehouse_name, loop_boxes.blength, loop_boxes.bwidth, loop_boxes.bdepth";

    //echo $dt_view_qry . "<br>";

    $dt_view_res = db_query($dt_view_qry);

    while ($dt_view_row = array_shift($dt_view_res)) {

        ?>

			<tr vAlign="center">

				<td bgColor="#e4e4e4" class="style12" > <input type="checkbox" name="inventoryid_chk[]" value="<?php echo $dt_view_row["B"]; ?>"></td>

				<td bgColor="#e4e4e4" class="style12" > <input type="hidden" name="old_val[]" value="<?php echo $dt_view_row["A"]; ?>"><?php echo $dt_view_row["A"]; ?></td>

				<td bgColor="#e4e4e4" class="style12" ><input type=text size=8 name="inventoryid[]" value="<?php echo $dt_view_row["A"]; ?>"></td>

				<td bgColor="#e4e4e4" class="style12left">

					<input type=text name="invnotes[]" id="invnotes" />

				</td>

				<td bgColor="#e4e4e4" class="style12left">

    				<input type="hidden" name="boxid[]" value="<?php echo $dt_view_row["B"]; ?>">

					<font size=1><?php echo $dt_view_row["C"]; ?></font>

				</td>

				<td bgColor="#e4e4e4" class="style12" >

					<input type=text size=8 name="quan_available[]" value="<?php echo $dt_view_row["quantity_available"] ?>">

				</td>

		</tr>



	<?php
}?>



		 <tr>

		<td class="style12">

			Password:

		</td>

		<td colspan=3>

			<input name="txt_pwd" id="txt_pwd" type="password">

		</td>

	</tr>

	<tr><td colspan=4><input type="submit" name="btnsubmit" id="btnsubmit" value="Update Inventory"></td><tr>

  </table>

</form>

<br>

<?php

}

?>

</div>

</body>

</html>