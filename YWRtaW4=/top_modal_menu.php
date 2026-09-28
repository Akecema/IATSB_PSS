<?php

date_default_timezone_set('Asia/Kuala_Lumpur');
?>
<style>
.modal-header
{
 background-color:#3342cc;
 color: #FFF;
}
</style>

 <!-- Header-->
       <header class="app-header"><a class="app-header__logo" href="index_admin.php"><font face="arial" >PSS IATSB</font></a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
       <?php //----------welcome and date ------------ ?>
          &nbsp;&nbsp; <font color="#FFFFFF"><br />       <?php echo $Cdate;?> <b class="caret">| </b> &nbsp;&nbsp; Welcome <?php echo $res["user_fullname"]; ?></font>
      <ul class="app-nav">
      <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
       <ul class="dropdown-menu settings-menu dropdown-menu-right">
        <li><a href="#myModal1" data-toggle="modal" class="dropdown-item"><i class="fa fa-user fa-lg"></i> My Profile</a></li>
        <li> <a href="#myModal2" data-toggle="modal" class="dropdown-item"><i class="fa fa-cog fa-lg"></i> Change Password</a></li>
        <li><a href="#" class="dropdown-item" onClick="logout()"><i class="fa fa-sign-out fa-lg"></i> Log Out</a></li>
      </ul>
     </li>
      </ul>        
      <!-- <div class="bs-component">-->
              
   <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true" data-backdrop="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="scrollmodalLabel">Personal Information</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <?php

