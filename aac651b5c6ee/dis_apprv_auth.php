<?php

$queryAssy = "SELECT * FROM sys_setup_disposal WHERE cat_acc = 'C' ORDER BY id ASC";
$rsAssy = mysqli_query($dbc,$queryAssy);   //run the query.
$numAssy = mysqli_num_rows($rsAssy);   //how many material are there?
$rowAssy = mysqli_fetch_array($rsAssy);

$queryStm = "SELECT * FROM sys_setup_disposal WHERE cat_acc = 'D' ORDER BY id ASC";
$rsStm = mysqli_query($dbc,$queryStm);   //run the query.
$numStm = mysqli_num_rows($rsStm);   //how many material are there?
$rowStm= mysqli_fetch_array($rsStm);

$queryHead = "SELECT * FROM sys_setup_disposal WHERE cat_acc = 'E' ORDER BY id ASC";
$rsHead = mysqli_query($dbc,$queryHead);   //run the query.
$numHead = mysqli_num_rows($rsHead);   //how many material are there?
$rowHead= mysqli_fetch_array($rsHead);

?>