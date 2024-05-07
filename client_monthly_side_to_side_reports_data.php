<?php
require ("../mainfunctions/database.php");
require ("../mainfunctions/general-functions.php");
//require ("inc/header_session.php");
ini_set("display_errors", "1");

error_reporting(E_ERROR);
// set_time_limit(0);	
// ini_set('memory_limit', '-1');
function getnickname_warehouse(string $warehouse_name, int $loopid): string {
	$nickname = "";
	if ($loopid > 0) {
		db_b2b();
		$sql = "SELECT nickname, company, shipCity, shipState FROM companyInfo where loopid = ?";
		$result_comp = db_query($sql , array("i"), array($loopid));
		while ($row_comp = array_shift($result_comp)) {
			if ($row_comp["nickname"] != "") {
				$nickname = $row_comp["nickname"];
			} else {
				$tmppos_1 = strpos($row_comp["company"], "-");
				if ($tmppos_1 != false) {
					$nickname = $row_comp["company"];
				} else {
					if ($row_comp["shipCity"] <> "" || $row_comp["shipState"] <> "" ) {
						$nickname = $row_comp["company"] . " - " . $row_comp["shipCity"] . ", " . $row_comp["shipState"] ;
					} else {
						$nickname = $row_comp["company"];
					}
				}
			}
		}
		db();
	} else {
		$nickname = $warehouse_name;
	}
	return $nickname;
}

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
//exit();

