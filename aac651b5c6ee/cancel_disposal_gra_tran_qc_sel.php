<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "canC_gra_tran_qcProc.php"; 
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

//CR status (Pending Approval Exec QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

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
  if(isset($_POST["cancel_btn2"])) 
  
   { // handle the form.

 
   $uid2 = $_POST["uid2"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
	
	//-------------------generate gra QC doc no.---------------
	
	 if($_POST["plant_code"] == '3100')
	{
	
	 $query_id2A = "SELECT * FROM run_count_itsb WHERE uid = '32'";
	 $result_id2A = mysqli_query($dbc,$query_id2A);
	
	}elseif($_POST["plant_code"] == '3101')
	{
		
	 $query_id2A = "SELECT * FROM run_count_itsb WHERE uid = '81'";
	 $result_id2A = mysqli_query($dbc,$query_id2A);
		
	}
	
	if ($result_id2A) 
{
	$nrows2A = mysqli_num_rows($result_id2A);
	$row_id2A = mysqli_fetch_array($result_id2A);
	
	$dht2A = 00000; 
	$dht_OK2A = "362";
	$dg2A = 0;

  	if($row_id2A["count_max"] <= 0)
  	{ 
   
    	$lastID2A = ($row_id2A["count_max"] + 1);
    	$dg2A = ($dht2A + ($lastID2A));
   }
   else
   {
      $lastID2A = ($row_id2A["count_max"] + 1);
      $dg2A =  $lastID2A;
	
    }
	$number2A = $dg2A; // Length of running no
    $number2A = sprintf('%03d', $number2A);  
	
    $ref2 = (($row_id2A["start_ref"]).$dht_OK2A.$date_run.($number2A));
	  
	
	} // end if $result_id2

	
   
    //--------- Disposal QC detail ------------
	 
	   $query_info5A = "SELECT * FROM gra_disposal_qc_detail WHERE doc_dis = '".sql_esc($uid2)."' AND (status_dis = '".sql_esc($rst_sta29["status_desc"])."')";
	   $result_info5A = mysqli_query($dbc,$query_info5A);
	  
	  while($data_info5A = mysqli_fetch_array($result_info5A))
	  
	  {
		  
	 // ---------update cancellation--------------------------
	 
	$query_cancelA = "UPDATE gra_disposal_qc_detail SET status_dis = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), ref_doc_dis = '".sql_esc($ref2)."' WHERE doc_dis = '".sql_esc($uid2)."' AND (status_dis = '".sql_esc($rst_sta29["status_desc"])."')";
	$result_cancelA = mysqli_query($dbc,$query_cancelA);
	
	
	  
	   $query_infoA = "SELECT *, DATE_FORMAT(posting_date,'%d%m%Y') AS J FROM gra_disposal_qc_detail WHERE doc_dis = '".sql_esc($uid2)."' AND id_dis = '".sql_esc($data_info5A["id_dis"])."' AND status_dis = '".sql_esc($rst_sta4["status_desc"])."'";
	   $result_infoA = mysqli_query($dbc,$query_infoA);
	   $row_infoA = mysqli_fetch_array($result_infoA);


//---------insert data at table gra_disposal_qc_detail_cancel - status part = 'WQ'
		
		  $query_store = "INSERT INTO gra_disposal_qc_detail_cancel(id,id_dis,doc_dis,id_scan_dis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,comp_code,plant_code,sloc_from,sloc_to,qty_dis,uom_dis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_dis,date_generate_dis,ref_doc_dis,user_cancel,date_cancel,remark_cancel,status_ftp,status_tran,status_dis,sloc_rej,work_center,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,remark_dis,status_approved1,hod_approved1,date_approved1,remark_approved1,status_approved2,hod_approved2,date_approved2,remark_approved2,status_approved3,hod_approved3,date_approved3,remark_approved3,status_approved4,hod_approved4,date_approved4,remark_approved4,status_part,cost_center,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoA["id_dis"])."','".sql_esc($row_infoA["doc_dis"])."','".sql_esc($row_infoA["id_scan_dis"])."','".sql_esc($row_infoA["scan_doc"])."','".sql_esc($row_infoA["item_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["plan_no"])."','".sql_esc($row_infoA["doc_no"])."','".sql_esc($row_infoA["comp_code"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["sloc_from"])."','".sql_esc($row_infoA["sloc_to"])."','".sql_esc($row_infoA["qty_dis"])."','".sql_esc($row_infoA["uom_dis"])."','".sql_esc($row_infoA["posting_date"])."','".sql_esc($row_infoA["shift_day"])."','".sql_esc($row_infoA["model_code"])."','".sql_esc($row_infoA["material_type"])."','".sql_esc($row_infoA["stamp_ind"])."','".sql_esc($row_infoA["slip_no"])."','".sql_esc($row_infoA["user_create"])."','".sql_esc($row_infoA["date_create"])."','".sql_esc($row_infoA["user_generate_gra"])."','".sql_esc($row_infoA["date_generate_gra"])."','".sql_esc($row_infoA["ref_doc_dis"])."','".sql_esc($username)."',NOW(),'".sql_esc($row_infoA["remark_cancel"])."','".sql_esc($row_infoA["status_ftp"])."','".sql_esc($row_infoA["status_tran"])."','".sql_esc($row_infoA["status_dis"])."','".sql_esc($row_infoA["sloc_rej"])."','".sql_esc($row_infoA["work_center"])."','".sql_esc($row_infoA["proc_reject"])."','".sql_esc($row_infoA["type_reject"])."','".sql_esc($row_infoA["type_defect"])."','".sql_esc($row_infoA["reason_reject"])."','".sql_esc($row_infoA["user_reject"])."','".sql_esc($row_infoA["date_reject"])."','".sql_esc($row_infoA["time_reject"])."','".sql_esc($row_infoA["remark_dis"])."','".sql_esc($row_infoA["status_approved1"])."','".sql_esc($row_infoA["hod_approved1"])."','".sql_esc($row_infoA["date_approved1"])."','".sql_esc($row_infoA["remark_approved1"])."','".sql_esc($row_infoA["status_approved2"])."','".sql_esc($row_infoA["hod_approved2"])."','".sql_esc($row_infoA["date_approved2"])."','".sql_esc($row_infoA["remark_approved2"])."','".sql_esc($row_infoA["status_approved3"])."','".sql_esc($row_infoA["hod_approved3"])."','".sql_esc($row_infoA["date_approved3"])."','".sql_esc($row_infoA["remark_approved3"])."','".sql_esc($row_infoA["status_approved4"])."','".sql_esc($row_infoA["hod_approved4"])."','".sql_esc($row_infoA["date_approved4"])."','".sql_esc($row_infoA["remark_approved4"])."','".sql_esc($row_infoA["status_part"])."','".sql_esc($row_infoA["cost_center"])."','','')";          
		 /* $rst_store = mysqli_query($dbc,$query_store);*/
		  $rst_store = mysqli_query($dbc,$query_store) or die (mysqli_error());
		  
		   
	$filen_rcv = "DP".$ref2; 
		   
		   //-----prepared by------
		 $query_prepw = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$row_infoA["user_generate_dis"]]);
		 $result_prepw = db_query($dbc, $query_prepw);
		 $data_prepw = mysqli_fetch_array($result_prepw);
		 
		// ----quantity-----
		// $qty_new = (intval($data_rcv_ftp["qty_dis"]));
        
		// ---get year

		 $tahun_plan = substr($row_infoA["posting_date"],0,4);
		 

$data_rcv .= $row_infoA["plant_code"].";".$row_infoA["ref_doc_dis"].";".$row_infoA["doc_dis"].";".$row_infoA["J"].";".$tahun_plan.";552;".$row_infoA["user_generate_dis"]."\r\n";
   

     //----------update table ftp_tp_gra_disposal_qc_cancel------------
   
    $query_rcv_ftp_info = "INSERT INTO ftp_tp_gra_disposal_qc_cancel(id,file_name,ref_doc_dis,doc_dis,id_dis,plan_no,material_no,material_desc,qty_ftp,uom, plant,shift_day,slip_no,mvt_type,status_ftp,posting_date,posting_time,sloc_from,sloc_to,work_center,proc_reject,type_reject,type_defect,reason_reject,cost_center,prepared_by,user_create,date_create) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($row_infoA["ref_doc_dis"])."','".sql_esc($row_infoA["doc_dis"])."','".sql_esc($row_infoA["id_dis"])."','".sql_esc($row_infoA["plan_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["qty_dis"])."','".sql_esc($row_infoA["uom_dis"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["shift_day"])."','".sql_esc($row_infoA["slip_no"])."','552','Y','".sql_esc($row_infoA["posting_date"])."','','".sql_esc($row_infoA["sloc_from"])."','".sql_esc($row_infoA["sloc_to"])."','".sql_esc($row_infoA["work_center"])."','".sql_esc($row_infoA["proc_reject"])."','".sql_esc($row_infoA["type_reject"])."','".sql_esc($row_infoA["type_defect"])."','".sql_esc($row_infoA["reason_reject"])."','".sql_esc($row_infoA["cost_center"])."','".sql_esc($row_infoA["prepared_by"])."','".sql_esc($row_infoA["user_create"])."','".sql_esc($row_infoA["date_create"])."')"; 
     $rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
		  
	
	  }
	  
	    $file_rcv = "../FromPortal2/DP/".$filen_rcv.".csv";
		file_put_contents($file_rcv,$data_rcv);
	  
	
		
	  
 	 
	/*  if($result_cancelA)
	 { */
	 
		  //update count_max----------------------------------------
		 
		  if($_POST["plant_code"] == '3100')
		{
	  
		   $query_max_A = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2A)."', date_updated = NOW() WHERE uid = '32'";
		   $result_max_A = mysqli_query($dbc,$query_max_A);

	
		}elseif($_POST["plant_code"] == '3101')
		{
		   $query_max_B = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2A)."', date_updated = NOW() WHERE uid = '81'";
		   $result_max_B = mysqli_query($dbc,$query_max_B);
		   

		}
	 

		   echo "<script>";
		   echo "alert('Material Document $ref2 posted.');";
		   echo "window.location='canC_disposal_gra_tran_qcProc.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT'";
	       echo "</script>"; 
		   exit(); //quit the script
		
  // }


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteCancelA<?php echo html_esc($row["doc_dis"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Cancellation Disposal</h5>
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
					
		   // 3. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND (posting_date >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (posting_date <= '".sql_esc($date2_final)."')"; }
							

				$where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04;
	
	//********** END CONDITION **************
	
	
 ?>

  

<br>

        <div class="content mt-12"><h5>Are you sure to cancel this transaction?</h5><br>
       

    <form name="frmSearch" id="frmSearch" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" class="needs-validation"  novalidate>

    <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_displayA = "SELECT * FROM gra_disposal_qc_detail WHERE doc_dis = '".sql_esc($row["doc_dis"])."' AND (status_dis = '".sql_esc($rst_sta29["status_desc"])."') " .$where_sql." ORDER BY doc_dis ASC ";
$result_displayA = mysqli_query($dbc,$query_displayA);   //run the query.
   
   while($row2A = mysqli_fetch_array($result_displayA))
   {

      ?>
     
       <input name="uid2" type="hidden" value="<?php echo html_esc($row2A["doc_dis"]); ?> ">    
       <input name="date1" type="hidden" value="<?php echo $dateF; ?>"> 
       <input name="date2" type="hidden" value="<?php echo $dateT; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
   
      <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  
      
     <div class="modal-footer pull-left">
      <input name="cancel_btn2" type="submit"  class="btn btn-success btn-sm" value="YES" />
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