<?php
include '../include/config.php';

//CR status (New)

$sta = "SELECT * from request_status WHERE status_id = '1' ";
$sta_res = mysqli_query($dbc,$sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2' ";
$sta_res2 = mysqli_query($dbc,$sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);	

//CR status (Cancel)
$sta4 = "SELECT * from request_status WHERE status_id = '4' ";
$sta_res4 = mysqli_query($dbc,$sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);



   $dateF = $_GET["date1"];
   $dateT = $_GET["date2"];
   $plant_code = $_GET["plant_code"];
   $work_center = $_GET["work_center"];
   $material_no = $_GET["material_no"]; 
   $shift_ops = $_GET["shift_ops"]; 
   $name_file = $_GET["name_file"]; 
   
   //-------generate doc print pps-----------
   
	$query_id = "SELECT count_max FROM run_count_no_itsb WHERE uid = '3'";
	$result_id = mysqli_query($dbc,$query_id);
	
	if ($result_id) 
{
	$nrows = mysqli_num_rows($result_id);
	$row_id = mysqli_fetch_row($result_id);
	
	$dht = 0000000; 
	$dht_OK = "239";
	$dg2 = 0;

  	if($row_id[0] <= 0)
  	{ 
   
    	$lastID = ($row_id[0] + 1);
    	$dg = ($dht + ($lastID));
   }
   else
   {
      $lastID = ($row_id[0] + 1);
      $dg =  $lastID;
	
    }
	$number = $dg; // Length of running no
    $number = sprintf('%07d', $number);  
	
	  $ref = ($dht_OK.($number));
	
	
	} // end if $result_id
  
	
   
 
if(isset($_POST['e_tcid']))
{
	  

 
    $trc_id = $_POST["e_tcid"]; 
    $st = count($trc_id);
	$string = "";
	
	    
	for($g=0; $g<$st; $g++)
	{		
		$query_info2 = new PreparedSql("SELECT * FROM pps_detail WHERE id = ?", [$trc_id[$g]]);
		$result_info2 = db_query($dbc, $query_info2);
		$row_info2 = mysqli_fetch_array($result_info2);
		
		
		$query_prt_batch = "INSERT INTO prt_sheet_pps_release(id_gen,doc_generate,id_pps_dtl,plan_no,work_center,plant_code,month_plan,year_plan,date_plan,created_by,date_create)   	
							VALUES('','".sql_esc($ref)."','".sql_esc($trc_id[$g])."','".sql_esc($row_info2["plan_no"])."','".sql_esc($row_info2["work_center"])."','".sql_esc($row_info2["plant_code"])."',
									'".sql_esc($row_info2["month_plan"])."','".sql_esc($row_info2["year_plan"])."','".sql_esc($row_info2["date_plan"])."','',NOW())";
		$result_prt_batch = mysqli_query($dbc,$query_prt_batch);	
	  
	}// end for loop
			
   
			
			
			
   }// end if
   
   
    
		//update count_max----------------------------------------
		
	
       $query_max_a = "UPDATE run_count_no_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '3'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	 
       //end update count_max ---------------------------------	
		
			
				
		echo "<script>"; 
		echo "window.open('test-pps-release-print.php?id=$ref')"; 
        echo "</script>";

			
?>
 