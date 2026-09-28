<?php

error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

$query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
$result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
$res = mysqli_fetch_array($result2);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "1")) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	
	
$url = "add_user.php"; 

?>

<?php

/* User details */
$get_userNo = $_GET['usrNo'];
$get_userID = $_GET['usrId'];

include "get-user-details.php";

/* menu authorization */
$query_ath_all = "SELECT * FROM function_acc_detail WHERE staff_ID = '".sql_esc($get_userID)."'";
$result_ath_all = mysqli_query($dbc,$query_ath_all);  
$row_ath_all = mysqli_fetch_array($result_ath_all); 	 

include 'apprv_func_list.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo html_esc($data_setup["tajuk_sys"]); ?>">
    <title><?php echo html_esc($data_setup["title_desc"]); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!----sort table https://stackoverflow.com/questions/10683712/html-table-sort/51648529---->
    <!--   <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>-->

    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>

    <style>
    /*th {
    cursor: pointer;
    background-color: coral;
    }  */  
    .modal-dialog{
        overflow-y: initial !important
    }
    .modal-body{
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }


    div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }

    </style> 

    <script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "scrollX": true
        } );
    } );
    </script>  

    <!-- Add New -->
    <link rel="stylesheet" type="text/css" href="oth_css.css">

  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
     <?php   include "top_modal_menu.php";   ?>
    
   
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    
    <?php   include "left_admin_menu.php";   ?>
   
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> User Maintenance</h1>
          <p>Display User</p>
        </div>
         <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">User Maintenance</li>
          <li class="breadcrumb-item"><a href="display_user.php">Display User</a></li>
        </ul>
      </div>  

        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link" href="add_user.php">Add User</a></li>
            <li class="nav-item"><a class="nav-link active" href="display_user.php">Display User</a></li>
            <li class="nav-item"><a class="nav-link" href="reset_password_user.php">Reset Password</a></li>
            <li class="nav-item"><a class="nav-link" href="crt-vendor_user.php">Assign Vendor</a></li>
            <li class="nav-item"><a class="nav-link" href="display-vendor_user.php">Display Assign Vendor</a></li>
        </ul>

        <?php

        $message_design = "";
        $message_dept = "";
        $message_comp = "";
        $mesej1 = "";

        //------------------------------end function --------------------------------
        if (isset($_POST['submit']))
        {
            
            $user_no = $_POST['user_no'];
            $vendor_no = $_POST['vendor_no'];
            $staff_ID = $_POST['staff_ID'];
            $user_id = $_POST['user_id'];
            $user_fullname = $_POST['user_fullname'];
            $department = $_POST['dept'];
            $designation = $_POST['design'];
            $company = $_POST['company'];
            $user_telno1 = $_POST['user_telno1'];
            $level_id = $_POST['level_id'];
            $status = $_POST['status'];
            $user_email = $_POST['user_email'];

            //-------------dashboard------------------------
  $main_dash = addslashes($_POST['main_dash']);
  $main_dash2 = addslashes($_POST['main_dash2']);
  $main_dash3 = addslashes($_POST['main_dash3']);
  $main_dash4 = addslashes($_POST['main_dash4']); 
  $main_dash5 = addslashes($_POST['main_dash5']);


  //----------category ----------------------------
  $prd_cat = addslashes($_POST['prd_cat']);
  $f_stamp_prd = addslashes($_POST['f_stamp_prd']);
  $f_assy_prd = addslashes($_POST['f_assy_prd']);
  
  //----------planning -----------------------------
  $prd_plan = addslashes($_POST['prd_plan']);
  $f_ftp_plan_prd = addslashes($_POST['f_ftp_plan_prd']);
  $f_upl_plan_prd = addslashes($_POST['f_upl_plan_prd']);
  $f_view_plan_prd = addslashes($_POST['f_view_plan_prd']);
  $f_close_plan_prd = addslashes($_POST['f_close_plan_prd']);
  
  //-----------delivery Instruction------------------
  $main_di = addslashes($_POST['main_di']);
  $f_dlv_di = addslashes($_POST['f_dlv_di']);
  $f_dlv_di2 = addslashes($_POST['f_dlv_di2']);
  $f_dlv_di3 = addslashes($_POST['f_dlv_di3']);
  $f_dlv_di4 = addslashes($_POST['f_dlv_di4']);
  $f_dlv_di5 = addslashes($_POST['f_dlv_di5']);
  $f_dlv_di6 = addslashes($_POST['f_dlv_di6']);
  $f_dlv_di7 = addslashes($_POST['f_dlv_di7']);
  
  //----------receiving -----------------------------
  
  $pc_rec = addslashes($_POST['pc_rec']);
  $f_gr_rec0 = addslashes($_POST['f_gr_rec0']);
  $f_gr_rec = addslashes($_POST['f_gr_rec']);
  $f_gr_rec2 = addslashes($_POST['f_gr_rec2']);
  $f_grfoc_rec = addslashes($_POST['f_grfoc_rec']);
  $f_print_rec = addslashes($_POST['f_print_rec']);
  $f_printfoc_rec = addslashes($_POST['f_printfoc_rec']);
  
  //------------goods return-------------------------
  
  $f_gturn_rec = addslashes($_POST['f_gturn_rec']);	
  $f_gi_rec = addslashes($_POST['f_gi_rec']);
  $f_tp_progress = addslashes($_POST['f_tp_progress']);
  
  
  //--------subcont---------------------------
  $main_subcont = addslashes($_POST['main_subcont']);
  $f_subcont = addslashes($_POST['f_subcont']);
  $f_subcont2 = addslashes($_POST['f_subcont2']);
  
  //------------Transfer Material-------------
  
  $f_trans_rec = addslashes($_POST['f_trans_rec']);
 
  
  //---------delivery -------------------
  
  $main_dlv = addslashes($_POST['main_dlv']);
  $f_dlv_do = addslashes($_POST['f_dlv_do']);	
  $f_dlv_do2 = addslashes($_POST['f_dlv_do2']);	
  $f_dlv_do3 = addslashes($_POST['f_dlv_do3']);
  $f_dlv_do4 = addslashes($_POST['f_dlv_do4']);
  $f_dlv_do5 = addslashes($_POST['f_dlv_do5']);
  $f_dlv_do6 = addslashes($_POST['f_dlv_do6']);
  $f_dlv_do7 = addslashes($_POST['f_dlv_do7']);
  $f_dlv_do8 = addslashes($_POST['f_dlv_do8']);
  $f_dlv_do9 = addslashes($_POST['f_dlv_do9']);
  
  //----------disposal rec -----------------
  $f_dis_rec = addslashes($_POST['f_dis_rec']);
  $f_dis_approval_rec = addslashes($_POST['f_dis_approval_rec']);
  
  //------transit------------------------------
  
  $main_transit = addslashes($_POST['main_transit']);
  $f_bf_tran_dlv = addslashes($_POST['f_bf_tran_dlv']);
  $f_bf_tran_dlv2 = addslashes($_POST['f_bf_tran_dlv2']);
  
  
  
  //---------Production------------------------------
  $main_bflush = addslashes($_POST['main_bflush']);
  $f_bf_ok = addslashes($_POST['f_bf_ok']);
  $f_bf_ng = addslashes($_POST['f_bf_ng']);
  $f_bf_pending = addslashes($_POST['f_bf_pending']);
  $f_bf_handwork = addslashes($_POST['f_bf_handwork']);
  $f_bf_pend_conf_prd = addslashes($_POST['f_bf_pend_conf_prd']);
  $f_pend_rwork_conf_prd = addslashes($_POST['f_pend_rwork_conf_prd']);
  $f_pend_hwork_conf_prd = addslashes($_POST['f_pend_hwork_conf_prd']);
  $main_disposal = addslashes($_POST['main_disposal']);
  $f_comp_rej_prd = addslashes($_POST['f_comp_rej_prd']);
  $f_dis_prd = addslashes($_POST['f_dis_prd']);
  $f_dis_list_prd = addslashes($_POST['f_dis_list_prd']);
  $f_dis_approval_prd = addslashes($_POST['f_dis_approval_prd']);
  $f_dis_approval_prd2 = addslashes($_POST['f_dis_approval_prd2']);
  $f_dis_approval_prd3 = addslashes($_POST['f_dis_approval_prd3']);
  $f_dis_approval_prd4 = addslashes($_POST['f_dis_approval_prd4']);
  $f_print_prd = addslashes($_POST['f_print_prd']);


 //----disposal production 2 -------------------------------
   $main_disposal_prd2 = addslashes($_POST['main_disposal_prd2']);
   $f_dis_rej_prd2 = addslashes($_POST['f_dis_rej_prd2']);
   $f_comp_rej_prd2 = addslashes($_POST['f_comp_rej_prd2']);



//---------Return  Advise----------------------------
  $main_gra = addslashes($_POST['main_gra']);
  $f_gra_qc = addslashes($_POST['f_gra_qc']);
  $f_print_qc = addslashes($_POST['f_print_qc']);
  
   //----disposal QC  -------------------------------
   $main_disposal_qc = addslashes($_POST['main_disposal_qc']);
   $f_dis_approval_qc = addslashes($_POST['f_dis_approval_qc']);
   $f_comp_rej_qc = addslashes($_POST['f_comp_rej_qc']);
   
 //----disposal--------------------------------------

  $f_dis_approval_ex_qc = addslashes($_POST['f_dis_approval_ex_qc']);
  $f_dis_approval_h_qc = addslashes($_POST['f_dis_approval_h_qc']);
  
   $f_hqc_smenu1 = addslashes($_POST['f_hqc_smenu1']);
   $f_hqc_smenu2 = addslashes($_POST['f_hqc_smenu2']);
   $f_hqc_smenu3 = addslashes($_POST['f_hqc_smenu3']);
 
 
 //-----------cancellation ---------------------------
 
  $main_canc = addslashes($_POST['main_canc']);
  $f_canc_smenu1 = addslashes($_POST['f_canc_smenu1']);
  $f_canc_smenu2 = addslashes($_POST['f_canc_smenu2']);
  $f_canc_smenu3 = addslashes($_POST['f_canc_smenu3']);
  $f_canc_smenu4 = addslashes($_POST['f_canc_smenu4']);
  $f_canc_smenu5 = addslashes($_POST['f_canc_smenu5']);
  $f_canc_smenu6 = addslashes($_POST['f_canc_smenu6']);
  $f_canc_smenu7 = addslashes($_POST['f_canc_smenu7']);
  $f_canc_smenu8 = addslashes($_POST['f_canc_smenu8']);
  $f_canc_smenu9 = addslashes($_POST['f_canc_smenu9']);
  $f_canc_smenu10 = addslashes($_POST['f_canc_smenu10']);
  $f_canc_smenu11 = addslashes($_POST['f_canc_smenu11']);
  $f_canc_smenu12 = addslashes($_POST['f_canc_smenu12']);
  $f_canc_smenu13 = addslashes($_POST['f_canc_smenu13']);

  //-----------report--------------------------------------


  $main_rpt = addslashes($_POST['main_rpt']);
  $f_rpt_smenu0 = addslashes($_POST['f_rpt_smenu0']);
  $f_rpt_smenu1 = addslashes($_POST['f_rpt_smenu1']);
  $f_rpt_smenu2 = addslashes($_POST['f_rpt_smenu2']);
  $f_rpt_smenu3 = addslashes($_POST['f_rpt_smenu3']);
  $f_rpt_smenu4 = addslashes($_POST['f_rpt_smenu4']);
  $f_rpt_smenu5 = addslashes($_POST['f_rpt_smenu5']);
  $f_rpt_smenu6 = addslashes($_POST['f_rpt_smenu6']);
  $f_rpt_smenu7 = addslashes($_POST['f_rpt_smenu7']);
  $f_rpt_smenu8 = addslashes($_POST['f_rpt_smenu8']);
  $f_rpt_smenu9 = addslashes($_POST['f_rpt_smenu9']);
  $f_rpt_smenu10 = addslashes($_POST['f_rpt_smenu10']);
  $f_rpt_smenu11 = addslashes($_POST['f_rpt_smenu11']);
  $f_rpt_smenu12 = addslashes($_POST['f_rpt_smenu12']);
  $f_rpt_smenu13 = addslashes($_POST['f_rpt_smenu13']);
  $f_rpt_smenu14 = addslashes($_POST['f_rpt_smenu14']);
  $f_rpt_smenu15 = addslashes($_POST['f_rpt_smenu15']);
  $f_rpt_smenu16 = addslashes($_POST['f_rpt_smenu16']);
  $f_rpt_smenu17 = addslashes($_POST['f_rpt_smenu17']);
  $f_rpt_smenu18 = addslashes($_POST['f_rpt_smenu18']);
  $f_rpt_smenu19 = addslashes($_POST['f_rpt_smenu19']);
  $f_rpt_smenu20 = addslashes($_POST['f_rpt_smenu20']);
  $f_rpt_smenu21 = addslashes($_POST['f_rpt_smenu21']);
  $f_rpt_smenu22 = addslashes($_POST['f_rpt_smenu22']);
 // $f_rpt_smenu23 = addslashes($_POST['f_rpt_smenu23']);
	
  //---------FTP Monitor ---------------------
  
  $main_ftp = addslashes($_POST['main_ftp']);
  $f_ftp_smenu1 = addslashes($_POST['f_ftp_smenu1']);
  $f_ftp_smenu2 = addslashes($_POST['f_ftp_smenu2']);
  $f_ftp_smenu3 = addslashes($_POST['f_ftp_smenu3']);
  $f_ftp_smenu4 = addslashes($_POST['f_ftp_smenu4']);
  $f_ftp_smenu5 = addslashes($_POST['f_ftp_smenu5']);
  $f_ftp_smenu6 = addslashes($_POST['f_ftp_smenu6']);
  $f_ftp_smenu7 = addslashes($_POST['f_ftp_smenu7']);
  $f_ftp_smenu8 = addslashes($_POST['f_ftp_smenu8']);
  $f_ftp_smenu9 = addslashes($_POST['f_ftp_smenu9']);
  $f_ftp_smenu10 = addslashes($_POST['f_ftp_smenu10']);
  $f_ftp_smenu11 = addslashes($_POST['f_ftp_smenu11']);
  $f_ftp_smenu12 = addslashes($_POST['f_ftp_smenu12']);
  $f_ftp_smenu13 = addslashes($_POST['f_ftp_smenu13']);
  $f_ftp_smenu14 = addslashes($_POST['f_ftp_smenu14']);
  $f_ftp_smenu15 = addslashes($_POST['f_ftp_smenu15']);
  $f_ftp_smenu16 = addslashes($_POST['f_ftp_smenu16']);
 
 //---------CEO ---------------------
  
  $main_coo = addslashes($_POST['main_coo']);
  $f_coo_smenu1 = addslashes($_POST['f_coo_smenu1']);
  $f_coo_smenu2 = addslashes($_POST['f_coo_smenu2']);
  $f_coo_smenu3 = addslashes($_POST['f_coo_smenu3']);
  $f_coo_smenu4 = addslashes($_POST['f_coo_smenu4']);
  $f_coo_smenu5 = addslashes($_POST['f_coo_smenu5']);
  
   //--------PO -------------------
  $main_po = addslashes($_POST['main_po']);
  $f_po_smenu1 = addslashes($_POST['f_po_smenu1']);
  $f_po_smenu2 = addslashes($_POST['f_po_smenu2']);
  $f_po_smenu3 = addslashes($_POST['f_po_smenu3']);
  
  
   //--------MFO -------------------
  $main_mfo = addslashes($_POST['main_mfo']);
  $f_mfo_smenu1 = addslashes($_POST['f_mfo_smenu1']);
  $f_mfo_smenu2 = addslashes($_POST['f_mfo_smenu2']);
  $f_mfo_smenu3 = addslashes($_POST['f_mfo_smenu3']);

  $f_close_pps = addslashes($_POST['f_close_pps']);
  


            $query_search = "SELECT user_no FROM user_detail where user_no = '".sql_esc($get_userNo)."'";
            $result_search = mysqli_query($dbc,$query_search);   //run the query.
            $num_search = mysqli_num_rows($result_search);   //how many suppliers are there?

            if($num_search == 1) {

                $row = mysqli_fetch_array($result_search);

                $query_upd = " UPDATE user_detail SET user_fullname='".sql_esc($user_fullname)."', department = '".sql_esc($department)."', designation = '".sql_esc($designation)."', company = '".sql_esc($company)."', 
                                    user_telno1='".sql_esc($user_telno1)."', user_telno2='".sql_esc($user_telno2)."', user_fax='".sql_esc($user_fax)."', user_email='".sql_esc($user_email)."', date_update= NOW(), user_update ='".sql_esc($username)."', 
                                        status = '".sql_esc($status)."', level_id = '".sql_esc($level_id)."' 
                                            WHERE user_no = '".sql_esc($get_userNo)."'";
				$result_upd = mysqli_query($dbc,$query_upd); 
				
				//-----update table login_detail
				$query_upd3 = " UPDATE login_detail SET company = '".sql_esc($company)."', user_email='".sql_esc($user_email)."', status = '".sql_esc($status)."', level_id = '".sql_esc($level_id)."', user_update = '".sql_esc($res["staff_ID"])."',
                                    date_update = NOW() 
                                        WHERE staff_ID = '".sql_esc($usr_id)."'";
				$result_upd3 = mysqli_query($dbc,$query_upd3); 

                //update authorization
                $query_search2 = " SELECT staff_ID FROM function_acc_detail WHERE staff_ID = '".sql_esc($usr_id)."'";
                $result_search2 = mysqli_query($dbc,$query_search2);   //run the query.
                $num_search2 = mysqli_num_rows($result_search2);   //how many suppliers are there?

                if($num_search2 > 0) {


     $query_upd2 = "UPDATE function_acc_detail SET user_fullname = '".sql_esc($user_fullname)."', main_dash = '".sql_esc($main_dash)."', main_dash2 = '".sql_esc($main_dash2)."', main_dash3 = '".sql_esc($main_dash3)."', main_dash4 = '".sql_esc($main_dash4)."', main_dash5 = '".sql_esc($main_dash5)."', prd_cat ='".sql_esc($prd_cat)."', f_stamp_prd ='".sql_esc($f_stamp_prd)."', f_assy_prd ='".sql_esc($f_assy_prd)."', prd_plan ='".sql_esc($prd_plan)."', f_ftp_plan_prd='".sql_esc($f_ftp_plan_prd)."', f_upl_plan_prd='".sql_esc($f_upl_plan_prd)."', f_view_plan_prd='".sql_esc($f_view_plan_prd)."', f_close_plan_prd='".sql_esc($f_close_plan_prd)."', main_di ='".sql_esc($main_di)."', f_dlv_di ='".sql_esc($f_dlv_di)."', f_dlv_di2 ='".sql_esc($f_dlv_di2)."', f_dlv_di3 ='".sql_esc($f_dlv_di3)."', f_dlv_di4 ='".sql_esc($f_dlv_di4)."', f_dlv_di5 ='".sql_esc($f_dlv_di5)."', f_dlv_di6 ='".sql_esc($f_dlv_di6)."', f_dlv_di7 ='".sql_esc($f_dlv_di7)."', pc_rec = '".sql_esc($pc_rec)."', f_gr_rec0 = '".sql_esc($f_gr_rec0)."', f_gr_rec = '".sql_esc($f_gr_rec)."', f_gr_rec2 = '".sql_esc($f_gr_rec2)."', f_grfoc_rec = '".sql_esc($f_grfoc_rec)."', f_print_rec = '".sql_esc($f_print_rec)."', f_printfoc_rec = '".sql_esc($f_printfoc_rec)."', f_gturn_rec ='".sql_esc($f_gturn_rec)."', f_gi_rec ='".sql_esc($f_gi_rec)."', f_tp_progress ='".sql_esc($f_tp_progress)."', main_subcont ='".sql_esc($main_subcont)."', f_subcont ='".sql_esc($f_subcont)."', f_subcont2 ='".sql_esc($f_subcont2)."', f_trans_rec ='".sql_esc($f_trans_rec)."', main_dlv ='".sql_esc($main_dlv)."', f_dlv_do ='".sql_esc($f_dlv_do)."', f_dlv_do2 ='".sql_esc($f_dlv_do2)."', f_dlv_do3 ='".sql_esc($f_dlv_do3)."', f_dlv_do4 ='".sql_esc($f_dlv_do4)."', f_dlv_do5 ='".sql_esc($f_dlv_do5)."', f_dlv_do6 ='".sql_esc($f_dlv_do6)."', f_dlv_do7 ='".sql_esc($f_dlv_do7)."', f_dlv_do8 ='".sql_esc($f_dlv_do8)."', f_dlv_do9 ='".sql_esc($f_dlv_do9)."', f_dis_rec ='".sql_esc($f_dis_rec)."', f_dis_approval_rec ='".sql_esc($f_dis_approval_rec)."', main_transit ='".sql_esc($main_transit)."', f_bf_tran_dlv ='".sql_esc($f_bf_tran_dlv)."', f_bf_tran_dlv2 ='".sql_esc($f_bf_tran_dlv2)."', main_bflush ='".sql_esc($main_bflush)."', f_bf_ok='".sql_esc($f_bf_ok)."', f_bf_ng='".sql_esc($f_bf_ng)."', f_bf_pending='".sql_esc($f_bf_pending)."', f_bf_handwork='".sql_esc($f_bf_handwork)."', f_bf_pend_conf_prd='".sql_esc($f_bf_pend_conf_prd)."', f_pend_rwork_conf_prd='".sql_esc($f_pend_rwork_conf_prd)."', f_pend_hwork_conf_prd='".sql_esc($f_pend_hwork_conf_prd)."', main_disposal ='".sql_esc($main_disposal)."', f_comp_rej_prd='".sql_esc($f_comp_rej_prd)."', main_disposal_prd2 ='".sql_esc($main_disposal_prd2)."', f_dis_rej_prd2='".sql_esc($f_dis_rej_prd2)."', f_comp_rej_prd2='".sql_esc($f_comp_rej_prd2)."',  main_disposal_qc ='".sql_esc($main_disposal_qc)."', f_comp_rej_qc = '".sql_esc($f_comp_rej_qc)."', f_dis_prd='".sql_esc($f_dis_prd)."', f_dis_list_prd='".sql_esc($f_dis_list_prd)."', f_dis_approval_prd='".sql_esc($f_dis_approval_prd)."', f_dis_approval_prd2='".sql_esc($f_dis_approval_prd2)."', f_dis_approval_prd3='".sql_esc($f_dis_approval_prd3)."', f_dis_approval_prd4='".sql_esc($f_dis_approval_prd4)."', f_print_prd='".sql_esc($f_print_prd)."',  main_gra ='".sql_esc($main_gra)."', f_gra_qc = '".sql_esc($f_gra_qc)."', f_print_qc ='".sql_esc($f_print_qc)."', f_dis_approval_qc ='".sql_esc($f_dis_approval_qc)."', f_dis_approval_ex_qc ='".sql_esc($f_dis_approval_ex_qc)."', f_dis_approval_h_qc ='".sql_esc($f_dis_approval_h_qc)."', f_hqc_smenu1 = '".sql_esc($f_hqc_smenu1)."', f_hqc_smenu2 = '".sql_esc($f_hqc_smenu2)."', f_hqc_smenu3 = '".sql_esc($f_hqc_smenu3)."', main_canc = '".sql_esc($main_canc)."', f_canc_smenu1 = '".sql_esc($f_canc_smenu1)."', f_canc_smenu2 = '".sql_esc($f_canc_smenu2)."', f_canc_smenu3 = '".sql_esc($f_canc_smenu3)."', f_canc_smenu4 = '".sql_esc($f_canc_smenu4)."', f_canc_smenu5 = '".sql_esc($f_canc_smenu5)."',f_canc_smenu6 = '".sql_esc($f_canc_smenu6)."', f_canc_smenu7 = '".sql_esc($f_canc_smenu7)."', f_canc_smenu8 = '".sql_esc($f_canc_smenu8)."', f_canc_smenu9 = '".sql_esc($f_canc_smenu9)."', f_canc_smenu10 = '".sql_esc($f_canc_smenu10)."', f_canc_smenu11 = '".sql_esc($f_canc_smenu11)."', f_canc_smenu12 = '".sql_esc($f_canc_smenu12)."', f_canc_smenu13 = '".sql_esc($f_canc_smenu13)."', main_rpt = '".sql_esc($main_rpt)."', f_rpt_smenu0 = '".sql_esc($f_rpt_smenu0)."', f_rpt_smenu1 = '".sql_esc($f_rpt_smenu1)."', f_rpt_smenu2 = '".sql_esc($f_rpt_smenu2)."', f_rpt_smenu3 = '".sql_esc($f_rpt_smenu3)."', f_rpt_smenu4 = '".sql_esc($f_rpt_smenu4)."', f_rpt_smenu5 = '".sql_esc($f_rpt_smenu5)."', f_rpt_smenu6 = '".sql_esc($f_rpt_smenu6)."', f_rpt_smenu7 = '".sql_esc($f_rpt_smenu7)."', f_rpt_smenu8 = '".sql_esc($f_rpt_smenu8)."', f_rpt_smenu9 = '".sql_esc($f_rpt_smenu9)."', f_rpt_smenu10 = '".sql_esc($f_rpt_smenu10)."', f_rpt_smenu11 = '".sql_esc($f_rpt_smenu11)."', f_rpt_smenu12 = '".sql_esc($f_rpt_smenu12)."', f_rpt_smenu13 = '".sql_esc($f_rpt_smenu13)."', f_rpt_smenu14 = '".sql_esc($f_rpt_smenu14)."', f_rpt_smenu15 = '".sql_esc($f_rpt_smenu15)."', f_rpt_smenu16 = '".sql_esc($f_rpt_smenu16)."', f_rpt_smenu17 = '".sql_esc($f_rpt_smenu17)."', f_rpt_smenu18 = '".sql_esc($f_rpt_smenu18)."', f_rpt_smenu19 = '".sql_esc($f_rpt_smenu19)."', f_rpt_smenu20 = '".sql_esc($f_rpt_smenu20)."', f_rpt_smenu21 = '".sql_esc($f_rpt_smenu21)."', f_rpt_smenu22 = '".sql_esc($f_rpt_smenu22)."',  main_ftp = '".sql_esc($main_ftp)."', f_ftp_smenu1 = '".sql_esc($f_ftp_smenu1)."', f_ftp_smenu2 = '".sql_esc($f_ftp_smenu2)."', f_ftp_smenu3 = '".sql_esc($f_ftp_smenu3)."', f_ftp_smenu4 = '".sql_esc($f_ftp_smenu4)."', f_ftp_smenu5 = '".sql_esc($f_ftp_smenu5)."', f_ftp_smenu6 = '".sql_esc($f_ftp_smenu6)."', f_ftp_smenu7 = '".sql_esc($f_ftp_smenu7)."', f_ftp_smenu8 = '".sql_esc($f_ftp_smenu8)."', f_ftp_smenu9 = '".sql_esc($f_ftp_smenu9)."', f_ftp_smenu10 = '".sql_esc($f_ftp_smenu10)."', f_ftp_smenu11 = '".sql_esc($f_ftp_smenu11)."', f_ftp_smenu12 = '".sql_esc($f_ftp_smenu12)."', f_ftp_smenu13 = '".sql_esc($f_ftp_smenu13)."', f_ftp_smenu13 = '".sql_esc($f_ftp_smenu13)."', f_ftp_smenu14 = '".sql_esc($f_ftp_smenu14)."', f_ftp_smenu15 = '".sql_esc($f_ftp_smenu15)."', main_coo = '".sql_esc($main_coo)."', f_coo_smenu1 = '".sql_esc($f_coo_smenu1)."', f_coo_smenu2 = '".sql_esc($f_coo_smenu2)."', f_coo_smenu3 = '".sql_esc($f_coo_smenu3)."', f_coo_smenu4 = '".sql_esc($f_coo_smenu4)."', f_coo_smenu5 = '".sql_esc($f_coo_smenu5)."', f_close_pps = '".sql_esc($f_close_pps)."', main_po = '".sql_esc($main_po)."', f_po_smenu1 = '".sql_esc($f_po_smenu1)."', f_po_smenu2 = '".sql_esc($f_po_smenu2)."', f_po_smenu3 = '".sql_esc($f_po_smenu3)."', main_mfo = '".sql_esc($main_mfo)."', f_mfo_smenu1 = '".sql_esc($f_mfo_smenu1)."', f_mfo_smenu2 = '".sql_esc($f_mfo_smenu2)."', f_mfo_smenu3 = '".sql_esc($f_mfo_smenu3)."', user_update = '".sql_esc($staff_ID)."', date_update = NOW() WHERE staff_ID = '".sql_esc($usr_id)."'";
	$result_upd2 = mysqli_query($dbc,$query_upd2); 


                }else{
					
					
	$query_roles = "INSERT INTO function_acc_detail (staff_ID,user_fullname,plant_code,main_dash,main_dash2,main_dash3,main_dash4,main_dash5,prd_cat,f_stamp_prd,f_assy_prd,prd_plan,f_ftp_plan_prd,f_upl_plan_prd,f_view_plan_prd,f_close_plan_prd,main_di,f_dlv_di,f_dlv_di2,f_dlv_di3,f_dlv_di4,f_dlv_di5,f_dlv_di6,f_dlv_di7,pc_rec,f_gr_rec0,f_gr_rec,f_gr_rec2,f_grfoc_rec,f_print_rec,f_printfoc_rec,f_gturn_rec,f_gi_rec,f_tp_progress,main_subcont,f_subcont,f_subcont2,f_trans_rec,main_dlv,f_dlv_do,f_dlv_do2,f_dlv_do3,f_dlv_do4,f_dlv_do5,f_dlv_do6,f_dlv_do7,f_dlv_do8,f_dlv_do9,f_dis_rec,f_dis_approval_rec,main_transit,f_bf_tran_dlv,f_bf_tran_dlv2,main_bflush,f_bf_ok,f_bf_ng,f_bf_pending,f_bf_handwork,f_bf_pend_conf_prd,f_pend_rwork_conf_prd,f_pend_hwork_conf_prd,main_disposal,f_comp_rej_prd,main_disposal_prd2,f_dis_rej_prd2,f_comp_rej_prd2,main_disposal_qc,f_comp_rej_qc,f_dis_prd,f_dis_list_prd,f_dis_approval_prd,f_dis_approval_prd2,f_dis_approval_prd3,f_dis_approval_prd4,f_print_prd,main_gra,f_gra_qc,f_print_qc,f_dis_approval_qc,f_dis_approval_ex_qc,f_dis_approval_h_qc,f_hqc_smenu1,f_hqc_smenu2,f_hqc_smenu3,main_canc,f_canc_smenu1,f_canc_smenu2,f_canc_smenu3,f_canc_smenu4,f_canc_smenu5,f_canc_smenu6,f_canc_smenu7,f_canc_smenu8,f_canc_smenu9,f_canc_smenu10,f_canc_smenu11,f_canc_smenu12,f_canc_smenu13,main_rpt, f_rpt_smenu0,f_rpt_smenu1,f_rpt_smenu2,f_rpt_smenu3,f_rpt_smenu4,f_rpt_smenu5,f_rpt_smenu6,f_rpt_smenu7,f_rpt_smenu8,f_rpt_smenu9,f_rpt_smenu10,f_rpt_smenu11,f_rpt_smenu12,f_rpt_smenu13,f_rpt_smenu14,f_rpt_smenu15,f_rpt_smenu16,f_rpt_smenu17,f_rpt_smenu18,f_rpt_smenu19,f_rpt_smenu20,f_rpt_smenu21,f_rpt_smenu22,f_rpt_smenu23,main_ftp,f_ftp_smenu1,f_ftp_smenu2,f_ftp_smenu3,f_ftp_smenu4,f_ftp_smenu5,f_ftp_smenu6,f_ftp_smenu7,f_ftp_smenu8,f_ftp_smenu9,f_ftp_smenu10,f_ftp_smenu11,f_ftp_smenu12,f_ftp_smenu13,f_ftp_smenu14,f_ftp_smenu15,f_ftp_smenu16,main_coo,f_coo_smenu1,f_coo_smenu2,f_coo_smenu3,f_coo_smenu4,f_coo_smenu5,f_close_pps,main_po,f_po_smenu1,f_po_smenu2,f_po_smenu3,main_mfo,f_mfo_smenu1,f_mfo_smenu2,f_mfo_smenu3,user_create,date_create,user_update,date_update,status_acc) VALUES ('".strtoupper($user_id)."','".strtoupper($user_fullname)."','".sql_esc($vendor_no)."','".sql_esc($main_dash)."','".sql_esc($main_dash2)."','".sql_esc($main_dash3)."','".sql_esc($main_dash4)."','".sql_esc($main_dash5)."','".sql_esc($prd_cat)."','".sql_esc($f_stamp_prd)."','".sql_esc($f_assy_prd)."','".sql_esc($prd_plan)."','".sql_esc($f_ftp_plan_prd)."','".sql_esc($f_upl_plan_prd)."','".sql_esc($f_view_plan_prd)."','".sql_esc($f_close_plan_prd)."','".sql_esc($main_di)."','".sql_esc($f_dlv_di)."','".sql_esc($f_dlv_di2)."','".sql_esc($f_dlv_di3)."','".sql_esc($f_dlv_di4)."','".sql_esc($f_dlv_di5)."','".sql_esc($f_dlv_di6)."','".sql_esc($f_dlv_di7)."','".sql_esc($pc_rec)."','".sql_esc($f_gr_rec0)."','".sql_esc($f_gr_rec)."','".sql_esc($f_gr_rec2)."','".sql_esc($f_grfoc_rec)."','".sql_esc($f_print_rec)."','".sql_esc($f_printfoc_rec)."','".sql_esc($f_gturn_rec)."','".sql_esc($f_gi_rec)."','".sql_esc($f_tp_progress)."','".sql_esc($main_subcont)."','".sql_esc($f_subcont)."','".sql_esc($f_subcont2)."','".sql_esc($f_trans_rec)."','".sql_esc($main_dlv)."','".sql_esc($f_dlv_do)."','".sql_esc($f_dlv_do2)."','".sql_esc($f_dlv_do3)."','".sql_esc($f_dlv_do4)."','".sql_esc($f_dlv_do5)."','".sql_esc($f_dlv_do6)."','".sql_esc($f_dlv_do7)."','".sql_esc($f_dlv_do8)."','".sql_esc($f_dlv_do9)."','".sql_esc($f_dis_rec)."','".sql_esc($f_dis_approval_rec)."','".sql_esc($main_transit)."','".sql_esc($f_bf_tran_dlv)."','".sql_esc($f_bf_tran_dlv2)."','".sql_esc($main_bflush)."','".sql_esc($f_bf_ok)."','".sql_esc($f_bf_ng)."','".sql_esc($f_bf_pending)."','".sql_esc($f_bf_handwork)."','".sql_esc($f_bf_pend_conf_prd)."','".sql_esc($f_pend_rwork_conf_prd)."','".sql_esc($f_pend_hwork_conf_prd)."','".sql_esc($main_disposal)."','".sql_esc($f_comp_rej_prd)."','".sql_esc($main_disposal_prd2)."','".sql_esc($f_dis_rej_prd2)."','".sql_esc($f_comp_rej_prd2)."','".sql_esc($main_disposal_qc)."','".sql_esc($f_comp_rej_qc)."','".sql_esc($f_dis_prd)."','".sql_esc($f_dis_list_prd)."','".sql_esc($f_dis_approval_prd)."','".sql_esc($f_dis_approval_prd2)."','".sql_esc($f_dis_approval_prd3)."','".sql_esc($f_dis_approval_prd4)."','".sql_esc($f_print_prd)."','".sql_esc($main_gra)."','".sql_esc($f_gra_qc)."','".sql_esc($f_print_qc)."','".sql_esc($f_dis_approval_qc)."','".sql_esc($f_dis_approval_ex_qc)."','".sql_esc($f_dis_approval_h_qc)."','".sql_esc($f_hqc_smenu1)."','".sql_esc($f_hqc_smenu2)."','".sql_esc($f_hqc_smenu3)."','".sql_esc($main_canc)."','".sql_esc($f_canc_smenu1)."','".sql_esc($f_canc_smenu2)."','".sql_esc($f_canc_smenu3)."','".sql_esc($f_canc_smenu4)."','".sql_esc($f_canc_smenu5)."','".sql_esc($f_canc_smenu6)."','".sql_esc($f_canc_smenu7)."','".sql_esc($f_canc_smenu8)."','".sql_esc($f_canc_smenu9)."','".sql_esc($f_canc_smenu10)."','".sql_esc($f_canc_smenu11)."','".sql_esc($f_canc_smenu12)."','".sql_esc($f_canc_smenu13)."','".sql_esc($main_rpt)."','".sql_esc($f_rpt_smenu0)."','".sql_esc($f_rpt_smenu1)."','".sql_esc($f_rpt_smenu2)."','".sql_esc($f_rpt_smenu3)."','".sql_esc($f_rpt_smenu4)."','".sql_esc($f_rpt_smenu5)."','".sql_esc($f_rpt_smenu6)."','".sql_esc($f_rpt_smenu7)."','".sql_esc($f_rpt_smenu8)."','".sql_esc($f_rpt_smenu9)."','".sql_esc($f_rpt_smenu10)."','".sql_esc($f_rpt_smenu11)."','".sql_esc($f_rpt_smenu12)."','".sql_esc($f_rpt_smenu13)."','".sql_esc($f_rpt_smenu14)."','".sql_esc($f_rpt_smenu15)."','".sql_esc($f_rpt_smenu16)."','".sql_esc($f_rpt_smenu17)."','".sql_esc($f_rpt_smenu18)."','".sql_esc($f_rpt_smenu19)."','".sql_esc($f_rpt_smenu20)."','".sql_esc($f_rpt_smenu21)."','".sql_esc($f_rpt_smenu22)."','','".sql_esc($main_ftp)."','".sql_esc($f_ftp_smenu1)."','".sql_esc($f_ftp_smenu2)."','".sql_esc($f_ftp_smenu3)."','".sql_esc($f_ftp_smenu4)."','".sql_esc($f_ftp_smenu5)."','".sql_esc($f_ftp_smenu6)."','".sql_esc($f_ftp_smenu7)."','".sql_esc($f_ftp_smenu8)."','".sql_esc($f_ftp_smenu9)."','".sql_esc($f_ftp_smenu10)."','".sql_esc($f_ftp_smenu11)."','".sql_esc($f_ftp_smenu12)."','".sql_esc($f_ftp_smenu13)."','".sql_esc($f_ftp_smenu14)."','".sql_esc($f_ftp_smenu15)."','".sql_esc($f_ftp_smenu16)."','".sql_esc($main_coo)."','".sql_esc($f_coo_smenu1)."','".sql_esc($f_coo_smenu2)."','".sql_esc($f_coo_smenu3)."','".sql_esc($f_coo_smenu4)."','".sql_esc($f_coo_smenu5)."','".sql_esc($f_close_pps)."','".sql_esc($main_po)."','".sql_esc($f_po_smenu1)."','".sql_esc($f_po_smenu2)."','".sql_esc($f_po_smenu3)."','".sql_esc($main_mfo)."','".sql_esc($f_mfo_smenu1)."','".sql_esc($f_mfo_smenu2)."','".sql_esc($f_mfo_smenu3)."','".sql_esc($username)."',NOW(),'','','Y')";
    $result_roles = mysqli_query($dbc,$query_roles);				
									
                
                }



                if($result_upd || $result_upd3 || $result_upd2 || $result_roles){
                    
                    $mesej1="<script language='JavaScript'>alert('Profile is successfully updated.');window.location='display_user.php';</script>";
                }

            }



        }

        echo $mesej1;

        ?>

        <div class="row">
            <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                <h3 class="tile-title">Account Profile</h3>

                <form class="form-horizontal" method="post" action="" >

                    <div class="form-group row">
                        <label class="control-label col-md-2">Company Code</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" value="<?php echo html_esc($vendor_no); ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Staff ID</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" value="<?php echo $usr_id; ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Name <span class="compulsStar">* </span></label>
                        <div class="col-md-8">
                            <input class="form-control" id="user_fullname" name="user_fullname" type="text" value="<?php echo $usr_name; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Company <span class="compulsStar">* </span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="company" id="company">
                                <option value="">-- Select Company --</option>
                                <?php				  
                                $query3 = "SELECT * FROM company WHERE status_comp = 'Y'";
                                $result3 = mysqli_query($dbc,$query3);

                                while($row3 = mysqli_fetch_array($result3)) 
                                {
                                ?>
                                <option value="<?php echo html_esc($row3["comp_code"]); ?>" <?php if($row3["comp_code"] == $usr_comp2) { echo "selected"; } ?>> <?php echo html_esc($row3["comp_code"]); ?> - <?php echo html_esc($row3["comp_name"]); ?></option>
                                <?php } ?>
                                
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Department <span class="compulsStar">* </span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="dept" id="dept">
                                <option value="">-- Select Department --</option>
                                <?php				  
                                $query4 = "SELECT * FROM department ORDER BY dept_code ASC";
                                $result4 = mysqli_query($dbc,$query4);

                                while($row4 = mysqli_fetch_array($result4)) 
                                {
                                ?>
                                <option value="<?php echo html_esc($row4["id_dept"]); ?>" <?php if($row4["id_dept"] == $usr_dept2) { echo "selected"; } ?>> <?php echo html_esc($row4["dept_code"]); ?> - <?php echo html_esc($row4["dept_name"]); ?></option>
                                <?php } ?>
                                
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Designation <span class="compulsStar">* </span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="design" id="design">
                                <option value="">-- Select Designation --</option>
                                <?php				  
                                $query5 = "SELECT * FROM designation ORDER BY design ASC";
                                $result5 = mysqli_query($dbc,$query5);

                                while($row5 = mysqli_fetch_array($result5)) 
                                {
                                ?>
                                <option value="<?php echo html_esc($row5["id_design"]); ?>" <?php if($row5["id_design"] == $usr_desg2) { echo "selected"; } ?>> <?php echo html_esc($row5["design"]); ?></option>
                                <?php } ?>
                                
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Telephone No. 1 <span class="compulsStar">* </span></label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" value="<?php echo $usr_tel1; ?>" id="user_telno1" name="user_telno1">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Telephone No. 2</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" value="<?php echo $usr_tel2; ?>" id="user_telno2" name="user_telno2">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Fax No.</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" value="<?php echo $usr_fax; ?>" id="user_fax" name="user_fax">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Email <span class="compulsStar">* </span></label>
                        <div class="col-md-8">
                            <input class="form-control" type="email" value="<?php echo $usr_email; ?>" id="user_email" name="user_email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Level  <span class="compulsStar">* </span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="level_id" id="level_id">
                                <option value="">-- Select Level --</option>
                                <?php				  
                                $query6 = "SELECT * FROM level_detail WHERE status_level = 'Y'";
                                $result6 = mysqli_query($dbc,$query6);

                                while($row6 = mysqli_fetch_array($result6)) 
                                {
                                ?>
                                <option value="<?php echo html_esc($row6["id_level"]); ?>" <?php if($row6["id_level"] == $usr_level2) { echo "selected"; } ?>> <?php echo html_esc($row6["desc_level"]); ?></option>
                                <?php } ?>
                                
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Status User <span class="compulsStar">* </span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="status" id="status">
                                <option value="" placeholder="Select Status"> -- Select Status --</option>
                                <option value="AC" <?php if($usr_accsta == "AC") { ?> selected="selected"<?php } ?>>Active</option>
                                <option value="NA" <?php if($usr_accsta == "NA") { ?> selected="selected"<?php } ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">User Created <span class="compulsStar">* </span></label>
                        <div class="col-md-8">
                            <input class="form-control" type="email" value="<?php echo $created_by; ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Date Created<span class="compulsStar">* </span></label>
                        <div class="col-md-8">
                            <input class="form-control" type="email" value="<?php echo $created_date; ?>" disabled>
                        </div>
                    </div>

                   <hr>

                   <div class="form-group row">
                        <label class="control-label col-md-2">User Roles Details </label>
                        <div class="col-md-8">

                            <p><b>Dashboard</b></p>
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash" name="main_dash" value="Y" <?php if($row_ath_all["main_dash"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Dashboard 1</span>
                  </label>
                </div>  
            
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash2" name="main_dash2" value="Y" <?php if($row_ath_all["main_dash2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Dashboard 2</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash3"  name="main_dash3" value="Y" <?php if($row_ath_all["main_dash3"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Dashboard 3</span>
                  </label>
                </div> 
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash4" name="main_dash4" value="Y" <?php if($row_ath_all["main_dash4"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Dashboard 4</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash5"  name="main_dash5" value="Y" <?php if($row_ath_all["main_dash5"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Dashboard 5</span>
                  </label>
                </div>  
                
                <hr width="100%"> 
      
              <p><b>Category Production</b></p>
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="prd_cat" name="prd_cat" value="Y" <?php if($row_ath_all["prd_cat"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Category Production</span>
                  </label>
                </div>  
            
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_stamp_prd" name="f_stamp_prd" value="Y" <?php if($row_ath_all["f_stamp_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Stamping</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_assy_prd"  name="f_assy_prd" value="Y" <?php if($row_ath_all["f_assy_prd"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Assembly</span>
                  </label>
                </div>  
                
                 <hr width="100%">  
              <!---  PLanning Menu ------>
               <p><b>Planning</b></p>
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="prd_plan" name="prd_plan" value="Y" <?php if($row_ath_all["prd_plan"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Planning</span>
                  </label>
                </div>  
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_plan_prd" name="f_ftp_plan_prd" value="Y" <?php if($row_ath_all["f_ftp_plan_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Create Planned Order</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_upl_plan_prd" name="f_upl_plan_prd" value="Y" <?php if($row_ath_all["f_upl_plan_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Upload PPS</span>
                  </label>
                </div> 
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_view_plan_prd"  name="f_view_plan_prd" value="Y" <?php if($row_ath_all["f_view_plan_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">PPS Listings</span>
                  </label>
                </div>  
              
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_close_plan_prd" name="f_close_plan_prd" value="Y" <?php if($row_ath_all["f_close_plan_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Close Planned Order</span>
                  </label>
                </div>  
              
                <hr width="100%">  
                
                <!-- Delivery Instruction --->
              
               <p><b>Delivery Instruction</b></p>
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_di" name="main_di" value="Y" <?php if($row_ath_all["main_di"] == 'Y'){ ?> checked <?php  } ?> ><span class="button-indecator">Delivery Instruction</span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di" name="f_dlv_di" value="Y" <?php if($row_ath_all["f_dlv_di"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Upload DI/Kanban</span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di2" name="f_dlv_di2" value="Y" <?php if($row_ath_all["f_dlv_di2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Inbox</span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di3" name="f_dlv_di3" value="Y" <?php if($row_ath_all["f_dlv_di3"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Print DO &amp;Tag</span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di6" name="f_dlv_di6" value="Y" <?php if($row_ath_all["f_dlv_di6"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Print DO &amp;Tag PPC</span>
                  </label>
                </div>
              
              <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di5" name="f_dlv_di5" value="Y" <?php if($row_ath_all["f_dlv_di5"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Maintain DO</span>
                  </label>
                </div>
                
                <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di4" name="f_dlv_di4" value="Y" <?php if($row_ath_all["f_dlv_di4"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Maintain DI</span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dlv_di7" name="f_dlv_di7" value="Y" <?php if($row_ath_all["f_dlv_di7"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">PO vs GR (Quantity) </span>
                  </label>
                </div>  
                
                <hr width="100%">  
            
                
                 <!-- Receiving  --->
               <p><b>Receiving</b></p>
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="pc_rec" name="pc_rec" value="Y" <?php if($row_ath_all["pc_rec"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Receiving</span>
                  </label>
                </div>  
             
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gr_rec0" name="f_gr_rec0" value="Y" <?php if($row_ath_all["f_gr_rec0"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">PO Listing</span>
                  </label>
                </div>  
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gr_rec" name="f_gr_rec" value="Y" <?php if($row_ath_all["f_gr_rec"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Goods Receipt</span>
                  </label>
                </div>  
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gr_rec2" name="f_gr_rec2" value="Y" <?php if($row_ath_all["f_gr_rec2"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Goods Receipt by PO</span>
                  </label>
                </div>     
                
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_grfoc_rec" name="f_grfoc_rec" value="Y" <?php if($row_ath_all["f_grfoc_rec"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt FOC</span>
                  </label>
                </div>     
              
              <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_print_rec"  name="f_print_rec"  value="Y" <?php if($row_ath_all["f_print_rec"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Print GR Tag</span>
                  </label>
                </div>    
                
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_printfoc_rec"  name="f_printfoc_rec"  value="Y" <?php if($row_ath_all["f_printfoc_rec"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Print GR FOC Tag</span>
                  </label>
                </div>    
              
               <hr width="100%">  
                <!-- Goods Return --->
               <p><b>Goods Return</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gturn_rec" name="f_gturn_rec" value="Y" <?php if($row_ath_all["f_gturn_rec"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Return</span>
                  </label>
                </div>    
                
                  <hr width="100%">  
                
                <!-- GI Consumable --->
               <p><b>GI Consumable</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gi_rec" name="f_gi_rec" value="Y" <?php if($row_ath_all["f_gi_rec"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">GI Consumable</span>
                  </label>
                </div>    
                
                
                
                
                  <hr width="100%">  
           
           
              <!-- Transfer Posting --->
               <p><b>Transfer Posting</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_tp_progress" name="f_tp_progress" value="Y" <?php if($row_ath_all["f_tp_progress"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Transfer Posting</span>
                  </label>
                </div>  
                  <hr width="100%">  
                
                 <!-- Subcontracting --->
                 <p><b>Subcontracting</b></p>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="main_subcont" name="main_subcont" value="Y" <?php if($row_ath_all["main_subcont"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Subcontracting</span>
                  </label>
                </div> 
                
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_subcont" name="f_subcont" value="Y" <?php if($row_ath_all["f_subcont"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Transfer to Subcont</span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_subcont2" name="f_subcont2" value="Y" <?php if($row_ath_all["f_subcont2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Print SDO</span>
                  </label>
                </div> 
                
                
                  <hr width="100%">  
                
                 <!-- Transfer Material --->
                 <p><b>Transfer Material</b></p>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_trans_rec" name="f_trans_rec" value="Y" <?php if($row_ath_all["f_trans_rec"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Transfer Material</span>
                  </label>
                </div> 
                
                <hr width="100%">  
                   
                  <!-- Delivery --->
                 <p><b>Delivery</b></p>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="main_dlv" name="main_dlv" value="Y" <?php if($row_ath_all["main_dlv"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Delivery</span>
                  </label>
                 </div>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do7" name="f_dlv_do7" value="Y" <?php if($row_ath_all["f_dlv_do7"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Sales Order Listing</span>
                  </label>
                 </div>
                   <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do" name="f_dlv_do" value="Y" <?php if($row_ath_all["f_dlv_do"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Create DO Perodua</span>
                  </label>
                 </div>
                    <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do2" name="f_dlv_do2" value="Y" <?php if($row_ath_all["f_dlv_do2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Create DO Perodua Sales</span>
                  </label>
                 </div>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do5" name="f_dlv_do5" value="Y" <?php if($row_ath_all["f_dlv_do5"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Create DO Perodua Manufacturing</span>
                  </label>
                 </div>
                  <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do3" name="f_dlv_do3" value="Y" <?php if($row_ath_all["f_dlv_do3"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Create DO Others Customer</span>
                  </label>
                 </div>
                  <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do4" name="f_dlv_do4" value="Y" <?php if($row_ath_all["f_dlv_do4"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Print DO</span>
                  </label>
                 </div>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do6" name="f_dlv_do6" value="Y" <?php if($row_ath_all["f_dlv_do6"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Closed Sales Order</span>
                  </label>
                 </div>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do8" name="f_dlv_do8" value="Y" <?php if($row_ath_all["f_dlv_do8"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Upload PDIO</span>
                  </label>
                 </div>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do9" name="f_dlv_do9" value="Y" <?php if($row_ath_all["f_dlv_do9"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Create DO Perodua</span>
                  </label>
                 </div>
                   
               <hr width="100%">  
              
                 <!-- Disposal Receiving --->
                <p><b>Disposal Receiving</b></p>
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_rec" name="f_dis_rec" value="Y" <?php if($row_ath_all["f_dis_rec"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Receiving</span>
                  </label>
                </div> 
                
                 <hr width="100%">  
              
                 <!-- Disposal Approval Receiving --->
                <p><b>Disposal Approval Receiving</b></p>
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_rec" name="f_dis_approval_rec" value="Y" <?php if($row_ath_all["f_dis_approval_rec"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Disposal Approval Receiving</span>
                  </label>
                </div>
                
                
               <hr width="100%">
                
                <!-- Transit --->
                <p><b>Transit</b></p>
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_transit" name="main_transit" value="Y" <?php if($row_ath_all["main_transit"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Transit</span>
                  </label>
                </div>
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_tran_dlv" name="f_bf_tran_dlv" value="Y" <?php if($row_ath_all["f_bf_tran_dlv"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">BF Transit</span>
                  </label>
                </div>
                
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_tran_dlv2" name="f_bf_tran_dlv2" value="Y" <?php if($row_ath_all["f_bf_tran_dlv2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Print Tag</span>
                  </label>
                </div>
                
               
               
                 <hr width="100%"> 
                
            <!-- Backflush --->
               <p><b>Backflush</b></p>
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_bflush" name="main_bflush" value="Y" <?php if($row_ath_all["main_bflush"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Backflush</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_ok" name="f_bf_ok" value="Y" <?php if($row_ath_all["f_bf_ok"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Confirmation Backflush (OK)</span>
                  </label>
                </div>  
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_ng"  name="f_bf_ng" value="Y" <?php if($row_ath_all["f_bf_ng"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Confirmation Backflush (NG)</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_pending" name="f_bf_pending" value="Y" <?php if($row_ath_all["f_bf_pending"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Confirmation Backflush (Pending) </span>
                  </label>
                </div>  
              
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_handwork" name="f_bf_handwork" value="Y" <?php if($row_ath_all["f_bf_handwork"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Confirmation Backflush (Handwork)</span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_print_prd" name="f_print_prd" value="Y" <?php if($row_ath_all["f_print_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Print Tag</span>
                  </label>
                </div> 
               
              
               <hr width="100%"> 
                
            <!-- Production --->
               <p><b>Production</b></p>
             
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_pend_conf_prd" name="f_bf_pend_conf_prd" value="Y" <?php if($row_ath_all["f_bf_pend_conf_prd"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Pending Confirmation</span>
                  </label>
                </div>  
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_pend_rwork_conf_prd" name="f_pend_rwork_conf_prd" value="Y" <?php if($row_ath_all["f_pend_rwork_conf_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Rework</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_pend_hwork_conf_prd"  name="f_pend_hwork_conf_prd" value="Y" <?php if($row_ath_all["f_pend_hwork_conf_prd"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Handwork</span>
                  </label>
                </div>  
              
                
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_list_prd"  name="f_dis_list_prd" value="Y" <?php if($row_ath_all["f_dis_list_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposals List</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_prd" name="f_dis_approval_prd" value="Y" <?php if($row_ath_all["f_dis_approval_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval - Engineering</span>
                  </label>
                </div>  
              
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_prd2" name="f_dis_approval_prd2" value="Y" <?php if($row_ath_all["f_dis_approval_prd2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval - Stamping</span>
                  </label>
                </div> 
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_prd3" name="f_dis_approval_prd3" value="Y" <?php if($row_ath_all["f_dis_approval_prd3"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval - Assembly</span>
                  </label>
                </div> 
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_prd4" name="f_dis_approval_prd4" value="Y" <?php if($row_ath_all["f_dis_approval_prd4"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval</span>
                  </label>
                </div> 
              
               <hr width="100%"> 
                
            <!-- Disposals Production --->
               <p><b>Disposals</b></p>
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_disposal" name="main_disposal" value="Y" <?php if($row_ath_all["main_disposal"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposals</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_prd" name="f_dis_prd" value="Y" <?php if($row_ath_all["f_dis_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Reject Output </span>
                  </label>
                </div>  
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_comp_rej_prd" name="f_comp_rej_prd" value="Y" <?php if($row_ath_all["f_comp_rej_prd"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Component Reject</span>
                  </label>
                </div>  
                
                 <hr width="100%"> 
                 
               <!-- Disposals Production 2 --->
               <p><b>Disposal Engineering</b></p>
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_disposal_prd2" name="main_disposal_prd2" value="Y" <?php if($row_ath_all["main_disposal_prd2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposals</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_rej_prd2" name="f_dis_rej_prd2" value="Y" <?php if($row_ath_all["f_dis_rej_prd2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Reject Part</span>
                  </label>
                </div>  
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_comp_rej_prd2" name="f_comp_rej_prd2" value="Y" <?php if($row_ath_all["f_comp_rej_prd2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Reject Component</span>
                  </label>
                </div>  
               
               
                    
                
                
              <hr width="100%"> 
                
            <!-- Return Advise --->
               <p><b>Return Advise</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_gra" name="main_gra" value="Y" <?php if($row_ath_all["main_gra"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Return Advise</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gra_qc" name="f_gra_qc" value="Y" <?php if($row_ath_all["f_gra_qc"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Return Advise(GRA)</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_print_qc" name="f_print_qc" value="Y" <?php if($row_ath_all["f_print_qc"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Print GRA</span>
                  </label>
                </div>  
                
                   
              <hr width="100%"> 
                
            <!-- Disposal QC --->
               <p><b>Disposal QC</b></p>
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_disposal_qc" name="main_disposal_qc" value="Y" <?php if($row_ath_all["main_disposal_qc"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposals</span>
                  </label>
                </div>  
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_qc" name="f_dis_approval_qc" value="Y" <?php if($row_ath_all["f_dis_approval_qc"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Reject Part</span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_comp_rej_qc" name="f_comp_rej_qc" value="Y" <?php if($row_ath_all["f_comp_rej_qc"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Reject Component</span>
                  </label>
                </div>   
         
                
                 <hr width="100%"> 
                
            <!-- Disposal Approval Exec --->
               <p><b>Disposal Approval HOD QC</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_ex_qc"  name="f_dis_approval_ex_qc" value="Y" <?php if($row_ath_all["f_dis_approval_ex_qc"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval HOD QC</span>
                  </label>
                </div>  
                   
              <hr width="100%"> 
                
            <!-- Disposal Approval QC --->
               <p><b>Disposal Approval COO</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_h_qc" name="f_dis_approval_h_qc" value="Y" <?php if($row_ath_all["f_dis_approval_h_qc"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval COO</span>
                  </label>
                </div>
                
                
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_hqc_smenu1" name="f_hqc_smenu1" value="Y" <?php if($row_ath_all["f_hqc_smenu1"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_hqc_smenu2" name="f_hqc_smenu2" value="Y" <?php if($row_ath_all["f_hqc_smenu2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Cancellation </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_hqc_smenu3" name="f_hqc_smenu3" value="Y" <?php if($row_ath_all["f_hqc_smenu3"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Document List </span>
                  </label>
                </div>    
                
                
                
                
                
                
                  
                
                <hr width="100%">  
                   
            <!-- Cancellation --->
               <p><b>Cancellation </b></p>
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_canc" name="main_canc" value="Y" <?php if($row_ath_all["main_canc"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Cancellation </span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu1" name="f_canc_smenu1" value="Y" <?php if($row_ath_all["f_canc_smenu1"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu2" name="f_canc_smenu2" value="Y" <?php if($row_ath_all["f_canc_smenu2"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt FOC </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu3" name="f_canc_smenu3" value="Y" <?php if($row_ath_all["f_canc_smenu3"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Return </span>
                  </label>
                </div>    
           
         
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu4" name="f_canc_smenu4" value="Y" <?php if($row_ath_all["f_canc_smenu4"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">GI Consumable </span>
                  </label>
                </div>    
           
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu5" name="f_canc_smenu5" value="Y" <?php if($row_ath_all["f_canc_smenu5"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Transfer Posting </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu6" name="f_canc_smenu6" value="Y" <?php if($row_ath_all["f_canc_smenu6"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Transfer to Subcont </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu7" name="f_canc_smenu7" value="Y" <?php if($row_ath_all["f_canc_smenu7"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Transfer Material </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu8" name="f_canc_smenu8" value="Y" <?php if($row_ath_all["f_canc_smenu8"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Delivery Order </span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu9" name="f_canc_smenu9" value="Y" <?php if($row_ath_all["f_canc_smenu9"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal PPC </span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu10" name="f_canc_smenu10" value="Y" <?php if($row_ath_all["f_canc_smenu10"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Production </span>
                  </label>
                </div>    
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu11" name="f_canc_smenu11" value="Y" <?php if($row_ath_all["f_canc_smenu11"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Goods Return Advise </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu12" name="f_canc_smenu12" value="Y" <?php if($row_ath_all["f_canc_smenu12"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal QC </span>
                  </label>
                </div>   
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu13" name="f_canc_smenu13" value="Y" <?php if($row_ath_all["f_canc_smenu13"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Engineering</span>
                  </label>
                </div> 
              
              
               <hr width="100%">           
               <!-- Report --->
               <p><b>Report </b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_rpt" name="main_rpt" value="Y" <?php if($row_ath_all["main_rpt"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Report </span>
                  </label>
                </div>
                
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu0" name="f_rpt_smenu0" value="Y" <?php if($row_ath_all["f_rpt_smenu0"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Delivery Instruction </span>
                  </label>
                </div>  
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu21" name="f_rpt_smenu21" value="Y" <?php if($row_ath_all["f_rpt_smenu21"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Delivery Instruction PPC </span>
                  </label>
                </div>   
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu18" name="f_rpt_smenu18" value="Y" <?php if($row_ath_all["f_rpt_smenu18"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Delivery Order </span>
                  </label>
                </div> 
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu1" name="f_rpt_smenu1" value="Y" <?php if($row_ath_all["f_rpt_smenu1"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Goods Receipt </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu2" name="f_rpt_smenu2" value="Y" <?php if($row_ath_all["f_rpt_smenu2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt FOC </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu3" name="f_rpt_smenu3" value="Y" <?php if($row_ath_all["f_rpt_smenu3"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Goods Return </span>
                  </label>
                </div>    
           
         
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu4" name="f_rpt_smenu4" value="Y" <?php if($row_ath_all["f_rpt_smenu4"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">GI Consumable </span>
                  </label>
                </div>    
           
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu5" name="f_rpt_smenu5" value="Y" <?php if($row_ath_all["f_rpt_smenu5"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Transfer Posting </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu6" name="f_rpt_smenu6" value="Y" <?php if($row_ath_all["f_rpt_smenu6"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Transfer to Subcont </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu7" name="f_rpt_smenu7" value="Y" <?php if($row_ath_all["f_rpt_smenu7"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Transfer Material </span>
                  </label>
                </div> 
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu17" name="f_rpt_smenu17" value="Y" <?php if($row_ath_all["f_rpt_smenu17"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">PDIO/DI </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu20" name="f_rpt_smenu20" value="Y" <?php if($row_ath_all["f_rpt_smenu20"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">PDIO/DI for FINA</span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu8" name="f_rpt_smenu8" value="Y" <?php if($row_ath_all["f_rpt_smenu8"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Backflush Transit </span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu9" name="f_rpt_smenu9" value="Y" <?php if($row_ath_all["f_rpt_smenu9"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Goods Return Advise </span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu19" name="f_rpt_smenu19" value="Y" <?php if($row_ath_all["f_rpt_smenu19"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Disposal PPC </span>
                  </label>
                </div>    
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu10" name="f_rpt_smenu10" value="Y" <?php if($row_ath_all["f_rpt_smenu10"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Disposal QC </span>
                  </label>
                </div>    
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu11" name="f_rpt_smenu11" value="Y" <?php if($row_ath_all["f_rpt_smenu11"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Backflush </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu12" name="f_rpt_smenu12" value="Y" <?php if($row_ath_all["f_rpt_smenu12"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Pending </span>
                  </label>
                </div>   
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu13" name="f_rpt_smenu13" value="Y" <?php if($row_ath_all["f_rpt_smenu13"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Rework </span>
                  </label>
                </div>   
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu14" name="f_rpt_smenu14" value="Y" <?php if($row_ath_all["f_rpt_smenu14"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Handwork </span>
                  </label>
                </div>   
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu15" name="f_rpt_smenu15" value="Y" <?php if($row_ath_all["f_rpt_smenu15"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Disposal Production</span>
                  </label>
                </div>   
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu16" name="f_rpt_smenu16" value="Y" <?php if($row_ath_all["f_rpt_smenu16"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Planned Order Status </span>
                  </label>
                </div>   
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu22" name="f_rpt_smenu22" value="Y" <?php if($row_ath_all["f_rpt_smenu22"] == 'Y') { ?> checked <?php  } ?>><span class="button-indecator">Disposal Engineering </span>
                  </label>
                </div>  
                
                  
                    <hr width="100%">           
               <!-- FTP --->
               <p><b>FTP Monitoring </b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_ftp" name="main_ftp" value="Y" <?php if($row_ath_all["main_ftp"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">FTP Monitoring </span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu1" name="f_ftp_smenu1" value="Y" <?php if($row_ath_all["f_ftp_smenu1"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Backflush OK</span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu2" name="f_ftp_smenu2" value="Y" <?php if($row_ath_all["f_ftp_smenu2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Backflush NG</span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu3" name="f_ftp_smenu3" value="Y" <?php if($row_ath_all["f_ftp_smenu3"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Backflush Pending</span>
                  </label>
                </div>    
           
         
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu4" name="f_ftp_smenu4" value="Y" <?php if($row_ath_all["f_ftp_smenu4"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Backflush Handwork</span>
                  </label>
                </div>    
           
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu5" name="f_ftp_smenu5" value="Y" <?php if($row_ath_all["f_ftp_smenu5"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Disposal GI</span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu6" name="f_ftp_smenu6" value="Y" <?php if($row_ath_all["f_ftp_smenu6"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu7" name="f_ftp_smenu7" value="Y" <?php if($row_ath_all["f_ftp_smenu7"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Goods Return</span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu8" name="f_ftp_smenu8" value="Y" <?php if($row_ath_all["f_ftp_smenu8"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">GI Consumable</span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu9" name="f_ftp_smenu9" value="Y" <?php if($row_ath_all["f_ftp_smenu9"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Transfer Material</span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu10" name="f_ftp_smenu10" value="Y" <?php if($row_ath_all["f_ftp_smenu10"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Transfer Posting</span>
                  </label>
                </div>    
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu15" name="f_ftp_smenu15" value="Y" <?php if($row_ath_all["f_ftp_smenu15"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Transfer to Subcont</span>
                  </label>
                </div>    
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu11" name="f_ftp_smenu11" value="Y" <?php if($row_ath_all["f_ftp_smenu11"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Disposal</span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu12" name="f_ftp_smenu12" value="Y" <?php if($row_ath_all["f_ftp_smenu12"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Backflush Transit</span>
                  </label>
                </div>   
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu13" name="f_ftp_smenu13" value="Y" <?php if($row_ath_all["f_ftp_smenu13"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Delivery Order</span>
                  </label>
                </div>   
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu14" name="f_ftp_smenu14" value="Y" <?php if($row_ath_all["f_ftp_smenu14"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Disposal QC </span>
                  </label>
                </div> 
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu16" name="f_ftp_smenu16" value="Y" <?php if($row_ath_all["f_ftp_smenu16"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Disposal Engineering </span>
                  </label>
                </div>   

                
                
                 <hr width="100%">           
               <!-- CEO --->
               <p><b><?php echo html_esc($rst_apprv8["apprv_name2"]); ?></b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_coo" name="main_coo" value="Y" <?php if($row_ath_all["main_coo"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator"><?php echo html_esc($rst_apprv8["apprv_name2"]); ?> </span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu1" name="f_coo_smenu1" value="Y" <?php if($row_ath_all["f_coo_smenu1"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Pending Approval</span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu2" name="f_coo_smenu2" value="Y" <?php if($row_ath_all["f_coo_smenu2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Approved</span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu3" name="f_coo_smenu3" value="Y" <?php if($row_ath_all["f_coo_smenu3"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Rejected</span>
                  </label>
                </div>    
           
         
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu4" name="f_coo_smenu4" value="Y" <?php if($row_ath_all["f_coo_smenu4"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Cancellation</span>
                  </label>
                </div>    
           
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu5" name="f_coo_smenu5" value="Y" <?php if($row_ath_all["f_coo_smenu5"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Document List</span>
                  </label>
                </div>  
                
                
                   
             
                   <hr width="100%">           
               <!-- Report --->
                  <p><b>Close PPS </b></p>
                  
                  
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_close_pps" name="f_close_pps" value="Y" <?php if($row_ath_all["f_close_pps"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Closing </span>
                  </label>
                  </div>   
                
                
                
                 <hr width="100%">           
               <!-- PO --->
               <p><b>Purchase Order</b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_po" name="main_po" value="Y" <?php if($row_ath_all["main_po"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Purchase Order </span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_po_smenu1" name="f_po_smenu1" value="Y" <?php if($row_ath_all["f_po_smenu1"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Upload PO</span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_po_smenu2" name="f_po_smenu2" value="Y" <?php if($row_ath_all["f_po_smenu2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">View PO</span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_po_smenu3" name="f_po_smenu3" value="Y" <?php if($row_ath_all["f_po_smenu3"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Maintain PO</span>
                  </label>
                </div> 
                
                
                
                
                
                 <hr width="100%">           
               <!-- MFO --->
               <p><b>Material Forecast Order</b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_mfo" name="main_mfo" value="Y" <?php if($row_ath_all["main_mfo"] == 'Y'){ ?> checked <?php  } ?>><span class="button-indecator">Material Forecast Order </span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_mfo_smenu1" name="f_mfo_smenu1" value="Y" <?php if($row_ath_all["f_mfo_smenu1"] == 'Y') { ?> checked <?php  } ?> ><span class="button-indecator">Upload MFO</span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_mfo_smenu2" name="f_mfo_smenu2" value="Y" <?php if($row_ath_all["f_mfo_smenu2"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">View MFO</span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_mfo_smenu3" name="f_mfo_smenu3" value="Y" <?php if($row_ath_all["f_mfo_smenu3"] == 'Y')  { ?> checked <?php  } ?>><span class="button-indecator">Maintain MFO</span>
                  </label>
                </div> 
                
                
                
                        </div>
                    </div>

                    <div class="form-group col-md-8 align-self-end">
                        <input type="button" id="Reset" onclick="window.location.href='display_user.php';" class="btn btn-warning" value="CANCEL">
                        <input name="submit" type="submit" id="submit" value="UPDATE" class="btn btn-primary" onClick="return EditUsr()">
                        <!--   <button class="btn btn-primary" type="button" onClick=""><i class="fa fa-fw fa-lg fa-check-circle"></i>Subscribe</button>-->
                    </div>

                </form>
                
                </div>
            </div>
            </div>
        </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->

    <!-- Data table plugin-->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">$('#example').DataTable();</script> -->

    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>

    <script>
    function EditUsr(){
    
        var user_fullname = $("#user_fullname").val();
        var company = $("#company").val();
        var dept = $("#dept").val();
        var design = $("#design").val();
        var user_telno1 = $("#user_telno1").val();
        var user_telno2 = $("#user_telno2").val();
        var user_fax = $("#user_fax").val();
        var user_email = $("#user_email").val();
        var level_id = $("#level_id").val();
        var user_fax = $("#user_fax").val();
        var status = $("#status").val();
        
        
        if (confirm('Update user details?')){
        
            if(user_fullname == '' ){
                alert('Name is required.');
                document.getElementById("user_fullname").focus();
                document.getElementById('user_fullname').style.borderColor = "#D41F3A";
                return false;
            }
            else if(company == '' ){
                alert('Company is required.');
                document.getElementById("company").focus();
                document.getElementById('company').style.borderColor = "#D41F3A";
                return false;
            }
            else if(dept == '' ){
                alert('Department is required.');
                document.getElementById("dept").focus();
                document.getElementById('dept').style.borderColor = "#D41F3A";
                return false;
            }
            else if(design == '' ){
                alert('Designation is required.');
                document.getElementById("design").focus();
                document.getElementById('design').style.borderColor = "#D41F3A";
                return false;
            }
            else if(user_telno1 == '' ){
                alert('Telephone No is required.');
                document.getElementById("user_telno1").focus();
                document.getElementById('user_telno1').style.borderColor = "#D41F3A";
                return false;
            }
            else if(user_email == ''){
                alert('Email is required.');
                document.getElementById("user_email").focus();
                document.getElementById('user_email').style.borderColor = "#D41F3A";
                return false;
            }
            else if(level_id == '' ){
                alert('Level is required.');
                document.getElementById("level_id").focus();
                document.getElementById('level_id').style.borderColor = "#D41F3A";
                return false;
            }
            else if(status == '' ){
                alert('Status User is required.');
                document.getElementById("status").focus();
                document.getElementById('status').style.borderColor = "#D41F3A";
                return false;
            }
    
        }
        else
        {
            return false;
        }	
    }
    </script>
 
   </body>
</html>