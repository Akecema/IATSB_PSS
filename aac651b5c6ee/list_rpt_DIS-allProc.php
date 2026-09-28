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
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	include 'apprv_func_list.php';  
	
//--------function user --------------------------
$query_fuct = new PreparedSql("SELECT * FROM  function_acc_detail WHERE staff_ID = ?", [$res["staff_ID"]]);
$rs_fuct = db_query($dbc, $query_fuct);   //run the query.
$num_fuct = mysqli_num_rows($rs_fuct);   //how many material are there?
$data_fuct = mysqli_fetch_array($rs_fuct);
//----------------------------------------------------
	
    $url = "list_rpt_DIS_all.php";
	
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

//CR status (Pending Approval Exec QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

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
        width: 1500px;
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
          <h1><i class="fa fa-file-text-o"></i> Report</h1>
          <p>Disposal Report</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Report</li>
          <li class="breadcrumb-item"><a href="list_rpt_DIS_all.php">Disposal Report</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Disposal Report </h3>
            <div class="tile-body">
              <div class="table-responsive">
          <?php
		  
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
        	$plant_code = $_GET["plant_code"]; 
			$work_center = $_GET["work_center"];
			$material_no = $_GET["material_no"]; 
			//$doc_dis = $_GET["doc_dis"];
			$rej_opt = $_GET["rej_opt"];  
			
			
		  ?>    
              
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <br><br>
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
                <th>Reject Source : </th>
                <th colspan="3">
              <select name="rej_opt" id="rej_opt" class="form-control">
              <option value="NULL" placeholder="Select Reject Source"> -- Select Reject Source --</option>
              <option value="BFNG" <?php if($_GET["rej_opt"] == 'BFNG') { ?> selected="selected"<?php } ?>>Backflush</option>
              <option value="BFPEND" <?php if($_GET["rej_opt"] == 'BFPEND') { ?> selected="selected"<?php } ?>>Pending</option>
              <option value="BFRWK" <?php if($_GET["rej_opt"] == 'BFRWK') { ?> selected="selected"<?php } ?>>Rework</option>
              <?php if(($data_fuct["f_stamp_prd"] == 'Y') || ($data_fuct["f_assy_prd"] == 'N')) { ?> <option value="BFHWORK" <?php if($_GET["rej_opt"] == 'BFHWORK') { ?> selected="selected"<?php } ?>>Handwork</option><?php } ?>
              <option value="CREJ" <?php if($_GET["rej_opt"] == 'CREJ') { ?> selected="selected"<?php } ?>>Component Reject</option>
              </select>  
             </th>
              </tr>
               <tr>
                <th>Part Number :</th>
                <th><div id="mat_div"> <select name="material_no" id="material_no" class="form-control">
                  <option value="NULL" placeholder="Select Part Number"> -- Select Part Number --</option>
                                  </select></div></th>
              </tr>
              <!-- <tr>
               <th>Disposal Doc. No. : </th>
                <th>
               		
           <select name="doc_dis" class="form-control">
            <option value="NULL" placeholder="Select Disposal Doc. No."> -- Select Disposal Doc. No. -- </option>
          <?php
          //Retrieve and display the available types
         /* $query57 = 'SELECT * FROM disposal_detail_prd_all WHERE status_part = "PR" GROUP BY doc_dis';
          $result57 = mysqli_query($dbc,$query57);
          
              while($row57 = mysqli_fetch_array($result57)) {*/
        
              ?>
       
         <option value="<?php //echo $row57["doc_dis"]; ?>" <?php //if($row57["doc_dis"] == $_GET["doc_dis"]) echo "selected"; ?>> <?php //echo stripslashes($row57["doc_dis"]); ?> </option>
          <?php
          // }  ?>
                            
        </select> 
                </th>
              </tr>-->
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
                    $wheresql_01 = " AND plant_cd = '".sql_esc($plant_code)."'"; }  	
					
		   // 2. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (date_disposal >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //3. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
					$wheresql_03 = " AND (date_disposal <= '".sql_esc($date2_final)."')"; }
					
					
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
					
		/*  //6. Doc Disposal.
                if ($doc_dis == "NULL"){ 
                    $wheresql_06 = ""; }
                else {
                    $wheresql_06 = " AND doc_dis = '$doc_dis'"; } */
					
					
			//7. Reject Source
                if ($rej_opt == "NULL"){ 
                    $wheresql_07 = ""; }
                else {
                    $wheresql_07 = " AND reject_source = '".sql_esc($rej_opt)."'"; } 		
					
					
					
					 	
					
						
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05 .$wheresql_07;
						
	
	//********** END CONDITION **************
	
		  
 			
			
   $query8GR = "SELECT COUNT(*) FROM disposal_detail_prd_all WHERE status_part = 'PR' " .$where_sql ." ORDER BY doc_dis ASC ";
   $result8GR = mysqli_query($dbc,$query8GR);
   $num_rowsGR = mysqli_num_rows($result8GR);
			
  
