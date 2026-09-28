<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "canC_coo_disposal4-prdProc2.php"; 
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
  if(isset($_POST["can_DISbtn"])) 
  
   { // handle the form.

 
   $uid4 = $_POST["uid4"];
   $plant_code = $_POST["plant_code"];
   $dateF = $_POST["date1"];
   $dateT = $_POST["date2"];
   
   
   // echo $uid3;
	
	$sta_out = substr($uid4,4,3);	
	//echo $sta_out; 
	
	
  if($sta_out == "311")
  {
	  
	 //------generate Material Document No. Cancellation for BF NG Generate.---------------------------------
				
				 if($_POST["plant_code"] == '3100')
				{
				
				 $query_id21 = "SELECT * FROM run_count_itsb WHERE uid = '22'";
				 $result_id21 = mysqli_query($dbc,$query_id21);
				
				}elseif($_POST["plant_code"] == '3101')
				{
					
				 $query_id21 = "SELECT * FROM run_count_itsb WHERE uid = '73'";
				 $result_id21 = mysqli_query($dbc,$query_id21);
					
				}
				
				if ($result_id21) 
			{
				$nrows21 = mysqli_num_rows($result_id21);
				$row_id21 = mysqli_fetch_array($result_id21);
				
				$dht21 = 00000; 
				$dht_OK21 = "312";
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
     
	  
	  
	  
     }elseif($sta_out == "321")
	  {
		  
		  //------generate Material Document No. Cancellation for Disposal Pending NG Generate.---------------------------------
				
				 if($_POST["plant_code"] == '3100')
				{
				
				 $query_id22 = "SELECT * FROM run_count_itsb WHERE uid = '24'";
				 $result_id22 = mysqli_query($dbc,$query_id22);
				
				}elseif($_POST["plant_code"] == '3101')
				{
					
				 $query_id22 = "SELECT * FROM run_count_itsb WHERE uid = '75'";
				 $result_id22 = mysqli_query($dbc,$query_id22);
					
				}
				
				if ($result_id22) 
			{
				$nrows22 = mysqli_num_rows($result_id22);
				$row_id22 = mysqli_fetch_array($result_id22);
				
				$dht22 = 00000; 
				$dht_OK22 = "322";
				$dg22 = 0;
			
				if($row_id22["count_max"] <= 0)
				{ 
			   
					$lastID22 = ($row_id22["count_max"] + 1);
					$dg22 = ($dht22 + ($lastID22));
			   }
			   else
			   {
				  $lastID22 = ($row_id22["count_max"] + 1);
				  $dg22 =  $lastID22;
				
				}
				$number22 = $dg22; // Length of running no
				$number22 = sprintf('%03d', $number22);  
				
				$ref22 = (($row_id22["start_ref"]).$dht_OK22.$date_run.($number22));
				
				} // end if $result_id2	
   
	  }elseif($sta_out == "331")
	  {
		  
		    //------generate Material Document No. Cancellation for Disposal Hnadwork NG Generate.---------------------------------
				
								
				 $query_id23 = "SELECT * FROM run_count_itsb WHERE uid = '26'";
				 $result_id23 = mysqli_query($dbc,$query_id23);
				
				
				if ($result_id23) 
			{
				$nrows23 = mysqli_num_rows($result_id23);
				$row_id23 = mysqli_fetch_array($result_id23);
				
				$dht23 = 00000; 
				$dht_OK23 = "332";
				$dg23 = 0;
			
				if($row_id23["count_max"] <= 0)
				{ 
			   
					$lastID23 = ($row_id23["count_max"] + 1);
					$dg23 = ($dht23 + ($lastID23));
			   }
			   else
			   {
				  $lastID23 = ($row_id23["count_max"] + 1);
				  $dg23 =  $lastID23;
				
				}
				$number23 = $dg23; // Length of running no
				$number23 = sprintf('%03d', $number23);  
				
				$ref23 = (($row_id23["start_ref"]).$dht_OK23.$date_run.($number23));
				
				} // end if $result_id2	
   
	  }elseif($sta_out == "341")
	  {
		  
	 //------generate Material Document No. Cancellation for Disposal Rework NG Generate.---------------------------------
				
				if($_POST["plant_code"] == '3100')
				{
				
				 $query_id24 = "SELECT * FROM run_count_itsb WHERE uid = '28'";
				 $result_id24 = mysqli_query($dbc,$query_id24);
				
				}elseif($_POST["plant_code"] == '3101')
				{
					
				 $query_id24 = "SELECT * FROM run_count_itsb WHERE uid = '77'";
				 $result_id24 = mysqli_query($dbc,$query_id24);
					
				}
				
				
				if ($result_id24) 
			{
				$nrows24 = mysqli_num_rows($result_id24);
				$row_id24 = mysqli_fetch_array($result_id24);
				
				$dht24 = 00000; 
				$dht_OK24 = "342";
				$dg24 = 0;
			
				if($row_id24["count_max"] <= 0)
				{ 
			   
					$lastID24 = ($row_id24["count_max"] + 1);
					$dg24 = ($dht24 + ($lastID24));
			   }
			   else
			   {
				  $lastID24 = ($row_id24["count_max"] + 1);
				  $dg24 =  $lastID24;
				
				}
				$number24 = $dg24; // Length of running no
				$number24 = sprintf('%03d', $number24);  
				
				$ref24 = (($row_id24["start_ref"]).$dht_OK24.$date_run.($number24));
				
				} // end if $result_id2	
   
    }elseif($sta_out == "351")
	  {		  
		  //------generate Material Document No. Cancellation for CR(component reject) Generate.---------------------------------
				
				 if($_POST["plant_code"] == '3100')
				{
				
				 $query_id25 = "SELECT * FROM run_count_itsb WHERE uid = '30'";
				 $result_id25 = mysqli_query($dbc,$query_id25);
				
				}elseif($_POST["plant_code"] == '3101')
				{
					
				 $query_id25 = "SELECT * FROM run_count_itsb WHERE uid = '79'";
				 $result_id25 = mysqli_query($dbc,$query_id25);
					
				}
				
				if ($result_id25) 
			{
				$nrows25 = mysqli_num_rows($result_id25);
				$row_id25 = mysqli_fetch_array($result_id25);
				
				$dht25 = 00000; 
				$dht_OK25 = "352";
				$dg25 = 0;
			
				if($row_id25["count_max"] <= 0)
				{ 
			   
					$lastID25 = ($row_id25["count_max"] + 1);
					$dg25 = ($dht25 + ($lastID25));
			   }
			   else
			   {
				  $lastID25 = ($row_id25["count_max"] + 1);
				  $dg25 =  $lastID25;
				
				}
				$number25 = $dg25; // Length of running no
				$number25 = sprintf('%03d', $number25);  
				
				$ref25 = (($row_id25["start_ref"]).$dht_OK25.$date_run.($number25));
				
				} // end if $result_id2	
				
				
				
	  }
	
		
   
    //--------- Disposal Production all detail ------------
	 
	   $query_info5 = "SELECT * FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid4)."' AND status_disposal = '".sql_esc($rst_sta3["status_desc"])."'";
	   $result_info5 = mysqli_query($dbc,$query_info5);
	  
	  while($data_info5 = mysqli_fetch_array($result_info5))
	  
	  {
		  
		 include "cancel_disposal-hqc_actProc.php";
		 
	  }//end while loop
	
	
  if($sta_out == "311")
  {
   
   $doc_canC = $ref21;

   }elseif($sta_out == "321")
  {
   
   $doc_canC = $ref22;
	  	  
  }elseif($sta_out == "331")
  {
	 
	$doc_canC = $ref23; 
	 
  }elseif($sta_out == "341")
  {
	 
	$doc_canC = $ref24; 
	 
  }elseif($sta_out == "351")
  {
	 
	$doc_canC = $ref25; 
	 
  }else{
	  
  }  
	  
  
  if($sta_out != "311")
  {
	   //-------------sent ftp mvt_type 552 to SAP --------
	
	$qry_tftp = mysqli_query($dbc,"SELECT *, DATE_FORMAT(date_cancel,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid4)."' AND status_disposal = '".sql_esc($rst_sta4["status_desc"])."'");

$data = "";
while($row_tftp = mysqli_fetch_array($qry_tftp)) {
	
	//echo $row_tftp["id"];
	
	
		if($row_tftp["qty_NG"] != "0.000")
	{
		$qty_nw = $row_tftp["qty_NG"];
		
	}elseif($row_tftp["qty_qc"] != "0.000")
	{
		$qty_nw = $row_tftp["qty_qc"];
	}else{
		
		
	}

   $qty_nw2 = (intval($qty_nw));
   
   //-----Recipient ------
    $query_recipt = "SELECT * FROM user_detail WHERE username = '".sql_esc($row_tftp["user_cancel"])."'";
	$result_recipt = mysqli_query($dbc,$query_recipt);
	$row_recipt = mysqli_fetch_array($result_recipt);
	
	//----yrs posting -----
	
	 $tahun_plan = substr($row_tftp["date_cancel"],0,4);
   
	
  //-----FINISH GOODS (2300)---------
  
  // disposal_no_ref
 // Plant;Disposal Cancel Doc No.;Disposal Doc No.;Posting Date;yr_posting;Movemwnt Type; receiptt
  
  if($row_tftp["material_type"] == "Z301")	
  {
	
  $data .= $row_tftp['plant_cd'].";".$row_tftp['disposal_no_ref'].";".$row_tftp['doc_dis'].";".$row_tftp['JD'].";".$tahun_plan.";552;".$row_recipt['user_fullname']."\r\n";
  
  }elseif($row_tftp["material_type"] == "Z201")
  {
	  
  $data .= $row_tftp['plant_cd'].";".$row_tftp['disposal_no_ref'].";".$row_tftp['doc_dis'].";".$row_tftp['JD'].";".$tahun_plan.";552;".$row_recipt['user_fullname']."\r\n";
	  
  }elseif($row_tftp["material_type"] == "Z401")
  {
	  
  $data .= $row_tftp['plant_cd'].";".$row_tftp['disposal_no_ref'].";".$row_tftp['doc_dis'].";".$row_tftp['JD'].";".$tahun_plan.";552;".$row_recipt['user_fullname']."\r\n";
	  
  }
  else{
	 
	 $data .= $row_tftp['plant_cd'].";".$row_tftp['disposal_no_ref'].";".$row_tftp['doc_dis'].";".$row_tftp['JD'].";".$tahun_plan.";552;".$row_recipt['user_fullname']."\r\n";
	  
	   
  }
   
}  //while loop



//------------------get filen doc. no cancellation generate --------------------------------------//


  
		 
 $filen= "DP".$doc_canC;
//$csv_filename = $filen."_".date("YmdHis",time());

$file = "../FromPortal2/DP/".$filen.".csv";
//chmod($file, 0777);
file_put_contents($file,$data);

       

 $qry_all = "SELECT *, DATE_FORMAT(date_disposal,'%d%m%Y') AS JD FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($uid4)."' AND status_disposal = '".sql_esc($rst_sta4["status_desc"])."' AND disposal_no_ref = '".sql_esc($doc_canC)."'";
  $result_all = mysqli_query($dbc,$qry_all);
  
  while($row_all = mysqli_fetch_array($result_all))
   {
  //----------update table ftp_disposal_detail_prd_all------------
  
  
		if($row_all["qty_NG"] != "0.000")
	{
		$qty_nwftp = $row_all["qty_NG"];
		
	}elseif($row_all["qty_qc"] != "0.000")
	{
		$qty_nwftp = $row_all["qty_qc"];
	}else{
		
		
	}

 
   
     $query_ftp_info = "INSERT INTO ftp_disposal_detail_prd_all_canc(id,id_dis,file_name,disposal_no_ref,doc_dis,id_disposal,bflush_hwork,bflush_rework,bflush_pending,bflush_no,uid,plan_no,material_no,material_desc,qty_ftp,uom,status_ftp,posting_date,posting_time,user_create,date_create,plant_code,stamp_ind,status_part) VALUES('','".sql_esc($row_all['id'])."','".sql_esc($filen)."','".sql_esc($row_all['disposal_no_ref'])."','".sql_esc($row_all['doc_dis'])."','".sql_esc($row_all["id_disposal"])."','".sql_esc($row_all["bflush_hwork"])."','".sql_esc($row_all["bflush_rework"])."','".sql_esc($row_all["bflush_pending"])."','".sql_esc($row_all["bflush_qqc_no"])."','".sql_esc($row_all["uid"])."','".sql_esc($row_all["plan_no"])."','".sql_esc($row_all["material_no"])."','".sql_esc($row_all["material_desc"])."','".sql_esc($qty_nwftp)."','".sql_esc($row_all["UOM_unit"])."','Y','".sql_esc($row_all["date_disposal"])."','".sql_esc($row_all["time_posting"])."','".sql_esc($username)."',NOW(),'".sql_esc($row_all["plant_cd"])."','".sql_esc($row_all["stamp_ind"])."','".sql_esc($row_all["status_part"])."')"; 
     $rst_ftp_info = mysqli_query($dbc,$query_ftp_info);
	 
	 
   }// while loop ftp
	 
	  
  } // end if($sta_out != "311")
  
  

		   echo "<script>";
		   echo "alert('Cancel Disposal ".html_esc($uid4)." posted.');";
		   echo "window.location='canC_hqc_disposal4-prdProc2.php?date1=$dateF&&date2=$dateT&&plant_code=$plant_code'";
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
		   // $doc_dis = $_GET["doc_dis"]; 
			
			
			
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
					
		
							

				$where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04;
	
	//********** END CONDITION **************
	
	
 ?>

  

<br>

        <div class="content mt-12"><h5>Are you sure to cancel this transaction?</h5><br>
       

    <form name="frmSearch" id="frmSearch" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" class="needs-validation"  novalidate>

    <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM disposal_detail_prd_all WHERE doc_dis = '".sql_esc($row["doc_dis"])."' AND status_disposal = '".sql_esc($rst_sta3["status_desc"])."' " .$where_sql." ORDER BY doc_dis ASC ";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   
   while($row6 = mysqli_fetch_array($result_display))
   {

      ?>
     
       <input name="uid4" type="hidden" value="<?php echo html_esc($row["doc_dis"]); ?> ">    
       <input name="date1" type="hidden" value="<?php echo $dateF; ?>"> 
       <input name="date2" type="hidden" value="<?php echo $dateT; ?>"> 
       <input name="plant_code" type="hidden" value="<?php echo $plant_code; ?>">  
  
      
      <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
  
      
     <div class="modal-footer pull-left">
      <input name="can_DISbtn" type="submit"  class="btn btn-success btn-sm" value="PROCEED" />
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