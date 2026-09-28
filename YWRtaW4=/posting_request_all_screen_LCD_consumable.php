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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	
	
$url = "posting_request_all_screen_LCD_consumable.php"; 
 
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
  <meta name="description" content="<?php $data_setup["tajuk_sys"]; ?>">
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
     <script type="text/JavaScript">

function timedRefresh(timeoutPeriod) {
     setTimeout("location.reload(true);",timeoutPeriod);
}


</script>
<?php

function _time_diff($hour_a, $hour_b){
   $y = date('Y-m-d').' ';
   return (int)((strtotime($y.$hour_b) - strtotime($y.$hour_a)) / 60);
}

include 'content2.php';

?>
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
}

/*.modal-dialog{
          width: 700px;
		  margin-left:0;
       }
.modal-header {
	width: 700px;
    background-color: #067EC6;
    padding:16px 16px;
    color:#FFF;
    border-bottom:2px #337AB7;
 }*/
 /*.modal-body {
	width: 700px;
    background-color: #FFF;
	overflow-y: auto;
  
 }*/
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
          <h1><i class="fa fa-th-list"></i>Board</h1>
          <p>Consumable Request Board</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Board</li>
          <li class="breadcrumb-item"><a href="posting_request_all_screen_LCD_consumable.php">Consumable Request Board</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">

       <?php

	$query = "SELECT *, DATE_FORMAT(MR.date_require,'%d-%m-%Y') AS R FROM consumable_request AS MR, consumable_detail AS SD WHERE MR.id_con = SD.id_con AND MR.status_request = 'Y' AND (MR.status != '".sql_esc($rst_sta13["status_desc"])."' AND MR.status  != '".sql_esc($rst_sta21["status_desc"])."') GROUP BY MR.temp_mrin, MR.id_work ORDER BY MR.date_require, MR.time_require DESC";
    $rs = mysqli_query($dbc,$query);   //run the query.
	$num_rows = mysqli_num_rows($rs);   //how many material are there?
		
	 if ($num_rows > 0) {
	 
	         echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>';
			  		 
			  ?>    
              
                  <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr>
                    <th>MRIN No.</th>
                    <th>Factory</th>
                    <th>Line</th> 
                    <th>Request Date</th>
                    <th>Request Time</th>
                    <th>Requestor</th>
                    <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php
				   
	$no = 1;
	$counter = 1;			   

   while($row2 = mysqli_fetch_array($rs))
   {

    $query_scan = "SELECT * FROM scan_detail WHERE id_scan = '".sql_esc($row2["id_scan"])."'";
   	$result_scan = mysqli_query($dbc,$query_scan);
   	$row_scan = mysqli_fetch_array($result_scan);
	
	$query_again = "SELECT * FROM consumable_request WHERE status_request = 'Y' and id_scan = '".sql_esc($row2["id_scan"])."' ORDER BY id_req_con ASC";
    $rs_again = mysqli_query($dbc,$query_again);   //run the query.
    $row = mysqli_fetch_array($rs_again);
	
	$query_u = "SELECT * FROM user_detail WHERE user_no = '".sql_esc($row["user_create"])."'";
	$result_u = mysqli_query($dbc,$query_u);   //run the query.
	$data_u = mysqli_fetch_array($result_u);   //how many records are there?    


 	$query3 = "SELECT * FROM factory_detail WHERE id_fac = '".sql_esc($row_scan["factory"])."'";
    $result3 = mysqli_query($dbc,$query3);
	$row3 = mysqli_fetch_array($result3);
	

  
  //---------------------------------------------------------------------------------------------------------------------
//Update listing board   - MRIN disappear from listing if all component status_posting = "Close"
//---------------------------------------------------------------------------------------------------------------------
	 $TOT = 0.000;
	 $outs_qty = 0;
	 
	$query_tp = "SELECT *,SUM(rquantity) as TOT FROM post_consumable_detail_header WHERE mrin_no = '".sql_esc($row2["temp_mrin"])."' AND mvt_type = 201 AND status_posting = '".sql_esc($rst_sta["status_desc"])."' GROUP BY material_no";
	$result_tp  = mysqli_query($dbc,$query_tp); 
	//$row_tp = mysql_fetch_assoc($result_tp); 
	
	while($row_tp = mysqli_fetch_assoc($result_tp))
{
  
		
	$tp_quantity = $row_tp["TOT"]; 
	
	
	$outs_qty = (($row["con_qty"]) - ($row_tp["TOT"]));
	
	
	   if(($row["con_qty"] == $tp_quantity) || ($row["con_qty"] < $tp_quantity) && ($outs_qty <= 0))
       {  
	
 $query_upd2 = "UPDATE `post_consumable_detail_header` SET status_posting = '".sql_esc($rst_sta13["status_desc"])."', date_close = NOW() WHERE mrin_no = '".sql_esc($row2["temp_mrin"])."' AND material_no = '".sql_esc($row_tp["material_no"])."' ";
 $result_upd2 = mysqli_query($dbc,$query_upd2); 
	      
 $query_upd3 = "UPDATE `consumable_request` SET status = '".sql_esc($rst_sta13["status_desc"])."' WHERE temp_mrin = '".sql_esc($row2["temp_mrin"])."' AND material_no = '".sql_esc($row_tp["material_no"])."' ";
 $result_upd3 = mysqli_query($dbc,$query_upd3); 
 
	 $query_upd4 = "UPDATE `consumable_request` SET status = '".sql_esc($rst_sta13["status_desc"])."' WHERE temp_mrin = '".sql_esc($row2["temp_mrin"])."' AND (con_qty = '0.000' OR con_qty = '')";
 $result_upd4 = mysqli_query($dbc,$query_upd4); 
	
	   //--------------------------------------------------------------------
       //copy yg close MRIN masuk dalam MRIN history
	   //---------------------------------------------------------------------
        if($result_upd3 || $result_upd4)
		 {
		 
		   $query_upd8 = "SELECT * FROM `consumable_request` WHERE temp_mrin = '".sql_esc($row2["temp_mrin"])."' AND status = '".sql_esc($rst_sta13["status_desc"])."'";
		   $result_upd8 = mysqli_query($dbc,$query_upd8);
		   $row_upd8 = mysqli_num_rows($result_upd8); 
        

		   if($row_upd4 > 0 )
		   {
		  
	$query_mm3 = "SELECT * FROM `cosumable_request` WHERE temp_mrin = '".sql_esc($row2["temp_mrin"])."' AND status = '".sql_esc($rst_sta13["status_desc"])."' AND material_no = '".sql_esc($row_tp["material_no"])."'"; 
    $result_mm3 = mysqli_query($dbc,$query_mm3) or die (mysqli_error($dbc));
	$row_mm3 = mysqli_fetch_array($result_mm3); 
			
			
			$query_mm3_insert =  "INSERT INTO consumable_request_close(id_req_con, mrin_doc, mrin_year, temp_mrin, id_hdr, id_dtl, id_scan, bom_id, bom_qty, bom_oum, status_request, status_print, user_create, date_create, user_update, date_update, date_posting, time_posting, status, bom_component, date_mrin, time_mrin, reason_close, reason_close2) VALUES('".sql_esc($row_mm3["id_req"])."','".sql_esc($row_mm3["mrin_doc"])."','".sql_esc($row_mm3["mrin_year"])."','".sql_esc($row_mm3["temp_mrin"])."','".sql_esc($row_mm3["id_hdr"])."','".sql_esc($row_mm3["id_dtl"])."','".sql_esc($row_mm3["id_scan"])."','".sql_esc($row_mm3["bom_id"])."','".sql_esc($row_mm3["con_qty"])."', '".sql_esc($row_mm3["bom_oum"])."','".sql_esc($row_mm3["status_request"])."','".sql_esc($row_mm3["status_print"])."','".sql_esc($row_mm3["user_create"])."','".sql_esc($row_mm3["date_create"])."','".sql_esc($row_mm3["user_update"])."','".sql_esc($row_mm3["date_update"])."','".sql_esc($row_mm3["date_posting"])."','".sql_esc($row_mm3["time_posting"])."','".sql_esc($row_mm3["status"])."','".sql_esc($row_mm3["bom_component"])."','".sql_esc($row_mm3["date_mrin"])."','".sql_esc($row_mm3["time_mrin"])."','6','')";
$result_mm3_insert = mysqli_query($dbc,$query_mm3_insert) or die (mysqli_error($dbc));
			
		  
		  
		    } // if $r4 == $r5
		  
		 
		   }// if($result_upd3)
	
	  
	   }elseif(($row["con_qty"] > $tp_quantity))
       {
	
	    }
	
} // end while loop $row_tp
  
		  ?>
       <tr>
           <td>&nbsp;<?php echo html_esc($row2["temp_mrin"]); ?></td>
           <td><div align="center"><?php echo html_esc($row2["factory"]); ?></div></td>
           <td><div align="center"><?php echo html_esc($row2["id_work"]); ?></div></td>
           <td><?php echo html_esc($row2["R"]); ?>&nbsp;</td>
           <td><?php echo html_esc($row2["time_require"]); ?></td>
           <td><?php echo html_esc($data_u["user_fullname"]); ?></td>
          <td><div align="center">
    <?php   
	   
         //------------------------   Traffic light-------------------------------------------------------------
		//- edit date : 5/11/2014    by : azie
		//-----------------------------------------------------------------------------------------------------
		
		
$curr_time = date("Y-m-d H:i:s"); 
$request_time = ($row2["date_require"].' '.$row2["time_require"]);

$min_20 = date("Y-m-d H:i:s", strtotime("$request_time - 20 minutes"));
$plus_20 = date("Y-m-d H:i:s", strtotime("$request_time + 20 minutes"));

   $start_date = new DateTime($min_20);
   $diff_time = $start_date->diff(new DateTime($request_time));


if ($curr_time < $min_20)
{
                echo '<img src="../images/grey_icon.jpg" width="25" height="25" /> ';
}
elseif(($curr_time >= $min_20) && ($curr_time < $request_time) )
{
                echo '<img src="../images/green_icon2.jpg" width="25" height="25" /> ';
}
elseif(($curr_time >= $request_time) && ($curr_time < $plus_20) )
{
                echo '<img src="../images/yellow_icon2.jpg" width="25" height="25" /> ';
}
elseif($curr_time >= $plus_20)
{
                echo '<img src="../images/red_icon2.jpg" width="25" height="25" /> ';
}


	?></div></td>
    </tr>
          <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  }  ?>

                </tbody>
                </table>
                
              
            
 <?php
   mysqli_free_result($rs); 
   
   ?> <?php
	}   // free up the resources 
