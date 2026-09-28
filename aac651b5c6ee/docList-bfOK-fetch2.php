<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

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

//CR status (Transfer GI)
$sta27 = "SELECT * from request_status WHERE status_id = '27'";
$sta_res27 = mysqli_query($dbc,$sta27);
$rst_sta27 = mysqli_fetch_array($sta_res27);



if($_POST['action'] == 'fetch_bfOK')
{
 
    $columns = array('plant_code', 'bflush_no', 'work_no','material_no');

        //Get value

          $dateF = $_POST["date1"];
		  $dateT = $_POST["date2"];
		  $material_no = $_POST["material_no"]; 
		  $work_center = $_POST["work_center"]; 
		  $plant_code = $_POST["plant_code"]; 				
				
	     

//-------Count all results------------------------//
			
$where_sql = '';
				 
  $ddF = substr($_POST["date1"],0,2);
  $mmF = substr($_POST["date1"],3,2);
  $yyF = substr($_POST["date1"],6,4);

  $date1_final = ($yyF.'-'.$mmF.'-'.$ddF);
     
  $ddF2 = substr($_POST["date2"],0,2);
  $mmF2 = substr($_POST["date2"],3,2); 
  $yyF2 = substr($_POST["date2"],6,4);

  $date2_final = ($yyF2.'-'.$mmF2.'-'.$ddF2);

    
// 1. dateF
 if ($dateF == "0000-00-00" ){
     $wheresql_01 = ""; }
 else {
     $wheresql_01 = " AND (date_posting >= '".sql_esc($date1_final)."')"; }      
                                 
     
//2. DateT
 if ($dateT == "0000-00-00" ){
     $wheresql_02 = ""; }
 else {
    $wheresql_02 = " AND (date_posting <= '".sql_esc($date2_final)."')"; }


//3. Plant Code
if (($plant_code == "") || ($plant_code == "NULL")){ 

$wheresql_03 = ""; }
else {
$wheresql_03 = " AND plant_code = '".sql_esc($plant_code)."'"; 

}

//4. work_center
if ($work_center == "NULL" ){
    $wheresql_04 = ""; }
else {
    $wheresql_04 = " AND work_center = '".sql_esc($work_center)."'"; }

                 
//5. Part Number
if ($material_no == "NULL"){ 
    $wheresql_05 = ""; }
else {
    $wheresql_05 = " AND material_no = '".sql_esc($material_no)."'"; }  	 
   
 
 $where_sql =  $wheresql_01 .$wheresql_02 .$wheresql_03 .$wheresql_04 .$wheresql_05;


//********** END CONDITION **************

$query = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') as T, DATE_FORMAT(date_posting,'%d-%m-%Y') as R, DATE_FORMAT(date_cancel,'%d-%m-%Y') as T7 FROM pps_detail_trn_fg_ok WHERE status_pps != '".sql_esc($rst_sta6["status_desc"])."' AND status = 'Y'" .$where_sql;
$result = $dbc->query($query) or die(mysqli_error($dbc));
$totalData2 = $result->num_rows;

			
  
$query = "SELECT *, DATE_FORMAT(date_plan,'%d-%m-%Y') as T, DATE_FORMAT(date_posting,'%d-%m-%Y') as R, DATE_FORMAT(date_cancel,'%d-%m-%Y') as T7 FROM pps_detail_trn_fg_ok WHERE status_pps != '".sql_esc($rst_sta6["status_desc"])."' AND status = 'Y'" .$where_sql;
$result = $dbc->query($query) or die(mysqli_error($dbc));
$totalData = $result->num_rows;

 if(isset($_POST["search"]["value"]))
    {
       
        $query .= ' AND (bflush_no LIKE "%'.sql_esc($_POST["search"]["value"]).'%"';
        $query .= ' OR plant_code LIKE "%'.sql_esc($_POST["search"]["value"]).'%"'; 
        $query .= ' OR plan_no LIKE "%'.sql_esc($_POST["search"]["value"]).'%"'; 
        $query .= ' OR material_no LIKE "%'.sql_esc($_POST["search"]["value"]).'%"'; 
        $query .= ' OR model_code LIKE "%'.sql_esc($_POST["search"]["value"]).'%" )'; 
       /*   $query .= ' OR back_no LIKE "%'.$_POST["search"]["value"].'%" )';  */
      	
    }




    if(!empty($_POST["order"])){

        $query .= ' ORDER BY '.sql_num($_POST['order']['0']['column']).' '.sql_dir($_POST['order']['0']['dir']).' ';
        
   } else {
        $query .= ' ORDER BY bflush_no ASC';
   }
   
// $query = '';

   if($_POST["length"] != -1){
      
       
       $query .= ' LIMIT ' . sql_num($_POST['start']) . ', ' . sql_num($_POST['length']);
   }	


    $result = $dbc->query($query) or die(mysqli_error($dbc));
    $records ='';

    if($result->num_rows > 0) {


        $totalFiltered = $result->num_rows;


            $stmt = $dbc->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();	  

            
            $stmtTotal = $dbc->prepare($query);
            $stmtTotal->execute();
            $allResult = $stmtTotal->get_result();
            $allRecords = $allResult->num_rows; 
            
             $displayRecords = $result->num_rows; // dispaly perpage 
            
            
            $records = array();	        
   

//$count = 1;

$count = $_POST['start'] + 1;


    while ($row= $result->fetch_assoc())		
    {
        //-----checking planned order Qty is completed --------//
	 
	 $tot_BFOK = 0.000;
	 
	 $query_chk_bfOK = "SELECT * FROM pps_detail_trn_fg_ok WHERE plan_no = '".sql_esc($row["plan_no"])."'";
	 $rs_chk_bfOK = mysqli_query($dbc,$query_chk_bfOK);
     
	 while($row_chk_bfOK = mysqli_fetch_array($rs_chk_bfOK))
	  {
		 $tot_BFOK =  ($tot_BFOK + $row_chk_bfOK["qty_actual"]);
		  
	  }
	 
	 
	  if($tot_BFOK > ($row["qty_plan"]))
	  {
	    $status_new = "COMPLETED";
		$msg_sta =  '<span class="badge badge-pill badge-success">'.$status_new.'</span>'; 	
	
	  }elseif($tot_BFOK == ($row["qty_plan"]))
	  {
	    $status_new = "COMPLETED";
		$msg_sta =  '<span class="badge badge-pill badge-success">'.$status_new.'</span>'; 	
	
	  }elseif($row["status_pps"] == $rst_sta7["status_desc"])
	   {
	    $status_new = "IN PROGRESS";
		$msg_sta =  '<span class="badge badge-pill badge-warning">'.$status_new.'</span>';  
	   
	   }elseif($row["status_pps"] == $rst_sta13["status_desc"])
	   {
		   
		 $status_new = "CLOSED";
		 $msg_sta =  '<span class="badge badge-pill badge-danger">'.$status_new.'</span>';    
		   
		   
	   }elseif($row["status_pps"] == $rst_sta["status_desc"])
	   {
		   
		$status_new = "NEW";
		$msg_sta =  '<span class="badge badge-pill badge-pill">'.$status_new.'</span>';  
		
	   }else{
		   
		   
		   
	   }
	
   
	   //-----shift-----
	   
	   if($row["shift_posting"] == "D/S")
	   {
		   $shift_ds = "Day";
	   }elseif($row["shift_posting"] == "N/S")
	   {
		 $shift_ds = "Night";
	   }else{
		   
		   $shift_ds = "NA"; 
	   }
	   
	     //-----user canccellation-----------
		 
		 $query_u_can = "SELECT * FROM user_detail WHERE username = '".sql_esc($row["user_cancel"])."'"; 
		 $rs_u_can = mysqli_query($dbc,$query_u_can);   //run the query.
		 $data_u_can = mysqli_fetch_array($rs_u_can);
	   
	   
	    //-----get data GR detail -------
	   
	   $query_gr_scan = "SELECT * FROM  scan_gr_trn_fg_ok WHERE bflush_no_ok = '".sql_esc($row["bflush_no"])."'";
	   $result_gr_scan =  mysqli_query($dbc,$query_gr_scan); 
       $row_gr_scan = mysqli_fetch_array($result_gr_scan);	 


       if($row["date_cancel"] != '0000-00-00 00:00:00')         
       { 
           $dt_can = $row["T7"]; 
       
       }else{
           
           $dt_can = ''; 

       } 
	   
    

        $sub_array = array();
        $sub_array[] = $count;
        $sub_array[] = $row["model_code"];
        $sub_array[] = $row["material_no"];      
        $sub_array[] = $row["plan_no"];  
        $sub_array[] = $row["T"];
        $sub_array[] = $row["bflush_no"];
        $sub_array[] = $row["R"];
        $sub_array[] = $row["time_posting"];
        $sub_array[] = $row["work_center"];
        $sub_array[] = $shift_ds;
        $sub_array[] = intval($row["qty_actual"]);
        $sub_array[] = $msg_sta;
        $sub_array[] = $row_gr_scan["doc_gra"];       
        $sub_array[] = $row["bflush_no_ref"];
        $sub_array[] = $dt_can;
        $sub_array[] = $row["user_cancel"].' '.$data_u_can["user_fullname"];


       
        $records[] = $sub_array;

       $count++;
     

        
		} // while loop


    }else{

        $query = "SELECT * FROM pps_detail_trn_fg_ok WHERE status_pps != '".sql_esc($rst_sta6["status_desc"])."' AND status = 'Y' ORDER BY bflush_no ASC ";
       

        $totalFiltered = $result->num_rows;

    } // end if

        function get_all_data($dbc)
        {
            $query = "SELECT * FROM pps_detail_trn_fg_ok WHERE status = 'Y' ORDER BY bflush_no ASC ";
            $result = mysqli_query($dbc, $query);
            return mysqli_num_rows($result);
        }
    
     
          /*   $output = array(
                "draw"	=>	intval($_POST["draw"]),			
                "iTotalRecords"	=> 	$totalFiltered,
                "iTotalDisplayRecords"	=> $totalData2,
                "data"	=> 	$records
            ); */


            $output = array(
                "draw"	=>	intval($_POST["draw"]),			
                "iTotalRecords"	=> 	$totalFiltered,
                "iTotalDisplayRecords"	=> $totalData2,
                "data"	=> 	$records
            );
            
    
        echo json_encode($output);
        

    } // end if




