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

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	//--------function user --------------------------
$query_fuct = new PreparedSql("SELECT * FROM  function_acc_detail WHERE staff_ID = ?", [$res["staff_ID"]]);
$rs_fuct = db_query($dbc, $query_fuct);   //run the query.
$num_fuct = mysqli_num_rows($rs_fuct);   //how many material are there?
$data_fuct = mysqli_fetch_array($rs_fuct);
//----------------------------------------------------	
	
    $url = "detail_bf_disposal-prd.php";
	
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
           <h1><i class="fa fa-bar-chart"></i> Disposals</h1>
          <p>Reject Output</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Disposals</li>
          <li class="breadcrumb-item"><a href="detail_bf_HWORK_disposal-prd.php">Reject Output</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Reject Output </h3>
            <div class="tile-body">
              <div class="table-responsive">
              
               <ul class="nav nav-tabs">
                <?php if(($data_fuct["f_stamp_prd"] == 'Y') || ($data_fuct["f_assy_prd"] == 'Y')) {  ?> <li class="nav-item"><a class="nav-link" href="detail_bf_disposal-prd.php">Backflush NG </a></li><?php }  ?>
               <?php if(($data_fuct["f_stamp_prd"] == 'Y') || ($data_fuct["f_assy_prd"] == 'Y')) {  ?><li class="nav-item"><a class="nav-link" href="detail_bf_PEND_disposal-prd.php">Pending NG</a></li><?php }  ?>
               <?php if(($data_fuct["f_stamp_prd"] == 'Y') || ($data_fuct["f_assy_prd"] == 'N')) { ?>    <li class="nav-item"><a class="nav-link active" href="detail_bf_HWORK_disposal-prd.php">Handwork NG</a></li><?php }  ?>
                <?php if(($data_fuct["f_stamp_prd"] == 'Y') || ($data_fuct["f_assy_prd"] == 'Y')) {  ?>  <li class="nav-item"><a class="nav-link" href="detail_bf_RWK_disposal-prd.php">Rework NG</a></li><?php }  ?>               
              </ul> 
          <?php
		  
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
        	$plant_code = $_GET["plant_code"]; 
			$work_center = $_GET["work_center"];
			$material_no = $_GET["material_no"]; 
		   
			
			
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
                </select><div class="form-control-feedback" ><?php echo $message_pcode; ?></div>
		     </td>
             </tr>
              <tr>
                <th>Line :</th>
                <th><div id="work_centerdiv"><select name="work_center" id="work_center" class="form-control" onChange="getMaterial(this.value)">
                  <option value="NULL" placeholder="Select Line"> -- Select Line --</option>
                  <?php
	               $query5 = new PreparedSql("SELECT * FROM work_center_detail WHERE plant_code = ? AND dept_acc = 'PRODUCTION' AND status_wc = 'Y' ORDER BY id_work ASC", [$_GET["plant_code"]]);
                   $result5 = db_query($dbc, $query5);
  
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
                <th><input name="Submit25" type="submit" class="btn btn-info" id="button" value="SEARCH" />
              
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
   
	       //5. Part Number
                if ($material_no == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND material_no = '".sql_esc($material_no)."'"; }  	
					
			                                        
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;
						
	
	//********** END CONDITION **************
			
		  ?>     
                   
      <?php

$message_psdt = "";
$message_psdt2 = "";

if(isset($_POST["submit4"]))  
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

       $id_item = $_POST["id_item"]; 
	   $date_dis = $_POST["date_dis"];     
	   $id_disposal = $_POST["id_disposal"];  
	   $plant_code = $_POST["plant_code"]; 
	   $remarks = $_POST["remarks"];
	   $dateF = $_POST["date1"];
	   $dateT = $_POST["date2"];
	   $work_center = $_POST["work_center"];
	   $material_no = $_POST["material_no"];
	
		   
	    if((($_POST["date1"]) == "00-00-0000") || (($_POST["date1"]) == ""))
     {
	     $dateF = FALSE;
		 $message_psdt = '<span class="badge badge-pill badge-danger"> Please select Posting Date !</span>';
	 }else{
		 $dateF = TRUE;
	  }	
	  
	    if((($_POST["date2"]) == "00-00-0000") || (($_POST["date2"]) == ""))
     {
	     $dateT = FALSE;
		 $message_psdt2 = '<span class="badge badge-pill badge-danger"> Please select Posting Date !</span>';
	 }else{
		 $dateT = TRUE;
	  }	      
		   
	//------------checking date posting mesti sama -----------------
		   
	  /* foreach($_POST["id_item"] as $j=>$i) 
	   {
	   
	   $id_item = $_POST["id_item"]; 
	   $date_dis = $_POST["date_dis"];     
	   $id_disposal = $_POST["id_disposal"];  
	   $plant_code = $_POST["plant_code"]; 
	   $remarks = $_POST["remarks"];
	   $dateF = $_POST["date1"];
	   $dateT = $_POST["date2"];
	   $work_center = $_POST["work_center"];
	   $material_no = $_POST["material_no"];
	   
	  
		  
	     }//for each
	 		*/

  if($dateF && $dateT)
  {
	  
	   //-------------------generate Disposal doc no.---------------
	
		
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '25'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "331";
	$dg2 = 0;

  	if($row_id2["count_max"] <= 0)
  	{ 
   
    	$lastID2 = ($row_id2["count_max"] + 1);
    	$dg2 = ($dht2 + ($lastID2));
   }
   else
   {
      $lastID2 = ($row_id2["count_max"] + 1);
      $dg2 =  $lastID2;
	
    }
	$number2 = $dg2; // Length of running no
    $number2 = sprintf('%03d', $number2);  
	
    $ref = (($row_id2["start_ref"]).$dht_OK2.$date_run.($number2));
	  
	
	} // end if $result_id2


	    
		
		$amount = "";
		$amount2 = "";
		$amount3 = "";
		$amount4 = "";
        $how_many = count($id_item); 
		
	   $id_disposal = $_POST["id_disposal"]; 
	   $id_item = $_POST["id_item"];  
	   $plant_code = $_POST["plant_code"]; 
	   $remarks = $_POST["remarks"];
	   $dateF = $_POST["date1"];
	   $dateT = $_POST["date2"];
	   $work_center = $_POST["work_center"];
	   $material_no = $_POST["material_no"];
	   $date_dis = $_POST["date_dis"]; 
		
		           //----format date---- 
		         $ddF = substr($_POST["date1"],0,2);
				 $mmF = substr($_POST["date1"],3,2);
				 $yyF = substr($_POST["date1"],6,4);
			
			     $date_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
			
		

       foreach($_POST["id_item"] as $j=>$i) {
		   
	
	    $amount .= (htmlspecialchars($_POST["remarks"][$i]).';');
		$amount2 .= (($_POST["id_disposal"][$i]).';');
		$amount3 .= (($_POST["id_item"][$i]).';');
		$amount4 .= (($_POST["date_dis"][$i]).';');
			
		//-----checking barcode GR Tag
		
		$string = explode(";",($amount));		
	    $string2 = explode(";",($amount2));	
		$string3 = explode(";",($amount3));	  
	    $string4 = explode(";",($amount4));	
		
        }
		
	  
		 			
		   for ($i=0; $i<$how_many; $i++) { 
		   
		// echo $string[$i]; echo "</br>";		
		// echo $string2[$i]; echo "</br>";
		// echo $string3[$i]; echo "</br>";
		// echo $string4[$i]; echo "</br>";
		// echo $string4[$i + 1]; echo "</br>";
			
		// echo $ref; echo "</br>";
		 
		//------checking STM or ASSY --------
		
		 $query_chk_pilih = "SELECT * FROM disposal_detail_prd_pending_confirm_hwork WHERE id_disposal = '".sql_esc($string3[$i])."'";
		 $result_chk_pilih =  mysqli_query($dbc,$query_chk_pilih);
		 $row_chk_pilih = mysqli_fetch_array($result_chk_pilih);
		
		
		
		if($row_chk_pilih["stamp_ind"] == 'STM')
		{
		
		$query_update_scan2 = "UPDATE disposal_detail_prd_pending_confirm_hwork SET doc_dis = '".sql_esc($ref)."', doc_disposal_no = '".sql_esc($number2)."', remarks = '".sql_esc($string[$i])."', user_disposal = '".sql_esc($username)."', date_disposal = NOW(), status_disposal = '".sql_esc($rst_sta32["status_desc"])."' WHERE id_disposal = '".sql_esc($string3[$i])."'";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2);
		
		}elseif($row_chk_pilih["stamp_ind"] == 'BLK')
		{
		
		$query_update_scan2 = "UPDATE disposal_detail_prd_pending_confirm_hwork SET doc_dis = '".sql_esc($ref)."', doc_disposal_no = '".sql_esc($number2)."', remarks = '".sql_esc($string[$i])."', user_disposal = '".sql_esc($username)."', date_disposal = NOW(), status_disposal = '".sql_esc($rst_sta32["status_desc"])."' WHERE id_disposal = '".sql_esc($string3[$i])."'";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2);
		
		}elseif($row_chk_pilih["stamp_ind"] == 'ASSY') {
			
		$query_update_scan2 = "UPDATE disposal_detail_prd_pending_confirm_hwork SET doc_dis = '".sql_esc($ref)."', doc_disposal_no = '".sql_esc($number2)."', remarks = '".sql_esc($string[$i])."', user_disposal = '".sql_esc($username)."', date_disposal = NOW(), status_disposal = '".sql_esc($rst_sta34["status_desc"])."' WHERE id_disposal = '".sql_esc($string3[$i])."'";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2);	
			
		}else{
			
			$query_update_scan2 = "UPDATE disposal_detail_prd_pending_confirm_hwork SET doc_dis = '".sql_esc($ref)."', doc_disposal_no = '".sql_esc($number2)."', remarks = '".sql_esc($string[$i])."', user_disposal = '".sql_esc($username)."', date_disposal = NOW(), status_disposal = '".sql_esc($rst_sta15["status_desc"])."' WHERE id_disposal = '".sql_esc($string3[$i])."'";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2);		
			
			
		}
		
		 $query_chk_info = "SELECT * FROM disposal_detail_prd_pending_confirm_hwork WHERE id_disposal = '".sql_esc($string3[$i])."'";
		 $result_chk_info =  mysqli_query($dbc,$query_chk_info);
		 $row_chk_info = mysqli_fetch_array($result_chk_info);
		 
		
		
		$query_ins_dis = "INSERT INTO disposal_detail_prd_all(id,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_chk_info["id_disposal"])."','".sql_esc($row_chk_info["doc_dis"])."','".sql_esc($row_chk_info["doc_disposal_no"])."','".sql_esc($row_chk_info["bflush_hwork"])."','','','".sql_esc($row_chk_info["bflush_qqc_no"])."','".sql_esc($row_chk_info["plan_no"])."','".sql_esc($row_chk_info["uid"])."','".sql_esc($row_chk_info["material_no"])."','".sql_esc($row_chk_info["material_desc"])."','".sql_esc($row_chk_info["material_type"])."','".sql_esc($row_chk_info["model_code"])."','".sql_esc($row_chk_info["qty_plan"])."','".sql_esc($row_chk_info["qty_actual"])."','".sql_esc($row_chk_info["qty_balance"])."','".sql_esc($row_chk_info["qty_NG"])."','".sql_esc($row_chk_info["qty_qc"])."','".sql_esc($row_chk_info["qty_qc_ok"])."','".sql_esc($row_chk_info["qty_qc_NG"])."','".sql_esc($row_chk_info["UOM_unit"])."','".sql_esc($row_chk_info["comp_code"])."','".sql_esc($row_chk_info["work_center"])."','".sql_esc($row_chk_info["shift_day"])."','".sql_esc($row_chk_info["date_plan"])."','".sql_esc($row_chk_info["user_posting"])."',NOW(),'".sql_esc($row_chk_info["time_posting"])."','".sql_esc($row_chk_info["status_disposal"])."','".sql_esc($row_chk_info["ploc"])."','".sql_esc($row_chk_info["ploc_prod_reject"])."','".sql_esc($row_chk_info["ploc_qc_reject"])."','".sql_esc($row_chk_info["proc_reject"])."','".sql_esc($row_chk_info["type_reject"])."','".sql_esc($row_chk_info["type_defect"])."','".sql_esc($row_chk_info["reason_reject"])."','".sql_esc($row_chk_info["user_reject"])."','".sql_esc($row_chk_info["date_reject"])."','".sql_esc($row_chk_info["time_reject"])."','".sql_esc($row_chk_info["qty_wastage"])."','".sql_esc($row_chk_info["type_wastage"])."','".sql_esc($row_chk_info["reason_wastage"])."','".sql_esc($row_chk_info["user_wastage"])."','".sql_esc($row_chk_info["date_wastage"])."','".sql_esc($row_chk_info["time_wastage"])."','".sql_esc($row_chk_info["user_disposal"])."','".sql_esc($row_chk_info["date_disposal"])."','".sql_esc($row_chk_info["remarks"])."','".sql_esc($row_chk_info["status_part"])."','".sql_esc($row_chk_info["user_update"])."','".sql_esc($row_chk_info["date_update"])."','".sql_esc($row_chk_info["status_approved"])."','".sql_esc($row_chk_info["approved_by"])."','".sql_esc($row_chk_info["date_approved"])."','".sql_esc($row_chk_info["remark_approved"])."','".sql_esc($row_chk_info["status_approved2"])."','".sql_esc($row_chk_info["approved_by2"])."','".sql_esc($row_chk_info["date_approved2"])."','".sql_esc($row_chk_info["remark_approved2"])."','".sql_esc($row_chk_info["status_approved3"])."','".sql_esc($row_chk_info["approved_by3"])."','".sql_esc($row_chk_info["date_approved3"])."','".sql_esc($row_chk_info["remark_approved3"])."','".sql_esc($row_chk_info["status_approved4"])."','".sql_esc($row_chk_info["approved_by4"])."','".sql_esc($row_chk_info["date_approved4"])."','".sql_esc($row_chk_info["remark_approved4"])."','".sql_esc($row_chk_info["status_approved5"])."','".sql_esc($row_chk_info["approved_by5"])."','".sql_esc($row_chk_info["date_approved5"])."','".sql_esc($row_chk_info["remark_approved5"])."','".sql_esc($row_chk_info["cost_center"])."','".sql_esc($row_chk_info["id_factory"])."','".sql_esc($row_chk_info["disposal_no_ref"])."','".sql_esc($row_chk_info["user_cancel"])."','".sql_esc($row_chk_info["date_cancel"])."','".sql_esc($row_chk_info["remark_cancel"])."','".sql_esc($row_chk_info["plant_cd"])."','".sql_esc($row_chk_info["shift_posting"])."','".sql_esc($row_chk_info["stamp_ind"])."','BFHWORK','".sql_esc($row_chk_info["back_no"])."','".sql_esc($row_chk_info["kanban_no"])."','".sql_esc($row_chk_info["SAP_ref_doc"])."','".sql_esc($row_chk_info["SAP_ref_doc_can"])."')";
