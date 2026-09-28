<?php
// Check, if username session is NOT set then this page will jump to login page

/*if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "1")) {
header('Location: ../index.php');
exit();
}
*/
?>

    <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
      
     <!-- <img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">-->
        <div>
          <p class="app-sidebar__user-name"><div align="center">Production Support <br />System (PSS)<?php //echo $res['user_fullname']; ?></div></p>
         <!-- <p class="app-sidebar__user-designation">Frontend Developer</p>-->
        </div>
      </div>
      
      
      
   <a href="index_admin.php" class="app-menu__item"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a>
  <ul class="app-menu">
    <?php if ($url == "index_admin.php"){ ?>
  
    <li class="active"><?php }else { echo "<li>"; } ?><a href="index_admin.php" class="app-menu__item"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Home</span></a> </li>
    
  
    
     <?php if ($url == "setup_maintain_add.php"){ ?>
    <li><a href="setup_maintain_add.php" class="app-menu__item active"><i class="app-menu__icon fa fa-cogs"></i><span class="app-menu__label">Setup System</span></a> </li>
	<?php }else { echo "<li>"; ?><a href="setup_maintain_add.php" class="app-menu__item"><i class="app-menu__icon fa fa-cogs"></i><span class="app-menu__label">Setup System</span></a> </li> <?php } ?>
    
    <?php if (($url == "add_user.php") || ($url == "display_user.php") || ($url == "reset_password_user.php")){ ?>
		
    <li class="active"><a href="add_user.php" class="app-menu__item active"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">User Maintenance</span></a> </li>
     <?php }else { echo "<li>";  ?><a href="add_user.php" class="app-menu__item"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">User Maintenance</span></a> </li> <?php } ?>
   
      <?php if (($url == "work_center_table.php") ||($url == "material_master_list.php") || ($url == "con_detail_table.php") || ($url == "bom_header_upload.php") || ($url == "reason_reject_table.php") || ($url == "type_reject_table.php") || ($url == "reason_wastage_table.php") || ($url == "type_wastage_table.php") || ($url == "add_vendor_account.php") || ($url == "display_model_table.php") || ($url == "add_tbl_storage_PD.php") || ($url == "add_tbl_storage_QC.php")) { ?>
    <li  class="treeview is-expanded"><a href="work_center_table.php" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Syst. Data Maintenance</span> <i class="treeview-indicator fa fa-angle-right"></i></a> <?php }else { echo "<li class='treeview'>"; ?><a href="work_center_table.php" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Syst. Data Maintenance</span> <i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
    
      <ul class="treeview-menu">
         <?php if ($url == "work_center_table.php"){ ?>
        <li><a href="work_center_table.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Work Center</a></li><?php }else { echo "<li>";  ?><a href="work_center_table.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Work Center</a></li><?php } ?>
        <?php if ($url == "material_master_list.php"){ ?>
        <li><a href="material_master_list.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Material Master</a></li><?php }else { echo "<li>"; ?><a href="material_master_list.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Material Master</a></li><?php }  ?>
		<?php if ($url == "con_detail_table.php"){ ?>
        <li><a href="con_detail_table.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Consumable Details</a></li><?php }else { echo "<li>";  ?><a href="con_detail_table.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Consumable Details</a></li><?php }  ?>
         <?php if ($url == "reason_reject_table.php"){ ?>
        <li><a href="reason_reject_table.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Reason Reject</a></li><?php }else { echo "<li>";?><a href="reason_reject_table.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Reason Reject</a></li><?php }  ?>
        <?php if ($url == "type_reject_table.php"){ ?>
        <li><a href="type_reject_table.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Type of Reject</a></li><?php }else { echo "<li>"; ?><a href="type_reject_table.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Type of Reject</a></li><?php }  ?>
        <?php if ($url == "reason_wastage_table.php"){ ?>
        <li><a href="reason_wastage_table.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Reason Wastage</a></li><?php }else { echo "<li>";  ?><a href="reason_wastage_table.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Reason Wastage</a></li><?php }  ?>
        <?php if ($url == "type_wastage_table.php"){ ?>
        <li><a href="type_wastage_table.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Type of Wastage</a></li><?php }else { echo "<li>"; ?><a href="type_wastage_table.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Type of Wastage</a></li><?php }  ?>
        <?php if ($url == "add_tbl_storage_PD.php"){ ?>
        <li><a href="add_tbl_storage_PD.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Production Storage Location</a><?php }else { echo "<li>";  ?><a href="add_tbl_storage_PD.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Production Storage Location</a></li><?php }  ?>
        <?php if ($url == "add_tbl_storage_QC.php"){ ?>
        <li><a href="add_tbl_storage_QC.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;QC Storage Location</a></li><?php }else { echo "<li>";  ?><a href="add_tbl_storage_QC.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;QC Storage Location</a></li><?php }  ?>
        <?php if ($url == "add_vendor_account.php"){ ?>
        <li><a href="add_vendor_account.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Vendor Account</a></li><?php }else { echo "<li>";  ?><a href="add_vendor_account.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Vendor Account</a></li><?php }  ?>
         <?php if ($url == "display_model_table.php"){ ?>
        <li ><a href="display_model_table.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Material Model</a></li><?php }else { echo "<li>";  ?><a href="display_model_table.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Material Model</a></li><?php }  ?>
      </ul>
    </li>
    
    
     <?php if (($url == "posting_request_all_screen_LCD.php") || ($url == "posting_request_all_screen_LCD_consumable.php") || ($url == "posting_request_all_screen_LCD_WIP.php")) { ?> 
   <li  class="treeview is-expanded"><a href="posting_request_all_screen_LCD.php"  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-bar-chart"></i><span class="app-menu__label">Board</span><i class="treeview-indicator fa fa-angle-right"></i> </a> <?php }else { echo "<li class='treeview'>";  ?> <a href="posting_request_all_screen_LCD.php"  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-bar-chart"></i><span class="app-menu__label">Board</span><i class="treeview-indicator fa fa-angle-right"></i> </a><?php }  ?>
   
   
      <ul class="treeview-menu">
         <?php if ($url == "posting_request_all_screen_LCD.php"){ ?>
        <li><a href="posting_request_all_screen_LCD.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Material Request Board</a></li><?php }else { echo "<li>";  ?><a href="posting_request_all_screen_LCD.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Material Request Board</a></li><?php }  ?>
           <?php if ($url == "posting_request_all_screen_LCD_consumable.php"){ ?>
        <li><a href="posting_request_all_screen_LCD_consumable.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Consumable Request Board</a></li><?php }else { echo "<li>"; ?><a href="posting_request_all_screen_LCD_consumable.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Consumable Request Board</a></li><?php }  ?>
         <?php if ($url == "posting_request_all_screen_LCD_WIP.php"){ ?>
        <li><a href="posting_request_all_screen_LCD_WIP.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;WIP Request Board</a></li><?php }else { echo "<li>";  ?><a href="posting_request_all_screen_LCD_WIP.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;WIP Request Board</a></li><?php }  ?>
      </ul>
    </li>
    
     <?php if (($url == "report_PPC.php") || ($url == "material_request_analysis.php")) { ?> 
   <li class="treeview is-expanded"> <a href="report_PPC.php" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Material Request</span><i class="treeview-indicator fa fa-angle-right"></i></a> <?php }else { echo "<li class='treeview'>";  ?>
   <a href="report_PPC.php" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Material Request</span><i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
      
      <ul class="treeview-menu">
         <?php if ($url == "report_PPC.php"){ ?>
        <li><a href="report_PPC.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Material Request Report</a></li><?php }else { echo "<li>";  ?><a href="report_PPC.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Material Request Report</a></li><?php } ?>
         <?php if ($url == "material_request_analysis.php"){ ?>
        <li><a href="material_request_analysis.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Material Request Analysis</a></li><?php }else { echo "<li>";  ?><a href="material_request_analysis.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Material Request Analysis</a></li><?php } ?>
      </ul>
    </li>
       <?php if (($url == "report_PPC_consumable.php") || ($url == "consumable_request_analysis.php")) { ?> 
   <li class="treeview is-expanded"> <?php }else { echo "<li class='treeview'>";  ?><a href="report_PPC_consumable.php"  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-edit"></i><span class="app-menu__label">Consumable Request</span><i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
      
      <ul class="treeview-menu">
        <?php if ($url == "report_PPC_consumable.php"){ ?>
        <li><a href="report_PPC_consumable.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Consumable Request Report</a></li><?php }else { echo "<li>";  ?><a href="report_PPC_consumable.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Consumable Request Report</a></li><?php } ?>
         <?php if ($url == "consumable_request_analysis.php"){ ?>
        <li><a href="consumable_request_analysis.php" class="treeview-itema ctive"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Consumable Request Analysis</a></li><?php }else { echo "<li>";  ?><a href="consumable_request_analysis.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Consumable Request Analysis</a></li><?php } ?>
      </ul>
    </li>
    
      <?php if ($url == "wip_request_analysis.php") { ?> 
   <li class="treeview is-expanded"><a href="wip_request_analysis.php" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i> <span class="app-menu__label">WIP Request</span><i class="treeview-indicator fa fa-angle-right"></i> </a> <?php }else { echo "<li class='treeview'>";  ?> <a href="wip_request_analysis.php" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i> <span class="app-menu__label">WIP Request</span><i class="treeview-indicator fa fa-angle-right"></i> </a><?php } ?>
     
      <ul class="treeview-menu">
        <?php if ($url == "wip_request_analysis.php"){ ?>
        <li><a href="wip_request_analysis.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;WIP Request Report</a></li><?php }else { echo "<li>";  ?><a href="wip_request_analysis.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;WIP Request Report</a></li><?php } ?>
      </ul>
    </li>
  <!--   
    <?php if (($url == "list_ftp_pending_sap.php") ||($url == "FTP_bflush_download.php") || ($url =="FTP_gdtranfer_download.php")) { ?> 
    <li class="treeview is-expanded"> <a href="FTP_bflush_download.php" class="app-menu__item"  data-toggle="treeview"> <i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">FTP Monitoring</span><i class="treeview-indicator fa fa-angle-right"></i></a> <?php }else { echo "<li class='treeview'>";  ?> <a href="FTP_bflush_download.php" class="app-menu__item"  data-toggle="treeview"> <i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">FTP Monitoring</span><i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
    	
        <ul class="treeview-menu">
        <?php if ($url == "list_ftp_pending_sap.php"){ ?>
    		<li><a href="list_ftp_pending_sap.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush FTP Monitor</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_pending_sap.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush FTP Monitor</a></li><?php } ?>
    		<?php if ($url == "FTP_bflush_download.php"){ ?>
    		<li><a href="FTP_bflush_download.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;FTP Backflush </a></li><?php }else { echo "<li>";  ?><a href="FTP_bflush_download.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;FTP Backflush </a></li><?php } ?>
            <?php if ($url =="FTP_gdtranfer_download.php"){ ?>
    		<li><a href="FTP_gdtranfer_download.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;FTP Good Tranfer </a></li><?php }else { echo "<li>"; } ?><a href="FTP_gdtranfer_download.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;FTP Good Tranfer </a></li><?php // } ?>
    	</ul>
    </li>-->

  <li><a href="../logout.php" class="app-menu__item"><i class="app-menu__icon fa fa-power-off" ></i><span class="app-menu__label">Logout</span></a></li>
  </ul>

    </aside>
 
<!--sidebar-menu-->

    
    
    
   <!-- 
    
    
    
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
      
      
      <img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?php echo html_esc($res['user_fullname']); ?></p>
         <!-- <p class="app-sidebar__user-designation">Frontend Developer</p>-->
      <!--  </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item active" href="../docs/dashboard.html"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">UI Elements</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="../docs/bootstrap-components.html"><i class="icon fa fa-circle-o"></i> Bootstrap Elements</a></li>
            <li><a class="treeview-item" href="https://fontawesome.com/v4.7.0/icons/" target="_blank" rel="noopener"><i class="icon fa fa-circle-o"></i> Font Icons</a></li>
            <li><a class="treeview-item" href="../docs/ui-cards.html"><i class="icon fa fa-circle-o"></i> Cards</a></li>
            <li><a class="treeview-item" href="../docs/widgets.html"><i class="icon fa fa-circle-o"></i> Widgets</a></li>
          </ul>
        </li>
        <li><a class="app-menu__item" href="../docs/charts.html"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Charts</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-edit"></i><span class="app-menu__label">Forms</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="../docs/form-components.html"><i class="icon fa fa-circle-o"></i> Form Components</a></li>
            <li><a class="treeview-item" href="../docs/form-custom.html"><i class="icon fa fa-circle-o"></i> Custom Components</a></li>
            <li><a class="treeview-item" href="../docs/form-samples.html"><i class="icon fa fa-circle-o"></i> Form Samples</a></li>
            <li><a class="treeview-item" href="../docs/form-notifications.html"><i class="icon fa fa-circle-o"></i> Form Notifications</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Tables</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="../docs/table-basic.html"><i class="icon fa fa-circle-o"></i> Basic Tables</a></li>
            <li><a class="treeview-item" href="../docs/table-data-table.html"><i class="icon fa fa-circle-o"></i> Data Tables</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">Pages</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="../docs/blank-page.html"><i class="icon fa fa-circle-o"></i> Blank Page</a></li>
            <li><a class="treeview-item" href="../docs/page-login.html"><i class="icon fa fa-circle-o"></i> Login Page</a></li>
            <li><a class="treeview-item" href="../docs/page-lockscreen.html"><i class="icon fa fa-circle-o"></i> Lockscreen Page</a></li>
            <li><a class="treeview-item" href="../docs/page-user.html"><i class="icon fa fa-circle-o"></i> User Page</a></li>
            <li><a class="treeview-item" href="../docs/page-invoice.html"><i class="icon fa fa-circle-o"></i> Invoice Page</a></li>
            <li><a class="treeview-item" href="../docs/page-calendar.html"><i class="icon fa fa-circle-o"></i> Calendar Page</a></li>
            <li><a class="treeview-item" href="../docs/page-mailbox.html"><i class="icon fa fa-circle-o"></i> Mailbox</a></li>
            <li><a class="treeview-item" href="../docs/page-error.html"><i class="icon fa fa-circle-o"></i> Error Page</a></li>
          </ul>
        </li>
        <li><a class="app-menu__item" href="../docs/docs.html"><i class="app-menu__icon fa fa-file-code-o"></i><span class="app-menu__label">Docs</span></a></li>
      </ul>
    </aside>-->
 