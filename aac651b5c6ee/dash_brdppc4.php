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

$query2 = new PreparedSql("SELECT * FROM user_detail WHERE username = ?", [$username]);
$result2 = db_query($dbc, $query2) or die (mysqli_error());
$res = mysqli_fetch_array($result2);
	
$url = "dash_brdppc4.php"; 

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
    
    $query_sql = new PreparedSql("SELECT * FROM login_detail WHERE username = ? and status = 'AC'", [$username]);
    $result_sql = db_query($dbc, $query_sql);
    $info = mysqli_fetch_array($result_sql);
    
    
    if(($info['status_pass'] == 'N'))
    {
	?>
   
		<script type="text/javascript">
        jQuery(document).ready(function ($) {
        $.fancybox({
        href: "backjob_initial_pass.php?username=<?php echo html_esc($username); ?>",
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
        href: "backjob_reminder_pass.php?username=<?php echo html_esc($username); ?>",
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
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
          <p>Dashboard of Production Support System (PSS)</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="dash_brdppc4.php">Dashboard</a></li>
        </ul>
      </div>
     
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Delivery</h3>
              <div class="col-md-12">
             <ul class="nav nav-tabs">
               <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="dash_brdppc4.php">Delivery Order</a></li>
               <li class="nav-item"><a class="nav-link" href="dash_brdppc4C.php">Disposal</a></li>
              </ul> 
            </div>
            
            	<!--Searching-->
                 <div class="col-md-12">
                  <div class="tile">
                    <!--<h3 class="tile-title">Subscribe</h3>-->
                    <div class="tile-body">
                      <form class="row" method="POST" action="">
                        <div class="form-group col-md-2">
                         <!--<label class="control-label">Year</label>-->
                          <select name="selYr" id="selYr" class="form-control">
                          <option value="NULL"> - Year - </option>
							<?php
							$qryYr = "SELECT  DISTINCT YEAR(date_posting_do) as planyear FROM dlv_ord_dikanban_generate";
							$resultYr = mysqli_query($dbc,$qryYr);
							
							while($rowYr = mysqli_fetch_array($resultYr)) 
							{ 
								$Pdate = date('Y', strtotime($rowYr['date_posting_do']))
								
							?>
                            <option value="<?php echo html_esc($rowYr["planyear"]); ?>" <?php if($rowYr["planyear"] == $crtYr) echo "selected"; ?>> <?php echo html_esc($rowYr["planyear"]); ?></option>
							<?php
							}
							?>   
                           </select> 
                        </div>
                        <div class="form-group col-md-2">
                        <!--<label class="control-label">Month</label>-->
                          <select name="selMth" id="selMth" class="form-control">
                          <option value="NULL"> - Month - </option>
							<?php
							$qryMth = "SELECT * FROM tbl_month ORDER BY id ASC";
							$resultMth = mysqli_query($dbc,$qryMth);
							
							while($rowMth = mysqli_fetch_array($resultMth)) 
							{ 
							?>
							<option value="<?php echo html_esc($rowMth["month_int"]); ?>"> <?php echo html_esc($rowMth["month_descp"]); ?></option>
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
								"subCaption"=> "Delivery Order by Monthly",
								"xAxisName"=> "Month",
								"yAxisName"=> "Quantity",
								"numberPrefix"=> "",
								"paletteColors"=> "#CC0000,#33CC99,#FF9900,#333333,#FF5733,#0E31A0",
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
								"valueFontColor"=> "#000000",
								"rotateValues"=> "1",
								"placeValuesInside"=> "1",
								"divlineColor"=> "#999999",
								"divLineDashed"=> "1",
								"divLineDashLen"=> "1",
								"divLineGapLen"=> "1",
								"canvasBgColor"=> "#ffffff",
								"captionFontSize"=> "14",
								"subcaptionFontSize"=> "12",
								"subcaptionFontBold"=> "0"
								)
							);
											
						$arrData["categories"] = array();
						$cat["category"] = array();
						$arrData["dataset"] = array();
						$data1["data"] = array();
						$data1B["data"] = array();
						$data1C["data"] = array();
						$data1D["data"] = array();
						$data1E["data"] = array();
						$data1F["data"] = array();
					    $data1G["data"] = array();
						$data1H["data"] = array();
						$data1I["data"] = array();

						while($row = mysqli_fetch_array($result)) 
						{

							//BUKIT BERUNTUNG
							$result_cntE = $dbc->query("SELECT SUM(qty_dlv) AS cnteidE FROM dlv_ord_dikanban_generate WHERE MONTH(date_posting_do) = '$row[month_int]' AND status_DO ='$rst_sta7[status_desc]'
															AND plant_code = '3100' AND YEAR(date_posting_do) = '$crtYr' AND vc_code ='100127'");
							$row_cntE  = $result_cntE->fetch_assoc();
						
							$count_eidE = $row_cntE['cnteidE'];
							
							//-----------no 2----------
							
							$result_cntEB = $dbc->query("SELECT SUM(qty_dlv) AS cnteidE FROM dlv_ord_dikanban_generate WHERE MONTH(date_posting_do) = '$row[month_int]' AND status_DO ='$rst_sta7[status_desc]'
															AND plant_code = '3100' AND YEAR(date_posting_do) = '$crtYr' AND vc_code ='100229' ");
							$row_cntEB  = $result_cntEB->fetch_assoc();
						
							$count_eidEB = $row_cntEB['cnteidE'];
							
							//-----------no 3----------
							
							$result_cntEC = $dbc->query("SELECT SUM(qty_dlv) AS cnteidE FROM dlv_ord_dikanban_generate WHERE MONTH(date_posting_do) = '$row[month_int]' AND status_DO ='$rst_sta7[status_desc]'
															AND plant_code = '3100' AND YEAR(date_posting_do) = '$crtYr' AND vc_code = '100230' ");
							$row_cntEC  = $result_cntEC->fetch_assoc();
						
							$count_eidEC = $row_cntEC['cnteidE'];
						
							//-----------no 4----------
							
							$result_cntED = $dbc->query("SELECT SUM(qty_dlv) AS cnteidE FROM dlv_ord_dikanban_generate WHERE MONTH(date_posting_do) = '$row[month_int]' AND status_DO ='$rst_sta7[status_desc]'
															AND plant_code = '3100' AND YEAR(date_posting_do) = '$crtYr' AND vc_code = '100231' ");
							$row_cntED  = $result_cntED->fetch_assoc();
						
							$count_eidED = $row_cntED['cnteidE'];
							
							//-----------no 5----------
							
							$result_cntEE = $dbc->query("SELECT SUM(qty_dlv) AS cnteidE FROM dlv_ord_dikanban_generate WHERE MONTH(date_posting_do) = '$row[month_int]' AND status_DO ='$rst_sta7[status_desc]'
															AND plant_code = '3100' AND YEAR(date_posting_do) = '$crtYr' AND vc_code = '100232' ");
							$row_cntEE  = $result_cntEE->fetch_assoc();
						
							$count_eidEE = $row_cntEE['cnteidE'];
						
							
								//-----------no 6----------
							
							$result_cntEF = $dbc->query("SELECT SUM(qty_dlv) AS cnteidE FROM dlv_ord_dikanban_generate WHERE MONTH(date_posting_do) = '$row[month_int]' AND status_DO ='$rst_sta7[status_desc]'
															AND plant_code = '3100' AND YEAR(date_posting_do) = '$crtYr' AND vc_code = '100233' ");
							$row_cntEF  = $result_cntEF->fetch_assoc();
						
							$count_eidEF = $row_cntEF['cnteidE'];
							
								//-----------no 7----------
							
							$result_cntEG = $dbc->query("SELECT SUM(qty_dlv) AS cnteidE FROM dlv_ord_dikanban_generate WHERE MONTH(date_posting_do) = '$row[month_int]' AND status_DO ='$rst_sta7[status_desc]'
															AND plant_code = '3100' AND YEAR(date_posting_do) = '$crtYr' AND vc_code = '100234' ");
							$row_cntEG  = $result_cntEG->fetch_assoc();
						
							$count_eidEG = $row_cntEG['cnteidE'];
							
								//-----------no 8----------
							
							$result_cntEH = $dbc->query("SELECT SUM(qty_dlv) AS cnteidE FROM dlv_ord_dikanban_generate WHERE MONTH(date_posting_do) = '$row[month_int]' AND status_DO ='$rst_sta7[status_desc]'
															AND plant_code = '3100' AND YEAR(date_posting_do) = '$crtYr' AND vc_code = '100235' ");
							$row_cntEH  = $result_cntEH->fetch_assoc();
						
							$count_eidEH = $row_cntEH['cnteidE'];
							
								//-----------no 9----------
							
							$result_cntEI = $dbc->query("SELECT SUM(qty_dlv) AS cnteidE FROM dlv_ord_dikanban_generate WHERE MONTH(date_posting_do) = '$row[month_int]' AND status_DO ='$rst_sta7[status_desc]'
															AND plant_code = '3100' AND YEAR(date_posting_do) = '$crtYr' AND vc_code = '100236' ");
							$row_cntEI  = $result_cntEI->fetch_assoc();
						
							$count_eidEI = $row_cntEI['cnteidE'];
							
							
							array_push($cat["category"],array("label" => $row["month_descp"]));
							array_push($data1["data"],array("value" => $count_eidE));
							array_push($data1B["data"],array("value" => $count_eidEB));
							array_push($data1C["data"],array("value" => $count_eidEC));
							array_push($data1D["data"],array("value" => $count_eidED));
							array_push($data1E["data"],array("value" => $count_eidEE ));
							array_push($data1F["data"],array("value" => $count_eidEF));
							array_push($data1G["data"],array("value" => $count_eidEG));
							array_push($data1H["data"],array("value" => $count_eidEH));
							array_push($data1I["data"],array("value" => $count_eidEI));
							
							//$total_var = $total_var + $smsstat_status_row['sum'];
							
						}
			
					array_push($arrData["categories"], array("category" => array_values($cat["category"])));
					array_push($arrData["dataset"], array("seriesname" => "100127","data" => array_values($data1["data"])));
					array_push($arrData["dataset"], array("seriesname" => "100229","data" => array_values($data1B["data"])));
					array_push($arrData["dataset"], array("seriesname" => "100230","data" => array_values($data1C["data"])));
				    array_push($arrData["dataset"], array("seriesname" => "100231","data" => array_values($data1D["data"])));
					array_push($arrData["dataset"], array("seriesname" => "100232","data" => array_values($data1E["data"])));
					array_push($arrData["dataset"], array("seriesname" => "100233","data" => array_values($data1F["data"])));
					array_push($arrData["dataset"], array("seriesname" => "100234","data" => array_values($data1G["data"])));
					array_push($arrData["dataset"], array("seriesname" => "100235","data" => array_values($data1H["data"])));
					array_push($arrData["dataset"], array("seriesname" => "100236","data" => array_values($data1I["data"])));
				
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
                echo "window.location='dash_brdppc4_src.php?selYr=$sYr&&selMth=$sMth'";
                echo "</script>";
                exit(); //quit the script
            }
            
            ?>   
		
			
          </div>
        </div>
        
        
        
        
        
        
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">3100 - Serendah</h3>
            
            <!--Searching-->
             <div class="col-md-12">
              <div class="tile">
                <!--<h3 class="tile-title">Subscribe</h3>-->
                <div class="tile-body">
                  <form class="row" method="POST" action="">
                    <div class="form-group col-md-4">
                     <!--<label class="control-label">Year</label>-->
                      <select name="selYr2" id="selYr2" class="form-control">
                      <option value="NULL"> - Year -</option>
                        <?php
                        $qryYr2 = "SELECT  DISTINCT YEAR(date_posting_do) as planyear FROM dlv_ord_dikanban_generate";
                        $resultYr2 = mysqli_query($dbc,$qryYr2);
                        
                        while($rowYr2 = mysqli_fetch_array($resultYr2)) 
                        { 
                            $Pdate2 = date('Y', strtotime($rowYr2['date_posting_do']))
                            
                        ?>
                        <option value="<?php echo html_esc($rowYr2["planyear"]); ?>" <?php if($rowYr2["planyear"] == $crtYr) echo "selected"; ?>> <?php echo html_esc($rowYr2["planyear"]); ?></option>
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
                        <option value="<?php echo html_esc($rowMth2["month_int"]); ?>"> <?php echo html_esc($rowMth2["month_descp"]); ?></option>
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
					"paletteColors"=> "#33CC99,#FF9900,#009933,#CC0000",
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
			
			//Approved DO
			$strQuery = "SELECT * FROM request_status WHERE status_id = '7' ";
			$result = $dbc->query($strQuery) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$row = mysqli_fetch_array($result); 
			
	
			//Cancelled
			$strQuery3 = "SELECT * FROM request_status WHERE status_id = '4' ";
			$result3 = $dbc->query($strQuery3) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$row3 = mysqli_fetch_array($result3); 
			
			//Approved DO
			$result_new = $dbc->query("SELECT SUM(qty_dlv) AS cntNew FROM dlv_ord_dikanban_generate WHERE YEAR(date_posting_do) = '$crtYr' AND status_DO ='$row[status_desc]'
											AND plant_code = '3100'");
			$row_new  = $result_new->fetch_assoc();
		
			$count_new = $row_new['cntNew'];
					
			
			//Cancel Approved DO
			$result_new2 = $dbc->query("SELECT SUM(qty_dlv) AS cntNew FROM dlv_ord_dikanban_generate WHERE YEAR(date_posting_do) = '$crtYr' AND status_DO ='$row3[status_desc]'
											AND plant_code = '3100'");
			$row_new2  = $result_new2->fetch_assoc();
		
			$count_new2 = $row_new2['cntNew'];
					
			
		
			//display donut
			array_push($arrData["data"], 
				array(
              	"label" => "Delivery Order",
              	"value" => $count_new
              	),
				array(
              	"label" => "Cancelled DO",
              	"value" => $count_new2
              	)
			
				
           	);
			
			
			$jsonEncodedData = json_encode($arrData);

			$columnChartB = new FusionCharts("doughnut2d", "BBPlantChart" , 1000,500, "chart-BB", "json", $jsonEncodedData);

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
                echo "window.location='dash_brdppc4_srcB.php?selYr2=$sYr&&selMth2=$sMth'";
                echo "</script>";
                exit(); //quit the script
            }
            
            ?>   
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
   

  </body>
</html>