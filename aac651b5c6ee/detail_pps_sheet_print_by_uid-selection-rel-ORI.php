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
 bottom: 0;
   
}
/* @media print{
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
  
} */
	
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
    <body class="app sidebar-mini">


  <?php
  
          // $id = base64_decode($_GET["id"]);
		     $id = $_GET["id"];
			 
	  $query_bac_prt_pps = "SELECT * FROM prt_sheet_pps_release WHERE doc_generate = '".sql_esc($id)."'";
	  $result_bac_prt_pps = mysqli_query($dbc,$query_bac_prt_pps);
	 
	 
	 while($dt_bac_prt_pps = mysqli_fetch_array($result_bac_prt_pps))	 
			 
	{	
			/*echo "id : ".$dt_bac_prt_pps["id_pps_dtl"];   echo "&nbsp;&nbsp;&nbsp; work : ".$dt_bac_prt_pps["work_center"];
			echo "<br>";*/
		   
$queryu2 = "SELECT *, DATE_FORMAT(MR.date_plan,'%d-%m-%Y') AS T, DATE_FORMAT(MR.date_plan,'%d%m%Y') AS T2, DATE_FORMAT(MR.date_upload,'%d-%m-%Y %H:%i:%s') AS K FROM pps_detail AS MR, work_center_detail AS SR, prt_sheet_pps_release AS PN WHERE PN.id_pps_dtl = MR.id AND SR.id_work = MR.work_center AND PN.work_center = SR.id_work AND MR.id = '".sql_esc($dt_bac_prt_pps["id_pps_dtl"])."' AND (MR.status_pps = '".sql_esc($rst_sta2["status_desc"])."' OR MR.status_pps = '".sql_esc($rst_sta7["status_desc"])."') GROUP BY MR.work_center";
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
 
 
/* echo "id colom 2 : ".$db_rs2["id"];  echo "&nbsp;&nbsp;&nbsp; work : ".$db_rs2["work_center"]; echo "<br>"; 
*/ ?>

<div class="page">
<br>
  <!--  <div class="page"> -->
    
	   
	   

        <?php
	 $query_by_group =  "SELECT *, DATE_FORMAT(MR.date_plan,'%d-%m-%Y') AS T, DATE_FORMAT(MR.date_plan,'%d%m%Y') AS T2, DATE_FORMAT(MR.date_upload,'%d-%m-%Y %H:%i:%s') AS K from pps_detail AS MR, work_center_detail AS SR, prt_sheet_pps_release AS PN WHERE PN.id_pps_dtl = MR.id AND SR.id_work = MR.work_center AND MR.id = '".sql_esc($db_rs2["id"])."' AND MR.work_center = '".sql_esc($db_rs2["work_center"])."' AND (MR.status_pps = '".sql_esc($rst_sta2["status_desc"])."' OR MR.status_pps = '".sql_esc($rst_sta7["status_desc"])."') GROUP BY MR.work_center";
	 
	 
	 
	 //
			 
			 
	 /* $query_by_group = "SELECT *, DATE_FORMAT(MR.date_plan,'%d-%m-%Y') AS T, DATE_FORMAT(MR.date_upload,'%d-%m-%Y %H:%i:%s') AS K FROM pps_detail AS MR, prt_sheet_pps_new AS PN WHERE MR.id = PN.id_pps_dtl AND MR.id = '".$db_rs2["id"]."' AND MR.status_pps = '".$rst_sta["status_desc"]."' AND MR.work_center = '".$db_rs2["work_center"]."' "; */
      $result_by_group = mysqli_query($dbc,$query_by_group);   //run the query.
		
      $counter = 1;
      $no = 1;
	  $i = 1; 
	
   
   while($row3 = mysqli_fetch_array($result_by_group)){
   
   //echo "id colom 3 : ".$row3["id"];  echo "&nbsp;&nbsp;&nbsp; work colom 3: ".$row3["work_center"]; echo "<br>"; 
  
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
	 ?>
     
     <table cellpadding="2" cellspacing="2" class="table-bordered">
  <tr>
    <td width="35%" > <img src="../set_upload/<?php echo $filename;  ?>" width="300" height="70"/></td>
    <td width="30%"><div align="center"><h5>Production Planning Sheet</h5></div></td>
    <td width="35%"><table width="96%" class="table-borderless">
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
        <th> <?php echo $db_rs2["work_center"]; ?></th>
        </tr>
        <tr>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        </tr>
    </table></td>
    <td>&nbsp;</td>
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
        <th height="28"><div align="left"><span class="style3">Filename</span></div></th>
        <th height="28"><span class="style3">:</span></th>
        <th height="28"><span class="style3"><?php echo  $data_ftp_pps["file_name"]; ?></span></th>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="3"> 
     
     
       <table class="table">
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
      </thead>
   <!--   <tbody>-->	 
     
     
     <?php
       //---------get material header---------
	    $query_mat_h = "SELECT * FROM mat_master_header AS HD, mat_master_detail AS AD WHERE HD.material_no = AD.material AND HD.material_no = '".sql_esc($row3['material_no'])."'";
		$result_mat_h = mysqli_query($dbc,$query_mat_h);
		$data_mat_h = mysqli_fetch_array($result_mat_h);	
		
		  //---------get material detail---------
	    $query_mat_d = "SELECT * FROM mat_master_detail WHERE (material = '".sql_esc($row3['material_no'])."' OR bill_component = '".sql_esc($row3['material_no'])."')";
		$result_mat_d = mysqli_query($dbc,$query_mat_d);
		$data_mat_d = mysqli_fetch_array($result_mat_d);	
		
		echo '<tbody><tr >'; 
        if ($i && $i % 6 == 0) 
		echo '</tr><tr class="breakAfter">'; 
		else if ($i)  
		echo '<tr>';  
	    ++$i;  

		 ?>
       <!-- <tr>-->
          <td width="60" height="28"><?php  echo $no; ?></td>
          <td width="60" height="28"><?php  echo $row3["model_code"]; ?></td>
          <td width="384"><b><?php  echo $row3["material_no"]; ?></b><br><?php  echo $data_mat_h["material_desc"]; ?></td>
          <td width="151" height="28"><div align="center"><?php echo $row3["plan_no"]; ?></div></td>
          <td width="93" height="28"><?php  echo $row3["T"]; ?></td>
          <td width="46" height="28"><div align="center"><font color="#FF0000"><?php echo $sta; ?></font></div></td>
          <td width="46"><div align="center"><?php echo $row3["seq_pps"]; ?></div></td>
          <td width="69" height="28"><div align="center"><?php  echo intval($row3["qty_plan"]); ?></div></td>
          <td width="55" height="28"><div align="center"><font color="#FF0000">
            <?php  echo $data_mat_h["BUn"]; ?>   </font></div></td>
          <td width="90" height="28"> <div align="left">
       <?php
	   
       //---qty convert ----
        $qty_new = (intval($row3["qty_plan"]));
	   
// set the barcode content and type

$bar_text = ($row3["material_no"].'|'.$row3["plant_code"].'|'.$row3["plan_no"].'|'.$row3["T2"].'|'.$row3["work_center"].'|'.$qty_new.'|'.$sta.'|'.$data_mat_h["BUn"]);


$barcodeobj = new TCPDF2DBarcode($bar_text, 'QRcode');
echo $barcodeobj->getBarcodeSVGcode(3.0, 3.0, 'black');

?>
                  </div></td>
          <td width="44"><?php  echo $row3["status_pps"]; ?></td>
          <td width="140">&nbsp;</td>
          </tr>
        <?php 
		  
		     $counter++; // menambah counter 
			 $no++;   
			   
			   
			   }
			   
			   
			   ?>
      </tbody>
    </table><?php //include "footer.php";   ?></td>
    </tr>
</table></div>


<?php    } // end while loop main


	}//end while loop batch file

   ?>

              
              
          
              <div class="modal-footer">  
              
              <input type="hidden" name="upload_id" value="<?php echo $row["upload_id"]; ?>">
              <input type="button" id="btnprint" value="Print this Page" onClick="print_page()" class="btn btn-success btn-sm"/>

              
             </div>  
         
         <!-- 
                <!--  </div>--><!--</div>
                  </div>
                  </div>
                  </div>
                  </div>-->
</body>
</html>