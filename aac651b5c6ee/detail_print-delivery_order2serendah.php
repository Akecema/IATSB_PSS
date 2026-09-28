<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));
$fmt_curr_time = (date("H:i:s"));
$pick_curr_time = (date("H:i a"));
$yearSkrg = (date("Y"));

set_time_limit(0);
// include 2D barcode class (search for installation path)
require_once('tcpdf_barcodes_2d.php');


// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "3")) {
header('Location: ../index.php');
exit();
}

$url = "create_dlv_bypdio_serendahProc2.php";

$query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
$result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
$res = mysqli_fetch_array($result2);
	
	


$today = getdate();
$hours = $today['hours']; 
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year']; 

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

 //CR status (New)

 $sta = "SELECT * from request_status WHERE status_id = '1'";
 $sta_res = mysqli_query($dbc,$sta);
 $rst_sta = mysqli_fetch_array($sta_res);
 
 //CR status (Released)  //CR status (New)
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
 
 //CR status (Rejected)
 $sta5 = "SELECT * from request_status WHERE status_id = '5'";
 $sta_res5 = mysqli_query($dbc,$sta5);
 $rst_sta5 = mysqli_fetch_array($sta_res5);
 
 //CR status (Draft)
 $sta6 = "SELECT * from request_status WHERE status_id = '6'";
 $sta_res6 = mysqli_query($dbc,$sta6);
 $rst_sta6 = mysqli_fetch_array($sta_res6);
 
 //CR status (In Progress)
 $sta7 = "SELECT * from request_status WHERE status_id = '7'";
 $sta_res7 = mysqli_query($dbc,$sta7);
 $rst_sta7 = mysqli_fetch_array($sta_res7);
//----------------------------------------------------------------------------------------- 

$extension = explode ('.', $data_setup["logo_name"]);
$filename = $data_setup["logo_comp"].'.'.$extension[1];



$suid = base64_decode($_GET["suid"]);
$so_no = $_GET["so_no"];
$pdio_no = $_GET["pdio_no"];

//--------- pps detail ------------

$query_pps_tit = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as R FROM prt_do_perodua_tag WHERE scan_gen = '".sql_esc($suid)."'";
$result_pps_tit = mysqli_query($dbc,$query_pps_tit);
$data_tit = mysqli_fetch_array($result_pps_tit);

?>
<?php
     
if((isset($_POST["submit4PDIO"]))  && $_POST!=="") 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));
$fmt_curr_time = (date("H:i:s"));
$pick_curr_time = (date("H:i a"));
$yearSkrg = (date("Y"));




 //CR status (New)

 $sta = "SELECT * from request_status WHERE status_id = '1'";
 $sta_res = mysqli_query($dbc,$sta);
 $rst_sta = mysqli_fetch_array($sta_res);
 
 //CR status (Released)  //CR status (New)
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
 
 //CR status (Rejected)
 $sta5 = "SELECT * from request_status WHERE status_id = '5'";
 $sta_res5 = mysqli_query($dbc,$sta5);
 $rst_sta5 = mysqli_fetch_array($sta_res5);
 
 //CR status (Draft)
 $sta6 = "SELECT * from request_status WHERE status_id = '6'";
 $sta_res6 = mysqli_query($dbc,$sta6);
 $rst_sta6 = mysqli_fetch_array($sta_res6);
 
 //CR status (In Progress)
 $sta7 = "SELECT * from request_status WHERE status_id = '7'";
 $sta_res7 = mysqli_query($dbc,$sta7);
 $rst_sta7 = mysqli_fetch_array($sta_res7);

//CR status (Pending)
$sta8 = "SELECT * from request_status WHERE status_id = '8'";
$sta_res8 = mysqli_query($dbc,$sta8);
$rst_sta8 = mysqli_fetch_array($sta_res8);

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc,$sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13'";
$sta_res13 = mysqli_query($dbc,$sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);

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

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

