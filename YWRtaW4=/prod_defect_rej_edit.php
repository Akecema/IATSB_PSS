<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "display_prod_defect-reject.php"; 
	
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
    <link rel="shortcut icon" href="../images/favicon.ico">
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

$message_rejdesc = "";
$message_sta = "";
$message_procrjt = "";
$message_reason = "";
$message_tpe = "";
$message_def = "";
 
 if (isset($_POST['submit9']))
{

$defect_desc = $_POST['defect_desc'];
$status_defect = $_POST['status_defect'];
$id_proc = $_POST['id_proc'];
$id_type = $_POST['id_type'];
$id_defect = $_POST['id_defect'];
$id_reason = $_POST['id_reason'];
$defect_code = $_POST['defect_code'];

$message = NULL; // create an empty new variable.
	

	$i = 1;


	
// check for a defect_desc.
if (empty($_POST['defect_desc']))
{ $defect_desc = FALSE;
  $message_rejdesc = '<span class="badge badge-pill badge-danger">Please enter Defectives!</span>';
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
  $message_tpe = '<span class="badge badge-pill badge-danger">Please select Type of Reject!</span>';
  }
    else
  { $id_type = addslashes($_POST['id_type']);
  }

   
 if($defect_desc && $status_defect && $id_proc && $id_type && $id_defect) //everything ok
{
  
$defect_desc = $_POST['defect_desc'];
$status_defect = $_POST['status_defect'];
$id_proc = $_POST['id_proc'];
$id_type = $_POST['id_type'];
$id_defect = $_POST['id_defect'];
$id_reason = $_POST['id_reason']; 	
	
		$query_search = "SELECT * FROM type_defect_detail_prd WHERE id_defect = '".sql_esc($row2["id_defect"])."'";
		$result_search = mysqli_query($dbc,$query_search);   //run the query.
		$num_search = mysqli_num_rows($result_search);   //how many suppliers are there?
		
		if($num_search == 1) {
		//echo $num_search; 
		$row = mysqli_fetch_array($result_search);
		// make the update query
		
		$query_upd2 = "UPDATE type_defect_detail_prd SET defect_desc = '".sql_esc($defect_desc)."', status_defect = '".sql_esc($status_defect)."', id_proc = '".sql_esc($id_proc)."', id_type = '".sql_esc($id_type)."', id_reason = '".sql_esc($id_reason)."' WHERE id_defect = '".sql_esc($id_defect)."'"; 
		$result_upd2 = mysqli_query($dbc,$query_upd2); 
		
						
		if($result_upd2)
		{
			echo "<script>";
			echo "alert('Defectives is successfully updated.');";
			echo "window.location='display_prod_defect-reject.php'";
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
  <div class="modal fade" id="myNoteSloc<?php echo $row2["id_defect"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
         <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Defectives Reject</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Defectives Reject</strong>
       </div>
      <?php

$query_was = "SELECT * FROM type_defect_detail_prd WHERE id_defect = '".sql_esc($row2["id_defect"])."'";
$result_was = mysqli_query($dbc,$query_was);   //run the query.
$row_was = mysqli_fetch_array($result_was);   //how many records are there?
     
   ?>
   <form name="formEdit" method="post" action="" class="needs-validation"  novalidate>
   <table width="100%" cellspacing="5">
    <tr>
    <td width="191">Defectives Reject Desc. <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="defect_desc" name="defect_desc" value="<?php  echo $row_was["defect_desc"]; ?>" class="form-control" required><div class="invalid-feedback"><?php echo  $message_rejdesc; ?></div></td>
    </tr>
  <tr>
    <td>Status Defectives <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td>
      <select name="status_defect" id="status_defect" class="form-control">
                   <?php if($_POST['submit9'] == true)
						{ ?>
               <option value="Y" <?php if($_POST["status_defect"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($_POST["status_defect"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
               <?php 
						}
						else
						{ ?>
               <option value="Y" <?php if($row_was["status_defect"] == 'Y') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="N" <?php if($row_was["status_defect"] == 'N') { ?> selected="selected"<?php } ?>>INACTIVE</option>
               <?php } ?>
                 </select>
    
    
    <div class="invalid-feedback"><?php echo $message_sta; ?></div></td>
    </tr>
     <tr>
    <td width="191">Reason <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="id_reason" name="id_reason" value="<?php  echo $row_was["id_reason"]; ?>" class="form-control" required><div class="invalid-feedback"><?php echo  $message_reason; ?></div></td>
    </tr>
     <tr>
    <td>Production Process<font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td>
     <select name="id_proc" class="form-control" onChange="getType(this.value)">
            <option value="NULL" placeholder="Select Process"> -- Select Process -- </option>
          <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM proc_reject_detail_prd WHERE status_proc = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
         <option value="<?php echo $row27["id_proc"]; ?>" <?php if($row27["id_proc"] == $row_was["id_proc"]) { ?> selected="selected"<?php } ?>> <?php echo stripslashes($row27["id_proc"]); ?> - <?php echo $row27["proc_desc"]; ?></option>
          <?php
           }  ?>
                            
        </select>
                    
     <div class="form-control-feedback" ><?php echo $message_procrjt; ?></div></td>
    </tr>
     <tr>
    <td width="191">Type of Reject <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td width="971">
    
          <div id="mtype_div"> 
          <select name="id_type" id="id_type" class="form-control" onChange="getDType(this.value)">
          
          <?php
	
	$query48 = "SELECT * FROM type_reject_detail_prd WHERE id_proc = '".sql_esc($row_was["id_proc"])."' AND status_type = 'Y' ORDER BY id_type ASC";
    $result48 =mysqli_query($dbc,$query48);
	
	 while($row48 = mysqli_fetch_array($result48)) 
	  { 
				   
	
	?>  
          
          
          <option value="<?php echo $row48["id_type"]; ?>" <?php if($row48["id_type"] == $row_was["id_type"]) echo "selected"; ?>> <?php echo stripslashes($row48["id_type"]),' - ',stripslashes($row48["type_desc"]); ?></option>
  <?php   }  ?>
  
          </select>
          </div><div class="form-control-feedback" ><?php echo $message_tpe; ?></div>  
    </td>
    </tr>
      <tr>
    <td width="191">Defectives <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td width="971">
    
          <div id="dtype_div"> 
          <select name="defect_code" id="defect_code" class="form-control">
          
          <?php
	
	$queryD = "SELECT * FROM type_defect_detail_prd WHERE id_proc = '".sql_esc($row_was["id_proc"])."' AND id_type = '".sql_esc($row_was["id_type"])."' AND status_defect = 'Y' ORDER BY id_defect ASC";
    $resultD =mysqli_query($dbc,$queryD);
	
	 while($rowD = mysqli_fetch_array($resultD)) 
	  { 
				   
	?>  
          
          <option value="<?php echo $rowD["id_defect"]; ?>" <?php if($rowD["id_defect"] == $row_was["id_defect"]) echo "selected"; ?>> <?php echo stripslashes($rowD["id_defect"]),' - ',stripslashes($rowD["defect_desc"]); ?></option>
  <?php   }  ?>
  
          </select>
          </div> <div class="form-control-feedback" ><?php echo $message_def; ?></div> 
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
      <!--       <input type="hidden" id="id_type" name="id_type"  class="form-control" value="<?php echo $row2["id_type"];  ?>" > --> 
              <input type="hidden" id="id_defect" name="id_defect"  class="form-control" value="<?php echo $row2["id_defect"];  ?>" > 
             <input name="submit9" type="submit" id="submit9" value="UPDATE" class="btn btn-info" onClick="return confirm('Confirm to update?');" > 
             <button type="button" class="btn btn-success" data-dismiss="modal">CLOSE</button>
             </div>  
            
    </form>  
                  </div></div>
                  </div>
                  </div>
                  </div>
                  </div>
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
		
		var strURL="findType-prod-rej_edt.php?id_proc="+id_proc;
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
	
	
	function getDType(id_proc,id_type) {	
		
		var strURL="findDype-prod-rej_edt.php?id_proc="+id_proc+"&id_type="+id_type;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('dtype_div').innerHTML=req.responseText;						
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
                  
                  
</body>
</html>