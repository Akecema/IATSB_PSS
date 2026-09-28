<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

$query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
$result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
$res = mysqli_fetch_array($result2);

set_time_limit(0);

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

$drun = substr($fmt_curr_date,0,2);
$mrun = substr($fmt_curr_date,3,2);
$yrun = substr($fmt_curr_date,8,2);

$date_run = ($drun.$mrun.$yrun);


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

$url = "ppc_receiv-gd-rect.php"; 

?>

<?php 

//get purchase order
$purc_ord_no = $_GET["purc_ord_no"];

//get mat generate no
$matDoc = $_GET['matDoc'];


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

//Vendor
$query_vend = "SELECT * FROM po_detail WHERE purc_ord_no = '".sql_esc($purc_ord_no)."' AND (status_po = '".sql_esc($rst_sta["status_desc"])."' OR status_po = '".sql_esc($rst_sta7["status_desc"])."') ";
$result_vend = mysqli_query($dbc,$query_vend);
$row_vend = mysqli_fetch_array($result_vend);

//-------check vendor detail ----------

				  $query5a = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ?", [$row_vend["vendor_id"]]);
				  $result5a = db_query($dbc, $query5a);
			      $row5a = mysqli_fetch_array($result5a);

?>

    
<!DOCTYPE html>
<html>
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

   <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>-->
    
      <script language="javascript">
	$('.datepicker').pickadate({
	weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
	showMonthsShort: true
	})
		</script>
		
     <script language="javascript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>

	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>-->
	
    <style>
	 div.dataTables_wrapper {
        width: 1300px;
        margin: 0 auto;
    }

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
          <h1><i class="fa fa-file-text-o"></i> Receiving</h1>
          <p>Goods Receipt</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Receiving</li>
          <li class="breadcrumb-item"><a href="ppc_receiv-gd-rect_po.php">Goods Receipt</a></li>
        </ul>
      </div>
      
  <div class="row">
    <div class="col-md-12">
      <div class="tile"><h3 class="tile-title">Goods Receipt </h3> <br/>
        <div class="tile-body">
              <div class="table-responsive">
 
           <!-- <form name="frm-example" id="frm-example" method="post" action="ist-new0.php?purc_ord_no=<?php echo html_esc($purc_ord_no); ?>">-->
            <form  method="post" action="ppc_receiv-gd-rect-ist-newist-new0po.php?purc_ord_no=<?php echo html_esc($purc_ord_no); ?>&&matDoc=<?php echo html_esc($matDoc); ?>">

             
            <table class="table table-bordered">
            <tr>
                <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
                <th width="69%" colspan="2">&nbsp;</th>
            </tr>
            <tr>
                <th>Vendor :</th>
                <th colspan="2"><input class="form-control" id="vendor_id" type="text" name="vendor_id" readonly value="<?php echo html_esc($row_vend["vendor_id"]). ' - ' .html_esc($row5a["vendor_name"]); ?>"/></th>
            </tr>
            <tr>
                <th>Delivery Order No. : <font color="#FF0000">*</font></th>
                <td colspan="2">
                <input class="form-control" id="dlv_ord_no" type="text" placeholder="Enter Delivery Order No." name="dlv_ord_no"  value="<?php if(isset($_POST["dlv_ord_no"])) { echo html_esc($_POST["dlv_ord_no"]); } ?>"/> 
            	</td>
            </tr>
            <tr>
            	<th>Posting Date : </th>
            	<td colspan="2"><input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="PSSDate" value="<?php if(isset($_POST['PSSDate'])){ echo html_esc($_POST['PSSDate']); }else{ echo $fmt_curr_date; } ?>"></td>
            </tr>
            <tr>
            <th>Shift :</th>
            	<td><div class="form-check"><input class="form-check-input" id="shift_ops" type="radio" name="shift_ops" value="D/S" checked>Day</div></td>
            	<td><div class="form-check"><input class="form-check-input" id="shift_ops" type="radio" name="shift_ops" value="N/S">Night</div></td>
            </tr>
            </table>
              
            <p>&nbsp; </p>  
             <table class="table table-hover table-bordered" id="example">
              <thead>
                <tr>
                <th>No</th>
                <th>Part Number</th>
                <th>Part Name</th>
                <th>Order Qty</th>
                <th>Received Qty</th>
                <th>Balance Qty</th>
                <th>GR Qty</th>
                <th>UoM</th>
                <th>SLoc</th>
                <th>Standard Package</th>
                </tr>
                </thead>
                 <tbody>	
				<?php
				
				$counter = 1;
				
                //foreach ($trc_id as $item) {
            
                $query_st = "SELECT * FROM po_detail_trans_gr  WHERE material_doc_gen = '".sql_esc($matDoc)."' ";
                $result_st = mysqli_query($dbc,$query_st);
                //$row_st = mysqli_fetch_array($result_st);
				
            
                ?>

                    <?php
					
					$no4 = 1;
					
					while($row = mysqli_fetch_array($result_st))
					{
						//calculate received qty dlm po_detail_trans_gr
						$query_info = "SELECT * FROM po_detail WHERE id_gr = '".sql_esc($row["id_DI"])."'";
						$result_info = mysqli_query($dbc,$query_info);
						$row_info = mysqli_fetch_array($result_info);
							
						$query_info2 = "SELECT * FROM po_detail_trans_gr WHERE purc_ord_no = '".sql_esc($row_info["purc_ord_no"])."' AND material_no ='".sql_esc($row_info["material_no"])."' 
											AND status_gr = '".sql_esc($rst_sta3["status_desc"])."'";
						$result_info2 = mysqli_query($dbc,$query_info2);
						
						$tot_gr_qty = 0.000;
						$bal_gr_qty = 0.000;
					
						while($row_info2 = mysqli_fetch_array($result_info2)) 
						{
							$tot_gr_qty = $tot_gr_qty + $row_info2["gr_qty"];
							$bal_gr_qty = (($row_info["po_qty"]) - ($tot_gr_qty));
							
						}				
				  ?> 
                 
                    <tr>
                    <td width="50"><?php echo $counter; ?>.<?php //echo $row["id_gr"]; ?>
                    <input type="checkbox" id="checkbox" name="e_grid[]" value="<?php echo html_esc($row["id"]); ?>" style="display:none" checked></td>
                    <td width="150"><?php echo html_esc($row_info["material_no"]); ?></td>
                    <td width="350"><?php echo html_esc($row_info["material_desc"]); ?></td>
                    <td width="100"><?php echo html_esc($row_info["po_qty"]); ?></td>
                    <td width="100"><?php echo $tot_gr_qty; ?></td>
                    <td width="100"><?php echo number_format((float)$bal_gr_qty, 3, '.', ''); ?></td>
                    <td width="200"><input name="gr_qty[]" id="gr_qty"  type="number" class="form-control form-control-sm" step="0.001" min="0.001"></td>
                    <td width="100"><?php echo html_esc($row_info["ord_uom"]); ?></td>
                    <td width="200"><input name="sloc_gr[]" type="text" value="<?php echo html_esc($row_info["sloc"]); ?>" id="sloc_gr" class="form-control form-control-sm"></td>
                    <td width="200"><input name="std_package[]" type="text" value="<?php echo html_esc($row["std_package"]); ?>" id="std_package" class="form-control form-control-sm" required></td>
                  </tr>
					<?php 
						$no4++;
						$counter++; // menambah counter 
                    } //end while
                    ?>
                    
                    <?php	
					
                    //}//for loop
                    ?>
                  </tbody>	
                </table>
                
           <?php //}//end submit ?>
           
        
        <div class="tile-footer">
            <a href="ppc_receiv-gd-rect_po-ist3.php?purc_ord_no=<?php echo html_esc($purc_ord_no); ?>" type="button" class="btn btn-warning btn-sm">BACK </a>
            <button class="btn btn-primary btn-sm" name="submitgr" onClick="return addGr()">SUBMIT</button>
        </div>
        </form>
           </div>
        </div>
     </div> 
    </div>
  </div>
  
