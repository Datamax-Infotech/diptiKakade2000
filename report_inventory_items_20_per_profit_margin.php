<?php

//require_once "inc/header_session.php";
// ini_set("display_errors", "1");

// error_reporting(E_ERROR);
require_once "../mainfunctions/database.php";

require_once "../mainfunctions/general-functions.php";

if (!isset($_SESSION)) {
    session_start();
}



function arr_sort(array $DT_array, string $srt_sort, string $srt_order): array
{
    // Sorting based on the specified criteria and order
    switch ($srt_sort) {
        case "b2bid":
            $MGArraysort_I = array_column($DT_array, 'ID');
            break;
        case "description":
            $MGArraysort_I = array_column($DT_array, 'A');
            break;
        case "warehouse":
            $MGArraysort_I = array_column($DT_array, 'WH_Name');
            break;
        case "supplier":
            $MGArraysort_I = array_column($DT_array, 'Supp_Name');
            break;
        case "fob":
            $MGArraysort_I = array_column($DT_array, 'foB');
            break;
        case "b2bcost":
            $MGArraysort_I = array_column($DT_array, 'coG');
            break;
        case "gprofit":
            $MGArraysort_I = array_column($DT_array, 'porfit');
            break;
        case "pload":
            $MGArraysort_I = array_column($DT_array, 'pLoad');
            break;
        case "margin":
            $MGArraysort_I = array_column($DT_array, 'margin');
            break;
        default:
            // Default to sorting by b2bid if sorting criteria is not recognized
            $MGArraysort_I = array_column($DT_array, 'ID');
    }

    // Sorting order
    if ($srt_order == "DESC") {
        array_multisort($MGArraysort_I, SORT_DESC, $DT_array);
    } else {
        array_multisort($MGArraysort_I, SORT_ASC, $DT_array);
    }

    return $DT_array;
}

?>



<!DOCTYPE html>

<html>

<head>

	<title>Inventory Items w/ <20% Profit Margin</title>

	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css' >

	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">

	<LINK rel="stylesheet" type="text/css" href="one_style.css">

	<style>

		.datatbl{

			width:1300px;

			text-align:center;

		}

		.row_title_style{

			font-size: 14px;

			background: #ABC5DF;

			font-weight: 600;

			font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif !important;

		}



		.datatbl tr td{

			background:#E4EAEB;

		}



		.datatbl tr:hover td{

			background:#fff;

		}

		input[type=submit]{

			cursor:pointer;

		}

	</style>



</head>

<body>

<?php include "inc/header.php";?>

<?php

$INArray = array();

$boxtype[] = array("Gaylord", "GaylordUCB", "Loop", "PresoldGaylord");

$boxtype[] = array("LoopShipping", "Box", "Boxnonucb", "Presold", "Medium", "Large", "Xlarge");

$boxtype[] = array("SupersackUCB", "SupersacknonUCB");

$boxtype[] = array("PalletsUCB", "PalletsnonUCB");

?>

	<div class="main_data_css">



		<div class="dashboard_heading" style="float: left;">

			<div style="float: left;">

				Inventory Items w/ &lt;20% Profit Margin

				<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>

					<span class="tooltiptext">This report shows the user all sorting warehouse inventory items where profit margin is less than 20%. This will showcase to the user inventory items with below 20% profit margin which may require discussion and fixing the profit margin.</span>

				</div>

			</div>

		</div>

		<div class="">

			<br>



			<?php

