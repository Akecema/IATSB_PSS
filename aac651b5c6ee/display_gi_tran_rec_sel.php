<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "canC_gi_tran-recProc.php"; 
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
  if(isset($_POST["can_GIS2btn"])) 
  
   { // handle the form.

 
   $uid4 = $_POST["uid4"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
 
   //-------------------generate gra QC doc no.---------------
	
	
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '36'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "382";
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
	
    $ref4 = (($row_id2["start_ref"]).$dht_OK2.$date_run.($number2));
	  
	
	} // end if $result_id2

	
   
    //--------- Goods Issue Consumable detail ------------
	 
	   $query_info5 = "SELECT * FROM gis_rcv_detail WHERE doc_gis = '".sql_esc($uid4)."' AND status_gis = '".sql_esc($rst_sta27["status_desc"])."' ";
	   $result_info5 = mysqli_query($dbc,$query_info5);
	  
	  while($data_info5 = mysqli_fetch_array($result_info5))
	  
	  {
		  
	 // ---------update cancellation--------------------------
	 
	$query_cancelGR = "UPDATE gis_rcv_detail SET status_gis = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), ref_doc_gis = '".sql_esc($ref4)."' WHERE doc_gis = '".sql_esc($uid4)."' AND status_gis = '".sql_esc($rst_sta27["status_desc"])."'";
	$result_cancelGR = mysqli_query($dbc,$query_cancelGR);
	
	
	  
	   $query_infoBe = "SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM gis_rcv_detail WHERE doc_gis = '".sql_esc($uid4)."' AND id_gis = '".sql_esc($data_info5["id_gis"])."' AND status_gis = '".sql_esc($rst_sta4["status_desc"])."'";
	   $result_infoBe = mysqli_query($dbc,$query_infoBe);
	   $row_infoBe = mysqli_fetch_array($result_infoBe);
	   
	   
	//---------insert data at table gis_rcv_detail_cancel
		
		  $query_storeGI = "INSERT INTO gis_rcv_detail_cancel(id,id_gis,doc_gis,id_scan_gis,scan_doc,item_no,material_no, material_desc,plan_no,doc_no,plant_code,sloc_from,sloc_to,qty_gis,uom_gis,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_gis,date_generate_gis,ref_doc_gis,user_cancel,date_cancel,status_ftp,status_tran,status_gis,doc_no_return,return_by,date_return,received_by,date_received,dlv_ord_no,work_center,cost_center,SAP_ref_doc,SAP_ref_doc_can) VALUES('','".sql_esc($row_infoBe["id_gis"])."','".sql_esc($row_infoBe["doc_gis"])."','".sql_esc($row_infoBe["id_scan_gis"])."','".sql_esc($row_infoBe["scan_doc"])."','".sql_esc($row_infoBe["item_no"])."','".sql_esc($row_infoBe["material_no"])."','".sql_esc($row_infoBe["material_desc"])."','".sql_esc($row_infoBe["plan_no"])."','".sql_esc($row_infoBe["doc_no"])."','".sql_esc($row_infoBe["plant_code"])."','".sql_esc($row_infoBe["sloc_from"])."','".sql_esc($row_infoBe["sloc_to"])."','".sql_esc($row_infoBe["qty_gis"])."','".sql_esc($row_infoBe["uom_gis"])."','".sql_esc($row_infoBe["posting_date"])."','".sql_esc($row_infoBe["shift_day"])."','".sql_esc($row_infoBe["model_code"])."','".sql_esc($row_infoBe["material_type"])."','".sql_esc($row_infoBe["stamp_ind"])."','".sql_esc($row_infoBe["slip_no"])."','".sql_esc($row_infoBe["user_create"])."','".sql_esc($row_infoBe["date_create"])."','".sql_esc($row_infoBe["user_generate_gis"])."','".sql_esc($row_infoBe["date_generate_gis"])."','".sql_esc($row_infoBe["ref_doc_gis"])."','".sql_esc($row_infoBe["user_cancel"])."','".sql_esc($row_infoBe["date_cancel"])."','".sql_esc($row_infoBe["status_ftp"])."','".sql_esc($row_infoBe["status_tran"])."','".sql_esc($row_infoBe["status_gis"])."','".sql_esc($row_infoBe["doc_no_return"])."','".sql_esc($row_infoBe["return_by"])."','".sql_esc($row_infoBe["date_return"])."','".sql_esc($row_infoBe["received_by"])."','".sql_esc($row_infoBe["date_received"])."','".sql_esc($row_infoBe["dlv_ord_no"])."','".sql_esc($row_infoBe["work_center"])."','".sql_esc($row_infoBe["cost_center"])."','".sql_esc($row_infoBe["SAP_ref_doc"])."','".sql_esc($row_infoBe["SAP_ref_doc_can"])."')";          
		  $rst_storeGI = mysqli_query($dbc,$query_storeGI) or die (mysqli_error());
	  
	
	  $filen_rcv = "GI".$ref4; 
		   
		   //-----prepared by------
		 $query_prepw = "SELECT * FROM user_detail WHERE username = '".sql_esc($row_infoBe["user_cancel"])."'";
		 $result_prepw = mysqli_query($dbc,$query_prepw);
		 $data_prepw = mysqli_fetch_array($result_prepw);
		 
	
	//Plant;Document No. Cancellation; Document No.;Posting Date;Posting Date Year;Movement Type;Recipient 
   // 2300; 2300382070320001; 2300381070320001;29122019;2019;202;IKHRAM 
        
		// ---get year

		 $tahun_plan = substr($row_infoBe["posting_date"],0,4);
		 

$data_rcv .= $row_infoBe["plant_code"].";".$row_infoBe["ref_doc_gis"].";".$row_infoBe["doc_gis"].";".$row_infoBe["JD"].";".$tahun_plan.";202;".$row_infoBe["user_cancel"]."\r\n";
   

     //----------update table ftp_tp_gis_rcv_cancel------------
  $query_rcv_ftp_info = "INSERT INTO ftp_tp_gis_rcv_cancel(id,file_name,ref_doc_gis,doc_gis,id_gis,plan_no,material_no,material_desc,qty_ftp,uom, plant,shift_day,slip_no,mvt_type,status_ftp,posting_date,posting_time,sloc_from,sloc_to,prepared_by,user_create,date_create,work_center,cost_center) VALUES('','".sql_esc($filen_rcv)."','".sql_esc($ref4)."','".sql_esc($row_infoBe["doc_gis"])."','".sql_esc($row_infoBe["id_gis"])."','".sql_esc($row_infoBe["plan_no"])."','".sql_esc($row_infoBe["material_no"])."','".sql_esc($row_infoBe["material_desc"])."','".sql_esc($row_infoBe["qty_gis"])."','".sql_esc($row_infoBe["uom_gis"])."','".sql_esc($row_infoBe["plant_code"])."','".sql_esc($row_infoBe["shift_day"])."','".sql_esc($row_infoBe["slip_no"])."','202','Y','".sql_esc($row_infoBe["posting_date"])."',NOW(),'".sql_esc($row_infoBe["sloc_from"])."','".sql_esc($row_infoBe["sloc_to"])."','".sql_esc($data_prep["user_fullname"])."','".sql_esc($username)."',NOW(),'".sql_esc($row_infoBe["work_center"])."','".sql_esc($row_infoBe["cost_center"])."')"; 
     $rst_rcv_ftp_info = mysqli_query($dbc,$query_rcv_ftp_info);
	 
		  
	
	  }
	  
	    $file_rcv = "../FromPortal2/GI/".$filen_rcv.".csv";
		file_put_contents($file_rcv,$data_rcv);
 	 
	/*  if($result_cancel)
	 { */
	 
		  //update count_max----------------------------------------
		
	  
		   $query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '36'";
		   $result_max_aA = mysqli_query($dbc,$query_max_aA);
	 
   

		   echo "<script>";
		   echo "alert('Material Document $ref4 posted.');";
		   echo "window.location='canC_gi_tran-recProc.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT'";
	       echo "</script>"; 
		   exit(); //quit the script
		
  


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteDisplayGIS<?php echo $row["doc_gis"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display GI Consumable</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
     <!--   <div class="content mt-12">-->
     
     <?php
	 
	 $query_bb = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T3 from gis_rcv_detail WHERE doc_gis = '".sql_esc($row["doc_gis"])."' GROUP BY doc_gis";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);	 
	 
	 //---work center----
	 $query_line = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($data_bb["work_center"])."'";
	 $rs_line = mysqli_query($dbc,$query_line);   //run the query.
     $data_line = mysqli_fetch_array($rs_line);	 
	 
	 ?>
    <form name="frmDisplay" id="frmDisplay" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" >       
  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="250" height="50"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<h5><font color="#999999"><b>GI CONSUMABLE</b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>Plant :  </b><?php echo $row["plant_code"];   ?></div></td>
    <td>&nbsp;</td> 
    <td><div align="left"><b>Document No. :  </b><?php echo $row["doc_gis"];   ?></div></td>
   <tr> 
    <td><div align="left"><b>Line :  </b><?php echo $row["work_center"];   ?> - <?php echo $data_line["wc_desc"]; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Date :  </b><?php echo $data_bb["T3"];   ?></div></td>
  </tr>
  <tr>
    <td><div align="left"><b>Cost Center :  </b><?php echo $data_line["cost_center"];   ?> - <?php echo $data_line["cc_desc"];   ?></div></td>
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
   
$query_display = "SELECT * FROM gis_rcv_detail WHERE doc_gis = '".sql_esc($row["doc_gis"])."' AND status_gis = '".sql_esc($rst_sta27["status_desc"])."'" .$where_sql." ORDER BY doc_gis ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
  
   ?>
 
 <table width="98%" class="table-bordered">
 <thead bgcolor="#eeeeee">
  <tr>
     <th>No</th>
     <th>Part No.</th>
     <th>Part Name</th>
     <th>Quantity</th>
     <th>Unit</th>
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
  
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $row2["material_no"]; ?></td>
    <td><?php echo $row2["material_desc"]; ?></td>
    <td><?php echo intval($row2["qty_gis"]); ?></td>
    <td><?php echo $row2["uom_gis"]; ?></td>
  </tr>
  
 <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>

     <div class="modal-footer pull-left">
 
       <input name="uid4" type="hidden" value="<?php echo $row["doc_gis"]; ?> ">    
       <input name="date1" type="hidden" value="<?php echo $_GET["date1"]; ?>"> 
       <input name="date2" type="hidden" value="<?php echo $_GET["date2"]; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
  
       <input name="can_GIS2btn" type="submit"  class="btn btn-danger btn-sm" value="CANCEL" onClick="return confirm('Are you sure to cancel this transaction?');"/>
     </div> 

  </form>
                <!--  </div></div>-->
                  </div>
                  </div>
                  </div>
                  </div>
               
</body>
</html>