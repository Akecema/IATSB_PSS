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
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
    $url = "display_pps_month_reprint.php";
	

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

//CR status (Cancel)
$sta21 = "SELECT * from request_status WHERE status_id = '21'";
$sta_res21 = mysqli_query($dbc,$sta21);
$rst_sta21 = mysqli_fetch_array($sta_res21);

//CR status (Close)
$sta22 = "SELECT * from request_status WHERE status_id = '22'";
$sta_res22 = mysqli_query($dbc,$sta22);
$rst_sta22 = mysqli_fetch_array($sta_res22);

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
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    
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

 <style type="text/css" media="print"> 
	.breakAfter{ 
	page-break-after: always; 
	}
	.breakBefore{
	page-break-before: always ;
	}
	.tfoot { display: table-footer-group; }
	.page {
	 size:landscape;
	 bottom: 0;
	   
	}
	/* @media print{
	  body{  margin-top: -1.8cm;  font-family: Arial, Helvetica, sans-serif; font-size:12px; }
	  #ad{ display:none;}
	  #leftbar{ display:none;}
	  #contentarea{ width:100%;}
	  .header, .hide { visibility: hidden }
	  .tfoot { display: table-footer-group; }
	  @page {size: landscape}
	 /* tr.page-break  { display: block; page-break-before: always; }  */
	  .breakAfter{ 
	page-break-after: always; 
	}
	.breakBefore{
	page-break-before: always ;
	}
	  
	} */
		
	@media print {
		body.modalprinter * {
			visibility: hidden;
		}
	
		body.modalprinter .modal-dialog.focused {
			position: absolute;
			padding: 0;
			margin: 0;
			left: 0;
			top: 0;
		}
	
		body.modalprinter .modal-dialog.focused .modal-content {
			border-width: 0;
		}
	
		body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title,
		body.modalprinter .modal-dialog.focused .modal-content .modal-body,
		body.modalprinter .modal-dialog.focused .modal-content .modal-body * {
			visibility: visible;
		}
	
		body.modalprinter .modal-dialog.focused .modal-content .modal-header,
		body.modalprinter .modal-dialog.focused .modal-content .modal-body {
			padding: 0;
		}
	
		body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title {
			margin-bottom: 20px;
		}
	}

</style> 

<!--<style>
.modal-dialog{
    position: relative;
    display: table; /* This is important */ 
    overflow-y: auto;    
    overflow-x: auto;
    width: auto;
    min-width: 300px;   
}

