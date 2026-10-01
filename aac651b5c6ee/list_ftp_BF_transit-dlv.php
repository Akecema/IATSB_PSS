<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED &~ E_WARNING);
//ini_set("display_errors", 0); 
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

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
	
    $url = "list_ftp_BF_transit-dlv.php";

	
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
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    
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
          <h1><i class="fa fa-download"></i> FTP Monitoring</h1>
          <p>FTP Monitoring - Backflush Transit</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">FTP Monitoring</li>
          <li class="breadcrumb-item"><a href="list_ftp_BF_transit-dlv.php">Backflush Transit</a></li>
        </ul>
      </div> 
          <!--  <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="list_ftp_BF_transit-dlv.php">2300 - BB Plant </a></li>
                 <li class="nav-item"><a class="nav-link" href="list_ftp_BF_transit-dlvmk.php">2301 - MK Plant</a></li>
               
              </ul>
              -->
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body"><br><br>
              <div class="table-responsive">
              
              
              <?php
		
	    //date_default_timezone_set('Asia/Bangkok');
		//date_default_timezone_set('Asia/Kuala Lumpur');
		
/*
$root = $_SERVER['DOCUMENT_ROOT'];
$path = "../../FromPortal/BF_TRANSIT/"; 

// Open the folder
 // Missing folder is a normal case (FTP delivery not yet landed/configured for this env);
// is_dir($dir) check below already handles it by showing an empty list.
@opendir($root . $path);

$dir = "$root/FromPortal/BF_TRANSIT/";

$folder = '../../FromPortal/BF_TRANSIT/';
$filetype = '*.*';    
$files = glob($folder.$filetype);    
$total = count($files);*/   


$root = $_SERVER['DOCUMENT_ROOT'];
$path = "/FromPortal/BF_TRANSIT/"; 

// Open the folder
 // Missing folder is a normal case (FTP delivery not yet landed/configured for this env);
// is_dir($dir) check below already handles it by showing an empty list.
@opendir($root . $path);

$dir = "$root/FromPortal/BF_TRANSIT/";

$folder = '/FromPortal/BF_TRANSIT/';
$filetype = '*.*';    
$files = glob($folder.$filetype);    
$total = count($files); 

 

