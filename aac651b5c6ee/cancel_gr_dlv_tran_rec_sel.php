<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "canC_gr_dlv_tran_recProc.php"; 
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

$query_function = new PreparedSql("SELECT * FROM function_acc_detail WHERE staff_ID = ?", [$res["staff_ID"]]);
$result_function = db_query($dbc, $query_function);   //run the query.
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

//CR status (Return GRA)
$sta26 = "SELECT * from request_status WHERE status_id = '26'";
$sta_res26 = mysqli_query($dbc,$sta26);
$rst_sta26 = mysqli_fetch_array($sta_res26);	

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
 //-------------- click button "Cancellation"----------------
  if(isset($_POST["can_GRAbtn"])) 
  
   { // handle the form.

 
   $uid3 = $_POST["uid3"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   
   
   
   // echo $uid3;
	
	//-------------------generate gra QC doc no.---------------
	
	 if($_POST["plant_code"] == '3100')
	{
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '10'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($_POST["plant_code"] == '3101')
	{
		
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '65'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "142";
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

	
   
    //--------- Goods Return detail ------------
	 
	   $query_info5 = "SELECT * FROM gra_qc_detail_return_rcv WHERE doc_no_return = '".sql_esc($uid3)."' AND status_gra = '".sql_esc($rst_sta26["status_desc"])."' ";
	   $result_info5 = mysqli_query($dbc,$query_info5);
	  
	  while($data_info5 = mysqli_fetch_array($result_info5))
	  
	  {
		  
	 // ---------update cancellation--------------------------
	 
	$query_cancelGR = "UPDATE gra_qc_detail_return_rcv SET status_gra = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), ref_doc_gra = '".sql_esc($ref2)."' WHERE doc_no_return = '".sql_esc($uid3)."' AND (status_gra = '".sql_esc($rst_sta26["status_desc"])."')";
	$result_cancelGR = mysqli_query($dbc,$query_cancelGR);
	
	
	  
	   $query_infoA = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM gra_qc_detail_return_rcv WHERE doc_no_return = '".sql_esc($uid3)."' AND id_gra = '".sql_esc($data_info5["id_gra"])."' AND (status_gra = '".sql_esc($rst_sta4["status_desc"])."')";
	   $result_infoA = mysqli_query($dbc,$query_infoA);
	   $row_infoA = mysqli_fetch_array($result_infoA);
	   
	   
	 $query_store_ret = "INSERT INTO gra_qc_detail_return_rcv_cancel(id,id_rcv,id_gra,scan_doc_return,doc_gra,id_scan_gra,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,plant_code,sloc_from,vendor_no,qty_gra,uom_gra,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_gra,date_generate_gra,ref_doc_gra,user_cancel,date_cancel,status_ftp,status_tran,status_gra,barcode_gr,gr_doc_no,remark_gra,doc_no_return,return_by,date_return,received_by,date_received,lorry_no,ic_driver,dlv_ord_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoA["id"])."','".sql_esc($row_infoA["id_gra"])."','".sql_esc($row_infoA["scan_doc_return"])."','".sql_esc($row_infoA["doc_gra"])."','".sql_esc($row_infoA["id_scan_gra"])."','".sql_esc($row_infoA["scan_doc"])."','".sql_esc($row_infoA["item_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["plan_no"])."','".sql_esc($row_infoA["doc_no"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["sloc_from"])."','".sql_esc($row_infoA["vendor_no"])."','".sql_esc($row_infoA["qty_gra"])."','".sql_esc($row_infoA["uom_gra"])."','".sql_esc($row_infoA["posting_date"])."','".sql_esc($row_infoA["shift_day"])."','".sql_esc($row_infoA["model_code"])."','".sql_esc($row_infoA["material_type"])."','".sql_esc($row_infoA["stamp_ind"])."','".sql_esc($row_infoA["slip_no"])."','".sql_esc($row_infoA["user_create"])."','".sql_esc($row_infoA["date_create"])."','".sql_esc($row_infoA["user_generate_gra"])."','".sql_esc($row_infoA["date_generate_gra"])."','".sql_esc($row_infoA["ref_doc_gra"])."','".sql_esc($row_infoA["user_cancel"])."','".sql_esc($row_infoA["date_cancel"])."','N','Y','".sql_esc($row_infoA["status_gra"])."','".sql_esc($row_infoA["barcode_gr"])."','".sql_esc($row_infoA["gr_doc_no"])."','".sql_esc($row_infoA["remark_gra"])."','".sql_esc($row_infoA["doc_no_return"])."','".sql_esc($row_infoA["return_by"])."','".sql_esc($row_infoA["date_return"])."','".sql_esc($row_infoA["received_by"])."','".sql_esc($row_infoA["date_received"])."','".sql_esc($row_infoA["lorry_no"])."','".sql_esc($row_infoA["ic_driver"])."','".sql_esc($row_infoA["dlv_ord_no"])."','".sql_esc($row_infoA["SAP_ref_doc"])."','".sql_esc($row_infoA["SAP_ref_doc_can"])."')";          
		  $rst_store_ret = mysqli_query($dbc,$query_store_ret);
	  
	
	  $filen_rcv = "GR".$ref2; 
		   
		   //-----prepared by------
		 $query_prepw = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$row_infoA["user_cancel"]]);
		 $result_prepw = db_query($dbc, $query_prepw);
		 $data_prepw = mysqli_fetch_array($result_prepw);
		 
	
	//Plant;Document No. Cancellation; Document No.;Posting Date;Posting Date Year;Movement Type;Recipient 
    //2300; 2300142070320001; 2300141070320001;29122019;2019;123;IKHRAM 
        
		// ---get year

		 $tahun_plan = substr($row_infoA["posting_date"],0,4);

$data_rcv .= $row_infoA["plant_code"].";".$row_infoA["ref_doc_gra"].";".$row_infoA["doc_no_return"].";".$row_infoA["JD"].";".$tahun_plan.";123;".$row_infoA["user_cancel"]."\r\n";
   

     //----------update table ftp_tp_gra_qc_return_rcv_cancel------------
    $query_rcv_ftp_info = "INSERT INTO ftp_tp_gra_qc_return_rcv_cancel(id,file_name,ref_doc_gra,doc_no_return,doc_gra,id_gra,plan_no,material_no,material_desc,qty_ftp,uom,plant,shift_day,slip_no,mvt_type,status_ftp,posting_date,posting_time,sloc_from,sloc_to,prepared_by,user_create,date_create,vendor_no,status_gra) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($ref2)."','".sql_esc($row_infoA["doc_no_return"])."','".sql_esc($row_infoA["doc_gra"])."','".sql_esc($row_infoA["id_gra"])."','".sql_esc($row_infoA["plan_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["qty_gra"])."','".sql_esc($row_infoA["uom_gra"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["shift_day"])."','".sql_esc($row_infoA["slip_no"])."','123','Y','".sql_esc($row_infoA["posting_date"])."',NOW(),'".sql_esc($row_infoA["sloc_from"])."','','".sql_esc($data_prep["user_fullname"])."','".sql_esc($username)."',NOW(),'".sql_esc($row_infoA["vendor_no"])."','".sql_esc($row_infoA["status_gra"])."')"; 
     $rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
	 
		  
	
	  }
	  
	    $file_rcv = "../FromPortal2/GR/".$filen_rcv.".csv";
		file_put_contents($file_rcv,$data_rcv);
 	 
	/*  if($result_cancel)
	 { */
	 
		  //update count_max----------------------------------------
		 
		  if($_POST["plant_code"] == '3100')
		{
	  
		   $query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '10'";
		   $result_max_aA = mysqli_query($dbc,$query_max_aA);

	
		}elseif($_POST["plant_code"] == '3101')
		{
		   $query_max_bB = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '65'";
		   $result_max_bB = mysqli_query($dbc,$query_max_bB);
		   

		}
	 

		   echo "<script>";
		   echo "alert('Material Document $ref2 posted.');";
		   echo "window.location='canC_gr_dlv_tran-recProc.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT'";
	       echo "</script>"; 
		   exit(); //quit the script
		
    //}


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteCancelGR<?php echo html_esc($row["doc_no_return"]); ?><?php echo html_esc($row["doc_gra"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Cancellation Goods Return</h5>
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
		   // $trans_opt = $_GET["trans_opt"]; 
			
			
			
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
                    $wheresql_03 = " AND (posting_date >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (posting_date <= '".sql_esc($date2_final)."')"; }
							

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
   
$query_display = "SELECT * FROM gra_qc_detail_return_rcv WHERE doc_no_return = '".sql_esc($row["doc_no_return"])."' AND doc_gra = '".sql_esc($row["doc_gra"])."' AND status_gra = '".sql_esc($rst_sta26["status_desc"])."' " .$where_sql." ORDER BY doc_gra ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   
   while($row2 = mysqli_fetch_array($result_display))
   {

      ?>
     
       <input name="uid3" type="hidden" value="<?php echo html_esc($row["doc_no_return"]); ?> ">   
       <input name="date1" type="hidden" value="<?php echo $dateF; ?>"> 
       <input name="date2" type="hidden" value="<?php echo $dateT; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
  
      
      <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  
      
     <div class="modal-footer pull-left">
      <input name="can_GRAbtn" type="submit"  class="btn btn-success btn-sm" value="YES" />
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