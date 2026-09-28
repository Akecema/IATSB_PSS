<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "detail_pps_month_reprint.php"; 
	require_once('tcpdf_barcodes_2d.php');

	
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
  <?php
 //-------------- click button "PROCEED"----------------
  if(isset($_POST["proc_btn"])) 
  
   { // handle the form.

 
   $id = $_POST["id"];
   
  // echo $id;
   
    //--------- pps detail ------------
	 
	   $query_pps = "SELECT * FROM pps_detail WHERE id = '".sql_esc($id)."'";
	   $result_pps = mysqli_query($dbc,$query_pps);
       $data_pps = mysqli_fetch_array($result_pps);
	  
		  
	  //---------update status "New" kpd "Release"--------------------------
	 
	$query_upd_rel = "UPDATE pps_detail SET status_pps = '".sql_esc($rst_sta2["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), user_posting = '".sql_esc($username)."', date_posting = NOW() WHERE id = '".sql_esc($id)."'";
	$result_upd_rel = mysqli_query($dbc,$query_upd_rel);
		  
	 
	  if($result_upd_rel)
	 { 

		   echo "<script>";
		   echo "alert('Your transaction has been processed successfully');";
		   echo "window.location='display_pps_month_reprint2.php?date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&plant_code=".html_esc($plant_code)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."&&shift_ops=".html_esc($shift_ops)."&&name_file=".html_esc($name_file)."'";
		   //echo "window.location='ftp_bflush_SAP_cancel.php?uid=$uid&&buid=$ref'";
	       echo "</script>"; 
		   exit(); //quit the script
		
    }


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteRelease<?php echo html_esc($row["id"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">PPS Release</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
     <?php       
          //--------- pps detail ------------
	 
	   $query_pps_dtl = "SELECT * FROM pps_detail WHERE id = '".sql_esc($row["id"])."'";
	   $result_pps_dtl = mysqli_query($dbc,$query_pps_dtl);   
	   $data_pps_dtl = mysqli_fetch_array($result_pps_dtl);
	   
	   
	   ?>
                 
        <div class="content mt-12"><h3>Are you sure?</h3><br>
        <h5>Release Planned Order : <?php echo html_esc($data_pps_dtl["plan_no"]); ?></h5>
   
  <?php
  
            $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plant_code = $_GET["plant_code"];
			$work_center = $_GET["work_center"];
			$material_no = $_GET["material_no"];
			$shift_ops = $_GET["shift_ops"];
			$name_file = $_GET["name_file"];
			
			
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);

			 //convert 
			
			$query_convert = "SELECT * FROM work_center_detail as SR WHERE SR.id_work = '".sql_esc($_GET["work_center"])."'";
			$result_convert = mysqli_query($dbc,$query_convert); 
			$row_convert = mysqli_fetch_array($result_convert);
			
			$query_convert2 = "SELECT * FROM ftp_pps WHERE file_name = '".sql_esc($_GET["name_file"])."'";
			$result_convert2 = mysqli_query($dbc,$query_convert2); 
			$row_convert2 = mysqli_fetch_array($result_convert2);
			
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
                    $wheresql_01 = " AND (MR.date_plan >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 2. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (MR.date_plan <= '".sql_esc($date2_final)."')"; } 
					 	 
		 //3. Plant Code 
                if ($plant_code == "NULL"){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND MR.plant_code = '".sql_esc($plant_code)."'"; } 
					
          //4. Work Center
                if ($work_center == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND MR.work_center = '".sql_esc($work_center)."'"; }
   
	       //5. Material No.
                if ($material_no == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND MR.material_no = '".sql_esc($material_no)."'"; }  	
					
		 
		  //6. Shift
                if ($shift_ops == "NULL"){ 
                    $wheresql_06 = ""; }
                else {
					// $wheresql_06 = ""; }
					
                    $wheresql_06 = " AND ((MR.shift_pps1 = '".sql_esc($shift_ops)."') OR (MR.shift_pps2 = '".sql_esc($shift_ops)."')) "; }  		 				        
					
		 // 7. File name
                if ($name_file == "NULL" ){
                    $wheresql_07 = ""; }
                else {
                    $wheresql_07 = " AND MR.upload_id = '".sql_esc($row_convert2["upload_id"])."'"; }    
					
			
	$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05 .$wheresql_06 .$wheresql_07;		
	
	//********** END CONDITION **************
	
$queryu2 = "SELECT * FROM pps_detail AS MR WHERE MR.status_pps = '".sql_esc($rst_sta["status_desc"])."'".$where_sql;
$rs2 = mysqli_query($dbc,$queryu2);   //run the query.
$db_rs2 = mysqli_fetch_array($rs2);


 ?>

<div class="page">
<br>

    <form name="frmSearch" id="frmSearch" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" class="needs-validation"  novalidate>
    
       <input name="id" type="hidden" value="<?php echo html_esc($row["id"]); ?> "> 
       <input name="uid" type="hidden" value="<?php echo html_esc($row["upload_id"]); ?> ">    
       <input name="date1" type="hidden" value="<?php echo $date1_final; ?> "> 
       <input name="date2" type="hidden" value="<?php echo $date2_final; ?> "> 
       <input name="plant_code" type="hidden" value="<?php echo html_esc($plant_code); ?>">  
       <input name="work_center" type="hidden" value="<?php echo html_esc($work_center); ?>"> 
       <input name="material_no" type="hidden" value="<?php echo html_esc($material_no); ?>"> 
       <input name="shift_ops" type="hidden" value="<?php echo html_esc($shift_ops); ?>"> 
       <input name="name_file" type="hidden" value="<?php echo html_esc($name_file); ?>">  
  
      
     <div class="modal-footer pull-left">
     
      <input name="proc_btn" type="submit"  class="btn btn-success btn-sm" value="PROCEED" />
              
      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">CANCEL</button>
             </div> 

  </form>
                <!--  </div>--></div>
                  </div>
                  </div>
                  </div>
                  </div>
               
</body>
</html>