<?php 
include 'include/config.php';
include 'include/config_mail.php';

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- Main CSS-->
   <link rel="stylesheet" type="text/css" href="css/main-idx.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title><?php echo $data_setup["title_desc"]; ?></title>
    <script language="javascript">

 defaultStatus = "PSS Online  <?php echo $data_setup['title_desc']; ?>"
 function show ( text )
 {
  window.status=text;
  return true;
 }
</script>
<?php
    function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes separately and for good reason.
        if (preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        elseif (preg_match('/Firefox/i',$u_agent))
        {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }
        elseif (preg_match('/Chrome/i',$u_agent))
        {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }
        elseif (preg_match('/Safari/i',$u_agent))
        {
            $bname = 'Apple Safari';
            $ub = "Safari";
        }
        elseif (preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Opera';
            $ub = "Opera";
        }
        elseif (preg_match('/Netscape/i',$u_agent))
        {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // Finally get the correct version number.
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // See how many we have.
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }

        // Check if we have a number.
        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }

    // Now try it.
    $ua=getBrowser();
    $yourbrowser= "Your browser: " . $ua['name'] . " " . $ua['version'];
	//. " on " .
                 // $ua['platform'] . " reports: <br >" . $ua['userAgent'];
  //  print_r($yourbrowser);
	
	
	if($ua['name'] == "Google Chrome")
	{
	//echo "url biasa"; 
	
	}elseif($ua['name'] == "Mozilla Firefox")
	{
	//echo "url mozilla";
	}
	elseif($ua['name'] == "Apple Safari")
	{
	//echo "url Safari";
	}

//---------------------------------------------------------------------

function encode($ss,$ntime){
    for($i=0;$i<$ntime;$i++){
        $ss=base64_encode($ss);
    }
return $ss;
}


function decode($ss,$ntime){
    for($i=0;$i<$ntime;$i++){
        $ss=base64_decode($ss);
    }
return $ss;
}

 $extension = explode ('.', $data_setup["logo_name"]);
 $filename = $data_setup["logo_comp"].'.'.$extension[1];

?>
  </head>
 <style>
  body {
 background-image: url("images/scan_indx1.jpg");
 background-color: #cccccc;
}

