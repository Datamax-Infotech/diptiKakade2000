<?php
// ini_set("display_errors", "1");

// error_reporting(E_ERROR);
require "../mainfunctions/database.php";

require "../mainfunctions/general-functions.php";

$bg = "#f4f4f4";

$style12_val = "style12";

?>

	<div id="ucb_own_inventory_summary">



	</div>

	<div class="">

		<table cellSpacing="1" cellPadding="1" border="0">

			<tr align="middle">

				<th colspan="13" class="style24" style="height: 16px">UCB Owned Inventory

				</th>

			</tr>

		<tr>

			<td colspan="13">

			  <div id="div_ucbinv" name="div_ucbinv" >

				<table cellSpacing="1" cellPadding="1" border="0">

				  <tr vAlign="center">

					<th bgColor="#e4e4e4" class="style13" width="60px">

						<input type="checkbox" id="chk_sel_all" name="chk_sel_all" onclick="checkboxSelectAll()" value="selall"/>

					</th>

					<th bgColor="#e4e4e4" class="style13" width="60px">Actual</th>



					<th bgColor="#e4e4e4" class="style13" width="60px">After PO</th>



					<th bgColor="#e4e4e4" class="style13">Loads Available After PO</th>



					<th bgColor="#e4e4e4" class="style13">Frequency (Loads/Mo)</th>



					<th bgColor="#e4e4e4" class="style13" width="70px">Per Pallet</th>



					<th bgColor="#e4e4e4" class="style13" width="70px;">Per Trailer</th>



					<th bgColor="#e4e4e4" class="style13">Min FOB</th>



					<th bgColor="#e4e4e4" class="style13" width="70px">B2B Cost</th>



					<th bgColor="#e4e4e4" class="style13" width="70px">B2B ID</th>



					<th bgColor="#e4e4e4" class="style13" width="90px">Type</th>



					<th bgColor="#e4e4e4" class="style13" width="50px">L</th>

					<th bgColor="#e4e4e4" class="style13" width="50px">W</th>

					<th bgColor="#e4e4e4" class="style13" width="50px">H</th>



					<th bgColor="#e4e4e4" class="style13" width="50px">Cu.Ft.</th>



					<th bgColor="#e4e4e4" class="style13" width="50px">Walls</th>



					<th bgColor="#e4e4e4" class="style13" width="150px;">Description</th>



					<th bgColor="#e4e4e4" class="style13">Warehouse</th>



					<th bgColor="#e4e4e4" class="style13" width="100px">Supplier</th>



					<!-- <th bgColor="#e4e4e4" class="style13" width="100px">Ship From</th>

					<th bgColor="#e4e4e4" class="style13" width="80px">Worked as a kit box?</th> -->



				  </tr>

		<?php

$sql_fil = "";

$sql_wall = "";

if (isset($_REQUEST["wall"]) && $_REQUEST["wall"] != "") {

    $wall_val = explode(",", $_REQUEST["wall"]);

    for ($i = 0; $i < count($wall_val); $i++) {

        if ($sql_wall == "") {

            $sql_wall = " AND (tmp_inventory_list_set2.box_wall = " . $wall_val[$i];

            if (count($wall_val) == 1) {

                $sql_wall = $sql_wall . ") ";

            }

        } else {

            $sql_wall = $sql_wall . " OR tmp_inventory_list_set2.box_wall = " . $wall_val[$i];

        }

    }

    if ($sql_wall != "" && count($wall_val) > 1) {

        $sql_wall = $sql_wall . ") ";

    }

}

