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

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
    $url = "print_tag_backflush_trn_fg.php";
	
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
         <h1><i class="fa fa-bar-chart"></i> Backflush</h1>
          <p>Print Tag</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Backflush</li>
          <li class="breadcrumb-item"><a href="print_tag_backflush_trn_fg.php">Print Tag</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Print Tag </h3>
            <div class="tile-body">
              <div class="table-responsive">
          <?php
		  
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
        	$trans_opt = $_GET["trans_opt"]; 
			$plant_code = $_GET["plant_code"]; 
			$work_center = $_GET["work_center"];
			$plan_no = $_GET["plan_no"]; 
			
			
		   if($_GET["trans_opt"] == "BFPEND")
			 {
				 
			echo "<script>";
            echo "window.location='printT_tag_bf_trn_PEND-prdProc.php?date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&plant_code=".html_esc($plant_code)."&&work_center=".html_esc($work_center)."&&plan_no=".html_esc($plan_no)."&&trans_opt=".html_esc($trans_opt)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
			 }
			 elseif($_GET["trans_opt"] == "BFHWOK")
			 {
				 
			echo "<script>";
            echo "window.location='printT_tag_bf_trn_HWOK-prdProc.php?date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&plant_code=".html_esc($plant_code)."&&work_center=".html_esc($work_center)."&&plan_no=".html_esc($plan_no)."&&trans_opt=".html_esc($trans_opt)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
				 
			 }			 
			 elseif($_GET["trans_opt"] == "PENDCON")
			 {
				 
			echo "<script>";
            echo "window.location='printT_bf_pend_Confirm-prdProc.php?date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&plant_code=".html_esc($plant_code)."&&work_center=".html_esc($work_center)."&&plan_no=".html_esc($plan_no)."&&trans_opt=".html_esc($trans_opt)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
				 
			 }elseif($_GET["trans_opt"] == "CONHWOK")
			 {
				 
			echo "<script>";
            echo "window.location='printT_bf_pend_Confirm_Hwork-prdProc.php?date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&plant_code=".html_esc($plant_code)."&&work_center=".html_esc($work_center)."&&plan_no=".html_esc($plan_no)."&&trans_opt=".html_esc($trans_opt)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
				 
			 }elseif($_GET["trans_opt"] == "CONRWK")
			 {
				 
			echo "<script>";
            echo "window.location='printT_bf_pend_Confirm_Rwork-prdProc.php?date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&plant_code=".html_esc($plant_code)."&&work_center=".html_esc($work_center)."&&plan_no=".html_esc($plan_no)."&&trans_opt=".html_esc($trans_opt)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
				 
			 }else{
				 
		
				 
			 }
					
		  ?>    
              
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <br>
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="3">&nbsp;</th>
            </tr>
             <tr>
                <th>Output Status :<font color="#FF0000">*</font></th>
                <th colspan="3">
              <select name="trans_opt" id="trans_opt" class="form-control">
              <option value="NULL" placeholder="Select Output Status"> -- Select Output Status --</option>
              <option value="BFOK" <?php if($_GET["trans_opt"] == 'BFOK') { ?> selected="selected"<?php } ?>>Backflush OK</option>
              <option value="BFPEND" <?php if($_GET["trans_opt"] == 'BFPEND') { ?> selected="selected"<?php } ?>>Backflush PENDING</option>
              <option value="BFHWOK" <?php if($_GET["trans_opt"] == 'BFHWOK') { ?> selected="selected"<?php } ?>>Backflush HANDWORK</option>
              <option value="PENDCON" <?php if($_GET["trans_opt"] == 'PENDCON') { ?> selected="selected"<?php } ?>>Pending OK</option>
              <option value="CONHWOK" <?php if($_GET["trans_opt"] == 'CONHWOK') { ?> selected="selected"<?php } ?>>Handwork OK</option>
              <option value="CONRWK" <?php if($_GET["trans_opt"] == 'CONRWK') { ?> selected="selected"<?php } ?>>Rework OK</option>
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
                </select></div></th>
              </tr>
               <tr>
                <th>Planned Order No. :</th>
                <th><select name="plan_no" class="form-control">
            <option value="NULL" placeholder="Select Planned Order No."> -- Select Planned Order No. -- </option>
          <?php
          //Retrieve and display the available pps_detail
          $query57 = "SELECT * FROM pps_detail WHERE status_pps = '".sql_esc($rst_sta7["status_desc"])."'";
          $result57 = mysqli_query($dbc,$query57);
          
              while($row57 = mysqli_fetch_array($result57)) {
        
              ?>
               <option value="<?php echo html_esc($row57["plan_no"]); ?>" <?php if($row57["plan_no"] == $_GET["plan_no"]) echo "selected"; ?>> <?php echo stripslashes($row57["plan_no"]); ?> </option>
       
          <?php
           }  ?>
                            
        </select></th>
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
   
	       //5. Plan No.
                if ($plan_no == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND plan_no = '".sql_esc($plan_no)."'"; }  	
					
		/*	//6. Doc No.
                if ($bflush_no == "NULL"){ 
                    $wheresql_06 = ""; }
                else {
                    $wheresql_06 = " AND bflush_no = '$bflush_no'"; }  */
		    	
	                                        
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;
						
	
	//********** END CONDITION **************
	
		  
 			
			
   $query8GR = "SELECT COUNT(*) FROM pps_detail_trn_fg_ok WHERE (status_pps = '".sql_esc($rst_sta7["status_desc"])."' OR status_pps = '".sql_esc($rst_sta14["status_desc"])."' OR status_pps = '".sql_esc($rst_sta11["status_desc"])."') " .$where_sql ." ORDER BY bflush_no ASC ";
   $result8GR = mysqli_query($dbc,$query8GR);
   $num_rowsGR = mysqli_num_rows($result8GR);
			
  
$queryGR = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as R FROM pps_detail_trn_fg_ok WHERE (status_pps = '".sql_esc($rst_sta7["status_desc"])."' OR status_pps = '".sql_esc($rst_sta14["status_desc"])."' OR status_pps = '".sql_esc($rst_sta11["status_desc"])."') " .$where_sql." ORDER BY bflush_no ASC ";
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
                    <th>Posting Date</th>  
                    <th>Posting Time</th>
                    <th>Line</th>
                    <th>Shift</th>
                    <th>Quantity</th>
                    <th>Status</th>
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
	   
	   //-----shift-----
	   
	   if($row["shift_posting"] == "D/S")
	   {
		   $shift_ds = "Day";
	   }elseif($row["shift_posting"] == "N/S")
	   {
		 $shift_ds = "Night";
	   }else{
		   
		   $shift_ds = "NA"; 
	   }
	   
	   
	   //-----change plant id to plant name
  
  if($row["plant_code"] == "3100")
  {
	  $plant_new = "BB";
	  
  }elseif($row["plant_code"] == "3101")
  {
	  $plant_new = "MLK";
  }else{
	  
	  $plant_new = "";
  }
  
  
  //------check status spare part in table_material_itsb
  
  $query_spare = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($row["material_no"])."' AND status_BOM = 'Y' AND status_sp = 'Y'";
  $result_spare = mysqli_query($dbc,$query_spare);
  $data_spare = mysqli_fetch_array($result_spare);
      ?>
                <tr>
                <td width="30"><?php echo $no4; ?></td>
                <td width="80"><?php echo html_esc($row["model_code"]); ?></td>
                <td width="200"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="150"><?php echo html_esc($row["plan_no"]); ?></td> 
                <td width="150"><?php echo html_esc($row["bflush_no"]); ?></td> 
                <td width="100"><?php echo html_esc($row["R"]); ?></td> 
                <td width="100"><?php echo html_esc($row["time_posting"]); ?></td>
                <td width="80"><?php echo html_esc($row["work_center"]); ?></td> 
                <td width="80"><?php echo $shift_ds; ?></td>
                <td width="100"><?php echo intval($row["qty_actual"]); ?></td>
                <td width="100">BF OK</td>
                <td width="200">  
                <?php
				
				//----- Bflush OK FERT or HALB ----
        
		if($row["stamp_ind"] == "STM")   
		{     
				if($row["material_type"] == "Z301")
				{   ?>          
                 
                 <a href="printT_tag_bf_trn_OKprd_sel.php?buid=<?php echo base64_encode($row["bflush_no"]);  ?>" target="_blank" class="btn btn-primary btn-sm"><img src="../images/print_new.png" width="16" height="16" alt="Print Tag">&nbsp;Print Tag</a>    
          <?php   }elseif($row["material_type"] == "Z201")
			    { 
				
				    if($data_spare["status_sp"] == "Y")
				     {   
				?>
				
	            <a href="printT_tag_bf_trn_OK4prd_sel.php?buid=<?php echo base64_encode($row["bflush_no"]);  ?>" target="_blank" class="btn btn-primary btn-sm"><img src="../images/print_new.png" width="16" height="16" alt="Print Tag">&nbsp;Print Tag</a>    
			
			<?php    }else{

		  ?>
                 <a href="printT_tag_bf_trn_OK2prd_sel.php?buid=<?php echo base64_encode($row["bflush_no"]);  ?>" target="_blank" class="btn btn-primary btn-sm"><img src="../images/print_new.png" width="16" height="16" alt="Print Tag">&nbsp;Print Tag</a>    
          <?php } }else{
		 
		         }
		  
		  
		}elseif($row["stamp_ind"] == "ASSY")
			{
				if($data_spare["status_sp"] == "Y")
				{   
				?>
				
	            <a href="printT_tag_bf_trn_OK4prd_sel.php?buid=<?php echo base64_encode($row["bflush_no"]);  ?>" target="_blank" class="btn btn-primary btn-sm"><img src="../images/print_new.png" width="16" height="16" alt="Print Tag">&nbsp;Print Tag</a>    
			
			<?php	}else{
				?>
                 <a href="printT_tag_bf_trn_OK3prd_sel.php?buid=<?php echo base64_encode($row["bflush_no"]);  ?>" target="_blank" class="btn btn-primary btn-sm"><img src="../images/print_new.png" width="16" height="16" alt="Print Tag">&nbsp;Print Tag</a>    
         <?php        
                 }
				 
		   }elseif($row["stamp_ind"] == "BLK")
			{
				
			   if($row["material_type"] == "Z301")
				{   ?>          
                 
                 <a href="printT_tag_bf_trn_OKprdBLK_sel.php?buid=<?php echo base64_encode($row["bflush_no"]);  ?>" target="_blank" class="btn btn-primary btn-sm"><img src="../images/print_new.png" width="16" height="16" alt="Print Tag">&nbsp;Print Tag</a>    
          <?php  
		        }elseif($row["material_type"] == "Z101")
			    { 
				
				?>
		       <a href="printT_tag_bf_trn_OK5prdRM_sel.php?buid=<?php echo base64_encode($row["bflush_no"]);  ?>" target="_blank" class="btn btn-primary btn-sm"><img src="../images/print_new.png" width="16" height="16" alt="Print Tag">&nbsp;Print Tag</a>    

				
		<?php	}else{  ?>
					
		        <a href="printT_tag_bf_trn_OK5prd_sel.php?buid=<?php echo base64_encode($row["bflush_no"]);  ?>" target="_blank" class="btn btn-primary btn-sm"><img src="../images/print_new.png" width="16" height="16" alt="Print Tag">&nbsp;Print Tag</a>    
	
					
			<?php	}
				
				
				
          }else{ 
		
		  ?>
	                 <a href="printT_tag_bf_trn_OK5prd_sel.php?buid=<?php echo base64_encode($row["bflush_no"]);  ?>" target="_blank" class="btn btn-primary btn-sm"><img src="../images/print_new.png" width="16" height="16" alt="Print Tag">&nbsp;Print Tag</a>    
	
		<?php
		
		  }  ?>  
                </td>
                 <td width="200">  
         <?php
		  
		  //----print tag size A4------
		         
                if(($row["stamp_ind"] == "BLK")  && ($row["material_type"] == "Z301"))
		    {     
		    ?> 
                
            <a href="printT_tag_bf_trn_OKprdBLK_sel_A4.php?buid=<?php echo base64_encode($row["bflush_no"]);  ?>" target="_blank" class="btn btn-info btn-sm"><img src="../images/print_new.png" width="16" height="16" alt="Print Tag A4">&nbsp;Print A4</a>    
            <?php   } ?>
                
                </td>
                
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