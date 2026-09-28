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

//CR status (Received)
$sta35 = "SELECT * from request_status WHERE status_id = '35'";
$sta_res35 = mysqli_query($dbc,$sta35);
$rst_sta35 = mysqli_fetch_array($sta_res35);

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
			$vendor_no = $_GET["vendor_no"]; 
			
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
					
		   // 3. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND (doc_date >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (doc_date <= '".sql_esc($date2_final)."')"; }
					
		  //5. Vendor Code
                if (($vendor_no == "") || ($vendor_no == "NULL")){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND vendor_id = '".sql_esc($vendor_no)."'"; }  		
								

				$where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04 .$wheresql_05;
	
	//********** END CONDITION **************
 

$namaFile = "PO vs GR (Quantity) ".$date_tdy.".xls";

 $count_record = "";	



  $query8 = "SELECT * FROM po_detail WHERE (status_po = '".sql_esc($rst_sta["status_desc"])."' OR status_po = '".sql_esc($rst_sta7["status_desc"])."' OR status_po != '".sql_esc($rst_sta4["status_desc"])."' ) " .$where_sql." GROUP BY material_no, purc_ord_no ORDER BY purc_ord_no ASC ";
  $result8 = mysqli_query($dbc,$query8) or die(mysqli_error($dbc));
  $num_rows = mysqli_num_rows($result8);
 
//---------------------------end count

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
$content .= "<font size='12px'><strong>DOCUMENT LIST - PO vs GR (QUANTITY) </strong></font> ";
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
echo '<th width="5" bgcolor="#E9F58D">PLANT</th>';
echo '<th width="5" bgcolor="#E9F58D">PURCHASE ORDER NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">VENDOR CODE</th>';
echo '<th width="5" bgcolor="#E9F58D">VENDOR NAME</th>';
echo '<th width="5" bgcolor="#E9F58D">PART NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">PART NAME</th>';
echo '<th width="5" bgcolor="#E9F58D">MODEL</th>';
echo '<th width="5" bgcolor="#E9F58D">PO QUANTITY</th>';
echo '<th width="5" bgcolor="#E9F58D">GR QUANTITY</th>';
echo '<th width="5" bgcolor="#E9F58D">BALANCE</th>';
echo '<th width="5" bgcolor="#E9F58D">UOM</th>';
echo '</tr>';
echo '</table>';

 
//Display table
// query menampilkan semua data
  $query_sql3 = "SELECT *, DATE_FORMAT(doc_date,'%d-%m-%Y') as R3 FROM po_detail WHERE (status_po = '".sql_esc($rst_sta["status_desc"])."' OR status_po = '".sql_esc($rst_sta7["status_desc"])."' OR status_po != '".sql_esc($rst_sta4["status_desc"])."' ) " .$where_sql."  GROUP BY material_no, purc_ord_no ORDER BY doc_gen ASC ";
  $result_sql3 = mysqli_query($dbc,$query_sql3);   //run the query.
 
//count how many data
   $counter = 1;
   $no = 1;
   $i = 1;

   
 echo '<table border="1" width="100%">';
	 
   $no2 = 1;
	   while ($data_sql3 = mysqli_fetch_array($result_sql3))
   {
	 //----shift day----
	 /* if($data_sql3["shift_gr"] == "D/S")
	 {
		 $shift_desc = "Day";
		 
	 }else{
		 $shift_desc = "Night";
		 
	 } */
	 
	 //---- Status -----
	 
	 /* if($data_sql3["status_gr"] == ($rst_sta3["status_desc"]))
	 {
		$status_br = $rst_sta35["status_desc"]; 
		 
	 }elseif($data_sql3["status_gr"] == ($rst_sta4["status_desc"]))
	 {
		$status_br = $rst_sta4["status_desc"]; 
		 
	 }else{
		 
		$status_br = ""; 
		 
	 } */


     //--------- Checking delivery order whether it has been fully received or not.-----------	 
 $tot_gr_qtyB = 0.000;
 $tot_rec_qtyA = 0.000;
 $tot_grd_qtyA  = 0.000;	
 $Grd_total_new_bal = 0.000;
 $tot_gr_qtyC = 0.000;
 
 
 $query_check_Trcv = "SELECT * FROM dlv_ord_dikanban_generate WHERE po_no = '".sql_esc($data_sql3['purc_ord_no'])."' AND  status_DO = '".sql_esc($rst_sta14["status_desc"])."' AND material_no = '".sql_esc($data_sql3["material_no"])."'";
 $result_check_Trcv = mysqli_query($dbc,$query_check_Trcv);
   
 while($data_check_Trcv = mysqli_fetch_array($result_check_Trcv))
 {
 
 
 $tot_grd_qtyA = $tot_grd_qtyA + $data_check_Trcv["qty_dlv"];
 
 }
 

 
 //dlv_ord_dikanban_generate
 //--------------Update 7 April 2022-------		 
   $query_check_Prcv = "SELECT * FROM po_detail_trans_gr WHERE purc_ord_no = '".sql_esc($data_sql3['purc_ord_no'])."' AND status_gr = '".sql_esc($rst_sta3["status_desc"])."' AND material_no = '".sql_esc($data_sql3["material_no"])."'";
 $result_check_Prcv = mysqli_query($dbc,$query_check_Prcv);
   
 while($data_check_Prcv = mysqli_fetch_array($result_check_Prcv))
 {
   
   
   $tot_gr_qtyB = $tot_gr_qtyB + $data_check_Prcv["gr_qty"];
     
   
 }

//-------`po_detail`
//--------------Update 3 August 2023-------		 
$query_check_Pftp = "SELECT * FROM po_detail WHERE purc_ord_no = '".sql_esc($data_sql3['purc_ord_no'])."' AND material_no = '".sql_esc($data_sql3["material_no"])."'";
$result_check_Pftp = mysqli_query($dbc,$query_check_Pftp);
$data_check_Pftp = mysqli_fetch_array($result_check_Pftp);

  
  $tot_gr_qtyC = $tot_gr_qtyC + $data_check_Pftp["po_qty"];
     


if($tot_gr_qtyB != 0.000)
 {
  
$Grd_total_new_bal = (($tot_gr_qtyC) - ($tot_gr_qtyB));

}else{

 $Grd_total_new_bal = ($tot_gr_qtyC);
}


  //------------number format -------------//
if($data_sql3["ord_uom"] == 'PCS')
{
  $PO_baru = intval($tot_gr_qtyC,3);
  $GR_baru = intval($tot_gr_qtyB,3);
  $Grd_baru = intval($Grd_total_new_bal);

}else{

  $PO_baru = number_format($tot_gr_qtyC,3);
  $GR_baru = number_format($tot_gr_qtyB,3);
  $Grd_baru = number_format($Grd_total_new_bal,3);

}
  
	 
	 //----get vendor detail -----
	 
	 $query_vend = new PreparedSql("SELECT * FROM vendor_detail WHERE vendor_code = ? AND status_acc = 'Y'", [$data_sql3["vendor_id"]]);
	 $result_vend = db_query($dbc, $query_vend); 
	 $data_vend = mysqli_fetch_array($result_vend);
		 
		echo '<tr height="35">';
        echo '<td>'. $no2.'</td>'; 
		echo '<td>'. $data_sql3["plant_code"].'</td>'; 
		echo '<td>'. $data_sql3["purc_ord_no"].'</td>'; 	
		echo '<td>'. $data_sql3["vendor_id"].'</td>'; 	
		echo '<td>'. $data_vend["vendor_name"].'</td>'; 	
	 	echo '<td>'. $data_sql3["material_no"].'</td>'; 	
		echo '<td>'. $data_sql3["material_desc"].'</td>'; 
		echo '<td>'. $data_sql3["model_gr"].'</td>'; 
		echo '<td align="right">'.$PO_baru.'</td>';  
		echo '<td align="right">'.$GR_baru.'</td>';  
    echo '<td align="right">'.$Grd_baru.'</td>';  
	 	echo '<td>'. strtoupper($data_sql3["ord_uom"]).'</td>';  	
    echo '</tr>'; 
		

 $no2++;
   }
    
    
  mysqli_free_result($result_sql3);   
   
  ?></tbody></table> 
 
<?php

echo iconv('utf-8', 'cp1251', "$data"); 
?>
</body>
</html>