if (isset($_REQUEST["boxtype"]) && $_REQUEST["boxtype"] == "Gaylord") {

    $sql_fil .= " AND type_ofbox IN ('Gaylord','GaylordUCB', 'Loop','PresoldGaylord')";

    if ($_REQUEST["heightMin"] != 0 || $_REQUEST["heightMax"] != 99) {

        $sql_fil .= " AND (CONVERT(SUBSTRING_INDEX(LWH, 'x', -1), UNSIGNED INTEGER) >= " . $_REQUEST["heightMin"] . " AND CONVERT(SUBSTRING_INDEX(LWH, 'x', -1), UNSIGNED INTEGER) <= " . $_REQUEST["heightMax"] . " )";

    }

   

    $box_shape_val = explode(",", $_REQUEST["shape"]);

    if (in_array('1', $box_shape_val)) {

        $box_shape = " AND inventory.shape_rect = 1";

    }

    if (in_array('2', $box_shape_val)) {

        if ($box_shape == "") {

            $box_shape = " AND inventory.shape_oct = 1";

        } else {

            $box_shape .= " OR inventory.shape_oct = 1";

        }

    }

    $bottom_config = "";

    $bottom_config_val = explode(",", $_REQUEST["bottom"]);

    if (in_array('1', $bottom_config_val)) {

        if (in_array('2', $bottom_config_val) || in_array('3', $bottom_config_val) || in_array('4', $bottom_config_val) || in_array('5', $bottom_config_val)) {

            $bottom_config = " AND ( inventory.bottom_no = 1";

        } else {

            $bottom_config = " AND inventory.bottom_no = 1";

        }

    }

    if (in_array('2', $bottom_config_val)) {

        if ($bottom_config == "") {

            if (in_array('3', $bottom_config_val) || in_array('4', $bottom_config_val) || in_array('5', $bottom_config_val)) {

                $bottom_config = " AND (inventory.bottom_partial = 1";

            } else {

                $bottom_config = " AND inventory.bottom_partial = 1";

            }

        } else {

            if (in_array('3', $bottom_config_val) || in_array('4', $bottom_config_val) || in_array('5', $bottom_config_val)) {

                $bottom_config = $bottom_config . " OR inventory.bottom_partial = 1 ";

            } else {

                $bottom_config = $bottom_config . " OR inventory.bottom_partial = 1) ";

            }

        }

    }

    if (in_array('3', $bottom_config_val)) {

        if ($bottom_config == "") {

            if (in_array('4', $bottom_config_val) || in_array('5', $bottom_config_val)) {

                $bottom_config = " AND (inventory.bottom_tray = 1";

            } else {

                $bottom_config = " AND inventory.bottom_tray = 1";

            }

        } else {

            if (in_array('4', $bottom_config_val) || in_array('5', $bottom_config_val)) {

                $bottom_config = $bottom_config . " OR inventory.bottom_tray = 1";

            } else {

                $bottom_config = $bottom_config . " OR inventory.bottom_tray = 1) ";

            }

        }

    }

    if (in_array('4', $bottom_config_val)) {

        if ($bottom_config == "") {

            if (in_array('5', $bottom_config_val)) {

                $bottom_config = " AND (inventory.bottom_fullflap = 1";

            } else {

                $bottom_config = " AND inventory.bottom_fullflap = 1";

            }

        } else {

            if (in_array('5', $bottom_config_val)) {

                $bottom_config = $bottom_config . " OR inventory.bottom_fullflap = 1";

            } else {

                $bottom_config = $bottom_config . " OR inventory.bottom_fullflap = 1) ";

            }

        }

    }

    if (in_array('5', $bottom_config_val)) {

        if ($bottom_config == "") {

            $bottom_config = " AND inventory.bottom_partialsheet = 1";

        } else {

            $bottom_config = $bottom_config . " OR inventory.bottom_partialsheet = 1) ";

        }

    }

} elseif (isset($_REQUEST["boxtype"]) && $_REQUEST["boxtype"] == "Shipping") {

    $sql_fil .= " AND type_ofbox IN ('Box', 'Boxnonucb', 'Presold', 'Medium', 'Large', 'Xlarge')";

    if ($_REQUEST["lengthMin"] != 0 || $_REQUEST["lengthMax"] != 99) {

        $sql_fil .= " AND (CONVERT(SUBSTRING_INDEX(LWH, 'x', 1), UNSIGNED INTEGER) >= " . $_REQUEST["lengthMin"] . " AND CONVERT(SUBSTRING_INDEX(LWH, 'x', 1), UNSIGNED INTEGER) <= " . $_REQUEST["lengthMax"] . " )";

    }

    if ($_REQUEST["widthMin"] != 0 || $_REQUEST["widthMax"] != 99) {

        $sql_fil .= " AND (CONVERT(SUBSTRING_INDEX( SUBSTRING_INDEX (LWH, 'x', 2), 'x', -1), UNSIGNED INTEGER) >= " . $_REQUEST["widthMin"] . " AND CONVERT(SUBSTRING_INDEX( SUBSTRING_INDEX(LWH, 'x', 2), 'x', -1), UNSIGNED INTEGER) <= " . $_REQUEST["widthMax"] . " )";

    }

    if ($_REQUEST["heightMin"] != 0 || $_REQUEST["heightMax"] != 99) {

        $sql_fil .= " AND (CONVERT(SUBSTRING_INDEX(LWH, 'x', -1), UNSIGNED INTEGER) >= " . $_REQUEST["heightMin"] . " AND CONVERT(SUBSTRING_INDEX(LWH, 'x', -1), UNSIGNED INTEGER) <= " . $_REQUEST["heightMax"] . " )";

    }

    if ($_REQUEST["cubicMin"] != 0 || $_REQUEST["cubicMax"] != 99) {

        //$sql_fil .= " AND ((inventory.lengthInch * inventory.widthInch * inventory.depthInch / 1728) >= ". $_REQUEST["cubicMin"] ." and (inventory.lengthInch * inventory.widthInch * inventory.depthInch / 1728) <= ". $_REQUEST["cubicMax"] .")";

        $sql_fil .= " AND ((((lengthInch + if(lengthFraction > 0 , CAST(SUBSTRING_INDEX(lengthFraction, '/', 1) AS DECIMAL(10,2)) / CAST(SUBSTRING_INDEX(lengthFraction, '/', -1) AS DECIMAL(10,2)), 0)) * (widthInch + if(widthFraction > 0, CAST(SUBSTRING_INDEX(widthFraction, '/', 1) AS DECIMAL(10,2)) / CAST(SUBSTRING_INDEX(widthFraction, '/', -1) AS DECIMAL(10,2)), 0)) * (depthInch + if(depthFraction > 0, CAST(SUBSTRING_INDEX(depthFraction, '/', 1) AS DECIMAL(10,2)) / CAST(SUBSTRING_INDEX(depthFraction, '/', -1) AS DECIMAL(10,2)), 0)))/1728) >= " . $_REQUEST["cubicMin"] . "

		and (((lengthInch + if(lengthFraction > 0 , CAST(SUBSTRING_INDEX(lengthFraction, '/', 1) AS DECIMAL(10,2)) / CAST(SUBSTRING_INDEX(lengthFraction, '/', -1) AS DECIMAL(10,2)), 0)) * (widthInch + if(widthFraction > 0, CAST(SUBSTRING_INDEX(widthFraction, '/', 1) AS DECIMAL(10,2)) / CAST(SUBSTRING_INDEX(widthFraction, '/', -1) AS DECIMAL(10,2)), 0)) *(depthInch + if(depthFraction > 0, CAST(SUBSTRING_INDEX(depthFraction, '/', 1) AS DECIMAL(10,2)) / CAST(SUBSTRING_INDEX(depthFraction, '/', -1) AS DECIMAL(10,2)), 0)))/1728) <= " . $_REQUEST["cubicMax"] . ")";

    }

    $bottom_config = "";

    $bottom_config_val = explode(",", $_REQUEST["bottom"]);

    if (in_array('1', $bottom_config_val)) {

        if (in_array('4', $bottom_config_val) || in_array('6', $bottom_config_val)) {

            $bottom_config = " AND (inventory.bottom_no = 1";

        } else {

            $bottom_config = " AND inventory.bottom_no = 1";

        }

    }

    if (in_array('4', $bottom_config_val)) {

        if ($bottom_config == "") {

            if (in_array('6', $bottom_config_val)) {

                $bottom_config = " AND ( inventory.bottom_fullflap = 1";

            } else {

                $bottom_config = " AND inventory.bottom_fullflap = 1";

            }

        } else {

            if (in_array('6', $bottom_config_val)) {

                $bottom_config = $bottom_config . " OR inventory.bottom_fullflap = 1";

            } else {

                $bottom_config = $bottom_config . " OR inventory.bottom_fullflap = 1) ";

            }

        }

    }

    if (in_array('6', $bottom_config_val)) {

        if ($bottom_config == "") {

            $bottom_config = " AND inventory.bottom_flat = 1";

        } else {

            $bottom_config = $bottom_config . " OR inventory.bottom_flat = 1)";

        }

    }

} else {

    $sql_fil .= " AND type_ofbox IN ('Gaylord','GaylordUCB', 'Loop','PresoldGaylord' , 'Box', 'Boxnonucb', 'Presold', 'Medium', 'Large', 'Xlarge')";

    if ($_REQUEST["lengthMin"] != 0 || $_REQUEST["lengthMax"] != 99) {

        $sql_fil .= " AND (CONVERT(SUBSTRING_INDEX(LWH, 'x', 1), UNSIGNED INTEGER) >= " . $_REQUEST["lengthMin"] . " AND CONVERT(SUBSTRING_INDEX(LWH, 'x', 1), UNSIGNED INTEGER) <= " . $_REQUEST["lengthMax"] . " )";

    }

    if ($_REQUEST["widthMin"] != 0 || $_REQUEST["widthMax"] != 99) {

        $sql_fil .= " AND (CONVERT(SUBSTRING_INDEX( SUBSTRING_INDEX (LWH, 'x', 2), 'x', -1), UNSIGNED INTEGER) >= " . $_REQUEST["widthMin"] . " AND CONVERT(SUBSTRING_INDEX( SUBSTRING_INDEX(LWH, 'x', 2), 'x', -1), UNSIGNED INTEGER) <= " . $_REQUEST["widthMax"] . " )";

    }

    if ($_REQUEST["heightMin"] != 0 || $_REQUEST["heightMax"] != 99) {

        $sql_fil .= " AND (CONVERT(SUBSTRING_INDEX(LWH, 'x', -1), UNSIGNED INTEGER) >= " . $_REQUEST["heightMin"] . " AND CONVERT(SUBSTRING_INDEX(LWH, 'x', -1), UNSIGNED INTEGER) <= " . $_REQUEST["heightMax"] . " )";

    }

    if ($_REQUEST["cubicMin"] != 0 || $_REQUEST["cubicMax"] != 99) {

        //$sql_fil .= " AND ((inventory.lengthInch * inventory.widthInch * inventory.depthInch / 1728) >= ". $_REQUEST["cubicMin"] ." and (inventory.lengthInch * inventory.widthInch * inventory.depthInch / 1728) <= ". $_REQUEST["cubicMax"] .")";

        $sql_fil .= " AND ((((lengthInch + if(lengthFraction > 0 , CAST(SUBSTRING_INDEX(lengthFraction, '/', 1) AS DECIMAL(10,2)) / CAST(SUBSTRING_INDEX(lengthFraction, '/', -1) AS DECIMAL(10,2)), 0)) * (widthInch + if(widthFraction > 0, CAST(SUBSTRING_INDEX(widthFraction, '/', 1) AS DECIMAL(10,2)) / CAST(SUBSTRING_INDEX(widthFraction, '/', -1) AS DECIMAL(10,2)), 0)) * (depthInch + if(depthFraction > 0, CAST(SUBSTRING_INDEX(depthFraction, '/', 1) AS DECIMAL(10,2)) / CAST(SUBSTRING_INDEX(depthFraction, '/', -1) AS DECIMAL(10,2)), 0)))/1728) >= " . $_REQUEST["cubicMin"] . "

		and (((lengthInch + if(lengthFraction > 0 , CAST(SUBSTRING_INDEX(lengthFraction, '/', 1) AS DECIMAL(10,2)) / CAST(SUBSTRING_INDEX(lengthFraction, '/', -1) AS DECIMAL(10,2)), 0)) * (widthInch + if(widthFraction > 0, CAST(SUBSTRING_INDEX(widthFraction, '/', 1) AS DECIMAL(10,2)) / CAST(SUBSTRING_INDEX(widthFraction, '/', -1) AS DECIMAL(10,2)), 0)) *(depthInch + if(depthFraction > 0, CAST(SUBSTRING_INDEX(depthFraction, '/', 1) AS DECIMAL(10,2)) / CAST(SUBSTRING_INDEX(depthFraction, '/', -1) AS DECIMAL(10,2)), 0)))/1728) <= " . $_REQUEST["cubicMax"] . ")";

    }

    $box_shape = "";

    $box_shape_val = explode(",", $_REQUEST["shape"]);

    if (in_array('1', $box_shape_val)) {

        $box_shape = " AND inventory.shape_rect = 1";

    }

    if (in_array('2', $box_shape_val)) {

        if ($box_shape == "") {

            $box_shape = " AND inventory.shape_oct = 1";

        } else {

            $box_shape .= " OR inventory.shape_oct = 1";

        }

    }

    $bottom_config = "";

    $bottom_config_val = explode(",", $_REQUEST["bottom"]);

    if (in_array('1', $bottom_config_val)) {

        if (in_array('2', $bottom_config_val) || in_array('3', $bottom_config_val) || in_array('4', $bottom_config_val) || in_array('5', $bottom_config_val) || in_array('6', $bottom_config_val)) {

            $bottom_config = " AND ( inventory.bottom_no = 1";

        } else {

            $bottom_config = " AND inventory.bottom_no = 1";

        }

    }

    if (in_array('2', $bottom_config_val)) {

        if ($bottom_config == "") {

            if (in_array('3', $bottom_config_val) || in_array('4', $bottom_config_val) || in_array('5', $bottom_config_val) || in_array('6', $bottom_config_val)) {

                $bottom_config = " AND (inventory.bottom_partial = 1";

            } else {

                $bottom_config = " AND inventory.bottom_partial = 1";

            }

        } else {

            if (in_array('3', $bottom_config_val) || in_array('4', $bottom_config_val) || in_array('5', $bottom_config_val) || in_array('6', $bottom_config_val)) {

                $bottom_config = $bottom_config . " OR inventory.bottom_partial = 1 ";

            } else {

                $bottom_config = $bottom_config . " OR inventory.bottom_partial = 1) ";

            }

        }

    }

    if (in_array('3', $bottom_config_val)) {

        if ($bottom_config == "") {

            if (in_array('4', $bottom_config_val) || in_array('5', $bottom_config_val) || in_array('6', $bottom_config_val)) {

                $bottom_config = " AND (inventory.bottom_tray = 1";

            } else {

                $bottom_config = " AND inventory.bottom_tray = 1";

            }

        } else {

            if (in_array('4', $bottom_config_val) || in_array('5', $bottom_config_val) || in_array('6', $bottom_config_val)) {

                $bottom_config = $bottom_config . " OR inventory.bottom_tray = 1";

            } else {

                $bottom_config = $bottom_config . " OR inventory.bottom_tray = 1) ";

            }

        }

    }

    if (in_array('4', $bottom_config_val)) {

        if ($bottom_config == "") {

            if (in_array('5', $bottom_config_val) || in_array('6', $bottom_config_val)) {

                $bottom_config = " AND (inventory.bottom_fullflap = 1";

            } else {

                $bottom_config = " AND inventory.bottom_fullflap = 1";

            }

        } else {

            if (in_array('5', $bottom_config_val) || in_array('6', $bottom_config_val)) {

                $bottom_config = $bottom_config . " OR inventory.bottom_fullflap = 1";

            } else {

                $bottom_config = $bottom_config . " OR inventory.bottom_fullflap = 1) ";

            }

        }

    }

    if (in_array('5', $bottom_config_val)) {

        if ($bottom_config == "") {

            if (in_array('6', $bottom_config_val)) {

                $bottom_config = " AND (inventory.bottom_partialsheet = 1";

            } else {

                $bottom_config = " AND inventory.bottom_partialsheet = 1";

            }

        } else {

            if (in_array('6', $bottom_config_val)) {

                $bottom_config = $bottom_config . " OR inventory.bottom_partialsheet = 1 ";

            } else {

                $bottom_config = $bottom_config . " OR inventory.bottom_partialsheet = 1) ";

            }

        }

    }

    if (in_array('6', $bottom_config_val)) {

        if ($bottom_config == "") {

            $bottom_config = " AND inventory.bottom_flat = 1";

        } else {

            $bottom_config = $bottom_config . " OR inventory.bottom_flat = 1)";

        }

    }

}

