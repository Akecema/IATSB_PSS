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
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
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
   
 
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    <script language="javascript">


$(document).ready(function(){
	$(document).on('click', '#btnPrint', function(){
  	$('.printMe').printElem();
  });
});

</script>

<style>

	.prt-button {
		position: fixed;
		bottom: 10px;
		right: 10px; 
	}

	
	</style>

    <style type="text/css" media="print"> 
.breakAfter{ 
page-break-after: always; 
}
.breakBefore{
page-break-before: always ;
}
.tfoot { display: table-footer-group; }
.page {

    margin: 10mm 10mm 10mm 0;
	size: landscape;
	margin-left: 30px;
    bottom: 0;
}

  .breakAfter{ 
page-break-after: always; 
}
.breakBefore{
page-break-before: always ;
}

	
@media print {
    body.modalprinter * {
        visibility: hidden;
    }

    body.modalprinter .modal-dialog.focused {
        position: absolute;
        padding: 0;
        margin: 0;
        left: 0;
        top: 0;
    }

    body.modalprinter .modal-dialog.focused .modal-content {
        border-width: 0;
    }

    body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title,
    body.modalprinter .modal-dialog.focused .modal-content .modal-body,
    body.modalprinter .modal-dialog.focused .modal-content .modal-body * {
        visibility: visible;
    }

    body.modalprinter .modal-dialog.focused .modal-content .modal-header,
    body.modalprinter .modal-dialog.focused .modal-content .modal-body {
        padding: 0;
    }

    body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title {
        margin-bottom: 20px;
    }
   
    .prt-button 
		{ 
			display: none; 
		}
}

</style> 

  </head>
    <body class="app sidebar-mini">

  <?php
  
           $id = base64_decode($_GET["id"]);
		   
		   
		//********** END CONDITION **************

$queryu2 = "SELECT *, DATE_FORMAT(MR.date_plan,'%d-%m-%Y') AS T, DATE_FORMAT(MR.date_plan,'%d%m%Y') AS T2, DATE_FORMAT(MR.date_upload,'%d-%m-%Y %H:%i:%s') AS K, DATE_FORMAT(MR.work_hours,'%h:%i') AS T5 FROM pps_detail AS MR WHERE MR.id = '".sql_esc($id)."' AND MR.status_pps = '".sql_esc($rst_sta2["status_desc"])."' GROUP BY MR.work_center";


