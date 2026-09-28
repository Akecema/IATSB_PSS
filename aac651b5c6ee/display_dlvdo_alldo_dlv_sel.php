<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "canC_dlvdo_alldo-dlvProc.php"; 
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
  if(isset($_POST["cancelDO_btn"])) 
  
   { // handle the form.

 
   $uid2 = $_POST["uid2"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   $ship_point = $_POST["ship_point"];
   
   //echo $uid2;
   
 
    //-----generate TP Cancellation Doc. No.
	
				 if($plant_code == '3100')
				{
				
				 $query_id3 = "SELECT * FROM run_count_itsb WHERE uid = '42'";
				 $result_id3 = mysqli_query($dbc,$query_id3);
				
				}elseif($plant_code == '3101')
				{
					
				 $query_id3 = "SELECT * FROM run_count_itsb WHERE uid = '89'";
				 $result_id3 = mysqli_query($dbc,$query_id3);
					
				}
				
				if ($result_id3) 
			{
				$nrows3 = mysqli_num_rows($result_id3);
				$row_id3 = mysqli_fetch_array($result_id3);
				
				$dht3 = 00000; 
				$dht_OK3 = "512";
				$dg3 = 0;
			
				if($row_id3["count_max"] <= 0)
				{ 
			   
					$lastID3 = ($row_id3["count_max"] + 1);
					$dg3 = ($dht3 + ($lastID3));
			   }
			   else
			   {
				  $lastID3 = ($row_id3["count_max"] + 1);
				  $dg3 =  $lastID3;
				
				}
				$number3 = $dg3; // Length of running no
				$number2 = sprintf('%03d', $number3);  
				
				$ref3A = (($row_id3["start_ref"]).$dht_OK3.$date_run.($number2));
				  
				
				} // end if $result_id2
 
          
	   if($plant_code == '3100')
				{
				
	   $query_max_A = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '42'";
	   $result_max_A = mysqli_query($dbc,$query_max_A);
				
		    }elseif($plant_code == '3101')
				{
	 
	   $query_max_A = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '89'";
	   $result_max_A = mysqli_query($dbc,$query_max_A);
	 
				}
    
 
 
   
   // --------- pps detail ------------
	 
	   $query_pps = "SELECT * FROM dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($uid2)."' AND status_DO = '".sql_esc($rst_sta3["status_desc"])."'";
	   $result_pps = mysqli_query($dbc,$query_pps);
	  
	  while($data_pps = mysqli_fetch_array($result_pps))
	  
	  {
		  
	/*echo $data_pps["id"];  echo "<br>nnnn";
	
	echo $ref3;*/
	
	
	 //------cancel status "Cancel"
	 if($data_pps["vendor_name"] == "100124")
	 {
		 
	 $query_can_per2 = "UPDATE scan_p2_perodua1 SET status_DO = '".sql_esc($rst_sta4["status_desc"])."', material_doc_ref = '".sql_esc($ref3A)."', user_cancel ='".sql_esc($username)."', date_cancel = NOW(), time_cancel = NOW() WHERE material_doc_gen = '".sql_esc($data_pps["material_doc_gen"])."' AND status_DO = '".sql_esc($rst_sta3["status_desc"])."'";
	 $result_can_per2 = mysqli_query($dbc,$query_can_per2);
	
	 }elseif($data_pps["vendor_name"] == "100002")
	 {
		 
     $query_can_per2sales = "UPDATE scan_p2_perodua2 SET status_DO = '".sql_esc($rst_sta4["status_desc"])."', material_doc_ref = '".sql_esc($ref3A)."', user_cancel ='".sql_esc($username)."', date_cancel = NOW(), time_cancel = NOW() WHERE material_doc_gen = '".sql_esc($data_pps["material_doc_gen"])."' AND status_DO = '".sql_esc($rst_sta3["status_desc"])."'";
	 $result_can_per2sales = mysqli_query($dbc,$query_can_per2sales);
		 
	 }elseif($data_pps["vendor_name"] == "100000")
	 {
		 
   $query_can_per2PMSB = "UPDATE scan_p2_perodua3 SET status_DO = '".sql_esc($rst_sta4["status_desc"])."', material_doc_ref = '".sql_esc($ref3A)."', user_cancel ='".sql_esc($username)."', date_cancel = NOW(), time_cancel = NOW() WHERE material_doc_gen = '".sql_esc($data_pps["material_doc_gen"])."' AND status_DO = '".sql_esc($rst_sta3["status_desc"])."'";
	 $result_can_per2PMSB = mysqli_query($dbc,$query_can_per2PMSB);

   $query_can_others = "UPDATE scan_p2_othcust SET status_DO = '".sql_esc($rst_sta4["status_desc"])."', material_doc_ref = '".sql_esc($ref3A)."', user_cancel ='".sql_esc($username)."', date_cancel = NOW(), time_cancel = NOW() WHERE material_doc_gen = '".sql_esc($data_pps["material_doc_gen"])."' AND status_DO = '".sql_esc($rst_sta3["status_desc"])."'";
	 $result_can_others = mysqli_query($dbc,$query_can_others); 
		 
	 }else{
		
	 $query_can_others = "UPDATE scan_p2_othcust SET status_DO = '".sql_esc($rst_sta4["status_desc"])."', material_doc_ref = '".sql_esc($ref3A)."', user_cancel ='".sql_esc($username)."', date_cancel = NOW(), time_cancel = NOW() WHERE material_doc_gen = '".sql_esc($data_pps["material_doc_gen"])."' AND status_DO = '".sql_esc($rst_sta3["status_desc"])."'";
	 $result_can_others = mysqli_query($dbc,$query_can_others); 
		 
	 }
	 
	  //---------update cancellation--------------------------
	 
	$query_cancel = "UPDATE dlv_ord_all_delivery SET status_DO = '".sql_esc($rst_sta4["status_desc"])."', ref_material_doc = '".sql_esc($ref3A)."', user_cancel = '".sql_esc($username)."', date_cancel = NOW() WHERE material_doc_gen = '".sql_esc($data_pps["material_doc_gen"])."'";
	$result_cancel = mysqli_query($dbc,$query_cancel);
	
	  //----get detail------
	  
	   $query_dtlA = "SELECT * FROM dlv_ord_all_delivery WHERE id = '".sql_esc($data_pps["id"])."' AND material_doc_gen = '".sql_esc($data_pps["material_doc_gen"])."'";
	   $result_dtlA = mysqli_query($dbc,$query_dtlA);
	   $row_infoA = mysqli_fetch_array($result_dtlA);
	  
		  
	  //insert into table dlv_ord_all_delivery_canc------------
	  
	$query_data2 = "INSERT INTO dlv_ord_all_delivery_canc(id_cancel,id,id_do,upload_id,scan_gen,material_doc_gen,pdio_no,order_no,vendor_name,shop_pt,lshop,ldock,dlv_cat,trip_no,lane_no,prod_date,dlv_date,cycle_no,back_no,material_no,material_desc,total_order_pcs,total_order_box,total_rcv_pcs,total_rcv_box,user_upload,date_upload,status_upload,user_update,date_update,so_no,ship_point,cust_code,id_soi,doc_gen,sold_desc,ship_no,ship_desc,item_no,material_no_soi,material_desc_soi,plant_code,qty_order,qty_bal,qty_rec,qty_dlv,unit_soi,matl_group,sales_org,posting_date,posting_time,user_post,date_post,time_post,ref_material_doc,user_cancel,date_cancel,remark_cancel,status_DO,status_part,qty_return,doc_no_return,return_by,date_return,reject_ticket_no,user_reject,date_reject) VALUES ('','".sql_esc($row_infoA["id"])."','".sql_esc($row_infoA["id_do"])."','".sql_esc($row_infoA["upload_id"])."','".sql_esc($row_infoA["scan_gen"])."','".sql_esc($row_infoA["material_doc_gen"])."','".sql_esc($row_infoA["pdio_no"])."','".sql_esc($row_infoA["order_no"])."','".sql_esc($row_infoA["vendor_name"])."','".sql_esc($row_infoA["shop_pt"])."','".sql_esc($row_infoA["lshop"])."','".sql_esc($row_infoA["ldock"])."','".sql_esc($row_infoA["dlv_cat"])."','".sql_esc($row_infoA["trip_no"])."','".sql_esc($row_infoA["lane_no"])."','".sql_esc($row_infoA["prod_date"])."','".sql_esc($row_infoA["dlv_date"])."','".sql_esc($row_infoA["cycle_no"])."','".sql_esc($row_infoA["back_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["total_order_pcs"])."','".sql_esc($row_infoA["total_order_box"])."','".sql_esc($row_infoA["total_rcv_pcs"])."','".sql_esc($row_infoA["total_rcv_box"])."','".sql_esc($row_infoA["user_upload"])."','".sql_esc($row_infoA["date_upload"])."','".sql_esc($row_infoA["status_upload"])."','".sql_esc($row_infoA["user_update"])."','".sql_esc($row_infoA["date_update"])."','".sql_esc($row_infoA["so_no"])."','".sql_esc($row_infoA["ship_point"])."','".sql_esc($row_infoA["cust_code"])."','".sql_esc($row_infoA["id_soi"])."','".sql_esc($row_infoA["doc_gen"])."','".sql_esc($row_infoA["sold_desc"])."','".sql_esc($row_infoA["ship_no"])."','".sql_esc($row_infoA["ship_desc"])."','".sql_esc($row_infoA["item_no"])."','".sql_esc($row_infoA["material_no_soi"])."','".sql_esc($row_infoA["material_desc_soi"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["qty_order"])."','".sql_esc($row_infoA["qty_bal"])."','".sql_esc($row_infoA["qty_rec"])."','".sql_esc($row_infoA["qty_dlv"])."','".sql_esc($row_infoA["unit_soi"])."','".sql_esc($row_infoA["matl_group"])."','".sql_esc($row_infoA["sales_org"])."','".sql_esc($row_infoA["posting_date"])."','".sql_esc($row_infoA["posting_time"])."','".sql_esc($row_infoA["user_post"])."','".sql_esc($row_infoA["date_post"])."','".sql_esc($row_infoA["time_post"])."','".sql_esc($row_infoA["ref_material_doc"])."','".sql_esc($row_infoA["user_cancel"])."','".sql_esc($row_infoA["date_cancel"])."','".sql_esc($row_infoA["remark_cancel"])."','".sql_esc($row_infoA["status_DO"])."','".sql_esc($row_infoA["status_part"])."','0.000','','','0000-00-00','','','0000-00-00')";
	$result_data2 = mysqli_query($dbc,$query_data2);  
  
		  
	  } // end while data pss
	  
	   //----checking ftp tp_dlv_ord_all_delivery_can-------
    $data_rcvV = "";
   

   $query_rcv_ftpV = "SELECT *, DATE_FORMAT(dlv_date,'%d%m%Y') AS J FROM dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($uid2)."' AND status_DO = '".sql_esc($rst_sta4["status_desc"])."'";
   $result_rcv_ftpV = mysqli_query($dbc,$query_rcv_ftpV);
   
   
  
   while($data_rcv_ftpV = mysqli_fetch_array($result_rcv_ftpV))
   
   {
	   
	   //echo "hhh".$ref3;
		 //----quantity-----
		 $qty_new = (intval($data_rcv_ftpV["qty_dlv"]));
		 
		 //----Posting Date Year
		 $post_yr = substr($data_rcv_ftpV["date_cancel"],0,4);
		 
   
     $data_rcvV .= $data_rcv_ftpV['so_no'].";".$data_rcv_ftpV['J'].";".$data_rcv_ftpV['material_no'].";".$qty_new.";".$data_rcv_ftpV['material_doc_gen'].";".$data_rcv_ftpV['ref_material_doc']."\r\n";
 
	
	  
	  } //end while loop
	  
	    $filen_rcvV = "DO".$ref3A;  
		 
		 $file_rcv = "../FromPortal2/DO/".$filen_rcvV.".csv";
		 file_put_contents($file_rcv,$data_rcvV);
	  
	  
	
	   //--------insert into table ftp_dlv_ord_perodua_dlv
	   
	   //----colect data --------------
  $query_collect = "SELECT * FROM dlv_ord_all_delivery WHERE ref_material_doc = '".sql_esc($ref3A)."'";
  $rst_collect = mysqli_query($dbc,$query_collect);
  
  
  while($data_collect = mysqli_fetch_array($rst_collect))
  
 {
    //--------insert into table ftp_dlv_ord_all_delivery_cancel
	
	$query_ftp_info2 = "INSERT INTO ftp_dlv_ord_all_delivery_cancel(id_ftp,file_name,ref_material_doc,material_doc_gen,id_do,scan_gen,plant_code,so_no,ship_point,cust_code,pdio_no,item_no,material_no,material_desc,qty_order,qty_dlv,uom_dlv,dlv_date,ship_from,ship_to,user_posting,date_posting,time_posting,status_DO,status_ftp,status_part) VALUES ('','".sql_esc($filen_rcvV)."','".sql_esc($ref3A)."','".sql_esc($data_collect["material_doc_gen"])."','".sql_esc($data_collect["id"])."','".sql_esc($data_collect["scan_gen"])."','".sql_esc($data_collect["plant_code"])."','".sql_esc($data_collect["so_no"])."','".sql_esc($data_collect["ship_point"])."','".sql_esc($data_collect["cust_code"])."','".sql_esc($data_collect["pdio_no"])."','".sql_esc($data_collect["item_no"])."','".sql_esc($data_collect["material_no"])."','".sql_esc($data_collect["material_desc"])."','".sql_esc($data_collect["qty_order"])."','".sql_esc($data_collect["qty_dlv"])."','".sql_esc($data_collect["unit_soi"])."','".sql_esc($data_collect["dlv_date"])."','".sql_esc($data_collect["cust_code"])."','".sql_esc($data_collect["ship_no"])."','".sql_esc($data_collect["user_post"])."','".sql_esc($data_collect["date_post"])."','".sql_esc($data_collect["time_post"])."','".sql_esc($data_collect["status_DO"])."','Y','".sql_esc($data_collect["status_part"])."')";
	$rst_ftp_info2 = mysqli_query($dbc,$query_ftp_info2);
	
 }
	   
				
    //---------------------------------------end ftp -------------------------------------------------   

	 
	 
   

		   echo "<script>";
		   echo "alert('Cancellation DO Number $ref3A Posted.');";
		   echo "window.location='canC_dlvdo_alldo-dlvProc.php?material_doc_gen=$material_doc_gen&&ship_point=".html_esc($ship_point)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."'";
	       echo "</script>"; 
		   exit(); //quit the script
		 
		


   }// end submit
 
 
?>
  <div class="modal fade printable autoprint" id="myNoteDisplayDO<?php echo html_esc($row["material_doc_gen"]); ?><?php echo html_esc($row["plant_code"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
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
	 
	  //------------plant code detail -------------
		 
		 $query_plant = new PreparedSql("SELECT * FROM plant_detail WHERE plant_code = ?", [$data_bb["plant_code"]]);
		 $result_plant = db_query($dbc, $query_plant);
	     $data_plant = mysqli_fetch_array($result_plant);
	 ?>
   
   <form name="frmSearch" id="frmSearch" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" >  
   
  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="250" height="50"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<h5><font color="#999999"><b>PSS DELIVERY ORDER</b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>Plant :  </b><?php echo html_esc($data_plant["plant_desc"]);   ?></div></td>
    <td>&nbsp;</td> 
    <td><div align="left"><b>Document No. :  </b><?php echo html_esc($row["material_doc_gen"]);   ?></div></td>
  </tr>
   </table>


  <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T3, DATE_FORMAT(dlv_date,'%d-%m-%Y') AS T7 FROM dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($row["material_doc_gen"])."' AND status_DO = '".sql_esc($rst_sta3["status_desc"])."' " .$where_sql." ORDER BY material_doc_gen ASC ";
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
     <th>DI/PDIO Number</th>
     <th>Tag No.</th>
    </tr>
  </thead>
  <tbody>
  <?php
    
   while($row2 = mysqli_fetch_array($result_display))
   {

  
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo html_esc($row2["material_no"]); ?></td>
    <td><?php echo html_esc($row2["material_desc"]); ?></td>
    <td><?php echo html_esc($row2["T3"]); ?></td>
    <td><?php echo html_esc($row2["T7"]); ?></td>
    <td><?php echo intval($row2["qty_dlv"]); ?></td>
    <td><?php echo html_esc($row2["unit_soi"]); ?></td>
    <td><?php echo html_esc($row2["pdio_no"]); ?></td>
    <td><?php echo html_esc($row2["tag_no"]); ?></td>
  </tr>
  
 <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
       
  </tbody>
</table>
 <br><br>
    
       
      <input name="uid2" type="hidden" id="uid2" value="<?php echo html_esc($row["material_doc_gen"]); ?>">
      <input name="plant_code" type="hidden" id="plant_code" value="<?php echo html_esc($row["plant_code"]); ?>">
      <input name="ship_point" type="hidden" id="ship_point" value="<?php echo html_esc($_GET["ship_point"]); ?>">
      <input name="date1"  type="hidden" id="date1" value="<?php echo html_esc($_GET["date1"]); ?>">
      <input name="date2"  type="hidden" id="date2" value="<?php echo html_esc($_GET["date2"]); ?>">
       
         <!-- <div class="modal-footer pull-left">-->
         <input name="cancelDO_btn" type="submit"  class="btn btn-danger btn-sm" value="CANCEL" onClick="return confirm('Confirm to Cancel DO <?php echo html_esc($row["material_doc_gen"]); ?> ?');"/>
           
             <!--</div> -->

  </form>
      
    
     </div> 
    
                  </div>
                  </div>
                  </div>
      
          
</body>
</html>