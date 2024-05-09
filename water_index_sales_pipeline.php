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


<head>
	<title>UCBZeroWaste Sales Pipeline <?php  echo "Logged in as : " . $_COOKIE['userinitials']; ?></title>
	<meta http-equiv="refresh" content="3000">
	
	

	<style type="text/css">
		
	
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

body{
	padding:0;
	margin:0;
	width:100%;
}
.container{
	padding:0 10px;
}
.main_data_css{
	margin: 0 auto;
	width: 100%;
	height: auto;
	clear: both !important;
	padding-top: 35px;
}	
</style>

<SCRIPT LANGUAGE="JavaScript" SRC="inc/CalendarPopup.js"></SCRIPT>
<script LANGUAGE="JavaScript">document.write(getCalendarStyles());</script>

<script LANGUAGE="JavaScript">
	 var cal1xx = new CalendarPopup("listdiv");
	 cal1xx.showNavigationDropdowns();
	 
	 var cal1nxxrep = new CalendarPopup("listdivnew");
	 cal1nxxrep.showNavigationDropdowns();
</script>
	
	<LINK rel='stylesheet' type='text/css' href='one_style.css' >
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>
	
</head>
	
<body>
	<?php  include("inc/header.php"); ?>
	
<div id="light_todo" class="white_content"></div>
<div id="fade_todo" class="black_overlay"></div>
	
<div class="main_data_css">
	<div class="dashboard_heading" style="float: left;">
		<div style="float: left;">UCBZeroWaste Sales Pipeline
		<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
		<span class="tooltiptext">
			UCB Zero Waste Table Pipeline
		</span></div>
		
		<div style="height: 13px;">&nbsp;</div>				
		</div>
	</div>
	
<div class="container">
	<table border="0" cellpadding="5" cellspacing="2" width="100%" align="center">
		<tr align="">
			<td style="vertical-align:top;">
				<table cellSpacing="0" cellPadding="2" border="0" width="350" class="sales_pipeline_style" >
					<tr align="middle">
					  <td class="style24" style="height: 16px" colspan="2">
						<strong><span style="text-transform: uppercase">Sales Pipeline</span></strong>
					  </td>
					</tr>
					
					<?php 
						$status = "Select * from status where (sales_flg = 3) order by sort_order";
						db_b2b();
						$dt_view_res4 = db_query($status);
					
						while ($objStatus= array_shift($dt_view_res4)) {
					?>
						<tr vAlign="center">
						  <td bgColor="#e4e4e4" class="stylenew">
							<a href="javascript:void(0);" onclick="showtable_pipeline('salespipeline', '<?php  echo $objStatus["id"]; ?>', '<?php  echo $sort_order_pre;?>' , '<?php  echo $sort;?>');">						  
								<?php  echo $objStatus["name"]; ?>
							<?php 
								$comp_q = "Select * from companyInfo where ucbzw_account_status = '".$objStatus["id"]."'";
								db_b2b();
								$comp_row = db_query($comp_q);

								$total_status_rec= tep_db_num_rows($comp_row);
							?>
								(<?php  echo $total_status_rec; ?>)
							</a>
							
							</td>
							<td bgColor="#e4e4e4">
							<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
								<span class="tooltiptext">
									<?php  echo $objStatus["tooltip_text"]; ?>
								</span></div>
							</td>
						</tr>
					<?php 
					}
					?>
					
				  </table> 
			</td>
			<td style="vertical-align:top;">
				<div id="main_content">
				</div>
			</td>
		</tr>
	</table>
</div>
</div>

</body>
</html>

