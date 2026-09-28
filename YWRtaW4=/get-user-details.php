
<?php

include '../include/config.php';

$query_rcd = "SELECT * FROM user_detail where staff_ID = '".sql_esc($get_userID)."'";
$resulty_rcd = mysqli_query($dbc,$query_rcd);  
$row_rcd = mysqli_fetch_array($resulty_rcd);

$vendor_no = $row_rcd['vendor_no'];
$usr_id = $row_rcd['staff_ID'];
$usr_name = $row_rcd['user_fullname'];
$usr_comp2 = $row_rcd['company'];
$usr_dept2 = $row_rcd['department'];
$usr_desg2 = $row_rcd['designation'];

$usr_tel1 = $row_rcd['user_telno1'];
$usr_tel2 = $row_rcd['user_telno2'];
$usr_fax = $row_rcd['user_fax'];

$usr_email = $row_rcd['user_email'];
$usr_level2 = $row_rcd['level_id'];
$usr_accsta = $row_rcd['status'];
$created_by = $row_rcd['user_created'];
$created_date = $row_rcd['date_created'];

?>