$queryGR = "SELECT *,DATE_FORMAT(date_plan,'%d-%m-%Y') as TW, DATE_FORMAT(date_posting,'%d-%m-%Y') as T, DATE_FORMAT(date_disposal,'%d-%m-%Y') AS T3, DATE_FORMAT(date_approved,'%d-%m-%Y') AS T9, DATE_FORMAT(date_approved2,'%d-%m-%Y') AS T19, DATE_FORMAT(date_approved3,'%d-%m-%Y') AS T29, DATE_FORMAT(date_approved4,'%d-%m-%Y') AS T39, DATE_FORMAT(date_approved5,'%d-%m-%Y') AS T49, DATE_FORMAT(date_cancel,'%d-%m-%Y') as T75 FROM disposal_detail_prd_all WHERE status_part = 'PR' " .$where_sql." ORDER BY doc_dis ASC ";
$rsGR = mysqli_query($dbc,$queryGR);
$num_rowsGR = mysqli_num_rows($rsGR);   //how many material are there?
    
		  
		 if ($num_rowsGR > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rowsGR.' record(s).</div>'; 
	   
        
    	?>
        
         <table class="table">
            <tr>
                <td width="1%">&nbsp;</td> 
                <td width="85%">&nbsp;</td> 
                  <td width="7%"><a href="list_rpt_DIS-all_dLoad.php?plant_code=<?php echo html_esc($plant_code); ?>&&date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&work_center=<?php echo html_esc($work_center); ?>&&material_no=<?php echo html_esc($material_no); ?>&&rej_opt=<?php echo html_esc($rej_opt); ?>" ><img src="../images/dload_excel.jpg" width="48" height="48" title="Download" /></a></td>
                 <td width="7%"><!--<img src="../images/print2.jpg" width="48" height="48" onClick="window.print()" title="Print"/>--></td>
              </tr>
            </table> 
     
                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>No</th>
                    <th>Model</th>
                    <th>Part Number</th>
                    <th>Planned Order No.</th>
                    <th>Planned Date</th>
                    <th>NG Doc. No.</th>  
                    <th>Disposal Doc. No.</th>
                    <th>Posting Date</th>
                    <th>Reject Source</th>
                    <th>Quantity</th>
                    <th>Type of Reject</th>
                    <th>Defectives</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Approved/Rejected Date</th>
                    <th>Disposal Cancellation</th>
                    <th>Disposal Cancellation Date</th>
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
	   
	   if($row["shift_posting"] == "D/S")
	   {
		   $shift_ds = "Day";
	   }elseif($row["shift_posting"] == "N/S")
	   {
		 $shift_ds = "Night";
	   }else{
		   
		   $shift_ds = "NA"; 
	   }
	
	
	//------- quantity	
	
	if($row["qty_NG"] != "0.000")
	{
		$qty_new = $row["qty_NG"];
		
	}elseif($row["qty_qc"] != "0.000")
	{
		$qty_new = $row["qty_qc"];
	}else{
		
		
	}
	
	 //-----user canccellation-----------
		 
		 $query_u_can = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$row["user_cancel"]]); 
		 $rs_u_can = db_query($dbc, $query_u_can);   //run the query.
		 $data_u_can = mysqli_fetch_array($rs_u_can);
	
	 //---type of reject
 $query_type = new PreparedSql("SELECT * FROM type_reject_detail_prd WHERE id_type = ? AND status_type = 'Y' ORDER BY id_type ASC", [$row["type_reject"]]);
 $result_type = db_query($dbc, $query_type);
 $row_type = mysqli_fetch_array($result_type); 
 
  //---defect
 $query_defect = new PreparedSql("SELECT * FROM type_defect_detail_prd WHERE id_defect = ? AND status_defect = 'Y' ORDER BY id_defect ASC", [$row["type_defect"]]);
 $result_defect = db_query($dbc, $query_defect);
 $row_defect = mysqli_fetch_array($result_defect);   
 
 
 //----source disposal------
   $sta_out = substr($row["doc_dis"],4,3);	
   
       if($sta_out == "311")
	  {
		  
	  $source_dis = "Backflush";	  
		  
	  }elseif($sta_out == "321")
	  {
		   $source_dis = "Pending";
 
	   }elseif($sta_out == "331")
	  {
		   $source_dis = "Handwork";
	   
	   }elseif($sta_out == "341")
	  {
		  
		  $source_dis = "Rework"; 
	  }elseif($sta_out == "351")
	  {
		  
		  $source_dis = "Component Reject"; 
	  }
	
	
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
		 
		 if($row["status_approved2"] == ($rst_sta3["status_desc"]))
	     {
		
		$sta_dis = "Approved COO";
		$dt_dis = $row["T19"]; 
	  	
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
		
		$sta_dis = "Rejected QD";
		$dt_dis = $row["T19"]; 
		
		}elseif($row["status_approved3"] == ($rst_sta5["status_desc"]))
		{
		
		$sta_dis = "Rejected COO";
		$dt_dis = $row["T29"]; 
		
		}elseif($row["status_approved4"] == ($rst_sta5["status_desc"]))
		{
		
		$sta_dis = "Rejected ".$rst_apprv8["apprv_name2"];
		$dt_dis = $row["T39"]; 
		
		}elseif($row["status_approved5"] == ($rst_sta5["status_desc"]))
		{
		
				if($row["stamp_ind"] == "ASSY")
				{
				
				$sta_dis = "Rejected ".$rst_apprv4["apprv_name2"];
				$dt_dis = $row["T49"]; 	
					
				}elseif($row["stamp_ind"] == "STM")
				{
				
				
				$sta_dis = "Rejected ".$rst_apprv3["apprv_name2"];
				$dt_dis = $row["T49"]; 
				
				}else{  }
		
		
		
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
		
		$sta_dis = "Approved QC";
		$dt_dis = $row["T19"]; 
		
	}elseif($row["status_disposal"] == ($rst_sta25["status_desc"]))
	{
		
		$sta_dis = "Approved COO";
		$dt_dis = $row["T29"]; 
		
	}elseif($row["status_disposal"] == ($rst_sta29["status_desc"]))
	{
		
		       if($row["stamp_ind"] == "ASSY")
				{
				
				$sta_dis = "Approved ".$rst_apprv4["apprv_name2"];
				$dt_dis = $row["T49"]; 	
					
				}elseif($row["stamp_ind"] == "STM")
				{
				
				
				$sta_dis = "Approved ".$rst_apprv3["apprv_name2"];
				$dt_dis = $row["T49"]; 
				
				}else{  }
	
		
	}elseif($row["status_disposal"] == ($rst_sta25["status_desc"]))
	{
		
		$sta_dis = "Approved QD";
		$dt_dis = $row["T29"]; 
	}elseif($row["status_disposal"] == ($rst_sta4["status_desc"]))
	{
		
		$sta_dis = "Cancelled";
		$dt_dis = $row["T75"]; 
	}
   
      ?>
                <tr>
                <td width="30"><?php echo $no4; ?></td>
                <td width="80"><?php echo html_esc($row["model_code"]); ?></td>
                <td width="200"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="150"><?php echo html_esc($row["plan_no"]); ?></td> 
                <td width="150"><?php echo html_esc($row["TW"]); ?></td>
                <td width="150"><?php echo html_esc($row["bflush_qqc_no"]); ?></td> 
                <td width="150"><?php echo html_esc($row["doc_dis"]); ?></td> 
                <td width="150"><?php echo html_esc($row["T"]); ?></td> 
                <td width="100"><?php echo $source_dis; ?></td> 
                <td><?php if($row["UOM_unit"] == 'KG') { ?> <?php echo $qty_new; ?> <?php }else{ ?><?php echo intval($qty_new); ?> <?php } ?></td>
                <td width="100"><?php echo html_esc($row_type["type_desc"]); ?></td> 
                <td width="100"><?php echo html_esc($row_defect["defect_desc"]); ?></td>
                <td width="150"><?php echo html_esc($row["reason_reject"]); ?></td>
                <td width="150"><?php echo $sta_dis; ?></td>
                <td width="150"><?php if($dt_dis != "00-00-0000") { echo $dt_dis;  }else{  echo "&nbsp;"; } ?> </td>
                <td width="150"><?php echo html_esc($row["disposal_no_ref"]); ?></td>
                <td width="150"><?php if($row["date_cancel"] != "0000-00-00 00:00:00") { echo html_esc($row["T75"]); }?></td>
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
mysqli_close($dbc);
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