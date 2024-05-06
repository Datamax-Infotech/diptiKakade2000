<?php

//require ("inc/header_session.php");
require "../mainfunctions/database.php";
require "../mainfunctions/general-functions.php";

//set_time_limit(0);
ini_set('memory_limit', '-1');

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Warehouse Inventory Items Inbound Flow Tracker</title>
	<LINK rel='stylesheet' type='text/css' href='one_style.css' >
	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css' >
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
</head>

<body>
	<?php include "inc/header.php";?>
	<div class="main_data_css">
		<div class="dashboard_heading" style="float: left;">
			<div style="float: left;">
			 Warehouse Inventory Items Inbound Flow Tracker

			<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
			<span class="tooltiptext">This report shows the user all sorting warehouse inventory items inbound flow based on drop down options. This will showcase to the user inventory items we are least or not getting, which may require follow up.</span></div>
			<div style="height: 13px;">&nbsp;</div>
			</div>
		</div>
		<form method="post" name="sort_inventory" id="sort_inventory" action="report_sort_inventory_trailing_30day.php" >
			<table border="0" width="1300" >
				<tr>

					<td valign="top" width="800px">
						Sort as: &nbsp;
						<select name="inv_filter" id="inv_filter">
							<option value="1" <?php if ($_REQUEST["inv_filter"] == 1) {
    echo " selected ";
}
?>>Show All</option>
							<option value="2" <?php if ($_REQUEST["inv_filter"] == 2) {
    echo " selected ";
}
?>>No Inbound Flow in Last 30 Days</option>
							<option value="3" <?php if ($_REQUEST["inv_filter"] == 3) {
    echo " selected ";
}
?>>&lt 20% inbound flow from previous month</option>
						</select> &emsp;
						<input type='submit' id='btn_submit' name='btn_submit' value="Show Report" />
					</td>

				</tr>
			</table>

		</form>

		<?php

