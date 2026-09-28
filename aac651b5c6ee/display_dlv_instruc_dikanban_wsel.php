<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
$Cdate = date ("l, j F Y ");

set_time_limit(0);
// include 2D barcode class (search for installation path)
require_once('tcpdf_barcodes_2d.php');

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

$url = "display_inbox-dikanban.php";

$query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
$result2 = db_query($dbc, $query2) or die (mysqli_error());
$res = mysqli_fetch_array($result2);
	
$today = getdate();
$hours = $today['hours']; 
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year']; 	

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	

$extension = explode ('.', $data_setup["logo_name"]);
$filename = $data_setup["logo_comp"].'.'.$extension[1];

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


$uid2 = base64_decode($_GET["uid2"]);

//$uid = $_GET["uid"];
//--------- pps detail ------------

$query_pps_tit = "SELECT *,DATE_FORMAT(date_dlv,'%d-%m-%Y') as R FROM print_tag_do_dikanban WHERE do_no = '".sql_esc($uid2)."'";
$result_pps_tit = mysqli_query($dbc,$query_pps_tit);
$data_tit = mysqli_fetch_array($result_pps_tit);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?> ">
    <title><?php echo html_esc($data_setup["comp_code"]); ?> : Material Doc. No <?php echo html_esc($data_tit["do_no"]); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    
     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <!-- <link rel="stylesheet" type="text/css" href="css/prt-sheet2.css">-->
    
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
<!--https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages-->
<script>
    $(document).ready(function(){
    $(document).on('click', '#btnPrint', function(){
    $('.printMe').printElem();
    });
    });
    
    </script>
    <style>
    @media print {
		@page{
			/*size: 8.5in 11in; */
			size: A4;	
			zoom:100%;
		}
		.face {			
			margin: 0.05cm;
			zoom:97%;
			/*page-break-after: always;*/
		}
		<!--.table {page-break-before: always; }-->

		.face-button button  
		{ 
			display: none; 
		}
		
		.prt-button 
		{ 
			display: none; 
		}
		
	
    .ft_page1 {page-break-after: always;}

	.tblspace
		{ 
			display: none;
		
		}
		
		.allButFooter {
    min-height: calc(100vh - 45px); 
         }
		 
		.tfootT2 { display:table-footer-group;
	           height: 300px;
               margin-top:-100px; 
			   bottom: 0;
			   
	       }

			
	}
		
	</style>
	
	<style>
	/*https://gist.github.com/hubgit/7025107*/
	@page {
		/* dimensions for the whole page */
		size: A4;
	}
	
	body {
		/*width: 210mm;
		height: 148.5mm;*/
	
		margin: 0;
	}
	

	/* fill half the height with each face */
	.face {

		size: A4;
		height:auto;
		/*margin-top: 0.05cm;*/
		margin-bottom: 0.6cm;
		
	}
	
	/* the front face */
	.face-front {
		background: #fff;
		/*margin-bottom: 0.05cm;
		top:0.05cm;
		bottom: 0.05cm;*/
		
	}
	
	.prt-button {
		position: fixed;
		bottom: 10px;
		right: 310px; 
	}
			
	.style4 {
		font-size: 12px;
		color: #000000;
		font-family: Arial, Helvetica, sans-serif;
	}
	.style1 {	
		font-size: 14px;
		font-weight: bold;
		color: #000000;
		font-family: Arial, Helvetica, sans-serif;
	}
	.style10 {	
		font-size: 12px;
		color: #000000; 
		font-family: Arial, Helvetica, sans-serif;
		padding-bottom: 0.2cm;
	}
	.style11 {	
		font-family: Arial, Helvetica, sans-serif;
		font-size: 17px;
		color: #000000;
		font-weight: bold;
	}
	.style7 {	
		font-size: 18px;
		font-weight: bold;
		color: #000000;
		font-family: Arial, Helvetica, sans-serif;
	}
	.style8 {	
		font-size: 13px;
		color: #000000; 
		font-family: Arial, Helvetica, sans-serif;
	}
	.style9 {	
		font-size: 22px;
		font-weight: bold;
		color: #000000; 
		font-family: Arial, Helvetica, sans-serif;
	}
	
	</style>
      <style type="text/css">
    .tableD { page-break-inside:auto }
    .divV   { page-break-inside:avoid; } /* This is the key */
    .theadS { display:table-header-group }
    .tfootT { display:table-footer-group }
	.tfootT2 { display:table-footer-group }
	.tbodyB { display:table-row-group }

   </style> 
   <style>
