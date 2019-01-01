<?php
	
	
	require_once('buys_actions.php');
	
	//payid 	bank 	cost 	date 	orderid 	refid 	data_names 	data_values 	paystatus
	
	$searchsql = sprintf('(date >= %04d%02d%02d000000 AND date <= %04d%02d%02d999999)',$fdate_y,$fdate_m,$fdate_d,$tdate_y,$tdate_m,$tdate_d);
	
	if($find != '') $searchsql .= " AND data_values LIKE _utf8 '%$find%' ";

	$requeststatus_array = array(
		'all' => " AND paystatus IN ('done','payed') ",
		'done' => " AND paystatus = 'done' ",
		'payed' => " AND paystatus = 'payed' "
	);
	if($requeststatus_array[$requeststatus]) $searchsql .= $requeststatus_array[$requeststatus];

	$rowcount = "SELECT count(payid) FROM epay_info WHERE $searchsql";
	$rownum = $sys->pageno($rowcount,$rpp,$pagecount,$pagenum);
	
	$nxml->addtablebyarray('info',array(array($pagecount,$pagenum,$rowcount,$rpp)));
	
	//payid,bank,cost,date,orderid,refid,paystatus,data_names,data_values
	
	$result = mysql_query("SELECT payid,bank,cost,date,orderid,refid,paystatus,data_names,data_values FROM epay_info 
								WHERE $searchsql ORDER BY paystatus ASC,payid DESC LIMIT $rownum,$rpp",$sys->conn);
	
								
								
	$nxml->addtablebysql('table',$result);

	require_once('php/banks/epay.php');

	foreach($nxml->data['table'] as $index => $values){
		$data_names = $values[7];
		$data_values = $values[8];
		
		unset($values[7]);
		unset($values[8]);
		
		$data_array = online_payment::string2array($data_names,$data_values);
		$values[7] = $data_array['نام و نام خانوادگی'];
		$values[8] = $data_array['پست الکترونیکی'];
		$values[9] = $data_array['شماره تماس'];
		
		
		$nxml->data['table'][$index] = $values;
	}



?>