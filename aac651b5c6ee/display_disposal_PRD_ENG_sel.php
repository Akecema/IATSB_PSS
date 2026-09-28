<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "canC_disposal_gra_tranPRDENGProc.php"; 
	require_once('tcpdf_barcodes_2d.php');
	include 'apprv_func_list.php';
	
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

//CR status (Pending Approve)
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
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
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
  if(isset($_POST["canC_DISbtn"])) 
  
   { // handle the form.

 
   $uid6 = $_POST["uid6"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   $trans_opt = $_POST["trans_opt"]; 

		  //-------------------generate gra QC doc no.---------------
	
	 if($_POST["plant_code"] == '3100')
	{
	
	 $query_id2A = "SELECT * FROM run_count_itsb WHERE uid = '107'";
	 $result_id2A = mysqli_query($dbc,$query_id2A);
	
	}elseif($_POST["plant_code"] == '3101')
	{
		
	 $query_id2A = "SELECT * FROM run_count_itsb WHERE uid = '109'";
	 $result_id2A = mysqli_query($dbc,$query_id2A);
		
	}
	
	if ($result_id2A) 
{
	$nrows2A = mysqli_num_rows($result_id2A);
	$row_id2A = mysqli_fetch_array($result_id2A);
	
	$dht2A = 00000; 
	$dht_OK2A = "392";
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
	
    $ref6 = (($row_id2A["start_ref"]).$dht_OK2A.$date_run.($number2A));
	  
	
	} // end if $result_id2

	
	
	 if($trans_opt == "ENG")
	 {
   
    //--------- Disposal PROD ENG detail ------------
	 
	   $query_info5A = "SELECT * FROM gra_disposal_prdeng_detail WHERE doc_dis = '".sql_esc($uid6)."' AND (status_dis = '".sql_esc($rst_sta15["status_desc"])."')";
	   $result_info5A = mysqli_query($dbc,$query_info5A);
	  
	  while($data_info5A = mysqli_fetch_array($result_info5A))
	  
	  {
		  
	 // ---------update cancellation--------------------------
	 
	$query_cancelAr = "UPDATE gra_disposal_prdeng_detail SET status_dis = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), ref_doc_dis = '".sql_esc($ref6)."' WHERE doc_dis = '".sql_esc($uid6)."' AND (status_dis = '".sql_esc($rst_sta15["status_desc"])."')";
	$result_cancelAr = mysqli_query($dbc,$query_cancelAr);
	
	 // ---------update cancellation--------------------------
	 
	$query_cancelArT = "UPDATE disposal_detail_prd_all SET status_disposal = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), disposal_no_ref = '".sql_esc($ref6)."' WHERE doc_dis = '".sql_esc($uid6)."' AND (status_disposal = '".sql_esc($rst_sta15["status_desc"])."')";
	$result_cancelArT = mysqli_query($dbc,$query_cancelArT);
	
	  
	   $query_infoA = "SELECT *, DATE_FORMAT(posting_date,'%d%m%Y') AS J FROM gra_disposal_prdeng_detail WHERE doc_dis = '".sql_esc($uid6)."' AND id_dis = '".sql_esc($data_info5A["id_dis"])."' AND (status_dis = '".sql_esc($rst_sta4["status_desc"])."')";
	   $result_infoA = mysqli_query($dbc,$query_infoA);
	   $row_infoA = mysqli_fetch_array($result_infoA);


//---------insert data at table gra_disposal_qc_detail_cancel - status part = 'WQ'
		
		  $query_storeT = "INSERT INTO gra_disposal_prdeng_detail_cancel(id,id_dis,doc_dis,id_scan_dis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,comp_code,plant_code,sloc_from,sloc_to,qty_dis,uom_dis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_dis,date_generate_dis,ref_doc_dis,user_cancel,date_cancel,remark_cancel,status_ftp,status_tran,status_dis,sloc_rej,work_center,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,remark_dis,status_approved1,hod_approved1,date_approved1,remark_approved1,status_approved2,hod_approved2,date_approved2,remark_approved2,status_approved3,hod_approved3,date_approved3,remark_approved3,status_approved4,hod_approved4,date_approved4,remark_approved4,status_part,cost_center,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoA["id_dis"])."','".sql_esc($row_infoA["doc_dis"])."','".sql_esc($row_infoA["id_scan_dis"])."','".sql_esc($row_infoA["scan_doc"])."','".sql_esc($row_infoA["item_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["plan_no"])."','".sql_esc($row_infoA["doc_no"])."','".sql_esc($row_infoA["comp_code"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["sloc_from"])."','".sql_esc($row_infoA["sloc_to"])."','".sql_esc($row_infoA["qty_dis"])."','".sql_esc($row_infoA["uom_dis"])."','".sql_esc($row_infoA["posting_date"])."','".sql_esc($row_infoA["shift_day"])."','".sql_esc($row_infoA["model_code"])."','".sql_esc($row_infoA["material_type"])."','".sql_esc($row_infoA["stamp_ind"])."','".sql_esc($row_infoA["slip_no"])."','".sql_esc($row_infoA["user_create"])."','".sql_esc($row_infoA["date_create"])."','".sql_esc($row_infoA["user_generate_gra"])."','".sql_esc($row_infoA["date_generate_gra"])."','".sql_esc($row_infoA["ref_doc_dis"])."','".sql_esc($username)."',NOW(),'".sql_esc($row_infoA["remark_cancel"])."','".sql_esc($row_infoA["status_ftp"])."','".sql_esc($row_infoA["status_tran"])."','".sql_esc($row_infoA["status_dis"])."','".sql_esc($row_infoA["sloc_rej"])."','".sql_esc($row_infoA["work_center"])."','".sql_esc($row_infoA["proc_reject"])."','".sql_esc($row_infoA["type_reject"])."','".sql_esc($row_infoA["type_defect"])."','".sql_esc($row_infoA["reason_reject"])."','".sql_esc($row_infoA["user_reject"])."','".sql_esc($row_infoA["date_reject"])."','".sql_esc($row_infoA["time_reject"])."','".sql_esc($row_infoA["remark_dis"])."','".sql_esc($row_infoA["status_approved1"])."','".sql_esc($row_infoA["hod_approved1"])."','".sql_esc($row_infoA["date_approved1"])."','".sql_esc($row_infoA["remark_approved1"])."','".sql_esc($row_infoA["status_approved2"])."','".sql_esc($row_infoA["hod_approved2"])."','".sql_esc($row_infoA["date_approved2"])."','".sql_esc($row_infoA["remark_approved2"])."','".sql_esc($row_infoA["status_approved3"])."','".sql_esc($row_infoA["hod_approved3"])."','".sql_esc($row_infoA["date_approved3"])."','".sql_esc($row_infoA["remark_approved3"])."','".sql_esc($row_infoA["status_approved4"])."','".sql_esc($row_infoA["hod_approved4"])."','".sql_esc($row_infoA["date_approved4"])."','".sql_esc($row_infoA["remark_approved4"])."','".sql_esc($row_infoA["status_part"])."','".sql_esc($row_infoA["cost_center"])."','','')";          
		 /* $rst_store = mysqli_query($dbc,$query_store);*/
		  $rst_storeT = mysqli_query($dbc,$query_storeT) or die (mysqli_error($dbc));
		  
		  
		  //---------------update at table disposal_detail_prd_all [prod ENG]----------
		
	     $query_chk_info = "SELECT * FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid6)."'";
		 $result_chk_info =  mysqli_query($dbc,$query_chk_info);
		 $row_chk_info = mysqli_fetch_array($result_chk_info);
	
	if($row_chk_info > 0)
	{
			
		$query_ins_dis = "INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_chk_info["id"])."','".sql_esc($row_chk_info["id_disposal"])."','".sql_esc($row_chk_info["doc_dis"])."','".sql_esc($row_chk_info["doc_disposal_no"])."','".sql_esc($row_chk_info["bflush_hwork"])."','".sql_esc($row_chk_info["bflush_rework"])."','".sql_esc($row_chk_info["bflush_pending"])."','".sql_esc($row_chk_info["bflush_qqc_no"])."','".sql_esc($row_chk_info["plan_no"])."','".sql_esc($row_chk_info["uid"])."','".sql_esc($row_chk_info["material_no"])."','".sql_esc($row_chk_info["material_desc"])."','".sql_esc($row_chk_info["material_type"])."','".sql_esc($row_chk_info["model_code"])."','".sql_esc($row_chk_info["qty_plan"])."','".sql_esc($row_chk_info["qty_actual"])."','".sql_esc($row_chk_info["qty_balance"])."','".sql_esc($row_chk_info["qty_NG"])."','".sql_esc($row_chk_info["qty_qc"])."','".sql_esc($row_chk_info["qty_qc_ok"])."','".sql_esc($row_chk_info["qty_qc_NG"])."','".sql_esc($row_chk_info["UOM_unit"])."','".sql_esc($row_chk_info["plant_cd"])."','".sql_esc($row_chk_info["work_center"])."','".sql_esc($row_chk_info["shift_day"])."','".sql_esc($row_chk_info["posting_date"])."','".sql_esc($row_chk_info["user_generate_dis"])."','".sql_esc($row_chk_info["date_generate_dis"])."','".sql_esc($row_chk_info["time_generate_dis"])."','".sql_esc($row_chk_info["status_dis"])."','".sql_esc($row_chk_info["sloc_rej"])."','".sql_esc($row_chk_info["sloc_rej"])."','".sql_esc($row_chk_info["sloc_rej"])."','".sql_esc($row_chk_info["proc_reject"])."','".sql_esc($row_chk_info["type_reject"])."','".sql_esc($row_chk_info["type_defect"])."','".sql_esc($row_chk_info["reason_reject"])."','".sql_esc($row_chk_info["user_reject"])."','".sql_esc($row_chk_info["date_reject"])."','".sql_esc($row_chk_info["time_reject"])."','','','','','','','".sql_esc($row_chk_info["user_create"])."','".sql_esc($row_chk_info["date_create"])."','".sql_esc($row_chk_info["remark_dis"])."','".sql_esc($row_chk_info["status_part"])."','','','".sql_esc($row_chk_info["status_approved"])."','".sql_esc($row_chk_info["approved_by"])."','".sql_esc($row_chk_info["date_approved"])."','".sql_esc($row_chk_info["remark_approved"])."','".sql_esc($row_chk_info["status_approved2"])."','".sql_esc($row_chk_info["approved_by2"])."','".sql_esc($row_chk_info["date_approved2"])."','".sql_esc($row_chk_info["remark_approved2"])."','".sql_esc($row_chk_info["status_approved3"])."','".sql_esc($row_chk_info["hod_approved3"])."','".sql_esc($row_chk_info["date_approved3"])."','".sql_esc($row_chk_info["remark_approved3"])."','".sql_esc($row_chk_info["status_approved4"])."','".sql_esc($row_chk_info["approved_by4"])."','".sql_esc($row_chk_info["date_approved4"])."','".sql_esc($row_chk_info["remark_approved4"])."','".sql_esc($row_chk_info["status_approved5"])."','".sql_esc($row_chk_info["approved_by5"])."','".sql_esc($row_chk_info["date_approved5"])."','".sql_esc($row_chk_info["remark_approved5"])."','".sql_esc($row_chk_info["cost_center"])."','".sql_esc($row_chk_info["id_factory"])."','".sql_esc($row_chk_info["disposal_no_ref"])."','".sql_esc($row_chk_info["user_cancel"])."','".sql_esc($row_chk_info["date_cancel"])."','".sql_esc($row_chk_info["remark_cancel"])."','".sql_esc($row_chk_info["plant_cd"])."','".sql_esc($row_chk_info["shift_posting"])."','".sql_esc($row_chk_info["stamp_ind"])."','".sql_esc($row_chk_info["reject_source"])."','".sql_esc($row_chk_info["back_no"])."','".sql_esc($row_chk_info["kanban_no"])."','".sql_esc($row_chk_info["SAP_ref_doc"])."','".sql_esc($row_chk_info["SAP_ref_doc_can"])."')";
$result_ins_dis = mysqli_query($dbc,$query_ins_dis); 

	}
		  
		  
		  
		  
		   
	$filen_rcv = "DP".$ref6; 
		   
		   //-----prepared by------
		 $query_prepw = "SELECT * FROM user_detail WHERE username = '".sql_esc($row_infoA["user_generate_dis"])."'";
		 $result_prepw = mysqli_query($dbc,$query_prepw);
		 $data_prepw = mysqli_fetch_array($result_prepw);
		 
		// ----quantity-----
		// $qty_new = (intval($data_rcv_ftp["qty_dis"]));
        
		// ---get year

		 $tahun_plan = substr($row_infoA["posting_date"],0,4);
		 

$data_rcv .= $row_infoA["plant_code"].";".$row_infoA["ref_doc_dis"].";".$row_infoA["doc_dis"].";".$row_infoA["J"].";".$tahun_plan.";552;".$row_infoA["user_generate_dis"]."\r\n";
   

     //----------update table ftp_tp_gra_disposal_qc_cancel------------
   
    $query_rcv_ftp_info = "INSERT INTO ftp_tp_gra_disposal_eng_cancel(id,file_name,ref_doc_dis,doc_dis,id_dis,plan_no,material_no,material_desc,qty_ftp,uom, plant,shift_day,slip_no,mvt_type,status_ftp,posting_date,posting_time,sloc_from,sloc_to,work_center,proc_reject,type_reject,type_defect,reason_reject,cost_center,prepared_by,user_create,date_create) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($row_infoA["ref_doc_dis"])."','".sql_esc($row_infoA["doc_dis"])."','".sql_esc($row_infoA["id_dis"])."','".sql_esc($row_infoA["plan_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["qty_dis"])."','".sql_esc($row_infoA["uom_dis"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["shift_day"])."','".sql_esc($row_infoA["slip_no"])."','552','Y','".sql_esc($row_infoA["posting_date"])."','','".sql_esc($row_infoA["sloc_from"])."','".sql_esc($row_infoA["sloc_to"])."','".sql_esc($row_infoA["work_center"])."','".sql_esc($row_infoA["proc_reject"])."','".sql_esc($row_infoA["type_reject"])."','".sql_esc($row_infoA["type_defect"])."','".sql_esc($row_infoA["reason_reject"])."','".sql_esc($row_infoA["cost_center"])."','".sql_esc($row_infoA["prepared_by"])."','".sql_esc($row_infoA["user_create"])."','".sql_esc($row_infoA["date_create"])."')"; 
     $rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
		  
	
	  }
	  
	  //$file_rcv = "../FromPortal2/DP/".$filen_rcv.".csv";
		//file_put_contents($file_rcv,$data_rcv);
	  
	
		
	 }else{
		 
		 
		 
		  //--------- Disposal PROD ENG COMPONENT REJECT detail ------------
	 
	   $query_info5A = "SELECT * FROM prd_creject_detail_eng WHERE doc_dis = '".sql_esc($uid6)."' AND (status_dis = '".sql_esc($rst_sta15["status_desc"])."')";
	   $result_info5A = mysqli_query($dbc,$query_info5A);
	  
	  while($data_info5A = mysqli_fetch_array($result_info5A))
	  {
			  
	 // ---------update cancellation--------------------------
	 
	$query_cancelAr = "UPDATE prd_creject_detail_eng SET status_dis = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), ref_doc_dis = '".sql_esc($ref6)."' WHERE doc_dis = '".sql_esc($uid6)."' AND (status_dis = '".sql_esc($rst_sta15["status_desc"])."')";
	$result_cancelAr = mysqli_query($dbc,$query_cancelAr);
	
	 // ---------update cancellation--------------------------
	 
	$query_cancelArT = "UPDATE disposal_detail_prd_all SET status_disposal = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), disposal_no_ref = '".sql_esc($ref6)."' WHERE doc_dis = '".sql_esc($uid6)."' AND (status_disposal = '".sql_esc($rst_sta15["status_desc"])."')";
	$result_cancelArT = mysqli_query($dbc,$query_cancelArT);
	
	  
	   $query_infoA = "SELECT *, DATE_FORMAT(posting_date,'%d%m%Y') AS J FROM prd_creject_detail_eng WHERE doc_dis = '".sql_esc($uid6)."' AND (status_dis = '".sql_esc($rst_sta4["status_desc"])."')";
	   $result_infoA = mysqli_query($dbc,$query_infoA);
	   $row_infoA = mysqli_fetch_array($result_infoA);


//---------insert data at table gra_disposal_qc_detail_cancel - status part = 'WQ'
		/*
		  $query_storeT = "INSERT INTO gra_disposal_prdeng_detail_cancel(id,id_dis,doc_dis,id_scan_dis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,comp_code,plant_code,sloc_from,sloc_to,qty_dis,uom_dis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_dis,date_generate_dis,ref_doc_dis,user_cancel,date_cancel,remark_cancel,status_ftp,status_tran,status_dis,sloc_rej,work_center,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,remark_dis,status_approved1,hod_approved1,date_approved1,remark_approved1,status_approved2,hod_approved2,date_approved2,remark_approved2,status_approved3,hod_approved3,date_approved3,remark_approved3,status_approved4,hod_approved4,date_approved4,remark_approved4,status_part,cost_center,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".$row_infoA["id_dis"]."','".$row_infoA["doc_dis"]."','".$row_infoA["id_scan_dis"]."','".$row_infoA["scan_doc"]."','".$row_infoA["item_no"]."','".$row_infoA["material_no"]."','".$row_infoA["material_desc"]."','".$row_infoA["plan_no"]."','".$row_infoA["doc_no"]."','".$row_infoA["comp_code"]."','".$row_infoA["plant_code"]."','".$row_infoA["sloc_from"]."','".$row_infoA["sloc_to"]."','".$row_infoA["qty_dis"]."','".$row_infoA["uom_dis"]."','".$row_infoA["posting_date"]."','".$row_infoA["shift_day"]."','".$row_infoA["model_code"]."','".$row_infoA["material_type"]."','".$row_infoA["stamp_ind"]."','".$row_infoA["slip_no"]."','".$row_infoA["user_create"]."','".$row_infoA["date_create"]."','".$row_infoA["user_generate_gra"]."','".$row_infoA["date_generate_gra"]."','".$row_infoA["ref_doc_dis"]."','".$username."',NOW(),'".$row_infoA["remark_cancel"]."','".$row_infoA["status_ftp"]."','".$row_infoA["status_tran"]."','".$row_infoA["status_dis"]."','".$row_infoA["sloc_rej"]."','".$row_infoA["work_center"]."','".$row_infoA["proc_reject"]."','".$row_infoA["type_reject"]."','".$row_infoA["type_defect"]."','".$row_infoA["reason_reject"]."','".$row_infoA["user_reject"]."','".$row_infoA["date_reject"]."','".$row_infoA["time_reject"]."','".$row_infoA["remark_dis"]."','".$row_infoA["status_approved1"]."','".$row_infoA["hod_approved1"]."','".$row_infoA["date_approved1"]."','".$row_infoA["remark_approved1"]."','".$row_infoA["status_approved2"]."','".$row_infoA["hod_approved2"]."','".$row_infoA["date_approved2"]."','".$row_infoA["remark_approved2"]."','".$row_infoA["status_approved3"]."','".$row_infoA["hod_approved3"]."','".$row_infoA["date_approved3"]."','".$row_infoA["remark_approved3"]."','".$row_infoA["status_approved4"]."','".$row_infoA["hod_approved4"]."','".$row_infoA["date_approved4"]."','".$row_infoA["remark_approved4"]."','".$row_infoA["status_part"]."','".$row_infoA["cost_center"]."','','')";          
		 /* $rst_store = mysqli_query($dbc,$query_store);*/
		 /* $rst_storeT = mysqli_query($dbc,$query_storeT) or die (mysqli_error());
		  */
		  
		  //---------------update at table disposal_detail_prd_all [prod ENG]----------
		
	     $query_chk_info = "SELECT * FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid6)."'";
		 $result_chk_info =  mysqli_query($dbc,$query_chk_info);
		 $row_chk_info = mysqli_fetch_array($result_chk_info);
	
	if($row_chk_info > 0)
	{
			
		$query_ins_dis = "INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_chk_info["id"])."','".sql_esc($row_chk_info["id_disposal"])."','".sql_esc($row_chk_info["doc_dis"])."','".sql_esc($row_chk_info["doc_disposal_no"])."','".sql_esc($row_chk_info["bflush_hwork"])."','".sql_esc($row_chk_info["bflush_rework"])."','".sql_esc($row_chk_info["bflush_pending"])."','".sql_esc($row_chk_info["bflush_qqc_no"])."','".sql_esc($row_chk_info["plan_no"])."','".sql_esc($row_chk_info["uid"])."','".sql_esc($row_chk_info["material_no"])."','".sql_esc($row_chk_info["material_desc"])."','".sql_esc($row_chk_info["material_type"])."','".sql_esc($row_chk_info["model_code"])."','".sql_esc($row_chk_info["qty_plan"])."','".sql_esc($row_chk_info["qty_actual"])."','".sql_esc($row_chk_info["qty_balance"])."','".sql_esc($row_chk_info["qty_NG"])."','".sql_esc($row_chk_info["qty_qc"])."','".sql_esc($row_chk_info["qty_qc_ok"])."','".sql_esc($row_chk_info["qty_qc_NG"])."','".sql_esc($row_chk_info["UOM_unit"])."','".sql_esc($row_chk_info["plant_cd"])."','".sql_esc($row_chk_info["work_center"])."','".sql_esc($row_chk_info["shift_day"])."','".sql_esc($row_chk_info["posting_date"])."','".sql_esc($row_chk_info["user_generate_dis"])."','".sql_esc($row_chk_info["date_generate_dis"])."','".sql_esc($row_chk_info["time_generate_dis"])."','".sql_esc($row_chk_info["status_dis"])."','".sql_esc($row_chk_info["sloc_rej"])."','".sql_esc($row_chk_info["sloc_rej"])."','".sql_esc($row_chk_info["sloc_rej"])."','".sql_esc($row_chk_info["proc_reject"])."','".sql_esc($row_chk_info["type_reject"])."','".sql_esc($row_chk_info["type_defect"])."','".sql_esc($row_chk_info["reason_reject"])."','".sql_esc($row_chk_info["user_reject"])."','".sql_esc($row_chk_info["date_reject"])."','".sql_esc($row_chk_info["time_reject"])."','','','','','','','".sql_esc($row_chk_info["user_create"])."','".sql_esc($row_chk_info["date_create"])."','".sql_esc($row_chk_info["remark_dis"])."','".sql_esc($row_chk_info["status_part"])."','','','".sql_esc($row_chk_info["status_approved"])."','".sql_esc($row_chk_info["approved_by"])."','".sql_esc($row_chk_info["date_approved"])."','".sql_esc($row_chk_info["remark_approved"])."','".sql_esc($row_chk_info["status_approved2"])."','".sql_esc($row_chk_info["approved_by2"])."','".sql_esc($row_chk_info["date_approved2"])."','".sql_esc($row_chk_info["remark_approved2"])."','".sql_esc($row_chk_info["status_approved3"])."','".sql_esc($row_chk_info["hod_approved3"])."','".sql_esc($row_chk_info["date_approved3"])."','".sql_esc($row_chk_info["remark_approved3"])."','".sql_esc($row_chk_info["status_approved4"])."','".sql_esc($row_chk_info["approved_by4"])."','".sql_esc($row_chk_info["date_approved4"])."','".sql_esc($row_chk_info["remark_approved4"])."','".sql_esc($row_chk_info["status_approved5"])."','".sql_esc($row_chk_info["approved_by5"])."','".sql_esc($row_chk_info["date_approved5"])."','".sql_esc($row_chk_info["remark_approved5"])."','".sql_esc($row_chk_info["cost_center"])."','".sql_esc($row_chk_info["id_factory"])."','".sql_esc($row_chk_info["disposal_no_ref"])."','".sql_esc($row_chk_info["user_cancel"])."','".sql_esc($row_chk_info["date_cancel"])."','".sql_esc($row_chk_info["remark_cancel"])."','".sql_esc($row_chk_info["plant_cd"])."','".sql_esc($row_chk_info["shift_posting"])."','".sql_esc($row_chk_info["stamp_ind"])."','".sql_esc($row_chk_info["reject_source"])."','".sql_esc($row_chk_info["back_no"])."','".sql_esc($row_chk_info["kanban_no"])."','".sql_esc($row_chk_info["SAP_ref_doc"])."','".sql_esc($row_chk_info["SAP_ref_doc_can"])."')";
$result_ins_dis = mysqli_query($dbc,$query_ins_dis); 

	}
		  
		  
		  
		  
		   
	$filen_rcv = "DP".$ref6; 
		   
		   //-----prepared by------
		 $query_prepw = "SELECT * FROM user_detail WHERE username = '".sql_esc($row_infoA["user_generate_dis"])."'";
		 $result_prepw = mysqli_query($dbc,$query_prepw);
		 $data_prepw = mysqli_fetch_array($result_prepw);
		 
		// ----quantity-----
		// $qty_new = (intval($data_rcv_ftp["qty_dis"]));
        
		// ---get year

		 $tahun_plan = substr($row_infoA["posting_date"],0,4);
		 

$data_rcv .= $row_infoA["plant_code"].";".$row_infoA["ref_doc_dis"].";".$row_infoA["doc_dis"].";".$row_infoA["J"].";".$tahun_plan.";552;".$row_infoA["user_generate_dis"]."\r\n";
   

     //----------update table ftp_tp_gra_disposal_qc_cancel------------
   
    $query_rcv_ftp_info = "INSERT INTO ftp_tp_gra_disposal_eng_cancel(id,file_name,ref_doc_dis,doc_dis,id_dis,plan_no,material_no,material_desc,qty_ftp,uom, plant,shift_day,slip_no,mvt_type,status_ftp,posting_date,posting_time,sloc_from,sloc_to,work_center,proc_reject,type_reject,type_defect,reason_reject,cost_center,prepared_by,user_create,date_create) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($row_infoA["ref_doc_dis"])."','".sql_esc($row_infoA["doc_dis"])."','".sql_esc($row_infoA["id_dis"])."','".sql_esc($row_infoA["plan_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["qty_dis"])."','".sql_esc($row_infoA["uom_dis"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["shift_day"])."','".sql_esc($row_infoA["slip_no"])."','552','Y','".sql_esc($row_infoA["posting_date"])."','','".sql_esc($row_infoA["sloc_from"])."','".sql_esc($row_infoA["sloc_to"])."','".sql_esc($row_infoA["work_center"])."','".sql_esc($row_infoA["proc_reject"])."','".sql_esc($row_infoA["type_reject"])."','".sql_esc($row_infoA["type_defect"])."','".sql_esc($row_infoA["reason_reject"])."','".sql_esc($row_infoA["cost_center"])."','".sql_esc($row_infoA["user_generate_dis"])."','".sql_esc($row_infoA["user_create"])."','".sql_esc($row_infoA["date_create"])."')"; 
     $rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
		  
	
	  }
	  
	   // $file_rcv = "../FromPortal2/DP/".$filen_rcv.".csv";
		//file_put_contents($file_rcv,$data_rcv);
	  
	
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
	 }  // end ifelse
	  
 	 
	/*  if($result_cancelA)
	 { */
	 
		  //update count_max----------------------------------------
		 
		  if($_POST["plant_code"] == '3100')
		{
	  
		   $query_max_A = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2A)."', date_updated = NOW() WHERE uid = '107'";
		   $result_max_A = mysqli_query($dbc,$query_max_A);

	
		}elseif($_POST["plant_code"] == '3101')
		{
		   $query_max_B = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2A)."', date_updated = NOW() WHERE uid = '109'";
		   $result_max_B = mysqli_query($dbc,$query_max_B);
		   

		}
	 

		   echo "<script>";
		   echo "alert('Material Document $ref6 posted.');";
		   echo "window.location='canC_disposal_gra_tranPRDENGProc.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT'";
	       echo "</script>"; 
		   exit(); //quit the script
		


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteDisplayA<?php echo $row["doc_dis"]; ?><?php echo $row["reject_source"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display Disposal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
     <!--   <div class="content mt-12">-->
     
     <?php
	 
	 $query_bb = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') AS T3 from disposal_detail_prd_all WHERE doc_dis = '".sql_esc($row["doc_dis"])."' GROUP BY doc_dis";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 
	 ?>
        
        <table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="250" height="50"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<h5><font color="#999999"><b>DISPOSAL FORM</b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>Plant :  </b><?php echo $row["plant_cd"];   ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Document No. :  </b><?php echo $row["doc_dis"];   ?></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Date :  </b><?php echo $data_bb["T3"];   ?></div></td>  
  
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Shift :  </b><?php echo $row["shift_posting"];   ?></div></td>
  </tr>
        </table>

        
        
        
        
        
        
        
   
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
                    $wheresql_01 = " AND plant_cd = '".sql_esc($plant_code)."'"; }  	
					
		   // 3. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND (date_posting >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (date_posting <= '".sql_esc($date2_final)."')"; }
							

				$where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04;
	
	//********** END CONDITION **************
	
	
 ?>
 
  <?php
   
   $counterA = 1;
   $noA = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($row["doc_dis"])."' AND (status_disposal = '".sql_esc($rst_sta15["status_desc"])."') AND status_part = 'ENG' " .$where_sql." ORDER BY doc_dis ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   ?>
  <form name="frmDisplay" id="frmDisplay" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" >
 <table width="98%" class="table-bordered">
 <thead bgcolor="#eeeeee">
  <tr>
     <th>No</th>
     <th>Part No.</th>
     <th>Model</th>
     <th>Quantity</th>
     <th>Unit</th>
     <th>Section/Line</th>
     <th>Location</th>
     <th>Process of Reject</th>
     <th>Type of Reject</th>
     <th>Defectives</th>
     <th>Reasons</th> 
     <th>Remark</th>
  </tr>
  </thead>
  <tbody>
  <?php
    
   while($row2 = mysqli_fetch_array($result_display))
   {

  //-----get process of reject----
	   
	   $query_proc = "SELECT * FROM proc_reject_detail_prdeng WHERE id_proc = '".sql_esc($row2["proc_reject"])."'";
	   $rst_proc = mysqli_query($dbc,$query_proc);
       $data_proc = mysqli_fetch_array($rst_proc);
	   
  //----get type of reject -----
  
       $query_type = "SELECT * FROM type_reject_detail_prdeng WHERE id_type = '".sql_esc($row2["type_reject"])."'";
	   $rst_type = mysqli_query($dbc,$query_type);
       $data_type = mysqli_fetch_array($rst_type);
  
  
  //----get reason of reject ------
       $query_reason = "SELECT * FROM type_defect_detail_prdeng WHERE id_defect = '".sql_esc($row2["type_defect"])."'";
	   $rst_reason = mysqli_query($dbc,$query_reason);
       $data_reason = mysqli_fetch_array($rst_reason);
 
  ?>
  <tr>
    <td><?php echo $noA; ?></td>
    <td width="250"><b><?php echo $row2["material_no"]; ?></b><br><?php echo $row2["material_desc"]; ?></td>
    <td><?php echo $row2["model_code"]; ?></td>
    <td><?php echo intval($row2["qty_qc"]); ?></td>
    <td><?php echo $row2["UOM_unit"]; ?></td>
    <td><?php echo $row2["work_center"]; ?></td>
    <td><?php echo $row2["ploc_prod_reject"]; ?></td>
    <td><?php echo $data_proc["proc_desc"]; ?></td>
    <td><?php echo $data_type["type_desc"]; ?></td>
    <td><?php echo $data_reason["defect_desc"]; ?></td>
    <td><?php echo $row2["reason_reject"]; ?></td>
    <td width="250"><?php echo $row2["remarks"]; ?></td>
  </tr>
  
 <?php 
		  
		  $noA++;
		  $counterA++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>

     <div class="modal-footer pull-left">
     <!-- <input name="cancel_btn" type="submit"  class="btn btn-success btn-sm" value="BACK" />-->
       <input name="uid6" type="hidden" value="<?php echo $row["doc_dis"]; ?> ">    
       <input name="date1" type="hidden" value="<?php echo $_GET["date1"]; ?>"> 
       <input name="date2" type="hidden" value="<?php echo $_GET["date2"]; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
       <input name="trans_opt" type="hidden" value="<?php echo $row["reject_source"]; ?>"> 
     
       <input name="canC_DISbtn" type="submit"  class="btn btn-danger btn-sm" value="CANCEL" onClick="return confirm('Are you sure to cancel this transaction?');"/>
      </div> 

     </form>
                <!--  </div></div>-->
                  </div>
                  </div>
                  </div>
                  </div>
               
</body>
</html>