<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

                 $drun = substr($fmt_curr_date,0,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,8,2);
				 
				 $date_run = ($drun.$mrun.$yrun);

set_time_limit(0);

   $url = "detail_DI_doc-dikanban.php"; 
	require_once('tcpdf_barcodes_2d.php');
	
	
// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
header('Location: ../index.php');
exit();
}
//-----date----
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

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
     include 'apprv_func_list.php';
	
//----------------------------------------------------

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

//CR status (Rejected)
$sta5 = "SELECT * from request_status WHERE status_id = '5'";
$sta_res5 = mysqli_query($dbc,$sta5);
$rst_sta5 = mysqli_fetch_array($sta_res5);

//CR status (Draft)
$sta6 = "SELECT * from request_status WHERE status_id = '6'";
$sta_res6 = mysqli_query($dbc,$sta6);
$rst_sta6 = mysqli_fetch_array($sta_res6);

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

//CR status (Pending Approve)
$sta15 = "SELECT * from request_status WHERE status_id = '15'";
$sta_res15 = mysqli_query($dbc,$sta15);
$rst_sta15 = mysqli_fetch_array($sta_res15);

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

//CR status (Pending Approval COO)
$sta25 = "SELECT * from request_status WHERE status_id = '25'";
$sta_res25 = mysqli_query($dbc,$sta25);
$rst_sta25 = mysqli_fetch_array($sta_res25);

//CR status (Pending Approval Exec QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

//CR status (Pending Approve STM)
$sta32 = "SELECT * from request_status WHERE status_id = '32'";
$sta_res32 = mysqli_query($dbc,$sta32);
$rst_sta32 = mysqli_fetch_array($sta_res32);


//CR status (Pending Approve ASSY)
$sta34 = "SELECT * from request_status WHERE status_id = '34'";
$sta_res34 = mysqli_query($dbc,$sta34);
$rst_sta34 = mysqli_fetch_array($sta_res34);


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
      <!----sort table https://stackoverflow.com/questions/10683712/html-table-sort/51648529---->
   <!-- <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>-->
    <!--  <script src="https://www.w3schools.com/lib/w3.js"></script>-->
	
	<SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    <script language="javascript">
document.addEventListener('DOMContentLoaded', function () {
	$('.datepicker').pickadate({
weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
showMonthsShort: true
})
	
});
</script>

<style>
/*Size : 8.27in and 11.69 inches*/


@media print{
@page{
	size: A4;
	margin: 2.0cm 1.5cm 2.5cm 1.5cm;
	margin-bottom: 0px;
}
					
@page :first {

	margin: 0.5cm 1.5cm 3.0cm 1.5cm;
    margin-bottom: 0px;
}

.prt-button 
 { 
	display: none; 
	bottom: 20px;
	margin-left: 75px;
	margin-right: 50px;
 }
 
   
}
</style>

<style>
input[value="+ Add Item"]{
  display:none;
}


</style>
 <style>
 @page{
	 padding-left: 20px;
}
	.style7 {	
	font-size: 11px;
	font-weight: bold;
	color: #000000;
	/*font-family: Arial, Helvetica, sans-serif;*/
    }
	.style17 {	
	font-size: 11px;
	color: #000000;
	
    }
	.style18 {	
	font-size: 14px;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
	text-decoration: underline;
    }
	

	</style>
    
    <script type="text/javascript">
	function print_page() {
		var ButtonControl = document.getElementById("btnprint");
		ButtonControl.style.visibility = "hidden";
		window.print();
	}
</script> 
  </head>
  <body class="app sidebar-mini">
  
       
      <div class="row">
        <div class="col-md-12">
        <div style="margin-left:20px">
        
     
      <?php
	        $buid2 = base64_decode($_GET["buid"]);
			$uid2 = base64_decode($_GET["uid"]);
			$duid2 = base64_decode($_GET["duid"]);
			$dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
         	$vendor_code = $_GET["vendor_code"]; 
		    
		
 
  $extension = explode('.', $data_setup["logo_name"]);
  $filename = $data_setup["logo_comp"].'.'.$extension[1];
 

   
   
 ?>
  
     
      <?php
	 
	 $query_bb = "SELECT *, DATE_FORMAT(date_issue,'%d-%m-%Y') AS T4, DATE_FORMAT(date_dlv,'%d-%m-%Y') AS T3 from dlv_ord_dikanban_generate WHERE DI_doc = '".sql_esc($buid2)."' AND po_no = '".sql_esc($uid2)."' AND do_no = '".sql_esc($duid2)."' GROUP BY do_no";
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
	 
	 ?>
  
     
        <table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless" >
  <tr>
    <td width="52%"><img src="../set_upload/<?php echo $filename; ?>" width="350" height="40"/> </td>     
    <td width="1%">&nbsp;</td>
    <td width="47%" valign="top">&nbsp;<h5><font color="#999999"><b>INGRESS DELIVERY INSTRUCTION ORDER</b></font></h5></td>
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
    <td><?php echo html_esc($data_bb["po_no"]);   ?></td>
  </tr>
  <tr>
    <td><b>Vendor Name </b></td>
    <td>:</td>
    <td><?php echo html_esc($data_vend["vendor_name"]);  ?></td>
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
   
