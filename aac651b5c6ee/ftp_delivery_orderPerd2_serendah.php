<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));
$fmt_curr_time = (date("H:i:s"));
$pick_curr_time = (date("H:i a"));
$yearSkrg = (date("Y"));

set_time_limit(0);
// include 2D barcode class (search for installation path)
require_once('tcpdf_barcodes_2d.php');

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "3")) {
header('Location: ../index.php');
exit();
}

$url = "view_do_perd2-dlvProc2.php";

$query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
$result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
$res = mysqli_fetch_array($result2);
	
	


$today = getdate();
$hours = $today['hours']; 
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year']; 

$fmt_curr_date = (date("d-m-Y"));

                 $drun = substr($fmt_curr_date,0,2);
				 $mrun = substr($fmt_curr_date,3,2);
				 $yrun = substr($fmt_curr_date,8,2);
				 
				 $date_run = ($drun.$mrun.$yrun);	

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	

$extension = explode ('.', $data_setup["logo_name"]);
$filename = $data_setup["logo_comp"].'.'.$extension[1];

$suid2 = base64_decode($_GET["suid2"]);
$so_no = $_GET["so_no"];
$pdio_no = $_GET["pdio_no"];


//----------------------------------------------------	

 //CR status (New)

 $sta = "SELECT * from request_status WHERE status_id = '1'";
 $sta_res = mysqli_query($dbc,$sta);
 $rst_sta = mysqli_fetch_array($sta_res);
 
 //CR status (Released)  //CR status (New)
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
 
 //CR status (Rejected)
 $sta5 = "SELECT * from request_status WHERE status_id = '5'";
 $sta_res5 = mysqli_query($dbc,$sta5);
 $rst_sta5 = mysqli_fetch_array($sta_res5);
 
 //CR status (Draft)
 $sta6 = "SELECT * from request_status WHERE status_id = '6'";
 $sta_res6 = mysqli_query($dbc,$sta6);
 $rst_sta6 = mysqli_fetch_array($sta_res6);
 
 //CR status (In Progress)
 $sta7 = "SELECT * from request_status WHERE status_id = '7'";
 $sta_res7 = mysqli_query($dbc,$sta7);
 $rst_sta7 = mysqli_fetch_array($sta_res7);
//----------------------------------------------------------------------------------------- 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?> ">
    <title><?php echo html_esc($data_setup["comp_code"]); ?> : Generate Doc. No <?php echo $suid2; ?></title>
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
<style>
/*Size : 8.27in and 11.69 inches*/


@media print{
@page{
	size: A5 landscape;
	/*margin-top: 1.0cm;*/
	/*padding-top:2.5cm;
	padding-bottom:4.5cm;*/
	margin: 2.0cm 1.5cm 2.5cm 1.5cm ;
}

body {
   display:table;
   table-layout:fixed;
   padding-top:0.5cm;
   padding-bottom:2.5cm;
   height:auto;
}

@page :first {
	/*padding-top:1.5cm;
	padding-bottom:4.5cm;*/
	
	margin: 0.5cm 1.5cm 3.0cm 1.5cm ;

}


/* div.printBt {
	page:printBt ;
	position: fixed;
	bottom: 20px;
	margin-left: 75px;
	margin-right: 50px;
	visibility:hidden;
} */
}

@page Section1 {
size:5.8in 8.3in; 
/*margin:.10in .5in .10in .5in; 
mso-header-margin:.10in; 
mso-footer-margin:.10in; 
mso-paper-source:0;*/
}

body
{
	background-color:#FFF;
	
}
 
.style4 {
	font-size: 14px;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}
.style1 {	
	font-size: 16px;
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
	font-size: 24px;
	font-weight: bold;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}
.style8 {	
	font-size: 13px;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
}
.style9 {	
	font-size: 26px;
	font-weight: bold;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
}

/* div.printBt {
	page:printBt ;
	position: fixed;
	bottom: 20px;
	margin-left: 75px;
	margin-right: 50px;
} */

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

if((isset($_POST["submitBck"]))  && $_POST!=="") 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}
 
	echo '<script type="text/javascript">';		
	echo "window.close();";
	echo "</script>";
	exit(); //quit the script
	   
}//end submitBck




?>


<body class="A4 landscape">

<p>&nbsp;</p>

