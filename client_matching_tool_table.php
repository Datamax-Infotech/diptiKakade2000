<?php

// ini_set("display_errors", "1");

// error_reporting(E_ALL);
// ini_set('memory_limit', '-1');


function get_loop_box_id(int $b2b_id): ?int
{
    $dt_so = "SELECT * FROM loop_boxes WHERE b2b_id = " . $b2b_id;
    db();
    $dt_res_so = db_query($dt_so);
    while ($so_row = array_shift($dt_res_so)) {
        if ($so_row["id"] > 0) {
            return $so_row["id"];
        }
    }
    return null;
}
?>

<style>

.nowraptxt {

  white-space: nowrap;

}



th {

  position: -webkit-sticky;

  position: sticky;

  top: 0;

  z-index: 2;

}

</style>



<link rel="stylesheet" type="text/css" href="css/newstylechange.css" />

<script type="text/javascript" src="http://loops.usedcardboardboxes.com/wz_tooltip.js"></script>

<script type="text/javascript">

	function showdata_my(caddress, cpin, id){

		alert("page_to_go_href_link.php?address="+ encodeURIComponent(caddress) +"&pin="+ cpin +"&boxid="+id);

	}

</script>

<div class="scrollit">

<table width="99%" border="0" cellspacing="1" cellpadding="0" class="basic_style">



	<tr>

		<th class='display_title'>Place Order</th>

		<th class='display_title'>Qty Avail NOW</th>

		<th class='display_title'>Lead Time for FTL</th>



		<th class='display_title'>Per Full Truckload (FTL)</th>

		<th class='display_title'>FOB</th>

		<th class='display_title'>B2B ID</th>

		<th class='display_title'>Miles Away

			<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>

				<span class="tooltiptext">Green Color - miles away <= 250,

				<br>Orange Color - miles away <= 550 and > 250,

				<br>Red Color - miles away > 550</span>

			</div>

		</th>

		<th class='display_title'>B2B Status</th>

		<th align="center" class='display_title'>L</th>

		<th align="center" class='display_title'>x</th>

		<th align="center" class='display_title'>W</th>

		<th align="center" class='display_title'>x</th>

		<th align="center" class='display_title'>H</th>

		<th class='display_title'>Description</th>

		<th class='display_title'>Supplier</th>

		<th class='display_title'>Ship From</th>

		<th class='display_title'>LTL?</th>

		<th class='display_title'>Pickup?</th>

		<th class='display_title'>Supplier Relationship Owner</th>

	</tr>



<?php

$tmp_zip = "";

$shipLat = "";

$shipLong = "";

$tmp_zip = str_replace(" ", "", $_REQUEST["zipcode"]);

if ($tmp_zip != "") {

    if ($tmp_zip == "11111") {

        db_b2b();
        $zipQry = db_query("Select * from zipcodes_mexico limit 1");

    } else {
        db_b2b();
        $zipQry = db_query("Select * from ZipCodes WHERE zip ='" . intval($tmp_zip) . "'");

        $zipTest = tep_db_num_rows($zipQry);

        if ($zipTest == 0) {

            db_b2b();
            $zipQry = db_query("Select * from zipcodes_canada WHERE zip ='" . $tmp_zip . "'");

        }

    }

    while ($zip = array_shift($zipQry)) {

        $shipLat = $zip["latitude"];

        $shipLong = $zip["longitude"];

    }

}

$flt_str = $status_filter = $size_filter = "";

$length = $width = $height = '';

$MGArray = array();

if ($_REQUEST["itype"] == 1) {

    $flt_str = "(inventory.box_type IN ('Gaylord', 'GaylordUCB', 'PresoldGaylord')) AND ";

} else if ($_REQUEST["itype"] == 2) {

    $flt_str = "(inventory.box_type IN ('Medium', 'Large', 'Xlarge', 'Boxnonucb', 'Box', 'Presold')) AND ";

} else if ($_REQUEST["itype"] == 3) {

    $flt_str = "(inventory.box_type IN ('PalletsUCB', 'PalletsnonUCB')) AND ";

} else if ($_REQUEST["itype"] == 4) {

    $flt_str = "(inventory.box_type IN ('SupersackUCB', 'SupersacknonUCB', 'Supersacks')) AND ";

} else {

    $flt_str = "lengthInch !=''";

}

$status_filter = "(b2b_status=1.0 or b2b_status=1.1 or b2b_status=1.2) AND";

$can_ship_ltl_str = "";

if ($_REQUEST["can_ship_ltl"] == "Yes") {

    $can_ship_ltl_str = " ship_ltl = 1 and ";

}

$can_pickup_allowed_str = "";

