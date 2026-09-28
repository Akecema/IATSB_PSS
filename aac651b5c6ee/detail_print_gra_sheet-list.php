<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");

set_time_limit(0);
// include 2D barcode class (search for installation path)
require_once('tcpdf_barcodes_2d.php');


// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------		
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?>">
    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/prt-sheet.css">

    <!-- Font-icon css-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script> 
    
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    
    
    
    
    
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>

<style type="text/css">
<!--
.style3 {color: #000000}

.style4 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>

<style type="text/css" media="print"> 
	  
.breakAfter{ 
page-break-after: always; 
}
.breakBefore{
page-break-before: always ;
}
.tfoot { 
     
	 display: table-footer-group;
     margin-left: 30px;
     margin-right: 30px;

}
.page {
 size:portrait;
   margin-left: 30px;
   margin-right: 30px; 
}


 @media print{
  body{  margin-top: -0.8cm;  font-family: Arial, Helvetica, sans-serif; font-size:11px; }
  #ad{ display:none;}
  #leftbar{ display:none;}
  #contentarea{ width:90%;}
  .header, .hide { visibility: hidden }
  .tfoot { display: table-footer-group;
     margin-left: 30px;
     margin-right: 30px;
	 width:90%;
   }
  @page {size: portrait;
  margin-left: 30px;
  margin-right: 30px;
	 
  }
  .GGG {
	  
	 margin-left: 30px;
     margin-right: 30px;
	  
  }
  
  .badge badge-pill badge-light {
	  display:none;
  }
  }
 /* tr.page-break  { display: block; page-break-before: always; }  */
  .breakAfter{ 
page-break-after: always; 
}
.breakBefore{
page-break-before: always ;
}
  .prt-button 
		{ 
			display: none; 
		}
.GGG {
	  
	 margin-left: 30px;
     margin-right: 30px;
	  
  }
} 

</style>
</head>

<?php


//- First page:
$url = 'gra_tran_reprint_qc.php';

?>

<body class="app sidebar-mini">
<div class="GGG">
<br>
<?php

 $uid = (base64_decode($_GET["uid"]));
 
