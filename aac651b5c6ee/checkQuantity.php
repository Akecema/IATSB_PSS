<?php

session_start();
$username = $_SESSION['username'];
include '../include/config.php';
$buid2 = base64_decode($_GET['buid']);
$id = $_GET['id'];

$result['status'] = "Fail";

if (isset($_GET['quant'])) {
	$out_quantity = $_GET['quant'];
} else {
	$out_quantity = 0;
}

//CR status (Cancelled)
$sta4 = "SELECT * from request_status WHERE status_id = '4'";
$sta_res4 = mysqli_query($dbc, $sta4);
$rst_sta4 = mysqli_fetch_array($sta_res4);



$query_all = "SELECT * FROM dlv_dikanban_generate WHERE id = '".sql_esc($id)."' ";
$result_all = mysqli_query($dbc, $query_all);
$row2 = mysqli_fetch_array($result_all);

$tot_di_qty2 = 0.000;
$tot_kanb = 0.000;

$query_qty_deli = "SELECT * FROM dlv_ord_dikanban_generate WHERE po_no = '".sql_esc($row2["po_no"])."' AND DI_doc = '".sql_esc($row2["DI_doc"])."' AND material_no = '".sql_esc($row2["material_no"])."' AND status_DO != '".sql_esc($rst_sta4["status_desc"])."' AND status_kanban != '".sql_esc($rst_sta4["status_desc"])."'";
$result_qty_deli = mysqli_query($dbc, $query_qty_deli);

while ($data_qty_deli = mysqli_fetch_array($result_qty_deli)) {

	$tot_di_qty = $tot_di_qty + $data_qty_deli["qty_dlv"];
}

	$tot_di_qty2 = $tot_di_qty + $out_quantity; 

$tot_kanb = $tot_kanb + $row2["kanban_order"];
$pend_qty2 = ($row2["kanban_order"] - ($tot_di_qty2));

if ($tot_di_qty2 != 0.000) {

	if (($pend_qty2 < 0.000) && ($pend_qty2 != 0.000)) {
		$result['status'] = "ERROR";
	} else {
		$result['status'] = "SUCCESS";
	}
}


echo json_encode($result); //pass array
echo mysqli_error($dbc);
