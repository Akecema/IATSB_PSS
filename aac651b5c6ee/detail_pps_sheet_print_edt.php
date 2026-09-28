<?php
    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	//$url = "detail_pps_month_reprint.php"; 
	require_once('tcpdf_barcodes_2d.php');

	
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
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   
  <!--  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>-->
      <script language="javascript">
	  $(document).ready(function() {
			$('#example').DataTable( {
				"scrollX": true
			} );
		} );
	  </script>

		<script>
		function showEdit(editableObj) {
			$(editableObj).css("background","#FFF");
		} 
		
		function saveToDatabase(editableObj,column,id) {
			$(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "saveedit.php",
				type: "post",
				data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
				success: function(data){
					$(editableObj).css("background","#E8F6F3");
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
 <!-- <script src="http://code.jquery.com/jquery-latest.min.js"></script>-->
<!--<script>
$(document).ready(function(){
$('select.shift_pps1').on('change',function () {
        var shift_pps1 = $(this).val();
        var id = $('td.myid').html();
        alert(shift_pps1);
        //alert(id);
        $.ajax({
                 type: "POST",
                 url: "SaveDecision.php",
                 data: {shift_pps1: shift_pps1, id: id },
                 success: function(msg) {
                     $('#autosavenotify').text(msg);
                 }
      })
  });
});
</script>-->
   
   
 
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
  

    <style type="text/css" media="print"> 
.breakAfter{ 
page-break-after: always; 
}
.breakBefore{
page-break-before: always ;
}
.tfoot { display: table-footer-group; }
.page {
 size:landscape;
 bottom: 0;
   
}
/* @media print{
  body{  margin-top: -1.8cm;  font-family: Arial, Helvetica, sans-serif; font-size:12px; }
  #ad{ display:none;}
  #leftbar{ display:none;}
  #contentarea{ width:100%;}
  .header, .hide { visibility: hidden }
  .tfoot { display: table-footer-group; }
  @page {size: landscape}
 /* tr.page-break  { display: block; page-break-before: always; }  */
  .breakAfter{ 
page-break-after: always; 
}
.breakBefore{
page-break-before: always ;
}
  
} */
	
@media print {
    body.modalprinter * {
        visibility: hidden;
    }

    body.modalprinter .modal-dialog.focused {
        position: absolute;
        padding: 0;
        margin: 0;
        left: 0;
        top: 0;
    }

    body.modalprinter .modal-dialog.focused .modal-content {
        border-width: 0;
    }

    body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title,
    body.modalprinter .modal-dialog.focused .modal-content .modal-body,
    body.modalprinter .modal-dialog.focused .modal-content .modal-body * {
        visibility: visible;
    }

    body.modalprinter .modal-dialog.focused .modal-content .modal-header,
    body.modalprinter .modal-dialog.focused .modal-content .modal-body {
        padding: 0;
    }

    body.modalprinter .modal-dialog.focused .modal-content .modal-header .modal-title {
        margin-bottom: 20px;
    }
}

</style> 

<style>
<!--modal width-->
.custom { 
	width: 1200px !important;
} 
   
</style>
 

  </head>
  <body class="app sidebar-mini">
  <?php
 //-------------- click button "SAVE"----------------

 if(isset($_POST["edt_btn"])) 
  { // handle the form.

 
    $uid = $_POST["uid"];
    $tid = $_POST["tid"];
    $shift_ops2 = $_POST["shift_ops2"];
	$date_plan = $_POST["date_plan"];
  
    $how_many = count($tid); 
 
   // echo $how_many;
   
   for ($i=0; $i<$how_many; $i++) { 
   
   // echo $uid;  echo "upload"; 
   // echo $shift_ops2[$i];  echo "      id :".$tid[$i]; echo "<br>";
   
   
   
     if($shift_ops2[$i] == "D/S")
	 {
	
	
	   $query_up_sta = "UPDATE pps_detail SET shift_pps1 = '".sql_esc($shift_ops2[$i])."', shift_pps2 = '', date_plan = '".sql_esc($date_plan[$i])."'  WHERE id ='".sql_esc($tid[$i])."'";
	   $result_up_sta = mysqli_query($dbc,$query_up_sta);
	   
	 }elseif($shift_ops2[$i] == "N/S")
	 {
		 
	   $query_up_sta2 = "UPDATE pps_detail SET shift_pps2 = '".sql_esc($shift_ops2[$i])."', shift_pps1 = '', date_plan = '".sql_esc($date_plan[$i])."'  WHERE id ='".sql_esc($tid[$i])."'";
	   $result_up_sta2 = mysqli_query($dbc,$query_up_sta2);
		 
		 
	 }else{
		 
		 
		 
	 }
	 
		 
	 ///---------------select info pss-detail-----------------
	 
	 $qty_upd_inf = new PreparedSql("SELECT * FROM pps_detail WHERE id = ?", [$tid[$i]]);
	 $rst_qty_upd_inf = db_query($dbc, $qty_upd_inf);  
	 $rowac = mysqli_fetch_array($rst_qty_upd_inf);
		  
	 
					 $ddm = substr($rowac["date_plan"],8,2);
					 $mmm = substr($rowac["date_plan"],5,2);
					 $yym = substr($rowac["date_plan"],0,4);
				
					 $date1_m = ($yym.'-'.$mmm.'-'.$ddm);
	 
	 $qty_update_m = "UPDATE pps_detail SET month_plan = '".sql_esc($mmm)."', year_plan = '".sql_esc($yym)."', user_update = '".sql_esc($username)."', date_update = NOW() WHERE id = '".sql_esc($tid[$i])."'";
	  $rst_qty_update_m = mysqli_query($dbc,$qty_update_m);  
	 
	 
   
   } // end for loop
    

		   echo "<script>";
		   echo "alert('Your transaction has been processed successfully');";
		   echo "window.location='display_pps_month_reprint2.php?date1=".html_esc($dateF)."&&date2=".html_esc($dateT)."&&plan_category=".html_esc($plan_category)."&&material_no=".html_esc($material_no)."&&shift_ops=".html_esc($shift_ops)."'";
		   echo "</script>"; 
		   exit(); //quit the script



 }// end submit
?>
  <div class="modal fade printable autoprint" id="myNoteEdit<?php echo html_esc($row["id"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content custom">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">PPS Edit</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
        <div class="content mt-12">
   
  <?php
  
            $dateF = $_GET["date1"];
            $dateT = $_GET["date2"];
			$plan_category = $_GET["plan_category"];
			$material_no = $_GET["material_no"];
			$shift_ops = $_GET["shift_ops"];
		
			
			
			     $ddF = substr($_GET["date1"],0,2);
				 $mmF = substr($_GET["date1"],3,2);
				 $yyF = substr($_GET["date1"],6,4);
			
			     $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
				 
				 
				 $ddT = substr($_GET["date2"],0,2);
				 $mmT = substr($_GET["date2"],3,2);
				 $yyT = substr($_GET["date2"],6,4);
			
			     $date2_final = ($yyT.'-'.$mmT.'-'.$ddT);

			
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
                    $wheresql_01 = " AND (MR.date_plan >= '".sql_esc($date1_final)."')"; }      
                                                
		 // 2. dateT
                if ($dateT == "0000-00-00" ){
                    $wheresql_02 = ""; }
                else {
                    $wheresql_02 = " AND (MR.date_plan <= '".sql_esc($date2_final)."')"; } 
					 	 
		 //3. Plan Category
                if ($plan_category == "NULL"){ 
                    $wheresql_03 = ""; }
                else {
                    $wheresql_03 = " AND MR.plan_category = '".sql_esc($plan_category)."'"; } 
					
          //4. Part No.
                if ($material_no == "NULL" ){
                    $wheresql_04 = ""; }
                else {
					$wheresql_04 = " AND MR.material_no = '".sql_esc($material_no)."'"; }
   
		 
		  //5. Shift
                if ($shift_ops == "NULL"){ 
                    $wheresql_05 = ""; }
                else {
					// $wheresql_06 = ""; }
					
                    $wheresql_05 = " AND ((MR.shift_pps1 = '".sql_esc($shift_ops)."') OR (MR.shift_pps2 = '".sql_esc($shift_ops)."')) "; }  		 				        
					
		
			
	$where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;		
	
	//********** END CONDITION **************
	
$queryu2 = "SELECT * FROM pps_detail AS MR WHERE MR.status_pps = '".sql_esc($rst_sta2["status_desc"])."'".$where_sql;
$rs2 = mysqli_query($dbc,$queryu2);   //run the query.
$db_rs2 = mysqli_fetch_array($rs2);


 ?>

<div class="page">
<br>
  <!--  <div class="page"> -->
 

      <form name="edt_sheet" id="edt_sheet" action="" method="post">
     <table class="table-bordered" style="width:1000px">
      <thead>
        <tr>
        <th>No.</th>
        <th>Back No.</th>
        <th>Part Number</th>
        <th>Part Name</th>
        <th>Planned Order No.</th>
        <th>Planned Date</th> 
        <th>Line</th>
        <th>Shift</th>
        <th>Plan Quantity</th>
        </tr>
      </thead>
      <tbody>
    <?php
   
   $counter = 1;
   $no = 1;
   $sta_out = "";
   
$query_display = "SELECT *, DATE_FORMAT(MR.date_plan,'%d-%m-%Y') as R FROM pps_detail AS MR WHERE MR.status_pps = '".sql_esc($rst_sta2["status_desc"])."' AND MR.id = '".sql_esc($row["id"])."' ".$where_sql." order by MR.plan_no ASC";
$result_display = mysqli_query($dbc,$query_display);   //run the query.
   
   while($row2 = mysqli_fetch_array($result_display))
   {
		
	//shift	
		if($row2["shift_pps1"] != "")
	{
		$sta = "D/S";
		
	}elseif($row2["shift_pps2"] != "")
	 {
		$sta = "N/S";
	 }else{
		 
		$sta = " ";
	 }
	
	 
	  //----model ---
  
 $query_Mod = new PreparedSql("SELECT * FROM work_center_detail WHERE id_work = ? AND status_wc = 'Y' ORDER BY id ASC", [$row2["work_center"]]);
 $result_Mod = db_query($dbc, $query_Mod);
 $row_Mod = mysqli_fetch_array($result_Mod);  
 
  if($row_Mod["wc_desc2"] == "")
  {
	  $model_nameA = $row_Mod["id_work"];
  }else{
	  
	 $model_nameA = $row_Mod["wc_desc2"]; 
  }
	
	//----table material info ----------
	
		$query_matA = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ? AND status_BOM = 'Y'", [$row2["material_no"]]);
	    $result_matA = db_query($dbc, $query_matA);
        $row_matA = mysqli_fetch_array($result_matA); 
	 	
	
	 
      ?>
       <tr>
        <td width="2%"><?php echo $no; ?></td>
        <td width="3%"><?php echo  html_esc($row2["back_no"]); ?></td>
        <td width="10%"><?php echo html_esc($row2["material_no"]); ?></td>
         <td width="10%"><?php echo html_esc($row_matA["material_desc"]); ?></td>
        <td width="8%"><font color="#0000CC"><?php echo html_esc($row2["plan_no"]); ?></font></td>
        <td width="5%" bgcolor="#E8F6F3">
        <input type="date" name="date_plan[]" class="input-xlarge datepicker" value="<?php echo html_esc($row2["date_plan"]); ?>" <?php if(isset($_POST["date_plan"][($row2["id"])])) { echo html_esc($_POST["date_plan"][($row2["id"])]); } ?>> </td>
        
    <!--    <td bgcolor="#E8F6F3" contenteditable="true" onBlur="saveToDatabase(this,'date_plan','<?php echo html_esc($row2["id"]); ?>')" onClick="showEdit(this);"><?php echo html_esc($row2["date_plan"]); ?></td> -->
       <td width="10%"><?php echo $model_nameA; ?></td>
       <td width="8%" bgcolor="#E8F6F3">
            <select name="shift_ops2[]" id="shift_ops2" class="form-control">
                  <option value="NULL" placeholder="Select Shift"> -- Select --</option>
                  <option value="D/S" <?php if($row2["shift_pps1"] == "D/S") { ?> selected="selected"<?php } ?>>D/S</option>
                  <option value="N/S" <?php if($row2["shift_pps2"] == "N/S") { ?> selected="selected"<?php } ?>>N/S</option>
                </select>
       </td>
    
     
        <td width="5%" bgcolor="#E8F6F3" contenteditable="true" onBlur="saveToDatabase(this,'qty_plan','<?php echo html_esc($row2["id"]); ?>')" onClick="showEdit(this);"><?php echo html_esc($row2["qty_plan"]); ?><?php //echo intval($row2["qty_plan"],0); ?></td>
      
       <input name="tid[]" type="hidden" value="<?php echo html_esc($row2["id"]); ?> ">   
       <input name="uid" type="hidden" value="<?php echo html_esc($row2["upload_id"]); ?> ">    
       <input name="date1" type="hidden" value="<?php echo $date1_final; ?> "> 
       <input name="date2" type="hidden" value="<?php echo $date2_final; ?> "> 
       <input name="plan_category" type="hidden" value="<?php echo html_esc($plan_category); ?>">  
       <input name="material_no" type="hidden" value="<?php echo html_esc($material_no); ?>"> 
       <input name="shift_ops" type="hidden" value="<?php echo html_esc($shift_ops); ?>"> 
      </tr> 
      <?php 
		  
		  $no++;
		  $counter++; // menambah counter
		  } 
		  
		  ?>
        </tbody>
      </table>
      
   
     <div class="modal-footer pull-left">
     <input type="submit" value="SAVE" name="edt_btn" class="btn btn-success btn-sm" onClick="return validateacv_s()">
     <input type="hidden" value="<?php echo html_esc($row["id"]); ?>"/>
              
             <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">BACK</button>
            </div> 
   
  </form>
                <!--  </div>--></div>
                  </div>
                  </div>
                  </div>
                  </div>
  <script>
/*validate achievement */
/*https://jsfiddle.net/Guruprasad_Rao/ssepbxfk/3/*/
function validateacv_s(){

	var eduInput = document.getElementsByName('shift_ops2[]');
	
	if (confirm('Are you sure want to perform this activity?.')){
	
		for (i=0; i<eduInput.length; i++)
		{
			if (eduInput[i].value == "")
			{
				alert('Please select achievement.');
				eduInput[i].focus();
				eduInput[i].style.borderColor = "#FF3300";			 
				return false;
			}
		}
	}
	else
	{
	 return false;
	}	
}
</script>
<script>
/*https://jsfiddle.net/Guruprasad_Rao/ssepbxfk/3/*/
$("select").on('change',function () {
	var rat_number = $(this).val();
	var price = $(this).find(':selected').data('price');
	
	/*var totalrat = rat_number * $(this).closest('tr').find('.input').data('value');
	var score = totalrat.toFixed(1);
		
	$(this).closest('tr').find('.rattip').val(rat_number);
	$(this).closest('tr').find('.priceip').val(price);
	$(this).closest('tr').find('.input').val(score);
	*/
});
</script>

             
</body>
</html>