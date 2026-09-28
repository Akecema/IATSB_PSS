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
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
    $url = "detail_aprv_coo_disposal4-prd.php";
	include 'apprv_func_list.php';
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

//CR status (Pending Approval Exec. QC)
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
    <SCRIPT LANGUAGE="JavaScript">
<!-- 

<!-- Begin
function Check(chk)
{
if(document.myform.Check_ctr.checked==true){
for (i = 0; i < chk.length; i++)
chk[i].checked = true ;
}else{

for (i = 0; i < chk.length; i++)
chk[i].checked = false ;
}
}

// End -->
</script>
<?php
//echo "the following values have been checked: ";
$checked="";
$amount ="";

$a = array();
if(isset($_POST["cancel"])) {
	foreach($_POST["cancel"] as $j=>$i) {
	   // $amount .= $_POST["remark_reject"][$i]."|";
		$checked .= ($checked==""?"":",") . "checkbox" . $i;
		
		array_push($a, $i);
	//	 array_push($amount, $i);
	}
}
//echo $checked;
//echo $amount;

function was_checked($i,$a) {
if(in_array($i, $a)===true) {
return "checked='checked'";
return "";
}
}

?>
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
           <h1><i class="fa fa-bar-chart"></i> <?php echo html_esc($rst_apprv8["apprv_name2"]); ?></h1>
          <p>Pending Approval</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><?php echo html_esc($rst_apprv8["apprv_name2"]); ?></li>
          <li class="breadcrumb-item"><a href="detail_aprv_coo_disposal4-prd.php">Pending Approval</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Pending Approval</h3>
            <div class="tile-body">
              <div class="table-responsive">
              
        
        <?php
		
 if(isset($_POST["SubmitPRT"]))  
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}    


        $gid = $_POST["gid"];
        $id_item = $_POST["id_item"];
		$dateF = $_POST["date1"];
	    $dateT = $_POST["date2"];
        $plant_code = $_POST["plant_code"]; 
	   	$cancel = $_POST["cancel"];
		$work_center = $_POST["work_center"]; 
		$status_disposal = $_POST["status_disposal"]; 
		
		
	    $amount3 = "";
		$amount2 = "";
		$how_many = count($cancel); 
	
	
	
	 foreach($_POST["cancel"] as $j=>$i) {
	
	    $amount3 .= (($_POST["id_item"][$i]).';');
		$amount2 .= (($_POST["gid"][$i]).';');
			
		//-----checking barcode GR Tag
		
		$string = explode(";",($amount3));		
	    $string2 = explode(";",($amount2));	
	
	 }//end foreach
	
	
	 for ($i=0; $i<$how_many; $i++) { 
		   
		//echo $string[$i]; echo "</br>";		
		// echo $string2[$i]; echo "</br>";
		
			//echo ($i+1).'-'.$cancel[$i]; 
		 
		 $doc_baru = base64_encode($cancel[$i]);
		 
		        echo "<script>";
				echo "window.open('detail_aprv_coo_disposal4-prd_print-sel.php?buidT=$doc_baru','_blank');";
				//echo "window.location='confirm_backflush_tran.php';"; 
				echo "</script>";
				//exit(); //quit the script
		
		
	 }
	
	
	            echo "<script>";
				echo "window.location='detail_aprv_coo_disposal4-prdProc2.php?date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&plant_code=".html_esc($plant_code)."&&work_center=".html_esc($work_center)."&&status_disposal=".html_esc($status_disposal)."';"; 
				echo "</script>";
				//exit(); //quit the script
	
	
	
}
		
		
		?> 
    
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
                    $wheresql_01 = " AND plant_cd = '$plant_code'"; }  	
					
		   // 2. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (date_posting >= '$date1_final')"; }      
                                                
					
          //3. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
					$wheresql_03 = " AND (date_posting <= '$date2_final')"; }
					
	     //4. Work Center
                if ($work_center == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND work_center = '$work_center'"; }
					
		 //5. status_disposal
               /* if ($status_disposal == "NULL" ){
                    $wheresql_05 = ""; }
                else {
					$wheresql_05 = " AND status_disposal = '$status_disposal'"; }*/
  
			                                        			
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04;
						
	
	//********** END CONDITION **************
			
		  ?> 
          
          

                   
    <?php
		
   $query8GR = "SELECT COUNT(*) FROM disposal_detail_prd_all WHERE status_disposal = '".sql_esc($rst_sta25["status_desc"])."'  GROUP BY doc_dis ORDER BY doc_dis ASC ";
   $result8GR = mysqli_query($dbc,$query8GR);
   $num_rowsGR = mysqli_num_rows($result8GR);
			
  
$queryGR = "SELECT *, DATE_FORMAT(date_disposal,'%d-%m-%Y') as R FROM disposal_detail_prd_all WHERE status_disposal = '".sql_esc($rst_sta25["status_desc"])."'  GROUP BY doc_dis ORDER BY doc_dis ASC  ";
$rsGR = mysqli_query($dbc,$queryGR);
$num_rowsGR = mysqli_num_rows($rsGR);   //how many material are there?
    
		  
		 if ($num_rowsGR > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rowsGR.' record(s).</div>'; 
	   
        
    	?>
    <form action="detail_aprv_coo_disposal4-prd.php" method="post" name="myform" id="myform">    
               <!-- <form action="" method="post" name="myform" id="myform">-->
                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>No</th>
                    <th>Disposal Date</th>
                    <th>Disposal Doc. No.</th>
                    <th>Section</th> 
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
	
 //---type of reject
 $query_type = "SELECT * FROM type_reject_detail_prd WHERE id_type = '".sql_esc($row["type_reject"])."' AND status_type = 'Y' ORDER BY id_type ASC";
 $result_type = mysqli_query($dbc,$query_type);
 $row_type = mysqli_fetch_array($result_type); 
 
  //---defect
 $query_defect = "SELECT * FROM type_defect_detail_prd WHERE id_defect = '".sql_esc($row["type_defect"])."' AND status_defect = 'Y' ORDER BY id_defect ASC";
 $result_defect = mysqli_query($dbc,$query_defect);
 $row_defect = mysqli_fetch_array($result_defect); 
 
  //-----change plant id to plant name
  
  if($row["plant_cd"] == "2300")
  {
	  $plant_new = "BB";
	  
  }elseif($row["plant_cd"] == "2301")
  {
	  $plant_new = "MLK";
  }else{
	  
	  $plant_new = "";
  }
	
	 //-----change status disposal
	  
	  if($row["status_disposal"] == ($rst_sta3["status_desc"]))
	{
		$status_new = "Approved ".$rst_apprv8["apprv_name2"];
	
		
	  }elseif($row["status_disposal"] == ($rst_sta5["status_desc"]))
	  {
		//-------
		if($row["status_approved"] == ($rst_sta5["status_desc"]))
		{
		
		$status_new = "Rejected HOD Requestor";
	
			
		}elseif($row["status_approved2"] == ($rst_sta5["status_desc"]))
		{
		
		$status_new = "Rejected Exec QC";
	
		
		}elseif($row["status_approved3"] == ($rst_sta5["status_desc"]))
		{
		
		$status_new = "Rejected HOD QC";
	
		
		}elseif($row["status_approved4"] == ($rst_sta5["status_desc"]))
		{
		
		$status_new = "Rejected ".$rst_apprv8["apprv_name2"];
			}
		
	}elseif($row["status_disposal"] == ($rst_sta15["status_desc"]))
	{
		
		$status_new = "Pending HOD Requestor";
		
		
	}elseif($row["status_disposal"] == ($rst_sta32["status_desc"]))
	{
		
		$status_new = "Pending ".$rst_apprv3["apprv_name2"];
		
		
	}elseif($row["status_disposal"] == ($rst_sta34["status_desc"]))
	{
		
		$status_new = "Pending ".$rst_apprv9["apprv_name2"];
		
		
	}elseif($row["status_disposal"] == ($rst_sta24["status_desc"]))
	{
		
		$status_new = "Approved Exec QC";
		
		
	}elseif($row["status_disposal"] == ($rst_sta25["status_desc"]))
	{
		
		$status_new = "Approved HOD QC";
	
		
	}elseif($row["status_disposal"] == ($rst_sta29["status_desc"]))
	{
		
		$status_new = "Approved HOD Requestor";
		
		
	}elseif($row["status_disposal"] == ($rst_sta25["status_desc"]))
	{
		
		$status_new = "Approved QC";
		
	}elseif($row["status_disposal"] == ($rst_sta4["status_desc"]))
	{
		
		$status_new = "Cancelled";
		
	}
  
		
	
      ?>
                <tr>
                <td width="30">  
                <div align="center"><?php echo $no4; ?><br><input type="checkbox" name="cancel[]" value="<?php echo html_esc($row["doc_dis"]); ?>" <?=was_checked($row["doc_dis"],$a) ?> /><input type="hidden" name="Check_ctr" value="yes" 
onClick="Check(document.myform.cancel)">
                  <input type="hidden" name="gid[<?php echo html_esc($row["id"]); ?>]" value="<?php echo html_esc($row["id"]); ?>" />
                  <input name="id_item[<?php echo html_esc($row["id"]); ?>]" type="hidden" value="<?php echo html_esc($row["doc_dis"]); ?>"></div></td>  
                 <td width="80"><?php echo html_esc($row["R"]); ?></td>
                <td width="150"><?php echo html_esc($row["doc_dis"]); ?></td> 
                <td width="80"><?php echo html_esc($row["work_center"]); ?></td>
                <td width="80"><?php echo $status_new; ?></td> 
                <td width="100">
                
   
          <?php   if($row["status_part"] == "PR") 
		            {  
					
					 if($row["stamp_ind"] == "STM")
					 {
					?>
	        <a href="display_apprv_dis-HCooPRDC-stm.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>
			
				<?php	 
					 }else{
						 
						 ?>
			<a href="display_apprv_dis-HCooPRDC.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>
	 
				
				<?php
					 }
					
					}elseif($row["status_part"] == "WS") 
		            { 
					?>
                    
          <a href="display_apprv_dis-HCooPRCV.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>
              <?php
		        
					
					}elseif($row["status_part"] == "WQ") 
		            { 
				?>
                
          <a href="display_apprv_dis-HCooPDLV.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>
                
                <?php	
		            }elseif($row["status_part"] == "QC") 
		            { 
					
					
					?>
          <a href="display_apprv_dis-HCooQQC.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>
                    <?php
					
					
					}else{
				
					}
		  
		  
		    ?>
               
              </td> 
                <td width="100">
                
           <?php   if($row["status_part"] == "PR") 
		            {  
					
					if($row["stamp_ind"] == "STM")
			         {
				?>
               <a href="detail_aprv_coo_disposal4-prd_print-stm.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
				
                <?php   }else{  ?>
               
               <a href="detail_aprv_coo_disposal4-prd_print.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
                <?php  } ?>
                
                	<?php
				}elseif($row["status_part"] == "WS") 
		            { 
					?>
		      <a href="detail_aprv_coo_disposal4PRCV-prd_print.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
				  <?php	
					}elseif($row["status_part"] == "WQ") 
		            { ?>
		      <a href="detail_aprv_coo_disposal4PDLV-prd_print.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
					<?php
		            }elseif($row["status_part"] == "QC") 
		            { 	?>
              <a href="detail_aprv_coo_disposal4QQC-prd_print.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
					<?php
					}else{
				
					}
		  
		  
		    ?>
                
                
        
         <!--    <a href="detail_aprv_bf_disposal4-prd_print.php?buid=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a> -->
                                
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

<br>
       <input name="SubmitPRT" type="submit" id="submit4" value="PRINT" class="btn btn-success btn-sm"  >
    
<br><br>
</div>
<br><br>
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
   
   
  </body>
</html>