<?php


	$adminlogin = $_SESSION['adminlogin'] == session_id();
	$checksession = $_POST['_checksession'] == 1;
	$adminusername = md5($_POST['_username']);
	$password = md5($_POST['_password']);
	
	if($checksession){
		$adminlogin = $_SESSION['adminlogin'] == session_id();
		if(!$adminlogin) $nxml->send('status','NSESSION');
	}else{
		
		$adminlogin = $sys->genv('admin_username') == $adminusername && $sys->genv('admin_password') == $password;
		if(!$adminlogin) $nxml->send('status','NO');
		
		$info['id'] = 'admin';
		$adminid = $info['id'];
		$_SESSION['adminlogin'] = session_id();
		$_SESSION['adminid'] = $info['id'];
		
		
		$lastlogin = $sys->genv('admin_lastlogin');
		$lastlogin = substr($lastlogin,0,4) . ',' . substr($lastlogin,4,2) . ',' . substr($lastlogin,6,2);
		
		$lastlogin = '00,00,00';
		
		$_SESSION['adminlastlogin'] = $lastlogin;
		
		$sys->senv('admin_SID',$_SESSION['adminlogin']);
		$sys->senv('admin_lastlogin',$sys->jdate['YmdHis']);
		
		$login_ips = $sys->genv('admin_ips');
		$login_ips = $login_ips == '' ? array() : explode(',',$login_ips);
		$login_ips_count = count($login_ips);
		
		if($login_ips_count < 1){
			$login_ips = array($sys->ip);
		}elseif($login_ips_count < 4){
			$login_ips[] = $sys->ip;
		}else{
			unset($login_ips[0]);
			$login_ips[] = $sys->ip;
		}
		
		$sys->senv('admin_ips',implode(',',$login_ips));
		
	}
	
	$nxml->adddata('status','OK');
	
	
	$nxml->adddata('date',$_SESSION['adminlastlogin']);
	

?>