if (isset($_REQUEST['btnRunReport'])) {
	$client_id = ""; 
	$create_excel_flg = "yes";
	$sheet_cnt = 0;

	$fileName = "monthlyReports_".date('Y-m-d_His').".xls";

	//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

	$fromDate 	= $_REQUEST["ddYearFrom"]."-".$_REQUEST["ddMonthFrom"]."-01";
	$toSelected = $_REQUEST["ddYearTo"]."-".$_REQUEST["ddMonthTo"]."-01";
	$toDate 	= date("Y-m-t", strtotime($toSelected));

	$start    = new DateTime($fromDate);
	$start->modify('first day of this month');
	$end      = new DateTime($toDate);
	$end->modify('first day of next month');
	$interval = DateInterval::createFromDateString('1 month');
	$period   = new DatePeriod($start, $interval, $end);
	//echo "<pre>period - "; print_r($period); echo "</pre>";

	$parent_comp_flg = 0; $companyid = 0;
	/* Client asked to comment the All option
	if ($_REQUEST['client'] == "all"){
		$sql = "SELECT supplierdashboard_usermaster.companyid , supplierdashboard_usermaster.parent_comp_flg FROM loop_warehouse inner join supplierdashboard_usermaster on supplierdashboard_usermaster.companyid = loop_warehouse.b2bid";
	}else{
		$client_sel_arr = $_REQUEST['client'];

		foreach ($client_sel_arr as $client_sel_arr_tmp)	
		{
			$client_id = $client_id . $client_sel_arr_tmp . ",";
		}
		if (trim($client_id) != "") {
			$client_id= substr($client_id, 0, strlen($client_id)-1); 
		}
		
		$sql = "SELECT supplierdashboard_usermaster.companyid , supplierdashboard_usermaster.parent_comp_flg FROM loop_warehouse inner join supplierdashboard_usermaster on supplierdashboard_usermaster.companyid = loop_warehouse.b2bid
		WHERE id in (" . $client_id .")";
	}	*/

	$client_sel_arr = $_REQUEST['client'];

	foreach ($client_sel_arr as $client_sel_arr_tmp)	
	{
		$client_id = $client_sel_arr_tmp;
		
		$sql = "SELECT supplierdashboard_usermaster.companyid , supplierdashboard_usermaster.parent_comp_flg FROM loop_warehouse inner join supplierdashboard_usermaster on supplierdashboard_usermaster.companyid = loop_warehouse.b2bid
		WHERE id in (" . $client_id .")";
		db();
		$result_comp = db_query($sql);
		while ($row_comp = array_shift($result_comp)) {
			$parent_comp_flg = $row_comp["parent_comp_flg"];
			$companyid = $row_comp["companyid"]; 
		}
		
		if ($parent_comp_flg == 1){
			$child_comp_list = "";
			$sql = "SELECT  ID, loopid FROM companyInfo WHERE parent_comp_id = '". $companyid . "' and parent_child = 'Child'";
			//echo $sql;
			db_b2b();
			$result_comp = db_query($sql);
			while ($row_comp = array_shift($result_comp)) {
				$child_comp_list .= $row_comp["loopid"] . ",";
			}
			if (trim($child_comp_list) != ""){
				$child_comp_list = rtrim($child_comp_list, ",");
			}
		}
		
		if ($_REQUEST['client'] == "all"){
			db();
			$getVendor = db_query("SELECT water_vendors.Name, water_vendors.main_material, water_vendors.id FROM water_boxes_report_data INNER JOIN water_transaction ON water_transaction.id = water_boxes_report_data.trans_rec_id INNER JOIN water_vendors ON water_transaction.vendor_id = water_vendors.id 
			WHERE water_vendors.id <> 844 AND invoice_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "' GROUP BY water_vendors.Name, water_vendors.id ORDER BY water_vendors.Name");
		}else{
			db();
			$getVendor = db_query("SELECT water_vendors.Name, water_vendors.main_material, water_vendors.id FROM water_boxes_report_data INNER JOIN water_transaction ON water_transaction.id = water_boxes_report_data.trans_rec_id INNER JOIN water_vendors ON water_transaction.vendor_id = water_vendors.id 
			WHERE water_vendors.id <> 844 AND warehouse_id  in (" . $client_id .") AND invoice_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "' GROUP BY water_vendors.Name, water_vendors.id ORDER BY water_vendors.Name");
		}
		
		$i = 0; $newArr = array();
		foreach($getVendor as $getVendorK => $getVendorV){
			foreach ($period as $dt) {
				$monthNum = $dt->format("m");
				$yearNum = $dt->format("Y");
				$monthName = date("F", mktime(0, 0, 0, intval($monthNum), 10));
				
				//echo "<br /> ".$yearNum." / ".$monthNum;
				$startDate = $yearNum."-".$monthNum."-01";
				$endDateSel = $yearNum."-".$monthNum."-01";
				$endDate 	= date("Y-m-t", strtotime($endDateSel));
				//echo "<br /> ".$startDate." / ".$endDate;

				if ($_REQUEST['client'] == "all"){
					$getQry  = "SELECT water_transaction.invoice_date, sum(weight_in_pound) AS weightval, sum(avg_price_per_pound) AS valueeachval, sum(total_value) AS totalval, vendor_id, Month(water_transaction.invoice_date) AS monthNum FROM water_boxes_report_data INNER JOIN water_inventory ON water_boxes_report_data.box_id = water_inventory.ID INNER JOIN water_transaction ON water_boxes_report_data.trans_rec_id = water_transaction.id WHERE water_transaction.vendor_id = " . $getVendorV["id"] . " AND (invoice_date >= '" . $startDate . "' AND invoice_date <= '" . $endDate . " 23:59:59') GROUP BY water_transaction.vendor_id, Month(invoice_date)";
				}else{
					$getQry  = "SELECT water_transaction.invoice_date, sum(weight_in_pound) AS weightval, sum(avg_price_per_pound) AS valueeachval, sum(total_value) AS totalval, vendor_id, Month(water_transaction.invoice_date) AS monthNum FROM water_boxes_report_data INNER JOIN water_inventory ON water_boxes_report_data.box_id = water_inventory.ID INNER JOIN water_transaction ON water_boxes_report_data.trans_rec_id = water_transaction.id WHERE water_boxes_report_data.warehouse_id  in (" . $client_id .") AND water_transaction.vendor_id = " . $getVendorV["id"] . " AND (invoice_date >= '" . $startDate . "' AND invoice_date <= '" . $endDate . " 23:59:59') GROUP BY water_transaction.vendor_id, Month(invoice_date)";
				}				
				//echo "<br><br> getQry -> ".$getQry;
				db();
				$resQry = db_query($getQry);
				//echo "<pre> resQry -"; print_r($resQry); echo "</pre>";
				$rec_foundQry = "no";
				while($rowsQry = array_shift($resQry)){
					//echo "<br/><br/> 111 ".$rowsQry["monthNum"] ."==". $monthNum;
					$monthNum1 = $rowsQry['monthNum'];
					$rec_foundQry = "yes";
					$newArr[$monthNum][$i]['weightval'] = $rowsQry["weightval"];
					$newArr[$monthNum][$i]['invoice_date'] = $rowsQry['invoice_date'];	
				}

				if ($_REQUEST['client'] == "all"){
					$getQry2  = "SELECT invoice_date, total_value AS totalval, vendor_id, water_boxes_report_data.CostOrRevenuePerUnit, water_boxes_report_data.CostOrRevenuePerItem, water_boxes_report_data.CostOrRevenuePerPull , Month(invoice_date) AS monthNum  FROM water_boxes_report_data INNER JOIN water_inventory ON water_boxes_report_data.box_id = water_inventory.ID INNER JOIN water_transaction ON water_boxes_report_data.trans_rec_id = water_transaction.id WHERE water_transaction.vendor_id = " . $getVendorV["id"] . " AND (invoice_date >= '" . $startDate . "' AND invoice_date <= '" . $endDate . " 23:59:59') ";
				}else{
					$getQry2  = "SELECT invoice_date, total_value AS totalval, vendor_id, water_boxes_report_data.CostOrRevenuePerUnit, water_boxes_report_data.CostOrRevenuePerItem, water_boxes_report_data.CostOrRevenuePerPull , Month(invoice_date) AS monthNum  FROM water_boxes_report_data INNER JOIN water_inventory ON water_boxes_report_data.box_id = water_inventory.ID INNER JOIN water_transaction ON water_boxes_report_data.trans_rec_id = water_transaction.id WHERE warehouse_id  in (" . $client_id .") AND water_transaction.vendor_id = " . $getVendorV["id"] . " AND (invoice_date >= '" . $startDate . "' AND invoice_date <= '" . $endDate . " 23:59:59') ";
				}
				
				//echo "<br><br> getQry2 -> ".$getQry2;
				db();
				$resQry2 = db_query($getQry2);
				//echo "<pre> resQry2 -"; print_r($resQry2); echo "</pre>";
				$totalval_tot = 0; $rec_foundQry2 = 'no';
				while($rowsQry2 = array_shift($resQry2)) {
					//echo "<br/><br/> 222 ".$rowsQry2["monthNum"] ."==". $monthNum;
					//if($rowsQry2["monthNum"] == $monthNum ){
						$rec_foundQry2 = 'yes';								
						if ($rowsQry2["CostOrRevenuePerUnit"] == "Cost Per Unit" || $rowsQry2["CostOrRevenuePerItem"] == "Cost Per Item" || $rowsQry2["CostOrRevenuePerPull"] == "Cost Per Pull"){
							$totalval_tot = $totalval_tot - $rowsQry2["totalval"];
						}else{
							$totalval_tot = $totalval_tot + $rowsQry2["totalval"];
						}
						$newArr[$monthNum][$i]['totalval_tot'] = $totalval_tot;
					//}
				}

				if ($_REQUEST['client'] == "all"){
					$getQry3 = "SELECT water_transaction.invoice_date, water_vendors.Name AS Vendorname, water_trans_addfees.id AS addfeeid, water_trans_addfees.add_fees, water_trans_addfees.add_fees_occurance, Month(invoice_date) AS monthNum FROM water_transaction INNER JOIN water_vendors ON water_transaction.vendor_id = water_vendors.id INNER JOIN water_trans_addfees ON water_trans_addfees.trans_id = water_transaction.id WHERE water_vendors.id <> 844 AND water_transaction.vendor_id = " . $getVendorV["id"] . " AND (invoice_date >= '" . $startDate . "' AND invoice_date <= '" . $endDate . " 23:59:59')";
				}else{
					$getQry3 = "SELECT water_transaction.invoice_date, water_vendors.Name AS Vendorname, water_trans_addfees.id AS addfeeid, water_trans_addfees.add_fees, water_trans_addfees.add_fees_occurance, Month(invoice_date) AS monthNum FROM water_transaction INNER JOIN water_vendors ON water_transaction.vendor_id = water_vendors.id INNER JOIN water_trans_addfees ON water_trans_addfees.trans_id = water_transaction.id WHERE water_vendors.id <> 844 AND company_id  in (" . $client_id .") AND water_transaction.vendor_id = " . $getVendorV["id"] . " AND (invoice_date >= '" . $startDate . "' AND invoice_date <= '" . $endDate . " 23:59:59')";
				}				
				//echo "<br> getQry3 -> ".$getQry3;
				db();
				$resQry3 = db_query($getQry3);
				//echo "<pre> resQry3 -"; print_r($resQry3); echo "</pre>";
				$rec_foundQry3 = 'no'; $tot_add_fees = 0;
				while($rowQry3 = array_shift($resQry3)) {	
					//echo "<br/><br/> 333 ".$rowQry3["monthNum"] ."==". $monthNum;						
					//if($rowQry3["monthNum"] == $monthNum ){
						$rec_foundQry3 = 'yes';
						if ($rowQry3["add_fees_occurance"] > 0) {
							$tot_add_fees= $tot_add_fees + ($rowQry3["add_fees"] * $rowQry3["add_fees_occurance"]);	
						}else{
							$tot_add_fees = $tot_add_fees + ($rowQry3["add_fees"]);	
						}
						$newArr[$monthNum][$i]['tot_add_fees'] = $tot_add_fees;
					//}
				}
				if ($rec_foundQry == "no"){
					$newArr[$monthNum][$i]['weightval'] = 0;
					$newArr[$monthNum][$i]['invoice_date'] = "";
				}
				if ($rec_foundQry2 == "no"){
					$newArr[$monthNum][$i]['totalval_tot'] = 0;
				}
				if ($rec_foundQry3 == "no"){
					$newArr[$monthNum][$i]['tot_add_fees'] = 0;
				}
				$newArr[$monthNum][$i]['vendor_id'] = $getVendorV["id"];
				$i++;
			}
		}
		//echo "<pre> newArr -"; print_r($newArr); echo "</pre>";
		//exit();

		$finalArr = array();
		foreach ($newArr as $newArrK => $newArrV) { 
			foreach ($newArrV as $newArrVK => $newArr1) {

				$weightval = 0; $weight_tot = 0; $weightval_tot = 0; $totalval_tot = 0; 

				$weightval = $newArr1["weightval"]/2000;
				$weight_tot = $weight_tot + $weightval;
				/*Total Weight (Tons)*/
				$weightval_tot = $weightval_tot + $weightval;
				$totalval_tot = $newArr1["totalval_tot"] - $newArr1["tot_add_fees"];
				//$monthName = date("F",strtotime($newArr1["invoice_date"]));
				$monthName = date("F", mktime(0, 0, 0, $newArrK, 10));

				$finalArr[$monthName][$newArr1['vendor_id']]['total_weight_tons'] = $weightval_tot;
				$finalArr[$monthName][$newArr1['vendor_id']]['net_finamtial_impact'] = $totalval_tot;
				$finalArr[$monthName][$newArr1['vendor_id']]['monthNum'] = $newArrK;
				$finalArr[$monthName][$newArr1['vendor_id']]['monthName'] = $monthName;
			}
		}
		//echo "<pre> finalArr -"; print_r($finalArr); echo "</pre>";/**/
		//exit();

		$counter = 0;
		foreach ($period as $dt) {									    
			$counter = $counter + 2;
		}
		$colspan = $counter + 1;

		//For parent - child company records
		if ($parent_comp_flg == 1 && $child_comp_list != ""){
			$qry = "SELECT water_vendors.Name, water_vendors.main_material, water_vendors.id FROM water_boxes_report_data INNER JOIN water_transaction ON water_transaction.id = water_boxes_report_data.trans_rec_id INNER JOIN water_vendors ON water_transaction.vendor_id = water_vendors.id 
			WHERE water_vendors.id <> 844 AND warehouse_id in (". $child_comp_list .") AND invoice_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "' GROUP BY water_vendors.Name, water_vendors.id ORDER BY water_vendors.Name";
			//echo $qry . "<br>";
			db();
			$getVendor = db_query($qry);
			$i = 0; $newArr_child = array();
			foreach($getVendor as $getVendorK => $getVendorV){
				foreach ($period as $dt) {
					$monthNum = $dt->format("m");
					$yearNum = $dt->format("Y");
					$monthName = date("F", mktime(0, 0, 0, (int)$monthNum, 10));
					//echo "<br /> ".$yearNum." / ".$monthNum;
					$startDate = $yearNum."-".$monthNum."-01";
					$endDateSel = $yearNum."-".$monthNum."-01";
					$endDate 	= date("Y-m-t", strtotime($endDateSel));
					//echo "<br /> ".$startDate." / ".$endDate;

					$getQry  = "SELECT water_transaction.invoice_date, sum(weight_in_pound) AS weightval, sum(avg_price_per_pound) AS valueeachval, sum(total_value) AS totalval, vendor_id, Month(water_transaction.invoice_date) AS monthNum FROM water_boxes_report_data INNER JOIN water_inventory ON water_boxes_report_data.box_id = water_inventory.ID INNER JOIN water_transaction ON water_boxes_report_data.trans_rec_id = water_transaction.id WHERE water_boxes_report_data.warehouse_id in (". $child_comp_list .")  AND water_transaction.vendor_id = " . $getVendorV["id"] . " AND (invoice_date >= '" . $startDate . "' AND invoice_date <= '" . $endDate . " 23:59:59') GROUP BY water_transaction.vendor_id, Month(invoice_date)";
					//echo "<br><br> getQry -> ".$getQry;
					db();
					$resQry = db_query($getQry);
					//echo "<pre> resQry -"; print_r($resQry); echo "</pre>";
					$rec_foundQry = "no";
					while($rowsQry = array_shift($resQry)){
						//echo "<br/><br/> 111 ".$rowsQry["monthNum"] ."==". $monthNum;
						$monthNum1 = $rowsQry['monthNum'];
						$rec_foundQry = "yes";
						$newArr_child[$monthNum][$i]['weightval'] = $rowsQry["weightval"];
						$newArr_child[$monthNum][$i]['invoice_date'] = $rowsQry['invoice_date'];	
					}


					$getQry2  = "SELECT invoice_date, total_value AS totalval, vendor_id, water_boxes_report_data.CostOrRevenuePerUnit, water_boxes_report_data.CostOrRevenuePerItem, water_boxes_report_data.CostOrRevenuePerPull , Month(invoice_date) AS monthNum  FROM water_boxes_report_data INNER JOIN water_inventory ON water_boxes_report_data.box_id = water_inventory.ID INNER JOIN water_transaction ON water_boxes_report_data.trans_rec_id = water_transaction.id WHERE warehouse_id IN (" . $child_comp_list ." ) AND water_transaction.vendor_id = " . $getVendorV["id"] . " AND (invoice_date >= '" . $startDate . "' AND invoice_date <= '" . $endDate . " 23:59:59') ";
					//echo "<br><br> getQry2 -> ".$getQry2;
					db();
					$resQry2 = db_query($getQry2);
					//echo "<pre> resQry2 -"; print_r($resQry2); echo "</pre>";
					$totalval_tot = 0; $rec_foundQry2 = 'no';
					while($rowsQry2 = array_shift($resQry2)) {
						//echo "<br/><br/> 222 ".$rowsQry2["monthNum"] ."==". $monthNum;
						//if($rowsQry2["monthNum"] == $monthNum ){
							$rec_foundQry2 = 'yes';								
							if ($rowsQry2["CostOrRevenuePerUnit"] == "Cost Per Unit" || $rowsQry2["CostOrRevenuePerItem"] == "Cost Per Item" || $rowsQry2["CostOrRevenuePerPull"] == "Cost Per Pull"){
								$totalval_tot = $totalval_tot - $rowsQry2["totalval"];
							}else{
								$totalval_tot = $totalval_tot + $rowsQry2["totalval"];
							}
							$newArr_child[$monthNum][$i]['totalval_tot'] = $totalval_tot;
						//}
					}

					$getQry3 = "SELECT water_transaction.invoice_date, water_vendors.Name AS Vendorname, water_trans_addfees.id AS addfeeid, water_trans_addfees.add_fees, water_trans_addfees.add_fees_occurance, Month(invoice_date) AS monthNum FROM water_transaction INNER JOIN water_vendors ON water_transaction.vendor_id = water_vendors.id INNER JOIN water_trans_addfees ON water_trans_addfees.trans_id = water_transaction.id WHERE water_vendors.id <> 844 AND company_id IN (" . $child_comp_list .") AND water_transaction.vendor_id = " . $getVendorV["id"] . " AND (invoice_date >= '" . $startDate . "' AND invoice_date <= '" . $endDate . " 23:59:59')";
					//echo "<br> getQry3 -> ".$getQry3;
					db();
					$resQry3 = db_query($getQry3);
					//echo "<pre> resQry3 -"; print_r($resQry3); echo "</pre>";
					$rec_foundQry3 = 'no'; $tot_add_fees = 0;
					while($rowQry3 = array_shift($resQry3)) {	
						//echo "<br/><br/> 333 ".$rowQry3["monthNum"] ."==". $monthNum;						
						//if($rowQry3["monthNum"] == $monthNum ){
							$rec_foundQry3 = 'yes';
							if ($rowQry3["add_fees_occurance"] > 0) {
								$tot_add_fees= $tot_add_fees + ($rowQry3["add_fees"] * $rowQry3["add_fees_occurance"]);	
							}else{
								$tot_add_fees = $tot_add_fees + ($rowQry3["add_fees"]);	
							}
							$newArr_child[$monthNum][$i]['tot_add_fees'] = $tot_add_fees;
						//}
					}
					if ($rec_foundQry == "no"){
						$newArr_child[$monthNum][$i]['weightval'] = 0;
						$newArr_child[$monthNum][$i]['invoice_date'] = "";
					}
					if ($rec_foundQry2 == "no"){
						$newArr_child[$monthNum][$i]['totalval_tot'] = 0;
					}
					if ($rec_foundQry3 == "no"){
						$newArr_child[$monthNum][$i]['tot_add_fees'] = 0;
					}
					$newArr_child[$monthNum][$i]['vendor_id'] = $getVendorV["id"];
					$i++;
				}
			}

			$finalArr_child = array();
			foreach ($newArr_child as $newArrK => $newArrV) { 
				foreach ($newArrV as $newArrVK => $newArr1) {

					$weightval = 0; $weight_tot = 0; $weightval_tot = 0; $totalval_tot = 0; 

					$weightval = $newArr1["weightval"]/2000;
					$weight_tot = $weight_tot + $weightval;
					/*Total Weight (Tons)*/
					$weightval_tot = $weightval_tot + $weightval;
					$totalval_tot = $newArr1["totalval_tot"] - $newArr1["tot_add_fees"];
					//$monthName = date("F",strtotime($newArr1["invoice_date"]));
					$monthName = date("F", mktime(0, 0, 0, $newArrK, 10));

					$finalArr_child[$monthName][$newArr1['vendor_id']]['total_weight_tons'] = $weightval_tot;
					$finalArr_child[$monthName][$newArr1['vendor_id']]['net_finamtial_impact'] = $totalval_tot;
					$finalArr_child[$monthName][$newArr1['vendor_id']]['monthNum'] = $newArrK;
					$finalArr_child[$monthName][$newArr1['vendor_id']]['monthName'] = $monthName;
				}
			}
		}
		//For parent - child company records

		/*HERE START THE EXCEL DATA STORE AND DOWNLOAD*/

		if ($create_excel_flg == "yes") {
			require 'PHPExcel/Classes/PHPExcel.php'; 
			require 'PHPExcel/Classes/PHPExcel/IOFactory.php'; 
			$object = new PHPExcel();
			$object->setActiveSheetIndex(0);
			
			$create_excel_flg = "no";
		}else{
			$object->createSheet();    
			$sheet_cnt = $sheet_cnt + 1;
			$object->setActiveSheetIndex($sheet_cnt);
		}		

		/*SET WIDTH OF EACH CELL START*/
		$object->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$object->getActiveSheet()->getColumnDimension('B')->setWidth(18);
		$object->getActiveSheet()->getColumnDimension('C')->setWidth(18);
		$object->getActiveSheet()->getColumnDimension('D')->setWidth(18);
		$object->getActiveSheet()->getColumnDimension('E')->setWidth(18);
		$object->getActiveSheet()->getColumnDimension('F')->setWidth(18);
		$object->getActiveSheet()->getColumnDimension('G')->setWidth(18);
		$object->getActiveSheet()->getColumnDimension('H')->setWidth(18);
		$object->getActiveSheet()->getColumnDimension('I')->setWidth(18);
		$object->getActiveSheet()->getColumnDimension('J')->setWidth(18);
		$object->getActiveSheet()->getColumnDimension('K')->setWidth(18);
		$object->getActiveSheet()->getColumnDimension('L')->setWidth(18);
		$object->getActiveSheet()->getColumnDimension('M')->setWidth(18);
		$object->getActiveSheet()->getColumnDimension('N')->setWidth(18);
		/*SET WIDTH OF EACH CELL ENDS*/

		/*Set style as alignment center of all excel start*/
		$object->getDefaultStyle()
			->applyFromArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
					)
				)
			);
		/*Set style as alignment center of all excel end*/

		
		$excelColS_1 = 'A';
		$num = $counter;
		$excelColE_1 = chr(ord($excelColS_1) + $num );
		$object->getActiveSheet()->mergeCells('A1:'.$excelColE_1.'1');
		$object->getActiveSheet()->getStyle('A1:'.$excelColE_1.'1')->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
		$object->getActiveSheet()->setCellValue('A1','Contracted Clients Monthly Reports Side to Side');
		
		/*Get company details*/
		if ($_REQUEST['client'] == "all") {
			$comp_nm_display = "All clients";
		}else{
			db();
			$sql1 = db_query("SELECT id, company_name, b2bid FROM loop_warehouse WHERE id in (" . $client_id .")");
			$myrowsel1 = array_shift($sql1);
			$company_name = $myrowsel1["company_name"] . "'s";
			$main_company_name = getnickname_warehouse($company_name, $myrowsel1["id"]);
			if($main_company_name != ''){
				$comp_nm_display = $main_company_name;
			}else{
				$comp_nm_display = $company_name;
			}
		}	

		$object->getActiveSheet()->getStyle('A2')->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
		$object->getActiveSheet()->setCellValue('A2',$comp_nm_display);
		$excelColS_2 = 'A';	$excelColS_2_sec = "";
		$col = 0;
		foreach ($period as $dt) {
			$monthNum = $dt->format("m");
			$yearNum = $dt->format("y");
			$monthNum = intval($monthNum); // Convert $monthNum to an integer
			$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

			$col = $col+1;
			$excelCol_Weight = $excelColS_2_sec . chr(ord($excelColS_2) + $col );
			$object->getActiveSheet()->getStyle($excelCol_Weight.'2')->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			$object->getActiveSheet()->setCellValue($excelCol_Weight.'2', $monthName."-".$yearNum );
			if ($excelCol_Weight == "Z"){
				$col = -1;
				$excelColS_2_sec = "A";
			}
			if ($excelCol_Weight == "AZ"){
				$col = -1;
				$excelColS_2_sec = "B";
			}
			if ($excelCol_Weight == "BZ"){
				$col = -1;
				$excelColS_2_sec = "C";
			}
			if ($excelCol_Weight == "CZ"){
				$col = -1;
				$excelColS_2_sec = "D";
			}
			if ($excelCol_Weight == "DZ"){
				$col = -1;
				$excelColS_2_sec = "E";
			}

			$col = $col+1;
			$excelCol_Finance = $excelColS_2_sec . chr(ord($excelColS_2) + ($col) );
			$object->getActiveSheet()->getStyle($excelCol_Finance.'2')->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			$object->getActiveSheet()->setCellValue($excelCol_Finance.'2', $monthName."-".$yearNum );
		}

		$object->getActiveSheet()->getStyle('A3')->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
		$object->getActiveSheet()->setCellValue('A3','Vendors');
		$excelColS_3 = 'A';	$excelColS_3_sec = "";
		$col = 0;
		foreach ($period as $dt) {
			$monthNum = intval($dt->format("m")); // Convert $monthNum to an integer
			$yearNum = intval($dt->format("y")); // Convert $yearNum to an integer
			$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

			$col = $col+1;
			$excelCol_Weight = $excelColS_3_sec . chr(ord($excelColS_3) + $col );
			$object->getActiveSheet()->getStyle($excelCol_Weight.'3')->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			$object->getActiveSheet()->setCellValue($excelCol_Weight.'3', 'Total Weight (Tons)' );
			if ($excelCol_Weight == "Z"){
				$col = -1;
				$excelColS_3_sec = "A";
			}
			if ($excelCol_Weight == "AZ"){
				$col = -1;
				$excelColS_3_sec = "B";
			}
			if ($excelCol_Weight == "BZ"){
				$col = -1;
				$excelColS_3_sec = "C";
			}
			if ($excelCol_Weight == "CZ"){
				$col = -1;
				$excelColS_3_sec = "D";
			}
			if ($excelCol_Weight == "DZ"){
				$col = -1;
				$excelColS_3_sec = "E";
			}

			$col = $col+1;
			$excelCol_Finance = $excelColS_3_sec . chr(ord($excelColS_3) + ($col) );
			$object->getActiveSheet()->getStyle($excelCol_Finance.'3')->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			$object->getActiveSheet()->setCellValue($excelCol_Finance.'3', 'Net Financial Spend' );
		}


		if ($_REQUEST['client'] == "all") {
			db();
			$getVendor = db_query("SELECT water_vendors.Name, water_vendors.id FROM water_boxes_report_data INNER JOIN water_transaction ON water_transaction.id = water_boxes_report_data.trans_rec_id INNER JOIN water_vendors ON water_transaction.vendor_id = water_vendors.id WHERE water_vendors.id <> 844 AND invoice_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "' GROUP BY water_vendors.Name, water_vendors.id ORDER BY water_vendors.Name");
		}else{
			db();
			$getVendor = db_query("SELECT water_vendors.Name, water_vendors.id FROM water_boxes_report_data INNER JOIN water_transaction ON water_transaction.id = water_boxes_report_data.trans_rec_id INNER JOIN water_vendors ON water_transaction.vendor_id = water_vendors.id WHERE water_vendors.id <> 844 AND warehouse_id  in (" . $client_id .") AND invoice_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "' GROUP BY water_vendors.Name, water_vendors.id ORDER BY water_vendors.Name");
		}		

		$rt = 0;
		$excel_row = 4;
		while ($rowsVendor = array_shift($getVendor)) {

			$object->getActiveSheet()->getStyle('A'.$excel_row)->applyFromArray(array ( 'alignment' => array (  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,), 'borders' => array( 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN )  )  ) );
			$object->getActiveSheet()->setCellValue('A'.($excel_row), str_replace("&#39;","'", $rowsVendor['Name']) );
			$grand_total_weight_tons = $grand_net_finamtial_impact = 0;

			$excelColS = 'A'; $excelColS_sec = "";	
			$col = 0;
			foreach ($period as $dt) {
				$monthNum = intval($dt->format("m"));
				$yearNum = intval($dt->format("Y"));

				$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
				//echo "<br /> monthName - ".$monthName." / id - ".$rowsVendor['id'];
				$total_weight_tons = 0; $net_finamtial_impact = 0; 
				if($finalArr[$monthName][$rowsVendor['id']]['total_weight_tons'] != ''){
					$total_weight_tons = $finalArr[$monthName][$rowsVendor['id']]['total_weight_tons'];
				}else{
					$total_weight_tons = 0;
				}												   	

				if($finalArr[$monthName][$rowsVendor['id']]['net_finamtial_impact'] != ''){
					$net_finamtial_impact = $finalArr[$monthName][$rowsVendor['id']]['net_finamtial_impact'];
				}else{
					$net_finamtial_impact = 0;
				}

				$col = $col+1;
				$excelCol_Weight = $excelColS_sec . chr(ord($excelColS) + $col );
				$object->getActiveSheet()->getStyle($excelCol_Weight.$excel_row)->applyFromArray(array ( 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ),       'numberformat'=>array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00) ) );
				$object->getActiveSheet()->setCellValue($excelCol_Weight.($excel_row), number_format($total_weight_tons,2) );
				if ($excelCol_Weight == "Z"){
					$col = -1;
					$excelColS_sec = "A";
				}
				if ($excelCol_Weight == "AZ"){
					$col = -1;
					$excelColS_sec = "B";
				}
				if ($excelCol_Weight == "BZ"){
					$col = -1;
					$excelColS_sec = "C";
				}
				if ($excelCol_Weight == "CZ"){
					$col = -1;
					$excelColS_sec = "D";
				}
				if ($excelCol_Weight == "DZ"){
					$col = -1;
					$excelColS_sec = "E";
				}

				$col = $col+1;
				$excelCol_Finance = $excelColS_sec . chr(ord($excelColS) + ($col) );
				$object->getActiveSheet()->getStyle($excelCol_Finance.$excel_row)->applyFromArray(array ( 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ),       'numberformat'=>array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00) ) );
				$object->getActiveSheet()->setCellValue($excelCol_Finance.($excel_row), '$'.number_format($net_finamtial_impact,2) );

				$arrGrandTotal[$yearNum . $monthName][$rt]['total_weight_tons'] = $total_weight_tons;
				$arrGrandTotal[$yearNum . $monthName][$rt]['net_finamtial_impact'] = $net_finamtial_impact;
				$rt++;
			}
			$excel_row++;
		}

		/*UsedCardboardBoxes start*/
		$object->getActiveSheet()->getStyle('A'.$excel_row)->applyFromArray(array ( 'alignment' => array (  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,), 'borders' => array( 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN )  )  ) );
		$object->getActiveSheet()->setCellValue('A'.($excel_row), str_replace("&#39;","'", 'UsedCardboardBoxes') );

		$finalArr1 = array();
		//loop_boxes.bdescription,
		if ($_REQUEST['client'] == "all") {
			$getUCBWeight = "SELECT sum(loop_boxes_sort.boxgood*loop_boxes.bweight) as sumweight, sum(loop_boxes_sort.boxgood * loop_boxes_sort.sort_boxgoodvalue) as totamt, loop_transaction.pr_requestdate_php FROM loop_boxes_sort INNER JOIN loop_transaction ON loop_transaction.id = loop_boxes_sort.trans_rec_id INNER JOIN loop_boxes ON loop_boxes.id = loop_boxes_sort.box_id WHERE loop_transaction.pr_requestdate_php BETWEEN '" . $fromDate ." 00:00:00' AND '" . $toDate . " 23:59:59' AND (loop_boxes.isbox LIKE 'N' OR loop_boxes.isbox LIKE 'Y') 
			GROUP BY month(loop_transaction.pr_requestdate_php) ORDER BY loop_transaction.pr_requestdate_php ASC";
		}else{
			$getUCBWeight = "SELECT sum(loop_boxes_sort.boxgood*loop_boxes.bweight) as sumweight, sum(loop_boxes_sort.boxgood * loop_boxes_sort.sort_boxgoodvalue) as totamt, 
			loop_transaction.pr_requestdate_php FROM loop_boxes_sort INNER JOIN loop_transaction ON loop_transaction.id = loop_boxes_sort.trans_rec_id INNER JOIN loop_boxes ON loop_boxes.id = loop_boxes_sort.box_id 
			WHERE loop_transaction.warehouse_id  in (" . $client_id .") AND  loop_transaction.pr_requestdate_php BETWEEN '" . $fromDate ." 00:00:00' AND '" . $toDate . " 23:59:59' 
			AND (loop_boxes.isbox LIKE 'N' OR loop_boxes.isbox LIKE 'Y') 
			GROUP BY month(loop_transaction.pr_requestdate_php) ORDER BY loop_transaction.pr_requestdate_php ASC";
		}		
		//echo "<br/>getUCBWeight -> ".$getUCBWeight;
		db();
		$resUCBWeight = db_query($getUCBWeight);
		//echo "<pre> resUCBWeight -"; print_r($resUCBWeight); echo "</pre>";
		$resUCBWeight1 = array();
		$sumweight_tot = $totamt_tot = 0;
		$pr_requestdate_php = "";
		while ($resUCBWeight_row = array_shift($resUCBWeight))
		{
		//foreach ($resUCBWeight as $key => $value) {
			$sumweight_tot = $resUCBWeight_row["sumweight"];
			$totamt_tot = $resUCBWeight_row["totamt"];
			$pr_requestdate_php = $resUCBWeight_row["pr_requestdate_php"];
		
			//$resUCBWeight1[$value['pr_requestdate_php']][] = $value;
			//echo "<pre> resUCBWeight1 -"; print_r($resUCBWeight1); echo "</pre>";

		//foreach ($resUCBWeight1 as $key => $resUCBWeight2) {
			$amt_tot = 0; $amt_tot1 = 0; $ucb_otherchgs_tot = 0; 
			$weightval = 0; $weightval_tot = 0;
			/*foreach ($resUCBWeight2 as $key => $rowUCBWeight) {												
				$weightval = $weightval + ($rowUCBWeight["sumweight"]/2000);
				$amt_tot = $amt_tot + $rowUCBWeight["totamt"];
				$monthName = date("F",strtotime($rowUCBWeight["pr_requestdate_php"]));
			}*/
			
			$weightval = $weightval + ($sumweight_tot/2000);
			$amt_tot = $amt_tot + $totamt_tot;
			$monthName = date("F",strtotime($pr_requestdate_php));
			
			$weightval_tot = $weightval_tot + $weightval;
			$finalArr1[$monthName]['monthName'] = $monthName;
			$finalArr1[$monthName]['weightval_tot'] = $weightval_tot;

			if ($_REQUEST['client'] == "all") {
				$getUCBAmt = "SELECT distinct loop_transaction.id , loop_transaction.freightcharge AS freightcharge, loop_transaction.othercharge AS othercharge FROM loop_transaction INNER JOIN loop_boxes_sort ON loop_transaction.id = loop_boxes_sort.trans_rec_id WHERE loop_transaction.pr_requestdate_php BETWEEN '" . $fromDate ." 00:00:00' AND '" . $toDate . " 23:59:59' GROUP BY Month(loop_transaction.pr_requestdate_php)";
			}else{
				$getUCBAmt = "SELECT distinct loop_transaction.id , loop_transaction.freightcharge AS freightcharge, loop_transaction.othercharge AS othercharge FROM loop_transaction INNER JOIN loop_boxes_sort ON loop_transaction.id = loop_boxes_sort.trans_rec_id WHERE loop_transaction.warehouse_id  in (" . $client_id .") AND loop_transaction.pr_requestdate_php BETWEEN '" . $fromDate ." 00:00:00' AND '" . $toDate . " 23:59:59' GROUP BY Month(loop_transaction.pr_requestdate_php)";
			}			
			//echo "<br/> getUCBAmt -> ".$getUCBAmt;
			db();
			$resUCBAmt = db_query($getUCBAmt);
			//echo "<pre> resUCBAmt -"; print_r($resUCBAmt); echo "</pre>";
			while($rowUCBAmt = array_shift($resUCBAmt)) {
				$ucb_otherchgs_tot = $ucb_otherchgs_tot + $rowUCBAmt["freightcharge"];
				$ucb_otherchgs_tot = $ucb_otherchgs_tot + $rowUCBAmt["othercharge"];
			}
			$amt_tot1 = $amt_tot + $ucb_otherchgs_tot;
			$finalArr1[$monthName]['amt_tot'] = $amt_tot1;
		}
		//echo "<pre> finalArr1 -"; print_r($finalArr1); echo "</pre>";

		$excelColUCB = 'A';	 $excelColTotal_S = '';
		$colUCB = 0;
		foreach ($period as $dt) {
			$monthNum = intval($dt->format("m"));
			$yearNum = intval($dt->format("Y"));
			
			$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
			//echo "<br /> monthName - ".$monthName." / id - ".$rowsVendor['id'];
			$total_weight_tons = 0; $net_finamtial_impact = 0; 
			if($finalArr1[$monthName]['weightval_tot'] != ''){
				$total_weight_tons = $finalArr1[$monthName]['weightval_tot'];
			}else{
				$total_weight_tons = 0;
			}												   	

			if($finalArr1[$monthName]['amt_tot'] != ''){
				$net_finamtial_impact = $finalArr1[$monthName]['amt_tot'];
			}else{
				$net_finamtial_impact = 0;
			}


			$colUCB = $colUCB+1;
			$excelCol_Weight = $excelColTotal_S . chr(ord($excelColUCB) + $colUCB );
			$object->getActiveSheet()->getStyle($excelCol_Weight.$excel_row)->applyFromArray(array ( 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ),       'numberformat'=>array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00) ) );
			$object->getActiveSheet()->setCellValue($excelCol_Weight.($excel_row), number_format($total_weight_tons,2) );
			if ($excelCol_Weight == "Z"){
				$colUCB = -1;
				$excelColTotal_S = "A";
			}
			if ($excelCol_Weight == "AZ"){
				$colUCB = -1;
				$excelColTotal_S = "B";
			}
			if ($excelCol_Weight == "BZ"){
				$colUCB = -1;
				$excelColTotal_S = "C";
			}
			if ($excelCol_Weight == "CZ"){
				$colUCB = -1;
				$excelColTotal_S = "D";
			}
			if ($excelCol_Weight == "DZ"){
				$colUCB = -1;
				$excelColTotal_S = "E";
			}

			$colUCB = $colUCB+1;
			$excelCol_Finance = $excelColTotal_S . chr(ord($excelColUCB) + ($colUCB) );
			$object->getActiveSheet()->getStyle($excelCol_Finance.$excel_row)->applyFromArray(array ( 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ),       'numberformat'=>array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00) ) );
			$object->getActiveSheet()->setCellValue($excelCol_Finance.($excel_row), '$'.number_format($net_finamtial_impact,2) );

			$arrGrandTotal1[$yearNum . $monthName]['total_weight_tons'] = $total_weight_tons;
			$arrGrandTotal1[$yearNum . $monthName]['net_finamtial_impact'] = $net_finamtial_impact;
		}
		//echo "<pre> arrGrandTotal1 -"; print_r($arrGrandTotal1); echo "</pre>";
		/*UsedCardboardBoxes ends*/	

		/*TOTAL start*/
		$object->getActiveSheet()->getStyle('A'.($excel_row+1))->applyFromArray( array ( 'font' => array ( 'bold' => true ), 'fill' => array ( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array ( 'rgb' => 'A9A9A9' ) ), 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ) ) );
		$object->getActiveSheet()->setCellValue('A'.($excel_row+1), str_replace("&#39;","'", 'TOTAL') );

		$total_weight_tons = 0; $net_finamtial_impact = 0;
		$excelColTotal = 'A'; $excelColTotal_S = '';	
		$colTotal = 0;
		foreach ($period as $dt) {
			$monthNum = intval($dt->format("m"));
			$yearNum = intval($dt->format("Y"));
			
			$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
			//echo "<br /> monthName - ".$monthName." / id - ".$rowsVendor['id'];
			 
			if($arrGrandTotal[$yearNum . $monthName] != ''){
				$arrTotal[$yearNum . $monthName]['total_weight_tons'] = array_sum(array_column($arrGrandTotal[$yearNum . $monthName], 'total_weight_tons'));
			}

			if($arrGrandTotal[$yearNum . $monthName] != ''){
				$arrTotal[$yearNum . $monthName]['net_finamtial_impact'] = array_sum(array_column($arrGrandTotal[$yearNum . $monthName], 'net_finamtial_impact'));
			}
			//echo "<pre> arrTotal -"; print_r($arrTotal); echo "</pre>";
			$total_weight_tons = $arrTotal[$yearNum . $monthName]['total_weight_tons'] + $arrGrandTotal1[$yearNum . $monthName]['total_weight_tons'];
			$net_finamtial_impact = $arrTotal[$yearNum . $monthName]['net_finamtial_impact'] + $arrGrandTotal1[$yearNum . $monthName]['net_finamtial_impact'];

			$colTotal = $colTotal + 1;
			$excelCol_Weight = $excelColTotal_S . chr(ord($excelColTotal) + $colTotal );
			$object->getActiveSheet()->getStyle($excelCol_Weight.($excel_row+1))->applyFromArray( array ( 'font' => array ( 'bold' => true ), 'fill' => array ( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array ( 'rgb' => 'A9A9A9' ) ), 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ) ) );
			$object->getActiveSheet()->setCellValue($excelCol_Weight.($excel_row+1), number_format($total_weight_tons,2) );
			if ($excelCol_Weight == "Z"){
				$colTotal = -1;
				$excelColTotal_S = "A";
			}
			if ($excelCol_Weight == "AZ"){
				$colTotal = -1;
				$excelColTotal_S = "B";
			}
			if ($excelCol_Weight == "BZ"){
				$colTotal = -1;
				$excelColTotal_S = "C";
			}
			if ($excelCol_Weight == "CZ"){
				$colTotal = -1;
				$excelColTotal_S = "D";
			}
			if ($excelCol_Weight == "DZ"){
				$colTotal = -1;
				$excelColTotal_S = "E";
			}

			$colTotal = $colTotal + 1;
			$excelCol_Finance = $excelColTotal_S . chr(ord($excelColTotal) + ($colTotal) );
			$object->getActiveSheet()->getStyle($excelCol_Finance.($excel_row+1))->applyFromArray( array ( 'font' => array ( 'bold' => true ), 'fill' => array ( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array ( 'rgb' => 'A9A9A9' ) ), 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ) ) );
			$object->getActiveSheet()->setCellValue($excelCol_Finance.($excel_row+1), '$'.number_format($net_finamtial_impact,2) );
		}
		/*TOTAL end*/	

		//Parent Child Output
		if ($parent_comp_flg == 1 && $child_comp_list != ""){
			$excel_row = $excel_row + 3;
			$object->getActiveSheet()->getStyle('A' . $excel_row)->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			$object->getActiveSheet()->setCellValue('A' . $excel_row, "All Child company");
			$excelColS_2 = 'A';	 $excelColTotal_S = '';
			$col = 0;
			foreach ($period as $dt) {
				$monthNum = intval($dt->format("m"));
				$yearNum = intval($dt->format("Y"));
				$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

				$col = $col+1;
				$excelCol_Weight = $excelColTotal_S . chr(ord($excelColS_2) + $col );
				$object->getActiveSheet()->getStyle($excelCol_Weight.$excel_row)->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
				$object->getActiveSheet()->setCellValue($excelCol_Weight.$excel_row, $monthName."-".$yearNum );
				if ($excelCol_Weight == "Z"){
					$col = -1;
					$excelColTotal_S = "A";
				}
				if ($excelCol_Weight == "AZ"){
					$col = -1;
					$excelColTotal_S = "B";
				}
				if ($excelCol_Weight == "BZ"){
					$col = -1;
					$excelColTotal_S = "C";
				}
				if ($excelCol_Weight == "CZ"){
					$col = -1;
					$excelColTotal_S = "D";
				}
				if ($excelCol_Weight == "DZ"){
					$col = -1;
					$excelColTotal_S = "E";
				}

				$col = $col+1;
				$excelCol_Finance = $excelColTotal_S . chr(ord($excelColS_2) + ($col) );
				$object->getActiveSheet()->getStyle($excelCol_Finance.$excel_row)->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
				$object->getActiveSheet()->setCellValue($excelCol_Finance.$excel_row, $monthName."-".$yearNum );
			}

			$excel_row = $excel_row + 1;
			$object->getActiveSheet()->getStyle('A' . $excel_row)->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			$object->getActiveSheet()->setCellValue('A' . $excel_row,'Vendors');
			$excelColS_3 = 'A'; $excelColTotal_S = '';	
			$col = 0;
			
			foreach ($period as $dt) {
				$monthNum = intval($dt->format("m"));
				$yearNum = intval($dt->format("Y"));
				$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

				$col = $col+1;
				$excelCol_Weight = $excelColTotal_S . chr(ord($excelColS_3) + $col );
				$object->getActiveSheet()->getStyle($excelCol_Weight.$excel_row)->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
				$object->getActiveSheet()->setCellValue($excelCol_Weight.$excel_row, 'Total Weight (Tons)' );
				if ($excelCol_Weight == "Z"){
					$col = -1;
					$excelColTotal_S = "A";
				}
				if ($excelCol_Weight == "AZ"){
					$col = -1;
					$excelColTotal_S = "B";
				}
				if ($excelCol_Weight == "BZ"){
					$col = -1;
					$excelColTotal_S = "C";
				}
				if ($excelCol_Weight == "CZ"){
					$col = -1;
					$excelColTotal_S = "D";
				}
				if ($excelCol_Weight == "DZ"){
					$col = -1;
					$excelColTotal_S = "E";
				}
				
				$col = $col+1;
				$excelCol_Finance = $excelColTotal_S . chr(ord($excelColS_3) + ($col) );
				$object->getActiveSheet()->getStyle($excelCol_Finance.$excel_row)->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
				$object->getActiveSheet()->setCellValue($excelCol_Finance.$excel_row, 'Net Financial Spend' );
			}
			db();
			$getVendor = db_query("SELECT water_vendors.Name, water_vendors.id FROM water_boxes_report_data INNER JOIN water_transaction ON water_transaction.id = water_boxes_report_data.trans_rec_id INNER JOIN water_vendors ON water_transaction.vendor_id = water_vendors.id WHERE water_vendors.id <> 844 AND warehouse_id in ( ". $child_comp_list.") AND invoice_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "' GROUP BY water_vendors.Name, water_vendors.id ORDER BY water_vendors.Name");
			
			$excel_row = $excel_row + 1;
			$rt = 0;
			while ($rowsVendor = array_shift($getVendor)) {

				$object->getActiveSheet()->getStyle('A'.$excel_row)->applyFromArray(array ( 'alignment' => array (  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,), 'borders' => array( 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN )  )  ) );
				$object->getActiveSheet()->setCellValue('A'.($excel_row), str_replace("&#39;","'", $rowsVendor['Name']) );
				$grand_total_weight_tons = $grand_net_finamtial_impact = 0;

				$excelColS = 'A'; $excelColTotal_S = '';	
				$col = 0;
				foreach ($period as $dt) {
					$monthNum = intval($dt->format("m"));
					$yearNum = intval($dt->format("Y"));

					$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
					//echo "<br /> monthName - ".$monthName." / id - ".$rowsVendor['id'];
					$total_weight_tons = 0; $net_finamtial_impact = 0; 
					if($finalArr_child[$monthName][$rowsVendor['id']]['total_weight_tons'] != ''){
						$total_weight_tons = $finalArr_child[$monthName][$rowsVendor['id']]['total_weight_tons'];
					}else{
						$total_weight_tons = 0;
					}												   	

					if($finalArr_child[$monthName][$rowsVendor['id']]['net_finamtial_impact'] != ''){
						$net_finamtial_impact = $finalArr_child[$monthName][$rowsVendor['id']]['net_finamtial_impact'];
					}else{
						$net_finamtial_impact = 0;
					}

					$col = $col+1;
					$excelCol_Weight = $excelColTotal_S . chr(ord($excelColS) + $col );
					$object->getActiveSheet()->getStyle($excelCol_Weight.$excel_row)->applyFromArray(array ( 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ),       'numberformat'=>array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00) ) );
					$object->getActiveSheet()->setCellValue($excelCol_Weight.($excel_row), number_format($total_weight_tons,2) );
					if ($excelCol_Weight == "Z"){
						$col = -1;
						$excelColTotal_S = "A";
					}
					if ($excelCol_Weight == "AZ"){
						$col = -1;
						$excelColTotal_S = "B";
					}
					if ($excelCol_Weight == "BZ"){
						$col = -1;
						$excelColTotal_S = "C";
					}
					if ($excelCol_Weight == "CZ"){
						$col = -1;
						$excelColTotal_S = "D";
					}
					if ($excelCol_Weight == "DZ"){
						$col = -1;
						$excelColTotal_S = "E";
					}
					
					$col = $col+1;
					$excelCol_Finance = $excelColTotal_S . chr(ord($excelColS) + ($col) );
					$object->getActiveSheet()->getStyle($excelCol_Finance.$excel_row)->applyFromArray(array ( 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ),       'numberformat'=>array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00) ) );
					$object->getActiveSheet()->setCellValue($excelCol_Finance.($excel_row), '$'.number_format($net_finamtial_impact,2) );

					$arrGrandTotal[$yearNum . $monthName][$rt]['total_weight_tons'] = $total_weight_tons;
					$arrGrandTotal[$yearNum . $monthName][$rt]['net_finamtial_impact'] = $net_finamtial_impact;
					$rt++;
				}
				$excel_row++;
			}

			/*UsedCardboardBoxes start*/
			$object->getActiveSheet()->getStyle('A'.$excel_row)->applyFromArray(array ( 'alignment' => array (  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,), 'borders' => array( 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN )  )  ) );
			$object->getActiveSheet()->setCellValue('A'.($excel_row), str_replace("&#39;","'", 'UsedCardboardBoxes') );

			$finalArr1 = array();
			$getUCBWeight = "SELECT sum(loop_boxes_sort.boxgood*loop_boxes.bweight) as sumweight, sum(loop_boxes_sort.boxgood * loop_boxes_sort.sort_boxgoodvalue) as totamt, 
			loop_transaction.pr_requestdate_php FROM loop_boxes_sort INNER JOIN loop_transaction ON loop_transaction.id = loop_boxes_sort.trans_rec_id 
			INNER JOIN loop_boxes ON loop_boxes.id = loop_boxes_sort.box_id WHERE loop_transaction.warehouse_id in (". $child_comp_list .") AND  loop_transaction.pr_requestdate_php BETWEEN '" . $fromDate ." 00:00:00' AND '" . $toDate . " 23:59:59' 
			AND (loop_boxes.isbox LIKE 'N' OR loop_boxes.isbox LIKE 'Y') GROUP BY month(loop_transaction.pr_requestdate_php) ORDER BY loop_transaction.pr_requestdate_php ASC";
			
			//echo "<br/>getUCBWeight -> ".$getUCBWeight;
			db();
			$resUCBWeight = db_query($getUCBWeight);
			//echo "<pre> resUCBWeight -"; print_r($resUCBWeight); echo "</pre>";
			$resUCBWeight1 = array();
			$sumweight_tot = $totamt_tot = 0;
			$pr_requestdate_php = "";
			while ($resUCBWeight_row = array_shift($resUCBWeight))
			{
			//foreach ($resUCBWeight as $key => $value) {
				$sumweight_tot = $resUCBWeight_row["sumweight"];
				$totamt_tot =  $resUCBWeight_row["totamt"];
				$pr_requestdate_php = $resUCBWeight_row["pr_requestdate_php"];
			
			//$resUCBWeight1[$value['pr_requestdate_php']][] = $value;
			//echo "<pre> resUCBWeight1 -"; print_r($resUCBWeight1); echo "</pre>";

			//foreach ($resUCBWeight1 as $key => $resUCBWeight2) {
				$amt_tot = 0; $amt_tot1 = 0; $ucb_otherchgs_tot = 0; 
				$weightval = 0; $weightval_tot = 0;
				/*foreach ($resUCBWeight2 as $key => $rowUCBWeight) {												
					$weightval = $weightval + ($rowUCBWeight["sumweight"]/2000);
					$amt_tot = $amt_tot + $rowUCBWeight["totamt"];
					$monthName = date("F",strtotime($rowUCBWeight["pr_requestdate_php"]));
				}*/
				
				$weightval = $weightval + ($sumweight_tot/2000);
				$amt_tot = $amt_tot + $totamt_tot;
				$monthName = date("F",strtotime($pr_requestdate_php));
				
				$weightval_tot = $weightval_tot + $weightval;
				$finalArr1[$monthName]['monthName'] = $monthName;
				$finalArr1[$monthName]['weightval_tot'] = $weightval_tot;

				$getUCBAmt = "SELECT distinct loop_transaction.id , loop_transaction.freightcharge AS freightcharge, loop_transaction.othercharge AS othercharge FROM loop_transaction INNER JOIN loop_boxes_sort ON loop_transaction.id = loop_boxes_sort.trans_rec_id WHERE loop_transaction.warehouse_id in ( ". $child_comp_list. ") AND loop_transaction.pr_requestdate_php BETWEEN '" . $fromDate ." 00:00:00' AND '" . $toDate . " 23:59:59' GROUP BY Month(loop_transaction.pr_requestdate_php)";
				//echo "<br/> getUCBAmt -> ".$getUCBAmt;
				db();
				$resUCBAmt = db_query($getUCBAmt);
				//echo "<pre> resUCBAmt -"; print_r($resUCBAmt); echo "</pre>";
				while($rowUCBAmt = array_shift($resUCBAmt)) {
					$ucb_otherchgs_tot = $ucb_otherchgs_tot + $rowUCBAmt["freightcharge"];
					$ucb_otherchgs_tot = $ucb_otherchgs_tot + $rowUCBAmt["othercharge"];
				}
				$amt_tot1 = $amt_tot + $ucb_otherchgs_tot;
				$finalArr1[$monthName]['amt_tot'] = $amt_tot1;
			}
			//echo "<pre> finalArr1 -"; print_r($finalArr1); echo "</pre>";

			$excelColUCB = 'A';	$excelColTotal_S = '';
			$colUCB = 0;
			foreach ($period as $dt) {
				$monthNum = intval($dt->format("m"));
				$yearNum = intval($dt->format("Y"));

				$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
				//echo "<br /> monthName - ".$monthName." / id - ".$rowsVendor['id'];
				$total_weight_tons = 0; $net_finamtial_impact = 0; 
				if($finalArr1[$monthName]['weightval_tot'] != ''){
					$total_weight_tons = $finalArr1[$monthName]['weightval_tot'];
				}else{
					$total_weight_tons = 0;
				}												   	

				if($finalArr1[$monthName]['amt_tot'] != ''){
					$net_finamtial_impact = $finalArr1[$monthName]['amt_tot'];
				}else{
					$net_finamtial_impact = 0;
				}


				$colUCB = $colUCB+1;
				$excelCol_Weight =  $excelColTotal_S . chr(ord($excelColUCB) + $colUCB );
				$object->getActiveSheet()->getStyle($excelCol_Weight.$excel_row)->applyFromArray(array ( 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ),       'numberformat'=>array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00) ) );
				$object->getActiveSheet()->setCellValue($excelCol_Weight.($excel_row), number_format($total_weight_tons,2) );
				if ($excelCol_Weight == "Z"){
					$colUCB = -1;
					$excelColTotal_S = "A";
				}
				if ($excelCol_Weight == "AZ"){
					$colUCB = -1;
					$excelColTotal_S = "B";
				}
				if ($excelCol_Weight == "BZ"){
					$colUCB = -1;
					$excelColTotal_S = "C";
				}
				if ($excelCol_Weight == "CZ"){
					$colUCB = -1;
					$excelColTotal_S = "D";
				}
				if ($excelCol_Weight == "DZ"){
					$colUCB = -1;
					$excelColTotal_S = "E";
				}
				
				$colUCB = $colUCB+1;
				$excelCol_Finance =  $excelColTotal_S . chr(ord($excelColUCB) + ($colUCB) );
				$object->getActiveSheet()->getStyle($excelCol_Finance.$excel_row)->applyFromArray(array ( 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ),       'numberformat'=>array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00) ) );
				$object->getActiveSheet()->setCellValue($excelCol_Finance.($excel_row), '$'.number_format($net_finamtial_impact,2) );

				$arrGrandTotal1[$yearNum . $monthName]['total_weight_tons'] = $total_weight_tons;
				$arrGrandTotal1[$yearNum . $monthName]['net_finamtial_impact'] = $net_finamtial_impact;
			}
			//echo "<pre> arrGrandTotal1 -"; print_r($arrGrandTotal1); echo "</pre>";
			/*UsedCardboardBoxes ends*/	

			/*TOTAL start*/
			$object->getActiveSheet()->getStyle('A'.($excel_row+1))->applyFromArray( array ( 'font' => array ( 'bold' => true ), 'fill' => array ( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array ( 'rgb' => 'A9A9A9' ) ), 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ) ) );
			$object->getActiveSheet()->setCellValue('A'.($excel_row+1), str_replace("&#39;","'", 'TOTAL') );

			$total_weight_tons = 0; $net_finamtial_impact = 0;
			$excelColTotal = 'A'; $excelColTotal_S = '';	
			$colTotal = 0;
			foreach ($period as $dt) {
				$monthNum = (int)$dt->format("m");
				$yearNum = (int)$dt->format("Y");

				$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
				//echo "<br /> monthName - ".$monthName." / id - ".$rowsVendor['id'];
				 
				if($arrGrandTotal[$yearNum . $monthName] != ''){
					$arrTotal[$yearNum . $monthName]['total_weight_tons'] = array_sum(array_column($arrGrandTotal[$yearNum . $monthName], 'total_weight_tons'));
				}

				if($arrGrandTotal[$yearNum . $monthName] != ''){
					$arrTotal[$yearNum . $monthName]['net_finamtial_impact'] = array_sum(array_column($arrGrandTotal[$yearNum . $monthName], 'net_finamtial_impact'));
				}
				//echo "<pre> arrTotal -"; print_r($arrTotal); echo "</pre>";
				$total_weight_tons = $arrTotal[$yearNum . $monthName]['total_weight_tons'] + $arrGrandTotal1[$yearNum . $monthName]['total_weight_tons'];
				$net_finamtial_impact = $arrTotal[$yearNum . $monthName]['net_finamtial_impact'] + $arrGrandTotal1[$yearNum . $monthName]['net_finamtial_impact'];


				$colTotal = $colTotal + 1;
				$excelCol_Weight = $excelColTotal_S . chr(ord($excelColTotal) + $colTotal );
				$object->getActiveSheet()->getStyle($excelCol_Weight.($excel_row+1))->applyFromArray( array ( 'font' => array ( 'bold' => true ), 'fill' => array ( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array ( 'rgb' => 'A9A9A9' ) ), 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ) ) );
				$object->getActiveSheet()->setCellValue($excelCol_Weight.($excel_row+1), number_format($total_weight_tons,2) );
				if ($excelCol_Weight == "Z"){
					$colTotal = -1;
					$excelColTotal_S = "A";
				}
				if ($excelCol_Weight == "AZ"){
					$colTotal = -1;
					$excelColTotal_S = "B";
				}
				if ($excelCol_Weight == "BZ"){
					$colTotal = -1;
					$excelColTotal_S = "C";
				}
				if ($excelCol_Weight == "CZ"){
					$colTotal = -1;
					$excelColTotal_S = "D";
				}
				if ($excelCol_Weight == "DZ"){
					$colTotal = -1;
					$excelColTotal_S = "E";
				}

				$colTotal = $colTotal + 1;
				$excelCol_Finance = $excelColTotal_S . chr(ord($excelColTotal) + ($colTotal) );
				$object->getActiveSheet()->getStyle($excelCol_Finance.($excel_row+1))->applyFromArray( array ( 'font' => array ( 'bold' => true ), 'fill' => array ( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array ( 'rgb' => 'A9A9A9' ) ), 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ) ) );
				$object->getActiveSheet()->setCellValue($excelCol_Finance.($excel_row+1), '$'.number_format($net_finamtial_impact,2) );
			}
			/*TOTAL end*/	
		}
		//Parent Child Output
		
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');

		//header info for browser
		header('Content-Type: application/xls');    
		header('Content-Disposition: attachment; filename='.$fileName);  
		header('Pragma: no-cache'); 
		header('Expires: 0');
	}
	
	//$object_writer->save('/home/usedcardboardbox/public_html/ucbloop/invoice_excel/' . $fileName);

	$object_writer->save('php://output');

	

	?>
	
	<?php
}
?>