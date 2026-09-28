<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "canC_receiv_gdfoc_tran-recProc.php"; 
	require_once('tcpdf_barcodes_2d.php');
	
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

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);

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
 
  $extension = explode('.', $data_setup["logo_name"]);
  $filename = $data_setup["logo_comp"].'.'.$extension[1];
 
 
 
 //-------------- click button "Cancellation"----------------
  if(isset($_POST["canC_GRFOCbtn"])) 
  
   { // handle the form.

 
   $uid6 = $_POST["uid6"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];

	//-------------------generate gra QC doc no.---------------
	
	
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '149'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	
	
	if($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "152";
	$dg2 = 0;

  	if($row_id2["count_max"] <= 0)
  	{ 
   
    	$lastID2 = ($row_id2["count_max"] + 1);
    	$dg2 = ($dht2 + ($lastID2));
   }
   else
   {
      $lastID2 = ($row_id2["count_max"] + 1);
      $dg2 =  $lastID2;
	
    }
	$number2 = $dg2; // Length of running no
    $number2 = sprintf('%03d', $number2);  
	
    $ref6 = (($row_id2["start_ref"]).$dht_OK2.$date_run.($number2));
	  
	
	} // end if $result_id2

	
   
    //--------- Goods Receipt detail ------------
	 
	   $query_info5 = "SELECT * FROM po_detail_trans_gr_foc WHERE material_doc_gen = '".sql_esc($uid6)."' AND (status_gr = '".sql_esc($rst_sta3["status_desc"])."') AND status_po = '".sql_esc($rst_sta7["status_desc"])."'";
	   $result_info5 = mysqli_query($dbc,$query_info5);
	  
	  while($data_info5 = mysqli_fetch_array($result_info5))
	  
	  {
		  
	 // ---------update cancellation--------------------------
	 
	$query_cancelGRr = "UPDATE po_detail_trans_gr_foc SET status_po = '".sql_esc($rst_sta4["status_desc"])."', status_gr = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), time_cancel = NOW(), ref_doc_gen = '".sql_esc($ref6)."' WHERE material_doc_gen = '".sql_esc($uid6)."' AND (status_gr = '".sql_esc($rst_sta3["status_desc"])."')";
	$result_cancelGRr = mysqli_query($dbc,$query_cancelGRr);
	
	
	  
	   $query_infoa = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM po_detail_trans_gr_foc WHERE material_doc_gen = '".sql_esc($uid6)."' AND id = '".sql_esc($data_info5["id"])."' AND (status_gr = '".sql_esc($rst_sta4["status_desc"])."')";
	   $result_infoa = mysqli_query($dbc,$query_infoa);
	   $row_infoa = mysqli_fetch_array($result_infoa);
	   
	   
	   
	  $query_data2a = "INSERT INTO po_detail_trans_grfoc_cancel(id,id_po,id_scan,id_DI,id_gen,scan_doc,doc_gen,back_no,plant_code,purc_ord_no,vendor_id,gr_chg,deleg_gr,item_no,material_no,material_desc,size_gr,model_gr,matl_group,purc_group,material_type,work_center,sloc,doc_date,po_qty,ord_uom,yr_gr,user_create,date_create,user_update,date_update,date_upload,status_po,dlv_ord_no,shift_gr,user_posting,posting_gr,sloc_gr,rec_qty,gr_qty,status_gr,material_doc_gen,date_post,time_post,ref_doc_gen,user_cancel,date_cancel,time_cancel,std_package,tbox_kanban,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoa["id"])."','".sql_esc($row_infoa["id_scan"])."','".sql_esc($row_infoa["id_DI"])."','".sql_esc($row_infoa["id_gen"])."','".sql_esc($row_infoa["scan_doc"])."','".sql_esc($row_infoa["doc_gen"])."','".sql_esc($row_infoa["back_no"])."','".sql_esc($row_infoa["plant_code"])."','".sql_esc($row_infoa["purc_ord_no"])."','".sql_esc($row_infoa["vendor_id"])."','".sql_esc($row_infoa["gr_chg"])."','".sql_esc($row_infoa["deleg_gr"])."','".sql_esc($row_infoa["item_no"])."','".sql_esc($row_infoa["material_no"])."','".sql_esc($row_infoa["material_desc"])."','".sql_esc($row_infoa["size_gr"])."','".sql_esc($row_infoa["model_gr"])."','".sql_esc($row_infoa["matl_group"])."','".sql_esc($row_infoa["purc_group"])."','".sql_esc($row_infoa["material_type"])."','".sql_esc($row_infoa["work_center"])."','".sql_esc($row_infoa["sloc"])."','".sql_esc($row_infoa["doc_date"])."','".sql_esc($row_infoa["po_qty"])."','".sql_esc($row_infoa["ord_uom"])."','".sql_esc($row_infoa["yr_gr"])."','".sql_esc($row_infoa["user_create"])."','".sql_esc($row_infoa["date_create"])."','".sql_esc($row_infoa["user_update"])."','".sql_esc($row_infoa["date_update"])."','".sql_esc($row_infoa["date_upload"])."','".sql_esc($row_infoa["status_po"])."','".sql_esc($row_infoa["dlv_ord_no"])."','".sql_esc($row_infoa["shift_gr"])."','".sql_esc($row_infoa["user_posting"])."','".sql_esc($row_infoa["posting_gr"])."','".sql_esc($row_infoa["sloc_gr"])."','".sql_esc($row_infoa["rec_qty"])."','".sql_esc($row_infoa["gr_qty"])."','".sql_esc($row_infoa["status_gr"])."','".sql_esc($row_infoa["material_doc_gen"])."','".sql_esc($row_infoa["date_post"])."','".sql_esc($row_infoa["time_post"])."','".sql_esc($row_infoa["ref_doc_gen"])."','".sql_esc($row_infoa["user_cancel"])."','".sql_esc($row_infoa["date_cancel"])."','".sql_esc($row_infoa["time_cancel"])."','".sql_esc($row_infoa["std_package"])."','".sql_esc($row_infoa["tbox_kanban"])."','".sql_esc($row_infoa["SAP_ref_doc"])."','".sql_esc($row_infoa["SAP_ref_doc_can"])."')"; 	
       $result_data2a = mysqli_query($dbc,$query_data2a) or die (mysqli_error($dbc));  
	  
	
	  $filen_rcv = "GR".$ref6; 
		   
		   //-----prepared by------
		 $query_prepw = "SELECT * FROM user_detail WHERE username = '".sql_esc($row_infoa["user_cancel"])."'";
		 $result_prepw = mysqli_query($dbc,$query_prepw);
		 $data_prepw = mysqli_fetch_array($result_prepw);
		 
	
		// ----quantity-----
		// $qty_new = (intval($data_rcv_ftp["qty_dis"]));
        
		// ---get year

		 $tahun_plan = substr($row_infoa["posting_gr"],0,4);
		 

$data_rcv .= $row_infoa["plant_code"].";".$row_infoa["ref_doc_gen"].";".$row_infoa["material_doc_gen"].";".$row_infoa["JD"].";".$tahun_plan.";512;".$row_infoa["user_cancel"]."\r\n";
   

     //----------update table ftp_detail_gd_receipt_cancel------------
   
    $query_rcv_ftp_info = "INSERT INTO ftp_detail_gdfoc_receipt_cancel(id_ups,file_name,ref_doc_gen,material_doc_gen,id_gr,doc_gen,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,sloc,sloc_gr,doc_date,po_qty,gr_qty,ord_uom,user_posting,date_posting,time_posting,status_po,status_ftp,mvt_type) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($row_infoa["ref_doc_gen"])."','".sql_esc($row_infoa["material_doc_gen"])."','".sql_esc($row_infoa["id_gr"])."','".sql_esc($row_infoa["doc_gen"])."','".sql_esc($row_infoa["plant_code"])."','".sql_esc($row_infoa["purc_ord_no"])."','".sql_esc($row_infoa["vendor_id"])."','".sql_esc($row_infoa["item_no"])."','".sql_esc($row_infoa["material_no"])."','".sql_esc($row_infoa["material_desc"])."','".sql_esc($row_infoa["sloc"])."','".sql_esc($row_infoa["sloc_gr"])."','".sql_esc($row_infoa["doc_date"])."','".sql_esc($row_infoa["po_qty"])."','".sql_esc($row_infoa["gr_qty"])."','".sql_esc($row_infoa["ord_uom"])."','".sql_esc($row_infoa["user_cancel"])."','".sql_esc($row_infoa["date_cancel"])."',NOW(),'".sql_esc($row_infoa["status_po"])."','Y','102')";      
	$rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
		  
	
	  }
	  
	//------------edit by azie 30/3/2021-----------  
	  
	   $query_infoaD = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JDD FROM po_detail_trans_gr_foc WHERE material_doc_gen = '".sql_esc($uid6)."' AND (status_gr = '".sql_esc($rst_sta4["status_desc"])."')";
	   $result_infoaD = mysqli_query($dbc,$query_infoaD);
	   $row_infoaD = mysqli_fetch_array($result_infoaD);
	  
	  	// ---get year

		 $tahun_planD = substr($row_infoaD["posting_gr"],0,4);
		 

$data_rcvD .= $row_infoaD["plant_code"].";".$row_infoaD["ref_doc_gen"].";".$row_infoaD["material_doc_gen"].";".$row_infoaD["JDD"].";".$tahun_planD.";512;".$row_infoaD["user_cancel"]."\r\n";
	  
	    $file_rcv = "../FromPortal2/GR/".$filen_rcv.".csv";
		file_put_contents($file_rcv,$data_rcvD);
 	 
	/*  if($result_cancel)
	 { */
	 
		  //update count_max----------------------------------------
		 
		
	  
		   $query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '149'";
		   $result_max_aA = mysqli_query($dbc,$query_max_aA);

	
		
	 

		   echo "<script>";
		   echo "alert('Material Document $ref6 posted.');";
		   echo "window.location='canC_receiv_gdfoc_tran-recProc.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT'";
	       echo "</script>"; 
		   exit(); //quit the script
		
   


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteDisplayGRFOC<?php echo html_esc($row["material_doc_gen"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display Goods Receipt FOC</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
     <!--   <div class="content mt-12">-->
     
     <?php
	 
	 $query_bb = "SELECT *, DATE_FORMAT(posting_gr,'%d-%m-%Y') AS T3 from po_detail_trans_gr_foc WHERE material_doc_gen = '".sql_esc($row["material_doc_gen"])."' GROUP BY doc_gen";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 //----get vendor detail -----
	 
	 $query_vend = "SELECT * FROM vendor_detail WHERE vendor_code = '".sql_esc($data_bb["vendor_id"])."'";
	 $result_vend = mysqli_query($dbc,$query_vend); 
	 $data_vend = mysqli_fetch_array($result_vend);
	 
	 
	 ?>
    <form name="frmDisplay" id="frmDisplay" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" >     
  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="250" height="50"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<h5><font color="#999999"><b>GOODS RECEIPT</b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>Plant :  </b><?php echo html_esc($row["plant_code"]);   ?></div></td>
    <td>&nbsp;</td> 
    <td><div align="left"><b>Document No. :  </b><?php echo html_esc($row["material_doc_gen"]);   ?></div></td>
   <tr> 
    <td><div align="left"><b>Purchase Order No. :  </b><?php echo html_esc($row["purc_ord_no"]);   ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Date :  </b><?php echo html_esc($data_bb["T3"]);   ?></div></td>
  </tr>
  <tr>
    <td><div align="left"><b>Delivery Order No. :  </b><?php echo html_esc($row["dlv_ord_no"]);   ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Shift :  </b><?php echo $shift_ds;   ?></div></td>
  </tr>
   <tr>
    <td><div align="left"><b>Vendor : </b> <?php echo html_esc($row["vendor_id"]);   ?> - <?php echo html_esc($data_vend["vendor_name"]); ?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  <?php
  
            $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plant_code = $_GET["plant_code"];
		
			
			
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);

		    //1. Plant Code
                if (($plant_code == "") || ($plant_code == "NULL")){ 
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND plant_code = '".sql_esc($plant_code)."'"; }  	
					
		   // 3. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND (posting_gr >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (posting_gr <= '".sql_esc($date2_final)."')"; }
							

				$where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04;
	
	//********** END CONDITION **************
	
	
 ?>
 
  <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM po_detail_trans_gr_foc WHERE material_doc_gen = '".sql_esc($row["material_doc_gen"])."' AND (status_po = '".sql_esc($rst_sta7["status_desc"])."')  AND status_gr = '".sql_esc($rst_sta3["status_desc"])."'" .$where_sql." ORDER BY doc_gen ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   ?>
 
 <table width="98%" class="table-bordered">
 <thead bgcolor="#eeeeee">
  <tr>
     <th>No</th>
     <th>Part No.</th>
     <th>Part Name</th>
     <th>Model</th>
     <th>Quantity</th>
     <th>Unit</th>
     <th>Location</th>
    </tr>
  </thead>
  <tbody>
  <?php
    
   while($row2 = mysqli_fetch_array($result_display))
   {

  //-----shift-----
	   
	   if($row2["shift_gr"] == "D/S")
	   {
		   $shift_ds2 = "Day";
	   }elseif($row2["shift_gr"] == "N/S")
	   {
		 $shift_ds2 = "Night";
	   }else{
		   
		   $shift_ds2 = "NA"; 
	   }
  
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo html_esc($row2["material_no"]); ?></td>
    <td><?php echo html_esc($row2["material_desc"]); ?></td>
    <td><?php echo html_esc($row2["model_gr"]); ?></td>
    <td><?php echo intval($row2["gr_qty"]); ?></td>
    <td><?php echo html_esc($row2["ord_uom"]); ?></td>
    <td><?php echo html_esc($row2["sloc_gr"]); ?></td>
  </tr>
  
 <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>

     <div class="modal-footer pull-left">
        <input name="uid6" type="hidden" value="<?php echo html_esc($row["material_doc_gen"]); ?> ">    
       <input name="date1" type="hidden" value="<?php echo html_esc($_GET["date1"]); ?>"> 
       <input name="date2" type="hidden" value="<?php echo html_esc($_GET["date2"]); ?>">
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
    
      <input name="canC_GRFOCbtn" type="submit"  class="btn btn-danger btn-sm" value="CANCEL" onClick="return confirm('Are you sure to cancel this transaction?');"/>
     </div> 

</form>
                <!--  </div></div>-->
                  </div>
                  </div>
                  </div>
                  </div>
               
</body>
</html>