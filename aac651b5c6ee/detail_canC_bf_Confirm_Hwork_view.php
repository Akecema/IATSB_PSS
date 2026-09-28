<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	//$url = "detail_pps_month_reprint.php"; 
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
   
  <!--  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>-->
      <script language="javascript">
	  $(document).ready(function() {
			$('#example').DataTable( {
				"scrollX": true
			} );
		} );
	  </script>

 
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
/* @media print{
  body{  margin-top: -1.8cm;  font-family: Arial, Helvetica, sans-serif; font-size:12px; }
  #ad{ display:none;}
  #leftbar{ display:none;}
  #contentarea{ width:100%;}
  .header, .hide { visibility: hidden }
  .tfoot { display: table-footer-group; }
  @page {size: landscape}
 /* tr.page-break  { display: block; page-break-before: always; }  */
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

<style>
<!--modal width-->
.custom { 
	width: 1200px !important;
} 
   
</style>
 

  </head>
  <body class="app sidebar-mini">
 
  <div class="modal fade printable autoprint" id="myNoteView<?php echo $row["id"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content custom">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Cancellation Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
        <div class="content mt-12">
   
  <?php
  
            
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
        	$trans_opt = $_GET["trans_opt"]; 
			$plant_code = $_GET["plant_code"]; 
			$work_center = $_GET["work_center"];
			$material_no = $_GET["material_no"]; 
		
			
		 $where_sql = '';
				 
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 $ddF2 = substr($_GET["date2"],0,2);
				 $mmF2 = substr($_GET["date2"],3,2);
				 $yyF2 = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyF2.'-'.$mmF2.'-'.$ddF2);
				 
								 		
		
								
	       //1. Plant Code
                if (($plant_code == "") || ($plant_code == "NULL")){ 
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND plant_code = '".sql_esc($plant_code)."'"; }  	
					
		   // 2. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (date_posting >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //3. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
					$wheresql_03 = " AND (date_posting <= '".sql_esc($date2_final)."')"; }
					
					
		  //4. Work Center
                if ($work_center == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND work_center = '".sql_esc($work_center)."'"; }
   
	       //5. Part Number
                if ($material_no == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND material_no = '".sql_esc($material_no)."'"; }  	
					
		
	                                        
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;
						
	
	//********** END CONDITION **************
	
	
$queryu2 = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as R FROM pps_detail_trn_fg_hwork_confirm WHERE (status_pps = '".sql_esc($rst_sta7["status_desc"])."' OR status_pps = '".sql_esc($rst_sta14["status_desc"])."')" .$where_sql." ORDER BY bflush_no ASC ";
$rs2 = mysqli_query($dbc,$queryu2);   //run the query.
$db_rs2 = mysqli_fetch_array($rs2);


 ?>

<div class="page">
<br>
  <!--  <div class="page"> -->
 

      <form name="view_sheet" id="view_sheet" action="detail_canC_bf_Confirm_Hwork_view.php?plant_code=<?php echo $plant_code; ?>&&trans_opt=<?php echo $trans_opt; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>&&material_no=<?php echo $material_no; ?>" method="post">
     <table class="table-bordered" style="width:1000px">
      <thead>
        <tr bgcolor="#eeeeee">
        <th>No.</th>
        <th>Model</th>
        <th>Back No.</th>
        <th>Part Number</th>
        <th>BF Doc. No.</th>
        <th>Handwork Doc. No.</th>
        <th>Planned Order No.</th>
        <th>Posting Date</th>
        <th>Posting Time</th>
        <th>Line</th>
        <th>Shift</th>
        <th>Quantity</th>
        <th>Status</th>
        </tr>
      </thead>
      <tbody>
    <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT *, DATE_FORMAT(date_posting,'%d-%m-%Y') as RT FROM pps_detail_trn_fg_hwork_confirm WHERE  id = '".sql_esc($row["id"])."' AND (status_pps = '".sql_esc($rst_sta7["status_desc"])."' OR status_pps = '".sql_esc($rst_sta14["status_desc"])."')" .$where_sql." ORDER BY bflush_no ASC "; 
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   
   while($row2 = mysqli_fetch_array($result_display))
   {
		
	  //-----shift-----
	   
	   if($row2["shift_posting"] == "D/S")
	   {
		   $shift_dsA = "Day";
	   }elseif($row2["shift_posting"] == "N/S")
	   {
		 $shift_dsA = "Night";
	   }else{
		   
		   $shift_dsA = "NA"; 
	   }
	   
	   
	    //------quantity------
	   
	
	if($row2["status_butn"] == "OK")
	{
		$qty_output = $row2["qty_OK"];
		
	}elseif($row2["status_butn"] == "NG")
	{
	    $qty_output = $row2["qty_NG"];
	
	}elseif($row2["status_butn"] == "REWORK")
	{
	    $qty_output = $row2["qty_REWORK"];
	}else{
	    // $qty_output = "";
	}
	
	
	 //----model ---
  
 $query_Mod = "SELECT * FROM model_detail_tbl WHERE model_code = '".sql_esc($row2["model_code"])."' AND status_model = 'Y' ORDER BY id_model ASC";
 $result_Mod = mysqli_query($dbc,$query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  
 
 
  //----line ---
  
 $query_Mod2A = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($row2["work_center"])."' AND status_wc = 'Y' ORDER BY id ASC";
 $result_Mod2A = mysqli_query($dbc,$query_Mod2A);
 $row_Mod2A = mysqli_fetch_array($result_Mod2A);  
 
  if($row_Mod2["wc_desc2"] == "")
  {
	  $model_name2A = $row_Mod2A["id_work"];
  }else{
	  
	 $model_name2A = $row_Mod2A["wc_desc2"]; 
  }


	//----table material info ----------
	
		$query_mat = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($row2["material_no"])."' AND status_BOM = 'Y'";
	    $result_mat = mysqli_query($dbc,$query_mat);
        $row_mat = mysqli_fetch_array($result_mat); 
	 
      ?>
       <tr>
        <td width="2%"><?php echo $no; ?></td>
        <td width="3%"><?php echo $row_Mod["model_desc"]; ?></td>
        <td width="3%"><?php echo $row2["back_no"]; ?></td>
        <td width="10%"><?php echo $row2["material_no"]; ?></td>
        <td width="10%"><?php echo $row2["bflush_no"]; ?></td>
        <td width="80"><?php echo $row["bflush_hwork"]; ?></td>
        <td width="8%"><font color="#0000CC"><?php echo $row2["plan_no"]; ?></font></td>
        <td width="100"><?php echo $row2["RT"]; ?></td> 
        <td width="100"><?php echo $row2["time_posting"]; ?></td>   
        <td width="10%"><?php echo $model_name2A; ?></td>
        <td width="80"><?php echo $shift_dsA; ?></td>
        <td width="100"><?php echo intval($qty_output); ?></td>
  	    <td width="100"><?php echo $row2["status_butn"]; ?></td>         
                 
     
    <!--   <input name="tid[]" type="hidden" value="<?php echo $row2["id"]; ?> ">   -->
       <input name="uid4" type="hidden" value="<?php echo $row2["id"]; ?> ">    
       <input name="date1" type="hidden" value="<?php echo $date1_final; ?> "> 
       <input name="date2" type="hidden" value="<?php echo $date2_final; ?> "> 
       <input name="work_center" type="hidden" value="<?php echo $work_center; ?>">  
       <input name="material_no" type="hidden" value="<?php echo $material_no; ?>"> 
       <input name="trans_opt" type="hidden" value="<?php echo $trans_opt; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>"> 
      </tr> 
      <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
        </tbody>
      </table>
      
   
     <div class="modal-footer pull-left">
    
     <input type="hidden" value="<?php echo $row["id"]; ?>"/>
              
             <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">BACK</button>
            </div> 
   
  </form>
                <!--  </div>--></div>
                  </div>
                  </div>
                  </div>
                  </div>
 
             
</body>
</html>