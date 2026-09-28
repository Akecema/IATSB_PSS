<?php
    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "display_setup_shiftday.php"; 
	
//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	

//--------menu function ------------------------------

$query_function = new PreparedSql("SELECT * FROM function_acc_detail WHERE staff_ID = ?", [$res["staff_ID"]]);
$result_function = db_query($dbc, $query_function);   //run the query.
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
 
 if (isset($_POST['submit9']))
{

$id_shift = $_POST['id_shift'];
$shift_cd = $_POST['shift_cd'];
$time_start = $_POST['time_start'];
$time_end = $_POST['time_end'];

$message = NULL; // create an empty new variable.
	

	$i = 1;


	// check time start
	if(empty($_POST['time_start']))
	{ 
		$time_start = FALSE;
		
	}
	else
	{ 
		$time_start = addslashes($_POST['time_start']);
	}


	
	// check time end
	if(empty($_POST['time_end'])) 
	{ 
		$time_end = FALSE;
		
	}
	else
	{ 
		$time_end = addslashes($_POST['time_end']);
	}

   
	if($time_start && $time_end) //everything ok
	{    
	$id_shift = $_POST['id_shift']; 	
	$shift_cd = $_POST['shift_cd'];
	$time_start = $_POST['time_start'];
    $time_end = $_POST['time_end'];
	
		$query_search = "SELECT * FROM shift_detail WHERE id_shift = '".sql_esc($id_shift)."'";
		$result_search = mysqli_query($dbc,$query_search);   //run the query.
		$num_search = mysqli_num_rows($result_search);   //how many suppliers are there?
		
		if($num_search == 1) {
		//echo $num_search; 
		$row2 = mysqli_fetch_array($result_search);
		// make the update query
		
		$query_upd2 = "UPDATE shift_detail SET time_start = '".sql_esc($_POST['time_start'])."', time_end = '".sql_esc($_POST['time_end'])."' WHERE id_shift = '".sql_esc($id_shift)."'"; 
		$result_upd2 = mysqli_query($dbc,$query_upd2); 
		
						
		if($result_upd2)
		{
			echo "<script>";
			echo "alert('Shift Day is successfully updated.');";
			echo "window.location='display_setup_shiftday.php'";
			echo "</script>"; 
			exit(); //quit the script						
		} 
		else 
		{ 
			echo 'Cannot update record'; 
		}
	}
	//print the message if there is one.
		  
} 


} 
 ?> 
  <div class="modal fade" id="myNoteEditM<?php echo html_esc($row["id_shift"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
         <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Shift Day</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Shift Day</strong>
       </div>
      <?php

$query_was = "SELECT * FROM shift_detail WHERE id_shift = '".sql_esc($row["id_shift"])."'";
$result_was = mysqli_query($dbc,$query_was);   //run the query.
$row_was = mysqli_fetch_array($result_was);   //how many records are there?
     
   ?>
   <form name="formEdit" method="post" action="" class="needs-validation"  novalidate>
   <table width="100%" cellspacing="5">
    <tr>
    <td width="191">Shift Code <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="shift_cd" name="shift_cd" readonly value="<?php  echo html_esc($row_was["shift_cd"]); ?>" class="form-control"></td>
    </tr>
     <tr>
    <td width="191">Shift Description <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="shift_desc" name="shift_desc" readonly value="<?php  echo html_esc($row_was["shift_desc"]); ?>" class="form-control"></td>
    </tr>
   <tr>
    <td width="191">Time Start <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="time_start" name="time_start" value="<?php  echo html_esc($row_was["time_start"]); ?>" class="form-control" required><div class="invalid-feedback">Please enter time start.</div></td>
    </tr>
  <tr>
    <td>Time End <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td>
    
    <input type="text" id="time_end" name="time_end" value="<?php echo html_esc($row_was["time_end"]); ?>" class="form-control" required /><div class="invalid-feedback">Please enter time end.</div></td>
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
             <input type="hidden" id="id_shift" name="id_shift"  class="form-control" value="<?php echo html_esc($row["id_shift"]);  ?>" >  
             <input name="submit9" type="submit" id="submit9" value="UPDATE" class="btn btn-info" onClick="return confirm('Confirm to update?');" > 
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