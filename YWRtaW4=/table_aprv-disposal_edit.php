<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "display_setup_disposal_aprv_tbl.php"; 
	
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

	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?>">
    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    
    <script>
    (function() {
    'use strict';
    window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
    form.addEventListener('submit', function(event) {
    if (form.checkValidity() === false) {
    event.preventDefault();
    event.stopPropagation();
    }
    form.classList.add('was-validated');
    }, false);
    });
    }, false);
    })();
    
    </script>
	<SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  </head>
  <body class="app sidebar-mini">

<?php
if (isset($_POST['submit91']))
{
    $id_apprv = $_POST['id_apprv'];
	$apprv_name = $_POST['apprv_name'];
	$apprv_name2 = $_POST['apprv_name2'];
	$code_aprv = $_POST['code_aprv'];
	$status_apprv = $_POST['status_apprv'];

$message = NULL; // create an empty new variable.

$i = 1;

//------------------------------end function --------------------------------
// check for a $apprv_name
if (empty($_POST['apprv_name'])) 
{ 
  $apprv_name = FALSE;
   }
    else
  { $apprv_name = addslashes($_POST['apprv_name']);
  }

  
// check for a $apprv_name2
if (empty($_POST['apprv_name2'])) 
{ 
  $apprv_name2 = FALSE;
   }
    else
  { $apprv_name2 = addslashes($_POST['apprv_name2']);
  }


   
 if($apprv_name && $apprv_name2) //everything ok
{     

	$id_apprv = $_POST['id_apprv'];
	$apprv_name = $_POST['apprv_name'];
	$apprv_name2 = $_POST['apprv_name2'];
	$code_aprv = $_POST['code_aprv'];
	$status_apprv = $_POST['status_apprv'];
	
		  	  $query_search = "SELECT * FROM function_apprv_detail WHERE id_apprv = '".sql_esc($id_apprv)."'";
              $result_search = mysqli_query($dbc,$query_search);   //run the query.
              $num_search = mysqli_num_rows($result_search);   //how many suppliers are there?
			  
			  if($num_search == 1) {
			  //echo $num_search; 
			    $row = mysqli_fetch_array($result_search);
				// make the update query
	
	$query_upd = "UPDATE function_apprv_detail SET apprv_name = '".sql_esc($apprv_name)."', apprv_name2 = '".sql_esc($apprv_name2)."' WHERE id_apprv = '".sql_esc($id_apprv)."'"; 
	$result_upd = mysqli_query($dbc,$query_upd); 
								
			if($result_upd)
			{
			 echo "<script>";
		     echo "alert('Table Approval Disposal is successfully update.');";
			 echo "window.location='display_setup_disposal_aprv_tbl.php'";
			 echo "</script>"; 
		     exit(); //quit the script
			
							
  } else { echo 'Cannot update record'; 
  }
}
//print the message if there is one.
	  
} 
} 
 ?> 
  <div class="modal fade" id="myNoteEditM<?php echo html_esc($row["id_apprv"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">   
        <!-- <div class="modal-dialog" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;" > -->     
         <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Table Approval Disposal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Table Approval Disposal</strong>
       </div>
      <?php
	 
$query_modA = "SELECT * FROM function_apprv_detail WHERE id_apprv = '".sql_esc($row["id_apprv"])."'";
$result_modA = mysqli_query($dbc,$query_modA);   //run the query.
$row_modA = mysqli_fetch_array($result_modA);   //how many records are there?


   //----status info ---
   
   if($row_modA["status_apprv"] == 'Y')
   {
	   $status_new = "Active";
   }else{
	   
	    $status_new = "In Active";
   }


     
   ?>
    <form name="formEdit" method="post" action="" class="needs-validation"  novalidate>
   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">ID</td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="id_apprv" name="id_apprv" readonly value="<?php  echo html_esc($row_modA["id_apprv"]); ?>" class="form-control" ></td>
    </tr>
     <tr>
    <td width="191">Initial Approval </td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="apprv_name" name="apprv_name" value="<?php  echo html_esc($row_modA["apprv_name"]); ?>" class="form-control" required><div class="invalid-feedback">Please enter Initial Approval.</div></td>
    </tr>
  <tr>
    <td>Initial Approval2 <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td><input type="text" id="apprv_name2" name="apprv_name2" value="<?php echo html_esc($row_modA["apprv_name2"]); ?>" class="form-control" required /><div class="invalid-feedback">Please enter Initial Approval2.</div></td>
    </tr>
   
    <tr>
    <td>Status <font color="#FF0000">*</font></td>
    <td>:</td>
    <td> <input type="text" id="status_apprv" name="status_apprv" readonly value="<?php  echo $status_new; ?>" class="form-control" >
	
	</td>
    </tr>
    <tr>
    <td><font color="#FF0000"><b>  * Compulsory field</b></font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
   </table>                         
       </div> <!-- card -->
       </div><!-- /# card -->
       <br />

              
              <div class="modal-footer"> 
             <input type="hidden" id="code_aprv" name="code_aprv"  class="form-control" value="<?php echo html_esc($row["id_apprv"]);  ?>" >  
             <input name="submit91" type="submit" id="submit91" value="UPDATE" class="btn btn-info" onClick="return confirm('Confirm to update?');" > 
             <button type="button" class="btn btn-success" data-dismiss="modal">CLOSE</button>
             </div>  
            
    </form>  
                  </div></div>
                  </div>
                  </div>
                  </div>
                  </div>
</body>
</html>