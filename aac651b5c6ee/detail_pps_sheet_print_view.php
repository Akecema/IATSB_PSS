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
                                <h5 class="modal-title" id="mediumModalLabel">PPS Details</h5>
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
                    $wheresql_01 = " AND (MR.date_plan >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 2. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (MR.date_plan <= '".sql_esc($date2_final)."')"; } 
					 	 
		 //3. Plan Category
                if ($plan_category == "NULL"){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND MR.plan_category = '".sql_esc($plan_category)."'"; } 
					
          //4. Part No.
                if ($material_no == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND MR.material_no = '".sql_esc($material_no)."'"; }
   
		 
		  //5. Shift
                if ($shift_ops == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
					// $wheresql_06 = ""; }
					
                    $wheresql_05 = " AND ((MR.shift_pps1 = '".sql_esc($shift_ops)."') OR (MR.shift_pps2 = '".sql_esc($shift_ops)."')) "; }  		 				        
					
		
			
	$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;		
	
	//********** END CONDITION **************
	
$queryu2 = "SELECT * FROM pps_detail AS MR WHERE MR.status_pps = '".sql_esc($rst_sta2["status_desc"])."'".$where_sql;
$rs2 = mysqli_query($dbc,$queryu2);   //run the query.
$db_rs2 = mysqli_fetch_array($rs2);


 ?>

<div class="page">
<br>
  <!--  <div class="page"> -->
 

      <form name="view_sheet" id="view_sheet" action="detail_pps_sheet_print_view.php?date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&plan_category=<?php echo $plan_category; ?>&&material_no=<?php echo $material_no; ?>&&shift_ops=<?php echo $shift_ops; ?>" method="post">
     <table class="table-bordered" style="width:1000px">
      <thead>
        <tr>
        <th>No.</th>
        <th>Model</th>
        <th>Back No.</th>
        <th>Part Number</th>
        <th>Part Name</th>
        <th>Planned Order No.</th>
        <th>Planned Date</th>
        <th>Line</th>
        <th>Shift</th>
        <th>Planned Quantity</th>
        </tr>
      </thead>
      <tbody>
    <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT *, DATE_FORMAT(MR.date_plan,'%d-%m-%Y') as R FROM pps_detail AS MR WHERE MR.status_pps = '".sql_esc($rst_sta2["status_desc"])."' AND MR.id = '".sql_esc($row["id"])."' ".$where_sql." order by MR.plan_no ASC";
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
	
	
	 //----model ---
  
 $query_Mod = "SELECT * FROM model_detail_tbl WHERE model_code = '".sql_esc($row2["model_code"])."' AND status_model = 'Y' ORDER BY id_model ASC";
 $result_Mod = mysqli_query($dbc,$query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  


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
        <td width="10%"><?php echo $row_mat["material_desc"]; ?></td>
        <td width="8%"><font color="#0000CC"><?php echo $row2["plan_no"]; ?></font></td>
        <td width="5%"><?php echo $row2["date_plan"]; ?></td>  
        <td width="10%"><?php echo $model_name; ?></td>
        <td width="8%"><?php echo $sta; ?></td>
        <td width="10%"><?php echo $row2["qty_plan"]; ?></td>
	 
      
    <!--   <input name="tid[]" type="hidden" value="<?php echo $row2["id"]; ?> ">   -->
       <input name="uid4" type="hidden" value="<?php echo $row2["upload_id"]; ?> ">    
       <input name="date1" type="hidden" value="<?php echo $date1_final; ?> "> 
       <input name="date2" type="hidden" value="<?php echo $date2_final; ?> "> 
       <input name="plan_category" type="hidden" value="<?php echo $plan_category; ?>">  
       <input name="material_no" type="hidden" value="<?php echo $material_no; ?>"> 
       <input name="shift_ops" type="hidden" value="<?php echo $shift_ops; ?>"> 
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