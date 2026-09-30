<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));



                 $drun = substr($fmt_curr_date,0,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,8,2);
				 
				 $date_run = ($drun.$mrun.$yrun);

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
	
    $url = "can_prog_trn-posting.php"; 
	
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
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script> 
    
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>-->
       <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

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
<style>
.shortenedSelect {
    max-width: 300px;
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
          <h1><i class="fa fa-times"></i> Cancellation</h1>
          <p>Transfer Posting</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Cancellation</li>
          <li class="breadcrumb-item"><a href="can_prog_trn-posting.php">Transfer Posting</a></li>
        </ul>
      </div> 
        
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Cancellation </h3>
            <div class="tile-body">
              <div class="table-responsive">
              <ul class="nav nav-tabs">
               <li class="nav-item"><a class="nav-link" href="can_prog_trn-posting.php">Cancellation </a></li>
               <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="can_prog_aftrn-posting.php">Cancelled</a></li>
                          
              </ul> 
              
  <?php       
  
    $message_pcode = "";
	$message_slocf = "";
	$message_sloct = "";
	$message_psdf = "";
	$message_psdt = "";

		    
			$dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plant_code = $_GET["plant_code"];
			$sloc_f = $_GET["sloc_f"];
			$sloc_t = $_GET["sloc_t"];
		
	
?>


    
              <form action="" method="get" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th colspan="3">&nbsp;</th>
            </tr>
             <tr>
            <th>Plant :  <font color="#FF0000">*</font></th>
            <td colspan="3">
           <select name="plant_code" class="form-control" >
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
                     <div class="form-control-feedback" ><?php echo $message_pcode; ?></div>
		     </td>
             </tr>
               <tr>
                <th>Sloc from : </th>
                   <td colspan="3">
            <select name="sloc_f" id="sloc_f" class="form-control">
                       <option value="NULL" placeholder="Select Storage Location"> -- Select Storage Location --</option>
               
                  <?php
	               $query_sect = "SELECT * FROM sloc_tbl ORDER BY sloc_id ASC";
                   $result_sect = mysqli_query($dbc,$query_sect);
  
                   while($row_sect = mysqli_fetch_array($result_sect)) 
			      {
				 ?>
                    <option value="<?php echo html_esc($row_sect["sloc_code"]); ?>"<?php if($row_sect["sloc_code"] == $_GET["sloc_f"]) echo "selected"; ?>> <?php echo html_esc($row_sect["sloc_code"]); ?> - <?php echo html_esc($row_sect["sloc_desc"]); ?></option>
                     
                  <?php
				
				  
                  }
				?>
              </select>     
              <div class="form-control-feedback" > <?php echo $message_slocf; ?></div> 
               </th>
               </tr>
                 <tr>
                <th>Sloc to : </th>
                 <td colspan="3">
                
                 <select name="sloc_t" id="sloc_t" class="form-control">
                 <option value="NULL" placeholder="Select Storage Location"> -- Select Storage Location --</option>
               
                  <?php
	               $query_sect2 = "SELECT * FROM sloc_tbl ORDER BY sloc_id ASC";
                   $result_sect2 = mysqli_query($dbc,$query_sect2);
  
                   while($row_sect2 = mysqli_fetch_array($result_sect2)) 
			      {
				    ?>
                    <option value="<?php echo html_esc($row_sect2["sloc_code"]); ?>"<?php if($row_sect2["sloc_code"] == $_GET["sloc_t"]) echo "selected"; ?>> <?php echo html_esc($row_sect2["sloc_code"]); ?> - <?php echo html_esc($row_sect2["sloc_desc"]); ?></option>
                     
                  <?php
				  
                  }
				?>
              </select>     
                <div class="form-control-feedback" > <?php echo $message_sloct; ?></div> 
                </th>
               </tr>
              <tr>
              <th>Posting Date from :  <font color="#FF0000">*</font></th>
                 <td colspan="3"><input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" >
               <div class="form-control-feedback" ><?php echo $message_psdf; ?></div>
              </td>
              </tr>
              <tr>
              <th>Posting Date to:  <font color="#FF0000">*</font></th>
                 <td colspan="3"><input class="form-control" id="PSS2Date" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>">
               <div class="form-control-feedback" ><?php echo $message_psdt; ?></div> 
                </th>
              </tr>
              <tr>
                <th><input name="submit3" type="submit" id="submit3" value="SEARCH" class="btn btn-info"  /></th>
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
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);
				 		
		 // 1. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND (posting_date >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 2. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (posting_date <= '".sql_esc($date2_final)."')"; } 
					 	 
		 //3. Plant Code 
                if ($plant_code == "NULL"){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND plant_code = '".sql_esc($plant_code)."'"; } 
					
          //4. sloc from
                if ($sloc_f == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND sloc_from = '".sql_esc($sloc_f)."'"; }
   
	       //5. sloc to
                if ($sloc_t == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND sloc_to = '".sql_esc($sloc_t)."'"; }  	
					
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;	
	
	//********** END CONDITION **************
	
   $query8 = "SELECT COUNT(*) FROM tp_store_detail WHERE status_tp = '".sql_esc($rst_sta4["status_desc"])."' " .$where_sql;
   $result8 = mysqli_query($dbc,$query8);
   $num_rows = mysqli_num_rows($result8);
			
  
 
  
$query = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as R, DATE_FORMAT(date_cancel,'%d-%m-%Y') as R7 FROM tp_store_detail WHERE status_tp = '".sql_esc($rst_sta4["status_desc"])."'" .$where_sql." GROUP BY doc_tp ORDER BY id_tp ASC ";
$rs = mysqli_query($dbc,$query);
$num_rows = mysqli_num_rows($rs);   //how many material are there?
    
		  
		 if ($num_rows > 0) {
	 
	         echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>';
			  		 	
?>
           
              <!-- <form action="can_prog_trn-postingProc2.php" method="post" name="myform" id="myform">-->
           
                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>No.</th>
                    <th>Plant</th>
                    <th>SLoc From</th>
                    <th>SLoc To</th>
                    <th>Shift</th>
                    <th>Posting Date</th>
                    <th>Document No.</th>
                    <th>Cancellation Doc. No.</th>
                    <th>Cancellation Date</th>
                    <th>Action</th>
                </tr>
              </thead>    
              <tbody>
           <?php 

   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   
   while($row = mysqli_fetch_array($rs))
   {
	   
	   // $no4 = sprintf('%04d',$no4);

		
      ?>
                <tr>
                <td width="30"><?php echo $no4; ?><input name="id_tp[<?php echo html_esc($row["id_scan_tp"]); ?>]" type="hidden" value="<?php echo html_esc($row["id_scan_tp"]); ?>">
               </td>
                <td width="200"><?php echo html_esc($row["plant_code"]); ?></td>
                <td width="80"><?php echo html_esc($row["sloc_from"]); ?></td>
                <td width="80"><?php echo html_esc($row["sloc_to"]); ?></td> 
                <td width="80"><?php echo html_esc($row["shift_day"]); ?></td> 
                <td width="100"><?php echo html_esc($row["R"]); ?></td>
                <td width="80"><?php echo html_esc($row["doc_tp"]); ?></td>
                <td width="100"><?php echo html_esc($row["ref_doc_tp"]); ?></td>
                <td width="100"><?php if($row["date_cancel"] != "0000-00-00 00:00:00") { echo html_esc($row["R7"]);  }else{    } ?></td>
                <td width="100"> <a href="#myNoteView<?php echo html_esc($row["doc_tp"]); ?>" data-toggle="modal" target="_parent"><i class="fa fa-search" aria-hidden="true"></i>View</a> 
                 
                    <!--------------------------modal------------------------->
          <?php    include "display_tp_tran_proc_wselCan.php";   ?></td>
          
              
                </tr>
                 
          <?php 
		  
		  $no4++;
		  $counter++; // menambah counter
	
		  } 
		  
       mysqli_free_result($rs); 		  
		  ?>
</tbody>
</table> 
        
<?php  

 }else{
	 
 
?> <center>
<table width="800" cellspacing="0" class="textboxred">
  <tr> 
    <td><div align="center"><font color="#FF0000"><strong>There are currently no record(s).</strong></font></div></td>
  </tr>
</table></center>

<?php   } ?>


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
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
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
	  
      
	   $('#PSS2Date').datepicker({
		defaultDate: new Date(),   
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
    </script>
  
  </body>
</html>