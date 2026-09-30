<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
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
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	//include 'apprv_func_list_qc.php';
	
    $url = "FTP_gratranfer_monitor2.php";
	
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

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);

//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc,$sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);


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
        width: 1200px;
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
          <h1><i class="fa fa-file-text-o"></i> Report</h1>
          <p>Disposal QC</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Report</li>
          <li class="breadcrumb-item"><a href="FTP_gratranfer_monitor2.php">Disposal QC</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Document List</h3>
            <div class="tile-body">
              <div class="table-responsive">
          <?php
		  
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
			$plant_code = $_GET["plant_code"]; 
		    $trans_opt = $_GET["trans_opt"]; 
			
			
			if($_GET["trans_opt"] == "QC")
			 {
				 
		    echo "<script>";
            echo "window.location='FTP_gratranfer_monitor_DIS.php?plant_code=".html_esc($plant_code)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&trans_opt=".html_esc($trans_opt)."'";
            echo "</script>";
            exit(); //quit the script	 
		

			 }else{
				
				 
			 }
			
					
		  ?>    
              
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="3">&nbsp;</th>
            </tr>
            <tr>
            <th>Plant : </th>
            <td colspan="3">
           <select name="plant_code" class="form-control">
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
                <th>Posting Date from :</th>
                <td colspan="3">
        <?php
			     $dd1 = substr($_GET["date1"],8,2);
				 $mm1 = substr($_GET["date1"],5,2);
				 $yy1 = substr($_GET["date1"],0,4);
			?>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" >
                  
                    </td></tr>
                 <tr>
                <th>Posting Date to :</th>
                <td colspan="3"><?php
			     $dd2 = substr($_GET["date2"],8,2);
				 $mm2 = substr($_GET["date2"],5,2);
				 $yy2 = substr($_GET["date2"],0,4);
			?>
             <input class="form-control" id="PSSDate2" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>" ></td>
             
              </tr>
              <tr>
                <th>Reject Source :</th>
                <th colspan="3">
              <select name="trans_opt" id="trans_opt" class="form-control">
              <option value="NULL" placeholder="Select Output Status"> -- Select Output Status --</option>
              <option value="QC" <?php if($_GET["trans_opt"] == 'QC') { ?> selected="selected"<?php } ?>>Reject Part</option>
              <option value="CREJ" <?php if($_GET["trans_opt"] == 'CREJ') { ?> selected="selected"<?php } ?>>Reject Component</option>
              </select>    
     			</th>
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
					
		   // 3. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND (date_posting >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (date_posting <= '".sql_esc($date2_final)."')"; }
							

				$where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04;
	
	//********** END CONDITION **************
	
		  
 			
			
   $query8Dis = "SELECT COUNT(*) FROM disposal_detail_prd_all WHERE status_part = 'QC' AND reject_source = 'CREJ' AND status_disposal != '".sql_esc($rst_sta13["status_desc"])."' " .$where_sql ."GROUP BY doc_dis";
   $result8Dis = mysqli_query($dbc,$query8Dis);
   $num_rowsDis = mysqli_num_rows($result8Dis);
			
  
$queryDis = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as R, DATE_FORMAT(date_cancel,'%d-%m-%Y') as R7 FROM disposal_detail_prd_all WHERE status_part = 'QC' AND reject_source = 'CREJ' AND status_disposal != '".sql_esc($rst_sta13["status_desc"])."' " .$where_sql." GROUP BY doc_dis ORDER BY doc_dis ASC ";
$rsDis = mysqli_query($dbc,$queryDis);
$num_rowsDis = mysqli_num_rows($rsDis);   //how many material are there?
    
		  
		 if ($num_rowsDis > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rowsDis.' record(s).</div>'; 
	   
        
    	?>
        
        <table class="table">
<tr>
    <td width="1%">&nbsp;</td> 
    <td width="85%">&nbsp;</td> 
    <td width="7%"><a href="report_document_list-comp_rejQC_DIS_download.php?plant_code=<?php echo html_esc($plant_code); ?>&&date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&trans_opt=<?php echo html_esc($trans_opt); ?>" ><img src="../images/dload_excel.jpg" width="48" height="48" title="Download" /></a></td>
    
  </tr>
</table> 
        
        
      
                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>No</th>
                    <th>Plant</th>
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
   
   while($row = mysqli_fetch_array($rsDis))
   {
			   
	    if($row["shift_posting"] == "D/S")
		{
			
		$shift_nw = "Day";
		}elseif($row["shift_posting"] == "N/S")
		{
		$shift_nw = "Night";
		
		}else{
			
			$shift_nw = "N/A";
		}
	   
      ?>
                <tr>
                <td width="30"><?php echo $no4; ?></td>
                <td width="80"><?php echo html_esc($row["plant_cd"]); ?></td>
                <td width="80"><?php echo $shift_nw; ?></td>
                <td width="100"><?php echo html_esc($row["R"]); ?></td> 
                <td width="100"><?php echo html_esc($row["doc_dis"]);  ?></td>
                <td width="100"><?php if($row["status_disposal"] == $rst_sta4["status_desc"]) { echo html_esc($row["dis_no_ref"]);  }  ?></td>
                <td width="100"><?php if($row["date_cancel"] != "0000-00-00 00:00:00") { echo html_esc($row["R7"]);  }else{   }  ?></td>
                <td width="100">
                
                 <a href="#myNoteDisplayA<?php echo html_esc($row["doc_dis"]); ?>" data-toggle="modal" target="_parent"><i class="fa fa-search" aria-hidden="true"></i>View</a> 
                 
                    <!--------------------------modal------------------------->
          <?php    include "display_disposal_comp_rej_qc_wsel.php";   ?>
                              
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

<?php
   mysqli_free_result($rsDis); 
   
 
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
	
    function getVendor(plant_code) {		
		
		var strURL="findVendor2-GRA.php?plant_code="+plant_code;
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
	
	
</script>
  </body>
</html>