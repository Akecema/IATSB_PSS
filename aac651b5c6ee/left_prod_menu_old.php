<?php    //--------menu function ------------------------------

$query_function = "SELECT * FROM function_acc_detail WHERE staff_ID = '".sql_esc($res["staff_ID"])."'";
$result_function = mysqli_query($dbc,$query_function);   //run the query.
$data_function = mysqli_fetch_array($result_function);   //how many records are there?  
//----------------------------------------------------
    
 ?>   
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><!--<img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">-->
        <div>
           <p class="app-sidebar__user-name"><div align="center">Production Support <br />System (PSS)<?php //echo $res['user_fullname']; ?></div></p>
          <!--<p class="app-sidebar__user-designation">Frontend Developer</p>-->
        </div>
      </div>
      <ul class="app-menu">
      
       <?php if($url == "index_production.php"){ ?>
        <li><a href="index_production.php" class="app-menu__item active"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Home</span></a></li>  <?php  }else{ echo "<li>"; ?><a href="index_production.php" class="app-menu__item"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Home</span></a></li>  <?php  } ?>    
     
     <?php if($url == "dash_brdprod.php"){ ?>
        <li><a href="dash_brdprod.php" class="app-menu__item active"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Planning</span></a></li>  <?php  }else{ echo "<li>"; ?><a href="dash_brdprod.php" class="app-menu__item"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Planning</span></a></li>  <?php  } ?> 
         
		 <?php if($url == "dash_brdprod2.php"){ ?>
        <li><a href="dash_brdprod2.php" class="app-menu__item active"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Production</span></a></li>  <?php  }else{ echo "<li>"; ?><a href="dash_brdprod2.php" class="app-menu__item"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Production</span></a></li>  <?php  } ?> 
       
         <?php
			    if($data_function["prd_plan"] == "Y")
			 {
				?>
                
         <?php if (($url == "upload_pps_month-assy.php") || ($url == "display_pps_month_reprint.php") || ($url == "technical_complete_tran.php") || ($url == "report_plan_order-status.php")) { ?>
         
    <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-line-chart"></i><span class="app-menu__label">Production Planning</span> <i class="treeview-indicator fa fa-angle-right"></i></a> <?php }else { echo "<li class='treeview'>"; ?><a href="" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-line-chart"></i><span class="app-menu__label">Production Planning</span> <i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
    
      <ul class="treeview-menu">
         <?php 
         if($data_function["f_ftp_plan_prd"] == "Y")
			 {   ?>
         <?php if ($url == "upload_pps_month-assy.php"){ ?>
        <li><a href="upload_pps_month-assy.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Upload Planning</a></li><?php }else { echo "<li>";  ?><a href="upload_pps_month-assy.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Upload Planning</a></li><?php } ?>
        <?php  }  ?>
        
        
         <?php 
         if($data_function["f_view_plan_prd"] == "Y")
			 {   ?>
         <?php if ($url == "display_pps_month_reprint.php"){ ?>
        <li><a href="display_pps_month_reprint.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;PPS Listings</a></li><?php }else { echo "<li>";  ?><a href="display_pps_month_reprint.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;PPS Listings</a></li><?php } ?>
        <?php  }  ?>  
        
        
         <?php 
         if($data_function["f_close_plan_prd"] == "Y")
			 {   ?>
         <?php if ($url == "technical_complete_tran.php"){ ?>
        <li><a href="technical_complete_tran.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Close Planned Order</a></li><?php }else { echo "<li>";  ?><a href="technical_complete_tran.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Close Planned Order</a></li><?php } ?>
        <?php  }  ?>     
        
         <?php 
         if($data_function["f_rep_plan_prd"] == "Y")
			 {   ?>
         <?php if ($url == "report_plan_order-status.php"){ ?>
        <li><a href="report_plan_order-status.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Planned Order Status Report</a></li><?php }else { echo "<li>";  ?><a href="report_plan_order-status.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Planned Order Status Report</a></li><?php } ?>
        <?php  }  ?>  
        
         </ul>
         </li>
         <?php  }  ?> 
        
        
   
        
          
        
         <?php
			    if($data_function["prd_assb"] == "Y")
			 {
				?>
                
         <?php if (($url == "confirm_backflush_tran.php") || ($url == "confirm_backflush_tran_NG.php") || ($url == "confirm_backflush_tran_Pend.php") || ($url == "confirm_backflush_tran_Hwok.php") || ($url == "confirm_backflush_tran_Pend-confirm.php") || ($url == "backflush_tran_Pend-confirm_rework.php") || ($url == "confirm_backflush_tran_Hwok-confirm.php") || ($url == "detail_PRD_cancel_bflush.php") ||($url == "detail_comp_reject_prd.php") || ($url == "detail_aprv_bf_disposal-prd.php") || ($url == "detail_aprv_bf_disposal2-prd.php") || ($url == "detail_aprv_bf_disposal3-prd.php") || ($url == "detail_aprv_bf_disposal4-prd.php") || ($url == "detail_list_bf_disposal-prd.php") || ($url == "detail_aprv_bf_disposal-prd.php") || ($url == "print_tag_backflush_trn_fg.php") || ($url == "report_production_reject.php") || ($url == "report_wastage_reject.php")) { ?>
         
    <li class="treeview is-expanded"><a href="confirm_backflush_tran.php" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-bar-chart"></i><span class="app-menu__label">Production</span> <i class="treeview-indicator fa fa-angle-right"></i></a> <?php }else { echo "<li class='treeview'>"; ?><a href="confirm_backflush_tran.php" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-bar-chart"></i><span class="app-menu__label">Production</span> <i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
    
      <ul class="treeview-menu">
         <?php 
         if($data_function["f_bf_ok"] == "Y")
			 {   ?>
         <?php if ($url == "confirm_backflush_tran.php"){ ?>
        <li><a href="confirm_backflush_tran.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Confirmation Backflush (OK)</a></li><?php }else { echo "<li>";  ?><a href="confirm_backflush_tran.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Confirmation Backflush (OK)</a></li><?php } ?>
        <?php  }  ?>    
        
        <?php 
         if($data_function["f_bf_ng"] == "Y")
			 {   ?>
        
         <?php if ($url == "confirm_backflush_tran_NG.php"){ ?>
        <li><a href="confirm_backflush_tran_NG.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Confirmation Backflush (NG)</a></li><?php }else { echo "<li>";  ?><a href="confirm_backflush_tran_NG.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Confirmation Backflush (NG)</a></li><?php } ?>
        <?php   } ?>
        
        <?php 
         if($data_function["f_bf_pending"] == "Y")
			 {   ?>
        
       <?php if ($url == "confirm_backflush_tran_Pend.php"){ ?>
        <li><a href="confirm_backflush_tran_Pend.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Confirmation Backflush (PENDING)</a></li><?php }else { echo "<li>";  ?><a href="confirm_backflush_tran_Pend.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Confirmation Backflush (PENDING)</a></li><?php } ?> 
        
        <?php   }  ?>
        
        <?php 
         if($data_function["f_bf_handwork"] == "Y")
			 {   ?>
             
         <?php if ($url == "confirm_backflush_tran_Hwok.php"){ ?>
        <li><a href="confirm_backflush_tran_Hwok.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Confirmation Backflush (HANDWORK)</a></li><?php }else { echo "<li>";  ?><a href="confirm_backflush_tran_Hwok.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Confirmation Backflush (HANDWORK)</a></li><?php } ?> 
        <?php   } ?>
        
               
            <?php 
         if($data_function["f_bf_pend_conf_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "confirm_backflush_tran_Pend-confirm.php"){ ?>
        <li><a href="confirm_backflush_tran_Pend-confirm.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Pending Confirmation</a></li><?php }else { echo "<li>"; ?><a href="confirm_backflush_tran_Pend-confirm.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Pending Confirmation</a></li><?php }  ?>	 
			 
		<?php	 } ?>
             
               <?php 
         if($data_function["f_pend_rwork_conf_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "backflush_tran_Pend-confirm_rework.php"){ ?>
        <li><a href="backflush_tran_Pend-confirm_rework.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Rework</a></li><?php }else { echo "<li>"; ?><a href="backflush_tran_Pend-confirm_rework.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Rework</a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
             
           <?php 
         if($data_function["f_pend_hwork_conf_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "confirm_backflush_tran_Hwok-confirm.php"){ ?>
        <li><a href="confirm_backflush_tran_Hwok-confirm.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Handwork</a></li><?php }else { echo "<li>"; ?><a href="confirm_backflush_tran_Hwok-confirm.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Handwork</a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
        <?php 
         if($data_function["f_canc_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_PRD_cancel_bflush.php"){ ?>
        <li><a href="detail_PRD_cancel_bflush.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Cancellation</a></li><?php }else { echo "<li>"; ?><a href="detail_PRD_cancel_bflush.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Cancellation</a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
        <?php 
         if($data_function["f_comp_rej_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_comp_reject_prd.php"){ ?>
        <li><a href="detail_comp_reject_prd.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Component Reject</a></li><?php }else { echo "<li>"; ?><a href="detail_comp_reject_prd.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Component Reject</a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
           <?php 
         if($data_function["f_dis_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_bf_disposal-prd.php"){ ?>
        <li><a href="detail_bf_disposal-prd.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposals</a></li><?php }else { echo "<li>"; ?><a href="detail_bf_disposal-prd.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposals</a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
         <?php 
         if($data_function["f_dis_list_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_list_bf_disposal-prd.php"){ ?>
        <li><a href="detail_list_bf_disposal-prd.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposals List</a></li><?php }else { echo "<li>"; ?><a href="detail_list_bf_disposal-prd.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposals List</a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
         <?php 
         if($data_function["f_dis_approval_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_aprv_bf_disposal-prd.php"){ ?>
        <li><a href="detail_aprv_bf_disposal-prd.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposals Approval</a></li><?php }else { echo "<li>"; ?><a href="detail_aprv_bf_disposal-prd.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposals Approval</a></li><?php }  ?>	 		<?php	 } ?>
        
        
      <!--   <?php 
       //  if($data_function["f_dis_approval_prd2"] == "Y")
			// {    
			 ?>
		 <?php //if ($url == "detail_aprv_bf_disposal2-prd.php"){ ?>
        <li><a href="detail_aprv_bf_disposal2-prd.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposals Approval - QC Exec</a></li><?php // }else { echo "<li>"; ?><a href="detail_aprv_bf_disposal2-prd.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposals Approval - QC Exec</a></li><?php //}  ?>	 		<?php	// } ?>
        
         <?php 
       //  if($data_function["f_dis_approval_prd3"] == "Y")
			// {    
			 ?>
		 <?php //if ($url == "detail_aprv_bf_disposal3-prd.php"){ ?>
        <li><a href="detail_aprv_bf_disposal3-prd.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposals Approval - HOD QC</a></li><?php // }else { echo "<li>"; ?><a href="detail_aprv_bf_disposal3-prd.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposals Approval - HOD QC</a></li><?php // }  ?>	 		<?php	// } ?>
        
        
         <?php 
      //   if($data_function["f_dis_approval_prd4"] == "Y")
			// {    
			 ?>
		 <?php //if ($url == "detail_aprv_bf_disposal4-prd.php"){ ?>
        <li><a href="detail_aprv_bf_disposal4-prd.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposals Approval - COO</a></li><?php //}else { echo "<li>"; ?><a href="detail_aprv_bf_disposal4-prd.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposals Approval - COO</a></li><?php //}  ?>	 		<?php	// } ?>
        
        -->
        <?php 
         if($data_function["f_print_prd"] == "Y")
			 {    
			 ?>
        
        <?php if ($url == "print_tag_backflush_trn_fg.php"){ ?>
        <li><a href="print_tag_backflush_trn_fg.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print Tag</a></li><?php }else { echo "<li>"; ?><a href="print_tag_backflush_trn_fg.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print Tag</a></li><?php }  ?>
    <?php	 } ?>    
        
        
      </ul>
    </li>
    
    
    <?php    }  ?>
    
      <?php
			    if($data_function["f_rep_prd"] == "Y")
			 {
				?>
    
     
      <?php if (($url == "list_rpt_bf_all.php") || ($url == "list_rpt_PEND_all.php") || ($url =="list_rpt_RWK_all.php") | ($url =="list_rpt_RWK_all.php") | ($url =="list_rpt_HWORK_all.php") | ($url =="list_rpt_DIS_all.php") | ($url =="list_rpt_pln_sta_all.php")) { ?> 
   <li class="treeview is-expanded"><a href="list_rpt_bf_all.php" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">Report</span><i class="treeview-indicator fa fa-angle-right"></i> </a> <?php }else { echo "<li class='treeview'>";  ?> <a href="list_rpt_bf_all.php"  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">Report</span><i class="treeview-indicator fa fa-angle-right"></i> </a><?php }  ?>
   
   
      <ul class="treeview-menu">
         <?php if ($url == "list_rpt_bf_all.php"){ ?>
        <li><a href="list_rpt_bf_all.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush</a></li><?php }else { echo "<li>";  ?><a href="list_rpt_bf_all.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush</a></li><?php }  ?>
          
           <?php if ($url == "list_rpt_PEND_all.php"){ ?>
        <li><a href="list_rpt_PEND_all.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Pending</a></li><?php }else { echo "<li>"; ?><a href="list_rpt_PEND_all.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Pending</a></li><?php }  ?>
        
         <?php if ($url == "list_rpt_RWK_all.php"){ ?>
        <li><a href="list_rpt_RWK_all.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Rework</a></li><?php }else { echo "<li>"; ?><a href="list_rpt_RWK_all.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Rework</a></li><?php }  ?>
        
       <?php 
	      
		  if($data_function["f_assy_prd"] == "Y")
			 {
         if ($url == "list_rpt_HWORK_all.php"){ ?>
        <li><a href="list_rpt_HWORK_all.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Handwork</a></li><?php }else { echo "<li>"; ?><a href="list_rpt_HWORK_all.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Handwork</a></li><?php }  ?>
        <?php   }   ?>
        <?php if ($url == "list_rpt_DIS_all.php"){ ?>
        <li><a href="list_rpt_DIS_all.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php }else { echo "<li>"; ?><a href="list_rpt_DIS_all.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php }  ?>
        
        <?php if ($url == "list_rpt_pln_sta_all.php"){ ?>
        <li><a href="list_rpt_pln_sta_all.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Planned Order Status</a></li><?php }else { echo "<li>"; ?><a href="list_rpt_pln_sta_all.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Planned Order Status</a></li><?php }  ?>
      
      </ul>
    </li>
      <?php  } ?>
    
        
        
        
        
        <?php
			    if($data_function["prd_ftp"] == "Y")
			 {
				?>
    
     
      <?php if (($url == "list_ftp_bf-all_prd.php") || ($url == "list_ftp_bf-NG_prd.php") || ($url == "list_ftp_bf-PEND_prd.php") || ($url == "list_ftp_bf-HWORK_prd.php") || ($url == "list_ftp_PEND-all_prd.php") || ($url =="list_ftp_RWK-all_prd.php") || ($url =="list_ftp_HWORK-all_prd.php") || ($url == "list_ftp_DIS-all_prd.php")) { ?> 
   <li class="treeview is-expanded"><a href="list_ftp_bf-all_prd.php" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-upload"></i><span class="app-menu__label">FTP Monitoring</span><i class="treeview-indicator fa fa-angle-right"></i> </a> <?php }else { echo "<li class='treeview'>";  ?> <a href="list_ftp_bf-all_prd.php"  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-upload"></i><span class="app-menu__label">FTP Monitoring</span><i class="treeview-indicator fa fa-angle-right"></i> </a><?php }  ?>
   
   
      <ul class="treeview-menu">
       <?php 
         if($data_function["f_bf_pftp"] == "Y")
			 {    
			 ?>
      
         <?php if ($url == "list_ftp_bf-all_prd.php"){ ?>
        <li><a href="list_ftp_bf-all_prd.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush OK</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_bf-all_prd.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush OK</a></li><?php }  ?>
        
        <?php if ($url == "list_ftp_bf-NG_prd.php"){ ?>
        <li><a href="list_ftp_bf-NG_prd.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush NG</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_bf-NG_prd.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush NG</a></li><?php }  ?>
      
        
        <?php if ($url == "list_ftp_bf-PEND_prd.php"){ ?>
        <li><a href="list_ftp_bf-PEND_prd.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush Pending</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_bf-PEND_prd.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush Pending</a></li><?php }  ?>
        
         <?php if ($url == "list_ftp_bf-HWORK_prd.php"){ ?>
        <li><a href="list_ftp_bf-HWORK_prd.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush Handwork</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_bf-HWORK_prd.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush Handwork</a></li><?php }  ?>
        
        <?php  }   ?>
        
        <?php 
         if($data_function["f_pend_pftp"] == "Y")
			 {    
			 ?>
           <?php if ($url == "list_ftp_PEND-all_prd.php"){ ?>
        <li><a href="list_ftp_PEND-all_prd.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Pending</a></li><?php }else { echo "<li>"; ?><a href="list_ftp_PEND-all_prd.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Pending</a></li><?php }  ?>
        <?php   }   ?>
        <?php 
        /* if($data_function["f_rwork_pftp"] == "Y")
			 {    */
			 ?>
         <?php //if ($url == "list_ftp_RWK-all_prd.php"){ ?>
<!--        <li><a href="list_ftp_RWK-all_prd.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Rework</a></li><?php //}else { echo "<li>";  ?><a href="list_ftp_RWK-all_prd.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Rework</a></li><?php //}  ?>
-->        <?php  //}  ?>
        
        <?php 
        /* if($data_function["f_hwork_pftp"] == "Y")
			 {  */  
			 ?>
        
         <?php //if ($url == "list_ftp_HWORK-all_prd.php"){ ?>
<!--        <li><a href="list_ftp_HWORK-all_prd.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Handwork</a></li><?php //}else { echo "<li>";  ?><a href="list_ftp_HWORK-all_prd.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Handwork</a></li><?php //}  ?>
-->        <?php   //}  ?>
        
        
         <?php 
         if($data_function["f_dis_pftp"] == "Y")
			 {    
			 ?>
        
         <?php if ($url == "list_ftp_DIS-all_prd.php"){ ?>
        <li><a href="list_ftp_DIS-all_prd.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal GI</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_DIS-all_prd.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal GI</a></li><?php }  ?>
        <?php   }  ?>
        
      </ul>
    </li>
      <?php  } ?>
    
        
        
 
    
       <li><a href="../logout.php" class="app-menu__item"><i class="app-menu__icon fa fa-power-off" ></i><span class="app-menu__label">Logout</span></a></li>
      
      
      </ul>
    </aside>
 