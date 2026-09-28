<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "4")) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

//CR status (Cancelled)
$sta4 = "SELECT * from request_status WHERE status_id = '4'";
$sta_res4 = mysqli_query($dbc,$sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);
			 
//CR status (Transfer Posting)
$sta19 = "SELECT * from request_status WHERE status_id = '19'";
$sta_res19 = mysqli_query($dbc,$sta19);
$rst_sta19 = mysqli_fetch_array($sta_res19);

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);

//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc,$sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);

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
       		$plant_code = $_GET["plant_code"];

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
					
		   // 3. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND (posting_date >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (posting_date <= '".sql_esc($date2_final)."')"; }
							

				$where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04;
	
	//********** END CONDITION **************

 

$namaFile = "Document_List_Disposal".$date_tdy.".xls";

 $count_record = "";	
		
  $query8 = "SELECT * FROM gra_disposal_qc_detail WHERE status_tran = 'Y' AND status_dis != '".sql_esc($rst_sta13["status_desc"])."'".$where_sql."GROUP BY doc_dis";
  $result8 = mysqli_query($dbc,$query8) or die(mysqli_error());
  $num_rows = mysqli_num_rows($result8);

  $query8a = "SELECT * FROM gra_disposal_qc_detail_cancel WHERE status_tran = 'Y' ".$where_sql."GROUP BY doc_dis";
  $result8a = mysqli_query($dbc,$query8a) or die(mysqli_error());
  $num_rows_8a = mysqli_num_rows($result8a);

//---------------------------end count
 
  //$count_record =  ($num_rows + $num_rows_8a);

    $count_record =  ($num_rows);

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
//echo '<th width="5" bgcolor="#E9F58D">NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">PLANT</th>';
echo '<th width="5" bgcolor="#E9F58D">PART NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">PART NAME</th>';
echo '<th width="5" bgcolor="#E9F58D">MODEL</th>';
echo '<th width="5" bgcolor="#E9F58D">QUANTITY</th>';
echo '<th width="5" bgcolor="#E9F58D">UOM</th>';
echo '<th width="5" bgcolor="#E9F58D">SECTION/LINE</th>';
echo '<th width="5" bgcolor="#E9F58D">STORAGE LOCATION</th>';
echo '<th width="5" bgcolor="#E9F58D">PROCESS OF REJECT</th>';
echo '<th width="5" bgcolor="#E9F58D">TYPE OF REJECT</th>';
echo '<th width="5" bgcolor="#E9F58D">DEFECTION OF REJECT</th>';
echo '<th width="5" bgcolor="#E9F58D">REASONS</th>';
echo '<th width="5" bgcolor="#E9F58D">REMARK</th>';
echo '<th width="5" bgcolor="#E9F58D">POSTING DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">SHIFT</th>';
echo '<th width="5" bgcolor="#E9F58D">DOCUMENT NO.</th>';
echo '</tr>';
echo '</table>';

 
//Display table
// query menampilkan semua data

$query_sql2A = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as R2 FROM gra_disposal_qc_detail WHERE status_tran = 'Y' ".$where_sql. "GROUP BY doc_dis ORDER BY posting_date DESC";
$result_sql2A = mysqli_query($dbc,$query_sql2A);   //run the query.

