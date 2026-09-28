<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));



                 $drun = substr($fmt_curr_date,0,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,8,2);
				 
				 $date_run = ($drun.$mrun.$yrun);

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "3")) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
    $url = "detail_GR_disposal-receive.php"; 
	
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

//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc,$sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

//CR status (Transfer Posting)
$sta19 = "SELECT * from request_status WHERE status_id = '19'";
$sta_res19 = mysqli_query($dbc,$sta19);
$rst_sta19 = mysqli_fetch_array($sta_res19);	

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);	


	?>

<?php

$number =  (base64_decode($_GET["scan_doc"]));

echo $number;

if(isset($_POST["submit4"]))  
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}


      
	   $scan_doc = $number;  
	   $scan_qty = $_POST["scan_qty"]; 
	   $sloc_rej = $_POST["sloc_rej"]; 
	   $item_no = $_POST["item_no"];
	   $id_dis = $_POST["id_dis"];  
	   $plant_code2 = $_POST["plant_code2"]; 
	   $remark_dis = $_POST["remark_dis"];
	   $dateF = $_POST["date1"];
	   $work_center = $_POST["work_center"];
	  // $type_reject = $_POST["type_reject"];
	   //$type_defect = $_POST["type_defect"];
	   $reason_reject  = $_POST["reason_reject"];
	   
	   
	   
		  if((($_POST["date1"]) == "00-00-0000") || (($_POST["date1"]) == ""))
     {
	     $dateF = FALSE;
		 $message_psdt = '<span class="badge badge-pill badge-danger"> Please select Posting Date !</span>';
	 }else{
		 $dateF = TRUE;
	  }
	   
	   foreach($_POST["id_dis"] as $j=>$i) {
		   
	   /*echo $_POST["item_no"][$i];  echo "<br>";
	     echo $_POST["scan_qty"][$i];  echo "<br>";
		 echo $_POST["sloc_rej"][$i];  echo "<br>";
		 echo $_POST["work_center"][$i];  echo "<br>";
	     echo $_POST["type_reject"][$i];  echo "<br>";
		 echo $_POST["type_defect"][$i];  echo "<br>";
	     echo $_POST["reason_reject"][$i];  echo "<br>";*/
		
	   
	      if(($_POST["scan_qty"][$i]) == "")
	      { 
		     $scan_qty = FALSE;
				
		   }//end if
		   
		   if(($_POST["sloc_rej"][$i]) == "")
	      { 
		     $sloc_rej = FALSE;
				
		   }//end if
		   
		    if(($_POST["work_center"][$i]) == "")
	      { 
		     $work_center = FALSE;
				
		   }//end if
		   
		    if(($_POST["remark_dis"][$i]) == "")
	      { 
		     $remark_dis = FALSE;
				
		   }//end if
		  
	     }//for each
	 		

  if($dateF && $scan_qty && $sloc_rej && $work_center && $remark_dis)
  {
		   
	   //-------------------generate gra QC doc no.---------------
	
	 if($_POST["plant_code2"] == '2300')
	{
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '33'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($_POST["plant_code2"] == '2301')
	{
		
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '82'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 000; 
	$dht_OK2 = "371";
	$dg2 = 0;

  	if($row_id2["count_max"] <= 0)
  	{ 
   
    	$lastID2 = ($row_id2["count_max"] + 1);
    	$dg2 = ($dht2 + ($lastID2));
   }
   else
   {
      $lastID2 = ($row_id2["count_max"] + 1);
      $dg2 =  $lastID2;
	
    }
	$number2 = $dg2; // Length of running no
    $number2 = sprintf('%03d', $number2);  
	
    $ref = (($row_id2["start_ref"]).$dht_OK2.$date_run.($number2));
	  
	
	} // end if $result_id2

	    
		
		$amount = "";
		$amount2 = "";
		$amount3 = "";
		$amount4 = "";
		$amount5 = "";
		$amount6 = "";
		$amount7 = "";
		$amount8 = "";
		$amount9 = "";
	    $how_many = count($id_dis); 
		
		$item_no = $_POST["item_no"]; 
		$scan_qty = $_POST["scan_qty"]; 
	    $sloc_rej = $_POST["sloc_rej"]; 
		$id_dis = $_POST["id_dis"]; 
		$remark_dis = $_POST["remark_dis"];
		$work_center = $_POST["work_center"];
	   // $type_reject = $_POST["type_reject"];
		//$type_defect = $_POST["type_defect"];
	    $reason_reject  = $_POST["reason_reject"];
		$dateF = $_POST["date1"];
		
		           //----format date---- 
		         $ddF = substr($_POST["date1"],0,2);
				 $mmF = substr($_POST["date1"],3,2);
				 $yyF = substr($_POST["date1"],6,4);
			
			     $date_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
	/* for($i = 0; $i < count($_POST["type_reject"]); $i++)  
	{
		
		
		$type_rejectX = $_POST["type_reject"];
		$type_defectX = $_POST["type_defect"];
		
		 echo "type hhhh :".$type_rejectX[$i]; echo "</br>";
		
		 echo "defect : ".$type_defectX[$i]; echo "</br>";
		
		
		
		$apaFirst = $_POST['achv_ed'];
		$apaScd = $_POST['defect'];
		
		$ch_temp = "INSERT INTO type_reject_test(first,second,third)
						VALUES ('".$apaFirst[$i]."','".$apaScd[$i]."','') ";
						
		$rs_chtemp = mysql_query($ch_temp) or die (mysql_error());
	
	}
		*/		 
				 
				 
		

       foreach($_POST["id_dis"] as $j=>$i) {
		   
		$azieTest =  (($_POST["sloc_rej"][$i]).';');
	    $amount .= (($_POST["scan_qty"][$i]).';');
		$amount2 .= $azieTest;
		$amount3 .= (($_POST["item_no"][$i]).';');
		$amount4 .= (($_POST["id_dis"][$i]).';');
		$amount5 .= (($_POST["remark_dis"][$i]).';');
		$amount6 .= (($_POST["work_center"][$i]).';');
		//$amount7 .= (($_POST["type_reject"][$i]).';');
		$amount8 .= (($_POST["reason_reject"][$i]).';');
		//$amount9 .= (($_POST["type_defect"][$i]).';');
		
		//-----checking barcode GR Tag
		
		$string = explode(";",($amount));	
		$string2 = explode(";",($amount2));	
		$string3 = explode(";",($amount3));
		$string4 = explode(";",($amount4));
		$string5 = explode(";",($amount5));
		$string6 = explode(";",($amount6));
		$string7 = explode(";",($amount7));
		$string8 = explode(";",($amount8));
		$string9 = explode(";",($amount9));
		
	
        }
		
		
		
		
	  
		 			
		   for ($i=0; $i< $how_many; $i++) { 
		   
		  //  $bar_gr2 = trim($string2[$i],"\t");
			
		
		 //split dulu pps ref kpd prod_order, material,uom, plant, sloc, qty
			//$str_tp = $bar_gr2;
			
			
			
			/*if($str_tp)
			{
			
			
			list($part1, $part2, $part3, $part4, $part5, $part6, $part7, $part8, $part9, $part10) = (explode('|', $str_tp, 10));
		
			}
	*/
		   
		//	echo $part4;  echo "<br>"; 
		 echo html_esc($string[$i]); echo "</br>";
		/* echo $string2[$i]; echo "</br>";
		 echo $string3[$i]; echo "</br>";
		 echo $string4[$i]; echo "</br>";
		 echo $string5[$i]; echo "</br>";
		 echo $string6[$i]; echo "</br>";
		 echo $string7[$i]; echo "</br>";
		 echo $string8[$i]; echo "</br>";
		 echo $string9[$i]; echo "</br>";*/
		 
		 
		 //echo "reason :".$string8[$i]; echo "</br>";
		  
		$type_rejectX = $_POST["type_reject"];
		$type_defectX = $_POST["type_defect"];
		
		// echo "type :".$type_rejectX[$i]; echo "</br>";
		
		// echo "defect : ".$type_defectX[$i]; echo "</br>";
		 
		
		
		/*$query_update_scan2 = "UPDATE sc_gra_disposal_ppcrec SET scan_qty = '".$string[$i]."' WHERE id_scan_dis = '".$string4[$i]."'";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2);
		
		
		 $query_dtl_chk2 = "SELECT * FROM sc_gra_disposal_ppcrec WHERE id_scan_dis = '".$string4[$i]."'";
		 $result_dtl_chk2 = mysqli_query($dbc,$query_dtl_chk2);
		 $row_info = mysqli_fetch_array($result_dtl_chk2);*/
		
	     //----get cost center ----
		/*  $query_wctr = "SELECT * FROM work_center_detail WHERE id_work = '".$string6[$i]."'";
		  $result_wctr = mysqli_query($dbc,$query_wctr);
		  $row_wctr = mysqli_fetch_array($result_wctr);
		*/
		//---------insert data at table gra_disposal_ppcrec_detail - status part = 'WS'
		
		 /* $query_storeD = "INSERT INTO gra_disposal_ppcrec_detail(id_dis,doc_dis,id_scan_dis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,comp_code,plant_code,sloc_from,sloc_to,qty_dis,uom_dis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_dis,date_generate_dis,time_generate_dis,ref_doc_dis,user_cancel,date_cancel,remark_cancel,status_ftp,status_tran,status_dis,sloc_rej,work_center,type_reject,type_defect,reason_reject,remark_dis,status_approved1,hod_approved1,date_approved1,remark_approved1,status_approved2,hod_approved2,date_approved2,remark_approved2,status_approved3,hod_approved3,date_approved3,remark_approved3,status_approved4,hod_approved4,date_approved4,remark_approved4,status_part,cost_center,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".$ref."','".$row_info["id_scan_dis"]."','".$number."','".$string3[$i]."','".$row_info["material_no"]."','".$row_info["material_desc"]."','".$row_info["plan_no"]."','".$row_info["doc_no"]."','".$row_info["plant_code"]."','".$_POST["plant_code2"]."','".$row_info["scan_sloc"]."','','".$string[$i]."','".strtoupper($row_info["scan_uom"])."','".$date_final."','".$row_info["scan_shift"]."','".$row_info["model_code"]."','".$row_info["material_type"]."','".$row_info["stamp_ind"]."','".$row_info["slip_no"]."','".$row_info["user_create"]."','".$row_info["date_create"]."','".$username."',NOW(),NOW(),'','','','','N','Y','".$rst_sta10["status_desc"]."','".$string2[$i]."','".$string6[$i]."','".$string7[$i]."','".$string9[$i]."','".$string8[$i]."','".$string5[$i]."','','','','','','','','','','','','','','','','','WS','".$row_wctr["cost_center"]."','','')";          
		  $rst_storeD = mysqli_query($dbc,$query_storeD);
		*/

		//---update status "yes" for generate diposal PPC Receiving----
		
	/*	$query_update_scan = "UPDATE sc_gra_disposal_ppcrec SET status = 'Y', status_dis = '".$rst_sta10["status_desc"]."' WHERE id_scan_dis = '".$string4[$i]."'";
	    $rst_update_scan = mysqli_query($dbc,$query_update_scan);
		*/
		
		//---------------update at table disposal_detail_prd_all [prod - ppc receiving - ppc delivery - qc - coo ]----------
		
	    /* $query_chk_info = "SELECT * FROM gra_disposal_ppcrec_detail WHERE id_dis = '".$string4[$i]."'";
		 $result_chk_info =  mysqli_query($dbc,$query_chk_info);
		 $row_chk_info = mysqli_fetch_array($result_chk_info);
		 
		
		$query_ins_dis = "INSERT INTO disposal_detail_prd_all(id,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,remark_approved4,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".$row_chk_info["id_dis"]."','".$row_chk_info["doc_dis"]."','".$row_chk_info["item_no"]."','','','','".$row_chk_info["doc_no"]."','".$row_chk_info["plan_no"]."','".$row_chk_info["id_scan_dis"]."','".$row_chk_info["material_no"]."','".$row_chk_info["material_desc"]."','".$row_chk_info["material_type"]."','".$row_chk_info["model_code"]."','".$row_info["scan_qty"]."','','','','".$row_chk_info["qty_dis"]."','','','".$row_chk_info["uom_dis"]."','".$row_chk_info["comp_code"]."','".$row_chk_info["work_center"]."','".$row_chk_info["shift_day"]."','".$row_info["scan_date"]."','".$row_chk_info["user_generate_dis"]."','".$row_chk_info["date_generate_dis"]."','".$row_chk_info["time_generate_dis"]."','".$row_chk_info["status_dis"]."','".$row_chk_info["sloc_rej"]."','".$row_chk_info["sloc_rej"]."','','".$row_chk_info["type_reject"]."','".$row_chk_info["type_defect"]."','".$row_chk_info["reason_reject"]."','".$row_chk_info["user_reject"]."','".$row_chk_info["date_reject"]."','".$row_chk_info["time_reject"]."','','','','','','','".$row_chk_info["user_create"]."','".$row_chk_info["date_create"]."','".$row_chk_info["remark_dis"]."','".$row_chk_info["status_part"]."','','','".$row_chk_info["status_approved1"]."','".$row_chk_info["hod_approved1"]."','".$row_chk_info["date_approved1"]."','".$row_chk_info["remark_approved1"]."','".$row_chk_info["status_approved2"]."','".$row_chk_info["hod_approved2"]."','".$row_chk_info["date_approved2"]."','".$row_chk_info["remark_approved2"]."','".$row_chk_info["status_approved3"]."','".$row_chk_info["hod_approved3"]."','".$row_chk_info["date_approved3"]."','".$row_chk_info["remark_approved3"]."','".$row_chk_info["status_approved4"]."','".$row_chk_info["hod_approved4"]."','".$row_chk_info["date_approved4"]."','".$row_chk_info["remark_approved4"]."','".$row_chk_info["cost_center"]."','1','".$row_chk_info["ref_doc_dis"]."','".$row_chk_info["user_cancel"]."','".$row_chk_info["date_cancel"]."','".$row_chk_info["remark_cancel"]."','".$row_chk_info["plant_code"]."','".$row_chk_info["shift_day"]."','".$row_info["stamp_ind"]."','".$row_chk_info["SAP_ref_doc"]."','".$row_chk_info["SAP_ref_doc_can"]."')";
$result_ins_dis = mysqli_query($dbc,$query_ins_dis); 
			
		*/
		
	
		
		
		
		
	}//end for loop
       
	 
	   
	 //update count_max----------------------------------------
	 
	/*  if($_POST["plant_code2"] == '2300')
	{
  
       $query_max_a = "UPDATE run_count_itsb SET count_max = '".$number2."', date_updated = NOW() WHERE uid = '33'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".$number."', date_updated = NOW() WHERE uid = '124'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);

	}elseif($_POST["plant_code2"] == '2301')
	{
	   $query_max_b = "UPDATE run_count_itsb SET count_max = '".$number2."', date_updated = NOW() WHERE uid = '82'";
	   $result_max_b = mysqli_query($dbc,$query_max_b);
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".$number."', date_updated = NOW() WHERE uid = '124'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);
	}

   //end update count_max ---------------------------------	
   
   $ref_GRA = (base64_encode($ref));
   
    echo '<script type="text/javascript">';
	echo "alert('Material Document $ref posted.');";
	echo "window.location='detail_GR_disposal-receive.php';"; 
	echo "</script>";
	exit(); //quit the script
*/
	
	 }//end ifelse "OK"

}// end submit 4



if(isset($_POST["submit5"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

//-----------delete all data current screen-------------

   $query_delete_scan = "DELETE FROM sc_gra_disposal_ppcrec WHERE scan_doc = '".sql_esc($number)."'";
   $result_delete_scan = mysqli_query($dbc,$query_delete_scan);

//---------end delete ----------------------------------

}//end submit5


?>      
  
 

</head>


<body>
</body>
</html>
