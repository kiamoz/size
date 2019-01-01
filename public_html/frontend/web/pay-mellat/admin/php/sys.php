<?php

//error_reporting(0);

require_once('config.php');
require_once('newXML.php');

class sitesystem{
	var $conn,$jdate;
	
	function sitesystem(){
		global $ENV_INFO;
				
		$this->conn = mysql_connect($ENV_INFO['mysql_host'],$ENV_INFO['mysql_username'],$ENV_INFO['mysql_password']);
		mysql_select_db($ENV_INFO['mysql_database'],$this->conn);
		mysql_query("SET CHARACTER SET 'utf8'", $this->conn);
		
		date_default_timezone_set('Asia/Tehran');
		
		$this->ip = ($_SERVER['X_FORWARDED_FOR']) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
		
		$date = split(',',date('Y,m,d'));
		$date = $this->cjdate($date[0],$date[1],$date[2]);
		$date['t'] = date('His');
		$date = array(
			'Y' => $date['Y'],
			'm' => $date['m'],
			'd' => $date['d'],
			't' => $date['t'],
			'Ymd' => $date['Y'] . $date['m'] . $date['d'],
			'His' => $date['t'],
			'YmdHis' => $date['Y'] . $date['m'] . $date['d'] . $date['t']
		);
		$this->jdate = $date;
		
	}
	
	function esc($text){
		return mysql_escape_string($text);
	}
	
	function bytesToSize($bytes) {
		 $sizes = array('Bytes','KB','MB','GB','TB');
		 if ($bytes == 0) return '0 Byte';
		 $i = floor(floor(log($bytes) / log(1024)));
		 return (round($bytes / (1024 ^ $i),2) . ' ' . $sizes[$i]);
	}

	
	function genv($name){
		$name = $this->esc($name);
		$result = mysql_query("SELECT env_sys.value FROM env_sys WHERE env_sys.name = '$name' LIMIT 1",$this->conn);
		if(!$result) return false;
		$result = mysql_fetch_assoc($result);
		return $result['value'];
	}
	
	function senv($name,$value){
		$name = $this->esc($name);
		$value = $this->esc($value);
		$result = mysql_query("UPDATE env_sys SET env_sys.value = '$value' WHERE env_sys.name = '$name' LIMIT 1",$this->conn);
		return $result ? true : false;
	}	
	
	function pageno($rowcount,&$rpp,&$pagecount,&$pagenum){
		if(!is_numeric($rowcount)){
			$result = mysql_query($rowcount,$this->conn);
			$result = @mysql_fetch_assoc($result);
			foreach($result as $rowcount) if(is_numeric($rowcount)) break;
			$rowcount = intval($rowcount);
		}
		if(intval($rpp) < 1) $rpp = 10;
		$pagecount = floor(($rowcount - 1) / $rpp) + 1;
		if($pagenum < 1) $pagenum = 1;
		if($pagenum > $pagecount) $pagenum = $pagecount;
		$rownum = ($pagenum - 1) * $rpp;
		if($rownum < 0) $rownum = 0;
		return $rownum;
	}
	
	function mailHTML($mail,$title,$from,$body){
		return @mail($mail,$title,
			'<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>'.$title.'</title>
			</head>
			<body>
				<div style="border:1px solid #CCC;margin:10px;padding:15px 20px 20px 20px;font-family:Tahoma, Arial, '. 
					'Geneva, sans-serif;font-size:12px;line-height:20px;direction:rtl;text-align:justify;">
				'.nl2br($body).
				'</div>
			</body>
			</html>'
	
			,"From: $from\r\nReply-To: $from\r\nContent-type: text/html\r\n");
	}
	
	
	function jdate($format){
		$date = (func_num_args()>1)?date('Y,m,d',func_get_arg(1)):date('Y,m,d');
		list($Y,$m,$d) = explode(',',$date);
		
		$jdate = $this->cjdate($Y,$m,$d);
		$jY = $jdate['Y'];
		$jm = $jdate['m'];
		$jd = $jdate['d'];
		
		$format = str_replace('Y',$jY,$format);
		$format = str_replace('m',$jm,$format);
		$format = str_replace('d',$jd,$format);
		
		return (func_num_args()>1)?date($format,func_get_arg(1)):date($format);
	}
	
	function cjdate_div($a,$b){
		return (int)($a / $b);
	}
	function cjdate($g_y,$g_m,$g_d){ //تبدیل تاریخ میلادی به شمسی
	
		$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
		$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);     
	
	   $gy = $g_y-1600;
	   $gm = $g_m-1; 
	   $gd = $g_d-1; 
	
	   $g_day_no = 365*$gy+$this->cjdate_div($gy+3,4)-$this->cjdate_div($gy+99,100)+$this->cjdate_div($gy+399,400); 
	
	   for ($i=0; $i < $gm; ++$i) $g_day_no += $g_days_in_month[$i]; 
	
	   if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0))) $g_day_no++; 
	
	   $g_day_no += $gd; 
	   $j_day_no = $g_day_no-79; 
	   $j_np = $this->cjdate_div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */ 
	   $j_day_no = $j_day_no % 12053; 
	   $jy = 979+33*$j_np+4*$this->cjdate_div($j_day_no,1461); /* 1461 = 365*4 + 4/4 */ 
	   $j_day_no %= 1461;
	   
	   if ($j_day_no >= 366) { 
		  $jy += $this->cjdate_div($j_day_no-1, 365); 
		  $j_day_no = ($j_day_no-1)%365; 
	   } 
	
	
	   for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i)  $j_day_no -= $j_days_in_month[$i]; 
	
	   $jm = $i+1; 
	   $jd = $j_day_no+1; 
	
	   return array(
			'Y' => sprintf('%04d',$jy),
			'm' => sprintf('%02d',$jm),
			'd' => sprintf('%02d',$jd)
		); 
	}
	
	function encode($text){ 
		$txtlen = strlen($text);
		$en = '';
		for($i = 0;$i < $txtlen;$i++){
			$ord = ord(substr($text,$i,1));
			$en .= chr(255 - $ord);
		}
		return base64_encode($en);
	} 

	function decode($text){ 
		$text = base64_decode($text);
		$txtlen = strlen($text);
		$en = '';
		for($i = 0;$i < $txtlen;$i++){
			$ord = ord(substr($text,$i,1));
			$en .= chr(255 - $ord);
		}
		return $en;
	} 
	
	function error_report($type,$title,$page,$errrinfo){
		
	}
	
}

$sys = new sitesystem();
$GLOBALS['sys'] = $sys;

define('REG_MAIL','/^[a-zA-Z0-9_\.-]+@[a-zA-Z0-9_\.-]+\.[a-zA-Z0-9]+$/');



?>