<?php


/*
	programmer: Mahmood Reza Moradi Administrator Of ITfars.com	
	tel: 09303033990
	ITfars.com
	
*/


class online_payment{
	var $conn,$ob,$dbname,$table;
	var $banks,$bank,$bankname;
	var $localTime,$localDate,$DateTime,$elocalDate,$eDateTime;
	
	function online_payment($conn,$databasename){
		
		$this->conn = $conn;
		$this->dbname = $databasename;
		$this->table = "$databasename.epay_info";
			
				
		$this->banks = array(
			'mellat' => 'ملت'

		);
				
				
				
		$this->localTime = date('His');								// زمان سرور

		$this->localDate = date('Ymd');								// زمان سرور میلادی
		$this->DateTime = $this->localDate . $this->localTime;		// زمان سرور میلادی
		
		$date = split(',',date('Y,m,d'));
		$date = $this->cjdate($date[0],$date[1],$date[2]);
		$date = $date['Y'] . $date['m'] . $date['d'];
		
		$this->localDate = $date;									// زمان سرور شمسی
		$this->DateTime = $this->localDate . $this->localTime;		// زمان سرور شمسی
						
	}
	
	///// bank  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function setbank(&$bank,$usedef = false){
		
		if(!isset($this->banks[$bank])){
			if($usedef){
				foreach($this->banks as $ibank => $nbank){
					$bank = $ibank;
					break;
				}
			}else{
				$this->bank = '';
				return false;
			}
		}
		
