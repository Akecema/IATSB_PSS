<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

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
document.addEventListener('DOMContentLoaded', function () {
	$('.datepicker').pickadate({
weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
showMonthsShort: true
})
	
});
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
          <p>Disposals</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Production</li>
          <li class="breadcrumb-item"><a href="detail_bf_disposal-prd.php">Disposals</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Disposals </h3>
            <div class="tile-body">
              <div class="table-responsive">
              
               <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="detail_bf_disposal-prd.php">Backflush NG </a></li>
                 <li class="nav-item"><a class="nav-link" href="detail_bf_PEND_disposal-prd.php">Pending NG</a></li>
                 <li class="nav-item"><a class="nav-link" href="detail_bf_HWORK_disposal-prd.php">Handwork NG</a></li>
                 <li class="nav-item"><a class="nav-link" href="detail_bf_RWK_disposal-prd.php">Rework NG</a></li>               
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
                </select>
		     </td>
             </tr>
              <tr>
                <th>Line :</th>
                <th><div id="work_centerdiv"><select name="work_center" id="work_center" class="form-control" onChange="getMaterial(this.value)">
                  <option value="NULL" placeholder="Select Line"> -- Select Line --</option>
                  <?php
	               $query5 = new PreparedSql("SELECT * FROM work_center_detail WHERE plant_code = ? ORDER BY id_work ASC", [$_GET["plant_code"]]);
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
                <input name="date1" type="hidden" value="<?php echo html_esc($_GET['date1']); ?> ">
                <input name="date2" type="hidden" value="<?php echo html_esc($_GET['date2']); ?> ">
                <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">
                 <input name="work_center" type="hidden" value="<?php echo $work_center; ?>">
                <input name="material_no" type="hidden" value="<?php echo $material_no; ?>">
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
	   
	   if(($_POST["date_dis"][$i]) != "0000-00-00")
		{
		   
		    if(($_POST["date_dis"][$i + 1]) != ($_POST["date_dis"][$i]))
	      { 
		     $date_dis = FALSE;
			 
			//echo '<script type="text/javascript">';
	      //  echo "alert('Please select NG with the same date only.');";
	      //  echo "window.location='detail_bf_disposal-prdProc2.php?date1=$dateF&&date2=$dateT&&plant_code=$plant_code&&work_center=$work_center&&material_no=$material_no';"; echo "<//script>";
			
			//exit(); //quit the script 
		   }else{
			   
			 $date_dis = TRUE;  
			   
			   
		   }
		   
		} //end if
		  
	     }//for each
	 		*/

  if($dateF && $dateT)
  {
	  
	   //-------------------generate Disposal doc no.---------------
	
	 if($_POST["plant_code"] == '2300')
	{
	
	 $query_id2 = "SELECT count_max FROM run_count_itsb WHERE uid = '21'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($_POST["plant_code"] == '2301')
	{
		
	 $query_id2 = "SELECT count_max FROM run_count_itsb WHERE uid = '72'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_row($result_id2);
	
	$dht2 = 000; 
	$dht_OK2 = "311";
	$dg2 = 0;

  	if($row_id2[0] <= 0)
  	{ 
   
    	$lastID2 = ($row_id2[0] + 1);
    	$dg2 = ($dht2 + ($lastID2));
   }
   else
   {
      $lastID2 = ($row_id2[0] + 1);
      $dg2 =  $lastID2;
	
    }
	$number2 = $dg2; // Length of running no
    $number2 = sprintf('%03d', $number2);  
	
    $ref = ($_POST["plant_code"].$dht_OK2.$date_run.($number2));
	  
	
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
		   
	
	    $amount .= (($_POST["remarks"][$i]).';');
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
		 
		/*if((($string4[$i]) != "0000-00-00") && (($string4[$i + 1]) != "0000-00-00"))
		{
			 			 	
		 if(($string4[$i + 1]) == ($string4[$i])) 	     
		   { 
		 
		  
		  }else{
		   
			echo '<script type="text/javascript">';
	        echo "alert('Please select NG with the same date only dsagag.');";
	       // echo "window.location='detail_bf_disposal-prdProc2.php?date1=$dateF&&date2=$dateT&&plant_code=$plant_code&&work_center=$work_center&&material_no=$material_no';"; 
			echo "</script>";
			//exit(); //quit the script 
			
		   }
	      
		}
		*/
		
		$query_update_scan2 = "UPDATE disposal_detail_prd_ng SET doc_dis = '".sql_esc($ref)."', doc_disposal_no = '".sql_esc($number2)."', remarks = '".sql_esc($string[$i])."', user_disposal = '".sql_esc($username)."', date_disposal = NOW(), status_disposal = '".sql_esc($rst_sta15["status_desc"])."' WHERE id_disposal = '".sql_esc($string3[$i])."'";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2);
		
		
		
	}//end for loop
       
	   //----checking ftp ftp_bf_disposal_fg_ng-------
    $data_rcv = "";
   

  $query_rcv_ftp = "SELECT *, DATE_FORMAT(date_disposal,'%d%m%Y') AS J, DATE_FORMAT(date_create,'%d%m%Y') AS R2 FROM disposal_detail_prd_ng WHERE doc_dis = '".sql_esc($ref)."'";
   $result_rcv_ftp = mysqli_query($dbc,$query_rcv_ftp);
   
   $filen_rcv = "DP".$ref; 
  
   while($data_rcv_ftp = mysqli_fetch_array($result_rcv_ftp))
   
   {
        //-----prepared by------
		 $query_prep = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$data_rcv_ftp["user_disposal"]]);
		 $result_prep = db_query($dbc, $query_prep);
		 $data_prep = mysqli_fetch_array($result_prep);
		 
		 //----quantity-----
		 $qty_new = (intval($data_rcv_ftp["qty_NG"]));
		 
		 //----;ID Type of Reject
		 
		 $id_typereject = sprintf('%04d',$data_rcv_ftp["type_reject"]);
		 
		 
		 //---get month & year

	     $mon_plan = substr($data_rcv_ftp["date_disposal"],5,2);		
		 $tahun_plan = substr($data_rcv_ftp["date_disposal"],0,4);
	

