<?php
$ship_point == '3100';


if($ship_point == '3100')
{

   $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '41'";
   $result_max_a = mysqli_query($dbc,$query_max_a);

}elseif($ship_point == '3101')
{
   $query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '88'";
   $result_max_b = mysqli_query($dbc,$query_max_b);
 
}

?>