<?php
require_once ("./php/config.php");
connect2();

function bpVerifyRequest($terminal_id = terminal_id, $user = terminal_user_name,
    $pass = terminal_password)
{
    if(sha1(salt.$_POST["SaleOrderId"].salt)!=$_GET["aum"]) return 1203;
    
    $namespace = 'http://interfaces.core.sw.bps.com/';
    $client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
    
	// Check for an error
	$err = $client->getError();
	if ($err) {
		echo '<h2>خطای اتصال به بانک: </h2>';//<pre>' . $err . '</pre>';
		die();
	}
    
    $RefId = $_POST["RefId"]; //1
    $orderId = $_POST["SaleOrderId"];//2
    $saleOrderId = $_POST["SaleOrderId"]; //2
    $saleReferenceId = $_POST["SaleReferenceId"]; //3
    $ResCode = $_POST["ResCode"]; //4
    //save
    $sql = "SELECT * FROM downloader WHERE token='" . $RefId . "' ";
    $result2 = mysql_query($sql);

    if ($result2 && mysql_num_rows($result2) == 0)
        return 1201;
    if ($ResCode != 0)
        return $ResCode;
    if ($result2 && mysql_num_rows($result2) > 0) {
        $cath = mysql_fetch_array($result2);
        if ($cath["sts"] == "1") {
            return 1205;
        }
    }

    $sql2 = "UPDATE downloader SET ercod='".$ResCode."',refid='" . $saleReferenceId . "',modified='" .
        date(date_format) . "' where token='" . $RefId . "' ";
    $saving = mysql_query($sql2);
    if (!$saving)
        return 1200;
    //end save
    $parameters = array(
        'terminalId' => $terminal_id,
        'userName' => $user,
        'userPassword' => $pass,
        'orderId' => $orderId,
        'saleOrderId' => $saleOrderId,
        'saleReferenceId' => $saleReferenceId,
        );
    $result = $client->call('bpVerifyRequest', $parameters, $namespace);
 
 		// Check for a fault
		if ($client->fault) {
			echo '<h2>مشکل در ارتباط با بانک...</h2><pre>';
			//print_r($result);
			echo '</pre>';
			die();
		} 
		else {
    			$resultStr = $result;
    			
    			$err = $client->getError();
    			if ($err) {
    				// Display the error
    				echo '<h2>خطای ارتباط با بانک...</h2>';//<pre>' . $err . '</pre>';
    				die();
    			} 
    			else {   
                        // Display the result
                        if ($result == 0) 
                        {
                            $sql2 = "UPDATE downloader SET sts='1',modified='" . date(date_format) .
                                "' where token='" . $RefId . "' ";
                            $saving = mysql_query($sql2);
                        
                            if (!$saving) {
                                return 1200;
                            }
                            return $result;
                        } else {
                        
                            $result = bpInquiryRequest($RefId); //estelam
                            return $result;
                        }
    	            }// end Display the result
	   	    }// end Check for errors
}
function bpSettleRequest($RefId, $terminal_id = terminal_id, $user =
    terminal_user_name, $pass = terminal_password)
{
    $namespace = 'http://interfaces.core.sw.bps.com/';
    $client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');

	// Check for an error
	$err = $client->getError();
	if ($err) {
		echo '<h2>خطای اتصال به بانک: </h2>';//<pre>' . $err . '</pre>';
		die();
	}
    
    $sql = "SELECT * FROM downloader WHERE token='" . $RefId . "' ";
    $result2 = mysql_query($sql);

    if (!$result2 || mysql_num_rows($result2) == 0)
        return 1201;
    if ($result2 && mysql_num_rows($result2) > 0) {
        $cath = mysql_fetch_array($result2);
        $orderId = $cath["id"];
        $saleOrderId = $cath["id"];
        $saleReferenceId = $cath["refid"];
    }

    $parameters = array(
        'terminalId' => $terminal_id,
        'userName' => $user,
        'userPassword' => $pass,
        'orderId' => $orderId,
        'saleOrderId' => $saleOrderId,
        'saleReferenceId' => $saleReferenceId,
        );
    $result = $client->call('bpSettleRequest', $parameters, $namespace);

 		// Check for a fault
		if ($client->fault) {
			echo '<h2>مشکل در ارتباط با بانک...</h2><pre>';
			//print_r($result);
			echo '</pre>';
			die();
		} 
		else {
    			$resultStr = $result;
    			
    			$err = $client->getError();
    			if ($err) {
    				// Display the error
    				echo '<h2>خطای ارتباط با بانک...</h2>';//<pre>' . $err . '</pre>';
    				die();
    			} 
    			else {   
                      // Display the result
                        if ($result == 0 || ($cath["sts"] != "1" && $result == 45)) 
                        {
                            $sql2 = "UPDATE downloader SET sts='2',modified='" . date(date_format) .
                                "' where token='" . $RefId . "' ";
                            $saving = mysql_query($sql2);
                    
                            if (!$saving) {
                                return 1200;
                            }
                            return $result;
                        }
                        return $result;
       	            }// end Display the result
	   	    }// end Check for errors            
}
function bpInquiryRequest($RefId, $terminal_id = terminal_id, $user =
    terminal_user_name, $pass = terminal_password)
{
    $namespace = 'http://interfaces.core.sw.bps.com/';
    $client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');

	// Check for an error
	$err = $client->getError();
	if ($err) {
		echo '<h2>خطای اتصال به بانک: </h2>';//<pre>' . $err . '</pre>';
		die();
	}

    $sql = "SELECT * FROM downloader WHERE token='" . $RefId . "' ";
    $result2 = mysql_query($sql);

    if (!$result2 || mysql_num_rows($result2) == 0)
        return 1201;
    if ($result2 && mysql_num_rows($result2) > 0) {
        $cath = mysql_fetch_array($result2);
        $orderId = $cath["id"];
        $saleOrderId = $cath["id"];
        $saleReferenceId = $cath["refid"];
    }
    $parameters = array(
        'terminalId' => $terminal_id,
        'userName' => $user,
        'userPassword' => $pass,
        'orderId' => $orderId,
        'saleOrderId' => $saleOrderId,
        'saleReferenceId' => $saleReferenceId,
        );
    $result = $client->call('bpInquiryRequest', $parameters, $namespace);
    
		// Check for a fault
		if ($client->fault) {
			echo '<h2>مشکل در ارتباط با بانک...</h2><pre>';
			//print_r($result);
			echo '</pre>';
			die();
		} 
		else {
    			$resultStr = $result;
    			
    			$err = $client->getError();
    			if ($err) {
    				// Display the error
    				echo '<h2>خطای ارتباط با بانک...</h2>';//<pre>' . $err . '</pre>';
    				die();
    			} 
    			else {   
                      // Display the result
    
                        
                        if ($result == 0) {
                            $sql2 = "UPDATE downloader SET sts='1',modified='" . date(date_format) .
                                "' where token='" . $RefId . "' ";
                            $saving = mysql_query($sql2);
                    
                            if (!$saving) {
                                return 1200;
                            }
                        }
                        return $result;
       	             }// end Display the result
	   	    }// end Check for errors
}
function bpReversalRequest($RefId, $terminal_id = terminal_id, $user =
    terminal_user_name, $pass = terminal_password)
{
    $namespace = 'http://interfaces.core.sw.bps.com/';
    $client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');

	// Check for an error
	$err = $client->getError();
	if ($err) {
		echo '<h2>خطای اتصال به بانک: </h2>';//<pre>' . $err . '</pre>';
		die();
	}
    
    $sql = "SELECT * FROM downloader WHERE token='" . $RefId . "' ";
    $result2 = mysql_query($sql);

    if (!$result2 || mysql_num_rows($result2) == 0)
        return 1201;
    if ($result2 && mysql_num_rows($result2) > 0) {
        $cath = mysql_fetch_array($result2);
        $orderId = $cath["id"];
        $saleOrderId = $cath["id"];
        $saleReferenceId = $cath["refid"];
    }
    $parameters = array(
        'terminalId' => $terminal_id,
        'userName' => $user,
        'userPassword' => $pass,
        'orderId' => $orderId,
        'saleOrderId' => $saleOrderId,
        'saleReferenceId' => $saleReferenceId,
        );
    $result = $client->call('bpReversalRequest', $parameters, $namespace);

		// Check for a fault
		if ($client->fault) {
			echo '<h2>مشکل در ارتباط با بانک...</h2><pre>';
			//print_r($result);
			echo '</pre>';
			die();
		} 
		else {
    			$resultStr = $result;
    			
    			$err = $client->getError();
    			if ($err) {
    				// Display the error
    				echo '<h2>خطای ارتباط با بانک...</h2>';//<pre>' . $err . '</pre>';
    				die();
    			} 
    			else {   
                      // Display the result    
                         return $result;
    
                     }// end Display the result
	   	    }// end Check for errors
}
function epay_errors($error_code)
{
    //print_r($error_code);
    $error_code = trim($error_code);
    $arr = array();
    $arr[0] = "تراكنش با موفقيت انجام شد";
    $arr[3] = "عملیات پرداخت شروع نشده است";
    $arr[11] = "شماره كارت نامعتبر است";
    $arr[12] = "موجودي كافي نيست";
    $arr[13] = "رمز نادرست است";
    $arr[14] = "تعداد دفعات وارد كردن رمز بيش از حد مجاز است";
    $arr[15] = "كارت نامعتبر است";
    $arr[16] = "دفعات برداشت وجه بيش از حد مجاز است";
    $arr[17] = "كاربر از انجام تراكنش منصرف شده است";
    $arr[18] = "تاريخ انقضاي كارت گذشته است";
    $arr[19] = "مبلغ برداشت وجه بيش از حد مجاز است";
    $arr[111] = "صادر كننده كارت نامعتبر است";
    $arr[112] = "خطاي سوييچ صادر كننده كارت";
    $arr[113] = "پاسخي از صادر كننده كارت دريافت نشد";
    $arr[114] = "دارنده كارت مجاز به انجام اين تراكنش نيست";
    $arr[21] = "پذيرنده نامعتبر است";
    $arr[23] = "خطاي امنيتي رخ داده است";
    $arr[24] = "اطلاعات كاربري پذيرنده نامعتبر است";
    $arr[25] = "مبلغ نامعتبر است";
    $arr[31] = "پاسخ نامعتبر است";
    $arr[32] = "فرمت اطلاعات وارد شده صحيح نمي باشد";
    $arr[33] = "حساب نامعتبر است";
    $arr[34] = "خطاي سيستمي";
    $arr[35] = "تاريخ نامعتبر است";
    $arr[41] = "شماره درخواست تكراري است";
    $arr[42] = "يافت نشد  Sale تراكنش";
    $arr[43] = "داده شده است Verify قبلا درخواست";
    $arr[44] = "يافت نشد Verfiy درخواست";
    $arr[45] = "شده است Settle تراكنش";
    $arr[46] = "نشده است  Settle تراكنش";
    $arr[47] = "يافت نشد  Settle تراكنش";
    $arr[48] = "شده است  Reverse تراكنش";
    $arr[49] = "يافت نشد Refund تراكنش";
    $arr[412] = "شناسه قبض نادرست است";
    $arr[413] = "شناسه پرداخت نادرست است";
    $arr[414] = "سازمان صادر كننده قبض نامعتبر است";
    $arr[415] = "زمان جلسه كاري به پايان رسيده است";
    $arr[416] = "خطا در ثبت اطلاعات";
    $arr[417] = "شناسه پرداخت كننده نامعتبر است";
    $arr[418] = "اشكال در تعريف اطلاعات مشتري";
    $arr[419] = "تعداد دفعات ورود اطلاعات از حد مجاز گذشته است";
    $arr[421] = "نامعتبر است  IP";
    $arr[51] = "تراكنش تكراري است";
    $arr[54] = "تراكنش مرجع موجود نيست";
    $arr[55] = "تراكنش نامعتبر است";
    $arr[61] = "خطا در واريز";
    $arr[1200] = "سایت دچار مشکل شده است";
    $arr[1201] = "فاکتور يافت نشد";
    $arr[1203] = "آدرس صفحه نا معتبر است";
    $arr[1205] = "اين تراکنش قبلا بررسي شده است";

    if (array_key_exists($error_code, $arr))
        return $arr[$error_code]; //. "(" . $error_code . ")";
    else
        if (!is_array($error_code))
            return "کد خطا نا معتبر است" . ": " . $error_code;
        else
            return $error_code;
}

