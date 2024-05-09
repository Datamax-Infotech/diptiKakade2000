<?php

require "../mainfunctions/database.php";
require "../mainfunctions/general-functions.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Water Waste Contracted Clients - Pallet Supplier</title>
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
	<LINK rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>
</head>

<body>
<?php include "inc/header.php";?>
<div class="main_data_css">
	<div class="dashboard_heading" style="float: left;">
		<div style="float: left;">
			Water Waste Contracted Clients - Pallet Supplier
		<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
		<span class="tooltiptext">This heat map shows the user contacted clients.</span></div>
		<div style="height: 13px;">&nbsp;</div>
		</div>
	</div>
	<?php
$sql_z = "Select ID, company, nickname, zip from companyInfo left join industry_master on industry_master.industry_id =  companyInfo.industry_id
		where zip <> '' and (company like '%Pallet%' or nickname like '%Pallet%' or industry_master.industry like '%Pallet%')";
db_b2b();
$resultz = db_query($sql_z);
$i = 1;
while ($row_z = array_shift($resultz)) {
    $name = get_nickname_val($row_z["company"], $row_z["ID"]);
    // Check in name, industry

    $ptxt = "Pallet";
    $addcomp1 = "";

    $warehouseid = "";
    $warehqry = "SELECT id from loop_warehouse where b2bid = " . $row_z["ID"];
    db();
    $warehres = db_query($warehqry);
    $warehrow = array_shift($warehres);
    $warehouseid = $warehrow["id"];
    if ($warehouseid != "") {
        $qry = "SELECT * FROM inventory where box_type in ('PalletsUCB','PalletsnonUCB') and b2b_status not in ('2.5', '2.6', '2.7')
				and vendor_b2b_rescue=" . $warehouseid . " order by ID";
        db_b2b();
        $res_arr = db_query($qry);

        if (tep_db_num_rows($res_arr) > 0) {
            $addcomp1 = "Yes";
        }
    }

    if ($addcomp1 == "Yes") {
        $ziparr = explode('-', $row_z["zip"]);
        $zip = $ziparr[0];
        db_b2b();
        $sqloc = db_query("Select * from ZipCodes where zip = '" . $zip . "'");
        if (empty($sqloc)) {
            $zip = str_replace(" ", "", $zip);
            db_b2b();
            $sqloc = db_query("Select * from zipcodes_canada where zip = '" . $zip . "'");
        }

        $sloc = $sqloc[0]['latitude'];
        $slog = (($sqloc[0]['longitude']) + ($i * .0001));
        if (!empty($sloc)) {
            $MGarray[] = array('cid' => $row_z["ID"], 'cname' => $name, 'vendor' => 0,
                'zip' => $row_z["zip"], 'lat' => $sloc, 'log' => $slog);
        }
        $i++;
    }
}

$water_qry = "SELECT id, zipcode, Name FROM water_vendors WHERE `active_flg` = 1 AND zipcode <> '' and water_vendors.id
		in (Select water_vendor_id from water_vendor_materials_trans_data where water_vendor_materials_id in ('50','51','52') ) order by Name ";
db();
$water_res = db_query($water_qry);
while ($row_z = array_shift($water_res)) {
    $ziparr = explode('-', $row_z["zipcode"]);
    $zip = $ziparr[0];
    db_b2b();
    $sqloc = db_query("Select * from ZipCodes where zip = '" . $zip . "'");
    if (empty($sqloc)) {
        $zip = str_replace(" ", "", $zip);
        db_b2b();
        $sqloc = db_query("Select * from zipcodes_canada where zip = '" . $zip . "'");
    }

    $sloc = $sqloc[0]['latitude'];
    $slog = (($sqloc[0]['longitude']) + ($i * .0001));
    if (!empty($sloc)) {
        $MGarray[] = array('cid' => $row_z["id"], 'cname' => $row_z["Name"], 'vendor' => 1,
            'zip' => $zip, 'lat' => $sloc, 'log' => $slog);
    }

    $i++;
}
?>

	<div id="map" style="height: 800px; border:1px solid White;"></div>
	<script src="https://maps.google.com/maps/api/js?key=AIzaSyCvH4lAZv3iZOIataWfDx07DALo43kmjZU&sensor=false" type="text/javascript"></script>

	<script type="text/javascript">
    var locations = [

  <?php

$i = 1;
foreach ($MGarray as $mapdata) {
    if ($mapdata["vendor"] == 1) {
        echo "['<a href=water_vendor_master_new.php?id=" . $mapdata["cid"] . "&proc=View target=_blank>" . addslashes($mapdata["cname"]) . "(Vendor)</a><br>";
    } else {
        echo "['<a href=viewCompany.php?ID=" . $mapdata["cid"] . " target=_blank>" . addslashes($mapdata["cname"]) . "</a><br>";
    }
    echo "<br>Location Zip: " . $mapdata["zip"] . "<br>', ";
    echo $mapdata["lat"] . ", " . $mapdata["log"] . ", " . $i . ", '  ";
    echo " ";
    if ($mapdata["vendor"] == 1) {
        echo " https://maps.google.com/mapfiles/ms/icons/green-dot.png ";
    } else {
        echo " https://maps.google.com/mapfiles/ms/icons/red-dot.png ";
    }
    echo " '";
    echo " ],";
    $i++;
}
?>


	];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 4,
      center: new google.maps.LatLng(39.695798, -91.40084),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
		icon: new google.maps.MarkerImage(locations[i][4]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
  </script>

	<style>
		#no-more-tables{
			float:left;
			width:25%;
			overflow-x:auto;
			margin-top: 20px;
			margin-bottom: 20px;
		}
		 #no-more-tables table {
			width: 96%;
			margin:0px auto;
			padding:0;
			border-spacing: 1;
			border-collapse:collapse;
		  }
		tr:nth-child(even) {
			background-color: #efefef;
		}
		tr:nth-child(odd) {
			background-color: #ffffff;
		}
		#no-more-tables table th{
			text-align: left;
			background-color:#c9c9c9;
			font-size:16px;
			color:#4a4a4a;
			line-height:22px;
			border-right: 1px solid #cfcfcf;
			font-weight:normal;
			padding: 11px 0px 11px 10px;
		  }
		#no-more-tables table th:last-of-type {
			border-right: none;
		  }
		#no-more-tables table td:last-of-type {
			border-right: none;
		  }
		  #no-more-tables table td {
			text-align: left;
			color:#4a4a4a;
			line-height:22px;
			font-size:16px;
			border-right: 1px solid #cfcfcf;
			padding: 8px 0px 8px 10px;
		}

		.text-align1 {
			text-align: center !important;
		}
	</style>
	<div id="no-more-tables">
		<table>
			<thead>
				<th>Zip Code</th>
				<th>Company Name</th>
			</thead>
		<?php
foreach ($MGarray as $row) {
    echo "<tr><td class='text-align1'>" . $row["zip"] . " </td>";
    echo "<td class='text-align1'>" . $row["cname"] . " </td></tr>";
}
?>
		</table>
	</div>
</div>
</body>
</html>