</style>
  <body>
   <!-- <section class="material-half-bg">
      <div class="cover"></div>
    </section>-->
    <section class="login-content">
      <div class="logo">
        <h1><img src="set_upload/<?php echo $filename;  ?>" width="400" height="70"/></h1>
      </div>
       <?php 

 //Checks if there is a login cookie
 if(isset($_COOKIE['ID_my_site']))

 //if there is, it logs you in and directes you to the members page
 { 
 
 
 //-----------------baru tambah
 
 //unset($_SESSION["username"]);  
		session_unset();
	
		
	 $past = time() - 100; 
   //this makes the time in the past to destroy the cookie 
     setcookie("ID_my_site", $past); 
     setcookie("Key_my_site", $past); 
	 setcookie("Lvl_my_site", $past); 
 

//------------------------barutambah 03/04/2014
 
 
 	$username = $_COOKIE['ID_my_site']; 
 	$pass = $_COOKIE['Key_my_site'];
	

	    $query_check = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."' AND status = 'AC' AND status_failed = 'N'";
 	 	$check = mysqli_query($dbc,$query_check);
		
 	while($info = mysqli_fetch_array($check)) 	
 		{
			
	$lvl_id = $info["level_id"];
	$lvl_id = $_COOKIE['Lvl_my_site'];
			
 		if ($pass != $info['password']) 
 			{
				
	   //-------------additional for checking failed login 5 times ---------------
		//-------------edit date 16/11/2017
		
		$check_log = "SELECT * FROM failed_login AS FL, user_detail AS UL WHERE FL.staff_ID = UL.staff_ID AND FL.username = '".sql_esc($_POST['username'])."' AND FL.ip_address = '".sql_esc($_SERVER["REMOTE_ADDR"])."'  AND FL.date_failed BETWEEN DATE_SUB( NOW() , INTERVAL 1 DAY ) AND NOW()";
		$rs_check_log = mysqli_query($dbc,$check_log);   
	    $num_check_log = mysqli_num_rows($rs_check_log);  
		$row = mysqli_fetch_array($rs_check_log);
		
		if($num_check_log < 5)
		{
			
				
		$query_log = "INSERT INTO failed_login(ip_address,date_failed,staff_ID,username) VALUES('".sql_esc($_SERVER["REMOTE_ADDR"])."',NOW(),'".sql_esc($info['staff_ID'])."','".sql_esc($_POST['username'])."')";
		$result_log = mysqli_query($dbc,$query_log) or die (mysqli_error());
		
		             
		             echo "<script>";
			         echo "alert('Incorrect password, please try again.');";
		             echo "window.location='index.php'";
					 echo "</script>";
			
		}else{
		
		//------update status_failed -------------------
		//------hantar e-mail kpd administrator---------
		
		//----------------------------------------------	
			       $query_update_fail = "UPDATE user_detail SET status_failed = 'Y', date_failed = NOW(), user_update = '".sql_esc($row["username"])."', date_update = NOW() where username='".sql_esc($_POST["username"])."'";
				  $result_update_fail = mysqli_query($dbc,$query_update_fail) or die (mysqli_error());
				  
				  if(mysqli_affected_rows() == 1) { //If it ran ok
				  
			
			$to = $row["user_email"]; 
			$subject = "PSS Online Reset Account password changed."; 
			$headers = "From: " .$data_setup["email_account"]."\r\n"; 
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			
			$mess2 ="<p>Dear Sir; </br>";
			
			$mess2 .="<p>Access to the web page was blocked. Details of the reset password changed as below;</p>";
			$mess = '<html><body>';
			$mess .= '<table cellpadding="5">';
			$mess .= "<tr><td><strong>Username :</strong> </td><td>" .$_POST["username"].  "</td></tr>";		
			$mess .= "<tr><td><strong>Staff ID :</strong> </td><td>" .$info['staff_ID']. "</td></tr>";
		    $mess .= "</table>";	
			$mess .= "<br>"; 
		
			$mess .="<p>Please use the following link to view:</br>";
			$mess .="<a href='".$data_setup["urls_system"]."'>" .$data_setup["urls_system"]."</a> </p>";
			$mess .= "<p><font color='black'>This is a system generated email. Please DO NOT reply. </font></p>";
			$mess .= "<p>&nbsp;</p>";
			$mess .= "</body></html>";
			
			mail($to, $subject, $mess2.$mess, $headers);
		
				  }
		
		
		             echo "<script>";
			         echo "alert('You have tried more than 5 invalid attempts.');";
		             echo "window.location='login_lock.php'";
					 echo "</script>";	
					
		
		}
				
				
 			 			}
 		else
 			{
			
 			if ($info['level_id']== 1)
		{
		// session 'index_admin.php
$username = $_POST["username"]; 
$password = $_POST["pass"];
$lvl_id = $info["level_id"];

session_start();
 $_SESSION["username"] = $username;
$_SESSION["password"] = $password;
$_SESSION["lvl_id"] = $lvl_id;

		//include 'index_admin.php'; 
		$url = "index_admin.php";
			if($ua['name'] == "Google Chrome")
	{
		//header ("Location: https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."YWRtaW4=/index_admin.php?lvl=$info[level_id]&&page=".encode($url,5));
		header ("Location: ".$data_setup["urls_system"]."/YWRtaW4=/index_admin.php?lvl=$info[level_id]&&page=".encode($url,5));		
		}elseif(($ua['name'] == "Apple Safari") || ($ua['name'] == "Mozilla Firefox"))
	{
		header ("Location: ".$data_setup["urls_system"]."/YWRtaW4=/index_admin.php?lvl=$info[level_id]&&page=".encode($url,5));	
	}	
		}// display admin screen
		
	elseif ($info['level_id']== 2)
		{
		// session 'index_super.php
$username = $_POST["username"]; 
$password = $_POST["pass"];
$lvl_id = $info["level_id"];
 
session_start();
 $_SESSION["username"] = $username;
$_SESSION["password"] = $password;
$_SESSION["lvl_id"] = $lvl_id;

 include 'backjob_clean.php';

		$url2 = "index_production.php";
		if($ua['name'] == "Google Chrome")
	{
		//header ("Location: https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."aac651b5c6ee/index_production.php?lvl=$info[level_id]&&page=".encode($url2,5));
		header ("Location: ".$data_setup["urls_system"]."/aac651b5c6ee/index_production.php?lvl=$info[level_id]&&page=".encode($url2,5));
	}elseif(($ua['name'] == "Apple Safari") || ($ua['name'] == "Mozilla Firefox"))
	{
	header ("Location: ".$data_setup["urls_system"]."/aac651b5c6ee/index_production.php?lvl=$info[level_id]&&page=".encode($url2,5));	
	}		
		}//display user screen
    
	elseif ($info['level_id']== 3)
		{
		// session 'index_super.php
$username = $_POST["username"]; 
$password = $_POST["pass"];
$lvl_id = $info["level_id"];

session_start();
$_SESSION["username"] = $username;
$_SESSION["password"] = $password;
$_SESSION["lvl_id"] = $lvl_id;

 include 'backjob_clean.php';
	
		$url8 = "index_ppc_rec.php";
		if($ua['name'] == "Google Chrome")
	{
		//header ("Location: https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."ppc3JlY/index_ppc_rec.php?lvl=$info[level_id]&&page=".encode($url8,5));
		header ("Location: ".$data_setup["urls_system"]."/ppc3JlY/index_ppc_rec.php?lvl=$info[level_id]&&page=".encode($url8,5));	
		}elseif(($ua['name'] == "Apple Safari") || ($ua['name'] == "Mozilla Firefox"))
	{
		header ("Location: ".$data_setup["urls_system"]."/ppc3JlY/index_ppc_rec.php?lvl=$info[level_id]&&page=".encode($url8,5));	
	}	
		}//display planning dept
	 
   elseif ($info['level_id']== 4)
		{
		
$username = $_POST["username"]; 
$password = $_POST["pass"];
$lvl_id = $info["level_id"];

session_start();
 $_SESSION["username"] = $username;
$_SESSION["password"] = $password;
$_SESSION["lvl_id"] = $lvl_id;
	
		$url10 = "index_qqc.php";
		if($ua['name'] == "Google Chrome")
	{
		//header ("Location: https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/cHBjqqc/index_qqc.php?lvl=$info[level_id]&&page=".encode($url10,5));
		header ("Location: ".$data_setup["urls_system"]."/cHBjqqc/index_qqc.php?lvl=$info[level_id]&&page=".encode($url10,5));
		}elseif(($ua['name'] == "Apple Safari") || ($ua['name'] == "Mozilla Firefox"))
	{
		header ("Location: ".$data_setup["urls_system"]."/cHBjqqc/index_qqc.php?lvl=$info[level_id]&&page=".encode($url10,5));	
	}	
		}//display QA/QC dept
		
		elseif ($info['level_id']== 5)
		{
		
$username = $_POST["username"]; 
$password = $_POST["pass"];
$lvl_id = $info["level_id"];

session_start();
 $_SESSION["username"] = $username;
$_SESSION["password"] = $password;
$_SESSION["lvl_id"] = $lvl_id;
	
		$url11 = "index_coO.php";
		
		if($ua['name'] == "Google Chrome")
	{
		//header ("Location: https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/aHJvCOo/index_coO.php?lvl=$info[level_id]&&page=".encode($url11,5));
		header ("Location: ".$data_setup["urls_system"]."/aHJvCOo/index_coO.php?lvl=$info[level_id]&&page=".encode($url11,5));	
		}elseif(($ua['name'] == "Apple Safari") || ($ua['name'] == "Mozilla Firefox"))
	{
		header ("Location: ".$data_setup["urls_system"]."/aHJvCOo/index_coO.php?lvl=$info[level_id]&&page=".encode($url11,5));	
	}	
		}//display COO
				
		else{ 
		
		 	if($ua['name'] == "Google Chrome")
	    {
		//header("Location: https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."blankPg.php"); 
		header ("Location: ".$data_setup["urls_system"]."/blankPg.php");
		
		}elseif(($ua['name'] == "Apple Safari") || ($ua['name'] == "Mozilla Firefox"))
	    {
		
	    header ("Location: ".$data_setup["urls_system"]."/blankPg.php");	
		
	     }	
		
 			}
 		}
}
 }

 //if the login form is submitted 
 if (isset($_POST['submit'])) { // if form has been submitted

 // makes sure they filled it in
 	if(!$_POST['username'] | !$_POST['pass']) {
	
	                 echo "<br><br>"; 
		             echo "<script>";
			         echo "alert('You did not fill in a required field.');";
		             echo "window.location='index.php'";
					 echo "</script>";
	
 		
 	}
 	// checks it against the database

 	
   $query_check = "SELECT * FROM user_detail WHERE username = '".sql_esc($_POST['username'])."' AND status = 'AC' AND status_failed = 'N'";
   $check = mysqli_query($dbc,$query_check);
 //Gives error if user dosen't exist
 $check2 = mysqli_num_rows($check);
 if ($check2 == 0) {

 
                     echo "<br><br>"; 
		             echo "<script>";
			         echo "alert('Access denied. Kindly contact System Administrator.');";
		             echo "window.location='index.php'";
					 echo "</script>";
 
 
 		//die('That user does not exist in our database. Please contact IAV Administrator to Register.');
 				}
 while($info = mysqli_fetch_array($check)) 	
 {
    $_POST['pass'] = stripslashes($_POST['pass']);
 	$info['password'] = stripslashes($info['password']);
 	$_POST['pass'] = md5($_POST['pass']);

 //gives error if the password is wrong
 	if ($_POST['pass'] != $info['password']) {
	
	
		
		//-------------additional for checking failed login 5 times ---------------
		//-------------edit date 16/11/2017
		
		$check_log = "SELECT * FROM failed_login AS FL, user_detail AS UL WHERE FL.staff_ID = UL.staff_ID AND FL.username = '".sql_esc($_POST['username'])."' AND FL.ip_address = '".sql_esc($_SERVER["REMOTE_ADDR"])."'  AND FL.date_failed BETWEEN DATE_SUB( NOW() , INTERVAL 1 DAY ) AND NOW()";
		$rs_check_log = mysqli_query($dbc,$check_log);   
	    $num_check_log = mysqli_num_rows($rs_check_log);  
		$row = mysqli_fetch_array($rs_check_log);
		
		if($num_check_log < 5)
		{
			
				
		$query_log = "INSERT INTO failed_login(ip_address,date_failed,staff_ID,username) VALUES('".sql_esc($_SERVER["REMOTE_ADDR"])."',NOW(),'".sql_esc($info['staff_ID'])."','".sql_esc($_POST['username'])."')";
		$result_log = mysqli_query($dbc,$query_log) or die (mysqli_error());
		
		             
		             echo "<script>";
			         echo "alert('Incorrect password, please try again.');";
		             echo "window.location='index.php'";
					 echo "</script>";
			
		}else{
		
		//------update status_failed -------------------
		//------hantar e-mail kpd administrator---------
		
		//----------------------------------------------	
			       $query_update_fail = "UPDATE user_detail SET status_failed = 'Y', date_failed = NOW(), user_update = '".sql_esc($row["username"])."', date_update = NOW() where username='".sql_esc($_POST["username"])."'";
				  $result_update_fail = mysqli_query($dbc,$query_update_fail) or die (mysqli_error());
				  
				  if(mysqli_affected_rows() == 1) { //If it ran ok
				  
			
			$to = $row["user_email"]; 
			$subject = "PSS Online Reset Account password changed."; 
			$headers = "From: " .$data_setup["email_account"]."\r\n"; 
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			
			$mess2 ="<p>Dear Sir; </br>";
			
			$mess2 .="<p>Access to the web page was blocked. Details of the reset password changed as below; </p>";
			$mess = '<html><body>';
			$mess .= '<table cellpadding="5">';
			$mess .= "<tr><td><strong>Username :</strong> </td><td>" .$_POST["username"].  "</td></tr>";		
			$mess .= "<tr><td><strong>Staff ID :</strong> </td><td>" .$info['staff_ID']. "</td></tr>";
		    $mess .= "</table>";	
			$mess .= "<br>"; 
		
			$mess .="<p>Please use the following link to view:</br>";
			$mess .="<a href='".$data_setup["urls_system"]."'>" .$data_setup["urls_system"]."</a> </p>";
			$mess .= "<p><font color='black'>This is a system generated email. Please DO NOT reply. </font></p>";
			$mess .= "<p>&nbsp;</p>";
			$mess .= "</body></html>";
			
			mail($to, $subject, $mess2.$mess, $headers);
		
				  }
		
		             echo "<script>";
			         echo "alert('You have tried more than 5 invalid attempts.');";
		             echo "window.location='login_lock.php'";
					 echo "</script>";	
					
		
		}
		

	//--------------------end checking login failed 5 time-------------------------------------------------                 
 		
 	}
	else 
 { 
 
 // if login is ok then we add a cookie 
 	 $_POST['username'] = stripslashes($_POST['username']); 
 	 $hour = time() + 3600; 
 setcookie('ID_my_site', $_POST['username'], $hour); 
 setcookie('Key_my_site', $_POST['pass'], $hour);	 
 
 //then redirect them to the members area 
if ($info['level_id']== 1)
		{

// session 'index_admin.php
$username = $_POST["username"]; 
$password = $_POST["pass"];
$lvl_id = $info["level_id"];

session_start();
$_SESSION["username"] = $username;
$_SESSION["password"] = $password;
$_SESSION["lvl_id"] = $lvl_id;
		//include 'index_admin.php'; 
		$url = 'index_admin.php'; 
		if($ua['name'] == "Google Chrome")
	{
		//header ("Location: https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."YWRtaW4=/index_admin.php?lvl=$info[level_id]&&page=".encode($url,5));
		header ("Location: ".$data_setup["urls_system"]."/YWRtaW4=/index_admin.php?lvl=$info[level_id]&&page=".encode($url,5));	
	}elseif(($ua['name'] == "Apple Safari") || ($ua['name'] == "Mozilla Firefox"))
	{
		header ("Location: ".$data_setup["urls_system"]."/YWRtaW4=/index_admin.php?lvl=$info[level_id]&&page=".encode($url,5));	
	}	
		
		}// display admin screen
	elseif ($info['level_id']== 2)
		{
		// session 'index_super.php
$username = $_POST["username"]; 
$password = $_POST["pass"];
$lvl_id = $info["level_id"];

session_start();
$_SESSION["username"] = $username;
$_SESSION["password"] = $password;
$_SESSION["lvl_id"] = $lvl_id;
		
		include 'backjob_clean.php';
		
		$url2 = "index_production.php";
		if($ua['name'] == "Google Chrome")
	{
		//header ("Location: https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."aac651b5c6ee/index_production.php?lvl=$info[level_id]&&page=".encode($url2,5));
		header ("Location: ".$data_setup["urls_system"]."/aac651b5c6ee/index_production.php?lvl=$info[level_id]&&page=".encode($url2,5));
		}elseif(($ua['name'] == "Apple Safari") || ($ua['name'] == "Mozilla Firefox"))
	{
		header ("Location: ".$data_setup["urls_system"]."/aac651b5c6ee/index_production.php?lvl=$info[level_id]&&page=".encode($url2,5));	
	}	
		
		}//display user screen
		
		elseif ($info['level_id']== 3)
		{
		// session 'index_super.php
$username = $_POST["username"]; 
$password = $_POST["pass"];
$lvl_id = $info["level_id"];

session_start();
$_SESSION["username"] = $username;
$_SESSION["password"] = $password;
$_SESSION["lvl_id"] = $lvl_id;

 include 'backjob_clean.php';
	
		$url8 = "index_ppc_rec.php";
		if($ua['name'] == "Google Chrome")
	{
		//header ("Location: https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."ppc3JlY/index_ppc_rec.php?lvl=$info[level_id]&&page=".encode($url8,5));
		header ("Location: ".$data_setup["urls_system"]."/ppc3JlY/index_ppc_rec.php?lvl=$info[level_id]&&page=".encode($url8,5));
		}elseif(($ua['name'] == "Apple Safari") || ($ua['name'] == "Mozilla Firefox"))
	{
		header ("Location: ".$data_setup["urls_system"]."/ppc3JlY/index_ppc_rec.php?lvl=$info[level_id]&&page=".encode($url8,5));	
	}	
		}//display planning dept
   
   elseif ($info['level_id']== 4)
		{
		
$username = $_POST["username"]; 
$password = $_POST["pass"];
$lvl_id = $info["level_id"];

session_start();
$_SESSION["username"] = $username;
$_SESSION["password"] = $password;
$_SESSION["lvl_id"] = $lvl_id;
	
		$url10 = "index_qqc.php";
		if($ua['name'] == "Google Chrome")
	{
		//header ("Location: https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."cHBjqqc/index_qqc.php?lvl=$info[level_id]&&page=".encode($url10,5));
		header ("Location: ".$data_setup["urls_system"]."/cHBjqqc/index_qqc.php?lvl=$info[level_id]&&page=".encode($url10,5));	

		}elseif(($ua['name'] == "Apple Safari") || ($ua['name'] == "Mozilla Firefox"))
	{
		header ("Location: ".$data_setup["urls_system"]."/cHBjqqc/index_qqc.php?lvl=$info[level_id]&&page=".encode($url10,5));	
	}	
		}//display QA/QC dept
		
			elseif ($info['level_id']== 5)
		{
		
$username = $_POST["username"]; 
$password = $_POST["pass"];
$lvl_id = $info["level_id"];

session_start();
 $_SESSION["username"] = $username;
$_SESSION["password"] = $password;
$_SESSION["lvl_id"] = $lvl_id;
	
		$url11 = "index_coO.php";
		
		if($ua['name'] == "Google Chrome")
	{
		//header ("Location: https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."aHJvCOo/index_coO.php?lvl=$info[level_id]&&page=".encode($url11,5));
		header ("Location: ".$data_setup["urls_system"]."/aHJvCOo/index_coO.php?lvl=$info[level_id]&&page=".encode($url11,5));	

		}elseif(($ua['name'] == "Apple Safari") || ($ua['name'] == "Mozilla Firefox"))
	{
		header ("Location: ".$data_setup["urls_system"]."/aHJvCOo/index_coO.php?lvl=$info[level_id]&&page=".encode($url11,5));	
	}	
		}//display COO
	
 } 
 } 
 } 
 else 
{	 
 
 // if they are not logged in 
 ?>
      <div class="login-box">      
         <form action="" method="post" id="loginform"  class="login-form" >
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
          <div class="form-group">
            <label class="control-label">USERNAME</label>
            <input class="form-control"  name="username" type="text" placeholder="Username" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" name="pass" type="password" placeholder="Password">
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
               <!-- <label>
                  <input type="checkbox"><span class="label-text">Stay Signed in</span>
                </label>-->
              </div>
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
            </div>
          </div>
          <div class="form-group btn-container"><input name="submit" type="submit" value="LOGIN" class="btn btn-primary btn-block"/>
         <!--   <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>-->
          </div>
        </form>
         <form id="recoverform" action="forgot_password.php"  class="forget-form"  data-remote="true" method="post">
       <!-- <form class="forget-form" action="docs/index.html">-->
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
          <div class="form-group">
            <label class="control-label">USERNAME</label>
             <input type="text" name="user_name" size="20"  id="user_name" value="<?php if(isset($_POST['user_name'])) echo $_POST['user_name']; ?>" class="form-control">
         
          </div>
           <div class="form-group">
            <label class="control-label">EMAIL</label>
             <input type="text" name="email"  size="50" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" class="form-control" >
         
          </div>
             
          
          <div class="form-group btn-container"><input name="submit2" type="submit" class="btn btn-primary btn-block" value="RESET" >
          <!--  <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>-->
          </div>
         
           
          <div class="form-group mt-3">
           <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
          </div>
        </form>
      </div>
         <?php 
 } 

 ?>  
      
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
  </body>
</html>