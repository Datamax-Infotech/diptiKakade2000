<?php
session_start();
// ini_set("display_errors", "1");

// error_reporting(E_ERROR);
//require "inc/header_session.php";
require "../mainfunctions/database.php";
require "../mainfunctions/general-functions.php";
require "tablefunctions.php";

$chkinitials = $_COOKIE['userinitials'];


// function getnickname(string $warehouse_name, int $b2bid): string
// {
//     $nickname = "";

//     if ($b2bid > 0) {
//         $sql = "SELECT nickname, company, shipCity, shipState FROM companyInfo where ID = " . $b2bid;
//         db_b2b();
// 		$result_comp = db_query($sql);

//         while ($row_comp = array_shift($result_comp)) {
//             if ($row_comp["nickname"] != "") {
//                 $nickname = $row_comp["nickname"];
//             } else {
//                 $tmppos_1 = strpos($row_comp["company"], "-");
//                 if ($tmppos_1 !== false) {
//                     $nickname = $row_comp["company"];
//                 } else {
//                     if ($row_comp["shipCity"] != "" || $row_comp["shipState"] != "") {
//                         $nickname = $row_comp["company"] . " - " . $row_comp["shipCity"] . ", " . $row_comp["shipState"];
//                     } else {
//                         $nickname = $row_comp["company"];
//                     }
//                 }
//             }
//         }
//     } else {
//         $nickname = $warehouse_name;
//     }

//     return $nickname;
// }

?>
<!DOCTYPE html>
<html>
<head>
<title>Recyclers Report</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="sorter/style.css" />

	<LINK rel='stylesheet' type='text/css' href='one_style.css' >
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>
</head>

<body bgcolor="#FFFFFF" text="#333333" link="#333333" vlink="#666666" alink="#333333">

