<?php

require "../mainfunctions/database.php";

require "../mainfunctions/general-functions.php";

$title_name = "Negative Gross Profit - Inventory List";

?>

<!DOCTYPE html>

<html>

<head>



	<title><?php echo $title_name; ?></title>

	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">

	<link rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>

</head>



<body>

<?php include "inc/header.php";?>

<div style="">

	<div class="main_data_css">

		<div class="dashboard_heading" style="float: left;">

			<div style="float: left;"><?php echo $title_name; ?>



			<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>

			<span class="tooltiptext">This report shows the user all inventory items where the gross profit stored for the item is a negative value. These inventory items should be reviewed regularly to ensure they are accurate and not data entry mistakes.</span></div>



			<div style="height: 13px;">&nbsp;</div>

			</div>

		</div>

		<br/>&nbsp;<br/>



		<table cellSpacing="1" cellPadding="1" width="800" border="0">

		<tr>

			<th style="background-color:#FFCC66;" colspan="4">Min Gross Profit less than zero  - Inventory List </th>

		</tr>

		<tr>

			<th style="background-color:#FFCC66;">Sr. no</th>

			<th style="background-color:#FFCC66;">Loop Id</th>

			<th style="background-color:#FFCC66;">B2B Id</th>

			<th style="background-color:#FFCC66;">Min Gross Profit</th>

		</tr>

		<?php

db();
$sql = db_query("SELECT * FROM loop_boxes");

while ($row = array_shift($sql)) {

    if ($row["b2b_id"] > 0) {

        $boxgoodvalue = $row["boxgoodvalue"];

        $boxgoodvaluearray = explode(".", $boxgoodvalue);

        $boxgoodvalueDollar = $boxgoodvaluearray[0];

        $boxgoodvalueCents = $boxgoodvaluearray[1];

        $id = $row["id"];

        $b2b_id = $row["b2b_id"];
        db_b2b();
        $sql_b2b = "SELECT * FROM inventory WHERE id = " . $b2b_id;

        $result_b2b = db_query($sql_b2b);

        $myrowsel_b2b = array_shift($result_b2b);

        $b2b_ovh_costDollar = round($myrowsel_b2b["overhead_costDollar"]);

        $b2b_ovh_costCents = $myrowsel_b2b["overhead_costCents"];

        $b2b_costDollar = floatval($boxgoodvalueDollar) + floatval($b2b_ovh_costDollar);

        $b2b_costCents = "0." . $boxgoodvalueCents + $b2b_ovh_costCents;

        $b2b_ulineDollar = $myrowsel_b2b["ulineDollar"];

        $b2b_ulineCents = $myrowsel_b2b["ulineCents"];

        $mingross_profit = ($b2b_ulineDollar + $b2b_ulineCents) - ($b2b_costDollar + $b2b_costCents);

        if ($mingross_profit < 0) {

            if ($bgcolor == "#E4E4E4") {

                $bgcolor = "#C5C5C5";

            } else {

                $bgcolor = "#E4E4E4";

            }

            echo '<tr><td bgcolor="' . $bgcolor . '">' . ++$srno;

            echo '</td><td bgcolor="' . $bgcolor . '"><a target="_blank" href="manage_box_b2bloop.php?id=' . $id . '&proc=Edit">' . $id . '</a>';

            echo '</td><td bgcolor="' . $bgcolor . '">' . $b2b_id;

            echo '</td><td bgcolor="' . $bgcolor . '">' . number_format($mingross_profit, 2);

            echo '</td></tr>';

        }

    }

}

?>

	</table>

	</div>

</div>

</body>

</html>