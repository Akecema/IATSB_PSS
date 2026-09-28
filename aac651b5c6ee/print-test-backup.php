<?php

session_start();
$username = $_SESSION['username'];
include '../include/config.php';

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
   
 	 <link rel="stylesheet" type="text/css" href="css/prt-sheet.css">
     
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    <script language="javascript">
    jQuery.fn.extend({
	printElem: function() {
		var cloned = this.clone();
    var printSection = $('#printSection');
    if (printSection.length == 0) {
    	printSection = $('<div id="printSection"></div>')
    	$('body').append(printSection);
    }
    printSection.append(cloned);
    var toggleBody = $('body *:visible');
    toggleBody.hide();
    $('#printSection, #printSection *').show();
    window.print();
    printSection.remove();
    toggleBody.show();
	}
});

$(document).ready(function(){
	$(document).on('click', '#btnPrint', function(){
  	$('.printMe').printElem();
  });
});

</script>



<script type="text/javascript">
	function print_page() {
		var ButtonControl = document.getElementById("btnprint");
		ButtonControl.style.visibility = "hidden";
		window.print();
	}
</script>

<style>

.prt-button {
  position: relative;
  display: inline-block;
  cursor: pointer;
  vertical-align: middle;
  margin-left:92%;
  margin-bottom: 30px;
  border-radius: 2px;
  width: 100px;
  
  margin-right: -10px;
}
.titleHdr {
	text-align:left;
	font-size:13px;
	font-weight:bold;
	margin: auto;
	border:none;
	padding: 2px;
}

.sheetName {
	text-align:center;
	font-size:17px;
	font-weight:bold;
	margin: auto;
	padding: 2px;
}


<!--main-->
table.sheetmain 
{
	border: 3px solid #000000;
}
<!--/n main-->


<!--header-->
table.sheethdr td.sheettd
{
	color: #cccccc;/*font color*/
	padding: 4px;
	text-align: right;
	/*font-family: Trebuchet MS, Arial, Helvetica, Sans-Serif ;*/
	font-size: 16px;
	font-weight: bold;
}
<!--/n header-->

table.sheetrcord
{
	border: 1px solid #999999;
}

table.sheetrcord th.sheethed
{
	color: #000000;/*font color*/
	padding-left: 14px;
	border: 1px solid #B7B7B7;
	/*font-family: Trebuchet MS, Arial, Helvetica, Sans-Serif ;*/
	font-size: 13px;
	font-weight: bold;
	line-height:20px;
}

table.sheetrcord td.sheethed 
{
	color: #000000;/*font color*/
	padding-left: 14px;
	border: 1px solid #B7B7B7;;
	/*font-family: Trebuchet MS, Arial, Helvetica, Sans-Serif ;*/
	font-size: 13px;
}


</style>

</head>
<body class="app sidebar-mini">
    
<?php
	
$query_pps = "SELECT * FROM prt_sheet_pps_new_test where doc_generate='".sql_esc($prtid)."' group by work_center,date_plan ORDER BY date_plan ASC";
$result_pps = mysqli_query($dbc,$query_pps);

