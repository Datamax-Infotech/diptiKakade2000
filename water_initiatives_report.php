<?php

session_start();



//require ("inc/header_session.php");

require ("../mainfunctions/database.php");

require ("../mainfunctions/general-functions.php");



$chkinitials =  $_COOKIE['userinitials'];

?>


<!DOCTYPE html>

<html>

<head>

<title>W.A.T.E.R. Initiatives Report</title>

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

			<div style="float: left;">Water Initiatives

			<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>

			<span class="tooltiptext">

				This report allows users to track WATER initiaves that are "Active", "Completed" or both.

			</span></div>

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

	



<form action="water_initiatives_report.php" method="get">

	

	<div ><i>Note: Please wait until you see <font color="red">"END OF REPORT"</font> at the bottom of the report, before using the sort option.</i></div>

	<table width="100%" border="0" cellspacing="2" cellpadding="2" bgcolor="#E4E4E4">

		<tr align="left">

			<td colspan="2" bgcolor="#C0CDDA"><font face="Arial, Helvetica, sans-serif" size="1" color="#333333">

				Company:

				<?php

				$matchStr2= "Select b2bid as ID, company_name as company from loop_warehouse inner join water_initiatives on water_initiatives.companyid = loop_warehouse.b2bid where rec_type= 'Manufacturer' and Active = 1 group by loop_warehouse.b2bid order by company_name";
				db();
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

				&nbsp;&nbsp;

				

				Initiative Status:

				<select name="initiative_status" id="initiative_status">

					<option value='All' <?php if ($_REQUEST["initiative_status"] == "All"){ echo " selected "; } ?> >Select All</option>

					<option value='Active and Completed' <?php if ($_REQUEST["initiative_status"] == "Active and Completed"){ echo " selected "; } ?>>Active and Completed</option>

					<option value='Active only' <?php if ($_REQUEST["initiative_status"] == "Active only"){ echo " selected "; } ?>>Active only</option>

					<option value='Completed only' <?php if ($_REQUEST["initiative_status"] == "Completed only"){ echo " selected "; } ?>>Completed only</option>

				</select>

				&nbsp;&nbsp;

				UCBZeroWaste Account Owner:

				<?php

				$matchStr2= "Select employeeID, name from employees order by name";
				db_b2b();
				$res = db_query($matchStr2);

				?>

				<select name="emp_id" id="emp_id">

					<option value=''></option>

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

			

				</font>

			</td>

		</tr>



		<tr>

			<td>

				<input type="submit" id="btnsubmit" value="Find Matches">

			</td>

		</tr>

	</table>