$queryu = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T, DATE_FORMAT(date_generate_gra,'%d-%m-%Y') AS H, DATE_FORMAT(date_return,'%d-%m-%Y') AS J from gra_qc_detail WHERE doc_gra = '".sql_esc($uid)."' GROUP BY doc_gra";
$rs = mysqli_query($dbc,$queryu);   //run the query.

 while ($db_rs = mysqli_fetch_array($rs))
   {
	   
	   
	    $mon_plan = substr($db_rs["posting_date"],5,2);		
		$tahun_plan = substr($db_rs["posting_date"],0,4);
	   
	   
	   
	   	if($mon_plan == "01")
	{
      $bulan_text = "January";
	}elseif($mon_plan == "02")
	{
	  $bulan_text = "February";
	  
    }elseif($mon_plan == "03")
	{
	  $bulan_text = "March";
	}elseif($mon_plan == "04")
	{
	  $bulan_text = "April";
	}elseif($mon_plan == "05")
	{
	  $bulan_text = "May";
	}elseif($mon_plan == "06")
	{
	  $bulan_text = "June";
	}elseif($mon_plan == "07")
	{
	  $bulan_text = "July";
	}elseif($mon_plan == "08")
	{
	  $bulan_text = "August";
	}elseif($mon_plan == "09")
	{
	  $bulan_text = "September";
	}elseif($mon_plan == "10")
	{
	  $bulan_text = "October";
	}elseif($mon_plan == "11")
	{
	  $bulan_text = "November";
	}elseif($mon_plan == "12")
	{
	  $bulan_text = "December";
	}else{
		$bulan_text = "Others";
	}
 
 $extension = explode('.', $data_setup["logo_name"]);
 $filename = $data_setup["logo_comp"].'.'.$extension[1];
 
 //--------------get filename from table  ftp_tp_gra_qc
 
 $query_ftp_pps = "SELECT * FROM ftp_tp_gra_qc WHERE doc_gra = '".sql_esc($uid)."'";
 $result_ftp_pps = mysqli_query($dbc,$query_ftp_pps);
 $data_ftp_pps = mysqli_fetch_array($result_ftp_pps);  
 
 
 //-------get address plant-----
 
 $query_plant = "SELECT * FROM company_detail WHERE plant_code = '".sql_esc($db_rs["plant_code"])."'";
 $result_plant = mysqli_query($dbc,$query_plant);
 $data_plant = mysqli_fetch_array($result_plant); 
 
  //-------get address vendor-----
 
 $query_vendor = "SELECT * FROM vendor_detail WHERE vendor_code = '".sql_esc($db_rs["vendor_no"])."'";
 $result_vendor = mysqli_query($dbc,$query_vendor);
 $data_vendor = mysqli_fetch_array($result_vendor); 
	
 ?>
<div class="page"><br>
 <table width="100%" border="1" cellpadding="2" cellspacing="2" style="table-layout:fixed">
  <tr>
    <td width="100%" height="45" colspan="3"><img src="../set_upload/<?php echo $filename;  ?>" width="250" height="50"/>
    <table width="40%" align="right" class="table-bordered">
        <tr>
          <th width="122" height="28"><div align="left">Doc No. </div></th>
          <th width="10">:</th>
          <th width="174">QR-8.3-QA.A02</th>
          </tr>
        <tr>
          <th height="36"><div align="left">Rev. No.</div></th>
          <th>:</th>
          <th>0</th>
          </tr>
      </table>     </td>
    </tr>
  <tr>
    <td width="40%" height="46"><table width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="100%">&nbsp;<?php echo html_esc($data_plant["comp_add1"]).'&nbsp;'.html_esc($data_plant["comp_add2"]).'&nbsp;'.html_esc($data_plant["comp_add3"]);  ?><br>
          &nbsp;<?php echo html_esc($data_plant["comp_postcode"]).'&nbsp;'.html_esc($data_plant["comp_city"]).'&nbsp;'.html_esc($data_plant["comp_state"]); ?><br>
          &nbsp;<?php echo html_esc($data_plant["comp_telno1"]).'&nbsp;'.html_esc($data_plant["comp_fax"]); ?>
          
          </td>
        </tr>
      
      </table></td>
    <td width="60%" colspan="2">
      <table width="50%" border="0" align="right" cellpadding="3" cellspacing="2">
      <tr>
        <td>&nbsp;
          <span class="badge badge-pill badge-light"><h5>GOODS RETURN ADVICE</h5></span>
          
          <p><span class="style3">PSS DOCUMENT NO. <?php echo $uid;  ?></span></p></td>
        </tr>
    </table></td>
    </tr>
  <tr>
    <td rowspan="4" width="40%"><table width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="100%">&nbsp;<b><?php echo html_esc($data_vendor["vendor_name"]);  ?></b><br>
          &nbsp;<?php echo html_esc($data_vendor["add_no1"]).'&nbsp;'.html_esc($data_vendor["add_no2"]);  ?><br>
          &nbsp;<?php echo html_esc($data_vendor["post_code"]).'&nbsp;'.html_esc($data_vendor["post_city"]).'&nbsp;'.html_esc($data_vendor["post_region"]).'&nbsp;'.html_esc($data_vendor["post_country"]); ?><br>
          &nbsp;<?php echo html_esc($data_vendor["tphone"]).'&nbsp;'.html_esc($data_vendor["fax_no"]); ?><br>
          &nbsp; <b>Vendor Code :<?php echo html_esc($data_vendor["vendor_code"]); ?></b> <br></td>
      </tr>
    </table></td>
    <td width="20%">Your D.O. No.</td>
    <td width="40%"><?php echo html_esc($db_rs["dlv_ord_no"]); ?> </td>
  </tr>
  <tr>
    <td width="20%">Delivery Date</td>
    <td width="40%">&nbsp;</td>
  </tr>
  <tr>
    <td width="20%">Our Order No.</td>
    <td width="40%">&nbsp;</td>
  </tr>
  <tr>
    <td width="20%">Date</td>
    <td width="40%"><span class="style3"><?php echo html_esc($db_rs["T"]); ?></span></td>
  </tr>
  </table>
<!--</div>-->
<br><?php 

	
	
	?>
      <table width="100%" class="table" style="page-break-inside:inherit">
      <thead>
        <tr>
          <th>Item</th>
          <th>Part No.</th>
          <th>Description</th>
          <th>Quantity</th>
          <th>Unit</th>
          <th>Category</th>
          <th>DO No.</th>
          <th>Remark</th>
          <th>QR Code</th>
        </tr>
      </thead>
      <tbody>
        <?php
		
	  $query_by_group = "SELECT *, DATE_FORMAT(posting_date,'%d%m%Y') AS T from gra_qc_detail WHERE doc_gra = '".sql_esc($uid)."' AND vendor_no = '".sql_esc($db_rs["vendor_no"])."'";
      $result_by_group = mysqli_query($dbc,$query_by_group);   //run the query.
		
		
      $counter = 1;
      $no = 1;
	  $i = 1;
	  
	$datarows = 0;
	$datatotal = 5; //total row per header
	
	
	
   
   while($row = mysqli_fetch_array($result_by_group))
   {
		
 $no = sprintf('%03d', $no);
	if($row["stamp_ind"] == "STM")
	{
		$sta = "STAMPING";
		
	}elseif($row["stamp_ind"] == "ASSY")
	 {
		$sta = "ASSEMBLY";
	 }elseif($row["stamp_ind"] == "TRN")
	 {
		$sta = "TRANSIT";
	 }elseif($row["stamp_ind"] == "BLK")
	 {
		$sta = "BLANKING";
	 }else{
		 
		$sta = "";
	 }	
 
      //-------get issued detail----
	  
	  $query_issue = "SELECT * FROM user_detail WHERE username = '".sql_esc($row["user_generate_gra"])."'";
	  $result_issue = mysqli_query($dbc,$query_issue);
	  $data_issue = mysqli_fetch_array($result_issue);	
	  
	   //-------get return detail----
	  
	  $query_return = "SELECT * FROM user_detail WHERE username = '".sql_esc($row["return_by"])."'";
	  $result_return = mysqli_query($dbc,$query_return);
	  $data_return = mysqli_fetch_array($result_return);	
	  
	  //---------get material header---------
	   
	    $query_mat_h = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($row['material_no'])."'";
		$result_mat_h = mysqli_query($dbc,$query_mat_h);
		$data_mat_h = mysqli_fetch_array($result_mat_h);	
		
			
		
		if ($i && $i % 5 == 0)  
		{
		echo '<tr style="page-break-after:always">'; 
		}elseif ($i)
		{  
		echo '<tr>';  
		
	   // ++$i; 
		}
		 ?>
        
        <td width="60" height="28"><?php  echo $no; ?></td>
        <td width="150" height="28"><b><?php  echo html_esc($row["material_no"]); ?></b></td>
        <td width="300"><?php  echo html_esc($row["material_desc"]); ?></td> 
        <td width="69" height="28"><div align="center"><?php  echo intval($row["qty_gra"]); ?></div></td> 
        <td width="55" height="28"><div align="center"><?php  echo html_esc($row["uom_gra"]); ?></div></td>
        <td width="151" height="28"><?php echo $sta; ?></td>
        <td width="150" height="28"><?php echo html_esc($row["dlv_ord_no"]); ?></td>
        <td width="130"><?php  echo html_esc($row["remark_gra"]); ?></td>
        <td width="150" height="28"> <div align="center">
       <?php

// set the barcode content and type

$bar_text = ($row["material_no"].'|'.$row["plant_code"].'|'.$row["plan_no"].'|'.$row["doc_gra"].'|'.$row["T"].'|'.$row["sloc_from"].'|'.$row["qty_gra"].'|'.$row["uom_gra"].'|'.$row["gr_doc_no"].'|'.$row["dlv_ord_no"]);

$barcodeobj = new TCPDF2DBarcode($bar_text, 'QRcode');
echo $barcodeobj->getBarcodeSVGcode(3.0, 3.0, 'black');

?>
                  </div></td>
          </tr>
        <?php 
	         $datarows++;  
		     $counter++; // menambah counter 
			 $no++;
			 ++$i; 
			   
			   }
	
			   ?>
           
      </tbody>
    </table>
    
   
    <table width="100%" border="1" cellspacing="1" cellpadding="1">
    <tr>
    <td width="32%"><table width="90%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="32%"><div align="center">Issued by<br><br>______________________________________</div></td>
      </tr>
      <tr>
        <td width="32%"><div align="center">Q.A</div><br>
        <div align="left">Name :  &nbsp;<span class="style5"><?php if($db_rs["user_generate_gra"] != "") { echo html_esc($data_issue["user_fullname"]);   } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
        Date :  &nbsp;<span class="style5"><?php if($db_rs["H"] != "00-00-0000") { echo html_esc($db_rs["H"]);  } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div></td>
      </tr>
    </table></td>
    <td width="32%"><table width="90%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td width="32%"><div align="center">Returned by
          <br>
          <br>
          ______________________________________</div></td>
      </tr>
      <tr>
        <td width="32%"><div align="center">Store</div>
          <br>
          <div align="left">Name :  &nbsp;<span class="style5"><?php if($db_rs["return_by"] != "") { echo html_esc($data_return["user_fullname"]);  } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
            Date :  &nbsp;<span class="style5"><?php if($db_rs["J"] != "00-00-0000") { echo html_esc($db_rs["J"]);  } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div></td>
      </tr>
    </table></td>
   <td width="32%"><table width="98%" border="0" cellspacing="2" cellpadding="3">
      <tr>
        <td>Received by &nbsp;&nbsp;  ______________________________________</td>
      </tr>
      <tr>
        <td>Lorry No. &nbsp;&nbsp;&nbsp;  ______________________________________</td>
      </tr>
      <tr>
        <td>I/C No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_______________________________________</td>
      </tr>
    </table>
   
   
   </td>
   </tr>
   </table>

<?php   
 } // end while loop main  


 ?> <!-- <div class="breakBefore">break
</div>
-->
  
  
    </div><br> 

<div class="prt-button">
  <button type="button" name="btn_release" id="btn_release" class="btn btn-success btn-sm" onClick="window.print()">Print this Page</button>
</div>



</div>


</body>
</html>
