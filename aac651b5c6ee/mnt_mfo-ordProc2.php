<?php
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
	
    $url = "mnt_mfo-ord.php";
	
	ini_set('display_errors', 1);
	error_reporting(~0);

	
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

//CR status (Transfer Posting)
$sta19 = "SELECT * from request_status WHERE status_id = '19'";
$sta_res19 = mysqli_query($dbc,$sta19);
$rst_sta19 = mysqli_fetch_array($sta_res19);

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
          <h1><i class="fa fa-th-list"></i> Material Forecast Order</h1>
          <p>Maintain MFO</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Material Forecast Order </li>
          <li class="breadcrumb-item"><a href="mnt_mfo-ord.php">Maintain MFO</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Maintain MFO </h3>
            <div class="tile-body">
              <div class="table-responsive">
          <?php
		  
		    $month_mfo = $_GET["month_mfo"];
			$year_mfo = $_GET["year_mfo"];
         	$vendor_no = $_GET["vendor_no"]; 
			
		  ?>    
              
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="3">&nbsp;</th>
            </tr>
            <tr>
            <th>Vendor : <font color="#FF0000">*</font></th>
            <td colspan="3">
          <select name="vendor_no" class="form-control" >
                  <option value="NULL" placeholder="Select Vendor"> -- Select Vendor -- </option>
                  <?php
				  
	    	//------------- select get login vendor --------------
		$query_ath_vend2 = new PreparedSql("SELECT * FROM function_ath_vendordetail WHERE staff_ID = ?", [$res["staff_ID"]]);
		$result_ath_vend2 = db_query($dbc, $query_ath_vend2);
	
          
              while($data_ath_vend2 = mysqli_fetch_array($result_ath_vend2)) {
				  
				  
				  //----vendor detail ------
				   $query27A = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ? AND status_acc = 'Y'", [$data_ath_vend2["vendor_id"]]);
                   $result27A = db_query($dbc, $query27A);
                   $row27A = mysqli_fetch_array($result27A);			  

        
              ?>
                  <option value="<?php echo html_esc($data_ath_vend2["vendor_id"]); ?>" <?php if($data_ath_vend2["vendor_id"] == $_GET["vendor_no"]) echo "selected"; ?>> <?php echo stripslashes($row27A["vendor_code"]); ?> - <?php echo html_esc($row27A["vendor_name"]); ?></option>
                  <?php
           }  ?>
                </select>
		     </td>
             </tr>
             <tr>
                <th>Month : <font color="#FF0000">*</font></th>
                <td colspan="3">
        <select name="month_mfo" class="form-control" >
        <option value="NULL" placeholder="Select Month"> -- Select Month -- </option>
                      <?php
					  
			//------------- select get login vendor --------------
		$query_mth = "SELECT * FROM tbl_month ORDER BY id ASC";
		$result_mth = mysqli_query($dbc,$query_mth);
	
          
              while($data_mth = mysqli_fetch_array($result_mth)) {
				  
		
        
              ?>
                      <option value="<?php echo html_esc($data_mth["month_int"]); ?>" <?php if($data_mth["month_int"] == $_GET["month_mfo"]) echo "selected"; ?> > <?php echo stripslashes($data_mth["month_descp"]); ?></option>
                      <?php
           }  ?>
                    </select>
                  
                    </td></tr>
                <tr>
                <th>Year :  <font color="#FF0000">*</font></th>
                <td colspan="3"> <select name="year_mfo" class="form-control" >
                 <option value="NULL"> -- Select Year -- </option> 
                <option value="2021" <?php if($_GET["year_mfo"] == "2021") { ?> selected="selected"<?php } ?>>2021</option> 
                <option value="2022" <?php if($_GET["year_mfo"] == "2022") { ?> selected="selected"<?php } ?>>2022</option> 
                <option value="2023" <?php if($_GET["year_mfo"] == "2023") { ?> selected="selected"<?php } ?>>2023</option> 
                <option value="2024" <?php if($_GET["year_mfo"] == "2024") { ?> selected="selected"<?php } ?>>2024</option> 
                <option value="2025" <?php if($_GET["year_mfo"] == "2025") { ?> selected="selected"<?php } ?>>2025</option> 
                <option value="2026" <?php if($_GET["year_mfo"] == "2026") { ?> selected="selected"<?php } ?>>2026</option> 
                <option value="2027" <?php if($_GET["year_mfo"] == "2027") { ?> selected="selected"<?php } ?>>2027</option> 
                <option value="2028" <?php if($_GET["year_mfo"] == "2028") { ?> selected="selected"<?php } ?>>2028</option> 
                <option value="2029" <?php if($_GET["year_mfo"] == "2029") { ?> selected="selected"<?php } ?>>2029</option>   
                <option value="2030" <?php if($_GET["year_mfo"] == "2030") { ?> selected="selected"<?php } ?>>2030</option> 
              </select>
              
              </td>
             
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
				 
		 //3. Vendor Code
                if (($vendor_no == "") || ($vendor_no == "NULL")){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND vendor_no = '".sql_esc($vendor_no)."'"; }  	
					
		 // 1. month
                if ($month_mfo == "NULL" ){
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND (month_mfo = '".sql_esc($month_mfo)."')"; }      
                                                
					
          //2. year
                if ($year_mfo == "NULL" ){
                    $wheresql_02 = ""; }
                else {
					$wheresql_02 = " AND (year_mfo = '".sql_esc($year_mfo)."')"; }
					
						
	        
					
	                              
				
				$where_sql =  $wheresql_03 .$wheresql_01 .$wheresql_02;	
	
	//********** END CONDITION **************
					
	
   $query8 = "SELECT COUNT(*) FROM mforecast_ord_ups WHERE mfo_no != '' " .$where_sql;
   $result8 = mysqli_query($dbc,$query8);
   $num_rows = mysqli_num_rows($result8);

$query_pur = "SELECT *, DATE_FORMAT(upload_date,'%d-%m-%Y') as R FROM mforecast_ord_ups WHERE mfo_no != '' " .$where_sql." ORDER BY mfo_no, month_mfo DESC";
$rs_pur = mysqli_query($dbc,$query_pur);
$num_rows = mysqli_num_rows($rs_pur);   //how many material are there?
    
		  
		 if ($num_rows > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>'; 
	   
        
    	?>
          
                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>No.</th>  
                    <th>Material Forecast Order No.</th>
                    <th>Vendor Name</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Remarks</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>View</th>
                </tr>
              </thead>    
              <tbody>
           <?php 

   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   $msg_sta = "";
   
   while($row = mysqli_fetch_array($rs_pur))
   {
	   
	             //------get table month detail --------
	         	$query_mth_detail = "SELECT * FROM tbl_month WHERE month_int = '".sql_esc($row["month_mfo"])."' ";
				$result_mth_detail = mysqli_query($dbc,$query_mth_detail);
	            $data_mth_detail = mysqli_fetch_array($result_mth_detail);
	

                 //----vendor detail ------
				   $query_vcode = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ? AND status_acc = 'Y'", [$row["vendor_no"]]);
                   $result_vcode = db_query($dbc, $query_vcode);
                   $row_vcode = mysqli_fetch_array($result_vcode);	

     
	
      ?>
                <tr>
                <td width="30"><?php echo $no4; ?></td>
                <td width="150"><?php echo html_esc($row["mfo_no"]); ?></td>
                <td width="250"><?php echo html_esc($row_vcode["vendor_name"]); ?></td> 
                <td width="100"><?php echo html_esc($data_mth_detail["month_descp"]); ?></td>
                <td width="150"><?php echo html_esc($row["year_mfo"]); ?></td>
                <td width="200"><?php echo html_esc($row["remark_upload"]); ?></td>
                <td width="150">
                
               
                 <a href="edt-mtnmfo-ord.php?buid=<?php echo base64_encode($row["upload_id"]); ?>&&vendor_no=<?php echo html_esc($row["vendor_no"]); ?>&&month_mfo=<?php echo html_esc($month_mfo); ?>&&year_mfo=<?php echo html_esc($year_mfo); ?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>    
            
                
                </td>
                <td width="150"><a href="#myNoteCancelMFO<?php echo html_esc($row["upload_id"]); ?>" data-toggle="modal" target="_parent"><i class="fa fa-window-close" aria-hidden="true"></i>Delete</a> 
              <?php
			  
			  
			   include "cancel_upsmfo-ord.php";  
			   
			   
			   ?>
                </td>
                 <td width="150">
                 <a href="../MFO_upload/<?php echo html_esc($row["mfo_no"]).".pdf"; ?>" target="_blank"><img src="../images/icon_view.jpg" width="16" height="16" alt="View MFO">View</a>    
                </td>
                </tr>
                 
          <?php 
		  
		  $no4++;
		  $counter++; // menambah counter
		  } 
		  
		  
		  ?>

         
 </tbody>
</table>
 <br>
              
<?php
   mysqli_free_result($rs_pur); 
   
 
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