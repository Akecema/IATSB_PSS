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

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

//CR status (Transfer Material)
$sta28 = "SELECT * from request_status WHERE status_id = '28'";
$sta_res28 = mysqli_query($dbc,$sta28);
$rst_sta28 = mysqli_fetch_array($sta_res28);


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
         	 $vendor_code = $_GET["vendor_code"]; 
			
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
				 
								 		
		 // 1. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND (date_posting_do >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //2. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
					$wheresql_02 = " AND (date_posting_do <= '".sql_esc($date2_final)."')"; }
					
						
	       //3. Vendor Code
                if (($vendor_code == "") || ($vendor_code == "NULL")){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND vc_code = '".sql_esc($vendor_code)."'"; } 
					
		 
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03;
	
	//********** END CONDITION **************
	

$namaFile = "Delivery Order ".$date_tdy.".xls";

 $count_record = "";	
		
  $query8 = "SELECT * FROM dlv_ord_dikanban_generate WHERE (status_kanban = '".sql_esc($rst_sta7["status_desc"])."')" .$where_sql." GROUP BY do_no";
  $result8 = mysqli_query($dbc,$query8) or die(mysqli_error());
  $num_rows = mysqli_num_rows($result8);
  
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
$content .= "<font size='12px'><strong>DELIVERY ORDER</strong></font> ";
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
echo '<th rowspan="2" width="5" bgcolor="#E9F58D">NO.</th>';
echo '<th rowspan="2" width="5" bgcolor="#E9F58D">DELIVERY ORDER NO. </th>';
echo '<th rowspan="2" width="5" bgcolor="#E9F58D">PURCHASE ORDER NO.</th>';
echo '<th rowspan="2" width="5" bgcolor="#E9F58D">DELIVERY INSTRUCTION NO.</th>';
echo '<th rowspan="2" width="5" bgcolor="#E9F58D">GR DOC NO.</th>';
echo '<th rowspan="2" width="5" bgcolor="#E9F58D">VENDOR CODE</th>';
echo '<th rowspan="2" width="5" bgcolor="#E9F58D">VENDOR NAME</th>';
echo '<th rowspan="2" width="5" bgcolor="#E9F58D">BACK NO.</th>';
echo '<th rowspan="2" width="5" bgcolor="#E9F58D">PART NO.</th>';
echo '<th rowspan="2" width="5" bgcolor="#E9F58D">PART NAME</th>';
echo '<th rowspan="2" width="5" bgcolor="#E9F58D">DELIVERY DATE</th>';
echo '<th rowspan="2" width="5" bgcolor="#E9F58D">DELIVERY TIME</th>';
echo '<th colspan="2" width="5" bgcolor="#E9F58D">DELIVERED</th>';
echo '<th colspan="2" width="5" bgcolor="#E9F58D">RECEIVED</th>';
echo '</tr>';
echo '<tr height="35">';
echo '<th width="150" bgcolor="#E9F58D">&nbsp;QTY     &nbsp;</th>';
echo '<th width="150" bgcolor="#E9F58D">PACKAGING </th>';
echo '<th width="150" bgcolor="#E9F58D">&nbsp;QTY    &nbsp;</th>';
echo '<th width="150" bgcolor="#E9F58D">PACKAGING</th>';
echo '</tr>';
echo '</table>';

//Display table
// query menampilkan semua data
  $query_sql3 = "SELECT *, DATE_FORMAT(date_posting_do,'%d-%m-%Y') as RP FROM dlv_ord_dikanban_generate WHERE (status_kanban = '".sql_esc($rst_sta7["status_desc"])."') " .$where_sql."  ORDER BY DI_doc ASC ";
  $result_sql3 = mysqli_query($dbc,$query_sql3);   //run the query.
 
//count how many data
   $counter = 1;
   $no = 1;
   $i = 1;

   
 echo '<table border="1" width="100%">';
	 
   $no2 = 1;
	   while ($data_sql3 = mysqli_fetch_array($result_sql3))
   {
	    
	      //----vendor detail ------
				   $query_vcode = "SELECT * FROM vendor_detail WHERE vendor_code = '".sql_esc($data_sql3["vc_code"])."' AND status_acc = 'Y'";
                   $result_vcode = mysqli_query($dbc,$query_vcode);
                   $row_vcode = mysqli_fetch_array($result_vcode);	
				   
		 //----print tag detail -----
		 
		 $query_tag = "SELECT * FROM print_tag_do_dikanban WHERE id_do = '".sql_esc($data_sql3["id"])."'";		   
         $result_tag = mysqli_query($dbc,$query_tag);
         $row_tag = mysqli_fetch_array($result_tag);	
	  
	
	   $tot_gr_qtyB = 0.000;
	   
		   //--------------Good Receipt - base on DO No.-------		 
    $query_check_Prcv = "SELECT * FROM po_detail_trans_gr WHERE dlv_ord_no = '".sql_esc($data_sql3["do_no"])."' AND purc_ord_no = '".sql_esc($data_sql3["po_no"])."' AND id_DI = '".sql_esc($data_sql3["id_DI"])."' AND doc_gen = '".sql_esc($data_sql3["DI_doc"])."'  AND status_gr = '".sql_esc($rst_sta3["status_desc"])."'";
	$result_check_Prcv = mysqli_query($dbc,$query_check_Prcv);
	  
	 while($data_check_Prcv = mysqli_fetch_array($result_check_Prcv))
	  {
		  
		  $tot_gr_qtyB = $tot_gr_qtyB + $data_check_Prcv["gr_qty"];
		
	   }
	   
	   
	    $query_check_PrcvTg = "SELECT * FROM po_detail_trans_gr WHERE dlv_ord_no = '".sql_esc($data_sql3["do_no"])."' AND purc_ord_no = '".sql_esc($data_sql3["po_no"])."' AND id_DI = '".sql_esc($data_sql3["id_DI"])."' AND doc_gen = '".sql_esc($data_sql3["DI_doc"])."' AND material_no = '".sql_esc($data_sql3["material_no"])."' AND status_gr = '".sql_esc($rst_sta3["status_desc"])."'";
	    $result_check_PrcvTg = mysqli_query($dbc,$query_check_PrcvTg);
	    $data_check_PrcvTg = mysqli_fetch_array($result_check_PrcvTg);
	   
	     $query_tagGR = "SELECT * FROM print_tag_gd_receipt WHERE id_gr = '".sql_esc($data_check_PrcvTg["id"])."'";		   
         $result_tagGR = mysqli_query($dbc,$query_tagGR);
         $row_tagGR = mysqli_fetch_array($result_tagGR);
	 	
	
		echo '<tr height="35">';
		echo '<td>'. $no2.'</td>'; 
		echo '<td>&nbsp;'. $data_sql3["do_no"].'</td>';	 
	 	echo '<td>&nbsp;'. $data_sql3["po_no"].'</td>'; 
        echo '<td>&nbsp;'. $data_sql3["DI_doc"].'</td>'; 	
		echo '<td>&nbsp;'. $data_check_Prcv["material_doc_gen"].'</td>'; 
        echo '<td>'. $data_sql3["vc_code"].'</td>';   
        echo '<td>'. $row_vcode["vendor_name"].'</td>';
		echo '<td>'. $data_sql3["back_no"].'</td>'; 
		echo '<td>'. $data_sql3["material_no"].'</td>'; 
        echo '<td>'. $data_sql3["material_desc"].'</td>';
		echo '<td>&nbsp;'. $data_sql3["RP"].'</td>';
		echo '<td>&nbsp;'. $data_sql3["time_posting_do"].'</td>';
		echo '<td width="150" align="right">'. intval($data_sql3["qty_dlv"]).'</td>'; 
        echo '<td>'. $row_tag["total_slip"].'</td>';
        echo '<td width="150" align="right">'. intval($tot_gr_qtyB).'</td>'; 
		if($row_tagGR["tag_qty"] != 0.000)
		{
        echo '<td>'.$row_tagGR["total_slip"].'</td>'; 
		}else{
			
		  echo '<td>0</td>'; 	
			
		}
	    echo '</tr>'; 
		$no2++;

	}
  ?><?php 
   
    
    
  mysqli_free_result($result_sql3);   
   
  ?></tbody></table> 
 
<?php

echo iconv('utf-8', 'cp1251', "$data"); 
?>
</body>
</html>


