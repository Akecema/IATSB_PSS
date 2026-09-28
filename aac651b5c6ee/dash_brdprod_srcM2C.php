<?php
error_reporting(E_ALL &~ E_NOTICE &~ E_DEPRECATED);
session_start();
$username = $_SESSION['username'];
include '../include/config.php';
//include_once ('../classes/paginator.class2.php');
//require_once("../calendar/classes/tc_calendar.php");

$Cdate = date ("l, j F Y ");
$currentdate = (date("Y-m-d"));

set_time_limit(0);

// Check, if username session is NOT set then this page will jump to login page
if ((!isset($_SESSION['username'])) && ($_SESSION['lvl_id'] != "2")) {
header('Location: ../index.php');
exit();
}

//--------setup website page --------------------------
$query_setup = "SELECT * FROM sys_setup_maintain WHERE status_system = 'AC'";
$rs_setup = mysqli_query($dbc,$query_setup);   //run the query.
$num_setup = mysqli_num_rows($rs_setup);   //how many material are there?
$data_setup = mysqli_fetch_array($rs_setup);
//----------------------------------------------------

$query2 = "SELECT * FROM user_detail WHERE username = '".sql_esc($username)."'";
$result2 = mysqli_query($dbc,$query2) or die (mysqli_error());
$res = mysqli_fetch_array($result2);
	
$url = "dash_brdprod2.php"; 

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

//CR status (Transfer Posting)
$sta19 = "SELECT * from request_status WHERE status_id = '19'";
$sta_res19 = mysqli_query($dbc,$sta19);
$rst_sta19 = mysqli_fetch_array($sta_res19);


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="<?php echo $data_setup["tajuk_sys"]; ?>">
    <title><?php echo $data_setup["title_desc"]; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
   
    
    <!---------Chart-------->
    <?php include("../chart/fusioncharts.php"); ?>
	<!-- <link  rel="stylesheet" type="text/css" href="../chart/assets/css/style.css" />-->

  	<!-- You need to include the following JS file to render the chart.
  	When you make your own charts, make sure that the path to this JS file is correct.
  	Else, you will get JavaScript errors. -->

  	<script src="../chart/js/fusioncharts.js"></script>
    
    <SCRIPT LANGUAGE="JavaScript">
	function logout()
	{
	  if (confirm('Are you sure you want to logout?'))
		location.href = "../logout.php";	
	}
	</script>

	<?php
    
    $query_sql = "SELECT * FROM login_detail WHERE username = '".sql_esc($username)."' and status = 'AC'";
    $result_sql = mysqli_query($dbc,$query_sql);
    $info = mysqli_fetch_array($result_sql);
    
    
    if(($info['status_pass'] == 'N'))
    {
	?>
   
		<script type="text/javascript">
        jQuery(document).ready(function ($) {
        $.fancybox({
        href: "backjob_initial_pass.php?username=<?php echo $username; ?>",
        type: "iframe" // <-- whatever content image, inline, swf, etc
        });
        }); // ready
        </script>
        
        <?php
        }
        elseif(($info['expired_pass_date'] <=  $currentdate )) 
        {
        
        ?>
        
        <script type="text/javascript">
        jQuery(document).ready(function ($) {
        $.fancybox({
        href: "backjob_reminder_pass.php?username=<?php echo $username; ?>",
        type: "iframe" // <-- whatever content image, inline, swf, etc
        });
        }); // ready
        </script>
  
   
    <?php
	 }
	 ?>
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
   <!-- <header class="app-header"><a class="app-header__logo" href="index_admin.php"><font face="arial" >PSS ITSB</font></a>-->
      <!-- Sidebar toggle button--><!--<a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>-->
      <!-- Navbar Right Menu-->

