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

$url = "detail_print_tag_bfOK_ind.php";

$query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
$result2 = db_query($dbc, $query2) or die (mysqli_error());
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


$buid = base64_decode($_GET["buid"]);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?> ">
    <title><?php echo html_esc($data_setup["comp_code"]); ?> : Material Doc. No <?php echo $buid; ?></title>
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
			size: A4 landscape;	
		}
		.face {
			margin: 0.5cm;
			page-break-after: always;
		}
		
		.face-button button  
		{ 
			display: none; 
		}
		
			.style7 {	
		font-size: 23px;
		font-weight: bold;
		color: #000000;
		font-family: Arial, Helvetica, sans-serif;
	}
	.style77 {	
		font-size: 35px;
		font-weight: bold;
		color: #000000;
		font-family: Arial, Helvetica, sans-serif;
	}
			
	}
		
	</style>
	
	<style>
	/*https://gist.github.com/hubgit/7025107*/
	@page {
		/* dimensions for the whole page */
		size: A4 landscape;
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
		margin-top: 0.5cm;
		margin-bottom: 1.2cm;
		
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
		font-size: 20px;
		color: #000000;
		font-family: Arial, Helvetica, sans-serif;
	}
	.style1 {	
		font-size: 20px;
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
		font-size: 30px;
		font-weight: bold;
		color: #000000;
		font-family: Arial, Helvetica, sans-serif;
	}
	.style77 {	
		font-size: 45px;
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

$buid = base64_decode($_GET["buid"]);


//--------- pps detail ------------

$query_pps = new PreparedSql("SELECT *, DATE_FORMAT(posting_date,'%d%m%Y') AS R FROM print_tag_bf_ok WHERE bflush_no = ?", [$buid]);
$result_pps = db_query($dbc, $query_pps);

while($row = mysqli_fetch_array($result_pps))

{

	//----------display material header
	$query_info3 = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$row["material_no"]]);
	$result_info3 = db_query($dbc, $query_info3);
	$row_info3 = mysqli_fetch_array($result_info3);


?>

<p>&nbsp;</p>

<center>
<div class="face">
  <table width="1000" height="600" border="1" cellpadding="3" cellspacing="3">
    <tr>
      <td colspan="3"><p><img src="../set_upload/<?php echo $filename;  ?>" width="350" height="70" hspace="2" vspace="2"/></p></td>
      <td colspan="2"><h3><center>BLANKING</center></h3><h4><center>FINISHED GOODS (FG)</center></h4><br></td>
      <td width="9%" colspan="3" rowspan="3">
       <?php

	$query = new PreparedSql("SELECT *,DATE_FORMAT(posting_date,'%d%m%Y') as Q2 FROM print_tag_bf_ok WHERE bflush_no = ? AND id_tag = ? AND status_bf = ?", [$buid, $row["id_tag"], $rst_sta["status_desc"]]);
	$hasil = db_query($dbc, $query);
	
	// setting banyaknya kolom
	$kolom = 2;
	
	// membuat tabel berisi label barcode
	echo " <center><br /><table border='0'>";
	$counter = 1;
	$total_slip_no = "";
	
	while ($data = mysqli_fetch_array($hasil))
	{
	
		$query_sloc = new PreparedSql("SELECT * FROM mat_master_detail WHERE material = ? OR bill_component = ?", [$data["material_no"], $data["material_no"]]);
		$result_sloc = db_query($dbc, $query_sloc);
		$data_sloc = mysqli_fetch_array($result_sloc);
	
	$total_slip_no = ($row["slip_no"].' of '.$row["total_slip"]);
	$qty_new = (intval($data['tag_qty']));
	
     echo "<tr>";
	?>      <?php
	 echo "<td align='center' style='padding: 0.5px'>";
	// set the barcode content and type
	
	//Part Number|Plant|Planned Order No.|BF Pending Doc. No.|BF Pending Posting Date|Line|Pending Quantity|Unit of Measure
	
	$barcodeobj = ($data['material_no'].'|'.$data['plant_cd'].'|'.$data['plan_no'].'|'.$data['bflush_no'].'|'.$data['Q2'].'|'.$data['station_loc'].'|'.$qty_new.'|'.$data['tag_uom'].'|'.$data['model_code'].'|'.$data['back_no']);

	
	
	$barcodeobj = new TCPDF2DBarcode($barcodeobj, 'QRcode');
    echo $barcodeobj->getBarcodeSVGcode(4.5, 4.5, 'black');
	
	echo "</td>";
	
    echo "</tr>";


}
echo "</table></center>";
//echo $row["id_tag"];
?>
      
      <br> </td>
      </tr>
    <tr>
      <td colspan="2">Material Doc. No.</td>
      <td width="14%"><span class="style1"><?php echo html_esc($row["bflush_no"]);  ?></span></td>
      <td width="19%"><span class="style8">Production Date</span></td>
      <td width="17%"><div align="center"><span class="style1"> <?php echo html_esc($row["R"]);  ?></span></div></td>
    </tr>
    <tr>
      <td colspan="2"><span class="style8">Planned Order No.</span></td>
      <td><span class="style1"><?php echo html_esc($row["plan_no"]);  ?></span></td>
      <td>Slip No. </td>
      <td><div align="center"><span class="style1"> <?php echo html_esc($row["slip_no"]);  ?> of <?php echo html_esc($row["total_slip"]);  ?> </span></div></td>
    </tr>
    <tr>
      <td width="12%"><div align="center"><span class="style4">MODEL</span></div></td>
      <td colspan="2"><div align="center"><span class="style4">PART NUMBER</span></div></td>
      <td colspan="5"><div align="center"><span class="style4">PART NAME</span></div></td>
      </tr>
    <tr>
      <td>&nbsp;<div align="center"><span class="style77"><?php echo html_esc($row["model_code"]);  ?></span></div></td>
      <td colspan="2">&nbsp;<div align="center"><span class="style77"><?php echo html_esc($row["material_no"]);     ?></span></div></td>
      <td colspan="5">&nbsp;<div align="center"><span class="style77"><?php echo html_esc($row["material_desc"]);  ?></span></div></td>
      </tr>
    <tr>
      <td colspan="4"><div align="center"><span class="style4">SPEC / MATERIAL SIZE</span></div></td>
      <td colspan="4"><div align="center"><span class="style4">QUANTITY</span></div></td>
      </tr>
    <tr>
      <td colspan="4">&nbsp;<div align="center"><span class="style77"><?php echo html_esc($row_info3["size_dim"]);  ?></span></div></td>
      <td colspan="4">&nbsp;<div align="center"><span class="style77"><?php echo intval($row["tag_qty"]);  ?></span></div></td>
      </tr>
    <tr>
      <td colspan="8"><h2><div align="center"><span class="style1">Vendor Production Inspection</span></div></h2></td>
      </tr>
    <tr>
      <td colspan="2" height="30" width="335"><p>&nbsp;<br></p></td>
      <td colspan="2" height="30" width="335">&nbsp;</td>
      <td colspan="4" height="30" width="335">&nbsp;</td>
      </tr>
    <tr>
      <td colspan="2"><div align="center"><span class="style4">PPC</span></div></td>
      <td colspan="2"><div align="center"><span class="style4">PRESS</span></div></td>
      <td colspan="4"><div align="center"><span class="style4">QD</span></div></td>
      </tr>
  </table>
 
     
</div>
</center>
<?php }// end while loop main ?>
    

<!--button print-->
<div class="face-button">
  <button type="button" name="btn_release" class="btn btn-success btn-sm" onClick="window.print()">Print this Page A4</button>
</div>

</body>
</html>