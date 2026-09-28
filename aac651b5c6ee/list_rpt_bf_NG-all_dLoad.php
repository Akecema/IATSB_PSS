<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

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

//CR status (Return GRA)
$sta26 = "SELECT * from request_status WHERE status_id = '26'";
$sta_res26 = mysqli_query($dbc,$sta26);
$rst_sta26 = mysqli_fetch_array($sta_res26);

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);


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
        	$trans_opt = $_GET["trans_opt"]; 
			$plant_code = $_GET["plant_code"]; 
			$work_center = $_GET["work_center"];
			$material_no = $_GET["material_no"]; 
			
			
			
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
                    $wheresql_01 = " AND plant_code = '".sql_esc($plant_code)."'"; }  	
					
		   // 2. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (date_posting >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //3. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
					$wheresql_03 = " AND (date_posting <= '".sql_esc($date2_final)."')"; }
					
					
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
		
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;
						
	
	//********** END CONDITION **************
 

$namaFile = "Backflush_NG_".$date_tdy.".xls";

 $count_record = "";	
		
  $query8 = "SELECT COUNT(*) FROM pps_detail_trn_fg_ng WHERE status_pps != '".sql_esc($rst_sta6["status_desc"])."' AND status = 'Y'" .$where_sql ." ORDER BY bflush_no ASC ";
  $result8 = mysqli_query($dbc,$query8) or die(mysqli_error($dbc));
  $num_rows = mysqli_num_rows($result8);
  
  $query8a = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') as T, DATE_FORMAT(date_posting,'%d-%m-%Y') as R, DATE_FORMAT(date_cancel,'%d-%m-%Y') as T7 FROM pps_detail_trn_fg_ng WHERE status_pps != '".sql_esc($rst_sta6["status_desc"])."' AND status = 'Y'" .$where_sql." ORDER BY bflush_no ASC ";
  $result8a = mysqli_query($dbc,$query8a) or die(mysqli_error($dbc));
  $num_rows_8a = mysqli_num_rows($result8a);

//---------------------------end count
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
$content .= "<font size='12px'><strong>DOCUMENT LIST - BACKFLUSH NG</strong></font> ";
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
echo '<th width="5" bgcolor="#E9F58D">POSTING DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">POSTING TIME</th>';
echo '<th width="5" bgcolor="#E9F58D">GR DOC. NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">PLANT</th>';
echo '<th width="5" bgcolor="#E9F58D">LINE</th>';
echo '<th width="5" bgcolor="#E9F58D">SHIFT</th>';
echo '<th width="5" bgcolor="#E9F58D">LOCATION</th>';
echo '<th width="5" bgcolor="#E9F58D">QUANTITY</th>';
echo '<th width="5" bgcolor="#E9F58D">OUTPUT STATUS</th>';
echo '<th width="5" bgcolor="#E9F58D">CANCELLATION DOC. NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">CANCELLATION DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">DISPOSAL DOC. NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">APPROVED DISPOSAL DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">CANCELLED BY</th>';
echo '</tr>';
echo '</table>';

 
//Display table
// query menampilkan semua data
  $query_sql3 = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') as T, DATE_FORMAT(date_posting,'%d-%m-%Y') as R, DATE_FORMAT(date_cancel,'%d-%m-%Y') as T7 FROM pps_detail_trn_fg_ng WHERE status_pps != '".sql_esc($rst_sta6["status_desc"])."' AND status = 'Y'" .$where_sql." ORDER BY bflush_no ASC ";
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
	   
	   if($data_sql3["shift_posting"] == "D/S")
	   {
		   $shift_ds = "Day";
	   }elseif($data_sql3["shift_posting"] == "N/S")
	   {
		 $shift_ds = "Night";
	   }else{
		   
		   $shift_ds = "NA"; 
	   }
	   
	    //-----user canccellation-----------
		 
		 $query_u_can = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_sql3["user_cancel"])."'"; 
		 $rs_u_can = mysqli_query($dbc,$query_u_can);   //run the query.
		 $data_u_can = mysqli_fetch_array($rs_u_can);
	 
	   
	    //---- get disposal detail ------
		 $query_dis_scan = "SELECT *, DATE_FORMAT(date_disposal,'%d-%m-%Y') as K, DATE_FORMAT(date_approved4,'%d-%m-%Y') as K7 FROM disposal_detail_prd_ng WHERE plan_no = '".sql_esc($data_sql3["plan_no"])."' AND bflush_qqc_no = '".sql_esc($data_sql3["bflush_no"])."'";
	     $result_dis_scan =  mysqli_query($dbc,$query_dis_scan); 
		 $row_dis_scan = mysqli_fetch_array($result_dis_scan);	 
	   
	 
       //-----get data GR detail -------
	   
	   $query_gr_scan = "SELECT * FROM  scan_gr_trn_fg_ng WHERE bflush_no_ng = '".sql_esc($data_sql3["bflush_no"])."'";
	   $result_gr_scan =  mysqli_query($dbc,$query_gr_scan); 
	   
	    
	 
		echo '<tr height="35">';
		echo '<td>'. $no2.'</td>'; 
		echo '<td>&nbsp;'. $data_sql3["model_code"].'</td>';  
		echo '<td>'. $data_sql3["material_no"].'</td>'; 	
		echo '<td>&nbsp;'. $data_sql3["material_desc"].'</td>'; 
		echo '<td>&nbsp;'. $data_sql3["plan_no"].'</td>'; 
		echo '<td>&nbsp;'. $data_sql3["T"].'</td>'; 	
		echo '<td>&nbsp;'. $data_sql3["bflush_no"].'</td>';  	
		echo '<td>&nbsp;'. $data_sql3["R"].'</td>'; 	
		echo '<td>&nbsp;'. $data_sql3["time_posting"].'</td>'; 	
		echo '<td>&nbsp;';
	 	 while ($row_gr_scan = mysqli_fetch_array($result_gr_scan))	 
		 {
		echo $row_gr_scan["doc_gra"]; echo "<br>&nbsp;";
		 }
		echo '</td>'; 	
		echo '<td>&nbsp;'. $data_sql3["plant_code"].'</td>';
		echo '<td>&nbsp;'. $data_sql3["work_center"].'</td>';  
		echo '<td>&nbsp;'. strtoupper($shift_ds).'</td>';
		echo '<td>&nbsp;'. $data_sql3["ploc"].'</td>';	
		echo '<td align="right">'. intval($data_sql3["qty_NG"]).'</td>';  
	 	echo '<td>&nbsp;'. $data_sql3["status_pps"].'</td>';
		echo '<td>&nbsp;'. $data_sql3["bflush_no_ref"].'</font></td>';
	 if($data_sql3["date_cancel"] != "0000-00-00 00:00:00") {	echo '<td>&nbsp;'. $data_sql3["T7"].'</td>'; }else { echo '<td>&nbsp;</td>'; }
	    echo '<td>&nbsp;'. $row_dis_scan["doc_dis"].'</td>';
	  if($row_dis_scan["date_approved4"] != "0000-00-00 00:00:00") { echo '<td>&nbsp;'. $row_dis_scan["K7"].'</td>'; }else { echo '<td>&nbsp;</td>'; }
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


