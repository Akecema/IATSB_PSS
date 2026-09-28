<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
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
	
	
	
$url = "close_po-create.php"; 

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

//CR status (Cancelled)
$sta4 = "SELECT * from request_status WHERE status_id = '4'";
$sta_res4 = mysqli_query($dbc,$sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);

//CR status (Draft)
$sta6 = "SELECT * from request_status WHERE status_id = '6'";
$sta_res6 = mysqli_query($dbc,$sta6);
$rst_sta6 = mysqli_fetch_array($sta_res6);

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
   <!-- <script language="javascript">
		let tid = "#usersTable";
		let headers = document.querySelectorAll(tid + " th");
	
		// Sort the table element when clicking on the table headers
		headers.forEach(function(element, i) {
	 	element.addEventListener("click", function() {
		w3.sortHTML(tid, ".item", "td:nth-child(" + (i + 1) + ")");
 		 });
		});
	</script>-->
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
          <h1><i class="fa fa-file-text-o"></i> PO Close</h1>
          <p>PO Close</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">PO Close</li>
          <li class="breadcrumb-item"><a href="close_po-create.php">PO Close</a></li>
        </ul>
      </div> 
             <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="close_po-create.php">PO Close</a></li>
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="close_po-display.php">Display PO Closed</a></li>
            </ul>
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">PO Close </h3>
            <div class="tile-body">
              <div class="table-responsive">
         		<form name="frmSearch" method="post" action="">
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
	
	$query = "SELECT *, DATE_FORMAT(date_closed, '%d-%m-%Y %h:%i:%s') AS CT FROM po_detail WHERE (purc_ord_no LIKE '%".sql_esc($strKeyword)."%' OR material_no LIKE '%".sql_esc($strKeyword)."%') AND status_po = '".sql_esc($rst_sta13["status_desc"])."'";
    $rs = mysqli_query($dbc,$query);   //run the query.
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
    
	//$query .= "ORDER BY material_no ASC LIMIT ".$row_start.','.$row_end; //silap
	$query .= "ORDER BY id_gr ASC LIMIT  ".sql_num($row_start).','.$per_page;
	$rs = mysqli_query($dbc,$query);
	
		  
		 if ($num_rows > 0) {
	 
	         echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>';
			  		 
			  ?> 
               <!-- <table class="table table-hover table-bordered" id="usersTable"  >   --> 
                  <table class="table table-hover table-bordered sortable" id="usersTable" >
                  <thead>
                    <tr>
                    <th>Purchase Order No.</th>
                    <th>Material No.</th>
                    <th>Item No.</th>
                    <th>Plant Code</th>
                    <th>Vendor ID</th>
                    <th>GR Change</th>
                    <th>User Closed</th>
                    <th>Date Closed</th>
                    </tr>
                  </thead>
                  <tbody>
   <?php

   while($row2 = mysqli_fetch_array($rs))
   {
		
      ?>        <tr class="item">
                <td><div align="center"><?php  echo html_esc($row2["purc_ord_no"]); ?></div></td>
                <td>&nbsp;<?php  echo html_esc($row2["material_no"]); ?></td>
                <td><div align="center"><?php echo html_esc($row2["item_no"]); ?></div></td>
                <td><?php  echo html_esc($row2["plant_code"]); ?></td>
                <td><div align="center"><?php echo html_esc($row2["vendor_id"]); ?></div></td>
                <td><div align="center"><?php echo html_esc($row2["gr_chg"]); ?></div></td>
                <td> <div align="center"><?php echo html_esc($row2["user_closed"]); ?>
                 <!--<a href="#myNoteWork<?php echo html_esc($row2["id_gr"]); ?>" data-toggle="modal" class="btn btn-warning square-btn-adjust"  target="_parent"><img src="../images/icon_view.jpg" width="16" height="16" alt="View">&nbsp;View</a>-->
                 
                    <!--------------------------modal------------------------->
          <?php    //include "work_center_view.php";   ?>
               </div>
                <td> <div align="center"><?php echo html_esc($row2["CT"]); ?>
           <!--  <a href="#myNoteEdit<?php echo html_esc($row2["id_gr"]); ?>" data-toggle="modal" class="btn btn-warning square-btn-adjust"  target="_parent"><img src="../images/edit.gif" width="16" height="16" alt="Edit">&nbsp;Edit</a>-->
                 
                    <!--------------------------modal------------------------->
          <?php   //include "work_center_edit.php";   ?>
                  </div>    
        
                 </td>
          </tr>
       
          <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  }  ?>

                </tbody>
                </table>
         <br>
               
<!--Total <?php echo $num_rows;?> Record : <?php echo $num_pages;?> Page :-->
<?php


 $strKeyword  = urlencode($strKeyword);


if($prev_page)
{   
 
    echo "<div class='pagin'>";
	echo " <a href='close_po-display.php?Page=$prev_page&txtKeyword=$strKeyword' class='pagin'><< Back</a> ";
	echo "</div>";
}

for($i=1; $i<=$num_pages; $i++){
	if($i != $page)
	{   
	   if($i < 5)
        {
	    echo "<div class='pagin'>";
		echo "<a href='close_po-display.php?Page=$i&txtKeyword=$strKeyword' class='pagin'> $i </a> ";
		echo "</div>";
		} // end num page
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
	echo " <a href ='close_po-display.php?Page=$next_page&txtKeyword=$strKeyword' class='pagin'>Next>></a> ";
	echo "</div>";
}

   mysqli_free_result($rs); 
   
   ?> <?php
	}   // free up the resources 
else
{
?><center>
<table width="800" cellspacing="0" class="textboxred">
  <tr> 
    <td><div align="center"><font color="#FF0000"><strong>There are currently no PO request.</strong></font></div></td>
  </tr>
</table></center>
        <?php
		   } 
//mysql_close()
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
    
  </body>
</html>