<?php 
require ("../mainfunctions/database.php");
require ("../mainfunctions/general-functions.php");
//require ("inc/header_session.php");



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
                if ($tmppos_1 !== false) {
                    $nickname = $row_comp["company"];
                } else {
                    if ($row_comp["shipCity"] <> "" || $row_comp["shipState"] <> "") {
                        $nickname = $row_comp["company"] . " - " . $row_comp["shipCity"] . ", " . $row_comp["shipState"];
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


if (isset($_REQUEST['btnRunReport'])) {
	//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
	$create_excel_flg = "yes";
	$sheet_cnt = 0;

	$fileName = "monthlyReportsLandfillDiversion_".date('Y-m-d_His').".xls";

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

	$client_sel_arr = $_REQUEST['client'];
	foreach ($client_sel_arr as $client_sel_arr_tmp)	
	{
		$client_id = $client_sel_arr_tmp;

	
		db();
		$qryRes6 = db_query("SELECT MONTHNAME(invoice_date) as monthnm, Year(invoice_date) as yearnm, invoice_date, weight_in_pound, 
		water_inventory.outlet,water_transaction.vendor_id FROM water_boxes_report_data INNER JOIN water_transaction ON water_transaction.id = 
		water_boxes_report_data.trans_rec_id INNER JOIN water_inventory ON water_boxes_report_data.box_id = water_inventory.ID 
		WHERE warehouse_id IN (". $client_id .") AND invoice_date between '" . $fromDate  . "' AND '" . $toDate . "' ");
		

		$newArrQryRes6LandFill = array(); 
		$sumonth = 0; 
		$newArrQryRes6Incineration = array(); $sumonth = 0;
		$newArrQryRes6WasteToEnergy = array(); $sumonth = 0;
		$newArrQryRes6Recycling = array(); $sumonth = 0;
		$newArrQryRes6Reuse = array(); $sumonth = 0;

		//echo "<br /><br /> =>> ".$fromDate." / ".$toDate."<br />";
		foreach ($qryRes6 as $qryRes6K => $qryRes6V){
			if($qryRes6V['invoice_date'] >= $fromDate && $qryRes6V['invoice_date'] <= $toDate && $qryRes6V['outlet'] == 'Landfill' ){
				$monthnm = $qryRes6V["monthnm"];
				$vendor_id = $qryRes6V["vendor_id"];
				$sumonth = $newArrQryRes6LandFill[$monthnm][$vendor_id]['weight'];
				$sumonth = $sumonth + $qryRes6V["weight_in_pound"];
				$newArrQryRes6LandFill[$monthnm][$vendor_id]['monthnm'] = $monthnm;
				$newArrQryRes6LandFill[$monthnm][$vendor_id]['yearnm'] = $qryRes6V['yearnm'];
				$newArrQryRes6LandFill[$monthnm][$vendor_id]['weight'] = $sumonth;
				$newArrQryRes6LandFill[$monthnm][$vendor_id]['vendor_id'] = $vendor_id;
			}		            
		//echo "<pre> newArrQryRes6LandFill -";print_r($newArrQryRes6LandFill) ; echo "</pre>";

		//echo "<br /><br /> =>> ".$st_date." / ".$end_date."<br />";
			if($qryRes6V['invoice_date'] >= $fromDate && $qryRes6V['invoice_date'] <= $toDate && $qryRes6V['outlet'] == 'Incineration (No Energy Recovery)' ){
				$monthnm = $qryRes6V["monthnm"];
				$vendor_id = $qryRes6V["vendor_id"];
				$sumonth = $newArrQryRes6Incineration[$monthnm][$vendor_id]['weight'];
				$sumonth = $sumonth + $qryRes6V["weight_in_pound"];
				$newArrQryRes6Incineration[$monthnm][$vendor_id]['monthnm'] = $monthnm;
				$newArrQryRes6Incineration[$monthnm][$vendor_id]['yearnm'] = $qryRes6V['yearnm'];
				$newArrQryRes6Incineration[$monthnm][$vendor_id]['weight'] = $sumonth;
				$newArrQryRes6Incineration[$monthnm][$vendor_id]['vendor_id'] = $vendor_id;
			}		            
		//echo "<pre> newArrQryRes6  Incineration & Treatment -";print_r($newArrQryRes6Incineration) ; echo "</pre>";
	//exit();

	//echo '<br />=====================================================';
	//echo '<br /> <br /> Waste to energy';

			if($qryRes6V['invoice_date'] >= $fromDate && $qryRes6V['invoice_date'] <= $toDate && $qryRes6V['outlet'] == 'Waste To Energy' ){
				$monthnm = $qryRes6V["monthnm"];
				$vendor_id = $qryRes6V["vendor_id"];
				$sumonth = $newArrQryRes6WasteToEnergy[$monthnm][$vendor_id]['weight'];
				$sumonth = $sumonth + $qryRes6V["weight_in_pound"];
				$newArrQryRes6WasteToEnergy[$monthnm][$vendor_id]['monthnm'] = $monthnm;
				$newArrQryRes6WasteToEnergy[$monthnm][$vendor_id]['yearnm'] = $qryRes6V['yearnm'];
				$newArrQryRes6WasteToEnergy[$monthnm][$vendor_id]['weight'] = $sumonth;
				$newArrQryRes6WasteToEnergy[$monthnm][$vendor_id]['vendor_id'] = $vendor_id;
			}		            
		//echo "<pre> newArrQryRes6 Waste to energy -";print_r($newArrQryRes6WasteToEnergy) ; echo "</pre>";

	//echo '<br />=====================================================';
	//echo '<br /> <br /> Recycling';

			if(($qryRes6V['invoice_date'] >= $fromDate && $qryRes6V['invoice_date'] <= $toDate) && $qryRes6V['outlet'] == 'Recycling' ){
				$monthnm = $qryRes6V["monthnm"];
				$vendor_id = $qryRes6V["vendor_id"];
				$sumonth = $newArrQryRes6Recycling[$monthnm][$vendor_id]['weight'];
				$sumonth = $sumonth + $qryRes6V["weight_in_pound"];
				$newArrQryRes6Recycling[$monthnm][$vendor_id]['monthnm'] = $monthnm;
				$newArrQryRes6Recycling[$monthnm][$vendor_id]['yearnm'] = $qryRes6V['yearnm'];
				$newArrQryRes6Recycling[$monthnm][$vendor_id]['weight'] = $sumonth;
				$newArrQryRes6Recycling[$monthnm][$vendor_id]['vendor_id'] = $vendor_id;
			}		            

		//echo '<br />=====================================================';
		//echo '<br /> <br /> Reuse';
			foreach ($qryRes6 as $qryRes6K => $qryRes6V){
				if(($qryRes6V['invoice_date'] >= $fromDate && $qryRes6V['invoice_date'] <= $toDate) && $qryRes6V['outlet'] == 'Reuse' ){
					$monthnm = $qryRes6V["monthnm"];
					$vendor_id = $qryRes6V["vendor_id"];
					$sumonth = $newArrQryRes6Reuse[$monthnm][$vendor_id]['weight'];
					$sumonth = $sumonth + $qryRes6V["weight_in_pound"];
					$newArrQryRes6Reuse[$monthnm][$vendor_id]['monthnm'] = $monthnm;
					$newArrQryRes6Reuse[$monthnm][$vendor_id]['yearnm'] = $qryRes6V['yearnm'];
					$newArrQryRes6Reuse[$monthnm][$vendor_id]['weight'] = $sumonth;
					$newArrQryRes6Reuse[$monthnm][$vendor_id]['vendor_id'] = $vendor_id;
				}		            
			}
			//echo "<pre> newArrQryRes6 Reuse -";print_r($newArrQryRes6Reuse) ; echo "</pre>";
		}
		//echo "<pre> newArrQryRes6 Recycling -";print_r($newArrQryRes6Recycling) ; echo "</pre>";	
		//exit();

		
	/*end*/

		$counter = 0;
		foreach ($period as $dt) {									    
			$counter = $counter + 2;
		}
		$colspan = $counter + 1;

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
		$object->getActiveSheet()->setCellValue('A1','Contracted Clients Monthly Reports Side to Side with Landfill Diversion Details');

		
		/*Get company details*/
		if ($client_id == "all") {
			$comp_nm_display = "All Clients";
		}else{
			db();
			$sql1 = db_query("SELECT id, company_name, b2bid FROM loop_warehouse WHERE id=".$client_id);
			$myrowsel1 = array_shift($sql1);
			$company_name = $myrowsel1["company_name"] . "'s";
			$main_company_name = getnickname_warehouse($company_name, $client_id);
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
		$excelColS_3 = 'A';	$excelColS_2_sec = "";
		$col = 0;
		foreach ($period as $dt) {
			$monthNum = intval($monthNum); // Convert $monthNum to an integer
			$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
			$yearNum = $dt->format("y");
			$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

			$col = $col+1;
			$excelCol_Weight = $excelColS_2_sec . chr(ord($excelColS_3) + $col );
			$object->getActiveSheet()->getStyle($excelCol_Weight.'3')->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			$object->getActiveSheet()->setCellValue($excelCol_Weight.'3', 'Total Diverted Weight (Tons)' );
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
			$excelCol_Finance = $excelColS_2_sec . chr(ord($excelColS_3) + ($col) );
			$object->getActiveSheet()->getStyle($excelCol_Finance.'3')->applyFromArray(array('font'=>array('bold'=>true),'borders'=>array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),'alignment'=>array('horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			$object->getActiveSheet()->setCellValue($excelCol_Finance.'3', 'Total Landfilled Weight (Tons)' );
		}

		if ($client_id == "all") {
			db();
			$getVendor = db_query("SELECT water_vendors.Name, water_vendors.id FROM water_boxes_report_data INNER JOIN water_transaction ON water_transaction.id = water_boxes_report_data.trans_rec_id INNER JOIN water_vendors ON water_transaction.vendor_id = water_vendors.id WHERE water_vendors.id <> 844 AND invoice_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "' GROUP BY water_vendors.Name, water_vendors.id ORDER BY water_vendors.Name");
		}else{
			db();
			$getVendor = db_query("SELECT water_vendors.Name, water_vendors.id FROM water_boxes_report_data INNER JOIN water_transaction ON water_transaction.id = water_boxes_report_data.trans_rec_id INNER JOIN water_vendors ON water_transaction.vendor_id = water_vendors.id WHERE water_vendors.id <> 844 AND warehouse_id = ".$client_id." AND invoice_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "' GROUP BY water_vendors.Name, water_vendors.id ORDER BY water_vendors.Name");
		}		
										
		$rt = 0;
		$excel_row = 4;
		while ($rowsVendor = array_shift($getVendor)) {

			$object->getActiveSheet()->getStyle('A'.$excel_row)->applyFromArray(array ( 'alignment' => array (  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,), 'borders' => array( 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN )  )  ) );
			$object->getActiveSheet()->setCellValue('A'.($excel_row), str_replace("&#39;","'", $rowsVendor['Name']) );
			$totalDivertedWeightSum = 0;  $totalLandfilledWeightSum = 0;

			$excelColS = 'A'; $excelColS_2_sec = '';	
			$col = 0;
			foreach ($period as $dt) {
				$monthNum = intval($dt->format("m"));
					$yearNum = $dt->format("Y");
				$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
				//echo "<br /> monthName - ".$monthName." / id - ".$rowsVendor['id'];
				$totalDivertedWeight = 0; $totalLandfilledWeight = 0;
						 
				//group of Reuse & Recycling & Waste to energy
				
				if($newArrQryRes6Reuse[$monthName][$rowsVendor['id']] != '' || $newArrQryRes6Recycling[$monthName][$rowsVendor['id']] != '' || $newArrQryRes6WasteToEnergy[$monthName][$rowsVendor['id']] != '' ){
					$totalDivertedWeightSum = $newArrQryRes6Reuse[$monthName][$rowsVendor['id']]['weight'] + $newArrQryRes6Recycling[$monthName][$rowsVendor['id']]['weight'] + $newArrQryRes6WasteToEnergy[$monthName][$rowsVendor['id']]['weight'];
					$totalDivertedWeight = $totalDivertedWeightSum / 2000;
				}
				//group of Incineration & LandFill
				if($newArrQryRes6Incineration[$monthName][$rowsVendor['id']] != '' || $newArrQryRes6LandFill[$monthName][$rowsVendor['id']] != '' ){
					$totalLandfilledWeightSum = $newArrQryRes6Incineration[$monthName][$rowsVendor['id']]['weight'] + $newArrQryRes6LandFill[$monthName][$rowsVendor['id']]['weight'];
					$totalLandfilledWeight = $totalLandfilledWeightSum / 2000;
				}

				$col = $col+1;
				$excelCol_Weight = $excelColS_2_sec . chr(ord($excelColS) + $col );
				$object->getActiveSheet()->getStyle($excelCol_Weight.$excel_row)->applyFromArray(array ( 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ),       'numberformat'=>array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00) ) );
				$object->getActiveSheet()->setCellValue($excelCol_Weight.($excel_row), number_format($totalDivertedWeight,2) );
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
				$excelCol_Finance = $excelColS_2_sec . chr(ord($excelColS) + ($col) );
				$object->getActiveSheet()->getStyle($excelCol_Finance.$excel_row)->applyFromArray(array ( 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ),       'numberformat'=>array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00) ) );
				$object->getActiveSheet()->setCellValue($excelCol_Finance.($excel_row), number_format($totalLandfilledWeight,2) );

				$arrGrandTotal[$yearNum . $monthName][$rt]['totalDivertedWeight'] = $totalDivertedWeight;
				$arrGrandTotal[$yearNum . $monthName][$rt]['totalLandfilledWeight'] = $totalLandfilledWeight;
				$rt++;
			}
			$excel_row++;
		}

		/*UsedCardboardBoxes start*/
			$object->getActiveSheet()->getStyle('A'.$excel_row)->applyFromArray(array ( 'alignment' => array (  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,), 'borders' => array( 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN), 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN )  )  ) );
			$object->getActiveSheet()->setCellValue('A'.($excel_row), str_replace("&#39;","'", 'UsedCardboardBoxes') );

			$finalArr1 = array();
			if ($client_id == "all") {
				$getUCBWeight = "SELECT sum(loop_boxes_sort.boxgood*loop_boxes.bweight) as sumweight, 
				sum(loop_boxes_sort.boxgood * loop_boxes_sort.sort_boxgoodvalue) as totamt, loop_transaction.pr_requestdate_php 
				FROM loop_boxes_sort INNER JOIN loop_transaction ON loop_transaction.id = loop_boxes_sort.trans_rec_id INNER JOIN loop_boxes ON loop_boxes.id = loop_boxes_sort.box_id WHERE loop_transaction.pr_requestdate_php BETWEEN '" . $fromDate ." 00:00:00' AND '" . $toDate . " 23:59:59' AND (loop_boxes.isbox LIKE 'N' OR loop_boxes.isbox LIKE 'Y') GROUP BY month(loop_transaction.pr_requestdate_php) ORDER BY loop_transaction.pr_requestdate_php ASC";
			}else{
				$getUCBWeight = "SELECT sum(loop_boxes_sort.boxgood*loop_boxes.bweight) as sumweight, 
				sum(loop_boxes_sort.boxgood * loop_boxes_sort.sort_boxgoodvalue) as totamt, loop_transaction.pr_requestdate_php 
				FROM loop_boxes_sort INNER JOIN loop_transaction ON loop_transaction.id = loop_boxes_sort.trans_rec_id INNER JOIN loop_boxes ON loop_boxes.id = loop_boxes_sort.box_id WHERE loop_transaction.warehouse_id = ".$client_id." AND  loop_transaction.pr_requestdate_php BETWEEN '" . $fromDate ." 00:00:00' AND '" . $toDate . " 23:59:59' AND (loop_boxes.isbox LIKE 'N' OR loop_boxes.isbox LIKE 'Y') GROUP BY month(loop_transaction.pr_requestdate_php) ORDER BY loop_transaction.pr_requestdate_php ASC";
			}			
			//echo "<br/>getUCBWeight -> ".$getUCBWeight;
			db();
			$resUCBWeight = db_query($getUCBWeight);
			//echo "<pre> resUCBWeight -"; print_r($resUCBWeight); echo "</pre>";
			$resUCBWeight1 = array();
			$sumweight_tot = $totamt_tot = 0; $pr_requestdate_php = "";
			while ($resUCBWeight_row = array_shift($resUCBWeight))
			{
				$sumweight_tot = $resUCBWeight_row["sumweight"];
				$totamt_tot =  $resUCBWeight_row["totamt"];
				$pr_requestdate_php = $resUCBWeight_row["pr_requestdate_php"];
			
				//echo "<pre> resUCBWeight1 -"; print_r($resUCBWeight1); echo "</pre>";

			//foreach ($resUCBWeight1 as $key => $resUCBWeight2) {
				$amt_tot = 0; $amt_tot1 = 0; $ucb_otherchgs_tot = 0; 
				$weightval = 0; $weightval_tot = 0;
				
				$weightval = $weightval + ($sumweight_tot/2000);
				$amt_tot = $amt_tot + $totamt_tot;
				$monthName = date("F",strtotime($pr_requestdate_php));
				
				$weightval_tot = $weightval_tot + $weightval;
				$finalArr1[$monthName]['monthName'] = $monthName;
				$finalArr1[$monthName]['weightval_tot'] = $weightval_tot;

				if ($client_id == "all") {
					$getUCBAmt = "SELECT distinct loop_transaction.id , loop_transaction.freightcharge AS freightcharge, loop_transaction.othercharge AS othercharge FROM loop_transaction INNER JOIN loop_boxes_sort ON loop_transaction.id = loop_boxes_sort.trans_rec_id WHERE loop_transaction.pr_requestdate_php BETWEEN '" . $fromDate ." 00:00:00' AND '" . $toDate . " 23:59:59' GROUP BY Month(loop_transaction.pr_requestdate_php)";
				}else{
					$getUCBAmt = "SELECT distinct loop_transaction.id , loop_transaction.freightcharge AS freightcharge, loop_transaction.othercharge AS othercharge FROM loop_transaction INNER JOIN loop_boxes_sort ON loop_transaction.id = loop_boxes_sort.trans_rec_id WHERE loop_transaction.warehouse_id = ".$client_id." AND loop_transaction.pr_requestdate_php BETWEEN '" . $fromDate ." 00:00:00' AND '" . $toDate . " 23:59:59' GROUP BY Month(loop_transaction.pr_requestdate_php)";
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

			$excelColUCB = 'A';	$excelColS_2_sec = "";
			$colUCB = 0;
			foreach ($period as $dt) {
				$monthNum = intval($dt->format("m"));
				$yearNum = $dt->format("Y");

				$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
				//echo "<br /> monthName - ".$monthName." / id - ".$rowsVendor['id'];
				$total_weight_tons = 0; $net_finamtial_impact = 0; 
				if($finalArr1[$monthName]['weightval_tot'] != ''){
					$total_weight_tons = $finalArr1[$monthName]['weightval_tot'];
				}else{
					$total_weight_tons = 0;
				}												   	

				$colUCB = $colUCB+1;
				$excelCol_Weight = $excelColS_2_sec . chr(ord($excelColUCB) + $colUCB );
				$object->getActiveSheet()->getStyle($excelCol_Weight.$excel_row)->applyFromArray(array ( 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ),       'numberformat'=>array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00) ) );
				$object->getActiveSheet()->setCellValue($excelCol_Weight.($excel_row), number_format($total_weight_tons,2) );
				if ($excelCol_Weight == "Z"){
					$colUCB = -1;
					$excelColS_2_sec = "A";
				}
				if ($excelCol_Weight == "AZ"){
					$colUCB = -1;
					$excelColS_2_sec = "B";
				}
				if ($excelCol_Weight == "BZ"){
					$colUCB = -1;
					$excelColS_2_sec = "C";
				}
				if ($excelCol_Weight == "CZ"){
					$colUCB = -1;
					$excelColS_2_sec = "D";
				}
				if ($excelCol_Weight == "DZ"){
					$colUCB = -1;
					$excelColS_2_sec = "E";
				}


				$colUCB = $colUCB+1;
				$excelCol_Finance = $excelColS_2_sec . chr(ord($excelColUCB) + ($colUCB) );
				$object->getActiveSheet()->getStyle($excelCol_Finance.$excel_row)->applyFromArray(array ( 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ),       'numberformat'=>array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00) ) );
				$object->getActiveSheet()->setCellValue($excelCol_Finance.($excel_row), 0 );

				$arrGrandTotal[$yearNum . $monthName][$rt]['totalDivertedWeight'] = $total_weight_tons;
				$arrGrandTotal[$yearNum . $monthName][$rt]['totalLandfilledWeight'] = 0;
				$rt++;
			}
			//echo "<pre> arrGrandTotal1 -"; print_r($arrGrandTotal1); echo "</pre>";
		/*UsedCardboardBoxes ends*/	

		/*TOTAL start*/
		$object->getActiveSheet()->getStyle('A'.($excel_row+1))->applyFromArray( array ( 'font' => array ( 'bold' => true ), 'fill' => array ( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array ( 'rgb' => 'A9A9A9' ) ), 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ) ) );
		$object->getActiveSheet()->setCellValue('A'.($excel_row+1), str_replace("&#39;","'", 'TOTAL') );

		$totalDivertedWeight = 0; $totalLandfilledWeight = 0;
		$excelColTotal = 'A'; $excelColS_2_sec = "";	
		$colTotal = 0;
		foreach ($period as $dt) {
			$monthNum = intval($dt->format("m"));
			$yearNum = $dt->format("Y");

			$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
			//echo "<br /> monthName - ".$monthName." / id - ".$rowsVendor['id'];
			 
			if($arrGrandTotal[$yearNum . $monthName] != ''){
				$arrTotal[$yearNum . $monthName]['totalDivertedWeight'] = array_sum(array_column($arrGrandTotal[$yearNum . $monthName], 'totalDivertedWeight'));
			}

			if($arrGrandTotal[$yearNum . $monthName] != ''){
				$arrTotal[$yearNum . $monthName]['totalLandfilledWeight'] = array_sum(array_column($arrGrandTotal[$yearNum . $monthName], 'totalLandfilledWeight'));
			}
			//echo "<pre> arrTotal -"; print_r($arrTotal); echo "</pre>";
			$totalDivertedWeight = $arrTotal[$yearNum . $monthName]['totalDivertedWeight'] + $arrGrandTotal1[$yearNum . $monthName]['totalDivertedWeight'];
			$totalLandfilledWeight = $arrTotal[$yearNum . $monthName]['totalLandfilledWeight'] + $arrGrandTotal1[$yearNum . $monthName]['totalLandfilledWeight'];


			$colTotal = $colTotal + 1;
			$excelCol_Weight = $excelColS_2_sec . chr(ord($excelColTotal) + $colTotal );
			$object->getActiveSheet()->getStyle($excelCol_Weight.($excel_row+1))->applyFromArray( array ( 'font' => array ( 'bold' => true ), 'fill' => array ( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array ( 'rgb' => 'A9A9A9' ) ), 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ) ) );
			$object->getActiveSheet()->setCellValue($excelCol_Weight.($excel_row+1), number_format($totalDivertedWeight,2) );
			if ($excelCol_Weight == "Z"){
				$colTotal = -1;
				$excelColS_2_sec = "A";
			}
			if ($excelCol_Weight == "AZ"){
				$colTotal = -1;
				$excelColS_2_sec = "B";
			}
			if ($excelCol_Weight == "BZ"){
				$colTotal = -1;
				$excelColS_2_sec = "C";
			}
			if ($excelCol_Weight == "CZ"){
				$colTotal = -1;
				$excelColS_2_sec = "D";
			}
			if ($excelCol_Weight == "DZ"){
				$colTotal = -1;
				$excelColS_2_sec = "E";
			}

			$colTotal = $colTotal + 1;
			$excelCol_Finance = $excelColS_2_sec . chr(ord($excelColTotal) + ($colTotal) );
			$object->getActiveSheet()->getStyle($excelCol_Finance.($excel_row+1))->applyFromArray( array ( 'font' => array ( 'bold' => true ), 'fill' => array ( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array ( 'rgb' => 'A9A9A9' ) ), 'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), 'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ) ) );
			$object->getActiveSheet()->setCellValue($excelCol_Finance.($excel_row+1), number_format($totalLandfilledWeight,2) );
		}
		/*TOTAL end*/

		//header info for browser
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/xls');    
		header('Content-Disposition: attachment; filename='.$fileName);  
		header('Pragma: no-cache'); 
		header('Expires: 0');

		//$object_writer->save('/home/usedcardboardbox/public_html/ucbloop/invoice_excel/' . $fileName);
	}
	
	$object_writer->save('php://output');
}
?>