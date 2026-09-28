;<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$buid2 = base64_decode($_GET["buid"]);
$uid = base64_decode($_GET["uid2"]);

$qry = mysqli_query($dbc,"SELECT *, DATE_FORMAT(date_posting,'%d%m%Y') AS R, DATE_FORMAT(date_create,'%Y-%m-%d') AS R2, DATE_FORMAT(date_create,'%H:%i:%s') AS R3 FROM pps_detail_trn_fg_pending_confirm WHERE bflush_no = '".sql_esc($buid2)."'");
$data = "";
while($row = mysqli_fetch_array($qry)) {
	
	
	if($row["status_butn"] == "OK")
	 {	
	
	 $qty_nw = (intval($row['qty_OK']));
		
	 }
	 
	 if($row["status_butn"] == "REWORK")
	 {	
	
	 $qty_nw = (intval($row['qty_REWORK']));
		
	 }
	  	
	  if($row["status_butn"] == "NG")
	 {	 
	
	$qty_nw = (intval($row['qty_NG']));
		
	 }
	
		
  //-----FINISH GOODS (2300)---------
  
  if($row["material_type"] == "Z301")	
  {
	
  $data .= $row['bflush_no'].";".$row['R'].";".$row['material_no'].";".$qty_nw.";".$row['plan_no'].";".$row['plant_code'].";131;".$row['ploc']."\r\n";
  
  }elseif($row["material_type"] == "Z201")
  {
	  
	 $data .= $row['bflush_no'].";".$row['R'].";".$row['material_no'].";".$qty_nw.";".$row['plan_no'].";".$row['plant_code'].";131;".$row['ploc']."\r\n"; 
	  
  }else{
	 
	  $data .= $row['bflush_no'].";".$row['R'].";".$row['material_no'].";".$qty_nw.";".$row['plan_no'].";".$row['plant_code'].";131;".$row['ploc']."\r\n"; 
	   
  }
     
}

$filen="BF".$buid2;
//$csv_filename = $filen."_".date("YmdHis",time());

