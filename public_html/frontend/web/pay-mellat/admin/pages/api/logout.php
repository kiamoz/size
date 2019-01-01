<?php

	foreach($_SESSION as $name => $value){
		$_SESSION[$name] = '';	
	}
	
	$result = session_destroy();
	$result = $sys->senv('admin_SID','LOGOUT');
	
	if(!$result) $nxml->send('status','NO');
	$nxml->send('status','OK');


?>