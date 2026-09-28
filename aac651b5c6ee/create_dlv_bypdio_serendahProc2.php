<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));
$fmt_curr_time = (date("H:i:s"));
$pick_curr_time = (date("H:i a"));
$yearSkrg = (date("Y"));

$drun = substr($fmt_curr_date,0,2);
$mrun = substr($fmt_curr_date,3,2);
$yrun = substr($fmt_curr_date,8,2);

$date_run = ($drun.$mrun.$yrun);

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "3")) {
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
	
    $url = "create_dlv_bypdio_serendah.php"; 

    //CR status (New)

$sta = "SELECT * from request_status WHERE status_id = '1'";
$sta_res = mysqli_query($dbc,$sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)  //CR status (New)
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

//CR status (Rejected)
$sta5 = "SELECT * from request_status WHERE status_id = '5'";
$sta_res5 = mysqli_query($dbc,$sta5);
$rst_sta5 = mysqli_fetch_array($sta_res5);

//CR status (Draft)
$sta6 = "SELECT * from request_status WHERE status_id = '6'";
$sta_res6 = mysqli_query($dbc,$sta6);
$rst_sta6 = mysqli_fetch_array($sta_res6);

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

	

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
          <h1><i class="fa fa-th-list"></i> Delivery</h1>
          <p>Create Delivery Order - Perodua</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Delivery</li>
          <li class="breadcrumb-item"><a href="create_dlv_bypdio_serendah.php">Create New</a></li>
        </ul>
      </div> 
        
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Create Delivery Order - Perodua </h3>
            <div class="tile-body">
              <div class="table-responsive">
       <?php

$so_no = $_GET["so_no"];
$pdio_no = $_GET["pdio_no"];
$scan_doc = $_GET["scan_doc"];
$ship_point = '3100';




      if(isset($_POST["submit4PDIO"]))  
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}
    
