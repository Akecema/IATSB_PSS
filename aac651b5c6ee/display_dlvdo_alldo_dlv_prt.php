<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "prt_dlvdo_alldo-dlvProc.php"; 
	require_once('tcpdf_barcodes_2d.php');
	
	$fmt_curr_date = (date("d-m-Y"));



                 $drun = substr($fmt_curr_date,0,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,8,2);
				 
				 $date_run = ($drun.$mrun.$yrun);

	
//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	

//--------menu function ------------------------------

$query_function = new PreparedSql("SELECT * FROM function_acc_detail WHERE staff_ID = ?", [$res["staff_ID"]]);
$result_function = db_query($dbc, $query_function);   //run the query.
//$data_function = mysqli_fetch_array($result_function);   //how many records are there?  

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
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   
 
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    

    <style type="text/css" media="print"> 
.breakAfter{ 
page-break-after: always; 
}
.breakBefore{
page-break-before: always ;
}
.tfoot { display: table-footer-group; }
.page {
 size:landscape;
 bottom: 0;
   
}

  .breakAfter{ 
page-break-after: always; 
}
.breakBefore{
page-break-before: always ;
}
  

	
@media print {
    body.modalprinter * {
        visibility: hidden;
    }

    body.modalprinter .modal-dialog.focused {
        position: absolute;
        padding: 0;
        margin: 0;
        left: 0;
        top: 0;
    }

    body.modalprinter .modal-dialog.focused .modal-content {
        border-width: 0;
    }

    body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title,
    body.modalprinter .modal-dialog.focused .modal-content .modal-body,
    body.modalprinter .modal-dialog.focused .modal-content .modal-body * {
        visibility: visible;
    }

    body.modalprinter .modal-dialog.focused .modal-content .modal-header,
    body.modalprinter .modal-dialog.focused .modal-content .modal-body {
        padding: 0;
    }

    body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title {
        margin-bottom: 20px;
    }
}

</style> 
<style >
.modlDisplay
{
	width : 1000px;	
}

</style>
 <script type="text/javascript">
        function print_page() {
            var ButtonControl = document.getElementById("btnprint");
            ButtonControl.style.visibility = "hidden";
            window.print();
        }
    </script>
  </head>
  <body class="app sidebar-mini">
  
 <?php
 
  $extension = explode('.', $data_setup["logo_name"]);
  $filename = $data_setup["logo_comp"].'.'.$extension[1];
  
  
 
  
  //-------------- click button "Cancellation"----------------
 
if(isset($_POST["printDO_btn"])) 
{ // handle the form.

	$uid2 = $_POST["uid2"];
	$do_no = $_POST["do_no"];
	$dateF = $_POST["date1"];
	$dateT = $_POST["date2"];
	$ship_point = $_POST["ship_point"];
	$status_part = $_POST["status_part"];
	




	

	if($status_part == "OTHERS")
	{
	
	
	    $query_by_groupF = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T5 from dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($uid2)."'";
      $result_by_groupF = mysqli_query($dbc,$query_by_groupF);   //run the query.
		  $row_by_groupF = mysqli_fetch_array($result_by_groupF);
		
		$dtcrt = $row_by_groupF["T5"];
      //-------get issued detail----
	  
	  $query_issueF = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$row_by_groupF["user_post"]]);
	  $result_issueF = db_query($dbc, $query_issueF);
	  $data_issueF = mysqli_fetch_array($result_issueF);	
	  
	  $ffff = $data_issueF["user_fullname"];
	  
	    $buid2 = (base64_encode($uid2));
	    $puid2 = (base64_encode($ffff));
		  $duid2 = (base64_encode($dtcrt));
		
	
	
	echo "<script>";
	echo "window.open('dlvdo-print_othcust.php?buid=$buid2&&puid=$puid2&&duid=$duid2', '_blank');";
	echo "window.location='prt_dlvdo_alldo-dlvProc.php?do_no=".html_esc($do_no)."&&ship_to=".html_esc($ship_point)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."'";
	echo "</script>";
	exit(); //quit the script
	
	}


}// end submit
 
