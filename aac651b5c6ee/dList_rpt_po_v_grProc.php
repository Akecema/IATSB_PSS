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
	
    $url = "list_rpt_po_v_gr.php";
	
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script> 
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
   
     
   
   <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    
  <style>
div.dataTables_wrapper {
        width: 1000px;
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
        <h1><i class="fa fa-truck"></i> Delivery Instruction</h1>
          <p>PO vs GR (Quantity)</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Delivery Instruction</li>
          <li class="breadcrumb-item"><a href="list_rpt_po_v_gr.php">PO VS GR (Quantity)</a></li>
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
        $plant_code = $_GET["plant_code"]; 
			  $vendor_no = $_GET["vendor_no"]; 
	
			
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
            <th>Vendor : <font color="#FF0000">*</font></th>
            <td colspan="3">
             <select name="vendor_no" class="form-control" >
             <option value="NULL" placeholder="Select Vendor"> -- Select Vendor -- </option>
               <?php
					  
			//------------- select get login vendor --------------
		$query_ath_vend = "SELECT * FROM vendor_detail WHERE status_acc = 'Y'";
		$result_ath_vend = mysqli_query($dbc,$query_ath_vend);
	
          
              while($data_ath_vend = mysqli_fetch_array($result_ath_vend)) {
				 
				  
        
              ?>
                      <option value="<?php echo html_esc($data_ath_vend["vendor_code"]); ?>" <?php if($data_ath_vend["vendor_code"] == $_GET["vendor_no"]) echo "selected"; ?> > <?php echo stripslashes($data_ath_vend["vendor_code"]); ?> - <?php echo html_esc($data_ath_vend["vendor_name"]); ?></option>
                      <?php
           }  ?>    
				  
                </select>
		     </td>
             </tr>
              <tr>
                <th>Document Date from :</th>
                <td colspan="3">
        <?php
			   $dd1 = substr($_GET["date1"],8,2);
				 $mm1 = substr($_GET["date1"],5,2);
				 $yy1 = substr($_GET["date1"],0,4);
			?>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" >
                  
                    </td></tr>
                 <tr>
                <th>Document Date to :</th>
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
					
		  //5. Vendor Code
                if (($vendor_no == "NULL")){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND vendor_id = '".sql_esc($vendor_no)."'"; }  	
							

				$where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04 .$wheresql_05;
	
	//********** END CONDITION **************
	
		  
 			
			
   $query8GR = "SELECT COUNT(*) FROM po_detail WHERE (status_po = '".sql_esc($rst_sta["status_desc"])."' OR status_po = '".sql_esc($rst_sta7["status_desc"])."' OR status_po != '".sql_esc($rst_sta4["status_desc"])."' ) " .$where_sql ." GROUP BY material_no, purc_ord_no ORDER BY purc_ord_no ASC ";
   $result8GR = mysqli_query($dbc,$query8GR);
   $num_rowsGR = mysqli_num_rows($result8GR);
			
  
$queryGR = "SELECT *, DATE_FORMAT(doc_date,'%d-%m-%Y') as R FROM po_detail WHERE (status_po = '".sql_esc($rst_sta["status_desc"])."' OR status_po = '".sql_esc($rst_sta7["status_desc"])."' OR status_po != '".sql_esc($rst_sta4["status_desc"])."')  " .$where_sql." GROUP BY material_no, purc_ord_no ORDER BY purc_ord_no ASC ";
$rsGR = mysqli_query($dbc,$queryGR);
$num_rowsGR = mysqli_num_rows($rsGR);   //how many material are there?
    
		  
		 if ($num_rowsGR > 0) {
			 
      echo '<div align="center">There are currently  '. $num_rowsGR.' record(s).</div>'; 
        
    	?> 
            <table class="table">
            <tr>
                <td width="1%">&nbsp;</td> 
                <td width="85%">&nbsp;</td> 
                  <td width="7%"><a href="rpt_dList_rpt_po_v_gr_download.php?plant_code=<?php echo html_esc($plant_code); ?>&&date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&vendor_no=<?php echo html_esc($vendor_no); ?>" ><img src="../images/dload_excel.jpg" width="48" height="48" title="Download" /></a></td>
                 <td width="7%"><!--<img src="../images/print2.jpg" width="48" height="48" onClick="window.print()" title="Print"/>--></td>
               
              </tr>
            </table> 
    
                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>No</th>
                    <th>Vendor</th>
                    <th>PO No.</th>
                    <th>Part No.</th>
                    <th>Part Name</th>
                    <th>Model</th>
                    <th>PO Quantity</th>
                    <th>GR Quantity</th>
                    <th>Balance</th>
                    <th>Unit</th>
                </tr>
              </thead>    
              <tbody>
           <?php 

   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   $no4A = 1;
   
   while($row = mysqli_fetch_array($rsGR))
   {

  


     //----- vendor detail -----------//
    $query_vend_info = "SELECT * FROM vendor_detail WHERE vendor_code ='".sql_esc($row['vendor_id'])."' AND status_acc = 'Y'";
    $result_vend_info = mysqli_query($dbc,$query_vend_info) or die (mysqli_error($dbc));
    $row_vend_info = mysqli_fetch_array($result_vend_info);

//--------- Checking delivery order whether it has been fully received or not.-----------	 
$tot_gr_qtyB = 0.000;
$tot_rec_qtyA = 0.000;
$tot_grd_qtyA  = 0.000;	
$Grd_total_new_bal = 0.000;
$tot_gr_qtyC = 0.000;

$query_check_Trcv = "SELECT * FROM dlv_ord_dikanban_generate WHERE po_no = '".sql_esc($row['purc_ord_no'])."' AND  status_DO = '".sql_esc($rst_sta14["status_desc"])."' AND material_no = '".sql_esc($row["material_no"])."'";
$result_check_Trcv = mysqli_query($dbc,$query_check_Trcv);
  
while($data_check_Trcv = mysqli_fetch_array($result_check_Trcv))
{


$tot_grd_qtyA = $tot_grd_qtyA + $data_check_Trcv["qty_dlv"];

}



//dlv_ord_dikanban_generate
//--------------Update 7 April 2022-------		 
  $query_check_Prcv = "SELECT * FROM po_detail_trans_gr WHERE purc_ord_no = '".sql_esc($row['purc_ord_no'])."' AND status_gr = '".sql_esc($rst_sta3["status_desc"])."' AND material_no = '".sql_esc($row["material_no"])."'";
$result_check_Prcv = mysqli_query($dbc,$query_check_Prcv);
  
while($data_check_Prcv = mysqli_fetch_array($result_check_Prcv))
{
  
  
  $tot_gr_qtyB = $tot_gr_qtyB + $data_check_Prcv["gr_qty"];
  
    
  
}

//-------`po_detail`
//--------------Update 3 August 2023-------		 
$query_check_Pftp = "SELECT * FROM po_detail WHERE purc_ord_no = '".sql_esc($row['purc_ord_no'])."' AND material_no = '".sql_esc($row["material_no"])."'";
$result_check_Pftp = mysqli_query($dbc,$query_check_Pftp);
$data_check_Pftp = mysqli_fetch_array($result_check_Pftp);

  
  $tot_gr_qtyC = $tot_gr_qtyC + $data_check_Pftp["po_qty"];
     


if($tot_gr_qtyB != 0.000)
 {
  
$Grd_total_new_bal = (($tot_gr_qtyC) - ($tot_gr_qtyB));

}else{

 $Grd_total_new_bal = ($tot_gr_qtyC);
}

//------------number format -------------//
if($row["ord_uom"] == 'PCS')
{
  $PO_baru = intval($tot_gr_qtyC,3);
  $GR_baru = intval($tot_gr_qtyB,3);
  $Grd_baru = intval($Grd_total_new_bal);

}else{

  $PO_baru = number_format($tot_gr_qtyC,3);
  $GR_baru = number_format($tot_gr_qtyB,3);
  $Grd_baru = number_format($Grd_total_new_bal,3);

}






      ?>

                <tr>
                <td width="30"><?php echo $no4; ?></td> 
                <td width="150"><?php echo html_esc($row["vendor_id"]); ?></td>
                <td width="150"><?php echo html_esc($row["purc_ord_no"]); ?></td>
                <td width="150"><?php echo html_esc($row["material_no"]); ?></td>
                <td width="300"><?php echo html_esc($row["material_desc"]); ?></td>
                <td width="150"><?php echo html_esc($row["model_gr"]); ?></td>
                <td width="150"><span class="badge badge-pill badge-primary"><?php echo $PO_baru; ?></span></td>
                <td width="150"><?php if($GR_baru < 0) { ?><span class="badge badge-pill badge-warning"><?php echo $GR_baru; ?></span><?php }else{ ?><span class="badge badge-pill badge-info"> <?php echo $GR_baru; ?></span> <?php } ?> </td>
                <td width="150"><?php if($Grd_baru < 0) { ?><span class="badge badge-pill badge-danger"><?php echo $Grd_baru; ?></span><?php }else{ ?><span class="badge badge-pill badge-success"> <?php echo $Grd_baru; ?></span> <?php } ?></td>
                <td width="150"><?php echo html_esc($row["ord_uom"]); ?></td>              
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
    <!-- <script type="text/javascript">$('#example').DataTable();</script> -->
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    
     <script language="javascript">
		  $(document).ready(function() {
				$('#example').DataTable( {
					"scrollX": true,
			//		"lengthMenu": [[ -1], [ "All"]]
				} );
		} );
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

/* 
	
$.fn.rowCount = function() {
    return $('tr', $(this).find('tbody')).length;
};

$.fn.columnCount = function() {
    return $('th', $(this).find('tbody')).length;
};
var

rowctr = $('#example').rowCount();
var colctr = $('#example').columnCount();

console.log('No of Rows:'+rowctr);
console.log('No of Columns:'+colctr);

$('div.total-title').text('There are currently '+rowctr+'  record(s)'); */

</script>
  </body>
</html>