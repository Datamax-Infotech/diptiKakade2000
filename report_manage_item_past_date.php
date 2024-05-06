<?php

//require ("inc/header_session.php");
// ini_set("display_errors", "1");

// error_reporting(E_ERROR);
require "../mainfunctions/database.php";

require "../mainfunctions/general-functions.php";

?>

<!DOCTYPE html>


<html>

<head>

	<title>Items with Past Due Ship Dates Report</title>



	<script type="text/javascript">



		function showdatehistory(unqid, flg){



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

					var selectobject = document.getElementById("tag_showdatehistory"+unqid);

					var n_left = f_getPosition(selectobject, 'Left');

					var n_top  = f_getPosition(selectobject, 'Top');



					document.getElementById('light').style.left = n_left + 10 + 'px';

					document.getElementById('light').style.top = n_top + 10 + 'px';

					document.getElementById('light').style.width = "40%";

					document.getElementById('light').style.height = "30%";



					document.getElementById("light").innerHTML = "<a href='javascript:void(0)' onclick=document.getElementById('light').style.display='none';>Close</a>" + xmlhttp.responseText;

					document.getElementById('light').style.display='block';



				}

			}



			if (flg == 3){

				trans_rec_id = document.getElementById('trans_rec_id'+unqid).value;

				comp_warehouse_id = document.getElementById('comp_warehouse_id'+unqid).value;

				xmlhttp.open("GET","manage_box_next_load_available_date_history.php?flg=" + flg + "&unqid=" +unqid + "&trans_rec_id="+trans_rec_id + "&comp_warehouse_id="+comp_warehouse_id,true);

			}else{

				xmlhttp.open("GET","manage_box_next_load_available_date_history.php?flg=" + flg + "&unqid=" +unqid,true);

			}

			xmlhttp.send();

		}



		function transid_edit(unqid){



			document.getElementById('transid_ctrl'+unqid).style.display = 'none';



			document.getElementById('transid_ctrl_edit'+unqid).style.display = 'block';

		}



		function update_delay_chk(){

			if (document.getElementById('load_available_date_delay').value == "")

			{

				alert("Please enter the number of days.");

				return false;

			}else{



				totctrl = document.getElementById("totcotrols").value;

				var select_ctrls = "";

				for (counter = 1; counter <= totctrl; counter=counter+1)

				{

					if (document.getElementById("chk_select"+counter)){

						if (document.getElementById("chk_select"+counter).checked == true){

							select_ctrls = select_ctrls + document.getElementById("chk_select"+counter).value + ",";

						}

					}

				}



				document.getElementById("hd_selectedchk").value = select_ctrls;

				document.getElementById("hd_load_available_date_delay").value = document.getElementById('load_available_date_delay').value;

				document.frm_manage_box_next_load_available_date.submit();

			}

		}



		function chk_selectall(){

			var checkBox = document.getElementById("chk_select_all");

			var selectall = 0;

			if (checkBox.checked == true){

				selectall = 1;

			}



			totctrl = document.getElementById("totcotrols").value;



			for (counter = 1; counter <= totctrl; counter=counter+1)

			{

				if (document.getElementById("chk_select"+counter)){

					if (selectall == 1){

						document.getElementById("chk_select"+counter).checked = true;

					}else{

						document.getElementById("chk_select"+counter).checked = false;

					}

				}

			}



		}



		function transid_save(unqid, b2b_id){

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

					window.location.href = "report_manage_item_past_date.php?id="+ b2b_id;

				}

			}



			xmlhttp.open("GET","manage_box_next_load_available_date_save2.php?savetransid=1&unqid=" +unqid+"&transid=" +document.getElementById('txttransid'+unqid).value,true);

			xmlhttp.send();

		}



		function po_no_edit(unqid){



			document.getElementById('po_no_ctrl'+unqid).style.display = 'none';



			document.getElementById('po_no_ctrl_edit'+unqid).style.display = 'block';

		}



		function po_no_edit_save(unqid, b2b_id){

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

					window.location.href = "report_manage_item_past_date.php?id="+ b2b_id;

				}

			}



			xmlhttp.open("GET","manage_box_next_load_available_date_save2.php?savepono=1&unqid=" +unqid+"&pono=" +document.getElementById('purchase_pono'+unqid).value,true);

			xmlhttp.send();

		}





		function show_file_inviewer_pos(filename, formtype, ctrlnm){



			var selectobject = document.getElementById(ctrlnm);

			var n_left = f_getPosition(selectobject, 'Left');

			var n_top  = f_getPosition(selectobject, 'Top');



			parent.document.getElementById("light").innerHTML = "<a href='javascript:void(0)' onclick=document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'>Close</a> &nbsp;<center>" + formtype +	"</center><br/> <embed src='"+ filename + "' width='800' height='800'>";

			parent.document.getElementById('light').style.display='block';



			parent.document.getElementById('light').style.left = n_left - 200 + 'px';

			parent.document.getElementById('light').style.top = n_top + 10 + 'px';

			parent.document.getElementById('light').style.width = "60%";

			parent.document.getElementById('light').style.height = "60%";

		}



		function savetranslog(warehouse_id, transid, tmpcnt, unqid)

		{

			var next_load_av_date = document.getElementById("load_available_date"+unqid+tmpcnt).value;

			var txtnotes = document.getElementById("txtnotes"+unqid+tmpcnt).value;



			document.getElementById("inventory_preord_middle_div_" + tmpcnt).innerHTML = "<br><br>Loading .....<img src='images/wait_animated.gif' />";



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

				   alert("Data saved.");



				   document.getElementById("inventory_preord_middle_div_"+tmpcnt).innerHTML = xmlhttp.responseText;

				}

			}



			xmlhttp.open("GET","manage_box_next_load_available_date_save.php?unqid=" +unqid+ "&tmpcnt="+tmpcnt + "&next_load_av_date="+next_load_av_date+"&txtnotes="+txtnotes,true);

			xmlhttp.send();

		}



		function save_next_load_av_date(warehouse_id, transid, tmpcnt, unqid){



			var next_load_av_date = document.getElementById("load_available_date"+unqid+tmpcnt).value;

			var txtnotes = document.getElementById("txtnotes"+unqid+tmpcnt).value;



			document.getElementById("inventory_preord_middle_div_" + tmpcnt).innerHTML = "<br><br>Loading .....<img src='images/wait_animated.gif' />";



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

				   document.getElementById("span_savebtn"+tmpcnt).innerHTML = "<center><font size=2><i>Saved!</i></font></center>";

				}

			}



			xmlhttp.open("GET","manage_box_next_load_available_date_save.php?unqid=" +unqid+ "&tmpcnt="+tmpcnt + "&next_load_av_date="+next_load_av_date+"&txtnotes="+txtnotes,true);

			xmlhttp.send();

		}



		function add_new_next_load_av_date(boxid){



			var next_load_av_date = document.getElementById("load_available_date"+unqid+tmpcnt).value;



			document.getElementById("inventory_preord_middle_div_" + tmpcnt).innerHTML = "<br><br>Loading .....<img src='images/wait_animated.gif' />";



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

				   alert("Data saved.");



				   document.getElementById("inventory_preord_middle_div_"+tmpcnt).innerHTML = xmlhttp.responseText;

				}

			}



			xmlhttp.open("GET","manage_box_next_load_available_date_save.php?unqid=" +unqid+ "&tmpcnt="+tmpcnt + "&next_load_av_date="+next_load_av_date,true);

			xmlhttp.send();

		}



		function loadadddiv()

		{

			document.getElementById("divadd").style.display = "block";

			document.getElementById("btnsave_date").value = "Add";

		}



		function changeInputValues(classnm, valuetoupdate) {

		  var inputBoxes = document.getElementsByClassName(classnm);



		  for (var i = 0; i < inputBoxes.length; i++) {

			inputBoxes[i].value = valuetoupdate;

		  }

		}



		function edit_next_load_av_date(unqid, load_available_date, txtnotes, add_sales_trans, sales_comp, transid, compid, purchase_pono)

		{

			document.getElementById("divadd").style.display = "block";

			document.getElementById("add_load_available_date").value = load_available_date;

			document.getElementById("txtnotes").value = txtnotes;

			document.getElementById("add_sales_trans").value = add_sales_trans;

			//document.getElementById("sales_comp").value = sales_comp;

			document.getElementById("purchase_pono").value = purchase_pono;



			document.getElementById("unqid").value = unqid;

			document.getElementById("btnsave_date").value = "Save";

		}



		function inactive_next_load_av_date(unqid)

		{

			var choice = confirm('Are you sure you want to mark the Load as lost?');

			if (choice === false) {

				return false;

			}



			document.getElementById("unqid_action_inactive").value = unqid;



			document.getElementById("light").innerHTML = document.getElementById("div_markinactive").innerHTML;



			selectobject = document.getElementById("btninactive"+unqid);

			n_left = f_getPosition(selectobject, 'Left');

			n_top  = f_getPosition(selectobject, 'Top');



			document.getElementById('light').style.left= (n_left - 450) + 'px';

			document.getElementById('light').style.top = n_top + 10 + 'px';

			document.getElementById('light').style.display='block';



			parent.document.getElementById('light').style.width = "40%";

			parent.document.getElementById('light').style.height = "30%";



		}



		function cust_not_ready_next_load_av_date(unqid, inv_loop_id, inv_b2b_id)

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

				   document.getElementById("divtest").innerHTML = xmlhttp.responseText;



				   window.location.href = "report_manage_item_past_date.php?id="+ inv_b2b_id;

				}

			}



			xmlhttp.open("GET","manage_box_next_load_available_date_upddelay.php?unqid=" +unqid + "&inv_loop_id="+ inv_loop_id +"&next_load_av_date_delay="+document.getElementById("select_loadid"+unqid).value,true);

			xmlhttp.send();

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



		function delete_next_load_av_date(unqid)

		{

			var choice = confirm('Are you sure you want to delete?');

			if (choice === false) {

				return false;

			}



			document.getElementById("hd_action").value = "delete";

			document.getElementById("hd_unqid").value = unqid;

			document.frm_manage_box_next_load_available_date.submit();

		}





		function load_all()

		{

			document.getElementById("hd_showall").value = "showall";

			document.frm_manage_box_next_load_available_date.submit();

		}



		function showdelaytool()

		{

			if (document.getElementById("div_delay_tool_child").style.display == "none"){

				document.getElementById("div_delay_tool_child").style.display='block';

				document.getElementById("chk_select_all").style.display='block';

				document.getElementById("chk_select_all").checked = true;



				totctrl = document.getElementById("totcotrols").value;



				for (counter = 1; counter <= totctrl; counter=counter+1)

				{

					if (document.getElementById("chk_select"+counter)){

						document.getElementById("chk_select"+counter).style.display='block';

						document.getElementById("chk_select"+counter).checked = true;

					}

				}



			}else{

				document.getElementById("div_delay_tool_child").style.display='none';

				document.getElementById("chk_select_all").style.display='none';

				document.getElementById("chk_select_all").checked = true;



				totctrl = document.getElementById("totcotrols").value;



				for (counter = 1; counter <= totctrl; counter=counter+1)

				{

					if (document.getElementById("chk_select"+counter)){

						document.getElementById("chk_select"+counter).style.display='none';

						document.getElementById("chk_select"+counter).checked = false;

					}

				}



			}

		}



		function setthe_comp()

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

					document.getElementById("sales_comp").value = xmlhttp.responseText;

				}

			}



			xmlhttp.open("GET","manage_box_next_load_available_date_getcompid.php?transid=" +document.getElementById("add_sales_trans").value,true);

			xmlhttp.send();

		}





	</script>



	<style>

		.white_content {

			display: none;

			position: absolute;

			top: 5%;

			left: 10%;

			width: 40%;

			height: 30%;

			padding: 16px;

			border: 1px solid gray;

			background-color: white;

			z-index:1002;

			overflow: auto;

		}

	</style>

