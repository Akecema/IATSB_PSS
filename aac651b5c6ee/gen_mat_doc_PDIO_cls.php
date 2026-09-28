<?php

 if($plant_dlv== '3100')
	{
  
    $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = '".sql_esc($fdate)."' WHERE uid = '154'";
	$result_max_a = mysqli_query($dbc,$query_max_a);
	   
	 

	}elseif($plant_dlv == '3101')
	{
	   $query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = '".sql_esc($fdate)."' WHERE uid = '155'";
	   $result_max_b = mysqli_query($dbc,$query_max_b);
	 
  }

    ?>