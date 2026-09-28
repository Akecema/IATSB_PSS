<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	
	
$url = "add_vendor_account.php"; 
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
      <?php   include "left_admin_menu.php";   ?>
  
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> Table Maintenance</h1>
          <p>Add Vendor</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="add_vendor_account.php">Add Vendor</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="add_vendor_account.php" data-toggle="tab">Add Vendor</a></li>
                <li class="nav-item"><a class="nav-link"  href="vendor_account_table.php">Display Vendor</a></li>
            </ul>
            
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
	  $message_plant = "";
	  
	  
if(isset($_POST['Submit7'])) 
{ // handle the form.

   
$message = NULL; // create an empty new variable.
   
   $vendor_code = $_POST["vendor_code"];
   $vendor_name = $_POST["vendor_name"];
   $add_no1 = $_POST["add_no1"];
   $add_no2 = $_POST["add_no2"];
   $post_code = $_POST["post_code"];
   $post_city = $_POST["post_city"];
   $post_region = $_POST["post_region"];
   $post_country = $_POST["post_country"];
   $search_term = $_POST["search_term"];
   $tphone = $_POST["tphone"];
   $fax_no = $_POST["fax_no"];
   $payment_method = $_POST["payment_method"];
   $term_payment = $_POST["term_payment"];
   $status_acc = $_POST["status_acc"];
   $status_subcont = $_POST["status_subcont"];
   $plant_code = $_POST["plant_code"];
   $status_foc = $_POST["status_foc"];
   
   
   $tphone = addslashes($_POST["tphone"]);
   $fax_no = addslashes($_POST["fax_no"]);
   $payment_method = addslashes($_POST["payment_method"]);
   $term_payment = addslashes($_POST["term_payment"]);
  
// check for a vendor code
if(empty($_POST["vendor_code"]))
{ $vendor_code = FALSE;
  $message_vcode = '<span class="badge badge-pill badge-danger">Please enter Vendor Code!</span>';
  }

// check for a vendor_name
if(empty($_POST["vendor_name"]))
{ $vendor_name = FALSE;
  $message_vname = '<span class="badge badge-pill badge-danger">Please enter Vendor Name!</span>';
  }else
  { $vendor_name = addslashes($_POST["vendor_name"]);
  }
  
// check for a address no 1
if(empty($_POST["add_no1"]))
{ $add_no1 = FALSE;
  $message_add1 = '<span class="badge badge-pill badge-danger">Please enter Address No. 1!</span>';
  }
    else
  { $add_no1 = addslashes($_POST["add_no1"]);
  }
  
  // check for a address no 2
if(empty($_POST["add_no2"]))
{ $add_no2 = FALSE;
  $message_add2 = '<span class="badge badge-pill badge-danger">Please enter Address No. 2!</span>';
  }
    else
  { $add_no2 = addslashes($_POST["add_no2"]);
  }

// check for a post_code
if(empty($_POST["post_code"]))
{ $post_code = FALSE;
  $message_pcode = '<span class="badge badge-pill badge-danger">Please enter Postcode!</span>';
  }
  else
  { $post_code = addslashes($_POST["post_code"]);
  }

// check for a post city
if(empty($_POST["post_city"]))
{ $post_city = FALSE;
  $message_ct = '<span class="badge badge-pill badge-danger">Please enter City!</span>';
  }
    else
  { $post_city = addslashes($_POST["post_city"]);
  }
  
  // check for a post region
if(empty($_POST["post_region"]))
{ $post_region = FALSE;
  $message_reg = '<span class="badge badge-pill badge-danger">Please enter Region!</span>';
  }
    else
  { $post_region = addslashes($_POST["post_region"]);
  }

// check for a post country
if(empty($_POST["post_country"]))
{ $post_country = FALSE;
  $message_country = '<span class="badge badge-pill badge-danger">Please enter Country!</span>';
  }
    else
  { $post_country = addslashes($_POST["post_country"]);
  }
  
  // check for a search term
if(empty($_POST["search_term"]))
{ $search_term = FALSE;
  $message_sterm = '<span class="badge badge-pill badge-danger">Please enter Search Term!</span>';
  }
    else
  { $search_term = addslashes($_POST["search_term"]);
  }

// check for status account
if(empty($_POST["status_acc"]) || ($_POST["status_acc"] == "NULL"))
{ $status_acc = FALSE;
  $message_sta = '<span class="badge badge-pill badge-danger">Please to select Status Account!</span>';
  }
  else
  { $status_acc = addslashes($_POST["status_acc"]);
  }
  
  // check for status subcont
if(empty($_POST["status_subcont"]) || ($_POST["status_subcont"] == "NULL"))
{ $status_subcont = FALSE;
  $message_sub = '<span class="badge badge-pill badge-danger">Please to select Status Subcont!</span>';
  }
  else
  { $status_subcont = addslashes($_POST["status_subcont"]);
  }
  
  // check for plant code
if(empty($_POST["plant_code"]) || ($_POST["plant_code"] == "NULL"))
{ $plant_code = FALSE;
  $message_plant = '<span class="badge badge-pill badge-danger">Please to select plant code!</span>';
  }
  else
  { $plant_code = addslashes($_POST["plant_code"]);
  }
  
 if($vendor_code && $vendor_name && $add_no1 && $add_no2 && $post_code && $post_city && $post_region && $post_country && $search_term && $status_acc && $status_subcont && $plant_code) //everything ok
 {  

   $vendor_code = $_POST["vendor_code"];
   $vendor_name = $_POST["vendor_name"];
   $add_no1 = $_POST["add_no1"];
   $add_no2 = $_POST["add_no2"];
   $post_code = $_POST["post_code"];
   $post_city = $_POST["post_city"];
   $post_region = $_POST["post_region"];
   $post_country = $_POST["post_country"];
   $search_term = $_POST["search_term"];
   $tphone = $_POST["tphone"];
   $fax_no = $_POST["fax_no"];
   $payment_method = $_POST["payment_method"];
   $term_payment = $_POST["term_payment"];
   $status_acc = $_POST["status_acc"];
   $status_subcont = $_POST["status_subcont"];
   $plant_code = $_POST["plant_code"];
   $status_foc = $_POST["status_foc"];


//insert vendor detail

$query_db = "INSERT INTO vendor_detail(vendor_code,vendor_name,add_no1,add_no2,post_code,post_city,post_region,post_country,search_term,tphone,fax_no,payment_method,term_payment,user_create,date_create,user_update,date_update,status_acc,status_subcont,status_foc,plant_code) VALUES('".strtoupper($vendor_code)."','".strtoupper($vendor_name)."','".sql_esc($add_no1)."','".sql_esc($add_no2)."','".sql_esc($post_code)."','".sql_esc($post_city)."','".sql_esc($post_region)."','".sql_esc($post_country)."','".strtoupper($search_term)."','".sql_esc($tphone)."','".sql_esc($fax_no)."','".strtoupper($payment_method)."','".strtoupper($term_payment)."','".sql_esc($username)."',NOW(),'','','".sql_esc($status_acc)."','".sql_esc($status_subcont)."','".sql_esc($status_foc)."','".sql_esc($plant_code)."')";
$result = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));


             if($result)
             {
				echo "<script>";
				echo "alert('Account of vendor is successfully created');";
				echo "window.location='add_vendor_account.php'";
				echo "</script>";
			    exit(); //quit the script
             }
             else 
			 {
             $message = '<p><strong>Error!</strong> Cannot create account of VENDOR. </p>';
              mysqli_close($dbc); //close db
             }  
}
//print the message if there is one.
	  
	  
if (isset($message))
{ 
echo '<div class="alert alert-error">', $message, '</div>';
}
}
?>    
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Add Vendor</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Vendor Code  : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                   <input name="vendor_code" type="text" id="vendor_code" size="20" maxlength="20" value="<?php if(isset($_POST['vendor_code'])) echo $_POST['vendor_code']; ?>" class="form-control" placeholder="Enter Vendor Code" />
                   <div class="form-control-feedback" ><?php echo $message_vcode; ?></div>
                    </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Vendor Name  : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                   <input name="vendor_name" type="text" id="vendor_name" size="20" value="<?php if(isset($_POST['vendor_name'])) echo $_POST['vendor_name']; ?>" class="form-control" placeholder="Enter Vendor Name" />
                   <div class="form-control-feedback" ><?php echo $message_vname; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Search Term  : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
             <input name="search_term" type="text" class="form-control" id="search_term" size="20"  value="<?php if(isset($_POST['search_term'])) echo $_POST['search_term']; ?>" placeholder="Enter Search Term"/>
                   <div class="form-control-feedback" ><?php echo $message_sterm; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Address No. 1  : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
           <input name="add_no1" type="text" class="form-control" id="add_no1" size="20" value="<?php if(isset($_POST['add_no1'])) echo $_POST['add_no1']; ?>" placeholder="Enter Address No. 1" />
                   <div class="form-control-feedback" ><?php echo $message_add1; ?></div>
                    </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Address No.2  : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
           <input name="add_no2" type="text" class="form-control" id="add_no2" size="20" value="<?php if(isset($_POST['add_no2'])) echo $_POST['add_no2']; ?>" placeholder="Enter Address No. 2" />
                   <div class="form-control-feedback" ><?php echo $message_add2; ?></div>
                    </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Postcode  : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
            <input name="post_code" type="text" class="form-control" id="post_code" size="20" maxlength="15" value="<?php if(isset($_POST['post_code'])) echo $_POST['post_code']; ?>" placeholder="Enter Postcode"/>
                   <div class="form-control-feedback" ><?php echo $message_pcode; ?></div>
                    </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">City  : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
             <input name="post_city" type="text" class="form-control" id="post_city" size="20" value="<?php if(isset($_POST['post_city'])) echo $_POST['post_city']; ?>" placeholder="Enter City"/>
                   <div class="form-control-feedback" ><?php echo $message_ct; ?></div>
                    </div>
                </div> 
                    <div class="form-group row">
                  <label class="control-label col-md-3">Region  : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
              <input name="post_region" type="text" class="form-control" id="post_region" size="20" value="<?php if(isset($_POST['post_region'])) echo $_POST['post_region']; ?>" placeholder="Enter Region"/>
                   <div class="form-control-feedback" ><?php echo $message_reg; ?></div>
                    </div>
                </div> 
                  <div class="form-group row">
                  <label class="control-label col-md-3">Country  : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
             <input name="post_country" type="text" class="form-control" id="post_country" size="20" value="<?php if(isset($_POST['post_country'])) echo $_POST['post_country']; ?>" placeholder="Enter Country"/>
                   <div class="form-control-feedback" ><?php echo $message_country; ?></div>
                    </div>
                </div> 
                  <div class="form-group row">
                  <label class="control-label col-md-3">Phone No.  : </label>
                   <div class="col-md-8">
             <input name="tphone" type="text" class="form-control" id="tphone" size="20" maxlength="15" value="<?php if(isset($_POST['tphone'])) echo $_POST['tphone']; ?>" placeholder="Enter Phone No."/>
                  
                    </div>
                </div> 
                  <div class="form-group row">
                  <label class="control-label col-md-3">Fax No.  : </label>
                   <div class="col-md-8">
           <input name="fax_no" type="text" class="form-control" id="fax_no" size="20" maxlength="15" value="<?php if(isset($_POST['fax_no'])) echo $_POST['fax_no']; ?>" placeholder="Enter Fax No."/>
                    </div>
                </div> 
                  <div class="form-group row">
                  <label class="control-label col-md-3">Payment Menthod : </label>
                   <div class="col-md-8">
           <input name="payment_method" type="text" class="form-control" id="payment_method" size="20" maxlength="15" value="<?php if(isset($_POST['payment_method'])) echo $_POST['payment_method']; ?>" placeholder="Enter Payment Method"/>
                    </div>
                </div> 
                  <div class="form-group row">
                  <label class="control-label col-md-3">Term Payment : </label>
                   <div class="col-md-8">
      <input name="term_payment" type="text" class="form-control" id="term_payment" size="20" maxlength="15" value="<?php if(isset($_POST['term_payment'])) echo $_POST['term_payment']; ?>" placeholder="Enter Term Payment"/>
                </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Status Account: <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
               <select name="status_acc" id="status_acc" class="form-control">
               <option value="NULL"> --- Select --- </option>
                   <?php if($_POST['Submit7'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_acc"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($_POST["status_acc"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
               <?php 
						}
						else
						{ ?>
               <option value="Y">ACTIVE</option>
               <option value="N">INACTIVE</option>
               <?php } ?>
                 </select>
     
                   <div class="form-control-feedback" ><?php echo $message_sta; ?></div>
                    </div>
                </div>
                   <div class="form-group row">
                  <label class="control-label col-md-3">Status Subcont: <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
               <select name="status_subcont" id="status_subcont" class="form-control">
               <option value="NULL"> --- Select --- </option>
                   <?php if($_POST['Submit7'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_subcont"] == 'Y') { ?> selected="selected"<?php } ?>>YES</option>
               <option value="N" <?php if($_POST["status_subcont"] == 'N') { ?> selected="selected"<?php } ?>>NO</option>
               <?php 
						}
						else
						{ ?>
               <option value="Y">YES</option>
               <option value="N">NO</option>
               <?php } ?>
                 </select>
     
                   <div class="form-control-feedback" ><?php echo $message_sub; ?></div>
                    </div>
                </div>
                
                 <div class="form-group row">
                  <label class="control-label col-md-3">Status FOC: </label>
                   <div class="col-md-8">
               <select name="status_foc" id="status_foc" class="form-control">
               <option value="NULL"> --- Select --- </option>
                   <?php if($_POST['Submit7'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_foc"] == 'Y') { ?> selected="selected"<?php } ?>>YES</option>
               <option value="N" <?php if($_POST["status_foc"] == 'N') { ?> selected="selected"<?php } ?>>NO</option>
               <?php 
						}
						else
						{ ?>
               <option value="Y">YES</option>
               <option value="N">NO</option>
               <?php } ?>
                 </select>
                 </div>
                </div>
                
                
                
                 <div class="form-group row">
                  <label class="control-label col-md-3">Plant Code: <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                 <select name="plant_code" class="form-control">
            <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
          <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
         <option value="<?php echo $row27["plant_code"]; ?>" > <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo $row27["plant_desc"]; ?></option>
          <?php
           }  ?>
                            
        </select>
     
                   <div class="form-control-feedback" ><?php echo $message_plant; ?></div>
                    </div>
                </div>
               <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>* Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
                </div>
                <div class="form-group col-md-8 align-self-end">
               <input name="Submit7" type="submit" id="submit" value="CREATE" class="btn btn-primary">
               <input name="Reset" type="reset" id="Reset" class="btn btn-warning" value="CLEAR">
                 <!--   <button class="btn btn-primary" type="button" onClick=""><i class="fa fa-fw fa-lg fa-check-circle"></i>Subscribe</button>-->
                </div>
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
  
  </body>
</html>