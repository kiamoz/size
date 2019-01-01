<?php

/*
	programmer: Mahmood Reza Moradi Administrator Of ITfars.com	
	tel: 09303033990
	ITfars.com
	
*/

require_once('nusoap.php');

class online_payment_bankmellat{
	
	var $conn,$epay,$table,$nusoap_client,$namespace,$localDate,$localTime,$userip,$terminalId,$userName,$userPassword,$errormail,$siteurl,$sitename;
	
	function online_payment_bankmellat($epay){
		$this->epay = $epay;
		
		$this->conn = $epay->conn;
		$this->table = "$epay->dbname.logs_mellat";
		
		//$this->nusoap_client = new nusoap_client('https://pgwstest.bpm.bankmellat.ir/pgwchannel/services/pgw?wsdl');
		$this->nusoap_client = new nusoap_client('https://pgws.bpm.bankmellat.ir/pgwchannel/services/pgw?wsdl');
		$this->namespace = 'http://interfaces.core.sw.bps.com/';
		
		$this->localTime = $epay->localTime;		// زمان سرور
		$this->localDate = $epay->localDate;		// زمان سرور
						
		//	اطلاعات مربوط به دروازه پرداخت بانک ملت
		$this->terminalId = '11111';
		$this->userName = '1111';
		$this->userPassword = '1111';

	}
	
	function geterror($error_num){
		switch($error_num){
			//خطاهای بانک
			case '':return 'سرور بانک دچار مشکل می باشد.';
			case '41':return 'شماره درخواست تکراری است.';
			case '43':return 'عملیات قبلا انجام شده است.';
			case '17':return 'لغو عملیات پرداخت توسط کاربر صورت گرفته است.';
			case '415':return 'زمان شما برای انجام عملیات پرداخت به پایان رسیده است.';
			case '417':return 'شناسه پرداخت کننده نامعتبر است.';
			
			//
			case '11':return 'شماره كارت نامعتبر است.';
			case '12':return 'موجودي كافي نيست.';
			case '13':return 'رمز نادرست است.';
			case '14':return 'تعداد دفعات وارد كردن رمز بيش از حد مجاز است.';
			case '15':return 'كارت نامعتبر است.';
			case '16':return 'دفعات برداشت وجه بيش از حد مجاز است.';
			case '18':return 'تاريخ انقضاي كارت گذشته است.';
			case '19':return 'مبلغ برداشت وجه بيش از حد مجاز است.';
			case '111':return 'صادر كننده كارت نامعتبر است.';
			case '112':return 'خطاي سوييچ صادر كننده كارت.';
			case '113':return 'پاسخي از صادر كننده كارت دريافت نشد.';
			case '114':return 'دارنده كارت مجاز به انجام اين تراكنش نيست.';
			case '21':return 'پذيرنده نامعتبر است.';
			case '23':return 'خطاي امنيتي رخ داده است.';
			case '24':return 'اطلاعات كاربري پذيرنده نامعتبر است.';
			case '25':return 'مبلغ نامعتبر است.';
			case '31':return 'پاسخ نامعتبر است.';
			case '32':return 'فرمت اطلاعات وارد شده صحيح نمي باشد.';
			case '33':return 'حساب نامعتبر است.';
			case '34':return 'خطاي سيستمي.';
			case '35':return 'تاريخ نامعتبر است.';
			case '42':return 'خریدی با این شماره درخواست یافت نشد.';
			case '44':return 'کسر پول از حساب مشتری صورت نگرفته است.';
			case '45':return 'واریز پول قبلا انجام شده است.';
			case '46':return 'واریز پول به حساب پذیرنده انجام نشده است.';
			case '47':return 'واریز پول به حساب پذیرنده انجام نشده است.';
			case '48':return 'پول مشتری به حساب او بازگشت داده شده است.';
			case '49':return 'تراکنش استرداد وجه دلخواه یافت نشد.';
			case '412':return 'شناسه قبض نادرست است.';
			case '413':return 'شناسه پرداخت نادرست است.';
			case '414':return 'سازمان صادر كننده قبض نامعتبر است.';
			case '416':return 'در ثبت اطلاعات پرداخت شما در بانک ملت خطایی رخ داده است.';
			case '418':return 'در تعریف اطلاعات شما نزد بانک ملت خطایی پدید آمده است.';
			case '419':return 'تعداد دفعات ورود اطلاعات از حد مجاز گذشته است.';
			case '421':return 'IP نامعتبر است.';
			case '51':return 'تراکنش تکراری است.';
			case '54':return 'تراکنش مرجع موجود نیست.';
			case '55':return 'تراکنش نامعتبر است.';
			case '61':return 'خطا در واریز وجه.';


			//خطاهای کد
			case 1000:return '';	
			case 1001:return 'در ذخیره اطلاعات بانک ملت خطایی رخ داده است.';	
			case 1002:return 'در اتصال به بانک ملت خطایی رخ داده است.';	
			case 1003:return 'ورودی کمتر از مقدار مجاز می باشد.';	
			case 1004:return 'تراکنش صورت نگرفته است.';	
			case 1005:return 'تراکنش مورد نظر مربوط به این سرور نمی باشد.';	
			case 1006:return 'پرداخت شما با مشکل مواجه شد و پرداخت شما برگشت داده شد.';
			case 1007:return 'پرداخت شما با مشکل مواجه شد و اما عملیات برگشت پول با مشکل مواجه شد.';
			case 1008:return 'متاسفانه بانک پرداخت شما را تایید نکرد.';
			case 1009:return 'متاسفانه اطلاعات پرداخت شما در سیستم وجود ندارد یا سیستم قادر به بازیابی آن نمی باشد.';
			
			default:return 'شماره خطای اعلام شده توسط بانک: '.$error_num;
		}
	}
	