</main>


	
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
  <!--  <script type="text/javascript">$('#example').DataTable();</script>-->
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <!--<script type="text/javascript" src="js/plugins/select2.min.js"></script>-->
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
    <script language="javascript">
		  $(document).ready(function() {
				$('#example').DataTable( {
					"scrollX": true,
					"lengthMenu": [[ -1], [ "All"]]
				} );
		} );
	  </script>
 
	<script>
    /*validate meeting details */
    function addGr(){
    
        var dlv_no = $("#dlv_ord_no").val();
		var pos_dt = $("#PSSDate").val();
		
        if (confirm('Post GR transaction?')){
        
            if(dlv_no == '' )
			{
				alert('Delivery Order No is required.');			
				document.getElementById('dlv_ord_no').focus();
				document.getElementById('dlv_ord_no').style.borderColor = "#D41F3A";
				return false;
			}
			else if(pos_dt == '' )
			{
				alert('Posting Date is required.');
				document.getElementById('PSSDate').focus();
				document.getElementById('PSSDate').style.borderColor = "#D41F3A";
				return false;
			}
			
			var grQty = document.getElementsByName('gr_qty[]');
			var grSloc = document.getElementsByName('sloc_gr[]');
			 
			for (m = 0; m < grQty.length; m++)
			{
				if (grQty[m].value == '')
				{
					alert('GR quantity is required.');
					grQty[m].focus();
					grQty[m].style.borderColor = "#D41F3A";			 
					return false;
				}
				else if (grQty[m].value != '' && (grQty[m].value <= 0))
				{
					alert('Invalid GR quantity. GR quantity must be greater than 1.');
					grQty[m].focus();
					grQty[m].style.borderColor = "#FF3300";			 
					return false;
				}
				else if (grSloc[m].value == '')
				{
					alert('SLoc quantity is required.');
					grSloc[m].focus();
					grSloc[m].style.borderColor = "#D41F3A";			 
					return false;
				}
			}
			
			
			
        }
        else
        {
         	return false;
        }	
    }
    </script>

    
</body>
</html>