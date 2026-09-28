;<?php
session_start();
$username = $_SESSION['username'];
include '../include/config.php';


$buid = base64_decode($_GET["buid"]);
$uid = base64_decode($_GET["uid"]);

     // ---update status 

		$query_ftp = "UPDATE pps_detail_trn_fg_ok SET status_ftp_bflush = 'Y' WHERE bflush_no = '".sql_esc($buid)."'";
		$rst_query_ftp = mysqli_query($dbc,$query_ftp); //or die ("Error in query: $query_ftp"); 
		
				
		if($rst_query_ftp > 0)
		{
			
		 
  //----info print tag --------------
	 
  $query_p_tag = "SELECT * FROM pps_detail_trn_fg_ok AS A1 WHERE bflush_no = '".sql_esc($buid)."'";
  $rst_p_tag = mysqli_query($dbc,$query_p_tag);
  $data_p_tag = mysqli_fetch_array($rst_p_tag);	
  
   //------check status spare part in table_material_itsb
  
  $query_spare = "SELECT * FROM table_material_itsb WHERE material_no = '".sql_esc($data_p_tag["material_no"])."' AND status_BOM = 'Y' AND status_sp = 'Y'";
  $result_spare = mysqli_query($dbc,$query_spare);
  $data_spare = mysqli_fetch_array($result_spare);
  
			
			if($data_p_tag["stamp_ind"] == "STM")
			{
				if($data_p_tag["material_type"] == "Z301")
				{
				
				$buid =	base64_encode($buid);
		
				echo "<script>";
				//echo "alert('FTP Transferred to SAP.');";
				echo "window.open('detail_print_tag_bfOK_ind_stm.php?buid=$buid', '_blank');";
				echo "window.location='confirm_backflush_tran.php';"; 
				echo "</script>";
				exit(); //quit the script
					
				}elseif($data_p_tag["material_type"] == "Z201")
			    {
					
					
					 if($data_spare["status_sp"] == "Y")
				     {   
				 
				 
				$buid =	base64_encode($buid);
		
				echo "<script>";
				echo "window.open('detail_print_tag_bfOK_ind_stm3.php?buid=$buid', '_blank');";
				echo "window.location='confirm_backflush_tran.php';"; 
				echo "</script>";
				exit(); //quit the script
					
					
					
					 }else{
                
                
					
				$buid =	base64_encode($buid);
		
				echo "<script>";
				//echo "alert('FTP Transferred to SAP.');";
				echo "window.open('detail_print_tag_bfOK_ind_stm2.php?buid=$buid', '_blank');";
				echo "window.location='confirm_backflush_tran.php';"; 
				echo "</script>";
				exit(); //quit the script
				
					 } // data spare part
				
				}else{
					
				echo "<script>";
				echo "window.location='confirm_backflush_tran.php';"; 
				echo "</script>";
				exit(); //quit the script
				
				}
					
			}elseif($data_p_tag["stamp_ind"] == "ASSY")
			{		
		
		      if($data_spare["status_sp"] == "Y")
			{   
		
		        $buid =	base64_encode($buid);
		
				echo "<script>";
				echo "window.open('detail_print_tag_bfOK_ind_stm3.php?buid=$buid', '_blank');";
				echo "window.location='confirm_backflush_tran.php';"; 
				echo "</script>";
				exit(); //quit the script
					
		
		
		
		
			}else{
		
				$buid =	base64_encode($buid);
				
				echo "<script>";
				//echo "alert('FTP Transferred to SAP.');";
				echo "window.open('detail_print_tag_bfOK_ind.php?buid=$buid', '_blank');";
				echo "window.location='confirm_backflush_tran.php';"; 
				echo "</script>";
				exit(); //quit the script
				
				
			}//end data spare part
				
				
			}elseif($data_p_tag["stamp_ind"] == "BLK")
			{
			
			    if($data_p_tag["material_type"] == "Z301")
				{
			
			
			
			   $buid =	base64_encode($buid);
				
				echo "<script>";
				echo "window.open('detail_print_tag_bfOK_ind.php?buid=$buid', '_blank');";
				echo "window.location='confirm_backflush_tran.php';"; 
				echo "</script>";
				exit(); //quit the script
			
				}elseif($data_p_tag["material_type"] == "Z101")
			    {
				
				$buid =	base64_encode($buid);
				
				echo "<script>";
				echo "window.open('detail_print_tag_bfOK_ind_RM.php?buid=$buid', '_blank');";
				echo "window.location='confirm_backflush_tran.php';"; 
				echo "</script>";
				exit(); //quit the script
					
					
				// mat type BLK	
					
			    }else{
					 
					 
				 }
			
			
		    }else{
				
				
				echo "<script>";
				echo "alert('Error. Cannot Generate Tag');";
				echo "window.location='confirm_backflush_tran.php';"; 
				echo "</script>";
				exit(); //quit the script	
				
			}

		
	      } //end if($rst_query_ftp)
		
      
    
?>
