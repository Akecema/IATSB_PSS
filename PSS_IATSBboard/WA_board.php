<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
include 'include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));
$masa = (date("H:m:s"));

          $query_shtA = "SELECT * FROM shift_detail WHERE id_shift = '1'";
		  $result_shtA = mysqli_query($dbc,$query_shtA);
		  $data_shtA = mysqli_fetch_array($result_shtA); 
		  
		 //----shift posting ----
		 
		 if(($masa >= $data_shtA["time_start"]) && ($masa <= $data_shtA["time_end"]))
		 {
			 
		 $shif_pA = "Day"; 
		 $shift_chkA = "D/S";
		 
		 }else
		 {
		 
		 $shif_pA = "Night"; 
		 $shift_chkA = "N/S";
		
		 }	 

//$Cdate = date ("l, j F Y ");
//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

set_time_limit(0);

$nextpage = 1;

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

//CR status (Transfer QC)
$sta18 = "SELECT * from request_status WHERE status_id = '18'";
$sta_res18 = mysqli_query($dbc,$sta18);
$rst_sta18 = mysqli_fetch_array($sta_res18);

//CR status (Cancel)
$sta21 = "SELECT * from request_status WHERE status_id = '21'";
$sta_res21 = mysqli_query($dbc,$sta21);
$rst_sta21 = mysqli_fetch_array($sta_res21);

//CR status (Close)
$sta22 = "SELECT * from request_status WHERE status_id = '22'";
$sta_res22 = mysqli_query($dbc,$sta22);
$rst_sta22 = mysqli_fetch_array($sta_res22);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="description" content="<?php $data_setup["tajuk_sys"]; ?>">
<title><?php echo $data_setup["title_desc"]; ?></title>
<link rel="shortcut icon" href="images/favicon.ico">  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<link rel="stylesheet" href="scripts/pagination3.css" type="text/css" />
<link rel="stylesheet" href="scripts/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="javascript/jquery-latest.js"></script> 
<script type="text/javascript" src="javascript/thickbox.js"></script>
<?php

//include 'content.php';

