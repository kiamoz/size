<?php
	
	$olduser = $sys->esc($_POST['olduser']);
	$oldpass = $sys->esc($_POST['oldpass']);
	$newuser = $sys->esc($_POST['newuser']);
	$newpass = $sys->esc($_POST['newpass']);
	$npassre = $sys->esc($_POST['npassre']);

	if($sys->genv('admin_username') != md5($olduser) ||  $sys->genv('admin_password') != md5($oldpass)) $nxml->send('result','NO,نام کاربری و یا رمز عبور قدیمی نادرست است.');
	if($newpass != $npassre) $nxml->send('result','NO,نام کاربری جدید و قدیمی مطابقت ندارند.');
	
	$sys->senv('admin_username',md5($newuser));
	$sys->senv('admin_password',md5($newpass));
	
	$nxml->adddata('result','OK');
	
?>