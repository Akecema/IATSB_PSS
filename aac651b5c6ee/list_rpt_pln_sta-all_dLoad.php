<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
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
$date_tdy = date('d-m-Y H:i:s');
set_time_limit(0);

            
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
        	//$plan_no = $_GET["plan_no"]; 
			$status_pps = $_GET["status_pps"]; 
			$plant_code = $_GET["plant_code"]; 
			$work_center = $_GET["work_center"];
			$material_no = $_GET["material_no"];
			
			
			 $where_sql = '';
				 
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 $ddF2 = substr($_GET["date2"],0,2);
				 $mmF2 = substr($_GET["date2"],3,2);
				 $yyF2 = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyF2.'-'.$mmF2.'-'.$ddF2);
			
			
			
			 
			
			
			 //1. Plant Code
                if (($plant_code == "") || ($plant_code == "NULL")){ 
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND plant_code = '".sql_esc($plant_code)."'"; }  	
					
		   // 2. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (date_plan >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //3. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
					$wheresql_03 = " AND (date_plan <= '".sql_esc($date2_final)."')"; }
					
					
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
					
		  //6. Planned Order
             /*   if ($plan_no == "NULL"){ 
                    $wheresql_06 = ""; }
                else {
                    $wheresql_06 = " AND plan_no = '$plan_no'"; }  	*/
					
		  //7. Status PPS
                if ($status_pps == "NULL"){ 
                    $wheresql_07 = " AND status_pps != '".sql_esc($rst_sta4["status_desc"])."' "; }
                else {
                    $wheresql_07 = " AND status_pps = '".sql_esc($status_pps)."'"; } 	 	
		
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05 .$wheresql_07;
						
	
	//********** END CONDITION **************
 

$namaFile = "Planned_Order_Status_".$date_tdy.".xls";

 $count_record = "";	
		
  $query8 = "SELECT COUNT(*) FROM pps_detail WHERE plan_no != ''" .$where_sql ." ORDER BY plan_no ASC ";
  $result8 = mysqli_query($dbc,$query8);
  $num_rows = mysqli_num_rows($result8);
  
  $query8a = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') as T, DATE_FORMAT(date_posting,'%d-%m-%Y') as R, DATE_FORMAT(date_posting,'%H:%m:%s') as R7 FROM pps_detail WHERE plan_no != ''" .$where_sql." ORDER BY plan_no ASC ";
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
$content .= "<font size='12px'><strong>DOCUMENT LIST - PLANNED ORDER STATUS</strong></font> ";
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
echo '<th width="5" bgcolor="#E9F58D">PLANNED ORDER NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">PLANNED DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">PLANNED QUANTITY</th>';
echo '<th width="5" bgcolor="#E9F58D">MATERIAL TYPE</th>';
echo '<th width="5" bgcolor="#E9F58D">MODEL</th>';
echo '<th width="5" bgcolor="#E9F58D">PART NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">BACK NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">KANBAN NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">PLANT</th>';
echo '<th width="5" bgcolor="#E9F58D">LINE</th>';
echo '<th width="5" bgcolor="#E9F58D">POSTING DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">POSTING TIME</th>';
echo '<th width="5" bgcolor="#E9F58D">REMARKS</th>';
echo '<th width="5" bgcolor="#E9F58D">STATUS</th>';
echo '</tr>';
echo '</table>';

 
//Display table
// query menampilkan semua data

  $query_sql3 =  "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') as T, DATE_FORMAT(date_posting,'%d-%m-%Y') as R, DATE_FORMAT(date_posting,'%H:%m:%s') as R7 FROM pps_detail WHERE plan_no != ''" .$where_sql." ORDER BY plan_no ASC ";
  $result_sql3 = mysqli_query($dbc,$query_sql3);   //run the query.
 
