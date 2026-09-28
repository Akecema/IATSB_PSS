<?php
ini_set("display_errors", 1);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$date_tdy = date('d-m-Y H:i:s');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

$fmt_curr_date = (date("d-m-Y"));
$drun = substr($fmt_curr_date,0,2);
$mrun = substr($fmt_curr_date,3,2);
$yrun = substr($fmt_curr_date,8,2);

$date_run = ($drun.$mrun.$yrun);
//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);

$extension = explode('.', $data_setup["logo_name"]);
$filename = $data_setup["logo_comp"].'.'.$extension[1];
//----------------------------------------------------

$query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
$result2 = db_query($dbc, $query2) or die (mysqli_error());
$res = mysqli_fetch_array($result2);
    
//CR status (New)
$sta = "SELECT * from request_status WHERE status_id = '1'";
$sta_res = mysqli_query($dbc,$sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2'";
$sta_res2 = mysqli_query($dbc,$sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);


//CR status (Approved)
$sta3 = "SELECT * from request_status WHERE status_id = '3'";
$sta_res3 = mysqli_query($dbc,$sta3);
$rst_sta3 = mysqli_fetch_array($sta_res3);

//CR status (Cancelled)
$sta4 = "SELECT * from request_status WHERE status_id = '4'";
$sta_res4 = mysqli_query($dbc,$sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

//CR status (Pending)
$sta8 = "SELECT * from request_status WHERE status_id = '8'";
$sta_res8 = mysqli_query($dbc,$sta8);
$rst_sta8 = mysqli_fetch_array($sta_res8);

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc,$sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13'";
$sta_res13 = mysqli_query($dbc,$sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

//CR status (Cancel)
$sta21 = "SELECT * from request_status WHERE status_id = '21'";
$sta_res21 = mysqli_query($dbc,$sta21);
$rst_sta21 = mysqli_fetch_array($sta_res21);

//CR status (Close)
$sta22 = "SELECT * from request_status WHERE status_id = '22'";
$sta_res22 = mysqli_query($dbc,$sta22);
$rst_sta22 = mysqli_fetch_array($sta_res22);

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);

//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc,$sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

//CR status (Transfer Material)
$sta28 = "SELECT * from request_status WHERE status_id = '28'";
$sta_res28 = mysqli_query($dbc,$sta28);
$rst_sta28 = mysqli_fetch_array($sta_res28);

//CR status (Return)
$sta30 = "SELECT * from request_status WHERE status_id = '30'";
$sta_res30 = mysqli_query($dbc,$sta30);
$rst_sta30 = mysqli_fetch_array($sta_res30);

//CR status (Return Delivery)
$sta31 = "SELECT * from request_status WHERE status_id = '31'";
$sta_res31 = mysqli_query($dbc,$sta31);
$rst_sta31 = mysqli_fetch_array($sta_res31);

// =========================================
// FILTERS
// =========================================
$dateF       = $_GET["date1"];
$dateT       = $_GET["date2"];
$ship_to     = $_GET["ship_to"];
$do_no       = $_GET["do_no"];
$trans_type  = $_GET["trans_type"];
$material_no = $_GET["material_no"];
$model_code  = $_GET["model_code"];

$ddF = substr($dateF,0,2);
$mmF = substr($dateF,3,2);
$yyF = substr($dateF,6,4);
$date1_final = $yyF.'-'.$mmF.'-'.$ddF;

$ddF2 = substr($dateT,0,2);
$mmF2 = substr($dateT,3,2);
$yyF2 = substr($dateT,6,4);
$date2_final = $yyF2.'-'.$mmF2.'-'.$ddF2;

$wheresql_01 = ($do_no == "") ? "" : " AND material_doc_gen = '".sql_esc(sql_esc($do_no))."'";

//2. ship to party
if (($ship_to == "") || ($ship_to == "NULL")){ 
    $wheresql_02 = ""; }
else {
    $wheresql_02 = " AND ship_no = '".sql_esc($ship_to)."'"; }  	
        
    
// 3. dateF
if ($dateF == "0000-00-00" ){
    $wheresql_03 = ""; }
else {
    $wheresql_03 = " AND (DATE(dlv_date) >= '".sql_esc($date1_final)."')"; }      
                                
    
//4. DateT
if ($dateT == "0000-00-00" ){
    $wheresql_04 = ""; }
else {
    $wheresql_04 = " AND (DATE(dlv_date) <= '".sql_esc($date2_final)."')"; }

$wheresql_05 = ($material_no == "NULL")
    ? ""
    : " AND material_no = '".sql_esc(sql_esc($material_no))."'";

$wheresql_06 = ($model_code == "NULL")
    ? ""
    : " AND matl_group >= '".sql_esc(sql_esc($model_code))."'";

if (($trans_type == "NORMAL") || ($trans_type == "NULL")) {
    $wheresql_08 = "";
} elseif ($trans_type == "CANCEL") {
    $wheresql_08 = " AND status_DO = '".sql_esc($rst_sta3['status_desc'])."'";
} else {
    $wheresql_08 = "";
}

$where_sql =
$wheresql_01 .
$wheresql_02 .
$wheresql_03 .
$wheresql_04 .
$wheresql_05 .
$wheresql_06 .
$wheresql_08;

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// =========================================
// REPORT HEADER
// =========================================

$query8 = "
SELECT *
FROM dlv_ord_all_delivery
WHERE material_doc_gen != ''
AND status_DO != '".sql_esc($rst_sta31["status_desc"])."'
$where_sql
";

$result8 = mysqli_query($dbc,$query8);
$num_rows = mysqli_num_rows($result8);

$query8a = "
SELECT *
FROM dlv_ord_all_delivery_canc
WHERE material_doc_gen != ''
$where_sql
";

$result8a = mysqli_query($dbc,$query8a);
$num_rows_8a = mysqli_num_rows($result8a);

$count_record = $num_rows + $num_rows_8a;

$sheet->setCellValue('A1', strtoupper($data_setup["title_desc"]));
$sheet->setCellValue('A2', 'DOCUMENT LIST - DELIVERY ORDER REPORT');
$sheet->setCellValue('A4', 'Date : '.$date_tdy);
$sheet->setCellValue('E4', 'Record Count : '.$count_record);
$sheet->getStyle('A1')->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 12
    ]
]);

