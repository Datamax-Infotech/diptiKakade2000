<?php

//require "inc/header_session.php";
// ini_set("display_errors", "1");

// error_reporting(E_ERROR);
require "../mainfunctions/database.php";

require "../mainfunctions/general-functions.php";

$eid = $_COOKIE['b2b_id'];

$x = "SELECT * from loop_employees WHERE b2b_id = '" . $eid . "'";
db();
$viewres = db_query($x);

$row = array_shift($viewres);

$initials = $row['initials'];

$user_lvl = $row['level'];

$name = $row['name'];

$commission = $row['commission'];

$dashboard_view = $row['dashboard_view'];

$super_user = "";

$sql = "SELECT level FROM loop_employees where initials = '" . $_COOKIE["userinitials"] . "'";
db();
$result = db_query($sql);

while ($rowemp = array_shift($result)) {

    $super_user = $rowemp["level"];

}

// function timestamp_to_date(string $d): string
// {
//     $da = explode(" ", $d);
//     $dp = explode("-", $da[0]);
//     return $dp[1] . "/" . $dp[2] . "/" . $dp[0];
// }

// function timestamp_to_datetime(string $d): string
// {
//     $da = explode(" ", $d);
//     $dp = explode("-", $da[0]);
//     $dh = explode(":", $da[1]);
//     $x = $dp[1] . "/" . $dp[2] . "/" . $dp[0];

//     if ($dh[0] == 12) {
//         //$x .= " " . ($dh[0] - 0) . ":" . $dh[1] . "PM CT";
//         $x .= " " . $dh[0] . ":" . $dh[1] . "PM CT";
//     } elseif ($dh[0] == 0) {
//         $x .= " 12:" . $dh[1] . "AM CT";
//     } elseif ($dh[0] > 12) {
//         //$x .= " " . ($dh[0] - 12) . ":" . $dh[1] . "PM CT";
//         $x .= " " . (intval($dh[0]) - 12) . ":" . $dh[1] . "PM CT";
//     } else {
//         $x .= " " . ($dh[0]) . ":" . $dh[1] . "AM CT";
//     }

//     return $x;
// }

?>

<!DOCTYPE html>

<html>



<head>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title>Browse Warehouse Inventory Tool</title>



<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css' >



<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">