</head>



<body>

<!DOCTYPE html>



	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css' >

	<LINK rel='stylesheet' type='text/css' href='one_style.css' >

	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">



	<div id="light" class="white_content"></div>



	<script language="JavaScript" SRC="inc/CalendarPopup.js"></script>

	<script language="JavaScript" SRC="inc/general.js"></script>

	<script language="JavaScript">document.write(getCalendarStyles());</script>

	<script language="JavaScript" >

		var cal1xx = new CalendarPopup("listdiv");

		cal1xx.showNavigationDropdowns();



		var cal2xx = new CalendarPopup("listdiv");

		cal2xx.showNavigationDropdowns();

	</script>



	<div ID="listdiv" style="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></div>



<?php

$inview_mode = "no";

if (isset($_REQUEST["inview"])) {

    if ($_REQUEST["inview"] == "yes") {

        $inview_mode = "yes";

    }

}

$sql = "SELECT * from loop_employees WHERE id = '" . $_COOKIE['employeeid'] . "'";
// echo $sql;
// echo $_COOKIE['employeeid'];
db();
$viewres = db_query($sql);

$row = array_shift($viewres);

$issuperuser = "no";

if ($row['level'] == 2) {

    $issuperuser = "yes";

}

$box_loop_id = "";
$b2b_id = "";
$loop_id = "";

$sql_transnotes = "SELECT id, b2b_id FROM loop_boxes where b2b_id = '" . $_REQUEST["id"] . "'";
db();
$result_transnotes = db_query($sql_transnotes);

while ($myrowsel_transnotes = array_shift($result_transnotes)) {

    $b2b_id = $myrowsel_transnotes["b2b_id"];

    $box_loop_id = $myrowsel_transnotes["id"];

    $loop_id = $myrowsel_transnotes["id"];

}

$parent_box_id = "";

$redirect_mainpg = "no";

