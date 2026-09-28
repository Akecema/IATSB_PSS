<?php
session_start();
$username = $_SESSION["username"];
include '../include/config.php';

include '../include/config_mail.php';
$Cdate = date ("l, j F Y ");

ini_set("display_errors",0);
require_once "excel_reader2.php";

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------		

//CR status (New)

$sta = "SELECT * from request_status WHERE status_id = '1' ";
$sta_res = mysqli_query($dbc,$sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2' ";
$sta_res2 = mysqli_query($dbc,$sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);	

//CR status (Cancel)
$sta4 = "SELECT * from request_status WHERE status_id = '4' ";
$sta_res4 = mysqli_query($dbc,$sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);	

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
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
    <script language="javascript">
	$('.datepicker').pickadate({
	weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
	showMonthsShort: true
	})
	</script>
  </head>
<body>
<!-- refresh page every 5 second auto.... -->
<!-- <body onload="JavaScript:timedRefresh(5000);">  -->

<?php


set_time_limit(0);


//-----------------upload file into table pps_upload------------------------//
	
	foreach (glob("upload_pps/*.xls") as $filename) 
{ 
   // $date1 = $_GET["date1"];
	$plant_code = $_GET["plant_code"];
	$upload_id = $_GET["upload_id"];
	
	$file = $filename;
	
	//echo $file."<br>"; 

    $data = new Spreadsheet_Excel_Reader($file);

             //--------check 1 days upload once----------------------------------------//
			//-------- 2nd upload will be remove/cancel the previous data-------------//
			/*
			$query_select_detail = "SELECT * FROM pps_detail WHERE (status_pps = '".$rst_sta["status_desc"]."' OR status_pps = '".$rst_sta2["status_desc"]."') AND date_plan = '".$date1."' AND plan_category = '".$plan_category."'";
			$result_select_detail = mysql_query($query_select_detail);
            $row_select_detail = mysql_fetch_array($result_select_detail);
			
			if($row_select_detail > 0)
			{
				
            $query_upd_sts = "UPDATE pps_detail SET status_pps = '".$rst_sta4["status_desc"]."' WHERE (status_pps = '".$rst_sta["status_desc"]."' OR status_pps = '".$rst_sta2["status_desc"]."') AND date_plan = '".$date1."' AND plan_category = '".$plan_category."'";
			$result_upd_sts = mysql_query($query_upd_sts);
				
				
			}*/   // end if $row_select_detail
			
			//------------------end 2nd upload checking---------------------------
			
//echo "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";

$html="<table border='1'>";
//for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.

for($i=0;$i<= 1;$i++) // Loop to get all sheets in a file.
{	

	if(count($data->sheets[$i]["cells"])>0) // checking sheet not empty
	{
		//echo "Sheet $i:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i]["cells"])."<br />";
		
		
		for($j=4;$j<=count($data->sheets[$i]["cells"]);$j++) // loop used to get each row of the sheet
		{ 
		
			$html.="<tr>";
			for($k=1;$k<=count($data->sheets[$i]["cells"][$j]);$k++) // This loop is created to get data in a table format.
			{
				$html.="<td>";
				$html.=$data->sheets[$i]["cells"][$j][$k];
				$html.="</td>";
				
				
			    $month_plan =  mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][1][2]);
			
			}
			
			$model_code = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][1]);
			$shift_pps1 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][6]);
			$shift_pps2 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][8]);
			$material_no = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][2]);
			$material_desc = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][3]);
			$work_center = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][4]);
			$seq_pps1 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][5]);
			$seq_pps2 = mysqli_real_escape_string($dbc,$data->sheets[$i]["cells"][$j][7]);
			//echo $data->sheets[$i]["cells"][$j][2];
				
				
			$html.="</tr>";
			

			
				if($material_no != " " )
					{
	
								
			$query_1 = "INSERT INTO pps_upload(ref_id,plan_no,upload_id,model_code,month_plan,material_no,qty_plan,qty_actual,status_pps,comp_code,work_center,shift_pps1,shift_pps2,date_plan,user_upload,date_upload,user_create,date_create,user_update,date_update,plan_category,seq_pps1,seq_pps2,plant_code,year_plan) VALUES('','','".sql_esc($upload_id)."','".sql_esc($model_code)."','".sql_esc($month_plan)."','".sql_esc($material_no)."','','','New','".sql_esc($data_setup["comp_code"])."','".sql_esc($work_center)."','".sql_esc($shift_pps1)."','".sql_esc($shift_pps2)."','".sql_esc($month_plan)."','".sql_esc($username)."',NOW(),'".sql_esc($username)."',NOW(),'','','','".sql_esc($seq_pps1)."','".sql_esc($seq_pps2)."','".sql_esc($plant_code)."','".sql_esc($month_plan)."')";
		$result_1 = mysqli_query($dbc,$query_1);
		
		
		 $query_update2_V = "UPDATE ftp_pps SET date_plan = '".sql_esc($month_plan)."' WHERE id_file = '".sql_esc($upload_id)."'";
		 $result_update2_V = mysqli_query($dbc,$query_update2_V) or die (mysqli_error());   
			
			
					}// end if
			
		}
		
		
	}

}

