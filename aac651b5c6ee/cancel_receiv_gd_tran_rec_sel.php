<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "canC_receiv_gd_tran_recProc.php"; 
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
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
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
 //-------------- click button "Cancellation"----------------
  if(isset($_POST["canCL_GR2btn"])) 
  
   { // handle the form.

 
   $uid3 = $_POST["uid3"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   
   
   // echo $uid3;
	
	//-------------------generate gra QC doc no.---------------
	
	 if($_POST["plant_code"] == '3100')
	{
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '6'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($_POST["plant_code"] == '3101')
	{
		
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '61'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "122";
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
	
    $ref2 = (($row_id2["start_ref"]).$dht_OK2.$date_run.($number2));
	  
	
	} // end if $result_id2

	
   
    //--------- Goods Receipt detail ------------
	 
	   $query_info5 = "SELECT * FROM po_detail_trans_gr WHERE material_doc_gen = '".sql_esc($uid3)."' AND status_gr = '".sql_esc($rst_sta3["status_desc"])."' AND status_po = '".sql_esc($rst_sta7["status_desc"])."'";
	   $result_info5 = mysqli_query($dbc,$query_info5);
	  
	  while($data_info5 = mysqli_fetch_array($result_info5))
	  {
		  
		  
	 // ---------update cancellation--------------------------
	 
	$query_cancelGR = "UPDATE po_detail_trans_gr SET status_po = '".sql_esc($rst_sta4["status_desc"])."', status_gr = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), time_cancel = NOW(), ref_doc_gen = '".sql_esc($ref2)."' WHERE material_doc_gen = '".sql_esc($uid3)."' AND status_gr = '".sql_esc($rst_sta3["status_desc"])."'";
	$result_cancelGR = mysqli_query($dbc,$query_cancelGR);
	
	
	  
	   $query_infoa = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM po_detail_trans_gr WHERE material_doc_gen = '".sql_esc($uid3)."' AND id = '".sql_esc($data_info5["id"])."' AND (status_gr = '".sql_esc($rst_sta4["status_desc"])."')";
	   $result_infoa = mysqli_query($dbc,$query_infoa);
	   $row_infoa = mysqli_fetch_array($result_infoa);
	   

	  $query_data2Aa = "INSERT INTO po_detail_trans_gr_cancel(id,id_po,id_scan,id_DI,id_gen,scan_doc,doc_gen,back_no,plant_code,purc_ord_no,vendor_id,gr_chg,deleg_gr,item_no,material_no,material_desc,size_gr,model_gr,matl_group,purc_group,material_type,work_center,sloc,doc_date,po_qty,ord_uom,yr_gr,user_create,date_create,user_update,date_update,date_upload,status_po,dlv_ord_no,shift_gr,user_posting,posting_gr,sloc_gr,rec_qty,gr_qty,status_gr,material_doc_gen,date_post,time_post,ref_doc_gen,user_cancel,date_cancel,time_cancel,std_package,tbox_kanban,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoa["id"])."','".sql_esc($row_infoa["id_scan"])."','".sql_esc($row_infoa["id_DI"])."','".sql_esc($row_infoa["id_gen"])."','".sql_esc($row_infoa["scan_doc"])."','".sql_esc($row_infoa["doc_gen"])."','".sql_esc($row_infoa["back_no"])."','".sql_esc($row_infoa["plant_code"])."','".sql_esc($row_infoa["purc_ord_no"])."','".sql_esc($row_infoa["vendor_id"])."','".sql_esc($row_infoa["gr_chg"])."','".sql_esc($row_infoa["deleg_gr"])."','".sql_esc($row_infoa["item_no"])."','".sql_esc($row_infoa["material_no"])."','".sql_esc($row_infoa["material_desc"])."','".sql_esc($row_infoa["size_gr"])."','".sql_esc($row_infoa["model_gr"])."','".sql_esc($row_infoa["matl_group"])."','".sql_esc($row_infoa["purc_group"])."','".sql_esc($row_infoa["material_type"])."','".sql_esc($row_infoa["work_center"])."','".sql_esc($row_infoa["sloc"])."','".sql_esc($row_infoa["doc_date"])."','".sql_esc($row_infoa["po_qty"])."','".sql_esc($row_infoa["ord_uom"])."','".sql_esc($row_infoa["yr_gr"])."','".sql_esc($row_infoa["user_create"])."','".sql_esc($row_infoa["date_create"])."','".sql_esc($row_infoa["user_update"])."','".sql_esc($row_infoa["date_update"])."','".sql_esc($row_infoa["date_upload"])."','".sql_esc($row_infoa["status_po"])."','".sql_esc($row_infoa["dlv_ord_no"])."','".sql_esc($row_infoa["shift_gr"])."','".sql_esc($row_infoa["user_posting"])."','".sql_esc($row_infoa["posting_gr"])."','".sql_esc($row_infoa["sloc_gr"])."','".sql_esc($row_infoa["rec_qty"])."','".sql_esc($row_infoa["gr_qty"])."','".sql_esc($row_infoa["status_gr"])."','".sql_esc($row_infoa["material_doc_gen"])."','".sql_esc($row_infoa["date_post"])."','".sql_esc($row_infoa["time_post"])."','".sql_esc($row_infoa["ref_doc_gen"])."','".sql_esc($row_infoa["user_cancel"])."','".sql_esc($row_infoa["date_cancel"])."','".sql_esc($row_infoa["time_cancel"])."','".sql_esc($row_infoa["std_package"])."','".sql_esc($row_infoa["tbox_kanban"])."','".sql_esc($row_infoa["SAP_ref_doc"])."','".sql_esc($row_infoa["SAP_ref_doc_can"])."')"; 	
       $result_data2Aa = mysqli_query($dbc,$query_data2Aa) or die (mysqli_error($dbc));  
	   
	   
	
	
	  $filen_rcv = "GR".$ref2; 
		   
		   //-----prepared by------
		 $query_prepw = "SELECT * FROM user_detail WHERE username = '".sql_esc($row_infoa["user_cancel"])."'";
		 $result_prepw = mysqli_query($dbc,$query_prepw);
		 $data_prepw = mysqli_fetch_array($result_prepw);
		 
	
		// ----quantity-----
		// $qty_new = (intval($data_rcv_ftp["qty_dis"]));
        
		// ---get year

		 $tahun_plan = substr($row_infoa["posting_gr"],0,4);
		 

$data_rcv .= $row_infoa["plant_code"].";".$row_infoa["ref_doc_gen"].";".$row_infoa["material_doc_gen"].";".$row_infoa["JD"].";".$tahun_plan.";102;".$row_infoa["user_cancel"]."\r\n";
   

     //----------update table ftp_detail_gd_receipt_cancel------------
   
    $query_rcv_ftp_info = "INSERT INTO ftp_detail_gd_receipt_cancel(id_ups,file_name,ref_doc_gen,material_doc_gen,id_gr,doc_gen,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,sloc,sloc_gr,doc_date,po_qty,gr_qty,ord_uom,user_posting,date_posting,time_posting,status_po,status_ftp,mvt_type) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($row_infoa["ref_doc_gen"])."','".sql_esc($row_infoa["material_doc_gen"])."','".sql_esc($row_infoa["id_gr"])."','".sql_esc($row_infoa["doc_gen"])."','".sql_esc($row_infoa["plant_code"])."','".sql_esc($row_infoa["purc_ord_no"])."','".sql_esc($row_infoa["vendor_id"])."','".sql_esc($row_infoa["item_no"])."','".sql_esc($row_infoa["material_no"])."','".sql_esc($row_infoa["material_desc"])."','".sql_esc($row_infoa["sloc"])."','".sql_esc($row_infoa["sloc_gr"])."','".sql_esc($row_infoa["doc_date"])."','".sql_esc($row_infoa["po_qty"])."','".sql_esc($row_infoa["gr_qty"])."','".sql_esc($row_infoa["ord_uom"])."','".sql_esc($row_infoa["user_cancel"])."','".sql_esc($row_infoa["date_cancel"])."',NOW(),'".sql_esc($row_infoa["status_po"])."','Y','102')";      
	$rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
		  
	
	  }
	  
	  //---edit by Azie  30/3/2021
	 
	   $query_infoaR = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JDR FROM po_detail_trans_gr WHERE material_doc_gen = '".sql_esc($uid3)."' AND (status_gr = '".sql_esc($rst_sta4["status_desc"])."')";
	   $result_infoaR = mysqli_query($dbc,$query_infoaR);
	   $row_infoaR = mysqli_fetch_array($result_infoaR);
	  
	  // ---get year

		 $tahun_planR = substr($row_infoaR["posting_gr"],0,4);
		 

$data_rcvR .= $row_infoaR["plant_code"].";".$row_infoaR["ref_doc_gen"].";".$row_infoaR["material_doc_gen"].";".$row_infoaR["JDR"].";".$tahun_planR.";102;".$row_infoaR["user_cancel"]."\r\n";
	  
	  
	    $file_rcv = "../FromPortal2/GR/".$filen_rcv.".csv";
		file_put_contents($file_rcv,$data_rcvR);
 	 
	/*  if($result_cancel)
	 { */
	 
		  //update count_max----------------------------------------
		 
		  if($_POST["plant_code"] == '3100')
		{
	  
		   $query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '6'";
		   $result_max_aA = mysqli_query($dbc,$query_max_aA);

	
		}elseif($_POST["plant_code"] == '3101')
		{
		   $query_max_bB = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '61'";
		   $result_max_bB = mysqli_query($dbc,$query_max_bB);
		   

		}
		

		   echo "<script>";
		   echo "alert('Material Document $ref2 posted.');";
		   echo "window.location='canC_receiv_gd_tran-recProc.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT'";
	       echo "</script>"; 
		   exit(); //quit the script
		
    //}


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteCancelGR<?php echo $row["material_doc_gen"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Cancellation Goods Receipt</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
        <div class="content mt-12">
   
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

  

<br>

        <div class="content mt-12"><h5>Are you sure to cancel this transaction?</h5><br>
       

    <form name="frmSearch" id="frmSearch" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" class="needs-validation"  novalidate>

    <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM po_detail_trans_gr WHERE material_doc_gen = '".sql_esc($row["material_doc_gen"])."' AND (status_gr = '".sql_esc($rst_sta3["status_desc"])."') " .$where_sql." ORDER BY doc_gen ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   
   while($row2 = mysqli_fetch_array($result_display))
   {

      ?>
     
       <input name="uid3" type="hidden" value="<?php echo $row2["material_doc_gen"]; ?> ">    
       <input name="date1" type="hidden" value="<?php echo $dateF; ?>"> 
       <input name="date2" type="hidden" value="<?php echo $dateT; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
      
      
      <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  
      
     <div class="modal-footer pull-left">
      <input name="canCL_GR2btn" type="submit"  class="btn btn-success btn-sm" value="YES" />
     <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">NO</button>
             </div> 

  </form>
                <!--  </div>--></div>
                  </div>
                  </div>
                  </div>
                  </div>
               
</body>
</html>