if (isset($_REQUEST["btn_submit"])) {
    $DTArray = array();
    db();
    $lastmonth_qry_array = array();
    $lastmonth_qry = "SELECT box_id, sum(boxgood) as sumboxgood from loop_inventory where boxgood >0 and ";
    $lastmonth_qry .= " UNIX_TIMESTAMP(add_date) >= " . strtotime('today - 30 days') . " AND UNIX_TIMESTAMP(add_date) <= " . strtotime(date("m/d/Y")) . " group by box_id";

    $dt_res_so = db_query($lastmonth_qry);
    while ($so_row = array_shift($dt_res_so)) {
        $lastmonth_qry_array[$so_row["box_id"]] = $so_row["sumboxgood"];
    }

    $box_type_str_arr = array("'Gaylord','GaylordUCB', 'PresoldGaylord', 'Loop'", "'LoopShipping','Box','Boxnonucb','Presold','Medium','Large','Xlarge','Boxnonucb'", "'PalletsUCB','PalletsnonUCB'", "'SupersackUCB','SupersacknonUCB'");
    $box_type_cnt = 0;
    foreach ($box_type_str_arr as $box_type_str_arr_tmp) {
        $box_type_cnt = $box_type_cnt + 1;

        if ($box_type_cnt == 1) {$box_type = "Gaylord Totes";}
        if ($box_type_cnt == 2) {$box_type = "Shipping Boxes";}
        if ($box_type_cnt == 3) {$box_type = "Pallets";}
        if ($box_type_cnt == 4) {$box_type = "Supersacks";}

        db();
        $sql = "SELECT box_warehouse_id, b2b_id, id, expected_loads_per_mo, bdescription, vendor_b2b_rescue FROM loop_boxes
					where box_warehouse_id <> 238 and b2b_status IN ('1.0', '1.1', '1.2') and type in (" . $box_type_str_arr_tmp . ") order by b2b_id ASC";

        $result = db_query($sql);
        while ($boxrow = array_shift($result)) {
            $lastmonth_val = 0;
            $lastmonth_val = $lastmonth_qry_array[$boxrow["id"]];
            $warehouse_id = $boxrow["box_warehouse_id"];
            $b2b_id = $boxrow["b2b_id"];
            $loop_id = $boxrow["id"];
            $expected_loads_per_mo = $boxrow["expected_loads_per_mo"];
            $bdescription = $boxrow["bdescription"];
            $supplier_id = "";
            $supplier_nm = "";
            if ($boxrow["vendor_b2b_rescue"] != "") {
                db();
                $q1 = "SELECT * FROM loop_warehouse where id = " . $boxrow["vendor_b2b_rescue"];
                $v_query = db_query($q1);
                while ($v_fetch = array_shift($v_query)) {
                    $supplier_id = $v_fetch["b2bid"];
                    $supplier_nm = get_nickname_val($v_fetch['company_name'], $v_fetch["b2bid"]);
                }
            }

            $sort_warehouse = "";
            db();
            $qry = "SELECT company_name FROM loop_warehouse WHERE id = '" . $warehouse_id . "'";
            $dt_view_res = db_query($qry);
            while ($data_row = array_shift($dt_view_res)) {
                $sort_warehouse = $data_row["company_name"];
            }

            //last to last month qty
            $ltlast_val = "";
            $difference = "";
            $percentage = 0;
            if ($_REQUEST["inv_filter"] == 3) {
                db();
                $ltlast_qry = "SELECT sum(boxgood) as A from loop_inventory where in_out = 0 and box_id = " . $loop_id;
                $ltlast_qry .= " AND UNIX_TIMESTAMP(add_date) >= " . strtotime('today - 60 days') . " AND UNIX_TIMESTAMP(add_date) <= " . strtotime('today - 31 days');

                $ltlast_res = db_query($ltlast_qry);
                $ltlast_val = $ltlast_res[0]['A'];

                $difference = $lastmonth_val - $ltlast_val;
                if ($ltlast_val != 0) {
                    //$percentage = ($lastmonth_val / $ltlast_val) * 100;
                }
                $percentage = ($difference / $lastmonth_val) * 100;

                if ($percentage < 20) {
                    $DTArray[$box_type_cnt][] = array('loop_id' => $loop_id, 'b2b_id' => $b2b_id,
                        'desc' => $bdescription, 'warehouse' => $sort_warehouse,
                        'supp_id' => $supplier_id, 'supp_name' => $supplier_nm,
                        'load_month' => $boxrow['expected_loads_per_mo'], 'last_month' => $lastmonth_val,
                        'ltlast_val' => $ltlast_val, 'difference' => $difference, 'percentage' => $percentage,
                    );
                }
            } else if ($_REQUEST["inv_filter"] == 2) {
                if ($lastmonth_val == 0) {
                    $DTArray[$box_type_cnt][] = array('loop_id' => $loop_id, 'b2b_id' => $b2b_id,
                        'desc' => $bdescription, 'warehouse' => $sort_warehouse,
                        'supp_id' => $supplier_id, 'supp_name' => $supplier_nm,
                        'load_month' => $boxrow['expected_loads_per_mo'], 'last_month' => $lastmonth_val,
                        'ltlast_val' => $ltlast_val, 'difference' => $difference, 'percentage' => $percentage,
                    );
                }
            } else {
                $DTArray[$box_type_cnt][] = array('loop_id' => $loop_id, 'b2b_id' => $b2b_id,
                    'desc' => $bdescription, 'warehouse' => $sort_warehouse,
                    'supp_id' => $supplier_id, 'supp_name' => $supplier_nm,
                    'load_month' => $boxrow['expected_loads_per_mo'], 'last_month' => $lastmonth_val,
                    'ltlast_val' => $ltlast_val, 'difference' => $difference, 'percentage' => $percentage,
                );
            }
        }
    }

    ?>

		<table width="1300px">

		<?php
for ($i = 1; $i < 5; $i++) {
        switch ($i) {
            case 1:$box_title = "Gaylord Totes";
                break;
            case 2:$box_title = "Shipping Boxes";
                break;
            case 3:$box_title = "Pallets";
                break;
            case 4:$box_title = "Supersacks";
                break;
        }
        $rwnum = 1;
        ?>
			<tr>
				<td colspan="10" align="center">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="10" bgColor='#ABC5DF' align="center">
					<strong><?php echo $box_title; ?></strong>
				</td>
			</tr>
			<tr align="middle">
				<td bgColor='#ABC5DF' class="style12_new" width="70px">Sr. No</td>
				<td bgColor='#ABC5DF' class="style12_new" width="70px">B2B ID</td>
				<td bgColor='#ABC5DF' class="style12_new" width="350px">Description</td>
				<td bgColor='#ABC5DF' class="style12_new" width="200px">Warehouse</td>
				<td bgColor='#ABC5DF' class="style12_new" width="250px">Supplier</td>
				<?php if ($_REQUEST["inv_filter"] == 2) {?>
				<td bgColor='#ABC5DF' class="style12_new" width="50px">Expected # of Loads/Mo</td>
				<?php } else {?>

				<td bgColor='#ABC5DF' class="style12_new" width="70px">Last Month Qty</td>

				<?php if ($_REQUEST["inv_filter"] == 3) {?>
				<td bgColor='#ABC5DF' class="style12_new" width="70px">31-60days ago Qty</td>
				<td bgColor='#ABC5DF' class="style12_new" width="70px">Difference</td>
				<td bgColor='#ABC5DF' class="style12_new" width="70px">% Difference</td>
				<?php }}
        ?>
			</tr>
		<?php
        $SIArray = $DTArray[$i];
        // array_multisort(array_column($SIArray, 'warehouse'), SORT_ASC,
        // array_column($SIArray, 'last_month'), SORT_DESC, $SIArray);

        usort($SIArray, function($a, $b) {
            if ($a['warehouse'] == $b['warehouse']) {
                return $b['last_month'] - $a['last_month'];
            }
            return $a['warehouse'] <=> $b['warehouse'];
        });


        foreach ($SIArray as $row) {
            if ($bg == "#EBEBEB") {
                $bg = "#F3F3F3";
            } else {
                $bg = "#EBEBEB";
            }
            ?>
			<tr>
				<td bgColor='<?php echo $bg; ?>'><?php echo $rwnum++; ?></td>
				<td bgColor='<?php echo $bg; ?>'>
					<a href="manage_box_b2bloop.php?id=<?php echo $row['loop_id']; ?>&proc=View" target="_blank"><?php echo $row['b2b_id']; ?></a></td>
				<td bgColor='<?php echo $bg; ?>'>
					<a href="manage_box_b2bloop.php?id=<?php echo $row['loop_id']; ?>&proc=View" target="_blank"><?php echo $row['desc']; ?></a></td>
				<td bgColor='<?php echo $bg; ?>'><?php echo $row['warehouse']; ?></td>

				<td bgColor='<?php echo $bg; ?>'>
					<a href ="viewCompany.php?ID=<?php echo $row['supp_id']; ?>" target="_blank"><?php echo $row['supp_name']; ?></a>
				</td>
				<?php if ($_REQUEST["inv_filter"] == 2) {?>
				<td bgColor='<?php echo $bg; ?>'><?php echo $row['load_month']; ?></td>
				<?php } else {?>
				<td bgColor='<?php echo $bg; ?>'><?php echo $row['last_month']; ?></td>
				<?php if ($_REQUEST["inv_filter"] == 3) {?>
				<td bgColor='<?php echo $bg; ?>'><?php echo $row['ltlast_val']; ?></td>
				<td bgColor='<?php echo $bg; ?>'><?php echo $row['difference']; ?></td>
				<td bgColor='<?php echo $bg; ?>'><?php echo number_format($row['percentage'], 0) . "%"; ?></td>
				<?php }}?>
			</tr>
		<?php

        }
    }
    ?>
		</table>
		<?php
}
?>
	</div>
</body>
</html>
