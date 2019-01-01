<?php
	
	
	switch($reqaction){

		case 'pay_settle':
		
				require_once('php/banks/epay.php');
				
				$ob = new online_payment($sys->conn,$ENV_INFO['mysql_database']);
				
				$result = $ob->settlebypayid($reqpayid,$errno);
				
				if($result){
					$nxml->adddata('result',"OK,فرآیند پرداخت کد <b>$reqpayid</b> با موفقیت تکمیل شد.");
				}else{
					$errormsg = $ob->geterror($errno);
					$nxml->adddata('result',"NO,فرآیند پرداخت کد <b>$reqpayid</b> با مشکل مواجه شد. $errormsg");
				}

			break;
	}
	
	
?>