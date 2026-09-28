<?php

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "index_admin.php"; 
	
//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	

//--------menu function ------------------------------

$query_function = new PreparedSql("SELECT * FROM function_acc_detail WHERE staff_ID = ?", [$res["staff_ID"]]);
$result_function = db_query($dbc, $query_function);   //run the query.
$data_function = mysqli_fetch_array($result_function);   //how many records are there?  

include 'apprv_func_list.php';
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
  <div class="modal fade" id="myNoteUser<?php echo html_esc($row["user_no"]); ?><?php echo html_esc($row["staff_ID"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">View Account</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Account Profile</strong>
       </div>
    

   <table width="100%" cellspacing="5">
   <tr>
    <td width="191">Company Code</td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="vendor_no" name="vendor_no" readonly value="<?php  echo html_esc($row[1]); ?>" class="form-control"></td>
    </tr>
  <tr>
    <td>Staff ID</td>
    <td width="28">:</td>
    <td><input type="text" id="staff_ID" name="staff_ID" readonly value="<?php echo html_esc($row["staff_ID"]); ?>" class="form-control"/></td>
    </tr>
  <tr>
    <td>Name</td>
    <td>:</td>
    <td><input type="text" id="user_fullname" name="user_fullname" readonly value="<?php echo html_esc($row["user_fullname"]);  ?>" class="form-control"/>
     </td>
    </tr>
  <tr>
    <td>Company</td>
    <td>:</td>
    <td><?php		
 	
  //Retrieve and display the available types
  $query3 = "SELECT * FROM company WHERE comp_code = '".sql_esc($row["company"])."'";
  $result3 = mysqli_query($dbc,$query3);
  $row3 = mysqli_fetch_array($result3);
  

	?>
      <input type="text" id="company" name="company" readonly value="<?php echo html_esc($row3["comp_code"]); ?> - <?php echo html_esc($row3["comp_name"]); ?>" class="form-control" /></td>
    </tr>
  <tr>
    <td>Department</td>
    <td>:</td>
    <td><?php		
   //Retrieve and display the available types
  $query2 = "SELECT * from department WHERE id_dept = '".sql_esc($row[6])."'";
  $result2 = db_query($dbc, $query2);
   $row2 = mysqli_fetch_array($result2);
	    
		
	
	?>
      <input type="text" id="department" name="department" readonly value="<?php echo html_esc($row2["dept_name"]);  ?>" class="form-control" /></td>
    </tr>
  <tr>
    <td>Designation</td>
    <td>:</td>
    <td><?php		

  //Retrieve and display the available types
  $query2b = "SELECT * FROM designation WHERE id_design = '".sql_esc($row["designation"])."'";
  $result2b = mysqli_query($dbc,$query2b);
   $row2b = mysqli_fetch_array($result2b);
   
  

	?>  <input type="text" id="designation" name="designation" readonly value="<?php echo html_esc($row2b[1]);  ?>" class="form-control" /></td>
    </tr>
  <tr>
    <td>Telephone No. 1</td>
    <td>:</td>
    <td><input type="text" id="user_telno1" name="user_telno1" readonly value="<?php echo html_esc($row["user_telno1"]);  ?>" class="form-control" /></td>
    </tr>
  <tr>
    <td>Telephone No. 2</td>
    <td>:</td>
    <td><input type="text" id="user_telno2" name="user_telno2" readonly value="<?php echo html_esc($row["user_telno2"]);  ?>" class="form-control" /></td>
    </tr>
  <tr>
    <td>Fax No.</td>
    <td>:</td>
    <td><input type="text" id="user_fax" name="user_fax" readonly value="<?php echo html_esc($row["user_fax"]); ?>" class="form-control" /></td>
    </tr>
      <tr>
    <td>Email</td>
    <td>:</td>
    <td><input type="text" id="user_email" name="user_email" readonly value="<?php echo html_esc($row["user_email"]); ?>" class="form-control" /></td>
    </tr>
    <tr>
    <td>Level</td>
    <td>:</td>
    <td><?php		
 
  //Retrieve and display the available types
  $query4 = "SELECT * FROM level_detail WHERE status_level = 'Y' AND id_level = '".sql_esc($row["level_id"])."'";
  $result4 = mysqli_query($dbc,$query4);
  $row4 = mysqli_fetch_array ($result4);
	  
	
	?><input type="text" id="level_id" name="level_id" readonly value="<?php  echo html_esc($row4["desc_level"]); ?>" class="form-control" /></td>
    </tr>
      <tr>
    <td>Status User</td>
    <td>:</td>
    <td> <?php
	 
	  if($row["status"] == "AC")
	  {
	     $sts = "Active";
		 }
		 else{
		 $sts = "Inactive";
		 }
	 
	    //--------------------------
	
	            $query_search2 = new PreparedSql("SELECT * FROM function_acc_detail WHERE staff_ID = ?", [$row["staff_ID"]]);
              $result_search2 = db_query($dbc, $query_search2);   //run the query.
              $num_search2 = mysqli_num_rows($result_search2);   //how many suppliers are there?
			        $row_ath_all = mysqli_fetch_array($result_search2);   
	
	
	
	
	  
      ?><input type="text" id="status" name="status" readonly value="<?php  echo $sts;  ?>" class="form-control" /></td>
    </tr>
     <tr>
    <td>User Created</td>
    <td>:</td>
    <td><input type="text" id="user_created" name="user_created" readonly value="<?php echo html_esc($row["user_created"]);  ?>" class="form-control" /></td>
    </tr>
  <tr>
    <td>Date Created</td>
    <td>:</td>
    <td><input type="text" id="date_created" name="date_created" readonly value="<?php echo html_esc($row["date_created"]);  ?>" class="form-control" /></td>
    </tr>
    <tr>
    <td width="191">Company Code</td>
    <td width="28">:</td>
    <td width="971"><input type="text" id="vendor_no" name="vendor_no" readonly value="<?php  echo html_esc($row["vendor_no"]); ?>" class="form-control"></td>
    </tr>
    </table>
    </div>
    </div>
    <br>
    
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Production Roles Details</strong>
       </div>
       
     <table>
      <tr>
      <td>User Roles Details</td>
      <td>:</td> 
      <td>
       <!--- dashboard ---->
               
               <p><b>Dashboard</b></p>
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash" name="main_dash" disabled value="Y" <?php if($row_ath_all["main_dash"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Dashboard 1</span>
                  </label>
                </div>  
            
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash2" name="main_dash2" disabled value="Y" <?php if($row_ath_all["main_dash2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Dashboard 2</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash3"  name="main_dash3" disabled value="Y" <?php if($row_ath_all["main_dash3"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Dashboard 3</span>
                  </label>
                </div> 
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash4" name="main_dash4" disabled value="Y" <?php if($row_ath_all["main_dash4"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Dashboard 4</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash5"  name="main_dash5" disabled value="Y" <?php if($row_ath_all["main_dash5"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Dashboard 5</span>
                  </label>
                </div>  
                
                <hr width="100%"> 
      
              <p><b>Category Production</b></p>
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="prd_cat" name="prd_cat" disabled value="Y" <?php if($row_ath_all["prd_cat"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Category Production</span>
                  </label>
                </div>  
            
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_stamp_prd" name="f_stamp_prd" disabled value="Y" <?php if($row_ath_all["f_stamp_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Stamping</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_assy_prd"  name="f_assy_prd" disabled value="Y" <?php if($row_ath_all["f_assy_prd"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Assembly</span>
                  </label>
                </div>  
                
                 <hr width="100%">  
              <!---  PLanning Menu ------>
               <p><b>Planning</b></p>
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="prd_plan" name="prd_plan" disabled value="Y" <?php if($row_ath_all["prd_plan"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Planning</span>
                  </label>
                </div>  
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_plan_prd" name="f_ftp_plan_prd" disabled value="Y" <?php if($row_ath_all["f_ftp_plan_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Create Planned Order</span>
                  </label>
                </div> 
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_upl_plan_prd" name="f_upl_plan_prd" disabled value="Y" <?php if($row_ath_all["f_upl_plan_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Upload PPS</span>
                  </label>
                </div> 
                 
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_view_plan_prd"  name="f_view_plan_prd" disabled value="Y" <?php if($row_ath_all["f_view_plan_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">PPS Listings</span>
                  </label>
                </div>  
              
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_close_plan_prd" name="f_close_plan_prd" disabled value="Y" <?php if($row_ath_all["f_close_plan_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Close Planned Order</span>
                  </label>
                </div>  
              
                <hr width="100%">  
                
                <!-- Delivery Instruction --->
              
               <p><b>Delivery Instruction</b></p>
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_di" name="main_di" disabled value="Y" <?php if($row_ath_all["main_di"] == 'Y'){ ?> checked <?php  } ?> ><span class="button-indecator">Delivery Instruction</span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di" name="f_dlv_di" disabled value="Y" <?php if($row_ath_all["f_dlv_di"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Upload DI/Kanban</span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di2" name="f_dlv_di2" disabled value="Y" <?php if($row_ath_all["f_dlv_di2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Inbox</span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di3" name="f_dlv_di3" disabled value="Y" <?php if($row_ath_all["f_dlv_di3"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Print DO &amp;Tag</span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di6" name="f_dlv_di6" disabled value="Y" <?php if($row_ath_all["f_dlv_di6"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Print DO &amp;Tag PPC</span>
                  </label>
                </div>
              
              <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di5" name="f_dlv_di5" disabled value="Y" <?php if($row_ath_all["f_dlv_di5"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Maintain DO</span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di4" name="f_dlv_di4" disabled value="Y" <?php if($row_ath_all["f_dlv_di4"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Maintain DI</span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dlv_di7" name="f_dlv_di7" disabled value="Y" <?php if($row_ath_all["f_dlv_di7"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">PO vs GR (Quantity) </span>
                  </label>
                </div>  
                
                <hr width="100%">  
            
                
                 <!-- Receiving  --->
               <p><b>Receiving</b></p>
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="pc_rec" name="pc_rec" disabled value="Y" <?php if($row_ath_all["pc_rec"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Receiving</span>
                  </label>
                </div>  
             
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gr_rec" name="f_gr_rec" disabled value="Y" <?php if($row_ath_all["f_gr_rec"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Goods Receipt</span>
                  </label>
                </div>     
                
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_grfoc_rec" name="f_grfoc_rec" disabled value="Y" <?php if($row_ath_all["f_grfoc_rec"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt FOC</span>
                  </label>
                </div>     
              
              <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_print_rec"  name="f_print_rec"  disabled value="Y" <?php if($row_ath_all["f_print_rec"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Print GR Tag</span>
                  </label>
                </div>    
                
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_printfoc_rec"  name="f_printfoc_rec" disabled value="Y" <?php if($row_ath_all["f_printfoc_rec"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Print GR FOC Tag</span>
                  </label>
                </div>    
              
               <hr width="100%">  
                <!-- Goods Return --->
               <p><b>Goods Return</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gturn_rec" name="f_gturn_rec" disabled value="Y" <?php if($row_ath_all["f_gturn_rec"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Return</span>
                  </label>
                </div>    
                
                  <hr width="100%">  
                
                <!-- GI Consumable --->
               <p><b>GI Consumable</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gi_rec" name="f_gi_rec" disabled value="Y" <?php if($row_ath_all["f_gi_rec"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">GI Consumable</span>
                  </label>
                </div>    
                
                
                
                
                  <hr width="100%">  
           
           
              <!-- Transfer Posting --->
               <p><b>Transfer Posting</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_tp_progress" name="f_tp_progress" disabled value="Y" <?php if($row_ath_all["f_tp_progress"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Transfer Posting</span>
                  </label>
                </div>  
                  <hr width="100%">  
                
                 <!-- Subcontracting --->
                 <p><b>Subcontracting</b></p>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="main_subcont" name="main_subcont" disabled value="Y" <?php if($row_ath_all["main_subcont"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Subcontracting</span>
                  </label>
                </div> 
                
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_subcont" name="f_subcont" disabled value="Y" <?php if($row_ath_all["f_subcont"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Transfer to Subcont</span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_subcont2" name="f_subcont2" disabled value="Y" <?php if($row_ath_all["f_subcont2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Print SDO</span>
                  </label>
                </div> 
                
                
                  <hr width="100%">  
                
                 <!-- Transfer Material --->
                 <p><b>Transfer Material</b></p>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_trans_rec" name="f_trans_rec" disabled value="Y" <?php if($row_ath_all["f_trans_rec"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Transfer Material</span>
                  </label>
                </div> 
                
                <hr width="100%">  
                   
                  <!-- Delivery --->
                 <p><b>Delivery</b></p>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="main_dlv" name="main_dlv" disabled value="Y" <?php if($row_ath_all["main_dlv"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Delivery</span>
                  </label>
                 </div>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do7" name="f_dlv_do7" disabled value="Y" <?php if($row_ath_all["f_dlv_do7"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Sales Order Listing</span>
                  </label>
                 </div>
                 
                   <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do" name="f_dlv_do" disabled value="Y" <?php if($row_ath_all["f_dlv_do"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Create DO Perodua</span>
                  </label>
                 </div>
                    <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do2" name="f_dlv_do2" disabled value="Y" <?php if($row_ath_all["f_dlv_do2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Create DO Perodua Sales</span>
                  </label>
                 </div>
                  <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do5" name="f_dlv_do5" disabled value="Y" <?php if($row_ath_all["f_dlv_do5"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Create DO Perodua Manufacturing</span>
                  </label>
                 </div>
                 
                  <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do3" name="f_dlv_do3" disabled value="Y" <?php if($row_ath_all["f_dlv_do3"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Create DO Others Customer</span>
                  </label>
                 </div>
                  <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do4" name="f_dlv_do4" disabled value="Y" <?php if($row_ath_all["f_dlv_do4"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Print DO</span>
                  </label>
                 </div>
                  <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do6" name="f_dlv_do6" disabled value="Y" <?php if($row_ath_all["f_dlv_do6"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Closed Sales Order</span>
                  </label>
                 </div>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do8" name="f_dlv_do8" disabled value="Y" <?php if($row_ath_all["f_dlv_do8"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Upload PDIO</span>
                  </label>
                 </div>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do9" name="f_dlv_do9" disabled value="Y" <?php if($row_ath_all["f_dlv_do9"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Create DO Perodua</span>
                  </label>
                 </div>
                   
               <hr width="100%">  
              
                 <!-- Disposal Receiving --->
                <p><b>Disposal Receiving</b></p>
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_rec" name="f_dis_rec" disabled value="Y" <?php if($row_ath_all["f_dis_rec"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Receiving</span>
                  </label>
                </div> 
                
                 <hr width="100%">  
              
                 <!-- Disposal Approval Receiving --->
                <p><b>Disposal Approval Receiving</b></p>
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_rec" name="f_dis_approval_rec" disabled value="Y" <?php if($row_ath_all["f_dis_approval_rec"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Disposal Approval Receiving</span>
                  </label>
                </div>
                
                
               <hr width="100%">
                
                <!-- Transit --->
                <p><b>Transit</b></p>
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_transit" name="main_transit" disabled value="Y" <?php if($row_ath_all["main_transit"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Transit</span>
                  </label>
                </div>
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_tran_dlv" name="f_bf_tran_dlv" disabled value="Y" <?php if($row_ath_all["f_bf_tran_dlv"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">BF Transit</span>
                  </label>
                </div>
                
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_tran_dlv2" name="f_bf_tran_dlv2" disabled value="Y" <?php if($row_ath_all["f_bf_tran_dlv2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Print Tag</span>
                  </label>
                </div>
                
                
                 <hr width="100%"> 
                
            <!-- Backflush --->
               <p><b>Backflush</b></p>
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_bflush" name="main_bflush" disabled value="Y" <?php if($row_ath_all["main_bflush"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Backflush</span>
                  </label>
                </div> 
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_ok" name="f_bf_ok" disabled value="Y" <?php if($row_ath_all["f_bf_ok"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Confirmation Backflush (OK)</span>
                  </label>
                </div>  
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_ng"  name="f_bf_ng" disabled value="Y" <?php if($row_ath_all["f_bf_ng"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Confirmation Backflush (NG)</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_pending" name="f_bf_pending" disabled value="Y" <?php if($row_ath_all["f_bf_pending"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Confirmation Backflush (Pending) </span>
                  </label>
                </div>  
              
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_handwork" name="f_bf_handwork" disabled value="Y" <?php if($row_ath_all["f_bf_handwork"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Confirmation Backflush (Handwork)</span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_print_prd" name="f_print_prd" disabled value="Y" <?php if($row_ath_all["f_print_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Print Tag</span>
                  </label>
                </div> 
               
               
              
               <hr width="100%"> 
                
            <!-- Production --->
               <p><b>Production</b></p>
             
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_pend_conf_prd" name="f_bf_pend_conf_prd" disabled value="Y" <?php if($row_ath_all["f_bf_pend_conf_prd"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Pending Confirmation</span>
                  </label>
                </div>  
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_pend_rwork_conf_prd" name="f_pend_rwork_conf_prd" disabled value="Y" <?php if($row_ath_all["f_pend_rwork_conf_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Rework</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_pend_hwork_conf_prd"  name="f_pend_hwork_conf_prd" disabled value="Y" <?php if($row_ath_all["f_pend_hwork_conf_prd"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Handwork</span>
                  </label>
                </div>  
              
               
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_list_prd"  name="f_dis_list_prd" disabled value="Y" <?php if($row_ath_all["f_dis_list_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposals List</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_prd" name="f_dis_approval_prd" disabled value="Y" <?php if($row_ath_all["f_dis_approval_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval - Engineering</span>
                  </label>
                </div>  
              
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_prd2" name="f_dis_approval_prd2" disabled value="Y" <?php if($row_ath_all["f_dis_approval_prd2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval - Stamping</span>
                  </label>
                </div> 
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_prd3" name="f_dis_approval_prd3" disabled value="Y" <?php if($row_ath_all["f_dis_approval_prd3"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval - Assembly</span>
                  </label>
                </div> 
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_prd4" name="f_dis_approval_prd4" disabled value="Y" <?php if($row_ath_all["f_dis_approval_prd4"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval</span>
                  </label>
                </div> 
              
                    
               <hr width="100%"> 
                
            <!-- Disposal Production --->
               <p><b>Disposals</b></p>
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_disposal" name="main_disposal" disabled value="Y" <?php if($row_ath_all["main_disposal"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposals</span>
                  </label>
                </div> 
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_prd" name="f_dis_prd" disabled value="Y" <?php if($row_ath_all["f_dis_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Reject Output </span>
                  </label>
                </div>    
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_comp_rej_prd" name="f_comp_rej_prd" disabled value="Y" <?php if($row_ath_all["f_comp_rej_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Component Reject</span>
                  </label>
                </div>  
                
               <hr width="100%"> 
               
                <!-- Disposal Production 2 --->
               <p><b>Disposal Engineering</b></p>
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_disposal_prd2" name="main_disposal_prd2" disabled value="Y" <?php if($row_ath_all["main_disposal_prd2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposals</span>
                  </label>
                </div> 
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_rej_prd2" name="f_dis_rej_prd2" disabled value="Y" <?php if($row_ath_all["f_dis_rej_prd2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Reject Part</span>
                  </label>
                </div>    
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_comp_rej_prd2" name="f_comp_rej_prd2" disabled value="Y" <?php if($row_ath_all["f_comp_rej_prd2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Reject Component</span>
                  </label>
                </div>  
                  
                
                
              <hr width="100%"> 
                
            <!-- Return Advise --->
               <p><b>Return Advise</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_gra" name="main_gra" disabled value="Y" <?php if($row_ath_all["main_gra"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Return Advise</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gra_qc" name="f_gra_qc" disabled value="Y" <?php if($row_ath_all["f_gra_qc"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Return Advise(GRA)</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_print_qc" name="f_print_qc" disabled value="Y" <?php if($row_ath_all["f_print_qc"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Print GRA</span>
                  </label>
                </div>  
                
                   
              <hr width="100%"> 
                
            <!-- Disposal QC --->
               <p><b>Disposal QC</b></p>
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_disposal_qc" name="main_disposal_qc" disabled value="Y" <?php if($row_ath_all["main_disposal_qc"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposals</span>
                  </label>
                </div> 
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_qc" name="f_dis_approval_qc" disabled value="Y" <?php if($row_ath_all["f_dis_approval_qc"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Reject Part</span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_comp_rej_qc" name="f_comp_rej_qc" disabled value="Y" <?php if($row_ath_all["f_comp_rej_qc"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Reject Component</span>
                  </label>
                </div>   
         
                
                 <hr width="100%"> 
                
            <!-- Disposal Approval Exec --->
               <p><b>Disposal Approval HOD QC</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_ex_qc"  name="f_dis_approval_ex_qc" disabled value="Y" <?php if($row_ath_all["f_dis_approval_ex_qc"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval HOD QC</span>
                  </label>
                </div>  
                   
              <hr width="100%"> 
                
            <!-- Disposal Approval QC --->
               <p><b>Disposal Approval COO</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_h_qc" name="f_dis_approval_h_qc" disabled value="Y" <?php if($row_ath_all["f_dis_approval_h_qc"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval COO</span>
                  </label>
                </div>  
                
                   <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_hqc_smenu1" name="f_hqc_smenu1" disabled value="Y" <?php if($row_ath_all["f_hqc_smenu1"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_hqc_smenu2" name="f_hqc_smenu2" disabled value="Y" <?php if($row_ath_all["f_hqc_smenu2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Cancellation </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_hqc_smenu3" name="f_hqc_smenu3" disabled value="Y" <?php if($row_ath_all["f_hqc_smenu3"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Document List </span>
                  </label>
                </div> 
                
                
                
                
                <hr width="100%">  
                   
            <!-- Cancellation --->
               <p><b>Cancellation </b></p>
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_canc" name="main_canc" disabled value="Y" <?php if($row_ath_all["main_canc"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Cancellation </span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu1" name="f_canc_smenu1" disabled value="Y" <?php if($row_ath_all["f_canc_smenu1"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu2" name="f_canc_smenu2" disabled value="Y" <?php if($row_ath_all["f_canc_smenu2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt FOC </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu3" name="f_canc_smenu3" disabled value="Y" <?php if($row_ath_all["f_canc_smenu3"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Return </span>
                  </label>
                </div>    
           
         
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu4" name="f_canc_smenu4" disabled value="Y" <?php if($row_ath_all["f_canc_smenu4"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">GI Consumable </span>
                  </label>
                </div>    
           
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu5" name="f_canc_smenu5" disabled value="Y" <?php if($row_ath_all["f_canc_smenu5"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Transfer Posting </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu6" name="f_canc_smenu6" disabled value="Y" <?php if($row_ath_all["f_canc_smenu6"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Transfer to Subcont </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu7" name="f_canc_smenu7" disabled value="Y" <?php if($row_ath_all["f_canc_smenu7"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Transfer Material </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu8" name="f_canc_smenu8" disabled value="Y" <?php if($row_ath_all["f_canc_smenu8"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Delivery Order </span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu9" name="f_canc_smenu9" disabled value="Y" <?php if($row_ath_all["f_canc_smenu9"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal PPC </span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu10" name="f_canc_smenu10" disabled value="Y" <?php if($row_ath_all["f_canc_smenu10"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Production </span>
                  </label>
                </div>    
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu11" name="f_canc_smenu11" disabled value="Y" <?php if($row_ath_all["f_canc_smenu11"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Return Advise </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu12" name="f_canc_smenu12" disabled value="Y" <?php if($row_ath_all["f_canc_smenu12"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal QC </span>
                  </label>
                </div>   
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu13" name="f_canc_smenu13" disabled value="Y" <?php if($row_ath_all["f_canc_smenu13"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Engineering </span>
                  </label>
                </div>
              
              
               <hr width="100%">           
               <!-- Report --->
               <p><b>Report </b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_rpt" name="main_rpt" disabled value="Y" <?php if($row_ath_all["main_rpt"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Report </span>
                  </label>
                </div>
                
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu0" name="f_rpt_smenu0" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu0"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Delivery Instruction </span>
                  </label>
                </div>  
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu21" name="f_rpt_smenu21" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu21"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Delivery Instruction PPC</span>
                  </label>
                </div>    
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu18" name="f_rpt_smenu18" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu18"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Delivery Order </span>
                  </label>
                </div> 
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu1" name="f_rpt_smenu1" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu1"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Goods Receipt </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu2" name="f_rpt_smenu2" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt FOC </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu3" name="f_rpt_smenu3" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu3"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Goods Return </span>
                  </label>
                </div>    
           
         
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu4" name="f_rpt_smenu4" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu4"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">GI Consumable </span>
                  </label>
                </div>    
           
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu5" name="f_rpt_smenu5" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu5"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Transfer Posting </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu6" name="f_rpt_smenu6" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu6"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Transfer to Subcont </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu7" name="f_rpt_smenu7" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu7"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Transfer Material </span>
                  </label>
                </div> 
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu17" name="f_rpt_smenu17" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu17"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">PDIO/DI </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu20" name="f_rpt_smenu20" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu20"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">PDIO/DI for FINA </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu8" name="f_rpt_smenu8" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu8"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Backflush Transit </span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu9" name="f_rpt_smenu9" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu9"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Goods Return Advise </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu19" name="f_rpt_smenu19" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu19"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Disposal PPC </span>
                  </label>
                </div>     
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu10" name="f_rpt_smenu10" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu10"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Disposal QC </span>
                  </label>
                </div>    
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu11" name="f_rpt_smenu11" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu11"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Backflush </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu12" name="f_rpt_smenu12" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu12"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Pending </span>
                  </label>
                </div>   
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu13" name="f_rpt_smenu13" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu13"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Rework </span>
                  </label>
                </div>   
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu14" name="f_rpt_smenu14" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu14"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Handwork </span>
                  </label>
                </div>   
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu15" name="f_rpt_smenu15" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu15"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Disposal Production</span>
                  </label>
                </div>   
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu16" name="f_rpt_smenu16" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu16"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Planned Order Status </span>
                  </label>
                </div>  
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu22" name="f_rpt_smenu22" disabled value="Y" <?php if($row_ath_all["f_rpt_smenu22"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Engineering </span>
                  </label>
                </div>  
               
                
                <hr width="100%">           
               <!-- Report --->
               <p><b>FTP Monitoring </b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_ftp" name="main_ftp" disabled value="Y" <?php if($row_ath_all["main_ftp"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">FTP Monitoring </span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu1" name="f_ftp_smenu1" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu1"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Backflush OK </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu2" name="f_ftp_smenu2" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Backflush NG </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu3" name="f_ftp_smenu3" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu3"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Backflush Pending </span>
                  </label>
                </div>    
           
         
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu4" name="f_ftp_smenu4" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu4"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Backflush Handwork </span>
                  </label>
                </div>    
           
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu5" name="f_ftp_smenu5" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu5"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Disposal GI </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu6" name="f_ftp_smenu6" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu6"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu7" name="f_ftp_smenu7" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu7"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Goods Return </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu8" name="f_ftp_smenu8" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu8"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">GI Consumable</span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu9" name="f_ftp_smenu9" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu9"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Transfer Material </span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu10" name="f_ftp_smenu10" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu10"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Transfer Posting </span>
                  </label>
                </div>  
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu15" name="f_ftp_smenu15" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu15"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Transfer to Subcont </span>
                  </label>
                </div>     
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu11" name="f_ftp_smenu11" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu11"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Disposal </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu12" name="f_ftp_smenu12" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu12"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Backflush Transit </span>
                  </label>
                </div>   
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu13" name="f_ftp_smenu13" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu13"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Delivery Order </span>
                  </label>
                  </div>   
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu14" name="f_ftp_smenu14" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu14"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Disposal QC </span>
                  </label>
                  </div>   
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu16" name="f_ftp_smenu16" disabled value="Y" <?php if($row_ath_all["f_ftp_smenu16"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Disposal Engineering </span>
                  </label>
                  </div> 
                  
                  
                   <hr width="100%">           
               <!-- CEO  --->
               <p><b><?php echo html_esc($rst_apprv8["apprv_name2"]); ?> </b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_coo" name="main_coo" disabled value="Y" <?php if($row_ath_all["main_coo"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator"><?php echo html_esc($rst_apprv8["apprv_name2"]); ?> </span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu1" name="f_coo_smenu1" disabled value="Y" <?php if($row_ath_all["f_coo_smenu1"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Pending Approval </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu2" name="f_coo_smenu2" disabled value="Y" <?php if($row_ath_all["f_coo_smenu2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Approved </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu3" name="f_coo_smenu3" disabled value="Y" <?php if($row_ath_all["f_coo_smenu3"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Rejected </span>
                  </label>
                </div>    
           
         
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu4" name="f_coo_smenu4" disabled value="Y" <?php if($row_ath_all["f_coo_smenu4"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Cancellation </span>
                  </label>
                </div>    
           
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu5" name="f_coo_smenu5" disabled value="Y" <?php if($row_ath_all["f_coo_smenu5"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Document List </span>
                  </label>
                </div>  
                  
                   <hr width="100%">           
               <!-- Report --->
                  <p><b>Close PPS </b></p>
                  
                  
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_close_pps" name="f_close_pps" disabled value="Y" <?php if($row_ath_all["f_close_pps"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Closing </span>
                  </label>
                  </div>   
                  
                  
                  
                      <hr width="100%">           
               <!-- PO  --->
               <p><b>Purchase Order</b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_po" name="main_po" disabled value="Y" <?php if($row_ath_all["main_po"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Purchase Order</span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_po_smenu1" name="f_po_smenu1" disabled value="Y" <?php if($row_ath_all["f_po_smenu1"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Upload PO </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_po_smenu2" name="f_po_smenu2" disabled value="Y" <?php if($row_ath_all["f_po_smenu2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">View PO </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_po_smenu3" name="f_po_smenu3" disabled value="Y" <?php if($row_ath_all["f_po_smenu3"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Maintain PO </span>
                  </label>
                </div>   
                
                
                   <hr width="100%">           
               <!-- MFO  --->
               <p><b>Material Forecast Order</b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_mfo" name="main_mfo" disabled value="Y" <?php if($row_ath_all["main_mfo"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Material Forecast Order</span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_mfo_smenu1" name="f_mfo_smenu1" disabled value="Y" <?php if($row_ath_all["f_mfo_smenu1"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Upload MFO </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_mfo_smenu2" name="f_mfo_smenu2" disabled value="Y" <?php if($row_ath_all["f_mfo_smenu2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">View MFO </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_mfo_smenu3" name="f_mfo_smenu3" disabled value="Y" <?php if($row_ath_all["f_mfo_smenu3"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Maintain MFO </span>
                  </label>
                </div>
  
     </td></tr>
     
     
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