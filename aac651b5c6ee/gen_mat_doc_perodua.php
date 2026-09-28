<?php
$ship_point == '3100';

if($ship_point == '3100')
{

 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '128'";
 $result_id2 = mysqli_query($dbc,$query_id2);

}elseif($ship_point == '3101')
{
    
 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '129'";
 $result_id2 = mysqli_query($dbc,$query_id2);
    
}


if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 000; 
	$dht_OK2 = 000;
	$dg2 = 0;

  	if($row_id2["count_max"] <= 0)
  	{ 
   
    	$lastID2 = ($row_id2["count_max"] + 1);
    	$dg2 = ($dht2 + ($lastID2));
   }
   else
   {
      $lastID2 = ($row_id2["count_max"] + 1);
      $dg2 =  $lastID2;
	
    }
	$number2 = $dg2; // Length of running no
    $number2 = sprintf('%05d', $number2);  
	
    $ref = (($row_id2['start_ref']).$date_run.($number2));
	
	
	} // end if $result_id2
	


?>