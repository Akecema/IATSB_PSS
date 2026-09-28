<?php

session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
header('Location: ../index.php');
exit();
}




$prtid = $_GET["id"];

//echo "Print id = ".$prtid;

$myArray = explode(',', $prtid);
//print_r($myArray);

$arrayLength = count($myArray);

/*$i = 0;
while ($i < $arrayLength)
{
	echo $prtid[$i][$i] ."<br />";
	$i++;
}*/

?>

  
<?php
for($i = 0; $i < count($myArray); $i++)  
{ 
	
	/*$query_bac_prt_pps = "SELECT * FROM pps_detail_test WHERE id = '".$myArray[$i]."' group by work_center";
	$result_bac_prt_pps = mysqli_query($dbc,$query_bac_prt_pps);
	$dt_bac_prt_pps = mysqli_fetch_array($result_bac_prt_pps);	 */ 
	
	
	$query_bac_prt_pps = "SELECT * FROM pps_detail_test  WHERE id = '".sql_esc($myArray[$i])."' group by work_center ";
	$result_bac_prt_pps = mysqli_query($dbc,$query_bac_prt_pps);
	$dt_bac_prt_pps = mysqli_fetch_array($result_bac_prt_pps);	 


	echo "Work = ".$dt_bac_prt_pps['work_center']."</br>";
	
	$query_bac_prt_pps2 = "SELECT * FROM prt_sheet_pps_new WHERE id_pps_dtl = '".sql_esc($dt_bac_prt_pps['id'])."' group by work_center ";
	$result_bac_prt_pps2 = mysqli_query($dbc,$query_bac_prt_pps2);
	
	while($dt_bac_prt_pps2 = mysqli_fetch_array($result_bac_prt_pps2)) {	 
	
	
	?>
   

   <!-- <table class="table-bordered">
	 <thead>  
    
    <tr>
      <th>No.</th>
      <th>Plant</th>
    </tr>
    </thead>  
    		
    <tbody>
        <td><?php  echo $dt_bac_prt_pps2['id_pps_dtl']; ?></td>
        <td><?php  echo $dt_bac_prt_pps2['work_center']; ?></td>
    </tbody>
    </table>-->
    
<?php } ?>



<?php
}//end for loop
?>

	
	</table>

	
<?php	
/*$query_bac_prt_pps = "SELECT * FROM prt_sheet_pps_new WHERE id_pps_dtl = '".$myArray."' ";
$result_bac_prt_pps = mysqli_query($dbc,$query_bac_prt_pps);

while($dt_bac_prt_pps = mysqli_fetch_array($result_bac_prt_pps))	  
{

	echo "Print id = ".$dt_bac_prt_pps['id_pps_dtl']."\n";
}*/	


/*$query_bac_prt_pps = "SELECT * FROM prt_sheet_pps_new WHERE doc_generate = '".$prtid."' ";
$result_bac_prt_pps = mysqli_query($dbc,$query_bac_prt_pps);

while($dt_bac_prt_pps = mysqli_fetch_array($result_bac_prt_pps))	  
{	
	
	
	$query_bac_prt_pps2 = "SELECT * FROM prt_sheet_pps_new WHERE id_pps_dtl = '".$dt_bac_prt_pps['id_pps_dtl']."' GROUP BY work_center";
	$result_bac_prt_pps2 = mysqli_query($dbc,$query_bac_prt_pps2);
	
	while($row3 = mysqli_fetch_array($result_bac_prt_pps2))
	{*/
	  
		//echo "Print id = ".$row3['id_pps_dtl'];
	
?>

 <!--<table class="table-bordered">
      <thead>  
      
        <tr>
          <th>No.</th>
          <th>Plant</th>
        </tr>
      </thead>
        
       <tbody>
       <td><?php  echo $row3["id_pps_dtl"]; ?></td>
       <td><?php  echo $row3["work_center"]; ?></td>
       </tbody>-->

<?php
//}
//}   
?>
<!--</table>-->