</form>



	<br>

		<?php

		$sorturl="water_initiatives_report.php?company_id=".$_REQUEST["company_id"]."&initiative_status=".$_REQUEST["initiative_status"]."&emp_id=".$_REQUEST["emp_id"];

		

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

					<strong>Initiative Status</strong>

					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=initiative_status"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=initiative_status"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>

				</th>

				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">

					<strong>Initiative Title</strong>

					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=initiative_title"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=initiative_title"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>

				</th>

				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">

					<strong>Initiative Details</strong>

					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=initiative_detail"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=initiative_detail"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>

				</th>

				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">

					<strong>Created On</strong>

					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=created_on"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=created_on"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>

				</th>

				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">

					<strong>Due Date</strong>

					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=due_date"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=due_date"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>

				</th>

				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">

					<strong>Completed Date</strong>

					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=comp_date"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=comp_date"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>

				</th>

				<th bgColor="#ABC5DF" class="style12" style="height: 16px" align="middle">

					<strong>Task Owner</strong>

					<a href="<?php echo $sorturl; ?>&sort_order_pre=ASC&sort=task_owner"><img src="images/sort_asc.png" width="6px;" height="12px;"></a>&nbsp;<a href="<?php echo $sorturl; ?>&sort_order_pre=DESC&sort=task_owner"><img src="images/sort_desc.png" width="6px;" height="12px;"></a>

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

					$MGArraysort_I[] = $MGArraytmp['task_status'];

					

				}

				if ($_GET['sort_order_pre'] == "ASC") {

					array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 

					

				}

				if ($_GET['sort_order_pre'] == "DESC") {

					array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 

				}

			}

			if($_GET['sort'] == "initiative_title")

			{

				$MGArraysort_I = array();

				foreach ($MGArray as $MGArraytmp) {

					$MGArraysort_I[] = $MGArraytmp['task_title'];

					

				}

				if ($_GET['sort_order_pre'] == "ASC") {

					array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 

					

				}

				if ($_GET['sort_order_pre'] == "DESC") {

					array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 

				}

			}

			if($_GET['sort'] == "initiative_detail")

			{

				$MGArraysort_I = array();

				foreach ($MGArray as $MGArraytmp) {

					$MGArraysort_I[] = $MGArraytmp['task_details'];

					

				}

				if ($_GET['sort_order_pre'] == "ASC") {

					array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 

					

				}

				if ($_GET['sort_order_pre'] == "DESC") {

					array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 

				}

			}

			if($_GET['sort'] == "created_on")

			{

				$MGArraysort_I = array();

				foreach ($MGArray as $MGArraytmp) {

					$MGArraysort_I[] = $MGArraytmp['task_added_on'];

					

				}

				if ($_GET['sort_order_pre'] == "ASC") {

					array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 

					

				}

				if ($_GET['sort_order_pre'] == "DESC") {

					array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 

				}

			}

			if($_GET['sort'] == "due_date")

			{

				$MGArraysort_I = array();

				foreach ($MGArray as $MGArraytmp) {

					$MGArraysort_I[] = $MGArraytmp['due_date'];

					

				}

				if ($_GET['sort_order_pre'] == "ASC") {

					array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 

					

				}

				if ($_GET['sort_order_pre'] == "DESC") {

					array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 

				}

			}

			if($_GET['sort'] == "comp_date")

			{

				$MGArraysort_I = array();

				foreach ($MGArray as $MGArraytmp) {

					$MGArraysort_I[] = $MGArraytmp['completed_date'];

					

				}

				if ($_GET['sort_order_pre'] == "ASC") {

					array_multisort($MGArraysort_I,SORT_ASC,SORT_STRING,$MGArray); 

					

				}

				if ($_GET['sort_order_pre'] == "DESC") {

					array_multisort($MGArraysort_I,SORT_DESC,SORT_STRING,$MGArray); 

				}

			}

			if($_GET['sort'] == "task_owner")

			{

				$MGArraysort_I = array();

				foreach ($MGArray as $MGArraytmp) {

					$MGArraysort_I[] = $MGArraytmp['task_owner'];

					

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

					<?php echo $MGArraytmp2["task_status"]; ?>

				</td>

				<td bgColor="#E4EAEB" class="style12" align="left">

					<?php echo $MGArraytmp2["task_title"]; ?>

				</td>

				<td bgColor="#E4EAEB" class="style12" align="left">

					<?php echo $MGArraytmp2["task_details"]; ?>

				</td>

				<td bgColor="#E4EAEB" class="style12" align="left">

					<?php echo date("m/d/Y" , strtotime($MGArraytmp2["task_added_on"])); ?>

				</td>

				<td bgColor="#E4EAEB" class="style12" align="left">

					<?php echo date("m/d/Y" , strtotime($MGArraytmp2["due_date"])); ?>

				</td>

				<td bgColor="#E4EAEB" class="style12" align="left">

					<?php if ($MGArraytmp2["completed_date"] != "0000-00-00 00:00:00") { echo date("m/d/Y" , strtotime($MGArraytmp2["completed_date"])); } ?>

				</td>

				

				<td bgColor="#E4EAEB" class="style12" align="left">

					<?php echo $MGArraytmp2["task_owner"]; ?>

				</td>

			</tr>		

		<?php

			}

	}else{

		

		if ($_REQUEST["company_id"] != "")

		{

			

			if (($_REQUEST["company_id"] == "All") && ($_REQUEST["initiative_status"] == "All")){

				$main_matchStr2= "Select * from water_initiatives order by status asc" ;

			}else{

				if ($_REQUEST["company_id"] == "All")

				{

					if ($_REQUEST["initiative_status"] == "Active and Completed")

					{

						$main_matchStr2 = "Select * from water_initiatives order by status asc" ;

					}else if ($_REQUEST["initiative_status"] == "Active only"){

						$main_matchStr2 = "Select * from water_initiatives where status = 1 ";

					}else if ($_REQUEST["initiative_status"] == "Completed only"){

						$main_matchStr2 = "Select * from water_initiatives where status = 2 ";

					}			

				}else{	

					if ($_REQUEST["initiative_status"] == "Active and Completed" || $_REQUEST["initiative_status"] == "All" )

					{

						$main_matchStr2 = "Select * from water_initiatives where companyid = " . $_REQUEST["company_id"] . " order by status asc" ;

					}else if ($_REQUEST["initiative_status"] == "Active only"){

						$main_matchStr2 = "Select * from water_initiatives where status = 1 and companyid = " . $_REQUEST["company_id"];

					}else if ($_REQUEST["initiative_status"] == "Completed only"){

						$main_matchStr2 = "Select * from water_initiatives where status = 2 and companyid = " . $_REQUEST["company_id"];

					}			

				}

			}

			
			db();
			$res = db_query($main_matchStr2);

			while ($objInvmatch = array_shift($res)) {



				$emp_str = "";

				if ($_REQUEST["emp_id"] != "")

				{

					$emp_str = " and ucbzw_account_owner = " . $_REQUEST["emp_id"];

				}				

				
				db_b2b();
				$res_comp = db_query("Select *, employees.name as empname, status.name as statusname from companyInfo left join employees on employees.employeeID = companyInfo.ucbzw_account_owner left join status on status.id = companyInfo.ucbzw_account_status where companyInfo.ID = " . $objInvmatch["companyid"] . $emp_str);

				while ($obj_comp = array_shift($res_comp)) {

				

					$show_record = "yes";



					if ($show_record == "yes") {	

						$lastcrmdt=$obj_comp["last_contact_date"];

						if ($lastcrmdt != ""){

						$lastcrmdt_sort = date("Y-m-d", strtotime($lastcrmdt));

						$lastcrmdt = date("m/d/Y" , strtotime($lastcrmdt));

					}else{

						$lastcrmdt_sort = "";

						$lastcrmdt = "";

					}	

					

					if ($objInvmatch["status"] == 1)

					{	

						$task_status = "Active";

					}	

					if ($objInvmatch["status"] == 2)

					{	

						$task_status = "Completed";

					}	

					

					$nickname=get_nickname_val('' , $objInvmatch["companyid"]);

				?>



					<tr>

						<td bgColor="#E4EAEB" class="style12" align="left">		

							<a target="_blank" href="viewCompany.php?ID=<?php echo $obj_comp["ID"];?>" target="_blank">

								<?php

								echo $nickname;?></a>

						</td>

						<td bgColor="#E4EAEB" class="style12" align="left">

							<?php echo $obj_comp["empname"]; ?>

						</td>

						<td bgColor="#E4EAEB" class="style12" align="left">

							<?php echo $task_status; ?>

						</td>

						<td bgColor="#E4EAEB" class="style12" align="left">

							<?php echo $objInvmatch["task_title"]; ?>

						</td>

						<td bgColor="#E4EAEB" class="style12" align="left">

							<?php echo $objInvmatch["task_details"]; ?>

						</td>

						<td bgColor="#E4EAEB" class="style12" align="left">

							<?php echo date("m/d/Y" , strtotime($objInvmatch["task_added_on"])); ?>

						</td>

						<td bgColor="#E4EAEB" class="style12" align="left">

							<?php echo date("m/d/Y" , strtotime($objInvmatch["due_date"])); ?>

						</td>

						<td bgColor="#E4EAEB" class="style12" align="left">

							<?php if ($objInvmatch["completed_date"] != "0000-00-00 00:00:00") { echo date("m/d/Y" , strtotime($objInvmatch["completed_date"])); } ?>

						</td>

						<td bgColor="#E4EAEB" class="style12" align="left">

							<?php echo $objInvmatch["task_owner"]; ?>

						</td>

					</tr>		

				<?php

					$MGArray[] = array('companyid' => $obj_comp["ID"], 'company' => $nickname, 'empname' => $obj_comp["empname"], 'task_status' => $task_status, 'task_title' => $objInvmatch["task_title"], 

					'task_details' => $objInvmatch["task_details"], 'task_added_on' => $objInvmatch["task_added_on"], 'due_date'=> $objInvmatch["due_date"], 'completed_date' => $objInvmatch["completed_date"],

					'task_owner' => $objInvmatch["task_owner"]);

				

					$_SESSION['sortarrayn'] = $MGArray;

				}

			}

		

		}



	  }

	}

  ?>

	  

	  

	</tbody>  

	</table>

	<div ><i><font color="red">"END OF REPORT"</font></i></div>

<?php

   



?>

	</div>

</body>

</html>