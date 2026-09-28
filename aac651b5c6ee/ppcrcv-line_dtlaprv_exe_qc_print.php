<?php  //----check setup setting disposal approval ppc rcv	----
			  
			  if($data_setup6["bil_table"] == "5")
                 {  
 ?>
       <!-- <div align="right">-->
        <table width="98%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td>&nbsp;</td>
    <td width="60%">
               <table width="100%" class="table-bordered" cellpadding="2">
                   <tr bgcolor="#eeeeee">
                     <th width="20%"><div align="center">Prepared by</div></th>
                     <th width="20%"><div align="center">Verified by</div></th>
                     <th width="20%"><div align="center">Verified by</div></th>
                     <th width="20%"><div align="center">Verified by</div></th>
                     <th width="20%"><div align="center">Approved by</div></th>
                   </tr>
                    <tr>
                     <td><div align="center"><p><b><?php  echo $data_prepare["user_fullname"];   ?></b>
                     <br><?php echo $data_bb["T3"];   ?></p></div></td>
                     <td><div align="center"><p><b><?php  if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) { echo $data_appr["user_fullname"];  }  ?></b>
                     <br><?php if((($data_bb["approved_by"]) != "") && (($data_bb["status_approved"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T9"]; } ?></p></div></td> 
                     <td><div align="center"><p><b><?php  if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) { echo $data_appr2["user_fullname"];  }  ?></b>
                     <br><?php if((($data_bb["approved_by2"]) != "") && (($data_bb["status_approved2"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T19"]; } ?></p></div></td> 
                     <td><div align="center"><p><b><?php  if((($data_bb["approved_by3"]) != "") && (($data_bb["status_approved3"]) == $rst_sta3["status_desc"])) { echo $data_appr3["user_fullname"];  }  ?></b>
                     <br><?php if((($data_bb["approved_by3"]) != "") && (($data_bb["status_approved3"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T29"]; } ?></p></div></td>
                     <td><div align="center"><p><b><?php  if((($data_bb["approved_by4"]) != "") && (($data_bb["status_approved4"]) == $rst_sta3["status_desc"])) { echo $data_appr4["user_fullname"];  }  ?></b>
                     <br><?php if((($data_bb["approved_by4"]) != "") && (($data_bb["status_approved4"]) == $rst_sta3["status_desc"])) {  echo $data_bb["T39"]; } ?></p></div></td>
                   </tr>
                   <tr>
                     <td><div align="center"><?php echo $rst_apprv["apprv_name"]; ?></div></td>
                     <td><div align="center"><?php echo $rst_apprv2["apprv_name"]; ?></div></td>
                     <td><div align="center"><?php echo $rst_apprv5["apprv_name"]; ?></div></td>
                     <td><div align="center"><?php echo $rst_apprv6["apprv_name"]; ?></div></td>
                     <td><div align="center"><?php echo $rst_apprv8["apprv_name"]; ?></div></td>
                   </tr>
                 </table>
    
    </td>
  </tr>
</table><br><table width="98%" border="1" cellspacing="1" cellpadding="1">
   <tr>
    <td><table width="98%" class="table-borderless">
                   <tr>
                     <th colspan="4"><div class="style18">COMMENT</div></th>
                   </tr>
                    <tr> 
                     <td width="15%"><b><?php echo $rst_apprv2["apprv_name2"]; ?> :</b></td>
                     <td width="25%"><?php if(($data_bb["approved_by"]) != "") {  echo $data_bb["remark_approved"]; }else{ ?>
                     _______________________________________________<?php }  ?></td>
                     <td width="15%"><b><?php echo $rst_apprv6["apprv_name2"]; ?> :</b></td>
                     <td width="25%"><?php if(($data_bb["approved_by3"]) != "") {  echo $data_bb["remark_approved3"]; }else{ ?>
                     _______________________________________________<?php }  ?>
                     </td>
                   </tr>
                    <tr> 
                     <td width="15%"><b><?php echo $rst_apprv5["apprv_name2"]; ?> :</b></td>
                     <td width="25%"><?php if(($data_bb["approved_by2"]) != "") {  echo $data_bb["remark_approved2"]; }else{ ?>
                     _______________________________________________<?php }  ?></td>
                     <td width="15%"><b><?php echo $rst_apprv8["apprv_name2"]; ?> :</b></td>
                     <td width="25%"><?php if(($data_bb["approved_by4"]) != "") {  echo $data_bb["remark_approved4"]; }else{ ?>
                     _______________________________________________<?php }  ?></td>
                   </tr>
                  </table>    </td>
  </tr>
</table><?php }   ?>

                    
     