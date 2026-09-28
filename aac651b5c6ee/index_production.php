<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
//include_once ('../classes/paginator.class2.php');
//require_once("../calendar/classes/tc_calendar.php");
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$nCurrentDate = (date("d-m-Y"));

$date_startApr = (date("01-m-Y"));
$date_start = (date("01-01-Y"));
$date_end = (date("d-m-Y"));

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
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	
	
$url = "index_production.php"; 

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

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

//CR status (Pending Approval Exec. QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

//CR status (Pending Approval STM)
$sta32 = "SELECT * from request_status WHERE status_id = '32'";
$sta_res32 = mysqli_query($dbc,$sta32);
$rst_sta32 = mysqli_fetch_array($sta_res32);

//CR status (Pending Approval ASSY)
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
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>

    <?php

   $query_sql = "SELECT * FROM login_detail WHERE username = '".sql_esc($username)."' and status = 'AC'";
   $result_sql = mysqli_query($dbc,$query_sql);
   $info = mysqli_fetch_array($result_sql);
    
 
    if(($info['status_pass'] == 'N'))
         {
	?>
   
    <script type="text/javascript">
jQuery(document).ready(function ($) {
    $.fancybox({
        href: "backjob_initial_pass.php?username=<?php echo html_esc($username); ?>",
        type: "iframe" // <-- whatever content image, inline, swf, etc
    });
}); // ready
</script>
   
    <?php
	 }
	  elseif(($info['expired_pass_date'] <=  $currentdate )) 
	  {

	?>
    
    <script type="text/javascript">
jQuery(document).ready(function ($) {
    $.fancybox({
        href: "backjob_reminder_pass.php?username=<?php echo html_esc($username); ?>",
        type: "iframe" // <-- whatever content image, inline, swf, etc
    });
}); // ready
</script>
  
   
    <?php
	 }
	 ?>
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
   <!-- <header class="app-header"><a class="app-header__logo" href="index_admin.php"><font face="arial" >PSS ITSB</font></a>-->
      <!-- Sidebar toggle button--><!--<a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>-->
      <!-- Navbar Right Menu-->

