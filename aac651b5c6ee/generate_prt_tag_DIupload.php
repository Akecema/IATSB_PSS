<?php 
include '../include/config.php';

//-----------------------------------------------------//
  //-----    Print Tag generate after submit 29.03.2023--//
  //-----------------------------------------------------//

  $query_all2 = "SELECT * FROM dlv_dikanban_generate WHERE id = '".mysqli_insert_id($dbc)."' AND status_kanban = '".sql_esc($rst_sta["status_desc"])."'";
  $result_all2 = mysqli_query($dbc,$query_all2);
  $data_all2 = mysqli_fetch_array($result_all2);
  
  $dl_qty = (intval($data_all2["kanban_order"]));
  

  //---- size dim table_material_itsb --------------
  $query_pack2 = "SELECT std_packaging, type_package, size_dim FROM table_material_itsb WHERE material_no = '".sql_esc($data_all2["material_no"])."'";
  $result_pack2 = mysqli_query($dbc,$query_pack2);
  $data_pack2 = mysqli_fetch_array($result_pack2);
  
  //----detail standard packaging [ambil dari table mat_master_header]
  
  $query_pack = "SELECT * FROM dlv_dikanban_generate WHERE id = '".sql_esc($data_all2["id"])."' AND DI_doc = '".sql_esc($ref)."'";
  $result_pack = mysqli_query($dbc,$query_pack);
  $data_pack = mysqli_fetch_array($result_pack);
  
  
  
  if (($data_all2["std_ups_package"] == "")) {
  
      $st_pack = (intval($data_all2["kanban_order"]));

  }elseif (($data_all2["std_package"] == "") && ($data_all2["std_ups_package"] == "")) {
  
      $st_pack = (intval($data_all2["kanban_order"]));

  }else{
  
     $st_pack = $data_all2["std_package"];
    
  }
  

  $no_tg = "";
  
  $bil_tag = (($dl_qty) / ($st_pack));
  
  $b =  intval($bil_tag);  // genapkan value yg dibahagikan utk didarabkan 
 
  // $b = round($bil_tag, 0, PHP_ROUND_HALF_DOWN);  // genapkan value yg dibahagikan utk didarabkan 
  $last_tag = ($bil_tag - $b);	   // sekiranya masih ada baki utk keluarkn delivery tag yg last
  
  $bil_tag2 = ($st_pack * $b);
  
  if ($dl_qty < ($st_pack)) {
      $bil_tag3A = ($dl_qty);
  } else {
      $bil_tag3A =  ($dl_qty - $bil_tag2);  //quantity delivery tag yg last
  }
  
  if ($b == 1) {
      $no_tg = 1;
  } elseif ($last_tag == 0) {
      $no_tg = $b;
  } else {
      $no_tg = ($b + 1);
  }
  
  $w = 1;
  
  for ($m = 1; $m <= $bil_tag; $m++) {
      $bil_tag_newA = (($dl_qty) / ($st_pack));
  
      if (($bil_tag_newA > '1.000') && ($bil_tag_newA < '1.999')) {

  
          $query_tag3B = "INSERT INTO print_tag_do_dikanban(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($st_pack)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','2','".sql_esc($data_all2["DI_dlv_date"])."','".sql_esc($data_all2["DI_dlv_time"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."')";
          $result_tag3B = mysqli_query($dbc,$query_tag3B);
  
          $tag_no3B = ($data_all2["DI_doc"].'/'.$w.'/'.$data_pack["std_package"].'/'.$no_tg);
  
  
          $query_tag3_t = "UPDATE print_tag_do_dikanban SET tag_no = '".sql_esc($tag_no3B)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND DI_doc = '".sql_esc($ref)."'";
          $result_tag3_t = mysqli_query($dbc,$query_tag3_t);
      } else {
  
  
  
  
  
  
  
          $query_tag3B = "INSERT INTO print_tag_do_dikanban(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($st_pack)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($data_all2["DI_dlv_date"])."','".sql_esc($data_all2["DI_dlv_time"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."')";
          $result_tag3B = mysqli_query($dbc,$query_tag3B);
  
          $tag_no3B = ($data_all2["DI_doc"].'/'.$w.'/'.$data_pack["std_package"].'/'.$no_tg);
  
  
          $query_tag3_t = "UPDATE print_tag_do_dikanban SET tag_no = '".sql_esc($tag_no3B)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND DI_doc = '".sql_esc($ref)."'";
          $result_tag3_t = mysqli_query($dbc,$query_tag3_t);
      }
  
      $w++;
  } // end for loop
  
  if (($last_tag > 0.000) || ($dl_qty < ($st_pack))) // kalau qty lebih kecil drpd std packaging and baki drpd bahagi tag
  {
  
      $bil_tag_new = (($dl_qty) / ($st_pack));
  
  
      if (($bil_tag_new > '1.000') && ($bil_tag_new < '1.999')) {
  
          $query_tag2 = "INSERT INTO print_tag_do_dikanban(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($bil_tag3A)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','2','".sql_esc($data_all2["DI_dlv_date"])."','".sql_esc($data_all2["DI_dlv_time"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."')";
          $result_tag2 = mysqli_query($dbc,$query_tag2);
  
  
          $tag_no2 = ($data_all2["DI_doc"].'/'.$w.'/'.$bil_tag3A.'/'.($b + 1));
  
          $query_tag2_t = "UPDATE print_tag_do_dikanban SET tag_no = '".sql_esc($tag_no2)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND DI_doc = '".sql_esc($ref)."'";
          $result_tag2_t = mysqli_query($dbc,$query_tag2_t);
      } else {
  
  
          $query_tag2 = "INSERT INTO print_tag_do_dikanban(id_tag,tag_no,id_do,do_no,DI_doc,back_no,plant_code,purc_ord_no,vendor_id,item_no,material_no,material_desc,size_gr,model_gr,ord_uom,tag_qty,shift_tag,sloc,sloc_gr,user_posting,posting_date,posting_time,user_create,date_create,status_tag,status_print,status_DO,yr_gr,slip_no,total_slip,date_dlv,time_dlv,supp_do,supp_part_no) VALUES('','','".sql_esc($data_all2["id"])."','".sql_esc($data_all2["do_no"])."','".sql_esc($data_all2["DI_doc"])."','".sql_esc($data_all2["back_no"])."','".sql_esc($data_all2["plant_code"])."','".sql_esc($data_all2["po_no"])."','".sql_esc($data_all2["vc_code"])."','','".sql_esc($data_all2["material_no"])."','".sql_esc($data_all2["material_desc"])."','".sql_esc($data_pack2["size_dim"])."','".sql_esc($data_all2["model_cd"])."','".sql_esc($data_all2["uom_dlv"])."','".sql_esc($bil_tag3A)."','".sql_esc($data_all2["shift_dlv"])."','','','".sql_esc($data_all2["user_posting"])."','".sql_esc($data_all2["date_posting"])."','".sql_esc($data_all2["time_posting"])."','".strtoupper($username)."',NOW(),'Y','N','".sql_esc($data_all2["status_DO"])."',NOW(),'".sql_esc($w)."','".sql_esc($no_tg)."','".sql_esc($data_all2["DI_dlv_date"])."','".sql_esc($data_all2["DI_dlv_time"])."','".sql_esc($data_all2["supp_do"])."','".sql_esc($data_all2["supp_part_no"])."')";
          $result_tag2 = mysqli_query($dbc,$query_tag2);
  
  
          $tag_no2 = ($data_all2["DI_doc"].'/'.$w.'/'.$bil_tag3A.'/'.($b + 1));
  
          $query_tag2_t = "UPDATE print_tag_do_dikanban SET tag_no = '".sql_esc($tag_no2)."' WHERE id_tag = '".mysqli_insert_id($dbc)."' AND DI_doc = '".sql_esc($ref)."'";
          $result_tag2_t = mysqli_query($dbc,$query_tag2_t);
      }
  } // end if
  





?>