?>
  <div class="modal fade printable autoprint" id="myNoteDisplayDO<?php echo html_esc($row["material_doc_gen"]); ?><?php echo html_esc($row["ship_point"]); ?><?php echo html_esc($row["status_part"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content modlDisplay">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">PSS Delivery Order</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
     <!--   <div class="content mt-12">-->
     
     <?php
	 
	 $query_bb = "SELECT * from dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($row["material_doc_gen"])."'";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 ?>
   
   <form name="frmSearch" id="frmSearch" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" >  
   
  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="250" height="50"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<h5><font color="#999999"><b>PSS DELIVERY ORDER</b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>Plant :  </b><?php echo html_esc($row["plant_code"]);   ?></div></td>
    <td>&nbsp;</td> 
    <td><div align="left"><b>Document No. :  </b><?php echo html_esc($row["material_doc_gen"]);   ?></div></td>
  </tr>
   </table>


  <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T3, DATE_FORMAT(dlv_date,'%d-%m-%Y') AS T7 FROM dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($row["material_doc_gen"])."' " .$where_sql." ORDER BY material_doc_gen ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.

   ?>
 
 <table width="98%" class="table-bordered">
 <thead bgcolor="#eeeeee">
  <tr>
     <th>No</th>
     <th>Part No.</th>
     <th>Part Name</th>
     <th>Created Date</th>
     <th>Delivery Date</th>
     <th>Delivery Quantity</th>
     <th>Ship From</th>
     <th>Ship To</th>
    </tr>
  </thead>
  <tbody>
  <?php
    
   while($row2 = mysqli_fetch_array($result_display))
   {

   
	   $query_mat = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$row2["material_no"]]);
	   $result_mat = db_query($dbc, $query_mat);
       $row_mat = mysqli_fetch_array($result_mat);
	   
	   
  
  ?>
  <tr>
    <td><?php echo $no; ?>&nbsp;&nbsp;<?php //echo $row2["id"]; ?></td>
    <td><?php echo html_esc($row2["material_no"]); ?></td>
    <td><?php echo html_esc($row2["material_desc"]); ?></td>
    <td><?php echo html_esc($row2["T3"]); ?></td>
    <td><?php echo html_esc($row2["T7"]); ?></td>
    <td><?php echo intval($row2["qty_dlv"]); ?></td>
    <td><?php echo html_esc($row2["cust_code"]); ?></td>
    <td><?php echo html_esc($row2["ship_point"]); ?></td>
  </tr>
  
 <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
       
  </tbody>
</table>
 <br><br>
    
       
      <input name="do_no"  type="hidden" id="do_no" value="<?php echo html_esc($do_no); ?>">
      <input name="uid2" type="hidden" id="uid2" value="<?php echo html_esc($row["material_doc_gen"]); ?>">
      <input name="ship_to" type="hidden" id="ship_to" value="<?php echo html_esc($_GET["ship_to"]); ?>">
      <input name="date1"  type="hidden" id="date1" value="<?php echo html_esc($_GET["date1"]); ?>">
      <input name="date2"  type="hidden" id="date2" value="<?php echo html_esc($_GET["date2"]); ?>">
      <input name="ship_point" type="hidden" id="ship_point" value="<?php echo html_esc($row["ship_point"]); ?>">
      <input name="status_part" type="hidden" id="status_part" value="<?php echo html_esc($row["status_part"]); ?>">
       
         <!-- <div class="modal-footer pull-left">-->
         <input name="printDO_btn" type="submit"  class="btn btn-success btn-sm" value="PRINT" />
           
             <!--</div> -->

  </form>
      
    
     </div> 
    
                  </div>
                  </div>
                  </div>
      
          
</body>
</html>