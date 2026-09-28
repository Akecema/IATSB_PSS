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

$url = "print_tag-dikanban.php";

$query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
$result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
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

$buid = base64_decode($_GET["buid"]);

//$uid = $_GET["uid"];
//--------- pps detail ------------

$query_pps_tit = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as R FROM print_tag_do_dikanban WHERE  DI_doc = '".sql_esc($buid)."'";
$result_pps_tit = mysqli_query($dbc,$query_pps_tit);
$data_tit = mysqli_fetch_array($result_pps_tit);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?> ">
    <title><?php echo $data_setup["comp_code"]; ?> : Delivery Order No. <?php echo $data_tit["do_no"]; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/prt-sheet.css">
    
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
	.style1A {	
		font-size: 9px;
		font-weight: bold;
		color: #000000;
		font-family: Arial, Helvetica, sans-serif;
	}
	.style1B {	
		font-size: 11px;
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
</style>
    
</head>

<body>

<?php



//--------- pps detail ------------

$query_pps = "SELECT *,DATE_FORMAT(date_dlv,'%d-%m-%Y') as R FROM print_tag_do_dikanban WHERE DI_doc = '".sql_esc($buid)."' ";
$result_pps = mysqli_query($dbc,$query_pps);
$rowcount=mysqli_num_rows($result_pps);

while($rowA = mysqli_fetch_array($result_pps))
{
 

	//----------display table_material_itsb
	$query_info3 = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($rowA["material_no"])."'";
	$result_info3 = mysqli_query($dbc,$query_info3);
	$row_info3 = mysqli_fetch_array($result_info3);

	$query_detail_tag = "SELECT *, DATE_FORMAT(date_dlv,'%d-%m-%Y') as RPV FROM dlv_dikanban_generate WHERE id = '".sql_esc($rowA["id_do"])."' AND  (status_kanban = '".sql_esc($rst_sta["status_desc"])."' OR status_kanban = '".sql_esc($rst_sta7["status_desc"])."' OR status_kanban = '".sql_esc($rst_sta13["status_desc"])."' OR status_kanban = '".sql_esc($rst_sta14["status_desc"])."')  ";
	$rst_detail_tag = mysqli_query($dbc,$query_detail_tag);
	$row_detail_tag = mysqli_fetch_array($rst_detail_tag);



?>

<center>
<div class="face">

<table width="98%" height="242" border="1" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="32" colspan="2">&nbsp;&nbsp;<img src="../set_upload/<?php echo $filename;  ?>" width="350" height="50" hspace="1" vspace="1"/>
   </td>
    <td height="32" colspan="2"><h4><center>DI/KANBAN ORDER</center></h4></td>
    <td height="32" colspan="2"><h4><center><?php echo $rowA["back_no"]; ?></center></h4></td>
    </tr>
   <tr>
    <td width="161" height="20">&nbsp;<span class="style8">Delivery Order No.</span></td>
    <td width="196" height="20">&nbsp;<span class="style1"><?php //echo $rowA["do_no"];  ?></span></td>
    <td width="124" height="20">&nbsp;<span class="style8">Purchase Order No.</span></td>
    <td width="161" height="20">&nbsp;<span class="style1"> <?php echo $rowA["purc_ord_no"];  ?></span></td>
    <td colspan="2" rowspan="4">&nbsp;
    
    <?php
	
	$query = "SELECT *,DATE_FORMAT(date_dlv,'%d%m%Y') as Q2 FROM print_tag_do_dikanban WHERE id_tag = '".sql_esc($rowA["id_tag"])."' ";
	$hasil = mysqli_query($dbc,$query);
	
	// setting banyaknya kolom
	$kolom = 2;
	
	// membuat tabel berisi label barcode
	echo " <center><br /><table border='0'>";
	$counter = 1;
	$total_slip_no = "";
	
	while ($data = mysqli_fetch_array($hasil))
	{
	   //----detail vendor ----------
	 $query_vendfoc = "SELECT * FROM vendor_detail WHERE vendor_code = '".sql_esc($data["vendor_id"])."'";
	 $result_vendfoc = mysqli_query($dbc,$query_vendfoc);
	 $row_vendfoc = mysqli_fetch_array($result_vendfoc);
	
	
	
	
		$query_sloc = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($data["material_no"])."'";
		$result_sloc = mysqli_query($dbc,$query_sloc);
		$data_sloc = mysqli_fetch_array($result_sloc);
	
	$total_slip_no = ($rowA["slip_no"].' of '.$rowA["total_slip"]);
	
	$qty_baru = (intval($rowA['tag_qty']));
	
	
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
     <td height="20">&nbsp;<span class="style8">Delivery Instruction No.</span></td>
     <td height="20">&nbsp;<span class="style1"><?php echo $rowA["DI_doc"];  ?></span></td>
     <td height="20">&nbsp;<span class="style8">Vendor</span></td>
     <td height="20">&nbsp;<span class="style1"> <?php echo $row_vendfoc["search_term"];  ?></span></td>
   </tr>
   <tr>
     <td height="20">&nbsp;<span class="style8">Delivery Date</span></td>
     <td height="20">&nbsp;<span class="style1">&nbsp;<?php echo $row_detail_tag["RPV"]; ?></span></td>
     <td height="20">&nbsp;<span class="style8">Delivery Time [ETD]</span></td>
     <td height="20">&nbsp;<span class="style1">&nbsp;<?php echo $row_detail_tag["time_dlv"]; ?></span></td>
   </tr>
    <tr>
    <td height="20">&nbsp;<span class="style8">Model</span></td>
    <td colspan="3">&nbsp;<span class="style7"><?php echo $rowA["model_gr"];  ?></span></td>
    </tr>
  <tr>
    <td height="20">&nbsp;<span class="style8">Part No.</span></td>
    <td height="20" colspan="3" >&nbsp;<span class="style7"><?php echo $rowA["material_no"];     ?></span>
      </td>
    <td width="105" height="25" >&nbsp;<span class="style8">Quantity</span></td>
    <td width="146">&nbsp;<span class="style7"><?php echo intval($rowA["tag_qty"]);  ?></span>&nbsp;</td>
  </tr>
  <tr>
    <td height="20">&nbsp;<span class="style8">Part Name</span></td>
    <td colspan="3" >&nbsp;<span class="style7"><?php echo $rowA["material_desc"];  ?></span></td>
    <td>&nbsp;<span class="style8">UOM</span><span class="style8"></span></td>
    <td>&nbsp;<span class="style7"><?php echo $rowA["ord_uom"];  ?></span></td>
  </tr>
  <tr>
    <td height="40" rowspan="2">&nbsp;<span class="style8">Size/Dimensions</span></td>
    <td height="20" colspan="3" rowspan="2" >&nbsp;<span class="style7"><?php echo $data_sloc["size_dim"];  ?></span></td>
    <td>&nbsp;<span class="style8">Slip No.</span></td>
    <td>&nbsp;<span class="style1"> <?php echo $rowA["slip_no"];  ?> of <?php echo $rowA["total_slip"];  ?> </span></td>
  </tr>
  <tr>
    <td>&nbsp;<span class="style8">Shift</span></td>
    <td>&nbsp;<span class="style1">&nbsp; <?php if($rowA["shift_tag"] == "D/S"){ echo "Day"; }else{ echo "Night"; } ?></span></td>
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