@media print {
    .pageBreakT {
        page-break-after: always; }
		
	.tableD { page-break-inside:auto }
    .divV   { page-break-inside:avoid; } /* This is the key */
    .theadS { display:table-header-group }
    .tfootT { display:table-footer-group }

		
    }
}
</style>
</head>

<body>
<div class="ft_page1">
<?php

$uid2 = base64_decode($_GET["buid"]);


	 $query_bb = "SELECT *, DATE_FORMAT(date_posting_do,'%d-%m-%Y') AS D4, DATE_FORMAT(time_posting_do,'%h:%i:%s %p') AS DT4, DATE_FORMAT(date_dlv,'%d-%m-%Y') AS D3 from dlv_ord_dikanban_generate WHERE do_no = '".sql_esc($uid2)."' ";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 
	 //-----get cvendor  ----
	 
	 $query_vend = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ?", [$data_bb["vc_code"]]);
	 $result_vend = db_query($dbc, $query_vend) or die (mysqli_error());
	 $data_vend = mysqli_fetch_array($result_vend);
	 
	  //-----get model  ----
	 
	 $query_model = new PreparedSql("SELECT * FROM model_detail WHERE model_code = ?", [$data_bb["model_cd"]]);
	 $result_model = db_query($dbc, $query_model);
	 $data_model = mysqli_fetch_array($result_model);
	 
	 
	 //-----shift day ---
	 
	 if($data_bb["shift_dlv"] == "D/S")
	 {
		$waktu_dec = "AM"; 
	 }elseif($data_bb["shift_dlv"] == "N/S")
	 {
	    $waktu_dec = "PM"; 
	 }else{
		$waktu_dec = "";  
	 }
	 ?>
        
        <table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
  <tr>
    <td width="42%"><img src="../set_upload/<?php echo $filename; ?>" width="350" height="50"/> </td>     
    <td width="25%">&nbsp;</td>
    <td width="33%" valign="top">&nbsp;<h3><font color="#999999"><b>DELIVERY ORDER</b></font></h3></td>
  </tr>
  <tr>
    <td rowspan="5"><p><b>INGRESS AOI TECHNOLOGIES SDN. BHD. (1346911-U)</b></p>
    Lot 40481, Seksyen 20,<br> Mukim Bandar Serendah,<br>
    Hulu Selangor,<br> 48200 Selangor.<br>
    <p>Tel : 03-6028 3003<br>Fax: 03-6028 3004</p>
    
    </td>
    <td><?php
	
	
	
	// membuat tabel berisi label barcode
	echo " <center><br /><table border='0'>";
	
	
	
     echo "<tr>";
	?>      <?php
	 echo "<td align='center'>";
	// set the barcode content and type
	
	$barcodeobjA = ($data_bb['do_no'].'|'.$data_bb['po_no'].'|'.$data_bb['DI_doc']);
	
	
	$barcodeobjA = new TCPDF2DBarcode($barcodeobjA, 'QRcode');
    echo $barcodeobjA->getBarcodeSVGcode(2.5, 2.5, 'black');
	
	echo "</td>";
	
    echo "</tr>";


echo "</table></center>";
//echo $row["id_tag"];
?>
    
     </td>
    <td><table width="400" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="200"><b>Delivery Order No.</b></td>
    <td width="8">:</td>
    <td width="192"><?php echo $uid2;   ?></td>
  </tr>
  <tr>
    <td><b>Purchase Order No.</b></td>
    <td>:</td>
    <td><?php echo html_esc($data_bb["po_no"]);   ?></td>
  </tr>
 
  <tr>
    <td><b>Delivery Instruction No.</b></td>
    <td>:</td>
    <td><?php echo html_esc($data_bb["DI_doc"]);   ?></td>
  </tr>
  <tr>
    <td><b>Vendor Name</b></td>
    <td>:</td>
    <td><?php echo html_esc($data_vend["vendor_name"]);  ?></td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td>Delivery Date</td>
    <td>:</td>
    <td><?php echo html_esc($data_bb["D3"]);   ?></td>
  </tr>
  <tr>
    <td>Delivery Time</td>
    <td>:</td>
    <td><?php echo html_esc($data_bb["time_dlv"]);   ?><?php //echo $data_bb["DT4"].'&nbsp;'.$waktu_dec;   ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

    </td>
  </tr>
  
        </table>
