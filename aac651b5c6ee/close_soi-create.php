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
	
    $url = "close_soi-create.php"; 
	
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
          <h1><i class="fa fa-truck"></i> Delivery</h1>
          <p>Closed Sales Order</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Delivery</li>
          <li class="breadcrumb-item"><a href="close_soi-create.php">Closed Sales Order</a></li>
        </ul>
      </div> 
      
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="close_soi-create.php">Closed Sales Order</a></li>
                <li class="nav-item"><a class="nav-link" href="close_soi-display.php">Display SO Closed</a></li>
                <li class="nav-item"><a class="nav-link" href="close_soi-search.php">Search SO Close</a></li>
              </ul>
        
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Closed Sales Order</h3>
            <div class="tile-body">
              <div class="table-responsive">
        <?php
	  
	
	   $message_soi = "";
	   $message_soi2 = "";
	   $message_shipto = "";
	   $message_psdt = "";
	   
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
					
			
         $so_no = $_POST["so_no"];
		 $dateF = $_POST["date1"];
		 $ship_to = $_POST["ship_to"]; 
		 
		
	  
	  //--SO No.
	   if(($_POST["so_no"]) == "")
     {
	     $so_no = FALSE;
		 $message_soi = '<span class="badge badge-pill badge-danger"> Please enter SO Number!</span>';
	 }else{
		  
		 $so_no = TRUE;
		 
		  $query_po_list = "SELECT * FROM so_close_detail WHERE so_no = '".sql_esc($_POST["so_no"])."' AND status_so = '".sql_esc($rst_sta13["status_desc"])."'";
          $result_po_list = mysqli_query($dbc,$query_po_list);
          $row_list = mysqli_fetch_array($result_po_list);
       
			 
			 if($row_list > 0 )
			 {
				 
			  $message_soi2 = '<span class="badge badge-pill badge-danger"> SO Number is already status closed!</span>';	 
			  $so_no = FALSE;
				 
			 }
	    
		 
	  }
	  
	   if(($_POST["ship_to"]) == "NULL")
		 {
			 $ship_to = FALSE;
			 $message_shipto = '<span class="badge badge-pill badge-danger">Please select Ship to Party!</span>';
		 }else{
			 
			 $ship_to = TRUE;	 
			 
		  }
	  
	  
		  if((($_POST["date1"]) == "00-00-0000") || (($_POST["date1"]) == ""))
     {
	     $dateF = FALSE;
		 $message_psdt = '<span class="badge badge-pill badge-danger"> Please select Posting Date !</span>';
	 }else{
		 $dateF = TRUE;
	  }
	  
	
		if($so_no && $ship_to && $dateF)
	   {
		   
        $so_no = $_POST["so_no"];
		  	$dateF = $_POST["date1"];
		    $ship_to = $_POST["ship_to"]; 
			 
			 //------ get date posting -------
		     $ddF = substr($_POST["date1"],0,2);
				 $mmF = substr($_POST["date1"],3,2);
				 $yyF = substr($_POST["date1"],6,4);
			
			     $date1_final1 = ($yyF.'-'.$mmF.'-'.$ddF);
			
			
			//----cust detail
			
			$query_info_cust = "SELECT * FROM cust_detail WHERE id_cust = '".sql_esc($ship_to)."' AND status_cust = 'Y'";
			$result_info_cust = mysqli_query($dbc,$query_info_cust);
      $row_info_cust = mysqli_fetch_array($result_info_cust);
			
			
			
		   //-----add table so_close_detail
		       $q_con = "INSERT INTO so_close_detail(id_so,so_no,ship_to,ship_desc,user_closed,date_closed,remark_closed,user_create,date_create,plant_code,status_so)  VALUES('','".sql_esc($so_no)."','".sql_esc($ship_to)."','".sql_esc($row_info_cust["cust_desc"])."','".sql_esc($username)."','".sql_esc($date1_final1)."','System Closed','".sql_esc($username)."',NOW(),'3100','".sql_esc($rst_sta13["status_desc"])."')";
           $rst_con = mysqli_query($dbc,$q_con);


      //---- update status      

			
		      $query_info = "SELECT * FROM so_detail_dlv WHERE so_no = '".sql_esc($_POST["so_no"])."'";
          $result_info = mysqli_query($dbc,$query_info);
          $row_info = mysqli_fetch_array($result_info);
		
		
		  if($row_info["status_so"] != ($rst_sta13["status_desc"]))
		   {
			   
			   
		//-----update status closed to open -------
		
		$query_upd_pps = "UPDATE so_detail_dlv SET status_so = '".sql_esc($rst_sta13["status_desc"])."', user_closed = '".sql_esc($username)."', date_closed = NOW(), remark_closed = 'System Closed' WHERE so_no = '".sql_esc($_POST["so_no"])."'";
		$result_upd_pps = mysqli_query($dbc,$query_upd_pps);
		
			   
			
		   }
			
			

		   
       echo "<script>";
		   echo "alert('SO No. $so_no is successfully closed.');";
		   echo "window.location='close_soi-create.php'";
	     echo "</script>"; 
		   exit(); //quit the script		   
			
			
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
                <th>Sales Order Number : <font color="#FF0000">*</font></th>
                <th colspan="2">
           <input class="form-control" id="so_no" type="text" placeholder="Enter Sales Order No." name="so_no" value="<?php if(isset($_POST['so_no'])){ echo html_esc($_POST['so_no']); } ?>" />    
          <div class="form-control-feedback" ><?php echo $message_soi; ?></div> <div class="form-control-feedback" ><?php echo $message_soi2; ?></div>
            <!-- <div id="result"></div>-->
               </th>
              </tr>
             <tr>  
            <th>Ship to Party :</th>
            <td colspan="3">
           <select name="ship_to" class="form-control" >
                      <option value="NULL" placeholder="Select Ship to Party"> -- Select Ship to Party -- </option>
                      <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM cust_detail WHERE status_cust = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
                      <option value="<?php echo html_esc($row27["id_cust"]); ?>" > <?php echo stripslashes($row27["id_cust"]); ?> - <?php echo html_esc($row27["cust_desc"]); ?></option>
                      <?php
           }  ?>
                    </select><div class="form-control-feedback" ><?php echo $message_shipto; ?></div>
		     </td>
             </tr>
             <tr>
                <th>Closing Date : <font color="#FF0000">*</font></th>
                <td colspan="3"><input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php if(isset($_POST['date1'])){ echo html_esc($_POST['date1']); }else{ echo $fmt_curr_date; } ?>" /> 
                    <div class="form-control-feedback" ><?php echo $message_psdt; ?></div></td>
                    </tr>
              
              
              <tr>
                <th>
                
     <input name="Submit2" type="submit"  class="btn btn-success" value="CLOSE SO" onclick="return confirm('Are you sure to close this Sales Order No.?');"/>             
                
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
	  
      
    </script>

  </body>
</html>