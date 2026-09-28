<?php
    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "type_wastage_table.php"; 
	
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

$id_wastage = $_POST['id_wastage'];
$status_wastage = $_POST['status_wastage'];
$wastage_desc = $_POST['wastage_desc'];

$message = NULL; // create an empty new variable.


 //$size = count($_POST["id_dtl"]) + 1;
 
  $i = 1;

//------------------------------end function --------------------------------
// check for a wastage_desc.
if (empty($_POST['wastage_desc']))
{ $wastage_desc = FALSE;
  
  }else
  { $wastage_desc = addslashes($_POST['wastage_desc']);
  }
  
// check for a status
if (empty($_POST['status_wastage'])) 
{ 
  $status_wastage = FALSE;
 
  }
    else
  { $status_wastage = addslashes($_POST['status_wastage']);
  }

   
 if($wastage_desc && $status_wastage) //everything ok
{     	
		  	  $query_search = "SELECT * FROM type_wastage_detail WHERE id_wastage = '".sql_esc($id_wastage)."'";
              $result_search = mysqli_query($dbc,$query_search);   //run the query.
              $num_search = mysqli_num_rows($result_search);   //how many suppliers are there?
			  
			  if($num_search == 1) {
			  //echo $num_search; 
			    $row = mysqli_fetch_array($result_search);
				// make the update query
	
		$query_upd = "UPDATE type_wastage_detail SET wastage_desc = '".sql_esc($wastage_desc)."', status_wastage = '".sql_esc($status_wastage)."' WHERE id_wastage = '".sql_esc($id_wastage)."'"; 
		$result_upd = mysqli_query($dbc,$query_upd); 
								
			if($result_upd)
			{
			 echo "<script>";
		     echo "alert('Type Wastage is successfully update.');";
			 echo "window.location='type_wastage_table.php'";
		     echo "</script>"; 
		     exit(); //quit the script
			
							
  } else { echo 'Cannot update record'; 
  }
}
//print the message if there is one.
	  
} 
} 
 ?> 
  <div class="modal fade" id="myNoteEdit<?php echo html_esc($row2["id_wastage"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
         <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Type of Wastage</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Type of Wastage</strong>
       </div>
      <?php

$query_was = "SELECT * FROM type_wastage_detail WHERE id_wastage = '".sql_esc($row2["id_wastage"])."'";
$result_was = mysqli_query($dbc,$query_was);   //run the query.
$row_was = mysqli_fetch_array($result_was);   //how many records are there?
     
   ?>
    <form name="formEdit" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" class="needs-validation"  novalidate>
   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">ID Wastage </td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="id_wastage" name="id_wastage" readonly value="<?php  echo html_esc($row_was["id_wastage"]); ?>" class="form-control"></td>
    </tr>
  <tr>
    <td>Type Wastage Description <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td><input type="text" id="wastage_desc" name="wastage_desc" value="<?php echo html_esc($row_was["wastage_desc"]); ?>" class="form-control" required /><div class="invalid-feedback">Please enter type wastage description.</div></td>
    </tr>
    <tr>
    <td>Status <font color="#FF0000">*</font></td>
    <td>:</td>
    <td>
      <select name="status_wastage"  class="form-control" required>
      <option value="" placeholder="Select Status"> -- Select Status --</option>
	  <option value="Y" class="title" <?php if($row_was["status_wastage"] == 'Y') echo "selected"; ?>>Y - Active</option>
	  <option value="N" class="title" <?php if($row_was["status_wastage"] == 'N') echo "selected"; ?>>N - Inactive</option>
	  </select><div class="invalid-feedback">Please select status wastage.</div>
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
             <input type="hidden" id="id_wastage" name="id_wastage"  class="form-control" value="<?php echo html_esc($row2["id_wastage"]);  ?>" >  
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