$query_top = "SELECT * from user_detail where user_no = '".sql_esc($res["user_no"])."'";
$result_top = mysqli_query($dbc,$query_top);   //run the query.
$row_top = mysqli_fetch_array($result_top);   //how many records are there?

 ?>
        
             <table width="99%" border="0" cellspacing="2">
               <tr>
                 <td width="26%" height="25">Company Code</td>
                 <td width="3%" height="25">:</td>
                 <td width="71%" height="25"><?php echo $row_top["vendor_no"]; ?></td>
               </tr>
               <tr>
                 <td height="25">Staff ID </td>
                 <td height="25">:</td>
                 <td height="25"><b><font color="blue"><?php echo $row_top["staff_ID"]; ?></font></b></td>
               </tr>
                 <tr>
                 <td height="25">Name</td>
                 <td height="25">:</td>
                 <td height="25"><?php echo $row_top["user_fullname"]; ?> </td> 
               </tr>
               <tr>
                 <td height="25">Company's Name</td>
                 <td height="25">:</td>
                 <td height="25"><?php		
 	
  //Retrieve and display the available types
  $query3_a = "SELECT * FROM company WHERE comp_code = '".sql_esc($row_top["company"])."'";
  $result3_a = mysqli_query($dbc,$query3_a);
  $row3_a = mysqli_fetch_array($result3_a);
  
	    echo $row3_a["comp_name"];
		

	?></td>
               </tr>
      
               <tr>
                 <td height="25">Department</td>
                 <td height="25">:</td>
                 <td height="25"><?php		
   //Retrieve and display the available types
  $query2_a ="SELECT * from department WHERE id_dept = '".sql_esc($row_top["department"])."'";
  $result2_a = mysqli_query($dbc,$query2_a);
  $row2_a = mysqli_fetch_array($result2_a);
	    
  echo $row2_a["dept_name"]; 
	
	?></td>
               </tr>
               <tr>
                 <td height="25">Designation</td>
                 <td height="25">:</td>
                 <td height="25"><?php		

  //Retrieve and display the available types
  $query2b = "SELECT * FROM designation WHERE id_design = '".sql_esc($row_top["designation"])."'";
  $result2b = mysqli_query($dbc,$query2b);
  $row2b = mysqli_fetch_array($result2b);
   
  echo $row2b["design"];

	?></td>
               </tr>
               <tr>
                 <td height="25">Telephone No. 1</td>
                 <td height="25">:</td>
                 <td height="25"><?php echo $row_top["user_telno1"]; ?></td>
               </tr>
               <tr>
                 <td height="25">Telephone No. 2</td>
                 <td height="25">:</td>
                 <td height="25"><?php echo $row_top["user_telno2"]; ?></td>
               </tr>
               <tr>
                 <td height="25">Fax No</td>
                 <td height="25">:</td>
                 <td height="25"><?php echo $row_top["user_fax"]; ?> </td>
               </tr>
               <tr>
                 <td height="25">E-mail</td>
                 <td height="25">:</td>
                 <td height="25"><?php echo $row_top["user_email"]; ?></td>
               </tr>
               <tr>
                 <td height="25">Level</td>
                 <td height="25">:</td>
                 <td height="25"><?php		
 
  //Retrieve and display the available types
  $query4_a = "SELECT * FROM level_detail WHERE status_level = 'Y' AND id_level = '".sql_esc($row_top["level_id"])."'";
  $result4_a = mysqli_query($dbc,$query4_a);
  $row4_a = mysqli_fetch_array($result4_a);
  
	    echo $row4_a["desc_level"];
	
	?></td>
               </tr>
               <tr>
                 <td height="25">Status User</td>
                 <td height="25">:</td>
                 <td height="25">
	 <?php
	 
	  if($row_top["status"] == "AC")
	  {
	     $sts = "Active";
		 }
		 else{
		 $sts = "Inactive";
		 }
	 
	 echo $sts; 
	  
      ?></td>
               </tr>
               <tr>
                 <td height="25">Date Created</td>
                 <td height="25">:</td>
                 <td height="25"><b><font color="blue">
                   <?php  echo $row_top["date_created"]; ?>
                 </font></b></td>
               </tr>
              
               <tr>
                 <td height="25">&nbsp;</td>
                 <td height="25">&nbsp;</td>
                 <td height="25">&nbsp;</td>
               </tr>
            </table> 
          
            <div align="right">
          <input type="hidden" name="user_no" id="user_no" value="<?php echo $row_top["user_no"]; ?>">
		  <button type="button" class="btn btn-primary" data-dismiss="modal">CLOSE</button></div>
                
                
                 </div>
                           <!-- </div>-->
                            
                        </div>
                    </div>
                </div>
                
                 <form class="contact" id="modal-form" data-remote="true" method="post" action="change_password_prod.php" >
                 <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true" data-backdrop="false" >
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Change Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                 <div class="modal-body">
                 <!-- <form name="form_no1"  >  -->
                    
                    <div class="card">
                      <div class="card-header"><strong>Change Password</strong></div>
                      <div class="card-body card-block">
                        <div class="form-group"><label class="form-control-label">Username</label><input type="text" name="username1" size="30" id="username1" readonly value="<?php echo $username; ?>" placeholder="Enter your username" class="form-control"></div>
                        <div class="form-group"><label class="form-control-label">Current Password</label><input type="password" name="password" id="password" size="30" placeholder="Enter current password" class="form-control" required="required"></div>
                        <div class="form-group"><label class="form-control-label">New Password</label><input type="password" name="newpass"  id="newpass" size="30" placeholder="Enter new password" class="form-control" required="required"></div>
                        <div class="form-group"><label class=" form-control-label">Confirm New Password</label><input type="password" name="newpass2"  id="newpass2" size="30" placeholder="Enter new password" class="form-control" required="required"></div>
                        
                        
              <div class="modal-footer">      
              <input type="submit" name="submit2" value="Change Password" class="btn btn-primary" />
             </div>  
                <hr />
         		 <p class="style11">Password Composition and Rules</p>
                 <p> 
                 
                   Passwords shall be at least 8 non-sequential characters long.<br>
                   Passwords shall be composed of alpha-numeric characters. <br>
                   Passwords shall contain all of the 4 characteristics below: <br>
                   &nbsp;&nbsp;&raquo; alphabet character (a, b, c...z) <br>
                   &nbsp;&nbsp;&raquo; upper case letter (A, B, C...Z) <br>
                   &nbsp;&nbsp;&raquo; number (0, 1, 2, 3...9) <br>
                   &nbsp;&nbsp;&raquo; special character (@, $, !...etc.) <br>
                   Regular passwords shall be changed at least every 3 months (90 days).<br>
                 
                 </p>
      
                  </div>   
                  </div>
                            </div>
                      
                        </div>
                    </div>
                </div>

                  </form>
                
                  
            </div>
 
        </header><!-- /header -->
        <!-- Header-->