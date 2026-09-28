<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.7.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "1")) {
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
	
    $url = "pss_reopen-create.php"; 
	
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

//CR status (Draft)
$sta6 = "SELECT * from request_status WHERE status_id = '6'";
$sta_res6 = mysqli_query($dbc,$sta6);
$rst_sta6 = mysqli_fetch_array($sta_res6);

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
   <!-- <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>-->
    <!--  <script src="https://www.w3schools.com/lib/w3.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script> 
  
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
      <?php   include "left_admin_menu.php";   ?>
   
    <main class="app-content">
    
  
      <div class="app-title">
        <div>
          <h1><i class="fa fa-file-text-o"></i> PSS Planning ReOpen</h1>
          <p>PSS Planning</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">PSS Planning ReOpen</li>
          <li class="breadcrumb-item"><a href="pss_reopen-create.php">PSS Planning</a></li>
        </ul>
      </div> 
        
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">PSS Planning </h3>
            <div class="tile-body">
              <div class="table-responsive">
        <?php
	  
	
	   $message_plan = "";
	   $message_po2 = "";
	  
        if(isset($_POST["Submit2"]))
        {
			
			function escape_data($data) {
		global $dbc;   // need the connection.
		if (ini_get('magic_quotes_gpc')) {
			$data = stripslashes($data);
			}
			return mysqli_real_escape_string($data,$dbc);
			}   // end function.
		$message = NULL; // create an empty new variable.		
					
			
         $plan_no = $_POST["plan_no"];
		    
	  
	  //--Planning No.
	   if(($_POST["plan_no"]) == "")
     {
	     $plan_no = FALSE;
		 $message_plan = '<span class="badge badge-pill badge-danger"> Please enter Planning Number!</span>';
	 }else{
		  
		   $plan_no = TRUE;
		 
		  $query_po_list = "SELECT * FROM pps_detail WHERE plan_no = '".sql_esc($_POST["plan_no"])."'";
          $result_po_list = mysqli_query($dbc,$query_po_list);
          $row_list = mysqli_fetch_array($result_po_list);
       
			 
			 if($row_list < 1)
			 {
				 
			  $message_po2 = '<span class="badge badge-pill badge-danger"> Planning Number not exist!</span>';	 
			  $plan_no = FALSE;
				 
			 }
	    
		 
	  }
	  
	
		if($plan_no)
	   {
		   
           	$plan_no = $_POST["plan_no"];
			
		  $query_info = "SELECT * FROM pps_detail WHERE plan_no = '".sql_esc($_POST["plan_no"])."'";
          $result_info = mysqli_query($dbc,$query_info);
          $row_info = mysqli_fetch_array($result_info);
		
		
		  if($row_info["status_pps"] == ($rst_sta13["status_desc"]))
		   {
			   
			   
		//-----update status closed to open -------
		
		$query_upd_pps = "UPDATE pps_detail SET status_pps = '".sql_esc($rst_sta7["status_desc"])."', user_closed = '', date_closed = '0000-00-00 00:00:00', remark_closed = '' WHERE plan_no = '".sql_esc($row_info["plan_no"])."'";
		$result_upd_pps = mysqli_query($dbc,$query_upd_pps);
		
		
		//----delete data from table pps_detail_close --------   
			   
	    $query_del_pps = "DELETE FROM pps_detail_close WHERE plan_no = '".sql_esc($row_info["plan_no"])."'";
		$result_del_pps = mysqli_query($dbc,$query_del_pps);   
			   
		   
		   
		   echo "<script>";
		   echo "alert('Planning No. $plan_no is successfully status open.');";
		   echo "window.location='pss_reopen-create.php'";
	       echo "</script>"; 
		   exit(); //quit the script
			   
	
			
		   }else{
			   
		   echo "<script>";
		   echo "alert('Planning No. $plan_no still status open.');";
		   echo "window.location='pss_reopen-create.php'";
	       echo "</script>"; 
		   exit(); //quit the script   
			   
			   
			   
		   }
			
			
	   }//end if ok
			
			
			
        }
        
    	?>  
        
    
              
            <form action="" method="post" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="2">&nbsp;</th>
            </tr>
             <tr>
                <th>Planning No. : <font color="#FF0000">*</font></th>
                <th colspan="2">
           <input class="form-control" id="plan_no" type="text" placeholder="Enter Planning No." name="plan_no" value="<?php if(isset($_POST['plan_no'])){ echo html_esc($_POST['plan_no']); } ?>" />    
          <div class="form-control-feedback" ><?php echo $message_plan; ?></div> <div class="form-control-feedback" ><?php echo $message_po2; ?></div>
            <!-- <div id="result"></div>-->
               </th>
              </tr>
              <tr>
                <th>
                
     <input name="Submit2" type="submit"  class="btn btn-info" value="SEARCH" onclick="return confirm('Are you sure to open this planning?');"/>             
                
                </th>
                <th colspan="2">&nbsp;</th>
              </tr>
            
                </table>
        </form>
 
 
 
 
 
 
      
     
             </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    
  <!--  <script>
$(document).ready(function(){
    $("#purc_ord_no").on("input", function(){
        // Print entered value in a div box
        $("#result").text($(this).val());
    });
});
</script>-->
  
    
    <!--<script>
	$('#link_input').on('keyup',function(){
  var val = $(this).val();
  var len = val.length;

  if(len == 10){
    $('#myform').submit();
  }
});
	
	</script>-->
    
    
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
	  
      
	   $('#PSS2Date').datepicker({
		defaultDate: new Date(),   
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      $('#demoSelect').select2();
    </script>
  <!--  <script language="javascript" type="text/javascript">

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
	
	function getVendor(purc_ord_no) {		
		
		var strURL="findVendor.php?purc_ord_no="+purc_ord_no;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('vendordiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
</script>-->
  </body>
</html>