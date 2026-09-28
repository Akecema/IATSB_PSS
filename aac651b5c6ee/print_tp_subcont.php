<?php
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

$url = "can_aftp_subcontProc2.php";

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

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc,$sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

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

//CR status (Pending Approval COO)
$sta25 = "SELECT * from request_status WHERE status_id = '25'";
$sta_res25 = mysqli_query($dbc,$sta25);
$rst_sta25 = mysqli_fetch_array($sta_res25);

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

//CR status (Pending Approval Exec. QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

$buid = base64_decode($_GET["buid2"]);


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?> ">
    <title><?php echo html_esc($data_setup["comp_code"]); ?> : Document No <?php echo $buid; ?></title>
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
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    <script>
    $(document).ready(function(){
    $(document).on('click', '#btnPrint', function(){
    $('.printMe').printElem();
    });
    });
    
    </script>
<!--https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages-->
<style>
/*Size : 8.27in and 11.69 inches*/


@media print{
@page{
	size: A5 landscape;
	/*margin-top: 1.0cm;*/
	/*padding-top:2.5cm;
	padding-bottom:4.5cm;*/
	margin: 2.0cm 1.5cm 2.5cm 1.5cm ;
}

body {
   display:table;
   table-layout:fixed;
   padding-top:0.5cm;
   padding-bottom:2.5cm;
   height:auto;
}

@page :first {
	/*padding-top:1.5cm;
	padding-bottom:4.5cm;*/
	
	margin: 0.5cm 1.5cm 3.0cm 1.5cm ;

}

/* the front face */
	.face-front {
		background: #fff;
		margin-bottom: 1cm;
		top:4cm;
		bottom: 4cm;
		
	}
	
	.face-button button {
		position: fixed;
		bottom: 10px;
		right: 310px; 
		visibility:hidden;
	}

.prt-button 
 { 
	display: none; 
	bottom: 20px;
	margin-left: 75px;
	margin-right: 50px;
 }
}

@page Section1 {
size:5.8in 8.3in; 
/*margin:.10in .5in .10in .5in; 
mso-header-margin:.10in; 
mso-footer-margin:.10in; 
mso-paper-source:0;*/
}

body
{
	background-color:#FFF;
	
}
}
.style4 {
	font-size: 14px;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}
.style1 {	
	font-size: 16px;
	font-weight: bold;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}
.style10 {	
	font-size: 10px;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
	padding-bottom: 0.5cm;
}
.style11 {	
	font-family: Arial, Helvetica, sans-serif;
	font-size: 22px;
	color: #000000;
	font-weight: bold;
}
.style7 {	
	font-size: 11px;
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
	font-size: 26px;
	font-weight: bold;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
}
.style18 {	
	font-size: 14px;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
	text-decoration: underline;
}
.prt-button  {
	
	bottom: 20px;
	margin-left: 75px;
	margin-right: 50px;
}

</style>

</head>

<body class="A5 landscape">

