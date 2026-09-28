<?php
    
     
	  if($sta_out == "311")
	  {
   
   
   
   
   // ---------update cancel Disposal and revert to original table--------------------------
	 
	$query_cancelGR1 = "UPDATE disposal_detail_prd_all SET disposal_no_ref = '".sql_esc($ref21)."', status_disposal = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW() WHERE doc_dis = '".sql_esc($uid4)."' AND status_disposal = '".sql_esc($rst_sta3["status_desc"])."'";
	$result_cancelGR1 = mysqli_query($dbc,$query_cancelGR1);
	
	 
	  
	   $query_infoB1 = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid4)."' AND id = '".sql_esc($data_info5["id"])."' AND status_disposal = '".sql_esc($rst_sta4["status_desc"])."'";
	   $result_infoB1 = mysqli_query($dbc,$query_infoB1);
	   $row_infoB1 = mysqli_fetch_array($result_infoB1);
	  
	 // echo $row_infoB["id_disposal"];	
	 
	  $query_ins_dis1 = "INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoB1["id"])."','".sql_esc($row_infoB1["id_disposal"])."','".sql_esc($row_infoB1["doc_dis"])."','".sql_esc($row_infoB1["doc_disposal_no"])."','".sql_esc($row_infoB1["bflush_hwork"])."','".sql_esc($row_infoB1["bflush_rework"])."','".sql_esc($row_infoB1["bflush_pending"])."','".sql_esc($row_infoB1["bflush_qqc_no"])."','".sql_esc($row_infoB1["plan_no"])."','".sql_esc($row_infoB1["uid"])."','".sql_esc($row_infoB1["material_no"])."','".sql_esc($row_infoB1["material_desc"])."','".sql_esc($row_infoB1["material_type"])."','".sql_esc($row_infoB1["model_code"])."','".sql_esc($row_infoB1["qty_plan"])."','".sql_esc($row_infoB1["qty_actual"])."','".sql_esc($row_infoB1["qty_balance"])."','".sql_esc($row_infoB1["qty_NG"])."','".sql_esc($row_infoB1["qty_qc"])."','".sql_esc($row_infoB1["qty_qc_ok"])."','".sql_esc($row_infoB1["qty_qc_NG"])."','".sql_esc($row_infoB1["UOM_unit"])."','".sql_esc($row_infoB1["comp_code"])."','".sql_esc($row_infoB1["work_center"])."','".sql_esc($row_infoB1["shift_day"])."','".sql_esc($row_infoB1["date_plan"])."','".sql_esc($row_infoB1["user_posting"])."','".sql_esc($row_infoB1["date_posting"])."','".sql_esc($row_infoB1["time_posting"])."','".sql_esc($row_infoB1["status_disposal"])."','".sql_esc($row_infoB1["ploc"])."','".sql_esc($row_infoB1["ploc_prod_reject"])."','".sql_esc($row_infoB1["ploc_qc_reject"])."','".sql_esc($row_infoB1["proc_reject"])."','".sql_esc($row_infoB1["type_reject"])."','".sql_esc($row_infoB1["type_defect"])."','".sql_esc($row_infoB1["reason_reject"])."','".sql_esc($row_infoB1["user_reject"])."','".sql_esc($row_infoB1["date_reject"])."','".sql_esc($row_infoB1["time_reject"])."','".sql_esc($row_infoB1["qty_wastage"])."','".sql_esc($row_infoB1["type_wastage"])."','".sql_esc($row_infoB1["reason_wastage"])."','".sql_esc($row_infoB1["user_wastage"])."','".sql_esc($row_infoB1["date_wastage"])."','".sql_esc($row_infoB1["time_wastage"])."','".sql_esc($row_infoB1["user_disposal"])."','".sql_esc($row_infoB1["date_disposal"])."','".sql_esc($row_infoB1["remarks"])."','".sql_esc($row_infoB1["status_part"])."','".sql_esc($row_infoB1["user_update"])."','".sql_esc($row_infoB1["date_update"])."','".sql_esc($row_infoB1["status_approved"])."','".sql_esc($row_infoB1["approved_by"])."','".sql_esc($row_infoB1["date_approved"])."','".sql_esc($row_infoB1["remark_approved"])."','".sql_esc($row_infoB1["status_approved2"])."','".sql_esc($row_infoB1["approved_by2"])."','".sql_esc($row_infoB1["date_approved2"])."','".sql_esc($row_infoB1["remark_approved2"])."','".sql_esc($row_infoB1["status_approved3"])."','".sql_esc($row_infoB1["approved_by3"])."','".sql_esc($row_infoB1["date_approved3"])."','".sql_esc($row_infoB1["remark_approved3"])."','".sql_esc($row_infoB1["status_approved4"])."','".sql_esc($row_infoB1["approved_by4"])."','".sql_esc($row_infoB1["date_approved4"])."','".sql_esc($row_infoB1["remark_approved4"])."','".sql_esc($row_infoB1["status_approved5"])."','".sql_esc($row_infoB1["approved_by5"])."','".sql_esc($row_infoB1["date_approved5"])."','".sql_esc($row_infoB1["remark_approved5"])."','".sql_esc($row_infoB1["cost_center"])."','".sql_esc($row_infoB1["id_factory"])."','".sql_esc($row_infoB1["disposal_no_ref"])."','".sql_esc($row_infoB1["user_cancel"])."','".sql_esc($row_infoB1["date_cancel"])."','".sql_esc($row_infoB1["remark_cancel"])."','".sql_esc($row_infoB1["plant_cd"])."','".sql_esc($row_infoB1["shift_posting"])."','".sql_esc($row_infoB1["stamp_ind"])."','".sql_esc($row_infoB1["reject_source"])."','".sql_esc($row_infoB1["back_no"])."','".sql_esc($row_infoB1["kanban_no"])."','".sql_esc($row_infoB1["SAP_ref_doc"])."','".sql_esc($row_infoB1["SAP_ref_doc_can"])."')";
