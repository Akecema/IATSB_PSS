<?php
    $query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
    $result2 = mysqli_query($dbc,$query2) or die (mysqli_error($dbc));
    $res = mysqli_fetch_array($result2);
	
	$url = "material_master_list.php"; 
	
//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------	

//--------menu function ------------------------------

$query_function = "SELECT * FROM function_acc_detail WHERE staff_ID = '".sql_esc($res["staff_ID"])."'";
$result_function = mysqli_query($dbc,$query_function);   //run the query.
//$data_function = mysqli_fetch_array($result_function);   //how many records are there?  

//----------------------------------------------------

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

//CR status (In Progress)
$sta7 = "SELECT * from request_status WHERE status_id = '7'";
$sta_res7 = mysqli_query($dbc,$sta7);
$rst_sta7 = mysqli_fetch_array($sta_res7);

//CR status (Pending)
$sta8 = "SELECT * from request_status WHERE status_id = '8'";
$sta_res8 = mysqli_query($dbc,$sta8);
$rst_sta8 = mysqli_fetch_array($sta_res8);

//CR status (Completed)
$sta14 = "SELECT * from request_status WHERE status_id = '14'";
$sta_res14 = mysqli_query($dbc,$sta14);
$rst_sta14 = mysqli_fetch_array($sta_res14);

//CR status (Deleted)
$sta16 = "SELECT * from request_status WHERE status_id = '16'";
$sta_res16 = mysqli_query($dbc,$sta16);
$rst_sta16 = mysqli_fetch_array($sta_res16);

	?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta name="description" content="<?php $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
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

  </head>
  <body class="app sidebar-mini">
  <div class="modal fade" id="myNoteMat<?php echo $row2["id_hdr"]; ?>" tabindex="-100" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">        
      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Display Material Master</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
        <div class="modal-body">
                 
    <div class="content mt-12">
        <div class="card">
        <div class="card-header">
        <strong>Display Material Master</strong>
       </div>
   <?php

    $query_scan = "SELECT *,DATE_FORMAT(date_bom_create, '%d-%m-%Y') AS R2 FROM mat_master_header AS HD WHERE HD.id_hdr = '".sql_esc($row2["id_hdr"])."'";
    $result_scan = mysqli_query($dbc,$query_scan);
    $data_scan = mysqli_fetch_array($result_scan);     
   ?>



     <table class="table table-bordered">
       <tr bgcolor="#00A6A6">
         <td><div align="center">Item No.</div></td>
         <td><div align="center">Material No.</div></td>
         <td><div align="center">Material Description</div></td>
         <td><div align="center">Material Type</div></td>
         <td><div align="center">UoM</div></td>
         <td><div align="center">Plant</div></td>
         <td><div align="center">BOM</div></td>
         <td><div align="center">Date BOM Created</div></td>
       </tr>
       <tr bgcolor="#FFFFFF">
         <td height="35"><?php echo $no; ?></td>
         <td height="35"><?php echo $data_scan["material_no"]; ?></td>
         <td height="35"><?php echo $data_scan["material_desc"]; ?></td>
         <td><?php echo $data_scan["material_type"]; ?></td>
         <td><?php echo $data_scan["BUn"]; ?></td>
         <td><?php echo $data_scan["plant"]; ?></td>
         <td><?php echo $data_scan["bom"]; ?></td>
         <td><?php echo $data_scan["R2"]; ?></td>
       </tr>
    </table>
    
    <hr>

<?php
    
    $query_component = "SELECT *, DATE_FORMAT(valid_from, '%d-%m-%Y') AS R FROM mat_master_header AS h, mat_master_detail AS s WHERE h.id_hdr = s.id_hdr AND s.material = '".sql_esc($data_scan["material_no"])."' AND s.bom_status != 'N'";
    $result_component = mysqli_query($dbc,$query_component);
    
    ?>
            <table class="table table-bordered">
            <thead>
               <tr bgcolor="#D3D3D3">
                 <td><div align="center">Item No.</div></td>
                 <td><div align="center">Component</div></td>
                 <td><div align="center">Component Description</div></td>
                 <td><div align="center">Valid From</div></td>
                 <td><div align="center">SLoc</div></td>
                 <td><div align="center">IsLoc</div></td>
                 <td><div align="center">Mat. Type</div></td>
                 <td><div align="center">UoM</div></td>
                 <td><div align="center">Consumption</div></td>
               </tr>
               </thead>
               <tbody>
			<?php
            
            $counter = 1;
            $i = 1;
            $no2 = 1;
             
            while($row = mysqli_fetch_array($result_component))
            {  

            ?>
              
               <tr>
                 <td><?php echo $no2; ?></td>
                 <td><?php echo $row["bill_component"];   ?></td>
                 <td><?php echo $row["material_desc_c"];   ?></td>
                 <td><?php echo $row["R"];   ?></td>
                 <td><?php echo $row["sloc"];   ?></td>
                 <td><?php echo $row["isloc"];   ?></td>
                 <td><?php echo $row["material_type"];   ?></td>
                 <td><?php echo $row["comp_unit"];   ?></td>
                 <td><?php echo $row["consumption"];   ?></td> 
                 <input name="id_dtl[<?php echo $i; ?>]" type="hidden" value="<?php echo $row["id_dtl"]; ?>">
                 <input name="id_hdr" type="hidden" value="<?php echo $id_hdr; ?>">
               </tr>
		<?php
        
        $i++;
        $no++;
        $no2++;		 
        } // end while loop
        
        ?>
        </tbody>
           </table> 

                    
       </div> <!-- card -->
       </div><!-- /# card -->
       <br />
              <div class="modal-footer">  
               <button type="button" class="btn btn-success" data-dismiss="modal">CLOSE</button>    
            <!--  <input type="submit" name="submit2" value="Close" class="btn btn-success" />-->
             </div>  
             
      
                  </div></div>
                  </div>
                  </div>
                  </div>
                  </div>
</body>
</html>