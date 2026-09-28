<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "1")) {
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

//CR status (Pending Approve)
$sta15 = "SELECT * from request_status WHERE status_id = '15'";
$sta_res15 = mysqli_query($dbc,$sta15);
$rst_sta15 = mysqli_fetch_array($sta_res15);

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

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);

//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc,$sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);

//CR status (Pending Approval COO)
$sta25 = "SELECT * from request_status WHERE status_id = '25'";
$sta_res25 = mysqli_query($dbc,$sta25);
$rst_sta25 = mysqli_fetch_array($sta_res25);

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

//CR status (Pending Approval Exec QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

//CR status (Pending Approve STM)
$sta32 = "SELECT * from request_status WHERE status_id = '32'";
$sta_res32 = mysqli_query($dbc,$sta32);
$rst_sta32 = mysqli_fetch_array($sta_res32);

//CR status (Pending Approve ASSY)
$sta34 = "SELECT * from request_status WHERE status_id = '34'";
$sta_res34 = mysqli_query($dbc,$sta34);
$rst_sta34 = mysqli_fetch_array($sta_res34);

//---------------------------------------------------------

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
   
</head>
<body>

<?php

//if(isset($_POST['download'])) 
//{ // handle the form.
date_default_timezone_set('Asia/Kuala_Lumpur');
$date_tdy = date('d-m-Y H:i:s');
set_time_limit(0);

            
		
	
	//********** END CONDITION **************
 

$namaFile = "Template BOM Header ".$date_tdy.".xls";


header('Content-type: application/excel');                                  
header('Content-Disposition: attachment; filename='.$namaFile.'');
//header('Content-Type: image/jpeg');
header("Pragma: no-cache");
header("Expires: 0");

$content = "";
$data = "";	

//Create report header 
/*
$content .= "<p><font size='10px'><strong> ".strtoupper($data_setup["title_desc"])."</strong></font></p>";
$content .= "Date : " .$date_tdy."";


echo $content;*/

 //-------Count all results------------------------//	
	
echo '<table border="1" width="100%">';
echo '<tr height="35">';
echo '<th width="5" bgcolor="#83afab">ID Header</th>';
echo '<th width="5" bgcolor="#83afab">Material No.</th>';
echo '<th width="5" bgcolor="#83afab">Material Description</th>';
echo '<th width="5" bgcolor="#83afab">Material Type (Z301/Z201)</th>';
echo '<th width="5" bgcolor="#83afab">Material Group</th>';
echo '<th width="5" bgcolor="#83afab">Plant Code</th>';
echo '<th width="5" bgcolor="#83afab">BOM Usage</th>';
echo '<th width="5" bgcolor="#83afab">BOM</th>';
echo '<th width="5" bgcolor="#83afab">Alternative BOM</th>';
echo '<th width="5" bgcolor="#83afab">BUn</th>';
echo '<th width="5" bgcolor="#83afab">Date Create (yyyy-mm-dd)</th>';
echo '<th width="5" bgcolor="#83afab">Date BOM Create (yyyy-mm-dd)</th>';
echo '<th width="5" bgcolor="#83afab">Status BOM</th>';
echo '<th width="5" bgcolor="#83afab">Standard Package</th>';
echo '<th width="5" bgcolor="#83afab">Type Package</th>';
echo '<th width="5" bgcolor="#83afab">Location Dlv.</th>';
echo '<th width="5" bgcolor="#83afab">Station Dlv.</th>';
echo '<th width="5" bgcolor="#83afab">Receive Point</th>';
echo '<th width="5" bgcolor="#83afab">Part Side RH/LH</th>';
echo '<th width="5" bgcolor="#83afab">Work Center/Line</th>';
echo '<th width="5" bgcolor="#83afab">Valid From (yyyy-mm-dd)</th>';
echo '<th width="5" bgcolor="#83afab">Valid To (yyyy-mm-dd)</th>';
echo '<th width="5" bgcolor="#83afab">Category Transit(A,S,T)</th>';
echo '<th width="5" bgcolor="#83afab">VClass</th>';
echo '<th width="5" bgcolor="#83afab">Model</th>';
echo '</tr>';
echo '</table>';

//-------------------------------content table -------------------------------
   
        echo '<table border="1" width="100%">';
		echo '<tr height="35">';
		echo '<td>&nbsp;</td>'; 
		echo '<td>PW935217</td>'; 	
		echo '<td>SFG-SG-P1-P213A BKT OS MIRROR BLANK RH</td>'; 
		echo '<td>Z201</td>'; 
		echo '<td>D55L</td>'; 	
		echo '<td>3100</td>';  
		echo '<td>1</td>';  	
		echo '<td>4517</td>'; 	
		echo '<td>1</td>';
		echo '<td>PCS</td>';
		echo '<td>&nbsp;2013-02-03</td>';  
		echo '<td>&nbsp;2013-02-03</td>';
		echo '<td>Y</td>';	
		echo '<td>&nbsp;</td>';  
	    echo '<td>&nbsp;</td>';
		echo '<td>&nbsp;</td>';
		echo '<td>&nbsp;</td>';
        echo '<td>&nbsp;</td>';
		echo '<td>RH</td>';
        echo '<td>N1P1</td>';
		echo '<td>&nbsp;2013-02-03</td>';  
		echo '<td>&nbsp;9999-12-31</td>';
		echo '<td>A</td>';
		echo '<td>Z202</td>';
	    echo '<td>D55L</td>';
        echo '</tr></table>'; 



echo iconv('utf-8', 'cp1251', "$data"); 
?>
</body>
</html>


