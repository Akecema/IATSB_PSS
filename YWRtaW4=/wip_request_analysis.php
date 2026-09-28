<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "1")) {
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
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
    $url = "wip_request_analysis.php"; 

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
      <?php   include "left_admin_menu.php";   ?>
   
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> WIP Request</h1>
          <p>WIP Request Analysis</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">WIP Request</li>
          <li class="breadcrumb-item"><a href="wip_request_analysis.php">WIP Request Analysis</a></li>
        </ul>
      </div> 
           
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
              
            <form action="" method="post" name="frmSearch" id="frmSearch">
            <table class="table table-bordered">
            <tr>
            <th>Request Date From : <font color="#FF0000">*</font></th>
            <td>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" /> 
		     </td>
              <th>Request Date To : <font color="#FF0000">*</font></th>
              <td>
			   <input class="form-control" id="PSS2Date" type="text" placeholder="Select Date" name="date2" />
			  </td>
            </tr>
            
              <tr>
              <th>Factory :</th>
              <td><select name="factory" id="factory" onChange="getFactory(this.value)" class="form-control" >
                <option value="NULL" placeholder="Select Factory"> -- Select Factory --</option>
                <?php
	       $query3 = "SELECT * FROM factory_detail GROUP BY factory_desc2 ORDER BY id_fac ASC";
                   $result3 = mysqli_query($dbc,$query3);
  
                   while($row3=mysqli_fetch_array($result3)) 
			      {
                  echo'<option value="',html_esc($row3["factory_desc2"]),'">',stripslashes($row3["factory_desc"]),'</option>';
                  }
				?>
              </select>
              </td>
              <th>Work Center :</th>
              <td><div id="work_centerdiv"> 
               <select name="work_center" id="work_center" class="form-control" >
                <option value="NULL" placeholder="Select Work Center"> -- Select Work Center --</option>
                </select></div></td>
             </tr>
             <tr>
              <th>Material No. :</th>
              <td><select name="material_no" id="material_no" class="form-control">
                    <option value="NULL" placeholder="Select Material No."> -- Select Material No. --</option>
                   <?php
	             $query9 = "SELECT * FROM mat_master_detail WHERE bom_status = 'Y' GROUP BY bill_component ORDER BY bill_component ASC";
                   $result9 = mysqli_query($dbc,$query9);
  
                   while($row9=mysqli_fetch_array($result9)) 
			      {
				   ?>
                  <option value="<?php echo html_esc($row9["bill_component"]); ?>"> <?php echo html_esc($row9["bill_component"]); ?></option>
                  <?php
                  }
				?>
                  </select> </td>          
              <th>Status :</th>
              <td><select name="status" id="status" class="form-control" >
                  <option value="NULL" placeholder="Select Status"> -- Select Status --</option>
                  <option value="New">Open</option>
                  <option value="Close">Close</option>
                  </select></td>
              </tr>
              <tr>
                <th>&nbsp;<font color="#FF0000">* Compulsory field</font></th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th><input name="Submit2" type="submit" class="btn btn-info" id="button" value="SEARCH" /></th>
              </tr>
            
                </table>
        </form>
 
      
      <?php
        if(isset($_POST["Submit2"]))
        {
            $material_no = $_POST["material_no"];
			$factory = $_POST["factory"];
			$work_center = $_POST["work_center"];
			$status = $_POST["status"];
            $dateF = $_POST["date1"];
            $dateT = $_POST["date2"];
								
			
			 if(($_POST["date1"]) > ($_POST["date2"]))
			{
				
			echo "<script>";
			echo "alert('Request date from is more than Request date to.');";
			echo "</script>";
			exit(); //quit the script	
				
			}
			
			 if((($_POST["date1"]) == "00-00-0000") || (($_POST["date1"]) == ""))
			{
				
			echo "<script>";
			echo "alert('Please select request date from.');";
			echo "</script>";
			exit(); //quit the script	
				
			}
						
			  if((($_POST["date2"]) == "00-00-0000") || (($_POST["date2"]) == ""))
			{
				
			echo "<script>";
			echo "alert('Please select request date to.');";
			echo "</script>";
			exit(); //quit the script	
				
			}
			
			
	
			 
            echo "<script>";
            echo "window.location='wip_request_analysisProc.php?factory=".html_esc($factory)."&&work_center=".html_esc($work_center)."&&status=".html_esc($status)."&&date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&material_no=".html_esc($material_no)."'";
            echo "</script>";
            exit(); //quit the script
        }
        
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
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
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
      	format: "dd-mm-yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
      
	   $('#PSS2Date').datepicker({
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
	
	function getFactory(factory) {		
		
		var strURL="findWorkcenter2.php?factory="+factory;
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