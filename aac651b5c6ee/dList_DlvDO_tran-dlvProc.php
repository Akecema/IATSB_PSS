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
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
    $url = "detail_do_alldoc-dlv.php";
	
//--------menu function ------------------------------

$query_function = new PreparedSql("SELECT * FROM function_acc_detail WHERE staff_ID = ?", [$res["staff_ID"]]);
$result_function = db_query($dbc, $query_function);   //run the query.
$data_function = mysqli_fetch_array($result_function);   //how many records are there?  
//----------------------------------------------------
    
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

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc,$sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

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

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

//CR status (Transfer Material)
$sta28 = "SELECT * from request_status WHERE status_id = '28'";
$sta_res28 = mysqli_query($dbc,$sta28);
$rst_sta28 = mysqli_fetch_array($sta_res28);

//CR status (Return)
$sta30 = "SELECT * from request_status WHERE status_id = '30'";
$sta_res30 = mysqli_query($dbc,$sta30);
$rst_sta30 = mysqli_fetch_array($sta_res30);

//CR status (Return Delivery)
$sta31 = "SELECT * from request_status WHERE status_id = '31'";
$sta_res31 = mysqli_query($dbc,$sta31);
$rst_sta31 = mysqli_fetch_array($sta_res31);

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
        width: 1400px;
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
          <p>DI/PDIO</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Report</li>
          <li class="breadcrumb-item"><a href="detail_do_alldoc-dlv.php">DI/PDIO</a></li>
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
        	$ship_to = $_GET["ship_to"]; 
			$do_no = $_GET["do_no"]; 
			
		    $trans_type = $_GET["trans_type"]; 
		    $material_no = $_GET["material_no"]; 
			$model_code = $_GET["model_code"]; 
			
			
			
		
		  ?>    
              
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
              <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="3">&nbsp;</th>
            </tr> 
            <tr>
                <th>DI/PDIO Number : </th>
                <th colspan="3">
           <input class="form-control" id="do_no" type="text" placeholder="Enter DI/PDIO Number" name="do_no" value="<?php  echo html_esc($_GET['do_no']); ?>" />    
          <!--<div class="form-control-feedback" ><?php //echo $message_do; ?></div>-->
               </th>
              </tr>
             <tr>
                <th>Delivery Date from : <font color="#FF0000">*</font></th>
                <td colspan="3"><input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php  echo html_esc($_GET['date1']); ?>" /> 
                    </td></tr>
                 <tr>
                <th>Delivery Date to : <font color="#FF0000">*</font></th>
                <td colspan="3"><input class="form-control" id="PSSDate2" type="text" placeholder="Select Date" name="date2" value="<?php  echo html_esc($_GET['date2']); ?>" /></td>
              </tr>
               
            <th>Ship to Party :</th>
            <td colspan="3">
           <select id="ship_to" name="ship_to" class="form-control" >
                      <option value="NULL" placeholder="Select Ship to Party"> -- Select Ship to Party -- </option>
                      <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM cust_detail WHERE status_cust = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
                      <option value="<?php echo html_esc($row27["id_cust"]); ?>"  <?php if($row27["id_cust"]==$_GET["ship_to"]) echo "selected"; ?>> <?php echo stripslashes($row27["id_cust"]); ?> - <?php echo html_esc($row27["cust_desc"]); ?></option>
                      <?php
           }  ?>
                    </select>
		     </td>
             </tr>
               <tr>
                <th>Document Type :</th>
                <td colspan="3"> <select name="trans_type" id="trans_type" class="form-control">
              <option value="NULL" placeholder="Select Document Type"> -- Select Document Type --</option>
              <option value="type1"  <?php if($_GET["trans_type"] == 'type1') { ?> selected="selected"<?php } ?>>NORMAL</option>
              <option value="type3" <?php if($_GET["trans_type"] == 'type3') { ?> selected="selected"<?php } ?>>CANCEL</option>
              </select>  </td>
              </tr> 
              <tr>
                <th>Model : </th>
                <th colspan="3">
             <?php    
                $query49 = "SELECT * FROM model_detail_tbl WHERE status_model = 'Y' GROUP BY model_code ORDER BY id_model ASC";
                $result49 = mysqli_query($dbc,$query49);

             ?>
                <select name="model_code" id="model_code" class="form-control">
              <option value="NULL" placeholder="Select Model"> -- Select Model --</option>
          
				<?php
              while($row49=mysqli_fetch_array($result49)) 
                {
            ?>
                                   <!--RETAIN VALUE-->
         <option value="<?php echo html_esc($row49["model_code"]);  ?>" <?php if($row49["model_code"]==$_GET["model_code"]) echo "selected"; ?>> <?php echo html_esc($row49["model_code"]); ?> - <?php echo html_esc($row49["model_desc"]); ?></option>
                                 
                
                <?php     }
                
                ?>
            </select>
    
               </th>
              </tr>
                <tr>
                <th>Part Number : </th>
                <th colspan="3">
             <?php    
                $query39 = "SELECT * FROM mat_master_header WHERE status_BOM = 'Y' ORDER BY id_hdr ASC";
                $result39 = mysqli_query($dbc,$query39);

             ?>
                <select name="material_no" id="material_no" class="form-control">
              <option value="NULL" placeholder="Select Part Number"> -- Select Part Number --</option>
          
				<?php
              while($row39=mysqli_fetch_array($result39)) 
                {
                ?>
                                   <!--RETAIN VALUE-->
          <option value="<?php echo html_esc($row39["material_no"]);  ?>" <?php if($row39["material_no"]==$_GET["material_no"]) echo "selected"; ?>> <?php echo html_esc($row39["material_no"]); ?> - <?php echo html_esc($row39["material_desc"]); ?></option>
                               
                
                <?php     }
                
                ?>
            </select>
    
               </th>
              </tr>
               
              <tr>
                <th><input name="Submit22" type="submit" class="btn btn-info" id="button" value="SEARCH" /></th>
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
				 
	       //1. do_no
                if ($do_no == ""){ 
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND pdio_no = '".sql_esc($do_no)."'"; }  
					
		  //2. ship to party
                if (($ship_to == "") || ($ship_to == "NULL")){ 
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND ship_no = '".sql_esc($ship_to)."'"; }  	
						
					
		   // 3. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND (DATE(dlv_date) >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (DATE(dlv_date) <= '".sql_esc($date2_final)."')"; }
					
		//5. Material No
                if ($material_no == "NULL" ){
                    $wheresql_05 = ""; }
                else {
					$wheresql_05 = " AND (material_no = '".sql_esc($material_no)."')"; }
					
					
		  //6. model_code
                if ($model_code == "NULL" ){
                    $wheresql_06 = ""; }
                else {
					$wheresql_06 = " AND (sales_org = '".sql_esc($model_code)."')"; }
					
						
		   //8. Transfer Type
                if(($trans_type == "NORMAL") || ($trans_type == "NULL" )){
                    $wheresql_08 = ""; 
               }elseif($trans_type == "CANCEL" ){
					$wheresql_08 = " AND (status_DO = '".sql_esc($rst_sta3['status_desc'])."')"; 
				}else{
				
				}
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05 .$wheresql_06 .$wheresql_08;
	
	//********** END CONDITION **************
	
		  
 			
			
   $query8GR = "SELECT COUNT(*) FROM dlv_ord_all_delivery WHERE material_doc_gen != ''" .$where_sql ." GROUP BY material_doc_gen ORDER BY material_doc_gen ASC ";
   $result8GR = mysqli_query($dbc,$query8GR);
   $num_rowsGR = mysqli_num_rows($result8GR);
			
  
$queryGR = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as R, DATE_FORMAT(dlv_date,'%d-%m-%Y') as R7, DATE_FORMAT(date_cancel,'%d-%m-%Y') as R27 FROM dlv_ord_all_delivery WHERE material_doc_gen != '' " .$where_sql." GROUP BY material_doc_gen ORDER BY material_doc_gen ASC ";
$rsGR = mysqli_query($dbc,$queryGR);
$num_rowsGR = mysqli_num_rows($rsGR);   //how many material are there?
    
		  
		 if ($num_rowsGR > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rowsGR.' record(s).</div>'; 
	   
        
    	?> <table class="table">
<tr>
    <td width="1%">&nbsp;</td> 
    <td width="85%">&nbsp;</td> 
      <td width="7%"><a href="rpt_dList_DlvDO_dlv_download.php?do_no=<?php echo html_esc($do_no); ?>&&ship_to=<?php echo html_esc($ship_to); ?>&&material_no=<?php echo html_esc($material_no); ?>&&model_code=<?php echo html_esc($model_code); ?>&&trans_type=<?php echo html_esc($trans_type); ?>&&date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>" ><img src="../images/dload_excel.jpg" width="48" height="48" title="Download" /></a></td>
     <td width="7%"><!--<img src="../images/print2.jpg" width="48" height="48" onClick="window.print()" title="Print"/>--></td>
   
  </tr>
</table> 
      
                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>PSS DO Number</th>
                    <th>DI/PDIO Number</th>  
                    <th>Delivery Date</th>
                    <th>Ship To Code</th>
                    <th>Shift</th>
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
   
   while($row = mysqli_fetch_array($rsGR))
   {
	   
	   
	   if($row["cycle_no"] == "D/S")
	   {
		   $shift_N = "Day";
	   }elseif($row["cycle_no"] == "N/S")
	  {
		   $shift_N = "Night";
	  }else{
		   
		   $shift_N = "None";
		   
	  }
	   
      ?>
                <tr>
                <td width="150"><?php echo html_esc($row["material_doc_gen"]); ?></td>
                <td width="150"><?php echo html_esc($row["pdio_no"]); ?></td>
                <td width="100"><?php echo html_esc($row["R7"]); ?></td> 
                <td width="80"><?php echo html_esc($row["ship_no"]); ?></td>
                <td width="60"><?php echo  $shift_N; ?></td>
                <td width="100"><?php echo html_esc($row["ref_material_doc"]); ?></td>
                <td width="100"><?php if($row["date_cancel"] != '0000-00-00 00:00:00') { echo html_esc($row["R27"]); }else{ }  ?></td>  
                <td width="100">
                <!-- <a href="#myNoteDisplayDO<?php echo html_esc($row["material_doc_gen"]); ?><?php echo html_esc($row["ship_point"]); ?>" data-toggle="modal" target="_parent"><i class="fa fa-search" aria-hidden="true"></i>View</a>  -->
                <a href="#" class="myNoteDisplayDO" data-id="<?php echo html_esc($row['material_doc_gen']); ?>" data-ship_point="<?php echo html_esc($row["ship_point"]); ?>" data-toggle="modal" target="_parent">
                  <i class="fa fa-search" aria-hidden="true"></i> View
                </a>
                    <!--------------------------modal------------------------->
                
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
   mysqli_free_result($rsGR); 
   
 
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
    <div class="modal fade printable autoprint" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content custom">
              <div class="modal-header">
                  <h5 class="modal-title" id="myModalLabel">PSS Delivery Order</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body" id="modalContent">
                  <!-- AJAX content will be loaded here -->
              </div>
          </div>
      </div>
    </div>
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
      $(document).ready(function() {
        $('#example').on('click', '.myNoteDisplayDO', function() {
            $('#modalContent').empty();
            var material_doc_gen = $(this).data('id'); // Get the ID from the clicked link
            var ship_point = $(this).data('ship_point'); // Get the Ship Point from the clicked link
            var date1 = $('#PSSDate').val();
            var date2 = $('#PSSDate2').val();
            var ship_to = $('#ship_to').val();
            var do_no = $('#do_no').val();
            var trans_type = $('#trans_type').val();
            var model_code = $('#model_code').val();
            var material_no = $('#material_no').val();
            // console.log(material_doc_gen);
            // console.log(date1);
            // console.log(date2);
            // console.log(plant_code);
            $.ajax({
              url: 'display_dlvdo_alldo_dlv.php', 
              type: 'POST',
              data: {
                  material_doc_gen: material_doc_gen,
                  ship_point: ship_point,
                  date1: date1,
                  date2: date2,
                  ship_to: ship_to,
                  do_no: do_no,
                  trans_type: trans_type,
                  model_code: model_code,
                  material_no: material_no,
                  cache_bust: new Date().getTime()
              },
              success: function(response) {
                // console.log(response);
                // Load the response into the modal body
                $('#modalContent').html(response);
                $('#myModal').modal('show'); // Show the modal
              },
              error: function(xhr, status, error) {
                console.log("Error: ", error);
                console.log("Status: ", status);
                console.log("Response: ", xhr.responseText);
              }
            });
        });
      });
    </script>
    
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
	  
	   $('#PSSDate3').datepicker({
		defaultDate: new Date(),   
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      $('#demoSelect').select2();
    </script>
   
  </body>
</html>