if ($_REQUEST["hd_selectedchk"] != "") {

    if ($_REQUEST["hd_load_available_date_delay"] != "") {

        $chkselectedvalarr = explode(",", $_REQUEST["hd_selectedchk"]);

        foreach ($chkselectedvalarr as $chkselectedval) {

            if ($chkselectedval != "") {

                $load_available_date = "";

                $h_qry1 = "Select load_available_date from loop_next_load_available_history where unqid = '" . $chkselectedval . "'";
                db();
                $h_res1 = db_query($h_qry1);

                while ($h_row1 = array_shift($h_res1)) {

                    $load_available_date = $h_row1["load_available_date"];

                }

                $ins_qry = "Update loop_next_load_available_history set load_available_date = '" . date("Y-m-d", strtotime($load_available_date . ' + ' . $_REQUEST["hd_load_available_date_delay"] . ' days')) . "',

					updated_by_user_id = '" . $_COOKIE['employeeid'] . "', updated_on = '" . date("Y-m-d H:i:s") . "'

					where unqid = '" . $chkselectedval . "'";

                db();
                db_query($ins_qry);

                $sql = "Insert into loop_next_load_available_date_history (next_load_available_unqid, load_available_date, updated_by_user_id, updated_on)

					Select '" . $chkselectedval . "', '" . date("Y-m-d", strtotime($load_available_date . ' + ' . $_REQUEST["hd_load_available_date_delay"] . ' days')) . "',

					 '" . $_COOKIE['employeeid'] . "', '" . date("Y-m-d H:i:s") . "'";
                db();
                $result = db_query($sql);

                $redirect_mainpg = "yes";

            }

        }

    }

}

if (isset($_REQUEST["btnsave_date"])) {

    if ($_REQUEST["btnsave_date"] == "Add") {

        $txtnotes = str_replace("'", "\'", $_REQUEST["txtnotes"]);

        $ins_qry = "Insert into loop_next_load_available_history (trans_rec_id, purchase_pono, load_available_date, inv_loop_id, inv_b2b_id,

			sales_trans_id, updated_by_user_id, updated_on, notes)

			Select '" . $_REQUEST["add_sales_trans"] . "', '" . $_REQUEST["purchase_pono"] . "', '" . date("Y-m-d", strtotime($_REQUEST["add_load_available_date"])) . "', '" . $loop_id . "', '" . $b2b_id . "', '" . $_REQUEST["add_sales_trans"] . "',

			'" . $_COOKIE['employeeid'] . "', '" . date("Y-m-d H:i:s") . "', '" . $txtnotes . "'";
        db();
        db_query($ins_qry);

        $new_id = tep_db_insert_id();

        $sql = "Insert into loop_next_load_available_date_history (next_load_available_unqid, load_available_date, updated_by_user_id, updated_on)

			select '" . $new_id . "', '" . date("Y-m-d", strtotime($_REQUEST["add_load_available_date"])) . "',

			 '" . $_COOKIE['employeeid'] . "', '" . date("Y-m-d H:i:s") . "'";
        db();
        $result = db_query($sql);

    }

    if ($_REQUEST["btnsave_date"] == "Save") {

        $txtnotes = str_replace("'", "\'", $_REQUEST["txtnotes"]);

        $ins_qry = "Update loop_next_load_available_history set trans_rec_id = '" . $_REQUEST["add_sales_trans"] . "', purchase_pono = '" . $_REQUEST["purchase_pono"] . "', load_available_date = '" . date("Y-m-d", strtotime($_REQUEST["add_load_available_date"])) . "',

			inv_loop_id = '" . $loop_id . "', inv_b2b_id = '" . $b2b_id . "',

			sales_trans_id = '" . $_REQUEST["add_sales_trans"] . "', updated_by_user_id = '" . $_COOKIE['employeeid'] . "', updated_on = '" . date("Y-m-d H:i:s") . "'

			, notes = '" . $txtnotes . "' where unqid = '" . $_REQUEST["unqid"] . "'";
        db();
        db_query($ins_qry);

        $sql = "Insert into loop_next_load_available_date_history (next_load_available_unqid, load_available_date, updated_by_user_id, updated_on)

			Select '" . $_REQUEST["unqid"] . "', '" . date("Y-m-d", strtotime($_REQUEST["add_load_available_date"])) . "',

			 '" . $_COOKIE['employeeid'] . "', '" . date("Y-m-d H:i:s") . "'";
        db();
        $result = db_query($sql);

    }

    $redirect_mainpg = "yes";

}

if ($_REQUEST["hd_action_inactive"] == "yes") {

    $qry_upd = "Update loop_next_load_available_history set inactive_delete_flg = 2, inactive_reason_id = '" . $_REQUEST["inactive_reason"] . "',

		inactive_reason_notes = '" . str_replace("'", "\'", $_REQUEST["txtnotes_markinactive"]) . "' where unqid = '" . $_REQUEST["unqid_action_inactive"] . "'";
    db();
    db_query($qry_upd);

    $b2b_id = $_REQUEST["id"];

    $redirect_mainpg = "yes";

}

if (isset($_REQUEST["hd_action"])) {

    if ($_REQUEST["hd_action"] == "delete") {

        $qry_upd = "Update loop_next_load_available_history set inactive_delete_flg = 3

			where unqid = '" . $_REQUEST["hd_unqid"] . "'";
        db();
        db_query($qry_upd);

        $b2b_id = $_REQUEST["id"];

        $redirect_mainpg = "yes";

    }

}

if ($redirect_mainpg == "yes") {

    echo "<script type=\"text/javascript\">";

    echo "window.location.href=\"report_manage_item_past_date.php?id=" . $b2b_id . "\";";

    echo "</script>";

    echo "<noscript>";

    echo "<meta http-equiv=\"refresh\" content=\"0;url=report_manage_item_past_date.php?id=" . $b2b_id . "\" />";

    echo "</noscript>";exit;

}

$gaylordstatuspg = "no";

if ($_REQUEST["gaylordstatuspg"] == "1") {

    $gaylordstatuspg = "yes";

}

if ($gaylordstatuspg == "no") {

    include "inc/header.php";

}

?>



<div class="main_data_css">

	<div class="dashboard_heading" style="float: left;">

		<div style="float: left;">

			Items with Past Due Ship Dates



			<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>

			<span class="tooltiptext">This report will help Sourcing team to check what are the items that have past due delivery dates. In that way they can follow up with there respective Suppliers.</span></div><br>

		</div>

	</div>



	<div style="line-height:10px;">&nbsp;</div>



	<div style="display: flex; align-items: center;">

		<div style="border:1px solid black!important; background-color: #FFFF99; width: 40px; height: 15px;"></div>

		<p style="margin-left: 10px; margin-right: 10px;">Loads unsold</p>

		<div style="border:1px solid black!important; background-color: #a7f1a7; width: 40px; height: 15px;"></div>

		<p style="margin-left: 10px; margin-right: 10px;">Loads sold</p>

		<div style="border:1px solid black!important; background-color: #f9f3f3; width: 40px; height: 15px;"></div>

		<p style="margin-left: 10px; margin-right: 10px;">Load Lost</p>

		<div style="border:1px solid black!important; background-color: #f5dddc; width: 40px; height: 15px;"></div>

		<p style="margin-left: 10px; margin-right: 10px;">Deleted</p>

	</div>



	<?php

$no_of_rec = 0;
$box_id_list = "";

$sql = "Select * from loop_next_load_available_history where inactive_delete_flg = 0 AND trans_rec_id = 0 and load_available_date <= '" . date("Y-m-d") . "' ORDER BY load_available_date asc";
db();
$dt_res_so = db_query($sql);

$no_of_rec = tep_db_num_rows($dt_res_so);

