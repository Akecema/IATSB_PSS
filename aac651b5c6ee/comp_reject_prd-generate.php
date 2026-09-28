<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);

	set_time_limit(0);
	
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

                 $drun = substr($fmt_curr_date,0,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,8,2);
				 
				 $date_run = ($drun.$mrun.$yrun);


//CR status (New)

$sta = "SELECT * from request_status WHERE status_id = '1' ";
$sta_res = mysqli_query($dbc,$sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2' ";
$sta_res2 = mysqli_query($dbc,$sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);	

//CR status (Approved)
$sta3 = "SELECT * from request_status WHERE status_id = '3'";
$sta_res3 = mysqli_query($dbc,$sta3);
$rst_sta3 = mysqli_fetch_array($sta_res3);

//CR status (Cancel)
$sta4 = "SELECT * from request_status WHERE status_id = '4' ";
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


            $scan_doc = $_GET["scan_doc"];
			$barcode_ref = $_GET["barcode_ref"];
            $dateF = $_GET["date1"];
           	$shift_ops = $_GET["shift_ops"]; 
			$dt_arini = (date("dmY"));
			
			$plant_code = $_GET["plant_code"];
			$model_code = $_GET["model_code"]; 
			$material_type = $_GET["material_type"]; 
			$stamp_ind = $_GET["stamp_ind"];
			$material_no = $_GET["material_no"];
			
if(isset($_POST["submit4"]))  
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

			
	
/*if(isset($_POST['e_tcid']))
{*/
	
	$idd = $_POST["idd"]; 			
    $trc_id = $_POST["e_tcid"]; 
    $st = count($trc_id);
	$string = "";
	$shift_ops = $_POST["shift_ops"];
	$dateF = $_POST["date1"];
	
	$item_no = $_POST["item_no"];
	$scan_qty = $_POST["scan_qty"];
	$plant_code2 = $_POST["plant_code2"];
	$sloc_rej = $_POST["sloc_rej"];
	$work_center = $_POST["work_center"];
	$proc_reject = $_POST["proc_reject"];
	$type_reject = $_POST["type_reject"];
	$type_defect = $_POST["type_defect"];
	$remark_dis = $_POST["remark_dis"];
	
	            
	
	//--------checking ------------
	
		
	                 if(($_POST["shift_ops"]) == "")
					   {
	                    echo "<script>";
						echo "alert('Please select Shift.');";
					    echo "window.location='detail_comp_reject_prd.php?scan_doc=$scan_no&&barcode_ref=$barcode_ref&&plant_code=$plant_code&&model_code=$model_code&&material_type=$material_type&&stamp_ind=$stamp_ind&&material_no=$material_no'";
						echo "</script>";
						exit(); //quit the script
		 
		 
		 
						} 
						
						if(($dateF == "00-00-0000") || ($dateF == ""))
					   {
	                    echo "<script>";
						echo "alert('Please select Posting Date.');";
						echo "window.location='detail_comp_reject_prd.php?scan_doc=$scan_no&&barcode_ref=$barcode_ref&&plant_code=$plant_code&&model_code=$model_code&&material_type=$material_type&&stamp_ind=$stamp_ind&&material_no=$material_no'";
						echo "</script>";
						exit(); //quit the script
		 
		 
		 
						} 
	
	

//------generate Material Document No. for GR Generate.---------------------------------
	
	 if($_POST["plant_code2"] == '3100')
	{
	
	 $query_id2 = "SELECT count_max FROM run_count_itsb WHERE uid = '29'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($_POST["plant_code2"] == '3101')
	{
		
	 $query_id2 = "SELECT count_max FROM run_count_itsb WHERE uid = '78'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_row($result_id2);
	
	$dht2 = 000; 
	$dht_OK2 = "351";
	$dg2 = 0;

  	if($row_id2[0] <= 0)
  	{ 
   
    	$lastID2 = ($row_id2[0] + 1);
    	$dg2 = ($dht2 + ($lastID2));
   }
   else
   {
      $lastID2 = ($row_id2[0] + 1);
      $dg2 =  $lastID2;
	
    }
	$number2 = $dg2; // Length of running no
    $number2 = sprintf('%03d', $number2);  
	
    $ref3 = ($plant_code2.$dht_OK2.$date_run.($number2));
	  
	
	} // end if $result_id2
	
		$amount = "";
		$amount2 = "";
		$amount3 = "";
		$string = "";
		$string2 = "";
		$string3 = "";
		
		$idd = $_POST["idd"]; 			
		$trc_id = $_POST["e_tcid"]; 
		$st = count($trc_id);
		
		
		$shift_ops = $_POST["shift_ops"];
	    $dateF = $_POST["date1"];
	
		$item_no = $_POST["item_no"];
		$scan_qty = $_POST["scan_qty"];
		$plant_code2 = $_POST["plant_code2"];
		$sloc_rej = $_POST["sloc_rej"];
		$work_center = $_POST["work_center"];
		$proc_reject = $_POST["proc_reject"];
		$type_reject = $_POST["type_reject"];
		$type_defect = $_POST["type_defect"];
		$remark_dis = $_POST["remark_dis"];
		
		
		
	    foreach($_POST["idd"] as $j=>$i) {
		   
		$azieTest =  (($_POST["sloc_rej"][$i]).';');
	    $amount .= (($_POST["scan_qty"][$i]).';');
		$amount2 .= $azieTest;
		$amount3 .= (($_POST["item_no"][$i]).';');
				
		//-----checking barcode GR Tag
		
		$string = explode(";",($amount));	
		$string2 = explode(";",($amount2));	
		$string3 = explode(";",($amount3));	
		
	
        }
	
	
	
		 for($i=0; $i<$st; $i++)
	{		
	
	// echo ($i+1).'-'.$cancel[$i]; echo "</br>";
	
	             $ddF = substr($_POST["date1"],0,2);
				 $mmF = substr($_POST["date1"],3,2);
				 $yyF = substr($_POST["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
	   //----------insert check to table scan_prd_creject-------------
	   
	      $query_po_list = "SELECT * FROM scan_prd_creject WHERE id_scan_dis = '".sql_esc($trc_id[$i])."'";
          $result_po_list = mysqli_query($dbc,$query_po_list);
          $row_po_list = mysqli_fetch_array($result_po_list);
		  

		
		
		$query_tag3 = "INSERT INTO prd_creject_detail(id_dis,doc_dis,id_scan_dis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,plant_code,sloc_from,sloc_to,qty_dis,uom_dis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_dis,date_generate_dis,time_generate_dis,ref_doc_dis,user_cancel,date_cancel,remark_cancel,status_ftp,status_tran,status_dis,sloc_rej,work_center,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,remark_dis,status_approved1,hod_approved1,date_approved1,remark_approved1,status_approved2,hod_approved2,date_approved2,remark_approved2,status_approved3,hod_approved3,date_approved3,remark_approved3,status_approved4,hod_approved4,date_approved4,remark_approved4,status_part,cost_center,barcode_gr,gr_doc_no,bill_component,material_desc_c,c_vclass,SAP_ref_doc,SAP_ref_doc_can) VALUES ('','".sql_esc($ref3)."','".sql_esc($row_po_list["id_scan_dis"])."','".sql_esc($row_po_list["scan_doc"])."','".sql_esc($string3[$i])."','".sql_esc($row_po_list["material_no"])."','".sql_esc($row_po_list["material_desc"])."','".sql_esc($row_po_list["plan_no"])."','".sql_esc($row_po_list["doc_no"])."','".sql_esc($row_po_list["plant_code"])."','".sql_esc($row_po_list["scan_sloc_f"])."','".sql_esc($row_po_list["scan_sloc_t"])."','".sql_esc($string[$i])."','".sql_esc($row_po_list["scan_uom"])."','".sql_esc($date1_final)."','".sql_esc($shift_ops)."','".sql_esc($row_po_list["model_code"])."','".sql_esc($row_po_list["material_type"])."','".sql_esc($row_po_list["stamp_ind"])."','".sql_esc($row_po_list["slip_no"])."','".sql_esc($row_po_list["user_create"])."','".sql_esc($row_po_list["date_create"])."','".sql_esc($username)."',NOW(),NOW(),'','','','remrk','N','Y','','".sql_esc($string2[$i])."','','','','','','','','','','','','','','','','','','','','','','','','','','','','".sql_esc($row_po_list["barcode_ref"])."','".sql_esc($row_po_list["gr_doc_no"])."','".sql_esc($row_po_list["bill_component"])."','".sql_esc($row_po_list["material_desc_c"])."','".sql_esc($row_po_list["c_vclass"])."','','')";
		$result_tag3 = mysqli_query($dbc,$query_tag3);
		
			//---update status "yes" for generate tp to store----
		
		$query_update_scan = "UPDATE scan_prd_creject SET status = 'Y', status_dis = '".sql_esc($rst_sta7["status_desc"])."' WHERE id_scan_dis = '".sql_esc($trc_id[$i])."'";
	    $rst_update_scan = mysqli_query($dbc,$query_update_scan);
		
		 
	 /*  $query_tag3 = "INSERT INTO po_detail_trans_gr(id,id_gr,doc_gen,comp_code,plant_code,purc_ord_no,vendor_id,gr_chg,deleg_gr,item_no,material_no, material_desc,size_gr,model_gr,matl_group,purc_group,sloc,doc_date,po_qty,ord_uom,yr_gr,user_create,date_create,user_update, date_update,date_upload,status_po,dlv_ord_no,shift_gr,user_posting,posting_gr,sloc_gr,rec_qty,gr_qty,status_gr,material_doc_gen,date_post,time_post,ref_doc_gen,user_cancel,date_cancel,time_cancel,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".$row_po_list["id_gr"]."','".$row_po_list["doc_gen"]."','".$row_po_list["comp_code"]."','".$row_po_list["plant_code"]."','".$row_po_list["purc_ord_no"]."','".$row_po_list["vendor_id"]."','".$row_po_list["gr_chg"]."','".$row_po_list["deleg_gr"]."','".$row_po_list["item_no"]."','".$row_po_list["material_no"]."','".$row_po_list["material_desc"]."','".$row_po_list["size_gr"]."','".$row_po_list["model_gr"]."','".$row_po_list["matl_group"]."','".$row_po_list["purc_group"]."','".$row_po_list["sloc"]."','".$row_po_list["doc_date"]."','".$row_po_list["po_qty"]."','".$row_po_list["ord_uom"]."','".$row_po_list["yr_gr"]."','".$row_po_list["user_create"]."','".$row_po_list["date_create"]."','".$username."',NOW(),'".$row_po_list["date_upload"]."','".$rst_sta7["status_desc"]."','".$dlv_ord_no."','".$shift_ops."','".$username."','".$date1_final."','".$string2[$i]."','".$tot_gr_qty2a."','".$string[$i]."','".$rst_sta3["status_desc"]."','".$ref3."',NOW(),NOW(),'','','','','','')";
	   $result_tag3 = mysqli_query($dbc,$query_tag3);	  */
		  
		
		  
		//update table po_detail
	
		
		/*$query_all = "SELECT * FROM po_detail_trans_gr WHERE id_gr = '".$trc_id[$i]."' AND material_doc_gen = '".$ref3."' AND status_gr = '".$rst_sta3["status_desc"]."'";
		$result_all = mysqli_query($dbc,$query_all);
		$data_all = mysqli_fetch_array($result_all);*/
		
		//update table po_detail
		
	   /* $query_releas_v2 = "UPDATE po_detail SET status_po = '".$rst_sta7["status_desc"]."', user_update = '".$username."', date_update = NOW() WHERE id_gr = '".$trc_id[$i]."'";
        $result_releas_v2 = mysqli_query($dbc,$query_releas_v2);*/
		
		
		//update table print tag GR
		
	/*	 $dl_qty = $data_all["gr_qty"];*/
		 
		  //----detail standard packaging [ambil dari table mat_master_header]
	  
	  /* $query_pack = "SELECT std_packaging, type_package FROM table_material_itsb WHERE material_no = '".$data_all["material_no"]."'";
	   $result_pack = mysqli_query($dbc,$query_pack);
	   $data_pack = mysqli_fetch_array($result_pack);
		
		
		        if(($data_pack["std_packaging"] == "") || ($data_pack["std_packaging"] == "0"))
		        {
		
		        $st_pack = $dl_qty;
	            }else{
		
                $st_pack = $data_pack["std_packaging"];
		        }
		 
		 $bil_tag = "";
		 
		 if($dl_qty != "0")
		 {
		 
         $bil_tag = ($dl_qty / $st_pack);
	  
		 }
		
     $b =  intval($bil_tag);  // genapkan value yg dibahagikan utk didarabkan 
	// $b = round($bil_tag, 0, PHP_ROUND_HALF_DOWN);  // genapkan value yg dibahagikan utk didarabkan 
	 $last_tag = ($bil_tag - $b);	   // sekiranya masih ada baki utk keluarkn delivery tag yg last
	 
	 
	 $bil_tag2 = ($st_pack * $b);
	 
	 if($dl_qty < ($st_pack))
	 {
	 $bil_tag3A = ($dl_qty);
	 
	 }else{
	 $bil_tag3A =  ($dl_qty - $bil_tag2);  //quantity delivery tag yg last
      }*/
	// echo "last qty ".$last_tag;
	 
	/* $query_id2 = "SELECT MAX(tag_no) FROM delivery_tagasn";
     $result_id2 = mysql_query($query_id2);
	 $row_id2 = mysql_fetch_row($result_id2);
	 
	 $tag_no = ($row_id[1] + 1);
	 echo $tag_no;   */
	 
	/* echo "B  : ".$b;
	 
	 if($b <= 1)
	 {
	  $no_tg = 1;
	  }elseif($last_tag == 0)
	  {
	   $no_tg = $b;
	  }else{
	  
	  $no_tg = ($b + 1);
	  
	  }
	  
	
	  
	$w = 1;
		   
     for($m=1; $m <= $bil_tag; $m++)
	 { 
	  echo "first"; echo $no_tg;
	 
       $query_tag3 = "INSERT INTO print_tag_gd_receipt(id_tag,tag_no,id_gr,material_doc_gen,doc_gen,dlv_ord_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_po,yr_gr,slip_no,total_slip)  VALUES('','','".$data_all["id"]."','".$data_all["material_doc_gen"]."','".$data_all["doc_gen"]."','".$data_all["dlv_ord_no"]."','".$data_all["plant_code"]."','".$data_all["purc_ord_no"]."','".$data_all["vendor_id"]."','".$data_all["item_no"]."','".$data_all["material_no"]."','".$data_all["material_desc"]."','".$data_all["size_gr"]."','".$data_all["model_gr"]."','".$data_all["ord_uom"]."','$st_pack','".$data_all["shift_gr"]."','".$data_all["sloc"]."','".$data_all["sloc_gr"]."','".$data_all["user_posting"]."','".$data_all["posting_gr"]."','".$data_all["time_post"]."','$username',NOW(),'N','N','".$data_all["status_po"]."',NOW(),'".$w."','".$no_tg."')";
	   $result_tag3 = mysqli_query($dbc,$query_tag3);
	   
	     $tag_no = ($data_all["material_doc_gen"].'/'.$w.'/'.$data_pack["std_packaging"].'/'.$no_tg);
		
		 
		 $query_tag3_t = "UPDATE print_tag_gd_receipt SET tag_no = '".$tag_no."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND material_doc_gen = '".$ref3."'";
	     $result_tag3_t = mysqli_query($dbc,$query_tag3_t);
	   
     $w++; 
	 
	 } // end for loop
	 
	 
	  if(($last_tag > 0.00) || ($dl_qty < ($st_pack))){	   // kalau qty lebih kecil drpd std packaging and baki drpd bahagi tag
	  
	   echo "last"; echo $no_tg;
	 
	 $query_tag2 = "INSERT INTO print_tag_gd_receipt(id_tag,tag_no,id_gr,material_doc_gen,doc_gen,dlv_ord_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_po,yr_gr,slip_no,total_slip)  VALUES('','','".$data_all["id"]."','".$data_all["material_doc_gen"]."','".$data_all["doc_gen"]."','".$data_all["dlv_ord_no"]."','".$data_all["plant_code"]."','".$data_all["purc_ord_no"]."','".$data_all["vendor_id"]."','".$data_all["item_no"]."','".$data_all["material_no"]."','".$data_all["material_desc"]."','".$data_all["size_gr"]."','".$data_all["model_gr"]."','".$data_all["ord_uom"]."','".$bil_tag3A."','".$data_all["shift_gr"]."','".$data_all["sloc"]."','".$data_all["sloc_gr"]."','".$data_all["user_posting"]."','".$data_all["posting_gr"]."','".$data_all["time_post"]."','$username',NOW(),'N','N','".$data_all["status_po"]."',NOW(),'".$w."','".$no_tg."')"; 
	   $result_tag2 = mysqli_query($dbc,$query_tag2);
	   

       
	     $tag_no = ($data_all["material_doc_gen"].'/'.$w.'/'.$bil_tag3A.'/'.($b + 1));
		 
		 $query_tag2_t = "UPDATE print_tag_gd_receipt SET tag_no = '".$tag_no."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND material_doc_gen = '".$ref3."'";
	     $result_tag2_t = mysqli_query($dbc,$query_tag2_t);
	   
		 }// end if
		*/
		
		
		
		
			}// end for loop
			
			
			
			
	//generate text file ftp GR		
/*			
	$qry = mysqli_query($dbc,"SELECT *, DATE_FORMAT(posting_gr,'%d%m%Y') AS R FROM po_detail_trans_gr WHERE material_doc_gen = '".$ref3."'");
	
$data = "";
while($row = mysqli_fetch_array($qry)) {
	
	$qty_nw = (intval($row['gr_qty']));
	
  $data .= $row['purc_ord_no'].";".$row['material_doc_gen'].";".$row['dlv_ord_no'].";".$row['R'].";".$row['material_no'].";".$qty_nw.";".$row['ord_uom'].";101;".$row['sloc_gr'].";".$row['user_posting']."\r\n";
     
}

$filen="GR".$ref3;
//$csv_filename = $filen."_".date("YmdHis",time());

$file = "../FromPortal2/GR/".$filen.".csv";
//chmod($file, 0777);
file_put_contents($file,$data);

*/

 //----colect data --------------
/*  $query_collect = "SELECT * FROM po_detail_trans_gr WHERE material_doc_gen = '".$ref3."'";
  $rst_collect = mysqli_query($dbc,$query_collect);
  
   while($data_collect = mysqli_fetch_array($rst_collect))
  {

    //--------insert into table ftp_detail_gd_receipt
  
     $query_ftp_info = "INSERT INTO ftp_detail_gd_receipt(id_ups,file_name,material_doc_gen,id_gr,doc_gen,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,sloc,sloc_gr,doc_date,po_qty,gr_qty,ord_uom,user_posting,date_posting,time_posting,status_po,status_ftp,mvt_type) VALUES('','".$filen."','".$ref3."','".$data_collect["id_gr"]."','".$data_collect["doc_gen"]."','".$data_collect["plant_code"]."','".$data_collect["purc_ord_no"]."','".$data_collect["vendor_id"]."','".$data_collect["item_no"]."','".$data_collect["material_no"]."','".$data_collect["material_desc"]."','".$data_collect["sloc"]."','".$data_collect["sloc_gr"]."','".$data_collect["doc_date"]."','".$data_collect["po_qty"]."','".$data_collect["gr_qty"]."','".$data_collect["ord_uom"]."','".$data_collect["user_posting"]."','".$data_collect["posting_gr"]."','".$data_collect["time_post"]."','".$data_collect["status_po"]."','Y','101')"; 
     $rst_ftp_info = mysqli_query($dbc,$query_ftp_info);
	 
	 
	 
	 
  } 
  
*/		//update count_max----------------------------------------
	 
	  if($_POST["plant_code2"] == '3100')
	{
  
       $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '29'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	   
	   $query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($scan_doc)."', date_updated = NOW() WHERE uid = '133'";
	   $result_max_aA = mysqli_query($dbc,$query_max_aA);

	}elseif($_POST["plant_code2"] == '3101')
	{
	   $query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '78'";
	   $result_max_b = mysqli_query($dbc,$query_max_b);
	   
	   $query_max_bB = "UPDATE run_count_itsb SET count_max = '".sql_esc($scan_doc)."', date_updated = NOW() WHERE uid = '133'";
	   $result_max_bB = mysqli_query($dbc,$query_max_bB);
	 
	}
	
	
	//----update table po_detail_trans_gr utk yg x generate mat. doc. no
	  
	  /*  $query_upd_can = "UPDATE po_detail_trans_gr SET status_po = '".$rst_sta6["status_desc"]."', status_gr = '".$rst_sta6["status_desc"]."', user_update = '".$username."', purc_ord_no = '".$purc_ord_no."', user_cancel = '".$username."', date_cancel = NOW(), time_cancel = NOW() WHERE material_doc_gen = '' AND status_gr = '".$rst_sta["status_desc"]."' ";
        $result_upd_can = mysqli_query($dbc,$query_upd_can);*/
	
	

   //end update count_max ---------------------------------	
	    $ref2 = base64_encode($ref3);
	  
	    echo "<script>";
		echo "alert('Material Document $ref3 posted.');";
		//echo "window.open('detail_print_gd_receipt-tag.php?uid2=$ref2');";
		echo "window.location='detail_comp_reject_prd.php';"; 
		echo "</script>";
		exit(); //quit the script
			
			
   }// end if
 
?>

<?php

 if(isset($_POST["submit5"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

//-----------delete all data current screen-------------

   $query_delete_scan = "DELETE FROM scan_prd_creject WHERE scan_doc = '".sql_esc($scan_doc)."'";
   $result_delete_scan = mysqli_query($dbc,$query_delete_scan);

//---------end delete ----------------------------------

}//end submit5

?>