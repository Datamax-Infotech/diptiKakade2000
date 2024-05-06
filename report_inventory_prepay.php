<?php
//require "inc/header_session.php";
require "../mainfunctions/database.php";
require "../mainfunctions/general-functions.php";
?>
<!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Supplier Inventory Prepay Active list</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<style type="text/css">
	.txtstyle_color
	{
		font-family:arial;
		font-size:12;
		height: 16px;
		background:#ABC5DF;
	}

	.black_overlay{
		display: none;
		position: absolute;
		top: 0%;
		left: 0%;
		width: 100%;
		height: 100%;
		background-color: gray;
		z-index:1001;
		-moz-opacity: 0.9;
		opacity:.90;
		filter: alpha(opacity=90);
	}

	.white_content {
		display: none;
		position: absolute;
		top: 5%;
		left: 10%;
		width: 60%;
		height: 90%;
		padding: 16px;
		border: 1px solid gray;
		background-color: white;
		z-index:1002;
		overflow: auto;
	}

	table.table_style {
	  margin: 15px 0;
		width: 70%;
		white-space: nowrap;
	}

	table.table_style tr td{
		padding: 5px;
		font-family: Arial, Helvetica, sans-serif;
		font-size: x-small;
		}
		table.table_style tr:nth-child(2) td{
	   font-weight: bold;
    }
</style>

</head>

    <SCRIPT LANGUAGE="JavaScript" SRC="inc/CalendarPopup.js"></SCRIPT><SCRIPT LANGUAGE="JavaScript" SRC="inc/general.js"></SCRIPT>
	<script LANGUAGE="JavaScript">document.write(getCalendarStyles());</script>
	<script LANGUAGE="JavaScript">
		var cal2xx = new CalendarPopup("listdiv");
		cal2xx.showNavigationDropdowns();
	</script>

<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css' >
<LINK rel='stylesheet' type='text/css' href='one_style.css' >
<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">

<body>
    <div id="light" class="white_content"></div>
    <div id="fade" class="black_overlay"></div>

<?php include "inc/header.php";?>
<div class="main_data_css">

	<div class="dashboard_heading" style="float: left;">
		<div style="float: left;">
			Supplier Inventory Prepay Active list

			<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
			<span class="tooltiptext">This report display Supplier Inventory Prepay Active list.</span></div><br>
		</div>
	</div>

	<div>
<?php
db();
//$dt_view_qry = "Select id, b2b_id, vendor_b2b_rescue, bdescription from loop_boxes where Prepay = 1 order by b2b_id ";
$dt_view_qry = "Select vendor_b2b_rescue from loop_boxes where Prepay = 1 group by vendor_b2b_rescue order by vendor_b2b_rescue ";
$data_res = db_query($dt_view_qry);

if (tep_db_num_rows($data_res) > 0) {

    ?>
	<table width="800px" border="0" cellspacing="1" cellpadding="1" >
		<tr>
			<td width="20px" bgcolor="#ABC5DF">Sr No.
			</td>

			<td width="200px" bgcolor="#ABC5DF">Supplier</td>

			<!-- <td width="200px" bgcolor="#ABC5DF" align="center">Inventory</td>-->

		</tr>
	<?php
$cnt = 1;
    while ($data = array_shift($data_res)) {
        $rowcolor = "#E4E4E4";

        $b2bid = "";
        $dt_view_qry1 = "Select b2bid from loop_warehouse where rec_type = 'Manufacturer' and id = '" . $data["vendor_b2b_rescue"] . "'";
        $data_res1 = db_query($dt_view_qry1);
        while ($data1 = array_shift($data_res1)) {
            $b2bid = $data1["b2bid"];
        }

        if ($b2bid != "") {
            $nickname = get_nickname_val("Blank", $b2bid);

            $rowcolor = "#E4E4E4";
            ?>
				<tr valign="middle">
					<td bgcolor="<?php echo $rowcolor ?>"><?php echo $cnt; ?></td>

					<td bgcolor="<?php echo $rowcolor ?>">
						<a target="_blank" href="viewCompany.php?ID=<?php echo $b2bid ?>&proc=View">
						<?php echo $nickname; ?></a>
					</td>

					<!-- <td bgcolor="<?php echo $rowcolor ?>">
						<a target="_blank" href="manage_box_b2bloop.php?id=<?php echo $data["id"] ?>&proc=View">
						<?php echo $data["bdescription"]; ?></a>
					</td> -->

				</tr>
				<?php
}
        $cnt = $cnt + 1;

    }?>
	</table>
<?php
}
?>
	</div>
</div>

</body>

</html>