<?php

require "../mainfunctions/database.php";
require "../mainfunctions/general-functions.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Water Waste Contracted Clients - Organic Processors</title>
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
	<LINK rel='stylesheet' type='text/css' href='css/ucb_common_style.css'>
</head>

<body>
<? include("inc/header.php"); ?>
<div class="main_data_css">
	<div class="dashboard_heading" style="float: left;">
		<div style="float: left;">
			Water Waste Contracted Clients - Organic Processors
		<div class="tooltip"><i class="fa fa-info-circle" aria-hidden="true"></i>
		<span class="tooltiptext">This heat map shows the user contacted clients Organic Processors.</span></div>
		<div style="height: 13px;">&nbsp;</div>
		</div>
	</div>
	<?
		$sql_z = "Select comp_id_b2b From commodity_trans where commodity_trans.commodity_id = 16";
		db();
		$resultz = db_query($sql_z);
		while ($row_z = array_shift($resultz) ) {
			$commodity_trans_list .= $row_z["comp_id_b2b"] . ",";
		}
		if ($commodity_trans_list != ""){
			$commodity_trans_list = substr($commodity_trans_list, 0 , strlen($commodity_trans_list)-1);
		}

		//and companyInfo.haveNeed = 'Have Boxes'
		$sql_z = "Select companyInfo.ID, companyInfo.company, companyInfo.zip From
		companyInfo where zip <> '' and ID in ($commodity_trans_list) ";
		//echo $sql_z;
		db_b2b();
		$resultz = db_query($sql_z);
		$i = 1;
		while ( $row_z = array_shift($resultz) ) {
			$name = get_nickname_val($row_z["company"], $row_z["ID"]);

			$sloc = "";
			$ziparr = explode('-', $row_z["zip"]);
			$zip = $ziparr[0];
			db_b2b();
			$sqloc = db_query("Select * from ZipCodes where zip = '" .$zip . "'");
			if(empty($sqloc)){
				$zip = str_replace(" ", "", $zip);
				db_b2b();
				$sqloc = db_query("Select * from zipcodes_canada where zip = '" .$zip . "'");
			}

			$sloc = $sqloc[0]['latitude'];
			$slog = (($sqloc[0]['longitude']) + ($i * .0001));
			if(!empty($sloc)){

				$MGarray[] = array('cid' => $row_z["ID"], 'cname' => $name,  'vendor' => 0,
								   'zip' => $row_z["zip"], 'lat' => $sloc, 'log' => $slog );
			}
			$i++;
		}

		//AND water_vendors.b2bid > 0
		$water_qry = "SELECT  id, zipcode, Name FROM water_vendors WHERE `active_flg` = 1  and water_vendors.id in
		(Select water_vendor_id from water_vendor_materials_trans_data where zipcode <> ''
		and water_vendor_materials_id in ('59','60','61','62','63','64','65','66') ) order by name ";
		db();
		$water_res = db_query($water_qry);
		if(tep_db_num_rows($water_res)>0){

			While($row_z = array_shift($water_res)){

				$sloc = "";
				$ziparr = explode('-', $row_z["zipcode"]);
				$zip = $ziparr[0];
				db_b2b();
				$sqloc = db_query("Select * from ZipCodes where zip = '" .$zip . "'");
				if(empty($sqloc)){

					$zip = str_replace(" ", "", $zip);
					db_b2b();
					$sqloc = db_query("Select * from zipcodes_canada where zip = '" .$zip . "'");
				}

				$sloc = $sqloc[0]['latitude'];
				$slog = (($sqloc[0]['longitude']) + ($i * .0001));
				if(!empty($sloc)){
					$MGarray[] = array('cid' => $row_z["id"], 'cname' => $row_z["Name"], 'vendor' => 1,
									   'zip' => $row_z["zipcode"], 'lat' => $sloc, 'log' => $slog );
				}
				$i++;
			}
		}


	?>

	<div id="map" style="height: 800px; border:1px solid White;"></div>
	<script src="https://maps.google.com/maps/api/js?key=AIzaSyCvH4lAZv3iZOIataWfDx07DALo43kmjZU&sensor=false" type="text/javascript"></script>

	<script type="text/javascript">
    var locations = [

  <?

	$i = 1;
	foreach($MGarray as $mapdata){
		if ($mapdata["vendor"] == 1){
			echo "['<a href=water_vendor_master_new.php?id=" . $mapdata["cid"] . "&proc=View target=_blank>" . addslashes($mapdata["cname"]) . "(Vendor)</a><br>";
		}else{
			echo "['<a href=viewCompany.php?ID=" . $mapdata["cid"] . " target=_blank>" . addslashes($mapdata["cname"]) . "</a><br>";
		}

		echo "<br>Location Zip: " . $mapdata["zip"] . "<br>', ";
		echo $mapdata["lat"] . ", " . $mapdata["log"]  . ", " . $i . ", '  ";
		echo " ";
		if ($mapdata["vendor"] == 1){
			echo " https://maps.google.com/mapfiles/ms/icons/green-dot.png ";
		}else{
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
		<?
			foreach($MGarray as $row){
				echo "<tr><td class='text-align1'>" . $row["zip"] ." </td>";
				echo "<td class='text-align1'>" . $row["cname"] ." </td></tr>";
			}
		?>
		</table>
	</div>
</div>
</body>
</html>
