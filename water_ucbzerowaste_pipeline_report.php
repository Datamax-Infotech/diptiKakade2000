<?php
session_start();

//require ("inc/header_session.php");
require ("../mainfunctions/database.php");
require ("../mainfunctions/general-functions.php");

$chkinitials =  $_COOKIE['userinitials'];
?>

<html>
<head>
<title>UCBZeroWaste Pipeline</title>
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
		<div style="float: left;">UCBZeroWaste Pipeline</div>
		&nbsp;<!--<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
		<span class="tooltiptext">
			This report shows the user all of the biggest companies in each industry that we sell to, so that when we go to sell to other companies in that industry, we can drop the names of the big ones.
		</span></div>-->
		
		<div style="height: 13px;">&nbsp;</div>				
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
	

<form action="water_ucbzerowaste_pipeline_report.php" method="get">

	<div ><i>Note: Please wait until you see <font color="red">"END OF REPORT"</font> at the bottom of the report, before using the sort option.</i></div>
	<table width="100%" border="0" cellspacing="2" cellpadding="2" bgcolor="#E4E4E4">
		<tr align="left">
			<td colspan="2" bgcolor="#C0CDDA"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">
				UCBZeroWaste Account Manager:
				<?php
				$matchStr2= "Select employeeID, name from employees order by name";
				db_b2b();
				$res = db_query($matchStr2);
				?>
				<select name="emp_id" id="emp_id">
					<option value=''>Select All</option>
					<?php
					while ($objInvmatch = array_shift($res)) {
						
						if ($objInvmatch["employeeID"] == $_REQUEST["emp_id"]) {
								echo "<option value=" . $objInvmatch["employeeID"] . " Selected >";
						}else{		
							echo "<option value=" . $objInvmatch["employeeID"] . " >";
						}
						echo $objInvmatch["name"];
						echo "</option>";
					}
					?>
				</select>
				&nbsp;&nbsp;
				
				UCBZeroWaste Account Status:
				<?php
				$matchStr2= "Select id, name from status where sales_flg = 3 order by sort_order";
				db_b2b();
				$res = db_query($matchStr2);
				$cnt_seq = 1;
				?>
				<select name="ucbzw_account_status" id="ucbzw_account_status">
					<option value=''>Select All</option>
					<?php
					while ($objInvmatch = array_shift($res)) {
						
						if ($objInvmatch["id"] == $_REQUEST["ucbzw_account_status"]) {
								echo "<option value=" . $objInvmatch["id"] . " Selected >";
						}else{		
							echo "<option value=" . $objInvmatch["id"] . " >";
						}
						echo $cnt_seq . ". " . $objInvmatch["name"];
						echo "</option>";
						
						$cnt_seq = $cnt_seq + 1;
					}
					?>
				</select>
				
				</font>
			</td>
		</tr>

		<tr>
			<td>
				<input type="submit" id="btnsubmit" name="btnsubmit" value="Find Matches">
			</td>
		</tr>
	</table>
