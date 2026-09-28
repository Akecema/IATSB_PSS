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

$query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
$result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
$res = mysqli_fetch_array($result2);

$url = "ppc_receiv-gd-rect.php"; 

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

<?php

//------generate Material Document No. for GR Generate.------------------
if($res["plant_code"] == '3100')
{
	$query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '122'";
	$result_id2 = mysqli_query($dbc,$query_id2);	
}
elseif($res["plant_code"] == '3101')
{
	$query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '123'";
	$result_id2 = mysqli_query($dbc,$query_id2);
}

if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "121";
	$dg2 = 0;

	if($row_id2["count_max"] <= 0)
	{ 
		$lastID2 = ($row_id2["count_max"] + 1);
		$dg2 = ($dht2 + ($lastID2));
	}
	else
	{
		$lastID2 = ($row_id2["count_max"] + 1);
		$dg2 =  $lastID2;	
	}
	
	$number2 = $dg2; // Length of running no
	$number2 = sprintf('%05d', $number2);  
	
	$ref3 = ($dht_OK2.$date_run.($number2));

} // end if $result_id2
	
?>

<?php 

//get purchase order
$purc_ord_no = base64_decode($_GET["purc_ord_no"]);
$do_no = base64_decode($_GET["do_no"]);
$DI_doc = base64_decode($_GET["DI_doc"]);

?>

