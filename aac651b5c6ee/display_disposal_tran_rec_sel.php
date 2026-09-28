<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "canC_disposal_tran-recProc.php"; 
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

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc,$sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

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

//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc,$sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);

//CR status (Return GRA)
$sta26 = "SELECT * from request_status WHERE status_id = '26'";
$sta_res26 = mysqli_query($dbc,$sta26);
$rst_sta26 = mysqli_fetch_array($sta_res26);

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

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
  if(isset($_POST["canC_DISbtn"])) 
  
   { // handle the form.

 
   $uid6 = $_POST["uid6"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
 
   // echo $uid3;
	
	//-------------------generate Disposal Cancellation doc no.---------------
	
	 if($_POST["plant_code"] == '3100')
	{
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '34'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($_POST["plant_code"] == '3101')
	{
		
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '83'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "372";
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

	
   
    //--------- Disposal Receiving detail ------------
	 
	   $query_info5 = "SELECT * FROM gra_disposal_ppcrec_detail WHERE doc_dis = '".sql_esc($uid6)."' AND status_dis = '".sql_esc($rst_sta10["status_desc"])."'";
	   $result_info5 = mysqli_query($dbc,$query_info5);
	  
	  while($data_info5 = mysqli_fetch_array($result_info5))
	  
	  {
		  
	 // ---------update cancellation--------------------------
	 
	$query_cancelGRr = "UPDATE gra_disposal_ppcrec_detail SET status_dis = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), ref_doc_dis = '".sql_esc($ref6)."' WHERE doc_dis = '".sql_esc($uid6)."' AND status_dis = '".sql_esc($rst_sta10["status_desc"])."'";
	$result_cancelGRr = mysqli_query($dbc,$query_cancelGRr);
	
	
	//--------update canellation table disposal_detail_prd_all
	
	$query_cancelGRr2 = "UPDATE disposal_detail_prd_all SET status_disposal = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), disposal_no_ref = '".sql_esc($ref6)."' WHERE doc_dis = '".sql_esc($uid6)."' AND status_disposal = '".sql_esc($rst_sta10["status_desc"])."'";
	$result_cancelGRr2 = mysqli_query($dbc,$query_cancelGRr2);
	
	  
	   $query_infoBd = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM gra_disposal_ppcrec_detail WHERE doc_dis = '".sql_esc($uid6)."' AND id_dis = '".sql_esc($data_info5["id_dis"])."' AND status_dis = '".sql_esc($rst_sta4["status_desc"])."'";
	   $result_infoBd = mysqli_query($dbc,$query_infoBd);
	   $row_infoBd = mysqli_fetch_array($result_infoBd);
	   
	  // echo $row_infoB["id_dis"];
	   
	   
	//---------insert data at table gra_disposal_ppcrec_detail_cancel
		
		   $query_can_disp = "INSERT INTO gra_disposal_ppcrec_detail_cancel(id,id_dis,doc_dis,id_scan_dis,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,comp_code,plant_code,sloc_from,sloc_to,qty_dis,uom_dis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_dis,date_generate_dis,time_generate_dis,ref_doc_dis,user_cancel,date_cancel,remark_cancel,status_ftp,status_tran,status_dis,sloc_rej,work_center,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,remark_dis,status_approved1,hod_approved1,date_approved1,remark_approved1,status_approved2,hod_approved2,date_approved2,remark_approved2,status_approved3,hod_approved3,date_approved3,remark_approved3,status_approved4,hod_approved4,date_approved4,remark_approved4,status_part,cost_center,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoBd["id_dis"])."','".sql_esc($row_infoBd["doc_dis"])."','".sql_esc($row_infoBd["id_scan_dis"])."','".sql_esc($row_infoBd["scan_doc"])."','".sql_esc($row_infoBd["item_no"])."','".sql_esc($row_infoBd["material_no"])."','".sql_esc($row_infoBd["material_desc"])."','".sql_esc($row_infoBd["plan_no"])."','".sql_esc($row_infoBd["doc_no"])."','".sql_esc($row_infoBd["comp_code"])."','".sql_esc($row_infoBd["plant_code"])."','".sql_esc($row_infoBd["sloc_from"])."','".sql_esc($row_infoBd["sloc_to"])."','".sql_esc($row_infoBd["qty_dis"])."','".sql_esc($row_infoBd["uom_dis"])."','".sql_esc($row_infoBd["posting_date"])."','".sql_esc($row_infoBd["shift_day"])."','".sql_esc($row_infoBd["model_code"])."','".sql_esc($row_infoBd["material_type"])."','".sql_esc($row_infoBd["stamp_ind"])."','".sql_esc($row_infoBd["slip_no"])."','".sql_esc($row_infoBd["user_create"])."','".sql_esc($row_infoBd["date_create"])."','".sql_esc($row_infoBd["user_generate_dis"])."','".sql_esc($row_infoBd["date_generate_dis"])."','".sql_esc($row_infoBd["time_generate_dis"])."','".sql_esc($row_infoBd["ref_doc_dis"])."','".sql_esc($row_infoBd["user_cancel"])."','".sql_esc($row_infoBd["date_cancel"])."','".sql_esc($row_infoBd["remark_cancel"])."','".sql_esc($row_infoBd["status_ftp"])."','".sql_esc($row_infoBd["status_tran"])."','".sql_esc($row_infoBd["status_dis"])."','".sql_esc($row_infoBd["sloc_rej"])."','".sql_esc($row_infoBd["work_center"])."','".sql_esc($row_infoBd["proc_reject"])."','".sql_esc($row_infoBd["type_reject"])."','".sql_esc($row_infoBd["type_defect"])."','".sql_esc($row_infoBd["reason_reject"])."','".sql_esc($row_infoBd["user_reject"])."','".sql_esc($row_infoBd["date_reject"])."','".sql_esc($row_infoBd["time_reject"])."','".sql_esc($row_infoBd["remark_dis"])."','".sql_esc($row_infoBd["status_approved1"])."','".sql_esc($row_infoBd["hod_approved1"])."','".sql_esc($row_infoBd["date_approved1"])."','".sql_esc($row_infoBd["remark_approved1"])."','".sql_esc($row_infoBd["status_approved2"])."','".sql_esc($row_infoBd["hod_approved2"])."','".sql_esc($row_infoBd["date_approved2"])."','".sql_esc($row_infoBd["remark_approved2"])."','".sql_esc($row_infoBd["status_approved3"])."','".sql_esc($row_infoBd["hod_approved3"])."','".sql_esc($row_infoBd["date_approved3"])."','".sql_esc($row_infoBd["remark_approved3"])."','".sql_esc($row_infoBd["status_approved4"])."','".sql_esc($row_infoBd["hod_approved4"])."','".sql_esc($row_infoBd["date_approved4"])."','".sql_esc($row_infoBd["remark_approved4"])."','WS','".sql_esc($row_infoBd["cost_center"])."','".sql_esc($row_infoBd["SAP_ref_doc"])."','".sql_esc($row_infoBd["SAP_ref_doc_can"])."')";           
		   $rst_can_disp = mysqli_query($dbc,$query_can_disp) or die (mysqli_error());  
	  
	
	  $filen_rcv = "DP".$ref6; 
		   
		   //-----prepared by------
		 $query_prepw = "SELECT * FROM user_detail WHERE username = '".sql_esc($row_infoBd["user_cancel"])."'";
		 $result_prepw = mysqli_query($dbc,$query_prepw);
		 $data_prepw = mysqli_fetch_array($result_prepw);
		
		
		//Plant;Document No. Cancellation;Document No.;Posting Date;Posting Date Year;Movement Type;Recipient 
        //2300; 2300372070320001; 2300371070320001;29122019;2019;552;IKHRAM  

        
		// ---get year

		 $tahun_plan = substr($row_infoBd["posting_date"],0,4);
		 

$data_rcv .= $row_infoBd["plant_code"].";".$row_infoBd["ref_doc_dis"].";".$row_infoBd["doc_dis"].";".$row_infoBd["JD"].";".$tahun_plan.";552;".$row_infoBd["user_cancel"]."\r\n";
   

     //----------update table ftp_tp_gra_disposal_ppcrec_cancel------------
	 
   $query_rcv_ftp_info = "INSERT INTO ftp_tp_gra_disposal_ppcrec_cancel(id,file_name,ref_doc_dis,doc_dis,id_dis,plan_no,material_no,material_desc,qty_ftp,uom,plant,shift_day,slip_no,mvt_type,status_ftp,posting_date,posting_time,sloc_from,sloc_to,work_center,proc_reject,type_reject,type_defect,reason_reject,cost_center,prepared_by,user_create,date_create) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($row_infoBd["ref_doc_dis"])."','".sql_esc($row_infoBd["doc_dis"])."','".sql_esc($row_infoBd["id_dis"])."','".sql_esc($row_infoBd["plan_no"])."','".sql_esc($row_infoBd["material_no"])."','".sql_esc($row_infoBd["material_desc"])."','".sql_esc($row_infoBd["qty_dis"])."','".sql_esc($row_infoBd["uom_dis"])."','".sql_esc($row_infoBd["plant_code"])."','".sql_esc($row_infoBd["shift_day"])."','".sql_esc($row_infoBd["slip_no"])."','552','Y','".sql_esc($row_infoBd["posting_date"])."',NOW(),'".sql_esc($row_infoBd["sloc_from"])."','".sql_esc($row_infoBd["sloc_to"])."','".sql_esc($row_infoBd["work_center"])."','".sql_esc($row_infoBd["proc_reject"])."','".sql_esc($row_infoBd["type_reject"])."','".sql_esc($row_infoBd["type_defect"])."','".sql_esc($row_infoBd["reason_reject"])."','".sql_esc($row_infoBd["cost_center"])."','".sql_esc($data_prepw["user_fullname"])."','".sql_esc($username)."',NOW())"; 
     $rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
	 
		  
	
	  }
	  
	    $file_rcv = "../FromPortal2/DP/".$filen_rcv.".csv";
		file_put_contents($file_rcv,$data_rcv);
 	 
	
	 
		   if($_POST["plant_code"] == '3100')
		{
	  
		   $query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '34'";
		   $result_max_aA = mysqli_query($dbc,$query_max_aA);

	
		}elseif($_POST["plant_code"] == '3101')
		{
		   $query_max_bB = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '83'";
		   $result_max_bB = mysqli_query($dbc,$query_max_bB);
		   

		}
	 

		   echo "<script>";
		   echo "alert('Material Document $ref6 posted.');";
		   echo "window.location='canC_disposal_tran-recProc.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT'";
	       echo "</script>"; 
		   exit(); //quit the script
		
 

   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteDisplayDIS<?php echo $row["doc_dis"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display Disposal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
     <!--   <div class="content mt-12">-->
     
     <?php
	 
	 $query_bb = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T3 from gra_disposal_ppcrec_detail WHERE doc_dis = '".sql_esc($row["doc_dis"])."' GROUP BY doc_dis";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);	 
	 
	 //---work center----
	 $query_line = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($data_bb["work_center"])."'";
	 $rs_line = mysqli_query($dbc,$query_line);   //run the query.
     $data_line = mysqli_fetch_array($rs_line);	 
	 
	 
	   //-----plant code-----
	   
	   if($row["plant_code"] == "3100")
	   {
		   $plant_nw2 = "Serendah";
		   
	   }elseif($row["plant_code"] == "3101")
	   {
		 $plant_nw2 = "Melaka";
	   }else{
		   
		   $plant_nw2 = "NA"; 
	   }
	 ?>
        
  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="250" height="50"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<h5><font color="#999999"><b>DISPOSAL FORM</b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>Plant :  </b><?php echo $plant_nw2;   ?></div></td>
    <td>&nbsp;</td> 
    <td><div align="left"><b>Document No. :  </b><?php echo $row["doc_dis"];   ?></div></td>
   <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Date :  </b><?php echo $data_bb["T3"];   ?></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Shift :  </b><?php echo $shift_ds;   ?></div></td>
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
                    $wheresql_03 = " AND (posting_date >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (posting_date <= '".sql_esc($date2_final)."')"; }
							

				$where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04;
	
	//********** END CONDITION **************
	
	
 ?>
 
  <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM gra_disposal_ppcrec_detail WHERE doc_dis = '".sql_esc($row["doc_dis"])."' AND status_dis = '".sql_esc($rst_sta10["status_desc"])."'" .$where_sql." ORDER BY doc_dis ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
  
   ?>
   <form name="frmDisplay" id="frmDisplay" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" > 
 <table width="98%" class="table-bordered">
 <thead bgcolor="#eeeeee">
  <tr>
     <th>No</th>
     <th>Part No.</th>
     <th>Model</th>
     <th>Quantity</th>
     <th>Unit</th>
     <th>Section/Line</th>
     <th>Location</th>
     <th>Process of Reject</th>
     <th>Type of Reject</th>
     <th>Defectives</th>
     <th>Reasons</th>
     <th>Remark</th>
    </tr>
  </thead>
  <tbody>
  <?php
    
   while($row2 = mysqli_fetch_array($result_display))
   {

  //-----shift-----
	   
	   if($row2["shift_day"] == "D/S")
	   {
		   $shift_ds2 = "Day";
	   }elseif($row2["shift_day"] == "N/S")
	   {
		 $shift_ds2 = "Night";
	   }else{
		   
		   $shift_ds2 = "NA"; 
	   }
	   
	   
	  //-----get process ----
	   
	   $query_proc = "SELECT * FROM proc_reject_detail_ppcdlv WHERE id_proc = '".sql_esc($row2["proc_reject"])."'";
	   $rst_proc = mysqli_query($dbc,$query_proc);
       $data_proc = mysqli_fetch_array($rst_proc);
	   
  //----get type of reject -----
  
       $query_type = "SELECT * FROM type_reject_detail_ppcdlv WHERE id_type = '".sql_esc($row2["type_reject"])."'";
	   $rst_type = mysqli_query($dbc,$query_type);
       $data_type = mysqli_fetch_array($rst_type);
  
  
  //----get defect/ reason of reject ------
       $query_reason = "SELECT * FROM type_defect_detail_ppcdlv WHERE id_defect = '".sql_esc($row2["type_defect"])."'";
	   $rst_reason = mysqli_query($dbc,$query_reason);
       $data_reason = mysqli_fetch_array($rst_reason);
	   
  
  ?>
    <tr>
     <td><?php echo $no; ?></td>
     <td><?php echo $row2["material_no"]; ?></td>
     <td><?php echo $row2["model_code"]; ?></td>
     <td><?php echo intval($row2["qty_dis"]); ?></td>
     <td><?php echo $row2["uom_dis"]; ?></td>  
     <td><?php echo $row2["work_center"]; ?></td>
     <td><?php echo $row2["sloc_from"]; ?></td>
     <td><?php echo $data_proc["proc_desc"]; ?></td>
     <td><?php echo $data_type["type_desc"]; ?></td>
     <td><?php echo $data_reason["defect_desc"]; ?></td>
     <td><?php echo $row2["reason_reject"]; ?></td>
     <td><?php echo $row2["remark_dis"]; ?></td>  
    </tr>
  
 <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>

     <div class="modal-footer pull-left">
     
       <input name="uid6" type="hidden" value="<?php echo $row["doc_dis"]; ?> ">    
       <input name="date1" type="hidden" value="<?php echo $_GET["date1"]; ?>"> 
       <input name="date2" type="hidden" value="<?php echo $_GET["date2"]; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
       
     <!-- <input name="cancel_btn" type="submit"  class="btn btn-success btn-sm" value="BACK" />-->
      <input name="canC_DISbtn" type="submit"  class="btn btn-danger btn-sm" value="CANCEL" onClick="return confirm('Are you sure to cancel this transaction?');"/>
     
     </div> 
    </form>

                <!--  </div></div>-->
                  </div>
                  </div>
                  </div>
                  </div>
               
</body>
</html>