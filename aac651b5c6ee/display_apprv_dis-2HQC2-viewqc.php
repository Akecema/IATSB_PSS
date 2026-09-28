<?php

date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "dis_approve_qc-tranProc-aprv.php"; 
	require_once('tcpdf_barcodes_2d.php');
	include 'apprv_func_list.php';
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

//CR status (Rejected)
$sta5 = "SELECT * from request_status WHERE status_id = '5'";
$sta_res5 = mysqli_query($dbc,$sta5);
$rst_sta5 = mysqli_fetch_array($sta_res5);

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

//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc,$sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);

//CR status (Pending Approval COO)
$sta25 = "SELECT * from request_status WHERE status_id = '25'";
$sta_res25 = mysqli_query($dbc,$sta25);
$rst_sta25 = mysqli_fetch_array($sta_res25);

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
<style>
<!--modal width-->
.custom { 
	width: 1200px !important;
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
  if(isset($_POST["prt_btnTQC"])) 
  
   { // handle the form.

 
   $uid2 = $_POST["uid2"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   $work_center = $_POST["work_center"];
   
   
   $uid2A = base64_encode($uid2);
   
		   echo "<script>";
		   echo "window.open('detail_aprv_disposal4QQC-prd_print.php?buidT=$uid2A', '_blank');";
		   echo "window.location='dis_approve_qc-tranProc-aprv.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT&&work_center=$work_center'"; 
		   echo "</script>"; 
		   exit(); //quit the script
   
   
   }
   
   
?>
  <div class="modal fade printable autoprint" id="myNoteApprv<?php echo html_esc($row["doc_dis"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content custom">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display Disposal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
     <!--   <div class="content mt-12">-->
     
     <?php
	 
	 $query_bb = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') AS T3, DATE_FORMAT(date_approved,'%d-%m-%Y') AS T9, DATE_FORMAT(date_approved2,'%d-%m-%Y') AS T19, DATE_FORMAT(date_approved3,'%d-%m-%Y') AS T29, DATE_FORMAT(date_approved4,'%d-%m-%Y') AS T39  from disposal_detail_prd_all WHERE doc_dis = '".sql_esc($row["doc_dis"])."' GROUP BY doc_dis";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 //---get user prepared by---
	 
	 $query_prepare = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$data_bb["user_disposal"]]);
	 $result_prepare = db_query($dbc, $query_prepare);
	 $data_prepare = mysqli_fetch_array($result_prepare);
	 
	  //---get user approved by---
		 
	 $query_appr = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$data_bb["approved_by"]]);
	 $result_appr = db_query($dbc, $query_appr);
	 $data_appr = mysqli_fetch_array($result_appr);
	 
	 //---get user approved2 by---
	 
	 $query_appr2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$data_bb["approved_by2"]]);
	 $result_appr2 = db_query($dbc, $query_appr2);
	 $data_appr2 = mysqli_fetch_array($result_appr2);
	 
	  //---get user approved3 by---
	 
	 $query_appr3 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$data_bb["approved_by3"]]);
	 $result_appr3 = db_query($dbc, $query_appr3);
	 $data_appr3 = mysqli_fetch_array($result_appr3);
	 
	 
	 
	 
	 //---get shift-----
	  if($row["shift_day"] == "D/S")
	  
	  {   $shft_new = "Day";
	  
	  }elseif($row["shift_day"] == "D/S")
	  {
		  $shft_new = "Night";
		  
	  }else{
		  
		  $shft_new = "None"; 
	  }
	 
	 ?>
        
        <table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="250" height="50"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<h5><font color="#999999"><b>DISPOSAL FORM</b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>DEPARTMENT :  </b> QUALITY</div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Document No. :  </b><?php echo html_esc($row["doc_dis"]);   ?></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Date :  </b><?php echo html_esc($data_bb["T3"]);   ?></div></td>  
  
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Shift :  </b><?php echo $shft_new;   ?></div></td>
  </tr>
        </table>

        
   
  <?php
  
            $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plant_code = $_GET["plant_code"];
			$work_center = $_GET["work_center"];
			
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
                    $wheresql_01 = " AND plant_cd = '".sql_esc($plant_code)."'"; }  	
					
		   // 3. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND (date_posting >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (date_posting <= '".sql_esc($date2_final)."')"; }
							

			 //5. Work Center
                if ($work_center == "NULL" ){
                    $wheresql_05 = ""; }
                else {
					$wheresql_05 = " AND work_center = '".sql_esc($work_center)."'"; }
							

				$where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04 .$wheresql_05;
	
	//********** END CONDITION **************
	
	
 ?>
 
  <?php
   
   $counterA = 1;
   $noA = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($row["doc_dis"])."' " .$where_sql." ORDER BY doc_dis ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   ?>
 <form name="frmSearch" id="frmSearch" method="post" action="" class="needs-validation"  novalidate>
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
	   
	    //----get process of reject -----
  
       $query_proc = new PreparedSql("SELECT * FROM proc_reject_detail_qqc WHERE id_proc = ?", [$row2["proc_reject"]]);
	   $rst_proc = db_query($dbc, $query_proc);
       $data_proc = mysqli_fetch_array($rst_proc);

   //----get type of reject -----
  
       $query_type = new PreparedSql("SELECT * FROM type_reject_detail_qqc WHERE id_type = ?", [$row2["type_reject"]]);
	   $rst_type = db_query($dbc, $query_type);
       $data_type = mysqli_fetch_array($rst_type);
  
  
   //----get reason of defect ------
       $query_reason = new PreparedSql("SELECT * FROM type_defect_detail_qqc WHERE id_defect = ?", [$row2["type_defect"]]);
	   $rst_reason = db_query($dbc, $query_reason);
       $data_reason = mysqli_fetch_array($rst_reason);
	   
	      //------- quantity	
	
	if($row2["qty_NG"] != "0.000")
	{
		$qty_new = $row2["qty_NG"];
		
	}elseif($row2["qty_qc"] != "0.000")
	{
		$qty_new = $row2["qty_qc"];
	}else{
		
		
	}
  	   
	   

  
  ?>
  <tr>
    <td><?php echo $noA; ?></td>
    <td width="250"><b><?php echo html_esc($row2["material_no"]); ?></b><br><?php echo html_esc($row2["material_desc"]); ?></td>
    <td><?php echo html_esc($row2["model_code"]); ?></td>
    <td><div align="center"><?php if( $row2["UOM_unit"] == 'KG') { ?> <?php echo $qty_new; ?> <?php }else{ ?><?php echo intval($qty_new); ?> <?php } ?></div></td>
    <td><?php echo html_esc($row2["UOM_unit"]); ?></td>
    <td><?php echo html_esc($row2["work_center"]); ?></td>
    <td><div align="center"><?php echo html_esc($row2["ploc_prod_reject"]); ?></div></td>
    <td><?php echo html_esc($data_proc["proc_desc"]); ?></td>
    <td><?php echo html_esc($data_type["type_desc"]); ?></td>
    <td><?php echo html_esc($data_reason["defect_desc"]); ?></td>
    <td><?php echo html_esc($row2["reason_reject"]); ?></td>
    <td width="250"><?php echo html_esc($row2["remarks"]); ?></td>  
  </tr>
  
 <?php 
		  
		  $noA++;
		  $counterA++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>

        <p>&nbsp;</p>
                <div class="modal-body pull-right">
                 <table width="80%" class="table table-bordered">
                   <tr>
                     <th width="33%">Prepared by</th>
                     <th width="33%">Verified by</th>
                     <th width="33%">Verified by</th>
                     <th width="33%">Approved by</th>
                   </tr>
                    <tr>
                     <td><p><b><?php  echo html_esc($data_prepare["user_fullname"]);   ?></b>
                     <br><?php echo html_esc($data_bb["T3"]);   ?></p></td>
                     <td><p><b><?php  if(($data_bb["approved_by"]) != "") { echo html_esc($data_appr["user_fullname"]);  }  ?></b>
                     <br><?php if(($data_bb["approved_by"]) != "") {  echo html_esc($data_bb["T9"]); }  ?></p></td>
                     <td><p><b><?php  if(($data_bb["approved_by2"]) != "") { echo html_esc($data_appr2["user_fullname"]);  }  ?></b>
                     <br><?php if(($data_bb["approved_by2"]) != "") {  echo html_esc($data_bb["T19"]); }  ?></p></td>
                      <td><p><b><?php  if(($data_bb["approved_by3"]) != "") { echo html_esc($data_appr3["user_fullname"]);  }  ?></b>
                     <br><?php if(($data_bb["approved_by3"]) != "") {  echo html_esc($data_bb["T29"]); }  ?></p></td>
                   </tr>
                   <tr>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv5["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv6["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv8["apprv_name"]); ?></div></td>
                   </tr>
                 </table></div>
             
             <br>
             
              <p>
              
                
             <table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr>
                    <td><table width="98%" class="table-borderless">
                   <tr>
                     <th colspan="4"><div class="style18">COMMENT</div></th>
                   </tr>
                    <tr> 
                     <td width="20%"><div class="style7"><?php echo html_esc($rst_apprv5["apprv_name2"]); ?>:</div></td>
                     <td width="25%"><textarea name="remark_approved" id="remark_approved" rows="2" cols="30" readonly><?php if(($data_bb["approved_by"]) != "") {  echo html_esc($data_bb["remark_approved"]); } ?></textarea> </td>
                   </tr>
                    <tr> 
                     <td width="20%"><div class="style7"><?php echo html_esc($rst_apprv6["apprv_name2"]); ?>:</div></td>
                     <td width="25%"><textarea name="remark_approved2" id="remark_approved2" rows="2" cols="30" ><?php if(($data_bb["approved_by2"]) != "") {  echo html_esc($data_bb["remark_approved2"]); } ?></textarea></td>
                    </tr>
                     <tr> 
                     <td width="20%"><div class="style7"><?php echo html_esc($rst_apprv8["apprv_name2"]); ?>:</div></td>
                     <td width="25%"><textarea name="remark_approved3" id="remark_approved3" rows="2" cols="30" ><?php if(($data_bb["approved_by3"]) != "") {  echo html_esc($data_bb["remark_approved3"]); } ?></textarea></td>
                    </tr>
                  </table>    </td>
  </tr>
</table>
             </p>
           
          </p>
             
             <br>
             
   

                <!--  </div></div>-->
                  </div>  
                  
      <div class="modal-footer">
      
       <input name="uid2" type="hidden" value="<?php echo html_esc($row["doc_dis"]); ?>">    
       <input name="date1" type="hidden" value="<?php echo $dateF; ?>"> 
       <input name="date2" type="hidden" value="<?php echo $dateT; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">
       <input name="work_center" type="hidden" value="<?php echo $work_center; ?>">
      <input name="prt_btnTQC" type="submit"  class="btn btn-warning btn-sm" value="PRINT"/>
     </div> 
     </form>
                  </div>
                  </div>
                  </div>
               
</body>
</html>