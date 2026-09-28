<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$Cdate = date ("l, j F Y ");

set_time_limit(0);
// include 2D barcode class (search for installation path)
require_once('tcpdf_barcodes_2d.php');


// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------		
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?>">
    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>
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

<style type="text/css">
<!--
.style3 {color: #000000}

.style4 {
	font-size: 14px;
	font-weight: bold;
}
-->
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
 size:landscape;
   
}

 @media print{
  body{  margin-top: -1.8cm;  font-family: Arial, Helvetica, sans-serif; font-size:12px; }
  #ad{ display:none;}
  #leftbar{ display:none;}
  #contentarea{ width:100%;}
  .header, .hide { visibility: hidden }
  .tfoot { display: table-footer-group; }
  @page {size: landscape}
 /* tr.page-break  { display: block; page-break-before: always; }  */
  .breakAfter{ 
page-break-after: always; 
}
.breakBefore{
page-break-before: always ;
}
  
} 

</style>
<script type="text/javascript">
        function print_page() {
            var ButtonControl = document.getElementById("btnprint");
            ButtonControl.style.visibility = "hidden";
            window.print();
        }
    </script>

     
</head>

<?php

function encode($ss,$ntime){
    for($i=0;$i<$ntime;$i++){
        $ss=base64_encode($ss);
    }
return $ss;
}


function decode($ss,$ntime){
    for($i=0;$i<$ntime;$i++){
        $ss=base64_decode($ss);
    }
return $ss;
}

//- First page:
$url = 'upload_pps_month.php';

?>

<body class="app sidebar-mini">
<div class="widget-box">

  <?php

 $upload_id = $_GET["upload_id"];
 