<br>
<?php
   
   $counterA = 1;
   $noA = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM dlv_ord_dikanban_generate WHERE do_no = '".sql_esc($uid2)."' ORDER BY back_no ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   ?>
 <!--<form name="frmSearch" id="frmSearch" method="post" action="" class="needs-validation"  novalidate>-->
 
  <table border="1" class="tableD">
    
        <thead class="theadS">
            <tr>
             <th>No</th>
             <th>Back No.</th>
             <th>Part No.</th>
             <th>Part Name</th> 
             <th>Standard Packaging</th> 
             <th>Total Packaging</th>
             <th>Delivered Quantity</th>     
             <th>Balanced Quantity</th>
             <th>UoM</th>
             <th>Remarks</th>
            </tr>
        </thead>

  <tbody>
  <?php
   
   
  $pend_qty = 0.000;  
  $tot_pack = 0;
  $tot_dlv_qty = 0;
  $tot_pend_qty = 0;
  $k = 1;
   
   while($row2 = mysqli_fetch_array($result_display))
   {

   //-----print tag -----
   
    $query_tag_info = "SELECT *,DATE_FORMAT(date_dlv,'%d-%m-%Y') as R FROM print_tag_do_dikanban WHERE do_no = '".sql_esc($uid2)."' AND back_no = '".sql_esc($row2["back_no"])."' AND material_no = '".sql_esc($row2["material_no"])."' ";
	$result_tag_info = mysqli_query($dbc,$query_tag_info);
	$data_tag_info = mysqli_fetch_array($result_tag_info);
   
   
   
   
   //---- calculation quantity delivery -------
	
	 $query_qty_deli = "SELECT * FROM dlv_ord_dikanban_generate WHERE po_no = '".sql_esc($row2["po_no"])."' AND DI_doc = '".sql_esc($row2["DI_doc"])."' AND material_no = '".sql_esc($row2["material_no"])."' AND status_DO != '".sql_esc($rst_sta4["status_desc"])."'";
	 $result_qty_deli = mysqli_query($dbc,$query_qty_deli);
	 $num_1 = mysqli_num_rows($result_qty_deli);   //how many material are there? 
	  
	 
	   $tot_di_qty = 0.000;
	   
	   
	   while($data_qty_deli = mysqli_fetch_array($result_qty_deli)) 
	{   
		
		$tot_di_qty = $tot_di_qty + $data_qty_deli["qty_dlv"];
							
	
	}
	
	$pend_qty = ($row2["kanban_order"] - ($tot_di_qty));
   
   
   
     //-----tag info ---
	 if($data_tag_info["total_slip"] > 0 )
	 {
		$tag_pack = $data_tag_info["total_slip"]; 
	 
	 }else{
		 
		$tag_pack = 0; 
		 
	 }
	 
	 //-----calculation -----
	 $tot_pack = $tot_pack + $data_tag_info["total_slip"]; 
	 $tot_dlv_qty = $tot_dlv_qty + $row2["qty_dlv"];
	 $tot_pend_qty = $tot_pend_qty + $pend_qty;
    
      echo '<tbody><tr>'; 
    if ($k && $k % 5 == 0)
	
        echo '</tr><tr class="breakAfter">'; 
	else if ($k) 
	
        echo '</tr><tr>'; 
	  ++$k;  	
  ?>
   
    <td width="60"><div align="center"><?php echo $noA; ?></div></td>
    <td width="150"><div align="center"><?php echo html_esc($row2["back_no"]); ?></div></td>
    <td width="200"><?php echo html_esc($row2["material_no"]); ?></td>
    <td width="300"><?php echo html_esc($row2["material_desc"]); ?></td>
    <td width="100"><div align="center"> <?php if($row2["qty_dlv"] > 0.000 ) { echo html_esc($row2["std_package"]);  }else{  echo '0'; } ?>	</div></td> 
    <td width="100"><div align="center"><?php echo $tag_pack; ?></div></td>  
    <td width="100"><div align="center"><?php if($row2["qty_dlv"] > 0.000 ) { echo intval($row2["qty_dlv"]); }else{  echo '0'; } ?></div></td>
    <td width="100"><div align="center"> <?php echo $pend_qty; ?>	</div></td>   
    <td width="100"><div align="center"><?php echo html_esc($row2["uom_dlv"]); ?></div></td>
    <td width="150"></td>
    </tr>
  
 <?php 
		  
	      //$tot_pack++;
		  $noA++;
		  $counterA++; // menambah counter
		  
		  echo '</tr></tbody>';
		  
		  } 
		  
		  ?>
   
  
   <tfoot width="98%" class="tfootT">
    <tr>
    <td width="784" colspan="5"><div align="right"><b>Total</b></div></td>
    <td width="100"><div align="center"><?php echo $tot_pack; ?></div></td>  
    <td width="100"><div align="center"><?php echo $tot_dlv_qty; ?></div></td>
    <td width="100"><div align="center"><?php echo $tot_pend_qty; ?></div></td>   
    <td width="100"></td>  
    <td width="150">&nbsp;</td>
    </tr>
       </tfoot>
