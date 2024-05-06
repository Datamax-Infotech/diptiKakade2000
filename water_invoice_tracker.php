<?php
session_start();

//require ("inc/header_session.php");
require ("../mainfunctions/database.php");
require ("../mainfunctions/general-functions.php");

$chkinitials =  $_COOKIE['userinitials'];
?>

<html>
<head>
<title>UCBZeroWaste Invoice Tracker</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="sorter/style.css" />
	
	<LINK rel='stylesheet' type='text/css' href='one_style.css' >
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>
</head>

<body bgcolor="#FFFFFF" text="#333333" link="#333333" vlink="#666666" alink="#333333">
<?php include("inc/header.php"); ?>

<div class="main_data_css">
	<div class="dashboard_heading" style="float: left;">
		<div style="float: left;">UCBZeroWaste Invoice Tracker
		<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
		<span class="tooltiptext">
			UCBZeroWaste Invoice Tracker.
		</span></div>
		
		<div style="height: 13px;">&nbsp;</div>				
		</div>	
	</div>
<table border="0" width="80%" cellspacing="0" cellpadding="5">
  <tr>

    <td  valign="top">

<?php
	$sort_order_pre = "ASC";
	if($_GET['sort_order_pre'] == "ASC")
	{
		$sort_order_pre = "DESC";
	}else{
		$sort_order_pre = "ASC";
	}

?>
	
<form action="water_invoice_tracker.php" method="get">

	<table width="100%" border="0" cellspacing="2" cellpadding="2" bgcolor="#E4E4E4">
		<tr align="left">
			<td bgcolor="#C0CDDA"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				Company:
				<?php
				//$matchStr2= "Select id, b2bid, company_name as company from loop_warehouse inner join water_initiatives on water_initiatives.companyid = loop_warehouse.b2bid where rec_type= 'Manufacturer' and Active = 1 group by loop_warehouse.b2bid order by company_name";
				$matchStr2= "Select ID, company from companyInfo where active = 1 and ucbzw_flg = 1 order by company";
				db_b2b();
				$res = db_query($matchStr2);
				?>
				<select name="company_id" id="company_id">
					<option value='All'>Select All</option>
					<?php
					while ($objInvmatch = array_shift($res)) {
						
						if ($objInvmatch["ID"] == $_REQUEST["company_id"]) {
								echo "<option value=" . $objInvmatch["ID"] . " Selected >";
						}else{		
							echo "<option value=" . $objInvmatch["ID"] . " >";
						}
						echo get_nickname_val($objInvmatch["company"], $objInvmatch["ID"]);
						echo "</option>";
					}
					?>
				</select>
				</font>
			</td>
			<td bgcolor="#C0CDDA">OR</td>
			<td bgcolor="#C0CDDA"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				UCBZeroWaste Account Status:
				<?php
				$matchStr2= "Select id, name from status where sales_flg = 3 order by sort_order";
				db_b2b();
				$res = db_query($matchStr2);
				?>
				<select name="account_status_id" id="account_status_id">
					<option value='All'>Select All</option>
					<?php
					while ($objInvmatch = array_shift($res)) {
						
						if ($objInvmatch["id"] == $_REQUEST["account_status_id"]) {
								echo "<option value=" . $objInvmatch["id"] . " Selected >";
						}else{		
							echo "<option value=" . $objInvmatch["id"] . " >";
						}
						echo $objInvmatch["name"];
						echo "</option>";
					}
					?>
				</select>
				</font>
			</td>
			<td bgcolor="#C0CDDA">Select Year:</td>
			<td bgcolor="#C0CDDA">
				<select name="year_val" id="year_val"><option>Please Select</option>
					<?php 
						for ($year_cnt = date("Y")-4; $year_cnt <= date("Y"); $year_cnt++) {
					?>
							<option value="<?php echo $year_cnt; ?>" <?php if ($year_cnt==$_REQUEST["year_val"]) echo " selected "; ?>><?php echo $year_cnt; ?></option>
					<?php } ?>
				</select>				
			</td>

			<td bgcolor="#C0CDDA" >
				<input type="submit" id="btnsubmit" value="Invoice Tracker">
			</td>
		</tr>
	</table>
