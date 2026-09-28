<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	$url = "doc_list_prog_trn-postingProc2.php"; 
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

//CR status (Transfer Posting)
$sta19 = "SELECT * from request_status WHERE status_id = '19'";
$sta_res19 = mysqli_query($dbc,$sta19);
$rst_sta19 = mysqli_fetch_array($sta_res19);

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
    
  
    //-------------- click button "Rejected"--------------------------------------------------------------------------------------
  if(isset($_POST["prt_btn"])) 
   { // handle the form.
 
            $uid2 = $_POST["uid2"];
            $dateF = $_POST["date1"];
            $dateT = $_POST["date2"];
			$plant_code = $_POST["plant_code"];
			$sloc_f = $_GET["sloc_f"];
			$sloc_t = $_GET["sloc_t"];

   
           $uid2A = base64_encode($uid2);
   
           echo "<script>";
		   echo "window.open('print_tp_tran_proc.php?buid=$uid2A','_blank');";
		   echo "window.location='doc_list_prog_trn-postingProc2.php?date1=$dateF&&date2=$dateT&&plant_code=$plant_code&&sloc_f=$sloc_f&&sloc_t=$sloc_t';"; 
		   echo "</script>"; 
		   exit(); //quit the script
   
   
   }
   
?>
  <div class="modal fade printable autoprint" id="myNoteView<?php echo $row["doc_tp"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display Transfer Posting</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
     <!--   <div class="content mt-12">-->
     
     <?php
	 
	 $query_bb = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T3 from tp_store_detail WHERE doc_tp = '".sql_esc($row["doc_tp"])."'  GROUP BY doc_tp";
	 $rs_bb = mysqli_query($dbc,$query_bb);   //run the query.
     $data_bb = mysqli_fetch_array($rs_bb);
	 
	 
	 //-----user canccellation-----------
	 
	 $query_u_can = "SELECT * FROM user_detail WHERE username = '".sql_esc($row["user_cancel"])."'"; 
	 $rs_u_can = mysqli_query($dbc,$query_u_can);   //run the query.
     $data_u_can = mysqli_fetch_array($rs_u_can);
	 
	 ?>
   
   <form name="frmSearch" id="frmSearch" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" >  
   
  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="table table-borderless">
  <tr>
    <td><img src="../set_upload/<?php echo $filename; ?>" width="250" height="50"/> </td>     
    <td>&nbsp;</td>
    <td valign="top">&nbsp;<h5><font color="#999999"><b>TRANSFER POSTING</b></font></h5></td>
  </tr>
  <tr>
    <td><div align="left"><b>Plant :  </b><?php echo $row["plant_code"];   ?></div></td>
    <td>&nbsp;</td> 
    <td><div align="left"><b>Document No. :  </b><?php echo $row["doc_tp"];   ?></div></td>
   <tr> 
    <td><div align="left"><b>SLoc From :  </b><?php echo $row["sloc_from"];   ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Date :  </b><?php echo $data_bb["T3"];   ?></div></td>
  </tr>
  <tr>
    <td><div align="left"><b>SLoc To :  </b><?php echo $row["sloc_to"];   ?></div></td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Shift :  </b><?php echo $row["shift_day"];  ?></div></td>
  </tr>
  <?php   
 if($row["status_tp"] == $rst_sta4["status_desc"])
 {
  ?>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><b>Cancelled By :  </b><?php echo $data_u_can["user_fullname"];  ?></div></td>
  </tr><?php   } ?>
  </table>
  <?php
            
			$dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plant_code = $_GET["plant_code"];
			$sloc_f = $_GET["sloc_f"];
			$sloc_t = $_GET["sloc_t"];
			
			
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
                    $wheresql_01 = " AND (posting_date >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 2. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (posting_date <= '".sql_esc($date2_final)."')"; } 
					 	 
		 //3. Plant Code 
                if ($plant_code == "NULL"){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND plant_code = '".sql_esc($plant_code)."'"; } 
					
          //4. sloc from
                if ($sloc_f == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND sloc_from = '".sql_esc($sloc_f)."'"; }
   
	       //5. sloc to
                if ($sloc_t == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND sloc_to = '".sql_esc($sloc_t)."'"; }  	
					
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;	
	
   	//********** END CONDITION **************
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT * FROM tp_store_detail WHERE doc_tp = '".sql_esc($row["doc_tp"])."'  AND status_tran = 'Y'" .$where_sql." ORDER BY doc_tp ASC";
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
    <td><?php echo intval($row2["qty_tp"]); ?></td>
    <td><?php echo $row2["uom_tp"]; ?></td>
  </tr>
  
 <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
       
  </tbody>
</table>
 <br><br>
    
        <div class="modal-footer pull-left">
      <input name="plant_code"  type="hidden" id="plant_code" value="<?php echo $plant_code; ?>">
      <input name="uid2" type="hidden" id="uid2" value="<?php echo $row["doc_tp"]; ?>">
      <input name="sloc_f" type="hidden" id="sloc_f" value="<?php echo $_GET["sloc_f"]; ?>">
      <input name="sloc_t" type="hidden" id="sloc_t" value="<?php echo $_GET["sloc_t"]; ?>">
      <input name="date1" type="hidden" id="date1" value="<?php echo $_GET["date1"]; ?>">
      <input name="date2" type="hidden" id="date2" value="<?php echo $_GET["date2"]; ?>">
      <input name="prt_btn" type="submit"  class="btn btn-warning btn-sm" value="PRINT"/> 
      
      </div> 
  </form>
      
    
     </div> 
    
                  </div>
                  </div>
                  </div>
      
          
</body>
</html>