<?php
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

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
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

//CR status (QC OK)
$sta11 = "SELECT * from request_status WHERE status_id = '11'";
$sta_res11 = mysqli_query($dbc,$sta11);
$rst_sta11 = mysqli_fetch_array($sta_res11);

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

//CR status (Transfer QC)
$sta18 = "SELECT * from request_status WHERE status_id = '18'";
$sta_res18 = mysqli_query($dbc,$sta18);
$rst_sta18 = mysqli_fetch_array($sta_res18);

//CR status (Cancel)
$sta21 = "SELECT * from request_status WHERE status_id = '21'";
$sta_res21 = mysqli_query($dbc,$sta21);
$rst_sta21 = mysqli_fetch_array($sta_res21);

//CR status (Close)
$sta22 = "SELECT * from request_status WHERE status_id = '22'";
$sta_res22 = mysqli_query($dbc,$sta22);
$rst_sta22 = mysqli_fetch_array($sta_res22);

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
<!--    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
-->    <!--  <script src="https://www.w3schools.com/lib/w3.js"></script>-->
	
	<SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    
<style>
   
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


<SCRIPT LANGUAGE="JavaScript">
<!-- 

<!-- Begin
function Check(chk)
{
if(document.myform.Check_ctr.checked==true){
for (i = 0; i < chk.length; i++)
chk[i].checked = true ;
}else{

for (i = 0; i < chk.length; i++)
chk[i].checked = false ;
}
}

// End -->
</script>

<?php
//echo "the following values have been checked: ";
$checked="";
$amount ="";

$a = array();
if(isset($_POST["cancel"])) {
	foreach($_POST["cancel"] as $j=>$i) {
	    $amount .= $_POST["remark_closed"][$i]."|";
		$checked .= ($checked==""?"":",") . "checkbox" . $i;
		
		array_push($a, $i);
	//	 array_push($amount, $i);
	}
}
//echo $checked;
//echo $amount;

function was_checked($i,$a) {
if(in_array($i, $a)===true) {
return "checked='checked'";
return "";
}
}

