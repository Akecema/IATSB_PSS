<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

$curr_month = (date("m"));
$getYear = (date("Y"));

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
	
    $url = "display_purc-ord.php"; 
	
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


	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php $data_setup["tajuk_sys"]; ?>">
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
          <h1><i class="fa fa-th-list"></i> Purchase Order</h1>
          <p>View PO</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Purchase Order </li>
          <li class="breadcrumb-item"><a href="display_purc-ord.php">View PO</a></li>
        </ul>
      </div> 
           
      <div class="row">
        <div class="col-md-12">
          <div class="tile"> <h3 class="tile-title">View PO </h3>
            <div class="tile-body">
              <div class="table-responsive">
              <?php  
			  $message_vcode = "";  
			  $message_mth = "";
	          $message_yyr = "";
	   
        if(isset($_POST["Submit2"]))
        {
            $month_po = $_POST["month_po"];
			$year_po = $_POST["year_po"];
         	$vendor_no = $_POST["vendor_no"]; 
			
			
			if(($_POST["vendor_no"]) == "NULL")
			 {
				 $vendor_no = FALSE;
				 $message_vcode = '<span class="badge badge-pill badge-danger">Please select Vendor!</span>';
			 }else{
				 
				  $vendor_no = TRUE;
				 
			 }
			 
			  
	  // check for year po

	if(($_POST["year_po"]) == "")
     {
	     $year_po = FALSE;
		 $message_yyr = '<span class="badge badge-pill badge-danger">Please select Year!</span>';
	 }else{
		 $year_po = TRUE;
	  }
	  
	  
	   // check for month po

	if(($_POST["month_po"]) == "NULL")
     {
	     $month_po = FALSE;
		 $message_mth = '<span class="badge badge-pill badge-danger">Please select Month!</span>';
	 }else{
		 $month_po = TRUE;
	  }
	  
			
		  if($vendor_no && $month_po && $year_po)
		  {
			  
			$month_po = $_POST["month_po"];
			$year_po = $_POST["year_po"];
            $vendor_no = $_POST["vendor_no"]; 
			
				
								 
            echo "<script>";
            echo "window.location='display_purc-ordProc2.php?vendor_no=$vendor_no&&month_po=$month_po&&year_po=$year_po'";
            echo "</script>";
            exit(); //quit the script
			
			
		  } //end if purc_ord_no
        }
		
		
		
	
		
		
		
	 ?>
              
            <form action="" method="post" name="frmSearch" id="frmSearch">
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
		$query_ath_vend = new PreparedSql("SELECT * FROM function_ath_vendordetail WHERE staff_ID = ?", [$res["staff_ID"]]);
		$result_ath_vend = db_query($dbc, $query_ath_vend);
	
          
              while($data_ath_vend = mysqli_fetch_array($result_ath_vend)) {
				  
				  
				  //----vendor detail ------
				   $query27 = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ? AND status_acc = 'Y'", [$data_ath_vend["vendor_id"]]);
                   $result27 = db_query($dbc, $query27);
                   $row27 = mysqli_fetch_array($result27);
				  
        
              ?>
                      <option value="<?php echo html_esc($data_ath_vend["vendor_id"]); ?>" > <?php echo stripslashes($data_ath_vend["vendor_id"]); ?> - <?php echo html_esc($row27["vendor_name"]); ?></option>
                      <?php
           }  ?>
                    </select><div class="form-control-feedback" ><?php echo $message_vcode; ?></div>
		     </td>
             </tr>
             <tr>
                <th>Month : <font color="#FF0000">*</font></th>
                <td colspan="3">  <select name="month_po" class="form-control" >
                      <option value="NULL" placeholder="Select Month"> -- Select Month -- </option>
                      <?php
					  
			//------------- select get login vendor --------------
		$query_mth = "SELECT * FROM tbl_month ORDER BY id ASC";
		$result_mth = mysqli_query($dbc,$query_mth);
	
          
              while($data_mth = mysqli_fetch_array($result_mth)) {
				  
		
        
              ?>
                      <option value="<?php echo html_esc($data_mth["month_int"]); ?>" <?php if($data_mth["month_int"] ==  $curr_month){ echo "selected";  } ?> > <?php echo stripslashes($data_mth["month_descp"]); ?></option>
                      <?php
           }  ?>
                    </select><div class="form-control-feedback" ><?php echo $message_mth; ?></div>
                    </td></tr>
               <tr>
                <th>Year :  <font color="#FF0000">*</font></th>
                <td colspan="3">
                
             <select name="year_po" class="form-control" >
            <option value=""> -- Select Year -- </option>
            <?php
            for ($year = 2021; $year <= 2030; $year++) {
            $selected = (isset($getYear) && $getYear == $year) ? 'selected' : '';
            echo "<option value=$year $selected>$year</option>";
            }
            ?>
            </select><div class="form-control-feedback" ><?php echo $message_yyr; ?>		               </tr>
             
              <tr>
                <th><input name="Submit2" type="submit" class="btn btn-info" id="button" value="SEARCH" /></th>
                <th colspan="3">&nbsp;</th>
              </tr>
            
                </table>
        </form>
 
      
    
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
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
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