<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');

set_time_limit(0);
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

$fmt_curr_date = (date("d-m-Y"));



                 $drun = substr($fmt_curr_date,0,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,8,2);
				 
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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
    $url = "detail_list_bf_disposal-prd.php";
	
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

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

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
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
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
div.dataTables_wrapper {
        width: 1300px;
        margin: 0 auto;
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
           <h1><i class="fa fa-bar-chart"></i> Production</h1>
          <p>Disposals List</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Production</li>
          <li class="breadcrumb-item"><a href="detail_list_bf_disposal-prd.php">Disposals List</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Disposals List</h3>
            <div class="tile-body">
              <div class="table-responsive">
              
           <ul class="nav nav-tabs">
           <li class="nav-item"><a class="nav-link active" href="detail_list_bf_disposal-prd.php">New Disposal </a></li>
           <li class="nav-item"><a class="nav-link" href="detail_list_bf_disposal-prd-aprv.php">Approved Disposal</a></li>
           </ul>   
            <?php
		  
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
        	$plant_code = $_GET["plant_code"]; 
			$work_center = $_GET["work_center"]; 
			
			?>
        
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="3">&nbsp;</th>
            </tr>
             <tr>
            <th>Date From : <font color="#FF0000">*</font></th>
            <td>
           <?php
			     $dd1 = substr($_GET["date1"],8,2);
				 $mm1 = substr($_GET["date1"],5,2);
				 $yy1 = substr($_GET["date1"],0,4);
			?>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo $dateF; ?>" >
		     </td>
             </tr>
             <tr>
              <th>Date To : <font color="#FF0000">*</font></th>
              <td><?php
			     $dd2 = substr($_GET["date2"],8,2);
				 $mm2 = substr($_GET["date2"],5,2);
				 $yy2 = substr($_GET["date2"],0,4);
			?>
             <input class="form-control" id="PSSDate2" type="text" placeholder="Select Date" name="date2" value="<?php echo $dateT; ?>" ></td>
              </tr>
              <tr>
            <th>Plant : <font color="#FF0000">*</font></th>
            <td colspan="3">
           <select name="plant_code" class="form-control" onChange="getWorkCenter(this.value)">
                  <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
                  <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
                  <option value="<?php echo $row27["plant_code"]; ?>" <?php if($row27["plant_code"] == $_GET["plant_code"]) echo "selected"; ?>> <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo $row27["plant_desc"]; ?></option>
                  <?php
           }  ?>
                </select>
		     </td>
             </tr>
              <tr>
                <th>Section/Line :</th>
                <th>
                <div id="work_centerdiv"><select name="work_center" id="work_center" class="form-control" >
                  <option value="NULL" placeholder="Select Line"> -- Select Line --</option>
                  <?php
	               $query5 = "SELECT * FROM work_center_detail WHERE plant_code = '".sql_esc($_GET["plant_code"])."' AND dept_acc = 'PRODUCTION' AND status_wc = 'Y' ORDER BY id_work ASC";
                   $result5 = mysqli_query($dbc,$query5);
  
                   while($row5=mysqli_fetch_array($result5)) 
				    { 
				   
				   ?>
                <option value="<?php echo $row5["id_work"]; ?>" <?php if($row5["id_work"] == $_GET["work_center"]) echo "selected"; ?>> <?php echo $row5["id_work"],' - ',stripslashes($row5["wc_desc"]); ?></option>
                
                
                
                <?php
                  }
				?>
                </select></div>
                
                </th>
              </tr>
              <tr>
                <th>
                <input name="Submit25" type="submit" class="btn btn-info" id="button" value="SEARCH" />
              
                </th>
                <th colspan="3">&nbsp;</th>
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
				 
				 $ddF2 = substr($_GET["date2"],0,2);
				 $mmF2 = substr($_GET["date2"],3,2);
				 $yyF2 = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyF2.'-'.$mmF2.'-'.$ddF2);
				 
								 		
	       //1. Plant Code
                if (($plant_code == "") || ($plant_code == "NULL")){ 
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND plant_cd = '".sql_esc($plant_code)."'"; }  	
					
		   // 2. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (date_posting >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //3. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
					$wheresql_03 = " AND (date_posting <= '".sql_esc($date2_final)."')"; }
					
		   //4. Work Center
                if ($work_center == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND work_center = '".sql_esc($work_center)."'"; }
					
			                                        			
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04;
						
	
	//********** END CONDITION **************
			
		  ?>     
                   
    <?php
		
   $query8GR = "SELECT COUNT(*) FROM disposal_detail_prd_all WHERE (status_disposal = '".sql_esc($rst_sta15["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta32["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta34["status_desc"])."')" .$where_sql ." GROUP BY doc_dis ORDER BY doc_dis ASC ";
   $result8GR = mysqli_query($dbc,$query8GR);
   $num_rowsGR = mysqli_num_rows($result8GR);
			
  
$queryGR = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as R FROM disposal_detail_prd_all WHERE (status_disposal = '".sql_esc($rst_sta15["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta32["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta34["status_desc"])."') " .$where_sql." GROUP BY doc_dis ORDER BY doc_dis ASC ";
$rsGR = mysqli_query($dbc,$queryGR);
$num_rowsGR = mysqli_num_rows($rsGR);   //how many material are there?
    
		  
		 if ($num_rowsGR > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rowsGR.' record(s).</div>'; 
	   
        
    	?>
    <form action="detail_list_bf_disposal-prdProc2.php?date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&plant_code=<?php echo $plant_code; ?>&&work_center=<?php echo $work_center; ?>" method="post" name="myform" id="myform">    
             
                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>No</th>
                    <th>Disposal Doc. No.</th>
                    <th>Doc. Date</th>
                    <th>Line</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Action</th>
                    <th>Action</th>
                 </tr>
              </thead>    
              <tbody>
           <?php 

   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   
   while($row = mysqli_fetch_array($rsGR))
   {
	   
	   
	   //----get process of reject -----
  
     $query_proc = "SELECT * FROM proc_reject_detail_prd WHERE id_proc = '".sql_esc($row["proc_reject"])."'";
	 $rst_proc = mysqli_query($dbc,$query_proc);
     $row_proc = mysqli_fetch_array($rst_proc);
	
	 //---type of reject
	 $query_type = "SELECT * FROM type_reject_detail_prd WHERE id_type = '".sql_esc($row["type_reject"])."' AND status_type = 'Y' ORDER BY id_type ASC";
	 $result_type = mysqli_query($dbc,$query_type);
	 $row_type = mysqli_fetch_array($result_type); 
	 
	  //---defect
	 $query_defect = "SELECT * FROM type_defect_detail_prd WHERE id_defect = '".sql_esc($row["type_defect"])."' AND status_defect = 'Y' ORDER BY id_defect ASC";
	 $result_defect = mysqli_query($dbc,$query_defect);
	 $row_defect = mysqli_fetch_array($result_defect); 
 
  //-----change plant id to plant name
  
  if($row["plant_cd"] == "3100")
  {
	  $plant_new = "SERENDAH";
	  
  }elseif($row["plant_cd"] == "3101")
  {
	  $plant_new = "MLK";
  }else{
	  
	  $plant_new = "";
  }
	
	
	//-----change status disposal
  
  if($row["status_disposal"] == ($rst_sta15["status_desc"]))
  {
	  $status_new = "New";
	  
  }elseif($row["status_disposal"] == ($rst_sta32["status_desc"]))
  {
	  $status_new = "New";
	  
  }elseif($row["status_disposal"] == ($rst_sta34["status_desc"]))
  {
	  $status_new = "New";
	  
  }elseif($row["status_disposal"] == ($rst_sta29["status_desc"]))
  {
	  $status_new = "Pending Exec. QC";
  }else{
	  
	  $status_new = "None";
  } 
  
  
     //----line ---
  
 $query_Mod2 = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($row["work_center"])."' AND status_wc = 'Y' ORDER BY id ASC";
 $result_Mod2 = mysqli_query($dbc,$query_Mod2);
 $row_Mod2 = mysqli_fetch_array($result_Mod2);  
 
  if($row_Mod2["wc_desc2"] == "")
  {
	  $model_name2 = $row_Mod2["id_work"];
  }else{
	  
	 $model_name2 = $row_Mod2["wc_desc2"]; 
  }
  
  
	   
      ?>
                <tr>
                <td width="30"><div align="center"><?php echo $no4; ?><br>
                <!--<input type="checkbox" name="id_item[<?php echo $row["id_disposal"]; ?>]" value="<?php echo $row["id_disposal"]; ?>" />-->
                  <input name="id_item[<?php echo $row["id_disposal"]; ?>]" type="hidden" value="<?php echo $doc_dis; ?>">
 </div> </td>
                <td width="150"><?php echo $row["doc_dis"]; ?></td> 
                <td width="100"><?php echo $row["R"]; ?></td> 
                <td width="100"><?php echo $row["work_center"]; ?></td> 
                <td width="80"><?php echo $status_new; ?></td> 
                <td width="100">
                 <a href="#myNoteEdit<?php echo $row["doc_dis"]; ?>" data-toggle="modal"  target="_parent"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;Edit</a> 
                 
                 <?php 
                 if($row["status_part"] == 'PR'){    
                 
                include "detail_list_bf_disposal-prd_edt.php";   
               }elseif($row["status_part"] == 'ENG'){    

                 include "detail_list_bf_disposal-prd_edtENG.php";   
                }

                 ?>
              </td> 
                <td width="100">
              <?php if($row["status_part"] == 'PR'){    
                  if($row["stamp_ind"] == 'STM')
		         {
					 ?>
             <a href="detail_list_bf_disposal-prd_print-stm.php?buid=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a> 
              <?php 
			     }elseif($row["stamp_ind"] == 'BLK')
		         {
					 ?>
             <a href="detail_list_bf_disposal-prd_print-stm.php?buid=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a> 
              <?php  }elseif($row["stamp_ind"] == 'ASSY') {?>
              
             <a href="detail_list_bf_disposal-prd_print.php?buid=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a> 
             
              <?php }else{}
              
              }elseif($row["status_part"] == 'ENG'){               ?>    
                
          <a href="print_dis_approve_qc-tranProc-ENG.php?buid=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a> 

                <?php }else{} ?>
              </td> 
                <td width="100">
                 <a href="#myNoteCancelDIS<?php echo $row["doc_dis"]; ?>" data-toggle="modal" target="_parent"><i class="fa fa-window-close" aria-hidden="true"></i>Cancel</a> 
             <!--------------------------modal-------------------------> 
             
			 <?php         
                   if(($row["stamp_ind"] == 'STM') && ($row["status_disposal"] == ($rst_sta32["status_desc"])))
		         {
			       include "cancel_list_bf_disposal-prd_sel-stm.php";
				    
				 }elseif(($row["stamp_ind"] == 'BLK') && ($row["status_disposal"] == ($rst_sta32["status_desc"])))
		         {
			       include "cancel_list_bf_disposal-prd_sel-stm.php";
				    
				 }elseif(($row["stamp_ind"] == 'ASSY') && ($row["status_disposal"] == ($rst_sta34["status_desc"])))
		         {
				  
				    include "cancel_list_bf_disposal-prd_sel-assy.php";

          }elseif(($row["stamp_ind"] == 'ASSY') && ($row["status_disposal"] == ($rst_sta32["status_desc"])))
          {
       
         include "cancel_list_bf_disposal-prd_sel-stm.php";
			  
		         }elseif(($row["status_part"] == 'ENG') && ($row["status_disposal"] == ($rst_sta15["status_desc"])))
             {
             
              include "cancel_list_bf_disposal-prd_sel-ENG.php";
             
            }else{
		  		   include "cancel_list_bf_disposal-prd_sel.php";
				   
				 } ?>

              </td> 
                </tr>
                  
          <?php 
		  
		  $no4++;
		  $counter++; // menambah counter
		  } 
		  
		  
		  ?>
       <input name="date1" type="hidden" value="<?php echo $_GET["date1"] ?>"> 
       <input name="date2" type="hidden" value="<?php echo $_GET["date2"] ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
       <input name="work_center" type="hidden" value="<?php echo $work_center; ?>">  
               
         
 </tbody>
</table><!--</form>-->

</div> 
<br><br>
<?php
   mysqli_free_result($rsGR); 
   
 ?>
 
     
 
 <?php
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
	?>	   
		   </form>
           
  <?php         
//mysqli_close($dbc)
?>

                       
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
    <!--<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>-->
    <script type="text/javascript">$('#example').DataTable();</script>
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    
    
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
		
		var strURL="findPlant4_dis_aprvPro2.php?plant_code="+plant_code;
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
	</script>
  </body>
</html>