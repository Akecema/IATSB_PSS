<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
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

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	
	
$url = "add_model_table.php"; 
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
          <p>Add Model</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="add_model_table.php">Add Model</a></li>
        </ul>
      </div>  

            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="add_model_table.php" data-toggle="tab">Add Model</a></li>
                <li class="nav-item"><a class="nav-link"  href="display_model_table.php">Material Model</a></li>
            </ul>
            
      <?php
$message_mcode = "";
$message_mdesc = "";
$message_pcode = "";
$message_sta = ""; 
$message_mtype = ""; 
$message_services = ""; 
		  
if (isset($_POST['Submit12'])) 
{ // handle the form.


$message = NULL; // create an empty new variable.
   
$model_name = $_POST['model_name'];
$model_desc = $_POST['model_desc'];
$plant_code = $_POST['plant_code'];
$status_model = $_POST['status_model'];
$mat_type = $_POST['mat_type'];
$services_part = $_POST['services_part'];


// check for a model_name.
if (empty($_POST['model_name']))
{ $model_name = FALSE;
  $message_mcode = '<span class="badge badge-pill badge-danger">Please enter Model Code.!</span>';
  }else
  { $model_name = addslashes($_POST['model_name']);
  }
  

// check for a model_desc.
if (empty($_POST['model_desc']))
{ $model_desc = FALSE;
  $message_mdesc = '<span class="badge badge-pill badge-danger">Please enter Model Description.!</span>';
  }else
  { $model_desc = addslashes($_POST['model_desc']);
  }
  
// check for status account
if(empty($_POST["status_model"]) || ($_POST["status_model"] == "NULL"))
{ $status_model = FALSE;
  $message_sta = '<span class="badge badge-pill badge-danger"> Please select Status Account!</span>';
  }
  else
  { $status_model = addslashes($_POST["status_model"]);
  }

// check for plant code
if(empty($_POST["plant_code"]) || ($_POST["plant_code"] == "NULL"))
{ $plant_code = FALSE;
  $message_pcode = '<span class="badge badge-pill badge-danger">Please select Plant Code!</span>';
  }
  else
  { $plant_code = addslashes($_POST["plant_code"]);
  }
  
  // check for a mat type
if((empty($_POST['mat_type'])) || ($_POST['mat_type']) == "NULL")
{ 
   $mat_type = FALSE;
   $message_mtype = '<span class="badge badge-pill badge-danger">Please select Material Type!</span>';
 
  }
    else
  { $mat_type = addslashes($_POST['mat_type']);
  }


  // check for services part
if(empty($_POST["services_part"]) || ($_POST["services_part"] == "NULL"))
{ $services_part = FALSE;
  $message_services = '<span class="badge badge-pill badge-danger"> Please select Services Part!</span>';
  }
  else
  { $services_part = addslashes($_POST["status_model"]);
  }
   
 if($model_name && $model_desc && $status_model && $plant_code && $mat_type && $services_part) //everything ok
{
	
$model_name = $_POST['model_name'];
$model_desc = $_POST['model_desc'];
$plant_code = $_POST['plant_code'];
$status_model = $_POST['status_model'];
$mat_type = $_POST['mat_type'];
$services_part = $_POST['services_part'];

//register the user in the db.
$query_db = "INSERT INTO model_detail_tbl(id_model,model_code,model_desc,status_model,material_type,plant_code,services_part) VALUES('','".strtoupper($model_name)."','".sql_esc($model_desc)."','".sql_esc($status_model)."','".sql_esc($mat_type)."','".sql_esc($plant_code)."','".sql_esc($services_part)."')";
$result = mysqli_query($dbc,$query_db) or die(mysqli_error($dbc));


             if($result)
             {
				echo "<script>";
				echo "alert('Model is successfully created');";
				echo "window.location='display_model_table.php'";
				echo "</script>";
			    exit(); //quit the script
             }
             else 
			 {
			    echo "<script>";
				echo "alert('Cannot create Model of Material.');";	 
				echo "</script>";
			    exit(); //quit the script 
				 
              //mysqli_close($dbc); //close db
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
            <h3 class="tile-title">Add Model of Material</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Model Code :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                 <input name="model_name" type="text" id="model_name" size="20" value="<?php if(isset($_POST['model_name'])) echo html_esc($_POST['model_name']); ?>" class="form-control" placeholder="Enter Model Code" />      
                    <div class="form-control-feedback" ><?php echo $message_mcode; ?></div>
                    </div>
                   
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Model Description : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="model_desc" type="text" class="form-control" id="model_desc" size="20" value="<?php if(isset($_POST['model_desc'])) echo html_esc($_POST['model_desc']); ?>"  placeholder="Enter Model Description" />
                   <div class="form-control-feedback" ><?php echo $message_mdesc; ?></div>
                    </div>
                </div>
               <div class="form-group row">
                  <label class="control-label col-md-3">Plant Code : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                      		
          <select name="plant_code" class="form-control" onChange="getType(this.value)">
            <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
                  <?php
          //Retrieve and display the available types
          $query29 = "SELECT * FROM plant_detail WHERE status_plant = 'Y'";
          $result29 = mysqli_query($dbc,$query29);
          
              while($row29 = mysqli_fetch_array($result29)) {
        
              ?>
                  <option value="<?php echo html_esc($row29["plant_code"]); ?>" <?php if(($row29["plant_code"]) == ($_POST["plant_code"])) echo "selected"; ?>> <?php echo html_esc($row29["plant_code"]); ?> - <?php echo html_esc($row29["plant_desc"]); ?></option>
                  <?php
           }  ?>
                </select>
                   <div class="form-control-feedback" ><?php echo $message_pcode; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Material Type :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
              <div id="mtype_div"> 
             <select name="mat_type" id="mat_type" class="form-control" >
             <option value="NULL" placeholder="Select Type"> -- Select Type -- </option>   
                 <?php
	
	$query48 = "SELECT * FROM material_type_tbl WHERE status_type = 'Y' ORDER BY id ASC";
    $result48 =mysqli_query($dbc,$query48);
	
	 while($row48 = mysqli_fetch_array($result48)) 
	  { 
	?>  
          <option value="<?php echo html_esc($row48["id"]); ?>"<?php if(($row48["id"]) == $_POST['mat_type']) echo "selected"; ?> > <?php echo stripslashes($row48["mtype_name"]); ?></option>
  <?php   }  ?>
  
          </select> <div class="form-control-feedback" ><?php echo $message_mtype; ?></div>
              </div>  
             
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Status Account: <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
               <select name="status_model" id="status_model" class="form-control">
               <option value="NULL"> --- Select --- </option>
                   <?php if($_POST['Submit12'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_model"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($_POST["status_model"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
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
                  <label class="control-label col-md-3">Services Part: <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
               <select name="services_part" id="services_part" class="form-control">
               <option value="NULL"> --- Select --- </option>
                   <?php if($_POST['Submit12'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["services_part"] == 'Y') { ?> selected="selected"<?php } ?>>YES</option>
               <option value="N" <?php if($_POST["services_part"] == 'N') { ?> selected="selected"<?php } ?>>NO</option>
               <?php 
						}
						else
						{ ?>
               <option value="Y">YES</option>
               <option value="N">NO</option>
               <?php } ?>
                 </select>
     
                   <div class="form-control-feedback" ><?php echo $message_services; ?></div>
                    </div>
                </div>
       
              <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>* Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
              </div>
              
                <div class="form-group col-md-8 align-self-end">
               <input name="Submit12" type="submit" id="submit" value="CREATE" class="btn btn-primary">
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
     <script language="javascript" type="text/javascript">

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
	
		function getType(plant_code) {		
		
		var strURL="findType-model.php?plant_code="+plant_code;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('mtype_div').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	//var strURL="agd-add00.php?idmtg="+idmtg+"&comp="+comp+"&year="+yr ;
	
	/*function getModel(plant_code,mat_type) {		
		
		var strURL="findModel-model.php?plant_code="+plant_code+"&mat_type="+mat_type;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('model_div').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	*/
	
	
	
</script>  <!-- Page specific javascripts-->
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