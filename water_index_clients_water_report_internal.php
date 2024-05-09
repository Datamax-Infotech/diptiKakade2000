<?php


session_start();
if(!$_COOKIE['userloggedin']){
header("location:login.php");
}
 
//require ("inc/header_session.php");
require ("../mainfunctions/database.php");
require ("../mainfunctions/general-functions.php");

?>

<!DOCTYPE html>

<html>

<head>
	<title>Clients WATER Dashboards <?php echo "Logged in as : " . $_COOKIE['userinitials']; ?></title>
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
<?php include("inc/header.php"); ?>
<div class="main_data_css">
	<div class="dashboard_heading" style="float: left;">
		<div style="float: left;">WATER Dashboards Login Credentials List
		<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
		<span class="tooltiptext">
			UCB Zero Waste WATER Dashboards Login Credentials List
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
							$main_sql = "Select company_id, loop_warehouse.company_name, loop_warehouse.b2bid, count(*) as cnt from 
										water_transaction inner join loop_warehouse on loop_warehouse.id = water_transaction.company_id where 
										loop_warehouse.rec_type = 'Manufacturer' group by company_id";
										
							$data_res = db_query($main_sql);
							$total_rows=tep_db_num_rows($data_res);
						  ?>
						  <strong><span style="text-transform: uppercase">
							  Clients WATER Dashboards</span> (<?php echo $total_rows; ?> records found)
						</strong>
						</td>
					</tr>
					<?php
						$sorturl="water_index_clients_water_report_internal.php?w=wt";
					?>
					<tr>
						<th class="border_left" bgcolor="#C0CDDA" width="230px">COMPANY NAME &nbsp;
							<a href="<?php echo $sorturl;?>&sort_order_pre=ASC&sort=comp_name"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;
							<a href="<?php echo $sorturl;?>&sort_order_pre=DESC&sort=comp_name"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
						</th>
						<th bgcolor="#C0CDDA">Client WATER<br> Dashboard</th>
						<th bgcolor="#C0CDDA">Number of WATER <br>Transactions Entries &nbsp;
							<a href="<?php echo $sorturl;?>&sort_order_pre=ASC&sort=count"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;
							<a href="<?php echo $sorturl;?>&sort_order_pre=DESC&sort=count"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
						</th>
						<th bgcolor="#C0CDDA">Next Communication</th>
						<th bgcolor="#C0CDDA" width="30%">Next Step</th>
						<th bgcolor="#C0CDDA">Assigned To
							<a href="<?php echo $sorturl;?>&sort_order_pre=ASC&sort=assignto"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;
							<a href="<?php echo $sorturl;?>&sort_order_pre=DESC&sort=assignto"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>
						</th>
						<th bgcolor="#C0CDDA">Back-end User login</font></th>
						<th bgcolor="#C0CDDA">Back-end Password</font></th>
					</tr>
						<?php
					    if (!isset($_REQUEST["sort"])){ 
                        $MGArray_data = array();
						$displayedRow = 1;
						while ($data = array_shift($data_res)) {
							$comp_nickname = get_nickname_val($data["company_name"], $data["b2bid"]);
														
							db_b2b();
							$next_step = ""; $assignedto = ""; $next_comm = ""; $last_comm = "";
							$data_comp = db_query("Select assignedto, next_step, next_date, last_contact_date from companyInfo where ID = ".  $data["b2bid"]);
							while ($data_comp_res = array_shift($data_comp)) {
								$next_step = $data_comp_res["next_step"];
								$assignedto = $data_comp_res["assignedto"]; 
								if ($data_comp_res["next_date"] != ""){
									$next_comm = date("m/d/Y" , strtotime($data_comp_res["next_date"]));
								}	
								if ($data_comp_res["last_contact_date"] != ""){
									$last_comm = date("m/d/Y" , strtotime($data_comp_res["last_contact_date"]));
								}	
							}
							$emp_name = "";
							db();
							$data_comp = db_query("Select name from loop_employees where b2b_id = ". $assignedto);
							while ($data_comp_res = array_shift($data_comp)) {
								$emp_name = $data_comp_res["name"];
							}							
							$sqlGetZWDt = "SELECT loginid, companyid, user_name, password FROM supplierdashboard_usermaster WHERE companyid=".$data["b2bid"]." and activate_deactivate = 1" ;
							db();
							$resGetZWDt = db_query($sqlGetZWDt);
							$arrGetZWDt = array_shift($resGetZWDt);
							$userName = "";
							$pwd = "";
							if(!empty($arrGetZWDt)){
								$userName 	= ($arrGetZWDt['user_name']);
								$pwd  		= ($arrGetZWDt['password']);	
							}
						
							?>
							<tr vAlign="center">
							  	<td bgColor="#e4e4e4" class="stylenew">
									<a target="_blank" href ="viewCompany-purchasing.php?ID=<?php echo $data["b2bid"]; ?>&proc=View&searchcrit=&show=water-initiatives&rec_type=Manufacturer"><?php echo $comp_nickname."</a>"; ?>
								</td>
								<td bgColor="#e4e4e4" class="stylenew">
									<?php if ($userName != "") {?>
										<a target="_blank" href="https://www.ucbzerowaste.com/index.php?txtemail=<?php echo base64_encode($userName);?>&txtpassword=<?php echo base64_encode($pwd);?>&redirect=yes">Client WATER Dashboard</a>
									<?php }else {?>
										&nbsp;	
									<?php }?>
								</td>
								<td bgColor="#e4e4e4" align="middle"><?php echo $data['cnt'];?></td>
								<td bgColor="#e4e4e4" class="stylenew"><?php echo $next_comm;?></td>
								<td bgColor="#e4e4e4" class="stylenew"><?php echo $next_step;?></td>
								<td bgColor="#e4e4e4" class="stylenew"><?php echo $emp_name;?></td>
								<td bgColor="#e4e4e4" class="stylenew"><?php echo $userName;?></td>
								<td bgColor="#e4e4e4" class="stylenew"><?php echo $pwd;?></td>	
							</tr>
							<?php
							$displayedRow++;
							if($displayedRow > $total_rows){
							?>
							<tr>
								<td colspan="8" align="center" style="color:red;font-size:12px;"><i>End of Report</i></td>
							</tr>
							<?php
							}
							$MGArray_data[] = array('cid' => $data["b2bid"], 'comp_nickname' => $comp_nickname, 
											'userName' => $userName, 'pwd' => $pwd, 'count' => $data['cnt'],
											'next_comm' => $next_comm, 'next_step' => $next_step, 'emp_name' => $emp_name); 
							
							
						}
						$_SESSION['sortarrayn'] = $MGArray_data;	
						 	
					} else
					
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
						if($_REQUEST['sort'] == "count")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['count'];
                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,SORT_NUMERIC,$MGArray); 
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,SORT_NUMERIC,$MGArray); 
                            }
                        }
                        if($_REQUEST['sort'] == "assignto")
                        {
                            $MGArraysort_I = array();

                            foreach ($MGArray as $MGArraytmp) {
                            $MGArraysort_I[] = $MGArraytmp['emp_name'];
                            }

                            if ($_REQUEST['sort_order_pre'] == "ASC"){
                                array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 
                            }
                            if ($_REQUEST['sort_order_pre'] == "DESC"){
                                array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 
                            }
                        }
						$displayedRow = 1;
						foreach ($MGArray as $MGArraytmp2) {
						?>
						<tr>
							<td bgColor="#e4e4e4" class="stylenew">
								<a target="_blank" href ="viewCompany-purchasing.php?ID=<?php echo $MGArraytmp2['cid']; ?>&proc=View&searchcrit=&show=water-initiatives&rec_type=Manufacturer"><?php echo $MGArraytmp2['comp_nickname'];?></a>
							</td>
							<td bgColor="#e4e4e4" class="stylenew">
								<?php if ($MGArraytmp2['userName'] != "") {?>
									<a target="_blank" href="https://www.ucbzerowaste.com/index.php?txtemail=<?php echo $MGArraytmp2['userName'];?>&txtpassword=<?php echo $MGArraytmp2['pwd'];?>&redirect=yes">Client WATER Dashboard</a>
								<?php }else {?>
									&nbsp;	
								<?php }?>
							</td>
							<td bgColor="#e4e4e4" align="middle"><?php echo $MGArraytmp2['count'];?></td>
							<td bgColor="#e4e4e4" class="stylenew"><?php echo $MGArraytmp2['next_comm'];?></td>
							<td bgColor="#e4e4e4" class="stylenew"><?php echo $MGArraytmp2['next_step'];?></td>
							<td bgColor="#e4e4e4" class="stylenew"><?php echo $MGArraytmp2['emp_name'];?></td>
							<td bgColor="#e4e4e4" class="stylenew"><?php echo $MGArraytmp2['userName'];?></td>
							<td bgColor="#e4e4e4" class="stylenew"><?php echo $MGArraytmp2['pwd'];?></td>
						</tr>
						<?php
						$displayedRow++;
						if($displayedRow > $total_rows){
						?>
						<tr>
							<td colspan="8" align="center" style="color:red;font-size:12px;"><i>End of Report</i></td>
						</tr>
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