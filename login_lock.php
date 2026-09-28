<?php 
include 'include/config.php';


//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------


?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
<script language="javascript">

 defaultStatus = "PSS Online  <?php echo html_esc($data_setup['title_desc']); ?>"
 function show ( text )
 {
  window.status=text;
  return true;
 }
</script>
 </head> 
 
 <body class="app sidebar-mini">

<!--<meta http-equiv="refresh" content="50;URL=index.php"> -->

<section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="lockscreen-content">
      <div class="logo"> </div>
           
      <div class="lock-box"><img src="images/lock2.png"  class="rounded-circle user-image">   
      <!--<img class="rounded-circle user-image" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/128.jpg">-->
       
        <p class="text-center text-muted">Account Locked</p>
       
        <p>Access to the web page was blocked. </br>Kindly contact System Administrator</p>
         <div class="form-group btn-container">
       
            <button class="btn btn-primary btn-block" type="submit" onclick="window.location.href='index.php';"><i class="fa fa-unlock fa-lg"></i>UNLOCK </button>
          
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>





</body>
</html>
