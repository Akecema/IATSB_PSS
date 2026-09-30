<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);

//----disposal prod
$query_setup2 = "SELECT * FROM sys_setup_disposal WHERE id = '3' AND status_acc = 'Y'";
$rs_setup2 = mysqli_query($dbc,$query_setup2);   //run the query.
$num_setup2 = mysqli_num_rows($rs_setup2);   //how many material are there?
$data_setup2 = mysqli_fetch_array($rs_setup2);

//-----disposal prod assy
$query_setup3 = "SELECT * FROM sys_setup_disposal WHERE id = '1' AND status_acc = 'Y'";
$rs_setup3 = mysqli_query($dbc,$query_setup3);   //run the query.
$num_setup3 = mysqli_num_rows($rs_setup3);   //how many material are there?
$data_setup3 = mysqli_fetch_array($rs_setup3);

//----disposal prod stm
$query_setup4 = "SELECT * FROM sys_setup_disposal WHERE id = '2' AND status_acc = 'Y'";
$rs_setup4 = mysqli_query($dbc,$query_setup4);   //run the query.
$num_setup4 = mysqli_num_rows($rs_setup4);   //how many material are there?
$data_setup4 = mysqli_fetch_array($rs_setup4);

//----disposal qc
$query_setup5 = "SELECT * FROM sys_setup_disposal WHERE id = '5' AND status_acc = 'Y'";
$rs_setup5 = mysqli_query($dbc,$query_setup5);   //run the query.
$num_setup5 = mysqli_num_rows($rs_setup5);   //how many material are there?
$data_setup5 = mysqli_fetch_array($rs_setup5);

//----disposal ppc
$query_setup6 = "SELECT * FROM sys_setup_disposal WHERE id = '4' AND status_acc = 'Y'";
$rs_setup6 = mysqli_query($dbc,$query_setup6);   //run the query.
$num_setup6 = mysqli_num_rows($rs_setup6);   //how many material are there?
$data_setup6 = mysqli_fetch_array($rs_setup6);

//----disposal ENG
$query_setup7 = "SELECT * FROM sys_setup_disposal WHERE id = '6' AND status_acc = 'Y'";
$rs_setup7 = mysqli_query($dbc,$query_setup7);   //run the query.
$num_setup7 = mysqli_num_rows($rs_setup7);   //how many material are there?
$data_setup7 = mysqli_fetch_array($rs_setup7);

//----------------------------------------------------

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	include 'apprv_func_list.php';  
	
    $url = "dis_approve_qc-tran.php";
	
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

//CR status (Cancelled)
$sta4 = "SELECT * from request_status WHERE status_id = '4'";
$sta_res4 = mysqli_query($dbc,$sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);

//CR status (Rejected)
$sta5 = "SELECT * from request_status WHERE status_id = '5'";
$sta_res5 = mysqli_query($dbc,$sta5);
$rst_sta5 = mysqli_fetch_array($sta_res5);

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

//CR status (Pending)
$sta8 = "SELECT * from request_status WHERE status_id = '8'";
$sta_res8 = mysqli_query($dbc,$sta8);
$rst_sta8 = mysqli_fetch_array($sta_res8);

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc,$sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13'";
$sta_res13 = mysqli_query($dbc,$sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

//CR status (Cancel)
$sta21 = "SELECT * from request_status WHERE status_id = '21'";
$sta_res21 = mysqli_query($dbc,$sta21);
$rst_sta21 = mysqli_fetch_array($sta_res21);

//CR status (Close)
$sta22 = "SELECT * from request_status WHERE status_id = '22'";
$sta_res22 = mysqli_query($dbc,$sta22);
$rst_sta22 = mysqli_fetch_array($sta_res22);

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);

//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc,$sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);

//CR status (Pending Approval COO)
$sta25 = "SELECT * from request_status WHERE status_id = '25'";
$sta_res25 = mysqli_query($dbc,$sta25);
$rst_sta25 = mysqli_fetch_array($sta_res25);

//CR status (Pending Approval Exec QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);

//CR status (Pending Approval STM)
$sta32 = "SELECT * from request_status WHERE status_id = '32'";
$sta_res32 = mysqli_query($dbc,$sta32);
$rst_sta32 = mysqli_fetch_array($sta_res32);

//CR status (Pending Approval ASSY)
$sta34 = "SELECT * from request_status WHERE status_id = '34'";
$sta_res34 = mysqli_query($dbc,$sta34);
$rst_sta34 = mysqli_fetch_array($sta_res34);


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
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    <!--  <script src="https://www.w3schools.com/lib/w3.js"></script>-->
	
	<SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    
