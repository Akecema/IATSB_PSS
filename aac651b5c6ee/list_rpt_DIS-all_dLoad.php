<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

date_default_timezone_set('Asia/Kuala_Lumpur');

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));



set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
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
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	include 'apprv_func_list.php';  
	
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

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13'";
$sta_res13 = mysqli_query($dbc,$sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Pending Approve)
$sta15 = "SELECT * from request_status WHERE status_id = '15'";
$sta_res15 = mysqli_query($dbc,$sta15);
$rst_sta15 = mysqli_fetch_array($sta_res15);

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

//CR status (Pending Approval COO)
$sta25 = "SELECT * from request_status WHERE status_id = '25'";
$sta_res25 = mysqli_query($dbc,$sta25);
$rst_sta25 = mysqli_fetch_array($sta_res25);

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

//CR status (Pending Approval Exec QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

//CR status (Pending Approve STM)
$sta32 = "SELECT * from request_status WHERE status_id = '32'";
$sta_res32 = mysqli_query($dbc,$sta32);
$rst_sta32 = mysqli_fetch_array($sta_res32);

//CR status (Pending Approve ASSY)
$sta34 = "SELECT * from request_status WHERE status_id = '34'";
$sta_res34 = mysqli_query($dbc,$sta34);
$rst_sta34 = mysqli_fetch_array($sta_res34);

//---------------------------------------------------------

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
   
</head>
<body>

<?php

