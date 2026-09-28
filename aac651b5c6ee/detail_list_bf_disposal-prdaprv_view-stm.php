<?php
    
	date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "detail_list_bf_disposal-prd-aprv.php"; 
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

//----disposal prod
$query_setup2 = "SELECT * FROM sys_setup_disposal WHERE id = '3' AND status_acc = 'Y'";
$rs_setup2 = mysqli_query($dbc,$query_setup2);   //run the query.
$num_setup2 = mysqli_num_rows($rs_setup2);   //how many material are there?
$data_setup2 = mysqli_fetch_array($rs_setup2);

//-----disposal prod assy
$query_setup3 = "SELECT * FROM sys_setup_disposal WHERE id = '1' AND status_acc = 'Y'";
$rs_setup3 = mysqli_query($dbc,$query_setup3);   //run the query.
$num_setup3 = mysqli_num_rows($rs_setup3);   //how many material are there?
$data_setup3 = mysqli_fetch_array($rs_setup3);

//----disposal prod stm
$query_setup4 = "SELECT * FROM sys_setup_disposal WHERE id = '2' AND status_acc = 'Y'";
$rs_setup4 = mysqli_query($dbc,$query_setup4);   //run the query.
$num_setup4 = mysqli_num_rows($rs_setup4);   //how many material are there?
$data_setup4 = mysqli_fetch_array($rs_setup4);

//----disposal qc
$query_setup5 = "SELECT * FROM sys_setup_disposal WHERE id = '5' AND status_acc = 'Y'";
$rs_setup5 = mysqli_query($dbc,$query_setup5);   //run the query.
$num_setup5 = mysqli_num_rows($rs_setup5);   //how many material are there?
$data_setup5 = mysqli_fetch_array($rs_setup5);

//----disposal ppc
$query_setup6 = "SELECT * FROM sys_setup_disposal WHERE id = '4' AND status_acc = 'Y'";
$rs_setup6 = mysqli_query($dbc,$query_setup6);   //run the query.
$num_setup6 = mysqli_num_rows($rs_setup6);   //how many material are there?
$data_setup6 = mysqli_fetch_array($rs_setup6);

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

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc,$sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Pending Approve)
$sta15 = "SELECT * from request_status WHERE status_id = '15'";
$sta_res15 = mysqli_query($dbc,$sta15);
$rst_sta15 = mysqli_fetch_array($sta_res15);

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

//CR status (Return GRA)
$sta26 = "SELECT * from request_status WHERE status_id = '26'";
$sta_res26 = mysqli_query($dbc,$sta26);
$rst_sta26 = mysqli_fetch_array($sta_res26);


//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

//CR status (Pending Approval Exec QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

