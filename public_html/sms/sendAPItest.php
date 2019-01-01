<?php

	include "sendAPI.class.php";
	
	$send = new sendAPI('havijori','66569104');
	
	$mobiles = array(
		'09123863215',
		'09127869842',
	);
	
	$body = '
آینده روشن است.
ورود به پیشخوان مجازی بانک آینده
۱۳۹۶/۰۷/۰۲
۱۰:۵۳-989123863215. <3';
	
	$result = $send->send($mobiles,$body);
        print_r($result);