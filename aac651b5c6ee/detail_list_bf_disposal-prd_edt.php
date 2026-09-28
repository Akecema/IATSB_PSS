<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "detail_list_bf_disposal-prd.php"; 
	require_once('tcpdf_barcodes_2d.php');

	
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



//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc,$sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);

//CR status (Pending Approval COO)
$sta25 = "SELECT * from request_status WHERE status_id = '25'";
$sta_res25 = mysqli_query($dbc,$sta25);
$rst_sta25 = mysqli_fetch_array($sta_res25);

//CR status (Pending Approval Exec. QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

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
    <link rel="shortcut icon" href="../images/favicon.ico">
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
<style >
.modlDisplay
{
	width : 1600px;	
}

</style>
  </head>
  <body class="app sidebar-mini">
  <?php
 //-------------- click button "SAVE"----------------

 if(isset($_POST["edt_btn"])) 
  { // handle the form.

 
    $uid2 = $_POST["uid2"];
    $tid = $_POST["tid"];
    $remarks = $_POST["remarks"];
	$dateF = $_POST["date1"];
	$dateT = $_POST["date2"];
    $plant_code = $_POST["plant_code"]; 
	$work_center = $_POST["work_center"];
  
    $how_many = count($tid); 
 
   // echo $how_many;
   
   for ($i=0; $i<$how_many; $i++) { 
   
  /* echo $uid2;  echo "id"; 
   echo $remarks[$i]; echo "<br>";*/
   
   
   
    
		 
	 ///---------------update disposal_detail_prd_all-----------------
	 
	 $qty_update_m = "UPDATE disposal_detail_prd_all SET remarks = '".sql_esc($remarks[$i])."', user_update = '".sql_esc($username)."', date_update = NOW() WHERE id = '".sql_esc($tid[$i])."'";
	  $rst_qty_update_m = mysqli_query($dbc,$qty_update_m);  
	 
	 
   
   } // end for loop
    

	   echo "<script>";
	   echo "alert('Your transaction has been processed successfully');";
	   echo "window.location='detail_list_bf_disposal-prdProc2.php?date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&plant_code=".html_esc($plant_code)."&&work_center=".html_esc($work_center)."'";
	   echo "</script>"; 
	   exit(); //quit the script



 }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteEdit<?php echo html_esc($row["doc_dis"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content modlDisplay">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit New Disposal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
        <div class="content mt-12">
   
  <?php
  
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
                    $wheresql_01 = " AND plant_cd = '".sql_esc($plant_code)."'"; }  	
					
		   // 2. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (date_disposal >= '".sql_esc($date1_final)."')"; }      
                                                
					
          //3. DateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_03 = ""; }
                else {
					$wheresql_03 = " AND (date_disposal <= '".sql_esc($date2_final)."')"; }
  
			                                        			
		  //4. Work Center
                if ($work_center == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND work_center = '".sql_esc($work_center)."'"; }
					
			                                        			
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04;
	
	//********** END CONDITION **************

	
$queryu2 = "SELECT *, DATE_FORMAT(date_disposal,'%d-%m-%Y') as R FROM disposal_detail_prd_all WHERE (status_disposal = '".sql_esc($rst_sta15["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta32["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta34["status_desc"])."')" .$where_sql." ORDER BY doc_dis ASC ";
$rs2 = mysqli_query($dbc,$queryu2);   //run the query.
$db_rs2 = mysqli_fetch_array($rs2);


 ?>

<div class="page">
<br>
  <!--  <div class="page"> -->
 


      <form name="edt_sheet" id="edt_sheet" action="detail_list_bf_disposal-prd_edt.php?date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&plant_code=<?php echo html_esc($plant_code); ?>&&work_center=<?php echo html_esc($work_center); ?>" method="post">
      <table class="table-bordered" style="width:150%">
      <thead>
        <tr>
        <th>No.</th>       
        <th>Date</th>
        <th>Model</th>
        <th>Part Number/Part Name</th>
        <th>Plant</th>
        <th>Quantity</th>
        <th>UoM</th>
        <th>From Location</th>
        <th>Cost Center</th>
        <th>Process/Section</th>
        <th>Type of Reject</th>
        <th>Defectives</th>
        <th>Reason for Rejection</th>
        <th>Remarks</th>
        </tr>
      </thead>
      <tbody>
    <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT *, DATE_FORMAT(date_disposal,'%d-%m-%Y') as R FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($row["doc_dis"])."' AND (status_disposal = '".sql_esc($rst_sta15["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta32["status_desc"])."' OR status_disposal = '".sql_esc($rst_sta34["status_desc"])."')".$where_sql." ORDER BY doc_dis ASC";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   
   while($row2 = mysqli_fetch_array($result_display))
   {
	
	//------- quantity	
	
	if($row2["qty_NG"] != "0.000")
	{
		$qty_new = $row2["qty_NG"];
		
	}elseif($row2["qty_qc"] != "0.000")
	{
		$qty_new = $row2["qty_qc"];
	}else{
		
		
	}
	
	
	
	
	
	//----get process of reject -----
  
     $query_proc = new PreparedSql("SELECT * FROM proc_reject_detail_prd WHERE id_proc = ?", [$row2["proc_reject"]]);
	 $rst_proc = db_query($dbc, $query_proc);
     $row_proc = mysqli_fetch_array($rst_proc);
	
	 //---type of reject
	 $query_type = new PreparedSql("SELECT * FROM type_reject_detail_prd WHERE id_type = ? AND status_type = 'Y' ORDER BY id_type ASC", [$row2["type_reject"]]);
	 $result_type = db_query($dbc, $query_type);
	 $row_type = mysqli_fetch_array($result_type); 
	 
	  //---defect
	 $query_defect = new PreparedSql("SELECT * FROM type_defect_detail_prd WHERE id_defect = ? AND status_defect = 'Y' ORDER BY id_defect ASC", [$row2["type_defect"]]);
	 $result_defect = db_query($dbc, $query_defect);
	 $row_defect = mysqli_fetch_array($result_defect);   

	  //----model ---
  
 $query_Mod = new PreparedSql("SELECT * FROM work_center_detail WHERE id_work = ? AND status_wc = 'Y' ORDER BY id ASC", [$row2["model_code"]]);
 $result_Mod = db_query($dbc, $query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  
 
  if($row_Mod["wc_desc2"] == "")
  {
	  $model_name = $row_Mod["id_work"];
  }else{
	  
	 $model_name = $row_Mod["wc_desc2"]; 
  }
      ?>
       <tr>
        <td width="30"><?php echo $no; ?></td>
        <td width="100"><?php echo html_esc($row2["R"]); ?> </td>
        <td width="80"><?php echo  $model_name; ?></td>
        <td width="250"><?php echo html_esc($row2["material_no"]); ?></td>
        <td width="100"><font color="#0000CC"><?php echo html_esc($row2["plant_cd"]); ?></font></td>
        <td width="60">
         <?php if( $row2["UOM_unit"] == 'KG'){  ?><input name="qty_disposal" type="text" value="<?php echo $qty_new; ?>" class="form-control" disabled >  </td>
   <?php   }else{  ?>   
        <input name="qty_disposal" type="text" value="<?php echo (intval($qty_new)); ?>" class="form-control" disabled ><?php } ?>    </td>
        <td width="80"><?php echo  html_esc($row2["UOM_unit"]); ?></td>
        <td width="80"><?php echo  html_esc($row2["ploc_prod_reject"]); ?></td>
        <td width="80"><?php echo  html_esc($row2["cost_center"]); ?></td>
        <td width="100"><?php echo html_esc($row_proc["proc_desc"]); ?></td>
        <td width="100"><?php echo html_esc($row_type["type_desc"]); ?></td>
        <td width="100"><?php echo html_esc($row_defect["defect_desc"]); ?></td>
        <td width="100"><?php echo html_esc($row2["reason_reject"]); ?></td>
        <td width="300">              
               <textarea name="remarks[]" class="form-control-range" id="exampleFormControlTextarea1" rows="5" cols="100"><?php  echo html_esc($row2["remarks"]);  ?></textarea>
               <input name="tid[]" type="hidden" value="<?php echo html_esc($row2["id"]); ?>">
             
        </td>
     
       <input name="uid2" type="hidden" value="<?php echo html_esc($row["doc_dis"]); ?> ">    
       <input name="date1" type="hidden" value="<?php echo html_esc($_GET["date1"]); ?> "> 
       <input name="date2" type="hidden" value="<?php echo html_esc($_GET["date2"]) ?> "> 
       <input name="plant_code" type="hidden" value="<?php echo html_esc($plant_code); ?>">  
       <input name="work_center" type="hidden" value="<?php echo html_esc($work_center); ?>"> 
   
      </tr> 
      <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
        </tbody>
      </table>
      
   
     <div class="modal-footer pull-left">
     <input type="submit" value="SAVE" name="edt_btn" class="btn btn-success btn-sm" >
             
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