//if(isset($_POST['download'])) 
//{ // handle the form.
date_default_timezone_set('Asia/Kuala_Lumpur');
$date_tdy = date('d-m-Y H:i:s');
set_time_limit(0);

            
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
        	//$doc_dis = $_GET["doc_dis"]; 
			$plant_code = $_GET["plant_code"]; 
			$work_center = $_GET["work_center"];
			$material_no = $_GET["material_no"]; 
			$rej_opt = $_GET["rej_opt"];  
			
			
			
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);
				 
				 
				  //1. Plant Code
                if (($plant_code == "") || ($plant_code == "NULL")){ 
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND plant_cd = '".sql_esc($plant_code)."'"; }  	
					
		   // 2. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (date_disposal >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //3. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
					$wheresql_03 = " AND (date_disposal <= '".sql_esc($date2_final)."')"; }
					
					
		 //4. Work Center
                if ($work_center == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND work_center = '".sql_esc($work_center)."'"; }
   
	       //5. Part Number
                if ($material_no == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND material_no = '".sql_esc($material_no)."'"; } 
					
		/*  //6. Doc Disposal.
                if ($doc_dis == "NULL"){ 
                    $wheresql_06 = ""; }
                else {
                    $wheresql_06 = " AND doc_dis = '$doc_dis'"; } */
					
					
			//7. Reject Source
                if ($rej_opt == "NULL"){ 
                    $wheresql_07 = ""; }
                else {
                    $wheresql_07 = " AND reject_source = '".sql_esc($rej_opt)."'"; } 		
					
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05 .$wheresql_07;

	
	//********** END CONDITION **************
 

$namaFile = "Disposal_".$date_tdy.".xls";

 $count_record = "";	
		
  $query8 = "SELECT COUNT(*) FROM disposal_detail_prd_all WHERE status_part = 'PR' " .$where_sql ." ORDER BY doc_dis ASC ";
  $result8 = mysqli_query($dbc,$query8);
  $num_rows = mysqli_num_rows($result8);
  
  $query8a = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') as TW, DATE_FORMAT(date_disposal,'%d-%m-%Y') as T, DATE_FORMAT(date_posting,'%d-%m-%Y') as R, DATE_FORMAT(date_cancel,'%d-%m-%Y') as R3, DATE_FORMAT(date_approved,'%d-%m-%Y') as T7, DATE_FORMAT(date_approved2,'%d-%m-%Y') as T72, DATE_FORMAT(date_approved3,'%d-%m-%Y') as T73, DATE_FORMAT(date_approved4,'%d-%m-%Y') as T74, DATE_FORMAT(date_cancel,'%d-%m-%Y') as T75 FROM disposal_detail_prd_all WHERE status_part = 'PR' " .$where_sql." ORDER BY doc_dis ASC ";
  $result8a = mysqli_query($dbc,$query8a);
  $num_rows_8a = mysqli_num_rows($result8a);

//---------------------------end count
 // $count_record =  ($num_rows + $num_rows_8a);

 $count_record =  ($num_rows_8a);

//header("Content-type: application/octet-stream"); 
header('Content-type: application/excel');                                  
header('Content-Disposition: attachment; filename='.$namaFile.'');
header('Content-Type: image/jpeg');
header("Pragma: no-cache");
header("Expires: 0");

$content = "";
$data = "";	

//Create report header 

$content .= "<p><font size='12px'><strong> ".strtoupper($data_setup["title_desc"])."</strong></font></p>";
$content .= "<font size='12px'><strong>DOCUMENT LIST - DISPOSAL</strong></font> ";
$content .= "<br>";
/*$content .= "<font size='12px'><strong>FROM : ".$dateF." </strong></font>&nbsp;&nbsp;&nbsp; ";
$content .= "<font size='12px'><strong>TO : ".$dateT."</strong></font> ";*/
$content .= "<br>";
$content .= "<br>";
$content .= "Date : " .$date_tdy."&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ";
$content .= "Record Count : ".$count_record;
$content .= "<br>";

echo $content;
echo '<br>';
echo "<br>";  
 //-------Count all results------------------------//	
	
echo '<table border="1" width="100%">';
echo '<tr height="35">';
echo '<th width="5" bgcolor="#E9F58D">NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">MODEL</th>';
echo '<th width="5" bgcolor="#E9F58D">PART NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">PART NAME</th>';
echo '<th width="5" bgcolor="#E9F58D">PLANNED ORDER NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">PLANNED DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">BF DOC. NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">DISPOSAL DOC. NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">POSTING DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">PLANT</th>';
echo '<th width="5" bgcolor="#E9F58D">REJECT SOURCE</th>';
echo '<th width="5" bgcolor="#E9F58D">LINE</th>';
echo '<th width="5" bgcolor="#E9F58D">SHIFT</th>';
echo '<th width="5" bgcolor="#E9F58D">LOCATION</th>';
echo '<th width="5" bgcolor="#E9F58D">QUANTITY</th>';
echo '<th width="5" bgcolor="#E9F58D">UOM</th>';
/*echo '<th width="5" bgcolor="#E9F58D">CANCELLATION DATE</th>';*/
echo '<th width="5" bgcolor="#E9F58D">TYPE OF REJECT</th>';
echo '<th width="5" bgcolor="#E9F58D">DEFECTIVES</th>';
echo '<th width="5" bgcolor="#E9F58D">REASON OF REJECTION</th>';
echo '<th width="5" bgcolor="#E9F58D">STATUS</th>';
echo '<th width="5" bgcolor="#E9F58D">APPROVED/REJECTED DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">DISPOSAL CANCELLATION</th>';
echo '<th width="5" bgcolor="#E9F58D">DISPOSAL CANCELLATION DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">CANCELLED BY</th>';
echo '</tr>';
echo '</table>';

 
//Display table
// query menampilkan semua data
  $query_sql3 = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') as TW, DATE_FORMAT(date_disposal,'%d-%m-%Y') as T, DATE_FORMAT(date_posting,'%d-%m-%Y') as R, DATE_FORMAT(date_approved,'%d-%m-%Y') AS T9, DATE_FORMAT(date_approved2,'%d-%m-%Y') AS T19, DATE_FORMAT(date_approved3,'%d-%m-%Y') AS T29, DATE_FORMAT(date_approved4,'%d-%m-%Y') AS T39, DATE_FORMAT(date_approved5,'%d-%m-%Y') AS T49, DATE_FORMAT(date_cancel,'%d-%m-%Y') as T75 FROM disposal_detail_prd_all WHERE status_part = 'PR' " .$where_sql." ORDER BY doc_dis ASC ";
  $result_sql3 = mysqli_query($dbc,$query_sql3);   //run the query.
 
//count how many data
   $counter = 1;
   $no = 1;
   $i = 1; 

   
 echo '<table border="1" width="100%">';
	 
   $no2 = 1;
	   while ($data_sql3 = mysqli_fetch_array($result_sql3))
   {
	//-----shift-----
	   
	    //-----shift-----
	   
	   if($data_sql3["shift_posting"] == "D/S")
	   {
		   $shift_ds = "Day";
	   }elseif($data_sql3["shift_posting"] == "N/S")
	   {
		 $shift_ds = "Night";
	   }else{
		   
		   $shift_ds = "NA"; 
	   }
	
	
	//------- quantity	
	
	if($data_sql3["qty_NG"] != "0.000")
	{
		$qty_new = $data_sql3["qty_NG"];
		
	}elseif($data_sql3["qty_qc"] != "0.000")
	{
		$qty_new = $data_sql3["qty_qc"];
	}
	elseif($data_sql3["qty_qc_ok"] != "0.000")
	{
		$qty_new = $data_sql3["qty_qc_ok"];
	}else{
		
		
	}
	
	//-----user canccellation-----------
		 
		 $query_u_can = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_sql3["user_cancel"])."'"; 
		 $rs_u_can = mysqli_query($dbc,$query_u_can);   //run the query.
		 $data_u_can = mysqli_fetch_array($rs_u_can);
	
	 //---type of reject
 $query_type = "SELECT * FROM type_reject_detail_prd WHERE id_type = '".sql_esc($data_sql3["type_reject"])."' AND status_type = 'Y' ORDER BY id_type ASC";
 $result_type = mysqli_query($dbc,$query_type);
 $row_type = mysqli_fetch_array($result_type); 
 
  //---defect
 $query_defect = "SELECT * FROM type_defect_detail_prd WHERE id_defect = '".sql_esc($data_sql3["type_defect"])."' AND status_defect = 'Y' ORDER BY id_defect ASC";
 $result_defect = mysqli_query($dbc,$query_defect);
 $row_defect = mysqli_fetch_array($result_defect);   
 
 
 //----source disposal------
   $sta_out = substr($data_sql3["doc_dis"],4,3);	
   
       if($sta_out == "311")
	  {
		  
	  $source_dis = "Backflush";	  
		  
	  }elseif($sta_out == "321")
	  {
		   $source_dis = "Pending";
 
	   }elseif($sta_out == "331")
	  {
		   $source_dis = "Handwork";
	   
	   }elseif($sta_out == "341")
	  {
		  
		  $source_dis = "Rework"; 
	  }elseif($sta_out == "351")
	  {
		  
		  $source_dis = "Component Reject"; 
	  }
	  
	  
	  
 //-----change status disposal
	  
	  if($data_sql3["status_disposal"] == ($rst_sta3["status_desc"]))
	{
		 if($data_setup4["bil_table"] == "4")
         {  
		 
		$sta_dis = "Approved ".$rst_apprv6["apprv_name2"];
		$dt_dis = $data_sql3["T39"]; 
		 
		 }else{
		
		$sta_dis = "Approved ".$rst_apprv8["apprv_name2"];
		$dt_dis = $data_sql3["T49"]; 
		
		 }
		 
		 if($data_sql3["status_approved2"] == ($rst_sta3["status_desc"]))
	     {
		
		$sta_dis = "Approved HOD QC";
		$dt_dis = $data_sql3["T19"]; 
	  	
	     }
	
   }elseif($data_sql3["status_disposal"] == ($rst_sta5["status_desc"]))
	{
		//-------
		if($data_sql3["status_approved"] == ($rst_sta5["status_desc"]))
		{
			
		
		$sta_dis = "Rejected HOD Requestor";
		$dt_dis = $data_sql3["T9"]; 	
			
		}elseif($data_sql3["status_approved2"] == ($rst_sta5["status_desc"]))
		{
		
		$sta_dis = "Rejected Exec QC";
		$dt_dis = $data_sql3["T19"]; 
		
		}elseif($data_sql3["status_approved3"] == ($rst_sta5["status_desc"]))
		{
		
		$sta_dis = "Rejected HOD QC";
		$dt_dis = $data_sql3["T29"]; 
		
		}elseif($data_sql3["status_approved4"] == ($rst_sta5["status_desc"]))
		{
		
		$sta_dis = "Rejected ".$rst_apprv8["apprv_name2"];
		$dt_dis = $data_sql3["T39"]; 
		
		}elseif($data_sql3["status_approved5"] == ($rst_sta5["status_desc"]))
		{
		
				if($data_sql3["stamp_ind"] == "ASSY")
				{
				
				$sta_dis = "Rejected ".$rst_apprv4["apprv_name2"];
				$dt_dis = $data_sql3["T49"]; 	
					
				}elseif($data_sql3["stamp_ind"] == "STM")
				{
				
				
				$sta_dis = "Rejected ".$rst_apprv3["apprv_name2"];
				$dt_dis = $data_sql3["T49"]; 
				
				}else{  }
		
		
		
		}
		
		
	}elseif($data_sql3["status_disposal"] == ($rst_sta15["status_desc"]))
	{
		
		$sta_dis = "Pending ".$rst_apprv2["apprv_name2"];
		//$dt_dis = $row["T"]; 
	    $dt_dis = $data_sql3["T49"]; 
		
	}elseif($data_sql3["status_disposal"] == ($rst_sta32["status_desc"]))
	{
		
		$sta_dis = "Pending ".$rst_apprv3["apprv_name2"];
		//$dt_dis = $row["T"]; 
	    $dt_dis = $data_sql3["T49"]; 
		
	}elseif($data_sql3["status_disposal"] == ($rst_sta34["status_desc"]))
	{
		
		$sta_dis = "Pending ".$rst_apprv4["apprv_name2"];
		//$dt_dis = $row["T"]; 
	    $dt_dis = $data_sql3["T49"]; 
		
	}
	elseif($data_sql3["status_disposal"] == ($rst_sta24["status_desc"]))
	{
		
		$sta_dis = "Approved Exec QC";
		$dt_dis = $data_sql3["T19"]; 
		
	}elseif($data_sql3["status_disposal"] == ($rst_sta25["status_desc"]))
	{
		
		$sta_dis = "Approved HOD QC";
		$dt_dis = $data_sql3["T29"]; 
		
	}elseif($data_sql3["status_disposal"] == ($rst_sta29["status_desc"]))
	{
		
		       if($data_sql3["stamp_ind"] == "ASSY")
				{
				
				$sta_dis = "Approved ".$rst_apprv4["apprv_name2"];
				$dt_dis = $data_sql3["T49"]; 	
					
				}elseif($data_sql3["stamp_ind"] == "STM")
				{
				
				
				$sta_dis = "Approved ".$rst_apprv3["apprv_name2"];
				$dt_dis = $data_sql3["T49"]; 
				
				}else{  }
	
		
	}elseif($data_sql3["status_disposal"] == ($rst_sta25["status_desc"]))
	{
		
		$sta_dis = "Approved QC";
		$dt_dis = $data_sql3["T29"]; 
		
	}elseif($data_sql3["status_disposal"] == ($rst_sta4["status_desc"]))
	{
		
		$sta_dis = "Cancelled";
		$dt_dis = $data_sql3["T75"]; 
	}


 
 
		echo '<tr height="35">';
		echo '<td>'. $no2.'</td>'; 
		echo '<td>&nbsp;'. $data_sql3["model_code"].'</td>';  
		echo '<td>'. $data_sql3["material_no"].'</td>'; 	
		echo '<td>&nbsp;'. $data_sql3["material_desc"].'</td>'; 
		echo '<td>&nbsp;'. $data_sql3["plan_no"].'</td>'; 
		echo '<td>&nbsp;'. $data_sql3["TW"].'</td>'; 	
		echo '<td>'. $data_sql3["bflush_qqc_no"].'</td>';  
		echo '<td>&nbsp;'. $data_sql3["doc_dis"].'</td>';  	
		echo '<td>&nbsp;'. $data_sql3["T"].'</td>'; 	
		echo '<td>&nbsp;'. $data_sql3["plant_cd"].'</td>';
		echo '<td>&nbsp;'. $source_dis.'</td>';
		echo '<td>&nbsp;'. $data_sql3["work_center"].'</td>';  
		echo '<td>&nbsp;'. strtoupper($shift_ds).'</td>';
		echo '<td>&nbsp;'. $data_sql3["ploc_prod_reject"].'</td>';	
		if($data_sql3["UOM_unit"] == 'KG') {  echo '<td align="right">&nbsp;'.$qty_new.'</td>'; }else{  echo '<td align="right">&nbsp;'.intval($qty_new).'</td>'; } 
		echo '<td>&nbsp;'.$data_sql3["UOM_unit"].'</td>';
		/*echo '<td>&nbsp;'. $data_sql3["disposal_no_ref"].'</font></td>';
	 	echo '<td>&nbsp;'. $data_sql3["R3"].'</td>';*/
	    echo '<td>&nbsp;'.$row_type["type_desc"].'</td>';
		echo '<td>&nbsp;'.$row_defect["defect_desc"].'</td>';
        echo '<td>&nbsp;'.$data_sql3["reason_reject"].'</td>';
		echo '<td>&nbsp;'.$sta_dis.'</td>';
		if($dt_dis != "00-00-0000") {  
        echo '<td>&nbsp;'.$dt_dis.'</td>'; 
		}else{  
		
		echo '<td>&nbsp;</td>'; } 
		
		echo '<td>&nbsp;'.$data_sql3["disposal_no_ref"].'</td>';
	   if($data_sql3["date_cancel"] != "0000-00-00 00:00:00") {	
	     echo '<td>&nbsp;'.$data_sql3["T75"].'</td>';}else{
		 echo '<td>&nbsp;</td>';	 
		 }
		 echo '<td>&nbsp;'. $data_sql3["user_cancel"].' '.$data_u_can["user_fullname"].'</td>';
        echo '</tr>'; 
		

  ?><?php $no2++;
   }
    
    
  mysqli_free_result($result_sql3);   
   
  ?></tbody></table> 
 
<?php

echo iconv('utf-8', 'cp1251', "$data"); 
?>
</body>
</html>