?>
  
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
		  
		    $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plant_code = $_GET["plant_code"];
			$work_center = $_GET["work_center"];
			//$bflush_no = $_GET["bflush_no"];
			$material_no = $_GET["material_no"];
			
					
		  ?>    
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
            <br>
            <table class="table table-bordered">
            <tr>
             <th width="31%">&nbsp;<div align="left"><font color="#FF0000">* Compulsory field</font></div></th>
             <th width="69%">&nbsp;</th>
            </tr>
            <tr>
            <th>Date From : <font color="#FF0000">*</font></th>
            <td>
              <?php
			     $dd1 = substr($_GET["date1"],8,2);
				 $mm1 = substr($_GET["date1"],5,2);
				 $yy1 = substr($_GET["date1"],0,4);
			?>
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" >
		     </td>
            </tr>
             <tr>
              <th>Date To : <font color="#FF0000">*</font></th>
              <td><input class="form-control" id="PSS2Date" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>"></td>
         
           </tr>
            <tr>
                <th>Plant : <font color="#FF0000">*</font></th>
                <th><select name="plant_code" class="form-control" onChange="getWorkCenter(this.value)">
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
                </select></th>
              </tr>
              <tr> 
                <th>Line :</th>
                <th><div id="work_centerdiv"><select name="work_center" id="work_center" class="form-control" onChange="getMaterial(this.value)">
                  <option value="NULL" placeholder="Select Line"> -- Select Line --</option>
                  <?php
	               $query5 = new PreparedSql("SELECT * FROM work_center_detail WHERE plant_code = ? AND dept_acc = 'PRODUCTION' AND status_wc = 'Y' ORDER BY id_work ASC", [$_GET["plant_code"]]);
                   $result5 = db_query($dbc, $query5);
  
                   while($row5=mysqli_fetch_array($result5)) 
				    { 
				   
				   ?>
                  <option value="<?php echo html_esc($row5["id_work"]); ?>" <?php if($row5["id_work"] == $_GET["work_center"]) echo "selected"; ?>> <?php echo html_esc($row5["id_work"]),' - ',stripslashes($row5["wc_desc"]); ?></option>
                  <?php
                  }
				?>
                </select></div></th>
              </tr>
               <tr>
                <th>Part Number :</th>
                <th><div id="mat_div"><select name="material_no" id="material_no" class="form-control">
                  <option value="NULL" placeholder="Select Part Number"> -- Select Part Number --</option>
                  <?php
	             $query49 = "SELECT * FROM table_material_itsb WHERE prod_line = '".sql_esc($work_center)."' AND status_BOM = 'Y' ORDER BY material_no ASC";
                   $result49 = mysqli_query($dbc,$query49);
  
                   while($row49=mysqli_fetch_array($result49)) 
			      {
				   ?>
                  <option value="<?php echo html_esc($row49["material_no"]); ?>"<?php if($row49["material_no"] == $_GET["material_no"]) echo "selected"; ?>> <?php echo html_esc($row49["material_no"]); ?> - <?php echo html_esc($row49["material_desc"]); ?></option>
                  <?php
                  }
				?>
                </select></div></th>
              </tr>
             
              <tr>
                <th><input name="Submit2" type="submit" class="btn btn-info" id="button" value="SEARCH" /></th>
                <th>&nbsp;</th>
               </tr>
                </table>
              </form>
       
      <?php
       
			
			
			 //convert 
			
			$query_convert = new PreparedSql("SELECT * FROM work_center_detail as SR WHERE SR.id_work = ?", [$_GET["work_center"]]);
			$result_convert = db_query($dbc, $query_convert); 
			$row_convert = mysqli_fetch_array($result_convert);
			
		    //-------Count all results------------------------//
			
				 $where_sql = '';
				 
				 
				 
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);
				 		
		 // 1. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND (MR.date_posting >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 2. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (MR.date_posting <= '".sql_esc($date2_final)."')"; } 
					 	 
		 //3. Plant Code 
                if ($plant_code == "NULL"){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND MR.plant_code = '".sql_esc($plant_code)."'"; } 
					
          //4. Work Center
                if ($work_center == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND MR.work_center = '".sql_esc($work_center)."'"; }
   
	       //5. Part Number
                if ($material_no == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
                    $wheresql_05 = " AND MR.material_no = '".sql_esc($material_no)."'"; }  	
		
	                                        
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;
	
	//********** END CONDITION **************
	
  $query8 = "SELECT COUNT(*) FROM pps_detail_trn_fg_pending_confirm AS MR WHERE MR.status_pps = 'REWORK' AND MR.status = 'Y' AND (MR.status_pps != '".sql_esc($rst_sta11["status_desc"])."' AND MR.status_pps != '".sql_esc($rst_sta4["status_desc"])."') " .$where_sql;
   $result8 = mysqli_query($dbc,$query8);
   $num_rows = mysqli_num_rows($result8);
			
  
$query_final = "SELECT *, DATE_FORMAT(MR.date_plan,'%d-%m-%Y') as R, DATE_FORMAT(MR.date_posting,'%d-%m-%Y') as R2, DATE_FORMAT(MR.date_create,'%d-%m-%Y') as R3 FROM pps_detail_trn_fg_pending_confirm AS MR WHERE MR.status_butn = 'REWORK' AND MR.status = 'Y' AND (MR.status_pps != '".sql_esc($rst_sta11["status_desc"])."' AND MR.status_pps != '".sql_esc($rst_sta4["status_desc"])."') " .$where_sql." ORDER BY MR.plan_no ASC ";
$rs = mysqli_query($dbc,$query_final);
$num_rows = mysqli_num_rows($rs);   //how many material are there?
		  
		 if ($num_rows > 0) {
	 
	         echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>';
			 
?>
                <table class="table table-bordered">
                <thead>
                <tr>
                <th>No.</th>
                <th>Model</th>
                <th>Part Number</th>
                <th>BF Pending Doc. No.</th>
                <th>Pending Doc. No.</th>
                <th>Posting Date</th>
                <th>Line</th>
                <th>Shift</th> 
                <th>Quantity</th>
                <th>Status</th>
                <th>Action</th>
                </tr>
              </thead>   
              <tbody>	
<?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   $k = 1;
   
   while($row_final = mysqli_fetch_array($rs))
	{	
	//shift	
		if($row_final["shift_pps1"] != "")
	{
		$sta = "D/S";
		
	}elseif($row_final["shift_pps2"] != "")
	 {
		$sta = "N/S";
	 }else{
		 
		$sta = " ";
	 }	
	 
	if($row_final["status_butn"] == "REWORK")
	{
	$status_out = "Pending RW";
	}elseif($row_final["status_butn"] == "QC OK")
	{
	$status_out = "x Pending RW";	
	}
	
    
	  //----model ---
  
 $query_Mod = new PreparedSql("SELECT * FROM model_detail_tbl WHERE model_code = ? AND plant_code = ? AND status_model = 'Y' ORDER BY id_model ASC", [$row_final["model_code"], $row_final["plant_code"]]);
 $result_Mod = db_query($dbc, $query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  
 
  if($row_Mod["model_desc"] == "")
  {
	  $model_name = $row_Mod["model_desc"];
  }else{
	  
	 $model_name = $row_Mod["model_desc"]; 
  }

   //----line ---
  
 $query_Mod2 = new PreparedSql("SELECT * FROM work_center_detail WHERE id_work = ? AND status_wc = 'Y' ORDER BY id ASC", [$row_final["work_center"]]);
 $result_Mod2 = db_query($dbc, $query_Mod2);
 $row_Mod2 = mysqli_fetch_array($result_Mod2);  
 
  if($row_Mod2["wc_desc2"] == "")
  {
	  $model_name2 = $row_Mod2["id_work"];
  }else{
	  
	 $model_name2 = $row_Mod2["wc_desc2"]; 
  }
	  
	 
      ?>
           
                <tr>
                <td width="30"><?php echo $no; ?></td>
                <td width="48"><?php echo $model_name; ?></td>
                <td width="48"><?php echo html_esc($row_final["material_no"]); ?></td>
                <td width="120"><?php echo html_esc($row_final["bflush_pending"]); ?></td>
                <td width="120"><?php echo html_esc($row_final["bflush_no"]); ?></td>
                <td width="80"><?php echo html_esc($row_final["R2"]); ?></td>
                <td width="80"><?php  echo $model_name2; ?></td> 
                <td width="40"><?php echo $sta; ?></td> 
                <td width="43"><div align="center"><?php echo number_format($row_final["qty_REWORK"]); ?></div></td>
                <td width="90"><div align="center"><?php echo $status_out; ?></div></td>
                <td width="100"> 
                <a href="bflush_tran_Pend_c-rework.php?uid2=<?php echo html_esc($row_final["id"]); ?>" >
               <!-- <a href="#myNoteRework<?php echo html_esc($row_final["id"]); ?>" data-toggle="modal"  target="_parent" >--><i class="fa fa-check-circle" aria-hidden="true"></i>Reworked Qty</a>
                
                 <?php    
				 //include "bflush_tran_Pend_c-rework.php";  
				  ?>
                 
               <input name="id[<?php echo $k; ?>]" type="hidden" value="<?php echo html_esc($row_final["id"]); ?>">
               </td>
                </tr>
          
          <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  $k++;
		  } 
	 
	 
	 
		  ?>
          </tbody>
          </table>
         
 
 
 
 <br>
               
<!--Total <?php echo $num_rows;?> Record : <?php echo $num_pages;?> Page :
--><?php


   mysqli_free_result($rs); 
   
 
	}   // free up the resources 
else
{
?><center>
<table width="800" cellspacing="0" class="textboxred">
  <tr> 
    <td><div align="center"><font color="#FF0000"><strong>There are currently no Rework Request.</strong></font></div></td>
  </tr>
</table></center>
        <?php
		   } 
		   
//mysqli_close($dbc);
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