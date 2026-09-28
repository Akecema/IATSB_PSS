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
	
    $url = "detail_PRD_cancel_bflush.php";
	
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

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);


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
        width: 1400px;
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
          <h1><i class="fa fa-file-text-o"></i> Production</h1>
          <p>Cancellation</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Production</li>
          <li class="breadcrumb-item"><a href="detail_PRD_cancel_bflush.php">Cancellation</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Cancellation </h3>
            <div class="tile-body">
              <div class="table-responsive">
               <ul class="nav nav-tabs">
               <li class="nav-item"><a class="nav-link" href="detail_PRD_cancel_bflush.php">Cancellation </a></li>
               <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="detail_PRD_afcancel_bflush.php">Cancelled</a></li>
                          
              </ul>    
          <?php
		  
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
        	$trans_opt = $_GET["trans_opt"]; 
			$plant_code = $_GET["plant_code"]; 
			$work_center = $_GET["work_center"];
			$material_no = $_GET["material_no"]; 
		
			if($_GET["trans_opt"] == "ABFOK")
			 
			 {
				 
			echo "<script>";
            echo "window.location='canC_bf_aftran_OK-prdProc.php?plant_code=".html_esc($plant_code)."&&trans_opt=".html_esc($trans_opt)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
			 }elseif($_GET["trans_opt"] == "ABFNG")
			 {
				 
			echo "<script>";
            echo "window.location='canC_bf_aftran_NG-prdProc.php?plant_code=".html_esc($plant_code)."&&trans_opt=".html_esc($trans_opt)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
			 }
			 elseif($_GET["trans_opt"] == "ABFPEND")
			 {
				 
			echo "<script>";
            echo "window.location='canC_bf_aftran_PEND-prdProc.php?plant_code=".html_esc($plant_code)."&&trans_opt=".html_esc($trans_opt)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
			 }
			  elseif($_POST["trans_opt"] == "ABFHWOK")
			 {
				 
			echo "<script>";
            echo "window.location='canC_bf_aftran_HWOK-prdProc.php?plant_code=".html_esc($plant_code)."&&trans_opt=".html_esc($trans_opt)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
				 
			 } 
			 elseif($_GET["trans_opt"] == "APENDCON")
			 {
				 
			echo "<script>";
            echo "window.location='canC_bf_afpend_Confirm-prdProc.php?plant_code=".html_esc($plant_code)."&&trans_opt=".html_esc($trans_opt)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
				 
			 }elseif($_GET["trans_opt"] == "ACONHWOK")
			 {
				 
			echo "<script>";
            echo "window.location='canC_bf_afConfirm_Hwork-prdProc.php?plant_code=".html_esc($plant_code)."&&trans_opt=".html_esc($trans_opt)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
			 }else{
				 
	
			 }
			
		  ?>    
              
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="3">&nbsp;</th>
            </tr>
            <tr>
             <th>Transaction :</th>
                <th colspan="3">
              <select name="trans_opt" id="trans_opt" class="form-control">
              <option value="NULL" placeholder="Select Process"> -- Select Process --</option>
              <option value="ABFOK" <?php if($_GET["trans_opt"] == 'ABFOK') { ?> selected="selected"<?php } ?>>Backflush OK</option>
              <option value="ABFNG" <?php if($_GET["trans_opt"] == 'ABFNG') { ?> selected="selected"<?php } ?>>Backflush NG</option>
              <option value="ABFPEND" <?php if($_GET["trans_opt"] == 'ABFPEND') { ?> selected="selected"<?php } ?>>Backflush PENDING</option>
              <option value="ABFHWOK" <?php if($_GET["trans_opt"] == 'ABFHWOK') { ?> selected="selected"<?php } ?>>Backflush HANDWORK</option>
              <option value="APENDCON" <?php if($_GET["trans_opt"] == 'APENDCON') { ?> selected="selected"<?php } ?>>Pending</option>
              <option value="ACONHWOK" <?php if($_GET["trans_opt"] == 'ACONHWOK') { ?> selected="selected"<?php } ?>>Handwork</option>
              <option value="ACONRWK" <?php if($_GET["trans_opt"] == 'ACONRWK') { ?> selected="selected"<?php } ?>>Rework</option>
              </select>    
     			</th>
              </tr>
             
             <tr>
            <th>Date From : <font color="#FF0000">*</font></th>
            <td>
           <?php
			     $dd1 = substr($_GET["date1"],8,2);
				 $mm1 = substr($_GET["date1"],5,2);
				 $yy1 = substr($_GET["date1"],0,4);
			?>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" >
		     </td>
             </tr>
             <tr>
              <th>Date To : <font color="#FF0000">*</font></th>
              <td><?php
			     $dd2 = substr($_GET["date2"],8,2);
				 $mm2 = substr($_GET["date2"],5,2);
				 $yy2 = substr($_GET["date2"],0,4);
			?>
             <input class="form-control" id="PSSDate2" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>" ></td>
              </tr>
              <tr>
            <th>Plant : </th>
            <td colspan="3">
           <select name="plant_code" class="form-control" onChange="getWorkCenter(this.value)">
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
                </select>
		     </td>
             </tr>
              <tr>
                <th>Line :</th>
                <th><div id="work_centerdiv"><select name="work_center" id="work_center" class="form-control" onChange="getMaterial(this.value)">
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
                </select></div></th>
              </tr>
               <tr>
                <th>Part Number :</th>
                <th><div id="mat_div"> <select name="material_no" id="material_no" class="form-control">
                  <option value="NULL" placeholder="Select Part Number"> -- Select Part Number --</option>
                                  </select></div></th>
              </tr>
          
              <tr>
                <th><input name="Submit22" type="submit" class="btn btn-info" id="button" value="SEARCH" />
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
                    $wheresql_01 = " AND plant_code = '".sql_esc($plant_code)."'"; }  	
					
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
   
	       //5. Part Number
                if ($material_no == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND material_no = '".sql_esc($material_no)."'"; }  	
                            
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;
						
	
	//********** END CONDITION **************
	
		  
 			
			
   $query8GR = "SELECT COUNT(*) FROM pps_detail_trn_fg_pending_confirm_rework WHERE status_pps = '".sql_esc($rst_sta4["status_desc"])."' " .$where_sql ." ORDER BY bflush_no ASC ";
   $result8GR = mysqli_query($dbc,$query8GR);
   $num_rowsGR = mysqli_num_rows($result8GR);
			
  
$queryGR = "SELECT *, DATE_FORMAT(date_rw_posting,'%d-%m-%Y') as R, DATE_FORMAT(date_cancel,'%d-%m-%Y') as R5 FROM pps_detail_trn_fg_pending_confirm_rework WHERE status_pps = '".sql_esc($rst_sta4["status_desc"])."' " .$where_sql." ORDER BY bflush_no ASC ";
$rsGR = mysqli_query($dbc,$queryGR);
$num_rowsGR = mysqli_num_rows($rsGR);   //how many material are there?
    
		  
		 if ($num_rowsGR > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rowsGR.' record(s).</div>'; 
	   
        
    	?>
      
                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>No</th>
                    <th>Model</th>
                    <th>Part Number</th>
                    <th>Planned Order No.</th>
                    <th>BF Doc. No.</th>  
                    <th>Rework Doc. No.</th>
                    <th>Posting Date</th> 
                    <th>Posting Time</th>
                    <th>Line</th>
                    <th>Shift</th>
                    <th>Cancellation Doc. No</th>
                    <th>Cancellation Date</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Cancelled By</th>
                </tr>
              </thead>    
              <tbody>
           <?php 

   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   
   while($row = mysqli_fetch_array($rsGR))
   {
	   
	   //-----shift-----
	   
	   if($row["shift_rwk"] == "D/S")
	   {
		   $shift_ds = "Day";
	   }elseif($row["shift_rwk"] == "N/S")
	   {
		 $shift_ds = "Night";
	   }else{
		   
		   $shift_ds = "NA"; 
	   }
	   
	
    //----model ---
  
 $query_Mod = "SELECT * FROM model_detail_tbl WHERE model_code = '".sql_esc($row["model_code"])."' AND plant_code = '".sql_esc($row["plant_code"])."' AND status_model = 'Y' ORDER BY id_model ASC";
 $result_Mod = mysqli_query($dbc,$query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  
 
  if($row_Mod["model_desc"] == "")
  {
	  $model_name = $row_Mod["model_desc"];
  }else{
	  
	 $model_name = $row_Mod["model_desc"]; 
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
	   
	   //-----Qunatity Rework -----
	   
	   if($row["status_butn"] == "OK")
	   {
		   $qty_RWK_new = $row["qty_RW_OK"];
		   
	   }elseif($row["status_butn"] == "NG")
	   {
		 $qty_RWK_new = $row["qty_RW_NG"];
	   }else{
		   
		   $qty_RWK_new = "NA"; 
	   }
	   
	   //-----user canccellation-----------
		 
		 $query_u_can = "SELECT * FROM user_detail WHERE username = '".sql_esc($row["user_cancel"])."'"; 
		 $rs_u_can = mysqli_query($dbc,$query_u_can);   //run the query.
		 $data_u_can = mysqli_fetch_array($rs_u_can);
      ?>
                <tr>
                <td width="30"><?php echo $no4; ?></td>
                <td width="80"><?php echo $model_name; ?></td>
                <td width="200"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="200"><?php echo html_esc($row["plan_no"]); ?></td>
                <td width="150"><?php echo html_esc($row["bflush_pending"]); ?></td> 
                <td width="150"><?php echo html_esc($row["bflush_rework"]); ?></td> 
                <td width="100"><?php echo html_esc($row["R"]); ?></td> 
                <td width="100"><?php echo html_esc($row["time_rw_posting"]); ?></td> 
                <td width="80"><?php echo $model_name2; ?></td> 
                <td width="80"><?php echo $shift_ds; ?></td>
                <td width="150"><?php echo html_esc($row["bflush_no_ref"]); ?></td> 
                <td width="150"><?php echo html_esc($row["R5"]); ?>  </td>  
                <td width="100"><?php echo intval($qty_RWK_new); ?></td>
                <td width="100"><?php echo html_esc($row["status_butn"]); ?></td>
                <td width="200"><?php echo html_esc($row["user_cancel"]).' '.html_esc($data_u_can["user_fullname"]);    ?>  </td>
                </tr>
                 
          <?php 
		  
		  $no4++;
		  $counter++; // menambah counter
		  } 
		  
		  
		  ?>

         
 </tbody>
</table><!--</form>-->
 <br>

<?php
   mysqli_free_result($rsGR); 
   
 
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
mysqli_close($dbc)
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
		
		var strURL="findPlant4Can.php?plant_code="+plant_code;
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
		
		var strURL="findMaterial4Can.php?work_center="+work_center;
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
  </body>
</html>