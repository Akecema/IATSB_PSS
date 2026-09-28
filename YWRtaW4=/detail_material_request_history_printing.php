<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "report_PPC.php"; 
	require_once('/tcpdf_barcodes_2d.php');

	
//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	

//--------menu function ------------------------------

$query_function = "SELECT * FROM function_acc_detail WHERE staff_ID = '".sql_esc($res["staff_ID"])."'";
$result_function = mysqli_query($dbc,$query_function);   //run the query.
//$data_function = mysqli_fetch_array($result_function);   //how many records are there?  

//----------------------------------------------------

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
  <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?>">
    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
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
  </head>
    <body class="app sidebar-mini">

  <div class="modal fade printable autoprint" id="myNotePrint<?php echo html_esc($row2["temp_mrin"]); ?><?php echo html_esc($row2["prod_order"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display Material Request</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
        <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Display Material Request</strong>
       </div>
   <?php
   
	$queryu = "SELECT * from material_request WHERE temp_mrin = '".sql_esc($row2["temp_mrin"])."'";
	$rsu = mysqli_query($dbc,$queryu);   //run the query.
	$db_rs = mysqli_fetch_array($rsu);


	$query_2 = "SELECT *, DATE_FORMAT(MR.date_mrin,'%d-%m-%Y') as R, DATE_FORMAT(MR.date_posting,'%d-%m-%Y') as R2 from material_request as MR, scan_detail as SD WHERE MR.id_scan = SD.id_scan AND MR.temp_mrin = '".sql_esc($row2["temp_mrin"])."'";
	$result_2 = mysqli_query($dbc,$query_2);   //run the query.
	$data_2 = mysqli_fetch_array($result_2);

    $query3 = "SELECT * FROM factory_detail WHERE id_fac = '".sql_esc($data_2["factory"])."'";
    $result3 = mysqli_query($dbc,$query3);
	$row3 = mysqli_fetch_array($result3);
	
	$query_k = "SELECT * from user_detail WHERE user_no = '".sql_esc($data_2["user_create"])."'";
	$result_k = mysqli_query($dbc,$query_k);
	$row_k = mysqli_fetch_array($result_k);

	$query_k2 = "SELECT * from user_detail WHERE username = '".sql_esc($data_2["user_update"])."'";
	$result_k2 = mysqli_query($dbc,$query_k2);
	$row_k2 = mysqli_fetch_array($result_k2);
   
     
   ?>
 
      <table class="table table-bordered table" >
        <tr>
          <th>MRIN No</th>
          <th>:</th>
          <th><?php echo html_esc($row2["temp_mrin"]); ?></th>
          <th>Factory</th>
          <th>:</th>
          <th><?php echo html_esc($data_2["factory"]);  ?></th>
        </tr>
        <tr>
          <th>Date &amp; Time</th>
          <th>:</th>
          <th><?php echo html_esc($data_2["R2"]); ?>&nbsp;<?php echo html_esc($data_2["time_posting"]); ?></th>
          <th>Required Date &amp; Time</th>
          <th>:</th>
          <th><?php echo html_esc($data_2["R"]); ?>&nbsp;<?php echo html_esc($data_2["time_mrin"]); ?></th>
        </tr>
        <tr>
          <th>Requested by</th>
          <th>:</th>
          <th><?php echo html_esc($row_k["user_fullname"]); ?></th>
          <th>Prepared by (PPC)</th>
          <th>:</th>
          <th><?php echo html_esc($row_k2["user_fullname"]); ?></th>
        </tr>
      </table>
      <br>
   
			<form name="form1" method="post" action="">
               <table class="display nowrap" style="width:100%">
               <thead>
                <tr>
                 <th>Material Number</th>
                 <th>Material Description</th>
                 <th>Uom</th>
                 <th>Prod Order</th>
                 <th>Material Produce</th>
                 <th>Line</th>
                 <th>Transfer Location</th> 
                 <th>Received Sloc</th>
                 <th>Requested Quantity</th>
                 <th>Transfer Quantity</th>
                 <th>Outstanding Quantity</th>
                 <th>&nbsp;</th>
                </tr>
              </thead><tbody>
              <?php

      $counter = 1;
      $no = 1;
   
   while ($row_u = mysqli_fetch_array($rsu))
   {
		//$user_no = $row[0]; 
    $no = sprintf('%03d', $no);
		
   
   $query_scan = "SELECT * FROM scan_detail WHERE id_scan = '".sql_esc($row_u["id_scan"])."'";
   $result_scan = mysqli_query($dbc,$query_scan);
   $row_scan = mysqli_fetch_array($result_scan);
   
		 
   $query1_p = "SELECT * FROM scan_detail WHERE id_scan = '".sql_esc($row_u["id_scan"])."' GROUP BY id_scan";
   $result1_p = mysqli_query($dbc,$query1_p);
   $row1_p = mysqli_fetch_array($result1_p);
	
		 
  $query4_p = "SELECT * from mat_master_header as LD, mat_master_detail as SD WHERE SD.id_hdr = LD.id_hdr and SD.id_hdr = '".sql_esc($row_u["id_hdr"])."'";
  $result4_p = mysqli_query($dbc,$query4_p);
  $row4_p = mysqli_fetch_array($result4_p); 
		  	 
     if($row4_p["mat_type"] == "Z110")
	{
	  $sta = "W110";
	} elseif($row4_p["mat_type"] == "Z210")	 
	{
	  $sta = "W110";
	} elseif($row4_p["mat_type"] == "Z310")
	 {
	  $sta = "";
	  }else{
	  $sta = "Invalid";
	  }
	  
		 
		if(($row_u["bom_qty"] != "") && ($row_u["bom_qty"] != "0.000"))
		{

		 ?>

                <tr>
                <td><?php  echo html_esc($row4_p["bill_component"]); ?></td>
                <td><?php  echo html_esc($row4_p["material_desc_c"]); ?></td>
                <td><div align="center"><?php echo html_esc($row_u["bom_oum"]); ?></div></td>
                <td><div align="center"><?php echo html_esc($row_scan["prod_order"]); ?></div></td>
                <td><?php  echo html_esc($row4_p["material"]); ?></td>
                <td><div align="center"><font color="#FF0000"><?php echo html_esc($row1_p["work_center"]); ?></font></div></td>
                <td><div align="center"><?php echo $sta; ?></div></td>
                <td><div align="center"><font color="#FF0000"><?php echo html_esc($row4_p["isloc"]); ?></font></div></td>
                <td><div align="right"><?php echo html_esc($row_u["bom_qty"]); ?>&nbsp;</div></td>
                <td>
                 <div align="right">
	                <?php 
					
    $query_tp = "SELECT *,SUM(rquantity) as TOT FROM post_detail_header WHERE mrin_no = '".sql_esc($row_u["temp_mrin"])."' AND prod_order = '".sql_esc($row_scan["prod_order"])."' AND mvt_type = 311 AND material_no = '".sql_esc($row4_p["bill_component"])."' AND status_posting != '".sql_esc($rst_sta21["status_desc"])."'";
	$result_tp  = mysqli_query($dbc,$query_tp); 
	//$row_tp = mysql_fetch_assoc($result_tp); 
		
					
		$outs_qty = 0;
					
	while($row_tp = mysqli_fetch_assoc($result_tp))
   {
	echo html_esc($row_tp["TOT"]); 
	
	$tp_quantity = $row_tp["TOT"]; 
	
	$outs_qty = (($row_u["bom_qty"]) - ($row_tp["TOT"]));
	
	 }//end while $row_tp	
	 
	$outs_qty1 = number_format($outs_qty,3);
	

	 ?>
       </div></td>
     <td><div align="right"><?php echo $outs_qty1; ?></div></td>
     <td><div align="center">
  <?php                 
                	//-------------------------------------------------------
					// tick and cross icon for update status
					//------------------------------------------------------------
   								
        if(($row_u["bom_qty"] == $tp_quantity) || ($row_u["bom_qty"] < $tp_quantity))
        {        

?>
              <img src="../images/tick.png" width="15" height="15" title="OK"/>
             
            <?php
	   }elseif(($row_u["bom_qty"] > $tp_quantity))
       {

?>
              <img src="../images/cross.png" width="15" height="15" title="Not OK"/>
    <?php
	
	} else{
	
	
	echo "invalid";  }   
                
     ?> 
    </div>           
    </td> 
    </tr>
      <?php 
		   }// end if else
		
		  
		  $counter++; // menambah counter 
          $no ++;   
			   
			   }
			   
      ?> </tbody>
        </table>  
             <p>&nbsp;</p> 
         <?php
		
	$query_display_reason = "SELECT * from material_request_cancel WHERE temp_mrin = '".sql_esc($row2["temp_mrin"])."' AND status = '".sql_esc($rst_sta21["status_desc"])."'";
    $result_display_reason = mysqli_query($dbc,$query_display_reason);
    $row_display_reason = mysqli_fetch_array($result_display_reason);
	
	$query_reason_tbl = "SELECT * from reason_req_cancel WHERE id_cancel = '".sql_esc($row_display_reason["reason_cancel"])."'";
	 $result_reason_tbl = mysqli_query($dbc,$query_reason_tbl);
    $row_reason_tbl = mysqli_fetch_array($result_reason_tbl);
	
	if($row_display_reason	> 0)
	{   
		?>
        <table width="80%" border="0" cellpadding="2" cellspacing="2" style="border:solid 1px #d5d5d5;">
  <tr>
    <th width="13%" height="40"><div align="right">Reason</div></th>
    <th width="3%" height="40">:</th>
    <td width="84%" height="40"><?php echo html_esc($row_reason_tbl["reason_desc_cancel"]).' - ' . html_esc($row_display_reason["reason_cancel2"]); ?></td>
  </tr>
</table>
<?php
  }

		
	$query_display_reason2 = "SELECT * from material_request_close WHERE temp_mrin = '".sql_esc($row2["temp_mrin"])."' AND status = '".sql_esc($rst_sta22["status_desc"])."'";
    $result_display_reason2 = mysqli_query($dbc,$query_display_reason2);
    $row_display_reason2 = mysqli_fetch_array($result_display_reason2);
	
	$query_reason_tbl2 = "SELECT * from reason_req_close WHERE id_close = '".sql_esc($row_display_reason2["reason_close"])."'";
	$result_reason_tbl2 = mysqli_query($dbc,$query_reason_tbl2);
    $row_reason_tbl2 = mysqli_fetch_array($result_reason_tbl2);
	
	if($row_display_reason2	> 0)
	{   
		?>
        <table width="80%" border="0" cellpadding="2" cellspacing="2" style="border:solid 1px #d5d5d5;">
  <tr>
    <th width="13%" height="40"><div align="right">Reason</div></th>
    <th width="3%" height="40">:</th>
    <td width="84%" height="40"><?php echo html_esc($row_reason_tbl2["reason_desc"]).' - ' . html_esc($row_display_reason2["reason_close2"]); ?></td>
  </tr>
</table>
<?php
  }


?>
 <br>                        
       </div> <!-- card -->
       </div><!-- /# card -->
       <br />
              <div class="modal-footer">  
               <button type="button" class="btn btn-primary" onclick="window.print();">PRINT</button>
               <button type="button" class="btn btn-success" data-dismiss="modal">CLOSE</button>    
            <!--  <input type="submit" name="submit2" value="Close" class="btn btn-success" />-->
             </div>  
          </form>   
      
                  </div></div>
                  </div>
                  </div>
                  </div>
                  </div>
</body>
</html>