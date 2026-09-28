<?php

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
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

$query_function = "SELECT * FROM function_acc_detail WHERE staff_ID = '".sql_esc($res["staff_ID"])."'";
$result_function = mysqli_query($dbc,$query_function);   //run the query.
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

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc,$sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

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

//CR status (Return GRA)
$sta26 = "SELECT * from request_status WHERE status_id = '26'";
$sta_res26 = mysqli_query($dbc,$sta26);
$rst_sta26 = mysqli_fetch_array($sta_res26);

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);	

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
 //-------------- click button "Cancellation"----------------
  if(isset($_POST["can_RTNDObtn"])) 
  
   { // handle the form.

 
   $uid4 = $_POST["uid4"];
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
				
				 $query_id3 = "SELECT * FROM run_count_itsb WHERE uid = '44'";
				 $result_id3 = mysqli_query($dbc,$query_id3);
				
				}elseif($ship_point == '3101')
				{
					
				 $query_id3 = "SELECT * FROM run_count_itsb WHERE uid = '91'";
				 $result_id3 = mysqli_query($dbc,$query_id3);
					
				}
				
				if ($result_id3) 
			{
				$nrows3 = mysqli_num_rows($result_id3);
				$row_id3 = mysqli_fetch_array($result_id3);
				
				$dht3 = 00000; 
				$dht_OK3 = "522";
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
 
   
 
 
   
   // --------- pps detail ------------
	 
	   $query_ppsA = "SELECT * FROM dlv_ord_all_return_delivery WHERE doc_no_return = '".sql_esc($uid4)."' AND status_DO = '".sql_esc($rst_sta31["status_desc"])."'";
	   $result_ppsA = mysqli_query($dbc,$query_ppsA);
	  
	  while($data_ppsA = mysqli_fetch_array($result_ppsA))
	  
	  {
		  
	/*echo $data_pps["id"];  echo "<br>nnnn";
	
	echo $ref3;*/
	
	 $query_can_rtn = "UPDATE dlv_ord_all_return_delivery SET ref_doc_return = '".sql_esc($ref3A)."', qty_return = '0.000', status_upload = '".sql_esc($rst_sta4["status_desc"])."', status_DO = '".sql_esc($rst_sta4["status_desc"])."', user_doc_return ='".sql_esc($username)."', date_doc_return = NOW() WHERE id = '".sql_esc($data_ppsA["id"])."' AND doc_no_return = '".sql_esc($data_ppsA["doc_no_return"])."' AND status_DO = '".sql_esc($rst_sta31["status_desc"])."'";
	 $result_can_rtn = mysqli_query($dbc,$query_can_rtn);
	 
	 //--------reverse semula return dlm table dlv_ord_all_delivery
	 
	 $query_upd_rvs = "UPDATE dlv_ord_all_delivery SET status_DO = '".sql_esc($rst_sta3["status_desc"])."', doc_no_return = '', return_by = '', date_return = '0000-00-00 00:00:00', reject_ticket_no = '', user_reject = '', date_reject = '0000-00-00 00:00:00' WHERE id = '".sql_esc($data_ppsA["id_dlv"])."' AND doc_no_return = '".sql_esc($data_ppsA["doc_no_return"])."' AND status_DO = '".sql_esc($rst_sta31["status_desc"])."'";
	 $result_upd_rvs = mysqli_query($dbc,$query_upd_rvs);
	
	
	  //----get detail------
	  
	   $query_dtlA = "SELECT * FROM dlv_ord_all_return_delivery WHERE id = '".sql_esc($data_ppsA["id"])."' AND doc_no_return = '".sql_esc($data_ppsA["doc_no_return"])."'";
	   $result_dtlA = mysqli_query($dbc,$query_dtlA);
	   $row_infoA = mysqli_fetch_array($result_dtlA);
	  
		 //insert into table dlv_ord_all_return_delivery_canc------------
	  
	$query_data2 = "INSERT INTO dlv_ord_all_return_delivery_canc(id_cancel,id,id_dlv,id_do,upload_id,scan_gen,material_doc_gen,pdio_no,order_no,vendor_name,shop_pt,lshop,ldock,dlv_cat,trip_no,lane_no,prod_date,dlv_date,cycle_no,back_no,material_no,material_desc,total_order_pcs,total_order_box,total_rcv_pcs,total_rcv_box,user_upload,date_upload,status_upload,user_update,date_update,so_no,ship_point,cust_code,id_soi,doc_gen,sold_desc,ship_no,ship_desc,item_no,material_no_soi,material_desc_soi,plant_code,qty_order,qty_bal,qty_rec,qty_dlv,unit_soi,matl_group,sales_org,posting_date,posting_time,user_post,date_post,time_post,ref_material_doc,user_cancel,date_cancel,remark_cancel,status_DO,status_part,qty_return,doc_no_return,return_by,date_return,reject_ticket_no,user_reject,date_reject,ref_doc_return,user_doc_return,date_doc_return,remark_doc_return,return_ind) VALUES ('','".sql_esc($row_infoA["id"])."','".sql_esc($row_infoA["id_dlv"])."','".sql_esc($row_infoA["id_do"])."','".sql_esc($row_infoA["upload_id"])."','".sql_esc($row_infoA["scan_gen"])."','".sql_esc($row_infoA["material_doc_gen"])."','".sql_esc($row_infoA["pdio_no"])."','".sql_esc($row_infoA["order_no"])."','".sql_esc($row_infoA["vendor_name"])."','".sql_esc($row_infoA["shop_pt"])."','".sql_esc($row_infoA["lshop"])."','".sql_esc($row_infoA["ldock"])."','".sql_esc($row_infoA["dlv_cat"])."','".sql_esc($row_infoA["trip_no"])."','".sql_esc($row_infoA["lane_no"])."','".sql_esc($row_infoA["prod_date"])."','".sql_esc($row_infoA["dlv_date"])."','".sql_esc($row_infoA["cycle_no"])."','".sql_esc($row_infoA["back_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["total_order_pcs"])."','".sql_esc($row_infoA["total_order_box"])."','".sql_esc($row_infoA["total_rcv_pcs"])."','".sql_esc($row_infoA["total_rcv_box"])."','".sql_esc($row_infoA["user_upload"])."','".sql_esc($row_infoA["date_upload"])."','".sql_esc($row_infoA["status_upload"])."','".sql_esc($row_infoA["user_update"])."','".sql_esc($row_infoA["date_update"])."','".sql_esc($row_infoA["so_no"])."','".sql_esc($row_infoA["ship_point"])."','".sql_esc($row_infoA["cust_code"])."','".sql_esc($row_infoA["id_soi"])."','".sql_esc($row_infoA["doc_gen"])."','".sql_esc($row_infoA["sold_desc"])."','".sql_esc($row_infoA["ship_no"])."','".sql_esc($row_infoA["ship_desc"])."','".sql_esc($row_infoA["item_no"])."','".sql_esc($row_infoA["material_no_soi"])."','".sql_esc($row_infoA["material_desc_soi"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["qty_order"])."','".sql_esc($row_infoA["qty_bal"])."','".sql_esc($row_infoA["qty_rec"])."','".sql_esc($row_infoA["qty_dlv"])."','".sql_esc($row_infoA["unit_soi"])."','".sql_esc($row_infoA["matl_group"])."','".sql_esc($row_infoA["sales_org"])."','".sql_esc($row_infoA["posting_date"])."','".sql_esc($row_infoA["posting_time"])."','".sql_esc($row_infoA["user_post"])."','".sql_esc($row_infoA["date_post"])."','".sql_esc($row_infoA["time_post"])."','".sql_esc($row_infoA["ref_material_doc"])."','".sql_esc($row_infoA["user_cancel"])."','".sql_esc($row_infoA["date_cancel"])."','".sql_esc($row_infoA["remark_cancel"])."','".sql_esc($row_infoA["status_DO"])."','".sql_esc($row_infoA["status_part"])."','".sql_esc($row_infoA["qty_return"])."','".sql_esc($row_infoA["doc_no_return"])."','".sql_esc($row_infoA["return_by"])."','".sql_esc($row_infoA["date_return"])."','".sql_esc($row_infoA["reject_ticket_no"])."','".sql_esc($row_infoA["user_reject"])."','".sql_esc($row_infoA["date_reject"])."','".sql_esc($row_infoA["ref_doc_return"])."','".sql_esc($row_infoA["user_doc_return"])."','".sql_esc($row_infoA["date_doc_return"])."','".sql_esc($row_infoA["remark_doc_return"])."','".sql_esc($row_infoA["return_ind"])."')";
	$result_data2 = mysqli_query($dbc,$query_data2);  
  
		  
	  } // end while data pss


	        
		  if($ship_point == '3100')
				{
				
	   $query_max_A1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '44'";
	   $result_max_A1 = mysqli_query($dbc,$query_max_A1);
				
		    }elseif($ship_point == '3101')
				{
	 
	   $query_max_A1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '91'";
	   $result_max_A1 = mysqli_query($dbc,$query_max_A1);
	 
				}
    
		   echo "<script>";
		   echo "alert('Return DO ".html_esc($uid4)." Successfully Cancelled. Your cancellation number $ref3A');";
		   echo "window.location='canC_return_dlvdo_alldo-dlvProc.php?do_no=$do_no&&ship_to=$ship_to&&date1=$dateF&&date2=$dateT&&date3=".html_esc($dateA)."'";
	       echo "</script>"; 
		   exit(); //quit the script
		


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteCancelRTNDO<?php echo html_esc($row["doc_no_return"]); ?><?php echo html_esc($row["ship_point"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Cancellation Return Delivery Order</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
        <div class="content mt-12">
   
  <?php
  
            $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
        	$ship_to = $_GET["ship_to"]; 
			$do_no = $_GET["do_no"]; 
  
         
			 $where_sql = '';
				 
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 $ddF2 = substr($_GET["date2"],0,2);
				 $mmF2 = substr($_GET["date2"],3,2);
				 $yyF2 = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyF2.'-'.$mmF2.'-'.$ddF2);
				 
				 $ddF3 = substr($_GET["date3"],0,2);
				 $mmF3 = substr($_GET["date3"],3,2);
				 $yyF3 = substr($_GET["date3"],6,4);
			
			     $date3_final = ($yyF3.'-'.$mmF3.'-'.$ddF3);
				 
								 		
		
								
	       //1. do_no
                if ($do_no == ""){ 
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND material_doc_gen = '".sql_esc($do_no)."'"; }  
					
		   //2. ship to party
                if (($ship_to == "") || ($ship_to == "NULL")){ 
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND cust_code = '".sql_esc($ship_to)."'"; }  	
						
					
		   // 3. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND (dlv_date >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (dlv_date <= '".sql_esc($date2_final)."')"; }
					
		  //4. DateA (posting date)
                if ($dateA == "0000-00-00" ){
                    $wheresql_05 = ""; }
                else {
					$wheresql_05 = " AND (posting_date >= '".sql_esc($date3_final)."')"; }
							

				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;
	
	//********** END CONDITION **************
 ?>

  

<br>

        <div class="content mt-12"><h5>Confirm to Cancel Return DO?</h5><br>
       

    <form name="frmSearch" id="frmSearch" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" class="needs-validation"  novalidate>

    <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM dlv_ord_all_return_delivery WHERE doc_no_return = '".sql_esc($row["doc_no_return"])."' AND ship_point = '".sql_esc($row["ship_point"])."' AND status_DO = '".sql_esc($rst_sta31["status_desc"])."' " .$where_sql." ORDER BY doc_no_return ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   
   while($row2 = mysqli_fetch_array($result_display))
   {

    //echo $row2["id"];
      ?>
     
      <input name="do_no"  type="hidden" id="do_no" value="<?php echo $do_no; ?>">
      <input name="uid4" type="hidden" id="uid4" value="<?php echo html_esc($row["doc_no_return"]); ?>">
      <input name="ship_to" type="hidden" id="ship_to" value="<?php echo html_esc($_GET["ship_to"]); ?>">
      <input name="date3"  type="hidden" id="date3" value="<?php echo html_esc($_GET["date3"]); ?>">
      <input name="date1"  type="hidden" id="date1" value="<?php echo html_esc($_GET["date1"]); ?>">
      <input name="date2"  type="hidden" id="date2" value="<?php echo html_esc($_GET["date2"]); ?>">
      <input name="ship_point" type="hidden" id="ship_point" value="<?php echo html_esc($row["ship_point"]); ?>"> 
  
      
      <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  
      
     <div class="modal-footer pull-left">
      <input name="can_RTNDObtn" type="submit"  class="btn btn-success btn-sm" value="PROCEED" />
     <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">CANCEL</button>
             </div> 

  </form>
                <!--  </div>--></div>
                  </div>
                  </div>
                  </div>
                  </div>
               
</body>
</html>