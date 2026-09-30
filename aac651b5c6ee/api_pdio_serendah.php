<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include __DIR__ . '/config.php';

set_time_limit(0);

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
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);


    $url = "api_pdio_serendah.php";

//CR status (New)

$sta = "SELECT * from request_status WHERE status_id = '1'";
$sta_res = mysqli_query($dbc,$sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2'";
$sta_res2 = mysqli_query($dbc,$sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>



    <!-- jQuery library -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->

<!-- Bootstrap library -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
-->

    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";
	}
	</script>
    
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
          <h1><i class="fa fa-th-list"></i> Delivery</h1>
          <p>Upload PDIO (API)</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Delivery</li>
          <li class="breadcrumb-item"><a href="api_pdio_serendah.php">Upload PDIO (API)</a></li>
        </ul>
      </div>

              <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link" href="ups_pdio_serendah.php">Upload PDIO</a></li>
                 <li class="nav-item"><a class="nav-link"  href="view_pdio_serendah-dlv.php">View Upload PDIO</a></li>
                 <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="api_pdio_serendah.php">Upload PDIO (API)</a></li>
                 <li class="nav-item"><a class="nav-link"  href="view_API_serendah-dlv.php">View Upload PDIO (API)</a></li>

              </ul>

        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Pull PDIO from Perodua API</h3>
            <div class="tile-body">

         <form action="api_pdio_trigger.php" method="post" class="needs-validation" novalidate>
            <table class="table table-bordered">
             <tr>
              <th width="31%">Production Date : <font color="#FF0000">*</font></th>
              <td colspan="2">
                <input class="form-control" type="date" name="pull_date" value="<?php echo date('Y-m-d'); ?>" required />
              </td>
             </tr>
             <tr>
              <th>Organization : <font color="#FF0000">*</font></th>
              <td colspan="2">
                <label class="mr-3"><input type="checkbox" name="organizations[]" value="PMSB" checked> PMSB (PM* - PERODUA MANUFACTURING SDN BHD)</label>
                <br>
                <label><input type="checkbox" name="organizations[]" value="PGMSB" checked> PGMSB (PG* - PERODUA GLOBAL MANUFACTURING SDN. BHD.)</label>
              </td>
             </tr>
             <tr>
              <th>PDIO Number (optional):</th>
              <td colspan="2">
                <input class="form-control" type="text" name="pdio_number" placeholder="Leave blank to pull the whole day" />
              </td>
             </tr>
             <tr>
              <th><button type="submit" name="triggerPdioPull" class="btn btn-primary" id="pullApiBtn">PULL FROM API</button></th>
              <th colspan="2">&nbsp;</th>
             </tr>
            </table>
         </form>

            </div>
          </div>
         </div>
         </div>

<?php if (isset($_GET['pulled_date']) && DateTime::createFromFormat('Y-m-d', $_GET['pulled_date'])) {
    $pulledDate = $_GET['pulled_date'];
    $listStmt = $dbc->prepare(
        "SELECT pdio_no, order_no, back_no, material_no, material_no_sap, material_desc,
                pdio_qty, uom_pdio, trip_no, dlv_date, status_pdio, cust_code
         FROM dlv_upload_pdio
         WHERE prod_date = ? AND file_name LIKE 'API_%'
         ORDER BY pdio_no, back_no"
    );
    $listStmt->bind_param('s', $pulledDate);
    $listStmt->execute();
    $listResult = $listStmt->get_result();
?>
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Data Pulled for <?php echo htmlspecialchars($pulledDate); ?> (<?php echo $listResult->num_rows; ?> line(s) currently in dlv_upload_pdio)</h3>
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>PDIO No.</th>
                      <th>Customer</th>
                      <th>Order No.</th>
                      <th>Back No.</th>
                      <th>Part No.</th>
                      <th>Part No. (SAP)</th>
                      <th>Part Name</th>
                      <th>Qty</th>
                      <th>Unit</th>
                      <th>Trip</th>
                      <th>Delivery Date/Time</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
<?php if ($listResult->num_rows === 0) { ?>
                    <tr><td colspan="12"><div align="center">No rows found for this date - check pdio_api_debug.log if you expected data here.</div></td></tr>
<?php } else { while ($rowL = $listResult->fetch_assoc()) { ?>
                    <tr>
                      <td><?php echo htmlspecialchars($rowL['pdio_no']); ?></td>
                      <td><?php echo htmlspecialchars($rowL['cust_code']); ?></td>
                      <td><?php echo htmlspecialchars($rowL['order_no']); ?></td>
                      <td><?php echo htmlspecialchars($rowL['back_no']); ?></td>
                      <td><?php echo htmlspecialchars($rowL['material_no']); ?></td>
                      <td><?php echo htmlspecialchars($rowL['material_no_sap']); ?></td>
                      <td><?php echo htmlspecialchars($rowL['material_desc']); ?></td>
                      <td><?php echo htmlspecialchars($rowL['pdio_qty']); ?></td>
                      <td><?php echo htmlspecialchars($rowL['uom_pdio']); ?></td>
                      <td><?php echo htmlspecialchars($rowL['trip_no']); ?></td>
                      <td><?php echo htmlspecialchars($rowL['dlv_date']); ?></td>
                      <td>
<?php
    $statusBadge = 'badge-secondary';
    if ($rowL['status_pdio'] === 'Approved') { $statusBadge = 'badge-success'; }
    elseif ($rowL['status_pdio'] === 'Draft') { $statusBadge = 'badge-warning'; }
    elseif ($rowL['status_pdio'] === 'New') { $statusBadge = 'badge-info'; }
?>
                        <span class="badge badge-pill <?php echo $statusBadge; ?>"><?php echo htmlspecialchars($rowL['status_pdio']); ?></span>
                      </td>
                    </tr>
<?php } } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
         </div>
         </div>
<?php } ?>

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
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>

     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
<!--    <script type="text/javascript" src="js/plugins/sweetalert.min.js"></script>
-->
     <script type="text/javascript">


      $('#PlanDate').datepicker({
	    defaultDate: new Date(),
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });

	   $('#Plan2Date').datepicker({
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });

      
    </script>
<script>
		(function () {
		  'use strict'

		  // Fetch all the forms we want to apply custom Bootstrap validation styles to
		  var forms = document.querySelectorAll('.needs-validation')

		  // Loop over them and prevent submission
		  Array.prototype.slice.call(forms)
			.forEach(function (form) {
			  form.addEventListener('submit', function (event) {
				if (!form.checkValidity()) {
				  event.preventDefault()
				  event.stopPropagation()
				}

				form.classList.add('was-validated')
			  }, false)
			})
		})()
	</script>


  </body>
</html>
