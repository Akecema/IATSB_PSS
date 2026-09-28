<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "work_center_table.php"; 
	
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
if (isset($_POST['submit9']))
{

$id_work = $_POST['id_work'];
$id_hdr = $_POST['id_hdr'];
$wc_desc = $_POST['wc_desc'];
$cost_center = $_POST['cost_center'];
$cc_desc = $_POST['cc_desc'];
$plant_code = $_POST['plant_code'];
$id_factory = $_POST['id_factory'];
$dept_acc = $_POST['dept_acc'];
$status_wc = $_POST['status_wc'];
$wc_desc2 = $_POST['wc_desc2'];
$prod_cat = $_POST['prod_cat'];


//--------------------function escape data from form ------------------------
/*function escape_data ($data) {
global $dbc;   // need the connection.
if (ini_get('magic_quotes_gpc')) 
{
    $data = stripslashes($data);
	}
	return mysql_real_escape_string($data,$dbc);
	}   // end function.*/
$message = NULL; // create an empty new variable.


 //$size = count($_POST["id_dtl"]) + 1;
 
  $i = 1;

//------------------------------end function --------------------------------
// check for a wc_desc.
if (empty($_POST['wc_desc']))
{ $wc_desc = FALSE;
 
  }else
  { $wc_desc = addslashes($_POST['wc_desc']);
  }
  
// check for a plant code
if (empty($_POST['plant_code']))
{ $plant_code = FALSE;
 
  }
    else
  { $plant_code = addslashes($_POST['plant_code']);
  }

// check for a cost center
if (empty($_POST['cost_center']))
{ $cost_center = FALSE;
 
  }
  else
  { $cost_center = addslashes($_POST['cost_center']);
  }

// check for a cost center Desc
if (empty($_POST['cc_desc']))
{ $cc_desc = FALSE;
  
  }
    else
  { $cc_desc = addslashes($_POST['cc_desc']);
  }

// check for factory
if (empty($_POST['id_factory']) || ($_POST['id_factory'] == ""))
{ $id_factory = FALSE;
  
  }
  else
  { $id_factory = addslashes($_POST['id_factory']);
  }

// check for dept account
if (empty($_POST['dept_acc']) || ($_POST['dept_acc'] == ""))
  { $dept_acc = FALSE;
  
  }
  else
  { $dept_acc = addslashes($_POST['dept_acc']);
  }
  

// check for status account
if (empty($_POST['status_wc']) || ($_POST['status_wc'] == ""))
  { $status_wc = FALSE;
  
  }
  else
  { $status_wc = addslashes($_POST['status_wc']);
  }   
 
 
 // check for a wc_desc.
if (empty($_POST['wc_desc2']))
{ $wc_desc2 = FALSE;
 
  }else
  { $wc_desc2 = addslashes($_POST['wc_desc2']);
  }
  //---------------------------------------------------------------------------------------
  // material component 
  //----------------------------------------------------------------------------------------

   
 if($id_work && $wc_desc && $plant_code && $cost_center && $cc_desc && $id_factory && $dept_acc && $status_wc && $wc_desc2) //everything ok
{     	
		  	  $query_search = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($id_work)."'";
              $result_search = mysqli_query($dbc,$query_search);   //run the query.
              $num_search = mysqli_num_rows($result_search);   //how many suppliers are there?
			  
			  if($num_search == 1) {
			  //echo $num_search; 
			    $row = mysqli_fetch_array($result_search);
				// make the update query
	
		$query_upd = "UPDATE work_center_detail SET wc_desc = '".sql_esc($wc_desc)."', cost_center = '".sql_esc($cost_center)."', cc_desc = '".sql_esc($cc_desc)."', plant_code = '".sql_esc($plant_code)."', id_factory = '".sql_esc($id_factory)."', dept_acc = '".sql_esc($dept_acc)."', status_wc = '".sql_esc($status_wc)."', wc_desc2 = '".sql_esc($wc_desc2)."', prod_cat = '".sql_esc($prod_cat)."' WHERE id_work = '".sql_esc($id_work)."'"; 
		$result_upd = mysqli_query($dbc,$query_upd); 
								
			if($result_upd)
			{
			 echo "<script>";
		     echo "alert('Work Center is successfully update.');";
			 echo "window.location='work_center_table.php'";
			 echo "</script>"; 
		     exit(); //quit the script
			
							
  } else { echo 'Cannot update record'; 
  }
}
//print the message if there is one.
	  
} 

} 
 ?> 
  <div class="modal fade" id="myNoteEdit<?php echo $row2["id_work"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
         <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Work Center</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Work Center</strong>
       </div>
      <?php

