<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
ini_set("display_errors", 1);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';


$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));
$fmt_curr_date = (date("d-m-Y"));
$fmt_curr_time = (date("H:i:s"));
$pick_curr_time = (date("H:i a"));
$yearSkrg = (date("Y"));

$drun = substr($fmt_curr_date,0,2);
$mrun = substr($fmt_curr_date,3,2);
$yrun = substr($fmt_curr_date,8,2);

$date_run = ($drun.$mrun.$yrun);

set_time_limit(0);
 //CR status (New)
 $sta = "SELECT * from request_status WHERE status_id = '1'";
 $sta_res = mysqli_query($dbc,$sta);
 $rst_sta = mysqli_fetch_array($sta_res);

 //CR status (Approved)
 $sta3 = "SELECT * from request_status WHERE status_id = '3'";
 $sta_res3 = mysqli_query($dbc,$sta3);
 $rst_sta3 = mysqli_fetch_array($sta_res3);
 
 
 //CR status (Draft)
 $sta6 = "SELECT * from request_status WHERE status_id = '6'";
 $sta_res6 = mysqli_query($dbc,$sta6);
 $rst_sta6 = mysqli_fetch_array($sta_res6);
 
 //CR status (In Progress)
 $sta7 = "SELECT * from request_status WHERE status_id = '7'";
 $sta_res7 = mysqli_query($dbc,$sta7);
 $rst_sta7 = mysqli_fetch_array($sta_res7);

//https://phppot.com/php/import-excel-file-into-mysql-database-using-php/

require_once('../excel-reader/php-excel-reader/excel_reader2.php');
require_once('../excel-reader/SpreadsheetReader.php');


$mesej2 = "";
$message = "";