$query_display = "SELECT * FROM dlv_ord_dikanban_generate WHERE DI_doc = '".sql_esc($buid2)."' AND po_no = '".sql_esc($uid2)."' AND do_no = '".sql_esc($duid2)."' " .$where_sql." ORDER BY back_no ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   ?>
 <form name="frmSearch" id="frmSearch" method="post" action="" class="needs-validation"  novalidate>
 <table width="98%" class="table-bordered">
 <thead bgcolor="#eeeeee">
  <tr> 
     <th>No</th>
     <th>Back No.</th>
     <th>Part No.</th>
     <th>Part Name</th>
     <th>DI/Kanban Quantity</th>
     <th>Delivered Quantity</th>
     <th>Outstanding Quantity</th>
     <th>Standard Packaging</th>
     <th>UoM</th>
  </tr>
  </thead>
  <tbody>
  <?php
   
   
  $pend_qty = 0.000;  
   
   while($row2 = mysqli_fetch_array($result_display))
   {

    //---- calculation quantity delivery -------
	
	 $query_qty_deli = "SELECT * FROM dlv_ord_dikanban_generate WHERE po_no = '".sql_esc($row2["po_no"])."' AND DI_doc = '".sql_esc($buid2)."' AND material_no = '".sql_esc($row2["material_no"])."' AND status_DO != '".sql_esc($rst_sta4["status_desc"])."'";
	 $result_qty_deli = mysqli_query($dbc,$query_qty_deli);
	 $num_1 = mysqli_num_rows($result_qty_deli);   //how many material are there? 
	  
	 
	   $tot_di_qty = 0.000;
	   
	   
	   while($data_qty_deli = mysqli_fetch_array($result_qty_deli)) 
	{   
		
		$tot_di_qty = $tot_di_qty + $data_qty_deli["qty_dlv"];
							
	
	}
	
	if(($tot_di_qty) > ($row2["kanban_order"]) )
	{
		
	$pend_qty = ((($row2["kanban_order"]) - ($tot_di_qty)) * (-1));
	
	}else{
	
	$pend_qty = ($row2["kanban_order"] - ($tot_di_qty));
	
	}
  ?>
   <tr>
    <td width="60"><div align="center"><?php echo $noA; ?></div></td>
    <td width="150"><div align="center"><?php echo html_esc($row2["back_no"]); ?></div></td>
    <td width="200"><?php echo html_esc($row2["material_no"]); ?></td>
    <td width="300"><?php echo html_esc($row2["material_desc"]); ?></td>
    <td width="100"><div align="center"><?php echo html_esc($row2["kanban_order"]); ?></div></td>
    <td width="100"><div align="center"> <?php echo $tot_di_qty; ?>	</div></td> 
    <td width="100"><div align="center"><?php echo intval($pend_qty);  ?></div> 
   <td width="100"><div align="center"><?php echo html_esc($row2["std_package"]); ?></div>  </td>      
    <td width="100"><div align="center"><?php echo html_esc($row2["uom_dlv"]); ?></div></td>
    </tr>
  
 <?php 
		  
	  
		  $noA++;
		  $counterA++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>

       
       
                <!--  </div></div> -->
                 <!-- </div> -->
                  
    <!--  <div class="modal-footer">-->
    <!-- <br>-->
     <div align="left">   
      
       <input name="uid2" type="hidden" value="<?php echo $buid2; ?>">  
       <input name="date1" type="hidden" value="<?php echo html_esc($dateF); ?>">  
       <input name="date2" type="hidden" value="<?php echo html_esc($dateT); ?>">  
       <input name="vendor_code" type="hidden" value="<?php echo html_esc($vendor_code); ?>">    
      
     </div> 
     <div class="prt-button">
  <button type="button" name="btn_release" id="btn_release" class="btn btn-success btn-sm" onClick="window.print()">Print this Page</button>
   </div>
     </form>
  
           </div>       
            </div>
       </div>
          
 
   
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Data table plugin-->
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
   
  </body>
</html>