$result_ins_dis = mysqli_query($dbc,$query_ins_dis); 
		
		
		
		
	}//end for loop
       
	   
	    //---checking date ----   
	   
	   $query_chk_tarikh = "SELECT MIN(T2.date_posting - T1.date_posting) AS Dif FROM disposal_detail_prd_pending_confirm_hwork T1 INNER JOIN disposal_detail_prd_pending_confirm_hwork T2 on T1.date_posting < T2.date_posting WHERE T1.doc_dis = T2.doc_dis AND T1.doc_dis = '".sql_esc($ref)."'
ORDER BY T1.date_posting";
	   $result_chk_tarikh =  mysqli_query($dbc,$query_chk_tarikh); 
       $row_chk_tarikh = mysqli_fetch_array($result_chk_tarikh);
	   
	  // echo $row_chk_tarikh["Dif"];
	   
	   if($row_chk_tarikh["Dif"] == 0)
	   {
	   
	 //update count_max----------------------------------------
  
       $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '25'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);

   //end update count_max ---------------------------------	
   
	   }else{
		    
			echo '<script type="text/javascript">';
	        echo "alert('Please select HANDWORK with the same date only.');";
	        echo "window.location='detail_bf_HWORK_disposal-prdProc2.php?date1=$dateF&&date2=$dateT&&plant_code=$plant_code&&work_center=$work_center&&material_no=$material_no';"; 
			echo "</script>";
			//exit(); //quit the script   
			
			
			//-----delete file date x ssama ------
			
		     $query_del_tarikh = "DELETE FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($ref)."'";
			 $result_del_tarikh =  mysqli_query($dbc,$query_del_tarikh); 
			 $row_del_tarikh = mysqli_fetch_array($result_del_tarikh);
			 
			 $query_upd_sta = "UPDATE disposal_detail_prd_pending_confirm_hwork SET doc_dis = '', doc_disposal_no = '', remarks = '', user_disposal = '', date_disposal = '0000-00-00', status_disposal = '".sql_esc($rst_sta["status_desc"])."' WHERE doc_dis = '".sql_esc($ref)."'";
	         $rst_upd_sta = mysqli_query($dbc,$query_upd_sta);	
	 
	        }
   
   
       if($_POST["id_item"] > 0)
	   {
   
   
    echo '<script type="text/javascript">';
	echo "alert('Generate Disposal Document $ref posted.');";
	echo "window.location='detail_bf_HWORK_disposal-prdProc2.php?date1=$dateF&&date2=$dateT&&plant_code=$plant_code&&work_center=$work_center&&material_no=$material_no';"; 
	echo "</script>";
	exit(); //quit the script
	
	   }else{
		   
		   
	echo '<script type="text/javascript">';
    echo "alert('Please select item for Generate Disposal.');";
	echo "window.location='detail_bf_HWORK_disposal-prdProc2.php?date1=$dateF&&date2=$dateT&&plant_code=$plant_code&&work_center=$work_center&&material_no=$material_no';"; 
	echo "</script>";
	exit(); //quit the script	   
		   
		   
		   
	   }

	
	 }//end ifelse "OK"

}// end submit 4


		
			
   $query8GR = "SELECT COUNT(*) FROM disposal_detail_prd_pending_confirm_hwork WHERE status_disposal = '".sql_esc($rst_sta["status_desc"])."'" .$where_sql ." ORDER BY bflush_qqc_no ASC ";
   $result8GR = mysqli_query($dbc,$query8GR);
   $num_rowsGR = mysqli_num_rows($result8GR);
			
  