<?php
if(isset($_POST['btn_submit']))
{
	
	
	
	if(isset($_POST['e_tcid']))
    {
	
	$trc_id = $_POST['e_tcid'];
	
	
	for($k=0; $k<count($trc_id); $k++)
	{
		/*$query = "INSERT INTO a_test_two(po_no,material_doc_gen,id_gr) VALUES ('$purc_ord_no','$ref3','".$_POST['e_tcid'][$k]."')";
		$result = mysqli_query($dbc,$query);*/
		
		//PO details
		$query_po_list = "SELECT * FROM po_detail WHERE id_gr = '".sql_esc($trc_id[$k])."'";
		$result_po_list = mysqli_query($dbc,$query_po_list);
		$row_po_list = mysqli_fetch_array($result_po_list);
		
		//----check material -----
		
		$query_mat_info = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($row_po_list["material_no"])."'";
		$result_mat_info = mysqli_query($dbc,$query_mat_info);
		$row_mat_info = mysqli_fetch_array($result_mat_info);


		$query_tag3 = "INSERT INTO po_detail_trans_gr
		(id,id_scan,id_DI,id_gen,scan_doc,doc_gen,back_no,plant_code,purc_ord_no,vendor_id,gr_chg,deleg_gr,item_no,material_no, 
			material_desc,size_gr,model_gr,matl_group,purc_group,material_type,work_center,sloc,doc_date,po_qty,ord_uom,yr_gr,user_create,date_create,user_update, 
			date_update,date_upload,status_po,user_posting,status_gr,material_doc_gen,date_post,time_post,ref_doc_gen,user_cancel,
			date_cancel,time_cancel,std_package,tbox_kanban,SAP_ref_doc,SAP_ref_doc_can) 
			VALUES('','".sql_esc($trc_id[$k])."','".sql_esc($row_po_list["id_gr"])."','".sql_esc($row_po_list["id_gr"])."','','".sql_esc($row_po_list["doc_gen"])."','".sql_esc($row_po_list["back_no"])."',
				'".sql_esc($row_po_list["plant_code"])."','".sql_esc($row_po_list["purc_ord_no"])."','".sql_esc($row_po_list["vendor_id"])."',
				'".sql_esc($row_po_list["gr_chg"])."','".sql_esc($row_po_list["deleg_gr"])."','".sql_esc($row_po_list["item_no"])."',
				'".sql_esc($row_po_list["material_no"])."','".sql_esc($row_po_list["material_desc"])."','".sql_esc($row_po_list["size_gr"])."',
				'".sql_esc($row_po_list["model_gr"])."','".sql_esc($row_po_list["matl_group"])."','".sql_esc($row_po_list["purc_group"])."','".sql_esc($row_po_list["material_type"])."','".sql_esc($row_po_list["work_center"])."',
				'".sql_esc($row_po_list["sloc"])."','".sql_esc($row_po_list["doc_date"])."','".sql_esc($row_po_list["po_qty"])."','".sql_esc($row_po_list["ord_uom"])."',
				'".sql_esc($row_po_list["yr_gr"])."','".sql_esc($row_po_list["user_create"])."','".sql_esc($row_po_list["date_create"])."','".sql_esc($username)."',
				NOW(),'".sql_esc($row_po_list["date_upload"])."','".sql_esc($rst_sta7["status_desc"])."','".sql_esc($username)."','".sql_esc($rst_sta3["status_desc"])."',
				'".sql_esc($ref3)."',NOW(),NOW(),'','','','','".sql_esc($row_mat_info["std_packaging"])."','".sql_esc($row_po_list["tbox_kanban"])."','','')";								
     $result_tag3 = mysqli_query($dbc,$query_tag3);


	}
	
	//update count_max----------------------------------------
	if($res["plant_code"] == '3100')
	{
		$query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '122'";
		$result_max_a = mysqli_query($dbc,$query_max_a);
	}
	elseif($res["plant_code"] == '3101')
	{
		$query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '123'";
		$result_max_b = mysqli_query($dbc,$query_max_b);
	}

	echo "<script>";
	echo "window.location='ppc_receiv-gd-rect-ist-new.php?purc_ord_no=$purc_ord_no&&matDoc=$ref3'"; 
	echo "</script>";
	exit(); //quit the script
	
	
  }
 else{
	 
	    
    echo '<script type="text/javascript">';
	echo "alert('Error! Transaction failed. Please select item.');";
	echo "window.location='ppc_receiv-gd-rect-ist3.php?purc_ord_no=$purc_ord_no';"; 
	echo "</script>";
	exit(); //quit the script
 	 
	 
	 
   }
}	
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

	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>-->
	
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

    <script language="javascript">
	$('.datepicker').pickadate({
	weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
	showMonthsShort: true
	})
		</script>
		<script language="javascript">
		  $(document).ready(function() {
				$('#example').DataTable( {
					"scrollX": true
				} );
		} );
	  </script>
      <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
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
          <li class="breadcrumb-item"><a href="ppc_receiv-gd-rect.php">Goods Receipt</a></li>
        </ul>
      </div>
      
  <div class="row">
    <div class="col-md-12">
      <div class="tile"><h3 class="tile-title">Goods Receipt </h3> <br/>
        <div class="row">
          <div class="col-lg-10">
          
            <!--<form name="frm-example" id="frm-example" method="post" action="ist-new.php?purc_ord_no=<?php echo $purc_ord_no; ?>">-->
			<form name="frm-example" id="frm-example" method="post" action="">
            
			<?php
			//-------Count all results------------------------//
	
						
			$where_sql = '';
					 
			//1. Purchase Order Number
			if ($purc_ord_no == ""){ 
			$wheresql_01 = ""; }
			else {
			$wheresql_01 = " AND po_no = '".sql_esc($purc_ord_no)."'"; } 
			
			//2. Delivery Order Number
			if ($do_no == ""){ 
			$wheresql_02 = ""; }
			else {
			$wheresql_02 = " AND do_no = '".sql_esc($do_no)."'"; } 
			
			//3. DI Number
			if ($DI_doc == ""){ 
			$wheresql_03 = ""; }
			else {
			$wheresql_03 = " AND DI_doc = '".sql_esc($DI_doc)."'"; } 
			
			$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03;	
			
			//********** END CONDITION **************
			$query_vend = "SELECT * FROM dlv_ord_dikanban_generate WHERE po_no = '".sql_esc($purc_ord_no)."' AND (status_kanban = '".sql_esc($rst_sta["status_desc"])."' or status_kanban = '".sql_esc($rst_sta7["status_desc"])."') ";
			$result_vend = mysqli_query($dbc,$query_vend);
			$row_vend = mysqli_fetch_array($result_vend);
			
			$query8 = "SELECT COUNT(*) FROM dlv_ord_dikanban_generate WHERE (status_kanban = '".sql_esc($rst_sta["status_desc"])."' OR status_kanban = '".sql_esc($rst_sta7["status_desc"])."' )" .$where_sql;
			$result8 = mysqli_query($dbc,$query8);
			$num_rows2 = mysqli_num_rows($result8);
			
			$queryD = "SELECT *, DATE_FORMAT(date_posting_do,'%d-%m-%Y') as R FROM dlv_ord_dikanban_generate WHERE  (status_kanban = '".sql_esc($rst_sta["status_desc"])."' OR status_kanban = '".sql_esc($rst_sta7["status_desc"])."') " .$where_sql." ORDER BY back_no ASC ";
			$rsD = mysqli_query($dbc,$queryD);
			
			$num_rows = mysqli_num_rows($rsD);   //how many material are there?
			
			if ($num_rows > 0) {
			
			?>
            
             <!--<table class="table table-hover table-bordered" id="exampleTable">-->
             <table class="table table-hover table-bordered" id="exampleTable">
                  <thead>
                    <tr>
                    <th>Item. <div align="center"><input type="checkbox" name="chkDel" class="selectall"/></div></th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    </tr>
                    </thead>
                    <tbody>	
                    
                    <?php
					$counter = 1;
					$no4 = 1;
					$msg = "";
					
					while($row = mysqli_fetch_array($rsD))
					{
						//calculate received qty dlm po_detail_trans_gr
						$query_info = "SELECT * FROM dlv_ord_dikanban_generate WHERE id = '".sql_esc($row["id"])."'";
						$result_info = mysqli_query($dbc,$query_info);
						$row_info = mysqli_fetch_array($result_info);
							
						$query_info2 = "SELECT * FROM po_detail_trans_gr WHERE purc_ord_no = '".sql_esc($row_info["purc_ord_no"])."' AND material_no ='".sql_esc($row_info["material_no"])."' 
											AND status_gr = '".sql_esc($rst_sta3["status_desc"])."'";
						$result_info2 = mysqli_query($dbc,$query_info2);
						
						$tot_gr_qty = 0.000;
					
						while($row_info2 = mysqli_fetch_array($result_info2)) 
						{
							$tot_gr_qty = $tot_gr_qty + $row_info2["gr_qty"];

					    }
					$msg = "<span class='badge badge-pill badge-danger'>Insufficient amount!</span>";
				  ?> 
                  <tr>
                    <td width="5%" align="center">
                    <input type="checkbox" id="checkbox" name="e_tcid[]" value="<?php echo html_esc($row["id_gr"]); ?>" class="form-check"><?php //echo $row["id_gr"]; ?></td>
                    <td><?php echo html_esc($row["material_no"]); ?></td>
                    <td><?php echo html_esc($row["material_desc"]); ?> &nbsp;&nbsp;<?php if(($tot_gr_qty) > $row_info["po_qty"]) { ?><div class="form-control-feedback" ><?php echo $msg; ?></div><?php } ?></td>
                  </tr>
                  <?php 
					  $no4++;
					  $counter++; // menambah counter 
				  } 
				  
					
				  ?>
                  <tbody>	
                </table>
               
            
          </div>
        </div>
        <div class="tile-footer">
           <input name="btn_submit" type="submit" id="btn_save" value="SELECT ITEM" class="btn btn-success btn-sm" >
           <a href="ppc_receiv-gd-rect.php" type="button" class="btn btn-warning btn-sm">BACK </a>
        </div>
        </form>
        <?php
		mysqli_free_result($rsD); 
		}   // free up the resources 
		else
		{
		?>
        <table width="800" cellspacing="0" class="textboxred">
            <tr> 
                <td><div align="center"><font color="#FF0000"><strong>There are currently no Goods Receipt record(s).</strong></font></div></td>
            </tr>
        </table>
        <?php } ?>
         
      </div>
    </div>
  </div>
  
  <div id="weather-temp">
  
  </div>
  