$top_config = "";

$top_config_val = explode(",", $_REQUEST["top"]);

$top_config_val_3 = "";
$top_config_val_4 = "";

if (in_array('3', $top_config_val)) {

    $top_config_val_3 = "yes";

}

if (in_array('4', $top_config_val)) {

    $top_config_val_4 = "yes";

}

if (in_array('1', $top_config_val)) {

    if ($top_config_val_3 == "yes" || $top_config_val_4 == "yes") {

        $top_config = " AND (inventory.top_nolid = 1";

    } else {

        $top_config = " AND inventory.top_nolid = 1";

    }

}

if (in_array('2', $top_config_val)) {

    if ($top_config == "") {

        if ($top_config_val_3 == "yes" || $top_config_val_4 == "yes") {

            $top_config = " AND (inventory.top_nolid = 1";

        } else {

            $top_config = " AND inventory.top_nolid = 1";

        }

    }

}

if (in_array('3', $top_config_val)) {

    if ($top_config == "") {

        if (in_array('4', $top_config_val)) {

            $top_config = " AND ( inventory.top_partial = 1";

        } else {

            $top_config = " AND inventory.top_partial = 1";

        }

    } else {

        if (in_array('4', $top_config_val)) {

            $top_config = $top_config . " OR inventory.top_partial = 1";

        } else {

            $top_config = $top_config . " OR inventory.top_partial = 1) ";

        }

    }

}

