<?php
ini_set("display_errors", 1);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

$fmt_curr_date = (date("d-m-Y"));
$drun = substr($fmt_curr_date,0,2);
$mrun = substr($fmt_curr_date,3,2);
$yrun = substr($fmt_curr_date,8,2);

$date_run = ($drun.$mrun.$yrun);
//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);

$extension = explode('.', $data_setup["logo_name"]);
$filename = $data_setup["logo_comp"].'.'.$extension[1];
//----------------------------------------------------

$query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
$result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
$res = mysqli_fetch_array($result2);
    
//CR status (New)
$sta = "SELECT * from request_status WHERE status_id = '1'";
$sta_res = mysqli_query($dbc,$sta);
$rst_sta = mysqli_fetch_array($sta_res);

//CR status (Released)
$sta2 = "SELECT * from request_status WHERE status_id = '2'";
$sta_res2 = mysqli_query($dbc,$sta2);
$rst_sta2 = mysqli_fetch_array($sta_res2);


//CR status (Approved)
$sta3 = "SELECT * from request_status WHERE status_id = '3'";
$sta_res3 = mysqli_query($dbc,$sta3);
$rst_sta3 = mysqli_fetch_array($sta_res3);

//CR status (Cancelled)
$sta4 = "SELECT * from request_status WHERE status_id = '4'";
$sta_res4 = mysqli_query($dbc,$sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

//CR status (Pending)
$sta8 = "SELECT * from request_status WHERE status_id = '8'";
$sta_res8 = mysqli_query($dbc,$sta8);
$rst_sta8 = mysqli_fetch_array($sta_res8);

//CR status (Pending Approval PPC)
$sta10 = "SELECT * from request_status WHERE status_id = '10'";
$sta_res10 = mysqli_query($dbc,$sta10);
$rst_sta10 = mysqli_fetch_array($sta_res10);

//CR status (Closed)
$sta13 = "SELECT * from request_status WHERE status_id = '13'";
$sta_res13 = mysqli_query($dbc,$sta13);
$rst_sta13 = mysqli_fetch_array($sta_res13);

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

//CR status (Cancel)
$sta21 = "SELECT * from request_status WHERE status_id = '21'";
$sta_res21 = mysqli_query($dbc,$sta21);
$rst_sta21 = mysqli_fetch_array($sta_res21);

//CR status (Close)
$sta22 = "SELECT * from request_status WHERE status_id = '22'";
$sta_res22 = mysqli_query($dbc,$sta22);
$rst_sta22 = mysqli_fetch_array($sta_res22);

//CR status (Transfer GRA)
$sta23 = "SELECT * from request_status WHERE status_id = '23'";
$sta_res23 = mysqli_query($dbc,$sta23);
$rst_sta23 = mysqli_fetch_array($sta_res23);

//CR status (Pending Approval QC)
$sta24 = "SELECT * from request_status WHERE status_id = '24'";
$sta_res24 = mysqli_query($dbc,$sta24);
$rst_sta24 = mysqli_fetch_array($sta_res24);

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);

//CR status (Transfer Material)
$sta28 = "SELECT * from request_status WHERE status_id = '28'";
$sta_res28 = mysqli_query($dbc,$sta28);
$rst_sta28 = mysqli_fetch_array($sta_res28);

//CR status (Return)
$sta30 = "SELECT * from request_status WHERE status_id = '30'";
$sta_res30 = mysqli_query($dbc,$sta30);
$rst_sta30 = mysqli_fetch_array($sta_res30);

//CR status (Return Delivery)
$sta31 = "SELECT * from request_status WHERE status_id = '31'";
$sta_res31 = mysqli_query($dbc,$sta31);
$rst_sta31 = mysqli_fetch_array($sta_res31);

