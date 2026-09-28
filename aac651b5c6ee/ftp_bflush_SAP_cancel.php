<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$uid = $_GET["uid"];
$buid = $_GET["buid"];
//---------------------
$dateF = $_GET["date1"];
$dateT = $_GET["date2"];
$factory = $_GET["factory"];
$work_center = $_GET["work_center"];
$plan_no = $_GET["plan_no"];
$shift_ops = $_GET["shift_ops"];

$qry = mysqli_query($dbc,"SELECT *, DATE_FORMAT(A1.date_posting,'%Y-%m-%d') AS R, DATE_FORMAT(A1.date_create,'%Y-%m-%d') AS R2, DATE_FORMAT(A1.date_create,'%H:%i:%s') AS R3 FROM pps_detail_transaction AS A1, scan_prod_planning AS A2 WHERE A2.id_scan = A1.id_scan AND A1.id = '".sql_esc($uid)."'");
$data = "";
while($rowa = mysqli_fetch_array($qry)) {
	
	$sta_out = substr($rowa["bflush_no"],4,3);
	//$sta_out = substr($row["bflush_no"],4,1);
	$filen="BF".$buid;
	
	if($sta_out == "221")
	{
		
	$query_type = "SELECT * FROM type_reject_detail WHERE id_type = '".sql_esc($rowa['type_reject'])."' ORDER BY id_type ASC";
    $result_type = mysqli_query($dbc,$query_type);
    $row_type = mysqli_fetch_array($result_type); 
	
	$query_reason = "SELECT * FROM reason_ng_reject WHERE id_reject = '".sql_esc($rowa['reason_reject'])."' ORDER BY id_reject ASC";
    $result_reason = mysqli_query($dbc,$query_reason);
    $row_reason = mysqli_fetch_array($result_reason);
	
	 $data .= $rowa['bflush_no_ref'].";".$rowa['bflush_no'].";".$rowa['comp_code'].";".$rowa['work_center'].";".$rowa['material_no'].";132;".$rowa['plan_no'].";".$rowa['date_plan'].";".$rowa['scan_shift'].";".$rowa['qty_NG'].";".$rowa['scan_uom'].";".$rowa['ploc'].";".$rowa['R'].";".$rowa['time_posting'].";".$rowa['R2'].";".$rowa['R3'].";".$rowa['user_cancel'].";".$rowa['date_cancel']."\r\n";
	
  
   //----colect data --------------
  $query_collect = "SELECT *, DATE_FORMAT(A1.date_posting,'%Y-%m-%d') AS R FROM pps_detail_transaction AS A1, scan_prod_planning AS A2 WHERE A2.id_scan = A1.id_scan AND A1.id = '".sql_esc($uid)."'";
  $rst_collect = mysqli_query($dbc,$query_collect);
  $data_collect = mysqli_fetch_array($rst_collect);

 
     //--------insert into table ftp_bflush_detail
  
     $query_ftp_info = "INSERT INTO ftp_bflush_detail(id, file_name, bflush_no, ref_id, plan_no, material_no, material_desc, qty_ftp, uom, status_ftp, posting_date, posting_time, user_create, date_create) VALUES('','".sql_esc($filen)."','".sql_esc($data_collect["bflush_no"])."','".sql_esc($data_collect["ref_id"])."','".sql_esc($data_collect["plan_no"])."','".sql_esc($data_collect["material_no"])."','".sql_esc($data_collect["material_desc"])."','".sql_esc($data_collect["qty_NG"])."','".sql_esc($data_collect["scan_uom"])."','Y','".sql_esc($data_collect["R"])."','".sql_esc($data_collect["time_posting"])."','".sql_esc($username)."',NOW())"; 
     $rst_ftp_info = mysqli_query($dbc,$query_ftp_info);
	 
	}elseif($sta_out == "211")
	{
	
	 $data .= $rowa['bflush_no_ref'].";".$rowa['bflush_no'].";".$rowa['comp_code'].";".$rowa['work_center'].";".$rowa['material_no'].";132;".$rowa['plan_no'].";".$rowa['date_plan'].";".$rowa['scan_shift'].";".$rowa['qty_actual'].";".$rowa['scan_uom'].";".$rowa['ploc'].";".$rowa['R'].";".$rowa['time_posting'].";".$rowa['R2'].";".$rowa['R3'].";".$rowa['user_cancel'].";".$rowa['date_cancel']."\r\n";	
		
	
	
	  //----colect data --------------
  $query_collect = "SELECT *, DATE_FORMAT(A1.date_posting,'%Y-%m-%d') AS R FROM pps_detail_transaction AS A1, scan_prod_planning AS A2 WHERE A2.id_scan = A1.id_scan AND A1.id = '".sql_esc($uid)."'";
  $rst_collect = mysqli_query($dbc,$query_collect);
  $data_collect = mysqli_fetch_array($rst_collect);

 
     //--------insert into table ftp_bflush_detail
  
     $query_ftp_info = "INSERT INTO ftp_bflush_detail(id, file_name, bflush_no, ref_id, plan_no, material_no, material_desc, qty_ftp, uom, status_ftp, posting_date, posting_time, user_create, date_create) VALUES('','".sql_esc($filen)."','".sql_esc($data_collect["bflush_no"])."','".sql_esc($data_collect["ref_id"])."','".sql_esc($data_collect["plan_no"])."','".sql_esc($data_collect["material_no"])."','".sql_esc($data_collect["material_desc"])."','".sql_esc($data_collect["qty_actual"])."','".sql_esc($data_collect["scan_uom"])."','Y','".sql_esc($data_collect["R"])."','".sql_esc($data_collect["time_posting"])."','".sql_esc($username)."',NOW())"; 
     $rst_ftp_info = mysqli_query($dbc,$query_ftp_info);
		
	}else{
		
	
	 $data .= $rowa['bflush_no_ref'].";".$rowa['bflush_no'].";".$rowa['comp_code'].";".$rowa['work_center'].";".$rowa['material_no'].";132;".$rowa['plan_no'].";".$rowa['date_plan'].";".$rowa['scan_shift'].";".$rowa['qty_actual'].";".$rowa['scan_uom'].";".$rowa['ploc'].";".$rowa['R'].";".$rowa['time_posting'].";".$rowa['R2'].";".$rowa['R3'].";".$rowa['user_cancel'].";".$rowa['date_cancel']."\r\n";	
		
	
	
	  //----colect data --------------
  $query_collect = "SELECT *, DATE_FORMAT(A1.date_posting,'%Y-%m-%d') AS R FROM pps_detail_transaction AS A1, scan_prod_planning AS A2 WHERE A2.id_scan = A1.id_scan AND A1.id = '".sql_esc($uid)."'";
  $rst_collect = mysqli_query($dbc,$query_collect);
  $data_collect = mysqli_fetch_array($rst_collect);

 
     //--------insert into table ftp_bflush_detail
  
     $query_ftp_info = "INSERT INTO ftp_bflush_detail(id, file_name, bflush_no, ref_id, plan_no, material_no, material_desc, qty_ftp, uom, status_ftp, posting_date, posting_time, user_create, date_create) VALUES('','".sql_esc($filen)."','".sql_esc($data_collect["bflush_no"])."','".sql_esc($data_collect["ref_id"])."','".sql_esc($data_collect["plan_no"])."','".sql_esc($data_collect["material_no"])."','".sql_esc($data_collect["material_desc"])."','".sql_esc($data_collect["qty_actual"])."','".sql_esc($data_collect["scan_uom"])."','Y','".sql_esc($data_collect["R"])."','".sql_esc($data_collect["time_posting"])."','".sql_esc($username)."',NOW())"; 
     $rst_ftp_info = mysqli_query($dbc,$query_ftp_info);	
		
		
	}
  
  
  
  
}


$filen="BF2".$buid;
//$csv_filename = $filen."_".date("YmdHis",time());

$file = "../FromPortal/".$filen.".csv";
//chmod($file, 0777);
file_put_contents($file,$data);
   
   
   
   
     // ---update status 

		$query_ftp = "UPDATE pps_detail_transaction SET status_ftp_bflush = 'Y' WHERE id = '".sql_esc($uid)."'";
		$rst_query_ftp = mysqli_query($dbc,$query_ftp); //or die ("Error in query: $query_ftp"); 
		
				
		if($rst_query_ftp > 0)
		{
			
		echo "<script>";
		echo "alert('FTP Transferred to SAP.');";
	//	echo "parent.tb_remove(); parent.location.reload(1)";
		echo "window.location='cancellation_list_backflush_tran2.php?date1=$dateF&&date2=$dateT&&factory=$factory&&work_center=$work_center&&plan_no=$plan_no&&shift_ops=$shift_ops'";
		echo "</script>";
		exit(); //quit the script
		
	      }
		
      
    
?>
