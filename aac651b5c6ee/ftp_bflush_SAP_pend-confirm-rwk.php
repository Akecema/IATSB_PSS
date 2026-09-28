<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$buid = base64_decode($_GET["buid"]);
$uid = base64_decode($_GET["uid"]);

$qry = mysqli_query($dbc,"SELECT *, DATE_FORMAT(date_rw_posting,'%d%m%Y') AS R, DATE_FORMAT(date_create,'%Y-%m-%d') AS R2 FROM pps_detail_trn_fg_pending_confirm_rework WHERE bflush_rework = '".sql_esc($buid)."'");
$data = "";
while($row_qry = mysqli_fetch_array($qry)) {
	
	
	if($row_qry["status_butn"] == "OK")
	 {	
	
	 $qty_nw = (intval($row_qry['qty_RW_OK']));
		
	 }
	
	  	
	  if($row_qry["status_butn"] == "NG")
	 {	 
	
	$qty_nw = (intval($row_qry['qty_RW_NG']));
		
	 }
	
		
  //-----FINISH GOODS (2300)---------
  
  if($row_qry["material_type"] == "Z301")	
  {
	
  $data .= $row_qry['bflush_rework'].";".$row_qry['R'].";".$row_qry['material_no'].";".$qty_nw.";".$row_qry['plan_no'].";".$row_qry['plant_code'].";131;".$row_qry['ploc']."\r\n"; 
  
  }elseif($row_qry["material_type"] == "Z201")
  {
	  
	 $data .= $row_qry['bflush_rework'].";".$row_qry['R'].";".$row_qry['material_no'].";".$qty_nw.";".$row_qry['plan_no'].";".$row_qry['plant_code'].";131;".$row_qry['ploc']."\r\n"; 
	  
  }else{
	 
	  $data .= $row_qry['bflush_rework'].";".$row_qry['R'].";".$row_qry['material_no'].";".$qty_nw.";".$row_qry['plan_no'].";".$row_qry['plant_code'].";131;".$row_qry['ploc']."\r\n"; 
	   
  }
     
}

$filen="BF".$buid;
//$csv_filename = $filen."_".date("YmdHis",time());

