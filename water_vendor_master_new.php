<?php

session_start();
if (!$_COOKIE['userloggedin']) {
    header("location:login.php");
}

//require "inc/header_session.php";
ini_set("display_errors", "1");

error_reporting(E_ERROR);
require "../mainfunctions/database.php";
require "../mainfunctions/general-functions.php";

// function ThrowError(string $err_type, string $err_descr): string {
//     $err_text = "";
//     switch ($err_type) {
//         case "9991SQLresultcount":
//             return "<BR><B>ERROR:  --> " . mysqli_error() . "</b>
//                     <BR>LOCATION: $err_type
//                     <BR>DESCRIPTION: Unable to execute SQL statement.
//                     <BR>Please Check the Following:
//                     <BR>- Ensure the Table(s) Exists in database $dbname
//                     <BR>- Ensure All Fields Exist in the Table(s)
//                     <BR>- SQL STATEMENT: $err_descr<BR>
//                     <BR>- MYSQL ERROR: " . mysqli_error();
//             break;
//         case "9994SQL":
//             return "<BR><B>ERROR:  --> " . mysqli_error() . "</b>
//                     <BR>LOCATION: $err_type
//                     <BR>DESCRIPTION: Unable to execute SQL statement.
//                     <BR>Please Check the Following:
//                     <BR>- Ensure the Table(s) Exists in database $dbname
//                     <BR>- Ensure All Fields Exist in the Table(s)
//                     <BR>- SQL STATEMENT: $err_descr<BR>
//                     <BR>- MYSQL ERROR: " . mysqli_error();
//             break;
//         default:
//             return "UNKNOWN ERROR TYPE: $err_type
//                     <BR>DESCR: $err_descr<BR>";
//             break;
//     } //end switch

//     return $err_text;
// }

?>
<!DOCTYPE html>

<html>
<head>
	<title>Vendors Master Database </title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/water_vendor_master.css">
	<link rel="stylesheet" href="one_style.css">
	<script src="scripts/common.js"></script>

	<link href="css/multiselect.css" rel="stylesheet"/>
<script src="multiselect.min.js"></script>

	<LINK rel='stylesheet' type='text/css' href='one_style.css' >
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>
		<SCRIPT LANGUAGE="JavaScript" SRC="inc/CalendarPopup.js"></SCRIPT>
	<script LANGUAGE="JavaScript">document.write(getCalendarStyles());</script>
	<script language="javascript">
		var calcoidt = new CalendarPopup("listdiv_coidt");
		calcoidt.showNavigationDropdowns();

		var caldate_of_bill_switchdt = new CalendarPopup("listdiv_date_of_bill_switchdt");
		caldate_of_bill_switchdt.showNavigationDropdowns();


	</script>
	<style>
		.TBL_ROW_DATA_RED
		{
			FONT-SIZE: 11px;
			BACKGROUND-COLOR: #ee735b;
		}
		.TBL_ROW_DATA_GREEN
		{
			FONT-SIZE: 11px;
			BACKGROUND-COLOR: #99FF99;
		}

		.main_data_css{
			width:auto;
		}
		.vendors_master_database_table{
			table-layout:fixed;
			border:solid 1px #000;
			border-collapse:collapse;
			margin-top:5px;
		}
		.vendors_master_database_table th{
			background:#000;
			color:#FFF;
			border: solid 1px #000;
			padding: 5px;
		}
		.vendors_master_database_table td{
			padding:5px;
			vertical-align: top;
		}
		.vendors_master_database_table .frmlabel {
			font:bold 11.5px Arial;
		}
		.vendor_inner_table{
			width:100%;
		}
		.contact_inner_table{
			border:solid 1px #000;
			margin-top:2px;
			margin-bottom: 5px;
		}
		.inner_table_header{
			background:#DDD;
			text-align: center;
		}
		.vendor_receivable_form_table{
			border:solid 1px #eee;
			width:100%;
		}
		.text-center{
			text-align: center;
		}
	</style>
</head>

<body>
	<?php include "inc/header.php";?>
<div class="main_data_css">

	<?php if ($_REQUEST["posting"] == "yes") {?>
		<div class="dashboard_heading" style="float: left;">
			<div style="float: left;">Vendors Master Database

				<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
				<span class="tooltiptext">
					UCB Zero Waste Master Database
				</span></div>

				<div style="height: 13px;">&nbsp;</div>
			</div>
		</div>
	<?php } else {?>
		<div class="dashboard_heading" style="float: left;">
			<div style="float: left;">Vendor Record

				<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
				<span class="tooltiptext">
					The Vendor Record below has information and insights into this specific vendor. Discover the point of contact, billing switch status, and locality details instantly.
				</span></div>

				<div style="height: 13px;">&nbsp;</div>
			</div>
		</div>
	<?php }?>


	<div id="light" class="white_content"></div>
	<div id="fade" class="black_overlay"></div>
<?php

$thispage = $SCRIPT_NAME; //SET THIS TO THE NAME OF THIS FILE
$pagevars = ""; //INSERT ANY "GET" VARIABLES HERE...

$allowedit = "yes"; //SET TO "no" IF YOU WANT TO DISABLE EDITING
$allowaddnew = "yes"; //SET TO "no" IF YOU WANT TO DISABLE NEW RECORDS
$allowview = "yes"; //SET TO "no" IF YOU WANT TO DISABLE VIEWING RECORDS
$allowdelete = "yes"; //SET TO "no" IF YOU WANT TO DISABLE DELETING RECORDS
$allowinactive = "yes"; //SET TO "no" IF YOU WANT TO DISABLE INACTIVE RECORDS

$addl_select_crit = "order by Name"; //ADDL CRITERIA FOR SQL STATEMENTS (ADD/UPD/DEL).
$addl_update_crit = ""; //ADDITIONAL CRITERIA FOR UPDATE STATEMENTS.
$addl_insert_crit = ""; //ADDITIONAL CRITERIA FOR INSERT STATEMENTS.
$addl_insert_values = ""; //ADDITIONAL VALUES FOR INSERT STATEMENTS.

if (isset($_REQUEST["proc"])) {$proc = $_REQUEST["proc"];} else { $proc = "";}
if (isset($_REQUEST["posting"])) {$posting = $_REQUEST["posting"];} //else{ $posting = ""; }
if (isset($_REQUEST["compid"]) && $_REQUEST["compid"] != "") {
    ?>
	<a href="viewCompany.php?ID=<?php echo $_REQUEST["compid"]; ?>&proc=View&searchcrit=&show=watertransactions&rec_type=Manufacturer">Return to UCBZeroWaste Index Homepage</a><br>
<?php
} else {
    ?>
		<a href="water_index.php">Return to UCBZeroWaste Index Homepage</a>&nbsp;
	<?php
}

