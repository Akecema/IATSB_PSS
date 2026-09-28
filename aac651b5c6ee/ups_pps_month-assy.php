<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));

$masa = (date("H:m:s"));

set_time_limit(0);

//-----date----
$today = getdate();
$hours = $today['hours']; 
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year']; 


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
	
$url = "ups_pps_month-assy.php"; 

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

//CR status (Return GRA)
$sta26 = "SELECT * from request_status WHERE status_id = '26'";
$sta_res26 = mysqli_query($dbc,$sta26);
$rst_sta26 = mysqli_fetch_array($sta_res26);

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);


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
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
    <script>
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('txt').innerHTML =
  h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}
</script>
 <style>
input[value="+ Add Item"]{
  display:none;
}


</style>
  </head>
  
  <body class="app sidebar-mini" onload="startTime()">
    <!-- Navbar-->
      <?php   include "top_modal_menu.php";   ?>
    
    
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php   include "left_prod_menu.php";   ?>
  
    <main class="app-content">
    
     <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Planning</h1>
          <p>Create Planning</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"> Planning</li>
          <li class="breadcrumb-item"><a href="ups_pps_month-assy.php">Create Planning</a></li>
        </ul>
      </div> 
           
      
       <?php
 $message_pps = "";
 $message = NULL;
 $message_shift = "";
 
  //---shift detail ------
		
		  $query_shtA = "SELECT * FROM shift_detail WHERE id_shift = '1'";
		  $result_shtA = mysqli_query($dbc,$query_shtA);
		  $data_shtA = mysqli_fetch_array($result_shtA); 
		  
		 //----shift posting ----
		 
		 if(($masa >= $data_shtA["time_start"]) && ($masa <= $data_shtA["time_end"]))
		 {
			 
		 $shif_pA = "D/S"; 
		 
		 }else
		 {
		 
		 $shif_pA = "N/S"; 
		
		 }	 
 
 
 
 
 
 
    $query_id = "SELECT * FROM run_count_itsb WHERE uid = '137'";
	$result_id = mysqli_query($dbc,$query_id);
	
	
	if ($result_id) 
{
	$nrows = mysqli_num_rows($result_id);
	$row_id = mysqli_fetch_array($result_id);
	
	$dht = 000; 
	//$dht_OK = "211";
	$dg2 = 0;

  	if($row_id["count_max"] <= 0)
  	{ 
   
    	$lastID = ($row_id["count_max"] + 1);
    	$dg = ($dht + ($lastID));
   }
   else
   {
      $lastID = ($row_id["count_max"] + 1);
      $dg =  $lastID;
	
    }
	
	$number = $dg; // Length of running no
    $number = sprintf('%05d', $number);  
	
	
	  
	
	} // end if $result_id	
 
 
 
 
 
 
