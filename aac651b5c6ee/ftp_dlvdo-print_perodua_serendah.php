<?php
/*require('C:\xampp\htdocs\PSS_Online\ppc_store\fpdf\fpdf.php');
*/



//error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';


require('fpdf\fpdf.php');

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));
$fmt_curr_time = (date("H:i:s"));
$pick_curr_time = (date("H:i a"));
$yearSkrg = (date("Y"));

$uid2 = (base64_decode($_GET["buid"]));
//$uid = $_GET["uid"];

//Initialize the 5 columns and the total
$column_item = "";
$column_part_no = "";
$column_part_name = "";
$column_qty = "";
$column_unit = "";
$no = 1;
$max = 10;

//-------select data from database --------------------------//
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);

//logo company
$extension = explode('.', $data_setup["logo_name"]);
$filename = $data_setup["logo_comp"].'.'.$extension[1];
		
//----------------------------------------------------

$query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
$result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
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

//query
$uid2 = (base64_decode($_GET["buid"]));
$prep_by = (base64_decode($_GET["puid"]));
$dtcrt_by = (base64_decode($_GET["duid"]));


$query_by_group = "SELECT *, DATE_FORMAT(posting_date,'%d%m%Y') AS T from prt_do_perodua_tag WHERE material_doc_gen = '".sql_esc($uid2)."'";
$result_by_group = mysqli_query($dbc,$query_by_group);   //run the query.
	
//Create a new PDF file
$pdf=new FPDF('P','mm','A4');
$pdf->SetMargins(6.5, 6.5, 6.5);



class PDF extends FPDF
{
	// Page header
	function Header()
	{	
		$this->Image('../set_upload/1.png',10,10,100);	// Logo
		$this->Ln(1); // Line break
		$this->SetTitle('DELIVERY ORDER');
		$this->SetFont('Arial','',9);
		$this->Cell(150,2,'Doc No. :',0,1,'R','','');
		$this->Cell(180,-1,'QR-7.5.5-PC-A01',0,1,'R','','');
		$this->SetFont('Arial','',9);
		$this->Cell(150,8,'Rev No. :',0,1,'R');
		$this->Cell(157,-8,'0',0,1,'R','','');
		
		$this->Ln(15); // Line break
	}

	// Page footer
	function Footer()
	{
		//include '../include/config.php';
		$uid2 = (base64_decode($_GET["buid"]));
		$prep_by = (base64_decode($_GET["puid"]));
		$dtcrt_by = (base64_decode($_GET["duid"]));
		
		$this->Ln(2);// Line break 
		$this->SetY(-80);// Position at 6.0 cm from bottom
		$this->SetFont('Arial','',10);// Arial italic 8
		$this->Cell(0,7,'Received the above mention goods in good order and condition. Kindly sign, chop and return.',0,1,'L');

		//----header table ---------
		$this->SetFillColor(100,229,252); 
		$this->SetFont('Arial','B',11);
		$this->SetX(1);
		$this->Cell(70,37,'Received by',1,0,'C',0);
		$this->Cell(70,37,'Distribution :',1,0,'C',0);
		$this->Cell(70,37,'Authorised by',1,0,'C',0);
				
		//---content table --------
	$this->Ln(23);
	$this->SetFont('Arial','',9);
	$this->SetX(2);
	$this->Cell(15,0,'Name :',0,0,'C');
	$this->SetX(15);
	$this->Cell(49,0,'',1);
	$this->SetX(75);
	$this->Cell(75,0,'White  :',0);
	$this->SetX(87);
	$this->Cell(85,0,'Customer',0);
	$this->SetX(145);
	$this->Cell(15,0,'Name :',0);
	$this->SetX(157);
	$this->Cell(34,0,'',1,0);
	
	
	
	
	$this->Ln(4);
	$this->SetFont('Arial','',9);
	$this->SetX(2);
	$this->Cell(15,0,'IC No. :',0,0,'C');
	$this->SetX(15);
	$this->Cell(49,0,'',1,0);
	$this->SetX(75);
	$this->Cell(75,0,'Green  :',0);
	$this->SetX(87);
	$this->Cell(85,0,'Store',0);
	$this->SetX(145);
	$this->Cell(15,0,'Designation :',0);
	$this->SetX(166);
	$this->Cell(34,0,'',1,0);
	
	
	
	$this->Ln(4);
	$this->SetFont('Arial','',9);
	$this->SetX(2);
	$this->Cell(15,0,'Date   :',0,0,'C');
	$this->SetX(15);
	$this->Cell(49,0,'',1);
	$this->SetX(75);
	$this->Cell(75,0,'Blue    :',0);
	$this->SetX(87);
	$this->Cell(89,0,'Account',0);
	$this->SetX(145);
	$this->Cell(15,0,'Department :',0);
	$this->SetX(166);
	$this->Cell(34,0,'',1,0);
	
		
	$this->Ln(4);	
    $this->SetX(75);
	$this->Cell(75,0,'Yellow :',0);
	$this->SetX(87);
	$this->Cell(89,0,'Account',0);
	
	
		
	
	//-----------pagination-------------	
		$this->Ln(2);// Line break
		$this->Cell(0,30,''.$this->PageNo().' of {nb}',0,0,'C'); // Page number
		
		
		
		
		
	}








} // end class






// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

/*$pdf->SetFont('Arial','B',18);
$pdf->Cell(60,10,'SUBCONTRACTOR DELIVERY ORDER',0,2);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(150,0,'No. :',0,1,'R','','');
$pdf->Cell(180,0,$uid,0,1,'R','','');
$pdf->Cell(150,8,'Date :',0,1,'R');
$pdf->Cell(180,-8,$row_detail["T5"],0,1,'R','','');
$pdf->Ln(10);*/

//Fields Name position
$Y_Fields_Name_position = 80;
//Table position, under Fields Name
$Y_Table_Position = 86;


//-----address vendor -------
$queryu = "SELECT *, DATE_FORMAT(date_create,'%d-%m-%Y') AS Q, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T, DATE_FORMAT(dlv_date,'%d-%m-%Y') AS H from prt_do_perodua_tag 
				WHERE material_doc_gen = '".sql_esc($uid2)."' GROUP BY material_doc_gen";
$rs = mysqli_query($dbc,$queryu);
$db_rs = mysqli_fetch_array($rs);

//-------get address plant-----		
$query_plant = "SELECT * FROM company_detail WHERE plant_code = '".sql_esc($db_rs["ship_point"])."'";
$result_plant = mysqli_query($dbc,$query_plant);
$data_plant = mysqli_fetch_array($result_plant); 


//1st row header	
$pdf->SetFont('Arial','',8);
$pdf->Cell(150,4,$data_plant["comp_add1"].$data_plant["comp_add2"].$data_plant["comp_add3"],0,1,'L','','');
$pdf->Cell(150,4,$data_plant["comp_postcode"].','.$data_plant["comp_city"].$data_plant["comp_state"],0,1,'L','','');
$pdf->Cell(150,4,$data_plant["comp_telno1"].$data_plant["comp_fax"],0,1,'L','','');
$pdf->Cell(150,4,'SST Reg No : B-16-1808-21002437',0,1,'L','','');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(174,-25,'DELIVERY ORDER',0,1,'R','','');
		
$pdf->SetFont('Arial','',8);
$pdf->Cell(144,35,'No.A ',0,1,'R','','');

$pdf->Ln(1);


//-------get address customer-----
$query_vendor = new PreparedSql("SELECT * FROM cust_detail WHERE id_cust = ?", [$db_rs["ship_from"]]);
$result_vendor = db_query($dbc, $query_vendor);
$data_vendor = mysqli_fetch_array($result_vendor); 

//2nd row header
	
$pdf->SetFont('Arial','B',8);
$pdf->Cell(150,4,$data_vendor["cust_desc"],0,1,'L','','');
$pdf->SetFont('Arial','',8);
$pdf->Cell(150,4,$data_vendor["add_no1"].$data_vendor["add_no2"],0,1,'L','','');
$pdf->Cell(150,4,$data_vendor["post_code"].','.$data_vendor["post_city"].$data_vendor["post_region"].$data_vendor["post_country"],0,1,'L','','');
$pdf->Cell(150,4,$data_vendor["tphone"].$data_vendor["fax_no"],0,1,'L','','');
$pdf->SetFont('Arial','',8);
//$pdf->Cell(150,4,$data_vendor["id_cust"],0,1,'L','','');