if(isset($_POST['submitPDIO']))
{    
   
  
  $cust_code = $_POST['cust_code'];
  $ship_point = $_POST['ship_point'];
  $checkA = $_POST['checkA'];



  // check for a upload file
 if($_FILES['upload']['size'] == 0 || empty($_FILES['upload']['tmp_name']))
 { 

 $upload = FALSE;
 $message = '<span class="badge badge-pill badge-danger"> Please select Upload File!</span>';
 }	 


  //----get ship point extract string -----
$plant_dlv = substr($ship_point,0,4); 

  $allowedFileType = array('application/vnd.ms-excel','text/xls,text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

  if(in_array($_FILES["upload"]["type"],$allowedFileType))
  {

    // Prepare the data
    $fileName = mysqli_real_escape_string($dbc, trim($_FILES['upload']['name']));
    $fileSize = mysqli_real_escape_string($dbc, $_FILES['upload']['size']);
    $fileType = mysqli_real_escape_string($dbc, $_FILES['upload']['type']);
    // Check duplicate filename
    $sqlCheckFile = "SELECT 1 FROM ftp_ups_pdio WHERE file_name = ? LIMIT 1";
    $stmtCheckFile = $dbc->prepare($sqlCheckFile);
    $stmtCheckFile->bind_param("s", $fileName);
    $stmtCheckFile->execute();

    $result = $stmtCheckFile->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Upload failed! File name already exists.');
                window.history.back();
              </script>";
        exit;
    }
 
    $stmtCheckFile->close();
    $tempPath = $_FILES['upload']['tmp_name'];
    $Reader = new SpreadsheetReader($tempPath);

    $sheetCount = count($Reader->sheets());

    $duplicatePDIO = array();

    for($i=0;$i<$sheetCount;$i++)
    {
        $Reader->ChangeSheet($i);

        foreach ($Reader as $index => $Row)
        {
            if (($index === 0) || ($index === 1) || ($index === 2) || ($index === 3)) {
                continue;
            }

            $pdio_no = trim($Row[0] ?? '');

            if($pdio_no == '')
                continue;

            $sqlPDIO = "SELECT 1 FROM dlv_upload_pdio WHERE pdio_no = ? LIMIT 1";
            $stmtPDIO = $dbc->prepare($sqlPDIO);
            $stmtPDIO->bind_param("s",$pdio_no);
            $stmtPDIO->execute();
            $stmtPDIO->store_result();

            if($stmtPDIO->num_rows > 0){
                $duplicatePDIO[] = $pdio_no;
            }

            $stmtPDIO->close();
        }
    }
    if(!empty($duplicatePDIO))
    {
      $duplicatePDIO = array_unique($duplicatePDIO);

      echo "<script>
              alert('Upload failed! The following PDIO already exist:\\n\\n" .
              implode("\\n", $duplicatePDIO) .
              "');
              window.history.back();
            </script>";
      exit;
    }
 
    $targetPath = 'PDIO_upld/'.$_FILES['upload']['name'];
    move_uploaded_file($_FILES['upload']['tmp_name'], $targetPath);
    //$datePlan = '0000-00-00'; // Adjust this if you have a default or intended value
 
    $query_ftp = "INSERT INTO ftp_ups_pdio(upload_id,id_file,file_name,file_size,file_type,date_pdio,user_upload,date_upload,user_update,date_update,comp_code,cust_code,plant_code) VALUES('','','".sql_esc($fileName)."','".sql_esc($fileSize)."','".sql_esc($fileType)."','','".sql_esc($username)."',NOW(),'','','2300','".sql_esc($cust_code)."','".sql_esc($plant_dlv)."')";
    $result_ftp = mysqli_query($dbc,$query_ftp);   

$uid3 = mysqli_insert_id($dbc);  //upload ID
$sta_cust = 'Y';

$query_update2 = "UPDATE ftp_ups_pdio SET id_file = '".sql_esc($uid3)."' WHERE upload_id = '".sql_esc($uid3)."'";
$result_update2 = mysqli_query($dbc,$query_update2);  

 //-----check customer detail ---------
 $query_info_cust = "SELECT * FROM cust_detail WHERE id_cust =? AND status_cust =?";
 $rs_info_cust = $dbc->prepare($query_info_cust); 
 $rs_info_cust->bind_param("ss", $cust_code,$sta_cust);
 $rs_info_cust->execute();
 $result2_info_cust = $rs_info_cust->get_result(); // get the mysqli result
 $data_info_cust = $result2_info_cust->fetch_assoc(); // fetch data   



$Reader = new SpreadsheetReader($targetPath);
				
		$sheetCount = count($Reader->sheets());

        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);
            
            //foreach($Reader as $Row)
            foreach ($Reader as $index => $Row) 
            {
                //skip 1st row (header)
                if (($index === 0) || ($index === 1) || ($index === 2) || ($index === 3)) {
                    continue;
                }



                $pdio_no = "";
                if(isset($Row[0])) {
                    $pdio_no = mysqli_real_escape_string($dbc,$Row[0]);
                }
                
                $order_no = "";
                if(isset($Row[1])) {
                    $order_no = mysqli_real_escape_string($dbc,$Row[1]);
                }
                        
                $dlv_category = "";
                if(isset($Row[6])) {
                    $dlv_category = mysqli_real_escape_string($dbc,$Row[6]);
                }
                
                $trip_no = "";
                if(isset($Row[7])) {
                    $trip_no = mysqli_real_escape_string($dbc,$Row[7]);
                }

                $line_no = "";
                if(isset($Row[8])) {
                    $line_no = mysqli_real_escape_string($dbc,$Row[8]);
                }

                $prod_date = "";
                if(isset($Row[9])) {
                  $raw = trim($Row[9]);

                  // d/m/Y
                  $dp = DateTime::createFromFormat('d/m/Y', $raw);
                  if ($dp && $dp->format('d/m/Y') === $raw) {
                      $prod_date = $dp->format('Y-m-d');
                  }

                  // m/d/Y (fallback)
                  if ($prod_date === null) {
                      $dp = DateTime::createFromFormat('m/d/Y', $raw);
                      if ($dp && $dp->format('m/d/Y') === $raw) {
                          $prod_date = $dp->format('Y-m-d');
                      }
                  }
                }

                $date_dlv2 = "";
                if(isset($Row[10])) {
                  // $date_dlv2 = mysqli_real_escape_string($dbc,$Row[10]);
                  $raw2 = trim($Row[10]);

                  // d/m/Y H:i
                  $dp = DateTime::createFromFormat('d/m/Y H:i', $raw2);
                  if ($dp && $dp->format('d/m/Y H:i') === $raw2) {
                      $date_dlv2 = $dp->format('Y-m-d H:i:s');
                  }

                  // m/d/Y H:i (fallback)
                  if ($date_dlv2 === null) {
                      $dp = DateTime::createFromFormat('m/d/Y H:i', $raw2);
                      if ($dp && $dp->format('m/d/Y H:i') === $raw2) {
                          $date_dlv2 = $dp->format('Y-m-d H:i:s');
                      }
                  }
                }

                $cycle_pdio = "";
                if(isset($Row[11])) {
                    $cycle_pdio = mysqli_real_escape_string($dbc,$Row[11]);
                }


                $back_no = "";
                if(isset($Row[12])) {
                    $back_no = mysqli_real_escape_string($dbc,$Row[12]);
                }


                $material_no = "";
                if(isset($Row[13])) {
                    $material_no = mysqli_real_escape_string($dbc,$Row[13]);
                }


                $material_desc = "";
                if(isset($Row[14])) {
                    $material_desc = mysqli_real_escape_string($dbc,$Row[14]);
                }


                $pdio_qty = "0.000";
                if(isset($Row[16])) {
                    $pdio_qty = mysqli_real_escape_string($dbc,$Row[16]);
                }

              
                


                if(($Row[0] != "") || ($Row[1] != "") || ($Row[6] != "") || ($Row[7] != "") || ($Row[8] != "") || ($Row[11] != "") || ($Row[12] != "") || ($Row[13] != "") || ($Row[14] != ""))
                {
/* 
                  $mesej2 = "<script language='JavaScript'>alert('Data error.');window.location='ups_pdio_sgchoh.php';</script>";


                }else{ */

                $sta_baru = 'New';

                  $rinsert = "INSERT INTO dlv_upload_pdio(pdio_no,order_no,dlv_category,trip_no,line_no,prod_date,dlv_date,cycle_pdio,back_no,material_no,material_desc,pdio_qty,created_by,date_create,status_pdio,plant_code,upload_id,file_name,cust_code) 
                              VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                  $rinsert= $dbc->prepare($rinsert);
                  $rinsert->bind_param("sssssssssssssssssss", $pdio_no, $order_no, $dlv_category, $trip_no, $line_no, $prod_date, $date_dlv2, $cycle_pdio, $back_no,$material_no, $material_desc,$pdio_qty,$username,$currentdate,$sta_baru,$plant_dlv,$uid3,$fileName,$cust_code);
                  $rinsert->execute();   
                 

                }

              } // foreach


            } // for $i


 //-------------------------------------------------------------------------------------

 $query_all = "SELECT TB1.*,TB2.* FROM dlv_upload_pdio AS TB1, table_material_itsb AS TB2 
 WHERE TB1.upload_id = '".sql_esc($uid3)."'
 AND (TB1.material_no = TB2.material_cust_no OR TB1.material_no = TB2.material_no)
 AND TB2.status_BOM = 'Y' 
 AND TB2.plant_code = '3100'";
 $result_all = mysqli_query($dbc,$query_all);

while($data_all = mysqli_fetch_assoc($result_all)) {

  
 //------checking back nobetul------------//
  $cstr = $data_all["back_no"];
  $cstr2 = str_replace(' ','',$cstr);

 
 //------checking string date betul------------//
  
//  $dp= DateTime::createFromFormat("m/d/Y", $data_all['prod_date']);
//  $dpstr = $dp->format('Y-m-d');

//  $dp2= DateTime::createFromFormat("d/m/Y H:i", $data_all['dlv_date']);
//  $dpstr2 = $dp2->format('Y-m-d');  

  $yearSkrg = (date("Y"));
  $monthSkrg = (date("m"));

   $query_update2_V = "UPDATE dlv_upload_pdio SET material_no_sap = '".sql_esc($data_all["material_no"])."',
    material_desc = '".sql_esc($data_all["material_desc"])."', uom_pdio = '".sql_esc($data_all["BUn"])."',
     cust_name = '".sql_esc($data_info_cust["cust_desc"])."', file_name = '".sql_esc($fileName)."',
      back_no = '".sql_esc($cstr2)."', status_pdio = 'Draft', yr_plan = '".sql_esc($yearSkrg)."', mth_plan = '".sql_esc($monthSkrg)."' 
       WHERE upload_id = '".sql_esc($uid3)."' AND id = '".sql_esc($data_all["id"])."' ";
   $result_update2_V = mysqli_query($dbc,$query_update2_V); 


 
 }


//-------------------------checking duplicate data upload -----------------------------

$query_check_dup = "SELECT TB3.*, TB4.* FROM dlv_pdio_generate AS TB3
LEFT JOIN dlv_upload_pdio AS TB4 ON TB3.pdio_no = TB4.pdio_no
AND TB3.order_no = TB4.order_no
AND TB3.material_no_cust = TB4.material_no
AND TB3.prod_date = TB4.prod_date
AND TB3.cycle_pdio = TB4.cycle_pdio
AND TB3.trip_no = TB4.trip_no
AND TB3.line_no = TB4.line_no
AND TB3.dlv_category = TB4.dlv_category
AND TB3.upload_id != TB4.upload_id
WHERE TB4.upload_id = '".sql_esc($uid3)."' AND TB3.plant_code = '3100' ORDER BY TB4.id ASC";


/*  $query_check_dup = "SELECT TB4.* FROM dlv_upload_pdio TB4
WHERE EXISTS (SELECT * FROM dlv_pdio_generate TB3
              WHERE TB3.pdio_no = TB4.pdio_no
AND TB3.order_no = TB4.order_no
AND TB3.material_no_cust = TB4.material_no
AND TB3.prod_date = TB4.prod_date
AND TB3.cycle_pdio = TB4.cycle_pdio
AND TB3.trip_no = TB4.trip_no
AND TB3.line_no = TB4.line_no
AND TB3.dlv_category = TB4.dlv_category
AND TB3.upload_id != TB4.upload_id)
AND TB4.upload_id = '".$uid3."'"; */

$result_check_dup = mysqli_query($dbc,$query_check_dup);

while($data_check_dup = mysqli_fetch_assoc($result_check_dup)) {

  $del_dup_row = "DELETE FROM dlv_upload_pdio WHERE id = '".sql_esc($data_check_dup['id'])."'  ";
  $result_dup_row = mysqli_query($dbc,$del_dup_row );


}


//----------------------------------end    



 if($checkA == "")
{

 include 'gen_mat_doc_PDIO.php';

 $query_congen = "SELECT TB3.* FROM dlv_upload_pdio AS TB3
 WHERE TB3.upload_id = '".sql_esc($uid3)."'
 AND TB3.plant_code = '3100'";
 $result_congen = mysqli_query($dbc,$query_congen);

while($data_congen = mysqli_fetch_assoc($result_congen)) {

//-------generate dlv pdio-------------

$query_generate = "INSERT INTO dlv_pdio_generate(id,id_gen,mat_doc,pdio_no,order_no,dlv_category,trip_no,line_no,prod_date,dlv_date,cycle_pdio,back_no,material_no,material_desc,pdio_qty,uom_pdio,created_by,date_create,update_by,date_update,status_upload,status_pdio,plant_code,upload_id,file_name,mth_plan,yr_plan,cust_code,cust_name,status_DO,material_no_cust) VALUES('','".sql_esc($data_congen['id'])."','".sql_esc($ref)."','".sql_esc($data_congen['pdio_no'])."','".sql_esc($data_congen['order_no'])."','".sql_esc($data_congen['dlv_category'])."','".sql_esc($data_congen['trip_no'])."','".sql_esc($data_congen['line_no'])."','".sql_esc($data_congen['prod_date'])."','".sql_esc($data_congen['dlv_date'])."','".sql_esc($data_congen['cycle_pdio'])."','".sql_esc($data_congen['back_no'])."','".sql_esc($data_congen['material_no_sap'])."','".sql_esc($data_congen['material_desc'])."','".sql_esc($data_congen['pdio_qty'])."','".sql_esc($data_congen['uom_pdio'])."','".sql_esc($data_congen['created_by'])."','".sql_esc($data_congen['date_create'])."','".sql_esc($username)."',NOW(),'".sql_esc($rst_sta7["status_desc"])."','".sql_esc($rst_sta3["status_desc"])."','".sql_esc($data_congen['plant_code'])."','".sql_esc($data_congen['upload_id'])."','".sql_esc($data_congen['file_name'])."','".sql_esc($data_congen['mth_plan'])."','".sql_esc($data_congen['yr_plan'])."','".sql_esc($data_congen['cust_code'])."','".sql_esc($data_congen['cust_name'])."','".sql_esc($rst_sta["status_desc"])."','".sql_esc($data_congen['material_no'])."')";
$result_generate = mysqli_query($dbc,$query_generate);




}
include 'gen_mat_doc_PDIO_cls.php';


$query_update2_V2 = "UPDATE dlv_upload_pdio SET status_pdio = '".sql_esc($rst_sta3["status_desc"])."'  WHERE upload_id = '".sql_esc($uid3)."'  ";
$result_update2_V2 = mysqli_query($dbc,$query_update2_V2); 



  echo "<script>";
  echo "alert('File successfully uploaded.');";
  echo "window.location='ups_pdio_serendah.php'";
  echo "</script>";
  exit(); //quit the script
  


}else{  // ifelse checkA tick
 
 
 $ups_id = base64_encode($uid3);
 $ups_ship = base64_encode($plant_dlv);
 $ups_cust = base64_encode($cust_code);


    echo "<script>";
    echo "window.location='ups_pdio_serendahProc2.php?ship_point=$ups_ship&&cust_code=$ups_cust&&upload_id=$ups_id&&checkB=$checkA';";
    echo "</script>";
    exit(); //quit the script     


}//end checker
// 



  }


}else{

  echo "<script>"; 
  echo "window.location='ups_pdio_serendah.php'";
  echo "</script>";
  exit(); //quit the script
  

}


if(isset($_POST["ResetPDIO"])) 
{ // handle the form.

require_once('../include/config.php');   //connect to the db.

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
header('Location: ../index.php');
exit();
}

//-----------delete all data current screen-------------
$query_delete_scan = "DELETE FROM ftp_ups_pdio WHERE user_upload = '".sql_esc($username)."'";
$result_delete_scan = mysqli_query($dbc,$query_delete_scan);


//---------end delete ----------------------------------

}//end submit5  

?>