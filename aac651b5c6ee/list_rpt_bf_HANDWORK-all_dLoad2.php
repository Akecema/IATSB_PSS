<?php
session_start();
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

// Query to fetch all status records in one go
$status_query = "SELECT * FROM request_status WHERE status_id IN (1, 2, 3, 6, 7, 8, 14, 16, 21, 22, 23, 26, 27)";
$status_result = mysqli_query($dbc, $status_query);
$status_mapping = [];
while ($status = mysqli_fetch_array($status_result)) {
    $status_mapping[$status['status_id']] = $status['status_desc'];
}
//---------------------------------------------------------

// Retrieve parameters from GET request
$dateF = $_GET["date1"];
$dateT = $_GET["date2"];
$plant_code = $_GET["plant_code"];
$work_center = $_GET["work_center"];
$material_no = $_GET["material_no"];

// Format dates
$date1_final = date('Y-m-d', strtotime($dateF));
$date2_final = date('Y-m-d', strtotime($dateT));

// Construct WHERE conditions
$where_sql = "";
$where_sql .= empty($plant_code) || $plant_code == "NULL" ? "" : " AND p.plant_code = '".sql_esc($plant_code)."'";
$where_sql .= empty($dateF) || $dateF == "0000-00-00" ? "" : " AND p.date_posting >= '".sql_esc($date1_final)."'";
$where_sql .= empty($dateT) || $dateT == "0000-00-00" ? "" : " AND p.date_posting <= '".sql_esc($date2_final)."'";
$where_sql .= $work_center == "NULL" ? "" : " AND p.work_center = '".sql_esc($work_center)."'";
$where_sql .= $material_no == "NULL" ? "" : " AND p.material_no = '".sql_esc($material_no)."'";

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set up the general header
$sheet->setCellValue('A1', strtoupper($data_setup["title_desc"]));
$sheet->setCellValue('A2', 'DOCUMENT LIST - BACKFLUSH HANDWORK');
$sheet->setCellValue('A3', 'Date: ' . date('d-m-Y H:i:s'));

// Count the number of records
$query_count = "SELECT COUNT(*) FROM pps_detail_trn_fg_hwork p WHERE p.status_pps != '".sql_esc($status_mapping[6])."' AND p.status = 'Y' {$where_sql} ORDER BY bflush_no ASC";
$result_count = mysqli_query($dbc, $query_count);
$count_record = mysqli_fetch_row($result_count)[0];

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
    'NO.', 'MODEL', 'PART NO.', 'PART NAME', 'PLANNED ORDER NO.', 'PLANNED DATE',
    'BF DOC. NO.', 'POSTING DATE', 'POSTING TIME', 'GR DOC. NO.', 'PLANT',
    'LINE', 'SHIFT', 'LOCATION', 'QUANTITY', 'OUTPUT STATUS', 'CANCELLATION DOC. NO.',
    'CANCELLATION DATE', 'DISPOSAL DOC. NO.', 'APPROVED DISPOSAL DATE', 'CANCELLED BY'
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
$query_data = "WITH pre_aggregated_scan AS (
    SELECT 
        bflush_no_hwork, 
        GROUP_CONCAT(doc_gra SEPARATOR '\n') AS gr_docs
    FROM 
        scan_gr_trn_fg_hwork
    GROUP BY 
        bflush_no_hwork
)
SELECT 
    p.*, 
    DATE_FORMAT(p.date_plan, '%d-%m-%Y') AS T,
    DATE_FORMAT(p.date_posting, '%d-%m-%Y') AS R,
    DATE_FORMAT(p.date_cancel, '%d-%m-%Y') AS T7,
    s.gr_docs,
	u.user_fullname AS user_fullname_cancelled
FROM 
    pps_detail_trn_fg_hwork p
LEFT JOIN 
    pre_aggregated_scan s ON p.bflush_no = s.bflush_no_hwork
LEFT JOIN 
    user_detail u ON p.user_cancel = u.username
WHERE 
    p.status_pps != '".sql_esc($status_mapping[6])."' 
    AND p.status = 'Y' 
    {$where_sql}
GROUP BY 
    p.bflush_no
ORDER BY 
    p.bflush_no ASC";
$result_data = mysqli_query($dbc, $query_data);
// if (!$result_data) {
//     die('Query Failed: ' . mysqli_error($dbc)); // Log or display the error
// }
// die();
$row_num = 7; // Start from the row after the header
$counter = 1;
while ($row = mysqli_fetch_array($result_data)) {
    $col = 'A';
    $sheet->setCellValue($col . $row_num, $counter++);
    $sheet->setCellValue(++$col . $row_num, $row['model_code']);
    $sheet->setCellValue(++$col . $row_num, $row['material_no']);
    $sheet->setCellValue(++$col . $row_num, $row['material_desc']);
    $sheet->setCellValue(++$col . $row_num, $row['plan_no']);
    $sheet->setCellValue(++$col . $row_num, $row['T']);
    $sheet->setCellValueExplicit(++$col . $row_num, $row['bflush_no'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $sheet->setCellValue(++$col . $row_num, $row['R']);
    $sheet->setCellValue(++$col . $row_num, $row['time_posting']);
	$sheet->setCellValue(++$col . $row_num, $row['gr_docs']); // Concatenated GR Docs
    $sheet->getStyle($col . $row_num)->getAlignment()->setWrapText(true); // Ensure text wrapping for visibility
    $sheet->setCellValue(++$col . $row_num, $row['plant_code']);
    $sheet->setCellValue(++$col . $row_num, $row['work_center']);
	//-----shift-----
	   
	if($row["shift_posting"] == "D/S")
	{
		$shift_ds = "DAY";
	}elseif($row["shift_posting"] == "N/S")
	{
	  $shift_ds = "NIGHT";
	}else{
		
		$shift_ds = "NA"; 
	}
    $sheet->setCellValue(++$col . $row_num, $shift_ds);
    $sheet->setCellValue(++$col . $row_num, $row['ploc']);
    $sheet->setCellValue(++$col . $row_num, $row['qty_actual']);
    $sheet->setCellValue(++$col . $row_num, $row['status_pps']);
	$sheet->setCellValueExplicit(++$col . $row_num, $row['bflush_no_ref'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
	if($row["date_cancel"] != "0000-00-00 00:00:00") {	
		$sheet->setCellValue(++$col . $row_num, $row['T7']);
	} else { 
		$sheet->setCellValue(++$col . $row_num, '');
	}
    $sheet->setCellValue(++$col . $row_num, '');
    $sheet->setCellValue(++$col . $row_num, '');
    $sheet->setCellValue(++$col . $row_num, $row['user_cancel'] . ' ' . $row['user_fullname_cancelled']); // Display user name

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
header('Content-Disposition: attachment; filename="Backflush_HANDWORK_' . date('d-m-Y_H-i-s') . '.xlsx"');
header('Cache-Control: max-age=0');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();