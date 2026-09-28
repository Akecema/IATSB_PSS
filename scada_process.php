<?php
ini_set("display_errors", 1);
include 'include/config.php';

date_default_timezone_set('Asia/Kuala_Lumpur');

$fmt_curr_date = (date("d-m-Y"));
$drun = substr($fmt_curr_date,0,2);
$mrun = substr($fmt_curr_date,3,2);
$yrun = substr($fmt_curr_date,8,2);

$date_run = ($drun.$mrun.$yrun);

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

//CR status (Draft)
$sta6 = "SELECT * from request_status WHERE status_id = '6'";
$sta_res6 = mysqli_query($dbc,$sta6);
$rst_sta6 = mysqli_fetch_array($sta_res6);

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

//CR status (Pending)
$sta8 = "SELECT * from request_status WHERE status_id = '8'";
$sta_res8 = mysqli_query($dbc,$sta8);
$rst_sta8 = mysqli_fetch_array($sta_res8);

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

// SCADA PATH

$scada_path = 'E:/Apache24/htdocs/PSS_IATSB/FromPortal2/DP/SCADA';

$archive_path = $scada_path . '/Archive';

// START WORKER

while (true) {

    $files = glob($scada_path . '/*.csv');


    // NO FILE

    if (empty($files)) {

        // Nothing to process

        sleep(1);

        continue;
    }


    // PROCESS EACH CSV
    foreach ($files as $file) {

        if (!file_exists($file)) {
            continue;
        }


        // FILE NAME

        $file1 = basename($file);

        // NG1909202501001.csv
        $filename = pathinfo(
            $file1,
            PATHINFO_FILENAME
        );


        // Remove NG
        $filename = substr(
            $filename,
            2
        );

        // FILE NAME PARTS

        $file_date2 = substr(
            $filename,
            0,
            8
        );

        $work_order = substr(
            $filename,
            8,
            2
        );

        $running_no = substr(
            $filename,
            10,
            3
        );

        // GENERATE PLAN NO

        $file_date = substr($file_date2, 0, 4) . substr($file_date2, -2);
        
        $plan_no = $file_date . $work_order;


        // GENERATE BFLUSH QQC NO

        $bflush_qqc_no = $file_date . $work_order . $running_no;

        //TIME POSTING
        $time_posting = date('H:i:s');

        // CSV LOGIC STARTS HERE

        if (($handle = fopen($file, "r")) !== false) {

            $i = 0;

            // DATABASE LOGIC
            $plant_code = '3100';

            $query_id = "SELECT * FROM run_count_itsb WHERE uid = '21'";
            $result_id = mysqli_query($dbc,$query_id);
            if ($result_id) 
            {
                $nrows = mysqli_num_rows($result_id);
                $row_id = mysqli_fetch_array($result_id);
                
                $dht = 00000; 
                $dht_OK = "221";
                $dg2 = 0;

                if($row_id["count_max"] <= 0)
                { 
            
                    $lastID = ($row_id["count_max"] + 1);
                    $dg = ($dht + ($lastID));
                }
                else
                {
                    $lastID = ($row_id["count_max"] + 1);
                    $dg =  $lastID;
                
                }
                $number = $dg; // Length of running no
                $number = sprintf('%03d', $number);  
                
                
                // $ref = ($dht_OK.($number));
                
                // $ref = (($row_id["start_ref"]).$dht_OK.$date_run.($number));
                $doc_dis = ('3100311'.($file_date).($number));
                $doc_disposal_no = $number;
                
            } // end if $result_id

            while (($data = fgetcsv($handle, 0, ",")) !== false) {
                $data[0] = preg_replace('/^\xEF\xBB\xBF/', '', $data[0]);

                $posting_date = DateTime::createFromFormat(
                    'dmY',
                    trim($data[0])
                )->format('Y-m-d');

                $shift = $data[1];
                $material_no = $data[2];
                $qty_NG = $data[3];
                $uom = $data[4];
                $sloc = $data[5];
                $proc_reject = 'Process (Production)';
                $defect  = $data[6];
                $reason_reject = 'Out of Standard';
                $user = $data[7];
                $remark = $data[8];
                $i++;
            }
            fclose($handle);

            // $query_max_b = "UPDATE run_count_itsb SET count_max = '".$number."', date_updated = NOW() WHERE uid = '13'";
	        // $result_max_b = mysqli_query($dbc,$query_max_b);

             // echo $plant_code . '-' . $material_type . '-' . $model . '-' . 
            // $category_mat . '-' . $posting_date . '-' . $sloc . '-' . $shift . '-' . $user . '-' . $material_no . '-' . $material_name . '-' . 
            // $qty_NG . '-' . $uom . '-' . $sloc . '-' . $section . '-' . $proc_reject . '-' . $typeofreject . '-' . $defect . '-' . $reason_reject . '-' . $user . '<br/>';

            //find material detail
            $query_mat = new PreparedSql("SELECT * FROM table_material_itsb WHERE material_no = ?", [$material_no]);
            $result_mat = db_query($dbc, $query_mat);
            $data_mat = mysqli_fetch_array($result_mat);
            if($data_mat['mat_type'] == '1'){
                $material_type = 'Z101';
            }elseif($data_mat['mat_type'] == '2'){
                $material_type = 'Z201';
            }elseif($data_mat['mat_type'] == '3'){
                $material_type = 'Z301';
            }elseif($data_mat['mat_type'] == '4'){
                $material_type = 'Z401';
            }
            
            $status_disposal = '';
            if(($material_type == "Z301") && ($data_mat["category_mat"] == "ASSY"))
            {
                $ploc = "W1RJ";  
            }elseif(($material_type == "Z301") && ($data_mat["category_mat"] == "STM"))
            {
                $ploc = "P1RJ";  
            }elseif(($material_type == "Z201")  && ($data_mat["category_mat"] == "ASSY"))
            {
                $ploc = "W1RJ";
            }elseif(($material_type == "Z201")  && ($data_mat["category_mat"] == "STM"))
            {
                $ploc = "P1RJ";
            }elseif(($material_type == "Z301")  && ($data_mat["category_mat"] == "BLK"))
            {
                $ploc = "B1RJ";
                
            }elseif(($material_type == "Z101")  && ($data_mat["category_mat"] == "BLK"))
            {
                $ploc = "B1RJ";
            }
            else{
                
                $ploc = "";
            }

            $category_mat = $data_mat['category_mat'];
            $material_name = $data_mat['material_desc'];
            $section = $data_mat['prod_line'];

            $query_usr = new PreparedSql("SELECT * FROM user_detail WHERE staff_ID = ?", [$user]);
            $result_usr = db_query($dbc, $query_usr);
            $data_usr = mysqli_fetch_array($result_usr);
            if($data_usr['department'] == '37' || $data_usr['department'] == '62'){
                $status_disposal = 'Pending Approve ASSY';

            }elseif($data_usr['department'] == '38' || $data_usr['department'] == '61'){
                $status_disposal = 'Pending Approve STM';
            }

            $query_md = new PreparedSql("SELECT * FROM model_detail_tbl WHERE id_model = ?", [$data_mat['model_code']]);
            $result_md = db_query($dbc, $query_md);
            $data_md = mysqli_fetch_array($result_md);
            $model = $data_md['model_code'];

            //find type of reject
            $query_tr = "SELECT * FROM type_defect_detail_prd WHERE defect_desc = '".sql_esc($defect)."'";
            $result_tr = mysqli_query($dbc,$query_tr);
            $data_tr = mysqli_fetch_array($result_tr);
            
            $query_trdesc = "SELECT * FROM type_defect_detail_prd WHERE defect_desc = '".sql_esc($defect)."'";
            $result_trdesc = mysqli_query($dbc,$query_trdesc);
            $data_trdesc = mysqli_fetch_array($result_trdesc);
            $typeofreject = $data_trdesc['id_type'];

            //----------- find cost center --------------
            $query_cs_cent = new PreparedSql("SELECT * FROM work_center_detail WHERE id_work = ?", [$section]);
            $result_cs_cent = db_query($dbc, $query_cs_cent); 
            $row_cs_cent = mysqli_fetch_array($result_cs_cent);

            $qty_plan = 0.000;


            $query_ins_dis2 = "INSERT INTO disposal_detail_prd_all(id_disposal,doc_dis,doc_disposal_no,bflush_hwork, bflush_rework,
            bflush_pending, bflush_qqc_no,plan_no,uid,material_no,material_desc,
            material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit, 
            comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,
            ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,
            qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,
            user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,
            remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,
            remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,
            date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,reject_source,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) 
            VALUES('','".sql_esc($doc_dis)."','".sql_esc($doc_disposal_no)."','','','','".sql_esc($bflush_qqc_no)."','".sql_esc($plan_no)."','','".sql_esc($material_no)."',
            '".sql_esc($material_name)."','".sql_esc($material_type)."','".sql_esc($model)."','".sql_esc($qty_plan)."','','','".sql_esc($qty_NG)."','','','',
            '".sql_esc($uom)."','".sql_esc($plant_code)."','".sql_esc($section)."','".sql_esc($shift)."','".sql_esc($posting_date)."','".sql_esc($user)."','".sql_esc($posting_date)."',
            '".sql_esc($time_posting)."','".sql_esc($status_disposal)."','".sql_esc($ploc)."','".sql_esc($sloc)."','','1','".sql_esc($typeofreject)."','".sql_esc($data_tr['id_defect'])."',
            '".sql_esc($reason_reject)."','".sql_esc($user)."','".sql_esc($posting_date)."','".sql_esc($time_posting)."','','','','','','','".sql_esc($user)."','".sql_esc($posting_date)."','".sql_esc($remark)."','PR','".sql_esc($user)."',NOW(),
            '','','','','','','','','','','','','','','','','','','','','".sql_esc($row_cs_cent["cost_center"])."','1','','','','',
            '".sql_esc($plant_code)."','".sql_esc($shift)."','".sql_esc($category_mat)."','BFNG','".sql_esc($data_mat["back_no"])."','',
            '','')";
            $result_ins_dis2 = mysqli_query($dbc,$query_ins_dis2);  

            $query_ins_dis = "INSERT INTO disposal_detail_prd_ng(id_disposal,doc_dis,doc_disposal_no,bflush_qqc_no,plan_no,uid,material_no,material_desc,
            material_type,model_code,qty_plan,qty_actual,qty_balance,qty_NG,qty_qc,qty_qc_ok,qty_qc_NG,UOM_unit, 
            comp_code,work_center,shift_day,date_plan,user_posting,date_posting,time_posting,status_disposal,ploc,
            ploc_prod_reject,ploc_qc_reject,proc_reject,type_reject,type_defect,reason_reject,user_reject,date_reject,time_reject,
            qty_wastage,type_wastage,reason_wastage,user_wastage,date_wastage,time_wastage,user_disposal,date_disposal,remarks,status_part,
            user_update,date_update,status_approved,approved_by,date_approved,remark_approved,status_approved2,approved_by2,date_approved2,
            remark_approved2,status_approved3,approved_by3,date_approved3,remark_approved3,status_approved4,approved_by4,date_approved4,
            remark_approved4,status_approved5,approved_by5,date_approved5,remark_approved5,cost_center,id_factory,disposal_no_ref,user_cancel,
            date_cancel,remark_cancel,plant_cd,shift_posting,stamp_ind,back_no,kanban_no,SAP_ref_doc,SAP_ref_doc_can) 
            VALUES('','".sql_esc($doc_dis)."','".sql_esc($doc_disposal_no)."','".sql_esc($bflush_qqc_no)."','".sql_esc($plan_no)."','','".sql_esc($material_no)."',
            '".sql_esc($material_name)."','".sql_esc($material_type)."','".sql_esc($model)."','".sql_esc($qty_plan)."','','','".sql_esc($qty_NG)."','','','',
            '".sql_esc($uom)."','".sql_esc($plant_code)."','".sql_esc($section)."','".sql_esc($shift)."','".sql_esc($posting_date)."','".sql_esc($user)."','".sql_esc($posting_date)."',
            '".sql_esc($time_posting)."','".sql_esc($status_disposal)."','".sql_esc($ploc)."','".sql_esc($sloc)."','','1','".sql_esc($typeofreject)."','".sql_esc($data_tr['id_defect'])."',
            '".sql_esc($reason_reject)."','".sql_esc($user)."','".sql_esc($posting_date)."','".sql_esc($time_posting)."','','','','','','','".sql_esc($user)."','".sql_esc($posting_date)."','".sql_esc($remark)."','PR','".sql_esc($user)."',NOW(),
            '','','','','','','','','','','','','','','','','','','','','".sql_esc($row_cs_cent["cost_center"])."','1','','','','',
            '".sql_esc($plant_code)."','".sql_esc($shift)."','".sql_esc($category_mat)."','".sql_esc($data_mat["back_no"])."','',
            '','')";
            $result_ins_dis = mysqli_query($dbc,$query_ins_dis);  
            if (!$result_ins_dis) {
                die("INSERT disposal_detail_prd_ng ERROR: " . mysqli_error($dbc) . 
                    "<br><br>SQL:<br>" . htmlspecialchars($query_ins_dis));
            }
           
            
            // ARCHIVE FILE

            $file1 = basename($file);

            $destination =
                $archive_path . '/' . $file1;


            // Avoid overwrite
            if (file_exists($destination)) {

                $info = pathinfo($file1);

                $destination =
                    $archive_path . '/' .
                    $info['filename'] .
                    '_' .
                    date('YmdHis') .
                    '.' .
                    $info['extension'];
            }


            rename($file, $destination);
        }
    }
    die();
    // WAIT 1 SECOND
    sleep(1);
}

?>