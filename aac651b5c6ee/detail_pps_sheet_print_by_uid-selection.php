<?php

session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

$query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
$result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
$res = mysqli_fetch_array($result2);

$url = "detail_pps_month_reprint.php"; 
require_once('tcpdf_barcodes_2d.php');


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

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

//CR status (Cancel)
$sta21 = "SELECT * from request_status WHERE status_id = '21'";
$sta_res21 = mysqli_query($dbc,$sta21);
$rst_sta21 = mysqli_fetch_array($sta_res21);

//CR status (Close)
$sta22 = "SELECT * from request_status WHERE status_id = '22'";
$sta_res22 = mysqli_query($dbc,$sta22);
$rst_sta22 = mysqli_fetch_array($sta_res22);

$extension = explode ('.', $data_setup["logo_name"]);
$filename = $data_setup["logo_comp"].'.'.$extension[1];
		
$prtid = $_GET["id"];

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   
 	<link rel="stylesheet" type="text/css" href="css/prt-sheet.css">
  
	<style media="print">
    @media print {
		panel 
		{
			/*page-break-after: always;*/
		}
		.prt-button 
		{ 
			display: none; 
		}
		.tblspace
		{ 
			display: none; 
		}	
    }
    
    @page {
    margin: 10mm 10mm 10mm 0;
	size: landscape;
	margin-left: 30px;
    }
    
    /*.forPrint{
    page-break-after: always;
    }*/
	
	.forPrint2{
	page-break-before:always;
	}
	
	.prt-button {
		position: fixed;
		bottom: 10px;
		right: 310px; 
	}
    
    </style>

    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    


</head>
<body>

<?php
	
$query_pps = "SELECT * FROM prt_sheet_pps_new WHERE doc_generate='".sql_esc($prtid)."' GROUP BY work_center,date_plan ORDER BY date_plan ASC";
$result_pps = mysqli_query($dbc,$query_pps);

