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

$url = "upload_pps_month.php";


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

<style type="text/css" media="print"> 
.breakAfter{ 
page-break-after: always; 
}
.breakBefore{
page-break-before: always ;
}
.tfoot { display: table-footer-group; }
.page {
    width: 21cm;
    min-height: 29.7cm;
	page-break-after: always ;
	bottom: 0;
}
 @media print{
  body{
	margin-top: -1.9cm;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	background-color: #FFFFFF;
}
  #ad{ display:none;}
  #leftbar{ display:none;}
  #contentarea{ width:100%;}
  .header, .hide { visibility: hidden }
  .tfoot { display: table-footer-group; }
} 

</style> 

<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function printWindow() {
bV = parseInt(navigator.appVersion);
if (bV >= 4) window.print();
}
//  End -->
</script>
</head>
  <body class="app sidebar-mini">

  <?php

 $upload_id = $_GET["upload_id"];
 
 
$queryu = "SELECT *, DATE_FORMAT(MR.date_plan,'%d-%m-%Y') as T from pps_detail as MR, ftp_pps as SD WHERE MR.upload_id = SD.upload_id AND MR.upload_id = '".sql_esc($upload_id)."'";
$rs = mysqli_query($dbc,$queryu);   //run the query.

 ?>
 <div class="widget-box">
<!--<table class="table table-condensed">
<tr>
      <td width="1%">&nbsp;</td>  
      <td width="7%"><a href="javascript:parent.tb_remove(); parent.location.reload(1)" ><img src="../images/back3.jpg" width="48" height="48" /></a></td>  
      <td width="7%">&nbsp;</td>
      <td width="85%"> <div class="small-nav"></div></td>
   
  </tr>
</table>
--><br>
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Print Review </h5>
          </div>

      <br>
      
     
   <?php
    //generate Planned Order PPS
   
    $query_num_2 = "SELECT * FROM num_range_detail WHERE id_num = '1'";
    $result_num_2 = mysqli_query($dbc,$query_num_2);
	$data_num_2 = mysqli_fetch_array($result_num_2);


$query_id_2 = "SELECT MAX(plan_no) FROM pps_detail";
$result_id_2 = mysqli_query($dbc,$query_id_2);

