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
	
$url = "dash_brdprod.php"; 

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
    
    $query_sql = "SELECT * FROM login_detail WHERE username = '".sql_esc($username)."' and status = 'AC'";
    $result_sql = mysqli_query($dbc,$query_sql);
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
    
    <?php
	//Graph Bar		
	$sYr2 = $_GET['selYr2'];
    $sMth2 = $_GET['selMth2'];

	if ($sYr2 == 'NULL') {
		$wheresql_01 = '';}
	else{
		$wheresql_01 = " AND YEAR(date_plan) = '$sYr2' ";}
		
	if ($sMth2 == 'NULL') {
		$wheresql_02 = '';}
	else{
		$wheresql_02 = " AND month_plan = '$sMth2' ";}
	
			
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
          <li class="breadcrumb-item"><a href="dash_brdprod.php">Dashboard</a></li>
        </ul>
      </div>
    
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Planning</h3>
            
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
							$qryYr = "SELECT  DISTINCT YEAR(date_plan) as planyear FROM pps_detail";
							$resultYr = mysqli_query($dbc,$qryYr);
							
							while($rowYr = mysqli_fetch_array($resultYr)) 
							{ 
								$Pdate = date('Y', strtotime($rowYr['date_plan']))
								
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
                          <option value="NULL"> - Month -</option>
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
								"subCaption"=> "Planned Order Number by Monthly",
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

							//SERENDAH
							$result_cntE = $dbc->query("SELECT count(status_pps) AS cnteidE FROM pps_detail where month_plan = '$row[month_int]' and status_pps ='Released'
															AND comp_code = '3100' and YEAR(date_plan) = '$crtYr'");
							$row_cntE  = $result_cntE->fetch_assoc();
						
							$count_eidE = $row_cntE['cnteidE'];
						
						
							
							
							array_push($cat["category"],array("label" => $row["month_descp"]));
							array_push($data1["data"],array("value" => $count_eidE));
							
							//$total_var = $total_var + $smsstat_status_row['sum'];
							
						}
			
							array_push($arrData["categories"], array("category" => array_values($cat["category"])));
							array_push($arrData["dataset"], array("seriesname" => "Serendah Plant","data" => array_values($data1["data"])));
				
					
				
					/*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */
				
					$jsonEncodedData = json_encode($arrData);
				
				
					$columnChart = new FusionCharts("mscolumn3d", "Dashboard 1" , 1000, 600, "1st_challenge", "json", $jsonEncodedData);
					//https://www.fusioncharts.com/dev/chart-guide/list-of-charts
				
					// Render the chart
					$columnChart->render();
				
					// Close the database connection
					//dbhandle->close();
				}
			
			?>
		
			<div id="1st_challenge"><!-- Fusion Charts will render here--></div>
            
            <!--searching-->
			<?php
            if(isset($_POST['Srch']))
            {
                $sYr = $_POST['selYr'];
                $sMth = $_POST['selMth'];
            
                echo "<script>";
                echo "window.location='dash_brdprod_src.php?selYr=".html_esc($sYr)."&&selMth=".html_esc($sMth)."'";
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
                  <form class="row" method="GET" action=""> 
                    <div class="form-group col-md-3">
                     <!--<label class="control-label">Year</label>-->
                      <select name="selYr2" id="selYr2" class="form-control">
                      <option value="NULL"> -Year -</option>
                        <?php
                        $qryYr2 = "SELECT  DISTINCT YEAR(date_plan) as planyear FROM pps_detail";
                        $resultYr2 = mysqli_query($dbc,$qryYr2);
                        
                        while($rowYr2 = mysqli_fetch_array($resultYr2)) 
                        { 
                            $Pdate2 = date('Y', strtotime($rowYr2['date_plan']))
                            
                        ?>
                        <option value="<?php echo html_esc($rowYr2["planyear"]); ?>" <?php if($rowYr2["planyear"] == $sYr2) echo "selected"; ?>> <?php echo html_esc($rowYr2["planyear"]); ?></option>
                        <?php
                        }
                        ?>   
                      </select> 
                    </div>
                    <div class="form-group col-md-4">
                    <!--<label class="control-label">Month</label>-->
                      <select name="selMth2" id="selMth2" class="form-control">
                      <option value="NULL"> - Month -</option>
                        <?php
                        $qryMth2 = "SELECT * FROM tbl_month ORDER BY id ASC";
                        $resultMth2 = mysqli_query($dbc,$qryMth2);
                        
                        while($rowMth2 = mysqli_fetch_array($resultMth2)) 
                        { 
                        ?>
                        <option value="<?php echo html_esc($rowMth2["month_int"]); ?>" <?php if($rowMth2["month_int"] == $sMth2) echo "selected"; ?>> <?php echo html_esc($rowMth2["month_descp"]); ?></option>
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
			
			//New
			$strQuery = "SELECT * FROM request_status WHERE status_id = '1' ";
			$result = $dbc->query($strQuery) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$row = mysqli_fetch_array($result); 
			
			//In progress
			$strQuery2 = "SELECT * FROM request_status WHERE status_id = '7' ";
			$result2 = $dbc->query($strQuery2) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$row2 = mysqli_fetch_array($result2); 
			
			//Released
			$strQuery3 = "SELECT * FROM request_status WHERE status_id = '2' ";
			$result3 = $dbc->query($strQuery3) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$row3 = mysqli_fetch_array($result3); 
			
			//Closed
			$strQuery4 = "SELECT * FROM request_status WHERE status_id = '13' ";
			$result4 = $dbc->query($strQuery4) or exit("Error code ({$dbc->errno}): {$dbc->error}");
			$row4 = mysqli_fetch_array($result4); 
			
			//New
			$result_new = $dbc->query("SELECT count(status_pps) AS cntNew FROM pps_detail WHERE  status_pps ='$row[status_desc]'
											AND comp_code = '3100'".$where_sql );
			$row_new  = $result_new->fetch_assoc();
		
			$count_new = $row_new['cntNew'];
					
			//In progress
			$result_pgress = $dbc->query("SELECT count(status_pps) AS cntPgres FROM pps_detail WHERE status_pps ='$row2[status_desc]'
											AND comp_code = '3100'".$where_sql );
			$row_pgress  = $result_pgress->fetch_assoc();
		
			$count_pgress = $row_pgress['cntPgres'];
			
			//Released
			$result_rlsed = $dbc->query("SELECT count(status_pps) AS cntRlsd FROM pps_detail WHERE status_pps ='$row3[status_desc]'
											AND comp_code = '3100'".$where_sql );
			$row_rlsed  = $result_rlsed->fetch_assoc();
		
			$count_rlsed = $row_rlsed['cntRlsd'];
			
			//Closed
			$result_closed = $dbc->query("SELECT count(status_pps) AS cntClsd FROM pps_detail WHERE status_pps ='$row4[status_desc]'
											AND comp_code = '3100'".$where_sql );
			$row_closed  = $result_closed->fetch_assoc();
		
			$count_closed = $row_closed['cntClsd'];
			
			//create donut
			array_push($arrData["data"], 
				array(
              	"label" => $row["status_desc"],
              	"value" => $count_new
              	),
				array(
              	"label" => $row2["status_desc"],
              	"value" => $count_pgress
              	),
				array(
              	"label" => $row3["status_desc"],
              	"value" => $count_rlsed
              	),
				array(
              	"label" => $row4["status_desc"],
              	"value" => $count_closed
              	)
				
           	);
			
			
			$jsonEncodedData = json_encode($arrData);
	
			$columnChart = new FusionCharts("doughnut2d", "myFirstChart" , 1000,500, "chart-BB", "json", $jsonEncodedData);

			// Render the chart
			$columnChart->render();

			// Close the database connection
			//$dbc->close();
			
			?>
            
            <div id="chart-BB"><!-- Fusion Charts will render here--></div>
            
            <!--/n Donut Chart-->
          </div>
        </div>
        
       
            <!--/n Searching-->
            
          
        
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