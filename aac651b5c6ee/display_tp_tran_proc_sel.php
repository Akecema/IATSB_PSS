<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "can_prog_trn-postingProc2.php"; 
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

//CR status (Transfer Posting)
$sta19 = "SELECT * from request_status WHERE status_id = '19'";
$sta_res19 = mysqli_query($dbc,$sta19);
$rst_sta19 = mysqli_fetch_array($sta_res19);

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
 
  $extension = explode('.', $data_setup["logo_name"]);
  $filename = $data_setup["logo_comp"].'.'.$extension[1];
  
  
 
  
  //-------------- click button "Cancellation"----------------
  if(isset($_POST["cancelTP_btn"])) 
  
   { // handle the form.

 
   $uid2 = $_POST["uid2"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   $sloc_f = $_POST["sloc_f"];
   $sloc_t = $_POST["sloc_t"];
   
   
   //echo $uid2;
   
 
    //-----generate TP Cancellation Doc. No.
	
				 if($plant_code == '3100')
				{
				
				 $query_id3 = "SELECT * FROM run_count_itsb WHERE uid = '38'";
				 $result_id3 = mysqli_query($dbc,$query_id3);
				
				}elseif($plant_code == '3101')
				{
					
				 $query_id3 = "SELECT * FROM run_count_itsb WHERE uid = '85'";
				 $result_id3 = mysqli_query($dbc,$query_id3);
					
				}
				
				if ($result_id3) 
			{
				$nrows3 = mysqli_num_rows($result_id3);
				$row_id3 = mysqli_fetch_array($result_id3);
				
				$dht3 = 00000; 
				$dht_OK3 = "412";
				$dg3 = 0;
			
				if($row_id3["count_max"] <= 0)
				{ 
			   
					$lastID3 = ($row_id3["count_max"] + 1);
					$dg3 = ($dht3 + ($lastID3));
			   }
			   else
			   {
				  $lastID3 = ($row_id3["count_max"] + 1);
				  $dg3 =  $lastID3;
				
				}
				$number3 = $dg3; // Length of running no
				$number3 = sprintf('%03d', $number3);  
				
				$ref3 = (($row_id3["start_ref"]).$dht_OK3.$date_run.($number3));
				  
				
				} // end if $result_id2
 
   
 
 
   
   // --------- pps detail ------------
	 
	   $query_pps = "SELECT * FROM tp_store_detail WHERE doc_tp = '".sql_esc($uid2)."' AND status_tp = '".sql_esc($rst_sta19["status_desc"])."' ";
	   $result_pps = mysqli_query($dbc,$query_pps);
	  
	  while($data_pps = mysqli_fetch_array($result_pps))
	  
	  {
		  
	  //---------update cancellation--------------------------
	 
	$query_cancel = "UPDATE tp_store_detail SET status_tp = '".sql_esc($rst_sta4["status_desc"])."', ref_doc_tp = '".sql_esc($ref3)."', user_cancel = '".sql_esc($username)."', date_cancel = NOW() WHERE id_tp = '".sql_esc($data_pps["id_tp"])."' AND doc_tp = '".sql_esc($uid2)."'";
	$result_cancel = mysqli_query($dbc,$query_cancel);
	
	
	  //----get detail------
	  
	   $query_dtlA = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS J, DATE_FORMAT(date_create,'%d%m%Y') AS R2 FROM tp_store_detail WHERE doc_tp = '".sql_esc($uid2)."' AND id_tp = '".sql_esc($data_pps["id_tp"])."' AND status_tp = '".sql_esc($rst_sta4["status_desc"])."'";
	   $result_dtlA = mysqli_query($dbc,$query_dtlA);
	   $row_infoA = mysqli_fetch_array($result_dtlA);
	  
		  
	  //insert into table tp_store_detail_canc------------
	
$query_data2 = "INSERT INTO tp_store_detail_canc(id,id_tp,doc_tp,id_scan_tp,scan_doc,item_no,material_no, material_desc,plan_no,doc_no,plant_code,sloc_from,sloc_to,qty_tp,uom_tp,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_tp,date_generate_tp,ref_doc_tp,user_cancel,date_cancel,status_ftp,status_tran,status_tp,barcode_gr,gr_doc_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoA["id_tp"])."','".sql_esc($row_infoA["doc_tp"])."','".sql_esc($row_infoA["id_scan_tp"])."','".sql_esc($row_infoA["scan_doc"])."','".sql_esc($row_infoA["item_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["plan_no"])."','".sql_esc($row_infoA["doc_no"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["sloc_from"])."','".sql_esc($row_infoA["sloc_to"])."','".sql_esc($row_infoA["qty_tp"])."','".sql_esc($row_infoA["uom_tp"])."','".sql_esc($row_infoA["posting_date"])."','".sql_esc($row_infoA["shift_day"])."','".sql_esc($row_infoA["model_code"])."','".sql_esc($row_infoA["material_type"])."','".sql_esc($row_infoA["stamp_ind"])."','".sql_esc($row_infoA["slip_no"])."','".sql_esc($row_infoA["user_create"])."','".sql_esc($row_infoA["date_create"])."','".sql_esc($row_infoA["user_generate_tp"])."','".sql_esc($row_infoA["date_generate_tp"])."','".sql_esc($ref3)."','".sql_esc($username)."',NOW(),'".sql_esc($row_infoA["status_ftp"])."','".sql_esc($row_infoA["status_tran"])."','".sql_esc($row_infoA["status_tp"])."','".sql_esc($row_infoA["barcode_gr"])."','".sql_esc($row_infoA["gr_doc_no"])."','','')";
$result_data2 = mysqli_query($dbc,$query_data2);   


   //----checking ftp tp_cancel_store-------
     $data_rcvV = "";
	
	 $filen_rcvV = "TP".$ref3; 


  //-----prepared by------
		 $query_prepV = "SELECT * FROM user_detail WHERE username = '".sql_esc($row_infoA["user_generate_tp"])."'";
		 $result_prepV = mysqli_query($dbc,$query_prepV) or die (mysqli_error());
		 $data_prepV = mysqli_fetch_array($result_prepV);
		 
		 //----quantity-----
		 $qty_new = (intval($row_infoA["qty_tp"]));
		 
		 //----Posting Date Year
		 $post_yr = substr($row_infoA["date_cancel"],0,4);



         $data_rcvV .= $row_infoA["plant_code"].";".$row_infoA["ref_doc_tp"].";".$row_infoA["doc_tp"].";".$row_infoA["J"].";".$post_yr.";312;".$row_infoA["user_generate_tp"]."\r\n";
   


  
     //----------update table ftp_qc_received_detail------------
   
     $query_rcv_ftp_infoV = "INSERT INTO ftp_tp_cancel_store(id,file_name,doc_tp,ref_doc_tp,id_tp,plan_no,material_no,material_desc,qty_ftp,uom,plant,shift_day,slip_no,mvt_type,status_ftp,posting_date,posting_time,sloc_from,sloc_to,prepared_by,user_create,date_create) VALUES('','".sql_esc($filen_rcvV)."','".sql_esc($row_infoA["doc_tp"])."','".sql_esc($ref3)."','".sql_esc($row_infoA["id_tp"])."','".sql_esc($row_infoA["plan_no"])."','".sql_esc($row_infoA["material_no"])."','".sql_esc($row_infoA["material_desc"])."','".sql_esc($row_infoA["qty_tp"])."','".sql_esc($row_infoA["uom_tp"])."','".sql_esc($row_infoA["plant_code"])."','".sql_esc($row_infoA["shift_day"])."','".sql_esc($row_infoA["slip_no"])."','312','Y','".sql_esc($row_infoA["date_cancel"])."',NOW(),'".sql_esc($row_infoA["sloc_from"])."','".sql_esc($row_infoA["sloc_to"])."','".sql_esc($data_prepV["user_fullname"])."','".sql_esc($username)."',NOW())"; 
     $rst_rcv_ftp_infoV = mysqli_query($dbc,$query_rcv_ftp_infoV);

				  
		  
	  }
	  


		$file_rcvV = "../FromPortal2/TP/".$filen_rcvV.".csv";
		file_put_contents($file_rcvV,$data_rcvV);
				
    //---------------------------------------end ftp -------------------------------------------------   

	         if($plant_code == '3100')
				{
				
	   $query_max_A = "UPDATE run_count_itsb SET count_max = '".sql_esc($number3)."', date_updated = NOW() WHERE uid = '38'";
	   $result_max_A = mysqli_query($dbc,$query_max_A);
				
				}elseif($plant_code == '3101')
				{
	 
	   $query_max_A = "UPDATE run_count_itsb SET count_max = '".sql_esc($number3)."', date_updated = NOW() WHERE uid = '85'";
	   $result_max_A = mysqli_query($dbc,$query_max_A);
	 
				}
	 
   

		   echo "<script>";
		   echo "alert('Material Document $ref3 posted.');";
		   echo "window.location='can_prog_trn-postingProc2.php?date1=$dateF&&date2=$dateT&&plant_code=$plant_code&&sloc_f=$sloc_f&&sloc_t=$sloc_t'";
	       echo "</script>"; 
		   exit(); //quit the script
		
    


   }// end submit
 
 
?>
  <div class="modal fade printable autoprint" id="myNoteView<?php echo html_esc($row["doc_tp"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display Transfer Posting</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
     <!--   <div class="content mt-12">-->
     
     <?php
	 
	 $query_bb = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T3 from tp_store_detail WHERE doc_tp = '".sql_esc($row["doc_tp"])."' AND status_tp = '".sql_esc($rst_sta19["status_desc"])."' GROUP BY doc_tp";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 ?>
   
   <form name="frmSearch" id="frmSearch" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" >  
   
  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="250" height="50"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<h5><font color="#999999"><b>TRANSFER POSTING</b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>Plant :  </b><?php echo html_esc($row["plant_code"]);   ?></div></td>
    <td>&nbsp;</td> 
    <td><div align="left"><b>Document No. :  </b><?php echo html_esc($row["doc_tp"]);   ?></div></td>
   <tr> 
    <td><div align="left"><b>SLoc From :  </b><?php echo html_esc($row["sloc_from"]);   ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Date :  </b><?php echo html_esc($data_bb["T3"]);   ?></div></td>
  </tr>
  <tr>
    <td><div align="left"><b>SLoc To :  </b><?php echo html_esc($row["sloc_to"]);   ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Shift :  </b><?php echo html_esc($row["shift_day"]);  ?></div></td>
  </tr>
  </table>
  <?php
            
			$dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plant_code = $_GET["plant_code"];
			$sloc_f = $_GET["sloc_f"];
			$sloc_t = $_GET["sloc_t"];
			
			
			    //-------Count all results------------------------//
			
				 $where_sql = '';
				 
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);
				 		
		 // 1. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND (posting_date >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 2. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (posting_date <= '".sql_esc($date2_final)."')"; } 
					 	 
		 //3. Plant Code 
                if ($plant_code == "NULL"){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND plant_code = '".sql_esc($plant_code)."'"; } 
					
          //4. sloc from
                if ($sloc_f == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND sloc_from = '".sql_esc($sloc_f)."'"; }
   
	       //5. sloc to
                if ($sloc_t == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND sloc_to = '".sql_esc($sloc_t)."'"; }  	
					
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;	
	
   	//********** END CONDITION **************
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM tp_store_detail WHERE doc_tp = '".sql_esc($row["doc_tp"])."' AND status_tp = '".sql_esc($rst_sta19["status_desc"])."' AND status_tran = 'Y'" .$where_sql." ORDER BY doc_tp ASC";
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
    </tr>
  </thead>
  <tbody>
  <?php
    
   while($row2 = mysqli_fetch_array($result_display))
   {

  
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo html_esc($row2["material_no"]); ?></td>
    <td><?php echo html_esc($row2["material_desc"]); ?></td>
    <td><?php echo html_esc($row2["model_code"]); ?></td>
    <td><?php echo intval($row2["qty_tp"]); ?></td>
    <td><?php echo html_esc($row2["uom_tp"]); ?></td>
  </tr>
  
 <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
       
  </tbody>
</table>
 <br><br>
    
       
      <input name="plant_code"  type="hidden" id="plant_code" value="<?php echo $plant_code; ?>">
      <input name="uid2" type="hidden" id="uid2" value="<?php echo html_esc($row["doc_tp"]); ?>">
      <input name="sloc_f" type="hidden" id="sloc_f" value="<?php echo html_esc($_GET["sloc_f"]); ?>">
      <input name="sloc_t" type="hidden" id="sloc_t" value="<?php echo html_esc($_GET["sloc_t"]); ?>">
      <input name="date1" type="hidden" id="date1" value="<?php echo html_esc($_GET["date1"]); ?>">
      <input name="date2" type="hidden" id="date2" value="<?php echo html_esc($_GET["date2"]); ?>">
       
         <!-- <div class="modal-footer pull-left">-->
         <input name="cancelTP_btn" type="submit"  class="btn btn-danger btn-sm" value="CANCEL" onClick="return confirm('Are you sure to cancel this transaction?');"/>
           
             <!--</div> -->

  </form>
      
    
     </div> 
    
                  </div>
                  </div>
                  </div>
      
          
</body>
</html>