if ($_REQUEST["can_pickup_allowed"] == "Yes") {

    $can_pickup_allowed_str = " customer_pickup_allowed = 1 and ";

}

$qty_avail_now_str = "";

if ($_REQUEST["timing_fltr"] == 2) {

    $qty_avail_now_str = " (after_actual_inventory > 0 and after_actual_inventory > quantity) and ";

}

db_b2b();
$yyyy = db_query("SELECT *, inventory.id AS I, inventory.lengthInch AS L, inventory.widthInch AS W, inventory.depthInch AS D, inventory.notes AS N,

		inventory.date AS DT, inventory.vendor AS V FROM inventory WHERE " . $flt_str . " " . $status_filter . " $can_ship_ltl_str $can_pickup_allowed_str $qty_avail_now_str inventory.Active LIKE 'A'

		ORDER BY inventory.availability DESC");

$vendor_b2b_rescue_id_pre = '';

while ($inv = array_shift($yyyy)) {

    $count = 0;

    $tipcount_match_str = "";

    if ($_REQUEST["itype"] == 1) {

        $show_rec_condition1 = "no";

        if (((int) $inv["depthInch"] >= (int) $_REQUEST['g_item_min_height']) && ((int) $inv["depthInch"] <= (int) $_REQUEST['g_item_max_height'])) {

            $show_rec_condition1 = "yes";

        }

        if (((int) $inv["bheight_min"] >= (int) $_REQUEST['g_item_min_height']) && ((int) $inv["bheight_max"] <= (int) $_REQUEST['g_item_max_height'])) {

            $show_rec_condition1 = "yes";

        }

        $show_rec_condition2 = "no";

        if ($_REQUEST['g_shape_rectangular'] != "") {

            if ($_REQUEST['g_shape_rectangular'] == "Yes" && (int) $inv["shape_rect"] == 1 && (int) $inv["shape_oct"] == 0) {

                $show_rec_condition2 = "yes";

            }

        }

        if ($_REQUEST['g_shape_octagonal'] != "") {

            if ($_REQUEST['g_shape_octagonal'] == "Yes" && (int) $inv["shape_oct"] == 1 && (int) $inv["shape_rect"] == 0) {

                $show_rec_condition2 = "yes";

            }

        }

        if (($_REQUEST['g_shape_rectangular'] == "Yes" && $_REQUEST['g_shape_octagonal'] == "Yes") && ((int) $inv["shape_oct"] == 1 && (int) $inv["shape_rect"] == 1)) {

            $show_rec_condition2 = "yes";

        }

        $show_rec_condition3 = "no";

        if ($_REQUEST['g_wall_2'] == "Yes" && $inv["wall_2"] == 1) {$show_rec_condition3 = "yes";}

        if ($_REQUEST['g_wall_3'] == "Yes" && $inv["wall_3"] == 1) {$show_rec_condition3 = "yes";}

        if ($_REQUEST['g_wall_4'] == "Yes" && $inv["wall_4"] == 1) {$show_rec_condition3 = "yes";}

        if ($_REQUEST['g_wall_5'] == "Yes" && $inv["wall_5"] == 1) {$show_rec_condition3 = "yes";}

        if ($_REQUEST['g_wall_6'] == "Yes" && $inv["wall_6"] == 1) {$show_rec_condition3 = "yes";}

        if ($_REQUEST['g_wall_7'] == "Yes" && $inv["wall_7"] == 1) {$show_rec_condition3 = "yes";}

        if ($_REQUEST['g_wall_8'] == "Yes" && $inv["wall_8"] == 1) {$show_rec_condition3 = "yes";}

        $show_rec_condition4 = "no";

        if ($_REQUEST['g_no_top'] == "Yes" && ((int) $inv["top_nolid"] == 1)) {$show_rec_condition4 = "yes";}

        if ($_REQUEST['g_lid_top'] == "Yes" && ((int) $inv["top_remove"] == 1)) {$show_rec_condition4 = "yes";}

        if ($_REQUEST['g_partial_flap_top'] == "Yes" && ((int) $inv["top_partial"] == 1)) {$show_rec_condition4 = "yes";}

        if ($_REQUEST['g_full_flap_top'] == "Yes" && ((int) $inv["top_full"] == 1)) {$show_rec_condition4 = "yes";}

        $show_rec_condition5 = "no";

        if ($_REQUEST['g_no_bottom_config'] == "Yes" && ((int) $inv["bottom_no"] == 1)) {$show_rec_condition5 = "yes";}

        if ($_REQUEST['g_tray_bottom'] == "Yes" && ((int) $inv["bottom_tray"] == 1)) {$show_rec_condition5 = "yes";}

        if ($_REQUEST['g_partial_flap_wo'] == "Yes" && ((int) $inv["bottom_partial"] == 1)) {$show_rec_condition5 = "yes";}

        if ($_REQUEST['g_partial_flap_w'] == "Yes" && ((int) $inv["bottom_partialsheet"] == 1)) {

            $show_rec_condition5 = "yes";

        }

        if ($_REQUEST['g_full_flap_bottom'] == "Yes" && ((int) $inv["bottom_fullflap"] == 1)) {

            $show_rec_condition5 = "yes";

        }

        $show_rec_condition6 = "no";

        if ($_REQUEST['g_vents_okay'] == "" && (int) $inv["vents_yes"] == 0) {$show_rec_condition6 = "yes";}

        if ($_REQUEST['g_vents_okay'] == "Yes") {$show_rec_condition6 = "yes";}

    } elseif ($_REQUEST["itype"] == 2) {

        $show_rec_condition1 = "no";

        if (((int) $inv["lengthInch"] >= (int) $_REQUEST['sb_item_min_length'] && (int) $inv["lengthInch"] <= (int) $_REQUEST['sb_item_max_length']) && ((int) $inv["widthInch"] >= (int) $_REQUEST['sb_item_min_width'] && (int) $inv["widthInch"] <= (int) $_REQUEST['sb_item_max_width']) && ((int) $inv["depthInch"] >= (int) $_REQUEST['sb_item_min_height'] && (int) $inv["depthInch"] <= (int) $_REQUEST['sb_item_max_height'])) {

            $show_rec_condition1 = "yes";

        }

        if (((int) $inv["bheight_min"] >= (int) $_REQUEST['sb_item_min_height']) && ((int) $inv["bheight_max"] <= (int) $_REQUEST['sb_item_max_height'])) {

            $show_rec_condition1 = "yes";

        }

        $show_rec_condition2 = "no";

        $bcubicfootage = (($inv["lengthInch"] + $inv["lengthFraction"]) * ($inv["widthInch"] + $inv["widthFraction"]) * ($inv["depthInch"] + $inv["depthFraction"])) / 1728;

        $bcubicfootage = number_format($bcubicfootage, 2);

        if (((double) $bcubicfootage >= (double) $_REQUEST['sb_cubic_footage_min']) && ((double) $bcubicfootage <= (double) $_REQUEST['sb_cubic_footage_max'])) {

            $show_rec_condition2 = "yes";

        }

        $show_rec_condition3 = "no";

        if ($inv["uniform_mixed_load"] == "Mixed") {

            if ($_REQUEST['sb_wall_1'] == "Yes" && ($inv["bwall_min"] >= 1 && $inv["bwall_max"] <= 1)) {

                $show_rec_condition3 = "yes";

            }

            if ($_REQUEST['sb_wall_2'] == "Yes" && ($inv["bwall_min"] >= 2 && $inv["bwall_max"] <= 2)) {

                $show_rec_condition3 = "yes";

            }

        } else {

            if ($_REQUEST['sb_wall_1'] == "Yes" && $inv["bwall"] == 1) {$show_rec_condition3 = "yes";}

            if ($_REQUEST['sb_wall_2'] == "Yes" && $inv["wall_2"] == 1) {$show_rec_condition3 = "yes";}

        }

        $show_rec_condition4 = "no";

        if ($_REQUEST['sb_no_top'] == "Yes" && ((int) $inv["top_nolid"] == 1)) {$show_rec_condition4 = "yes";}

        if ($_REQUEST['sb_full_flap_top'] == "Yes" && ((int) $inv["top_full"] == 1)) {$show_rec_condition4 = "yes";}

        if ($_REQUEST['sb_partial_flap_top'] == "Yes" && ((int) $inv["top_partial"] == 1)) {$show_rec_condition4 = "yes";}

        $show_rec_condition5 = "no";

        if ($_REQUEST['sb_no_bottom'] == "Yes" && ((int) $inv["bottom_no"] == 1)) {$show_rec_condition5 = "yes";}

        if ($_REQUEST['sb_full_flap_bottom'] == "Yes" && ((int) $inv["bottom_fullflap"] == 1)) {$show_rec_condition5 = "yes";}

        if ($_REQUEST['sb_partial_flap_bottom'] == "Yes" && ((int) $inv["bottom_partial"] == 1)) {$show_rec_condition5 = "yes";}

        $show_rec_condition6 = "no";

        if ($_REQUEST['sb_vents_okay'] == "" && (int) $inv["vents_yes"] == 0) {$show_rec_condition6 = "yes";}

        if ($_REQUEST['sb_vents_okay'] == "Yes") {$show_rec_condition6 = "yes";}

    } else {

        $show_rec_condition1 = $show_rec_condition2 = $show_rec_condition3 = "yes";

        $show_rec_condition4 = $show_rec_condition5 = $show_rec_condition6 = "yes";

    }

    $show_rec_condition7 = "yes";

    $b2b_onlineDollar = round($inv["ulineDollar"]);

    $b2b_onlineCents = $inv["ulineCents"];

    $b2b_fob_num = $b2b_onlineDollar + $b2b_onlineCents;

    if ($_REQUEST["txtprice_from"] != "" && $_REQUEST["txtprice_to"] != "") {

        $show_rec_condition7 = "no";

        $price_from = str_replace(",", "", number_format($_REQUEST["txtprice_from"], 0));

        $price_to = str_replace(",", "", number_format($_REQUEST["txtprice_to"], 0));

        if ($price_from >= $b2b_fob_num || $b2b_fob_num <= $price_to) {

            $show_rec_condition7 = "yes";

        }

    }

    if ($show_rec_condition1 == "yes" && $show_rec_condition2 == "yes" && $show_rec_condition3 == "yes" && $show_rec_condition4 == "yes" && $show_rec_condition5 == "yes" && $show_rec_condition6 == "yes" && $show_rec_condition7 == "yes") {

        $b2b_fob = $b2b_onlineDollar + $b2b_onlineCents;

        $b2b_fob = "$" . number_format($b2b_fob, 2);

        $b2b_costDollar = round($inv["costDollar"]);

        $b2b_costCents = $inv["costCents"];

        $b2b_cost = $b2b_costDollar + $b2b_costCents;

        $b2b_cost = "$" . number_format($b2b_cost, 2);

        $zipStr = "";

        if ($tmp_zip != "") {

            if ($inv["location_country"] == "Canada") {

                $tmp_zipval = str_replace(" ", "", $inv["location_zip"]);

                $zipStr = "Select * from zipcodes_canada WHERE zip = '" . $tmp_zipval . "'";

            } elseif (($inv["location_country"]) == "Mexico") {

                $zipStr = "Select * from zipcodes_mexico limit 1";

            } else {

                $zipStr = "Select * from ZipCodes WHERE zip = '" . intval($inv["location_zip"]) . "'";

            }

        }

        $inv_id_list = "";

        if ($inv["availability"] != "-3.5") {

            $inv_id_list .= $inv["I"] . ",";

        } else {
            $inv_id_list = "";
        }

        $distC = 0;
        $locLat = "";
        $locLong = "";
        if ($tmp_zip != "") {
            db_b2b();
            $dt_view_res3 = db_query($zipStr);

            while ($ziploc = array_shift($dt_view_res3)) {

                $locLat = $ziploc["latitude"];

                $locLong = $ziploc["longitude"];

            }

            $distLat = ($shipLat - $locLat) * 3.141592653 / 180;

            $distLong = ($shipLong - $locLong) * 3.141592653 / 180;

            $distA = Sin($distLat / 2) * Sin($distLat / 2) + Cos($shipLat * 3.14159 / 180) * Cos($locLat * 3.14159 / 180) * Sin($distLong / 2) * Sin($distLong / 2);

            $distC = 2 * atan2(sqrt($distA), sqrt(1 - $distA));

        }

        $rec_found_box = "n";

        $actual_val = 0;
        $after_po_val = 0;
        $last_month_qty = 0;
        $pallet_val = "";
        $pallet_val_afterpo = "";

        $tmp_noofpallet = 0;
        $ware_house_boxdraw = "";
        $preorder_txt = "";
        $preorder_txt2 = "";
        $box_warehouse_id = 0;

        $bpallet_qty = 0;
        $boxes_per_trailer = 0;

        $ship_cdata_ltl = '';
        $pickup_cdata_allowed = '';

        $next_load_available_date = "";
        $ship_ltl = "";
        $qry_loc = "select id, bpallet_qty, boxes_per_trailer, ship_ltl, customer_pickup_allowed, box_warehouse_id,vendor_b2b_rescue, box_warehouse_id, next_load_available_date from loop_boxes where b2b_id=" . $inv["I"];
        db();
        $dt_view = db_query($qry_loc);
        $customer_pickup_allowed = "";
        $shipfrom_city = "";
        $shipfrom_state = "";
        $shipfrom_zip = "";

        while ($loc_res = array_shift($dt_view)) {

            $bpallet_qty = $loc_res['bpallet_qty'];

            $boxes_per_trailer = $loc_res['boxes_per_trailer'];

            $ship_ltl = $loc_res['ship_ltl'];

            $customer_pickup_allowed = $loc_res['customer_pickup_allowed'];

            $box_warehouse_id = $loc_res["box_warehouse_id"];

            $next_load_available_date = $loc_res["next_load_available_date"];

            if ($loc_res["box_warehouse_id"] == "238") {

                $vendor_b2b_rescue_id = $loc_res["vendor_b2b_rescue"];

                $get_loc_qry = "Select * from companyInfo where loopid = " . $vendor_b2b_rescue_id;
                db_b2b();
                $get_loc_res = db_query($get_loc_qry);

                $loc_row = array_shift($get_loc_res);

                $shipfrom_city = $loc_row["shipCity"];

                $shipfrom_state = $loc_row["shipState"];

                $shipfrom_zip = $loc_row["shipZip"];

            } else {

                $vendor_b2b_rescue_id = $loc_res["box_warehouse_id"];

                $get_loc_qry = "Select * from loop_warehouse where id ='" . $vendor_b2b_rescue_id . "'";
                db();
                $get_loc_res = db_query($get_loc_qry);

                $loc_row = array_shift($get_loc_res);

                $shipfrom_city = $loc_row["company_city"];

                $shipfrom_state = $loc_row["company_state"];

                $shipfrom_zip = $loc_row["company_zip"];

            }

        }

        if ($ship_ltl == 1) {$ship_cdata_ltl = 'Y';}

        if ($customer_pickup_allowed == 1) {$pickup_cdata_allowed = 'Y';}

        $ship_from = $shipfrom_city . ", " . $shipfrom_state . " " . $shipfrom_zip;

        $ship_from2 = $shipfrom_state;

        $after_po_val_tmp = 0;

        $dt_view_qry = "SELECT * from tmp_inventory_list_set2 where trans_id = " . $inv["loops_id"] . " order by warehouse, type_ofbox, Description";
        db_b2b();
        $dt_view_res_box = db_query($dt_view_qry);

        while ($dt_view_res_box_data = array_shift($dt_view_res_box)) {

            $rec_found_box = "y";

            $actual_val = $dt_view_res_box_data["actual"];

            $after_po_val_tmp = $dt_view_res_box_data["afterpo"];

            $last_month_qty = $dt_view_res_box_data["lastmonthqty"];

        }

        if ($rec_found_box == "n") {

            $actual_val = $inv["actual_inventory"];

            $after_po_val = $inv["after_actual_inventory"];

            $last_month_qty = $inv["lastmonthqty"];

        }

        if ($box_warehouse_id == 238) {

            $after_po_val = $inv["after_actual_inventory"];

        } else {

            $after_po_val = $after_po_val_tmp;

        }

        $to_show_rec = "n";

        if ($_REQUEST["timing_fltr"] == 2) {

            if ($after_po_val >= $boxes_per_trailer && $after_po_val > 0) {

                $to_show_rec = "y";

            }

        } else {

            $to_show_rec = "y";

        }

        if ($to_show_rec == "y") {

            $vendor_name = "";
            $ownername = "";

            if ($inv["vendor_b2b_rescue"] > 0) {

                $vendor_b2b_rescue = $inv["vendor_b2b_rescue"];

                $q1 = "SELECT id, company_name, b2bid FROM loop_warehouse where id = $vendor_b2b_rescue";
                db();
                $query = db_query($q1);

                while ($fetch = array_shift($query)) {

                    $vendor_name = get_nickname_val($fetch["company_name"], $fetch["b2bid"]);

                    $comqry = "select *,employees.name as empname from companyInfo inner join employees on employees.employeeID=companyInfo.assignedto where employees.status='Active' and companyInfo.id=" . $fetch["b2bid"];
                    db_b2b();
                    $comres = db_query($comqry);

                    while ($comrow = array_shift($comres)) {

                        $ownername = $comrow["initials"];

                    }

                }

            } else {

                $vendor_b2b_rescue = $inv["V"];

                if ($vendor_b2b_rescue != "") {

                    $q1 = "SELECT * FROM vendors where id = $vendor_b2b_rescue";
                    db_b2b();
                    $query = db_query($q1);

                    while ($fetch = array_shift($query)) {

                        $vendor_name = $fetch["Name"];

                        $comqry = "select *,employees.name as empname from companyInfo inner join employees on employees.employeeID=companyInfo.assignedto where employees.status='Active' and companyInfo.id=" . $fetch["b2bid"];
                        db_b2b();
                        $comres = db_query($comqry);

                        while ($comrow = array_shift($comres)) {

                            $ownername = $comrow["initials"];

                        }

                    }

                }

            }

            if ($inv["lead_time"] <= 1) {

                $lead_time = "Next Day";

            } else {

                $lead_time = $inv["lead_time"] . " Days";

            }

            $estimated_next_load = "";
            $b2bstatuscolor = "";

            if ($boxes_per_trailer != 0) {

                $expected_loads_per_mo = round($after_po_val / $boxes_per_trailer, 2);

            } else {

                $expected_loads_per_mo = 0;

            }

            $expected_loads_per_mo_from_db = $inv["expected_loads_per_mo"];

            $annual_volume = "";

            if ($boxes_per_trailer == 0) {

                $annual_volume = "<font color=red>0</font>";

            } else {

                $annual_volume = number_format(($boxes_per_trailer * $expected_loads_per_mo_from_db * 12), 0);

            }

            $annual_volume_total_load = $expected_loads_per_mo_from_db * 12;

            $qty_avail_3month = 0;

            $sold_qty = 0;

            $b2b_status = $inv["b2b_status"];

            $b2bstatuscolor = "";

            $st_query = "select * from b2b_box_status where status_key='" . $b2b_status . "'";
            db();
            $st_res = db_query($st_query);

            $st_row = array_shift($st_res);

            $b2bstatus_name = $st_row["box_status"];

            if ($st_row["status_key"] == "1.0" || $st_row["status_key"] == "1.1" || $st_row["status_key"] == "1.2") {

                $b2bstatuscolor = "green";

            } elseif ($st_row["status_key"] == "2.0" || $st_row["status_key"] == "2.1" || $st_row["status_key"] == "2.2") {

                $b2bstatuscolor = "orange";

            }

            if ($inv["buy_now_load_can_ship_in"] == "<font color=red> Ask Purch Rep </font>" || $inv["buy_now_load_can_ship_in"] == "<font color=red>Ask Purch Rep</font>") {

                $estimated_next_load = "<font color=red>Ask Rep</font>";

            } else {

                $estimated_next_load = $inv["buy_now_load_can_ship_in"];

            }

            if ($inv["box_urgent"] == 1) {

                $b2bstatuscolor = "red";

                $b2bstatus_name = "URGENT";

            }

            if ($inv["uniform_mixed_load"] == "Mixed") {

                if ($inv["blength_min"] == $inv["blength_max"]) {

                    $blength = $inv["blength_min"];

                } else {

                    $blength = $inv["blength_min"] . " - " . $inv["blength_max"];

                }

                if ($inv["bwidth_min"] == $inv["bwidth_max"]) {

                    $bwidth = $inv["bwidth_min"];

                } else {

                    $bwidth = $inv["bwidth_min"] . " - " . $inv["bwidth_max"];

                }

                if ($inv["bheight_min"] == $inv["bheight_max"]) {

                    $bdepth = $inv["bheight_min"];

                } else {

                    $bdepth = $inv["bheight_min"] . " - " . $inv["bheight_max"];

                }

            } else {

                $blength = $inv["lengthInch"];

                $bwidth = $inv["widthInch"];

                $bdepth = $inv["depthInch"];

            }

            $blength_frac = 0;

            $bwidth_frac = 0;

            $bdepth_frac = 0;

            $length = $blength;

            $width = $bwidth;

            $depth = $bdepth;

            if ($inv["lengthFraction"] != "") {

                $arr_length = explode("/", $inv["lengthFraction"]);

                if (count($arr_length) > 1) {

                    $blength_frac = intval($arr_length[0]) / intval($arr_length[1]);

                    $length = floatval($blength + $blength_frac);

                }

            }

            if ($inv["widthFraction"] != "") {

                $arr_width = explode("/", $inv["widthFraction"]);

                if (count($arr_width) > 1) {

                    $bwidth_frac = intval($arr_width[0]) / intval($arr_width[1]);

                    $width = floatval($bwidth + $bwidth_frac);

                }

            }

            if ($inv["depthFraction"] != "") {

                $arr_depth = explode("/", $inv["depthFraction"]);

                if (count($arr_depth)) {

                    $bdepth_frac = intval($arr_depth[0]) / intval($arr_depth[1]);

                    $depth = floatval($bdepth + $bdepth_frac);

                }

            }

            $miles_away_color = "";

            if ($tmp_zip != "") {

                $miles_from = (int) (6371 * $distC * .621371192);

                if ($miles_from <= 250) {

                    $miles_away_color = "green";

                }

                if (($miles_from <= 550) && ($miles_from > 250)) {

                    $miles_away_color = "#FF9933";

                }

                if (($miles_from > 550)) {

                    $miles_away_color = "red";

                }

            } else {

                $miles_from = "";

                $miles_away_color = "";

            }

            $b_urgent = "No";
            $contracted = "No";
            $prepay = "No";
            $ship_ltl = "No";

            if ($inv["box_urgent"] == 1) {

                $b_urgent = "Yes";

            }

            if ($inv["contracted"] == 1) {

                $contracted = "Yes";

            }

            if ($inv["prepay"] == 1) {

                $prepay = "Yes";

            }

            if ($inv["ship_ltl"] == 1) {

                $ship_ltl = "Yes";

            }

            $tipStr = "<b>Notes:</b> " . $inv["N"] . "<br>";

            if ($inv["DT"] != "0000-00-00") {

                $tipStr .= "<b>Notes Date:</b> " . date("m/d/Y", strtotime($inv["DT"])) . "<br>";

            } else {

                $tipStr .= "<b>Notes Date:</b> <br>";

            }

            $tipStr .= "<b>Urgent:</b> " . $b_urgent . "<br>";

            $tipStr .= "<b>Contracted:</b> " . $contracted . "<br>";

            $tipStr .= "<b>Prepay:</b> " . $prepay . "<br>";

            $tipStr .= "<b>Can Ship LTL?</b> " . $ship_ltl . "<br>";

            $tipStr .= "<b>Qty Avail:</b> " . $after_po_val . "<br>";

            $tipStr .= "<b>Lead Time for FTL:</b> " . $estimated_next_load . "<br>";

            $tipStr .= "<b>Qty Available, Next 3 Months:</b> " . $inv["expected_loads_per_mo"] . "<br>";

            $tipStr .= "<b>B2B Status:</b> " . $b2bstatus_name . "<br>";

            $tipStr .= "<b>Supplier Relationship Owner:</b> " . $ownername . "<br>";

            $tipStr .= "<b>B2B ID#:</b> " . $inv["I"] . "<br>";

            $tipStr .= "<b>Description:</b> " . $inv["description"] . "<br>";

            $tipStr .= "<b>Supplier:</b> " . $vendor_name . "<br>";

            $tipStr .= "<b>Ship From:</b> " . $ship_from . "<br>";

            $tipStr .= "<b>Miles From:</b> " . $miles_from . "<br>";

            $tipStr .= "<b>Per Pallet:</b> " . $bpallet_qty . "<br>";

            $tipStr .= "<b>Per Truckload:</b> " . $boxes_per_trailer . "<br>";

            $tipStr .= "<b>FOB:</b> " . $b2b_fob . "<br>";

            $tipStr .= "<b>B2B Cost:</b> " . $b2b_cost . "<br>";

            $tipStr .= "<b>Ship Ltl:</b> " . $ship_cdata_ltl . "<br>";

            $tipStr .= "<b>Custome Pickup:</b> " . $pickup_cdata_allowed . "<br>";

            $tmpTDstr = "<tr>";

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl><a href='javascript:void(0)' onclick='showdata_my('', \"" . $tmp_zip . "\", " . $inv["I"] . ")'>";

            $tmpTDstr = $tmpTDstr . "Order</a></td>";

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl >";

            $font_blue = "";
            $font_blue1 = "";

            if ($after_po_val < 0) {

                $font_blue = "<font color='blue'>";

                $font_blue1 = "</font>";

                $tmpTDstr = $tmpTDstr . "<font color='blue'>" . number_format($after_po_val, 0) . $pallet_val_afterpo . " (" . $expected_loads_per_mo . ")</font></td>";

            } else if ($after_po_val == 0 && $expected_loads_per_mo == 0) {

                $tmpTDstr = $tmpTDstr . "<font color='black'>" . number_format($after_po_val, 0) . "</font></td>";

            } else if ($after_po_val >= $boxes_per_trailer) {

                $tmpTDstr = $tmpTDstr . "<font color='green'>" . number_format($after_po_val, 0) . $pallet_val_afterpo . " (" . $expected_loads_per_mo . ")</font></td>";

            } else {

                $tmpTDstr = $tmpTDstr . "<font color='black'>" . number_format($after_po_val, 0) . $pallet_val_afterpo . " (" . $expected_loads_per_mo . ")</font></td>";

            }

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl >" . $font_blue . $estimated_next_load . $font_blue1 . "</td>";

            /*$expected_loads_per_mo_for_3m = round(str_replace(",", "", $qty_avail_3month)/str_replace(",", "", $boxes_per_trailer),2);

            if ($qty_avail_3month == 0 && $expected_loads_per_mo_for_3m == 0){

            $tmpTDstr =  $tmpTDstr . "<td bgColorrepl >" . $font_blue . $qty_avail_3month . $font_blue1 . "</td>";

            }else{

            $tmpTDstr =  $tmpTDstr . "<td bgColorrepl >" . $font_blue . $qty_avail_3month . " (" . $expected_loads_per_mo_for_3m . ")" . $font_blue1 ."</td>";

            }

            if ($annual_volume == 0 && $annual_volume_total_load == 0){

            $tmpTDstr =  $tmpTDstr . "<td bgColorrepl >" . $annual_volume . "</td>";

            }else{

            $tmpTDstr =  $tmpTDstr . "<td bgColorrepl >" . $annual_volume . " (" . $annual_volume_total_load . ")</td>";

            }*/

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl >" . number_format($boxes_per_trailer, 0) . "</td>";

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl >" . $b2b_fob . "</td>";

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl >" . $inv["I"] . "</td>";

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl><font color='$miles_away_color'>" . $miles_from . "</td>";

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl><font color='" . $b2bstatuscolor . "'>" . $b2bstatus_name . "</td>";

            $tmpTDstr = $tmpTDstr . "<td align='center' bgColorrepl width='40px'>" . $length . "</td>";

            $tmpTDstr = $tmpTDstr . "<td align='center' bgColorrepl> x </td>";

            $tmpTDstr = $tmpTDstr . "<td  align='center'  bgColorrepl width='40px'>" . $width . "</td>";

            $tmpTDstr = $tmpTDstr . "<td  align='center' bgColorrepl> x </td>";

            $tmpTDstr = $tmpTDstr . "<td  align='center'  bgColorrepl width='40px'>" . $depth . "</td>";

            if (isset($_REQUEST["display_view"]) && $_REQUEST["display_view"] == "2") {

                if ($inv["uniform_mixed_load"] == "Mixed") {

                    if ($inv["bwall_min"] == $inv["bwall_max"]) {

                        $tmpTDstr = $tmpTDstr . "<td bgColorrepl>" . $inv["bwall_min"] . "</td>";

                    } else {

                        $tmpTDstr = $tmpTDstr . "<td bgColorrepl>" . $inv["bwall_min"] . "-" . $inv["bwall_max"] . "</td>";

                    }

                } else {

                    $tmpTDstr = $tmpTDstr . "<td bgColorrepl>" . $inv["bwall"] . "</td>";

                }

            }

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl>" . "<a target='_blank' href='http://loops.usedcardboardboxes.com/manage_box_b2bloop.php?id=" . get_loop_box_id($inv["I"]) . "&proc=View&'";

            $tmpTDstr = $tmpTDstr . " onmouseover=\"Tip('" . str_replace("'", "\'", $tipStr) . "')\" onmouseout=\"UnTip()\"";

            $tmpTDstr = $tmpTDstr . " >";

            $tmpTDstr = $tmpTDstr . $inv["description"] . "</a></td>";

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl>" . $vendor_name . "</td>";

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl>" . $ship_from . "</td>";

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl>" . $ship_cdata_ltl . "</td>";

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl>" . $pickup_cdata_allowed . "</td>";

            $tmpTDstr = $tmpTDstr . "<td bgColorrepl>" . $ownername . "</td>";

            $tmpTDstr = $tmpTDstr . "</tr>";

            $mileage = (int) (6371 * $distC * .621371192);

            $MGArray[] = array('arrorder' => $mileage, 'arrdet' => $tmpTDstr, 'qtyavlnow' => $after_po_val, 'box_urgent' => $inv["box_urgent"]);

        }

    }

}

if ($tmp_zip != "") {

    $MGArraysort = array();

    foreach ($MGArray as $MGArraytmp) {

        $MGArraysort[] = $MGArraytmp['arrorder'];

    }

    array_multisort($MGArraysort, SORT_NUMERIC, $MGArray);

} else {

    $MGArraysort = array();

    foreach ($MGArray as $MGArraytmp) {

        $MGArraysort[] = $MGArraytmp['qtyavlnow'];

    }

    array_multisort($MGArraysort, SORT_DESC, SORT_NUMERIC, $MGArray);

}

$x = 0;
$bg = "#e4e4e4";

foreach ($MGArray as $MGArraytmp2) {

    if ($x == 0) {

        $x = 1;

        $bg = "#e4e4e4";

        $bgstyle = "display_table";

    } else {

        $x = 0;

        $bg = "#f4f4f4";

        $bgstyle = "display_table_alt";

    }

    if ($MGArraytmp2['box_urgent'] == 1) {

        $bg = "#f2cdcd";

        $bgstyle = "display_urgent";

    }

    echo str_replace("bgColorrepl", "class=$bgstyle", $MGArraytmp2['arrdet']);

}

?>

</table>

</div>

