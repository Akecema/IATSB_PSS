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
$num_setup = $rs_setup ? mysqli_num_rows($rs_setup) : 0;   //how many material are there?
$data_setup = $rs_setup ? mysqli_fetch_array($rs_setup) : null;
//----------------------------------------------------

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = $result2 ? mysqli_fetch_array($result2) : null;
	
    $url = "report_PPC_consumable.php"; 

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
$rst_sta = $sta_res ? mysqli_fetch_array($sta_res) : null;

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2'";
$sta_res2 = mysqli_query($dbc,$sta2);
$rst_sta2 = $sta_res2 ? mysqli_fetch_array($sta_res2) : null;


//CR status (Approved)
$sta3 = "SELECT * from request_status WHERE status_id = '3'";
$sta_res3 = mysqli_query($dbc,$sta3);
$rst_sta3 = $sta_res3 ? mysqli_fetch_array($sta_res3) : null;

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = $sta_res7 ? mysqli_fetch_array($sta_res7) : null;

//CR status (Pending)
$sta8 = "SELECT * from request_status WHERE status_id = '8'";
$sta_res8 = mysqli_query($dbc,$sta8);
$rst_sta8 = $sta_res8 ? mysqli_fetch_array($sta_res8) : null;

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13'";
$sta_res13 = mysqli_query($dbc,$sta13);
$rst_sta13 = $sta_res13 ? mysqli_fetch_array($sta_res13) : null;

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = $sta_res14 ? mysqli_fetch_array($sta_res14) : null;

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = $sta_res16 ? mysqli_fetch_array($sta_res16) : null;

//CR status (Cancel)
$sta21 = "SELECT * from request_status WHERE status_id = '21'";
$sta_res21 = mysqli_query($dbc,$sta21);
$rst_sta21 = $sta_res21 ? mysqli_fetch_array($sta_res21) : null;

