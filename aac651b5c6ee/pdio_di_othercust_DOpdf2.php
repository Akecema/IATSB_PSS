<?php
//error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

//-------select data from database --------------------------//
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);

//logo company
$extension = explode('.', $data_setup["logo_name"]);
$filename = $data_setup["logo_comp"].'.'.$extension[1];
		
//----------------------------------------------------

$query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
$result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
$res = mysqli_fetch_array($result2);

$url = "prt_do_tran-dlv.php";

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

        $sht2 = (base64_decode($_GET["sht"])); 
		$mat2 = (base64_decode($_GET["mat"])); 
		$mol2 = (base64_decode($_GET["mol"])); 
		$dtF2 = (base64_decode($_GET["dtF"])); 
		$dtT2 = (base64_decode($_GET["dtT"])); 






	

//============================================================+
// File name   : example_011.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 011 for TCPDF class
//               Colored Table (very simple table)
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {
	
	
	
	
	
    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'../logo_iatsb.jpg';
        $this->Image($image_file, 10, 10, 80, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
   
    }
	
protected $last_page_flag = false;

public function Close() {
    $this->last_page_flag = true;
    parent::Close();
}

public function Footer() {
	

	
	
    if ($this->last_page_flag) {
        // ... footer for the last page ...
		
	
	
	// Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	    $this->SetY(-25);
	    $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 9, 'Prepared by : ______________________________', 0, false, 'L');
        $this->Cell(0, 9, 'Approved by : ______________________________', 0, false, 'R');
   
   
    } else {
        // ... footer for the normal page ...
	  
	
		 // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
	

    // Load table data from file
    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }

    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(40, 35, 40, 45);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('PSS DELIVERY REPORT');
$pdf->SetSubject('PSS DELIVERY REPORT');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$PDF_HEADER_LOGO = "../logo_n.gif";//any image file. check correct path.
$PDF_HEADER_LOGO_WIDTH = "100";
$PDF_HEADER_TITLE = "";
$PDF_HEADER_STRING = "";

// set default header data
$pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

//AddPage [P(PORTRAIT),L(LANDSCAPE)],FORMAT(A4-A5-ETC)

$pdf->AddPage('L','A5');

// column titles
//$header = array('NO.', 'BACK NO.','SAP PART NO', 'CUST PART NO.');

// data loading
//$data = $pdf->LoadData('data/table_data_demo.txt');
// print colored table
//$pdf->ColoredTable($header, $data);
  $pdf->SetFont('helvetica', '', 8);
  $pdf->Cell(0, 0,'Delivery Date From :'.$dtF2, 0, false, 'L', 0, '', 0, false, 'T', 'M' );
  $pdf->Ln();
  $pdf->Cell(0, 0,'Delivery Date To :'.$dtT2, 0, false, 'L', 0, '', 0, false, 'T', 'M' );

   $taJUk = "PSS DELIVERY REPORT";
  
   $pdf->SetFont('helvetica', 'B', 12);
   $pdf->writeHTML($taJUk, true, 0, true, 0);

 // set some text to print
   $headerTable = 
   '<style>
      .text-center {
         text-align: center;
      }
      .bold {
         font-weight: bold;
      }
   </style>

  
  <table width="100%" border="1" cellpadding="1">
    <thead><tr bgcolor="#CC3333">
    <td width="30" class="text-center">NO.</td>
    <td width="60" class="text-center">BACK NO.</td>
    <td width="100" class="text-center">SAP PART NO.</td>
    <td width="100" class="text-center">CUST PART NO.</td>
    <td width="150" class="text-center">PART NAME</td>
    <td width="60" class="text-center">MODEL</td>
    <td width="80" class="text-center">TOTAL DELIVERED</td>
    <td width="80" class="text-center">TOTAL INVOICE</td>
  </tr></thead></table>';
  
   $pdf->SetFont('times', 'B', 10);
   $pdf->writeHTML($headerTable, 0, 0, 0, 0);
	
	$no = 1;
  
   $contentTable = '<table width="100%" border="1" cellpadding="1">';
 
//query
         $sht2 = (base64_decode($_GET["sht"])); 
		$mat2 = (base64_decode($_GET["mat"])); 
		$mol2 = (base64_decode($_GET["mol"])); 
		$dtF2 = (base64_decode($_GET["dtF"])); 
		$dtT2 = (base64_decode($_GET["dtT"])); 


   $where_sql = '';
				 
			     $ddF = substr($dtF2,0,2);
				 $mmF = substr($dtF2,3,2);
				 $yyF = substr($dtF2,6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 $ddF2 = substr($dtT2,0,2);
				 $mmF2 = substr($dtT2,3,2);
				 $yyF2 = substr($dtT2,6,4);
			
			     $date2_final = ($yyF2.'-'.$mmF2.'-'.$ddF2);


  //2. ship to party
               if (($sht2 == "") || ($sht2 == "NULL")){ 
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND vendor_name = '".sql_esc($sht2)."'"; }  	
						
					
		   // 3. dateF
                if ($dtF2 == "00-00-0000" ){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND (dlv_date >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dtT2 == "00-00-0000" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (dlv_date <= '".sql_esc($date2_final)."')"; }
					
		//5. Material No
                if ($mat2 == "NULL" ){
                    $wheresql_05 = ""; }
                else {
					$wheresql_05 = " AND (material_no = '".sql_esc($mat2)."')"; }
					
					
		  //6. model_code
                if ($mol2 == "NULL" ){
                    $wheresql_06 = ""; }
                else {
					$wheresql_06 = " AND (sales_org = '".sql_esc($mol2)."')"; }
					
				
				$where_sql =  $wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05 .$wheresql_06;
	
	//********** END CONDITION **************
		
	 
$queryu = "SELECT * FROM dlv_ord_all_delivery WHERE material_doc_gen != '' ".$where_sql ." GROUP BY material_no ORDER BY material_doc_gen ASC ";
$rs = mysqli_query($dbc,$queryu);   //run the query.
$num_rows = mysqli_num_rows($rs);
$a = $num_rows;	
	
	
   
 while($data_rs = mysqli_fetch_array($rs))
	 {
		 
		  $total_qty = 0;
		  $total_invoice = 0;
	  
	  ///-------calcelutae all material in different pdio/di -----
	  
	  $query_total_q = "SELECT * FROM dlv_ord_all_delivery WHERE material_doc_gen != '' AND material_no = '".sql_esc($data_rs["material_no"])."' ".$where_sql;
	  $rst_total_q = mysqli_query($dbc,$query_total_q);
      
	  while($rowTq = mysqli_fetch_array($rst_total_q))
		   {
			   
	   $total_qty = ($total_qty + $rowTq["qty_dlv"]);		   
		   }
		
		//$total_invoice   
		   
		   //----get model in table material----
		   
		   $query_mat = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($data_rs["material_no"])."' OR material_cust_no = '".sql_esc($data_rs["material_no"])."'";
		   $rst_mat = mysqli_query($dbc,$query_mat);
           $row_mat = mysqli_fetch_array($rst_mat);
	
   
  $contentTable .=
    '<tr>
    <td width="30"><div align="center">'.$no.'</div></td>
    <td width="60"><div align="center">'.$data_rs["back_no"].'</div></td>
    <td width="100">'.$data_rs["material_no_sap"].'</td>
    <td width="100">'.$data_rs["material_no"].'</td>
    <td width="150">'.$data_rs["material_desc"].'</td>
    <td width="60"><div align="center">'.$row_mat["mat_group"].'</div></td>
    <td width="80"><div align="center">'.$total_qty.'</div></td>
    <td width="80"><div align="center">'.$total_qty.'</div></td></tr>';
   
  
      $no++;
   }

   $contentTable .= '</table>';
   
  
    $pdf->SetFont('helvetica', '', 8);
    $pdf->writeHTML($contentTable, true, 0, true, 0);
  



// close and output PDF document
$pdf->Output('PSS DELIVERY ORDER.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