//count how many data
   $counter = 1;
   $no = 1;
   $i = 1;

   
 echo '<table border="1" width="100%">';
  while ($data_sql2A = mysqli_fetch_array($result_sql2A))
   {
	 
	 
	 $query_sql3A = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as R3 FROM gra_disposal_qc_detail WHERE status_tran = 'Y' AND doc_dis = '".sql_esc($data_sql2A["doc_dis"])."' ORDER BY doc_dis ASC";
     $result_sql3A = mysqli_query($dbc,$query_sql3A);   //run the query.
	 
   $no2 = 1;
	   while ($data_sql3A = mysqli_fetch_array($result_sql3A))
   {
	 
	 if($data_sql3A["shift_day"] == "D/S")
	 {
		 $shift_desc = "Day";
		 
	 }else{
		 $shift_desc = "Night";
		 
	 }
	 
	   //-----get proc detail----
	   
	   $query_sectA = "SELECT * FROM proc_reject_detail_qqc WHERE id_proc = '".sql_esc($data_sql3A["proc_reject"])."'";
	   $rst_sectA = mysqli_query($dbc,$query_sectA);
       $data_sectA = mysqli_fetch_array($rst_sectA);
	   
	   //----get type of reject -----
  
       $query_type = "SELECT * FROM type_reject_detail_qqc WHERE id_type = '".sql_esc($data_sql3A["type_reject"])."'";
	   $rst_type = mysqli_query($dbc,$query_type);
       $data_type = mysqli_fetch_array($rst_type);
  
  
  //----get reason of reject ------
       $query_reason = "SELECT * FROM type_defect_detail_qqc WHERE id_defect = '".sql_esc($data_sql3A["type_defect"])."'";
	   $rst_reason = mysqli_query($dbc,$query_reason);
       $data_reason = mysqli_fetch_array($rst_reason);
	 
	 
		echo '<tr height="35">';
		//echo '<td>'. $no.'</td>';  
		echo '<td>&nbsp;'. $data_sql3A["plant_code"].'</td>'; 
		echo '<td>&nbsp;'. $data_sql3A["material_no"].'</td>'; 	
		echo '<td>&nbsp;'. $data_sql3A["material_desc"].'</td>'; 
		echo '<td>&nbsp;'. $data_sql3A["model_code"].'</td>';  
		echo '<td align="right">&nbsp;'. intval($data_sql3A["qty_dis"]).'</td>';  
	 	echo '<td>&nbsp;'. strtoupper($data_sql3A["uom_dis"]).'</td>';  
		echo '<td>&nbsp;'. $data_sql3A["work_center"].'</td>';
		echo '<td>&nbsp;'. $data_sql3A["sloc_rej"].'</td>';
		echo '<td>&nbsp;'. $data_sectA["proc_desc"].'</td>'; 	
		echo '<td>&nbsp;'. $data_type["type_desc"].'</td>'; 
		echo '<td>&nbsp;'. $data_reason["defect_desc"].'</td>';  
		echo '<td>&nbsp;'. $data_reason["id_reason"].'</td>';  
		echo '<td>&nbsp;'. $data_sql3A["remark_dis"].'</td>'; 	
		echo '<td>&nbsp;'. $data_sql3A["R3"].'</td>';
	    echo '<td>&nbsp;'. strtoupper($shift_desc).'</td>';  
        echo '<td>&nbsp;'. $data_sql3A["doc_dis"].'</td>';
        echo '</tr>'; 
		
		//---- record cancellation ------ //
		$query_cancel_dis = "SELECT *, DATE_FORMAT(date_cancel,'%d-%m-%Y') as R4 FROM gra_disposal_qc_detail_cancel WHERE doc_dis = '".sql_esc($data_sql3A["doc_dis"])."' AND status_dis = '".sql_esc($rst_sta4["status_desc"])."'";
		$result_cancel_dis = mysqli_query($dbc,$query_cancel_dis);
	    $row_cancel_dis = mysqli_fetch_array($result_cancel_dis);
		
		
     if(($data_sql3A["id_dis"]) == ($row_cancel_dis["id_dis"]))  
	  {
			
	    echo '<tr height="35">';
		//echo '<td><font color="#FF0000">'. $no.'</font></td>'; 
		echo '<td>&nbsp;'. $row_cancel_dis["plant_code"].'</td>';	
		echo '<td>&nbsp;'. $row_cancel_dis["material_no"].'</td>'; 	
		echo '<td>&nbsp;'. $row_cancel_dis["material_desc"].'</td>';  
		echo '<td>&nbsp;'. $row_cancel_dis["model_code"].'</td>';  
		echo '<td align="right">&nbsp;<font color="#FF0000">'. intval(-($row_cancel_dis["qty_dis"])).'</font></td>';  
	 	echo '<td>&nbsp;'. strtoupper($row_cancel_dis["uom_dis"]).'</td>';
		echo '<td>&nbsp;'. $data_sql3A["work_center"].'</td>';
		echo '<td>&nbsp;'. $data_sql3A["sloc_rej"].'</td>';	
		echo '<td>&nbsp;'. $data_sectA["proc_desc"].'</td>'; 	
		echo '<td>&nbsp;'. $data_type["type_desc"].'</td>'; 
		echo '<td>&nbsp;'. $data_reason["defect_desc"].'</td>';  
		echo '<td>&nbsp;'. $data_reason["id_reason"].'</td>';  
		echo '<td>&nbsp;'. $row_cancel_dis["remark_dis"].'</td>'; 	   
		echo '<td>&nbsp;'. $row_cancel_dis["R4"].'</td>';
		echo '<td>&nbsp;'. strtoupper($shift_desc).'</td>';  
        echo '<td>&nbsp;<font color="#FF0000">'. $row_cancel_dis["ref_doc_dis"].'</font></td>';
	
	  }else{
		 
	    echo '</tr>'; 
	   
	  }
  ?><?php $no++;
   }
    
    
  mysqli_free_result($result_sql3A);   
 }  
  ?></tbody></table> 
 
<?php

echo iconv('utf-8', 'cp1251', "$data"); 
?>
</body>
</html>


