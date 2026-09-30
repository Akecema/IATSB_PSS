<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
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
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
    $url = "detail_PRD_cancel_bflush.php";
	
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

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);

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
div.dataTables_wrapper {
        width: 1000px;
        margin: 0 auto;
    }
</style>   
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
     <?php   include "top_modal_menu.php";   ?>
    
   
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php   include "left_prod_menu.php";   ?>
   
    <main class="app-content">
    
  
      <div class="app-title">
        <div>
          <h1><i class="fa fa-file-text-o"></i> Production</h1>
          <p>Cancellation</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Production</li>
          <li class="breadcrumb-item"><a href="detail_PRD_cancel_bflush.php">Cancellation</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Cancellation </h3>
            <div class="tile-body">
              <div class="table-responsive">
               <ul class="nav nav-tabs">
               <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="detail_PRD_cancel_bflush.php">Cancellation </a></li>
               <li class="nav-item"><a class="nav-link" href="detail_PRD_afcancel_bflush.php">Cancelled</a></li>
                          
              </ul>    
          <?php
		  
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
        	$trans_opt = $_GET["trans_opt"]; 
			$plant_code = $_GET["plant_code"]; 
			$work_center = $_GET["work_center"];
			$material_no = $_GET["material_no"];
		
			
			if($_GET["trans_opt"] == "BFOK")
			 
			 {
				 
			echo "<script>";
            echo "window.location='canC_bf_tran_OK-prdProc.php?plant_code=".html_esc($plant_code)."&&trans_opt=".html_esc($trans_opt)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
			 }
			 elseif($_GET["trans_opt"] == "BFPEND")
			 {
				 
			echo "<script>";
            echo "window.location='canC_bf_tran_PEND-prdProc.php?plant_code=".html_esc($plant_code)."&&trans_opt=".html_esc($trans_opt)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
			 }
			 elseif($_GET["trans_opt"] == "BFHWOK")
			 {
				 
			echo "<script>";
            echo "window.location='canC_bf_tran_HWOK-prdProc.php?plant_code=".html_esc($plant_code)."&&trans_opt=".html_esc($trans_opt)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
				 
			 }			 
			 elseif($_GET["trans_opt"] == "PENDCON")
			 {
				 
			echo "<script>";
            echo "window.location='canC_bf_pend_Confirm-prdProc.php?plant_code=".html_esc($plant_code)."&&trans_opt=".html_esc($trans_opt)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
				 
			 }elseif($_GET["trans_opt"] == "CONHWOK")
			 {
				 
			echo "<script>";
            echo "window.location='canC_bf_Confirm_Hwork-prdProc.php?plant_code=".html_esc($plant_code)."&&trans_opt=".html_esc($trans_opt)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
				 
			 }elseif($_GET["trans_opt"] == "CONRWK")
			 {
				 
			echo "<script>";
            echo "window.location='canC_bf_pend_Confirm_Rwork-prdProc.php?plant_code=".html_esc($plant_code)."&&trans_opt=".html_esc($trans_opt)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&work_center=".html_esc($work_center)."&&material_no=".html_esc($material_no)."'";
            echo "</script>";
            exit(); //quit the script	 
				 
				 
			 }else{
				 
				 
			 }
			
		  ?>    
              
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="3">&nbsp;</th>
            </tr>
            <tr>
               <th>Transaction :</th>
                <th colspan="3">
              <select name="trans_opt" id="trans_opt" class="form-control">
              <option value="NULL" placeholder="Select Process"> -- Select Process --</option>
              <option value="BFOK" <?php if($_GET["trans_opt"] == 'BFOK') { ?> selected="selected"<?php } ?>>Backflush OK</option>
              <option value="BFNG" <?php if($_GET["trans_opt"] == 'BFNG') { ?> selected="selected"<?php } ?>>Backflush NG</option>
              <option value="BFPEND" <?php if($_GET["trans_opt"] == 'BFPEND') { ?> selected="selected"<?php } ?>>Backflush PENDING</option>
              <option value="BFHWOK" <?php if($_GET["trans_opt"] == 'BFHWOK') { ?> selected="selected"<?php } ?>>Backflush HANDWORK</option>
              <option value="PENDCON" <?php if($_GET["trans_opt"] == 'PENDCON') { ?> selected="selected"<?php } ?>>Pending</option>
              <option value="CONHWOK" <?php if($_GET["trans_opt"] == 'CONHWOK') { ?> selected="selected"<?php } ?>>Handwork</option>
              <option value="CONRWK" <?php if($_GET["trans_opt"] == 'CONRWK') { ?> selected="selected"<?php } ?>>Rework</option>
              </select>    
     			</th>
              </tr>
             
             <tr>
            <th>Date From : <font color="#FF0000">*</font></th>
            <td>
           <?php
			     $dd1 = substr($_GET["date1"],8,2);
				 $mm1 = substr($_GET["date1"],5,2);
				 $yy1 = substr($_GET["date1"],0,4);
			?>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" >
		     </td>
             </tr>
             <tr>
              <th>Date To : <font color="#FF0000">*</font></th>
              <td><?php
			     $dd2 = substr($_GET["date2"],8,2);
				 $mm2 = substr($_GET["date2"],5,2);
				 $yy2 = substr($_GET["date2"],0,4);
			?>
             <input class="form-control" id="PSSDate2" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>" ></td>
              </tr>
              <tr>
            <th>Plant : </th>
            <td colspan="3">
           <select name="plant_code" class="form-control" onChange="getWorkCenter(this.value)">
                  <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
                  <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
                  <option value="<?php echo html_esc($row27["plant_code"]); ?>" <?php if($row27["plant_code"] == $_GET["plant_code"]) echo "selected"; ?>> <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo html_esc($row27["plant_desc"]); ?></option>
                  <?php
           }  ?>
                </select>
		     </td>
             </tr>
              <tr>
                <th>Line :</th>
                <th><div id="work_centerdiv"><select name="work_center" id="work_center" class="form-control" onChange="getMaterial(this.value)">
                  <option value="NULL" placeholder="Select Line"> -- Select Line --</option>
                   <?php
	               $query5 = new PreparedSql("SELECT * FROM work_center_detail WHERE plant_code = ? AND dept_acc = 'PRODUCTION' AND status_wc = 'Y' ORDER BY id_work ASC", [$_GET["plant_code"]]);
                   $result5 = db_query($dbc, $query5);
  
                   while($row5=mysqli_fetch_array($result5)) 
				    { 
				   
				   ?>
                  <option value="<?php echo html_esc($row5["id_work"]); ?>" <?php if($row5["id_work"] == $_GET["work_center"]) echo "selected"; ?>> <?php echo html_esc($row5["id_work"]),' - ',stripslashes($row5["wc_desc"]); ?></option>
                  <?php
                  }
				?> 
                </select></div></th>
              </tr>
               <tr>
                <th>Part Number :</th>
                <th><div id="mat_div"> <select name="material_no" id="material_no" class="form-control">
                  <option value="NULL" placeholder="Select Part Number"> -- Select Part Number --</option>
                                  </select></div></th>
              </tr>
              
              <tr>
                <th><input name="Submit25" type="submit" class="btn btn-info" id="button" value="SEARCH" />
                </th>
                <th colspan="3">&nbsp;</th>
              </tr>
            
                </table>
        </form>  
                   
        <?php
          // Prepare the date ranges safely
          $date1_final = DateTime::createFromFormat('d-m-Y', $_GET['date1'])->format('Y-m-d');
          $date2_final = DateTime::createFromFormat('d-m-Y', $_GET['date2'])->format('Y-m-d');

          // Build the WHERE clause
          $where_clauses = [];
          if (!empty($plant_code) && $plant_code !== "NULL") {
              $where_clauses[] = "pps.plant_code = ?";
          }
          if ($dateF !== "0000-00-00") {
              $where_clauses[] = "pps.date_posting >= ?";
          }
          if ($dateT !== "0000-00-00") {
              $where_clauses[] = "pps.date_posting <= ?";
          }
          if ($work_center !== "NULL") {
              $where_clauses[] = "pps.work_center = ?";
          }
          if ($material_no !== "NULL") {
              $where_clauses[] = "pps.material_no = ?";
          }

          // Combine all conditions into a single clause
          $where_sql = $where_clauses ? ' AND ' . implode(' AND ', $where_clauses) : '';

          // Prepare the SQL query with JOINs to get the model and work center data in one go
          $queryGR = "
            SELECT 
                pps.*,
                DATE_FORMAT(pps.date_posting, '%d-%m-%Y') AS R,
                (SELECT md.model_desc 
                FROM model_detail_tbl md 
                WHERE md.model_code = pps.model_code 
                  AND md.plant_code = pps.plant_code 
                  AND md.status_model = 'Y' 
                LIMIT 1) AS model_name,
                (SELECT wcd.wc_desc2 
                FROM work_center_detail wcd 
                WHERE wcd.id_work = pps.work_center 
                  AND wcd.status_wc = 'Y' 
                LIMIT 1) AS work_center_desc
            FROM 
                pps_detail_trn_fg_ng pps
            WHERE 
                pps.status_pps = ?
                $where_sql
            ORDER BY 
                pps.bflush_no ASC;
          ";

          // Prepare statement
          $stmt = $dbc->prepare($queryGR);
          if ($stmt === false) {
              die('Prepare failed: ' . $dbc->error);
          }

          $params = [$rst_sta7["status_desc"]];

          if (!empty($plant_code) && $plant_code !== "NULL") {
              $params[] = $plant_code;
          }
          if ($dateF !== "0000-00-00") {
              $params[] = $date1_final;
          }
          if ($dateT !== "0000-00-00") {
              $params[] = $date2_final;
          }
          if ($work_center !== "NULL") {
              $params[] = $work_center;
          }
          if ($material_no !== "NULL") {
              $params[] = $material_no;
          }

          // Bind parameters
          $stmt->bind_param(str_repeat('s', count($params)), ...$params);

          // Execute and get the result
          $stmt->execute();
          $result = $stmt->get_result();

          // Fetch and count the rows
          $num_rowsGR = $result->num_rows;
          // var_dump($num_rowsGR);
          // die();
          if ($num_rowsGR > 0) {
            echo '<div align="center">There are currently ' . $num_rowsGR . ' record(s).</div>';
            ?>
            <table class="table table-hover table-bordered" id="example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Model</th>
                        <th>Part Number</th>
                        <th>BF Doc. No.</th>
                        <th>Posting Date</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $counter = 1;
                $no4 = 1;
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td width="30"><?php echo $no4; ?></td>
                        <td width="80"><?php echo html_esc($row['model_name']); ?></td>
                        <td width="150"><?php echo html_esc($row['material_no']); ?></td>
                        <td width="150">
                          <a href="#" class="myNoteView" data-id="<?php echo htmlspecialchars($row['bflush_no']); ?>" data-toggle="modal" data-target="#myModal">
                              <b><?php echo html_esc($row['bflush_no']); ?></b>
                          </a>
                        </td>
                        <td width="100"><?php echo html_esc($row['R']); ?></td>
                        <td width="100"><?php echo intval($row['qty_NG']); ?></td>
                        <td width="150">
                            <a href="#" class="myNoteCancelBF" data-id="<?php echo html_esc($row['bflush_no']); ?>" data-toggle="modal" target="_parent">
                              <i class="fa fa-window-close" aria-hidden="true"></i> Cancellation
                            </a>
                        </td>
                    </tr>
                    <?php 
                    $no4++;
                    $counter++;
                }
                ?>
                </tbody>
            </table>
            <br>
            <?php
            $stmt->close();
          } else {
              ?>
              <center>
                  <table width="800" cellspacing="0" class="textboxred">
                      <tr> 
                          <td><div align="center"><font color="#FF0000"><strong>There are currently no record(s).</strong></font></div></td>
                      </tr>
                  </table>
              </center>
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
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content custom">
              <div class="modal-header">
                  <h5 class="modal-title" id="myModalLabel">Cancellation Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body" id="modalContent">
                  <!-- AJAX content will be loaded here -->
              </div>
          </div>
      </div>
    </div>
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content custom">
              <div class="modal-header">
                  <h5 class="modal-title" id="myModalLabel">Cancellation Backflush</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body" id="modalContent2">
                  <!-- AJAX content will be loaded here -->
              </div>
          </div>
      </div>
    </div>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Data table plugin-->
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <!--<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>-->
    <script type="text/javascript">$('#example').DataTable();</script>
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    
    
     <script type="text/javascript">
          
       $('#PSSDate').datepicker({
		defaultDate: new Date(),
		format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
	   $('#PSSDate2').datepicker({
		defaultDate: new Date(),   
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
    </script>
   <script language="javascript" type="text/javascript">
    $(document).ready(function() {
      $('#example').on('click', '.myNoteView', function() {
          $('#modalContent').html('');
          var id = $(this).data('id'); // Get the ID from the clicked link
          console.log(id);
          var date1 = $('#PSSDate').val();
          var date2 = $('#PSSDate2').val();
          var plant_code = $('#plant_code').val();
          var work_center = $('#work_center').val();
          var material_no = $('#material_no').val();
          
          // console.log(date1);
          // console.log(date2);
          // console.log(plant_code);
          // console.log(work_center);
          // console.log(material_no);
          // AJAX call to fetch data from the server
          $.ajax({
              url: 'detail_canC_bf_tran_NG_view.php', 
              type: 'POST',
              data: {
                  id: id,
                  date1: date1,
                  date2: date2,
                  plant_code: plant_code,
                  work_center: work_center,
                  material_no: material_no
              },
              success: function(response) {
                console.log(response);
                // Load the response into the modal body
                $('#modalContent').html(response);
                $('#myModal').modal('show'); // Show the modal
              },
              error: function() {
                  alert('Failed to load content.');
              }
          });
      });
      $('#example').on('click', '.myNoteCancelBF', function() {
        $('#modalContent').html('');
        var id = $(this).data('id'); // Get the ID from the clicked link
        console.log(id);
        var date1 = $('#PSSDate').val();
        var date2 = $('#PSSDate2').val();
        var plant_code = $('#plant_code').val();
        var work_center = $('#work_center').val();
        var material_no = $('#material_no').val();
          
        // AJAX call to fetch data from the server
        $.ajax({
            url: 'cancel_bf_tran_NGprd_sel.php', 
            type: 'POST',
            data: {
              id: id,
              date1: date1,
              date2: date2,
              plant_code: plant_code,
              work_center: work_center,
              material_no: material_no
            },
            success: function(response) {
              console.log(response);
              // Load the response into the modal body
              $('#modalContent').html(response);
              $('#myModal').modal('show'); // Show the modal
            },
            error: function() {
                alert('Failed to load content.');
            }
        });
      });
      $(document).on('click', '.can_BFNGbtn', function () {
        const formData = $('#frmCancel').serialize(); // Serialize form data if needed
        // console.log(formData);
        $.ajax({
            url: 'cancel_bf_tran_NGprd_sel.php',
            method: 'POST',
            data: {
              action: 'can_BFNGbtn',
              formData: formData,
            },
            success: function (response) {
              console.log(response);
              try {
                  const result = JSON.parse(response);

                  if (result.status === 'success') {
                      alert(result.message);
                      if (result.redirect) {
                          window.location.href = result.redirect;
                      }
                  } else {
                      alert('Error: ' + result.message);
                  }
              } catch (e) {
                  console.error('Invalid JSON response:', response);
                  alert('An unexpected error occurred. Please try again.');
              }
            },
            error: function () {
                alert('An error occurred while processing the request.');
            },
        });
      });
    });
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
	
	function getWorkCenter(plant_code) {		
		
		var strURL="findPlant4Can.php?plant_code="+plant_code;
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
	
	function getMaterial(work_center) {		
		
		var strURL="findMaterial4Can.php?work_center="+work_center;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('mat_div').innerHTML=req.responseText;						
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