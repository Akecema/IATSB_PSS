  <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="index_admin.php"><font face="arial" >PSS ITSB</font></a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <li class="app-search">
          <input class="app-search__input" type="search" placeholder="Search">
          <button class="app-search__button"><i class="fa fa-search"></i></button>
        </li>



<!--<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">-->
    <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
    <!--<li><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome <?php echo html_esc($res['user_fullname']); ?></span><b class="caret"></b></a>-->
       <ul class="dropdown-menu settings-menu dropdown-menu-right">
        <li><a href="#myModal1" data-toggle="modal" class="dropdown-item"><i class="fa fa-user fa-lg"></i> My Profile</a></li>
        <li> <a href="#myModal2" data-toggle="modal" class="dropdown-item"><i class="fa fa-cog fa-lg"></i> Change Password</a></li>
        <li><a href="../logout.php" class="dropdown-item"><i class="fa fa-sign-out fa-lg"></i> Log Out</a></li>
      </ul>
    </li>

<!--  </ul>
</div>-->
</ul>
</header>



  <main class="app-content">
<!----- start modal ------------------------------------------->
<div class="bs-component" style="margin-bottom: 3em;">
 <div id="myModal1" class="modal hide">
   <!-- <div class="modal-content">-->
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Personal Information</h3>
             <div class="modal-body">
  <?php

$queryu = "SELECT * from user_detail where user_no = '".sql_esc($res["user_no"])."'";
$resultu = mysqli_query($dbc,$queryu);   //run the query.
$row = mysqli_fetch_row($resultu);   //how many records are there?

 ?>
        
             <table width="99%" border="0" cellspacing="2">
               <tr>
                 <td width="26%" height="25">Vendor ID </td>
                 <td width="3%" height="25">:</td>
                 <td width="71%" height="25"><?php echo html_esc($row[1]); ?></td>
               </tr>
               <tr>
                 <td height="25">Staff ID </td>
                 <td height="25">:</td>
                 <td height="25"><b><font color="blue"><?php echo html_esc($row[2]); ?></font></b></td>
               </tr>
                 <tr>
                 <td height="25">Name</td>
                 <td height="25">:</td>
                 <td height="25"><?php echo html_esc($row[5]); ?> </td> 
               </tr>
               <tr>
                 <td height="25">Company's Name</td>
                 <td height="25">:</td>
                 <td height="25"><?php		
 	
  //Retrieve and display the available types
  $query3 = "SELECT * FROM company WHERE comp_code = '".sql_esc($row[8])."'";
  $result3 = mysqli_query($dbc,$query3);
  $row3 = mysqli_fetch_array($result3);
  
	    echo html_esc($row3["comp_name"]);
		

	?></td>
               </tr>
      
               <tr>
                 <td height="25">Department</td>
                 <td height="25">:</td>
                 <td height="25"><?php		
   //Retrieve and display the available types
  $query2 ="SELECT * from department WHERE id_dept = '".sql_esc($row[6])."'";
  $result2 = mysqli_query($dbc,$query2);
  $row2 = mysqli_fetch_array($result2);
	    
		echo html_esc($row2["dept_name"]); 
	
	?></td>
               </tr>
               <tr>
                 <td height="25">Designation</td>
                 <td height="25">:</td>
                 <td height="25"><?php		

  //Retrieve and display the available types
  $query2b = "SELECT * FROM designation WHERE id_design = '".sql_esc($row[7])."'";
  $result2b = mysqli_query($dbc,$query2b);
  $row2b = mysqli_fetch_array($result2b);
   
  echo html_esc($row2b[1]);

	?></td>
               </tr>
               <tr>
                 <td height="25">Telephone No. 1</td>
                 <td height="25">:</td>
                 <td height="25"><?php echo html_esc($row[9]); ?></td>
               </tr>
               <tr>
                 <td height="25">Telephone No. 2</td>
                 <td height="25">:</td>
                 <td height="25"><?php echo html_esc($row[10]); ?></td>
               </tr>
               <tr>
                 <td height="25">Fax No</td>
                 <td height="25">:</td>
                 <td height="25"><?php echo html_esc($row[11]); ?> </td>
               </tr>
               <tr>
                 <td height="25">E-mail</td>
                 <td height="25">:</td>
                 <td height="25"><?php echo html_esc($row[12]); ?></td>
               </tr>
               <tr>
                 <td height="25">Level</td>
                 <td height="25">:</td>
                 <td height="25"><?php		
 
  //Retrieve and display the available types
  $query4 = "SELECT * FROM level_detail WHERE status_level = 'Y' AND id_level = '".sql_esc($row[16])."'";
  $result4 = mysqli_query($dbc,$query4);
  $row4 = mysqli_fetch_array($result4);
	   
	    echo html_esc($row4["desc_level"]);
	
	?></td>
               </tr>
               <tr>
                 <td height="25">Status User</td>
                 <td height="25">:</td>
                 <td height="25">
	 <?php
	 
	  if($row[15] == "AC")
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
                   <?php  echo html_esc($row[14]); ?>
                 </font></b></td>
               </tr>
              
               <tr>
                 <td height="25">&nbsp;</td>
                 <td height="25">&nbsp;</td>
                 <td height="25">&nbsp;</td>
               </tr>
            </table> 
            </div> <!---modal body -->
            <!-- <div class="buttons">
            <input type="button" onClick="location.href='profile_edit_personal.php?user_no=<?php echo html_esc($row[0]); ?>'" value="EDIT" class="button" > </div>-->
            
                    <div class="modal-footer">
                      <input type="hidden" name="user_no" id="user_no" value="<?php echo html_esc($row[0]); ?>">
                      <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>
            
            
        <!--    <div align="right">
          <input type="hidden" name="user_no" id="user_no" value="<?php echo html_esc($row[0]); ?>">
		 <button type="button" class="btn btn-success" data-dismiss="modal">CLOSE</button></div>
                
      </div>-->
      </div>
      </div>
        <!--- modul1 --->
