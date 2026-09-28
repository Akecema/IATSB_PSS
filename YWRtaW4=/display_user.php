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

$url = "add_user.php"; 

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

    <link rel="stylesheet" type="text/css" href="pagin.css">
	
	<SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
<style>
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
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
          <h1><i class="fa fa-users"></i> User Maintenance</h1>
          <p>Assign Vendor</p>
          
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">User Maintenance</li>
          <li class="breadcrumb-item"><a href="display-vendor_user.php">Display Assign Vendor</a></li>
        </ul>
      </div>  

      <ul class="nav nav-tabs">
          <li class="nav-item"><a class="nav-link"  href="add_user.php">Add User</a></li>
          <li class="nav-item"><a class="nav-link active" href="display_user.php">Display User</a></li>
          <li class="nav-item"><a class="nav-link" href="reset_password_user.php">Reset Password</a></li>
          <li class="nav-item"><a class="nav-link" href="crt-vendor_user.php">Assign Vendor</a></li>
          <li class="nav-item"><a class="nav-link" href="display-vendor_user.php">Display Assign Vendor</a></li>
      </ul>
              
              
      <div class="row">
        <div class="col-md-12">
          <div class="tile">

            <!-- searching -->
            <div class="tile-title-w-btn">
              <h3 class="title"></h3>
              <div class="messanger">                        
                <div class="sender">
                  <form name="frmSearch" method="post" action="">
                    <input type="text" id="txtKeyword" name="txtKeyword" value="<?php echo $strKeyword;?>" placeholder="Search" >
                    <button class="btn btn-primary" type="submit"><i class="fa fa-lg fa-fw fa-search"></i></button>
                  </form>
                </div> 
              </div>  
            </div>

            <div class="tile-body">
              <div class="table-responsive">

             
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
                
                $query = "SELECT * FROM user_detail WHERE username LIKE '%".sql_esc($strKeyword)."%' or user_fullname LIKE '%".sql_esc($strKeyword)."%'
                            or staff_ID LIKE '%".sql_esc($strKeyword)."%'";
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
                $query .= "ORDER BY user_no ASC LIMIT  ".sql_num($row_start).','.$per_page;
                $rs = mysqli_query($dbc,$query);
                
                    
                  if ($num_rows > 0) {
         
                 /* echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>'; */
                   
              ?>

              <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>No.</th> 
                      <th>Name</th>
                      <th>Staff ID</th>
                      <th>Status</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  
                  $counter = 1;
                  /* $no = 1; */

                  $no_idx = $row_start + 1;

                  while($row = mysqli_fetch_array($rs))
                  {
    
                    $user_no = $row["user_no"]; 
    
    
                    if($row["status"] == "AC")
                    {
                      $sts = "Active";
                    }
                    else{
                      $sts = "Inactive";
                    }
    
                    $query4_p = "SELECT * FROM level_detail WHERE id_level = '".sql_esc($row["level_id"])."'";
                    $result4_p = mysqli_query($dbc,$query4_p);
                    $row4_p = mysqli_fetch_array($result4_p);
    
                  ?>

                    <tr>
                      <td><?php echo $no_idx; ?>.</td>
                      <td><?php echo html_esc($row["user_fullname"]); ?></td>
                      <td><?php echo html_esc($row["staff_ID"]); ?></td>
                      <td><?php echo $sts; ?></td>
                      <td> 
                        <a href="#myNoteUser<?php echo html_esc($user_no); ?><?php echo html_esc($row["staff_ID"]); ?>" data-toggle="modal" class="btn btn-success btn-sm"  target="_parent" title="View details"><i class="fa fa-bars" aria-hidden="true"></i>View</a>
                        
                        <!--------------------------modal------------------------->
                        <?php include "detail_user.php";   ?>

                        <a href="javascript:;" onclick="window.location.href='edit_user_detail.php?usrNo=<?php echo html_esc($user_no);?>&&usrId=<?php echo html_esc($row['staff_ID']);?>';" class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>

                        <?php
                        if($row["status_failed"] == "Y")
                        {
                        ?>
                          <a href="#myNoteLock<?php echo html_esc($user_no); ?><?php echo html_esc($row["staff_ID"]); ?>" data-toggle="modal"  class="btn btn-success btn-sm" target="_parent" title="Unlock User"><i class="fa fa-lock" aria-hidden="true"></i>Unlock</a>
                                
                          <!--------------------------modal------------------------->
                          <?php   include "unlock_pass_account.php";  
                      
                        }else{ 
                        ?>       
                          <a href="#myNoteLockZA<?php echo html_esc($user_no); ?><?php echo html_esc($row["staff_ID"]); ?>" data-toggle="modal"  class="btn btn-dark btn-sm" target="_parent" title="Lock User"><i class="fa fa-unlock" aria-hidden="true"></i>Lock</a>
                                
                          <!--------------------------modal------------------------->
                          <?php    include "lock_pass_account.php";   
                              
                        }
                        ?>

                      </td>
                    </tr>

                    <?php 		  
                      /* $no++; 
                      $counter++;*/ // menambah counter
                      $no_idx++;
                    }  
                    ?>

                  </tbody>
                </table>
                <br>

                <!-- Pagination -->
<div class="d-flex justify-content-between">
  
  <div>
    <?php echo '<div align="center">There are currently  '. $num_rows.' record(s)</div>'; ?>
  </div>

  <div>
    
    <?php

    $strKeyword  = urlencode($strKeyword);


    if($prev_page)
    {   
      echo "<div class='pagin'>";
      echo " <a href='display_user.php?Page=$prev_page&txtKeyword=$strKeyword' class='pagin'>Previous</a> ";
      echo "</div>";
    }

    for($i=1; $i<=$num_pages; $i++){
      if($i != $page)
      {   
          if($i < 5)
          {
            echo "<div class='pagin'>";
            echo "<a href='display_user.php?Page=$i&txtKeyword=$strKeyword' class='pagin'> $i </a> ";
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
      echo " <a href ='display_user.php?Page=$next_page&txtKeyword=$strKeyword' class='pagin'> Next </a> ";
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
        <td><div align="center"><font color="#FF0000"><strong>There are currently no record.</strong></font></div></td>
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