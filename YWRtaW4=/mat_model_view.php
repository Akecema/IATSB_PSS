<?php
    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "display_model_table.php"; 
	
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
    <meta name="description" content="PSS ITSB Online, Ingress Technologies Sdn. Bhd.,Ingress ">
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
  <div class="modal fade" id="myNoteModel<?php echo html_esc($row2["id_model"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display Model of Material</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Display Model of Material</strong>
       </div>
   <?php

$query_mod = "SELECT * from model_detail_tbl where id_model = '".sql_esc($row2["id_model"])."'";
$result_mod = mysqli_query($dbc,$query_mod);   //run the query.
$row_mod = mysqli_fetch_array($result_mod);   //how many records are there?


      //--- material type --------
	    $query_mat_type = new PreparedSql("SELECT * FROM material_type_tbl WHERE id = ?", [$row_mod["material_type"]]);
		$result_mat_type = db_query($dbc, $query_mat_type) or die (mysqli_error($dbc));
        $data_mat_type = mysqli_fetch_array($result_mat_type);

      //---model ----
        if($row_mod["status_model"] == "Y")
	    {
	     $sts = "Active";
		 }
		 else{
		 $sts = "Inactive";
		 }


     //---services part ----
     if($row_mod["services_part"] == "Y")
     {
      $services_part = "Yes";
    }
    else{
      $services_part = "No";
    }
     
   ?>

   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">ID Model </td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="id_model" name="id_model" readonly value="<?php  echo html_esc($row_mod["id_model"]); ?>" class="form-control"></td>
    </tr>
    <tr>
    <td width="191">Model Code </td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="model_code" name="model_code" readonly value="<?php  echo html_esc($row_mod["model_code"]); ?>" class="form-control"></td>
    </tr>
  <tr>
    <td>Model Description </td>
    <td width="28">:</td>
    <td><input type="text" id="model_desc" name="model_desc" readonly value="<?php echo html_esc($row_mod["model_desc"]); ?>" class="form-control"/></td>
    </tr>
  <tr>
    <td>Plant Code</td>
    <td>:</td>
    <td><input type="text" id="plant_code" name="plant_code" readonly value="<?php echo html_esc($row_mod["plant_code"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Material Type</td>
    <td>:</td>
    <td><input type="text" id="material_type" name="material_type" readonly value="<?php echo html_esc($data_mat_type["mat_type_id"]), ' - ' .html_esc($data_mat_type["mtype_name"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Status Account</td>
    <td>:</td>
    <td><input type="text" id="status_model" name="status_model" readonly value="<?php echo $sts;  ?>" class="form-control"/>
     </td>
    </tr>
    <tr>
    <td>Services Part</td>
    <td>:</td>
    <td><input type="text" id="services_part" name="services_part" readonly value="<?php echo $services_part;  ?>" class="form-control"/>
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