</form>

	<br>
		<?php
		$sorturl="water_ucbzerowaste_pipeline_report.php?company_id=".$_REQUEST["company_id"]."&initiative_status=".$_REQUEST["initiative_status"]."&emp_id=".$_REQUEST["emp_id"];
		
		?>
	<table width="1200px" border="0" cellspacing="2" cellpadding="2" bgcolor="#E4E4E4" id="table" class="sortable">
		<thead>
			<tr>
				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
					<strong>Company</strong>
					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=company"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=company"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
					
				</th>
				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
					<strong>UCBZW Account Owner</strong>
					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=rep"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=rep"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
				</th>
				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
					<strong>UCBZW Account Status</strong>
					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=initiative_status"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=initiative_status"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
				</th>
				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
					<strong>Last Account Status update</strong>
					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=last_account_status"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=last_account_status"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
				</th>
				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
					<strong>UCBZW Previous account Status</strong>
					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=prev_acc_status"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=prev_acc_status"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
				</th>
				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
					<strong>Gross Savings Opportunity (in U$)</strong>
					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=gross_saving"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=gross_saving"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
				</th>
				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
					<strong>Client Savings Opportunity (in U$)</strong>
					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=client_saving"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=client_saving"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
				</th>
				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
					<strong>UCBZW Share Opportunity (in U$)</strong>
					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=ucbzw_share"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=ucbzw_share"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
				</th>
				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
					<strong>Commodities Identified</strong>
					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=commodities"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=commodities"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
				</th>
				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">
					<strong>Major Implementation Changes</strong>
					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=majorichange"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=majorichange"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
				</th>
				
			</tr>
		</thead>
		<tbody>
		<?php
		if (isset($_REQUEST["sort"])) {
			$MGArray = $_SESSION['sortarrayn'];

			if($_GET['sort'] == "company")
			{
				$MGArraysort_I = array();
				foreach ($MGArray as $MGArraytmp) {
					$MGArraysort_I[] = $MGArraytmp['company'];
					
				}
				if ($_GET['sort_order_pre'] == "ASC") {
					array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 
					
				}
				if ($_GET['sort_order_pre'] == "DESC") {
					array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 
				}
			}
			if($_GET['sort'] == "rep")
			{
				$MGArraysort_I = array();
				foreach ($MGArray as $MGArraytmp) {
					$MGArraysort_I[] = $MGArraytmp['empname'];
					
				}
				if ($_GET['sort_order_pre'] == "ASC") {
					array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 
					
				}
				if ($_GET['sort_order_pre'] == "DESC") {
					array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 
				}
			}
			if($_GET['sort'] == "initiative_status")
			{
				$MGArraysort_I = array();
				foreach ($MGArray as $MGArraytmp) {
					$MGArraysort_I[] = $MGArraytmp['acc_status'];
					
				}
				if ($_GET['sort_order_pre'] == "ASC") {
					array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 
					
				}
				if ($_GET['sort_order_pre'] == "DESC") {
					array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 
				}
			}

			if($_GET['sort'] == "last_account_status")
			{
				$MGArraysort_I = array();
				foreach ($MGArray as $MGArraytmp) {
					$MGArraysort_I[] = $MGArraytmp['last_account_status'];
					
				}
				if ($_GET['sort_order_pre'] == "ASC") {
					array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 
					
				}
				if ($_GET['sort_order_pre'] == "DESC") {
					array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 
				}
			}

			if($_GET['sort'] == "prev_acc_status")
			{
				$MGArraysort_I = array();
				foreach ($MGArray as $MGArraytmp) {
					$MGArraysort_I[] = $MGArraytmp['prev_account_status'];
					
				}
				if ($_GET['sort_order_pre'] == "ASC") {
					array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 
					
				}
				if ($_GET['sort_order_pre'] == "DESC") {
					array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 
				}
			}
			
			if($_GET['sort'] == "gross_saving")
			{
				$MGArraysort_I = array();
				foreach ($MGArray as $MGArraytmp) {
					$MGArraysort_I[] = $MGArraytmp['gross_saving'];
					
				}
				if ($_GET['sort_order_pre'] == "ASC") {
					array_multisort($MGArraysort_I,SORT_ASC,SORT_NUMERIC,$MGArray); 
					
				}
				if ($_GET['sort_order_pre'] == "DESC") {
					array_multisort($MGArraysort_I,SORT_DESC,SORT_NUMERIC,$MGArray); 
				}
			}

			if($_GET['sort'] == "client_saving")
			{
				$MGArraysort_I = array();
				foreach ($MGArray as $MGArraytmp) {
					$MGArraysort_I[] = $MGArraytmp['client_saving'];
					
				}
				if ($_GET['sort_order_pre'] == "ASC") {
					array_multisort($MGArraysort_I,SORT_ASC,SORT_NUMERIC,$MGArray); 
					
				}
				if ($_GET['sort_order_pre'] == "DESC") {
					array_multisort($MGArraysort_I,SORT_DESC,SORT_NUMERIC,$MGArray); 
				}
			}
			
			if($_GET['sort'] == "ucbzw_share")
			{
				$MGArraysort_I = array();
				foreach ($MGArray as $MGArraytmp) {
					$MGArraysort_I[] = $MGArraytmp['ucbzw_share'];
					
				}
				if ($_GET['sort_order_pre'] == "ASC") {
					array_multisort($MGArraysort_I,SORT_ASC,SORT_NUMERIC,$MGArray); 
					
				}
				if ($_GET['sort_order_pre'] == "DESC") {
					array_multisort($MGArraysort_I,SORT_DESC,SORT_NUMERIC,$MGArray); 
				}
			}

			if($_GET['sort'] == "commodities")
			{
				$MGArraysort_I = array();
				foreach ($MGArray as $MGArraytmp) {
					$MGArraysort_I[] = $MGArraytmp['commodities'];
					
				}
				if ($_GET['sort_order_pre'] == "ASC") {
					array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 
					
				}
				if ($_GET['sort_order_pre'] == "DESC") {
					array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 
				}
			}

			if($_GET['sort'] == "majorichange")
			{
				$MGArraysort_I = array();
				foreach ($MGArray as $MGArraytmp) {
					$MGArraysort_I[] = $MGArraytmp['majorichange'];
					
				}
				if ($_GET['sort_order_pre'] == "ASC") {
					array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 
					
				}
				if ($_GET['sort_order_pre'] == "DESC") {
					array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 
				}
			}

			foreach ($MGArray as $MGArraytmp2) {
		?>
			<tr>
				<td bgColor="#E4EAEB" class="style12" align="left">		
					<a target="_blank" href="viewCompany.php?ID=<?php echo $MGArraytmp2["companyid"];?> target="_blank"><?php echo $MGArraytmp2["company"];?></a>
				</td>
				<td bgColor="#E4EAEB" class="style12" align="left">
					<?php echo $MGArraytmp2["empname"]; ?>
				</td>
				<td bgColor="#E4EAEB" class="style12" align="left">
					<?php echo $MGArraytmp2["acc_status"]; ?>
				</td>
				<td bgColor="#E4EAEB" class="style12" align="left">
					<?php echo $MGArraytmp2["last_account_status"]; ?>
				</td>
				<td bgColor="#E4EAEB" class="style12" align="left">
					<?php echo $MGArraytmp2["prev_account_status"]; ?>
				</td>
				<td bgColor="#E4EAEB" class="style12" align="left">		
					<?php echo $MGArraytmp2["gross_saving"];?>
				</td>
				<td bgColor="#E4EAEB" class="style12" align="left">
					<?php echo $MGArraytmp2["client_saving"]; ?>
				</td>
				<td bgColor="#E4EAEB" class="style12" align="left">
					<?php echo $MGArraytmp2["ucbzw_share"]; ?>
				</td>
				<td bgColor="#E4EAEB" class="style12" align="left">
					<?php echo $MGArraytmp2["commodities"]; ?>
				</td>
				<td bgColor="#E4EAEB" class="style12" align="left">
					<?php echo $MGArraytmp2["majorichange"]; ?>
				</td>

			</tr>		
		<?php
			}
	}else{
		
		if (isset($_REQUEST["btnsubmit"]))
		{
			
			$emp_str = "";
			if ($_REQUEST["emp_id"] != "")
			{
				$emp_str = " and ucbzw_account_owner = " . $_REQUEST["emp_id"];
			}				
			$acc_status = "";
			if ($_REQUEST["ucbzw_account_status"] != "")
			{
				$acc_status = " and ucbzw_account_status = " . $_REQUEST["ucbzw_account_status"];
			}				
			
			$matchStr2 = "Select *, employees.name as empname, status.name as statusname from companyInfo left join employees on employees.employeeID = companyInfo.ucbzw_account_owner left join status on status.id = companyInfo.ucbzw_account_status where ucbzw_flg = 1 and active = 1 " . $emp_str . " ". $acc_status . " order by company";
			//echo $matchStr2;
			db_b2b();
			$res = db_query($matchStr2);
			while ($objInvmatch = array_shift($res)) {
					
					db_b2b();
					$prev_account_status = "Non WATER Opportunity<br>"; $last_account_status = "Non WATER Opportunity<br>";
					$sql = "SELECT * FROM company_status_history_ucbwz where companyID = ? order by unqid" ;
					$result = db_query($sql , array("i"), array($objInvmatch["ID"]));
					while ($myrowsel = array_shift($result)) {
						$last_account_status = date("m/d/Y", strtotime($myrowsel["changed_on"])) . " CT";
						
						$prev_account_status .= "<br>" . $myrowsel["status_value"] . "<br>";
					}

					$percent=40; 
					$potential_annual_rev_num = "";
					$potential_annual_rev_num = (double)str_replace(array(',','$'), '', $objInvmatch["potential_annual_rev"]);

					if ( $potential_annual_rev_num > 0 ) {
					   $clientsaving = round((0.6 * $potential_annual_rev_num), 2);
					   $potential_annual_share=round(($percent / 100) * $potential_annual_rev_num, 2);
					   
					 } else {
						$clientsaving = 0;
						$potential_annual_share= 0;
						
					 }
					
					
			?>

				<tr>
					<td bgColor="#E4EAEB" class="style12" align="left">		
						<a target="_blank" href="viewCompany.php?ID=<?php echo $objInvmatch["ID"];?>" target="_blank"><?php echo get_nickname_val($objInvmatch["company"] , $objInvmatch["ID"]);
							$nickname=get_nickname_val($objInvmatch["company"] , $objInvmatch["ID"]);
							?></a>
					</td>
					<td bgColor="#E4EAEB" class="style12" align="left">
						<?php echo $objInvmatch["empname"]; ?>
					</td>
					<td bgColor="#E4EAEB" class="style12" align="left">
						<?php echo $objInvmatch["statusname"]; ?>
					</td>
					<td bgColor="#E4EAEB" class="style12" align="left" >
						<?php echo $last_account_status; ?>
					</td>
					<td bgColor="#E4EAEB" class="style12" align="left">
						<?php echo $prev_account_status; ?>
					</td>
					<td bgColor="#E4EAEB" class="style12" align="left">		
						<?php echo $potential_annual_rev_num; ?>
					</td>
					<td bgColor="#E4EAEB" class="style12" align="left">
						<?php echo $clientsaving; ?>
					</td>
					<td bgColor="#E4EAEB" class="style12" align="left">
						<?php echo $potential_annual_share; ?>
					</td>
					<td bgColor="#E4EAEB" class="style12" align="left" >
						<?php echo $objInvmatch["commodities_identified"]; ?>
					</td>
					<td bgColor="#E4EAEB" class="style12" align="left">
						<?php echo $objInvmatch["major_implementation"]; ?>
					</td>
				</tr>		
			<?php
				$MGArray[] = array('companyid' => $objInvmatch["ID"], 'company' => $nickname, 'empname' => $objInvmatch["empname"], 'gross_saving' => $potential_annual_rev_num, 'client_saving' => $clientsaving, 'ucbzw_share' => $potential_annual_share, 'commodities' => $objInvmatch["commodities_identified"], 'majorichange' => $objInvmatch["major_implementation"],
				'prev_account_status' => $prev_account_status, 'last_account_status' => $last_account_status, 'acc_status' => $objInvmatch["statusname"]); 
			
				$_SESSION['sortarrayn'] = $MGArray;
			}
		
		}

	  }
  ?>
	  
	  
	</tbody>  
	</table>
	<div ><i><font color="red">"END OF REPORT"</font></i></div>
<?php
   

?>
</body>
</html>