if (in_array('4', $top_config_val)) {

    if ($top_config == "") {

        $top_config = " AND inventory.top_full = 1";

    } else {

        $top_config = $top_config . " OR inventory.top_full = 1) ";

    }

}

$vents_sql = "";

if (isset($_REQUEST['vents']) && $_REQUEST['vents'] == 1) {

    $vents_sql = " AND inventory.vents_yes=1";

}

$warehouse_input_sql = "";

if (isset($_REQUEST['warehouse_input']) && $_REQUEST['warehouse_input'] != "") {

    $warehouse_input_sql = " AND wid= '" . $_REQUEST['warehouse_input'] . "' ";

}

$dt_view_qry = "SELECT *, inventory.loops_id, inventory.location_city, inventory.location_state, inventory.location_zip, inventory.bwall, inventory.expected_loads_per_mo,

	inventory.vendor, inventory.lengthInch, inventory.widthInch, inventory.depthInch, inventory.vendor_b2b_rescue, (inventory.lengthInch * inventory.widthInch * inventory.depthInch / 1728) AS cubic from tmp_inventory_list_set2

	INNER JOIN inventory ON inventory.loops_id = tmp_inventory_list_set2.trans_id WHERE warehouse <> 'Direct Ship' $warehouse_input_sql $sql_fil $sql_wall $box_shape $top_config $bottom_config $vents_sql

	order by warehouse, type_ofbox, tmp_inventory_list_set2.Description";

