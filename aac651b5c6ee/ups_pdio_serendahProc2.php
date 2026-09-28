<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
//include 'tzone-config.php';
//include 'status-config.php';

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));
$fmt_curr_time = (date("H:i:s"));
$pick_curr_time = (date("H:i a"));
$yearSkrg = (date("Y"));

         $drun = substr($fmt_curr_date,0,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,8,2);
				 
				 $date_run = ($drun.$mrun.$yrun);

set_time_limit(0);

   $url = "ups_pdio_serendah.php"; 
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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
    // include 'apprv_func_list.php';

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

	

	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
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
	$('.datepicker').pickadate({
weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
showMonthsShort: true
})
	</script>
   
<style>
th {
  cursor: pointer;
 /* background-color: coral;*/
}    
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}
</style> 
<style>
.pagin {
  display: inline-block;
}

.pagin a {
  color: black;
  float: left;
  padding: 7px 10px;
  text-decoration: none;
  border: 1px solid #ddd;
}

.pagin a.active {
  background-color: #32A478;
  color: white;
  border: 1px solid #32A478;
}

.pagin a:hover:not(.active) {background-color: #ddd;}

.pagin a:first-child {
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
}

.pagin a:last-child {
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px;
}
</style>  
<style>
input[value="+ Add Item"]{
  display:none;
}


</style>
 <style>
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
  <body class="app sidebar-mini" onload="startTime()">
    <!-- Navbar-->
     <?php   include "top_modal_menu.php";   ?>
    
   
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php   include "left_prod_menu.php";   ?>
   
    <main class="app-content">
 
         <div class="app-title">
        <div>
        <h1><i class="fa fa-th-list"></i> Delivery</h1>
          <p>Upload PDIO</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Delivery</li>
          <li class="breadcrumb-item"><a href="ups_pdio_serendah.php">Upload PDIO</a></li>
        </ul>
      </div> 

      <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="ups_pdio_serendah.php">Upload PDIO</a></li>
                 <li class="nav-item"><a class="nav-link"  href="view_pdio_serendah-dlv.php">View Upload PDIO</a></li>
               
              </ul>
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
            
      <?php
	          $buid = base64_decode($_GET["upload_id"]);
            $ship_point = base64_decode($_GET["ship_point"]);
            $cust_code = base64_decode($_GET["cust_code"]);
            $check_final = $_GET["checkB"];
			
		//	echo $buid;
 
  $extension = explode('.', $data_setup["logo_name"]);
  $filename = $data_setup["logo_comp"].'.'.$extension[1];
 
  use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;  
	
	

	 //-------------- click button "Approved"-----------------------------------------------------------------------------
  if(isset($_POST["apprv_btnPDIO"])) 
  
   { // handle the form.
   
    require 'PHPMailer/src/PHPMailer.php';
  	require 'PHPMailer/src/SMTP.php';
	require 'PHPMailer/src/Exception.php';

 
   $uid2 = $_POST["uid2"];
   $check_final2 = $_POST["checkBX"];
   $ship_point = $_POST["ship_point"];

    //----get ship point extract string -----
    $plant_dlv = substr($ship_point,0,4);
 
   include 'gen_mat_doc_PDIO.php';
   //-------------------generate PDIO doc no. ---------------
   
   

  $query_info_chk = "SELECT * FROM dlv_upload_pdio WHERE upload_id = '".sql_esc($uid2)."' AND status_pdio = '".sql_esc($rst_sta["status_desc"])."'";
  $result_info_chk = mysqli_query($dbc,$query_info_chk);


 while($data_info_chk = mysqli_fetch_array($result_info_chk))
 {

  $query_Level7 = "UPDATE dlv_upload_pdio SET status_pdio = '".sql_esc($rst_sta3["status_desc"])."' WHERE upload_id = '".sql_esc($uid2)."'";
  $result_Level7 = mysqli_query($dbc,$query_Level7);

  $query_Level8 = "UPDATE dlv_pdio_generate SET mat_doc = '".sql_esc($ref)."', status_pdio = '".sql_esc($rst_sta3["status_desc"])."' WHERE upload_id = '".sql_esc($uid2)."' ";
  $result_Level8 = mysqli_query($dbc,$query_Level8);

 }

	
   //--------- PDIO [draft] detail ------------
	 
	   $query_info5A = "SELECT * FROM dlv_upload_pdio WHERE upload_id = '".sql_esc($uid2)."' AND status_pdio = '".sql_esc($rst_sta6["status_desc"])."'";
	   $result_info5A = mysqli_query($dbc,$query_info5A);

     $count = "";
	  
	  while($data_info5A = mysqli_fetch_array($result_info5A))
	  {

$query_info_mat = "SELECT material_no, material_desc, material_cust_no, status_BOM, plant_code, BUn FROM table_material_itsb WHERE material_cust_no = '".sql_esc($data_info5A['material_no'])."' AND status_BOM = 'Y' AND plant_code = '3100'";
$result_info_mat = mysqli_query($dbc,$query_info_mat);
$data_info_mat = mysqli_fetch_array($result_info_mat);

 //-------generate dlv pdio-------------
 $query_generate = "INSERT INTO dlv_pdio_generate(id,id_gen,mat_doc,pdio_no,order_no,dlv_category,trip_no,line_no,prod_date,dlv_date,cycle_pdio,back_no,material_no,material_desc,pdio_qty,uom_pdio,created_by,date_create,update_by,date_update,status_upload,status_pdio,plant_code,upload_id,file_name,mth_plan,yr_plan,cust_code,cust_name,status_DO,material_no_cust) VALUES('','".sql_esc($data_info5A['id'])."','".sql_esc($ref)."','".sql_esc($data_info5A['pdio_no'])."','".sql_esc($data_info5A['order_no'])."','".sql_esc($data_info5A['dlv_category'])."','".sql_esc($data_info5A['trip_no'])."','".sql_esc($data_info5A['line_no'])."','".sql_esc($data_info5A['prod_date'])."','".sql_esc($data_info5A['dlv_date'])."','".sql_esc($data_info5A['cycle_pdio'])."','".sql_esc($data_info5A['back_no'])."','".sql_esc($data_info_mat['material_no'])."','".sql_esc($data_info_mat['material_desc'])."','".sql_esc($data_info5A['pdio_qty'])."','".sql_esc($data_info_mat['BUn'])."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'".sql_esc($rst_sta7["status_desc"])."','".sql_esc($rst_sta3["status_desc"])."','".sql_esc($data_info5A['plant_code'])."','".sql_esc($uid2)."','".sql_esc($data_info5A['file_name'])."','".sql_esc($data_info5A['mth_plan'])."','".sql_esc($data_info5A['yr_plan'])."','".sql_esc($data_info5A['cust_code'])."','".sql_esc($data_info5A['cust_name'])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($data_info5A['material_no'])."')";
 $result_generate = mysqli_query($dbc,$query_generate);
     


// ---------update dlv_upload_pdio--------------------------
	 
$query_LevelA = "UPDATE dlv_upload_pdio SET status_pdio = '".sql_esc($rst_sta3["status_desc"])."' WHERE upload_id = '".sql_esc($uid2)."' ";
$result_LevelA = mysqli_query($dbc,$query_LevelA);


     $count++;
	 
	  } // end while loop

    
     include 'gen_mat_doc_PDIO_cls.php';


       $query_all3 = "SELECT *, DATE_FORMAT(dlv_date,'%d-%m-%Y') AS TA3 FROM dlv_pdio_generate WHERE upload_id = '".sql_esc($uid2)."' ";
       $result_all3 = mysqli_query($dbc,$query_all3);
       $data_all3 = mysqli_fetch_array($result_all3);
       

      $date_pdiox = $data_all3['TA3'];
        
       echo "<script>";
       echo "alert('File successfully uploaded.');";
       echo "window.location='ups_pdio_serendah.php'";
       echo "</script>";
       exit(); //quit the script


   }// end submit
   

   
if(isset($_POST["back_btnPDIO"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

$buid = $_POST["uid2"];



//-----------delete all data current screen-------------
$query_delete_scan = "DELETE FROM ftp_ups_pdio WHERE upload_id = '".sql_esc($buid)."' AND user_upload = '".sql_esc($username)."'";
$result_delete_scan = mysqli_query($dbc,$query_delete_scan);

$query_delete_scan2 = "DELETE FROM dlv_pdio_generate WHERE upload_id = '".sql_esc($buid)."' AND created_by = '".sql_esc($username)."'";
$result_delete_scan2 = mysqli_query($dbc,$query_delete_scan2);


   $query_delete_scan3 = "DELETE FROM dlv_upload_pdio WHERE upload_id = '".sql_esc($buid)."' AND created_by = '".sql_esc($username)."'";
   $result_delete_scan3 = mysqli_query($dbc,$query_delete_scan3);

//---------end delete ----------------------------------



echo "<script>";
echo "window.location='ups_pdio_serendah.php'";
echo "</script>";
exit(); //quit the script


}
   
 ?>
  
     
      <?php
	 
	 $query_bb = "SELECT *, DATE_FORMAT(prod_date,'%d-%m-%Y') AS T4, DATE_FORMAT(dlv_date,'%d-%m-%Y') AS T3 from dlv_upload_pdio WHERE upload_id = '".sql_esc($buid)."' ";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 	 
	 
	 ?>
        
        <table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="350" height="40"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><font color="#999999"><!-- <b>PERODUA RECEIVING REPORT</b --></font></div></td>
    <td>&nbsp;</td>
    </tr>
  
        </table>
  <br>
 
  <?php

if($data_bb < 1)
{

  ?>
  <div class="alert alert-dismissible alert-danger">
                <button class="close" type="button" data-dismiss="alert">×</button><strong>There are no record(s) to update. Data already exist</strong>
              </div>

<?php


}
   
   $counterA = 1;
   $noA = 1;
   $sta_out = "";
   
$query_display = "SELECT *, DATE_FORMAT(prod_date,'%d-%m-%Y') AS T4, DATE_FORMAT(dlv_date,'%d-%m-%Y') AS T3 FROM dlv_upload_pdio WHERE upload_id = '".sql_esc($buid)."' ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   ?>
 <form name="frmSearch" id="frmSearch" method="post" action="" class="needs-validation"  novalidate>
 <table width="98%" class="table-bordered">
 <thead bgcolor="#eeeeee">
  <tr>
     <th><div align="center">No</div></th>
     <th><div align="center">PDIO No.</div></th>
     <th><div align="center">Delivery Category</div></th>
     <th><div align="center">Production Date</div></th>
     <th><div align="center">Delivery Date</div></th>
     <th><div align="center">Trip No.</div></th>
     <th><div align="center">Back No.</div></th>
     <th><div align="center">Part No.</div></th>
     <th><div align="center">Part Name</div></th>
     <th><div align="center">Total Order</div></th>
     <th><div align="center">UOM</div></th>
  </tr>
  </thead>
  <tbody>
  <?php
    
   while($row2 = mysqli_fetch_array($result_display))
   {

 
  
  ?>
   <tr>
    <td width="60"><div align="center"><?php echo $noA; ?></div></td>
    <td width="150"><div align="center"><?php echo $row2["pdio_no"]; ?></div></td>
    <td width="200"><div align="center"><?php echo $row2["dlv_category"]; ?></div></td>
    <td width="200"><div align="center"><?php echo $row2["T4"]; ?></div></td>
    <td width="200"><div align="center"><?php echo $row2["T3"]; ?></div></td>
    <td width="100"><div align="center"><?php echo $row2["trip_no"]; ?></div></td>
    <td width="100"><div align="center"><?php echo $row2["back_no"]; ?></div></td>
    <td width="150"><?php echo $row2["material_no"]; ?></td>
    <td width="200"><?php echo $row2["material_desc"]; ?></td>
    <td width="100"><div align="center"><?php echo intval($row2["pdio_qty"]); ?></div></td>
    <td width="100"><div align="center"><?php echo $row2["uom_pdio"]; ?></div>

  
</td>
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
     <br>
     <div align="left">
       <input name="ship_point" type="hidden" value="<?php echo $ship_point; ?>">    
       <input name="uid2" type="hidden" value="<?php echo $buid; ?>">    
       <input name="checkBX" type="hidden" value="<?php echo $check_final; ?>">    
    <input name="apprv_btnPDIO" type="submit"  class="btn btn-success btn-sm" value="SUBMIT" onclick="return confirm('Are you sure to upload?');"/>
    <input name="back_btnPDIO" type="submit"  class="btn btn-info btn-sm" value="BACK" href='ups_pdio_serendah.php?upload_id=<?php echo $buid; ?> '/>
    
     </div> 
     </form>
               
                
                  
                  
            </div>
          </div>
          
        </div>
      </div>
   </main>
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