$result_ins_dis1 = mysqli_query($dbc,$query_ins_dis1);
	
	
	/*$query_cancelDis1 = "UPDATE disposal_detail_prd_ng SET disposal_no_ref = '".$ref21."', status_disposal = '".$rst_sta4["status_desc"]."', user_cancel = '".$username."', date_cancel = NOW() WHERE doc_dis = '".$uid4."'";
	$result_cancelDis1 = mysqli_query($dbc,$query_cancelDis1); */
	
	$query_cancelDis1 = "UPDATE disposal_detail_prd_ng SET doc_dis = '', doc_disposal_no = '', disposal_no_ref = '', status_disposal = '".sql_esc($rst_sta["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), status_approved = '', approved_by = '', date_approved = '0000-00-00', remark_approved = '', status_approved2 = '', approved_by2 = '', date_approved2 = '0000-00-00', remark_approved2 = '', status_approved3 = '', approved_by3 = '', date_approved3 = '0000-00-00', remark_approved3 = '', status_approved5 = '', approved_by5 = '', date_approved5 = '0000-00-00', remark_approved5 = '' WHERE doc_dis = '".sql_esc($uid4)."'";
	$result_cancelDis1 = mysqli_query($dbc,$query_cancelDis1); 
	
	//update count_max----------------------------------------
	 
		  if($_POST["plant_code"] == '3100')
		{
	  
		   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number21)."', date_updated = NOW() WHERE uid = '22'";
		   $result_max_a1 = mysqli_query($dbc,$query_max_a1);
	
		}elseif($_POST["plant_code"] == '3101')
		{
		   $query_max_b1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number21)."', date_updated = NOW() WHERE uid = '73'";
		   $result_max_b1 = mysqli_query($dbc,$query_max_b1);
		 
		}
	
	//-----------------------------end 311---------------------------------------
	
	  }elseif($sta_out == "321")
	  {
		  
	
   // ---------update cancel Disposal and revert to original table--------------------------
	 
	$query_cancelGR2 = "UPDATE disposal_detail_prd_all SET disposal_no_ref = '".sql_esc($ref22)."', status_disposal = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW() WHERE doc_dis = '".sql_esc($uid4)."' AND status_disposal = '".sql_esc($rst_sta3["status_desc"])."'";
	$result_cancelGR2 = mysqli_query($dbc,$query_cancelGR2);	 
	  
	   $query_infoB2 = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid4)."' AND id = '".sql_esc($data_info5["id"])."' AND status_disposal = '".sql_esc($rst_sta4["status_desc"])."'";
	   $result_infoB2 = mysqli_query($dbc,$query_infoB2);
	   $row_infoB2 = mysqli_fetch_array($result_infoB2);
	  
	 // echo $row_infoB["id_disposal"];		 
	 
	  $query_ins_dis2 = "INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoB2["id"])."','".sql_esc($row_infoB2["id_disposal"])."','".sql_esc($row_infoB2["doc_dis"])."','".sql_esc($row_infoB2["doc_disposal_no"])."','".sql_esc($row_infoB2["bflush_hwork"])."','".sql_esc($row_infoB2["bflush_rework"])."','".sql_esc($row_infoB2["bflush_pending"])."','".sql_esc($row_infoB2["bflush_qqc_no"])."','".sql_esc($row_infoB2["plan_no"])."','".sql_esc($row_infoB2["uid"])."','".sql_esc($row_infoB2["material_no"])."','".sql_esc($row_infoB2["material_desc"])."','".sql_esc($row_infoB2["material_type"])."','".sql_esc($row_infoB2["model_code"])."','".sql_esc($row_infoB2["qty_plan"])."','".sql_esc($row_infoB2["qty_actual"])."','".sql_esc($row_infoB2["qty_balance"])."','".sql_esc($row_infoB2["qty_NG"])."','".sql_esc($row_infoB2["qty_qc"])."','".sql_esc($row_infoB2["qty_qc_ok"])."','".sql_esc($row_infoB2["qty_qc_NG"])."','".sql_esc($row_infoB2["UOM_unit"])."','".sql_esc($row_infoB2["comp_code"])."','".sql_esc($row_infoB2["work_center"])."','".sql_esc($row_infoB2["shift_day"])."','".sql_esc($row_infoB2["date_plan"])."','".sql_esc($row_infoB2["user_posting"])."','".sql_esc($row_infoB2["date_posting"])."','".sql_esc($row_infoB2["time_posting"])."','".sql_esc($row_infoB2["status_disposal"])."','".sql_esc($row_infoB2["ploc"])."','".sql_esc($row_infoB2["ploc_prod_reject"])."','".sql_esc($row_infoB2["ploc_qc_reject"])."','".sql_esc($row_infoB2["proc_reject"])."','".sql_esc($row_infoB2["type_reject"])."','".sql_esc($row_infoB2["type_defect"])."','".sql_esc($row_infoB2["reason_reject"])."','".sql_esc($row_infoB2["user_reject"])."','".sql_esc($row_infoB2["date_reject"])."','".sql_esc($row_infoB2["time_reject"])."','".sql_esc($row_infoB2["qty_wastage"])."','".sql_esc($row_infoB2["type_wastage"])."','".sql_esc($row_infoB2["reason_wastage"])."','".sql_esc($row_infoB2["user_wastage"])."','".sql_esc($row_infoB2["date_wastage"])."','".sql_esc($row_infoB2["time_wastage"])."','".sql_esc($row_infoB2["user_disposal"])."','".sql_esc($row_infoB2["date_disposal"])."','".sql_esc($row_infoB2["remarks"])."','".sql_esc($row_infoB2["status_part"])."','".sql_esc($row_infoB2["user_update"])."','".sql_esc($row_infoB2["date_update"])."','".sql_esc($row_infoB2["status_approved"])."','".sql_esc($row_infoB2["approved_by"])."','".sql_esc($row_infoB2["date_approved"])."','".sql_esc($row_infoB2["remark_approved"])."','".sql_esc($row_infoB2["status_approved2"])."','".sql_esc($row_infoB2["approved_by2"])."','".sql_esc($row_infoB2["date_approved2"])."','".sql_esc($row_infoB2["remark_approved2"])."','".sql_esc($row_infoB2["status_approved3"])."','".sql_esc($row_infoB2["approved_by3"])."','".sql_esc($row_infoB2["date_approved3"])."','".sql_esc($row_infoB2["remark_approved3"])."','".sql_esc($row_infoB2["status_approved4"])."','".sql_esc($row_infoB2["approved_by4"])."','".sql_esc($row_infoB2["date_approved4"])."','".sql_esc($row_infoB2["remark_approved4"])."','".sql_esc($row_infoB2["status_approved5"])."','".sql_esc($row_infoB2["approved_by5"])."','".sql_esc($row_infoB2["date_approved5"])."','".sql_esc($row_infoB2["remark_approved5"])."','".sql_esc($row_infoB2["cost_center"])."','".sql_esc($row_infoB2["id_factory"])."','".sql_esc($row_infoB2["disposal_no_ref"])."','".sql_esc($row_infoB2["user_cancel"])."','".sql_esc($row_infoB2["date_cancel"])."','".sql_esc($row_infoB2["remark_cancel"])."','".sql_esc($row_infoB2["plant_cd"])."','".sql_esc($row_infoB2["shift_posting"])."','".sql_esc($row_infoB2["stamp_ind"])."','".sql_esc($row_infoB2["reject_source"])."','".sql_esc($row_infoB2["back_no"])."','".sql_esc($row_infoB2["kanban_no"])."','".sql_esc($row_infoB2["SAP_ref_doc"])."','".sql_esc($row_infoB2["SAP_ref_doc_can"])."')";