$queryu = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') AS T, DATE_FORMAT(date_upload,'%d-%m-%Y %H:%i:%s') AS K from pps_detail WHERE upload_id = '".sql_esc($upload_id)."' GROUP BY work_center";
$rs = mysqli_query($dbc,$queryu);   //run the query.

 while ($db_rs = mysqli_fetch_array($rs))
   {
	   	if($db_rs["month_plan"] == "01")
	{
      $bulan_text = "January";
	}elseif($db_rs["month_plan"] == "02")
	{
	  $bulan_text = "February";
	  
    }elseif($db_rs["month_plan"] == "03")
	{
	  $bulan_text = "March";
	}elseif($db_rs["month_plan"] == "04")
	{
	  $bulan_text = "April";
	}elseif($db_rs["month_plan"] == "05")
	{
	  $bulan_text = "May";
	}elseif($db_rs["month_plan"] == "06")
	{
	  $bulan_text = "June";
	}elseif($db_rs["month_plan"] == "07")
	{
	  $bulan_text = "July";
	}elseif($db_rs["month_plan"] == "08")
	{
	  $bulan_text = "August";
	}elseif($db_rs["month_plan"] == "09")
	{
	  $bulan_text = "September";
	}elseif($db_rs["month_plan"] == "10")
	{
	  $bulan_text = "October";
	}elseif($db_rs["month_plan"] == "11")
	{
	  $bulan_text = "November";
	}elseif($db_rs["month_plan"] == "12")
	{
	  $bulan_text = "December";
	}else{
		$bulan_text = "Others";
	}
 
 $extension = explode('.', $data_setup["logo_name"]);
 $filename = $data_setup["logo_comp"].'.'.$extension[1];
 
 //--------------get filename from table ftp_pps
 
 $query_ftp_pps = "SELECT * FROM ftp_pps WHERE upload_id = '".sql_esc($upload_id)."'";
 $result_ftp_pps = mysqli_query($dbc,$query_ftp_pps);
 $data_ftp_pps = mysqli_fetch_array($result_ftp_pps);  
 
	
 ?>
<div class="page"><br><table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="30%" height="93"><img src="../set_upload/<?php echo $filename;  ?>" width="250" height="50"/></td>
    <td width="40%"><div align="center"><h5>Production Planning Sheet</h5></div></td>
    <td width="30%"><table width="96%" class="table-bordered">
      <tr>
        <th width="122" height="28"><div align="left">Doc No. </div></th>
        <th width="10">:</th>
        <th width="174">&nbsp;</th>
      </tr>
      <tr>
        <th height="36"><div align="left">Rev. No.</div></th>
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
    <td>

    <table width="96%" class="table-bordered">
      <tr>
        <th width="47%"><div align="left"><span class="style3">Production Plant</span></div></th>
        <th width="4%"><span class="style3">:</span></th>
        <th width="49%"><span class="style3"> <?php echo html_esc($db_rs["comp_code"]); ?></span></th>
      </tr>
      <tr>
        <th><div align="left"><span class="style3">Plant</span></div></th>
        <th><span class="style3">:</span></th>
        <th><span class="style3"> <?php echo html_esc($db_rs["plant_code"]); ?></span></th>
      </tr>
      <tr>
        <th><div align="left"><span class="style3">Production Line</span></div></th>
        <th><span class="style3">:</span></th>
        <th> <?php echo html_esc($db_rs["work_center"]); ?></th>
      </tr>
    </table></td>
    <td>&nbsp;</td>
    <td><table width="96%" class="table-bordered">
      <tr>
        <th width="125" height="28"><div align="left"><span class="style3">Month/Year</span></div></th>
        <th width="10" height="28"><span class="style3">:</span></th>
        <th width="177" height="28"><span class="style3">
          <?php echo html_esc($db_rs["month_plan"]); ?>/ <?php echo html_esc($db_rs["year_plan"]); ?>
        </span></th>
      </tr>
      <tr>
        <th width="125" height="28"><div align="left"><span class="style3"> Date</span></div></th>
        <th height="28"><span class="style3">:</span></th>
        <th height="28"><span class="style3"><?php echo html_esc($db_rs["K"]); ?></span></th>
      </tr>
      <tr>
        <th height="28"><div align="left"><span class="style3">Filename</span></div></th>
        <th height="28"><span class="style3">:</span></th>
        <th height="28"><span class="style3"><?php echo html_esc($data_ftp_pps["file_name"]); ?></span></th>
      </tr>
    </table></td>
    </tr>

</table><!--</div>-->
<table class="table table-bordered" style="page-break-inside:inherit">
      <thead>
        <tr>
          <th>No.</th>
          <th>Model</th>
          <th>Part No./ Part Name</th>
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
      </thead>
      <tbody>
        <?php
		
	  $query_by_group = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') AS T, DATE_FORMAT(date_upload,'%d-%m-%Y %H:%i:%s') AS K from pps_detail WHERE upload_id = '".sql_esc($upload_id)."' AND work_center = '".sql_esc($db_rs["work_center"])."'";
      $result_by_group = mysqli_query($dbc,$query_by_group);   //run the query.
		
		
      $counter = 1;
      $no = 1;
	  $i = 1;
   
   while($row = mysqli_fetch_array($result_by_group))
   {
		//$user_no = $row[0]; 
 $no = sprintf('%03d', $no);
	if($row["shift_pps1"] != "")
	{
		$sta = "D/S";
		
	}elseif($row["shift_pps2"] != "")
	 {
		$sta = "N/S";
	 }else{
		 
		$sta = " ";
	 }	
 
	  //---------get material header---------
	    $query_mat_h = "SELECT * FROM mat_master_header AS HD, mat_master_detail AS AD WHERE HD.material_no = AD.material AND HD.material_no = '".sql_esc($row['material_no'])."'";
		$result_mat_h = mysqli_query($dbc,$query_mat_h);
		$data_mat_h = mysqli_fetch_array($result_mat_h);	
		
		  //---------get material detail---------
	    $query_mat_d = "SELECT * FROM mat_master_detail WHERE (material = '".sql_esc($row['material_no'])."' OR bill_component = '".sql_esc($row['material_no'])."')";
		$result_mat_d = mysqli_query($dbc,$query_mat_d);
		$data_mat_d = mysqli_fetch_array($result_mat_d);
		
		
		if ($i && $i % 4 == 0)  
		echo '<tr style="page-break-after:always">';  
	    else if ($i)  
		echo '<tr>';  
	    ++$i; 
	

		 ?>
   
          <td width="60" height="28"><?php  echo $no; ?></td>
          <td width="60" height="28"><?php  echo html_esc($row["model_code"]); ?></td>
          <td width="384"><b><?php  echo html_esc($row["material_no"]); ?></b><?php  echo html_esc($data_mat_h["material_desc"]); ?></td>
          <td width="151" height="28"><div align="center"><?php echo html_esc($row["plan_no"]); ?></div></td>
          <td width="93" height="28"><?php  echo html_esc($row["T"]); ?></td>
          <td width="46" height="28"><div align="center"><font color="#FF0000"><?php echo $sta; ?></font></div></td>
          <td width="46"><div align="center"><?php echo html_esc($row["seq_pps"]); ?></div></td>
          <td width="69" height="28"><div align="center"><?php  echo intval($row["qty_plan"]); ?></div></td>
          <td width="55" height="28"><div align="center"><font color="#FF0000">
            <?php  echo html_esc($data_mat_h["BUn"]); ?>
          </font></div></td>
          <td width="90" height="28"> <div align="left">
       <?php
	   
	    //---qty convert ----
	   
	    $qty_new = (intval($row["qty_plan"]));

// set the barcode content and type
// Part Number|Model|Back No.|Part Name|Quantity|Kanban No.

$bar_text = ($row["material_no"].'|'.$row["model_code"].'|'.$row["back_no"].'|'.$data_mat_h["material_desc"].'|'.$qty_new.'|'.$row["kanban_no"]);

//$bar_text = ($row["material_no"].'|'.$row["plant_code"].'|'.$row["plan_no"].'|'.$row["date_plan"].'|'.$row["work_center"].'|'.$row["qty_plan"].'|'.$sta.'|'.$data_mat_h["BUn"]);

$barcodeobj = new TCPDF2DBarcode($bar_text, 'QRcode');
//echo $barcodeobj->getBarcodeSVGcode(3.0, 3.0, 'black');

?>
                  </div></td>
          <td width="90" height="28"><?php  echo html_esc($row["status_pps"]); ?></td>
          <td width="130">&nbsp;</td>
          </tr>
        <?php 
	  
		     $counter++; // menambah counter 
			 $no ++;   
			   
			   }
			   
			   ?>
             <!--  <tr>
               <td colspan="14">
               <?php //include "footer.php";   ?>
               </td></tr>-->
      </tbody>
    </table></div>
   <!-- </div>-->
    <div class="breakBefore">
<?php   
 } // end while loop main  


 ?>
