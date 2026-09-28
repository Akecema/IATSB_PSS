<?php
    
     
	  if($sta_out == "311")
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
   
   
   
   // ---------update cancel Disposal and revert to original table--------------------------
	 
	$query_cancelGR1 = new PreparedSql("UPDATE disposal_detail_prd_all SET disposal_no_ref = ?, status_disposal = ?, user_cancel = ?, date_cancel = NOW() WHERE doc_dis = ? AND status_disposal = ?", [$ref21, $rst_sta4["status_desc"], $username, $uid4, $rst_sta15["status_desc"]]);
	$result_cancelGR1 = db_query($dbc, $query_cancelGR1);
	
	 
	  
	   $query_infoB1 = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid4)."' AND id = '".sql_esc($data_info5["id"])."' AND status_disposal = '".sql_esc($rst_sta4["status_desc"])."' AND disposal_no_ref = '".sql_esc($ref21)."'";
	   $result_infoB1 = mysqli_query($dbc,$query_infoB1);
	   $row_infoB1 = mysqli_fetch_array($result_infoB1);
	  
	 // echo $row_infoB["id_disposal"];	
	 
	  $query_ins_dis1 = new PreparedSql("INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$row_infoB1["id"], $row_infoB1["id_disposal"], $row_infoB1["doc_dis"], $row_infoB1["doc_disposal_no"], $row_infoB1["bflush_hwork"], $row_infoB1["bflush_rework"], $row_infoB1["bflush_pending"], $row_infoB1["bflush_qqc_no"], $row_infoB1["plan_no"], $row_infoB1["uid"], $row_infoB1["material_no"], $row_infoB1["material_desc"], $row_infoB1["material_type"], $row_infoB1["model_code"], $row_infoB1["qty_plan"], $row_infoB1["qty_actual"], $row_infoB1["qty_balance"], $row_infoB1["qty_NG"], $row_infoB1["qty_qc"], $row_infoB1["qty_qc_ok"], $row_infoB1["qty_qc_NG"], $row_infoB1["UOM_unit"], $row_infoB1["comp_code"], $row_infoB1["work_center"], $row_infoB1["shift_day"], $row_infoB1["date_plan"], $row_infoB1["user_posting"], $row_infoB1["date_posting"], $row_infoB1["time_posting"], $row_infoB1["status_disposal"], $row_infoB1["ploc"], $row_infoB1["ploc_prod_reject"], $row_infoB1["ploc_qc_reject"], $row_infoB1["proc_reject"], $row_infoB1["type_reject"], $row_infoB1["type_defect"], $row_infoB1["reason_reject"], $row_infoB1["user_reject"], $row_infoB1["date_reject"], $row_infoB1["time_reject"], $row_infoB1["qty_wastage"], $row_infoB1["type_wastage"], $row_infoB1["reason_wastage"], $row_infoB1["user_wastage"], $row_infoB1["date_wastage"], $row_infoB1["time_wastage"], $row_infoB1["user_disposal"], $row_infoB1["date_disposal"], $row_infoB1["remarks"], $row_infoB1["status_part"], $row_infoB1["user_update"], $row_infoB1["date_update"], $row_infoB1["status_approved"], $row_infoB1["approved_by"], $row_infoB1["date_approved"], $row_infoB1["remark_approved"], $row_infoB1["status_approved2"], $row_infoB1["approved_by2"], $row_infoB1["date_approved2"], $row_infoB1["remark_approved2"], $row_infoB1["status_approved3"], $row_infoB1["approved_by3"], $row_infoB1["date_approved3"], $row_infoB1["remark_approved3"], $row_infoB1["status_approved4"], $row_infoB1["approved_by4"], $row_infoB1["date_approved4"], $row_infoB1["remark_approved4"], $row_infoB1["status_approved5"], $row_infoB1["approved_by5"], $row_infoB1["date_approved5"], $row_infoB1["remark_approved5"], $row_infoB1["cost_center"], $row_infoB1["id_factory"], $row_infoB1["disposal_no_ref"], $row_infoB1["user_cancel"], $row_infoB1["date_cancel"], $row_infoB1["remark_cancel"], $row_infoB1["plant_cd"], $row_infoB1["shift_posting"], $row_infoB1["stamp_ind"], $row_infoB1["reject_source"], $row_infoB1["back_no"], $row_infoB1["kanban_no"], $row_infoB1["SAP_ref_doc"], $row_infoB1["SAP_ref_doc_can"]]);
$result_ins_dis1 = db_query($dbc, $query_ins_dis1);
	
	
	$query_cancelDis1 = "UPDATE disposal_detail_prd_ng SET doc_dis = '', doc_disposal_no = '', status_disposal = '".sql_esc($rst_sta["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW() WHERE doc_dis = '".sql_esc($uid4)."' AND status_disposal != '".sql_esc($rst_sta4["status_desc"])."'";
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
		  
		  //------generate Material Document No. Cancellation for Disposal Pending NG Generate.---------------------------------
				
				 if($_POST["plant_code"] == '3100')
				{
				
				 $query_id22 = "SELECT * FROM run_count_itsb WHERE uid = '24'";
				 $result_id22 = mysqli_query($dbc,$query_id22);
				
				}elseif($_POST["plant_code"] == '3101')
				{
					
				 $query_id22 = "SELECT * FROM run_count_itsb WHERE uid = '75'";
				 $result_id22 = mysqli_query($dbc,$query_id22);
					
				}
				
				if ($result_id22) 
			{
				$nrows22 = mysqli_num_rows($result_id22);
				$row_id22 = mysqli_fetch_array($result_id22);
				
				$dht22 = 00000; 
				$dht_OK22 = "322";
				$dg22 = 0;
			
				if($row_id22["count_max"] <= 0)
				{ 
			   
					$lastID22 = ($row_id22["count_max"] + 1);
					$dg22 = ($dht22 + ($lastID22));
			   }
			   else
			   {
				  $lastID22 = ($row_id22["count_max"] + 1);
				  $dg22 =  $lastID22;
				
				}
				$number22 = $dg22; // Length of running no
				$number22 = sprintf('%03d', $number22);  
				
				$ref22 = (($row_id22["start_ref"]).$dht_OK22.$date_run.($number22));
				
				} // end if $result_id2	
   
   
   
   // ---------update cancel Disposal and revert to original table--------------------------
	 
	$query_cancelGR2 = new PreparedSql("UPDATE disposal_detail_prd_all SET disposal_no_ref = ?, status_disposal = ?, user_cancel = ?, date_cancel = NOW() WHERE doc_dis = ? AND status_disposal = ?", [$ref22, $rst_sta4["status_desc"], $username, $uid4, $rst_sta15["status_desc"]]);
	$result_cancelGR2 = db_query($dbc, $query_cancelGR2);	 
	  
	   $query_infoB2 = new PreparedSql("SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = ? AND id = ? AND status_disposal = ?", [$uid4, $data_info5["id"], $rst_sta4["status_desc"]]);
	   $result_infoB2 = db_query($dbc, $query_infoB2);
	   $row_infoB2 = mysqli_fetch_array($result_infoB2);
	  
	 // echo $row_infoB["id_disposal"];		 
	 
	  $query_ins_dis2 = new PreparedSql("INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$row_infoB2["id"], $row_infoB2["id_disposal"], $row_infoB2["doc_dis"], $row_infoB2["doc_disposal_no"], $row_infoB2["bflush_hwork"], $row_infoB2["bflush_rework"], $row_infoB2["bflush_pending"], $row_infoB2["bflush_qqc_no"], $row_infoB2["plan_no"], $row_infoB2["uid"], $row_infoB2["material_no"], $row_infoB2["material_desc"], $row_infoB2["material_type"], $row_infoB2["model_code"], $row_infoB2["qty_plan"], $row_infoB2["qty_actual"], $row_infoB2["qty_balance"], $row_infoB2["qty_NG"], $row_infoB2["qty_qc"], $row_infoB2["qty_qc_ok"], $row_infoB2["qty_qc_NG"], $row_infoB2["UOM_unit"], $row_infoB2["comp_code"], $row_infoB2["work_center"], $row_infoB2["shift_day"], $row_infoB2["date_plan"], $row_infoB2["user_posting"], $row_infoB2["date_posting"], $row_infoB2["time_posting"], $row_infoB2["status_disposal"], $row_infoB2["ploc"], $row_infoB2["ploc_prod_reject"], $row_infoB2["ploc_qc_reject"], $row_infoB2["proc_reject"], $row_infoB2["type_reject"], $row_infoB2["type_defect"], $row_infoB2["reason_reject"], $row_infoB2["user_reject"], $row_infoB2["date_reject"], $row_infoB2["time_reject"], $row_infoB2["qty_wastage"], $row_infoB2["type_wastage"], $row_infoB2["reason_wastage"], $row_infoB2["user_wastage"], $row_infoB2["date_wastage"], $row_infoB2["time_wastage"], $row_infoB2["user_disposal"], $row_infoB2["date_disposal"], $row_infoB2["remarks"], $row_infoB2["status_part"], $row_infoB2["user_update"], $row_infoB2["date_update"], $row_infoB2["status_approved"], $row_infoB2["approved_by"], $row_infoB2["date_approved"], $row_infoB2["remark_approved"], $row_infoB2["status_approved2"], $row_infoB2["approved_by2"], $row_infoB2["date_approved2"], $row_infoB2["remark_approved2"], $row_infoB2["status_approved3"], $row_infoB2["approved_by3"], $row_infoB2["date_approved3"], $row_infoB2["remark_approved3"], $row_infoB2["status_approved4"], $row_infoB2["approved_by4"], $row_infoB2["date_approved4"], $row_infoB2["remark_approved4"], $row_infoB2["status_approved5"], $row_infoB2["approved_by5"], $row_infoB2["date_approved5"], $row_infoB2["remark_approved5"], $row_infoB2["cost_center"], $row_infoB2["id_factory"], $row_infoB2["disposal_no_ref"], $row_infoB2["user_cancel"], $row_infoB2["date_cancel"], $row_infoB2["remark_cancel"], $row_infoB2["plant_cd"], $row_infoB2["shift_posting"], $row_infoB2["stamp_ind"], $row_infoB2["reject_source"], $row_infoB2["back_no"], $row_infoB2["kanban_no"], $row_infoB2["SAP_ref_doc"], $row_infoB2["SAP_ref_doc_can"]]);
$result_ins_dis2 = db_query($dbc, $query_ins_dis2);
 
		  
	$query_cancelDis2 = new PreparedSql("UPDATE disposal_detail_prd_pending_confirm SET doc_dis = '', doc_disposal_no = '', status_disposal = ?, user_update = ?, date_update = NOW() WHERE doc_dis = ?", [$rst_sta["status_desc"], $username, $uid4]);
	$result_cancelDis2 = db_query($dbc, $query_cancelDis2); 
	
	
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
		  
		    //------generate Material Document No. Cancellation for Disposal Hnadwork NG Generate.---------------------------------
				
								
				 $query_id23 = "SELECT * FROM run_count_itsb WHERE uid = '26'";
				 $result_id23 = mysqli_query($dbc,$query_id23);
				
				
				if ($result_id23) 
			{
				$nrows23 = mysqli_num_rows($result_id23);
				$row_id23 = mysqli_fetch_array($result_id23);
				
				$dht23 = 00000; 
				$dht_OK23 = "332";
				$dg23 = 0;
			
				if($row_id23["count_max"] <= 0)
				{ 
			   
					$lastID23 = ($row_id23["count_max"] + 1);
					$dg23 = ($dht23 + ($lastID23));
			   }
			   else
			   {
				  $lastID23 = ($row_id23["count_max"] + 1);
				  $dg23 =  $lastID23;
				
				}
				$number23 = $dg23; // Length of running no
				$number23 = sprintf('%03d', $number23);  
				
				$ref23 = (($row_id23["start_ref"]).$dht_OK23.$date_run.($number23));
				
				} // end if $result_id2	
   
   
   
   // ---------update cancel Disposal and revert to original table--------------------------
	 
	$query_cancelGR3 = new PreparedSql("UPDATE disposal_detail_prd_all SET disposal_no_ref = ?, status_disposal = ?, user_cancel = ?, date_cancel = NOW() WHERE doc_dis = ? AND status_disposal = ?", [$ref23, $rst_sta4["status_desc"], $username, $uid4, $rst_sta15["status_desc"]]);
	$result_cancelGR3 = db_query($dbc, $query_cancelGR3);	 
	  
	   $query_infoB3 = new PreparedSql("SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = ? AND id = ? AND status_disposal = ?", [$uid4, $data_info5["id"], $rst_sta4["status_desc"]]);
	   $result_infoB3 = db_query($dbc, $query_infoB3);
	   $row_infoB3 = mysqli_fetch_array($result_infoB3);
	  
	 // echo $row_infoB["id_disposal"];		
		 $query_ins_dis3 = new PreparedSql("INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$row_infoB3["id"], $row_infoB3["id_disposal"], $row_infoB3["doc_dis"], $row_infoB3["doc_disposal_no"], $row_infoB3["bflush_hwork"], $row_infoB3["bflush_rework"], $row_infoB3["bflush_pending"], $row_infoB3["bflush_qqc_no"], $row_infoB3["plan_no"], $row_infoB3["uid"], $row_infoB3["material_no"], $row_infoB3["material_desc"], $row_infoB3["material_type"], $row_infoB3["model_code"], $row_infoB3["qty_plan"], $row_infoB3["qty_actual"], $row_infoB3["qty_balance"], $row_infoB3["qty_NG"], $row_infoB3["qty_qc"], $row_infoB3["qty_qc_ok"], $row_infoB3["qty_qc_NG"], $row_infoB3["UOM_unit"], $row_infoB3["comp_code"], $row_infoB3["work_center"], $row_infoB3["shift_day"], $row_infoB3["date_plan"], $row_infoB3["user_posting"], $row_infoB3["date_posting"], $row_infoB3["time_posting"], $row_infoB3["status_disposal"], $row_infoB3["ploc"], $row_infoB3["ploc_prod_reject"], $row_infoB3["ploc_qc_reject"], $row_infoB3["proc_reject"], $row_infoB3["type_reject"], $row_infoB3["type_defect"], $row_infoB3["reason_reject"], $row_infoB3["user_reject"], $row_infoB3["date_reject"], $row_infoB3["time_reject"], $row_infoB3["qty_wastage"], $row_infoB3["type_wastage"], $row_infoB3["reason_wastage"], $row_infoB3["user_wastage"], $row_infoB3["date_wastage"], $row_infoB3["time_wastage"], $row_infoB3["user_disposal"], $row_infoB3["date_disposal"], $row_infoB3["remarks"], $row_infoB3["status_part"], $row_infoB3["user_update"], $row_infoB3["date_update"], $row_infoB3["status_approved"], $row_infoB3["approved_by"], $row_infoB3["date_approved"], $row_infoB3["remark_approved"], $row_infoB3["status_approved2"], $row_infoB3["approved_by2"], $row_infoB3["date_approved2"], $row_infoB3["remark_approved2"], $row_infoB3["status_approved3"], $row_infoB3["approved_by3"], $row_infoB3["date_approved3"], $row_infoB3["remark_approved3"], $row_infoB3["status_approved4"], $row_infoB3["approved_by4"], $row_infoB3["date_approved4"], $row_infoB3["remark_approved4"], $row_infoB3["status_approved5"], $row_infoB3["approved_by5"], $row_infoB3["date_approved5"], $row_infoB3["remark_approved5"], $row_infoB3["cost_center"], $row_infoB3["id_factory"], $row_infoB3["disposal_no_ref"], $row_infoB3["user_cancel"], $row_infoB3["date_cancel"], $row_infoB3["remark_cancel"], $row_infoB3["plant_cd"], $row_infoB3["shift_posting"], $row_infoB3["stamp_ind"], $row_infoB3["reject_source"], $row_infoB3["back_no"], $row_infoB3["kanban_no"], $row_infoB3["SAP_ref_doc"], $row_infoB3["SAP_ref_doc_can"]]);
$result_ins_dis3 = db_query($dbc, $query_ins_dis3);  
		  
		  
		
    $query_cancelDis3 = new PreparedSql("UPDATE disposal_detail_prd_pending_confirm_hwork SET doc_dis = '', doc_disposal_no = '', status_disposal = ?, user_update = ?, date_update = NOW() WHERE doc_dis = ?", [$rst_sta["status_desc"], $username, $uid4]);
	$result_cancelDis3 = db_query($dbc, $query_cancelDis3); 
	
	  if($_POST["plant_code"] == '3100')
		{
	      //update count_max----------------------------------------

		   $query_max_a3 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number23)."', date_updated = NOW() WHERE uid = '26'";
		   $result_max_a3 = mysqli_query($dbc,$query_max_a3);
	
		}
	//-----------------------------end 331---------------------------------------  
		  
	  }elseif($sta_out == "341")
	  {
		  
	 //------generate Material Document No. Cancellation for Disposal Rework NG Generate.---------------------------------
				
				if($_POST["plant_code"] == '3100')
				{
				
				 $query_id24 = "SELECT * FROM run_count_itsb WHERE uid = '28'";
				 $result_id24 = mysqli_query($dbc,$query_id24);
				
				}elseif($_POST["plant_code"] == '3101')
				{
					
				 $query_id24 = "SELECT * FROM run_count_itsb WHERE uid = '77'";
				 $result_id24 = mysqli_query($dbc,$query_id24);
					
				}
				
				
				if ($result_id24) 
			{
				$nrows24 = mysqli_num_rows($result_id24);
				$row_id24 = mysqli_fetch_array($result_id24);
				
				$dht24 = 00000; 
				$dht_OK24 = "342";
				$dg24 = 0;
			
				if($row_id24["count_max"] <= 0)
				{ 
			   
					$lastID24 = ($row_id24["count_max"] + 1);
					$dg24 = ($dht24 + ($lastID24));
			   }
			   else
			   {
				  $lastID24 = ($row_id24["count_max"] + 1);
				  $dg24 =  $lastID24;
				
				}
				$number24 = $dg24; // Length of running no
				$number24 = sprintf('%03d', $number24);  
				
				$ref24 = (($row_id24["start_ref"]).$dht_OK24.$date_run.($number24));
				
				} // end if $result_id2	
   
   
   
   // ---------update cancel Disposal and revert to original table--------------------------
	 
	$query_cancelGR4 = new PreparedSql("UPDATE disposal_detail_prd_all SET disposal_no_ref = ?, status_disposal = ?, user_cancel = ?, date_cancel = NOW() WHERE doc_dis = ? AND status_disposal = ?", [$ref24, $rst_sta4["status_desc"], $username, $uid4, $rst_sta15["status_desc"]]);
	$result_cancelGR4 = db_query($dbc, $query_cancelGR4);	 
	  
	   $query_infoB4 = new PreparedSql("SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = ? AND id = ? AND status_disposal = ?", [$uid4, $data_info5["id"], $rst_sta4["status_desc"]]);
	   $result_infoB4 = db_query($dbc, $query_infoB4);
	   $row_infoB4 = mysqli_fetch_array($result_infoB4);
	  
	 // echo $row_infoB["id_disposal"];	
	 
	  $query_ins_dis4 = new PreparedSql("INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$row_infoB4["id"], $row_infoB4["id_disposal"], $row_infoB4["doc_dis"], $row_infoB4["doc_disposal_no"], $row_infoB4["bflush_hwork"], $row_infoB4["bflush_rework"], $row_infoB4["bflush_pending"], $row_infoB4["bflush_qqc_no"], $row_infoB4["plan_no"], $row_infoB4["uid"], $row_infoB4["material_no"], $row_infoB4["material_desc"], $row_infoB4["material_type"], $row_infoB4["model_code"], $row_infoB4["qty_plan"], $row_infoB4["qty_actual"], $row_infoB4["qty_balance"], $row_infoB4["qty_NG"], $row_infoB4["qty_qc"], $row_infoB4["qty_qc_ok"], $row_infoB4["qty_qc_NG"], $row_infoB4["UOM_unit"], $row_infoB4["comp_code"], $row_infoB4["work_center"], $row_infoB4["shift_day"], $row_infoB4["date_plan"], $row_infoB4["user_posting"], $row_infoB4["date_posting"], $row_infoB4["time_posting"], $row_infoB4["status_disposal"], $row_infoB4["ploc"], $row_infoB5["ploc_prod_reject"], $row_infoB4["ploc_qc_reject"], $row_infoB4["proc_reject"], $row_infoB4["type_reject"], $row_infoB4["type_defect"], $row_infoB4["reason_reject"], $row_infoB4["user_reject"], $row_infoB4["date_reject"], $row_infoB4["time_reject"], $row_infoB4["qty_wastage"], $row_infoB4["type_wastage"], $row_infoB4["reason_wastage"], $row_infoB4["user_wastage"], $row_infoB4["date_wastage"], $row_infoB4["time_wastage"], $row_infoB4["user_disposal"], $row_infoB4["date_disposal"], $row_infoB4["remarks"], $row_infoB4["status_part"], $row_infoB4["user_update"], $row_infoB4["date_update"], $row_infoB4["status_approved"], $row_infoB4["approved_by"], $row_infoB4["date_approved"], $row_infoB4["remark_approved"], $row_infoB4["status_approved2"], $row_infoB4["approved_by2"], $row_infoB4["date_approved2"], $row_infoB4["remark_approved2"], $row_infoB4["status_approved3"], $row_infoB4["approved_by3"], $row_infoB4["date_approved3"], $row_infoB4["remark_approved3"], $row_infoB4["status_approved4"], $row_infoB4["approved_by4"], $row_infoB4["date_approved4"], $row_infoB4["remark_approved4"], $row_infoB4["status_approved5"], $row_infoB4["approved_by5"], $row_infoB4["date_approved5"], $row_infoB4["remark_approved5"], $row_infoB4["cost_center"], $row_infoB4["id_factory"], $row_infoB4["disposal_no_ref"], $row_infoB4["user_cancel"], $row_infoB4["date_cancel"], $row_infoB4["remark_cancel"], $row_infoB4["plant_cd"], $row_infoB4["shift_posting"], $row_infoB4["stamp_ind"], $row_infoB4["reject_source"], $row_infoB4["back_no"], $row_infoB4["kanban_no"], $row_infoB4["SAP_ref_doc"], $row_infoB4["SAP_ref_doc_can"]]);
$result_ins_dis4 = db_query($dbc, $query_ins_dis4);
	 		  
		  
    $query_cancelDis4 = new PreparedSql("UPDATE disposal_detail_prd_pending_confirm_rework SET doc_dis = '', doc_disposal_no = '', status_disposal = ?, user_update = ?, date_update = NOW() WHERE doc_dis = ?", [$rst_sta["status_desc"], $username, $uid4]);
	$result_cancelDis4 = db_query($dbc, $query_cancelDis4); 
	
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
		  //------generate Material Document No. Cancellation for CR(component reject) Generate.---------------------------------
				
				 if($_POST["plant_code"] == '3100')
				{
				
				 $query_id25 = "SELECT * FROM run_count_itsb WHERE uid = '30'";
				 $result_id25 = mysqli_query($dbc,$query_id25);
				
				}elseif($_POST["plant_code"] == '3101')
				{
					
				 $query_id25 = "SELECT * FROM run_count_itsb WHERE uid = '79'";
				 $result_id25 = mysqli_query($dbc,$query_id25);
					
				}
				
				if ($result_id25) 
			{
				$nrows25 = mysqli_num_rows($result_id25);
				$row_id25 = mysqli_fetch_array($result_id25);
				
				$dht25 = 00000; 
				$dht_OK25 = "352";
				$dg25 = 0;
			
				if($row_id25["count_max"] <= 0)
				{ 
			   
					$lastID25 = ($row_id25["count_max"] + 1);
					$dg25 = ($dht25 + ($lastID25));
			   }
			   else
			   {
				  $lastID25 = ($row_id25["count_max"] + 1);
				  $dg25 =  $lastID25;
				
				}
				$number25 = $dg25; // Length of running no
				$number25 = sprintf('%03d', $number25);  
				
				$ref25 = (($row_id25["start_ref"]).$dht_OK25.$date_run.($number25));
				
				} // end if $result_id2	
				
				
				
				 // ---------update cancel Disposal and revert to original table--------------------------
	 
	 $query_cancelGR5 = new PreparedSql("UPDATE disposal_detail_prd_all SET disposal_no_ref = ?, status_disposal = ?, user_cancel = ?, date_cancel = NOW() WHERE doc_dis = ? AND status_disposal = ?", [$ref25, $rst_sta4["status_desc"], $username, $uid4, $rst_sta15["status_desc"]]);
	 $result_cancelGR5 = db_query($dbc, $query_cancelGR5);
	
	 
	  
	   $query_infoB5 = new PreparedSql("SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = ? AND id = ? AND status_disposal = ?", [$uid4, $data_info5["id"], $rst_sta4["status_desc"]]);
	   $result_infoB5 = db_query($dbc, $query_infoB5);
	   $row_infoB5 = mysqli_fetch_array($result_infoB5);
				

	  $query_ins_dis5 = new PreparedSql("INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$row_infoB5["id"], $row_infoB5["id_disposal"], $row_infoB5["doc_dis"], $row_infoB5["doc_disposal_no"], $row_infoB5["bflush_hwork"], $row_infoB5["bflush_rework"], $row_infoB5["bflush_pending"], $row_infoB5["bflush_qqc_no"], $row_infoB5["plan_no"], $row_infoB5["uid"], $row_infoB5["material_no"], $row_infoB5["material_desc"], $row_infoB5["material_type"], $row_infoB5["model_code"], $row_infoB5["qty_plan"], $row_infoB5["qty_actual"], $row_infoB5["qty_balance"], $row_infoB5["qty_NG"], $row_infoB5["qty_qc"], $row_infoB5["qty_qc_ok"], $row_infoB5["qty_qc_NG"], $row_infoB5["UOM_unit"], $row_infoB5["comp_code"], $row_infoB5["work_center"], $row_infoB5["shift_day"], $row_infoB5["date_plan"], $row_infoB5["user_posting"], $row_infoB5["date_posting"], $row_infoB5["time_posting"], $row_infoB5["status_disposal"], $row_infoB5["ploc"], $row_infoB5["ploc_prod_reject"], $row_infoB5["ploc_qc_reject"], $row_infoB5["proc_reject"], $row_infoB5["type_reject"], $row_infoB5["type_defect"], $row_infoB5["reason_reject"], $row_infoB5["user_reject"], $row_infoB5["date_reject"], $row_infoB5["time_reject"], $row_infoB5["qty_wastage"], $row_infoB5["type_wastage"], $row_infoB5["reason_wastage"], $row_infoB5["user_wastage"], $row_infoB5["date_wastage"], $row_infoB5["time_wastage"], $row_infoB5["user_disposal"], $row_infoB5["date_disposal"], $row_infoB5["remarks"], $row_infoB5["status_part"], $row_infoB5["user_update"], $row_infoB5["date_update"], $row_infoB5["status_approved"], $row_infoB5["approved_by"], $row_infoB5["date_approved"], $row_infoB5["remark_approved"], $row_infoB5["status_approved2"], $row_infoB5["approved_by2"], $row_infoB5["date_approved2"], $row_infoB5["remark_approved2"], $row_infoB5["status_approved3"], $row_infoB5["approved_by3"], $row_infoB5["date_approved3"], $row_infoB5["remark_approved3"], $row_infoB5["status_approved4"], $row_infoB5["approved_by4"], $row_infoB5["date_approved4"], $row_infoB5["remark_approved4"], $row_infoB5["status_approved5"], $row_infoB5["approved_by5"], $row_infoB5["date_approved5"], $row_infoB5["remark_approved5"], $row_infoB5["cost_center"], $row_infoB5["id_factory"], $row_infoB5["disposal_no_ref"], $row_infoB5["user_cancel"], $row_infoB5["date_cancel"], $row_infoB5["remark_cancel"], $row_infoB5["plant_cd"], $row_infoB5["shift_posting"], $row_infoB5["stamp_ind"], $row_infoB5["reject_source"], $row_infoB5["back_no"], $row_infoB5["kanban_no"], $row_infoB5["SAP_ref_doc"], $row_infoB5["SAP_ref_doc_can"]]);
$result_ins_dis5 = db_query($dbc, $query_ins_dis5);  



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
	
	
	           
		  
	  }else{
		  
		  
	  }  // end else
	
	
	
	
	
	



?>