function check_setle($id)
{
    $sql = "SELECT * FROM downloader WHERE gateway='ML' and id='".$id."' ";
    $result2 = mysql_query($sql);

    $t = 0;
    if ($result2 && mysql_num_rows($result2) > 0) 
    {
        $cath = mysql_fetch_array($result2);
        $token=$cath["token"];

        $t =bpInquiryRequest($token);

        if ($t == 0) {
            $settle = bpSettleRequest($token);
            
            if($settle == 0 || $settle== 45)
            {                 
                $sql2 = "UPDATE downloader SET ercod='0',sts='2',modified='" . date(date_format) .
                    "' where id='" . $id . "' ";
                $saving = mysql_query($sql2);  
                
                if( $settle== 45 )
                  echo 'تراکنش شماره '.$id.'  قبلا ستل شده است';
                else
                  echo 'تراکنش شماره '.$id.' با موفقیت ستل شد.';
            }
            else
            {
                $sql2 = "UPDATE downloader SET ercod='46',sts='1',modified='" . date(date_format) .
                    "' where id='" . $id . "' ";
                $saving = mysql_query($sql2); 
                
                echo $settle.'</br>';
                echo 'تراکنش شماره '.$id.' ستل نشد.';
            }
        }
        else
        {
            $sql2 = "UPDATE downloader SET ercod='44',sts='3',modified='" . date(date_format) .
                "' where id='" . $id . "' ";
            $saving = mysql_query($sql2);            
            
            echo $t.'</br>';
            echo 'برای تراکنش شماره '.$id.' تایید پرداختی ارسال نشده است';

            
        }

    }
    else
    {
        echo 'چنین سفارشی یافت نشد';
    }
}
?>