</table>

<tfoot class="tfootT">
<table width="98%" class="tfootT table-bordered" >
  <tr>
    <td width="784" colspan="5"><div align="right"><b>Grand Total</b></div></td>
    <td width="100"></td>  
    <td width="100"></td>
    <td width="100"></td>   
    <td width="100"></td>
    <td width="150"></td>
  </tr>
</table>
 </tfoot>
<br>
<!--
<div class="allButFooter">
        System Generated....
    </div>-->
  
<tfoot class="tfootT2">
<table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="20">&nbsp;</td>
  </tr>
</table>

<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td colspan="2"><span class="style1B"><div align="center"><?php echo html_esc($data_setup["title_desc"]); ?></div></span></td>
    <td colspan="2"><span class="style1B"><div align="center">VENDOR</div></span></td>
  </tr>
  <tr>
    <td width="25%"><span class="style1B"><div align="center">ORDER BY </div></span></td>
    <td width="25%"><span class="style1B"><div align="center">RECEIVED BY</div></span></td>
    <td width="25%"><span class="style1B"><div align="center">SUPPLIER ACKNOWLEDGEMENT</div></span></td>
    <td width="25%"><span class="style1B"><div align="center">LORRY DRIVER</div></span></td>
  </tr>
  <tr>
    <td><span class="style1A">*THIS IS AN APPROVED COMPUTER GENERATED<br>DOCUMENT AND DO NOT REQUIRE SIGNATURE</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Name :</td>
    <td>Name :</td>
    <td>Name :</td>
    <td>Name :</td>
  </tr>
</table>
 

 </tfoot>
</div>
<br>
<?php



//--------- pps detail ------------

$query_pps = "SELECT *,DATE_FORMAT(date_dlv,'%d-%m-%Y') as R FROM print_tag_do_dikanban WHERE do_no = '".sql_esc($uid2)."'";
$result_pps = mysqli_query($dbc,$query_pps);
$rowcount=mysqli_num_rows($result_pps);