$queryGR = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as R FROM disposal_detail_prd_pending_confirm_hwork WHERE status_disposal = '".sql_esc($rst_sta["status_desc"])."'" .$where_sql." ORDER BY bflush_qqc_no ASC ";
$rsGR = mysqli_query($dbc,$queryGR);
$num_rowsGR = mysqli_num_rows($rsGR);   //how many material are there?
    
		  
		 if ($num_rowsGR > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rowsGR.' record(s).</div>'; 
	   
        
    	?>
    <form action="detail_bf_HWORK_disposal-prdProc2.php?date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&plant_code=<?php echo $plant_code; ?>&&work_center=<?php echo $work_center; ?>&&material_no=<?php echo $material_no; ?>" method="post" name="myform" id="myform">    
               <!-- <form action="" method="post" name="myform" id="myform">-->
                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>No</th>
                    <th>Model</th>
                    <th>Part Number</th>
                    <th>BF Doc No.</th>
                    <th>NG Doc. No.</th>
                    <th>Posting Date</th>
                    <th>Line</th>
                    <th>Shift</th>
                    <th>Quantity</th>
                    <th>Process/Section</th>
                    <th>Type of Reject</th>
                    <th>Defectives</th>
                    <th>Reason for Rejection</th>
                    <th>Remarks</th>
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
  
 $query_proc = new PreparedSql("SELECT * FROM proc_reject_detail_prd WHERE id_proc = ?", [$row["proc_reject"]]);
 $rst_proc = db_query($dbc, $query_proc);
 $row_proc = mysqli_fetch_array($rst_proc);	
	
 //---type of reject
 $query_type = new PreparedSql("SELECT * FROM type_reject_detail_prd WHERE id_type = ? AND status_type = 'Y' ORDER BY id_type ASC", [$row["type_reject"]]);
 $result_type = db_query($dbc, $query_type);
 $row_type = mysqli_fetch_array($result_type); 
 
  //---defect
 $query_defect = new PreparedSql("SELECT * FROM type_defect_detail_prd WHERE id_defect = ? AND status_defect = 'Y' ORDER BY id_defect ASC", [$row["type_defect"]]);
 $result_defect = db_query($dbc, $query_defect);
 $row_defect = mysqli_fetch_array($result_defect);     
	 
  
    //----model ---
  
 $query_Mod = new PreparedSql("SELECT * FROM model_detail_tbl WHERE model_code = ? AND plant_code = ? AND status_model = 'Y' ORDER BY id_model ASC", [$row["model_code"], $row["plant_cd"]]);
 $result_Mod = db_query($dbc, $query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  
 
  if($row_Mod["model_desc"] == "")
  {
	  $model_name = $row_Mod["model_desc"];
  }else{
	  
	 $model_name = $row_Mod["model_desc"]; 
  }
	  
	  
	   //----line ---
  
 $query_Mod2 = new PreparedSql("SELECT * FROM work_center_detail WHERE id_work = ? AND status_wc = 'Y' ORDER BY id ASC", [$row["work_center"]]);
 $result_Mod2 = db_query($dbc, $query_Mod2);
 $row_Mod2 = mysqli_fetch_array($result_Mod2);  
 
  if($row_Mod2["wc_desc2"] == "")
  {
	  $model_name2 = $row_Mod2["id_work"];
  }else{
	  
	 $model_name2 = $row_Mod2["wc_desc2"]; 
  }
	  
      ?>
                <tr>
                <td width="30"><div align="center"><?php echo $no4; ?><br><input type="checkbox" name="id_item[<?php echo html_esc($row["id_disposal"]); ?>]" value="<?php echo html_esc($row["id_disposal"]); ?>"/>
 </div> </td>
                <td width="80"><?php echo $model_name; ?></td>
                <td width="200"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="150"><?php echo html_esc($row["bflush_hwork"]); ?></td> 
                <td width="150"><?php echo html_esc($row["bflush_qqc_no"]); ?></td> 
                <td width="100"><?php echo html_esc($row["R"]); ?></td> 
                <td width="80"><?php echo $model_name2; ?></td> 
                <td width="80"><?php echo html_esc($row["shift_posting"]); ?></td>
                <td width="100"><?php echo intval($row["qty_NG"]); ?></td>
                <td width="100"><?php echo html_esc($row_proc["proc_desc"]); ?></td>
                <td width="100"><?php echo html_esc($row_type["type_desc"]); ?></td>
                <td width="100"><?php echo html_esc($row_defect["defect_desc"]); ?></td>
                <td width="100"><?php echo html_esc($row["reason_reject"]); ?></td>
                <td width="150">              
               <textarea name="remarks[<?php echo html_esc($row["id_disposal"]); ?>]" id="textarea" rows="3" cols="20" class="form-control" ><?php if (isset($_POST['remarks'][($row["id_disposal"])])) { echo html_esc($_POST['remarks'][($row["id_disposal"])]); } ?></textarea>
               <input name="id_disposal[<?php echo html_esc($row["id_disposal"]); ?>]" type="hidden" value="<?php echo html_esc($row["id_disposal"]); ?>">
               <input name="date_dis[<?php echo html_esc($row["id_disposal"]); ?>]" type="hidden" value="<?php echo html_esc($row["date_posting"]); ?>">
               
               
                </td>
                </tr>
                 
          <?php 
		  
		  $no4++;
		  $counter++; // menambah counter
		  } 
		  
		  
		  ?>

         
 </tbody>
</table><!--</form>-->

</div> 
<br><br>
<?php
   mysqli_free_result($rsGR); 
   
 ?>
   <input name="submit4" type="submit" id="submit4" value="GENERATE DISPOSAL DOCUMENT" class="btn btn-success btn-sm" onclick="return confirm('Are you sure? Generate Disposal document on selected Handwork NG?');" >
               
       <input name="date1" type="hidden" value="<?php echo $dateF; ?>"> 
       <input name="date2" type="hidden" value="<?php echo $dateT; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
       <input name="work_center" type="hidden" value="<?php echo $work_center; ?>">  
       <input name="material_no" type="hidden" value="<?php echo $material_no; ?>"> 
       
               
               
               
               
               
               
 
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
		
		var strURL="findPlant4Dis.php?plant_code="+plant_code;
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
		
		var strURL="findMaterial4Dis.php?work_center="+work_center;
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