if ($proc == "View") {
    ?>

<?php
}
if ($proc == "") {
    if ($allowaddnew == "yes") {
        ?>
	<a href="<?php echo $thispage; ?>?proc=New&<?php echo $pagevars; ?>&compid=<?php echo $_REQUEST["compid"]; ?>">Add New Entry</a>&nbsp;
	<a href="<?php echo $thispage; ?>?posting=active_inactive&compid=<?php echo $_REQUEST["compid"]; ?>">View all Active and Inactive Entry</a><br><br>
	<?php
}?>

	<?php if ($_REQUEST["recadded"] == "y") {?>
		<br><font size="2" color="green">Record Added</font><br>
	 <?php }?>
	 <?php if ($_REQUEST["recupdated"] == "y") {?>
		<br><font size="2" color="green">Record Updated</font><br>
	 <?php }?>
	 <?php if ($_REQUEST["recdel"] == "y") {?>
		<br><font size="2" color="green">Record Deleted</font><br>
	 <?php }?>
	 <?php if ($_REQUEST["recinactive"] == "y") {?>
		<br><font size="2" color="green">Inactive/Active Flag Updated</font><br>
	 <?php }?>

<?php
if ($posting == "yes") {?>
		<div>
			<form method="POST" name="abc" action="">
				<table border="0">
					<tr>
						<input type="hidden" name="posting" value="<?php echo $_REQUEST['posting'] ?>">
						<input type="hidden" name="compid" value="<?php echo $_REQUEST['compid'] ?>">
						<td class="row_view">Vendor Name:</td>
						<td class="row_view"><input type="text" name="vendorname" value="<?php echo $_POST["vendorname"]; ?>" /></td>

						<td class="row_view">Materials Managed:</td>
						<td rowspan="2" class="row_view" valign="top">
							<Select id="vmaterial" name="vendormaterial[]" multiple>
							<?php
								$txtselected = "";
								$materialarr = []; // Initialize material array
								if(isset($_POST["vendormaterial"]) && is_array($_POST["vendormaterial"])) {
									db();
									$sqlfrm = "SELECT id, material FROM water_vendor_materials ORDER BY material ASC";
									$materialarr = db_query($sqlfrm);
									foreach ($materialarr as $row) {
										if (in_array($row["id"], $_POST["vendormaterial"])) {
											$txtselected = "selected";
										} else {
											$txtselected = "";
										}
										echo '<option value="' . $row["id"] . '"  ' . $txtselected . '>' . $row["material"] . '</option>';
									}
								}
							?>

							</select>
						</td>

						<td class="row_view">Vendor State:</td>
						<td class="row_view">
							<Select id="vendorstate" name="vendorstate[]" multiple>

							<?php
								$txtselected = "";
								$materialarr = []; // Initialize material array
								if(isset($_POST["vendorstate"]) && is_array($_POST["vendorstate"])) {
									db();
									$sqlfrm = "SELECT * FROM state_master ORDER BY state";
									$materialarr = db_query($sqlfrm);
									foreach ($materialarr as $row) {
										if (in_array($row["state"], $_POST["vendorstate"])) {
											$txtselected = "selected";
										} else {
											$txtselected = "";
										}
										echo '<option value="' . $row["state"] . '"  ' . $txtselected . '>' . $row["state"] . '</option>';
									}
								}
							?>

							</select>




						</td>
						<td rowspan="2" class="row_view">
							<input type=submit value="Filter">
						</td>
					</tr>
					<tr>
						<td class="row_view">Keyword:</td>
						<td class="row_view"><input type="text" name="vendorkeyword" value="<?php echo $_POST["vendorkeyword"]; ?>" /></td>
						<td class="row_view">COI Expired:
							<Select id="coi_expired_flg_sel" name="coi_expired_flg_sel" >
								<option value=""  <?php echo (($_POST["coi_expired_flg"] == "") ? "selected" : ""); ?>></option>
								<option value="Yes" <?php echo (($_POST["coi_expired_flg"] == "Yes") ? "selected" : ""); ?>>Yes</option>
								<option value="No"  <?php echo (($_POST["coi_expired_flg"] == "No") ? "selected" : ""); ?>>No</option>
							</select>
						</td>
						<td class="row_view">Vendor Status:</td>
						<td class="row_view">
							<Select id="vendorstatus" name="vendorstatus[]" multiple>
								<option value="1"  <?php echo ((($_POST["vendorstatus"] == 1) || ($_POST["vendorstatus"] == 0)) ? "selected" : ""); ?>>Active Vendor</option>
								<option value="2"  <?php echo (($_POST["vendorstatus"] == 2) ? "selected" : ""); ?>>Known Vendor</option>
								<option value="99"  <?php echo (($_POST["vendorstatus"] == 99) ? "selected" : ""); ?>>Do not use Vendor</option>
							</select>
						</td>


					</tr>
				</table>
			</form>
		</div>
		<link href="css/multiselect.css" rel="stylesheet"/>
		<script src="multiselect.min.js"></script>
		<script>
	            document.multiselect('#vmaterial').setCheckBoxClick("checkboxAll", function(target, args) {
				})
				.setCheckBoxClick("1", function(target, args) {
				});
				//Multiselect for State
				document.multiselect('#vendorstate')
				.setCheckBoxClick("checkboxAll", function(target, args) {
				})
				.setCheckBoxClick("1", function(target, args) {
				});
				//Multiselect for Status
				document.multiselect('#vendorstatus')
				.setCheckBoxClick("checkboxAll", function(target, args) {
				})
				.setCheckBoxClick("1", function(target, args) {
				});
		</script>
		<?php
			$flag = "all";
			$sql = "SELECT * FROM water_vendors";

			$condition = "";
			if (isset($_POST["vendorname"]) && $_POST["vendorname"] != "") {
				$condition = $condition . "`Name` like ('%" . $_POST["vendorname"] . "%') AND ";
			}

			$vendormaterial_condition = "";
			if (isset($_POST["vendormaterial"]) && $_POST["vendormaterial"] != "") {
				$finalstrarr = $searchstringtxt = "";
				if (count($_POST["vendormaterial"]) > 1) {
					$joinsearchstr = implode(", ", $_POST["vendormaterial"]);
					$searchstrarr = explode(", ", $joinsearchstr);
					$searchstr = implode("', '", $searchstrarr);
					foreach ($searchstrarr as $material_val) {
						$search_material_val .= "'$material_val',";
					}
					//$condition = $condition . ") AND ";
					$search_marterial = rtrim($search_material_val, ",");

					$vendormaterial_condition = " and water_vendors.id in (Select water_vendor_id from water_vendor_materials_trans_data where water_vendor_materials_id in (" . $search_marterial . ") )";
				} else {
					$searchstr = implode("", $_POST["vendormaterial"]);
					$vendormaterial_condition = " and water_vendors.id in (Select water_vendor_id from water_vendor_materials_trans_data where water_vendor_materials_id = '" . $searchstr . "') ";
				}

			}

			if (isset($_POST["vendorstate"]) && $_POST["vendorstate"] != "") {
				/*if ($_POST["vendorstate"] != "any"){
				$condition = $condition . " `state` = '".$_POST["vendorstate"]."' AND ";
				}*/
				$finalstrarr = $searchstringtxt = "";
				if (count($_POST["vendorstate"]) > 1) {
					$joinsearchstr = implode(", ", $_POST["vendorstate"]);
					$searchstrarr1 = explode(", ", $joinsearchstr);
					$searchstr = implode("', '", $searchstrarr);
					foreach ($searchstrarr1 as $state_val) {
						$search_state_val .= " state like '%$state_val%' or ";
					}
					//$condition = $condition . ") AND ";
					$search_state = rtrim($search_state_val, "or ");

					$condition .= " (" . $search_state . ") AND ";
				} else {
					$searchstr = implode("", $_POST["vendorstate"]);
					$condition = $condition . " `state` like '%" . str_replace("'", "\'", $searchstr) . "%' AND ";
				}

			}

			if (isset($_POST["vendorkeyword"]) && $_POST["vendorkeyword"] != "") {
				$condition = $condition . " `name` like ('%" . $_POST["vendorkeyword"] . "%') OR `contact_name` like ('%" . $_POST["vendorkeyword"] . "%') OR `full_address` like ('%" . $_POST["vendorkeyword"] . "%') AND ";
			}

			if (isset($_POST["coi_expired_flg_sel"]) && $_POST["coi_expired_flg_sel"] != "") {
				$condition = $condition . " `coi_expired_flg` = '" . $_POST["coi_expired_flg_sel"] . "' AND ";
			}

			if (isset($_POST["vendorstatus"]) && $_POST["vendorstatus"] != "") {
				if ($_POST["vendorstatus"] == 99) {
					$condition = $condition . " `active_flg` = 0 ";
				} else {
					//$condition = $condition . " `active_flg` = " . $_POST["vendorstatus"];
				}
				//
				$finalstrarr = $searchstringtxt = "";
				if (count($_POST["vendorstatus"]) > 1) {
					$joinsearchstr = implode(", ", $_POST["vendorstatus"]);
					$searchstrarr = explode(",", $joinsearchstr);
					$searchstr = implode("', '", $searchstrarr);
					foreach ($searchstrarr as $status_val) {
						$search_status_val .= " active_flg = '$status_val' or ";
					}
					//$condition = $condition . ") AND ";
					$search_status = rtrim($search_status_val, "or ");

					$condition .= " (" . $search_status . ") ";
				} else {
					$searchstr = implode("", $_POST["vendorstatus"]);
					$condition = $condition . " `active_flg` = " . $searchstr;
				}
				//

			} else {
				$condition = $condition . " `active_flg` = 1 ";
			}

			$sql = $sql . " WHERE $condition $vendormaterial_condition $addl_select_crit";

			db();
			$result = db_query($sql);
			if ($sql_debug_mode == 1) {echo "<BR>SQL: $sql<BR>";}
			$id = $myrowsel["id"];

			echo "<br><table style='table-layout:fixed;' WIDTH='1350px'>";
			echo "	<tr align='middle'><td colspan='19' class='style24' style='height: 16px'><strong>VENDOR MASTER DATABASE</strong></td></tr>";
			echo "<TR>";
        ?>
		<?php
			$sorturl = "water_vendor_master_new.php?posting=yes&compid=" . $_REQUEST['compid'];
			$imgasc = '<img src="images/sort_asc.png" width="6px;" height="12px;">';
			$imgdesc = '<img src="images/sort_desc.png" width="6px;" height="12px;">';
        ?>

		<th class="style12" bgcolor="#C0CDDA" width="35px" rowspan="2"><strong>Status</strong> &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=status"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=status"><?php echo $imgdesc; ?></a>
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="86px" rowspan="2"><strong>Name</strong> &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=name"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=name"><?php echo $imgdesc; ?></a>
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="58px" rowspan="2"><strong>Description</strong> &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=description"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=description"><?php echo $imgdesc; ?></a>
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="110px" rowspan="2"><strong>Materials Managed</strong> &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=material"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=material"><?php echo $imgdesc; ?></a>
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="75px" rowspan="2"><strong>Able to provide transportation</strong> &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=transportation"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=transportation"><?php echo $imgdesc; ?></a>
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="75px" rowspan="2"><strong>Does Vendor have an Agreement in place with UCB Client?</strong> &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=vendoragreement"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=vendoragreement"><?php echo $imgdesc; ?></a>
		</th>

		<th class="style12" bgcolor="#C0CDDA" colspan="3"><strong>Vendor Sales Rep.</strong></th>

		<th class="style12" bgcolor="#C0CDDA" width="45px" rowspan="2"><strong>Areas doing business</strong> &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=business_area"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=business_area"><?php echo $imgdesc; ?></a>
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="45px" rowspan="2"><strong>UCBZW Clients Using the Vendor</strong> &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=client_using_vendor"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=client_using_vendor"><?php echo $imgdesc; ?></a>
		</th>

		<th class="style12" bgcolor="#C0CDDA" width="79px" rowspan="2"><strong>City</strong> &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=city"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=city"><?php echo $imgdesc; ?></a>
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="76px" rowspan="2"><strong>State</strong>
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=state"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=state"><?php echo $imgdesc; ?></a>
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="72px" rowspan="2"><strong>Zip</strong> &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=zip"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=zip"><?php echo $imgdesc; ?></a>
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="20px" rowspan="2"><strong>Billing Switched to UCBZW</strong>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=billswitchUZW"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=billswitchUZW"><?php echo $imgdesc; ?></a>
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="95px" rowspan="2"><strong>Vendor Accepted Payment Method</strong>  &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=vendoracceptPmethod"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=vendoracceptPmethod"><?php echo $imgdesc; ?></a>
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="95px" rowspan="2"><strong>Attach Copy of the Certificate of Insurance (COI)</strong>  &nbsp;
			<!--<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=COIfile"><?//=$imgasc;?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=COIfile"><?//=$imgdesc;?></a> -->
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="95px" rowspan="2"><strong>Certificate of Insurance expiration date</strong>  &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=COIexpirydt"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=COIexpirydt"><?php echo $imgdesc; ?></a>
		</th>

		<th class="style12" bgcolor="#C0CDDA" width="44px" rowspan="2"><strong>Buttons</strong>
		</th>
	</tr>
	<tr>
		<th class="style12" bgcolor="#C0CDDA" width="60px"><strong>Primary Point of <br>Contact Name</strong> &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=cont_name"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=cont_name"><?php echo $imgdesc; ?></a>
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="80px"><strong>Primary Point of <br>Contact Email</strong> &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=cont_email"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=cont_email"><?php echo $imgdesc; ?></a>
		</th>
		<th class="style12" bgcolor="#C0CDDA" width="81px"><strong>Primary Point of <br>Contact Telephone</strong> &nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=cont_phone"><?php echo $imgasc; ?></a>&nbsp;
			<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=cont_phone"><?php echo $imgdesc; ?></a>
		</th>
	</tr>
	<?php
if (empty($result)) {
            echo "<tr><td colspan=17 style='text-align:center;color:red;font-style:italic'>No record Found.</td></tr>";
        } else {
            if (!isset($_REQUEST["sort"])) {
                $MGArray_data = array();

                while ($myrow = array_shift($result)) {
                    switch ($shade) {
                        case "TBL_ROW_DATA_LIGHT":
                            $shade = "TBL_ROW_DATA_DRK";
                            break;
                        case "TBL_ROW_DATA_DRK":
                            $shade = "TBL_ROW_DATA_LIGHT";
                            break;
                        default:
                            $shade = "TBL_ROW_DATA_DRK";
                            break;
                    } //end switch shade

                    $status = "";
                    switch ($myrow["active_flg"]) {
                        case 0:$status = "Do not use Vendor";
                            break;
                        case 1:$status = "Active Vendor";
                            break;
                        case 2:$status = "Known Vendor";
                            break;
                    }
                    //if($myrow["active_flg"]) $status = "Active Vendor";

                    //
                    $main_material = "";
                    $new_sql = "Select material from water_vendor_materials_trans_data inner join water_vendor_materials on water_vendor_materials.id = water_vendor_materials_trans_data.water_vendor_materials_id
					where water_vendor_id = '" . $myrow["id"] . "'";
                    db();
                    $get_boxes_query = db_query($new_sql);
                    while ($boxes = array_shift($get_boxes_query)) {
                        $main_material = $main_material . $boxes["material"] . ",";
                    }
                    if ($main_material != "") {
                        $main_material = rtrim($main_material, ",");
                    }

                    $comp_names = "";
                    $new_sql = "SELECT loop_warehouse.b2bid, loop_warehouse.warehouse_name FROM water_transaction inner join water_vendors on water_transaction.vendor_id = water_vendors.id
					inner join loop_warehouse on loop_warehouse.id = water_transaction.company_id
					where water_vendors.id = '" . $myrow["id"] . "' group by water_transaction.company_id";
                    db();
                    $get_boxes_query = db_query($new_sql);
                    while ($boxes = array_shift($get_boxes_query)) {
                        //$comp_names = $comp_names . get_nickname_val($boxes["warehouse_name"], $boxes["b2bid"]) . ",";
                        $comp_names = $comp_names . "<a target='_blank' href='viewCompany-purchasing.php?ID=" . $boxes["b2bid"] . "&proc=View&searchcrit=&show=watertransactions&rec_type=Manufacturer'>" . get_nickname_val($boxes["warehouse_name"], $boxes["b2bid"]) . "</a>, ";
                    }
                    ?>
						<?php
                    $shade_dt = "";
                    if ($myrow["certificate_of_insurance_expiry_dt"] != "" && $myrow["certificate_of_insurance_expiry_dt"] != "0000-00-00") {
                        $today = date("Y-m-d");
                        $date2 = date_create($myrow["certificate_of_insurance_expiry_dt"]);
                        $date1 = date_create($today);
                        $diff = date_diff($date2, $date1);
                        $total_days = $diff->format("%a");
                        //echo "total_days - " . $total_days . "<br>";
                        if ($total_days < 30) {
                            $shade_dt = "TBL_ROW_DATA_RED";
                        } elseif ($total_days >= 30) {
                            $shade_dt = "TBL_ROW_DATA_GREEN";
                        }
                    } else {
                        $shade_dt = "";
                    }
                    //echo "shade_dt - " . $shade_dt . "<br>";
                    ?>
					<tr>
						<td width="50px" class="<?php echo $shade; ?>">
							<?php
                    if ($status == "COI Expired") {
                        echo "<span style='color:red;'>";
                    } else {
                        echo "<span>";
                    }
                    ?>
							<?php echo $status; ?>
							<?php
                    echo "</span>";
                    ?>
						</td>
						<td width="100px" class="<?php echo $shade; ?>">
							<a href="<?php echo $thispage; ?>?id=<?php echo $myrow["id"]; ?>&proc=View&<?php echo $pagevars; ?>"><?php echo $myrow["Name"]; ?></a>
						</td>
						<td width="100px" class="<?php echo $shade; ?>" style="word-wrap:break-word;">
							<?php echo $myrow["description"]; ?>
						</td>
						<td width="100px" class="<?php echo $shade; ?>" style="word-wrap:break-word;">
							<?php echo $main_material; ?>
						</td>
						<td width="20px" class="<?php echo $shade; ?>">
							<?php echo ($myrow["transportation"] == "Yes") ? "Yes" : "No"; ?>
						</td>
						<td width="20px" class="<?php echo $shade; ?>">
							<?php echo ($myrow["agreement_with_client"] == 1) ? "Yes" : "No"; ?>
						</td>
						<td width="60px" class="<?php echo $shade; ?>">
							<?php echo $myrow["contact_name"]; ?>
						</td>
						<td width="50px" class="<?php echo $shade; ?>" style="word-wrap:break-word;">
							<?php echo $myrow["contact_email"]; ?>
						</td>
						<td width="50px" class="<?php echo $shade; ?>">
							<?php echo $myrow["contact_phone"]; ?>
						</td>
						<td width="80px" class="<?php echo $shade; ?>">
							<?php echo $myrow["business_area"]; ?>
						</td>
						<td width="80px" class="<?php echo $shade; ?>">
							<?php echo $comp_names; ?>
						</td>
						<td width="50px" class="<?php echo $shade; ?>">
							<?php echo $myrow["city"]; ?>
						</td>
						<td width="30px" class="<?php echo $shade; ?>">
							<?php echo $myrow["state"]; ?>
						</td>
						<td width="20px" class="<?php echo $shade; ?>">
							<?php echo $myrow["zipcode"]; ?>
						</td>
						<td width="20px" class="<?php echo $shade; ?>">
							<?php echo $myrow["billingSwitchToZeroWaste"]; ?>
						</td>
						<td width="50px" class="<?php echo $shade; ?>">
							<?php echo $myrow["vendrAcceptdPayMethd"]; ?>
						</td>
						<td width="50px" class="<?php echo $shade; ?>">
							<?php
                       if ($myrow["certificate_of_insurance"] != "") {
                        ?>
								<a href="certificate_of_insurance_images/<?php echo $myrow["certificate_of_insurance"]; ?>" target="_blank">View</a><br><br>
							<?php
                        }
                    ?>

						</td>
						<td width="50px" class="<?php echo $shade; ?> <?php echo $shade_dt; ?>">
							<?php
                    if ($myrow["certificate_of_insurance_expiry_dt"] != "" && $myrow["certificate_of_insurance_expiry_dt"] != "0000-00-00") {
                        echo $myrow["certificate_of_insurance_expiry_dt"];
                    }
                    ?>
						</td>

						<td width="60px" class="<?php echo $shade; ?>">
							<a href="<?php echo $thispage; ?>?id=<?php echo $myrow["id"]; ?>&proc=Edit&<?php echo $pagevars; ?>&flag=yes&compid=<?php echo $_REQUEST["compid"]; ?>">Edit</a> &nbsp;
							<a href="<?php echo $thispage; ?>?id=<?php echo $myrow["id"]; ?>&proc=Delete&<?php echo $pagevars; ?>&compid=<?php echo $_REQUEST["compid"]; ?>">Delete</a> &nbsp;
							<a href="<?php echo $thispage; ?>?id=<?php echo $myrow["id"]; ?>&proc=inactive&<?php echo $pagevars; ?>&compid=<?php echo $_REQUEST["compid"]; ?>">Mark Inactive</a>
						</td>
					</tr>
					<?php

                    $MGArray_data[] = array('id' => $myrow["id"], 'name' => $myrow["Name"], 'status' => $status,
                        'description' => $myrow["description"], 'material' => $myrow["main_material"], 'comp_names' => $comp_names,
                        'transportation' => $myrow["transportation"], 'sales_contact_name' => $myrow["contact_name"],
                        'sales_contact_email' => $myrow["contact_email"], 'sales_contact_phone' => $myrow["contact_phone"],
                        'area_business' => $myrow["business_area"], 'notes' => $myrow["notes"], 'agreement_with_client' => $myrow["agreement_with_client"],
                        'address' => $myrow["full_address"], 'city' => $myrow["city"], 'state' => $myrow["state"],
                        'zipcode' => $myrow["zipcode"], 'billingSwitchToZeroWaste' => $myrow["billingSwitchToZeroWaste"],
                        'vendrAcceptdPayMethd' => $myrow["vendrAcceptdPayMethd"], 'logo_image' => $myrow["logo_image"]);
                }

                $_SESSION['sortarrayn'] = $MGArray_data;

            } else { //sort's if else part  '' => ,

                $MGArray = $_SESSION['sortarrayn'];
                if ($_REQUEST['sort'] == "status") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['status'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }
                }

                if ($_REQUEST['sort'] == "client_using_vendor") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['comp_names'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }
                }

                if ($_REQUEST['sort'] == "name") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['name'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }
                }
                if ($_REQUEST['sort'] == "description") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['description'];
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
                        $MGArraysort_I[] = $MGArraytmp['material'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }
                }

                if ($_REQUEST['sort'] == "transportation") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['transportation'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }

                }

                if ($_REQUEST['sort'] == "vendoragreement") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['agreement_with_client'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_NUMERIC, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_NUMERIC, $MGArray);
                    }

                }

                if ($_REQUEST['sort'] == "business_area") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['area_business'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }
                }
                if ($_REQUEST['sort'] == "notes") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['notes'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }
                }
                if ($_REQUEST['sort'] == "address") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['address'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }
                }
                if ($_REQUEST['sort'] == "city") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['city'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }
                }
                if ($_REQUEST['sort'] == "state") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['state'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }

                }
                if ($_REQUEST['sort'] == "zip") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['zipcode'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_NUMERIC, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_NUMERIC, $MGArray);
                    }
                }
                if ($_REQUEST['sort'] == "billswitchUZW") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['billingSwitchToZeroWaste'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }
                }
                if ($_REQUEST['sort'] == "cont_name") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['sales_contact_name'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }
                }
                if ($_REQUEST['sort'] == "cont_email") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['sales_contact_email'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }
                }
                if ($_REQUEST['sort'] == "cont_phone") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['sales_contact_phone'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }
                }
                if ($_REQUEST['sort'] == "vendoracceptPmethod") {
                    $MGArraysort_I = array();

                    foreach ($MGArray as $MGArraytmp) {
                        $MGArraysort_I[] = $MGArraytmp['vendrAcceptdPayMethd'];
                    }

                    if ($_REQUEST['sort_order_pre'] == "ASC") {
                        array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
                    }
                    if ($_REQUEST['sort_order_pre'] == "DESC") {
                        array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
                    }
                }

                foreach ($MGArray as $MGArraytmp2) {
                    switch ($shade) {
                        case "TBL_ROW_DATA_LIGHT":
                            $shade = "TBL_ROW_DATA_DRK";
                            break;
                        case "TBL_ROW_DATA_DRK":
                            $shade = "TBL_ROW_DATA_LIGHT";
                            break;
                        default:
                            $shade = "TBL_ROW_DATA_DRK";
                            break;
                    }
                    ?>
					<tr>
						<td class="<?php echo $shade; ?>"><?php echo $MGArraytmp2["status"]; ?></td>
						<td class="<?php echo $shade; ?>">
							<a href="<?php echo $thispage; ?>?id=<?php echo $MGArraytmp2["id"]; ?>&proc=View&<?php echo $pagevars; ?>"><?php echo $MGArraytmp2["name"]; ?></a>
						</td>
						<td class="<?php echo $shade; ?>"><?php echo $MGArraytmp2["description"]; ?></td>
						<td class="<?php echo $shade; ?>"><?php echo $MGArraytmp2["material"]; ?></td>
						<td class="<?php echo $shade; ?>">
							<?php echo ($MGArraytmp2["transportation"] == "Yes") ? "Yes" : "No"; ?>
						</td>
						<td class="<?php echo $shade; ?>">
							<?php echo ($MGArraytmp2["agreement_with_client"] == 1) ? "Yes" : "No"; ?>
						</td>
						<td class="<?php echo $shade; ?>"><?php echo $MGArraytmp2["sales_contact_name"]; ?></td>
						<td class="<?php echo $shade; ?>"><?php echo $MGArraytmp2["sales_contact_email"]; ?></td>
						<td class="<?php echo $shade; ?>"><?php echo $MGArraytmp2["sales_contact_phone"]; ?></td>
						<td class="<?php echo $shade; ?>"><?php echo $MGArraytmp2["area_business"]; ?></td>
						<!--<td class="<?//=$shade;?>"><?//=$MGArraytmp2["address"];?></td>-->
						<td class="<?php echo $shade; ?>"><?php echo $MGArraytmp2["comp_names"]; ?></td>
						<td class="<?php echo $shade; ?>"><?php echo $MGArraytmp2["city"]; ?></td>
						<td class="<?php echo $shade; ?>"><?php echo $MGArraytmp2["state"]; ?></td>
						<td class="<?php echo $shade; ?>"><?php echo $MGArraytmp2["zipcode"]; ?></td>
						<td class="<?php echo $shade; ?>"><?php echo $MGArraytmp2["billingSwitchToZeroWaste"]; ?></td>
						<td class="<?php echo $shade; ?>"><?php echo $MGArraytmp2["vendrAcceptdPayMethd"]; ?></td>
						<!--<td class="<?php echo $shade; ?>">
							<?php //if ($MGArraytmp2["logo_image"] != "") { ?>
								<a href='#' name="vendor_img" id="vendor_img<?//=$MGArraytmp2["id"];?>" onclick="viewlogo('<?//=$MGArraytmp2["logo_image"];?>',<?php //echo $MGArraytmp2["id"]; ?>)">View Logo</a>
							<?php //} ?>
						</td>-->
						<td class="<?php echo $shade; ?>">
							<a href="<?php echo $thispage; ?>?id=<?php echo $MGArraytmp2["id"]; ?>&proc=Edit&<?php echo $pagevars; ?>&flag=yes&compid=<?php echo $_REQUEST["compid"]; ?>">Edit</a> &nbsp;
							<a href="<?php echo $thispage; ?>?id=<?php echo $MGArraytmp2["id"]; ?>&proc=Delete&<?php echo $pagevars; ?>&compid=<?php echo $_REQUEST["compid"]; ?>">Delete</a> &nbsp;
							<a href="<?php echo $thispage; ?>?id=<?php echo $MGArraytmp2["id"]; ?>&proc=inactive&<?php echo $pagevars; ?>&compid=<?php echo $_REQUEST["compid"]; ?>">Mark Inactive</a>
						</td>
					</tr>
				<?php
}
            }
        }
        echo "</table>";} // if $posting == "yes" ends here

    if ($posting == "active_inactive") {
        $pagenorecords = 100; //THIS IS THE PAGE SIZE
        //IF NO PAGE
        if ($page == 0) {
            $myrecstart = 0;
        } else {
            $myrecstart = ($page * $pagenorecords);
        }

        $sort_order = "ASC";

        if ($_GET['sort_order'] == "ASC") {
            $sort_order = "DESC";
        } else {
            $sort_order = "ASC";
        }

        $flag = "all";
        $sql = "SELECT * FROM water_vendors";
        $sqlcount = "select count(*) as reccount from water_vendors";

        $sql = $sql . " WHERE (1=1)  $addl_select_crit "; // LIMIT $myrecstart, $pagenorecords";
        $sqlcount = $sqlcount . " WHERE (1=1) $addl_select_crit "; //LIMIT $myrecstart, $pagenorecords

        if ($sql_debug_mode == 1) {echo "<BR>SQL: $sql<BR>";}
        //SET PAGE
        if ($page == 0) {
            $page = 1;
        } else {
            $page = ($page + 1);
        }

        if ($reccount == 0) {
            //$resultcount = (db_query($sqlcount,db() )) OR DIE (ThrowError($err_type,$err_descr););
            db();
            $resultcount = (db_query($sqlcount)) or die(ThrowError("9991SQLresultcount", $sqlcount));
            if ($myrowcount = array_shift($resultcount)) {
                $reccount = $myrowcount["reccount"];
            } //IF RECCOUNT = 0
        } //end if reccount

        echo "<!--<DIV CLASS='CURR_PAGE'>Page $page - $reccount Records Found</DIV>-->";

        //EXECUTE OUR SQL STRING FOR THE TABLE RECORDS
        //echo $sql;
        db();
        $result = db_query($sql);
        if ($sql_debug_mode == 1) {echo "<BR>SQL: $sql<BR>";}

        echo "<br><TABLE WIDTH='840'>";
        echo "	<tr align='middle'><td colspan='17' class='style24' style='height: 16px'><strong>VENDOR MASTER DATABASE</strong></td></tr>";
        echo "<TR>";
        ?>
		<TD><DIV CLASS='TBL_COL_HDR'><a href='water_vendor_master.php?posting=active_inactive&sorting=yes&sort=lengthInch&sort_order_pre=<?php echo $sort_order_pre; ?>&page=<?php echo $_REQUEST['page']; ?>&reccount=<?php echo $_REQUEST['reccount']; ?>&searchcrit=<?php echo $_REQUEST['searchcrit']; ?>&<?php echo $pagevars; ?>' >Name</a></DIV></TD>
		<TD><DIV CLASS='TBL_COL_HDR'><a href='water_vendor_master.php?posting=active_inactive&sorting=yes&sort=widthInch&sort_order_pre=<?php echo $sort_order_pre; ?>&page=<?php echo $_REQUEST['page']; ?>&reccount=<?php echo $_REQUEST['reccount']; ?>&searchcrit=<?php echo $_REQUEST['searchcrit']; ?>&<?php echo $pagevars; ?>' >Address</a></DIV></TD>

		<TD><DIV CLASS='TBL_COL_HDR'><a href='water_vendor_master.php?posting=active_inactive&sorting=yes&sort=inactive&sort_order=<?php echo $sort_order; ?>&page=<?php echo $_REQUEST['page']; ?>&reccount=<?php echo $_REQUEST['reccount']; ?>&searchcrit=<?php echo $_REQUEST['searchcrit']; ?>&<?php echo $pagevars; ?>' >Active Flag</a></DIV></TD>
		<TD><DIV CLASS='TBL_COL_HDR'>&nbsp;</DIV></TD>
		<TD><DIV CLASS='TBL_COL_HDR'>&nbsp;</DIV></TD>
		<TD><DIV CLASS='TBL_COL_HDR'>&nbsp;</DIV></TD>
		<TD><DIV CLASS='TBL_COL_HDR'>&nbsp;</DIV></TD>

		<?php

        while ($myrow = array_shift($result)) {
            //FORMAT THE OUTPUT OF THE SEARCH
            $id = $myrowsel_b2b["id"];
            //SWITCH ROW COLORS
            switch ($shade) {
                case "TBL_ROW_DATA_LIGHT":
                    $shade = "TBL_ROW_DATA_DRK";
                    break;
                case "TBL_ROW_DATA_DRK":
                    $shade = "TBL_ROW_DATA_LIGHT";
                    break;
                default:
                    $shade = "TBL_ROW_DATA_DRK";
                    break;
            } //end switch shade
            ?>

		<TR>
			<TD CLASS='<?php echo $shade; ?>'>
				<?php echo $myrow["Name"]; ?>
			</TD>

			<TD CLASS='<?php echo $shade; ?>'>
				<?php echo $myrow["full_address"] . ", " . $myrow["city"] . " " . $myrow["state"] . " " . $myrow["zipcode"]; ?>
			</TD>

			<TD CLASS='<?php echo $shade; ?>'>
				<?php echo ($myrow["active_flg"] == 0) ? "NO" : "YES"; ?>
			</TD>
			<TD CLASS='<?php echo $shade; ?>'>&nbsp;

			</TD>

			<TD CLASS='<?php echo $shade; ?>'>
				<?php if ($allowview == "yes") {?><a href="<?php echo $thispage; ?>?id=<?php echo $myrow["id"]; ?>&proc=View&<?php echo $pagevars; ?>&compid=<?php echo $_REQUEST["compid"]; ?>">View</a>
				<?php }?>
			</TD>
			<TD CLASS='<?php echo $shade; ?>'>&nbsp;

			</TD>

			<TD CLASS='<?php echo $shade; ?>'>
				<?php if ($allowedit == "yes") {?>
				<a href="<?php echo $thispage; ?>?id=<?php echo $myrow["id"]; ?>&proc=Edit&<?php echo $pagevars; ?>&flag=yes&compid=<?php echo $_REQUEST["compid"]; ?>">Edit</a>
				<?php }?>
			</TD>
			<TD CLASS='<?php echo $shade; ?>'>&nbsp;

			</TD>

			<TD CLASS='<?php echo $shade; ?>'>
				<?php if ($allowdelete == "yes") {?>
				<a href="<?php echo $thispage; ?>?id=<?php echo $myrow["id"]; ?>&proc=Delete&<?php echo $pagevars; ?>&compid=<?php echo $_REQUEST["compid"]; ?>">Delete</a>
				<?php }?>
			</TD>
			<TD CLASS='<?php echo $shade; ?>'>&nbsp;

			</TD>

			<TD CLASS='<?php echo $shade; ?>'>
				<?php if ($myrow["active_flg"] == 0) {?>
				<a href="<?php echo $thispage; ?>?id=<?php echo $myrow["id"]; ?>&proc=active&<?php echo $pagevars; ?>&compid=<?php echo $_REQUEST["compid"]; ?>">Mark Active</a>
				<?php }?>
				<?php if ($myrow["active_flg"] == 1) {?>
				<a href="<?php echo $thispage; ?>?id=<?php echo $myrow["id"]; ?>&proc=inactive&<?php echo $pagevars; ?>&compid=<?php echo $_REQUEST["compid"]; ?>">Mark Inactive</a>
				<?php }?>
			</TD>

		</TR>
		<?php
}
        echo "</TABLE>";
    }

} //$proc == "" ends here.


