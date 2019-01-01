<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
  <meta charset="utf-8">
  <title>ساده پرداز میهن پال</title>
  <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
  <style type="text/css">
div.c7 {text-align: center}
  div.c6 {margin-top:8px;}
  .c5 {margin-top:-12px;margin-bottom:10px}
  a.c4 {display:inline-block}
  p.c3 {margin-top:-18px;margin-bottom:10px}
  div.c2 {clear:both}
  div.c1 {height:3px;width:100%;background:#DF5900;border-bottom:1px solid #B91A05}
  </style>
</head>
<body>
  <div class='c1'>
  </div>

  <div id="main" style='width:700px'>
    <div id="header" style='background:none;height:50px'></div>


    <div id="content" class='c6'>
      

      <div id='left' style='width:100%'>
     

        <div class="post">
          <span class="posttitle">بازگشت پرداخت</span>

        <div class='c5'>
<form method="post" action="?send">
	<table width="600" align="center" class="tbl" >
		<tr>
			<td class="right"><div id="show_payment_result">در حال دریافت اطلاعات پرداخت از بانک ...</div></td>
		</tr>
	</table>
</form>
<?php


	require_once('admin/php/sys.php');
	require_once('admin/php/banks/epay.php');
	
	$ob = new online_payment($sys->conn,$ENV_INFO['mysql_database']);
	
	$checkpage_result = $ob->checkpage($bank,$payid,$saleorderid,$refid,$cost,$data,$errno);
	
	$payment_is_ok = false;
	
	if($checkpage_result){
		if($ob->verifybypayid($payid,$errno)){
			$ob->settlebypayid($payid,$errno);
			$payment_is_ok = true;
			$msg = "پرداخت شما با موفقیت انجام شد . مبلغ $cost ریال طی تراکنش $refid از حساب شما کسر شد . در اسرع وقت به درخواست شما رسیدگی خواهد شد .";
		}else{
			$msg = $ob->geterror($errno);
		}
	}else{
		$msg = $ob->geterror($errno);
	}

	echo("<script language='javascript'>document.getElementById('show_payment_result').innerHTML='$msg';</script>");

if($payment_is_ok){
    ?>
    
<span id="sent">اطلاعات شما با موفقیت به دست ما رسید</span>
    
    <?php
    
}else{
	
    ?>
    
<span id="err">در فرآیند پرداخت خطایی رخ داده است</span>
    
    <?php
}
	
?>
        </div>
 </div>
       
      </div>

      <div class='c2'></div>
    </div>

   <br>

    <div class="c7">
       <a href=
"http://www.inasrabadi.ir">سیستم پرداخت وبسایت شخصی ایمان نصرآبادی</a> 
    </div><br>
    <br>
  </div>
</body>
</html>
