<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "customer_account_table.php"; 
	
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

      $message_vcode = "";
	  $message_vname = "";
	  $message_sterm = "";
	  $message_add1 = "";
	  $message_add2 = "";
	  $message_pcode = "";
	  $message_ct = "";
	  $message_country = "";
	  $message_reg = "";
	  $message_sta = "";
	  $message_sub = "";


if (isset($_POST['submit9']))
{


   $message = NULL; // create an empty new variable.


   $id_cust = $_POST["id_cust"];
   $cust_desc = $_POST["cust_desc"];
   $add_no1 = $_POST["add_no1"];
   $add_no2 = $_POST["add_no2"];
   $post_code = $_POST["post_code"];
   $post_city = $_POST["post_city"];
   $post_region = $_POST["post_region"];
   $post_country = $_POST["post_country"];
   $cust_ID = $_POST["cust_ID"];
   $tphone = $_POST["tphone"];
   $fax_no = $_POST["fax_no"];
   $payment_method = $_POST["payment_method"];
   $term_payment = $_POST["term_payment"];
   $status_cust = $_POST["status_cust"];
   $plant_code = $_POST["plant_code"];
   $country_code = $_POST["country_code"];

//------------------------------end function --------------------------------
// check for a cust code
if (empty($_POST["id_cust"]))
{ $id_cust = FALSE;
  $message_vcode = '<span class="badge badge-pill badge-danger">Please enter Customer Code!</span>';
  }

// check for a cust_name
if (empty($_POST["cust_desc"]))
{ $cust_desc = FALSE;
  $message_vname = '<span class="badge badge-pill badge-danger">Please enter Customer Name!</span>';
  }else
  { $cust_desc = addslashes($_POST["cust_desc"]);
  }
  
// check for a address no 1
if (empty($_POST["add_no1"]))
{ $add_no1 = FALSE;
  $message_add1 = '<span class="badge badge-pill badge-danger">Please enter Address No. 1!</span>';
  }
    else
  { $add_no1 = addslashes($_POST["add_no1"]);
  }
  
  
// check for a post_code
if (empty($_POST["post_code"]))
{ $post_code = FALSE;
  $message_pcode = '<span class="badge badge-pill badge-danger">Please enter Postcode!</span>';
  }
  else
  { $post_code = addslashes($_POST["post_code"]);
  }

// check for a post city
if (empty($_POST["post_city"]))
{ $post_city = FALSE;
  $message_cc = '<span class="badge badge-pill badge-danger">Please enter City!</span>';
  }
    else
  { $post_city = addslashes($_POST["post_city"]);
  }
  
  // check for a post region
if (empty($_POST["post_region"]))
{ $post_region = FALSE;
  $message_reg = '<span class="badge badge-pill badge-danger">Please enter Region!</span>';
  }
    else
  { $post_region = addslashes($_POST["post_region"]);
  }

// check for a post country
if (empty($_POST["post_country"]))
{ $post_country = FALSE;
  $message_country = '<span class="badge badge-pill badge-danger">Please enter Country!</span>';
  }
    else
  { $post_country = addslashes($_POST["post_country"]);
  }
  
  // check for a search term
if ((empty($_POST["cust_ID"]))  || ($_POST["cust_ID"] == "NULL"))
{ $cust_ID = FALSE;
  $message_sterm = '<span class="badge badge-pill badge-danger">Please enter Search Term!</span>';
  }
    else
  { $cust_ID = addslashes($_POST["cust_ID"]);
  }

// check for status account
if (empty($_POST["status_cust"]) || ($_POST["status_cust"] == ""))
{ $status_cust = FALSE;
  $message_sta = '<span class="badge badge-pill badge-danger">Please select Status Account!</span>';
  }
  else
  { $status_cust = addslashes($_POST["status_cust"]);
  }
  
  // check for plant code
if (empty($_POST["plant_code"]) || ($_POST["plant_code"] == "NULL"))
{ $plant_code = FALSE;
  $message_sub = '<span class="badge badge-pill badge-danger">Please select Status Subcont!</span>';
  }
  else
  { $plant_code = addslashes($_POST["plant_code"]);
  }
  
 if($id_cust && $cust_desc && $add_no1 && $post_code && $post_city && $post_region && $post_country && $cust_ID && $status_cust && $plant_code) //everything ok
 {  
 
 
   $id_cust = $_POST["id_cust"];
   $cust_desc = $_POST["cust_desc"];
   $add_no1 = $_POST["add_no1"];
   $add_no2 = $_POST["add_no2"];
   $post_code = $_POST["post_code"];
   $post_city = $_POST["post_city"];
   $post_region = $_POST["post_region"];
   $post_country = $_POST["post_country"];
   $cust_ID = $_POST["cust_ID"];
   $tphone = $_POST["tphone"];
   $fax_no = $_POST["fax_no"];
   $payment_method = $_POST["payment_method"];
   $term_payment = $_POST["term_payment"];
   $status_cust = $_POST["status_cust"];
   $plant_code = $_POST["plant_code"];
   $country_code = $_POST["country_code"];
   $cust_sname = $_POST["cust_sname"];
 
 
   //---info plant code ----

$query_plant = "SELECT * FROM plant_detail WHERE plant_code = '".sql_esc($plant_code)."' AND status_plant = 'Y'";
$result_plant = mysqli_query($dbc,$query_plant);
$row_plant = mysqli_fetch_array($result_plant);

//---info country ----

$query_ctry = "SELECT * FROM country WHERE country_code = '".sql_esc($country_code)."' AND status_ccode = 'Y'";
$result_ctry = mysqli_query($dbc,$query_ctry);
$row_ctry = mysqli_fetch_array($result_ctry);
 
 
 
 
 
 	     	  $query_search = "SELECT * FROM cust_detail WHERE id_cust = '".sql_esc($id_cust)."'";
              $result_search = mysqli_query($dbc,$query_search);   //run the query.
              $num_search = mysqli_num_rows($result_search);   //how many suppliers are there?
			  
			  if($num_search == 1) {
			 
			    $row = mysqli_fetch_array($result_search);
			
		$query_upd = "UPDATE cust_detail SET cust_desc = '".strtoupper($cust_desc)."', add_no1 = '".sql_esc($add_no1)."', add_no2 = '".sql_esc($add_no2)."', search_term = '".strtoupper($cust_ID)."', post_code = '".sql_esc($post_code)."', post_city = '".sql_esc($post_city)."', post_region = '".sql_esc($post_region)."', post_country = '".sql_esc($post_country)."', tphone = '".sql_esc($tphone)."', fax_no = '".sql_esc($fax_no)."', payment_method = '".sql_esc($payment_method)."', term_payment = '".sql_esc($term_payment)."', status_cust = '".sql_esc($status_cust)."', cust_sname = '".sql_esc($cust_sname)."', plant_code = '".sql_esc($plant_code)."', country_code = '".sql_esc($country_code)."', cust_ID = '".sql_esc($cust_ID)."', country_desc = '".sql_esc($row_ctry["country_text"])."', plant_desc = '".sql_esc($row_plant["plant_desc"])."', user_update = '".sql_esc($username)."', date_update = NOW() WHERE id_cust = '".sql_esc($id_cust)."'"; 
		$result_upd = mysqli_query($dbc,$query_upd); 
								
		  // if($result_upd)
		 //{
			 echo "<script>";
		     echo "alert('Account customer is successfully update.');";
			 echo "window.location='cust_account_table.php'";
		     echo "</script>"; 
		     exit(); //quit the script
			
        // } 
}else { 

echo 'Cannot update record'; 
          
		  }
//print the message if there is one.
	  
} 
//---------------------------function message------------------------------ 
if (isset($message))
{ echo '<div class="msg msg-error"><font color="red" class ="error_entry">', $message, '</font></div>';
}
} 
 ?> 
  <div class="modal fade" id="myNoteEditCust<?php echo $row2["id_cust"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
         <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Customer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
       
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Customer Details</strong>
       </div>
      <?php