//CR status (Pending Approve STM)
$sta32 = "SELECT * from request_status WHERE status_id = '32'";
$sta_res32 = mysqli_query($dbc,$sta32);
$rst_sta32 = mysqli_fetch_array($sta_res32);

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
   <style>
	.style7 {	
	font-size: 11px;
	font-weight: bold;
	color: #000000;
	/*font-family: Arial, Helvetica, sans-serif;*/
    }
	.style17 {	
	font-size: 11px;
	color: #000000;
	
    }
	.style18 {	
	font-size: 14px;
	color: #000000; 
	font-family: Arial, Helvetica, sans-serif;
	text-decoration: underline;
    }
	
	</style> 

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
  if(isset($_POST["cancel_btn"])) 
  
   { // handle the form.

 
   $uid = $_POST["uid"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   $work_center = $_POST["work_center"];

		   echo "<script>";
		   echo "window.location='detail_list_bf_disposal-prd-aprvProc2.php?date1=$dateF&&date2=$dateT&&plant_code=$plant_code&&work_center=$work_center'";
	       echo "</script>"; 
		   exit(); //quit the script
		
  


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteView<?php echo html_esc($row["doc_dis"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
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
	 
	 $query_bb = "SELECT *, DATE_FORMAT(date_disposal,'%d-%m-%Y') AS T3, DATE_FORMAT(date_approved,'%d-%m-%Y') AS T9, DATE_FORMAT(date_approved2,'%d-%m-%Y') AS T19, DATE_FORMAT(date_approved3,'%d-%m-%Y') AS T29, DATE_FORMAT(date_approved4,'%d-%m-%Y') AS T39, DATE_FORMAT(date_approved5,'%d-%m-%Y') AS T49  from disposal_detail_prd_all WHERE doc_dis = '".sql_esc($row["doc_dis"])."' GROUP BY doc_dis";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);	 
	 
	 //---get user prepared by---
	 
	 $query_prepare = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["user_disposal"])."'";
	 $result_prepare = mysqli_query($dbc,$query_prepare);
	 $data_prepare = mysqli_fetch_array($result_prepare);
	 
	  //---get user approved by---
	 
	 $query_appr5 = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["approved_by5"])."'";
	 $result_appr5 = mysqli_query($dbc,$query_appr5);
	 $data_appr5 = mysqli_fetch_array($result_appr5);
	 
	 
	  //---get user approved by---
	 
	 $query_appr = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["approved_by"])."'";
	 $result_appr = mysqli_query($dbc,$query_appr);
	 $data_appr = mysqli_fetch_array($result_appr);
	 
	 //---get user approved2 by---
	 
	 $query_appr2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["approved_by2"])."'";
	 $result_appr2 = mysqli_query($dbc,$query_appr2);
	 $data_appr2 = mysqli_fetch_array($result_appr2);
	 
	  //---get user approved3 by---
	 
	 $query_appr3 = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["approved_by3"])."'";
	 $result_appr3 = mysqli_query($dbc,$query_appr3);
	 $data_appr3 = mysqli_fetch_array($result_appr3);
	 
	 //---get user approved4 by---
	 
	 $query_appr4 = "SELECT * FROM user_detail WHERE username = '".sql_esc($data_bb["approved_by4"])."'";
	 $result_appr4 = mysqli_query($dbc,$query_appr4);
	 $data_appr4 = mysqli_fetch_array($result_appr4);
	 
	 //---get shift-----
	  if($data_bb["shift_posting"] == "D/S")
	  
	  {   $shft_new = "Day";
	  
	  }elseif($data_bb["shift_posting"] == "N/S")
	  {
		  $shft_new = "Night";
		  
	  }else{
		  
		  $shft_new = "None"; 
	  }
	 
	 
	 ?>
	 
	     <table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
  <tr>
    <td height="100"><img src="../set_upload/<?php echo $filename; ?>" width="250" height="50"/> <br></td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<h5><font color="#999999"><b>DISPOSAL FORM</b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>DEPARTMENT :  </b> PRODUCTION</div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Document No. :  </b><?php echo html_esc($row["doc_dis"]);  ?></div></td>
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
                    $wheresql_03 = " AND (date_disposal >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //4. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (date_disposal <= '".sql_esc($date2_final)."')"; }
					
		//5. Work Center
                if ($work_center == "NULL" ){
                    $wheresql_05 = ""; }
                else {
					$wheresql_05 = " AND work_center = '".sql_esc($work_center)."'"; }
							

				$where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04 .$wheresql_05;
	
	//********** END CONDITION **************
	
	
 ?>
 
  <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($row["doc_dis"])."' AND (status_disposal = '".sql_esc($rst_sta3["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta5["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta15["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta10["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta24["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta25["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta29["status_desc"])."')" .$where_sql." ORDER BY doc_dis ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
  
   ?>
 
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
     <th>Process/Section</th>
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
  
		 $query_proc = "SELECT * FROM proc_reject_detail_prd WHERE id_proc = '".sql_esc($row2["proc_reject"])."'";
		 $rst_proc = mysqli_query($dbc,$query_proc);
		 $data_proc = mysqli_fetch_array($rst_proc);

   //----get type of reject -----
  
       $query_type = "SELECT * FROM type_reject_detail_prd WHERE id_type = '".sql_esc($row2["type_reject"])."'";
	   $rst_type = mysqli_query($dbc,$query_type);
       $data_type = mysqli_fetch_array($rst_type);
  
  
  //----get reason of defect ------
       $query_reason = "SELECT * FROM type_defect_detail_prd WHERE id_defect = '".sql_esc($row2["type_defect"])."'";
	   $rst_reason = mysqli_query($dbc,$query_reason);
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
  
   //----model ---
  
 $query_Mod = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($row2["model_code"])."' AND status_wc = 'Y' ORDER BY id ASC";
 $result_Mod = mysqli_query($dbc,$query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  
 
  if($row_Mod["wc_desc2"] == "")
  {
	  $model_name = $row_Mod["id_work"];
  }else{
	  
	 $model_name = $row_Mod["wc_desc2"]; 
  }   
  
  
  ?>
    <tr>
    <td><div align="center"><?php echo $noA; ?></div></td>
    <td width="250"><b><?php echo html_esc($row2["material_no"]); ?></b><br><?php echo html_esc($row2["material_desc"]); ?></td>
    <td><div align="center"><?php echo $model_name; ?></div></td>
    <td><?php echo intval($qty_new); ?></td>
    <td><?php echo html_esc($row2["UOM_unit"]); ?></td>
    <td><div align="center"><?php echo html_esc($row2["work_center"]); ?></div></td>
    <td><div align="center"><?php echo html_esc($row2["ploc_prod_reject"]); ?></div></td>
    <td><?php echo html_esc($data_proc["proc_desc"]); ?></td>
    <td><?php echo html_esc($data_type["type_desc"]); ?></td>
    <td><?php echo html_esc($data_reason["defect_desc"]); ?></td>
    <td><?php echo html_esc($data_reason["id_reason"]); ?></td>
    <td width="250"><?php echo html_esc($row2["remarks"]); ?></td>  
  </tr>
  
 <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>
<br>
<?php 
 
   if($data_setup4["bil_table"] == "4")
   {  ?>

 <p>&nbsp;</p>
                <div class="modal-body pull-right">
               <table width="60%" class="table table-bordered">
                   <tr>
                     <th width="10%"><div align="center" class="style7">Prepared by</div></th>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th>
                     <th width="10%"><div align="center" class="style7">Approved by</div></th>
                   </tr>
                     <tr>
                     <td><div align="center"><p><b><?php  echo html_esc($data_prepare["user_fullname"]);   ?></b>
                     <br><?php echo html_esc($data_bb["T3"]);   ?></p></div></td>
                      <td><div align="center"><p><b><?php  if((($data_bb["approved_by5"]) != "") && (($data_bb["status_approved5"]) == $rst_sta3["status_desc"])) { echo html_esc($data_appr5["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by5"]) != "") && (($data_bb["status_approved5"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T49"]); } ?></p></div></td>
                     <td><div align="center"><p><b><?php  if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) { echo html_esc($data_appr["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T9"]); } ?></p></div></td> 
                     <td><div align="center"><p><b><?php  if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) { echo html_esc($data_appr2["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T19"]); } ?></p></div></td> 
                   </tr>
                   <tr>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv3["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv5["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv6["apprv_name"]); ?></div></td>
                   </tr>
                 </table>
              </div><br>
              <table width="98%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td><table width="98%" class="table-borderless">
                   <tr>
                     <th colspan="4"><div class="style18">COMMENT</div></th>
                   </tr>
                  <tr> 
                     <td width="20%"><div class="style7"><?php echo html_esc($rst_apprv3["apprv_name2"]); ?>:</div></td> 
                     <td width="25%"><?php if(($data_bb["approved_by5"]) != "") {  echo html_esc($data_bb["remark_approved5"]); }else{ ?>
                     _______________________________________________<?php }  ?></td>
                     <td width="20%"><div class="style7"><?php echo html_esc($rst_apprv5["apprv_name2"]); ?>:</div></td>
                     <td width="25%"><?php if(($data_bb["approved_by"]) != "") {  echo html_esc($data_bb["remark_approved"]); }else{ ?>
                     _______________________________________________<?php }  ?> </td>
                      </tr>
                   <tr>   
                     <td width="20%"><div class="style7"><?php echo html_esc($rst_apprv6["apprv_name2"]); ?>:</div></td>
                     <td width="25%"><?php if(($data_bb["approved_by2"]) != "") {  echo html_esc($data_bb["remark_approved2"]); }else{ ?>
                     _______________________________________________<?php }  ?></td> 
                     <td width="20%">&nbsp;</td>
                     <td width="25%">&nbsp;</td>
                   </tr>
                    <tr> 
                        <td width="20%">&nbsp;</td>
                     <td width="25%">&nbsp;</td>
                      <td width="20%">&nbsp;</td>
                     <td width="25%">&nbsp;</td>
                   </tr>
                  </table>    </td>
  </tr>
</table><?php }  include "prod-linestm_dtlaprv_prdaprv_print.php";  ?>


     <div class="modal-footer pull-left">
     <!-- <input name="cancel_btn" type="submit"  class="btn btn-success btn-sm" value="BACK" />-->
     <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">CANCEL</button>
     </div> 


                <!--  </div></div>-->
                  </div>
                  </div>
                  </div>
                  </div>
               
</body>
</html>