$result_ins_dis2 = mysqli_query($dbc,$query_ins_dis2);
 
		  
/*	$query_cancelDis2 = "UPDATE disposal_detail_prd_pending_confirm SET disposal_no_ref = '".$ref22."', status_disposal = '".$rst_sta4["status_desc"]."', user_cancel = '".$username."', date_cancel = NOW() WHERE doc_dis = '".$uid4."'";
	$result_cancelDis2 = mysqli_query($dbc,$query_cancelDis2); 
*/	
	$query_cancelDis2 = "UPDATE disposal_detail_prd_pending_confirm SET doc_dis = '', doc_disposal_no = '', status_disposal = '".sql_esc($rst_sta["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), status_approved = '', approved_by = '', date_approved = '0000-00-00', remark_approved = '', status_approved2 = '', approved_by2 = '', date_approved2 = '0000-00-00', remark_approved2 = '', status_approved3 = '', approved_by3 = '', date_approved3 = '0000-00-00', remark_approved3 = '', status_approved4 = '', approved_by4 = '', date_approved4 = '0000-00-00', remark_approved4 = '' WHERE doc_dis = '".sql_esc($uid4)."'";
	$result_cancelDis2 = mysqli_query($dbc,$query_cancelDis2); 
	
		//update count_max----------------------------------------
	 
		  if($_POST["plant_code"] == '3100')
		{
	  
		   $query_max_a2 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number22)."', date_updated = NOW() WHERE uid = '24'";
		   $result_max_a2 = mysqli_query($dbc,$query_max_a2);
	
		}elseif($_POST["plant_code"] == '3101')
		{
		   $query_max_b2 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number22)."', date_updated = NOW() WHERE uid = '75'";
		   $result_max_b2 = mysqli_query($dbc,$query_max_b2);
		 
		}
	
	
	//-----------------------------end 321---------------------------------------
		  
	  }elseif($sta_out == "331")
	  {
		  
   
   
   // ---------update cancel Disposal and revert to original table--------------------------
	 
	$query_cancelGR3 = "UPDATE disposal_detail_prd_all SET disposal_no_ref = '".sql_esc($ref23)."', status_disposal = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW() WHERE doc_dis = '".sql_esc($uid4)."' AND status_disposal = '".sql_esc($rst_sta3["status_desc"])."'";
	$result_cancelGR3 = mysqli_query($dbc,$query_cancelGR3);	 
	  
	   $query_infoB3 = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid4)."' AND id = '".sql_esc($data_info5["id"])."' AND status_disposal = '".sql_esc($rst_sta4["status_desc"])."'";
	   $result_infoB3 = mysqli_query($dbc,$query_infoB3);
	   $row_infoB3 = mysqli_fetch_array($result_infoB3);
	  
	 // echo $row_infoB["id_disposal"];		
		 $query_ins_dis3 = "INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoB3["id"])."','".sql_esc($row_infoB3["id_disposal"])."','".sql_esc($row_infoB3["doc_dis"])."','".sql_esc($row_infoB3["doc_disposal_no"])."','".sql_esc($row_infoB3["bflush_hwork"])."','".sql_esc($row_infoB3["bflush_rework"])."','".sql_esc($row_infoB3["bflush_pending"])."','".sql_esc($row_infoB3["bflush_qqc_no"])."','".sql_esc($row_infoB3["plan_no"])."','".sql_esc($row_infoB3["uid"])."','".sql_esc($row_infoB3["material_no"])."','".sql_esc($row_infoB3["material_desc"])."','".sql_esc($row_infoB3["material_type"])."','".sql_esc($row_infoB3["model_code"])."','".sql_esc($row_infoB3["qty_plan"])."','".sql_esc($row_infoB3["qty_actual"])."','".sql_esc($row_infoB3["qty_balance"])."','".sql_esc($row_infoB3["qty_NG"])."','".sql_esc($row_infoB3["qty_qc"])."','".sql_esc($row_infoB3["qty_qc_ok"])."','".sql_esc($row_infoB3["qty_qc_NG"])."','".sql_esc($row_infoB3["UOM_unit"])."','".sql_esc($row_infoB3["comp_code"])."','".sql_esc($row_infoB3["work_center"])."','".sql_esc($row_infoB3["shift_day"])."','".sql_esc($row_infoB3["date_plan"])."','".sql_esc($row_infoB3["user_posting"])."','".sql_esc($row_infoB3["date_posting"])."','".sql_esc($row_infoB3["time_posting"])."','".sql_esc($row_infoB3["status_disposal"])."','".sql_esc($row_infoB3["ploc"])."','".sql_esc($row_infoB3["ploc_prod_reject"])."','".sql_esc($row_infoB3["ploc_qc_reject"])."','".sql_esc($row_infoB3["proc_reject"])."','".sql_esc($row_infoB3["type_reject"])."','".sql_esc($row_infoB3["type_defect"])."','".sql_esc($row_infoB3["reason_reject"])."','".sql_esc($row_infoB3["user_reject"])."','".sql_esc($row_infoB3["date_reject"])."','".sql_esc($row_infoB3["time_reject"])."','".sql_esc($row_infoB3["qty_wastage"])."','".sql_esc($row_infoB3["type_wastage"])."','".sql_esc($row_infoB3["reason_wastage"])."','".sql_esc($row_infoB3["user_wastage"])."','".sql_esc($row_infoB3["date_wastage"])."','".sql_esc($row_infoB3["time_wastage"])."','".sql_esc($row_infoB3["user_disposal"])."','".sql_esc($row_infoB3["date_disposal"])."','".sql_esc($row_infoB3["remarks"])."','".sql_esc($row_infoB3["status_part"])."','".sql_esc($row_infoB3["user_update"])."','".sql_esc($row_infoB3["date_update"])."','".sql_esc($row_infoB3["status_approved"])."','".sql_esc($row_infoB3["approved_by"])."','".sql_esc($row_infoB3["date_approved"])."','".sql_esc($row_infoB3["remark_approved"])."','".sql_esc($row_infoB3["status_approved2"])."','".sql_esc($row_infoB3["approved_by2"])."','".sql_esc($row_infoB3["date_approved2"])."','".sql_esc($row_infoB3["remark_approved2"])."','".sql_esc($row_infoB3["status_approved3"])."','".sql_esc($row_infoB3["approved_by3"])."','".sql_esc($row_infoB3["date_approved3"])."','".sql_esc($row_infoB3["remark_approved3"])."','".sql_esc($row_infoB3["status_approved4"])."','".sql_esc($row_infoB3["approved_by4"])."','".sql_esc($row_infoB3["date_approved4"])."','".sql_esc($row_infoB3["remark_approved4"])."','".sql_esc($row_infoB3["status_approved5"])."','".sql_esc($row_infoB3["approved_by5"])."','".sql_esc($row_infoB3["date_approved5"])."','".sql_esc($row_infoB3["remark_approved5"])."','".sql_esc($row_infoB3["cost_center"])."','".sql_esc($row_infoB3["id_factory"])."','".sql_esc($row_infoB3["disposal_no_ref"])."','".sql_esc($row_infoB3["user_cancel"])."','".sql_esc($row_infoB3["date_cancel"])."','".sql_esc($row_infoB3["remark_cancel"])."','".sql_esc($row_infoB3["plant_cd"])."','".sql_esc($row_infoB3["shift_posting"])."','".sql_esc($row_infoB3["stamp_ind"])."','".sql_esc($row_infoB3["reject_source"])."','".sql_esc($row_infoB3["back_no"])."','".sql_esc($row_infoB3["kanban_no"])."','".sql_esc($row_infoB3["SAP_ref_doc"])."','".sql_esc($row_infoB3["SAP_ref_doc_can"])."')";
