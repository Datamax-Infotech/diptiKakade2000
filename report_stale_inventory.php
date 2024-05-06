<?php
//require "inc/header_session.php";
require "../mainfunctions/database.php";
require "../mainfunctions/general-functions.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Stale Inventory Report</title>
</head>

<style>
.outer-container{
	width: 100%;
	margin: 0 auto;
}
.container{
	padding: 10px;

}
.content{
	margin: 0 auto;
	width:100%;
	display:grid;
}
.txtstyle, .txtstyle_color
{
font-family:arial;
font-size:13;
font-weight:700;
height:16px;
background:#ABC5DF;
text-align: center;
}

.center
{
	text-align: center;
}
.left
{
	text-align: left;
}

.style12 {
    font-family: Arial, Helvetica, sans-serif;
    font-size: x-small;
    color: #333333;
    text-align: right;
}

.style12center {
    font-family: Arial, Helvetica, sans-serif;
    font-size: x-small;
    color: #333333;
    text-align: center;
}
.style12left {
    font-family: Arial, Helvetica, sans-serif;
    font-size: x-small;
    color: #333333;
    text-align: left;
}
</style>

<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css' >
<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">

<script>
	function display_preoder_sel(tmpcnt, reccnt, box_id, wid) {
		if (reccnt > 0 ) {

		if (document.getElementById('inventory_preord_top_' + tmpcnt).style.display == 'table-row')
		{ document.getElementById('inventory_preord_top_' + tmpcnt).style.display='none'; } else {
		 document.getElementById('inventory_preord_top_' + tmpcnt).style.display='table-row'; }

		document.getElementById("inventory_preord_middle_div_"+tmpcnt).innerHTML = "<br><br>Loading .....<img src='images/wait_animated.gif' />";

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
			  document.getElementById("inventory_preord_middle_div_"+tmpcnt).innerHTML = xmlhttp.responseText;
			}
		}

		xmlhttp.open("GET","inventory_preorder_childtable.php?box_id=" +box_id+"&wid="+wid,true);
		xmlhttp.send();

		}
	}

</script>

