<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$buid2 = base64_decode($_GET["buid"]);
$uid2 = base64_decode($_GET["uid"]);

//echo $buid2; echo "hhh"; echo $uid2;

$qry = mysqli_query($dbc,"SELECT *, DATE_FORMAT(A1.date_posting,'%d%m%Y') AS R, DATE_FORMAT(A1.date_create,'%Y-%m-%d') AS R2, DATE_FORMAT(A1.date_create,'%H:%i:%s') AS R3 FROM pps_detail_trn_fg_hwork_confirm AS A1, sc_prd_planning_hwork_confirm AS A2 WHERE A1.id_scan = A2.id_scan AND A1.bflush_no = '".sql_esc($buid2)."'");
$data = "";
while($row_tg = mysqli_fetch_array($qry)) {
	
	
	if($row_tg["status_butn"] == "OK")
	 {	
	
	 $qty_nw = (intval($row_tg['qty_OK']));
		
	 }
	 	  	
	  if($row_tg["status_butn"] == "NG")
	 {	 
	
	$qty_nw = (intval($row_tg['qty_NG']));
		
	 }
	
		
  //-----FINISH GOODS (2300)---------
  
  if($row_tg["material_type"] == "Z301")	
  {
	
  $data .= $row_tg['bflush_no'].";".$row_tg['R'].";".$row_tg['material_no'].";".$qty_nw.";".$row_tg['plan_no'].";".$row_tg['plant_code'].";131;2360\r\n";
  
  }elseif($row_tg["material_type"] == "Z201")
  {
	  
	 $data .= $row_tg['bflush_no'].";".$row_tg['R'].";".$row_tg['material_no'].";".$qty_nw.";".$row_tg['plan_no'].";".$row_tg['plant_code'].";131;2350\r\n"; 
	  
  }else{
	 
	  $data .= $row_tg['bflush_no'].";".$row_tg['R'].";".$row_tg['material_no'].";".$qty_nw.";".$row_tg['plan_no'].";".$row_tg['plant_code'].";131;\r\n"; 
	   
  }
     
}

$filen="BF".$buid2;
//$csv_filename = $filen."_".date("YmdHis",time());

$file = "../FromPortal/BF_HANDWORK_CONFIRM/".$filen.".csv";
//chmod($file, 0777);
file_put_contents($file,$data);
   
   
    //----colect data --------------
  $query_collect = "SELECT *, DATE_FORMAT(A1.date_posting,'%Y-%m-%d') AS M FROM pps_detail_trn_fg_hwork_confirm AS A1, sc_prd_planning_hwork_confirm AS A2 WHERE A2.id_scan = A1.id_scan AND A1.bflush_no = '".sql_esc($buid2)."'";
  $rst_collect = mysqli_query($dbc,$query_collect);
  $data_collect = mysqli_fetch_array($rst_collect);
  
    //--------Quantity-------------------
	
	if($data_collect["status_butn"] == "OK")
	 {	
	
	 $qty_nw2 = (intval($data_collect['qty_OK']));
		
	 }
	 
	
	  if($data_collect["status_butn"] == "NG")
	 {	 
	
	$qty_nw2 = (intval($data_collect['qty_NG']));
		
	 }

 
     //--------insert into table ftp_bflush_detail
  
     $query_ftp_info = "INSERT INTO ftp_bflush_detail_fg_hwork_confirm(id,file_name,bflush_hwork,bflush_no,ref_id,plan_no,material_no,material_desc,qty_ftp,uom,status_ftp,posting_date,posting_time,user_create,date_create,plant_code,stamp_ind) VALUES('','".sql_esc($filen)."','".sql_esc($data_collect["bflush_hwork"])."','".sql_esc($buid2)."','".sql_esc($data_collect["ref_id"])."','".sql_esc($data_collect["plan_no"])."','".sql_esc($data_collect["material_no"])."','".sql_esc($data_collect["material_desc"])."','".sql_esc($qty_nw2)."','".sql_esc($data_collect["scan_uom"])."','Y','".sql_esc($data_collect["M"])."','".sql_esc($data_collect["time_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($data_collect["plant_code"])."','".sql_esc($data_collect["material_type"])."')"; 
     $rst_ftp_info = mysqli_query($dbc,$query_ftp_info);
   
     // ---update status 

		$query_ftp = "UPDATE pps_detail_trn_fg_hwork_confirm SET status_ftp_bflush = 'Y' WHERE bflush_no = '".sql_esc($buid2)."'";
		$rst_query_ftp = mysqli_query($dbc,$query_ftp); //or die ("Error in query: $query_ftp"); 
		
				
		if($rst_query_ftp > 0)
		{
		/*	
		echo "<script>";
		echo "window.location='confirm_backflush_tran_Hwok-confirm.php'";
		echo "</script>";
		exit(); //quit the script*/
		
	   //----info print tag --------------
	 
  $query_p_tag = "SELECT * FROM pps_detail_trn_fg_hwork_confirm AS A1, sc_prd_planning_hwork_confirm AS A2 WHERE A2.id_scan = A1.id_scan AND A1.bflush_no = '".sql_esc($buid2)."'";
  $rst_p_tag = mysqli_query($dbc,$query_p_tag);
  $data_p_tag = mysqli_fetch_array($rst_p_tag);	
  
  
 // echo $data_p_tag["stamp_ind"];	
			
		if($data_p_tag["status_butn"] == "OK")
			{
				
			//if($data_p_tag["stamp_ind"] == "STM")
			//{
				if($data_p_tag["material_type"] == "Z301")
				{
				
				$buid33 =	base64_encode($buid2);
		
				echo "<script>";
				echo "window.open('detail_print_tag_bfHwokConf_ind_stm.php?buid=$buid33','_blank');";
				echo "window.location='confirm_backflush_tran_Hwok-confirm.php';"; 
				echo "</script>";
				exit(); //quit the script
					
				}elseif($data_p_tag["material_type"] == "Z201")
			    {
					
					
				$buid33 =	base64_encode($buid2);
		
				echo "<script>";
				echo "window.open('detail_print_tag_bfHwokConf_ind_stm2.php?buid=$buid33','_blank');";
				echo "window.location='confirm_backflush_tran_Hwok-confirm.php';"; 
				echo "</script>";
				exit(); //quit the script
				
				}else{
					
				echo "<script>";
				echo "window.location='confirm_backflush_tran_Hwok-confirm.php';"; 
				echo "</script>";
				exit(); //quit the script
				
				}// material type
									
			//} //stamp_ind
			
			}else{
                
				
				echo "<script>";
				echo "window.location='confirm_backflush_tran_Hwok-confirm.php';"; 
				echo "</script>";
				exit(); //quit the script	
				
			}// status_butn
		
	      } //end if($rst_query_ftp)
		
      
    
?>
