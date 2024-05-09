<?php

session_start();

if (!$_COOKIE['userloggedin']) {

    header("location:login.php");

}

//require "inc/header_session.php";

require "../mainfunctions/database.php";

require "../mainfunctions/general-functions.php";

?>


<!DOCTYPE html>



<head>

	<title>Pickup Request Management <?php echo "Logged in as : " . $_COOKIE['userinitials']; ?></title>

	<meta http-equiv="refresh" content="3000">







	<style type="text/css">

		.main_data_css{

			margin: 0 auto;

			width: 100%;

			height: auto;

			clear: both !important;

			padding-top: 35px;

			margin-left: 10px;

			margin-right: 10px;

		}



	.stylenew {

		font-size: 8pt;

		font-family: Arial, Helvetica, sans-serif;

		color: #333333;

		text-align: left;

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

		-moz-opacity: 0.8;

		opacity:.80;

		filter: alpha(opacity=80);

	}



	.white_content_reminder {

		display: none;

		position: absolute;

		top: 10%;

		left: 10%;

		width: 70%;

		height: 85%;

		padding: 16px;

		border: 1px solid gray;

		background-color: white;

		z-index:1002;

		overflow: auto;

		box-shadow: 8px 8px 5px #888888;

	}



	.white_content {

		display: none;

		position: absolute;

		top: 10%;

		left: 10%;

		width: 35%;

		height: 25%;

		padding: 16px;

		border: 1px solid gray;

		background-color: white;

		z-index:1002;

		overflow: auto;

		box-shadow: 8px 8px 5px #888888;

	}

	table.sales_pipeline_style{

		 border-collapse: collapse;

	}

	table.sales_pipeline_style td{

		border-top: 1px solid #FFFFFF;

		padding:4px;

	}

	.tooltip {

	position: relative;

	display: inline-block;

	font-size: 11px;

	}


	.tooltip .tooltiptext {

	visibility: hidden;

	width: 180px;

	background-color: #464646;

	color: #fff;

	text-align: left;

	border-radius: 6px;

	padding: 5px 7px;

	position: absolute;

	z-index: 1;

	top: -5px;

	left: 110%;



		font-size: 11px;

		font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif!important;

	}



		.tooltip .tooltiptext::after {

		content: "";

		position: absolute;

		top: 35%;

		right: 100%;

		margin-top: -5px;

		border-width: 5px;

		border-style: solid;

		border-color: transparent black transparent transparent;

		}

		.tooltip:hover .tooltiptext {

		visibility: visible;

		}

		table.impl_css{

			 border-collapse: collapse;

		}

		table.impl_css tr th{

			border: 1px solid #FFFFFF;

			font-size: 12px;

			font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif!important;

		}

		table.impl_css tr td{

			border: 1px solid #FFFFFF;

			font-size: 12px;

			font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif!important;

		}

		table.impl_css tr th.border_left, table.impl_css tr td.border_left{

			border-left: 1px solid #727272;

		}

		table.impl_css tr th.border_right, table.impl_css tr td.border_right{

			border-right: 1px solid #727272;

		}

</style>



</head>

<body>
<?php

echo "<LINK rel='stylesheet' type='text/css' href='one_style.css' >";

?>





<?php include "inc/header.php";?>

	<br><br>

<div class="main_data_css">

	<P align="center">&nbsp;&nbsp;<strong><font face="Arial" Size="3">WATER PICKUP REQUEST MANAGEMENT</font></strong><br><br></p>



	<table border="0" cellpadding="5" cellspacing="2" width="99%" align="center">

		<tr align="middle">

			<td>

				<table cellSpacing="0" cellPadding="2" border="0" width="450" class="sales_pipeline_style" >

					<tr align="middle">

					  <td class="style24" style="height: 16px">

						  <?php

$comp_qr = "Select * from companyInfo where ucbzw_account_status = 83";
db_b2b();
$comp_row1 = db_query($comp_qr);

$total_implementation = tep_db_num_rows($comp_row1);