if(isset($_POST['material_doc_gen'])){
    $material_doc_gen = $_POST['material_doc_gen'];
    $dateF = $_POST["date1"];
    $dateT = $_POST["date2"];
    $ship_point = $_POST["ship_point"]; 
    $ship_to = $_POST["ship_to"]; 
    $do_no = $_POST['do_no'];
    $trans_type = $_POST['trans_type'];
    $model_code = $_POST['model_code'];
    $material_no = $_POST['material_no'];

    $query_bb = "SELECT * from dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($material_doc_gen)."'";
    $rs_bb = mysqli_query($dbc,$query_bb);  
    $data_bb = mysqli_fetch_array($rs_bb);
	 
    //------------plant code detail -------------
    $query_plant = "SELECT * FROM plant_detail WHERE plant_code = '".sql_esc($data_bb["plant_code"])."'";
    $result_plant = mysqli_query($dbc,$query_plant);
    $data_plant = mysqli_fetch_array($result_plant);

    $html  = '<form name="frmSearch" id="frmSearch" method="post" action=""';
    $html .= '<table width="98%" border="0" cellspacing="0" cellpadding="0" class="table table-borderless">';
    $html .= '<tr>';
    $html .= '<td><img src="../set_upload/'.$filename.'" width="250" height="50"/></td>';
    $html .= '<td>&nbsp;</td>';
    $html .= '<td valign="top">&nbsp;<h5><font color="#999999"><b>PSS DELIVERY ORDER</b></font></h5></td>';
    $html .= '</tr><tr>';
    $html .= '<td><div align="left"><b>Plant :  </b>'.$data_plant["plant_desc"].'</div></td>';
    $html .= '<td>&nbsp;</td>';
    $html .= '<td><div align="left"><b>Document No. :  </b>'.$material_doc_gen.'</div></td>';
    $html .= '</tr><tr>';
    $html .= '<td>&nbsp;</td>';
    $html .= '<td>&nbsp;</td>';
    $html .= '<td><div align="left"><b>DI/PDIO No. :  </b>'.$data_bb["pdio_no"].'</div></td>';
    $html .= '</tr></table>';

    //-------Where SQL Build------------------------//
			
    $where_sql = '';
    
    $ddF = substr($_POST["date1"],0,2);
    $mmF = substr($_POST["date1"],3,2);
    $yyF = substr($_POST["date1"],6,4);

    $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
    
    $ddF2 = substr($_POST["date2"],0,2);
    $mmF2 = substr($_POST["date2"],3,2);
    $yyF2 = substr($_POST["date2"],6,4);

    $date2_final = ($yyF2.'-'.$mmF2.'-'.$ddF2);
				 
    //1. do_no
    if ($do_no == ""){ 
    $wheresql_01 = ""; }
    else {
    $wheresql_01 = " AND pdio_no = '".sql_esc($do_no)."'"; }  
					
   //2. ship to party
    if (($ship_to == "") || ($ship_to == "NULL")){ 
        $wheresql_02 = ""; }
    else {
        $wheresql_02 = " AND ship_no = '".sql_esc($ship_to)."'"; }  	
                
            
    // 3. dateF
    if ($dateF == "0000-00-00" ){
        $wheresql_03 = ""; }
    else {
        $wheresql_03 = " AND (DATE(dlv_date) >= '".sql_esc($date1_final)."')"; }      
                                        
            
    //4. DateT
    if ($dateT == "0000-00-00" ){
        $wheresql_04 = ""; }
    else {
        $wheresql_04 = " AND (DATE(dlv_date) <= '".sql_esc($date2_final)."')"; }
                
    //5. Material No
    if ($material_no == "NULL" ){
    $wheresql_05 = ""; }
    else {
    $wheresql_05 = " AND (material_no = '".sql_esc($material_no)."')"; }
					
					
    //6. model_code
    if ($model_code == "NULL" ){
    $wheresql_06 = ""; }
    else {
    $wheresql_06 = " AND (sales_org = '".sql_esc($model_code)."')"; }
					
						
    //8. Transfer Type
    if(($trans_type == "NORMAL") || ($trans_type == "NULL" )){
    $wheresql_08 = ""; 
    }elseif($trans_type == "CANCEL" ){
    $wheresql_08 = " AND (status_DO = '".sql_esc($rst_sta3['status_desc'])."')"; 
    }else{

    }

    $where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05 .$wheresql_06 .$wheresql_08;

    $counter = 1;
    $no = 1;
    $sta_out = "";

    $query_display = "SELECT *, DATE_FORMAT(posting_date,'%d-%m-%Y') AS T3, DATE_FORMAT(dlv_date,'%d-%m-%Y') AS T7 FROM dlv_ord_all_delivery WHERE material_doc_gen = '".sql_esc($material_doc_gen)."' " .$where_sql." ORDER BY material_doc_gen ASC ";
    $result_display = mysqli_query($dbc,$query_display);

    $html .= '<table width="98%" class="table-bordered"><thead bgcolor="#eeeeee"><tr>';
    $html .= '<th>No</th><th>Part No.</th><th>Part Name</th><th>Back No.</th><th>Created Date</th><th>Delivery Date</th><th>Quantity</th><th>Unit</th><th>Customer</th>';
    $html .= '</tr></thead><tbody>';

    while($row2 = mysqli_fetch_assoc($result_display))
    {
        $query_mat = "SELECT * FROM table_material_itsb WHERE material_cust_no = '".sql_esc($row2["material_no"])."'";
	    $result_mat = mysqli_query($dbc,$query_mat);
        $row_mat = mysqli_fetch_array($result_mat);

        $html .= '<tr>';
        $html .= '<td>'.$no.'</td>';
        $html .= '<td>'.$row2["material_no"].'</td>';
        $html .= '<td>'.$row2["material_desc"].'</td>';
        $html .= '<td>'.$row2["back_no"].'</td>';
        $html .= '<td>'.$row2["T3"].'</td>';
        $html .= '<td>'.$row2["T7"].'</td>';
        $html .= '<td>'.intval($row2["qty_dlv"]).'</td>';
        $html .= '<td>'.$row2["unit_soi"].'</td>';
        $html .= '<td>'.$row2["vendor_name"].'</td>';
        $html .= '</tr>';

        $no++;
        $counter++;
    }

    $html .= '</tbody></table><br><br>';
    $html .= '<input name="do_no"  type="hidden" id="do_no" value="'.$do_no.'">';
    $html .= '<input name="uid2"  type="hidden" id="uid2" value="'.$material_doc_gen.'">';
    $html .= '<input name="ship_to"  type="hidden" id="ship_to" value="'.$ship_to.'">';
    $html .= '<input name="date1"  type="hidden" id="date1" value="'.$dateF.'">';
    $html .= '<input name="date2"  type="hidden" id="date2" value="'.$dateT.'">';
    $html .= '<input name="ship_point"  type="hidden" id="ship_point" value="'.$ship_point.'">';
    $html .= '<input name="cancelDO_btn" id="cancelDO_btn" type="submit" class="btn btn-danger btn-sm" value="CLOSE">';
    $html .= '</form>';
    // Return the generated HTML
    echo $html;
} else {
    echo 'No data received.';
}
?>