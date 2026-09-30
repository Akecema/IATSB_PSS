<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
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
	
    $url = "prt_GR_tag-gd-rect.php";
	
	/*ini_set('display_errors', 1);
	error_reporting(~0);
*/
	
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
          <h1><i class="fa fa-file-text-o"></i> Receiving</h1>
          <p>Print GR Tag</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Receiving </li>
          <li class="breadcrumb-item"><a href="prt_GR_tag-gd-rect.php">Print GR Tag</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Print GR Tag </h3>
            <div class="tile-body">
              <div class="table-responsive">
          <?php
		  
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
           	$purc_ord_no = $_GET["purc_ord_no"];
			$vendor_id = $_GET["vendor_id"]; 
		
		  ?>    
              
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="3">&nbsp;</th>
            </tr>
             <tr>
                <th>PO No. : </th>
                <th colspan="3">
           <input class="form-control" id="purc_ord_no" type="text" placeholder="Enter Purchase Order No." name="purc_ord_no" value="<?php echo html_esc($_GET['purc_ord_no']); ?>" onChange="getVendor(this.value)"/>    
          
            <!-- <div id="result"></div>-->
               </th>
              </tr>
            
              <tr>
                <th>Vendor :</th>
                <th colspan="3">   
                <select name="vendor_id" class="form-control" >
                 <option value="NULL" placeholder="Select Vendor"> -- Select Vendor -- </option>
                
                
                             <?php
			  
			 
				  //-------check vendor detail ----------

				  $query5a = "SELECT * FROM vendor_detail WHERE status_acc = 'Y'";
				  $result5a = mysqli_query($dbc,$query5a);
			     
				 while($row5a = mysqli_fetch_array($result5a)){
                
              ?>
               <option value="<?php echo html_esc($row5a["vendor_code"]); ?>" <?php if($row5a["vendor_code"] == $_GET["vendor_id"]) echo "selected"; ?>> <?php echo stripslashes($row5a["vendor_code"]); ?> - <?php echo html_esc($row5a["vendor_name"]); ?></option>
              
              <?php } ?>
              
              </select></th>
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
                  
                </td>
                </tr>
                <tr>    
                <th>Posting Date from :</th>
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
				 
								 		
		 // 1. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND (posting_gr >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //2. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
					$wheresql_02 = " AND (posting_gr <= '".sql_esc($date2_final)."')"; }
					
					
          //3. Purchase Order Number
                if ($purc_ord_no == ""){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND purc_ord_no = '".sql_esc($purc_ord_no)."'"; } 
					
		  //4. Vendor Number
                if ($vendor_id == "NULL"){ 
                    $wheresql_04 = " AND vendor_id != ''"; }
                else {
                    $wheresql_04 = " AND vendor_id = '".sql_esc($vendor_id)."'"; } 
					
	     	 				        
	
	          	//$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;	                              
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04;	
	
	//********** END CONDITION **************
	
   $query8 = "SELECT COUNT(*) FROM po_detail_trans_gr WHERE status_po = '".sql_esc($rst_sta7["status_desc"])."' AND status_gr = '".sql_esc($rst_sta3["status_desc"])."'" .$where_sql ."GROUP BY material_doc_gen";
   $result8 = mysqli_query($dbc,$query8);
   $num_rows = mysqli_num_rows($result8);
			
  
 
  
$query = "SELECT *, DATE_FORMAT(posting_gr,'%d-%m-%Y') as R FROM po_detail_trans_gr WHERE status_po = '".sql_esc($rst_sta7["status_desc"])."' AND status_gr = '".sql_esc($rst_sta3["status_desc"])."' " .$where_sql." GROUP BY material_doc_gen ORDER BY posting_gr ASC ";
$rs = mysqli_query($dbc,$query);
$num_rows = mysqli_num_rows($rs);   //how many material are there? 
    
		  
		 if ($num_rows > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>'; 
	   
        
    	?>

                <table class="table table-hover table-bordered dataTable" id="example">
               <thead>
                <tr>
                    <th>Item</th>
                    <th>Purchase Order No.</th>
                    <th>Delivery Order No.</th>   
                    <th>Posting Date</th>
                    <th>Document No.</th>
                    <th>Vendor</th>
                    <th>Receipient</th>
                    <th>Shift</th>
                    <th>Action</th>
                </tr>
              </thead>    
              <tbody>
           <?php 

   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   $shift_desc = "";
   
   while($row = mysqli_fetch_array($rs))
   {
	   if($row["shift_gr"] == "D/S")
	   {
		  $shift_desc = "Day";
		   
	   }elseif($row["shift_gr"] == "N/S"){
		 
		  $shift_desc = "Night";  
		   
	   }else{
		   
		   
	   }
		
      ?>
                <tr>
                <td width="30"><?php echo $no4; ?></td>
                <td width="100"><?php echo html_esc($row["purc_ord_no"]); ?></td>
                 <td width="100"><?php echo html_esc($row["dlv_ord_no"]); ?></td>
                <td width="100"><?php echo html_esc($row["R"]); ?></td>
                <td width="150"><?php echo html_esc($row["material_doc_gen"]); ?></td>
                <td width="80"><?php echo html_esc($row["vendor_id"]); ?></td>
                <td width="80"><?php echo html_esc($row["user_posting"]); ?></td>
                <td width="100"><?php echo $shift_desc; ?></td>
                 <td width="200">
                 <a href="detail_print_gd_receipt-ts.php?uid2=<?php echo base64_encode($row["material_doc_gen"]); ?>" target="_blank" class="btn btn-warning btn-sm"><img src="../images/print_new.png" width="16" height="16" alt="Print Tag">&nbsp;Print Tag</a>    
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
               
<!--Total <?php //echo $num_rows;?> Record : <?php //echo $num_pages;?> Page :
-->
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
	
	function getVendor(purc_ord_no) {		
		
		var strURL="findVendor-9.php?purc_ord_no="+purc_ord_no;
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