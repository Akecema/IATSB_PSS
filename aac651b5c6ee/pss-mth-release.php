<?php
//$username = $_SESSION['username'];
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
   $plan_category = $_GET["plan_category"];
   $material_no = $_GET["material_no"]; 
   $shift_ops = $_GET["shift_ops"]; 
   $username = $_GET["username"]; 
 
if(isset($_POST['e_tcid']))
{
	  

 
    $trc_id = $_POST["e_tcid"]; 
    $st = count($trc_id);
	$string = "";
	
	  
	
	    
		 for($i=0; $i<$st; $i++)
	{		
	
	// echo ($i+1).'-'.$cancel[$i]; echo "</br>";
		
		
		//update table pps_detail
		
	$query_releas_v = "UPDATE pps_detail SET status_pps = '".sql_esc($rst_sta2["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), user_posting = '".sql_esc($username)."', date_posting = NOW() WHERE id = '".sql_esc($trc_id[$i])."'";
        $result_releas_v = mysqli_query($dbc,$query_releas_v);
	
		  
			}// end for loop
			
   }// end if
/*   else{
	   
	      echo "<script>";
		  echo "alert('Please tick the check box for proceed the transaction.');";
		  echo "window.location='display_pps_month_reprint2.php?date1=$dateF&&date2=$dateT&&plant_code=$plant_code&&work_center=$work_center&&plan_no=$plan_no&&shift_ops=$shift_ops&&name_file=$name_file'";
		  echo "</script>"; 
		  exit(); //quit the script
	  
	   
   }
*/
?>
 