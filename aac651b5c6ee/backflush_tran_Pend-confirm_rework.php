<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

set_time_limit(0);

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
//----------------------------------------------------

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
    $url = "backflush_tran_Pend-confirm_rework.php"; 
	
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

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

//CR status (Pending)
$sta8 = "SELECT * from request_status WHERE status_id = '8'";
$sta_res8 = mysqli_query($dbc,$sta8);
$rst_sta8 = mysqli_fetch_array($sta_res8);

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
   <!-- <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>-->
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
          <h1><i class="fa fa-bar-chart"></i> Production</h1>
          <p>Rework Confirmation</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Production</li>
          <li class="breadcrumb-item"><a href="backflush_tran_Pend-confirm_rework.php">Rework Confirmation</a></li>
        </ul>
      </div> 
                        
      <div class="row">
        <div class="col-md-12">
          <div class="tile"><h3 class="tile-title">Rework Confirmation</h3>
            <div class="tile-body">
              <div class="table-responsive">
              
                  
      <?php
	  
	    $message_pcode = "";
		$message_psdt = "";
		$message_psdt2 = "";
	  
        if(isset($_POST["Submit2"]))
        {
			
			$dateF = $_POST["date1"];
            $dateT = $_POST["date2"];
			$plant_code = $_POST["plant_code"];
			$work_center = $_POST["work_center"];
			$material_no = $_POST["material_no"]; 
			//$bflush_no = $_POST["bflush_no"]; 
		
			
				
				if(($_POST["plant_code"]) == "NULL")
		 {
			 $plant_code = FALSE;
			 $message_pcode = '<span class="badge badge-pill badge-danger">Please select Plant!</span>';
		 }else{
			 
				  $plant_code = TRUE;	 
			 
		  }
		  
	
	    
		  if((($_POST["date1"]) == "00-00-0000") || (($_POST["date1"]) == ""))
     {
	     $dateF = FALSE;
		 $message_psdt = '<span class="badge badge-pill badge-danger"> Please select Posting Date !</span>';
	 }else{
		 $dateF = TRUE;
	  }
	  
	    if((($_POST["date2"]) == "00-00-0000") || (($_POST["date2"]) == ""))
     {
	     $dateT = FALSE;
		 $message_psdt2 = '<span class="badge badge-pill badge-danger"> Please select Posting Date !</span>';
	 }else{
		 $dateT = TRUE;
	  }
	  
	   
			if($plant_code && $dateF && $dateT)//everything ok
		   {  
			
			$dateF = $_POST["date1"];
            $dateT = $_POST["date2"];
			$plant_code = $_POST["plant_code"];
			$work_center = $_POST["work_center"];
			$material_no = $_POST["material_no"]; 
			//$bflush_no = $_POST["bflush_no"]; 	
				
						 
            echo "<script>";
            echo "window.location='backflush_tran_Pend-confirm_rework2.php?date1=$dateF&&date2=$dateT&&plant_code=$plant_code&&work_center=$work_center&&material_no=$material_no'";
            echo "</script>";
            exit(); //quit the script
         
		 
		  }
   
   
   
		}
    	?>
              
            <form action="" method="post" name="frmSearch" id="frmSearch">
            <br>
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%">&nbsp;</th>
            </tr>
            <tr>
            <th>Date From : <font color="#FF0000">*</font></th>
            <td>
           <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php if(isset($_POST['date1'])){ echo $_POST['date1']; }else{ echo $fmt_curr_date; } ?>" /><div class="form-control-feedback" ><?php echo $message_psdt; ?></div>
		     </td>
             </tr>
             <tr>
              <th>Date To : <font color="#FF0000">*</font></th>
              <td><input class="form-control" id="PSS2Date" type="text" placeholder="Select Date" name="date2" value="<?php if(isset($_POST['date2'])){ echo $_POST['date2']; }else{ echo $fmt_curr_date; } ?>" /><div class="form-control-feedback" ><?php echo $message_psdt2; ?></div></td>
              </tr>
              <tr>
                <th>Plant : <font color="#FF0000">*</font></th>
                <th>
               		
           <select name="plant_code" class="form-control" onChange="getWorkCenter(this.value)">
            <option value="NULL" placeholder="Select Plant"> -- Select Plant -- </option>
          <?php
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y"';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
              ?>
         <option value="<?php echo $row27["plant_code"]; ?>" > <?php echo stripslashes($row27["plant_code"]); ?> - <?php echo $row27["plant_desc"]; ?></option>
          <?php
           }  ?>
                            
        </select><div class="form-control-feedback" ><?php echo $message_pcode; ?></div>
                </th>
              </tr>
              <tr>
                <th>Line :</th>
                <th><div id="work_centerdiv"><select name="work_center" id="work_center" class="form-control" onChange="getMaterial(this.value)">
                  <option value="NULL" placeholder="Select Line"> -- Select Line --</option>
                </select></div></th>
              </tr>
               <tr>
                <th>Part Number :</th>
                <th><div id="mat_div"> <select name="material_no" id="material_no" class="form-control">
                  <option value="NULL" placeholder="Select Part Number"> -- Select Part Number --</option>
                                  </select></div></th>
              </tr>
            
           
              <tr>
                <th><input name="Submit2" type="submit" class="btn btn-info" id="button" value="SEARCH" /></th>
                <th>&nbsp;</th>
              </tr>
            
                </table>
        </form>
 
  
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
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
    <script type="text/javascript">
      $('#sl').on('click', function(){
      	$('#tl').loadingBtn();
      	$('#tb').loadingBtn({ text : "Signing In"});
      });
      
      $('#el').on('click', function(){
      	$('#tl').loadingBtnComplete();
      	$('#tb').loadingBtnComplete({ html : "Sign In"});
      });
      
      $('#PSSDate').datepicker({
		defaultDate: new Date(),
		format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
	  
      
	   $('#PSS2Date').datepicker({
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
		
		var strURL="findPlant4.php?plant_code="+plant_code;
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
	
	function getMaterial(work_center) {		
		
		var strURL="findMaterial4.php?work_center="+work_center;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('mat_div').innerHTML=req.responseText;						
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