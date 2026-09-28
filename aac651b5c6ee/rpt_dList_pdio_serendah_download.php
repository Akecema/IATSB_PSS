<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';


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

$date_tdy = date('d-m-Y H:i:s');
set_time_limit(0);

$dateF = $_GET["date1"];
$dateT = $_GET["date2"];
$cust_code = $_GET["cust_code"]; 
$pdio_no = $_GET["pdio_no"]; 
$ship_point = $_GET['ship_point'];

//----get ship point extract string -----
$plant_dlv = substr($_GET['ship_point'],0,4);
			
			
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



              $plant_dlv = substr($ship_point,0,4);	 		
		
              //2. Ship Point
          if (($ship_point == "NULL") || ($ship_point == "")){ 
              $wheresql_02 = ""; }
          else {
              $wheresql_02 = " AND plant_code = '".sql_esc($plant_dlv)."'"; }  		
              
              
     //1. cust Code
          if (($cust_code == "") || ($cust_code == "NULL")){ 
              $wheresql_01 = ""; }
          else {
              $wheresql_01 = " AND cust_code = '".sql_esc($cust_code)."'"; }  	

      
                              
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

    //2. PDIO No.

          if ($pdio_no == ""){ 
              $wheresql_05 = ""; }
          else {
              $wheresql_05 = " AND pdio_no = '".sql_esc($pdio_no)."'"; }  	
              
   

          $where_sql =  $wheresql_02 .$wheresql_01 .$wheresql_03 .$wheresql_04 .$wheresql_05;
              
          
 
 //********** END CONDITION **************
 

$namaFile = "PDIO PSS IATSB_".$date_tdy.".xls";

 $count_record = "";	
		
  $query8 = "SELECT *, DATE_FORMAT(dlv_date,'%d-%m-%Y') as R FROM dlv_pdio_generate WHERE mat_doc != '' AND (status_pdio = '".sql_esc($rst_sta3["status_desc"])."')" .$where_sql."ORDER BY pdio_no ASC ";
  $result8 = mysqli_query($dbc,$query8) or die(mysqli_error($dbc));
  $num_rows = mysqli_num_rows($result8);
  
  $query8a = "SELECT *, DATE_FORMAT(dlv_date,'%d-%m-%Y') as R FROM dlv_pdio_generate WHERE mat_doc != '' AND (status_pdio = '".sql_esc($rst_sta3["status_desc"])."')" .$where_sql."ORDER BY pdio_no ASC ";
  $result8a = mysqli_query($dbc,$query8a) or die(mysqli_error($dbc));
  $num_rows_8a = mysqli_num_rows($result8a);

//---------------------------end count
 // $count_record =  ($num_rows + $num_rows_8a);
  
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
$content .= "<font size='12px'><strong>DOCUMENT LIST - UPLOAD PDIO [PSS IATSB]</strong></font> ";
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
echo '<th width="5" bgcolor="#E9F58D">PDIO NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">ORDER NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">DELIVERY CATEGORY </th>';
echo '<th width="5" bgcolor="#E9F58D">PRODUCTION DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">DELIVERY DATE</th>';
echo '<th width="5" bgcolor="#E9F58D">TRIP NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">BACK NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">PART NO.</th>';
echo '<th width="5" bgcolor="#E9F58D">PART NAME</th>';
echo '<th width="5" bgcolor="#E9F58D">DELIVERY QTY</th>';
echo '<th width="5" bgcolor="#E9F58D">UOM</th>';
echo '</tr>';
echo '</table>';

 
//Display table
// query menampilkan semua data
  $query_sql3 = "SELECT *, DATE_FORMAT(dlv_date,'%d-%m-%Y') as R, DATE_FORMAT(prod_date,'%d-%m-%Y') as R37 FROM dlv_pdio_generate WHERE mat_doc != '' AND (status_pdio = '".sql_esc($rst_sta3["status_desc"])."')" .$where_sql."ORDER BY pdio_no ASC ";
  $result_sql3 = mysqli_query($dbc,$query_sql3);   //run the query.
 
//count how many data
   $counter = 1;
   $no = 1;
   $i = 1;

   
 echo '<table border="1" width="100%">';
	 
   $no2 = 1;
	   while ($data_sql3 = mysqli_fetch_array($result_sql3))
   {

	   
	   $query_mat2 = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$data_sql3["material_no"]]);
	   $result_mat2 = db_query($dbc, $query_mat2);
       $row_mat2 = mysqli_fetch_array($result_mat2);
	   
	    
	 
		echo '<tr height="35">';
		echo '<td>'. $no2.'</td>';  
		echo '<td>'. $data_sql3["pdio_no"].'</td>'; 
        echo '<td>'. $data_sql3["order_no"].'</td>'; 	
	 	echo '<td><div align="center">'. $data_sql3["dlv_category"].'</div></td>'; 	
        echo '<td>'. $data_sql3["R37"].'</td>'; 
        echo '<td>'. $data_sql3["R"].'</td>'; 
        echo '<td><div align="center">'. $data_sql3["trip_no"].'</div></td>'; 
		echo '<td>'. $data_sql3["back_no"].'</td>'; 
        echo '<td>'. strtoupper($data_sql3["material_no"]).'</td>'; 
         echo '<td>'. $data_sql3["material_desc"].'</td>';   
		echo '<td align="center">'.intval($data_sql3["pdio_qty"]).'</div></td>'; 	 	
        echo '<td>'. $data_sql3["uom_pdio"].'</td>';
	
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