<body>
<?php require_once "inc/header.php";?>
<br>
<div id="light" class="white_content"></div>
<div class="outer-container">
	<div class="container">
		<div class="dashboard_heading" style="float: left;">
			<div style="float: left;">
				Stale Inventory Report

				<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
				<span class="tooltiptext">This report list inventory items for each warehouse.</span></div><br>
			</div>
		</div>

		<br>
		<div class="content">

		  <style type="text/css">
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

		<script>

		function dynamic_Select(sort){
			var skillsSelect = document.getElementById('dropdown');
			var selectedText = skillsSelect.options[skillsSelect.selectedIndex].value;
			document.getElementById("temp").value = selectedText;
		}

		function displaynonucbgaylord(colid, sortflg){
			document.getElementById("div_noninv_gaylord").innerHTML  = "<br/><div style='text-align: center;'>Loading .....<img src='images/wait_animated.gif' /></div>";

			if (window.XMLHttpRequest){
				xmlhttp=new XMLHttpRequest();
			}
			else{
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("div_noninv_gaylord").innerHTML = xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","inventory_displaynonucbgaylord.php?colid=" + colid + "&sortflg=" + sortflg ,true);
			xmlhttp.send();
		}


		function displaynonucbshipping(colid, sortflg){
			document.getElementById("div_noninv_shipping").innerHTML  = "<br/><div style='text-align: center;'>Loading .....<img src='images/wait_animated.gif' /></div>";

			if (window.XMLHttpRequest){
				xmlhttp=new XMLHttpRequest();
			}
			else{
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("div_noninv_shipping").innerHTML = xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","inventory_displaynonucbshipping.php?colid=" + colid + "&sortflg=" + sortflg ,true);
			xmlhttp.send();
		}
		//

			//
		function sort_Select(warehouseid){
			var Selectval = document.getElementById('sort_by_order');
			var order_type = Selectval.options[Selectval.selectedIndex].text;


			if(document.getElementById("dropdown").value == ""){
				alert("Please Select the field.");
			}
			else{
				document.getElementById("tempval_focus").focus();

				document.getElementById("tempval").style.display = "none";
				document.getElementById("tempval1").innerHTML  = "<br/><div style='text-align: center;'>Loading .....<img src='images/wait_animated.gif' /></div>";

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
						if(order_type != "")
						{
							document.getElementById("tempval1").innerHTML = xmlhttp.responseText;
						}
					}
				}

				xmlhttp.open("GET","pre_order_sort.php?warehouseid=" + warehouseid + "&selectedgrpid_inedit="+document.getElementById("temp").value+"&sort_order="+order_type,true);
				xmlhttp.send();
			}
		}

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

		function displayafterpo(boxid){
			document.getElementById("light").innerHTML  = "<br/><div style='text-align: center;'>Loading .....<img src='images/wait_animated.gif' /></div>";
			document.getElementById('light').style.display='block';
			document.getElementById('fade').style.display='block';

			var selectobject = document.getElementById("after_pos" + boxid);
			var n_left = f_getPosition(selectobject, 'Left');
			var n_top  = f_getPosition(selectobject, 'Top');
			n_left = n_left - 250;
			n_top = n_top - 100;
			document.getElementById('light').style.left=n_left + 'px';
			document.getElementById('light').style.top=n_top + 20 + 'px';

			if (window.XMLHttpRequest){
				xmlhttp=new XMLHttpRequest();
			}
			else{
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("light").innerHTML = "<a href='javascript:void(0)' onclick=document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'>Close</a> <br><hr>" + xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","inventory_showafterpo.php?id=" + boxid,true);
			xmlhttp.send();
		}

		function displaymap(){
			document.getElementById("light").innerHTML  = "<br/><div style='text-align: center;'>Loading .....<img src='images/wait_animated.gif' /></div>";
			document.getElementById('light').style.display='block';
			document.getElementById('fade').style.display='block';

			var selectobject = document.getElementById("show_map1");
			var n_left = f_getPosition(selectobject, 'Left');
			var n_top  = f_getPosition(selectobject, 'Top');
			n_left = n_left - 50;
			document.getElementById('light').style.left=n_left + 'px';
			document.getElementById('light').style.top=n_top + 20 + 'px';

			if (window.XMLHttpRequest){
				xmlhttp=new XMLHttpRequest();
			}
			else{
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("light").innerHTML = "<a href='javascript:void(0)' onclick=document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'>Close</a> <br><hr>" + xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","inventory_showmap.php",true);
			xmlhttp.send();
		}


		function displayflyer(boxid, flyernm){
			document.getElementById("light").innerHTML  = "<a href='javascript:void(0)' onclick=document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'>Close</a> <br><hr><embed src='boxpics/" + flyernm + "' width='700' height='800'>";
			document.getElementById('light').style.display='block';
			document.getElementById('fade').style.display='block';

			var selectobject = document.getElementById("box_fly_div"+boxid);
			var n_left = f_getPosition(selectobject, 'Left');
			var n_top  = f_getPosition(selectobject, 'Top');
			n_left = n_left - 350;
			n_top = n_top - 200;
			document.getElementById('light').style.left=n_left + 'px';
			document.getElementById('light').style.top=n_top + 'px';

		}

		function displayflyer_main(boxid, flyernm){
			document.getElementById("light").innerHTML  = "<a href='javascript:void(0)' onclick=document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'>Close</a> <br><hr><embed src='boxpics/" + flyernm + "' width='700' height='800'>";
			document.getElementById('light').style.display='block';

			var selectobject = document.getElementById("box_fly_div_main"+boxid);
			var n_left = f_getPosition(selectobject, 'Left');
			var n_top  = f_getPosition(selectobject, 'Top');
			n_left = n_left - 350;
			n_top = n_top - 200;
			document.getElementById('light').style.left=n_left + 'px';
			document.getElementById('light').style.top=n_top + 20 + 'px';

		}

		function displayactualpallet(boxid){
			document.getElementById("light").innerHTML  = "<br/><div style='text-align: center;'>Loading .....<img src='images/wait_animated.gif' /></div>";
			document.getElementById('light').style.display='block';

			var selectobject = document.getElementById("actual_pos"+boxid);
			var n_left = f_getPosition(selectobject, 'Left');
			var n_top  = f_getPosition(selectobject, 'Top');
			n_top = n_top - 200;
			document.getElementById('light').style.left=n_left + 'px';
			document.getElementById('light').style.top=n_top + 20 + 'px';

			if (window.XMLHttpRequest){
				xmlhttp=new XMLHttpRequest();
			}
			else{
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("light").innerHTML = "<a href='javascript:void(0)' onclick=document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'>Close</a> <br><hr>" + xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","report_inventory.php?inventory_id="+boxid+"&action=run",true);
			xmlhttp.send();
		}

		function displayboxdata(boxid){
			document.getElementById("light").innerHTML  = "<br/><div style='text-align: center;'>Loading .....<img src='images/wait_animated.gif' /></div>";
			document.getElementById('light').style.display='block';
			document.getElementById('fade').style.display='block';

			var selectobject = document.getElementById("box_div" + boxid);
			var n_left = f_getPosition(selectobject, 'Left');
			var n_top  = f_getPosition(selectobject, 'Top');
			n_left = n_left - 350;
			n_top = n_top - 200;

			document.getElementById('light').style.left=n_left + 'px';
			document.getElementById('light').style.top=n_top + 20 + 'px';

			if (window.XMLHttpRequest){
				xmlhttp=new XMLHttpRequest();
			}
			else{
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("light").innerHTML = "<a href='javascript:void(0)' onclick=document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'>Close</a> <br><hr>" + xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","manage_box_b2bloop.php?id=" + boxid + "&proc=View&",true);
			xmlhttp.send();
		}

		function displayboxdata_main(boxid){
			document.getElementById("light").innerHTML  = "<br/><div style='text-align: center;'>Loading .....<img src='images/wait_animated.gif' /></div>";
			document.getElementById('light').style.display='block';
			document.getElementById('fade').style.display='block';

			var selectobject = document.getElementById("box_div_main" + boxid);
			var n_left = f_getPosition(selectobject, 'Left');
			var n_top  = f_getPosition(selectobject, 'Top');
			n_left = n_left - 350;
			n_top = n_top - 200;

			document.getElementById('light').style.left=n_left + 'px';
			document.getElementById('light').style.top=n_top + 20 + 'px';

			if (window.XMLHttpRequest){
				xmlhttp=new XMLHttpRequest();
			}
			else{
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("light").innerHTML = "<a href='javascript:void(0)' onclick=document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'>Close</a> <br><hr>" + xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","manage_box_b2bloop.php?id=" + boxid + "&proc=View&",true);
			xmlhttp.send();
		}

		function inv_warehouse_list(){
			var chklist_sel = document.getElementById('inv_warehouse');
			var inv_warehouse = "";
			var opts = [], opt;
			len=chklist_sel.options.length;
			for (var i=0; i<len; i++) {
				opt = chklist_sel.options[i];
				if (opt.selected) {
					inv_warehouse = inv_warehouse + opt.value + ",";
				}
			}

			if (inv_warehouse != "") {
				inv_warehouse = inv_warehouse.substring(0, inv_warehouse.length-1);
			}

			var opts = [], opt;
			var inv_boxtype = "";
			var chklist_sel = document.getElementById('inv_boxtype');
			len=chklist_sel.options.length;
			for (var i=0; i<len; i++) {
				opt = chklist_sel.options[i];
				if (opt.selected) {
					inv_boxtype = inv_boxtype + opt.value + ",";
				}
			}

			if (inv_boxtype != "") {
				inv_boxtype = inv_boxtype.substring(0, inv_boxtype.length-1);
			}

			document.getElementById("tempval_focus").focus();

			document.getElementById("tempval").style.display = "none";
			document.getElementById("tempval1").innerHTML  = "<br/><div style='text-align: center;'>Loading .....<img src='images/wait_animated.gif' /></div>";

			if (window.XMLHttpRequest){
				xmlhttp=new XMLHttpRequest();
			}
			else{
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("tempval1").innerHTML = xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","inv_warehouse_lst.php?warehouse_id_lst=" + inv_warehouse + "&boxtype_lst="+ inv_boxtype,true);
			xmlhttp.send();

		}
	</script>
	<!--------------------------NEW INVENTORY ------------------------------------>

	<form method="post" name="inv_frm" action="report_stale_inventory.php">
		<table border="0">
			<tr>
				<td>Box Status</td>
				<td>
					<select id="box_status" name="box_status">
						<option value="all" <?php if (isset($_REQUEST["box_status"]) && 'all' == $_REQUEST["box_status"]) {
    echo " selected ";
}
?> >All</option>
						<option value="available" <?php if (isset($_REQUEST["box_status"]) && 'available' == $_REQUEST["box_status"]) {
    echo " selected ";
}
?>>Available</option>
					</select>
				</td>

				<td><input type="submit" name="btntool" name="btntool" value="Submit" /></td>
			</tr>
		</table>
	</form>

	<div id="tempval_focus" name="tempval_focus" ></div>
	<div id="tempval1" name="tempval1" >
	</div>

	<?php if (isset($_REQUEST["btntool"])) {?>
	<div id="tempval" name="tempval" >

	<?php
$bg = "#f4f4f4";
    $style12_val = "style12";
    ?>
	<table cellSpacing="1" cellPadding="1" border="0" width="1300" >

	  <tr>
		<td colspan="14">
			<div id="div_ucbinv_w" name="div_ucbinv_w" >
			<table cellSpacing="1" cellPadding="1" border="0" width="1300" >

		<?php
$warehouse_id_arr = array(18, 556, 1115, 2563, 5174, 4146);
    foreach ($warehouse_id_arr as $warehouse_id_arr_tmp) {
        $warehouse_name = "";
        $dt_view_qry_1 = "SELECT warehouse_name, company_name, b2bid from loop_warehouse where id = '" . $warehouse_id_arr_tmp . "'";
        db();
        $dt_view_res_1 = db_query($dt_view_qry_1);
        while ($dt_view_row_1 = array_shift($dt_view_res_1)) {
            $warehouse_name = $dt_view_row_1["warehouse_name"];
        }

        $warehouseid_selected = $warehouse_id_arr_tmp;

        $x = 0;
        $newflg = "no";
        $preordercnt = 1;
        $box_type_str_arr = array("'Gaylord','GaylordUCB', 'PresoldGaylord', 'Loop'", "'LoopShipping','Box','Boxnonucb','Presold','Medium','Large','Xlarge','Boxnonucb'", "'SupersackUCB','SupersacknonUCB'", "'DrumBarrelUCB','DrumBarrelnonUCB'", "'PalletsUCB','PalletsnonUCB'", "'Recycling','Other','Waste-to-Energy'");
        $box_type_cnt = 0;
        $MGArray = array();
        foreach ($box_type_str_arr as $box_type_str_arr_tmp) {
            $box_type_cnt = $box_type_cnt + 1;

            if ($box_type_cnt == 1) {$box_type = "Gaylord";}
            if ($box_type_cnt == 2) {$box_type = "Shipping Boxes";}
            if ($box_type_cnt == 3) {$box_type = "Supersacks";}
            if ($box_type_cnt == 4) {$box_type = "Drums/Barrels/IBCs";}
            if ($box_type_cnt == 5) {$box_type = "Pallets";}
            if ($box_type_cnt == 6) {$box_type = "Recycling+Other";}
            ?>
			  <tr vAlign="center" >
				<td colspan="21" >&nbsp;</td>
			  </tr>
			  <tr vAlign="center" >
				<td colspan="21" bgColor="#e4e4e4" height="20" align="center"><b><?php echo $box_type; ?></b></td>
			  </tr>

			  <tr vAlign="center" style="white-space: nowrap;">
				<td bgColor="#e4e4e4" class="style12center"><b>Warehouse&nbsp;<a href="#" onclick="displayucbinv(26,1);" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="#" onclick="displayucbinv(26,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b>
				</td>
				<td bgColor="#e4e4e4" class="style12center"><b>ID&nbsp;<a href="#" onclick="displayucbinv(22,1);" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="#" onclick="displayucbinv(22,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b>
				</td>

				<td bgColor="#e4e4e4" class="style12center"><b>Actual&nbsp;<a href="#" onclick="displayucbinv(21,1);" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="#" onclick="displayucbinv(21,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b>
				</td>

				<td bgColor="#e4e4e4" class="style12"><b>After PO&nbsp;<a href="#" onclick="displayucbinv(2,1);" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="#" onclick="displayucbinv(2,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b></td>

				<td bgColor="#e4e4e4" class="style12left" ><b>Length&nbsp;<a href="#" onclick="displayucbinv(7,1);" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="#" onclick="displayucbinv(7,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b></font>
				</td>
				<td bgColor="#e4e4e4" class="style12left">X</td>
				<td bgColor="#e4e4e4" class="style12left" ><b>Width&nbsp;<a href="javascript:void();" onclick="displayucbinv(16,1);" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(16,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b></font>
				</td>
				<td bgColor="#e4e4e4" class="style12left">X</td>
				<td bgColor="#e4e4e4" class="style12left" ><b>Height&nbsp;<a href="javascript:void();" onclick="displayucbinv(17,1);" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(17,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b></font>
				</td>

				<td bgColor="#e4e4e4" class="style12"><b>Walls&nbsp;<a href="javascript:void();" onclick="displayucbinv(4,1);" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(4,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b>
				</td>
				<td bgColor="#e4e4e4" class="style12" width="150px;"><b>Nickname&nbsp;<a href="javascript:void();" onclick="displayucbinv(23,1);" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(23,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b></font>
				</td>

				<!-- new columns -->
				<td bgColor="#e4e4e4" class="style12" width="100px;"><b>Last Date In&nbsp;<a href="javascript:void();" onclick="displayucbinv(24,1)" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(24,2)"><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b></font>
				</td>
				<td bgColor="#e4e4e4" class="style12" width="50px;"><b>Ageing Days&nbsp;<a href="javascript:void();" onclick="displayucbinv(25,1)" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(25,2)"><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b></font>
				</td>
				<!-- end new columns -->

				<td bgColor="#e4e4e4" class="style12" width="150px;"><b>Description&nbsp;<a href="javascript:void();" onclick="displayucbinv(8,1);" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(8,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b></font>
				</td>

				<td bgColor="#e4e4e4" class="style12" width="70px"><b>Per Pallet&nbsp;<a href="javascript:void();" onclick="displayucbinv(10,1);" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(10,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b>
				</td>

				<td bgColor="#e4e4e4" class="style12" width="70px;"><b>Per Truckload&nbsp;<a href="javascript:void();" onclick="displayucbinv(11,1);" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(11,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b>
				</td>

				<td bgColor="#e4e4e4" class="style12" width="100px"><b>Vendor&nbsp;<a href="javascript:void();" onclick="displayucbinv(5,1)" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(5,2);" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b></td>

				<td bgColor="#e4e4e4" class="style12" width="100px;"><b>Work as a Kit Box&nbsp;<a href="javascript:void();" onclick="displayucbinv(14,1)" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(14,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b></font></td>

				 <td bgColor="#e4e4e4" class="style12" width="100px;"><b>Strapped Pallets in Inventory&nbsp;<a href="javascript:void();" onclick="displayucbinv(18,1)" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(18,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b></font></td>

				 <td bgColor="#e4e4e4" class="style12" width="100px;"><b>Cubic Footage of Strapped Pallet&nbsp;<a href="javascript:void();" onclick="displayucbinv(19,1)" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(19,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b></font></td>

				<td bgColor="#e4e4e4" class="style12" width="100px;"><b>Space Taken by Item&nbsp;<a href="javascript:void();" onclick="displayucbinv(20,1)" ><img src="images/sort_asc.jpg" width="5px;" height="10px;"></a>&nbsp;<a href="javascript:void();" onclick="displayucbinv(20,2)" ><img src="images/sort_desc.jpg"  width="5px;" height="10px;"></a></b></font></td>

			  </tr>
			<?php
if ($_REQUEST["box_status"] == "available") {
                $b2b_status_str = " b2b_status in ('1.0', '1.1', '1.2')";
            } else {
                $b2b_status_str = " b2b_status not in ('2.5', '2.6', '2.7', '2.8', '2.9')";
            }

            $dt_view_qry = "SELECT loop_boxes.bpallet_l, loop_boxes.bwall_min, loop_boxes.bwall_max, loop_boxes.vendor_b2b_rescue, loop_boxes.uniform_mixed_load, blength_min, blength_max, bwidth_min, bwidth_max, bheight_min, bheight_max,
				loop_boxes.bpallet_w, loop_boxes.bpallet_h, loop_boxes.bpallet_qty, loop_boxes.actual_qty_calculated, loop_boxes.work_as_kit_box, loop_boxes.flyer, loop_boxes.boxes_per_trailer, loop_boxes.id AS I,
				loop_boxes.b2b_id AS inv_id, loop_boxes.nickname, loop_boxes.bdescription AS C,
				loop_boxes.blength AS L, loop_boxes.blength_frac AS LF, loop_boxes.bwidth AS W, loop_boxes.bwidth_frac AS WF, loop_boxes.bdepth AS D,
				loop_boxes.bdepth_frac as DF, loop_boxes.work_as_kit_box as kb, loop_boxes.bwall AS WALL, loop_boxes.bstrength AS ST, loop_boxes.isbox as ISBOX,
				loop_boxes.type as TYPE, loop_boxes.box_warehouse_id AS wid, loop_boxes.sku as SKU
				FROM loop_boxes where loop_boxes.inactive = 0 and loop_boxes.box_warehouse_id = " . $warehouseid_selected . " and $b2b_status_str
				and loop_boxes.type in (" . $box_type_str_arr_tmp . ")
				GROUP BY loop_boxes.box_warehouse_id, loop_boxes.id order by CONVERT(loop_boxes.bdepth,UNSIGNED INTEGER), loop_boxes.bdescription";
            //order by CONVERT(loop_boxes.bdepth,UNSIGNED INTEGER), loop_boxes.bdescription
            //order by warehouse, type_ofbox, Description
            db();
            $dt_view_res = db_query($dt_view_qry);

            // $num_rows = tep_db_num_rows($dt_view_res);
            // if ($num_rows > 0)
            $tmpwarenm = "";
            $tmp_noofpallet = 0;
            while ($dt_view_row = array_shift($dt_view_res)) {
                $actual_qty_calculated = $dt_view_row["actual_qty_calculated"];

                // new query to find last date when in_out=1
                $dt_last_qry = "select max(add_date) as add_date from loop_inventory where in_out=1 and box_id=" . $dt_view_row["I"];
                db();
                $dt_last_res = db_query($dt_last_qry);
                $dt_last_row = array_shift($dt_last_res);
                if (is_null($dt_last_row['add_date'])) {
                    $last_date = "";
                    $dt_last_row['ageing'] = "";
                } else {
                    $last_date = date("m/d/Y", strtotime($dt_last_row['add_date']));
                    $earlier = new DateTime($dt_last_row['add_date']);
                    $later = new DateTime(date("Y-m-d"));
                    $ageing = $later->diff($earlier);
                    $dt_view_row['ageing'] = $earlier->diff($later)->format("%r%a");
                }
                $dt_view_row['last_date'] = $last_date;
                //$ageing = (new DateTime("2010-01-11"))->diff(new DateTime("2019-08-19"))->days
                // end new query
                $vendor_name = "";
                //$dt_view_qry_1 = "SELECT vendors.name AS VN , location_city, location_state, location_zip from inventory INNER JOIN vendors ON inventory.vendor = vendors.id where inventory.ID = " . $dt_view_row["inv_id"];
                $dt_view_qry_1 = "SELECT warehouse_name, company_name, b2bid from loop_warehouse where id = '" . $dt_view_row["vendor_b2b_rescue"] . "'";
                db();
                $dt_view_res_1 = db_query($dt_view_qry_1);
                while ($dt_view_row_1 = array_shift($dt_view_res_1)) {
                    $vendor_name = get_nickname_val($dt_view_row_1["warehouse_name"], $dt_view_row_1["b2bid"]);
                }

                $date_dt = new DateTime(); //Today
                $dateMinus12 = $date_dt->modify("-12 months"); // Last day 12 months ago

                $sales_order_qty = 0;
                $dt_so_item = "SELECT sum(qty) as sumqty FROM loop_salesorders ";
                $dt_so_item .= " inner join loop_transaction_buyer on loop_transaction_buyer.id = loop_salesorders.trans_rec_id ";
                $dt_so_item .= " where (STR_TO_DATE(loop_salesorders.so_date, '%m/%d/%Y') between '" . $dateMinus12->format('Y-m-d') . "' and '" . date("Y-m-d") . "') and location_warehouse_id = " . $dt_view_row["wid"] . " and box_id = " . $dt_view_row["I"] . " and loop_transaction_buyer.bol_create = 0 and loop_transaction_buyer.Preorder=0 and loop_transaction_buyer.ignore = 0 ";

                //echo $dt_so_item . "<br>";
                db();
                $dt_res_so_item = db_query($dt_so_item);

                while ($so_item_row = array_shift($dt_res_so_item)) {
                    if ($so_item_row["sumqty"] > 0) {
                        $sales_order_qty = $so_item_row["sumqty"];
                    } else {
                        $sales_order_qty = 0;
                    }
                }

                //$lastmonth_val = $lastmonth_qry_array[$dt_view_row["I"]];

                $reccnt = 0;
                if ($sales_order_qty > 0) {$reccnt = $sales_order_qty;}

                $preorder_txt = "";
                $preorder_txt2 = "";

                if ($reccnt > 0) {
                    $preorder_txt = "<u>";
                    $preorder_txt2 = "</u>";
                }

                if (($actual_qty_calculated >= $dt_view_row["boxes_per_trailer"]) && ($dt_view_row["boxes_per_trailer"] > 0)) {
                    $bg = "yellow";
                }

                $pallet_val = 0;
                $pallet_val_afterpo = 0;
                $actual_po = $actual_qty_calculated - $sales_order_qty;

                if ($dt_view_row["bpallet_qty"] > 0) {
                    $pallet_val = number_format($actual_qty_calculated / $dt_view_row["bpallet_qty"], 1, '.', '');
                    $pallet_val_afterpo = number_format($actual_po / $dt_view_row["bpallet_qty"], 1, '.', '');
                }

                $pallet_space_per = "";

                if ($pallet_val > 0) {
                    $tmppos_1 = strpos($pallet_val, '.');
                    if ($tmppos_1 != false) {
                        if (intval(substr($pallet_val, strpos($pallet_val, '.') + 1, 1)) > 0) {
                            $pallet_val_temp = $pallet_val;
                            $pallet_val = " (" . $pallet_val_temp . ")";
                        } else {

                            $pallet_val = floatval($pallet_val);
                            $pallet_val_format = number_format($pallet_val, 0);

                            //$pallet_val_format = number_format($pallet_val, 0);
                            $pallet_val = " (" . $pallet_val_format . ")";
                        }
                    } else {
                        $pallet_val = floatval($pallet_val);
                        $pallet_val_format = number_format($pallet_val, 0);
                        // $pallet_val_format = number_format($pallet_val, 0);
                        $pallet_val = " (" . $pallet_val_format . ")";
                    }
                } else { $pallet_val = "";}

                if ($pallet_val_afterpo > 0) {
                    $tmppos_1 = strpos($pallet_val_afterpo, '.');
                    if ($tmppos_1 != false) {
                        if (intval(substr($pallet_val_afterpo, strpos($pallet_val_afterpo, '.') + 1, 1)) > 0) {
                            $pallet_val_afterpo_temp = $pallet_val_afterpo;
                            $pallet_val_afterpo = " (" . $pallet_val_afterpo_temp . ")";
                        } else {
                            $pallet_val_afterpo = floatval($pallet_val_afterpo);
                            $pallet_val_afterpo_format = number_format($pallet_val_afterpo, 0);
                            //$pallet_val_afterpo_format = number_format($pallet_val_afterpo, 0);
                            $pallet_val_afterpo = " (" . $pallet_val_afterpo_format . ")";
                        }
                    } else {
                        $pallet_val_afterpo = floatval($pallet_val_afterpo);
                        $pallet_val_afterpo_format = number_format($pallet_val_afterpo, 0);
                        //$pallet_val_afterpo_format = number_format($pallet_val_afterpo, 0);
                        $pallet_val_afterpo = " (" . $pallet_val_afterpo_format . ")";
                    }
                } else { $pallet_val_afterpo = "";}

                $pallet_space_per = "";

                $blength = $dt_view_row["L"];
                $blength_frac = $dt_view_row["LF"];
                $tmppos_1 = strpos($blength_frac, '/');
                if ($tmppos_1 != false) {
                    $blength_frac_tmp = explode("/", $blength_frac);
                    //$blength = $blength + ($blength_frac_tmp[0] / $blength_frac_tmp[1]);
                    $blength = floatval($blength) + (floatval($blength_frac_tmp[0]) / floatval($blength_frac_tmp[1]));
                }

                $bwidth = $dt_view_row["W"];
                $bwidth_frac = $dt_view_row["WF"];
                $tmppos_1 = strpos($bwidth_frac, '/');
                if ($tmppos_1 != false) {
                    $bwidth_frac_tmp = explode("/", $bwidth_frac);
                    $bwidth = floatval($bwidth) + (floatval($bwidth_frac_tmp[0]) / floatval($bwidth_frac_tmp[1]));
                    //$bwidth = $bwidth + ($bwidth_frac_tmp[0] / $bwidth_frac_tmp[1]);
                }
                $bdepth = $dt_view_row["D"];
                $bdepth_frac = $dt_view_row["DF"];
                $tmppos_1 = strpos($bdepth_frac, '/');
                if ($tmppos_1 != false) {
                    $bdepth_frac_tmp = explode("/", $bdepth_frac);
                    $bdepth = $bdepth + (floatval($bdepth_frac_tmp[0]) / floatval($bdepth_frac_tmp[1]));
                    //$bdepth = $bdepth + ($bdepth_frac_tmp[0] / $bdepth_frac_tmp[1]);
                }
                $LWH = $blength . " x " . $bwidth . " x " . $bdepth;

                $bsize = explode("x", $LWH);

                $uniform_mixed_load = $dt_view_row["uniform_mixed_load"];

                $bwall = "";
                if ($uniform_mixed_load == "Mixed") {
                    $bwall = $dt_view_row["bwall_min"] . " - " . $dt_view_row["bwall_max"];

                    $blength_min = $dt_view_row["blength_min"];
                    $blength_max = $dt_view_row["blength_max"];
                    $bwidth_min = $dt_view_row["bwidth_min"];
                    $bwidth_max = $dt_view_row["bwidth_max"];
                    $bheight_min = $dt_view_row["bheight_min"];
                    $bheight_max = $dt_view_row["bheight_max"];

                    if ($blength_min == $blength_max) {
                        $length = floatval($blength_min);
                    } else {
                        $length = floatval($blength_min) . "-" . floatval($blength_max);
                    }

                    if ($bwidth_min == $bwidth_max) {
                        $width = floatval($bwidth_min);
                    } else {
                        $width = floatval($bwidth_min) . "-" . floatval($bwidth_max);
                    }

                    if ($bheight_min == $bheight_max) {
                        $height = floatval($bheight_min);
                    } else {
                        $height = floatval($bheight_min) . "-" . floatval($bheight_max);
                    }

                    $bwall_min = $dt_view_row["bwall_min"];
                    $bwall_max = $dt_view_row["bwall_max"];

                    if ($bwall_min == $bwall_max) {
                        $bwall = floatval($bwall_min);
                    } else {
                        $bwall = floatval($bwall_min) . "-" . floatval($bwall_max);
                    }
                } else {
                    $length = $bsize[0];
                    $width = $bsize[1];
                    $height = $bsize[2];
                    $bwall = $dt_view_row["WALL"];
                }
                //

                $cubic_footage_strapped_pallet = 0;
                $space_taken_by_item = 0;

                //Calculate strapped_pallets_inv
                if ($actual_qty_calculated > 0) {
                    $strapped_pallets_inv = $actual_qty_calculated / $dt_view_row["bpallet_qty"];
                } else {
                    $strapped_pallets_inv = 0;
                }
                //---------End Calculate strapped_pallets_inv

                //Calculate Cubic Footage of Strapped Pallet =(48*40*52)/1728
                $bpallet_l = $dt_view_row["bpallet_l"];
                $bpallet_w = $dt_view_row["bpallet_w"];
                $bpallet_h = $dt_view_row["bpallet_h"];

                $cubic_footage_strapped_pallet = ($bpallet_l * $bpallet_w * $bpallet_h) / 1728;
                //------End Calculate Cubic Footage of Strapped Pallet
                //Space Taken by Item
                $space_taken_by_item = $strapped_pallets_inv * $cubic_footage_strapped_pallet;
                //End Space Taken by Item

                $parent_child_flg = "";
                $multiple_same_box_qry = "Select parent_box_id from loop_boxes_parent_child where parent_box_id = '" . $dt_view_row["I"] . "' and parent_child_flg = 2";
                db();
                $multiple_same_box_res = db_query($multiple_same_box_qry);
                while ($multiple_same_box_row = array_shift($multiple_same_box_res)) {
                    if ($multiple_same_box_row["parent_box_id"] > 0) {
                        $parent_child_flg = 1;
                    }
                }

                if ($parent_child_flg == "") {
                    $multiple_same_box_qry = "Select parent_child_flg from loop_boxes_parent_child where loop_box_id = '" . $dt_view_row["I"] . "'";
                    db();
                    $multiple_same_box_res = db_query($multiple_same_box_qry);
                    while ($multiple_same_box_row = array_shift($multiple_same_box_res)) {
                        $parent_child_flg = $multiple_same_box_row["parent_child_flg"];
                    }
                }

                if ($parent_child_flg != 2) {
                    $MGArray[] = array('warehouse_name' => $warehouse_name,
                        'inv_id' => $dt_view_row["inv_id"], 'I' => $dt_view_row["I"], 'reccnt' => $reccnt, 'actual_qty_calculated' => $actual_qty_calculated, 'actual_po' => $actual_po,
                        'wid' => $dt_view_row["wid"], 'pallet_val_afterpo' => $pallet_val_afterpo, 'length' => $length, 'width' => $width, 'height' => $height, 'bwall' => $bwall,
                        'nickname' => $dt_view_row["nickname"],
                        'last_date' => $dt_view_row["last_date"], 'ageing' => $dt_view_row["ageing"], 'C' => $dt_view_row["C"],
                        'bpallet_qty' => $dt_view_row["bpallet_qty"],
                        'boxes_per_trailer' => $dt_view_row["boxes_per_trailer"], 'preordercnt' => $preordercnt,
                        'vendor_name' => $vendor_name,
                        'work_as_kit_box' => $dt_view_row["work_as_kit_box"],
                        'strapped_pallets_inv' => $strapped_pallets_inv,
                        'cubic_footage_strapped_pallet' => $cubic_footage_strapped_pallet,
                        'space_taken_by_item' => $space_taken_by_item,
                    );

                    if ($reccnt > 0) {
                        $preordercnt = $preordercnt + 1;
                    }
                }

            }

            $MGArraysort = array();

            foreach ($MGArray as $MGArraytmp) {
                $MGArraysort[] = $MGArraytmp['ageing'];
            }
            array_multisort($MGArraysort, SORT_DESC, SORT_NUMERIC, $MGArray);

            $x = 0;
            $bg = "#f4f4f4";
            foreach ($MGArray as $row) {
                $preorder_txt = "";
                $preorder_txt2 = "";
                if ($row["reccnt"] > 0) {
                    $preorder_txt = "<u>";
                    $preorder_txt2 = "</u>";
                }
                if (($row["actual_qty_calculated"] >= $row["boxes_per_trailer"]) && ($row["boxes_per_trailer"] > 0)) {
                    $bg = "yellow";
                }
                ?>

				<tr vAlign="center" >

					<td bgColor="<?php echo $bg; ?>" class="style12center">
						<?php echo $row["warehouse_name"]; ?>
					</td>
					<td bgColor="<?php echo $bg; ?>" class="style12center">
						<?php echo $row["inv_id"]; ?>
					</td>
					<td bgColor="<?php echo $bg; ?>" class="style12center" >
						<a href='javascript:void();' id='actual_pos<?php echo $row["I"]; ?>' onclick="displayactualpallet(<?php echo $row["I"]; ?>);">
					<?php
if ($row["actual_qty_calculated"] < 0) {?>
							<font color="red">
					<?php	} else {?>
							<font color="green">
					<?php }?>
					<?php echo number_format($row["actual_qty_calculated"]); ?>		</font>

						</a>
					</td>

					<td bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" >

					<?php
if ($row["actual_po"] < 0) {?>
						<div onclick="display_preoder_sel(<?php echo $row["preordercnt"]; ?>, <?php echo $row["reccnt"]; ?>, <?php echo $row["I"]; ?>, <?php echo $row["wid"]; ?>)" style="FONT-WEIGHT: bold;FONT-SIZE: 8pt;COLOR: 006600; FONT-FAMILY: Arial"><font color="blue"><?php echo $preorder_txt; ?><?php
echo number_format($row["actual_po"]) . $row["pallet_val_afterpo"]; ?><?php echo $preorder_txt2; ?></font></div>

					<?php	} else {?>
						<div onclick="display_preoder_sel(<?php echo $row["preordercnt"]; ?>, <?php echo $row["reccnt"]; ?>, <?php echo $row["I"]; ?>, <?php echo $row["wid"]; ?>)" style="FONT-WEIGHT: bold;FONT-SIZE: 8pt;COLOR: 006600; FONT-FAMILY: Arial">	<font color="green"><?php echo $preorder_txt; ?><?php
echo number_format($row["actual_po"]) . $row["pallet_val_afterpo"]; ?> </font><?php echo $preorder_txt2; ?></div>
					<?php }?>
					</td>

					<td bgColor="<?php echo $bg; ?>"  style="text-align: center!important;" class="<?php echo $style12_val; ?>"><?php echo $row["length"]; ?>
					</td>

					<td bgColor="<?php echo $bg; ?>" class="style12left">X</td>

					<td bgColor="<?php echo $bg; ?>"  style="text-align: center!important;" class="<?php echo $style12_val; ?>"><?php echo $row["width"]; ?>
					</td>

					<td bgColor="<?php echo $bg; ?>" class="style12left">X</td>

					<td bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" style="text-align: center!important;"><?php echo $row["height"]; ?>
					</td>

					<td bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>"><?php echo $row["bwall"]; ?></td>

					<td bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>"><?php echo $row["nickname"]; ?></td>

					<!-- new columns -->
					<td bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>"><?php echo $row["last_date"]; ?></td>

					<td bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>"><?php echo $row["ageing"]; ?></td>
					<!-- end new columns -->

					<td bgColor="<?php echo $bg; ?>" class="style12left" ><a target="_blank" href='manage_box_b2bloop.php?id=<?php echo $row["I"]; ?>&proc=View' id='box_div_main<?php echo $row["I"]; ?>' ><?php echo $row["C"]; ?></a></td>

					<td bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo $row["bpallet_qty"]; ?></td>

					<td bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo number_format($row["boxes_per_trailer"], 0); ?></td>

					<td bgColor="<?php echo $bg; ?>" class="style12left" ><?php echo $row["vendor_name"]; ?></td>

					<td bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>">
					<?php echo $row["work_as_kit_box"]; ?></td>

					<td bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>"><?php
echo number_format($row["strapped_pallets_inv"], 0);
                ?></td>
					<td bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>"><?php
echo number_format($row["cubic_footage_strapped_pallet"], 0);
                ?></td>
					<td bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>"><?php
echo number_format($row["space_taken_by_item"], 0);
                ?></td>

<?php
//$space_taken_by_item_final=$space_taken_by_item_final+$space_taken_by_item;
                ?>
				</tr>

				<?php
if ($x == 0) {
                    $x = 1;
                    $bg = "#e4e4e4";
                } else {
                    $x = 0;
                    $bg = "#f4f4f4";
                }

                if ($row["reccnt"] > 0) {?>
						<tr id='inventory_preord_top_<?php echo $row["preordercnt"]; ?>' align="middle" style="display:none;">
						  <td>&nbsp;</td>
						  <td colspan="13" style="font-size:xx-small; font-family: Arial, Helvetica, sans-serif; background-color: #FAFCDF; height: 16px">
								<div id="inventory_preord_middle_div_<?php echo $row["preordercnt"]; ?>"></div>
						  </td>
						</tr>
				<?php	}
            } //foreach end here.
            ?>



					<?php	//if ($reccnt > 0) {?>
						<?php
//    $preordercnt = $preordercnt + 1;
            //}

            //}
        }?>

					<tr vAlign="center" >
						<td colspan="21" ><hr></td>
					</tr>
				<?php
}
    ?>
					</table>
				</div>
				</td></tr>
			  </table>
			</div>

		<?php
}
echo "<input type='hidden' id='inventory_preord_totctl' value='$preordercnt' />";
?>
		</div>
	</div>
</div>
</body>
</html>

<?php