		require_once("bank.$bank.php");
		eval('$this->ob = new online_payment_bank'.$bank.'($this);');
		$this->bank = $bank;
		$this->bankname = $this->banks[$bank];
		return true;
				
	}
	
	function error_report($type,$title,$file,$errrinfo){
		
	}
	
	function geterror($errno){
		
		switch($errno){
			
			case '9001':return 'سامانه قادر به ذخیره سازی اطلاعات پرداخت شما نمی باشد.';
			case '9002':return 'اطلاعات پرداخت شما در سامانه موجود نمی باشد و یا سامانه قادر به بازیابی آن ها نمی باشد.';
			case '9003':return 'بانک عامل یافت نشد.';
			case '9004':return 'در اطلاعات ارسال شده توسط بانک و اطلاعات موجود در سامانه سایت تناقض وجود دارد.';
			case '9005':return 'عملیات قبلا انجام شده است.';
			case '9006':return 'عملیات قبلا انجام شده است. لطفا مجدد تلاش ننمایید.';
			case '9007':return 'مبلغ وارد شده کمتر از مقدار مجاز می باشد. حداقل مبلغ مجاز 2000 ریال می باشد.';
			case '9008':return 'ترتیب مراحل پرداخت رعایت نشده است.';
			
			default:
				if(!$this->ob) return 'بانک مورد نظر یافت نشد';
				return $this->ob->geterror($errno);
		}
	}
	
	///// pay  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function pay($callBackUrl,$amount,$bankinfo,$data_array,&$callbackdata,&$errno){
		
		$amount = intval($amount);
		if($amount < 1){
			$errno = 9007;
			return false;
		}
		
		$data_string = $this->array2string($data_array);
		$data_names = str_replace('\'','\\\'',$data_string['name']);
		$data_values = str_replace('\'','\\\'',$data_string['value']);
				
		
		$answer = mysql_query("INSERT INTO $this->table (bank,cost,date,data_names,data_values,paystatus) 
									VALUES('$this->bank','$amount',$this->DateTime,'$data_names','$data_values','started')",$this->conn);
		$payid = mysql_insert_id($this->conn);
		
		if(!$answer){
			$errno = 9001;
			return false;
		}
		
		if($bankinfo == '') $bankinfo = "پرداخت با شماره $payid";
		
		$answer = $this->ob->pay($callBackUrl,$payid,$amount,$bankinfo,$orderid,$RefID,$url,$urldata,$urlsendmethod,$errno);
		if(!$answer) return false;
		
		$answer = mysql_query("UPDATE $this->table SET refid = '$RefID',orderid = '$orderid' WHERE payid = '$payid' LIMIT 1",$this->conn);
		if(!$answer){
			$errno = 9001;
			return false;
		}
		
		$callbackdata = array(
			'payid' => $payid,
			'orderid' => $orderid,
			'RefID' => $RefID,
			
			'url' => $url,
			'urldata' => $urldata,
			'urlmethod' => $urlsendmethod
		);
		
		return true;
	}
	
	
	///// checkpage  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function checkpage(&$bank,&$payid,&$saleorderid,&$SaleReferenceId,&$cost,&$data,&$errno){
		
		$payid = 0;
		
		if(isset($_REQUEST['payid'])){
			$payid = intval($_REQUEST['payid']);
		}else if(isset($_REQUEST['x_fp_sequence'])){
			$payid = intval($_REQUEST['x_fp_sequence']);
		}
		
		$reault = mysql_query("SELECT bank,cost,orderid,data_names,data_values,paystatus FROM $this->table WHERE payid = '$payid' LIMIT 1",$this->conn);
		if(!$reault){
			$errno = 9002;
			return false;
		}
		
		$reault = mysql_fetch_assoc($reault);
		if(!$reault){
			$errno = 9002;
			return false;
		}
		
		$data = $this->string2array($reault['data_names'],$reault['data_values']);
		
		$bank = $reault['bank'];
		$cost = $reault['cost'];
		$orderid = $reault['orderid'];
		$paystatus = $reault['paystatus'];
		
		if($paystatus != 'started'){
			$errno = 9005;
			return false;
		}
		
		if($bank != $this->bank && !$this->setbank($bank)){
			$errno = 9003;
			return false;
		}
		
		$answer = $this->ob->checkpage($saleorderid,$SaleReferenceId,$paycost,$errno);
		if(!$answer) return false;
		
		if($orderid != $saleorderid || $cost != $paycost){
			$errno = 9004;
			return false;
		}
		
		$answer = mysql_query("UPDATE $this->table SET refid = '$SaleReferenceId' WHERE payid = '$payid' LIMIT 1", $this->conn);

		if(!$answer){
			$errno = 9001;
			return false;
		}
				
		return true;
	}
	
	
	///// verify  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function verify($saleorderid,$SaleReferenceId,$cost,&$errno){
		return $this->ob->verify($saleorderid,$SaleReferenceId,$cost,$errno);
	}
	
	function verifybypayid($payid,&$errno){
		$reault = mysql_query("SELECT bank,cost,orderid,refid,paystatus FROM $this->table WHERE payid = '$payid' LIMIT 1",$this->conn);
		if(!$reault){
			$errno = 9001;
			return false;
		}
		
		$reault = mysql_fetch_assoc($reault);
		if(!$reault){
			$errno = 9001;
			return false;
		}
		
		$bank = $reault['bank'];
		$cost = $reault['cost'];
		$orderid = $reault['orderid'];
		$refid = $reault['refid'];
		$paystatus = $reault['paystatus'];
		
		if($bank != $this->bank && !$this->setbank($bank)){
			$errno = 9003;
			return false;
		}
		
		$answer = $this->verify($orderid,$refid,$cost,$errno);
		if(!$answer) return false;
		
		$answer = mysql_query("UPDATE $this->table SET paystatus = 'payed' WHERE payid = '$payid' LIMIT 1", $this->conn);
		if(!$answer){
			$errno = 9001;
			return false;
		}
		
		return true;
	}
	
	///// settle  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function settle($saleorderid,$SaleReferenceId,$cost,&$errno){
		return $this->ob->settle($saleorderid,$SaleReferenceId,$cost,$errno);
	}
	
	function settlebypayid($payid,&$errno){
		$reault = mysql_query("SELECT bank,cost,orderid,refid,paystatus FROM $this->table WHERE payid = '$payid' LIMIT 1",$this->conn);
		if(!$reault){
			$errno = 9001;
			return false;
		}
		
		$reault = mysql_fetch_assoc($reault);
		if(!$reault){
			$errno = 9001;
			return false;
		}
		
		$bank = $reault['bank'];
		$cost = $reault['cost'];
		$orderid = $reault['orderid'];
		$refid = $reault['refid'];
		$paystatus = $reault['paystatus'];
		
		if($paystatus != 'payed'){
			$errno = 9008;
			return false;
		}
		
		if($bank != $this->bank && !$this->setbank($bank)){
			$errno = 9003;
			return false;
		}
		
		$answer = $this->settle($orderid,$refid,$cost,$errno);
		if(!$answer) return false;
		
		$answer = mysql_query("UPDATE $this->table SET paystatus = 'done' WHERE payid = '$payid' LIMIT 1", $this->conn);
		if(!$answer){
			$errno = 9001;
			return false;
		}
		
		return true;
	}
	
	///// other function  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function inquiry($saleorderid,$SaleReferenceId,$cost,&$errno){
		return $this->ob->inquiry($saleorderid,$SaleReferenceId,$cost,$errno);
	}

	function reversal($saleorderid,$SaleReferenceId,$cost,&$errno){
		return $this->ob->inquiry($saleorderid,$SaleReferenceId,$cost,$errno);
	}
	
	
	///// offline function  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function checkpayoffline($payid,&$data,&$cost,&$refid,&$bankname,&$payrow,&$errno){
				
		$reault = mysql_query("SELECT * FROM $this->table WHERE payid = '$payid' LIMIT 1",$this->conn);
		if(!$reault){
			$errno = 9001;
			return false;
		}
		
		$reault = mysql_fetch_assoc($reault);
		if(!$reault){
			$errno = 9001;
			return false;
		}
				
		$bank = $reault['bank'];
		$paystatus = $reault['paystatus'];
		$cost = $reault['cost'];
		$refid = $reault['refid'];
		
		$data = $this->string2array($reault['data_names'],$reault['data_values']);
		$payrow = $reault;
		
		if($bank != $this->bank && !$this->setbank($bank)){
			$errno = 9003;
			return false;
		}
		
		if($paystatus != 'payed' && $paystatus != 'done') return false;
		
		$bankname = $this->bankname;
		
		if($errno != 0) return false;
		
		return true;

	}
	
	function updatepaymentdata($payid,$data_array){
		
		$data_string = $this->array2string($data_array);
		$data_names = str_replace('\'','\\\'',$data_string['name']);
		$data_values = str_replace('\'','\\\'',$data_string['value']);
		
		return mysql_query("UPDATE $this->table SET data_names = '$data_names',data_values = '$data_values' WHERE payid = '$payid' LIMIT 1", $this->conn) ? true : false;
		
	}





	
	///// array  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function _array2string_encode($string){
		return str_replace('[','\\4',str_replace(']','\\3',str_replace(',','\\2',str_replace('\\','\\1',$string))));
	}
	
	function array2string($array){
		if(is_object($array)) return array('name' => '','value' => 'OBJECT');
		if(!is_array($array)) return array('name' => '','value' => online_payment::_array2string_encode($array));
		foreach($array as $name => $value){
			$data = online_payment::array2string($value);
			$names .= ',' . online_payment::_array2string_encode($name) . $data['name'];
			$values .= ',' . $data['value'];
		}
		if($names != '') $names = substr($names,1);
		if($values != '') $values = substr($values,1);
		
		return array('name' => "[$names]",'value' => "[$values]");
	}

	function _array2string_split($names){
		$names = substr($names,1,strlen($names) - 2);
		$len = strlen($names);
		$break = 0;
		for($i=0;$i<$len;$i++){
			switch($names[$i]){
				case ',':
					if($break == 0) $names = substr($names,0,$i++) . '\',\'' . substr($names,$i++);
					$len += 2;
					break;
				case '\'':
					$names = substr($names,0,$i++) . '\\\'' . substr($names, $i);
					$len += 1;
					break;
				case '[': $break++; break;
				case ']': $break--; break;
			}
		}
		
		eval("\$names = array('$names');");
		
		return $names;
		
	}
	
	function _array2string_decode($string){
		return str_replace('\\1','\\',str_replace('\\2',',',str_replace('\\3',']',str_replace('\\4','[',$string))));
	}
	
	function string2array($names,$values){
		
		try{
			$namesa = online_payment::_array2string_split($names);
			$valuesa = online_payment::_array2string_split($values);
			
			$array = array();
			
			$count = count($namesa);
			for($i=0;$i<$count;$i++){
				$arstart = strpos($namesa[$i],'[',0);
				if($arstart === false){
					$array[online_payment::_array2string_decode($namesa[$i])] = online_payment::_array2string_decode($valuesa[$i]);
				}else{
					$namestr = substr($namesa[$i],0,$arstart);
					$namearraystr = substr($namesa[$i],$arstart);
					$array[online_payment::_array2string_decode($namestr)] = online_payment::string2array($namearraystr,$valuesa[$i]);
				}
			}
			
			return $array;
		}catch(Exception $error){
			return array();	
		}
	}
	
	
	///// Jdate  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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






}

?>