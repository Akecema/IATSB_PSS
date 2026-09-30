<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "1")) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
    $url = "wip_request_analysis.php"; 

    ini_set('display_errors', 1);
	error_reporting(~0);

	$strKeyword = "";

	if(isset($_POST["txtKeyword"]))
	{
		$strKeyword = $_POST["txtKeyword"];
	}
	if(isset($_GET["txtKeyword"]))
	{
		$strKeyword = $_GET["txtKeyword"];
	}
	
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

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13'";
$sta_res13 = mysqli_query($dbc,$sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);

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
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <!----sort table https://stackoverflow.com/questions/10683712/html-table-sort/51648529---->
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    <!--  <script src="https://www.w3schools.com/lib/w3.js"></script>-->
	
	<SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    <script language="javascript">
document.addEventListener('DOMContentLoaded', function () {
	$('.datepicker').pickadate({
	weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
	showMonthsShort: true
	})
	
});
</script>
<style>
th {
  cursor: pointer;
 /* background-color: coral;*/
}    
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
	overflow-x: auto;
}
</style> 
<style>
.pagin {
  display: inline-block;
}

.pagin a {
  color: black;
  float: left;
  padding: 7px 10px;
  text-decoration: none;
  border: 1px solid #ddd;
}

.pagin a.active {
  background-color: #32A478;
  color: white;
  border: 1px solid #32A478;
}

