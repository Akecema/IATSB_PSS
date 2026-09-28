<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
//include '../include/config_mail.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

set_time_limit(0);

 				 $drun = substr($fmt_curr_date,2,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,6,2);
				 
				 $date_run = ($drun.$mrun.$yrun);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
//--------menu function ------------------------------

$query_function = new PreparedSql("SELECT * FROM function_acc_detail WHERE staff_ID = ?", [$res["staff_ID"]]);
$result_function = db_query($dbc, $query_function);   //run the query.
$data_function = mysqli_fetch_array($result_function);   //how many records are there?  
//----------------------------------------------------	
	
$url = "mnt_mfo-ord.php"; 

	
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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    
    
    
    <!-- jQuery library -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->

<!-- Bootstrap library -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
-->

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
  </head>
  
  <body class="app sidebar-mini">
    <!-- Navbar-->
      <?php   include "top_modal_menu.php";   ?>
    
    
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php   include "left_prod_menu.php";   ?>
  
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Material Forecast Order</h1>
          <p>Maintain MFO</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Material Forecast Order</li>
          <li class="breadcrumb-item"><a href="mnt_mfo-ord.php">Maintain MFO</a></li>
        </ul>
      </div> 
            
    <?php

 $buid2 = base64_decode($_GET["buid"]);
 
 //echo $buid2;

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';


	 $query_bb = "SELECT *, DATE_FORMAT(upload_date,'%d-%m-%Y') AS T4 from mforecast_ord_ups WHERE upload_id = '".sql_esc($buid2)."' ";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 
	 //-----get cvendor  ----
	 
	 $query_vend = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ?", [$data_bb["vendor_no"]]);
	 $result_vend = db_query($dbc, $query_vend) or die (mysqli_error());
	 $data_vend = mysqli_fetch_array($result_vend);

   

?>

    
    
            
       <?php
	   
	   $message_vcode = "";
	   $message_file = ""; 
	   $message_mfo = ""; 
	   $message_mth = "";
	   $message_yyr = "";
	
// Set the page title and include the HTML header.
//include ('templates/header.inc');

