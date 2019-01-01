<?php
if ($_POST['ResCode'] == '0') {
	//--پرداخت در بانک باموفقیت بوده
	include_once('lib/nusoap.php');
	$client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
	$namespace='http://interfaces.core.sw.bps.com/';
 
	$terminalId		= "3633310";					// Terminal ID
$userName		= "mkjnh2136";					// Username
$userPassword           = "36999615";					// Password
	$orderId 				= $_POST['SaleOrderId'];		// Order ID
	
	$verifySaleOrderId 		= $_POST['SaleOrderId'];
	$verifySaleReferenceId 	= $_POST['SaleReferenceId'];
			
	$parameters = array(
		'terminalId' => $terminalId,
		'userName' => $userName,
		'userPassword' => $userPassword,
		'orderId' => $orderId,
		'saleOrderId' => $verifySaleOrderId,
		'saleReferenceId' => $verifySaleReferenceId);
	// Call the SOAP method
	$result = $client->call('bpVerifyRequest', $parameters, $namespace);
	if($result == '0') {
		//-- وریفای به درستی انجام شد٬ درخواست واریز وجه
		// Call the SOAP method
		$result = $client->call('bpSettleRequest', $parameters, $namespace);
		if($result == '0') {
			//-- تمام مراحل پرداخت به درستی انجام شد.
			//-- آماده کردن خروجی
			echo 'The transaction was successful';
		} else {
			//-- در درخواست واریز وجه مشکل به وجود آمد. درخواست بازگشت وجه داده شود.
			$client->call('bpReversalRequest', $parameters, $namespace);			
			echo 'Error : '. $result;
		}
	} else {
		//-- وریفای به مشکل خورد٬ نمایش پیغام خطا و بازگشت زدن مبلغ
		$client->call('bpReversalRequest', $parameters, $namespace);
		echo 'Error : '. $result;
	}
} else {
	//-- پرداخت با خطا همراه بوده
	echo 'Error : '. $_POST['ResCode'];
}
?>