<script>
	function f_getPosition (e_elemRef, s_coord) {
		var n_pos = 0, n_offset,
			e_elem = e_elemRef;

		while (e_elem) {
			n_offset = e_elem["offset" + s_coord];
			n_pos += n_offset;
			e_elem = e_elem.offsetParent;
		}

		e_elem = e_elemRef;
		while (e_elem != document.body) {
			n_offset = e_elem["scroll" + s_coord];
			if (n_offset && e_elem.style.overflow == 'scroll')
				n_pos -= n_offset;
			e_elem = e_elem.parentNode;
		}
		return n_pos;
	}
	
	function showtask(compid)
	{
		selectobject = document.getElementById("todo_edit"+compid);
		n_left = f_getPosition(selectobject, 'Left');
		n_top  = f_getPosition(selectobject, 'Top');
		
		
				
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
				document.getElementById('light_todo').style.left= (n_left - 600) + 'px';
				document.getElementById('light_todo').style.top=n_top - 10 + 'px';
				document.getElementById('light_todo').style.width= 700 + 'px';
				document.getElementById('light_todo').style.height= 300 + 'px';
				
			}
		}
		
		xmlhttp.open("GET","todolist_view_special_op.php?fromrep=y&compid="+compid,true);
		xmlhttp.send();
	}
	
	function addtodoitem()
	{
		document.getElementById("todo_div").innerHTML = "<br><br>Loading .....<img src='images/wait_animated.gif' />"; 						
		
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
			  document.getElementById("todo_div").innerHTML = xmlhttp.responseText;
			}
		}
		
		var compid = document.getElementById('todo_companyID').value;
		var todo_message = document.getElementById('todo_message').value;
		var todo_employee = document.getElementById('todo_employee').value;
		var todo_date = document.getElementById('todo_date').value;
		var task_priority = document.getElementById('task_priority').value;
		var task_created_by = document.getElementById('todo_created_by').value;
		
		xmlhttp.open("GET","todolist_update.php?compid=" +compid+"&task_created_by="+encodeURIComponent(task_created_by)+"&todo_message="+encodeURIComponent(todo_message)+"&todo_employee="+todo_employee+"&todo_date="+todo_date+"&task_priority="+encodeURIComponent(task_priority),true);
		xmlhttp.send();		
	}
		
	function todoitem_edit(unqid, compid)
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
				selectobject = document.getElementById("todo_edit"+unqid);
				n_left = f_getPosition(selectobject, 'Left');
				n_top  = f_getPosition(selectobject, 'Top');

				document.getElementById("light_todo").innerHTML = "<a href='javascript:void(0)' onclick=document.getElementById('light_todo').style.display='none';document.getElementById('fade_todo').style.display='none'>Close</a> &nbsp;<center></center><br/>" + xmlhttp.responseText;
				document.getElementById('light_todo').style.display='block';

				/*document.getElementById('light_todo').style.left= (n_left - 300) + 'px';
				document.getElementById('light_todo').style.top=n_top - 40 + 'px';
				document.getElementById('light_todo').style.width= 700 + 'px';
				document.getElementById('light_todo').style.height= 200 + 'px';
			  */
			}
		}
		
		xmlhttp.open("GET","todolist_edit_data.php?compid="+compid +"&unqid="+unqid,true);
		xmlhttp.send();		
	}	
	
	function update_edit_item(unqid)
	{
		var compid = document.getElementById('todo_companyID').value;

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
				alert("Record updated.");
				//document.getElementById('light_todo').style.display='none';
				document.getElementById("light_todo").innerHTML = "<a href='javascript:void(0)' onclick=document.getElementById('light_todo').style.display='none';document.getElementById('fade_todo').style.display='none'>Close</a> &nbsp;<center></center><br/>" + xmlhttp.responseText;						
			}
		}
		
		var todo_message = document.getElementById('todo_message_edit').value;
		var todo_employee = document.getElementById('todo_employee_edit').value;
		var todo_date = document.getElementById('todo_date_edit').value;
		var task_priority = document.getElementById('task_priority_edit').value;
		
		xmlhttp.open("GET","todolist_update.php?inedit_mode=1&unqid="+unqid+"&compid=" +compid+"&todo_message="+encodeURIComponent(todo_message)+"&todo_employee="+todo_employee+"&todo_date="+todo_date+"&task_priority="+encodeURIComponent(task_priority),true);
		xmlhttp.send();		
	}
	
	
	
	function todoitem_markcomp(unqid, compid)
	{
		//alert(selectedText);
		document.getElementById("light_todo").innerHTML = "<br><br>Loading .....<img src='images/wait_animated.gif' />"; 						
		
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
			  document.getElementById("light_todo").innerHTML = xmlhttp.responseText;
			}
		}
		
		xmlhttp.open("GET","todolist_update.php?compid="+compid +"&unqid="+unqid+"&markcomp=1",true);
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
		
		

		xmlhttp.open("GET","water_index_load_tables_pipeline_new_one.php?tablenm="+tablenm + "&sort_order_pre="+sort_order_pre + "&statusid="+statusid + "&sort="+sort,true);			
		xmlhttp.send();		
	}
	
	function update_nextstep(tmpcnt, mainid, empid, statusid, ucbzw_flg){
		
		document.getElementById("res_div_int" + tmpcnt).style.display = 'block';
		document.getElementById("res_div_int" + tmpcnt).innerHTML = "<br><br>Loading .....<img src='images/wait_animated.gif' />"; 						
		
		var ucbzw_nextstep_data = escape(document.getElementById("txt_nextstep_ucbzw" + tmpcnt).value);
		
		var ucbzw_nextcomm_data = document.getElementById("txt_nextcomm_ucbzw" + tmpcnt).value;
		var poc_job_title = escape(document.getElementById("poc_job_title" + tmpcnt).value);
		var potential_annual_rev = document.getElementById("txt_potential_annual_rev" + tmpcnt).value;
		
		
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
		xmlhttp.open("GET","water_index_load_tables_pipeline_update_one.php?companyID=" + mainid + "&ucbzw_flg=" + ucbzw_flg + "&ucbzw_nextstep_data="+ ucbzw_nextstep_data  + "&ucbzw_nextcomm_data="+ ucbzw_nextcomm_data + "&poc_job_title="+ poc_job_title + "&potential_annual_rev="+potential_annual_rev + "&empid=" + empid + "&statusid=" + statusid + "&tmpcnt=" + tmpcnt,true);
		xmlhttp.send();		
    }
	
	showtable_pipeline('salespipeline', '79', '','');
</script>