while($dt_pps = mysqli_fetch_array($result_pps))
{	
	$prt_HDR = "SELECT *,DATE_FORMAT(PS.date_plan,'%d-%m-%Y') AS H FROM pps_detail as PS WHERE id = '".sql_esc($dt_pps['id_pps_dtl'])."' ";
	$resprt_HDR = mysqli_query($dbc,$prt_HDR);
	$dtprt_HDR = mysqli_fetch_array($resprt_HDR);
	
?>

<!--table full-->
<!--<table width="100%" border="3" style="border:#B7B7B7">
  <tr>
    <td>-->
     <?php
    //$query_pps2 = "SELECT * FROM pps_detail_test where doc_generate='2380000040' and work_center = '$dt_pps[work_center]' ";
    $query_pps2 = "SELECT * FROM prt_sheet_pps_new where doc_generate='".sql_esc($dt_pps['doc_generate'])."' and work_center = '".sql_esc($dt_pps['work_center'])."' and date_plan = '".sql_esc($dt_pps['date_plan'])."' ";
    $result_pps2 = mysqli_query($dbc,$query_pps2);
    
    $counter = 1;
    $no = 1;
    $i = 1; 
    $k =1;
    
    $datarows = 0;
	$datatotal = 3; //total row per header
	$slip_pg = 1;
	$mumy2 = 1;
	
    while($dt_pps2 = mysqli_fetch_array($result_pps2))
    {
        
        /*$prt_pps = "SELECT *,DATE_FORMAT(MR.date_plan,'%d-%m-%Y') AS T, DATE_FORMAT(MR.date_plan,'%d%m%Y') AS T2, DATE_FORMAT(MR.date_upload,'%d-%m-%Y %H:%i:%s') AS K 
						FROM pps_detail_test AS MR, work_center_detail AS SR, prt_sheet_pps_new AS PN  
							WHERE MR.id = '$dt_pps2[id_pps_dtl]' AND PN.id_pps_dtl = MR.id AND SR.id_work = MR.work_center AND MR.work_center = '".$dt_pps2["work_center"]."' 
								AND MR.status_pps = '".$rst_sta["status_desc"]."' ";*/
		$prt_pps = "SELECT *, DATE_FORMAT(MR.date_plan,'%d-%m-%Y') AS T, DATE_FORMAT(MR.date_plan,'%d%m%Y') AS T2, DATE_FORMAT(MR.date_upload,'%d-%m-%Y %H:%i:%s') AS K, DATE_FORMAT(MR.work_hours,'%H:%i') AS T5  
						FROM pps_detail AS MR 
							WHERE MR.id = '".sql_esc($dt_pps2['id_pps_dtl'])."' AND MR.status_pps = '".sql_esc($rst_sta["status_desc"])."' ";
        $resprt_pps = mysqli_query($dbc,$prt_pps);
        $dtprt_pps = mysqli_fetch_array($resprt_pps);
		
		//---------get user upload -------------
		
		$query_upld = "SELECT * FROM user_detail WHERE staff_ID = '".sql_esc($dtprt_HDR["user_upload"])."'";
		$result_upld = mysqli_query($dbc,$query_upld);
        $data_upld = mysqli_fetch_array($result_upld);	
		
		//---------get user released -------------
		
		$query_rels = "SELECT * FROM user_detail WHERE staff_ID = '".sql_esc($dtprt_HDR["user_update"])."'";
		$result_rels = mysqli_query($dbc,$query_rels);
        $data_rels = mysqli_fetch_array($result_rels);	
		
        $name_aprv = "Wan Amer Faisal Wan Omar";
		
         //---------get material header---------
      	
		$query_mat_h = "SELECT * FROM table_material_itsb WHERE material_no = '". sql_esc($dtprt_pps['material_no'])."'";
        $result_mat_h = mysqli_query($dbc,$query_mat_h);
        $data_mat_h = mysqli_fetch_array($result_mat_h);	
		
		$no = sprintf('%03d', $no);
		 
		if($dtprt_pps["shift_pps1"] != "")
		{
			$sta = "D/S";
		}
		elseif($dtprt_pps["shift_pps2"] != "")
		{
			$sta = "N/S";
		}
		else
		{
			$sta = " ";
		}	
		
	     
		  if($dtprt_pps["work_hours"] != "00:00:00")
		  {
			$time_new =  $dtprt_pps["T5"];  
			  
		  }else{
			$time_new = "";  
		  }	
		  
		 //----model ---
		  
		 $query_Mod = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($dtprt_HDR["work_center"])."' AND plant_code = '".sql_esc($dtprt_HDR["plant_code"])."' AND status_wc = 'Y' ORDER BY id ASC";
		 $result_Mod = mysqli_query($dbc,$query_Mod);
		 $row_Mod = mysqli_fetch_array($result_Mod);  
		 
		  if($row_Mod["wc_desc2"] == "")
		  {
			  $model_name = $row_Mod["id_work"];
		  }else{
			  
			 $model_name = $row_Mod["wc_desc2"]; 
		  }   
		  
		  
		  
		  
		  

		if ($datarows % $datatotal == 0) { //repeat after nth row   
		
	
	//----------calculation page --------------//
	  $rowcount = mysqli_num_rows($result_pps2);
      $jum_page = ($rowcount / $datatotal);
	
	
	//-----total of page -----
	if(($jum_page) <= 1)
	{
	 $fnum_pg = '1';
	 	
	}elseif(($jum_page) > 1)
	{
	 $fnum_pg = (intval($jum_page) + 1);	
	 
	}else{
		
		
	}
	
	
	
				
    ?> 
    
     <!--space-->
    <div class="tblspace">
	<table border="0" width="100%"><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr></table>
    </div>
    <!--space-->
    
    <div class="forPrint2">  <!--PRINT VIEW---> 
    <!--row header-->
    <table width="100%" border="1" style="border:#B7B7B7">
      <tr>
        <td width="26%" colspan="3" > <img src="../set_upload/<?php echo $filename;  ?>" width="350" height="50"/></td>
        <td width="41%" rowspan="2" class="sheetName">Production Planning Sheet</td>
        <td width="25%" colspan="3">
        
        <!--header Doc no-->
        <table width="100%" class="tblHeader">
        <thead>
          <tr>
            <td width="38%">Doc No. </td>
            <td width="6%">:</td>
            <td width="52%">&nbsp;</td>
          </tr>
          <tr>
            <td width="38%">Rev. No.</td>
            <td width="6%">:</td>
            <td width="52%">&nbsp;</td>
          </tr>
          <tr>
            <td width="38%"> Date</td>
            <td width="6%">:</td>
            <td width="52%">&nbsp;</td>
          </tr>
          </thead>
        </table>
        <!--/n header Doc no-->        </td>
      </tr>
      
      <tr>
        <td colspan="3" width="36%">
        <!--header plant-->
        <table width="100%" class="tblHeader">
        <thead>
          <tr>
            <td width="26%">Plant</td>
            <td width="6%">:</td>
            <td width="54%"><?php echo $dtprt_HDR["plant_code"]; ?></td>
          </tr>
          <tr>
            <td width="25%">Production Line</td>
            <td width="6%">:</td>
            <td width="54%"><?php echo $model_name; ?></td>
          </tr>
         </thead>
        </table>
        <!--/n header plant-->        </td>
        <td colspan="3" width="30%">
        <!--header month -->
        <table width="100%" class="tblHeader">
        <thead>
          <tr>
            <td width="8%">Month/Year</td>
            <td width="8%">:</td>
            <td width="52%"><?php echo $dtprt_HDR["month_plan"]; ?>/ <?php echo $dtprt_HDR["year_plan"]; ?></td>
          </tr>
          <tr>
            <td width="38%">Date</td>
            <td width="8%">:</td>
            <td width="52%"><?php echo $dtprt_HDR["H"]; ?></td>
          </tr>
          <tr>
            <td width="38%">Page</td>
            <td width="8%">:</td>
            <td width="52%">&nbsp;<?php echo $mumy2; ?> of <?php echo $fnum_pg; ?></td>
          </tr>
          </thead>
        </table>
        <!--/n header month --></td>
      </tr>
    </table>
    <!--/n row header-->
    </td>
  </tr>
    
  <tr>
    <td>
    <!--row record-->
    <!--<table width="100%"  class="tblRecord">
    
    	<thead>
        <tr>
            <th>No.</th>
            <th>Model</th>
            <th>Part No. / Part Name</th>
            <th>Planned Order No.</th>
            <th>Planned Start Date</th>
            <th>Shift</th>
            <th>Seq #</th>
            <th>Planned Order Quantity</th>
            <th>UOM</th>
            <th>QR Code</th>
            <th>Status</th>
            <th>Remarks</th>
        </tr>
       </thead>-->

      	<!--row record-->
    	<table width="100%" class="tblRecord">
    
    	<thead>
        <tr>
            <th>No. </th>
            <th>Part No. / Part Name </th>
            <th>Planned Order No.</th>
            <th>Planned Start Date</th>
            <th>Planned Start Time</th>
            <th>Shift</th>
            <th>Seq #</th>
            <th>Planned Quantity</th>
            <th>UOM</th>
            <th>QR Code</th>
            <th>Status</th>
            <th>Remarks</th>
        </tr>
       </thead>
       
       <tbody>
	   <?php } 
	 
		
		
	   
	   if($rowcount<=$datatotal)
	{
		$num_pages = 1;
	}
	elseif(($rowcount % $datatotal) == 0)
	{
		$num_pages =($rowcount/$datatotal) ;
	}
	else
	{
		$num_pages = ($rowcount/$datatotal)+1;
		$num_pages = (int)$num_pages;
	}	
		
		
		//echo $num_pages;
		//$k = 1;
		
		if ($k && $k % 3 == 0)  
		{
		$slip_pg = ($k + 1);
		
		}elseif ($k)
		{  
		
		$slip_pg = $k;	
		
	    
		}$k++;
		
		$mumy = ($slip_pg/$num_pages);
		$mumy2 = (intval($mumy));
		//$mumy2 = (round($mumy) + 1);
		
		
	     
		//echo ($mumy);
		//echo intval($mumy);

	 ?>
    
        <tr>
            <td width="5%"><?php  echo $no; ?></td>
        <!--    <td width="7%"><?php //echo $dtprt_pps['model_code']; ?></td> -->
            <td width="25%"><b><?php echo $dtprt_pps["material_no"]; ?></b><br/><?php echo $data_mat_h["material_desc"]; ?>
              <br>[Std Pack: <?php echo $data_mat_h["std_packaging"].'&nbsp;'.$data_mat_h["BUn"]; ?>]</td>
            <td width="11%" height="28"><?php echo $dtprt_pps["plan_no"]; ?></td>
            <td width="10%" height="28"><?php  echo $dtprt_pps["T"]; ?></td>
            <td width="10%" height="28"><?php  echo $time_new; ?></td>
            <td width="5%" height="28"><font color="#FF0000"><?php echo $sta; ?></font></td>
            <td width="5%"><?php echo $dtprt_pps["seq_pps"]; ?></td>
            <td width="6%" height="28"><?php  echo intval($dtprt_pps["qty_plan"]); ?></td>
            <td width="5%" height="28"><font color="#FF0000"><?php echo $data_mat_h["BUn"]; ?></font></td>
            <td width="10%" height="100">&nbsp;&nbsp;</td>
            <td width="8%" height="28"><?php echo $dtprt_pps["status_pps"]; ?></td>
            <td width="13%" height="28"></td>
		</tr>
        <tr>
        <td colspan="12">&nbsp;</td>
        </tr>
        
	<?php
   
	$datarows++;  
	$counter++; // menambah counter 
	$no++; 
	$slip_pg++;
    
    } //n while loop record 
	
   
	
	
	
	?>
    </tbody>
    </table> 
 
   </div> <!--/n PRINT VIEW---> 
  
    <!--/n row record -->
   <!-- </td>
  </tr>
  
</table>-->
<!--/n table full-->
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td width="34%" height="50"><div align="center">&nbsp;<b>Uploaded by</b><br>
    <?php echo $data_upld["user_fullname"];    ?>
    </div></td>
    <td width="33%"><div align="center">&nbsp;<b>Approved by</b><br>
    <?php echo $name_aprv;   ?></div></td>
    <td width="33%"><div align="center">&nbsp;<b>Released by</b><br>
    <?php //echo $data_rels["user_fullname"];   ?></div></td>
  </tr>
</table>

<?php
}//n while grouping	 
?>

<br/>
<!--button print-->
<div class="prt-button">
  <button type="button" name="btn_release" id="btn_release" class="btn btn-success btn-sm" onClick="window.print()">Print this Page</button>
</div>

</body>
</html>