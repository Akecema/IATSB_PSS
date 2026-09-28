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
	
	
	
$url = "display_model_table.php"; 
    
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
	?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
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
          <h1><i class="fa fa-th-list"></i> Table Maintenance</h1>
          <p>Material Model</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="display_model_table.php">Material Model</a></li>
        </ul>
      </div> 
      
             <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="add_model_table.php">Add Model</a></li>
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="display_model_table.php">Material Model</a></li>
            </ul>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
              
                <form name="frmSearch" method="post" action="">
                <table width="350" align="right">
                <tr>
                <th><div align="right">
                <input name="txtKeyword" type="text" id="txtKeyword" value="<?php echo $strKeyword;?>">
                <input type="submit" value="Search" name="submit5" class="btn btn-info"></div></th>
                
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
	
	$query = "SELECT * FROM model_detail_tbl WHERE model_code != '' AND (model_code LIKE '%".sql_esc($strKeyword)."%' OR model_desc LIKE '%".sql_esc($strKeyword)."%')";
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
	$query .= "ORDER BY model_code ASC LIMIT  ".sql_num($row_start).','.$per_page;
	$rs = mysqli_query($dbc,$query);
	
		  
		 if ($num_rows > 0) {
	 
	         echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>';
			  		 
			  ?>    
              
                  <table class="table table-hover table-bordered sortable">
                  <thead>
                    <tr>
                    <th>ID Model</th>
                    <th>Model Code</th>
                    <th>Model Description</th>
                    <th>Plant Code</th>
                    <th>Material Type</th>
                    <th>Options</th>
                    <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php

   while($row2 = mysqli_fetch_array($rs))
   {
		$query_mat_type = "SELECT * FROM material_type_tbl WHERE id = '".sql_esc($row2["material_type"])."'";
		$result_mat_type = mysqli_query($dbc,$query_mat_type) or die (mysqli_error($dbc));
        $data_mat_type = mysqli_fetch_array($result_mat_type);
	
	
	 
      ?> <tr class="item">
                <td><div align="center"><?php  echo $row2["id_model"]; ?></div></td>
                <td><div align="center"><?php  echo $row2["model_code"]; ?></div></td>
                <td>&nbsp;<?php  echo $row2["model_desc"]; ?></td>
                <td>&nbsp;<?php  echo $row2["plant_code"]; ?></td>
                <td>&nbsp;<?php  echo $data_mat_type["mat_type_id"]; ?></td>
                <td><div align="center">               
                  <a href="#myNoteModel<?php echo $row2["id_model"]; ?>" data-toggle="modal" class="btn btn-warning square-btn-adjust"  target="_parent"><img src="../images/icon_view.jpg" width="16" height="16" alt="View">&nbsp;View</a>
                 
                    <!--------------------------modal------------------------->
          <?php    include "mat_model_view.php";   ?>
                
          </div></td>
                <td>
                <div align="center">
                 <a href="#myNoteEditM<?php echo $row2["id_model"]; ?>" data-toggle="modal" class="btn btn-warning square-btn-adjust"  target="_parent"><img src="../images/edit.gif" width="16" height="16" alt="Edit">&nbsp;Edit</a>
                 
                    <!--------------------------modal------------------------->
          <?php   include "mat_model_edit.php";   ?>
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
	echo " <a href='display_model_table.php?Page=$prev_page&txtKeyword=$strKeyword' class='pagin'><< Back</a> ";
	echo "</div>";
}

for($i=1; $i<=$num_pages; $i++){
	if($i != $page)
	{   
	    if($i < 5)
        {
	    echo "<div class='pagin'>";
		echo "<a href='display_model_table.php?Page=$i&txtKeyword=$strKeyword' class='pagin'> $i </a> ";
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
	echo " <a href ='display_model_table.php?Page=$next_page&txtKeyword=$strKeyword' class='pagin'>Next>></a> ";
	echo "</div>";
}

?>
            
 <?php
   mysqli_free_result($rs); 
   
   ?> <?php
	}   // free up the resources 
else
{
?><center>
<table width="800" cellspacing="0" class="textboxred">
  <tr> 
    <td><div align="center"><font color="#FF0000"><strong>There are currently no material model.</strong></font></div></td>
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