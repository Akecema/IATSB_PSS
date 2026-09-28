<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));


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


//----disposal ppc/rcv
$query_setup5 = "SELECT * FROM sys_setup_disposal WHERE id = '4' AND status_acc = 'Y'";
$rs_setup5 = mysqli_query($dbc,$query_setup5);   //run the query.
$num_setup5 = mysqli_num_rows($rs_setup5);   //how many material are there?
$data_setup5 = mysqli_fetch_array($rs_setup5);

//----disposal QC

$query_setup6 = "SELECT * FROM sys_setup_disposal WHERE id = '5' AND status_acc = 'Y'";
$rs_setup6 = mysqli_query($dbc,$query_setup6);   //run the query.
$num_setup6 = mysqli_num_rows($rs_setup6);   //how many material are there?
$data_setup6 = mysqli_fetch_array($rs_setup6);

//----------------------------------------------------

    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
    $res = mysqli_fetch_array($result2);
	
	
//CR status (New)

$sta = "SELECT * from request_status WHERE status_id = '1' ";
$sta_res = mysqli_query($dbc,$sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2' ";
$sta_res2 = mysqli_query($dbc,$sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);	

//CR status (Approved)
$sta3 = "SELECT * from request_status WHERE status_id = '3'";
$sta_res3 = mysqli_query($dbc,$sta3);
$rst_sta3 = mysqli_fetch_array($sta_res3);

//CR status (Cancel)
$sta4 = "SELECT * from request_status WHERE status_id = '4' ";
$sta_res4 = mysqli_query($dbc,$sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13' ";
$sta_res13 = mysqli_query($dbc,$sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);


//CR status (Pending Approve)
$sta15 = "SELECT * from request_status WHERE status_id = '15' ";
$sta_res15 = mysqli_query($dbc,$sta15);
$rst_sta15 = mysqli_fetch_array($sta_res15);

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

//CR status (Pending Approve STM)
$sta32 = "SELECT * from request_status WHERE status_id = '32'";
$sta_res32 = mysqli_query($dbc,$sta32);
$rst_sta32 = mysqli_fetch_array($sta_res32);

//CR status (Pending Approve ASSY)
$sta34 = "SELECT * from request_status WHERE status_id = '34'";
$sta_res34 = mysqli_query($dbc,$sta34);
$rst_sta34 = mysqli_fetch_array($sta_res34);


// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

//server setting for email
//include "inc-server-email-settings.php";

//email notification subject
//include "inc-notification.php";

if(isset($_POST['e_tcid']))
{
	  
    $trc_id = $_POST["e_tcid"]; 
    $st = count($trc_id);
	

	    
		 for($i=0; $i<$st; $i++)
	{		

		//update table pps_detail
		
	$query_releas_v = "UPDATE disposal_detail_prd_all SET status_disposal = '".sql_esc($rst_sta3["status_desc"])."' WHERE id = '".sql_esc($trc_id[$i])."'";
    $result_releas_v = mysqli_query($dbc,$query_releas_v);
	
	
	    $query_infoN = "SELECT * FROM disposal_detail_prd_all WHERE id = '".sql_esc($trc_id[$i])."' AND status_disposal = '".sql_esc($rst_sta3["status_desc"])."'";
		$result_infoN = mysqli_query($dbc,$query_infoN);
		$row_infoN = mysqli_fetch_array($result_infoN);
		  
		
		
		/*$qty_updateY = "UPDATE disposal_detail_prd_all SET status_disposal = '".$rst_sta29["status_desc"]."', status_approved5 = '".$rst_sta3["status_desc"]."', approved_by5 = '".$username."', date_approved5 = NOW() WHERE doc_dis = '".$row_infoN["doc_dis"]."'";
        $result_qty_updateY = mysqli_query($dbc,$qty_updateY);  */
		
		
		
		
		
		//-----update table-------------------------
     $sta_outB = substr($row_infoN["doc_dis"],4,3);
	
   
   if($sta_outB == "311")
	  {
	
	$query_cancelDis1B = "UPDATE disposal_detail_prd_ng SET status_disposal = '".sql_esc($rst_sta3["status_desc"])."', status_approved2 = '".sql_esc($rst_sta3["status_desc"])."', approved_by2 = '".sql_esc($username)."', date_approved2 = NOW() WHERE doc_dis = '".sql_esc($row_infoN["doc_dis"])."'";
	$result_cancelDis1B = mysqli_query($dbc,$query_cancelDis1B); 
	
		  
	  }elseif($sta_outB == "321")
	  {
	
	$query_cancelDis2B = "UPDATE disposal_detail_prd_pending_confirm SET status_disposal = '".sql_esc($rst_sta3["status_desc"])."', status_approved2 = '".sql_esc($rst_sta3["status_desc"])."', approved_by2 = '".sql_esc($username)."', date_approved2 = NOW() WHERE doc_dis = '".sql_esc($row_infoN["doc_dis"])."'";
	$result_cancelDis2B = mysqli_query($dbc,$query_cancelDis2B); 
		  
	  }elseif($sta_outB == "331")
	  {
	
	$query_cancelDis3B = "UPDATE disposal_detail_prd_pending_confirm_hwork SET status_disposal = '".sql_esc($rst_sta3["status_desc"])."', status_approved2 = '".sql_esc($rst_sta3["status_desc"])."', approved_by2 = '".sql_esc($username)."', date_approved2 = NOW() WHERE doc_dis = '".sql_esc($row_infoN["doc_dis"])."'";
	$result_cancelDis3B = mysqli_query($dbc,$query_cancelDis3B); 
		  
	  }elseif($sta_outB == "341")
	  {
	
	$query_cancelDis4B = "UPDATE disposal_detail_prd_pending_confirm_rework SET status_disposal = '".sql_esc($rst_sta3["status_desc"])."', status_approved2 = '".sql_esc($rst_sta3["status_desc"])."', approved_by2 = '".sql_esc($username)."', date_approved2 = NOW() WHERE doc_dis = '".sql_esc($row_infoN["doc_dis"])."'";
	$result_cancelDis4B = mysqli_query($dbc,$query_cancelDis4B); 
		  
	  }elseif($sta_outB == "351")
	  {
    $query_cancelDisB = "UPDATE prd_creject_detail SET status_dis = '".sql_esc($rst_sta3["status_desc"])."', status_approved2 = '".sql_esc($rst_sta3["status_desc"])."', hod_approved2 = '".sql_esc($username)."', date_approved2 = NOW() WHERE doc_dis = '".sql_esc($row_infoN["doc_dis"])."'";
	$result_cancelDisB = mysqli_query($dbc,$query_cancelDisB);    
	
			  
	  }elseif($sta_outB == "361")
	  {
		  
	    if($row_infoN["status_part"] == "PR")
		{	 
		 
    $query_cancelDis6BB = "UPDATE prd_creject_detail SET status_dis = '".sql_esc($rst_sta3["status_desc"])."', status_approved2 = '".sql_esc($rst_sta3["status_desc"])."', hod_approved2 = '".sql_esc($username)."', date_approved2 = NOW() WHERE doc_dis = '".sql_esc($row_infoN["doc_dis"])."'";
	$result_cancelDis6BB = mysqli_query($dbc,$query_cancelDis6BB);  
	  
		}elseif($row_infoN["status_part"] == "QC")
		{
			
			if($row_infoN["reject_source"] == "QC")
			{
				
				
    $query_LevelUAA = "UPDATE gra_disposal_qc_detail SET status_approved2 = '".sql_esc($rst_sta3["status_desc"])."', hod_approved2 = '".sql_esc($username)."', date_approved2 = NOW(), status_dis = '".sql_esc($rst_sta3["status_desc"])."' WHERE doc_dis = '".sql_esc($row_infoN["doc_dis"])."'";
	$result_LevelUAA = mysqli_query($dbc,$query_LevelUAA);				
				
				
			}elseif($row_infoN["reject_source"] == "CREJ")
				
	$query_cancelDis6BC = "UPDATE prd_creject_detail_qc SET status_dis = '".$rst_sta3["status_desc"]."', status_approved2 = '".$rst_sta3["status_desc"]."', hod_approved2 = '".$username."', date_approved2 = NOW() WHERE doc_dis = '".$row_infoN["doc_dis"]."'";
	$result_cancelDis6BC = mysqli_query($dbc,$query_cancelDis6BC); 			
				
				
			}else{    }
			
				  

	  }elseif($sta_outB == "371")
	  {
/*    $query_cancelDis7B = "UPDATE prd_creject_detail SET status_dis = '".$rst_sta3["status_desc"]."', status_approved5 = '".$rst_sta3["status_desc"]."', hod_approved5 = '".$username."', date_approved5 = NOW() WHERE doc_dis = '".$row_infoN["doc_dis"]."'";
	$result_cancelDis7B = mysqli_query($dbc,$query_cancelDis7B);    
*/	
			  
	  }
	  
	  
	  
	  else{
		  
		  
	  }
	  
	  
	  
	
	  
	  
	  
	   //---------email account Approval Head Assbly ------
	  /*  $query_coo = "SELECT * FROM function_acc_detail WHERE f_dis_approval_prd = 'Y'";
		$result_coo = mysqli_query($dbc,$query_coo);
	    
		while($row_coo = mysqli_fetch_array($result_coo))
		{
			
			
		//-------profile Exec QC ---------
		 $query_mel = "SELECT * FROM user_detail WHERE staff_ID = '".$row_coo["staff_ID"]."'";
         $result_mel = mysqli_query($dbc,$query_mel);
         $res_mel = mysqli_fetch_array($result_mel);
		
	   
	    //--------------email notify to COO ----------------------------

	      //Send an email, if desired
		 
	      $Uname = $row_coo['user_fullname'];
	      $Wdesc = $data_setup['tajuk_sys'];
		  $Uurl = $data_setup['urls_system']; 
		  $Wdesc2 =  $res["user_fullname"];
		  $email = $res_mel["user_email"];
		  $disposal_doc = $row_infoN["doc_dis"];
		  $post_dt1 = $fmt_curr_date;
		  
	
			//--------------------------------------------------------
				//body message
				$message = file_get_contents('disposal-notify-apprv0-Aassy.html'); 
				
				//name
				$message = str_replace('%uname%', $Uname, $message); 
				//web desc
				$message = str_replace('%wdesc%', $Wdesc, $message); 
				//requestor
				$message = str_replace('%wdesc2%', $Wdesc2, $message); 
				//disposal doc no
				$message = str_replace('%tdisposal_doc%', $disposal_doc, $message); 
				//posting date
				$message = str_replace('%tpost_date%', $post_dt1, $message); 
				//url
				$message = str_replace('%uurl%', $Uurl, $message); 
				
		
					
				//PHPMailer Object
				$mail = new PHPMailer(); //Argument true in constructor enables exceptions
			
				//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
				$mail->isSMTP();
				$mail->Host       = $data_setup['smtp_account'];              		// Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = $data_setup['email_account'];         		// SMTP username
				$mail->Password   = $data_setup['passwd'];                // SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
				$mail->Port       = $data_setup['port_no'];

				$mail->From = $data_setup['email_account'];
				$mail->FromName = $data_setup['tajuk_sys'];
				
				//To address and name
				$mail->addAddress($email, $res_mel["user_email"]);
				//$mail->addAddress($email, 'shahrazi@ingresscorp.com.my');
				
				//Send HTML or Plain Text email
				$mail->isHTML(true);
			    //$mail->Subject = "Disposal Approval Request : Disposal No. ";
				$mail->Subject = "Disposal Approval Request : Disposal No. $disposal_doc";
				$mail->MsgHTML($message);
				
				
				$mail->CharSet="utf-8";
				
				//send the mail
				$mail->send();
			
	  
		} */// end while looop
	      
	    //---------------------------email----------------------------------
	  
		  
			}// end for loop
			

							
			 echo "<script>";
			 echo "alert('Disposal has been approved.');";
			 echo "window.location='detail_aprv_bf_disposal-prd-assy.php'";
			 echo "</script>"; 
			 exit(); //quit the script
		
			
   }// end if

?>
 