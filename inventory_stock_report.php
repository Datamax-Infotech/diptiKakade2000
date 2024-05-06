<?php

session_start();

//require ("inc/header_session.php");
// ini_set("display_errors", "1");

// error_reporting(E_ALL);
require "../mainfunctions/database.php";

require "../mainfunctions/general-functions.php";

?>

<!DOCTYPE html>



<html>

<head>

	<title>Stock Inventory Report</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">

	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>

	<link rel='stylesheet' type='text/css' href='one_style.css'>

	<style>

		.invtbl_stock{

			font-size:13px;

		}

		.invtbl_stock th,

		.invtbl_stock tfoot td{

			background-color:#ABC5DF;

		}



		.invtbl_stock tr:nth-child(even) {

			background-color: #efefef;

		}

		.invtbl_stock tr:nth-child(odd) {

			background-color: #D9D9D9;

		}

	</style>

</head>



<body class="basic_style">

<?php include "inc/header.php";?>

<div class="main_data_css">

	<div class="dashboard_heading" style="float: left;">

		<div style="float: left;">Inventory Stock Report</div>

		&nbsp;<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>

		<span class="tooltiptext">This report is showing the total in-hand inventory available in the warehouse..</span></div>

		<div style="height: 13px;">&nbsp;</div>

	</div>



<?php

$surl = "inventory_stock_report.php?sort_order=";

$aimg = "<img src='images/sort_asc.png' width='5px' height='10px'>";

$dimg = "<img src='images/sort_desc.png' width='5px' height='10px'>";
$box_type = "";
$INVarray = "";

