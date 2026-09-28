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

//CR status (Return)
$sta30 = "SELECT * from request_status WHERE status_id = '30'";
$sta_res30 = mysqli_query($dbc,$sta30);
$rst_sta30 = mysqli_fetch_array($sta_res30);

//CR status (Return Delivery)
$sta31 = "SELECT * from request_status WHERE status_id = '31'";
$sta_res31 = mysqli_query($dbc,$sta31);
$rst_sta31 = mysqli_fetch_array($sta_res31);


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
        	$ship_to = $_GET["ship_to"]; 
			$do_no = $_GET["do_no"]; 
		    $trans_type = $_GET["trans_type"]; 
		    $material_no = $_GET["material_no"]; 
			$model_code = $_GET["model_code"]; 
			
			
			      //-------Count all results------------------------//
			
				 $where_sql = '';
				 
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 $ddF2 = substr($_GET["date2"],0,2);
				 $mmF2 = substr($_GET["date2"],3,2);
				 $yyF2 = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyF2.'-'.$mmF2.'-'.$ddF2);
			
								
	       //1. do_no
                if ($do_no == ""){ 
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND material_doc_gen = '".sql_esc($do_no)."'"; }  
					
		   //2. ship to party
                if (($ship_to == "") || ($ship_to == "NULL")){ 
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND vendor_name = '".sql_esc($ship_to)."'"; }  	
						
					
		   // 3. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND (dlv_date >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (dlv_date <= '".sql_esc($date2_final)."')"; }
					
		//5. Material No
                if ($material_no == "NULL" ){
                    $wheresql_05 = ""; }
                else {
					$wheresql_05 = " AND (material_no = '".sql_esc($material_no)."')"; }
					
					
		  //6. model_code
                if ($model_code == "NULL" ){
                    $wheresql_06 = ""; }
                else {
					$wheresql_06 = " AND (matl_group >= '".sql_esc($model_code)."')"; }
					
				
		   //8. Transfer Type
                if (($trans_type == "NORMAL") || ($trans_type == "NULL" )){
                    $wheresql_08 = ""; 
				}elseif($trans_type == "CANCEL" ){
					$wheresql_08 = " AND (status_DO = '".sql_esc($rst_sta3['status_desc'])."')"; 
					
				}else{
				}
				
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05 .$wheresql_06 .$wheresql_08;
	
	//********** END CONDITION **************
	
 

$namaFile = "Delivery Order ".$date_tdy.".xls";

 $count_record = "";	
		
  $query8 = "SELECT * FROM dlv_ord_all_delivery WHERE material_doc_gen != '' AND status_DO != '".sql_esc($rst_sta31["status_desc"])."'" .$where_sql ." ORDER BY material_doc_gen ASC ";
  $result8 = mysqli_query($dbc,$query8) or die(mysqli_error());
  $num_rows = mysqli_num_rows($result8);
  
  $query8a = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as R, DATE_FORMAT(dlv_date,'%d-%m-%Y') as R7 FROM dlv_ord_all_delivery_canc WHERE material_doc_gen != '' " .$where_sql." ORDER BY material_doc_gen ASC ";
  $result8a = mysqli_query($dbc,$query8a) or die(mysqli_error());
  $num_rows_8a = mysqli_num_rows($result8a);

//---------------------------end count
  $count_record =  ($num_rows + $num_rows_8a);

 // $count_record =  ($num_rows);

//header("Content-type: application/octet-stream"); 
header('Content-type: application/excel');                                  
header('Content-Disposition: attachment; filename='.$namaFile.'');
header("Pragma: no-cache");
header("Expires: 0");

$content = "";
$data = "";	

//Create report header 

$content .= "<p><font size='12px'><strong> ".strtoupper($data_setup["title_desc"])."</strong></font></p>";
$content .= "<font size='12px'><strong>DOCUMENT LIST - DELIVERY ORDER REPORT</strong></font> ";
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
echo '<th width="5" bgcolor="#E9F58D">SO NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">DO NUMBER</th>';
echo '<th width="5" bgcolor="#E9F58D">DELIVERY DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">PART NUMBER</th>';
echo '<th width="5" bgcolor="#E9F58D">PART NUMBER SAP</th>';
echo '<th width="5" bgcolor="#E9F58D">PART DESCRIPTION</th>';
echo '<th width="5" bgcolor="#E9F58D">DI/PDIO NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">MATERIAL TYPE</th>';
echo '<th width="5" bgcolor="#E9F58D">MODEL</th>';
echo '<th width="5" bgcolor="#E9F58D">DELIVERY QUANTITY</th>';
echo '<th width="5" bgcolor="#E9F58D">UOM</th>';
echo '<th width="5" bgcolor="#E9F58D">SOLD TO PARTY</th>';
echo '<th width="5" bgcolor="#E9F58D">SHIP TO PARTY</th>';
echo '<th width="5" bgcolor="#E9F58D">TRANSFER TYPE</th>';
echo '<th width="5" bgcolor="#E9F58D">TRANSFER DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">SHIFT</th>';
echo '<th width="5" bgcolor="#E9F58D">TRIP NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">TAG NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">DOC. STATUS</th>';
echo '<th width="5" bgcolor="#E9F58D">CANCELLATION DOC. NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">CANCELLATION DATE</th>';
echo '</tr>';
echo '</table>';

 
//Display table
// query menampilkan semua data
  $query_sql3 = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as R, DATE_FORMAT(dlv_date,'%d-%m-%Y') as R7 FROM dlv_ord_all_delivery WHERE material_doc_gen != '' AND status_DO != '".sql_esc($rst_sta4["status_desc"])."' AND status_DO != '".sql_esc($rst_sta31["status_desc"])."'" .$where_sql." ORDER BY material_doc_gen ASC ";
  $result_sql3 = mysqli_query($dbc,$query_sql3);   //run the query.
 
//count how many data
   $counter = 1;
   $no = 1;
   $i = 1;

   
 echo '<table border="1" width="100%">';
	 
   $no2 = 1;
	   while ($data_sql3 = mysqli_fetch_array($result_sql3))
   {
	  
	   if($data_sql3["doc_no_return"] != "")
		{
		
		$sta_atas = "Return";
		$trsf_sta = "Yes";
		
		}else{
			
	     $sta_atas = "Normal";	
		 $trsf_sta = "Yes";
			
		}
		
		
		///-------------table material iatsb for model --------
		$query_mat_info = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($data_sql3["material_no_sap"])."' AND status_BOM = 'Y'"; 
	 	$result_mat_info = mysqli_query($dbc,$query_mat_info);
        $data_mat_info = mysqli_fetch_array($result_mat_info);
		
		///-----== get model ----------------
		$query_mat_infoA = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($data_mat_info["model_code"])."' AND status_model = 'Y'"; 
	 	$result_mat_infoA = mysqli_query($dbc,$query_mat_infoA);
        $data_mat_infoA = mysqli_fetch_array($result_mat_infoA);
		
	 
		echo '<tr height="35">';
		echo '<td>'. $no2.'</td>';  
		echo '<td>&nbsp;'. $data_sql3["so_no"].'</td>'; 	
		echo '<td>&nbsp;'. $data_sql3["material_doc_gen"].'</td>'; 	
		echo '<td>&nbsp;'. $data_sql3["R7"].'</td>';
	 	echo '<td>'. $data_sql3["material_no"].'</td>'; 
		echo '<td>'. $data_sql3["material_no_sap"].'</td>'; 	
		echo '<td>'. $data_sql3["material_desc"].'</td>';  
		echo '<td>'. $data_sql3["pdio_no"].'</td>'; 
		echo '<td>'. $data_sql3["matl_group"].'</td>';  
		echo '<td>'. $data_mat_infoA["model_code"].'</td>';  
		echo '<td align="right">'. intval($data_sql3["qty_dlv"]).'</td>'; 
	 	echo '<td>'. strtoupper($data_sql3["unit_soi"]).'</td>'; 
		echo '<td>'. $data_sql3["vendor_name"].'</td>';
		echo '<td>'. $data_sql3["ship_point"].'</td>';    
		echo '<td>'. $data_sql3["status_DO"].'</td>';  
	 	echo '<td>&nbsp;'. $data_sql3["R"].'</td>';
		echo '<td>'. $data_sql3["cycle_no"].'</td>';  
		echo '<td>'. $data_sql3["trip_no"].'</td>';  
		echo '<td>'. $data_sql3["tag_no"].'</td>';  
		echo '<td>'. $sta_atas.'</td>';  
		echo '<td>&nbsp;'. $data_sql3["ref_material_doc"].'</td>';
		echo '<td>&nbsp;</td>';
        echo '</tr>'; 
		
	
  ?><?php $no2++;
   }
    
    
  mysqli_free_result($result_sql3);   
  
   $query_sql3A = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') as R, DATE_FORMAT(dlv_date,'%d-%m-%Y') as R7, DATE_FORMAT(date_cancel,'%d-%m-%Y') as R9 FROM dlv_ord_all_delivery_canc WHERE material_doc_gen != '' " .$where_sql." ORDER BY material_doc_gen ASC ";
   $result_sql3A = mysqli_query($dbc,$query_sql3A);   //run the query.
   
    echo '<table border="1" width="100%">';
	
	$no4 = "1"; 
  
	   while ($data_sql3A = mysqli_fetch_array($result_sql3A))
   { 
   
       if($data_sql3A["ref_material_doc"] != "")
		{
		
		$sta_bwh = "Cancel";
		$trsf_sta2 = "Yes";
		
		}else{
			
	     $sta_bwh = "";	
		 $trsf_sta2 = "No";
			
		}
  ?>
  <?php
        echo '<tr height="35">';
		echo '<td>'. $no4.'</td>';  
		echo '<td>&nbsp;'. $data_sql3A["so_no"].'</td>'; 	
		echo '<td>&nbsp;'. $data_sql3A["material_doc_gen"].'</td>'; 	
		echo '<td>&nbsp;'. $data_sql3A["R7"].'</td>';
	 	echo '<td>'. $data_sql3A["material_no"].'</td>'; 	
		echo '<td>'. $data_sql3A["material_desc"].'</td>'; 
	    echo '<td>'. $data_sql3A["pdio_no"].'</td>';  
		echo '<td>'. $data_sql3A["matl_group"].'</td>';  
		echo '<td align="right">'. intval($data_sql3A["qty_dlv"]).'</td>'; 
	 	echo '<td>'. strtoupper($data_sql3A["unit_soi"]).'</td>'; 
		echo '<td>'. $data_sql3A["vendor_name"].'</td>';
		echo '<td>'. $data_sql3A["ship_point"].'</td>';    
		echo '<td>'. $data_sql3A["status_DO"].'</td>';  
	 	echo '<td>&nbsp;'. $data_sql3A["R"].'</td>';
		echo '<td>'. $sta_bwh.'</td>';  
        echo '<td>&nbsp;'. $data_sql3A["ref_material_doc"].'</td>';
		echo '<td>&nbsp;'. $data_sql3A["R9"].'</td>';
        echo '</tr>'; 
  
  
  
  
  ?>
  
  <?php $no4++;
   }
   ?> 
  
  
  
  </tbody></table> 
 
<?php

echo iconv('utf-8', 'cp1251', "$data"); 
?>
</body>
</html>