<table border="0" width="80%" cellspacing="0" cellpadding="5">
  <tr>

    <td  valign="top">

			<?php
			$sort_order_pre = "ASC";
			if ($_GET['sort_order_pre'] == "ASC") {
				$sort_order_pre = "DESC";
			} else {
				$sort_order_pre = "ASC";
			}

			?>
		<?php include "inc/header.php";?>

		<div class="main_data_css">
			<div class="dashboard_heading" style="float: left;">
				<div style="float: left;">Recyclers Report
					<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
						<span class="tooltiptext">
							Recyclers Report
						</span>
					</div>

					<div style="height: 13px;">&nbsp;</div>
				</div>
			</div>

			<form action="recyclers_report.php" method="get">

				<div ><i>Note: Please wait until you see <font color="red">"END OF REPORT"</font> at the bottom of the report, before using the sort option.</i></div>
				<table width="100%" border="0" cellspacing="2" cellpadding="2" bgcolor="#E4E4E4">
					<tr align="center">
					<td colspan="2" bgcolor="#C0CDDA"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">Recyclers Report</font></td>
					</tr>
					<tr align="left">
						<td colspan="2" bgcolor="#C0CDDA"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
							Select from:
							<select name="sales_rescue" id="sales_rescue">
								<option value='sales'>Companies Buying</option>
								<option value='rescue'>Companies Selling</option>
							</select>
								&nbsp;&nbsp;

								Select Commodity:
								<?php
								$matchStr2 = "Select * from commodity_master order by commodity";
								db();
								$res = db_query($matchStr2);
								?>
							<select name="commodity_id" id="commodity_id">
								<option value=''></option>
								<?php
									while ($objInvmatch = array_shift($res)) {

										if ($objInvmatch["commodity_id"] == $_REQUEST["commodity_id"]) {
											echo "<option value=" . $objInvmatch["commodity_id"] . " Selected >";
										} else {
											echo "<option value=" . $objInvmatch["commodity_id"] . " >";
										}
										echo $objInvmatch["commodity"];
										echo "</option>";
									}
								?>
							</select>
								&nbsp;&nbsp;
								Enter ZIP to Search Area:
								<input type="text "name="txt_zip" id="txt_zip" value="<?php echo $_REQUEST["txt_zip"]; ?>" size="5">
								&nbsp;&nbsp;

								How many miles to search?
								<input type="text "name="miles" id="miles" value="<?php if ($_REQUEST["miles"] == '') {echo '50';} else {echo $_REQUEST["miles"];}?>" size="5">
								&nbsp;&nbsp;

								State:
							<select name="state" id="state">
								<option value="" <?PHP if ($_REQUEST["state"] == "") {
										echo "selected";
									}
									?>>Any State</option>
														<option value="AL" <?PHP if ($_REQUEST["state"] == "AL") {
										echo "selected";
									}
									?>>Alabama</option>
														<option value="AK" <?PHP if ($_REQUEST["state"] == "AK") {
										echo "selected";
									}
									?>>Alaska</option>
														<option value="AZ" <?PHP if ($_REQUEST["state"] == "AZ") {
										echo "selected";
									}
									?>>Arizona</option>
								<option value="AR" <?PHP if ($_REQUEST["state"] == "AR") {
										echo "selected";
									}
									?>>Arkansas</option>
														<option value="CA" <?PHP if ($_REQUEST["state"] == "CA") {
										echo "selected";
									}
									?>>California</option>
														<option value="CO" <?PHP if ($_REQUEST["state"] == "CO") {
										echo "selected";
									}
									?>>Colorado</option>
														<option value="CT" <?PHP if ($_REQUEST["state"] == "CT") {
										echo "selected";
									}
									?>>Connecticut</option>
														<option value="DE" <?PHP if ($_REQUEST["state"] == "DE") {
										echo "selected";
									}
									?>>Delaware</option>
														<option value="DC" <?PHP if ($_REQUEST["state"] == "DC") {
										echo "selected";
									}
									?>>District of Columbia</option>
														<option value="FL" <?PHP if ($_REQUEST["state"] == "FL") {
										echo "selected";
									}
									?>>Florida</option>
														<option value="GA" <?PHP if ($_REQUEST["state"] == "GA") {
										echo "selected";
									}
									?>>Georgia</option>
														<option value="HI" <?PHP if ($_REQUEST["state"] == "HI") {
										echo "selected";
									}
									?>>Hawaii</option>
														<option value="ID" <?PHP if ($_REQUEST["state"] == "ID") {
										echo "selected";
									}
									?>>Idaho</option>
														<option value="IL" <?PHP if ($_REQUEST["state"] == "IL") {
										echo "selected";
									}
									?>>Illinois</option>
														<option value="IN" <?PHP if ($_REQUEST["state"] == "IN") {
										echo "selected";
									}
									?>>Indiana</option>
														<option value="IA" <?PHP if ($_REQUEST["state"] == "IA") {
										echo "selected";
									}
									?>>Iowa</option>
														<option value="KS" <?PHP if ($_REQUEST["state"] == "KS") {
										echo "selected";
									}
									?>>Kansas</option>
														<option value="KY" <?PHP if ($_REQUEST["state"] == "KY") {
										echo "selected";
									}
									?>>Kentucky</option>
														<option value="LA" <?PHP if ($_REQUEST["state"] == "LA") {
										echo "selected";
									}
									?>>Louisiana</option>
														<option value="ME" <?PHP if ($_REQUEST["state"] == "ME") {
										echo "selected";
									}
									?>>Maine</option>
														<option value="MD" <?PHP if ($_REQUEST["state"] == "MD") {
										echo "selected";
									}
									?>>Maryland</option>
														<option value="MA" <?PHP if ($_REQUEST["state"] == "MA") {
										echo "selected";
									}
									?>>Massachusetts</option>
														<option value="MI" <?PHP if ($_REQUEST["state"] == "MI") {
										echo "selected";
									}
									?>>Michigan</option>
														<option value="MN" <?PHP if ($_REQUEST["state"] == "MN") {
										echo "selected";
									}
									?>>Minnesota</option>
														<option value="MS" <?PHP if ($_REQUEST["state"] == "MS") {
										echo "selected";
									}
									?>>Mississippi</option>
														<option value="MO" <?PHP if ($_REQUEST["state"] == "MO") {
										echo "selected";
									}
									?>>Missouri</option>
														<option value="MT" <?PHP if ($_REQUEST["state"] == "MT") {
										echo "selected";
									}
									?>>Montana</option>
														<option value="NE" <?PHP if ($_REQUEST["state"] == "NE") {
										echo "selected";
									}
									?>>Nebraska</option>
														<option value="NV" <?PHP if ($_REQUEST["state"] == "NV") {
										echo "selected";
									}
									?>>Nevada</option>
														<option value="NH" <?PHP if ($_REQUEST["state"] == "NH") {
										echo "selected";
									}
									?>>New Hampshire</option>
														<option value="NJ" <?PHP if ($_REQUEST["state"] == "NJ") {
										echo "selected";
									}
									?>>New Jersey</option>
														<option value="NM" <?PHP if ($_REQUEST["state"] == "NM") {
										echo "selected";
									}
									?>>New Mexico</option>
														<option value="NY" <?PHP if ($_REQUEST["state"] == "NY") {
										echo "selected";
									}
									?>>New York</option>
														<option value="NC" <?PHP if ($_REQUEST["state"] == "NC") {
										echo "selected";
									}
									?>>North Carolina</option>
														<option value="ND" <?PHP if ($_REQUEST["state"] == "ND") {
										echo "selected";
									}
									?>>North Dakota</option>
														<option value="OH" <?PHP if ($_REQUEST["state"] == "OH") {
										echo "selected";
									}
									?>>Ohio</option>
														<option value="OK" <?PHP if ($_REQUEST["state"] == "OK") {
										echo "selected";
									}
									?>>Oklahoma</option>
														<option value="OR" <?PHP if ($_REQUEST["state"] == "OR") {
										echo "selected";
									}
									?>>Oregon</option>
														<option value="PA" <?PHP if ($_REQUEST["state"] == "PA") {
										echo "selected";
									}
									?>>Pennsylvania</option>
														<option value="RI" <?PHP if ($_REQUEST["state"] == "RI") {
										echo "selected";
									}
									?>>Rhode Island</option>
														<option value="SC" <?PHP if ($_REQUEST["state"] == "SC") {
										echo "selected";
									}
									?>>South Carolina</option>
														<option value="SD" <?PHP if ($_REQUEST["state"] == "SD") {
										echo "selected";
									}
									?>>South Dakota</option>
														<option value="TN" <?PHP if ($_REQUEST["state"] == "TN") {
										echo "selected";
									}
									?>>Tennessee</option>
														<option value="TX" <?PHP if ($_REQUEST["state"] == "TX") {
										echo "selected";
									}
									?>>Texas</option>
														<option value="UT" <?PHP if ($_REQUEST["state"] == "UT") {
										echo "selected";
									}
									?>>Utah</option>
														<option value="VT" <?PHP if ($_REQUEST["state"] == "VT") {
										echo "selected";
									}
									?>>Vermont</option>
														<option value="VA" <?PHP if ($_REQUEST["state"] == "VA") {
										echo "selected";
									}
									?>>Virginia</option>
														<option value="WA" <?PHP if ($_REQUEST["state"] == "WA") {
										echo "selected";
									}
									?>>Washington</option>
														<option value="WV" <?PHP if ($_REQUEST["state"] == "WV") {
										echo "selected";
									}
									?>>West Virginia</option>
														<option value="WI" <?PHP if ($_REQUEST["state"] == "WI") {
										echo "selected";
									}
									?>>Wisconsin</option>
														<option value="WY" <?PHP if ($_REQUEST["state"] == "WY") {
										echo "selected";
									}
									?>>Wyoming</option>
														<option value="AB" <?PHP if ($_REQUEST["state"] == "AB") {
										echo "selected";
									}
									?>>Alberta</option>
														<option value="BC" <?PHP if ($_REQUEST["state"] == "BC") {
										echo "selected";
									}
									?>>British Columbia</option>
														<option value="MB" <?PHP if ($_REQUEST["state"] == "MB") {
										echo "selected";
									}
									?>>Manitoba</option>
														<option value="NB" <?PHP if ($_REQUEST["state"] == "NB") {
										echo "selected";
									}
									?>>New Brunswick</option>
														<option value="NF" <?PHP if ($_REQUEST["state"] == "NF") {
										echo "selected";
									}
									?>>Newfoundland</option>
														<option value="NS" <?PHP if ($_REQUEST["state"] == "NS") {
										echo "selected";
									}
									?>>Nova Scotia</option>
														<option value="NT" <?PHP if ($_REQUEST["state"] == "NT") {
										echo "selected";
									}
									?>>Northwest Territories</option>
														<option value="NU" <?PHP if ($_REQUEST["state"] == "NU") {
										echo "selected";
									}
									?>>Nunavut</option>
														<option value="ON" <?PHP if ($_REQUEST["state"] == "ON") {
										echo "selected";
									}
									?>>Ontario</option>
														<option value="PE" <?PHP if ($_REQUEST["state"] == "PE") {
										echo "selected";
									}
									?>>Prince Edward Island</option>
														<option value="QC" <?PHP if ($_REQUEST["state"] == "QC") {
										echo "selected";
									}
									?>>Quebec</option>
														<option value="SK" <?PHP if ($_REQUEST["state"] == "SK") {
										echo "selected";
									}
									?>>Saskatchewan</option>
														<option value="YT" <?PHP if ($_REQUEST["state"] == "YT") {
										echo "selected";
									}
									?>>Yukon Territory</option>
							</select>

							</font>
						</td>
					</tr>

					<tr>
						<td>
							<input type=submit value="Find Matches">
						</td>
					</tr>
				</table>
			</form>

			<br>
				<?php
					$sorturl = "recyclers_report.php?sales_rescue=" . $_REQUEST["sales_rescue"] . "&commodity_id=" . $_REQUEST["commodity_id"] . "&txt_zip=" . $_REQUEST["txt_zip"] . "&miles=" . $_REQUEST["miles"] . "&state=" . $_REQUEST["state"] . "";

				?>
			<table width="1000px" border="0" cellspacing="2" cellpadding="2" bgcolor="#E4E4E4" id="table" class="sortable">
				<thead>
					<tr>
						<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
							<strong>Company</strong>
							<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=company"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=company"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>

						</th>
						<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
							<strong>Account Owner</strong>
							<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=rep"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=rep"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
						</th>
						<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
							<strong>Sell to Email</strong>
							<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=selltoeml"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=selltoeml"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>

						</th>
						<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
							<strong>Last Contact Date</strong>
							<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=lastcrmdate"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=lastcrmdate"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
						</th>
						<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
							<strong>Account Status</strong>
							<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=acc_status"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=acc_status"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>

						</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if (isset($_REQUEST["sort"])) 
						{
							$MGArray = $_SESSION['sortarrayn'];

							if ($_GET['sort'] == "company") {
								$MGArraysort_I = array();
								foreach ($MGArray as $MGArraytmp) {
									$MGArraysort_I[] = $MGArraytmp['company'];

								}
								if ($_GET['sort_order_pre'] == "ASC") {
									array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);

								}
								if ($_GET['sort_order_pre'] == "DESC") {
									array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
								}
							}
							if ($_GET['sort'] == "selltoeml") {
								$MGArraysort_I = array();
								foreach ($MGArray as $MGArraytmp) {
									$MGArraysort_I[] = $MGArraytmp['email'];
								}
								if ($_GET['sort_order_pre'] == "ASC") {
									array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
								}
								if ($_GET['sort_order_pre'] == "DESC") {
									array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
								}
							}
							if ($_GET['sort'] == "rep") {
								$MGArraysort_I = array();
								foreach ($MGArray as $MGArraytmp) {
									$MGArraysort_I[] = $MGArraytmp['rep'];
								}
								if ($_GET['sort_order_pre'] == "ASC") {
									array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
								}
								if ($_GET['sort_order_pre'] == "DESC") {
									array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
								}
							}
							if ($_GET['sort'] == "lastcrmdate") {
								$MGArraysort_I = array();
								foreach ($MGArray as $MGArraytmp) {
									$MGArraysort_I[] = $MGArraytmp['lastcrmdt_sort'];
								}
								if ($_GET['sort_order_pre'] == "ASC") {
									array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
								}
								if ($_GET['sort_order_pre'] == "DESC") {
									array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
								}
							}
							if ($_GET['sort'] == "acc_status") {
								$MGArraysort_I = array();
								foreach ($MGArray as $MGArraytmp) {
									$MGArraysort_I[] = $MGArraytmp['acc_status'];
								}
								if ($_GET['sort_order_pre'] == "ASC") {
									array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGArray);
								}
								if ($_GET['sort_order_pre'] == "DESC") {
									array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGArray);
								}
							}
							foreach ($MGArray as $MGArraytmp2) {
								if ($MGArraytmp2["rep"] != "") 
								{
									?>
									<tr>
										<td bgColor="#E4EAEB" class="style12" align="left">
											<a target="_blank" href="viewCompany.php?ID=<?php echo $MGArraytmp2["companyid"]; ?> target="_blank"><?php echo $MGArraytmp2["company"]; ?></a>
										</td>
										<td bgColor="#E4EAEB" class="style12" align="left">
											<?php echo $MGArraytmp2["rep"]; ?>
										</td>
										<td bgColor="#E4EAEB" class="style12" align="left">
											<?php echo $MGArraytmp2["email"]; ?>
										</td>
										<td bgColor="#E4EAEB" class="style12" align="left">
											<?php echo $MGArraytmp2["lastcrmdate"]; ?>
										</td>
										<td bgColor="#E4EAEB" class="style12" align="left">
											<?php echo $MGArraytmp2["acc_status"]; ?>
										</td>
									</tr>
								<?php
								}
							}
						} 
						else 
						{

							if ($_REQUEST["commodity_id"] != "") {
								$matchStr2 = "Select comp_id_b2b from commodity_trans inner join commodity_master on commodity_master.commodity_id = commodity_trans.commodity_id where commodity_trans.commodity_id = " . $_REQUEST["commodity_id"];
								db();
								$res = db_query($matchStr2);
								while ($objInvmatch = array_shift($res)) {
									$sales_rescue_str = "";
									if ($_REQUEST["sales_rescue"] == "sales") {
										$sales_rescue_str = " and companyInfo.haveNeed = 'Need Boxes' ";
									}
									if ($_REQUEST["sales_rescue"] == "rescue") {
										$sales_rescue_str = " and companyInfo.haveNeed = 'Have Boxes' ";
									}

									$state_str = "";
									if ($_REQUEST["state"] != "") {
										$state_str = " and companyInfo.state = '" . $_REQUEST["state"] . "' ";
									}
									db_b2b();
									$res_comp = db_query("Select *, employees.name as empname, status.name as statusname from companyInfo left join employees on employees.employeeID = companyInfo.assignedto left join status on status.id = companyInfo.status where companyInfo.ID = " . $objInvmatch["comp_id_b2b"] . $sales_rescue_str . $state_str);
								
									while ($obj_comp = array_shift($res_comp)) {

										$show_record = "yes";
										$txt_zip = $_REQUEST["txt_zip"];
										if ($txt_zip != "") {

											$tmppos_1 = strpos($txt_zip, " ");
											if ($tmppos_1 != false) {
												$tmp_zipval = str_replace(" ", "", $txt_zip);
												$zipStr = "Select * from zipcodes_canada WHERE zip = '" . $tmp_zipval . "'";
											} else {
												$zipStr = "Select * from ZipCodes WHERE zip = '" . intval($txt_zip) . "'";
											}
											db_b2b();
											$res4 = db_query($zipStr);
											$objShipZip = array_shift($res4);

											$shipLat = $objShipZip["latitude"];
											$shipLong = $objShipZip["longitude"];

											$zipStr = "";
											$locLat = "";
											$locLong = "";
											$tmppos_1 = strpos($obj_comp["zip"], " ");
											if ($tmppos_1 != false) {
												$tmp_zipval = str_replace(" ", "", $obj_comp["zip"]);
												$zipStr = "Select * from zipcodes_canada WHERE zip = '" . $tmp_zipval . "'";
											} else {
												$zipStr = "Select * from ZipCodes WHERE zip = '" . intval($obj_comp["zip"]) . "'";
											}
											db_b2b();
											$dt_view_res4 = db_query($zipStr);
											while ($ziploc = array_shift($dt_view_res4)) {
												$locLat = $ziploc["latitude"];

												$locLong = $ziploc["longitude"];
											}

											$distLat = ($shipLat - $locLat) * 3.141592653 / 180;
											$distLong = ($shipLong - $locLong) * 3.141592653 / 180;

											$distA = Sin($distLat / 2) * Sin($distLat / 2) + Cos($shipLat * 3.14159 / 180) * Cos($locLat * 3.14159 / 180) * Sin($distLong / 2) * Sin($distLong / 2);

											$distC = 2 * atan2(sqrt($distA), sqrt(1 - $distA));

											//echo $obj_comp["ID"] . " " . (int) (6371 * $distC * .621371192) . " " . $_REQUEST["miles"] . "<br>";

											if ((int) (6371 * $distC * .621371192) > (int) ($_REQUEST["miles"])) {
												$show_record = "no";
											}
										}

										if ($show_record == "yes") 
										{
											$lastcrmdt = $obj_comp["last_contact_date"];
											if ($lastcrmdt != "") {
												$lastcrmdt_sort = date("Y-m-d", strtotime($lastcrmdt));
												$lastcrmdt = date("m/d/Y", strtotime($lastcrmdt));
											} else {
												$lastcrmdt_sort = "";
												$lastcrmdt = "";
											}
											?>
											<tr>
												<td bgColor="#E4EAEB" class="style12" align="left">
													<a target="_blank" href="viewCompany.php?ID=<?php echo $obj_comp["ID"]; ?>" target="_blank"><?php echo getnickname('', $objInvmatch["comp_id_b2b"]);
													$nickname = getnickname('', $objInvmatch["comp_id_b2b"]);
													?></a>
												</td>
												<td bgColor="#E4EAEB" class="style12" align="left">
													<?php echo $obj_comp["empname"]; ?>
												</td>
												<td bgColor="#E4EAEB" class="style12" align="left">
													<?php echo $obj_comp["email"]; ?>
												</td>
												<td bgColor="#E4EAEB" class="style12" align="left">
													<?php echo $lastcrmdt; ?>
												</td>
												<td bgColor="#E4EAEB" class="style12" align="left">
													<?php echo $obj_comp["statusname"]; ?>
												</td>
											</tr>
											<?php
											$MGArray[] = array('companyid' => $obj_comp["ID"], 'company' => $nickname, 'tmp_str' => $tmp_str, 'email' => $obj_comp["email"],
												'acc_status' => $obj_comp["statusname"], 'rep' => $obj_comp["empname"], 'lastcrmdate' => $lastcrmdt, 'lastcrmdt_sort' => $lastcrmdt_sort);

											$_SESSION['sortarrayn'] = $MGArray;
										}
									}

								}

							}
						}
					?>


				</tbody>
			</table>
			<div >
				<i><font color="red">"END OF REPORT"</font></i>
			</div>

	    </div>
</body>
</html>