/*$queryu2 = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') AS T, DATE_FORMAT(date_upload,'%d-%m-%Y %H:%i:%s') AS K from pps_detail WHERE upload_id = '".$row["upload_id"]."' GROUP BY work_center";*/
$rs2 = mysqli_query($dbc,$queryu2);   //run the query.

 while($db_rs2 = mysqli_fetch_array($rs2))
   {
	   if($db_rs2["month_plan"] == "01")
	{
      $bulan_text = "January";
	}elseif($db_rs2["month_plan"] == "02")
	{
	  $bulan_text = "February";
	  
    }elseif($db_rs2["month_plan"] == "03")
	{
	  $bulan_text = "March";
	}elseif($db_rs2["month_plan"] == "04")
	{
	  $bulan_text = "April";
	}elseif($db_rs2["month_plan"] == "05")
	{
	  $bulan_text = "May";
	}elseif($db_rs2["month_plan"] == "06")
	{
	  $bulan_text = "June";
	}elseif($db_rs2["month_plan"] == "07")
	{
	  $bulan_text = "July";
	}elseif($db_rs2["month_plan"] == "08")
	{
	  $bulan_text = "August";
	}elseif($db_rs2["month_plan"] == "09")
	{
	  $bulan_text = "September";
	}elseif($db_rs2["month_plan"] == "10")
	{
	  $bulan_text = "October";
	}elseif($db_rs2["month_plan"] == "11")
	{
	  $bulan_text = "November";
	}elseif($db_rs2["month_plan"] == "12")
	{
	  $bulan_text = "December";
	}else{
		$bulan_text = "Others";
	}
	
	$extension = explode ('.', $data_setup["logo_name"]);
    $filename = $data_setup["logo_comp"].'.'.$extension[1];
	
	//--------------get filename from table ftp_pps
 
 $query_ftp_pps = "SELECT * FROM ftp_pps WHERE upload_id = '".sql_esc($db_rs2["upload_id"])."'";
 $result_ftp_pps = mysqli_query($dbc,$query_ftp_pps);
 $data_ftp_pps = mysqli_fetch_array($result_ftp_pps);  
 
 //---------get user upload -------------
		
		$query_upld = "SELECT * FROM user_detail WHERE staff_ID = '".sql_esc($db_rs2["user_upload"])."'";
		$result_upld = mysqli_query($dbc,$query_upld);
        $data_upld = mysqli_fetch_array($result_upld);	
		
		//---------get user released -------------
		
		$query_rels = "SELECT * FROM user_detail WHERE staff_ID = '".sql_esc($db_rs2["user_update"])."'";
		$result_rels = mysqli_query($dbc,$query_rels);
    $data_rels = mysqli_fetch_array($result_rels);	

        $query_plan_apprv = "SELECT * FROM function_apprv_pss_sht WHERE plant_code = '".sql_esc($db_rs2["plant_code"])."'";
		    $result_plan_apprv = mysqli_query($dbc,$query_plan_apprv);
        $data_plan_apprv = mysqli_fetch_array($result_plan_apprv);	
		
		$name_aprv = "IKhwan HuHuHu";
		
		
		
		 //----model ---
		  
		 $query_Mod = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($db_rs2["work_center"])."' AND plant_code = '".sql_esc($db_rs2["plant_code"])."' AND status_wc = 'Y' ORDER BY id ASC";
		 $result_Mod = mysqli_query($dbc,$query_Mod);
		 $row_Mod = mysqli_fetch_array($result_Mod);  
		 
		  if($row_Mod["wc_desc2"] == "")
		  {
			  $model_name = $row_Mod["id_work"];
		  }else{
			  
			 $model_name = $row_Mod["wc_desc2"]; 
		  }   
		    
		
 ?>

<div class="page">
<br><!--<table cellpadding="2" cellspacing="2" >-->
 <table width="100%" border="1" class="table-bordered">
  <tr>
    <td width="15%" > <img src="../set_upload/<?php echo $filename;  ?>" width="350" height="50"/></td>
    <td width="42%" rowspan="2"><div align="center"><h5>Production Planning Sheet</h5></div></td>
    <td width="38%"><table width="96%" class="table-borderless">
      <tr>
        <th width="38%"><div align="left">Doc No. </div></th>
        <th width="5%">:</th>
        <th width="57%">&nbsp;</th>
        </tr>
      <tr>
        <th><div align="left">Rev. No.</div></th>
        <th>:</th>
        <th>&nbsp;</th>
        </tr>
      <tr>
        <th><div align="left">Effective Date </div></th>
        <th>:</th>
        <th>&nbsp;</th>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="96%" class="table-borderless">
      <tr>
        <th width="47%"><div align="left"><span class="style3">Plant</span></div></th>
        <th width="4%"><span class="style3">:</span></th>
        <th width="49%"><span class="style3"> <?php echo $db_rs2["plant_code"]; ?></span></th>
        </tr>
      <tr>
        <th><div align="left"><span class="style3">Production Line</span></div></th>
        <th><span class="style3">:</span></th>
        <th> <?php echo $model_name; ?></th>
        </tr>
      <tr>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        </tr>
    </table></td>
    <td><table width="96%" class="table-borderless">
      <tr>
        <th><div align="left"><span class="style3">Month/Year</span></div></th>
        <th width="10"><span class="style3">:</span></th>
        <th width="205"><span class="style3"> <?php echo $db_rs2["month_plan"]; ?>/ <?php echo $db_rs2["year_plan"]; ?></span></th>
        </tr>
      <tr>
        <th width="135" height="28"><div align="left"><span class="style3"> Date</span></div></th>
        <th height="28"><span class="style3">:</span></th>
        <th height="28"><span class="style3"><?php echo $db_rs2["K"]; ?></span></th>
        </tr>
      <tr>
        <th height="28"><div align="left"><span class="style3">Page</span></div></th>
        <th height="28"><span class="style3">:</span></th>
        <th height="28"><span class="style3">1 of 1</span></th>
        </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="3"> 
  <!--  <div class="page"> -->
    <table class="table">
      <thead>
        <tr>
            <th>No. </th>
            <th>Part No. / Part Name </th>
            <th>Planned Order No.</th>
            <th>Planned Start Date</th>
            <th>Planned Start Time</th>
            <th>Shift</th>
            <th>Kanban #</th>
            <th>Planned Order Quantity</th>
            <th>UOM</th>
            <th>QR Code</th>
            <th>Status</th>
            <th>&nbsp;OK&nbsp;</th>
            <th>&nbsp;NG&nbsp;</th>
            <th>&nbsp;P&nbsp;</th>
            <th>&nbsp;HW&nbsp;</th>

          </tr>
      </thead>
   <!--   <tbody>-->
        <?php
		
	   $query_by_group = "SELECT *, DATE_FORMAT(MR.date_plan,'%d-%m-%Y') AS T, DATE_FORMAT(MR.date_plan,'%d%m%Y') AS T2, DATE_FORMAT(MR.date_upload,'%d-%m-%Y %H:%i:%s') AS K, DATE_FORMAT(MR.work_hours,'%H:%i') AS T5 from pps_detail AS MR WHERE MR.work_center = '".sql_esc($db_rs2["work_center"])."' AND MR.id = '".sql_esc($id)."' AND MR.status_pps = '".sql_esc($rst_sta2["status_desc"])."'";
      $result_by_group = mysqli_query($dbc,$query_by_group);   //run the query.
		
      $counter = 1;
      $no = 1;
	  $i = 1; 
	
   
   while($row3 = mysqli_fetch_array($result_by_group))
   {
		//$user_no = $row[0]; 
 $no = sprintf('%03d', $no);
	if($row3["shift_pps1"] != "")
	{
		$sta = "D/S";
		
	}elseif($row3["shift_pps2"] != "")
	 {
		$sta = "N/S";
	 }else{
		 
		$sta = " ";
	 }
	 
	  if($row3["work_hours"] != "00:00:00")
	  {
		$time_new =  $row3["T5"];  
		  
	  }else{
		$time_new = "";  
	  }		
	  
	  	
		$query_mat_h = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($row3['material_no'])."'";
        $result_mat_h = mysqli_query($dbc,$query_mat_h);
        $data_mat_h = mysqli_fetch_array($result_mat_h);
	  
	  
	 
      
		
		echo '<tbody><tr >'; 
        if ($i && $i % 3 == 0) 
		echo '</tr><tr class="breakAfter">'; 
		else if ($i)  
		echo '<tr>';  
	    ++$i;  

		 ?>
       <!-- <tr>-->
          <td width="60" height="28"><?php  echo $no; ?></td>
          <td width="384"><b><?php  echo $row3["material_no"]; ?></b><br><?php  echo $data_mat_h["material_desc"]; ?>
            <br>[Std Pack: <?php echo $data_mat_h["std_packaging"].'&nbsp;'.$data_mat_h["BUn"]; ?>]</td>
          <td width="151" height="28"><div align="center"><?php echo $row3["plan_no"]; ?></div></td>
          <td width="93" height="28"><?php  echo $row3["T"]; ?></td>
          <td width="100" height="28"><?php  echo $time_new; ?></td>
          <td width="46" height="28"><div align="center"><font color="#FF0000"><?php echo $sta; ?></font></div></td>
          <td width="46"><div align="center"><?php echo $row3["kanban_no"]; ?></div></td>
          <td width="69" height="28"><div align="center"><?php  echo intval($row3["qty_plan"]); ?></div></td>
          <td width="55" height="28"><div align="center"><font color="#FF0000">
            <?php  echo $data_mat_h["BUn"]; ?>   </font></div></td>
          <td width="100" height="100"> <div align="left">
       <?php
	   
	   //---qty convert ----
	   
	    $qty_new = (intval($row3["qty_plan"]));
	    

// set the barcode content and type
// Part Number|Model|Back No.|Part Name|Quantity|Kanban No.

$bar_text = ($row3["material_no"].'|'.$row3["model_code"].'|'.$row3["back_no"].'|'.$data_mat_h["material_desc"].'|'.$qty_new.'|'.$row3["kanban_no"]);

$barcodeobj = new TCPDF2DBarcode($bar_text, 'QRcode');
echo $barcodeobj->getBarcodeSVGcode(3.5, 3.5, 'black');

?>
                  </div></td>
          <td width="44"><?php  echo $row3["status_pps"]; ?></td>
           <td width="3%"></td>
            <td width="3%"></td>
            <td width="3%"></td>
            <td width="3%"></td>
		</tr>
        <tr><td colspan="15">&nbsp;</td></tr>
        <?php 
		  
		     $counter++; // menambah counter 
			 $no++;   
			   
			   
			   }
			   
			   
			   ?>
      </tbody>
    </table><?php //include "footer.php";   ?></td>
    </tr>
</table>
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td width="34%" height="50"><div align="center">&nbsp;<b>Uploaded by</b><br>
    <?php echo $data_upld["user_fullname"];    ?>
    </div></td>
   <td width="33%"><div align="center">&nbsp;<b>Approved by</b><br>
    <?php if($data_plan_apprv["f_name"] != ""){ echo $data_plan_apprv["f_name"]; }else{ echo "<br>";  } ?></div></td>
    <td width="33%"><div align="center">&nbsp;<b>Released by</b><br>
    <?php if($data_rels["user_fullname"] != "") { echo $data_rels["user_fullname"];   }else{ echo "<br>";  }  ?></div></td>
  </tr>
</table> <input type="hidden" name="upload_id" value="<?php echo $row["upload_id"]; ?>">
</div>
<?php    } // end while loop main   ?>

             
             <!--button print-->
<div class="prt-button">

  <button type="button" name="btn_release" id="btn_release" class="btn btn-success btn-sm" onClick="window.print()">Print this Page</button>
</div>
         
         <!-- 
                <!--  </div>--><!--</div>
                  </div>
                  </div>
                  </div>
                  </div>-->
</body>
</html>