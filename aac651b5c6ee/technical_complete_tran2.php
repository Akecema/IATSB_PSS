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
	
    $url = "technical_complete_tran.php";
	
	ini_set('display_errors', 1);
	error_reporting(~0);

	
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
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
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
    <script language="javascript">
	$('.datepicker').pickadate({
weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
showMonthsShort: true
})
	</script>
    
    
	<script>
		function showEdit(editableObj) {
			$(editableObj).css("background","#FFF");
		} 
		
		function saveToDatabase(editableObj,column,id) {
			$(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "saveClose-Plan.php",
				type: "post",
				data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
				success: function(data){
					$(editableObj).css("background","#E8F6F3");
					parent.location.reload();
				}        
		   });
		}
		</script>
          <!-- for tick checkbox generate Doc------->
 <script language="javascript">
$(document).ready(function (){
   var table = $('#example').DataTable({
      pageLength: 10
   });

   // Handle form submission event
   $('#myform').on('submit', function(e){
      var form = this;

      // Encode a set of form elements from all pages as an array of names and values
      var params = table.$('input,select,textarea').serializeArray();

      // Iterate over all form elements
      $.each(params, function(){
         // If element doesn't exist in DOM
         if(!$.contains(document, form[this.name])){
            // Create a hidden element
            $(form).append(
               $('<input>')
                  .attr('type', 'hidden')
                  .attr('name', this.name)
                  .val(this.value)
								  
				  
				/* $('#shift_pps1').append($('<option>',
				 {
				  .attr('type', 'hidden')
                  .attr('name', this.name)
                  .val(this.value)
				}));*/
            );
         }
      });
   });
});
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
          <h1><i class="fa fa-th-list"></i> Planning</h1>
          <p>Close Planned Order</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Planning</li>
          <li class="breadcrumb-item"><a href="technical_complete_tran.php">Close Planned Order</a></li>
        </ul>
      </div> 
          
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body"><br>
              <div class="table-responsive">
         <?php
		  
		      $message_pcode = "";
			  $message_psdt = "";
			  $message_psdt2 = "";
			  $message_line = "";
		  
		    $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plan_category = $_GET["plan_category"];
			$material_no = $_GET["material_no"]; 
			$shift_ops = $_GET["shift_ops"];
			
	
			  ?>    
              
            <form action="" method="get" name="frmSearch" id="frmSearch">
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
             <input class="form-control" id="PSSDate" type="text" placeholder="Select Date" name="date1" value="<?php echo html_esc($_GET['date1']); ?>" ><div class="form-control-feedback" ><?php echo $message_psdt; ?></div>		     </td>
            </tr>
             <tr>
              <th>Date To : <font color="#FF0000">*</font></th>
              <td><input class="form-control" id="PSS2Date" type="text" placeholder="Select Date" name="date2" value="<?php echo html_esc($_GET['date2']); ?>"><div class="form-control-feedback" ><?php echo $message_psdt2; ?></div></td>
           </tr>
            <tr>
                <th>Process :</th>
                <th><select name="plan_category" class="form-control" onChange="getProc(this.value)">
                <option value="NULL" placeholder="Select Process"> -- Select Process -- </option>
                <option value="STM" <?php if($_GET["plan_category"] == 'STM') { ?> selected="selected"<?php } ?>>PRESS STAMPING</option>
                <option value="ASSY" <?php if($_GET["plan_category"] == 'ASSY') { ?> selected="selected"<?php } ?>>WELD ASSEMBLY</option>
                 <option value="BLK" <?php if($_GET["plan_category"] == 'BLK') { ?> selected="selected"<?php } ?>>BLANKING</option>
                </select><div class="form-control-feedback" ><?php echo $message_pcode; ?></div></th>
              </tr>
              <tr> 
                <th>Part No. :</th>
                <th>
                
                <div id="back_nodiv"><select name="material_no" id="material_no" class="form-control" >
                  <option value="NULL" placeholder="Select Part No."> -- Select Part No. --</option>
                 <?php
				 
	               $query5 = "SELECT * FROM table_material_itsb WHERE category_mat = '".sql_esc($_GET["plan_category"])."' AND (Vclass = 'Z201' OR Vclass = 'Z301') AND status_BOM = 'Y' ORDER BY id_mat ASC";
                   $result5 = mysqli_query($dbc,$query5);
  
                   while($row5=mysqli_fetch_array($result5)) 
				    { 
				   
				   ?>
                  <option value="<?php echo html_esc($row5["material_no"]); ?>" <?php if($row5["material_no"] == $_GET["material_no"]) echo "selected"; ?>>(<?php echo html_esc($row5["back_no"]); ?>)&nbsp;<?php echo html_esc($row5["material_no"]); ?> -  <?php echo html_esc($row5["material_desc"]); ?></option>
                  <?php
                  }
				?> 
                  
                  
                </select></div> <div class="form-control-feedback" ><?php echo $message_line; ?></div></th>
              </tr>
             
              <tr>
                <th>Shift :</th>
                <th><select name="shift_ops" id="shift_ops" class="form-control">
                  <option value="NULL" placeholder="Select Shift"> -- Select Shift --</option>
                  <option value="D/S" <?php if($_GET["shift_ops"] == "D/S") { ?> selected="selected"<?php } ?>>D/S - Day Shift</option>
                  <option value="N/S" <?php if($_GET["shift_ops"] == "N/S") { ?> selected="selected"<?php } ?>>N/S - Night Shift</option>
                </select></th>
              </tr>
              <tr>
                <th><input name="Submit2" type="submit" class="btn btn-info" id="button" value="SEARCH" /></th>
                <th>&nbsp;</th>
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
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);
				 		
		 // 1. dateF
                if ($dateF == "0000-00-00" ){
                    $wheresql_01 = ""; }
                else {
                    $wheresql_01 = " AND (date_plan >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 2. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (date_plan <= '".sql_esc($date2_final)."')"; } 
					 	 
		 //3. Plan Category 
                if ($plan_category == "NULL"){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND plan_category = '".sql_esc($plan_category)."'"; } 
					
          //4. Part No.
                if ($material_no == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND material_no = '".sql_esc($material_no)."'"; }
   
			 
		  //5. Shift
                if ($shift_ops == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
					// $wheresql_06 = ""; }
					
                    $wheresql_05 = " AND ((shift_pps1 = '".sql_esc($shift_ops)."') OR (shift_pps2 = '".sql_esc($shift_ops)."')) "; }  		 				        
					
                                       
				
				$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;	
	
	//********** END CONDITION **************
			
			
		?>	
<!--	<script language="javascript">		
			if (confirm('Are sure to close the planned order <?php echo $part3; ?>!')) {
				
				
				-->
			<?php
			
			
			 //echo "window.location='close_sbarcode_single.php?puid=$part3'";
			
			
			?>
 <!-- // true (paypal.me/andrewdhyder)
} else {
  // false
}

</script>
			-->
		<?php	
		
		 // }	
				
	
	//********** END CONDITION **************
	
  $query8 = "SELECT COUNT(*) FROM pps_detail WHERE (status_pps = '".sql_esc($rst_sta7["status_desc"])."' OR status_pps = '".sql_esc($rst_sta18["status_desc"])."') AND status = 'Y' " .$where_sql;
   $result8 = mysqli_query($dbc,$query8);
   $num_rows = mysqli_num_rows($result8);
			
  
$query_final = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') as R, DATE_FORMAT(date_posting,'%d-%m-%Y') as R2, DATE_FORMAT(date_create,'%d-%m-%Y') as R3, DATE_FORMAT(work_hours,'%H:%i') as T5 FROM pps_detail WHERE (status_pps = '".sql_esc($rst_sta7["status_desc"])."' OR status_pps = '".sql_esc($rst_sta18["status_desc"])."') AND status = 'Y' " .$where_sql." ORDER BY plan_no ASC ";
$rs = mysqli_query($dbc,$query_final);
$num_rows = mysqli_num_rows($rs);   //how many material are there?
		  
		 if ($num_rows > 0) {
	 
	         echo '<div align="center">There are currently  '. $num_rows.' record(s).</div>';
			 
?>
  <form name="myform" method="post" action="technical_complete_tran2.php?date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&plan_category=<?php echo html_esc($plan_category); ?>&&material_no=<?php echo html_esc($material_no); ?>&&shift_ops=<?php echo html_esc($shift_ops); ?>">
 
                <table class="table table-hover table-bordered" id="example">
                <thead>
                <tr>
                <th>No. </br> <input type="checkbox" name="chkDel" class="selectall"/> </br> </th>
                <th>Back Number</th>
                <th>Part Number</th>
                <th>Planned Order No.</th>
                <th>Planned Date</th>
                <th>Shift</th> 
                <th>Status</th>
                <th>Remarks</th>
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
	 
	 //-----checking planned order Qty is completed --------//
	 
	 $tot_BFOK = 0.000;
	 
	 $query_chk_bfOK = "SELECT * FROM pps_detail_trn_fg_ok WHERE plan_no = '".sql_esc($row_final["plan_no"])."'";
	 $rs_chk_bfOK = mysqli_query($dbc,$query_chk_bfOK);
     
	 while($row_chk_bfOK = mysqli_fetch_array($rs_chk_bfOK))
	  {
		 $tot_BFOK =  ($tot_BFOK + $row_chk_bfOK["qty_actual"]);
		  
	  }
	 
	 
	  if($tot_BFOK > ($row_final["qty_plan"]))
	  {
	    $status_new = "COMPLETED";
		$msg_sta =  '<span class="badge badge-pill badge-success">'.$status_new.'</span>'; 	
	
	  }elseif($tot_BFOK == ($row_final["qty_plan"]))
	  {
	    $status_new = "COMPLETED";
		$msg_sta =  '<span class="badge badge-pill badge-success">'.$status_new.'</span>'; 	
	
	  }elseif($row_final["status_pps"] == $rst_sta7["status_desc"])
	   {
	    $status_new = "IN PROGRESS";
		$msg_sta =  '<span class="badge badge-pill badge-warning">'.$status_new.'</span>';  
	   
	   }elseif($row_final["status_pps"] == $rst_sta13["status_desc"])
	   {
		   
		 $status_new = "CLOSED";
		 $msg_sta =  '<span class="badge badge-pill badge-danger">'.$status_new.'</span>';    
		   
		   
	   }elseif($row_final["status_pps"] == $rst_sta["status_desc"])
	   {
		   
		$status_new = "NEW";
		$msg_sta =  '<span class="badge badge-pill badge-info">'.$status_new.'</span>';  
		
	   }else{
		   
		$status_new = "NEW";
		$msg_sta =  '<span class="badge badge-pill badge-info">'.$status_new.'</span>';    
		   
	   }
	
	 
		 
	 
	 //-----time---------
	 
	  if($row_final["work_hours"] != "00:00:00")
  
	  {
		$time_new =  $row_final["T5"];  
		  
	  }else{
		$time_new = "";  
	  }
	
  
	 
	 
	 
	  //----model ---
  
 $query_Mod = new PreparedSql("SELECT * FROM work_center_detail WHERE id_work = ? AND status_wc = 'Y' ORDER BY id ASC", [$row_final["work_center"]]);
 $result_Mod = db_query($dbc, $query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  
 
  if($row_Mod["wc_desc2"] == "")
  {
	  $model_name = $row_Mod["id_work"];
  }else{
	  
	 $model_name = $row_Mod["wc_desc2"]; 
  }
  

	 
      ?>
           
                <tr>
                <td width="30">
             <div align="center">
          <input type="checkbox" id="checkbox" name="e_tcid[]" value="<?php echo html_esc($row_final["id"]); ?>" class="form-check">       
                 <?php //echo $no; ?></div></td>
                <td width="48"><?php echo html_esc($row_final["back_no"]); ?></td>
                <td width="48"><?php echo html_esc($row_final["material_no"]); ?></td>
                <td width="120">
                
     <a href="#myNoteView<?php echo html_esc($row_final["id"]); ?>" data-toggle="modal"  target="_parent" ><b><?php echo html_esc($row_final["plan_no"]); ?></b> <?php include "detail_pps_sheet_close_view.php";   ?></a>             
                
                
                </td>
                <td width="80"><?php echo html_esc($row_final["R"]); ?></td>
                <td width="40"><?php echo $sta; ?></td> 
                <td width="90"><?php echo $msg_sta; ?></td>
                <td width="100" contenteditable="true" onBlur="saveToDatabase(this,'remark_closed','<?php echo html_esc($row_final["id"]); ?>')" onClick="showEdit(this);"><?php echo html_esc($row_final["remark_closed"]);  ?></td>
               <!-- <td><textarea name="remark_closed[<?php echo html_esc($row_final["id"]); ?>]" id="textarea" rows="2" cols="10" maxlength="250" ><?php if (isset($_POST['remark_closed'][($row_final["id"])])) { echo html_esc($_POST['remark_closed'][($row_final["id"])]); } ?></textarea>-->
               <input name="sid[]" type="hidden" value="<?php echo html_esc($row_final["id"]); ?>">
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
          
          <table class="table">
     	  <tr>
          <td><div align="left">
           <button type="button" name="btn_release" id="btn_release" class="btn btn-success btn-sm">CLOSE PLANNED ORDER</button>
          
         <!-- <input name="Submit3A" type="submit"  class="btn btn-success" id="button" value="CLOSE PLANNED ORDER" />--></div></td>
          </tr>
          </table>
          
          </form>
 
 
 
 <br>
 <?php
   mysqli_free_result($rs); 
   
 
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
	
	function getProc(plan_category) {		
		
		var strURL="findProc-pss.php?plan_category="+plan_category;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('back_nodiv').innerHTML=req.responseText;						
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
<script type="text/javascript">
$('.selectall').click(function() {
    if ($(this).is(':checked')) {
        $('div input').attr('checked', true);
    } else {
        $('div input').attr('checked', false);
    }
});
</script>

    
<script>
$(document).ready(function () { 
    var oTable = $('#example').dataTable({
        stateSave: true
    });

    var allPages = oTable.fnGetNodes();

    $('body').on('click', '#selectAll', function () {
        if ($(this).hasClass('allChecked')) {
            $('input[type="checkbox"]', allPages).prop('checked', false);
        } else {
            $('input[type="checkbox"]', allPages).prop('checked', true);
        }
        $(this).toggleClass('allChecked');
		
    })
	
	
});
</script>


<script>
//Submit Release Selected Planned Order
//Status changed to submitted
//https://www.youtube.com/watch?v=fGS-Ff3wgXw
//https://stackoverflow.com/questions/29896599/how-can-i-select-all-checkboxes-from-all-the-pages-in-a-jquery-datatable
$(document).on("click", "#btn_release", function(event) {  

$('#example').DataTable();  

	if (confirm('Are you sure? Close selected planned orders?'))
	{
		var e_tcid = new Array();

		var oTable = $('#example').dataTable();  
		var rowcollection =  oTable.$("#checkbox:checked", {"page": "all"});  
		
		rowcollection.each(function(index,elem) {  
			e_tcid.push($(elem).val());
			
		});    
					

		if(e_tcid.length == 0)
		//if($('input.styled').not(':checked').length > 0) 
		{
			alert('Please select a planned order to close.');
		}
		else
		{
			
			
			$.ajax({
			 url: "technical_complete_tran2Proc.php?date1=<?php echo html_esc($dateF); ?>&&date2=<?php echo html_esc($dateT); ?>&&plan_category=<?php echo html_esc($plan_category); ?>&&material_no=<?php echo html_esc($material_no); ?>&&shift_ops=<?php echo html_esc($shift_ops); ?>",
			 type: "POST",
			 data: {
			 	e_tcid:e_tcid
			 },
			 success: function(data){
			 $("#divShow").html(data);
			
			 //$('#output').html(response); 
			 alert('Your transaction has been processed successfully.');
			 location.reload();
			 } 
		
			
			});
			
		}
		
	}
	else
	{
		return false;
	}

});

</script>


  </body>
</html>