$file = "../FromPortal/BF_PENDING_CONFIRM/".$filen.".csv";
//chmod($file, 0777);
file_put_contents($file,$data);
   
   
    //----colect data --------------
  $query_collect = "SELECT *, DATE_FORMAT(date_rw_posting,'%Y-%m-%d') AS M FROM pps_detail_trn_fg_pending_confirm_rework WHERE bflush_rework = '".sql_esc($buid)."'";
  $rst_collect = mysqli_query($dbc,$query_collect);
  $data_collect = mysqli_fetch_array($rst_collect);
  
    //--------Quantity-------------------
	
	if($data_collect["status_butn"] == "OK")
	 {	
	
	 $qty_nw2 = (intval($data_collect['qty_RW_OK']));
		
	 }
	  	
	  if($data_collect["status_butn"] == "NG")
	 {	 
	
	$qty_nw2 = (intval($data_collect['qty_RW_NG']));
		
	 }
	 
	  
	  
	  //-----UOM detail----
	   $query_unit = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$data_collect["material_no"]]);
	   $result_unit = db_query($dbc, $query_unit);
	   $data_unit = mysqli_fetch_array($result_unit);
	  

 
     //--------insert into table ftp_bflush_detail
  
     $query_ftp_info = "INSERT INTO ftp_bflush_detail_fg_pending_confirm_rework(id,file_name,bflush_rework,bflush_pending, bflush_no,ref_id,plan_no,material_no,material_desc,qty_ftp,uom,status_ftp,posting_date,posting_time,user_create, date_create,plant_code,stamp_ind) VALUES('','".sql_esc($filen)."','".sql_esc($buid)."','".sql_esc($data_collect["bflush_pending"])."','".sql_esc($data_collect["bflush_no"])."','".sql_esc($data_collect["ref_id"])."','".sql_esc($data_collect["plan_no"])."','".sql_esc($data_collect["material_no"])."','".sql_esc($data_collect["material_desc"])."','".sql_esc($qty_nw2)."','".sql_esc($data_unit["BUn"])."','Y','".sql_esc($data_collect["M"])."','".sql_esc($data_collect["time_rw_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($data_collect["plant_code"])."','".sql_esc($data_collect["material_type"])."')"; 
     $rst_ftp_info = mysqli_query($dbc,$query_ftp_info);
   
     // ---update status 

		$query_ftp = "UPDATE pps_detail_trn_fg_pending_confirm_rework SET status_ftp_bflush = 'Y' WHERE bflush_rework = '".sql_esc($buid)."'";
		$rst_query_ftp = mysqli_query($dbc,$query_ftp); //or die ("Error in query: $query_ftp"); 
		
		
		
	  //----info print tag --------------
	 
  $query_p_tag = "SELECT * FROM print_tag_bf_pending_confirm_rework WHERE bflush_rework = '".sql_esc($buid)."'";
  $rst_p_tag = mysqli_query($dbc,$query_p_tag);
  $data_p_tag = mysqli_fetch_array($rst_p_tag);		
			 
		if($data_p_tag["status_butn"] == "OK")
		{
			
			if($data_p_tag["stamp_ind"] == "STM")
			{
				if($data_p_tag["material_type"] == "Z301")
				{
				
				$buid =	base64_encode($buid);
		
				echo "<script>";
				//echo "alert('FTP Transferred to SAP.');";
				echo "window.open('detail_print_tag_bfPEND-RWK-OK_ind_stm.php?buid=$buid', '_blank');";
				echo "window.location='backflush_tran_Pend-confirm_rework.php';"; 
				echo "</script>";
				exit(); //quit the script
					
				}elseif($data_p_tag["material_type"] == "Z201")
			    {
					
					
				$buid =	base64_encode($buid);
		
				echo "<script>";
				//echo "alert('FTP Transferred to SAP.');";
				echo "window.open('detail_print_tag_bfPEND-RWK-OK_ind_stm2.php?buid=$buid', '_blank');";
				echo "window.location='backflush_tran_Pend-confirm_rework.php';"; 
				echo "</script>";
				exit(); //quit the script
				
				}else{
					
				echo "<script>";
				echo "window.location='backflush_tran_Pend-confirm_rework.php';"; 
				echo "</script>";
				exit(); //quit the script
				
				}
					
			}elseif($data_p_tag["stamp_ind"] == "ASSY")
			{		
		
				$buid =	base64_encode($buid);
				
				echo "<script>";
				//echo "alert('FTP Transferred to SAP.');";
				echo "window.open('detail_print_tag_bfPEND-RWK-OK_ind.php?buid=$buid', '_blank');";
				echo "window.location='backflush_tran_Pend-confirm_rework.php';"; 
				echo "</script>";
				exit(); //quit the script
				
				
			}elseif($data_p_tag["stamp_ind"] == "BLK")
			{
			
			  
			  if($data_p_tag["material_type"] == "Z301")
				{
				
				$buid =	base64_encode($buid);
		
				echo "<script>";
				//echo "alert('FTP Transferred to SAP.');";
				echo "window.open('detail_print_tag_bfPEND-RWK-OK_ind_stm.php?buid=$buid', '_blank');";
				echo "window.location='backflush_tran_Pend-confirm_rework.php';"; 
				echo "</script>";
				exit(); //quit the script
					
				}elseif($data_p_tag["material_type"] == "Z101")
			    {
			
			
			   $buid =	base64_encode($buid);
		
				echo "<script>";
				//echo "alert('FTP Transferred to SAP.');";
				echo "window.open('detail_print_tag_bfPEND-RWK-OK_ind_RM.php?buid=$buid', '_blank');";
				echo "window.location='backflush_tran_Pend-confirm_rework.php';"; 
				echo "</script>";
				exit(); //quit the script
			
				}else{
					
					
				}	// mat type BLK	
			
		
			
			
			}else{
				
				
				echo "<script>";
				echo "alert('Error. Cannot Generate Tag');";
				echo "window.location='backflush_tran_Pend-confirm_rework.php';"; 
				echo "</script>";
				exit(); //quit the script	
				
			}

		
		}else{
			
		        echo "<script>";
				echo "window.location='backflush_tran_Pend-confirm_rework.php';"; 
				echo "</script>";
				exit(); //quit the script	
			
			
			
		}
		
	     // } //end if($rst_query_ftp)
			
		
	/*	
		
				
		if($rst_query_ftp)
		{
			
		echo "<script>";
		echo "window.location='backflush_tran_Pend-confirm_rework.php'";
		echo "</script>";
		exit(); //quit the script
		
	      }*/
		
      
    
?>