$today = getdate();
$hours = $today['hours']; 
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year']; 
?>
<style type="text/css">
<!--
.style3 {color: #000000; font-size:18px}
.style4 {color: #000000; font-size:14px}
.style5 {color: #00FF00; font-size:14px}

body {
	background-color: #FFFFFF;
}
.style6 {color: #000000; font-size: 18px; }
.style7 {color: #000000}
.style9 {color: #000000; font-size: 14px; }
.style10 {color: #000000; font-size: 9px; }
body,td,th {
	color: #000000;
}
.glow {
  font-size: 18px;
  color: #fff;
  text-align: center;
  animation: glow 1s ease-in-out infinite alternate;
}

@-webkit-keyframes glow {
  from {
    text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #e60073, 0 0 40px #e60073, 0 0 50px #e60073, 0 0 60px #e60073, 0 0 70px #e60073;
  }
  
  to {
    text-shadow: 0 0 20px #fff, 0 0 30px #ff4da6, 0 0 40px #ff4da6, 0 0 50px #ff4da6, 0 0 60px #ff4da6, 0 0 70px #ff4da6, 0 0 80px #ff4da6;
  }
}
-->
</style>
</head>

<?php
function convertZero ($value) {
   if ($value == 0) {
      $newValue = "-";
   } else {
      $newValue = $value;
   }
   return $newValue;
}

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #141414;">
   <tr>
    <td width="500">&nbsp;<h1><font color="#0000FF"><?php echo $data_setup["title_desc"]; ?></font></h1></td>
    <td width="200">&nbsp;<span class="style6"><?php echo date("l M d, Y");   ?></span></td>
 
  <td width="200">&nbsp;&nbsp;&nbsp;<span class="style6"> <?php echo date("H:i:s");  ?></span></td>

  </tr>
  <tr>
    <td>&nbsp;<span class="style6">Production : Welding Assembly</span></td>
    <td>&nbsp;<span class="style6">Shift : <?php echo $shif_pA;  ?></span></td>
    <td>&nbsp;<span class="style6">Page : &nbsp;<?php echo $currentpage.' of '.$totalpages; ?></span></td>
  </tr>
</table>


 
<?php

   $trBreak = 1;
   $trBreak2 = 1;
   
  
 $table .= '<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td>MODULE</td>
    <td>MODEL</td>
    <td>BACK NO.</td>
    <td>PART NUMBER</td>
    <td>PLAN</td>
    <td>ACTUAL</td>
    <td>REJECT</td>
    <td>PENDING</td>
  </tr>';


 # Count planning
      $countPlanW = mysqli_num_rows(mysqli_query($dbc, "SELECT * FROM pps_detail WHERE status_pps != '".sql_esc($rst_sta4["status_desc"])."' AND status = 'Y'"));

      $sqlDiv = "SELECT * FROM work_center_detail WHERE prod_cat = 'A' AND status_wc = 'Y' AND status_publish = 'Y'";
      $rsDiv = mysqli_query($dbc, $sqlDiv);
      while ($rowDiv = mysqli_fetch_array($rsDiv)) {
         # Count no of module (base on work center)
         $countDiv = mysqli_num_rows(mysqli_query($dbc, "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($rowDiv['id_work'])."' AND status_wc = 'Y'"));
         # Get data of module
         $fetchDiv = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM welding_assy_detail WHERE module_code = '".sql_esc($rowDiv['id_work'])."'"));

         if ($countDiv > 0) {
            $sqlCty = "SELECT * FROM welding_assy_detail WHERE module_code = '".sql_esc($rowDiv['id_work'])."' AND status_publish = 'Y' ORDER BY module_code";
            $rsCty = mysqli_query($dbc, $sqlCty);

            $table .= "<tr>";
            $table .= "<td rowspan='" . $countDiv . "'><center>" . $fetchDiv['module_desc'] . "A</center></td>";
         
            while ($rowCty = mysqli_fetch_array($rsCty)) {
               # Count no of model
               $countCty = mysqli_num_rows(mysqli_query($dbc, "SELECT * FROM welding_assy_detail WHERE module_code = '".sql_esc($rowDiv['id_work'])."' AND model_code = '".sql_esc($rowCty['model_code'])."' AND status_module = 'Y'"));
              
			   # Get data of model
               $fetchCty = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM welding_assy_detail WHERE module_code = '".sql_esc($fetchDiv['module_code'])."' AND model_code = '".sql_esc($rowCty['model_code'])."' AND status_module = 'Y'"));

               if ($countCty > 0) {
                  if ($trBreak == 0) {
                     $table .= "<tr>";
                     $trBreak2 = 1;
                  }

                 // $table .= "<td rowspan='" . $countCty . "' class='bg-white'><center>" . $fetchCty['model_code'] . "B</center></td>";

                  $sqlComp = "SELECT * FROM welding_assy_detail WHERE model_code = '".sql_esc($rowCty['model_code'])."'";
                  $rsComp = mysqli_query($dbc,$sqlComp);

                  while ($rowComp = mysqli_fetch_array($rsComp)) {
                     
                     if ($trBreak2 == 0) {
                        $table .= "<tr>";
                     }

                     # Count pps detail
                     $countBackNo = mysqli_num_rows(mysqli_query($dbc, "SELECT * FROM pps_detail WHERE work_center = '".sql_esc($rowComp["module_code"])."' AND model_code = '".sql_esc($rowComp["model_code"])."' AND status_pps != '".sql_esc($rst_sta4["status_desc"])."' AND status = 'Y'"));
				     
					 # Get data pps
				     $fetchBackNo = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM pps_detail WHERE work_center = '".sql_esc($rowDiv['module_code'])."' AND model_code = '".sql_esc($rowCty['model_code'])."' "));
	
			  
		  
		   $table .= "<td><center>" . $rowComp['model_code'] . "Z</center></td>";
   // $rowCty[model_code]

               $table .= "<td><center>F".  $fetchBackNo["back_no"]."</center></td>";
               $table .= "<td></center>" .$fetchBackNo["material_no"]."</td>";
               $table .= "<td><center></center></td>";
               $table .= "<td><center></center></td>";
               $table .= "<td><center></center></td>";
               $table .= "<td><center></center></td>";
               $table .= "</tr>";

               $caseNo++;
               $trBreak2 = 0;
            }
            $trBreak = 0;
         }
         $trBreak = 1;
         $trBreak2 = 1;
      }
	  

		 }
	  }

$table .= "</table>";
echo $table;
echo "<br>";


?>






   