// Open a directory, and read its contents
if(is_dir($dir)){
  if($dh = opendir($dir)){
  
  // Open a directory, and read its contents
if(is_dir($dir)){
  if($dh = opendir($dir)){
  
   echo "<br>";
  // echo "<font color='blue'>TOTAL FILES : ".$total." </font>"; echo "<br>";
   ?>
   <table class="table table-hover table-bordered" id="example">
  <thead>
   <tr>
    <td width="20%">File Name</td> 
    <td width="20%">Part No. From</td>
    <td width="10%">Quantity</td>
    <td width="10%">UoM</td> 
    <td width="10%">SLoc</td>
    <td width="10%">Section/Line</td>
    <td width="10%">Posting Date</td>
    <td width="10%">Posting Time</td>
   </tr>
   </thead>
   </table>
   
   <?php
      while (($file = readdir($dh)) !== false){
	
	            clearstatcache();
                if(is_file($dir."/".$file)) {    
				 $path_parts2 = pathinfo($file);
                 $filename2 = $path_parts2['filename']; 
				 
		
		
		$queryAA = "SELECT * FROM ftp_bflush_detail_bf_transit WHERE file_name = '".sql_esc($filename2)."' AND status_ftp = 'Y' AND plant_code = '3100' GROUP BY file_name";
	    $rsAA = mysqli_query($dbc,$queryAA);   //run the query.
		
		while($row_rsAA = mysqli_fetch_array($rsAA)){
		
		?>
		<i class="fa fa-folder-open"></i> <?php echo html_esc($row_rsAA["file_name"]); ?>


   <?php		
   //---check filename --------
		
	$queryA = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') AS R3 FROM ftp_bflush_detail_bf_transit WHERE file_name = '".sql_esc($filename2)."' AND status_ftp = 'Y' AND plant_code = '3100'";
	$rs = mysqli_query($dbc,$queryA);   //run the query.
	

	while($row_rs = mysqli_fetch_array($rs)){   //how many material are there?
	
	
	
	    //---check table tp_store_detail	
    $query_whn = "SELECT * FROM pps_detail_trn_bf_transit WHERE id = '".sql_esc($row_rs["ref_id"])."' AND bflush_no = '".sql_esc($row_rs["bflush_no"])."' AND plant_code = '3100'";
	$rs_whn = mysqli_query($dbc,$query_whn);   //run the query.
	$row_whn = mysqli_fetch_array($rs_whn);   //how many material are there?	
	
	$row_ctn = mysqli_num_rows($rs_whn);  
	
	//echo $row_ctn;		
		
		if($row_rs){ 		                
    ?>
  <table class="table">
 <tbody>
  <tr> 
    <td width="20%"><?php echo html_esc($row_rs["file_name"]); ?></td>
    <td width="20%"><?php echo html_esc($row_rs["material_no"]); ?></td>
    <td width="10%"><?php echo intval($row_rs["qty_ftp"]); ?></td>
    <td width="10%"><?php echo html_esc($row_rs["uom"]); ?></td>
    <td width="10%"><?php echo html_esc($row_whn["ploc"]); ?></td>
    <td width="10%"><?php echo html_esc($row_whn["work_center"]); ?></td>
    <td width="10%"><?php echo html_esc($row_rs["R3"]);  ?></td>
    <td width="10%"><?php echo html_esc($row_rs["posting_time"]);  ?></td>
  </tr>
  </tbody>
</table>

<?php  }//end if($row_rs)


	} // end A
		} //end AA



        $queryBB = "SELECT * FROM ftp_bflush_detail_bf_transit_cancel WHERE file_name = '".sql_esc($filename2)."' AND status_ftp = 'Y' AND plant_code = '3100' GROUP BY file_name";
	    $rsBB = mysqli_query($dbc,$queryBB);   //run the query.
		
		while($row_rsBB = mysqli_fetch_array($rsBB)){
		
		?>
		<i class="fa fa-folder-open"></i> <?php echo html_esc($row_rsBB["file_name"]); ?>


   <?php		
   //---check filename --------
		
	$queryB = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') AS R3 FROM ftp_bflush_detail_bf_transit_cancel WHERE file_name = '".sql_esc($filename2)."' AND status_ftp = 'Y' AND plant_code = '3100'";
	$rsB = mysqli_query($dbc,$queryB);   //run the query.
	

	while($row_rsB = mysqli_fetch_array($rsB)){   //how many material are there?
	
	
	
	    //---check table tp_store_detail	
    $query_whn2 = "SELECT * FROM pps_detail_trn_bf_transit_cancel WHERE id_fg = '".sql_esc($row_rsB["ref_id"])."' AND bflush_no = '".sql_esc($row_rsB["bflush_no"])."' AND plant_code = '3100'";
	$rs_whn2 = mysqli_query($dbc,$query_whn2);   //run the query.
	$row_whn2 = mysqli_fetch_array($rs_whn2);   //how many material are there?	
	
	$row_ctn2 = mysqli_num_rows($rs_whn2);  
	
	//echo $row_ctn;		
		
		if($row_rsB){ 		                
    ?>
  <table class="table">
 <tbody>
  <tr> 
    <td width="20%"><?php echo html_esc($row_rsB["file_name"]); ?></td>
    <td width="20%"><?php echo html_esc($row_rsB["material_no"]); ?></td>
    <td width="10%"><?php echo intval($row_rsB["qty_ftp"]); ?></td>
    <td width="10%"><?php echo html_esc($row_rsB["uom"]); ?></td>
    <td width="10%"><?php echo html_esc($row_whn2["ploc"]); ?></td>
    <td width="10%"><?php echo html_esc($row_whn2["work_center"]); ?></td>
    <td width="10%"><?php echo html_esc($row_rsB["R3"]);  ?></td>
    <td width="10%"><?php echo html_esc($row_rsB["posting_time"]);  ?></td>
  </tr>
  </tbody>
</table>

<?php  }//end if($row_rsB)


	} // end B
		} //end BB








	  } //end while
    }
	
    //closedir($dh);
  }
}

  }


  }
  
  // $mysql_fetch_close($rs);



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
    
<!--    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#example').DataTable();</script>-->
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
   
				
  </body>
</html>