<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
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

//CR status (Cancelled)
$sta4 = "SELECT * from request_status WHERE status_id = '4'";
$sta_res4 = mysqli_query($dbc,$sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);
			 
//CR status (Transfer Posting)
$sta19 = "SELECT * from request_status WHERE status_id = '19'";
$sta_res19 = mysqli_query($dbc,$sta19);
$rst_sta19 = mysqli_fetch_array($sta_res19);

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
		    $vendor_code = $_GET["vendor_code"];
		
	      	
			  //-------Count all results------------------------//
			
				 $where_sql = '';
				 
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);
				 		
		 // 1. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND (posting_date >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //2. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
					$wheresql_02 = " AND (posting_date <= '".sql_esc($date2_final)."')"; }
					
						
	       //3. Vendor Code
                if (($vendor_code == "") || ($vendor_code == "NULL")){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND vendor_no = '".sql_esc($vendor_code)."'"; }  	
					
	                              
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03;	
	
	//********** END CONDITION **************

 

$namaFile = "Document_List_TPSubcont_".$date_tdy.".xls";

 $count_record = "";	
		
  $query8 = "SELECT * FROM tp_subcont_detail WHERE status_tran = 'Y' ".$where_sql;
  $result8 = mysqli_query($dbc,$query8) or die(mysqli_error());
  $num_rows = mysqli_num_rows($result8);

  $query8a = "SELECT * FROM tp_subcont_detail_canc WHERE status_tran = 'Y' ".$where_sql;
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
$content .= "<font size='12px'><strong>DOCUMENT LIST - TRANSFER TO SUBCONT</strong></font> ";
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
echo '<th width="5" bgcolor="#E9F58D">VENDOR CODE</th>';
echo '<th width="5" bgcolor="#E9F58D">VENDOR NAME</th>';
echo '<th width="5" bgcolor="#E9F58D">SHIFT</th>';
echo '<th width="5" bgcolor="#E9F58D">POSTING DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">DOCUMENT NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">PART NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">PART NAME</th>';
echo '<th width="5" bgcolor="#E9F58D">MODEL</th>';
echo '<th width="5" bgcolor="#E9F58D">QUANTITY</th>';
echo '<th width="5" bgcolor="#E9F58D">UOM</th>';
echo '</tr>';
echo '</table>';

 
//Display table
// query menampilkan semua data

$query_sql2 = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as R2 FROM tp_subcont_detail WHERE status_tran = 'Y' ".$where_sql. "ORDER BY posting_date DESC";
$result_sql2 = mysqli_query($dbc,$query_sql2);   //run the query.

//count how many data
   $counter = 1;
   $no = 1;
   $i = 1;

   
 echo '<table border="1" width="100%">';
  while ($data_sql2 = mysqli_fetch_array($result_sql2))
   {
	 
	    $no2 = 1;
		
	 $query_sql3 = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as R3 FROM tp_subcont_detail WHERE status_tran = 'Y' AND doc_tp = '".sql_esc($data_sql2["doc_tp"])."' AND id_tp = '".sql_esc($data_sql2["id_tp"])."' ORDER BY doc_tp ASC";
     $result_sql3 = mysqli_query($dbc,$query_sql3);   //run the query.
	 

	   while ($data_sql3 = mysqli_fetch_array($result_sql3))
   {
	 
	 if($data_sql3["shift_day"] == "D/S")
	 {
		 $shift_desc = "Day";
		 
	 }else{
		 $shift_desc = "Night";
		 
	 }
	 
	//------vendor detail --------
	 
	 $query_vend = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ?", [$data_sql3["vendor_no"]]);
	 $rs_vend = db_query($dbc, $query_vend);   //run the query.
     $data_vend = mysqli_fetch_array($rs_vend);
	 
	 
	 
	 
		echo '<tr height="35">';
		//echo '<td>'. $no.'</td>';  
		echo '<td>'. $data_sql3["vendor_no"].'</td>'; 
		echo '<td>&nbsp;'. $data_vend["vendor_name"].'</td>'; 
		echo '<td>&nbsp;'. strtoupper($shift_desc).'</td>'; 
		echo '<td>&nbsp;'. $data_sql3["R3"].'</td>'; 
		echo '<td>&nbsp;'. $data_sql3["doc_tp"].'</td>';	
	 	echo '<td>'. $data_sql3["material_no"].'</td>'; 	
		echo '<td>'. $data_sql3["material_desc"].'</td>';  
		echo '<td>&nbsp;'. $data_sql3["model_code"].'</td>';  
	 	echo '<td align="right">'. intval($data_sql3["qty_tp"]).'</td>';  
	 	echo '<td>&nbsp;'. strtoupper($data_sql3["uom_tp"]).'</td>';  
        echo '</tr>'; 
		
		//---- record cancellation ------ //
		$query_cancel_plb = "SELECT *, DATE_FORMAT(date_cancel,'%d-%m-%Y') as R4 FROM tp_subcont_detail_canc WHERE id_tp = '".sql_esc($data_sql3["id_tp"])."' AND status_tp = '".sql_esc($rst_sta4["status_desc"])."'";
		$result_cancel_plb = mysqli_query($dbc,$query_cancel_plb);
	    $row_cancel = mysqli_fetch_array($result_cancel_plb);
		
		
     if(($data_sql3["id_tp"]) == ($row_cancel["id_tp"]))  
	  {
		  
	    echo '<tr height="35">';
		//echo '<td>'. $no.'</td>';  
		echo '<td>'. $row_cancel["vendor_no"].'</td>'; 
		echo '<td>&nbsp;'. $data_vend["vendor_name"].'</td>'; 
		echo '<td>&nbsp;'. strtoupper($shift_desc).'</td>'; 
		echo '<td>&nbsp;'. $row_cancel["R3"].'</td>'; 
		echo '<td><font color="#FF0000">'. $row_cancel["ref_doc_tp"].'</font></td>';	
	 	echo '<td>'. $row_cancel["material_no"].'</td>'; 	
		echo '<td>'. $row_cancel["material_desc"].'</td>';  
		echo '<td>&nbsp;'. $row_cancel["model_code"].'</td>';  
	 	echo '<td align="right"><font color="#FF0000">'. intval(-($row_cancel["qty_tp"])).'</font></td>';  
	 	echo '<td>&nbsp;'. strtoupper($row_cancel["uom_tp"]).'</td>';  
        echo '</tr>'; 
		  
		
       }else{
		 
	    echo '</tr>'; 
	   
	  }
  ?><?php $no++;
   }
    
    
  mysqli_free_result($result_sql3);   
 }  
  ?></tbody></table> 
 
<?php

echo iconv('utf-8', 'cp1251', "$data"); 
?>
</body>
</html>