$data_rcv .= $data_rcv_ftp["plant_code"].";".$data_rcv_ftp["doc_dis"].";".$data_rcv_ftp["J"].";".$data_rcv_ftp["material_no"].";".$qty_new.";".$data_rcv_ftp["UOM_unit"].";551;".$data_rcv_ftp["work_center"].";".$id_typereject.";".$data_rcv_ftp["cost_center"].";".$data_prep["user_fullname"]."\r\n";
   

     //----------update table  ftp_bf_disposal_fg_ng------------
   
    $query_rcv_ftp_info = "INSERT INTO ftp_bf_disposal_fg_ng(id,file_name,doc_dis,id_dis,plan_no,material_no,material_desc,qty_ftp,uom, plant,shift_day,slip_no,mvt_type,status_ftp,posting_date,posting_time,sloc_from,sloc_to,work_center,type_reject,reason_reject,cost_center,prepared_by,user_create,date_create) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($ref)."','".sql_esc($data_rcv_ftp["id_dis"])."','".sql_esc($data_rcv_ftp["plan_no"])."','".sql_esc($data_rcv_ftp["material_no"])."','".sql_esc($data_rcv_ftp["material_desc"])."','".sql_esc($data_rcv_ftp["qty_dis"])."','".sql_esc($data_rcv_ftp["uom_dis"])."','".sql_esc($data_rcv_ftp["plant_code"])."','".sql_esc($data_rcv_ftp["shift_day"])."','".sql_esc($data_rcv_ftp["slip_no"])."','551','Y','".sql_esc($data_rcv_ftp["posting_date"])."',NOW(),'".sql_esc($data_rcv_ftp["sloc_from"])."','".sql_esc($data_rcv_ftp["sloc_to"])."','".sql_esc($data_rcv_ftp["work_center"])."','".sql_esc($data_rcv_ftp["type_reject"])."','".sql_esc($data_rcv_ftp["reason_reject"])."','".sql_esc($data_rcv_ftp["cost_center"])."','".sql_esc($data_prep["user_fullname"])."','".sql_esc($username)."',NOW())"; 
     $rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
	 
	 
	  }

		$file_rcv = "../FromPortal2/DP/".$filen_rcv.".csv";
		file_put_contents($file_rcv,$data_rcv);

   
	   // ---update status 
   
		$query_rcv_ftp2 = "UPDATE ftp_bf_disposal_fg_ng SET status_ftp = 'Y' WHERE doc_dis = '".sql_esc($ref)."'";
		$rst_query_rcv_ftp2 = mysqli_query($dbc,$query_rcv_ftp2); //or die ("Error in query: $query_ftp"); 
		
				
    //---------------------------------------end ftp -------------------------------------------------   
	   
	   
	 //update count_max----------------------------------------
	 
	  if($_POST["plant_code2"] == '2300')
	{
  
       $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '21'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);


	}elseif($_POST["plant_code2"] == '2301')
	{
	   $query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '72'";
	   $result_max_b = mysqli_query($dbc,$query_max_b);

	}

   //end update count_max ---------------------------------	
   
   
    echo '<script type="text/javascript">';
	echo "alert('Material Document $ref posted.');";
	echo "window.location='detail_bf_disposal-prd.php';"; 
	echo "</script>";
	exit(); //quit the script

	
	 }//end ifelse "OK"

}// end submit 4


	  
	 
	
		  
 			
			
   $query8GR = "SELECT COUNT(*) FROM disposal_detail_prd_ng WHERE status_disposal = '".sql_esc($rst_sta["status_desc"])."'" .$where_sql ." ORDER BY bflush_qqc_no ASC ";
   $result8GR = mysqli_query($dbc,$query8GR);
   $num_rowsGR = mysqli_num_rows($result8GR);
			
  
