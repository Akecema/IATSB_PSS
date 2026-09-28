<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "canC_bf_tran_NG-prdProc.php"; 
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

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Pending Approved)
$sta15 = "SELECT * from request_status WHERE status_id = '15'";
$sta_res15 = mysqli_query($dbc,$sta15);
$rst_sta15 = mysqli_fetch_array($sta_res15);

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

//CR status (Return GRA)
$sta26 = "SELECT * from request_status WHERE status_id = '26'";
$sta_res26 = mysqli_query($dbc,$sta26);
$rst_sta26 = mysqli_fetch_array($sta_res26);

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);		

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
  if(isset($_POST["can_BFPENDbtn"])) 
  
   { // handle the form.

 
   $uid3 = $_POST["uid3"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   $trans_opt = $_POST["trans_opt"]; 
   $work_center = $_POST["work_center"];
   $material_no = $_POST["material_no"]; 
 
   
   // echo $uid3;
	
	//-------------------generate backflush Pending Cancel doc no.---------------
	
	 if($_POST["plant_code"] == '3100')
	{
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '16'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($_POST["plant_code"] == '3101')
	{
		
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '71'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "232";
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
    $number2 = sprintf('%03d', $number2);  
	
    $ref2 = (($row_id2["start_ref"]).$dht_OK2.$date_run.($number2));
	  
	
	} // end if $result_id2

	
   
    //--------- pps_detail_trn_fg_ok detail ------------
	 
	   $query_info5 = "SELECT * FROM pps_detail_trn_fg_pending WHERE bflush_no = '".sql_esc($uid3)."' AND status_pps = '".sql_esc($rst_sta7["status_desc"])."' ";
	   $result_info5 = mysqli_query($dbc,$query_info5);
	  
	  while($data_info5 = mysqli_fetch_array($result_info5))
	  
	  {
		  
	 // ---------update cancellation--------------------------
	 
	$query_cancelBFOK = "UPDATE pps_detail_trn_fg_pending SET status_pps = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), bflush_no_ref = '".sql_esc($ref2)."' WHERE bflush_no = '".sql_esc($uid3)."' AND status_pps = '".sql_esc($rst_sta7["status_desc"])."'";
	$result_cancelBFOK = mysqli_query($dbc,$query_cancelBFOK);
	

	  
	   $query_infoB = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM pps_detail_trn_fg_pending WHERE bflush_no = '".sql_esc($uid3)."' AND id = '".sql_esc($data_info5["id"])."' AND status_pps = '".sql_esc($rst_sta4["status_desc"])."'";
	   $result_infoB = mysqli_query($dbc,$query_infoB);
	   $row_infoB = mysqli_fetch_array($result_infoB);
	   
	   
	//---------insert data at table pps_detail_trn_fg_ok_cancel
	
	
		
		  $query_store = "INSERT INTO pps_detail_trn_fg_pending_cancel(id,id_fg,pps_id,ref_id,bflush_no,plan_no,id_scan,upload_id,model_code,month_plan,material_no,material_desc,material_type,qty_plan,qty_actual,qty_balance,qty_NG,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,time_posting,ploc,delivery_loc,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,status_ftp_bflush,bflush_no_ref,user_cancel,date_cancel,remark_cancel,plant_code,shift_posting,stamp_ind,remark_pend,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoB["id"])."','".sql_esc($row_infoB["pps_id"])."','".sql_esc($row_infoB["ref_id"])."','".sql_esc($row_infoB["bflush_no"])."','".sql_esc($row_infoB["plan_no"])."','".sql_esc($row_infoB["id_scan"])."','".sql_esc($row_infoB["upload_id"])."','".sql_esc($row_infoB["model_code"])."','".sql_esc($row_infoB["month_plan"])."','".sql_esc($row_infoB["material_no"])."','".sql_esc($row_infoB["material_desc"])."','".sql_esc($row_infoB["material_type"])."','".sql_esc($row_infoB["qty_plan"])."','".sql_esc($row_infoB["qty_actual"])."','".sql_esc($row_infoB["qty_balance"])."','".sql_esc($row_infoB["qty_NG"])."','".sql_esc($row_infoB["status_pps"])."','".sql_esc($row_infoB["comp_code"])."','".sql_esc($row_infoB["work_center"])."','".sql_esc($row_infoB["shift_pps1"])."','".sql_esc($row_infoB["shift_pps2"])."','".sql_esc($row_infoB["date_plan"])."','".sql_esc($row_infoB["status"])."','".sql_esc($row_infoB["user_upload"])."','".sql_esc($row_infoB["date_upload"])."','".sql_esc($row_infoB["user_create"])."','".sql_esc($row_infoB["date_create"])."','".sql_esc($row_infoB["user_update"])."','".sql_esc($row_infoB["date_update"])."','".sql_esc($row_infoB["user_posting"])."','".sql_esc($row_infoB["date_posting"])."','".sql_esc($row_infoB["time_posting"])."','".sql_esc($row_infoB["ploc"])."','".sql_esc($row_infoB["delivery_loc"])."','".sql_esc($row_infoB["proc_reject"])."','".sql_esc($row_infoB["type_reject"])."','".sql_esc($row_infoB["type_defect"])."','".sql_esc($row_infoB["reason_reject"])."','".sql_esc($row_infoB["user_reject"])."','".sql_esc($row_infoB["date_reject"])."','".sql_esc($row_infoB["time_reject"])."','".sql_esc($row_infoB["status_ftp_bflush"])."','".sql_esc($row_infoB["bflush_no_ref"])."','".sql_esc($row_infoB["user_cancel"])."','".sql_esc($row_infoB["date_cancel"])."','".sql_esc($row_infoB["remark_cancel"])."','".sql_esc($row_infoB["plant_code"])."','".sql_esc($row_infoB["shift_posting"])."','".sql_esc($row_infoB["stamp_ind"])."','".sql_esc($row_infoB["remark_pend"])."','".sql_esc($row_infoB["back_no"])."','".sql_esc($row_infoB["kanban_no"])."','".sql_esc($row_infoB["SAP_ref_doc"])."','".sql_esc($row_infoB["SAP_ref_doc_can"])."')";        
		  $rst_store = mysqli_query($dbc,$query_store) or die (mysqli_error());
	  
	
   
	  $filen_rcv = "BF".$ref2; 
		   
		   //-----prepared by------
		 $query_prepw = "SELECT * FROM user_detail WHERE username = '".sql_esc($row_infoB["user_cancel"])."'";
		 $result_prepw = mysqli_query($dbc,$query_prepw);
		 $data_prepw = mysqli_fetch_array($result_prepw);
		 
		   //-----material_detail------
		 $query_mt_dtl = "SELECT * FROM mat_master_header WHERE material_no = '".sql_esc($row_infoB["material_no"])."'";
		 $result_mt_dtl = mysqli_query($dbc,$query_mt_dtl);
		 $data_mt_dtl = mysqli_fetch_array($result_mt_dtl);
		 
	
	//Plant;Document No. Cancellation; Document No.;Posting Date;Posting Date Year;Movement Type;Recipient 
   // 2300; 230021201012020001; 2300211010120001;29122020;2020;132;IKHRAM 
        
		// ---get year

		 $tahun_plan = substr($row_infoB["date_posting"],0,4);
		 

$data_rcv .= $row_infoB["plant_code"].";".$row_infoB["bflush_no_ref"].";".$row_infoB["bflush_no"].";".$row_infoB["JD"].";".$tahun_plan.";132;".$data_prepw["user_fullname"]."\r\n";
   

     //----------update table ftp_bflush_detail_fg_pending_cancel------------
	 
  $query_rcv_ftp_info = "INSERT INTO ftp_bflush_detail_fg_pending_cancel(id,file_name,bflush_no_ref,bflush_no,ref_id,plan_no,material_no,material_desc,qty_ftp,uom,status_ftp,posting_date,posting_time,user_create,date_create,plant_code,stamp_ind) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($ref2)."','".sql_esc($row_infoB["bflush_no"])."','".sql_esc($row_infoB["ref_id"])."','".sql_esc($row_infoB["plan_no"])."','".sql_esc($row_infoB["material_no"])."','".sql_esc($row_infoB["material_desc"])."','".sql_esc($row_infoB["qty_actual"])."','".sql_esc($data_mt_dtl["BUn"])."','Y','".sql_esc($row_infoB["date_posting"])."','".sql_esc($row_infoB["time_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($row_infoB["plant_code"])."','".sql_esc($row_infoB["stamp_ind"])."')"; 
     $rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
	 
		  
	
	  }
	  
	    $file_rcv = "../FromPortal/BF_PENDING/".$filen_rcv.".csv";
		file_put_contents($file_rcv,$data_rcv);
 	 
	/*  if($result_cancel)
	 { */
	 
		  //update count_max----------------------------------------
	        if($_POST["plant_code"] == '3100')
		{
	  
		   $query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '16'";
		   $result_max_aA = mysqli_query($dbc,$query_max_aA);

	
		}elseif($_POST["plant_code"] == '3101')
		{
		   $query_max_bB = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '71'";
		   $result_max_bB = mysqli_query($dbc,$query_max_bB);
		   

		}
	 

		   echo "<script>";
		   echo "alert('Material Document $ref2 posted.');";
		   echo "window.location='canC_bf_tran_PEND-prdProc.php?plant_code=$plant_code&&trans_opt=$trans_opt&&date1=$dateF&&date2=$dateT&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
	       echo "</script>"; 
		   exit(); //quit the script
		
    //}


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteCancelBFPEND<?php echo html_esc($row["bflush_no"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Cancellation Backflush</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
        <div class="content mt-12">
   
  <?php
  
            $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plant_code = $_GET["plant_code"];
		    $trans_opt = $_GET["trans_opt"]; 
			
			
			
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);

		    //1. Plant Code
                if (($plant_code == "") || ($plant_code == "NULL")){ 
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND plant_code = '".sql_esc($plant_code)."'"; }  	
					
		   // 2. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (date_posting >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //3. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
					$wheresql_03 = " AND (date_posting <= '".sql_esc($date2_final)."')"; }
					
					
		 //4. Work Center
                if ($work_center == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND work_center = '".sql_esc($work_center)."'"; }
   
	       //5. Part Number
                if ($material_no == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND material_no = '".sql_esc($material_no)."'"; }  	
					
		
	                                        
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;
	
	//********** END CONDITION **************
	
	
 ?>

  

<br>

        <div class="content mt-12"><h5>Cancel Backflush Pending <?php echo html_esc($row["bflush_no"]); ?>?</h5><br>
       

    <form name="frmSearch" id="frmSearch" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" class="needs-validation"  novalidate>

    <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM pps_detail_trn_fg_pending WHERE bflush_no = '".sql_esc($row["bflush_no"])."' AND status_pps = '".sql_esc($rst_sta7["status_desc"])."' " .$where_sql." ORDER BY bflush_no ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   
   while($row2 = mysqli_fetch_array($result_display))
   {

      ?>
     
       <input name="uid3" type="hidden" value="<?php echo html_esc($row2["bflush_no"]); ?> ">    
       <input name="date1" type="hidden" value="<?php echo $dateF; ?>"> 
       <input name="date2" type="hidden" value="<?php echo $dateT; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
       <input name="trans_opt" type="hidden" value="<?php echo $trans_opt; ?>"> 
       <input name="work_center" type="hidden" value="<?php echo html_esc($work_center); ?>">  
       <input name="material_no" type="hidden" value="<?php echo html_esc($material_no); ?>">   
      
      <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  
      
     <div class="modal-footer pull-left">
      <input name="can_BFPENDbtn" type="submit"  class="btn btn-success btn-sm" value="PROCEED" />
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