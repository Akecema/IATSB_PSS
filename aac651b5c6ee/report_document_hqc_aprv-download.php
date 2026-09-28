<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

//CR status (Approved)
$sta3 = "SELECT * from request_status WHERE status_id = '3'";
$sta_res3 = mysqli_query($dbc,$sta3);
$rst_sta3 = mysqli_fetch_array($sta_res3);

//CR status (Cancelled)
$sta4 = "SELECT * from request_status WHERE status_id = '4'";
$sta_res4 = mysqli_query($dbc,$sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);

//CR status (Rejected)
$sta5 = "SELECT * from request_status WHERE status_id = '5'";
$sta_res5 = mysqli_query($dbc,$sta5);
$rst_sta5 = mysqli_fetch_array($sta_res5);

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc,$sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc,$sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);

//CR status (Pending Approval COO)
$sta25 = "SELECT * from request_status WHERE status_id = '25'";
$sta_res25 = mysqli_query($dbc,$sta25);
$rst_sta25 = mysqli_fetch_array($sta_res25);

//CR status (Pending Approval Exec QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

//---------------------------------------------------------



// Retrieve parameters from GET request
$dateF = $_GET["date1"];
$dateT = $_GET["date2"];
$plant_code = $_GET["plant_code"];
$work_center = $_GET["work_center"];

// Format dates
$date1_final = date('Y-m-d', strtotime($dateF));
$date2_final = date('Y-m-d', strtotime($dateT));
$date_tdy = date('d-m-Y H:i:s');

// Construct WHERE conditions
$where_sql = "";
$where_sql .= empty($plant_code) || $plant_code == "NULL" ? "" : " AND p.plant_cd = '".sql_esc($plant_code)."'";
$where_sql .= empty($dateF) || $dateF == "0000-00-00" ? "" : " AND p.date_disposal >= '".sql_esc($date1_final)."'";
$where_sql .= empty($dateT) || $dateT == "0000-00-00" ? "" : " AND p.date_disposal <= '".sql_esc($date2_final)."'";
$where_sql .= empty($work_center) || $work_center == "NULL" ? "" : " AND p.work_center = '".sql_esc($work_center)."'";

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set up the general header
$sheet->setCellValue('A1', strtoupper($data_setup["title_desc"]));
$sheet->setCellValue('A2', 'DOCUMENT LIST - DISPOSAL');
$sheet->setCellValue('A3', 'Date: ' . $date_tdy);


$query_count = "SELECT COUNT(*) AS total_count
FROM disposal_detail_prd_all p
WHERE (p.status_disposal = '".sql_esc($rst_sta3["status_desc"])."' OR p.status_disposal= '".sql_esc($rst_sta5["status_desc"])."' OR p.status_disposal= '".sql_esc($rst_sta10["status_desc"])."' OR p.status_disposal= '".sql_esc($rst_sta24["status_desc"])."' OR p.status_disposal= '".sql_esc($rst_sta25["status_desc"])."' OR p.status_disposal= '".sql_esc($rst_sta29["status_desc"])."')"
  .$where_sql;
$result8 = mysqli_query($dbc, $query_count) or die(mysqli_error($dbc));
$row8 = mysqli_fetch_assoc($result8);
$count_record = $row8['total_count'];
$sheet->setCellValue('A4', 'Record Count: ' . $count_record);

// Style the general header cells
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14); // Adjust the size as needed
$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

$sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

$sheet->getStyle('A3')->getFont()->setBold(true)->setSize(12);
$sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

$sheet->getStyle('A4')->getFont()->setBold(true)->setSize(12);
$sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

// Create table header
$headers = [
    'NO.', 'PLANT', 'PART NO.', 'PART NAME', 'MODEL', 'QUANTITY',
    'UOM', 'SECTION/LINE','STORAGE LOCATION', 
	'PROCESS OF REJECT', 'TYPE OF REJECT', 'DEFECTION OF REJECT', 'REASONS',
    'REMARK', 'POSTING DATE', 'SHIFT', 'DOCUMENT NO.','CANCELLATION DOCUMENT NO.', 'CANCELLATION DATE'
];



