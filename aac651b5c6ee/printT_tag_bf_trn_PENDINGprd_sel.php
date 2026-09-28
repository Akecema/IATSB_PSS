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

$url = "printT_tag_bf_trn_PEND-prdProc.php";

$query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
$result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
$res = mysqli_fetch_array($result2);
	
$today = getdate();
$hours = $today['hours']; 
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year']; 	

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	

$extension = explode ('.', $data_setup["logo_name"]);
$filename = $data_setup["logo_comp"].'.'.$extension[1];

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


$buid2 = base64_decode($_GET["buid"]);

/*$query_pps_tit = mysqli_query($dbc,"SELECT * FROM print_tag_bf_pending WHERE bflush_no = '$buid'");
$data_tit = mysqli_fetch_array($result_pps_tit);*/

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?> ">
    <title><?php echo html_esc($data_setup["comp_code"]); ?> : Material Doc. No <?php echo $buid2; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    
     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
<!--https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages-->
<script>
    $(document).ready(function(){
    $(document).on('click', '#btnPrint', function(){
    $('.printMe').printElem();
    });
    });
    
    </script>
    
    <style>
    @media print {
		@page{
			size: A5 landscape;	
		}
		.face {
			margin: 0.5cm;
			page-break-after: always;
		}
		
		.face-button button  
		{ 
			display: none; 
		}
			
	}
		
	</style>
	
<style>
	/*https://gist.github.com/hubgit/7025107*/
	@page {
		/* dimensions for the whole page */
		size: A5 landscape;
	}
	
	body {
		/*width: 210mm;
		height: 148.5mm;*/
	
		margin: 0;
	}
	

	/* fill half the height with each face */
	.face {
		/*height: 50%;
		width: 100%;*/
		/*position: relative;*/
		/*margin-top: 1.0cm;
		margin-right: 5.0cm;
		margin-bottom: 1.0cm;
		margin-left: 7.0cm;*/
		margin-top: 2.0cm;
		margin-bottom: 1.5cm;
		
	}
	
	/* the front face */
	.face-front {
		background: #fff;
		margin-bottom: 1cm;
		top:1cm;
		bottom: 1cm;
		
	}
	
	.face-button button {
		position: fixed;
		bottom: 10px;
		right: 310px; 
	}
			
	.style4 {
		font-size: 16px;
		color: #000000;
		font-family: Arial, Helvetica, sans-serif;
	}
	.style1 {	
		font-size: 18px;
		font-weight: bold;
		color: #000000;
		font-family: Arial, Helvetica, sans-serif;
	}
	.style10 {	
		font-size: 10px;
		color: #000000; 
		font-family: Arial, Helvetica, sans-serif;
		padding-bottom: 0.5cm;
	}
	.style11 {	
		font-family: Arial, Helvetica, sans-serif;
		font-size: 22px;
		color: #000000;
		font-weight: bold;
	}
	.style7 {	
		font-size: 23px;
		font-weight: bold;
		color: #000000;
		font-family: Arial, Helvetica, sans-serif;
	}
	.style8 {	
		font-size: 15px;
		color: #000000; 
		font-family: Arial, Helvetica, sans-serif;
	}
	.style9 {	
		font-size: 28px;
		font-weight: bold;
		color: #000000; 
		font-family: Arial, Helvetica, sans-serif;
	}
	
	</style>

</head>

<body>

<?php



$buid2 = base64_decode($_GET["buid"]);


//--------- pps detail ------------

$query_pps = "SELECT *, DATE_FORMAT(posting_date,'%d%m%Y') AS R FROM print_tag_bf_pending WHERE bflush_no = '".sql_esc($buid2)."'";
$result_pps = mysqli_query($dbc,$query_pps);

while($row_pps = mysqli_fetch_array($result_pps))