if (isset($_REQUEST['sort']) && $_REQUEST['sort'] != '') {

    $INVarray = $_SESSION['invsortarr'];

} else {

    $_SESSION['invsortarr'] = "";
    $box_type_cnt = 0;

    $box_type_arr = array("'Gaylord','GaylordUCB', 'PresoldGaylord', 'Loop'",

        "'LoopShipping','Box','Boxnonucb','Presold','Medium','Large','Xlarge','Boxnonucb'",

        "'SupersackUCB','SupersacknonUCB'", "'PalletsUCB','PalletsnonUCB'",

        "'DrumBarrelUCB','DrumBarrelnonUCB'", "'Recycling','Other','Waste-to-Energy'");

    foreach ($box_type_arr as $box_type_tmp) {

        //$box_type_cnt = $box_type_cnt + 1;
        $box_type_cnt++;
        if ($box_type_cnt == 1) {$box_type = "Gaylord";}

        if ($box_type_cnt == 2) {$box_type = "Shipping Boxes";}

        if ($box_type_cnt == 3) {$box_type = "Supersacks";}

        if ($box_type_cnt == 4) {$box_type = "Pallets";}

        if ($box_type_cnt == 5) {$box_type = "Drums Barrels";}

        if ($box_type_cnt == 6) {$box_type = "Recycling Other";}

        db();
        $sql = "SELECT id, b2b_id, bdescription, boxgoodvalueoperator, boxgoodvalue, box_warehouse_id, actual_qty_calculated

			FROM loop_boxes WHERE type IN (" . $box_type_tmp . ") and actual_qty_calculated > 0 and box_warehouse_id <> 238 ORDER BY id ASC";

        $i = 1;
        $warehouse_id = "";

        $dataArr = array();

        $result = db_query($sql);

        while ($myrow = array_shift($result)) {

            $time_start = microtime(true);

            $id = $myrow["id"];

            $b2b_id = $myrow["b2b_id"];

            $boxgoodvalueoperator = $myrow['boxgoodvalueoperator'];

            $bdescription = $myrow["bdescription"];

            $bdescription = preg_replace("(\n)", "<BR>", $bdescription);

            $boxgoodvalue = $myrow["boxgoodvalue"];

            $warehouse_id = $myrow["box_warehouse_id"];
            $vendor_b2b_rescue = "";
            $b2b_ulineCents = "";
            $b2b_ulineDollar = "";
            $b2b_ovh_costDollar = "";
            $b2b_ovh_costCents = "";

            if ($b2b_id > 0) {
                db_b2b();
                $sql_b2b = "SELECT ulineDollar, ulineCents, overhead_costDollar, overhead_costCents, vendor_b2b_rescue FROM inventory WHERE ID = " . $b2b_id;

                $result_b2b = db_query($sql_b2b);

                $myrowsel_b2b = array_shift($result_b2b);

                $b2b_ulineDollar = $myrowsel_b2b["ulineDollar"];

                $b2b_ulineCents = $myrowsel_b2b["ulineCents"];

                //$b2b_ovh_costDollar = round($myrowsel_b2b["overhead_costDollar"]);
                $b2b_ovh_costDollar = round($myrowsel_b2b["overhead_costDollar"] ?? 0.0);
                $b2b_ovh_costCents = $myrowsel_b2b["overhead_costCents"];

                $vendor_b2b_rescue = $myrowsel_b2b["vendor_b2b_rescue"];

            }

            $supplier_name = "";
            db();
            $q1 = "SELECT id, company_name, b2bid FROM loop_warehouse where id = '" . $vendor_b2b_rescue . "'";

            $query = db_query($q1);

            while ($fetch = array_shift($query)) {

                $supplier_name = get_nickname_val($fetch['company_name'], $fetch["b2bid"]);

            }

            //Min FoB

            $mfob = "0.00";

            if ($b2b_ulineDollar != "" || $b2b_ulineCents != "") {

                $mfob = number_format($b2b_ulineDollar + $b2b_ulineCents, 2);

            }

            //Box Cost

            if ($boxgoodvalue != "") {

                $tmppos_1 = stripos($boxgoodvalue, ".");

                if ($boxgoodvalue < 0) {$boxgoodvalueoperator = "-";}

                if ($tmppos_1 != false) {

                    $boxcost = $boxgoodvalueoperator . "$" . str_replace("-", "", number_format($boxgoodvalue, 2));

                } else {

                    $boxcost = $boxgoodvalueoperator . "$" . str_replace("-", "", number_format($boxgoodvalue)) . ".00";

                }

            } else {

                $boxcost = "$0.00";

            }

            $ovh_cost = "0.00";

            if ($b2b_ovh_costDollar != "" || $b2b_ovh_costCents != "") {

                $ovh_cost = $b2b_ovh_costDollar + $b2b_ovh_costCents;

            }

            $b2bcost = $boxgoodvalue + $ovh_cost;

            $warehouse = "";
            db();
            $dt_view_qry = "SELECT company_name FROM loop_warehouse where loop_warehouse.id ='" . $warehouse_id . "'";

            $dt_view_res = db_query($dt_view_qry);

            while ($dt_view_row = array_shift($dt_view_res)) {

                $warehouse = $dt_view_row["company_name"];

            }

            $quantity = $myrow["actual_qty_calculated"];

            if ($quantity != 0) {

                $totboxcost = $quantity * $boxgoodvalue;

                $totovh_cost = $quantity * $ovh_cost;

                $totval = $quantity * $mfob;

                $totcost = $quantity * $b2bcost;

                $totprof = $totval - $totcost;

                if ($totval == 0) {

                    $profitmargin = "0.00";

                } else {

                    $profitmargin = ($totprof / $totval) * 100;

                }

                $dataArr[] = array('ID' => $id, 'item_name' => $bdescription, 'warehouse' => $warehouse,

                    'supplier_name' => $supplier_name, 'quantity' => $quantity,

                    'mfob' => $mfob, 'boxgoodvalueoperator' => $boxgoodvalueoperator,

                    'boxgoodvalue' => $boxgoodvalue, 'totboxcost' => $totboxcost,

                    'ovh_cost' => $ovh_cost, 'totovh_cost' => $totovh_cost,

                    'b2bcost' => $b2bcost, 'totval' => $totval, 'totcost' => $totcost,

                    'totprof' => $totprof, 'profitmargin' => $profitmargin,

                );

            }

        }

        // if (count($dataArr) > 0) {

        //     $INVarray[] = array('box_type' => $box_type, 'tbl_data' => $dataArr);

        // }
        if (!isset($INVarray) || !is_array($INVarray)) {
            $INVarray = array();
        }

        if (count($dataArr) > 0) {
            $INVarray[] = array('box_type' => $box_type, 'tbl_data' => $dataArr);
        }

        $_SESSION['invsortarr'] = $INVarray;

    }

}

