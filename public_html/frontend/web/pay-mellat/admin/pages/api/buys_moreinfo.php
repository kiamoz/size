<?php
	
	require_once('buys_actions.php');
	
	
	
	$result = mysql_query("SELECT payid,bank,cost,date,orderid,refid,paystatus,data_names,data_values
									FROM epay_info WHERE payid = '$payid' LIMIT 1",$sys->conn);
	$nxml->addtablebysql('table',$result);
	
	require_once('php/banks/epay.php');
	
	function make_javascript_obj($array){
		if(!is_array($array)) return '\'' . str_replace('\'','\\\'',str_replace("\n",'\\n',str_replace("\r",'\\r',str_replace('\n','\\n',str_replace('\r','\\r',str_replace('\\','\\\\',$array)))))) . '\'';
		
		$str = '';
		
		foreach($array as $name => $value){
			$str .= ',' . make_javascript_obj($name) . ':' . make_javascript_obj($value);
		}
		
		if($str) $str = substr($str,1);
		return ('{' . $str . '}');
	}
	
	foreach($nxml->data['table'] as $index => $values){
		$data_names = $values[7];
		$data_values = $values[8];
		
		unset($values[7]);
		unset($values[8]);

		$data_array = online_payment::string2array($data_names,$data_values);
		$values[7] = make_javascript_obj($data_array);
		

		$nxml->data['table'][$index] = $values;
	}
	

?>