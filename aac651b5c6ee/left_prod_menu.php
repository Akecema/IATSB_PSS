<?php    //--------menu function ------------------------------
include 'apprv_func_list.php';

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
     
        <?php
			    if($data_function["main_dash"] == "Y")
			 {
				?>
        <?php if($url == "dash_brdprod.php"){ ?>
        <li><a href="dash_brdprod.php" class="app-menu__item active"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Planning</span></a></li>  <?php  }else{ echo "<li>"; ?><a href="dash_brdprod.php" class="app-menu__item"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Planning</span></a></li>  <?php  } } ?> 
         
             <?php
			    if($data_function["main_dash2"] == "Y")
			 {
				?>
		 <?php if($url == "dash_brdprod2.php"){ ?>
        <li><a href="dash_brdprod2.php" class="app-menu__item active"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Production</span></a></li>  <?php  }else{ echo "<li>"; ?><a href="dash_brdprod2.php" class="app-menu__item"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Production</span></a></li>  <?php  }  }?> 
         <?php
			    if($data_function["main_dash3"] == "Y")
			 {
				?>
       
         <?php if($url == "dash_brdppc2.php"){ ?>
        <li><a href="dash_brdppc2.php" class="app-menu__item active"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Progress</span></a></li>  <?php  }else{ echo "<li>"; ?><a href="dash_brdppc2.php" class="app-menu__item"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Progress</span></a></li>  <?php  } } ?> 
      
        <?php
			    if($data_function["main_dash4"] == "Y")
			 {
				?>
      <?php if($url == "dash_brdppc3.php"){ ?>
        <li><a href="dash_brdppc3.php" class="app-menu__item active"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Receiving</span></a></li>  <?php  }else{ echo "<li>"; ?><a href="dash_brdppc3.php" class="app-menu__item"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Receiving</span></a></li>  <?php  }  } ?> 
       
       
         <?php
			    if($data_function["main_dash5"] == "Y")
			 {
				?>
       <?php if($url == "dash_brdppc4.php"){ ?>
        <li><a href="dash_brdppc4.php" class="app-menu__item active"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Delivery</span></a></li>  <?php  }else{ echo "<li>"; ?><a href="dash_brdppc4.php" class="app-menu__item"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard Delivery</span></a></li>  <?php  }  }?> 
       
       
       
         <?php
			    if($data_function["prd_plan"] == "Y")
			 {
				?>
                
         <?php if (($url == "ups_pps_month-assy.php") || ($url == "upload_pps_month-assy.php") || ($url == "display_pps_month_reprint.php") || ($url == "technical_complete_tran.php")) { ?>
         
    <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-line-chart"></i><span class="app-menu__label">Planning</span> <i class="treeview-indicator fa fa-angle-right"></i></a> <?php }else { echo "<li class='treeview'>"; ?><a href="" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-line-chart"></i><span class="app-menu__label">Planning</span> <i class="treeview-indicator fa fa-angle-right"></i></a><?php }  ?>
    
      <ul class="treeview-menu">
         <?php 
         if($data_function["f_ftp_plan_prd"] == "Y")
			 {   ?>
         <?php if ($url == "ups_pps_month-assy.php"){ ?>
        <li><a href="ups_pps_month-assy.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Create Planned Order</a></li><?php }else { echo "<li>";  ?><a href="ups_pps_month-assy.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Create Planned Order</a></li><?php } ?>
        <?php  }  ?>
        
         <?php 
         if($data_function["f_upl_plan_prd"] == "Y")
			 {   ?>
         <?php if ($url == "upload_pps_month-assy.php"){ ?>
        <li><a href="upload_pps_month-assy.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Upload PPS</a></li><?php }else { echo "<li>";  ?><a href="upload_pps_month-assy.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Upload PPS</a></li><?php } ?>
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
        
             
         </ul>
         
         </li><?php   }   ?> 
         
         
         
    <!--- Purchase Order ----->
    
     <?php
			    if($data_function["main_po"] == "Y")
			 {
				?>
                
         <?php if (($url == "ups_purc-ord.php") || ($url == "display_purc-ord.php") || ($url == "mnt_purc-ord.php")) { ?>
         
    <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-line-chart"></i><span class="app-menu__label">Purchase Order</span> <i class="treeview-indicator fa fa-angle-right"></i></a> <?php }else { echo "<li class='treeview'>"; ?><a href="" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-line-chart"></i><span class="app-menu__label">Purchase Order</span> <i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
    
      <ul class="treeview-menu">
         <?php 
         if($data_function["f_po_smenu1"] == "Y")
			 {   ?>
         <?php if ($url == "ups_purc-ord.php"){ ?>
        <li><a href="ups_purc-ord.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Upload PO</a></li><?php }else { echo "<li>";  ?><a href="ups_purc-ord.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Upload PO</a></li><?php } ?>
        <?php  }  ?>
        
        
         <?php 
         if($data_function["f_po_smenu2"] == "Y")
			 {   ?>
         <?php if ($url == "display_purc-ord.php"){ ?>
        <li><a href="display_purc-ord.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;View PO</a></li><?php }else { echo "<li>";  ?><a href="display_purc-ord.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;View PO</a></li><?php } ?>
        <?php  }  ?>  
        
        
         <?php 
         if($data_function["f_po_smenu3"] == "Y")
			 {   ?>
         <?php if ($url == "mnt_purc-ord.php"){ ?>
        <li><a href="mnt_purc-ord.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Maintain PO</a></li><?php }else { echo "<li>";  ?><a href="mnt_purc-ord.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Maintain PO</a></li><?php } ?>
        <?php  }  ?>     
        
             
         </ul>
         </li>
         <?php  }   ?> 
              
         
          <!--- Material Forcast ----->
    
     <?php
			    if($data_function["main_mfo"] == "Y")
			 {
				?>
                
         <?php if (($url == "ups_mfo-ord.php") || ($url == "display_mfo-ord.php") || ($url == "mnt_mfo-ord.php")) { ?>
         
    <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-line-chart"></i><span class="app-menu__label">Material Forecast Order</span> <i class="treeview-indicator fa fa-angle-right"></i></a> <?php }else { echo "<li class='treeview'>"; ?><a href="" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-line-chart"></i><span class="app-menu__label">Material Forecast Order</span> <i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
    
      <ul class="treeview-menu">
         <?php 
         if($data_function["f_mfo_smenu1"] == "Y")
			 {   ?>
         <?php if ($url == "ups_mfo-ord.php"){ ?>
        <li><a href="ups_mfo-ord.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Upload MFO</a></li><?php }else { echo "<li>";  ?><a href="ups_mfo-ord.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Upload MFO</a></li><?php } ?>
        <?php  }  ?>
        
        
         <?php 
         if($data_function["f_mfo_smenu2"] == "Y")
			 {   ?>
         <?php if ($url == "display_mfo-ord.php"){ ?>
        <li><a href="display_mfo-ord.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;View MFO</a></li><?php }else { echo "<li>";  ?><a href="display_mfo-ord.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;View MFO</a></li><?php } ?>
        <?php  }  ?>  
        
        
         <?php 
         if($data_function["f_mfo_smenu3"] == "Y")
			 {   ?>
         <?php if ($url == "mnt_mfo-ord.php"){ ?>
        <li><a href="mnt_mfo-ord.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Maintain MFO</a></li><?php }else { echo "<li>";  ?><a href="mnt_mfo-ord.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Maintain MFO</a></li><?php } ?>
        <?php  }  ?>     
        
             
         </ul>
         </li>
         <?php  }  ?> 
                  
         
    <!----   Delivery Instruction Menu ------>      
          <?php
			    if($data_function["main_di"] == "Y")
			 {
				?>
                
         <?php if (($url == "ups_dlv_dikanban.php") || ($url == "display_inbox-dikanban.php") || ($url == "print_tag-dikanban.php") || ($url == "display_mtn-dikanban.php") || ($url == "display_mtndo-dikanban.php") || ($url == "print_tag-dikanban_ppc.php") || ($url == "list_rpt_po_v_gr.php")) { ?>
         
    <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-truck"></i><span class="app-menu__label">Delivery Instruction</span> <i class="treeview-indicator fa fa-angle-right"></i></a> <?php }else { echo "<li class='treeview'>"; ?><a href="" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-truck"></i><span class="app-menu__label">Delivery Instruction</span> <i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
    
      <ul class="treeview-menu">
         
           <?php
			    if($data_function["f_dlv_di"] == "Y")
			 {
				?>
         <?php if ($url == "ups_dlv_dikanban.php"){ ?>
        <li><a href="ups_dlv_dikanban.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Upload DI/Kanban</a></li><?php }else { echo "<li>";  ?><a href="ups_dlv_dikanban.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Upload DI/Kanban</a></li><?php }  }?>
           <?php
			    if($data_function["f_dlv_di2"] == "Y")
			 {
				?>
         <?php if ($url == "display_inbox-dikanban.php"){ ?>
        <li><a href="display_inbox-dikanban.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Inbox</a></li><?php }else { echo "<li>";  ?><a href="display_inbox-dikanban.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Inbox</a></li><?php } } ?>
      <?php
			    if($data_function["f_dlv_di3"] == "Y")
			 {
				?>
         <?php if ($url == "print_tag-dikanban.php"){ ?>
        <li><a href="print_tag-dikanban.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print DO &amp; Tag</a></li><?php }else { echo "<li>";  ?><a href="print_tag-dikanban.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print DO &amp; Tag</a></li><?php }  }?>
        
        <?php
			    if($data_function["f_dlv_di6"] == "Y")
			 {
				?>
         <?php if ($url == "print_tag-dikanban_ppc.php"){ ?>
        <li><a href="print_tag-dikanban_ppc.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print DO &amp; Tag PPC</a></li><?php }else { echo "<li>";  ?><a href="print_tag-dikanban_ppc.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print DO &amp; Tag PPC</a></li><?php }  }?>
        
       <?php
			    if($data_function["f_dlv_di5"] == "Y")
			 {
				?>
         <?php if ($url == "display_mtndo-dikanban.php"){ ?>
        <li><a href="display_mtndo-dikanban.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Maintain DO</a></li><?php }else { echo "<li>";  ?><a href="display_mtndo-dikanban.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Maintain DO</a></li><?php }  }?>
         
		 <?php
			    if($data_function["f_dlv_di4"] == "Y")
			 {
				?>
         <?php if ($url == "display_mtn-dikanban.php"){ ?>
        <li><a href="display_mtn-dikanban.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Maintain DI</a></li><?php }else { echo "<li>";  ?><a href="display_mtn-dikanban.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Maintain DI</a></li><?php }  }?>

        <?php 
        if($data_function["f_dlv_di7"] == "Y")
			 {   ?>
        <?php if ($url == "list_rpt_po_v_gr.php"){ ?>
        <li><a href="list_rpt_po_v_gr.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;PO vs GR (Quantity)</a></li><?php }else { echo "<li>"; ?><a href="list_rpt_po_v_gr.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;PO vs GR (Quantity)</a></li><?php }  } ?>
    
 

   </ul> 
   
   </li>
         <?php  }   ?> 
        
         
        
        
           <?php
			    if($data_function["pc_rec"] == "Y")
		  {
				?>
    
     
      <?php if (($url == "display_po-rec.php") || ($url == "ppc_receiv-gd-rect.php") || ($url == "ppc_receiv-gd-rect_po.php") || ($url == "ppc_receivfoc-gd-rect.php") || ($url == "prt_GR_tag-gd-rect.php") || ($url == "prt_GRfoc_tag-gd-rect.php")) { ?> 
      
   <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">Receiving</span><i class="treeview-indicator fa fa-angle-right"></i> </a> <?php }else { echo "<li class='treeview'>";  ?> <a href=""  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">Receiving</span><i class="treeview-indicator fa fa-angle-right"></i> </a><?php  }  ?>
   
   
      <ul class="treeview-menu">
      
      <?php 

         if($data_function["f_gr_rec0"] == "Y")
			 {   ?>
             
       <?php if ($url == "display_po-rec.php"){ ?>
        <li><a href="display_po-rec.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;PO Listings </a></li><?php }else { echo "<li>";  ?><a href="display_po-rec.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;PO Listings </a></li><?php }  } ?>
      
    
      
      
      
        <?php 

         if($data_function["f_gr_rec"] == "Y")
			 {   ?>
      
    
         <?php if ($url == "ppc_receiv-gd-rect.php"){ ?>
        <li><a href="ppc_receiv-gd-rect.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt</a></li><?php }else { echo "<li>";  ?><a href="ppc_receiv-gd-rect.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt</a></li><?php } } ?>
    
    
     <?php 

         if($data_function["f_gr_rec2"] == "Y")
			 {   ?>
      
    
         <?php if ($url == "ppc_receiv-gd-rect_po.php"){ ?>
        <li><a href="ppc_receiv-gd-rect_po.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt by PO</a></li><?php }else { echo "<li>";  ?><a href="ppc_receiv-gd-rect_po.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt by PO</a></li><?php } } ?>
    
    
    
    
    
         <?php
			    if($data_function["f_grfoc_rec"] == "Y")
			 {
				?>
                
       <?php if ($url == "ppc_receivfoc-gd-rect.php"){ ?>
        <li><a href="ppc_receivfoc-gd-rect.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt FOC </a></li><?php }else { echo "<li>";  ?><a href="ppc_receivfoc-gd-rect.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt FOC </a></li><?php } } ?>
         
         <?php 
         if($data_function["f_print_rec"] == "Y")
			 {   ?>
           
		   <?php if ($url == "prt_GR_tag-gd-rect.php"){ ?>
        <li><a href="prt_GR_tag-gd-rect.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print GR Tag</a></li><?php }else { echo "<li>"; ?><a href="prt_GR_tag-gd-rect.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print GR Tag</a></li><?php }  } ?>
        
        
        <?php 
         if($data_function["f_printfoc_rec"] == "Y")
			 {   ?>
           
		   <?php if ($url == "prt_GRfoc_tag-gd-rect.php"){ ?>
        <li><a href="prt_GRfoc_tag-gd-rect.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print GR FOC Tag</a></li><?php }else { echo "<li>"; ?><a href="prt_GRfoc_tag-gd-rect.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print GR FOC Tag</a></li><?php }  } ?>
    
      
      </ul>
    </li>
      <?php  } ?>
      
      
      
        <?php 
         if($data_function["f_gturn_rec"] == "Y")
			 {   ?>
         <?php if ($url == "detail_GR_return-receive.php"){ ?>
        <li><a href="detail_GR_return-receive.php" class="app-menu__item active" ><i class="app-menu__icon fa fa-cart-arrow-down" aria-hidden="true"></i><span class="app-menu__label">&nbsp;Goods Return</span></a></li><?php }else { echo "<li>"; ?><a href="detail_GR_return-receive.php" class="app-menu__item" ><i class="app-menu__icon fa fa-cart-arrow-down" aria-hidden="true"></i><span class="app-menu__label">&nbsp;Goods Return</span></a></li><?php }  } ?>
        
        <?php 
         if($data_function["f_gi_rec"] == "Y")
			 {   ?>
         <?php if ($url == "detail_GR_GI-receive.php"){ ?>
        <li><a href="detail_GR_GI-receive.php" class="app-menu__item active" ><i class="app-menu__icon fa fa-cart-plus" aria-hidden="true"></i><span class="app-menu__label"> &nbsp;GI Consumable</span></a></li><?php }else { echo "<li>"; ?><a href="detail_GR_GI-receive.php" class="app-menu__item" ><i class="app-menu__icon fa fa-cart-plus" aria-hidden="true"></i><span class="app-menu__label"> &nbsp;GI Consumable</span></a></li><?php }  } ?>
        
        
         <?php 
         if($data_function["f_tp_progress"] == "Y")
			 {   ?>
         <?php if ($url == "prog_trn-posting.php"){ ?>
        <li><a href="prog_trn-posting.php" class="app-menu__item active"><i class="app-menu__icon fa fa-share-square-o" aria-hidden="true"></i><span class="app-menu__label">&nbsp;Transfer Posting</span></a></li><?php }else { echo "<li>";  ?><a href="prog_trn-posting.php" class="app-menu__item"><i class="app-menu__icon fa fa-share-square-o" aria-hidden="true"></i><span class="app-menu__label">&nbsp;Transfer Posting</span></a></li><?php } ?>
        
        <?php  }  ?>   
        
        
        <!---- subcontracting menu -------->
        <?php
			    if($data_function["main_subcont"] == "Y")
			 {
				?>
                
         <?php if (($url == "trans_posting_to_subcont.php") || ($url == "display_print_sdo.php")) { ?>
         
    <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-barcode"></i><span class="app-menu__label">Subcontracting</span> <i class="treeview-indicator fa fa-angle-right"></i></a><?php }else { echo "<li class='treeview'>"; ?><a href="" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-barcode"></i><span class="app-menu__label">Subcontracting</span> <i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
    
      <ul class="treeview-menu">
        
          <?php
			    if($data_function["f_subcont"] == "Y")
			 {
				?>
         <?php if ($url  =="trans_posting_to_subcont.php"){ ?>
        <li><a href="trans_posting_to_subcont.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer to Subcont</a></li><?php }else { echo "<li>";  ?><a href="trans_posting_to_subcont.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer to Subcont</a></li><?php } } ?>
       
             <?php
			    if($data_function["f_subcont2"] == "Y")
			 {
				?>
         <?php if ($url == "display_print_sdo.php"){ ?>
        <li><a href="display_print_sdo.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print SDO</a></li><?php }else { echo "<li>";  ?><a href="display_print_sdo.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print SDO</a></li><?php } } ?>

             
         </ul>
         </li>
         <?php  }  ?> 
        
         
        
        
        
        <!--transfer Material --->
        
         <?php 
         if($data_function["f_trans_rec"] == "Y")
			 {   ?>
         <?php if ($url == "detail_trans_mat-receive.php"){ ?>
        <li><a href="detail_trans_mat-receive.php" class="app-menu__item active" ><i class="app-menu__icon fa fa-truck" aria-hidden="true"></i><span class="app-menu__label">Transfer Material</span></a></li><?php }else { echo "<li>"; ?><a href="detail_trans_mat-receive.php" class="app-menu__item" ><i class="app-menu__icon fa fa-truck" aria-hidden="true"></i><span class="app-menu__label">Transfer Material</span></a></li><?php }  } ?>
   
   
   
       <!-- Delivery Order (DO) --->
   
      
       <?php
			    if($data_function["main_dlv"] == "Y")
			 {
				?>
    
     
      <?php if (($url == "display_soi-dlv.php") || ($url == "crt_do_perd2-dlvP2.php") || ($url == "crt_do_perd2-dlvP2Sales.php") || ($url == "crt_do_perd2-dlvP2MSB.php") || ($url == "crt_do_oth_cust-dlv.php") || ($url =="prt_do_tran-dlv.php") || ($url =="do_disposal-dlv.php") || ($url =="dis_approve_tran-dlv.php") || ($url == "close_soi-create.php") || ($url == "ups_pdio_serendah.php") || ($url == "create_dlv_bypdio_serendah.php")) { ?>  
   <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-upload"></i><span class="app-menu__label">Delivery</span><i class="treeview-indicator fa fa-angle-right"></i> </a> <?php }else { echo "<li class='treeview'>";  ?> <a href=""  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-upload"></i><span class="app-menu__label">Delivery</span><i class="treeview-indicator fa fa-angle-right"></i> </a><?php }  ?>
   
      <ul class="treeview-menu">
       <?php 
         if($data_function["f_dlv_do7"] == "Y")
			 {    
			 ?>
      
         <?php if ($url == "display_soi-dlv.php"){ ?>
        <li><a href="display_soi-dlv.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Sales Order Listing </a></li><?php }else { echo "<li>";  ?><a href="display_soi-dlv.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Sales Order Listing</a></li><?php }  ?>
        <?php  }   ?>
        
        <?php 
         if($data_function["f_dlv_do"] == "Y")
			 {    
			 ?>
      
         <?php if ($url == "crt_do_perd2-dlvP2.php"){ ?>
        <li><a href="crt_do_perd2-dlvP2.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;DO Perodua Global </a></li><?php }else { echo "<li>";  ?><a href="crt_do_perd2-dlvP2.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;DO Perodua Global</a></li><?php }  ?>
        <?php  }   ?>
        
         <?php 
         if($data_function["f_dlv_do2"] == "Y")
			 {    
			 ?>
      
         <?php if ($url == "crt_do_perd2-dlvP2Sales.php"){ ?>
        <li><a href="crt_do_perd2-dlvP2Sales.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;DO Perodua Sales </a></li><?php }else { echo "<li>";  ?><a href="crt_do_perd2-dlvP2Sales.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;DO Perodua Sales </a></li><?php }  ?>
        <?php  }   ?>
        
        
  <?php 
         if($data_function["f_dlv_do5"] == "Y")
			 {    
			 ?>
      
         <?php if ($url == "crt_do_perd2-dlvP2MSB.php"){ ?>
        <li><a href="crt_do_perd2-dlvP2MSB.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;DO Perodua Manufacturing </a></li><?php }else { echo "<li>";  ?><a href="crt_do_perd2-dlvP2MSB.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;DO Perodua Manufacturing </a></li><?php }  ?>
        <?php  }   ?>

        <?php 
          if($data_function["f_dlv_do3"] == "Y")
			 {    
			 ?>
           <?php if ($url == "crt_do_oth_cust-dlv.php"){ ?>
        <li><a href="crt_do_oth_cust-dlv.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;DO Other Customers</a></li><?php }else { echo "<li>"; ?><a href="crt_do_oth_cust-dlv.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;DO Other Customers</a></li><?php }  ?>
        <?php   }   ?> 
		
		
        
        <?php 
        if($data_function["f_dlv_do4"] == "Y")
			 {    
			 ?>
         <?php if ($url == "prt_do_tran-dlv.php"){ ?>
        <li><a href="prt_do_tran-dlv.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print DO</a></li><?php }else { echo "<li>";  ?><a href="prt_do_tran-dlv.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print DO</a></li><?php }  ?>
        <?php  }  ?>
        
        <?php 
        if($data_function["f_dlv_do6"] == "Y")
			 {    
			 ?>
         <?php if ($url == "close_soi-create.php"){ ?>
        <li><a href="close_soi-create.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Closed Sales Order</a></li><?php }else { echo "<li>";  ?><a href="close_soi-create.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Closed Sales Order</a></li><?php }  ?>
        <?php  }  ?>

     <?php 
        if($data_function["f_dlv_do8"] == "Y")
			 {    
			 ?>
         <?php if ($url == "ups_pdio_serendah.php"){ ?>
        <li><a href="ups_pdio_serendah.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Upload PDIO</a></li><?php }else { echo "<li>";  ?><a href="ups_pdio_serendah.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Upload PDIO</a></li><?php } } ?>
      
        <?php 
        if($data_function["f_dlv_do9"] == "Y")
			 {    
			 ?>
      <?php  if ($url == "create_dlv_bypdio_serendah.php"){ ?>
         <li><a href="create_dlv_bypdio_serendah.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Create DO Perodua </a></li><?php }else { echo "<li>";  ?><a href="create_dlv_bypdio_serendah.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Create DO Perodua </a></li><?php }  ?>

      
        <?php  }  ?>
        

        
        
      </ul>
    </li>
      <?php  } ?>
        
        
           <!-- Disposal receiving --->
           
        <?php 
         if($data_function["f_dis_rec"] == "Y")
			 {   ?>
         <?php if ($url == "detail_GR_disposal-receive.php"){ ?>
        <li><a href="detail_GR_disposal-receive.php" class="app-menu__item active" ><i class="app-menu__icon fa fa-trash" aria-hidden="true"></i><span class="app-menu__label">Disposal</span></a></li><?php }else { echo "<li>"; ?><a href="detail_GR_disposal-receive.php" class="app-menu__item" ><i class="app-menu__icon fa fa-trash" aria-hidden="true"></i><span class="app-menu__label">Disposal</span></a></li><?php }  } ?>
        
           
           <!-- Disposal Approval receiving --->
               
        <?php 
         if($data_function["f_dis_approval_rec"] == "Y")
			 {   ?>
          <?php if ($url == "dis_approve_tran-receive.php"){ ?>
        <li><a href="dis_approve_tran-receive.php" class="app-menu__item active" ><i class="app-menu__icon fa fa-thumbs-o-up" aria-hidden="true"></i><span class="app-menu__label">Disposal Approval</span></a></li><?php }else { echo "<li>"; ?><a href="dis_approve_tran-receive.php" class="app-menu__item" ><i class="app-menu__icon fa fa-thumbs-o-up" aria-hidden="true"></i><span class="app-menu__label">Disposal Approval</span></a></li><?php }  } ?>
       
        
  
      
   <!-----  Transit ------>
   <?php
			    if($data_function["main_transit"] == "Y")
			 {
				?>
    
     
      <?php if (($url == "prt_tag_bftsit_dis_tran-dlv.php") || ($url =="bf_transit_do-dlv.php")) { ?>  
   <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-truck"></i><span class="app-menu__label">Transit</span><i class="treeview-indicator fa fa-angle-right"></i> </a> <?php }else { echo "<li class='treeview'>";  ?> <a href=""  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-truck"></i><span class="app-menu__label">Transit</span><i class="treeview-indicator fa fa-angle-right"></i> </a><?php }  ?>
   
      <ul class="treeview-menu">
      
        <?php 
         if($data_function["f_bf_tran_dlv"] == "Y")
			 {    
			 ?>
        
         <?php if ($url == "bf_transit_do-dlv.php"){ ?>
        <li><a href="bf_transit_do-dlv.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>BF Transit</a></li><?php }else { echo "<li>";  ?><a href="bf_transit_do-dlv.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>BF Transit</a></li><?php }  ?>
        <?php   }  ?>
        
        <?php 
         if($data_function["f_bf_tran_dlv2"] == "Y")
			 {    
			 ?>
         <?php if ($url == "prt_tag_bftsit_dis_tran-dlv.php"){ ?>
        <li><a href="prt_tag_bftsit_dis_tran-dlv.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>Print Tag</a></li><?php }else { echo "<li>";  ?><a href="prt_tag_bftsit_dis_tran-dlv.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>Print Tag</a></li><?php }  ?>
        <?php  }  ?> 
        
        
        
       
        
      </ul>
    </li>
      <?php  } ?>   
      


   <!-----  Backflush ------>
   <?php
			    if($data_function["main_bflush"] == "Y")
			 {
				?>

      
        <?php if (($url == "confirm_backflush_tran.php") || ($url == "confirm_backflush_tran_NG.php") || ($url == "confirm_backflush_tran_Pend.php") || ($url == "confirm_backflush_tran_Hwok.php") || ($url == "print_tag_backflush_trn_fg.php")) { ?>  
   <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-truck"></i><span class="app-menu__label">Backflush</span><i class="treeview-indicator fa fa-angle-right"></i> </a> <?php }else { echo "<li class='treeview'>";  ?> <a href=""  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-truck"></i><span class="app-menu__label">Backflush</span><i class="treeview-indicator fa fa-angle-right"></i> </a><?php }  ?>
   
      <ul class="treeview-menu">
      

      
        <!-- BF OK --->
       
          <?php 
         if($data_function["f_bf_ok"] == "Y")
			 {   ?>
         <?php if ($url == "confirm_backflush_tran.php"){ ?>
        <li><a href="confirm_backflush_tran.php"  class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><span class="app-menu__label">Backflush (OK)</span></a></li><?php }else { echo "<li>";  ?><a href="confirm_backflush_tran.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><span class="app-menu__label">Backflush (OK)</span></a></li><?php } ?>
        <?php  }  ?>   
        
          <!-- BF NG ---> 
       
       <?php 
         if($data_function["f_bf_ng"] == "Y")
			 {   ?>
        
         <?php if ($url == "confirm_backflush_tran_NG.php"){ ?>
        <li><a href="confirm_backflush_tran_NG.php"  class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><span class="app-menu__label">Backflush (NG)</span></a></li><?php }else { echo "<li>";  ?><a href="confirm_backflush_tran_NG.php"   class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><span class="app-menu__label">Backflush (NG)</span></a></li><?php } ?>
        <?php   } ?>
        
          <!-- BF PENDING --->
        
        <?php 
         if($data_function["f_bf_pending"] == "Y")
			 {   ?>
        
       <?php if ($url == "confirm_backflush_tran_Pend.php"){ ?>
        <li><a href="confirm_backflush_tran_Pend.php"  class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><span class="app-menu__label">Backflush (PENDING)</span></a></li><?php }else { echo "<li>";  ?><a href="confirm_backflush_tran_Pend.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><span class="app-menu__label">Backflush (PENDING)</span></a></li><?php } ?> 
        
        <?php   }  ?>
        
          <!-- BF HANDWORK --->
        
        <?php 
         if($data_function["f_bf_handwork"] == "Y")
			 {   ?>
             
         <?php if ($url == "confirm_backflush_tran_Hwok.php"){ ?>
        <li><a href="confirm_backflush_tran_Hwok.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><span class="app-menu__label">Backflush (HANDWORK)</span></a></li><?php }else { echo "<li>";  ?><a href="confirm_backflush_tran_Hwok.php"  class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><span class="app-menu__label">Backflush (HANDWORK)</span></a></li><?php } ?> 
        <?php   } ?>
        
        
          <?php 
         if($data_function["f_print_prd"] == "Y")
			 {    
			 ?>
        
        <?php if ($url == "print_tag_backflush_trn_fg.php"){ ?>
        <li><a href="print_tag_backflush_trn_fg.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><span class="app-menu__label">Print Tag</span></a></li><?php }else { echo "<li>"; ?><a href="print_tag_backflush_trn_fg.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i><span class="app-menu__label">Print Tag</span></a></li><?php }  ?>
    <?php	 } ?>  
    
              </ul>
    </li>
          <?php  } ?>   
        
        
       <!-- BF PENDING Confirm --->  
            <?php 
         if($data_function["f_bf_pend_conf_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "confirm_backflush_tran_Pend-confirm.php"){ ?>
        <li><a href="confirm_backflush_tran_Pend-confirm.php"  class="app-menu__item active"><i class="app-menu__icon fa fa-qrcode" aria-hidden="true"></i><span class="app-menu__label">Pending Confirmation</span></a></li><?php }else { echo "<li>"; ?><a href="confirm_backflush_tran_Pend-confirm.php" class="app-menu__item"><i class="app-menu__icon fa fa-qrcode" aria-hidden="true"></i><span class="app-menu__label">Pending Confirmation</span></a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
          <!-- BF REWORK --->
             
               <?php 
         if($data_function["f_pend_rwork_conf_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "backflush_tran_Pend-confirm_rework.php"){ ?>
        <li><a href="backflush_tran_Pend-confirm_rework.php"  class="app-menu__item active"><i class="app-menu__icon fa fa-qrcode" aria-hidden="true"></i><span class="app-menu__label">Rework Confirmation</span></a></li><?php }else { echo "<li>"; ?><a href="backflush_tran_Pend-confirm_rework.php"  class="app-menu__item"><i class="app-menu__icon fa fa-qrcode" aria-hidden="true"></i><span class="app-menu__label">Rework Confirmation</span></a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
           <!-- BF HANDWORK Confirm --->    
           <?php 
         if($data_function["f_pend_hwork_conf_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "confirm_backflush_tran_Hwok-confirm.php"){ ?>
        <li><a href="confirm_backflush_tran_Hwok-confirm.php"  class="app-menu__item active"><i class="app-menu__icon fa fa-qrcode" aria-hidden="true"></i><span class="app-menu__label">Handwork</span></a></li><?php }else { echo "<li>"; ?><a href="confirm_backflush_tran_Hwok-confirm.php"  class="app-menu__item"><i class="app-menu__icon fa fa-qrcode" aria-hidden="true"></i><span class="app-menu__label">Handwork</span></a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
        
       
       
       
        <!-- Disposal PROD ---> 
     
   <?php
			    if($data_function["main_disposal"] == "Y")
			 {
				?>
        
          <?php if (($url == "detail_bf_disposal-prd.php") || ($url == "detail_comp_reject_prd.php")) { ?>  
   <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-trash"></i><span class="app-menu__label">Disposals</span><i class="treeview-indicator fa fa-angle-right"></i> </a> <?php }else { echo "<li class='treeview'>";  ?> <a href=""  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-trash"></i><span class="app-menu__label">Disposals</span><i class="treeview-indicator fa fa-angle-right"></i> </a><?php }  ?>
   
      <ul class="treeview-menu">
        
        
       
         <?php 
         if($data_function["f_dis_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_bf_disposal-prd.php"){ ?>
        <li><a href="detail_bf_disposal-prd.php" class="treeview-item active"><i class="app-menu__icon fa fa-trash" aria-hidden="true"></i><span class="app-menu__label">Reject Output</span></a></li><?php }else { echo "<li>"; ?><a href="detail_bf_disposal-prd.php" class="treeview-item"><i class="app-menu__icon fa fa-trash" aria-hidden="true"></i><span class="app-menu__label">Reject Output</span></a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
          <!-- COMPONENT REJECT --->
       
         <?php 
         if($data_function["f_comp_rej_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_comp_reject_prd.php"){ ?>
        <li><a href="detail_comp_reject_prd.php" class="treeview-item active"><i class="app-menu__icon fa fa-minus" aria-hidden="true"></i><span class="app-menu__label">Component Reject</span></a></li><?php }else { echo "<li>"; ?><a href="detail_comp_reject_prd.php" class="treeview-item"><i class="app-menu__icon fa fa-minus" aria-hidden="true"></i><span class="app-menu__label">Component Reject</span></a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
          </ul>
    </li>
     
        <?php	 } ?>




           <!-- Disposal Engineering---> 
     
   <?php
			    if($data_function["main_disposal_prd2"] == "Y")
			 {
				?>
        
          <?php if (($url == "detail_disposal_reject-prdEng.php") || ($url == "detail_comp_reject_prdEng.php")) { ?>  
   <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-trash"></i><span class="app-menu__label">Disposals Eng</span><i class="treeview-indicator fa fa-angle-right"></i> </a> <?php }else { echo "<li class='treeview'>";  ?> <a href=""  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-trash"></i><span class="app-menu__label">Disposals Eng</span><i class="treeview-indicator fa fa-angle-right"></i> </a><?php }  ?>
   
      <ul class="treeview-menu">
        
        
       
         <?php 
         if($data_function["f_dis_rej_prd2"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_disposal_reject-prdEng.php"){ ?>
        <li><a href="detail_disposal_reject-prdEng.php" class="treeview-item active"><i class="app-menu__icon fa fa-trash" aria-hidden="true"></i><span class="app-menu__label">Reject Part</span></a></li><?php }else { echo "<li>"; ?><a href="detail_disposal_reject-prdEng.php" class="treeview-item"><i class="app-menu__icon fa fa-trash" aria-hidden="true"></i><span class="app-menu__label">Reject Part</span></a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
          <!-- COMPONENT REJECT --->
       
         <?php 
         if($data_function["f_comp_rej_prd2"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_comp_reject_prdEng.php"){ ?>
        <li><a href="detail_comp_reject_prdEng.php" class="treeview-item active"><i class="app-menu__icon fa fa-minus" aria-hidden="true"></i><span class="app-menu__label">Reject Component</span></a></li><?php }else { echo "<li>"; ?><a href="detail_comp_reject_prdEng.php" class="treeview-item"><i class="app-menu__icon fa fa-minus" aria-hidden="true"></i><span class="app-menu__label">Reject Component</span></a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
      
        
          </ul>
    </li>
     
        <?php	 } ?>
        
     
        
         <!-- List Disposal PROD ---> 
        
         <?php 
         if($data_function["f_dis_list_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_list_bf_disposal-prd.php"){ ?>
        <li><a href="detail_list_bf_disposal-prd.php" class="app-menu__item active"><i class="app-menu__icon fa fa-list" aria-hidden="true"></i><span class="app-menu__label">Disposals List</span></a></li><?php }else { echo "<li>"; ?><a href="detail_list_bf_disposal-prd.php" class="app-menu__item"><i class="app-menu__icon fa fa-list" aria-hidden="true"></i><span class="app-menu__label">Disposals List</span></a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
         <!-- Disposal Approval Prod (Assy/Stm) PROD ---> 
         
         <?php 
         if($data_function["f_dis_approval_prd"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_aprv_bf_disposal-prd.php"){ ?>
        <li><a href="detail_aprv_bf_disposal-prd.php" class="app-menu__item active"><i class="app-menu__icon fa fa-thumbs-o-up" aria-hidden="true"></i><span class="app-menu__label">Disposals Approval</span></a></li><?php }else { echo "<li>"; ?><a href="detail_aprv_bf_disposal-prd.php" class="app-menu__item"><i class="app-menu__icon fa fa-thumbs-o-up" aria-hidden="true"></i><span class="app-menu__label">Disposals Approval</span></a></li><?php }  ?>	 		<?php	 } ?>
        
        
          <!-- Disposal Approval Stamping PROD ---> 
       <?php 
         if($data_function["f_dis_approval_prd2"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_aprv_bf_disposal-prd-stm.php"){ ?>
        <li><a href="detail_aprv_bf_disposal-prd-stm.php" class="app-menu__item active"><i class="app-menu__icon fa fa-thumbs-o-up" aria-hidden="true"></i><span class="app-menu__label">Disposals Approval</span></a></li><?php  }else { echo "<li>"; ?><a href="detail_aprv_bf_disposal-prd-stm.php" class="app-menu__item"><i class="app-menu__icon fa fa-thumbs-o-up" aria-hidden="true"></i><span class="app-menu__label">Disposals Approval</span></a></li><?php }  ?>	 		<?php	} ?>
        
        
         <?php 
         if($data_function["f_dis_approval_prd3"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_aprv_bf_disposal-prd-assy.php"){ ?>
        <li><a href="detail_aprv_bf_disposal-prd-assy.php" class="treeview-item active"><i class="app-menu__icon fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;Disposals Approval</a></li><?php  }else { echo "<li>"; ?><a href="detail_aprv_bf_disposal-prd-assy.php" class="app-menu__item"><i class="app-menu__icon fa fa-thumbs-o-up" aria-hidden="true"></i><span class="app-menu__label">Disposals Approval</span></a></li><?php }  ?>	 		<?php	} ?>
        
       
         <!-- Print Tag PROD ---> 
         
         
       
       
       
       
         <!-- Return Advise ---> 
       
        <?php
			    if($data_function["main_gra"] == "Y")
			 {
				?>
                
         <?php if (($url == "gra_tran_crt_qc.php") || ($url == "gra_tran_reprint_qc.php")) { ?>
         
    <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-line-chart"></i><span class="app-menu__label">Return Advise</span> <i class="treeview-indicator fa fa-angle-right"></i></a> <?php }else { echo "<li class='treeview'>"; ?><a href="" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-line-chart"></i><span class="app-menu__label">Return Advise</span> <i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
    
      <ul class="treeview-menu">
         <?php 
         if($data_function["f_gra_qc"] == "Y")
			 {   ?>
         <?php if ($url == "gra_tran_crt_qc.php"){ ?>
        <li><a href="gra_tran_crt_qc.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Return Advise (GRA)</a></li><?php }else { echo "<li>";  ?><a href="gra_tran_crt_qc.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Return Advise (GRA)</a></li><?php } ?>
        <?php  }  ?>
        
        
         <?php 
         if($data_function["f_print_qc"] == "Y")
			 {   ?>
         <?php if ($url == "gra_tran_reprint_qc.php"){ ?>
        <li><a href="gra_tran_reprint_qc.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print GRA</a></li><?php }else { echo "<li>";  ?><a href="gra_tran_reprint_qc.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Print GRA</a></li><?php } ?>
        <?php  }  ?>  
        
         </ul>
      
         </li>
         <?php  }  ?> 


     <?php
			    if($data_function["main_disposal_qc"] == "Y")
			 {
				?>
        
          <?php if (($url == "detail_comp_reject_qc.php") || ($url == "dis_tran_crt_qc.php")) { ?>  
   <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-trash"></i><span class="app-menu__label">Disposals</span><i class="treeview-indicator fa fa-angle-right"></i> </a> <?php }else { echo "<li class='treeview'>";  ?> <a href=""  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-trash"></i><span class="app-menu__label">Disposals</span><i class="treeview-indicator fa fa-angle-right"></i> </a><?php }  ?>
   
      <ul class="treeview-menu">
      
          <!-- Disposal QC ---> 
       
          <?php 
         if($data_function["f_dis_approval_qc"] == "Y") 
			 {   ?>
         <?php if ($url == "dis_tran_crt_qc.php"){ ?>
        <li><a href="dis_tran_crt_qc.php" class="treeview-item active"><i class="app-menu__icon fa fa-trash" aria-hidden="true"></i><span class="app-menu__label">Reject Part</span></a></li><?php }else { echo "<li>";  ?><a href="dis_tran_crt_qc.php" class="treeview-item"><i class="app-menu__icon fa fa-trash" aria-hidden="true"></i><span class="app-menu__label">Reject Part</span></a></li><?php } ?>
        <?php  }  ?> 
        
          <!-- COMPONENT REJECT QC --->
       
         <?php 
         if($data_function["f_comp_rej_qc"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_comp_reject_qc.php"){ ?>
        <li><a href="detail_comp_reject_qc.php" class="treeview-item active"><i class="app-menu__icon fa fa-minus" aria-hidden="true"></i><span class="app-menu__label">Reject Component</span></a></li><?php }else { echo "<li>"; ?><a href="detail_comp_reject_qc.php" class="treeview-item"><i class="app-menu__icon fa fa-minus" aria-hidden="true"></i><span class="app-menu__label">Reject Component</span></a></li><?php }  ?>	 
			 
		<?php	 } ?>
        
            </ul>
      
         </li>
         <?php  }  ?>  
         


       
          <!-- Disposal Approval Exec QC --->  
     <?php 
         if($data_function["f_dis_approval_ex_qc"] == "Y")
			 {   ?>
          <?php if ($url == "dis_approve_exe_qc-tran.php"){ ?>
        <li><a href="dis_approve_exe_qc-tran.php" class="app-menu__item active" ><i class="app-menu__icon fa fa-thumbs-o-up" aria-hidden="true"></i><span class="app-menu__label">Disposal Approval</span></a></li><?php }else { echo "<li>";  ?><a href="dis_approve_exe_qc-tran.php" class="app-menu__item" ><i class="app-menu__icon fa fa-thumbs-o-up" aria-hidden="true"></i><span class="app-menu__label">Disposal Approval</span></a></li><?php }  ?>
        <?php   }  ?>
       
         <!-- Disposal Approval HEAD QC --->  
               <?php 
       /*  if($data_function["f_dis_approval_h_qc"] == "Y")
			 {   ?>
          <?php if ($url == "dis_approve_qc-tran.php"){ ?>
        <li><a href="dis_approve_qc-tran.php" class="app-menu__item active" ><i class="app-menu__icon fa fa-thumbs-o-up" aria-hidden="true"></i><span class="app-menu__label">Disposal Approval QC</span></a></li><?php }else { echo "<li>";  ?><a href="dis_approve_qc-tran.php" class="app-menu__item" ><i class="app-menu__icon fa fa-thumbs-o-up" aria-hidden="true"></i><span class="app-menu__label">Disposal Approval QC</span></a></li><?php }  ?>

        <?php   }*/  ?>
        
        
        
         <?php
			   if($data_function["f_dis_approval_h_qc"] == "Y")
			 {
				?>
                
         <?php if (($url == "dis_approve_qc-tran.php") || ($url == "canC_hqc_disposal4-prd.php") || ($url == "FTP_hqc_monitor_DIS.php")) { ?>
         
    <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-thumbs-o-up"></i><span class="app-menu__label">Disposal Approval</span> <i class="treeview-indicator fa fa-angle-right"></i></a> <?php }else { echo "<li class='treeview'>"; ?><a href="" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-thumbs-o-up"></i><span class="app-menu__label">Disposal Approval</span> <i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
    
      <ul class="treeview-menu">
       
         <?php 
         if($data_function["f_hqc_smenu1"] == "Y")
			 {    
			 ?>
           <?php if ($url == "dis_approve_qc-tran.php"){ ?>
        <li><a href="dis_approve_qc-tran.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal Approval</a></li><?php }else { echo "<li>";  ?><a href="dis_approve_qc-tran.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal Approval</a></li><?php } }?>
         
       
        <?php 
         if($data_function["f_hqc_smenu2"] == "Y")
			 {    
			 ?>
         <?php if ($url == "canC_hqc_disposal4-prd.php"){ ?>
        <li><a href="canC_hqc_disposal4-prd.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Cancellation</a></li><?php }else { echo "<li>";  ?><a href="canC_hqc_disposal4-prd.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Cancellation</a></li><?php } }?>
  
  <?php 
         if($data_function["f_hqc_smenu3"] == "Y")
			 {    
			 ?>
   <?php if ($url == "FTP_hqc_monitor_DIS.php"){ ?>
        <li><a href="FTP_hqc_monitor_DIS.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Document List</a></li><?php }else { echo "<li>";  ?><a href="FTP_hqc_monitor_DIS.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Document List</a></li><?php } } ?>
        
         </ul>
         </li>
       
        
     
         
         
         <?php  }  ?> 
        
        
        
  
        
        
        
       
        <!-- Cancellation ---> 
        
         <?php
			   if($data_function["main_canc"] == "Y")
			 {
				?>
                
         <?php if (($url == "detail_GR_cancel-receive.php") || ($url == "detail_GRfoc_cancel-receive.php") || ($url == "detail_GReturn_cancel-receive.php") || ($url == "detail_GI_con_cancel-receive.php") || ($url == "detail_TM_cancel-receive.php") || ($url == "can_prog_trn-posting.php") || ($url == "can_tp_subcont.php") || ($url == "detail_do_cancel_alldo-dlv.php") || ($url == "detail_disposal_cancel-receive.php") || ($url == "detail_PRD_cancel_bflush.php") || ($url == "dis_gra_tran_qc-pst.php") || ($url == "can_gra_tran_qc-pst.php") || ($url == "dis_gra_tran_PRD_ENG.php")) { ?>
         
    <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-times"></i><span class="app-menu__label">Cancellation</span> <i class="treeview-indicator fa fa-angle-right"></i></a> <?php }else { echo "<li class='treeview'>"; ?><a href="" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-times"></i><span class="app-menu__label">Cancellation</span> <i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
    
      <ul class="treeview-menu">
      
       <!-- Cancel GR --->    
      
       <?php
         if($data_function["f_canc_smenu1"] == "Y")
			 {   ?>
          <?php if ($url == "detail_GR_cancel-receive.php"){ ?>
        <li><a href="detail_GR_cancel-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt</a></li><?php }else { echo "<li>"; ?><a href="detail_GR_cancel-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt</a></li><?php }  } ?>
        
         <!-- Cancel GR FOC --->    
      
       <?php
          if($data_function["f_canc_smenu2"] == "Y")
			 {   ?>
          <?php if ($url == "detail_GRfoc_cancel-receive.php"){ ?>
        <li><a href="detail_GRfoc_cancel-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt FOC</a></li><?php }else { echo "<li>"; ?><a href="detail_GRfoc_cancel-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt FOC</a></li><?php }  } ?>
       
       
       
         <!-- Cancel Goods Return Delivery --->  
     
      <?php
         if($data_function["f_canc_smenu3"] == "Y")
			 {   ?>
          <?php if ($url == "detail_GReturn_cancel-receive.php"){ ?>
        <li><a href="detail_GReturn_cancel-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Return</a></li><?php }else { echo "<li>"; ?><a href="detail_GReturn_cancel-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Return</a></li><?php }  } ?>  
        
        
           <!-- Cancel GI Consumable --->  
     
      <?php
          if($data_function["f_canc_smenu4"] == "Y")
			 {   ?>
          <?php if ($url == "detail_GI_con_cancel-receive.php"){ ?>
        <li><a href="detail_GI_con_cancel-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;GI Consumable</a></li><?php }else { echo "<li>"; ?><a href="detail_GI_con_cancel-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;GI Consumable</a></li><?php }  } ?>  
        
       
       
       <!-- Cancel Progress --->    
        
       <?php 
          if($data_function["f_canc_smenu5"] == "Y")
			 {   ?>
             
       <?php if ($url == "can_prog_trn-posting.php"){ ?>
        <li><a href="can_prog_trn-posting.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer Posting</a></li><?php }else { echo "<li>";  ?><a href="can_prog_trn-posting.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer Posting</a></li><?php }  ?>
            
        <?php   } ?>
        
        
         <!-- Cancel Transfer Subcont --->    
        
       <?php 
         if($data_function["f_canc_smenu6"] == "Y")
			 {   ?>
             
       <?php if ($url == "can_tp_subcont.php"){ ?>
        <li><a href="can_tp_subcont.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer to Subcont</a></li><?php }else { echo "<li>";  ?><a href="can_tp_subcont.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer to Subcont</a></li><?php }  ?>
            
        <?php   } ?>
        
        
           <!-- Cancel Transfer Material --->  
     
      <?php
         if($data_function["f_canc_smenu7"] == "Y")
			 {   ?>
          <?php if ($url == "detail_TM_cancel-receive.php"){ ?>
        <li><a href="detail_TM_cancel-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer Material</a></li><?php }else { echo "<li>"; ?><a href="detail_TM_cancel-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer Material</a></li><?php }  } ?>  
       
        
            <!-- Cancel Delivery Order--->    
       
       <?php 
         if($data_function["f_canc_smenu8"] == "Y")
			 {    
			 ?>
        
         <?php if ($url == "detail_do_cancel_alldo-dlv.php"){ ?>
        <li><a href="detail_do_cancel_alldo-dlv.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Delivery Order</a></li><?php }else { echo "<li>";  ?><a href="detail_do_cancel_alldo-dlv.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Delivery Order</a></li><?php }  ?>
        <?php   }  ?>
        
 
        
        
         <!-- Cancel Disposal PPC --->    
        
       <?php 
        if($data_function["f_canc_smenu9"] == "Y")
			 {   ?>
          <?php if ($url == "detail_disposal_cancel-receive.php"){ ?>
        <li><a href="detail_disposal_cancel-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php }else { echo "<li>"; ?><a href="detail_disposal_cancel-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php }  } ?>
      
     
      
      <!-- Cancel Production--->    
        
         <?php 
         if($data_function["f_canc_smenu10"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_PRD_cancel_bflush.php"){ ?>
        <li><a href="detail_PRD_cancel_bflush.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Production</a></li><?php }else { echo "<li>"; ?><a href="detail_PRD_cancel_bflush.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Production</a></li><?php }  ?>	 
			 
		<?php	 } ?>
               
        
         <!-- Cancel Good Return Advise---> 
          <?php 
          if($data_function["f_canc_smenu11"] == "Y")
			 {   ?>
         <?php if ($url == "can_gra_tran_qc-pst.php"){ ?>
        <li><a href="can_gra_tran_qc-pst.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Return Advise</a></li><?php }else { echo "<li>";  ?><a href="can_gra_tran_qc-pst.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Return Advise</a></li><?php } ?>
        <?php  }  ?>  
        
     
          <!-- Cancel Disposal QC ---> 
         
         <?php 
          if($data_function["f_canc_smenu12"] == "Y")
			 {   ?>
         <?php if ($url == "dis_gra_tran_qc-pst.php"){ ?>
        <li><a href="dis_gra_tran_qc-pst.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php }else { echo "<li>";  ?><a href="dis_gra_tran_qc-pst.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php } ?>
        <?php  }  ?>   
        
        
        
          <!-- Cancel Disposal PRD ENG ---> 
         
         <?php 
          if($data_function["f_canc_smenu13"] == "Y")
			 {   ?>
         <?php if ($url == "dis_gra_tran_PRD_ENG.php"){ ?>
        <li><a href="dis_gra_tran_PRD_ENG.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php }else { echo "<li>";  ?><a href="dis_gra_tran_PRD_ENG.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php } ?>
        <?php  }  ?>  
        
        </ul>
      
         </li>
        
         <?php  }    ?> 
      
    
               <!-- REPORT ---> 
       
     
      <?php
	   if($data_function["main_rpt"] == "Y")
		{			?>
    
     
      <?php if (($url == "detail_DI_doc-dikanban.php") || ($url == "detail_DI_doc-dikanban_PPC.php") || ($url == "detail_dlv_instrucdoc-dikanban.php") || ($url == "detail_do_doc-dlv.php") || ($url == "detail_GR_doc-receive.php") || ($url == "detail_GRfoc_doc-receive.php") || ($url == "detail_GR_GI_doc-receive.php") || ($url == "detail_GR_TM_doc-receive.php") || ($url == "detail_GReturn_doc-receive.php") || ($url == "detail_do_alldoc-dlv.php") || ($url == "detail_do_alldoc-dlv_FINA.php") || ($url == "doc_list_prog_trn-posting.php") || ($url == "doc_tp_subcont.php") || ($url == "FTP_gratranfer_monitor.php") || ($url == "FTP_gratranfer_monitor2.php") || ($url == "FTP_gratranfer_monitor3.php") || ($url == "list_rpt_bf_all_v2.php") || ($url == "list_rpt_PEND_all.php") || ($url =="list_rpt_RWK_all.php") || ($url =="list_rpt_HWORK_all.php") || ($url =="list_rpt_DIS_all.php") || ($url =="list_rpt_pln_sta_all.php") || ($url =="list_rpt_DIS_ENG.php") ) { ?> 
   <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">Report</span><i class="treeview-indicator fa fa-angle-right"></i> </a> <?php }else { echo "<li class='treeview'>";  ?> <a href=""  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">Report</span><i class="treeview-indicator fa fa-angle-right"></i> </a><?php }  ?>
   
   
      <ul class="treeview-menu">
      
       <!---- Report Delivery Instruction ------>      
          <?php
		if($data_function["f_rpt_smenu0"] == "Y")
			 {
				?>
      
      <?php if ($url == "detail_DI_doc-dikanban.php"){ ?>
        <li><a href="detail_DI_doc-dikanban.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Delivery Instruction</a></li><?php }else { echo "<li>"; ?><a href="detail_DI_doc-dikanban.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Delivery Instruction</a></li><?php }  } ?>
      


        <!---- Report Delivery Instruction PPC ------>      
          <?php
		if($data_function["f_rpt_smenu21"] == "Y")
			 {
				?>
      
      <?php if ($url == "detail_DI_doc-dikanban_PPC.php"){ ?>
        <li><a href="detail_DI_doc-dikanban_PPC.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Delivery Instruction PPC</a></li><?php }else { echo "<li>"; ?><a href="detail_DI_doc-dikanban_PPC.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Delivery Instruction PPC </a></li><?php }  } ?>



      
        <!---- Report Delivery Order ------>    
      <?php
		if($data_function["f_rpt_smenu18"] == "Y")
			 {
				?>
      
       <?php if ($url == "detail_dlv_instrucdoc-dikanban.php"){ ?>
        <li><a href="detail_dlv_instrucdoc-dikanban.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Delivery Order</a></li><?php }else { echo "<li>"; ?><a href="detail_dlv_instrucdoc-dikanban.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Delivery Order</a></li><?php }  } ?>

      
        <!-- Report Goods Receipt ---> 
        <?php 
         if($data_function["f_rpt_smenu1"] == "Y")
			 {   ?>
          <?php if ($url == "detail_GR_doc-receive.php"){ ?>
        <li><a href="detail_GR_doc-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt</a></li><?php }else { echo "<li>"; ?><a href="detail_GR_doc-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt</a></li><?php }  } ?>
        
         <!-- Report Goods Receipt FOC ---> 
        <?php 
         if($data_function["f_rpt_smenu2"] == "Y")
			 {   ?>
          <?php if ($url == "detail_GRfoc_doc-receive.php"){ ?>
        <li><a href="detail_GRfoc_doc-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt FOC</a></li><?php }else { echo "<li>"; ?><a href="detail_GRfoc_doc-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt FOC</a></li><?php }  } ?>
        
          <!-- Report Goods Return ---> 
         <?php 
         if($data_function["f_rpt_smenu3"] == "Y")
			 {   ?>
          <?php if ($url == "detail_GReturn_doc-receive.php"){ ?>
        <li><a href="detail_GReturn_doc-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Return</a></li><?php }else { echo "<li>"; ?><a href="detail_GReturn_doc-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Return</a></li><?php }  } ?>
        
         <!-- Report GI ---> 
         
         <?php 
           if($data_function["f_rpt_smenu4"] == "Y")
			 {   ?>
          <?php if ($url == "detail_GR_GI_doc-receive.php"){ ?>
        <li><a href="detail_GR_GI_doc-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;GI Consumable</a></li><?php }else { echo "<li>"; ?><a href="detail_GR_GI_doc-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;GI Consumable</a></li><?php }  } ?>
      
      
 
        
        <!-- Report Transfer Posting ---> 
      
       <?php 
          if($data_function["f_rpt_smenu5"] == "Y")
			 {   ?>
        
       <?php if ($url == "doc_list_prog_trn-posting.php"){ ?>
        <li><a href="doc_list_prog_trn-posting.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer Posting</a></li><?php }else { echo "<li>";  ?><a href="doc_list_prog_trn-posting.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer Posting</a></li><?php } ?> 
        
        <?php   }  ?>
        
        
        
        
          <!-- Report Transfer Subcont --->    
        
       <?php 
          if($data_function["f_rpt_smenu6"] == "Y")
			 {   ?>
             
       <?php if ($url == "doc_tp_subcont.php"){ ?>
        <li><a href="doc_tp_subcont.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer to Subcont</a></li><?php }else { echo "<li>";  ?><a href="doc_tp_subcont.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer to Subcont</a></li><?php }  ?>
            
        <?php   } ?>
        
        
        
        
          <!-- Report Transfer Material ---> 
        
         <?php 
          if($data_function["f_rpt_smenu7"] == "Y")
			 {   ?>
          <?php if ($url == "detail_GR_TM_doc-receive.php"){ ?>
        <li><a href="detail_GR_TM_doc-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer Material</a></li><?php }else { echo "<li>"; ?><a href="detail_GR_TM_doc-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer Material</a></li><?php }  } ?>
        
         <?php 
           if($data_function["f_rpt_smenu17"] == "Y")
			 {    
			 ?>
        
         <?php  if ($url == "detail_do_alldoc-dlv.php"){ ?>
        <li><a href="detail_do_alldoc-dlv.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;PDIO/DI</a></li><?php }else { echo "<li>";  ?><a href="detail_do_alldoc-dlv.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;PDIO/DI</a></li><?php }  ?>
        <?php   }  ?>

 <?php 
           if($data_function["f_rpt_smenu20"] == "Y")
			 {    
			 ?>
        
         <?php  if ($url == "detail_do_alldoc-dlv_FINA.php"){ ?>
        <li><a href="detail_do_alldoc-dlv_FINA.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;PDIO/DI for FINA</a></li><?php }else { echo "<li>";  ?><a href="detail_do_alldoc-dlv_FINA.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;PDIO/DI for FINA</a></li><?php }  ?>
        <?php   }  ?> 

      
       <?php 
          if($data_function["f_rpt_smenu8"] == "Y")
			 {    
			 ?>
        
         <?php if ($url == "detail_do_doc-dlv.php"){ ?>
        <li><a href="detail_do_doc-dlv.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush Transit</a></li><?php }else { echo "<li>";  ?><a href="detail_do_doc-dlv.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush Transit</a></li><?php }  ?>
        <?php   }  ?>
      
      
      
       <?php 
         if($data_function["f_rpt_smenu9"] == "Y")
			 {   ?>
          <?php if ($url == "FTP_gratranfer_monitor.php"){ ?>
        <li><a href="FTP_gratranfer_monitor.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Return Advise</a></li><?php }else { echo "<li>";  ?><a href="FTP_gratranfer_monitor.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Return Advise</a></li><?php }  ?>
        <?php   }  ?>
        
         <?php 
        if($data_function["f_rpt_smenu19"] == "Y")
			 {   ?>
          <?php if ($url == "FTP_gratranfer_monitor3.php"){ ?>
        <li><a href="FTP_gratranfer_monitor3.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal PPC</a></li><?php }else { echo "<li>";  ?><a href="FTP_gratranfer_monitor3.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal PPC</a></li><?php }  ?>
        <?php   }  ?>
        
          <?php 
        if($data_function["f_rpt_smenu10"] == "Y")
			 {   ?>
          <?php if ($url == "FTP_gratranfer_monitor2.php"){ ?>
        <li><a href="FTP_gratranfer_monitor2.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal QC</a></li><?php }else { echo "<li>";  ?><a href="FTP_gratranfer_monitor2.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal QC</a></li><?php }  ?>
        <?php   }  ?>
      
       <?php 
        if($data_function["f_rpt_smenu11"] == "Y")
			 {   ?>
      
         <?php if ($url == "list_rpt_bf_all_v2.php"){ ?>
        <li><a href="list_rpt_bf_all_v2.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush</a></li><?php }else { echo "<li>";  ?><a href="list_rpt_bf_all_v2.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush</a></li><?php } } ?>
          
          <?php 
        if($data_function["f_rpt_smenu12"] == "Y")
			 {   ?>
           <?php if ($url == "list_rpt_PEND_all.php"){ ?>
        <li><a href="list_rpt_PEND_all.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Pending</a></li><?php }else { echo "<li>"; ?><a href="list_rpt_PEND_all.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Pending</a></li><?php } } ?>
        <?php 
        if($data_function["f_rpt_smenu13"] == "Y")
			 {   ?>
         <?php if ($url == "list_rpt_RWK_all.php"){ ?>
        <li><a href="list_rpt_RWK_all.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Rework</a></li><?php }else { echo "<li>"; ?><a href="list_rpt_RWK_all.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Rework</a></li><?php }  }?>
        
        <?php 
        if($data_function["f_rpt_smenu14"] == "Y")
			 {   ?>
       <?php 
	      
         if ($url == "list_rpt_HWORK_all.php"){ ?>
        <li><a href="list_rpt_HWORK_all.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Handwork</a></li><?php }else { echo "<li>"; ?><a href="list_rpt_HWORK_all.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Handwork</a></li><?php } } ?>
      <?php 
        if($data_function["f_rpt_smenu15"] == "Y")
			 {   ?>
        <?php if ($url == "list_rpt_DIS_all.php"){ ?>
        <li><a href="list_rpt_DIS_all.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php }else { echo "<li>"; ?><a href="list_rpt_DIS_all.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php } } ?>
        <?php 
        if($data_function["f_rpt_smenu16"] == "Y")
			 {   ?>
        <?php if ($url == "list_rpt_pln_sta_all.php"){ ?>
        <li><a href="list_rpt_pln_sta_all.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Planned Order Status</a></li><?php }else { echo "<li>"; ?><a href="list_rpt_pln_sta_all.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Planned Order Status</a></li><?php } } ?>
      
                <?php 
        if($data_function["f_rpt_smenu22"] == "Y")
			 {   ?>
        <?php if ($url == "list_rpt_DIS_ENG.php"){ ?>
        <li><a href="list_rpt_DIS_ENG.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal ENG</a></li><?php }else { echo "<li>"; ?><a href="list_rpt_DIS_ENG.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal ENG</a></li><?php }  } ?>
    

        
      </ul>
    </li>
      <?php  
	  
	  }
	  
	  ?>

        
        
     <!-- FTP Monitoring ---> 
        <?php
			    if($data_function["main_ftp"] == "Y")
			 {
				?>
    
     
      <?php if (($url == "list_ftp_bf-all_prd.php") || ($url == "list_ftp_bf-NG_prd.php") || ($url == "list_ftp_bf-PEND_prd.php") || ($url == "list_ftp_bf-HWORK_prd.php") || ($url == "list_ftp_PEND-all_prd.php") || ($url =="list_ftp_RWK-all_prd.php") || ($url =="list_ftp_HWORK-all_prd.php") || ($url == "list_ftp_DIS-all_prd.php") || ($url == "list_ftp_gd-rect.php") || ($url == "list_ftp_GR_return-receive.php") || ($url =="list_ftp_GR_GI-receive.php") || ($url =="list_ftp_trans_mat-receive.php") || ($url =="list_ftp_TP-receive.php") || ($url == "list_ftp_TPSubcon-receive.php") || ($url =="list_ftp_GR_disposal-receive.php") || ($url =="list_ftp_BF_transit-dlv.php") || ($url == "list_ftp_dlvdo-dlv.php") || ($url == "list_ftp_rtndlvdo-dlv.php") || ($url == "list_ftp_dis_qc.php") || ($url == "list_ftp_dis_ENG.php")) { ?> 
   <li class="treeview is-expanded"><a href="list_ftp_bf-all_prd.php" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-upload"></i><span class="app-menu__label">FTP Monitoring</span><i class="treeview-indicator fa fa-angle-right"></i> </a> <?php }else { echo "<li class='treeview'>";  ?> <a href="list_ftp_bf-all_prd.php"  class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-upload"></i><span class="app-menu__label">FTP Monitoring</span><i class="treeview-indicator fa fa-angle-right"></i> </a><?php }  ?>
   
   
      <ul class="treeview-menu">
       <?php 
         if($data_function["f_ftp_smenu1"] == "Y")
		{    
			 ?>
      
         <?php if ($url == "list_ftp_bf-all_prd.php"){ ?>
        <li><a href="list_ftp_bf-all_prd.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush OK</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_bf-all_prd.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush OK</a></li><?php }  ?>
        <?php }  ?>
         <?php 
         if($data_function["f_ftp_smenu2"] == "Y")
		{    
			 ?>
        <?php if ($url == "list_ftp_bf-NG_prd.php"){ ?>
        <li><a href="list_ftp_bf-NG_prd.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush NG</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_bf-NG_prd.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush NG</a></li><?php }  ?>
      
         <?php }  ?>
         <?php 
         if($data_function["f_ftp_smenu3"] == "Y")
		{    
			 ?>
        <?php if ($url == "list_ftp_bf-PEND_prd.php"){ ?>
        <li><a href="list_ftp_bf-PEND_prd.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush Pending</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_bf-PEND_prd.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush Pending</a></li><?php }  ?>
         <?php }  ?>
         <?php 
         if($data_function["f_ftp_smenu4"] == "Y")
		{    
			 ?>
         <?php if ($url == "list_ftp_bf-HWORK_prd.php"){ ?>
        <li><a href="list_ftp_bf-HWORK_prd.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush Handwork</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_bf-HWORK_prd.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush Handwork</a></li><?php }  ?>
        
        <?php  }   ?>
       
         <?php 
         if($data_function["f_ftp_smenu5"] == "Y")
		{    
			 ?>
        
         <?php if ($url == "list_ftp_DIS-all_prd.php"){ ?>
        <li><a href="list_ftp_DIS-all_prd.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_DIS-all_prd.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php }  ?>
        <?php  }  ?>
        
 
        
        <?php 
         if($data_function["f_ftp_smenu6"] == "Y")
			 {    
			 ?>
      
         <?php if ($url == "list_ftp_gd-rect.php"){ ?>
        <li><a href="list_ftp_gd-rect.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_gd-rect.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Receipt</a></li><?php }  } ?>
          
          
           <?php 
         if($data_function["f_ftp_smenu7"] == "Y")
			 {    
			 ?>
      
           <?php if ($url == "list_ftp_GR_return-receive.php"){ ?>
        <li><a href="list_ftp_GR_return-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Return</a></li><?php }else { echo "<li>"; ?><a href="list_ftp_GR_return-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Goods Return</a></li><?php }  } ?>
        
         <?php 
         if($data_function["f_ftp_smenu8"] == "Y")
			 {    
			 ?>
      
         <?php if ($url == "list_ftp_GR_GI-receive.php"){ ?>
        <li><a href="list_ftp_GR_GI-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;GI Consumable</a></li><?php }else { echo "<li>"; ?><a href="list_ftp_GR_GI-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;GI Consumable</a></li><?php }  } ?>
        
         <?php 
         if($data_function["f_ftp_smenu9"] == "Y")
			 {    
			 ?>
      
         <?php if ($url == "list_ftp_trans_mat-receive.php"){ ?>
        <li><a href="list_ftp_trans_mat-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer Material</a></li><?php }else { echo "<li>"; ?><a href="list_ftp_trans_mat-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer Material</a></li><?php }   } ?>
       
        <?php 
         if($data_function["f_ftp_smenu10"] == "Y")
			 {    
			 ?>
      
         <?php if ($url == "list_ftp_TP-receive.php"){ ?>
        <li><a href="list_ftp_TP-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer Posting</a></li><?php }else { echo "<li>"; ?><a href="list_ftp_TP-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer Posting</a></li><?php }  } ?>
        
       <?php 
         if($data_function["f_ftp_smenu15"] == "Y")
			 {    
			 ?>
      
         <?php if ($url == "list_ftp_TPSubcon-receive.php"){ ?>
        <li><a href="list_ftp_TPSubcon-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer to Subcont</a></li><?php }else { echo "<li>"; ?><a href="list_ftp_TPSubcon-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Transfer to Subcont</a></li><?php }  } ?>


         <?php 
         if($data_function["f_ftp_smenu11"] == "Y")
			 {    
			 ?>
         <?php if ($url == "list_ftp_GR_disposal-receive.php"){ ?>
        <li><a href="list_ftp_GR_disposal-receive.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php }else { echo "<li>"; ?><a href="list_ftp_GR_disposal-receive.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php } } ?>
        
         <?php 
         if($data_function["f_ftp_smenu12"] == "Y")
			 {    
			 ?>
        <?php if ($url == "list_ftp_BF_transit-dlv.php"){ ?>
        <li><a href="list_ftp_BF_transit-dlv.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush Transit</a></li><?php }else { echo "<li>"; ?><a href="list_ftp_BF_transit-dlv.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Backflush Transit</a></li><?php } } ?>
      
	    <?php 
         if($data_function["f_ftp_smenu13"] == "Y")
			 {    
			 ?>
        <?php if ($url == "list_ftp_dlvdo-dlv.php"){ ?>
        <li><a href="list_ftp_dlvdo-dlv.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Delivery Order</a></li><?php }else { echo "<li>"; ?><a href="list_ftp_dlvdo-dlv.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Delivery Order</a></li><?php } } ?>
      
        <?php 
         if($data_function["f_ftp_smenu14"] == "Y")
			 {    
			 ?>
      
         <?php if ($url == "list_ftp_dis_qc.php"){ ?>
        <li><a href="list_ftp_dis_qc.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_dis_qc.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal</a></li><?php }  } ?>
      
      
      <?php 
         if($data_function["f_ftp_smenu16"] == "Y")
			 {    
			 ?>
      
         <?php if ($url == "list_ftp_dis_ENG.php"){ ?>
        <li><a href="list_ftp_dis_ENG.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal ENG</a></li><?php }else { echo "<li>";  ?><a href="list_ftp_dis_ENG.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Disposal ENG</a></li><?php }  } ?>
      
     
      </ul>
    </li>
      <?php  } ?>
       <?php
			    if($data_function["main_coo"] == "Y")
			 {
				?>
                
         <?php if (($url == "detail_aprv_coo_disposal4-prd.php") || ($url == "detail_aprv_coo_disposal4-prd-aprv.php") || ($url == "canC_coo_disposal4-prd.php") || ($url == "detail_rej_coo_disposal4-prd-aprv.php") || ($url == "FTP_gratranfer_monitor_DIS.php")) { ?>
         
    <li class="treeview is-expanded"><a href="" class="app-menu__item active"  data-toggle="treeview"><i class="app-menu__icon fa fa-thumbs-o-up"></i><span class="app-menu__label"><?php echo $rst_apprv8["apprv_name2"]; ?></span> <i class="treeview-indicator fa fa-angle-right"></i></a> <?php }else { echo "<li class='treeview'>"; ?><a href="" class="app-menu__item"  data-toggle="treeview"><i class="app-menu__icon fa fa-thumbs-o-up"></i><span class="app-menu__label"><?php echo $rst_apprv8["apprv_name2"]; ?></span> <i class="treeview-indicator fa fa-angle-right"></i></a><?php } ?>
    
      <ul class="treeview-menu">
       
         <?php 
         if($data_function["f_coo_smenu1"] == "Y")
			 {    
			 ?>
         <?php if ($url == "detail_aprv_coo_disposal4-prd.php"){ ?>
        <li><a href="detail_aprv_coo_disposal4-prd.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Pending Approval</a></li><?php }else { echo "<li>";  ?><a href="detail_aprv_coo_disposal4-prd.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Pending Approval</a></li><?php } }?>
         
         <?php 
         if($data_function["f_coo_smenu2"] == "Y")
			 {    
			 ?>
		 <?php if ($url == "detail_aprv_coo_disposal4-prd-aprv.php"){ ?>
        <li><a href="detail_aprv_coo_disposal4-prd-aprv.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Approved</a></li><?php }else { echo "<li>";  ?><a href="detail_aprv_coo_disposal4-prd-aprv.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Approved</a></li><?php }  }?>
        
        <?php 
         if($data_function["f_coo_smenu3"] == "Y")
			 {    
			 ?>
         <?php if ($url == "detail_rej_coo_disposal4-prd-aprv.php"){ ?>
        <li><a href="detail_rej_coo_disposal4-prd-aprv.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Rejected</a></li><?php }else { echo "<li>";  ?><a href="detail_rej_coo_disposal4-prd-aprv.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Rejected</a></li><?php } }?>
        
        <?php 
         if($data_function["f_coo_smenu4"] == "Y")
			 {    
			 ?>
         <?php if ($url == "canC_coo_disposal4-prd.php"){ ?>
        <li><a href="canC_coo_disposal4-prd.php" class="treeview-item active"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Cancellation</a></li><?php }else { echo "<li>";  ?><a href="canC_coo_disposal4-prd.php" class="treeview-item"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Cancellation</a></li><?php } }?>
  
  <?php 
         if($data_function["f_coo_smenu5"] == "Y")
			 {    
			 ?>
   <?php if ($url == "FTP_gratranfer_monitor_DIS.php"){ ?>
        <li><a href="FTP_gratranfer_monitor_DIS.php" class="treeview-item active" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Document List</a></li><?php }else { echo "<li>";  ?><a href="FTP_gratranfer_monitor_DIS.php" class="treeview-item" ><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;Document List</a></li><?php } } ?>
        
         </ul>
         </li>
       
        
     
         
         
         <?php  }  ?> 
    
        
    
       <li><a href="../logout.php" class="app-menu__item"><i class="app-menu__icon fa fa-power-off" ></i><span class="app-menu__label">Logout</span></a></li>
      
      
      </ul>
    </aside>
 