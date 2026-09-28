<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2);
    $res = mysqli_fetch_array($result2);
	
$url = "confirm_backflush_tran_Hwok-confirm.php"; 
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
     <script>
		function startTime() {
		  var today = new Date();
		  var h = today.getHours();
		  var m = today.getMinutes();
		  var s = today.getSeconds();
		  m = checkTime(m);
		  s = checkTime(s);
		  document.getElementById('txt').innerHTML =
		  h + ":" + m + ":" + s;
		  var t = setTimeout(startTime, 500);
		}
		function checkTime(i) {
		  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
		  return i;
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
          <h1><i class="fa fa-bar-chart"></i> Production</h1>
          <p>Confirmation Handwork</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Production</li>
          <li class="breadcrumb-item"><a href="confirm_backflush_tran_Hwok-confirm.php">Confirmation Handwork</a></li>
        </ul>
      </div>  
      
       <?php
 $message_pps = "";
 $message = NULL;
 
if(isset($_POST['submit33'])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.


// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

$message = NULL; // create an empty new variable.

   
   $pps_ref = $_POST["pps_ref"];
  // $work_center = $_POST["work_center"];
   $user_no = $_POST["user_no"];
  
  
// check for a pps ref (scan from pps)
if(empty($_POST["pps_ref"]))
{ 

            $pps_ref = FALSE;
            echo "<script>";
			echo "alert('Error! Please scan Handwork Slip Tag Number');";
			echo "</script>";


  }
 

if($pps_ref) //everything ok
{  

//checking delete space semasa scanning

$pps_ref2 =trim($pps_ref);
			
 
//split dulu pps ref kpd prod_order, material,uom, plant, sloc, qty
$str = $pps_ref2;

list($part1, $part2, $part3, $part4, $part5, $part6, $part7, $part8, $part9, $part10) = (explode('|', $str, 10));


				 //--------- check for planning order x wujud------------- 
    $query_check_wujud = "SELECT * FROM pps_detail WHERE plan_no = '".sql_esc($part3)."' ";
	$result_check_wujud = mysqli_query($dbc,$query_check_wujud);
    $data_check_wujud = mysqli_fetch_array($result_check_wujud);
	
		     if($data_check_wujud["plan_no"]  > 0)
				 {
					 
				 }else{
			
				  echo "<script>";
				  echo "alert('Error! Please scan Handwork Slip Tag Number');";
				  echo "window.location='confirm_backflush_tran_Hwok-confirm.php'";
				  echo "</script>";
				  exit(); //quit the script
			 
				 }


  //--------- check for closed planning order x bleh scan pps------------- 
  /*  $query_check_pps = "SELECT * FROM pps_detail WHERE plan_no = '".$part3."'";
	$result_check_pps = mysqli_query($dbc,$query_check_pps);
    $data_check_pps = mysqli_fetch_array($result_check_pps);
	
	if(($data_check_pps["status_pps"] == "Closed") || ($data_check_pps["status_pps"] == "Transfer QC"))
	{
		
			  echo "<script>";
			  echo "alert('PPS is already Closed. Please scan the others pps.');";
			  echo "window.location='confirm_backflush_tran_Hwok-confirm.php'";
			  echo "</script>";
			  exit(); //quit the script
		
	}else{
  */
  //----shift day------
		
		if($data_check_pps["shift_pps1"] != "")
		{
			$shift_nw = "D/S";
		}elseif($data_check_pps["shift_pps2"] != "")
		{
		    $shift_nw = "N/S";
		}else{
			
		    $shift_nw = "";
		}
  
  
  
  
  $query3 = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($part6)."' ORDER BY id_work ASC";
  $result3 = mysqli_query($dbc,$query3);
  $row3 = mysqli_fetch_array($result3); 
				   
  $query_q2 = "SELECT * FROM mat_master_header WHERE material_no = '".sql_esc($part1)."'";
  $result_q2 = mysqli_query($dbc,$query_q2);
  $ans3 = mysqli_fetch_array($result_q2);
  
                 $ddP = substr($part5,0,2);
				 $mmP = substr($part5,2,2);
				 $yyP = substr($part5,4,4);
			
			     $dat_post = ($yyP.'-'.$mmP.'-'.$ddP);
				 
				 
//checking base on qty backflush Handwork-------------
			 
  $query_qA2 = "SELECT * FROM pps_detail_trn_fg_hwork WHERE bflush_no = '".sql_esc($part4)."'";
  $result_qA2 = mysqli_query($dbc,$query_qA2);
  $ans3A = mysqli_fetch_array($result_qA2);

    
				  
//insert to scan_detail
$query_db = "INSERT INTO sc_prd_planning_hwork_confirm(id_scan,pps_ref,bflush_hwork,factory,work_center,plan_no,material_no,material_desc,material_type,scan_date_plan,scan_plant,scan_shift,scan_qty,scan_uom,user_create,date_create,user_update,date_update,status_urgent,plant_cd,model_code,back_no,kanban_no) VALUES('','".sql_esc($pps_ref2)."','".sql_esc($part4)."','".sql_esc($row3["id_factory"])."','".sql_esc($part6)."','".sql_esc($part3)."','".sql_esc($part1)."','".sql_esc($ans3["material_desc"])."','".sql_esc($ans3["material_type"])."','".sql_esc($dat_post)."','".sql_esc($part2)."','".sql_esc($shift_nw)."','".sql_esc($ans3A["qty_actual"])."','".sql_esc($part8)."','".sql_esc($username)."',NOW(),'','','N','".sql_esc($part2)."','".sql_esc($part9)."','".sql_esc($part10)."','".sql_esc($ans3A["kanban_no"])."')";
$result_db = mysqli_query($dbc,$query_db);


             if($result_db)
             {
			 
			 $query_sql = "SELECT * FROM sc_prd_planning_hwork_confirm WHERE id_scan = '".mysqli_insert_id($dbc)."'";
			 $result_sql = mysqli_query($dbc,$query_sql);
			 $data_sql = mysqli_fetch_array($result_sql);
			 
			  echo "<script>";
			  echo "window.location='confirm_backflushProc_Hwok-confirm.php?uid2=".html_esc($data_sql['id_scan'])."'";
			  echo "</script>";
			  exit(); //quit the script
             }
             else 
			 {
				 
              echo "<script>";
			  echo "alert('Confirmation Backflush is failed. ');";
			  echo "</script>";
			 // exit(); //quit the script	 
				 
              mysqli_close($dbc); //close db
             }   
} // end else

	 
//}//print the message if there is one.
	  
}
?>
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Confirmation Handwork</h3>
            <div class="tile-body">
            <div class="col-form-label">
            <span class="text-info">&nbsp;<?php echo date("D M d, Y");   ?>&nbsp; <div id="txt"></div></span>
             </div>
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row col-md-10">
                  <label class="control-label col-md-3">Handwork Tag Number<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-10">
                  <input name="pps_ref" type="text" id="pps_ref" maxlength="200" value="<?php if(isset($_POST['pps_ref'])) echo html_esc($_POST['pps_ref']); ?>" class="form-control" /><div class="form-control-feedback" ><?php echo $message_pps; ?></div>
                    </div> <div class="col-md-2"><img src="../images/barcode_scan.jpeg" width="40" height="40" /></div>
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Eg: Part Number|Plant|Planned Order No.|Doc. No.|Posting Date|Line|Quantity|UoM|Model|Back No.</small>  
                    </div>
              <div class="form-group row">
                  <input name="user_no" type="hidden" value="<?php echo html_esc($res["user_no"]); ?>" />
                  <label class="control-label col-md-3"><font color="#FF0000"><b>* Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
              </div>
              
                <div class="form-group col-md-8 align-self-end">
               <input name="submit33" type="submit" id="submit33" value="NEXT" class="btn btn-success">
               <input name="Reset" type="reset" id="Reset" class="btn btn-warning" value="CANCEL">
                </div>
              </form>
            </div>
          </div>
      
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
  
  </body>
</html>