<?php

?>
<?php
session_start();
if (!$_COOKIE['userloggedin']) {
    header("location:login.php");
}

// require "inc/header_session.php";
require "../mainfunctions/database.php";
require "../mainfunctions/general-functions.php";
?>
<!DOCTYPE html>

<html>
<head>
	<title>WATER Materials Master Database</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/water_vendor_master.css">
	<link rel="stylesheet" href="one_style.css">

	<style>
		.style_txt {
			font-size: 10pt;
			font-family: Arial, Helvetica, sans-serif;
			text-align: center;
		}
	</style>

	<LINK rel='stylesheet' type='text/css' href='one_style.css' >
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>
</head>

<body>
	<?php include "inc/header.php";?>
	<div class="main_data_css">
		<div class="dashboard_heading" style="float: left;">
			<div style="float: left;">WATER Materials Master Database
				<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
				<span class="tooltiptext">
					UCB Zero Waste Material Database
				</span></div>

				<div style="height: 13px;">&nbsp;</div>
				</div>
		</div>
		<div id="light" class="white_content"></div>
		<div id="fade" class="black_overlay"></div>

		<?php
		if (isset($_REQUEST["compid"]) && $_REQUEST["compid"] != "") {
			?>
			<a href="viewCompany.php?ID=<?php echo $_REQUEST["compid"]; ?>&proc=View&searchcrit=&show=watertransactions&rec_type=Manufacturer">Home</a>
		<?php
		} else {

		}

		$sorturl = "water_material_master_table.php?compid=" . $_REQUEST['compid'];
		$imgasc = '<img src="images/sort_asc.png" width="6px;" height="12px;">';
		$imgdesc = '<img src="images/sort_desc.png" width="6px;" height="12px;">';

		?>
		&nbsp;&nbsp;
		<a href="water_index.php">Return to UCBZeroWaste Index Homepage</a>
		<br>
		&nbsp;&nbsp;
		<a href="water_manage_box_b2bloop.php?proc=New" target="_blank">Add New WATER Material</a>
		<br><br>

		<table cellSpacing="1" cellPadding="1" border="0">
			<tr>

				<td valign="top">

					<table cellSpacing="1" cellPadding="1" border="0" style="width:1000px" id="table1">
						<tr align="middle" >
							<th bgColor="#c0cdda" colspan="7" class='style24' style = "height: 16px; text-align:middle;">
								WATER ITEMS
							</th>
						</tr>
						<tr bgColor="#c0cdda">
							<th align="left" height="13" class="style12" ><strong>MATERIAL CATEGORY</strong>&nbsp;
								<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=category"><?php echo $imgasc; ?></a>&nbsp;
								<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=category"><?php echo $imgdesc; ?></a>
							</th>
							<th align="left" height="13" class="style12" ><strong>MATERIAL</strong>&nbsp;
								<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=material"><?php echo $imgasc; ?></a>&nbsp;
								<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=material"><?php echo $imgdesc; ?></a>
							</th>
							<th align="left" height="13" class="style12" ><strong>OUTLET</strong>&nbsp;
								<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=outlet"><?php echo $imgasc; ?></a>&nbsp;
								<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=outlet"><?php echo $imgdesc; ?></a>
							</th>
							<th align="left" height="13" class="style12" ><strong>COST</strong>&nbsp;
								<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=cost"><?php echo $imgasc; ?></a>&nbsp;
								<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=cost"><?php echo $imgdesc; ?></a>
							</th>
							<th align="left" height="13" class="style12" ><strong>REVENUE</strong>&nbsp;
								<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=revenue"><?php echo $imgasc; ?></a>&nbsp;
								<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=revenue"><?php echo $imgdesc; ?></a>
							</th>
							<th align="left" height="13" class="style12" ><strong>VENDOR</strong>&nbsp;
								<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=vendor"><?php echo $imgasc; ?></a>&nbsp;
								<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=vendor"><?php echo $imgdesc; ?></a>
							</th>
							<th align="left" height="13" class="style12" style="min-width:180px;" ><strong>Options</strong></th>
						</tr>

							<?php
							if (!isset($_REQUEST["sort"])) {
								db();
								$get_boxes_query = db_query("SELECT *, water_inventory.description AS mat_description, water_inventory.id AS LBID FROM water_inventory left join water_vendors on water_vendors.id = water_inventory.vendor order by water_vendors.Name , water_vendors.city, water_vendors.state, water_vendors.zipcode");
								$MGArray = array();
								while ($boxes = array_shift($get_boxes_query)) {

									$b2b_vendor = 0;
									$b2b_fob = 0;
									$b2b_cost = 0;
									$b2b_ulineDollar = round($boxes["ulineDollar"]);
									$b2b_ulineCents = $boxes["ulineCents"];
									$b2b_fob = $b2b_ulineDollar + $b2b_ulineCents;
									$b2b_fob = "$ " . number_format($b2b_fob, 2);

									$b2b_costDollar = round($boxes["costDollar"]);
									$b2b_costCents = $boxes["costCents"];
									$b2b_cost = $b2b_costDollar + $b2b_costCents;
									$b2b_cost = "$ " . number_format($b2b_cost, 2);

									$b2b_vendor = $boxes["vendor"];

									$sql_getdata = "SELECT * FROM water_vendors where active_flg = 1 and id = '" . $b2b_vendor . "'";
									db();
									$query = db_query($sql_getdata);
									$vender_nm = "";
									while ($rowsel_getdata = array_shift($query)) {
										$vender_nm = trim($rowsel_getdata['Name'] . " - " . $rowsel_getdata['city'] . ", " . $rowsel_getdata['state'] . " " . $rowsel_getdata['zipcode']);
									}

									$materialcat = "";
									$sqlnew = "SELECT material from water_vendor_materials where id='" . $boxes["materialcategory"] . "'";
									db();
									$querynew = db_query($sqlnew);
									while ($rowsel_getdata = array_shift($querynew)) {
										$materialcat = $rowsel_getdata['material'];
									}

									$cost = "";
									$revenue = "";
									$AmountUnit = "";
									$Amount_val = number_format($boxes["Amount"], 2);
									if ($boxes["WeightorNumberofPulls"] == "By Weight") {
										if ($boxes["AmountUnit"] == "Tons") {
											$AmountUnit = "tons";
										}
										if ($boxes["AmountUnit"] == "Pounds") {
											$AmountUnit = "lbs";
										}
										if ($boxes["AmountUnit"] == "Kilograms") {
											$AmountUnit = "kg";
										}

										if ($boxes["CostOrRevenuePerUnit"] == "Cost Per Unit") {
											$cost = "$" . $Amount_val . "/" . $AmountUnit;
										}
										if ($boxes["CostOrRevenuePerUnit"] == "Revenue Per Unit") {
											$revenue = "$" . $Amount_val . "/" . $AmountUnit;
										}
									}

									if ($boxes["WeightorNumberofPulls"] == "By Number of Pulls") {

										$cost = "$" . $Amount_val . "/Pull";
									}

									$MGArray[] = array('bpallet_qty' => $boxes["quantity_per_pallet"], 'boxes_per_trailer' => $boxes["quantity"],
										'bdescription' => $boxes["mat_description"], 'outlet' => $boxes["Outlet"], 'boxesid' => $boxes["LBID"],
										'sku' => $boxes["sku"], 'b2b_fob' => $b2b_fob, 'b2b_cost' => $b2b_cost, 'boxgoodvalue' => $boxes["boxgoodvalue"],
										'vender_nm' => $vender_nm, 'WeightorNumberofPulls' => $boxes["WeightorNumberofPulls"],
										'AmountUnit' => $boxes["AmountUnit"], 'CostOrRevenuePerUnit' => $boxes["CostOrRevenuePerUnit"],
										'Amount' => $boxes["Amount"], 'CostOrRevenuePerPull' => $boxes["CostOrRevenuePerPull"],
										'materialcategory' => $materialcat, 'cost' => $cost, 'revenue' => $revenue);
								}
								$_SESSION['sortarrayn'] = $MGArray;

								$MGArraysort_I = array();
								foreach ($MGArray as $MGArraytmp) {
									$MGArraysort_I[] = $MGArraytmp['vender_nm'];
								}
								array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);

							} else {

							$MGArray = $_SESSION['sortarrayn'];
							if ($_REQUEST['sort'] == "category") {
								$MGArraysort_I = array();

								foreach ($MGArray as $MGArraytmp) {
									$MGArraysort_I[] = $MGArraytmp['materialcategory'];
								}

								if ($_REQUEST['sort_order_pre'] == "ASC") {
									array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
								}
								if ($_REQUEST['sort_order_pre'] == "DESC") {
									array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
								}
							}
							if ($_REQUEST['sort'] == "material") {
								$MGArraysort_I = array();

								foreach ($MGArray as $MGArraytmp) {
									$MGArraysort_I[] = $MGArraytmp['bdescription'];
								}

								if ($_REQUEST['sort_order_pre'] == "ASC") {
									array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
								}
								if ($_REQUEST['sort_order_pre'] == "DESC") {
									array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
								}
							}
							if ($_REQUEST['sort'] == "outlet") {
								$MGArraysort_I = array();

								foreach ($MGArray as $MGArraytmp) {
									$MGArraysort_I[] = $MGArraytmp['outlet'];
								}

								if ($_REQUEST['sort_order_pre'] == "ASC") {
									array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
								}
								if ($_REQUEST['sort_order_pre'] == "DESC") {
									array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
								}
							}
							if ($_REQUEST['sort'] == "cost") {
								$MGArraysort_I = array();

								foreach ($MGArray as $MGArraytmp) {
									$MGArraysort_I[] = $MGArraytmp['cost'];
								}

								if ($_REQUEST['sort_order_pre'] == "ASC") {
									array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
								}
								if ($_REQUEST['sort_order_pre'] == "DESC") {
									array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
								}
							}
							if ($_REQUEST['sort'] == "revenue") {
								$MGArraysort_I = array();

								foreach ($MGArray as $MGArraytmp) {
									$MGArraysort_I[] = $MGArraytmp['revenue'];
								}

								if ($_REQUEST['sort_order_pre'] == "ASC") {
									array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
								}
								if ($_REQUEST['sort_order_pre'] == "DESC") {
									array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
								}
							}
							if ($_REQUEST['sort'] == "vendor") {
								$MGArraysort_I = array();

								foreach ($MGArray as $MGArraytmp) {
									$MGArraysort_I[] = $MGArraytmp['vender_nm'];
								}

								if ($_REQUEST['sort_order_pre'] == "ASC") {
									array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
								}
								if ($_REQUEST['sort_order_pre'] == "DESC") {
									array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
								}
							}
						}

						foreach ($MGArray as $MGArraytmp2) {

							?>
									<tr bgColor="#e4e4e4">
										<td height="13" class="style_txt" align="right">
											<?php echo $MGArraytmp2["materialcategory"]; ?>
										</td>

										<td align="left" height="13" class="style_txt">
											<a target="_blank" href="water_manage_box_b2bloop.php?id=<?php echo $MGArraytmp2["boxesid"]; ?>&compid=<?php echo $_REQUEST["ID"]; ?>&proc=View"><font size="1" Face="arial"><?php echo $MGArraytmp2["bdescription"]; ?></font></a>
										</td>

										<td height="13" class="style_txt" align="right">
											<?php echo $MGArraytmp2["outlet"]; ?>
										</td>

										<td height="13" class="style_txt" align="right">
											<?php echo $MGArraytmp2["cost"]; //echo $cost;  ?>
										</td>

										<td height="13" class="style_txt" align="right">
											<?php echo $MGArraytmp2["revenue"]; //echo $revenue;   ?>
										</td>

										<td height="13" class="style_txt" align="right" >
											<?php echo $MGArraytmp2["vender_nm"]; ?>
											<input type="hidden" name="box_id[]" value="<?php echo $MGArraytmp2["boxesid"]; ?>"/>
										</td>
										<td height="13" class="style_txt" align="right" >
											<a href="water_manage_box_b2bloop.php?id=<?php echo $MGArraytmp2["boxesid"]; ?>&proc=Edit&flag=yes" target="_blank">Edit This Item</a>&ensp;
											<a href="water_manage_box_b2bloop.php?id=<?php echo $MGArraytmp2["boxesid"]; ?>&proc=Delete" target="_blank">Delete This Item</a>
										</td>
									</tr>

						<?php
						}?>
						<tr bgColor="#e4e4e4">
							<td align="center" colspan="7" height="13" class="style_txt">

								&nbsp;<font face="arial"  size="1"><a href="water_manage_box_b2bloop.php?proc=New" target="_blank">Add New WATER Material</a></font>
							</td>
						</tr>
					</table>
				</td>


			</tr>
		</table>

	</div>
</body>
</html>