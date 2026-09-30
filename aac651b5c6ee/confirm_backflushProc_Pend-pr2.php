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
    $result2 = db_query($dbc, $query2);
    $res = mysqli_fetch_array($result2);
	
    $url = "confirm_backflush_tran_Pend.php"; 
	
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
          <h1><i class="fa fa-file-text-o"></i> Backflush</h1>
          <p>Confirm Backflush (Pending)</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Backflush </li>
          <li class="breadcrumb-item"><a href="confirm_backflush_tran_Pend.php">Confirm Backflush (Pending)</a></li>
        </ul>
      </div> 
            
              
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
      <?php
	   
	   $uid2 = base64_decode($_GET["uid"]);
	   $buid2 = base64_decode($_GET["buid"]);
	
	  // echo $buid2;   echo "<br>";  echo $uid2;
	  
	   $query_scan = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as B FROM pps_detail_trn_fg_pending WHERE bflush_no = '".sql_esc($buid2)."' AND id_scan = '".sql_esc($uid2)."'";
	   $result_scan = mysqli_query($dbc,$query_scan);
	   $data_scan = mysqli_fetch_array($result_scan);
	   
	   $date_arini = date('Y-m-d'); 
	   $current_date = date('Y-m-d H:i:s'); 
	   $next_date = date('Y-m-d H:i:s', strtotime($current_date .' +2 day'));
	   
	      
	$message_bcode = ""; 
	$message_qpend = "";  
	
	
	   
	   //--------------------------------------------------------------------------
   if((isset($_POST["con_bfpend2"])) && $_POST!=="") 
   { // handle the form.
	   
	   $uid2 = $_POST["uid2"];
	   $buid2 = $_POST["buid2"];
	   
	   $query_scan2 = "SELECT * FROM pps_detail_trn_fg_pending WHERE bflush_no = '".sql_esc($buid2)."' AND id_scan = '".sql_esc($uid2)."'";
	   $result_scan2 = mysqli_query($dbc,$query_scan2);
	   $data_scan2 = mysqli_fetch_array($result_scan2);
	   
	    //-------update status "Released" to "Inprogress" in table pps_detail	
	
	$query_upd_detail = "UPDATE pps_detail SET user_posting = '".sql_esc($username)."', date_posting = NOW(), status_pps = '".sql_esc($rst_sta7["status_desc"])."' WHERE plan_no = '".sql_esc($data_scan2["plan_no"])."' AND status_pps != '".sql_esc($rst_sta4["status_desc"])."' ";
	$result_upd_detail = mysqli_query($dbc,$query_upd_detail);
	 
	  //-------update status "Draft" to "Inprogress" in table pps_detail_trn_fg_ok	
	 
	$query_upd_detail2 = "UPDATE pps_detail_trn_fg_pending SET user_update = '".sql_esc($username)."', date_update = NOW(), status_pps = '".sql_esc($rst_sta7["status_desc"])."' WHERE bflush_no = '".sql_esc($buid2)."' AND id_scan = '".sql_esc($uid2)."' ";
	$result_upd_detail2 = mysqli_query($dbc,$query_upd_detail2); 

  $qry = mysqli_query($dbc,"SELECT *, DATE_FORMAT(date_posting,'%d%m%Y') AS R, DATE_FORMAT(date_create,'%Y-%m-%d') AS R2, DATE_FORMAT(date_create,'%H:%i:%s') AS R3 FROM pps_detail_trn_fg_pending WHERE bflush_no = '".sql_esc($buid2)."' AND status_pps != '".sql_esc($rst_sta6["status_desc"])."'");
  $data = "";
  while($row = mysqli_fetch_array($qry)) {
    
    $qty_nw = (intval($row['qty_actual']));
    
     //-----FINISH GOODS (2300)---------
    
    if($row["material_type"] == "Z301")	
    {		
    
    $data .= $row['bflush_no'].";".$row['R'].";".$row['material_no'].";".$qty_nw.";".$row['plan_no'].";".$row['plant_code'].";131;".$row['ploc']."\r\n";
    
    }elseif($row["material_type"] == "Z201")
    {
     $data .= $row['bflush_no'].";".$row['R'].";".$row['material_no'].";".$qty_nw.";".$row['plan_no'].";".$row['plant_code'].";131;".$row['ploc']."\r\n";
      
    }else{
      
    $data .= $row['bflush_no'].";".$row['R'].";".$row['material_no'].";".$qty_nw.";".$row['plan_no'].";".$row['plant_code'].";131;".$row['ploc']."\r\n";
      
    }
    
    
    
    
       
  }
  
  $filen="BF".$buid2;
  //$csv_filename = $filen."_".date("YmdHis",time());
  
  $file = "../FromPortal/BF_PENDING/".$filen.".csv";
  //chmod($file, 0777);
  file_put_contents($file,$data);
     
     
      //----colect data --------------
    $query_collect = "SELECT *, DATE_FORMAT(A1.date_posting,'%Y-%m-%d') AS M FROM pps_detail_trn_fg_pending AS A1, sc_prd_planning_pending AS A2 WHERE A2.id_scan = A1.id_scan AND A1.bflush_no = '".sql_esc($buid2)."' AND status_pps != '".sql_esc($rst_sta6["status_desc"])."'";
    $rst_collect = mysqli_query($dbc,$query_collect);
    $data_collect = mysqli_fetch_array($rst_collect);
  
   
       //--------insert into table ftp_bflush_detail
    
       $query_ftp_info = "INSERT INTO ftp_bflush_detail_fg_pending(id,file_name,bflush_no,ref_id,plan_no,material_no,material_desc,qty_ftp,uom,status_ftp,posting_date,posting_time,user_create,date_create,plant_code,stamp_ind) VALUES('','".sql_esc($filen)."','".sql_esc($buid2)."','".sql_esc($data_collect["ref_id"])."','".sql_esc($data_collect["plan_no"])."','".sql_esc($data_collect["material_no"])."','".sql_esc($data_collect["material_desc"])."','".sql_esc($data_collect["qty_actual"])."','".sql_esc($data_collect["scan_uom"])."','Y','".sql_esc($data_collect["M"])."','".sql_esc($data_collect["time_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($data_collect["plant_code"])."','".sql_esc($data_collect["material_type"])."')"; 
       $rst_ftp_info = mysqli_query($dbc,$query_ftp_info);
     
	
	       $ref11 =	base64_encode($buid2);
		     $uid22 =	base64_encode($uid2);	
		   
		  // $buid2 = $_POST["buid2"];  
	
	       echo "<script>";
		     echo "alert('Your transaction has been processed successfully');";
		     echo "window.location='ftp_bflush_SAP_pend.php?buid=$ref11&&uid=$uid22'";
	       echo "</script>"; 
		     exit(); //quit the script

	  
	  
   }//end submit
	   
	 if(isset($_POST["conf_BACK"])) 
   { // handle the form.
   
       $uid2 = $_POST["uid2"];
	   $buid2 = $_POST["buid2"];
	   
	   $query_scan2 = "SELECT * FROM pps_detail_trn_fg_pending WHERE bflush_no = '".sql_esc($buid2)."' AND id_scan = '".sql_esc($uid2)."'";
	   $result_scan2 = mysqli_query($dbc,$query_scan2);
	   $data_scan2 = mysqli_fetch_array($result_scan2);
	   
	 
	  //-------update status "Draft" to "Inprogress" in table pps_detail_trn_fg_ok	
	 
	$query_upd_detail2 = "UPDATE pps_detail_trn_fg_pending SET user_update = '".sql_esc($username)."', date_update = NOW(), status_pps = '".sql_esc($rst_sta6["status_desc"])."' WHERE bflush_no = '".sql_esc($buid2)."' AND id_scan = '".sql_esc($uid2)."'";
	$result_upd_detail2 = mysqli_query($dbc,$query_upd_detail2);  
	
	
	  //-------print tag jadi plan no ""
	  
	$query_upd_detail3 = "UPDATE print_tag_bf_pending SET plan_no = '', status_bf = '".sql_esc($rst_sta6["status_desc"])."' WHERE bflush_no = '".sql_esc($buid2)."' AND plan_no = '".sql_esc($data_scan2["plan_no"])."'";
	$result_upd_detail3 = mysqli_query($dbc,$query_upd_detail3);  
	
	
	
				echo "<script>";
				echo "window.location='confirm_backflushProc_Pend.php?uid2=$uid2';"; 
				echo "</script>";
				exit(); //quit the script	
   
   
   }
	        
	   
	

   //------------------------------------------------------------------------------

		 $no = 1; 
		 
		 //------------plant code detail -------------
		 
		 $query_plant = new PreparedSql("SELECT * FROM plant_detail WHERE plant_code = ?", [$data_scan["plant_code"]]);
		 $result_plant = db_query($dbc, $query_plant);
	     $data_plant = mysqli_fetch_array($result_plant);
		  
		  ?>        
        <form name="myform" method="post" action="confirm_backflushProc_Pend-pr2.php?uid2=<?php echo $uid2; ?>">
        <table width="100%" border="0" cellpadding="2">
     <tr>
       <td width="52%" height="234"><p>Please confirm your backflush PENDING details:
         <table width="95%" border="1" align="right" cellpadding="2" class="table-condensed"> 
         <tr>
             <th scope="row"><div align="left">Plant</div></th>
             <td>:</td>
             <td><?php echo html_esc($data_plant["plant_desc"]); ?></td>
            </tr>
           <tr>
             <th scope="row"><div align="left">Back No.</div></th>
             <td>:</td>
             <td><?php echo html_esc($data_scan["back_no"]); ?></td>
            </tr>
            <tr>
             <th scope="row"><div align="left">Part Number</div></th>
             <td>:</td>
             <td><?php echo html_esc($data_scan["material_no"]); ?></td>
             </tr>
            <tr>
             <th scope="row"><div align="left">Part Name</div></th>
             <td>:</td>
             <td><?php echo html_esc($data_scan["material_desc"]); ?></td>
             </tr>
              <tr>
             <th scope="row"><div align="left">Backflush Quantity</div></th>
             <td>:</td>
             <td><?php echo intval($data_scan["qty_actual"]); ?></td>
             </tr>
              <tr>
             <th scope="row"><div align="left">Reason for Pending</div></th>
             <td>:</td>
             <td><?php echo html_esc($data_scan["remark_pend"]); ?></td>
             </tr>
             <tr>
             <th scope="row"><div align="left">Posting Date</div></th>
             <td>:</td>
             <td><?php echo html_esc($data_scan["B"]); ?></td>
             </tr>
              <tr>
             <th width="33%"><div align="left">Posting Time</div></th>
             <td width="5%"> :</td>
             <td width="62%"><?php echo html_esc($data_scan["time_posting"]); ?></td>
             </tr>
              <tr>
             <th width="33%"><div align="left">Planned Order</div></th>
             <td width="5%"> :</td>
             <td width="62%"><?php echo html_esc($data_scan["plan_no"]); ?></td>
             </tr>
             <tr>
             <th scope="row"><div align="left">Line</div></th>
             <td>:</td>
             <td><?php echo html_esc($data_scan["work_center"]); ?></td>
             </tr>
           </table></td>
       <td width="48%">
        <!-- <table width="95%" border="0" align="center" cellpadding="2">
           <tr>
             <td><span class="style4">&nbsp;<?php //echo date("D M d, Y");   ?></span>&nbsp;&nbsp;<span class="style5"><?php //echo date("h:i:s");  ?></span></td>
             </tr>
           <tr>
             <td><p>&nbsp;</p>
               <p>&nbsp;</p>
               <p>&nbsp;</p>
               <p>&nbsp;</p>
               <p>&nbsp;</p>
               <p>&nbsp;</p></td>
             </tr>
           
           </table>--></td>
     </tr>
     </table> 
   
        
  <br>   
             
             <table>
             <tr>
                     <td>&nbsp;
                     <input class="form-control" id="uid2" type="hidden"  name="uid2" value="<?php echo $uid2;   ?>" />
                     <input class="form-control" id="buid2" type="hidden"  name="buid2" value="<?php echo $buid2;   ?>" /> 
                     <input name="con_bfpend2" type="submit" id="con_bfpend2" value="CONFIRM" class="btn btn-success btn-sm" onClick="return confirm('Are you sure?Confirm backflush activity?');"></td>
                      <td>&nbsp;</td>
                      <td width="40%">&nbsp;<input name="conf_BACK" type="submit" id="conf_BACK" value="BACK" class="btn btn-warning btn-sm"  ></td>
                      <td width="40%">&nbsp;</td>
                     </tr>
             </table>
        </form>
 
     
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
    <!-- Data table plugin-->
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    <script type="text/javascript">
      $('#sl').on('click', function(){
      	$('#tl').loadingBtn();
      	$('#tb').loadingBtn({ text : "Signing In"});
      });
      
      $('#el').on('click', function(){
      	$('#tl').loadingBtnComplete();
      	$('#tb').loadingBtnComplete({ html : "Sign In"});
      });
      
      $('#PSSDate').datepicker({
		defaultDate: new Date(),
		format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
	   $('#PSS2Date').datepicker({
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
    </script>
  
  </body>
</html>