if ($_REQUEST['sort'] != "") {

    $STArray = $_SESSION['dataArray'];

    for ($tmp = 0; $tmp < count($STArray); $tmp++) {

        $DTArray = array();

        $rowcnt = 0;

        $DTArray = $STArray[$tmp];

        switch ($tmp) {

            case 1:$tbl_title = 'Shipping Box';

                $tablenm = 'SB';

                if ($_REQUEST['tablenm'] == $tablenm) {

                    $INArraytmp = arr_sort($DTArray, $_REQUEST['sort'], $_REQUEST['sort_order']);

                } else {

                    $INArraytmp = $DTArray;

                }

                break;

            case 2:$tbl_title = 'Supersacks';

                $tablenm = 'SS';

                if ($_REQUEST['tablenm'] == $tablenm) {

                    $INArraytmp = arr_sort($DTArray, $_REQUEST['sort'], $_REQUEST['sort_order']);

                } else {

                    $INArraytmp = $DTArray;

                }

                break;

            case 3:$tbl_title = 'Pallets';

                $tablenm = 'PT';

                if ($_REQUEST['tablenm'] == $tablenm) {

                    $INArraytmp = arr_sort($DTArray, $_REQUEST['sort'], $_REQUEST['sort_order']);

                } else {

                    $INArraytmp = $DTArray;

                }

                break;

            default:$tbl_title = 'Gaylord Totes';

                $tablenm = 'GT';

                if ($_REQUEST['tablenm'] == $tablenm) {

                    $INArraytmp = arr_sort($DTArray, $_REQUEST['sort'], $_REQUEST['sort_order']);

                } else {

                    $INArraytmp = $DTArray;

                }

                break;

        }

        $sorturl = "report_inventory_items_20_per_profit_margin.php?tablenm=" . $tablenm . "&sort_order=";

        $ascarr = '<img src="images/sort_asc.png" width="6px" height="12px">';

        $descarr = '<img src="images/sort_desc.png" width="6px" height="12px">';

        echo '<table class="datatbl">

					<tr>

						<th class="row_title_style" colspan="10">' . $tbl_title . '</th>

					</tr>

					<tr>

						<th class="row_title_style" width="3%">Sr. No.

						</th>

						<th class="row_title_style" width="5%">B2B ID

							<a href="' . $sorturl . 'ASC&sort=b2bid">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=b2bid">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="26%">Description

							<a href="' . $sorturl . 'ASC&sort=description">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=description">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="7%">Warehouse

							<a href="' . $sorturl . 'ASC&sort=warehouse">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=warehouse">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="26%">Supplier

							<a href="' . $sorturl . 'ASC&sort=supplier">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=supplier">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="4%">Min FOB

							<a href="' . $sorturl . 'ASC&sort=fob">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=fob">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="6%">Total B2B Cost

							<a href="' . $sorturl . 'ASC&sort=b2bcost">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=b2bcost">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="7%">Min Gross Profit

							<a href="' . $sorturl . 'ASC&sort=gprofit">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=gprofit">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="8%">Min Gross Profit per Load

							<a href="' . $sorturl . 'ASC&sort=pload">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=pload">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="7%">% of Profit Margin

							<a href="' . $sorturl . 'ASC&sort=margin">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=margin">' . $descarr . '</a>

						</th>

					</tr>';

        foreach ($INArraytmp as $r) {

            echo "<tr><td>" . $rowcnt = $rowcnt + 1 . "</td><td>";

            echo "<a target='_blank' href='manage_box_b2bloop.php?id=" . $r['LID'] . "&proc=View'>";

            echo $r['ID'] . "</a></td><td align='left'>";

            echo $r['A'] . "</td><td>";

            echo $r['WH_Name'] . "</td><td align='left'>";

            echo $r['Supp_Name'] . "</td><td>";

            echo "$" . number_format($r['foB'], 2) . "</td><td>";

            echo "$" . number_format($r['coG'], 2) . "</td><td>";

            echo "$" . number_format($r['porfit'], 2) . "</td><td>";

            echo "$" . number_format($r['pLoad'], 2) . "</td><td>";

            echo number_format($r['margin'], 2) . "%</td></tr>";

        } // foreach closed here.

        echo '</table>';

    } // for loop end here.

    // if sort not empty ends here.

} else {

    for ($i = 0; $i < count($boxtype); $i++) {

        $sel_sql = "SELECT loop_boxes.id AS LID, loop_boxes.b2b_id AS Invid, loop_boxes.bdescription AS A, loop_boxes.box_warehouse_id AS B,

					loop_boxes.boxgoodvalueoperator As GVO, loop_boxes.boxgoodvalue As BGV

					FROM loop_boxes WHERE box_warehouse_id > 0 and b2b_status IN ('1.0', '1.1', '1.2') and type IN ('" . implode("','", $boxtype[$i]) . "') order by loop_boxes.id";

        db();
        // echo $sel_sql;
        $sel_res = db_query($sel_sql);

        while ($r = array_shift($sel_res)) {

            $vendor_b2b_rescue = "";
            $foD = "";
            $foC = "";
            $ohD = "";
            $ohC = "";
            $quantity = "";
            $invid = "";
            db_b2b();
            $q1 = "SELECT inventory.ID, inventory.vendor_b2b_rescue AS C, inventory.quantity, inventory.ulineDollar as foD, inventory.ulineCents as foC,

						inventory.overhead_costDollar as ohD, inventory.overhead_costCents as ohC

						FROM inventory WHERE ID = '" . $r['Invid'] . "'";

            $query = db_query($q1);

            while ($fetch = array_shift($query)) {

                $invid = $fetch["ID"];

                $vendor_b2b_rescue = $fetch["C"];

                $quantity = $fetch["quantity"];

                $foD = $fetch["foD"];

                $foC = $fetch["foC"];

                $ohD = $fetch["ohD"];

                $ohC = $fetch["ohC"];

            }

            //Supllier Name

            $supplier_name = "";
            $fetch = "";
            $b2bid = "";
            db();
            $q1 = "SELECT id, company_name, b2bid FROM loop_warehouse where id = '" . $vendor_b2b_rescue . "'";

            $query = db_query($q1);

            while ($fetch = array_shift($query)) {

                $b2bid = $fetch["b2bid"];

                $supplier_name = get_nickname_val($fetch['company_name'], $fetch["b2bid"]) . " (Loop ID: " . $fetch["id"] . " B2B ID:" . $fetch["b2bid"] . ")";

            }

            //warehouse name

            $wh_name = "";

            if ($r['B'] != "") {
                db();
                $qry = "SELECT company_name FROM loop_warehouse WHERE Active = 1 and id = " . $r['B'];

                $dt_view_res = db_query($qry);

                while ($data_row = array_shift($dt_view_res)) {

                    $wh_name = $data_row["company_name"];

                }

            }

            //min FOB

            $foB = $foD + $foC;

            //COGS

            $boxgoodvalue = $r['BGV'];

            $boxgoodvaluearray = explode(".", $boxgoodvalue);

            $boxgoodvalueDollar = $boxgoodvaluearray[0];

            $boxgoodvalueCents = "0." . $boxgoodvaluearray[1];

            $do1 = $boxgoodvalueDollar + $ohD;

            $co1 = $boxgoodvalueCents + $ohC;

            $cogs = $do1 + $co1;

            //Gross Profit

            $gross_profit = "";

            if ($foD != "" || $foC != "") {

                $gross_profit = $foB - $cogs;

            } else {

                $gross_profit = "0.00";

            }

            //Gross Profit Per Load

            if ($gross_profit != "0.00" || $gross_profit != "") {

                $gross_profit_load = $gross_profit * $quantity;

            } else {

                $gross_profit_load = "0.00";

            }

            //% of Profit Margin

            //$profit_margin = (($gross_profit / $foB) * 100);
            if (!empty($foB)) {
                $profit_margin = (($gross_profit / $foB) * 100);
            } else {
                $profit_margin = 0;
            }

            if ($profit_margin < 20) {

                $INArray[$i][] = array('LID' => $r['LID'], 'ID' => $invid, 'A' => $r['A'],

                    'WH_Name' => $wh_name, 'Supp_Name' => $supplier_name, 'foB' => $foB,

                    'CID' => $b2bid, 'coG' => $cogs, 'porfit' => $gross_profit,

                    'pLoad' => $gross_profit_load, 'margin' => $profit_margin,

                );

            } // if less than 20 end here.

        }

    }

    $_SESSION['dataArray'] = $INArray;

    for ($tmp = 0; $tmp < count($INArray); $tmp++) {

        $INArraytmp = array();

        $rowcnt = 0;

        $INArraytmp = $INArray[$tmp];

        switch ($tmp) {

            case 1:$tbl_title = 'Shipping Box';

                $tablenm = 'SB';

                break;

            case 2:$tbl_title = 'Supersacks';

                $tablenm = 'SS';

                break;

            case 3:$tbl_title = 'Pallets';

                $tablenm = 'PT';

                break;

            default:$tbl_title = 'Gaylord Totes';

                $tablenm = 'GT';

                break;

        }

        $sorturl = "report_inventory_items_20_per_profit_margin.php?tablenm=" . $tablenm . "&sort_order=";

        $ascarr = '<img src="images/sort_asc.png" width="6px" height="12px">';

        $descarr = '<img src="images/sort_desc.png" width="6px" height="12px">';

        echo '<table class="datatbl">

					<tr>

						<th class="row_title_style" colspan="10">' . $tbl_title . '</th>

					</tr>

					<tr>

						<th class="row_title_style" width="3%">Sr. No.

						</th>

						<th class="row_title_style" width="5%">B2B ID

							<a href="' . $sorturl . 'ASC&sort=b2bid">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=b2bid">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="26%">Description

							<a href="' . $sorturl . 'ASC&sort=description">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=description">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="7%">Warehouse

							<a href="' . $sorturl . 'ASC&sort=warehouse">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=warehouse">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="26%">Supplier

							<a href="' . $sorturl . 'ASC&sort=supplier">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=supplier">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="4%">Min FOB

							<a href="' . $sorturl . 'ASC&sort=fob">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=fob">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="6%">Total B2B Cost

							<a href="' . $sorturl . 'ASC&sort=b2bcost">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=b2bcost">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="7%">Min Gross Profit

							<a href="' . $sorturl . 'ASC&sort=gprofit">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=gprofit">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="8%">Min Gross Profit per Load

							<a href="' . $sorturl . 'ASC&sort=pload">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=pload">' . $descarr . '</a>

						</th>

						<th class="row_title_style" width="7%">% of Profit Margin

							<a href="' . $sorturl . 'ASC&sort=margin">' . $ascarr . '</a>

							<a href="' . $sorturl . 'DESC&sort=margin">' . $descarr . '</a>

						</th>

					</tr>';

        foreach ($INArraytmp as $r) {

            echo "<tr><td>" . $rowcnt = $rowcnt + 1 . "</td><td>";

            echo "<a target='_blank' href='manage_box_b2bloop.php?id=" . $r['LID'] . "&proc=View'>";

            echo $r['ID'] . "</a></td><td align='left'>";

            echo $r['A'] . "</td><td>";

            echo $r['WH_Name'] . "</td><td align='left'>";

            echo $r['Supp_Name'] . "</td><td>";

            echo "$" . number_format($r['foB'], 2) . "</td><td>";

            echo "$" . number_format($r['coG'], 2) . "</td><td>";

            echo "$" . number_format($r['porfit'], 2) . "</td><td>";

            echo "$" . number_format($r['pLoad'], 2) . "</td><td>";

            echo number_format($r['margin'], 2) . "%</td></tr>";

        } // foreach closed here.

        echo '</table>';

    } // for loop end here.

} // if sort == "" else part end here.

?>

		</div>

	</div>

</body>

</html>