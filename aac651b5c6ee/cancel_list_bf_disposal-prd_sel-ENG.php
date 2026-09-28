<?php
    date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "detail_list_bf_disposal-prdProc2.php"; 
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

//CR status (Return GRA)
$sta26 = "SELECT * from request_status WHERE status_id = '26'";
$sta_res26 = mysqli_query($dbc,$sta26);
$rst_sta26 = mysqli_fetch_array($sta_res26);

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);		

//CR status (Pending Approve STM)
$sta32 = "SELECT * from request_status WHERE status_id = '32'";
$sta_res32 = mysqli_query($dbc,$sta32);
$rst_sta32 = mysqli_fetch_array($sta_res32);

//CR status (Pending Approve ASSY)
$sta34 = "SELECT * from request_status WHERE status_id = '34'";
$sta_res34 = mysqli_query($dbc,$sta34);
$rst_sta34 = mysqli_fetch_array($sta_res34);
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
 //-------------- click button "Cancellation"----------------
  if(isset($_POST["can_DISbtnASSY"])) 
  
   { // handle the form.

 
   $uid4 = $_POST["uid4"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   $work_center = $_POST["work_center"];

	$sta_out = substr($uid4,4,3);	
	//echo $sta_out; 
	
	
    //--------- Disposal Production all detail ------------
	 
	   $query_info5 = "SELECT * FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid4)."' AND (status_disposal = '".sql_esc($rst_sta34["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta15["status_desc"])."')";
	   $result_info5 = mysqli_query($dbc,$query_info5);
	  
	  while($data_info5 = mysqli_fetch_array($result_info5))
	  
	  {
		  
        if($sta_out == "391")
        {
     
      //------generate Material Document No. Cancellation for DISPOSAL ENGNEERING---------------------------------
                  
                    if($_POST["plant_code"] == '3100')
                  {
                  
                   $query_id21 = "SELECT * FROM run_count_itsb WHERE uid = '107'";
                   $result_id21 = mysqli_query($dbc,$query_id21);
                  
                  }elseif($_POST["plant_code"] == '3101')
                  {
                      
                   $query_id21 = "SELECT * FROM run_count_itsb WHERE uid = '109'";
                   $result_id21 = mysqli_query($dbc,$query_id21);
                      
                  }
                  
                  if ($result_id21) 
              {
                  $nrows21 = mysqli_num_rows($result_id21);
                  $row_id21 = mysqli_fetch_array($result_id21);
                  
                  $dht21 = 00000; 
                  $dht_OK21 = "392";
                  $dg21 = 0;
              
                  if($row_id21["count_max"] <= 0)
                  { 
                 
                      $lastID21 = ($row_id21["count_max"] + 1);
                      $dg21 = ($dht21 + ($lastID21));
                 }
                 else
                 {
                    $lastID21 = ($row_id21["count_max"] + 1);
                    $dg21 =  $lastID21;
                  
                  }
                  $number21 = $dg21; // Length of running no
                  $number21 = sprintf('%03d', $number21);  
                  
                  $ref21 = (($row_id21["start_ref"]).$dht_OK21.$date_run.($number21));
                  
                  } // end if $result_id2	
      
     
     
     // ---------update cancel Disposal and revert to original table--------------------------
       
      $query_cancelGR1 = "UPDATE disposal_detail_prd_all SET disposal_no_ref = '".sql_esc($ref21)."', status_disposal = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW() WHERE doc_dis = '".sql_esc($uid4)."' AND status_disposal = '".sql_esc($rst_sta15["status_desc"])."'";
      $result_cancelGR1 = mysqli_query($dbc,$query_cancelGR1);
      
       
        
         $query_infoB1 = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid4)."' AND id = '".sql_esc($data_info5["id"])."' AND status_disposal = '".sql_esc($rst_sta4["status_desc"])."' AND disposal_no_ref = '".sql_esc($ref21)."'";
         $result_infoB1 = mysqli_query($dbc,$query_infoB1);
         $row_infoB1 = mysqli_fetch_array($result_infoB1);
        
       // echo $row_infoB["id_disposal"];	
       
        $query_ins_dis1 = "INSERT INTO disposal_detail_prd_all_canc(id,id_dis,id_disposal,doc_dis,doc_disposal_no,bflush_hwork,bflush_rework,bflush_pending,bflush_qqc_no,plan_no,uid,material_no,material_desc,material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit,comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoB1["id"])."','".sql_esc($row_infoB1["id_disposal"])."','".sql_esc($row_infoB1["doc_dis"])."','".sql_esc($row_infoB1["doc_disposal_no"])."','".sql_esc($row_infoB1["bflush_hwork"])."','".sql_esc($row_infoB1["bflush_rework"])."','".sql_esc($row_infoB1["bflush_pending"])."','".sql_esc($row_infoB1["bflush_qqc_no"])."','".sql_esc($row_infoB1["plan_no"])."','".sql_esc($row_infoB1["uid"])."','".sql_esc($row_infoB1["material_no"])."','".sql_esc($row_infoB1["material_desc"])."','".sql_esc($row_infoB1["material_type"])."','".sql_esc($row_infoB1["model_code"])."','".sql_esc($row_infoB1["qty_plan"])."','".sql_esc($row_infoB1["qty_actual"])."','".sql_esc($row_infoB1["qty_balance"])."','".sql_esc($row_infoB1["qty_NG"])."','".sql_esc($row_infoB1["qty_qc"])."','".sql_esc($row_infoB1["qty_qc_ok"])."','".sql_esc($row_infoB1["qty_qc_NG"])."','".sql_esc($row_infoB1["UOM_unit"])."','".sql_esc($row_infoB1["comp_code"])."','".sql_esc($row_infoB1["work_center"])."','".sql_esc($row_infoB1["shift_day"])."','".sql_esc($row_infoB1["date_plan"])."','".sql_esc($row_infoB1["user_posting"])."','".sql_esc($row_infoB1["date_posting"])."','".sql_esc($row_infoB1["time_posting"])."','".sql_esc($row_infoB1["status_disposal"])."','".sql_esc($row_infoB1["ploc"])."','".sql_esc($row_infoB1["ploc_prod_reject"])."','".sql_esc($row_infoB1["ploc_qc_reject"])."','".sql_esc($row_infoB1["proc_reject"])."','".sql_esc($row_infoB1["type_reject"])."','".sql_esc($row_infoB1["type_defect"])."','".sql_esc($row_infoB1["reason_reject"])."','".sql_esc($row_infoB1["user_reject"])."','".sql_esc($row_infoB1["date_reject"])."','".sql_esc($row_infoB1["time_reject"])."','".sql_esc($row_infoB1["qty_wastage"])."','".sql_esc($row_infoB1["type_wastage"])."','".sql_esc($row_infoB1["reason_wastage"])."','".sql_esc($row_infoB1["user_wastage"])."','".sql_esc($row_infoB1["date_wastage"])."','".sql_esc($row_infoB1["time_wastage"])."','".sql_esc($row_infoB1["user_disposal"])."','".sql_esc($row_infoB1["date_disposal"])."','".sql_esc($row_infoB1["remarks"])."','".sql_esc($row_infoB1["status_part"])."','".sql_esc($row_infoB1["user_update"])."','".sql_esc($row_infoB1["date_update"])."','".sql_esc($row_infoB1["status_approved"])."','".sql_esc($row_infoB1["approved_by"])."','".sql_esc($row_infoB1["date_approved"])."','".sql_esc($row_infoB1["remark_approved"])."','".sql_esc($row_infoB1["status_approved2"])."','".sql_esc($row_infoB1["approved_by2"])."','".sql_esc($row_infoB1["date_approved2"])."','".sql_esc($row_infoB1["remark_approved2"])."','".sql_esc($row_infoB1["status_approved3"])."','".sql_esc($row_infoB1["approved_by3"])."','".sql_esc($row_infoB1["date_approved3"])."','".sql_esc($row_infoB1["remark_approved3"])."','".sql_esc($row_infoB1["status_approved4"])."','".sql_esc($row_infoB1["approved_by4"])."','".sql_esc($row_infoB1["date_approved4"])."','".sql_esc($row_infoB1["remark_approved4"])."','".sql_esc($row_infoB1["status_approved5"])."','".sql_esc($row_infoB1["approved_by5"])."','".sql_esc($row_infoB1["date_approved5"])."','".sql_esc($row_infoB1["remark_approved5"])."','".sql_esc($row_infoB1["cost_center"])."','".sql_esc($row_infoB1["id_factory"])."','".sql_esc($row_infoB1["disposal_no_ref"])."','".sql_esc($row_infoB1["user_cancel"])."','".sql_esc($row_infoB1["date_cancel"])."','".sql_esc($row_infoB1["remark_cancel"])."','".sql_esc($row_infoB1["plant_cd"])."','".sql_esc($row_infoB1["shift_posting"])."','".sql_esc($row_infoB1["stamp_ind"])."','".sql_esc($row_infoB1["reject_source"])."','".sql_esc($row_infoB1["back_no"])."','".sql_esc($row_infoB1["kanban_no"])."','".sql_esc($row_infoB1["SAP_ref_doc"])."','".sql_esc($row_infoB1["SAP_ref_doc_can"])."')";
        $result_ins_dis1 = mysqli_query($dbc,$query_ins_dis1);
      
      
      
      
      //update count_max----------------------------------------
       
            if($_POST["plant_code"] == '3100')
          {
        
             $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number21)."', date_updated = NOW() WHERE uid = '107'";
             $result_max_a1 = mysqli_query($dbc,$query_max_a1);
      
          }elseif($_POST["plant_code"] == '3101')
          {
             $query_max_b1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number21)."', date_updated = NOW() WHERE uid = '109'";
             $result_max_b1 = mysqli_query($dbc,$query_max_b1);
           
          }
      
      //-----------------------------end 311---------------------------------------
      
        }
		 
	  }//end while loop
	  
	  
    

		   echo "<script>";
		   echo "alert('Cancel Disposal ".html_esc($uid4)." posted.');";
		   echo "window.location='detail_list_bf_disposal-prdProc2.php?date1=$dateF&&date2=$dateT&&plant_code=$plant_code&&work_center=$work_center'";
	       echo "</script>"; 
		   exit(); //quit the script
		


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteCancelDIS<?php echo html_esc($row["doc_dis"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Cancellation Disposal</h5>
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

  

<br>

        <div class="content mt-12"><h5>Are you sure to cancel this transaction?</h5><br>
       

    <form name="frmSearch" id="frmSearch" method="post" action="" class="needs-validation"  novalidate>

    <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($row["doc_dis"])."' AND status_disposal = '".sql_esc($rst_sta34["status_desc"])."' " .$where_sql." ORDER BY doc_dis ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   
   while($row6 = mysqli_fetch_array($result_display))
   {


		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
   <input name="uid4" type="hidden" value="<?php echo html_esc($row["doc_dis"]); ?> ">    
       <input name="date1" type="hidden" value="<?php echo $dateF; ?>"> 
       <input name="date2" type="hidden" value="<?php echo $dateT; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
       <input name="work_center" type="hidden" value="<?php echo $work_center; ?>"> 
      
     <div class="modal-footer pull-left">
      <input name="can_DISbtnASSY" type="submit"  class="btn btn-success btn-sm" value="YES" />
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