$query_ven = "SELECT * FROM cust_detail WHERE id_cust = '".sql_esc($row2["id_cust"])."'";
$result_ven = mysqli_query($dbc,$query_ven);   //run the query.
$row_ven = mysqli_fetch_array($result_ven);   //how many records are there?
     
   ?>
   <form name="formEdit" method="post" action="" class="needs-validation"  novalidate>
   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">Customer Code </td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="id_cust" name="id_cust" value="<?php  echo $row_ven["id_cust"]; ?>" class="form-control"></td>
    </tr>
  <tr>
    <td>Customer Name <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td><input type="text" id="cust_desc" name="cust_desc" value="<?php echo $row_ven["cust_desc"]; ?>" class="form-control" required/><div class="invalid-feedback">Please enter customer name.</div>
     </td>
    </tr>
   <tr>
    <td>Search Term <font color="#FF0000">*</font></td>
    <td>:</td>
    <td>
           <select name="cust_ID" class="form-control">
            <option value="NULL" placeholder="Select Search Term"> -- Select Search Term -- </option>
          <?php
          //Retrieve and display the available types
          $query17 = 'SELECT * FROM table_cust_detail WHERE status_customer = "Y"';
          $result17 = mysqli_query($dbc,$query17);
          
              while($row17 = mysqli_fetch_array($result17)) {
        
              ?>
         <option value="<?php echo $row17["customer_code"]; ?>" <?php if($row17["customer_code"] == $row_ven["cust_ID"]) echo "selected"; ?> > <?php echo stripslashes($row17["customer_code"]); ?> </option>
          <?php
           }  ?>
                            
        </select>
    <div class="invalid-feedback">Please enter search term code.</div>
     </td>
    </tr>
     <tr>
    <td>Address No. 1 <font color="#FF0000">*</font></td>
    <td>:</td>
    <td><input type="text" id="add_no1" name="add_no1" value="<?php echo $row_ven["add_no1"];  ?>" class="form-control" required/>
     <div class="invalid-feedback">Please enter address no.1.</div>
     </td>
    </tr>
     <tr>
    <td>Address No. 2 </td>
    <td>:</td>
    <td><input type="text" id="add_no2" name="add_no2" value="<?php echo $row_ven["add_no2"];  ?>" class="form-control"/>
    <div class="invalid-feedback">Please enter address no.2.</div>
     </td>
    </tr>
     <tr>
    <td>Postcode <font color="#FF0000">*</font></td>
    <td>:</td>
    <td><input type="text" id="post_code" name="post_code" maxlength="10" value="<?php echo $row_ven["post_code"];  ?>" class="form-control" required/>
    <div class="invalid-feedback">Please enter postcode.</div>
     </td>
    </tr>
     <tr>
    <td>City <font color="#FF0000">*</font></td>
    <td>:</td>
    <td><input type="text" id="post_city" name="post_city" value="<?php echo $row_ven["post_city"];  ?>" class="form-control" required/>
    <div class="invalid-feedback">Please enter city.</div>
     </td>
    </tr>
     <tr>
    <td>Region <font color="#FF0000">*</font></td>
    <td>:</td>
    <td><input type="text" id="post_region" name="post_region" value="<?php echo $row_ven["post_region"];  ?>" class="form-control" required/> <div class="invalid-feedback">Please enter region.</div>
     </td>
    </tr>
     <tr>
    <td>Country <font color="#FF0000">*</font></td>
    <td>:</td>
    <td><input type="text" id="post_country" name="post_country" value="<?php echo $row_ven["post_country"];  ?>" class="form-control" required/> <div class="invalid-feedback">Please enter country.</div>
     </td>
    </tr>
     <tr>
    <td>Phone</td>
    <td>:</td>
    <td><input type="text" id="tphone" name="tphone" maxlength="20" value="<?php echo $row_ven["tphone"];  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Fax</td>
    <td>:</td>
    <td><input type="text" id="fax_no" name="fax_no" maxlength="20" value="<?php echo $row_ven["fax_no"];  ?>" class="form-control"/>
     </td>
    </tr>
      <tr>
    <td>Payment Method</td>
    <td>:</td>
    <td><input type="text" id="payment_method" name="payment_method" value="<?php echo $row_ven["payment_method"];  ?>" class="form-control"/>
     </td>
    </tr>
      <tr>
    <td>Term Payment</td>
    <td>:</td>
    <td><input type="text" id="term_payment" name="term_payment" value="<?php echo $row_ven["term_payment"];  ?>" class="form-control"/>
     </td>
    </tr>
      <tr>
    <td>User Created</td>
    <td>:</td>
    <td><input type="text" id="user_create" name="user_create" value="<?php echo $data_create["user_fullname"];  ?>" class="form-control"/>
     </td>
    </tr>  <tr>
    <td>Date Created</td>
    <td>:</td>
    <td><input type="text" id="date_create" name="date_create" value="<?php echo $row_ven["date_create"];  ?>" class="form-control"/>
     </td>
    </tr>  <tr>
    <td>User Updated</td>
    <td>:</td>
    <td><input type="text" id="user_update" name="user_update" value="<?php echo $data_update["user_fullname"];  ?>" class="form-control"/>
     </td>
    </tr>  
    <tr>
    <td>Date Updated</td>
    <td>:</td>
    <td><input type="text" id="date_update" name="date_update" value="<?php echo $row_ven["date_update"];  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Status Account <br>(Y = Active, N = Inactive) <font color="#FF0000">*</font></td>
    <td>:</td>
    <td>
      <select name="status_cust"  class="form-control" required>
      <option value="" placeholder="Select Status"> -- Select Status --</option>
	  <option value="Y" class="title" <?php if($row_ven["status_cust"] == 'Y') echo "selected"; ?>>Y - Active</option>
	  <option value="N" class="title" <?php if($row_ven["status_cust"] == 'N') echo "selected"; ?>>N - Inactive</option>
	  </select>
      <div class="invalid-feedback">Please select status account.</div>
    </td>
    </tr>
    <tr>
    <td>Plant Code <font color="#FF0000">*</font></td>
    <td>:</td>
    <td>
            <select name="plant_code" class="form-control" >
            <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
                  <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
                  <option value="<?php echo $row27["plant_code"]; ?>" <?php if($row_ven["plant_code"] == $row27["plant_code"]) echo "selected"; ?>> <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo $row27["plant_desc"]; ?></option>
                  <?php
           }  ?>
                </select>
    
     <div class="invalid-feedback">Please select plant code.</div>
     </td>
    </tr>
     <tr>
    <td>Country Code <font color="#FF0000">*</font></td>
    <td>:</td>
    <td>  <select name="country_code" class="form-control">
            <option value="NULL" placeholder="Select Country"> -- Select Country -- </option>
          <?php
          //Retrieve and display the available types
          $query57 = 'SELECT * FROM country WHERE status_ccode = "Y"';
          $result57 = mysqli_query($dbc,$query57);
          
              while($row57 = mysqli_fetch_array($result57)) {
        
              ?>
         <option value="<?php echo $row57["country_code"]; ?>" <?php if($row_ven["country_code"] == $row57["country_code"]) echo "selected"; ?> > <?php echo stripslashes($row57["country_code"]); ?> - <?php echo $row57["country_text"]; ?></option>
          <?php
           }  ?>
                            
        </select>
    
     <div class="invalid-feedback">Please select country code.</div>
     </td>
    </tr>
       <tr>
    <td>Short Name</td>
    <td>:</td>
    <td><input type="text" id="cust_sname" name="cust_sname" value="<?php echo $row_ven["cust_sname"];  ?>" class="form-control"/>
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
             <input type="hidden" id="id_cust" name="id_cust"  class="form-control" value="<?php echo $row2["id_cust"];  ?>" >  
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