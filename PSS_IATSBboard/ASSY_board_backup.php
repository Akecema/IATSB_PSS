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

//CR status (Draft)
$sta6 = "SELECT * from request_status WHERE status_id = '6'";
$sta_res6 = mysqli_query($dbc,$sta6);
$rst_sta6 = mysqli_fetch_array($sta_res6);

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
    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>
    <link rel="shortcut icon" href="images/favicon.ico">  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<link rel="stylesheet" href="scripts/pagination3.css" type="text/css" />
<link rel="stylesheet" href="scripts/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="javascript/jquery-latest.js"></script> 
<script type="text/javascript" src="javascript/thickbox.js"></script>	
<?php

include 'contentASSY.php';

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
	background-color: #000000;
}
.style6 {color: #ffffff; font-size: 18px; }
.style16 {color: #0F0; font-size: 24px; }
.style7 {color: #000000}
.style9 {color: #000000; font-size: 14px; }
.style10 {color: #000000; font-size: 9px; }
.style66 {color: #0000FF; font-size: 28px; }
body,td,th {
	color: #FFFFFF;
}

.glow {
  font-size: 9px;
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
<!--<table width="100%" border="1" cellspacing="1" cellpadding="1">
--> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #141414;">
   <tr>
    <td width="500">&nbsp;<h2><img src="images/logo_n.gif" width="400" height="45" alt="IATSB"></h2></td>
    <td width="200">&nbsp;<span class="style16"><?php echo date("l M d, Y");   ?></span></td>
    <td width="200">&nbsp;&nbsp;&nbsp;<span class="style16"> <?php echo date("H:i:s");  ?></span></td>

  </tr>
  <tr>
    <td>&nbsp;<span class="style16">PRODUCTION : WELDING ASSEMBLY</span></td>
    <td>&nbsp;<span class="style16">SHIFT : <?php echo $shif_pA;  ?></span></td>
    <td>&nbsp;<span class="style16">PAGE : &nbsp;<?php echo $currentpage.' OF '.$totalpages; ?></span></td>
  </tr>
</table>



<?php
 //---shift detail ------
	
	  $query_sht_checking = "SELECT * FROM shift_detail WHERE id_shift = '1'";
	  $result_sht_checking = mysqli_query($dbc,$query_sht_checking);
	  $data_sht_checking = mysqli_fetch_array($result_sht_checking); 
	  
	 //----shift posting ----
	 $prev_date = date('Y-m-d', strtotime($currentdate .' -1 day'));
	 
	 if(($masa >= $data_sht_checking["time_start"]) && ($masa <= $data_sht_checking["time_end"]))
	 {
		 
     $date_baru = $currentdate;
	
	 
	 }else
	 {
	    if(($masa >= '00:00:00') && ($masa <= '07:59:00'))
	   {
	    $date_baru = $prev_date; 
	   }else{
		   
		 $date_baru = $currentdate;   
	   }
	
	 }



$sql2 = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') AS R FROM pps_detail WHERE plan_category = 'ASSY' AND (status_pps != '".sql_esc($rst_sta4["status_desc"])."') AND (status_pps != '".sql_esc($rst_sta13["status_desc"])."') AND status = 'Y' AND date_plan = '".sql_esc($date_baru)."' AND (shift_pps1 = '".sql_esc($shift_chkA)."' OR shift_pps2 = '".sql_esc($shift_chkA)."') ORDER BY date_plan DESC LIMIT ".sql_num($offset).", $rowsperpage ";
$result2 = mysqli_query($dbc,$sql2);
?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px #141414;">
              <tr>
                <th width="150" height="28" bgcolor="#000066"><span class="style6"><div align="center">MODULE</div></span></th> 
                <th width="100" bgcolor="#000066"><span class="style6"><div align="center">MODEL</div></span></th>
                <th width="150" height="28" bgcolor="#000066"><span class="style6"><div align="center">BACK NO.</div></span></th>
                <th width="250" height="28" bgcolor="#000066"><span class="style6"><div align="center">PART NUMBER</div></span></th>
                <th width="100" height="28" bgcolor="#000066"><span class="style6"><div align="center">STATUS</div></span></th>
                <th width="100" height="28" bgcolor="#000066"><span class="style6"><div align="center">PLAN</div></span></th>
                <th width="100" bgcolor="#000066"><span class="style6"><div align="center">ACTUAL</div></span></th>
                <th width="100" bgcolor="#000066"><span class="style6"><div align="center">REJECT</div></span></span></th>
                <th width="100" bgcolor="#000066"><span class="style6"><div align="center">PENDING</div></span></span></th>
                </tr>
          </table>


<?php
 $no = 1;
while ($list = mysqli_fetch_array($result2)) {




     //------------------------------------------------//shift	
		if($list["shift_pps1"] != "")
	{
		$sta = "D/S";
		
	}elseif($list["shift_pps2"] != "")
	 {
		$sta = "N/S";
	 }else{
		 
		$sta = " ";
	 }	
	 
	 //----------table material ------
	 
  $query_q2A = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($list["material_no"])."'";
  $result_q2A = mysqli_query($dbc,$query_q2A);
  $ans3A = mysqli_fetch_array($result_q2A);
  
  //-------model-----------------
  
  $query_model = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($ans3A["model_code"])."' AND material_type = '".sql_esc($ans3A["mat_type"])."'";
  $result_model = mysqli_query($dbc,$query_model);
  $data_model = mysqli_fetch_array($result_model);
  
  //-----material type material_type_tbl ---------
  
  $query_mtype = "SELECT * FROM material_type_tbl WHERE id = '".sql_esc($ans3A["mat_type"])."'";
  $result_mtype = mysqli_query($dbc,$query_mtype);
  $data_mtype = mysqli_fetch_array($result_mtype);
	 
   $qty_total_pend = 0.000;
   $qty_total_ok = 0.000;
   $qty_total_ng = 0.000;
   $qty_total_rework = 0.000;
   $qty_total_hwork = 0.000;
   
  
    //-----checking pps_trans entering output production Backflush OK
	
	   $query_bOK = "SELECT * FROM pps_detail_trn_fg_ok WHERE plan_no = '".sql_esc($list["plan_no"])."' AND (status_pps != '".sql_esc($rst_sta4["status_desc"])."') AND (status_pps != '".sql_esc($rst_sta6["status_desc"])."')";
	   $result_bOK = mysqli_query($dbc,$query_bOK);
	   
	   while($data_bOK = mysqli_fetch_array($result_bOK))
	   {
		 $qty_total_ok = ($qty_total_ok + $data_bOK["qty_actual"]);     
		   
	   }
       

     //-----checking BF NG entering output production
	   $query_bNG = "SELECT * FROM pps_detail_trn_fg_ng WHERE plan_no = '".sql_esc($list["plan_no"])."' AND (status_pps != '".sql_esc($rst_sta4["status_desc"])."') AND (status_pps != '".sql_esc($rst_sta6["status_desc"])."')";
	   $result_bNG = mysqli_query($dbc,$query_bNG);
	  
	   while($data_bNG = mysqli_fetch_array($result_bNG))
	   {
		
		$qty_total_ng = ($qty_total_ng + $data_bNG["qty_NG"]);    
	   }
	   
	    //-----checking BF Pending entering output production
	   $query_bPEND = "SELECT * FROM pps_detail_trn_fg_pending WHERE plan_no = '".sql_esc($list["plan_no"])."' AND (status_pps != '".sql_esc($rst_sta4["status_desc"])."') AND (status_pps != '".sql_esc($rst_sta6["status_desc"])."')";
	   $result_bPEND = mysqli_query($dbc,$query_bPEND);
	  
	   while($data_bPEND = mysqli_fetch_array($result_bPEND))
	   {
		
		$qty_total_pend = ($qty_total_pend + $data_bPEND["qty_actual"]);    
	   } 
	   
	   
	   
	     //-----checking BF Rework entering output production
	   $query_bRWK = "SELECT * FROM pps_detail_trn_fg_pending_confirm WHERE plan_no = '".sql_esc($list["plan_no"])."' AND (status_pps != '".sql_esc($rst_sta4["status_desc"])."') AND (status_pps != '".sql_esc($rst_sta6["status_desc"])."') AND status_butn = 'REWORK'";
	   $result_bRWK = mysqli_query($dbc,$query_bRWK);
	  
	   while($data_bRWK = mysqli_fetch_array($result_bRWK))
	   {
		
		$qty_total_rework = ($qty_total_rework + $data_bRWK["qty_REWORK"]);    
	   } 
	   
	   
	    //-----checking BF Handwork entering output production
	   $query_bHWORK = "SELECT * FROM pps_detail_trn_fg_hwork WHERE plan_no = '".sql_esc($list["plan_no"])."' AND (status_pps != '".sql_esc($rst_sta4["status_desc"])."') AND (status_pps != '".sql_esc($rst_sta6["status_desc"])."')";
	   $result_bHWORK = mysqli_query($dbc,$query_bHWORK);
	  
	   while($data_bHWORK = mysqli_fetch_array($result_bHWORK))
	   {
		
		$qty_total_hwork = ($qty_total_hwork + $data_bHWORK["qty_actual"]);    
	   } 	 
	 
	  //----model ---
  
 $query_Mod = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($list["work_center"])."' AND status_wc = 'Y' ORDER BY id ASC";
 $result_Mod = mysqli_query($dbc,$query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  
 
  if($row_Mod["wc_desc2"] == "")
  {
	  $model_name = $row_Mod["id_work"];
  }else{
	  
	 $model_name = $row_Mod["wc_desc2"]; 
  }
  
 
 
 
  
	  if($qty_total_ok > ($list["qty_plan"]))
	  {
	    $status_new = "COMPLETED";
		$msg_sta =  '<span class="badge badge-pill badge-success glow">'.$status_new.'</span>'; 	
	
	  }elseif($qty_total_ok == ($list["qty_plan"]))
	  {
	    $status_new = "COMPLETED";
		$msg_sta =  '<span class="badge badge-pill badge-success glow">'.$status_new.'</span>'; 	
	
	  }elseif($list["status_pps"] == $rst_sta7["status_desc"])
	   {
	    $status_new = "IN PROGRESS";
		$msg_sta =  '<span class="badge badge-pill badge-warning">'.$status_new.'</span>';  
	   
	   }elseif($list["status_pps"] == $rst_sta13["status_desc"])
	   {
		   
		 $status_new = "CLOSED";
		 $msg_sta =  '<span class="badge badge-pill badge-danger">'.$status_new.'</span>';    
		   
		   
	   }elseif($list["status_pps"] == $rst_sta["status_desc"])
	   {
		   
		$status_new = "NEW";
		$msg_sta =  '<span class="badge badge-pill badge-info">'.$status_new.'</span>';  
		
	   }elseif($list["status_pps"] == $rst_sta2["status_desc"])
	   {
		   
		$status_new = "NEW";
		$msg_sta =  '<span class="badge badge-pill badge-info">'.$status_new.'</span>';  
		
	   }else{
		   
		$status_new = "NEW";
		$msg_sta =  '<span class="badge badge-pill badge-info">'.$status_new.'</span>';     
		   
	   }

?>
  
  
<table width="100%" border="1" cellpadding="0" cellspacing="0"  style="border:solid 1px #141414;">
  <tr>
    <td width="150" height="36"><div align="center"><font size="+1" color="#FFFF00"><?php echo html_esc($row_Mod["wc_desc"]); ?></font></div></td>
    <td width="100"><div align="center"><font size="+1" color="#FFFF00"><?php echo html_esc($list["model_code"]); ?></font></div></td>
    <td width="150"><div align="center"><font size="+1" color="#FFFF00"><?php echo html_esc($list["back_no"]); ?></font></div></td>
    <td width="250"><div align="center"><font size="+1" color="#FFFF00"><?php echo html_esc($list["material_no"]); ?></font></div></td>
    <td width="100"><div align="center"><?php echo $msg_sta; ?></div></td>
    <td width="100"><div align="center"><font size="+1" color="#FFFF00"><?php echo (intval($list["qty_plan"])); ?>&nbsp;</font></div></td>
    <td width="100"><div align="center"><font size="+1" color="#FFFF00"><?php echo $qty_total_ok; ?></font></div></td>
    <td width="100"><div align="center"><font size="+1" color="#FFFF00"><?php echo $qty_total_ng; ?></font></div></td>
    <td width="100"><div align="center"><font size="+1" color="#FFFF00"><?php echo $qty_total_pend; ?></font></div></td>
  </tr>
</table>    
 <?php
   
 $no++;
} 
 

?>

   