$query_work = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($row2["id_work"])."'";
$result_work = mysqli_query($dbc,$query_work);   //run the query.
$row_work = mysqli_fetch_array($result_work);   //how many records are there?
     
   ?>
   <form name="formEdit" method="post" action="" class="needs-validation"  novalidate>
   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">Work Center</td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="id_work" name="id_work" readonly value="<?php  echo $row_work["id_work"]; ?>" class="form-control"></td>
    </tr>
  <tr>
    <td>Work Center Description <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td><input type="text" id="wc_desc" name="wc_desc" value="<?php echo $row_work["wc_desc"]; ?>" class="form-control" required /><div class="invalid-feedback">Please enter work center description.</div></td>
    </tr>
  <tr>
    <td>Plant Code <font color="#FF0000">*</font></td>
    <td>:</td>
    <td>
     <select name="plant_code" class="form-control" onChange="getWorkCenter(this.value)">
                  <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
                  <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
                  <option value="<?php echo $row27["plant_code"]; ?>" <?php if($row_work["plant_code"] == $row27["plant_code"]) echo "selected"; ?>> <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo $row27["plant_desc"]; ?></option>
                  <?php
           }  ?>
                </select>
    
    
     </td>
    </tr>
  <tr>
    <td>Cost Center <font color="#FF0000">*</font></td>
    <td>:</td>
    <td><input type="text" id="cost_center" name="cost_center"  value="<?php echo $row_work["cost_center"];  ?>" class="form-control" required /><div class="invalid-feedback">Please enter cost center code.</div>
     </td>
    </tr>
      <tr>
    <td>Cost Center Description <font color="#FF0000">*</font></td>
    <td>:</td>
   <td><input type="text" id="cc_desc" name="cc_desc" value="<?php echo $row_work["cc_desc"];  ?>" class="form-control" required/><div class="invalid-feedback">Please enter cost center description.</div> </td>
    </tr>
     <tr>
    <td>Factory <font color="#FF0000">*</font></td>
    <td>:</td>
    <td>
             <select name="id_factory" id="id_factory" class="form-control" required>
                <option value="" placeholder="Select Factory"> -- Select Factory --</option>
                <?php
	               $query3 = "SELECT * FROM factory_detail_itsb WHERE factory_id = '1' ORDER BY factory_id ASC";
                   $result3 = mysqli_query($dbc,$query3);
  
                   while($row3 = mysqli_fetch_array($result3)) 
			      {
				  
				  
				  ?>
                <option value="<?php echo $row3["factory_id"]; ?>" <?php if($row3["factory_id"] == $row_work["id_factory"]) echo "selected"; ?>> <?php echo $row3["factory_desc"]; ?></option>
                <?php
                  }
				?>
              </select>
    <div class="invalid-feedback">Please select factory.</div>
   </td>
    </tr>
    
    
    
       <tr>
    <td>Department Account <font color="#FF0000">*</font></td>
    <td>:</td>
    <td>
                <select name="dept_acc" id="dept_acc" class="form-control" required>
                <option value="NULL" placeholder="Select Department"> -- Select Department --</option>
                <?php
				
	               $query4 = "SELECT * FROM level_dept WHERE status_level = 'Y' ORDER BY id_levelD ASC";
                   $result4 = mysqli_query($dbc,$query4);
  
                   while($row4 = mysqli_fetch_array($result4)) 
			      {
				  
				  
				  ?>
                <option value="<?php echo $row4["desc_level"]; ?>" <?php if($row4["desc_level"] == $row_work["dept_acc"]) echo "selected"; ?>> <?php echo $row4["desc_level"]; ?></option>
                <?php
                  }
				?>
              </select>
    <div class="invalid-feedback">Please select department account.</div>
   </td>
    </tr>
    
    
      <tr>
    <td>Status Account <font color="#FF0000">*</font></td>
    <td>:</td>
    <td>
                <select name="status_wc" id="status_wc" class="form-control" required>
                <option value="NULL" placeholder="Select Status"> -- Select Status --</option>
                <option value="Y" <?php if($row_work["status_wc"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
                <option value="N" <?php if($row_work["status_wc"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
                </select>
    <div class="invalid-feedback">Please select status account.</div>
   </td>
    </tr>
    <tr>
    <td>Model Description <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td><input type="text" id="wc_desc2" name="wc_desc2" value="<?php echo $row_work["wc_desc2"]; ?>" class="form-control" required /><div class="invalid-feedback">Please enter model description.</div></td>
    </tr>
     <tr>
    <td>Category Material </td>
    <td>:</td>
    <td>
                <select name="prod_cat" id="prod_cat" class="form-control" required>
                <option value="NULL" placeholder="Select Category Material"> -- Select Category Material --</option>
                <option value="A" <?php if($row_work["prod_cat"] == 'A') { ?> selected="selected"<?php } ?>>ASSEMBLY</option>
                <option value="S" <?php if($row_work["prod_cat"] == 'S') { ?> selected="selected"<?php } ?>>STAMPING</option>
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
             <input type="hidden" id="id_work" name="id_work"  class="form-control" value="<?php echo $row2["id_work"];  ?>" > 
             <input type="hidden" id="id_hdr" name="id_hdr"  class="form-control" value="<?php echo $row2["id"];  ?>" >  
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