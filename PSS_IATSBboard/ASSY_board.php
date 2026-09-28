<?php 
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include 'include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');

$Cdate = date("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));
$masa = (date("H:m:s"));

$query_shtA = "SELECT * FROM shift_detail WHERE id_shift = '1'";
$result_shtA = mysqli_query($dbc, $query_shtA);
$data_shtA = mysqli_fetch_array($result_shtA);

//----shift posting ----
if (($masa >= $data_shtA["time_start"]) && ($masa <= $data_shtA["time_end"])) {
   $shif_pA = "Day";
   $shift_chkA = "D/S";
} else {
   $shif_pA = "Night";
   $shift_chkA = "N/S";
}

//$Cdate = date ("l, j F Y ");
//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc, $query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

set_time_limit(0);

$nextpage = 1;

//CR status (New)
$sta = "SELECT * from request_status WHERE status_id = '1'";
$sta_res = mysqli_query($dbc, $sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2'";
$sta_res2 = mysqli_query($dbc, $sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);

//CR status (Approved)
$sta3 = "SELECT * from request_status WHERE status_id = '3'";
$sta_res3 = mysqli_query($dbc, $sta3);
$rst_sta3 = mysqli_fetch_array($sta_res3);

//CR status (Cancelled)
$sta4 = "SELECT * from request_status WHERE status_id = '4'";
$sta_res4 = mysqli_query($dbc, $sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);

//CR status (Draft)
$sta6 = "SELECT * from request_status WHERE status_id = '6'";
$sta_res6 = mysqli_query($dbc, $sta6);
$rst_sta6 = mysqli_fetch_array($sta_res6);

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc, $sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

//CR status (Pending)
$sta8 = "SELECT * from request_status WHERE status_id = '8'";
$sta_res8 = mysqli_query($dbc, $sta8);
$rst_sta8 = mysqli_fetch_array($sta_res8);

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13'";
$sta_res13 = mysqli_query($dbc, $sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc, $sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc, $sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

//CR status (Transfer QC)
$sta18 = "SELECT * from request_status WHERE status_id = '18'";
$sta_res18 = mysqli_query($dbc, $sta18);
$rst_sta18 = mysqli_fetch_array($sta_res18);

//CR status (Cancel)
$sta21 = "SELECT * from request_status WHERE status_id = '21'";
$sta_res21 = mysqli_query($dbc, $sta21);
$rst_sta21 = mysqli_fetch_array($sta_res21);

//CR status (Close)
$sta22 = "SELECT * from request_status WHERE status_id = '22'";
$sta_res22 = mysqli_query($dbc, $sta22);
$rst_sta22 = mysqli_fetch_array($sta_res22);

include 'contentASSY.php';

$today = getdate();
$hours = $today['hours'];
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$month = $today['mon'];
$mday = $today['mday'];
$year = $today['year'];
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
   <style>
      body {
         background-color: #000000;
      }

      .style6 {
         color: #ffffff;
         font-size: 18px;
      }

      .style16 {
         color: #0F0;
         font-size: 24px;
      }

      .wa-padding {
         padding: 10px;
      }

      .wa-style {
         color: #FFFF00;
         text-align: center;
         font-size: 18px;
      }

      .center {
         text-align: center;
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
   </style>
</head>
<body>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #141414;">
      <tr>
         <td width="500">&nbsp;<h2><img src="images/logo_n.gif" width="400" height="45" alt="IATSB"></h2>
         </td>
         <td width="200">&nbsp;<span class="style16"><?php echo date("l M d, Y");   ?></span></td>
         <td width="200">&nbsp;&nbsp;&nbsp;<span class="style16"> <?php echo date("H:i:s");  ?></span></td>

      </tr>
      <tr>
         <td>&nbsp;<span class="style16">PRODUCTION : WELDING ASSEMBLY</span></td>
         <td>&nbsp;<span class="style16">SHIFT : <?php echo $shif_pA;  ?></span></td>
         <td>&nbsp;<span class="style16">PAGE : &nbsp;<?php echo $currentpage . ' OF ' . $totalpages; ?></span></td>
      </tr>
   </table>

   <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:solid 1px #141414;">
      <thead>
         <tr bgcolor="#000066" align="center" height="28" class="style6">
            <th width="150">MODULE</th>
            <th width="100">MODEL</th>
            <th width="150">BACK NO.</th>
            <th width="250">PART NUMBER</th>
            <th width="100">STATUS</th>
            <th width="100">PLAN</th>
            <th width="100">ACTUAL</th>
            <th width="100">REJECT</th>
            <th width="100">PENDING</th>
         </tr>
      </thead>
      <tbody>
         <?php 
         //--- shift detail ------
         $query_sht_checking = "SELECT * FROM shift_detail WHERE id_shift = '1'";
         $result_sht_checking = mysqli_query($dbc, $query_sht_checking);
         $data_sht_checking = mysqli_fetch_array($result_sht_checking);

         //----shift posting ----
         $prev_date = date('Y-m-d', strtotime($currentdate . ' -1 day'));

         if (($masa >= $data_sht_checking["time_start"]) && ($masa <= $data_sht_checking["time_end"])) {
            $date_baru = $currentdate;
         } else {
            if (($masa >= '00:00:00') && ($masa <= '07:59:00')) {
               $date_baru = $prev_date;
            } else {
               $date_baru = $currentdate;
            }
         }

         $table = "";

         # ------------------------------------------------- Group table by `Module` -------------------------------------------------
         $sqlPPS = "SELECT DISTINCT work_center FROM pps_detail WHERE plan_category = 'ASSY' AND (status_pps != '".sql_esc($rst_sta4['status_desc'])."') AND (status_pps != '".sql_esc($rst_sta13['status_desc'])."') AND status = 'Y' AND date_plan = '".sql_esc($date_baru)."' AND (shift_pps1 = '".sql_esc($shift_chkA)."' OR shift_pps2 = '".sql_esc($shift_chkA)."') ORDER BY date_plan DESC LIMIT ".sql_num($offset).", $rowsperpage";
         $resPPS = mysqli_query($dbc, $sqlPPS);
         while ($rowPPS  = mysqli_fetch_array($resPPS)) { 
            //----model ---
            $query_Mod = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($rowPPS['work_center'])."' AND status_wc = 'Y'";
            $result_Mod = mysqli_query($dbc, $query_Mod);
            $row_Mod = mysqli_fetch_array($result_Mod); 
            
            //----Count no of materials/part no by Module---
            $countM = mysqli_num_rows(mysqli_query($dbc, "SELECT * FROM pps_detail WHERE work_center = '".sql_esc($rowPPS['work_center'])."' AND plan_category = 'ASSY' AND (status_pps != '".sql_esc($rst_sta4['status_desc'])."') AND (status_pps != '".sql_esc($rst_sta13['status_desc'])."') AND status = 'Y' AND date_plan = '".sql_esc($date_baru)."' AND (shift_pps1 = '".sql_esc($shift_chkA)."' OR shift_pps2 = '".sql_esc($shift_chkA)."')")); 
            
            $table .= "<tr>";
            $table .= "<td rowspan='" .$countM. "' class='wa-padding wa-style'>" .$row_Mod['wc_desc']. "</td>";
               
            $trCheck2 = 0;

            # ------------------------------------------------- Group table by `Model` -------------------------------------------------
            $sqlPPS2 = "SELECT DISTINCT model_code FROM pps_detail WHERE work_center = '".sql_esc($rowPPS['work_center'])."' AND plan_category = 'ASSY' AND (status_pps != '".sql_esc($rst_sta4['status_desc'])."') AND (status_pps != '".sql_esc($rst_sta13['status_desc'])."') AND status = 'Y' AND date_plan = '".sql_esc($date_baru)."' AND (shift_pps1 = '".sql_esc($shift_chkA)."' OR shift_pps2 = '".sql_esc($shift_chkA)."') ORDER BY date_plan";
            $resPPS2 = mysqli_query($dbc, $sqlPPS2);
            while ($rowPPS2 = mysqli_fetch_array($resPPS2)) {
               //----Count no of materials/part no by Model---
               $countM2 = mysqli_num_rows(mysqli_query($dbc, "SELECT * FROM pps_detail WHERE work_center = '".sql_esc($rowPPS['work_center'])."' AND model_code = '".sql_esc($rowPPS2['model_code'])."' AND plan_category = 'ASSY' AND (status_pps != '".sql_esc($rst_sta4['status_desc'])."') AND (status_pps != '".sql_esc($rst_sta13['status_desc'])."') AND status = 'Y' AND date_plan = '".sql_esc($date_baru)."' AND (shift_pps1 = '".sql_esc($shift_chkA)."' OR shift_pps2 = '".sql_esc($shift_chkA)."')")); 
                  
               if ($trCheck2 == 1) {
                  $table .= "<tr>";
               } 

               $table .= "<td rowspan='" .$countM2. "' class='wa-padding wa-style'>" .$rowPPS2['model_code']. "</td>";

               $trCheck = 0;

               # ------------------------------------------------- Table details starts here -------------------------------------------------
               $sqlData = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') AS R FROM pps_detail WHERE work_center = '".sql_esc($rowPPS['work_center'])."' AND model_code = '".sql_esc($rowPPS2['model_code'])."' AND plan_category = 'ASSY' AND (status_pps != '".sql_esc($rst_sta4['status_desc'])."') AND (status_pps != '".sql_esc($rst_sta13['status_desc'])."') AND status = 'Y' AND date_plan = '".sql_esc($date_baru)."' AND (shift_pps1 = '".sql_esc($shift_chkA)."' OR shift_pps2 = '".sql_esc($shift_chkA)."') ORDER BY date_plan DESC";
               $resData = mysqli_query($dbc, $sqlData);
               while ($rowData = mysqli_fetch_array($resData)) {
                  // --------------------- Shift   --------------------- 	
                  if ($rowData["shift_pps1"] != "") {
                     $sta = "D/S";
                  } elseif ($rowData["shift_pps2"] != "") {
                     $sta = "N/S";
                  } else {
                     $sta = " ";
                  }

                  // --------------------- Material --------------------- 
                  $query_q2A  = "SELECT * FROM table_material_itsb WHERE material_no = '" . sql_esc($rowData["material_no"]) . "'";
                  $result_q2A = mysqli_query($dbc, $query_q2A);
                  $ans3A      = mysqli_fetch_array($result_q2A);

                  // --------------------- Model    --------------------- 
                  $query_model   = "SELECT * FROM model_detail_tbl WHERE id_model = '" . sql_esc($ans3A["model_code"]) . "' AND material_type = '" . sql_esc($ans3A["mat_type"]) . "'";
                  $result_model  = mysqli_query($dbc, $query_model);
                  $data_model    = mysqli_fetch_array($result_model);

                  // --------------------- Material Type ----------------
                  $query_mtype   = "SELECT * FROM material_type_tbl WHERE id = '" . sql_esc($ans3A["mat_type"]) . "'";
                  $result_mtype  = mysqli_query($dbc, $query_mtype);
                  $data_mtype    = mysqli_fetch_array($result_mtype);

                  $qty_total_pend = 0.000;
                  $qty_total_ok = 0.000;
                  $qty_total_ng = 0.000;
                  $qty_total_rework = 0.000;
                  $qty_total_hwork = 0.000;

                  // ----- Check pps_trans entering output production Backflush OK
                  $query_bOK = "SELECT * FROM pps_detail_trn_fg_ok WHERE plan_no = '" . sql_esc($rowData["plan_no"]) . "' AND (status_pps != '" . sql_esc($rst_sta4["status_desc"]) . "') AND (status_pps != '" . sql_esc($rst_sta6["status_desc"]) . "')";
                  $result_bOK = mysqli_query($dbc, $query_bOK);
                  while ($data_bOK = mysqli_fetch_array($result_bOK)) {
                     $qty_total_ok = ($qty_total_ok + $data_bOK["qty_actual"]);
                  }

                  // ----- Check BF NG entering output production
                  $query_bNG = "SELECT * FROM pps_detail_trn_fg_ng WHERE plan_no = '" . sql_esc($rowData["plan_no"]) . "' AND (status_pps != '" . sql_esc($rst_sta4["status_desc"]) . "') AND (status_pps != '" . sql_esc($rst_sta6["status_desc"]) . "')";
                  $result_bNG = mysqli_query($dbc, $query_bNG);
                  while ($data_bNG = mysqli_fetch_array($result_bNG)) {
                     $qty_total_ng = ($qty_total_ng + $data_bNG["qty_NG"]);
                  }

                  // ----- Check BF Pending entering output production
                  $query_bPEND = "SELECT * FROM pps_detail_trn_fg_pending WHERE plan_no = '" . sql_esc($rowData["plan_no"]) . "' AND (status_pps != '" . sql_esc($rst_sta4["status_desc"]) . "') AND (status_pps != '" . sql_esc($rst_sta6["status_desc"]) . "')";
                  $result_bPEND = mysqli_query($dbc, $query_bPEND);
                  while ($data_bPEND = mysqli_fetch_array($result_bPEND)) {
                     $qty_total_pend = ($qty_total_pend + $data_bPEND["qty_actual"]);
                  }

                  // ----- Check BF Rework entering output production
                  $query_bRWK = "SELECT * FROM pps_detail_trn_fg_pending_confirm WHERE plan_no = '" . sql_esc($rowData["plan_no"]) . "' AND (status_pps != '" . sql_esc($rst_sta4["status_desc"]) . "') AND (status_pps != '" . sql_esc($rst_sta6["status_desc"]) . "') AND status_butn = 'REWORK'";
                  $result_bRWK = mysqli_query($dbc, $query_bRWK);
                  while ($data_bRWK = mysqli_fetch_array($result_bRWK)) {
                     $qty_total_rework = ($qty_total_rework + $data_bRWK["qty_REWORK"]);
                  }

                  // ----- Check BF Handwork entering output production
                  $query_bHWORK = "SELECT * FROM pps_detail_trn_fg_hwork WHERE plan_no = '" . sql_esc($rowData["plan_no"]) . "' AND (status_pps != '" . sql_esc($rst_sta4["status_desc"]) . "') AND (status_pps != '" . sql_esc($rst_sta6["status_desc"]) . "')";
                  $result_bHWORK = mysqli_query($dbc, $query_bHWORK);
                  while ($data_bHWORK = mysqli_fetch_array($result_bHWORK)) {
                     $qty_total_hwork = ($qty_total_hwork + $data_bHWORK["qty_actual"]);
                  }

                  // --------------------- Model    ---------------------
                  $query_Mod = "SELECT * FROM work_center_detail WHERE id_work = '" . sql_esc($rowData["work_center"]) . "' AND status_wc = 'Y' ORDER BY id ASC";
                  $result_Mod = mysqli_query($dbc, $query_Mod);
                  $row_Mod = mysqli_fetch_array($result_Mod);

                  if ($row_Mod["wc_desc2"] == "") {
                     $model_name = $row_Mod["id_work"];
                  } else {
                     $model_name = $row_Mod["wc_desc2"];
                  }

                  if ($qty_total_ok > ($rowData["qty_plan"])) {
                     $status_new = "COMPLETED";
                     $msg_sta =  '<span class="badge badge-pill badge-success glow">' . $status_new . '</span>';
                  } elseif ($qty_total_ok == ($rowData["qty_plan"])) {
                     $status_new = "COMPLETED";
                     $msg_sta =  '<span class="badge badge-pill badge-success glow">' . $status_new . '</span>';
                  } elseif ($rowData["status_pps"] == $rst_sta7["status_desc"]) {
                     $status_new = "IN PROGRESS";
                     $msg_sta =  '<span class="badge badge-pill badge-warning">' . $status_new . '</span>';
                  } elseif ($rowData["status_pps"] == $rst_sta13["status_desc"]) {
                     $status_new = "CLOSED";
                     $msg_sta =  '<span class="badge badge-pill badge-danger">' . $status_new . '</span>';
                  } elseif ($rowData["status_pps"] == $rst_sta["status_desc"]) {
                     $status_new = "NEW";
                     $msg_sta =  '<span class="badge badge-pill badge-info">' . $status_new . '</span>';
                  } elseif ($rowData["status_pps"] == $rst_sta2["status_desc"]) {
                     $status_new = "NEW";
                     $msg_sta =  '<span class="badge badge-pill badge-info">' . $status_new . '</span>';
                  } else {
                     $status_new = "NEW";
                     $msg_sta =  '<span class="badge badge-pill badge-info">' . $status_new . '</span>';
                  }

                  if ($trCheck == 1) {
                     $table .= "<tr>";
                  }
                  
                  $table .= "<td class='wa-padding wa-style'>" .$rowData['back_no']. "</td>";
                  $table .= "<td class='wa-padding wa-style'>" .$rowData['material_no']. "</td>";
                  $table .= "<td class='wa-padding center'>" .$msg_sta. "</td>";
                  $table .= "<td class='wa-padding wa-style'>" .(intval($rowData["qty_plan"])). "</td>";
                  $table .= "<td class='wa-padding wa-style'>" .$qty_total_ok. "</td>";
                  $table .= "<td class='wa-padding wa-style'>" .$qty_total_ng. "</td>";
                  $table .= "<td class='wa-padding wa-style'>" .$qty_total_pend. "</td>";
                  $table .= "</tr>";
                  $trCheck = 1;
               }
               $trCheck2 = 1;
            }
            $table .= "</tr>";
         } 
         
         echo $table;?>
         
      </tbody>
   </table>
</body>
</html>