$result_ins_dis3 = mysqli_query($dbc,$query_ins_dis3);  
		  
		  
		
    /*$query_cancelDis3 = "UPDATE disposal_detail_prd_pending_confirm_hwork SET disposal_no_ref = '".$ref23."', status_disposal = '".$rst_sta4["status_desc"]."', user_cancel = '".$username."', date_cancel = NOW() WHERE doc_dis = '".$uid4."'";
	$result_cancelDis3 = mysqli_query($dbc,$query_cancelDis3); */
	
	 $query_cancelDis3 = "UPDATE disposal_detail_prd_pending_confirm_hwork SET doc_dis = '', doc_disposal_no = '', status_disposal = '".sql_esc($rst_sta["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), status_approved = '', approved_by = '', date_approved = '0000-00-00', remark_approved = '', status_approved2 = '', approved_by2 = '', date_approved2 = '0000-00-00', remark_approved2 = '', status_approved3 = '', approved_by3 = '', date_approved3 = '0000-00-00', remark_approved3 = '', status_approved5 = '', approved_by5 = '', date_approved5 = '0000-00-00', remark_approved5 = '' WHERE doc_dis = '".sql_esc($uid4)."'";
	 $result_cancelDis3 = mysqli_query($dbc,$query_cancelDis3); 
	
	      //update count_max----------------------------------------

		   $query_max_a3 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number23)."', date_updated = NOW() WHERE uid = '26'";
		   $result_max_a3 = mysqli_query($dbc,$query_max_a3);
	
		
	//-----------------------------end 331---------------------------------------  
		  
	  }elseif($sta_out == "341")
	  {
		  

   
   
   // ---------update cancel Disposal and revert to original table--------------------------
	 
	$query_cancelGR4 = "UPDATE disposal_detail_prd_all SET disposal_no_ref = '".sql_esc($ref24)."', status_disposal = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW() WHERE doc_dis = '".sql_esc($uid4)."' AND status_disposal = '".sql_esc($rst_sta3["status_desc"])."'";
	$result_cancelGR4 = mysqli_query($dbc,$query_cancelGR4);	 
	  
	   $query_infoB4 = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid4)."' AND id = '".sql_esc($data_info5["id"])."' AND status_disposal = '".sql_esc($rst_sta4["status_desc"])."'";
	   $result_infoB4 = mysqli_query($dbc,$query_infoB4);
	   $row_infoB4 = mysqli_fetch_array($result_infoB4);
	  
	 // echo $row_infoB["id_disposal"];	
	 
	  $query_ins_dis4 = "INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoB4["id"])."','".sql_esc($row_infoB4["id_disposal"])."','".sql_esc($row_infoB4["doc_dis"])."','".sql_esc($row_infoB4["doc_disposal_no"])."','".sql_esc($row_infoB4["bflush_hwork"])."','".sql_esc($row_infoB4["bflush_rework"])."','".sql_esc($row_infoB4["bflush_pending"])."','".sql_esc($row_infoB4["bflush_qqc_no"])."','".sql_esc($row_infoB4["plan_no"])."','".sql_esc($row_infoB4["uid"])."','".sql_esc($row_infoB4["material_no"])."','".sql_esc($row_infoB4["material_desc"])."','".sql_esc($row_infoB4["material_type"])."','".sql_esc($row_infoB4["model_code"])."','".sql_esc($row_infoB4["qty_plan"])."','".sql_esc($row_infoB4["qty_actual"])."','".sql_esc($row_infoB4["qty_balance"])."','".sql_esc($row_infoB4["qty_NG"])."','".sql_esc($row_infoB4["qty_qc"])."','".sql_esc($row_infoB4["qty_qc_ok"])."','".sql_esc($row_infoB4["qty_qc_NG"])."','".sql_esc($row_infoB4["UOM_unit"])."','".sql_esc($row_infoB4["comp_code"])."','".sql_esc($row_infoB4["work_center"])."','".sql_esc($row_infoB4["shift_day"])."','".sql_esc($row_infoB4["date_plan"])."','".sql_esc($row_infoB4["user_posting"])."','".sql_esc($row_infoB4["date_posting"])."','".sql_esc($row_infoB4["time_posting"])."','".sql_esc($row_infoB4["status_disposal"])."','".sql_esc($row_infoB4["ploc"])."','".sql_esc($row_infoB5["ploc_prod_reject"])."','".sql_esc($row_infoB4["ploc_qc_reject"])."','".sql_esc($row_infoB4["proc_reject"])."','".sql_esc($row_infoB4["type_reject"])."','".sql_esc($row_infoB4["type_defect"])."','".sql_esc($row_infoB4["reason_reject"])."','".sql_esc($row_infoB4["user_reject"])."','".sql_esc($row_infoB4["date_reject"])."','".sql_esc($row_infoB4["time_reject"])."','".sql_esc($row_infoB4["qty_wastage"])."','".sql_esc($row_infoB4["type_wastage"])."','".sql_esc($row_infoB4["reason_wastage"])."','".sql_esc($row_infoB4["user_wastage"])."','".sql_esc($row_infoB4["date_wastage"])."','".sql_esc($row_infoB4["time_wastage"])."','".sql_esc($row_infoB4["user_disposal"])."','".sql_esc($row_infoB4["date_disposal"])."','".sql_esc($row_infoB4["remarks"])."','".sql_esc($row_infoB4["status_part"])."','".sql_esc($row_infoB4["user_update"])."','".sql_esc($row_infoB4["date_update"])."','".sql_esc($row_infoB4["status_approved"])."','".sql_esc($row_infoB4["approved_by"])."','".sql_esc($row_infoB4["date_approved"])."','".sql_esc($row_infoB4["remark_approved"])."','".sql_esc($row_infoB4["status_approved2"])."','".sql_esc($row_infoB4["approved_by2"])."','".sql_esc($row_infoB4["date_approved2"])."','".sql_esc($row_infoB4["remark_approved2"])."','".sql_esc($row_infoB4["status_approved3"])."','".sql_esc($row_infoB4["approved_by3"])."','".sql_esc($row_infoB4["date_approved3"])."','".sql_esc($row_infoB4["remark_approved3"])."','".sql_esc($row_infoB4["status_approved4"])."','".sql_esc($row_infoB4["approved_by4"])."','".sql_esc($row_infoB4["date_approved4"])."','".sql_esc($row_infoB4["remark_approved4"])."','".sql_esc($row_infoB4["status_approved5"])."','".sql_esc($row_infoB4["approved_by5"])."','".sql_esc($row_infoB4["date_approved5"])."','".sql_esc($row_infoB4["remark_approved5"])."','".sql_esc($row_infoB4["cost_center"])."','".sql_esc($row_infoB4["id_factory"])."','".sql_esc($row_infoB4["disposal_no_ref"])."','".sql_esc($row_infoB4["user_cancel"])."','".sql_esc($row_infoB4["date_cancel"])."','".sql_esc($row_infoB4["remark_cancel"])."','".sql_esc($row_infoB4["plant_cd"])."','".sql_esc($row_infoB4["shift_posting"])."','".sql_esc($row_infoB4["stamp_ind"])."','".sql_esc($row_infoB4["reject_source"])."','".sql_esc($row_infoB4["back_no"])."','".sql_esc($row_infoB4["kanban_no"])."','".sql_esc($row_infoB4["SAP_ref_doc"])."','".sql_esc($row_infoB4["SAP_ref_doc_can"])."')";
