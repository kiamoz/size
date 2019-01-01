<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<meta charset="utf-8">
<title>سیستم پرداخت وبسایت شخصی ایمان نصرآبادی</title>
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

<div id="main" style='width:400px'>
<div id="header" style='background:none;height:50px'></div>
<div id="content" class='c6'>
<div id='left' style='width:100%'>
<div class="post">
<span class="posttitle">پرداخت آنلاین با همکاری بانک ملت</span>

<div class='c5'>
<font face="Tahoma">
	
<script type="text/javascript" src="epay.js"></script>
</font>
<form method="post" action="#" id="paymentform_page45">


<table border="0" cellpadding="0" cellspacing="0" style="width:400px">
	<tbody>
		<tr><br>
			<td>نام و نام خانوادگی :
<br><br><input type='text' name='username' value=''/><br><br></td>
			<td>ایمیل : 
<br><br><input type='text' name='email' value='ایمیل بدون www می باشد' dir=rtl /><br><br></td>
		</tr>
		<tr>
			<td>شماره تلفن/موبایل :
<br><br><input type='text' name='tel' value='09' dir=ltr /><br><br></td>
			<td>مبلغ به ریال :
<br><br><input type='text' name='cost' value='' dir='ltr' /><br><br></td>
		</tr>

	</tbody>
</table>

توضیحات : 
<br><br><textarea cols=54 rows=4 name='payfor' value='payfor' ></textarea><br><br>

<input type='submit'  class='submit' value='ثبت'/><br>



</form>
<font face="Tahoma">
<script type="text/javascript">
	epay_jscript.pageroot='';

	epay_jscript.initpayform('paymentform_page45',{username:'every',payfor:'every',email:'mail',tel:'code'},function(frm){
		var err='';
		
		if(frm.username.value==''){err+='\nوارد کردن نام الزامی است.'}else if(!frm.username.inputreg.ok()) err+='\nنام وارد شده معتبر نمی باشد.';
		if(!frm.email.inputreg.ok()) err+='\nایمیل وارد شده معتبر نمی باشد. (می توانید این بخش را خالی رها کنید)';
		if(frm.tel.value==''){err+='\nوارد کردن شماره تماس الزامی است.'}else if(!frm.tel.inputreg.ok()) err+='\nشماره تماس وارد شده معتبر نمی باشد.';
		if(frm.payfor.value==''){err+='\nوارد کردن علت پرداخت الزامی است.'}else if(!frm.payfor.inputreg.ok()) err+='\nلطفا در وارد کردن علت پرداخت از حروف مجاز استفاده کنید.';
		
		if(err==''){
			return true;
		}else{
			epay_jscript.alert('خطاهای زیر رخ داده اند:'+err);
			return false;
		};		
	});
    
</script>
</font>
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