</div>

    <form name="form1" action="printing_pps_sheet_release.php?upload_id=<?php echo html_esc($upload_id); ?>" method="post" class="form-horizontal">
<input type="hidden" name="upload_id" value="<?php echo html_esc($upload_id); ?>">

<input name="submit_rel" type="submit" id="submit" value="PRINT" class="btn btn-primary btn-sm" >

<!--<input name="submit_rel" type="submit" id="btnprint" value="PRINT" class="btn btn-primary btn-sm" onclick="print_page()">
-->
<input type="button" onclick="parent.window.close();" value="CANCEL" class="btn btn-warning btn-sm"/>
</form>

</div>
<?php
	//------------update status = "Release"------------------//
	
	if(isset($_POST['submit_rel'])) 
  { // handle the form.

  
	 $query_upd = "UPDATE pps_detail SET status = 'Y', status_pps = 'Released' WHERE upload_id = '".sql_esc($upload_id)."'";
	 $result_upd = mysqli_query($dbc,$query_upd);   //run the query.*/	
	 
	 
	 if($result_upd)
	 {
	 ?>
    <?php 
	
    echo '<script type="text/javascript">';
	//echo 'window.print();';
	echo "window.open('detail_pps_sheet_print_by_id.php?upload_id=".html_esc($upload_id)."', '_blank');";
	echo "opener.location.href = 'upload_pps_month.php';"; 
	echo "window.close()";
	echo "</script>";
	exit(); //quit the script


	 ?>
<?php

	 }//end if
	 
  }
	

?>


</body>
</html>