<link rel='stylesheet' type='text/css' href='css/inventory_cron.css'>



	<script>

		function checkboxClicked(){

			totcnt = document.getElementById("tot_count_arry").value;

			var actual_total = 0;

			var after_po_total = 0;

			var total_load_av = 0;

			var loads_considered = 0;

			var frequency_loads = 0;

			var tot_cnt = 0;

			var sel_boxids = ""; var sel_boxids_b2b = "";

			var weighted_avg_FOB = 0;

			var min_fob_wetdavg = 0;

			var wetdavg_tot = 0;



			for (var tmpcnt = 0; tmpcnt < totcnt; tmpcnt++) {

				tdbgcolor = document.getElementById("tr_rowone"+tmpcnt).style.backgroundColor;

				if (tdbgcolor == "rgb(204, 255, 204)"){

					if (tmpcnt % 2 === 0){

						tdbgcolor = '#f4f4f4';

					}else{

						tdbgcolor = '#e4e4e4';

					}

				}



				if (document.getElementById("chk_sel"+tmpcnt).checked == true){

					tot_cnt = tot_cnt + 1;

					var chk_all_details = document.getElementById("chk_sel"+tmpcnt).value;



					var chk_all_details_array = chk_all_details.split('|');



					min_fob_wetdavg = min_fob_wetdavg + (chk_all_details_array[7] * chk_all_details_array[1]);

					if (chk_all_details_array[1] > 0){

						wetdavg_tot = wetdavg_tot + parseFloat(chk_all_details_array[1]);

					}



					//alert(chk_all_details_array[7] + "=" + chk_all_details_array[1] + "=" + min_fob_wetdavg + "=" + wetdavg_tot);



					if (chk_all_details_array[0] != ""){

						actual_total = actual_total + parseFloat(chk_all_details_array[0]);

					}

					if (chk_all_details_array[1] != "" && chk_all_details_array[1] > 0){

						after_po_total = after_po_total + parseFloat(chk_all_details_array[1]);

					}

					if (chk_all_details_array[2] != "" && chk_all_details_array[1] > 0){

						total_load_av = total_load_av + parseFloat(chk_all_details_array[2]);

					}

					if (chk_all_details_array[3] != ""){

						loads_considered = loads_considered + parseFloat(chk_all_details_array[3]);

					}

					if (chk_all_details_array[5] != ""){

						frequency_loads = frequency_loads + parseFloat(chk_all_details_array[5]);

					}



					if (chk_all_details_array[6] != ""){

						if(sel_boxids != ""){

							sel_boxids = sel_boxids + ", " + chk_all_details_array[6];

						}else{

							sel_boxids = chk_all_details_array[6];

						}

					}



					if (chk_all_details_array[8] != ""){

						if(sel_boxids_b2b != ""){

							sel_boxids_b2b = sel_boxids_b2b + ", " + chk_all_details_array[8];

						}else{

							sel_boxids_b2b = chk_all_details_array[8];

						}

					}



					document.getElementById("tr_rowone"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rowtwo"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rowthree"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rowfour"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rowfive"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rowsix"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rowseven"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_roweight"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rownine"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rowten"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_roweleven"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rowtweelve"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rowthirteen"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rowfourteen"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rowfifteen"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rowsixteen"+tmpcnt).style.backgroundColor = '#CCFFCC';

					//document.getElementById("tr_rowtwenty"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_row1seventeen"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_roweighteen"+tmpcnt).style.backgroundColor = '#CCFFCC';

					document.getElementById("tr_rowninteen"+tmpcnt).style.backgroundColor = '#CCFFCC';

				}else{

					document.getElementById("tr_rowone"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rowtwo"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rowthree"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rowfour"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rowfive"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rowsix"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rowseven"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_roweight"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rownine"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rowten"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_roweleven"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rowtweelve"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rowthirteen"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rowfourteen"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rowfifteen"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rowsixteen"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_row1seventeen"+tmpcnt).style.backgroundColor = tdbgcolor;



					document.getElementById("tr_roweighteen"+tmpcnt).style.backgroundColor = tdbgcolor;

					document.getElementById("tr_rowninteen"+tmpcnt).style.backgroundColor = tdbgcolor;

				}

			}



			//alert("Tot" + min_fob_wetdavg + "=" + wetdavg_tot);



			weighted_avg_FOB = min_fob_wetdavg/wetdavg_tot;



			document.getElementById("div_actual_total").innerHTML = Math.round(actual_total).toLocaleString();

			document.getElementById("div_after_po").innerHTML = Math.round(after_po_total).toLocaleString();

			document.getElementById("div_loads_av").innerHTML = total_load_av.toFixed(2) + "%";

			//document.getElementById("div_no_of_loads").innerHTML = (loads_considered/tot_cnt).toFixed(2);

			document.getElementById("div_freq_load").innerHTML = frequency_loads.toFixed(2);



			document.getElementById("div_weighted_avg_FOB").innerHTML = weighted_avg_FOB.toFixed(2);



			if(sel_boxids != ""){

				document.getElementById("selected_listbox").value = sel_boxids;

				document.getElementById("btn_add").disabled = false;

			}else{

				document.getElementById("selected_listbox").value = "";

				document.getElementById("btn_add").disabled = true;

			}



			if(sel_boxids_b2b != ""){

				document.getElementById("selected_listbox_b2b").value = sel_boxids_b2b;

			}else{

				document.getElementById("selected_listbox_b2b").value = "";

			}



		}



		function checkboxSelectAll(){



			totcnt = document.getElementById("tot_count_arry").value;



			for (var tmpcnt = 0; tmpcnt < totcnt; tmpcnt++) {

				if (document.getElementById("chk_sel_all").checked == true){

					document.getElementById("chk_sel"+tmpcnt).checked = true;

				}

				if (document.getElementById("chk_sel_all").checked == false){

					document.getElementById("chk_sel"+tmpcnt).checked = false;

				}

			}



			checkboxClicked();

		}



		function show_inventories(){

			document.getElementById("content_result_div").innerHTML = "<center><br><br> Loading..... <img src='images/wait_animated.gif'/></center>";



			var selectedBoxType = getSelectedCheckboxes("inv_boxtype");

			var selectedWall = getSelectedCheckboxes("inv_boxwall");

            var selectedTop = getSelectedCheckboxes("inv_topconfig");

            var selectedBottom = getSelectedCheckboxes("inv_bottomconfig");

			var selectedShape = getSelectedCheckboxes("inv_boxshape");

			var selectedVents = getSelectedCheckboxes("inv_boxvents");

			var lengthMin = document.getElementById("boxlength_min").value;

			var lengthMax = document.getElementById("boxlength_max").value;

			var widthMin = document.getElementById("boxwidth_min").value;

			var widthMax = document.getElementById("boxwidth_max").value;

			var heightMin = document.getElementById("boxheight_min").value;

			var heightMax = document.getElementById("boxheight_max").value;

			var cubicMin = document.getElementById("boxcubic_min").value;

			var cubicMax = document.getElementById("boxcubic_max").value;

			var warehouse_input = document.getElementById("warehouse_input").value;



			if(window.XMLHttpRequest){

				var xhr = new XMLHttpRequest();

			}else{

				var xhr = new ActiveXObject("Microsoft.XMLHTTP");

			}

			xhr.onreadystatechange = function (){

				if(xhr.readyState == 4 && xhr.status == 200){

					document.getElementById("content_result_div").innerHTML = xhr.responseText;

					moveSummary();

				}

			}

			var data = "boxtype=" + encodeURIComponent(selectedBoxType)	+

                       "&shape=" + encodeURIComponent(selectedShape) +

                       "&wall=" + encodeURIComponent(selectedWall) +

                       "&top=" + encodeURIComponent(selectedTop) +

                       "&bottom=" + encodeURIComponent(selectedBottom) +

					   "&vents=" + encodeURIComponent(selectedVents) +

					   "&heightMin=" + heightMin + "&heightMax=" + heightMax +

					   "&lengthMin=" +lengthMin + "&lengthMax=" + lengthMax +

					   "&widthMin=" + widthMin + "&widthMax=" + widthMax +

					   "&cubicMin=" + cubicMin + "&cubicMax=" + cubicMax + "&warehouse_input=" + warehouse_input;



			xhr.open("POST", "inventory_v1_result.php", true);

			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			xhr.send(data);

		}



		function getSelectedCheckboxes(name) {
			var checkboxes = document.getElementsByName(name);
			var selectedCheckboxes = [];

			checkboxes.forEach(function(checkbox) {
				if (checkbox.checked) {
					selectedCheckboxes.push(checkbox.value);
				}
			});

			return selectedCheckboxes.join(",");
		}

	</script>

	<script>


		function toggleShippingOptions(checkbox) {
			var boxOptions = document.getElementsByName("inv_boxtype");
			var wallOptions = document.getElementsByName("inv_boxwall");
			var bottomOptions = document.getElementsByName("inv_bottomconfig");
			var eleShape = document.getElementById("boxshapediv");
			var boxGOptions = document.getElementById("ginv_boxtype");
			var boxSOptions = document.getElementById("sinv_boxtype");
			var boxToplid = document.getElementById("box_topLid");

			if (checkbox.checked && checkbox.value === "Shipping") {
				wallOptions.forEach(function(option) {
					if (option.value !== "1" && option.value !== "2") {
						option.disabled = true;
						option.parentElement.style.display = "none";
						option.checked = false;
					}
				});

				bottomOptions.forEach(function(boption) {
					if (boption.value !== "1" && boption.value !== "4" && boption.value !== "6") {
						boption.disabled = true;
						boption.parentElement.style.display = "none";
						boption.checked = false;
					}
				});

				boxGOptions.parentElement.style.display = "none";
				eleShape.style.display = "none";
				boxToplid.disabled = true;
				boxToplid.parentElement.style.display = "none";
				document.getElementById("inv_boxlength").style.display = "block";
				document.getElementById("inv_boxwidth").style.display = "block";
				document.getElementById("inv_boxcubic").style.display = "block";
			} else if (checkbox.checked && checkbox.value === "Gaylord") {
				wallOptions.forEach(function(option) {
					option.disabled = false;
					option.parentElement.style.display = "block";
				});

				bottomOptions.forEach(function(boption) {
					if (boption.value === "6") {
						boption.disabled = false;
						boption.parentElement.style.display = "none";
					}
				});

				if (eleShape.style.display === "none") {
					eleShape.style.display = "block";
				}

				boxSOptions.parentElement.style.display = "none";
				boxToplid.disabled = false;
				boxToplid.parentElement.style.display = "block";
				document.getElementById("inv_boxlength").style.display = "none";
				document.getElementById("inv_boxwidth").style.display = "none";
				document.getElementById("inv_boxcubic").style.display = "none";
			} else {
				wallOptions.forEach(function(option) {
					option.disabled = false;
					option.parentElement.style.display = "block";
				});

				bottomOptions.forEach(function(boption) {
					boption.disabled = false;
					boption.parentElement.style.display = "block";
				});

				if (eleShape.style.display === "none") {
					eleShape.style.display = "block";
				}

				boxGOptions.parentElement.style.display = "block";
				boxSOptions.parentElement.style.display = "block";
				boxToplid.disabled = false;
				boxToplid.parentElement.style.display = "block";
				document.getElementById("inv_boxlength").style.display = "block";
				document.getElementById("inv_boxwidth").style.display = "block";
				document.getElementById("inv_boxcubic").style.display = "block";
			}
		}



		function moveSummary(){

			var ele = document.getElementById("summary_report");

			var eleTop = document.getElementById("ucb_own_inventory_summary");



			eleTop.innerHTML = ele.innerHTML;

			ele.style.display = "none";

		}

	</script>

</head>



<body>

	<?php require_once "inc/header.php";?>

	<br>

	<div class="outer-container">

		<div class="container">

			<div class="dashboard_heading" style="float: left;">

				<div style="float: left;">

					Browse Warehouse Inventory Tool



					<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>

					<span class="tooltiptext">This report shows warehouse Inventory Tool.</span></div><br>

				</div>

			</div>



			<div class="main_container1">

				<div class="px-10 content_container">

				<div class="container25 left">

					<div class="content">

						<div class="">

							<div class="inventory_title">Box Type</div>

							<div class="">

								<input type="checkbox" id="ginv_boxtype" name="inv_boxtype" class="filter_option_cb" onclick="show_inventories(); toggleShippingOptions(this);" value="Gaylord">

								<label>GayLord</label>

							</div>

							<div class="">

								<input type="checkbox" id="sinv_boxtype" name="inv_boxtype" class="filter_option_cb" onchange="toggleShippingOptions(this); show_inventories();" value="Shipping">

								<label>Shipping Boxes</label>

							</div>

						</div>



						<div class="">

							<div class="inventory_title">Warehouse</div>

							<div class="">

								<select name="warehouse_input" id="warehouse_input" onchange="show_inventories();">

									<option value="">All</option>

									<?php

										$q1 = "SELECT id, warehouse_name FROM loop_warehouse where rec_type = 'Sorting' and Active = 1 order by warehouse_name";
										db();
										$query = db_query($q1);

										while ($fetch = array_shift($query)) {

											$name = $fetch['warehouse_name'];

											$id = $fetch['id'];

											?>

										<option <?php if ($_REQUEST["warehouse_input"] == $id) {echo " selected ";}?> value="<?php echo $id; ?>"><?php echo $name; ?></option>

									<?php
}?>

								</select>

							</div>

						</div>



						<div class="" id="">

							<div class="inventory_title">Box Flexibility</div>

							<div class="" id="inv_boxlength">

								<div class="inventory_subtitle">Length</div>

								<div class="left">

									<label><input type="text" id="boxlength_min" class="filter_option_cb" onchange="show_inventories();" size="3" value="0">

									Min</label>&emsp;

								</div>

								<div class="">

									<label><input type="text" id="boxlength_max" class="filter_option_cb" onchange="show_inventories();" size="3" value="99">

									Max</label>

								</div>

							</div>



							<div class="" id="inv_boxwidth">

								<div class="inventory_subtitle">Width</div>

								<div class="left">

									<label><input type="text" id="boxwidth_min" class="filter_option_cb" onchange="show_inventories();" size="3" value="0">

									Min</label>&emsp;

								</div>

								<div class="">

									<label><input type="text" id="boxwidth_max" class="filter_option_cb" onchange="show_inventories();" size="3" value="99">

									Max</label>

								</div>

							</div>



							<div class="" id="inv_boxheight">

								<div class="inventory_subtitle">Height</div>

								<div class="left">

									<label><input type="text" id="boxheight_min" class="filter_option_cb" onchange="show_inventories();" size="3" value="0">

									Min</label>&emsp;

								</div>

								<div class="">

									<label><input type="text" id="boxheight_max" class="filter_option_cb" onchange="show_inventories();" size="3" value="99">

									Max</label>

								</div>

							</div>



							<div class="" id="inv_boxcubic">

								<div class="inventory_subtitle">Cubic Footage</div>

								<div class="left">

									<input type="text" id="boxcubic_min" class="filter_option_cb" onchange="show_inventories();" size="3" value="0">

									<label>Min</label>&emsp;

								</div>

								<div class="">

									<input type="text" id="boxcubic_max" class="filter_option_cb" onchange="show_inventories();" size="3" value="99">

									<label>Max</label>

								</div>

							</div>

						</div>



						<div class="" id="boxshapediv">

							<div class="inventory_title">Shape</div>

							<div class="">

								<input type="checkbox" id="" name="inv_boxshape" class="filter_option_cb" onclick="show_inventories();" value="1">

								<label>Rectangular</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_boxshape" class="filter_option_cb" onclick="show_inventories();" value="2">

								<label>Octagonal</label>

							</div>

						</div>

						<div class="">

							<div class="inventory_title"># of Wall</div>

							<div class="">

								<label><input type="checkbox" id="" name="inv_boxwall" class="filter_option_cb" onclick="show_inventories();" value="1">

								1ply</label>

							</div>

							<div class="">

								<label><input type="checkbox" id="" name="inv_boxwall" class="filter_option_cb" onclick="show_inventories();" value="2">

								2ply</label>

							</div>

							<div class="">

								<label><input type="checkbox" id="" name="inv_boxwall" class="filter_option_cb" onclick="show_inventories();" value="3">

								3ply</label>

							</div>

							<div class="">

								<label><input type="checkbox" id="" name="inv_boxwall" class="filter_option_cb" onclick="show_inventories();" value="4">

								4ply</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_boxwall" class="filter_option_cb" onclick="show_inventories();" value="5">

								<label>5ply</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_boxwall" class="filter_option_cb" onclick="show_inventories();" value="6">

								<label>6ply</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_boxwall" class="filter_option_cb" onclick="show_inventories();" value="7">

								<label>7ply</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_boxwall" class="filter_option_cb" onclick="show_inventories();" value="8">

								<label>8ply</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_boxwall" class="filter_option_cb" onclick="show_inventories();" value="9">

								<label>9ply</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_boxwall" class="filter_option_cb" onclick="show_inventories();" value="10">

								<label>10ply</label>

							</div>

						</div>

						<div class="">

							<div class="inventory_title">Top Config</div>

							<div class="">

								<input type="checkbox" id="" name="inv_topconfig" class="filter_option_cb" onclick="show_inventories();" value="1">

								<label>No Top</label>

							</div>

							<div class="">

								<input type="checkbox" id="box_topLid" name="inv_topconfig" class="filter_option_cb" onclick="show_inventories();" value="2">

								<label>Lid Top</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_topconfig" class="filter_option_cb" onclick="show_inventories();" value="3">

								<label>Partial Flap Top</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_topconfig" class="filter_option_cb" onclick="show_inventories();" value="4">

								<label>Full Flap Top</label>

							</div>

						</div>

						<div class="">

							<div class="inventory_title">Bottom Config</div>

							<div class="">

								<input type="checkbox" id="" name="inv_bottomconfig" class="filter_option_cb" onclick="show_inventories();" value="1">

								<label>No Bottom</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_bottomconfig" class="filter_option_cb" onclick="show_inventories();" value="2">

								<label>Partial Flap w/o Slipsheet</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_bottomconfig" class="filter_option_cb" onclick="show_inventories();" value="3">

								<label>Tray Bottom</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_bottomconfig" class="filter_option_cb" onclick="show_inventories();" value="4">

								<label>Full Flap Bottom</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_bottomconfig" class="filter_option_cb" onclick="show_inventories();" value="5">

								<label>Partial Flap w/ Slipsheet</label>

							</div>

							<div class="">

								<input type="checkbox" id="" name="inv_bottomconfig" class="filter_option_cb" onclick="show_inventories();" value="6">

								<label>Partial Flap Bottom</label>

							</div>

						</div>

						<div class="">

							<div class="inventory_title">Vents</div>

							<div class="">

								<input type="checkbox" id="" name="inv_boxvents" class="filter_option_cb" onclick="show_inventories();" value="1">

								<label>Remove Vented Boxes?</label>

							</div>

						</div>

					</div>

				</div>

				<div class="container75 right">

					<div class="pl-10">

						<div class="content" id="content_result_div">



						</div>

					</div>

				</div>

			</div>

		</div>

   </div>

</div>



	<script>

		show_inventories();

	</script>



</body>

</html>