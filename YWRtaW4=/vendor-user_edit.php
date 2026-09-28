<?php
    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "display-vendor_user.php"; 
	
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
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    <!--  <script src="https://www.w3schools.com/lib/w3.js"></script>-->
	
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

$username1 = $_POST['username1'];
$id_ath = $_POST['id_ath'];
$ath_status = $_POST['ath_status'];
$vendor_id = $_POST['vendor_id'];

$message = NULL; // create an empty new variable.
	

	$i = 1;

	//------------------------------end function --------------------------------

	
	// check for a status
	if(empty($_POST['ath_status'])) 
	{ 
		$ath_status = FALSE;
		
	}
	else
	{ 
		$ath_status = addslashes($_POST['ath_status']);
	}

   
	if($ath_status) //everything ok
	{  
	
	$username1 = $_POST['username1'];
	$id_ath = $_POST['id_ath'];
	$ath_status = $_POST['ath_status'];
	$vendor_id = $_POST['vendor_id'];	
	
		
		
		$query_upd2 = "UPDATE function_ath_vendordetail SET ath_status = '".sql_esc($_POST['ath_status'])."' WHERE id_ath = '".sql_esc($id_ath)."'"; 
		$result_upd2 = mysqli_query($dbc,$query_upd2); 
		
						
		if($result_upd2)
		{
			echo "<script>";
			echo "alert('Assign vendor is successfully updated.');";
			echo "window.location='display-vendor_user.php'";
			echo "</script>"; 
			exit(); //quit the script						
		} 
		else 
		{ 
			echo 'Cannot update record'; 
		}

		  
} 


} 
 ?> 
  <div class="modal fade" id="myNoteAth<?php echo html_esc($row2["id_ath"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
         <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit Assign Vendor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Assign Vendor</strong>
       </div>
      <?php

$query_was = "SELECT * FROM function_ath_vendordetail WHERE id_ath = '".sql_esc($row2["id_ath"])."'";
$result_was = mysqli_query($dbc,$query_was);   //run the query.
$row_was = mysqli_fetch_array($result_was);   //how many records are there?
     
	//-----------vendor info ---------- 
	 
	 
	 
	
   ?>
   <form name="formEdit" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" class="needs-validation"  novalidate>
   <table width="100%" cellspacing="5">
  
    <tr>
    <td>User<font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td><input type="text" id="username1" name="username1" readonly value="<?php echo html_esc($row_was["username"]); ?>" class="form-control"  /><div class="invalid-feedback">Please enter username.</div></td>
    </tr>
    <tr>
    <td>Vendor<font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td><input type="text" id="vendor_id" name="vendor_id" readonly value="<?php echo html_esc($row_was["vendor_id"]); ?>" class="form-control"  /><div class="invalid-feedback">Please select vendor.</div></td>
    </tr>
     <tr>
    <td>Status <font color="#FF0000">*</font></td>
    <td width="28">:</td>
    <td>
      <select name="ath_status" id="ath_status" class="form-control" required >
      <option value="NULL" placeholder="Select Status"> -- Select Status --</option>
      <option value="Y" <?php if($row_was["ath_status"] == "Y") { ?> selected="selected"<?php } ?>>Active</option>
      <option value="N" <?php if($row_was["ath_status"] == "N") { ?> selected="selected"<?php } ?>>Inactive</option>
      </select> <div class="invalid-feedback">Please select status .</div></td>
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
             <input type="hidden" id="id_ath" name="id_ath"  class="form-control" value="<?php echo html_esc($row2["id_ath"]);  ?>" >  
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