while($dt_pps = mysqli_fetch_array($result_pps))
{	
	$prt_HDR = "SELECT *,DATE_FORMAT(PS.date_plan,'%d-%m-%Y') AS H FROM pps_detail_test as PS WHERE id = '".sql_esc($dt_pps['id_pps_dtl'])."' ";
	$resprt_HDR = mysqli_query($dbc,$prt_HDR);
	$dtprt_HDR = mysqli_fetch_array($resprt_HDR);
	
?>

<!--table full-->
<table width="100%" class="sheetmain">
  <tr>
    <td>
    <!--row header-->
    <table width="100%" border="1" style="border:#B7B7B7">
      <tr>
        <td colspan="3" > <img src="../set_upload/<?php echo $filename;  ?>" width="300" height="70"/></td>
        <td width="448" class="sheetName">Production Planning Sheet</td>
        <td width="308" colspan="3">
        
        <!--header Doc no-->
        <table width="100%" border="0">
          <tr>
            <td width="42%" class="titleHdr">Doc No. </td>
            <td width="8%" class="titleHdr">:</td>
            <td width="50% class="titleHdr"">&nbsp;</td>
          </tr>
          <tr>
            <td width="42%" class="titleHdr">Rev. No.</td>
            <td width="8%" class="titleHdr">:</td>
            <td width="50%" class="titleHdr">&nbsp;</td>
          </tr>
          <tr>
            <td width="42%" class="titleHdr"> Date</td>
            <td width="8%" class="titleHdr">:</td>
            <td width="50%" class="titleHdr">&nbsp;</td>
          </tr>
        </table>
        <!--/n header Doc no-->
        
        </td>
      </tr>
      
      <tr>
        <td colspan="3" width="35%">
        <!--header plant-->
        <table width="100%">
          <tr>
            <td width="32%" class="titleHdr">Plant</td>
            <td width="4%" class="titleHdr">:</td>
            <td width="64%" class="titleHdr"><?php echo html_esc($dtprt_HDR["plant_code"]); ?></td>
          </tr>
          <tr>
            <td class="titleHdr">Production Line</td>
            <td class="titleHdr">:</td>
            <td class="titleHdr"><?php echo html_esc($dtprt_HDR["work_center"]); ?></td>
          </tr>
        </table>
        <!--/n header plant-->    
        </td>
        <td width="36%">&nbsp;</td>
        <td colspan="3" width="30%">
        <!--header month -->
        <table width="100%" border="0">
          <tr>
            <td width="42%" class="titleHdr">Month/Year</td>
            <td width="8%" class="titleHdr">:</td>
            <td width="50%" class="titleHdr"><?php echo html_esc($dtprt_HDR["month_plan"]); ?>/ <?php echo html_esc($dtprt_HDR["year_plan"]); ?></td>
          </tr>
          <tr>
            <td width="42%" class="titleHdr">Date</td>
            <td width="8%" class="titleHdr">:</td>
            <td width="50%" class="titleHdr"><?php echo html_esc($dtprt_HDR["H"]); ?></td>
          </tr>
          <tr>
            <td width="42%" class="titleHdr">Page</td>
            <td width="8%" class="titleHdr">:</td>
            <td width="50%" class="titleHdr">&nbsp;</td>
          </tr>
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
    <table width="100%"  class="sheetrcord">
    <tr>
        <th class="sheethed">No.</th>
        <th class="sheethed">Model</th>
        <th class="sheethed">Part No. / Part Name</th>
        <th class="sheethed">Planned Order No.</th>
        <th class="sheethed">Planned Start Date</th>
        <th class="sheethed">Shift</th>
        <th class="sheethed">Seq #</th>
        <th class="sheethed">Planned Order Quantity</th>
        <th class="sheethed">UOM</th>
        <th class="sheethed">QR Code</th>
        <th class="sheethed">Status</th>
        <th class="sheethed">Remarks</th>
    </tr>
    <?php
    //$query_pps2 = "SELECT * FROM pps_detail_test where doc_generate='2380000040' and work_center = '$dt_pps[work_center]' ";
    $query_pps2 = "SELECT * FROM prt_sheet_pps_new_test where doc_generate='".sql_esc($dt_pps['doc_generate'])."' and work_center = '".sql_esc($dt_pps['work_center'])."' and date_plan = '".sql_esc($dt_pps['date_plan'])."' ";
    $result_pps2 = mysqli_query($dbc,$query_pps2);
    
    $counter = 1;
    $no = 1;
    $i = 1; 
    
    
    while($dt_pps2 = mysqli_fetch_array($result_pps2))
    {
        
        /*$prt_pps = "SELECT *,DATE_FORMAT(MR.date_plan,'%d-%m-%Y') AS T, DATE_FORMAT(MR.date_plan,'%d%m%Y') AS T2, DATE_FORMAT(MR.date_upload,'%d-%m-%Y %H:%i:%s') AS K 
						FROM pps_detail_test AS MR, work_center_detail AS SR, prt_sheet_pps_new AS PN  
							WHERE MR.id = '$dt_pps2[id_pps_dtl]' AND PN.id_pps_dtl = MR.id AND SR.id_work = MR.work_center AND MR.work_center = '".$dt_pps2["work_center"]."' 
								AND MR.status_pps = '".$rst_sta["status_desc"]."' ";*/
		$prt_pps = "SELECT *,DATE_FORMAT(MR.date_plan,'%d-%m-%Y') AS T, DATE_FORMAT(MR.date_plan,'%d%m%Y') AS T2, DATE_FORMAT(MR.date_upload,'%d-%m-%Y %H:%i:%s') AS K 
						FROM pps_detail_test AS MR 
							WHERE MR.id = '".sql_esc($dt_pps2['id_pps_dtl'])."' AND MR.status_pps = '".sql_esc($rst_sta["status_desc"])."' ";
        $resprt_pps = mysqli_query($dbc,$prt_pps);
        $dtprt_pps = mysqli_fetch_array($resprt_pps);
        
        
         //---------get material header---------
        $query_mat_h = "SELECT * FROM mat_master_header AS HD, mat_master_detail AS AD WHERE HD.material_no = AD.material AND HD.material_no = '". sql_esc($dtprt_pps['material_no'])."'";
        $result_mat_h = mysqli_query($dbc,$query_mat_h);
        $data_mat_h = mysqli_fetch_array($result_mat_h);	
        
          //---------get material detail---------
        $query_mat_d = "SELECT * FROM mat_master_detail WHERE (material = '". sql_esc($dtprt_pps['material_no'])."' OR bill_component = '". sql_esc($dtprt_pps['material_no'])."')";
        $result_mat_d = mysqli_query($dbc,$query_mat_d);
        $data_mat_d = mysqli_fetch_array($result_mat_d);	
		
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
        
        echo '<tbody><tr >'; 
        if ($i && $i % 6 == 0) 
        echo '</tr><tr class="breakAfter">'; 
        else if ($i)  
        echo '<tr>';  
        ++$i;  
        
    ?> 
     
    
     <tr>
        <td class="sheethed" width="3%"><?php echo html_esc($dtprt_pps['id']); ?></td>
        <td class="sheethed" width="7%"><?php echo html_esc($dtprt_pps['model_code']); ?></td> 
        <td class="sheethed" width="25%"><b><?php  echo html_esc($dtprt_pps["material_no"]); ?></b><br><?php echo html_esc($data_mat_h["material_desc"]); ?></td>
        <td class="sheethed" width="10%" height="28"><?php echo html_esc($dtprt_pps["plan_no"]); ?></td>
        <td class="sheethed" width="10%" height="28"><?php  echo html_esc($dtprt_pps["T"]); ?></td>
        <td class="sheethed" width="5%" height="28"><font color="#FF0000"><?php echo $sta; ?></font></td>
        <td class="sheethed" width="5%"><?php echo html_esc($dtprt_pps["seq_pps"]); ?></td>
        <td class="sheethed" width="6%" height="28"><?php  echo intval($dtprt_pps["qty_plan"]); ?></td>
        <td class="sheethed" width="6%" height="28"><font color="#FF0000"><?php echo html_esc($data_mat_h["BUn"]); ?></font></td>
        <td class="sheethed" width="10%" height="28"></td>
        <td class="sheethed" width="8%" height="28"><?php echo html_esc($dtprt_pps["status_pps"]); ?></td>
        <td class="sheethed" width="13%" height="28"></td>
    </tr>  
    <?php } //n while loop record ?>
    </table> 
    <!--/n row record -->
    </td>
  </tr>
</table>
<!--/n table full-->


<br/>
<?php
}//n while grouping	 
?>
<br/>


<!--button print-->
<!--<div class="btnSheetPrt">
  <input type="button" id="btnprint" value="Print this Page" onclick="print_page()" class="btn btn-success btn-sm "/>
</div-->


<div class="prt-button">
  <button type="button" name="btn_release" id="btn_release" class="btn btn-success btn-sm">Print this Page</button>
</div>




</body>
</html>