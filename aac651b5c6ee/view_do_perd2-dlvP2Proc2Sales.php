<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

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

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	
	
$url = "crt_do_perd2-dlvP2Sales.php"; 

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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
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
          <h1><i class="fa fa-th-list"></i> Delivery</h1>
          <p>View DO Perodua Sales</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Delivery</li>
          <li class="breadcrumb-item"><a href="view_do_perd2-dlvP2Sales.php">View DO Perodua Sales</a></li>
        </ul>
      </div> 
      
              <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link"  href="crt_do_perd2-dlvP2Sales.php">Create New </a></li>
                 <li class="nav-item"><a class="nav-link active"  href="view_do_perd2-dlvP2Sales.php">View DO Perodua Sales</a></li>
               
              </ul>
       
          <?php
		    
			$material_doc_gen = $_GET['material_doc_gen'];
            $ship_point = $_GET['ship_point'];
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
				
			
		  ?>    
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">View Delivery Order - Perodua Sales</h3>
            <div class="tile-body">
         
           <form action="" method="get" name="frmSearch" id="frmSearch">
           <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="2">&nbsp;</th>
            </tr>
             <tr>
                <th>DI/PDIO Number : </th>
                <th colspan="2">
           <input class="form-control" id="material_doc_gen" type="text" placeholder="Enter DI/PDIO Number" name="material_doc_gen" value="<?php echo html_esc($_GET['material_doc_gen']); ?>" /> 
            <!-- <div id="result"></div>-->
               </th>
              </tr>
            <tr>
            <th>Ship to Party : </th>
            <td colspan="2">
           <input class="form-control" id="ship_point" type="text" placeholder="Enter Ship to Party" name="ship_point" value="<?php echo "100002";  ?>" readonly />
		     </td>
             </tr>
               <tr>
                <th>Delivery Date from :  </th>
                <td colspan="3"> 
				
				<?php
			     $dd1 = substr($_GET["date1"],8,2);
				 $mm1 = substr($_GET["date1"],5,2);
				 $yy1 = substr($_GET["date1"],0,4);
			    ?>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" >                  
                    </td></tr>
                <tr>
                <th>Delivery Date to :  </th>
                <td colspan="3">
				<?php
			     $dd2 = substr($_GET["date2"],8,2);
				 $mm2 = substr($_GET["date2"],5,2);
				 $yy2 = substr($_GET["date2"],0,4);
			    ?>
             <input class="form-control" id="PSSDate2" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>" ></td>
              </tr>
              <tr>
                <th><input name="submitCT" type="submit" class="btn btn-info" id="button" value="SEARCH" /></th>
                <th colspan="2">&nbsp;</th>
              </tr>
            
                </table>
        </form> 
        
        <?php
         //-------Count all results------------------------//
			
				 $where_sql = '';
   
	             $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);
				 
				 
				 		
		 // 1. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND (dlv_date >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 2. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (dlv_date <= '".sql_esc($date2_final)."')"; } 
					
		 //3. Sales Order Number
                if ($material_doc_gen == ""){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND pdio_no = '".sql_esc($material_doc_gen)."'"; } 
					
          //4. Shipping Point
                if ($ship_point == "" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND ship_point = '".sql_esc($ship_point)."'"; }	 	 
	    
		
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04;	
	
	//********** END CONDITION **************
	
   $query8 = "SELECT COUNT(*) FROM dlv_ord_all_delivery WHERE (status_DO = '".sql_esc($rst_sta3["status_desc"])."' OR status_DO = '".sql_esc($rst_sta4["status_desc"])."') " .$where_sql;
   $result8 = mysqli_query($dbc,$query8);
   $num_rows = mysqli_num_rows($result8);
            
		
	$query = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as R, DATE_FORMAT(dlv_date,'%d-%m-%Y') as R8 FROM dlv_ord_all_delivery WHERE (status_DO = '".sql_esc($rst_sta3["status_desc"])."' OR status_DO = '".sql_esc($rst_sta4["status_desc"])."') " .$where_sql." GROUP BY material_doc_gen ORDER BY so_no ASC ";
	$rs = mysqli_query($dbc,$query);
	$num_rows = mysqli_num_rows($rs);   //how many material are there?
    
		  
		 if ($num_rows > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>'; 
	   		
		
			
           ?>
           
           
             <form name="myform" method="post" action="view_do_perd2-dlvP2Proc2Sales.php?material_doc_gen=<?php echo html_esc($material_doc_gen); ?>&&ship_point=<?php echo html_esc($ship_point); ?>&&date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>">
               
                  <table class="table table-hover table-bordered" id="example">
                  <thead>
                    <tr> 
                    <th>PSS DO Number</th>
                    <th>DI/PDIO Number</th> 
                    <th>Delivery Date</th>
                    <th>Shift</th>
                    <th>Created Date</th>
                    <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>	
 <?php
   $counter = 1;
   $no4 = 1;
   $i = 1;
   $bal_qty_new = 0;
   $total_deli = 0;

   while($row = mysqli_fetch_array($rs))
   {
	   
	     //----convert status DO -----
	   
	   if($row["status_DO"] == $rst_sta3["status_desc"])
	   {
		   
		$status_new = "ACTIVE";
		$msg_sta =  '<span class="badge badge-pill badge-success">'.$status_new.'</span>';  
		
	   }elseif($row["status_DO"] == $rst_sta4["status_desc"])
	   {
	    $status_new = "CANCELLED";
		$msg_sta =  '<span class="badge badge-pill badge-danger">'.$status_new.'</span>';  
	   
	   }else{
		   
	   }
	   
	      
	   //-------shift----------
	   
	   if($row["cycle_no"] == "D/S")
	   {
		   $shift_ds = "Day";
	   }elseif($row["cycle_no"] == "N/S")
	   {
		 $shift_ds = "Night";
	   }else{
		   
		   $shift_ds = ""; 
	   }
	   
	   //-----get cust info ----
	   
	   $query_cust_info = new PreparedSql("SELECT * FROM cust_detail WHERE id_cust = ?", [$row["ship_point"]]);
	   $result_cust_info = db_query($dbc, $query_cust_info);
	   $row_cust_info  = mysqli_fetch_array($result_cust_info);
	   
	   
	   //----calculate all delivery same sales order --------

	$query_all_soi = "SELECT *, SUM(qty_dlv) AS SS3 FROM dlv_ord_all_delivery WHERE material_no = '".sql_esc($row["material_no"])."' AND so_no = '".sql_esc($row["so_no"])."' AND status_DO = '".sql_esc($rst_sta3["status_desc"])."'";
	$result_all_soi = mysqli_query($dbc,$query_all_soi);
	
	while($row_all_soi = mysqli_fetch_array($result_all_soi))
	{

	//-----calculate balance qty -------
	   $bal_qty_new = (($row["qty_order"]) - ($row_all_soi["SS3"]));
	  
  ?>  	  
                <tr>
                <td width="200">
               <?php
			
                if($row["status_DO"] == $rst_sta3["status_desc"])
	        {    
	        ?>  
                  <a href="#myNoteDisplayDOSales<?php echo html_esc($row["material_doc_gen"]); ?>" data-toggle="modal" target="_parent">
                 
                    <!--------------------------modal------------------------->
          <?php    include "view_do_per2Sales-preview.php";   ?>
                <?php echo html_esc($row["material_doc_gen"]); ?>
               </a>
                <?php  }elseif($row["status_DO"] == $rst_sta4["status_desc"])
	          {   ?>  
             <a href="#myNoteDisplayDOSalescanC<?php echo html_esc($row["ref_material_doc"]); ?>" data-toggle="modal" target="_parent">
                 
                    <!--------------------------modal------------------------->
          <?php    include "view_docanC_per2Sales-preview.php";   ?>
                <?php echo html_esc($row["material_doc_gen"]); ?>
               </a><br><font color="red"><?php echo html_esc($row["ref_material_doc"]); ?></font>
                <?php  }   ?> 
               
               
               </td>
                <td width="200"><?php echo html_esc($row["pdio_no"]); ?> </td>
                <td width="150"><?php echo html_esc($row["R8"]); ?></td>
                <td width="150"><?php echo $shift_ds; ?></td>
                <td width="150" height="28"><?php echo html_esc($row["R"]); ?></td>
                <td width="150"><?php echo $msg_sta; ?></td>
               </tr>
               
               
               
               
               

  <?php 
		 
		  $no4++;
		  $counter++; // menambah counter 
		   
		   
	}
	
	?>
		  
	
          
          <?php   
		
		    
		  } ?>
          
          </tbody>
          </table>
         
       
          
          
          <table class="table">
  <tr>
    <td>&nbsp;   
				
			
               <input name="material_doc_gen" type="hidden" value="<?php echo html_esc($material_doc_gen); ?>">  
               <input name="ship_point" type="hidden" value="<?php echo html_esc($ship_point); ?>"> 
               <input name="date1" type="hidden" value="<?php echo html_esc($dateF); ?>"> 
               <input name="date2" type="hidden" value="<?php echo html_esc($dateT); ?>"> 
              
            </td>
  </tr>
</table>
 </form>

<!--<div id="divShow">
                        </div>-->
 <br>
<?php

   mysqli_free_result($rs); 
   

 
	}   // free up the resources 
else
{
?><center>
<table width="800" cellspacing="0" class="textboxred">
  <tr> 
    <td><div align="center"><font color="#FF0000"><strong>There are currently no record(s).</strong></font></div></td>
  </tr>
</table></center>
        <?php
		   } 
//mysqli_close($dbc)
?>
    
       
           
              
          <!--  </div>-->
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
<!--    <script type="text/javascript">$('#example').DataTable();</script>
-->     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    
     <!-- Page specific javascripts-->
  
    <script type="text/javascript">
          
       $('#PSSDate').datepicker({
		defaultDate: new Date(),
		format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
	   $('#PSSDate2').datepicker({
		defaultDate: new Date(),   
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
	   $('#PSSDate3').datepicker({
		defaultDate: new Date(),   
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
    </script>
    <script language="javascript">
		$(document).ready(function () {
      $('#example').DataTable({
        scrollX: true,
    			});
		});
	  </script>
  
  </body>
</html>