.pagin a:hover:not(.active) {background-color: #ddd;}

.pagin a:first-child {
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
}

.pagin a:last-child {
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px;
}
</style>   
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
     <?php   include "top_modal_menu.php";   ?>
    
   
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php   include "left_admin_menu.php";   ?>
   
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> WIP Request</h1>
          <p>WIP Request Analysis</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">WIP Request</li>
          <li class="breadcrumb-item"><a href="wip_request_analysis.php">WIP Request Analysis</a></li>
        </ul>
      </div> 
           
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
              
              <?php
			$where_sql = '';
			$date1_final = '';
			$date2_final = '';
			
			
			$material_no = $_GET["material_no"];
			$factory = $_GET["factory"];
			$work_center = $_GET["work_center"];
	        $status = $_GET["status"];
			$dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			
			  
		   ?>
              
           <!-- <form action="" method="get" name="frmSearch" id="frmSearch">-->
             <form action="wip_request_analysisProc.php?factory=<?php echo html_esc($factory); ?>&&work_center=<?php echo html_esc($work_center); ?>&&status=<?php echo html_esc($status); ?>&&date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&material_no=<?php echo html_esc($material_no); ?>" method="get" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
            <th>Request Date From : <font color="#FF0000">*</font></th>
            <td>
            <?php
			     $dd1 = substr($_GET["date1"],8,2);
				 $mm1 = substr($_GET["date1"],5,2);
				 $yy1 = substr($_GET["date1"],0,4);
			?>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" >
             
		      </td>
              <th>Request Date To : <font color="#FF0000">*</font></th>
              <td>
			   <input class="form-control" id="PSS2Date" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>">
			  </td>
             </tr>
              
              <tr>
              <th>Factory :</th>
              <td><select name="factory" id="factory" onChange="getFactory(this.value)" class="form-control">
                <option value="NULL" placeholder="Select Factory"> -- Select Factory --</option>
                <?php
	               $query3 = "SELECT * FROM factory_detail GROUP BY factory_desc2 ORDER BY id_fac ASC";
                   $result3 = db_query($dbc, $query3);
  
                   while($row3=mysqli_fetch_array($result3)) 
			      {
				  
				  
				  ?>
                <option value="<?php echo html_esc($row3["factory_desc2"]); ?>" <?php if($row3["factory_desc2"] == $_GET["factory"]) echo "selected"; ?>> <?php echo html_esc($row3["factory_desc"]); ?></option>
                <?php
                  }
				?>
              </select>
              </td>
          <th>Work Center :</th>
          <td><div id="work_centerdiv"> 
               <select name="work_center" id="work_center" class="form-control">
                <option value="NULL" placeholder="Select Work Center"> -- Select Work Center --</option>
                 <?php
	               $query5 = "SELECT * FROM work_center_detail WHERE id_factory = '".sql_esc($_GET["factory"])."' ORDER BY id_work ASC";
                   $result5 = mysqli_query($dbc,$query5);
  
                   while($row5=mysqli_fetch_array($result5)) 
				    { 
				   
				   ?>
                <option value="<?php echo html_esc($row5["id_work"]); ?>" <?php if($row5["id_work"] == $_GET["work_center"]) echo "selected"; ?>> <?php echo html_esc($row5["id_work"]),' - ',stripslashes($row5["wc_desc"]); ?></option>
                <?php
                  }
				?>
                </select></div></td>
              </tr>
              <tr>
              <th>Material No. :</th>
              <td>
                  <select name="material_no" id="material_no" class="form-control">
                  <option value="NULL" placeholder="Select Material No."> -- Select Material No. --</option>
                  <?php
	               $query9 = "SELECT * FROM mat_master_detail WHERE bom_status = 'Y' GROUP BY bill_component ORDER BY bill_component ASC";
                   $result9 = mysqli_query($dbc,$query9);
  
                   while($row9=mysqli_fetch_array($result9)) 
			      {
				   ?>
                  <option value="<?php echo html_esc($row9["bill_component"]); ?>" <?php if($row9["bill_component"] == $_GET["material_no"]) echo "selected"; ?>> <?php echo html_esc($row9["bill_component"]); ?></option>
                  <?php
                  }
				?>
                 </select>             
             </td>          
              <th>Status :</th>
              <td>
              <select name="status" id="status" class="form-control">
                  <option value="NULL" placeholder="Select Status"> -- Select Status --</option>
                  <option value="New" <?php if($_GET["status"] == "New") { ?> selected="selected"<?php } ?>>Open</option>
                  <option value="Close" <?php if($_GET["status"] == "Close") { ?> selected="selected"<?php } ?>>Close</option>
              </select>
              
            </td>
              </tr>
              <tr>
                <th>&nbsp;<font color="#FF0000">* Compulsory field</font></th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th><input name="Submit2" type="submit" class="btn btn-info" id="button" value="SEARCH" /></th>
              </tr>
             
                </table>
        </form>
 
         
                <form name="frmSearch5" method="post" action="wip_request_analysisProc.php?factory=<?php echo html_esc($factory); ?>&&work_center=<?php echo html_esc($work_center); ?>&&status=<?php echo html_esc($status); ?>&&date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&material_no=<?php echo html_esc($material_no); ?>">
                <table width="350" align="right">
                <tr>
                <th><div align="right">
                <input name="txtKeyword" type="text" id="txtKeyword" value="<?php echo $strKeyword;?>">
                <input type="submit" value="Search" name="submit5" class="btn btn-info"></th>
                </div>
                </tr>
                </table>
                </form>
                <?php	

			
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);
				 
				 
		     //convert material no kpd id_hdr
			
			$query_convert = "SELECT * FROM `mat_master_header` as MH WHERE MH.material_no = '".sql_esc($_GET["material_no"])."'";
			$result_convert = mysqli_query($dbc,$query_convert); 
			
			while ($row_convert = mysqli_fetch_array($result_convert))
			{
			
			//echo $row_convert["id_fac"];
			
			}
			
				
			
			//-------Count all results------------------------//
		 
		 // 2. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND (MR.date_posting >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 3. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (MR.date_posting <= '".sql_esc($date2_final)."')"; }  
                                                
		 // 3. Status
                if ($status == "NULL" ){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND MR.status = '".sql_esc($status)."'"; }          
                                
          //4. Work Center
                if ($work_center == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND SD.work_center = '".sql_esc($work_center)."'"; }
   
	       //5. Material No.
                if ($material_no == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND MR.bom_component = '".sql_esc($material_no)."'"; }  	
					
		   //6. Factory 
                if ($factory == "NULL"){ 
                    $wheresql_06 = ""; }
                else {
                    $wheresql_06 = " AND SD.factory = '".sql_esc($factory)."'"; }  			
	       	
	                                        
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05 .$wheresql_06;	
			
	
	//********** END CONDITION **************
	
   $query8 = "SELECT *,DATE_FORMAT(MR.date_mrin,'%d-%m-%Y') AS R, DATE_FORMAT(MR.date_posting,'%d-%m-%Y') AS R2 FROM wip_request AS MR, scan_detail_wip AS SD WHERE MR.id_scan_wip = SD.id_scan AND MR.status_request = 'Y' AND MR.status != '".sql_esc($rst_sta["status_desc"])."' AND (MR.temp_mrin_wip LIKE '%".sql_esc($strKeyword)."%')" .$where_sql. "GROUP BY MR.temp_mrin_wip";
   $result8 = mysqli_query($dbc,$query8);
   $num_rows = mysqli_num_rows($result8);
			
  
    //define how many result per pages
	$page  = 1;
	$per_page = 10; 
	$counter = 1;
	
    $no = 1;
    $i = 1;
	
   if(isset($_GET["Page"]))
	{
     $page = $_GET["Page"];
	// $no = (is_numeric($_GET['no']) ? $_GET['no'] : 1);
	 
	}else {
     $page = 1;
	 $no = 1;  
    }

	$prev_page = $page-1;
	$next_page = $page+1;
      
 
 
  
$query = "SELECT *,DATE_FORMAT(MR.date_mrin,'%d-%m-%Y') AS R, DATE_FORMAT(MR.date_posting,'%d-%m-%Y') AS R2 FROM wip_request AS MR, scan_detail_wip AS SD WHERE MR.id_scan_wip = SD.id_scan AND MR.status_request = 'Y' AND MR.status != '".sql_esc($rst_sta["status_desc"])."' AND (MR.temp_mrin_wip LIKE '%".sql_esc($strKeyword)."%')" .$where_sql. " GROUP BY MR.temp_mrin_wip";
$rs = mysqli_query($dbc,$query);
$num_rows = mysqli_num_rows($rs);   //how many material are there?
		
	//$row_start = (($page - 1)* $per_page);
	
	$row_start = (($per_page*$page)-$per_page);
	
	if($num_rows<=$per_page)
	{
		$num_pages = 1;
	}
	elseif(($num_rows % $per_page) == 0)
	{
		$num_pages =($num_rows/$per_page) ;
	}
	else
	{
		$num_pages = ($num_rows/$per_page)+1;
		$num_pages = (int)$num_pages;
	}
	
	$row_end = ($per_page*$page);
	
	if($row_end > $num_rows)
	{
		$row_end = $num_rows;
	}
    
	$query .= " ORDER BY MR.date_posting ASC, MR.temp_mrin_wip ASC LIMIT ".sql_num($row_start).','.$per_page;
	//$rs = mysqli_query($dbc,$query);
	
		  
		 if ($num_rows > 0) {
	 
	         echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>';
			  		 	
?>
                 <table class="table table-hover table-bordered sortable">
                  <thead>
                    <tr>
                   	 <th>Factory</th>
                     <th>Line</th>
                     <th>MRIN No.</th>
                     <th>Material No.</th>
                     <th>Required <br />Date</th>
                     <th>Required Time</th>
                     <th>Duration</th>
                     <th>Requested <br />Quantity</th>
                     <th>Transferred <br />Quantity</th>
                     <th>Variance <br />Quantity</th>
                     <th>UoM</th>
                     <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>


	 <?php
    $counter = 1;
    $no = 1;
    $i = 1;
    $variance_qty = 0;
    $bq = 0;
    $rq = 0;
   
   while($row2 = mysqli_fetch_array($rs))
   {
		//$user_no = $row[0]; 

		
		
   	$query_scan = "SELECT * FROM scan_detail_wip WHERE id_scan = '".sql_esc($row2["id_scan"])."'";
   	$result_scan = mysqli_query($dbc,$query_scan);
   	$row_scan = mysqli_fetch_array($result_scan);
	
	$query_again = "SELECT * FROM wip_request WHERE status_request = 'Y' and id_scan_wip = '".sql_esc($row2["id_scan"])."' ORDER BY id_req_wip ASC";
    $rs_again = mysqli_query($dbc,$query_again);   //run the query.
    $row = mysqli_fetch_array($rs_again);
	
	$query_u = new PreparedSql("SELECT * FROM user_detail WHERE user_no = ?", [$row["user_create"]]);
	$result_u = db_query($dbc, $query_u);   //run the query.
	$data_u = mysqli_fetch_array($result_u);   //how many records are there?    

 	$query3 = new PreparedSql("SELECT * FROM factory_detail WHERE id_fac = ?", [$row_scan["factory"]]);
    $result3 = db_query($dbc, $query3);
	$row3 = mysqli_fetch_array($result3);
	
	$query4_p = "SELECT * from mat_master_header as LD, mat_master_detail as SD WHERE SD.id_hdr = LD.id_hdr and SD.id_dtl = '".sql_esc($row2["id_dtl_wip"])."'";
  	$result4_p = mysqli_query($dbc,$query4_p);
 	$row4_p = mysqli_fetch_array($result4_p); 
 
    $query5 = "SELECT * FROM post_detail_header_wip WHERE mrin_no = '".sql_esc($row2["temp_mrin_wip"])."' AND material_no = '".sql_esc($row2["bom_component"])."' AND mvt_type = 311 AND prod_order = '".sql_esc($row_scan["prod_order"])."'";
    $result5 = mysqli_query($dbc,$query5);
	$row5 = mysqli_fetch_array($result5);
	
	$query6 = "SELECT * FROM post_detail_header_wip AS PD, wip_request AS MR WHERE PD.mrin_no = MR.temp_mrin_wip AND PD.material_no = MR.bom_component AND PD.mrin_no = '".sql_esc($row2["temp_mrin_wip"])."' AND PD.material_no = '".sql_esc($row2["bom_component"])."' AND PD.mvt_type = 311";
    $result6 = mysqli_query($dbc,$query6);
	$row6 = mysqli_fetch_array($result6);

//-------------------------------------------------------Transfer Posting [Traffic Light] --------------------------
// table post_detail_header --- checking traffic licht
//-----------------------------------------------------------------------------------------------------------------

$date_post =  ($row2["date_mrin"].' '.$row2["time_mrin"]);
//$date_transfer = (date("Y-m-d").' '.date("H:i:s"));
$date_transfer = ($row5["date_create"].' '.$row5["time_create"]);

$start_date = new DateTime($date_post);
$since_start = $start_date->diff(new DateTime($date_transfer));

/*echo $since_start->m.' month<br>';
 echo $since_start->d.' days<br>';
echo $since_start->h.' hours<br>';
echo $since_start->i.' minutes<br>';
echo $since_start->s.' seconds<br>';  */ 

//------------------------------------------------------ Variance Quantity-----------------------------------------
//
//------------------------------------------------------------------------------------------------------------------	

					
    $query_tp = "SELECT *,SUM(rquantity) as TOT FROM post_detail_header_wip WHERE mrin_no = '".sql_esc($row2["temp_mrin_wip"])."' AND prod_order = '".sql_esc($row_scan["prod_order"])."' AND mvt_type = 311 AND material_no = '".sql_esc($row4_p["bill_component"])."'";
	$result_tp  = mysqli_query($dbc,$query_tp); 

    $outs_qty = 0;
					
	while($row_tp = mysqli_fetch_assoc($result_tp))
   {
	
	$tp_quantity = $row_tp["TOT"]; 
	
	$outs_qty = ((($row2["bom_qty_wip"])) - (($row_tp["TOT"])));
	
	 }//end while $row_tp	
	 
	$outs_qty1 = number_format($outs_qty,3);	
	
	  $bq = ($row2["bom_qty_wip"]);	
	  $rq = ($row5["rquantity"]);
	
      $variance_qty = ($bq - $rq);
	  $variance_qty2 =  number_format($variance_qty, 3, '.', '');
	  

		  ?>        
         
  <tr>
    <td width="50"><div align="center"><?php echo html_esc($row_scan["factory"]); ?></div></td> 
    <td width="60"><div align="center"><?php echo html_esc($row_scan["work_center"]); ?></div></td>
    <td width="100">&nbsp;<?php echo html_esc($row2["temp_mrin_wip"]); ?></td>
    <td width="160">&nbsp;<?php echo html_esc($row2["bom_component"]); ?></td>
    <td width="100"><div align="center"><?php echo html_esc($row2["R"]); ?></div></td>
    <td width="80"><div align="center"><?php echo html_esc($row2["time_mrin"]); ?></div></td>
    <td width="70">
	<?php
	//-------------------------------------------------------------------------------------
	//-   check status "Open" and still dont have TP
	//---------------------------------------------------------------------------------
	if ($row6 > 0)
	{
	
     echo $since_start->h." : ".$since_start->i; 
	}else{
	
	echo "&nbsp;";
	}
 
	?></td>
    <td width="90"><div align="right"><?php echo html_esc($row2["bom_qty_wip"]); ?></div>
   </td>
    <td width="90"><div align="right"><?php echo html_esc($row5["rquantity"]); ?></div></td>
    <td width="90"><?php if($variance_qty2 < 0 ) { echo "<font color='red'>";  echo $variance_qty2;  echo "</font>"; }else{ echo $variance_qty2; } ?></td>
    <td width="50"><div align="center"><?php echo html_esc($row2["bom_oum_wip"]); ?></div></td>
    <td width="55"><?php echo html_esc($row2["status"]);    ?></td>
  </tr>
 
  <?php 
		 
		  $no++;
		  $counter++; // menambah counter 
		   
		   //}// end if
		
		    
		  } ?>
          
          </tbody>
          </table>
 <br>
               
<!--Total <?php echo $num_rows;?> Record : <?php echo $num_pages;?> Page :
--><?php


 $strKeyword  = urlencode($strKeyword);


if($prev_page)
{   
 
    echo "<div class='pagin'>";
	echo " <a href='wip_request_analysisProc.php?Page=$prev_page&txtKeyword=$strKeyword&factory=".html_esc($factory)."&&work_center=".html_esc($work_center)."&&status=".html_esc($status)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&material_no=".html_esc($material_no)."' class='pagin'><< Back</a> ";
	echo "</div>";
}

for($i=1; $i<=$num_pages; $i++){
	if($i != $page)
	{   
	    if($i < 5)
        {
	    echo "<div class='pagin'>";
		echo "<a href='wip_request_analysisProc.php?Page=$i&txtKeyword=$strKeyword&factory=".html_esc($factory)."&&work_center=".html_esc($work_center)."&&status=".html_esc($status)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&material_no=".html_esc($material_no)."' class='pagin'> $i </a> ";
		echo "</div>";
		} //end num page
	}
	else
	{
	    echo "<div class='pagin'>";
	 	echo "<a href='' class='pagin active'> $i </a>";
		echo "</div>";
	}
}
if($page!=$num_pages)
{
	echo "<div class='pagin'>"; 
	echo " <a href ='wip_request_analysisProc.php?Page=$next_page&txtKeyword=$strKeyword&factory=".html_esc($factory)."&&work_center=".html_esc($work_center)."&&status=".html_esc($status)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&material_no=".html_esc($material_no)."' class='pagin'>Next>></a> ";
	echo "</div>";
}

   mysqli_free_result($rs); 
   
 
	}   // free up the resources 
else
{
?><center>
<table width="800" cellspacing="0" class="textboxred">
  <tr> 
    <td><div align="center"><font color="#FF0000"><strong>There are currently no WIP Request.</strong></font></div></td>
  </tr>
</table></center>
        <?php
		   } 
mysqli_close($dbc);
?>



                       </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Data table plugin-->
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    <script type="text/javascript">
      $('#sl').on('click', function(){
      	$('#tl').loadingBtn();
      	$('#tb').loadingBtn({ text : "Signing In"});
      });
      
      $('#el').on('click', function(){
      	$('#tl').loadingBtnComplete();
      	$('#tb').loadingBtnComplete({ html : "Sign In"});
      });
      
      $('#PSSDate').datepicker({
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
      
	   $('#PSS2Date').datepicker({
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      $('#demoSelect').select2();
    </script>
    <script language="javascript" type="text/javascript">

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
	function getFactory(factory) {		
		
		var strURL="findWorkcenter3.php?factory="+factory;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('work_centerdiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
</script>
  </body>
</html>