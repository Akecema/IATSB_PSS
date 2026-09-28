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

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	
	
$url = "prod_reject_table.php"; 
	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?>">
    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <!----sort table https://stackoverflow.com/questions/10683712/html-table-sort/51648529---->
   <!-- <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>-->
    <!--  <script src="https://www.w3schools.com/lib/w3.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script> 
    
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    
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
          <p>Production Reject</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Table Maintenance</li>
          <li class="breadcrumb-item"><a href="prod_reject_table.php">Production Reject</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="prod_reject_table.php" >Add Process</a></li>
                <li class="nav-item"><a class="nav-link"  href="display_prod_reject.php">Display Process</a></li>
                <li class="nav-item"><a class="nav-link" href="prod_type-reject_table.php">Add Type</a></li>
                <li class="nav-item"><a class="nav-link"  href="display_prod_type-reject.php">Display Type</a></li>
                 <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="prod_defect-reject_table.php">Add Defect</a></li>
                <li class="nav-item"><a class="nav-link"  href="display_prod_defect-reject.php">Display Defect</a></li>
               <!-- <li class="nav-item"><a class="nav-link" href="prod_reason-reject_table.php">Add Reason</a></li>
                <li class="nav-item"><a class="nav-link" href="display_prod_reason-reject.php">Display Reason</a></li>-->
            </ul>
            
      <?php
	  
	  $message_rejdesc = "";
	  $message_sta = "";
	  $message_procrjt = "";
	  $message_rsn = "";
	  
if (isset($_POST['Submit7'])) 
{ // handle the form.


   $message = NULL; // create an empty new variable.
   
   $status_defect = $_POST['status_defect'];
   $defect_desc = $_POST['defect_desc'];
   $id_proc = $_POST['id_proc'];
   $id_type = $_POST['id_type'];
   $id_reason = $_POST['id_reason'];
  

// check for a reason_reject_desc.
if (empty($_POST['defect_desc']))
{ $defect_desc = FALSE;
  $message_rejdesc = '<span class="badge badge-pill badge-danger">Please enter Defectives Reject!</span>';
  }else
  { $defect_desc = addslashes($_POST['defect_desc']);
  }
  
// check for a status
if (empty($_POST['status_defect']) || ($_POST['status_defect'] == "NULL"))
{ 
  $status_defect = FALSE;
  $message_sta = '<span class="badge badge-pill badge-danger">Please select Status!</span>';
  }
    else
  { $status_defect = addslashes($_POST['status_defect']);
  }

// check for a process
if (empty($_POST['id_proc']) || ($_POST['id_proc'] == "NULL"))
{ 
  $id_proc = FALSE;
  $message_procrjt = '<span class="badge badge-pill badge-danger">Please select Process!</span>';
  }
    else
  { $id_proc = addslashes($_POST['id_proc']);
  }
  
  // check for a type
if (empty($_POST['id_type']) || ($_POST['id_type'] == "NULL"))
{ 
  $id_type = FALSE;
  $message_tyrjt = '<span class="badge badge-pill badge-danger">Please select Type of Reject!</span>';
  }
    else
  { $id_type = addslashes($_POST['id_type']);
  }
  
  // check for a reason
if (empty($_POST['id_reason']))
{ $id_reason = FALSE;
  $message_rsn = '<span class="badge badge-pill badge-danger">Please enter Reason Reject!</span>';
  }else
  { $id_reason = addslashes($_POST['id_reason']);
  }
   
 if($defect_desc && $status_defect && $id_proc && $id_type && $id_reason) //everything ok
{
	
   $status_defect = $_POST['status_defect'];
   $defect_desc = $_POST['defect_desc'];
   $id_proc = $_POST['id_proc'];
   $id_type = $_POST['id_type'];
   $id_reason = $_POST['id_reason'];

//register the user in the db.
$query_db = "INSERT INTO type_defect_detail_prd(id_defect,defect_desc,id_reason,status_defect,id_type,id_proc) VALUES
                                ('','".sql_esc($defect_desc)."','".sql_esc($id_reason)."','".sql_esc($status_defect)."','".sql_esc($id_type)."','".sql_esc($id_proc)."')";
$result = mysqli_query($dbc,$query_db) or die (mysqli_error($dbc));


             if($result)
             {
echo "<script>";
echo "alert('Defectives Reject is successfully created');";
echo "window.location='prod_defect-reject_table.php'";
echo "</script>";
			  exit(); //quit the script
             }
             else 
			 {
             $message = '<p><strong>Error!</strong> Cannot create Defectives Reject. </p>';
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
            <h3 class="tile-title">Defectives Reject</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Defectives Reject Desc. : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="defect_desc" type="text" class="form-control" id="defect_desc" size="20" maxlength="40" value="<?php if(isset($_POST['defect_desc'])) echo html_esc($_POST['defect_desc']); ?>"  placeholder="Enter Defectives Reject Description" />
                   <div class="form-control-feedback" ><?php echo $message_rejdesc; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Status Defect : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                     <select name="status_defect" id="status_defect" class="form-control">
                   <?php if($_POST['Submit7'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_defect"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($_POST["status_defect"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
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
                  <label class="control-label col-md-3">Reason : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                      <input name="id_reason" type="text" class="form-control" id="id_reason" size="20" maxlength="40" value="<?php if(isset($_POST['id_reason'])) echo html_esc($_POST['id_reason']); ?>"  placeholder="Enter Reason Reject" />
                    <div class="form-control-feedback" ><?php echo $message_rsn; ?></div>
                </div>
              </div>
              
              
              <div class="form-group row">
                  <label class="control-label col-md-3">Production Process : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                      		
           <select name="id_proc" class="form-control" onChange="getType(this.value)">
            <option value="NULL" placeholder="Select Process" > -- Select Process -- </option>
          <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM proc_reject_detail_prd WHERE status_proc = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
         <option value="<?php echo html_esc($row27["id_proc"]); ?>" > <?php echo stripslashes($row27["id_proc"]); ?> - <?php echo html_esc($row27["proc_desc"]); ?></option>
          <?php
           }  ?>
                            
        </select>
                    
                   <div class="form-control-feedback" ><?php echo $message_procrjt; ?></div>
                </div>
              </div>
              

          <div class="form-group row">
                  <label class="control-label col-md-3">Type Reject : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                    
                    
              <div id="mtype_div"> 
                <select name="id_type" id="id_type" class="form-control">
                <option value="NULL" placeholder="Select Type"> -- Select Type -- </option>
                </select>
              </div>  
       <div class="form-control-feedback" ><?php echo $message_tyrjt; ?></div>
                   </div>
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
	
	
		function getType(id_proc) {		
		
		var strURL="findType-prod-rej.php?id_proc="+id_proc;
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
	
</script>
    
    
    
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