?>

	<?php

if (!empty($INVarray)) {

    foreach ($INVarray as $val) {

        echo '<table class="invtbl_stock" cellSpacing="1" cellpadding="1" border="0" width="100%">';

        echo '<thead><tr bgColor="#ABC5DF"><th colspan="14">';

        echo $val['box_type'] . '</th></tr>';

        echo '<tr bgColor="#ABC5DF">';

        echo '<th width="50px">Sr.No.</th>';

        echo '<th>Inventory Name <a href="' . $surl . 'ASC&sort=item_name&tbl=' . $val['box_type'] . '">' . $aimg . '</a> ';

        echo '<a href="' . $surl . 'DESC&sort=item_name&tbl=' . $val['box_type'] . '">' . $dimg . '</a></th>';

        echo '<th width="100px">Warehouse <a href="' . $surl . 'ASC&sort=warehouse&tbl=' . $val['box_type'] . '">' . $aimg . '</a> ';

        echo '<a href="' . $surl . 'DESC&sort=warehouse&tbl=' . $val['box_type'] . '">' . $dimg . '</a></th>';

        echo '<th width="200px">Supplier Name <a href="' . $surl . 'ASC&sort=supplier_name&tbl=' . $val['box_type'] . '">' . $aimg . '</a> ';

        echo '<a href="' . $surl . 'DESC&sort=supplier_name&tbl=' . $val['box_type'] . '">' . $dimg . '</a></th>';

        echo '<th width="70px">Quantity<br>(A) <a href="' . $surl . 'ASC&sort=quantity&tbl=' . $val['box_type'] . '">' . $aimg . '</a> ';

        echo '<a href="' . $surl . 'DESC&sort=quantity&tbl=' . $val['box_type'] . '">' . $dimg . '</a></th>';

        echo '<th width="70px">Min FoB<br>(B) <a href="' . $surl . 'ASC&sort=mfob&tbl=' . $val['box_type'] . '">' . $aimg . '</a> ';

        echo '<a href="' . $surl . 'DESC&sort=mfob&tbl=' . $val['box_type'] . '">' . $dimg . '</a></th>';

        echo '<th width="70px">Box Cost<br>(C) <a href="' . $surl . 'ASC&sort=boxgoodvalue&tbl=' . $val['box_type'] . '">' . $aimg . '</a> ';

        echo '<a href="' . $surl . 'DESC&sort=boxgoodvalue&tbl=' . $val['box_type'] . '">' . $dimg . '</a></th>';

        echo '<th width="80px">Overhead Cost<br>(D) <a href="' . $surl . 'ASC&sort=ovh_cost&tbl=' . $val['box_type'] . '">' . $aimg . '</a> ';

        echo '<a href="' . $surl . 'DESC&sort=ovh_cost&tbl=' . $val['box_type'] . '">' . $dimg . '</a></th>';

        echo '<th width="80px">B2B Cost<br>(E=C+D) <a href="' . $surl . 'ASC&sort=b2bcost&tbl=' . $val['box_type'] . '">' . $aimg . '</a> ';

        echo '<a href="' . $surl . 'DESC&sort=b2bcost&tbl=' . $val['box_type'] . '">' . $dimg . '</a></th>';

        echo '<th width="80px">Total Value<br>(F=A*B) <a href="' . $surl . 'ASC&sort=totval&tbl=' . $val['box_type'] . '">' . $aimg . '</a> ';

        echo '<a href="' . $surl . 'DESC&sort=totval&tbl=' . $val['box_type'] . '">' . $dimg . '</a></th>';

        echo '<th width="80px">Total Box Cost<br>(G=A*C) <a href="' . $surl . 'ASC&sort=totboxcost&tbl=' . $val['box_type'] . '">' . $aimg . '</a> ';

        echo '<a href="' . $surl . 'DESC&sort=totboxcost&tbl=' . $val['box_type'] . '">' . $dimg . '</a></th>';

        echo '<th width="90px">Total Overhead<br>Cost(H=A*D) <a href="' . $surl . 'ASC&sort=totovh_cost&tbl=' . $val['box_type'] . '">' . $aimg . '</a> ';

        echo '<a href="' . $surl . 'DESC&sort=totovh_cost&tbl=' . $val['box_type'] . '">' . $dimg . '</a></th>';

        echo '<th width="80px">Total Profit<br>(I=F-G-H) <a href="' . $surl . 'ASC&sort=totprof&tbl=' . $val['box_type'] . '">' . $aimg . '</a> ';

        echo '<a href="' . $surl . 'DESC&sort=totprof&tbl=' . $val['box_type'] . '">' . $dimg . '</a></th>';

        echo '<th width="80px">Profit Margin<br>(J=I/F*100) <a href="' . $surl . 'ASC&sort=profitmargin&tbl=' . $val['box_type'] . '">' . $aimg . '</a> ';

        echo '<a href="' . $surl . 'DESC&sort=profitmargin&tbl=' . $val['box_type'] . '">' . $dimg . '</a>';

        echo '</th></tr></thead><tbody>';

        $i = 1;

        $sumtotval = $sumtotcost = $sumtotprof = 0;

        $MGArraysort_I = array();

        if (isset($_REQUEST['tbl']) && $_REQUEST['tbl'] == $val['box_type']) {

            $coltitle = $_REQUEST['sort'];

            foreach ($val['tbl_data'] as $MGArraytmp) {

                $MGArraysort_I[] = $MGArraytmp[$coltitle];

            }

            if ($_REQUEST['sort_order'] == "ASC") {

                if (in_array($_REQUEST['sort'], array("quantity", "mfob", "boxgoodvalue", "ovh_cost", "b2bcost", "totval", "totboxcost", "totovh_cost", "totprof", "profitmargin"))) {

                    array_multisort($MGArraysort_I, SORT_ASC, SORT_NUMERIC, $val['tbl_data']);

                } else {

                    array_multisort($MGArraysort_I, SORT_ASC, SORT_STRING, $val['tbl_data']);

                }

            }

            if ($_REQUEST['sort_order'] == "DESC") {

                if (in_array($_REQUEST['sort'], array("quantity", "mfob", "boxgoodvalue", "ovh_cost", "b2bcost", "totval", "totboxcost", "totovh_cost", "totprof", "profitmargin"))) {

                    array_multisort($MGArraysort_I, SORT_DESC, SORT_NUMERIC, $val['tbl_data']);

                } else {

                    array_multisort($MGArraysort_I, SORT_DESC, SORT_STRING, $val['tbl_data']);

                }

            }

        } else {

            foreach ($val['tbl_data'] as $MGArraytmp) {

                $MGArraysort_I[] = $MGArraytmp['quantity'];

            }

            array_multisort($MGArraysort_I, SORT_DESC, SORT_NUMERIC, $val['tbl_data']);

        }

        $sumtotval = $sumtotcost = $sumtotboxcost = $sumtotovhcost = $sumtotprof = 0;

        foreach ($val['tbl_data'] as $row) {

            echo '<tr><td>' . $i++ . '</td><td>';

            echo '<a target="_blank" href="manage_box_b2bloop.php?id=' . $row['ID'] . '&proc=View">';

            echo $row['item_name'] . '</a></td><td>';

            echo $row['warehouse'] . '</td><td>';

            echo $row['supplier_name'] . '</td><td align="right">';

            if ($row["quantity"] < 0) {

                echo '<font color="red">';

            } else {

                echo '<font color="#492105">';

            }

            echo $row['quantity'] . '</font></td><td align="right">$';

            echo $row['mfob'] . '</td><td align="right">$';

            echo $row['boxgoodvalueoperator'] . '$' . $row['boxgoodvalue'] . '</td><td align="right">$';

            echo number_format($row['ovh_cost'], 2) . '</td><td align="right">$';

            echo number_format($row['b2bcost'], 2) . '</td><td align="right">$';

            echo number_format($row['totval'], 2) . '</td><td align="right">$';

            echo number_format($row['totboxcost'], 2) . '</td><td align="right">$';

            echo number_format($row['totovh_cost'], 2) . '</td><td align="right">$';

            echo number_format($row['totprof'], 2) . '</td><td align="right">';

            echo number_format($row['profitmargin'], 2) . '%';

            echo '</td></tr>';

            $sumtotval += $row['totval'];

            $sumtotcost += $row['totcost'];

            $sumtotboxcost += $row['totboxcost'];

            $sumtotovhcost += $row['totovh_cost'];

            $sumtotprof += $row['totprof'];

        }

        //echo '</tbody></table>';

        echo '</tbody><tfoot><tr>';

        echo '<td colspan="9" align="right"><strong>Total</strong></td>';

        echo '<td align="right">$' . number_format($sumtotval, 2) . '</td>';

        echo '<td align="right">$' . number_format($sumtotboxcost, 2) . '</td>';

        echo '<td align="right">$' . number_format($sumtotovhcost, 2) . '</td>';

        echo '<td align="right">$' . number_format($sumtotprof, 2) . '</td>';

        echo '<td align="right">' . number_format(($sumtotprof / $sumtotval) * 100, 2) . '%</td>';

        echo '</tr></tfoot></table><br>';

    }

    echo '<table class="invtbl_stock" cellSpacing="1" cellpadding="1" border="0" width="60%">';

    echo '<thead><tr bgColor="#ABC5DF"><th colspan="7"> SUMMARY TABLE';

    echo '</th></tr><tr bgColor="#ABC5DF">';

    echo '<th width="190px">Box Type</th>';

    echo '<th width="100px">Quantity</th>';

    echo '<th width="100px">Total Value</th>';

    echo '<th width="100px">Total Box Cost</th>';

    echo '<th width="120px">Total Overhead Cost</th>';

    echo '<th width="100px">Total Profit</th>';

    echo '<th width="100px">Profit Margin</th>';

    echo '</tr></thead><tbody>';

    $quant = $toval = $boxcost = $ovhcost = $totprof = 0;

    foreach ($INVarray as $val) {

        $GTot_quant = array_sum(array_column($val['tbl_data'], 'quantity'));

        $GTot_val = array_sum(array_column($val['tbl_data'], 'totval'));

        $GTot_boxcost = array_sum(array_column($val['tbl_data'], 'totboxcost'));

        $GTot_ovhcost = array_sum(array_column($val['tbl_data'], 'totovh_cost'));

        $GTot_totprof = array_sum(array_column($val['tbl_data'], 'totprof'));

        echo '<tr><td>' . $val["box_type"];

        echo '</td><td align="right">' . $GTot_quant;

        echo '</td><td align="right">$' . number_format($GTot_val, 2);

        echo '</td><td align="right">$' . number_format($GTot_boxcost, 2);

        echo '</td><td align="right">$' . number_format($GTot_ovhcost, 2);

        echo '</td><td align="right">$' . number_format($GTot_totprof, 2);

        echo '</td><td align="right">' . number_format(($GTot_totprof / $GTot_val) * 100, 2);

        echo '%</td></tr>';

        $quant += $GTot_quant;

        $toval += $GTot_val;

        $boxcost += $GTot_boxcost;

        $ovhcost += $GTot_ovhcost;

        $totprof += $GTot_totprof;

    }

    echo '</tbody><tfoot><tr><td>Total</td><td align="right">';

    echo number_format($quant) . '</td><td align="right">$';

    echo number_format($toval, 2) . '</td><td align="right">$';

    echo number_format($boxcost, 2) . '</td><td align="right">$';

    echo number_format($ovhcost, 2) . '</td><td align="right">$';

    echo number_format($totprof, 2) . '</td><td align="right">';

    echo number_format(($totprof / $toval) * 100, 2) . '%</td></tr></tfoot>';

    echo '</table><br><br><br>';

}

?>



	</div>

</body>

</html>