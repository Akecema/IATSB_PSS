<?php 
 
   if($data_setup3["bil_table"] == "5")
   {  ?>

 <p>&nbsp;</p>
                <div class="modal-body pull-right">
               <table width="50%" class="table table-bordered">
                   <tr>
                     <th width="10%"><div align="center" class="style7">Prepared by</div></th>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th>
                     <th width="10%"><div align="center" class="style7">Verified by</div></th>
                     <th width="10%"><div align="center" class="style7">Approved by</div></th>
                   </tr>
                     <tr>
                     <td><div align="center" class="style7"><p><b><?php  echo $data_prepare["user_fullname"];   ?></b>
                     <br><?php echo $data_bb["T3"];   ?></p></div></td>
                     <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by5"]) != "") && (($data_bb["status_approved5"]) == $rst_sta3["status_desc"])) { echo $data_appr5["user_fullname"];  }  ?></b>
                     <br><?php if((($data_bb["approved_by5"]) != "") && (($data_bb["status_approved5"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T49"]; } ?></p></div></td>
                     <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])){ echo $data_appr["user_fullname"];  }  ?></b>
                     <br><?php if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T9"]; } ?></p></div></td> 
                     <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) { echo $data_appr2["user_fullname"];  }  ?></b>
                     <br><?php if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T19"]; } ?></p></div></td> 
                     <td><div align="center" class="style7"><p><b><?php  if((($data_bb["approved_by3"]) != "") && (($data_bb["status_approved3"]) == $rst_sta3["status_desc"])) { echo $data_appr3["user_fullname"];  }  ?></b>
                     <br><?php if((($data_bb["approved_by3"]) != "") && (($data_bb["status_approved3"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T29"]; } ?></p></div></td>
                   </tr>
                   <tr>
                     <td><div align="center" class="style7"><?php echo $rst_apprv["apprv_name"]; ?></div></td>
                     <td><div align="center" class="style7"><?php echo $rst_apprv4["apprv_name"]; ?></div></td>
                     <td><div align="center" class="style7"><?php echo $rst_apprv5["apprv_name"]; ?></div></td>
                     <td><div align="center" class="style7"><?php echo $rst_apprv6["apprv_name"]; ?></div></td>
                     <td><div align="center" class="style7"><?php echo $rst_apprv8["apprv_name"]; ?></div></td>
                   </tr>
                 </table>
              </div><br>
              <table width="98%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><table width="98%" class="table-borderless">
                   <tr>
                     <th colspan="4"><div class="style18">COMMENT</div></th>
                   </tr>
                    <tr> 
                     <td width="17%"><b><?php echo $rst_apprv4["apprv_name2"]; ?>:</b></td>
                     <td width="20%"><?php if(($data_bb["approved_by5"]) != "") {  echo $data_bb["remark_approved5"]; }else{ ?>
                     _______________________________________________<?php }  ?></td>
                     <td width="17%"><b><?php echo $rst_apprv5["apprv_name2"]; ?>:</b></td>
                     <td width="20%"><?php if(($data_bb["approved_by"]) != "") {  echo $data_bb["remark_approved"]; }else{ ?>
                     _______________________________________________<?php }  ?>
                     </td>
                   </tr>
                    <tr> 
                     <td width="17%"><b><?php echo $rst_apprv6["apprv_name2"]; ?>:</b></td>
                     <td width="20%"><?php if(($data_bb["approved_by2"]) != "") {  echo $data_bb["remark_approved2"]; }else{ ?>
                     _______________________________________________<?php }  ?></td>
                     <td width="17%"><b><?php echo $rst_apprv8["apprv_name2"]; ?>:</b></td>
                     <td width="20%"><?php if(($data_bb["approved_by3"]) != "") {  echo $data_bb["remark_approved3"]; }else{ ?>
                     _______________________________________________<?php }  ?></td>
                   </tr>
                  </table>    </td>
  </tr>
</table>

<?php }  ?>