$file = "../FromPortal/BF_PENDING_CONFIRM/".$filen.".csv";
//chmod($file, 0777);
file_put_contents($file,$data);
   
   
    //----colect data --------------
  $query_collect = "SELECT *, DATE_FORMAT(A1.date_posting,'%Y-%m-%d') AS M FROM pps_detail_trn_fg_pending_confirm AS A1, sc_prd_planning_pending_confirm AS A2 WHERE A2.id_scan = A1.id_scan AND A1.bflush_no = '".sql_esc($buid2)."'";
  $rst_collect = mysqli_query($dbc,$query_collect);
  $data_collect = mysqli_fetch_array($rst_collect);
  
    //--------Quantity-------------------
	
	if($data_collect["status_butn"] == "OK")
	 {	
	
	 $qty_nw2 = (intval($data_collect['qty_OK']));
		
	 }
	 
	 if($data_collect["status_butn"] == "REWORK")
	 {	
	
	 $qty_nw2 = (intval($data_collect['qty_REWORK']));
		
	 }
	  	
	  if($data_collect["status_butn"] == "NG")
	 {	 
	
	$qty_nw2 = (intval($data_collect['qty_NG']));
		
	 }

 
     //--------insert into table ftp_bflush_detail
  
     $query_ftp_info = "INSERT INTO ftp_bflush_detail_fg_pending_confirm(id,file_name,bflush_pending,bflush_no,ref_id,plan_no,material_no,material_desc,qty_ftp,uom,status_ftp,posting_date,posting_time,user_create,date_create,plant_code,stamp_ind) VALUES('','".sql_esc($filen)."','".sql_esc($data_collect["bflush_pending"])."','".sql_esc($buid2)."','".sql_esc($data_collect["ref_id"])."','".sql_esc($data_collect["plan_no"])."','".sql_esc($data_collect["material_no"])."','".sql_esc($data_collect["material_desc"])."','".sql_esc($qty_nw2)."','".sql_esc($data_collect["scan_uom"])."','Y','".sql_esc($data_collect["M"])."','".sql_esc($data_collect["time_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($data_collect["plant_code"])."','".sql_esc($data_collect["material_type"])."')"; 
     $rst_ftp_info = mysqli_query($dbc,$query_ftp_info);
   
     // ---update status 

		$query_ftp = "UPDATE pps_detail_trn_fg_pending_confirm SET status_ftp_bflush = 'Y' WHERE bflush_no = '".sql_esc($buid2)."'";
		$rst_query_ftp = mysqli_query($dbc,$query_ftp); //or die ("Error in query: $query_ftp"); 
		
				
		if($rst_query_ftp > 0)
		{
			
		/*echo "<script>";
		echo "window.location='confirm_backflush_tran_Pend-confirm.php'";
		echo "</script>";
		exit(); //quit the script
		*/
		
		//----info print tag --------------
	 
  $query_p_tag = "SELECT * FROM pps_detail_trn_fg_pending_confirm AS A1, sc_prd_planning_pending_confirm AS A2 WHERE A2.id_scan = A1.id_scan AND A1.bflush_no = '".sql_esc($buid2)."'";
  $rst_p_tag = mysqli_query($dbc,$query_p_tag);
  $data_p_tag = mysqli_fetch_array($rst_p_tag);		
			
		if($data_p_tag["status_butn"] == "OK")
			{
				
			if($data_p_tag["stamp_ind"] == "STM")
			{
				if($data_p_tag["material_type"] == "Z301")
				{
				
				$buid =	base64_encode($buid2);
		
				echo "<script>";
				//echo "alert('FTP Transferred to SAP.');";
				echo "window.open('detail_print_tag_bfPendConf_ind_stm.php?buid=$buid', '_blank');";
				echo "window.location='confirm_backflush_tran_Pend-confirm.php';"; 
				echo "</script>";
				exit(); //quit the script
					
				}elseif($data_p_tag["material_type"] == "Z201")
			    {
					
					
				$buid =	base64_encode($buid2);
		
				echo "<script>";
				//echo "alert('FTP Transferred to SAP.');";
				echo "window.open('detail_print_tag_bfPendConf_ind_stm2.php?buid=$buid', '_blank');";
				echo "window.location='confirm_backflush_tran_Pend-confirm.php';"; 
				echo "</script>";
				exit(); //quit the script
				
				}else{
					
				echo "<script>";
				echo "window.location='confirm_backflush_tran_Pend-confirm.php';"; 
				echo "</script>";
				exit(); //quit the script
				
				}// material type
					
			}elseif($data_p_tag["stamp_ind"] == "ASSY")
			{		
		
				$buid =	base64_encode($buid2);
				
				echo "<script>";
				//echo "alert('FTP Transferred to SAP.');";
				echo "window.open('detail_print_tag_bfPendConf_ind.php?buid=$buid', '_blank');";
				echo "window.location='confirm_backflush_tran_Pend-confirm.php';"; 
				echo "</script>";
				exit(); //quit the script
				
				
			}elseif($data_p_tag["stamp_ind"] == "BLK")
			{
			
			  if($data_p_tag["material_type"] == "Z301")
				{
			
			   $buid =	base64_encode($buid2);
				
				echo "<script>";
				//echo "alert('FTP Transferred to SAP.');";
				echo "window.open('detail_print_tag_bfPendConf_ind.php?buid=$buid', '_blank');";
				echo "window.location='confirm_backflush_tran_Pend-confirm.php';"; 
				echo "</script>";
				exit(); //quit the script
			
			  }elseif($data_p_tag["material_type"] == "Z101")
			    {
			    
				$buid =	base64_encode($buid2);
				
				echo "<script>";
				//echo "alert('FTP Transferred to SAP.');";
				echo "window.open('detail_print_tag_bfPendConf_ind_RM.php?buid=$buid', '_blank');";
				echo "window.location='confirm_backflush_tran_Pend-confirm.php';"; 
				echo "</script>";
				exit(); //quit the script
				
					
				// mat type BLK	
					
			    }else{
					 
					 
				 }
			
			
			}else{
				
				
				echo "<script>";
				echo "alert('Error. Cannot Generate Tag');";
				echo "window.location='confirm_backflush_tran_Pend-confirm.php';"; 
				echo "</script>";
				exit(); //quit the script	
				
			} //stamp_ind
			
			}else{
                
				
				echo "<script>";
				echo "window.location='confirm_backflush_tran_Pend-confirm.php';"; 
				echo "</script>";
				exit(); //quit the script	
				
			}// status_butn
		
	      } //end if($rst_query_ftp)
		
      
    
?>