<!--    </header>-->
    
    <?php   include "top_modal_menu.php";   ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    
    <?php   include "left_prod_menu.php";   ?>
    
    <!--<aside class="app-sidebar">
     
    </aside>-->
    
    
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-home"></i> Home</h1>
          <p>Production Support System (PSS)</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="index_production.php">Home</a></li>
        </ul>
      </div>
      <div class="row">
      <?php
       if($data_function["f_dis_approval_h_qc"] == "Y")
      {
		  
// pending approval disposal for QC
$query_con_req = "SELECT *, DATE_FORMAT(date_disposal,'%d-%m-%Y') as R FROM disposal_detail_prd_all WHERE status_disposal = '".sql_esc($rst_sta24["status_desc"])."'  GROUP BY doc_dis ORDER BY date_posting DESC";
$rs_con_req = mysqli_query($dbc,$query_con_req);   //run the query.
$num_con_req = mysqli_num_rows($rs_con_req);   //how many material are there?

// reject disposal for QC
$query_rej_req = "SELECT * FROM disposal_detail_prd_all WHERE status_disposal = '".sql_esc($rst_sta5["status_desc"])."' AND status_approved3 = '".sql_esc($rst_sta5["status_desc"])."' AND doc_dis != '' GROUP BY doc_dis ORDER BY date_posting DESC";
$rs_rej_req = mysqli_query($dbc,$query_rej_req);   //run the query.
$num_rej_req = mysqli_num_rows($rs_rej_req);   //how many material are there?


//approval disposal for QC
$query_disposal_req = "SELECT * FROM disposal_detail_prd_all WHERE status_disposal = '".sql_esc($rst_sta3["status_desc"])."' AND doc_dis != '' GROUP BY doc_dis ORDER BY date_posting DESC";
$rs_disposal_req = mysqli_query($dbc,$query_disposal_req);   //run the query.
$num_disposal_req = mysqli_num_rows($rs_disposal_req);   //how many material are there?

//cancel disposal for QC
$query_can_req = "SELECT * FROM disposal_detail_prd_all WHERE status_disposal = '".sql_esc($rst_sta4["status_desc"])."' AND doc_dis != '' GROUP BY doc_dis ORDER BY date_posting DESC";
$rs_can_req = mysqli_query($dbc,$query_can_req);   //run the query.
$num_can_req = mysqli_num_rows($rs_can_req);   //how many material are there?






		  
//-----change status disposal
	  
	  if($row["status_disposal"] == ($rst_sta3["status_desc"]))
	{
		 if($data_setup4["bil_table"] == "4")
         {  
		 
		$sta_dis = "Approved ".$rst_apprv6["apprv_name2"];
		$dt_dis = $row["T39"]; 
		 
		 }else{
		
		$sta_dis = "Approved ".$rst_apprv8["apprv_name2"];
		$dt_dis = $row["T49"]; 
		
		 }
	
		
		
		
		
	}elseif($row["status_disposal"] == ($rst_sta5["status_desc"]))
	{
		//-------
		if($row["status_approved"] == ($rst_sta5["status_desc"]))
		{
		
		$sta_dis = "Rejected HOD Requestor";
		$dt_dis = $row["T9"]; 	
			
		}elseif($row["status_approved2"] == ($rst_sta5["status_desc"]))
		{
		
		$sta_dis = "Rejected Exec QC";
		$dt_dis = $row["T19"]; 
		
		}elseif($row["status_approved3"] == ($rst_sta5["status_desc"]))
		{
		
		$sta_dis = "Rejected HOD QC";
		$dt_dis = $row["T29"]; 
		
		}elseif($row["status_approved4"] == ($rst_sta5["status_desc"]))
		{
		
		$sta_dis = "Rejected ".$rst_apprv8["apprv_name2"];
		$dt_dis = $row["T39"]; 
		
		}
		
		
	}elseif($row["status_disposal"] == ($rst_sta15["status_desc"]))
	{
		
		$sta_dis = "Pending ".$rst_apprv2["apprv_name2"];
		//$dt_dis = $row["T"]; 
	    $dt_dis = $row["T49"]; 
		
	}elseif($row["status_disposal"] == ($rst_sta32["status_desc"]))
	{
		
		$sta_dis = "Pending ".$rst_apprv3["apprv_name2"];
		//$dt_dis = $row["T"]; 
	    $dt_dis = $row["T49"]; 
		
	}elseif($row["status_disposal"] == ($rst_sta34["status_desc"]))
	{
		
		$sta_dis = "Pending ".$rst_apprv4["apprv_name2"];
		//$dt_dis = $row["T"]; 
	    $dt_dis = $row["T49"]; 
		
	}
	elseif($row["status_disposal"] == ($rst_sta24["status_desc"]))
	{
		
		$sta_dis = "Approved Exec QC";
		$dt_dis = $row["T19"]; 
		
	}elseif($row["status_disposal"] == ($rst_sta25["status_desc"]))
	{
		
		$sta_dis = "Approved HOD QC";
		$dt_dis = $row["T29"]; 
		
	}elseif($row["status_disposal"] == ($rst_sta29["status_desc"]))
	{
		    if($row["status_part"] == "PR") 
		            { 
		
		       if($row["stamp_ind"] == "ASSY")
				{
				
				$sta_dis = "Pending Approval ".$rst_apprv4["apprv_name2"];
				$dt_dis = $row["T49"]; 	
					
				}elseif($row["stamp_ind"] == "STM")
				{
				
				
				$sta_dis = "Pending Approval ".$rst_apprv3["apprv_name2"];
				$dt_dis = $row["T49"]; 
				
				}else{ 	}
				
		  }else{
			  
			  
			$sta_dis = "Pending Approval Exec QC";   
			  
		  }
	
		
	}elseif($row["status_disposal"] == ($rst_sta25["status_desc"]))
	{
		
		$sta_dis = "Approved QC";
		$dt_dis = $row["T29"]; 
		
	}elseif($row["status_disposal"] == ($rst_sta4["status_desc"]))
	{
		
		$sta_dis = "Cancelled";
		$dt_dis = $row["T75"]; 
	}
  	  
	?>  
	   <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-check fa-3x"></i>
            <a href="dis_approve_qc-tranProc-indx.php" title="Pending Approval Disposal"><div class="info">
              <h4>Pending Approval</h4>
              <p><span class="badge badge-pill badge-primary float-right"><?php echo $num_con_req; ?></span></p>
            </div></a>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-thumbs-o-up fa-3x"></i>
              <a href="dis_approve_qc-tranProc-aprv.php?plant_code=<?php echo html_esc($info["plant_code"]);  ?>&&date1=<?php echo $date_startApr; ?>&&date2=<?php echo $date_end;  ?>&&work_center=NULL&&status_disposal=Approved" title="Approved Disposal"> <div class="info">
              <h4>Approved</h4>
              <p><span class="badge badge-pill badge-primary float-right"><?php echo $num_disposal_req; ?></span></p>
            </div></a>
          </div>
        </div>
        <!--<div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-thumbs-down fa-3x"></i>
          <a href="detail_rej_coo_disposal4-prd-aprv.php" title="Rejected Disposal" > <div class="info">
              <h4>Rejected</h4>
              <p><b><?php // echo $num_rej_req; ?></b></p>
            </div></a>
          </div>
        </div>-->
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-remove fa-3x"></i>
          <a href="canC_hqc_disposal4-prd.php" title="Cancelled Disposal">  <div class="info">
              <h4>Cancellation</h4>
              <p><b><?php //echo $num_can_req; ?></b></p>
            </div></a>
          </div>
        </div>
      
  <?php  }  //end if  ?>  
      </div>
      
      
       <div class="row">
        <div class="col-md-12 col-lg-10"> 
      <img src="../images/banner_iatsb.png" width="1100" height="750">
      </div></div> 
      
     <!--
     //---contoh submit sekali ----//
        <a href="form.php" >test</a>
    <a href="contoh_pp.php" target="_blank">test</a>
      
   
        
      </div>-->
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    

  </body>
</html>