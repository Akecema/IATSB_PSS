<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "con_detail_table.php"; 
	
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
  <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
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
if (isset($_POST['Submit19']))
{

$id_con = $_POST['id_con'];
$material_no = $_POST['material_no'];
$mat_desc = $_POST['mat_desc'];
$cost_center = $_POST['cost_center'];
$plant = $_POST['plant'];
$BUn = $_POST['BUn'];
$con_status = $_POST['con_status'];

$message = NULL; // create an empty new variable.


//------------------------------end function --------------------------------
// check for a material No.
if (empty($_POST['material_no']))
{ $material_no = FALSE;
 
  }else
  { $material_no = addslashes($_POST['material_no']);
  }
  
// check for a material Desc
if (empty($_POST['mat_desc']))
{ $mat_desc = FALSE;
  
  }
    else
  { $mat_desc = addslashes($_POST['mat_desc']);
  }
  
// check for a plant code
if (empty($_POST['plant']))
{ $plant = FALSE;
 
  }
    else
  { $plant = addslashes($_POST['plant']);
  }

// check for a cost center
if (empty($_POST['cost_center']))
{ $cost_center = FALSE;
 
  }
  else
  { $cost_center = addslashes($_POST['cost_center']);
  }

// check for BUn
if (empty($_POST['BUn']) || ($_POST['BUn'] == "NULL"))
{ $BUn = FALSE;

  }
  else
  { $BUn = addslashes($_POST['BUn']);
  }

// check for con sstatus
if (empty($_POST['con_status']) || ($_POST['con_status'] == "NULL"))
{ $con_status = FALSE;
 
  }
  else
  { $con_status = addslashes($_POST['con_status']);
  }
  
  //---------------------------------------------------------------------------------------
  // material component 
  //----------------------------------------------------------------------------------------

   
 if($id_con && $material_no && $mat_desc && $plant && $cost_center && $BUn && $con_status) //everything ok
{     	
		  	  $query_search = "SELECT * FROM consumable_detail WHERE id_con = '".sql_esc($id_con)."'";
              $result_search = mysqli_query($dbc,$query_search);   //run the query.
              $num_search = mysqli_num_rows($result_search);   //how many suppliers are there?
			  
			  if($num_search == 1) {
			  //echo $num_search; 
			    $row = mysqli_fetch_array($result_search);
				// make the update query
	
		$query_upd = "UPDATE consumable_detail SET mat_desc = '".sql_esc($mat_desc)."', cost_center = '".sql_esc($cost_center)."', plant = '".sql_esc($plant)."', BUn = '".sql_esc($BUn)."', con_status = '".sql_esc($con_status)."' WHERE id_con = '".sql_esc($id_con)."'"; 
		$result_upd = mysqli_query($dbc,$query_upd); 
								
			if($result_upd)
			{
			 echo "<script>";
		     echo "alert('Consumable is successfully update.');";
		     echo "window.location='con_detail_table.php'";
	         echo "</script>"; 
		     exit(); //quit the script
			
							
  } else { echo 'Cannot update record'; 
  }
}
//print the message if there is one.
	  
} 

} 
 ?> 
  <div class="modal fade" id="myNoteEdit<?php echo $row2["id_con"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
         <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Consumable Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Consumable Details</strong>
       </div>
      <?php

$query_con = "SELECT * FROM consumable_detail WHERE id_con = '".sql_esc($row2["id_con"])."'";
$result_con = mysqli_query($dbc,$query_con);   //run the query.
$row_con = mysqli_fetch_array($result_con);   //how many records are there?
     
   ?> 
   <form name="formEdit" method="post" action="" class="needs-validation"  novalidate>
   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">Material No. <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="material_no" name="material_no" readonly value="<?php  echo $row_con["material_no"]; ?>" class="form-control" required /></td>
    </tr>
  <tr>
    <td>Material Description <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td><input type="text" id="mat_desc" name="mat_desc" value="<?php echo $row_con["mat_desc"]; ?>" class="form-control" required /><div class="invalid-feedback">Please enter material description.</div></td>
    </tr>
  <tr>
    <td>Plant Code <font color="#FF0000">*</font></td>
    <td>:</td>
    <td><input type="text" id="plant" name="plant" value="<?php echo $row_con["plant"];  ?>" class="form-control" required />
     <div class="invalid-feedback">Please enter plant code.</div>
     </td>
    </tr>
  <tr>
    <td>Cost Center <font color="#FF0000">*</font></td>
    <td>:</td>
    <td><input type="text" id="cost_center" name="cost_center"  value="<?php echo $row_con["cost_center"];  ?>" class="form-control" required /><div class="invalid-feedback">Please enter cost center.</div>
     </td>
    </tr>
      <tr>
    <td>BUn <font color="#FF0000">*</font></td>
    <td>:</td>
   <td>
   <?php		
    echo '<select name="BUn" class="form-control" required>
       <option value=""> --Select UOM -- </option>';
  
	  //Retrieve and display the available types
	  $query_unit = 'Select * from uom_con WHERE status_uom = "Y"';
	  $result_unit = mysqli_query($dbc,$query_unit);
  
		 while($row_unit = mysqli_fetch_array($result_unit)) {
		 ?>
				   <!--RETAIN VALUE-->
	   <option value="<?php echo $row_unit["UOM"]; ?>" <?php if($row_unit["UOM"] == $row_con["BUn"]) echo "selected"; ?>> <?php echo $row_unit["UOM"]; ?></option>
				   <?php }
             
	 
	  	//complete the form
	
	echo '</select>';

	?>
     <div class="invalid-feedback">Please select BUn.</div></td>
    </tr>
     <tr>
    <td>Status <font color="#FF0000">*</font></td>
    <td>:</td>
    <td> <select name="con_status"  class="form-control" required>
      <option value="" placeholder="Select Status"> -- Select Status --</option>
	  <option value="Y" class="title" <?php if($row_con["con_status"] == 'Y') echo "selected"; ?>>Y - Active</option>
	  <option value="N" class="title" <?php if($row_con["con_status"] == 'N') echo "selected"; ?>>N - Inactive</option>
	  </select>
      <div class="invalid-feedback">Please select status account.</div>
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
             <input type="hidden" id="id_con" name="id_con"  class="form-control" value="<?php echo $row2["id_con"];  ?>" >  
             <input name="Submit19" type="submit" id="submit9" value="UPDATE" class="btn btn-info" onClick="return confirm('Confirm to update?');" >             
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