<style>
th {
  cursor: pointer;
 /* background-color: coral;*/
}    
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}
</style> 
<style>
.pagin {
  display: inline-block;
}

.pagin a {
  color: black;
  float: left;
  padding: 7px 10px;
  text-decoration: none;
  border: 1px solid #ddd;
}

.pagin a.active {
  background-color: #32A478;
  color: white;
  border: 1px solid #32A478;
}

.pagin a:hover:not(.active) {background-color: #ddd;}

.pagin a:first-child {
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
}

.pagin a:last-child {
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px;
}
div.dataTables_wrapper {
        width: 1300px;
        margin: 0 auto;
    }
</style>   
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
     <?php   include "top_modal_menu.php";   ?>
    
   
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php   include "left_prod_menu.php";   ?>
   
    <main class="app-content">
    
  
      <div class="app-title">
        <div>
          <h1><i class="fa fa-file-text-o"></i> QC</h1>
          <p>Disposal Approval</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">QC</li>
          <li class="breadcrumb-item"><a href="dis_approve_qc-tran.php">Disposal Approval</a></li>
        </ul>
      </div> 
       
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Disposal Approval</h3>
            <div class="tile-body">
              <div class="table-responsive">
              
               <ul class="nav nav-tabs">
                 <li class="nav-item"><a class="nav-link" href="dis_approve_qc-tran.php">New Disposal </a></li>
                 <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="dis_approve_qc-tran-aprv.php">Approved Disposal</a></li>
              </ul>    
          <?php
		  
		    $dateF = $_GET["date1"];
			$dateT = $_GET["date2"];
			$plant_code = $_GET["plant_code"]; 
			$work_center = $_GET["work_center"];
			
			
		  ?>    
              
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%" colspan="3">&nbsp;</th>
            </tr>
            <tr>
            <th>Plant : </th>
            <td colspan="3">
           <select name="plant_code" class="form-control" onChange="getWorkCenter(this.value)">
                  <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
                  <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
                  <option value="<?php echo html_esc($row27["plant_code"]); ?>" <?php if($row27["plant_code"] == $_GET["plant_code"]) echo "selected"; ?>> <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo html_esc($row27["plant_desc"]); ?></option>
                  <?php
           }  ?>
                </select>
		     </td>
             </tr>
             
              <tr>
                <th>Posting Date from :</th>
                <td colspan="3">
        <?php
			     $dd1 = substr($_GET["date1"],8,2);
				 $mm1 = substr($_GET["date1"],5,2);
				 $yy1 = substr($_GET["date1"],0,4);
			?>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" >
                  
                    </td></tr>
                <tr>
                <th>Posting Date to :</th>
                <td colspan="3"><?php
			     $dd2 = substr($_GET["date2"],8,2);
				 $mm2 = substr($_GET["date2"],5,2);
				 $yy2 = substr($_GET["date2"],0,4);
			?>
             <input class="form-control" id="PSSDate2" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>" ></td>
             
              </tr>
              <tr>
                <th>Section/Line :</th>
                <th>
                <div id="work_centerdiv"><select name="work_center" id="work_center" class="form-control">
                  <option value="NULL" placeholder="Select Line"> -- Select Line --</option>
                  <?php
	               $query5 = new PreparedSql("SELECT * FROM work_center_detail WHERE plant_code = ? ORDER BY id_work ASC", [$_GET["plant_code"]]);
                   $result5 = db_query($dbc, $query5);
  
                   while($row5=mysqli_fetch_array($result5)) 
				    { 
				   
				   ?>
                <option value="<?php echo html_esc($row5["id_work"]); ?>" <?php if($row5["id_work"] == $_GET["work_center"]) echo "selected"; ?>> <?php echo html_esc($row5["id_work"]),' - ',stripslashes($row5["wc_desc"]); ?></option>
                
                
                
                <?php
                  }
				?>
                </select></div>
                
                </th>
              </tr>
              <tr>
                <th><input name="Submit22" type="submit" class="btn btn-info" id="button" value="SEARCH" />
                </th>
                <th colspan="3">&nbsp;</th>
              </tr>
            
                </table>
        </form>
 
               
                   
      <?php


 //-------Count all results------------------------//
      
 $where_sql = '';
          
 // Prepare the date ranges safely
 $date1_final = DateTime::createFromFormat('d-m-Y', $_GET['date1'])->format('Y-m-d');
 $date2_final = DateTime::createFromFormat('d-m-Y', $_GET['date2'])->format('Y-m-d');
		  
								  
 // Build the WHERE clause
 $where_clauses = [];
 if (!empty($plant_code) && $plant_code !== "NULL") {
	 $where_clauses[] = "pps.plant_cd = ?";
 }
 if ($dateF !== "0000-00-00") {
	 $where_clauses[] = "pps.date_disposal >= ?";
 }
 if ($dateT !== "0000-00-00") {
	 $where_clauses[] = "pps.date_disposal <= ?";
 }
 if (!empty($work_center) && $work_center !== "NULL") {
	$where_clauses[] = "pps.work_center = ?";
}

 // Combine all conditions into a single clause
 $where_sql = $where_clauses ? ' AND ' . implode(' AND ', $where_clauses) : '';

   //********** END CONDITION *************


	$queryDis = "SELECT pps.*, DATE_FORMAT(pps.date_disposal,'%d-%m-%Y') as R FROM disposal_detail_prd_all pps WHERE 
	(pps.status_disposal = ? OR pps.status_disposal = ?  OR pps.status_disposal = ?  OR pps.status_disposal = ?  OR pps.status_disposal = ?  OR pps.status_disposal = ?)   $where_sql GROUP BY pps.doc_dis ORDER BY pps.doc_dis ASC ";
	// Prepare statement
	$stmt = $dbc->prepare($queryDis);
	if ($stmt === false) {
		die('Prepare failed: '. $dbc->error);
	}

	$params = [$rst_sta3["status_desc"], $rst_sta5["status_desc"], $rst_sta10["status_desc"], $rst_sta24["status_desc"], $rst_sta25["status_desc"], $rst_sta29["status_desc"]];

	if (!empty($plant_code) && $plant_code !== "NULL") {
		$params[] = $plant_code;
	}
	if ($dateF !== "0000-00-00") {
		$params[] = $date1_final;
	}
	if ($dateT !== "0000-00-00") {
		$params[] = $date2_final;
	}

	// Bind parameters
	$stmt->bind_param(str_repeat('s', count($params)), ...$params);

	// Execute and get the result
	$stmt->execute();
	$result = $stmt->get_result();

	// Fetch and count the rows
	$num_rowsDis = $result->num_rows;

		  
		 if ($num_rowsDis > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_rowsDis.' record(s).</div>'; 
	   
        
    	?>

<table class="table">
<tr>
    <td width="1%">&nbsp;</td> 
    <td width="85%">&nbsp;</td> 
    <td width="7%"><a href="report_document_hqc_aprv-download.php?plant_code=<?php echo html_esc($plant_code); ?>&&date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&work_center=<?php echo html_esc($work_center); ?>" ><img src="../images/dload_excel.jpg" width="48" height="48" title="Download" /></a></td>
    
  </tr>
</table> 
    
      
                <table class="table table-hover table-bordered" id="example">
               <thead>
                <tr>
                    <th>No</th>
                    <th>Plant</th>
                    <th>Document No.</th> 
                    <th>Posting Date</th>
                    <th>Section/Line</th> 
                    <th>Status</th>
                    <th>Action</th>
                    <th>Action</th>
                </tr>
              </thead>    
              <tbody>
           <?php 

   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   
   while($row = $result->fetch_assoc())
   {   
	   
  //-----change status disposal
	  
	  if($row["status_disposal"] == ($rst_sta3["status_desc"]))
	{
		 if($data_setup4["bil_table"] == "4")
         {  
		 
		$sta_dis = "Approved ".$rst_apprv6["apprv_name2"];
		$dt_dis = $row["T39"]; 
		 
		 }else{
		
		$sta_dis = "Approved ".$rst_apprv8["apprv_name2"];
		$dt_dis = $row["T49"]; 
		
		 }
	
		
		
		
		
	}elseif($row["status_disposal"] == ($rst_sta5["status_desc"]))
	{
		//-------
		if($row["status_approved"] == ($rst_sta5["status_desc"]))
		{
		
		$sta_dis = "Rejected HOD Requestor";
		$dt_dis = $row["T9"]; 	
			
		}elseif($row["status_approved2"] == ($rst_sta5["status_desc"]))
		{
		
		$sta_dis = "Rejected QD";
		$dt_dis = $row["T19"]; 
		
		}elseif($row["status_approved3"] == ($rst_sta5["status_desc"]))
		{
		
		$sta_dis = "Rejected COO";
		$dt_dis = $row["T29"]; 
		
		}elseif($row["status_approved4"] == ($rst_sta5["status_desc"]))
		{
		
		$sta_dis = "Rejected ".$rst_apprv8["apprv_name2"];
		$dt_dis = $row["T39"]; 
		
		}
		
		
	}elseif($row["status_disposal"] == ($rst_sta15["status_desc"]))
	{
		
		$sta_dis = "Pending ".$rst_apprv2["apprv_name2"];
		//$dt_dis = $row["T"]; 
	    $dt_dis = $row["T49"]; 
		
	}elseif($row["status_disposal"] == ($rst_sta32["status_desc"]))
	{
		
		$sta_dis = "Pending ".$rst_apprv3["apprv_name2"];
		//$dt_dis = $row["T"]; 
	    $dt_dis = $row["T49"]; 
		
	}elseif($row["status_disposal"] == ($rst_sta34["status_desc"]))
	{
		
		$sta_dis = "Pending ".$rst_apprv4["apprv_name2"];
		//$dt_dis = $row["T"]; 
	    $dt_dis = $row["T49"]; 
		
	}
	elseif($row["status_disposal"] == ($rst_sta24["status_desc"]))
	{
		
		$sta_dis = "Approved QD";
		$dt_dis = $row["T19"]; 
		
	}elseif($row["status_disposal"] == ($rst_sta25["status_desc"]))
	{
		
		$sta_dis = "Approved COO";
		$dt_dis = $row["T29"]; 
		
	}elseif($row["status_disposal"] == ($rst_sta29["status_desc"]))
	{
		    if($row["status_part"] == "PR") 
		            { 
		
		       if($row["stamp_ind"] == "ASSY")
				{
				
				$sta_dis = "Pending Approval ".$rst_apprv4["apprv_name2"];
				$dt_dis = $row["T49"]; 	
					
				}elseif($row["stamp_ind"] == "STM")
				{
				
				
				$sta_dis = "Pending Approval ".$rst_apprv3["apprv_name2"];
				$dt_dis = $row["T49"]; 
				
				}elseif($row["stamp_ind"] == "BLK")
				{
				
				
				$sta_dis = "Pending Approval QD";
				$dt_dis = $row["T49"]; 
				
				}			
				else{  
				
				$sta_dis = "";
				
					}
				
		  }else{
			  
			  
			$sta_dis = "Pending Approval QD";   
			  
		  }
	
		
	}elseif($row["status_disposal"] == ($rst_sta25["status_desc"]))
	{
		
		$sta_dis = "Approved QD";
		$dt_dis = $row["T29"]; 
		
	}elseif($row["status_disposal"] == ($rst_sta4["status_desc"]))
	{
		
		$sta_dis = "Cancelled";
		$dt_dis = $row["T75"]; 
	}
  
		
	   
      ?>
                <tr>
                <td width="30"><?php echo $no4; ?></td>
                <td width="80"><?php echo html_esc($row["plant_cd"]); ?></td>
                <td width="150"><?php echo html_esc($row["doc_dis"]); ?></td>
                <td width="100"><?php echo html_esc($row["R"]); ?></td> 
                <td width="80"><?php echo html_esc($row["work_center"]); ?></td>
                <td width="80"><?php echo $sta_dis; ?></td>
                <td width="100">
				  <a href="#myNoteApprv<?php echo html_esc($row["doc_dis"]); ?>" data-toggle="modal" target="_parent"><i class="fa fa-check-square" aria-hidden="true"></i> View</a> 
             
             
                       <!--------------------------modal------------------------->
          <?php   if($row["status_part"] == "PR") 
		            {   
					
					  
						 if($row["stamp_ind"] == "STM")
					 {
						 
						 //----check setup setting disposal approval [prod stm]	----
			  
						  if($data_setup4["bil_table"] == "4")
						   {  		
					
					    include "display_apprv_dis-HQC2-viewprd-stm.php"; 
						 
						 }elseif($data_setup4["bil_table"] == "5")
						   {
							
						include "display_apprv_dis-2HQC2-viewprd-stm.php"; 
						  
						    }else{  } // end $data_setup4 
							
					 
					 }
						 elseif($row["stamp_ind"] == "BLK")
					 {
						 
						 //----check setup setting disposal approval [prod stm]	----
			  
						  if($data_setup4["bil_table"] == "4")
						   {  		
					
					    include "display_apprv_dis-HQC2-viewprd-stm.php"; 
						 
						 }elseif($data_setup4["bil_table"] == "5")
						   {
							
						include "display_apprv_dis-2HQC2-viewprd-stm.php"; 
						  
						    }else{  } // end $data_setup4 
							
					 
					 }else{
						 
						  //----check setup setting disposal approval [prod assy]	----
			  
						if($data_setup3["bil_table"] == "4")
						   {  	
					 
						include "display_apprv_dis-HQC2-viewprd.php"; 
						
						 }elseif($data_setup3["bil_table"] == "5")
						   {
							
						include "display_apprv_dis-2HQC2-viewprd.php"; 
						  
						    }else{  } // end $data_setup3 
						
						
					 }
					

                    }elseif($row["status_part"] == "ENG") 
		            { 

                      //----check setup setting disposal approval [ENG]	----
			  
						  if($data_setup7["bil_table"] == "4")
						   {  		
					
					    include "display_apprv_dis-HQC2-viewprd-ENG.php"; 
						 
						 }elseif($data_setup7["bil_table"] == "5")
						   {
							
						include "display_apprv_dis-2HQC2-viewprd-ENG.php"; 
						  
						    }else{  } // end $data_setup4 





					
					}elseif($row["status_part"] == "WS") 
		            { 
					
					 //----check setup setting disposal approval ppc	----
			  
			        if($data_setup6["bil_table"] == "4")
                       {  
					
		           
				    include "display_apprv_dis-HQC2-viewrcv.php"; 
					
					}elseif($data_setup6["bil_table"] == "5")
			        {
					
					 include "display_apprv_dis-2HQC2-viewrcv.php"; 
					 
					}else{  } // end $data_setup6 
					
					
					}elseif($row["status_part"] == "WQ") 
		            { 
					
					
					   //----check setup setting disposal approval ppc	----
			  
			       if($data_setup6["bil_table"] == "4")
                   {  
					
		            include "display_apprv_dis-HQC2-viewdlv.php"; 
						
						
					 }elseif($data_setup6["bil_table"] == "5")
			       {
					
					include "display_apprv_dis-2HQC2-viewdlv.php";
					
					 }else{  } // end $data_setup6 
						
								
					}
					elseif($row["status_part"] == "QC") 
		            { 
					
						 //----check setup setting disposal approval QC	----
			  
			       if($data_setup5["bil_table"] == "4")
                   {  		
		            include "display_apprv_dis-HQC2-viewqc.php"; 
					
					 }elseif($data_setup5["bil_table"] == "5")
                   {
					  
					  include "display_apprv_dis-2HQC2-viewqc.php"; 
					
					}else{ } // end $data_setup5 	
					
					
					}else{
				
					}
		  
		  
		    ?>
                </td>
                <td width="100">
                 
           <?php   if($row["status_part"] == "PR") 
		            {   
					
					 if($row["stamp_ind"] == "STM")
					 {
				   ?>
               <a href="detail_aprv_exeqc_disposal4-prd_print-stm.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
					 <?php  
					 }elseif($row["stamp_ind"] == "BLK")
					 {
				   ?>
               <a href="detail_aprv_exeqc_disposal4-prd_print-stm.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
					 <?php  }else{   ?>
                    
               <a href="detail_aprv_exeqc_disposal4-prd_print.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
					<?php } ?>
					
					<?php
					}elseif($row["status_part"] == "WS") 
		            { 
					?>
		      <a href="detail_aprv_exeqc_disposal4PRCV-prd_print.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
				  <?php	
					}elseif($row["status_part"] == "WQ") 
		            { ?>
		      <a href="detail_aprv_exeqc_disposal4PDLV-prd_print.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
					<?php
		            }elseif($row["status_part"] == "QC") 
		            { 	?>
              <a href="detail_aprv_exeqc_disposal4QQC-prd_print.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
				    <?php
					}elseif($row["status_part"] == "ENG")
					 {
				   ?>
               <a href="detail_aprv_exeqc_disposal4-prd_print-ENG.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
					
					<?php
					}else{
				
					}
		  
		  
		    ?>
          
          
          </td>
                </tr>
                 
          <?php 
		  
		  $no4++;
		  $counter++; // menambah counter
		  } 
		  
		  
		  ?>

         
 </tbody>
</table><!--</form>-->
 <br>

<?php
   $stmt->close();
   
	}   // free up the resources 
 else
 {
?><center>
<table width="800" cellspacing="0" class="textboxred">
  <tr> 
    <td><div align="center"><font color="#FF0000"><strong>There are currently no record(s).</strong></font></div></td>
  </tr>
</table></center>
        <?php
		   } 
mysqli_close($dbc)
?>

                       </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Data table plugin-->
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <!--<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>-->
    <script type="text/javascript">$('#example').DataTable();</script>
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    
    
     <script type="text/javascript">
          
       $('#PSSDate').datepicker({
		defaultDate: new Date(),
		format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
	   $('#PSSDate2').datepicker({
		defaultDate: new Date(),   
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
    </script>
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
	
	function getWorkCenter(plant_code) {		
		
		var strURL="findPlant4_dis_aprv2.php?plant_code="+plant_code;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('work_centerdiv').innerHTML=req.responseText;						
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