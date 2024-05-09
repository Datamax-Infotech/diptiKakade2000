<?php

ini_set("display_errors", "1");

error_reporting(E_ERROR);
//	require ("inc/header_session.php");
	require ("../mainfunctions/database.php");
	require ("../mainfunctions/general-functions.php");
	db();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>UCBZeroWaste Contracted Clients</title>
	<style>
		.main_table{
			font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif!important; 
			font-size: 13px!important;
		}
		.main_table tr td{
			font-size: 13px!important;
		}
		.style12 a{
			font-size: 13px!important;
			text-decoration: none;
			color: #454545;
			text-align: center;
		}
		
		.data_txt a{
			font-size: 12px!important;
			color: #006600;;
			text-align: center;
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
		
	</style>
	<SCRIPT LANGUAGE="JavaScript" SRC="inc/CalendarPopup.js"></SCRIPT>
	<script LANGUAGE="JavaScript">document.write(getCalendarStyles());</script>

	<script LANGUAGE="JavaScript">
		var cal1xx = new CalendarPopup("listdiv");
		cal1xx.showNavigationDropdowns();

		function showtask(compid)
		{
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
					document.getElementById("light_todo").innerHTML = "<a href='javascript:void(0)' onclick=document.getElementById('light_todo').style.display='none';document.getElementById('fade_todo').style.display='none'>Close</a> &nbsp;<center></center><br/>" + xmlhttp.responseText;
					document.getElementById("light_todo").style.display = 'block';
				}
			}
			
			xmlhttp.open("GET","todolist_view_special_op.php?fromrep=y&compid="+compid,true);
			xmlhttp.send();
		}

		function showtable_pipeline(tablenm, statusid, sort_order_pre, sort) 
		{
			document.getElementById("main_content").innerHTML = "<br/><br/><div align='center'>Loading .....<img src='images/wait_animated.gif' /></div>"; 				

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
				// alert(xmlhttp.responseText);
				document.getElementById("main_content").innerHTML = xmlhttp.responseText; 
			}
			}
			
			

			xmlhttp.open("GET","water_index_load_tables_pipeline_new.php?tablenm="+tablenm + "&sort_order_pre="+sort_order_pre + "&statusid="+statusid + "&sort="+sort,true);			
			xmlhttp.send();		
		}
		
		function update_nextstep(tmpcnt, mainid, empid, statusid, ucbzw_flg){
			if (document.getElementById("txt_nextstep" + tmpcnt).value == "")
			{
				alert("Please enter the Next Step details.");
				return;
			}
			
			document.getElementById("res_div_int" + tmpcnt).style.display = 'block';
			document.getElementById("res_div_int" + tmpcnt).innerHTML = "<br><br>Loading .....<img src='images/wait_animated.gif' />"; 						
			
			var nextstep_data = escape(document.getElementById("txt_nextstep" + tmpcnt).value);
			var nextcomm_data = document.getElementById("txt_nextcomm" + tmpcnt).value;
			var potential_annual_rev_val = document.getElementById("txt_potential_annual_rev" + tmpcnt).value;
			var commodity_indentified =  document.getElementById("txt_commodity_identified" + tmpcnt).value;
			var major_implementation =  document.getElementById("txt_major_implementation" + tmpcnt).value;

			
			var ucbzw_nextstep_data = "";
			var ucbzw_nextcomm_data = "";
			if (ucbzw_flg == 1){
				var ucbzw_nextstep_data = escape(document.getElementById("txt_nextstep_ucbzw" + tmpcnt).value);
				var ucbzw_nextcomm_data = document.getElementById("txt_nextcomm_ucbzw" + tmpcnt).value;
			}

			if (window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
			}else{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("res_div" + tmpcnt).innerHTML = xmlhttp.responseText;
					document.getElementById("res_div_int" + tmpcnt).style.display = 'none';
				}
			}
			xmlhttp.open("GET","water_index_load_tables_pipeline_update.php?companyID=" + mainid + "&ucbzw_flg=" + ucbzw_flg + "&ucbzw_nextstep_data="+ ucbzw_nextstep_data + "&ucbzw_nextcomm_data="+ ucbzw_nextcomm_data + "&txt_nextcomm="+ nextcomm_data + "&txt_nextstep=" + nextstep_data+"&potential_annual_rev_val=" + potential_annual_rev_val + "&commodity_indentified=" +commodity_indentified + "&major_implementation=" + major_implementation + "&empid=" + empid + "&statusid=" + statusid + "&tmpcnt=" + tmpcnt,true);
			xmlhttp.send();		
		}
	</script>

	<LINK rel='stylesheet' type='text/css' href='one_style.css' >
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>
</head>
<body>

