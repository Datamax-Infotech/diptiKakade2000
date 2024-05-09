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
	<title>Water Contracted Clients <?php echo "Logged in as : " . $_COOKIE['userinitials']; ?></title>
	<meta http-equiv="refresh" content="3000">



	<style type="text/css">
		.main_data_css{
			margin: 0 auto;
			width: 100%;
			height: auto;
			clear: both !important;
			padding-top: 35px;

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


	/*Tooltip style*/
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
/*white-space: nowrap;*/
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
<LINK rel='stylesheet' type='text/css' href='one_style.css' >
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>
</head>
<body>
<?php include "inc/header.php";?>
	<div class="main_data_css">
	<div class="dashboard_heading" style="float: left;">
		<div style="float: left;">Contracted Clients (Implementation Process, Order to Cash Cycle)
		<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
		<span class="tooltiptext">
			UCB Zero Waste Contracted Clients
		</span></div>

		<div style="height: 13px;">&nbsp;</div>
		</div>
	</div>

	<table border="0" cellpadding="5" cellspacing="2" width="99%" align="center">
		<tr align="middle">
			<td>
				<table cellSpacing="0" cellPadding="2" border="0" width="100%" class="impl_css">
					<tr align="middle">
					  <td class="style24" style="height: 16px" colspan="14">
						  <?php
							$comp_qr = "Select * from companyInfo where ucbzw_account_status = 83";
							db_b2b();
							$comp_row1 = db_query($comp_qr);
							$total_implementation = tep_db_num_rows($comp_row1);

							?>
						    <strong><span style="text-transform: uppercase">
							  IMPLEMENTATION PROCESS:</span> Contracted Clients (<?php echo $total_implementation; ?> records found)
						    </strong>
						</td>
					</tr>
					  <?php
$sorturl = "water_index_contracted_clients.php?w=wt";
?>
					  <tr>
					  	  <th class="border_left" bgcolor="#C0CDDA" width="230px">COMPANY NAME &nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=comp_name"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=comp_name"><img src="images/sort_desc.png" width="6px;" height="12px;"></a></th>
						  <th bgcolor="#C0CDDA">Client <br>WATER<br> Dashboard</th>
						  <th class="border_right" bgcolor="#C0CDDA">UCBZW <br>ACCOUNT<br> OWNER &nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=acctowner"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=acctowner"><img src="images/sort_desc.png" width="6px;" height="12px;"></a></th>
						  <th class="border_left" bgcolor="#C0CDDA">NUMBER OF <br>PAST DUE <br>INITIATIVES &nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=pastdueinitiative"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=pastdueinitiative"><img src="images/sort_desc.png" width="6px;" height="12px;"></a></th>
						  <th bgcolor="#C0CDDA">NUMBER OF <br>ACTIVE <br>INITIATIVES &nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=activeinitiative"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=activeinitiative"><img src="images/sort_desc.png" width="6px;" height="12px;"></a></th>
						  <th class="border_right" bgcolor="#C0CDDA">NUMBER OF<br> INITIATIVES <br>COMPLETED &nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=numinitiative"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=numinitiative"><img src="images/sort_desc.png" width="6px;" height="12px;"></a></th>
						  <th bgcolor="#C0CDDA">CURRENT <br>MONTH <br>VENDORS <br>REPORTS <br>NEEDED &nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=currentmonthvendor"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=currentmonthvendor"><img src="images/sort_desc.png" width="6px;" height="12px;"></a></th>
						  <th bgcolor="#C0CDDA">CURRENT <br>MONTH UCBZW <br>Consolidated <br>Invoices <br>to create &nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=currentmonthconsolidate"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=currentmonthconsolidate"><img src="images/sort_desc.png" width="6px;" height="12px;"></a></th>
						  <th bgcolor="#C0CDDA">Previous <br>Months<br>VENDORS <br>REPORTS <br>NEEDED &nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=prevmonthvendor"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=prevmonthvendor"><img src="images/sort_desc.png" width="6px;" height="12px;"></a></th>
						  <th class="border_right" bgcolor="#C0CDDA">Previous <br>Months UCBZW <br>Consolidated <br>Invoices <br>to create &nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=prevmonthconsolidate"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=prevmonthconsolidate"><img src="images/sort_desc.png" width="6px;" height="12px;"></a></th>
						  <th class="border_right" bgcolor="#C0CDDA">UNPAID <br>UCBZW <br>CONSOLIDATED <br>INVOICES &nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=unpaidconsolidate_invo"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=unpaidconsolidate_invo"><img src="images/sort_desc.png" width="6px;" height="12px;"></a></th>
						  <th class="border_right" bgcolor="#C0CDDA">UCBZW <br>PROFIT <br>SHARE <br>TO DATE &nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=profitsharedate"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=profitsharedate"><img src="images/sort_desc.png" width="6px;" height="12px;"></a></th>
						  <th bgcolor="#C0CDDA">VENDOR <br>PAYMENTS <br>TO MAKE &nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=vendorpayment_make"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=vendorpayment_make"><img src="images/sort_desc.png" width="6px;" height="12px;"></a></th>
						  <th class="border_right" bgcolor="#C0CDDA">VENDOR <br>PAYMENTS <br>TO RECEIVE &nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=vendorpaym_receive"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=vendorpaym_receive"><img src="images/sort_desc.png" width="6px;" height="12px;"></a></th>

					  	</tr>
						<?php
					    if (!isset($_REQUEST["sort"])){
                        $MGArray_data = array();
						$displayedRow = 1;
						while ($cres= array_shift($comp_row1)) {
							$warehouse_id=$cres["loopid"];
							$linksalesid=$cres["link_sales_id"];
							$comp_nickname = get_nickname_val($cres["company"], $cres["ID"]);
						
							$past_due_total=0;$past_due_active_total=0;
							$init_sql1 = "SELECT * FROM water_initiatives where companyid = '" . $cres["ID"] . "' and status = 1 and task_status<>4";
							db();
							$init_result1 = db_query($init_sql1);
							$total_active_initiative=tep_db_num_rows($init_result1);
							while ($myrowsel = array_shift($init_result1)) {
							$date1 = new DateTime($myrowsel["due_date"]);
								$date2 = new DateTime();

								$days = (strtotime($myrowsel["due_date"]) - strtotime(date("Y-m-d"))) / (60 * 60 * 24);
								if ($days < 0){
									$past_due_total=$past_due_total+1;
								}
								if ($days == 0 || $days > 0){
									$past_due_active_total=$past_due_active_total+1;
								}
							}
						
							$init_sql_comp = "SELECT * FROM water_initiatives where companyid = '" . $cres["ID"] . "' and (status = 2 )"; //or task_status=4
							db();
							$init_result_comp = db_query($init_sql_comp);
							$completed_initiatives=tep_db_num_rows($init_result_comp);
							
							$qassign = "SELECT * FROM employees WHERE status='Active' and employeeID='".$cres["ucbzw_account_owner"]."'";
							db_b2b();
							$dt_view_res_assign = db_query($qassign);
							$res_assign= array_shift($dt_view_res_assign);
							$owner=$res_assign["initials"];
					
							$selected_yr=date('Y');
					
							if ($selected_yr == date("Y")){
								$selected_month = Date("m")-1;
							}else{
								$selected_month = 12;
							}
							
							$query_mtd1 = "(SELECT water_vendors.Name, water_vendors.main_material, water_vendors.id as vendor from water_comp_vendor_list inner join water_vendors on water_vendors.id = water_comp_vendor_list.vendor_id
							WHERE comp_id = '" . $warehouse_id . "' and water_vendors.Name <> '' group by water_vendors.id ORDER BY water_vendors.Name) order by Name";
							
							$data_no_printed = "n"; $count_less_30 = 0; $count_less_30c = 0; $count_greater_30 = 0; $count_greater_30c=0;
							db();
							$res1 = db_query($query_mtd1);
							while($row_vendor = array_shift($res1))
							{
								$vender_nm = $row_vendor['Name'];

								$main_material = $row_vendor['main_material'];
								for ($month_cnt=1, $n=$selected_month; $month_cnt<=$n; $month_cnt++) {
									$data_no_printed = "y";
									$query = "SELECT company_id, have_doubt, doubt, no_invoice_due_flg from water_transaction where company_id = " . $warehouse_id . " and vendor_id = " . $row_vendor['vendor'] . " and Month(invoice_date) = " . $month_cnt . " and Year(invoice_date) = " . $selected_yr;
								
									db();
									$res = db_query($query);
									$rec_found = "no"; $have_doubt = ""; $doubt_txt = ""; $no_invoice_due_flg = "";
									while($row = array_shift($res))
									{
										$rec_found = "yes";
										if ($row["have_doubt"] == 1)
										{
											$have_doubt = "yes";
											$doubt_txt = $row["doubt"];
										}
							
										if ($row["no_invoice_due_flg"] == 1)
										{
											$rec_found = "no";
											$no_invoice_due_flg = "yes";
										}
									}

									if ($rec_found == "yes")
									{
										if ($have_doubt == "yes"){
										}else{ }
									}else{
										if ($no_invoice_due_flg != "yes"){
											if ($n == $month_cnt){
												if($row_vendor['vendor']!=844)
												{
													$count_less_30 = $count_less_30 + 1;
												}
												if($row_vendor['vendor']==844)
												{
													$count_less_30c = $count_less_30c + 1;
												}

											}else{

												if($row_vendor['vendor']!=844)
												{
													$count_greater_30 = $count_greater_30 + 1;
												}
												if($row_vendor['vendor']==844)
												{
													$count_greater_30c = $count_greater_30c + 1;
												}
											}

										}else{

										}
									}

								}

							}
							/*CHANGES IN MAKE PAYMENT LOGIN AS PER CLIENT REQUIREMENTS*/
							$qryMakePayment = "Select *,sum(amount) as amt, loop_warehouse.company_name, loop_warehouse.b2bid from water_transaction inner join loop_warehouse on loop_warehouse.id = water_transaction.company_id where make_receive_payment = 1 and company_id='".$warehouse_id."' AND water_transaction.made_payment = 0  group by company_id, water_transaction.id order by water_transaction.company_id";
							db();
							$resMakePayment = db_query($qryMakePayment);
							$amt_make_new = 0;
							while ($rowMakePayment = array_shift($resMakePayment)) {
								//if($rowMakePayment["amt"]<0){
									$amt_make_new = $amt_make_new + $rowMakePayment["amt"];
								//}
							}
					
							$vendorQry = "Select *,sum(amount) as amt, loop_warehouse.company_name, loop_warehouse.b2bid from water_transaction inner join loop_warehouse on loop_warehouse.id = water_transaction.company_id where make_receive_payment = 1 and company_id='".$warehouse_id."'  group by company_id, water_transaction.id order by water_transaction.company_id";
						
							db();
							$v_res1 = db_query($vendorQry);
							$vnumrows=tep_db_num_rows($v_res1);
							$amt_make=0; $amt_receive=0;
							while ($rows = array_shift($v_res1)) {
								if($rows["amt"]<0){
								//if($rows["made_payment"] == 1){
									$amt_make=$amt_make+$rows["amt"];
								}
								
								if($rows["amt"]>0){
								//if($rows["made_payment"] == 0){
									$amt_receive=$amt_receive+$rows["amt"];
								}

							}

						
							if($linksalesid>0)
							{
								$profit_val=0;
								db_b2b();
								$com_linkqry=db_query("select loopid from companyInfo where ID='" . $linksalesid . "'");
								$clink_rows = array_shift($com_linkqry);
							
								$link_warehouseid=$clink_rows["loopid"];
								
								$dt_view_qry = "SELECT id, po_file, po_poorderamount, inv_amount from loop_transaction_buyer WHERE warehouse_id = '" . $link_warehouseid . "' and UCBZeroWaste_flg=1 AND po_file != ''";
							
								db();
								$dt_view_res = db_query($dt_view_qry);
								$total_profit=0;
								while ($num_rows = array_shift($dt_view_res)) {
									$trans_id=$num_rows["id"];
									$inv_amount = $num_rows["inv_amount"];
									
									$invoice_amt=0;
									$inv_qry = "SELECT * FROM loop_invoice_items WHERE trans_rec_id = " . $trans_id . " ORDER BY id ASC";
									db();
									$inv_res = db_query($inv_qry);
									while ($inv_row = array_shift($inv_res)) {
										$invoice_amt += $inv_row["quantity"]*$inv_row["price"];
									}
									if ($invoice_amt== 0) {
										$invoice_amt=$inv_amount;
									}

									
									$vendor_pay = 0;
									$dt_view_qry5 = "SELECT *, loop_transaction_buyer_payments.id AS A , loop_transaction_buyer_payments.status AS B, files_companies.name AS C from loop_transaction_buyer_payments left JOIN files_companies ON loop_transaction_buyer_payments.company_id = files_companies.id  INNER JOIN loop_vendor_type ON loop_transaction_buyer_payments.typeid = loop_vendor_type.id  WHERE loop_transaction_buyer_payments.transaction_buyer_id = '". $trans_id ."'" ;
									db();
									$dt_view_res5 = db_query($dt_view_qry5);
									$num_rows1 = tep_db_num_rows($dt_view_res5);
									if ($num_rows1 > 0) {

										while ($dt_view_row2 = array_shift($dt_view_res5)) {
											$vendor_pay += $dt_view_row2["estimated_cost"];
										}
									}
									


									$sub_profit=$invoice_amt-$vendor_pay;

									

									$total_profit=$total_profit+$sub_profit;
								

								}
						
							}
							else{
								$total_profit=0;
							}
						
							if($linksalesid>0)
							{
								db_b2b();
								$com_linkqry1=db_query("select loopid from companyInfo where ID='" . $linksalesid . "'");
								$clink_rows1 = array_shift($com_linkqry1);
								
								$link_warehouseid=$clink_rows1["loopid"];
								
								$trans_view_qry = "SELECT * from loop_transaction_buyer WHERE warehouse_id = '" . $link_warehouseid . "' and UCBZeroWaste_flg=1";
								
								db();
								$trans_view_res = db_query($trans_view_qry);
								$unpaid_cnt=0;
								while ($tranlist = array_shift($trans_view_res)) {
									$noinv_val = 0;
								
									$sql_noinv = "SELECT no_invoice FROM loop_transaction_buyer WHERE id = '" . $tranlist["id"]."'" ;
									
									db();
									$rec_noinv = db_query($sql_noinv);
									while ($rec_noinvrow = array_shift($rec_noinv)) {
										$noinv_val = $rec_noinvrow["no_invoice"];
									}
									if ($noinv_val == 0) {
										$payments_sql = "SELECT SUM(loop_buyer_payments.amount) AS A FROM loop_buyer_payments WHERE trans_rec_id = '".$tranlist["id"]."'";
										db();

										$payment_qry = db_query($payments_sql);
										$payment = array_shift($payment_qry);
										
										if (number_format($tranlist["inv_amount"],2) == number_format($payment["A"],2) && $tranlist["inv_amount"] != "")
										{

										} elseif ($tranlist["inv_amount"] > 0) {
											$unpaid_cnt=$unpaid_cnt+1;
										} else {
											$unpaid_cnt=$unpaid_cnt+1;
										}
								
									}

								}

							}

							$sqlGetZWDt = "SELECT loginid, companyid, user_name, password FROM supplierdashboard_usermaster WHERE companyid=".$cres["ID"]." and activate_deactivate = 1" ;
							db();
							$resGetZWDt = db_query($sqlGetZWDt);
							$arrGetZWDt = array_shift($resGetZWDt);
							if(!empty($arrGetZWDt)){
								$userName 	= base64_encode($arrGetZWDt['user_name']);
								$pwd  		= base64_encode($arrGetZWDt['password']);
							}
					
							?>
							<tr vAlign="center">
							  	<td class="border_left" bgColor="#e4e4e4" class="stylenew" style="width: 10%"><a target="_blank" href ="viewCompany-purchasing.php?ID=<?php echo $cres["ID"]; ?>&proc=View&searchcrit=&show=water-initiatives&rec_type=Manufacturer"><?php echo $comp_nickname . "</a>"; ?>
								</td>
								<td class="border_left" bgColor="#e4e4e4" class="stylenew" style="width: 10%"><a target="_blank" href="https://www.ucbzerowaste.com/index.php?txtemail=<?php echo $userName; ?>&txtpassword=<?php echo $pwd; ?>&redirect=yes">Client WATER Dashboard</a>
								</td>

								<td class="border_right" bgColor="#e4e4e4" align="center"><?php echo $owner; ?></td>
								<td class="border_left" bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/viewCompany-purchasing.php?ID=<?php echo $cres["ID"]; ?>&proc=View&searchcrit=&show=water-initiatives&rec_type=Manufacturer" target="_blank">
									<span style='color:red;'>
									<?php echo $past_due_total; ?></span></td></a>

								<td bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/viewCompany-purchasing.php?ID=<?php echo $cres["ID"]; ?>&proc=View&searchcrit=&show=water-initiatives&rec_type=Manufacturer" target="_blank">
									<span style='color:blue;'>
									<?php echo $total_active_initiative; ?></span>
									</a>
								</td>
								<td class="border_right" bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/viewCompany-purchasing.php?ID=<?php echo $cres["ID"]; ?>&proc=View&searchcrit=&show=water-initiatives&rec_type=Manufacturer" target="_blank">
									<span style='color:green;'><?php echo $completed_initiatives; ?></span>
									</a>
								</td>
								<td bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/water_invoice_tracker.php?company_id=<?php echo $cres["ID"]; ?>&account_status_id=83&year_val=<?php echo $selected_yr; ?>" target="_blank">
									<?php
									if($count_less_30>0){
									?>
										<span style='color:red;'>
									<?php
									}
									else{
									?>
										<span style=''>
									<?php
									}
									echo $count_less_30; ?></span></a>
								</td>
								<td bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/water_invoice_tracker.php?company_id=<?php echo $cres["ID"]; ?>&account_status_id=83&year_val=<?php echo $selected_yr; ?>" target="_blank">
									<?php
									if($count_less_30c>0){
									?>
										<span style='color:red;'>
									<?php
									}
									else{
									?>
										<span style=''>
									<?php
									}
									echo $count_less_30c; ?></span></a></td>
								<td bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/water_invoice_tracker.php?company_id=<?php echo $cres["ID"]; ?>&account_status_id=83&year_val=<?php echo $selected_yr; ?>" target="_blank">
									<?php
									if($count_greater_30>0){
									?>
										<span style='color:red;'>
									<?php
									}
									else{
									?>
										<span style=''>
									<?php
									}
									echo $count_greater_30; ?></span></a>
								</td>
								<td class="border_right" bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/water_invoice_tracker.php?company_id=<?php echo $cres["ID"]; ?>&account_status_id=83&year_val=<?php echo $selected_yr; ?>" target="_blank">
									<?php
									if($count_greater_30c>0){
									?>
										<span style='color:red;'>
									<?php
									}
									else{
									?>
										<span style=''>
									<?php
									}
									echo $count_greater_30c; ?></span></a>
								</td>
								<td class="border_right" bgColor="#e4e4e4" align="center">
								<a href="viewCompany-purchasing.php?ID=<?php echo $cres["ID"]; ?>&proc=View&searchcrit=&show=watersalesinvoices&rec_type=Manufacturer" target="_blank">
								<?php echo $unpaid_cnt; ?></a></td>
								<td class="border_right" bgColor="#e4e4e4" align="center">$<?php echo number_format($total_profit, 2); ?></td>
								<td bgColor="#e4e4e4" align="right">
									<!-- <a href="payment_to_make_comp.php?company_id=<?php echo $warehouse_id; ?>" target="_blank"><span style='color:red;'><?php echo number_format($amt_make, 2); ?></span></a> -->
									<a href="UCBZeroWaste_Vendors_AP_AR.php?vendors_dd=All&comp_sel=<?php echo $warehouse_id; ?>&ddMadePayment=0" target="_blank">
										<span style='color:red;'>
											<?php //echo number_format($amt_make,2);
echo number_format($amt_make_new, 2);
?>
									 	</span>
									</a>
								</td>
								<td class="border_right" bgColor="#e4e4e4" align="right">
									<!-- <a href="payment_to_receive_comp.php?company_id=<?php echo $warehouse_id; ?>" target="_blank"><span style='color:green;'><?php echo number_format($amt_receive, 2); ?></span></a>-->
									<a href="UCBZeroWaste_Vendors_AP_AR.php?vendors_dd=All&comp_sel=<?php echo $warehouse_id; ?>&ddMadePayment=1" target="_blank"><span style='color:green;'><?php echo number_format($amt_receive, 2); ?></span></a>
								</td>
							</tr>
							<?php
							$displayedRow++;
							if($displayedRow > $total_implementation){
								?>
								<tr><td colspan="13" align="center" style="color: red; font-size: 12px; "><i>End of Report</i></td></tr>
								<?php
							}
							$MGArray[] = array('cid' => $cres["ID"],'comp_nickname' => $comp_nickname, 'userName' => $userName, 'pwd' => $pwd, 'owner' => $owner,
				            'past_due_total' => $past_due_total, 'total_active_initiative' => $total_active_initiative, 'completed_initiatives' => $completed_initiatives, 'selected_yr' => $selected_yr, 'count_less_30' => $count_less_30, 'count_less_30c' => $count_less_30c, 'count_greater_30' => $count_greater_30,'count_greater_30c' => $count_greater_30c,'unpaid_cnt' => $unpaid_cnt,'total_profit' => $total_profit,'amt_make_new' => $amt_make_new,'warehouse_id' => $warehouse_id,'amt_receive' => $amt_receive,'displayedRow' => $displayedRow,'total_implementation' => $total_implementation);
						}

						 $_SESSION['sortarrayn'] = $MGArray;
					}
					if(isset($_REQUEST["sort"]))
                    {
			             $MGArray = $_SESSION['sortarrayn'];

                         if($_REQUEST['sort'] == "comp_name")
                         {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            	$MGArraysort_I[] = $MGArraytmp['comp_nickname'];
                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,$MGArray);
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,$MGArray);
                            }

                        }
                        if($_REQUEST['sort'] == "acctowner")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['owner'];
                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray);
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray);
                            }
                        }
                        if($_REQUEST['sort'] == "pastdueinitiative")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['past_due_total'];

                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,$MGArray);
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,$MGArray);
                            }
                        }
                        if($_REQUEST['sort'] == "activeinitiative")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['total_active_initiative'];

                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,$MGArray);
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,$MGArray);
                            }
                        }
                        if($_REQUEST['sort'] == "numinitiative")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['completed_initiatives'];
                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,$MGArray);
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,$MGArray);
                            }
                        }
                        if($_REQUEST['sort'] == "currentmonthvendor")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['count_less_30'];
                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,$MGArray);
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,$MGArray);
                            }
                        }
                        if($_REQUEST['sort'] == "currentmonthconsolidate")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['count_less_30c'];
                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,$MGArray);
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,$MGArray);
                            }
                        }
						if($_REQUEST['sort'] == "prevmonthvendor")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['count_greater_30'];
                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,$MGArray);
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,$MGArray);
                            }
                        }
						if($_REQUEST['sort'] == "prevmonthconsolidate")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['count_greater_30c'];
                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,$MGArray);
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,$MGArray);
                            }
                        }
						if($_REQUEST['sort'] == "unpaidconsolidate_invo")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['unpaid_cnt'];
                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,$MGArray);
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,$MGArray);
                            }
                        }
						if($_REQUEST['sort'] == "profitsharedate")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['total_profit'];
                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,$MGArray);
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,$MGArray);
                            }
                        }
						if($_REQUEST['sort'] == "vendorpayment_make")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['amt_make_new'];
                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,$MGArray);
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,$MGArray);
                            }
                        }
						if($_REQUEST['sort'] == "vendorpaym_receive")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['amt_receive'];
                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,$MGArray);
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,$MGArray);
                            }
                        }


					
						$unpaid_cnt =0;
						$displayedRow = 1;
						foreach ($MGArray as $MGArraytmp2) {
						?>
							<tr vAlign="center">
							  	<td class="border_left" bgColor="#e4e4e4" class="stylenew" style="width: 10%"><a target="_blank" href ="viewCompany-purchasing.php?ID=<?php echo $MGArraytmp2["cid"]; ?>&proc=View&searchcrit=&show=water-initiatives&rec_type=Manufacturer"><?php echo $MGArraytmp2["comp_nickname"] . "</a>"; ?>
								</td>
								<td class="border_left" bgColor="#e4e4e4" class="stylenew" style="width: 10%"><a target="_blank" href="https://www.ucbzerowaste.com/index.php?txtemail=<?php echo $MGArraytmp2["userName"]; ?>&txtpassword=<?php echo $MGArraytmp2["pwd"]; ?>&redirect=yes">Client WATER Dashboard</a>
								</td>

								<td class="border_right" bgColor="#e4e4e4" align="center"><?php echo $MGArraytmp2["owner"]; ?></td>
								<td class="border_left" bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/viewCompany-purchasing.php?ID=<?php echo $MGArraytmp2["cid"]; ?>&proc=View&searchcrit=&show=water-initiatives&rec_type=Manufacturer" target="_blank">
									<span style='color:red;'>
									<?php echo $MGArraytmp2["past_due_total"]; ?></span></a></td>

								<td bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/viewCompany-purchasing.php?ID=<?php echo $MGArraytmp2["cid"]; ?>&proc=View&searchcrit=&show=water-initiatives&rec_type=Manufacturer" target="_blank">
									<span style='color:blue;'>
									<?php echo $MGArraytmp2["total_active_initiative"]; ?></span>
									</a>
								</td>
								<td class="border_right" bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/viewCompany-purchasing.php?ID=<?php echo $MGArraytmp2["cid"]; ?>&proc=View&searchcrit=&show=water-initiatives&rec_type=Manufacturer" target="_blank">
									<span style='color:green;'><?php echo $MGArraytmp2["completed_initiatives"]; ?></span>
									</a>
								</td>
								<td bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/water_invoice_tracker.php?company_id=<?php echo $MGArraytmp2["cid"]; ?>&account_status_id=83&year_val=<?php echo $MGArraytmp2["selected_yr"]; ?>" target="_blank">
									<?php
									if($MGArraytmp2["count_less_30"]>0){
									?>
										<span style='color:red;'>
									<?php
									}
									else{
									?>
										<span style=''>
									<?php
									}
									echo $MGArraytmp2["count_less_30"]; ?></span></a>
								</td>
								<td bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/water_invoice_tracker.php?company_id=<?php echo $MGArraytmp2["cid"]; ?>&account_status_id=83&year_val=<?php echo $selected_yr; ?>" target="_blank">
									<?php
									if($MGArraytmp2["count_less_30c"]>0){
									?>
										<span style='color:red;'>
									<?php
									}
									else{
									?>
										<span style=''>
									<?php
									}
									echo $MGArraytmp2["count_less_30c"]; ?></span></a></td>
								<td bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/water_invoice_tracker.php?company_id=<?php echo $MGArraytmp2["cid"]; ?>&account_status_id=83&year_val=<?php echo $selected_yr; ?>" target="_blank">
									<?php
									if($MGArraytmp2["count_greater_30"]>0){
									?>
										<span style='color:red;'>
									<?php
									}
									else{
									?>
										<span style=''>
									<?php
									}
									echo $MGArraytmp2["count_greater_30"]; ?></span></a>
								</td>
								<td class="border_right" bgColor="#e4e4e4" align="center">
									<a href="https://loops.usedcardboardboxes.com/water_invoice_tracker.php?company_id=<?php echo $MGArraytmp2["cid"]; ?>&account_status_id=83&year_val=<?php echo $MGArraytmp2["selected_yr"]; ?>" target="_blank">
									<?php
									if($MGArraytmp2["count_greater_30c"]>0){
									?>
										<span style='color:red;'>
									<?php
									}
									else{
									?>
										<span style=''>
									<?php
									}
									echo $MGArraytmp2["count_greater_30c"]; ?></span></a>
								</td>
								<td class="border_right" bgColor="#e4e4e4" align="center">
									<a href="viewCompany-purchasing.php?ID=<?php echo $MGArraytmp2["cid"]; ?>&proc=View&searchcrit=&show=watersalesinvoices&rec_type=Manufacturer" target="_blank">
								<?php echo $MGArraytmp2["unpaid_cnt"]; ?></a>
								</td>
								<td class="border_right" bgColor="#e4e4e4" align="center">$<?php echo number_format($MGArraytmp2["total_profit"], 2); ?>
								</td>
								<td bgColor="#e4e4e4" align="right">
									<!-- <a href="payment_to_make_comp.php?company_id=<?php echo $MGArraytmp2["warehouse_id"]; ?>" target="_blank"><span style='color:red;'><?php echo number_format($MGArraytmp2["amt_make"], 2); ?></span></a> -->
									<a href="UCBZeroWaste_Vendors_AP_AR.php?vendors_dd=All&comp_sel=<?php echo $MGArraytmp2["warehouse_id"]; ?>&ddMadePayment=0" target="_blank">
										<span style='color:red;'>
											<?php //echo number_format($amt_make,2);
echo number_format($MGArraytmp2["amt_make_new"], 2);
?>
									 	</span>
									</a>
								</td>
								<td class="border_right" bgColor="#e4e4e4" align="right">
									<!-- <a href="payment_to_receive_comp.php?company_id=<?php echo $MGArraytmp2["warehouse_id"]; ?>" target="_blank"><span style='color:green;'><?php echo number_format($MGArraytmp2["amt_receive"], 2); ?></span></a>-->
									<a href="UCBZeroWaste_Vendors_AP_AR.php?vendors_dd=All&comp_sel=<?php echo $MGArraytmp2["warehouse_id"]; ?>&ddMadePayment=1" target="_blank"><span style='color:green;'><?php echo number_format($MGArraytmp2["amt_receive"], 2); ?></span></a>
								</td>
							</tr>

							<?php
							   $displayedRow++;

								if($displayedRow > $MGArraytmp2["total_implementation"]){
								?>
									<tr><td colspan="13" align="center" style="color: red; font-size: 12px; "><i>End of Report</i></td></tr>
								<?php
								}
						   }
						}
						?>

				 </table>
			</td>
		</tr>
	</table>
</div>
</body>
</html>