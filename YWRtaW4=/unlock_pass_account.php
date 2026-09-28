
<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//------------------------------end function --------------------------------
if(isset($_POST['submit']))
{
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// create a function for escaping the data.
/*function escape_data($data) {
global $dbc;   // need the connection.
if (ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysqli_real_escape_string($data,$dbc);
	}   // end function.
$message = NULL; // create an empty new variable.*/
	
$user_no = $_POST['user_no'];
$user_id = $_POST['user_id'];
$user_fullname = $_POST['user_fullname'];
$status_failed = $_POST['status_failed'];


// check for a status account
if (empty($_POST["status_failed"]) || ($_POST["status_failed"] == ""))
{ $status_failed = FALSE;
  $message.= '<p> You are required to select STATUS ACCOUNT!</p>';
  }
  else
  { $status_failed = addslashes($_POST["status_failed"]);
  }

 
  $user_id = addslashes($_POST["user_id"]);
  $user_fullname = addslashes($_POST["user_fullname"]);
   
 if($status_failed)
{  

		  	  $query_search = new PreparedSql("SELECT * FROM user_detail WHERE user_no = ?", [$user_no]);
              $result_search = db_query($dbc, $query_search);   //run the query.
              $num_search = mysqli_num_rows($result_search);   //how many suppliers are there?
			  $row_search = mysqli_fetch_array($result_search);
			  
			  if($num_search == 1) {
			  //echo $num_search; 
			    
				// make the update query
				
				$query_upd = "UPDATE user_detail SET status_failed = 'N', date_update= NOW(), user_update ='".sql_esc($username)."', date_failed = '' WHERE user_no = '".sql_esc($user_no)."'";
				$result_upd = mysqli_query($dbc,$query_upd); 
			
			  if(mysqli_affected_rows($dbc) == 1) { //If it ran ok
			 
				     $Uname = $row_search['user_fullname'];
			         $Wdesc = $data_setup['tajuk_sys'];
			         $Uurl = $data_setup['urls_system'];
					 
					 $Wdesc2 =  $row_search["user_email"];
			         $email = $row_search["user_email"];
					 
					 
					 //--------------------------------------------------------
				//body message
				$message = file_get_contents('unlock-login.html'); 
				
				//name
				$message = str_replace('%uname%', $Uname, $message); 
				//web desc
				$message = str_replace('%wdesc%', $Wdesc, $message); 
				//web desc
				$message = str_replace('%wdesc2%', $Wdesc2, $message); 
				
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
				$mail->addAddress($email, $row_search["user_email"]);
				
				//Send HTML or Plain Text email
				$mail->isHTML(true);
			
				$mail->Subject = "PSS Online Activate Account";
				$mail->MsgHTML($message);
				
				
				$mail->CharSet="utf-8";
				
				//send the mail
				$mail->send();
				  
			
			
				//-----------------delete clear table failed_login-----------
			$query_failed_del = "DELETE FROM failed_login WHERE staff_ID = '".sql_esc($row_search["staff_ID"])."'";
		    $result_failed_del = mysqli_query($dbc,$query_failed_del); 			
			
			  }
			
			  }
			  
			echo "<script>";
			echo "alert('Account is successfully activate');";
		    echo "window.location='display_user.php'";
			echo "</script>";
			exit(); //quit the script
				   

} else { echo 'Cannot update record'; 
}
//print the message if there is one.
	  

//---------------------------function message------------------------------ 
if (isset($message))
{ echo '<div class="msg msg-error"><font color="red" class ="error_entry">', $message, '</font></div>';
}
} 
 ?>
  <div class="modal fade" id="myNoteLock<?php echo html_esc($user_no); ?><?php echo html_esc($row["staff_ID"]); ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Unlock Account</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Account Profile</strong>
       </div>
    <form name="form1" method="post" action="" >
    <table class="table table-bordered">
               <tr>
                 <td>Staff ID </td>
                 <td>:</td>
                 <td>
                   <input name="user_id" type="text" id="user_id" size="20" maxlength="20" readonly value="<?php echo html_esc($row["staff_ID"]); ?>" class="form-control" />
                 </td>
               </tr>
                 <tr>
                 <td height="25">Name </td>
                 <td height="25">:</td>
                 <td height="25">
         <input name="user_fullname" type="text" class="form-control" id="user_fullname" size="55" maxlength="100" readonly value="<?php echo html_esc($row["user_fullname"]); ?>" />
                </td>
               </tr>
               <?php

	     $sts = "LOCK";
       $sts2 = "UNLOCK";
		
      ?>
               <tr>
                 <td>Status Account *</td>
                 <td>:</td>
                 <td><select name="status_failed" class="form-control">
    <option value="Y" <?php if($row["status_failed"] == "Y") { ?> selected="selected"<?php } ?>><?php  echo $sts; ?></option>
    <option value="N" <?php if($row["status_failed"] == "N") { ?> selected="selected"<?php } ?>><?php  echo $sts2; ?></option>
	 
	      </select>
                  </td>
               </tr>
                <tr>
                 <td>Date Lock Access</td>
                 <td>:</td>
                 <td><?php  echo html_esc($row["date_failed"]); ?></td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
              
               <tr>
                 <td>* Compulsory field</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
            </table>
       
                         
       </div> <!-- card -->
       </div><!-- /# card -->
       <br />
                     
              <div class="modal-footer">   
               <input name="submit" type="submit"  id="submit" value="UPDATE" class="btn btn-info">  
               <button type="button" class="btn btn-success" data-dismiss="modal">CLOSE</button>
               <input type="hidden" name="user_no" id="user_no" value="<?php echo html_esc($row["user_no"]); ?>">  
             
            <!--  <input type="submit" name="submit2" value="Close" class="btn btn-success" />-->
             </div>  
        </form>      
      
                  </div></div>
                  </div>
                  </div>
                  </div>
                  </div>