//CR status (Close)
$sta22 = "SELECT * from request_status WHERE status_id = '22'";
$sta_res22 = mysqli_query($dbc,$sta22);
$rst_sta22 = $sta_res22 ? mysqli_fetch_array($sta_res22) : null;
 
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
          <h1><i class="fa fa-th-list"></i> Consumable Request</h1>
          <p>Consumable Request Report</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Consumable Request</li>
          <li class="breadcrumb-item"><a href="report_PPC_consumable.php">Consumable Request Report</a></li>
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
			
        
	        $temp_mrin = $_GET["temp_mrin"];
            $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$factory = $_GET["factory"];
			  
			  ?>
            <form action="report_PPCProc_consumable.php?temp_mrin=<?php echo html_esc($temp_mrin); ?>&&date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&factory=<?php echo html_esc($factory); ?>" method="get" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
            <th>Posting Date From : <font color="#FF0000">*</font></th>
            <td>
            <?php
			     $dd1 = substr($_GET["date1"],8,2);
				 $mm1 = substr($_GET["date1"],5,2);
				 $yy1 = substr($_GET["date1"],0,4);
			?>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" >
             
		     </td>
              <th>Posting Date To : <font color="#FF0000">*</font></th>
              <td>
			   <input class="form-control" id="PSS2Date" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>">
			  </td>
            </tr>
              <tr>
              <th>Factory :</th>
              <td><select name="factory" id="factory" class="form-control">
                <option value="NULL" placeholder="Select Factory"> -- Select Factory --</option>
                <?php
	               $query3 = "SELECT * FROM factory_detail GROUP BY factory_desc2 ORDER BY id_fac ASC";
                   $result3 = db_query($dbc, $query3);
  
                   while ($result3 && ($row3 = mysqli_fetch_array($result3))) 
			      {
				  
				  
				  ?>
                <option value="<?php echo html_esc($row3["factory_desc2"]); ?>" <?php if($row3["factory_desc2"] == $_GET["factory"]) echo "selected"; ?>> <?php echo html_esc($row3["factory_desc"]); ?></option>
                <?php
                  }
				?>
              </select>
              </td>
          <th>MRIN No :</th>
          <td><input name="temp_mrin" type="text" id="temp_mrin" class="form-control" value="<?php echo html_esc($_GET["temp_mrin"]); ?>" /></td>
           </tr>
              <tr>
                  <th>&nbsp;<font color="#FF0000">* Compulsory field</font></th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th><input name="Submit2" type="submit" class="btn btn-info" id="button" value="SEARCH" /></th>
                </tr>
                </table>
        </form>
 
 
               <!-- <form name="frmSearch5" method="post" action="<?php echo html_esc($_SERVER['SCRIPT_NAME']); ?>">-->
               <form name="frmSearch5" method="post" action="report_PPCProc_consumable.php?temp_mrin=<?php echo html_esc($temp_mrin); ?>&&date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&factory=<?php echo html_esc($factory); ?>">
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
			
			$query_convert = "SELECT * FROM factory_detail WHERE factory_desc = '".sql_esc($_GET["factory"])."'";
			$result_convert = mysqli_query($dbc,$query_convert); 
			
			while ($result_convert && ($row_convert = mysqli_fetch_array($result_convert)))
			{
			
			//echo $row_convert["id_fac"];
			
			}
			
			
			
			//-------Count all results------------------------//
	
		 
		 // 1. temp_mrin
                if($temp_mrin == "") {
                     $wheresql_01 = ""; }
                else {
                      $wheresql_01 = " AND temp_mrin = '".sql_esc($temp_mrin)."'"; }
		  // 2. dateF
                if (($dateF == "00-00-0000" ) || ($dateF == " " )) {
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (date_posting >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 3. dateT
                if (($dateT == "00-00-0000" ) || ($dateT == " " )){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND (date_posting <= '".sql_esc($date2_final)."')"; }          
                                
          //4. factory
                if ($factory == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND factory = '".sql_esc($factory)."'"; }
   
	   
			$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04;
			
	//********** END CONDITION **************
        
    	?>
        
         <?php

								 
   $query8 = "SELECT * FROM consumable_request WHERE status_request = 'Y' AND status != '".sql_esc($rst_sta21["status_desc"])."'  AND (temp_mrin LIKE '%".sql_esc($strKeyword)."%')" .$where_sql." GROUP BY temp_mrin";
   $result8 = mysqli_query($dbc,$query8);
   $num_rows = $result8 ? mysqli_num_rows($result8) : 0;
   
   /*$pages = new Paginator;
   $pages->items_total = $num_rows;
   $pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
   $pages->paginate();*/
   
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
      
 
 
  
$query = "SELECT * FROM consumable_request WHERE status_request = 'Y' AND status != '".sql_esc($rst_sta21["status_desc"])."' AND (temp_mrin LIKE '%".sql_esc($strKeyword)."%') ".$where_sql." GROUP BY temp_mrin";
$rs = mysqli_query($dbc,$query);
$num_rows = $rs ? mysqli_num_rows($rs) : 0;   //how many material are there?
		
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
    
	$query .= " ORDER BY date_posting ASC LIMIT ".sql_num($row_start).','.$per_page;
	//$rs = mysqli_query($dbc,$query);
	
		  
		 if ($num_rows > 0) {
	 
	         echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>';
			  		 	
?>


                
                
                
                 <table class="table table-hover table-bordered sortable">
                  <thead>
                    <tr>
                    <th>MRIN No.</th>
                    <th>Factory</th>
                    <th>Line</th>
                    <th>Request Date</th>
                    <th>Request Time</th>
                    <th>Requestor</th>
                    <th>Options</th>
                    <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>


	 <?php

       while ($rs && ($row_cons = mysqli_fetch_array($rs)))
       {
		   
	$query_again = "SELECT * FROM consumable_request WHERE status_request = 'Y' and id_scan = '".sql_esc($row_cons["id_scan"])."' ORDER BY id_req_con ASC";
    $rs_again = mysqli_query($dbc,$query_again);   //run the query.
    $row_again = $rs_again ? mysqli_fetch_array($rs_again) : null;
	
	$query_u = new PreparedSql("SELECT * FROM user_detail WHERE user_no = ?", [$row_again["user_create"]]);
	$result_u = db_query($dbc, $query_u);   //run the query.
	$data_u = $result_u ? mysqli_fetch_array($result_u) : null;   //how many records are there?    

 	$query3 = new PreparedSql("SELECT * FROM factory_detail WHERE id_fac = ?", [$row_again["factory"]]);
    $result3 = db_query($dbc, $query3);
	$row3 = $result3 ? mysqli_fetch_array($result3) : null;
	

//-------------------------------------------------------Transfer Posting [Traffic Light] --------------------------
// table post_consumable_detail_header --- checking traffic licht
//--------------------------------------------------------------------------------------------------

/*$date_post =  ($row2["date_require"].' '.$row2["time_require"]);
$date_transfer = (date("Y-m-d").' '.date("H:i:s"));
//$date_transfer = ($db_tp["date_create"].' '.$db_tp["time_create"]);

$start_date = new DateTime($date_post);
$since_start = $start_date->diff(new DateTime($date_transfer));
*/
	  
		   
		   
?>         
          
          
          
            <tr class="item">
            <td>&nbsp;<?php  echo html_esc($row_cons["temp_mrin"]); ?></td>
            <td>&nbsp;<?php  echo html_esc($row_cons["factory"]); ?></td>
            <td>&nbsp;<?php  echo html_esc($row_cons["id_work"]); ?></td>
            <td>&nbsp;<?php  echo html_esc($row_cons["date_require"]);  ?></td>
            <td>&nbsp;<?php  echo html_esc($row_cons["time_require"]); ?></td>
            <td>&nbsp;<?php  echo html_esc($data_u["user_fullname"]); ?></td>
            <td><div align="center">
                 <a href="#myNoteCon<?php echo html_esc($row_cons["temp_mrin"]); ?>" data-toggle="modal" class="btn btn-warning square-btn-adjust"  target="_parent"><img src="../images/icon_view.jpg" width="16" height="16" alt="View">&nbsp;View</a>
                 
                    <!--------------------------modal------------------------->
          <?php    include "detail_consumable_request.php";   ?>
               </div>
          
              </td> 
              <td><div align="center">
                 <a href="#myNotePrint<?php echo html_esc($row_cons["temp_mrin"]); ?>" data-toggle="modal" class="btn btn-warning square-btn-adjust"  target="_parent"><img src="../images/printe1.gif" width="16" height="16" alt="Print">&nbsp;Print</a>
                 
                    <!--------------------------modal------------------------->
          <?php    include "detail_consumable_request_printing.php";   ?>
               </div>
          
              </td> 
              </tr>
          <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  }  
		  
		  ?>

                </tbody>
              </table>
 <br>
               
<!--Total <?php echo $num_rows;?> Record : <?php echo $num_pages;?> Page :
--><?php


 $strKeyword  = urlencode($strKeyword);


if($prev_page)
{   
 
    echo "<div class='pagin'>";
	echo " <a href='report_PPCProc_consumable.php?Page=$prev_page&txtKeyword=$strKeyword&temp_mrin=".html_esc($temp_mrin)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&factory=".html_esc($factory)."' class='pagin'><< Back</a> ";
	echo "</div>";
}

for($i=1; $i<=$num_pages; $i++){
	if($i != $page)
	{   
	    if($i < 5)
        {
	    echo "<div class='pagin'>";
		echo "<a href='report_PPCProc_consumable.php?Page=$i&txtKeyword=$strKeyword&temp_mrin=".html_esc($temp_mrin)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&factory=".html_esc($factory)."' class='pagin'> $i </a> ";
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
	echo " <a href ='report_PPCProc_consumable.php?Page=$next_page&txtKeyword=$strKeyword&temp_mrin=".html_esc($temp_mrin)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&factory=".html_esc($factory)."' class='pagin'>Next>></a> ";
	echo "</div>";
}

   mysqli_free_result($rs); 
   
 
	}   // free up the resources 
else
{
?><center>
<table width="800" cellspacing="0" class="textboxred">
  <tr> 
    <td><div align="center"><font color="#FF0000"><strong>There are currently no Consumable Request.</strong></font></div></td>
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
	  
      
    </script>
    
  </body>
</html>