<div id="light_todo" class="white_content"></div>
<div id="fade_todo" class="black_overlay"></div>

<?php
	// function encrypt_password(string $txt): string {
	// 	$key = "1sw54@$sa$offj";

	// 	$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
	// 	$iv = openssl_random_pseudo_bytes($ivlen);
	// 	$ciphertext_raw = openssl_encrypt($txt, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
	// 	$hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
	// 	$ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
	// 	return $ciphertext;
	// }

		
	// function getnickname(string $warehouse_name, int $b2bid): string 
	// {
	// 	$nickname = "";
	// 	if ($b2bid > 0) {
	// 		db_b2b();
	// 		$sql = "SELECT nickname, company, shipCity, shipState FROM companyInfo where ID = ?";
	// 		$result_comp = db_query($sql , array("i"), array($b2bid));
	// 		while ($row_comp = array_shift($result_comp)) {
	// 			if ($row_comp["nickname"] != "") {
	// 				$nickname = $row_comp["nickname"];
	// 			} else {
	// 				$tmppos_1 = strpos($row_comp["company"], "-");
	// 				if ($tmppos_1 !== false) {
	// 					$nickname = $row_comp["company"];
	// 				} else {
	// 					if ($row_comp["shipCity"] <> "" || $row_comp["shipState"] <> "") {
	// 						$nickname = $row_comp["company"] . " - " . $row_comp["shipCity"] . ", " . $row_comp["shipState"];
	// 					} else { 
	// 						$nickname = $row_comp["company"]; 
	// 					}
	// 				}
	// 			}
	// 		}
	// 		db();
	// 	} else {
	// 		$nickname = $warehouse_name;
	// 	}
		
	// 	return $nickname;
	// }

	$tablenm = $_REQUEST["tablenm"];
?>
	<div ID="listdiv" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></div>		
	
<?php 
$fromdash_str = "";
if ($_REQUEST["fromdash"] == "yes") {
	$fromdash_str = "fromdash=yes&";
	include("inc/header.php"); 
	echo "<br><br><br><br>";
	echo "<div class='main_data_css'>";
}

$statusid_str = "";
if ($_REQUEST["statusid"] != "") {
	$statusid_str = $_REQUEST["statusid"];
}
?>
	