</style>-->

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
          <h1><i class="fa fa-th-list"></i> Planning</h1>
          <p>PPS Listings</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Planning</li>
          <li class="breadcrumb-item"><a href="display_pps_month_reprint.php">PPS Listings</a></li>
        </ul>
      </div> 
                         
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body"><br>
              <div class="table-responsive">
          <?php
		  
		      $message_pcode = "";
			  $message_psdt = "";
			  $message_psdt2 = "";
			  $message_line = "";
		  
		    $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plan_category = $_GET["plan_category"];
			$material_no = $_GET["material_no"]; 
			$shift_ops = $_GET["shift_ops"];
			
	
			  ?>    
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%">&nbsp;</th>
            </tr>
            <tr>
            <th>Date From : <font color="#FF0000">*</font></th>
            <td>
              <?php
			     $dd1 = substr($_GET["date1"],8,2);
				 $mm1 = substr($_GET["date1"],5,2);
				 $yy1 = substr($_GET["date1"],0,4);
			?>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" ><div class="form-control-feedback" ><?php echo $message_psdt; ?></div>		     </td>
            </tr>
             <tr>
              <th>Date To : <font color="#FF0000">*</font></th>
              <td><input class="form-control" id="PSS2Date" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>"><div class="form-control-feedback" ><?php echo $message_psdt2; ?></div></td>
           </tr>
            <tr>
                <th>Process :</th>
                <th><select name="plan_category" class="form-control" onChange="getProc(this.value)">
                <option value="NULL" placeholder="Select Process"> -- Select Process -- </option>
                <option value="STM" <?php if($_GET["plan_category"] == 'STM') { ?> selected="selected"<?php } ?>>PRESS STAMPING</option>
                <option value="ASSY" <?php if($_GET["plan_category"] == 'ASSY') { ?> selected="selected"<?php } ?>>WELD ASSEMBLY</option>
                 <option value="BLK" <?php if($_GET["plan_category"] == 'BLK') { ?> selected="selected"<?php } ?>>BLANKING</option>
                </select><div class="form-control-feedback" ><?php echo $message_pcode; ?></div></th>
              </tr>
              <tr> 
                <th>Part No. :</th>
                <th>
                
                <div id="back_nodiv"><select name="material_no" id="material_no" class="form-control" >
                  <option value="NULL" placeholder="Select Part No."> -- Select Part No. --</option>
                 <?php
				 
	               $query5 = "SELECT * FROM table_material_itsb WHERE category_mat = '".sql_esc($_GET["plan_category"])."' AND (Vclass = 'Z201' OR Vclass = 'Z301') AND status_BOM = 'Y' ORDER BY id_mat ASC";
                   $result5 = mysqli_query($dbc,$query5);
  
                   while($row5=mysqli_fetch_array($result5)) 
				    { 
				   
				   ?>
                  <option value="<?php echo html_esc($row5["material_no"]); ?>" <?php if($row5["material_no"] == $_GET["material_no"]) echo "selected"; ?>>(<?php echo html_esc($row5["back_no"]); ?>)&nbsp;<?php echo html_esc($row5["material_no"]); ?> - <?php echo html_esc($row5["material_desc"]); ?> </option>
                  <?php
                  }
				?> 
                  
                  
                </select></div> <div class="form-control-feedback" ><?php echo $message_line; ?></div></th>
              </tr>
             
              <tr>
                <th>Shift :</th>
                <th><select name="shift_ops" id="shift_ops" class="form-control">
                  <option value="NULL" placeholder="Select Shift"> -- Select Shift --</option>
                  <option value="D/S" <?php if($_GET["shift_ops"] == "D/S") { ?> selected="selected"<?php } ?>>D/S - Day Shift</option>
                  <option value="N/S" <?php if($_GET["shift_ops"] == "N/S") { ?> selected="selected"<?php } ?>>N/S - Night Shift</option>
                </select></th>
              </tr>
              
              <tr>
                <th><input name="Submit2" type="submit" class="btn btn-info" id="button" value="SEARCH" /></th>
                <th>&nbsp;</th>
               </tr>
                </table>
        </form>
   <!--    <a href="#" title="Dismissible popover" data-toggle="popover" data-trigger="focus" data-content="Click anywhere in the document to close this popover">Click me</a>-->
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
                    $wheresql_01 = " AND (date_plan >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 2. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (date_plan <= '".sql_esc($date2_final)."')"; } 
					 	 
		 //3. Plan Category 
                if ($plan_category == "NULL"){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND plan_category = '".sql_esc($plan_category)."'"; } 
					
          //4. Material No.
                if ($material_no == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND material_no = '".sql_esc($material_no)."'"; }
   
			 
		  //5. Shift
                if ($shift_ops == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
					// $wheresql_06 = ""; }
					
                    $wheresql_05 = " AND ((shift_pps1 = '".sql_esc($shift_ops)."') OR (shift_pps2 = '".sql_esc($shift_ops)."')) "; }  		 				        
					
                                       
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;	
	
	//********** END CONDITION **************	
		
	
   $query8 = "SELECT COUNT(*) FROM pps_detail WHERE status_pps = '".sql_esc($rst_sta2["status_desc"])."'" .$where_sql;
   $result8 = mysqli_query($dbc,$query8);
   $num_rows = mysqli_num_rows($result8);
			
  
 
  
$query = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') as R, DATE_FORMAT(work_hours,'%H:%i') as T5 FROM pps_detail WHERE status_pps = '".sql_esc($rst_sta2["status_desc"])."'" .$where_sql."ORDER BY date_plan ASC ";
$rs = mysqli_query($dbc,$query);
$num_rows = mysqli_num_rows($rs);   //how many material are there?
    
		  
		 if ($num_rows > 0) {
	 
	         echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>';
			  		 	
?>
                 <form name="myformG" method="post" action="display_pps_month_reprint2.php?date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&plan_category=<?php echo html_esc($plan_category); ?>&&material_no=<?php echo html_esc($material_no); ?>&&shift_ops=<?php echo html_esc($shift_ops); ?>">
                <!-- <table class="table table-hover table-bordered sortable fc-scroller dataTable">-->
                  <table class="table table-hover table-bordered" id="example">
                  <thead>
                    <tr>
                   	<th>No. <input type="checkbox" id="selectAll"> </th>
                    <th>Back Number</th>
                    <th>Part Number</th>
                    <th>Planned Order No.</th>
                    <th>Planned Date</th>
                    <th>Shift</th>
                    <th>Planned Quantity</th>
                    <th>Action</th>
                    <th>Action</th>
                    <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>	
 <?php
   $counter = 1;
   $no4 = 1;
   $i = 1;

   while($row = mysqli_fetch_array($rs))
   {
		
		
		
		if($row["shift_pps1"] == "D/S")
	{
		$star = "D/S";
		
	}elseif($row["shift_pps2"] == "N/S")
	 {
		$star = "N/S";
	 }else{
		 
		$star = " ";
	 }	
		 
  $query4_p ="SELECT * from level_detail as LD, user_detail as SD where SD.level_id = LD.id_level and LD.id_level = '.".sql_esc($row[16]).".'";
  $result4_p = mysqli_query($dbc,$query4_p);
  $row4_p = mysqli_fetch_array($result4_p);
  
  
  if($row["work_hours"] != "00:00:00")
  
  {
	$time_new =  $row["T5"];  
	  
  }else{
	$time_new = "";  
  }
  
  
  	 //----model ---
  
 /*$query_Mod = "SELECT * FROM work_center_detail WHERE id_work = '".$row["work_center"]."' AND status_wc = 'Y' ORDER BY id ASC";
 $result_Mod = mysqli_query($dbc,$query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  
 
  if($row_Mod["wc_desc2"] == "")
  {
	  $model_name = $row_Mod["id_work"];
  }else{
	  
	 $model_name = $row_Mod["wc_desc2"]; 
  }*/
  
  
  
  
  ?>        
         
             <tr>
                <td width="30"><div align="center">
                
          <input type="checkbox" id="checkbox" name="e_tcid[]" value="<?php echo html_esc($row["id"]); ?>" class="form-check">       
                 <?php echo $no4; ?></div></td>
                <td width="150"><?php echo html_esc($row["back_no"]); ?></td>
                <td width="150"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="124" height="28"> 
               <!-- <a href="detail_pps_sheet_print_view.php?buid=<?php //echo base64_encode($row["id"]);  ?>"  target="_blank"></a>-->
               <a href="#myNoteView<?php echo html_esc($row['id']); ?>" data-toggle="modal"  target="_parent"><b><?php echo html_esc($row["plan_no"]); ?>  </b><?php include "detail_pps_sheet_print_view.php";   ?></a>
               
               
              </td>
                <td width="100"><?php echo html_esc($row["R"]); ?></td>
                <td width="50"><?php echo $star; ?></td>
                <td width="80"><?php echo intval($row["qty_plan"]); ?></td>
                <td width="100">
                 <a href="#myNoteEdit<?php echo html_esc($row["id"]); ?>" data-toggle="modal"  target="_parent"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;Edit</a> 
                 
                    <!--------------------------modal------------------------->
          <?php    include "detail_pps_sheet_print_edt.php";   ?>
               
              </td> 
                <td width="100">
        
             <a href="detail_pps_sheet_print_by_uid.php?id=<?php echo base64_encode($row["id"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a> 
                                
              </td> 
                <td width="100">
                 <a href="#myNoteCancel<?php echo html_esc($row["id"]); ?>" data-toggle="modal" target="_parent"><i class="fa fa-window-close" aria-hidden="true"></i>Delete</a> 
                 
                    <!--------------------------modal------------------------->
          <?php    include "cancel_pps_tran_proc_selected.php";   ?>
               
              </td> 
             

  <?php 
		 
		  $no4++;
		  $counter++; // menambah counter 
		   
		   //}// end if
		?>
		  </tr>   
		<?php  } ?>
         
          </tbody>
   
          </table><table class="table">
  <tr>
    <td>&nbsp;                
           
               <button type="button" name="btn_deletd" id="btn_deletd" class="btn btn-danger btn-sm">DELETE PLANNED ORDER</button>
               <button type="button" name="btn_printPPS" id="btn_printPPS" class="btn btn-success btn-sm">PRINT PLANNED ORDER</button>
               <button type="button" name="btn_edtrecord" id="btn_edtrecord" class="btn btn-warning btn-sm">EDIT</button>
               
               
               <form name="myformG" method="post" action="display-update.php?date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&plan_category=<?php echo html_esc($plan_category); ?>&&material_no=<?php echo html_esc($material_no); ?>&&shift_ops=<?php echo html_esc($shift_ops); ?>" >
               <!-- Modal Multiple Edit-->
               <div class="modal fade" id="empModal" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
             
                 <!-- Modal content-->
                  <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">PPS Edit</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">                  
                  
                  </div>
            
                  <div class="modal-footer">
                    <input type="submit" value="SAVE" name="edt_btnMul" class="btn btn-success btn-sm" onClick="return confirm('Are you sure to edit this records?');">
                    <input type="hidden" value="<?php echo html_esc($row["id"]); ?>"/>
                    
                   <button type="button" onClick="javascript:window.location.reload()" class="btn btn-danger btn-sm" data-dismiss="modal">BACK</button>
                   <!-- <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">BACK</button>-->
                  </div>
                 </div>
                </div>
               </div>
               <!-- Modal Multiple Edit-->
               </form> 
               
            </td>
  </tr>
</table>
 </form>

<div id="divShow">
                        </div>
 <br>
<?php

   mysqli_free_result($rs); 
   
 
	}   // free up the resources 
else
{
?><center>
<table width="800" cellspacing="0" class="textboxred">
  <tr> 
    <td><div align="center"><font color="#FF0000"><strong>There are currently no Production Planning Sheet.</strong></font></div></td>
  </tr>
</table></center>
        <?php
		   } 
//mysqli_close($dbc)
?>

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
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    
<!--    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#example').DataTable();</script>-->
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
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
      
	   $('#PSS2Date').datepicker({
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      $('#demoSelect').select2();
    </script>
     <script language="javascript" type="text/javascript">

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
	function getProc(plan_category) {		
		
		var strURL="findProc-pss.php?plan_category="+plan_category;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('back_nodiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
</script>

      <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>

    
<script>
$(document).ready(function () { 
    var oTable = $('#example').dataTable({
        stateSave: true
    });

    var allPages = oTable.fnGetNodes();

    $('body').on('click', '#selectAll', function () {
        if ($(this).hasClass('allChecked')) {
            $('input[type="checkbox"]', allPages).prop('checked', false);
        } else {
            $('input[type="checkbox"]', allPages).prop('checked', true);
        }
        $(this).toggleClass('allChecked');
		
    })
	
	
});
</script>

<script>
//Submit IPP for approval
//Status changed to submitted
//https://www.youtube.com/watch?v=fGS-Ff3wgXw
//https://stackoverflow.com/questions/29896599/how-can-i-select-all-checkboxes-from-all-the-pages-in-a-jquery-datatable
$(document).on("click", "#btn_edtmult", function(event) {  

$('#example').DataTable();  

	if (confirm('Send an alert message to the users?'))
	{
		var e_tcid = new Array();

		var oTable = $('#example').dataTable();  
		var rowcollection =  oTable.$("#checkbox:checked", {"page": "all"});  
		
		rowcollection.each(function(index,elem) {  
			e_tcid.push($(elem).val());
			
		});    
					

		if(e_tcid.length == 0)
		//if($('input.styled').not(':checked').length > 0) 
		{
			alert('Please select a planned order to edit.');
		}
		else
		{
			$("#exampleModal").modal("show");
			
			/*$.ajax({
			 url: "emp-ipp-alert.php?sta=<?php echo $sta;?>",
			 type: "POST",
			 data: {
			 	e_tcid:e_tcid
			 },
			 success: function(data){
			 $("#divShow").html(data);
			 
			
			 //$('#output').html(response); 
			 alert('An alert message successfully send.');
			 location.reload();
			 } 
		
			
			});*/
			
		}
		
	}
	else
	{
		return false;
	}

});

</script>

<script>
//Submit Release Selected Planned Order
//Status changed to submitted
//https://www.youtube.com/watch?v=fGS-Ff3wgXw
//https://stackoverflow.com/questions/29896599/how-can-i-select-all-checkboxes-from-all-the-pages-in-a-jquery-datatable
$(document).on("click", "#btn_release", function(event) {  

$('#example').DataTable();  

	if (confirm('Are you sure to release multiple selected planned orders?'))
	{
		var e_tcid = new Array();

		var oTable = $('#example').dataTable();  
		var rowcollection =  oTable.$("#checkbox:checked", {"page": "all"});  
		
		rowcollection.each(function(index,elem) {  
			e_tcid.push($(elem).val());
			
		});    
					

		if(e_tcid.length == 0)
		//if($('input.styled').not(':checked').length > 0) 
		{
			alert('Please select a planned order to release.');
		}
		else
		{
			$.ajax({
			 url: "pss-mth-release.php?date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&plan_category=<?php echo html_esc($plan_category); ?>&&material_no=<?php echo html_esc($material_no); ?>&&shift_ops=<?php echo html_esc($shift_ops); ?>&&username=<?php echo html_esc($username); ?>",
			 type: "POST",
			 data: {
			 	e_tcid:e_tcid
			 },
			 success: function(data){
			 $("#divShow").html(data);
			
			 //$('#output').html(response); 
			 alert('Your transaction has been processed successfully.');
			 location.reload();
			 } 
		
			
			});
			
		}
		
	}
	else
	{
		return false;
	}

});

</script>

 <script>
//Submit Deleted the Planned Order
//Status changed to submitted
//https://www.youtube.com/watch?v=fGS-Ff3wgXw
//https://stackoverflow.com/questions/29896599/how-can-i-select-all-checkboxes-from-all-the-pages-in-a-jquery-datatable
$(document).on("click", "#btn_deletd", function(event) {  

$('#example').DataTable();  

	if (confirm('Are you sure to delete planned order?'))
	{
		var e_tcid = new Array();

		var oTable = $('#example').dataTable();  
		var rowcollection =  oTable.$("#checkbox:checked", {"page": "all"});  
		
		rowcollection.each(function(index,elem) {  
			e_tcid.push($(elem).val());
			
		});    
					

		if(e_tcid.length == 0)
		//if($('input.styled').not(':checked').length > 0) 
		{
			alert('Please select a planned order to delete.');
		}
		else
		{
			$.ajax({
			 url: "pss-mth-delete-plan-ord.php?date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&plan_category=<?php echo html_esc($plan_category); ?>&&material_no=<?php echo html_esc($material_no); ?>&&shift_ops=<?php echo html_esc($shift_ops); ?>&&username=<?php echo html_esc($username); ?>",
			 type: "POST",
			 data: {
			 	e_tcid:e_tcid
			 },
			 success: function(data){
			 $("#divShow").html(data);
			
			 //$('#output').html(response); 
			 alert('Your transaction has been processed successfully.');
			 location.reload();
			 } 
		
			
			});
			
		}
		
	}
	else
	{
		return false;
	}

});

</script>

 <script>
//Submit Release Selected Planned Order
//Status changed to submitted
//https://www.youtube.com/watch?v=fGS-Ff3wgXw
//https://stackoverflow.com/questions/29896599/how-can-i-select-all-checkboxes-from-all-the-pages-in-a-jquery-datatable
$(document).on("click", "#btn_printPPS", function(event) {  

$('#example').DataTable();  

	// if (confirm('Are you sure to print planned order?'))
	//{
		var e_tcid = new Array();

		var oTable = $('#example').dataTable();  
		var rowcollection =  oTable.$("#checkbox:checked", {"page": "all"});  
		
		rowcollection.each(function(index,elem) {  
			e_tcid.push($(elem).val());
			
		});    
					

		if(e_tcid.length == 0)
		//if($('input.styled').not(':checked').length > 0) 
		{
			alert('Please select a planned order to print.');
		}
		else
		{
			$.ajax({
			 url: "detail_print-sel-release.php?date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&plan_category=<?php echo html_esc($plan_category); ?>&&material_no=<?php echo html_esc($material_no); ?>&&shift_ops=<?php echo html_esc($shift_ops); ?>",
			 type: "POST",
			 data: {
			 	e_tcid:e_tcid
			 },
			 success: function(data){
		     $("#divShow").html(data);
			
			 //$('#output').html(response); 
			 alert('Your transaction has been processed successfully.');
			 location.reload();
			 } 
		
			
			});
			
		}
		
	//}
	//else
	//{
		//return false;
	//}

});

</script>

<script>
//Submit Release Selected Planned Order
//Status changed to submitted
//https://www.youtube.com/watch?v=fGS-Ff3wgXw
//https://stackoverflow.com/questions/29896599/how-can-i-select-all-checkboxes-from-all-the-pages-in-a-jquery-datatable
$(document).on("click", "#btn_editbtc", function(event) {  

$('#example').DataTable();  

	if (confirm('Are you sure to editing planned order?'))
	{
		var e_tcid = new Array();

		var oTable = $('#example').dataTable();  
		var rowcollection =  oTable.$("#checkbox:checked", {"page": "all"});  
		
		rowcollection.each(function(index,elem) {  
			e_tcid.push($(elem).val());
			
		});    
					

		if(e_tcid.length == 0)
		//if($('input.styled').not(':checked').length > 0) 
		{
			alert('Please select a planned order to edit.');
		}
		else
		{
			$.ajax({
			 url: "detail_print_edt-sel-new.php?date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&plan_category=<?php echo html_esc($plan_category); ?>&&material_no=<?php echo html_esc($material_no); ?>&&shift_ops=<?php echo html_esc($shift_ops); ?>",
			 type: "POST",
			 data: {
			 	e_tcid:e_tcid
			 },
			 success: function(data){
			 $("#divShow").html(data);
			
			 //$('#output').html(response); 
			 alert('Your transaction has been processed successfully.');
			 location.reload();
			 } 
		
			
			});
			
		}
		
	}
	else
	{
		return false;
	}

});

</script>

<!--Edit multiple-------->
<script>
//Submit Release Selected Planned Order
//Status changed to submitted
//https://www.youtube.com/watch?v=fGS-Ff3wgXw
//https://stackoverflow.com/questions/29896599/how-can-i-select-all-checkboxes-from-all-the-pages-in-a-jquery-datatable
$(document).on("click", "#btn_edtrecord", function(event) {  

$('#example').DataTable();  

	if (confirm('Are you sure to edit multiple planned orders?'))
	{
		var e_tcid = new Array();

		var oTable = $('#example').dataTable();  
		var rowcollection =  oTable.$("#checkbox:checked", {"page": "all"});  
		
		rowcollection.each(function(index,elem) {  
			e_tcid.push($(elem).val());
			
		});    
					

		if(e_tcid.length == 0)
		//if($('input.styled').not(':checked').length > 0) 
		{
			alert('Please select a planned order to edit.');
		}
		else
		{
			$.ajax({
			 url: "detail_pps_sheet_print_edt_multp.php",
			 type: "POST",
			 data: {
			 	e_tcid:e_tcid
			 },
			 success: function(response){
				// Add response in Modal body
			  	$('.modal-body').html(response);
		
			  	// Display Modal
			  	$('#empModal').modal('show'); 
			 } 
		
			
			});
			
		}
		
	}
	else
	{
		return false;
	}

});

</script>


<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});
</script>		
				
  </body>
</html>