<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "con_detail_table.php"; 
	
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
  <div class="modal fade" id="myNoteCon<?php echo $row2["id_con"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display Consumable Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Display Consumable Details</strong>
       </div>
   <?php

$query_con = "SELECT * FROM consumable_detail WHERE id_con = '".sql_esc($row2["id_con"])."'";
$result_con = mysqli_query($dbc,$query_con);   //run the query.
$row_con = mysqli_fetch_array($result_con);   //how many records are there?
     
   ?>

   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">Material No. </td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="material_no" name="material_no" readonly value="<?php  echo $row_con["material_no"]; ?>" class="form-control"></td>
    </tr>
  <tr>
    <td>Material  Description</td>
    <td width="28">:</td>
    <td><input type="text" id="mat_desc" name="mat_desc" readonly value="<?php echo $row_con["mat_desc"]; ?>" class="form-control"/></td>
    </tr>
  <tr>
    <td>Plant Code</td>
    <td>:</td>
    <td><input type="text" id="plant" name="plant" readonly value="<?php echo $row_con["plant"];  ?>" class="form-control"/>
     </td>
    </tr>
  <tr>
    <td>Cost Center</td>
    <td>:</td>
    <td><input type="text" id="cost_center" name="cost_center" readonly value="<?php echo $row_con["cost_center"];  ?>" class="form-control"/>
     </td>
    </tr>
      <tr>
    <td>BUn</td>
    <td>:</td>
   <td><input type="text" id="BUn" name="BUn" readonly value="<?php echo $row_con["BUn"];  ?>" class="form-control"/> </td>
    </tr>
     <tr>
    <td>Status [ Y = Active ; N = Inactive</td>
    <td>:</td>
    <td>
    <?php
	
	if($row_con["con_status"] == "Y")
	{
		$sta = "Active";
	}else{
		
		$sta = "Inactive";
		
	}
	
	
	?>
    <input type="text" id="con_status" name="con_status" readonly value="<?php echo $row_con["con_status"]. '-'.$sta;  ?>" class="form-control" /></td>
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