$pdf->SetFont('Arial','',8);
$pdf->Cell(132,-38,'Delivery Order No.:',0,1,'R','','');
$pdf->Cell(170,38,$db_rs["material_doc_gen"],0,1,'R','','');
$pdf->Cell(132,-28,'Delivery Date:',0,1,'R','','');
$pdf->Cell(170,28,$db_rs["H"],0,1,'R','','');
$pdf->Cell(132,-18,'Time:',0,1,'R','','');
$pdf->Cell(170,18,$db_rs["posting_time"],0,1,'R','','');
$pdf->Cell(132,-8,'PDIO/Kanban No./PO No.:',0,1,'R','','');
$pdf->Cell(170,8,$db_rs["pdio_no"],0,1,'R','','');

$pdf->Ln(2);

//For each row, add the field to the corresponding column
while($row = mysqli_fetch_array($result_by_group))
{	

	$query_info_dlv = "SELECT * FROM dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($row["material_doc_gen"])."' AND id_do='".sql_esc($row["id_do"])."'";
	$result_info_dlv = mysqli_query($dbc,$query_info_dlv);
	$data_info_dlv = mysqli_fetch_array($result_info_dlv);
	
	//-------get issued detail----
	$query_issue = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$row["prepared_by"]]);
	$result_issue = db_query($dbc, $query_issue);
	$data_issue = mysqli_fetch_array($result_issue);	
	
	$no = sprintf('%04d',$no);  // item no
	
    $item_no = $no;
    $part_no = $row["material_no"];
    $part_desc = $row["material_desc"];
    $part_qty = intval($row["qty_dlv"]);
	$part_uom = $data_info_dlv["unit_soi"];

    $column_item = $column_item.$item_no."\n";
    $column_part_no = $column_part_no.$part_no."\n";
	$column_part_name = $column_part_name.$part_desc."\n";
    $column_qty = $column_qty.$part_qty."\n";
	$column_unit = $column_unit.$part_uom."\n";
	
	
	if($no % $max == 1)  // next pages
	{
		if($no != 1)  // not 1st page [doc no]
		{	
		
		    $pdf->SetFont('Arial','B',18);
			$pdf->Cell(60,10,'',0,2);
			
			
	
	 	}
	
		//----header table ---------
		$pdf->SetFillColor(193,229,252); 
		$pdf->SetFont('Arial','B',11);
		$pdf->SetY($Y_Fields_Name_position);
		$pdf->SetX(1);
		$pdf->Cell(15,6,'Item',1,0,'C',1);
		$pdf->SetX(15);
		$pdf->Cell(60,6,'Part Number',1,0,'L',1);
		$pdf->SetX(60);
		$pdf->Cell(160,6,'Description',1,0,'L',1);
		$pdf->SetX(142);
		$pdf->Cell(30,6,'Quantity',1,0,'L',1);
		$pdf->SetX(192);
		$pdf->Cell(17,6,'Unit',0,1);
	
	}
	
	//---content table --------
	$pdf->Ln(7);
	$pdf->SetFont('Arial','',9);
	$pdf->SetX(0);
	$pdf->Cell(15,0,$item_no,0,0,'C');
	$pdf->SetX(15);
	$pdf->Cell(60,0,$part_no,0);
	$pdf->SetX(60);
	$pdf->Cell(160,0,$part_desc,0);
	$pdf->SetX(142);
	$pdf->Cell(30,0,$part_qty,0,0,'C');
	$pdf->SetX(183);
	$pdf->Cell(30,0,$part_uom,0,0,'C');


 

    //---- pages -----
	if($no % $max == 0)
	{		 
		$pdf->addPage('','',false); 
	} // end if
   
    $no++;
	
   }


	


//mysqli_close($dbc);


$pdf->Output();




?>


