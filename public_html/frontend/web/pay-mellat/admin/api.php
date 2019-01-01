<?php


require_once('php/sys.php');
require_once('php/newXML.php');

session_start();
$shoplogin = $_SESSION['adminlogin'] == session_id();
if(!$shoplogin && $_POST['api'] != 'checkuserpass') $nxml->send('FALSELOGININFO','OK');

$sid = session_id();
$adminid = $_SESSION['adminid'];


$functions_array = array('checkuserpass','logout','buys','buys_moreinfo','changepass');
$api = $_POST['api'];

if(!in_array($api,$functions_array)) $nxml->send('status','FUNCTION NOT FOUND');



	$pagenum = intval($_POST['pagenum']);
	
	$find = $sys->esc($_POST['find']);	
	$requeststatus = $sys->esc($_POST['requeststatus']);
	$filterstatus = $sys->esc($_POST['filterstatus']);
	$searchstatus = $sys->esc($_POST['searchstatus']);
	
	$fdate_d = intval($_POST['fdate_d']);	
	$fdate_m = intval($_POST['fdate_m']);	
	$fdate_y = intval($_POST['fdate_y']);	
	$tdate_d = intval($_POST['tdate_d']);	
	$tdate_m = intval($_POST['tdate_m']);	
	$tdate_y = intval($_POST['tdate_y']);
	
	if($tdate_d < 1) $tdate_d = 99;
	if($tdate_m < 1) $tdate_m = 99;
	if($tdate_y < 1) $tdate_y = 9999;

	$reqaction = $sys->esc($_POST['reqaction']);
	$reqpayid = $sys->esc($_POST['payid']);

	$payid = $sys->esc($_POST['payid']);
	$shopid = $sys->esc($_POST['shopid']);





require_once("pages/api/$api.php");

$nxml->run();

?>