$sheet->getStyle('A2')->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 12
    ]
]);
// =========================================
// COLUMN HEADER
// =========================================

$headers = [
    'NO.',
    'SO NO.',
    'DO NUMBER',
    'DELIVERY DATE',
    'PART NUMBER',
    'PART NUMBER SAP',
    'PART DESCRIPTION',
    'DI/PDIO NO.',
    'MATERIAL TYPE',
    'MODEL',
    'DELIVERY QUANTITY',
    'UOM',
    'SOLD TO PARTY',
    'SHIP TO PARTY',
    'TRANSFER TYPE',
    'TRANSFER DATE',
    'SHIFT',
    'TRIP NO.',
    'TAG NO.',
    'DOC. STATUS',
    'CANCELLATION DOC. NO.',
    'CANCELLATION DATE'
];

$row = 6;
$col = 'A';

foreach ($headers as $header) {
    $sheet->setCellValue($col.$row, $header);
    $col++;
}

$lastColumn = 'V'; // 22 columns

$sheet->getStyle('A6:V6')->applyFromArray([
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER,
        'wrapText'   => true
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'E9F58D'
        ]
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN
        ]
    ]
]);

$sheet->getRowDimension(6)->setRowHeight(35);
$sheet->mergeCells('A1:V1');
$sheet->mergeCells('A2:V2');

$sheet->getStyle('A1:V2')->getAlignment()->setHorizontal(
    Alignment::HORIZONTAL_LEFT
);

$row++;

// =========================================
// NORMAL DELIVERY
// =========================================

$query_sql3 = "
SELECT *,
DATE_FORMAT(posting_date,'%d-%m-%Y') as R,
DATE_FORMAT(dlv_date,'%d-%m-%Y') as R7
FROM dlv_ord_all_delivery
WHERE material_doc_gen != ''
AND status_DO != '".sql_esc($rst_sta4["status_desc"])."'
AND status_DO != '".sql_esc($rst_sta31["status_desc"])."'
$where_sql
ORDER BY material_doc_gen ASC
";

$result_sql3 = mysqli_query($dbc,$query_sql3);

