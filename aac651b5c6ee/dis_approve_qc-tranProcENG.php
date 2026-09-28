<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
header('Location: ../index.php');
exit();
}

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	include 'apprv_func_list.php';  
	
    $url = "dis_approve_qc-tran.php";
	

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

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

//CR status (Pending Approval Exec. QC)
$sta29 = "SELECT * from request_status WHERE status_id = '29'";
$sta_res29 = mysqli_query($dbc,$sta29);
$rst_sta29 = mysqli_fetch_array($sta_res29);


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
    <script language="javascript">
	$('.datepicker').pickadate({
weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
showMonthsShort: true
})
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
        width: 1200px;
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
                 <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="dis_approve_qc-tran.php">New Disposal </a></li>
                 <li class="nav-item"><a class="nav-link" href="dis_approve_qc-tran-aprv.php">Approved Disposal</a></li>
              </ul> 
          <?php
	
	    $plant_code = $_GET["plant_code"]; 
		  $dateF = $_GET["date1"];
	  	$dateT = $_GET["date2"];
	  	$work_center = $_GET["work_center"];
      $trans_opt = $_GET["trans_opt"]; 


         
   if($_GET["trans_opt"] == "PRSTM")
   {

     echo "<script>";
     echo "window.location='dis_approve_qc-tranProcSTM.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT&&work_center=$work_center&&trans_opt=$trans_opt'";
     echo "</script>";
     exit(); //quit the script 


   }elseif($_GET["trans_opt"] == "PRASSY")
    {
        
        echo "<script>";
        echo "window.location='dis_approve_qc-tranProcASSY.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT&&work_center=$work_center&&trans_opt=$trans_opt'";
        echo "</script>";
        exit(); //quit the script 
     
   }elseif($_GET["trans_opt"] == "PRBLK")
   {
     
     echo "<script>";
     echo "window.location='dis_approve_qc-tranProc.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT&&work_center=$work_center&&trans_opt=$trans_opt'";
     echo "</script>";
     exit(); //quit the script 
     
   }elseif($_GET["trans_opt"] == "WS")
   {
     
     echo "<script>";
     echo "window.location='dis_approve_qc-tranProcPPC.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT&&work_center=$work_center&&trans_opt=$trans_opt'";
     echo "</script>";
     exit(); //quit the script 
     

   }elseif($_GET["trans_opt"] == "QC")
   {
     
     echo "<script>";
     echo "window.location='dis_approve_qc-tranProcQAQC.php?plant_code=$plant_code&&date1=$dateF&&date2=$dateT&&work_center=$work_center&&trans_opt=$trans_opt'";
     echo "</script>";
     exit(); //quit the script 
     

   }else{
     
 
   }
			
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
                  <option value="<?php echo $row27["plant_code"]; ?>" <?php if($row27["plant_code"] == ($_GET["plant_code"])) echo "selected"; ?>> <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo $row27["plant_desc"]; ?></option>
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
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo $_GET['date1']; ?>" >
                  
                    </td></tr>
                 <tr>
                <th>Posting Date to :</th>
                <td colspan="3"><?php
			     $dd2 = substr($_GET["date2"],8,2);
				 $mm2 = substr($_GET["date2"],5,2);
				 $yy2 = substr($_GET["date2"],0,4);
			?>
             <input class="form-control" id="PSSDate2" type="text" placeholder="Select Date" name="date2" value="<?php echo $_GET['date2']; ?>" ></td>
             
              </tr>
              <tr>
                <th>Category :</th>
                <th colspan="3">
              <select name="trans_opt" id="trans_opt" class="form-control">
              <option value="NULL" placeholder="Select Category"> -- Select Category --</option>
              <option value="PRBLK" <?php if($_GET["trans_opt"] == 'PRBLK') { ?> selected="selected"<?php } ?>>Blanking</option>
              <option value="PRSTM" <?php if($_GET["trans_opt"] == 'PRSTM') { ?> selected="selected"<?php } ?>>Stamping</option>
              <option value="PRASSY" <?php if($_GET["trans_opt"] == 'PRASSY') { ?> selected="selected"<?php } ?>>Assembly</option>
              <option value="ENG" <?php if($_GET["trans_opt"] == 'ENG') { ?> selected="selected"<?php } ?>>Engineering</option>
              <option value="WS" <?php if($_GET["trans_opt"] == 'WS') { ?> selected="selected"<?php } ?>>PPC</option>
              <option value="QC" <?php if($_GET["trans_opt"] == 'QC') { ?> selected="selected"<?php } ?>>QAQC</option>
              </select>    
     			</th>
              </tr>
              <tr>
                <th>Section/Line :</th>
                <th>
                <div id="work_centerdiv"><select name="work_center" id="work_center" class="form-control">
                  <option value="NULL" placeholder="Select Line"> -- Select Line --</option>
                  <?php
	               $query5 = "SELECT * FROM work_center_detail WHERE plant_code = '".sql_esc($_GET["plant_code"])."' ORDER BY id_work ASC";
                   $result5 = mysqli_query($dbc,$query5);
  
                   while($row5=mysqli_fetch_array($result5)) 
				    { 
				   
				   ?>
                <option value="<?php echo $row5["id_work"]; ?>" <?php if($row5["id_work"] == ($_GET["work_center"])) echo "selected"; ?>> <?php echo $row5["id_work"],' - ',stripslashes($row5["wc_desc"]); ?></option>
                
                
                
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
				 
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 $ddF2 = substr($_GET["date2"],0,2);
				 $mmF2 = substr($_GET["date2"],3,2);
				 $yyF2 = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyF2.'-'.$mmF2.'-'.$ddF2);
				 
								 		
		
								
	       //1. Plant Code
                if ($plant_code == "NULL"){ 
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND plant_cd = '".sql_esc($plant_code)."'"; }  	
					
		   // 3. dateF
                if ($dateF == "0000-00-00"){
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND (date_disposal >= '".sql_esc($date1_final)."')"; }      
					
          //4. DateT
                if ($dateT == "0000-00-00"){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND (date_disposal <= '".sql_esc($date2_final)."')"; }
					
		  //5. Work Center
                if ($work_center == "NULL"){
                    $wheresql_05 = " AND work_center != '' "; }
                else {
					$wheresql_05 = " AND work_center = '".sql_esc($work_center)."'"; }
							

				$where_sql =  $wheresql_01 .$wheresql_03 .$wheresql_04 .$wheresql_05;
	
	//********** END CONDITION **************
	
		  
 			
			
   $query8Dis = "SELECT COUNT(*) FROM disposal_detail_prd_all WHERE (status_disposal = '".sql_esc($rst_sta24["status_desc"])."') AND status_part = 'ENG' " .$where_sql;
   $result8Dis = mysqli_query($dbc,$query8Dis);
   $num_rowsDis = mysqli_num_rows($result8Dis);
			
  
$queryDis = "SELECT *, DATE_FORMAT(date_disposal,'%d-%m-%Y') as R FROM disposal_detail_prd_all WHERE (status_disposal = '".sql_esc($rst_sta24["status_desc"])."') AND status_part = 'ENG' " .$where_sql."GROUP BY doc_dis ORDER BY doc_dis ASC ";
$rsDis = mysqli_query($dbc,$queryDis);
$num_rowsDis2 = mysqli_num_rows($rsDis);   //how many material are there?
    
		  
		 if ($num_rowsDis2 > 0) {
			 
			 echo '<div align="center">There are currently  '.$num_rowsDis2.' record(s).</div>'; 
		 
		 
    	?>
    
      
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
   
   while($row = mysqli_fetch_array($rsDis))
   {

	 	  	//-----change status disposal
	  
	  if($row["status_disposal"] == ($rst_sta3["status_desc"]))
    {
       if($data_setup4["bil_table"] == "4")
           {  
       
      $sta_dis = "Approved ".$rst_apprv6["apprv_name2"];
      //$dt_dis = $row["T39"]; 
       
       }else{
      
      $sta_dis = "Approved ".$rst_apprv8["apprv_name2"];
      //$dt_dis = $row["T49"]; 
      
       }
    
      
    }elseif($row["status_disposal"] == ($rst_sta5["status_desc"]))
    {
      //-------
      if($row["status_approved"] == ($rst_sta5["status_desc"]))
      {
      
      $sta_dis = "Rejected HOD Requestor";
      //$dt_dis = $row["T9"]; 	
        
      }elseif($row["status_approved2"] == ($rst_sta5["status_desc"]))
      {
      
      $sta_dis = "Rejected QD";
      //$dt_dis = $row["T19"]; 
      
      }elseif($row["status_approved3"] == ($rst_sta5["status_desc"]))
      {
      
      $sta_dis = "Rejected COO";
      //$dt_dis = $row["T29"]; 
      
      }elseif($row["status_approved4"] == ($rst_sta5["status_desc"]))
      {
      
      $sta_dis = "Rejected ".$rst_apprv8["apprv_name2"];
      //$dt_dis = $row["T39"]; 
      
      }
      
      
    }elseif($row["status_disposal"] == ($rst_sta15["status_desc"]))
    {
      
      $sta_dis = "Pending ".$rst_apprv2["apprv_name2"];
      //$dt_dis = $row["T"]; 
       // $dt_dis = $row["T49"]; 
      
    }elseif($row["status_disposal"] == ($rst_sta32["status_desc"]))
    {
      
      $sta_dis = "Pending ".$rst_apprv3["apprv_name2"];
      //$dt_dis = $row["T"]; 
       // $dt_dis = $row["T49"]; 
      
    }elseif($row["status_disposal"] == ($rst_sta34["status_desc"]))
    {
      
      $sta_dis = "Pending ".$rst_apprv4["apprv_name2"];
      //$dt_dis = $row["T"]; 
       // $dt_dis = $row["T49"]; 
      
    }
    elseif($row["status_disposal"] == ($rst_sta24["status_desc"]))
    {
      
      $sta_dis = "Approved QD";
      //$dt_dis = $row["T19"]; 
      
    }elseif($row["status_disposal"] == ($rst_sta25["status_desc"]))
    {
      
      $sta_dis = "Approved COO";
      //$dt_dis = $row["T29"]; 
      
    }elseif($row["status_disposal"] == ($rst_sta29["status_desc"]))
    {
          if($row["status_part"] == "PR") 
                  { 
      
             if($row["stamp_ind"] == "ASSY")
          {
          
          $sta_dis = "Pending Approval ".$rst_apprv4["apprv_name2"];
          //$dt_dis = $row["T49"]; 	
            
          }elseif($row["stamp_ind"] == "STM")
          {
          
          
          $sta_dis = "Pending Approval ".$rst_apprv3["apprv_name2"];
          //$dt_dis = $row["T49"]; 
          
          }else{ 	}
          
        }else{
          
          
        $sta_dis = "Pending Approval QD";   
          
        }
    
      
    }elseif($row["status_disposal"] == ($rst_sta25["status_desc"]))
    {
      
      $sta_dis = "Approved QD";
      //$dt_dis = $row["T29"]; 
      
    }elseif($row["status_disposal"] == ($rst_sta4["status_desc"]))
    {
      
      $sta_dis = "Cancelled";
      //$dt_dis = $row["T75"]; 
    }
	   
      ?>
                <tr>
                <td width="30"><?php echo $no4; ?></td>
                <td width="80"><?php echo $row["plant_cd"]; ?></td>
                <td width="150"><?php echo $row["doc_dis"]; ?></td>
                <td width="100"><?php echo $row["R"]; ?></td> 
                <td width="80"><?php echo $row["work_center"]; ?></td>
                <td width="80"><?php echo $sta_dis; ?></td>
                <td width="100">
				
				<?php if($row["status_disposal"] == ($rst_sta24["status_desc"])) { ?> 
                 
                    <!--------------------------modal------------------------->
           
          <?php   if($row["status_part"] == "PR") 
		           {   
						 if($row["stamp_ind"] == "STM")
					   {
					
					 //----check setup setting disposal approval [prod stm]	----
			  
			        if($data_setup4["bil_table"] == "4")
                    {  		
					   // include "display_apprv_dis-HQC-prd-stm.php";
					 ?>
      <a href="display_apprv_dis-HQC-prd-stm.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>        
                     
					 <?php  }elseif($data_setup4["bil_table"] == "5")
			      {
				 ?>
	    <a href="display_apprv_dis-2HQC-prd-stm.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>        
		 
          <?php		  }else{  }//$data_setup4
		  
		  
					   }elseif($row["stamp_ind"] == "BLK")
					   {
					
					 //----check setup setting disposal approval [prod stm]	----
			  
			        if($data_setup4["bil_table"] == "4")
                    {  		
					   // include "display_apprv_dis-HQC-prd-stm.php";
					 ?>
      <a href="display_apprv_dis-HQC-prd-stm.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>        
                     
					 <?php  }elseif($data_setup4["bil_table"] == "5")
			      {
				 ?>
	    <a href="display_apprv_dis-2HQC-prd-stm.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>        
		 
          <?php		  }else{  }//$data_setup4
					 
					 ?>
					 
					 
					 
					 <?php
					 }else{  //stamp_ind = "ASSY"
						 
						 
					 //----check setup setting disposal approval [prod assy]	----
			  
			        if($data_setup3["bil_table"] == "4")
                   {  		  	 
						//include "display_apprv_dis-HQC-prd.php";
						
						?>
          <a href="display_apprv_dis-HQC-prd.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>        				
                   
                   <?php  }elseif($data_setup3["bil_table"] == "5")
			      {
				 ?>
                   
        <a href="display_apprv_dis-2HQC-prd.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>        				
               
              <?php		 }else{  }//$data_setup3
					 
				
					
					 } // end else stamp_ind = "ASSY" 
					
				
				}elseif($row["status_part"] == "ENG") 
		           { 	
					
					
			     //----check setup setting disposal approval [ENG]	----
			  
			        if($data_setup7["bil_table"] == "4")
                    {  		
					   // include "display_apprv_dis-HQC-prd-stm.php";
					 ?>
        <a href="display_apprv_dis-HQC-prd-ENG.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>        
                     
			<?php  }elseif($data_setup7["bil_table"] == "5")
			      {
				 ?>
	    <a href="display_apprv_dis-2HQC-prd-ENG.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>        
		 
          <?php		  }else{  }//$data_setup4		
					
									
					
			    }elseif($row["status_part"] == "WS") 
		           { 
					
					
					 //----check setup setting disposal approval ppc	----
			  
			      if($data_setup6["bil_table"] == "4")
                   {  
				   // include "display_apprv_dis-HQC-rcv.php"; 
				   
				   ?>
         <a href="display_apprv_dis-HQC-rcv.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>		
				
                
					<?php  }elseif($data_setup6["bil_table"] == "5")
			     {
				 ?>
                
   <a href="display_apprv_dis-2HQC-rcv.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>		
                
                 <?php  }else{  }//$data_setup6   ?>
                
                
                
                	
					<?php
                    
			 }elseif($row["status_part"] == "WQ") 
		          { 
					
				  //----check setup setting disposal approval ppc	----
			  
			     if($data_setup6["bil_table"] == "4")
                   {  		
		           // include "display_apprv_dis-HQC-dlv.php"; 
						?>
   <a href="display_apprv_dis-HQC-dlv.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>                      
                 
                 	<?php  }elseif($data_setup6["bil_table"] == "5")
			       {
				 ?>
                 
      <a href="display_apprv_dis-2HQC-dlv.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>                      
               <?php  }else{  }//$data_setup6   ?>
                        
                   <?php     		
					}elseif($row["status_part"] == "QC") 
		            { 
					
					 	 //----check setup setting disposal approval QC	----
			  
			       if($data_setup5["bil_table"] == "4")
                   {  		  
					
		            // include "display_apprv_dis-HQC.php"; 
						?>
       <a href="display_apprv_dis-HQC.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>                                        
                  
                <?php  }elseif($data_setup5["bil_table"] == "5")
                   {
					?>   
                  
       <a href="display_apprv_dis-2HQC.php?buidT=<?php echo base64_encode($row["doc_dis"]);  ?>&&plant_code=<?php echo $plant_code; ?>&&date1=<?php echo $dateF; ?>&&date2=<?php echo $dateT; ?>&&work_center=<?php echo $work_center; ?>" ><i class="fa fa-check-circle" aria-hidden="true"></i>Approval</a>                                        
                 
                  <?php	}else{ } // end $data_setup5 
				   
				   ?>
                  
                  
                        
                   <?php		
				   }else{
				
					} //end elseif status part
		  
		     }    ?></td>
                  
          
                <td width="100">
                
                
             <?php     if($row["status_part"] == "PR") 
		            {  
					
						 if($row["stamp_ind"] == "STM")
					 {
					 
				?>
               <a href="print_dis_approve_qc-tranProc-prd-stm.php?buid=<?php echo base64_encode($row["doc_dis"]); ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
					
				<?php }else{   ?>	
					
               <a href="print_dis_approve_qc-tranProc-prd.php?buid=<?php echo base64_encode($row["doc_dis"]); ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
				<?php }   ?>	
					<?php
				}elseif($row["status_part"] == "WS") 
		            { 
					?>
		      <a href="print_dis_approve_qc-tranProc-rcv.php?buid=<?php echo base64_encode($row["doc_dis"]); ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
				  <?php	
					}elseif($row["status_part"] == "WQ") 
		            { ?>
		      <a href="print_dis_approve_qc-tranProc-dlv.php?buid=<?php echo base64_encode($row["doc_dis"]); ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
					<?php
		            }elseif($row["status_part"] == "QC") 
		            { 	?>
              <a href="print_dis_approve_qc-tranProc-qqc.php?buid=<?php echo base64_encode($row["doc_dis"]); ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
					<?php
					}elseif($row["status_part"] == "ENG") 
		            { 	?>
              <a href="print_dis_approve_qc-tranProc-prd-ENG.php?buid=<?php echo base64_encode($row["doc_dis"]); ?>"  target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
					<?php
				
					
					}else{
				
					}
               
		    ?>   </td>
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
   mysqli_free_result($rsDis); 
	
	}else{   // free up the resources 
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
	  
      $('#demoSelect').select2();
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