if ($result_id_2) {
$nrows_2 = mysqli_num_rows($result_id_2);
$row_id_2 = mysqli_fetch_row($result_id_2);

 $dht_2 = $data_num_2["mat_doc_start"]; 

  if($row_id_2[0] <= 0)
  { 
   
    $lastID_2 = ($row_id_2[0] + 1);
    $dg_2 = ($dht_2 + ($lastID_2));

   }else{
      $lastID_2 = ($row_id_2[0] + 1);
      $dg_2 =  $lastID_2;
    }

	  if($dg_2 >  ($data_num_2["mat_doc_end"]))
      {
     $dht_2 = $data_num_2["mat_doc_start"]; 
	 $lastID_2 = ($row_id_2[0] + 1);
	 $dg_2 = ($dht_2 + ($lastID_2));
	 
       }
      
  $ref = ($dg_2);
		  
  } // end if $result_id
 
   if(isset($_POST['submit3'])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.


// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}
// create a function for escaping the data.
function escape_data ($data) {
global $dbc;   // need the connection.
if (ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysqli_real_escape_string($data,$dbc);
	}   // end function.
$message = NULL; // create an empty new variable.	
	

  $upload_id = $_POST["upload_id"];
  $id = $_POST["id"];
  $plan_no = $_POST["plan_no"];
  $size2 = count($_POST["id"]);
  $j = 0;
  
 // echo $size2;

	foreach($id as $key => $n ) {
		  		 
		 $query_update = "UPDATE pps_detail SET plan_no = '".sql_esc($plan_no[$j])."', user_update = '".sql_esc($username)."', date_update = NOW(), user_posting = '".sql_esc($username)."', date_posting = NOW() WHERE id = '".sql_esc($n)."'";
         $result_update = mysqli_query($dbc,$query_update);  
		 
		 $j++;
		 
		 
		 
	  }
	  
	   //update count_max----------------------------------------
	   
	   $mx_query =  mysqli_query($dbc,"SELECT max(id) FROM pps_detail");
	   $mx_data =  mysqli_fetch_array($mx_query);  
	   
	   
	  
	   $query_max_a = "UPDATE run_count_no_itsb SET count_max = '".sql_esc($mx_data)."', date_updated = NOW() WHERE uid = '1'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	 
       //end update count_max ---------------------------------	
	  
	  
  
		   echo "<script>";
		   echo "alert('Planned Order Number(s) is succefully Generated.');";
		   echo "window.location='detail_pps_sheet_printing.php?upload_id=$upload_id'";
		   //echo "window.close()";
	       echo "</script>"; 
		   exit(); //quit the script
	
}
	
	?>  
      <!-- Content -->             
  <form name="form1" action="display_pps_month.php?upload_id=<?php echo $upload_id; ?>" method="post" class="form-horizontal">
              <table class="table table-bordered">
               <thead>
                <tr>
                  <th width="40">No.</th>
                  <th width="60">Model</th>
                  <th width="73">Part No.</th>
                  <th width="122">Work Center</th>
                  <th width="90">Shift</th>
                  <th width="90">Seq #</th>
                  <th width="63">Quantity</th>
                  <th width="80">Plan Date</th>
                  <th width="80">Status</th>
                  </tr>
              </thead><tbody>
              <?php
     $counter = 1;
     $no = 1;
     $k = 0;
	 $sta = "";
	 $p = 1;
		
   while ($row = mysqli_fetch_array($rs))
   {
	

			 
			 
			  if ($k && $k % 7 == 0)  
		echo '<tr style="page-break-before:always">';  
	else if ($k)  
		echo '<tr>';  
	++$k; 
	
	if($row["shift_pps1"] != "")
	{
		$sta = "D/S";
		
	}elseif($row["shift_pps2"] != "")
	 {
		$sta = "N/S";
	 }else{
		 
		$sta = " ";
	 }
	?>
               <tr> 
                 <td width="40"><?php  echo $counter; ?></td>
                 <td width="60"><?php  echo html_esc($row["model_code"]); ?></td>
                 <td width="73"><?php  echo html_esc($row["material_no"]); ?></td>
                 <td width="122"><?php  echo html_esc($row["work_center"]); ?></td>
                 <td width="90"><div align="center"><?php  echo $sta; ?>&nbsp;</div></td>
                 <td width="90"><div align="center"><?php  echo html_esc($row["seq_pps"]); ?>&nbsp;</div></td>
                 <td width="63"><div align="center"><?php echo html_esc($row["qty_plan"]); ?></div></td>
                 <td width="80"><div align="center"><?php echo html_esc($row["T"]); ?></div></td>
                 <td width="80"><div align="center"><?php echo html_esc($row["status_pps"]); ?></div></td>
                 <input type="hidden" name="plan_no[]" value="<?php echo $ref; ?>">
                 <input type="hidden" name="id[]" value="<?php echo html_esc($row["id"]); ?>">
                 <?php 
		  	  
		     $counter++; // menambah counter 
			 $no++; 
			 $ref++;  

			   }

			   ?>
               </tr></tbody>
             </table>
             
              <input type="hidden" name="upload_id" value="<?php echo $upload_id; ?>">
             <div class="form-actions">
               <input name="submit3" type="submit" id="submit" value="GENERATE [OK]" class="btn btn-success">
               <input name="Reset" type="reset" id="Reset" class="btn btn-warning" value="CANCEL">
             </div>
             </form>
             <p>&nbsp;</p> 
             
    <?php
        mysqli_free_result($rs);  
		
		?>
 <br>
 <?php //include "footer.php";   ?>          

</div>
         </body>
</html>