	function error_report($type,$title,$errrinfo){
		$this->epay->error_report($type,$title,'bank.mellat.php',$errrinfo);
	}
	
	function apicall($api,$parameters,&$orderid,&$answer){
		$answer ='';
		$orderid = 0;
		$amount = $parameters['amount']?$parameters['amount']:0;
				
		$sorderid = $parameters['saleOrderId']?$parameters['saleOrderId']:0;
		$refid = $parameters['saleReferenceId']?$parameters['saleReferenceId']:0;
		
		$apistring = substr(str_replace('Request','',$api),2);
		$parameters['terminalId'] = $this->terminalId;
		$parameters['userName'] = $this->userName;
		$parameters['userPassword'] = $this->userPassword;

		for($i=0;$i<2;$i++){
			$err = mysql_query("INSERT INTO $this->table (time,date,amount,sorderid,refid,function) 
										VALUES('$this->localTime','$this->localDate',$amount,'$sorderid','$refid','$apistring')",$this->conn);
			$orderid = mysql_insert_id($this->conn);
			$parameters['orderId'] = $orderid;
		
			if(!$err){
				$this->error_report('MySQL 1001','خطا در ایجاد ردیف جدید',mysql_error($this->conn));
				return 1001;
			}
			
			if($err = $this->nusoap_client->getError()){
				$this->error_report('SOAP 1002','ناتوانی در اتصال به بانک ملت',$err);
				return 1002;
			}
			
			$de ='';
			
			$result = $this->nusoap_client->call($api,$parameters,$this->namespace);
			
			if($this->nusoap_client->fault){
				$this->error_report('SOAP 1002/A','فراخوانی تابع بانک ملت با مشکل مواجه شده است',$this->nusoap_client->fault . '\n' . $this->nusoap_client->faultstring);
				return 1002;
			}
			
			if(strpos('Text: ' . $result,',') > 0){
				$result = @explode(',',$result);
			}else{
				$result = array($result,'');
			}
			
			$err = $result[0];
			mysql_query("UPDATE $this->table SET err = '$err' WHERE orderid = '$orderid' LIMIT 1", $this->conn);
			
			if($err != '41') break;
		}
		
		$answer = $result[1];
		return $err;
		
	}
	
	
	
	function pay($callBackUrl,$payid,$amount,$additionalData,&$orderid,&$RefID,&$url,&$urldata,&$urlsendmethod,&$error){
		
		$url = 'https://pgw.bpm.bankmellat.ir/pgwchannel/startpay.mellat';
		$urlsendmethod = 'POST';
		
		
		$error = 0;
		$amount = intval($amount);
		if($amount < 1){
			$error = 1003;
			return false;
		}
		
		$callBackUrl = $callBackUrl . (strpos($callBackUrl,'?') === false ? "?payid=$payid" : "&payid=$payid");
	
		$parameters = array(
			'amount' => $amount,
			'localDate' => $this->localDate,
			'localTime' => $this->localTime,
			'additionalData' => $additionalData,
			'callBackUrl' => $callBackUrl,
			'payerId' => 0
		);
		
		for($i = 0;$i < 2;$i++){
			$error = $this->apicall('bpPayRequest',$parameters,$orderid,$RefID);
			if($error != '0') break;
			if(strlen($RefID) > 5){
				$error = 0;
				break;
			}else{
				$error = 1002;
			}			
		}
		
		$urldata = "{RefId:'$RefID'}";
		
		if($error == '0') mysql_query("UPDATE $this->table SET refid = '$RefID' WHERE orderid = '$orderid' LIMIT 1", $this->conn);
		
		
		return ($error == '0');

	}

	
	function checkpage(&$saleorderid,&$SaleReferenceId,&$cost,&$error){
		$error = 0;
		$RefId = addslashes(mysql_escape_string($_POST['RefId']));
		$ResCode = addslashes(mysql_escape_string($_POST['ResCode']));
		$saleorderid = addslashes(mysql_escape_string($_POST['SaleOrderId']));		//	orderid مرحله ی قیل
		$SaleReferenceId = addslashes(mysql_escape_string($_POST['SaleReferenceId']));		// شماره تراکنش
		
		if($ResCode != 0){
			$error = $ResCode;	
			return false;
		}
		
		if(!$SaleReferenceId){
			$error = 1004;
			return false;
		}
		
		$reault = mysql_query("SELECT amount FROM $this->table WHERE orderid = '$saleorderid' LIMIT 1",$this->conn);
		if(!$reault){
			$error = 1009;
			return false;
		}
		$reault = mysql_fetch_assoc($reault);
		$cost = intval($reault['amount']);
		
		return true;
	}
																																 
	function verify($saleorderid,$SaleReferenceId,$cost,&$error){
		
		$error = 0;

		$parameters = array(
			'saleOrderId' => $saleorderid,
			'saleReferenceId' => $SaleReferenceId
		);
			
		$error = $this->apicall('bpVerifyRequest',$parameters,$orderid,$answer);
		
		return ($error == '0');
	}

	function settle($saleorderid,$SaleReferenceId,$cost,&$error){
		
		$error = 0;
			
		$parameters = array(
			'saleOrderId' => $saleorderid,
			'saleReferenceId' => $SaleReferenceId
		);

		$error = $this->apicall('bpSettleRequest',$parameters,$orderid,$answer);
		
		return ($error == '0');
	
	}
	
	function inquiry($saleorderid,$SaleReferenceId,$cost,&$error){
		
		$error = 0;
	
		$parameters = array(
			'saleOrderId' => $saleorderid,
			'saleReferenceId' => $SaleReferenceId
		);

		$error = $this->apicall('bpInquiryRequest',$parameters,$orderid,$answer);
		
		return ($error == '0');
	
	}

	function reversal($saleorderid,$SaleReferenceId,$cost,&$error){
		
		$error = 0;
			
		$parameters = array(
			'saleOrderId' => $saleorderid,
			'saleReferenceId' => $SaleReferenceId
		);

		$error = $this->apicall('bpReversalRequest',$parameters,$orderid,$answer);
		
		return ($error == '0');
	
	}

}

?>