//actual_qty_calculated > 0 and

// echo $dt_view_qry . "<br>";
db_b2b();
$dt_view_res = db_query($dt_view_qry);

//echo tep_db_num_rows($dt_view_res);

$preordercnt = 1;
$newflg = "no";

$tmpwarenm = "";
$tmp_noofpallet = 0;
$ware_house_boxdraw = "";

$total_actual_po = 0;

$total_after_po = 0;

$total_load_considered = 0;
$count_arry = 0;

$total_load_per_month = 0;
$total_load_av_after_po = 0;

while ($dt_view_row = array_shift($dt_view_res)) {

    $location_city = "";
    $location_state = "";
    $location_zip = "";
    $loops_id = 0;
    $vendor_b2b_rescue = 0;
    $bwall = "";
    $vendor_id = 0;
    $expected_loads_per_mo = "";

    $box_length = "";
    $box_width = "";
    $box_height = "";
    $vendor_name = "";

    $to_show_data2 = "no";

    $location_city = $dt_view_row["location_city"];

    $location_state = $dt_view_row["location_state"];

    $location_zip = $dt_view_row["location_zip"];

    $loops_id = $dt_view_row["loops_id"];

    $vendor_b2b_rescue = $dt_view_row["vendor_b2b_rescue"];

    $bwall = $dt_view_row["bwall"];

    $vendor_id = $dt_view_row["vendor"];

    $expected_loads_per_mo = $dt_view_row["expected_loads_per_mo"];

    $box_length = $dt_view_row["lengthInch"];

    $box_width = $dt_view_row["widthInch"];

    $box_height = $dt_view_row["depthInch"];

    $to_show_data2 = "yes";

    if ($vendor_b2b_rescue > 0) {

        $q1 = "SELECT id, company_name, b2bid FROM loop_warehouse where id = $vendor_b2b_rescue";
        db();
        $query = db_query($q1);

        while ($fetch = array_shift($query)) {

            $vendor_name = get_nickname_val($fetch["company_name"], $fetch["b2bid"]);

            $comqry = "select initials from companyInfo inner join employees on employees.employeeID=companyInfo.assignedto where employees.status='Active' and companyInfo.ID=" . $fetch["b2bid"];
            db_b2b();
            $comres = db_query($comqry);

            while ($comrow = array_shift($comres)) {

                $ownername = $comrow["initials"];

            }

        }

    } else {

        $vendor_b2b_rescue = $vendor_id;

        $q1 = "SELECT Name, b2bid FROM vendors where id = $vendor_b2b_rescue";
        db_b2b();
        $query = db_query($q1);

        while ($fetch = array_shift($query)) {

            $vendor_name = $fetch["Name"];

            $comqry = "select initials from companyInfo inner join employees on employees.employeeID=companyInfo.assignedto where employees.status='Active' and companyInfo.id=" . $fetch["b2bid"];
            db_b2b();
            $comres = db_query($comqry);

            while ($comrow = array_shift($comres)) {

                $ownername = $comrow["initials"];

            }

        }

    }

    $actual_qty_calculated = $dt_view_row["actual_qty_calculated"];

    if ($newflg == "no") {

        $newflg = "yes";

        ?><tr><td colspan="13" align="center">Sync on: <?php echo timeAgo($dt_view_row["updated_on"]); ?></td></tr><?php

    }

    $b2b_ulineDollar = round($dt_view_row["ulineDollar"]);

    $b2b_ulineCents = $dt_view_row["ulineCents"];

    //echo "b2b_ulineCents : " . $b2b_ulineCents . "<br>";

    if ($b2b_ulineDollar != "" || $b2b_ulineCents != "") {

        $min_fob = "$" . number_format($b2b_ulineDollar + $b2b_ulineCents, 2);

    } else {

        $min_fob = "$0.00";

    }

    $b2b_costDollar = round($dt_view_row["costDollar"]);

    $b2b_costCents = $dt_view_row["costCents"];

    $b2b_cost = $b2b_costDollar + $b2b_costCents;

    $sales_order_qty = $dt_view_row["sales_order_qty"];

    if ($actual_qty_calculated != 0 or $actual_qty_calculated - $sales_order_qty != 0) {

        $lastmonth_val = $expected_loads_per_mo;

        $reccnt = 0;

        if ($sales_order_qty > 0) {$reccnt = $sales_order_qty;}

        $preorder_txt = "";

        $preorder_txt2 = "";

        if ($reccnt > 0) {

            $preorder_txt = "<u>";

            $preorder_txt2 = "</u>";

        }

        if (($actual_qty_calculated >= $dt_view_row["per_trailer"]) && ($dt_view_row["per_trailer"] > 0)) {

            $bg = "yellow";

        }

        $pallet_val = 0;

        $pallet_val_afterpo = 0;

        $load_considered = 0;

        $actual_po = $actual_qty_calculated - $sales_order_qty;

        if ($dt_view_row["per_pallet"] > 0) {

            $pallet_val = number_format($actual_qty_calculated / $dt_view_row["per_pallet"], 1, '.', '');

            $pallet_val_afterpo = number_format($actual_po / $dt_view_row["per_pallet"], 1, '.', '');

            $load_considered = $pallet_val;

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

                    $pallet_val = " (" . $pallet_val_format . ")";

                }

            } else {

                $pallet_val = floatval($pallet_val);
                $pallet_val_format = number_format($pallet_val, 0);

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

                    $pallet_val_afterpo = " (" . $pallet_val_afterpo_format . ")";

                }

            } else {

                $pallet_val_afterpo = floatval($pallet_val_afterpo);
                $pallet_val_afterpo_format = number_format($pallet_val_afterpo, 0);

                $pallet_val_afterpo = " (" . $pallet_val_afterpo_format . ")";

            }

        } else { $pallet_val_afterpo = "";}

        $pallet_space_per = "";

        $to_show_data = "no";
        $filter_availability = "";
        $blength_frac = "";
        $bwidth_frac = "";
        if ($filter_availability != "All" && $filter_availability != "") {

            if ($filter_availability == "truckloadonly") {

                if ($actual_po >= $dt_view_row["per_trailer"]) {

                    $to_show_data = "yes";

                }

            }

            if ($filter_availability == "anyavailableboxes") {

                if ($actual_po > 0) {

                    $to_show_data = "yes";

                }

            }

        } else {

            $to_show_data = "yes";

        }

        if ($to_show_data == "yes" && $to_show_data2 == "yes") {

            if ($ware_house_boxdraw != $dt_view_row["warehouse"]) {

                ?><tr><td colspan="13"><hr style="border: 0; height: 1px;background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));"></td></tr><?php

            }

            $ware_house_boxdraw = $dt_view_row["warehouse"];

            $uniform_mixed_load = $dt_view_row["uniform_mixed_load"];

            if ($uniform_mixed_load == "Mixed") {

                $box_l = $dt_view_row["blength_min"] . " - " . $dt_view_row["blength_max"];

                $box_w = $dt_view_row["bwidth_min"] . " - " . $dt_view_row["bwidth_max"];

                $box_d = $dt_view_row["bheight_min"] . " - " . $dt_view_row["bheight_max"];

            } else {

                $blength = intval($dt_view_row["lengthInch"]);

                $blength_frac = $dt_view_row["lengthFraction"];

                $bwidth = $dt_view_row["widthInch"]; //." ".$myrowsel["bwidth_frac"];

                $bwidth_frac = $dt_view_row["widthFraction"];

                $bdepth = $dt_view_row["depthInch"]; //." ".$myrowsel["bdepth_frac"];

                $bdepth_frac = $dt_view_row["depthFraction"];

                $box_l = $blength . " " . $blength_frac;

                $box_w = $bwidth . " " . $bwidth_frac;

                $box_d = $bdepth . " " . $bdepth_frac;

            }

            if ($uniform_mixed_load != "Mixed") {

                if ($blength_frac != "") {

                    $blength_frac_num = explode("/", $blength_frac);

                    //$blength_frac_conv = $blength_frac_num[0] / $blength_frac_num[1];
                   
                    $blength_frac_num_0 = is_numeric($blength_frac_num[0]) ? $blength_frac_num[0] : 0;
                    $blength_frac_num_1 = is_numeric($blength_frac_num[1]) ? $blength_frac_num[1] : 1;
                    $blength_frac_conv = ($blength_frac_num_1 != 0) ? ($blength_frac_num_0 / $blength_frac_num_1) : 0;


                } else {

                    $blength_frac_conv = "";

                }

                if ($bwidth_frac != "") {

                    $bwidth_frac_num = explode("/", $bwidth_frac);

                    $bwidth_frac_conv = is_numeric($bwidth_frac_num[0]) && is_numeric($bwidth_frac_num[1]) ? ($bwidth_frac_num[0] / $bwidth_frac_num[1]) : 0;

                } else {

                    $bwidth_frac_conv = "";

                }

                if ($bdepth_frac != "") {

                    $bdepth_frac_num = explode("/", $bdepth_frac);

                    $bdepth_frac_conv = is_numeric($bdepth_frac_num[0]) && is_numeric($bdepth_frac_num[1]) ? ($bdepth_frac_num[0] / $bdepth_frac_num[1]) : 0;

                } else {

                    $bdepth_frac_conv = "";

                }

                //$bcubicfootage = (($blength + $blength_frac_conv) * ($bwidth + $bwidth_frac_conv) * ($bdepth + $bdepth_frac_conv)) / 1728;
                $blength = intval($blength);
                $bwidth = intval($bwidth);
                $bdepth = intval($bdepth);

                $blength_frac_conv = intval($blength_frac_conv);
                $bwidth_frac_conv = intval($bwidth_frac_conv);
                $bdepth_frac_conv = intval($bdepth_frac_conv);

                $bcubicfootage = (($blength + $blength_frac_conv) * ($bwidth + $bwidth_frac_conv) * ($bdepth + $bdepth_frac_conv)) / 1728;

                $bcubicfootage = number_format($bcubicfootage, 2);

            } else {

                $bcubicfootage_min = (($blength_min) * ($bwidth_min) * ($bheight_min)) / 1728;

                $item_bcubicfootage_min = number_format($bcubicfootage_min, 2);

                $bcubicfootage_max = (($blength_max) * ($bwidth_max) * ($bheight_max)) / 1728;

                $item_bcubicfootage_max = number_format($bcubicfootage_max, 2);

                $bcubicfootage = $item_bcubicfootage_min . " - " . $item_bcubicfootage_max;

                //echo $blength_min."-".$bwidth_min;

            }

            $load_av_after_po = 0;

            if ($dt_view_row["per_trailer"] > 0) {

                $load_av_after_po = round(($actual_po / $dt_view_row["per_trailer"]) * 100, 2);

            }

            ?>

		<tr vAlign="center" >

			<td id="tr_rowone<?php echo $count_arry; ?>" bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>">

				<input type="checkbox" id="chk_sel<?php echo $count_arry; ?>" name="chk_sel" onclick="checkboxClicked()"

				value="<?php echo $actual_qty_calculated . "|" . $actual_po . "|" . $load_av_after_po . "|" . $load_considered . "|" . $count_arry . "|" . $expected_loads_per_mo; ?>"/>

			</td>



			<td id="tr_rowtwo<?php echo $count_arry; ?>" bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" >

				<a href='javascript:void();' id='actual_pos<?php echo $dt_view_row["trans_id"]; ?>' onclick="displayactualpallet(<?php echo $dt_view_row["trans_id"]; ?>);">

				<?php if ($actual_qty_calculated < 0) {?>

				<font color="red"><?php echo $actual_qty_calculated . $pallet_val; ?></font>

				<?php	} else {?>

				<font color="green"><?php echo $actual_qty_calculated . $pallet_val; ?></font>

			   <?php }

            $total_actual_po += $actual_qty_calculated;

            $total_load_considered += $load_considered;

            ?>

				</a>

			</td>

			<td id="tr_rowthree<?php echo $count_arry; ?>" bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" >

			  <?php

            if ($actual_po < 0) {?>

				<div onclick="display_orders_data(<?php echo $count_arry; ?>, <?php echo $loops_id; ?>, <?php echo $vendor_b2b_rescue; ?>)" style="FONT-WEIGHT: bold;FONT-SIZE: 8pt;COLOR: #006600; FONT-FAMILY: Arial"><font color="blue"><?php echo $preorder_txt; ?><?php

                echo $actual_po . $pallet_val_afterpo; ?><?php echo $preorder_txt2; ?></font></div>

				<?php	} else {?>

				<div onclick="display_orders_data(<?php echo $count_arry; ?>, <?php echo $loops_id; ?>, <?php echo $vendor_b2b_rescue; ?>)" style="FONT-WEIGHT: bold;FONT-SIZE: 8pt;COLOR: #006600; FONT-FAMILY: Arial"><font color="green"><?php echo $preorder_txt; ?><?php

                echo $actual_po . $pallet_val_afterpo;

                ?></font><?php echo $preorder_txt2; ?></div> <?php }

            $total_after_po += $actual_po;

            ?>

			</td>

			  <td id="tr_rowfour<?php echo $count_arry; ?>" bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>">

				<?php

            echo $load_av_after_po . "%";

            $total_load_av_after_po += $load_av_after_po;

            ?>

			  </td>



			  <td id="tr_rowfive<?php echo $count_arry; ?>" bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>">

				<?php echo $expected_loads_per_mo;

            $total_load_per_month += $expected_loads_per_mo;

            ?>

			  </td>



			  <td id="tr_rowsix<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo $dt_view_row["per_pallet"]; ?></td>

			  <td id="tr_rowseven<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo number_format($dt_view_row["per_trailer"], 0); ?></td>

			  <td id="tr_roweight<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo $min_fob; ?></td>

			  <td id="tr_rownine<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" >$<?php echo number_format($b2b_cost, 2); ?></td>

			  <td id="tr_rowten<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo $dt_view_row["ID"]; ?></td>

			  <td id="tr_roweleven<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo $dt_view_row["type_ofbox"]; ?></td>

			  <td id="tr_rowtweelve<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo $box_l; ?></td>

			  <td id="tr_rowthirteen<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo $box_w; ?></td>

			  <td id="tr_rowfourteen<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo $box_d; ?></td>

			  <td id="tr_rowfifteen<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo $bcubicfootage; ?></td>



			  <td id="tr_rowsixteen<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo $dt_view_row["bwall"]; ?></td>



			  <td id="tr_row1seventeen<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><a target="_blank" href='manage_box_b2bloop.php?id=<?php echo $dt_view_row["trans_id"]; ?>&proc=View' id='box_div_main<?php echo $dt_view_row["trans_id"]; ?>' ><?php echo $dt_view_row["Description"]; ?></a></td>



			  <td id="tr_roweighteen<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo $dt_view_row["warehouse"]; ?></td>



			  <td id="tr_rowninteen<?php echo $count_arry; ?>"  bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo $vendor_name; ?></td>



			  <!-- <td bgColor="<?php echo $bg; ?>" class="style12left" ><?php echo $location_city . ", " . $location_state . " " . $location_zip; ?></td>



			  <td bgColor="<?php echo $bg; ?>" class="<?php echo $style12_val; ?>" ><?php echo $work_as_kit_box; ?></td> -->



		</tr>

		<?php

            if ($x == 0) {

                $x = 1;

                $bg = "#e4e4e4";

            } else {

                $x = 0;

                $bg = "#f4f4f4";

            }

            if ($reccnt > 0) {?>

			<tr id='inventory_preord_org_top_<?php echo $preordercnt; ?>' align="middle" style="display:none;">

			  <td>&nbsp;</td>

			  <td colspan="15" style="font-size:xx-small; font-family: Arial, Helvetica, sans-serif; background-color: #FAFCDF; height: 16px">

					<div id="inventory_preord_org_middle_div_<?php echo $preordercnt; ?>"></div>

			  </td>

			</tr>



	<?php

                $preordercnt = $preordercnt + 1;}

            ?>



			<tr id='inventory_preord_top_<?php echo $count_arry; ?>' align="middle" style="display:none;">

			  <td>&nbsp;</td>

			  <td>&nbsp;</td>

			  <td colspan="15" style="font-size:xx-small; font-family: Arial, Helvetica, sans-serif; background-color: #FAFCDF; height: 16px">

					<div id="inventory_preord_middle_div_<?php echo $count_arry; ?>"></div>

			  </td>

			</tr>



		<?php

            $count_arry = $count_arry + 1;

        }

    }

}

