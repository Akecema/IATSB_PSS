<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "can_tp_subcontProc2.php"; 
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
  if(isset($_POST["cancTP_btn"])) 
  
   { // handle the form.

 
   $uid4 = $_POST["uid4"];
   $vendor_code = $_POST["vendor_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
  
   
   $plant_cd_chk = '3100';
   //echo $plant_cd_chk;
 
 
    //-----generate TP Cancellation Doc. No.
	
				 if($res["plant_code"] == '3100')
				{
				
				 $query_id3 = "SELECT * FROM run_count_itsb WHERE uid = '140'";
				 $result_id3 = mysqli_query($dbc,$query_id3);
				
				}elseif($res["plant_code"] == '3101')
				{
					
				 $query_id3 = "SELECT * FROM run_count_itsb WHERE uid = '142'";
				 $result_id3 = mysqli_query($dbc,$query_id3);
					
				}
				
				if ($result_id3) 
			{
				$nrows3 = mysqli_num_rows($result_id3);
				$row_id3 = mysqli_fetch_array($result_id3);
				
				$dht3 = 00000; 
				$dht_OK3 = "432";
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
				$number3 = sprintf('%03d', $number3);  
				
				$ref3A = (($row_id3["start_ref"]).$dht_OK3.$date_run.($number3));
				  
				
				} // end if $result_id2
 
   
 
 
   
   // --------- pps detail ------------
	 
	   $query_ppsA = "SELECT * FROM tp_subcont_detail WHERE doc_tp = '".sql_esc($uid4)."' AND status_tp = '".sql_esc($rst_sta19["status_desc"])."' ";
	   $result_ppsA = mysqli_query($dbc,$query_ppsA);
	  
	  while($data_pps = mysqli_fetch_array($result_ppsA))
	  
	  {
		  
	  //---------update cancellation--------------------------
	 
	$query_cancelTP = "UPDATE tp_subcont_detail SET status_tp = '".sql_esc($rst_sta4["status_desc"])."', ref_doc_tp = '".sql_esc($ref3A)."', user_cancel = '".sql_esc($username)."', date_cancel = NOW() WHERE id_tp = '".sql_esc($data_pps["id_tp"])."' AND doc_tp = '".sql_esc($uid4)."'";
	$result_cancelTP = mysqli_query($dbc,$query_cancelTP);
	
	
	  //----get detail------
	  
	   $query_dtlA = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS J, DATE_FORMAT(date_create,'%d%m%Y') AS R2 FROM tp_subcont_detail WHERE doc_tp = '".sql_esc($uid4)."' AND id_tp = '".sql_esc($data_pps["id_tp"])."' AND status_tp = '".sql_esc($rst_sta4["status_desc"])."'";
	   $result_dtlA = mysqli_query($dbc,$query_dtlA);
	   $row_infoA = mysqli_fetch_array($result_dtlA);
	  
		  
	 //insert into table tp_store_detail_canc------------
	
$query_data2A = "INSERT INTO tp_subcont_detail_canc(id,id_tp,doc_tp,id_scan_tp,scan_doc,item_no,material_no, material_desc,plan_no,doc_no,plant_code,sloc_from,sloc_to,qty_tp,uom_tp,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_tp,date_generate_tp,ref_doc_tp,user_cancel,date_cancel,status_ftp,status_tran,status_tp,barcode_gr,gr_doc_no,SAP_ref_doc,SAP_ref_doc_can,vendor_no,drv_name,plate_no) VALUES('','".sql_esc($row_infoA["id_tp"])."','".sql_esc($row_infoA["doc_tp"])."','".sql_esc($row_infoA["id_scan_tp"])."','".sql_esc($row_infoA["scan_doc"])."','".sql_esc($row_infoA["item_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["plan_no"])."','".sql_esc($row_infoA["doc_no"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["sloc_from"])."','".sql_esc($row_infoA["sloc_to"])."','".sql_esc($row_infoA["qty_tp"])."','".sql_esc($row_infoA["uom_tp"])."','".sql_esc($row_infoA["posting_date"])."','".sql_esc($row_infoA["shift_day"])."','".sql_esc($row_infoA["model_code"])."','".sql_esc($row_infoA["material_type"])."','".sql_esc($row_infoA["stamp_ind"])."','".sql_esc($row_infoA["slip_no"])."','".sql_esc($row_infoA["user_create"])."','".sql_esc($row_infoA["date_create"])."','".sql_esc($row_infoA["user_generate_tp"])."','".sql_esc($row_infoA["date_generate_tp"])."','".sql_esc($ref3A)."','".sql_esc($username)."',NOW(),'".sql_esc($row_infoA["status_ftp"])."','".sql_esc($row_infoA["status_tran"])."','".sql_esc($row_infoA["status_tp"])."','".sql_esc($row_infoA["barcode_gr"])."','".sql_esc($row_infoA["gr_doc_no"])."','','','".sql_esc($row_infoA["vendor_no"])."','".sql_esc($row_infoA["drv_name"])."','".sql_esc($row_infoA["plate_no"])."')";
$result_data2A = mysqli_query($dbc,$query_data2A);   


   //----checking ftp tp_cancel_store-------
     $data_rcvV2 = "";
	
	 $filen_rcvV2 = "TS".$ref3A; 


  //-----prepared by------
		 $query_prepV = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$row_infoA["user_generate_tp"]]);
		 $result_prepV = db_query($dbc, $query_prepV) or die (mysqli_error());
		 $data_prepV = mysqli_fetch_array($result_prepV);
		 
		 //----quantity-----
		 $qty_new = (intval($row_infoA["qty_tp"]));
		 
		 //----Posting Date Year
		 $post_yr = substr($row_infoA["date_cancel"],0,4);



         $data_rcvV2 .= $row_infoA["plant_code"].";".$row_infoA["ref_doc_tp"].";".$row_infoA["doc_tp"].";".$row_infoA["J"].";".$post_yr.";542;".$row_infoA["user_generate_tp"]."\r\n";
   


  
     //----------update table ftp_qc_received_detail------------
   
     $query_rcv_ftp_infoV2 = "INSERT INTO ftp_tp_cancel_subcont(id,file_name,doc_tp,ref_doc_tp,id_tp,plan_no,material_no,material_desc,qty_ftp,uom,plant,shift_day,slip_no,mvt_type,status_ftp,posting_date,posting_time,sloc_from,sloc_to,prepared_by,user_create,date_create) VALUES('','".sql_esc($filen_rcvV2)."','".sql_esc($row_infoA["doc_tp"])."','".sql_esc($ref3A)."','".sql_esc($row_infoA["id_tp"])."','".sql_esc($row_infoA["plan_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["qty_tp"])."','".sql_esc($row_infoA["uom_tp"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["shift_day"])."','".sql_esc($row_infoA["slip_no"])."','312','Y','".sql_esc($row_infoA["date_cancel"])."',NOW(),'".sql_esc($row_infoA["sloc_from"])."','".sql_esc($row_infoA["sloc_to"])."','".sql_esc($data_prepV["user_fullname"])."','".sql_esc($username)."',NOW())"; 
     $rst_rcv_ftp_infoV2 = mysqli_query($dbc,$query_rcv_ftp_infoV2);
				  
		  
	  }

		$file_rcvV2 = "../FromPortal2/TS/".$filen_rcvV2.".csv";
		file_put_contents($file_rcvV2,$data_rcvV2);
				
    //---------------------------------------end ftp -------------------------------------------------   
		 
	 // if($result_cancel)
	// { 
	 
	         if($res["plant_code"] == '3100')
				{
				
	   $query_max_A = "UPDATE run_count_itsb SET count_max = '".sql_esc($number3)."', date_updated = NOW() WHERE uid = '140'";
	   $result_max_A = mysqli_query($dbc,$query_max_A);
				
				}elseif($res["plant_code"] == '3101')
				{
	 
	   $query_max_A = "UPDATE run_count_itsb SET count_max = '".sql_esc($number3)."', date_updated = NOW() WHERE uid = '142'";
	   $result_max_A = mysqli_query($dbc,$query_max_A);
	 
				}
	 
	 
	 

		   echo "<script>";
		   echo "alert('Material Document $ref3A posted.');";
		   echo "window.location='can_tp_subcontProc2.php?vendor_code=$vendor_code&&date1=$dateF&&date2=$dateT'";
	       echo "</script>"; 
		   exit(); //quit the script
		
   // }


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteCancel<?php echo html_esc($row["doc_tp"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Cancellation Transfer to Subcont</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
        <div class="content mt-12">
   
  <?php
  
            $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$vendor_code = $_GET["vendor_code"];
	
				 $where_sql = '';
				 
				 
				 
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);
				 		
		  // 1. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND (posting_date >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 2. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (posting_date <= '".sql_esc($date2_final)."')"; } 
					 	 
			//3. Vendor Code
                if (($vendor_code == "") || ($vendor_code == "NULL")){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND vendor_no = '".sql_esc($vendor_code)."'"; }  	
					
	                              
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03;	
	
	//********** END CONDITION **************
	
$queryu2 = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as R FROM tp_subcont_detail WHERE doc_tp = '".sql_esc($row["doc_tp"])."' AND status_tp = '".sql_esc($rst_sta19["status_desc"])."' AND status_tran = 'Y'" .$where_sql." ORDER BY doc_tp ASC";
$rs2 = mysqli_query($dbc,$queryu2);   //run the query.
$db_rs2 = mysqli_fetch_array($rs2);


 ?>

    <?php       
          //--------- pps detail ------------
	 
	   $query_pps_dtl = "SELECT * FROM tp_subcont_detail WHERE doc_tp = '".sql_esc($row["doc_tp"])."'";
	   $result_pps_dtl = mysqli_query($dbc,$query_pps_dtl);   
	   $data_pps_dtl = mysqli_fetch_array($result_pps_dtl);
	   
	   
	   ?>

<br>

        <div class="content mt-12"><h3>Are you sure to cancel transfer?</h3><br>
      <!--  <h5>Delete Material Doc. Number : <?php //echo $row["doc_tp"]; ?>?</h5>-->


    <form name="frmSearch" id="frmSearch" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" class="needs-validation"  novalidate>

    <?php
   
   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   
$query_displayA = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as R FROM tp_subcont_detail WHERE doc_tp = '".sql_esc($row["doc_tp"])."' AND status_tp = '".sql_esc($rst_sta19["status_desc"])."' AND status_tran = 'Y'" .$where_sql." ORDER BY doc_tp ASC";
$result_displayA = mysqli_query($dbc,$query_displayA);   //run the query.
   
   while($row2A = mysqli_fetch_array($result_displayA))
   {
	 
      ?>
     
       
      <input name="uid4" type="hidden" value="<?php echo html_esc($row["doc_tp"]); ?> ">    
      <input name="vendor_code"  type="hidden" id="vendor_code" value="<?php echo html_esc($_GET["vendor_code"]); ?>">
      <input name="date1" type="hidden" id="date1" value="<?php echo html_esc($_GET["date1"]); ?>">
      <input name="date2" type="hidden" id="date2" value="<?php echo html_esc($_GET["date2"]); ?>">
      
      <?php 
		  
		  $no4++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  
      
     <div class="modal-footer pull-left">
      <input name="cancTP_btn" type="submit"  class="btn btn-success btn-sm" value="YES" />
              
             <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">NO</button>
             </div> 

  </form>
                <!--  </div>--></div>
                  </div>
                  </div>
                  </div>
                  </div>
               
</body>
</html>