if(isset($_POST['e_tcid']))
{

$trc_id = $_POST["e_tcid"]; 
$st = count($trc_id);
$string = "";
$string = '';
$amount = '';

//------generate Material Document No. for GR Generate.---------------------------------


include 'gen_mat_doc_perodua.php';


foreach($_POST["e_tcid"] as $j=>$i) {
 
 $amount .= (($_POST["qty_dlv"][$i]).';');


//-----checking barcode GR Tag

$string = explode(";",($amount));	
  

  }


for($i=0; $i<$st; $i++)
{		

// echo ($i+1).'-'.$cancel[$i]; echo "</br>";


//update table upload_perodua_temp

$query_releas_v = "UPDATE upload_perodua_temp SET scan_gen = '".sql_esc($ref)."',qty_dlv = '".sql_esc($string[$i])."', user_update = '".sql_esc($username)."', date_update = NOW() WHERE id = '".sql_esc($trc_id[$i])."'";
  $result_releas_v = mysqli_query($dbc,$query_releas_v);


$query_all = "SELECT * FROM upload_perodua_temp WHERE id = '".sql_esc($trc_id[$i])."' ";
$result_all = mysqli_query($dbc,$query_all);
$data_all = mysqli_fetch_array($result_all);

 
//-------month & yrs
   $dy_do = substr($data_all["dlv_date"],8,2);
   $mth_do = substr($data_all["dlv_date"],5,2);
   $yrs_do = substr($data_all["dlv_date"],0,4);

 
//-------insert table prt_do_perodua_tag

$query_print_tag = "INSERT INTO prt_do_perodua_tag(id,tag_gen,scan_gen,material_doc_gen,id_do,so_no,ship_point,cust_code,pdio_no,material_no,material_desc,cust_mat_no,qty_dlv,uom_dlv,ship_from,ship_to,dlv_date,plant_code,month_do,year_do,posting_date,posting_time,prepared_by,status_part,created_by,date_create,status_tag) VALUES ('','".sql_esc($data_all["material_doc_gen"])."','".sql_esc($data_all["scan_gen"])."','".sql_esc($data_all["material_doc_gen"])."','".sql_esc($data_all["id"])."','".sql_esc($data_all["so_no"])."','".sql_esc($data_all["ship_point"])."','".sql_esc($data_all["cust_code"])."','".sql_esc($data_all["pdio_no"])."','".sql_esc($data_all["material_no"])."','".sql_esc($data_all["material_desc"])."','".sql_esc($data_all["cust_mat_no"])."','".sql_esc($data_all["qty_dlv"])."','".sql_esc($data_all["unit_soi"])."','".sql_esc($data_all["cust_code"])."','".sql_esc($data_all["ship_no"])."','".sql_esc($data_all["dlv_date"])."','".sql_esc($data_all["plant_code"])."','".sql_esc($mth_do)."','".sql_esc($yrs_do)."','".sql_esc($data_all["posting_date"])."','".sql_esc($data_all["posting_time"])."','".sql_esc($username)."','PERODUA','".sql_esc($username)."',NOW(),'Y')";
$rst_print_tag = mysqli_query($dbc,$query_print_tag);


}// end for loop


//update count_max----------------------------------------

  include 'gen_mat_doc_perodua_cls.php';


//end update count_max ---------------------------------	
$ref2 = base64_encode($ref);

echo "<script>";
echo "window.open('detail_print-delivery_order2serendah.php?suid=$ref2&&so_no=".html_esc($so_no)."&&pdio_no=".html_esc($pdio_no)."');";
echo "window.location='create_dlv_bypdio_serendah.php'";
echo "</script>";
exit(); //quit the script


}// end if





} // end submit




	
				
        //-------Count all results------------------------//
			
				 $where_sql = '';
		
							 	 
		  //1. Sales Order Number
                if ($so_no == ""){ 
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND so_no = '".sql_esc($so_no)."'"; } 
					
          //2. Pdio No
                if ($pdio_no == "" ){
                    $wheresql_02 = ""; }
                else {
					          $wheresql_02 = " AND pdio_no = '".sql_esc($pdio_no)."'"; }
   
		 
	                            
				
				$where_sql =  $wheresql_01 .$wheresql_02;	
	
	//********** END CONDITION **************
	
   $query8 = "SELECT COUNT(*) FROM upload_perodua_temp WHERE status_upload = '".sql_esc($rst_sta["status_desc"])."' AND scan_gen = '".sql_esc($scan_doc)."'  " .$where_sql;
   $result8 = mysqli_query($dbc,$query8);
   $num_rows = mysqli_num_rows($result8);
			

$query = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as R, DATE_FORMAT(dlv_date,'%d-%m-%Y') as R15, DATE_FORMAT(prod_date,'%d-%m-%Y') as R25 FROM upload_perodua_temp WHERE status_upload = '".sql_esc($rst_sta["status_desc"])."' AND scan_gen = '".sql_esc($scan_doc)."' AND plant_code = '3100'" .$where_sql." ORDER BY so_no ASC ";
$rs = mysqli_query($dbc,$query);
// var_dump($query);
$num_rows = mysqli_num_rows($rs);   //how many material are there?


		  
		 if ($num_rows > 0) {
			 
			 echo '<div align="center">There are currently '. $num_rows.' record(s).</div>'; 
	   
        
    	?>
        
     <form name="myform" method="post" action="">
               
                  <table class="table table-hover table-bordered" id="example">
                  <thead>
                    <tr> 
                    <th>All<input type="checkbox" id="selectAll"></th>
                    <th>Delete </th>
                   	<th>Item </th>
                    <th>Trip</th>
                    <th>Back No.</th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Production Date</th>
                    <th>Delivery Date</th>
                    <th>Delivery Qty</th>
                    <th>UoM</th>
                    <th>Kanban/PDIO No.</th>
                    <th>Delivery Category</th>
                    </tr>
                  </thead>
                  <tbody>	
 <?php
   $counter = 1;
   $no4 = 1;
   $i = 1;
  

   while($row = mysqli_fetch_array($rs))
   {
	   
    $no4 = sprintf('%04d',$no4); 
    
   $bal_qty_new = 0;
   $total_deli = 0;
   $tot_di_qty = 0;
	   //----calculate all delivery same sales order --------

	$query_all_soi = "SELECT * FROM dlv_ord_all_delivery WHERE (material_no = '".sql_esc($row['material_no'])."' OR material_no_sap = '".sql_esc($row['material_no'])."') AND pdio_no = '".sql_esc($row["pdio_no"])."' AND status_DO = '".sql_esc($rst_sta3["status_desc"])."' AND back_no = '".sql_esc($row["back_no"])."'";
	$result_all_soi = mysqli_query($dbc,$query_all_soi);
	
	while($row_all_soi = mysqli_fetch_array($result_all_soi))
	{

    $tot_di_qty = $tot_di_qty + $row_all_soi["qty_dlv"];     
    $bal_qty_new = (($row_all_soi["qty_order"]) - ($tot_di_qty)); 

  }
     
	//-----calculate balance qty -------
     
    // echo 'Bal :'.$bal_qty_new; echo '<br>';     echo 'total qty :'.$tot_di_qty; echo '<br>';
	  
  ?>   
                <tr>
                <td width="30"><div align="center">                
          <input type="checkbox" id="checkbox" name="e_tcid[]" value="<?php echo html_esc($row["id"]); ?>" class="form-check" >       
         </div><!-- <input type="text" value="true" id="check2[<?php echo html_esc($row["id"]); ?>]" hidden></td> -->
          <td width="60"><div align="center"><a href="delete_pdiosgchoh_item.php?scan_doc=<?php echo html_esc($row["scan_gen"]); ?>&&p_id=<?php echo html_esc($row["id"]); ?>&&pdio_no=<?php echo html_esc($row["pdio_no"]); ?>&&so_no=<?php echo html_esc($row["so_no"]); ?>" onclick="return confirm('Are you sure you want to delete?')"><img src="../images/delete.png" alt="Remove Item"></a></div></td>
                <!-- #endregion --> <td width="30"><div align="center"><?php echo $no4; ?> </div></td>
                 <td width="100"><?php echo html_esc($row["trip_no"]); ?></td>
                 <td width="100"><?php echo html_esc($row["back_no"]); ?></td>
                 <td width="150"><?php echo html_esc($row["material_no"]); ?></td>
                 <td width="124" height="28"><?php echo html_esc($row["material_desc"]); ?></td>
                 <td width="120"><?php echo html_esc($row["R25"]); ?></td>
                 <td width="120"><?php echo html_esc($row["R15"]); ?></td>
                <td width="150"><!-- <input type="text" value="" id="check" hidden> -->
                <input name="qty_dlv[<?php echo html_esc($row["id"]); ?>]" id="qty_dlv[<?php echo html_esc($row["id"]); ?>]" type="number" value="<?php if (isset($_POST['qty_dlv'])) {
																																																									echo html_esc($_POST["qty_dlv"][($row["id"])]);
																																																								} else {
																																																									if ($bal_qty_new < 0.000) {
																																																										echo "0";
																																																									}elseif ($bal_qty_new == 0.000) {

																																																										echo intval($row["qty_order"]);
																																																									}                                                                                                                 
                                                                                                                  else {
																																																										echo intval($bal_qty_new);
																																																									}
																																																								} ?>" class="form-control form-control-sm"  required />  
                
                
                
              </td>
               
                
                <td width="50"><?php echo html_esc($row["unit_soi"]); ?></td>
                <td width="150"><?php echo html_esc($row["pdio_no"]); ?></td>
                <td width="150"><?php echo html_esc($row["dlv_cat"]); ?></td>
              
              
               </tr>

  <?php 
		 
		  $no4++;
		  $counter++; // menambah counter 
		   
		   
	
		   //}// end if
		
		    
		  } ?>
          
          </tbody>
          </table>
          </table><table class="table">
  <tr>
    <td>&nbsp;
               <input name="so_no" type="hidden" value="<?php echo html_esc($so_no); ?>">             
               <input name="pdio_no" type="hidden" value="<?php echo html_esc($pdio_no); ?>">  
               <input name="ship_point" type="hidden" value="3100">
               <input name="scan_doc" type="hidden" value="<?php echo html_esc($scan_doc); ?>">  
               <input name="submit4PDIO" type="submit" id="submit4PDIO" value="CREATE DO" class="btn btn-success btn-sm">
         
             <!--   <button type="button" name="btn_genDO" id="btn_genDO" class="btn btn-success btn-sm">CREATE DO</button> -->
              
            </td>
  </tr>
</table>
 </form>

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
        <?php
		   } 
//mysqli_close($dbc)
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
	  
      $('#demoSelect').select2();
    </script>
   
  
    <script>
$(document).ready(function () { 
    var oTable = $('#example').dataTable({
       // stateSave: true,
        "scrollX": true,
					"lengthMenu": [[ -1], [ "All"]]
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
</script>
    <script>
//Submit Generate GR
//Status changed to submitted
//https://www.youtube.com/watch?v=fGS-Ff3wgXw
//https://stackoverflow.com/questions/29896599/how-can-i-select-all-checkboxes-from-all-the-pages-in-a-jquery-datatable
$(document).on("click", "#submit4PDIO", function(event) {  

$('#example').DataTable();  

	if (confirm('Are you sure to Create DO?'))
	{
		var e_tcid = new Array();

		var oTable = $('#example').dataTable();  
		var rowcollection =  oTable.$("#checkbox:checked", {"page": "all"});  
		
		rowcollection.each(function(index,elem) {  
			e_tcid.push($(elem).val());
			
		});    
					

		if(e_tcid.length == 0)
		//if($('input.styled').not(':checked').length > 0) 
		{
			alert('Please select a list item.');
		}
	
		
	}
	else
	{
		return false;
	}

});

</script>


  </body>
</html>