<!--      </div>-->

 <form class="contact" id="modal-form" data-remote="true" method="post" action="change_password_prod.php" >
 <div id="myModal2" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Change Password</h3>
                
               <table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="current">
          <tr> 
            <td><div align="right">Username</div></td>
            <td> <div align="center">:</div></td>
            <td><input type="text" name="username1" size="30" id="username1" readonly value="<?php echo $username; ?>" placeholder="Enter your username"></td>
          </tr>
          <tr> 
            <td><div align="right">Current Password</div></td>
            <td> <div align="center">:</div></td>
            <td><input type="password" name="password" id="password" size="30" placeholder="Enter current password"></td>
          </tr>
          <tr> 
            <td><div align="right">New Password </div></td>
            <td><div align="center">:</div></td>
            <td><input type="password" name="newpass"  id="newpass" size="30" placeholder="Enter new password"></td>
          </tr>
          <tr> 
            <td><div align="right">Confirm New Password</div></td>
            <td> <div align="center">:</div></td>
            <td><input type="password" name="newpass2"  id="newpass2" size="30" placeholder="Enter new password"></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
            <td><div align="right">
              <input type="submit" name="submit2" value="Change Password" class="btn btn-success" />
            </div></td>
          </tr>
          </table>
          <hr />
          <p class="style11">Password Composition and Rules</p>
         <ul>
           <li class="style8">Passwords shall be at least 8 non-sequential characters long.</li>
           <li class="style8">Passwords shall be composed of alpha-numeric characters. </li>
           <li class="style8">Passwords shall contain all of the 4 characteristics below: </li>
           <li class="style8">&raquo; alphabet character (a, b, c...z) </li>
           <li class="style8">&raquo; upper case letter (A, B, C...Z) </li>
           <li class="style8">&raquo; number (0, 1, 2, 3...9) </li>
           <li class="style8">&raquo; special character (@, $, !...etc.) </li>
           <li class="style8">Regular passwords shall be changed at least every 3 months (90 days).</li>
         </ul>
         <p align="center">&nbsp;</p>    
              </div>
             <!-- <div class="modal-body">
                <p>Here is the text coming you can put also image if you want…</p>
              </div>-->
            </div> <!--- modul2 --->
        </form>    
 <!-----------end modal ---------------------------------------->   
 
 <script>
      $('.bs-component [data-toggle="popover"]').popover();
      $('.bs-component [data-toggle="tooltip"]').tooltip();
    </script>

    </main>