<?php
    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "mat_detail_table.php"; 
	
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
  <div class="modal fade" id="myNoteCon<?php echo html_esc($row2["id_mat"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display Material Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Display Material Details</strong>
       </div>
   <?php

$query_con = "SELECT * FROM  table_material_itsb WHERE id_mat = '".sql_esc($row2["id_mat"])."'";
$result_con = mysqli_query($dbc,$query_con);   //run the query.
$row_con = mysqli_fetch_array($result_con);   //how many records are there?
  
  
        //---material type info -------
	   $query_vmat_type = new PreparedSql("SELECT * FROM material_type_tbl WHERE id = ?", [$row_con["mat_type"]]);
	   $result_vmat_type = db_query($dbc, $query_vmat_type) or die (mysqli_error($dbc));
       $res_vmat_type = mysqli_fetch_array($result_vmat_type);   
	   
	    //---model code info -------
	   $query_model_cd = new PreparedSql("SELECT * FROM model_detail_tbl WHERE id_model = ?", [$row_con["model_code"]]);
	   $result_model_cd = db_query($dbc, $query_model_cd) or die (mysqli_error($dbc));
       $res_model_cd = mysqli_fetch_array($result_model_cd);   
	   
	   //----category mat category_detail
	   $query_cat_mat = "SELECT * FROM category_detail WHERE stamp_ind = '".sql_esc($row_con["category_mat"])."'";
	   $result_cat_mat = mysqli_query($dbc,$query_cat_mat) or die (mysqli_error($dbc));
       $res_cat_mat = mysqli_fetch_array($result_cat_mat);  
   ?>

   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">Material No. </td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="material_no" name="material_no" readonly value="<?php  echo html_esc($row_con["material_no"]); ?>" class="form-control"></td>
    </tr>
  <tr>
    <td>Material  Description</td>
    <td width="28">:</td>
    <td><input type="text" id="material_desc" name="material_desc" readonly value="<?php echo html_esc($row_con["material_desc"]); ?>" class="form-control"/></td>
    </tr>
  <tr>
    <td>Plant Code</td>
    <td>:</td>
    <td><input type="text" id="plant_code" name="plant_code" readonly value="<?php echo html_esc($row_con["plant_code"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Material Type</td>
    <td>:</td>
    <td><input type="text" id="mat_type" name="mat_type" readonly value="<?php echo html_esc($row_con["mat_type"]);  ?> - <?php echo  html_esc($res_vmat_type["mtype_name"]); ?>" class="form-control"/>
     </td>
    </tr>
  <tr>
    <td>Line</td>
    <td>:</td>
    <td><input type="text" id="prod_line" name="prod_line" readonly value="<?php echo html_esc($row_con["prod_line"]);  ?>" class="form-control"/>
     </td>
    </tr>
    <tr>
     <td>Material of Group</td>
    <td>:</td>
    <td><input type="text" id="material_group" name="material_group" readonly value="<?php echo html_esc($row_con["material_group"]);  ?> " class="form-control"/>
     </td>
    </tr>
      <tr>
    <td>BUn</td>
    <td>:</td>
   <td><input type="text" id="BUn" name="BUn" readonly value="<?php echo html_esc($row_con["BUn"]);  ?>" class="form-control"/> </td>
    </tr>
    <tr>
     <td>VClass</td>
    <td>:</td>
    <td><input type="text" id="Vclass" name="Vclass" readonly value="<?php echo html_esc($row_con["Vclass"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Model Code</td>
    <td>:</td>
    <td><input type="text" id="model_code" name="model_code" readonly value="<?php echo html_esc($res_model_cd["model_code"]);  ?> - <?php echo html_esc($res_model_cd["model_desc"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Category Material</td>
    <td>:</td>
    <td><input type="text" id="category_mat" name="category_mat" readonly value="<?php echo html_esc($row_con["category_mat"]);  ?> - <?php echo html_esc($res_cat_mat["stamp_desc"]); ?>" class="form-control"/>
     </td>
    </tr>
    <tr>
     <td>Standard Package</td>
    <td>:</td>
    <td><input type="text" id="std_packaging" name="std_packaging" readonly value="<?php echo html_esc($row_con["std_packaging"]);  ?> " class="form-control"/>
     </td>
    </tr>
    <tr>
     <td>Type Package</td>
    <td>:</td>
    <td><input type="text" id="type_package" name="type_package" readonly value="<?php echo html_esc($row_con["type_package"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Part Side</td>
    <td>:</td>
    <td><input type="text" id="part_side" name="part_side" readonly value="<?php echo html_esc($row_con["part_side"]);  ?>" class="form-control"/>
     </td>
    </tr>
      <tr>
     <td>Back No.</td>
    <td>:</td>
    <td><input type="text" id="back_no" name="back_no"  readonly value="<?php echo html_esc($row_con["back_no"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Storage Location</td>
    <td>:</td>
    <td><input type="text" id="sloc" name="sloc" readonly value="<?php echo html_esc($row_con["sloc"]);  ?>" class="form-control"/>
     </td>
    </tr>
    <tr>
     <td>Size Dim</td>
    <td>:</td>
    <td><input type="text" id="size_dim" name="sloc" readonly value="<?php echo html_esc($row_con["size_dim"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Customer Part No.</td>
    <td>:</td>
    <td><input type="text" id="cust_part_no" name="cust_part_no" readonly value="<?php echo html_esc($row_con["cust_part_no"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Customer Part Name</td>
    <td>:</td>
    <td><input type="text" id="material_desc_cust" name="material_desc_cust" readonly value="<?php echo html_esc($row_con["material_desc_cust"]);  ?>" class="form-control"/>
     </td>
    </tr>
    <tr>
     <td>Production Part No.</td>
    <td>:</td>
    <td><input type="text" id="prod_part_no" name="prod_part_no" readonly value="<?php echo html_esc($row_con["prod_part_no"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Vendor Code</td>
    <td>:</td>
    <td><input type="text" id="vendor_id" name="vendor_id" readonly value="<?php echo html_esc($row_con["vendor_id"]);  ?>" class="form-control"/>
     </td>
    </tr> 
    <tr>
     <td>Vendor Name</td>
    <td>:</td>
    <td><input type="text" id="vendor_desc" name="vendor_desc" readonly value="<?php echo html_esc($row_con["vendor_desc"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Material Group</td>
    <td>:</td>
    <td><input type="text" id="mat_group" name="mat_group" readonly value="<?php echo html_esc($row_con["mat_group"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Account Group</td>
    <td>:</td>
    <td><input type="text" id="acc_group" name="acc_group" readonly value="<?php echo html_esc($row_con["acc_group"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>PP Log No.</td>
    <td>:</td>
    <td><input type="text" id="pp_log_no" name="pp_log_no" readonly value="<?php echo html_esc($row_con["pp_log_no"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>PP Log Description</td>
    <td>:</td>
    <td><input type="text" id="pp_log_desc" name="pp_log_desc" readonly value="<?php echo html_esc($row_con["pp_log_desc"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Customer Code</td>
    <td>:</td>
    <td><input type="text" id="cust_code" name="cust_code" readonly value="<?php echo html_esc($row_con["cust_code"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
     <td>Customer Name</td>
    <td>:</td>
    <td><input type="text" id="cust_name" name="cust_name" readonly value="<?php echo html_esc($row_con["cust_name"]);  ?>" class="form-control"/>
     </td>
    </tr>
     <tr>
    <td>Status [ Y = Active ; N = Inactive ]</td>
    <td>:</td>
    <td>
    <?php
	
	if($row_con["status_BOM"] == "Y")
	{
		$sta = "Active";
	}else{
		
		$sta = "Inactive";
		
	}
	
	
	?>
    <input type="text" id="status_BOM" name="status_BOM" readonly value="<?php echo html_esc($row_con["status_BOM"]). '-'.$sta;  ?>" class="form-control" /></td>
    </tr>
      <tr>
    <td>Status FOC [ Y = Active ; N = Inactive ]</td>
    <td>:</td>
    <td>
    <?php
	
	if($row_con["status_foc"] == "Y")
	{
		$stafoc = "Active";
	}else{
		
		$stafoc = "Inactive";
		
	}
	
	
	?>
    <input type="text" id="status_foc" name="status_foc" readonly value="<?php echo html_esc($row_con["status_foc"]). '-'.$stafoc;  ?>" class="form-control" /></td>
    </tr>
      <tr>
    <td>Status Spare Part [ Y = Active ; N = Inactive ]</td>
    <td>:</td>
    <td>
    <?php
	
	if($row_con["status_sp"] == "Y")
	{
		$stasp = "Active";
	}else{
		
		$stasp = "Inactive";
		
	}
	
	
	?>
    <input type="text" id="status_sp" name="status_sp" readonly value="<?php echo html_esc($row_con["status_sp"]). '-'.$stasp;  ?>" class="form-control" /></td>
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