if(isset($_POST['submitMupd'])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.


// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}
// create a function for escaping the data.
function escape_data($data) {
global $dbc;   // need the connection.
if (ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysqli_real_escape_string($data,$dbc);
	}   // end function.
$message = NULL; // create an empty new variable.
   
 $fileType = $_FILES['upload']['type'];
 $allowed = array("application/pdf");
 
 $buid2 = $_POST['buid'];
 $upload_id = $_POST['upload_id'];
  
 $upload = $_FILES['upload'];
 $mfo_no = $_POST['mfo_no'];
 $vendor_no = $_POST['vendor_no'];
 $month_mfo = $_POST['month_mfo'];
 $year_mfo = $_POST['year_mfo'];
 $remark_upload = $_POST['remark_upload'];

	
// check for vendor no

	if(($_POST["vendor_no"]) == "NULL")
     {
	     $vendor_no = FALSE;
		 $message_vcode = '<span class="badge badge-pill badge-danger">Please select Vendor!</span>';
	 }else{
		 $vendor_no = TRUE;
	  }
	  
	
	
	// check for mfo no

	if(($_POST["mfo_no"]) == "")
     {
	     $mfo_no = FALSE;
		 $message_mfo = '<span class="badge badge-pill badge-danger">Please enter Material Forecast Order No.!</span>';
	 }else{
		 $mfo_no = TRUE;
		 
		 
		 
		  //check file name duplicate-----
 
            $query_chk_attach4 = "SELECT * FROM mforecast_ord_ups WHERE mfo_no = '".sql_esc($_POST["mfo_no"])."' AND mfo_no != '".sql_esc($data_bb["mfo_no"])."' AND month_mfo = '".sql_esc($data_bb["month_mfo"])."' AND year_mfo = '".sql_esc($data_bb["year_mfo"])."'";
            $result_chk_attach4 = mysqli_query($dbc,$query_chk_attach4);   //run the query.
            $data_chk_attach4 = mysqli_fetch_array($result_chk_attach4);   //how many records are there?   
			 
			 if($data_chk_attach4 >= 1 )
			 {
			    $buid2A = base64_encode($buid2); 
				
				echo "<script>";
                echo "alert('Material Forecast Order $_POST[mfo_no] already exist in database');";
                echo "window.location='edt-mtnmfo-ord.php?buid=$buid2A'";
                echo "</script>";
				exit(); //quit the script
			              		   
			   }
		 
		 
		 
	  }
	    
	  
	  // check for year mfo

	if(($_POST["year_mfo"]) == "")
     {
	     $year_mfo = FALSE;
		 $message_yyr = '<span class="badge badge-pill badge-danger">Please select Year!</span>';
	 }else{
		 $year_mfo = TRUE;
	  }
	  
	  
	   // check for month mfo

	if(($_POST["month_mfo"]) == "NULL")
     {
	     $month_mfo = FALSE;
		 $message_mth = '<span class="badge badge-pill badge-danger">Please select Month!</span>';
	 }else{
		 $month_mfo = TRUE;
	  }
	  
	  
	
  
  if($upload  && $mfo_no && $vendor_no && $year_mfo && $month_mfo) //everything ok
 { 
 
 $buid2 = $_POST['buid'];
 $upload_id = $_POST['upload_id'];
    
 
 $upload = $_FILES['upload'];
 $mfo_no = $_POST['mfo_no'];
 $vendor_no = $_POST['vendor_no'];
 $month_mfo = $_POST['month_mfo'];
 $year_mfo = $_POST['year_mfo'];
 $remark_upload = $_POST['remark_upload'];
 
 
      $query_upd = "UPDATE mforecast_ord_ups SET mfo_no = '".sql_esc($mfo_no)."', vendor_no = '".sql_esc($vendor_no)."', month_mfo = '".sql_esc($month_mfo)."', year_mfo = '".sql_esc($year_mfo)."', remark_upload = '".sql_esc($remark_upload)."', user_update = '".sql_esc($username)."', date_update = NOW() WHERE upload_id = '".sql_esc($upload_id)."' ";
	  $result_upd = mysqli_query($dbc,$query_upd);	 
 
 
  
	  if($_FILES['upload']['size'] > 0)
	  {
 
			  if(($_FILES['upload']['type']) != "application/pdf" )
			  { 
				   
				   $buid2A = base64_encode($buid2); 
			 
					echo "<script>";
					echo "alert('The document could not be moved.  File incorrect');";
					echo "window.location='edt-mtnmfo-ord.php?buid=$buid2A'";
					echo "</script>"; 
			  
			  }//if upload type
  
    //create the filename
	     $extension = explode ('.', $_FILES['upload']['name']);
		 $filetest = $_FILES['upload']['name'];
		 $filename = $mfo_no.'.'.$extension[1];
		 
		 //move the file over
		 
  	 if(move_uploaded_file($_FILES['upload']['tmp_name'], "../MFO_upload/$filename"))  {
	
		
		//---update file UId ----
		
		$query_update_scan = "UPDATE mforecast_ord_ups SET file_uid = '".sql_esc($filename)."', file_name = '".sql_esc($_FILES['upload']['name'])."', file_size = '".sql_esc($_FILES['upload']['size'])."', file_type = '".sql_esc($_FILES['upload']['type'])."' WHERE upload_id = '".sql_esc($upload_id)."'";
	    $rst_update_scan = mysqli_query($dbc,$query_update_scan);
		  
  

     }//if move_uploaded_file
 
	
		 }else{ // if file isset
		 
		 
     $query_bbA = "SELECT *, DATE_FORMAT(upload_date,'%d-%m-%Y') AS T4 from mforecast_ord_ups WHERE upload_id = '".sql_esc($upload_id)."' ";
	 $rs_bbA = mysqli_query($dbc,$query_bbA);   //run the query.
     $data_bbA = mysqli_fetch_array($rs_bbA);
		 
		 
		 
		 $filen = ($data_bbA["file_uid"]);
		
		 $extension = explode ('.', $filen);
		
		 $filenameN = $mfo_no.'.'.$extension[1];
		
	$oldname = ('../MFO_upload/'.$filen);
    $newname = ('../MFO_upload/'.$filenameN);

   rename($oldname, $newname);
 
				
				$query_update_scanA = "UPDATE mforecast_ord_ups SET file_uid = '".sql_esc($filenameN)."' WHERE upload_id = '".sql_esc($upload_id)."'";
				$rst_update_scanA = mysqli_query($dbc,$query_update_scanA);

		
		
	}// if file isset
	
	
 
 
           echo "<script>";
		   echo "alert('Material Forecast Order $mfo_no has been updated');";
		   echo "window.location='mnt_mfo-ordProc2.php?vendor_no=$vendor_no&&month_mfo=$month_mfo&&year_mfo=$year_mfo'";
	       echo "</script>"; 
		   exit(); //quit the script
			   
			} else {  //If the query did not run OK
		
		
			}
				
				
				
			// }//end elseif($data_bb["po_no"] == ($_POST["po_no"]))
			  
			//	  mysqli_close($dbc);   // close database conn
				
				
				
				} // end submitTT

?>
<?php

if(isset($_POST["submitBck"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

 $buid2 = $_POST['buid'];
 $upload_id = $_POST['upload_id'];
    
 
 $upload = $_FILES['upload'];
 $mfo_no = $_POST['mfo_no'];
 $vendor_no = $_POST['vendor_no'];
 $month_mfo = $_POST['month_mfo'];
 $year_mfo = $_POST['year_mfo'];
 $remark_upload = $_POST['remark_upload'];  

           echo "<script>";
		   echo "window.location='mnt_mfo-ordProc2.php?vendor_no=$vendor_no&&month_mfo=$month_mfo&&year_mfo=$year_mfo'";
	       echo "</script>"; 
		   exit(); //quit the script
		   
		   
}//end submitBck

?>




      
        <div class="row">
        <div class="col-md-12">
      
             <div class="tile"> <h3 class="tile-title">Maintain MFO </h3>
            <div class="tile-body">
            
  
              <form name="form1" enctype="multipart/form-data" action="edt-mtnmfo-ord.php?buid=<?php echo base64_encode($buid2); ?>" method="post" class="form-horizontal">
               <input type="hidden" name="MAX_FILE_SIZE" value="1024000000000">
                <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%">&nbsp;</th>
            </tr>
            <tr>
            <th>MFO No. : <font color="#FF0000">*</font></th>
            <td>
           <input class="form-control" id="mfo_no" type="text" placeholder="Enter MFO No." name="mfo_no" value="<?php echo $data_bb["mfo_no"]; ?>" /><div class="form-control-feedback" ><?php echo $message_mfo; ?></div>
		     </td>
             </tr>
            
             <tr>
            <th>Upload File : <font color="#FF0000">*</font></th>
            <td>                 <a href="../MFO_upload/<?php echo $data_bb["mfo_no"].".pdf"; ?>" target="_blank"><?php echo $data_bb["mfo_no"]; ?></a> <br>
            


                    <input name="upload" type="file" class="form-control-file" value="<?php if(isset($_POST['upload'])) {  echo $_POST['upload']; } ?>" maxlength="200" accept="application/pdf" /> (Format File .pdf)
                   <p>File must be less than 5MB.</br>
                  </p>
                   <div class="form-control-feedback" ><?php echo $message_file; ?></div>
             </td>
             </tr>
           <tr>
            <th>Vendor : <font color="#FF0000">*</font></th>
            <td colspan="3">
            <select name="vendor_no" class="form-control" >
                  <option value="NULL" placeholder="Select Vendor"> -- Select Vendor -- </option>
                  <?php
				  
	    	//------------- select get login vendor --------------
		$query_ath_vend2 = new PreparedSql("SELECT * FROM function_ath_vendordetail WHERE staff_ID = ?", [$res["staff_ID"]]);
		$result_ath_vend2 = db_query($dbc, $query_ath_vend2);
	
          
              while($data_ath_vend2 = mysqli_fetch_array($result_ath_vend2)) {
				  
				  
				  //----vendor detail ------
				   $query27A = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ? AND status_acc = 'Y'", [$data_ath_vend2["vendor_id"]]);
                   $result27A = db_query($dbc, $query27A);
                   $row27A = mysqli_fetch_array($result27A);			  

        
              ?>
                  <option value="<?php echo $data_ath_vend2["vendor_id"]; ?>" <?php if($data_ath_vend2["vendor_id"] == $data_bb["vendor_no"]) echo "selected"; ?>> <?php echo stripslashes($row27A["vendor_code"]); ?> - <?php echo $row27A["vendor_name"]; ?></option>
                  <?php
           }  ?>
                </select> <div class="form-control-feedback" ><?php echo $message_vcode; ?></div>
		     </td>
             </tr>
             <tr>
            <th>Month : <font color="#FF0000">*</font></th>
            <td colspan="3">
           <select name="month_mfo" class="form-control" >
                      <option value="NULL" placeholder="Select Month"> -- Select Month -- </option>
                      <?php
					  
			//------------- select get login vendor --------------
		$query_mth = "SELECT * FROM tbl_month ORDER BY id ASC";
		$result_mth = mysqli_query($dbc,$query_mth);
	
          
              while($data_mth = mysqli_fetch_array($result_mth)) {
				  
		
        
              ?>
                      <option value="<?php echo $data_mth["month_int"]; ?>" <?php if($data_mth["month_int"] == $data_bb["month_mfo"]) echo "selected"; ?> > <?php echo stripslashes($data_mth["month_descp"]); ?></option>
                      <?php
           }  ?>
                    </select><div class="form-control-feedback" ><?php echo $message_mth; ?></div>
		     </td>
             </tr>
              <tr>
            <th>Year : <font color="#FF0000">*</font></th>
            <td>
                  <select name="year_mfo" class="form-control" >
                  <option value="<?php echo $data_bb["year_mfo"]; ?>"><?php echo $data_bb["year_mfo"]; ?></option>
                
          <?php
            for ($year = 2021; $year <= 2035; $year++) {
            $selected = (isset($getYear) && $getYear == $year) ? 'selected' : '';
            echo "<option value=$year $selected>$year</option>";
            }
            ?></select><div class="form-control-feedback" ><?php echo $message_yyr; ?>		</div>     </td>
             </tr>
               <tr>
            <th>Remarks : </th>
            <td>
           <textarea cols="60" rows="5" class="form-control" id="remark_upload" type="text" placeholder="Enter Remarks" name="remark_upload"><?php if(isset($_POST['remark_upload'])) { echo $_POST['remark_upload']; }else{ echo $data_bb["remark_upload"]; }?> </textarea>
		     </td>
             </tr>
           
              <tr>
                <th>
                     <input name="upload_id" type="hidden" value="<?php echo $data_bb["upload_id"]; ?>">  
                     <input name="buid" type="hidden" value="<?php echo $buid2; ?>">  
                   
      <input name="submitMupd" type="submit"  class="btn btn-success btn-sm" value="UPDATE" onclick="return confirm('Are you sure to update?');"/>
      <input name="submitBck" class="btn btn-info btn-sm" type="submit" value="BACK" />
          </th>
                <th>&nbsp;</th>
              </tr>
            
                </table>
              
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
    
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
  
     <script type="text/javascript">
     
		  
      $('#PlanDate').datepicker({
	    defaultDate: new Date(),
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
      
	   $('#Plan2Date').datepicker({
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      $('#demoSelect').select2();
    </script>
 <script>
$('.btn_release').on('click',function(){
    $('.modal-body').load('dash_brdprod.php',function(){
        $('#myModal').modal({show:true});
    });
});
</script>
  
  
  
  </body>
</html>