$queryGR = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as R FROM disposal_detail_prd_ng WHERE status_disposal = '".sql_esc($rst_sta["status_desc"])."'" .$where_sql." ORDER BY bflush_qqc_no ASC ";
$rsGR = mysqli_query($dbc,$queryGR);
$num_rowsGR = mysqli_num_rows($rsGR);   //how many material are there?
    
		  
		 if ($num_rowsGR > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rowsGR.' record(s).</div>'; 
	   
        
    	?>
    <form action="detail_bf_disposal-prdProc2.php?date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&plant_code=<?php echo $plant_code; ?>&&work_center=<?php echo $work_center; ?>&&material_no=<?php echo $material_no; ?>" method="post" name="myform" id="myform">    
               <!-- <form action="" method="post" name="myform" id="myform">-->
                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>No</th>
                    <th>Model</th>
                    <th>Part Number</th>
                    <th>Planned Order No.</th>
                    <th>NG Doc. No.</th>
                    <th>Posting Date</th>
                    <th>Plant</th>
                    <th>Line</th>
                    <th>Shift</th>
                    <th>Location</th>
                    <th>Quantity</th>
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
	
 //---type of reject
 $query_type = new PreparedSql("SELECT * FROM type_reject_detail_prd WHERE id_type = ? AND status_type = 'Y' ORDER BY id_type ASC", [$row["type_reject"]]);
 $result_type = db_query($dbc, $query_type);
 $row_type = mysqli_fetch_array($result_type); 
 
  //---defect
 $query_defect = new PreparedSql("SELECT * FROM type_defect_detail_prd WHERE id_defect = ? AND status_defect = 'Y' ORDER BY id_defect ASC", [$row["type_defect"]]);
 $result_defect = db_query($dbc, $query_defect);
 $row_defect = mysqli_fetch_array($result_defect);     
	 
	   
      ?>
                <tr>
                <td width="30"><div align="center"><?php echo $no4; ?><br><input type="checkbox" name="id_item[<?php echo html_esc($row["id_disposal"]); ?>]" value="<?php echo html_esc($row["id_disposal"]); ?>"/>
 </div> </td>
                <td width="80"><?php echo html_esc($row["model_code"]); ?></td>
                <td width="200"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="150"><?php echo html_esc($row["plan_no"]); ?></td> 
                <td width="150"><?php echo html_esc($row["bflush_qqc_no"]); ?></td> 
                <td width="100"><?php echo html_esc($row["R"]); ?></td> 
                <td width="80"><?php echo html_esc($row["plant_cd"]); ?></td>
                <td width="80"><?php echo html_esc($row["work_center"]); ?></td> 
                <td width="80"><?php echo html_esc($row["shift_day"]); ?></td>
                <td width="80"><?php echo html_esc($row["ploc_prod_reject"]); ?></td>
                <td width="100"><?php echo intval($row["qty_NG"]); ?></td>
                <td width="100"><?php echo html_esc($row_type["type_desc"]); ?></td>
                <td width="100"><?php echo html_esc($row_defect["defect_desc"]); ?></td>
                <td width="100"><?php echo html_esc($row["reason_reject"]); ?></td>
                <td width="150">              
               <textarea name="remarks[<?php echo html_esc($row["id_disposal"]); ?>]" id="textarea" rows="2" cols="10" class="form-control" ><?php if (isset($_POST['remarks'][($row["id_disposal"])])) { echo html_esc($_POST['remarks'][($row["id_disposal"])]); } ?></textarea>
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
   <input name="submit4" type="submit" id="submit4" value="GENERATE DISPOSAL DOCUMENT" class="btn btn-success btn-sm" onclick="return confirm('Are you sure to submit?');" >
               <input name="submit5" type="submit" id="submit5" class="btn btn-warning btn-sm" value="CLEAR">
               
               
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
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
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