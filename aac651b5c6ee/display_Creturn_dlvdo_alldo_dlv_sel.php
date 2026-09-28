<?php
    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "canC_return_dlvdo_alldo-dlvProc.php"; 
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
  
} */
	
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
  if(isset($_POST["cancelRTNDO_btn"])) 
  
   { // handle the form.

 
   $uid2 = $_POST["uid2"];
   $do_no = $_POST["do_no"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   $dateA = $_POST["date3"];
   $ship_to = $_POST["ship_to"];
   $ship_point = $_POST["ship_point"];
   
   
   //echo $uid2;
   
 
    //-----generate TP Cancellation Doc. No.
	
				 if($ship_point == '3100')
				{
				
				 $query_id3 = "SELECT count_max FROM run_count_itsb WHERE uid = '44'";
				 $result_id3 = mysqli_query($dbc,$query_id3);
				
				}elseif($ship_point == '3101')
				{
					
				 $query_id3 = "SELECT count_max FROM run_count_itsb WHERE uid = '91'";
				 $result_id3 = mysqli_query($dbc,$query_id3);
					
				}
				
				if ($result_id3) 
			{
				$nrows3 = mysqli_num_rows($result_id3);
				$row_id3 = mysqli_fetch_row($result_id3);
				
				$dht3 = 00000; 
				$dht_OK3 = "522";
				$dg3 = 0;
			
				if($row_id3[0] <= 0)
				{ 
			   
					$lastID3 = ($row_id3[0] + 1);
					$dg3 = ($dht3 + ($lastID3));
			   }
			   else
			   {
				  $lastID3 = ($row_id3[0] + 1);
				  $dg3 =  $lastID3;
				
				}
				$number3 = $dg3; // Length of running no
				$number2 = sprintf('%05d', $number3);  
				
				$ref3A = ($ship_point.$dht_OK3.$date_run.($number2));
				  
				
				} // end if $result_id2
 
   
 
 
   
   // --------- pps detail ------------
	 
	   $query_pps = "SELECT * FROM dlv_ord_all_return_delivery WHERE doc_no_return = '".sql_esc($uid2)."' AND status_DO = '".sql_esc($rst_sta31["status_desc"])."'";
	   $result_pps = mysqli_query($dbc,$query_pps);
	  
	  while($data_pps = mysqli_fetch_array($result_pps))
	  
	  {
		  
	/*echo $data_pps["id"];  echo "<br>nnnn";
	echo $ref3A;*/
	
	
	 $query_can_rtn = "UPDATE dlv_ord_all_return_delivery SET ref_doc_return = '".sql_esc($ref3A)."', qty_return = '0.000', status_upload = '".sql_esc($rst_sta4["status_desc"])."', status_DO = '".sql_esc($rst_sta4["status_desc"])."', user_doc_return ='".sql_esc($username)."', date_doc_return = NOW() WHERE id = '".sql_esc($data_pps["id"])."' AND doc_no_return = '".sql_esc($data_pps["doc_no_return"])."' AND status_DO = '".sql_esc($rst_sta31["status_desc"])."'";
	 $result_can_rtn = mysqli_query($dbc,$query_can_rtn);
	 
	 //--------reverse semula return dlm table dlv_ord_all_delivery
	 
	 $query_upd_rvs = "UPDATE dlv_ord_all_delivery SET status_DO = '".sql_esc($rst_sta3["status_desc"])."', doc_no_return = '', return_by = '', date_return = '0000-00-00 00:00:00', reject_ticket_no = '', user_reject = '', date_reject = '0000-00-00 00:00:00' WHERE id = '".sql_esc($data_pps["id_dlv"])."' AND doc_no_return = '".sql_esc($data_pps["doc_no_return"])."' AND status_DO = '".sql_esc($rst_sta31["status_desc"])."'";
	 $result_upd_rvs = mysqli_query($dbc,$query_upd_rvs);
	
	

	  //----get detail------
	  
	   $query_dtlA = "SELECT * FROM dlv_ord_all_return_delivery WHERE id = '".sql_esc($data_pps["id"])."' AND doc_no_return = '".sql_esc($data_pps["doc_no_return"])."'";
	   $result_dtlA = mysqli_query($dbc,$query_dtlA);
	   $row_infoA = mysqli_fetch_array($result_dtlA);
	  
		  
	  //insert into table dlv_ord_all_return_delivery_canc------------
	  
	$query_data2 = "INSERT INTO dlv_ord_all_return_delivery_canc(id_cancel,id,id_dlv,id_do,upload_id,scan_gen,material_doc_gen,pdio_no,order_no,vendor_name,shop_pt,lshop,ldock,dlv_cat,trip_no,lane_no,prod_date,dlv_date,cycle_no,back_no,material_no,material_desc,total_order_pcs,total_order_box,total_rcv_pcs,total_rcv_box,user_upload,date_upload,status_upload,user_update,date_update,so_no,ship_point,cust_code,id_soi,doc_gen,sold_desc,ship_no,ship_desc,item_no,material_no_soi,material_desc_soi,plant_code,qty_order,qty_bal,qty_rec,qty_dlv,unit_soi,matl_group,sales_org,posting_date,posting_time,user_post,date_post,time_post,ref_material_doc,user_cancel,date_cancel,remark_cancel,status_DO,status_part,qty_return,doc_no_return,return_by,date_return,reject_ticket_no,user_reject,date_reject,ref_doc_return,user_doc_return,date_doc_return,remark_doc_return,return_ind) VALUES ('','".sql_esc($row_infoA["id"])."','".sql_esc($row_infoA["id_dlv"])."','".sql_esc($row_infoA["id_do"])."','".sql_esc($row_infoA["upload_id"])."','".sql_esc($row_infoA["scan_gen"])."','".sql_esc($row_infoA["material_doc_gen"])."','".sql_esc($row_infoA["pdio_no"])."','".sql_esc($row_infoA["order_no"])."','".sql_esc($row_infoA["vendor_name"])."','".sql_esc($row_infoA["shop_pt"])."','".sql_esc($row_infoA["lshop"])."','".sql_esc($row_infoA["ldock"])."','".sql_esc($row_infoA["dlv_cat"])."','".sql_esc($row_infoA["trip_no"])."','".sql_esc($row_infoA["lane_no"])."','".sql_esc($row_infoA["prod_date"])."','".sql_esc($row_infoA["dlv_date"])."','".sql_esc($row_infoA["cycle_no"])."','".sql_esc($row_infoA["back_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["total_order_pcs"])."','".sql_esc($row_infoA["total_order_box"])."','".sql_esc($row_infoA["total_rcv_pcs"])."','".sql_esc($row_infoA["total_rcv_box"])."','".sql_esc($row_infoA["user_upload"])."','".sql_esc($row_infoA["date_upload"])."','".sql_esc($row_infoA["status_upload"])."','".sql_esc($row_infoA["user_update"])."','".sql_esc($row_infoA["date_update"])."','".sql_esc($row_infoA["so_no"])."','".sql_esc($row_infoA["ship_point"])."','".sql_esc($row_infoA["cust_code"])."','".sql_esc($row_infoA["id_soi"])."','".sql_esc($row_infoA["doc_gen"])."','".sql_esc($row_infoA["sold_desc"])."','".sql_esc($row_infoA["ship_no"])."','".sql_esc($row_infoA["ship_desc"])."','".sql_esc($row_infoA["item_no"])."','".sql_esc($row_infoA["material_no_soi"])."','".sql_esc($row_infoA["material_desc_soi"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["qty_order"])."','".sql_esc($row_infoA["qty_bal"])."','".sql_esc($row_infoA["qty_rec"])."','".sql_esc($row_infoA["qty_dlv"])."','".sql_esc($row_infoA["unit_soi"])."','".sql_esc($row_infoA["matl_group"])."','".sql_esc($row_infoA["sales_org"])."','".sql_esc($row_infoA["posting_date"])."','".sql_esc($row_infoA["posting_time"])."','".sql_esc($row_infoA["user_post"])."','".sql_esc($row_infoA["date_post"])."','".sql_esc($row_infoA["time_post"])."','".sql_esc($row_infoA["ref_material_doc"])."','".sql_esc($row_infoA["user_cancel"])."','".sql_esc($row_infoA["date_cancel"])."','".sql_esc($row_infoA["remark_cancel"])."','".sql_esc($row_infoA["status_DO"])."','".sql_esc($row_infoA["status_part"])."','".sql_esc($row_infoA["qty_return"])."','".sql_esc($row_infoA["doc_no_return"])."','".sql_esc($row_infoA["return_by"])."','".sql_esc($row_infoA["date_return"])."','".sql_esc($row_infoA["reject_ticket_no"])."','".sql_esc($row_infoA["user_reject"])."','".sql_esc($row_infoA["date_reject"])."','".sql_esc($row_infoA["ref_doc_return"])."','".sql_esc($row_infoA["user_doc_return"])."','".sql_esc($row_infoA["date_doc_return"])."','".sql_esc($row_infoA["remark_doc_return"])."','".sql_esc($row_infoA["return_ind"])."')";
	$result_data2 = mysqli_query($dbc,$query_data2);  
  
		  
	  } // end while data pss
	  
	
	        
		  if($ship_point == '3100')
				{
				
	   $query_max_A = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '44'";
	   $result_max_A = mysqli_query($dbc,$query_max_A);
				
		    }elseif($ship_point == '3101')
				{
	 
	   $query_max_A = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '91'";
	   $result_max_A = mysqli_query($dbc,$query_max_A);
	 
				}  

		   echo "<script>";
		   echo "alert('Return DO ".html_esc($uid2)." Successfully Cancelled. Your cancellation number $ref3A');";
		   echo "window.location='canC_return_dlvdo_alldo-dlvProc.php?do_no=".html_esc($do_no)."&&ship_to=".html_esc($ship_to)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&date3=".html_esc($dateA)."'";
	       echo "</script>"; 
		   exit(); //quit the script
		 
		


   }// end submit
 
 
?>
  <div class="modal fade printable autoprint" id="myNoteDisplayRTNDO<?php echo html_esc($row["doc_no_return"]); ?><?php echo html_esc($row["ship_point"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">PSS Return Delivery Order</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
     <!--   <div class="content mt-12">-->
     
     <?php
	 
	 $query_bb = "SELECT * from dlv_ord_all_return_delivery WHERE doc_no_return = '".sql_esc($row["doc_no_return"])."'";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	  if($data_bb["return_ind"] == "WTR")
	  {
		$status_RtnDOA = "With Replacement"; 
		  
	  }elseif($data_bb["return_ind"] == "WOR")
	  {
		$status_RtnDOA = "Without Replacement"; 
		
	  }else{
		  
		$status_RtnDOA = "None";  
		  
	  }
	 
	 
	 
	 
	 ?>
   
   <form name="frmSearch" id="frmSearch" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" >  
   
  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="250" height="50"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<h5><font color="#999999"><b>PSS RETURN DELIVERY ORDER - <?php echo $status_RtnDOA; ?></b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>Plant :  </b><?php echo html_esc($row["plant_code"]);   ?></div></td>
    <td>&nbsp;</td> 
    <td><div align="left"><b>Delivery Document No. :  </b><?php echo html_esc($row["material_doc_gen"]);   ?></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td> 
    <td><div align="left"><b>Return Document No. :  </b><?php echo html_esc($row["doc_no_return"]);   ?></div></td>
  </tr>
   </table>


  <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT *, DATE_FORMAT(date_return,'%d-%m-%Y') AS T3, DATE_FORMAT(dlv_date,'%d-%m-%Y') AS T7 FROM dlv_ord_all_return_delivery WHERE doc_no_return = '".sql_esc($row["doc_no_return"])."' AND status_DO = '".sql_esc($rst_sta31["status_desc"])."' " .$where_sql." ORDER BY doc_no_return ASC ";
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
     <th>Quantity</th>
     <th>Unit</th>
     <th>Customer</th>
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
    <td><?php echo $no; ?></td>
    <td><?php echo html_esc($row2["material_no"]); ?></td>
    <td><?php echo html_esc($row2["material_desc"]); ?></td>
    <td><?php echo html_esc($row2["T3"]); ?></td>
    <td><?php echo html_esc($row2["T7"]); ?></td>
    <td><?php echo intval($row2["qty_dlv"]); ?></td>
    <td><?php echo html_esc($row2["unit_soi"]); ?></td>
    <td><?php echo html_esc($row2["cust_code"]); ?></td>
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
      <input name="uid2" type="hidden" id="uid2" value="<?php echo html_esc($row["doc_no_return"]); ?>">
      <input name="ship_to" type="hidden" id="ship_to" value="<?php echo html_esc($_GET["ship_to"]); ?>">
      <input name="date3"  type="hidden" id="date3" value="<?php echo html_esc($_GET["date3"]); ?>">
      <input name="date1"  type="hidden" id="date1" value="<?php echo html_esc($_GET["date1"]); ?>">
      <input name="date2"  type="hidden" id="date2" value="<?php echo html_esc($_GET["date2"]); ?>">
      <input name="ship_point" type="hidden" id="ship_point" value="<?php echo html_esc($row["ship_point"]); ?>">
       
         <!-- <div class="modal-footer pull-left">-->
         <input name="cancelRTNDO_btn" type="submit"  class="btn btn-danger btn-sm" value="CANCEL" onClick="return confirm('Are you sure to cancel this transaction?');"/>
           
             <!--</div> -->

  </form>
      
    
     </div> 
    
                  </div>
                  </div>
                  </div>
      
          
</body>
</html>