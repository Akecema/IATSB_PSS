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
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>

  </head>
  <body class="app sidebar-mini">
  <div class="modal fade" id="myNoteWork<?php echo $row2["id_work"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display Work Center</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Display Work Center</strong>
       </div>
   <?php

$query_work = "SELECT * FROM work_center_detail WHERE id_work = '".sql_esc($row2["id_work"])."'";
$result_work = mysqli_query($dbc,$query_work);   //run the query.
$row_work = mysqli_fetch_array($result_work);   //how many records are there?

    
	
	 if($row_work["prod_cat"] == 'A')
	 {
		 
	  $pd_cat = "ASSEMBLY";
	  
	 }elseif($row_work["prod_cat"] == 'S')
	 {
		 
		$pd_cat = "STAMPING"; 
		 
	 }else{
		 
		 $pd_cat = ""; 
	    }



     
   ?>

   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">Work Center </td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="id_work" name="id_work" readonly value="<?php  echo $row_work["id_work"]; ?>" class="form-control"></td>
    </tr>
  <tr>
    <td>Work Center Description</td>
    <td width="28">:</td>
    <td><input type="text" id="wc_desc" name="wc_desc" readonly value="<?php echo $row_work["wc_desc"]; ?>" class="form-control"/></td>
    </tr>
  <tr>
    <td>Plant Code</td>
    <td>:</td>
    <td><input type="text" id="plant_code" name="plant_code" readonly value="<?php echo $row_work["plant_code"];  ?>" class="form-control"/>
     </td>
    </tr>
  <tr>
    <td>Cost Center</td>
    <td>:</td>
    <td><input type="text" id="cost_center" name="cost_center" readonly value="<?php echo $row_work["cost_center"];  ?>" class="form-control"/>
     </td>
    </tr>
      <tr>
    <td>Cost Center Description</td>
    <td>:</td>
   <td><input type="text" id="cc_desc" name="cc_desc" readonly value="<?php echo $row_work["cc_desc"];  ?>" class="form-control"/> </td>
    </tr>
     <tr>
    <td>Factory</td>
    <td>:</td>
    <td><input type="text" id="id_factory" name="id_factory" readonly value="<?php echo $row_work["id_factory"];  ?>" class="form-control" /></td>
    </tr>
    <tr>
    <td>Department Account</td>
    <td>:</td>
    <td><input type="text" id="dept_acc" name="dept_acc" readonly value="<?php echo $row_work["dept_acc"];  ?>" class="form-control" /></td>
    </tr>
    <tr>
    <td>Status Account</td>
    <td>:</td>
    <td><input type="text" id="status_wc" name="status_wc" readonly value="<?php echo $row_work["status_wc"];  ?>" class="form-control" /></td>
    </tr>
    <tr>
    <td>Model Description</td>
    <td>:</td>
    <td><input type="text" id="wc_desc2" name="wc_desc2" readonly value="<?php echo $row_work["wc_desc2"];  ?>" class="form-control" /></td>
    </tr>
     <tr>
    <td>Category Material</td>
    <td>:</td>
    <td><input type="text" id="prod_cat" name="prod_cat" readonly value="<?php echo $pd_cat;  ?>" class="form-control" /></td>
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