$no = 1;

while ($data_sql3 = mysqli_fetch_array($result_sql3))
{
    $sta_atas = ($data_sql3["doc_no_return"] != "")
        ? "Return"
        : "Normal";

    $query_mat_info = "
    SELECT *
    FROM table_material_itsb
    WHERE material_no = '".sql_esc($data_sql3["material_no_sap"])."'
    AND status_BOM = 'Y'
    ";

    $result_mat_info = mysqli_query($dbc,$query_mat_info);
    $data_mat_info = mysqli_fetch_array($result_mat_info);

    $query_mat_infoA = "
    SELECT *
    FROM model_detail_tbl
    WHERE id_model = '".sql_esc($data_mat_info["model_code"])."'
    AND status_model = 'Y'
    ";

    $result_mat_infoA = mysqli_query($dbc,$query_mat_infoA);
    $data_mat_infoA = mysqli_fetch_array($result_mat_infoA);

    $sheet->fromArray([
        $no,
        $data_sql3["so_no"],
        $data_sql3["material_doc_gen"],
        $data_sql3["R7"],
        $data_sql3["material_no"],
        $data_sql3["material_no_sap"],
        $data_sql3["material_desc"],
        $data_sql3["pdio_no"],
        $data_sql3["matl_group"],
        $data_mat_infoA["model_code"],
        intval($data_sql3["qty_dlv"]),
        strtoupper($data_sql3["unit_soi"]),
        $data_sql3["vendor_name"],
        $data_sql3["ship_point"],
        $data_sql3["status_DO"],
        $data_sql3["R"],
        $data_sql3["cycle_no"],
        $data_sql3["trip_no"],
        $data_sql3["tag_no"],
        $sta_atas,
        $data_sql3["ref_material_doc"],
        ''
    ], NULL, 'A'.$row);

    $sheet->setCellValueExplicit(
        'C'.$row,
        $data_sql3["material_doc_gen"],
        DataType::TYPE_STRING
    );

    $row++;
    $no++;
}

// =========================================
// CANCELLED DELIVERY
// =========================================

$query_sql3A = "
SELECT *,
DATE_FORMAT(posting_date,'%d-%m-%Y') as R,
DATE_FORMAT(dlv_date,'%d-%m-%Y') as R7,
DATE_FORMAT(date_cancel,'%d-%m-%Y') as R9
FROM dlv_ord_all_delivery_canc
WHERE material_doc_gen != ''
$where_sql
ORDER BY material_doc_gen ASC
";

$result_sql3A = mysqli_query($dbc,$query_sql3A);

while ($data_sql3A = mysqli_fetch_array($result_sql3A))
{
    $sta_bwh = ($data_sql3A["ref_material_doc"] != "")
        ? "Cancel"
        : "";

    $sheet->fromArray([
        $no,
        $data_sql3A["so_no"],
        $data_sql3A["material_doc_gen"],
        $data_sql3A["R7"],
        $data_sql3A["material_no"],
        '',
        $data_sql3A["material_desc"],
        $data_sql3A["pdio_no"],
        $data_sql3A["matl_group"],
        '',
        intval($data_sql3A["qty_dlv"]),
        strtoupper($data_sql3A["unit_soi"]),
        $data_sql3A["vendor_name"],
        $data_sql3A["ship_point"],
        $data_sql3A["status_DO"],
        $data_sql3A["R"],
        '',
        '',
        '',
        $sta_bwh,
        $data_sql3A["ref_material_doc"],
        $data_sql3A["R9"]
    ], NULL, 'A'.$row);

    $sheet->setCellValueExplicit(
        'C'.$row,
        $data_sql3A["material_doc_gen"],
        DataType::TYPE_STRING
    );
    $sheet->setCellValueExplicit(
        'U'.$row,
        $data_sql3A["ref_material_doc"],
        DataType::TYPE_STRING
    );

    $row++;
    $no++;
}

foreach (range('B', 'V') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

$lastRow = $row - 1;

$sheet->getStyle('A6:V'.$lastRow)->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN
        ]
    ]
]);
$sheet->freezePane('A7');

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Delivery Order '.$date_tdy.'.xlsx"');
header('Cache-Control: max-age=0');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>