<?php
	if ($tablenm == "all_inbound"){
		$tbl_array = array("reqnotdelivered","deliveredandnotsorted");
		//$tbl_array = array("reqnotdelivered","deliveredandnotsorted"); ,"sortedandnotpaid"
		
		$count = 0;			
		$arrlength = count($tbl_array); 
		for($arrycnt = 0; $arrycnt < $arrlength; $arrycnt++) 
		{
			showtbls($tbl_array[$arrycnt], "yes", $fromdash_str, $statusid_str);
		}	
	}

	if ($tablenm == "salespipeline")
	{	
		$count = 0;		?>

		<div id="main_content">		
		<?php
			showtbls($tablenm, "no" , $fromdash_str, $statusid_str);
		?>		
		</div><?php
	}


	function showtbls(string $tablenm, string $alltblflg, string $fromdash_str, string $statusid_str): void 
	{
		//
		$imgasc  = '<img src="images/sort_asc.png" width="6px;" height="12px;">';
		$imgdesc = '<img src="images/sort_desc.png" width="6px;" height="12px;">';
		$status = "Select * from status where (sales_flg = 3 and id='".$_REQUEST["statusid"]."')";
		db_b2b();
		$dt_view_res4 = db_query($status);
		$objStatus= array_shift($dt_view_res4);
		$sorturl="water_index_load_tables_pipeline_new.php?tablenm=salespipeline&statusid=" . $statusid_str . "&" . $fromdash_str . "sort_order_pre="; 
		
		?>	
		<form method="post" name="frmSalesPipeline" id="frmSalesPipeline" action="#" >
			<table class="main_table" cellspacing="1" cellpadding="4" width="1000px" align="center">
				<tr>
					<td class="style24" bgcolor="#FF9900" align="middle" colspan="13"><strong><span style="text-transform: uppercase"><?php echo "Sales Pipeline - ".$objStatus["name"];?></span></strong></td>		
				</tr>	
				<tr>
					<td bgcolor="#C0CDDA" class="style12" align="middle"><strong>UCBZeroWaste Account Owner</strong>
						
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'ASC' , 'owner');">	
						<?php echo $imgasc;?></a>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'DESC' , 'owner');"><?php echo $imgdesc;?></a>
					</td>
					<td bgcolor="#C0CDDA" class="style12" align="middle"><strong>UCBZeroWaste Account Status</strong>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'ASC' , 'acctst');"><?php echo $imgasc;?></a>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'DESC' , 'acctst');"><?php echo $imgdesc;?></a>
					</td>
					<td bgcolor="#C0CDDA" class="style12" align="middle" width="250px"><strong>Company</strong>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'ASC' , 'company');">
						<?php echo $imgasc;?></a>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'DESC' , 'company');">
						<?php echo $imgdesc;?></a>
					</td>
					<td bgcolor="#C0CDDA" class="style12" align="middle"><strong>Client Water Dashboard</strong></td>
					<td bgcolor="#C0CDDA" class="style12" align="middle" width="300px"><strong>Next Step Notes</strong></td>
					
					<td bgcolor="#C0CDDA" class="style12" align="middle"><strong>Next Step Due Date</strong>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'ASC' , 'duedate');">
						<?php echo $imgasc;?></a>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'DESC' , 'duedate');"><?php echo $imgdesc;?></a>
					</td>
					
					<td bgcolor="#C0CDDA" class="style12" align="middle"><strong>Tasks</strong>
					</td>

					<td bgcolor="#C0CDDA" class="style12" align="middle"><strong>Gross Savings Opportunity (in USD)</strong>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'ASC' , 'annualsaving');"><?php echo $imgasc;?></a>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'DESC' , 'annualsaving');"><?php echo $imgdesc;?></a>
					</td>
					<td bgcolor="#C0CDDA" class="style12" align="middle"><strong>Client Savings Opportunity (in USD)</strong>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'ASC' , 'clientsaving');"><?php echo $imgasc;?></a>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'DESC' , 'clientsaving');"><?php echo $imgdesc;?></a>
					</td>
					<td bgcolor="#C0CDDA" class="style12" align="middle"><strong>UCBZW Share Opportunity (in USD)</strong>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'ASC' , 'ucbzwshare');"><?php echo $imgasc;?></a>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'DESC' , 'ucbzwshare');"><?php echo $imgdesc;?></a>
					</td>
					<td bgcolor="#C0CDDA" class="style12" align="middle"><strong>Commodities Identified</strong>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'ASC' , 'commodityidentified');"><?php echo $imgasc;?></a>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'DESC' , 'commodityidentified');"><?php echo $imgdesc;?></a>
					</td>
					<td bgcolor="#C0CDDA" class="style12" align="middle"><strong>Major Implementation Changes</strong>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'ASC' , 'majorichanges');"><?php echo $imgasc;?></a>
						<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php echo $objStatus["id"]; ?>', 'DESC' , 'majorichanges');"><?php echo $imgdesc;?></a>
					</td>

					<td bgcolor="#C0CDDA" class="style12" align="middle"><strong>Save</strong></td>
				</tr>
				<?php
					$MGarray = array();
					$eid = $_COOKIE['b2b_id'] ; // this is the b2b.employees ID number, not the loop_employees ID number
					$comp_q1 = "Select * from companyInfo where ucbzw_account_status = '".$_REQUEST["statusid"]."'";
					db_b2b();
					$comp_row1 = db_query($comp_q1);
					while($comp_res1= array_shift($comp_row1)){
						$cnt_no = $cnt_no + 1;
						
						$comp_nickname = get_nickname_val($comp_res1["company"], $comp_res1["ID"]);
						$qassign = "SELECT * FROM employees WHERE status='Active' and employeeID='".$comp_res1["ucbzw_account_owner"]."'";
						db_b2b();
						$dt_view_res_assign = db_query($qassign);
						$res_assign= array_shift($dt_view_res_assign);
						
						$sqlGetZWDt = "SELECT loginid, companyid, user_name, password FROM supplierdashboard_usermaster WHERE companyid=".$comp_res1["ID"]." and activate_deactivate = 1" ;
						//echo $sqlGetZWDt . "<br>";
						db();
						$resGetZWDt = db_query($sqlGetZWDt);
						$arrGetZWDt = array_shift($resGetZWDt);
						$userName = ""; $pwd = "";
						if(!empty($arrGetZWDt)){
							$userName 	= base64_encode($arrGetZWDt['user_name']);
							$pwd  		= base64_encode($arrGetZWDt['password']);	
						}

						$start_ts = strtotime(date('m/d/Y'));
						$end_ts = strtotime($comp_res1["next_date"]);
						$diff = $end_ts - $start_ts;
						$days_diff_today = ($diff / 86400);
						$text_color = "black";
						if ($days_diff_today < 0){ $text_color = "red"; }
						
						$end_ts_ucbzw = strtotime($comp_res1["ucbzw_next_date"]);
						$diff_ucbzw = $end_ts_ucbzw - $start_ts;
						$days_diff_today_ucbzw = ($diff_ucbzw / 86400);
						$text_color_ucbzw = "black";
						if ($days_diff_today_ucbzw < 0){ $text_color_ucbzw = "red"; }
						 
						//
						$percent=40;
						$potential_annual_rev_num = (double)str_replace(array(',','$'), '', $comp_res1["potential_annual_rev"]);

						if ( $potential_annual_rev_num > 0 ) {
						   $potential_annual_share=round(($percent / 100) * $potential_annual_rev_num, 2);
						 } else {
							$potential_annual_share= 0;
						 }
						//
						if ( $potential_annual_rev_num > 0 ) {
							$clientsaving = round((0.6 * $potential_annual_rev_num), 2);
						} else {
							$clientsaving = 0;
						}
						
						$task_qry = "Select * from todolist where companyid = '". $comp_res1["ID"] . "' and status = 1";
						db();
						$oldfollowup = db_query($task_qry);
						$task_due = tep_db_num_rows($oldfollowup);

						$task_qry = "Select * from todolist where companyid = '". $comp_res1["ID"] . "' and status = 1 and due_date = '" . date("Y-m-d") . "'";
						db();
						$oldfollowup = db_query($task_qry);
						$task_due_today = tep_db_num_rows($oldfollowup);

						$task_qry = "Select * from todolist where companyid = '". $comp_res1["ID"] . "' and status = 1 and due_date < '" . date("Y-m-d") . "'";
						db();
						$oldfollowup = db_query($task_qry);
						$task_due_pastdue = tep_db_num_rows($oldfollowup);

						$MGarray[] = array('cnt' => $cnt_no, 'initials' => $res_assign["initials"], 'name' => $objStatus["name"], 'color_ucbzw' => $text_color_ucbzw,
									   'compid' => $comp_res1["ID"], 'compname' => $comp_nickname, 'next_step' => $comp_res1["next_step"],
									   'color' => $text_color, 'next_date' => $comp_res1["next_date"], 'potential_annual_rev' => $comp_res1["potential_annual_rev"],  'clientsaving' => $clientsaving, 'potential_annual_share' => $potential_annual_share, 'commodities_identified' => $comp_res1["commodities_identified"], 'major_implementation' => $comp_res1["major_implementation"],
									    'statusid' => $_REQUEST["statusid"], 'potential_annual_rev_num' => $potential_annual_rev_num, 
										'task_due' => $task_due, 'task_due_today' => $task_due_today, 'task_due_pastdue' => $task_due_pastdue, 
									   'UZWNS' => $comp_res1["ucbzw_next_step"], 'UZWND' => $comp_res1["ucbzw_next_date"], 'ucbzw_flg' => $comp_res1["ucbzw_flg"],
									   'eid' => $eid, 'username' => $userName, 'pwd' => $pwd);
					}
					
					if($_REQUEST['sort'] == "owner")
					{
						$MGArraysort_I = array();

						foreach ($MGarray as $MGArraytmp) {
						$MGArraysort_I[] = $MGArraytmp['initials'];
						}

						if ($_REQUEST['sort_order_pre'] == "ASC"){
							array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGarray); 
						}
						if ($_REQUEST['sort_order_pre'] == "DESC"){
							array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGarray); 
						}
					}
					if($_REQUEST['sort'] == "acctst")
					{
						$MGArraysort_I = array();

						foreach ($MGarray as $MGArraytmp) {
						$MGArraysort_I[] = $MGArraytmp['name'];
						}

						if ($_REQUEST['sort_order_pre'] == "ASC"){
							array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGarray); 
						}
						if ($_REQUEST['sort_order_pre'] == "DESC"){
							array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGarray); 
						}
					}
					if($_REQUEST['sort'] == "company")
					{
						$MGArraysort_I = array();

						foreach ($MGarray as $MGArraytmp) {
						$MGArraysort_I[] = $MGArraytmp['compname'];
						}

						if ($_REQUEST['sort_order_pre'] == "ASC"){
							array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGarray); 
						}
						if ($_REQUEST['sort_order_pre'] == "DESC"){
							array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGarray); 
						}
					}
					if($_REQUEST['sort'] == "duedate")
					{
						$MGArraysort_I = array();

						foreach ($MGarray as $MGArraytmp) {
						$MGArraysort_I[] = $MGArraytmp['next_date'];
						}

						if ($_REQUEST['sort_order_pre'] == "ASC"){
							array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGarray); 
						}
						if ($_REQUEST['sort_order_pre'] == "DESC"){
							array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGarray); 
						}
					}

					if($_REQUEST['sort'] == "annualsaving")
					{
						$MGArraysort_I = array();

						foreach ($MGarray as $MGArraytmp) {
						$MGArraysort_I[] = $MGArraytmp['potential_annual_rev_num'];
						}

						if ($_REQUEST['sort_order_pre'] == "ASC"){
							array_multisort($MGArraysort_I,SORT_ASC,SORT_NUMERIC,$MGarray); 
						}
						if ($_REQUEST['sort_order_pre'] == "DESC"){
							array_multisort($MGArraysort_I,SORT_DESC,SORT_NUMERIC,$MGarray); 
						}
					}

					if($_REQUEST['sort'] == "clientsaving")
					{
						$MGArraysort_I = array();

						foreach ($MGarray as $MGArraytmp) {
						$MGArraysort_I[] = $MGArraytmp['clientsaving'];
						}

						if ($_REQUEST['sort_order_pre'] == "ASC"){
							array_multisort($MGArraysort_I,SORT_ASC,SORT_NUMERIC,$MGarray); 
						}
						if ($_REQUEST['sort_order_pre'] == "DESC"){
							array_multisort($MGArraysort_I,SORT_DESC,SORT_NUMERIC,$MGarray); 
						}
					}

					if($_REQUEST['sort'] == "ucbzwshare")
					{
						$MGArraysort_I = array();

						foreach ($MGarray as $MGArraytmp) {
						$MGArraysort_I[] = $MGArraytmp['potential_annual_share'];
						}

						if ($_REQUEST['sort_order_pre'] == "ASC"){
							array_multisort($MGArraysort_I,SORT_ASC,SORT_NUMERIC,$MGarray); 
						}
						if ($_REQUEST['sort_order_pre'] == "DESC"){
							array_multisort($MGArraysort_I,SORT_DESC,SORT_NUMERIC,$MGarray); 
						}
					}
					
					if($_REQUEST['sort'] == "commodityidentified")
					{
						$MGArraysort_I = array();

						foreach ($MGarray as $MGArraytmp) {
						$MGArraysort_I[] = $MGArraytmp['commodities_identified'];
						}

						if ($_REQUEST['sort_order_pre'] == "ASC"){
							array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGarray); 
						}
						if ($_REQUEST['sort_order_pre'] == "DESC"){
							array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGarray); 
						}
					}

					if($_REQUEST['sort'] == "majorichanges")
					{
						$MGArraysort_I = array();

						foreach ($MGarray as $MGArraytmp) {
						$MGArraysort_I[] = $MGArraytmp['major_implementation'];
						}

						if ($_REQUEST['sort_order_pre'] == "ASC"){
							array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGarray); 
						}
						if ($_REQUEST['sort_order_pre'] == "DESC"){
							array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGarray); 
						}
					}
					
					foreach ($MGarray as $MGArraytmp2) {
				?>
						<tr id="res_div_int<?php echo $MGArraytmp2['cnt'];?>" valign="middle" style="display:none;">
							<td colspan="7">&nbsp;<td>
						</tr>
						<tr id="res_div<?php echo $MGArraytmp2['cnt'];?>" >
							<td bgColor="#e4e4e4" class="data_txt" align="center"><?php echo $MGArraytmp2['initials'];?></td>	
							<td bgColor="#e4e4e4" class="data_txt" align="left" ><?php echo $MGArraytmp2['name'];?></td>	
							<td bgColor="#e4e4e4" class="data_txt" align="left" >
								<a target="_blank" href ="viewCompany.php?ID=<?php echo $MGArraytmp2['compid'];?>"><?php echo $MGArraytmp2['compname'];?></a>
							</td>
							<td bgColor="#e4e4e4" class="data_txt" align="left" >
								<?php if ($MGArraytmp2['username'] != "") {?>
									<a target="_blank" href="https://www.ucbzerowaste.com/index.php?txtemail=<?php echo $MGArraytmp2['username'];?>&txtpassword=<?php echo $MGArraytmp2['pwd'];?>&redirect=yes">Client Water Dashboard</a>
								<?php }else {?>
									&nbsp;	
								<?php }?>
							</td>
							<td bgColor="#e4e4e4" class="data_txt" align="left" >
								<font face="Arial, Helvetica, sans-serif" size="1" >
									UCBoxes Next Step: <textarea type="text" cols="45" rows="3" id="txt_nextstep<?php echo $MGArraytmp2['cnt'];?>" ><?php echo $MGArraytmp2['next_step'];?></textarea>
								</font>
								<?php if($MGArraytmp2["ucbzw_flg"] == 1) { ?>
									<br><font face="Arial, Helvetica, sans-serif" size="1" >UCBZW Next Step: <textarea type="text" cols="45" rows="3" id="txt_nextstep_ucbzw<?php echo $MGArraytmp2['cnt']?>" ><?php echo $MGArraytmp2["UZWNS"]?></textarea></font>
								<?php  } ?>
							</td>	
							<td bgColor="#e4e4e4" class="data_txt" align="left" >
								<font face="Arial, Helvetica, sans-serif" size="1" >
									UCBoxes Next Comm.:<input type="text" style="color:<?php echo $MGArraytmp2['color'];?>" name="txt_nextcomm<?php echo $MGArraytmp2['cnt'];?>" id="txt_nextcomm<?php echo $MGArraytmp2['cnt'];?>" size="10" value="<?if ($MGArraytmp2['next_date'] != "") echo date('m/d/Y',strtotime( $MGArraytmp2['next_date']));?>"/>
								</font>
								<a href="#" onclick="cal1xx.select(document.frmSalesPipeline.txt_nextcomm<?php echo $MGArraytmp2['cnt'];?>,'anchor1xx<?php echo $MGArraytmp2['cnt'];?>','MM/dd/yyyy'); return false;" name="anchor1xx<?php echo $MGArraytmp2['cnt'];?>" id="anchor1xx<?php echo $MGArraytmp2['cnt'];?>">
								<img border="0" src="images/calendar.jpg"></a> 
								
								<?php if ($MGArraytmp2["ucbzw_flg"] == 1) { ?>
									<br>
								<?php
									if($MGArraytmp2["UZWND"]=="" || $MGArraytmp2["UZWND"]=="0000-00-00"){
										$UZWND="";
									}
									else{
										$UZWND=date('m/d/Y',strtotime($MGArraytmp2["UZWND"]));
									}
								?>
							
										<font face="Arial, Helvetica, sans-serif" size="1">
											UCBZW Next Comm.:<input type="text" style="color:<?php echo $MGArraytmp2['color_ucbzw'];?>" name="txt_nextcomm_ucbzw<?php echo $MGArraytmp2['cnt']?>" id="txt_nextcomm_ucbzw<?php echo $MGArraytmp2['cnt']?>" size="10" value="<?php echo $UZWND; ?>"/>
										</font>
										<a href="#" onclick="cal1xx.select(document.frmSalesPipeline.txt_nextcomm_ucbzw<?php echo $MGArraytmp2['cnt']?>,'ucbzw_anchor1xx<?php echo $MGArraytmp2['cnt']?>','MM/dd/yyyy'); return false;" name="ucbzw_anchor1xx<?php echo $MGArraytmp2['cnt']?>" id="ucbzw_anchor1xx<?php echo $MGArraytmp2['cnt']?>">
										<img border="0" src="images/calendar.jpg"></a> 
								<?php } ?>
								
							</td>
							
							<td bgColor="#e4e4e4" class="data_txt" align="center">
								<a href="#" onclick="showtask(<?php echo $MGArraytmp2["compid"]?>)"><?php echo "<font color=red>" . $MGArraytmp2["task_due_pastdue"] . "</font>,<font color=#4b9952>" . $MGArraytmp2["task_due_today"] . "</font>,<font color=black>" . $MGArraytmp2["task_due"] . "</font>"; ?></a>
							</td>
							
							<td bgColor="#e4e4e4" class="data_txt" align="left"><input type="text" size="10" id="txt_potential_annual_rev<?php echo $MGArraytmp2['cnt']?>" value="<?php 
							if (is_numeric($MGArraytmp2["potential_annual_rev"])){
								$potential_annual_rev_tmp = (double)str_replace(array(',','$'), '', $MGArraytmp2["potential_annual_rev"]);
								echo "$" . number_format($potential_annual_rev_tmp,2);
							}else{
								$potential_annual_rev_tmp = $MGArraytmp2["potential_annual_rev"];
								echo $potential_annual_rev_tmp;
							}								
							?>" /></td>
							
							<td bgColor="#e4e4e4" class="data_txt" align="left">
								$<?php echo number_format($MGArraytmp2['clientsaving'],2); ?></td>

							<td bgColor="#e4e4e4" class="data_txt" align="left">
								$<?php echo number_format($MGArraytmp2['potential_annual_share'],2); ?></td>
							
							<td bgColor="#e4e4e4" class="data_txt" align="left">
								<textarea type="text" cols="10" rows="3" id="txt_commodity_identified<?php echo $MGArraytmp2['cnt'];?>" ><?php echo $MGArraytmp2['commodities_identified'];?></textarea>
							</td>

							<td bgColor="#e4e4e4" class="data_txt" align="left">
								<textarea type="text" cols="10" rows="3" id="txt_major_implementation<?php echo $MGArraytmp2['cnt'];?>" ><?php echo $MGArraytmp2['major_implementation'];?></textarea>
							</td>

							<td bgColor="#e4e4e4" class="data_txt" align="left" >
								<input style="cursor:pointer;" type="button" onclick="update_nextstep(<?php echo $MGArraytmp2['cnt'];?>,<?php echo $MGArraytmp2['compid'];?>,<?php echo $MGArraytmp2['eid'];?>,<?php echo $MGArraytmp2['statusid'];?>, <?php echo $MGArraytmp2["ucbzw_flg"];?>);" value="Save"/> 
							</td>	
						</tr>
				<?php
					//major_implementation  commodities_identified
					}
				?>
			</table>
			<div ID="listdiv" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></div>
		</form>	
        <?php
	}
?>

<?php 
if ($_REQUEST["fromdash"] == "yes") {
	echo "</div>";
}
?>
</body>