</form>
	
	<?php
		if ($_REQUEST["company_id"] != "")
		{
			$sql_acc_status = "";
			if (($_REQUEST["account_status_id"] != "All")){
				$sql_acc_status = " and ucbzw_account_status = '" . $_REQUEST["account_status_id"] . "'" ;
			}
		
			db_b2b();
			if (($_REQUEST["company_id"] == "All")){
				$sql1 = "SELECT ID, loopid,nickname, company, parent_child, ucbzw_account_status from companyInfo WHERE haveNeed = 'Have Boxes' and ucbzw_flg = 1 $sql_acc_status order by nickname ASC" ;
			}else{
				$sql1 = "SELECT ID, loopid,nickname, company, parent_child, ucbzw_account_status from companyInfo WHERE haveNeed = 'Have Boxes' $sql_acc_status and ID = " . $_REQUEST["company_id"] . " order by nickname ASC";
			}
			
			$selected_yr = $_REQUEST["year_val"];
			if ($selected_yr == date("Y")){
				$selected_month = Date("m")-1;
			}else{
				$selected_month = 12;
			}				
			
			$count_less_30_tot = 0; $count_greater_30_tot = 0;
			
			$result1 = db_query($sql1);
			while ($myrowsel1 = array_shift($result1)) {
				db_b2b();
				$company_acc_status = "";
				$w1 = "Select name from status WHERE id = '" . $myrowsel1["ucbzw_account_status"] . "'";
				$w_res1 = db_query($w1);
				while ($row1 = array_shift($w_res1)) {
					$company_acc_status = $row1["name"];
				}

				$warehouse_id = $myrowsel1["loopid"];
				$cmp_id=$myrowsel1["ID"];
				//$company_name = get_nickname_val($myrowsel1["company"], $myrowsel1["ID"]);
				$company_name = $myrowsel1["nickname"];
				db();
		?>

		<div >
			
		<table cellspacing="2" cellpadding="2" border="0" bgcolor="#E4E4E4">
		  <tbody>
			  <tr>
				 <td bgcolor="#C0CDDA" colspan="17" class="colunm1_left">
				 <a href="viewCompany.php?ID=<?php echo $cmp_id;?>" target="_blank">
				 <?php echo $company_name;?></a> </td> 
			  </tr>
			  <tr>
				 <td bgcolor="#C0CDDA" colspan="17" class="colunm1_left">
				 <?php echo $company_acc_status;?></td> 
			  </tr>
			  
			<tr>
			  <td bgcolor="#C0CDDA" width="15%" rowspan="2" class="colunm1">Vendor</td>
			  <td bgcolor="#C0CDDA" width="15%" rowspan="2" class="colunm2">Description</td>
			  <td bgcolor="#C0CDDA" colspan="14" class="colunm3">Invoices</td>
			  </tr>
			<tr>
				<?php 
				   for ($i=1, $n=12; $i<=$n; $i++) 
				   {
					?>
						<td bgcolor="#C0CDDA" width="5%" ><?php echo date("M", mktime(0, 0, 0, $i, 10)) . " " . $selected_yr;?></td>
				<?php 	
				} 
				?>	
			</tr>
			<?php
				$query_mtd1 = "(SELECT water_vendors.Name, water_vendors.description, water_vendors.id as vendor from water_comp_vendor_list inner join water_vendors on water_vendors.id = water_comp_vendor_list.vendor_id
				WHERE comp_id = " . $warehouse_id . " and water_vendors.Name <> '' group by water_vendors.id ORDER BY water_vendors.Name) order by Name";
				
				$data_no_printed = "n"; $count_less_30 = 0; $count_greater_30 = 0;
				//echo $query_mtd1 . "<br>";
				$res1 = db_query($query_mtd1);
				while($row_vendor = array_shift($res1))
				{
					$vender_nm = $row_vendor['Name'];

					$main_material = $row_vendor['description'];
					
				?>
					<tr>
						<td bgcolor="#f2f2f2"><?php echo $vender_nm; ?></td>
						<td bgcolor="#f2f2f2"><?php echo $main_material; ?></td>
					<?php
						for ($month_cnt=1, $n=$selected_month; $month_cnt<=$n; $month_cnt++) {
							$data_no_printed = "y";
							$query = "SELECT company_id, have_doubt, doubt, no_invoice_due_flg from water_transaction where company_id = " . $warehouse_id . " and vendor_id = " . $row_vendor['vendor'] . " and Month(invoice_date) = " . $month_cnt . " and Year(invoice_date) = " . $selected_yr;
							//echo $query . "<br>";
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
								?>
									<td bgcolor="#f2f2f2" class='colunm4' ><img src="images/icon-03.jpg" /></td>													
								<?php
								}else{?>
									<td bgcolor="#f2f2f2" class='colunm4' ><img src="images/icon-01.jpg" /></td>													
								<?php }
							}else{
								if ($no_invoice_due_flg != "yes"){
									if ($n == $month_cnt){
										$count_less_30 = $count_less_30 + 1; 
										
									}else{	
										$count_greater_30 = $count_greater_30 + 1;
									}	
							?>
								<td bgcolor="#f2f2f2" class='colunm4' ><img src="images/icon-02.jpg" /></td>													
							<?php
								}else{
							?>
									<td bgcolor="#f2f2f2" class='colunm4' ><img src="images/grayout.jpg" /></td>													
							<?php
								}
							}
						}
					?>
					<?php
						for ($month_cnt=$selected_month, $n=12; $month_cnt<$n; $month_cnt++) {
							?>
								<td bgcolor="#f2f2f2" class='colunm4' ><img src="images/grayout.jpg" /></a></td>													
							<?php
						}
					?>
					</tr>
					<?php
				}
				
				$data_foun_ucb_firstrec = "no"; $str_rep = ""; $data_no_printed_loop = "n";
				?>
					<?php
						for ($month_cnt=1, $n=12; $month_cnt<=$n; $month_cnt++) {
							if ($month_cnt > $selected_month) {
								$str_rep .= "<td bgcolor='#f2f2f2' class='colunm4' ><img src='images/grayout.jpg' /></td>";
							}else{
								/*$query = "SELECT loop_boxes.vendor, loop_boxes.bdescription from loop_boxes_sort inner join loop_transaction on loop_transaction.id = loop_boxes_sort.trans_rec_id  ";
								$query .= " inner join loop_boxes on loop_boxes.id = loop_boxes_sort.box_id  ";
								$query .= " WHERE loop_transaction.warehouse_id = " . $warehouse_id . " and sort_entered = 1 and year(pr_requestdate_php) = '" . $selected_yr ."' and month(pr_requestdate_php) = " . $month_cnt ." ";
								*/

								$query = "SELECT loop_transaction.id from loop_transaction ";
								$query .= " WHERE loop_transaction.warehouse_id = " . $warehouse_id . " and sort_entered = 1 and DATE_FORMAT(STR_TO_DATE(loop_transaction.pa_pickupdate, '%m/%d/%Y'), '%Y') = " . $selected_yr ." and DATE_FORMAT(STR_TO_DATE(loop_transaction.pa_pickupdate, '%m/%d/%Y'), '%m') = " . $month_cnt ." ";
								//echo $query . "<br>";
								$res = db_query($query);
								$rec_found = "no";
								while($row = array_shift($res))
								{
									$rec_found = "yes";
								}
								
								$data_no_printed_loop = "y";
								
								if ($rec_found == "yes") 
								{
									if ($data_foun_ucb_firstrec == "no"){
										$data_foun_ucb_firstrec = "yes";
									}
									$str_rep .= "<td bgcolor='#f2f2f2' class='colunm4' ><img src='images/icon-01.jpg' /></td>";
								}else{
									$str_rep .= "<td bgcolor='#f2f2f2' class='colunm4' ><img src='images/icon-02.jpg' /></td>";
								}
							}	
						}
						echo "<tr><td bgcolor='#f2f2f2'>UsedCardBoardBoxes</td><td bgcolor='#f2f2f2'>Boxes</td>" . $str_rep . "</tr>";
					//}
					
					if ($data_no_printed == "y"){
				?>
					  <tr>
						 <td bgcolor="#C0CDDA" colspan="17" class="colunm1_left">
							Current Month Entries Missing: <?php echo $count_less_30;?>
							Previous Months Entries Missing: <?php echo $count_greater_30;?>
						</td> 
					</tr>
				<?php
					$count_less_30_tot = $count_less_30_tot + $count_less_30; 
					$count_greater_30_tot = $count_greater_30_tot + $count_greater_30; 
				
					} ?>
					
			</tbody>
		</table>
		
		
	</div>
<br><br>
	<?php } ?>
	
		<table>
			<tr>
				<td colspan="2" bgcolor="#C0CDDA" class="colunm1_left">
					<b>Summary Table - Count for all Company Records Above</b>
				</td> 
			</tr>
			<tr>
				<td bgcolor="#C0CDDA" class="colunm1_left">
					Total - Current Month Entries Missing:
				</td> 
				<td bgcolor="#C0CDDA" class="colunm1_left">	
					<?php echo $count_less_30_tot;?>
				</td> 
			</tr>
			<tr>
				<td bgcolor="#C0CDDA" class="colunm1_left">
					Total - Previous Months Entries Missing:
				</td> 
				<td bgcolor="#C0CDDA" class="colunm1_left">
					<?php echo $count_greater_30_tot;?>
				</td> 
			</tr>
		</table>
	
<?php }?>		

</body>
</html>