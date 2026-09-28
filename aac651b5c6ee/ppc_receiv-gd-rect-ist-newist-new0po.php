<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];

include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');

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

?>

<?php
//get PO no
$purc_ord_no = $_GET['purc_ord_no'];

//get mat generate no
$matDoc = $_GET['matDoc'];

$msgSv2 = "";

//submit fr quantity n sloc
if(isset($_POST['submitgr']))
{
	$listA = $_POST['e_grid'];
	
	for($j = 0; $j < count($_POST['e_grid']); $j++)  
	{ 		
		
		//echo $listA[$j];
		
		
		$dlv_ord_no = mysqli_escape_string($dbc,$_POST["dlv_ord_no"]);
		$shift_ops = $_POST["shift_ops"];
		$dateF = $_POST["PSSDate"];
		
		$ddF = substr($_POST["PSSDate"],0,2);
		$mmF = substr($_POST["PSSDate"],3,2);
		$yyF = substr($_POST["PSSDate"],6,4);
		
		$date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
		//$date1_final = date('Y-m-d',strtotime($_POST["PSSDate"]));
		
		$gr_qty = $_POST['gr_qty'];
		$sloc_gr = $_POST['sloc_gr'];
		$std_package = $_POST['std_package'];
		
		//update gr quatity
		
								
		$upd_chg2 = "UPDATE po_detail_trans_gr SET dlv_ord_no = '".sql_esc($dlv_ord_no)."', shift_gr = '".sql_esc($shift_ops)."', posting_gr = '".sql_esc($date1_final)."', sloc_gr = '".sql_esc($sloc_gr[$j])."', gr_qty = '".sql_esc($gr_qty[$j])."', std_package = '".sql_esc($std_package[$j])."'  WHERE material_doc_gen = '".sql_esc($matDoc)."' AND id = '".sql_esc($listA[$j])."' ";						
		$rstupd_chg2 = mysqli_query($dbc,$upd_chg2) or die('Error, insert query failed with:' . $upd_chg2);
		
				
		//-----calculate rec_qty-------
		$query_po_list2 = "SELECT * FROM po_detail_trans_gr WHERE id = '".sql_esc($listA[$j])."'";
		$result_po_list2 = mysqli_query($dbc,$query_po_list2);
		$row_po_list2 = mysqli_fetch_array($result_po_list2);
		  
		$query_info2a = "SELECT * FROM po_detail_trans_gr WHERE purc_ord_no = '".sql_esc($purc_ord_no)."' AND material_no ='".sql_esc($row_po_list2["material_no"])."' 
							AND status_gr = '".sql_esc($rst_sta3["status_desc"])."'";
		$result_info2a = mysqli_query($dbc,$query_info2a);
		
		$tot_gr_qty2a = 0.000;
		
		while($row_info2a = mysqli_fetch_array($result_info2a)) 
		{		
        	$tot_gr_qty2a = $tot_gr_qty2a + $row_info2a["gr_qty"];
		}
		
		//update rec quatity
		$query_upd_calc = "UPDATE po_detail_trans_gr SET rec_qty = '".sql_esc($tot_gr_qty2a)."' WHERE id = '".sql_esc($listA[$j])."' AND status_gr = '".sql_esc($rst_sta3["status_desc"])."'";
	   	$result_upd_calc = mysqli_query($dbc,$query_upd_calc);  
				
		//update table po_detail = In Progress
	    $query_releas_v2 = "UPDATE po_detail SET status_po = '".sql_esc($rst_sta7["status_desc"])."', user_update = '".strtoupper($username)."', date_update = NOW() WHERE id_gr = '".sql_esc($row_po_list2["id_gr"])."'";
        $result_releas_v2 = mysqli_query($dbc,$query_releas_v2);
		
		
		//update table print tag GR
		$query_all = "SELECT * FROM po_detail_trans_gr WHERE id = '".sql_esc($listA[$j])."' AND material_doc_gen = '".sql_esc($matDoc)."' AND status_gr = '".sql_esc($rst_sta3["status_desc"])."'";
		$result_all = mysqli_query($dbc,$query_all);
		$data_all = mysqli_fetch_array($result_all);
		
		//$dl_qty = (intval($data_all["gr_qty"]));
		$dl_qty = $data_all["gr_qty"];

		//----detail standard packaging [ambil dari table mat_master_header]
		$query_pack2 = "SELECT std_packaging, type_package, size_dim FROM table_material_itsb WHERE material_no = '".sql_esc($data_all["material_no"])."'";
		$result_pack2 = mysqli_query($dbc,$query_pack2);
		$data_pack2 = mysqli_fetch_array($result_pack2);
		
		$query_pack = "SELECT * FROM po_detail_trans_gr WHERE id = '".sql_esc($listA[$j])."' AND material_no = '".sql_esc($data_all["material_no"])."'";
		$result_pack = mysqli_query($dbc,$query_pack);
		$data_pack = mysqli_fetch_array($result_pack);
		
		
		
		if(($data_pack["std_package"] == "") || ($data_pack["std_package"] == "0"))
		{

		// $st_pack = (intval($data_all["gr_qty"]));
			$st_pack = (($data_all["gr_qty"]));
		}else{
		//  $st_pack = (intval($data_pack["std_package"]));
		$st_pack = (($data_pack["std_package"]));
		}

		$delivery_qty = round(floatval($dl_qty), 3);
		$pack_size = round(floatval($st_pack), 3);

		// Use bc math or epsilon trick to avoid float problems
		$epsilon = 0.0001;

		// Calculate how many full packs
		$full_packs = floor($delivery_qty / $pack_size);

		// Calculate leftover
		$leftover_qty = $delivery_qty - ($full_packs * $pack_size);
		$leftover_qty = ($leftover_qty > $epsilon) ? round($leftover_qty, 3) : 0;

		// Total number of tags
		$total_tags = ($leftover_qty > 0) ? $full_packs + 1 : $full_packs;

		$w = 1;

		for ($m = 1; $m <= $total_tags; $m++) 
		{
			// Determine quantity per tag
			if ($m < $total_tags) {
				$tag_qty = $pack_size; // Full pack
			} else {
				$tag_qty = ($leftover_qty > 0) ? $leftover_qty : $pack_size;
			}

			// Your INSERT query here (cleaned up to reflect usage of $tag_qty and $w)
			$query_tag = "INSERT INTO print_tag_gd_receipt(
				id_tag, tag_no, id_gr, material_doc_gen, doc_gen, dlv_ord_no, 
				plant_code, purc_ord_no, vendor_id, item_no, material_no, material_desc,
				size_gr, model_gr, ord_uom, tag_qty, shift_tag, sloc, sloc_gr, user_posting, 
				posting_date, posting_time, user_create, date_create, status_tag, 
				status_print, status_po, yr_gr, slip_no, total_slip
			) VALUES (
				'', '', '".sql_esc($data_all["id"])."', '".sql_esc($data_all["material_doc_gen"])."',
				'".sql_esc($data_all["doc_gen"])."', '".sql_esc($data_all["dlv_ord_no"])."', '".sql_esc($data_all["plant_code"])."',
				'".sql_esc($data_all["purc_ord_no"])."', '".sql_esc($data_all["vendor_id"])."', '".sql_esc($data_all["item_no"])."',
				'".sql_esc($data_all["material_no"])."', '".sql_esc($data_all["material_desc"])."', '".sql_esc($data_pack2["size_dim"])."',
				'".sql_esc($data_all["model_gr"])."', '".sql_esc($data_all["ord_uom"])."', '".sql_esc($tag_qty)."', '".sql_esc($data_all["shift_gr"])."',
				'".sql_esc($data_all["sloc"])."', '".sql_esc($data_all["sloc_gr"])."', '".sql_esc($data_all["user_posting"])."',
				'".sql_esc($data_all["posting_gr"])."', '".sql_esc($data_all["time_post"])."', '".strtoupper($username)."',
				NOW(), 'N', 'N', '".sql_esc($data_all["status_po"])."', NOW(), '".sql_esc($w)."', '".sql_esc($total_tags)."'
			)";

			mysqli_query($dbc, $query_tag);

			// Update tag number
			$tag_no = $data_all["material_doc_gen"] . '/' . $w . '/' . $tag_qty . '/' . $total_tags;

			$query_tag_update = "UPDATE print_tag_gd_receipt 
								SET tag_no = '".sql_esc($tag_no)."' 
								WHERE id_tag = '".mysqli_insert_id($dbc)."'
								AND material_doc_gen = '".sql_esc($matDoc)."'";

			mysqli_query($dbc, $query_tag_update);

			$w++;
		}
		
	    // $bil_tag = (($dl_qty)/($st_pack));
		
		// $b =  intval($bil_tag);  // genapkan value yg dibahagikan utk didarabkan 
		// // $b = round($bil_tag, 0, PHP_ROUND_HALF_DOWN);  // genapkan value yg dibahagikan utk didarabkan 
		// $last_tag = ($bil_tag - $b);	   // sekiranya masih ada baki utk keluarkn delivery tag yg last
		
		// $bil_tag2 = ($st_pack * $b);
		
		// if($dl_qty < ($st_pack))
		// {
		// 	$bil_tag3A = ($dl_qty);
		// }else{
		// 	$bil_tag3A =  ($dl_qty - $bil_tag2);  //quantity delivery tag yg last
		// }
		
		// if($b <= 1)
		// {
		// 	$no_tg = 1;
		// }
		// elseif($last_tag == 0)
		// {
		// 	$no_tg = $b;
		// }
		// else
		// {
		// 	$no_tg = ($b + 1);
		// }
		
		// $w = 1;
		   
		// for($m=1; $m <= $bil_tag; $m++)
		// { 
		
		// 	$query_tag3B = "INSERT INTO print_tag_gd_receipt(id_tag,tag_no,id_gr,material_doc_gen,doc_gen,dlv_ord_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_po,yr_gr,slip_no,total_slip) VALUES('','','".$data_all["id"]."','".$data_all["material_doc_gen"]."','".$data_all["doc_gen"]."','".$data_all["dlv_ord_no"]."','".$data_all["plant_code"]."','".$data_all["purc_ord_no"]."','".$data_all["vendor_id"]."','".$data_all["item_no"]."','".$data_all["material_no"]."','".$data_all["material_desc"]."','".$data_pack2["size_dim"]."','".$data_all["model_gr"]."','".$data_all["ord_uom"]."','$st_pack','".$data_all["shift_gr"]."','".$data_all["sloc"]."','".$data_all["sloc_gr"]."','".$data_all["user_posting"]."','".$data_all["posting_gr"]."','".$data_all["time_post"]."','".strtoupper($username)."',NOW(),'N','N','".$data_all["status_po"]."',NOW(),'".$w."','".$no_tg."')";
		// 	$result_tag3B = mysqli_query($dbc,$query_tag3B);
			
		// 	$tag_no3B = ($data_all["material_doc_gen"].'/'.$w.'/'.$data_pack["std_package"].'/'.$no_tg);
			
			
		// 	$query_tag3_t = "UPDATE print_tag_gd_receipt SET tag_no = '".$tag_no3B."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND material_doc_gen = '".$matDoc."'";
		// 	$result_tag3_t = mysqli_query($dbc,$query_tag3_t);
			
		// 	$w++; 
			
		// } // end for loop
		
		// if(($last_tag > 0.000) || ($dl_qty < ($st_pack)))// kalau qty lebih kecil drpd std packaging and baki drpd bahagi tag
		// {	 
		
		    
	  
		// 	$query_tag2 = "INSERT INTO print_tag_gd_receipt(id_tag,tag_no,id_gr,material_doc_gen,doc_gen,dlv_ord_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_po,yr_gr,slip_no,total_slip) 
		// 				VALUES('','','".$data_all["id"]."','".$data_all["material_doc_gen"]."','".$data_all["doc_gen"]."','".$data_all["dlv_ord_no"]."','".$data_all["plant_code"]."','".$data_all["purc_ord_no"]."','".$data_all["vendor_id"]."','".$data_all["item_no"]."','".$data_all["material_no"]."','".$data_all["material_desc"]."','".$data_pack2["size_dim"]."','".$data_all["model_gr"]."','".$data_all["ord_uom"]."','".$bil_tag3A."','".$data_all["shift_gr"]."','".$data_all["sloc"]."','".$data_all["sloc_gr"]."','".$data_all["user_posting"]."','".$data_all["posting_gr"]."','".$data_all["time_post"]."','".strtoupper($username)."',NOW(),'N','N','".$data_all["status_po"]."',NOW(),'".$w."','".$no_tg."')"; 
		// 	$result_tag2 = mysqli_query($dbc,$query_tag2);
			
			
		// 	$tag_no2 = ($data_all["material_doc_gen"].'/'.$w.'/'.$bil_tag3A.'/'.($b + 1));  
			
		// 	$query_tag2_t = "UPDATE print_tag_gd_receipt SET tag_no = '".$tag_no2."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND material_doc_gen = '".$matDoc."'";
		// 	$result_tag2_t = mysqli_query($dbc,$query_tag2_t);
	   
		//  }// end if
		
		
		}//end for loop
	
	//generate text file ftp GR				
	$qry = mysqli_query($dbc,"SELECT *, DATE_FORMAT(posting_gr,'%d%m%Y') AS R FROM po_detail_trans_gr WHERE material_doc_gen = '".sql_esc($matDoc)."'");
	
	$data = "";
	while($row = mysqli_fetch_array($qry)) {
	
	//$qty_nw = (intval($row['gr_qty']));
	$qty_nw = (($row['gr_qty']));
	
	$data .= $row['purc_ord_no'].";".$row['material_doc_gen'].";".$row['dlv_ord_no'].";".$row['R'].";".$row['material_no'].";".$qty_nw.";".$row['ord_uom'].";101;".$row['sloc_gr'].";".$row['user_posting'].";".$row['vendor_id']."\r\n";
	
	
	 //----------update table ftp_detail_gd_receipt_cancel------------
   
    $query_rcv_ftp_info = "INSERT INTO ftp_detail_gd_receipt(id_ups,file_name,material_doc_gen,id_gr,doc_gen,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,sloc,sloc_gr,doc_date,po_qty,gr_qty,ord_uom,user_posting,date_posting,time_posting,status_po,status_ftp,mvt_type) VALUES('','','".sql_esc($row["material_doc_gen"])."','".sql_esc($row["id_gr"])."','".sql_esc($row["doc_gen"])."','".sql_esc($row["plant_code"])."','".sql_esc($row["purc_ord_no"])."','".sql_esc($row["vendor_id"])."','".sql_esc($row["item_no"])."','".sql_esc($row["material_no"])."','".sql_esc($row["material_desc"])."','".sql_esc($row["sloc"])."','".sql_esc($row["sloc_gr"])."','".sql_esc($row["doc_date"])."','".sql_esc($row["po_qty"])."','".sql_esc($row["gr_qty"])."','".sql_esc($row["ord_uom"])."','".sql_esc($username)."','".sql_esc($row["date_post"])."','".sql_esc($row["time_post"])."','".sql_esc($row["status_po"])."','Y','101')";      
	$rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
	
	
	
	
	}
	
	$filen = "GR".$matDoc;
	//$csv_filename = $filen."_".date("YmdHis",time());
	
	$file = "../FromPortal2/GR/".$filen.".csv";
	//chmod($file, 0777);
	file_put_contents($file,$data);
	
	
	
   $query_upd_file = "UPDATE ftp_detail_gd_receipt SET file_name = '".sql_esc($filen)."' WHERE material_doc_gen = '".sql_esc($matDoc)."'";
   $result_upd_file = mysqli_query($dbc,$query_upd_file);
	
	
	  
	//----update table po_detail_trans_gr utk yg x generate mat. doc. no
	$query_upd_can = "UPDATE po_detail_trans_gr SET status_po = '".sql_esc($rst_sta6["status_desc"])."', status_gr = '".sql_esc($rst_sta6["status_desc"])."', user_update = '".strtoupper($username)."',purc_ord_no = '".sql_esc($purc_ord_no)."', user_cancel = '".strtoupper($username)."', date_cancel = NOW(), time_cancel = NOW() WHERE material_doc_gen = '' AND status_gr = '".sql_esc($rst_sta["status_desc"])."'";
	$result_upd_can = mysqli_query($dbc,$query_upd_can);
	
	
	
	//end update count_max ---------------------------------	
	$ref2 = base64_encode($matDoc);
	
	echo "<script>";
	echo "alert('Material Document $matDoc posted.');";
	echo "window.open('detail_print_gd_receipt-tag.php?uid2=$ref2');";
	echo "window.location='ppc_receiv-gd-rect_po.php';"; 
	echo "</script>";
	exit(); //quit the script
		
}
?>