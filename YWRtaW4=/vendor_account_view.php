<?php
    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "add_vendor_account.php"; 
	
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
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>

  </head>
  <body class="app sidebar-mini">
  <div class="modal fade" id="myNoteVendor<?php echo html_esc($row2["vendor_code"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display Vendor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Display Vendor</strong>
       </div>
   <?php
	$query_ven = "SELECT *, DATE_FORMAT(date_create,'%d-%m-%Y') AS R, DATE_FORMAT(date_update,'%d-%m-%Y') AS R2 FROM vendor_detail WHERE vendor_code = '".sql_esc($row2["vendor_code"])."'";
	$result_ven = mysqli_query($dbc,$query_ven);   //the query.
	$row_ven = mysqli_fetch_array($result_ven);   //how many records are there?


//----user created -----

    $query_create = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$row_ven["user_create"]]);
    $result_create = db_query($dbc, $query_create) or die (mysqli_error($dbc));
    $data_create = mysqli_fetch_array($result_create);
	
	//----user updated -----

    $query_update = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$row_ven["user_update"]]);
    $result_update = db_query($dbc, $query_update) or die (mysqli_error($dbc));
    $data_update = mysqli_fetch_array($result_update);
	
	if($row_ven["status_acc"] == "Y")
	{
		$sta_acc = "Active";
		
	}else
	{
		$sta_acc = "In Active";
	}




   if($row_ven["status_subcont"] == "Y")
	{
		$sta_sub = "YES";
		
	}else
	{
		$sta_sub = "NO";
	}
	
	
	 if($row_ven["status_foc"] == "Y")
	{
		$sta_foc = "YES";
		
	}else
	{
		$sta_foc = "NO";
	}
     
   ?>

   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">Vendor Code </td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="vendor_code" name="id_reason_wastage" readonly value="<?php  echo html_esc($row_ven["vendor_code"]); ?>" class="form-control"></td>
    </tr>
  <tr>
    <td>Vendor Name </td>
    <td width="28">:</td>
    <td><input type="text" id="vendor_name" name="vendor_name" readonly value="<?php echo html_esc($row_ven["vendor_name"]); ?>" class="form-control"/></td>
    </tr>
  <tr>
    <td>Search Term</td>
    <td>:</td>
    <td><input type="text" id="search_term" name="search_term" readonly value="<?php echo html_esc($row_ven["search_term"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Address No. 1</td>
    <td>:</td>
    <td><input type="text" id="add_no1" name="add_no1" readonly value="<?php echo html_esc($row_ven["add_no1"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Address No. 2</td>
    <td>:</td>
    <td><input type="text" id="add_no2" name="add_no2" readonly value="<?php echo html_esc($row_ven["add_no2"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Postcode</td>
    <td>:</td>
    <td><input type="text" id="post_code" name="post_code" readonly value="<?php echo html_esc($row_ven["post_code"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>City</td>
    <td>:</td>
    <td><input type="text" id="post_city" name="post_city" readonly value="<?php echo html_esc($row_ven["post_city"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Region</td>
    <td>:</td>
    <td><input type="text" id="post_region" name="post_region" readonly value="<?php echo html_esc($row_ven["post_region"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Country</td>
    <td>:</td>
    <td><input type="text" id="post_country" name="post_country" readonly value="<?php echo html_esc($row_ven["post_country"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Phone</td>
    <td>:</td>
    <td><input type="text" id="tphone" name="tphone" readonly value="<?php echo html_esc($row_ven["tphone"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Fax</td>
    <td>:</td>
    <td><input type="text" id="fax_no" name="fax_no" readonly value="<?php echo html_esc($row_ven["fax_no"]);  ?>" class="form-control"/>
     </td>
    </tr>
      <tr>
    <td>Payment Method</td>
    <td>:</td>
    <td><input type="text" id="payment_method" name="payment_method" readonly value="<?php echo html_esc($row_ven["payment_method"]);  ?>" class="form-control"/>
     </td>
    </tr>
      <tr>
    <td>Term Payment</td>
    <td>:</td>
    <td><input type="text" id="term_payment" name="term_payment" readonly value="<?php echo html_esc($row_ven["term_payment"]);  ?>" class="form-control"/>
     </td>
    </tr>
      <tr>
    <td>User Created</td>
    <td>:</td>
    <td><input type="text" id="user_create" name="user_create" readonly value="<?php echo html_esc($data_create["user_fullname"]);  ?>" class="form-control"/>
     </td>
    </tr>  <tr>
    <td>Date Created</td>
    <td>:</td>
    <td><input type="text" id="date_create" name="date_create" readonly value="<?php echo html_esc($row_ven["date_create"]);  ?>" class="form-control"/>
     </td>
    </tr>  <tr>
    <td>User Updated</td>
    <td>:</td>
    <td><input type="text" id="user_update" name="user_update" readonly value="<?php echo html_esc($data_update["user_fullname"]);  ?>" class="form-control"/>
     </td>
    </tr>  
    <tr>
    <td>Date Updated</td>
    <td>:</td>
    <td><input type="text" id="date_update" name="date_update" readonly value="<?php echo html_esc($row_ven["date_update"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Status Account <br>(Y = Active, N = In Active)</td>
    <td>:</td>
    <td><input type="text" id="status_acc" name="status_acc" readonly value="<?php echo html_esc($row_ven["status_acc"]).'='.$sta_acc;	?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Status Subcont <br> (Y = YES, N = NO)</td>
    <td>:</td>
    <td><input type="text" id="status_subcont" name="status_subcont" readonly value="<?php echo html_esc($row_ven["status_subcont"]).'='.$sta_sub;	?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Status FOC <br> (Y = YES, N = NO)</td>
    <td>:</td>
    <td><input type="text" id="status_foc" name="status_foc" readonly value="<?php echo html_esc($row_ven["status_foc"]).'='.$sta_foc;	?>" class="form-control"/>
     </td>
    </tr>
     </table>                         
       </div> <!-- card -->
       </div><!-- /# card -->
       <br />
              <div class="modal-footer">  
               <button type="button" class="btn btn-success" data-dismiss="modal">CLOSE</button>    
            <!--  <input type="submit" name="submit2" value="Close" class="btn btn-success" />-->
             </div>  
             
      
                  </div></div>
                  </div>
                  </div>
                  </div>
                  </div>
</body>
</html>