<!--    </header>-->
    
    <?php   include "top_modal_menu.php";   ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    
    <?php   include "left_prod_menu.php";   ?>
    

    <!--<aside class="app-sidebar">
     
    </aside>-->
    
    <?php
	
	//$lvl_user = $_GET["lvl"];
	//current year
	$crtYr = date('Y');

	?>
    
     <?php
	//Graph Bar		
	$sYr3 = $_GET['selYr3'];
    $sMth3 = $_GET['selMth3'];

	if ($sYr3 == 'NULL') {
		$wheresql_01 = '';}
	else{
		$wheresql_01 = " AND YEAR(date_posting) = '$sYr3' ";}
		
	if ($sMth3 == 'NULL') {
		$wheresql_02 = '';}
	else{
		$wheresql_02 = " AND MONTH(date_posting) = '$sMth3' ";}
	
			
	$where_sql =  $wheresql_01 . $wheresql_02;
	
	?>
    
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
          <p>Dashboard of Production Support System (PSS)</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="dash_brdprod2.php">Dashboard</a></li>
        </ul>
      </div>
    
      <div class="row">
        <div class="col-md-12">
              <ul class="nav nav-tabs">
               <li class="nav-item"><a class="nav-link" href="dash_brdprod2.php">Production - OK Parts</a></li>
               <li class="nav-item"><a class="nav-link" href="dash_brdprod2B.php">Production - NG Parts</a></li>
               <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="dash_brdprod2C.php">Disposals</a></li>
              </ul> 
        
        
          <div class="tile">
            <h3 class="tile-title">Disposals</h3>
            
            	<!--Searching-->
                 <div class="col-md-12">
                  <div class="tile">
                    <!--<h3 class="tile-title">Subscribe</h3>-->
                    <div class="tile-body">
                      <form class="row" method="POST" action="">
                        <div class="form-group col-md-2">
                         <!--<label class="control-label">Year</label>-->
                          <select name="selYr" id="selYr" class="form-control">
                          <option value="NULL"> -Year -</option>
							<?php
							$qryYr = "SELECT  DISTINCT YEAR(date_posting) as planyear FROM disposal_detail_prd_all WHERE status_part='PR'";
							$resultYr = mysqli_query($dbc,$qryYr);
							
							while($rowYr = mysqli_fetch_array($resultYr)) 
							{ 
								$Pdate = date('Y', strtotime($rowYr['date_posting']))
								
							?>
                            <option value="<?php echo $rowYr["planyear"]; ?>" <?php if($rowYr["planyear"] == $crtYr) echo "selected"; ?>> <?php echo $rowYr["planyear"]; ?></option>
							<?php
							}
							?>   
                           </select> 
                        </div>
                        <div class="form-group col-md-2">
                        <!--<label class="control-label">Month</label>-->
                          <select name="selMth" id="selMth" class="form-control">
                          <option value="NULL"> - Month -</option>
							<?php
							$qryMth = "SELECT * FROM tbl_month ORDER BY id ASC";
							$resultMth = mysqli_query($dbc,$qryMth);
							
							while($rowMth = mysqli_fetch_array($resultMth)) 
							{ 
							?>
							<option value="<?php echo $rowMth["month_int"]; ?>"> <?php echo $rowMth["month_descp"]; ?></option>
							<?php
							}
							?>   
                          </select> 
                        </div>
                        <div class="form-group col-md-4 align-self-end">
                          <button name="Srch" class="btn btn-primary" type="submit">Search</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!--/n Searching-->
        
            
            	<?php
				
				//include "graph-modal.php";
				// Form the SQL query that returns the top 10 most populous countries
				$strQuery = "SELECT * FROM tbl_month  ORDER BY id ASC ";
			
				// Execute the query, or else return the error message.
				$result = $dbc->query($strQuery) or exit("Error code ({$dbc->errno}): {$dbc->error}");
				
				// If the query returns a valid response, prepare the JSON string
				if ($result) {
				
						// The `$arrData` array holds the chart attributes and data
						$arrData = array(
							"chart" => array(
							  //"caption"=> $row3['country_name'],
							    "subCaption"=> "Disposals by Monthly",
								"xAxisName"=> "Month",
								"yAxisName"=> "Quantity",
								"numberPrefix"=> "",
								"paletteColors"=> "#CC0000,#333333",
								"bgColor"=> "#ffffff",
								"showBorder"=> "0",
								"showCanvasBorder"=> "0",
								"usePlotGradientColor"=> "0",
								"plotBorderAlpha"=> "10",
								"legendBorderAlpha"=> "0",
								"legendBgAlpha"=> "0",
								"legendShadow"=> "0",
								"legendFontSize"=> "19",
								"showHoverEffect"=> "1",
								"valueFontColor"=> "#ffffff",
								"rotateValues"=> "1",
								"placeValuesInside"=> "1",
								"divlineColor"=> "#999999",
								"divLineDashed"=> "1",
								"divLineDashLen"=> "1",
								"divLineGapLen"=> "1",
								"canvasBgColor"=> "#ffffff",
								"captionFontSize"=> "14",
								"subcaptionFontSize"=> "14",
								"subcaptionFontBold"=> "0"
								)
							);
											
						$arrData["categories"] = array();
						$cat["category"] = array();
						$arrData["dataset"] = array();
						$data1["data"] = array();
						$data2["data"] = array();

						while($row = mysqli_fetch_array($result)) 
						{

							//BUKIT BERUNTUNG
							//bf OK
							$result_cntE = $dbc->query("SELECT SUM(qty_NG) AS cnteidE FROM disposal_detail_prd_all where MONTH(date_posting) = '$row[month_int]' and status_disposal ='$rst_sta3[status_desc]'
															AND plant_cd = '2300' and YEAR(date_posting) = '$crtYr' AND status_part='PR'");
							$row_cntE  = $result_cntE->fetch_assoc();
						
							$count_eidE = $row_cntE['cnteidE'];
							
							//bf pending OK
							
							$result_cntE11 = $dbc->query("SELECT SUM(qty_qc_NG) AS cnteidE FROM disposal_detail_prd_all where MONTH(date_posting) = '$row[month_int]' and status_disposal ='$rst_sta3[status_desc]'
															AND plant_cd = '2300' and YEAR(date_posting) = '$crtYr' AND status_part='PR'");
							$row_cntE11  = $result_cntE11->fetch_assoc();
						
							$count_eidE11 = $row_cntE11['cnteidE'];
							
							
							
							
							$count_OKBB = ($count_eidE + $count_eidE11);
						
							//MELAKA
							//bf OK
							$result_cntE2 = $dbc->query("SELECT SUM(qty_NG) AS cnteidE FROM disposal_detail_prd_all where MONTH(date_posting) = '$row[month_int]' and status_disposal ='$rst_sta3[status_desc]'
															AND plant_cd = '2301' and YEAR(date_posting) = '$crtYr' AND status_part='PR'");
							$row_cntE2  = $result_cntE2->fetch_assoc();
						
							$count_eidE2 = $row_cntE2['cnteidE'];
							
							//bf pending OK
							
							$result_cntE21 = $dbc->query("SELECT SUM(qty_qc_NG) AS cnteidE FROM disposal_detail_prd_all where MONTH(date_posting) = '$row[month_int]' and status_disposal ='$rst_sta3[status_desc]'
															AND plant_cd = '2301' and YEAR(date_posting) = '$crtYr' AND status_part='PR'");
							$row_cntE21  = $result_cntE21->fetch_assoc();
						
							$count_eidE21 = $row_cntE21['cnteidE'];
							
						
							
							$count_OKMLK = ($count_eidE2 + $count_eidE21);
								
							
							array_push($cat["category"],array("label" => $row["month_descp"]));
							array_push($data1["data"],array("value" => $count_OKBB));
							array_push($data2["data"],array("value" => $count_OKMLK));
							//$total_var = $total_var + $smsstat_status_row['sum'];
							
						}
			
					array_push($arrData["categories"], array("category" => array_values($cat["category"])));
					array_push($arrData["dataset"], array("seriesname" => "BB Plant","data" => array_values($data1["data"])));
					array_push($arrData["dataset"], array("seriesname" => "MLK Plant","data" => array_values($data2["data"])));
				
				
					/*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */
					$jsonEncodedData = json_encode($arrData);
				
					$columnChart = new FusionCharts("mscolumn3d", "Dashboard 1" , 1000, 600, "ReleasedBar", "json", $jsonEncodedData);
					//https://www.fusioncharts.com/dev/chart-guide/list-of-charts
				
					// Render the chart
					$columnChart->render();
					
					// Close the database connection
					//$dbc->close();

				}
				
			?>
            
            <div id="ReleasedBar"><!-- Fusion Charts will render here--></div>
            
            <!--searching-->
			<?php
            if(isset($_POST['Srch']))
            {
                $sYr = $_POST['selYr'];
                $sMth = $_POST['selMth'];
            
                echo "<script>";
                echo "window.location='dash_brdprod_src2C.php?selYr=$sYr&&selMth=$sMth'";
                echo "</script>";
                exit(); //quit the script
            }
            
            ?>   
		
			
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">2300 - Bukit Beruntung</h3>
            
            <!--Searching-->
             <div class="col-md-12">
              <div class="tile">
                <!--<h3 class="tile-title">Subscribe</h3>-->
                <div class="tile-body">
                  <form class="row" method="POST" action="">
                    <div class="form-group col-md-3">
                     <!--<label class="control-label">Year</label>-->
                      <select name="selYr2" id="selYr2" class="form-control">
                      <option value="NULL"> -Year -</option>
                        <?php
                        $qryYr2 = "SELECT  DISTINCT YEAR(date_posting) as planyear FROM disposal_detail_prd_all WHERE status_part='PR' ";
                        $resultYr2 = mysqli_query($dbc,$qryYr2);
                        
                        while($rowYr2 = mysqli_fetch_array($resultYr2)) 
                        { 
                            $Pdate2 = date('Y', strtotime($rowYr2['date_posting']))
                            
                        ?>
                        <option value="<?php echo $rowYr2["planyear"]; ?>" <?php if($rowYr2["planyear"] == $crtYr) echo "selected"; ?>> <?php echo $rowYr2["planyear"]; ?></option>
                        <?php
                        }
                        ?>   
                       </select> 
                    </div>
                    <div class="form-group col-md-4">
                    <!--<label class="control-label">Month</label>-->
                      <select name="selMth2" id="selMth" class="form-control">
                      <option value="NULL"> - Month -</option>
                        <?php
                        $qryMth2 = "SELECT * FROM tbl_month ORDER BY id ASC";
                        $resultMth2 = mysqli_query($dbc,$qryMth2);
                        
                        while($rowMth2 = mysqli_fetch_array($resultMth2)) 
                        { 
                        ?>
                        <option value="<?php echo $rowMth2["month_int"]; ?>"> <?php echo $rowMth2["month_descp"]; ?></option>
                        <?php
                        }
                        ?>   
                      </select> 
                    </div>
                    <div class="form-group col-md-4 align-self-end">
                      <button name="SrchDont" class="btn btn-primary" type="submit">Search</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!--/n Searching-->
            
            <!--Donut Chart-->
            
            <?php
			$arrData = array(
				"chart" => array(
					//"caption" => "Split of Revenue by Product Categories",
					//"subCaption" => "Last year",
					//"numberPrefix" => "$",
					"showLegend"=> "1",
					"valueFontColor"=> "#000000",
					"valueFontSize"=> "12",
					"valueFontBold"=> "1",
					/*"legendcaption"=> "Hover over these:",*/
					"legendcaptionbold"=> "1",
					"legendcaptionfontsize"=> "16",
					"paletteColors"=> "#009933,#CC0000,#FF9900,#33CC99",
					"bgColor"=> "#ffffff",
					//"defaultCenterLabel" => "Total revenue: $64.08K",
					//"centerLabel" => "Revenue from ",
					//"decimals" => "0",
					"theme" => "fusion"
				)
			);
			
			$arrData["data"] = array();
									
			$arrData["categories"] = array();
			$cat["category"] = array();
			$arrData["dataset"] = array();
			$data1["data"] = array();
			$data2["data"] = array();
			$data3["data"] = array();
			$data4["data"] = array();
			
			//New
			$strQuery = "SELECT * FROM request_status WHERE status_id = '1' ";
			$result = $dbc->query($strQuery) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$row = mysqli_fetch_array($result); 
			
			//In progress
			$strQuery2 = "SELECT * FROM request_status WHERE status_id = '7' ";
			$result2 = $dbc->query($strQuery2) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$row2 = mysqli_fetch_array($result2); 
			
			//Released
			$strQuery3 = "SELECT * FROM request_status WHERE status_id = '3' ";
			$result3 = $dbc->query($strQuery3) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$row3 = mysqli_fetch_array($result3); 
			
			//Cancelled
			$strQuery4 = "SELECT * FROM request_status WHERE status_id = '4' ";
			$result4 = $dbc->query($strQuery4) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$row4 = mysqli_fetch_array($result4); 
			
			//BF OK
			$result_new = $dbc->query("SELECT SUM(qty_NG) AS cntNew FROM disposal_detail_prd_all WHERE YEAR(date_posting) = '$crtYr'  and status_disposal ='$row3[status_desc]'
											AND plant_cd = '2300' AND status_part='PR' ");
			$row_new  = $result_new->fetch_assoc();
		
			$count_new = $row_new['cntNew'];
					
			//BF PENDING OK
			$result_pgress = $dbc->query("SELECT SUM(qty_qc_NG) AS cntPgres FROM disposal_detail_prd_all WHERE YEAR(date_posting) = '$crtYr' and status_disposal ='$row3[status_desc]'
											AND plant_cd = '2300' AND status_part='PR' ");
			$row_pgress  = $result_pgress->fetch_assoc();
		
			$count_pgress = $row_pgress['cntPgres'];
			
			
			//--------------cancel --------------------------------
			
			$result_new2 = $dbc->query("SELECT SUM(qty_NG) AS cntNew FROM disposal_detail_prd_all WHERE YEAR(date_posting) = '$crtYr'  and status_disposal ='$row4[status_desc]'
											AND plant_cd = '2300' AND status_part='PR' ");
			$row_new2  = $result_new2->fetch_assoc();
		
			$count_new2 = $row_new2['cntNew'];
					
			//BF PENDING OK
			$result_pgress2 = $dbc->query("SELECT SUM(qty_qc_NG) AS cntPgres FROM disposal_detail_prd_all WHERE YEAR(date_posting) = '$crtYr' and status_disposal ='$row4[status_desc]'
											AND plant_cd = '2300' AND status_part='PR' ");
			$row_pgress2  = $result_pgress2->fetch_assoc();
		
			$count_pgress2 = $row_pgress2['cntPgres'];
			
			
			$count_open = ($count_new + $count_pgress);
			
			$count_close = ($count_new2 + $count_pgress2);
			
			//display donut
			array_push($arrData["data"], 
				array(
              	"label" => "Disposal",
              	"value" => $count_open
              	),
				array(
              	"label" => "Cancel Disposal",
              	"value" => $count_close
              	)
				
           	);
			
			
			
			$jsonEncodedData = json_encode($arrData);

			$columnChartB = new FusionCharts("doughnut2d", "BBPlantChart" , 480,500, "chart-BB", "json", $jsonEncodedData);

			// Render the chart
			$columnChartB->render();

			// Close the database connection
			//$dbc->close();
			
			?>
            
            <div id="chart-BB"><!-- Fusion Charts will render here--></div>
            
            
            
			
            <!--searching-->
			<?php
            if(isset($_POST['SrchDont']))
            {
                $sYr = $_POST['selYr2'];
                $sMth = $_POST['selMth2'];
            
                echo "<script>";
                echo "window.location='dash_brdprod_srcB2C.php?selYr2=$sYr&&selMth2=$sMth'";
                echo "</script>";
                exit(); //quit the script
            }
            
            ?>   
            <!--/n Donut Chart-->
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">2301 - Melaka</h3>
            
            <!--Searching-->
             <div class="col-md-12">
              <div class="tile">
                <!--<h3 class="tile-title">Subscribe</h3>-->
                <div class="tile-body">
                  <form class="row" method="GET" action=""> 
                    <div class="form-group col-md-3">
                     <!--<label class="control-label">Year</label>-->
                      <select name="selYr3" id="selYr3" class="form-control">
                      <option value="NULL"> -Year -</option>
                        <?php
                        $qryYr3 = "SELECT  DISTINCT YEAR(date_posting) as planyear FROM disposal_detail_prd_all WHERE status_part='PR'";
                        $resultYr3 = mysqli_query($dbc,$qryYr3);
                        
                        while($rowYr3 = mysqli_fetch_array($resultYr3)) 
                        { 
                            $Pdate3 = date('Y', strtotime($rowYr3['date_posting']))
                            
                        ?>
                        <option value="<?php echo $rowYr3["planyear"]; ?>" <?php if($rowYr3["planyear"] == $sYr3) echo "selected"; ?>> <?php echo $rowYr3["planyear"]; ?></option>
                        <?php
                        }
                        ?>   
                       </select> 
                    </div>
                    <div class="form-group col-md-4">
                    <!--<label class="control-label">Month</label>-->
                      <select name="selMth3" id="selMth3" class="form-control">
                      <option value="NULL"> - Month -</option>
                        <?php
                        $qryMth3 = "SELECT * FROM tbl_month ORDER BY id ASC";
                        $resultMth3 = mysqli_query($dbc,$qryMth3);
                        
                        while($rowMth3 = mysqli_fetch_array($resultMth3)) 
                        { 
                        ?>
                        <option value="<?php echo $rowMth3["month_int"]; ?>" <?php if($rowMth3["month_int"] == $sMth3) echo "selected"; ?>> <?php echo $rowMth3["month_descp"]; ?></option>
                        <?php
                        }
                        ?>   
                      </select> 
                    </div>
                    <div class="form-group col-md-4 align-self-end">
                      <button name="SrchDontM" class="btn btn-primary" type="submit">Search</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!--/n Searching-->
            
            <!--Donut Chart-->
            
            <?php
			$arrData3 = array(
				"chart" => array(
					//"caption" => "Split of Revenue by Product Categories",
					//"subCaption" => "Last year",
					//"numberPrefix" => "$",
					"showLegend"=> "1",
					"valueFontColor"=> "#000000",
					"valueFontSize"=> "12",
					"valueFontBold"=> "1",
					/*"legendcaption"=> "Hover over these:",*/
					"legendcaptionbold"=> "1",
					"legendcaptionfontsize"=> "12",
					"paletteColors"=> "#009933,#CC0000,#FF9900,#33CC99",
					"bgColor"=> "#ffffff",
					//"defaultCenterLabel" => "Total revenue: $64.08K",
					//"centerLabel" => "Revenue from ",
					//"decimals" => "0",
					"theme" => "fusion"
				)
			);
			
			$arrData3["data"] = array();
									
			$arrData3["categories"] = array();
			$cat["category"] = array();
			$arrData3["dataset"] = array();
			$data1M["data"] = array();
			$data2M["data"] = array();
			$data3M["data"] = array();
			$data4M["data"] = array();
			
			//New
			$strQueryM = "SELECT * FROM request_status WHERE status_id = '1' ";
			$resultM = $dbc->query($strQueryM) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$rowM = mysqli_fetch_array($resultM); 
			
			//In progress
			$strQueryM2 = "SELECT * FROM request_status WHERE status_id = '7' ";
			$resultM2 = $dbc->query($strQueryM2) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$rowM2 = mysqli_fetch_array($resultM2); 
			
			//Released
			$strQueryM3 = "SELECT * FROM request_status WHERE status_id = '3' ";
			$resultM3 = $dbc->query($strQueryM3) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$rowM3 = mysqli_fetch_array($resultM3); 
			
			//Cancelled
			$strQueryM4 = "SELECT * FROM request_status WHERE status_id = '4' ";
			$resultM4 = $dbc->query($strQueryM4) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$rowM4 = mysqli_fetch_array($resultM4); 
			
			
			//-------------open------------------
			//BF OK
			$result_newM = $dbc->query("SELECT SUM(qty_NG) AS cntNew FROM disposal_detail_prd_all WHERE YEAR(date_posting) = '$crtYr'  and status_disposal ='$rowM3[status_desc]'
											AND plant_cd = '2301' AND status_part='PR' ".$where_sql);
			$row_newM  = $result_newM->fetch_assoc();
		
			$count_newM = $row_newM['cntNew'];
					
			//BF PENDING OK
			$result_pgressM = $dbc->query("SELECT SUM(qty_qc_NG) AS cntPgres FROM disposal_detail_prd_all WHERE YEAR(date_posting) = '$crtYr' and status_disposal ='$rowM3[status_desc]'
											AND plant_cd = '2301' AND status_part='PR' ".$where_sql);
			$row_pgressM  = $result_pgressM->fetch_assoc();
		
			$count_pgressM = $row_pgressM['cntPgres'];
			
		  //------------cancel ----------------
		  
		  //BF OK
			$result_newM2 = $dbc->query("SELECT SUM(qty_NG) AS cntNew FROM disposal_detail_prd_all WHERE YEAR(date_posting) = '$crtYr'  and status_disposal ='$rowM4[status_desc]'
											AND plant_cd = '2301' AND status_part='PR' ".$where_sql);
			$row_newM2  = $result_newM2->fetch_assoc();
		
			$count_newM2 = $row_newM2['cntNew'];
					
			//BF PENDING OK
			$result_pgressM2 = $dbc->query("SELECT SUM(qty_qc_NG) AS cntPgres FROM disposal_detail_prd_all WHERE YEAR(date_posting) = '$crtYr' and status_disposal ='$rowM4[status_desc]'
											AND plant_cd = '2301' AND status_part='PR'".$where_sql);
			$row_pgressM2  = $result_pgressM2->fetch_assoc();
		
			$count_pgressM2 = $row_pgressM2['cntPgres'];
			
			
			$count_openM = ($count_newM + $count_pgressM);
			
			$count_closeM = ($count_newM2 + $count_pgressM2);
			
			
			
		    array_push($arrData3["data"], 
				array(
              	"label" => "Disposal",
              	"value" => $count_openM
              	),
				array(
              	"label" => "Cancel Disposal",
              	"value" => $count_closeM
              	)
				
           	);
			
			
			
		
			
			$jsonEncodedDataM = json_encode($arrData3);

			$columnChartM = new FusionCharts("doughnut2d", "MMPlantChart" , 480,500, "chart-MM", "json", $jsonEncodedDataM);

			// Render the chart
			$columnChartM->render();

			// Close the database connection
			//$dbc->close();
			
			?>
            
            <div id="chart-MM"><!-- Fusion Charts will render here--></div>
            
		
            <!--/n Donut Chart-->
            
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
    <script type="text/javascript" src="js/plugins/chart.js"></script>
    <script type="text/javascript">
      var data = {
      	labels: ["January", "February", "March", "April", "May"],
      	datasets: [
      		{
      			label: "My First dataset",
      			fillColor: "rgba(220,220,220,0.2)",
      			strokeColor: "rgba(220,220,220,1)",
      			pointColor: "rgba(220,220,220,1)",
      			pointStrokeColor: "#fff",
      			pointHighlightFill: "#fff",
      			pointHighlightStroke: "rgba(220,220,220,1)",
      			data: [65, 59, 80, 81, 56]
      		},
      		{
      			label: "My Second dataset",
      			fillColor: "rgba(151,187,205,0.2)",
      			strokeColor: "rgba(151,187,205,1)",
      			pointColor: "rgba(151,187,205,1)",
      			pointStrokeColor: "#fff",
      			pointHighlightFill: "#fff",
      			pointHighlightStroke: "rgba(151,187,205,1)",
      			data: [28, 48, 40, 19, 86]
      		}
      	]
      };
      var pdata = [
      	{
      		value: 300,
      		color: "#46BFBD",
      		highlight: "#5AD3D1",
      		label: "Complete"
      	},
      	{
      		value: 50,
      		color:"#F7464A",
      		highlight: "#FF5A5E",
      		label: "In-Progress"
      	}
      ]
      
      var ctxl = $("#lineChartDemo").get(0).getContext("2d");
      var lineChart = new Chart(ctxl).Line(data);
      
      var ctxp = $("#pieChartDemo").get(0).getContext("2d");
      var pieChart = new Chart(ctxp).Pie(pdata);
    </script>

  </body>
</html>