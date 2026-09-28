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
          <h1><i class="fa fa-th-list"></i> Production Planning</h1>
          <p>PPS Listings</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Production Planning</li>
          <li class="breadcrumb-item"><a href="display_pps_month_reprint.php">PPS Listings</a></li>
        </ul>
      </div> 
            <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link"  href="display_pps_month_reprint.php">New PPS </a></li>
                 <li class="nav-item"><a class="nav-link active" href="display_pps_month_reprint_rel.php">Released PPS</a></li>
               
              </ul>
              
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body"><br><br>
              <div class="table-responsive">
          <?php
		  
		      $message_pcode = "";
			  $message_psdt = "";
			  $message_psdt2 = "";
			  $message_line = "";
		  
		    $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plant_code = $_GET["plant_code"];
			$work_center = $_GET["work_center"];
			$material_no = $_GET["material_no"];
			$shift_ops = $_GET["shift_ops"];
			
		  ?>    
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <br>
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%">&nbsp;</th>
            </tr>
            <tr>
            <th>Date From : <font color="#FF0000">*</font></th>
            <td>
            
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" >
		     </td>
            </tr>
             <tr>
              <th>Date To : <font color="#FF0000">*</font></th>
              <td><input class="form-control" id="PSS2Date" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>"></td>
         
           </tr>
            <tr>
                <th>Plant :</th>
                <th><select name="plant_code" class="form-control" onChange="getWorkCenter(this.value)">
                  <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
                  <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
                  <option value="<?php echo html_esc($row27["plant_code"]); ?>" <?php if($row27["plant_code"] == $_GET["plant_code"]) echo "selected"; ?>> <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo html_esc($row27["plant_desc"]); ?></option>
                  <?php
           }  ?>
                </select></th>
              </tr>
              <tr> 
                <th>Line :</th>
                <th><div id="work_centerdiv"><select name="work_center" id="work_center" class="form-control" onChange="getMaterial(this.value)" >
                  <option value="NULL" placeholder="Select Line"> -- Select Line --</option>
                 <?php
	               $query5 = "SELECT * FROM work_center_detail WHERE plant_code = '".sql_esc($_GET["plant_code"])."' AND dept_acc = 'PRODUCTION' AND status_wc = 'Y' ORDER BY id_work ASC";
                   $result5 = mysqli_query($dbc,$query5);
  
                   while($row5=mysqli_fetch_array($result5)) 
				    { 
				   
				   ?>
                  <option value="<?php echo html_esc($row5["id_work"]); ?>" <?php if($row5["id_work"] == $_GET["work_center"]) echo "selected"; ?>> <?php echo html_esc($row5["id_work"]),' - ',stripslashes($row5["wc_desc"]); ?></option>
                  <?php
                  }
				?> 
                  
                  
                </select></div>
             </th>
              </tr>
             
              <tr>
                <th>Part Number :</th>
                <th>
                
                 <div id="mat_div"> <select name="material_no" id="material_no" class="form-control" > 
                  <option value="NULL" placeholder="Select Part Number"> -- Select Part Number --</option>
                  
                   <?php
				   
				   $query99 = "SELECT * FROM mat_master_header WHERE work_center = '".sql_esc($_GET["work_center"])."' AND status_BOM = 'Y' ORDER BY id_hdr ASC";
                   $result99 = mysqli_query($dbc,$query99);

  
                   while($row99=mysqli_fetch_array($result99)) 
				    { 
				   
				   ?>
                   
                   <option value="<?php echo html_esc($row99["material_no"]); ?>" <?php if($row99["material_no"] == $_GET["material_no"]) echo "selected"; ?> > <?php echo html_esc($row99["material_no"]); ?> - <?php echo html_esc($row99["material_desc"]); ?></option> 
              
                  <?php
                  }
				?> 
                  
                  
                  
                 </select></div>
            
                </th>
              </tr> 
              <tr>
                <th>Shift :</th>
                <th><select name="shift_ops" id="shift_ops" class="form-control">
                  <option value="NULL" placeholder="Select Shift"> -- Select Shift --</option>
                  <option value="D/S" <?php if($_GET["shift_ops"] == "D/S") { ?> selected="selected"<?php } ?>>D/S</option>
                  <option value="N/S" <?php if($_GET["shift_ops"] == "N/S") { ?> selected="selected"<?php } ?>>N/S</option>
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
       
			
			
			 //convert 
			
			$query_convert = "SELECT * FROM work_center_detail as SR WHERE SR.id_work = '".sql_esc($_GET["work_center"])."'";
			$result_convert = mysqli_query($dbc,$query_convert); 
			$row_convert = mysqli_fetch_array($result_convert);
			
			$query_convert2 = "SELECT * FROM ftp_pps WHERE file_name = '".sql_esc($_GET["name_file"])."'";
			$result_convert2 = mysqli_query($dbc,$query_convert2); 
			$row_convert2 = mysqli_fetch_array($result_convert2);
			
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
                    $wheresql_01 = " AND (MR.date_plan >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 2. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (MR.date_plan <= '".sql_esc($date2_final)."')"; } 
					 	 
		 //3. Plant Code 
                if ($plant_code == "NULL"){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND MR.plant_code = '".sql_esc($plant_code)."'"; } 
					
          //4. Work Center
                if ($work_center == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND MR.work_center = '".sql_esc($work_center)."'"; }
   
	       //5. Material No.
                if ($material_no == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND MR.material_no = '".sql_esc($material_no)."'"; }  	
					
		 
		  //6. Shift
                if ($shift_ops == "NULL"){ 
                    $wheresql_06 = ""; }
                else {
					// $wheresql_06 = ""; }
					
                    $wheresql_06 = " AND ((MR.shift_pps1 = '".sql_esc($shift_ops)."') OR (MR.shift_pps2 = '".sql_esc($shift_ops)."')) "; }  		 				        
		
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05 .$wheresql_06;	
	
	//********** END CONDITION **************
	
   $query8 = "SELECT COUNT(*) FROM pps_detail AS MR WHERE (MR.status_pps = '".sql_esc($rst_sta2["status_desc"])."' OR MR.status_pps = '".sql_esc($rst_sta7["status_desc"])."') " .$where_sql;
   $result8 = mysqli_query($dbc,$query8);
   $num_rows = mysqli_num_rows($result8);
			
  
 
  
$query = "SELECT *, DATE_FORMAT(MR.date_plan,'%d-%m-%Y') as R, DATE_FORMAT(work_hours,'%H:%i') as T5 FROM pps_detail AS MR WHERE (MR.status_pps = '".sql_esc($rst_sta2["status_desc"])."' OR MR.status_pps = '".sql_esc($rst_sta7["status_desc"])."')" .$where_sql."ORDER BY MR.plan_no ASC ";
$rs = mysqli_query($dbc,$query);
$num_rows = mysqli_num_rows($rs);   //how many material are there?
    
		  
		 if ($num_rows > 0) {
	 
	         echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>';
			  		 	
?>
                 <form name="myformG" method="post" action="display_pps_month_reprintProc_rel2.php?date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&plant_code=<?php echo html_esc($plant_code); ?>&&work_center=<?php echo html_esc($work_center); ?>&&material_no=<?php echo html_esc($material_no); ?>&&shift_ops=<?php echo html_esc($shift_ops); ?>">
                <!-- <table class="table table-hover table-bordered sortable fc-scroller dataTable">-->
                  <table class="table table-hover table-bordered" id="example">
                  <thead>
                    <tr>
                   	<th>No. <input type="checkbox" id="selectAll"></th>
                    <th>Part Number</th>
                    <th>Planned Order No.</th>
                    <th>Planned Date</th>
                    <th>Planned Start Time</th>
                    <th>Line</th>
                    <th>Shift</th>
                    <th>Planned Quantity</th>
                    <th>Status</th>
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
  
 $query_Mod = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($row["work_center"])."' AND status_wc = 'Y' ORDER BY id ASC";
 $result_Mod = mysqli_query($dbc,$query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  
 
  if($row_Mod["wc_desc2"] == "")
  {
	  $model_name = $row_Mod["id_work"];
  }else{
	  
	 $model_name = $row_Mod["wc_desc2"]; 
  }
  ?>        
         
             <tr>
                <td width="30"><div align="center">
                
          <input type="checkbox" id="checkbox" name="e_tcid[]" value="<?php echo html_esc($row["id"]); ?>" class="form-check">       
                 <?php echo $no4; ?> </div></td>
                
    
                <td width="150"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="124" height="28"><?php echo html_esc($row["plan_no"]); ?></td>
                <td width="100"><?php echo html_esc($row["R"]); ?></td>
                <td width="80"><?php echo $time_new; ?></td>
                <td width="80"><?php echo $model_name; ?></td>
                <td width="50"><?php echo $star; ?></td>
                <td width="80"><?php echo intval($row["qty_plan"]); ?></td>
                <td width="80"><?php echo html_esc($row["status_pps"]); ?></td>
                <td width="100">
        
             <a href="detail_pps_sheet_print_by_uid-rel.php?id=<?php echo base64_encode($row["id"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a> 
            
                </td> 
                <td width="100">
                <?php if($row["status_pps"] == $rst_sta2["status_desc"]) 
				{  ?>
                 <a href="#myNoteCancelRel<?php echo html_esc($row["id"]); ?>" data-toggle="modal" target="_parent"><i class="fa fa-window-close" aria-hidden="true"></i>Delete</a> 
                 
                    <!--------------------------modal------------------------->
          <?php    include "cancel_pps_tran_proc_selected-rel.php";   ?>
               <?php }  ?>
              </td> 
             

  <?php 
		 
		  $no4++;
		  $counter++; // menambah counter 
		   
		   //}// end if
		
		    
		  } ?>
          </tr>
          </tbody>
          </table>
          </table><table class="table">
  <tr>
    <td>&nbsp; 
                <button type="button" name="btn_printPPSrel" id="btn_printPPSrel" class="btn btn-success btn-sm">PRINT PLANNED ORDER</button>
              <button type="button" name="btn_deletdrel" id="btn_deletdrel" class="btn btn-danger btn-sm">DELETE PLANNED ORDER</button>
              
              
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
	
	function getWorkCenter(plant_code) {		
		
		var strURL="findPlant-pss.php?plant_code="+plant_code;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('work_centerdiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	function getMaterial(work_center) {		
	
		var strURL="findMaterial-pps.php?work_center="+work_center;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('mat_div').innerHTML=req.responseText;						
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
//Submit Deleted the Planned Order
//Status changed to submitted
//https://www.youtube.com/watch?v=fGS-Ff3wgXw
//https://stackoverflow.com/questions/29896599/how-can-i-select-all-checkboxes-from-all-the-pages-in-a-jquery-datatable
$(document).on("click", "#btn_deletdrel", function(event) {  

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
			 url: "pss-mth-delete-plan-ord_release.php?date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&plant_code=<?php echo html_esc($plant_code); ?>&&work_center=<?php echo html_esc($work_center); ?>&&material_no=<?php echo html_esc($material_no); ?>&&shift_ops=<?php echo html_esc($shift_ops); ?>",
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
$(document).on("click", "#btn_printPPSrel", function(event) {  

$('#example').DataTable();  

	//if (confirm('Are you sure to print planned order?'))
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
			 url: "detail_print-sel-release.php?date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&plant_code=<?php echo html_esc($plant_code); ?>&&work_center=<?php echo html_esc($work_center); ?>&&material_no=<?php echo html_esc($material_no); ?>&&shift_ops=<?php echo html_esc($shift_ops); ?>",
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
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});
</script>		
				
  </body>
</html>