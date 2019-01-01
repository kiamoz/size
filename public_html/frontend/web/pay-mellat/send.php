<?php
	
	$bank = $_POST['bank'];
	$cost = intval($_POST['cost']);
	
	$errmsg = false;
	$sendData = false;
	
	if($cost < 1) $errmsg = die("Message,مبلغ وارد شده نامعتبر است.");
		
		
	$data = array(
		'نام و نام خانوادگی' => $_POST['username'],
		'شماره تماس' => $_POST['tel'],
		'پست الکترونیکی' => $_POST['email'],
		'علت پرداخت' => $_POST['payfor'],
		'مبلغ واریزی' => $_POST['cost']
	);
		
		
	require_once('admin/php/sys.php');
	require_once('admin/php/banks/epay.php');
	
	$ob = new online_payment($sys->conn,$ENV_INFO['mysql_database']);
		
	$ob->setbank($bank,true);
	
	
	if($ob->pay('http://pay.inasrabadi.ir/verify.php',$cost,'',$data,$callbackdata,$errno)){
		$url = $callbackdata['url'];
		$method = $callbackdata['urlmethod'];
		$urldata = $callbackdata['urldata'];
		
		die("SendURL('$url','$method',$urldata);");
		
	}else{
		$msg = $ob->geterror($errno);
		die("Message,$msg");
	}
	
	
	

	
?>