?>

			</table>



		</div>

		</td></tr>

	  </table>

	</div>



<?php

echo "<input type='hidden' id='inventory_preord_totctl' value='$preordercnt' />";

?>



	<input type="hidden" id="tot_count_arry" value="<?php echo $count_arry; ?>" />





	<div id="summary_report">

		<div class="tbl_summary">

			<div class="left pr-1">

				<div class="reportSummary_title">Actual<br>Total</div>

				<div id="div_actual_total" class="atxt-c"><?php echo number_format($total_actual_po, 0); ?></div>

			</div>

			<div class="left pr-1">

				<div class="reportSummary_title">After PO<br>Total</div>

				<div id="div_after_po" class="atxt-c"><?php echo number_format($total_after_po, 0); ?></div>

			</div>

			<div class="left pr-1" style="width: 100px;">

				<div class="reportSummary_title" style="width: 100px;">Loads Available After PO</div>

				<div id="div_loads_av" class="atxt-c" style="width: 100px;"><?php echo $total_load_av_after_po; ?>%</div>

			</div>



			<div class="left pr-1">

				<div class="reportSummary_title">Frequency<br>(Loads/Mo)</div>

				<div id="div_freq_load" class="atxt-c"><?php echo $total_load_per_month; ?></div>

			</div>



		</div>



	</div>



