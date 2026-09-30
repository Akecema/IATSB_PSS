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
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    <!--  <script src="https://www.w3schools.com/lib/w3.js"></script>-->
	
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
        <h1><i class="fa fa-truck"></i>Delivery</h1>
          <p>SO Close</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Delivery</li>
          <li class="breadcrumb-item"><a href="close_soi-search.php">Search SO Close</a></li>
        </ul>
      </div> 
             <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="close_soi-create.php">Closed Sales Order</a></li>
                <li class="nav-item"><a class="nav-link" href="close_soi-display.php">Display SO Closed</a></li>
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="close_soi-search.php">Search SO Close</a></li>
            </ul>      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Search SO Close </h3>
            <div class="tile-body">
              <div class="table-responsive">
          <?php

        $message_pcode = '';  
		  
		    $dateF = $_GET["date1"];
		  	$dateT = $_GET["date2"];
        $plant_code = $_GET["plant_code"]; 
		  
		  ?>    
              
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="3">&nbsp;</th>
            </tr>
            <tr>
            <th>Plant :  <font color="#FF0000">*</font></th>
            <td colspan="3">
            <select name="plant_code" class="form-control" >
           <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
            <?php
                
				  $query_autho_plant = "SELECT * FROM plant_detail WHERE status_plant = 'Y' ORDER BY plant_id ASC ";
		      $sta_autho_plant = mysqli_query($dbc,$query_autho_plant);		
		          
				  while($rst_autho_plant=mysqli_fetch_array($sta_autho_plant))
				  {   
				 
				   ?> 
      <option value="<?php echo html_esc($rst_autho_plant["plant_code"]); ?>" <?php if($rst_autho_plant["plant_code"] == $_GET["plant_code"]) echo "selected"; ?>> <?php echo html_esc($rst_autho_plant["plant_code"]); ?> - <?php echo html_esc($rst_autho_plant["plant_desc"]); ?></option>     
                
                  <?php
                  }
				?>   
                    </select>
                     <div class="form-control-feedback" ><?php echo $message_pcode; ?></div>
		     </td>
             </tr>
            
             <tr>
                <th>Document Date from : <font color="#FF0000">*</font></th>
                <td colspan="3">
        <?php
			   $dd1 = substr($_GET["date1"],8,2);
				 $mm1 = substr($_GET["date1"],5,2);
				 $yy1 = substr($_GET["date1"],0,4);
			?>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" >
                  
                    </td></tr>
                <tr>
                <th>Document Date to :  <font color="#FF0000">*</font></th>
                <td colspan="3"><?php
			   $dd2 = substr($_GET["date2"],8,2);
				 $mm2 = substr($_GET["date2"],5,2);
				 $yy2 = substr($_GET["date2"],0,4);
			?>
             <input class="form-control" id="PSSDate2" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>" ></td>
             
              </tr>
             
              <tr>
                <th><input name="Submit2" type="submit" class="btn btn-info" id="button" value="SEARCH" />          
                </th>
                <th colspan="3">&nbsp;</th>
              </tr>
            
                </table>
      
 
               
                   
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

         
// 3. dateF
    if ($dateF == "0000-00-00" ){
        $wheresql_03 = ""; }
    else {
        $wheresql_03 = " AND (doc_date >= '".sql_esc($date1_final)."')"; }      
                                    

//4. DateT
    if ($dateT == "0000-00-00" ){
        $wheresql_04 = ""; }
    else {
        $wheresql_04 = " AND (doc_date <= '".sql_esc($date2_final)."')"; }




				$where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04;
	
	//********** END CONDITION **************
	
   $query8 = "SELECT COUNT(*) FROM so_detail_dlv WHERE  status_so = '".sql_esc($rst_sta13["status_desc"])."' " .$where_sql . "GROUP BY so_no ";
   $result8 = mysqli_query($dbc,$query8);
   $num_rows = mysqli_num_rows($result8);
			
  
 
  
$query = "SELECT *, DATE_FORMAT(date_closed,'%d-%m-%Y') as RF FROM so_detail_dlv WHERE  status_so = '".sql_esc($rst_sta13["status_desc"])."' " .$where_sql." GROUP BY so_no ORDER BY so_no ASC ";
$rs = mysqli_query($dbc,$query);
$num_rows = mysqli_num_rows($rs);   //how many material are there?
		  
		 if ($num_rows > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>'; 
	   
        
    	?>

                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>Sales Order No.</th>
                    <th>Material No.</th>
                    <th>Item No.</th>
                    <th>Plant Code</th>
                    <th>Sold to Party</th>
                    <th>Ship to Party</th>
                    <th>User Closed</th>
                    <th>Date Closed</th>
                </tr>
              </thead>    
              <tbody>
           <?php 

   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   $msg_sta = "";
   
   while($row = mysqli_fetch_array($rs))
   {
	   ?>
	   
	   
                <tr>
                <td width="150"><?php echo html_esc($row["so_no"]); ?></td>
                <td width="250"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="100"><?php echo html_esc($row["item_no"]); ?></td>
                <td width="100"><?php  echo html_esc($row["plant_code"]); ?></td>
                <td width="150"><div align="center"><?php echo html_esc($row["sold_no"]); ?></div></td> 
                <td width="150"><div align="center"><?php echo html_esc($row["ship_no"]); ?></div></td>
                <td> <div align="center"><?php echo html_esc($row["user_closed"]); ?>
                 <td width="100"><?php echo html_esc($row["RF"]); ?></td>
            
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
   mysqli_free_result($rs); 
   
 
	}   // free up the resources 
 else
 {
?><center>
<table width="800" cellspacing="0" class="textboxred">
  <tr> 
    <td><div align="center"><font color="#FF0000"><strong>There are currently no record(s).</strong></font></div></td>
  </tr>
</table></center>
</form>
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
	  
      
    </script>
   
  </body>
</html>