if(isset($_POST['submit3'])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.


// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

$message = NULL; // create an empty new variable.

   
   $pps_ref = $_POST["pps_ref"];
   $user_no = $_POST["user_no"];
  
  
// check for a pps ref (scan from pps)
if(empty($_POST["pps_ref"]))
{ 
           $pps_ref = FALSE;
            echo "<script>";
			echo "alert('Error! Please scan Kanban');";
			echo "</script>";
	
  }
 

if($pps_ref) //everything ok
{  

//checking delete space semasa scanning

$pps_ref2 = trim($pps_ref);
			
 
//split dulu pps ref kpd part no, model, back no, part name, quantity, kanban no.
$str = $pps_ref2;


list($part1, $part2, $part3, $part4, $part5, $part6) = (explode('|', $str, 6));


/*echo "no 1 ".$part1;
echo "<br>";
echo "no 2 ".$part2;
echo "<br>";
echo "no 3 ".$part3;
echo "<br>";
echo "no 4 ".$part4;
echo "<br>";
echo "no 5 ".$part5;
echo "<br>";
echo "no 6 ".$part6;
echo "<br>"; */


	//-------delete space -------
	
	$str_part1 = trim($part1,"  ");
    $str_part4 = trim($part4,"  ");
	$str_part2 = trim($part2,"  ");
	$str_part3 = trim($part3,"  ");
	$str_part5 = trim($part5,"  ");
	$str_part6 = trim($part6,"  ");
	
	
	
	
	//----checking 
	
	        $query_chk_attach4 = "SELECT * FROM sc_kanban_assy WHERE scan_doc = '".sql_esc($number)."' AND material_no = '".sql_esc($str_part1)."'";
            $result_chk_attach4 = mysqli_query($dbc,$query_chk_attach4);   //run the query.
            $data_chk_attach4 = mysqli_fetch_array($result_chk_attach4);   //how many records are there?   
			 
			 if($data_chk_attach4 >= 1 )
			 {
			   
				echo "<script>";
                echo "alert('Material already exist.Please scan again.');";
                echo "window.location='ups_pps_month-assy.php?scan_doc=$number'";
                echo "</script>";
				exit(); //quit the script
			              		   
			   }
			   
			             		   
			  
	

	//-----get material detail ------
			$query_mat_info = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($str_part1)."' AND status_BOM = 'Y'";
			$result_mat_info = mysqli_query($dbc,$query_mat_info);
			$data_mat_info = mysqli_fetch_array($result_mat_info);
	
	
	//----insert table sc_kanban_assy			 
				 
	$query_ins_scan = "INSERT INTO sc_kanban_assy(id,scan_doc,plan_no,scan_kanban,material_no,material_desc,model_code,back_no,qty_plan,qty_actual,kanban_no,status_pps,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,plant_code,year_plan,work_hours,date_kanban) VALUES ('','".sql_esc($number)."','','".sql_esc($pps_ref2)."','".sql_esc($str_part1)."','".sql_esc($str_part4)."','".sql_esc($str_part2)."','".sql_esc($str_part3)."','".sql_esc($str_part5)."','','".sql_esc($str_part6)."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($data_mat_info["prod_line"])."','','',NOW(),'".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','".sql_esc($data_mat_info["category_mat"])."','','3100','".sql_esc($year)."','',NOW())";
	$result_ins_scan = mysqli_query($dbc,$query_ins_scan);
    //$data_ins_scan = mysqli_fetch_array($result_ins_scan);			 
				 
				 
	//$uid2 = mysqli_insert_id($dbc);  //upload ID	
		 
	

           if($result_ins_scan)
             {
			 
			 $query_sql = "SELECT * FROM sc_kanban_assy WHERE id = '".mysqli_insert_id($dbc)."'";
			 $result_sql = mysqli_query($dbc,$query_sql);
			 $data_sql = mysqli_fetch_array($result_sql);
			 
			  echo "<script>";
			  echo "window.location='ups_pps_month-assy.php?scan_doc=$number'";
			  echo "</script>";
			  exit(); //quit the script
			  
             }
             else 
			 {
              echo "<script>";
			  echo "alert('Planning PSS is failed. ');";
			  echo "</script>";
			  exit(); //quit the script	 
				 
             // mysqli_close($dbc); //close db
             }   




	 
}//print the message if there is one.
	  
/*if (isset($message))
{ echo '<div class="msg msg-error"><font color="red" class ="error_entry">', $message, '</font></div>';
}
*/
}



