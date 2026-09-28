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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
    $url = "detail_DI_doc-dikanban_PPC.php";
	
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
      <?php   include "left_prod_menu.php";   ?>
   
    <main class="app-content">
    
     <div class="app-title">
        <div>
          <h1><i class="fa fa-file-text-o"></i> Report</h1>
          <p>Delivery Instruction PPC</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Report </li>
          <li class="breadcrumb-item"><a href="detail_DI_doc-dikanban_PPC.php">Delivery Instruction PPC</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Document List </h3>
            <div class="tile-body">
              <div class="table-responsive">
          <?php
		  
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
         	$vendor_code = $_GET["vendor_code"]; 
		  
		  ?>    
              
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="3">&nbsp;</th>
            </tr>
           
            <tr>
            <th>Vendor : </th>
            <td colspan="3">
           <select name="vendor_code" class="form-control" >
                  <option value="NULL" placeholder="Select Vendor"> -- Select Vendor -- </option>
                  <?php
					  
			//------------- select get login vendor --------------
		$query_ath_vend = "SELECT * FROM vendor_detail WHERE status_acc = 'Y'";
		$result_ath_vend = mysqli_query($dbc,$query_ath_vend);
	
          
              while($data_ath_vend = mysqli_fetch_array($result_ath_vend)) {
				 
				  
        
              ?>
                      <option value="<?php echo html_esc($data_ath_vend["vendor_code"]); ?>" <?php if($data_ath_vend["vendor_code"] == $_GET["vendor_code"]) echo "selected"; ?> > <?php echo stripslashes($data_ath_vend["vendor_code"]); ?> - <?php echo html_esc($data_ath_vend["vendor_name"]); ?></option>
                      <?php
           }  ?>    
				  
                </select>
		     </td>
             </tr>
             <tr>
                <th>Delivery Date from : <font color="#FF0000">*</font></th>
                <td colspan="3">
        <?php
			     $dd1 = substr($_GET["date1"],8,2);
				 $mm1 = substr($_GET["date1"],5,2);
				 $yy1 = substr($_GET["date1"],0,4);
			?>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" >
                  
                    </td></tr>
                <tr>
                <th>Delivery Date to :  <font color="#FF0000">*</font></th>
                <td colspan="3"><?php
			     $dd2 = substr($_GET["date2"],8,2);
				 $mm2 = substr($_GET["date2"],5,2);
				 $yy2 = substr($_GET["date2"],0,4);
			?>
             <input class="form-control" id="PSSDate2" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>" ></td>
             
              </tr>
             
              <tr>
                <th><input name="Submit22" type="submit" class="btn btn-info" id="button" value="SEARCH" />          
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
				 
								 		
		 // 1. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND (date_posting_do >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //2. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
					$wheresql_02 = " AND (date_posting_do <= '".sql_esc($date2_final)."')"; }
					
						
	       //3. Vendor Code
                if (($vendor_code == "") || ($vendor_code == "NULL")){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND vc_code = '".sql_esc($vendor_code)."'"; } 
					
		 
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03;
	
	//********** END CONDITION **************
	
   $query8 = "SELECT COUNT(*) FROM dlv_ord_dikanban_generate WHERE (status_kanban = '".sql_esc($rst_sta["status_desc"])."' OR status_kanban = '".sql_esc($rst_sta7["status_desc"])."')" .$where_sql ."GROUP BY do_no";
   $result8 = mysqli_query($dbc,$query8);
   $num_rows = mysqli_num_rows($result8);
			
  
 
  
$query = "SELECT *, DATE_FORMAT(date_posting_do,'%d-%m-%Y') as RP FROM dlv_ord_dikanban_generate WHERE (status_kanban = '".sql_esc($rst_sta["status_desc"])."' OR status_kanban = '".sql_esc($rst_sta7["status_desc"])."') " .$where_sql." GROUP BY do_no ORDER BY DI_doc ASC ";
$rs = mysqli_query($dbc,$query);
$num_rows = mysqli_num_rows($rs);   //how many material are there?
    
		  
		 if ($num_rows > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>'; 
	   
        
    	?>
        
        <table class="table">
            <tr>
                <td width="1%">&nbsp;</td> 
                <td width="85%">&nbsp;</td> 
                  <td width="7%"><a href="rpt_dList_DI-dikanban_download_PPC.php?vendor_code=<?php echo html_esc($vendor_code); ?>&&date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>" ><img src="../images/dload_excel.jpg" width="48" height="48" title="Download" /></a></td>
                 <td width="7%"><!--<img src="../images/print2.jpg" width="48" height="48" onClick="window.print()" title="Print"/>--></td>
               
              </tr>
            </table> 
      
        
        
        
        
        

                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>No.</th>  
                    <th>Delivery Instruction No.</th>
                    <th>Purchase Order No.</th>
                    <th>Delivery Order No.</th>
                    <th>Vendor Name</th>
                    <th>Delivery Date</th>
                    <th>Action</th>
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
	   
	 
                 //----vendor detail ------
				   $query_vcode = "SELECT * FROM vendor_detail WHERE vendor_code = '".sql_esc($row["vc_code"])."' AND status_acc = 'Y'";
                   $result_vcode = mysqli_query($dbc,$query_vcode);
                   $row_vcode = mysqli_fetch_array($result_vcode);	
     
	
      ?>
                <tr>
                <td width="30"><?php echo $no4; ?></td>
                <td width="150"><?php echo html_esc($row["DI_doc"]); ?></td>
                <td width="150"><?php echo html_esc($row["po_no"]); ?></td>
                <td width="150"><?php echo html_esc($row["do_no"]); ?></td>
                <td width="250"><?php echo html_esc($row_vcode["vendor_name"]); ?></td> 
                <td width="100"><?php echo html_esc($row["RP"]); ?></td>
             
                 <td width="100">
                 <a href="display_DI_dikanban_wsel.php?buid=<?php echo base64_encode($row["DI_doc"]); ?>&&uid=<?php echo base64_encode($row["po_no"]);?>&&duid=<?php echo base64_encode($row["do_no"]);?>" target="_blank"><i class="fa fa-search" aria-hidden="true"></i>View</a> 
                 
                    <!--------------------------modal------------------------->
          <?php   // include "display_DI_dikanban_wsel.php";   ?>
                
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