if ($no_of_rec == 0) {?>

		<div style="font-size:18px; font-family: Arial, Helvetica, sans-serif; height: 26px; text-align: center;">

			No data found.

		</div>

	<?php } else {

    $imgasc = '<img src="images/sort_asc.png" width="6px;" height="12px;">';

    $imgdesc = '<img src="images/sort_desc.png" width="6px;" height="12px;">';

    $sorturl = "report_manage_item_past_date.php?id=" . $_REQUEST['id'] . "&sort_order=";

    ?>



		<form name="frm_manage_box_next_load_available_date" id="frm_manage_box_next_load_available_date" action="#">



			<table width="1200px;">

				<tr align="middle" >

					<td colspan="17" style="font-size:14px; font-family: Arial, Helvetica, sans-serif; background-color: #C0CDDA; height: 16px">

					<b>Available Load Ship Dates Data</b>

					</td>

					<!-- With this report user can add/edit/delete/inactive Next load available date -->

				</tr>

				<tr align="middle" >

					<td bgColor='#ABC5DF'><input type="checkbox" id="chk_select_all" name="chk_select_all" value="1" onclick="chk_selectall()" style="display:none;" /></td>

					<td bgColor='#ABC5DF'  >Load ID

						<a href="<?php echo $sorturl; ?>ASC&sort=unqid"><?php echo $imgasc; ?></a>

						<a href="<?php echo $sorturl; ?>DESC&sort=unqid"><?php echo $imgdesc; ?></a>

					</td>



					<td bgColor='#ABC5DF' >Item Description

						<a href="<?php echo $sorturl; ?>ASC&sort=item_desc"><?php echo $imgasc; ?></a>

						<a href="<?php echo $sorturl; ?>DESC&sort=item_desc"><?php echo $imgdesc; ?></a>

					</td>

					<td bgColor='#ABC5DF'  >Supplier Name

						<a href="<?php echo $sorturl; ?>ASC&sort=suppname"><?php echo $imgasc; ?></a>

						<a href="<?php echo $sorturl; ?>DESC&sort=suppname"><?php echo $imgdesc; ?></a>

					</td>

					<td bgColor='#ABC5DF' >Account Owner

						<a href="<?php echo $sorturl; ?>ASC&sort=acc_owner"><?php echo $imgasc; ?></a>

						<a href="<?php echo $sorturl; ?>DESC&sort=acc_owner"><?php echo $imgdesc; ?></a>

					</td>



					<td bgColor='#ABC5DF' >Available Load Ship Dates

						<a href="<?php echo $sorturl; ?>ASC&sort=nextloadav"><?php echo $imgasc; ?></a>

						<a href="<?php echo $sorturl; ?>DESC&sort=nextloadav"><?php echo $imgdesc; ?></a>

					</td>

					<td bgColor='#ABC5DF'  >Notes

						<a href="<?php echo $sorturl; ?>ASC&sort=notes"><?php echo $imgasc; ?></a>

						<a href="<?php echo $sorturl; ?>DESC&sort=notes"><?php echo $imgdesc; ?></a>

					</td>

					<td  bgColor='#ABC5DF'  >Update By

						<a href="<?php echo $sorturl; ?>ASC&sort=nextloadav_updby"><?php echo $imgasc; ?></a>

						<a href="<?php echo $sorturl; ?>DESC&sort=nextloadav_updby"><?php echo $imgdesc; ?></a>

					</td>

					<td  bgColor='#ABC5DF'  >Update On

						<a href="<?php echo $sorturl; ?>ASC&sort=nextloadav_updon"><?php echo $imgasc; ?></a>

						<a href="<?php echo $sorturl; ?>DESC&sort=nextloadav_updon"><?php echo $imgdesc; ?></a>

					</td>

					<td bgColor='#ABC5DF'  >PO #

						<a href="<?php echo $sorturl; ?>ASC&sort=pono"><?php echo $imgasc; ?></a>

						<a href="<?php echo $sorturl; ?>DESC&sort=pono"><?php echo $imgdesc; ?></a>

					</td>

					<td bgColor='#ABC5DF'  >Trans ID

						<a href="<?php echo $sorturl; ?>ASC&sort=transid"><?php echo $imgasc; ?></a>

						<a href="<?php echo $sorturl; ?>DESC&sort=transid"><?php echo $imgdesc; ?></a>

					</td>

					<td bgColor='#ABC5DF'  >Sales Company Name

						<a href="<?php echo $sorturl; ?>ASC&sort=compname"><?php echo $imgasc; ?></a>

						<a href="<?php echo $sorturl; ?>DESC&sort=compname"><?php echo $imgdesc; ?></a>

					</td>



					<?php if ($_REQUEST["chk_load_lost"] == 1) {?>

						<td bgColor='#ABC5DF'  >Load Lost details

						</td>

					<?php }?>



					<?php if ($inview_mode == "no") {?>

						<td bgColor='#ABC5DF'  >&nbsp;</td>

						<td bgColor='#ABC5DF'  >&nbsp;</td>

						<?php if ($issuperuser == "yes") {?>

							<td bgColor='#ABC5DF'  >&nbsp;</td>

						<?php }?>

					<?php }?>

				</tr>



				<?php

    $MGarray = array();

    $cnt_no = 0;

    while ($so_row_main = array_shift($dt_res_so)) {

        $show_rec = "yes";

        if ($_REQUEST["chk_load_unsold"] == 1 && $_REQUEST["chk_load_sold"] == 0) {

            $show_rec = "no";

            if ($so_row_main["trans_rec_id"] == '') {

                $show_rec = "yes";

            }

        }

        if ($_REQUEST["chk_load_unsold"] == 0 && $_REQUEST["chk_load_sold"] == 1) {

            $show_rec = "no";

            if ($so_row_main["trans_rec_id"] != '') {

                $show_rec = "yes";

            }

        }

        if ($_REQUEST["chk_load_unsold"] == 1 && $_REQUEST["chk_load_sold"] == 1) {

            $show_rec = "yes";

        }

        if ($show_rec == "yes") {

            $trans_rec_id = $so_row_main["trans_rec_id"];

            $com_b2bid = 0;
            $comp_warehouse_id = 0;
            $trans_comp_nm = "";

            $sql_transnotes = "SELECT loop_warehouse.b2bid, loop_warehouse.id as warehouse_id FROM loop_transaction_buyer inner join loop_warehouse on loop_warehouse.id = loop_transaction_buyer.warehouse_id

						where loop_transaction_buyer.id = '" . $trans_rec_id . "'";
            db();
            $result_transnotes = db_query($sql_transnotes);

            while ($myrowsel_transnotes = array_shift($result_transnotes)) {

                $com_b2bid = $myrowsel_transnotes["b2bid"];

                $comp_warehouse_id = $myrowsel_transnotes["warehouse_id"];

            }

            $trans_comp_nm = get_nickname_val("Blank", $com_b2bid);

            $notes_data = "";
            $updated_by_user = "";
            $updated_on = "";
            $updated_by_user = "";

            if ($so_row_main["trans_rec_id"] == '') {

                $notes_data = $so_row_main["notes"];

                $sql_transnotes = "SELECT loop_employees.initials FROM loop_employees where id = '" . $so_row_main["updated_by_user_id"] . "'";
                db();
                $result_transnotes = db_query($sql_transnotes);

                while ($myrowsel_transnotes = array_shift($result_transnotes)) {

                    $updated_by_user = $myrowsel_transnotes["initials"];

                }

                $updated_on = $so_row_main["updated_on"];

            } else {

                $notes_emp_id = "";

                $sql_transnotes = "SELECT message, employee_id, date FROM loop_transaction_notes where company_id = '" . $comp_warehouse_id . "' and rec_id = '" . $trans_rec_id . "' order by id desc limit 1";
                db();
                $result_transnotes = db_query($sql_transnotes);

                while ($myrowsel_transnotes = array_shift($result_transnotes)) {

                    $notes_data = $myrowsel_transnotes["message"];

                    $notes_emp_id = $myrowsel_transnotes["employee_id"];

                    $updated_on = $myrowsel_transnotes["date"];

                }

                $sql_transnotes = "SELECT loop_employees.initials FROM loop_employees where id = '" . $notes_emp_id . "'";
                db();
                $result_transnotes = db_query($sql_transnotes);

                while ($myrowsel_transnotes = array_shift($result_transnotes)) {

                    $updated_by_user = $myrowsel_transnotes["initials"];

                }

            }

            $inv_box_desc = "";
            $vendor_b2b_rescue = "";

            $h_qry1 = "Select bdescription, vendor_b2b_rescue from loop_boxes where id = '" . $so_row_main["inv_loop_id"] . "'";

            $h_res1 = db_query($h_qry1);

            while ($h_row1 = array_shift($h_res1)) {

                $inv_box_desc = $h_row1["bdescription"];

                $vendor_b2b_rescue = $h_row1["vendor_b2b_rescue"];

            }

            $supplier_nm = "";
            $supplier_b2bid = "";
            $acc_owner = "";
            $supplier_owner = "";
            $sql3 = "SELECT id, company_name, b2bid FROM loop_warehouse where rec_type = 'Manufacturer' and id = '" . $vendor_b2b_rescue . "'";
            db();
            $res3 = db_query($sql3);

            while ($row3 = array_shift($res3)) {

                $cname = $row3['company_name'];

                if ($row3['company_name'] == "") {$cname = "Blank";}

                $supplier_b2bid = $row3["b2bid"];

                $name = get_nickname_val($cname, $row3["b2bid"]);

                $supplier_nm = $name . " (Loop ID: " . $row3["id"] . " B2B ID:" . $row3["b2bid"] . ")";

                $comqry = "select *,employees.name as empname from companyInfo inner join employees on employees.employeeID=companyInfo.assignedto

							where employees.status='Active' and companyInfo.id=" . $row3["b2bid"];
                db_b2b();
                $comres = db_query($comqry);

                while ($comrow = array_shift($comres)) {

                    $supplier_owner = $comrow["employeeID"];

                }

                if ($supplier_owner != "") {

                    $comqry = "select employeeID,employees.name as empname from employees where employeeID='" . $supplier_owner . "'";
                    db_b2b();
                    $comres = db_query($comqry);

                    while ($comrow = array_shift($comres)) {

                        $acc_owner = $comrow["empname"];

                    }

                }

            }

            $ship_qry = "SELECT loop_salesorders.so_date, planned_delivery_dt_customer_confirmed, loop_salesorders.warehouse_id, loop_salesorders.qty AS QTY, loop_warehouse.b2bid, loop_warehouse.company_name AS NAME,

						loop_transaction_buyer.id as transid, loop_transaction_buyer.po_delivery, loop_transaction_buyer.po_delivery_dt,

						loop_transaction_buyer.Preorder, loop_transaction_buyer.ops_delivery_date FROM loop_salesorders ";

            $ship_qry .= " INNER JOIN loop_warehouse ON loop_salesorders.warehouse_id = loop_warehouse.id ";

            $ship_qry .= " INNER JOIN loop_transaction_buyer ON loop_transaction_buyer.id = loop_salesorders.trans_rec_id ";

            $ship_qry .= " WHERE loop_salesorders.box_id = " . $so_row_main["inv_loop_id"] . " and loop_transaction_buyer.shipped = 0 and loop_transaction_buyer.ignore = 0";

            db();
            $dt_res_so1 = db_query($ship_qry);

            $so_row = array_shift($dt_res_so1);

            $sql_transnotes = "SELECT *, loop_employees.initials AS EI FROM loop_transaction_notes

						INNER JOIN loop_employees ON loop_transaction_notes.employee_id = loop_employees.id

						WHERE loop_transaction_notes.company_id = '" . $so_row["warehouse_id"] . "' AND  loop_transaction_notes.rec_id = '" . $so_row["transid"] . "' ORDER BY loop_transaction_notes.id DESC limit 1";
            db();
            $result_transnotes = db_query($sql_transnotes);

            $trans_log_notes = "";
            $trans_log_emp = "";
            $trans_log_dt = "";

            while ($myrowsel_transnotes = array_shift($result_transnotes)) {

                $trans_log_notes = $myrowsel_transnotes["message"];

                $trans_log_emp = $myrowsel_transnotes["EI"];

                if ($myrowsel_transnotes["date"] != "") {

                    $trans_log_dt = $myrowsel_transnotes["date"] . " CT";

                } else {

                    $trans_log_dt = "";

                }

            }

            $comp_nm = get_nickname_val($so_row["NAME"], $so_row["b2bid"]);

            //$bg = '#E4EAEB';

            if ($so_row["po_delivery_dt"] == "") {

                //$po_deli_date = $so_row["po_delivery"];

                $po_deli_date = strtotime($so_row["po_delivery"]);

            } else {

                //$po_deli_date = date("m/d/Y" , strtotime($so_row["po_delivery_dt"]));

                $po_deli_date = strtotime($so_row["po_delivery_dt"]);

            }

            $cnt_no = $cnt_no + 1;

            $com_b2bid_pono = "";

            $sql_transnotes = "SELECT companyID FROM quote where poNumber = '" . $so_row_main["purchase_pono"] . "'";
            db_b2b();
            $result_transnotes = db_query($sql_transnotes);

            while ($myrowsel_transnotes = array_shift($result_transnotes)) {

                $com_b2bid_pono = $myrowsel_transnotes["companyID"];

            }

            $inactive_reason = "";

            $sql_transnotes = "SELECT inactive_reason FROM loop_next_load_available_inactive_reason where unqid = '" . $so_row_main["inactive_reason_id"] . "'";
            db();
            $result_transnotes = db_query($sql_transnotes);

            while ($myrowsel_transnotes = array_shift($result_transnotes)) {

                $inactive_reason = $myrowsel_transnotes["inactive_reason"];

            }

            $date_history_data_flg = "no";

            $sql_transnotes = "SELECT next_load_available_unqid FROM loop_next_load_available_date_history where next_load_available_unqid = '" . $so_row_main["unqid"] . "' limit 1";
            db();
            $result_transnotes = db_query($sql_transnotes);

            while ($myrowsel_transnotes = array_shift($result_transnotes)) {

                $date_history_data_flg = "yes";

            }

            $date_notes_history_data_flg = "no";

            $sql_transnotes = "SELECT next_load_available_unqid FROM loop_next_load_available_note_history where next_load_available_unqid = '" . $so_row_main["unqid"] . "' limit 1";
            db();
            $result_transnotes = db_query($sql_transnotes);

            while ($myrowsel_transnotes = array_shift($result_transnotes)) {

                $date_notes_history_data_flg = "yes";

            }

            $MGarray[] = array('unqid' => $so_row_main["unqid"], 'box_id' => $_REQUEST["id"], 'transid' => $so_row_main["trans_rec_id"], 'load_available_date' => $so_row_main["load_available_date"],

                'updated_by_user' => $updated_by_user, 'updated_on' => $updated_on, 'trans_rec_id' => $trans_rec_id, 'purchase_pono' => $so_row_main["purchase_pono"], 'com_b2bid_pono' => $com_b2bid_pono,

                'com_b2bid' => $com_b2bid, 'comp_warehouse_id' => $comp_warehouse_id, 'trans_comp_nm' => $trans_comp_nm, 'inactive_delete_flg' => $so_row_main["inactive_delete_flg"],

                'inactive_reason_notes' => $so_row_main["inactive_reason_notes"], 'inactive_reason' => $inactive_reason, 'date_history_data_flg' => $date_history_data_flg, 'date_notes_history_data_flg' => $date_notes_history_data_flg,

                'inv_loop_id' => $so_row_main["inv_loop_id"], 'inv_b2b_id' => $so_row_main["inv_b2b_id"], 'inv_box_desc' => $inv_box_desc,

                'qty' => $so_row["QTY"], 'so_date' => $so_row["so_date"], 'po_deli_date' => $po_deli_date, 'Preorder' => $so_row["Preorder"], 'supplier_b2bid' => $supplier_b2bid,

                'comp_nm' => $comp_nm, 'ops_delivery_date' => $so_row["ops_delivery_date"], 'supplier_nm' => $supplier_nm, 'acc_owner' => $acc_owner,

                'warehouse_id' => $so_row["warehouse_id"], 'notes' => $notes_data, 'planned_delivery_dt_confirmed' => $so_row["planned_delivery_dt_customer_confirmed"],

                'emp_int' => $trans_log_emp, 'log_dt' => $trans_log_dt);

        }

    }

    if ($_REQUEST['sort'] == "unqid") {

        $MGArraysort_I = array();

        foreach ($MGarray as $MGArraytmp) {

            $MGArraysort_I[] = $MGArraytmp['unqid'];

        }

        if ($_REQUEST['sort_order'] == "ASC") {

            array_multisort($MGArraysort_I, SORT_ASC, SORT_NUMERIC, $MGarray);

        } else {

            array_multisort($MGArraysort_I, SORT_DESC, SORT_NUMERIC, $MGarray);

        }

    }

    if ($_REQUEST['sort'] == "transid") {

        $MGArraysort_I = array();

        foreach ($MGarray as $MGArraytmp) {

            $MGArraysort_I[] = $MGArraytmp['transid'];

        }

        if ($_REQUEST['sort_order'] == "ASC") {

            array_multisort($MGArraysort_I, SORT_ASC, SORT_NUMERIC, $MGarray);

        } else {

            array_multisort($MGArraysort_I, SORT_DESC, SORT_NUMERIC, $MGarray);

        }

    }

    if ($_REQUEST['sort'] == "item_desc") {

        $MGArraysort_I = array();

        foreach ($MGarray as $MGArraytmp) {

            $MGArraysort_I[] = $MGArraytmp['inv_box_desc'];

        }

        if ($_REQUEST['sort_order'] == "ASC") {

            array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGarray);

        } else {

            array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGarray);

        }

    }

    if ($_REQUEST['sort'] == "suppname") {

        $MGArraysort_I = array();

        foreach ($MGarray as $MGArraytmp) {

            $MGArraysort_I[] = $MGArraytmp['supplier_nm'];

        }

        if ($_REQUEST['sort_order'] == "ASC") {

            array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGarray);

        } else {

            array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGarray);

        }

    }

    if ($_REQUEST['sort'] == "acc_owner") {

        $MGArraysort_I = array();

        foreach ($MGarray as $MGArraytmp) {

            $MGArraysort_I[] = $MGArraytmp['acc_owner'];

        }

        if ($_REQUEST['sort_order'] == "ASC") {

            array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGarray);

        } else {

            array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGarray);

        }

    }

    if ($_REQUEST['sort'] == "nextloadav") {

        $MGArraysort_I = array();

        foreach ($MGarray as $MGArraytmp) {

            $MGArraysort_I[] = $MGArraytmp['load_available_date'];

        }

        if ($_REQUEST['sort_order'] == "ASC") {

            array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGarray);

        } else {

            array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGarray);

        }

    }

    if ($_REQUEST['sort'] == "nextloadav_updby") {

        $MGArraysort_I = array();

        foreach ($MGarray as $MGArraytmp) {

            $MGArraysort_I[] = $MGArraytmp['updated_by_user'];

        }

        if ($_REQUEST['sort_order'] == "ASC") {

            array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGarray);

        } else {

            array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGarray);

        }

    }

    if ($_REQUEST['sort'] == "nextloadav_updon") {

        $MGArraysort_I = array();

        foreach ($MGarray as $MGArraytmp) {

            $MGArraysort_I[] = $MGArraytmp['updated_on'];

        }

        if ($_REQUEST['sort_order'] == "ASC") {

            array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGarray);

        } else {

            array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGarray);

        }

    }

    if ($_REQUEST['sort'] == "compname") {

        $MGArraysort_I = array();

        foreach ($MGarray as $MGArraytmp) {

            $MGArraysort_I[] = $MGArraytmp['trans_comp_nm'];

        }

        if ($_REQUEST['sort_order'] == "ASC") {

            array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGarray);

        } else {

            array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGarray);

        }

    }

    if ($_REQUEST['sort'] == "pono") {

        $MGArraysort_I = array();

        foreach ($MGarray as $MGArraytmp) {

            $MGArraysort_I[] = $MGArraytmp['purchase_pono'];

        }

        if ($_REQUEST['sort_order'] == "ASC") {

            array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGarray);

        } else {

            array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGarray);

        }

    }

    if ($_REQUEST['sort'] == "notes") {

        $MGArraysort_I = array();

        foreach ($MGarray as $MGArraytmp) {

            $MGArraysort_I[] = $MGArraytmp['notes'];

        }

        if ($_REQUEST['sort_order'] == "ASC") {

            array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $MGarray);

        } else {

            array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $MGarray);

        }

    }

    $cnt_no = 1;
    $box_loop_no_prev = "";

    foreach ($MGarray as $MGArraytmp2) {

        if (($cnt_no % 2) == 0) {

            $bg = "#E4E4E4";

        } else {

            $bg = "#CCCCCC";

        }

        if ($MGArraytmp2["transid"] == "") {

            $bg = "#FFFF99";

        }

        if ($MGArraytmp2["transid"] != "") {

            $bg = "#a7f1a7";

        }

        if ($MGArraytmp2["inactive_delete_flg"] == 2) {

            $bg = "#f9f3f3";

        }

        if ($MGArraytmp2["inactive_delete_flg"] == 3) {

            $bg = "#f5dddc";

        }

        ?>

						<tr id="inventory_preord_middle_div_<?php echo $cnt_no; ?>">

							<td bgColor="<?php echo $bg; ?>"><input type="checkbox" id="chk_select<?php echo $cnt_no; ?>" name="chk_select[]" value="<?php echo $MGArraytmp2["unqid"]; ?>" style="display:none;" /></td>



							<td width="50px" bgColor="<?php echo $bg; ?>"><?php echo $MGArraytmp2["unqid"]; ?></td>



							<td width="150px" bgColor="<?php echo $bg; ?>"><a href="manage_box_b2bloop.php?id=<?php echo $MGArraytmp2["inv_loop_id"]; ?>&proc=View" target="_blank"><?php echo $MGArraytmp2["inv_box_desc"]; ?></a></td>

							<td width="150px" bgColor="<?php echo $bg; ?>"><a href="viewCompany.php?ID=<?php echo $MGArraytmp2["supplier_b2bid"]; ?>" target="_blank"><?php echo $MGArraytmp2["supplier_nm"]; ?></a></td>

							<td width="50px" bgColor="<?php echo $bg; ?>"><?php echo $MGArraytmp2["acc_owner"]; ?></td>



							<?php if ($parent_loop_box_id > 0) {?>

								<td bgColor="<?php echo $bg; ?>"><?php echo $MGArraytmp2["inv_b2b_id"]; ?></td>

							<?php }?>

							<td width="200px" bgColor="<?php echo $bg; ?>">

								<input type="text" name="load_available_date<?php echo $MGArraytmp2["unqid"] . $cnt_no; ?>" id="load_available_date<?php echo $MGArraytmp2["unqid"] . $cnt_no; ?>" size="11" value="<?php if ($MGArraytmp2["load_available_date"] == "") {echo "";} else {echo date("m/d/Y", strtotime($MGArraytmp2["load_available_date"]));}?>">

								<a href="#" onclick="cal1xx.select(document.frm_manage_box_next_load_available_date.load_available_date<?php echo $MGArraytmp2["unqid"] . $cnt_no; ?>, 'anchor1xx<?php echo $MGArraytmp2["unqid"] . $cnt_no; ?>','MM/dd/yyyy'); return false;" name="anchor1xx" id="anchor1xx<?php echo $MGArraytmp2["unqid"] . $cnt_no; ?>">

								<img border="0" src="images/calendar.jpg"></a>

								<?php if ($MGArraytmp2["date_history_data_flg"] == "yes") {?>

									<a id="tag_showdatehistory<?php echo $MGArraytmp2["unqid"]; ?>" href="#" onclick="showdatehistory(<?php echo $MGArraytmp2["unqid"]; ?>,1); return false;">History</a>

								<?php }?>

							</td>



							<td width="250px" bgColor="<?php echo $bg; ?>">

								<textarea rows="4" cols="35" name="txtnotes" id="txtnotes<?php echo $MGArraytmp2["unqid"] . $cnt_no; ?>"><?php echo $MGArraytmp2["notes"]; ?></textarea>

								<?php if ($MGArraytmp2["date_notes_history_data_flg"] == "yes") {?>

									<a id="tag_showdatehistory<?php echo $MGArraytmp2["unqid"]; ?>" href="#" onclick="showdatehistory(<?php echo $MGArraytmp2["unqid"]; ?>, 2); return false;">Load ID Notes History</a>

								<?php }?>

								<?php if ($MGArraytmp2["transid"] != "") {?>

									<a id="tag_showdatehistory<?php echo $MGArraytmp2["unqid"]; ?>" href="#" onclick="showdatehistory(<?php echo $MGArraytmp2["unqid"]; ?>, 3); return false;">Transaction Log History</a>



									<input type="hidden" id="trans_rec_id<?php echo $MGArraytmp2["unqid"]; ?>" name="trans_rec_id" value="<?php echo $MGArraytmp2["transid"]; ?>" />

									<input type="hidden" id="comp_warehouse_id<?php echo $MGArraytmp2["unqid"]; ?>" name="comp_warehouse_id" value="<?php echo $MGArraytmp2["comp_warehouse_id"]; ?>"/>



								<?php }?>

							</td>

							<td width="50px" bgColor="<?php echo $bg; ?>"><?php echo $MGArraytmp2["updated_by_user"]; ?></td>

							<td width="70px" bgColor="<?php echo $bg; ?>"><?php echo date("m/d/Y H:i:s", strtotime($MGArraytmp2["updated_on"])); ?></td>

							<?php if ($MGArraytmp2["purchase_pono"] == "") {?>

								<td width="100px" bgColor="<?php echo $bg; ?>">

									<span id="po_no_ctrl<?php echo $MGArraytmp2["unqid"]; ?>"><font color='red'>No PO linked yet</font></span>

									<span id="po_no_ctrl_edit<?php echo $MGArraytmp2["unqid"]; ?>" style="display:none;">

										<input type="text" name="purchase_pono" id="purchase_pono<?php echo $MGArraytmp2["unqid"]; ?>" size="10" value=""><br><i>(If no PO Number yet, leave blank)</i>

										<input type="button" name="btn_purchase_pono" id="btn_purchase_pono" onclick="po_no_edit_save(<?php echo $MGArraytmp2["unqid"]; ?>, <?php echo $_REQUEST["id"]; ?>)" value="Save">

									</span>

									<img src="images/edit.jpg" onclick="po_no_edit(<?php echo $MGArraytmp2["unqid"]; ?>)" style="cursor: pointer;">

								</td>

							<?php } else {?>

								<td width="100px" id="td_pono<?php echo $MGArraytmp2["unqid"]; ?>" bgColor="<?php echo $bg; ?>">

									<span id="po_no_ctrl<?php echo $MGArraytmp2["unqid"]; ?>">

										<?php

            $inrec_flg = "no";

            $query = "SELECT * FROM quote WHERE poNumber= '" . $MGArraytmp2["purchase_pono"] . "'";
            db_b2b();
            $dt_view_res3 = db_query($query);

            while ($objQuote = array_shift($dt_view_res3)) {

                $inrec_flg = "yes";

                if ($objQuote["filename"] != "") {?>

												<?php

                    $archeive_date = new DateTime(date("Y-m-d", strtotime($quotes_archive_date)));

                    $quote_date = new DateTime(date("Y-m-d", strtotime($objQuote["quoteDate"])));

                    if ($quote_date < $archeive_date) {

                        //if ( $objQuote["ID"] <= 1232290) {

                        if ($objQuote["missing_file_email_folder"] != '') {

                            ?>

														<a target="_blank" href="https://usedcardboardboxes.sharepoint.com/:b:/r/sites/LoopsCRMEmailAttachments/Shared%20Documents/before_2022/<?php echo $objQuote["missing_file_email_folder"] ?>/<?php echo $objQuote["filename"] ?>"><?php echo $MGArraytmp2["purchase_pono"] ?></a>

													<?php
} else {?>

														<a target="_blank" href="https://usedcardboardboxes.sharepoint.com/:b:/r/sites/LoopsCRMEmailAttachments/Shared%20Documents/quotes/before_oct_18_2022/<?php echo $objQuote["filename"] ?>"><?php echo $MGArraytmp2["purchase_pono"] ?></a>

												<?php
}

                    } else {

                        ?>

													<a href='#' id='quotespdfs<?php echo $objQuote["ID"] ?>' onclick="show_file_inviewer_pos('quotes/<?php echo $objQuote["filename"]; ?>', 'Quote', 'quotespdfs<?php echo $objQuote["ID"] ?>'); return false;"><?php echo $MGArraytmp2["purchase_pono"] ?></a>

												<?php
}?>

											<?php } else {?>

												<a target="_blank" href="viewCompany.php?ID=<?php echo $MGArraytmp2["com_b2bid_pono"]; ?>&proc=View&searchcrit=&show=Quoting&rec_type=Manufacturer"><?php echo $MGArraytmp2["purchase_pono"]; ?></a>

											<?php }

            }?>



										<?php if ($inrec_flg == "no") {?>

											<?php echo $MGArraytmp2["purchase_pono"]; ?>

										<?php }?>

									</span>

									<span id="po_no_ctrl_edit<?php echo $MGArraytmp2["unqid"]; ?>" style="display:none;">

										<input type="text" name="purchase_pono" id="purchase_pono<?php echo $MGArraytmp2["unqid"]; ?>" size="10" value="<?php echo $MGArraytmp2["purchase_pono"]; ?>"><br><i>(If no PO Number yet, leave blank)</i>

										<input type="button" name="btn_purchase_pono" id="btn_purchase_pono" onclick="po_no_edit_save(<?php echo $MGArraytmp2["unqid"]; ?>, <?php echo $_REQUEST["id"]; ?>)" value="Save">

									</span>

									<img src="images/edit.jpg" onclick="po_no_edit(<?php echo $MGArraytmp2["unqid"]; ?>); return false;" style="cursor: pointer;">

								</td>

							<?php }?>



							<?php if ($MGArraytmp2["transid"] == "") {?>

								<td width="100px" id="td_transid<?php echo $MGArraytmp2["unqid"]; ?>" bgColor="<?php echo $bg; ?>">

									<span id="transid_ctrl<?php echo $MGArraytmp2["unqid"]; ?>"><font color='red'>Load not sold yet</font></span>

									<span id="transid_ctrl_edit<?php echo $MGArraytmp2["unqid"]; ?>" style="display:none;">

										<input type="text" name="txttransid" id="txttransid<?php echo $MGArraytmp2["unqid"]; ?>" size="10" value=""><br><i>(If not sold yet leave blank)</i>

										<input type="button" name="btn_transid" id="btn_transid" onclick="transid_save(<?php echo $MGArraytmp2["unqid"]; ?>, <?php echo $_REQUEST["id"]; ?>)" value="Save">

									</span>

									<img src="images/edit.jpg" onclick="transid_edit(<?php echo $MGArraytmp2["unqid"]; ?>); return false;" style="cursor: pointer;">

									</td>

							<?php } else {?>

								<td width="100px" id="td_transid<?php echo $MGArraytmp2["unqid"]; ?>" bgColor="<?php echo $bg; ?>">

									<span id="transid_ctrl<?php echo $MGArraytmp2["unqid"]; ?>">

										<a target="_blank" href="viewCompany.php?ID=<?php echo $MGArraytmp2["com_b2bid"]; ?>&show=transactions&warehouse_id=<?php echo $MGArraytmp2["comp_warehouse_id"]; ?>&rec_type=Supplier&proc=View&searchcrit=&id=<?php echo $MGArraytmp2["comp_warehouse_id"]; ?>&rec_id=<?php echo $MGArraytmp2["trans_rec_id"]; ?>&display=buyer_view"><?php echo $MGArraytmp2["trans_rec_id"]; ?></a>

									</span>

									<span id="transid_ctrl_edit<?php echo $MGArraytmp2["unqid"]; ?>" style="display:none;">

										<input type="text" name="txttransid" id="txttransid<?php echo $MGArraytmp2["unqid"]; ?>" size="10" value="<?php echo $MGArraytmp2["transid"]; ?>"><br><i>(If not sold yet leave blank)</i>

										<input type="button" name="btn_transid" id="btn_transid" onclick="transid_save(<?php echo $MGArraytmp2["unqid"]; ?>, <?php echo $_REQUEST["id"]; ?>)" value="Save">

									</span>

									<img src="images/edit.jpg" onclick="transid_edit(<?php echo $MGArraytmp2["unqid"]; ?>); return false;" style="cursor: pointer;">

								</td>

							<?php }?>

							<td width="200px" id="td_transcomp<?php echo $MGArraytmp2["unqid"]; ?>" bgColor="<?php echo $bg; ?>"><a target="_blank" href="viewCompany.php?ID=<?php echo $MGArraytmp2["com_b2bid"]; ?>&show=transactions&warehouse_id=<?php echo $MGArraytmp2["comp_warehouse_id"]; ?>&rec_type=Supplier&proc=View&searchcrit=&id=<?php echo $MGArraytmp2["comp_warehouse_id"]; ?>&rec_id=<?php echo $MGArraytmp2["trans_rec_id"]; ?>&display=buyer_view"><?php echo $MGArraytmp2["trans_comp_nm"]; ?></a></td>



							<?php if ($_REQUEST["chk_load_lost"] == 1) {?>

								<td width="150px" bgColor="<?php echo $bg; ?>">

								<?php echo "Reason: " . $MGArraytmp2["inactive_reason"] . "<br>Notes: " . $MGArraytmp2["inactive_reason_notes"]; ?>

								</td>

							<?php }?>



							<td width="20px" bgColor="<?php echo $bg; ?>">

								<input type="button" id="btnsave_data" name="btnsave_data" value="Save"

								onclick="save_next_load_av_date(<?php echo $MGArraytmp2["comp_warehouse_id"]; ?>,<?php echo $MGArraytmp2["transid"]; ?>,<?php echo $cnt_no; ?>, <?php echo $MGArraytmp2['unqid']; ?>)" />

								<span id="span_savebtn<?php echo $cnt_no; ?>"></span>

							</td>



							<td width="20px" bgColor="<?php echo $bg; ?>">

								<input type="button" id="btninactive<?php echo $MGArraytmp2['unqid']; ?>" name="btnedit" value="Load Lost"

								onclick="inactive_next_load_av_date(<?php echo $MGArraytmp2['unqid']; ?>)" />

							</td>

							<?php if ($issuperuser == "yes") {?>

								<td width="20px"  bgColor="<?php echo $bg; ?>">

									<input type="button" id="btndelete" name="btndelete" value="Delete"

									onclick="delete_next_load_av_date(<?php echo $MGArraytmp2['unqid']; ?>)" />

								</td>

							<?php }?>

						</tr>

					<?php

        $cnt_no += 1;

    }?>

				<tr align="middle" >

					<td colspan="13" style="font-size: 14px; font-family: Arial, Helvetica, sans-serif; height: 16px"></td>

				</tr>

			</table>



			<input type="hidden" id="hd_action" name="hd_action" value=""/>

			<input type="hidden" id="inview" name="inview" value="<?php echo $_REQUEST["inview"]; ?>" />

			<input type="hidden" id="hd_showall" name="hd_showall" value=""/>

			<input type="hidden" id="id" name="id" value="<?php echo $_REQUEST["id"]; ?>"/>

			<input type="hidden" id="hd_unqid" name="hd_unqid" value="<?php echo $MGArraytmp2["unqid"]; ?>"/>

			<input type='hidden' name='totcotrols' id='totcotrols' value="<?php echo $cnt_no; ?>">

			<input type='hidden' name='hd_selectedchk' id='hd_selectedchk' value="">

			<input type='hidden' name='hd_load_available_date_delay' id='hd_load_available_date_delay' value="">



		</form>

	<?php
}?>

</div>



		<div id="divtest"></div>

</body>

</html>

