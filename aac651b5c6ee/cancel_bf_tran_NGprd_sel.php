<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
require_once('tcpdf_barcodes_2d.php');
date_default_timezone_set('Asia/Kuala_Lumpur');
$fmt_curr_date = (date("d-m-Y"));
$drun = substr($fmt_curr_date,0,2);
$mrun = substr($fmt_curr_date,3,2);
$yrun = substr($fmt_curr_date,8,2);

$date_run = ($drun.$mrun.$yrun);

//CR status (Cancelled)
$sta4 = "SELECT * from request_status WHERE status_id = '4'";
$sta_res4 = mysqli_query($dbc,$sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

//CR status (Cancelled BF)
$sta33 = "SELECT * from request_status WHERE status_id = '33'";
$sta_res33 = mysqli_query($dbc,$sta33);
$rst_sta33 = mysqli_fetch_array($sta_res33);	

if(isset($_POST["action"])) 
{ // handle the form.

    $formData = $_POST['formData'];
    
    // Parse the string into an associative array
    parse_str($formData, $parsedData);

    // Access individual variables
    $uid3 = $parsedData["uid3"];
    $plant_code = $parsedData["plant_code"];
    $dateF = $parsedData["date1"];
    $dateT = $parsedData["date2"];
    $work_center = $parsedData["work_center"];
    $material_no = $parsedData["material_no"];
    $trans_opt = "BFNG";
    $data_rcv = ''; // Initialize as an empty string
    $filen_rcv = '';
	$number2 = '';
	$number21 = '';
    // echo $uid3;
	
    //-------------------generate backflush OK cancel doc no.---------------

    if($parsedData["plant_code"] == '3100')
    {

        $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '12'";
        $result_id2 = mysqli_query($dbc,$query_id2);

    }elseif($parsedData["plant_code"] == '3101')
    {
        
        $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '67'";
        $result_id2 = mysqli_query($dbc,$query_id2);
        
    }
	
	
	
	if ($result_id2) 
    {
        $nrows2 = mysqli_num_rows($result_id2);
        $row_id2 = mysqli_fetch_array($result_id2);
        
        $dht2 = 00000; 
        $dht_OK2 = "222";
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
	 
    $query_info5 = "SELECT * FROM pps_detail_trn_fg_ng WHERE bflush_no = '".sql_esc($uid3)."' AND status_pps = '".sql_esc($rst_sta7["status_desc"])."' ";
    $result_info5 = mysqli_query($dbc,$query_info5);
    
    while($data_info5 = mysqli_fetch_array($result_info5))
    
    {
		  
        // ---------update cancellation--------------------------
    
        $query_cancelBFOK = "UPDATE pps_detail_trn_fg_ng SET status_pps = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), bflush_no_ref = '".sql_esc($ref2)."' WHERE bflush_no = '".sql_esc($uid3)."' AND status_pps = '".sql_esc($rst_sta7["status_desc"])."'";
        $result_cancelBFOK = mysqli_query($dbc,$query_cancelBFOK);
	
	
	  
        $query_infoB = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM pps_detail_trn_fg_ng WHERE bflush_no = '".sql_esc($uid3)."' AND id = '".sql_esc($data_info5["id"])."' AND status_pps = '".sql_esc($rst_sta4["status_desc"])."'";
        $result_infoB = mysqli_query($dbc,$query_infoB);
        $row_infoB = mysqli_fetch_array($result_infoB);
	   
	   
        //---------insert data at table pps_detail_trn_fg_ng_cancel
	
	
		
		$query_store = "INSERT INTO pps_detail_trn_fg_ng_cancel(id,id_fg,pps_id,ref_id,bflush_no,plan_no,id_scan,upload_id,model_code,month_plan,material_no,material_desc,material_type,qty_plan,qty_actual,qty_balance,qty_NG,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,time_posting,ploc,delivery_loc,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,status_ftp_bflush,bflush_no_ref,user_cancel,date_cancel,remark_cancel,plant_code,shift_posting,stamp_ind,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoB["id"])."','".sql_esc($row_infoB["pps_id"])."','".sql_esc($row_infoB["ref_id"])."','".sql_esc($row_infoB["bflush_no"])."','".sql_esc($row_infoB["plan_no"])."','".sql_esc($row_infoB["id_scan"])."','".sql_esc($row_infoB["upload_id"])."','".sql_esc($row_infoB["model_code"])."','".sql_esc($row_infoB["month_plan"])."','".sql_esc($row_infoB["material_no"])."','".sql_esc($row_infoB["material_desc"])."','".sql_esc($row_infoB["material_type"])."','".sql_esc($row_infoB["qty_plan"])."','".sql_esc($row_infoB["qty_actual"])."','".sql_esc($row_infoB["qty_balance"])."','".sql_esc($row_infoB["qty_NG"])."','".sql_esc($row_infoB["status_pps"])."','".sql_esc($row_infoB["comp_code"])."','".sql_esc($row_infoB["work_center"])."','".sql_esc($row_infoB["shift_pps1"])."','".sql_esc($row_infoB["shift_pps2"])."','".sql_esc($row_infoB["date_plan"])."','".sql_esc($row_infoB["status"])."','".sql_esc($row_infoB["user_upload"])."','".sql_esc($row_infoB["date_upload"])."','".sql_esc($row_infoB["user_create"])."','".sql_esc($row_infoB["date_create"])."','".sql_esc($row_infoB["user_update"])."','".sql_esc($row_infoB["date_update"])."','".sql_esc($row_infoB["user_posting"])."','".sql_esc($row_infoB["date_posting"])."','".sql_esc($row_infoB["time_posting"])."','".sql_esc($row_infoB["ploc"])."','".sql_esc($row_infoB["delivery_loc"])."','".sql_esc($row_infoB["proc_reject"])."','".sql_esc($row_infoB["type_reject"])."','".sql_esc($row_infoB["type_defect"])."','".sql_esc($row_infoB["reason_reject"])."','".sql_esc($row_infoB["user_reject"])."','".sql_esc($row_infoB["date_reject"])."','".sql_esc($row_infoB["time_reject"])."','".sql_esc($row_infoB["status_ftp_bflush"])."','".sql_esc($row_infoB["bflush_no_ref"])."','".sql_esc($row_infoB["user_cancel"])."','".sql_esc($row_infoB["date_cancel"])."','".sql_esc($row_infoB["remark_cancel"])."','".sql_esc($row_infoB["plant_code"])."','".sql_esc($row_infoB["shift_posting"])."','".sql_esc($row_infoB["stamp_ind"])."','".sql_esc($row_infoB["back_no"])."','".sql_esc($row_infoB["kanban_no"])."','".sql_esc($row_infoB["SAP_ref_doc"])."','".sql_esc($row_infoB["SAP_ref_doc_can"])."')";        
		$rst_store = mysqli_query($dbc,$query_store) or die (mysqli_error());
	  
		//-----update disposal status_disposal = "New" to "Cancelled"-------------
	
		$query_dis_sta = "UPDATE disposal_detail_prd_ng SET status_disposal =  '".sql_esc($rst_sta33["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW() WHERE bflush_qqc_no = '".sql_esc($uid3)."' AND uid = '".sql_esc($data_info5["id"])."'";
		$result_dis_sta = mysqli_query($dbc,$query_dis_sta);


		//---------------checking disposal hanya tinggal 1 bflush no n generate cancel disposal doc no---------------------
		
		$query_hdr_infoD = "SELECT * FROM disposal_detail_prd_ng WHERE bflush_qqc_no = '".sql_esc($row_infoB["bflush_no"])."' AND uid = '".sql_esc($row_infoB["id"])."' AND status_disposal = '".sql_esc($rst_sta33["status_desc"])."'";
		$result_hdr_infoD = mysqli_query($dbc,$query_hdr_infoD);
		$row_hdr_infoD = mysqli_fetch_array($result_hdr_infoD); 
		
		//-----update disposal_detail_prd_all status disposal = "Cancelled"		
		
		$query_dis_hdr = "UPDATE disposal_detail_prd_all SET status_disposal =  '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW() WHERE bflush_qqc_no = '".sql_esc($uid3)."' AND uid = '".sql_esc($data_info5["id"])."' AND doc_dis = '".sql_esc($row_hdr_infoD["doc_dis"])."'";
		$result_dis_hdr = mysqli_query($dbc,$query_dis_hdr); 

		
		$query_hdr_info = "SELECT * FROM disposal_detail_prd_all WHERE bflush_qqc_no = '".sql_esc($row_infoB["bflush_no"])."' AND uid = '".sql_esc($row_infoB["id"])."' AND status_disposal = '".sql_esc($rst_sta4["status_desc"])."'";
		$result_hdr_info = mysqli_query($dbc,$query_hdr_info);
		$row_hdr_info = mysqli_fetch_array($result_hdr_info); 

		
		
		$query_ins_dis1 = "INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_hdr_info["id_dis"])."','".sql_esc($row_hdr_info["id_disposal"])."','".sql_esc($row_hdr_info["doc_dis"])."','".sql_esc($row_hdr_info["doc_disposal_no"])."','".sql_esc($row_hdr_info["bflush_hwork"])."','".sql_esc($row_hdr_info["bflush_rework"])."','".sql_esc($row_hdr_info["bflush_pending"])."','".sql_esc($row_hdr_info["bflush_qqc_no"])."','".sql_esc($row_hdr_info["plan_no"])."','".sql_esc($row_hdr_info["uid"])."','".sql_esc($row_hdr_info["material_no"])."','".sql_esc($row_hdr_info["material_desc"])."','".sql_esc($row_hdr_info["material_type"])."','".sql_esc($row_hdr_info["model_code"])."','".sql_esc($row_hdr_info["qty_plan"])."','".sql_esc($row_hdr_info["qty_actual"])."','".sql_esc($row_hdr_info["qty_balance"])."','".sql_esc($row_hdr_info["qty_NG"])."','".sql_esc($row_hdr_info["qty_qc"])."','".sql_esc($row_hdr_info["qty_qc_ok"])."','".sql_esc($row_hdr_info["qty_qc_NG"])."','".sql_esc($row_hdr_info["UOM_unit"])."','".sql_esc($row_hdr_info["comp_code"])."','".sql_esc($row_hdr_info["work_center"])."','".sql_esc($row_hdr_info["shift_day"])."','".sql_esc($row_hdr_info["date_plan"])."','".sql_esc($row_hdr_info["user_posting"])."','".sql_esc($row_hdr_info["date_posting"])."','".sql_esc($row_hdr_info["time_posting"])."','".sql_esc($row_hdr_info["status_disposal"])."','".sql_esc($row_hdr_info["ploc"])."','".sql_esc($row_hdr_info["ploc_prod_reject"])."','".sql_esc($row_hdr_info["ploc_qc_reject"])."','".sql_esc($row_hdr_info["proc_reject"])."','".sql_esc($row_hdr_info["type_reject"])."','".sql_esc($row_hdr_info["type_defect"])."','".sql_esc($row_hdr_info["reason_reject"])."','".sql_esc($row_hdr_info["user_reject"])."','".sql_esc($row_hdr_info["date_reject"])."','".sql_esc($row_hdr_info["time_reject"])."','".sql_esc($row_hdr_info["qty_wastage"])."','".sql_esc($row_hdr_info["type_wastage"])."','".sql_esc($row_hdr_info["reason_wastage"])."','".sql_esc($row_hdr_info["user_wastage"])."','".sql_esc($row_hdr_info["date_wastage"])."','".sql_esc($row_hdr_info["time_wastage"])."','".sql_esc($row_hdr_info["user_disposal"])."','".sql_esc($row_hdr_info["date_disposal"])."','".sql_esc($row_hdr_info["remarks"])."','".sql_esc($row_hdr_info["status_part"])."','".sql_esc($row_hdr_info["user_update"])."','".sql_esc($row_hdr_info["date_update"])."','".sql_esc($row_hdr_info["status_approved"])."','".sql_esc($row_hdr_info["approved_by"])."','".sql_esc($row_hdr_info["date_approved"])."','".sql_esc($row_hdr_info["remark_approved"])."','".sql_esc($row_hdr_info["status_approved2"])."','".sql_esc($row_hdr_info["approved_by2"])."','".sql_esc($row_hdr_info["date_approved2"])."','".sql_esc($row_hdr_info["remark_approved2"])."','".sql_esc($row_hdr_info["status_approved3"])."','".sql_esc($row_hdr_info["approved_by3"])."','".sql_esc($row_hdr_info["date_approved3"])."','".sql_esc($row_hdr_info["remark_approved3"])."','".sql_esc($row_hdr_info["status_approved4"])."','".sql_esc($row_hdr_info["approved_by4"])."','".sql_esc($row_hdr_info["date_approved4"])."','".sql_esc($row_hdr_info["remark_approved4"])."','".sql_esc($row_hdr_info["cost_center"])."','".sql_esc($row_hdr_info["id_factory"])."','".sql_esc($row_hdr_info["disposal_no_ref"])."','".sql_esc($row_hdr_info["user_cancel"])."','".sql_esc($row_hdr_info["date_cancel"])."','".sql_esc($row_hdr_info["remark_cancel"])."','".sql_esc($row_hdr_info["plant_cd"])."','".sql_esc($row_hdr_info["shift_posting"])."','".sql_esc($row_hdr_info["stamp_ind"])."','".sql_esc($row_hdr_info["reject_source"])."','".sql_esc($row_hdr_info["SAP_ref_doc"])."','".sql_esc($row_hdr_info["SAP_ref_doc_can"])."')";
		$result_ins_dis1 = mysqli_query($dbc,$query_ins_dis1);

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
   

        //----------update table ftp_bflush_detail_fg_ng_cancel------------
	 
        $query_rcv_ftp_info = "INSERT INTO ftp_bflush_detail_fg_ng_cancel(id,file_name,bflush_no_ref,bflush_no,ref_id,plan_no,material_no,material_desc,qty_ftp,uom,status_ftp,posting_date,posting_time,user_create,date_create,plant_code,stamp_ind) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($ref2)."','".sql_esc($row_infoB["bflush_no"])."','".sql_esc($row_infoB["ref_id"])."','".sql_esc($row_infoB["plan_no"])."','".sql_esc($row_infoB["material_no"])."','".sql_esc($row_infoB["material_desc"])."','".sql_esc($row_infoB["qty_NG"])."','".sql_esc($data_mt_dtl["BUn"])."','Y','".sql_esc($row_infoB["date_posting"])."','".sql_esc($row_infoB["time_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($row_infoB["plant_code"])."','".sql_esc($row_infoB["stamp_ind"])."')"; 
     	$rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
	  
		// $file_rcv = "../FromPortal/BF_OK/".$filen_rcv.".csv";
		// file_put_contents($file_rcv,$data_rcv);
		
		//---------------checking disposal hanya tinggal 1 bflush no n generate cancel disposal doc no---------------------
	
		$query_hdr_infoT = "SELECT * FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($row_hdr_infoD["bflush_no"])."' AND status_disposal != '".sql_esc($rst_sta4["status_desc"])."'";
		$result_hdr_infoT = mysqli_query($dbc,$query_hdr_infoT);
		$row_hdr_infoT = mysqli_fetch_array($result_hdr_infoT);  
		
		
		if($row_hdr_infoT < 1)
		{
		
			if($row_hdr_infoT < 1)
			{
			   
			   	//------generate Material Document No. Cancellation for BF NG Generate.---------------------------------
				   
				if($_POST["plant_code"] == '3100')
				{
				   
					$query_id21 = "SELECT * FROM run_count_itsb WHERE uid = '22'";
					$result_id21 = mysqli_query($dbc,$query_id21);
				   
				}elseif($_POST["plant_code"] == '3101')
				{
					   
					$query_id21 = "SELECT * FROM run_count_itsb WHERE uid = '73'";
					$result_id21 = mysqli_query($dbc,$query_id21);
					   
				}
				   
				if ($result_id21) 
			   	{
				   $nrows21 = mysqli_num_rows($result_id21);
				   $row_id21 = mysqli_fetch_array($result_id21);
				   
				   $dht21 = 00000; 
				   $dht_OK21 = "312";
				   $dg21 = 0;
			   
				if($row_id21["count_max"] <= 0)
				{ 
				  
					   $lastID21 = ($row_id21["count_max"] + 1);
					   $dg21 = ($dht21 + ($lastID21));
				}
				else
				{
					 $lastID21 = ($row_id21["count_max"] + 1);
					 $dg21 =  $lastID21;
				   
				}
				   $number21 = $dg21; // Length of running no
				   $number21 = sprintf('%03d', $number21);  
				   
				   $ref21 = (($row_id21["start_ref"]).$dht_OK21.$date_run.($number21));
				   
				} // end if $result_id2	
	 
			   
				//-----update disposal status_disposal = "New" to "Cancelled"-------------
	   
				$query_dis_staT = "UPDATE disposal_detail_prd_ng SET status_disposal =  '".sql_esc($rst_sta33["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), disposal_no_ref = '".sql_esc($ref21)."'  WHERE id_disposal = '".sql_esc($row_hdr_infoT["id_disposal"])."' AND doc_dis = '".sql_esc($row_hdr_infoT["doc_dis"])."'";
				$result_dis_staT = mysqli_query($dbc,$query_dis_staT);
		
		  		//-----update disposal_detail_prd_all status disposal = "Cancelled"		
	  
				$query_dis_hdrT = "UPDATE disposal_detail_prd_all SET status_disposal =  '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), disposal_no_ref = '".sql_esc($ref21)."'  WHERE id_disposal = '".sql_esc($row_hdr_infoT["id_disposal"])."' AND doc_dis = '".sql_esc($row_hdr_infoT["doc_dis"])."'";
				$result_dis_hdrT = mysqli_query($dbc,$query_dis_hdrT); 
	  
				
			}  /// end if
		

		}	
	}

	$file_rcv = "../FromPortal/BF_NG/".$filen_rcv.".csv";
	file_put_contents($file_rcv,$data_rcv);

	//update count_max----------------------------------------
	if($_POST["plant_code"] == '3100')
	{
  
	   $query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '14'";
	   $result_max_aA = mysqli_query($dbc,$query_max_aA);

	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number21)."', date_updated = NOW() WHERE uid = '22'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);

	}elseif($_POST["plant_code"] == '3101')
	{
	   $query_max_bB = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '69'";
	   $result_max_bB = mysqli_query($dbc,$query_max_bB);
	   
	   $query_max_b1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number21)."', date_updated = NOW() WHERE uid = '73'";
	   $result_max_b1 = mysqli_query($dbc,$query_max_b1);
	   
	}

	// If everything is successful
	echo json_encode([
		"status" => "success",
		"message" => "Material Document $ref2 posted.",
		"redirect" => "canC_bf_tran_NG-prdProc.php?plant_code=$plant_code&&trans_opt=$trans_opt&&date1=$dateF&&date2=$dateT&&work_center=$work_center&&material_no=$material_no"
	]);
	exit();
		

}// end submit

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $dateF = $_POST["date1"];
    $dateT = $_POST["date2"];
    $plant_code = $_POST["plant_code"]; 
    $work_center = $_POST["work_center"];
    $material_no = $_POST["material_no"]; 

    
    $where_sql = '';
        
    $ddF = substr($_POST["date1"],0,2);
    $mmF = substr($_POST["date1"],3,2);
    $yyF = substr($_POST["date1"],6,4);

    $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
    
    $ddF2 = substr($_POST["date2"],0,2);
    $mmF2 = substr($_POST["date2"],3,2);
    $yyF2 = substr($_POST["date2"],6,4);

    $date2_final = ($yyF2.'-'.$mmF2.'-'.$ddF2);
        
                    
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

    $html = '<div class="content mt-12"><h5>Cancel Backflush NG <?php echo $row["bflush_no"]; ?>?</h5><br>';
    $html .= '<form name="frmCancel" id="frmCancel" method="post" class="needs-validation"  novalidate>';
    $query_display = "SELECT * FROM pps_detail_trn_fg_ng 
                      WHERE bflush_no = '".sql_esc($id)."' AND status_pps = '".sql_esc($rst_sta7["status_desc"])."' $where_sql 
                      ORDER BY bflush_no ASC";
    $result_display = mysqli_query($dbc, $query_display);

    while ($row2 = mysqli_fetch_array($result_display)) {
        $html .= '
        <input name="uid3" type="hidden" value="' . $row2["bflush_no"] . '">
        <input name="date1" type="hidden" value="' . $dateF . '">
        <input name="date2" type="hidden" value="' . $dateT . '">
        <input name="plant_code" type="hidden" value="' . $plant_code . '">
        <input name="work_center" type="hidden" value="' . $work_center . '">
        <input name="material_no" type="hidden" value="' . $material_no . '">';
    }
    $html .= '
        <div class="modal-footer pull-left">
            <input name="can_BFNGbtn" type="button" class="can_BFNGbtn btn btn-success btn-sm" value="PROCEED">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">CANCEL</button>
        </div>
    </form>';

    // Return the generated HTML
    echo $html;
    
    // Close statements
    // $query_Mod->close();
    // $query_Mod2A->close();
    // $stmt->close();
}
?>