//CR status (Transfer Material)
$sta28 = "SELECT * from request_status WHERE status_id = '28'";
$sta_res28 = mysqli_query($dbc,$sta28);
$rst_sta28 = mysqli_fetch_array($sta_res28);





//----------------------------------------------------------------------------------------- 


// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}


$so_no = $_POST["so_no"];
$pdio_no = $_POST["pdio_no"];
$suid = $_POST["suid"];

   //------------checking duplicate submitted ----------------
   
   $query_check_dup = "SELECT * FROM dlv_ord_all_delivery WHERE scan_gen = '".sql_esc($suid)."'";
   $result_check_dup = mysqli_query($dbc,$query_check_dup);
   $data_check_dup = mysqli_fetch_array($result_check_dup);   //how many records are there?   

            if($data_check_dup >= 1 )
			 {
			   
			    $suidA = base64_encode($suid);
				
				echo "<script>";
                echo "alert('FTP file already exist/generate.');";
                echo "window.location='ftp_delivery_orderPerd2_serendah.php?suid2=$suidA&&so_no=$so_no&&pdio_no=$pdio_no'";
                echo "</script>";
				exit(); //quit the script
			              		   
			   }



    $query_doc_generate = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as R, DATE_FORMAT(dlv_date,'%d-%m-%Y') as R7 FROM prt_do_perodua_tag WHERE scan_gen = '".sql_esc($suid)."' GROUP BY pdio_no";
    $result_doc_generate = mysqli_query($dbc,$query_doc_generate);

