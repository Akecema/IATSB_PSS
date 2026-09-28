<?php 
 
   if($data_setup4["bil_table"] == "5")
   {  ?>
       <!-- <div align="right">-->
        <table width="98%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td>&nbsp;</td>
    <td width="60%">
               <table width="100%" class="table-bordered" cellpadding="2">
                   <tr bgcolor="#eeeeee">
                     <th width="10%"><div align="center" class="style7">Prepared by</div></th>
                     <?php if($rowStm["status_acc"] == "Y") {  ?>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th><?php } ?>
                      <?php if($rowHead["status_acc"] == "Y") {  ?>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th><?php  } ?>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th>
                     <th width="10%"><div align="center" class="style7">Approved by</div></th>
                   </tr>
                    <tr>
                     <td><div align="center" class="style7"><p><b><?php  echo html_esc($data_prepare["user_fullname"]);   ?></b>
                     <br><?php echo html_esc($data_bb["T3"]);   ?></p></div></td>
                      <?php if($rowStm["status_acc"] == "Y") {  ?>
                      <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by5"]) != "") && (($data_bb["status_approved5"]) == $rst_sta3["status_desc"])) { echo html_esc($data_appr5["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by5"]) != "") && (($data_bb["status_approved5"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T49"]); } ?></p></div></td><?php  } ?> 
                       <?php if($rowHead["status_acc"] == "Y") {  ?>
                     <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) { echo html_esc($data_appr["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T9"]); } ?></p></div></td>
                     <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) { echo html_esc($data_appr2["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T19"]); } ?></p></div></td> 
                     <td><div align="center"><p><b><?php  if((($data_bb["approved_by3"]) != "") && (($data_bb["status_approved3"]) == $rst_sta3["status_desc"])) { echo html_esc($data_appr3["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by3"]) != "") && (($data_bb["status_approved3"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T29"]); } ?></p></div></td>
                     <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by4"]) != "") && (($data_bb["status_approved4"]) == $rst_sta3["status_desc"])) { echo html_esc($data_appr4["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by4"]) != "") && (($data_bb["status_approved4"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T39"]); } ?></p></div></td>
					 <?php  }else{ ?> 
                     <td><div align="center"><p><b><?php  if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) { echo html_esc($data_appr["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T9"]); } ?></p></div></td>
                     <td><div align="center"><p><b><?php  if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) { echo html_esc($data_appr2["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T19"]); } ?></p></div></td> 
                     <td><div align="center"><p><b><?php  if((($data_bb["approved_by3"]) != "") && (($data_bb["status_approved3"]) == $rst_sta3["status_desc"])) { echo html_esc($data_appr3["user_fullname"]);  }  ?></b>
                     <br><?php if((($data_bb["approved_by3"]) != "") && (($data_bb["status_approved3"]) == $rst_sta3["status_desc"])) {  echo html_esc($data_bb["T29"]); } ?></p></div></td>

                     <?php } ?>
                   </tr>
                   <tr>
                      <td><div align="center" class="style7"><?php echo html_esc($rst_apprv["apprv_name"]); ?></div></td>
                      <?php if($rowStm["status_acc"] == "Y") {  ?>  
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv3["apprv_name"]); ?></div></td><?php } ?>
                      <?php if($rowHead["status_acc"] == "Y") {  ?>  
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv4["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv5["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv6["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv8["apprv_name"]); ?></div></td>
					 <?php }else{ ?>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv5["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv6["apprv_name"]); ?></div></td>
                     <td><div align="center" class="style7"><?php echo html_esc($rst_apprv8["apprv_name"]); ?></div></td>

                     <?php } ?>
                   </tr>
                 </table>
    
    </td>
  </tr>
</table><br><table width="98%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><table width="98%" class="table-borderless">
                   <tr>
                     <th colspan="4"><div class="style18">COMMENT</div></th>
                   </tr>
                    <tr> 
                      <?php if($rowStm["status_acc"] == "Y") {  ?>  
                     <td width="15%"><b><?php echo html_esc($rst_apprv3["apprv_name2"]); ?>:</b></td> 
                     <td width="25%"><?php if(($data_bb["approved_by5"]) != "") {  echo html_esc($data_bb["remark_approved5"]); }else{ ?>
                     _______________________________________________<?php }  ?></td><?php  }   ?>
                        <?php if($rowHead["status_acc"] == "Y") {  ?>  
                       <td width="15%"><b><?php echo html_esc($rst_apprv4["apprv_name2"]); ?>:</b></td> 
                     <td width="25%"><?php if(($data_bb["approved_by"]) != "") {  echo html_esc($data_bb["remark_approved"]); }else{ ?>
                     _______________________________________________<?php }  ?></td><?php }else{  ?>
						 
						<td width="15%"></td>
                        <td width="25%"></td> 
						 
				  <?php	 } ?>
                    
                   
                   </tr>
                    <tr>
                     <?php if($rowHead["status_acc"] == "Y") {  ?>  
                     <td width="15%"><b><?php echo html_esc($rst_apprv5["apprv_name2"]); ?> :</b></td>
                     <td width="25%"><?php if(($data_bb["approved_by2"]) != "") {  echo html_esc($data_bb["remark_approved2"]); }else{ ?>
                     _______________________________________________<?php }  ?>
                     </td>
                     <td width="15%"><b><?php echo html_esc($rst_apprv6["apprv_name2"]); ?> :</b></td>
                     <td width="25%"><?php if(($data_bb["approved_by3"]) != "") {  echo html_esc($data_bb["remark_approved3"]); }else{ ?>
                     _______________________________________________<?php }  ?></td>
                     <?php }else{ ?>
                     <td width="15%"><b><?php echo html_esc($rst_apprv5["apprv_name2"]); ?> :</b></td>
                     <td width="25%"><?php if(($data_bb["approved_by"]) != "") {  echo html_esc($data_bb["remark_approved"]); }else{ ?>
                     _______________________________________________<?php }  ?>
                     </td>
                     <td width="15%"><b><?php echo html_esc($rst_apprv6["apprv_name2"]); ?> :</b></td>
                     <td width="25%"><?php if(($data_bb["approved_by2"]) != "") {  echo html_esc($data_bb["remark_approved2"]); }else{ ?>
                     _______________________________________________<?php }  ?></td>
                     <?php } ?>
                   </tr>
                    <tr>
                     <?php if($rowHead["status_acc"] == "Y") {  ?>   
                     <td width="15%"><b><?php echo html_esc($rst_apprv8["apprv_name2"]); ?> :</b></td>
                     <td width="25%"><?php if(($data_bb["approved_by4"]) != "") {  echo html_esc($data_bb["remark_approved4"]); }else{ ?>
                     _______________________________________________<?php }  ?></td> 
                     <td width="15%">&nbsp;</td>
                     <td width="25%">&nbsp;</td>
                     <?php }else{ ?>
                     <td width="15%"><b><?php echo html_esc($rst_apprv8["apprv_name2"]); ?> :</b></td>
                     <td width="25%"><?php if(($data_bb["approved_by3"]) != "") {  echo html_esc($data_bb["remark_approved3"]); }else{ ?>
                     _______________________________________________<?php }  ?></td> 
                     <td width="15%">&nbsp;</td>
                     <td width="25%">&nbsp;</td>
                     <?php } ?>
                   </tr>
                  </table>    </td>
  </tr>
</table><?php }    ?>

                    
     