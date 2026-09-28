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

$query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
$result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
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
$buid2 = base64_decode($_GET["buid2"]);

//$uid = $_GET["uid"];
//--------- pps detail ------------

$query_pps_tit = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as R FROM print_tag_do_dikanban WHERE do_no = '".sql_esc($buid2)."' AND DI_doc = '".sql_esc($buid)."'";
$result_pps_tit = mysqli_query($dbc,$query_pps_tit);
$data_tit = mysqli_fetch_array($result_pps_tit);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?> ">
    <title><?php echo $data_setup["comp_code"]; ?> : INGRESS DELIVERY INSTRUCTION ORDER. <?php echo $data_tit["do_no"]; ?></title>
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
		<!--.table {page-break-before: always; }-->

		.face-button button  
		{ 
			display: none; 
		}
		
		.prt-button 
		{ 
			display: none; 
		}
		
	
  .ft_page1 {page-break-after: always; 			
            
      }

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
		padding-left:5mm;
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
}
</style>
    
</head>

<body>
<div class="ft_page1">

 <?php
	        $buid2 = base64_decode($_GET["buid"]);
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
         	$vendor_code = $_GET["vendor_code"]; 
			
			//echo $buid2;
 
  $extension = explode('.', $data_setup["logo_name"]);
  $filename = $data_setup["logo_comp"].'.'.$extension[1];
 
   ?>
  
     
      <?php
	 
	 $query_bb = "SELECT *, DATE_FORMAT(date_issue,'%d-%m-%Y') AS T4, DATE_FORMAT(date_dlv,'%d-%m-%Y') AS T3 from dlv_dikanban_generate WHERE DI_doc = '".sql_esc($buid2)."' ";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 
	 //-----get cvendor  ----
	 
	 $query_vend = "SELECT * FROM vendor_detail WHERE vendor_code = '".sql_esc($data_bb["vc_code"])."'";
	 $result_vend = mysqli_query($dbc,$query_vend) or die (mysqli_error());
	 $data_vend = mysqli_fetch_array($result_vend);
	 
	  //-----get model  ----
	 
	 $query_model = "SELECT * FROM model_detail WHERE model_code = '".sql_esc($data_bb["model_cd"])."'";
	 $result_model = mysqli_query($dbc,$query_model);
	 $data_model = mysqli_fetch_array($result_model);
	 
	 ?>
        
        <table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
  <tr>
    <td width="56%"><img src="../set_upload/<?php echo $filename; ?>" width="350" height="40"/> </td>     
    <td width="1%">&nbsp;</td>
    <td width="43%" valign="top">&nbsp;<h5><font color="#999999"><b>INGRESS DELIVERY INSTRUCTION ORDER</b></font></h5></td>
  </tr>
  <tr>
    <td rowspan="5"><p><b>INGRESS AOI TECHNOLOGIES SDN. BHD. (1346911-U)</b></p>
    Lot 40481, Seksyen 20,<br> Mukim Bandar Serendah,<br>
    Hulu Selangor,<br> 48200 Selangor.<br>
    <p>Tel : 03-6028 3003<br>Fax: 03-6028 3004</p>
    
    </td>
    <td>&nbsp;</td>
    <td>
    <table width="450" >
  <tr>
    <td width="194"><b>Delivery Instruction No. </b></td>
    <td width="12">:</td>
    <td width="228"><?php echo $buid2;   ?></td>
  </tr>
  <tr>
    <td><b>Purchase Order No. </b></td>
    <td>:</td>
    <td><?php echo $data_bb["po_no"];   ?></td>
  </tr>
  <tr>
    <td><b>Vendor Name </b></td>
    <td>:</td>
    <td><?php echo $data_vend["vendor_name"];  ?></td>
  </tr>
   <tr>
    <td><b>Model </b></td>
    <td>:</td>
    <td><?php echo $data_bb["model_cd"];   ?></td>
  </tr>
</table>
</td>
  </tr>
       </table>
  
  <table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
    <tr>
    <td width="56%">&nbsp;</td> 
    <td width="1%">&nbsp;</td>  
    <td width="43%">
    <table width="450" >
      <tr>
        <td width="194"><b>Delivery Date</b></td>
        <td width="12">:</td>
        <td width="228"><?php echo $data_bb["T3"];   ?></td>
      </tr>
      <tr>
        <td width="194"><b>Delivery Time [ETD]</b></td>
        <td width="12">:</td>
        <td width="228"><?php echo $data_bb["time_dlv"];   ?></td>
      </tr>
    </table>
    </tr>
 
   </table><br>
  <?php
   
   $counterA = 1;
   $noA = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM dlv_dikanban_generate WHERE DI_doc = '".sql_esc($buid2)."'  GROUP BY DI_doc ORDER BY back_no ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   ?>
 <form name="frmSearch" id="frmSearch" method="post" action="" class="needs-validation"  novalidate>
 <?php
  $pend_qty = 0.000;  
   
   while($row2 = mysqli_fetch_array($result_display))
   {
?>
 <table width="98%" class="table-bordered">
 <thead bgcolor="#eeeeee">
  <tr> 
     <th>No</th>
     <th>Back No.</th>
     <th>Part No.</th>
     <th>Part Name</th>
     <th><div align="center">U/C</div></th>
     <th>Standard Packaging</th>
     <th>Kanban Order</th>
     <th><div align="center">Total Box</div></th>
  </tr>
  </thead>
  <tbody>
  <?php
  
   $query_display_det = "SELECT * FROM dlv_dikanban_generate WHERE DI_doc = '".sql_esc($buid2)."' AND status_kanban != '".sql_esc($rst_sta4["status_desc"])."' ORDER BY back_no ASC ";
   $result_display_det = mysqli_query($dbc,$query_display_det);   //run the query.
   
   while($data_display_det = mysqli_fetch_array($result_display_det)) 
	{   
  
  ?>
   <tr>
    <td width="60"><div align="center"><?php echo $noA; ?></div></td>
    <td width="150"><div align="center"><?php echo $data_display_det["back_no"]; ?></div></td>
    <td width="200"><?php echo $data_display_det["material_no"]; ?></td>
    <td width="300"><?php echo $data_display_det["material_desc"]; ?></td>
    <td width="100"><?php echo $data_display_det["usage_kanban"]; ?></td>
    <td width="100"><div align="center"><?php echo $data_display_det["std_package"]; ?></div></td>
    <td width="100"><div align="center"><?php echo intval($data_display_det["kanban_order"]); ?></div></td>
    <td width="100"><div align="center"><?php echo $data_display_det["tbox_kanban"]; ?></div></td>
    </tr>
  
 <?php 
		  
	  
		  $noA++;
		  $counterA++; // menambah counter
		  
	} //$data_display_det
		  ?>
  </tbody>
</table>
  <br>
  <?php     
       
    }      ?>       <!--  </div></div> -->
                 <!-- </div> -->
                  
    <!--  <div class="modal-footer">-->
     <br>
     <div align="left">   
      
       <input name="uid2" type="hidden" value="<?php echo $buid2; ?>">  
       <input name="date1" type="hidden" value="<?php echo $dateF; ?>">  
       <input name="date2" type="hidden" value="<?php echo $dateT; ?>">  
       <input name="vendor_code" type="hidden" value="<?php echo $vendor_code; ?>">    
      
     </div> 
     </form>
               
                
</div>
<br>


<!--button print-->
<div class="prt-button">
  <button type="button" name="btn_release" id="btn_release" class="btn btn-success btn-sm" onClick="window.print()">Print this Page</button>
</div>

</body>
</html>