{
 
	
	//----------display material header
	$query_info3 = "SELECT * FROM mat_master_header WHERE material_no = '".sql_esc($row_pps["material_no"])."'";
	$result_info3 = mysqli_query($dbc,$query_info3);
	$row_info3 = mysqli_fetch_array($result_info3);


?>
<p>&nbsp;</p>

<center>
<div class="face">
  <table width="1000" height="600" border="1" cellpadding="0" cellspacing="0">
    <tr>
      <td height="55" colspan="2"><p><img src="../set_upload/<?php echo $filename;  ?>" width="300" height="35" hspace="2" vspace="2"/></p></td>
      <td colspan="2"><h3><center>PENDING TAG</center></h3></td>
      </tr>
    <tr>
      <td width="145">&nbsp;<span class="style8">Material Document No.</span></td>
      <td width="288">&nbsp;<span class="style1"><?php echo html_esc($row_pps["bflush_no"]);  ?></span></td>
      <td colspan="2" rowspan="5">&nbsp;
       <?php

	$query = "SELECT *,DATE_FORMAT(posting_date,'%d%m%Y') as Q2 FROM print_tag_bf_pending WHERE bflush_no = '".sql_esc($buid2)."' AND id_tag = '".sql_esc($row_pps["id_tag"])."' AND status_bf = '".sql_esc($rst_sta["status_desc"])."'";
	$hasil = mysqli_query($dbc,$query);
	
	// setting banyaknya kolom
	$kolom = 2;
	
	// membuat tabel berisi label barcode
	echo " <center><br /><table border='0'>";
	$counter = 1;
	$total_slip_no = "";
	
	while ($data = mysqli_fetch_array($hasil))
	{
	
		$query_sloc = "SELECT * FROM mat_master_detail WHERE material = '".sql_esc($data["material_no"])."' OR bill_component = '".sql_esc($data["material_no"])."'";
		$result_sloc = mysqli_query($dbc,$query_sloc);
		$data_sloc = mysqli_fetch_array($result_sloc);
	
	$total_slip_no = ($row_pps["slip_no"].' of '.$row_pps["total_slip"]);
	
	$qty_new = (intval($data['tag_qty']));
	
     echo "<tr>";
	?>      <?php
	 echo "<td align='center' style='padding: 0.5px'>";
	// set the barcode content and type
	
	//Part Number|Plant|Planned Order No.|BF Pending Doc. No.|BF Pending Posting Date|Line|Pending Quantity|Unit of Measure
	
	$barcodeobj = ($data['material_no'].'|'.$data['plant_cd'].'|'.$data['plan_no'].'|'.$data['bflush_no'].'|'.$data['Q2'].'|'.$data['station_loc'].'|'.$qty_new.'|'.$data['tag_uom'].'|'.$data['model_code'].'|'.$data['back_no']);

	
	
	$barcodeobj = new TCPDF2DBarcode($barcodeobj, 'QRcode');
    echo $barcodeobj->getBarcodeSVGcode(5.0, 5.0, 'black');
	
	echo "</td>";
	
    echo "</tr>";


}
echo "</table></center>";
//echo $row["id_tag"];
?>
      
      <br>  
      
      </td>
      </tr>
    <tr>
      <td>&nbsp;<span class="style8">Production Date</span></td>
      <td>&nbsp;<span class="style1"><?php echo html_esc($row_pps["R"]);  ?></span></td>
      </tr>
    <tr>
      <td>&nbsp;<span class="style8">Production Time</span></td>
      <td>&nbsp;<span class="style1"><?php echo html_esc($row_pps["posting_time"]);  ?></span></td>
      </tr>
    <tr>
      <td>&nbsp;<span class="style8">Planned Order No.</span></td>
      <td>&nbsp;<span class="style1"><?php echo html_esc($row_pps["plan_no"]);  ?></span></td>
      </tr>
      <tr>
      <td>&nbsp;<span class="style8">Reason for Pending</span></td>
      <td>&nbsp;<span class="style1"><?php echo html_esc($row_pps["remark_pend"]);  ?></span></td>
      </tr>         
    <tr>
      <td>&nbsp;<span class="style8">Line</span></td>
      <td>&nbsp;<span class="style1"><?php echo html_esc($row_pps["station_loc"]);     ?></span></td>
      <td width="117">&nbsp;<span class="style8">Part No.</span></td>
      <td width="320"><div align="center"><span class="style7"><?php echo html_esc($row_pps["material_no"]);     ?></span></div></td>
    </tr>
    <tr>
      <td>&nbsp;<span class="style8">Shift</span></td>
      <td>&nbsp;<span class="style1">
      <?php if($row_pps["shift_tag"] == "D/S"){ echo "Day"; }else{ echo "Night"; } ?>
    </span></td>
      <td>&nbsp;<span class="style8">Part Name</span></td>
      <td><div align="center"><span class="style7"><?php echo html_esc($row_pps["material_desc"]);  ?></span></div></td>
    </tr>
    <tr>
      <td>&nbsp;<span class="style8">SV/Leader</span></td>
      <td>&nbsp;<span class="style1"><?php echo html_esc($row_pps["posting_by"]);  ?></span></td>
      <td>&nbsp;<span class="style8">Model</span></td>
      <td><div align="center"><span class="style7"><?php echo html_esc($row_pps["model_code"]);  ?></span></div></td>
    </tr>
    <tr>
      <td>&nbsp;<span class="style8">Pack Type</span></td>
      <td>&nbsp;<span class="style1"><?php echo html_esc($row_pps["pack_type"]);  ?></span></td>
      <td>&nbsp;<span class="style8">Quantity</span></td>
      <td><div align="center"><span class="style7"><?php echo intval($row_pps["tag_qty"]);  ?></span></div></td>
    </tr>
    <tr>
      <td>&nbsp;<span class="style8">Pack No.</span></td>
      <td>&nbsp;<span class="style1"><?php echo html_esc($row_pps["pack_no"]);  ?></span></td>
      <td>&nbsp;<span class="style8">Slip No.</span></td>
      <td><div align="center"><span class="style1"> <?php echo html_esc($row_pps["slip_no"]);  ?> of <?php echo html_esc($row_pps["total_slip"]);  ?> </span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;<span class="style8">Prepared (PRD)</span><br><p>&nbsp;</p></td>
      <td colspan="2">&nbsp;<span class="style8">Checked (QG/QC)</span><br><p>&nbsp;</p></td>
      </tr>
  </table> 
</div>
</center>
<?php }// end while loop main ?>
    

<!--button print-->
<div class="face-button">
  <button type="button" name="btn_release" class="btn btn-success btn-sm" onClick="window.print()">Print this Page</button>
</div>
</body>
</html>