$col = 'A';
$colautosize = 'B';
foreach ($headers as $header) {
	$cell = $col . '6';
    $sheet->setCellValue($cell, $header);

    // Style the header row
    $sheet->getStyle($cell)->getFont()->setBold(true);
    $sheet->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    
    // Set the background color
    $sheet->getStyle($cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
    $sheet->getStyle($cell)->getFill()->getStartColor()->setRGB('E9F58D'); // Set the color to #E9F58D

	// Add borders to the header cell
	$sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    // Auto-adjust the column width
    $sheet->getColumnDimension($colautosize)->setAutoSize(true);
	$colautosize++;
    $col++;
}

$query_sql3 = "SELECT p.*, DATE_FORMAT(p.date_disposal,'%d-%m-%Y') as R3, DATE_FORMAT(p.date_cancel,'%d-%m-%Y') as R8  FROM disposal_detail_prd_all p
WHERE (p.status_disposal = '".sql_esc($rst_sta3["status_desc"])."' OR p.status_disposal= '".sql_esc($rst_sta5["status_desc"])."' OR p.status_disposal= '".sql_esc($rst_sta10["status_desc"])."' OR p.status_disposal= '".sql_esc($rst_sta24["status_desc"])."' OR p.status_disposal= '".sql_esc($rst_sta25["status_desc"])."' OR p.status_disposal= '".sql_esc($rst_sta29["status_desc"])."')" 
.$where_sql." ORDER BY p.date_posting DESC ";
$result_sql3 = mysqli_query($dbc,$query_sql3);

$row_num = 7; // Start from the row after the header
$counter = 1;


while ($row = mysqli_fetch_array($result_sql3)) {




	//-----process reject PRODUCTION -----------
	   
	if($row["status_part"] == "PR")
	{
	
		 //-----get proc detail----
	  
	  $query_sectA = "SELECT proc_desc FROM proc_reject_detail_prd WHERE id_proc =?";
	  $rst_sectA = $dbc->prepare($query_sectA); 
	  $rst_sectA->bind_param("s", $row["proc_reject"]);
	  $rst_sectA->execute();
	  $result1 = $rst_sectA->get_result(); // get the mysqli result
	  $data_sectA = $result1->fetch_assoc(); // fetch data   

	  
	  //----get type of reject -----
 
	  $query_type = "SELECT * FROM type_reject_detail_prd WHERE id_type =?";
	  $rst_type = $dbc->prepare($query_type); 
	  $rst_type->bind_param("s", $row["type_reject"]);
	  $rst_type->execute();
	  $result2 = $rst_type->get_result(); // get the mysqli result
	  $data_type = $result2->fetch_assoc(); // fetch data   

 
 
 //----get reason of reject ------
	  $query_reason = "SELECT defect_desc, id_reason FROM type_defect_detail_prd WHERE id_defect =?";
	  $rst_reason =  $dbc->prepare($query_reason); 
	  $rst_reason->bind_param("s", $row["type_defect"]);
	  $rst_reason->execute();
	  $result3 = $rst_reason->get_result(); // get the mysqli result
	  $data_reason = $result3->fetch_assoc(); // fetch data   
	 
	   
	   
	}


	//-----process reject ENGINEERING -----------
	   
	if($row["status_part"] == "ENG")
	{
	
		 //-----get proc detail----
	  
	  $query_sectA = "SELECT proc_desc FROM proc_reject_detail_prdeng WHERE id_proc =?";
	  $rst_sectA = $dbc->prepare($query_sectA); 
	  $rst_sectA->bind_param("s", $row["proc_reject"]);
	  $rst_sectA->execute();
	  $result1 = $rst_sectA->get_result(); // get the mysqli result
	  $data_sectA = $result1->fetch_assoc(); // fetch data   
	  
	  //----get type of reject -----
 
	  $query_type = "SELECT * FROM type_reject_detail_prdeng WHERE id_type =?";
	  $rst_type = $dbc->prepare($query_type); 
	  $rst_type->bind_param("s", $row["type_reject"]);
	  $rst_type->execute();
	  $result2 = $rst_type->get_result(); // get the mysqli result
	  $data_type = $result2->fetch_assoc(); // fetch data    
 
 
 //----get reason of reject ------
	  $query_reason = "SELECT defect_desc, id_reason FROM type_defect_detail_prdeng WHERE id_defect =?";
	  $rst_reason =  $dbc->prepare($query_reason); 
	  $rst_reason->bind_param("s", $row["type_defect"]);
	  $rst_reason->execute();
	  $result3 = $rst_reason->get_result(); // get the mysqli result
	  $data_reason = $result3->fetch_assoc(); // fetch data   
	     
	   
	}
	
	  //-----get ppc received detail----
	 if($row["status_part"] == "WS")
	{
	
		 //-----get proc detail----
	  
	  $query_sectA = "SELECT proc_desc FROM proc_reject_detail_ppc WHERE id_proc =?";
	  $rst_sectA = $dbc->prepare($query_sectA); 
	  $rst_sectA->bind_param("s", $row["proc_reject"]);
	  $rst_sectA->execute();
	  $result1 = $rst_sectA->get_result(); // get the mysqli result
	  $data_sectA = $result1->fetch_assoc(); // fetch data   

	  //----get type of reject -----
 
	  $query_type = "SELECT * FROM type_reject_detail_ppc WHERE id_type =?";
	  $rst_type = $dbc->prepare($query_type); 
	  $rst_type->bind_param("s", $row["type_reject"]);
	  $rst_type->execute();
	  $result2 = $rst_type->get_result(); // get the mysqli result
	  $data_type = $result2->fetch_assoc(); // fetch data   
 
 
 //----get reason of reject ------
	  $query_reason = "SELECT defect_desc, id_reason FROM type_defect_detail_ppc WHERE id_defect =?";
	  $rst_reason =  $dbc->prepare($query_reason); 
	  $rst_reason->bind_param("s", $row["type_defect"]);
	  $rst_reason->execute();
	  $result3 = $rst_reason->get_result(); // get the mysqli result
	  $data_reason = $result3->fetch_assoc(); // fetch data   
	   
	
	   
	}
	
	 //-----get ppc delivery detail----
	 if($row["status_part"] == "WQ")
	{
	
		 //-----get proc detail----
	  
	  $query_sectA = "SELECT proc_desc FROM proc_reject_detail_ppcdlv WHERE id_proc =?";
	  $rst_sectA = $dbc->prepare($query_sectA); 
	  $rst_sectA->bind_param("s", $row["proc_reject"]);
	  $rst_sectA->execute();
	  $result1 = $rst_sectA->get_result(); // get the mysqli result
	  $data_sectA = $result1->fetch_assoc(); // fetch data   

	  //----get type of reject -----
 
	  $query_type = "SELECT * FROM type_reject_detail_ppcdlv WHERE id_type =?";
	  $rst_type = $dbc->prepare($query_type); 
	  $rst_type->bind_param("s", $row["type_reject"]);
	  $rst_type->execute();
	  $result2 = $rst_type->get_result(); // get the mysqli result
	  $data_type = $result2->fetch_assoc(); // fetch data   
 
 
 //----get reason of reject ------
	  $query_reason = "SELECT defect_desc, id_reason FROM type_defect_detail_ppcdlv WHERE id_defect =?";
	  $rst_reason =  $dbc->prepare($query_reason); 
	  $rst_reason->bind_param("s", $row["type_defect"]);
	  $rst_reason->execute();
	  $result3 = $rst_reason->get_result(); // get the mysqli result
	  $data_reason = $result3->fetch_assoc(); // fetch data   
	   
	
	}
	
	//-----get ppc delivery detail----
	 if($row["status_part"] == "QC")
	{
	
	  //-----get proc detail----
	  
	  $query_sectA = "SELECT proc_desc FROM proc_reject_detail_qqc WHERE id_proc =?";
	  $rst_sectA = $dbc->prepare($query_sectA); 
	  $rst_sectA->bind_param("s", $row["proc_reject"]);
	  $rst_sectA->execute();
	  $result1 = $rst_sectA->get_result(); // get the mysqli result
	  $data_sectA = $result1->fetch_assoc(); // fetch data   
	  
	  //----get type of reject -----
 
	  $query_type = "SELECT * FROM type_reject_detail_qqc WHERE id_type =?";
	  $rst_type = $dbc->prepare($query_type); 
	  $rst_type->bind_param("s", $row["type_reject"]);
	  $rst_type->execute();
	  $result2 = $rst_type->get_result(); // get the mysqli result
	  $data_type = $result2->fetch_assoc(); // fetch data   
 
 
 //----get reason of reject ------
	  $query_reason = "SELECT defect_desc, id_reason FROM type_defect_detail_qqc WHERE id_defect =?";
	  $rst_reason =  $dbc->prepare($query_reason); 
	  $rst_reason->bind_param("s", $row["type_defect"]);
	  $rst_reason->execute();
	  $result3 = $rst_reason->get_result(); // get the mysqli result
	  $data_reason = $result3->fetch_assoc(); // fetch data   
	
	
	
	}

	//------- quantity	
	
	if($row["qty_NG"] != "0.000")
	{
		$qty_new = $row["qty_NG"];
		
	}elseif($row["qty_qc"] != "0.000")
	{
		$qty_new = $row["qty_qc"];
	}else{
		
		
	}



	$col = 'A';
	$shift_desc = ($row["shift_day"] == "D/S") ? "DAY" : (($row["shift_day"] == "N/S") ? "NIGHT" : "NA");
	$sheet->setCellValue($col . $row_num, $counter++);
    $sheet->setCellValue(++$col . $row_num, $row['plant_cd']);
    $sheet->setCellValue(++$col . $row_num, $row['material_no']);
	$sheet->setCellValueExplicit(++$col . $row_num, $row['material_desc'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $sheet->setCellValue(++$col . $row_num, $row['model_code']);
	$sheet->setCellValue(++$col . $row_num, intval($qty_new));
	$sheet->setCellValue(++$col . $row_num, strtoupper($row['UOM_unit']));
	$sheet->setCellValue(++$col . $row_num, $row['work_center']);
    $sheet->setCellValue(++$col . $row_num, $row['ploc_qc_reject']);
    $sheet->setCellValue(++$col . $row_num, $data_sectA["proc_desc"]);
	
	$sheet->setCellValue(++$col . $row_num, $data_type["type_desc"]);
    $sheet->setCellValue(++$col . $row_num, $data_reason["defect_desc"]);
	$sheet->setCellValue(++$col . $row_num, $data_reason["id_reason"]);
	$sheet->setCellValue(++$col . $row_num, $row['remarks']);
	$sheet->setCellValue(++$col . $row_num, $row['R3']);
	$sheet->setCellValue(++$col . $row_num, $shift_desc);

	$sheet->setCellValueExplicit(++$col . $row_num, $row['doc_dis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
	if($row["disposal_no_ref"] != "") {	
	$sheet->setCellValueExplicit(++$col . $row_num, $row['disposal_no_ref'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
	}else{
		$sheet->setCellValue(++$col . $row_num, '');	
	}
	if($row["date_cancel"] != "0000-00-00 00:00:00") {	
		$sheet->setCellValue(++$col . $row_num, $row['R8']);
	} else {
		$sheet->setCellValue(++$col . $row_num, '');
	}



	$row_num++;
}

$borderStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '000000'],
        ],
    ],
];

// Apply to header row
// $sheet->getStyle('A6:' . $colautosize . '6')->applyFromArray($borderStyle);

// Apply to data rows
$sheet->getStyle('A7:' . $col . ($row_num - 1))->applyFromArray($borderStyle);

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Document_List-Disposal_' . $date_tdy . '.xlsx"');
header('Cache-Control: max-age=0');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();


  ?>
