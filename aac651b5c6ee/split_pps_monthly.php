<?php

        if(($no_t1 != "0.000") || ($no_t1 != "0") || ($no_t1 != ""))
			
			{
				 
				//$dat_t1 = '';
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t1"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($data_inform2["date_start"])."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//
			
		if(($no_t2 != "0.000") || ($no_t2 != "0") || ($no_t2 != ""))
			
			{
				 
		
		$d_p2 = substr($data_inform2["date_start"],8,2);
		$m_p2 = substr($data_inform2["date_start"],5,2);
		$y_p2 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t2 = ($y_p2.'-'.$m_p2.'-02');		 
				 
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t2"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t2)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//
			
		if(($no_t3 != "0.000") || ($no_t3 != "0") || ($no_t3 != ""))
			
			{
				 
		$d_p3 = substr($data_inform2["date_start"],8,2);
		$m_p3 = substr($data_inform2["date_start"],5,2);
		$y_p3 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t3 = ($y_p3.'-'.$m_p3.'-03');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t3"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t3)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//
			
			if(($no_t4 != "0.000") || ($no_t4 != "0") || ($no_t4 != ""))
			
			{
				 
		$d_p4 = substr($data_inform2["date_start"],8,2);
		$m_p4 = substr($data_inform2["date_start"],5,2);
		$y_p4 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t4 = ($y_p4.'-'.$m_p4.'-04');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t4"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t4)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//
			
			if(($no_t5 != "0.000") || ($no_t5 != "0") || ($no_t5 != ""))
			
			{
				 
		$d_p5 = substr($data_inform2["date_start"],8,2);
		$m_p5 = substr($data_inform2["date_start"],5,2);
		$y_p5 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t5 = ($y_p5.'-'.$m_p5.'-05');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t5"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t5)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}// $no_t5
			
			if(($no_t6 != "0.000") || ($no_t6 != "0") || ($no_t6 != ""))
			
			{
				 
		$d_p6 = substr($data_inform2["date_start"],8,2);
		$m_p6 = substr($data_inform2["date_start"],5,2);
		$y_p6 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t6 = ($y_p6.'-'.$m_p6.'-06');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t6"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t6)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}// $no_t6
			
		if(($no_t7 != "0.000") || ($no_t7 != "0") || ($no_t7 != ""))
			
			{
				 
		$d_p7 = substr($data_inform2["date_start"],8,2);
		$m_p7 = substr($data_inform2["date_start"],5,2);
		$y_p7 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t7 = ($y_p7.'-'.$m_p7.'-07');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t7"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t7)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t7
			
		if(($no_t8 != "0.000") || ($no_t8 != "0") || ($no_t8 != ""))
			
			{
				 
		$d_p8 = substr($data_inform2["date_start"],8,2);
		$m_p8 = substr($data_inform2["date_start"],5,2);
		$y_p8 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t8 = ($y_p8.'-'.$m_p8.'-08');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t8"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t8)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t8
			
		if(($no_t9 != "0.000") || ($no_t9 != "0") || ($no_t9 != ""))
			
			{
				 
		$d_p9 = substr($data_inform2["date_start"],8,2);
		$m_p9 = substr($data_inform2["date_start"],5,2);
		$y_p9 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t9 = ($y_p9.'-'.$m_p9.'-09');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t9"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t9)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t9
			
	   if(($no_t10 != "0.000") || ($no_t10 != "0") || ($no_t10 != ""))
			
			{
				 
		$d_p10 = substr($data_inform2["date_start"],8,2);
		$m_p10 = substr($data_inform2["date_start"],5,2);
		$y_p10 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t10 = ($y_p10.'-'.$m_p10.'-10');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t10"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t10)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t10
			
		if(($no_t11 != "0.000") || ($no_t11 != "0") || ($no_t11 != ""))
			
			{
				 
		$d_p11 = substr($data_inform2["date_start"],8,2);
		$m_p11 = substr($data_inform2["date_start"],5,2);
		$y_p11 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t11 = ($y_p11.'-'.$m_p11.'-11');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t11"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t11)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t11
			
		if(($no_t12 != "0.000") || ($no_t12 != "0") || ($no_t12 != ""))
			
			{
				 
		
		$d_p12 = substr($data_inform2["date_start"],8,2);
		$m_p12 = substr($data_inform2["date_start"],5,2);
		$y_p12 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t12 = ($y_p12.'-'.$m_p12.'-12');		 
				 
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t12"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t12)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t12
			
	  if(($no_t13 != "0.000") || ($no_t13 != "0") || ($no_t13 != ""))
			
			{
				 
		$d_p13 = substr($data_inform2["date_start"],8,2);
		$m_p13 = substr($data_inform2["date_start"],5,2);
		$y_p13 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t13 = ($y_p13.'-'.$m_p13.'-13');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t13"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t13)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t13
			
	  if(($no_t14 != "0.000") || ($no_t14 != "0") || ($no_t14 != ""))
			
			{
				 
		$d_p14 = substr($data_inform2["date_start"],8,2);
		$m_p14 = substr($data_inform2["date_start"],5,2);
		$y_p14 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t14 = ($y_p14.'-'.$m_p14.'-14');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t14"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t14)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_14
			
	   if(($no_t15 != "0.000") || ($no_t15 != "0") || ($no_t15 != ""))
			
			{
				 
		$d_p15 = substr($data_inform2["date_start"],8,2);
		$m_p15 = substr($data_inform2["date_start"],5,2);
		$y_p15 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t15 = ($y_p15.'-'.$m_p15.'-15');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t15"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t15)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}// $no_t15
			
		if(($no_t16 != "0.000") || ($no_t16 != "0") || ($no_t16 != ""))
			
			{
				 
		$d_p16 = substr($data_inform2["date_start"],8,2);
		$m_p16 = substr($data_inform2["date_start"],5,2);
		$y_p16 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t16 = ($y_p16.'-'.$m_p16.'-16');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t16"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t16)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}// $no_t16
			
	   if(($no_t17 != "0.000") || ($no_t17 != "0") || ($no_t17 != ""))
			
			{
				 
		$d_p17 = substr($data_inform2["date_start"],8,2);
		$m_p17 = substr($data_inform2["date_start"],5,2);
		$y_p17 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t17 = ($y_p17.'-'.$m_p17.'-17');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t17"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t17)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t17
			
		if(($no_t18 != "0.000") || ($no_t18 != "0") || ($no_t18 != ""))
			
			{
				 
		$d_p18 = substr($data_inform2["date_start"],8,2);
		$m_p18 = substr($data_inform2["date_start"],5,2);
		$y_p18 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t18 = ($y_p18.'-'.$m_p18.'-18');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t18"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t18)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t18
			
	   if(($no_t19 != "0.000") || ($no_t19 != "0") || ($no_t19 != ""))
			
			{
				 
		$d_p19 = substr($data_inform2["date_start"],8,2);
		$m_p19 = substr($data_inform2["date_start"],5,2);
		$y_p19 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t19 = ($y_p19.'-'.$m_p19.'-19');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t19"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t19)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t19
			
		if(($no_t20 != "0.000") || ($no_t20 != "0") || ($no_t20 != ""))
			
			{
				 
		$d_p20 = substr($data_inform2["date_start"],8,2);
		$m_p20 = substr($data_inform2["date_start"],5,2);
		$y_p20 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t20 = ($y_p20.'-'.$m_p20.'-20');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t20"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t20)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t20
			
		if(($no_t21 != "0.000") || ($no_t21 != "0") || ($no_t21 != ""))
			
			{
				 
		$d_p21 = substr($data_inform2["date_start"],8,2);
		$m_p21 = substr($data_inform2["date_start"],5,2);
		$y_p21 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t21 = ($y_p21.'-'.$m_p21.'-21');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t21"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t21)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t21
			
	    if(($no_t22 != "0.000") || ($no_t22 != "0") || ($no_t22 != ""))
			
			{
				 
		
		$d_p22 = substr($data_inform2["date_start"],8,2);
		$m_p22 = substr($data_inform2["date_start"],5,2);
		$y_p22 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t22 = ($y_p22.'-'.$m_p22.'-22');		 
				 
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t22"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t22)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t22
			
		if(($no_t23 != "0.000") || ($no_t23 != "0") || ($no_t23 != ""))
			
			{
				 
		$d_p23 = substr($data_inform2["date_start"],8,2);
		$m_p23 = substr($data_inform2["date_start"],5,2);
		$y_p23 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t23 = ($y_p23.'-'.$m_p23.'-23');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t23"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t23)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t23
			
		 if(($no_t24 != "0.000") || ($no_t24 != "0") || ($no_t24 != ""))
			
			{
				 
		$d_p24 = substr($data_inform2["date_start"],8,2);
		$m_p24 = substr($data_inform2["date_start"],5,2);
		$y_p24 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t24 = ($y_p24.'-'.$m_p24.'-24');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t24"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t24)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//
			
			if(($no_t25 != "0.000") || ($no_t25 != "0") || ($no_t25 != ""))
			{
				 
		$d_p25 = substr($data_inform2["date_start"],8,2);
		$m_p25 = substr($data_inform2["date_start"],5,2);
		$y_p25 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t25 = ($y_p25.'-'.$m_p25.'-25');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t25"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t25)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}// $no_t25
			
			if(($no_t26 != "0.000") || ($no_t26 != "0") || ($no_t26 != ""))
			{
				 
		$d_p26 = substr($data_inform2["date_start"],8,2);
		$m_p26 = substr($data_inform2["date_start"],5,2);
		$y_p26 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t26 = ($y_p26.'-'.$m_p26.'-26');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t26"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t26)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}// $no_t26
			
			if(($no_t27 != "0.000") || ($no_t27 != "0") || ($no_t27 != ""))
			
			{
				 
		$d_p27 = substr($data_inform2["date_start"],8,2);
		$m_p27 = substr($data_inform2["date_start"],5,2);
		$y_p27 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t27 = ($y_p27.'-'.$m_p27.'-27');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t27"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t27)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t27
			
		if(($no_t28 != "0.000") || ($no_t28 != "0") || ($no_t28 != ""))
			
			{
				 
		$d_p28 = substr($data_inform2["date_start"],8,2);
		$m_p28 = substr($data_inform2["date_start"],5,2);
		$y_p28 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t28 = ($y_p28.'-'.$m_p28.'-28');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t28"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t28)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t28
			
			
			if(($no_t29 != "0.000") || ($no_t29 != "0") || ($no_t29 != ""))
			{
				 
		$d_p29 = substr($data_inform2["date_start"],8,2);
		$m_p29 = substr($data_inform2["date_start"],5,2);
		$y_p29 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t29 = ($y_p29.'-'.$m_p29.'-29');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t29"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t29)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t29
			
			if(($no_t30 != "0.000") || ($no_t30 != "0") || ($no_t30 != ""))
			
			{
				 
		$d_p30 = substr($data_inform2["date_start"],8,2);
		$m_p30 = substr($data_inform2["date_start"],5,2);
		$y_p30 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t30 = ($y_p30.'-'.$m_p30.'-30');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t30"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t30)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t30
			
			if(($no_t31 != "0.000") || ($no_t31 != "0") || ($no_t31 != ""))
			
			{
				 
		$d_p31 = substr($data_inform2["date_start"],8,2);
		$m_p31 = substr($data_inform2["date_start"],5,2);
		$y_p31 = substr($data_inform2["date_start"],0,4);
				 
	    $dat_t31 = ($y_p31.'-'.$m_p31.'-31');	
			
			$query_F = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($data_inform2["upload_id"])."','".sql_esc($data_mat_info["material_group"])."','".sql_esc($data_inform2["mth_plan"])."','".sql_esc($data_inform2["material_no"])."','".sql_esc($data_inform2["no_t31"])."','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($data_inform2["work_center"])."','D/S','','".sql_esc($dat_t31)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','ASSY','".sql_esc($data_inform2["seq_id"])."','','".sql_esc($data_inform2["plant_code"])."','".sql_esc($data_inform2["yr_plan"])."')";
		    $result_F = mysqli_query($dbc,$query_F);
			}//$no_t31
			
			
?>			