if ($proc == "New") {
    if (isset($_REQUEST['SUBMIT']) && $_REQUEST['post'] == "yes") {

        $compid = FixString($_REQUEST["compid"]);
        $vendor_status_o = $_REQUEST["vendor_status"];
        $vendor_name = FixString($_REQUEST["vendor_name"]);
        $vendor_description = FixString($_REQUEST["vendor_description"]);
        $materialist = implode("|", $_REQUEST["materials"]);
        $transportation = $_REQUEST["transportation"];
        $businessarea_state = implode("|", $_REQUEST["businessarea_state"]);
        $vendor_salespoint_contact_name = FixString($_REQUEST["vendor_salespoint_contact_name"]);
        $vendor_salespoint_contact_email = FixString($_REQUEST["vendor_salespoint_contact_email"]);
        $vendor_salespoint_contact_phone = FixString($_REQUEST["vendor_salespoint_contact_phone"]);
        $vendor_main_phone = $_REQUEST["vendor_main_phone"];
        $vendor_hq_address = FixString($_REQUEST["vendor_hq_address"]);
        $vendor_hq_city = FixString($_REQUEST["vendor_hq_city"]);
        $vendor_hq_state = $_REQUEST["vendor_hq_state"];
        $vendor_zipcode = $_REQUEST["vendor_zipcode"];
        $for_what_client = FixString($_REQUEST['for_what_client']);
        $vendor_terms = $_REQUEST['vendor_terms'];
        $link_for_client_record = $_REQUEST['link_for_client_record'];
        $title = FixString($_REQUEST['title']);
        $full_address2 = FixString($_REQUEST['full_address2']);
        $directPhone = FixString($_REQUEST['directPhone']);
        $Fax = FixString($_REQUEST['Fax']);
        $linkedIn_profile = $_REQUEST['linkedIn_profile'] != "" ? FixString($_REQUEST['linkedIn_profile']) : "";
        $date_of_bill_switch = date("Y-m-d", strtotime($_REQUEST['date_of_bill_switch']));
        $general_notes = FixString($_REQUEST['general_notes']);
        // file upload agreement and logo
        $filetype1 = "jpg,jpeg,gif,png,PNG,JPG,JPEG,pdf";
        $allow_ext1 = explode(",", $filetype1);

        $signed_approved_bill_switch_agreement = "";
        if ($_FILES['signed_approved_bill_switch_agreement']['name'] != "") {
            if ($_FILES["signed_approved_bill_switch_agreement"]["error"] > 0) {
                echo "Return Code: " . $_FILES["signed_approved_bill_switch_agreement"]["error"] . "<br />";
            } else {
                $ext1 = pathinfo($_FILES["signed_approved_bill_switch_agreement"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext1), $allow_ext1)) {
                    move_uploaded_file($_FILES["signed_approved_bill_switch_agreement"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["signed_approved_bill_switch_agreement"]["name"]);
                    $signed_approved_bill_switch_agreement = $_FILES["signed_approved_bill_switch_agreement"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["signed_approved_bill_switch_agreement"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }

        $accept_payment_method_file1 = "";
        if ($_FILES['accept_payment_method_file']['name'] != "") {
            if ($_FILES["accept_payment_method_file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["accept_payment_method_file"]["error"] . "<br />";
            } else {
                $ext1 = pathinfo($_FILES["accept_payment_method_file"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext1), $allow_ext1)) {
                    move_uploaded_file($_FILES["accept_payment_method_file"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["accept_payment_method_file"]["name"]);
                    $accept_payment_method_file1 = $_FILES["accept_payment_method_file"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }

        $agreement_ucb_client_file = "";
        if ($_FILES['agreement_ucb_client_file']['name'] != "") {
            if ($_FILES["agreement_ucb_client_file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["agreement_ucb_client_file"]["error"] . "<br />";
            } else {
                $ext1 = pathinfo($_FILES["agreement_ucb_client_file"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext1), $allow_ext1)) {
                    move_uploaded_file($_FILES["agreement_ucb_client_file"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["agreement_ucb_client_file"]["name"]);
                    $agreement_ucb_client_file = $_FILES["agreement_ucb_client_file"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["agreement_ucb_client_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["agreement_ucb_client_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }

        $vendor_logo_file = "";
        if ($_FILES['vendor_logo_file']['name'] != "") {
            if ($_FILES["vendor_logo_file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["vendor_logo_file"]["error"] . "<br />";
            } else {
                $ext = pathinfo($_FILES["vendor_logo_file"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext), $allow_ext1)) {
                    move_uploaded_file($_FILES["vendor_logo_file"]["tmp_name"], "vendor_logo_images/" . $_FILES["vendor_logo_file"]["name"]);
                    $vendor_logo_file = $_FILES["vendor_logo_file"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["vendor_logo_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["vendor_logo_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }

        //certificate_of_insurance file upload
        $coi_file_update = "";
        if ($_FILES['coi_file']['name'] != "") {
            if ($_FILES["coi_file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["coi_file"]["error"] . "<br />";
            } else {
                $ext1 = pathinfo($_FILES["coi_file"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext1), $allow_ext1)) {
                    move_uploaded_file($_FILES["coi_file"]["tmp_name"], "certificate_of_insurance_images/" . $_FILES["coi_file"]["name"]);
                    $coi_file_update = $_FILES["coi_file"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["coi_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["coi_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }

        $filetype2 = "doc,docx,xls,xlsx,pdf,DOC,DOCX,XLS,XLSX,PDF";
        $allow_ext2 = explode(",", $filetype2);

        $vendor_onboarding_form = "";
        if ($_FILES['vendor_onboarding_form']['name'] != "") {
            if ($_FILES["vendor_onboarding_form"]["error"] > 0) {
                echo "Return Code: " . $_FILES["vendor_onboarding_form"]["error"] . "<br />";
            } else {
                $ext1 = pathinfo($_FILES["vendor_onboarding_form"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext1), $allow_ext2)) {
                    move_uploaded_file($_FILES["vendor_onboarding_form"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["vendor_onboarding_form"]["name"]);
                    $vendor_onboarding_form = $_FILES["vendor_onboarding_form"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["vendor_onboarding_form"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["vendor_onboarding_form"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }

        $vendor_audit_form = "";
        if ($_FILES['vendor_audit_form']['name'] != "") {
            if ($_FILES["vendor_audit_form"]["error"] > 0) {
                echo "Return Code: " . $_FILES["vendor_audit_form"]["error"] . "<br />";
            } else {
                $ext1 = pathinfo($_FILES["vendor_audit_form"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext1), $allow_ext2)) {
                    move_uploaded_file($_FILES["vendor_audit_form"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["vendor_audit_form"]["name"]);
                    $vendor_audit_form = $_FILES["vendor_audit_form"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["vendor_audit_form"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["vendor_audit_form"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }
        $vendor_tax_id = $_REQUST['vendor_tax_id'];
        $vendor_shipping_contact_name = FixString($_REQUEST["vendor_shipping_contact_name"]);
        $vendor_shipping_contact_email = FixString($_REQUEST["vendor_shipping_contact_email"]);
        $vendor_shipping_contact_phone = FixString($_REQUEST["vendor_shipping_contact_phone"]);
        $notes = FixString($_REQUEST["notes"]);
        $id = $_REQUEST["id"];
        $coi_date = $_REQUEST["coi_date"];
        $coi_expired_flg = $_REQUEST["coi_expired_flg"];

        //Check COI date and set status

        if ($coi_date != "") {
            $today = date("Y-m-d");
            $date2 = date_create($coi_date);
            $date1 = date_create($today);
            $diff = date_diff($date1, $date2);
            $total_days = $diff->format("%R%a");
            //echo $total_days;
            if ($total_days < 30) {
                $coi_expired_flg = "Yes";
                $vendor_status = 1;
            } elseif ($total_days >= 30) {
                $vendor_status = $vendor_status_o;
            }
        } else {
            $vendor_status = $vendor_status_o;
        }
        //
        $coi_date = date("Y-m-d", strtotime($coi_date));
        $inrtsql = "INSERT INTO `water_vendors`(`b2bid`, `Name`,`active_flg`,`for_what_client`,`vendor_terms`,`link_for_client_record`,`description`,main_material,
		transportation,business_area,contact_name,title,full_address,full_address2,city,`state`,zipcode,PhoneNo,directPhone,contact_phone,contact_email,
		Fax,linkedIn_profile,notes,date_of_bill_switch,coi_expired_flg,certificate_of_insurance_expiry_dt,vendor_tax_id,shipping_contact_name,shipping_contact_email,
		shipping_contact_phone,general_notes,signed_approved_bill_switch_agreement,vendor_aggrement_file,certificate_of_insurance,vendor_onboarding_form,vendor_audit_form,
		logo_image) VALUES('$compid','$vendor_name','$vendor_status','$for_what_client','$vendor_terms','$link_for_client_record','$vendor_description','$main_material','$transportation',
		'$businessarea_state','$vendor_salespoint_contact_name','$title','$vendor_hq_address','$full_address2','$vendor_hq_city','$vendor_hq_state',
		'$vendor_zipcode','$vendor_main_phone','$directPhone','$vendor_salespoint_contact_phone','$vendor_salespoint_contact_email','$Fax','$linkedIn_profile',
		'$notes','$date_of_bill_switch','$coi_expired_flg','$coi_date','$vendor_tax_id','$vendor_shipping_contact_name','$vendor_shipping_contact_email','$vendor_shipping_contact_phone',
		'$general_notes','$signed_approved_bill_switch_agreement','$agreement_ucb_client_file','$coi_file_update','$vendor_onboarding_form','$vendor_audit_form',
		'$vendor_logo_file')";
        db();
        $result = db_query($inrtsql);

        $b2b_id_new = 0;
        if (empty($result)) {
            $b2b_id_new = tep_db_insert_id();

            foreach ($_REQUEST["materials"] as $materials_ids) {
                db();
                $result1 = db_query("insert into water_vendor_materials_trans_data (water_vendor_id, water_vendor_materials_id) select '" . $b2b_id_new . "', '" . $materials_ids . "'");
            }

            if (isset($_REQUEST["wateritem"]) && $_REQUEST["wateritem"] == "y") {
                echo "<script type=\"text/javascript\">";
                echo "window.location.href=\"water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\";";
                echo "</script>";
                echo "<noscript>";
                echo "<meta http-equiv=\"refresh\" content=\"0;url=water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\" />";
                echo "</noscript>";exit;
            } else {
                echo "<script type=\"text/javascript\">";
                echo "window.location.href=\"water_vendor_master_new.php?id=" . $b2b_id_new . "&showsavemg=yes&proc=View&recadded=y&flag=yes\";";
                echo "</script>";
                echo "<noscript>";
                echo "<meta http-equiv=\"refresh\" content=\"0;url=water_vendor_master_new.php?id=" . $b2b_id_new . "&showsavemg=yes&proc=View&recadded=y&flag=yes\" />";
                echo "</noscript>";exit;
            }
        } else {
            echo ThrowError("9994SQL", $sql_b2b);
            echo "Error inserting record (9994SQL)";
        }

    }
    if (!$_REQUEST['post']) {
        ?>
<div class="outer_container">
	<DIV CLASS='PAGE_STATUS'>Adding or Editing Vendor Record </DIV>
	<FORM name="frmVendorAdd" id="frmVendorAdd" METHOD="POST" ACTION="<?php echo $thispage; ?>?proc=New&pgname=<?php echo $_REQUEST["pgname"]; ?>&compid=<?php echo $_REQUEST["compid"]; ?>&post=yes&<?php echo $pagevars; ?>&secformula_flg=<?php echo $_GET["secformula_flg"]; ?>" enctype="multipart/form-data">
		<input type="hidden" name="wateritem" id="wateritem" value="<?php echo $_REQUEST["wateritem"]; ?>" >
		<TABLE border='1' id="maintbl1" class="vendors_master_database_table">
			<tr>
				<th colspan="2">Vendor Information:</th>
			</tr>
			<tr>
				<td class="frmlabel"><b>Vendor Name:</b></td>
				<td><input class="vendor_input" type="text" name="vendor_name" value=""></td>
				</tr>
			<tr>
				<td class="frmlabel"><b>Acct. Status:</b></td>
				<td>
					<select class="vendor_select" name="vendor_status">
						<option value="1" >Active Vendor</option>
						<option value="2" >Known Vendor</option>
						<option value="0" >Do not use Vendor</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Vendor Terms:</b></td>
				<td>
					<select class="vendor_select" name="vendor_terms">
						<option value=""></option>
						<option value="Due On Receipt" >Due On Receipt</option>
						<option value="Net 10">Net 10</option>
						<option value="Net 15">Net 15</option>
						<option value="Net 30">Net 30</option>
						<option value="Net 45">Net 45</option>
						<option value="Net 60">Net 60</option>
						<option value="Net 90">Net 90</option>
						<option value="Net 120">Net 120</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>For What Client:</b></td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td class="frmlabel"><b>Description:</b></td>
				<td><input class="vendor_input" type="text" name="vendor_description" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Materials Managed:</b></td>
				<td>
						<select class="vendor_select" id="vendor_material" name="materials[]" multiple>
						    <?php
							$sqlfrm = "SELECT * FROM water_vendor_materials order by material ASC";
									db();
									$statearr = db_query($sqlfrm);
									foreach ($statearr as $row) {
										echo '<option value="' . $row["id"] . '">' . $row["material"] . '</option>';
									}
									?>
						</select>
						<script>
							document.multiselect('#vendor_material')
							.setCheckBoxClick("checkboxAll", function(target, args) {
							})
							.setCheckBoxClick("1", function(target, args) {
								console.log("Checkbox for item with value '1' was clicked and got value ", args.checked);
							});
					</script>
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Transportation:</b></td>
				<td>
				<select class="vendor_select" name="transportation">
					<option value=""></option>
					<option value="Yes" >Yes</option>
					<option value="No" >No</option>
					<option value="Unknown">Unknown</option>
				</select>
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Area of Business:</b></td>
				<td>
					<select class="vendor_select" id="businessarea_state" name="businessarea_state[]" multiple>
						<?php
						$sqlfrm = "SELECT * FROM state_master order by state ";
								db();
								$statearr = db_query($sqlfrm);
								foreach ($statearr as $row) {
									echo '<option value="' . $row["state"] . '">' . $row["state"] . '</option>';
								}
								?>
					</select>
					<script>
						document.multiselect('#businessarea_state')
						.setCheckBoxClick("checkboxAll", function(target, args) {
						})
						.setCheckBoxClick("1", function(target, args) {
							//console.log("Checkbox for item with value '1' was clicked and got value ", args.checked);
						});
					</script>
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Sales Contact Name:</b></td>
				<td><input class="vendor_input" type="text" name="vendor_salespoint_contact_name" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Title:</b></td>
				<td><input class="vendor_input" type="text" name="title" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Address 1:</b></td>
				<td><input class="vendor_input" type="text" name="vendor_hq_address" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Address 2:</b></td>
				<td><input class="vendor_input" type="text" name="full_address2" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>City:</b></td>
				<td><input class="vendor_input" type="text" name="vendor_hq_city" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>State/Province:</b></td>
				<td>
					<select class="vendor_select" name="vendor_hq_state">
						<option value=""></option>
						<?php
							$sqlfrm = "SELECT * FROM state_master order by state ";
									db();
									$statearr = db_query($sqlfrm);
									foreach ($statearr as $row) {
										echo '<option value="' . $row["state"] . '">' . $row["state"] . '</option>';
									}
									?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Zip Code:</b></td>
				<td><input class="vendor_input" type="text" name="zipcode" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Main Phone:</b></td>
				<td><input class="vendor_input" type="text" name="vendor_main_phone" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Direct Phone:</b></td>
				<td><input class="vendor_input" type="text" name="directPhone" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Cell:</b></td>
				<td><input class="vendor_input" type="text" name="vendor_salespoint_contact_phone" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Email:</b></td>
				<td><input class="vendor_input" type="text" name="vendor_salespoint_contact_email" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Fax:</b></td>
				<td><input class="vendor_input" type="text" name="Fax" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>LinkedIn Profile:</b></td>
				<td><input class="vendor_input" type="text" name="linkedIn_profile" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Notes:</b></td>
				<td><input class="vendor_input" type="text" name="notes" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Billing Switch to UCBZeroWaste:</b></td>
				<td>
					<select class="vendor_select" name="bill_switch_ucbzwaste">
						<option value=""></option>
						<option value="Yes" >Yes</option>
						<option value="No">No</option>
						<option value="Unknown" >Unknown</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Date of Billing Switch:</b></td>
				<td>
					<input id="date_of_bill_switch" name="date_of_bill_switch" class="form_component" type="text" value="" placeholder="MM/DD/YYYY"> &nbsp;&nbsp;
					<a href="#" onclick="caldate_of_bill_switchdt.select(document.frmVendorEdit.date_of_bill_switch,'anchordate_of_bill_switchdt','MM/dd/yyyy'); return false;" name="anchordate_of_bill_switchdt" id="anchordate_of_bill_switchdt"><img border="0" src="images/calendar.jpg"></a>
					<div ID="listdiv_date_of_bill_switchdt" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></div>
				</td>
				<!--<td><input class="vendor_input" type="date" name="date_of_bill_switch" pattern="\d{2}-\d{2}-\d{4}"></td>-->
			</tr>
			<tr>
				<td class="frmlabel"><b>Signed/Approved: Bill Switch Agreement:</b></td>
				<td>
					<input onchange="checkfile(this.id)" id="signed_approved_bill_switch_agreement" class="vendor_input" type="file" name="signed_approved_bill_switch_agreement" accept="application/pdf">
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Copy of Agreement: (FYI to be attached)</b></td>
				<td>
					<input onchange="checkfile(this.id)" id="agreement_ucb_client_file" class="vendor_input" type="file" name="agreement_ucb_client_file" accept="application/pdf">
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Certificate of Insurance (COI) Status:</b></td>
				<td>
					<select class="vendor_select" name="coi_expired_flg">
						<option value=""></option>
						<option value="Yes" >Yes</option>
						<option value="No" >No</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Attach Copy of COI:</b></td>
				<td>
				<input onchange="checkfile(this.id)" id="coi_file" class="vendor_input" type="file" name="coi_file" accept="application/pdf">
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Date COI Expires:</b></td>
				<td>
					<input id="coi_date" name="coi_date" class="form_component" type="text" value="" placeholder="MM/DD/YYYY"> &nbsp;&nbsp;
					<a href="#" onclick="calcoidt.select(document.frmVendorEdit.coi_date,'anchorcoidt','MM/dd/yyyy'); return false;" name="anchorcoidt" id="anchorcoidt"><img border="0" src="images/calendar.jpg"></a>
					<div ID="listdiv_coidt" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></div>
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Vendor Onboarding Form:</b></td>
				<td>
					<input type="file" name="vendor_onboarding_form" accept=".pdf,.xls,.xlsx,.doc,.docx" class="vendor_input">

				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Vendor Audit Form: (For Hazardous Waste Vendors)</b></td>
				<td>
					<input name="vendor_audit_form" type="file" class="vendor_input" accept=".pdf,.xls,.xlsx,.doc,.docx" >

				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Tax ID:</b></td>
				<td>
					<input class="vendor_input" type="text" name="vendor_tax_id" >
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Shipping & Freight Contact Name:</b></td>
				<td>
					<input class="vendor_input" type="text" name="vendor_shipping_contact_name" value="">
				</td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Shipping & Freight Contact Email:</b></td>
				<td><input class="vendor_input" type="text" name="vendor_shipping_contact_email" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Shipping & Freight Contact Phone:</b></td>
				<td><input class="vendor_input" type="text" name="vendor_shipping_contact_phone" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>General Notes:</b></td>
				<td><input class="vendor_input" type="text" name="general_notes" value=""></td>
			</tr>
			<tr>
				<td class="frmlabel"><b>Vendor Logo:</b></td>
				<td>
					<input class="vendor_input" type="file" name="vendor_logo_file" >
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<input type="hidden" value="<?php echo $id; ?>" name="id">
					<input CLASS="BUTTON" type="submit" value="Save" name="SUBMIT" onclick=chkfile()>
				</td>
			</tr>
		</TABLE>
		<BR>
	</form>

</div>
<?php
} // if form not submitted.
} //if $proc == "New" ends here.
if ($proc == "DELETE_RECEIVABLE_CONTACT") {
    db();
    $delete_record = db_query("DELETE from water_vendors_receivable_contact where id = " . $_REQUEST['contact_id']);

    if (empty($delete_record)) {
        echo "<DIV CLASS='SQL_RESULTS'>Record Deleted.   <a href=\"water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\">Continue</a></DIV>";
        if (isset($_REQUEST["wateritem"]) && $_REQUEST["wateritem"] == "y") {
            echo "<script type=\"text/javascript\">";
            echo "window.location.href=\"water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\";";
            echo "</script>";
            echo "<noscript>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\" />";
            echo "</noscript>";exit;
        } else {
            echo "<script type=\"text/javascript\">";
            echo "window.location.href=\"water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\";";
            echo "</script>";
            echo "<noscript>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\" />";
            echo "</noscript>";exit;
        }
    } else {
        echo "Error Adding Vendor Receivable Contact record.$sql";
    }
}
if ($proc == "EDIT_RECEIVABLE_CONTACT") {
    $water_vendor_id = $_REQUEST['water_vendor_id'];
    $vendor_contact_id = $_REQUEST['vendor_contact_id'];
    $receivable_contact_name = FixString($_REQUEST["receivable_contact_name"]);
    $receivable_title = FixString($_REQUEST["receivable_title"]);
    $receivable_address1 = FixString($_REQUEST["receivable_address1"]);
    $receivable_address2 = FixString($_REQUEST["receivable_address2"]);
    $receivable_city = FixString($_REQUEST["receivable_city"]);
    $receivable_state = $_REQUEST["receivable_state"];
    $receivable_zipcode = FixString($_REQUEST["receivable_zipcode"]);
    $receivable_main_phone = FixString($_REQUEST["receivable_main_phone"]);
    $receivable_direct_phone = FixString($_REQUEST["receivable_direct_phone"]);
    $receivable_cell = FixString($_REQUEST["receivable_cell"]);
    $receivable_email = FixString($_REQUEST["receivable_email"]);
    $receivable_fax = FixString($_REQUEST["receivable_fax"]);
    $receivable_portal_name = FixString($_REQUEST["receivable_portal_name"]);
    $receivable_portal_link = $_REQUEST["receivable_portal_link"];
    $receivable_notes = $_REQUEST["receivable_notes"];
    $do_we_get_invoiced = $_REQUEST['do_we_get_invoiced'];
    $receivable_need_tonnage_report = $_REQUEST["receivable_need_tonnage_report"];
    $accept_payment_method = $_REQUEST["accept_payment_method"];
    $website_link = $_REQUEST["website_link"];
    $website_userlogin = $_REQUEST["website_userlogin"];
    $website_password = $_REQUEST["website_password"];
    $website_accountid_number = $_REQUEST["website_accountid_number"];
    $website_creditcard_autopay_setup = $_REQUEST["website_creditcard_autopay_setup"];
    $website_creditcard_autopay = $_REQUEST["website_creditcard_autopay"]; //24
    $vendor_payment_method_ucb = $_REQUEST["vendor_payment_method_ucb"];
    $filetype1 = "jpg,jpeg,gif,png,PNG,JPG,JPEG,pdf";
    $allow_ext1 = explode(",", $filetype1);

    $accept_payment_method_file1 = "";
    /*if ($_FILES["accept_payment_method_file"]["error"] > 0){
    echo "Return Code: " . $_FILES["accept_payment_method_file"]["error"] . "<br />";
    }else{
    $ext1 = pathinfo($_FILES["accept_payment_method_file"]["name"], PATHINFO_EXTENSION);
    if(in_array(strtolower($ext1), $allow_ext1) ){
    move_uploaded_file($_FILES["accept_payment_method_file"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["accept_payment_method_file"]["name"]);
    $accept_payment_method_file1 = $_FILES["accept_payment_method_file"]["name"];
    }else{
    echo "<font color=red>" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
    echo "<script>alert('" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
    }
    }*/
    $accept_payment_method_ucb_file = "";
    /*if ($_FILES["accept_payment_method_ucb_file"]["error"] > 0){
    echo "Return Code: " . $_FILES["accept_payment_method_ucb_file"]["error"] . "<br />";
    }else{
    $ext1 = pathinfo($_FILES["accept_payment_method_ucb_file"]["name"], PATHINFO_EXTENSION);
    if(in_array(strtolower($ext1), $allow_ext1) ){
    move_uploaded_file($_FILES["accept_payment_method_ucb_file"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["accept_payment_method_ucb_file"]["name"]);
    $accept_payment_method_ucb_file = $_FILES["accept_payment_method_ucb_file"]["name"];
    }else{
    echo "<font color=red>" . $_FILES["accept_payment_method_ucb_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
    echo "<script>alert('" . $_FILES["accept_payment_method_ucb_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
    }
    }*/

    $receivable_payment_terms_given_by_ucbzerowaste = $_REQUEST["receivable_payment_terms_given_by_ucbzerowaste"];
    $receivable_client_contact_name = FixString($_REQUEST["receivable_client_contact_name"]);
    $receivable_client_contact_phone = FixString($_REQUEST["receivable_client_contact_phone"]);
    $receivable_client_contact_email = FixString($_REQUEST["receivable_client_contact_email"]);
    $created_on = date("Y-m-d h:i:s");
    db();
    $upd_sql = db_query("UPDATE water_vendors_receivable_contact set `receivable_contact_name`='$receivable_contact_name',`receivable_title`='$receivable_title',`receivable_address1`='$receivable_address1',`receivable_address2`='$receivable_address2',
	`receivable_city`='$receivable_city',`receivable_state`='$receivable_state',`receivable_zipcode`='$receivable_zipcode',`receivable_main_phone`='$receivable_main_phone',`receivable_direct_phone`='$receivable_direct_phone',
	`receivable_cell`='$receivable_cell',`receivable_email`='$receivable_email', `receivable_fax`='$receivable_fax',`receivable_portal_name`='$receivable_portal_name',`receivable_portal_link`='$receivable_portal_link',
	`receivable_notes`='$receivable_notes',`do_we_get_invoiced`='$do_we_get_invoiced',`receivable_need_tonnage_report`='$receivable_need_tonnage_report',`vendor_accept_payment_method`='$accept_payment_method',
	`websitelink_invoice_payment`='$website_link',`website_username`='$website_userlogin',`website_password`='$website_password',`website_cust_acct_number`='$website_accountid_number',`creditcard_autopay_setup`='$website_creditcard_autopay_setup',`creditcard_autopayment`='$website_creditcard_autopay',
	`accept_payment_method_file_one`='$accept_payment_method_file1',`vendor_payment_method_ucb`='$vendor_payment_method_ucb',`accept_payment_method_file_two`='$accept_payment_method_ucb_file',`receivable_payment_terms_given_by_ucbzerowaste`='$receivable_payment_terms_given_by_ucbzerowaste',
	`receivable_client_contact_name`='$receivable_client_contact_name',`receivable_client_contact_phone`='$receivable_client_contact_phone',`receivable_client_contact_email`='$receivable_client_contact_email',`created_on`='$created_on'
	where id=$vendor_contact_id");

    if (empty($upd_sql)) {
        echo "<DIV CLASS='SQL_RESULTS'>Record Updated.   <a href=\"water_vendor_master_new.php?posting=yes&recupdated=y\">Continue</a></DIV>";
        if (isset($_REQUEST["wateritem"]) && $_REQUEST["wateritem"] == "y") {
            echo "<script type=\"text/javascript\">";
            echo "window.location.href=\"water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\";";
            echo "</script>";
            echo "<noscript>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\" />";
            echo "</noscript>";exit;
        } else {
            echo "<script type=\"text/javascript\">";
            echo "window.location.href=\"water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\";";
            echo "</script>";
            echo "<noscript>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\" />";
            echo "</noscript>";exit;
        }
    } else {
        echo "Error Adding Vendor Receivable Contact record.$sql";
    }
}

if ($proc == "ADD_RECEIVABLE_CONTACT") {
    $water_vendor_id = $_REQUEST['water_vendor_id'];
    $receivable_contact_name = FixString($_REQUEST["receivable_contact_name"]);
    $receivable_title = FixString($_REQUEST["receivable_title"]);
    $receivable_address1 = FixString($_REQUEST["receivable_address1"]);
    $receivable_address2 = FixString($_REQUEST["receivable_address2"]);
    $receivable_city = FixString($_REQUEST["receivable_city"]);
    $receivable_state = $_REQUEST["receivable_state"];
    $receivable_zipcode = FixString($_REQUEST["receivable_zipcode"]);
    $receivable_main_phone = FixString($_REQUEST["receivable_main_phone"]);
    $receivable_direct_phone = FixString($_REQUEST["receivable_direct_phone"]);
    $receivable_cell = FixString($_REQUEST["receivable_cell"]);
    $receivable_email = FixString($_REQUEST["receivable_email"]);
    $receivable_fax = FixString($_REQUEST["receivable_fax"]);
    $receivable_portal_name = FixString($_REQUEST["receivable_portal_name"]);
    $receivable_portal_link = $_REQUEST["receivable_portal_link"];
    $receivable_notes = $_REQUEST["receivable_notes"];
    $do_we_get_invoiced = $_REQUEST['do_we_get_invoiced'];
    $receivable_need_tonnage_report = $_REQUEST["receivable_need_tonnage_report"];
    $accept_payment_method = $_REQUEST["accept_payment_method"];
    $website_link = $_REQUEST["website_link"];
    $website_userlogin = $_REQUEST["website_userlogin"];
    $website_password = $_REQUEST["website_password"];
    $website_accountid_number = $_REQUEST["website_accountid_number"];
    $website_creditcard_autopay_setup = $_REQUEST["website_creditcard_autopay_setup"];
    $website_creditcard_autopay = $_REQUEST["website_creditcard_autopay"]; //24
    $vendor_payment_method_ucb = $_REQUEST["vendor_payment_method_ucb"];
    $filetype1 = "jpg,jpeg,gif,png,PNG,JPG,JPEG,pdf";
    $allow_ext1 = explode(",", $filetype1);

    $accept_payment_method_file1 = "";
    /*if ($_FILES["accept_payment_method_file"]["error"] > 0){
    echo "Return Code: " . $_FILES["accept_payment_method_file"]["error"] . "<br />";
    }else{
    $ext1 = pathinfo($_FILES["accept_payment_method_file"]["name"], PATHINFO_EXTENSION);
    if(in_array(strtolower($ext1), $allow_ext1) ){
    move_uploaded_file($_FILES["accept_payment_method_file"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["accept_payment_method_file"]["name"]);
    $accept_payment_method_file1 = $_FILES["accept_payment_method_file"]["name"];
    }else{
    echo "<font color=red>" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
    echo "<script>alert('" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
    }
    }*/
    $accept_payment_method_ucb_file = "";
    /*if ($_FILES["accept_payment_method_ucb_file"]["error"] > 0){
    echo "Return Code: " . $_FILES["accept_payment_method_ucb_file"]["error"] . "<br />";
    }else{
    $ext1 = pathinfo($_FILES["accept_payment_method_ucb_file"]["name"], PATHINFO_EXTENSION);
    if(in_array(strtolower($ext1), $allow_ext1) ){
    move_uploaded_file($_FILES["accept_payment_method_ucb_file"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["accept_payment_method_ucb_file"]["name"]);
    $accept_payment_method_ucb_file = $_FILES["accept_payment_method_ucb_file"]["name"];
    }else{
    echo "<font color=red>" . $_FILES["accept_payment_method_ucb_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
    echo "<script>alert('" . $_FILES["accept_payment_method_ucb_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
    }
    }*/

    $receivable_payment_terms_given_by_ucbzerowaste = $_REQUEST["receivable_payment_terms_given_by_ucbzerowaste"];
    $receivable_client_contact_name = FixString($_REQUEST["receivable_client_contact_name"]);
    $receivable_client_contact_phone = FixString($_REQUEST["receivable_client_contact_phone"]);
    $receivable_client_contact_email = FixString($_REQUEST["receivable_client_contact_email"]);
    db();
    $ins_sql = db_query("INSERT INTO water_vendors_receivable_contact (`water_vendor_id`,`receivable_contact_name`,`receivable_title`,`receivable_address1`,`receivable_address2`,`receivable_city`,
	`receivable_state`,`receivable_zipcode`,`receivable_main_phone`,`receivable_direct_phone`,`receivable_cell`,`receivable_email`,`receivable_fax`,`receivable_portal_name`,`receivable_portal_link`,
	`receivable_notes`,`do_we_get_invoiced`,`receivable_need_tonnage_report`,`vendor_accept_payment_method`,`websitelink_invoice_payment`, `website_username`, `website_password`, `website_cust_acct_number`, `creditcard_autopay_setup`, `creditcard_autopayment`, `accept_payment_method_file_one`,
		`vendor_payment_method_ucb`, `accept_payment_method_file_two`,`receivable_payment_terms_given_by_ucbzerowaste`,`receivable_client_contact_name`,`receivable_client_contact_phone`,
	`receivable_client_contact_email`,`created_on`) VALUES ('$water_vendor_id','$receivable_contact_name','$receivable_title','$receivable_address1','$receivable_address2','$receivable_city'
	,'$receivable_state','$receivable_zipcode','$receivable_main_phone','$receivable_direct_phone','$receivable_cell','$receivable_email','$receivable_fax','$receivable_portal_name',
	'$receivable_portal_link','$receivable_notes','$do_we_get_invoiced','$receivable_need_tonnage_report','$accept_payment_method','$website_link','$website_userlogin','$website_password','$website_accountid_number','$website_creditcard_autopay_setup',
	'$website_creditcard_autopay','$accept_payment_method_file1','$vendor_payment_method_ucb','$accept_payment_method_ucb_file',
	'$receivable_payment_terms_given_by_ucbzerowaste','$receivable_client_contact_name','$receivable_client_contact_phone','$receivable_client_contact_email','" . date("Y-m-d h:i:s") . "')");

    if (empty($ins_sql)) {

        echo "<DIV CLASS='SQL_RESULTS'>Record Added.   <a href=\"water_vendor_master_new.php?posting=yes&recupdated=y\">Continue</a></DIV>";
        if (isset($_REQUEST["wateritem"]) && $_REQUEST["wateritem"] == "y") {
            echo "<script type=\"text/javascript\">";
            echo "window.location.href=\"water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\";";
            echo "</script>";
            echo "<noscript>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\" />";
            echo "</noscript>";exit;
        } else {
            echo "<script type=\"text/javascript\">";
            echo "window.location.href=\"water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\";";
            echo "</script>";
            echo "<noscript>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\" />";
            echo "</noscript>";exit;
        }
    } else {
        echo "Error Adding Vendor Receivable Contact record.$sql";
    }
}

if ($proc == "DELETE_PAYABLE_CONTACT") {
    db();
    $delete_record = db_query("DELETE from water_vendors_payable_contact where id = " . $_REQUEST['contact_id']);

    if (empty($delete_record)) {
        echo "<DIV CLASS='SQL_RESULTS'>Record Deleted.   <a href=\"water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\">Continue</a></DIV>";
        if (isset($_REQUEST["wateritem"]) && $_REQUEST["wateritem"] == "y") {
            echo "<script type=\"text/javascript\">";
            echo "window.location.href=\"water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\";";
            echo "</script>";
            echo "<noscript>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\" />";
            echo "</noscript>";exit;
        } else {
            echo "<script type=\"text/javascript\">";
            echo "window.location.href=\"water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\";";
            echo "</script>";
            echo "<noscript>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\" />";
            echo "</noscript>";exit;
        }
    } else {
        echo "Error Adding Vendor Payable Contact record.$sql";
    }
}
if ($proc == "EDIT_PAYABLE_CONTACT") {
    $water_vendor_id = $_REQUEST['water_vendor_id'];
    $vendor_contact_id = $_REQUEST['vendor_contact_id'];
    $payable_contact_name = FixString($_REQUEST["payable_contact_name"]);
    $payable_title = FixString($_REQUEST["payable_title"]);
    $payable_address1 = FixString($_REQUEST["payable_address1"]);
    $payable_address2 = FixString($_REQUEST["payable_address2"]);
    $payable_city = FixString($_REQUEST["payable_city"]);
    $payable_state = $_REQUEST["payable_state"];
    $payable_zipcode = FixString($_REQUEST["payable_zipcode"]);
    $payable_main_phone = FixString($_REQUEST["payable_main_phone"]);
    $payable_direct_phone = FixString($_REQUEST["payable_direct_phone"]);
    $payable_cell = FixString($_REQUEST["payable_cell"]);
    $payable_email = FixString($_REQUEST["payable_email"]);
    $payable_fax = FixString($_REQUEST["payable_fax"]);
    $payable_portal_name = FixString($_REQUEST["payable_portal_name"]);
    $payable_portal_link = $_REQUEST["payable_portal_link"];
    $payable_notes = $_REQUEST["payable_notes"];
    $do_we_get_rebate = $_REQUEST['do_we_get_rebate'];
    $need_separate_invoice = $_REQUEST["need_separate_invoice"];
    $payable_payment_terms_accepted_by_ucbzerowaste = $_REQUEST["payable_payment_terms_accepted_by_ucbzerowaste"];
    $filetype1 = "jpg,jpeg,gif,png,PNG,JPG,JPEG,pdf";
    $allow_ext1 = explode(",", $filetype1);

    $accept_payment_method_file = $_REQUEST['old_accept_payment_method_file'];

    if ($_FILES["accept_payment_method_file"]["name"] != "") {
        if ($_FILES["accept_payment_method_file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["accept_payment_method_file"]["error"] . "<br />";
        } else {
            $ext1 = pathinfo($_FILES["accept_payment_method_file"]["name"], PATHINFO_EXTENSION);
            if (in_array(strtolower($ext1), $allow_ext1)) {
                move_uploaded_file($_FILES["accept_payment_method_file"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["accept_payment_method_file"]["name"]);
                $accept_payment_method_file = $_FILES["accept_payment_method_file"]["name"];
            } else {
                echo "<font color=red>" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
                echo "<script>alert('" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
            }
        }
    }
    $payable_client_contact_name = FixString($_REQUEST["payable_client_contact_name"]);
    $payable_client_contact_phone = FixString($_REQUEST["payable_client_contact_phone"]);
    $payable_client_contact_email = FixString($_REQUEST["payable_client_contact_email"]);
    $created_on = date("Y-m-d h:i:s");
    db();
    $upd_sql = db_query("UPDATE water_vendors_payable_contact set `payable_contact_name`='$payable_contact_name',`payable_title`='$payable_title',`payable_address1`='$payable_address1',`payable_address2`='$payable_address2',
	`payable_city`='$payable_city',`payable_state`='$payable_state',`payable_zipcode`='$payable_zipcode',`payable_main_phone`='$payable_main_phone',`payable_direct_phone`='$payable_direct_phone',
	`payable_cell`='$payable_cell',`payable_email`='$payable_email', `payable_fax`='$payable_fax',`payable_portal_name`='$payable_portal_name',`payable_portal_link`='$payable_portal_link',
	`payable_notes`='$payable_notes',`do_we_get_rebate`='$do_we_get_rebate',`need_separate_invoice`='$need_separate_invoice',`payable_payment_terms_accepted_by_ucbzerowaste`='$payable_payment_terms_accepted_by_ucbzerowaste',
	`accept_payment_method_file`='$accept_payment_method_file',`payable_client_contact_name`='$payable_client_contact_name',`payable_client_contact_phone`='$payable_client_contact_phone',`payable_client_contact_email`='$payable_client_contact_email',
	`created_on`='$created_on' where id=$vendor_contact_id");

    if (empty($upd_sql)) {
        echo "<DIV CLASS='SQL_RESULTS'>Record Updated.   <a href=\"water_vendor_master_new.php?posting=yes&recupdated=y\">Continue</a></DIV>";
        if (isset($_REQUEST["wateritem"]) && $_REQUEST["wateritem"] == "y") {
            echo "<script type=\"text/javascript\">";
            echo "window.location.href=\"water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\";";
            echo "</script>";
            echo "<noscript>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\" />";
            echo "</noscript>";exit;
        } else {
            echo "<script type=\"text/javascript\">";
            echo "window.location.href=\"water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\";";
            echo "</script>";
            echo "<noscript>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\" />";
            echo "</noscript>";exit;
        }
    } else {
        echo "Error Updating Vendor Payable Contact record.$sql";
    }
}

if ($proc == "ADD_PAYABLE_CONTACT") {
    $water_vendor_id = $_REQUEST['water_vendor_id'];
    $payable_contact_name = FixString($_REQUEST["payable_contact_name"]);
    $payable_title = FixString($_REQUEST["payable_title"]);
    $payable_address1 = FixString($_REQUEST["payable_address1"]);
    $payable_address2 = FixString($_REQUEST["payable_address2"]);
    $payable_city = FixString($_REQUEST["payable_city"]);
    $payable_state = $_REQUEST["payable_state"];
    $payable_zipcode = FixString($_REQUEST["payable_zipcode"]);
    $payable_main_phone = FixString($_REQUEST["payable_main_phone"]);
    $payable_direct_phone = FixString($_REQUEST["payable_direct_phone"]);
    $payable_cell = FixString($_REQUEST["payable_cell"]);
    $payable_email = FixString($_REQUEST["payable_email"]);
    $payable_fax = FixString($_REQUEST["payable_fax"]);
    $payable_portal_name = FixString($_REQUEST["payable_portal_name"]);
    $payable_portal_link = $_REQUEST["payable_portal_link"];
    $payable_notes = $_REQUEST["payable_notes"];
    $do_we_get_rebate = $_REQUEST['do_we_get_rebate'];
    $need_separate_invoice = $_REQUEST["need_separate_invoice"];
    $payable_payment_terms_accepted_by_ucbzerowaste = $_REQUEST["payable_payment_terms_accepted_by_ucbzerowaste"];
    $filetype1 = "jpg,jpeg,gif,png,PNG,JPG,JPEG,pdf";
    $allow_ext1 = explode(",", $filetype1);

    $accept_payment_method_file = "";
    if ($_FILES["accept_payment_method_file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["accept_payment_method_file"]["error"] . "<br />";
    } else {
        $ext1 = pathinfo($_FILES["accept_payment_method_file"]["name"], PATHINFO_EXTENSION);
        if (in_array(strtolower($ext1), $allow_ext1)) {
            move_uploaded_file($_FILES["accept_payment_method_file"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["accept_payment_method_file"]["name"]);
            $accept_payment_method_file = $_FILES["accept_payment_method_file"]["name"];
        } else {
            echo "<font color=red>" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
            echo "<script>alert('" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
        }
    }

    $payable_client_contact_name = FixString($_REQUEST["payable_client_contact_name"]);
    $payable_client_contact_phone = FixString($_REQUEST["payable_client_contact_phone"]);
    $payable_client_contact_email = FixString($_REQUEST["payable_client_contact_email"]);
    db();
    $ins_sql = db_query("INSERT INTO water_vendors_payable_contact (`water_vendor_id`,`payable_contact_name`,`payable_title`,`payable_address1`,`payable_address2`,`payable_city`,
	`payable_state`,`payable_zipcode`,`payable_main_phone`,`payable_direct_phone`,`payable_cell`,`payable_email`,`payable_fax`,`payable_portal_name`,`payable_portal_link`,
	`payable_notes`,`do_we_get_rebate`,`need_separate_invoice`,`payable_payment_terms_accepted_by_ucbzerowaste`,`accept_payment_method_file`,`payable_client_contact_name`,`payable_client_contact_phone`,
	`payable_client_contact_email`,`created_on`) VALUES ('$water_vendor_id','$payable_contact_name','$payable_title','$payable_address1','$payable_address2','$payable_city'
	,'$payable_state','$payable_zipcode','$payable_main_phone','$payable_direct_phone','$payable_cell','$payable_email','$payable_fax','$payable_portal_name',
	'$payable_portal_link','$payable_notes','$do_we_get_rebate','$need_separate_invoice','$payable_payment_terms_accepted_by_ucbzerowaste','$accept_payment_method_file','$payable_client_contact_name','$payable_client_contact_phone','$payable_client_contact_email','" . date("Y-m-d h:i:s") . "')");

    if (empty($ins_sql)) {

        echo "<DIV CLASS='SQL_RESULTS'>Record Added.   <a href=\"water_vendor_master_new.php?posting=yes&recupdated=y\">Continue</a></DIV>";
        if (isset($_REQUEST["wateritem"]) && $_REQUEST["wateritem"] == "y") {
            echo "<script type=\"text/javascript\">";
            echo "window.location.href=\"water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\";";
            echo "</script>";
            echo "<noscript>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\" />";
            echo "</noscript>";exit;
        } else {
            echo "<script type=\"text/javascript\">";
            echo "window.location.href=\"water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\";";
            echo "</script>";
            echo "<noscript>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=water_vendor_master_new.php?id=" . $_REQUEST["id"] . "&proc=View&flag=yes&compid=" . $_REQUEST["compid"] . "\" />";
            echo "</noscript>";exit;
        }
    } else {
        echo "Error Adding Vendor Payable Contact record.$sql";
    }
}

if ($proc == "Edit") {
    if (isset($_REQUEST["id"])) {
        $id = $_REQUEST["id"];
    }

    if (isset($_REQUEST["submit"]) && $_REQUEST["post"] == "yes") {

        $compid = FixString($_REQUEST["compid"]);
        $vendor_status_o = $_REQUEST["vendor_status"];
        $vendor_name = FixString($_REQUEST["vendor_name"]);
        $vendor_description = FixString($_REQUEST["vendor_description"]);
        $materialist = implode("|", $_REQUEST["materials"]);
        $transportation = $_REQUEST["transportation"];
        $businessarea_state = implode("|", $_REQUEST["businessarea_state"]);
        $vendor_salespoint_contact_name = FixString($_REQUEST["vendor_salespoint_contact_name"]);
        $vendor_salespoint_contact_email = FixString($_REQUEST["vendor_salespoint_contact_email"]);
        $vendor_salespoint_contact_phone = FixString($_REQUEST["vendor_salespoint_contact_phone"]);
        $vendor_main_phone = $_REQUEST["vendor_main_phone"];
        $vendor_hq_address = FixString($_REQUEST["vendor_hq_address"]);
        $vendor_hq_city = FixString($_REQUEST["vendor_hq_city"]);
        $vendor_hq_state = $_REQUEST["vendor_hq_state"];
        $vendor_zipcode = $_REQUEST["zipcode"];
        $for_what_client = FixString($_REQUEST['for_what_client']);
        $vendor_terms = $_REQUEST['vendor_terms'];
        $link_for_client_record = $_REQUEST['link_for_client_record'];
        $title = FixString($_REQUEST['title']);
        $full_address2 = FixString($_REQUEST['full_address2']);
        $directPhone = FixString($_REQUEST['directPhone']);
        $Fax = FixString($_REQUEST['Fax']);
        $bill_switch_ucbzwaste = FixString($_REQUEST['bill_switch_ucbzwaste']);
        $linkedIn_profile = $_REQUEST['linkedIn_profile'] != "" ? FixString($_REQUEST['linkedIn_profile']) : "";
        $date_of_bill_switch = date("Y-m-d", strtotime($_REQUEST['date_of_bill_switch']));
        $general_notes = FixString($_REQUEST['general_notes']);
        // file upload agreement and logo
        $filetype1 = "jpg,jpeg,gif,png,PNG,JPG,JPEG,pdf";
        $allow_ext1 = explode(",", $filetype1);

        $signed_approved_bill_switch_agreement = "";
        if ($_FILES['signed_approved_bill_switch_agreement']['name'] != "") {
            if ($_FILES["signed_approved_bill_switch_agreement"]["error"] > 0) {
                echo "Return Code: " . $_FILES["signed_approved_bill_switch_agreement"]["error"] . "<br />";
            } else {
                $ext1 = pathinfo($_FILES["signed_approved_bill_switch_agreement"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext1), $allow_ext1)) {
                    move_uploaded_file($_FILES["signed_approved_bill_switch_agreement"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["signed_approved_bill_switch_agreement"]["name"]);
                    $signed_approved_bill_switch_agreement = $_FILES["signed_approved_bill_switch_agreement"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["signed_approved_bill_switch_agreement"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }

        $accept_payment_method_file1 = "";
        if ($_FILES['accept_payment_method_file']['name'] != "") {
            if ($_FILES["accept_payment_method_file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["accept_payment_method_file"]["error"] . "<br />";
            } else {
                $ext1 = pathinfo($_FILES["accept_payment_method_file"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext1), $allow_ext1)) {
                    move_uploaded_file($_FILES["accept_payment_method_file"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["accept_payment_method_file"]["name"]);
                    $accept_payment_method_file1 = $_FILES["accept_payment_method_file"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["accept_payment_method_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }

        $agreement_ucb_client_file = "";
        if ($_FILES['agreement_ucb_client_file']['name'] != "") {
            if ($_FILES["agreement_ucb_client_file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["agreement_ucb_client_file"]["error"] . "<br />";
            } else {
                $ext1 = pathinfo($_FILES["agreement_ucb_client_file"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext1), $allow_ext1)) {
                    move_uploaded_file($_FILES["agreement_ucb_client_file"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["agreement_ucb_client_file"]["name"]);
                    $agreement_ucb_client_file = $_FILES["agreement_ucb_client_file"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["agreement_ucb_client_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["agreement_ucb_client_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }

        $vendor_logo_file = "";
        if ($_FILES['vendor_logo_file']['name'] != "") {
            if ($_FILES["vendor_logo_file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["vendor_logo_file"]["error"] . "<br />";
            } else {
                $ext = pathinfo($_FILES["vendor_logo_file"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext), $allow_ext1)) {
                    move_uploaded_file($_FILES["vendor_logo_file"]["tmp_name"], "vendor_logo_images/" . $_FILES["vendor_logo_file"]["name"]);
                    $vendor_logo_file = $_FILES["vendor_logo_file"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["vendor_logo_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["vendor_logo_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }

        //certificate_of_insurance file upload
        $coi_file_update = "";
        if ($_FILES['coi_file']['name'] != "") {
            if ($_FILES["coi_file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["coi_file"]["error"] . "<br />";
            } else {
                $ext1 = pathinfo($_FILES["coi_file"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext1), $allow_ext1)) {
                    move_uploaded_file($_FILES["coi_file"]["tmp_name"], "certificate_of_insurance_images/" . $_FILES["coi_file"]["name"]);
                    $coi_file_update = $_FILES["coi_file"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["coi_file"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["coi_file"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }

        $filetype2 = "doc,docx,xls,xlsx,pdf,DOC,DOCX,XLS,XLSX,PDF";
        $allow_ext2 = explode(",", $filetype2);

        $vendor_onboarding_form = "";
        if ($_FILES['vendor_onboarding_form']['name'] != "") {
            if ($_FILES["vendor_onboarding_form"]["error"] > 0) {
                echo "Return Code: " . $_FILES["vendor_onboarding_form"]["error"] . "<br />";
            } else {
                $ext1 = pathinfo($_FILES["vendor_onboarding_form"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext1), $allow_ext2)) {
                    move_uploaded_file($_FILES["vendor_onboarding_form"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["vendor_onboarding_form"]["name"]);
                    $vendor_onboarding_form = $_FILES["vendor_onboarding_form"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["vendor_onboarding_form"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["vendor_onboarding_form"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }

        $vendor_audit_form = "";
        if ($_FILES['vendor_audit_form']['name'] != "") {
            if ($_FILES["vendor_audit_form"]["error"] > 0) {
                echo "Return Code: " . $_FILES["vendor_audit_form"]["error"] . "<br />";
            } else {
                $ext1 = pathinfo($_FILES["vendor_audit_form"]["name"], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext1), $allow_ext2)) {
                    move_uploaded_file($_FILES["vendor_audit_form"]["tmp_name"], "vendor_payment_method_images/" . $_FILES["vendor_audit_form"]["name"]);
                    $vendor_audit_form = $_FILES["vendor_audit_form"]["name"];
                } else {
                    echo "<font color=red>" . $_FILES["vendor_audit_form"]["name"] . " file not uploaded, this file type is restricted.</font>";
                    echo "<script>alert('" . $_FILES["vendor_audit_form"]["name"] . " file not uploaded, this file type is restricted.');</script>";
                }
            }
        }
        $vendor_tax_id = $_REQUEST['vendor_tax_id'];
        $vendor_shipping_contact_name = FixString($_REQUEST["vendor_shipping_contact_name"]);
        $vendor_shipping_contact_email = FixString($_REQUEST["vendor_shipping_contact_email"]);
        $vendor_shipping_contact_phone = FixString($_REQUEST["vendor_shipping_contact_phone"]);
        $notes = FixString($_REQUEST["notes"]);
        $id = $_REQUEST["id"];
        $coi_date = $_REQUEST["coi_date"];
        $coi_expired_flg = $_REQUEST["coi_expired_flg"];

        //Check COI date and set status

        if ($coi_date != "" && $coi_date != "11/30/-0001") {
            $today = date("Y-m-d");
            $date2 = date_create($coi_date);
            $date1 = date_create($today);
            $diff = date_diff($date1, $date2);
            $total_days = $diff->format("%R%a");
            //echo $total_days;
            if ($total_days < 30) {
                $coi_expired_flg = "Yes";
                $vendor_status = 1;
            } elseif ($total_days >= 30) {
                $vendor_status = $vendor_status_o;
            }
        } else {
            $vendor_status = $vendor_status_o;
        }
        //
        $coi_date = date("Y-m-d", strtotime($coi_date));
        $sql = "UPDATE water_vendors SET  Name = '$vendor_name',`active_flg`='$vendor_status',`for_what_client`='$for_what_client',`vendor_terms`='$vendor_terms',`link_for_client_record`='$link_for_client_record',
		`description`='$vendor_description',main_material = '$main_material',`transportation`='$transportation',`business_area`='$businessarea_state',
		`contact_name`='$vendor_salespoint_contact_name',`title`='$title',`full_address`='$vendor_hq_address',full_address2='$full_address2', billingSwitchToZeroWaste = '$bill_switch_ucbzwaste',
		city = '$vendor_hq_city',`state`='$vendor_hq_state',zipcode = '$vendor_zipcode',`PhoneNo`='$vendor_main_phone',`directPhone`='$directPhone',
		contact_phone='$vendor_salespoint_contact_phone',contact_email='$vendor_salespoint_contact_email',`Fax`='$Fax',linkedIn_profile='$linkedIn_profile',
		`notes`='$notes',date_of_bill_switch='$date_of_bill_switch',`coi_expired_flg`='$coi_expired_flg',certificate_of_insurance_expiry_dt = '$coi_date',
		`vendor_tax_id`='$vendor_tax_id',`shipping_contact_name`='$vendor_shipping_contact_name',`shipping_contact_email`='$vendor_shipping_contact_email',`shipping_contact_phone`='$vendor_shipping_contact_phone',
		general_notes='$general_notes'";
        if ($compid != "") {
            $sql .= ", `b2bid` = '$compid' ";
        }

        if ($vendor_logo_file != "") {
            $sql .= ", `logo_image` = '$vendor_logo_file' ";
        }
        if ($signed_approved_bill_switch_agreement != "") {
            $sql .= ", `signed_approved_bill_switch_agreement` = '$signed_approved_bill_switch_agreement' ";
        }

        if ($agreement_ucb_client_file != "") {
            $sql .= ", `vendor_aggrement_file` = '$agreement_ucb_client_file' ";
        }

        if ($coi_file_update != "") {
            $sql .= ", `certificate_of_insurance` = '$coi_file_update' ";
        }
        if ($vendor_onboarding_form != "") {
            $sql .= ", `vendor_onboarding_form` = '$vendor_onboarding_form' ";
        }
        if ($vendor_audit_form != "") {
            $sql .= ", `vendor_audit_form` = '$vendor_audit_form' ";
        }
        $sql .= "WHERE (`id`='$id')";

        //echo "<BR>SQL: $sql<BR>";
        db();
        $result = db_query($sql);
        if (empty($result)) {
            db();
            $result1 = db_query("delete from water_vendor_materials_trans_data where water_vendor_id = '" . $id . "'");
            foreach ($_REQUEST["materials"] as $materials_ids) {
                db();
                $result1 = db_query("insert into water_vendor_materials_trans_data (water_vendor_id, water_vendor_materials_id) select '" . $id . "', '" . $materials_ids . "'");
            }

            echo "<DIV CLASS='SQL_RESULTS'>Record Updated.   <a href=\"water_vendor_master_new.php?posting=yes&recupdated=y\">Continue</a></DIV>";
            if (isset($_REQUEST["wateritem"]) && $_REQUEST["wateritem"] == "y") {
                echo "<script type=\"text/javascript\">";
                echo "window.location.href=\"water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\";";
                echo "</script>";
                echo "<noscript>";
                echo "<meta http-equiv=\"refresh\" content=\"0;url=water_manage_box_b2bloop.php?pgname=viewcomp&proc=New&compid=" . $_REQUEST["compid"] . "\" />";
                echo "</noscript>";exit;
            } else {
                echo "<script type=\"text/javascript\">";
                echo "window.location.href=\"water_vendor_master_new.php?posting=yes&recupdated=y\";";
                echo "</script>";
                echo "<noscript>";
                echo "<meta http-equiv=\"refresh\" content=\"0;url=water_vendor_master_new.php?posting=yes&recupdated=y\" />";
                echo "</noscript>";exit;
            }
        } else {
            echo "Error Updating B2B water_vendors record.$sql";
        }

    } //if from submitted end here.

    if ($_REQUEST["post"] == "") {

        echo "<DIV CLASS='PAGE_STATUS'>Adding or Editing Vendor Record :</DIV>";
        $sql = "SELECT * FROM water_vendors WHERE ID = $id  $addl_select_crit ";
        db();
        $result = db_query($sql) or die("Error Retrieving Records (9993SQLGET)");
        if ($myrow = array_shift($result)) {
            do {
                $status = $myrow["active_flg"];
                $transportation = $myrow["transportation"];
                $switchucbzw = $myrow["billingSwitchToZeroWaste"];
                $agreementclient = $myrow["agreement_with_client"];
                $coi_expired_flg = $myrow["coi_expired_flg"];

                $comp_names = "";
                $new_sql = "SELECT loop_warehouse.b2bid, loop_warehouse.warehouse_name FROM water_transaction inner join water_vendors on water_transaction.vendor_id = water_vendors.id
				inner join loop_warehouse on loop_warehouse.id = water_transaction.company_id
				where water_vendors.id = '" . $id . "' group by water_transaction.company_id";
                db();
                $get_boxes_query = db_query($new_sql);
                while ($boxes = array_shift($get_boxes_query)) {
                    $comp_names = $comp_names . "<a target='_blank' href='viewCompany-purchasing.php?ID=" . $boxes["b2bid"] . "&proc=View&searchcrit=&show=watertransactions&rec_type=Manufacturer'>" . get_nickname_val($boxes["warehouse_name"], $boxes["b2bid"]) . "</a>, ";
                }

                ?>
			<table width="100%" class="vendors_master_database_table">
				<tr>
					<td>
						<form name="frmVendorEdit" method="post" action="<?php echo $thispage; ?>?id=<?php echo $_REQUEST["id"]; ?>&proc=Edit&pgname=<?php echo $_REQUEST["pgname"]; ?>&compid=<?php echo $_REQUEST["compid"]; ?>&post=yes&<?php echo $pagevars; ?>&flag=yes" enctype="multipart/form-data">
							<input type="hidden" name="wateritem" id="wateritem" value="<?php echo $_REQUEST["wateritem"]; ?>" >
							<TABLE border='1' id="maintbl1" class="vendors_master_database_table">
								<tr>
									<th colspan="2">Vendor Information:</th>
								</tr>
								<tr>
									<td class="frmlabel"><b>Vendor Name:</b></td>
									<td><input class="vendor_input" type="text" name="vendor_name" value="<?php echo $myrow["Name"]; ?>"></td>
									</tr>
								<tr>
									<td class="frmlabel"><b>Acct. Status:</b></td>
									<td>
										<select class="vendor_select" name="vendor_status">
											<option value="1" <?php if ($status == 1) {
                    echo "selected";
                }
                ?> >Active Vendor</option>
											<option value="2" <?php if ($status == 2) {
                    echo "selected";
                }
                ?> >Known Vendor</option>
											<option value="0" <?php if ($status == 0) {
                    echo "selected";
                }
                ?> >Do not use Vendor</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Vendor Terms:</b></td>
									<td>
									<select class="vendor_select" name="vendor_terms">
										<option <?php if ($myrow['vendor_terms'] == "") {
                    echo "selected";
                }
                ?>value=""></option>
										<option <?php if ($myrow['vendor_terms'] == "Due On Receipt") {
                    echo "selected";
                }
                ?> value="Due On Receipt" >Due On Receipt</option>
										<option <?php if ($myrow['vendor_terms'] == "Net 10") {
                    echo "selected";
                }
                ?> value="Net 10">Net 10</option>
										<option <?php if ($myrow['vendor_terms'] == "Net 15") {
                    echo "selected";
                }
                ?> value="Net 15">Net 15</option>
										<option <?php if ($myrow['vendor_terms'] == "Net 30") {
                    echo "selected";
                }
                ?> value="Net 30">Net 30</option>
										<option <?php if ($myrow['vendor_terms'] == "Net 45") {
                    echo "selected";
                }
                ?> value="Net 45">Net 45</option>
										<option <?php if ($myrow['vendor_terms'] == "Net 60") {
                    echo "selected";
                }
                ?> value="Net 60">Net 60</option>
										<option <?php if ($myrow['vendor_terms'] == "Net 90") {
                    echo "selected";
                }
                ?> value="Net 90">Net 90</option>
										<option <?php if ($myrow['vendor_terms'] == "Net 120") {
                    echo "selected";
                }
                ?> value="Net 120">Net 120</option>
									</select>
									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>For What Client:</b></td>
									<td><?php echo $comp_names; ?></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Description:</b></td>
									<td><input class="vendor_input" type="text" name="vendor_description" value="<?php echo $myrow["description"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Materials Managed:</b></td>
									<td>
											<select class="vendor_select" id="vendor_material" name="materials[]" multiple>
											<?php
$materialarr = array();
                $main_material = "";
                $new_sql = "Select water_vendor_materials_id from water_vendor_materials_trans_data inner join water_vendor_materials on water_vendor_materials.id = water_vendor_materials_trans_data.water_vendor_materials_id
												where water_vendor_id = '" . $_REQUEST["id"] . "'";
                db();
                $get_boxes_query = db_query($new_sql);
                while ($boxes = array_shift($get_boxes_query)) {
                    $main_material = $main_material . $boxes["water_vendor_materials_id"] . "|";
                }
                $materialarr = explode("|", $main_material);

                $sqlfrm = "SELECT * FROM water_vendor_materials order by material ASC";
                db();
                $statearr = db_query($sqlfrm);
                foreach ($statearr as $row) {
                    echo '<option value="' . $row["id"] . '" ' . ((in_array($row["id"], $materialarr)) ? "selected" : "") . '>' . $row["material"] . '</option>';
                }
                ?>
											</select>
											<script>
												document.multiselect('#vendor_material')
												.setCheckBoxClick("checkboxAll", function(target, args) {
												})
												.setCheckBoxClick("1", function(target, args) {
													console.log("Checkbox for item with value '1' was clicked and got value ", args.checked);
												});
										</script>
									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Transportation:</b></td>
									<td>
									<select class="vendor_select" name="transportation">
										<option value=""></option>
										<option value="Yes" <?if($transportation == "Yes") echo "selected";?>>Yes</option>
										<option value="No" <?if($transportation == "No") echo "selected";?>>No</option>
										<option value="Unknown" <?if($transportation == "Unknown") echo "selected";?>>Unknown</option>
									</select>
									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Area of Business:</b></td>
									<td>
										<select class="vendor_select" id="businessarea_state" name="businessarea_state[]" multiple>
											<?php
						                $business_areaarr = explode("|", $myrow["business_area"]);
										$sqlfrm = "SELECT * FROM state_master order by state ";
										db();
										$statearr = db_query($sqlfrm);
										foreach ($statearr as $row) {
											echo '<option value="' . $row["state"] . '" ' . ((in_array($row["state"], $business_areaarr)) ? "selected" : "") . '>' . $row["state"] . '</option>';
										}
										?>
										</select>
										<script>
											document.multiselect('#businessarea_state')
											.setCheckBoxClick("checkboxAll", function(target, args) {
											})
											.setCheckBoxClick("1", function(target, args) {
												//console.log("Checkbox for item with value '1' was clicked and got value ", args.checked);
											});
										</script>
									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Sales Contact Name:</b></td>
									<td><input class="vendor_input" type="text" name="vendor_salespoint_contact_name" value="<?php echo $myrow["contact_name"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Title:</b></td>
									<td><input class="vendor_input" type="text" name="title" value="<?php echo $myrow["title"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Address 1:</b></td>
									<td><input class="vendor_input" type="text" name="vendor_hq_address" value="<?php echo $myrow["full_address"]; ?>"</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Address 2:</b></td>
									<td><input class="vendor_input" type="text" name="full_address2" value="<?php echo $myrow["full_address2"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>City:</b></td>
									<td><input class="vendor_input" type="text" name="vendor_hq_city" value="<?php echo $myrow["city"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>State/Province:</b></td>
									<td>
										<select class="vendor_select" name="vendor_hq_state">
											<option value=""></option>
											<?php
									         $sqlfrm = "SELECT * FROM state_master order by state ";
													db();
													$statearr = db_query($sqlfrm);
													foreach ($statearr as $row) {
														echo '<option value="' . $row["state"] . '"  ' . (($row["state"] == $myrow["state"]) ? "Selected" : "") . '>' . $row["state"] . '</option>';
													}
													?>
										</select>
									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Zip Code:</b></td>
									<td><input class="vendor_input" type="text" name="zipcode" value="<?php echo $myrow["zipcode"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Main Phone:</b></td>
									<td><input class="vendor_input" type="text" name="vendor_main_phone" value="<?php echo $myrow["PhoneNo"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Direct Phone:</b></td>
									<td><input class="vendor_input" type="text" name="directPhone" value="<?php echo $myrow["directPhone"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Cell:</b></td>
									<td><input class="vendor_input" type="text" name="vendor_salespoint_contact_phone" value="<?php echo $myrow["contact_phone"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Email:</b></td>
									<td><input class="vendor_input" type="text" name="vendor_salespoint_contact_email" value="<?php echo $myrow["contact_email"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Fax:</b></td>
									<td><input class="vendor_input" type="text" name="Fax" value="<?php echo $myrow["Fax"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>LinkedIn Profile:</b></td>
									<td><input class="vendor_input" type="text" name="linkedIn_profile" value="<?php echo $myrow["linkedIn_profile"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Notes:</b></td>
									<td><input class="vendor_input" type="text" name="notes" value="<?php echo $myrow["notes"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Billing Switch to UCBZeroWaste:</b></td>
									<td>
										<select class="vendor_select" name="bill_switch_ucbzwaste">
											<option value=""></option>
											<option value="Yes" <?if($switchucbzw == "Yes") echo "selected";?>>Yes</option>
											<option value="No" <?if($switchucbzw == "No") echo "selected";?>>No</option>
											<option value="Unknown" <?if($switchucbzw == "Unknown") echo "selected";?>>Unknown</option>
										</select>
									</td>
								</tr>

								<tr>
									<td class="frmlabel"><b>Date of Billing Switch:</b></td>
									<td>
										<input id="date_of_bill_switch" name="date_of_bill_switch" class="form_component" type="text" value="<?php if ($myrow["date_of_bill_switch"] != "" && $myrow["date_of_bill_switch"] != "0000-00-00") {
											echo date("m/d/Y", strtotime($myrow["date_of_bill_switch"]));
										}
										?>" placeholder="MM/DD/YYYY"> &nbsp;&nbsp;
										<a href="#" onclick="caldate_of_bill_switchdt.select(document.frmVendorEdit.date_of_bill_switch,'anchordate_of_bill_switchdt','MM/dd/yyyy'); return false;" name="anchordate_of_bill_switchdt" id="anchordate_of_bill_switchdt"><img border="0" src="images/calendar.jpg"></a>
										<div ID="listdiv_date_of_bill_switchdt" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></div>
									</td>

								</tr>
								<tr>
									<td class="frmlabel"><b>Signed/Approved: Bill Switch Agreement:</b></td>
									<td>
										<?php if ($myrow["signed_approved_bill_switch_agreement"] != "") {?>
										<a href="vendor_payment_method_images/<?php echo $myrow["signed_approved_bill_switch_agreement"]; ?>" target="_blank">View</a><br><br>
										<?php }?>
										<input type="hidden" name="old_signed_approved_bill_switch_agreement" value="<?php echo $myrow["signed_approved_bill_switch_agreement"]; ?>" />
										<input onchange="checkfile(this.id)" id="signed_approved_bill_switch_agreement" class="vendor_input" type="file" name="signed_approved_bill_switch_agreement" accept="application/pdf">
									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Copy of Agreement: (FYI to be attached)</b></td>
									<td>
										<a href="vendor_payment_method_images/<?php echo $myrow["vendor_aggrement_file"]; ?>" target="_blank">View</a><br><br>
										<input onchange="checkfile(this.id)" id="agreement_ucb_client_file" class="vendor_input" type="file" name="agreement_ucb_client_file" accept="application/pdf">
									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Certificate of Insurance (COI) Status:</b></td>
									<td>
										<select class="vendor_select" name="coi_expired_flg">
											<option value=""></option>
											<option value="Yes" <?php if ($coi_expired_flg == "Yes") {
												echo "selected";
											}
											?>>Yes</option>
																		<option value="No" <?php if ($coi_expired_flg == "No") {
												echo "selected";
											}
											?>>No</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Attach Copy of COI:</b></td>
									<td>
									<?php
									if ($myrow["certificate_of_insurance"] != "") {
														?>
											<a href="certificate_of_insurance_images/<?php echo $myrow["certificate_of_insurance"]; ?>" target="_blank">View</a><br><br>
										<?php
	                                }
				                        	?>
										<input onchange="checkfile(this.id)" id="coi_file" class="vendor_input" type="file" name="coi_file" accept="application/pdf">

									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Date COI Expires:</b></td>
									<td>
										<input id="coi_date" name="coi_date" class="form_component" type="text" value="<?php if ($myrow["certificate_of_insurance_expiry_dt"] != "" && $myrow["certificate_of_insurance_expiry_dt"] != "0000-00-00") {
											echo date("m/d/Y", strtotime($myrow["certificate_of_insurance_expiry_dt"]));
										}
										?>"> &nbsp;&nbsp;
										<a href="#" onclick="calcoidt.select(document.frmVendorEdit.coi_date,'anchorcoidt','MM/dd/yyyy'); return false;" name="anchorcoidt" id="anchorcoidt"><img border="0" src="images/calendar.jpg"></a>
										<div ID="listdiv_coidt" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></div>
									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Vendor Onboarding Form:</b></td>
									<td>
										<?php
										if ($myrow["vendor_onboarding_form"] != "") {
															echo '<a href="vendor_payment_method_images/' . $myrow["vendor_onboarding_form"] . '" target= "_blank">View</a>';
															echo '<br><br>';
														}
														?>
										<input type="file" name="vendor_onboarding_form" accept=".pdf,.xls,.xlsx,.doc,.docx" class="vendor_input">

									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Vendor Audit Form: (For Hazardous Waste Vendors)</b></td>
									<td>
										<?php
									if ($myrow["vendor_audit_form"] != "") {
														echo '<a href="vendor_payment_method_images/' . $myrow["vendor_audit_form"] . '" target="_blank">View</a>';
														echo '<br><br>';
													}
													?>
										<input name="vendor_audit_form" type="file" class="vendor_input" accept=".pdf,.xls,.xlsx,.doc,.docx" >

									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Tax ID:</b></td>
									<td>
										<input class="vendor_input" type="text" name="vendor_tax_id" value="<?php echo $myrow["vendor_tax_id"]; ?>">
									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Shipping & Freight Contact Name:</b></td>
									<td>
										<input class="vendor_input" type="text" name="vendor_shipping_contact_name" value="<?php echo $myrow["shipping_contact_name"]; ?>">
									</td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Shipping & Freight Contact Email:</b></td>
									<td><input class="vendor_input" type="text" name="vendor_shipping_contact_email" value="<?php echo $myrow["shipping_contact_email"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Shipping & Freight Contact Phone:</b></td>
									<td><input class="vendor_input" type="text" name="vendor_shipping_contact_phone" value="<?php echo $myrow["shipping_contact_phone"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>General Notes:</b></td>
									<td><input class="vendor_input" type="text" name="general_notes" value="<?php echo $myrow["general_notes"]; ?>"></td>
								</tr>
								<tr>
									<td class="frmlabel"><b>Vendor Logo:</b></td>
									<td>
										<?php
										$imgurl = "https://loops.usedcardboardboxes.com/";
														?>
										<img src="<?php echo $imgurl . "vendor_logo_images/" . $myrow["logo_image"]; ?>" name="logoimg" width="200px" height="200px"><br><br>
										<input class="vendor_input" type="file" name="vendor_logo_file" >
									</td>
								</tr>
								<tr>
									<td colspan="6">
										<input type="hidden" value="<?php echo $id; ?>" name="id">
										<input CLASS="BUTTON" type="submit" value="Save" name="submit" onclick=chkfile()>
									</td>
								</tr>
							</TABLE>
							<BR>
						</form>
					</td>
					<td>
					<table class="vendor_receivable_contact_main_tbl vendor_inner_table" id="vendor_receivable_contact_main_tbl">
						<tr>
							<th colspan="2">Vendor Receivable Contact</th>
						</tr>
					</table>
					<?php
db();
                $vendor_receivable_contacts_sql = db_query("SELECT * FROM water_vendors_receivable_contact where water_vendor_id= $id order by id ASC");
                if (tep_db_num_rows($vendor_receivable_contacts_sql) > 0) {
                    $receivable_contacts_count = 1;
                    while ($myrow = array_shift($vendor_receivable_contacts_sql)) {

                        ?>
							<table class="vendor_receivable_contact_tbl contact_inner_table" width="100%">
								<thead>
								<tr class="inner_table_header">
									<td width="50%" align="left"><?php echo $myrow['receivable_contact_name'] . ' (' . $myrow['receivable_title'] . ')'; ?></td>
									<td width="50%" align="right">
										<a id="arrasc_<?php echo $myrow['id']; ?>" href="javascript:void(0);" onclick="show_receivale_contact_detail_div(<?php echo $myrow['id']; ?>)"><img src="images/sort_asc.png" width="6px" height="11px"></a>
										<a id="arrdesc_<?php echo $myrow['id']; ?>" href="javascript:void(0);" onclick="show_receivale_contact_detail_div(<?php echo $myrow['id']; ?>)" style="display: none;"><img src="images/sort_desc.png" width="6px" height="11px"></a>
									</td>
								</tr>
								</thead>
								<tbody id="rec_contact_detail_div_<?php echo $myrow['id']; ?>" style="display: <?php echo $receivable_contacts_count == 1 ? "revert" : "none"; ?>">
									<tr>
										<td class="frmlabel" colspan="2" align="center">
										<a  href="javascript:edit_receivable_contact(<?php echo $myrow['id']; ?>)">Edit</a>&nbsp;&nbsp;
										<a style="color:red" href="javascript:delete_receivable_contact(<?php echo $myrow["id"] ?>)" >Delete</a>
										</td>
									</tr>
									<tr>
										<td class="frmlabel" ><b>Name:</b></td>
										<td><?php echo $myrow["receivable_contact_name"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Title:</b></td>
										<td><?php echo $myrow["receivable_title"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Address 1:</b></td>
										<td><?php echo $myrow["receivable_address1"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Address 2:</b></td>
										<td><?php echo $myrow["receivable_address2"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>City:</b></td>
										<td><?php echo $myrow["receivable_city"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>State/Province:</b></td>
										<td><?php echo $myrow["receivable_state"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Zip Code:</b></td>
										<td><?php echo $myrow["receivable_zipcode"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Main Phone:</b></td>
										<td><?php echo $myrow["receivable_main_phone"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Direct Phone:</b></td>
										<td><?php echo $myrow["receivable_direct_phone"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Cell:</b></td>
										<td><?php echo $myrow["receivable_cell"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Email:</b></td>
										<td><?php echo $myrow["receivable_email"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Fax:</b></td>
										<td><?php echo $myrow["receivable_fax"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Portal Name:</b></td>
										<td><?php echo $myrow["receivable_portal_name"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Portal Link:</b></td>
										<td><?php echo $myrow["receivable_portal_link"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Notes:</b></td>
										<td><?php echo $myrow["receivable_notes"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Do We Get Invoiced:</b></td>
										<td><?php echo $myrow["do_we_get_invoiced"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Need Tonnage Report:</b></td>
										<td><?php echo $myrow["receivable_need_tonnage_report"]; ?></td>
									</tr>
									<tr>
									<td class="frmlabel"><b>Vendor Preferred Payment by:</b></td>
									<td>
										<?php echo $myrow["vendor_accept_payment_method"]; ?>
										<?php
if ($myrow["vendor_accept_payment_method"] == "Credit Card: via vendor website" || $myrow["vendor_accept_payment_method"] == "ePayment/EFT: via vendor site") {
                            ?>
									</td>
									</tr>
										<td colspan="2" style="padding:0px">
											<table border="0" width="100%">
													<tr>
														<td class="frmlabel" width="50%"><b>Website Link for Invoice Payment:</b></td>
														<td width="50%">
															<?php echo $myrow["websitelink_invoice_payment"]; ?>
														</td>
													</tr>
													<tr>
														<td class="frmlabel"><b>User Login:</b></td>
														<td>
															<?php echo $myrow["website_username"]; ?>
														</td>
													</tr>
													<tr>
														<td class="frmlabel"><b>Password for Login:</b></td>
														<td>
															<?php echo $myrow["website_password"]; ?>
														</td>
													</tr>
													<tr>
														<td class="frmlabel"><b>Customer Number or Account ID Number:</b></td>
														<td>
															<?php echo $myrow["website_cust_acct_number"]; ?>
														</td>
													</tr>
													<tr>
														<td class="frmlabel"><b>Credit Card Auto-Pay setup (Yes or No):</b></td>
														<td>
															<?php echo $myrow["creditcard_autopay_setup"]; ?>
														</td>
													</tr>
													<tr>
														<td class="frmlabel"><b>Credit Card on Auto-Payment:</b></td>
														<td>
															<?php echo $myrow["creditcard_autopayment"]; ?>
														</td>
													</tr>
											</table>
										</td>
										<?php
}?>

									<tr>
										<td class="frmlabel"><b>Vendor Payment Terms Given to UCBZeroWaste:</b></td>
										<td><?php echo $myrow["receivable_payment_terms_given_by_ucbzerowaste"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor A/R Client Contact Name:</b></td>
										<td><?php echo $myrow["receivable_client_contact_name"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor A/R Client Contact Phone:</b></td>
										<td><?php echo $myrow["receivable_client_contact_phone"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor A/R Client Contact Email:</b></td>
										<td><?php echo $myrow["receivable_client_contact_email"]; ?></td>
									</tr>
								</tbody>
							</table>
					<?php
$receivable_contacts_count++;
                    }
                }
                ?>
					<div>
					<form id="vendor_receivable_form" style="display:none" method="post" action="<?php echo $thispage; ?>?id=<?php echo $_REQUEST["id"]; ?>&proc=ADD_RECEIVABLE_CONTACT&pgname=<?php echo $_REQUEST["pgname"]; ?>&compid=<?php echo $_REQUEST["compid"]; ?>&post=yes&<?php echo $pagevars; ?>&flag=yes" enctype="multipart/form-data" >
						<input type="hidden" name="water_vendor_id" value="<?php echo $id; ?>">
						<table class="vendor_receivable_form_table">
						<tr>
							<td colspan="2" class="inner_table_header">Vendor Receivable Contact Information
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Name:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_contact_name"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Title:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_title"/></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Address 1:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_address1" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Address 2:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_address2"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>City:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_city" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>State/Province:</b></td>
							<td>
								<select class="vendor_select" name="receivable_state">
									<option value=""></option>
								<?php
$sqlfrm = "SELECT * FROM state_master order by state ";
                db();
                $statearr = db_query($sqlfrm);
                foreach ($statearr as $row) {
                    echo '<option value="' . $row["state"] . '">' . $row["state"] . '</option>';
                }
                ?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Zip Code:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_zipcode" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Main Phone:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_main_phone" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Direct Phone:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_direct_phone"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Cell:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_cell"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Email:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_email"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Fax:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_fax" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Portal Name:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_portal_name" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Portal Link:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_portal_link" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Notes:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_notes" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Do We Get Invoiced:</b></td>
							<td>
								<select class="vendor_select" name="do_we_get_invoiced">
									<option value=""></option>
									<option value="Yes" >Yes</option>
									<option value="No">No</option>
								</select>
						</tr>
						<tr>
							<td class="frmlabel"><b>Need Tonnage Report:</b></td>
							<td>
								<select class="vendor_select" name="receivable_need_tonnage_report">
									<option value=""></option>
									<option value="Yes" >Yes</option>
									<option value="No">No</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor Preferred Payment by:</b></td>
							<td>
								<select onchange="show_invoice_vendor_website()" class="vendor_select" id="accept_payment_method" name="accept_payment_method">
									<option value="">Choose One -- </option>
									<option value="Credit Card: via vendor website">Credit Card: via vendor website</option>
									<option value="Credit Card: via form sent by email">Credit Card: via form sent by email</option>
									<option value="Credit Card: via phone call">Credit Card: via phone call</option>
									<option value="ePayment/EFT: via bill.com">ePayment/EFT: via bill.com</option>
									<option value="ePayment/EFT: via vendor site">ePayment/EFT: via vendor site</option>
									<option value="Check: via bill.com">Check: via bill.com</option>
								</select>
							</td>
							<td colspan="2">
							<tr>
								<td colspan="2">
								<table border="0" width="100%" id="invoice_rebate_report_invoice_one_options" style="padding:0px">
									<tr>
										<td class="frmlabel"><b>Website Link for Invoice Payment:</b></td>
										<td>
											<input class="vendor_input" type="text" name="website_link">
										</td>
									</tr>
									<tr>
										<td class="frmlabel"><b>User Login:</b></td>
										<td>
											<input class="vendor_input" type="text" name="website_userlogin" >
										</td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Password for Login:</b></td>
										<td>
											<input class="vendor_input" type="password" name="website_password" >
										</td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Customer Number or Account ID Number:</b></td>
										<td>
											<input class="vendor_input" type="text" name="website_accountid_number" >
										</td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Credit Card Auto-Pay setup (Yes or No):</b></td>
										<td>
											<select class="vendor_select" name="website_creditcard_autopay_setup">
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Credit Card on Auto-Payment:</b></td>
										<td>
											<select class="vendor_select" name="website_creditcard_autopay">
												<option value="Chase Visa-2391">Chase Visa-2391</option>
												<option value="Capital One Visa-3521">Capital One Visa-3521</option>
											</select>
										</td>
									</tr>
								</table>
								<table id="invoice_rebate_report_invoice_one_second">
									<td class="frmlabel"><b>Accepted Payment method details:</b></td>
									<td>
										<input onchange="checkfile(this.id)" id="accept_payment_method_file" class="vendor_input" type="file" name="accept_payment_method_file" accept="application/pdf">
									</td>
								</table>
								<table id="invoice_rebate_report_invoice_two">
									<td class="frmlabel"><b>Vendor Payment Method to UCB:</b></td>
									<td>
										<select class="vendor_select" id="vendor_payment_method_ucb" name="vendor_payment_method_ucb">
											<option value="">Choose One -- </option>
											<option value="ePayment/EFT: credit to Chase account">ePayment/EFT: credit to Chase account</option>
											<option value="Check: snail mailed to the UCB office">Check: snail mailed to the UCB office</option>
										</select>
									</td>
								</table>
								<table id="invoice_rebate_report_invoice_two_second">
									<td class="frmlabel"><b>Accepted Payment method details:</b></td>
									<td>
										<input onchange="checkfile(this.id)" id="accept_payment_method_ucb_file" class="vendor_input" type="file" name="accept_payment_method_ucb_file" accept="application/pdf">
									</td>
								</table>
								</td>
							</tr>
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor Payment Terms Given to UCBZeroWaste:</b></td>
							<td>
								<select class="vendor_select" name="receivable_payment_terms_given_by_ucbzerowaste">
									<option value=""></option>
									<option value="Yes" >On Receipt</option>
									<option value="Net10">Net10</option>
									<option value="Net15">Net15</option>
									<option value="Net30">Net30</option>
									<option value="Net45">Net45</option>
									<option value="Net60">Net60</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor A/R Client Contact Name:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_client_contact_name"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor A/R Client Contact Phone:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_client_contact_phone"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor A/R Client Contact Email:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_client_contact_email"></td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<button type="submit">Save</button>&nbsp;&nbsp;
								<button onclick="remove_currently_added_receivable_form()" type="button">Never Mind</button></td>
						</tr>
						</table>
					</form>
					</div>
					<button onclick="add_vendor_receivable_contact()"><?php echo tep_db_num_rows($vendor_receivable_contacts_sql) == 0 ? "Add Receivable Contact" : "Add Another Receivable Contact"; ?></button>
				</td>
				<td>
					<table class="vendor_payable_contact_main_tbl vendor_inner_table" id="vendor_payable_contact_main_tbl">
						<tr>
							<th colspan="2">Vendor Payable Contact</th>
						</tr>
					</table>
					<?php
                db();
                $vendor_payable_contacts_sql = db_query("SELECT * FROM water_vendors_payable_contact where water_vendor_id= $id order by id ASC");
                if (tep_db_num_rows($vendor_payable_contacts_sql) > 0) {
                    $payable_contacts_count = 1;
                    while ($myrow = array_shift($vendor_payable_contacts_sql)) {

                        ?>
							<table class="vendor_payable_contact_tbl contact_inner_table" width="100%">
								<thead>
								<tr class="inner_table_header">
									<td width="50%" align="left"><?php echo $myrow['payable_contact_name'] . ' (' . $myrow['payable_title'] . ')'; ?></td>
									<td width="50%" align="right">
										<a id="arrasc_<?php echo $myrow['id']; ?>" href="javascript:void(0);" onclick="show_payable_contact_detail_div(<?php echo $myrow['id']; ?>)"><img src="images/sort_asc.png" width="6px" height="11px"></a>
										<a id="arrdesc_<?php echo $myrow['id']; ?>" href="javascript:void(0);" onclick="show_payable_contact_detail_div(<?php echo $myrow['id']; ?>)" style="display: none;"><img src="images/sort_desc.png" width="6px" height="11px"></a>
									</td>
								</tr>
								</thead>
								<tbody id="pay_contact_detail_div_<?php echo $myrow['id']; ?>" style="display: <?php echo $payable_contacts_count == 1 ? "revert" : "none"; ?>">
									<tr>
										<td class="frmlabel" colspan="2" align="center">
										<a  href="javascript:edit_payable_contact(<?php echo $myrow['id']; ?>)">Edit</a>&nbsp;&nbsp;
										<a style="color:red" href="javascript:delete_payable_contact(<?php echo $myrow["id"] ?>)" >Delete</a>
										</td>
									</tr>
									<tr>
										<td class="frmlabel" ><b>Name:</b></td>
										<td><?php echo $myrow["payable_contact_name"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Title:</b></td>
										<td><?php echo $myrow["payable_title"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Address 1:</b></td>
										<td><?php echo $myrow["payable_address1"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Address 2:</b></td>
										<td><?php echo $myrow["payable_address2"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>City:</b></td>
										<td><?php echo $myrow["payable_city"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>State/Province:</b></td>
										<td><?php echo $myrow["payable_state"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Zip Code:</b></td>
										<td><?php echo $myrow["payable_zipcode"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Main Phone:</b></td>
										<td><?php echo $myrow["payable_main_phone"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Direct Phone:</b></td>
										<td><?php echo $myrow["payable_direct_phone"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Cell:</b></td>
										<td><?php echo $myrow["payable_cell"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Email:</b></td>
										<td><?php echo $myrow["payable_email"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Fax:</b></td>
										<td><?php echo $myrow["payable_fax"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Portal Name:</b></td>
										<td><?php echo $myrow["payable_portal_name"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Portal Link:</b></td>
										<td><?php echo $myrow["payable_portal_link"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Notes:</b></td>
										<td><?php echo $myrow["payable_notes"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Do We Get Rebate:</b></td>
										<td><?php echo $myrow["do_we_get_rebate"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Need Separate Invoice:</b></td>
										<td><?php echo $myrow["need_separate_invoice"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor Payment Terms Accepted by UCBZeroWaste:</b></td>
										<td><?php echo $myrow["payable_payment_terms_accepted_by_ucbzerowaste"]; ?></td>
									</tr>
									<tr id="">
										<td class="frmlabel"><b>Accepted Payment method details:</b></td>
										<td>
											<?php if (!empty($myrow["accept_payment_method_file"])) {?>
											<a href="vendor_payment_method_images/<?php echo $myrow["accept_payment_method_file"]; ?>" target="_blank">View</a>
											<?php }?>
										</td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor A/P Client Contact Name:</b></td>
										<td><?php echo $myrow["payable_client_contact_name"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor A/P Client Contact Phone:</b></td>
										<td><?php echo $myrow["payable_client_contact_phone"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor A/P Client Contact Email:</b></td>
										<td><?php echo $myrow["payable_client_contact_email"]; ?></td>
									</tr>
								</tbody>
							</table>
					<?php
					$payable_contacts_count++;
										}
									}
									?>
					<div>
					<form id="vendor_payable_form" style="display:none" method="post" action="<?php echo $thispage; ?>?id=<?php echo $_REQUEST["id"]; ?>&proc=ADD_PAYABLE_CONTACT&pgname=<?php echo $_REQUEST["pgname"]; ?>&compid=<?php echo $_REQUEST["compid"]; ?>&post=yes&<?php echo $pagevars; ?>&flag=yes" enctype="multipart/form-data" >
						<input type="hidden" name="water_vendor_id" value="<?php echo $id; ?>">
						<table class="vendor_payable_form_table">
						<tr>
							<td colspan="2" class="inner_table_header">Vendor Payable Contact Information
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Name:</b></td>
							<td><input class="vendor_input" type="text" name="payable_contact_name"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Title:</b></td>
							<td><input class="vendor_input" type="text" name="payable_title"/></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Address 1:</b></td>
							<td><input class="vendor_input" type="text" name="payable_address1" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Address 2:</b></td>
							<td><input class="vendor_input" type="text" name="payable_address2"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>City:</b></td>
							<td><input class="vendor_input" type="text" name="payable_city" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>State/Province:</b></td>
							<td>
								<select class="vendor_select" name="payable_state">
									<option value=""></option>
								<?php
					$sqlfrm = "SELECT * FROM state_master order by state ";
									db();
									$statearr = db_query($sqlfrm);
									foreach ($statearr as $row) {
										echo '<option value="' . $row["state"] . '">' . $row["state"] . '</option>';
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Zip Code:</b></td>
							<td><input class="vendor_input" type="text" name="payable_zipcode" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Main Phone:</b></td>
							<td><input class="vendor_input" type="text" name="payable_main_phone" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Direct Phone:</b></td>
							<td><input class="vendor_input" type="text" name="payable_direct_phone"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Cell:</b></td>
							<td><input class="vendor_input" type="text" name="payable_cell"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Email:</b></td>
							<td><input class="vendor_input" type="text" name="payable_email"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Fax:</b></td>
							<td><input class="vendor_input" type="text" name="payable_fax" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Portal Name:</b></td>
							<td><input class="vendor_input" type="text" name="payable_portal_name" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Portal Link:</b></td>
							<td><input class="vendor_input" type="text" name="payable_portal_link" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Notes:</b></td>
							<td><input class="vendor_input" type="text" name="payable_notes" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Do We Get Rebate:</b></td>
							<td>
								<select class="vendor_select" name="do_we_get_rebate">
									<option value=""></option>
									<option value="Yes" >Yes</option>
									<option value="No">No</option>
								</select>
						</tr>
						<tr>
							<td class="frmlabel"><b>Need Separate Invoice:</b></td>
							<td>
								<select class="vendor_select" name="need_separate_invoice">
									<option value=""></option>
									<option value="Yes" >Yes</option>
									<option value="No">No</option>
								</select>
							</td>
						</tr>
						<tr id="">
							<td class="frmlabel"><b>Vendor Payment Terms Accepted by UCBZeroWaste:</b></td>
							<td>
								<select class="vendor_select" id="payable_payment_terms_accepted_by_ucbzerowaste" name="payable_payment_terms_accepted_by_ucbzerowaste">
									<option value="">Choose One -- </option>
									<option value="ePayment/EFT: credit to Chase account">ePayment/EFT: credit to Chase account</option>
									<option value="Check: snail mailed to the UCB office">Check: snail mailed to the UCB office</option>
								</select>
							</td>
						</tr>
						<tr id="">
							<td class="frmlabel"><b>Accepted Payment method details:</b></td>
							<td>
								<input onchange="checkfile(this.id)" id="accept_payment_method_ucb_file" class="vendor_input" type="file" name="accept_payment_method_file" accept="application/pdf">
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor A/P Client Contact Name:</b></td>
							<td><input class="vendor_input" type="text" name="payable_client_contact_name"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor A/P Client Contact Phone:</b></td>
							<td><input class="vendor_input" type="text" name="payable_client_contact_phone"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor A/P Client Contact Email:</b></td>
							<td><input class="vendor_input" type="text" name="payable_client_contact_email"></td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<button type="submit">Save</button>&nbsp;&nbsp;
								<button onclick="remove_currently_added_payable_form()" type="button">Never Mind</button></td>
						</tr>
						</table>
					</form>
					</div>
					<button onclick="add_vendor_payable_contact()"><?php echo tep_db_num_rows($vendor_payable_contacts_sql) == 0 ? "Add Payable Contact" : "Add Another Payable Contact"; ?></button>
				</td>
				</tr>
			</table>

								<?php
						} while ($myrow = array_shift($result));
								} // if record found

							} // if form not posted ends here.

						} // $proc=edit ends here.

						if ($proc == "View") {
							if (isset($_REQUEST["id"])) {
								$id = $_REQUEST["id"];
							}

							if (isset($_REQUEST["showsavemg"])) {
								echo "<DIV ><a href='water_vendor_master_new.php?proc=New'>Continue Adding WATER Item</a></DIV><br>";
								if (isset($_REQUEST["compid"])) {
									echo "<DIV ><a href='water_vendor_master_new.php?posting=yes&compid=" . $_REQUEST["compid"] . "'>Go to Vendor Master</a></DIV>";
								} else {
									echo "<DIV ><a href='water_vendor_master_new.php?posting=yes'>Go to Vendor Master</a></DIV>";
								}
							}

							echo "<DIV CLASS='PAGE_STATUS'>View Record</DIV>";

							if (isset($_REQUEST["showsavemg"])) {
								echo "<DIV style='color:green;'>Your changes were successfully saved</DIV>";
							}

							$sql = "SELECT * FROM water_vendors WHERE (`id` = $id)  $addl_select_crit";
							db();
							$result = db_query($sql) or die("Error Retrieving Records (9993SQLGET)");
							$myrow = array_shift($result);
							//    Vew Record in table

							$comp_names = "";
							$new_sql = "SELECT loop_warehouse.b2bid, loop_warehouse.warehouse_name FROM water_transaction inner join water_vendors on water_transaction.vendor_id = water_vendors.id
								inner join loop_warehouse on loop_warehouse.id = water_transaction.company_id
								where water_vendors.id = '" . $id . "' group by water_transaction.company_id";
							db();
							$get_boxes_query = db_query($new_sql);
							while ($boxes = array_shift($get_boxes_query)) {
								$comp_names = $comp_names . "<a target='_blank' href='viewCompany-purchasing.php?ID=" . $boxes["b2bid"] . "&proc=View&searchcrit=&show=watertransactions&rec_type=Manufacturer'>" . get_nickname_val($boxes["warehouse_name"], $boxes["b2bid"]) . "</a>, ";
							}

							?>

								<table border='1' id="maintbl1" width="100%" class="vendors_master_database_table">
									<tr>
										<td>
										<table border='1' id="maintbl1" width="100%" class="vendors_master_database_table">
									<tr>
										<td>
											<table class="vendor_information_tbl vendor_inner_table">
												<tr>
													<th colspan="2">Vendor Information:</th>
												</tr>
												<tr class="inner_table_header">
													<td  align="center" colspan="2"><a href="water_vendor_master_new.php?id=<?php echo $_REQUEST["id"]; ?>&proc=Edit&">Edit</a></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Vendor Name:</b></td>
													<td><?php echo $myrow["Name"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Acct. Status:</b></td>
													<td>
											<?php
												if ($myrow["active_flg"] == 0) {
													echo "Do not use Vendor";
												}

												if ($myrow["active_flg"] == 1) {
													echo "Active Vendor";
												}

												if ($myrow["active_flg"] == 2) {
													echo "Known Vendor";
												}

											?>
													</td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Vendor Terms:</b></td>
													<td><?php echo $myrow["vendor_terms"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>For What Client:</b></td>
													<td><?php echo $comp_names; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Description:</b></td>
													<td><?php echo $myrow["description"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Materials Managed:</b></td>
													<td>
														<?php
													$new_sql = "Select material from water_vendor_materials_trans_data inner join water_vendor_materials on water_vendor_materials.id = water_vendor_materials_trans_data.water_vendor_materials_id
																						where water_vendor_id = '" . $myrow["id"] . "'";
														db();
														$get_boxes_query = db_query($new_sql);
														while ($boxes = array_shift($get_boxes_query)) {
															echo $boxes["material"] . "<br>";
														}
														?>
													</td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Transportation:</b></td>
													<td><?php echo $myrow["transportation"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Area of Business:</b></td>
													<td><?php echo str_replace("|", "<br>", $myrow["business_area"]); ?></td>
													</tr>
												<tr>
													<td class="frmlabel"><b>Sales Contact Name:</b></td>
													<td><?php echo $myrow["contact_name"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Title:</b></td>
													<td><?php echo $myrow["title"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Address 1:</b></td>
													<td><?php echo $myrow["full_address"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Address 2:</b></td>
													<td><?php echo $myrow["full_address2"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>City:</b></td>
													<td><?php echo $myrow["city"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>State/Province:</b></td>
													<td><?php echo $myrow["state"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Zip Code:</b></td>
													<td><?php echo $myrow["zipcode"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Main Phone:</b></td>
													<td><?php echo $myrow["PhoneNo"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Direct Phone:</b></td>
													<td><?php echo $myrow["directPhone"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Cell:</b></td>
													<td><?php echo $myrow["contact_phone"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Email:</b></td>
													<td><?php echo $myrow["contact_email"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Fax:</b></td>
													<td><?php echo $myrow["Fax"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>LinkedIn Profile:</b></td>
													<td><?php echo $myrow["linkedIn_profile"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Notes:</b></td>
													<td><?php echo $myrow["notes"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Billing Switch to UCBZeroWaste:</b></td>
													<td><?php echo $myrow["billingSwitchToZeroWaste"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Date of Billing Switch:</b></td>
													<td><?php echo date("m/d/Y", strtotime($myrow["date_of_bill_switch"])); ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Signed/Approved: Bill Switch Agreement:</b></td>
													<td><?php echo $myrow["signed_approved_bill_switch_agreement"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Copy of Agreement: (FYI to be attached)</b></td>
													<td><?php echo $myrow["vendor_aggrement_file"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Certificate of Insurance (COI) Status:</b></td>
													<td><?php echo $myrow["coi_expired_flg"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Attach Copy of COI:</b></td>
													<td>
														<?php
													if ($myrow["certificate_of_insurance"] != "") {
														echo $myrow["certificate_of_insurance"];

														?>
														<br>
														<a href="certificate_of_insurance_images/<?php echo $myrow["certificate_of_insurance"]; ?>" target="_blank">View</a><br>
													<?php
													}
														?>
													</td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Date COI Expires:</b></td>
													<td><?php echo date("m/d/Y", strtotime($myrow["certificate_of_insurance_expiry_dt"])); ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Vendor Onboarding Form:</b></td>
													<td>
														<?php
														if ($myrow["vendor_onboarding_form"] != "") {
																echo $myrow["vendor_onboarding_form"];
																echo '<br><a href="vendor_payment_method_images/' . $myrow["vendor_onboarding_form"] . '" target="_blank">View</a>';
															}
															?>
													</td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Vendor Audit Form: (For Hazardous Waste Vendors)</b></td>
													<td>
														<?php
												if ($myrow["vendor_audit_form"] != "") {
														echo $myrow["vendor_audit_form"];
														echo '<br><a href="vendor_payment_method_images/' . $myrow["vendor_audit_form"] . '" target="_blank">View</a>';
													}
													?>
													</td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Tax ID:</b></td>
													<td><?php echo $myrow['vendor_tax_id']; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Shipping & Freight Contact Name:</b></td>
													<td><?php echo $myrow["shipping_contact_name"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Shipping & Freight Contact Email:</b></td>
													<td><?php echo $myrow["shipping_contact_email"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Shipping & Freight Contact Phone:</b></td>
													<td><?php echo $myrow["shipping_contact_phone"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>General Notes:</b></td>
													<td><?php echo $myrow["general_notes"]; ?></td>
												</tr>
												<tr>
													<td class="frmlabel"><b>Vendor Logo:</b></td>
													<td>
														<?php
														$imgurl = "https://loops.usedcardboardboxes.com/";
															?>
														<img src="<?php echo $imgurl . "vendor_logo_images/" . $myrow["logo_image"]; ?>" name="logoimg" width="200px" height="200px">
													</td>
												</tr>
											</table>
										</td>
										<td>
											<table class="vendor_receivable_contact_main_tbl vendor_inner_table" id="vendor_receivable_contact_main_tbl">
												<tr>
													<th colspan="2">Vendor Receivable Contact</th>
												</tr>
											</table>
											<?php
											db();
												$vendor_receivable_contacts_sql = db_query("SELECT * FROM water_vendors_receivable_contact where water_vendor_id= $id order by id ASC");
												if (tep_db_num_rows($vendor_receivable_contacts_sql) > 0) {
													$receivable_contacts_count = 1;
													while ($myrow = array_shift($vendor_receivable_contacts_sql)) {

											?>
													<table class="vendor_receivable_contact_tbl contact_inner_table" width="100%">
														<thead>
														<tr class="inner_table_header">
															<td width="50%" align="left"><?php echo $myrow['receivable_contact_name'] . ' (' . $myrow['receivable_title'] . ')'; ?></td>
															<td width="50%" align="right">
																<a id="arrasc_<?php echo $myrow['id']; ?>" href="javascript:void(0);" onclick="show_receivale_contact_detail_div(<?php echo $myrow['id']; ?>)"><img src="images/sort_asc.png" width="6px" height="11px"></a>
																<a id="arrdesc_<?php echo $myrow['id']; ?>" href="javascript:void(0);" onclick="show_receivale_contact_detail_div(<?php echo $myrow['id']; ?>)" style="display: none;"><img src="images/sort_desc.png" width="6px" height="11px"></a>
															</td>
														</tr>
														</thead>
														<tbody id="rec_contact_detail_div_<?php echo $myrow['id']; ?>" style="display: <?php echo $receivable_contacts_count == 1 ? "revert" : "none"; ?>">
															<tr>
																<td class="frmlabel" colspan="2" align="center">
																<a  href="javascript:edit_receivable_contact(<?php echo $myrow['id']; ?>)">Edit</a>&nbsp;&nbsp;
																<a style="color:red" href="javascript:delete_receivable_contact(<?php echo $myrow["id"] ?>)" >Delete</a>
																</td>
															</tr>
															<tr>
																<td class="frmlabel" ><b>Name:</b></td>
																<td><?php echo $myrow["receivable_contact_name"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Title:</b></td>
																<td><?php echo $myrow["receivable_title"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Address 1:</b></td>
																<td><?php echo $myrow["receivable_address1"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Address 2:</b></td>
																<td><?php echo $myrow["receivable_address2"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>City:</b></td>
																<td><?php echo $myrow["receivable_city"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>State/Province:</b></td>
																<td><?php echo $myrow["receivable_state"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Zip Code:</b></td>
																<td><?php echo $myrow["receivable_zipcode"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Main Phone:</b></td>
																<td><?php echo $myrow["receivable_main_phone"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Direct Phone:</b></td>
																<td><?php echo $myrow["receivable_direct_phone"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Cell:</b></td>
																<td><?php echo $myrow["receivable_cell"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Email:</b></td>
																<td><?php echo $myrow["receivable_email"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Fax:</b></td>
																<td><?php echo $myrow["receivable_fax"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Portal Name:</b></td>
																<td><?php echo $myrow["receivable_portal_name"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Portal Link:</b></td>
																<td><?php echo $myrow["receivable_portal_link"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Notes:</b></td>
																<td><?php echo $myrow["receivable_notes"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Do We Get Invoiced:</b></td>
																<td><?php echo $myrow["do_we_get_invoiced"]; ?></td>
															</tr>
															<tr>
																<td class="frmlabel"><b>Need Tonnage Report:</b></td>
																<td><?php echo $myrow["receivable_need_tonnage_report"]; ?></td>
															</tr>
															<tr>
															<td class="frmlabel"><b>Vendor Preferred Payment by:</b></td>
															<td>
																<?php echo $myrow["vendor_accept_payment_method"]; ?>
																<?php
																if ($myrow["vendor_accept_payment_method"] == "Credit Card: via vendor website" || $myrow["vendor_accept_payment_method"] == "ePayment/EFT: via vendor site") {
																				?>
															</td>
															</tr>
																<td colspan="2" style="padding:0px">
																	<table border="0" width="100%">
																			<tr>
																				<td class="frmlabel" width="50%"><b>Website Link for Invoice Payment:</b></td>
																				<td width="50%">
																					<?php echo $myrow["websitelink_invoice_payment"]; ?>
																				</td>
																			</tr>
																			<tr>
																				<td class="frmlabel"><b>User Login:</b></td>
																				<td>
																					<?php echo $myrow["website_username"]; ?>
																				</td>
																			</tr>
																			<tr>
																				<td class="frmlabel"><b>Password for Login:</b></td>
																				<td>
																					<?php echo $myrow["website_password"]; ?>
																				</td>
																			</tr>
																			<tr>
																				<td class="frmlabel"><b>Customer Number or Account ID Number:</b></td>
																				<td>
																					<?php echo $myrow["website_cust_acct_number"]; ?>
																				</td>
																			</tr>
																			<tr>
																				<td class="frmlabel"><b>Credit Card Auto-Pay setup (Yes or No):</b></td>
																				<td>
																					<?php echo $myrow["creditcard_autopay_setup"]; ?>
																				</td>
																			</tr>
																			<tr>
																				<td class="frmlabel"><b>Credit Card on Auto-Payment:</b></td>
																				<td>
																					<?php echo $myrow["creditcard_autopayment"]; ?>
																				</td>
																			</tr>
																	</table>
																</td>
																<?php
						}?>

									<tr>
										<td class="frmlabel"><b>Vendor Payment Terms Given to UCBZeroWaste:</b></td>
										<td><?php echo $myrow["receivable_payment_terms_given_by_ucbzerowaste"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor A/R Client Contact Name:</b></td>
										<td><?php echo $myrow["receivable_client_contact_name"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor A/R Client Contact Phone:</b></td>
										<td><?php echo $myrow["receivable_client_contact_phone"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor A/R Client Contact Email:</b></td>
										<td><?php echo $myrow["receivable_client_contact_email"]; ?></td>
									</tr>
								</tbody>
							</table>
					<?php
					$receivable_contacts_count++;
							}
						}
						?>
					<div>
					<form id="vendor_receivable_form" style="display:none" method="post" action="<?php echo $thispage; ?>?id=<?php echo $_REQUEST["id"]; ?>&proc=ADD_RECEIVABLE_CONTACT&pgname=<?php echo $_REQUEST["pgname"]; ?>&compid=<?php echo $_REQUEST["compid"]; ?>&post=yes&<?php echo $pagevars; ?>&flag=yes" enctype="multipart/form-data" >
						<input type="hidden" name="water_vendor_id" value="<?php echo $id; ?>">
						<table class="vendor_receivable_form_table">
						<tr>
							<td colspan="2" class="inner_table_header">Vendor Receivable Contact Information
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Name:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_contact_name"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Title:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_title"/></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Address 1:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_address1" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Address 2:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_address2"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>City:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_city" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>State/Province:</b></td>
							<td>
								<select class="vendor_select" name="receivable_state">
									<option value=""></option>
								<?php
								$sqlfrm = "SELECT * FROM state_master order by state ";
									db();
									$statearr = db_query($sqlfrm);
									foreach ($statearr as $row) {
										echo '<option value="' . $row["state"] . '">' . $row["state"] . '</option>';
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Zip Code:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_zipcode" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Main Phone:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_main_phone" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Direct Phone:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_direct_phone"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Cell:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_cell"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Email:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_email"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Fax:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_fax" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Portal Name:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_portal_name" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Portal Link:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_portal_link" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Notes:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_notes" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Do We Get Invoiced:</b></td>
							<td>
								<select class="vendor_select" name="do_we_get_invoiced">
									<option value=""></option>
									<option value="Yes" >Yes</option>
									<option value="No">No</option>
								</select>
						</tr>
						<tr>
							<td class="frmlabel"><b>Need Tonnage Report:</b></td>
							<td>
								<select class="vendor_select" name="receivable_need_tonnage_report">
									<option value=""></option>
									<option value="Yes" >Yes</option>
									<option value="No">No</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor Preferred Payment by:</b></td>
							<td>
								<select onchange="show_invoice_vendor_website()" class="vendor_select" id="accept_payment_method" name="accept_payment_method">
									<option value="">Choose One -- </option>
									<option value="Credit Card: via vendor website">Credit Card: via vendor website</option>
									<option value="Credit Card: via form sent by email">Credit Card: via form sent by email</option>
									<option value="Credit Card: via phone call">Credit Card: via phone call</option>
									<option value="ePayment/EFT: via bill.com">ePayment/EFT: via bill.com</option>
									<option value="ePayment/EFT: via vendor site">ePayment/EFT: via vendor site</option>
									<option value="Check: via bill.com">Check: via bill.com</option>
								</select>
							</td>
							<td colspan="2">
							<tr>
								<td colspan="2">
								<table border="0" width="100%" id="invoice_rebate_report_invoice_one_options" style="padding:0px">
									<tr>
										<td class="frmlabel"><b>Website Link for Invoice Payment:</b></td>
										<td>
											<input class="vendor_input" type="text" name="website_link">
										</td>
									</tr>
									<tr>
										<td class="frmlabel"><b>User Login:</b></td>
										<td>
											<input class="vendor_input" type="text" name="website_userlogin" >
										</td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Password for Login:</b></td>
										<td>
											<input class="vendor_input" type="password" name="website_password" >
										</td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Customer Number or Account ID Number:</b></td>
										<td>
											<input class="vendor_input" type="text" name="website_accountid_number" >
										</td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Credit Card Auto-Pay setup (Yes or No):</b></td>
										<td>
											<select class="vendor_select" name="website_creditcard_autopay_setup">
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Credit Card on Auto-Payment:</b></td>
										<td>
											<select class="vendor_select" name="website_creditcard_autopay">
												<option value="Chase Visa-2391">Chase Visa-2391</option>
												<option value="Capital One Visa-3521">Capital One Visa-3521</option>
											</select>
										</td>
									</tr>
								</table>
								<table id="invoice_rebate_report_invoice_one_second">
									<td class="frmlabel"><b>Accepted Payment method details:</b></td>
									<td>
										<input onchange="checkfile(this.id)" id="accept_payment_method_file" class="vendor_input" type="file" name="accept_payment_method_file" accept="application/pdf">
									</td>
								</table>
								<table id="invoice_rebate_report_invoice_two">
									<td class="frmlabel"><b>Vendor Payment Method to UCB::</b></td>
									<td>
										<select class="vendor_select" id="vendor_payment_method_ucb" name="vendor_payment_method_ucb">
											<option value="">Choose One -- </option>
											<option value="ePayment/EFT: credit to Chase account">ePayment/EFT: credit to Chase account</option>
											<option value="Check: snail mailed to the UCB office">Check: snail mailed to the UCB office</option>
										</select>
									</td>
								</table>
								<table id="invoice_rebate_report_invoice_two_second">
									<td class="frmlabel"><b>Accepted Payment method details:</b></td>
									<td>
										<input onchange="checkfile(this.id)" id="accept_payment_method_ucb_file" class="vendor_input" type="file" name="accept_payment_method_ucb_file" accept="application/pdf">
									</td>
								</table>
								</td>
							</tr>
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor Payment Terms Given to UCBZeroWaste:</b></td>
							<td>
								<select class="vendor_select" name="receivable_payment_terms_given_by_ucbzerowaste">
									<option value=""></option>
									<option value="Yes" >On Receipt</option>
									<option value="Net10">Net10</option>
									<option value="Net15">Net15</option>
									<option value="Net30">Net30</option>
									<option value="Net45">Net45</option>
									<option value="Net60">Net60</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor A/R Client Contact Name:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_client_contact_name"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor A/R Client Contact Phone:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_client_contact_phone"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor A/R Client Contact Email:</b></td>
							<td><input class="vendor_input" type="text" name="receivable_client_contact_email"></td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<button type="submit">Save</button>&nbsp;&nbsp;
								<button onclick="remove_currently_added_receivable_form()" type="button">Never Mind</button></td>
						</tr>
						</table>
					</form>
					</div>
					<button onclick="add_vendor_receivable_contact()"><?php echo tep_db_num_rows($vendor_receivable_contacts_sql) == 0 ? "Add Receivable Contact" : "Add Another Receivable Contact"; ?></button>
				</td>
				<td>
					<table class="vendor_payable_contact_main_tbl vendor_inner_table" id="vendor_payable_contact_main_tbl">
						<tr>
							<th colspan="2">Vendor Payable Contact</th>
						</tr>
					</table>
					<?php
						db();
							$vendor_payable_contacts_sql = db_query("SELECT * FROM water_vendors_payable_contact where water_vendor_id= $id order by id ASC");
							if (tep_db_num_rows($vendor_payable_contacts_sql) > 0) {
								$payable_contacts_count = 1;
								while ($myrow = array_shift($vendor_payable_contacts_sql)) {

                    ?>
							<table class="vendor_payable_contact_tbl contact_inner_table" width="100%">
								<thead>
								<tr class="inner_table_header">
									<td width="50%" align="left"><?php echo $myrow['payable_contact_name'] . ' (' . $myrow['payable_title'] . ')'; ?></td>
									<td width="50%" align="right">
										<a id="arrasc_<?php echo $myrow['id']; ?>" href="javascript:void(0);" onclick="show_payable_contact_detail_div(<?php echo $myrow['id']; ?>)"><img src="images/sort_asc.png" width="6px" height="11px"></a>
										<a id="arrdesc_<?php echo $myrow['id']; ?>" href="javascript:void(0);" onclick="show_payable_contact_detail_div(<?php echo $myrow['id']; ?>)" style="display: none;"><img src="images/sort_desc.png" width="6px" height="11px"></a>
									</td>
								</tr>
								</thead>
								<tbody id="pay_contact_detail_div_<?php echo $myrow['id']; ?>" style="display: <?php echo $payable_contacts_count == 1 ? "revert" : "none"; ?>">
									<tr>
										<td class="frmlabel" colspan="2" align="center">
										<a  href="javascript:edit_payable_contact(<?php echo $myrow['id']; ?>)">Edit</a>&nbsp;&nbsp;
										<a style="color:red" href="javascript:delete_payable_contact(<?php echo $myrow["id"] ?>)" >Delete</a>
										</td>
									</tr>
									<tr>
										<td class="frmlabel" ><b>Name:</b></td>
										<td><?php echo $myrow["payable_contact_name"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Title:</b></td>
										<td><?php echo $myrow["payable_title"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Address 1:</b></td>
										<td><?php echo $myrow["payable_address1"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Address 2:</b></td>
										<td><?php echo $myrow["payable_address2"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>City:</b></td>
										<td><?php echo $myrow["payable_city"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>State/Province:</b></td>
										<td><?php echo $myrow["payable_state"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Zip Code:</b></td>
										<td><?php echo $myrow["payable_zipcode"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Main Phone:</b></td>
										<td><?php echo $myrow["payable_main_phone"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Direct Phone:</b></td>
										<td><?php echo $myrow["payable_direct_phone"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Cell:</b></td>
										<td><?php echo $myrow["payable_cell"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Email:</b></td>
										<td><?php echo $myrow["payable_email"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Fax:</b></td>
										<td><?php echo $myrow["payable_fax"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Portal Name:</b></td>
										<td><?php echo $myrow["payable_portal_name"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Portal Link:</b></td>
										<td><?php echo $myrow["payable_portal_link"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Notes:</b></td>
										<td><?php echo $myrow["payable_notes"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Do We Get Rebate:</b></td>
										<td><?php echo $myrow["do_we_get_rebate"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Need Separate Invoice:</b></td>
										<td><?php echo $myrow["need_separate_invoice"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor Payment Terms Accepted by UCBZeroWaste:</b></td>
										<td><?php echo $myrow["payable_payment_terms_accepted_by_ucbzerowaste"]; ?></td>
									</tr>
									<tr id="">
										<td class="frmlabel"><b>Accepted Payment method details:</b></td>
										<td>
											<?php if (!empty($myrow["accept_payment_method_file"])) {?>
											<a href="vendor_payment_method_images/<?php echo $myrow["accept_payment_method_file"]; ?>" target="_blank">View</a>
											<?php }?>
										</td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor A/P Client Contact Name:</b></td>
										<td><?php echo $myrow["payable_client_contact_name"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor A/P Client Contact Phone:</b></td>
										<td><?php echo $myrow["payable_client_contact_phone"]; ?></td>
									</tr>
									<tr>
										<td class="frmlabel"><b>Vendor A/P Client Contact Email:</b></td>
										<td><?php echo $myrow["payable_client_contact_email"]; ?></td>
									</tr>
								</tbody>
							</table>
					<?php
					$payable_contacts_count++;
							}
						}
						?>
					<div>
					<form id="vendor_payable_form" style="display:none" method="post" action="<?php echo $thispage; ?>?id=<?php echo $_REQUEST["id"]; ?>&proc=ADD_PAYABLE_CONTACT&pgname=<?php echo $_REQUEST["pgname"]; ?>&compid=<?php echo $_REQUEST["compid"]; ?>&post=yes&<?php echo $pagevars; ?>&flag=yes" enctype="multipart/form-data" >
						<input type="hidden" name="water_vendor_id" value="<?php echo $id; ?>">
						<table class="vendor_payable_form_table">
						<tr>
							<td colspan="2" class="inner_table_header">Vendor Payable Contact Information
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Name:</b></td>
							<td><input class="vendor_input" type="text" name="payable_contact_name"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Title:</b></td>
							<td><input class="vendor_input" type="text" name="payable_title"/></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Address 1:</b></td>
							<td><input class="vendor_input" type="text" name="payable_address1" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Address 2:</b></td>
							<td><input class="vendor_input" type="text" name="payable_address2"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>City:</b></td>
							<td><input class="vendor_input" type="text" name="payable_city" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>State/Province:</b></td>
							<td>
								<select class="vendor_select" name="payable_state">
									<option value=""></option>
								<?php
								$sqlfrm = "SELECT * FROM state_master order by state ";
									db();
									$statearr = db_query($sqlfrm);
									foreach ($statearr as $row) {
										echo '<option value="' . $row["state"] . '">' . $row["state"] . '</option>';
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Zip Code:</b></td>
							<td><input class="vendor_input" type="text" name="payable_zipcode" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Main Phone:</b></td>
							<td><input class="vendor_input" type="text" name="payable_main_phone" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Direct Phone:</b></td>
							<td><input class="vendor_input" type="text" name="payable_direct_phone"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Cell:</b></td>
							<td><input class="vendor_input" type="text" name="payable_cell"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Email:</b></td>
							<td><input class="vendor_input" type="text" name="payable_email"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Fax:</b></td>
							<td><input class="vendor_input" type="text" name="payable_fax" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Portal Name:</b></td>
							<td><input class="vendor_input" type="text" name="payable_portal_name" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Portal Link:</b></td>
							<td><input class="vendor_input" type="text" name="payable_portal_link" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Notes:</b></td>
							<td><input class="vendor_input" type="text" name="payable_notes" ></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Do We Get Rebate:</b></td>
							<td>
								<select class="vendor_select" name="do_we_get_rebate">
									<option value=""></option>
									<option value="Yes" >Yes</option>
									<option value="No">No</option>
								</select>
						</tr>
						<tr>
							<td class="frmlabel"><b>Need Separate Invoice:</b></td>
							<td>
								<select class="vendor_select" name="need_separate_invoice">
									<option value=""></option>
									<option value="Yes" >Yes</option>
									<option value="No">No</option>
								</select>
							</td>
						</tr>
						<tr id="">
							<td class="frmlabel"><b>Vendor Payment Terms Accepted by UCBZeroWaste:</b></td>
							<td>
								<select class="vendor_select" id="payable_payment_terms_accepted_by_ucbzerowaste" name="payable_payment_terms_accepted_by_ucbzerowaste">
									<option value="">Choose One -- </option>
									<option value="ePayment/EFT: credit to Chase account">ePayment/EFT: credit to Chase account</option>
									<option value="Check: snail mailed to the UCB office">Check: snail mailed to the UCB office</option>
								</select>
							</td>
						</tr>
						<tr id="">
							<td class="frmlabel"><b>Accepted Payment method details:</b></td>
							<td>
								<input onchange="checkfile(this.id)" id="accept_payment_method_ucb_file" class="vendor_input" type="file" name="accept_payment_method_file" accept="application/pdf">
							</td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor A/P Client Contact Name:</b></td>
							<td><input class="vendor_input" type="text" name="payable_client_contact_name"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor A/P Client Contact Phone:</b></td>
							<td><input class="vendor_input" type="text" name="payable_client_contact_phone"></td>
						</tr>
						<tr>
							<td class="frmlabel"><b>Vendor A/P Client Contact Email:</b></td>
							<td><input class="vendor_input" type="text" name="payable_client_contact_email"></td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<button type="submit">Save</button>&nbsp;&nbsp;
								<button onclick="remove_currently_added_payable_form()" type="button">Never Mind</button></td>
						</tr>
						</table>
					</form>
					</div>
					<button onclick="add_vendor_payable_contact()"><?php echo tep_db_num_rows($vendor_payable_contacts_sql) == 0 ? "Add Payable Contact" : "Add Another Payable Contact"; ?></button>
				</td>
			</tr>
		</table>
				</td>
			</tr>
		</table>


		<?php

} // if $proc == "View" closed here

if ($proc == "Delete") {
    if (isset($_REQUEST["id"])) {
        $id = $_REQUEST["id"];
    }

    ?>
		<DIV CLASS='PAGE_STATUS'>Deleting Record</DIV>
		<?php

    $rec_found = "no";
    $q1 = "SELECT vendor_id FROM water_transaction where vendor_id = " . $id;
    db();
    $query = db_query($q1);
    while ($fetch = array_shift($query)) {
        $rec_found = "yes";
    }

    if ($rec_found == "yes") {
        ?>
				<DIV CLASS='PAGE_OPTIONS'>
					 <strong>VENDOR Record cannot be Deleted, transaction record exit!</strong><BR><br>
					 <a href="<?php echo $thispage; ?>?posting=yes<?php echo $pagevars; ?>">No</a>
				</DIV>
			<?php
} else {
        if (!isset($_REQUEST["delete"])) {
            ?>
				<DIV CLASS='PAGE_OPTIONS'>
								<br><br>Are you sure you want to delete this Record? <br><br>
								 <strong>THIS CANNOT BE UNDONE!</strong><BR><br>

					 <a href="<?php echo $thispage; ?>?id=<?php echo $id; ?>&delete=yes&proc=Delete&<?php echo $pagevars; ?>">Yes</a>
					   <a href="<?php echo $thispage; ?>?posting=yes<?php echo $pagevars; ?>">No</a>
				</DIV>
			<?php
}
    } //IF !DELETE

    if ($_REQUEST["delete"] == "yes") {

        $sql = "DELETE FROM water_vendors WHERE id='$id' ";
        db();
        $result = db_query($sql);

        if (empty($result)) {
            echo "<DIV CLASS='SQL_RESULTS'>Successfully Deleted Water Vendor Record</DIV>";

            if (!headers_sent()) {
                header('Location: water_vendor_master_new.php?posting=yes&recdel=y');exit;
            } else {
                echo "<script type=\"text/javascript\">";
                echo "window.location.href=\"water_vendor_master_new.php?posting=yes&recdel=y\";";
                echo "</script>";
                echo "<noscript>";
                echo "<meta http-equiv=\"refresh\" content=\"0;url=water_vendor_master_new.php?posting=yes&recdel=y\" />";
                echo "</noscript>";exit;
            }

        } else {
            echo "Error Deleting Water Inventory.";
        }
    } //END IF $DELETE=YES
} // END IF PROC = "DELETE"

if ($proc == "inactive") {
    if (isset($_REQUEST["id"])) {
        $id = $_REQUEST["id"];
    }

    ?>
		<DIV CLASS='PAGE_STATUS'>Updating inactive flag </DIV>
		<?php

    if (!isset($_REQUEST["inactive"])) {
        ?>
			<DIV CLASS='PAGE_OPTIONS'>
							<br><br>Are you sure you want to inactive this Record? <br><br>
							 <strong>THIS CANNOT BE UNDONE!</strong><BR><br>

				 <a href="<?php echo $thispage; ?>?id=<?php echo $id; ?>&inactive=yes&proc=inactive&<?php echo $pagevars; ?>">Yes</a>
				 <a href="<?php echo $thispage; ?>?posting=yes<?php echo $pagevars; ?>">No</a>
			</DIV>
		<?php
} //IF !update
    if ($_REQUEST["inactive"] == "yes") {

        $sql = "update water_vendors set active_flg = 0 WHERE id='$id' ";
        db();
        $result = db_query($sql);
        if (empty($result)) {
            echo "<DIV CLASS='SQL_RESULTS'>Successfully update inactive flag.</DIV>";

            if (!headers_sent()) {
                header('Location: water_vendor_master_new.php?posting=yes&recinactive=y');exit;
            } else {
                echo "<script type=\"text/javascript\">";
                echo "window.location.href=\"water_vendor_master_new.php?posting=yes\";";
                echo "</script>";
                echo "<noscript>";
                echo "<meta http-equiv=\"refresh\" content=\"0;url=water_vendor_master_new.php?posting=yes&recinactive=y\" />";
                echo "</noscript>";exit;
            }

        } else {
            echo "Error update Record from Water Inventory.";
        }
    }
} // if $proc == "inactive" closed here

if ($proc == "active") {
    if (isset($_REQUEST["id"])) {
        $id = $_REQUEST["id"];
    }

    ?>
		<DIV CLASS='PAGE_STATUS'>Updating active flag </DIV>
		<?php

    if (!isset($_REQUEST["active"])) {
        ?>
			<DIV CLASS='PAGE_OPTIONS'>
							<br><br>Are you sure you want to active this Record? <br><br>
							 <strong>THIS CANNOT BE UNDONE!</strong><BR><br>

				 <a href="<?php echo $thispage; ?>?id=<?php echo $id; ?>&active=yes&proc=active&<?php echo $pagevars; ?>">Yes</a>
				 <a href="<?php echo $thispage; ?>?posting=yes<?php echo $pagevars; ?>">No</a>
			</DIV>
		<?php
	} //IF !update
		if ($_REQUEST["active"] == "yes") {

			$sql = "update water_vendors set active_flg = 1 WHERE id='$id' ";
			db();
			$result = db_query($sql);
			if (empty($result)) {
				echo "<DIV CLASS='SQL_RESULTS'>Successfully update active flag.</DIV>";

				if (!headers_sent()) {
					header('Location: water_vendor_master_new.php?posting=yes&recinactive=y');exit;
				} else {
					echo "<script type=\"text/javascript\">";
					echo "window.location.href=\"water_vendor_master_new.php?posting=yes\";";
					echo "</script>";
					echo "<noscript>";
					echo "<meta http-equiv=\"refresh\" content=\"0;url=water_vendor_master_new.php?posting=yes&recinactive=y\" />";
					echo "</noscript>";exit;
				}

			} else {
				echo "Error update Record from Water Inventory.";
			}
		}
	} // if $proc ==

	?>
	<br>
</div>

	<script>
		function add_vendor_receivable_contact(){
			document.getElementById('vendor_receivable_form').style.display="revert";
		}
		function remove_currently_added_receivable_form(){
			document.getElementById('vendor_receivable_form').style.display="none";
		}
		function show_receivale_contact_detail_div(recid, actmode){
			var e = document.getElementById('rec_contact_detail_div_' + recid ).style.display;
			if(e == 'none'){
				document.getElementById('rec_contact_detail_div_'+ recid).style.display = "revert";
				document.getElementById('arrasc_'+ recid).style.display = "none";
				document.getElementById('arrdesc_'+ recid).style.display = "block";
			}else{
				document.getElementById('rec_contact_detail_div_'+ recid).style.display = "none";
				document.getElementById('arrasc_'+ recid).style.display = "block";
				document.getElementById('arrdesc_'+ recid).style.display = "none";
			}
		}
		function delete_receivable_contact(id){
			var conf=confirm("Do u sure want to delete receivable contact?");
			if(conf==true){
				window.location.href="<?php echo $thispage; ?>?id=<?php echo $_REQUEST["id"]; ?>&proc=DELETE_RECEIVABLE_CONTACT&pgname=<?php echo $_REQUEST["pgname"]; ?>&compid=<?php echo $_REQUEST["compid"]; ?>&post=yes&<?php echo $pagevars; ?>&flag=yes&contact_id="+id;
			}
		}
		var data_before_edit_vendor_contact="";
		function edit_receivable_contact(id){
			data_before_edit_vendor_contact=document.getElementById('rec_contact_detail_div_'+id).innerHTML;
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
					//console.log(xmlhttp.responseText);
					var data=JSON.parse(xmlhttp.responseText);
					var edit_form='<tr><td colspan="2"> <form method="post" action="<?php echo $thispage; ?>?id=<?php echo $_REQUEST["id"]; ?>&proc=EDIT_RECEIVABLE_CONTACT&pgname=<?php echo $_REQUEST["pgname"]; ?>&compid=<?php echo $_REQUEST["compid"]; ?>&post=yes&<?php echo $pagevars; ?>&flag=yes" enctype="multipart/form-data">';
						edit_form+='<input type="hidden" name="water_vendor_id" value="<?php echo $id; ?>">';
						edit_form+='<input type="hidden" name="vendor_contact_id" value="'+id+'">';

						edit_form+='<table class="vendor_receivable_form_table">';
						edit_form+='<tr><td colspan="2" class="inner_table_header">Edit Vendor Receivable Contact Information</td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Name:</b></td><td><input class="vendor_input" type="text" name="receivable_contact_name" value="'+data.receivable_contact_name+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Title:</b></td><td><input class="vendor_input" type="text" name="receivable_title" value="'+data.receivable_title+'"/></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Address 1:</b></td><td><input class="vendor_input" type="text" name="receivable_address1" value="'+data.receivable_address1+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Address 2:</b></td><td><input class="vendor_input" type="text" name="receivable_address2" value="'+data.receivable_address2+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>City:</b></td><td><input class="vendor_input" type="text" name="receivable_city" value="'+data.receivable_city+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>State/Province:</b></td><td>';
						edit_form+='<select class="vendor_select" name="receivable_state">';
						edit_form+='<option value=""></option>';
						var state_data=data.state_data;
						for(var i=0; i<state_data.length;i++){
							var selected_data= state_data[i]== data.receivable_state ? " selected" : "";
							edit_form+='<option '+selected_data+' value="'+state_data[i]+'">'+state_data[i]+'</option>';
						}
						edit_form+='</select></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Zip Code:</b></td><td><input class="vendor_input" type="text" name="receivable_zipcode" value="'+data.receivable_zipcode+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Main Phone:</b></td><td><input class="vendor_input" type="text" name="receivable_main_phone" value="'+data.receivable_main_phone+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Direct Phone:</b></td><td><input class="vendor_input" type="text" name="receivable_direct_phone" value="'+data.receivable_direct_phone+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Cell:</b></td><td><input class="vendor_input" type="text" name="receivable_cell" value="'+data.receivable_cell+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Email:</b></td><td><input class="vendor_input" type="text" name="receivable_email" value="'+data.receivable_email+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Fax:</b></td><td><input class="vendor_input" type="text" name="receivable_fax" value="'+data.receivable_fax+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Portal Name:</b></td><td><input class="vendor_input" type="text" name="receivable_portal_name" value="'+data.receivable_portal_name+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Portal Link:</b></td><td><input class="vendor_input" type="text" name="receivable_portal_link" value="'+data.receivable_portal_link+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Notes:</b></td><td><input class="vendor_input" type="text" name="receivable_notes" value="'+data.receivable_notes+'"></td></tr>';

						edit_form+='<tr><td class="frmlabel"><b>Do We Get Invoiced:</b></td><td><select class="vendor_select" name="do_we_get_invoiced">';
						edit_form+='<option value=""></option>';
						edit_form+='<option value="Yes" ';
						edit_form+=data.do_we_get_invoiced=="Yes" ? " selected " : "";
						edit_form+='>Yes</option>';
						edit_form+='<option value="No" ';
						edit_form+=data.do_we_get_invoiced=="No" ? " selected " : "";
						edit_form+='>No</option>';
						edit_form+='</select></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Need Tonnage Report:</b></td><td><select class="vendor_select" name="receivable_need_tonnage_report">';
						edit_form+='<option value=""></option>';
						edit_form+='<option value="Yes" ';
						edit_form+= data.receivable_need_tonnage_report=="Yes" ? " selected " : "";
						edit_form+='>Yes</option>';
						edit_form+='<option value="No" ';
						edit_form+= data.receivable_need_tonnage_report=="No" ? " selected " : "";
						edit_form+='>No</option>';
						edit_form+='</select></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Vendor Preferred Payment by:</b></td>';
						edit_form+='<td><select onchange="show_invoice_vendor_website2()" class="vendor_select" id="accept_payment_method2" name="accept_payment_method">';
						edit_form+='<option value="">Choose One -- </option>';
						edit_form+='<option ';
						edit_form+=data.vendor_accept_payment_method=="Credit Card: via vendor website" ? 'selected' : '' ;
						edit_form+=' value="Credit Card: via vendor website">Credit Card: via vendor website</option>';
						edit_form+='<option ';
						edit_form+=data.vendor_accept_payment_method=="Credit Card: via form sent by email" ? 'selected' : '' ;
						edit_form+=' value="Credit Card: via form sent by email">Credit Card: via form sent by email</option>';
						edit_form+='<option ';
						edit_form+=data.vendor_accept_payment_method=="Credit Card: via phone call" ? 'selected' : '' ;
						edit_form+=' value="Credit Card: via phone call">Credit Card: via phone call</option>';
						edit_form+='<option ';
						edit_form+=data.vendor_accept_payment_method=="ePayment/EFT: via bill.com" ? 'selected' : '' ;
						edit_form+=' value="ePayment/EFT: via bill.com">ePayment/EFT: via bill.com</option>';
						edit_form+='<option ';
						edit_form+=data.vendor_accept_payment_method=="ePayment/EFT: via vendor site" ? 'selected' : '' ;
						edit_form+=' value="ePayment/EFT: via vendor site"> ePayment/EFT: via vendor site</option>';
						edit_form+='<option ';
						edit_form+=data.vendor_accept_payment_method=="Check: via bill.com" ? 'selected' : '' ;
						edit_form+=' value="Check: via bill.com">Check: via bill.com</option>';
						edit_form+='</select></td>';
						edit_form+='<td colspan="2"><tr><td colspan="2">';
						edit_form+='<table border="0" width="100%" id="invoice_rebate_report_invoice_one_options2" style="padding:0px"> ';
						edit_form+='<tr><td class="frmlabel"><b>Website Link for Invoice Payment:</b></td><td><input class="vendor_input" type="text" name="website_link" value="'+data.websitelink_invoice_payment+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>User Login:</b></td><td><input class="vendor_input" type="text" name="website_userlogin" value="'+data.website_username+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Password for Login:</b></td><td><input class="vendor_input" type="password" name="website_password" value="'+data.website_password+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Customer Number or Account ID Number:</b></td><td><input class="vendor_input" type="text" name="website_accountid_number" value="'+data.website_cust_acct_number+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Credit Card Auto-Pay setup (Yes or No):</b></td>';
						edit_form+='<td><select class="vendor_select" name="website_creditcard_autopay_setup">';
						edit_form+='<option value="Yes"';
						edit_form+=data.creditcard_autopay_setup=="Yes"? " selected ":"";
						edit_form+='>Yes</option>';
						edit_form+='<option value="No"';
						edit_form+=data.creditcard_autopay_setup=="No"? " selected ":"";
						edit_form+='>No</option>';
						edit_form+='</select></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Credit Card on Auto-Payment:</b></td>';
						edit_form+='<td><select class="vendor_select" name="website_creditcard_autopay">'
						edit_form+='<option value="Chase Visa-2391"';
						edit_form+=data.creditcard_autopayment=="Chase Visa-2391" ? " selected ":"";
						edit_form+='>Chase Visa-2391</option>';
						edit_form+='<option value="Capital One Visa-3521"';
						edit_form+=data.creditcard_autopayment=="Capital One Visa-3521" ? " selected ":"";
						edit_form+='>Capital One Visa-3521</option>';
						edit_form+='</select></td></tr>';
						edit_form+='</table>';
						
						edit_form+='</td></tr></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Vendor Payment Terms Given to UCBZeroWaste:</b></td><td>';
						edit_form+='<select class="vendor_select" name="receivable_payment_terms_given_by_ucbzerowaste">';
						edit_form+='<option value=""></option>';
						edit_form+='<option value="On Receipt" ';
						edit_form+=data.receivable_payment_terms_given_by_ucbzerowaste=="On Receipt"? " selected":"";
						edit_form+='>On Receipt</option>';
						edit_form+='<option value="Net10" ';
						edit_form+=data.receivable_payment_terms_given_by_ucbzerowaste=="Net10"? " selected ":"";
						edit_form+='>Net10</option>';
						edit_form+='<option value="Net15" ';
						edit_form+=data.receivable_payment_terms_given_by_ucbzerowaste=="Net15"? " selected ":"";
						edit_form+='>Net15</option>';
						edit_form+='<option value="Net30" ';
						edit_form+=data.receivable_payment_terms_given_by_ucbzerowaste=="Net30"? " selected ":"";
						edit_form+='>Net30</option>';
						edit_form+='<option value="Net45" ';
						edit_form+=data.receivable_payment_terms_given_by_ucbzerowaste=="Net45"? " selected ":"";
						edit_form+='>Net45</option>';
						edit_form+='<option value="Net60" ';
						edit_form+=data.receivable_payment_terms_given_by_ucbzerowaste=="Net60"? " selected ":"";
						edit_form+='>Net60</option>';
						edit_form+='</select>';
						edit_form+='</td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Vendor A/R Client Contact Name:</b></td><td><input class="vendor_input" type="text" name="receivable_client_contact_name" value="'+data.receivable_client_contact_name+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Vendor A/R Client Contact Phone:</b></td><td><input class="vendor_input" type="text" name="receivable_client_contact_phone" value="'+data.receivable_client_contact_phone+'"></td></tr>';
						edit_form+='<tr><td class="frmlabel"><b>Vendor A/R Client Contact Email:</b></td><td><input class="vendor_input" type="text" name="receivable_client_contact_email" value="'+data.receivable_client_contact_email+'"></td></tr>';
						edit_form+='<tr><td colspan="2" align="center"><button type="submit">Save</button>&nbsp;&nbsp;<button onclick="remove_receivable_contact_form('+id+')" type="button">Never Mind</button></td></tr>';
						edit_form+='</table>';
						edit_form+='</form></td></tr>';
						document.getElementById('rec_contact_detail_div_'+id).innerHTML=edit_form;
						show_invoice_vendor_website2();
				}
				}

				xmlhttp.open("GET","get_vendor_data_for_edit.php?EDIT_RECEIVABLE_CONTACT=1&contact_id="+id,true);
				xmlhttp.send();

			}
			function remove_receivable_contact_form(id){
				document.getElementById('rec_contact_detail_div_'+id).innerHTML=data_before_edit_vendor_contact;
			}

			function show_invoice_vendor_website2(){
				var e = document.getElementById("accept_payment_method2");
				var selectedvalue = e.options[e.selectedIndex].value;
				if( (selectedvalue === "Credit Card: via vendor website") || (selectedvalue === "ePayment/EFT: via vendor site")){
					document.getElementById("invoice_rebate_report_invoice_one_options2").style.display = "revert";
				}else{
					document.getElementById("invoice_rebate_report_invoice_one_options2").style.display = "none";
				}
			}

			function add_vendor_payable_contact(){
				document.getElementById('vendor_payable_form').style.display="revert";
			}
			function remove_currently_added_payable_form(){
				document.getElementById('vendor_payable_form').style.display="none";
			}
			function show_payable_contact_detail_div(recid, actmode){
				var e = document.getElementById('pay_contact_detail_div_' + recid ).style.display;
				if(e == 'none'){
					document.getElementById('pay_contact_detail_div_'+ recid).style.display = "revert";
					document.getElementById('arrasc_'+ recid).style.display = "none";
					document.getElementById('arrdesc_'+ recid).style.display = "block";
				}else{
					document.getElementById('pay_contact_detail_div_'+ recid).style.display = "none";
					document.getElementById('arrasc_'+ recid).style.display = "block";
					document.getElementById('arrdesc_'+ recid).style.display = "none";
				}
			}
			function delete_payable_contact(id){
				var conf=confirm("Do u sure want to delete payable contact?");
				if(conf==true){
					window.location.href="<?php echo $thispage; ?>?id=<?php echo $_REQUEST["id"]; ?>&proc=DELETE_PAYABLE_CONTACT&pgname=<?php echo $_REQUEST["pgname"]; ?>&compid=<?php echo $_REQUEST["compid"]; ?>&post=yes&<?php echo $pagevars; ?>&flag=yes&contact_id="+id;
				}
			}
		var data_before_edit_vendor_pay_contact="";
		function edit_payable_contact(id){
		data_before_edit_vendor_pay_contact=document.getElementById('pay_contact_detail_div_'+id).innerHTML;
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
				var data=JSON.parse(xmlhttp.responseText);
				var edit_form='<tr><td colspan="2"> <form method="post" action="<?php echo $thispage; ?>?id=<?php echo $_REQUEST["id"]; ?>&proc=EDIT_PAYABLE_CONTACT&pgname=<?php echo $_REQUEST["pgname"]; ?>&compid=<?php echo $_REQUEST["compid"]; ?>&post=yes&<?php echo $pagevars; ?>&flag=yes" enctype="multipart/form-data">';
					edit_form+='<input type="hidden" name="water_vendor_id" value="<?php echo $id; ?>">';
					edit_form+='<input type="hidden" name="vendor_contact_id" value="'+id+'">';

					edit_form+='<table class="vendor_payable_form_table">';
					edit_form+='<tr><td colspan="2" class="inner_table_header">Edit Vendor Payable Contact Information</td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Name:</b></td><td><input class="vendor_input" type="text" name="payable_contact_name" value="'+data.payable_contact_name+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Title:</b></td><td><input class="vendor_input" type="text" name="payable_title" value="'+data.payable_title+'"/></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Address 1:</b></td><td><input class="vendor_input" type="text" name="payable_address1" value="'+data.payable_address1+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Address 2:</b></td><td><input class="vendor_input" type="text" name="payable_address2" value="'+data.payable_address2+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>City:</b></td><td><input class="vendor_input" type="text" name="payable_city" value="'+data.payable_city+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>State/Province:</b></td><td>';
					edit_form+='<select class="vendor_select" name="payable_state">';
					edit_form+='<option value=""></option>';
					var state_data=data.state_data;
					for(var i=0; i<state_data.length;i++){
						var selected_data= state_data[i]== data.payable_state ? " selected" : "";
						edit_form+='<option '+selected_data+' value="'+state_data[i]+'">'+state_data[i]+'</option>';
					}
					edit_form+='</select></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Zip Code:</b></td><td><input class="vendor_input" type="text" name="payable_zipcode" value="'+data.payable_zipcode+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Main Phone:</b></td><td><input class="vendor_input" type="text" name="payable_main_phone" value="'+data.payable_main_phone+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Direct Phone:</b></td><td><input class="vendor_input" type="text" name="payable_direct_phone" value="'+data.payable_direct_phone+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Cell:</b></td><td><input class="vendor_input" type="text" name="payable_cell" value="'+data.payable_cell+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Email:</b></td><td><input class="vendor_input" type="text" name="payable_email" value="'+data.payable_email+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Fax:</b></td><td><input class="vendor_input" type="text" name="payable_fax" value="'+data.payable_fax+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Portal Name:</b></td><td><input class="vendor_input" type="text" name="payable_portal_name" value="'+data.payable_portal_name+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Portal Link:</b></td><td><input class="vendor_input" type="text" name="payable_portal_link" value="'+data.payable_portal_link+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Notes:</b></td><td><input class="vendor_input" type="text" name="payable_notes" value="'+data.payable_notes+'"></td></tr>';

					edit_form+='<tr><td class="frmlabel"><b>Do We Get Rebate:</b></td><td><select class="vendor_select" name="do_we_get_rebate">';
					edit_form+='<option value=""></option>';
					edit_form+='<option value="Yes" ';
					edit_form+=data.do_we_get_rebate=="Yes" ? " selected " : "";
					edit_form+='>Yes</option>';
					edit_form+='<option value="No" ';
					edit_form+=data.do_we_get_rebate=="No" ? " selected " : "";
					edit_form+='>No</option>';
					edit_form+='</select></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Need Separate Invoice:</b></td><td><select class="vendor_select" name="need_separate_invoice">';
					edit_form+='<option value=""></option>';
					edit_form+='<option value="Yes" ';
					edit_form+= data.need_separate_invoice=="Yes" ? " selected " : "";
					edit_form+='>Yes</option>';
					edit_form+='<option value="No" ';
					edit_form+= data.need_separate_invoice=="No" ? " selected " : "";
					edit_form+='>No</option>';
					edit_form+='</select></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Vendor Payment Terms Accepted by UCBZeroWaste:</b></td><td>';
					edit_form+='<select class="vendor_select" name="payable_payment_terms_accepted_by_ucbzerowaste">';
					edit_form+='<option value="ePayment/EFT: credit to Chase account" ';
					edit_form+=data.payable_payment_terms_accepted_by_ucbzerowaste=="ePayment/EFT: credit to Chase account"? " selected":"";
					edit_form+='>ePayment/EFT: credit to Chase account</option>';
					edit_form+='<option value="Check: snail mailed to the UCB office" ';
					edit_form+=data.payable_payment_terms_accepted_by_ucbzerowaste=="Check: snail mailed to the UCB office"? " selected ":"";
					edit_form+='>Check: snail mailed to the UCB office</option>';
					edit_form+='</select>';
					edit_form+='</td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Accepted Payment method details:</b></td>';
					edit_form+='<td>';
					if (data.accept_payment_method_file!=""){
						edit_form+='<a href="vendor_payment_method_images/'+data.accept_payment_method_file+'" target="_blank">View</a><br>';
					}
					edit_form+='<input onchange="checkfile(this.id)" id="accept_payment_method_file_edit" class="vendor_input" type="file" name="accept_payment_method_file" accept="application/pdf">';
					edit_form+='<input type="hidden" name="old_accept_payment_method_file" value="'+data.accept_payment_method_file+'"/></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Vendor A/P Client Contact Name:</b></td><td><input class="vendor_input" type="text" name="payable_client_contact_name" value="'+data.payable_client_contact_name+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Vendor A/P Client Contact Phone:</b></td><td><input class="vendor_input" type="text" name="payable_client_contact_phone" value="'+data.payable_client_contact_phone+'"></td></tr>';
					edit_form+='<tr><td class="frmlabel"><b>Vendor A/P Client Contact Email:</b></td><td><input class="vendor_input" type="text" name="payable_client_contact_email" value="'+data.payable_client_contact_email+'"></td></tr>';
					edit_form+='<tr><td colspan="2" align="center"><button type="submit">Save</button>&nbsp;&nbsp;<button onclick="remove_payable_contact_form('+id+')" type="button">Never Mind</button></td></tr>';
					edit_form+='</table>';
					edit_form+='</form></td></tr>';
					document.getElementById('pay_contact_detail_div_'+id).innerHTML=edit_form;
			}
			}

			xmlhttp.open("GET","get_vendor_data_for_edit.php?EDIT_PAYABLE_CONTACT=1&contact_id="+id,true);
			xmlhttp.send();

		}
		function remove_payable_contact_form(id){
			document.getElementById('pay_contact_detail_div_'+id).innerHTML=data_before_edit_vendor_pay_contact;
		}

	</script>
</body>
</html>