<center>

 <form action="ftp_delivery_orderPerd2_serendah.php?suid2=<?php echo (base64_encode($suid2)); ?>&&so_no=<?php echo $so_no; ?>&&pdio_no=<?php echo $pdio_no; ?>" method="post" name="myform" id="myform">
     <table width="98%" border="0" cellspacing="1" cellpadding="1">
     <tr>
      <td colspan="6"><p><img src="../set_upload/<?php echo $filename;  ?>"width="267" height="27" hspace="2" vspace="2"/></p>
        <p><h3>Create Delivery Order</h3></p>
       </td>
      </tr>
      </table>
<?php

$suid2 = base64_decode($_GET["suid2"]);
$so_no = $_GET["so_no"];
$pdio_no = $_GET["pdio_no"];

$no = 1;

//$uid = $_GET["uid"];

//--------- pps detail ------------

$query_pps = "SELECT *,DATE_FORMAT(date_posting,'%d-%m-%Y') as R, DATE_FORMAT(dlv_date,'%d-%m-%Y') as R7 FROM ftp_dlv_ord_all_delivery WHERE scan_gen = '".sql_esc($suid2)."' GROUP BY file_name";
$result_pps = mysqli_query($dbc,$query_pps);


	
?>
<div class=Section1>

     <table width="98%" border="0" cellspacing="1" cellpadding="1">
     <tr>
      <td colspan="6"><p><b>PSS Delivery Order  </b></p></td>
      </tr>
      </table>
      <table width="98%" border="0" cellspacing="1" cellpadding="1">
      <tr>
      <th>NO.</th>
      <th>CUST DI/PDIO NUMBER</th>
      <th>PSS DO NUMBER</th>
      <th>TEXT FILE NAME</th>
      <th>OPTION</th>
     </tr>
     <?php
	while($row = mysqli_fetch_array($result_pps))

{
	
	    $query_by_groupF = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T5 from dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($row["material_doc_gen"])."' AND scan_gen = '".sql_esc($suid2)."'";
        $result_by_groupF = mysqli_query($dbc,$query_by_groupF);   //run the query.
		$row_by_groupF = mysqli_fetch_array($result_by_groupF);
		
		$dtcrt = $row_by_groupF["T5"];
      //-------get issued detail----
	  
	  $query_issueF = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$row_by_groupF["user_post"]]);
	  $result_issueF = db_query($dbc, $query_issueF);
	  $data_issueF = mysqli_fetch_array($result_issueF);	
	  
	  $ffff = $data_issueF["user_fullname"];
	  $mtdoc2 = $row["material_doc_gen"];
	   
	   
	    $buid2 = (base64_encode($mtdoc2));
	    $puid2 = (base64_encode($ffff));
		$duid2 = (base64_encode($dtcrt));
	 ?>
      <tr>
      <td width="10%"><?php echo $no; ?></td>
      <td width="25%"><?php echo html_esc($row["pdio_no"]); ?></td>
      <td width="15%"><?php echo html_esc($row["material_doc_gen"]); ?></td>
      <td width="15%"><a href="../FromPortal2/DO/<?php echo html_esc($row["file_name"]); ?>.csv" target="_blank"><?php echo html_esc($row["file_name"]); ?></a></td>
      <td width="15%">&nbsp;&nbsp;<a href="ftp_dlvdo-print_perodua_serendah.php?buid=<?php echo $buid2; ?>&&puid=<?php echo $puid2; ?>&&duid=<?php echo $duid2; ?>" target="_blank"><img src="../images/printe1.gif" width="16" height="14" hspace="2" vspace="2"/></a></td>
      </tr>
   
    <?php    
	
	$no++; 
	
	} //end while loop ?>
  </table> 

   
<p>&nbsp;</p>


 <table width="98%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td width="80%">&nbsp;</td>
          <td>&nbsp; <input name="submitBck" type="submit" id="submitBck" value="OK" class="btn btn-success btn-sm"  >
        </tr>
    </table>
    <p>&nbsp;</p>

</div>
   </form>  
</center>
<!--<div class="printBt">
<input type="button" id="btnprint" value="Print this Page" onclick="print_page()" class="btn btn-success"/>
</div>
-->

    <!--Footer-part-->


<!--end-Footer-part--> 

</body>
</html>