<div class=Section1>
<center>

  <?php
  
  $buid = base64_decode($_GET["buid2"]);
	 
	 $query_bb = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T3 from tp_subcont_detail WHERE doc_tp = '".sql_esc($buid)."' GROUP BY doc_tp";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 
	 //-----user canccellation-----------
	 
	 $query_u_can = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["user_cancel"])."'"; 
	 $rs_u_can = mysqli_query($dbc,$query_u_can);   //run the query.
     $data_u_can = mysqli_fetch_array($rs_u_can);
	 
	 //------vendor detail --------
	 
	 $query_vend = "SELECT * FROM vendor_detail WHERE vendor_code = '".sql_esc($data_bb["vendor_no"])."'";
	 $rs_vend = mysqli_query($dbc,$query_vend);   //run the query.
     $data_vend = mysqli_fetch_array($rs_vend);
	 
	 //----- shift day ----------
	 
	 if($data_bb["shift_day"] == 'D/S')
	 {
		 $shft_new = "Day";
	 }else{
		 
		 $shft_new = "Night"; 
		 
	 }

		    ?>
        
        <table width="98%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td height="100" rowspan="2"><img src="../set_upload/<?php echo $filename; ?>" width="350" height="50"/> <br></td>     
    <td rowspan="2">&nbsp;</td>
    <td>&nbsp;<table width="60%"  border="1" cellspacing="2" >
    <tr>
            <td width="18%">Doc. No. </td>
            <td width="2%">:</td>
            <td width="40%">&nbsp;</td>
          </tr>
          <tr>
            <td width="18%">Rev. No.</td>
            <td width="2%">:</td>
            <td width="40%">&nbsp;</td>
          </tr>
     </table>
    
      </td>
  </tr>
  <tr>
    <td>&nbsp;<h5><font color="#999999"><b>TRANSFER TO SUBCONT</b></font></h5>
    
    
    </td>
  </tr>
   <tr>
    <td><div align="left"><b>Plant :  </b><?php echo html_esc($data_bb["plant_code"]);   ?></div></td>
    <td>&nbsp;</td> 
    <td><div align="left"><b>Document No. :  </b><?php echo html_esc($data_bb["doc_tp"]);   ?></div></td>
   <tr> 
    <td><div align="left"><b>Vendor :  </b><?php echo html_esc($data_bb["vendor_no"]);   ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Date :  </b><?php echo html_esc($data_bb["T3"]);   ?></div></td>
  </tr>
 <tr>
    <td><div align="left"><b>Driver Name :  </b><?php echo html_esc($data_bb["drv_name"]);   ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Shift :  </b><?php echo $shft_new;  ?></div></td>
  </tr>
   <tr>
    <td><div align="left"><b>Plate Number :  </b><?php echo html_esc($data_bb["plate_no"]);   ?></div></td>
    <td>&nbsp;</td>
    <td> <?php   
 if($data_bb["status_tp"] == $rst_sta4["status_desc"])
 {  ?>
 
 <div align="left"><b>Cancelled By :  </b><?php echo html_esc($data_u_can["user_fullname"]);  ?></div><?php   } ?>
 </td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  
  </table>
   <br>
 
  <?php
   
   $counterA = 1;
   $noA = 1;
   $sta_out = "";
 
 $query_display = "SELECT * FROM tp_subcont_detail WHERE doc_tp = '".sql_esc($buid)."'  AND status_tran = 'Y' ORDER BY doc_tp ASC";
$result_display = mysqli_query($dbc,$query_display);   //run the query.

   ?>
<!-- <form name="frmSearch" id="frmSearch" method="post" action="" class="needs-validation"  novalidate>
--> 
<table width="98%" class="table-bordered" cellpadding="2">
 <thead bgcolor="#eeeeee">
    <tr>
     <th>No</th>
     <th>Part No.</th>
     <th>Part Name</th>
     <th>Model</th>
     <th>Quantity</th>
     <th>Unit</th>
    </tr>
  </thead>
  <tbody>
  <?php
    
   while($row2 = mysqli_fetch_array($result_display))
   {
   ?>
	<tr>
    <td><?php echo $noA; ?></td>
    <td><?php echo html_esc($row2["material_no"]); ?></td>
    <td><?php echo html_esc($row2["material_desc"]); ?></td>
    <td><?php echo html_esc($row2["model_code"]); ?></td>
    <td><?php echo intval($row2["qty_tp"]); ?></td>
    <td><?php echo html_esc($row2["uom_tp"]); ?></td>
  </tr>
 <?php 
		  
		  $noA++;
		  $counterA++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>

     
                    
     

<!--</div>-->


</center>
</div>
<br>
<!--button print-->
<div class="prt-button">
  <button type="button" name="btn_release" id="btn_release" class="btn btn-success btn-sm" onClick="window.print()">Print this Page</button>
</div>
</body>
</html>