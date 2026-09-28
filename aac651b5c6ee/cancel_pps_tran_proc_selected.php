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
  if(isset($_POST["cancel_btn"])) 
  
   { // handle the form.

 
   $uid = $_POST["uid"];
   
 // echo $uid;
   
    //--------- pps detail ------------
	 
	   $query_pps = "SELECT * FROM pps_detail WHERE id = '".sql_esc($uid)."'";
	   $result_pps = mysqli_query($dbc,$query_pps);
	  
	  while($data_pps = mysqli_fetch_array($result_pps))
	  
	  {
		  
	  //---------update cancellation--------------------------
	 
	$query_cancel = "UPDATE pps_detail SET status_pps = '".sql_esc($rst_sta4["status_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW(), user_posting = '".sql_esc($username)."', date_posting = NOW() WHERE id = '".sql_esc($uid)."'";
	$result_cancel = mysqli_query($dbc,$query_cancel);
		  
		   //insert into table pps_detail_cancellation-------------
	
$query_data2 = "INSERT INTO pps_cancellation(id,ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,user_cancel,date_cancel,plan_category,id_factory_pps,rev_pps,seq_pps,man_hours,work_hours,plant_code,year_plan,back_no,kanban_no) VALUES('".sql_esc($data_pps["id"])."','".sql_esc($data_pps["ref_id"])."','".sql_esc($data_pps["plan_no"])."','".sql_esc($data_pps["upload_id"])."','".sql_esc($data_pps["model_code"])."','".sql_esc($data_pps["month_plan"])."','".sql_esc($data_pps["material_no"])."','".sql_esc($data_pps["qty_plan"])."','".sql_esc($data_pps["qty_actual"])."','".sql_esc($rst_sta4["status_desc"])."','".sql_esc($data_pps["comp_code"])."','".sql_esc($data_pps["work_center"])."','".sql_esc($data_pps["shift_pps1"])."','".sql_esc($data_pps["shift_pps2"])."','".sql_esc($data_pps["date_plan"])."','N','".sql_esc($data_pps["user_upload"])."','".sql_esc($data_pps["date_upload"])."','".sql_esc($data_pps["user_create"])."','".sql_esc($data_pps["date_create"])."','".sql_esc($data_pps["user_update"])."','".sql_esc($data_pps["date_update"])."','".sql_esc($data_pps["user_posting"])."','".sql_esc($data_pps["date_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($data_pps["plan_category"])."','".sql_esc($data_pps["id_factory_pps"])."','".sql_esc($data_pps["rev_pps"])."','".sql_esc($data_pps["seq_pps"])."','".sql_esc($data_pps["man_hours"])."','".sql_esc($data_pps["work_hours"])."','".sql_esc($data_pps["plant_code"])."','".sql_esc($data_pps["year_plan"])."','".sql_esc($data_pps["back_no"])."','".sql_esc($data_pps["kanban_no"])."')";
$result_data2 = mysqli_query($dbc,$query_data2);   

				  
		  
	  }
	  
 
 	 
	  if($result_cancel)
	 { 

		   echo "<script>";
		   echo "alert('Your transaction has been processed successfully');";
		   echo "window.location='display_pps_month_reprint2.php?date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&plan_category=".html_esc($plan_category)."&&material_no=".html_esc($material_no)."&&shift_ops=".html_esc($shift_ops)."'";
		   //echo "window.location='ftp_bflush_SAP_cancel.php?uid=$uid&&buid=$ref'";
	       echo "</script>"; 
		   exit(); //quit the script
		
    }


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteCancel<?php echo html_esc($row["id"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">PPS Deleted</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
        <div class="content mt-12">
   
  <?php
  
            $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plan_category = $_GET["plan_category"];
			$material_no = $_GET["material_no"];
			$shift_ops = $_GET["shift_ops"];
			
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);

					
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
                    $wheresql_01 = " AND (date_plan >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 2. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (date_plan <= '".sql_esc($date2_final)."')"; } 
					 	 
		 //3. Plan Category 
                if ($plan_category == "NULL"){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND plan_category = '".sql_esc($plan_category)."'"; } 
					
          //4. Part No.
                if ($material_no == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND material_no = '".sql_esc($material_no)."'"; }
   
			 
		  //5. Shift
                if ($shift_ops == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
					// $wheresql_06 = ""; }
					
                    $wheresql_05 = " AND ((shift_pps1 = '".sql_esc($shift_ops)."') OR (shift_pps2 = '".sql_esc($shift_ops)."')) "; }  		 				        
					
                                       
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;	
		
	
	//********** END CONDITION **************
	
$queryu2 = "SELECT * FROM pps_detail WHERE status_pps = '".sql_esc($rst_sta2["status_desc"])."'".$where_sql;
$rs2 = mysqli_query($dbc,$queryu2);   //run the query.
$db_rs2 = mysqli_fetch_array($rs2);


 ?>

    <?php       
          //--------- pps detail ------------
	 
	   $query_pps_dtl = "SELECT * FROM pps_detail WHERE id = '".sql_esc($row["id"])."'";
	   $result_pps_dtl = mysqli_query($dbc,$query_pps_dtl);   
	   $data_pps_dtl = mysqli_fetch_array($result_pps_dtl);
	   
	   
	   ?>

<br>

        <div class="content mt-12"><h3>Are you sure?</h3><br>
        <h5>Delete Planned Order : <?php echo html_esc($data_pps_dtl["plan_no"]); ?>?</h5>


    <form name="frmSearch" id="frmSearch" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" class="needs-validation"  novalidate>

    <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') as R FROM pps_detail WHERE status_pps = '".sql_esc($rst_sta2["status_desc"])."' AND id = '".sql_esc($row["id"])."' ".$where_sql." order by plan_no ASC";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   
   while($row2 = mysqli_fetch_array($result_display))
   {
		
	//shift	
		if($row2["shift_pps1"] != "")
	{
		$sta = "D/S";
		
	}elseif($row2["shift_pps2"] != "")
	 {
		$sta = "N/S";
	 }else{
		 
		$sta = " ";
	 }	
	
	 
      ?>
     
       
       <input name="uid" type="hidden" value="<?php echo html_esc($row["id"]); ?> ">    
       <input name="date1" type="hidden" value="<?php echo $date1_final; ?> "> 
       <input name="date2" type="hidden" value="<?php echo $date2_final; ?> "> 
       <input name="plan_category" type="hidden" value="<?php echo html_esc($plan_category); ?>">  
       <input name="material_no" type="hidden" value="<?php echo html_esc($material_no); ?>"> 
       <input name="shift_ops" type="hidden" value="<?php echo html_esc($shift_ops); ?>"> 
      
      <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  
      
     <div class="modal-footer pull-left">
      <input name="cancel_btn" type="submit"  class="btn btn-success btn-sm" value="YES" />
              
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