//-------------------------------------------------------------------------------------------------------------------------
if(isset($_POST["submit4"]))  
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

	   $scan_doc = $number;  
	   $id = $_POST["id"];  
	   $plant_code2 = $_POST["plant_code2"];
	   $qty_actual = $_POST["qty_actual"];
	   $shift_ops = $_POST["shift_ops"];
	   $mat_no = $_POST["mat_no"];
	   
	 

  if($id)
  {
	  
	  
	        $query_chk_attach7 = "SELECT * FROM sc_kanban_assy WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
            $result_chk_attach7 = mysqli_query($dbc,$query_chk_attach7);   //run the query.
            
			
			while($data_chk_attach7 = mysqli_fetch_array($result_chk_attach7))  //how many records are there?  
			{
			  
			
			
		   $query_mat = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($data_chk_attach7["material_no"])."' AND status_BOM = 'Y'";
	       $rs_mat  = mysqli_query($dbc,$query_mat);
	       $data_mat  = mysqli_fetch_array($rs_mat);
			 
			  if(($data_chk_attach7["material_no"]) != ($data_mat["material_no"]))
		    {
			   
				echo "<script>";
                echo "alert('Error! Transaction failed. Material does not exist.');";
                echo "window.location='ups_pps_month-assy.php?scan_doc=$number'";
                echo "</script>";
				exit(); //quit the script
			              		   
			   }
   
			}
		
		$amountA = "";
		$amountB = "";
		$amountC = "";
		$amountD = "";
		$nw_time = "";

	    $how_many = count($id); 
		
		$id = $_POST["id"]; 
		$qty_actual = $_POST["qty_actual"];
		$mat_no = $_POST["mat_no"];
		$shift_ops = $_POST["shift_ops"];
						 

       foreach($_POST["id"] as $j=>$i) {
	
		$amountA .= (($_POST["shift_ops"][$i]).';');
		$amountB .= (($_POST["id"][$i]).';');
		$amountC .= (($_POST["qty_actual"][$i]).';');
		$amountD .= (($_POST["mat_no"][$i]).';');

		
		//-----checking barcode GR Tag
		
		$stringA = explode(";",($amountA));	
		$stringB = explode(";",($amountB));	
		$stringC = explode(";",($amountC));	
		$stringD = explode(";",($amountD));	
		
		 if(($_POST["id"][$i]) == "")
	      { 
		     $id = FALSE;
			 $message_gr = '<span class="badge badge-pill badge-danger">Please enter GR Doc. No.!</span>';
				
		   }//end if
		   
		   
		
	   
		   
		   
        } //foreach
		
	  
		 			
	 for ($i=0; $i<$how_many; $i++) { 
	 		   
	//-------------------generate gra QC doc no.---------------
	
	 if($_POST["plant_code2"] == '3100')
	{
	
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '4'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
	
	}elseif($_POST["plant_code2"] == '3101')
	{
		
	 $query_id2 = "SELECT * FROM run_count_itsb WHERE uid = '59'";
	 $result_id2 = mysqli_query($dbc,$query_id2);
		
	}
		
	
	if ($result_id2) 
{
	$nrows2 = mysqli_num_rows($result_id2);
	$row_id2 = mysqli_fetch_array($result_id2);
	
	$dht2 = 0000000; 
	$dht_OK2 = "0";
	$dg2 = 0;
	
	
  	if($row_id2["count_max"] <= 0)
  	{ 
   
    	$lastID2 = ($row_id2["count_max"] + 1);
    	$dg2 = ($dht2 + ($lastID2));
   }
   else
   {
      $lastID2 = ($row_id2["count_max"] + 1);
      $dg2 =  $lastID2;
	
    }
	$number2 = $dg2; // Length of running no
    $number2 = sprintf('%07d', $number2);  
	
    $ref5 = (($row_id2["start_ref"]).$number2);
	  
	
	} // end if $result_id2
	
	    
    
			    //----checking 
	
	        $query_chk_plan = "SELECT * FROM pps_detail WHERE material_no = '".sql_esc($stringD[$i])."' AND date_plan = '".sql_esc($currentdate)."' AND status_pps != '".sql_esc($rst_sta4["status_desc"])."' AND status_pps != '".sql_esc($rst_sta13["status_desc"])."'  ";
            $result_chk_plan = mysqli_query($dbc,$query_chk_plan);   //run the query.
      
			   while($data_chk_plan = mysqli_fetch_array($result_chk_plan)){
				// your code here
				
				  if($data_chk_plan > 1)
				 {
					
					  if($data_chk_plan["shift_pps1"] == $stringA[$i])
					  {
						 //echo "ada wujud";
							echo "<script>";
							echo "alert('Planning already exist.');";
							echo "window.location='ups_pps_month-assy.php?scan_doc=$number'";
							echo "</script>";
							exit(); //quit the script  
						  
					  }elseif($data_chk_plan["shift_pps2"] == $stringA[$i])
					  {
					        echo "<script>";
							echo "alert('Planning already exist.');";
							echo "window.location='ups_pps_month-assy.php?scan_doc=$number'";
							echo "</script>";
							exit(); //quit the script  
					  
					  
					  }else{
 					  
					  }
				
					 
				    }//end  if($data_chk_plan > 1)
			   
			   
			   
			   
			}  // while loop
	
	
	
		
	
			
		$query_update_scan2 = "UPDATE sc_kanban_assy SET plan_no = '".sql_esc($ref5)."', status_pps = '".sql_esc($rst_sta7["status_desc"])."', qty_actual = '".sql_esc($stringC[$i])."', user_update = '".sql_esc($username)."', date_update = NOW(), shift_pps1 = '".sql_esc($stringA[$i])."' WHERE id = '".sql_esc($stringB[$i])."'";
	    $rst_update_scan2 = mysqli_query($dbc,$query_update_scan2);
		
			
		  //update count_max----------------------------------------
	 
	  if($_POST["plant_code2"] == '3100')
	{
  
       $query_max_a = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '4'";
	   $result_max_a = mysqli_query($dbc,$query_max_a);
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '137'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);

	}elseif($_POST["plant_code2"] == '3101')
	{
	   $query_max_b = "UPDATE run_count_itsb SET count_max = '".sql_esc($number2)."', date_updated = NOW() WHERE uid = '59'";
	   $result_max_b = mysqli_query($dbc,$query_max_b);
	   
	   $query_max_a1 = "UPDATE run_count_itsb SET count_max = '".sql_esc($number)."', date_updated = NOW() WHERE uid = '137'";
	   $result_max_a1 = mysqli_query($dbc,$query_max_a1);
	}

		
		
		
		
				
		 $query_dtl_chk2A = "SELECT * FROM sc_kanban_assy WHERE status_pps = '".sql_esc($rst_sta7["status_desc"])."' AND id = '".sql_esc($stringB[$i])."'";
		 $result_dtl_chk2A = mysqli_query($dbc,$query_dtl_chk2A);
		 $row_infoA = mysqli_fetch_array($result_dtl_chk2A); 
		 
		 //-------------get material detail ----------
		  $query_mate = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($row_infoA["material_no"])."'";
		  $result_mate = mysqli_query($dbc,$query_mate);
		  $data_mate = mysqli_fetch_array($result_mate);
		  
		  //---------detail material_type_tbl (material_type) ----
		 
		  $query_mtypeA = "SELECT * FROM material_type_tbl WHERE id = '".sql_esc($data_mate["mat_type"])."'";
		  $result_mtypeA = mysqli_query($dbc,$query_mtypeA) or die (mysqli_error());
		  $d_mtypeA = mysqli_fetch_array($result_mtypeA);
		  
		  
		  //---------detail model_detail_tbl(model_code) ---
		  
		  $query_mcodeA = "SELECT * FROM model_detail_tbl WHERE id_model = '".sql_esc($data_mate["model_code"])."'";
		  $result_mcodeA = mysqli_query($dbc,$query_mcodeA) or die (mysqli_error());
		  $d_mcodeA = mysqli_fetch_array($result_mcodeA);
		 
		    $query_db_pps = "SELECT * FROM sc_kanban_assy WHERE id = '".sql_esc($stringB[$i])."'";
			$result_db_pps = mysqli_query($dbc,$query_db_pps);
            $row_db_pps = mysqli_fetch_array($result_db_pps);
			
			
		//----date posting split -------
		
		         $d_plan = substr($fmt_curr_date,0,2);
				 $m_plan = substr($fmt_curr_date,3,2);
				 $y_plan = substr($fmt_curr_date,6,4);	
				 
		//----time---$row_infoA
		
		$hrs = substr($row_infoA["date_update"],11,2);
		$mits = substr($row_infoA["date_update"],14,2);
		$secs = substr($row_infoA["date_update"],17,2);	
		
		$nw_time = 	($hrs.':'.$mits.':'.$secs);
		
		
		
		
			 //---shift detail ------
	
	  $query_sht = "SELECT * FROM shift_detail WHERE id_shift = '1'";
	  $result_sht = mysqli_query($dbc,$query_sht);
	  $data_sht = mysqli_fetch_array($result_sht); 
	  
	
	 
	 if($row_db_pps["shift_pps1"] == "N/S")
	 {
		 
     $shif_p2 = "N/S"; 
	 $shif_p1 = ""; 
	 
	 }else
	 {
	 
	 $shif_p1 = "D/S";
	 $shif_p2 = "";  
	
	 }
		
	
		 

		//---------insert data at table pps_detail
		
		  $query_shift_day1 = "INSERT INTO pps_detail(id,ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,status,user_upload,date_upload,user_create,date_create,user_update,date_update,user_posting,date_posting,user_closed,date_closed,plan_category,id_factory_pps,rev_pps,seq_pps,man_hours,work_hours,plant_code,year_plan,material_type,sloc,remark_closed,type_closed,remark_closed_plan,back_no,kanban_no) VALUES('','".sql_esc($row_db_pps["id"])."','".sql_esc($ref5)."','".sql_esc($row_db_pps["scan_doc"])."','".sql_esc($row_db_pps["model_code"])."','".sql_esc($m_plan)."','".sql_esc($row_db_pps["material_no"])."','".sql_esc($stringC[$i])."','".sql_esc($stringC[$i])."','".sql_esc($rst_sta2["status_desc"])."','3100','".sql_esc($row_db_pps["work_center"])."','".sql_esc($shif_p1)."','".sql_esc($shif_p2)."','".sql_esc($row_db_pps["date_plan"])."','Y','".sql_esc($row_db_pps["user_upload"])."','".sql_esc($row_db_pps["date_upload"])."','".sql_esc($row_db_pps["user_create"])."','".sql_esc($row_db_pps["date_create"])."','','','".sql_esc($username)."',NOW(),'','','".sql_esc($row_db_pps["plan_category"])."','1','','".sql_esc($row_db_pps["seq_pps1"])."','','".sql_esc($nw_time)."','".sql_esc($row_db_pps["plant_code"])."','".sql_esc($row_db_pps["year_plan"])."','".sql_esc($d_mtypeA["mat_type_id"])."','','','','','".sql_esc($row_db_pps["back_no"])."','".sql_esc($row_db_pps["kanban_no"])."')";
		   $result_shift_day1 = mysqli_query($dbc,$query_shift_day1);	
		   
		   
		$query_update_scan2A = "UPDATE sc_kanban_assy SET shift_pps1 = '".sql_esc($shif_p1)."', shift_pps2 = '".sql_esc($shif_p2)."'  WHERE id = '".sql_esc($stringB[$i])."'";
	    $rst_update_scan2A = mysqli_query($dbc,$query_update_scan2A);
		
		   
	  
		

	}//end for loop
      
   
    echo '<script type="text/javascript">';
	echo "alert('Planning successfully uploaded.');";
	echo "window.location='ups_pps_month-assy.php';"; 
	echo "</script>";
	exit(); //quit the script
   
	
	
	 }//end ifelse "OK"
	  else{
		   
		echo '<script type="text/javascript">';
		echo "alert('Error! Transaction failed. Please enter field correctly.');";
		echo "window.location='ups_pps_month-assy.php';"; 
		echo "</script>";
		exit(); //quit the script
		   
		   
	   }
			//}

}// end submit 4



