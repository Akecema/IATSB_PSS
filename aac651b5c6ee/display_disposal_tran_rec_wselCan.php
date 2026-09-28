<?php
    date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "canC_disposal_tran-recProc.php"; 
	require_once('tcpdf_barcodes_2d.php');
	include 'apprv_func_list.php';
    include 'dis_apprv_auth.php';
	
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

//----disposal PPc
$query_setup4 = "SELECT * FROM sys_setup_disposal WHERE id = '4' AND status_acc = 'Y'";
$rs_setup4 = mysqli_query($dbc,$query_setup4);   //run the query.
$num_setup4 = mysqli_num_rows($rs_setup4);   //how many material are there?
$data_setup4 = mysqli_fetch_array($rs_setup4);

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

.style7 {	
	font-size: 11px;
	font-weight: bold;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
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
  
  
    //-------------- click button "Rejected"--------------------------------------------------------------------------------------
  if(isset($_POST["prt_btn"])) 
   { // handle the form.
 
   $uid6 = $_POST["uid6"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   
   $uid2A = base64_encode($uid6);
   
           echo "<script>";
		   echo "window.open('print_dis_approve4_tran-prcvProc.php?buid=$uid2A','_blank');";
		   echo "window.location='canC_afdisposal_tran-recProc.php?date1=$dateF&&date2=$dateT&&plant_code=$plant_code';"; 
		   echo "</script>"; 
		   exit(); //quit the script
   
   
   }
   
?>
  <div class="modal fade printable autoprint" id="myNoteDisplayDIS<?php echo html_esc($row["doc_dis"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
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
	 
	 $query_bb = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T3, DATE_FORMAT(date_approved1,'%d-%m-%Y') AS T9, DATE_FORMAT(date_approved2,'%d-%m-%Y') AS T19, DATE_FORMAT(date_approved3,'%d-%m-%Y') AS T29, DATE_FORMAT(date_approved4,'%d-%m-%Y') AS T39 from gra_disposal_ppcrec_detail WHERE doc_dis = '".sql_esc($row["doc_dis"])."' GROUP BY doc_dis";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);	 
	 
	 //---work center----
	 $query_line = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($data_bb["work_center"])."'";
	 $rs_line = mysqli_query($dbc,$query_line);   //run the query.
     $data_line = mysqli_fetch_array($rs_line);	 
	 
	  //-----user canccellation-----------
	 
	 $query_u_can = "SELECT * FROM user_detail WHERE username = '".sql_esc($row["user_cancel"])."'"; 
	 $rs_u_can = mysqli_query($dbc,$query_u_can);   //run the query.
     $data_u_can = mysqli_fetch_array($rs_u_can);
	 
	 
	 //---get user prepared by---
	 
	 $query_prepare = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["user_generate_dis"])."'";
	 $result_prepare = mysqli_query($dbc,$query_prepare);
	 $data_prepare = mysqli_fetch_array($result_prepare);
	 
	  //---get user approved by---
	 
	 $query_appr = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["hod_approved1"])."'";
	 $result_appr = mysqli_query($dbc,$query_appr);
	 $data_appr = mysqli_fetch_array($result_appr);
	 
	 //---get user approved2 by---
	 
	 $query_appr2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["hod_approved2"])."'";
	 $result_appr2 = mysqli_query($dbc,$query_appr2);
	 $data_appr2 = mysqli_fetch_array($result_appr2);
	 
	  //---get user approved3 by---
	 
	 $query_appr3 = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["hod_approved3"])."'";
	 $result_appr3 = mysqli_query($dbc,$query_appr3);
	 $data_appr3 = mysqli_fetch_array($result_appr3);
	 
	 //---get user approved4 by---
	 
	 $query_appr4 = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["hod_approved4"])."'";
	 $result_appr4 = mysqli_query($dbc,$query_appr4);
	 $data_appr4 = mysqli_fetch_array($result_appr4);
	 
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
    <td><div align="left"><b>Document No. :  </b><?php echo html_esc($row["doc_dis"]);   ?></div></td>
   <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Date :  </b><?php echo html_esc($data_bb["T3"]);   ?></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Shift :  </b><?php echo $shift_ds;   ?></div></td>
  </tr>
  <?php  if($row["status_dis"] == $rst_sta4["status_desc"]) {  ?>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Cancelled By :  </b><?php echo html_esc($data_u_can["user_fullname"]);  ?></div></td>
  </tr><?php    }   ?>
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
   
