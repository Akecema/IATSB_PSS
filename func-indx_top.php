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

include 'func-brw.php';
 

?>
  </head>
 <style>
  body {
  background: url("images/scan_indx1.jpg") no-repeat center center fixed;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
    background-color: #cccccc;}

</style>
  <body>
   <!-- <section class="material-half-bg">
      <div class="cover"></div>
    </section>-->
    <section class="login-content">
      <div class="logo">
        <h1><img src="set_upload/<?php echo $filename;  ?>" width="400" height="70" /></h1>
      </div>