while($row = mysqli_fetch_array($result_pps))
{
 
// echo $rowcount;

  $i = $rowcount;
	
	//----------display material header
	$query_info3 = new PreparedSql("SELECT * FROM mat_master_header WHERE material_no = ?", [$row["material_no"]]);
	$result_info3 = db_query($dbc, $query_info3);
	$row_info3 = mysqli_fetch_array($result_info3);





?>

<center>
<div class="face">
<?php

/*
		if ($i && $i % 2 == 0)  
		echo '<table width="98%" height="240" border="1" cellpadding="0" cellspacing="0" style="page-break-after:always">';  
	    else if ($i)  
		echo '<table width="98%" height="240" border="1" cellpadding="0" cellspacing="0" >';  
	*/



?>
<table width="98%" height="242" border="1" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="32" colspan="2">&nbsp;&nbsp;<img src="../set_upload/<?php echo $filename;  ?>" width="350" height="50" hspace="1" vspace="1"/>
   </td>
    <td height="32" colspan="4"><h4><center>GOODS RECEIPT (GR) TAG</center></h4></td>
    </tr>
   <tr>
    <td width="161" height="20">&nbsp;<span class="style8">Document No.</span></td>
    <td width="196" height="20">&nbsp;<span class="style1"><?php echo html_esc($row["do_no"]);  ?></span></td>
    <td width="124" height="20">&nbsp;<span class="style8">Purchase Order No.</span></td>
    <td width="161" height="20">&nbsp;<span class="style1"> <?php echo html_esc($row["purc_ord_no"]);  ?></span></td>
    <td colspan="2" rowspan="4">&nbsp;
    
    <?php
	
	$query = "SELECT *,DATE_FORMAT(date_dlv,'%d%m%Y') as Q2 FROM print_tag_do_dikanban WHERE do_no = '".sql_esc($row["do_no"])."' AND id_tag = '".sql_esc($row["id_tag"])."' ";
	$hasil = mysqli_query($dbc,$query);
	
	// setting banyaknya kolom
	$kolom = 2;
	
	// membuat tabel berisi label barcode
	echo " <center><br /><table border='0'>";
	$counter = 1;
	$total_slip_no = "";
	
	while ($data = mysqli_fetch_array($hasil))
	{
	
		$query_sloc = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$data["material_no"]]);
		$result_sloc = db_query($dbc, $query_sloc);
		$data_sloc = mysqli_fetch_array($result_sloc);
	
	$total_slip_no = ($row["slip_no"].' of '.$row["total_slip"]);
	
	$qty_baru = (intval($row['tag_qty']));
	
	
     echo "<tr>";
	?>      <?php
	 echo "<td align='center'>";
	// set the barcode content and type
	
	$barcodeobj = ($data['material_no'].'|'.$data['plant_code'].'|'.$data['purc_ord_no'].'|'.$data['DI_doc'].'|'.$data['Q2'].'|'.$data['sloc_gr'].'|'.$qty_baru.'|'.$data['ord_uom'].'|'.$total_slip_no.'|'.$data['do_no']);
	
	
	$barcodeobj = new TCPDF2DBarcode($barcodeobj, 'QRcode');
    echo $barcodeobj->getBarcodeSVGcode(2.5, 2.5, 'black');
	
	echo "</td>";
	
    echo "</tr>";


}
echo "</table></center>";
//echo $row["id_tag"];
?>
<br>
    </td>
    </tr>
   <tr>
     <td height="20">&nbsp;<span class="style8">Received by</span></td>
     <td height="20">&nbsp;<span class="style1"><?php //echo $row["user_posting"];  ?></span></td>
     <td height="20">&nbsp;<span class="style8">Delivery Note</span></td>
     <td height="20">&nbsp;<span class="style1"> <?php //echo $row["do_no"];  ?></span></td>
   </tr>
   <tr>
     <td height="20">&nbsp;<span class="style8">Received Date</span></td>
     <td height="20">&nbsp;<span class="style1"><?php echo html_esc($row["R"]);  ?></span></td>
     <td height="20">&nbsp;<span class="style8">Received Time</span></td>
     <td height="20">&nbsp;<span class="style1"><?php echo html_esc($row["time_dlv"]);  ?></span></td>   
   </tr>
    <tr>
    <td height="20">&nbsp;<span class="style8">Model</span></td>
    <td colspan="3">&nbsp;<span class="style7"><?php echo html_esc($row["model_gr"]);  ?></span></td>
    </tr>
  <tr>
    <td height="20">&nbsp;<span class="style8">Part No.</span></td>
    <td height="20" colspan="3" >&nbsp;<span class="style7"><?php echo html_esc($row["material_no"]);     ?></span>
      </td>
    <td width="105" height="25" >&nbsp;<span class="style8">Quantity</span></td>
    <td width="146">&nbsp;<span class="style7"><?php echo intval($row["tag_qty"]);  ?></span>&nbsp;</td>
  </tr>
  <tr>
    <td height="20">&nbsp;<span class="style8">Part Name</span></td>
    <td colspan="3" >&nbsp;<span class="style7"><?php echo html_esc($row["material_desc"]);  ?></span></td>
    <td>&nbsp;<span class="style8">UOM</span><span class="style8"></span></td>
    <td>&nbsp;<span class="style7"><?php echo html_esc($row["ord_uom"]);  ?></span></td>
  </tr>
  <tr>
    <td height="40" rowspan="2">&nbsp;<span class="style8">Size/Dimensions</span></td>
    <td height="20" colspan="3" rowspan="2" >&nbsp;&nbsp;</td>
    <td>&nbsp;<span class="style8">Slip No.</span></td>
    <td>&nbsp;<span class="style1"> <?php echo html_esc($row["slip_no"]);  ?> of <?php echo html_esc($row["total_slip"]);  ?> </span></td>
  </tr>
  <tr>
    <td>&nbsp;<span class="style8">Shift</span></td>
    <td>&nbsp;<span class="style1"><?php if($row["shift_tag"] == "D/S"){ echo "Day"; }else{ echo "Night"; } ?>
    </span></td>
  </tr>
</table>
<?php      $i++; ?>

</div><br>
</center> 
<?php
  if($i % 4 == 0)
  {
  
  ?>
<div style="page-break-after:always"  > <?php   } else{  ?>

	<br>
 
   
<?php

 }   

?>

<?php
}// end while loop main 
?>

</div>   <?php   //} //enf if ?>


<!--button print-->
<div class="prt-button">
  <button type="button" name="btn_release" id="btn_release" class="btn btn-success btn-sm" onClick="window.print()">Print this Page</button>
</div>

</body>
</html>