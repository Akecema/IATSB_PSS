<?php

if($ship_point == '3100')
{

 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '41'";
 $result_id2 = mysqli_query($dbc,$query_id2);

}elseif($ship_point == '3101')
{
    
 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '88'";
 $result_id2 = mysqli_query($dbc,$query_id2);
    
}

if ($result_id2) 
{
$nrows2 = mysqli_num_rows($result_id2);
$row_id2 = mysqli_fetch_array($result_id2);

$dht2 = 00000; 
$dht_OK2 = "511";
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

$ref3 = (($row_id2['start_ref']).$dht_OK2.$date_run.($number2));
  

} // end if $result_id2

?>