$query_display = "SELECT * FROM gra_disposal_ppcrec_detail WHERE doc_dis = '".sql_esc($row["doc_dis"])."'  " .$where_sql." ORDER BY doc_dis ASC ";
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
     <td><?php echo html_esc($row2["material_no"]); ?></td>
     <td><?php echo html_esc($row2["model_code"]); ?></td>
     <td><?php echo intval($row2["qty_dis"]); ?></td>
     <td><?php echo html_esc($row2["uom_dis"]); ?></td>  
     <td><?php echo html_esc($row2["work_center"]); ?></td>
     <td><?php echo html_esc($row2["sloc_from"]); ?></td>
     <td><?php echo html_esc($data_proc["proc_desc"]); ?></td>
     <td><?php echo html_esc($data_type["type_desc"]); ?></td>
     <td><?php echo html_esc($data_reason["defect_desc"]); ?></td>
     <td><?php echo html_esc($row2["reason_reject"]); ?></td>
     <td><?php echo html_esc($row2["remark_dis"]); ?></td>  
    </tr>
  
 <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>

  <p>&nbsp;</p>
                <div class="modal-body pull-right">
                 <table width="50%" class="table table-bordered">
                   <tr>
                     <th width="10%"><div align="center" class="style7">Prepared by</div></th>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th>
                     <?php if($data_setup4["bil_table"] == "5") {  ?>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th><?php } ?>
                     <th width="10%"><div align="center" class="style7">Approved by</div></th>
                   </tr>
                     <tr>
                     <td><div align="center" class="style7"><p><b><?php  echo html_esc($data_prepare["user_fullname"]);   ?></b>
                     <br><?php echo html_esc($data_bb["T3"]);   ?></p></div></td>
                     <td><div align="center" class="style7"><p><b><?php  if(($data_bb["hod_approved1"]) != "") { echo html_esc($data_appr["user_fullname"]);  }  ?></b>
                     <br><?php if(($data_bb["hod_approved1"]) != "") {  echo html_esc($data_bb["T9"]); } ?></p></div></td> 
                     <td><div align="center" class="style7"><p><b><?php  if(($data_bb["hod_approved2"]) != "") { echo html_esc($data_appr2["user_fullname"]);  }  ?></b>
                     <br><?php if(($data_bb["hod_approved2"]) != "") {  echo html_esc($data_bb["T19"]); } ?></p></div></td> 
                     <td><div align="center" class="style7"><p><b><?php  if(($data_bb["hod_approved3"]) != "") { echo html_esc($data_appr3["user_fullname"]);  }  ?></b>
                     <br><?php if(($data_bb["hod_approved3"]) != "") {  echo html_esc($data_bb["T29"]); } ?></p></div></td>
                      <?php if($data_setup4["bil_table"] == "5") {  ?>
                     <td><div align="center" class="style7"><p><b><?php  if(($data_bb["hod_approved4"]) != "") { echo html_esc($data_appr4["user_fullname"]);  }  ?></b>
                     <br><?php if(($data_bb["hod_approved4"]) != "") {  echo html_esc($data_bb["T39"]); } ?></p></div></td>
                     <?php } ?>
                   </tr>
                   <tr>
                      <td><div align="center" class="style7"><?php echo html_esc($rst_apprv["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv2["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv5["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv6["apprv_name"]); ?></div></td>
                       <?php if($data_setup4["bil_table"] == "5") {  ?>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv8["apprv_name"]); ?></div></td><?php  } ?>
                   </tr>
                 </table></div>
             
             <br>
             
              <p>
             <div class="modal-body pull-left">
             <table width="45%" border="1" cellspacing="0" cellpadding="1">
                  <tr>
                    <td><table width="98%" class="table-borderless">
                   <tr>
                     <th colspan="4"><div class="style18">COMMENT</div></th>
                   </tr>
                    <tr> 
                     <td width="25%"><b><?php echo html_esc($rst_apprv2["apprv_name2"]); ?> :</b></td>
                     <td width="25%"><textarea name="remark_approved" id="remark_approved" rows="2" cols="30" readonly><?php if(($data_bb["hod_approved1"]) != "") {  echo html_esc($data_bb["remark_approved1"]); } ?></textarea></td>
                     <td width="25%"><b><?php echo html_esc($rst_apprv5["apprv_name2"]); ?> :</b></td>
                     <td width="25%"><textarea name="remark_approved2" id="remark_approved2" rows="2" cols="30" readonly><?php if(($data_bb["hod_approved2"]) != "") {  echo html_esc($data_bb["remark_approved2"]); } ?></textarea></td>
                    
                   </tr>
                    <tr> 
                     <td width="25%"><b><?php echo html_esc($rst_apprv6["apprv_name2"]); ?> :</b></td>
                     <td width="25%"><textarea name="remark_approved3" id="remark_approved3" rows="2" cols="30" readonly><?php if(($data_bb["hod_approved3"]) != "") {  echo html_esc($data_bb["remark_approved3"]); } ?></textarea> </td>
                       <?php if($data_setup4["bil_table"] == "5") {  ?>
                     <td width="25%"><b><?php echo html_esc($rst_apprv8["apprv_name2"]); ?> :</b></td>
                     <td width="25%"><textarea name="remark_approved4" id="remark_approved4" rows="2" cols="30" readonly><?php if(($data_bb["hod_approved4"]) != "") {  echo html_esc($data_bb["remark_approved4"]); } ?></textarea> </td><?php  } ?>
                   </tr>
                  </table>    </td>
  </tr>
</table>
             </p></div>

     <div class="modal-footer pull-left">
     
       <input name="uid6" type="hidden" value="<?php echo html_esc($row["doc_dis"]); ?> ">    
       <input name="date1" type="hidden" value="<?php echo html_esc($_GET["date1"]); ?>"> 
       <input name="date2" type="hidden" value="<?php echo html_esc($_GET["date2"]); ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
       <input name="trans_opt" type="hidden" value="<?php echo $trans_opt; ?>"> 
       <input name="prt_btn" type="submit"  class="btn btn-warning btn-sm" value="PRINT"/>
     <!-- <input name="cancel_btn" type="submit"  class="btn btn-success btn-sm" value="BACK" />-->
     
     </div> 
     
     
    </form>

                <!--  </div></div>-->
                  </div>
                  </div>
                  </div>
                  </div>
               
</body>
</html>