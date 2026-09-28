<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "canC_gra_tran_qcProc.php"; 
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
  if(isset($_POST["canC_GRAbtn"])) 
  
   { // handle the form.

 
   $uid6 = $_POST["uid6"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   
   //-------------------generate gra QC doc no.---------------
	
	 if($_POST["plant_code"] == '3100')
	{
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '8'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($_POST["plant_code"] == '3101')
	{
		
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '63'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 00000; 
	$dht_OK2 = "132";
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
	
    $ref6 = (($row_id2["start_ref"]).$dht_OK2.$date_run.($number2));
	  
	
	} // end if $result_id2

	
   
    //--------- GRA QC detail ------------
	 
	   $query_info5 = "SELECT * FROM gra_qc_detail WHERE doc_gra = '".sql_esc($uid6)."' AND (status_gra = '".sql_esc($rst_sta23["status_desc"])."')";
	   $result_info5 = mysqli_query($dbc,$query_info5);
	  
	  while($data_info5 = mysqli_fetch_array($result_info5))
	  
	  {
		  
	 // ---------update cancellation--------------------------
	 
	$query_cancelGR = "UPDATE gra_qc_detail SET status_gra = '".sql_esc($rst_sta4["status_desc"])."', user_cancel = '".sql_esc($username)."', date_cancel = NOW(), ref_doc_gra = '".sql_esc($ref6)."' WHERE doc_gra = '".sql_esc($uid6)."' AND (status_gra = '".sql_esc($rst_sta23["status_desc"])."')";
	$result_cancelGR = mysqli_query($dbc,$query_cancelGR);
	
	
	  
	   $query_infoa = "SELECT * FROM gra_qc_detail WHERE doc_gra = '".sql_esc($uid6)."' AND id_gra = '".sql_esc($data_info5["id_gra"])."' AND (status_gra = '".sql_esc($rst_sta4["status_desc"])."')";
	   $result_infoa = mysqli_query($dbc,$query_infoa);
	   $row_infoa = mysqli_fetch_array($result_infoa);
	   
	   
	  $query_data2a = "INSERT INTO gra_qc_detail_cancel(id,id_gra,doc_gra,id_scan_gra,scan_doc,item_no,material_no,material_desc,plan_no,doc_no,plant_code,sloc_from,vendor_no,qty_gra,uom_gra,posting_date,shift_day,model_code,material_type,stamp_ind,slip_no,user_create,date_create,user_generate_gra,date_generate_gra,ref_doc_gra,user_cancel,date_cancel,status_ftp,status_tran,status_gra,barcode_gr,gr_doc_no,remark_gra,doc_no_return,return_by,date_return,received_by,date_received,lorry_no,ic_driver,dlv_ord_no) VALUES('','".sql_esc($row_infoa["id_gra"])."','".sql_esc($row_infoa["doc_gra"])."','".sql_esc($row_infoa["id_scan_gra"])."','".sql_esc($row_infoa["scan_doc"])."','".sql_esc($row_infoa["item_no"])."','".sql_esc($row_infoa["material_no"])."','".sql_esc($row_infoa["material_desc"])."','".sql_esc($row_infoa["plan_no"])."','".sql_esc($row_infoa["doc_no"])."','".sql_esc($row_infoa["plant_code"])."','".sql_esc($row_infoa["sloc_from"])."','".sql_esc($row_infoa["vendor_no"])."','".sql_esc($row_infoa["qty_gra"])."','".sql_esc($row_infoa["uom_gra"])."','".sql_esc($row_infoa["posting_date"])."','".sql_esc($row_infoa["shift_day"])."','".sql_esc($row_infoa["model_code"])."','".sql_esc($row_infoa["material_type"])."','".sql_esc($row_infoa["stamp_ind"])."','".sql_esc($row_infoa["slip_no"])."','".sql_esc($row_infoa["user_create"])."','".sql_esc($row_infoa["date_create"])."','".sql_esc($row_infoa["user_generate_gra"])."','".sql_esc($row_infoa["date_generate_gra"])."','".sql_esc($ref6)."','".sql_esc($username)."',NOW(),'".sql_esc($row_infoa["status_ftp"])."','".sql_esc($row_infoa["status_tran"])."','".sql_esc($row_infoa["status_gra"])."','".sql_esc($row_infoa["barcode_gr"])."','".sql_esc($row_infoa["gr_doc_no"])."','".sql_esc($row_infoa["remark_gra"])."','".sql_esc($row_infoa["doc_no_return"])."','".sql_esc($row_infoa["return_by"])."','".sql_esc($row_infoa["date_return"])."','".sql_esc($row_infoa["received_by"])."','".sql_esc($row_infoa["date_received"])."','".sql_esc($row_infoa["lorry_no"])."','".sql_esc($row_infoa["ic_driver"])."','".sql_esc($row_infoa["dlv_ord_no"])."')";  
$result_data2a = mysqli_query($dbc,$query_data2a) or die (mysqli_error());  
	  
	
	  }
 	 
	/*  if($result_cancel)
	 { */
	 
		  //update count_max----------------------------------------
		 
		  if($_POST["plant_code"] == '3100')
		{
	  
		   $query_max_aA = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '8'";
		   $result_max_aA = mysqli_query($dbc,$query_max_aA);

	
		}elseif($_POST["plant_code"] == '3101')
		{
		   $query_max_bB = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '63'";
		   $result_max_bB = mysqli_query($dbc,$query_max_bB);
		   

		}
	 

		   echo "<script>";
		   echo "alert('Material Document $ref6 posted.');";
		   echo "window.location='canC_gra_tran_qcProc.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT'";
	       echo "</script>"; 
		   exit(); //quit the script
		
  
  


   }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteDisplay<?php echo $row["doc_gra"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display GRA</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
     <!--   <div class="content mt-12">-->
     
     <?php
	 
	 $query_bb = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T3 from gra_qc_detail WHERE doc_gra = '".sql_esc($row["doc_gra"])."' GROUP BY doc_gra";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 //----get vendor detail -----
	 
	 $query_vend = "SELECT * FROM vendor_detail WHERE vendor_code = '".sql_esc($data_bb["vendor_no"])."'";
	 $result_vend = mysqli_query($dbc,$query_vend); 
	 $data_vend = mysqli_fetch_array($result_vend);
	 
	 
	 ?>
          <form name="frmDisplay" id="frmDisplay" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" >  
        <table width="98%" border="0" cellspacing="2" cellpadding="0" class="table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="250" height="50"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<h5><font color="#999999"><b>GOODS RETURN ADVISE</b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>Plant :  </b><?php echo $row["plant_code"];   ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Document No. :  </b><?php echo $row["doc_gra"];   ?></div></td>
  </tr>
  <tr>
    <td><div align="left"><b>Vendor :  </b><?php echo $row["vendor_no"];   ?>: <?php echo $data_vend["vendor_name"]; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Date :  </b><?php echo $data_bb["T3"];   ?></div></td>  
  
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Shift :  </b><?php echo $row["shift_day"];   ?></div></td>
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
   
$query_display = "SELECT * FROM gra_qc_detail WHERE doc_gra = '".sql_esc($row["doc_gra"])."' AND (status_gra = '".sql_esc($rst_sta23["status_desc"])."') " .$where_sql." ORDER BY doc_gra ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   ?>
 
 <table width="98%" class="table-bordered">
 <thead bgcolor="#eeeeee">
  <tr>
     <th>No</th>
     <th>Part No.</th>
     <th>Part Name</th>
     <th>Model</th>
     <th>Quantity</th>
     <th>Unit</th>
     <th>Location</th>
     <th>GR Document No.</th>
     <th>Document No.</th> 
     <th>Remark</th>
  </tr>
  </thead>
  <tbody>
  <?php
    
   while($row2 = mysqli_fetch_array($result_display))
   {

  
  
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $row2["material_no"]; ?></td>
    <td><?php echo $row2["material_desc"]; ?></td>
    <td><?php echo $row2["model_code"]; ?></td>
    <td><?php echo intval($row2["qty_gra"]); ?></td>
    <td><?php echo $row2["uom_gra"]; ?></td>
    <td><?php echo $row2["sloc_from"]; ?></td>
    <td><?php echo $row2["gr_doc_no"]; ?></td>
    <td><?php echo $row2["doc_gra"]; ?></td>
    <td><?php echo $row2["remark_gra"]; ?></td>
  </tr>
  
 <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  </tbody>
</table>

     <div class="modal-footer pull-left">
     <!-- <input name="cancel_btn" type="submit"  class="btn btn-success btn-sm" value="BACK" />-->
       <input name="uid6" type="hidden" value="<?php echo $row["doc_gra"]; ?> ">    
       <input name="date1" type="hidden" value="<?php echo $_GET["date1"]; ?>"> 
       <input name="date2" type="hidden" value="<?php echo $_GET["date2"]; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
       
       <input name="canC_GRAbtn" type="submit"  class="btn btn-danger btn-sm" value="CANCEL" onClick="return confirm('Are you sure to cancel this transaction?');"/>
     </div> 
   
   
   </form>

                <!--  </div></div>-->
                  </div>
                  </div>
                  </div>
                  </div>
               
</body>
</html>