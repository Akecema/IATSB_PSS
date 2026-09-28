<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
require_once('tcpdf_barcodes_2d.php');
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $dateF = $_POST["date1"];
    $dateT = $_POST["date2"];
    $plant_code = $_POST["plant_code"]; 
    $work_center = $_POST["work_center"];
    $material_no = $_POST["material_no"]; 

    
    $where_sql = '';
        
    $ddF = substr($_POST["date1"],0,2);
    $mmF = substr($_POST["date1"],3,2);
    $yyF = substr($_POST["date1"],6,4);

    $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
    
    $ddF2 = substr($_POST["date2"],0,2);
    $mmF2 = substr($_POST["date2"],3,2);
    $yyF2 = substr($_POST["date2"],6,4);

    $date2_final = ($yyF2.'-'.$mmF2.'-'.$ddF2);
        
                    
    //1. Plant Code
    if (($plant_code == "") || ($plant_code == "NULL")){ 
        $wheresql_01 = ""; }
    else {
        $wheresql_01 = " AND plant_code = '$plant_code'"; }  	
    
    // 2. dateF
    if ($dateF == "0000-00-00" ){
        $wheresql_02 = ""; }
    else {
        $wheresql_02 = " AND (date_posting >= '$date1_final')"; }      
                                    
        
    //3. DateT
    if ($dateT == "0000-00-00" ){
        $wheresql_03 = ""; }
    else {
        $wheresql_03 = " AND (date_posting <= '$date2_final')"; }
        
        
    //4. Work Center
    if ($work_center == "NULL" ){
        $wheresql_04 = ""; }
    else {
        $wheresql_04 = " AND work_center = '$work_center'"; }

    //5. Part Number
    if ($material_no == "NULL"){ 
        $wheresql_05 = ""; }
    else {
        $wheresql_05 = " AND material_no = '$material_no'"; }  	
        
    $where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;

    // Create table with fetched data
    $html = '<table class="table table-bordered">';
    $html .= '<thead><tr>';
    $html .= '<th>No.</th>';
    $html .= '<th>Model</th>';
    $html .= '<th>Back No.</th>';
    $html .= '<th>Part Number</th>';
    $html .= '<th>BF Doc. No.</th>';
    $html .= '<th>Planned Order No.</th>';
    $html .= '<th>Posting Date</th>';
    $html .= '<th>Posting Time</th>';
    $html .= '<th>Line</th>';
    $html .= '<th>Shift</th>';
    $html .= '<th>Quantity</th>';
    $html .= '<th>Status</th>';
    $html .= '</tr></thead><tbody>';

    $counter = 1;
    $queryu2 = "SELECT *, DATE_FORMAT(date_posting, '%d-%m-%Y') as RT FROM pps_detail_trn_fg_ng WHERE bflush_no = ? AND status_pps = ? $where_sql ORDER BY bflush_no ASC";
    $stmt = $dbc->prepare($queryu2);
    $stmt->bind_param("ss", $id, $rst_sta7["status_desc"]);
    $stmt->execute();
    $rs2 = $stmt->get_result();
    
    while ($row2 = $rs2->fetch_array(MYSQLI_ASSOC)) {
        $shift_dsA = $row2["shift_posting"] == "D/S" ? "Day" : ($row2["shift_posting"] == "N/S" ? "Night" : "NA");
    
        // Fetch model and work center details
        $query_Mod = $dbc->prepare("SELECT * FROM model_detail_tbl WHERE model_code = ? AND status_model = 'Y' ORDER BY id_model ASC");
        $query_Mod->bind_param("s", $row2["model_code"]);
        $query_Mod->execute();
        $result_Mod = $query_Mod->get_result();
        $row_Mod = $result_Mod->fetch_array(MYSQLI_ASSOC);
    
        $query_Mod2A = $dbc->prepare("SELECT * FROM work_center_detail WHERE id_work = ? AND status_wc = 'Y' ORDER BY id ASC");
        $query_Mod2A->bind_param("s", $row2["work_center"]);
        $query_Mod2A->execute();
        $result_Mod2A = $query_Mod2A->get_result();
        $row_Mod2A = $result_Mod2A->fetch_array(MYSQLI_ASSOC);
        
        if($row_Mod2A["wc_desc2"] == "")
        {
            $model_name2A = $row_Mod2A["id_work"];
        }else{
            
            $model_name2A = $row_Mod2A["wc_desc2"]; 
        }

        $html .= '<tr>';
        $html .= '<td>' . $counter++ . '</td>';
        $html .= '<td>' . htmlspecialchars($row_Mod["model_desc"] ?? 'N/A') . '</td>';
        $html .= '<td>' . htmlspecialchars($row2["back_no"]) . '</td>';
        $html .= '<td>' . htmlspecialchars($row2["material_no"]) . '</td>';
        $html .= '<td style="color:#0000CC">' . htmlspecialchars($row2["bflush_no"]) . '</td>';
        $html .= '<td>' . htmlspecialchars($row2["plan_no"]) . '</td>';
        $html .= '<td>' . htmlspecialchars($row2["RT"]) . '</td>';
        $html .= '<td>' . htmlspecialchars($row2["time_posting"]) . '</td>';
        $html .= '<td>' . htmlspecialchars($model_name2A) . '</td>';
        $html .= '<td>' . htmlspecialchars($shift_dsA) . '</td>';
        $html .= '<td>' . intval($row2["qty_NG"]) . '</td>';
        $html .= '<td>NG</td>';
        $html .= '</tr>';
    }
    
    $html .= '</tbody></table>';
    
    // Return the generated HTML
    echo $html;
    
    // Close statements
    $query_Mod->close();
    $query_Mod2A->close();
    $stmt->close();
} else {
    echo 'No details found';
}
?>