$result_ins_dis4 = mysqli_query($dbc,$query_ins_dis4);
	 		  
		  
   /* $query_cancelDis4 = "UPDATE disposal_detail_prd_pending_confirm_rework SET disposal_no_ref = '".$ref24."', status_disposal = '".$rst_sta4["status_desc"]."', user_cancel = '".$username."', date_cancel = NOW() WHERE doc_dis = '".$uid4."'";
	$result_cancelDis4 = mysqli_query($dbc,$query_cancelDis4); */
	
	$query_cancelDis4 = "UPDATE disposal_detail_prd_pending_confirm_rework SET doc_dis = '', doc_disposal_no = '', status_disposal = '".sql_esc($rst_sta["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), status_approved = '', approved_by = '', date_approved = '0000-00-00', remark_approved = '', status_approved2 = '', approved_by2 = '', date_approved2 = '0000-00-00', remark_approved2 = '', status_approved3 = '', approved_by3 = '', date_approved3 = '0000-00-00', remark_approved3 = '',  status_approved5 = '', approved_by5 = '', date_approved5 = '0000-00-00', remark_approved5 = '' WHERE doc_dis = '".sql_esc($uid4)."'";
	$result_cancelDis4 = mysqli_query($dbc,$query_cancelDis4); 
	

	//update count_max----------------------------------------
	 
		  if($_POST["plant_code"] == '3100')
		{
	  
		   $query_max_a4 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number24)."', date_updated = NOW() WHERE uid = '28'";
		   $result_max_a4 = mysqli_query($dbc,$query_max_a4);
	
		}elseif($_POST["plant_code"] == '3101')
		{
		   $query_max_b4 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number24)."', date_updated = NOW() WHERE uid = '77'";
		   $result_max_b4 = mysqli_query($dbc,$query_max_b4);
		 
		}
	
	
	
	 
	
	//-----------------------------end 341---------------------------------------   
		  
	  }elseif($sta_out == "351")
	  {		  
	
				
				
				 // ---------update cancel Disposal and revert to original table--------------------------
	 
	 $query_cancelGR5 = "UPDATE disposal_detail_prd_all SET disposal_no_ref = '".sql_esc($ref25)."', status_disposal = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW() WHERE doc_dis = '".sql_esc($uid4)."' AND status_disposal = '".sql_esc($rst_sta3["status_desc"])."'";
	 $result_cancelGR5 = mysqli_query($dbc,$query_cancelGR5);
	
	 
	  
	   $query_infoB5 = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid4)."' AND id = '".sql_esc($data_info5["id"])."' AND status_disposal = '".sql_esc($rst_sta4["status_desc"])."'";
	   $result_infoB5 = mysqli_query($dbc,$query_infoB5);
	   $row_infoB5 = mysqli_fetch_array($result_infoB5);
				
	  
	  $query_ins_dis5 = "INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoB5["id"])."','".sql_esc($row_infoB5["id_disposal"])."','".sql_esc($row_infoB5["doc_dis"])."','".sql_esc($row_infoB5["doc_disposal_no"])."','".sql_esc($row_infoB5["bflush_hwork"])."','".sql_esc($row_infoB5["bflush_rework"])."','".sql_esc($row_infoB5["bflush_pending"])."','".sql_esc($row_infoB5["bflush_qqc_no"])."','".sql_esc($row_infoB5["plan_no"])."','".sql_esc($row_infoB5["uid"])."','".sql_esc($row_infoB5["material_no"])."','".sql_esc($row_infoB5["material_desc"])."','".sql_esc($row_infoB5["material_type"])."','".sql_esc($row_infoB5["model_code"])."','".sql_esc($row_infoB5["qty_plan"])."','".sql_esc($row_infoB5["qty_actual"])."','".sql_esc($row_infoB5["qty_balance"])."','".sql_esc($row_infoB5["qty_NG"])."','".sql_esc($row_infoB5["qty_qc"])."','".sql_esc($row_infoB5["qty_qc_ok"])."','".sql_esc($row_infoB5["qty_qc_NG"])."','".sql_esc($row_infoB5["UOM_unit"])."','".sql_esc($row_infoB5["comp_code"])."','".sql_esc($row_infoB5["work_center"])."','".sql_esc($row_infoB5["shift_day"])."','".sql_esc($row_infoB5["date_plan"])."','".sql_esc($row_infoB5["user_posting"])."','".sql_esc($row_infoB5["date_posting"])."','".sql_esc($row_infoB5["time_posting"])."','".sql_esc($row_infoB5["status_disposal"])."','".sql_esc($row_infoB5["ploc"])."','".sql_esc($row_infoB5["ploc_prod_reject"])."','".sql_esc($row_infoB5["ploc_qc_reject"])."','".sql_esc($row_infoB5["proc_reject"])."','".sql_esc($row_infoB5["type_reject"])."','".sql_esc($row_infoB5["type_defect"])."','".sql_esc($row_infoB5["reason_reject"])."','".sql_esc($row_infoB5["user_reject"])."','".sql_esc($row_infoB5["date_reject"])."','".sql_esc($row_infoB5["time_reject"])."','".sql_esc($row_infoB5["qty_wastage"])."','".sql_esc($row_infoB5["type_wastage"])."','".sql_esc($row_infoB5["reason_wastage"])."','".sql_esc($row_infoB5["user_wastage"])."','".sql_esc($row_infoB5["date_wastage"])."','".sql_esc($row_infoB5["time_wastage"])."','".sql_esc($row_infoB5["user_disposal"])."','".sql_esc($row_infoB5["date_disposal"])."','".sql_esc($row_infoB5["remarks"])."','".sql_esc($row_infoB5["status_part"])."','".sql_esc($row_infoB5["user_update"])."','".sql_esc($row_infoB5["date_update"])."','".sql_esc($row_infoB5["status_approved"])."','".sql_esc($row_infoB5["approved_by"])."','".sql_esc($row_infoB5["date_approved"])."','".sql_esc($row_infoB5["remark_approved"])."','".sql_esc($row_infoB5["status_approved2"])."','".sql_esc($row_infoB5["approved_by2"])."','".sql_esc($row_infoB5["date_approved2"])."','".sql_esc($row_infoB5["remark_approved2"])."','".sql_esc($row_infoB5["status_approved3"])."','".sql_esc($row_infoB5["approved_by3"])."','".sql_esc($row_infoB5["date_approved3"])."','".sql_esc($row_infoB5["remark_approved3"])."','".sql_esc($row_infoB5["status_approved4"])."','".sql_esc($row_infoB5["approved_by4"])."','".sql_esc($row_infoB5["date_approved4"])."','".sql_esc($row_infoB5["remark_approved4"])."','".sql_esc($row_infoB5["status_approved5"])."','".sql_esc($row_infoB5["approved_by5"])."','".sql_esc($row_infoB5["date_approved5"])."','".sql_esc($row_infoB5["remark_approved5"])."','".sql_esc($row_infoB5["cost_center"])."','".sql_esc($row_infoB5["id_factory"])."','".sql_esc($row_infoB5["disposal_no_ref"])."','".sql_esc($row_infoB5["user_cancel"])."','".sql_esc($row_infoB5["date_cancel"])."','".sql_esc($row_infoB5["remark_cancel"])."','".sql_esc($row_infoB5["plant_cd"])."','".sql_esc($row_infoB5["shift_posting"])."','".sql_esc($row_infoB5["stamp_ind"])."','".sql_esc($row_infoB5["reject_source"])."','".sql_esc($row_infoB5["back_no"])."','".sql_esc($row_infoB5["kanban_no"])."','".sql_esc($row_infoB5["SAP_ref_doc"])."','".sql_esc($row_infoB5["SAP_ref_doc_can"])."')";
$result_ins_dis5 = mysqli_query($dbc,$query_ins_dis5);  



    $query_cancelDis5 = "UPDATE prd_creject_detail SET ref_doc_dis = '".sql_esc($ref25)."', status_dis = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW() WHERE doc_dis = '".sql_esc($uid4)."'";
	$result_cancelDis5 = mysqli_query($dbc,$query_cancelDis5); 


	
	    	//update count_max----------------------------------------
	 
		  if($_POST["plant_code"] == '3100')
		{
	  
		   $query_max_a5 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number25)."', date_updated = NOW() WHERE uid = '30'";
		   $result_max_a5 = mysqli_query($dbc,$query_max_a5);
	
		}elseif($_POST["plant_code"] == '3101')
		{
		   $query_max_b5 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number25)."', date_updated = NOW() WHERE uid = '79'";
		   $result_max_b5 = mysqli_query($dbc,$query_max_b5);
		 
		}
	
		  //-----------------------------end 351---------------------------------------  
	  }else{
		  
		  
	  }  // end else
	
	

	
	
	
	
	
	
	
	
	
	



?>