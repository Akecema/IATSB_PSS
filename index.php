<?php 
include 'con-dbcIATSB.php';

include 'func-indx_top.php';

?>


    <?php 
	   
	include 'ckies-brw.php';
   
        include 'chk-auth_host.php';

	
	?>
    
    
    <?php
//if the login form is submitted 
 if (isset($_POST['submit'])) { // if form has been submitted
	
	include 'chk-auth.php';
 }else 
{	

  include 'mdl-login.php';
 
 // if they are not logged in 

 } 

 ?>  
      
    </section>
 <?php

  include 'func-indx_bottom.php';
  
?>
  </body>
</html>