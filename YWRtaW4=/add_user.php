<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

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

//--------menu function ------------------------------

$query_function = new PreparedSql("SELECT * FROM function_acc_detail WHERE staff_ID = ?", [$res["staff_ID"]]);
$result_function = db_query($dbc, $query_function);   //run the query.
$data_function = mysqli_fetch_array($result_function);   //how many records are there?  

include 'apprv_func_list.php';
//----------------------------------------------------




    $query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
    $result2 = db_query($dbc, $query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	
	
$url = "add_user.php"; 
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
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>
 <!-- <script type="text/javascript">
	
function show1(){ document.getElementById('div1').style.display ='none'; } 
function show2(){ document.getElementById('div1').style.display = 'block'; }

  </script>-->
  <style>
    .box{
        color: #fff;
        padding: 20px;
        display: none;
        margin-top: 20px;
    }
	.black{ background: #000000; }
    .red{ background: #ff0000; }
    .green{ background: #228B22; }
    .blue{ background: #0000ff; }
    label{ margin-right: 15px; }
</style>
 <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> 
    <style type="text/css"> 
        .selectt_f { 
            color: #fff; 
            padding: 30px; 
            display: none; 
            margin-top: 30px; 
            width: 60%; 
            background: #3BA591 
        } 
        .selectt_ff { 
            color: #fff; 
            padding: 30px; 
            display: none; 
            margin-top: 10px; 
            width: 100%; 
            background: #3E7B7B 
        } 
        label { 
            margin-right: 20px; 
        } 
    </style>  
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
          <h1><i class="fa fa-edit"></i> User Maintenance</h1>
          <p>Add User</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">User Maintenance</li>
          <li class="breadcrumb-item"><a href="add_user.php">Add User</a></li>
        </ul>
      </div>  
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="add_user.php">Add User</a></li>
                <li class="nav-item"><a class="nav-link" href="display_user.php">Display User</a></li>
                <li class="nav-item"><a class="nav-link" href="reset_password_user.php">Reset Password</a></li>
                <li class="nav-item"><a class="nav-link" href="crt-vendor_user.php">Assign Vendor</a></li>
                <li class="nav-item"><a class="nav-link" href="display-vendor_user.php">Display Assign Vendor</a></li>
              </ul>
       <?php
	   
	   $message_vendor = ""; 
	   $message_staff = "";
	   $message_name = "";
	   $message_pass = "";
	   $message_comp = "";
	   $message_dept = "";
	   $message_design = "";
	   $message_email = "";
	   $message_level = "";
	   $message_sta = "";
	   $message_telno1 = "";
	   $message_plant = "";
// Set the page title and include the HTML header.
//include ('templates/header.inc');

if (isset($_POST['submit_Y'])) 
{ // handle the form.


// create a function for escaping the data.
function escape_data($data) {
global $dbc;   // need the connection.
if (ini_get('magic_quotes_gpc')) {
    $data = stripslashes($data);
	}
	return mysqli_real_escape_string($data,$dbc);
	}   // end function.
$message = NULL; // create an empty new variable.
   
   $vendor_no = $_POST['vendor_no'];
   $user_id = $_POST['user_id'];
   $upw = $_POST['user_password'];
   $user_fullname = $_POST['user_fullname'];
   $department = $_POST['dept'];
   $designation = $_POST['design'];
   $company = $_POST['company'];
   $user_telno1 = $_POST['user_telno1'];
   $level_id = $_POST['level_id'];
   $status = $_POST['status'];
   $user_email = $_POST['user_email'];
   $plant_code = $_POST['plant_code'];
   //---------------------------
   $ath_mdl = $_POST['colorCheckbox'];

  
// check for a vendor no
if (empty($_POST['vendor_no']))
{ $vendor_no = FALSE;
  $message_vendor = '<span class="badge badge-pill badge-danger">Please enter COMPANY CODE!</span>';
  }


// check for a user id
if (empty($_POST['user_id']))
{
  $user_id = FALSE;
  $message_staff = '<span class="badge badge-pill badge-danger">Please enter USER ID!</span>';
  
  }else{
	  
	  $query_chk_profile = new PreparedSql("SELECT * FROM user_detail WHERE staff_ID = ?", [$_POST["user_id"]]);
	  $result_chk_profile = db_query($dbc, $query_chk_profile);  
	  $rst_chk_profile  = mysqli_fetch_array($result_chk_profile); 
	  
	  
	  if($rst_chk_profile > 0)
	  {
		  
     $user_id = FALSE;
     $message_staff = '<span class="badge badge-pill badge-danger">Sorry. USER ID is already used. </span>';  
		  
	  }
	  
	  
  }
  
 
// check for a password and match against the confirmed password.
if (empty($_POST['user_password']))
{ $upw = FALSE;
  $message_pass = '<span class="badge badge-pill badge-danger">Please enter PASSWORD!</span>';
  }
  else
  { 
  
  if ($_POST['user_password'] == $_POST['user_password2'])
    { 
	$upw = $_POST['user_password'];
	    if (preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $upw)) {
		$message_pass = '<span class="badge badge-pill badge-success">Password is Strong</span>';
        
         } else {
		$message_pass = '<span class="badge badge-pill badge-danger">Your passwords is weak.! Password must be at least 20 characters and must contain at least one lower case letter, one upper case letter and one digit</span>';
         
         }
	//$upw = escape_data($_POST['user_password']); 
	}
	else
    { $upw = FALSE;
      $message_pass = '<span class="badge badge-pill badge-danger">PASSWORD did not match the CONFIRMED PASSWORD!</span>';
     }
  }


// check for a fullname
if (empty($_POST['user_fullname']))
{ $user_fullname = FALSE;
  $message_name = '<span class="badge badge-pill badge-danger">Please enter NAME!</span>';
  }
 

// check for a telephone no 1
if (empty($_POST['user_telno1']))
{ $user_telno1 = FALSE;
  $message_telno1 = '<span class="badge badge-pill badge-danger">Please enter TELEPHONE NO (1)!</span>';
  }

  // check for a EMAIL
  
  $email = $user_email;
  $regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";

if (!preg_match($regexp, $email)) {
    
   $user_email = FALSE; 
   $message_email = '<span class="badge badge-pill badge-danger">Please enter valid E-MAIL address!</span>';
}

// check for a department
if (empty($_POST['dept']) || ($_POST['dept'] == ""))
{ $department= FALSE;
  $message_dept = '<span class="badge badge-pill badge-danger">Please to select DEPARTMENT!</span>';
  }
// check for a designation
if (empty($_POST['design']) || ($_POST['design'] == ""))
{ $designation= FALSE;
  $message_design = '<span class="badge badge-pill badge-danger">Please to select DESIGNATION!</span>';
  }

// check for a company
if (empty($_POST['company']) || ($_POST['company'] == ""))
{ $company= FALSE;
  $message_comp = '<span class="badge badge-pill badge-danger">Please to select COMPANY!</span>';
  }



// check for a LEVEL USER
if (empty($_POST['level_id']) || ($_POST['level_id'] == ""))
{ $level_id = FALSE;
  $message_level = '<span class="badge badge-pill badge-danger">Please to select LEVEL USER!</span>';
  }

// check for a Status
if (empty($_POST['status']) || ($_POST['status'] == ""))
{ $status= FALSE;
  $message_sta = '<span class="badge badge-pill badge-danger">Please to select STATUS USER!</span>';
  }

// check for a Plant Code
if (empty($_POST['plant_code']) || ($_POST['plant_code'] == ""))
{ $plant_code = FALSE;
  $message_plant = '<span class="badge badge-pill badge-danger">Please to select PLANT CODE!</span>';
  }

  $user_telno2 = addslashes($_POST['user_telno2']);
  $user_fax = addslashes($_POST['user_fax']);
 
    
  $_POST['user_password'] = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
 	
  if (!addslashes($_POST['user_password'])) {
    
 		$_POST['user_password'] = addslashes($_POST['user_password']);
 		$user_id = addslashes($_POST['user_id']);
 			}
  
if ($vendor_no && $user_id && $upw && $user_fullname && $department && $designation && $company && $user_telno1 && $user_email && $level_id && $status && $plant_code) //everything ok
{  

   $vendor_no = $_POST['vendor_no'];
   $user_id = $_POST['user_id'];
   $upw = $_POST['user_password'];
   $user_fullname = $_POST['user_fullname'];
   $department = $_POST['dept'];
   $designation = $_POST['design'];
   $company = $_POST['company'];
   $user_telno1 = $_POST['user_telno1'];
   $level_id = $_POST['level_id'];
   $status = $_POST['status'];
   $user_email = $_POST['user_email'];
   $plant_code = $_POST['plant_code'];

//register the user in the db.
$query_db = "INSERT INTO user_detail (vendor_no,staff_ID,username,password,user_fullname,department,designation,company,user_telno1,user_telno2,user_fax,user_email,user_created,date_created,status,level_id,user_update,date_update,last_login,status_failed,date_failed,plant_code) VALUES('".sql_esc($vendor_no)."','".sql_esc($user_id)."','".sql_esc($user_id)."','".sql_esc($_POST['user_password'])."','".sql_esc($user_fullname)."','".sql_esc($department)."','".sql_esc($designation)."','".sql_esc($company)."','".sql_esc($user_telno1)."','".sql_esc($user_telno2)."','".sql_esc($user_fax)."','".sql_esc($user_email)."','".sql_esc($username)."',NOW(),'".sql_esc($status)."','".sql_esc($level_id)."','','','','N','','".sql_esc($plant_code)."')";
$result = mysqli_query($dbc,$query_db);

//login detail
$query_login = "INSERT INTO login_detail (staff_ID,username,password,company,user_email,user_created,date_created,status,level_id,user_update,date_update,last_login,expired_pass_date,status_pass,plant_code) VALUES('".strtoupper($user_id)."','".strtoupper($user_id)."','".sql_esc($_POST['user_password'])."','".sql_esc($company)."','".sql_esc($user_email)."','".sql_esc($username)."',NOW(),'".sql_esc($status)."','".sql_esc($level_id)."','','','','','N','".sql_esc($plant_code)."')";
$result_login = mysqli_query($dbc,$query_login);

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
  
  $pc_rec = addslashes($_POST['f_gra_qc']);
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
  

  
  
  
  
  
  //---------Backflush --------------
  $main_bflush = addslashes($_POST['main_bflush']);
  $f_bf_ok = addslashes($_POST['f_bf_ok']);
  $f_bf_ng = addslashes($_POST['f_bf_ng']);
  $f_bf_pending = addslashes($_POST['f_bf_pending']);
  $f_bf_handwork = addslashes($_POST['f_bf_handwork']);
  $f_print_prd = addslashes($_POST['f_print_prd']);
  
  
  //-------Disposal Prod -------------
  $main_disposal = addslashes($_POST['main_disposal']);
  $f_comp_rej_prd = addslashes($_POST['f_comp_rej_prd']);
  $f_dis_prd = addslashes($_POST['f_dis_prd']);
  
  
  
  //---------Production------------------------------
  $f_bf_pend_conf_prd = addslashes($_POST['f_bf_pend_conf_prd']);
  $f_pend_rwork_conf_prd = addslashes($_POST['f_pend_rwork_conf_prd']);
  $f_pend_hwork_conf_prd = addslashes($_POST['f_pend_hwork_conf_prd']);
  
  $f_dis_list_prd = addslashes($_POST['f_dis_list_prd']);
  $f_dis_approval_prd = addslashes($_POST['f_dis_approval_prd']);
  $f_dis_approval_prd2 = addslashes($_POST['f_dis_approval_prd2']);
  $f_dis_approval_prd3 = addslashes($_POST['f_dis_approval_prd3']);
  $f_dis_approval_prd4 = addslashes($_POST['f_dis_approval_prd4']);
 



//---------Return  Advise----------------------------
  $main_gra = addslashes($_POST['main_gra']);
  $f_gra_qc = addslashes($_POST['f_gra_qc']);
  $f_print_qc = addslashes($_POST['f_print_qc']);
  
  //--------disposal production 2 -------------------
  
  $main_disposal_prd2 = addslashes($_POST['main_disposal_prd2']);
  $f_dis_rej_prd2 = addslashes($_POST['f_dis_rej_prd2']);
  $f_comp_rej_prd2 = addslashes($_POST['f_comp_rej_prd2']);
 
 
 //----disposal QC -----------------------------------
 
 
   $main_disposal_qc = addslashes($_POST['main_disposal_qc']);
   $f_comp_rej_qc = addslashes($_POST['f_comp_rej_qc']);
   $f_dis_approval_qc = addslashes($_POST['f_dis_approval_qc']);
 
 
 
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
  $f_rpt_smenu23 = addslashes($_POST['f_rpt_smenu23']); 

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
 
 //------------CEO-----------------
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

 //function_ath_detail [others roles]
$query_at_men = "INSERT INTO function_ath_detail(id_ath,username,staff_ID,ath_mdl,ath_status,date_create,user_create,date_update,user_update,plant_code) VALUES('','".strtoupper($user_id)."','".strtoupper($user_id)."','".sql_esc($level_id)."','Y',NOW(),'".sql_esc($username)."','','','".sql_esc($plant_code)."')";
$result_at_men = mysqli_query($dbc,$query_at_men);


 
 if(!empty($_POST['prd_cat'])){
	
	
  $f_stamp_prd = addslashes($_POST['f_stamp_prd']);
  $f_assy_prd = addslashes($_POST['f_assy_prd']);
	
}

if(!empty($_POST['prd_plan'])){
	
	
  $f_ftp_plan_prd = addslashes($_POST['f_ftp_plan_prd']);
  $f_upl_plan_prd = addslashes($_POST['f_upl_plan_prd']);
  $f_view_plan_prd = addslashes($_POST['f_view_plan_prd']);
  $f_close_plan_prd = addslashes($_POST['f_close_plan_prd']);
	
	
}



if(!empty($_POST['f_dis_approval_h_qc']))
{
  $f_hqc_smenu1 = addslashes($_POST['f_hqc_smenu1']);
  $f_hqc_smenu2 = addslashes($_POST['f_hqc_smenu2']);
  $f_hqc_smenu3 = addslashes($_POST['f_hqc_smenu3']);


 }  // end if approval HQC






if(!empty($_POST['main_di'])){


  $ff_dlv_di = addslashes($_POST['f_dlv_di']);
  $f_dlv_di2 = addslashes($_POST['f_dlv_di2']);
  $f_dlv_di3 = addslashes($_POST['f_dlv_di3']);
  $f_dlv_di4 = addslashes($_POST['f_dlv_di4']);
  $f_dlv_di5 = addslashes($_POST['f_dlv_di5']);
  $f_dlv_di6 = addslashes($_POST['f_dlv_di6']);
  $f_dlv_di7 = addslashes($_POST['f_dlv_di7']);
  
} // end delivery instruct


if(!empty($_POST['prd_plan']))
{
  $f_ftp_plan_prd = addslashes($_POST['f_ftp_plan_prd']);
  $f_view_plan_prd = addslashes($_POST['f_view_plan_prd']);
  $f_close_plan_prd = addslashes($_POST['f_close_plan_prd']);


 }  // end if planning
 
 
   //---------Backflush -----------------------
   if(!empty($_POST['main_bflush'])) 
 {
  
  $main_bflush = addslashes($_POST['main_bflush']);
  $f_bf_ok = addslashes($_POST['f_bf_ok']);
  $f_bf_ng = addslashes($_POST['f_bf_ng']);
  $f_bf_pending = addslashes($_POST['f_bf_pending']);
  $f_bf_handwork = addslashes($_POST['f_bf_handwork']);
  $f_print_prd = addslashes($_POST['f_print_prd']);
  
  
  
 }  // end if backflush 
 
 
  //---------disposal production  -----------------------
 
   if(!empty($_POST['main_disposal'])) 
 {
 
  $main_disposal = addslashes($_POST['main_disposal']);
  $f_comp_rej_prd = addslashes($_POST['f_comp_rej_prd']);
  $f_dis_prd = addslashes($_POST['f_dis_prd']);
 
 
 
  }  // end if disposal production 
  
  
   //----disposal production 2 -----------------------------------
 
   if(!empty($_POST['main_disposal_prd2'])) 
 {
 
  $main_disposal_prd2 = addslashes($_POST['main_disposal_prd2']);
  $f_dis_rej_prd2 = addslashes($_POST['f_dis_rej_prd2']);
  $f_comp_rej_prd2 = addslashes($_POST['f_comp_rej_prd2']);
 
 
  }  // end if disposal QC
  
  
   //----disposal QC -----------------------------------
 
   if(!empty($_POST['main_disposal_qc'])) 
 {
 
  $main_disposal_qc = addslashes($_POST['main_disposal_qc']);
  $f_comp_rej_qc = addslashes($_POST['f_comp_rej_qc']);
  $f_dis_approval_qc = addslashes($_POST['f_dis_approval_qc']);
 
 
 
  }  // end if disposal QC
  
  
 if(!empty($_POST['pc_rec'])){
  
  $f_gr_rec0 = addslashes($_POST['f_gr_rec0']);
  $f_gr_rec = addslashes($_POST['f_gr_rec']);
  $f_gr_rec2 = addslashes($_POST['f_gr_rec2']);
  $f_grfoc_rec = addslashes($_POST['f_grfoc_rec']);
  $f_print_rec = addslashes($_POST['f_print_rec']);
  $f_printfoc_rec = addslashes($_POST['f_printfoc_rec']);
  
	 
	 
 }   // end if receiving
 
 if(!empty($_POST['main_dlv'])) 
 {
	 
  $f_dlv_do = addslashes($_POST['f_dlv_do']);
  $f_dlv_do2 = addslashes($_POST['f_dlv_do2']);
  $f_dlv_do3 = addslashes($_POST['f_dlv_do3']);
  $f_dlv_do4 = addslashes($_POST['f_dlv_do4']);
  $f_dlv_do5 = addslashes($_POST['f_dlv_do5']);
  $f_dlv_do6 = addslashes($_POST['f_dlv_do6']);
  $f_dlv_do7 = addslashes($_POST['f_dlv_do7']);
  $f_dlv_do8 = addslashes($_POST['f_dlv_do8']);
  $f_dlv_do9 = addslashes($_POST['f_dlv_do9']);

	 
 } // end if delivery
 
 
  if(!empty($_POST['main_transit'])) 
 {
	 
  $f_bf_tran_dlv = addslashes($_POST['f_bf_tran_dlv']);
  $f_bf_tran_dlv2 = addslashes($_POST['f_bf_tran_dlv2']);
 
  
 }// end if  transit
 
 
  if(!empty($_POST['main_rpt'])) 
 {
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
  $f_rpt_smenu23 = addslashes($_POST['f_rpt_smenu23']); 
	 
 }// end if report
 
 
 
  if(!empty($_POST['main_ftp'])) 
 {
	 
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
  
 }// end if  FTP Monitor
  

  if(!empty($_POST['main_coo'])) 
 {
	 
  $f_coo_smenu1 = addslashes($_POST['f_coo_smenu1']);
  $f_coo_smenu2 = addslashes($_POST['f_coo_smenu2']);
  $f_coo_smenu3 = addslashes($_POST['f_coo_smenu3']);
  $f_coo_smenu4 = addslashes($_POST['f_coo_smenu4']);
  $f_coo_smenu5 = addslashes($_POST['f_coo_smenu5']);

 }
 
  if(!empty($_POST['main_po'])) 
 {
	 
  $f_po_smenu1 = addslashes($_POST['f_po_smenu1']);
  $f_po_smenu2 = addslashes($_POST['f_po_smenu2']);
  $f_po_smenu3 = addslashes($_POST['f_po_smenu3']);
 }
 
  if(!empty($_POST['main_mfo'])) 
 {
	 
  $f_mfo_smenu1 = addslashes($_POST['f_mfo_smenu1']);
  $f_mfo_smenu2 = addslashes($_POST['f_mfo_smenu2']);
  $f_mfo_smenu3 = addslashes($_POST['f_mfo_smenu3']);
 }


  $f_close_pps = addslashes($_POST['f_close_pps']); 
 

 


//function_acc_detail [submenu]
$query_roles = "INSERT INTO function_acc_detail (staff_ID,user_fullname,plant_code,main_dash,main_dash2,main_dash3,main_dash4,main_dash5,prd_cat,f_stamp_prd,f_assy_prd,prd_plan,f_ftp_plan_prd,f_upl_plan_prd,f_view_plan_prd,f_close_plan_prd,main_di,f_dlv_di,f_dlv_di2,f_dlv_di3,f_dlv_di4,f_dlv_di5,f_dlv_di6,f_dlv_di7,pc_rec,f_gr_rec0,f_gr_rec,f_gr_rec2,f_grfoc_rec,f_print_rec,f_printfoc_rec,f_gturn_rec,f_gi_rec,f_tp_progress,main_subcont,f_subcont,f_subcont2,f_trans_rec,main_dlv,f_dlv_do,f_dlv_do2,f_dlv_do3,f_dlv_do4,f_dlv_do5,f_dlv_do6,f_dlv_do7,f_dlv_do8,f_dlv_do9,f_dis_rec,f_dis_approval_rec,main_transit,f_bf_tran_dlv,f_bf_tran_dlv2,main_bflush,f_bf_ok,f_bf_ng,f_bf_pending,f_bf_handwork,f_bf_pend_conf_prd,f_pend_rwork_conf_prd,f_pend_hwork_conf_prd,main_disposal,f_comp_rej_prd,main_disposal_prd2,f_dis_rej_prd2,f_comp_rej_prd2,main_disposal_qc,f_comp_rej_qc,f_dis_prd,f_dis_list_prd,f_dis_approval_prd,f_dis_approval_prd2,f_dis_approval_prd3,f_dis_approval_prd4,f_print_prd,main_gra,f_gra_qc,f_print_qc,f_dis_approval_qc,f_dis_approval_ex_qc,f_dis_approval_h_qc,f_hqc_smenu1,f_hqc_smenu2,f_hqc_smenu3,main_canc,f_canc_smenu1,f_canc_smenu2,f_canc_smenu3,f_canc_smenu4,f_canc_smenu5,f_canc_smenu6,f_canc_smenu7,f_canc_smenu8,f_canc_smenu9,f_canc_smenu10,f_canc_smenu11,f_canc_smenu12,f_canc_smenu13,main_rpt, f_rpt_smenu0,f_rpt_smenu1,f_rpt_smenu2,f_rpt_smenu3,f_rpt_smenu4,f_rpt_smenu5,f_rpt_smenu6,f_rpt_smenu7,f_rpt_smenu8,f_rpt_smenu9,f_rpt_smenu10,f_rpt_smenu11,f_rpt_smenu12,f_rpt_smenu13,f_rpt_smenu14,f_rpt_smenu15,f_rpt_smenu16,f_rpt_smenu17,f_rpt_smenu18,f_rpt_smenu19,f_rpt_smenu20,f_rpt_smenu21,f_rpt_smenu22,f_rpt_smenu23,main_ftp,f_ftp_smenu1,f_ftp_smenu2,f_ftp_smenu3,f_ftp_smenu4,f_ftp_smenu5,f_ftp_smenu6,f_ftp_smenu7,f_ftp_smenu8,f_ftp_smenu9,f_ftp_smenu10,f_ftp_smenu11,f_ftp_smenu12,f_ftp_smenu13,f_ftp_smenu14,f_ftp_smenu15,f_ftp_smenu16,main_coo,f_coo_smenu1,f_coo_smenu2,f_coo_smenu3,f_coo_smenu4,f_coo_smenu5,f_close_pps,main_po,f_po_smenu1,f_po_smenu2,f_po_smenu3,main_mfo,f_mfo_smenu1,f_mfo_smenu2,f_mfo_smenu3,user_create,date_create,user_update,date_update,status_acc) VALUES ('".strtoupper($user_id)."','".strtoupper($user_fullname)."','".sql_esc($vendor_no)."','".sql_esc($main_dash)."','".sql_esc($main_dash2)."','".sql_esc($main_dash3)."','".sql_esc($main_dash4)."','".sql_esc($main_dash5)."','".sql_esc($prd_cat)."','".sql_esc($f_stamp_prd)."','".sql_esc($f_assy_prd)."','".sql_esc($prd_plan)."','".sql_esc($f_ftp_plan_prd)."','".sql_esc($f_upl_plan_prd)."','".sql_esc($f_view_plan_prd)."','".sql_esc($f_close_plan_prd)."','".sql_esc($main_di)."','".sql_esc($f_dlv_di)."','".sql_esc($f_dlv_di2)."','".sql_esc($f_dlv_di3)."','".sql_esc($f_dlv_di4)."','".sql_esc($f_dlv_di5)."','".sql_esc($f_dlv_di6)."','".sql_esc($f_dlv_di7)."','".sql_esc($f_dlv_do8)."','".sql_esc($f_dlv_do9)."','".sql_esc($pc_rec)."','".sql_esc($f_gr_rec0)."','".sql_esc($f_gr_rec)."','".sql_esc($f_gr_rec2)."','".sql_esc($f_grfoc_rec)."','".sql_esc($f_print_rec)."','".sql_esc($f_printfoc_rec)."','".sql_esc($f_gturn_rec)."','".sql_esc($f_gi_rec)."','".sql_esc($f_tp_progress)."','".sql_esc($main_subcont)."','".sql_esc($f_subcont)."','".sql_esc($f_subcont2)."','".sql_esc($f_trans_rec)."','".sql_esc($main_dlv)."','".sql_esc($f_dlv_do)."','".sql_esc($f_dlv_do2)."','".sql_esc($f_dlv_do3)."','".sql_esc($f_dlv_do4)."','".sql_esc($f_dlv_do5)."','".sql_esc($f_dlv_do6)."','".sql_esc($f_dlv_do7)."','".sql_esc($f_dis_rec)."','".sql_esc($f_dis_approval_rec)."','".sql_esc($main_transit)."','".sql_esc($f_bf_tran_dlv)."','".sql_esc($f_bf_tran_dlv2)."','".sql_esc($main_bflush)."','".sql_esc($f_bf_ok)."','".sql_esc($f_bf_ng)."','".sql_esc($f_bf_pending)."','".sql_esc($f_bf_handwork)."','".sql_esc($f_bf_pend_conf_prd)."','".sql_esc($f_pend_rwork_conf_prd)."','".sql_esc($f_pend_hwork_conf_prd)."','".sql_esc($main_disposal)."','".sql_esc($f_comp_rej_prd)."','".sql_esc($main_disposal_prd2)."','".sql_esc($f_dis_rej_prd2)."','".sql_esc($f_comp_rej_prd2)."','".sql_esc($main_disposal_qc)."','".sql_esc($f_comp_rej_qc)."','".sql_esc($f_dis_prd)."','".sql_esc($f_dis_list_prd)."','".sql_esc($f_dis_approval_prd)."','".sql_esc($f_dis_approval_prd2)."','".sql_esc($f_dis_approval_prd3)."','".sql_esc($f_dis_approval_prd4)."','".sql_esc($f_print_prd)."','".sql_esc($main_gra)."','".sql_esc($f_gra_qc)."','".sql_esc($f_print_qc)."','".sql_esc($f_dis_approval_qc)."','".sql_esc($f_dis_approval_ex_qc)."','".sql_esc($f_dis_approval_h_qc)."','".sql_esc($f_hqc_smenu1)."','".sql_esc($f_hqc_smenu2)."','".sql_esc($f_hqc_smenu3)."','".sql_esc($main_canc)."','".sql_esc($f_canc_smenu1)."','".sql_esc($f_canc_smenu2)."','".sql_esc($f_canc_smenu3)."','".sql_esc($f_canc_smenu4)."','".sql_esc($f_canc_smenu5)."','".sql_esc($f_canc_smenu6)."','".sql_esc($f_canc_smenu7)."','".sql_esc($f_canc_smenu8)."','".sql_esc($f_canc_smenu9)."','".sql_esc($f_canc_smenu10)."','".sql_esc($f_canc_smenu11)."','".sql_esc($f_canc_smenu12)."','".sql_esc($f_canc_smenu13)."','".sql_esc($main_rpt)."','".sql_esc($f_rpt_smenu0)."','".sql_esc($f_rpt_smenu1)."','".sql_esc($f_rpt_smenu2)."','".sql_esc($f_rpt_smenu3)."','".sql_esc($f_rpt_smenu4)."','".sql_esc($f_rpt_smenu5)."','".sql_esc($f_rpt_smenu6)."','".sql_esc($f_rpt_smenu7)."','".sql_esc($f_rpt_smenu8)."','".sql_esc($f_rpt_smenu9)."','".sql_esc($f_rpt_smenu10)."','".sql_esc($f_rpt_smenu11)."','".sql_esc($f_rpt_smenu12)."','".sql_esc($f_rpt_smenu13)."','".sql_esc($f_rpt_smenu14)."','".sql_esc($f_rpt_smenu15)."','".sql_esc($f_rpt_smenu16)."','".sql_esc($f_rpt_smenu17)."','".sql_esc($f_rpt_smenu18)."','".sql_esc($f_rpt_smenu19)."','".sql_esc($f_rpt_smenu20)."','".sql_esc($f_rpt_smenu21)."','".sql_esc($f_rpt_smenu22)."','".sql_esc($f_rpt_smenu23)."','".sql_esc($main_ftp)."','".sql_esc($f_ftp_smenu1)."','".sql_esc($f_ftp_smenu2)."','".sql_esc($f_ftp_smenu3)."','".sql_esc($f_ftp_smenu4)."','".sql_esc($f_ftp_smenu5)."','".sql_esc($f_ftp_smenu6)."','".sql_esc($f_ftp_smenu7)."','".sql_esc($f_ftp_smenu8)."','".sql_esc($f_ftp_smenu9)."','".sql_esc($f_ftp_smenu10)."','".sql_esc($f_ftp_smenu11)."','".sql_esc($f_ftp_smenu12)."','".sql_esc($f_ftp_smenu13)."','".sql_esc($f_ftp_smenu14)."','".sql_esc($f_ftp_smenu15)."','".sql_esc($f_ftp_smenu16)."','".sql_esc($main_coo)."','".sql_esc($f_coo_smenu1)."','".sql_esc($f_coo_smenu2)."','".sql_esc($f_coo_smenu3)."','".sql_esc($f_coo_smenu4)."','".sql_esc($f_coo_smenu5)."','".sql_esc($f_close_pps)."','".sql_esc($main_po)."','".sql_esc($f_po_smenu1)."','".sql_esc($f_po_smenu2)."','".sql_esc($f_po_smenu3)."','".sql_esc($main_mfo)."','".sql_esc($f_mfo_smenu1)."','".sql_esc($f_mfo_smenu2)."','".sql_esc($f_mfo_smenu3)."','".sql_esc($username)."',NOW(),'','','Y')";
$result_roles = mysqli_query($dbc,$query_roles);



 }//end if

             if($result && $result_login && $result_roles)
             {
				echo "<script>";
				echo "alert('Congratulations! User successfully created');";
				echo "window.location='display_user.php'";
				echo "</script>";
			    exit(); //quit the script
             }
             else 
			 {
	
			 
               $message = '<p><strong>Error!</strong> Cannot create User. </p>';
               mysqli_close($dbc); //close db
             }  
//}
//print the message if there is one.
	  
	  
if (isset($message))
{ 
?>
              <div class="alert alert-dismissible alert-danger">
                <button class="close" type="button" data-dismiss="alert">×</button><?php echo $message; ?>.
              </div>

<?php

}
}
?>

      
      
      
      
        <div class="row">
        <div class="col-md-12">
         <div class="tile">
            <h3 class="tile-title">Add Account</h3>
            <div class="tile-body">
              <form name="form1" method="post" action="" class="form-horizontal">
               <div class="form-group row">
                  <label class="control-label col-md-3">Company Name : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
   <?php		
 	echo '<select name="company" class="form-control">
  <option value=""> --Select-- </option>';
  
  //Retrieve and display the available types
  $query3 = 'SELECT * from company';
  $result3 = mysqli_query($dbc,$query3);
  
    
     while($row3 =mysqli_fetch_array($result3)) {
	
	 if($_POST['submit_Y'] == true){ ?>
               <!--RETAIN VALUE-->
               <option value="<?php echo html_esc($row3["comp_code"]); ?>" <?php if($row3["comp_code"]==$_POST["company"]) echo "selected"; ?>> <?php echo html_esc($row3["comp_name"]); ?></option>
               <?php }else{ ?>
               <option value="<?php echo html_esc($row3["comp_code"]); ?>" > <?php echo stripslashes($row3["comp_name"]); ?></option>
               <?php } ?>
               <?php
							}
	 
	  	//complete the form
	
	echo '</select>';

	?>
       <div class="form-control-feedback" ><?php echo $message_comp; ?></div>       
                </div>
              </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Company Code :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
			<?php		
            echo ' <select name="vendor_no" class="form-control" onChange="getPlant(this.value)">
            <option value=""> --Select-- </option>';
          
          //Retrieve and display the available types
          $query27 = 'SELECT * FROM plant_detail WHERE status_plant = "Y" GROUP BY comp_code';
          $result27 = mysqli_query($dbc,$query27);
          
              while($row27 = mysqli_fetch_array($result27)) {
        
                if($_POST['submit_Y'] == true){ ?>
                       <!--RETAIN VALUE-->
                       <option value="<?php echo html_esc($row27["comp_code"]); ?>" <?php if($row27["comp_code"]==$_POST["vendor_no"]) echo "selected"; ?>> <?php echo html_esc($row27["comp_code"]); ?></option>
                       <?php }else{ ?>
                       <option value="<?php echo html_esc($row27["comp_code"]); ?>" > <?php echo stripslashes($row27["comp_code"]); ?></option>
                       <?php } ?>
                       <?php
                                    }
                            
            //complete the form
            
            echo '</select>';
        
            ?>             
                    <!--<input name="vendor_no" type="text" id="vendor_no" size="20" maxlength="8" value="<?php if(isset($_POST['vendor_no'])) echo $_POST['vendor_no']; ?>" class="form-control" placeholder="Enter Vendor ID"/> -->
                    <div class="form-control-feedback" ><?php echo $message_vendor; ?></div>
                    </div>
                   
                </div>
                
                 <div class="form-group row">
                  <label class="control-label col-md-3">Plant Code : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                   <div id="plantdiv"> 
               <select name="plant_code" id="plant_code" class="form-control" >
                <option value="NULL" placeholder="Select Plant Code"> -- Select --</option>
                </select>  <div class="form-control-feedback" ><?php echo $message_plant; ?></div></div>
               
                    </div>
                </div>
           
                 <div class="form-group row">
                  <label class="control-label col-md-3">Staff ID : <font color="#FF0000"><b> *</b></font></label>
                   <div class="col-md-8">
                  <input name="user_id" type="text" class="form-control" id="user_id" size="20" maxlength="20" value="<?php if(isset($_POST['user_id'])) echo $_POST['user_id']; ?>"  placeholder="Enter Staff ID" />
                   <div class="form-control-feedback" ><?php echo $message_staff; ?></div>
                    </div>
                </div>
                 <div class="form-group row">
                  <label class="control-label col-md-3">Password : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                   <input name="user_password" type="password" class="form-control" id="user_password" size="20" maxlength="20" value="<?php if(isset($_POST['user_password'])) echo $_POST['user_password']; ?>" placeholder="Enter Password"/>
                    <div class="form-control-feedback" ><?php echo $message_pass; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Confirmed Password :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                    <input name="user_password2" type="password" class="form-control" placeholder="Enter Confirmed Password"  id="user_password2" size="20" maxlength="20" value="<?php if(isset($_POST['user_password2'])) echo $_POST['user_password2']; ?>" />
                     <div class="form-control-feedback" ><?php echo $message_pass; ?></div>
                </div>
              </div>
               <div class="form-group row">
                  <label class="control-label col-md-3">Name : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                 <input name="user_fullname" type="text"  class="form-control" id="user_fullname" size="60" maxlength="100" value="<?php if(isset($_POST['user_fullname'])) echo $_POST['user_fullname']; ?>" placeholder="Enter Name" />
                  <div class="form-control-feedback" ><?php echo $message_name; ?></div>
                </div>
              </div>
             
              
              
              <div class="form-group row">
                  <label class="control-label col-md-3">Department : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
    <?php		
 	echo ' <select name="dept" class="form-control">
    <option value=""> --Select-- </option>';
  
  //Retrieve and display the available types
  $query2 = 'SELECT * FROM department';
  $result2 = db_query($dbc, $query2);
  
      while($row2 = mysqli_fetch_array($result2)) {

        if($_POST['submit_Y'] == true){ ?>
               <!--RETAIN VALUE-->
               <option value="<?php echo html_esc($row2["id_dept"]); ?>" <?php if($row2["id_dept"]==$_POST["dept"]) echo "selected"; ?>> <?php echo html_esc($row2["dept_name"]); ?></option>
               <?php }else{ ?>
               <option value="<?php echo html_esc($row2["id_dept"]); ?>" > <?php echo stripslashes($row2["dept_name"]); ?></option>
               <?php } ?>
               <?php
							}
					
	//complete the form
	
	echo '</select>';

	?>  <div class="form-control-feedback" ><?php echo $message_dept; ?></div>
                </div>
              </div>
              
                <div class="form-group row">
                  <label class="control-label col-md-3">Designation : <font color="#FF0000"><b> *</b></font></label>
            <div class="col-md-8">
     <?php		
 	echo '<select name="design" class="form-control">
  <option value=""> --Select-- </option>';
  
  //Retrieve and display the available types
  $query2b = 'SELECT * FROM designation';
  $result2b = mysqli_query($dbc,$query2b);
  
    while($row2b = mysqli_fetch_array($result2b)) {

      if($_POST['submit_Y'] == true){ ?>
               <!--RETAIN VALUE-->
               <option value="<?php echo html_esc($row2b["id_design"])?>" <?php if($row2b["id_design"]==$_POST["design"]) echo "selected"; ?>> <?php echo html_esc($row2b["design"])?></option>
               <?php }else{ ?>
               <option value="<?php echo html_esc($row2b["id_design"])?>" > <?php echo strtoupper($row2b["design"])?></option>
               <?php } ?>
               <?php
							}
				
	echo '</select>';


	?>  <div class="form-control-feedback" ><?php echo $message_design; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Telephone No. 1 : <font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                  <input name="user_telno1" type="tel" id="user_telno1" class="form-control"  value="<?php if(isset($_POST['user_telno1'])) echo $_POST['user_telno1']; ?>"  placeholder="Enter Telephone No. 1"/>
                  
                    <div class="form-control-feedback" ><?php echo $message_telno1; ?></div>
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Telephone No. 2 : </label>
                    <div class="col-md-8">
                    <input name="user_telno2" type="tel" class="form-control" id="user_telno2" size="20" maxlength="20" value="<?php if(isset($_POST['user_telno2'])) echo $_POST['user_telno2']; ?>"  placeholder="Enter Telephone No. 2" />
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">Fax No : </label>
                    <div class="col-md-8">
                  <input name="user_fax" type="tel" class="form-control" id="user_fax" size="20" maxlength="20" value="<?php if(isset($_POST['user_fax'])) echo $_POST['user_fax']; ?>"  placeholder="Enter Fax No "/>
                  
                </div>
              </div>
              <div class="form-group row">
                  <label class="control-label col-md-3">E-mail :<font color="#FF0000"><b> *</b></font></label>
                    <div class="col-md-8">
                     <input name="user_email" type="text" class="form-control" id="user_email" size="60" maxlength="200" value="<?php if(isset($_POST['user_email'])) echo $_POST['user_email']; ?>" placeholder="Enter E-mail " />
                    <div class="form-control-feedback" ><?php echo $message_email; ?></div>
                </div>
              </div>
               <div class="form-group row">
                  <label class="control-label col-md-3">Level : <font color="#FF0000"><b> *</b></font></label>
            <div class="col-md-8">
   <?php		
 	echo ' <select name="level_id" class="form-control">
  <option value=""> --Select-- </option>';
  
  //Retrieve and display the available types
  $query4 = 'SELECT * FROM level_detail where status_level = "Y"';
  $result4 = mysqli_query($dbc,$query4);
  
   
     while($row4 = mysqli_fetch_array($result4)) {
	 
	  if($_POST['submit_Y'] == true){ ?>
               <!--RETAIN VALUE-->
               <option value="<?php echo html_esc($row4["id_level"]); ?>" <?php if($row4["id_level"]==$_POST["level_id"]) echo "selected"; ?>> <?php echo html_esc($row4["desc_level"]); ?></option>
               <?php }else{ ?>
               <option value="<?php echo html_esc($row4["id_level"]); ?>" > <?php echo stripslashes($row4["desc_level"]); ?></option>
               <?php } ?>
               <?php
							}
	 
	//complete the form
	
	echo '</select>';

	?>  <div class="form-control-feedback" ><?php echo $message_level; ?></div>
                </div>
              </div>
              
               <div class="form-group row">
                  <label class="control-label col-md-3">Status : <font color="#FF0000"><b> *</b></font></label>
            <div class="col-md-8">
            <select name="status" id="status" class="form-control">
                   <?php if($_POST['submit_Y'] == true)
						{ ?>
               <option value="AC" <?php if($_POST["status"] == 'AC') { ?> selected="selected"<?php } ?>>ACTIVE</option>
               <option value="NA" <?php if($_POST["status"] == 'NA') { ?> selected="selected"<?php } ?>>NON-ACTIVE</option>
               <?php 
						}
						else
						{ ?>
               <option value="AC">ACTIVE</option>
               <option value="NA">NON-ACTIVE</option>
               <?php } ?>
                 </select>
                   <div class="form-control-feedback" ><?php echo $message_sta; ?></div>
                </div>
              </div>
              <div class="form-group row">
              <label class="control-label col-md-3">Others Role/Menu : <font color="#FF0000"><b> *</b></font></label>
               <div class="col-md-8">
               
               <!--- dashboard ---->
               
               <p><b>Dashboard</b></p>
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash" name="main_dash" value="Y" <?php if(isset($_POST['main_dash'])) { ?> checked <?php  } ?> ><span class="button-indecator">Dashboard 1</span>
                  </label>
                </div>  
            
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash2" name="main_dash2" value="Y" <?php if(isset($_POST['main_dash2'])) { ?> checked <?php  } ?>><span class="button-indecator">Dashboard 2</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash3"  name="main_dash3" value="Y" <?php if(isset($_POST['main_dash3'])) { ?> checked <?php  } ?>><span class="button-indecator">Dashboard 3</span>
                  </label>
                </div> 
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash4" name="main_dash4" value="Y" <?php if(isset($_POST['main_dash4'])) { ?> checked <?php  } ?>><span class="button-indecator">Dashboard 4</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_dash5"  name="main_dash5" value="Y" <?php if(isset($_POST['main_dash5'])) { ?> checked <?php  } ?>><span class="button-indecator">Dashboard 5</span>
                  </label>
                </div>  
                
                <hr width="100%">  
               
               
              <!-- Category ---> 
              <p><b>Category Production</b></p>
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="prd_cat" name="prd_cat" value="Y" <?php if(isset($_POST['prd_cat'])) { ?> checked <?php  } ?> ><span class="button-indecator">Category Production</span>
                  </label>
                </div>  
            
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_stamp_prd" name="f_stamp_prd" value="Y" <?php if(isset($_POST['f_stamp_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">Stamping</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_assy_prd"  name="f_assy_prd" value="Y" <?php if(isset($_POST['f_assy_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">Assembly</span>
                  </label>
                </div>  
                
                <hr width="100%">  
              <!---  PLanning Menu ------>
               <p><b>Planning</b></p>
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="prd_plan" name="prd_plan" value="Y" <?php if(isset($_POST['prd_plan'])) { ?> checked <?php  } ?>><span class="button-indecator">Planning</span>
                  </label>
                </div>  
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_plan_prd" name="f_ftp_plan_prd" value="Y" <?php if(isset($_POST['f_ftp_plan_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">Create Planned Order</span>
                  </label>
                </div> 
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_upl_plan_prd" name="f_upl_plan_prd" value="Y" <?php if(isset($_POST['f_upl_plan_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">Upload PPS</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_view_plan_prd"  name="f_view_plan_prd" value="Y" <?php if(isset($_POST['f_view_plan_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">PPS Listings</span>
                  </label>
                </div>  
              
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_close_plan_prd" name="f_close_plan_prd" value="Y" <?php if(isset($_POST['f_close_plan_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">Close Planned Order</span>
                  </label>
                </div>  
              
                <hr width="100%">  
                
                <!-- Delivery Instruction --->
              
               <p><b>Delivery Instruction</b></p>
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_di" name="main_di" value="Y" <?php if(isset($_POST['main_di'])) { ?> checked <?php  } ?> ><span class="button-indecator">Delivery Instruction</span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di" name="f_dlv_di" value="Y" <?php if(isset($_POST['f_dlv_di'])) { ?> checked <?php  } ?>><span class="button-indecator">Upload DI/Kanban</span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di2" name="f_dlv_di2" value="Y" <?php if(isset($_POST['f_dlv_di2'])) { ?> checked <?php  } ?>><span class="button-indecator">Inbox</span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di3" name="f_dlv_di3" value="Y" <?php if(isset($_POST['f_dlv_di3'])) { ?> checked <?php  } ?>><span class="button-indecator">Print DO &amp;Tag</span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di6" name="f_dlv_di6" value="Y" <?php if(isset($_POST['f_dlv_di6'])) { ?> checked <?php  } ?>><span class="button-indecator">Print DO &amp;Tag PPC</span>
                  </label>
                </div>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di5" name="f_dlv_di5" value="Y" <?php if(isset($_POST['f_dlv_di5'])) { ?> checked <?php  } ?>><span class="button-indecator">Maintain DO</span>
                  </label>
                </div>
              
              <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_di4" name="f_dlv_di4" value="Y" <?php if(isset($_POST['f_dlv_di4'])) { ?> checked <?php  } ?>><span class="button-indecator">Maintain DI</span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dlv_di7" name="f_dlv_di7" value="Y" <?php if(isset($_POST['f_dlv_di7'])) { ?> checked <?php  } ?>><span class="button-indecator">PO vs GR (Quantity) </span>
                  </label>
                 </div>   
                
                
                <hr width="100%">  
            
                
                 <!-- Receiving  --->
               <p><b>Receiving</b></p>
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="pc_rec" name="pc_rec" value="Y" <?php if(isset($_POST['pc_rec'])) { ?> checked <?php  } ?> ><span class="button-indecator">Receiving</span>
                  </label>
                </div>  
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gr_rec0" name="f_gr_rec0" value="Y" <?php if(isset($_POST['f_gr_rec0'])) { ?> checked <?php  } ?> ><span class="button-indecator">PO Listing</span>
                  </label>
                </div>   
             
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gr_rec" name="f_gr_rec" value="Y" <?php if(isset($_POST['f_gr_rec'])) { ?> checked <?php  } ?> ><span class="button-indecator">Goods Receipt</span>
                  </label>
                </div>   
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gr_rec2" name="f_gr_rec2" value="Y" <?php if(isset($_POST['f_gr_rec2'])) { ?> checked <?php  } ?> ><span class="button-indecator">Goods Receipt by PO</span>
                  </label>
                </div>     
                
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_grfoc_rec" name="f_grfoc_rec" value="Y" <?php if(isset($_POST['f_grfoc_rec'])) { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt FOC</span>
                  </label>
                </div>     
              
              <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_print_rec"  name="f_print_rec"  value="Y" <?php if(isset($_POST['f_print_rec'])) { ?> checked <?php  } ?>><span class="button-indecator">Print GR Tag</span>
                  </label>
                </div>    
                
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_printfoc_rec"  name="f_printfoc_rec"  value="Y" <?php if(isset($_POST['f_printfoc_rec'])) { ?> checked <?php  } ?>><span class="button-indecator">Print GR FOC Tag</span>
                  </label>
                </div>    
              
               <hr width="100%">  
                <!-- Goods Return --->
               <p><b>Goods Return</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gturn_rec" name="f_gturn_rec" value="Y" <?php if(isset($_POST['f_gturn_rec'])) { ?> checked <?php  } ?>><span class="button-indecator">Goods Return</span>
                  </label>
                </div>    
                
                  <hr width="100%">  
                
                <!-- GI Consumable --->
               <p><b>GI Consumable</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gi_rec" name="f_gi_rec" value="Y" <?php if(isset($_POST['f_gi_rec'])) { ?> checked <?php  } ?>><span class="button-indecator">GI Consumable</span>
                  </label>
                </div>    
                
                
                
                
                  <hr width="100%">  
           
           
              <!-- Transfer Posting --->
               <p><b>Transfer Posting</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_tp_progress" name="f_tp_progress" value="Y" <?php if(isset($_POST['f_tp_progress'])) { ?> checked <?php  } ?>><span class="button-indecator">Transfer Posting</span>
                  </label>
                </div>  
                  <hr width="100%">  
                
                 <!-- Subcontracting --->
                 <p><b>Subcontracting</b></p>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="main_subcont" name="main_subcont" value="Y" <?php if(isset($_POST['main_subcont'])) { ?> checked <?php  } ?>><span class="button-indecator">Subcontracting</span>
                  </label>
                </div> 
                
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_subcont" name="f_subcont" value="Y" <?php if(isset($_POST['f_subcont'])) { ?> checked <?php  } ?>><span class="button-indecator">Transfer to Subcont</span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_subcont2" name="f_subcont2" value="Y" <?php if(isset($_POST['f_subcont2'])) { ?> checked <?php  } ?>><span class="button-indecator">Print SDO</span>
                  </label>
                </div> 
                
                
                  <hr width="100%">  
                
                 <!-- Transfer Material --->
                 <p><b>Transfer Material</b></p>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_trans_rec" name="f_trans_rec" value="Y" <?php if(isset($_POST['f_trans_rec'])) { ?> checked <?php  } ?>><span class="button-indecator">Transfer Material</span>
                  </label>
                </div> 
                
                <hr width="100%">  
                   
                  <!-- Delivery --->
                 <p><b>Delivery</b></p>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="main_dlv" name="main_dlv" value="Y" <?php if(isset($_POST['main_dlv'])) { ?> checked <?php  } ?>><span class="button-indecator">Delivery</span>
                  </label>
                 </div>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do7" name="f_dlv_do7" value="Y" <?php if(isset($_POST['f_dlv_do7'])) { ?> checked <?php  } ?>><span class="button-indecator">Sales Order Listing</span>
                  </label>
                 </div>
                 
                   <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do" name="f_dlv_do" value="Y" <?php if(isset($_POST['f_dlv_do'])) { ?> checked <?php  } ?>><span class="button-indecator">Create DO Perodua</span>
                  </label>
                 </div>
                    <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do2" name="f_dlv_do2" value="Y" <?php if(isset($_POST['f_dlv_do2'])) { ?> checked <?php  } ?>><span class="button-indecator">Create DO Perodua Sales</span>
                  </label>
                 </div>
                    <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do5" name="f_dlv_do5" value="Y" <?php if(isset($_POST['f_dlv_do5'])) { ?> checked <?php  } ?>><span class="button-indecator">Create DO Perodua Manufacturing</span>
                  </label>
                 </div>
                  <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do3" name="f_dlv_do3" value="Y" <?php if(isset($_POST['f_dlv_do3'])) { ?> checked <?php  } ?>><span class="button-indecator">Create DO Others Customer</span>
                  </label>
                 </div>
                  <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do4" name="f_dlv_do4" value="Y" <?php if(isset($_POST['f_dlv_do4'])) { ?> checked <?php  } ?>><span class="button-indecator">Print DO</span>
                  </label>
                 </div>
                  <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do6" name="f_dlv_do6" value="Y" <?php if(isset($_POST['f_dlv_do6'])) { ?> checked <?php  } ?>><span class="button-indecator">Closed Sales Order</span>
                  </label>
                 </div>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do8" name="f_dlv_do8" value="Y" <?php if(isset($_POST['f_dlv_do8'])) { ?> checked <?php  } ?>><span class="button-indecator">Upload PDIO</span>
                  </label>
                 </div>
                 <div class="toggle">
                  <label>
                   <input type="checkbox" id="f_dlv_do9" name="f_dlv_do9" value="Y" <?php if(isset($_POST['f_dlv_do9'])) { ?> checked <?php  } ?>><span class="button-indecator">Create DO Perodua</span>
                  </label>
                 </div>
                   
               <hr width="100%">  
              
                 <!-- Disposal Receiving --->
                <p><b>Disposal Receiving</b></p>
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_rec" name="f_dis_rec" value="Y" <?php if(isset($_POST['f_dis_rec'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal Receiving</span>
                  </label>
                </div> 
                
                 <hr width="100%">  
              
                 <!-- Disposal Approval Receiving --->
                <p><b>Disposal Approval Receiving</b></p>
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_rec" name="f_dis_approval_rec" value="Y" <?php if(isset($_POST['f_dis_approval_rec'])) { ?> checked <?php  } ?> ><span class="button-indecator">Disposal Approval Receiving</span>
                  </label>
                </div>
                
                
               <hr width="100%">
                
                <!-- Transit --->
                <p><b>Transit</b></p>
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_transit" name="main_transit" value="Y" <?php if(isset($_POST['main_transit'])) { ?> checked <?php  } ?>><span class="button-indecator">Transit</span>
                  </label>
                </div>
               
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_tran_dlv" name="f_bf_tran_dlv" value="Y" <?php if(isset($_POST['f_bf_tran_dlv'])) { ?> checked <?php  } ?>><span class="button-indecator">BF Transit</span>
                  </label>
                </div>
                
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_tran_dlv2" name="f_bf_tran_dlv2" value="Y" <?php if(isset($_POST['f_bf_tran_dlv2'])) { ?> checked <?php  } ?>><span class="button-indecator">Print Tag</span>
                  </label>
                </div>
                
               
               
                <hr width="100%"> 
                
            <!-- Backflush --->
               <p><b>Backflush</b></p>
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_bflush" name="main_bflush" value="Y" <?php if(isset($_POST['main_bflush'])) { ?> checked <?php  } ?>><span class="button-indecator">Backflush</span>
                  </label>
                </div>
               
               
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_ok" name="f_bf_ok" value="Y" <?php if(isset($_POST['f_bf_ok'])) { ?> checked <?php  } ?>><span class="button-indecator">Confirmation Backflush (OK)</span>
                  </label>
                </div>  
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_ng"  name="f_bf_ng" value="Y" <?php if(isset($_POST['f_bf_ng'])) { ?> checked <?php  } ?>><span class="button-indecator">Confirmation Backflush (NG)</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_pending" name="f_bf_pending" value="Y" <?php if(isset($_POST['f_bf_pending'])) { ?> checked <?php  } ?>><span class="button-indecator">Confirmation Backflush (Pending) </span>
                  </label>
                </div>  
              
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_handwork" name="f_bf_handwork" value="Y" <?php if(isset($_POST['f_bf_handwork'])) { ?> checked <?php  } ?>><span class="button-indecator">Confirmation Backflush (Handwork)</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_print_prd" name="f_print_prd" value="Y" <?php if(isset($_POST['f_print_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">Print Tag</span>
                  </label>
                </div> 
               
              
               <hr width="100%"> 
                
            <!-- Production --->
               <p><b>Production</b></p>
             
            
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_bf_pend_conf_prd" name="f_bf_pend_conf_prd" value="Y" <?php if(isset($_POST['f_bf_pend_conf_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">Pending Confirmation</span>
                  </label>
                </div>  
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_pend_rwork_conf_prd" name="f_pend_rwork_conf_prd" value="Y" <?php if(isset($_POST['f_pend_rwork_conf_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">Rework</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_pend_hwork_conf_prd"  name="f_pend_hwork_conf_prd" value="Y" <?php if(isset($_POST['f_pend_hwork_conf_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">Handwork</span>
                  </label>
                </div>  
              
               
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_list_prd"  name="f_dis_list_prd" value="Y" <?php if(isset($_POST['f_dis_list_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposals List</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_prd" name="f_dis_approval_prd" value="Y" <?php if(isset($_POST['f_dis_approval_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval Engineering</span>
                  </label>
                </div>  
              
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_prd2" name="f_dis_approval_prd2" value="Y" <?php if(isset($_POST['f_dis_approval_prd2'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval Stamping</span>
                  </label>
                </div> 
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_prd3" name="f_dis_approval_prd3" value="Y" <?php if(isset($_POST['f_dis_approval_prd3'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval - Assembly</span>
                  </label>
                </div> 
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_prd4" name="f_dis_approval_prd4" value="Y" <?php if(isset($_POST['f_dis_approval_prd4'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval </span>
                  </label>
                </div> 
                 
                 
                  <hr width="100%"> 
                
            <!-- Disposals --->
               <p><b>Disposals</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_disposal" name="main_disposal" value="Y" <?php if(isset($_POST['main_disposal'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposals</span>
                  </label>
                </div>    
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_prd" name="f_dis_prd" value="Y" <?php if(isset($_POST['f_dis_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">Reject Output</span>
                  </label>
                </div> 
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_comp_rej_prd" name="f_comp_rej_prd" value="Y" <?php if(isset($_POST['f_comp_rej_prd'])) { ?> checked <?php  } ?>><span class="button-indecator">Component Reject</span>
                  </label>
                </div> 
                
                
                   <hr width="100%"> 
                
            <!-- Disposal Engineering --->
               <p><b>Disposal Engineering</b></p>
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_disposal_prd2" name="main_disposal_prd2" value="Y" <?php if(isset($_POST['main_disposal_prd2'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposals</span>
                  </label>
                </div>  
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_rej_prd2" name="f_dis_rej_prd2" value="Y" <?php if(isset($_POST['f_dis_rej_prd2'])) { ?> checked <?php  } ?> ><span class="button-indecator">Reject Part</span>
                  </label>
                </div>  
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_comp_rej_prd2" name="f_comp_rej_prd2" value="Y" <?php if(isset($_POST['f_comp_rej_prd2'])) { ?> checked <?php  } ?> ><span class="button-indecator">Reject Component</span>
                  </label>
                </div> 
                
                 
                
              <hr width="100%"> 
                
            <!-- Return Advise --->
               <p><b>Return Advise</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_gra" name="main_gra" value="Y" <?php if(isset($_POST['main_gra'])) { ?> checked <?php  } ?>><span class="button-indecator">Return Advise</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_gra_qc" name="f_gra_qc" value="Y" <?php if(isset($_POST['f_gra_qc'])) { ?> checked <?php  } ?>><span class="button-indecator">Goods Return Advise(GRA)</span>
                  </label>
                </div>  
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_print_qc" name="f_print_qc" value="Y" <?php if(isset($_POST['f_print_qc'])) { ?> checked <?php  } ?> ><span class="button-indecator">Print GRA</span>
                  </label>
                </div>  
                
                   
              <hr width="100%"> 
                
            <!-- Disposal QC --->
               <p><b>Disposal QC</b></p>
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_disposal_qc" name="main_disposal_qc" value="Y" <?php if(isset($_POST['main_disposal_qc'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposals</span>
                  </label>
                </div>  
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_qc" name="f_dis_approval_qc" value="Y" <?php if(isset($_POST['f_dis_approval_qc'])) { ?> checked <?php  } ?> ><span class="button-indecator">Reject Part</span>
                  </label>
                </div>  
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_comp_rej_qc" name="f_comp_rej_qc" value="Y" <?php if(isset($_POST['f_comp_rej_qc'])) { ?> checked <?php  } ?> ><span class="button-indecator">Reject Component</span>
                  </label>
                </div> 
                
                
                 
                
                 <hr width="100%"> 
                
            <!-- Disposal Approval Exec --->
               <p><b>Disposal Approval HOD QC</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_ex_qc"  name="f_dis_approval_ex_qc" value="Y" <?php if(isset($_POST['f_dis_approval_ex_qc'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval HOD QC</span>
                  </label>
                </div>  
                   
              <hr width="100%"> 
                
            <!-- Disposal Approval QC --->
               <p><b>Disposal Approval COO</b></p>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_dis_approval_h_qc" name="f_dis_approval_h_qc" value="Y" <?php if(isset($_POST['f_dis_approval_h_qc'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal Approval COO</span>
                  </label>
                </div>  
                
                          
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_hqc_smenu1" name="f_hqc_smenu1" value="Y" <?php if(isset($_POST['f_hqc_smenu1'])) { ?> checked <?php  } ?> ><span class="button-indecator">Disposal Approval </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_hqc_smenu2" name="f_hqc_smenu2" value="Y" <?php if(isset($_POST['f_hqc_smenu2'])) { ?> checked <?php  } ?>><span class="button-indecator">Cancellation</span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_hqc_smenu3" name="f_hqc_smenu3" value="Y" <?php if(isset($_POST['f_hqc_smenu3'])) { ?> checked <?php  } ?>><span class="button-indecator">Document List </span>
                  </label>
                </div>    
              
                
                
                
                <hr width="100%">  
                   
            <!-- Cancellation --->
               <p><b>Cancellation </b></p>
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_canc" name="main_canc" value="Y" <?php if(isset($_POST['main_canc'])) { ?> checked <?php  } ?>><span class="button-indecator">Cancellation </span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu1" name="f_canc_smenu1" value="Y" <?php if(isset($_POST['f_canc_smenu1'])) { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu2" name="f_canc_smenu2" value="Y" <?php if(isset($_POST['f_canc_smenu2'])) { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt FOC </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu3" name="f_canc_smenu3" value="Y" <?php if(isset($_POST['f_canc_smenu3'])) { ?> checked <?php  } ?>><span class="button-indecator">Goods Return </span>
                  </label>
                </div>    
           
         
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu4" name="f_canc_smenu4" value="Y" <?php if(isset($_POST['f_canc_smenu4'])) { ?> checked <?php  } ?>><span class="button-indecator">GI Consumable </span>
                  </label>
                </div>    
           
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu5" name="f_canc_smenu5" value="Y" <?php if(isset($_POST['f_canc_smenu5'])) { ?> checked <?php  } ?>><span class="button-indecator">Transfer Posting </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu6" name="f_canc_smenu6" value="Y" <?php if(isset($_POST['f_canc_smenu6'])) { ?> checked <?php  } ?> ><span class="button-indecator">Transfer to Subcont </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu7" name="f_canc_smenu7" value="Y" <?php if(isset($_POST['f_canc_smenu7'])) { ?> checked <?php  } ?>><span class="button-indecator">Transfer Material </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu8" name="f_canc_smenu8" value="Y" <?php if(isset($_POST['f_canc_smenu8'])) { ?> checked <?php  } ?>><span class="button-indecator">Delivery Order </span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu9" name="f_canc_smenu9" value="Y" <?php if(isset($_POST['f_canc_smenu9'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal PPC </span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu10" name="f_canc_smenu10" value="Y" <?php if(isset($_POST['f_canc_smenu10'])) { ?> checked <?php  } ?>><span class="button-indecator">Production </span>
                  </label>
                </div>    
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu11" name="f_canc_smenu11" value="Y" <?php if(isset($_POST['f_canc_smenu11'])) { ?> checked <?php  } ?>><span class="button-indecator">Goods Return Advise </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu12" name="f_canc_smenu12" value="Y" <?php if(isset($_POST['f_canc_smenu12'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal QC </span>
                  </label>
                </div>   
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_canc_smenu13" name="f_canc_smenu13" value="Y" <?php if(isset($_POST['f_canc_smenu13'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal Engineering </span>
                  </label>
                </div>   
              
               <hr width="100%">           
               <!-- Report --->
               <p><b>Report </b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_rpt" name="main_rpt" value="Y" <?php if(isset($_POST['main_rpt'])) { ?> checked <?php  } ?>><span class="button-indecator">Report </span>
                  </label>
                </div>
                
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu0" name="f_rpt_smenu0" value="Y" <?php if(isset($_POST['f_rpt_smenu0'])) { ?> checked <?php  } ?>><span class="button-indecator">Delivery Instruction </span>
                  </label>
                </div>  
                
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu21" name="f_rpt_smenu21" value="Y" <?php if(isset($_POST['f_rpt_smenu21'])) { ?> checked <?php  } ?>><span class="button-indecator">Delivery Instruction PPC </span>
                  </label>
                </div>   
              <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu18" name="f_rpt_smenu18" value="Y" <?php if(isset($_POST['f_rpt_smenu18'])) { ?> checked <?php  } ?>><span class="button-indecator">Delivery Order </span>
                  </label>
                </div> 
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu1" name="f_rpt_smenu1" value="Y" <?php if(isset($_POST['f_rpt_smenu1'])) { ?> checked <?php  } ?> ><span class="button-indecator">Goods Receipt </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu2" name="f_rpt_smenu2" value="Y" <?php if(isset($_POST['f_rpt_smenu2'])) { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt FOC </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu3" name="f_rpt_smenu3" value="Y" <?php if(isset($_POST['f_rpt_smenu3'])) { ?> checked <?php  } ?>><span class="button-indecator">Goods Return </span>
                  </label>
                </div>    
           
         
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu4" name="f_rpt_smenu4" value="Y" <?php if(isset($_POST['f_rpt_smenu4'])) { ?> checked <?php  } ?>><span class="button-indecator">GI Consumable </span>
                  </label>
                </div>    
           
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu5" name="f_rpt_smenu5" value="Y" <?php if(isset($_POST['f_rpt_smenu5'])) { ?> checked <?php  } ?>><span class="button-indecator">Transfer Posting </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu6" name="f_rpt_smenu6" value="Y" <?php if(isset($_POST['f_rpt_smenu6'])) { ?> checked <?php  } ?>><span class="button-indecator">Transfer to Subcont </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu7" name="f_rpt_smenu7" value="Y" <?php if(isset($_POST['f_rpt_smenu7'])) { ?> checked <?php  } ?>><span class="button-indecator">Transfer Material </span>
                  </label>
                </div> 
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu17" name="f_rpt_smenu17" value="Y" <?php if(isset($_POST['f_rpt_smenu17'])) { ?> checked <?php  } ?>><span class="button-indecator">PDIO/DI </span>
                  </label>
                </div> 
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu20" name="f_rpt_smenu20" value="Y" <?php if(isset($_POST['f_rpt_smenu20'])) { ?> checked <?php  } ?>><span class="button-indecator">PDIO/DI for FINA </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu8" name="f_rpt_smenu8" value="Y" <?php if(isset($_POST['f_rpt_smenu8'])) { ?> checked <?php  } ?>><span class="button-indecator">Backflush Transit </span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu9" name="f_rpt_smenu9" value="Y" <?php if(isset($_POST['f_rpt_smenu9'])) { ?> checked <?php  } ?>><span class="button-indecator">Goods Return Advise </span>
                  </label>
                </div>
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu19" name="f_rpt_smenu19" value="Y" <?php if(isset($_POST['f_rpt_smenu19'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal PPC </span>
                  </label>
                </div>    
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu10" name="f_rpt_smenu10" value="Y" <?php if(isset($_POST['f_rpt_smenu10'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal QC </span>
                  </label>
                </div>    
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu11" name="f_rpt_smenu11" value="Y" <?php if(isset($_POST['f_rpt_smenu11'])) { ?> checked <?php  } ?>><span class="button-indecator">Backflush </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu12" name="f_rpt_smenu12" value="Y" <?php if(isset($_POST['f_rpt_smenu12'])) { ?> checked <?php  } ?>><span class="button-indecator">Pending </span>
                  </label>
                </div>   
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu13" name="f_rpt_smenu13" value="Y" <?php if(isset($_POST['f_rpt_smenu13'])) { ?> checked <?php  } ?>><span class="button-indecator">Rework </span>
                  </label>
                </div>   
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu14" name="f_rpt_smenu14" value="Y" <?php if(isset($_POST['f_rpt_smenu14'])) { ?> checked <?php  } ?>><span class="button-indecator">Handwork </span>
                  </label>
                </div>   
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu15" name="f_rpt_smenu15" value="Y" <?php if(isset($_POST['f_rpt_smenu15'])) { ?> checked <?php  } ?> ><span class="button-indecator">Disposal Production</span>
                  </label>
                </div>   
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu16" name="f_rpt_smenu16" value="Y" <?php if(isset($_POST['f_rpt_smenu16'])) { ?> checked <?php  } ?>><span class="button-indecator">Planned Order Status </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu22" name="f_rpt_smenu22" value="Y" <?php if(isset($_POST['f_rpt_smenu22'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal Engineering </span>
                  </label>
                 </div>   
                  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_rpt_smenu23" name="f_rpt_smenu23" value="Y" <?php if(isset($_POST['f_rpt_smenu23'])) { ?> checked <?php  } ?>><span class="button-indecator">Menu Report</span>
                  </label>
                 </div>   
                  
                  
                   <hr width="100%">           
               <!-- FTP Monitoring --->
               <p><b>FTP Monitoring</b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_ftp" name="main_ftp" value="Y" <?php if(isset($_POST['main_ftp'])) { ?> checked <?php  } ?>><span class="button-indecator">FTP Monitoring </span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu1" name="f_ftp_smenu1" value="Y" <?php if(isset($_POST['f_ftp_smenu1'])) { ?> checked <?php  } ?> ><span class="button-indecator">Backflush OK </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu2" name="f_ftp_smenu2" value="Y" <?php if(isset($_POST['f_ftp_smenu2'])) { ?> checked <?php  } ?>><span class="button-indecator">Backflush NG </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu3" name="f_ftp_smenu3" value="Y" <?php if(isset($_POST['f_ftp_smenu3'])) { ?> checked <?php  } ?>><span class="button-indecator">Backflush Pending </span>
                  </label>
                </div>    
           
         
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu4" name="f_ftp_smenu4" value="Y" <?php if(isset($_POST['f_ftp_smenu4'])) { ?> checked <?php  } ?>><span class="button-indecator">Backflush Handwork </span>
                  </label>
                </div>    
           
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu5" name="f_ftp_smenu5" value="Y" <?php if(isset($_POST['f_ftp_smenu5'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal GI </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu6" name="f_ftp_smenu6" value="Y" <?php if(isset($_POST['f_ftp_smenu6'])) { ?> checked <?php  } ?>><span class="button-indecator">Goods Receipt </span>
                  </label>
                </div>   
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu7" name="f_ftp_smenu7" value="Y" <?php if(isset($_POST['f_ftp_smenu7'])) { ?> checked <?php  } ?>><span class="button-indecator">Goods Return </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu8" name="f_ftp_smenu8" value="Y" <?php if(isset($_POST['f_ftp_smenu8'])) { ?> checked <?php  } ?>><span class="button-indecator">GI Consumable</span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu9" name="f_ftp_smenu9" value="Y" <?php if(isset($_POST['f_ftp_smenu9'])) { ?> checked <?php  } ?>><span class="button-indecator">Transfer Material </span>
                  </label>
                </div>  
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu10" name="f_ftp_smenu10" value="Y" <?php if(isset($_POST['f_ftp_smenu10'])) { ?> checked <?php  } ?>><span class="button-indecator">Transfer Posting </span>
                  </label>
                </div>    
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu15" name="f_ftp_smenu15" value="Y" <?php if(isset($_POST['f_ftp_smenu15'])) { ?> checked <?php  } ?>><span class="button-indecator">Transfer to Subcont </span>
                  </label>
                </div> 
              
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu11" name="f_ftp_smenu11" value="Y" <?php if(isset($_POST['f_ftp_smenu11'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal </span>
                  </label>
                </div> 
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu12" name="f_ftp_smenu12" value="Y" <?php if(isset($_POST['f_ftp_smenu12'])) { ?> checked <?php  } ?>><span class="button-indecator">Backflush Transit</span>
                  </label>
                </div>   
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu13" name="f_ftp_smenu13" value="Y" <?php if(isset($_POST['f_ftp_smenu13'])) { ?> checked <?php  } ?>><span class="button-indecator">Delivery Order </span>
                  </label>
                </div>   
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu14" name="f_ftp_smenu14" value="Y" <?php if(isset($_POST['f_ftp_smenu14'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal QC </span>
                  </label>
                </div>   
                
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_ftp_smenu16" name="f_ftp_smenu16" value="Y" <?php if(isset($_POST['f_ftp_smenu16'])) { ?> checked <?php  } ?>><span class="button-indecator">Disposal Engineering </span>
                  </label>
                </div>   
                  
                  
               <hr width="100%">           
               <!-- CEO --->
               <p><b><?php echo html_esc($rst_apprv8["apprv_name2"]); ?></b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_coo" name="main_coo" value="Y" <?php if(isset($_POST['main_coo'])) { ?> checked <?php  } ?>><span class="button-indecator"> <?php echo html_esc($rst_apprv8["apprv_name2"]); ?></span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu1" name="f_coo_smenu1" value="Y" <?php if(isset($_POST['f_coo_smenu1'])) { ?> checked <?php  } ?> ><span class="button-indecator">Pending Approval </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu2" name="f_coo_smenu2" value="Y" <?php if(isset($_POST['f_coo_smenu2'])) { ?> checked <?php  } ?>><span class="button-indecator">Approved</span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu3" name="f_coo_smenu3" value="Y" <?php if(isset($_POST['f_coo_smenu3'])) { ?> checked <?php  } ?>><span class="button-indecator">Rejected </span>
                  </label>
                </div>    
           
         
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu4" name="f_coo_smenu4" value="Y" <?php if(isset($_POST['f_coo_smenu4'])) { ?> checked <?php  } ?>><span class="button-indecator">Cancellation </span>
                  </label>
                </div>    
           
                <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_coo_smenu5" name="f_coo_smenu5" value="Y" <?php if(isset($_POST['f_coo_smenu5'])) { ?> checked <?php  } ?>><span class="button-indecator">Document List </span>
                  </label>
                </div>   
                  
                  
                   <hr width="100%">           
               <!-- Report --->
                  <p><b>Close PPS </b></p>
                  
                  
                  <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_close_pps" name="f_close_pps" value="Y" <?php if(isset($_POST['f_close_pps'])) { ?> checked <?php  } ?>><span class="button-indecator">Closing </span>
                  </label>
                  </div>   
                
    
          
                 
                   <hr width="100%">           
               <!-- PO --->
               <p><b>Purchase Order</b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_po" name="main_po" value="Y" <?php if(isset($_POST['main_po'])) { ?> checked <?php  } ?>><span class="button-indecator">Purchase Order </span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_po_smenu1" name="f_po_smenu1" value="Y" <?php if(isset($_POST['f_po_smenu1'])) { ?> checked <?php  } ?> ><span class="button-indecator">Upload PO </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_po_smenu2" name="f_po_smenu2" value="Y" <?php if(isset($_POST['f_po_smenu2'])) { ?> checked <?php  } ?>><span class="button-indecator">View PO </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_po_smenu3" name="f_po_smenu3" value="Y" <?php if(isset($_POST['f_po_smenu3'])) { ?> checked <?php  } ?>><span class="button-indecator">Maintain PO </span>
                  </label>
                </div>    
           
        
        
         
                   <hr width="100%">           
               <!-- MFO --->
               <p><b>Material Forecast Order</b></p>
               
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="main_mfo" name="main_mfo" value="Y" <?php if(isset($_POST['main_mfo'])) { ?> checked <?php  } ?>><span class="button-indecator">Material Forecast Order </span>
                  </label>
                </div>
             
               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_mfo_smenu1" name="f_mfo_smenu1" value="Y" <?php if(isset($_POST['f_mfo_smenu1'])) { ?> checked <?php  } ?> ><span class="button-indecator">Upload MFO </span>
                  </label>
                </div>
                
                 <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_mfo_smenu2" name="f_mfo_smenu2" value="Y" <?php if(isset($_POST['f_mfo_smenu2'])) { ?> checked <?php  } ?>><span class="button-indecator">View MFO </span>
                  </label>
                </div>    

               <div class="toggle">
                  <label>
                  <input type="checkbox" id="f_mfo_smenu3" name="f_mfo_smenu3" value="Y" <?php if(isset($_POST['f_mfo_smenu3'])) { ?> checked <?php  } ?>><span class="button-indecator">Maintain MFO </span>
                  </label>
                </div>    
           
            </div>
            
               
                <div class="form-group row">
                  <label class="control-label col-md-3"><font color="#FF0000"><b>  * Compulsory field</b></font></label>
                  
                  
                    <div class="col-md-8">
                  &nbsp; 
                </div>
           
                <div class="form-group col-md-8 align-self-end">
               <input name="submit_Y" type="submit" id="submit_Y" value="CREATE" class="btn btn-primary">
               <input name="Reset" type="reset" id="Reset" class="btn btn-warning" value="CLEAR">
                </div></div></div>
              </form>
            </div>
          </div>
      
         </div>
         </div>
      
     <!--     </div>
        </div>-->
     
    </main>
    <script>
$('[type="checkbox"]').change(function() {
    var shouldBeDisplayed = $(this).prop('checked');
    $('div[data-parentid="' + $(this).attr('id') + '"]').toggle(shouldBeDisplayed);
});
	</script>
    
    
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript"> 
            $(document).ready(function() { 
                $('input[type="checkbox"]').click(function() { 
                    var inputValue = $(this).attr("value"); 
                    $("." + inputValue).toggle(); 
                }); 
            }); 
        </script> 
        
     <script language="javascript" type="text/javascript">

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
	function getPlant(vendor_no) {		
		
		var strURL="findPlant2-Adduser.php?vendor_no="+vendor_no;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('plantdiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
</script>    
    
  </body>
</html>