$html.="</table>";
//echo $html;

			
//	------ move file to another folder ----------------------------------
			$handle2 = $file;
			$destination = "upload_pps_update/".$file;
			$data = file_get_contents($handle2);

			$handle2 = fopen($destination, "w");
			fwrite($handle2, $data);
			fclose($handle2);
			fclose($handle);
			unlink($file);
			

 //echo "<br />Data Inserted in dababase";

//--------------------------------------------------------------

} // end of foreach filename
			
	        $query_db_pps = "SELECT * FROM pps_upload WHERE status_pps = 'New'";
			$result_db_pps = mysqli_query($dbc,$query_db_pps);
             
			 while($row_db_pps = mysqli_fetch_array($result_db_pps))
			{
			
			$mon_plan = substr($row_db_pps["month_plan"],5,2);		
			$tahun_plan = substr($row_db_pps["month_plan"],0,4);		
			
			 //---- check factory from work center -------// 
			$query_convert = "SELECT * FROM work_center_detail as SR WHERE SR.id_work = '".sql_esc($row_db_pps["work_center"])."'";
			$result_convert = mysqli_query($dbc,$query_convert); 
			$row_convert = mysqli_fetch_array($result_convert);
			
			
			 //----- check material existing in table material ------//
			 
			 $query_chk_mat = "SELECT * FROM table_material WHERE material_no = '".sql_esc($row_db_pps["material_no"])."' AND bom_status = 'Y'";
			 $result_chk_mat = mysqli_query($dbc,$query_chk_mat); 
			 $row_chk_mat = mysqli_fetch_array($result_chk_mat);
			 
			   
			   if($row_chk_mat > 0){
				   
				   
				    //---------check shift --------------//
						
				if($row_db_pps["shift_pps1"] != "") 
				{
				
			$query_shift_day1 = "INSERT INTO pps_detail(id, ref_id, plan_no, upload_id, model_code, month_plan, material_no, qty_plan, qty_actual, status_pps, comp_code, work_center, shift_pps1, shift_pps2, date_plan, status, user_upload, date_upload, user_create, date_create, user_update, date_update, user_posting, date_posting, user_closed, date_closed, plan_category, id_factory_pps, rev_pps, seq_pps, man_hours, work_hours,plant_code,year_plan) VALUES('','".sql_esc($row_db_pps["ref_id"])."','','".sql_esc($row_db_pps["upload_id"])."','".sql_esc($row_db_pps["model_code"])."','".sql_esc($mon_plan)."','".sql_esc($row_db_pps["material_no"])."','".sql_esc($row_db_pps["shift_pps1"])."','','New','".sql_esc($row_db_pps["comp_code"])."','".sql_esc($row_db_pps["work_center"])."','D/S','','".sql_esc($row_db_pps["date_plan"])."','Y','".sql_esc($row_db_pps["user_upload"])."','".sql_esc($row_db_pps["date_upload"])."','".sql_esc($row_db_pps["user_create"])."','".sql_esc($row_db_pps["date_create"])."','','','','','','','".sql_esc($row_db_pps["plan_category"])."','".sql_esc($row_convert["id_factory"])."','','".sql_esc($row_db_pps["seq_pps1"])."','','','".sql_esc($row_db_pps["plant_code"])."','".sql_esc($tahun_plan)."')";
		   $result_shift_day1 = mysqli_query($dbc,$query_shift_day1);	
				}
		      
			  if($row_db_pps["shift_pps2"] != "")
				{
				$query_shift_day2 = "INSERT INTO pps_detail(id, ref_id, plan_no, upload_id, model_code, month_plan, material_no, qty_plan, qty_actual, status_pps, comp_code, work_center, shift_pps1, shift_pps2, date_plan, status, user_upload, date_upload, user_create, date_create, user_update, date_update, user_posting, date_posting, user_closed, date_closed, plan_category, id_factory_pps, rev_pps, seq_pps, man_hours, work_hours,plant_code) VALUES('','".sql_esc($row_db_pps["ref_id"])."','','".sql_esc($row_db_pps["upload_id"])."','".sql_esc($row_db_pps["model_code"])."','".sql_esc($mon_plan)."','".sql_esc($row_db_pps["material_no"])."','".sql_esc($row_db_pps["shift_pps2"])."','','New','".sql_esc($row_db_pps["comp_code"])."','".sql_esc($row_db_pps["work_center"])."','','N/S','".sql_esc($row_db_pps["date_plan"])."','Y','".sql_esc($row_db_pps["user_upload"])."','".sql_esc($row_db_pps["date_upload"])."','".sql_esc($row_db_pps["user_create"])."','".sql_esc($row_db_pps["date_create"])."','','','','','','','".sql_esc($row_db_pps["plan_category"])."','".sql_esc($row_convert["id_factory"])."','','".sql_esc($row_db_pps["seq_pps2"])."','','','".sql_esc($row_db_pps["plant_code"])."','".sql_esc($tahun_plan)."')";
			$result_shift_day2 = mysqli_query($dbc,$query_shift_day2);		
					
				}
				   
	       
			}else{
				
		
			 $query_mail = "SELECT * FROM login_detail WHERE level_id = '1' AND status = 'AC' ";
			 $result_mail = mysqli_query($dbc,$query_mail);
			 
			 while($row_mail = mysqli_fetch_array($result_mail))
			{
			//Send an email, if desired
				
			$to = $row_mail["user_email"]; 
			$subject = "PSS Online - Material Master Maintenance."; 
			$headers = "From: " .$data_setup["email_account"]."\r\n"; 
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			
			$mess2 ="<p>Dear Admin; </br></p>";
			$mess2 .="<p>The material are not exist(s) in PSS Material Master as below; </p>";
			$mess = '<html><body>';
			$mess .= '<table cellpadding="5">';
			$mess .= "<tr><td><strong>Material No.:</strong> </td><td>" .$row_db_pps["material_no"]. "</td></tr>";		
			$mess .= "</table>";	
		
			$mess .="<p>Please use the following link to view:</br>";
			$mess .="<a href='".$data_setup["urls_system"]."'>" .$data_setup["urls_system"]."</a> </p>";
			$mess .= "<p><font color='black'>This is a system generated email. Please DO NOT reply. </font></p>";
			$mess .= "<p>&nbsp;</p>";
			$mess .= "</body></html>";
			
			mail($to, $subject, $mess2.$mess, $headers);	   
				  
			} // end while loop mail	
		
			
		  //-------------------------------delete table ftp_pps-------------------------------------
		    $query_hsekeeping2 = "DELETE FROM ftp_pps WHERE upload_id = '".sql_esc($upload_id)."'";
			$result_hsekeeping2 =  mysqli_query($dbc,$query_hsekeeping2);
	  
		  //------------------------end delete upload table ftp_pps---------------------------------	
		  
		   //-------------------------------delete table pps_detail-------------------------------------
		    $query_hsekeeping3 = "DELETE FROM pps_detail WHERE upload_id = '".sql_esc($upload_id)."'";
			$result_hsekeeping3 =  mysqli_query($dbc,$query_hsekeeping3);
	  
		  //------------------------end delete upload table ftp_pps---------------------------------	
			
			//-------------------------------delete table pps_upload-------------------------------------
		    $query_hsekeeping = "DELETE FROM pps_upload WHERE upload_id = '".sql_esc($upload_id)."'";
			$result_hsekeeping =  mysqli_query($dbc,$query_hsekeeping);
	  
		  //------------------------end delete upload table pps-upload---------------------------------	
		  
				
			   }
				
				
		
	
			}// end while loop pps upload
			
			
			
			//----checking have data in pps upload -> proceed to next stage
			$query_db_pps_nxt = "SELECT * FROM pps_upload WHERE status_pps = 'New' and upload_id = '".sql_esc($upload_id)."'";
			$result_db_pps_nxt = mysqli_query($dbc,$query_db_pps_nxt);
			$row_db_pps_nxt = mysqli_fetch_array($result_db_pps_nxt);
	       
		   
		   if($row_db_pps_nxt > 0)
		   {
			   
		  //-------------------------------delete table pps_upload-------------------------------------
		    $query_hsekeeping_f = "DELETE FROM pps_upload WHERE upload_id = '".sql_esc($upload_id)."'";
			$result_hsekeeping_f =  mysqli_query($dbc,$query_hsekeeping_f);
	  
		  //------------------------end delete upload table pps-upload---------------------------------	   
		   
		   //--------------end transaction upload into table pps_upload------------------------------------//
			
			echo "<script>";
		    echo "window.location='detail_pps_sheet_printing.php?upload_id=$upload_id'";
			echo "</script>";	
			exit;
			
		   }else{
			   
				
			echo "<script>";
		    echo "alert('Error : Please verify the Material No. and update BOM.');";
			echo "window.close();";
			echo "parent.location.reload();";
			echo "</script>";	
			exit;        
			   
			   
		   }
	
	
		
?>
</body>
</html>