while($row_doc_generate = mysqli_fetch_array($result_doc_generate))
{
	$ship_point = $row_doc_generate['ship_point'];	

	
	$query_pdio_grp2 = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as T, DATE_FORMAT(dlv_date,'%d-%m-%Y') as T7 FROM prt_do_perodua_tag WHERE pdio_no = '".sql_esc($row_doc_generate["pdio_no"])."' AND scan_gen = '".sql_esc($suid)."'";
    $result_pdio_grp2 = mysqli_query($dbc,$query_pdio_grp2);

while($row_pdio2 = mysqli_fetch_array($result_pdio_grp2))
{ 

 //------generate Material Document No. for GR Generate.---------------------------------

 include 'gen_mat_doc_crt_DO_perodua2.php';


//---update material doc create DO in table upload_perodua_temp---
		
		$query_update_temp = "UPDATE upload_perodua_temp SET material_doc_gen = '".sql_esc($ref3)."', status_upload = '".sql_esc($rst_sta7["status_desc"])."', status_DO = '".sql_esc($rst_sta3["status_desc"])."', posting_date = NOW(), posting_time = NOW(), user_post = '".sql_esc($username)."', date_post = NOW(), time_post = NOW() WHERE scan_gen = '".sql_esc($suid)."' AND  pdio_no = '".sql_esc($row_pdio2["pdio_no"])."'";
	    $rst_update_temp = mysqli_query($dbc,$query_update_temp);
		
	
			
		$query_all2 = "SELECT * FROM upload_perodua_temp WHERE material_no = '".sql_esc($row_pdio2["material_no"])."' AND material_doc_gen = '".sql_esc($ref3)."' AND status_upload = '".sql_esc($rst_sta7["status_desc"])."' AND status_DO = '".sql_esc($rst_sta3["status_desc"])."' AND scan_gen = '".sql_esc($suid)."' AND pdio_no = '".sql_esc($row_pdio2["pdio_no"])."'";
		$result_all2 = mysqli_query($dbc,$query_all2);
	    $data_all2 = mysqli_fetch_array($result_all2);
		
			if($data_all2["material_doc_gen"] != "")
		{
		//insert table dlv_ord_perodua_dlv
	 $query_generate_do = "INSERT INTO dlv_ord_all_delivery(id,id_do,upload_id,scan_gen,material_doc_gen,pdio_no,order_no,vendor_name,shop_pt,lshop,ldock,dlv_cat,trip_no,lane_no,prod_date,dlv_date,cycle_no,back_no,material_no,material_desc,total_order_pcs,total_order_box,total_rcv_pcs,total_rcv_box,user_upload,date_upload,status_upload,user_update,date_update,so_no,ship_point,ship_name,tag_no,doc_gen,sold_desc,ship_no,ship_desc,item_no,material_no_sap,material_desc_sap,plant_code,qty_order,qty_bal,qty_rec,qty_dlv,unit_soi,matl_group,sales_org,posting_date,posting_time,user_post,date_post,time_post,ref_material_doc,user_cancel,date_cancel,remark_cancel,status_DO,status_part,qty_return,doc_no_return,return_by,date_return,reject_ticket_no,user_reject,date_reject) VALUES ('','".sql_esc($row_pdio2["id_do"])."','".sql_esc($data_all2["upload_id"])."','".sql_esc($data_all2["scan_gen"])."','".sql_esc($data_all2["material_doc_gen"])."','".sql_esc($data_all2["pdio_no"])."','".sql_esc($data_all2["order_no"])."','".sql_esc($data_all2["vendor_name"])."','".sql_esc($data_all2["shop_pt"])."','".sql_esc($data_all2["lshop"])."','".sql_esc($data_all2["ldock"])."','".sql_esc($data_all2["dlv_cat"])."','".sql_esc($data_all2["trip_no"])."','".sql_esc($data_all2["lane_no"])."','".sql_esc($data_all2["prod_date"])."','".sql_esc($data_all2["dlv_date"])."','".sql_esc($data_all2["cycle_no"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["cust_mat_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_all2["total_order_pcs"])."','".sql_esc($data_all2["total_order_box"])."','".sql_esc($data_all2["total_rcv_pcs"])."','".sql_esc($data_all2["total_rcv_box"])."','".sql_esc($data_all2["user_upload"])."','".sql_esc($data_all2["date_upload"])."','".sql_esc($data_all2["status_upload"])."','".sql_esc($data_all2["user_update"])."','".sql_esc($data_all2["date_update"])."','".sql_esc($data_all2["so_no"])."','".sql_esc($data_all2["ship_point"])."','".sql_esc($data_all2["cust_code"])."','".sql_esc($data_all2["id_soi"])."','".sql_esc($data_all2["doc_gen"])."','".sql_esc($data_all2["sold_desc"])."','".sql_esc($data_all2["ship_no"])."','".sql_esc($data_all2["ship_desc"])."','".sql_esc($data_all2["item_no"])."','".sql_esc($data_all2["material_no_soi"])."','".sql_esc($data_all2["material_desc_soi"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["qty_order"])."','".sql_esc($data_all2["qty_bal"])."','".sql_esc($data_all2["qty_rec"])."','".sql_esc($data_all2["qty_dlv"])."','".sql_esc($data_all2["unit_soi"])."','".sql_esc($data_all2["matl_group"])."','".sql_esc($data_all2["sales_org"])."','".sql_esc($data_all2["posting_date"])."','".sql_esc($data_all2["posting_time"])."','".sql_esc($data_all2["user_post"])."','".sql_esc($data_all2["date_post"])."','".sql_esc($data_all2["time_post"])."','','','','','".sql_esc($data_all2["status_DO"])."','PERODUA','0.000','','','0000-00-00 00:00:00','','','0000-00-00 00:00:00')";
	 $rst_generate_do = mysqli_query($dbc,$query_generate_do);

	 $temp_id = mysqli_insert_id($dbc);  //insert ID

			
	}
	//-----update mac doc print tag

	//-------------calculate Grand TOTAL DLV QTY update status_DO [completed] ----------------
	$tot_di_qty2 = 0.000;
	$tot_order = 0.000;
	$pend_qty2 = 0.000;

	$query_check_Trcv = "SELECT * FROM dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($ref3)."' AND status_DO = '".sql_esc($rst_sta3["status_desc"])."' AND (material_no = '".sql_esc($row_pdio2['material_no'])."' OR material_no_sap = '".sql_esc($row_pdio2['material_no'])."')";
	$result_check_Trcv = mysqli_query($dbc,$query_check_Trcv);
	  
	while($data_check_Trcv = mysqli_fetch_array($result_check_Trcv))
	{
	
	
	 $tot_di_qty2 = $tot_di_qty2 + $data_check_Trcv["qty_dlv"];
	 $pend_qty2 = ($data_check_Trcv["qty_order"] - ($tot_di_qty2));
	 $tot_order = $data_check_Trcv["qty_order"];

	}

	// echo 'Total DLY : '.$tot_di_qty2; echo '<br>';
	// echo 'Pending Qty : '.$pend_qty2; echo '<br>';
	// echo 'Order Qty : '.$tot_order; echo '<br>';
	// echo 'Query' .$query_check_Trcv;
	// die();
	if ($tot_di_qty2 != 0.000) {
 if($tot_order == ($tot_di_qty2))
  {
  
	$status_baru_DO = $rst_sta14["status_desc"];
    
  }elseif(($tot_order) < $tot_di_qty2)
  {
    
    $status_baru_DO = $rst_sta14["status_desc"];
    
    
  }elseif (($tot_di_qty2 < $tot_order) && ($tot_di_qty2 != 0.000)) {

	$status_baru_DO = $rst_sta7["status_desc"];
  
} elseif ($tot_di_qty2 == ($tot_order)) {

	$status_baru_DO = $rst_sta3["status_desc"];

}elseif (($pend_qty2 < 0.000) && ($pend_qty2 != 0.000)) {

		$status_baru_DO = $rst_sta14["status_desc"];

} else {
}
}else{


} 
  
//   echo 'Status : '.$status_baru_DO; echo '<br>';
       $query_gen_order = "SELECT * FROM dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($ref3)."' AND (material_no = '".sql_esc($row_pdio2['material_no'])."' OR material_no_sap = '".sql_esc($row_pdio2['material_no'])."')";
	   $result_gen_order = mysqli_query($dbc, $query_gen_order);
	   
	 while($data_gen_order = mysqli_fetch_array($result_gen_order))
	 {

	$query_update_temp8 = "UPDATE dlv_pdio_generate SET status_DO = '".sql_esc($status_baru_DO)."' WHERE pdio_no = '".sql_esc($data_gen_order['pdio_no'])."' AND (material_no = '".sql_esc($data_gen_order['material_no'])."' OR material_no_cust ='".sql_esc($data_gen_order['material_no'])."') ";
    $rst_update_temp8 = mysqli_query($dbc,$query_update_temp8);

      }

	   $query_update_temp2 = "UPDATE prt_do_perodua_tag SET material_doc_gen = '".sql_esc($ref3)."' WHERE scan_gen = '".sql_esc($suid)."' AND pdio_no = '".sql_esc($row_pdio2["pdio_no"])."'";
	   $rst_update_temp2 = mysqli_query($dbc,$query_update_temp2);

   		
   //generate text file ftp DO		
			
	$qry_ftp = mysqli_query($dbc,"SELECT *, DATE_FORMAT(posting_date,'%d%m%Y') AS R, DATE_FORMAT(dlv_date,'%d%m%Y') AS R7, DATE_FORMAT(prod_date,'%d%m%Y') AS R17 FROM dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($ref3)."' AND pdio_no = '".sql_esc($row_doc_generate["pdio_no"])."'");
	
$data = "";
while($row_ftp = mysqli_fetch_array($qry_ftp)) {
	
	$qty_nw = (intval($row_ftp['qty_dlv']));
	
     $data .= $row_ftp['so_no'].";".$row_ftp['R17'].";".$row_ftp['material_no'].";".$qty_nw.";".$row_ftp['material_doc_gen'].";".$row_ftp['pdio_no'].";\r\n";

    // $data .= $row_ftp['so_no'].";".$row_ftp['ship_point'].";".$row_ftp['R7'].";".$row_ftp['material_no'].";".$qty_nw.";".$row_ftp['material_doc_gen'].";".$row_ftp['pdio_no'].";".$row_ftp['back_no'].";".$row_ftp['dlv_cat'].";601\r\n";
  
 

}

$filen="DO".$ref3;
//$csv_filename = $filen."_".date("YmdHis",time());

$file = "../FromPortal2/DO/".$filen.".csv";
//chmod($file, 0777);
file_put_contents($file,$data);



 //----colect data --------------
  $query_collect = "SELECT * FROM dlv_ord_all_delivery WHERE id_do = '".sql_esc($row_pdio2["id_do"])."' AND material_doc_gen = '".sql_esc($ref3)."'";
  $rst_collect = mysqli_query($dbc,$query_collect);
  $data_collect = mysqli_fetch_array($rst_collect);



  

    //--------insert into table ftp_dlv_ord_perodua_dlv

	
	$query_ftp_info = "INSERT INTO ftp_dlv_ord_all_delivery(id_ftp,file_name,material_doc_gen,id_do,scan_gen,plant_code,so_no,ship_point,ship_name,pdio_no,item_no,material_no,material_desc,qty_order,qty_dlv,uom_dlv,dlv_date,ship_from,ship_to,user_posting,date_posting,time_posting,status_DO,status_ftp,status_part) VALUES ('','".sql_esc($filen)."','".sql_esc($ref3)."','".sql_esc($data_collect["id"])."','".sql_esc($data_collect["scan_gen"])."','".sql_esc($data_collect["plant_code"])."','".sql_esc($data_collect["so_no"])."','".sql_esc($data_collect["ship_point"])."','".sql_esc($data_collect["ship_name"])."','".sql_esc($data_collect["pdio_no"])."','".sql_esc($data_collect["item_no"])."','".sql_esc($data_collect["material_no"])."','".sql_esc($data_collect["material_desc"])."','".sql_esc($data_collect["qty_order"])."','".sql_esc($data_collect["qty_dlv"])."','".sql_esc($data_collect["unit_soi"])."','".sql_esc($data_collect["dlv_date"])."','".sql_esc($data_collect["cust_code"])."','".sql_esc($data_collect["ship_no"])."','".sql_esc($data_collect["user_post"])."','".sql_esc($data_collect["date_post"])."','".sql_esc($data_collect["time_post"])."','".sql_esc($data_collect["status_DO"])."','Y','".sql_esc($data_collect["status_part"])."')";
	$rst_ftp_info = mysqli_query($dbc,$query_ftp_info);
	

 
} // end while loop

//update count_max----------------------------------------

include 'gen_mat_doc_crt_DO_perodua2_cls.php';	
	 	

 } // end while loop main


    $suidA = base64_encode($suid);

    echo '<script type="text/javascript">';
	echo "alert('Material Document $ref3 posted.');";	
	echo "window.location='ftp_delivery_orderPerd2_serendah.php?suid2=$suidA&&so_no=$so_no&&pdio_no=$pdio_no';"; 
	echo "</script>";
	exit(); //quit the script  





} // end if $submit4


if(isset($_POST["submit5"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

$so_no = $_POST["so_no"];
$pdio_no = $_POST["pdio_no"];

//-----------delete all data current screen-------------

	   $query_delete_scan = "DELETE FROM dlv_ord_all_delivery WHERE scan_gen = '".sql_esc($suid)."' AND pdio_no = '".sql_esc($pdio_no)."' ";
	   $result_delete_scan = mysqli_query($dbc,$query_delete_scan);

//---------end delete ----------------------------------

//----update status print DO---
       $query_prt_DO = "DELETE FROM prt_do_perodua_tag WHERE scan_gen = '".sql_esc($suid)."' AND pdio_no = '".sql_esc($pdio_no)."' ";
	   $result_prt_DO = mysqli_query($dbc,$query_prt_DO);
	   
//----update status upload_perodua_temp---	   

       $query_prt_DO2 = "UPDATE upload_perodua_temp SET status_upload = '".sql_esc($rst_sta["status_desc"])."', status_DO = '".sql_esc($rst_sta["status_desc"])."' WHERE scan_gen = '".sql_esc($suid)."'";
	   $result_prt_DO2 = mysqli_query($dbc,$query_prt_DO2);
	   
	   
	echo '<script type="text/javascript">';
	echo "alert('Successfully deleted.');";
	echo "window.close();";
	echo "</script>";
	exit(); //quit the script
	   
}//end submit5




?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?> ">
    <title><?php echo html_esc($data_setup["comp_code"]); ?> : Generate Doc. No <?php echo $suid; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    
     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
<!--https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages-->
<style>
/*Size : 8.27in and 11.69 inches*/


@media print{
@page{
	size: A5 landscape;
	/*margin-top: 1.0cm;*/
	/*padding-top:2.5cm;
	padding-bottom:4.5cm;*/
	margin: 2.0cm 1.5cm 2.5cm 1.5cm ;
}

body {
   display:table;
   table-layout:fixed;
   padding-top:0.5cm;
   padding-bottom:2.5cm;
   height:auto;
}

@page :first {
	/*padding-top:1.5cm;
	padding-bottom:4.5cm;*/
	
	margin: 0.5cm 1.5cm 3.0cm 1.5cm ;

}


/* div.printBt {
	page:printBt ;
	position: fixed;
	bottom: 20px;
	margin-left: 75px;
	margin-right: 50px;
	visibility:hidden;
} */
}

@page Section1 {
size:5.8in 8.3in; 
/*margin:.10in .5in .10in .5in; 
mso-header-margin:.10in; 
mso-footer-margin:.10in; 
mso-paper-source:0;*/
}

body
{
	background-color:#FFF;
	
}

.style4 {
	font-size: 14px;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}
.style1 {	
	font-size: 16px;
	font-weight: bold;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}
.style10 {	
	font-size: 10px;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
	padding-bottom: 0.5cm;
}
.style11 {	
	font-family: Arial, Helvetica, sans-serif;
	font-size: 22px;
	color: #000000;
	font-weight: bold;
}
.style7 {	
	font-size: 24px;
	font-weight: bold;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}
.style8 {	
	font-size: 13px;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
}
.style9 {	
	font-size: 26px;
	font-weight: bold;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
}

/* div.printBt {
	page:printBt ;
	position: fixed;
	bottom: 20px;
	margin-left: 75px;
	margin-right: 50px;
} */

</style>
<script type="text/javascript">
	function print_page() {
		var ButtonControl = document.getElementById("btnprint");
		ButtonControl.style.visibility = "hidden";
		window.print();
	}
</script>
    
</head>



<body class="A4 landscape">

<p>&nbsp;</p>

<center>

 <form action="detail_print-delivery_order2serendah.php?suid=<?php echo (base64_encode($suid)); ?>&&so_no=<?php echo $so_no; ?>&&pdio_no=<?php echo $pdio_no; ?>" method="post" name="myform" id="myform">
     <table width="98%" border="0" cellspacing="1" cellpadding="1">
     <tr>
      <td colspan="6"><p><img src="../set_upload/<?php echo $filename;  ?>"width="267" height="27" hspace="2" vspace="2"/></p>
        <p><h3>Create Delivery Order</h3></p>
       </td>
      </tr>
      </table>
<?php

//$suid = base64_decode($_GET["suid"]);

//$uid = $_GET["uid"];

//--------- pps detail ------------

$query_pps = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as R, DATE_FORMAT(dlv_date,'%d-%m-%Y') as R7 FROM prt_do_perodua_tag WHERE scan_gen = '".sql_esc($suid)."' AND pdio_no = '".sql_esc($pdio_no)."'  GROUP BY pdio_no";
$result_pps = mysqli_query($dbc,$query_pps);

while($row = mysqli_fetch_array($result_pps))
{


	$query_pps_temp = "SELECT *, DATE_FORMAT(prod_date,'%d-%m-%Y') as S17, DATE_FORMAT(dlv_date,'%d-%m-%Y') as S7 FROM upload_perodua_temp WHERE id = '".sql_esc($row["id_do"])."' AND scan_gen = '".sql_esc($suid)."' AND pdio_no = '".sql_esc($pdio_no)."' ";
    $result_pps_temp = mysqli_query($dbc,$query_pps_temp);
	$row_temp = mysqli_fetch_array($result_pps_temp);
	//upload_perodua_temp
 	
	
?>
<div class=Section1>

     <table width="98%" border="0" cellspacing="1" cellpadding="1">
     <tr>
      <td colspan="6"><p><b>DI/PDIO Number   : <font color="#0000FF"><?php echo html_esc($row["pdio_no"]); ?> </font></b></p></td>
      </tr>
      </table>
      <table width="98%" border="0" cellspacing="1" cellpadding="1">
      <tr>
      <th>NO.</th>
      <th>PART NUMBER</th>
      <th>CUSTOMER PART NUMBER</th>
      <th>DELIVERY QUANTITY</th>
      <th>SHIP FROM</th>
      <th>SHIP TO</th>
	  <th>PRODUCTION DATE</th>
      <th>DELIVERY DATE</th>
     </tr>
     <?php
	//----------display material header
	$query_info3 = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$row["material_no"]]);
	$result_info3 = db_query($dbc, $query_info3);
	$row_info3 = mysqli_fetch_array($result_info3);
	
	$query_pdio_grp = "SELECT *,DATE_FORMAT(posting_date,'%d-%m-%Y') as T, DATE_FORMAT(dlv_date,'%d-%m-%Y') as T7 FROM prt_do_perodua_tag WHERE pdio_no = '".sql_esc($row["pdio_no"])."' AND scan_gen = '".sql_esc($row["scan_gen"])."'";
    $result_pdio_grp = mysqli_query($dbc,$query_pdio_grp);

while($row_pdio = mysqli_fetch_array($result_pdio_grp))

{ 
	 
 
	 ?>
      <tr>
      <td width="10%"><?php echo html_esc($row_pdio["pdio_no"]); ?></td>
      <td width="15%"><?php echo html_esc($row_pdio["material_no"]); ?></td>
      <td width="15%"><?php echo html_esc($row_pdio["cust_mat_no"]); ?></td>
      <td width="10%"><?php echo intval($row_pdio["qty_dlv"]); ?></td>
      <td width="10%"><?php echo html_esc($row_pdio["ship_from"]); ?></td>
      <td width="10%"><?php echo html_esc($row_pdio["ship_to"]); ?></td>
      <td width="15%"><?php echo html_esc($row_temp["S17"]); ?></td>
	  <td width="15%"><?php echo html_esc($row_pdio["T7"]); ?></td>
    </tr>
    
    <?php  } //end while loop ?>
  </table> 

   
<p>&nbsp;</p>

<?php

  

	  } // end while loop main

?>
 <table width="98%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td>&nbsp;
          <input name="so_no" type="hidden" value="<?php echo $so_no; ?>">              
               <input name="pdio_no" type="hidden" value="<?php echo $pdio_no; ?>"> 
               <input name="suid" type="hidden" value="<?php echo $suid; ?>">
              </td> 
          <td width="70%">&nbsp; <input name="submit4PDIO" type="submit" id="submit4PDIO" value="SUBMIT" class="btn btn-success btn-sm"  >
      <input name="submit5" type="submit" id="submit5" class="btn btn-warning btn-sm" value="CANCEL"></td>
        </tr>
    </table>
    <p>&nbsp;</p>

</div>
    </form>     
</center>
<!--<div class="printBt">
<input type="button" id="btnprint" value="Print this Page" onclick="print_page()" class="btn btn-success"/>
</div>
-->

    <!--Footer-part-->


<!--end-Footer-part--> 

</body>
</html>