<?php

session_start();
$username = $_SESSION['username'];
include '../include/config.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<style media="print">
@media print {
	.pageBb
	{
		/*page-break-before: always;*/
	}
	.prt-button 
	{ 
		display: none; 
	}

}
</style>
    
</head>

<body>

<table width="200" border="2">
  <tr>
    <td>no 1</td>
    <td>Name 1</td>
<?php

$query2 = "SELECT * FROM a_test order by id";
$result2 = mysqli_query($dbc,$query2) or die (mysqli_error());

$datarows = 0;
	
	
while($res = mysqli_fetch_array($result2)) {

if($datarows % 2 == 0) {
	
?>




  </tr>
  <tr>
    <td>1.</td>
    <td>Tata</td>
  
 
  <?php } ?>

------------------------
</tr>
  
  </table>
<br />

 
<?php

$datarows++; 
}
?>
--------------
<button type="button" name="btn_release" id="btn_release" class="btn btn-success btn-sm" onClick="window.print()">Print this Page</button>

</body>
</html>