else
{
?><center>
<table width="800" cellspacing="0" class="textboxred">
  <tr> 
    <td><div align="center"><font color="#FF0000"><strong>There are currently no consumable material.</strong></font></div></td>
  </tr>
</table></center>
        <?php
		   } 
mysqli_close($dbc)
?>


<table width="70%" border="0">
  <tr>
    <td width="20%"><span class="style4">No. of MRIN </span></td>
    <td width="9%"><span class="style4">&nbsp; :</span></td>
    <td width="71%"><span class="style4">&nbsp;<?php echo $numrows; ?></span></td>
  </tr>
  <tr>
    <td><span class="style4">Page No. </span></td>
    <td><span class="style4">&nbsp; :</span></td>
    <td><span class="style4">&nbsp;<?php echo $currentpage.' of '.$totalpages; ?></span></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>Legend :</p>
<table width="70%" border="1">
  <tr>
    <td width="10%"><div align="center"><img src="../images/red_icon2.jpg" alt="" width="20" height="20" /></div></td>
    <td width="90%">MRIN Request has passed 20 minutes from the requested time.</td>
  </tr>
  <tr>
    <td><div align="center"><img src="../images/yellow_icon2.jpg" alt="" width="20" height="20" /></div></td>
    <td>MRIN Request has reached the requested time.</td>
  </tr>
  <tr>
    <td><div align="center"><img src="../images/green_icon2.jpg" alt="" width="20" height="20" /></div></td>
    <td>MRIN Request is now 20 minutes before the requested time.</td>
  </tr>
  <tr>
    <td><div align="center"><img src="../images/grey_icon.jpg" alt="" width="20" height="20" /></div></td>
    <td>New MRIN Request has been posted.</td>
  </tr>
</table>
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
    
  </body>
</html>