?>

						  <strong><span style="text-transform: uppercase">PICKUP REQUEST MANAGEMENT</span>

						</strong>

						</td>

					</tr>

					<tr vAlign="center">

						<td bgColor="#e4e4e4" class="stylenew" style="width: 10%">

							<?php

$main_sql = "Select loop_warehouse.id as wid, water_loop_transaction.id as rec_id, loop_warehouse.company_name, loop_warehouse.b2bid from water_loop_transaction inner join loop_warehouse on loop_warehouse.id = water_loop_transaction.warehouse_id where (water_loop_transaction.pr_requestdate <> '' or water_loop_transaction.pr_requestdate is not null) and loop_warehouse.rec_type = 'Manufacturer'";
db();
$data_res = db_query($main_sql);

$data = array_shift($data_res);

$pr_num = tep_db_num_rows($data_res);

?>

							<a href='pickup_request_all.php' target='_blank'>

							Pick Up Requests (<?php echo "<span style='color:blue;'>" . $pr_num . "</span>"; ?>)</a>

						</td>

					</tr>

					 <tr vAlign="center">

						<td bgColor="#e4e4e4" class="stylenew" style="width: 10%">

							<?php

$main_sql1 = "Select loop_warehouse.id as wid, water_loop_transaction.id as rec_id, loop_warehouse.company_name, loop_warehouse.b2bid from water_loop_transaction inner join loop_warehouse on loop_warehouse.id = water_loop_transaction.warehouse_id where (water_loop_transaction.pa_pickupdate = '' or water_loop_transaction.pa_pickupdate is null) and loop_warehouse.rec_type = 'Manufacturer'";
db();
$data_res1 = db_query($main_sql1);

$data1 = array_shift($data_res1);

$pr_notcomfirm = tep_db_num_rows($data_res1);

?>

							<a href='pickup_request.php?show=notconfirmed' target='_blank'>

							Pickups Requested and Not Confirmed (<?php echo "<span style='color:red;'>" . $pr_notcomfirm . "</span>"; ?>)</a>

						</td>

					</tr>

					  <tr vAlign="center">

						<td bgColor="#e4e4e4" class="stylenew" style="width: 10%">

							<?php

$main_sql_conf = "Select loop_warehouse.id as wid, water_loop_transaction.id as rec_id, loop_warehouse.company_name, loop_warehouse.b2bid from water_loop_transaction inner join loop_warehouse on loop_warehouse.id = water_loop_transaction.warehouse_id where (water_loop_transaction.pa_pickupdate <> '' or water_loop_transaction.cnfmPickup = 'Confirmed' ) and (water_loop_transaction.cp_date = '' or water_loop_transaction.cp_date is null) and loop_warehouse.rec_type = 'Manufacturer'";
db();
$data_res_conf = db_query($main_sql_conf);

$pr_confirm = tep_db_num_rows($data_res_conf);

$data_conf = array_shift($data_res_conf);

?>

							<a href='pickup_request.php?show=confirmed' target='_blank'>

							Pickups Requested and Confirmed (<?php echo "<span style='color:blue;'>" . $pr_confirm . "</span>"; ?>)</a>

						</td>

					</tr>

					  <tr vAlign="center">

						<td bgColor="#e4e4e4" class="stylenew" style="width: 10%">

								<?php

$main_sql_compl = "Select loop_warehouse.id as wid, water_loop_transaction.id as rec_id, loop_warehouse.company_name, loop_warehouse.b2bid from water_loop_transaction inner join loop_warehouse on loop_warehouse.id = water_loop_transaction.warehouse_id where (water_loop_transaction.cp_date <> '' and water_loop_transaction.pa_pickupdate <> '') and loop_warehouse.rec_type = 'Manufacturer'";
db();
$data_res_compl = db_query($main_sql_compl);

$pr_compl = tep_db_num_rows($data_res_compl);

$data_compl = array_shift($data_res_compl);

?>

							<a href='pickup_request.php?show=completed' target='_blank'>Pickups Completed (<?php echo "<span style='color:green;'>" . $pr_compl . "</span>"; ?>)</a>

						</td>

					</tr>



				  </table>

			</td>

		</tr>

	</table>

</div>

</body>

</html>