//count how many data
   $counter = 1;
   $no = 1;
   $i = 1; 

   
 echo '<table border="1" width="100%">';
	 

   $counter = 1;
   $no2 = 1;
   $sta_out = "";
   
   while($row3 = mysqli_fetch_array($result_sql3))
   {
	   
	   //-----shift-----
	   
	   if($row3["shift_pps1"] == "D/S")
	   {
		   $shift_ds = "Day";
	   }elseif($row3["shift_pps2"] == "N/S")
	   {
		 $shift_ds = "Night";
	   }else{
		   
		   $shift_ds = "NA"; 
	   }
	   
	   
	       //----model ---
  
 $query_Mod = new PreparedSql("SELECT * FROM work_center_detail WHERE id_work = ? AND status_wc = 'Y' ORDER BY id ASC", [$row3["model_code"]]);
 $result_Mod = db_query($dbc, $query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  
 
  if($row_Mod["wc_desc2"] == "")
  {
	  $model_name = $row_Mod["id_work"];
  }else{
	  
	 $model_name = $row_Mod["wc_desc2"]; 
  }
	  
	  
	   //----line ---
  
 $query_Mod2 = new PreparedSql("SELECT * FROM work_center_detail WHERE id_work = ? AND status_wc = 'Y' ORDER BY id ASC", [$row3["work_center"]]);
 $result_Mod2 = db_query($dbc, $query_Mod2);
 $row_Mod2 = mysqli_fetch_array($result_Mod2);  
 
  if($row_Mod2["wc_desc2"] == "")
  {
	  $model_name2 = $row_Mod2["id_work"];
  }else{
	  
	 $model_name2 = $row_Mod2["wc_desc2"]; 
  }
	  
	   
	   
	   
	   
	     //---------bflush OK-----------
	   
	   $query_bfOK3 = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as RR, DATE_FORMAT(time_posting,'%H:%m:%s') as RR7 FROM pps_detail_trn_fg_ok WHERE plan_no = '".sql_esc($row3["plan_no"])."' AND ref_id = '".sql_esc($row3["ref_id"])."' AND status_pps != '".sql_esc($rst_sta6["status_desc"])."'";
	   $result_bfOK3 = mysqli_query($dbc,$query_bfOK3);
      // $data_bfOK3 = mysqli_fetch_array($result_bfOK3);
	   
	   $query_bfOK3A = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as RR, DATE_FORMAT(time_posting,'%H:%m:%s') as RR7 FROM pps_detail_trn_fg_ok WHERE plan_no = '".sql_esc($row3["plan_no"])."' AND ref_id = '".sql_esc($row3["ref_id"])."' AND status_pps != '".sql_esc($rst_sta6["status_desc"])."'";
	   $result_bfOK3A = mysqli_query($dbc,$query_bfOK3A);
      // $data_bfOK3A = mysqli_fetch_array($result_bfOK3A);
	   
	    //---------bflush NG-----------
	   
	   $query_bfNG3 = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as RR, DATE_FORMAT(time_posting,'%H:%m:%s') as RR7 FROM pps_detail_trn_fg_ng WHERE plan_no = '".sql_esc($row3["plan_no"])."' AND ref_id = '".sql_esc($row3["ref_id"])."' AND status_pps != '".sql_esc($rst_sta6["status_desc"])."'";
	   $result_bfNG3 = mysqli_query($dbc,$query_bfNG3);
       //$data_bfNG3 = mysqli_fetch_array($result_bfNG3);
	   
	   $query_bfNG3A = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as RR, DATE_FORMAT(time_posting,'%H:%m:%s') as RR7 FROM pps_detail_trn_fg_ng WHERE plan_no = '".sql_esc($row3["plan_no"])."' AND ref_id = '".sql_esc($row3["ref_id"])."' AND status_pps != '".sql_esc($rst_sta6["status_desc"])."'";
	   $result_bfNG3A = mysqli_query($dbc,$query_bfNG3A);
       //$data_bfNG3A = mysqli_fetch_array($result_bfNG3A);
	   
	   //---------bflush PENDING-----------
	   
	   $query_bfPEND3 = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as RR, DATE_FORMAT(time_posting,'%H:%m:%s') as RR7 FROM pps_detail_trn_fg_pending WHERE plan_no = '".sql_esc($row3["plan_no"])."' AND ref_id = '".sql_esc($row3["ref_id"])."' AND status_pps != '".sql_esc($rst_sta6["status_desc"])."'";
	   $result_bfPEND3 = mysqli_query($dbc,$query_bfPEND3);
      // $data_bfPEND3 = mysqli_fetch_array($result_bfPEND3);
	  
	   $query_bfPEND3A = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as RR, DATE_FORMAT(time_posting,'%H:%m:%s') as RR7 FROM pps_detail_trn_fg_pending WHERE plan_no = '".sql_esc($row3["plan_no"])."' AND ref_id = '".sql_esc($row3["ref_id"])."' AND status_pps != '".sql_esc($rst_sta6["status_desc"])."'";
	   $result_bfPEND3A = mysqli_query($dbc,$query_bfPEND3A);
      // $data_bfPEND3A = mysqli_fetch_array($result_bfPEND3A);
	   
   
    //---------bflush HANDWORK-----------
	   
	   $query_bfHWORK3 = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as RR, DATE_FORMAT(time_posting,'%H:%m:%s') as RR7 FROM pps_detail_trn_fg_hwork WHERE plan_no = '".sql_esc($row3["plan_no"])."' AND ref_id = '".sql_esc($row3["ref_id"])."' AND status_pps != '".sql_esc($rst_sta6["status_desc"])."'";
	   $result_bfHWORK3 = mysqli_query($dbc,$query_bfHWORK3);
     //  $data_bfHWORK3 = mysqli_fetch_array($result_bfHWORK3);
	 
	   $query_bfHWORK3A = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as RR, DATE_FORMAT(time_posting,'%H:%m:%s') as RR7 FROM pps_detail_trn_fg_hwork WHERE plan_no = '".sql_esc($row3["plan_no"])."' AND ref_id = '".sql_esc($row3["ref_id"])."' AND status_pps != '".sql_esc($rst_sta6["status_desc"])."'";
	   $result_bfHWORK3A = mysqli_query($dbc,$query_bfHWORK3A);
     //  $data_bfHWORK3A = mysqli_fetch_array($result_bfHWORK3A);
	 
	
				
				?>

                <tr>
                <td width="30">&nbsp;<?php echo $no2; ?></td>
                <td width="150">&nbsp;<?php echo $row3["plan_no"]; ?></td> 
                <td width="100">&nbsp;<?php echo $row3["T"]; ?></td>  
                <td width="100"><?php echo intval($row3["qty_plan"]); ?></td>
                <td width="80">&nbsp;<?php echo $row3["material_type"]; ?></td>
                <td width="80">&nbsp;<?php echo $model_name; ?></td>
                <td width="200"><?php echo $row3["material_no"]; ?></td>
                <td width="200">&nbsp;<?php echo $row3["back_no"]; ?></td>
                <td width="200">&nbsp;<?php echo $row3["kanban_no"]; ?></td>
                <td width="80">&nbsp;<?php echo $row3["plant_code"]; ?></td>
                <td width="80">&nbsp;<?php echo $model_name2; ?></td> 
                <td width="150">
                <?php
                
                 while($data_bfOK3 = mysqli_fetch_array($result_bfOK3))
				{
				 if($data_bfOK3 > 0 ){ echo $data_bfOK3["RR"]; echo "<br>"; }
				 
				} // end while bfOK
				 
				 while($data_bfNG3 = mysqli_fetch_array($result_bfNG3))
				 {
				 if($data_bfNG3 > 0 ){ echo $data_bfNG3["RR"]; echo "<br>"; }
				 } // end while bfNG
				 
				 while($data_bfPEND3 = mysqli_fetch_array($result_bfPEND3))
				 {
				 if($data_bfPEND3 > 0 ){ echo $data_bfPEND3["RR"]; echo "<br>"; }
				 } // end while bfPEND
				 
				 while($data_bfHWORK3 = mysqli_fetch_array($result_bfHWORK3))
				 {
				 if($data_bfHWORK3 > 0 ){ echo $data_bfHWORK["RR"]; echo "<br>";  }
				 } // end while bfHWORK
				 
				 
				?> </td>
                <td width="150"><?php 
				while($data_bfOK3A = mysqli_fetch_array($result_bfOK3A))
				{
				 if($data_bfOK3A > 0 ){ echo $data_bfOK3A["time_posting"]; echo "<br>"; } 
				} // end while bfOK
				
				 while($data_bfNG3A = mysqli_fetch_array($result_bfNG3A))
				 { 
				 if($data_bfNG3A > 0 ){ echo $data_bfNG3A["time_posting"];  echo "<br>"; }
				 } // end while bfNG
				 
				 while($data_bfPEND3A = mysqli_fetch_array($result_bfPEND3A))
				 {
				 if($data_bfPEND3A > 0 ){ echo $data_bfPEND3A["time_posting"]; echo "<br>"; }
				 } // end while bfPEND
				 
				 while($data_bfHWORK3A = mysqli_fetch_array($result_bfHWORK3A))
				 {
				 if($data_bfHWORK3A > 0 ){ echo $data_bfHWORK3A["time_posting"]; echo "<br>"; }
				 } // end while bfHWORK
				
                ?>
                
                
                
                </td>
                <td width="100">&nbsp;<?php echo $row3["remark_closed_plan"]; ?></td>
                <td width="100">&nbsp;<?php echo $row3["status_pps"]; ?></td>
                </tr>
             
                 
          <?php 
			 
			  
		
			
		  $no2++;
		  $counter++; // menambah counter
		  } 
		  
	
    
  mysqli_free_result($result_sql3);   
   
  ?></tbody></table> 
 
<?php

echo iconv('utf-8', 'cp1251', "$data"); 
?>
</body>
</html>


