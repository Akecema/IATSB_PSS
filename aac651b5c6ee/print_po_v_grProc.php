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

$url = "detail_GR_doc-receive.php";

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

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc,$sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

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

$buid = base64_decode($_GET["buid"]);


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?> ">
    <title><?php echo $data_setup["comp_code"]; ?> : Document No <?php echo $buid; ?></title>
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
  
  $buid = base64_decode($_GET["buid"]);
  $plant_code = $_GET["plant_code"];
  $dateF = $_GET["date1"];
  $dateT = $_GET["date2"];
  $vendor_no = $_GET["vendor_no"]; 

  
  $ddF = substr($_GET["date1"],0,2);
  $mmF = substr($_GET["date1"],3,2);
  $yyF = substr($_GET["date1"],6,4);

  $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
  
  
  $ddT = substr($_GET["date2"],0,2);
  $mmT = substr($_GET["date2"],3,2);
  $yyT = substr($_GET["date2"],6,4);

  $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);

//1. Plant Code
 if (($plant_code == "") || ($plant_code == "NULL")){ 
	 $wheresql_01 = ""; }
 else {
	 $wheresql_01 = " AND plant_code = '".sql_esc($plant_code)."'"; }  	
	 
// 3. dateF
 if ($dateF == "0000-00-00" ){
	 $wheresql_03 = ""; }
 else {
	 $wheresql_03 = " AND (posting_gr >= '".sql_esc($date1_final)."')"; }      
								 
	 
//4. DateT
 if ($dateT == "0000-00-00" ){
	 $wheresql_04 = ""; }
 else {
			   $wheresql_04 = " AND (posting_gr <= '".sql_esc($date2_final)."')"; }
			 

		 $where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04;

//********** END CONDITION **************

	 	 
	 $query_bb = "SELECT *, DATE_FORMAT(posting_gr,'%d-%m-%Y') AS T3 from po_detail_trans_gr WHERE purc_ord_no = '".sql_esc($buid)."' " .$where_sql." GROUP BY doc_gen";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 //----get vendor detail -----
	 
	 $query_vend = "SELECT * FROM vendor_detail WHERE vendor_code = '".sql_esc($data_bb["vendor_id"])."'";
	 $result_vend = mysqli_query($dbc,$query_vend); 
	 $data_vend = mysqli_fetch_array($result_vend);

	 //-----user canccellation-----------
	 
	 $query_u_can = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["user_cancel"])."'"; 
	 $rs_u_can = mysqli_query($dbc,$query_u_can);   //run the query.
     $data_u_can = mysqli_fetch_array($rs_u_can);
	 
	 
	  //-----shift-----
	   
	   if($data_bb["shift_gr"] == "D/S")
	   {
		   $shift_ds = "Day";
	   }elseif($data_bb["shift_gr"] == "N/S")
	   {
		 $shift_ds = "Night";
	   }else{
		   
		   $shift_ds = "NA"; 
	   }

		    ?>
       <br>     
        <form name="frmDisplay" id="frmDisplay" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" >     
  <table width="98%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="350" height="50"/> </td>     
    <td>&nbsp;</td>
    <td>&nbsp;<h5><font color="#999999"><b>DISPLAY PO VS GR (QUANTITY)</b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>Plant :  </b><?php echo $data_bb["plant_code"];   ?></div></td>
    <td>&nbsp;</td> 
	<td>&nbsp;</td> 
   <tr> 
    <td><div align="left"><b>Purchase Order No. :  </b><?php echo $data_bb["purc_ord_no"];   ?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><b>Delivery Order No. :  </b><?php echo $data_bb["dlv_ord_no"];   ?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td><div align="left"><b>Vendor : </b> <?php echo $data_bb["vendor_id"];   ?> - <?php echo $data_vend["vendor_name"]; ?></div></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  </table>      
 
   <br>
 
 <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM po_detail_trans_gr WHERE purc_ord_no = '".sql_esc($buid)."' " .$where_sql." GROUP BY material_no ORDER BY doc_gen ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   ?>
 
 <table width="98%" class="table-bordered">
 <thead bgcolor="#eeeeee">
  <tr>
     <th>No</th>
     <th>Part No.</th>
     <th>Part Name</th>
     <th>Model</th>
     <th>PO Quantity</th>
     <th>GR Quantity</th>
     <th>Balance</th>
     <th>Unit</th>
    </tr>
  </thead>
  <tbody>
  <?php
    
   while($row2 = mysqli_fetch_array($result_display))
   {

  //-----shift-----
	   
	   if($row2["shift_gr"] == "D/S")
	   {
		   $shift_ds2 = "Day";
	   }elseif($row2["shift_gr"] == "N/S")
	   {
		 $shift_ds2 = "Night";
	   }else{
		   
		   $shift_ds2 = "NA"; 
	   }

       //--------- Checking delivery order whether it has been fully received or not.-----------	 
 $tot_gr_qtyB = 0.000;
 $tot_rec_qtyA = 0.000;
 $tot_grd_qtyA  = 0.000;	
 $Grd_total_new_bal = 0.000;
 
 
 $query_check_Trcv = "SELECT * FROM dlv_ord_dikanban_generate WHERE do_no = '".sql_esc($row2['dlv_ord_no'])."' AND  status_DO = '".sql_esc($rst_sta14["status_desc"])."' AND material_no = '".sql_esc($row2["material_no"])."'";
 $result_check_Trcv = mysqli_query($dbc,$query_check_Trcv);
   
 while($data_check_Trcv = mysqli_fetch_array($result_check_Trcv))
 {
 
 
 $tot_grd_qtyA = $tot_grd_qtyA + $data_check_Trcv["qty_dlv"];
 
 }
 

 
 //dlv_ord_dikanban_generate
 //--------------Update 7 April 2022-------		 
   $query_check_Prcv = "SELECT * FROM po_detail_trans_gr WHERE purc_ord_no = '".sql_esc($row2['purc_ord_no'])."' AND status_gr = '".sql_esc($rst_sta3["status_desc"])."' AND material_no = '".sql_esc($row2["material_no"])."'";
 $result_check_Prcv = mysqli_query($dbc,$query_check_Prcv);
   
 while($data_check_Prcv = mysqli_fetch_array($result_check_Prcv))
 {
   
   
   $tot_gr_qtyB = $tot_gr_qtyB + $data_check_Prcv["gr_qty"];
     
   
 }



if($tot_gr_qtyB != 0.000)
	{
	 
$Grd_total_new_bal = (($row2["po_qty"] ) - ($tot_gr_qtyB));

}else{

$Grd_total_new_bal = ($row2["po_qty"] );
  
}
  
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $row2["material_no"]; ?></td>
    <td><?php echo $row2["material_desc"]; ?></td>
    <td><?php echo $row2["model_gr"]; ?></td>
    <td><?php echo $row2["po_qty"]; ?></td>
	<td><?php echo number_format($tot_gr_qtyB,3); ?></td>
    <td><?php echo number_format($Grd_total_new_bal,3); ?></td>
    <td><?php echo $row2["ord_uom"]; ?></td>
  </tr>
  
 <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>

  

</form>
     
                    
     

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