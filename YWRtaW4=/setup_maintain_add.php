<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

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

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	
	
$url = "setup_maintain_add.php"; 
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
          <h1><i class="fa fa-edit"></i> Setup System</h1>
          <p>Add Setting</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Setup System</li>
          <li class="breadcrumb-item"><a href="setup_maintain_add.php">Add Setting</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="setup_maintain_add.php">Add Setting</a></li>
                <li class="nav-item"><a class="nav-link" href="display_setup_maintain.php">Display Setting</a></li>
              </ul>
       <?php
	   
	   $message_title = ""; 
	   $message_url = "";
	   $message_logo = "";
	   $message_comp = "";
	   $message_smtp = "";
	   $message_mail = "";
	   $message_ftp = "";
	   $message_sta = "";
	 
// Set the page title and include the HTML header.
//include ('templates/header.inc');

if(isset($_POST['submit'])) 
{ // handle the form.


// create a function for escaping the data.
function escape_data($data) {
global $dbc;   // need the connection.
if (ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysqli_real_escape_string($data,$dbc);
	}   // end function.
$message = NULL; // create an empty new variable.
   
 $fileType = $_FILES['upload']['type'];
 $allowed = array("image/jpeg", "image/gif", "application/pdf");
 
 $title_desc = $_POST['title_desc'];
 $upload = $_FILES['upload'];
 $urls_system = $_POST['urls_system'];
 $smtp_account = $_POST['smtp_account'];
 $ftp_ip = $_POST['ftp_ip'];
 $status_system = $_POST['status_system'];
 $email_account = $_POST['email_account'];
 $comp_code = $_POST['comp_code'];

// check for a title desc
if(empty($_POST['title_desc']) || ($_POST['title_desc'] == ""))
{ 
  $title_desc = FALSE;
  $message_title = '<p><font color="#FF0000"><strong>Error!</strong> You are required to select Title Description!</font></p>';
  }
  
 // check for a urls_system
if(empty($_POST['urls_system']))
{ $urls_system = FALSE;
  $message_url = '<p><font color="#FF0000"><strong>Error!</strong> You are required to enter URLs System!</font></p>';
  } 
  
  // check for a company code
if(empty($_POST['comp_code']))
{ $comp_code = FALSE;
  $message_comp = '<p><font color="#FF0000"><strong>Error!</strong> You are required to enter Company Code!</font></p>';
  } 
  
  
// check for a upload file
 if($_FILES['upload']['size'] == 0 || empty($_FILES['upload']['tmp_name']))
  { 
 
  $upload = FALSE;
  $message_logo = '<p><font color="#FF0000"><strong>Error!</strong> You are required to select Upload File!</font></p>';
  }	 
 elseif(!in_array($fileType, $allowed)) 
	{
  		$upload = FALSE;
        $message_logo = '<p><font color="#FF0000"><strong>Error!</strong> Only IMAGE files are allowed.</font></p>';
	
	} 
     
// check for a smtp account
if(empty($_POST['smtp_account']))
{ $smtp_account = FALSE;
  $message_smtp = '<p><font color="#FF0000"><strong>Error!</strong> You are required to enter SMTP Mail!</font></p>';
  }

 // check for a EMAIL
  
  $email = $email_account;
  $regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";

if(!preg_match($regexp, $email)) {
    
   $email_account = FALSE; 
   $message_mail = '<p><font color="#FF0000"><strong>Error!</strong> You are required to enter a valid E-MAIL address!</font></p>';
} 

// check for a ftp ip
if(empty($_POST['ftp_ip']))
{ $ftp_ip = FALSE;
  $message_ftp = '<p><font color="#FF0000"><strong>Error!</strong> You are required to enter Status Setting!</font></p>';
  }
  
// check for a status
if(empty($_POST['status_system']) || ($_POST['status_system'] == ""))
{ $status_system = FALSE;
  $message_sta = '<p><font color="#FF0000"><strong>Error!</strong> You are required to enter FTP IP!</font></p>';
  }
  
  
  if($title_desc && $urls_system && $smtp_account && $ftp_ip && $status_system && $_FILES['upload']['size'] > 0 && $email_account && $comp_code) //everything ok
 {  	
   
   
	   //Add the record to the database
	   $query = "INSERT INTO sys_setup_maintain(id_setup, title_desc, logo_name, logo_comp, urls_system, smtp_account, email_account, ftp_ip, date_create, user_create, date_update, user_update, status_system, comp_code) VALUES('','".sql_esc($title_desc)."','".sql_esc($_FILES['upload']['name'])."','','".sql_esc($urls_system)."','".sql_esc($smtp_account)."', '".sql_esc($email_account)."', '".sql_esc($ftp_ip)."',NOW(),'".sql_esc($username)."','','','".sql_esc($status_system)."','".sql_esc($comp_code)."')";
	   $result = mysqli_query($dbc,$query);   
	  
	   if($result) {
	   //create the filename
	     $extension = explode('.', $_FILES['upload']['name']);
		   $uid = mysqli_insert_id($dbc);  //upload ID
		// $filetest = $_FILES['upload']['name'];
		 //$filename = $filetest;
		 $filename = $uid .'.'.$extension[1];
		 
		 
		    $query_update2 = "UPDATE sys_setup_maintain SET logo_comp = '".sql_esc($uid)."' WHERE id_setup = '".sql_esc($uid)."'";
			$result_update2 = mysqli_query($dbc,$query_update2) or die (mysqli_error($dbc));   
		 
		 //--------update table sys_setup_maintain ----------------
		  if($status_system == "AC")
		  {
			$query_update1 = "UPDATE sys_setup_maintain SET status_system = 'NA' WHERE logo_comp != '".sql_esc($uid)."'";
			$result_update1 = mysqli_query($dbc,$query_update1) or die (mysqli_error($dbc));   
	       
		  }
		 
	 if(move_uploaded_file($_FILES['upload']['tmp_name'], "../set_upload/$filename"))  {
		 
   
echo "<script>";
echo "alert('Congratulations! Your submission is successfully processed');";
echo "window.location='display_setup_maintain.php'";
echo "</script>";
			  exit(); //quit the script
         

           } else {
			
			echo "<script>";
            echo "alert('The document could not be moved.');";
            echo "window.location='setup_maintain_add.php'";
            echo "</script>";
			

			   }
			   
			  } else {  //If the query did not run OK
			  
			echo "<script>";
            echo "alert('Your submission could not be processed due to a system error. We apologize for any inconvenience.');";
            echo "window.location='setup_maintain_add.php'";
            echo "</script>";
			  
		
				}
				  mysqli_close($dbc);   // close database conn
				
				}
	  
if (isset($message))
{ echo '<div class="alert alert-error">', $message, '</div>';
}
}
?>
      
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Add Setting</h3>
            <div class="tile-body">
              <form name="form1" enctype="multipart/form-data" action="" method="post" class="form-horizontal">
        <input type="hidden" name="MAX_FILE_SIZE" value="1024000000000">
                <div class="form-group row">
                  <label class="control-label col-md-3">Title Header :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                    <?php		
 	echo ' <select name="title_desc" class="form-control">
  <option value=""> --Select-- </option>';
  
  //Retrieve and display the available types
  $query3 = "Select * from company";
  $result3 = mysqli_query($dbc,$query3);
  
    
     while($row3 =mysqli_fetch_array($result3)) {
	
	 if($_POST['submit'] == true){ ?>
               <!--RETAIN VALUE-->
               <option value="<?php echo $row3["comp_name"]; ?>" <?php if($row3["comp_code"]==$_POST["title_desc"]) echo "selected"; ?>> <?php echo $row3["comp_name"]; ?></option>
               <?php }else{ ?>
               <option value="<?php echo $row3["comp_name"]; ?>" > <?php echo stripslashes($row3["comp_name"]); ?></option>
               <?php } ?>
               <?php
							}
	 
	  	//complete the form
	
	echo '</select>';

	?>

                    <div class="form-control-feedback" ><?php echo $message_title; ?></div>
                    </div>
                   
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">URLs : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
  <input name="urls_system" type="text" class="form-control" id="urls_system" size="20" value="<?php if(isset($_POST['urls_system'])) echo $_POST['urls_system']; ?>"  placeholder="Enter URLs System"/>
                   <div class="form-control-feedback" ><?php echo $message_url; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Logo Company : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                   <input name="upload" type="file" class="form-control-file" value="<?php if(isset($_POST['upload'])) echo $_POST['upload']; ?>"maxlength="200" accept="image/x-png,image/gif,image/jpeg" /> 
              <p><span class="style3">Limit the size of an attachment is 2M.</span> </p>
                    <div class="form-control-feedback" ><?php echo $message_logo; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Company Code :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                    <input name="comp_code" type="text" class="form-control" id="comp_code"  placeholder="Enter Company Code" value="<?php if(isset($_POST['comp_code'])) echo $_POST['comp_code']; ?>" size="20" maxlength="10"/>
                     <div class="form-control-feedback" ><?php echo $message_comp; ?></div>
                </div>
              </div>
               <div class="form-group row">
                  <label class="control-label col-md-3">SMTP Mail : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                   <input name="smtp_account" type="text" class="form-control" id="smtp_account" size="20"  value="<?php if(isset($_POST['smtp_account'])) echo $_POST['smtp_account']; ?>"  placeholder="Enter SMTP Mail"/>
                  <div class="form-control-feedback" ><?php echo $message_smtp; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">E-mail System : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
  <input name="email_account" type="text" class="form-control" id="email_account" size="60" maxlength="200" value="<?php if(isset($_POST['email_account'])) echo $_POST['email_account']; ?>" placeholder="Enter E-mail System" />
       <div class="form-control-feedback" ><?php echo $message_mail; ?></div>       
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">FTP IP : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
     <input name="ftp_ip" type="text" class="form-control" id="ftp_ip" size="20" value="<?php if(isset($_POST['ftp_ip'])) echo $_POST['ftp_ip']; ?>"  placeholder="Enter FTP IP"/>
       <div class="form-control-feedback" ><?php echo $message_ftp; ?></div>
                </div>
              </div>
              
                <div class="form-group row">
                  <label class="control-label col-md-3">Status Setting : <font color="#FF0000"><b> *</b></font></label>
            <div class="col-md-8">
            <select name="status_system" id="status_system" class="form-control">
                   <?php if($_POST['submit'] == true)
						{ ?>
               <option value="AC" <?php if($_POST["status_system"] == 'AC') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="NA" <?php if($_POST["status_system"] == 'NA') { ?> selected="selected"<?php } ?>>NON-ACTIVE</option>
               <?php 
						}
						else
						{ ?>
               <option value="AC">ACTIVE</option>
               <option value="NA">NON-ACTIVE</option>
               <?php } ?>
                 </select>  <div class="form-control-feedback" ><?php echo $message_sta; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>  * Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
              </div>
              
                <div class="form-group col-md-8 align-self-end">
               <input name="submit" type="submit" id="submit" value="CREATE" class="btn btn-primary">
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