if(isset($_POST["submit5"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

//-----------delete all data current screen-------------

   $query_delete_scan = "DELETE FROM sc_kanban_assy WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."'";
   $result_delete_scan = mysqli_query($dbc,$query_delete_scan);

//---------end delete ----------------------------------


}




?>
      
      
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Create Planning</h3>
            <div class="tile-body">
            <div class="col-form-label">
            <span class="text-info">&nbsp;<?php echo date("D M d, Y");   ?>&nbsp; <div id="txt"></div></span>
            
             </div>
             <!-- <form name="form1" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">-->
               <form name="form1" method="post" action="" class="form-horizontal">
                <div class="form-group row col-md-10">
                  <label class="control-label col-md-3">Scan Kanban<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-10">
                  <input name="pps_ref" type="text" id="pps_ref" maxlength="200" value="<?php if(isset($_POST['pps_ref'])) echo $_POST['pps_ref']; ?>" class="form-control" autofocus/>
               
                    </div> <div class="col-md-2"><img src="../images/barcode_scan.jpeg" width="40" height="40" /></div>
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>Eg: Part Number|Model|Back No.|Part Name|Quantity|Kanban No.</small>
   
                    </div>
              <div class="form-group row">
                  <input name="user_no" type="hidden" value="<?php echo $res["user_no"]; ?>" />
                  <label class="control-label col-md-3"><font color="#FF0000"><b>* Compulsory field</b></font></label>
                    <div class="col-md-8">
                  &nbsp;
                </div>
              </div>
              
                <div class="form-group col-md-8 align-self-end">
                
               
               <input name="submit3" type="submit" id="submit" value="+ Add Item" class="btn btn-info btn-sm">
                             </div>
              </form>
              
              
               <?php

     $no = 1;
	 $sloc_to = "";
	 $k = 1;
	 $w = 1;


   
             $query_sql2 = "SELECT *,DATE_FORMAT(date_plan,'%d-%m-%Y') as R FROM sc_kanban_assy WHERE scan_doc = '".sql_esc($number)."' AND user_create = '".sql_esc($username)."' AND status_pps = 'New'";
			 $result_sql2 = mysqli_query($dbc,$query_sql2);
			 $num_1 = mysqli_num_rows($result_sql2);   //how many material are there?
    
		  
		 if ($num_1 > 0) {
			 
			 echo '<div align="center">There are currently  '. $num_1.' record(s).</div>'; 
	   
        
    	?>

                     
           <form action="ups_pps_month-assy.php?scan_doc=<?php echo (base64_encode($number)); ?>" method="post" name="myform" id="myform">
           
                
           
                <table class="table table-hover table-bordered" id="example">
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Item.</th> 
                    <th>Back No.</th>
                    <th>Part Number</th>
                    <th>Quantity</th>
                    <th>Shift&nbsp;&nbsp;&nbsp;</th>
                    <th>Kanban No.</th>
                </tr>
              </thead>    
              <tbody>
           <?php 

   $counter = 1;
   $no4 = 1;
   $sta_out = "";
   
   while($row = mysqli_fetch_array($result_sql2))
   {
	   
	    $no4 = sprintf('%04d',$no4);
		
		 //---get info sc_gra_return_rcv	
		$query_sc_asal = "SELECT * FROM sc_kanban_assy WHERE id = '".sql_esc($row["id"])."'";
		$rs_sc_asal  = mysqli_query($dbc,$query_sc_asal);
	    $data_sc_asal  = mysqli_fetch_array($rs_sc_asal);
		
		//----table material info --------------
		
		$query_chk_mat = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($row["material_no"])."' AND  status_BOM = 'Y'";
	    $rs_chk_mat  = mysqli_query($dbc,$query_chk_mat);
	    $data_chk_mat  = mysqli_fetch_array($rs_chk_mat);
	  
	
	     if(($data_chk_mat["material_no"]) != ($row["material_no"]))
		 {
		
		$mesej = '<span class="badge badge-pill badge-danger">Part number does not exist</span>';  
		 }else{
			 
		$mesej = "";	 	 
			 
		 }
		 
		 
		 
	
		
		
      ?>
                <tr>
                <td width="50"><a href="delete_kanban_item.php?scan_doc=<?php echo $row["scan_doc"]; ?>&&p_id=<?php echo $row["id"]; ?>" onclick="return confirm('Are you sure you want to delete?')"><img src="../images/delete.png" alt="Remove Item"></a></td>
                <td width="50"><?php echo $no4; ?><input name="id[<?php echo $row["id"]; ?>]" type="hidden" value="<?php echo $row["id"]; ?>">
                <input name="item_no[<?php echo $row["id"]; ?>]" type="hidden" value="<?php echo $no4; ?>"></td>
                <td width="80"><?php echo $row["back_no"]; ?></td>
                <td width="250"><?php echo $row["material_no"]; ?>&nbsp;&nbsp;<?php echo $mesej;  ?></td>
                <td width="150"> <input name="qty_actual[<?php echo $row["id"]; ?>]" type="text" id="qty_actual" value="<?php  if(isset($_POST['qty_actual'])){ echo $_POST["qty_actual"][($row["id"])]; }else{ echo intval($row["qty_plan"]); } ?>" class="form-control form-control-sm" required/> </td>
                <td width="150"><select name="shift_ops[<?php echo $row["id"]; ?>]" id="shift_ops" class="form-control form-control-sm" required/>
                  <option value="" placeholder="Select Shift"> -- Select Shift --</option>
                  <option value="D/S" <?php if($shif_pA == "D/S"){  ?> selected<?php }  ?>>D/S - Day Shift</option>
                  <option value="N/S" <?php if($shif_pA == "N/S"){  ?> selected<?php }  ?>>N/S - Night Shift</option>
                </select> <?php echo $message_shift; ?>   </td>
                <td width="150"><?php echo $row["kanban_no"]; ?>
                <input name="plant_code2" type="hidden" value="<?php echo $row["plant_code"]; ?>">
                <input name="mat_no[<?php echo $row["id"]; ?>]" type="hidden" value="<?php echo $row["material_no"]; ?>"></td>
                </td>
                </tr>
                 
          <?php 
		  
		  $no4++;
		  $counter++; // menambah counter
		  $w ++; 
          $k ++; 
		  
		 

		  } 
		  
       mysqli_free_result($result_sql2); 		  
		  ?>
</tbody>
</table> <!--
        <div class="form-actions">-->
               <input name="submit4" type="submit" id="submit4" value="SUBMIT" class="btn btn-success btn-sm" onclick="return confirm('Create Planning for Production?');" >
               <input name="submit5" type="submit" id="submit5" class="btn btn-warning btn-sm" value="CLEAR">
          <!-- </div>-->
<?php  

 }else{
 
?> 

<?php   } ?>


</form>
              
              
              
              
              
              
              
              
              
              
              
              
              
              
            </div>
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
        <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
  <!--  <script type="text/javascript">$('#example').DataTable();</script>-->
     <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
    <!--<script type="text/javascript" src="js/plugins/select2.min.js"></script>-->
    <script type="text/javascript" src="js/plugins/dropzone.js"></script>
     <script language="javascript">
		  $(document).ready(function() {
				$('#example').DataTable( {
					"scrollX": true,
					"lengthMenu": [[ -1], [ "All"]]
				} );
		} );
	  </script>
   <script>
$('.btn_release').on('click',function(){
    $('.modal-body').load('dash_brdprod.php',function(){
        $('#myModal').modal({show:true});
    });
});
</script>
  </body>
</html>