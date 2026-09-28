<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
include 'tzone-config.php';
include 'status-config.php';

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "3")) {
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
	
	
	
$url = "ups_pdio_iatsb.php"; 

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
    <script language="javascript">
	$('.datepicker').pickadate({
	weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
	showMonthsShort: true
	})
	</script>
  </head>
  
  <body class="app sidebar-mini">
    <!-- Navbar-->
      <?php   include "top_modal_menu.php";   ?>
    
    
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php   include "left_ppc_menu.php";   ?>
  
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Delivery</h1>
          <p>Upload PDIO</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Delivery</li>
          <li class="breadcrumb-item"><a href="ups_pdio_sgchoh.php">Upload PDIO</a></li>
        </ul>
      </div> 
      
              <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="ups_pdio_sgchoh.php">Upload PDIO</a></li>
                 <li class="nav-item"><a class="nav-link"  href="view_pdio_sgchoh-dlv.php">View Upload PDIO</a></li>
               
              </ul>
                         
       <?php

	   $message = ""; 

?>
      
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Upload PDIO</h3>
            <div class="tile-body">
         <?php echo $message; ?></div>

         <form action="ups_pdio_sgchoh01.php" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
         
       
         <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="2">&nbsp;</th>
            </tr>
             <tr>
            <th>Shipping Point : <font color="#FF0000">*</font></th>
            <td colspan="2">
           <input class="form-control" id="ship_point" type="text" placeholder="Enter Shipping Point" name="ship_point" value="<?php if(isset($_POST['ship_point'])){ echo $_POST['ship_point']; }else{ echo "2302 - SG. CHOH";   } ?>" readonly required />
         
		     </td>
             </tr>
             <tr>
              <th><label class="col-lg-4 col-form-label" for="validationcust">Customer : <font color="#FF0000">*</font> </label>  
                                                    </th>
              <td colspan="2">
                  <select name="cust_code" id="validationcust" class="form-control" required>
                  <option value="" placeholder="Select Customer"> -- Select Customer --</option>
                  <?php
				  
	               $query19 = "SELECT * FROM cust_detail WHERE cust_ID = 'PERODUA' AND status_cust = 'Y' ORDER BY id_cust ASC";
                   $result19 = mysqli_query($dbc,$query19);
  
                   while($row19 = mysqli_fetch_array($result19)) 
			      {
				   ?>
                     <option value="<?php echo $row19["id_cust"]; ?>"> <?php echo $row19["id_cust"]; ?> - <?php echo $row19["cust_desc"]; ?></option>
                
                  <?php
                  }
				?>
              </select><div class="invalid-feedback"><span class="badge badge-pill badge-danger">Please select Customer Code.</span>
														</div>
              </td>
              </tr>
            
              <tr>
                <th><label class="col-lg-4 col-form-label" for="validationfile">Select File :<font color="#FF0000">*</font></label></th>
                
                <td>
                    <input name="upload" id="validationfile" type="file" class="form-control-file" value="<?php if(isset($_POST['upload'])) echo $_POST['upload']; ?>" maxlength="200" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required /> 
                    <br>                 
                    <div class="invalid-feedback"><span class="badge badge-pill badge-danger"> Error! Please Select File.</span>	</div>
                   <br>
                    <label><input type="checkbox" id="checkA" value="checkA" name="checkA">Test Upload</label>
                   
                 </td>
             
              </tr>
             
              <tr>
                
                <th><input name="ResetPDIO" type="reset" id="Reset" class="btn btn-warning" value="RESET">


                <button type="submit" name="submitPDIO" class="btn btn-primary" id="submit">UPLOAD</button>

                <!-- <input name="submitPDIO" type="submit" class="btn btn-primary " id="button" value="UPLOAD" /> --></th>
                <th colspan="2">&nbsp;</th>
              </tr>
            
                </table>
        </form> 
            
            
            
              
              
              
            
              
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
	  
      $('#demoSelect').select2();
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