</main>



	<div class="nav">
    </div>
	
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Data table plugin-->
    <!--<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>-->
    <!--<script type="text/javascript">$('#exampleTable').DataTable();</script>-->
    
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <!--<script type="text/javascript" src="js/plugins/select2.min.js"></script>-->
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
	  
      $('#demoSelect').select2();
    </script>
    
    <!--checkbox-->
	<script type="text/javascript">
    $('.selectall').click(function() {
        if ($(this).is(':checked')) {
            $('div input').attr('checked', true);
        } else {
            $('div input').attr('checked', false);
        }
    });
    </script>
   <!--  <script>
	function validate_gr(){

		if (!document.getElementById('e_tcid').checked)
		{
			alert('Please select at least 1 item.');
			return false;
		}	
	}
	</script>-->
    <!--<script>
	$(document).ready(function () { 
		var oTable = $('#exampleTable').dataTable({
			stateSave: true
		});
	
		var allPages = oTable.fnGetNodes();
	
		$('body').on('click', '#selectAll', function () {
			if ($(this).hasClass('allChecked')) {
				$('input[type="checkbox"]', allPages).prop('checked', false);
			} else {
				$('input[type="checkbox"]', allPages).prop('checked', true);
			}
			$(this).toggleClass('allChecked');
			
		})
		
		
	});
	</script>-->
   
  

</body>
</html>